<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Tables extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_table_model', 'table_model');
        
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        if ($id > 0) {
            $data = $this->table_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Table found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Table not found.', null, $this);
            }
        } else {
            $area_id = $this->get('area_id') ? (int)$this->get('area_id') : null;
            $data = $this->table_model->get_all($company_id, $area_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Tables list.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('name', 'Table Name', 'required|max_length[50]');
        $this->form_validation->set_rules('area', 'Area', 'required|numeric');
        $this->form_validation->set_rules('sit_capacity', 'Sit Capacity', 'required|max_length[50]');
        
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $table_data = [
            'name' => $request_data['name'],
            'area' => $request_data['area'],
            'sit_capacity' => $request_data['sit_capacity'],
            'position' => $request_data['position'] ?? null,
            'description' => $request_data['description'] ?? null,
            'user_id' => $this->auth_data->user_id,
            'company_id' => $this->auth_data->company_id,
        ];

        $new_id = $this->table_model->create($table_data);
        if ($new_id) {
            
            
            $new_table = $this->table_model->get_by_id($new_id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Table created successfully.', $new_table, $this);
            
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create table. Invalid area ID?', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        unset($request_data['id'], $request_data['company_id'], $request_data['user_id'], $request_data['outlet_id']);
        
        if (empty($request_data)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Request body is empty.', null, $this);
        }

        $company_id = $this->auth_data->company_id;
        if ($this->table_model->update($id, $request_data, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Table updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update table.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->table_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Table deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete table.', null, $this);
        }
    }
}