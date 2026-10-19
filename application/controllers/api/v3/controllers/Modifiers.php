<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Modifiers extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_modifier_model', 'modifier_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        if ($id > 0) {
            $data = $this->modifier_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Modifier found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Modifier not found.', null, $this);
            }
        } else {
            $data = $this->modifier_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Modifiers list.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('name', 'Name', 'required|max_length[50]');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        
        $modifier_data = [
            'name' => $request_data['name'],
            'price' => $request_data['price'],
            'description' => $request_data['description'] ?? null,
            'ingredients' => $request_data['ingredients'] ?? [],
            'user_id' => $this->auth_data->user_id,
            'company_id' => $this->auth_data->company_id,
        ];
        
        $new_id = $this->modifier_model->create($modifier_data);
        if ($new_id) {
            
            
            $new_modifier = $this->modifier_model->get_by_id($new_id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Modifier created successfully.', $new_modifier, $this);
            
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create modifier.', null, $this);
        }
    }

    public function index_put($id)
    {
        
        $request_data = json_decode(file_get_contents('php://input'), true);

        if (empty($request_data)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'No modifier data provided to update.', null, $this);
        }

        $company_id = $this->auth_data->company_id;
        $user_id = $this->auth_data->user_id; 

        
        
        $update_success = $this->modifier_model->update($id, $request_data, $company_id, $user_id);

        
        

        if ($update_success) { 
            $updated_modifier = $this->modifier_model->get_by_id($id, $company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Modifier updated successfully.', $updated_modifier, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update modifier.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->modifier_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Modifier deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete modifier.', null, $this);
        }
    }
}