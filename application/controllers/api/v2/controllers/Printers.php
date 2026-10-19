<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Printers extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_printer_model', 'printer_model');
        $this->load->library('form_validation');
    }

    public function index_get($id = 0)
    {
        $company_id = $this->auth_data->company_id;
        if ($id > 0) {
            $data = $this->printer_model->get_by_id($id, $company_id);
            if ($data) {
                json_response(REST_Controller::HTTP_OK, 'success', 'Printer found.', $data, $this);
            } else {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Printer not found.', null, $this);
            }
        } else {
            $data = $this->printer_model->get_all($company_id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Printers list.', $data, $this);
        }
    }

    public function index_post()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('title', 'Title', 'required|max_length[250]');
        $this->form_validation->set_rules('outlet_id', 'Outlet', 'required|numeric');
        $this->form_validation->set_rules('printing_choice', 'Printing Choice', 'required|in_list[web_browser_popup,direct_print]');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $printer_data = [
            'title' => $request_data['title'],
            'outlet_id' => $request_data['outlet_id'],
            'printing_choice' => $request_data['printing_choice'],
            'type' => $request_data['type'] ?? null,
            'path' => $request_data['path'] ?? null,
            'characters_per_line' => $request_data['characters_per_line'] ?? null,
            'printer_ip_address' => $request_data['printer_ip_address'] ?? null,
            'printer_port' => $request_data['printer_port'] ?? null,
            'ipvfour_address' => $request_data['ipvfour_address'] ?? null,
            'print_format' => $request_data['print_format'] ?? '80mm',
            'company_id' => $this->auth_data->company_id,
        ];
        $new_id = $this->printer_model->create($printer_data);
        if ($new_id) {
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Printer created successfully.', ['id' => $new_id], $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create printer.', null, $this);
        }
    }

    public function index_put($id)
    {
        $request_data = json_decode(file_get_contents('php://input'), true);
        unset($request_data['id'], $request_data['company_id'], $request_data['outlet_name']);
        if (empty($request_data)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Request body is empty.', null, $this);
        }
        $company_id = $this->auth_data->company_id;
        if ($this->printer_model->update($id, $request_data, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Printer updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update printer.', null, $this);
        }
    }

    public function index_delete($id)
    {
        $company_id = $this->auth_data->company_id;
        if ($this->printer_model->delete($id, $company_id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Printer deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete printer.', null, $this);
        }
    }
}