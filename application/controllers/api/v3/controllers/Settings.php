<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Settings extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_setting_model', 'setting_model');
        $this->load->library('form_validation');
    }

    
    public function tax_get()
    {
        $company_id = $this->auth_data->company_id;
        $data = $this->setting_model->get_tax_settings($company_id);
        
        if ($data) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Tax settings retrieved.', $data, $this);
        } else {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Settings not found.', null, $this);
        }
    }

    public function tax_put()
    {
        $request_data = json_decode(file_get_contents('php://input'), true);

        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('collect_tax', 'Collect Tax', 'in_list[Yes,No]');
        
        if (isset($request_data['collect_tax']) && $request_data['collect_tax'] == 'Yes') {
            $this->form_validation->set_rules('tax_title', 'Tax Title', 'required');
            $this->form_validation->set_rules('tax_setting', 'Tax Fields', 'required|is_array');
            $this->form_validation->set_rules('tax_setting[*][tax]', 'Tax Name', 'required');
            $this->form_validation->set_rules('tax_setting[*][tax_rate]', 'Tax Rate', 'required|numeric');
        }

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }

        $company_id = $this->auth_data->company_id;
        if ($this->setting_model->update_tax_settings($company_id, $request_data)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Tax settings updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update tax settings.', null, $this);
        }
    }
      public function currency_get()
    {
        $company_id = $this->auth_data->company_id;
        $data = $this->setting_model->get_currency_settings($company_id);
        if ($data) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Currency settings retrieved.', $data, $this);
        } else {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Currency settings not found.', null, $this);
        }
    }
}