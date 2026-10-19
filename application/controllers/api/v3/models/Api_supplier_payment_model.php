<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_supplier_payment_model extends CI_Model
{
    private $table = 'tbl_supplier_payments';

    public function get_all($outlet_id, $supplier_id = null)
    {
        $this->db->select('sp.id, sp.date, sp.amount, s.name as supplier_name, u.full_name as paid_by, pm.name as payment_method_name');
        $this->db->from($this->table . ' sp');
        $this->db->join('tbl_suppliers s', 's.id = sp.supplier_id', 'left');
        $this->db->join('tbl_users u', 'u.id = sp.user_id', 'left');
        $this->db->join('tbl_payment_methods pm', 'pm.id = sp.payment_id', 'left');
        
        $this->db->where('sp.outlet_id', $outlet_id);
        $this->db->where('sp.del_status', 'Live'); 
        
        if ($supplier_id) {
            $this->db->where('sp.supplier_id', $supplier_id);
        }
        
        $this->db->order_by('sp.id', 'DESC');
        return $this->db->get()->result();
    }

   public function get_by_id($id, $outlet_id)
{
    $this->db->select('sp.id, sp.date, sp.amount, sp.supplier_id, sp.payment_id, sp.note, s.name as supplier_name, u.full_name as paid_by, pm.name as payment_method_name');
    $this->db->from($this->table . ' sp');
    $this->db->join('tbl_suppliers s', 's.id = sp.supplier_id', 'left');
    $this->db->join('tbl_users u', 'u.id = sp.user_id', 'left');
    $this->db->join('tbl_payment_methods pm', 'pm.id = sp.payment_id', 'left');
    $this->db->where('sp.id', $id);
    $this->db->where('sp.outlet_id', $outlet_id);
    $this->db->where('sp.del_status', 'Live');
    
    $result = $this->db->get()->row();

    if ($result) {
        
        $result->id = (int)$result->id;
        $result->amount = (float)$result->amount;
        $result->supplier_id = (int)$result->supplier_id;
        $result->payment_id = (int)$result->payment_id;
    }

    return $result;
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
        return $this->db->update($this->table, ['del_status' => 'Deleted']);
    }
    public function getSupplierDue($supplier_id) {
    $outlet_id = $this->session->userdata('outlet_id');

    
    $this->db->select_sum('due');
    $this->db->from('tbl_purchase');
    $this->db->where('supplier_id', $supplier_id);
    $this->db->where('del_status', 'Live');

    
    if ($outlet_id) {
        $this->db->where('outlet_id', $outlet_id);
    }
    $total_due = (float)$this->db->get()->row('due');

    $this->db->select_sum('amount');
    $this->db->from('tbl_supplier_payments');
    $this->db->where('supplier_id', $supplier_id);
    $this->db->where('del_status', 'Live');
    
    if ($outlet_id) {
        $this->db->where('outlet_id', $outlet_id);
    }
    $total_paid = (float)$this->db->get()->row('amount');
    
    return $total_due - $total_paid;
    
}
}