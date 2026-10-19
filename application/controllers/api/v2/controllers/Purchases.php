<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Purchases extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_purchase_model', 'purchase_model');
        $this->load->library('form_validation');
    }

      public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        if ($id > 0) {
            
            $data = $this->purchase_model->get_by_id($id, $company_id);
            if ($data) {
                
                $data->id = (int) $data->id;
                $data->supplier_id = (int) $data->supplier_id;
                $data->grand_total = (float) $data->grand_total;
                $data->paid = (float) $data->paid;
                $data->due = (float) $data->due;
                foreach ($data->items as &$item) {
                    $item->ingredient_id = (int) $item->ingredient_id;
                    $item->quantity_amount = (float) $item->quantity_amount;
                    $item->unit_price = (float) $item->unit_price;
                    $item->total = (float) $item->total;
                }
                json_response(REST_Controller::HTTP_OK, 'success', 'Purchase details found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Purchase not found.', null, $this);
            }
        } else {
            
              $outlet_id = $this->input->get('outlet_id');
            if (!$outlet_id || !is_numeric($outlet_id)) {
                json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'A valid Outlet ID is required.', null, $this);
            }
            $limit = $this->get('limit') ? (int) $this->get('limit') : 50; 
            $offset = $this->get('offset') ? (int) $this->get('offset') : 0;
            $data = $this->purchase_model->get_all($company_id, $outlet_id, $limit, $offset);
            
            
            foreach ($data as &$purchase) {
                $purchase->id = (int) $purchase->id;
                $purchase->supplier_id = (int) $purchase->supplier_id;
                $purchase->grand_total = (float) $purchase->grand_total;
                $purchase->paid = (float) $purchase->paid;
                $purchase->due = (float) $purchase->due;
                foreach ($purchase->items as &$item) {
                    $item->ingredient_id = (int) $item->ingredient_id;
                    $item->quantity_amount = (float) $item->quantity_amount;
                    $item->unit_price = (float) $item->unit_price;
                    $item->total = (float) $item->total;
                }
            }
            
            json_response(REST_Controller::HTTP_OK, 'success', 'Purchases list retrieved.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = $this->get_json_request_data(true);
        if (!$request_data) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid JSON payload.', null, $this);
            return;
        }
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required|numeric');
        $this->form_validation->set_rules('outlet_id', 'Outlet', 'required|numeric');
        $this->form_validation->set_rules('date', 'Date', 'required');
        if (!isset($request_data['items']) || !is_array($request_data['items']) || empty($request_data['items'])) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Items are required and must be a non-empty array.', null, $this);
            return;
        }
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
            return;
        }
        $purchase_data = [
            'reference_no' => $request_data['reference_no'] ?? 'P-' . uniqid(),
            'supplier_id' => $request_data['supplier_id'],
            'outlet_id' => $request_data['outlet_id'],
            'date' => date('Y-m-d', strtotime($request_data['date'])),
            'paid' => $request_data['paid'] ?? 0,
            'note' => $request_data['note'] ?? null,
            'items' => $request_data['items'],
            'user_id' => $this->auth_data->user_id,
'payment_id' => $request_data['payment_method_id'] ?? 0,
 
        ];
        $new_id = $this->purchase_model->create($purchase_data);
        if ($new_id) {
            $new_purchase = $this->purchase_model->get_by_id($new_id, $this->auth_data->company_id);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Purchase created successfully.', $new_purchase, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create purchase.', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = $this->get_json_request_data(true);
        if (!$request_data) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid or empty JSON payload.', null, $this);
            return;
        }
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required|numeric');
        $this->form_validation->set_rules('outlet_id', 'Outlet', 'required|numeric');
        $this->form_validation->set_rules('date', 'Date', 'required');
        if (!isset($request_data['items']) || !is_array($request_data['items']) || empty($request_data['items'])) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'The Items field is required and must be a non-empty array.', null, $this);
            return;
        }
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
            return;
        }
        $purchase_data = [
            'supplier_id' => $request_data['supplier_id'],
            'outlet_id' => $request_data['outlet_id'],
            'date' => date('Y-m-d', strtotime($request_data['date'])),
            'paid' => $request_data['paid'] ?? 0,
            'note' => $request_data['note'] ?? null,
            'items' => $request_data['items'],
'payment_id' => $request_data['payment_method_id'] ?? 0,

        ];
        if (isset($request_data['reference_no'])) {
            $purchase_data['reference_no'] = $request_data['reference_no'];
        }
        $company_id = $this->auth_data->company_id;
        if ($this->purchase_model->update($id, $purchase_data, $company_id)) {
            $updated_purchase = $this->purchase_model->get_by_id($id, $company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Purchase updated successfully.', $updated_purchase, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update purchase or purchase not found.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->purchase_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Purchase deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete purchase.', null, $this);
        }
    }
}
