<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!function_exists('json_response')) {
    function json_response($status_code, $status, $message, $data = null, &$controller)
    {
        $response = [
            'status' => $status,
            'message' => $message,
        ];
        if ($data !== null) {
            $response['data'] = $data;
        }
        $controller->response($response, $status_code);
    }
}

if (!function_exists('get_outlet_waiter')) {
    function get_outlet_waiter($outlet_id)
    {
        $ci = &get_instance();
        $outlet = $ci->db->select('default_waiter')->from('tbl_outlets')->where('id', $outlet_id)->get()->row();

        if ($outlet && $outlet->default_waiter) {
            return $outlet->default_waiter;
        }

        return 1;
    }
}

if (!function_exists('getOnlineOrderReceivingId')) {
    function getOnlineOrderReceivingId($outlet_id)
    {
        $ci = &get_instance();
        $outlet = $ci->db->select('default_waiter')->from('tbl_outlets')->where('id', $outlet_id)->get()->row();

        if ($outlet && $outlet->default_waiter) {
            return $outlet->default_waiter;
        }

        return 1;
    }
}
