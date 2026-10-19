<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Food_menus extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_food_menu_model', 'food_menu_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        $outlet_id = $this->get('outlet_id');

        if (!$id && !$outlet_id) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Outlet ID is required when fetching all menus.', null, $this);
        }

        if ($id > 0) {
            $data = $this->food_menu_model->get_by_id($id, $company_id, $outlet_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Food menu found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Food menu not found.', null, $this);
            }
        } else {
            $data = $this->food_menu_model->get_all($company_id, $outlet_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Food menus list.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        if (empty($request_data)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Request body is empty.', null, $this);
        }
        $this->_validate_food_menu($request_data);
        $menu_data = $this->_prepare_menu_data($request_data);
        $this->food_menu_model->auth_data = $this->auth_data;

        $new_id = $this->food_menu_model->create_or_update($menu_data);

        if ($new_id) {
            $outlet_id = $request_data['outlet_id'] ?? null;
            $new_menu = $this->food_menu_model->get_by_id($new_id, $this->auth_data->company_id, $outlet_id);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Food menu created successfully.', $new_menu, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create food menu.', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        if (empty($request_data)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Request body is empty.', null, $this);
        }

        $this->_validate_food_menu($request_data, $id);
        $menu_data = $this->_prepare_menu_data($request_data);
        $company_id = $this->auth_data->company_id;
        $this->food_menu_model->auth_data = $this->auth_data;

        if (!$this->food_menu_model->get_by_id($id, $company_id)) {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Food menu not found.', null, $this);
        }

        if ($this->food_menu_model->create_or_update($menu_data, $id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Food menu updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update food menu.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->food_menu_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Food menu deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete food menu.', null, $this);
        }
    }

    private function _validate_food_menu($data, $id = null)
    {
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('name', 'Name', 'required|max_length[250]');
        $this->form_validation->set_rules('category_id', 'Category', 'required|numeric');
        $this->form_validation->set_rules('sale_price', 'Sale Price', 'required|numeric');
        $this->form_validation->set_rules('product_type', 'Product Type', 'required|regex_match[/^[1-3]$/]');

        if (isset($data['product_type']) && $data['product_type'] == 3) {
            $this->form_validation->set_rules('purchase_price', 'Purchase Price', 'required|numeric');
            $this->form_validation->set_rules('alert_quantity', 'Alert Quantity', 'required|numeric');
            $this->form_validation->set_rules('ing_category_id', 'Ingredient Category', 'required|numeric');
        }

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
    }

    private function _prepare_menu_data($request_data)
    {
        return [
            'name' => $request_data['name'],
            'alternative_name' => $request_data['alternative_name'] ?? null,
            'code' => $request_data['code'] ?? 'FM-' . uniqid(),
            'category_id' => $request_data['category_id'],
            'sale_price' => $request_data['sale_price'],
            'sale_price_take_away' => $request_data['sale_price_take_away'] ?? $request_data['sale_price'],
            'delivery_price' => is_array($request_data['sale_price_delivery']) ? json_encode($request_data['sale_price_delivery']) : ($request_data['sale_price_delivery'] ?? $request_data['sale_price']),
            'description' => $request_data['description'] ?? null,
            'veg_item' => $request_data['veg_item'] ?? 'Veg No',
            'beverage_item' => $request_data['beverage_item'] ?? 'Beverage No',
            'loyalty_point' => $request_data['loyalty_point'] ?? null,
            'tax_information' => isset($request_data['tax_information']) ? json_encode($request_data['tax_information']) : null,
            'photo' => $request_data['photo'] ?? null,
            'product_type' => $request_data['product_type'],
            'purchase_price' => $request_data['purchase_price'] ?? null,
            'alert_quantity' => $request_data['alert_quantity'] ?? null,
            'ing_category_id' => $request_data['ing_category_id'] ?? null,
            'ingredients' => $request_data['ingredients'] ?? [],
            'modifiers' => $request_data['modifiers'] ?? [],
            'combo_items' => $request_data['combo_items'] ?? [],
            'variations' => $request_data['variations'] ?? [],
            'user_id' => $this->auth_data->user_id,
            'company_id' => $this->auth_data->company_id,
        ];
    }
}