<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Reservations extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_reservation_model', 'reservation_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;

        if ($id > 0) {
            $data = $this->reservation_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Reservation found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Reservation not found.', null, $this);
            }
        } else {
            $outlet_id = $this->get('outlet_id') ? (int)$this->get('outlet_id') : null;
            $date = $this->get('date') ? $this->get('date') : null;
            
            $data = $this->reservation_model->get_all($company_id, $outlet_id, $date);
            json_response(REST_Controller::HTTP_OK, 'success', 'Reservations list.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);

        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('outlet_id', 'Outlet', 'required|numeric');
        $this->form_validation->set_rules('name', 'Name', 'required|max_length[250]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|max_length[50]');
        $this->form_validation->set_rules('number_of_guest', 'Number of Guests', 'required|numeric');
        $this->form_validation->set_rules('reservation_date', 'Reservation Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('reservation_time', 'Reservation Time', 'required');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        
        $reservation_data = [
            'outlet_id' => $request_data['outlet_id'],
            'name' => $request_data['name'],
            'phone' => $request_data['phone'],
            'email' => $request_data['email'] ?? null,
            'number_of_guest' => $request_data['number_of_guest'],
            'reservation_date' => $request_data['reservation_date'],
            'reservation_time' => $request_data['reservation_time'],
            'notes' => $request_data['notes'] ?? null,
            'status' => 'Pending', 
            'company_id' => $this->auth_data->company_id,
        ];

        $new_id = $this->reservation_model->create($reservation_data);
        if ($new_id) {
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Reservation created successfully.', ['id' => $new_id], $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create reservation.', null, $this);
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
        if ($this->reservation_model->update($id, $request_data, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Reservation updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update reservation.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->reservation_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Reservation deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete reservation.', null, $this);
        }
    }
    
    
    public function valid_date($date)
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        if ($d && $d->format('Y-m-d') === $date) {
            return true;
        }
        $this->form_validation->set_message('valid_date', 'The {field} field must be in YYYY-MM-DD format.');
        return false;
    }
}