<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_waste_model extends CI_Model
{
    private $table = 'tbl_wastes';
    private $table_details = 'tbl_waste_ingredients';

    public function get_all($outlet_id, $limit = 100, $offset = 0) 
    {
        
        $this->db->select('w.id, w.reference_no, w.date, w.total_loss, w.note, w.employee_id, u.full_name as responsible_person');
        $this->db->from($this->table . ' w');
        $this->db->join('tbl_users u', 'u.id = w.employee_id', 'left');
        $this->db->where('w.outlet_id', $outlet_id);
        $this->db->where('w.del_status', 'Live');
        $this->db->order_by('w.id', 'DESC');
        $this->db->limit($limit, $offset);
        
        $wastes = $this->db->get()->result();
        
        foreach ($wastes as $waste) {
            $waste->items = $this->db
                ->select('wi.ingredient_id, i.name as ingredient_name, wi.waste_amount, wi.loss_amount')
                ->from($this->table_details . ' wi')
                ->join('tbl_ingredients i', 'i.id = wi.ingredient_id', 'left')
                ->where('wi.waste_id', $waste->id)
                ->where('wi.del_status', 'Live')
                ->get()
                ->result();
        }
        return $wastes;
    }

    public function get_by_id($id, $outlet_id)
    {
        
        $this->db->select('w.*, u.full_name as responsible_person');
        $this->db->from($this->table . ' w');
        $this->db->join('tbl_users u', 'u.id = w.employee_id', 'left');
        $this->db->where('w.id', $id);
        $this->db->where('w.outlet_id', $outlet_id);
        $this->db->where('w.del_status', 'Live');
        $waste = $this->db->get()->row();
        
        if ($waste) {
            $waste->items = $this->db
                ->select('wi.ingredient_id, i.name as ingredient_name, i.code as ingredient_code, wi.waste_amount, wi.last_purchase_price, wi.loss_amount')
                ->from($this->table_details . ' wi')
                ->join('tbl_ingredients i', 'i.id = wi.ingredient_id')
                ->where('wi.waste_id', $id)
                ->where('wi.del_status', 'Live')
                ->get()
                ->result();
        }
        return $waste;
    }

    public function create($data)
    {
        $this->db->trans_start();
        $items = $data['items'];
        unset($data['items']);
        
        $total_loss = 0;
        foreach ($items as $item) {
            $ingredient = $this->db->get_where('tbl_ingredients', ['id' => $item['ingredient_id']])->row();
            if ($ingredient) {
                $loss_amount = (float)$ingredient->purchase_price * (float)$item['waste_amount'];
                $total_loss += $loss_amount;
            }
        }
        
        $data['total_loss'] = $total_loss;
        $this->db->insert($this->table, $data);
        $waste_id = $this->db->insert_id();

        foreach ($items as $item) {
            $ingredient = $this->db->get_where('tbl_ingredients', ['id' => $item['ingredient_id']])->row();
            $last_purchase_price = $ingredient ? $ingredient->purchase_price : 0;
            $loss_amount = $last_purchase_price * (float)$item['waste_amount'];
            $item_data = [
                'waste_id' => $waste_id,
                'ingredient_id' => $item['ingredient_id'],
                'waste_amount' => $item['waste_amount'],
                'last_purchase_price' => $last_purchase_price,
                'loss_amount' => $loss_amount,
                'outlet_id' => $data['outlet_id']
            ];
            $this->db->insert($this->table_details, $item_data);
        }
        
        $this->db->trans_complete();
        return ($this->db->trans_status()) ? $waste_id : false;
    }
public function update($id, $data)
    {
        $this->db->trans_start();

        $items = $data['items'];
        unset($data['items']);
        
        
        $total_loss = 0;
        foreach ($items as $item) {
            $ingredient = $this->db->get_where('tbl_ingredients', ['id' => $item['ingredient_id']])->row();
            if ($ingredient) {
                $loss_amount = (float)$ingredient->purchase_price * (float)$item['waste_amount'];
                $total_loss += $loss_amount;
            }
        }
        $data['total_loss'] = $total_loss;

        
        $this->db->where('id', $id)->update($this->table, $data);

        
        $this->db->where('waste_id', $id)->update($this->table_details, ['del_status' => 'Deleted']);
        
        
        foreach ($items as $item) {
            $ingredient = $this->db->get_where('tbl_ingredients', ['id' => $item['ingredient_id']])->row();
            $last_purchase_price = $ingredient ? $ingredient->purchase_price : 0;
            $loss_amount = $last_purchase_price * (float)$item['waste_amount'];
            
            $item_data = [
                'waste_id' => $id,
                'ingredient_id' => $item['ingredient_id'],
                'waste_amount' => $item['waste_amount'],
                'last_purchase_price' => $last_purchase_price,
                'loss_amount' => $loss_amount,
                'outlet_id' => $data['outlet_id']            ];
            $this->db->insert($this->table_details, $item_data);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    public function delete($id, $outlet_id)
    {
        $waste = $this->db->get_where($this->table, ['id' => $id, 'outlet_id' => $outlet_id])->row();
        if (!$waste) {
            return false;
        }
        $this->db->trans_start();
        $this->db->where('id', $id)->update($this->table, ['del_status' => 'Deleted']);
        $this->db->where('waste_id', $id)->update($this->table_details, ['del_status' => 'Deleted']);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function generate_ref_no($outlet_id)
    {
        $count = $this->db->where('outlet_id', $outlet_id)->from($this->table)->count_all_results();
        return 'W-' . str_pad($count + 1, 6, '0', STR_PAD_LEFT);
    }
}