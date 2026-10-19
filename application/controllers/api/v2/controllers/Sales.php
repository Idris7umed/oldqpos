<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Sales extends API_Controller
{
  public function __construct()
{
    parent::__construct();
    
    $this->load->model('api_sale_model', 'sale_model'); 
}

    
    
  public function index_get()
{
    $outlet_id = $this->input->get('outlet_id');
    if (!$outlet_id || !is_numeric($outlet_id)) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'A valid Outlet ID is required.', null, $this);
    }
    $status = $this->input->get('status');
    $is_self_order = $this->input->get('is_self_order');
    $is_online_order = $this->input->get('is_online_order');
    
    $with_details = $this->input->get('with_details') === 'true';

    $company_id = $this->auth_data->company_id;
    $limit = $this->input->get('limit') ? (int) $this->input->get('limit') : 100;
    $offset = $this->input->get('offset') ? (int) $this->input->get('offset') : 0;
    
    $user_info = [
        'user_id' => $this->auth_data->user_id,
        'role' => $this->auth_data->role,
        'is_waiter' => ($this->auth_data->designation == 'Waiter') ? 'Yes' : 'No'
    ];

    
    
    
    $sales_list = $this->sale_model->get_sales_list($company_id, $outlet_id, $limit, $offset, $status, $is_self_order, $is_online_order, $user_info, $with_details);

    
    $total_records = $this->sale_model->get_sales_count($company_id, $outlet_id, $status, $is_self_order, $is_online_order, $user_info);

    $response_data = [
        'pagination' => [
            'total_records' => (int)$total_records,
            'limit' => $limit,
            'offset' => $offset,
            'current_page' => floor($offset / $limit) + 1,
            'total_pages' => ceil($total_records / $limit)
        ],
        'sales' => $sales_list
    ];
    json_response(REST_Controller::HTTP_OK, 'success', 'Sales list retrieved.', $response_data, $this);
}
    public function details_get($sale_id)
    {
        if (empty($sale_id) || !is_numeric($sale_id)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid Sale ID provided.', null, $this);
        }

        $company_id = $this->auth_data->company_id;
        $is_running = false; 
        $sale_details = $this->sale_model->get_sale_details_by_id($sale_id, $company_id, $is_running);

        if ($sale_details) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Sale details found.', $sale_details, $this);
        } else {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Sale not found.', null, $this);
        }
    }

public function running_details_get($sale_id)
{
    if (empty($sale_id) || !is_numeric($sale_id)) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid Sale ID provided.', null, $this);
    }
    
    $outlet_id = $this->input->get('outlet_id');
    if (!$outlet_id || !is_numeric($outlet_id)) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'A valid Outlet ID is required.', null, $this);
    }
    
    $company_id = $this->auth_data->company_id;
    
    
    $sale_details = $this->sale_model->get_running_sale_details_by_id($sale_id, $company_id, $outlet_id);
    
    if ($sale_details) {
        json_response(REST_Controller::HTTP_OK, 'success', 'Running order details found.', $sale_details, $this);
    } else {
        json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Running order not found.', null, $this);
    }
}
 public function index_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);

        if (!isset($request_data['outlet_id']) || !isset($request_data['customer_id']) || !isset($request_data['items'])) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Missing required fields (outlet_id, customer_id, items).', null, $this);
        }
        if (empty($request_data['items'])) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Items array cannot be empty.', null, $this);
        }

        $request_data['company_id'] = $this->auth_data->company_id;
        $request_data['user_id'] = $this->auth_data->user_id;

        $is_final_sale = isset($request_data['payments']) && !empty($request_data['payments']);
        
        $result = null;
        if ($is_final_sale) {
            $result = $this->sale_model->create_sale($request_data);
        } else {
            $result = $this->sale_model->create_or_update_running_order($request_data);
        }

        if (isset($result['status']) && $result['status']) {
            $response_data = [
                'sale_id' => $result['sale_id'],
                'sale_no' => $result['sale_no']
            ];
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Sale processed successfully.', $response_data, $this);
        } else {
            $error_message = $result['message'] ?? 'Failed to process sale.';
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', $error_message, null, $this);
        }
    }
  public function index_put($sale_id)
{
    if (empty($sale_id) || !is_numeric($sale_id)) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid Sale ID provided.', null, $this);
    }

    $request_data = json_decode(file_get_contents('php://input'), true);

    if (!isset($request_data['outlet_id']) || !isset($request_data['customer_id']) || !isset($request_data['items'])) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Missing required fields (outlet_id, customer_id, items).', null, $this);
    }
    
    $request_data['company_id'] = $this->auth_data->company_id;
    $request_data['user_id'] = $this->auth_data->user_id;

    
    $is_final_sale = isset($request_data['payments']) && !empty($request_data['payments']);

    if ($is_final_sale) {
        
        $result = $this->sale_model->finalize_running_order($sale_id, $request_data);
    } else {
        
        $result = $this->sale_model->create_or_update_running_order($request_data, $sale_id);
    }
    

    if (isset($result['status']) && $result['status']) {
        $response_data = [
            'sale_id' => $result['sale_id'],
            'sale_no' => $result['sale_no']
        ];
        json_response(REST_Controller::HTTP_OK, 'success', 'Sale processed successfully.', $response_data, $this);
    } else {
        $error_message = $result['message'] ?? 'Failed to process sale.';
        json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', $error_message, null, $this);
    }
}
      public function index_delete($sale_id)
    {
        if (empty($sale_id) || !is_numeric($sale_id)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid Sale ID provided.', null, $this);
        }
        
        $request_data = json_decode(file_get_contents('php://input'), true);
        $outlet_id = $request_data['outlet_id'] ?? null;

        if (!$outlet_id) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required in request body.', null, $this);
        }

        $company_id = $this->auth_data->company_id;
        
        $result = $this->sale_model->delete_sale($sale_id, $company_id, $outlet_id);

        if ($result['status']) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Sale cancelled successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', $result['message'], null, $this);
        }
    }
    public function split_sale_post($original_sale_id)
{
    if (empty($original_sale_id) || !is_numeric($original_sale_id)) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid Original Sale ID provided.', null, $this);
    }

    $request_data = json_decode(file_get_contents('php://input'), true);

    
    if (!isset($request_data['items']) || !isset($request_data['payments'])) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Missing required fields (items, payments).', null, $this);
    }

    
    $request_data['company_id'] = $this->auth_data->company_id;
    $request_data['user_id'] = $this->auth_data->user_id;
    
    
    $result = $this->sale_model->process_split_sale($original_sale_id, $request_data);

    if (isset($result['status']) && $result['status']) {
        $response_data = [
            'new_sale_id' => $result['new_sale_id'],
            'new_sale_no' => $result['new_sale_no'],
            'original_sale_updated' => $result['original_sale_updated']
        ];
        json_response(REST_Controller::HTTP_CREATED, 'success', 'Sale split successfully.', $response_data, $this);
    } else {
        $error_message = $result['message'] ?? 'Failed to split sale.';
        json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', $error_message, null, $this);
    }
}
public function process_refund_post($sale_id)
{
    if (empty($sale_id) || !is_numeric($sale_id)) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid Sale ID provided.', null, $this);
    }

    $request_data = json_decode(file_get_contents('php://input'), true);

    
    if (!isset($request_data['items']) || !isset($request_data['total_refund_amount']) || !isset($request_data['payment_method_id'])) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Missing required fields (items, total_refund_amount, payment_method_id).', null, $this);
    }

    $request_data['user_id'] = $this->auth_data->user_id;
    $request_data['company_id'] = $this->auth_data->company_id;
    
    
    $result = $this->sale_model->execute_refund($sale_id, $request_data);

    if (isset($result['status']) && $result['status']) {
        json_response(REST_Controller::HTTP_OK, 'success', 'Refund processed successfully.', null, $this);
    } else {
        $error_message = $result['message'] ?? 'Failed to process refund.';
        json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', $error_message, null, $this);
    }
}
public function change_date_put($sale_id)
{
    if (empty($sale_id) || !is_numeric($sale_id)) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid Sale ID provided.', null, $this);
    }

    $request_data = json_decode(file_get_contents('php://input'), true);
    $new_date = $request_data['sale_date'] ?? null;

    if (!$new_date || !DateTime::createFromFormat('Y-m-d', $new_date)) {
        json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'A valid sale date in Y-m-d format is required.', null, $this);
    }
    
    $company_id = $this->auth_data->company_id;

    $this->db->where('id', $sale_id);
    $this->db->where('company_id', $company_id);
    $update_result = $this->db->update('tbl_sales', ['sale_date' => $new_date]);

    if ($update_result) {
        json_response(REST_Controller::HTTP_OK, 'success', 'Sale date updated successfully.', null, $this);
    } else {
        json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update sale date.', null, $this);
    }
}

    public function change_delivery_status_put($sale_id)
    {
        if (empty($sale_id) || !is_numeric($sale_id)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid Sale ID provided.', null, $this);
            return;
        }

        $request_data = json_decode(file_get_contents('php://input'), true);
        $new_status = $request_data['status'] ?? null;
        $allowed_statuses = ['Pending', 'Delivered', 'Cancelled']; 

        if (!$new_status || !in_array($new_status, $allowed_statuses)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'A valid status (Pending, Delivered, Cancelled) is required.', null, $this);
            return;
        }

        $company_id = $this->auth_data->company_id;

        
        $sale = $this->db->get_where('tbl_sales', ['id' => $sale_id, 'company_id' => $company_id])->row();

        if (!$sale) {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Sale not found.', null, $this);
            return;
        }
        
        
        $this->db->where('id', $sale_id);
        $update_result = $this->db->update('tbl_sales', ['status' => $new_status]);

        if ($update_result) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Delivery status updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update delivery status.', null, $this);
        }
    }
  public function transfer_order_put($sale_id)
    {
        if (empty($sale_id) || !is_numeric($sale_id)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid Sale ID provided.', null, $this);
            return;
        }

        $request_data = json_decode(file_get_contents('php://input'), true);
        $new_table_id = $request_data['new_table_id'] ?? null;
        $outlet_id = $request_data['outlet_id'] ?? null;

        if (!$new_table_id || !is_numeric($new_table_id)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'A valid new_table_id is required.', null, $this);
            return;
        }
        
        if (!$outlet_id || !is_numeric($outlet_id)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'A valid outlet_id is required.', null, $this);
            return;
        }

        $company_id = $this->auth_data->company_id;

        $result = $this->sale_model->transfer_running_order($sale_id, $new_table_id, $company_id, $outlet_id);

        if (isset($result['status']) && $result['status']) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Order transferred successfully.', null, $this);
        } else {
            $error_message = $result['message'] ?? 'Failed to transfer order.';
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', $error_message, null, $this);
        }
    }
     public function merge_orders_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        $order_ids = $request_data['order_ids'] ?? null;

        if (!$order_ids || !is_array($order_ids) || count($order_ids) < 2) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'At least two order IDs are required to merge.', null, $this);
            return;
        }

        $company_id = $this->auth_data->company_id;
        $outlet_id = $this->auth_data->outlet_id;

        $result = $this->sale_model->merge_running_orders($order_ids, $company_id, $outlet_id);

        if (isset($result['status']) && $result['status']) {
            $response_data = [
                'primary_sale_id' => $result['primary_sale_id'],
                'merged_sale_ids' => $result['merged_sale_ids']
            ];
            json_response(REST_Controller::HTTP_OK, 'success', 'Orders merged successfully.', $response_data, $this);
        } else {
            $error_message = $result['message'] ?? 'Failed to merge orders.';
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', $error_message, null, $this);
        }
    }
    

    
}