<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_premade_food_model extends CI_Model
{
    private $table = 'tbl_ingredients';
    private $table_ingredients = 'tbl_premade_ingredients';

    public function get_all($company_id)
    {
        $this->db->select('i.id, i.name, i.code, i.purchase_price, i.alert_quantity, ic.category_name, u.unit_name');
        $this->db->from($this->table . ' i');
        $this->db->join('tbl_ingredient_categories ic', 'ic.id = i.category_id', 'left');
        $this->db->join('tbl_units u', 'u.id = i.unit_id', 'left');
        $this->db->where('i.company_id', $company_id);
        $this->db->where('i.ing_type', 'Pre-made Item');
        $this->db->where('i.del_status', 'Live');
        return $this->db->get()->result();
    }

    public function get_by_id($id, $company_id)
    {
        $premade_food = $this->db->get_where($this->table, ['id' => $id, 'company_id' => $company_id, 'del_status' => 'Live', 'ing_type' => 'Pre-made Item'])->row();

        if ($premade_food) {
            $premade_food->ingredients = $this->db
                ->select('pi.ingredient_id, i.name as ingredient_name, pi.consumption, u.unit_name')
                ->from($this->table_ingredients . ' pi')
                ->join('tbl_ingredients i', 'i.id = pi.ingredient_id')
                ->join('tbl_units u', 'u.id = i.unit_id', 'left')
                ->where('pi.pre_made_id', $id)
                ->where('pi.del_status', 'Live')
                ->get()
                ->result();
        }
        return $premade_food;
    }

    public function create_or_update($data, $id = null)
    {
        $this->db->trans_start();

        $ingredients = $data['ingredients'] ?? [];
        unset($data['ingredients']);

        if ($id) {
            $this->db->where('id', $id);
            $this->db->update($this->table, $data);
            $premade_id = $id;
        } else {
            $data['ing_type'] = 'Pre-made Item';
            $this->db->insert($this->table, $data);
            $premade_id = $this->db->insert_id();
        }

        $this->_sync_ingredients($premade_id, $ingredients, $data['user_id'], $data['company_id']);

        $this->db->trans_complete();
        return ($this->db->trans_status()) ? $premade_id : false;
    }

    public function delete($id, $company_id)
    {
        $this->db->trans_start();
        $this->db->where('id', $id)->where('company_id', $company_id)->update($this->table, ['del_status' => 'Deleted']);
        $this->db->where('pre_made_id', $id)->update($this->table_ingredients, ['del_status' => 'Deleted']);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    private function _sync_ingredients($premade_id, $ingredients, $user_id, $company_id)
    {
        $this->db->where('pre_made_id', $premade_id)->delete($this->table_ingredients);
        foreach ($ingredients as $ingredient) {
            if (!empty($ingredient['ingredient_id']) && !empty($ingredient['consumption'])) {
                $ing_data = [
                    'pre_made_id' => $premade_id,
                    'ingredient_id' => $ingredient['ingredient_id'],
                    'consumption' => $ingredient['consumption'],
                    'user_id' => $user_id,
                    'company_id' => $company_id,
                    'del_status' => 'Live',
                ];
                $this->db->insert($this->table_ingredients, $ing_data);
            }
        }
    }
}