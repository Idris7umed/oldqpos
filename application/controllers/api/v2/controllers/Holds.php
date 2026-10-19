<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Holds extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_hold_model', 'hold_model');
        $this->load->library('form_validation');
    }

   public function index_get($id = 0)
    {
        $outlet_id = $this->get('outlet_id');
        if (!$outlet_id) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required.', null, $this);
        }

        if ($id > 0) {
            $data = $this->hold_model->get_by_id($id, $outlet_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Hold found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Hold not found.', null, $this);
            }
        } else {
            
            
            $user_id = $this->auth_data->user_id;

            
            $data = $this->hold_model->get_all($outlet_id, $user_id);
            

            json_response(REST_Controller::HTTP_OK, 'success', 'Holds list.', $data, $this);
        }
    }

    public function index_post()
    {
        
        
        $request_data = $this->input->post();
        

        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('outlet_id', 'Outlet', 'required|numeric');
        $this->form_validation->set_rules('customer_id', 'Customer', 'required|numeric');
        
        
        
        if (!isset($request_data['items']) || !is_array($request_data['items'])) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'The Items field is required.', null, $this);
        }
        

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        
        $request_data['user_id'] = $this->auth_data->user_id;
        $result = $this->hold_model->create_or_update($request_data);

        if ($result['status']) {
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Hold created successfully.', ['id' => $result['hold_id']], $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', $result['message'], null, $this);
        }
    }

    public function index_put($id)
    {
        
        
        $request_data = $this->input->post();
        
        $request_data['user_id'] = $this->auth_data->user_id;

        $result = $this->hold_model->create_or_update($request_data, $id);
        
        if ($result['status']) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Hold updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', $result['message'], null, $this);
        }
    }        public function index_delete($id)
    {
        
        
        $request_data = json_decode(file_get_contents('php://input'), true);
        $outlet_id = $request_data['outlet_id'] ?? null;
        

        if (!$outlet_id) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required.', null, $this);
        }
        
        if ($this->hold_model->delete($id, $outlet_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Hold deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete hold.', null, $this);
        }
    }
      public function finalize_post($id)
    {
        $request_data = json_decode(file_get_contents('php://input'), true);

        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        $this->form_validation->set_rules('payments', 'Payments', 'required|is_array|min_length[1]');
        $this->form_validation->set_rules('payments[*][payment_method_id]', 'Payment Method ID', 'required|numeric');
        $this->form_validation->set_rules('payments[*][amount]', 'Amount', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $outlet_id = (int)$request_data['outlet_id'];
        
        
        $this->hold_model->auth_data = $this->auth_data;
        
        $result = $this->hold_model->finalize_hold($id, $request_data, $outlet_id);

        if ($result['status']) {
            $response_data = [
                'sale_id' => $result['sale_id'],
                'sale_no' => $result['sale_no']
            ];
            json_response(REST_Controller::HTTP_OK, 'success', 'Hold finalized into a sale successfully.', $response_data, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', $result['message'], null, $this);
        }
    }
}