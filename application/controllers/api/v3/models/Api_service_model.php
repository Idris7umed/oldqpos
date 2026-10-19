<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_service_model extends CI_Model {

    
    public function get_pricing_plans($id = 0) {
        if ($id > 0) {
            return $this->db->get_where('tbl_pricing_plans', ['id' => $id, 'del_status' => 'Live'])->row();
        }
        return $this->db->get_where('tbl_pricing_plans', ['del_status' => 'Live'])->result();
    }
    public function create_pricing_plan($data) {
        $this->db->insert('tbl_pricing_plans', $data);
        return $this->db->insert_id();
    }
    public function update_pricing_plan($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tbl_pricing_plans', $data);
    }
    public function delete_pricing_plan($id) {
        $this->db->where('id', $id);
        return $this->db->update('tbl_pricing_plans', ['del_status' => 'Deleted']);
    }

    
    public function get_companies($id = 0) {
        $this->db->select('c.*, p.plan_name, 
            (SELECT COUNT(id) FROM tbl_outlets WHERE company_id = c.id AND del_status = "Live") as outlet_count,
            (SELECT MAX(payment_date) FROM tbl_payment_histories WHERE company_id = c.id AND del_status = "Live") as last_payment_date
        ');
        $this->db->from('tbl_companies c');
        $this->db->join('tbl_pricing_plans p', 'p.id = c.plan_id', 'left');
        $this->db->where('c.del_status', 'Live');
        if ($id > 0) {
            $this->db->where('c.id', $id);
            return $this->db->get()->row();
        }
        return $this->db->get()->result();
    }
    public function get_admin_for_company($company_id) {
        return $this->db->where('company_id', $company_id)->where('role', 'Admin')->get('tbl_users')->row();
    }
    public function create_company_with_admin($company_data, $admin_data) {
        $this->db->trans_start();
        $this->db->insert('tbl_companies', $company_data);
        $company_id = $this->db->insert_id();
        $admin_data['company_id'] = $company_id;
        $admin_data['password'] = password_hash($admin_data['password'], PASSWORD_BCRYPT);
        $this->db->insert('tbl_users', $admin_data);
        $this->db->trans_complete();
        return ($this->db->trans_status()) ? $company_id : false;
    }
    public function update_company_with_admin($company_id, $admin_id, $company_data, $admin_data) {
        $this->db->trans_start();
        $this->db->where('id', $company_id)->update('tbl_companies', $company_data);
        if (isset($admin_data['password']) && !empty($admin_data['password'])) {
            $admin_data['password'] = password_hash($admin_data['password'], PASSWORD_BCRYPT);
        } else {
            unset($admin_data['password']);
        }
        $this->db->where('id', $admin_id)->update('tbl_users', $admin_data);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    public function delete_company($id) {
        if ($id == 1) return false;
        $this->db->where('id', $id);
        return $this->db->update('tbl_companies', ['del_status' => 'Deleted']);
    }
    public function update_company($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tbl_companies', $data);
    }
    public function get_company_outlets($company_id) {
        return $this->db->get_where('tbl_outlets', ['company_id' => $company_id, 'del_status' => 'Live'])->result();
    }

    
    public function get_payment_history($company_id = null) {
        $this->db->select('ph.*, c.business_name');
        $this->db->from('tbl_payment_histories ph');
        $this->db->join('tbl_companies c', 'c.id = ph.company_id');
        if ($company_id) {
            $this->db->where('ph.company_id', $company_id);
        }
        $this->db->where('ph.del_status', 'Live');
        return $this->db->get()->result();
    }
    public function add_payment($data) {
        $this->db->insert('tbl_payment_histories', $data);
        return $this->db->insert_id();
    }
    public function delete_payment($id) {
        $this->db->where('id', $id);
        return $this->db->update('tbl_payment_histories', ['del_status' => 'Deleted']);
    }

    
    public function get_main_company_settings() {
        return $this->db->where('id', 1)->get('tbl_companies')->row();
    }
}