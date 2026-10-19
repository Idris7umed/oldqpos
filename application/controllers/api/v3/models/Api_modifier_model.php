<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_modifier_model extends CI_Model
{
    private $table = 'tbl_modifiers';
    private $table_ingredients = 'tbl_modifier_ingredients';

    public function get_all($company_id)
    {
        $modifiers = $this->db->get_where($this->table, ['company_id' => $company_id, 'del_status' => 'Live'])->result();
        if (empty($modifiers)) {
            return [];
        }
        $modifier_ids = array_column($modifiers, 'id');
        $ingredients_result = $this
            ->db
            ->select('mi.modifier_id, mi.ingredient_id, i.name as ingredient_name, mi.consumption')
            ->from($this->table_ingredients . ' mi')
            ->join('tbl_ingredients i', 'i.id = mi.ingredient_id')
            ->where_in('mi.modifier_id', $modifier_ids)
            ->where('mi.del_status', 'Live')
            ->get()
            ->result();
        $ingredients_map = [];
        foreach ($ingredients_result as $ingredient) {
            $ingredient->ingredient_id = (int) $ingredient->ingredient_id;
            $ingredient->consumption = (float) $ingredient->consumption;
            $ingredients_map[$ingredient->modifier_id][] = $ingredient;
        }
        foreach ($modifiers as $modifier) {
            $modifier->ingredients = isset($ingredients_map[$modifier->id]) ? $ingredients_map[$modifier->id] : [];
        }
        return $modifiers;
    }

    public function get_by_id($id, $company_id)
    {
        $modifier = $this->db->get_where($this->table, ['id' => $id, 'company_id' => $company_id, 'del_status' => 'Live'])->row();
        if ($modifier) {
            $ingredients = $this
                ->db
                ->select('mi.ingredient_id, i.name as ingredient_name, mi.consumption')
                ->from($this->table_ingredients . ' mi')
                ->join('tbl_ingredients i', 'i.id = mi.ingredient_id')
                ->where('mi.modifier_id', $id)
                ->where('mi.del_status', 'Live')
                ->get()
                ->result();
            foreach ($ingredients as $ingredient) {
                $ingredient->ingredient_id = (int) $ingredient->ingredient_id;
                $ingredient->consumption = (float) $ingredient->consumption;
            }
            $modifier->ingredients = $ingredients;
        }
        return $modifier;
    }

    public function create($data)
    {
        $this->db->trans_start();
        $ingredients = $data['ingredients'] ?? [];
        unset($data['ingredients']);
        $total_cost = 0;
        foreach ($ingredients as $ingredient) {
            $ing_details = $this->db->get_where('tbl_ingredients', ['id' => $ingredient['ingredient_id']])->row();
            if ($ing_details) {
                
                $total_cost += (float) $ing_details->consumption_unit_cost * (float) $ingredient['consumption'];
            }
        }
        $data['total_cost'] = $total_cost;
        $this->db->insert($this->table, $data);
        $modifier_id = $this->db->insert_id();
        $this->_sync_ingredients($modifier_id, $ingredients, $data['user_id'], $data['company_id']);
        $this->db->trans_complete();
        return ($this->db->trans_status()) ? $modifier_id : false;
    }

    public function update($id, $data, $company_id, $user_id)
    {
        $existing_modifier = $this->db->get_where($this->table, ['id' => $id, 'company_id' => $company_id])->row();
        if (!$existing_modifier) {
            return false;
        }
        $this->db->trans_start();
        $ingredients = $data['ingredients'] ?? null;
        unset($data['ingredients']);
        if ($ingredients !== null) {
            $total_cost = 0;
            foreach ($ingredients as $ingredient) {
                $ing_id = is_array($ingredient) ? $ingredient['ingredient_id'] : $ingredient->ingredient_id;
                $ing_consumption = is_array($ingredient) ? $ingredient['consumption'] : $ingredient->consumption;
                $ing_details = $this->db->get_where('tbl_ingredients', ['id' => $ing_id])->row();
                if ($ing_details) {
                    
                    $total_cost += (float) $ing_details->consumption_unit_cost * (float) $ing_consumption;
                }
            }
            $data['total_cost'] = $total_cost;
        }
        if (!empty($data)) {
            $this->db->where('id', $id)->update($this->table, $data);
        }
        if ($ingredients !== null) {
            $this->_sync_ingredients($id, $ingredients, $user_id, $company_id);
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function delete($id, $company_id)
    {
        $existing_modifier = $this->db->get_where($this->table, ['id' => $id, 'company_id' => $company_id])->row();
        if (!$existing_modifier) {
            return false;
        }
        return $this->db->where('id', $id)->update($this->table, ['del_status' => 'Deleted']);
    }

    private function _sync_ingredients($modifier_id, $ingredients, $user_id, $company_id)
    {
        $this->db->where('modifier_id', $modifier_id)->delete($this->table_ingredients);
        foreach ($ingredients as $ingredient) {
            $ing_id = is_array($ingredient) ? $ingredient['ingredient_id'] : $ingredient->ingredient_id;
            $ing_consumption = is_array($ingredient) ? $ingredient['consumption'] : $ingredient->consumption;
            
            $ing_details = $this->db->get_where('tbl_ingredients', ['id' => $ing_id])->row();
            $cost_per_unit = 0;
            if ($ing_details) {
                $cost_per_unit = (float) $ing_details->consumption_unit_cost;
            }
            $ing_data = [
                'modifier_id' => $modifier_id,
                'ingredient_id' => $ing_id,
                'consumption' => $ing_consumption,
                'cost' => $cost_per_unit,
                'total' => $cost_per_unit * (float) $ing_consumption,
                'user_id' => $user_id,
                'company_id' => $company_id
            ];
            $this->db->insert($this->table_ingredients, $ing_data);
        }
    }
}
