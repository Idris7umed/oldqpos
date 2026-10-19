<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Food_menu_categories extends API_Controller
{
   public function __construct()
{
    parent::__construct();
    
    $this->load->model('api_food_menu_category_model', 'category_model'); 
}

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;

        if ($id > 0) {
            $data = $this->category_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Category found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Category not found.', null, $this);
            }
        } else {
            $data = $this->category_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Categories list.', $data, $this);
        }
    }

    public function index_post()
    {
        $data = [
            'category_name' => $this->post('category_name'),
            'description' => $this->post('description'),
            'company_id' => $this->auth_data->company_id,
            'user_id' => $this->auth_data->user_id,
        ];
        
        if (empty($data['category_name'])) {
             json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Category name is required.', null, $this);
        }
        
        $new_id = $this->category_model->create($data);
        if ($new_id) {
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Category created successfully.', ['id' => $new_id], $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create category.', null, $this);
        }
    }

    public function index_put($id)
    {
        $data = $this->put();
        unset($data['id'], $data['company_id']); 
        
        $company_id = $this->auth_data->company_id;
        
        if ($this->category_model->update($id, $data, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Category updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update category.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->category_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Category deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete category.', null, $this);
        }
    }
}