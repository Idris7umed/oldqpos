<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Orders extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Sale_model');
    }

    public function place_order_post()
    {
        if (!isset($this->auth_data->user_type) || $this->auth_data->user_type !== 'customer') {
            json_response(REST_Controller::HTTP_FORBIDDEN, 'error', 'This action is only allowed for customers.', null, $this);
            return;
        }
        $order_details = json_decode(file_get_contents('php://input'));
        if (!$order_details || !isset($order_details->items) || empty($order_details->items)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Order data is missing or invalid.', null, $this);
            return;
        }
        $this->db->trans_begin();
        $sale_no = $this->Sale_model->generateToken_no($order_details->outlet_id);
        $data = array();
        $data['customer_id'] = $this->auth_data->customer_id;
        $data['outlet_id'] = $order_details->outlet_id;
        $data['waiter_id'] = get_outlet_waiter($order_details->outlet_id);
        $data['total_items'] = count($order_details->items);
        $data['sub_total'] = $order_details->sub_total;
        $data['vat'] = $order_details->total_vat;
        $data['total_payable'] = $order_details->total_payable;
        $data['delivery_charge_actual_charge'] = $order_details->delivery_charge ?? 0;
        $data['user_id'] = get_outlet_waiter($order_details->outlet_id);
        $data['sale_date'] = date('Y-m-d');
        $data['date_time'] = date('Y-m-d H:i:s');
        $data['order_time'] = date('H:i:s');
        $data['order_status'] = 1;
        $data['sale_no'] = $sale_no;
        $data['is_online_order'] = 'Yes';
        $data['is_accept'] = 2;
        $data['online_order_receiving_id'] = getOnlineOrderReceivingId($order_details->outlet_id);
        $data['del_status'] = ($order_details->payment_method == 'cash_on_delivery') ? 'Live' : 'Deleted';
        $data['order_type'] = $order_details->order_type;
        $data['del_address'] = $order_details->customer_address ?? null;
        $this->db->insert('tbl_kitchen_sales', $data);
        $sale_id = $this->db->insert_id();
        foreach ($order_details->items as $item) {
            $item_data = [
                'food_menu_id' => $item->food_menu_id,
                'menu_name' => $item->menu_name,
                'qty' => $item->qty,
                'menu_unit_price' => $item->menu_unit_price,
                'menu_price_without_discount' => $item->menu_unit_price * $item->qty,
                'menu_price_with_discount' => $item->menu_unit_price * $item->qty,
                'menu_note' => $item->menu_note ?? null,
                'sales_id' => $sale_id,
                'outlet_id' => $order_details->outlet_id,
                'del_status' => 'Live',
                'cooking_status' => 'New'
            ];
            $this->db->insert('tbl_kitchen_sales_details', $item_data);
            $sales_details_id = $this->db->insert_id();
            if (isset($item->modifiers) && !empty($item->modifiers)) {
                foreach ($item->modifiers as $modifier) {
                    $modifier_data = [
                        'modifier_id' => $modifier->modifier_id,
                        'modifier_price' => $modifier->modifier_price,
                        'food_menu_id' => $item->food_menu_id,
                        'sales_id' => $sale_id,
                        'sales_details_id' => $sales_details_id,
                        'outlet_id' => $order_details->outlet_id
                    ];
                    $this->db->insert('tbl_kitchen_sales_details_modifiers', $modifier_data);
                }
            }
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to place order.', null, $this);
        } else {
            $this->db->trans_commit();
            $notification = 'a new online order has been placed, Order Number is: ' . $sale_no;
            $notification_data = [
                'notification' => $notification,
                'sale_id' => $sale_id,
                'outlet_id' => $order_details->outlet_id,
            ];
            $this->db->insert('tbl_notifications', $notification_data);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Order placed successfully.', ['sale_id' => $sale_id, 'sale_no' => $sale_no], $this);
        }
    }

    public function my_orders_get()
    {
        if (!isset($this->auth_data->user_type) || $this->auth_data->user_type !== 'customer') {
            json_response(REST_Controller::HTTP_FORBIDDEN, 'error', 'This action is only allowed for customers.', null, $this);
            return;
        }
        $customer_id = $this->auth_data->customer_id;
        $this->db->select('s.id, s.sale_no, s.total_payable, s.sale_date, s.order_status, s.is_accept, o.outlet_name');
        $this->db->from('tbl_kitchen_sales s');
        $this->db->join('tbl_outlets o', 'o.id = s.outlet_id', 'left');
        $this->db->where('s.customer_id', $customer_id);
        $this->db->where('s.is_online_order', 'Yes');
        $this->db->order_by('s.id', 'DESC');
        $orders = $this->db->get()->result();
        if (empty($orders)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Customer orders retrieved.', [], $this);
            return;
        }
        $sale_ids = array_column($orders, 'id');
        $this->db->select('ksd.id, ksd.sales_id, ksd.food_menu_id, ksd.menu_name, ksd.qty, ksd.menu_unit_price, ksd.menu_note, fm.photo');
        $this->db->from('tbl_kitchen_sales_details ksd');
        $this->db->join('tbl_food_menus fm', 'fm.id = ksd.food_menu_id', 'left');
        $this->db->where_in('ksd.sales_id', $sale_ids);
        $items_result = $this->db->get()->result();
        $items_map = [];
        foreach ($items_result as $item) {
            $items_map[$item->sales_id][] = $item;
        }
        $item_detail_ids = array_column($items_result, 'id');
        $modifiers_map = [];
        if (!empty($item_detail_ids)) {
            $this->db->select('ksdm.sales_details_id, ksdm.modifier_id, ksdm.modifier_price, m.name as modifier_name');
            $this->db->from('tbl_kitchen_sales_details_modifiers ksdm');
            $this->db->join('tbl_modifiers m', 'm.id = ksdm.modifier_id', 'left');
            $this->db->where_in('ksdm.sales_details_id', $item_detail_ids);
            $modifiers_result = $this->db->get()->result();
            foreach ($modifiers_result as $modifier) {
                $modifiers_map[$modifier->sales_details_id][] = $modifier;
            }
        }
        foreach ($orders as $order) {
            $order_items = isset($items_map[$order->id]) ? $items_map[$order->id] : [];
            foreach ($order_items as $item) {
                $item->modifiers = isset($modifiers_map[$item->id]) ? $modifiers_map[$item->id] : [];
            }
            $order->items = $order_items;
        }
        json_response(REST_Controller::HTTP_OK, 'success', 'Customer orders retrieved.', $orders, $this);
    }

    public function profile_stats_get()
    {
        if (!isset($this->auth_data->user_type) || $this->auth_data->user_type !== 'customer') {
            json_response(REST_Controller::HTTP_FORBIDDEN, 'error', 'This action is only allowed for customers.', null, $this);
            return;
        }
        $customer_id = $this->auth_data->customer_id;

        
        $this->db->where('customer_id', $customer_id);
        $this->db->where('is_online_order', 'Yes');
        $this->db->from('tbl_kitchen_sales');
        $total_orders = $this->db->count_all_results();

        
        $this->db->select_sum('sd.loyalty_point_earn');
        $this->db->from('tbl_sales_details sd');
        $this->db->join('tbl_sales s', 's.id = sd.sales_id');
        $this->db->where('s.customer_id', $customer_id);
        $earned_points = (int) $this->db->get()->row('loyalty_point_earn');

        $this->db->select_sum('sp.usage_point');
        $this->db->from('tbl_sale_payments sp');
        $this->db->join('tbl_sales s', 's.id = sp.sale_id');
        $this->db->where('s.customer_id', $customer_id);
        $this->db->where('sp.payment_id', 5);  
        $redeemed_points = (int) $this->db->get()->row('usage_point');

        $loyalty_points = $earned_points - $redeemed_points;

        $stats_data = [
            'total_orders' => (int) $total_orders,
            'loyalty_points' => (int) $loyalty_points,
        ];

        json_response(REST_Controller::HTTP_OK, 'success', 'Profile stats retrieved.', $stats_data, $this);
    }
}
