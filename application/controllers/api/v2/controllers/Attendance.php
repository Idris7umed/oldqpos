<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Attendance extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_attendance_model', 'attendance_model');
        $this->load->library('form_validation');
        $this->load->model('Common_model');
    }

    public function index_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('employee_id', 'Employee ID', 'numeric');
        $this->form_validation->set_rules('is_personal', 'Is Personal', 'in_list[true]');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $employee_id = $this->get('employee_id') ? (int) $this->get('employee_id') : null;
        $is_personal = $this->get('is_personal');
        if ($is_personal === 'true' && $employee_id === null) {
            $employee_id = $this->auth_data->user_id;
        }
        $company_id = $this->auth_data->company_id;
        $data = $this->attendance_model->get_all($company_id, $start_date, $end_date, $employee_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Attendance records retrieved.', $data, $this);
    }

    public function index_post()
    {
        $request_data = $this->get_json_request_data(true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('employee_id', 'Employee', 'required|numeric');
        $this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('in_time', 'In Time', 'required');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $attendance_data = [
            'employee_id' => $request_data['employee_id'],
            'date' => $request_data['date'],
            'in_time' => $request_data['in_time'],
            'out_time' => $request_data['out_time'] ?? null,
            'note' => $request_data['note'] ?? null,
            'user_id' => $this->auth_data->user_id,
            'company_id' => $this->auth_data->company_id,
            'reference_no' => $this->attendance_model->generate_ref_no()
        ];
        $new_id = $this->attendance_model->create($attendance_data);
        if ($new_id) {
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Attendance record created successfully.', ['attendance_id' => $new_id], $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create record.', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = $this->get_json_request_data(true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('in_time', 'In Time', 'required');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $update_data = [
            'in_time' => $request_data['in_time'],
            'out_time' => $request_data['out_time'] ?? null,
            'note' => $request_data['note'] ?? null
        ];
        if ($this->attendance_model->update($id, $this->auth_data->company_id, $update_data)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Attendance updated successfully.', ['attendance_id' => $id], $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update record.', null, $this);
        }
    }

    public function index_delete($id)
    {
        try {
            $this->Common_model->deleteStatusChange($id, 'tbl_attendance');
            $check_delete = $this->db->where('id', $id)->get('tbl_attendance')->row();
            if ($check_delete && $check_delete->del_status == 'Deleted') {
                json_response(REST_Controller::HTTP_OK, 'success', 'Attendance record deleted successfully.', null, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Record not found or could not be deleted.', null, $this);
            }
        } catch (Exception $e) {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'An error occurred during deletion.', null, $this);
        }
    }

    public function check_in_post()
    {
        $employee_id = $this->auth_data->user_id;
        $open_attendance = $this->attendance_model->get_open_attendance($employee_id);
        if ($open_attendance) {
            json_response(REST_Controller::HTTP_CONFLICT, 'error', 'You already have an open check-in for today.', ['attendance_id' => $open_attendance->id], $this);
        }
        $company_id = $this->auth_data->company_id;
        $attendance_data = [
            'employee_id' => $employee_id,
            'date' => date('Y-m-d'),
            'in_time' => date('H:i:s'),
            'user_id' => $employee_id,
            'company_id' => $company_id,
            'reference_no' => $this->attendance_model->generate_ref_no()
        ];
        $new_id = $this->attendance_model->check_in($attendance_data);
        if ($new_id) {
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Check-in successful.', ['attendance_id' => $new_id], $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to record check-in.', null, $this);
        }
    }

    public function check_out_post()
    {
        $employee_id = $this->auth_data->user_id;
        $open_attendance = $this->attendance_model->get_open_attendance($employee_id);
        if (!$open_attendance) {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'No open check-in found to check out.', null, $this);
        }
        $checkout_data = [
            'out_time' => date('H:i:s')
        ];
        if ($this->attendance_model->check_out($open_attendance->id, $checkout_data)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Check-out successful.', ['attendance_id' => $open_attendance->id], $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to record check-out.', null, $this);
        }
    }

    public function status_get()
    {
        $employee_id = $this->auth_data->user_id;
        $open_attendance = $this->attendance_model->get_open_attendance($employee_id);
        if ($open_attendance) {
            $response_data = [
                'is_checked_in' => true,
                'attendance_record' => $open_attendance
            ];
            json_response(REST_Controller::HTTP_OK, 'success', 'User is currently checked in.', $response_data, $this);
        } else {
            $response_data = [
                'is_checked_in' => false,
                'attendance_record' => null
            ];
            json_response(REST_Controller::HTTP_OK, 'success', 'User is not currently checked in.', $response_data, $this);
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
