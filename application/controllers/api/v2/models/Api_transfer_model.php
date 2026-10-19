<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_transfer_model extends CI_Model
{
    private $table = 'tbl_transfer';
    private $table_details = 'tbl_transfer_ingredients';

      public function get_all($company_id, $outlet_id = null)
    {
        
        
        $this->db->select('t.id, t.reference_no, DATE(t.date) as date, t.status, t.from_outlet_id, t.to_outlet_id, from_outlet.outlet_name as from_outlet, to_outlet.outlet_name as to_outlet');
        $this->db->from($this->table . ' t');
        $this->db->join('tbl_outlets from_outlet', 'from_outlet.id = t.from_outlet_id');
        $this->db->join('tbl_outlets to_outlet', 'to_outlet.id = t.to_outlet_id');

        if ($outlet_id) {
            $this->db->group_start();
            $this->db->where('t.from_outlet_id', $outlet_id);
            $this->db->or_where('t.to_outlet_id', $outlet_id);
            $this->db->group_end();
        } else {
            $this->db->where('from_outlet.company_id', $company_id);
        }
        
        $this->db->where('t.del_status', 'Live');
        $this->db->order_by('t.id', 'DESC');
        $transfers = $this->db->get()->result();

        if (empty($transfers)) {
            return [];
        }

        
        $transfer_ids = array_column($transfers, 'id');

        
        $items_result = $this->db
            ->select('ti.transfer_id, ti.ingredient_id, i.name as ingredient_name, i.code as ingredient_code, ti.quantity_amount')
            ->from($this->table_details . ' ti')
            ->join('tbl_ingredients i', 'i.id = ti.ingredient_id')
            ->where_in('ti.transfer_id', $transfer_ids)
            ->where('ti.del_status', 'Live')
            ->get()->result();

        
        $items_map = [];
        foreach ($items_result as $item) {
            $items_map[$item->transfer_id][] = $item;
        }

        
        foreach ($transfers as $transfer) {
            $transfer->items = isset($items_map[$transfer->id]) ? $items_map[$transfer->id] : [];
        }

        return $transfers;
    }
public function get_by_id($id, $company_id)
    {
        
        $this->db->select('t.*, DATE(t.date) as date, from_outlet.outlet_name as from_outlet, to_outlet.outlet_name as to_outlet');
        $this->db->from($this->table . ' t');
        $this->db->join('tbl_outlets from_outlet', 'from_outlet.id = t.from_outlet_id');
        $this->db->join('tbl_outlets to_outlet', 'to_outlet.id = t.to_outlet_id');
        $this->db->where('from_outlet.company_id', $company_id);
        $this->db->where('t.id', $id);
        $this->db->where('t.del_status', 'Live');
        $transfer = $this->db->get()->row();

        if ($transfer) {
            $transfer->items = $this->db
                ->select('ti.ingredient_id, i.name as ingredient_name, i.code as ingredient_code, ti.quantity_amount')
                ->from($this->table_details . ' ti')
                ->join('tbl_ingredients i', 'i.id = ti.ingredient_id')
                ->where('ti.transfer_id', $id)
                ->where('ti.del_status', 'Live')
                ->get()->result();
        }
        return $transfer;
    }
    

    public function create($data)
    {
        $this->db->trans_start();
        $items = $data['items'];
        unset($data['items']);
        
        $this->db->insert($this->table, $data);
        $transfer_id = $this->db->insert_id();

        foreach ($items as $item) {
            $item_data = [
                'transfer_id' => $transfer_id,
                'ingredient_id' => $item['ingredient_id'],
                'quantity_amount' => $item['quantity_amount'],
                'from_outlet_id' => $data['from_outlet_id'],
                'to_outlet_id' => $data['to_outlet_id'],
                'status' => $data['status'],
                'del_status' => 'Live'
            ];
            $this->db->insert($this->table_details, $item_data);
        }

        $this->db->trans_complete();
        return ($this->db->trans_status()) ? $transfer_id : false;
    }
public function update($id, $data)
    {
        $this->db->trans_start();

        $items = $data['items'];
        unset($data['items']);

        
        $this->db->where('id', $id)->update($this->table, $data);

        
        $this->db->where('transfer_id', $id)->update($this->table_details, ['del_status' => 'Deleted']);

        
        foreach ($items as $item) {
            $item_data = [
                'transfer_id' => $id,
                'ingredient_id' => $item['ingredient_id'],
                'quantity_amount' => $item['quantity_amount'],
                'from_outlet_id' => $data['from_outlet_id'],
                'to_outlet_id' => $data['to_outlet_id'],
                'status' => $data['status'],
                'del_status' => 'Live'
            ];
            $this->db->insert($this->table_details, $item_data);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    public function update_status($id, $data, $company_id)
    {
        $this->db->where('id', $id);
        
        
        $this->db->update($this->table, ['status' => $data['status'], 'note_for_receiver' => $data['note']]);
        
        
        $this->db->where('transfer_id', $id);
        return $this->db->update($this->table_details, ['status' => $data['status'
        ]]);
    }

   public function delete($id, $company_id, $from_outlet_id)
    {
        
        $this->db->where('id', $id);
        $this->db->where('from_outlet_id', $from_outlet_id);
        
        
        
        $this->db->where('status', 2); 
        

        
        $result = $this->db->update($this->table, ['del_status' => 'Deleted']);
        
        return $this->db->affected_rows() > 0;
    }
    
    public function generate_ref_no($outlet_id)
    {
        $count = $this->db->where('outlet_id', $outlet_id)->from($this->table)->count_all_results();
        return 'TR-' . str_pad($count + 1, 6, '0', STR_PAD_LEFT);
    }
}