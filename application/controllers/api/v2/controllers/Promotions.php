<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Promotions extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_promotion_model', 'promotion_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        if ($id > 0) {
            $data = $this->promotion_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Promotion found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Promotion not found.', null, $this);
            }
        } else {
            $outlet_id = $this->get('outlet_id') ? (int) $this->get('outlet_id') : null;
            $data = $this->promotion_model->get_all($company_id, $outlet_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Promotions list.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = $this->get_json_request_data(true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('title', 'Title', 'required|max_length[250]');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('type', 'Type', 'required|regex_match[/^[12]$/]');
        $this->form_validation->set_rules('outlet_id', 'Outlet', 'required|numeric');
        if (isset($request_data['type'])) {
            if ($request_data['type'] == 1) {
                $this->form_validation->set_rules('food_menu_id', 'Food Menu', 'required|numeric');
                $this->form_validation->set_rules('discount', 'Discount', 'required');
            } elseif ($request_data['type'] == 2) {
                $this->form_validation->set_rules('food_menu_id', 'Buy Food Menu', 'required|numeric');
                $this->form_validation->set_rules('qty', 'Buy Quantity', 'required|numeric');
                $this->form_validation->set_rules('get_food_menu_id', 'Get Food Menu', 'required|numeric');
                $this->form_validation->set_rules('get_qty', 'Get Quantity', 'required|numeric');
            }
        }
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $is_conflict = $this->promotion_model->check_promotion_conflict(
            $request_data['start_date'],
            $request_data['end_date'],
            $request_data['food_menu_id'],
            $this->auth_data->company_id
        );
        if ($is_conflict) {
            json_response(REST_Controller::HTTP_CONFLICT, 'error', 'A promotion for this item already exists within the selected date range.', null, $this);
        }
        $promo_data = [
            'title' => $request_data['title'],
            'start_date' => $request_data['start_date'],
            'end_date' => $request_data['end_date'],
            'type' => $request_data['type'],
            'outlet_id' => $request_data['outlet_id'],
            'food_menu_id' => $request_data['food_menu_id'],
            'qty' => $request_data['qty'] ?? null,
            'get_food_menu_id' => $request_data['get_food_menu_id'] ?? null,
            'get_qty' => $request_data['get_qty'] ?? null,
            'discount' => $request_data['discount'] ?? null,
            'status' => $request_data['status'] ?? 1,
            'user_id' => $this->auth_data->user_id,
            'company_id' => $this->auth_data->company_id,
        ];
        $new_id = $this->promotion_model->create($promo_data);
        if ($new_id) {
            $new_promo = $this->promotion_model->get_by_id($new_id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Promotion created successfully.', $new_promo, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create promotion.', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = $this->get_json_request_data(true);
        if (empty($request_data)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Request body is empty.', null, $this);
        }
        if (isset($request_data['start_date']) && isset($request_data['end_date']) && isset($request_data['food_menu_id'])) {
            $is_conflict = $this->promotion_model->check_promotion_conflict(
                $request_data['start_date'],
                $request_data['end_date'],
                $request_data['food_menu_id'],
                $this->auth_data->company_id,
                $id
            );
            if ($is_conflict) {
                json_response(REST_Controller::HTTP_CONFLICT, 'error', 'A promotion for this item already exists within the selected date range.', null, $this);
            }
        }
        unset($request_data['id'], $request_data['company_id'], $request_data['user_id']);
        $company_id = $this->auth_data->company_id;
        if ($this->promotion_model->update($id, $request_data, $company_id)) {
            $updated_promo = $this->promotion_model->get_by_id($id, $company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Promotion updated successfully.', $updated_promo, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update promotion or no changes made.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->promotion_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Promotion deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete promotion.', null, $this);
        }
    }

    public function check_conflict_post()
    {
        $request_data = $this->get_json_request_data(true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('start_date', 'Start Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('food_menu_id', 'Food Menu ID', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $exclude_id = isset($request_data['id']) ? (int) $request_data['id'] : null;
        $is_conflict = $this->promotion_model->check_promotion_conflict(
            $request_data['start_date'],
            $request_data['end_date'],
            $request_data['food_menu_id'],
            $this->auth_data->company_id,
            $exclude_id
        );
        json_response(REST_Controller::HTTP_OK, 'success', 'Conflict check complete.', ['is_conflict' => $is_conflict], $this);
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
