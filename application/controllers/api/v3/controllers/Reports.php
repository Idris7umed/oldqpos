<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Reports extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_report_model', 'report_model');
        $this->load->library('form_validation');
    }

    public function daily_summary_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $date = $this->get('date');
        $outlet_id = $this->get('outlet_id');
        $this->report_model->auth_data = $this->auth_data;
        $summary_data = $this->report_model->daily_summary_report($date, $outlet_id);
        json_response(REST_Controller::HTTP_OK, 'success', "Daily summary report for {$date}.", $summary_data, $this);
    }

    public function food_menu_sales_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        $this->form_validation->set_rules('category_id', 'Category ID', 'numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $outlet_id = $this->get('outlet_id');
        $category_id = $this->get('category_id') ? (int) $this->get('category_id') : null;
        $report_data = $this->report_model->food_menu_sales_report($start_date, $end_date, $outlet_id, $category_id);
        json_response(REST_Controller::HTTP_OK, 'success', "Food menu sales report from {$start_date} to {$end_date}.", $report_data, $this);
    }

    public function inventory_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        $this->form_validation->set_rules('category_id', 'Category ID', 'numeric');
        $this->form_validation->set_rules('ingredient_id', 'Ingredient ID', 'numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $outlet_id = (int) $this->get('outlet_id');
        $category_id = $this->get('category_id') ? (int) $this->get('category_id') : null;
        $ingredient_id = $this->get('ingredient_id') ? (int) $this->get('ingredient_id') : null;
        $this->report_model->auth_data = $this->auth_data;
        $report_data = $this->report_model->inventory_report($outlet_id, $category_id, $ingredient_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Inventory report generated.', $report_data, $this);
    }

    public function low_stock_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $outlet_id = (int) $this->get('outlet_id');
        $this->report_model->auth_data = $this->auth_data;
        $all_ingredients = $this->report_model->inventory_report($outlet_id);
        $low_stock_report = [];
        foreach ($all_ingredients as $ingredient) {
            if ($ingredient->alert_quantity > 0 && $ingredient->stock_qty <= $ingredient->alert_quantity) {
                $low_stock_report[] = $ingredient;
            }
        }
        json_response(REST_Controller::HTTP_OK, 'success', 'Low stock ingredients list retrieved.', $low_stock_report, $this);
    }

    public function profit_loss_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $outlet_id = (int) $this->get('outlet_id');
        $this->report_model->auth_data = $this->auth_data;
        $report_data = $this->report_model->profit_loss_report($start_date, $end_date, $outlet_id);
        json_response(REST_Controller::HTTP_OK, 'success', "Profit & Loss report from {$start_date} to {$end_date}.", $report_data, $this);
    }

    public function sales_by_waiter_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        $this->form_validation->set_rules('waiter_id', 'Waiter ID', 'numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $outlet_id = (int) $this->get('outlet_id');
        $waiter_id = $this->get('waiter_id') ? (int) $this->get('waiter_id') : null;
        $report_data = $this->report_model->sales_by_waiter_report($start_date, $end_date, $outlet_id, $waiter_id);
        json_response(REST_Controller::HTTP_OK, 'success', "Sales by waiter report from {$start_date} to {$end_date}.", $report_data, $this);
    }

    public function attendance_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('employee_id', 'Employee ID', 'numeric');
        $this->form_validation->set_rules('is_personal', 'Is Personal', 'in_list[true,false]');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $employee_id = $this->get('employee_id') ? (int) $this->get('employee_id') : null;
        $is_personal = $this->get('is_personal') === 'true';
        $company_id = $this->auth_data->company_id;
        $user_id = $this->auth_data->id;

        $report_data = $this->report_model->attendance_report($start_date, $end_date, $company_id, $employee_id, $is_personal, $user_id);
        json_response(REST_Controller::HTTP_OK, 'success', "Attendance report from {$start_date} to {$end_date}.", $report_data, $this);
    }

    public function customer_due_get()
    {
        $company_id = $this->auth_data->company_id;
        $outlet_id = $this->get('outlet_id') ? (int) $this->get('outlet_id') : null;
        $report_data = $this->report_model->customer_due_report($company_id, $outlet_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Customer due report generated.', $report_data, $this);
    }

    public function supplier_due_get()
    {
        $company_id = $this->auth_data->company_id;
        $outlet_id = $this->get('outlet_id') ? (int) $this->get('outlet_id') : null;
        $report_data = $this->report_model->supplier_due_report($company_id, $outlet_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Supplier due report generated.', $report_data, $this);
    }

    public function customer_ledger_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('customer_id', 'Customer ID', 'required|numeric');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $customer_id = (int) $this->get('customer_id');
        $this->auth_data->outlet_id = $this->get('outlet_id') ? (int) $this->get('outlet_id') : null;
        $this->report_model->auth_data = $this->auth_data;
        $report_data = $this->report_model->customer_ledger($customer_id, $start_date, $end_date);
        json_response(REST_Controller::HTTP_OK, 'success', "Customer ledger from {$start_date} to {$end_date}.", $report_data, $this);
    }

    public function supplier_ledger_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('supplier_id', 'Supplier ID', 'required|numeric');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $supplier_id = (int) $this->get('supplier_id');
        $this->auth_data->outlet_id = $this->get('outlet_id') ? (int) $this->get('outlet_id') : null;
        $this->report_model->auth_data = $this->auth_data;
        $report_data = $this->report_model->supplier_ledger($supplier_id, $start_date, $end_date);
        json_response(REST_Controller::HTTP_OK, 'success', "Supplier ledger from {$start_date} to {$end_date}.", $report_data, $this);
    }

    public function full_dashboard_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        $this->form_validation->set_rules('start_date', 'Start Date', 'callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'callback_valid_date');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $outlet_id = (int) $this->get('outlet_id');
        $start_date = $this->get('start_date') ? $this->get('start_date') : date('Y-m-01');
        $end_date = $this->get('end_date') ? $this->get('end_date') : date('Y-m-t');
        $this->report_model->auth_data = $this->auth_data;
        $dashboard_data = $this->report_model->get_full_dashboard_data($outlet_id, $start_date, $end_date);
        if ($dashboard_data) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Full dashboard data retrieved successfully.', $dashboard_data, $this);
        } else {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Could not retrieve dashboard data.', null, $this);
        }
    }

    public function dashboard_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        $this->form_validation->set_rules('date', 'Date', 'callback_valid_date');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $outlet_id = (int) $this->get('outlet_id');
        $date = $this->get('date') ? $this->get('date') : date('Y-m-d');
        $this->report_model->auth_data = $this->auth_data;
        $dashboard_data = $this->report_model->get_dashboard_summary($outlet_id, $date);
        json_response(REST_Controller::HTTP_OK, 'success', "Dashboard summary for {$date}.", $dashboard_data, $this);
    }

    public function detailed_sales_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        $this->form_validation->set_rules('user_id', 'User ID', 'numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $outlet_id = (int) $this->get('outlet_id');
        $user_id = $this->get('user_id') ? (int) $this->get('user_id') : null;
        $report_data = $this->report_model->detailed_sale_report($start_date, $end_date, $outlet_id, $user_id);
        json_response(REST_Controller::HTTP_OK, 'success', "Detailed sales report retrieved.", $report_data, $this);
    }

    public function expense_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        $this->form_validation->set_rules('expense_item_id', 'Expense Item ID', 'numeric');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $outlet_id = (int) $this->get('outlet_id');
        $expense_item_id = $this->get('expense_item_id') ? (int) $this->get('expense_item_id') : null;

        $this->load->model('Report_model');
        $report_data = $this->Report_model->expenseReport($start_date, $end_date, $expense_item_id, $outlet_id);
        json_response(REST_Controller::HTTP_OK, 'success', "Expense report from {$start_date} to {$end_date}.", $report_data, $this);
    }

    public function waste_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        $this->form_validation->set_rules('user_id', 'User ID', 'numeric');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $outlet_id = (int) $this->get('outlet_id');
        $user_id = $this->get('user_id') ? (int) $this->get('user_id') : null;

        $this->load->model('Report_model');
        $report_data = $this->Report_model->wasteReport($start_date, $end_date, $user_id, $outlet_id);
        json_response(REST_Controller::HTTP_OK, 'success', "Waste report from {$start_date} to {$end_date}.", $report_data, $this);
    }

    public function vat_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $outlet_id = (int) $this->get('outlet_id');

        $this->load->model('Report_model');
        $report_data = $this->Report_model->vatReport($start_date, $end_date, $outlet_id);
        json_response(REST_Controller::HTTP_OK, 'success', "VAT report from {$start_date} to {$end_date}.", $report_data, $this);
    }

    public function detailed_purchases_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        $this->form_validation->set_rules('user_id', 'User ID', 'numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $outlet_id = (int) $this->get('outlet_id');
        $user_id = $this->get('user_id') ? (int) $this->get('user_id') : null;
        $report_data = $this->report_model->detailed_purchase_report($start_date, $end_date, $outlet_id, $user_id);
        json_response(REST_Controller::HTTP_OK, 'success', "Detailed purchase report retrieved.", $report_data, $this);
    }

    public function customer_report_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('customer_id', 'Customer ID', 'required|numeric');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $customer_id = (int) $this->get('customer_id');
        $outlet_id = (int) $this->get('outlet_id');

        $report_data = $this->report_model->customer_report($start_date, $end_date, $customer_id, $outlet_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Customer report generated.', $report_data, $this);
    }

    public function audit_log_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'callback_valid_date');
        $this->form_validation->set_rules('user_id', 'User ID', 'numeric');
        $this->form_validation->set_rules('event_title', 'Event Title', 'alpha_numeric_spaces');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $user_id = $this->get('user_id');
        $event_title = $this->get('event_title');
        $outlet_id = $this->get('outlet_id');

        $report_data = $this->report_model->audit_log_report($start_date, $end_date, $user_id, $event_title, $outlet_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Audit log report generated.', $report_data, $this);
    }

    public function consumption_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $outlet_id = $this->get('outlet_id');

        $report_data = $this->report_model->consumption_report($start_date, $end_date, $outlet_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Consumption report generated.', $report_data, $this);
    }

    public function kitchen_performance_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $outlet_id = $this->get('outlet_id');

        $report_data = $this->report_model->kitchen_performance_report($start_date, $end_date, $outlet_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Kitchen performance report generated.', $report_data, $this);
    }

    public function loyalty_points_available_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('customer_id', 'Customer ID', 'numeric');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $customer_id = $this->get('customer_id');
        $outlet_id = $this->get('outlet_id');

        $report_data = $this->report_model->loyalty_points_report($customer_id, $outlet_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Available loyalty points report generated.', $report_data, $this);
    }

    public function loyalty_points_usage_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'callback_valid_date');
        $this->form_validation->set_rules('customer_id', 'Customer ID', 'numeric');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $customer_id = $this->get('customer_id');
        $outlet_id = $this->get('outlet_id');

        $report_data = $this->report_model->loyalty_points_usage_report($start_date, $end_date, $customer_id, $outlet_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Loyalty points usage report generated.', $report_data, $this);
    }

    public function production_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'callback_valid_date');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $outlet_id = $this->get('outlet_id');
        $report_data = $this->report_model->production_report($start_date, $end_date, $outlet_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Production report generated.', $report_data, $this);
    }

    public function purchases_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'callback_valid_date');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $outlet_id = $this->get('outlet_id');
        $this->load->model('Report_model');
        $report_data = $this->Report_model->purchaseReportByDate($start_date, $end_date, $outlet_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Purchase report by date generated.', $report_data, $this);
    }

    public function purchases_by_ingredient_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'callback_valid_date');
        $this->form_validation->set_rules('ingredient_id', 'Ingredient ID', 'numeric');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $ingredient_id = $this->get('ingredient_id');
        $this->load->model('Report_model');
        $report_data = $this->Report_model->purchaseReportByIngredient($start_date, $end_date, $ingredient_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Purchase report by ingredient generated.', $report_data, $this);
    }

    public function register_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('user_id', 'User ID', 'numeric');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $user_id = $this->get('user_id');
        $outlet_id = $this->get('outlet_id');
        $this->load->model('Report_model');
        $report_data = $this->Report_model->getRegisterInformation($start_date, $end_date, $user_id, $outlet_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Register report generated.', $report_data, $this);
    }

    public function sales_summary_by_date_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('user_id', 'User ID', 'numeric');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $user_id = $this->get('user_id');
        $outlet_id = $this->get('outlet_id');
        $report_data = $this->report_model->sales_summary_by_date($start_date, $end_date, $outlet_id, $user_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Sales summary by date generated.', $report_data, $this);
    }

    public function sales_summary_by_month_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('user_id', 'User ID', 'numeric');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $user_id = $this->get('user_id');
        $outlet_id = $this->get('outlet_id');
        $report_data = $this->report_model->sales_summary_by_month($start_date, $end_date, $outlet_id, $user_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Sales summary by month generated.', $report_data, $this);
    }

    public function tips_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'callback_valid_date');
        $this->form_validation->set_rules('waiter_id', 'Waiter ID', 'numeric');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $waiter_id = $this->get('waiter_id');
        $outlet_id = $this->get('outlet_id');
        $this->load->model('Report_model');
        $report_data = $this->Report_model->tipsReport($start_date, $end_date, $outlet_id, $waiter_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Tips report generated.', $report_data, $this);
    }

    public function transfers_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'callback_valid_date');
        $this->form_validation->set_rules('from_outlet_id', 'From Outlet ID', 'numeric');
        $this->form_validation->set_rules('to_outlet_id', 'To Outlet ID', 'numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $from_outlet_id = $this->get('from_outlet_id');
        $to_outlet_id = $this->get('to_outlet_id');
        $report_data = $this->report_model->transfer_report($start_date, $end_date, $from_outlet_id, $to_outlet_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Transfer report generated.', $report_data, $this);
    }

    public function product_analysis_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('category_id', 'Category ID', 'required|numeric');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');
        $category_id = $this->get('category_id');
        $outlet_id = $this->get('outlet_id');
        $this->load->model('Report_model');

        $total_all = $this->Report_model->productAnalysisReportTotal($start_date, $end_date, $outlet_id, $category_id);
        $report_data = $this->Report_model->productAnalysisReport($start_date, $end_date, $outlet_id, $category_id);

        $response = [
            'totals' => $total_all,
            'report' => $report_data
        ];
        json_response(REST_Controller::HTTP_OK, 'success', 'Product Analysis report generated.', $response, $this);
    }

    public function z_report_get()
    {
        $this->form_validation->set_data($this->get());
        $this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $date = $this->get('date');
        $outlet_id = $this->get('outlet_id');

        $this->load->model('Report_model');

        $data = [];

        $data['sub_total_foods'] = $this->Report_model->sub_total_foods($date, $outlet_id);
        $data['totalFoodRefunds'] = $this->Report_model->totalFoodRefunds($date, $date, $outlet_id, "DESC");
        $data['sub_total_modifiers'] = $this->Report_model->sub_total_modifiers($date, $outlet_id);
        $data['totals_sale_delivery'] = $this->Report_model->totalCharge($date, $outlet_id, "delivery");
        $data['totals_sale_service'] = $this->Report_model->totalCharge($date, $outlet_id, "service");
        $data['totals_sale_others'] = $this->Report_model->totalTaxDiscountChargeTips($date, $outlet_id);
        $data['taxes_foods'] = $this->Report_model->taxes_foods($date, $outlet_id);
        $data['totalDueReceived'] = $this->Report_model->totalDueReceived($date, $outlet_id);
        $data['total_discount_amount_foods'] = $this->Report_model->total_discount_amount_foods($date, $outlet_id);
        $data['total_due_amount_foods'] = $this->Report_model->total_due_amount_foods($date, $outlet_id);

        $data['totalFoodSales'] = $this->Report_model->totalFoodSales($date, $date, $outlet_id, "DESC");
        $data['totalFoodModifierSales'] = $this->Report_model->totalFoodModifierSales($date, $outlet_id, "DESC");

        $data['get_all_sale_payment'] = $this->Report_model->getAllSalePaymentZReport($date, $outlet_id);

        $data['getAllPurchasePaymentZreport'] = $this->Report_model->getAllPurchasePaymentZreport($date, $outlet_id);
        $data['getAllExpensePaymentZreport'] = $this->Report_model->getAllExpensePaymentZreport($date, $outlet_id);
        $data['getAllSupplierPaymentZreport'] = $this->Report_model->getAllSupplierPaymentZreport($date, $outlet_id);
        $data['getAllCustomerDueReceiveZreport'] = $this->Report_model->getAllCustomerDueReceiveZreport($date, $outlet_id);
        $data['getAllOtherSalePaymentZReport'] = $this->Report_model->getAllOtherSalePaymentZReport($date, $outlet_id);

        $company_id = $this->auth_data->company_id;

        $payment_methods = $this->db->select('*')
            ->from('tbl_payment_methods')
            ->where('company_id', $company_id)
            ->where('del_status', 'Live')
            ->get()
            ->result();

        $registers_data = [];
        $in_hand_summary = [];

        foreach ($payment_methods as $method) {
            $paid_sales = $this->Report_model->getAllSaleByPayment($date, $method->id, $outlet_id);
            $return_sales = $this->Report_model->getAllSaleReturnByPayment($date, $method->id, $outlet_id);
            $purchase = $this->Report_model->getAllPurchaseByPayment($date, $method->id, $outlet_id);
            $due_receive = $this->Report_model->getAllDueReceiveByPayment($date, $method->id, $outlet_id);
            $due_payment = $this->Report_model->getAllDuePaymentByPayment($date, $method->id, $outlet_id);
            $expense = $this->Report_model->getAllExpenseByPayment($date, $method->id, $outlet_id);

            $inline_total = $paid_sales - $return_sales - $purchase + $due_receive - $due_payment - $expense;

            $registers_data[] = [
                'id' => (int) $method->id,
                'name' => $method->name,
                'paid_sales' => (float) $paid_sales,
                'return_sales' => (float) $return_sales,
                'purchase' => (float) $purchase,
                'due_receive' => (float) $due_receive,
                'due_payment' => (float) $due_payment,
                'expense' => (float) $expense,
                'inline_total' => (float) $inline_total
            ];

            $in_hand_summary[] = $method->name . "||" . $inline_total;
        }

        $data['registers'] = $registers_data;
        $data['total_payments'] = $in_hand_summary;

        json_response(REST_Controller::HTTP_OK, 'success', 'Z-Report data generated.', $data, $this);
    }

    public function valid_date($date)
    {
        if (!$date)
            return true;

        $d = DateTime::createFromFormat('Y-m-d', $date);
        if ($d && $d->format('Y-m-d') === $date) {
            return true;
        }
        $this->form_validation->set_message('valid_date', 'The {field} field must be in YYYY-MM-DD format.');
        return false;
    }

}