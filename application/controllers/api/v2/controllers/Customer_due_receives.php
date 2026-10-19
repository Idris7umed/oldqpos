<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Customer_due_receives extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('api_customer_due_receive_model', 'due_receive_model');
        $this->load->library('form_validation');
    }

    
    public function index_get($id = null)
    {
        
        $outlet_id = $this->input->get('outlet_id');
        if (!$outlet_id) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required.', null, $this);
        }

        if ($id) {
            
            $data = $this->due_receive_model->get_by_id($id, $outlet_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Customer due receive details.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Record not found.', null, $this);
            }
        } else {
            
            $customer_id = $this->input->get('customer_id') ? (int)$this->input->get('customer_id') : null;
            $data = $this->due_receive_model->get_all($outlet_id, $customer_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Customer due receives list.', $data, $this);
        }
    }

    
    public function index_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        if (!$request_data) {
             json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid JSON payload.', null, $this);
        }
        
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('customer_id', 'Customer', 'required|numeric');
        $this->form_validation->set_rules('outlet_id', 'Outlet', 'required|numeric');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('payment_id', 'Payment Method', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $receive_data = [
            'customer_id'   => $request_data['customer_id'],
            'outlet_id'     => $request_data['outlet_id'],
            'amount'        => $request_data['amount'],
            'only_date'     => $request_data['date'], 
            'date'          => date('Y-m-d H:i:s'), 
            'payment_id'    => $request_data['payment_id'],
            'reference_no'  => $this->due_receive_model->generate_ref_no($request_data['outlet_id']),
            'note'          => $request_data['note'] ?? null,
            'user_id'       => $this->auth_data->user_id,
            'company_id'    => $this->auth_data->company_id,
            'del_status'    => 'Live' 
        ];

        $new_id = $this->due_receive_model->create($receive_data);
        if ($new_id) {
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Due receive recorded successfully.', ['id' => $new_id], $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to record due receive.', null, $this);
        }
    }

    
    public function index_put($id)
    {
        $request_data = json_decode(file_get_contents('php://input'), true);

        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('outlet_id', 'Outlet', 'required|numeric');
        $this->form_validation->set_rules('customer_id', 'Customer', 'required|numeric');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('payment_id', 'Payment Method', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        
        $update_data = [
            'customer_id' => $request_data['customer_id'],
            'amount'      => $request_data['amount'],
            'only_date'   => $request_data['date'],
            'payment_id'  => $request_data['payment_id'],
            'note'        => $request_data['note'] ?? null,
            'user_id'     => $this->auth_data->user_id,
        ];

        if ($this->due_receive_model->update($id, $request_data['outlet_id'], $update_data)) {
             $this->db->affected_rows() > 0 ? 
                json_response(REST_Controller::HTTP_OK, 'success', 'Due receive record updated successfully.', ['id' => $id], $this) :
                json_response(REST_Controller::HTTP_NOT_MODIFIED, 'error', 'Record not found or data is the same.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update due receive record.', null, $this);
        }
    }
    
    
    public function index_delete($id)
    {
        $outlet_id = $this->input->get('outlet_id');
        if (!$outlet_id) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required.', null, $this);
        }

        $this->due_receive_model->delete($id, $outlet_id);

        if ($this->db->affected_rows() > 0) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Due receive record deleted successfully.', null, $this);
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