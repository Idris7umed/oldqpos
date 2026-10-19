<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_counter_model extends CI_Model
{
    private $table = 'tbl_counters';

    public function get_all($company_id)
{
    $this->db->select('c.id, c.name, c.description, c.outlet_id, c.invoice_printer_id, c.bill_printer_id, o.outlet_name, ip.title as invoice_printer, bp.title as bill_printer');
    $this->db->from($this->table . ' c');
    $this->db->join('tbl_outlets o', 'o.id = c.outlet_id', 'left');
    $this->db->join('tbl_printers ip', 'ip.id = c.invoice_printer_id', 'left');
    $this->db->join('tbl_printers bp', 'bp.id = c.bill_printer_id', 'left');
    $this->db->where('c.company_id', $company_id);
    $this->db->where('c.del_status', 'Live');
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