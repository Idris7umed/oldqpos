
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_hold_model extends CI_Model
{
    private $table = 'tbl_holds';
    private $table_details = 'tbl_holds_details';
    private $table_modifiers = 'tbl_holds_details_modifiers';

     public function get_all($outlet_id, $user_id) 
    {
        $this->db->select('h.id, h.hold_no, h.total_payable, c.name as customer_name, t.name as table_name, u.full_name as waiter_name');
        $this->db->from($this->table . ' h');
        $this->db->join('tbl_customers c', 'c.id = h.customer_id', 'left');
        $this->db->join('tbl_tables t', 't.id = h.table_id', 'left');
        $this->db->join('tbl_users u', 'u.id = h.waiter_id', 'left');
        $this->db->where('h.outlet_id', $outlet_id);
        $this->db->where('h.user_id', $user_id); 
        $this->db->where('h.del_status', 'Live');
        $this->db->order_by('h.id', 'DESC');
        return $this->db->get()->result();
    }

     public function get_by_id($id, $outlet_id)
    {
        
        
        $this->db->select('*, 
            vat as tax, 
            delivery_charge_actual_charge as charge, 
            tips_amount_actual_charge as tips,
            total_discount_amount as total_discount
        ');
        $hold = $this->db->get_where($this->table, ['id' => $id, 'outlet_id' => $outlet_id, 'del_status' => 'Live'])->row();
        

        if ($hold) {
            $hold->items = $this->db
                ->select('hd.*, fm.name as menu_name')
                ->from($this->table_details . ' hd')
                ->join('tbl_food_menus fm', 'fm.id = hd.food_menu_id', 'left')
                ->where('hd.holds_id', $id)
                ->where('hd.del_status', 'Live')
                ->get()
                ->result();
            foreach ($hold->items as $item) {
                
                $item_details_from_db = $this->db->get_where($this->table_details, ['id' => $item->id])->row();
                $item->discount = $item_details_from_db->discount_amount ?? 0.00;
                
                $item->modifiers = $this->db->get_where($this->table_modifiers, ['holds_details_id' => $item->id])->result();
            }
        }
        return $hold;
    }

    public function create_or_update($data, $id = null)
    {
        $this->load->model('api_sale_model'); 
        
        $this->db->trans_start();

        
        $totals = $this->api_sale_model->_calculate_totals($data); 
        if (!$totals['success']) {
            $this->db->trans_rollback();
            return ['status' => false, 'message' => $totals['message']];
        }
        
        $hold_data = [
            'customer_id' => $data['customer_id'],
            'waiter_id' => $data['waiter_id'],
            'outlet_id' => $data['outlet_id'],
            'order_type' => $data['order_type'],
            'table_id' => $data['table_id'] ?? null,
            'sub_total' => $totals['sub_total'],
            'total_discount_amount' => $totals['total_discount'],
            'vat' => $totals['total_vat'],
            'delivery_charge_actual_charge' => $totals['delivery_charge'],
            'total_payable' => $totals['total_payable'],
            'total_items' => count($totals['items']),
            'sale_date' => date('Y-m-d'),
            'user_id' => $data['user_id']
        ];
        
        if ($id) { 
            $this->db->where('id', $id)->update($this->table, $hold_data);
            $hold_id = $id;
            
            $this->db->where('holds_id', $id)->delete($this->table_details);
            $this->db->where('holds_id', $id)->delete($this->table_modifiers);
        } else { 
            $hold_data['hold_no'] = 'H-' . uniqid();
            $this->db->insert($this->table, $hold_data);
            $hold_id = $this->db->insert_id();
        }

        
        foreach ($totals['items'] as $item) {
            $detail_data = [
                'holds_id' => $hold_id,
                'food_menu_id' => $item['food_menu_id'],
                'menu_name' => $item['name'],
                'qty' => $item['qty'],
                'menu_unit_price' => $item['price'],
                'outlet_id' => $data['outlet_id'],
                'user_id' => $data['user_id']
            ];
            $this->db->insert($this->table_details, $detail_data);
            $detail_id = $this->db->insert_id();

            if (isset($item['modifiers']) && count($item['modifiers'])) {
                foreach ($item['modifiers'] as $modifier) {
                    $mod_data = [
                        'holds_id' => $hold_id,
                        'holds_details_id' => $detail_id,
                        'modifier_id' => $modifier['modifier_id'],
                        'modifier_price' => $modifier['price'],
                        'food_menu_id' => $item['food_menu_id'],
                        'outlet_id' => $data['outlet_id'],
                        'user_id' => $data['user_id'],
                        'customer_id' => $data['customer_id']
                    ];
                    $this->db->insert($this->table_modifiers, $mod_data);
                }
            }
        }
        
        $this->db->trans_complete();
        return ($this->db->trans_status()) ? ['status' => true, 'hold_id' => $hold_id] : ['status' => false, 'message' => 'Database transaction failed.'];
    }

    public function delete($id, $outlet_id)
    {
        $this->db->where('id', $id);
        $this->db->where('outlet_id', $outlet_id);
        return $this->db->update($this->table, ['del_status' => 'Deleted']);
    }
     public function finalize_hold($hold_id, $payment_data, $outlet_id)
    {
        
        $hold = $this->get_by_id($hold_id, $outlet_id);
        if (!$hold || !$hold->items) {
            return ['status' => false, 'message' => 'Hold order not found or is empty.'];
        }

        
        $sale_data = [
            'outlet_id' => $hold->outlet_id,
            'customer_id' => $hold->customer_id,
            'waiter_id' => $hold->waiter_id,
            'order_type' => $hold->order_type,
            'items' => [],
            'payments' => $payment_data['payments'], 
            'sub_total_discount_value' => $hold->sub_total_discount_value,
            'delivery_charge' => $hold->delivery_charge_actual_charge,
            'company_id' => $this->auth_data->company_id,
            'user_id' => $this->auth_data->user_id
        ];

        
        foreach ($hold->items as $item) {
            $sale_item = [
                'food_menu_id' => $item->food_menu_id,
                'qty' => $item->qty,
                'note' => $item->menu_note,
                'modifiers' => []
            ];
            if (isset($item->modifiers) && count($item->modifiers)) {
                foreach ($item->modifiers as $mod) {
                    $sale_item['modifiers'][] = ['modifier_id' => $mod->modifier_id];
                }
            }
            $sale_data['items'][] = $sale_item;
        }

        
        $this->load->model('api_v2/models/api_sale_model', 'sale_model');
        $this->sale_model->auth_data = $this->auth_data; 
        $sale_result = $this->sale_model->create_sale($sale_data);

        
        if ($sale_result['status']) {
            $this->delete($hold_id, $outlet_id);
            return $sale_result;
        } else {
            return ['status' => false, 'message' => 'Failed to create sale from hold.'];
        }
    }
}