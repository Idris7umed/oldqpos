<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_expense_model extends CI_Model
{
    private $table = 'tbl_expenses';

    public function get_all($outlet_id, $start_date = null, $end_date = null)
    {
        $this->db->select('e.id, e.date, e.amount, ei.name as category_name, u.full_name as responsible_person, e.note, pm.name as payment_method_name');
        $this->db->from($this->table . ' e');
        $this->db->join('tbl_expense_items ei', 'ei.id = e.category_id', 'left');
        $this->db->join('tbl_users u', 'u.id = e.employee_id', 'left');
        $this->db->join('tbl_payment_methods pm', 'pm.id = e.payment_id', 'left');
        $this->db->where('e.outlet_id', $outlet_id);
        $this->db->where('e.del_status', 'Live');

        if ($start_date) {
            $this->db->where('e.date >=', $start_date);
        }
        if ($end_date) {
            $this->db->where('e.date <=', $end_date);
        }
        
        $this->db->order_by('e.date', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id, $outlet_id)
    {
        return $this->db->get_where($this->table, ['id' => $id, 'outlet_id' => $outlet_id, 'del_status' => 'Live'])->row();
    }

    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data, $outlet_id)
    {
        $this->db->where('id', $id);
        $this->db->where('outlet_id', $outlet_id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id, $outlet_id)
    {
        $this->db->where('id', $id);
        $this->db->where('outlet_id', $outlet_id);
        return $this->db->update($this->table, ['del_status' => 'Deleted']);
    }
}