
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_supplier_model extends CI_Model
{
    private $table = 'tbl_suppliers';

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
}