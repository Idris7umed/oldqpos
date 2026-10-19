<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Areas extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_area_model', 'area_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        if ($id > 0) {
            $data = $this->area_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Area found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Area not found.', null, $this);
            }
        } else {
            $data = $this->area_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Areas list.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('area_name', 'Area Name', 'required|max_length[250]');
        $this->form_validation->set_rules('outlet_id', 'Outlet', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $area_data = [
            'area_name' => $request_data['area_name'],
            'outlet_id' => $request_data['outlet_id'],
            'description' => $request_data['description'] ?? null,
            'company_id' => $this->auth_data->company_id,
        ];

        $new_id = $this->area_model->create($area_data);
        if ($new_id) {
            
            
            $new_area = $this->area_model->get_by_id($new_id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Area created successfully.', $new_area, $this);
            
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create area.', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        unset($request_data['id'], $request_data['company_id']);
        
        if (empty($request_data)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Request body is empty.', null, $this);
        }
        
        $company_id = $this->auth_data->company_id;
        if ($this->area_model->update($id, $request_data, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Area updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update area.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->area_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Area deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete area.', null, $this);
        }
    }
}