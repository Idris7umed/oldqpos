<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Ingredients extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_ingredient_model', 'ingredient_model');
        $this->load->helper('array');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        if ($id > 0) {
            $data = $this->ingredient_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Ingredient found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Ingredient not found.', null, $this);
            }
        } else {
            $data = $this->ingredient_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Ingredients list.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = $this->get_json_request_data();

        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('name', 'Name', 'required|max_length[50]');
        $this->form_validation->set_rules('category_id', 'Category', 'required|numeric');
        $this->form_validation->set_rules('purchase_price', 'Purchase Price', 'required|numeric');
        $this->form_validation->set_rules('purchase_unit_id', 'Purchase Unit', 'required|numeric');
        $this->form_validation->set_rules('consumption_unit_id', 'Consumption Unit', 'required|numeric');
        $this->form_validation->set_rules('conversion_rate', 'Conversion Rate', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $data = [
            'name' => element('name', $request_data),
            'category_id' => element('category_id', $request_data),
            'purchase_price' => element('purchase_price', $request_data),
            'alert_quantity' => element('alert_quantity', $request_data, 0),
            'purchase_unit_id' => element('purchase_unit_id', $request_data),
            'unit_id' => element('consumption_unit_id', $request_data), 
            'conversion_rate' => element('conversion_rate', $request_data),
            'consumption_unit_cost' => element('consumption_unit_cost', $request_data),
            'code' => element('code', $request_data) ? element('code', $request_data) : uniqid(),
            'company_id' => $this->auth_data->company_id,
            'user_id' => $this->auth_data->user_id,
        ];

        $new_id = $this->ingredient_model->create($data);

        if ($new_id) {
            $new_ingredient_data = $this->ingredient_model->get_by_id($new_id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Ingredient created successfully.', $new_ingredient_data, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create ingredient.', null, $this);
        }
    }

    public function index_put($id)
    {
        $data = $this->put();
        unset($data['id'], $data['company_id']);
        $company_id = $this->auth_data->company_id;
        if ($this->ingredient_model->update($id, $data, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Ingredient updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update ingredient.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->ingredient_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Ingredient deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete ingredient.', null, $this);
        }
    }
}