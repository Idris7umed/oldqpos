<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_payment_method_model extends CI_Model
{
    private $table = 'tbl_payment_methods';

    public function get_all($company_id)
    {
        $this->db->where('company_id', $company_id);
        $this->db->where('del_status', 'Live');
        $this->db->order_by('name', 'ASC');
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id, $company_id)
    {
        return $this->db->get_where($this->table, ['id' => $id, 'company_id' => $company_id, 'del_status' => 'Live'])->row();
    }

    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data, $company_id)
    {
        
        if ($id == 1 || $id == 5) { 
            
        }
        $this->db->where('id', $id);
        $this->db->where('company_id', $company_id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id, $company_id)
    {
        
        if ($id == 1 || $id == 5) { 
            return false;
        }
        $this->db->where('id', $id);
        $this->db->where('company_id', $company_id);
        return $this->db->update($this->table, ['del_status' => 'Deleted']);
    }
}