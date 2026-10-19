<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';
class Expenses extends API_Controller
{
public function __construct()
{
    parent::__construct();
    $this->load->model('api_expense_model', 'expense_model');
    $this->load->library('form_validation');
    $this->load->model('Common_model'); 
}
public function index_get($id = 0)
{
    $outlet_id = $this->get('outlet_id');
    if (!$outlet_id) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required.', null, $this);
    }
    if ($id > 0) {
        $data = $this->expense_model->get_by_id($id, $outlet_id);
        if ($data) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Expense record found.', $data, $this);
        } else {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Expense record not found.', null, $this);
        }
    } else {
        $start_date = $this->get('start_date') ? $this->get('start_date') : null;
        $end_date = $this->get('end_date') ? $this->get('end_date') : null;
        $data = $this->expense_model->get_all($outlet_id, $start_date, $end_date);
        json_response(REST_Controller::HTTP_OK, 'success', 'Expenses list retrieved.', $data, $this);
    }
}
public function index_post()
{
    $request_data = json_decode(file_get_contents('php://input'), true);
    $this->form_validation->set_data($request_data);
    $this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
    $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]');
    $this->form_validation->set_rules('category_id', 'Category', 'required|numeric');
    $this->form_validation->set_rules('employee_id', 'Responsible Person', 'required|numeric');
    $this->form_validation->set_rules('payment_id', 'Payment Method', 'required|numeric');
    $this->form_validation->set_rules('outlet_id', 'Outlet', 'required|numeric');
    if ($this->form_validation->run() == FALSE) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
    }

    
    $user_id = $this->auth_data->user_id;
    $outlet_id = $request_data['outlet_id'];
    $open_register_id = $this->Common_model->isOpenRegister($user_id, $outlet_id);

    if (!$open_register_id) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Please open a register to continue.', null, $this);
    }
    

    $expense_data = [
        'date' => $request_data['date'],
        'amount' => $request_data['amount'],
        'category_id' => $request_data['category_id'],
        'employee_id' => $request_data['employee_id'],
        'payment_id' => $request_data['payment_id'],
        'outlet_id' => $request_data['outlet_id'],
        'note' => $request_data['note'] ?? null,
        'user_id' => $user_id, 
        'counter_id' => $open_register_id, 
        'added_date_time' => date('Y-m-d H:i:s')
    ];
    $new_id = $this->expense_model->create($expense_data);
    if ($new_id) {
        json_response(REST_Controller::HTTP_CREATED, 'success', 'Expense created successfully.', ['id' => $new_id], $this);
    } else {
        json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create expense.', null, $this);
    }
}
public function index_put($id)
{
    $request_data = json_decode(file_get_contents('php://input'), true);
    unset($request_data['id'], $request_data['user_id'], $request_data['company_id']);
    if (empty($request_data) || !isset($request_data['outlet_id'])) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Request body is empty or missing outlet_id.', null, $this);
    }

    
    $user_id = $this->auth_data->user_id;
    $outlet_id = $request_data['outlet_id'];
    $open_register_id = $this->Common_model->isOpenRegister($user_id, $outlet_id);

    if (!$open_register_id) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Please open a register to continue.', null, $this);
    }

    
    $request_data['counter_id'] = $open_register_id;
    

    if ($this->expense_model->update($id, $request_data, $outlet_id)) {
        json_response(REST_Controller::HTTP_OK, 'success', 'Expense updated successfully.', null, $this);
    } else {
        json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update expense.', null, $this);
    }
}
public function index_delete($id)
{
    $request_data = json_decode(file_get_contents('php://input'), true);
    $outlet_id = isset($request_data['outlet_id']) ? $request_data['outlet_id'] : null;
    if (!$outlet_id) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required in request body.', null, $this);
    }
    if ($this->expense_model->delete($id, $outlet_id)) {
        json_response(REST_Controller::HTTP_OK, 'success', 'Expense deleted successfully.', null, $this);
    } else {
        json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete expense.', null, $this);
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