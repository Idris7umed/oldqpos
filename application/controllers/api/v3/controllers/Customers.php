<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Customers extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_customer_model', 'customer_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        if ($id > 0) {
            $data = $this->customer_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Customer found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Customer not found.', null, $this);
            }
        } else {
            $data = $this->customer_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Customers list.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = $this->get_json_request_data(true);
        if (!$request_data) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid JSON payload.', null, $this);
            return;
        }

        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
            return;
        }

        $data = [
            'name' => $request_data['name'],
            'phone' => $request_data['phone'],
            'email' => $request_data['email'] ?? null,
            'address' => $request_data['address'] ?? null,
            'date_of_birth' => $request_data['date_of_birth'] ?? null,
            'date_of_anniversary' => $request_data['date_of_anniversary'] ?? null,
            'default_discount' => $request_data['default_discount'] ?? 0,
            'password_online_user' => isset($request_data['password_online_user']) ? md5($request_data['password_online_user']) : null,
            'gst_number' => $request_data['gst_number'] ?? null,
            'company_id' => $this->auth_data->company_id,
            'user_id' => $this->auth_data->user_id,
        ];

        $new_id = $this->customer_model->create($data);
        if ($new_id) {
            $new_customer = $this->customer_model->get_by_id($new_id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Customer created successfully.', $new_customer, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create customer.', null, $this);
        }
    }

    public function index_put($id)
    {
        $data = $this->put();
        unset($data['id'], $data['company_id']);
        $company_id = $this->auth_data->company_id;
        if ($this->customer_model->update($id, $data, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Customer updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update customer.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->customer_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Customer deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete customer.', null, $this);
        }
    }
    public function get_due_get($customer_id)
    {
        if (!$customer_id || !is_numeric($customer_id)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Valid Customer ID is required.', null, $this);
            return;
        }

        
        $company_id = $this->auth_data->company_id;

        
        $due_amount = $this->customer_model->get_customer_due($customer_id, $company_id);

        if ($due_amount === null) {
            
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Customer not found.', null, $this);
            return;
        }

        $response_data = [
            'due_amount' => (float)$due_amount
        ];

        json_response(REST_Controller::HTTP_OK, 'success', 'Customer due amount retrieved.', $response_data, $this);
    }
}
