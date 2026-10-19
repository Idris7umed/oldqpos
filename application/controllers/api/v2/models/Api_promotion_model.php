<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_promotion_model extends CI_Model
{
    private $table = 'tbl_promotions';

    public function get_all($company_id, $outlet_id = null)
    {
        $this->db->select('p.*, fm1.name as food_menu_name, fm2.name as get_food_menu_name, o.outlet_name');
        $this->db->from($this->table . ' p');
        $this->db->join('tbl_food_menus fm1', 'fm1.id = p.food_menu_id', 'left');
        $this->db->join('tbl_food_menus fm2', 'fm2.id = p.get_food_menu_id', 'left');
        $this->db->join('tbl_outlets o', 'o.id = p.outlet_id', 'left');
        $this->db->where('p.company_id', $company_id);
        if ($outlet_id) {
            $this->db->where('p.outlet_id', $outlet_id);
        }
        $this->db->where('p.del_status', 'Live');
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

    public function check_promotion_conflict($start_date, $end_date, $food_menu_id, $company_id, $exclude_id = null)
    {
        $this->db->select('id');
        $this->db->from($this->table);
        $this->db->where('food_menu_id', $food_menu_id);
        $this->db->where('company_id', $company_id);
        $this->db->where('del_status', 'Live');

        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }

        $this->db->group_start();
        $this->db->where("('$start_date' BETWEEN start_date AND end_date)");
        $this->db->or_where("('$end_date' BETWEEN start_date AND end_date)");
        $this->db->or_where("(start_date BETWEEN '$start_date' AND '$end_date')");
        $this->db->or_where("(end_date BETWEEN '$start_date' AND '$end_date')");
        $this->db->group_end();

        $query = $this->db->get();

        return $query->num_rows() > 0;
    }
}
