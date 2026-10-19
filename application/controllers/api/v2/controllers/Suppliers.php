<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Suppliers extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_supplier_model', 'supplier_model');
        
        $this->load->model('Supplier_payment_model'); 
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;

        if ($id > 0) {
            $data = $this->supplier_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Supplier found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Supplier not found.', null, $this);
            }
        } else {
            $data = $this->supplier_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Suppliers list.', $data, $this);
        }
    }

    public function index_post()
    {
        
        $request_data = json_decode(file_get_contents('php://input'), true);

        $this->load->library('form_validation');
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $data = [
            'name' => $request_data['name'],
            'contact_person' => $request_data['contact_person'] ?? null,
            'phone' => $request_data['phone'],
            'email' => $request_data['email'] ?? null,
            'address' => $request_data['address'] ?? null,
            'description' => $request_data['description'] ?? null,
            'company_id' => $this->auth_data->company_id,
            'user_id' => $this->auth_data->user_id,
        ];

        $new_id = $this->supplier_model->create($data);
        if ($new_id) {
            
            $new_supplier = $this->supplier_model->get_by_id($new_id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Supplier created successfully.', $new_supplier, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create supplier.', null, $this);
        }
    }

    public function index_put($id)
    {
        $data = $this->put();
        unset($data['id'], $data['company_id']);

        $company_id = $this->auth_data->company_id;

        if ($this->supplier_model->update($id, $data, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Supplier updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update supplier.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->supplier_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Supplier deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete supplier.', null, $this);
        }
    }
    
    public function get_due_get($supplier_id)
{
    if (!$supplier_id || !is_numeric($supplier_id)) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Valid Supplier ID is required.', null, $this);
    }
    
    
    $outlet_id = $this->get('outlet_id');

    
    if (!$outlet_id) {
        
        
        $outlet_id = $this->session->userdata('outlet_id');
        if (!$outlet_id) {
             json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'outlet_id query parameter is required.', null, $this);
             return;
        }
    }
    
    
    $this->session->set_userdata('outlet_id', $outlet_id);

    $remaining_due = $this->Supplier_payment_model->getSupplierDue($supplier_id);
    $response_data = [
        'due_amount' => $remaining_due ? (float)$remaining_due : 0.0
    ];
    json_response(REST_Controller::HTTP_OK, 'success', 'Supplier due amount retrieved.', $response_data, $this);
}
}
