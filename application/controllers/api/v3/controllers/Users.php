<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Users extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_user_model', 'user_model');
        $this->load->library('form_validation');
        $this->load->helper('array');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        if ($id > 0) {
            $user = $this->user_model->get_by_id($id, $company_id);
            if ($user) {
                json_response(REST_Controller::HTTP_OK, 'success', 'User found.', $user, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'User not found.', null, $this);
            }
        } else {
            $users = $this->user_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Users list.', $users, $this);
        }
    }

    public function index_post()
    {
        $request_data = $this->get_json_request_data();
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('full_name', 'Full Name', 'required|max_length[50]');
        $this->form_validation->set_rules('email_address', 'Email', 'required|valid_email|is_unique[tbl_users.email_address]');
        $this->form_validation->set_rules('outlets', 'Outlets', 'required');

        if (element('will_login', $request_data, 'No') == 'Yes') {
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('role_id', 'Role', 'required|numeric');
            if(element('login_pin', $request_data)){
                 $this->form_validation->set_rules('login_pin', 'Login PIN', 'numeric|exact_length[4]|is_unique[tbl_users.login_pin]');
            }
        }

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $user_data = [
            'full_name' => element('full_name', $request_data),
            'email_address' => element('email_address', $request_data),
            'password' => element('password', $request_data),
            'phone' => element('phone', $request_data),
            'designation' => element('designation', $request_data),
            'role_id' => element('role_id', $request_data),
            'outlets' => element('outlets', $request_data),
            'will_login' => element('will_login', $request_data, 'No'),
            'login_pin' => element('login_pin', $request_data),
            'kitchens' => element('kitchens', $request_data),
    'order_receiving_id' => element('order_receiving_id', $request_data, 0),
            'active_status' => element('active_status', $request_data, 'Active'),
            'del_status' => 'Live',
            'company_id' => $this->auth_data->company_id,
            'created_id' => $this->auth_data->user_id,
        ];

        $new_id = $this->user_model->create($user_data);
        if ($new_id) {
            $new_user_data = $this->user_model->get_by_id($new_id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'User created successfully.', $new_user_data, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create user.', null, $this);
        }
    }

  public function index_put($id)
{
    $request_data = $this->get_json_request_data();
    if (empty($request_data)) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'No data provided for update.', null, $this);
        return;
    }

    $this->form_validation->set_data($request_data);
    $has_validation_rules = false;

    

    if (array_key_exists('full_name', $request_data)) {
        $this->form_validation->set_rules('full_name', 'Full Name', 'required|max_length[50]');
        $has_validation_rules = true;
    }

    if (array_key_exists('email_address', $request_data)) {
        $user = $this->user_model->get_by_id($id, $this->auth_data->company_id);
        if ($user && strtolower($request_data['email_address']) != strtolower($user->email_address)) {
            $this->form_validation->set_rules('email_address', 'Email', 'required|valid_email|is_unique[tbl_users.email_address]');
        } else {
            $this->form_validation->set_rules('email_address', 'Email', 'required|valid_email');
        }
        $has_validation_rules = true;
    }
    
    if (array_key_exists('password', $request_data) && !empty($request_data['password'])) {
        $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
        $has_validation_rules = true;
    }

    if (array_key_exists('login_pin', $request_data) && !empty($request_data['login_pin'])) {
        $user = $this->user_model->get_by_id($id, $this->auth_data->company_id);
        if($user && $request_data['login_pin'] != $user->login_pin){
            $this->form_validation->set_rules('login_pin', 'Login PIN', 'numeric|exact_length[4]|is_unique[tbl_users.login_pin]');
        }else{
            $this->form_validation->set_rules('login_pin', 'Login PIN', 'numeric|exact_length[4]');
        }
        $has_validation_rules = true;
    }

    

    
    
    if ($has_validation_rules && $this->form_validation->run() == FALSE) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        return;
    }

    
    unset($request_data['id'], $request_data['company_id']);
    
    $company_id = $this->auth_data->company_id;
    if ($this->user_model->update($id, $request_data, $company_id)) {
        $updated_user_data = $this->user_model->get_by_id($id, $company_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'User updated successfully.', $updated_user_data, $this);
    } else {
        json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update user.', null, $this);
    }
}
    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->user_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'User deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete user.', null, $this);
        }
    }
}