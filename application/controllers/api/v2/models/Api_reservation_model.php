<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_reservation_model extends CI_Model
{
    private $table = 'tbl_reservations';

    public function get_all($company_id, $outlet_id = null, $date = null)
    {
$this->db->select('r.id, r.name, r.phone, r.email, r.number_of_guest, r.reservation_date, r.reservation_time, r.status, r.notes, r.outlet_id, o.outlet_name');
        $this->db->from($this->table . ' r');
        $this->db->join('tbl_outlets o', 'o.id = r.outlet_id');
        $this->db->where('r.company_id', $company_id);
        $this->db->where('r.del_status', 'Live');

        if ($outlet_id) {
            $this->db->where('r.outlet_id', $outlet_id);
        }
        if ($date) {
            $this->db->where('r.reservation_date', $date);
        }
        
        $this->db->order_by('r.reservation_date', 'DESC');
        $this->db->order_by('r.reservation_time', 'ASC');
        
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