<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Productions extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_production_model', 'production_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $outlet_id = $this->get('outlet_id');
        if (!$outlet_id) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required.', null, $this);
        }

        if ($id > 0) {
            $data = $this->production_model->get_by_id($id, $outlet_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Production record found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Production record not found.', null, $this);
            }
        } else {
            $data = $this->production_model->get_all($outlet_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Productions list.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);

        if ($request_data === null) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid JSON data.', null, $this);
        }

        
        if (isset($request_data['status'])) {
            $request_data['status'] = (string)$request_data['status'];
        }

        
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('outlet_id', 'Outlet', 'required|numeric');
        $this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[0,1]');
        
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        
        if (!isset($request_data['items']) || !is_array($request_data['items']) || empty($request_data['items'])) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Items field is required and must be a non-empty array.', null, $this);
        }

        
        foreach ($request_data['items'] as $index => $item) {
            if (!isset($item['ingredient_id']) || !is_numeric($item['ingredient_id'])) {
                json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', "Item #{$index}: Pre-made Food ID is required and must be numeric.", null, $this);
            }
            if (!isset($item['quantity_amount']) || !is_numeric($item['quantity_amount']) || $item['quantity_amount'] <= 0) {
                json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', "Item #{$index}: Quantity is required and must be greater than 0.", null, $this);
            }
        }

        $production_data = [
            'reference_no' => $request_data['reference_no'] ?? $this->production_model->generate_ref_no($request_data['outlet_id']),
            'date' => $request_data['date'],
            'status' => (int)$request_data['status'], 
            'items' => $request_data['items'],
            'outlet_id' => $request_data['outlet_id'],
            'user_id' => $this->auth_data->user_id,
        ];

        $this->production_model->auth_data = $this->auth_data;
        $new_id = $this->production_model->create_or_update($production_data);

        if ($new_id) {
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Production created successfully.', ['id' => $new_id], $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create production.', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = $this->get_json_request_data(true);

        if ($request_data === null || !is_array($request_data)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid JSON data.', null, $this);
        }

        
        if (isset($request_data['status'])) {
            $request_data['status'] = (string)$request_data['status'];
        }

        
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('outlet_id', 'Outlet', 'required|numeric');
        $this->form_validation->set_rules('user_id', 'User', 'required|numeric');
        $this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[0,1]');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        
        if (!isset($request_data['items']) || !is_array($request_data['items']) || empty($request_data['items'])) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Items field is required and must be a non-empty array.', null, $this);
        }

        
        foreach ($request_data['items'] as $index => $item) {
            if (!isset($item['ingredient_id']) || !is_numeric($item['ingredient_id'])) {
                json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', "Item #{$index}: Pre-made Food ID is required and must be numeric.", null, $this);
            }
            if (!isset($item['quantity_amount']) || !is_numeric($item['quantity_amount']) || $item['quantity_amount'] <= 0) {
                json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', "Item #{$index}: Quantity is required and must be greater than 0.", null, $this);
            }
        }

        $production_data = [
            'reference_no' => $request_data['reference_no'] ?? null,
            'date' => $request_data['date'],
            'status' => (int)$request_data['status'], 
            'items' => $request_data['items'],
            'outlet_id' => $request_data['outlet_id'],
            'user_id' => $request_data['user_id'],
        ];

        $this->production_model->auth_data = $this->auth_data;
        $result = $this->production_model->create_or_update($production_data, $id);

        if ($result) {
            $updated_data = $this->production_model->get_by_id($id, $request_data['outlet_id']);
            json_response(REST_Controller::HTTP_OK, 'success', 'Production updated successfully.', $updated_data, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update production.', null, $this);
        }
    }

public function index_delete($id)
{
    
    $request_data = json_decode(file_get_contents('php://input'), true);
    $outlet_id = isset($request_data['outlet_id']) ? $request_data['outlet_id'] : null;

    if (!$outlet_id) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required in request body.', null, $this);
    }
    if ($this->production_model->delete($id, $outlet_id)) {
        json_response(REST_Controller::HTTP_OK, 'success', 'Production deleted successfully.', null, $this);
    } else {
        json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete production.', null, $this);
    }
}

    public function valid_date($date)
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
}