<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_kitchen_model extends CI_Model
{
    public function get_kitchen_orders($kitchen_id)
    {
        
        $this->db->select("
            ks.id as sale_id, 
            ks.sale_no, 
            ks.order_time, 
            c.name as customer_name,
            u.full_name as waiter_name,
            ks.orders_table_text
        ");
        $this->db->from('tbl_kitchen_sales ks');
        $this->db->join('tbl_kitchen_sales_details ksd', 'ksd.sales_id = ks.id');
        $this->db->join('tbl_food_menus fm', 'fm.id = ksd.food_menu_id');
        
        
        
        $this->db->join('tbl_food_menus fm_parent', 'fm_parent.id = fm.parent_id', 'left');
        
        
        
        
        
        $this->db->join('tbl_kitchen_categories kc', 'kc.cat_id = (CASE WHEN fm.parent_id > 0 THEN fm_parent.category_id ELSE fm.category_id END)', 'left');
        

        $this->db->join('tbl_customers c', 'c.id = ks.customer_id', 'left');
        $this->db->join('tbl_users u', 'u.id = ks.waiter_id', 'left');
        
        $this->db->where('kc.kitchen_id', $kitchen_id);
        $this->db->where_in('ksd.cooking_status', ['New', 'Started Cooking']);
        $this->db->where('ks.del_status', 'Live');
        $this->db->group_by('ks.id');
        $this->db->order_by('ks.order_time', 'ASC');
        
        $sales = $this->db->get()->result();

        
        foreach ($sales as $sale) {
            $sale->items = $this->db
                ->select('ksd.id as detail_id, ksd.menu_name, ksd.qty, ksd.cooking_status, ksd.menu_note')
                ->from('tbl_kitchen_sales_details ksd')
                ->join('tbl_food_menus fm', 'fm.id = ksd.food_menu_id')
                
                ->join('tbl_food_menus fm_parent', 'fm_parent.id = fm.parent_id', 'left')
                ->join('tbl_kitchen_categories kc', 'kc.cat_id = (CASE WHEN fm.parent_id > 0 THEN fm_parent.category_id ELSE fm.category_id END)', 'left')
                
                ->where('ksd.sales_id', $sale->sale_id)
                ->where('kc.kitchen_id', $kitchen_id)
                ->where_in('ksd.cooking_status', ['New', 'Started Cooking'])
                ->get()->result();
        }

        return $sales;
    }

    public function update_item_status($detail_id, $status)
    {
        
        if (!in_array($status, ['Started Cooking', 'Done'])) {
            return false;
        }

        $update_data = ['cooking_status' => $status];
        if ($status == 'Started Cooking') {
            $update_data['cooking_start_time'] = date('Y-m-d H:i:s');
        } elseif ($status == 'Done') {
            $update_data['cooking_done_time'] = date('Y-m-d H:i:s');
        }
        
        $this->db->where('id', $detail_id);
        return $this->db->update('tbl_kitchen_sales_details', $update_data);
    }
}