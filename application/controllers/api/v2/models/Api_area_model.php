<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_area_model extends CI_Model
{
    private $table = 'tbl_areas';

   public function get_all($company_id)
{
    
    $this->db->select('a.id, a.area_name, a.outlet_id, a.description, a.table_design_content, o.outlet_name');
    
    $this->db->from($this->table . ' a');
    $this->db->join('tbl_outlets o', 'o.id = a.outlet_id');
    $this->db->where('a.company_id', $company_id);
    $this->db->where('a.del_status', 'Live');
    return $this->db->get()->result();
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