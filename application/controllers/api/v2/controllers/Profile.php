<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Profile extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_profile_model', 'profile_model');
        $this->load->library('form_validation');
    }

    
    public function index_get()
    {
        $user_id = $this->auth_data->user_id;
        $profile = $this->profile_model->get_profile($user_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Profile data retrieved.', $profile, $this);
    }

    
    public function index_put()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        $user_id = $this->auth_data->user_id;

        
        
        if ($this->profile_model->update_profile($user_id, $request_data)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Profile updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update profile.', null, $this);
        }
    }

    
   public function change_password_post()
{
    $request_data = json_decode(file_get_contents('php://input'), true);
    $user_id = $this->auth_data->user_id;
    $this->form_validation->set_data($request_data);
    $this->form_validation->set_rules('old_password', 'Old Password', 'required');
    $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
    if ($this->form_validation->run() == FALSE) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
    }
    
    $user = $this->profile_model->get_user_by_id($user_id);
    
    $old_password_match = false;
    if ($user) {
        
        if (password_verify($request_data['old_password'], $user->password)) {
            $old_password_match = true;
        } 
        
        elseif (md5($request_data['old_password']) === $user->password) {
            $old_password_match = true;
        }
    }

    if ($old_password_match) {
        $new_password_hashed = password_hash($request_data['new_password'], PASSWORD_BCRYPT);
        if ($this->profile_model->update_profile($user_id, ['password' => $new_password_hashed])) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Password changed successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to change password.', null, $this);
        }
    } else {
        json_response(REST_Controller::HTTP_UNAUTHORIZED, 'error', 'Old password does not match.', null, $this);
    }
}
    
    
    public function change_pin_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        $user_id = $this->auth_data->user_id;

        
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('new_pin', 'New PIN', 'required|numeric|exact_length[4]');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        if ($this->profile_model->update_profile($user_id, ['login_pin' => $request_data['new_pin']])) {
            json_response(REST_Controller::HTTP_OK, 'success', 'PIN changed successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to change PIN.', null, $this);
        }
    }

    
    public function security_question_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        $user_id = $this->auth_data->user_id;

        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('question', 'Question', 'required');
        $this->form_validation->set_rules('answer', 'Answer', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $security_data = [
            'question' => $request_data['question'],
            'answer' => $request_data['answer']
        ];

        if ($this->profile_model->update_profile($user_id, $security_data)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Security question set successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to set security question.', null, $this);
        }
    }
}