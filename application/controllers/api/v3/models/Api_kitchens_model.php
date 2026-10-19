<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_kitchens_model extends CI_Model
{
    private $table = 'tbl_kitchens';
    private $table_categories = 'tbl_kitchen_categories';

    public function get_all($company_id)
    {
        $this->db->select('k.*, o.outlet_name, p.title as printer_name');
        $this->db->from($this->table . ' k');
        $this->db->join('tbl_outlets o', 'o.id = k.outlet_id', 'left');
        $this->db->join('tbl_printers p', 'p.id = k.printer_id', 'left');
        $this->db->where('k.company_id', $company_id);
        $this->db->where('k.del_status', 'Live');
        $kitchens = $this->db->get()->result();
        foreach ($kitchens as $kitchen) {
            $kitchen->categories = $this
                ->db
                ->select('kc.cat_id, fmc.category_name')
                ->from($this->table_categories . ' kc')
                ->join('tbl_food_menu_categories fmc', 'fmc.id = kc.cat_id', 'left')
                ->where('kc.kitchen_id', $kitchen->id)
                ->where('kc.del_status', 'Live')
                ->get()
                ->result();
        }
        return $kitchens;
    }

    public function get_by_id($id, $company_id)
    {
        $this->db->select('k.*, o.outlet_name, p.title as printer_name');
        $this->db->from($this->table . ' k');
        $this->db->join('tbl_outlets o', 'o.id = k.outlet_id', 'left');
        $this->db->join('tbl_printers p', 'p.id = k.printer_id', 'left');
        $this->db->where('k.id', $id);
        $this->db->where('k.company_id', $company_id);
        $this->db->where('k.del_status', 'Live');
        $kitchen = $this->db->get()->row();
        if ($kitchen) {
            $kitchen->categories = $this
                ->db
                ->select('kc.cat_id, fmc.category_name')
                ->from($this->table_categories . ' kc')
                ->join('tbl_food_menu_categories fmc', 'fmc.id = kc.cat_id', 'left')
                ->where('kc.kitchen_id', $kitchen->id)
                ->where('kc.del_status', 'Live')
                ->get()
                ->result();
        }
        return $kitchen;
    }

    public function get_available_categories($company_id, $outlet_id)
    {
        $this->db->select('id, category_name');
        $this->db->from('tbl_food_menu_categories');
        $this->db->where('company_id', $company_id);
        $this->db->where('del_status', 'Live');
        $this->db->order_by('category_name', 'ASC');
        return $this->db->get()->result();
    }

    public function create($data, $categories)
    {
        $this->db->trans_start();
        $this->db->insert($this->table, $data);
        $kitchen_id = $this->db->insert_id();
        if (!empty($categories)) {
            $cat_data = [];
            foreach ($categories as $cat_id) {
                $cat_data[] = [
                    'kitchen_id' => $kitchen_id,
                    'cat_id' => $cat_id,
                    'outlet_id' => $data['outlet_id'],
                ];
            }
            $this->db->insert_batch($this->table_categories, $cat_data);
        }
        $this->db->trans_complete();
        return ($this->db->trans_status() === FALSE) ? false : $kitchen_id;
    }

    public function update($id, $data, $categories, $company_id)
    {
        $this->db->trans_start();
        $this->db->where('id', $id)->where('company_id', $company_id)->update($this->table, $data);
        $this->db->where('kitchen_id', $id)->delete($this->table_categories);
        if (!empty($categories)) {
            $cat_data = [];
            foreach ($categories as $cat_id) {
                $cat_data[] = [
                    'kitchen_id' => $id,
                    'cat_id' => $cat_id,
                    'outlet_id' => $data['outlet_id'],
                ];
            }
            $this->db->insert_batch($this->table_categories, $cat_data);
        }
        $this->db->trans_complete();
        return ($this->db->trans_status() !== FALSE);
    }

    public function delete($id, $company_id)
    {
        $this->db->trans_start();
        $this->db->where('id', $id)->where('company_id', $company_id)->update($this->table, ['del_status' => 'Deleted']);
        $this->db->where('kitchen_id', $id)->update($this->table_categories, ['del_status' => 'Deleted']);
        $this->db->trans_complete();
        return ($this->db->trans_status() !== FALSE);
    }
}
