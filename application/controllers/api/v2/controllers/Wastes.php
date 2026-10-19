<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Wastes extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_waste_model', 'waste_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $outlet_id = $this->get('outlet_id');
        if (!$outlet_id) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required.', null, $this);
        }
        if ($id > 0) {
            $data = $this->waste_model->get_by_id($id, $outlet_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Waste record found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Waste record not found.', null, $this);
            }
        } else {
            $data = $this->waste_model->get_all($outlet_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Wastes list retrieved.', $data, $this);
        }
    }

public function index_post()
{
    $request_data = $this->get_json_request_data(true);
    $this->form_validation->set_data($request_data);
    $this->form_validation->set_rules('outlet_id', 'Outlet', 'required|numeric');
    $this->form_validation->set_rules('employee_id', 'Responsible Person', 'required|numeric');
    $this->form_validation->set_rules('date', 'Date', 'required');

    if (!isset($request_data['items']) || !is_array($request_data['items']) || empty($request_data['items'])) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Items are required and must be a non-empty array.', null, $this);
    }
    if ($this->form_validation->run() == FALSE) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
    }

    $waste_data = [
        'reference_no' => $this->waste_model->generate_ref_no($request_data['outlet_id']),
        'outlet_id' => $request_data['outlet_id'],
        'date' => date('Y-m-d', strtotime($request_data['date'])),
        'employee_id' => $request_data['employee_id'],
        'note' => $request_data['note'] ?? null,
        'items' => $request_data['items'],
        'user_id' => $this->auth_data->user_id,
        
    ];

    $new_id = $this->waste_model->create($waste_data);
    
    if ($new_id) {
        $new_waste_data = $this->waste_model->get_by_id($new_id, $request_data['outlet_id']);
        json_response(REST_Controller::HTTP_CREATED, 'success', 'Waste record created successfully.', $new_waste_data, $this);
    } else {
        json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create waste record.', null, $this);
    }
}
public function index_put($id)
    {
        if (!$id) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Transfer ID is required.', null, $this);
        }

        $request_data = $this->get_json_request_data(true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('from_outlet_id', 'From Outlet', 'required|numeric');
        $this->form_validation->set_rules('to_outlet_id', 'To Outlet', 'required|numeric|differs[from_outlet_id]');
        $this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[1,2,3]');

        if (!isset($request_data['items']) || !is_array($request_data['items'])) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Items must be an array.', null, $this);
        }

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $transfer_data = [
            'from_outlet_id' => $request_data['from_outlet_id'],
            'to_outlet_id' => $request_data['to_outlet_id'],
            'date' => $request_data['date'],
            'items' => $request_data['items'],
            'status' => $request_data['status'],
            'user_id' => $this->auth_data->user_id,
            'company_id' => $this->auth_data->company_id,
            'outlet_id' => $request_data['from_outlet_id'],
            'note_for_sender' => $request_data['note'] ?? null,
            'note_for_receiver' => $request_data['note_for_receiver'] ?? null
        ];

        if ($this->transfer_model->update($id, $transfer_data)) {
            $updated_data = $this->transfer_model->get_by_id($id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Transfer updated successfully.', $updated_data, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update transfer.', null, $this);
        }
    }
    public function index_delete($id)
    {
        $request_data = $this->get_json_request_data(true);
        $outlet_id = $request_data['outlet_id'] ?? null;
        
        if (!$outlet_id) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required in request body.', null, $this);
        }

        if ($this->waste_model->delete($id, $outlet_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Waste record deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete waste record or not found.', null, $this);
        }
    }
}