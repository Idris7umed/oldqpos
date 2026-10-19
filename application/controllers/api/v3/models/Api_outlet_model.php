<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_outlet_model extends CI_Model
{
    private $table = 'tbl_outlets';

    public function get_all($company_id)
    {
        
        $this->db->select('id, outlet_name, outlet_code, address, phone, email, active_status, default_waiter, online_order_module, food_menus, food_menu_prices, delivery_price');
        return $this->db->get_where($this->table, ['del_status' => 'Live', 'company_id' => $company_id])->result();
    }


   public function get_by_id($id, $company_id)
    {
        
        $this->db->select('id, outlet_name, outlet_code, address, phone, email, active_status, default_waiter, online_order_module, food_menus, food_menu_prices, delivery_price');
        return $this->db->get_where($this->table, ['id' => $id, 'del_status' => 'Live', 'company_id' => $company_id])->row();
    }
    
    
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    
    public function update($id, $data, $company_id)
    {
        $this->db->where('id', $id);
        $this->db->where('company_id', $company_id);
        return $this->db->update($this->table, $data);
    }

    
    public function delete($id, $company_id)
    {
        $this->db->where('id', $id);
        $this->db->where('company_id', $company_id);
        
        if ($id == 1) {
            return false;
        }
        return $this->db->update($this->table, ['del_status' => 'Deleted']);
    }

    
    public function generateOutletCode($company_id) {
        $count = $this->db->where('company_id', $company_id)->from($this->table)->count_all_results();
        $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        return $code;
    }
}