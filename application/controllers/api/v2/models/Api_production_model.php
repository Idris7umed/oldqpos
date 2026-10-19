<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_production_model extends CI_Model
{
    private $table = 'tbl_production';
    private $table_details = 'tbl_production_ingredients';
    private $table_consumption = 'tbl_sale_consumptions_of_menus';

    public function get_all($outlet_id)
    {
        return $this->db->get_where($this->table, ['outlet_id' => $outlet_id, 'del_status' => 'Live'])->result();
    }

    public function get_by_id($id, $outlet_id)
    {
        $production = $this->db->get_where($this->table, ['id' => $id, 'outlet_id' => $outlet_id, 'del_status' => 'Live'])->row();
        
        if ($production) {
            
            $production->items = $this->db
                ->select('pi.ingredient_id, i.name as premade_food_name, pi.quantity_amount')
                ->from($this->table_details . ' pi')
                ->join('tbl_ingredients i', 'i.id = pi.ingredient_id')
                ->where('pi.production_id', $id)
                ->get()->result();
        }
        
        return $production;
    }

    public function create_or_update($data, $id = null)
    {
        $this->db->trans_start();
        
        $items = $data['items'];
        unset($data['items']);
        
        if ($id) {
            $this->db->where('id', $id)->update($this->table, $data);
            $production_id = $id;
            
            $this->db->where('production_id', $id)->delete($this->table_details);
            $this->db->where('production_id', $id)->delete($this->table_consumption);
        } else {
            $this->db->insert($this->table, $data);
            $production_id = $this->db->insert_id();
        }
        
        $this->_insert_items_and_consume($production_id, $items, $data['status'], $data['outlet_id']);
        
        $this->db->trans_complete();
        return ($this->db->trans_status()) ? $production_id : false;
    }

    private function _insert_items_and_consume($production_id, $items, $status, $outlet_id) {
        foreach ($items as $item) {
            $prod_item_data = [
                'production_id' => $production_id,
                'ingredient_id' => $item['ingredient_id'],
                'quantity_amount' => $item['quantity_amount'],
                'outlet_id' => $outlet_id,
                'status' => $status
            ];
            
            $this->db->insert($this->table_details, $prod_item_data);
            
            if ($status == 1) {
                $recipe = $this->db->get_where('tbl_premade_ingredients', ['pre_made_id' => $item['ingredient_id']])->result();
                
                foreach ($recipe as $raw_ingredient) {
                    $consumption_data = [
                        'ingredient_id' => $raw_ingredient->ingredient_id,
                        'consumption' => (float)$item['quantity_amount'] * (float)$raw_ingredient->consumption,
                        'cost' => $raw_ingredient->cost,
                        'production_id' => $production_id,
                        'status' => 1,
                        'outlet_id' => $outlet_id,
                        'user_id' => $this->auth_data->user_id,
                        'del_status' => 'Live'
                    ];
                    
                    $this->db->insert($this->table_consumption, $consumption_data);
                }
            }
        }
    }

    public function delete($id, $outlet_id)
    {
        $this->db->trans_start();
        
        $this->db->where('id', $id)->where('outlet_id', $outlet_id)->update($this->table, ['del_status' => 'Deleted']);
        $this->db->where('production_id', $id)->delete($this->table_details);
        $this->db->where('production_id', $id)->delete($this->table_consumption);
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function generate_ref_no($outlet_id)
    {
        $count = $this->db->where('outlet_id', $outlet_id)->from($this->table)->count_all_results();
        return 'PROD-' . str_pad($count + 1, 6, '0', STR_PAD_LEFT);
    }
}