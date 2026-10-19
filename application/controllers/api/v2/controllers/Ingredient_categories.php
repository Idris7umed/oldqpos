<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Ingredient_categories extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_ingredient_category_model', 'category_model');
        $this->load->library('form_validation');
        $this->load->helper('array'); 
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        if ($id > 0) {
            $data = $this->category_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Ingredient category found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Ingredient category not found.', null, $this);
            }
        } else {
            $data = $this->category_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Ingredient categories list.', $data, $this);
        }
    }

    public function index_post()
    {
        
        $request_data = $this->post();
        
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('category_name', 'Category Name', 'required|max_length[50]');
        
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $category_data = [
            'category_name' => element('category_name', $request_data),
            'description'   => element('description', $request_data, null),
            'user_id'       => $this->auth_data->user_id,
            'company_id'    => $this->auth_data->company_id
        ];

        $new_id = $this->category_model->create($category_data);

        if ($new_id) {
            $new_category_data = $this->category_model->get_by_id($new_id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Ingredient category created.', $new_category_data, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create category.', null, $this);
        }
    }

    public function index_put($id)
    {
        
        $request_data = $this->put();

        if (empty($request_data)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Request body is empty.', null, $this);
        }

        
        unset($request_data['id'], $request_data['company_id'], $request_data['user_id']);
        
        $company_id = $this->auth_data->company_id;
        if ($this->category_model->update($id, $request_data, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Ingredient category updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update category.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->category_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Ingredient category deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete category.', null, $this);
        }
    }
}