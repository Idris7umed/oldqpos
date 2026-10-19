<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Denominations extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_denomination_model', 'denomination_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;

        if ($id > 0) {
            $data = $this->denomination_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Denomination found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Denomination not found.', null, $this);
            }
        } else {
            $data = $this->denomination_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Denominations list.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);

        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]');
        
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        
        $denomination_data = [
            'amount' => $request_data['amount'],
            'description' => $request_data['description'] ?? null,
            'company_id' => $this->auth_data->company_id,
        ];

        $new_id = $this->denomination_model->create($denomination_data);
        if ($new_id) {
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Denomination created successfully.', ['id' => $new_id], $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create denomination.', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        unset($request_data['id'], $request_data['company_id']);

        if (empty($request_data)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Request body is empty.', null, $this);
        }
        
        $company_id = $this->auth_data->company_id;
        if ($this->denomination_model->update($id, $request_data, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Denomination updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update denomination.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->denomination_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Denomination deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete denomination.', null, $this);
        }
    }
}