<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Currencies extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_currency_model', 'currency_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        
        $company_id = $this->auth_data->company_id;

        if ($id > 0) {
            $data = $this->currency_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Currency found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Currency not found.', null, $this);
            }
        } else {
            $data = $this->currency_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Currencies list.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);

        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('currency', 'Currency Code', 'required|max_length[10]');
        $this->form_validation->set_rules('conversion_rate', 'Conversion Rate', 'required|numeric|greater_than[0]');
        
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        
        $currency_data = [
            'currency' => $request_data['currency'],
            'conversion_rate' => $request_data['conversion_rate'],
            'company_id' => $this->auth_data->company_id,
        ];

        $new_id = $this->currency_model->create($currency_data);
        if ($new_id) {
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Currency created successfully.', ['id' => $new_id], $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create currency.', null, $this);
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
        if ($this->currency_model->update($id, $request_data, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Currency updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update currency.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->currency_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Currency deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete currency.', null, $this);
        }
    }
}