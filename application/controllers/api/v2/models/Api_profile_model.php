
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_profile_model extends CI_Model
{
    private $table = 'tbl_users';

    public function get_profile($user_id)
    {
        $this->db->select('id, full_name, phone, email_address, designation, question');
        return $this->db->get_where($this->table, ['id' => $user_id])->row();
    }

    public function update_profile($user_id, $data)
    {
        $this->db->where('id', $user_id);
        return $this->db->update($this->table, $data);
    }
    
    public function get_user_by_id($user_id)
    {
        return $this->db->get_where($this->table, ['id' => $user_id])->row();
    }
}