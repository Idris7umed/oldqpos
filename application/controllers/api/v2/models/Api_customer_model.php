<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_customer_model extends CI_Model
{
    private $table = 'tbl_customers';

    public function get_all($company_id)
    {
        return $this->db->get_where($this->table, ['del_status' => 'Live', 'company_id' => $company_id])->result();
    }

    public function get_by_id($id, $company_id)
    {
        return $this->db->get_where($this->table, ['id' => $id, 'del_status' => 'Live', 'company_id' => $company_id])->row();
    }

    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data, $company_id)
    {
        $this->db->where('id', $id);
        $this->db->where('company_id', $company_id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id, $company_id)
    {
        $this->db->where('id', $id);
        $this->db->where('company_id', $company_id);
        return $this->db->update($this->table, ['del_status' => 'Deleted']);
    }
      public function get_customer_due($customer_id, $company_id) {
        
        $this->db->where('id', $customer_id);
        $this->db->where('company_id', $company_id);
        $this->db->where('del_status', 'Live');
        $customer_exists = $this->db->from('tbl_customers')->count_all_results();
        
        if ($customer_exists == 0) {
            log_message('error', "get_customer_due: Customer with ID {$customer_id} not found for Company ID {$company_id}.");
            return null; 
        }

        
        $this->db->select_sum('total_payable');
        $this->db->from('tbl_sales');
        $this->db->where('customer_id', $customer_id);
        $this->db->where('company_id', $company_id); 
        $this->db->where('del_status', 'Live');
        $sales_total = (float)$this->db->get()->row('total_payable');

        
        $this->db->select_sum('amount');
        $this->db->from('tbl_customer_due_receives');
        $this->db->where('customer_id', $customer_id);
        $this->db->where('company_id', $company_id); 
        $this->db->where('del_status', 'Live');
        $paid_total = (float)$this->db->get()->row('amount');

        $due = $sales_total - $paid_total;

        log_message('debug', "get_customer_due for C_ID {$customer_id} / CO_ID {$company_id}: Sales={$sales_total}, Paid={$paid_total}, Due={$due}");

        return $due;
    }
}