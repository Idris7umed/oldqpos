<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_inventory_adjustment_model extends CI_Model
{
    private $table = 'tbl_inventory_adjustment';
    private $table_details = 'tbl_inventory_adjustment_ingredients';

    public function get_all($outlet_id, $limit = 20, $offset = 0)
    {
        $this->db->select('ia.id, ia.reference_no, ia.date, ia.note, u.full_name as responsible_person');
        $this->db->from($this->table . ' ia');
        $this->db->join('tbl_users u', 'u.id = ia.employee_id', 'left');
        $this->db->where('ia.outlet_id', $outlet_id);
        $this->db->where('ia.del_status', 'Live');
        $this->db->order_by('ia.id', 'DESC');
        $this->db->limit($limit, $offset);
        $adjustments = $this->db->get()->result();

        foreach ($adjustments as $adjustment) {
            $adjustment->items = $this->db
                ->select('iai.ingredient_id, i.name as ingredient_name, iai.consumption_amount, iai.consumption_status')
                ->from($this->table_details . ' iai')
                ->join('tbl_ingredients i', 'i.id = iai.ingredient_id', 'left')
                ->where('iai.inventory_adjustment_id', $adjustment->id)
                ->where('iai.del_status', 'Live')
                ->get()
                ->result();
        }
        return $adjustments;
    }

    public function get_by_id($id, $outlet_id)
    {
        $adjustment = $this->db->get_where($this->table, ['id' => $id, 'outlet_id' => $outlet_id, 'del_status' => 'Live'])->row();
        if ($adjustment) {
            
            $adjustment->id = (int) $adjustment->id;
            $adjustment->employee_id = (int) $adjustment->employee_id;

            $items_query = $this->db
                ->select('iai.ingredient_id, i.name as ingredient_name, i.code as ingredient_code, iai.consumption_amount, iai.consumption_status')
                ->from($this->table_details . ' iai')
                ->join('tbl_ingredients i', 'i.id = iai.ingredient_id')
                ->where('iai.inventory_adjustment_id', $id)
                ->where('iai.del_status', 'Live')
                ->get()
                ->result();

            
            foreach ($items_query as $item) {
                $item->ingredient_id = (int) $item->ingredient_id;
                $item->consumption_amount = (float) $item->consumption_amount;
            }
            $adjustment->items = $items_query;
        }
        return $adjustment;
    }

    public function create($data)
    {
        $this->db->trans_start();

        $items = $data['items'];
        unset($data['items']);

        $this->db->insert($this->table, $data);
        $adjustment_id = $this->db->insert_id();

        foreach ($items as $item) {
            $item_data = [
                'inventory_adjustment_id' => $adjustment_id,
                'ingredient_id' => $item['ingredient_id'],
                'consumption_amount' => $item['consumption_amount'],
                'consumption_status' => $item['consumption_status'],
                'outlet_id' => $data['outlet_id']
            ];
            $this->db->insert($this->table_details, $item_data);
        }

        $this->db->trans_complete();
        return ($this->db->trans_status()) ? $adjustment_id : false;
    }

    public function update($id, $data)
    {
        $this->db->trans_start();
        $items = $data['items'];
        unset($data['items']);
        $this->db->where('id', $id)->update($this->table, $data);
        $this->db->where('inventory_adjustment_id', $id)->delete($this->table_details);
        foreach ($items as $item) {
            $item_data = [
                'inventory_adjustment_id' => $id,
                'ingredient_id' => $item['ingredient_id'],
                'consumption_amount' => $item['consumption_amount'],
                'consumption_status' => $item['consumption_status'],
                'outlet_id' => $data['outlet_id']
            ];
            $this->db->insert($this->table_details, $item_data);
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function delete($id, $outlet_id)
    {
        $adjustment = $this->db->get_where($this->table, ['id' => $id, 'outlet_id' => $outlet_id])->row();
        if (!$adjustment) {
            return false;
        }
        $this->db->trans_start();
        $this->db->where('id', $id)->update($this->table, ['del_status' => 'Deleted']);
        $this->db->where('inventory_adjustment_id', $id)->update($this->table_details, ['del_status' => 'Deleted']);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function generate_ref_no($outlet_id)
    {
        $count = $this->db->where('outlet_id', $outlet_id)->from($this->table)->count_all_results();
        return 'IA-' . str_pad($count + 1, 6, '0', STR_PAD_LEFT);
    }
}