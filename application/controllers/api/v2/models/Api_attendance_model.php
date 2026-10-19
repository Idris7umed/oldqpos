<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_attendance_model extends CI_Model
{
    private $table = 'tbl_attendance';

    public function get_all($company_id, $start_date, $end_date, $employee_id = null)
    {
        $this->db->select('a.id, a.date, a.in_time, a.out_time, TIMEDIFF(a.out_time, a.in_time) as work_duration, a.employee_id, u.full_name as employee_name');
        $this->db->from($this->table . ' a');
        $this->db->join('tbl_users u', 'u.id = a.employee_id');
        $this->db->where('a.company_id', $company_id);
        $this->db->where('a.date >=', $start_date);
        $this->db->where('a.date <=', $end_date);
        if ($employee_id) {
            $this->db->where('a.employee_id', $employee_id);
        }
        $this->db->where('a.del_status', 'Live');
        $this->db->order_by('a.date', 'DESC');
        $this->db->order_by('a.in_time', 'DESC');
        return $this->db->get()->result();
    }

    public function get_open_attendance($employee_id)
    {
        return $this
            ->db
            ->where('employee_id', $employee_id)
            ->where('out_time IS NULL', null, false)
            ->where('date', date('Y-m-d'))
            ->where('del_status', 'Live')
            ->get($this->table)
            ->row();
    }

    public function check_in($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function check_out($attendance_id, $data)
    {
        $this->db->where('id', $attendance_id);
        return $this->db->update($this->table, $data);
    }

    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $company_id, $data)
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

    public function generate_ref_no()
    {
        $count = $this->db->query('SELECT count(id) as total_count FROM ' . $this->table)->row('total_count');
        return str_pad($count + 1, 6, '0', STR_PAD_LEFT);
    }
}
