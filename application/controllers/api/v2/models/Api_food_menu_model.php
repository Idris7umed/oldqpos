<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_food_menu_model extends CI_Model
{
    public $auth_data;
    private $table = 'tbl_food_menus';
    private $table_ingredients = 'tbl_food_menus_ingredients';
    private $table_modifiers = 'tbl_food_menus_modifiers';
    private $table_combo = 'tbl_combo_food_menus';

    public function get_all($company_id, $outlet_id)
    {
        $this->db->cache_off();

        $outlet = $this->db->get_where('tbl_outlets', ['id' => $outlet_id])->row();

        $visible_menu_ids = [];
        $outlet_prices = [];
        $outlet_delivery_prices = [];

        if ($outlet) {
            if (!empty($outlet->food_menus)) {
                $visible_menu_ids = explode(',', $outlet->food_menus);
            }

            if (!empty($outlet->food_menu_prices)) {
                $outlet_prices = json_decode($outlet->food_menu_prices, true);
            }

            if (!empty($outlet->delivery_price)) {
                $outlet_delivery_prices = json_decode($outlet->delivery_price, true);
            }
        }

        $this->db->select('fm.*, (SELECT COUNT(vf.id) FROM tbl_food_menus vf WHERE vf.parent_id = fm.id AND vf.del_status = "Live") as variation_count');
        $this->db->from('tbl_food_menus fm');
        $this->db->where('fm.company_id', $company_id);
        $this->db->where('fm.del_status', 'Live');
        $this->db->where('fm.parent_id', 0);

        if (!empty($visible_menu_ids)) {
            $this->db->where_in('fm.id', $visible_menu_ids);
        } else {
            return [];
        }

        $food_menus = $this->db->get()->result();

        if (empty($food_menus)) {
            return [];
        }

        $today = date('Y-m-d');
        $all_menu_ids = array_column($food_menus, 'id');

        $variations_map = [];

        if (!empty($all_menu_ids)) {
            $variations_result = $this
                ->db
                ->where_in('parent_id', $all_menu_ids)
                ->where('del_status', 'Live')
                ->get($this->table)
                ->result();

            foreach ($variations_result as $variation) {
                $this->_apply_outlet_price($variation, $outlet_prices, $outlet_delivery_prices);

                $all_menu_ids[] = $variation->id;
                $variations_map[$variation->parent_id][] = $variation;
            }
        }

        $ingredients_map = [];
        $ingredients_result = $this
            ->db
            ->select('fmi.food_menu_id, fmi.ingredient_id, i.name as ingredient_name, fmi.consumption, i.unit_id, u.unit_name')
            ->from($this->table_ingredients . ' fmi')
            ->join('tbl_ingredients i', 'i.id = fmi.ingredient_id')
            ->join('tbl_units u', 'u.id = i.unit_id', 'left')
            ->where_in('fmi.food_menu_id', $all_menu_ids)
            ->where('fmi.del_status', 'Live')
            ->get()
            ->result();
        foreach ($ingredients_result as $ingredient) {
            $ingredients_map[$ingredient->food_menu_id][] = $ingredient;
        }

        $modifiers_map = [];
        $modifiers_result = $this
            ->db
            ->select('fmm.food_menu_id, fmm.modifier_id, m.name as modifier_name, m.price as modifier_price')
            ->from($this->table_modifiers . ' fmm')
            ->join('tbl_modifiers m', 'm.id = fmm.modifier_id')
            ->where_in('fmm.food_menu_id', $all_menu_ids)
            ->where('fmm.del_status', 'Live')
            ->get()
            ->result();
        foreach ($modifiers_result as $modifier) {
            $modifiers_map[$modifier->food_menu_id][] = $modifier;
        }

        $combo_items_map = [];
        $combo_items_result = $this
            ->db
            ->select('cf.food_menu_id, cf.added_food_menu_id, fm.name, cf.quantity')
            ->from($this->table_combo . ' cf')
            ->join('tbl_food_menus fm', 'fm.id = cf.added_food_menu_id')
            ->where_in('cf.food_menu_id', $all_menu_ids)
            ->where('cf.del_status', 'Live')
            ->get()
            ->result();
        foreach ($combo_items_result as $combo_item) {
            $combo_items_map[$combo_item->food_menu_id][] = $combo_item;
        }

        foreach ($food_menus as $menu) {
            $this->_apply_outlet_price($menu, $outlet_prices, $outlet_delivery_prices);

            $promo_details = checkPromotionWithinDatePOS($today, $menu->id, $outlet_id);
            $menu->promotion = $promo_details['status'] ? $promo_details['details'] : null;

            $menu->photo_url = !empty($menu->photo) ? base_url('images/' . $menu->photo) : null;

            $menu->ingredients = $ingredients_map[$menu->id] ?? [];
            $menu->modifiers = $modifiers_map[$menu->id] ?? [];
            $menu->combo_items = $combo_items_map[$menu->id] ?? [];
            $menu->variations = $variations_map[$menu->id] ?? [];

            foreach ($menu->variations as $variation) {
                $promo_details_var = checkPromotionWithinDatePOS($today, $variation->id, $outlet_id);
                $variation->promotion = $promo_details_var['status'] ? $promo_details_var['details'] : null;

                $variation->photo_url = !empty($variation->photo) ? base_url('uploads/food_menu/' . $variation->photo) : null;
                $variation->ingredients = $ingredients_map[$variation->id] ?? [];
                $variation->modifiers = $modifiers_map[$variation->id] ?? [];
                $variation->combo_items = $combo_items_map[$variation->id] ?? [];
            }
        }

        return $food_menus;
    }

    private function _apply_outlet_price(&$menu, $outlet_prices, $outlet_delivery_prices)
    {
        $key = 'tmp' . $menu->id;

        if (isset($outlet_prices[$key])) {
            $prices = explode('||', $outlet_prices[$key]);

            if (isset($prices[0]) && $prices[0] !== '') {
                $menu->sale_price = $prices[0];
            }

            if (isset($prices[1]) && $prices[1] !== '') {
                $menu->sale_price_take_away = $prices[1];
            }

            if (isset($prices[2]) && $prices[2] !== '') {
                $menu->sale_price_delivery = $prices[2];
            }
        }

        $delivery_key = 'index_' . $menu->id;
        if (isset($outlet_delivery_prices[$delivery_key])) {
            $menu->delivery_price_json = $outlet_delivery_prices[$delivery_key];
        }
    }

    public function get_by_id($id, $company_id, $outlet_id = null)
    {
        $this->db->cache_off();
        $food_menu = $this->db->get_where($this->table, ['id' => $id, 'company_id' => $company_id, 'del_status' => 'Live'])->row();

        if ($food_menu) {
            if ($outlet_id) {
                $today = date('Y-m-d');
                $promo_details = checkPromotionWithinDatePOS($today, $food_menu->id, $outlet_id);
                $food_menu->promotion = $promo_details['status'] ? $promo_details['details'] : null;

                $outlet = $this->db->get_where('tbl_outlets', ['id' => $outlet_id])->row();
                if ($outlet) {
                    $outlet_prices = !empty($outlet->food_menu_prices) ? json_decode($outlet->food_menu_prices, true) : [];
                    $outlet_delivery_prices = !empty($outlet->delivery_price) ? json_decode($outlet->delivery_price, true) : [];
                    $this->_apply_outlet_price($food_menu, $outlet_prices, $outlet_delivery_prices);
                }
            } else {
                $food_menu->promotion = null;
            }

            $food_menu->photo_url = !empty($food_menu->photo) ? base_url('uploads/food_menu/' . $food_menu->photo) : null;

            $food_menu->ingredients = $this->db->select('fmi.ingredient_id, i.name as ingredient_name, fmi.consumption, i.unit_id, u.unit_name')->from($this->table_ingredients . ' fmi')->join('tbl_ingredients i', 'i.id = fmi.ingredient_id')->join('tbl_units u', 'u.id = i.unit_id', 'left')->where('fmi.food_menu_id', $id)->where('fmi.del_status', 'Live')->get()->result();

            $food_menu->modifiers = $this->db->select('fmm.modifier_id, m.name as modifier_name, m.price as modifier_price')->from($this->table_modifiers . ' fmm')->join('tbl_modifiers m', 'm.id = fmm.modifier_id')->where('fmm.food_menu_id', $id)->where('fmm.del_status', 'Live')->get()->result();

            if ($food_menu->parent_id == 0) {
                $food_menu->variations = $this->db->get_where($this->table, ['parent_id' => $id, 'del_status' => 'Live'])->result();
                if (!empty($food_menu->variations)) {
                    $today = date('Y-m-d');
                    foreach ($food_menu->variations as $variation) {
                        if (isset($outlet_prices) && isset($outlet_delivery_prices)) {
                            $this->_apply_outlet_price($variation, $outlet_prices, $outlet_delivery_prices);
                        }

                        if ($outlet_id) {
                            $promo_details_var = checkPromotionWithinDatePOS($today, $variation->id, $outlet_id);
                            $variation->promotion = $promo_details_var['status'] ? $promo_details_var['details'] : null;
                        } else {
                            $variation->promotion = null;
                        }

                        $variation->photo_url = !empty($variation->photo) ? base_url('uploads/food_menu/' . $variation->photo) : null;

                        $variation->ingredients = $this
                            ->db
                            ->select('fmi.ingredient_id, i.name as ingredient_name, fmi.consumption, i.unit_id, u.unit_name')
                            ->from($this->table_ingredients . ' fmi')
                            ->join('tbl_ingredients i', 'i.id = fmi.ingredient_id')
                            ->join('tbl_units u', 'u.id = i.unit_id', 'left')
                            ->where('fmi.food_menu_id', $variation->id)
                            ->where('fmi.del_status', 'Live')
                            ->get()
                            ->result();

                        $variation->modifiers = $this
                            ->db
                            ->select('fmm.modifier_id, m.name as modifier_name, m.price as modifier_price')
                            ->from($this->table_modifiers . ' fmm')
                            ->join('tbl_modifiers m', 'm.id = fmm.modifier_id')
                            ->where('fmm.food_menu_id', $variation->id)
                            ->where('fmm.del_status', 'Live')
                            ->get()
                            ->result();

                        $variation->combo_items = $this
                            ->db
                            ->select('cf.added_food_menu_id, fm.name, cf.quantity')
                            ->from($this->table_combo . ' cf')
                            ->join('tbl_food_menus fm', 'fm.id = cf.added_food_menu_id')
                            ->where('cf.food_menu_id', $variation->id)
                            ->where('cf.del_status', 'Live')
                            ->get()
                            ->result();
                    }
                }
            }

            $food_menu->combo_items = $this->db->select('cf.added_food_menu_id, fm.name, cf.quantity')->from($this->table_combo . ' cf')->join('tbl_food_menus fm', 'fm.id = cf.added_food_menu_id')->where('cf.food_menu_id', $id)->where('cf.del_status', 'Live')->get()->result();
        }
        return $food_menu;
    }

    public function create_or_update($data, $id = null)
    {
        $this->db->trans_start();

        $total_cost = 0;
        if (isset($data['ingredients'])) {
            foreach ($data['ingredients'] as $ingredient) {
                if (!empty($ingredient['ingredient_id'])) {
                    $ing_details = $this->db->get_where('tbl_ingredients', ['id' => $ingredient['ingredient_id']])->row();
                    if ($ing_details) {
                        $total_cost += (float) $ing_details->consumption_unit_cost * (float) ($ingredient['consumption'] ?? 0);
                    }
                }
            }
        }
        $data['total_cost'] = $total_cost;

        $ingredients = $data['ingredients'] ?? null;
        $modifiers = $data['modifiers'] ?? null;
        $variations = $data['variations'] ?? null;
        $combo_items = $data['combo_items'] ?? null;

        unset($data['ingredients'], $data['modifiers'], $data['variations'], $data['combo_items']);

        if ($id) {
            $this->db->where('id', $id)->update($this->table, $data);
            $food_menu_id = $id;
        } else {
            $this->db->insert($this->table, $data);
            $food_menu_id = $this->db->insert_id();
        }

        if ($ingredients !== null)
            $this->_sync_ingredients($food_menu_id, $ingredients);
        if ($modifiers !== null)
            $this->_sync_modifiers($food_menu_id, $modifiers);
        if ($combo_items !== null)
            $this->_sync_combo_items($food_menu_id, $combo_items);
        if ($variations !== null)
            $this->_sync_variations($food_menu_id, $variations);

        if (isset($data['product_type']) && $data['product_type'] == 3) {
            $this->_sync_product_as_ingredient($food_menu_id, $data);
        }

        $this->db->trans_complete();
        return ($this->db->trans_status()) ? $food_menu_id : false;
    }

    public function delete($id, $company_id)
    {
        $existing_menu = $this->db->get_where($this->table, ['id' => $id, 'company_id' => $company_id])->row();
        if (!$existing_menu)
            return false;

        $this->db->trans_start();
        $this->db->where('id', $id)->update($this->table, ['del_status' => 'Deleted']);
        $this->db->where('parent_id', $id)->update($this->table, ['del_status' => 'Deleted']);
        $this->db->where('food_id', $id)->update('tbl_ingredients', ['del_status' => 'Deleted']);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    private function _sync_ingredients($food_menu_id, $ingredients)
    {
        $this->db->where('food_menu_id', $food_menu_id)->delete($this->table_ingredients);
        foreach ($ingredients as $ingredient) {
            if (!empty($ingredient['ingredient_id']) && isset($ingredient['consumption'])) {
                $ing_details = $this->db->get_where('tbl_ingredients', ['id' => $ingredient['ingredient_id']])->row();
                $cost = 0;
                if ($ing_details) {
                    $cost = (float) $ing_details->consumption_unit_cost;
                }

                $ing_data = [
                    'food_menu_id' => $food_menu_id,
                    'ingredient_id' => $ingredient['ingredient_id'],
                    'consumption' => $ingredient['consumption'],
                    'cost' => $cost,
                    'total' => $cost * (float) ($ingredient['consumption'] ?? 0),
                    'user_id' => $this->auth_data->user_id,
                    'company_id' => $this->auth_data->company_id,
                ];
                $this->db->insert($this->table_ingredients, $ing_data);
            }
        }
    }

    private function _sync_modifiers($food_menu_id, $modifiers)
    {
        $this->db->where('food_menu_id', $food_menu_id)->delete($this->table_modifiers);
        foreach ($modifiers as $modifier) {
            if (!empty($modifier['modifier_id'])) {
                $mod_data = [
                    'food_menu_id' => $food_menu_id,
                    'modifier_id' => $modifier['modifier_id'],
                    'user_id' => $this->auth_data->user_id,
                    'company_id' => $this->auth_data->company_id,
                ];
                $this->db->insert($this->table_modifiers, $mod_data);
            }
        }
    }

    private function _sync_combo_items($food_menu_id, $combo_items)
    {
        $this->db->where('food_menu_id', $food_menu_id)->delete($this->table_combo);
        foreach ($combo_items as $item) {
            if (!empty($item['food_menu_id']) && !empty($item['quantity'])) {
                $combo_data = [
                    'food_menu_id' => $food_menu_id,
                    'added_food_menu_id' => $item['food_menu_id'],
                    'quantity' => $item['quantity'],
                    'user_id' => $this->auth_data->user_id,
                    'company_id' => $this->auth_data->company_id,
                ];
                $this->db->insert($this->table_combo, $combo_data);
            }
        }
    }

    private function _sync_variations($parent_id, $variations)
    {
        $existing_variation_ids = array_column($this->db->select('id')->from($this->table)->where('parent_id', $parent_id)->get()->result_array(), 'id');
        $incoming_variation_ids = [];

        foreach ($variations as $variation_data) {
            $variation_id = $variation_data['id'] ?? null;
            $ingredients = $variation_data['ingredients'] ?? [];
            $vr_ingr_text = $variation_data['vr_ingr'] ?? null;

            unset($variation_data['ingredients']);
            unset($variation_data['vr_ingr']);

            $variation_data['parent_id'] = $parent_id;
            if (isset($variation_data['delivery_price']) && is_array($variation_data['delivery_price'])) {
                $variation_data['delivery_price'] = json_encode($variation_data['delivery_price']);
            }
            if (isset($variation_data['sale_price_delivery']) && is_array($variation_data['sale_price_delivery'])) {
                $variation_data['delivery_price'] = json_encode($variation_data['sale_price_delivery']);
                unset($variation_data['sale_price_delivery']);
            }
            $variation_data['company_id'] = $this->auth_data->company_id;
            $variation_data['user_id'] = $this->auth_data->user_id;

            if ($vr_ingr_text !== null) {
                $variation_data['vr_ingr'] = $vr_ingr_text;
            }

            $total_cost = 0;
            foreach ($ingredients as $ingredient) {
                if (!empty($ingredient['ingredient_id'])) {
                    $ing_details = $this->db->get_where('tbl_ingredients', ['id' => $ingredient['ingredient_id']])->row();
                    if ($ing_details) {
                        $total_cost += (float) $ing_details->consumption_unit_cost * (float) ($ingredient['consumption'] ?? 0);
                    }
                }
            }
            $variation_data['total_cost'] = $total_cost;

            unset($variation_data['modifiers']);
            unset($variation_data['combo_items']);

            if ($variation_id) {
                $this->db->where('id', $variation_id)->update($this->table, $variation_data);
                $incoming_variation_ids[] = $variation_id;
            } else {
                $this->db->insert($this->table, $variation_data);
                $variation_id = $this->db->insert_id();
            }

            $this->_sync_ingredients($variation_id, $ingredients);
        }

        $variations_to_delete = array_diff($existing_variation_ids, $incoming_variation_ids);
        if (count($variations_to_delete) > 0) {
            $this->db->where_in('id', $variations_to_delete)->update($this->table, ['del_status' => 'Deleted']);
        }
    }

    private function _sync_product_as_ingredient($food_menu_id, $data)
    {
        $ingredient_data = [
            'name' => $data['name'],
            'purchase_price' => $data['purchase_price'],
            'alert_quantity' => $data['alert_quantity'],
            'category_id' => $data['ing_category_id'],
            'unit_id' => $this->_get_or_create_unit_id('Pcs'),
            'purchase_unit_id' => $this->_get_or_create_unit_id('Pcs'),
            'consumption_unit_cost' => $data['purchase_price'],
            'is_direct_food' => 2,
            'food_id' => $food_menu_id,
            'company_id' => $data['company_id'],
            'user_id' => $data['user_id']
        ];

        $existing_ingredient = $this->db->get_where('tbl_ingredients', ['food_id' => $food_menu_id])->row();
        if ($existing_ingredient) {
            $this->db->where('id', $existing_ingredient->id)->update('tbl_ingredients', $ingredient_data);
        } else {
            $ingredient_data['code'] = $data['code'] ?? 'ING-' . uniqid();
            $this->db->insert('tbl_ingredients', $ingredient_data);
        }
    }

    private function _get_or_create_unit_id($unit_name)
    {
        $unit = $this->db->get_where('tbl_units', ['unit_name' => $unit_name, 'company_id' => $this->auth_data->company_id])->row();
        if ($unit) {
            return $unit->id;
        } else {
            $data = ['unit_name' => $unit_name, 'company_id' => $this->auth_data->company_id];
            $this->db->insert('tbl_units', $data);
            return $this->db->insert_id();
        }
    }
}
