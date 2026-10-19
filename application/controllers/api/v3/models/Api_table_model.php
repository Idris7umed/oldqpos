<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_table_model extends CI_Model
{
    private $table = 'tbl_tables';

    public function get_all($company_id, $area_id = null)
    {
        
        $this->db->select('t.id, t.name, t.sit_capacity, t.position, t.description, t.area as area_id, o.outlet_name, a.area_name');
        $this->db->from($this->table . ' t');
        $this->db->join('tbl_outlets o', 'o.id = t.outlet_id');
        $this->db->join('tbl_areas a', 'a.id = t.area');
        $this->db->where('t.company_id', $company_id);
        $this->db->where('t.del_status', 'Live');
        if ($area_id) {
            $this->db->where('t.area', $area_id);
        }
        $tables = $this->db->get()->result();

        
        foreach ($tables as $table) {
            if (!empty($table->position)) {
                $table->position = json_decode($table->position);
            }
        }

        return $tables;
    }

    public function get_by_id($id, $company_id)
    {
        $table = $this->db->get_where($this->table, ['id' => $id, 'company_id' => $company_id, 'del_status' => 'Live'])->row();

        
        if ($table && !empty($table->position)) {
            $table->position = json_decode($table->position);
        }

        return $table;
    }

    public function create($data)
    {
        
        $area = $this->db->get_where('tbl_areas', ['id' => $data['area']])->row();
        if ($area) {
            $data['outlet_id'] = $area->outlet_id;
        } else {
            return false;  
        }
        
        
        if (isset($data['position']) && (is_array($data['position']) || is_object($data['position']))) {
            $data['position'] = json_encode($data['position']);
        }

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data, $company_id)
    {
        
        if (isset($data['area'])) {
            $area = $this->db->get_where('tbl_areas', ['id' => $data['area']])->row();
            if ($area) {
                $data['outlet_id'] = $area->outlet_id;
            }
        }
        
        
        if (isset($data['position']) && (is_array($data['position']) || is_object($data['position']))) {
            $data['position'] = json_encode($data['position']);
        }

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