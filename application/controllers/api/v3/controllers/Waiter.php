<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Waiter extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_waiter_model', 'waiter_model');
        $this->load->library('form_validation');
    }

    public function notifications_get()
    {
        $waiter_id = $this->auth_data->user_id;
        $notifications = $this->waiter_model->get_notifications($waiter_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Notifications retrieved.', $notifications, $this);
    }

    public function mark_as_viewed_post()
    {
        $request_data = $this->get_json_request_data(true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('notification_ids', 'Notification IDs', 'required|is_array');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $notification_ids = $request_data['notification_ids'];
        $waiter_id = $this->auth_data->user_id;

        if ($this->waiter_model->mark_as_viewed($notification_ids, $waiter_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Notifications marked as viewed.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update notifications.', null, $this);
        }
    }
    
    
    public function new_orders_ajax_get()
    {
        $outlet_id = $this->auth_data->outlet_id;
        $waiter_id = $this->auth_data->user_id;
        $data = $this->waiter_model->get_new_orders($outlet_id, $waiter_id);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    
    public function order_details_ajax_post()
    {
        $request_data = $this->get_json_request_data(true);
        $sale_id = $request_data['sale_id'] ?? null;

        if(!$sale_id){
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Sale ID is required.', null, $this);
        }
        
        $sale_object = $this->waiter_model->get_order_details($sale_id);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($sale_object));
    }
}