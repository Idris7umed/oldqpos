<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Kitchen extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_kitchen_model', 'kitchen_model');
        $this->load->library('form_validation');
    }

   public function orders_get($kitchen_id = 0) 
{
    if (!$kitchen_id || !is_numeric($kitchen_id)) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'A valid Kitchen ID is required in the URL.', null, $this);
    }
    $orders = $this->kitchen_model->get_kitchen_orders($kitchen_id);
    json_response(REST_Controller::HTTP_OK, 'success', 'Kitchen orders retrieved.', $orders, $this);
}

    public function update_status_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);

        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('detail_id', 'Item Detail ID', 'required|numeric');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[Started Cooking,Done]');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $detail_id = $request_data['detail_id'];
        $status = $request_data['status'];

        if ($this->kitchen_model->update_item_status($detail_id, $status)) {
            
            json_response(REST_Controller::HTTP_OK, 'success', 'Item status updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update item status.', null, $this);
        }
    }
}