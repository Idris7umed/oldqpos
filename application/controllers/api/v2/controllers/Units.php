<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Units extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_unit_model', 'unit_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        if ($id > 0) {
            $data = $this->unit_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Unit found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Unit not found.', null, $this);
            }
        } else {
            $data = $this->unit_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Units list.', $data, $this);
        }
    }

    public function index_post()
    {
        
        $request_data = $this->get_json_request_data(true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('unit_name', 'Unit Name', 'required|max_length[50]'); 
        
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $unit_data = [
            'unit_name' => $request_data['unit_name'],
            'description' => $request_data['description'] ?? null,
            'company_id' => $this->auth_data->company_id,
        ];

        $new_id = $this->unit_model->create($unit_data);
        if ($new_id) {
            
            $new_unit_data = $this->unit_model->get_by_id($new_id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Unit created successfully.', $new_unit_data, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create unit.', null, $this);
        }
    }

    public function index_put($id)
    {
        
        $request_data = $this->get_json_request_data(true);
        unset($request_data['id'], $request_data['company_id']);
        
        if (empty($request_data)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Request body is empty.', null, $this);
        }

        $company_id = $this->auth_data->company_id;
        if ($this->unit_model->update($id, $request_data, $company_id)) {
            $updated_unit_data = $this->unit_model->get_by_id($id, $company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Unit updated successfully.', $updated_unit_data, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update unit.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->unit_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Unit deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete unit.', null, $this);
        }
    }
}