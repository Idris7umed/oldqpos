<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_auth_model extends CI_Model
{
    public function get_user_by_email($email)
    {
        $this->db->where('email_address', $email);
        $this->db->where('del_status', 'Live');
        $this->db->where('active_status', 'Active');
        $query = $this->db->get('tbl_users');
        return $query->row();
    }

    
    public function get_user_by_pin($pin)
    {
        $this->db->where('login_pin', $pin);
        $this->db->where('del_status', 'Live');
        $this->db->where('active_status', 'Active');
        $query = $this->db->get('tbl_users');
        return $query->row();
    }
}