<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('checkPromotionWithinDatePOS')) {
    
    function checkPromotionWithinDatePOS($today_date, $food_menu_id, $outlet_id) {
        
        $ci = &get_instance();
            log_message('error', "Checking promotion for food_menu_id: {$food_menu_id} in outlet_id: {$outlet_id}");

        $ci->db->select('*');
        $ci->db->from('tbl_promotions');
        $ci->db->where('food_menu_id', $food_menu_id);
        $ci->db->where('outlet_id', $outlet_id); 
        $ci->db->where('status', 1);
        $ci->db->where('del_status', 'Live');
        $ci->db->where("start_date <= '$today_date'");
        $ci->db->where("end_date >= '$today_date'");
        $result = $ci->db->get()->row();
        
        if ($result) {
            return array('status' => true, 'details' => $result);
        } else {
            return array('status' => false);
        }
    }
}