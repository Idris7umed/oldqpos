<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Outlets extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_outlet_model', 'outlet_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        if ($id > 0) {
            $data = $this->outlet_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Outlet found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Outlet not found.', null, $this);
            }
        } else {
            $data = $this->outlet_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Outlets list.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = $this->input->post();
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('outlet_name', 'Outlet Name', 'required|max_length[50]');
        $this->form_validation->set_rules('address', 'Address', 'required|max_length[200]');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $outlet_data = [
            'outlet_name' => $request_data['outlet_name'],
            'address' => $request_data['address'],
            'phone' => $request_data['phone'],
            'email' => $request_data['email'] ?? null,
            'default_waiter' => $request_data['default_waiter'] ?? null,
            'active_status' => $request_data['active_status'] ?? 'active',
            'company_id' => $this->auth_data->company_id,
            'outlet_code' => $this->outlet_model->generateOutletCode($this->auth_data->company_id),
            'food_menus' => $request_data['food_menus'] ?? null,
            'food_menu_prices' => $request_data['food_menu_prices'] ?? null,
            'delivery_price' => $request_data['delivery_price'] ?? null,
        ];
        $new_id = $this->outlet_model->create($outlet_data);
        if ($new_id) {
            $new_outlet = $this->outlet_model->get_by_id($new_id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Outlet created successfully.', $new_outlet, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create outlet.', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = $this->input->post();
        if (empty($request_data)) {
            $request_data = $this->get_json_request_data();
        }
        unset($request_data['id'], $request_data['company_id'], $request_data['user_id'], $request_data['outlet_code']);
        if (empty($request_data)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Request body is empty.', null, $this);
        }
        $company_id = $this->auth_data->company_id;
        $update_data = $request_data;
        if (isset($request_data['food_menus']))
            $update_data['food_menus'] = $request_data['food_menus'];
        if (isset($request_data['food_menu_prices']))
            $update_data['food_menu_prices'] = $request_data['food_menu_prices'];
        if (isset($request_data['delivery_price']))
            $update_data['delivery_price'] = $request_data['delivery_price'];
        if ($this->outlet_model->update($id, $update_data, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Outlet updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update outlet or not found.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->outlet_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Outlet deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete outlet. The main outlet cannot be deleted.', null, $this);
        }
    }
}
