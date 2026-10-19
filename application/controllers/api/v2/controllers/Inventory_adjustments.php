<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Inventory_adjustments extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_inventory_adjustment_model', 'adjustment_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $outlet_id = $this->get('outlet_id');
        if (!$outlet_id) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required.', null, $this);
        }

        if ($id > 0) {
            $data = $this->adjustment_model->get_by_id($id, $outlet_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Adjustment details found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Adjustment not found.', null, $this);
            }
        } else {
            $data = $this->adjustment_model->get_all($outlet_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Adjustments list retrieved.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = $this->input->post();
        $items = $request_data['items'] ?? [];

        if (!isset($request_data['outlet_id']) || !is_numeric($request_data['outlet_id'])) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'The Outlet field is required and must be numeric.', null, $this);
            return;
        }
        if (!isset($request_data['employee_id']) || !is_numeric($request_data['employee_id'])) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'The Responsible Person field is required and must be numeric.', null, $this);
            return;
        }
        if (!isset($request_data['date']) || empty($request_data['date'])) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'The Date field is required.', null, $this);
            return;
        }
        if (empty($items)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Items are required and must be a non-empty array.', null, $this);
            return;
        }

        $adjustment_data = [
            'reference_no' => $request_data['reference_no'] ?? $this->adjustment_model->generate_ref_no($request_data['outlet_id']),
            'outlet_id' => $request_data['outlet_id'],
            'date' => date('Y-m-d', strtotime($request_data['date'])),
            'employee_id' => $request_data['employee_id'],
            'note' => $request_data['note'] ?? null,
            'items' => $items,
            'user_id' => $this->auth_data->user_id,
        ];

        $new_id = $this->adjustment_model->create($adjustment_data);
        if ($new_id) {
            $new_adjustment = $this->adjustment_model->get_by_id($new_id, $request_data['outlet_id']);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Inventory adjustment created successfully.', $new_adjustment, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create adjustment.', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        if (!isset($request_data['outlet_id']) || !isset($request_data['employee_id']) || !isset($request_data['date'])) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Missing required fields (outlet_id, employee_id, date).', null, $this);
        }
        if (!isset($request_data['items']) || !is_array($request_data['items']) || empty($request_data['items'])) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'The Items field is required and must not be empty.', null, $this);
        }

        $adjustment_data = [
            'outlet_id' => $request_data['outlet_id'],
            'date' => date('Y-m-d', strtotime($request_data['date'])),
            'employee_id' => $request_data['employee_id'],
            'note' => $request_data['note'] ?? null,
            'items' => $request_data['items'],
        ];

        if ($this->adjustment_model->update($id, $adjustment_data)) {
            $updated_adjustment = $this->adjustment_model->get_by_id($id, $request_data['outlet_id']);
            json_response(REST_Controller::HTTP_OK, 'success', 'Inventory adjustment updated successfully.', $updated_adjustment, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update adjustment or adjustment not found.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        $outlet_id = $request_data['outlet_id'] ?? null;
        if (!$outlet_id) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required in request body.', null, $this);
        }
        if ($this->adjustment_model->delete($id, $outlet_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Adjustment deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete adjustment or not found.', null, $this);
        }
    }
}