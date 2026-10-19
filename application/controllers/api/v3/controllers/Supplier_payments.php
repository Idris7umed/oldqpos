<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Supplier_payments extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_supplier_payment_model', 'payment_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = null)
    {
        $outlet_id = $this->input->get('outlet_id');
        if (!$outlet_id) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required.', null, $this);
        }

        if ($id) {
            $data = $this->payment_model->get_by_id($id, $outlet_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Supplier payment details.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Record not found.', null, $this);
            }
        } else {
            $supplier_id = $this->input->get('supplier_id') ? (int)$this->input->get('supplier_id') : null;
            $data = $this->payment_model->get_all($outlet_id, $supplier_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Supplier payments list.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = $this->get_json_request_data(true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required|numeric');
        $this->form_validation->set_rules('outlet_id', 'Outlet', 'required|numeric');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('payment_id', 'Payment Method', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $payment_data = [
            'supplier_id'     => $request_data['supplier_id'],
            'outlet_id'       => $request_data['outlet_id'],
            'amount'          => $request_data['amount'],
            'date'            => $request_data['date'],
            'payment_id'      => $request_data['payment_id'],
            'note'            => $request_data['note'] ?? null,
            'user_id'         => $this->auth_data->user_id,
            'added_date_time' => date('Y-m-d H:i:s'),
            'del_status'      => 'Live'
        ];

        $new_id = $this->payment_model->create($payment_data);

        if ($new_id) {
            $new_data = $this->payment_model->get_by_id($new_id, $request_data['outlet_id']);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Supplier payment recorded successfully.', $new_data, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to record supplier payment.', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = $this->get_json_request_data(true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('outlet_id', 'Outlet', 'required|numeric');
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required|numeric');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('payment_id', 'Payment Method', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        
        $update_data = [
            'supplier_id' => $request_data['supplier_id'],
            'amount'      => $request_data['amount'],
            'date'        => $request_data['date'],
            'payment_id'  => $request_data['payment_id'],
            'note'        => $request_data['note'] ?? null,
            'user_id'     => $this->auth_data->user_id,
        ];

        if ($this->payment_model->update($id, $request_data['outlet_id'], $update_data)) {
            $updated_data = $this->payment_model->get_by_id($id, $request_data['outlet_id']);
            json_response(REST_Controller::HTTP_OK, 'success', 'Supplier payment record updated successfully.', $updated_data, $this);
        } else {
            json_response(REST_Controller::HTTP_NOT_MODIFIED, 'error', 'Record not found or failed to update.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $outlet_id = $this->input->get('outlet_id');
        if (!$outlet_id) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required.', null, $this);
        }
        
        $this->payment_model->delete($id, $outlet_id);
        
        if ($this->db->affected_rows() > 0) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Supplier payment record deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Record not found or already deleted.', null, $this);
        }
    }

    public function valid_date($date)
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
}