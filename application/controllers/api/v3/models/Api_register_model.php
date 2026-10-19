<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_register_model extends CI_Model
{
    private $table = 'tbl_register';

    public function get_open_register($user_id, $outlet_id, $counter_id)
    {
        return $this
            ->db
            ->where('user_id', $user_id)
            ->where('outlet_id', $outlet_id)
            ->where('counter_id', $counter_id)
            ->where('register_status', 1)
            ->get($this->table)
            ->row();
    }

    public function open_register($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function get_register_details($register)
    {
        $start_time = $register->opening_balance_date_time;
        $end_time = date('Y-m-d H:i:s');
        $outlet_id = $register->outlet_id;

        $this->db->where('company_id', $register->company_id)->where('del_status', 'Live');
        $payment_methods = $this->db->get('tbl_payment_methods')->result();

        $opening_balances_map = [];
        if (isset($register->opening_details) && !empty($register->opening_details)) {
            $opening_details_decoded = json_decode($register->opening_details, true);

            if (is_array($opening_details_decoded)) {
                if (isset($opening_details_decoded[0]['payment_id'])) {
                    foreach ($opening_details_decoded as $detail) {
                        $opening_balances_map[$detail['payment_id']] = (float) $detail['amount'];
                    }
                } else {
                    foreach ($opening_details_decoded as $detail_str) {
                        $parts = explode('||', $detail_str);
                        if (count($parts) === 3) {
                            $payment_id = (int) $parts[0];
                            $amount = (float) $parts[2];
                            $opening_balances_map[$payment_id] = $amount;
                        }
                    }
                }
            }
        }

        $detailed_summary = [];
        foreach ($payment_methods as $pm) {
            $sales = $this
                ->db
                ->select('SUM(amount) as total')
                ->from('tbl_sale_payments sp')
                ->join('tbl_sales s', 's.id = sp.sale_id')
                ->where('s.date_time >=', $start_time)
                ->where('s.date_time <=', $end_time)
                ->where('s.outlet_id', $outlet_id)
                ->where('sp.payment_id', $pm->id)
                ->get()
                ->row('total');

            $supplier_payments = $this
                ->db
                ->select('SUM(amount) as total')
                ->from('tbl_supplier_payments')
                ->where('added_date_time >=', $start_time)
                ->where('added_date_time <=', $end_time)
                ->where('outlet_id', $outlet_id)
                ->where('payment_id', $pm->id)
                ->get()
                ->row('total');

            $expenses = $this
                ->db
                ->select('SUM(amount) as total')
                ->from('tbl_expenses')
                
                ->where('added_date_time >=', $start_time)  
                ->where('added_date_time <=', $end_time)  
                ->where('outlet_id', $outlet_id)
                ->where('payment_id', $pm->id)
                ->where('del_status', 'Live')  
                ->get()
                ->row('total');

            $customer_due_receives = $this
                ->db
                ->select('SUM(amount) as total')
                ->from('tbl_customer_due_receives')
                ->where('date >=', $start_time)
                ->where('date <=', $end_time)
                ->where('outlet_id', $outlet_id)
                ->where('payment_id', $pm->id)
                ->get()
                ->row('total');

            $opening_balance = isset($opening_balances_map[$pm->id]) ? $opening_balances_map[$pm->id] : 0.0;

            $closing_balance = $opening_balance + (float) ($sales ?? 0) + (float) ($customer_due_receives ?? 0) - (float) ($supplier_payments ?? 0) - (float) ($expenses ?? 0);

            $detailed_summary[] = [
                'payment_method_id' => (int) $pm->id,
                'payment_method_name' => $pm->name,
                'opening_balance' => $opening_balance,
                'sales' => (float) ($sales ?? 0),
                'customer_due_receives' => (float) ($customer_due_receives ?? 0),
                'supplier_payments' => (float) ($supplier_payments ?? 0),
                'expenses' => (float) ($expenses ?? 0),
                'closing_balance' => $closing_balance
            ];
        }

        $register_info_cleaned = [
            'id' => (int) $register->id,
            'opening_balance' => (float) $register->opening_balance,
            'opening_balance_date_time' => $register->opening_balance_date_time,
            'user_id' => (int) $register->user_id,
            'outlet_id' => (int) $register->outlet_id,
        ];

        return [
            'register_info' => $register_info_cleaned,
            'detailed_summary' => $detailed_summary
        ];
    }

    public function close_register($register_id, $closing_balance, $payment_methods_sale_details)
    {
        $update_data = [
            'closing_balance' => $closing_balance,
            'closing_balance_date_time' => date('Y-m-d H:i:s'),
            'register_status' => 2,
            'payment_methods_sale' => json_encode($payment_methods_sale_details)
        ];

        $this->db->where('id', $register_id);
        return $this->db->update($this->table, $update_data);
    }
}
