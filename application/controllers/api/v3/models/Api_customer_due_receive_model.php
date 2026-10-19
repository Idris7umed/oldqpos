<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_customer_due_receive_model extends CI_Model
{
    private $table = 'tbl_customer_due_receives';

    public function get_all($outlet_id, $customer_id = null)
    {
        $this->db->select('cdr.id, cdr.reference_no, cdr.only_date as date, cdr.amount, c.name as customer_name, u.full_name as received_by, pm.name as payment_method_name');
        $this->db->from($this->table . ' cdr');
        $this->db->join('tbl_customers c', 'c.id = cdr.customer_id', 'left');
        $this->db->join('tbl_users u', 'u.id = cdr.user_id', 'left');
        $this->db->join('tbl_payment_methods pm', 'pm.id = cdr.payment_id', 'left');
        
        $this->db->where('cdr.outlet_id', $outlet_id);
        $this->db->where('cdr.del_status', 'Live'); 
        
        if ($customer_id) {
            $this->db->where('cdr.customer_id', $customer_id);
        }
        
        $this->db->order_by('cdr.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id, $outlet_id)
    {
        $this->db->select('cdr.id, cdr.reference_no, cdr.only_date as date, cdr.amount, cdr.customer_id, cdr.payment_id, cdr.note, c.name as customer_name, u.full_name as received_by, pm.name as payment_method_name');
        $this->db->from($this->table . ' cdr');
        $this->db->join('tbl_customers c', 'c.id = cdr.customer_id', 'left');
        $this->db->join('tbl_users u', 'u.id = cdr.user_id', 'left');
        $this->db->join('tbl_payment_methods pm', 'pm.id = cdr.payment_id', 'left');
        
        $this->db->where('cdr.id', $id);
        $this->db->where('cdr.outlet_id', $outlet_id);
        $this->db->where('cdr.del_status', 'Live'); 
        
        return $this->db->get()->row();
    }

    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $outlet_id, $data)
    {
        $this->db->where('id', $id);
        $this->db->where('outlet_id', $outlet_id);
        $this->db->where('del_status', 'Live'); 
        return $this->db->update($this->table, $data);
    }

public function delete($id, $outlet_id)
{
    $this->db->where('id', $id);
    $this->db->where('outlet_id', $outlet_id);
    $this->db->where('del_status', 'Live');
    $result = $this->db->update($this->table, ['del_status' => 'Deleted']);

    
    log_message('error', 'Last Query Executed for Delete: ' . $this->db->last_query());
    log_message('error', 'Affected Rows: ' . $this->db->affected_rows());

    return $result;
}

    public function generate_ref_no($outlet_id)
    {
        
        $this->load->model('Customer_due_receive_model');
        return $this->Customer_due_receive_model->generateReferenceNo($outlet_id);
    }
}