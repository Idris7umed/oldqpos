<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_report_model extends CI_Model
{
    private function get_outlet_ids($outlet_id)
    {
        if ($outlet_id) {
            return [$outlet_id];
        }
        $outlets = $this->db->select('id')->from('tbl_outlets')->where('company_id', $this->auth_data->company_id)->get()->result_array();
        return array_column($outlets, 'id');
    }

    public function daily_summary_report($date, $outlet_id)
    {
        $sales = $this
            ->db
            ->select('SUM(total_payable) as total_sales, SUM(vat) as total_vat, SUM(total_discount_amount) as total_discount, COUNT(id) as total_orders, SUM(total_refund) as total_refund')
            ->from('tbl_sales')
            ->where('sale_date', $date)
            ->where('outlet_id', $outlet_id)
            ->where('order_status', 3)
            ->where('del_status', 'Live')
            ->get()
            ->row();
        $purchases = $this
            ->db
            ->select('SUM(grand_total) as total_purchases')
            ->from('tbl_purchase')
            ->where('date', $date)
            ->where('outlet_id', $outlet_id)
            ->where('del_status', 'Live')
            ->get()
            ->row();
        $expenses = $this
            ->db
            ->select('SUM(amount) as total_expenses')
            ->from('tbl_expenses')
            ->where('date', $date)
            ->where('outlet_id', $outlet_id)
            ->where('del_status', 'Live')
            ->get()
            ->row();
        $wastes = $this
            ->db
            ->select('SUM(total_loss) as total_wastes')
            ->from('tbl_wastes')
            ->where('date', $date)
            ->where('outlet_id', $outlet_id)
            ->where('del_status', 'Live')
            ->get()
            ->row();
        $supplier_payments = $this
            ->db
            ->select('SUM(amount) as total_supplier_payments')
            ->from('tbl_supplier_payments')
            ->where('date', $date)
            ->where('outlet_id', $outlet_id)
            ->where('del_status', 'Live')
            ->get()
            ->row();
        $customer_due_receives = $this
            ->db
            ->select('SUM(amount) as total_customer_due_receives')
            ->from('tbl_customer_due_receives')
            ->where('only_date', $date)
            ->where('outlet_id', $outlet_id)
            ->where('del_status', 'Live')
            ->get()
            ->row();
        return [
            'sales' => ['total_sales' => (float) ($sales->total_sales ?? 0), 'total_vat' => (float) ($sales->total_vat ?? 0), 'total_discount' => (float) ($sales->total_discount ?? 0), 'total_orders' => (int) ($sales->total_orders ?? 0), 'total_refund' => (float) ($sales->total_refund ?? 0)],
            'purchases' => ['total_purchases' => (float) ($purchases->total_purchases ?? 0)],
            'expenses' => ['total_expenses' => (float) ($expenses->total_expenses ?? 0)],
            'wastes' => ['total_wastes' => (float) ($wastes->total_wastes ?? 0)],
            'payments' => ['supplier_payments' => (float) ($supplier_payments->total_supplier_payments ?? 0), 'customer_due_receives' => (float) ($customer_due_receives->total_customer_due_receives ?? 0)]
        ];
    }

    public function food_menu_sales_report($start_date, $end_date, $outlet_id, $category_id = null)
    {
        $this->db->select('sd.food_menu_id, fm.name as menu_name, fm.code as menu_code, c.category_name, SUM(sd.qty) as total_quantity_sold, SUM(sd.menu_price_with_discount) as total_sales_amount');
        $this->db->from('tbl_sales_details sd');
        $this->db->join('tbl_sales s', 's.id = sd.sales_id');
        $this->db->join('tbl_food_menus fm', 'fm.id = sd.food_menu_id');
        $this->db->join('tbl_food_menu_categories c', 'c.id = fm.category_id', 'left');
        $this->db->where('s.sale_date >=', $start_date);
        $this->db->where('s.sale_date <=', $end_date);
        $this->db->where('s.outlet_id', $outlet_id);
        $this->db->where('s.order_status', 3);
        $this->db->where('s.del_status', 'Live');
        $this->db->where('sd.del_status', 'Live');
        if ($category_id) {
            $this->db->where('fm.category_id', $category_id);
        }
        $this->db->group_by('sd.food_menu_id');
        $this->db->order_by('total_quantity_sold', 'DESC');
        return $this->db->get()->result();
    }

    public function inventory_report($outlet_id, $category_id = null, $ingredient_id = null)
    {
        $company_id = $this->auth_data->company_id;
        $this->db->select("
            i.id as ingredient_id,
            i.name as ingredient_name,
            i.code as ingredient_code,
            i.alert_quantity,
            ic.category_name,
            u.unit_name,
            (
                COALESCE((SELECT SUM(pi.quantity_amount) FROM tbl_purchase_ingredients pi WHERE pi.ingredient_id = i.id AND pi.outlet_id = {$outlet_id} AND pi.del_status = 'Live'), 0)
                + COALESCE((SELECT SUM(ti.quantity_amount) FROM tbl_transfer_ingredients ti WHERE ti.ingredient_id = i.id AND ti.to_outlet_id = {$outlet_id} AND ti.status = 1 AND ti.del_status = 'Live'), 0)
                + COALESCE((SELECT SUM(iai.consumption_amount) FROM tbl_inventory_adjustment_ingredients iai WHERE iai.ingredient_id = i.id AND iai.outlet_id = {$outlet_id} AND iai.consumption_status = 'Plus' AND iai.del_status = 'Live'), 0)
                + COALESCE((SELECT SUM(p.quantity_amount) FROM tbl_production_ingredients p WHERE p.ingredient_id = i.id AND p.outlet_id = {$outlet_id} AND p.del_status = 'Live' AND p.status=1), 0)
                - COALESCE((SELECT SUM(scm.consumption) FROM tbl_sale_consumptions_of_menus scm WHERE scm.ingredient_id = i.id AND scm.outlet_id = {$outlet_id} AND scm.del_status = 'Live'), 0)
                - COALESCE((SELECT SUM(scmm.consumption) FROM tbl_sale_consumptions_of_modifiers_of_menus scmm WHERE scmm.ingredient_id = i.id AND scmm.outlet_id = {$outlet_id} AND scmm.del_status = 'Live'), 0)
                - COALESCE((SELECT SUM(wi.waste_amount) FROM tbl_waste_ingredients wi WHERE wi.ingredient_id = i.id AND wi.outlet_id = {$outlet_id} AND wi.del_status = 'Live'), 0)
                - COALESCE((SELECT SUM(tio.quantity_amount) FROM tbl_transfer_ingredients tio WHERE tio.ingredient_id = i.id AND tio.from_outlet_id = {$outlet_id} AND tio.status = 1 AND tio.del_status = 'Live'), 0)
                - COALESCE((SELECT SUM(iaim.consumption_amount) FROM tbl_inventory_adjustment_ingredients iaim WHERE iaim.ingredient_id = i.id AND iaim.outlet_id = {$outlet_id} AND iaim.consumption_status = 'Minus' AND iaim.del_status = 'Live'), 0)
            ) AS stock_qty
        ");
        $this->db->from('tbl_ingredients i');
        $this->db->join('tbl_ingredient_categories ic', 'ic.id = i.category_id', 'left');
        $this->db->join('tbl_units u', 'u.id = i.purchase_unit_id', 'left');
        $this->db->where('i.company_id', $company_id);
        $this->db->where('i.del_status', 'Live');
        if ($category_id) {
            $this->db->where('i.category_id', $category_id);
        }
        if ($ingredient_id) {
            $this->db->where('i.id', $ingredient_id);
        }
        $this->db->group_by('i.id');
        $this->db->order_by('i.name', 'ASC');
        return $this->db->get()->result();
    }

    public function profit_loss_report($start_date, $end_date, $outlet_id)
    {
        $sales = $this
            ->db
            ->select('SUM(total_payable) as total_sales, SUM(vat) as total_vat, SUM(total_discount_amount) as total_discounts')
            ->from('tbl_sales')
            ->where('sale_date >=', $start_date)
            ->where('sale_date <=', $end_date)
            ->where('outlet_id', $outlet_id)
            ->where('order_status', 3)
            ->where('del_status', 'Live')
            ->get()
            ->row();

        $cogs = 0;
        $item_consumption_cost = $this
            ->db
            ->select('SUM(scm.consumption * i.consumption_unit_cost) as total_cost')
            ->from('tbl_sale_consumptions_of_menus scm')
            ->join('tbl_sales s', 's.id = scm.sales_id')
            ->join('tbl_ingredients i', 'i.id = scm.ingredient_id')
            ->where('s.sale_date >=', $start_date)
            ->where('s.sale_date <=', $end_date)
            ->where('s.outlet_id', $outlet_id)
            ->where('s.order_status', 3)
            ->where('s.del_status', 'Live')
            ->get()
            ->row();

        $modifier_consumption_cost = $this
            ->db
            ->select('SUM(scmm.consumption * i.consumption_unit_cost) as total_cost')
            ->from('tbl_sale_consumptions_of_modifiers_of_menus scmm')
            ->join('tbl_sales s', 's.id = scmm.sales_id')
            ->join('tbl_ingredients i', 'i.id = scmm.ingredient_id')
            ->where('s.sale_date >=', $start_date)
            ->where('s.sale_date <=', $end_date)
            ->where('s.outlet_id', $outlet_id)
            ->where('s.order_status', 3)
            ->where('s.del_status', 'Live')
            ->get()
            ->row();

        $cogs = (float) ($item_consumption_cost->total_cost ?? 0) + (float) ($modifier_consumption_cost->total_cost ?? 0);

        $expenses = $this
            ->db
            ->select('SUM(amount) as total_expenses')
            ->from('tbl_expenses')
            ->where('date >=', $start_date)
            ->where('date <=', $end_date)
            ->where('outlet_id', $outlet_id)
            ->where('del_status', 'Live')
            ->get()
            ->row();

        $wastes = $this
            ->db
            ->select('SUM(total_loss) as total_wastes')
            ->from('tbl_wastes')
            ->where('date >=', $start_date)
            ->where('date <=', $end_date)
            ->where('outlet_id', $outlet_id)
            ->where('del_status', 'Live')
            ->get()
            ->row();

        $gross_profit = (float) ($sales->total_sales ?? 0) - $cogs;
        $net_profit = $gross_profit - (float) ($expenses->total_expenses ?? 0) - (float) ($wastes->total_wastes ?? 0) - (float) ($sales->total_discounts ?? 0);

        $report = [
            'revenue' => [
                'total_sales' => (float) ($sales->total_sales ?? 0)
            ],
            'costs_and_expenses' => [
                'cost_of_goods_sold' => $cogs,
                'total_expenses' => (float) ($expenses->total_expenses ?? 0),
                'total_wastes' => (float) ($wastes->total_wastes ?? 0),
                'total_discounts' => (float) ($sales->total_discounts ?? 0),
                'total_vat' => (float) ($sales->total_vat ?? 0)
            ],
            'profit_summary' => [
                'gross_profit' => $gross_profit,
                'net_profit' => $net_profit
            ]
        ];
        return $report;
    }

    public function sales_by_waiter_report($start_date, $end_date, $outlet_id, $waiter_id = null)
    {
        $this->db->select('
            s.waiter_id,
            u.full_name as waiter_name,
            COUNT(s.id) as total_sales_count,
            SUM(s.total_payable) as total_sales_amount
        ');
        $this->db->from('tbl_sales s');
        $this->db->join('tbl_users u', 'u.id = s.waiter_id', 'left');
        $this->db->where('s.sale_date >=', $start_date);
        $this->db->where('s.sale_date <=', $end_date);
        $this->db->where('s.outlet_id', $outlet_id);
        $this->db->where('s.order_status', 3);
        $this->db->where('s.del_status', 'Live');
        if ($waiter_id) {
            $this->db->where('s.waiter_id', $waiter_id);
        }
        $this->db->group_by('s.waiter_id');
        $this->db->order_by('total_sales_amount', 'DESC');
        return $this->db->get()->result();
    }

    public function attendance_report($start_date, $end_date, $company_id, $employee_id = null, $is_personal = false, $user_id = null)
    {
        $this->db->select('
            a.id,
            a.reference_no,
            a.date,
            a.in_time,
            a.out_time,
            a.note,
            u.full_name as employee_name,
            TIMEDIFF(a.out_time, a.in_time) as work_duration
        ');
        $this->db->from('tbl_attendance a');
        $this->db->join('tbl_users u', 'u.id = a.employee_id', 'left');
        $this->db->where('a.date >=', $start_date);
        $this->db->where('a.date <=', $end_date);
        $this->db->where('a.company_id', $company_id);
        $this->db->where('a.del_status', 'Live');
        if ($employee_id) {
            $this->db->where('a.employee_id', $employee_id);
        }
        if ($is_personal && $user_id) {
            $this->db->where('a.employee_id', $user_id);
        }
        $this->db->order_by('a.date', 'DESC');
        $this->db->order_by('a.in_time', 'ASC');
        return $this->db->get()->result();
    }

    public function customer_due_report($company_id, $outlet_id = null)
    {
        $outlet_ids = $this->get_outlet_ids($outlet_id);
        $this->db->select("
            c.id as customer_id,
            c.name as customer_name,
            c.phone,
            (SELECT SUM(s.due_amount) FROM tbl_sales s WHERE s.customer_id = c.id AND s.del_status = 'Live' AND s.outlet_id IN (" . implode(',', $outlet_ids) . ")) as total_due,
            (SELECT SUM(cdr.amount) FROM tbl_customer_due_receives cdr WHERE cdr.customer_id = c.id AND cdr.del_status = 'Live' AND cdr.outlet_id IN (" . implode(',', $outlet_ids) . ')) as total_paid
        ');
        $this->db->from('tbl_customers c');
        $this->db->where('c.company_id', $company_id);
        $this->db->where('c.del_status', 'Live');
        $this->db->having('total_due > total_paid');
        $this->db->order_by('customer_name', 'ASC');
        $results = $this->db->get()->result();
        foreach ($results as $result) {
            $result->remaining_due = (float) $result->total_due - (float) $result->total_paid;
        }
        return $results;
    }

    public function supplier_due_report($company_id, $outlet_id = null)
    {
        $outlet_ids = $this->get_outlet_ids($outlet_id);
        $this->db->select("
            s.id as supplier_id,
            s.name as supplier_name,
            s.phone,
            (SELECT SUM(p.due) FROM tbl_purchase p WHERE p.supplier_id = s.id AND p.del_status = 'Live' AND p.outlet_id IN (" . implode(',', $outlet_ids) . ")) as total_due,
            (SELECT SUM(sp.amount) FROM tbl_supplier_payments sp WHERE sp.supplier_id = s.id AND sp.del_status = 'Live' AND sp.outlet_id IN (" . implode(',', $outlet_ids) . ')) as total_paid
        ');
        $this->db->from('tbl_suppliers s');
        $this->db->where('s.company_id', $company_id);
        $this->db->where('s.del_status', 'Live');
        $this->db->having('total_due > total_paid');
        $this->db->order_by('supplier_name', 'ASC');
        $results = $this->db->get()->result();
        foreach ($results as $result) {
            $result->remaining_due = (float) $result->total_due - (float) $result->total_paid;
        }
        return $results;
    }

    public function customer_ledger($customer_id, $start_date, $end_date)
    {
        $outlet_ids = $this->get_outlet_ids($this->auth_data->outlet_id);

        $sales_due_before = $this
            ->db
            ->select('SUM(due_amount) as total')
            ->from('tbl_sales')
            ->where('customer_id', $customer_id)
            ->where_in('outlet_id', $outlet_ids)
            ->where('sale_date <', $start_date)
            ->where('del_status', 'Live')
            ->get()
            ->row('total');
        $payments_before = $this
            ->db
            ->select('SUM(amount) as total')
            ->from('tbl_customer_due_receives')
            ->where('customer_id', $customer_id)
            ->where_in('outlet_id', $outlet_ids)
            ->where('only_date <', $start_date)
            ->where('del_status', 'Live')
            ->get()
            ->row('total');
        $opening_balance = (float) ($sales_due_before ?? 0) - (float) ($payments_before ?? 0);
        $sales_query = $this
            ->db
            ->select("id, sale_no as reference_no, sale_date as date, 'Sale' as type, total_payable as debit, paid_amount as credit")
            ->from('tbl_sales')
            ->where('customer_id', $customer_id)
            ->where_in('outlet_id', $outlet_ids)
            ->where('sale_date >=', $start_date)
            ->where('sale_date <=', $end_date)
            ->where('del_status', 'Live');
        $sales_subquery = $this->db->get_compiled_select();
        $payments_query = $this
            ->db
            ->select("id, reference_no, only_date as date, 'Due Receive' as type, 0 as debit, amount as credit")
            ->from('tbl_customer_due_receives')
            ->where('customer_id', $customer_id)
            ->where_in('outlet_id', $outlet_ids)
            ->where('only_date >=', $start_date)
            ->where('only_date <=', $end_date)
            ->where('del_status', 'Live');
        $payments_subquery = $this->db->get_compiled_select();

        $ledger = $this->db->query("($sales_subquery) UNION ALL ($payments_subquery) ORDER BY date ASC")->result();
        return ['opening_balance' => $opening_balance, 'transactions' => $ledger];
    }

    public function supplier_ledger($supplier_id, $start_date, $end_date)
    {
        $outlet_ids = $this->get_outlet_ids($this->auth_data->outlet_id);

        $purchases_due_before = $this
            ->db
            ->select('SUM(due) as total')
            ->from('tbl_purchase')
            ->where('supplier_id', $supplier_id)
            ->where_in('outlet_id', $outlet_ids)
            ->where('date <', $start_date)
            ->where('del_status', 'Live')
            ->get()
            ->row('total');

        $payments_before = $this
            ->db
            ->select('SUM(amount) as total')
            ->from('tbl_supplier_payments')
            ->where('supplier_id', $supplier_id)
            ->where_in('outlet_id', $outlet_ids)
            ->where('date <', $start_date)
            ->where('del_status', 'Live')
            ->get()
            ->row('total');

        $opening_balance = (float) ($purchases_due_before ?? 0) - (float) ($payments_before ?? 0);

        $purchases_query = $this
            ->db
            ->select("id, reference_no, date, 'Purchase' as type, grand_total as debit, paid as credit")
            ->from('tbl_purchase')
            ->where('supplier_id', $supplier_id)
            ->where_in('outlet_id', $outlet_ids)
            ->where('date >=', $start_date)
            ->where('date <=', $end_date)
            ->where('del_status', 'Live');
        $purchases_subquery = $this->db->get_compiled_select();

        $payments_query = $this
            ->db
            ->select("id, '' as reference_no, date, 'Due Payment' as type, 0 as debit, amount as credit")
            ->from('tbl_supplier_payments')
            ->where('supplier_id', $supplier_id)
            ->where_in('outlet_id', $outlet_ids)
            ->where('date >=', $start_date)
            ->where('date <=', $end_date)
            ->where('del_status', 'Live');
        $payments_subquery = $this->db->get_compiled_select();

        $ledger = $this->db->query("($purchases_subquery) UNION ALL ($payments_subquery) ORDER BY date ASC")->result();
        return ['opening_balance' => $opening_balance, 'transactions' => $ledger];
    }

    public function get_dashboard_summary($outlet_id, $date)
    {
        $today_sales = $this
            ->db
            ->select('COUNT(id) as total_orders, SUM(total_payable) as total_sales, SUM(due_amount) as total_due')
            ->from('tbl_sales')
            ->where('sale_date', $date)
            ->where('outlet_id', $outlet_id)
            ->where('order_status', 3)
            ->where('del_status', 'Live')
            ->get()
            ->row();
        $running_orders = $this
            ->db
            ->from('tbl_sales')
            ->where('outlet_id', $outlet_id)
            ->where_in('order_status', [1, 2])
            ->where('del_status', 'Live')
            ->count_all_results();
        $today_purchases = $this
            ->db
            ->select('SUM(grand_total) as total_purchases')
            ->from('tbl_purchase')
            ->where('date', $date)
            ->where('outlet_id', $outlet_id)
            ->where('del_status', 'Live')
            ->get()
            ->row();
        $all_ingredients = $this->inventory_report($outlet_id);
        $low_stock_count = 0;
        foreach ($all_ingredients as $ing) {
            if ($ing->alert_quantity > 0 && $ing->stock_qty <= $ing->alert_quantity) {
                $low_stock_count++;
            }
        }
        $top_5_items = $this
            ->db
            ->select('fm.name as menu_name, SUM(sd.qty) as total_quantity_sold')
            ->from('tbl_sales_details sd')
            ->join('tbl_sales s', 's.id = sd.sales_id')
            ->join('tbl_food_menus fm', 'fm.id = sd.food_menu_id')
            ->where('s.sale_date', $date)
            ->where('s.outlet_id', $outlet_id)
            ->where('s.order_status', 3)
            ->where('s.del_status', 'Live')
            ->group_by('sd.food_menu_id')
            ->order_by('total_quantity_sold', 'DESC')
            ->limit(5)
            ->get()
            ->result();
        $summary = [
            'today_summary' => [
                'total_sales' => (float) ($today_sales->total_sales ?? 0),
                'total_orders' => (int) ($today_sales->total_orders ?? 0),
                'total_due' => (float) ($today_sales->total_due ?? 0),
                'total_purchases' => (float) ($today_purchases->total_purchases ?? 0)
            ],
            'live_status' => [
                'running_orders' => (int) ($running_orders ?? 0),
                'low_stock_items' => (int) ($low_stock_count ?? 0)
            ],
            'top_selling_items_today' => $top_5_items
        ];
        return $summary;
    }

      public function get_full_dashboard_data($outlet_id, $start_date, $end_date)
    {
        $company_id = $this->auth_data->company_id;

        $food_menu_count = $this->db->where("FIND_IN_SET(id, (SELECT food_menus FROM tbl_outlets WHERE id = $outlet_id)) != 0")->where('del_status', 'Live')->count_all_results('tbl_food_menus');
        $ingredient_count = $this->db->where('company_id', $company_id)->where('del_status', 'Live')->count_all_results('tbl_ingredients');
        $customer_count = $this->db->where('company_id', $company_id)->where('del_status', 'Live')->count_all_results('tbl_customers');
        $employee_count = $this->db->where('company_id', $company_id)->where('del_status', 'Live')->count_all_results('tbl_users');

        $all_ingredients = $this->inventory_report($outlet_id);
        $low_stock_ingredients = [];
        foreach($all_ingredients as $ingredient){
            if($ingredient->alert_quantity > 0 && $ingredient->stock_qty <= $ingredient->alert_quantity){
                $low_stock_ingredients[] = $ingredient;
            }
        }

        $sales_metrics = $this->db->select("
            SUM(total_payable) as sale_sum,
            COUNT(CASE WHEN order_type = 1 THEN 1 END) as dinein_count,
            COUNT(CASE WHEN order_type = 2 THEN 1 END) as take_away_count,
            COUNT(CASE WHEN order_type = 3 THEN 1 END) as delivery_count,
            COUNT(CASE WHEN order_status IN (1, 2) THEN 1 END) as running_orders
        ")
        ->from('tbl_sales')
        ->where('sale_date >=', $start_date)
        ->where('sale_date <=', $end_date)
        ->where('outlet_id', $outlet_id)
        ->where('del_status', 'Live')
        ->get()
        ->row();

        $purchase_sum = $this->api_get_sum('tbl_purchase', 'grand_total', 'date', $start_date, $end_date, $outlet_id);
        $waste_sum = $this->api_get_sum('tbl_wastes', 'total_loss', 'date', $start_date, $end_date, $outlet_id);
        $expense_sum = $this->api_get_sum('tbl_expenses', 'amount', 'date', $start_date, $end_date, $outlet_id);
        $customer_due_receive_sum = $this->api_get_sum('tbl_customer_due_receives', 'amount', 'only_date', $start_date, $end_date, $outlet_id);
        $supplier_due_payment_sum = $this->api_get_sum('tbl_supplier_payments', 'amount', 'date', $start_date, $end_date, $outlet_id);

        $sales_by_payment_methods = $this->api_sale_by_payments($start_date, $end_date, $outlet_id);
        $total_paid_by_methods = $this->api_sale_by_payments_total($start_date, $end_date, $outlet_id);

        $daily_sales_summary = $this->db->select('sale_date, sum(total_payable) as total_payable')
            ->from('tbl_sales')
            ->where('sale_date >=', $start_date)
            ->where('sale_date <=', $end_date)
            ->where('order_status', '3')
            ->where('outlet_id', $outlet_id)
            ->where('del_status', "Live")
            ->group_by('sale_date')
            ->order_by('sale_date', 'ASC')
            ->get()->result();

        $dashboard_data = [
            'kpi_counts' => [
                'food_menu_count' => (int)$food_menu_count,
                'ingredient_count' => (int)$ingredient_count,
                'customer_count' => (int)$customer_count,
                'employee_count' => (int)$employee_count,
            ],
            'operational_summary' => [
                'purchase_sum' => (float)$purchase_sum,
                'sale_sum' => (float)($sales_metrics->sale_sum ?? 0),
                'waste_sum' => (float)$waste_sum,
                'expense_sum' => (float)$expense_sum,
                'customer_due_receive_sum' => (float)$customer_due_receive_sum,
                'supplier_due_payment_sum' => (float)$supplier_due_payment_sum,
            ],
            'order_type_summary' => [
                'dinein_count' => (int)($sales_metrics->dinein_count ?? 0),
                'take_away_count' => (int)($sales_metrics->take_away_count ?? 0),
                'delivery_count' => (int)($sales_metrics->delivery_count ?? 0),
            ],
            'live_status' => [
                'running_orders' => (int)($sales_metrics->running_orders ?? 0),
                'low_stock_items' => count($low_stock_ingredients)
            ],
            'top_10_food_menu' => $this->api_top_ten_food_menu($start_date, $end_date, $outlet_id),
            'top_10_customer' => $this->api_top_ten_customer($start_date, $end_date, $outlet_id, $company_id),
            
            'customer_receivables' => $this->api_customer_receivable($outlet_id, 50), 
            'supplier_payables' => $this->api_supplier_payable($outlet_id),
            'low_stock_ingredients' => $low_stock_ingredients,
            'sales_by_payment_methods' => [
                'total_paid' => (float)($total_paid_by_methods->total_sales ?? 0),
                'breakdown' => $sales_by_payment_methods
            ],
            'daily_sales_summary' => $daily_sales_summary
        ];

        return $dashboard_data;
    }

    public function detailed_sale_report($start_date, $end_date, $outlet_id, $user_id = null)
    {
        $this->db->select('s.id, s.sale_no, s.sale_date, s.order_type, s.total_payable, s.paid_amount, s.due_amount, c.name as customer_name, u.full_name as user_name');
        $this->db->from('tbl_sales s');
        $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
        $this->db->join('tbl_users u', 'u.id = s.user_id', 'left');
        $this->db->where('s.sale_date >=', $start_date);
        $this->db->where('s.sale_date <=', $end_date);
        $this->db->where('s.outlet_id', $outlet_id);
        $this->db->where('s.order_status', 3);
        $this->db->where('s.del_status', 'Live');

        if ($user_id) {
            $this->db->where('s.user_id', $user_id);
        }

        $this->db->order_by('s.sale_date', 'DESC');
        return $this->db->get()->result();
    }

    public function expense_report($start_date, $end_date, $outlet_id, $expense_item_id = null)
    {
        $this->db->select('e.id, e.date, e.amount, ei.name as category_name, u.full_name as responsible_person, e.note, pm.name as payment_method_name');
        $this->db->from('tbl_expenses e');
        $this->db->join('tbl_expense_items ei', 'ei.id = e.category_id', 'left');
        $this->db->join('tbl_users u', 'u.id = e.employee_id', 'left');
        $this->db->join('tbl_payment_methods pm', 'pm.id = e.payment_id', 'left');
        $this->db->where('e.date >=', $start_date);
        $this->db->where('e.date <=', $end_date);
        $this->db->where('e.outlet_id', $outlet_id);
        if ($expense_item_id) {
            $this->db->where('e.category_id', $expense_item_id);
        }
        $this->db->where('e.del_status', 'Live');
        $this->db->order_by('e.date', 'DESC');
        return $this->db->get()->result();
    }

    public function waste_report($start_date, $end_date, $outlet_id, $user_id = null)
    {
        $this->db->select('w.id, w.reference_no, w.date, w.total_loss, w.note, u.full_name as responsible_person, w.employee_id');
        $this->db->from('tbl_wastes w');
        $this->db->join('tbl_users u', 'u.id = w.employee_id', 'left');
        $this->db->where('w.date >=', $start_date);
        $this->db->where('w.date <=', $end_date);
        $this->db->where('w.outlet_id', $outlet_id);
        if ($user_id) {
            $this->db->where('w.employee_id', $user_id);
        }
        $this->db->where('w.del_status', 'Live');
        $this->db->order_by('w.date', 'DESC');
        return $this->db->get()->result();
    }

    public function vat_report($start_date, $end_date, $outlet_id)
    {
        $this->db->select('sale_no, sale_date, total_payable, sale_vat_objects, total_vat');
        $this->db->from('tbl_sales');
        $this->db->where('sale_date >=', $start_date);
        $this->db->where('sale_date <=', $end_date);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('total_vat >', 0);
        $this->db->where('order_status', 3);
        $this->db->where('del_status', 'Live');
        return $this->db->get()->result();
    }

    public function detailed_purchase_report($start_date, $end_date, $outlet_id, $user_id = null)
    {
        $this->db->select('p.*, u.full_name as user_name');
        $this->db->from('tbl_purchase p');
        $this->db->join('tbl_users u', 'u.id = p.user_id', 'left');
        $this->db->where('p.date >=', $start_date);
        $this->db->where('p.date <=', $end_date);
        $this->db->where('p.outlet_id', $outlet_id);
        $this->db->where('p.del_status', 'Live');
        if ($user_id) {
            $this->db->where('p.user_id', $user_id);
        }
        $this->db->order_by('p.date', 'DESC');
        return $this->db->get()->result();
    }

    public function customer_report($start_date, $end_date, $customer_id, $outlet_id)
    {
        $sales = $this
            ->db
            ->select('sale_date,total_payable,paid_amount,due_amount,sale_no')
            ->from('tbl_sales')
            ->where('sale_date >=', $start_date)
            ->where('sale_date <=', $end_date)
            ->where('customer_id', $customer_id)
            ->where('order_status', 3)
            ->where('outlet_id', $outlet_id)
            ->where('del_status', 'Live')
            ->get()
            ->result();

        $due_receives = $this
            ->db
            ->select('date, amount, note')
            ->from('tbl_customer_due_receives')
            ->where('date >=', $start_date)
            ->where('date <=', $end_date)
            ->where('customer_id', $customer_id)
            ->where('outlet_id', $outlet_id)
            ->where('del_status', 'Live')
            ->get()
            ->result();

        return ['sales' => $sales, 'due_receives' => $due_receives];
    }

    public function audit_log_report($start_date, $end_date, $user_id, $event_title, $outlet_id)
    {
        $this->db->select('al.*, o.outlet_name');
        $this->db->from('tbl_audit_logs al');
        $this->db->join('tbl_outlets o', 'o.id = al.outlet_id', 'left');
        if ($start_date)
            $this->db->where('al.date >=', $start_date);
        if ($end_date)
            $this->db->where('al.date <=', $end_date);
        if ($user_id)
            $this->db->where('al.user_id', $user_id);
        if ($event_title)
            $this->db->where('al.event_title', $event_title);
        $this->db->where('al.outlet_id', $outlet_id);
        $this->db->where('al.del_status', 'Live');
        $this->db->order_by('al.id', 'desc');
        return $this->db->get()->result();
    }

    public function consumption_report($start_date, $end_date, $outlet_id)
    {
        $menus = $this
            ->db
            ->select('sum(consumption*cost) as total_consumption, sum(consumption) as total_consumption_qty, ingredient_id,i.name as ingredient_name,i.code as ingredient_code,i.purchase_price,i.conversion_rate')
            ->from('tbl_sales s')
            ->join('tbl_sale_consumptions_of_menus scm', 'scm.sales_id = s.id', 'inner')
            ->join('tbl_ingredients i', 'i.id = scm.ingredient_id', 'inner')
            ->where('s.sale_date>=', $start_date)
            ->where('s.sale_date <=', $end_date)
            ->where('s.outlet_id', $outlet_id)
            ->where('s.del_status', 'Live')
            ->where('s.order_status', 3)
            ->group_by('scm.ingredient_id')
            ->order_by('i.name', 'ASC')
            ->get()
            ->result();

        $modifiers = $this
            ->db
            ->select('sum(consumption*cost) as total_consumption, sum(consumption) as total_consumption_qty, ingredient_id,i.name as ingredient_name,i.code as ingredient_code,i.purchase_price,i.conversion_rate')
            ->from('tbl_sales s')
            ->join('tbl_sale_consumptions_of_modifiers_of_menus scmm', 'scmm.sales_id = s.id', 'inner')
            ->join('tbl_ingredients i', 'i.id = scmm.ingredient_id', 'inner')
            ->where('s.sale_date>=', $start_date)
            ->where('s.sale_date <=', $end_date)
            ->where('s.outlet_id', $outlet_id)
            ->where('s.del_status', 'Live')
            ->where('s.order_status', 3)
            ->group_by('scmm.ingredient_id')
            ->order_by('i.name', 'ASC')
            ->get()
            ->result();

        return ['menus' => $menus, 'modifiers' => $modifiers];
    }

    public function kitchen_performance_report($start_date, $end_date, $outlet_id)
    {
        $this->db->select('s.id as sale_id, sd.id as sale_details_id, sd.outlet_id, sd.menu_name, s.sale_date, s.sale_no, s.order_type, s.order_time, sd.cooking_start_time, sd.cooking_done_time');
        $this->db->from('tbl_sales_details sd');
        $this->db->join('tbl_sales s', 's.id = sd.sales_id', 'left');
        $this->db->where('s.sale_date>=', $start_date);
        $this->db->where('s.sale_date <=', $end_date);
        $this->db->where('sd.outlet_id', $outlet_id);
        $this->db->where('sd.del_status', 'Live');
        $this->db->where('s.order_status', '3');
        $this->db->where('sd.cooking_done_time IS NOT NULL');
        return $this->db->get()->result();
    }

    public function loyalty_points_report($customer_id, $outlet_id)
    {
        $this->db->select('id, name, phone');
        $this->db->from('tbl_customers');
        if ($customer_id != '') {
            $this->db->where('id', $customer_id);
        }
        $this->db->where('del_status', 'Live');
        $results = $this->db->get()->result();
        foreach ($results as $key => $value) {
            $return_data = getTotalLoyaltyPoint($value->id, $outlet_id);
            $results[$key]->redeemed_point = $return_data[0];
            $results[$key]->available_point = $return_data[1];
        }
        return $results;
    }

    public function loyalty_points_usage_report($start_date, $end_date, $customer_id, $outlet_id)
    {
        $this->db->select('p.*, c.name, c.phone, s.sale_no, s.date_time');
        $this->db->from('tbl_sale_payments p');
        $this->db->join('tbl_sales s', 's.id = p.sale_id', 'left');
        $this->db->join('tbl_customers c', 'c.id = s.customer_id', 'left');
        if ($start_date)
            $this->db->where('s.sale_date >=', $start_date);
        if ($end_date)
            $this->db->where('s.sale_date <=', $end_date);
        if ($customer_id)
            $this->db->where('s.customer_id', $customer_id);
        $this->db->where('s.outlet_id', $outlet_id);
        $this->db->where('p.payment_id', 5);
        $this->db->where('s.order_status', 3);
        $this->db->where('p.del_status', 'Live');
        return $this->db->get()->result();
    }

    public function production_report($start_date, $end_date, $outlet_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_production');
        if ($start_date)
            $this->db->where('date >=', $start_date);
        if ($end_date)
            $this->db->where('date <=', $end_date);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('status', '1');
        $this->db->where('del_status', 'Live');
        $productions = $this->db->get()->result();

        foreach ($productions as $key => $value) {
            $food_list = $this
                ->db
                ->select('pi.quantity_amount, i.name as ingredient_name, i.code as ingredient_code, u.unit_name')
                ->from('tbl_production_ingredients pi')
                ->join('tbl_ingredients i', 'i.id = pi.ingredient_id')
                ->join('tbl_units u', 'u.id = i.unit_id', 'left')
                ->where('pi.production_id', $value->id)
                ->get()
                ->result();
            $productions[$key]->items = $food_list;
        }
        return $productions;
    }

    public function register_report($start_date, $end_date, $user_id, $outlet_id)
    {
        $this->db->select('r.*, c.name as counter_name');
        $this->db->from('tbl_register r');
        $this->db->join('tbl_counters c', 'c.id = r.counter_id', 'left');
        if ($user_id)
            $this->db->where('r.user_id', $user_id);
        $this->db->where('r.outlet_id', $outlet_id);
        $this->db->where('DATE(r.opening_balance_date_time) >=', $start_date);
        $this->db->where('DATE(r.opening_balance_date_time) <=', $end_date);
        $this->db->order_by('r.id', 'DESC');
        return $this->db->get()->result();
    }

    public function tips_report($start_date, $end_date, $outlet_id, $waiter_id)
    {
        $this->db->select('sale_no, sale_date, total_payable, tips_amount_actual_charge as total_tips');
        $this->db->from('tbl_sales');
        if ($start_date)
            $this->db->where('sale_date >=', $start_date);
        if ($end_date)
            $this->db->where('sale_date <=', $end_date);
        if ($waiter_id)
            $this->db->where('waiter_id', $waiter_id);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('tips_amount_actual_charge >', 0);
        $this->db->where('order_status', 3);
        $this->db->where('del_status', 'Live');
        return $this->db->get()->result();
    }

    public function transfer_report($start_date, $end_date, $from_outlet_id, $to_outlet_id)
    {
        $this->db->select('t.*, from_o.outlet_name as from_outlet, to_o.outlet_name as to_outlet');
        $this->db->from('tbl_transfer t');
        $this->db->join('tbl_outlets from_o', 'from_o.id = t.from_outlet_id');
        $this->db->join('tbl_outlets to_o', 'to_o.id = t.to_outlet_id');
        if ($start_date)
            $this->db->where('t.received_date >=', $start_date);
        if ($end_date)
            $this->db->where('t.received_date <=', $end_date);
        if ($from_outlet_id)
            $this->db->where('t.from_outlet_id', $from_outlet_id);
        if ($to_outlet_id)
            $this->db->where('t.to_outlet_id', $to_outlet_id);
        $this->db->where('t.status', 1);
        $this->db->where('t.del_status', 'Live');
        $transfers = $this->db->get()->result();
        foreach ($transfers as $key => $value) {
            $items = $this
                ->db
                ->select('ti.quantity_amount, i.name as ingredient_name, i.code as ingredient_code')
                ->from('tbl_transfer_ingredients ti')
                ->join('tbl_ingredients i', 'i.id = ti.ingredient_id')
                ->where('ti.transfer_id', $value->id)
                ->get()
                ->result();
            $transfers[$key]->items = $items;
        }
        return $transfers;
    }

    public function sales_summary_by_date($start_date, $end_date, $outlet_id, $user_id)
    {
        $this->db->select('sale_date, sum(total_payable) as total_payable, sum(total_refund) as total_refund');
        $this->db->from('tbl_sales');
        if ($start_date)
            $this->db->where('sale_date >=', $start_date);
        if ($end_date)
            $this->db->where('sale_date <=', $end_date);
        if ($user_id)
            $this->db->where('user_id', $user_id);
        $this->db->where('order_status', '3');
        $this->db->where('outlet_id', $outlet_id);
        $this->db->group_by('sale_date');
        $this->db->where('del_status', 'Live');
        return $this->db->get()->result();
    }

    public function sales_summary_by_month($start_date, $end_date, $outlet_id, $user_id)
    {
        $this->db->select('DATE_FORMAT(sale_date, "%Y-%m") as sale_month, sum(total_payable) as total_payable');
        $this->db->from('tbl_sales');
        if ($start_date)
            $this->db->where('sale_date >=', $start_date);
        if ($end_date)
            $this->db->where('sale_date <=', $end_date);
        if ($user_id)
            $this->db->where('user_id', $user_id);
        $this->db->where('order_status', '3');
        $this->db->where('outlet_id', $outlet_id);
        $this->db->group_by('DATE_FORMAT(sale_date, "%Y-%m")');
        $this->db->where('del_status', 'Live');
        return $this->db->get()->result();
    }

    private function api_get_sum($table, $sum_field, $date_field, $start, $end, $outlet_id)
    {
        $result = $this
            ->db
            ->select("SUM({$sum_field}) as total_sum")
            ->from($table)
            ->where("{$date_field} >=", $start)
            ->where("{$date_field} <=", $end)
            ->where('outlet_id', $outlet_id)
            ->where('del_status', 'Live')
            ->get()
            ->row();
        return $result->total_sum ?? 0;
    }

    private function api_get_order_type_count($order_type, $start, $end, $outlet_id)
    {
        return $this
            ->db
            ->from('tbl_sales')
            ->where('sale_date >=', $start)
            ->where('sale_date <=', $end)
            ->where('order_type', $order_type)
            ->where('outlet_id', $outlet_id)
            ->where('del_status', 'Live')
            ->count_all_results();
    }

    private function api_top_ten_food_menu($start_date, $end_date, $outlet_id)
    {
        return $this
            ->db
            ->select('sum(qty) as total_qty, menu_name')
            ->from('tbl_sales_details')
            ->join('tbl_sales', 'tbl_sales.id = tbl_sales_details.sales_id', 'left')
            ->where('sale_date>=', $start_date)
            ->where('sale_date <=', $end_date)
            ->where('tbl_sales_details.outlet_id', $outlet_id)
            ->where('tbl_sales_details.del_status', 'Live')
            ->group_by('food_menu_id, menu_name')
            ->order_by('total_qty', 'desc')
            ->limit(10)
            ->get()
            ->result();
    }

    private function api_top_ten_customer($start_date, $end_date, $outlet_id, $company_id)
    {
        return $this
            ->db
            ->select('sum(tbl_sales.total_payable) as total_payable, tbl_customers.name, tbl_customers.phone')
            ->from('tbl_sales')
            ->join('tbl_customers', 'tbl_sales.customer_id = tbl_customers.id', 'left')
            ->where('tbl_sales.sale_date>=', $start_date)
            ->where('tbl_sales.sale_date <=', $end_date)
            ->where('tbl_sales.outlet_id', $outlet_id)
            ->where('tbl_sales.company_id', $company_id)
            ->where('tbl_sales.del_status', 'Live')
            ->where('tbl_sales.customer_id IS NOT NULL')
            ->group_by('customer_id')
            ->order_by('total_payable', 'desc')
            ->limit(10)
            ->get()
            ->result();
    }

       private function api_customer_receivable($outlet_id, $limit = 50)
    {
        return $this->db->select('sum(due_amount) as due_amount, name, tbl_customers.phone')
            ->from('tbl_sales')
            ->join('tbl_customers', 'tbl_customers.id = tbl_sales.customer_id', 'left')
            ->where('tbl_sales.outlet_id', $outlet_id)
            ->where('tbl_sales.due_amount >', 0)
            ->where('tbl_sales.del_status', 'Live')
            ->group_by('tbl_sales.customer_id')
            ->order_by('due_amount', 'desc')
            ->limit($limit)
            ->get()
            ->result();
    }

    private function api_supplier_payable($outlet_id)
    {
        return $this
            ->db
            ->select('sum(due) as due, name, phone')
            ->from('tbl_purchase')
            ->join('tbl_suppliers', 'tbl_suppliers.id = tbl_purchase.supplier_id', 'left')
            ->where('tbl_purchase.outlet_id', $outlet_id)
            ->where('tbl_purchase.due >', 0)
            ->where('tbl_purchase.del_status', 'Live')
            ->group_by('tbl_purchase.supplier_id')
            ->order_by('due', 'desc')
            ->get()
            ->result();
    }

    private function api_sale_by_payments_total($start_date, $end_date, $outlet_id)
    {
        return $this
            ->db
            ->select('sum(amount) as total_sales')
            ->from('tbl_sale_payments')
            ->join('tbl_sales', 'tbl_sales.id = tbl_sale_payments.sale_id', 'left')
            ->where('sale_date>=', $start_date)
            ->where('sale_date <=', $end_date)
            ->where('tbl_sale_payments.outlet_id', $outlet_id)
            ->where('tbl_sales.order_status', 3)
            ->where('tbl_sale_payments.del_status', 'Live')
            ->get()
            ->row();
    }

    private function api_sale_by_payments($start_date, $end_date, $outlet_id)
    {
        return $this
            ->db
            ->select('sum(amount) as total_sales, tbl_payment_methods.name')
            ->from('tbl_sale_payments')
            ->join('tbl_sales', 'tbl_sales.id = tbl_sale_payments.sale_id', 'left')
            ->join('tbl_payment_methods', 'tbl_payment_methods.id = tbl_sale_payments.payment_id', 'left')
            ->where('sale_date>=', $start_date)
            ->where('sale_date <=', $end_date)
            ->where('tbl_sales.order_status', 3)
            ->where('tbl_sale_payments.outlet_id', $outlet_id)
            ->where('tbl_sale_payments.del_status', 'Live')
            ->group_by('tbl_payment_methods.id')
            ->order_by('total_sales', 'desc')
            ->get()
            ->result();
    }
}
