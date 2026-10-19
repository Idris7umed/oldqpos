<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Counters extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_counter_model', 'counter_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        if ($id > 0) {
            $data = $this->counter_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Counter found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Counter not found.', null, $this);
            }
        } else {
            $data = $this->counter_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Counters list.', $data, $this);
        }
    }

    public function index_post()
    {
        
        $request_data = json_decode(file_get_contents('php://input'), true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('name', 'Counter Name', 'required|max_length[55]');
        $this->form_validation->set_rules('outlet_id', 'Outlet', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        
        $counter_data = [
            'name' => $request_data['name'],
            'outlet_id' => $request_data['outlet_id'],
            
            'invoice_printer_id' => !empty($request_data['invoice_printer_id']) ? $request_data['invoice_printer_id'] : 0,
            'bill_printer_id' => !empty($request_data['bill_printer_id']) ? $request_data['bill_printer_id'] : 0,
            'description' => $request_data['description'] ?? null,
            'user_id' => $this->auth_data->user_id,
            'company_id' => $this->auth_data->company_id,
            'added_date' => date('Y-m-d H:i:s')
        ];
        
        $new_id = $this->counter_model->create($counter_data);
        if ($new_id) {
            $new_counter = $this->counter_model->get_by_id($new_id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Counter created successfully.', $new_counter, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create counter.', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        unset($request_data['id'], $request_data['company_id'], $request_data['user_id']);
        
        if (empty($request_data)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Request body is empty.', null, $this);
        }

        
        if(array_key_exists('invoice_printer_id', $request_data) && empty($request_data['invoice_printer_id'])){
            $request_data['invoice_printer_id'] = 0;
        }
        if(array_key_exists('bill_printer_id', $request_data) && empty($request_data['bill_printer_id'])){
            $request_data['bill_printer_id'] = 0;
        }

        $company_id = $this->auth_data->company_id;
        if ($this->counter_model->update($id, $request_data, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Counter updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update counter.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->counter_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Counter deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete counter.', null, $this);
        }
    }
}