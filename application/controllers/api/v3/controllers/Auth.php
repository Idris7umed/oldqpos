<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Auth extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->add_package_path(APPPATH . 'controllers/api/v2/');
        $this->load->model('api_auth_model', 'auth_model');
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('api_role_model', 'role_model');
        $this->load->model('api_service_model', 'service_model');
        $this->load->library('jwt_lib');
        $this->load->library('form_validation');
        $this->load->model('Frontend_model');
        $this->load->helper('api');
        $this->load->helper('email_helper');
    }

    private function get_json_request_data($as_array = false)
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, $as_array);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $as_array ? [] : null;
        }
        return $data;
    }

    private function _send_activation_email($business_name, $recipient_email, $active_code)
    {
        $main_company = $this->Common_model->getDataById(1, 'tbl_companies');
        $activation_link = base_url() . 'authentication/active_company/' . $active_code;
        $message = "Congratulations, '$business_name' restaurant sign-up has been successful. To activate your account, please click the following link: <a href='$activation_link'>Activate Now</a>";
        sendEmailOnly($message, $recipient_email, '', $business_name, 'Restaurant Signup Verification');
    }

    public function pricing_plans_get($id = 0)
    {
        $data = $this->service_model->get_pricing_plans($id);
        if ($id > 0 && !$data) {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Pricing plan not found.', null, $this);
        }
        json_response(REST_Controller::HTTP_OK, 'success', 'Pricing plans retrieved.', $data, $this);
    }

    private function _generate_token_and_respond($user)
    {
        $role_name = $user->role ?? 'User';
        $user_permissions = [];
        $all_permissions = $this->role_model->get_all_permissions();
        $permissions_details_map = [];
        $parent_names_map = [];
        foreach ($all_permissions as $p) {
            $permissions_details_map[$p->child_id] = $p;
            if ($p->parent_id == 0) {
                $parent_names_map[$p->child_id] = $p->module_name;
            }
        }
        if ($role_name === 'Admin') {
            foreach ($all_permissions as $p) {
                if ($p->parent_id != 0 && isset($parent_names_map[$p->parent_id])) {
                    $parent_name = $parent_names_map[$p->parent_id];
                    $user_permissions[] = $parent_name . '.' . $p->label_name;
                } else {
                    $user_permissions[] = $p->module_name;
                }
            }
        } elseif (!empty($user->role_id)) {
            $role_details = $this->role_model->get_by_id($user->role_id, $user->company_id);
            if ($role_details) {
                $role_name = $role_details->role_name;
                if (!empty($role_details->permissions)) {
                    foreach ($role_details->permissions as $user_perm) {
                        $permission_id = $user_perm->access_child_id;
                        if (isset($permissions_details_map[$permission_id])) {
                            $perm_details = $permissions_details_map[$permission_id];
                            if ($perm_details->parent_id != 0 && isset($parent_names_map[$perm_details->parent_id])) {
                                $parent_name = $parent_names_map[$perm_details->parent_id];
                                $user_permissions[] = $parent_name . '.' . $perm_details->label_name;
                            } else {
                                $user_permissions[] = $perm_details->module_name;
                            }
                        }
                    }
                }
            }
        }
        $user_permissions = array_unique($user_permissions);
        $token_data = [
            'user_id' => (int) $user->id,
            'email' => $user->email_address,
            'role' => $role_name,
            'company_id' => (int) $user->company_id,
        ];
        $token = $this->jwt_lib->generate($token_data);
        $response_data = [
            'token' => $token,
            'user_info' => [
                'id' => (int) $user->id,
                'full_name' => $user->full_name,
                'email_address' => $user->email_address,
                'designation' => $user->designation,

                'role_name' => $role_name,
                'question' => $user->question,
                'permissions' => array_values($user_permissions)

            ]
        ];
        json_response(REST_Controller::HTTP_OK, 'success', 'Login successful.', $response_data, $this);
    }

    public function login_post()
    {

        $identifier = $this->post('email_or_phone');
        $password = $this->post('password');

        $request_data = $this->get_json_request_data(true);
        if (empty($identifier) && !empty($request_data)) {
            $identifier = $request_data['email_or_phone'] ?? null;
            $password = $request_data['password'] ?? null;
        }

        if (empty($identifier) || empty($password)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Email/Phone and password are required.', null, $this);
            return;
        }


        $staff_user = $this->auth_model->get_user_by_email($identifier);
        $staff_password_match = false;
        if ($staff_user) {
            if (password_verify($password, $staff_user->password) || md5($password) === $staff_user->password) {
                $staff_password_match = true;
            }
        }

        if ($staff_password_match && $staff_user->active_status == 'Active') {
            // Check Subscription Status
            $company_info = $this->Authentication_model->getCompanyInformation($staff_user->company_id);

            if ($company_info) {
                if ($company_info->is_active == 1) {
                    $is_block = "No";
                    $is_payment_clear = 'Yes';

                    if (!isFoodCourt()) {
                        if (!isServiceAccess($staff_user->id, $staff_user->company_id) && $staff_user->company_id != 1) {
                            $is_block = $company_info->is_block_all_user;
                            $is_payment_clear = 'No';

                            $due_payment = $this->Common_model->getPaymentInfo($company_info->id);

                            if ($due_payment) {
                                if ($due_payment->payment_date) {
                                    $access_day = $company_info->access_day;
                                    if (!$access_day) {
                                        $access_day = 0;
                                    }
                                    $today = date("Y-m-d", strtotime('today'));
                                    $end_date = date("Y-m-d", strtotime($due_payment->payment_date . " +" . $access_day . "day"));
                                    if ($today < $end_date) {
                                        $is_payment_clear = "Yes";
                                    }
                                }
                            } else {
                                $access_day = $company_info->access_day;
                                if (!$access_day) {
                                    $access_day = 0;
                                }
                                $today = date("Y-m-d", strtotime('today'));
                                $end_date = date("Y-m-d", strtotime($company_info->created_date . " +" . $access_day . "day"));
                                if ($today < $end_date) {
                                    $is_payment_clear = "Yes";
                                }
                            }
                        }
                    }

                    if ($is_block == "Yes") {
                        json_response(REST_Controller::HTTP_UNAUTHORIZED, 'error', 'Your account is blocked by the administrator.', null, $this);
                        return;
                    } elseif ($is_payment_clear == "No") {
                        json_response(REST_Controller::HTTP_UNAUTHORIZED, 'error', 'Your subscription has expired. Please renew your subscription to continue.', null, $this);
                        return;
                    }

                } else {
                    json_response(REST_Controller::HTTP_UNAUTHORIZED, 'error', 'Company is not active.', null, $this);
                    return;
                }
            } else {
                json_response(REST_Controller::HTTP_UNAUTHORIZED, 'error', 'Company information not found.', null, $this);
                return;
            }

            $this->_generate_staff_token_and_respond($staff_user);
            return;
        }


        $customer_user = $this->Frontend_model->getCustomerLogin($identifier, $password);

        if ($customer_user && $customer_user->del_status == 'Live') {
            $this->_generate_customer_token_and_respond($customer_user);
            return;
        }


        json_response(REST_Controller::HTTP_UNAUTHORIZED, 'error', 'Invalid credentials or inactive account.', null, $this);
    }

    private function _generate_staff_token_and_respond($user)
    {
        $role_name = $user->role ?? 'User';
        $user_permissions = [];
        $all_permissions = $this->role_model->get_all_permissions();
        $permissions_details_map = [];
        $parent_names_map = [];
        foreach ($all_permissions as $p) {
            $permissions_details_map[$p->child_id] = $p;
            if ($p->parent_id == 0) {
                $parent_names_map[$p->child_id] = $p->module_name;
            }
        }
        if ($role_name === 'Admin') {
            foreach ($all_permissions as $p) {
                if ($p->parent_id != 0 && isset($parent_names_map[$p->parent_id])) {
                    $parent_name = $parent_names_map[$p->parent_id];
                    $user_permissions[] = $parent_name . '.' . $p->label_name;
                } else {
                    $user_permissions[] = $p->module_name;
                }
            }
        } elseif (!empty($user->role_id)) {
            $role_details = $this->role_model->get_by_id($user->role_id, $user->company_id);
            if ($role_details) {
                $role_name = $role_details->role_name;
                if (!empty($role_details->permissions)) {
                    foreach ($role_details->permissions as $user_perm) {
                        $permission_id = $user_perm->access_child_id;
                        if (isset($permissions_details_map[$permission_id])) {
                            $perm_details = $permissions_details_map[$permission_id];
                            if ($perm_details->parent_id != 0 && isset($parent_names_map[$perm_details->parent_id])) {
                                $parent_name = $parent_names_map[$perm_details->parent_id];
                                $user_permissions[] = $parent_name . '.' . $perm_details->label_name;
                            } else {
                                $user_permissions[] = $perm_details->module_name;
                            }
                        }
                    }
                }
            }
        }
        $user_permissions = array_unique($user_permissions);

        $token_data = [
            'user_id' => (int) $user->id,
            'email' => $user->email_address,
            'role' => $role_name,
            'company_id' => (int) $user->company_id,
            'user_type' => 'staff'
        ];
        $token = $this->jwt_lib->generate($token_data);

        $response_data = [
            'token' => $token,
            'user_type' => 'staff',
            'user_info' => [
                'id' => (int) $user->id,
                'full_name' => $user->full_name,
                'email_address' => $user->email_address,
                'designation' => $user->designation,

                'role_name' => $role_name,
                'question' => $user->question,
                'permissions' => array_values($user_permissions)
            ]
        ];
        json_response(REST_Controller::HTTP_OK, 'success', 'Login successful.', $response_data, $this);
    }


    private function _generate_customer_token_and_respond($customer)
    {
        $token_data = [
            'customer_id' => (int) $customer->id,
            'name' => $customer->name,
            'phone' => $customer->phone,
            'user_type' => 'customer'
        ];
        $token = $this->jwt_lib->generate($token_data);

        unset($customer->password_online_user);
        unset($customer->active_code);

        $response_data = [
            'token' => $token,
            'user_type' => 'customer',
            'customer_info' => $customer
        ];

        json_response(REST_Controller::HTTP_OK, 'success', 'Login successful.', $response_data, $this);
    }

    public function login_pin_post()
    {
        $login_pin = $this->post('login_pin');
        if (empty($login_pin)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Login PIN is required.', null, $this);
            return;
        }
        $user = $this->auth_model->get_user_by_pin($login_pin);


        if ($user && $user->active_status == 'Active') {
            // Check Subscription Status
            $company_info = $this->Authentication_model->getCompanyInformation($user->company_id);

            if ($company_info) {
                if ($company_info->is_active == 1) {
                    $is_block = "No";
                    $is_payment_clear = 'Yes';

                    if (!isFoodCourt()) {
                        if (!isServiceAccess($user->id, $user->company_id) && $user->company_id != 1) {
                            $is_block = $company_info->is_block_all_user;
                            $is_payment_clear = 'No';

                            $due_payment = $this->Common_model->getPaymentInfo($company_info->id);

                            if ($due_payment) {
                                if ($due_payment->payment_date) {
                                    $access_day = $company_info->access_day;
                                    if (!$access_day) {
                                        $access_day = 0;
                                    }
                                    $today = date("Y-m-d", strtotime('today'));
                                    $end_date = date("Y-m-d", strtotime($due_payment->payment_date . " +" . $access_day . "day"));
                                    if ($today < $end_date) {
                                        $is_payment_clear = "Yes";
                                    }
                                }
                            } else {
                                $access_day = $company_info->access_day;
                                if (!$access_day) {
                                    $access_day = 0;
                                }
                                $today = date("Y-m-d", strtotime('today'));
                                $end_date = date("Y-m-d", strtotime($company_info->created_date . " +" . $access_day . "day"));
                                if ($today < $end_date) {
                                    $is_payment_clear = "Yes";
                                }
                            }
                        }
                    }

                    if ($is_block == "Yes") {
                        json_response(REST_Controller::HTTP_UNAUTHORIZED, 'error', 'Your account is blocked by the administrator.', null, $this);
                        return;
                    } elseif ($is_payment_clear == "No") {
                        json_response(REST_Controller::HTTP_UNAUTHORIZED, 'error', 'Your subscription has expired. Please renew your subscription to continue.', null, $this);
                        return;
                    }

                } else {
                    json_response(REST_Controller::HTTP_UNAUTHORIZED, 'error', 'Company is not active.', null, $this);
                    return;
                }
            } else {
                json_response(REST_Controller::HTTP_UNAUTHORIZED, 'error', 'Company information not found.', null, $this);
                return;
            }

            $this->_generate_staff_token_and_respond($user);
        } else {
            $message = $user && $user->active_status != 'Active' ? 'User is not active.' : 'Invalid PIN.';
            json_response(REST_Controller::HTTP_UNAUTHORIZED, 'error', $message, null, $this);
        }
    }

    public function forgot_password_step1_post()
    {
        $email = $this->post('email');
        if (empty($email)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Email is required.', null, $this);
            return;
        }
        $user_information = $this->Authentication_model->getAccountByMobileNo($email);
        if ($user_information) {
            $response_data = [
                'id' => $user_information->id,
                'full_name' => $user_information->full_name,
                'email_address' => $user_information->email_address,
                'question' => $user_information->question,
                'role_name' => $user_information->role,
            ];
            json_response(REST_Controller::HTTP_OK, 'success', 'Email Address found!', $response_data, $this);
        } else {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Email Address not found!', null, $this);
        }
    }

    public function forgot_password_step2_post()
    {
        $email = $this->post('email');
        $answer = $this->post('answer');
        $question = $this->post('question');
        if (empty($email) || empty($answer) || empty($question)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Email, question, and answer are required.', null, $this);
            return;
        }
        $user_information = $this->Authentication_model->getAccountByMobileNo($email);
        if ($user_information) {
            if ($question != $user_information->question) {
                json_response(REST_Controller::HTTP_UNAUTHORIZED, 'error', 'Incorrect question.', null, $this);
                return;
            }
            if ($answer != $user_information->answer) {
                json_response(REST_Controller::HTTP_UNAUTHORIZED, 'error', 'Incorrect answer.', null, $this);
                return;
            }
            $response_data = [
                'id' => $user_information->id,
                'full_name' => $user_information->full_name,
                'email_address' => $user_information->email_address,
                'question' => $user_information->question,
                'role_name' => $user_information->role,
            ];
            json_response(REST_Controller::HTTP_OK, 'success', 'Question and Answer matched!', $response_data, $this);
        } else {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'User not found!', null, $this);
        }
    }

    public function forgot_password_final_post()
    {
        $email = $this->post('email');
        $password = $this->post('password');
        $confirm_password = $this->post('confirm_password');
        if (empty($email) || empty($password) || empty($confirm_password)) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'All fields are required.', null, $this);
        }
        if ($password !== $confirm_password) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Passwords do not match.', null, $this);
        }
        $user_information = $this->Authentication_model->getAccountByMobileNo($email);
        if ($user_information) {
            $new_password_hashed = password_hash($password, PASSWORD_BCRYPT);
            $this->Authentication_model->updatePassword($new_password_hashed, $user_information->id);
            json_response(REST_Controller::HTTP_OK, 'success', 'Password updated successfully.', null, $this);
        } else {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'User not found!', null, $this);
        }
    }

    public function register_post()
    {
        $request_data = $this->get_json_request_data(true);
        if (!$request_data) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid JSON payload.', null, $this);
            return;
        }
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('business_name', 'Business Name', 'required');
        $this->form_validation->set_rules('admin_name', 'Admin Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tbl_users.email_address]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('plan_id', 'Plan', 'required|numeric');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
            return;
        }
        $this->load->model('Common_model');
        $plan_id = (int) $request_data['plan_id'];
        $plan = $this->Common_model->getDataById($plan_id, 'tbl_pricing_plans');
        if (!$plan) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid Plan ID.', null, $this);
            return;
        }
        $main_company = $this->Common_model->getDataById(1, 'tbl_companies');
        $active_code = uniqid();
        $is_free_trial = ($plan->free_trial_status == 'Yes');

        $company_data = [
            'business_name' => $request_data['business_name'],
            'phone' => $request_data['phone'] ?? null,
            'address' => $request_data['address'] ?? null,
            'plan_id' => $plan_id,
            'del_status' => $is_free_trial ? 'Live' : 'Deleted',
            'is_active' => $is_free_trial ? 1 : 2,
            'active_code' => $active_code,
            'date_format' => $main_company->date_format ?? 'd/m/Y',
            'zone_name' => $main_company->zone_name ?? 'Asia/Dubai',
            'currency' => $main_company->currency ?? '$',
            'pre_or_post_payment' => $main_company->pre_or_post_payment,
            'payment_settings' => $main_company->payment_settings,
        ];
        $admin_data = [
            'full_name' => $request_data['admin_name'],
            'email_address' => $request_data['email'],
            'password' => password_hash($request_data['password'], PASSWORD_BCRYPT),
            'phone' => $request_data['phone'] ?? null,
            'designation' => 'Admin User',
            'role' => 'Admin',
            'will_login' => 'Yes',
            'active_status' => 'Active',
            'del_status' => $is_free_trial ? 'Live' : 'Deleted'
        ];
        $this->db->trans_start();
        $this->db->insert('tbl_companies', $company_data);
        $company_id = $this->db->insert_id();
        $admin_data['company_id'] = $company_id;
        $this->db->insert('tbl_users', $admin_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create company and user.', null, $this);
            return;
        }
        $business_name = $request_data['business_name'];
        $admin_email = $request_data['email'];
        if ($plan->free_trial_status == 'Yes') {
            $company_update_data['payment_clear'] = 'Yes';
            $company_update_data['access_day'] = $plan->trail_days;
            $this->Common_model->updateInformation($company_update_data, $company_id, 'tbl_companies');





            json_response(REST_Controller::HTTP_CREATED, 'success', 'Your account has been activated successfully! You can now log in.', ['action' => 'activation_complete'], $this);
        } else {

            $this->load->helper('string');
            $this->load->helper('skipcash_helper');

            $amount_to_pay = number_format((float) $plan->monthly_cost, 2, '.', '');
            $custom_id = 'company_reg_' . $company_id;


            $payload_for_signature = [
                'Uid' => random_string('alnum', 16),
                'KeyId' => $this->config->item('skipcash_key_id'),
                'Amount' => $amount_to_pay,
                'FirstName' => $request_data['admin_name'],
                'LastName' => 'User',
                'Phone' => $request_data['phone'] ?? '55111111',
                'Email' => $request_data['email'],
                'Street' => $request_data['address'] ?? 'N/A',
                'City' => 'N/A',
                'State' => 'NA',
                'Country' => 'SA',
                'PostalCode' => '00000',
                'TransactionId' => 'REG-' . $company_id . '-' . time(),
                'Custom1' => $custom_id
            ];


            $full_payload = $payload_for_signature + [
                'webhookUrl' => base_url('payment/skipcash_callback'),
                'returnUrl' => base_url('payment/skipcash_return'),
            ];


            $signature = generate_skipcash_payment_signature($payload_for_signature, $this->config->item('skipcash_secret_key'));


            $base_api_url = $this->config->item('skipcash_sandbox_mode') ? $this->config->item('skipcash_api_url_sandbox') : $this->config->item('skipcash_api_url_production');
            $api_url = $base_api_url . '/payments';

            $headers = [
                'Content-Type: application/json',
                'Authorization: ' . $signature
            ];

            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($full_payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $response_data_skipcash = json_decode($response, true);

            log_message('error', 'SkipCash Request Payload: ' . json_encode($full_payload));
            log_message('error', 'SkipCash Response: ' . $response);

            if ($http_code == 200 && isset($response_data_skipcash['resultObj']['payUrl'])) {

                $response_data = [
                    'action' => 'require_payment',
                    'company_id' => $company_id,
                    'plan_name' => $plan->plan_name,
                    'amount' => $amount_to_pay,
                    'payment_url' => $response_data_skipcash['resultObj']['payUrl']
                ];
                json_response(REST_Controller::HTTP_CREATED, 'success', 'Registration successful. Please proceed to payment.', $response_data, $this);
            } else {
                $error_message = $response_data_skipcash['errorMessage'] ?? json_encode($response_data_skipcash);
                json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create payment link: ' . $error_message, null, $this);
            }

        }
    }

    public function confirm_payment_post()
    {
        $request_data = $this->get_json_request_data(true);
        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('company_id', 'Company ID', 'required|numeric');
        $this->form_validation->set_rules('transaction_id', 'Transaction ID', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric');
        $this->form_validation->set_rules('payment_method', 'Payment Method', 'required');
        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
            return;
        }
        $this->load->model('Common_model');
        $company_id = (int) $request_data['company_id'];
        $company = $this->Common_model->getDataById($company_id, 'tbl_companies');
        if (!$company) {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Company not found.', null, $this);
            return;
        }
        $company_update_data = [
            'payment_clear' => 'Yes',
            'is_active' => 1,
            'del_status' => 'Live'
        ];
        $this->Common_model->updateInformation($company_update_data, $company_id, 'tbl_companies');
        $admin_user = $this->db->where('company_id', $company_id)->where('role', 'Admin')->get('tbl_users')->row();
        if ($admin_user) {
            $this->Common_model->updateInformation(['del_status' => 'Live'], $admin_user->id, 'tbl_users');
        }
        $payment_history_data = [
            'payment_type' => $request_data['payment_method'],
            'company_id' => $company_id,
            'amount' => $request_data['amount'],
            'payment_date' => date('Y-m-d'),
            'trans_id' => $request_data['transaction_id'],
        ];
        $this->Common_model->insertInformation($payment_history_data, 'tbl_payment_histories');
        json_response(REST_Controller::HTTP_OK, 'success', 'Your account has been activated successfully! You can now log in.', ['action' => 'activation_complete'], $this);
    }

    public function regenerate_payment_link_post()
    {
        $request_data = $this->get_json_request_data(true);
        if (!isset($request_data['company_id']) || !is_numeric($request_data['company_id'])) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Company ID is required.', null, $this);
            return;
        }

        $company_id = (int) $request_data['company_id'];
        $company = $this->Common_model->getDataById($company_id, 'tbl_companies');

        if (!$company || $company->payment_clear == 'Yes') {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Company not found or payment already cleared.', null, $this);
            return;
        }

        $plan = $this->Common_model->getDataById($company->plan_id, 'tbl_pricing_plans');
        if (!$plan) {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Pricing plan not found for this company.', null, $this);
            return;
        }

        $admin_user = $this->db->where('company_id', $company_id)->where('role', 'Admin')->get('tbl_users')->row();
        if (!$admin_user) {
            json_response(REST_Controller::HTTP_NOT_FOUND, 'error', 'Admin user not found for this company.', null, $this);
            return;
        }

        $this->load->helper('string');
        $this->load->helper('skipcash_helper');
        $amount_to_pay = number_format((float) $plan->monthly_cost, 2, '.', '');
        $custom_id = 'company_reg_' . $company_id;

        $payload_for_signature = [
            'Uid' => random_string('alnum', 16),
            'KeyId' => $this->config->item('skipcash_key_id'),
            'Amount' => $amount_to_pay,
            'FirstName' => $admin_user->full_name,
            'LastName' => 'User',
            'Phone' => $company->phone ?? '55111111',
            'Email' => $admin_user->email_address,
            'Street' => $company->address ?? 'N/A',
            'City' => 'N/A',
            'State' => 'NA',
            'Country' => 'SA',
            'PostalCode' => '00000',
            'TransactionId' => 'REG-' . $company_id . '-' . time(),
            'Custom1' => $custom_id
        ];

        $full_payload = $payload_for_signature + [
            'webhookUrl' => base_url('payment/skipcash_callback'),
            'returnUrl' => base_url('payment/skipcash_return'),
        ];
        $signature = generate_skipcash_payment_signature($payload_for_signature, $this->config->item('skipcash_secret_key'));
        $base_api_url = $this->config->item('skipcash_sandbox_mode') ? $this->config->item('skipcash_api_url_sandbox') : $this->config->item('skipcash_api_url_production');
        $api_url = $base_api_url . '/payments';

        $headers = [
            'Content-Type: application/json',
            'Authorization: ' . $signature
        ];

        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($full_payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $response_data_skipcash = json_decode($response, true);
        log_message('error', 'SkipCash Regenerate Request: ' . json_encode($full_payload));
        log_message('error', 'SkipCash Regenerate Response: ' . $response);

        if ($http_code == 200 && isset($response_data_skipcash['resultObj']['payUrl'])) {
            $response_data = [
                'payment_url' => $response_data_skipcash['resultObj']['payUrl']
            ];
            json_response(REST_Controller::HTTP_OK, 'success', 'New payment link generated.', $response_data, $this);
        } else {
            $error_message = $response_data_skipcash['errorMessage'] ?? json_encode($response_data_skipcash);
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to create payment link: ' . $error_message, null, $this);
        }
    }
    public function customer_register_post()
    {
        $request_data = $this->get_json_request_data(true);
        if (!$request_data) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', 'Invalid JSON payload.', null, $this);
            return;
        }

        $this->form_validation->set_data($request_data);
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required|is_unique[tbl_customers.phone]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() == FALSE) {
            json_response(REST_Controller::HTTP_BAD_REQUEST, 'error', validation_errors(), null, $this);
            return;
        }

        $data = [
            'name' => $request_data['name'],
            'phone' => $request_data['phone'],
            'email' => $request_data['email'] ?? null,
            'address' => $request_data['address'] ?? null,
            'password_online_user' => md5($request_data['password']),
            'company_id' => 1,
            'user_id' => 1,
            'del_status' => 'Live'
        ];

        $new_id = $this->db->insert('tbl_customers', $data);

        if ($new_id) {
            $new_customer = $this->db->get_where('tbl_customers', ['id' => $this->db->insert_id()])->row();
            unset($new_customer->password_online_user);
            json_response(REST_Controller::HTTP_CREATED, 'success', 'Customer registered successfully.', $new_customer, $this);
        } else {
            json_response(REST_Controller::HTTP_INTERNAL_SERVER_ERROR, 'error', 'Failed to register customer.', null, $this);
        }
    }
}
