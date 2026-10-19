<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v2/core/API_Controller.php';

class Service extends API_Controller
{
     public function __construct()
    {
        parent::__construct();
        $this->load->model('api_service_model', 'service_model');
        $this->load->library('form_validation');
        if ($this->auth_data->company_id != 1) {
            json_response(REST_Controller::HTTP_FORBIDDEN, 'error', 'You do not have permission to access this resource.', null, $this);
        }
    }


    public function pricing_plans_post()
    {
        $request_data = $this->get_json_request_data(true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('plan_name', 'Plan Name', 'required');
        $this->form_validation->set_rules('monthly_cost', 'Monthly Cost', 'required|numeric');
        $this->form_validation->set_rules('price_for_month2', 'Yearly Cost', 'required|numeric');
        $this->form_validation->set_rules('number_of_maximum_users', 'Max Users', 'required|numeric');
        $this->form_validation->set_rules('number_of_maximum_outlets', 'Max Outlets', 'required|numeric');
        $this->form_validation->set_rules('number_of_maximum_invoices', 'Max Invoices', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $data = [
            'plan_name' => $request_data['plan_name'],
            'monthly_cost' => $request_data['monthly_cost'],
            'price_for_month2' => $request_data['price_for_month2'],
            'number_of_maximum_users' => $request_data['number_of_maximum_users'],
            'number_of_maximum_outlets' => $request_data['number_of_maximum_outlets'],
            'number_of_maximum_invoices' => $request_data['number_of_maximum_invoices'],
            'free_trial_status' => $request_data['free_trial_status'] ?? 'No',
            'trail_days' => $request_data['trail_days'] ?? 0,
            'description' => $request_data['description'] ?? null,
            'is_recommended' => $request_data['is_recommended'] ?? 'No',
            'payment_type' => $request_data['payment_type'] ?? 'Both',
            'price_interval' => $request_data['price_interval'] ?? 'monthly',
        ];
        $new_id = $this->service_model->create_pricing_plan($data);
        if ($new_id) {
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Pricing plan created successfully.', ['id' => $new_id], $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create pricing plan.', null, $this);
        }
    }

    public function pricing_plans_put($id)
    {
        $request_data = $this->get_json_request_data(true);
        if ($this->service_model->update_pricing_plan($id, $request_data)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Pricing plan updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update pricing plan.', null, $this);
        }
    }

    public function pricing_plans_delete($id)
    {
        if ($this->service_model->delete_pricing_plan($id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Pricing plan deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete pricing plan.', null, $this);
        }
    }

    public function companies_get($id = 0)
    {
        $data = $this->service_model->get_companies($id);
        
        if ($id > 0) {
            if (!$data) {
                json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Company not found.', null, $this);
            }
            $data->admin_user = $this->service_model->get_admin_for_company($id);
            
            
            
            if (isset($data->outlet_count)) {
                $data->outlet_count = (int)$data->outlet_count;
            }
            
            
            $remaining_days = "N/A";
            if (!empty($data->last_payment_date) && is_numeric($data->access_day)) {
                $last_payment = new DateTime($data->last_payment_date);
                $today = new DateTime();
                $days_passed = $today->diff($last_payment)->days;
                $remaining = (int)$data->access_day - $days_passed;
                $remaining_days = ($remaining >= 0) ? "$remaining days" : "Expired";
            } else if (is_numeric($data->access_day)) {
                $remaining_days = $data->access_day . " days trial";
            }
            $data->remaining_access_days = $remaining_days;

        } else if (is_array($data)) {
            foreach ($data as $company) {
                $company->admin_user = $this->service_model->get_admin_for_company($company->id);

                
                
                if (isset($company->outlet_count)) {
                    $company->outlet_count = (int)$company->outlet_count;
                }
                

                $remaining_days = "N/A";
                if (!empty($company->last_payment_date) && is_numeric($company->access_day)) {
                    $last_payment = new DateTime($company->last_payment_date);
                    $today = new DateTime();
                    $days_passed = $today->diff($last_payment)->days;
                    $remaining = (int)$company->access_day - $days_passed;
                    $remaining_days = ($remaining >= 0) ? "$remaining days" : "Expired";
                } else if (is_numeric($company->access_day)) {
                     $remaining_days = $company->access_day . " days trial";
                }
                $company->remaining_access_days = $remaining_days;
            }
        }
        
        json_response(REST_Controller::HTTP_OK, 'success', 'Companies retrieved.', $data, $this);
    }

    public function companies_post()
    {
        $request_data = $this->post();
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('business_name', 'Business Name', 'required');
        $this->form_validation->set_rules('admin_name', 'Admin Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tbl_users.email_address]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('plan_id', 'Plan', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $plan = $this->service_model->get_pricing_plan($request_data['plan_id']);
        if (!$plan) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid Plan ID.', null, $this);
        }
        $main_company = $this->service_model->get_main_company_settings();
        $company_data = [
            'business_name' => $request_data['business_name'],
            'phone' => $request_data['phone'] ?? null,
            'address' => $request_data['address'] ?? null,
            'plan_id' => $request_data['plan_id'],
            'access_day' => $plan->trail_days,
            'payment_clear' => 'Yes',
            'del_status' => 'Live',
            'is_active' => $request_data['is_active'] ?? 'Yes',
            'date_format' => $request_data['date_format'] ?? 'd/m/Y',
            'zone_name' => $request_data['zone_name'] ?? $main_company->zone_name,
            'currency' => $request_data['currency'] ?? $main_company->currency,
            'pre_or_post_payment' => $main_company->pre_or_post_payment,
            'payment_settings' => $main_company->payment_settings
        ];
        $admin_data = [
            'full_name' => $request_data['admin_name'],
            'email_address' => $request_data['email'],
            'password' => $request_data['password'],
            'phone' => $request_data['phone'] ?? null,
            'designation' => 'Admin User',
            'role' => 'Admin',
            'will_login' => 'Yes',
            'active_status' => 'Active',
            'del_status' => 'Live'
        ];
        $new_company_id = $this->service_model->create_company_with_admin($company_data, $admin_data);
        if ($new_company_id) {
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Company and Admin created successfully.', ['company_id' => $new_company_id], $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create company.', null, $this);
        }
    }

    public function companies_put($id)
    {
        $request_data = $this->put();
        $company_data = [
            'business_name' => $request_data['business_name'] ?? null,
            'phone' => $request_data['phone'] ?? null,
            'address' => $request_data['address'] ?? null,
            'plan_id' => $request_data['plan_id'] ?? null,
            'access_day' => $request_data['access_day'] ?? null,
            'is_active' => $request_data['is_active'] ?? null
        ];
        $company_data = array_filter($company_data, function ($value) {
            return $value !== null;
        });
        $admin_data = [
            'full_name' => $request_data['admin_name'] ?? null,
            'email_address' => $request_data['email'] ?? null,
            'password' => $request_data['password'] ?? null,
            'phone' => $request_data['phone'] ?? null
        ];
        $admin_data = array_filter($admin_data, function ($value) {
            return $value !== null;
        });
        $admin_user = $this->service_model->get_admin_for_company($id);
        if (!$admin_user) {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Admin user for this company not found.', null, $this);
        }
        if ($this->service_model->update_company_with_admin($id, $admin_user->id, $company_data, $admin_data)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Company updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update company.', null, $this);
        }
    }

    public function companies_delete($id)
    {
        if ($this->service_model->delete_company($id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Company deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Failed to delete company. Cannot delete the main company.', null, $this);
        }
    }

    public function company_outlets_get($company_id)
    {
        $data = $this->service_model->get_company_outlets($company_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Company outlets retrieved.', $data, $this);
    }

    public function block_company_post($id)
    {
        if ($this->service_model->update_company($id, ['is_block_all_user' => 'Yes'])) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Company users have been blocked.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Could not block company.', null, $this);
        }
    }

    public function unblock_company_post($id)
    {
        if ($this->service_model->update_company($id, ['is_block_all_user' => 'No'])) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Company users have been unblocked.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Could not unblock company.', null, $this);
        }
    }

    public function payments_get()
    {
        $company_id = $this->get('company_id');
        $data = $this->service_model->get_payment_history($company_id);
        json_response(REST_Controller::HTTP_OK, 'success', 'Payment history retrieved.', $data, $this);
    }

    public function manual_payment_post()
    {
        $request_data = $this->get_json_request_data(true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('company_id', 'Company', 'required|numeric');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
        }
        $data = [
            'payment_type' => 'Manual Payment',
            'company_id' => $request_data['company_id'],
            'amount' => $request_data['amount'],
            'payment_date' => date('Y-m-d'),
            'trans_id' => '--',
        ];
        if ($this->service_model->add_payment($data)) {
            $this->service_model->update_company($request_data['company_id'], ['payment_clear' => 'Yes']);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Manual payment added successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to add manual payment.', null, $this);
        }
    }

    public function payments_delete($id)
    {
        if ($this->service_model->delete_payment($id)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Payment record deleted successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to delete payment record.', null, $this);
        }
    }

    public function settings_get($type)
    {
        $settings = $this->service_model->get_main_company_settings();
        $data = null;
        switch ($type) {
            case 'payment':
                $data = json_decode($settings->payment_settings);
                break;
            case 'email':
                $data = json_decode($settings->email_settings);
                break;
            case 'landing_page':
                $data = [
                    'site_info' => json_decode($settings->white_label),
                    'social_links' => json_decode($settings->social_link_details),
                    'counter' => json_decode($settings->counter_details),
                    'reviews' => json_decode($settings->customer_reviewers)
                ];
                break;
        }
        if ($data) {
            json_response(REST_Controller::HTTP_OK, 'success', ucfirst($type) . ' settings retrieved.', $data, $this);
        } else {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Settings not found or invalid type.', null, $this);
        }
    }

    public function settings_put($type)
    {
        $request_data = $this->get_json_request_data(true);
        $field_name = '';
        switch ($type) {
            case 'payment':
                $field_name = 'payment_settings';
                break;
            case 'email':
                $field_name = 'email_settings';
                break;
            case 'social':
                $field_name = 'social_link_details';
                break;
            case 'counter':
                $field_name = 'counter_details';
                break;
        }
        if (empty($field_name)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid setting type.', null, $this);
        }
        $update_data[$field_name] = json_encode($request_data);
        if ($this->service_model->update_company(1, $update_data)) {
            json_response(REST_Controller::HTTP_OK, 'success', ucfirst($type) . ' settings updated.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update settings.', null, $this);
        }
    }

    public function site_settings_post()
    {
        $data = $this->post();
        
        $main_company = $this->service_model->get_main_company_settings();
        $existing_settings = $main_company->white_label ? json_decode($main_company->white_label, true) : [];

        $update_data = [
            'site_name' => $data['site_name'] ?? $existing_settings['site_name'] ?? null,
            'phone' => $data['phone'] ?? $existing_settings['phone'] ?? null,
            'email' => $data['email'] ?? $existing_settings['email'] ?? null,
            'footer' => $data['footer'] ?? $existing_settings['footer'] ?? null,
            'footer_description' => $data['footer_description'] ?? $existing_settings['footer_description'] ?? null,
            'support_time' => $data['support_time'] ?? $existing_settings['support_time'] ?? null,
            'whatsapp_number' => $data['whatsapp_number'] ?? $existing_settings['whatsapp_number'] ?? null,
            'footer_address' => $data['footer_address'] ?? $existing_settings['footer_address'] ?? null,
            'footer_copy_right_text' => $data['footer_copy_right_text'] ?? $existing_settings['footer_copy_right_text'] ?? null,
            'google_map' => $data['google_map'] ?? $existing_settings['google_map'] ?? null,
        ];

        if (isset($_FILES['system_logo']) && !empty($_FILES['system_logo']['name'])) {
            $logo_name = $this->_handle_logo_upload('system_logo');
            if ($logo_name) {
                $update_data['system_logo'] = $logo_name;
            } else {
                json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', $this->upload->display_errors(), null, $this);
            }
        } else {
            $update_data['system_logo'] = $existing_settings['system_logo'] ?? null;
        }

        $payload['white_label'] = json_encode($update_data);

        if ($this->service_model->update_company(1, $payload)) {
            json_response(REST_Controller::HTTP_OK, 'success', 'Site settings updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to update site settings.', null, $this);
        }
    }

    private function _handle_logo_upload($file_field_name)
    {
        $config['upload_path'] = './images';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = '1000';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($file_field_name)) {
            $upload_info = $this->upload->data();
            return $upload_info['file_name'];
        }
        return false;
    }
}