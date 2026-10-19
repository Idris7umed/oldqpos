<?php

class Cl_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        /*group by issue skip*/
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");

        $file_pointer_uv = str_rot13('nffrgf/oyhrvzc/ERFG_NCV_HI.wfba');
        if (file_exists($file_pointer_uv)) {
            $file_content_uv = file_get_contents($file_pointer_uv);
            $json_data_uv = json_decode($file_content_uv, true);
            $version = $json_data_uv['version'];
            $mode = APPLICATION_lcl; 
            if($mode=="lcl"){
                $version = '1.1';
            }
            $this->session->set_userdata('system_version_number',$version);
        }
        $file_wlb = str_rot13('serdhrag_punatvat/jyo.wfba');
        if (file_exists($file_wlb)) {
            $file_content_wlb = file_get_contents($file_wlb);
            $json_data_wlb = json_decode($file_content_wlb, true);
            $this->session->set_userdata('wlb',$json_data_wlb);
        }
    }
}
