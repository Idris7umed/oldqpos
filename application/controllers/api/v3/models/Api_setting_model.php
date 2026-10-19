<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_setting_model extends CI_Model
{
    private $table = 'tbl_companies';

    public function get_tax_settings($company_id)
    {
        $this->db->select('collect_tax, tax_title, tax_registration_no, tax_is_gst, tax_setting, state_code');
        $this->db->where('id', $company_id);
        $result = $this->db->get($this->table)->row();
        if ($result && $result->tax_setting) {
            $result->tax_setting = json_decode($result->tax_setting);
        }
        return $result;
    }

    public function update_tax_settings($company_id, $data)
    {
        if (isset($data['tax_setting']) && is_array($data['tax_setting'])) {
            $data['tax_setting'] = json_encode($data['tax_setting']);
        }
        $this->db->where('id', $company_id);
        return $this->db->update($this->table, $data);
    }

    
    public function get_currency_settings($company_id)
    {
        $this->db->select('currency, currency_position, `precision`');
        $this->db->where('id', $company_id);
        return $this->db->get($this->table)->row();
    }
    
}