<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_purchase_model extends CI_Model
{
    private $table = 'tbl_purchase';
    private $table_details = 'tbl_purchase_ingredients';
    private $table_ingredients = 'tbl_ingredients';

     public function get_all($company_id, $outlet_id, $limit = 20, $offset = 0)
    {
        $this->db->select('p.id, IFNULL(p.reference_no, "") as reference_no, p.date, p.grand_total, p.paid, p.due, p.supplier_id, p.note, p.payment_id as payment_method_id, s.name as supplier_name');
        $this->db->from($this->table . ' p');
        $this->db->join('tbl_suppliers s', 's.id = p.supplier_id', 'left');
        $this->db->join('tbl_outlets o', 'o.id = p.outlet_id'); 
        
        
        $this->db->where('o.company_id', $company_id); 
        $this->db->where('p.outlet_id', $outlet_id);
        $this->db->where('p.del_status', 'Live');
        
        $this->db->order_by('p.id', 'DESC');
        $this->db->limit($limit, $offset);
        
        $purchases = $this->db->get()->result();

        if (empty($purchases)) {
            return [];
        }


        
        $purchase_ids = array_column($purchases, 'id');

        
           $items_result = $this->db
            ->select('pi.purchase_id, pi.ingredient_id, i.name as ingredient_name, i.code as ingredient_code, pi.quantity_amount, pi.unit_price, pi.total')
            ->from($this->table_details . ' pi')
            ->join('tbl_ingredients i', 'i.id = pi.ingredient_id')
            ->where_in('pi.purchase_id', $purchase_ids)
            ->where('pi.del_status', 'Live')
            ->get()
            ->result();
        $items_map = [];
        foreach ($items_result as $item) {
            $items_map[$item->purchase_id][] = $item;
        }
        foreach ($purchases as $purchase) {
            $purchase->items = isset($items_map[$purchase->id]) ? $items_map[$purchase->id] : [];
        }
        return $purchases;
    }

    public function get_by_id($id, $company_id)
    {
        
        $this->db->select('p.id, IFNULL(p.reference_no, "") as reference_no, p.supplier_id, p.date, p.subtotal, p.other, p.grand_total, p.paid, p.due, p.note, p.user_id, p.outlet_id, p.added_date_time, p.payment_id, p.del_status, p.counter_id, s.name as supplier_name');
        $this->db->from($this->table . ' p');
        $this->db->join('tbl_suppliers s', 's.id = p.supplier_id', 'left');
        $this->db->join('tbl_outlets o', 'o.id = p.outlet_id');
        $this->db->where('p.id', $id);
        $this->db->where('o.company_id', $company_id);
        $this->db->where('p.del_status', 'Live');
        $purchase = $this->db->get()->row();

        if ($purchase) {
            $purchase->items = $this
                ->db
                ->select('pi.ingredient_id, i.name as ingredient_name, i.code as ingredient_code, pi.quantity_amount, pi.unit_price, pi.total')
                ->from($this->table_details . ' pi')
                ->join('tbl_ingredients i', 'i.id = pi.ingredient_id')
                ->where('pi.purchase_id', $id)
                ->where('pi.del_status', 'Live')
                ->get()
                ->result();
        }

        return $purchase;
    }

    public function create($data)
    {
        $this->db->trans_start();
        $items = $data['items'];
        unset($data['items']);
        if (isset($data['company_id'])) {
            unset($data['company_id']);
        }
        $grand_total = 0;
        foreach ($items as $item) {
            $grand_total += (float) $item['unit_price'] * (float) $item['quantity_amount'];
        }
        $data['grand_total'] = $grand_total;
        $data['due'] = $grand_total - (float) ($data['paid'] ?? 0);
        $this->db->insert($this->table, $data);
        $purchase_id = $this->db->insert_id();
        $this->_insert_purchase_items($purchase_id, $items, $data['outlet_id']);
        $this->db->trans_complete();
        return ($this->db->trans_status()) ? $purchase_id : false;
    }

    public function update($id, $data, $company_id)
    {
        $existing_purchase = $this->get_by_id($id, $company_id);
        if (!$existing_purchase) {
            return false;
        }
        $this->db->trans_start();
        $items = $data['items'];
        unset($data['items']);
        $grand_total = 0;
        foreach ($items as $item) {
            $grand_total += (float) $item['unit_price'] * (float) $item['quantity_amount'];
        }
        $data['grand_total'] = $grand_total;
        $data['due'] = $grand_total - (float) ($data['paid'] ?? 0);
        $this->db->where('id', $id)->update($this->table, $data);
        $this->db->where('purchase_id', $id)->delete($this->table_details);
        $this->_insert_purchase_items($id, $items, $data['outlet_id']);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    private function _insert_purchase_items($purchase_id, $items, $outlet_id)
    {
        foreach ($items as $item) {
            $ingredient = $this->db->get_where($this->table_ingredients, ['id' => $item['ingredient_id']])->row();
            if (!$ingredient)
                continue;
            $conversion_rate = (float) ($ingredient->conversion_rate) > 0 ? (float) ($ingredient->conversion_rate) : 1;
            $cost_per_unit = (float) $item['unit_price'] / $conversion_rate;
            $item_data = [
                'purchase_id' => $purchase_id,
                'ingredient_id' => $item['ingredient_id'],
                'unit_price' => $item['unit_price'],
                'quantity_amount' => $item['quantity_amount'],
                'total' => (float) $item['unit_price'] * (float) $item['quantity_amount'],
                'cost_per_unit' => $cost_per_unit,
                'outlet_id' => $outlet_id
            ];
            $this->db->insert($this->table_details, $item_data);
            $ingredient_update_data = [
                'purchase_price' => $item['unit_price'],
                'consumption_unit_cost' => $cost_per_unit
            ];
            $this->db->where('id', $item['ingredient_id'])->update($this->table_ingredients, $ingredient_update_data);
        }
    }

    public function delete($id, $company_id)
    {
        $existing_purchase = $this->get_by_id($id, $company_id);
        if (!$existing_purchase) {
            return false;
        }
        $this->db->trans_start();
        $this->db->where('id', $id)->update($this->table, ['del_status' => 'Deleted']);
        $this->db->where('purchase_id', $id)->update($this->table_details, ['del_status' => 'Deleted']);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
