<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_user_model extends CI_Model
{
    private $table = 'tbl_users';

    public function get_all($company_id)
    {
        
        $this->db->select('u.id, u.full_name, u.phone, u.email_address, u.designation, u.role_id, u.outlets, u.will_login, u.active_status, u.kitchens, u.login_pin, u.order_receiving_id, r.role_name');
        $this->db->from($this->table . ' u');
        $this->db->join('tbl_roles r', 'r.id = u.role_id', 'left');
        $this->db->where('u.company_id', $company_id);
        $this->db->where('u.del_status', 'Live');
        return $this->db->get()->result();
    }

    public function get_by_id($id, $company_id)
    {
        
        $this->db->select('u.id, u.full_name, u.phone, u.email_address, u.designation, u.role_id, u.outlets, u.will_login, u.active_status, u.kitchens, u.login_pin, u.order_receiving_id, r.role_name');
        $this->db->from($this->table . ' u');
        $this->db->join('tbl_roles r', 'r.id = u.role_id', 'left');
        $this->db->where('u.id', $id);
        $this->db->where('u.company_id', $company_id);
        $this->db->where('u.del_status', 'Live');
        return $this->db->get()->row();
    }

    public function create($data)
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            
            unset($data['password']);
        }
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data, $company_id)
    {
        if (isset($data['password'])) {
            if (!empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            } else {
                unset($data['password']);
            }
        }
        $this->db->where('id', $id);
        $this->db->where('company_id', $company_id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id, $company_id)
    {
        if ($id == 1) { 
            return false;
        }
        $this->db->where('id', $id);
        $this->db->where('company_id', $company_id);
        return $this->db->update($this->table, ['del_status' => 'Deleted']);
    }

    public function is_email_unique($email, $user_id = 0)
    {
        $this->db->where('email_address', $email);
        if ($user_id > 0) {
            $this->db->where('id !=', $user_id);
        }
        return $this->db->get($this->table)->num_rows() == 0;
    }
}