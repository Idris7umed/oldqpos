<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_waiter_model extends CI_Model
{
    private $table = 'tbl_notifications';

    public function get_notifications($waiter_id)
    {
        $this->db->select('id, notification, sale_id');
        $this->db->from($this->table);
        $this->db->where('waiter_id', $waiter_id);
        $this->db->where('push_status', 1);
        $this->db->order_by('id', 'ASC');
        return $this->db->get()->result();
    }

    public function mark_as_viewed($notification_ids, $waiter_id)
    {
        if (!is_array($notification_ids) || empty($notification_ids)) {
            return false;
        }
        $this->db->where('waiter_id', $waiter_id);
        $this->db->where_in('id', $notification_ids);
        return $this->db->update($this->table, ['push_status' => 2]);
    }

    
    public function get_new_orders($outlet_id, $waiter_id)
    {
        $this->db->select("s.id as sale_id, s.sale_no, s.order_status, c.name as customer_name, u.full_name as waiter_name, t.name as table_name, s.date_time");
        $this->db->from('tbl_sales s');
        $this->db->where("s.outlet_id", $outlet_id);
        $this->db->where_in("s.order_status", [1, 2]); 
        $this->db->join('tbl_tables t', 't.id = s.table_id', 'left');
        $this->db->join('tbl_users u', 'u.id = s.waiter_id', 'left');
        $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
        $this->db->order_by('s.id', 'ASC');
        $orders = $this->db->get()->result();

        foreach ($orders as $order) {
            $order->total_kitchen_type_items = $this->db->where('sales_id', $order->sale_id)->where('item_type !=', 'Bar Item')->from('tbl_sales_details')->count_all_results();
            $order->total_kitchen_type_done_items = $this->db->where('sales_id', $order->sale_id)->where('item_type !=', 'Bar Item')->where('cooking_status', 'Done')->from('tbl_sales_details')->count_all_results();
            
            $to_time = strtotime(date('Y-m-d H:i:s'));
            $from_time = strtotime($order->date_time);
            $minutes = floor(abs($to_time - $from_time) / 60);
            $seconds = abs($to_time - $from_time) % 60;
            $order->minute_difference = str_pad(floor($minutes), 2, "0", STR_PAD_LEFT);
            $order->second_difference = str_pad(floor($seconds), 2, "0", STR_PAD_LEFT);
        }
        return $orders;
    }
    
    public function get_order_details($sale_id)
    {
        $this->db->select("s.*, u.full_name as waiter_name, c.name as customer_name, t.name as table_name");
        $this->db->from('tbl_sales s');
        $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
        $this->db->join('tbl_users u', 'u.id = s.waiter_id', 'left');
        $this->db->join('tbl_tables t', 't.id = s.table_id', 'left');
        $this->db->where("s.id", $sale_id);
        $sale_info = $this->db->get()->row();

        if ($sale_info) {
            $items = $this->db->select("sd.id as sales_details_id, fm.name as menu_name, sd.qty, sd.cooking_status, sd.menu_note")
                                ->from('tbl_sales_details sd')
                                ->join('tbl_food_menus fm', 'fm.id = sd.food_menu_id', 'left')
                                ->where("sd.sales_id", $sale_id)
                                ->order_by('sd.id', 'ASC')
                                ->get()->result();
            
            foreach ($items as $item) {
                $item->modifiers = $this->db->select("sdm.*, m.name, m.price as modifier_price")
                                            ->from('tbl_sales_details_modifiers sdm')
                                            ->join('tbl_modifiers m', 'm.id = sdm.modifier_id', 'left')
                                            ->where("sdm.sales_id", $sale_id)
                                            ->where("sdm.sales_details_id", $item->sales_details_id)
                                            ->get()->result();
            }
            $sale_info->items = $items;
        }
        return $sale_info;
    }
    
}