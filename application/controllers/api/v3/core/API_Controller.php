<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class API_Controller extends REST_Controller
{
    protected $auth_data;

     public function __construct()
    {
        parent::__construct();
        $this->load->add_package_path(APPPATH . 'controllers/api/v2/');
        $this->load->library('jwt_lib');
        $this->load->helper('api_helper'); 
        $this->load->helper('promotion_api_helper');      
        $controller_name = strtolower($this->router->fetch_class());
        if ($controller_name === 'auth' || $controller_name === 'publicapi') {
            return; 
        }
        try {
            $token = $this->get_token_from_header();
            if (!$token) {
                json_response(REST_Controller::HTTP_UNAUTHORIZED, 'error', 'Authorization header is missing or token is invalid.', null, $this);
            }
            $validation = $this->jwt_lib->validate($token);

            if ($validation['status']) {
                $this->auth_data = $validation['data'];
            } else {
                json_response(REST_Controller::HTTP_UNAUTHORIZED, 'error', $validation['message'], null, $this);
            }
        } catch (Exception $e) {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'An unexpected error occurred.', null, $this);
        }
    }

    protected function get_json_request_data()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        }
        return is_array($data) ? $data : [];
    }

    private function get_token_from_header()
    {
        $auth_header = $this->input->get_request_header('Authorization', TRUE);
        if ($auth_header && preg_match('/Bearer\s(\S+)/', $auth_header, $matches)) {
            return $matches[1];
        }
        return null;
    }
}