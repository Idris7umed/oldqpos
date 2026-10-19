<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Roles extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_role_model', 'role_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        if ($id > 0) {
            $data = $this->role_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Role found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Role not found.', null, $this);
            }
        } else {
            $data = $this->role_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Roles list.', $data, $this);
        }
    }

    public function permissions_get()
    {
        $data = $this->role_model->get_all_permissions();
        json_response(REST_Controller::HTTP_OK, 'success', 'Available permissions list.', $data, $this);
    }

    public function index_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('role_name', 'Role Name', 'required|max_length[250]');
        $this->form_validation->set_rules('permissions', 'Permissions', 'is_array');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $role_data = [
            'role_name' => $request_data['role_name'],
            'permissions' => $request_data['permissions'] ?? [],
            'company_id' => $this->auth_data->company_id,
        ];

        $new_id = $this->role_model->create($role_data);
        if ($new_id) {
            $new_role = $this->role_model->get_by_id($new_id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Role created successfully.', $new_role, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create role.', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        unset($request_data['id'], $request_data['company_id']);
        $company_id = $this->auth_data->company_id;
        
        if ($this->role_model->update($id, $request_data, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Role updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update role or not found.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->role_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Role deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete role.', null, $this);
        }
    }
}