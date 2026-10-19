<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Premade_foods extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_premade_food_model', 'premade_food_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        if ($id > 0) {
            $data = $this->premade_food_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Pre-made food found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Pre-made food not found.', null, $this);
            }
        } else {
            $data = $this->premade_food_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Pre-made foods list.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        $this->_validate_input($request_data);

        $premade_data = $this->_prepare_data($request_data);
        $new_id = $this->premade_food_model->create_or_update($premade_data);

        if ($new_id) {
            $new_item = $this->premade_food_model->get_by_id($new_id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Pre-made food created successfully.', $new_item, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create pre-made food.', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        $this->_validate_input($request_data);
        
        $premade_data = $this->_prepare_data($request_data);
        
        if ($this->premade_food_model->create_or_update($premade_data, $id)) {
            $updated_item = $this->premade_food_model->get_by_id($id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Pre-made food updated successfully.', $updated_item, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update pre-made food.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->premade_food_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Pre-made food deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete pre-made food.', null, $this);
        }
    }
    
    private function _validate_input($data) {
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('name', 'Name', 'required|max_length[50]');
        $this->form_validation->set_rules('category_id', 'Category', 'required|numeric');
        $this->form_validation->set_rules('purchase_price', 'Total Cost', 'required|numeric');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required|numeric');
        $this->form_validation->set_rules('ingredients', 'Ingredients', 'is_array');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
    }

    private function _prepare_data($request_data) {
        return [
            'name' => $request_data['name'],
            'code' => $request_data['code'] ?? 'PM-' . uniqid(),
            'category_id' => $request_data['category_id'],
            'purchase_price' => $request_data['purchase_price'], 
            'alert_quantity' => $request_data['alert_quantity'] ?? 0,
            'unit_id' => $request_data['unit_id'],
            'purchase_unit_id' => $request_data['unit_id'], 
            'consumption_unit_cost' => $request_data['purchase_price'],
            'conversion_rate' => 1,
            'ingredients' => $request_data['ingredients'] ?? [],
            'user_id' => $this->auth_data->user_id,
            'company_id' => $this->auth_data->company_id,
        ];
    }
}