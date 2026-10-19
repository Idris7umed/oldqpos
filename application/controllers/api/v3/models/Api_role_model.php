<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_role_model extends CI_Model
{
    private $table = 'tbl_roles';
    private $table_access = 'tbl_role_access';

    public function get_all($company_id)
    {
        return $this->db->get_where($this->table, ['company_id' => $company_id, 'del_status' => 'Live'])->result();
    }

    public function get_by_id($id, $company_id)
    {
        $role = $this->db->get_where($this->table, ['id' => $id, 'company_id' => $company_id, 'del_status' => 'Live'])->row();

        if ($role) {
            
            $role->permissions = $this->db
                ->select('access_parent_id, access_child_id')
                ->from($this->table_access)
                ->where('role_id', $id)
                ->get()
                ->result();
        }
        return $role;
    }

    public function create($data)
    {
        $this->db->trans_start();

        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']);
        
        $this->db->insert($this->table, $data);
        $role_id = $this->db->insert_id();

        $this->_sync_permissions($role_id, $permissions);

        $this->db->trans_complete();
        return ($this->db->trans_status()) ? $role_id : false;
    }

    public function update($id, $data, $company_id)
    {
        $existing_role = $this->db->get_where($this->table, ['id' => $id, 'company_id' => $company_id])->row();
        if (!$existing_role) {
            return false;
        }

        $this->db->trans_start();

        $permissions = $data['permissions'] ?? null;
        unset($data['permissions']);

        if (!empty($data)) {
            $this->db->where('id', $id)->update($this->table, $data);
        }
        
        if ($permissions !== null) {
            $this->_sync_permissions($id, $permissions);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function delete($id, $company_id)
    {
        $existing_role = $this->db->get_where($this->table, ['id' => $id, 'company_id' => $company_id])->row();
        if (!$existing_role) {
            return false;
        }

        $this->db->trans_start();
        $this->db->where('id', $id)->update($this->table, ['del_status' => 'Deleted']);
        $this->db->where('role_id', $id)->delete($this->table_access);
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    private function _sync_permissions($role_id, $permissions)
    {
        $this->db->where('role_id', $role_id)->delete($this->table_access);

        foreach ($permissions as $permission) {
            if (isset($permission['access_parent_id']) && isset($permission['access_child_id'])) {
                $perm_data = [
                    'role_id' => $role_id,
                    'access_parent_id' => $permission['access_parent_id'],
                    'access_child_id' => $permission['access_child_id'],
                ];
                $this->db->insert($this->table_access, $perm_data);
            }
        }
    }
    
    
    public function get_all_permissions()
    {
        return $this->db->select('id as child_id, parent_id, module_name, function_name, label_name')->where('del_status', 'Live')->get('tbl_access')->result();
    }
}