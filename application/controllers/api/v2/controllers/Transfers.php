<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Transfers extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_transfer_model', 'transfer_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        $outlet_id = $this->get('outlet_id') ? (int) $this->get('outlet_id') : null;

        if ($id > 0) {
            $data = $this->transfer_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Transfer found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Transfer not found.', null, $this);
            }
        } else {
            $data = $this->transfer_model->get_all($company_id, $outlet_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Transfers list.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = $this->get_json_request_data(true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('from_outlet_id', 'From Outlet', 'required|numeric');
        $this->form_validation->set_rules('to_outlet_id', 'To Outlet', 'required|numeric|differs[from_outlet_id]');
        $this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
        if (!isset($request_data['items']) || !is_array($request_data['items']) || empty($request_data['items'])) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Items are required and must be a non-empty array.', null, $this);
        }
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $transfer_data = [
            'from_outlet_id' => $request_data['from_outlet_id'],
            'to_outlet_id' => $request_data['to_outlet_id'],
            'date' => $request_data['date'],
            'items' => $request_data['items'],
            'reference_no' => $this->transfer_model->generate_ref_no($request_data['from_outlet_id']),
            'status' => $request_data['status'] ?? 2,  
            'user_id' => $this->auth_data->user_id,
            'outlet_id' => $request_data['from_outlet_id'],
            'note_for_sender' => $request_data['note'] ?? null
        ];
        $new_id = $this->transfer_model->create($transfer_data);
        if ($new_id) {
            $new_data = $this->transfer_model->get_by_id($new_id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Transfer created successfully.', $new_data, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create transfer.', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = json_decode(file_get_contents('php://input'), true);

        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[1,3]');  

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $update_data = [
            'status' => $request_data['status'],
            'note_for_receiver' => $request_data['note'] ?? ''
        ];
        if ($request_data['status'] == 1) {
            $update_data['received_date'] = date('Y-m-d H:i:s');
        }
        $company_id = $this->auth_data->company_id;
     
        if ($this->transfer_model->update_status($id, $update_data, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Transfer status updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update transfer status.', null, $this);
        }

    }

    public function index_delete($id)
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        $from_outlet_id = $request_data['from_outlet_id'] ?? null;

        if (!$from_outlet_id) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'From Outlet ID is required in request body.', null, $this);
        }

        $company_id = $this->auth_data->company_id;
        $this->transfer_model->auth_data = $this->auth_data;

        if ($this->transfer_model->delete($id, $company_id, $from_outlet_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Transfer deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', "Failed to delete transfer. It might be received or you don't have permission.", null, $this);
        }
    }

    public function valid_date($date)
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
}
