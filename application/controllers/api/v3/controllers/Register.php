<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Register extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_register_model', 'register_model');
        $this->load->library('form_validation');
    }

    public function open_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);

        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        $this->form_validation->set_rules('counter_id', 'Counter ID', 'required|numeric');
        $this->form_validation->set_rules('opening_balance', 'Opening Balance', 'required|numeric');
        $this->form_validation->set_rules('opening_details', 'Opening Details', 'is_array');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $user_id = $this->auth_data->user_id;
        $outlet_id = $request_data['outlet_id'];
        $counter_id = $request_data['counter_id'];

        $is_open = $this->register_model->get_open_register($user_id, $outlet_id, $counter_id);
        if ($is_open) {
            json_response(REST_Controller::HTTP_CONFLICT, 'error', 'Register is already open.', null, $this);
        }

        $register_data = [
            'opening_balance' => $request_data['opening_balance'],
            'closing_balance' => 0.0,
            'counter_id' => $request_data['counter_id'],
            'opening_balance_date_time' => date('Y-m-d H:i:s'),
            'register_status' => 1,
            'user_id' => $user_id,
            'outlet_id' => $outlet_id,
            'company_id' => $this->auth_data->company_id,
        ];

        if (isset($request_data['opening_details']) && is_array($request_data['opening_details'])) {
            $details_to_save = [];
            foreach ($request_data['opening_details'] as $detail) {
                $details_to_save[] = "{$detail['payment_id']}||{$detail['payment_name']}||{$detail['amount']}";
            }
            $register_data['opening_details'] = json_encode($details_to_save);
        }

        $new_id = $this->register_model->open_register($register_data);

        if ($new_id) {
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Register opened successfully.', ['register_id' => $new_id], $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to open register.', null, $this);
        }
    }

    public function details_get()
    {
        $outlet_id = $this->get('outlet_id');
        $counter_id = $this->get('counter_id'); 

        if (!$outlet_id) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required.', null, $this);
        }

        
        $this->db->where('user_id', $this->auth_data->user_id);
        $this->db->where('outlet_id', $outlet_id);
        if ($counter_id) {
            $this->db->where('counter_id', $counter_id);
        }
        $this->db->where('register_status', 1);
        $open_register = $this->db->get('tbl_register')->row();
        
        if (!$open_register) {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'No open register found for this user/outlet.', null, $this);
        }

        $details = $this->register_model->get_register_details($open_register);
        json_response(REST_Controller::HTTP_OK, 'success', 'Open register details retrieved.', $details, $this);
    }
        public function close_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);

        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('register_id', 'Register ID', 'required|numeric');
        $this->form_validation->set_rules('closing_balance', 'Closing Balance', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $register_id = $request_data['register_id'];
        $closing_balance = $request_data['closing_balance'];
        
        
        $open_register = $this->db->get_where('tbl_register', ['id' => $register_id])->row();
        if (!$open_register) {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Register not found.', null, $this);
        }

        $details = $this->register_model->get_register_details($open_register);
        $payment_methods_sale_details = $details['detailed_summary'];


        if ($this->register_model->close_register($register_id, $closing_balance, $payment_methods_sale_details)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Register closed successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to close register.', null, $this);
        }
    }
}
