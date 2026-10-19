<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_denomination_model extends CI_Model
{
    private $table = 'tbl_denominations';

    public function get_all($company_id)
    {
        $this->db->order_by('amount', 'DESC');
        return $this->db->get_where($this->table, ['company_id' => $company_id, 'del_status' => 'Live'])->result();
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
}