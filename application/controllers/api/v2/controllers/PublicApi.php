<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class PublicApi extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->add_package_path(APPPATH . 'controllers/api/v2/');
        $this->load->model('Common_model');
        $this->load->helper('api');
        $this->load->model('api_outlet_model', 'outlet_model');
        $this->load->model('api_food_menu_model', 'food_menu_model');
        $this->load->model('api_food_menu_category_model', 'category_model');
    }

    public function outlets_get()
    {
        
        $this->db->select('id, outlet_name, address, phone, email, food_menus');
        $this->db->from('tbl_outlets');
        $this->db->where('del_status', 'Live');
        $this->db->where('active_status', 'active');
        $outlets = $this->db->get()->result();

        $sales_counts = [];

        
        foreach ($outlets as $outlet) {
            $food_menu_ids = !empty($outlet->food_menus) ? explode(',', $outlet->food_menus) : [];

            
            if (!empty($food_menu_ids)) {
                $this->db->select_min('sale_price');
                $this->db->where_in('id', $food_menu_ids);
                $this->db->where('del_status', 'Live');
                $min_price_query = $this->db->get('tbl_food_menus');
                
                $outlet->min_order_price = (float) $min_price_query->row('sale_price');
            } else {
                $outlet->min_order_price = 0.0;
            }

            
            
            $this->db->select('AVG(TIMESTAMPDIFF(MINUTE, order_time, cooking_done_time)) as avg_prep_time');
            $this->db->from('tbl_kitchen_sales');
            $this->db->where('outlet_id', $outlet->id);
            $this->db->where('cooking_done_time IS NOT NULL');
            $this->db->where("cooking_done_time != '0000-00-00 00:00:00'");
            $prep_time_query = $this->db->get();
            $avg_time = $prep_time_query->row('avg_prep_time');
            $outlet->delivery_time_minutes = $avg_time ? (int) round($avg_time) : 25;  

            
            $this->db->where('outlet_id', $outlet->id);
            $this->db->where('del_status', 'Live');
            $total_sales = $this->db->count_all_results('tbl_sales');
            $outlet->sales_count = $total_sales;
            $sales_counts[] = $total_sales;

            
            unset($outlet->food_menus);
        }

        
        $max_sales = !empty($sales_counts) ? max($sales_counts) : 0;

        foreach ($outlets as $outlet) {
            if ($max_sales > 0) {
                
                $rating = 3.5 + (($outlet->sales_count / $max_sales) * 1.5);
                $outlet->rating = round($rating, 1);
            } else {
                $outlet->rating = 3.5;  
            }
            unset($outlet->sales_count);  
        }

        json_response(REST_Controller::HTTP_OK, 'success', 'Outlets list retrieved.', $outlets, $this);
    }

    public function categories_get($outlet_id = 0)
    {
        if (!$outlet_id) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required.', null, $this);
            return;
        }
        $company_id = $this->db->select('company_id')->get_where('tbl_outlets', ['id' => $outlet_id])->row('company_id');
        if (!$company_id) {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Outlet not found.', null, $this);
            return;
        }
        $data = $this->category_model->get_all($company_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Categories list.', $data, $this);
    }

    public function menu_get($outlet_id = 0)
    {
        if (!$outlet_id) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required.', null, $this);
            return;
        }
        $company_id = $this->db->select('company_id')->get_where('tbl_outlets', ['id' => $outlet_id])->row('company_id');
        if (!$company_id) {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Outlet not found.', null, $this);
            return;
        }
        $data = $this->food_menu_model->get_all($company_id, $outlet_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Food menus list.', $data, $this);
    }
}
