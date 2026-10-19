<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Delivery_partners extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_delivery_partner_model', 'delivery_partner_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;

        if ($id > 0) {
            $data = $this->delivery_partner_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Delivery partner found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Delivery partner not found.', null, $this);
            }
        } else {
            $data = $this->delivery_partner_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Delivery partners list.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);

        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('name', 'Name', 'required|max_length[50]');
        
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        
        $partner_data = [
            'name' => $request_data['name'],
            'description' => $request_data['description'] ?? null,
            'user_id' => $this->auth_data->user_id,
            'company_id' => $this->auth_data->company_id,
        ];

        $new_id = $this->delivery_partner_model->create($partner_data);
        if ($new_id) {
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Delivery partner created successfully.', ['id' => $new_id], $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create delivery partner.', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        unset($request_data['id'], $request_data['company_id'], $request_data['user_id']);

        if (empty($request_data)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Request body is empty.', null, $this);
        }
        
        $company_id = $this->auth_data->company_id;
        if ($this->delivery_partner_model->update($id, $request_data, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Delivery partner updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update delivery partner.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->delivery_partner_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Delivery partner deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete delivery partner.', null, $this);
        }
    }
}