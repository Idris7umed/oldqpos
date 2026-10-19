<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_sale_model extends CI_Model
{
    public function get_sales_list($company_id, $outlet_id, $limit = 100, $offset = 0, $status = null, $is_self_order = null, $is_online_order = null, $user_info = null, $with_details = false)
    {
        if ($status == 'running') {
            $this->db->select('s.id, s.sale_no, s.total_payable, s.date_time as sale_date, c.name as customer_name, s.waiter_id, u.full_name as waiter_name, s.order_status, s.table_id, s.order_type, s.date_time, tbl.name as table_name');
            $this->db->from('tbl_kitchen_sales s');
            $this->db->join('tbl_customers c', 's.customer_id = c.id', 'left');
            $this->db->join('tbl_users u', 's.waiter_id = u.id', 'left');
            $this->db->join('tbl_tables tbl', 's.table_id = tbl.id', 'left');
            $this->db->where('s.company_id', $company_id);
            $this->db->where('s.outlet_id', $outlet_id);
            $this->db->where('s.del_status', 'Live');
            $this->db->where_in('s.order_status', ['1', '2']);

            if ($is_self_order) {
                $this->db->where('s.is_self_order', 'Yes');
            }
            if ($is_online_order) {
                $this->db->where('s.is_online_order', 'Yes');
            }

            if ($user_info) {
                if (isset($user_info['is_waiter']) && $user_info['is_waiter'] == 'Yes') {
                    $this->db->where('s.waiter_id', $user_info['user_id']);
                } else {
                    if (isset($user_info['role']) && $user_info['role'] != 'Admin') {
                        $this->db->where('s.user_id', $user_info['user_id']);
                    }
                }
            }
            $this->db->order_by('s.id', 'ASC');
            $sales = $this->db->get()->result();
            foreach ($sales as $key => $sale) {
                $sales[$key]->total_kitchen_type_items = $this->get_total_kitchen_type_items($sale->id, 'tbl_kitchen_sales_details');
                $sales[$key]->total_kitchen_type_done_items = $this->get_total_kitchen_type_done_items($sale->id, 'tbl_kitchen_sales_details');
                $sales[$key]->total_kitchen_type_started_cooking_items = $this->get_total_kitchen_type_started_cooking_items($sale->id, 'tbl_kitchen_sales_details');
                $sales[$key]->tables_booked = $this->get_all_tables_of_a_sale_items($sale->id);
                $to_time = strtotime(date('Y-m-d H:i:s'));
                $from_time = strtotime($sale->date_time);
                $minutes = floor(abs($to_time - $from_time) / 60);
                $seconds = abs($to_time - $from_time) % 60;
                $sales[$key]->minute_difference = str_pad(floor($minutes), 2, '0', STR_PAD_LEFT);
                $sales[$key]->second_difference = str_pad(floor($seconds), 2, '0', STR_PAD_LEFT);
            }
            return $sales;
        } else {
            if ($status == 'new') {
                $this->db->select('s.id, s.sale_no, s.total_payable, s.date_time as sale_date, c.name as customer_name, u.full_name as waiter_name, s.order_status, s.table_id, s.order_type');
                $this->db->from('tbl_kitchen_sales s');
                $this->db->where_in('s.order_status', ['1', '2']);
            } else {
                $this->db->select('s.id, s.sale_no, s.total_payable, s.date_time as sale_date, c.name as customer_name, u.full_name as waiter_name, s.order_status, s.table_id, s.total_refund, s.refund_content, s.order_type');
                $this->db->from('tbl_sales s');
                $this->db->where('s.order_status', '3');
            }

            $this->db->join('tbl_customers c', 's.customer_id = c.id', 'left');
            $this->db->join('tbl_users u', 's.waiter_id = u.id', 'left');
            $this->db->where('s.company_id', $company_id);
            $this->db->where('s.outlet_id', $outlet_id);
            $this->db->where('s.del_status', 'Live');

            if ($is_self_order) {
                $this->db->where('s.is_self_order', 'Yes');
            }
            if ($is_online_order) {
                $this->db->where('s.is_online_order', 'Yes');
            }

            $this->db->order_by('s.id', 'DESC');

            if ($status != 'new') {
                $this->db->limit($limit, $offset);
            }

            $sales = $this->db->get()->result();
            if (empty($sales)) {
                return [];
            }
            $sale_ids = array_column($sales, 'id');

            $details_table = ($status == 'new') ? 'tbl_kitchen_sales_details' : 'tbl_sales_details';
            $details_mod_table = ($status == 'new') ? 'tbl_kitchen_sales_details_modifiers' : 'tbl_sales_details_modifiers';

            $this->db->select('sales_id, food_menu_id, menu_name, qty, menu_unit_price, discount_amount as discount, menu_note, id as sale_detail_id');
            $this->db->from($details_table);
            $this->db->where_in('sales_id', $sale_ids);
            $this->db->where('del_status', 'Live');
            $sale_items_raw = $this->db->get()->result();
            $sale_items = [];
            foreach ($sale_items_raw as $item) {
                $item->total = ($item->qty * $item->menu_unit_price) - $item->discount;
                $sale_items[$item->sales_id][] = $item;
            }
            $sale_detail_ids = array_column($sale_items_raw, 'sale_detail_id');
            $sale_modifiers = [];
            if (!empty($sale_detail_ids)) {
                $this->db->select('sdm.sales_details_id, sdm.modifier_id, m.name as modifier_name, sdm.modifier_price');
                $this->db->from($details_mod_table . ' sdm');
                $this->db->join('tbl_modifiers m', 'm.id = sdm.modifier_id', 'left');
                $this->db->where_in('sdm.sales_details_id', $sale_detail_ids);
                $sale_modifiers_raw = $this->db->get()->result();
                foreach ($sale_modifiers_raw as $mod) {
                    $sale_modifiers[$mod->sales_details_id][] = $mod;
                }
            }
            foreach ($sales as $sale) {
                $sale->items = [];
                if (isset($sale_items[$sale->id])) {
                    foreach ($sale_items[$sale->id] as $item) {
                        $item->modifiers = $sale_modifiers[$item->sale_detail_id] ?? [];
                        unset($item->sale_detail_id);
                        $sale->items[] = $item;
                    }
                }
            }
            return $sales;
        }
    }

    public function get_sales_count($company_id, $outlet_id, $status = null, $is_self_order = null, $is_online_order = null, $user_info = null)
    {
        if ($status == 'running' || $status == 'new') {
            $this->db->from('tbl_kitchen_sales');
            $this->db->where_in('order_status', ['1', '2']);
            if ($user_info) {
                if (isset($user_info['is_waiter']) && $user_info['is_waiter'] == 'Yes') {
                    $this->db->where('waiter_id', $user_info['user_id']);
                } else {
                    if (isset($user_info['role']) && $user_info['role'] != 'Admin') {
                        $this->db->where('user_id', $user_info['user_id']);
                    }
                }
            }
        } else {
            $this->db->from('tbl_sales');
            $this->db->where('order_status', '3');
        }
        $this->db->where('company_id', $company_id);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('del_status', 'Live');

        if ($is_self_order) {
            $this->db->where('is_self_order', 'Yes');
        }
        if ($is_online_order) {
            $this->db->where('is_online_order', 'Yes');
        }

        return $this->db->count_all_results();
    }

    public function get_total_kitchen_type_items($sale_id, $table = 'tbl_sales_details')
    {
        $this->db->select('id');
        $this->db->from($table);
        $this->db->where('sales_id', $sale_id);
        return $this->db->get()->num_rows();
    }

    public function get_total_kitchen_type_done_items($sale_id, $table = 'tbl_sales_details')
    {
        $this->db->select('id');
        $this->db->from($table);
        $this->db->where('sales_id', $sale_id);
        $this->db->where('cooking_status', 'Done');
        return $this->db->get()->num_rows();
    }

    public function get_total_kitchen_type_started_cooking_items($sale_id, $table = 'tbl_sales_details')
    {
        $this->db->select('id');
        $this->db->from($table);
        $this->db->where('sales_id', $sale_id);
        $this->db->where('cooking_status', 'Started Cooking');
        return $this->db->get()->num_rows();
    }

    public function get_sale_details_by_id($sale_id, $company_id)
    {
        $this->db->select('s.*, c.name as customer_name, u.full_name as user_full_name');
        $this->db->from('tbl_sales s');
        $this->db->join('tbl_customers c', 's.customer_id = c.id', 'left');
        $this->db->join('tbl_users u', 's.user_id = u.id', 'left');
        $this->db->where('s.id', $sale_id);
        $this->db->where('s.company_id', $company_id);
        $sale = $this->db->get()->row();
        if (!$sale) {
            return null;
        }
        $this->db->select('sd.menu_name, sd.qty, sd.menu_unit_price, (sd.qty * sd.menu_unit_price) as total');
        $this->db->from('tbl_sales_details sd');
        $this->db->where('sd.sales_id', $sale_id);
        $this->db->where('sd.del_status', 'Live');
        $sale->items = $this->db->get()->result();
        return $sale;
    }

    public function get_running_sale_details_by_id($sale_id, $company_id, $outlet_id)
    {
        $this->db->select('s.*, c.name as customer_name, u.full_name as user_full_name, w.full_name as waiter_name');
        $this->db->from('tbl_kitchen_sales s');
        $this->db->join('tbl_customers c', 's.customer_id = c.id', 'left');
        $this->db->join('tbl_users u', 's.user_id = u.id', 'left');
        $this->db->join('tbl_users w', 's.waiter_id = w.id', 'left');
        $this->db->where('s.id', $sale_id);
        $this->db->where('s.company_id', $company_id);
        $this->db->where('s.outlet_id', $outlet_id);
        $this->db->where_in('s.order_status', ['1', '2']);
        $this->db->where('s.del_status', 'Live');
        $sale = $this->db->get()->row();
        if (!$sale) {
            return null;
        }

        $this->db->select('sd.*, fm.name as menu_name, (sd.qty * sd.menu_unit_price) as total');
        $this->db->from('tbl_kitchen_sales_details AS sd');
        $this->db->join('tbl_food_menus AS fm', 'fm.id = sd.food_menu_id', 'left');
        $this->db->where('sd.sales_id', $sale_id);
        $this->db->where('sd.del_status', 'Live');
        $sale->items = $this->db->get()->result();

        if (!empty($sale->items)) {
            foreach ($sale->items as $item) {
                $this->db->select('md.*, m.name as modifier_name');
                $this->db->from('tbl_kitchen_sales_details_modifiers AS md');
                $this->db->join('tbl_modifiers AS m', 'm.id = md.modifier_id', 'left');
                $this->db->where('md.sales_details_id', $item->id);
                $item->modifiers = $this->db->get()->result();
            }
        }
        if (isset($sale->sale_vat_objects) && is_string($sale->sale_vat_objects)) {
            $sale->sale_vat_objects = json_decode($sale->sale_vat_objects);
        }
        if (isset($sale->self_order_content) && is_string($sale->self_order_content)) {
            $decoded_once = json_decode($sale->self_order_content);
            if (is_string($decoded_once)) {
                $sale->self_order_content = json_decode($decoded_once);
            } else {
                $sale->self_order_content = $decoded_once;
            }
        }
        return $sale;
    }

    public function get_all_tables_of_a_sale_items($sale_id)
    {
        $this->db->select('tbl_tables.name as table_name');
        $this->db->from('tbl_orders_table');
        $this->db->join('tbl_tables', 'tbl_tables.id = tbl_orders_table.table_id', 'left');
        $this->db->where('sale_id', $sale_id);
        $this->db->where('tbl_orders_table.del_status', 'Live');
        $result = $this->db->get();
        if ($result != false) {
            return $result->result();
        } else {
            return false;
        }
    }

    public function create_sale($sale_data)
    {
        $this->db->trans_start();
        $totals = $this->_calculate_totals($sale_data);
        if (!$totals['success']) {
            $this->db->trans_rollback();
            return ['status' => false, 'message' => $totals['message']];
        }
        $main_sale_data = [
            'customer_id' => $sale_data['customer_id'],
            'outlet_id' => $sale_data['outlet_id'],
            'waiter_id' => $sale_data['waiter_id'] ?? null,
            'order_type' => $sale_data['order_type'],
            'company_id' => $sale_data['company_id'],
            'user_id' => $sale_data['user_id'],
            'sale_date' => date('Y-m-d'),
            'date_time' => date('Y-m-d H:i:s'),
            'order_time' => date('H:i:s'),
            'paid_date_time' => date('Y-m-d H:i:s'),
            'order_status' => 3,
            'sub_total' => $totals['sub_total'],
            'vat' => $totals['total_vat'],
            'total_discount_amount' => $totals['total_discount'],
            'delivery_charge_actual_charge' => $totals['delivery_charge'],
            'total_payable' => $totals['total_payable'],
            'paid_amount' => $totals['paid_amount'],
            'due_amount' => $totals['due_amount'],
            'sale_vat_objects' => json_encode($totals['vat_details']),
            'split_sale_id' => $sale_data['split_sale_id'] ?? null,
            'zatca_value' => $sale_data['zatca_invoice_value'] ?? null,
            'delivery_charge_actual_charge' => $totals['delivery_charge'],
            'tips_amount_actual_charge' => $sale_data['tips_amount_actual_charge'] ?? 0,
        ];
        $this->db->insert('tbl_sales', $main_sale_data);
        $sale_id = $this->db->insert_id();
        $sale_no = '';
        if (isset($sale_data['existing_sale_no']) && !empty($sale_data['existing_sale_no'])) {
            $sale_no = $sale_data['existing_sale_no'];
        } else {
            $sale_no_prefix = $this->db->select('short_name')->get_where('tbl_companies', ['id' => $sale_data['company_id']])->row('short_name');
            $sale_no = $sale_no_prefix . str_pad($sale_id, 8, '0', STR_PAD_LEFT);
        }
        $this->db->where('id', $sale_id)->update('tbl_sales', ['sale_no' => $sale_no]);
        $data_sale_consumptions = [
            'sale_id' => $sale_id,
            'user_id' => $sale_data['user_id'],
            'outlet_id' => $sale_data['outlet_id'],
            'del_status' => 'Live',
        ];
        $this->db->insert('tbl_sale_consumptions', $data_sale_consumptions);
        $sale_consumption_id = $this->db->insert_id();
        foreach ($totals['items'] as $item) {
            $food_details = $this->db->get_where('tbl_food_menus', ['id' => $item['food_menu_id']])->row();
            $sale_detail_data = [
                'sales_id' => $sale_id,
                'food_menu_id' => $item['food_menu_id'],
                'menu_name' => $item['name'],
                'qty' => $item['qty'],
                'menu_unit_price' => $item['price'],
                'menu_price_without_discount' => ($item['price'] * $item['qty']),
                'menu_price_with_discount' => ($item['price'] * $item['qty']),
                'outlet_id' => $sale_data['outlet_id'],
                'user_id' => $sale_data['user_id'],
                'del_status' => 'Live'
            ];
            $this->db->insert('tbl_sales_details', $sale_detail_data);
            $sale_detail_id = $this->db->insert_id();
            $food_menu_ingredients = $this->db->get_where('tbl_food_menus_ingredients', ['food_menu_id' => $item['food_menu_id']])->result();
            foreach ($food_menu_ingredients as $ingredient) {
                $consumption_detail = [
                    'ingredient_id' => $ingredient->ingredient_id,
                    'consumption' => $item['qty'] * $ingredient->consumption,
                    'sale_consumption_id' => $sale_consumption_id,
                    'sales_id' => $sale_id,
                    'food_menu_id' => $item['food_menu_id'],
                    'user_id' => $sale_data['user_id'],
                    'outlet_id' => $sale_data['outlet_id'],
                    'del_status' => 'Live',
                ];
                $this->db->insert('tbl_sale_consumptions_of_menus', $consumption_detail);
            }
            if (isset($item['modifiers']) && count($item['modifiers'])) {
                foreach ($item['modifiers'] as $modifier) {
                    $modifier_data = [
                        'sales_id' => $sale_id,
                        'sales_details_id' => $sale_detail_id,
                        'modifier_id' => $modifier['modifier_id'],
                        'modifier_price' => $modifier['price'],
                        'food_menu_id' => $item['food_menu_id'],
                        'outlet_id' => $sale_data['outlet_id'],
                        'user_id' => $sale_data['user_id'],
                        'customer_id' => $sale_data['customer_id']
                    ];
                    $this->db->insert('tbl_sales_details_modifiers', $modifier_data);
                    $modifier_ingredients = $this->db->get_where('tbl_modifier_ingredients', ['modifier_id' => $modifier['modifier_id']])->result();
                    foreach ($modifier_ingredients as $mod_ingredient) {
                        $consumption_mod_detail = [
                            'ingredient_id' => $mod_ingredient->ingredient_id,
                            'consumption' => $item['qty'] * $mod_ingredient->consumption,
                            'sale_consumption_id' => $sale_consumption_id,
                            'sales_id' => $sale_id,
                            'food_menu_id' => $item['food_menu_id'],
                            'user_id' => $sale_data['user_id'],
                            'outlet_id' => $sale_data['outlet_id'],
                            'del_status' => 'Live'
                        ];
                        $this->db->insert('tbl_sale_consumptions_of_modifiers_of_menus', $consumption_mod_detail);
                    }
                }
            }
        }
        foreach ($sale_data['payments'] as $payment) {
            $payment_data = [
                'sale_id' => $sale_id,
                'payment_id' => $payment['payment_method_id'],
                'amount' => $payment['amount'],
                'outlet_id' => $sale_data['outlet_id'],
                'user_id' => $sale_data['user_id'],
                'date_time' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('tbl_sale_payments', $payment_data);
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return ['status' => false, 'message' => 'Database transaction failed.'];
        } else {
            return ['status' => true, 'sale_id' => $sale_id, 'sale_no' => $sale_no];
        }
    }

    public function _calculate_totals($sale_data)
    {
        $sub_total = 0;
        $processed_items = [];
        $total_item_discount = 0;
        foreach ($sale_data['items'] as $item) {
            $food_menu_id_to_find = null;
            if (isset($item['food_menu_id']) && !empty($item['food_menu_id'])) {
                $food_menu_id_to_find = $item['food_menu_id'];
            } else if (isset($item['original_detail_id']) && !empty($item['original_detail_id'])) {
                $original_item = $this->db->select('food_menu_id')->get_where('tbl_kitchen_sales_details', ['id' => $item['original_detail_id']])->row();
                if ($original_item) {
                    $food_menu_id_to_find = $original_item->food_menu_id;
                }
            }
            if (!$food_menu_id_to_find) {
                return ['success' => false, 'message' => 'Could not determine Food Menu ID for one of the items.'];
            }
            $food_menu = $this->db->get_where('tbl_food_menus', ['id' => $food_menu_id_to_find])->row();
            if (!$food_menu) {
                return ['success' => false, 'message' => "Food menu with ID {$food_menu_id_to_find} not found."];
            }
            $item_price = $food_menu->sale_price;
            $item_total = $item_price * $item['qty'];
            $processed_item = [
                'food_menu_id' => $food_menu->id,
                'name' => $food_menu->name,
                'price' => $item_price,
                'qty' => $item['qty'],
                'cooking_status' => isset($item['cooking_status']) ? $item['cooking_status'] : 'New',
                'note' => isset($item['note']) ? $item['note'] : null,
                'modifiers' => []
            ];
            if (isset($item['modifiers']) && count($item['modifiers'])) {
                foreach ($item['modifiers'] as $mod) {
                    $modifier = $this->db->get_where('tbl_modifiers', ['id' => $mod['modifier_id']])->row();
                    if (!$modifier) {
                        return ['success' => false, 'message' => "Modifier with ID {$mod['modifier_id']} not found."];
                    }
                    $item_total += $modifier->price * $item['qty'];
                    $processed_item['modifiers'][] = ['modifier_id' => $modifier->id, 'price' => $modifier->price];
                }
            }
            if (isset($item['discount']) && $item['discount'] > 0) {
                $item_total -= $item['discount'];
                $total_item_discount += $item['discount'];
            }
            $sub_total += $item_total;
            $processed_items[] = $processed_item;
        }
        $order_discount = 0;
        if (isset($sale_data['sub_total_discount_value']) && $sale_data['sub_total_discount_value']) {
            if (strpos($sale_data['sub_total_discount_value'], '%') !== false) {
                $percentage = (float) str_replace('%', '', $sale_data['sub_total_discount_value']);
                $order_discount = ($sub_total * $percentage) / 100;
            } else {
                $order_discount = (float) $sale_data['sub_total_discount_value'];
            }
        }
        $total_discount = $total_item_discount + $order_discount;
        $sub_total_after_discount = $sub_total - $order_discount;
        $company_info = getCompanyInfo();
        $total_vat = 0;
        $vat_details = [];
        if ($company_info->collect_tax == 'Yes' && $company_info->tax_setting) {
            $taxes = json_decode($company_info->tax_setting);
            foreach ($taxes as $tax) {
                $tax_amount = ($sub_total_after_discount * (float) $tax->tax_rate) / 100;
                $total_vat += $tax_amount;
                $vat_details[] = [
                    'tax_field_id' => $tax->id,
                    'tax_field_type' => $tax->tax,
                    'tax_field_amount' => $tax_amount
                ];
            }
        }
        $delivery_charge = isset($sale_data['delivery_charge']) ? (float) $sale_data['delivery_charge'] : 0;
        $service_charge = isset($sale_data['service_charge']) ? (float) $sale_data['service_charge'] : 0;
        $total_payable = $sub_total_after_discount + $total_vat + $delivery_charge + $service_charge;
        $paid_amount = 0;
        if (isset($sale_data['payments'])) {
            foreach ($sale_data['payments'] as $payment) {
                $paid_amount += (float) $payment['amount'];
            }
        }
        $due_amount = $total_payable - $paid_amount;
        return [
            'success' => true,
            'items' => $processed_items,
            'sub_total' => $sub_total,
            'total_discount' => $total_discount,
            'total_vat' => $total_vat,
            'vat_details' => $vat_details,
            'delivery_charge' => $delivery_charge,
            'service_charge' => $service_charge,
            'total_payable' => $total_payable,
            'paid_amount' => $paid_amount,
            'due_amount' => $due_amount < 0 ? 0 : $due_amount,
        ];
    }

    public function create_or_update_running_order($sale_data, $sale_id_to_update = 0)
    {
        $this->db->trans_start();
        $totals = $this->_calculate_totals($sale_data);
        if (!$totals['success']) {
            $this->db->trans_rollback();
            return ['status' => false, 'message' => $totals['message']];
        }
        $tables_text_array = [];
        if (isset($sale_data['tables']) && is_array($sale_data['tables'])) {
            foreach ($sale_data['tables'] as $table) {
                $table_name = getTableName($table['table_id']);
                if ($table_name) {
                    $tables_text_array[] = $table_name;
                }
            }
        }
        $orders_table_text = implode(', ', $tables_text_array);
        $main_sale_data = [
            'customer_id' => $sale_data['customer_id'],
            'outlet_id' => $sale_data['outlet_id'],
            'waiter_id' => $sale_data['waiter_id'] ?? null,
            'order_type' => $sale_data['order_type'],
            'table_id' => $sale_data['table_id'] ?? null,
            'company_id' => $sale_data['company_id'],
            'user_id' => $sale_data['user_id'],
            'sale_date' => date('Y-m-d'),
            'date_time' => date('Y-m-d H:i:s'),
            'order_time' => date('H:i:s'),
            'order_status' => 1,
            'sub_total' => $totals['sub_total'],
            'vat' => $totals['total_vat'],
            'total_discount_amount' => $totals['total_discount'],
            'delivery_charge_actual_charge' => $totals['delivery_charge'],
            'total_payable' => $totals['total_payable'],
            'sale_vat_objects' => json_encode($totals['vat_details']),
            'orders_table_text' => $orders_table_text,
        ];
        $sale_no = '';
        if ($sale_id_to_update > 0) {
            $this->db->where('id', $sale_id_to_update);
            $this->db->update('tbl_kitchen_sales', $main_sale_data);
            $sale_id = $sale_id_to_update;
            $sale_no_obj = $this->db->select('sale_no')->get_where('tbl_kitchen_sales', ['id' => $sale_id])->row();
            $sale_no = $sale_no_obj ? $sale_no_obj->sale_no : '';
            $this->db->delete('tbl_kitchen_sales_details', array('sales_id' => $sale_id));
            $this->db->delete('tbl_kitchen_sales_details_modifiers', array('sales_id' => $sale_id));
        } else {
            $this->db->insert('tbl_kitchen_sales', $main_sale_data);
            $sale_id = $this->db->insert_id();
            $sale_no = getCompanyInfo()->short_name . str_pad($sale_id, 8, '0', STR_PAD_LEFT);
            $this->db->where('id', $sale_id)->update('tbl_kitchen_sales', ['sale_no' => $sale_no]);
        }
        $this->db->delete('tbl_orders_table', ['sale_id' => $sale_id]);
        if (isset($sale_data['tables']) && is_array($sale_data['tables'])) {
            foreach ($sale_data['tables'] as $table) {
                $order_table_info = [
                    'persons' => $table['persons'],
                    'booking_time' => date('Y-m-d H:i:s'),
                    'sale_id' => $sale_id,
                    'sale_no' => $sale_no,
                    'outlet_id' => $sale_data['outlet_id'],
                    'table_id' => $table['table_id'],
                ];
                $this->db->insert('tbl_orders_table', $order_table_info);
            }
        }
        foreach ($totals['items'] as $item) {
            $sale_detail_data = [
                'sales_id' => $sale_id,
                'food_menu_id' => $item['food_menu_id'],
                'menu_name' => $item['name'],
                'qty' => $item['qty'],
                'menu_unit_price' => $item['price'],
                'menu_price_without_discount' => ($item['price'] * $item['qty']),
                'menu_price_with_discount' => ($item['price'] * $item['qty']),
                'menu_note' => $item['note'] ?? null,
                'outlet_id' => $sale_data['outlet_id'],
                'user_id' => $sale_data['user_id'],
                'cooking_status' => $item['cooking_status'],
                'del_status' => 'Live'
            ];
            $this->db->insert('tbl_kitchen_sales_details', $sale_detail_data);
            $sale_detail_id = $this->db->insert_id();
            if (isset($item['modifiers']) && count($item['modifiers'])) {
                foreach ($item['modifiers'] as $modifier) {
                    $mod_data = [
                        'sales_id' => $sale_id,
                        'sales_details_id' => $sale_detail_id,
                        'modifier_id' => $modifier['modifier_id'],
                        'modifier_price' => $modifier['price'],
                        'food_menu_id' => $item['food_menu_id'],
                        'outlet_id' => $sale_data['outlet_id'],
                        'user_id' => $sale_data['user_id'],
                        'customer_id' => $sale_data['customer_id']
                    ];
                    $this->db->insert('tbl_kitchen_sales_details_modifiers', $mod_data);
                }
            }
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return ['status' => false, 'message' => 'Database transaction failed.'];
        } else {
            return ['status' => true, 'sale_id' => $sale_id, 'sale_no' => $sale_no];
        }
    }

    public function delete_sale($sale_id, $company_id, $outlet_id)
    {
        $this->db->where('id', $sale_id);
        $this->db->where('company_id', $company_id);
        $this->db->where('outlet_id', $outlet_id);
        $running_order = $this->db->get('tbl_kitchen_sales')->row();
        if ($running_order) {
            $this->db->trans_start();
            $this->db->delete('tbl_kitchen_sales_details', array('sales_id' => $sale_id));
            $this->db->delete('tbl_kitchen_sales_details_modifiers', array('sales_id' => $sale_id));
            $this->db->delete('tbl_orders_table', array('sale_id' => $sale_id));
            $this->db->delete('tbl_kitchen_sales', array('id' => $sale_id));
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                return ['status' => false, 'message' => 'Failed to delete running order from database.'];
            } else {
                return ['status' => true];
            }
        }
        $this->db->where('id', $sale_id);
        $this->db->where('company_id', $company_id);
        $this->db->where('outlet_id', $outlet_id);
        $final_sale = $this->db->get('tbl_sales')->row();
        if ($final_sale) {
            $this->db->where('id', $sale_id);
            $this->db->update('tbl_sales', ['del_status' => 'Deleted']);
            $this->db->where('sales_id', $sale_id);
            $this->db->update('tbl_sales_details', ['del_status' => 'Deleted']);
            return ['status' => true];
        }
        return ['status' => false, 'message' => 'Sale not found or you do not have permission to delete it.'];
    }

    public function process_split_sale($original_sale_id, $split_data)
    {
        $this->db->trans_start();
        $original_sale = $this->db->get_where('tbl_kitchen_sales', ['id' => $original_sale_id, 'del_status' => 'Live'])->row();
        if (!$original_sale) {
            $this->db->trans_rollback();
            return ['status' => false, 'message' => 'Original running order not found.'];
        }
        $new_sale_data = [
            'outlet_id' => $original_sale->outlet_id,
            'customer_id' => $original_sale->customer_id,
            'waiter_id' => $original_sale->waiter_id,
            'order_type' => $original_sale->order_type,
            'items' => $split_data['items'],
            'payments' => $split_data['payments'],
            'company_id' => $split_data['company_id'],
            'user_id' => $split_data['user_id'],
            'split_sale_id' => $original_sale_id
        ];
        $new_sale_result = $this->create_sale($new_sale_data);
        if (!$new_sale_result['status']) {
            $this->db->trans_rollback();
            return ['status' => false, 'message' => 'Failed to create new split invoice.'];
        }
        $all_original_items = $this->db->where('sales_id', $original_sale_id)->get('tbl_kitchen_sales_details')->result();
        $original_items_map = [];
        foreach ($all_original_items as $item) {
            $original_items_map[$item->id] = $item;
        }
        foreach ($split_data['items'] as $split_item) {
            $original_item_detail_id = $split_item['original_detail_id'];
            if (isset($original_items_map[$original_item_detail_id])) {
                $original_items_map[$original_item_detail_id]->qty -= $split_item['qty'];
            }
        }
        $original_has_remaining_items = false;
        foreach ($original_items_map as $item_id => $item) {
            if ($item->qty > 0) {
                $this->db->where('id', $item_id)->update('tbl_kitchen_sales_details', ['qty' => $item->qty]);
                $original_has_remaining_items = true;
            } else {
                $this->db->where('id', $item_id)->delete('tbl_kitchen_sales_details');
                $this->db->where('sales_details_id', $item_id)->delete('tbl_kitchen_sales_details_modifiers');
            }
        }
        $original_sale_updated = true;
        if (!$original_has_remaining_items || (isset($split_data['is_last_split']) && $split_data['is_last_split'] == true)) {
            $this->db->where('id', $original_sale_id)->delete('tbl_kitchen_sales');
            $this->db->where('sale_id', $original_sale_id)->delete('tbl_orders_table');
            $original_sale_updated = false;
        } else {
            $this->_recalculate_running_order_totals($original_sale_id);
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return ['status' => false, 'message' => 'Database transaction failed during split.'];
        } else {
            return [
                'status' => true,
                'new_sale_id' => $new_sale_result['sale_id'],
                'new_sale_no' => $new_sale_result['sale_no'],
                'original_sale_updated' => $result['original_sale_updated']
            ];
        }
    }

    private function _recalculate_running_order_totals($sale_id)
    {
        $items = $this->db->get_where('tbl_kitchen_sales_details', ['sales_id' => $sale_id])->result();
        $recalc_data = ['items' => []];
        foreach ($items as $item) {
            $mods = $this->db->get_where('tbl_kitchen_sales_details_modifiers', ['sales_details_id' => $item->id])->result();
            $recalc_data['items'][] = [
                'food_menu_id' => $item->food_menu_id,
                'qty' => $item->qty,
                'modifiers' => array_map(function ($m) {
                    return ['modifier_id' => $m->modifier_id];
                }, $mods)
            ];
        }
        $totals = $this->_calculate_totals($recalc_data);
        if ($totals['success']) {
            $update_data = [
                'sub_total' => $totals['sub_total'],
                'vat' => $totals['total_vat'],
                'service_charge' => $totals['service_charge'],
                'total_discount_amount' => $totals['total_discount'],
                'total_payable' => $totals['total_payable'],
            ];
            $this->db->where('id', $sale_id)->update('tbl_kitchen_sales', $update_data);
        }
    }

    public function execute_refund($sale_id, $refund_data)
    {
        $this->db->trans_start();
        $sale = $this->db->get_where('tbl_sales', ['id' => $sale_id, 'company_id' => $refund_data['company_id']])->row();
        if (!$sale) {
            $this->db->trans_rollback();
            return ['status' => false, 'message' => 'Original sale not found.'];
        }
        if ($sale->total_refund > 0) {
            $this->db->trans_rollback();
            return ['status' => false, 'message' => 'This sale has already been refunded.'];
        }
        $update_data = [
            'total_refund' => $refund_data['total_refund_amount'],
            'refund_date_time' => date('Y-m-d H:i:s'),
            'refund_payment_id' => $refund_data['payment_method_id'],
            'refund_content' => json_encode($refund_data['items'])
        ];
        $this->db->where('id', $sale_id)->update('tbl_sales', $update_data);
        $refund_consumption_data = [
            'sale_id' => $sale_id,
            'user_id' => $refund_data['user_id'],
            'outlet_id' => $sale->outlet_id,
            'del_status' => 'Live',
        ];
        $this->db->insert('tbl_sale_consumptions', $refund_consumption_data);
        $refund_consumption_id = $this->db->insert_id();
        foreach ($refund_data['items'] as $item) {
            if (!isset($item['food_menu_id']) || !isset($item['refund_qty']) || $item['refund_qty'] <= 0) {
                continue;
            }
            $ingredients = $this->db->get_where('tbl_food_menus_ingredients', ['food_menu_id' => $item['food_menu_id']])->result();
            foreach ($ingredients as $ingredient) {
                $consumption_data = [
                    'ingredient_id' => $ingredient->ingredient_id,
                    'consumption' => -($item['refund_qty'] * $ingredient->consumption),
                    'sale_consumption_id' => $refund_consumption_id,
                    'sales_id' => $sale_id,
                    'food_menu_id' => $item['food_menu_id'],
                    'user_id' => $refund_data['user_id'],
                    'outlet_id' => $sale->outlet_id,
                    'del_status' => 'Live',
                ];
                $this->db->insert('tbl_sale_consumptions_of_menus', $consumption_data);
            }
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return ['status' => false, 'message' => 'Database transaction failed during refund.'];
        } else {
            return ['status' => true, 'message' => 'Refund processed.'];
        }
    }

    public function merge_running_orders($order_ids, $company_id, $outlet_id)
    {
        $this->db->where_in('id', $order_ids);
        $this->db->where('company_id', $company_id);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where_in('order_status', ['1', '2']);
        $orders = $this->db->get('tbl_kitchen_sales')->result();
        if (count($orders) !== count($order_ids)) {
            return ['status' => false, 'message' => 'One or more orders not found or are not running orders.'];
        }
        usort($orders, function ($a, $b) {
            return strtotime($a->date_time) - strtotime($b->date_time);
        });
        $primary_order = array_shift($orders);
        $orders_to_subsume = $orders;
        $subsumed_ids = array_column($orders_to_subsume, 'id');
        $this->db->trans_start();
        $this->db->where_in('sales_id', $subsumed_ids);
        $this->db->update('tbl_kitchen_sales_details', ['sales_id' => $primary_order->id]);
        $this->db->where_in('sales_id', $subsumed_ids);
        $this->db->update('tbl_kitchen_sales_details_modifiers', ['sales_id' => $primary_order->id]);
        $this->db->where_in('sale_id', $subsumed_ids);
        $this->db->update('tbl_orders_table', ['sale_id' => $primary_order->id, 'sale_no' => $primary_order->sale_no]);
        $this->db->where_in('id', $subsumed_ids);
        $this->db->update('tbl_kitchen_sales', ['del_status' => 'Deleted']);
        $this->_recalculate_running_order_totals($primary_order->id);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return ['status' => false, 'message' => 'Database transaction failed during merge.'];
        }
        return [
            'status' => true,
            'primary_sale_id' => $primary_order->id,
            'merged_sale_ids' => $subsumed_ids
        ];
    }

    public function transfer_running_order($sale_id, $new_table_id, $company_id, $outlet_id)
    {
        $this->db->trans_start();
        $this->db->where('id', $sale_id);
        $this->db->where('company_id', $company_id);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where_in('order_status', ['1', '2']);
        $order = $this->db->get('tbl_kitchen_sales')->row();
        if (!$order) {
            $this->db->trans_rollback();
            return ['status' => false, 'message' => 'Running order not found.'];
        }
        $is_occupied = $this->db->where('table_id', $new_table_id)->where('sale_id !=', $sale_id)->where('del_status', 'Live')->from('tbl_orders_table')->count_all_results();
        if ($is_occupied > 0) {
        }
        $new_table_name = $this->db->select('name')->get_where('tbl_tables', ['id' => $new_table_id])->row('name');
        $this->db->where('id', $sale_id)->update('tbl_kitchen_sales', ['table_id' => $new_table_id, 'orders_table_text' => $new_table_name]);
        $this->db->where('sale_id', $sale_id)->update('tbl_orders_table', ['table_id' => $new_table_id]);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return ['status' => false, 'message' => 'Database transaction failed during transfer.'];
        }
        return ['status' => true, 'message' => 'Order transferred successfully.'];
    }

    public function finalize_running_order($running_sale_id, $sale_data)
    {
        $this->db->where('id', $running_sale_id);
        $this->db->where_in('order_status', ['1', '2']);
        $running_order = $this->db->get('tbl_kitchen_sales')->row();

        if (!$running_order) {
            return ['status' => false, 'message' => 'Running order to be finalized not found.'];
        }

        $this->db->trans_start();

        $sale_data['existing_sale_no'] = $running_order->sale_no;

        $create_result = $this->create_sale($sale_data);

        if (!$create_result['status']) {
            $this->db->trans_rollback();

            return ['status' => false, 'message' => $create_result['message'] ?? 'Failed to create final sale from running order.'];
        }

        $this->db->delete('tbl_kitchen_sales_details', array('sales_id' => $running_sale_id));
        $this->db->delete('tbl_kitchen_sales_details_modifiers', array('sales_id' => $running_sale_id));
        $this->db->delete('tbl_orders_table', array('sale_id' => $running_sale_id));
        $this->db->delete('tbl_kitchen_sales', array('id' => $running_sale_id));

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return ['status' => false, 'message' => 'Database transaction failed during finalization.'];
        } else {
            return [
                'status' => true,
                'sale_id' => $create_result['sale_id'],
                'sale_no' => $create_result['sale_no']
            ];
        }
    }
}
