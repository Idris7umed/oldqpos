<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Payment_methods extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_payment_method_model', 'payment_method_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        if ($id > 0) {
            $data = $this->payment_method_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Payment method found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Payment method not found.', null, $this);
            }
        } else {
            $data = $this->payment_method_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Payment methods list.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('name', 'Name', 'required|max_length[50]');
        
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $payment_data = [
            'name' => $request_data['name'],
            'description' => $request_data['description'] ?? null,
            'user_id' => $this->auth_data->user_id,
            'company_id' => $this->auth_data->company_id,
        ];
        
        $new_id = $this->payment_method_model->create($payment_data);
        if ($new_id) {
            
            $new_payment_method = $this->payment_method_model->get_by_id($new_id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Payment method created successfully.', $new_payment_method, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create payment method.', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        unset($request_data['id'], $request_data['company_id'], $request_data['user_id']);
        
        if (empty($request_data)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Request body is empty.', null, $this);
        }

        $company_id = $this->auth_data->company_id;
        if ($this->payment_method_model->update($id, $request_data, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Payment method updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update payment method.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->payment_method_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Payment method deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete payment method or it cannot be deleted.', null, $this);
        }
    }
}