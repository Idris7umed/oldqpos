<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Kitchens extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_kitchens_model', 'kitchens_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        if ($id > 0) {
            $data = $this->kitchens_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Kitchen found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Kitchen not found.', null, $this);
            }
        } else {
            $data = $this->kitchens_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Kitchens list retrieved.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        if (!$request_data) {
            $request_data = $this->post(); 
        }

        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('name', 'Name', 'required|max_length[50]');
        $this->form_validation->set_rules('outlet_id', 'Outlet', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $kitchen_data = [
            'name' => $request_data['name'],
            'outlet_id' => $request_data['outlet_id'],
            'printer_id' => $request_data['printer_id'] ?? null,
            'company_id' => $this->auth_data->company_id,
        ];
        $categories = $request_data['item_check'] ?? [];

        $new_id = $this->kitchens_model->create($kitchen_data, $categories);

        if ($new_id) {
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Kitchen created successfully.', ['id' => $new_id], $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create kitchen.', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = json_decode(file_get_contents('php://input'), true);

        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('name', 'Name', 'required|max_length[50]');
        $this->form_validation->set_rules('outlet_id', 'Outlet', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $kitchen_data = [
            'name' => $request_data['name'],
            'outlet_id' => $request_data['outlet_id'],
            'printer_id' => $request_data['printer_id'] ?? null,
        ];
        $categories = $request_data['item_check'] ?? [];
        $company_id = $this->auth_data->company_id;

        if ($this->kitchens_model->update($id, $kitchen_data, $categories, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Kitchen updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update kitchen.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->kitchens_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Kitchen deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete kitchen.', null, $this);
        }
    }

    public function categories_get($outlet_id)
    {
         if(is_null($outlet_id) || !is_numeric($outlet_id)){
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID required', null, $this);
    }
    $company_id = $this->auth_data->company_id;
    
    $categories = $this->kitchens_model->get_available_categories($company_id, $outlet_id);

        if ($categories) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Categories list retrieved.', $categories, $this);
        } else {
            json_response(REST_Controller::HTTP_OK, 'success', 'No categories found.', [], $this);
        }
    }
}