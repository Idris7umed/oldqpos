<?php
    $wl = getWhiteLabel();
	$timeZones = getTimeZone();
	$pricing_plans = getAllPricingPlan();

    $site_name = '';
    $site_logo = '';
    $favicon = '';
	$site_footer = '';
    if($wl){
        if($wl->site_name){
            $site_name = $wl->site_name;
        }
        if($wl->footer){
            $site_footer = $wl->footer;
        }
        if($wl->system_logo){
            $site_logo = base_url()."images/".$wl->system_logo;
        }
        if($wl->favicon){
            $favicon = base_url()."images/".$wl->favicon;
        }else{
            $favicon = base_url()."images/favicon.ico";
        }
    }
    $paymentSetting = paymentSetting();


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo escape_output($site_name);?></title>
	<!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo escape_output($favicon) ?>" type="image/x-icon"> 
	<!-- jQuery 3.7.1 -->
	<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Select2 -->
	<script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css">
	<!-- Bootstrap 5.0.1 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/bootstrap.min.css">
	<!-- Toastr js -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/notify/toastr.css" type="text/css">
	<!-- Sweet alert -->
	<script src="<?php echo base_url(); ?>assets/POS/sweetalert2/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/POS/sweetalert2/dist/sweetalert.min.css">
	<!-- Style css -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/signup.css">
</head>
<body>


	<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">

	<input type="hidden" id="saas_m_ch" value="<?=file_exists(APPPATH.'controllers/Service.php')?'yes':''?>">
	<input type="hidden" id="ok" value="<?php echo lang('ok'); ?>">
	<input type="hidden" id="warning" value="<?php echo lang('alert'); ?>">
	<input type="hidden" id="front_r_1" value="<?php echo lang('front_r_1'); ?>">
	<input type="hidden" id="front_r_2" value="<?php echo lang('front_r_2'); ?>">
	<input type="hidden" id="front_r_3" value="<?php echo lang('front_r_3'); ?>">
	<input type="hidden" id="front_r_4" value="<?php echo lang('front_r_4'); ?>">
	<input type="hidden" id="front_r_5" value="<?php echo lang('front_r_5'); ?>">
	<input type="hidden" id="front_r_6" value="<?php echo lang('front_r_6'); ?>">
	<input type="hidden" id="front_r_7" value="<?php echo lang('front_r_7'); ?>">
	<input type="hidden" id="front_r_8" value="<?php echo lang('front_r_8'); ?>">
	<input type="hidden" id="front_r_9" value="<?php echo lang('front_r_9'); ?>">
	<input type="hidden" id="front_r_10" value="<?php echo lang('front_r_10'); ?>">
	<input type="hidden" id="front_r_11" value="<?php echo lang('front_r_11'); ?>">
	<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
	<input type="hidden" id="please_select_payment_method" class="please_select_payment_method" value="<?php echo lang('please_select_payment_method')?>">
	<input type="hidden" id="please_select_payment_type" class="please_select_payment_type" value="<?php echo lang('please_select_payment_type')?>">
	<input type="hidden" value="" id="is_trail_plan">


	<section class="ftco-section">
		<div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">

                    
                    <div class="login-wrap onetime_payment">
                        <div class="d-flex justify-content-center logo-area">
                            <a href="<?php echo base_url();?>">
                                <img src="<?php echo $site_logo;?>" alt="site-logo">
                            </a>
                        </div>
                        <?php
                        $attributes = array('id' => 'singup_company');
                        $read_only = '';
                        $display = '';
                        if(isset($update_plan) && $update_plan){
                            $read_only = "readonly";
                            $display = "none";
                        }
                        echo form_open_multipart(base_url('PaymentController/paymentOnetime'),$attributes); ?>
                        <input type="hidden" id="payment_company_id" value="<?php  echo $company_info->id ?>" name="payment_company_id">
                        <input type="hidden" id="payment_type" value="" name="payment_type">
                        <input title="item_name" name="item_name" id="item_name" type="hidden" value="Monthly payment for <?php echo isset($plan_details->plan_name) && $plan_details->plan_name?$plan_details->plan_name:"Plan Name"?>">
                        <input title="item_description" name="item_description" type="hidden" value="Monthly payment for <?php echo isset($plan_details->plan_name) && $plan_details->plan_name?$plan_details->plan_name:"Plan Name"?>">
                        <input type="hidden" value="<?php echo isset($plan_details->monthly_cost) && $plan_details->monthly_cost?number_format($plan_details->monthly_cost,2):0?>" name="item_price" id="total_payable">
                        <div class="form-wrapper-2">
                            <div class="auth-cart">
                                <h4>Plan Details</h4>
                                <table style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Plan</th>
                                            <th>Payment Type</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo escape_output($plan_details->plan_name) ?></td>
                                            <td><?php echo escape_output($plan_details->payment_type == '1' ? 'One Time' : 'Recurring') ?></td>
                                            <td><?php echo getAmtCustomC($plan_details->monthly_cost, $company_info->id) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <h4>Select Payment</h4>
                                <p>
                                    <input type="radio" id="Paypal" name="payment_method_type">
                                    <label for="Paypal">Paypal</label>
                                </p>
                                <p>
                                    <input type="radio" id="Stripe" name="payment_method_type">
                                    <label for="Stripe">Stripe</label>
                                </p>
                            </div>
                        </div>
                        <div class="d-flex py-10 justify-content-center">
                            <button type="submit" name="submit" value="submit" class="btn login-button btn-2 rounded submit me-1">Continue</button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
		</div>
	</section>





	<!--Stripe payment form-->
    <form method="POST" action="<?php echo base_url()?>payment-form-saas" id="stripe_form">
        <input type="hidden" value="yes" name="check_stripe" id="check_stripe">
        <input type="hidden" value="<?php echo isset($total_payable_amount) && $total_payable_amount?number_format($total_payable_amount,2):0?>" name="total_payable_str" id="total_payable_str">
        <input title="payment_company_id" name="payment_company_id" id="payment_company_id" class="payment_company_id" type="hidden" value="">
        <input title="item_description" name="item_description_str" id="item_description_str" type="hidden"
               value="<?php echo isset($pricingPlans->plan_name) && $pricingPlans->plan_name?$pricingPlans->plan_name:"Plan Name"?>">
    </form>

    <!--Paypal payment form-->
    <form method="POST" action="<?php echo base_url()?>payment-form-saas" id="paypal_form">
        <input type="hidden" value="" name="tax_value" id="tax_value">
        <input type="hidden" value="" name="subtotal_value" id="subtotal_value">
        <input type="hidden" value="" name="discount_value" id="discount_value">
        <input type="hidden" value="<?php echo isset($total_payable_amount) && $total_payable_amount?number_format($total_payable_amount,2):0?>" name="item_price" id="total_payable">
        <input title="item_name" name="item_name" id="item_name" type="hidden" value="Monthly payment for <?php echo isset($pricingPlans->plan_name) && $pricingPlans->plan_name?$pricingPlans->plan_name:"Plan Name"?>">
        <input title="payment_company_id" name="payment_company_id" id="payment_company_id" class="payment_company_id" type="hidden" value="">
        <input title="item_number" name="item_number" type="hidden" value="0" id="item_number">
        <input title="item_description" name="item_description" type="hidden" value="Monthly payment for <?php echo isset($pricingPlans->plan_name) && $pricingPlans->plan_name?$pricingPlans->plan_name:"Plan Name"?>">
    </form>

    <!-- Buy button -->
    <form action="<?php echo escape_output($paymentSetting->url_paypal); ?>"  id="paypal_recurring_form" method="post">
        <!-- Identify your business so that you can collect the payments -->
        <input type="hidden" name="business" value="<?php echo escape_output($paymentSetting->paypal_business_email); ?>">
        <!-- Specify a subscriptions button. -->
        <input type="hidden" name="cmd" value="_xclick-subscriptions">
        <!-- Specify details about the subscription that buyers will purchase -->
        <input type="hidden" name="item_name" value="Monthly payment for <?php echo isset($pricingPlans->plan_name) && $pricingPlans->plan_name?$pricingPlans->plan_name:"Plan Name"?>">
        <input type="hidden" name="item_number" value="--">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="a3" id="paypalAmt" value="<?php echo isset($total_payable_amount) && $total_payable_amount?number_format($total_payable_amount,2):0?>" name="item_price" id="total_payable">
        <input type="hidden" name="p3" id="paypalValid" value="1">
        <input type="hidden" name="t3" value="M">
        <!-- Custom variable user ID -->
        <input title="payment_company_id" name="payment_company_id" id="payment_company_id" class="payment_company_id" type="hidden" value="">
        <!-- Specify urls -->
        <input type="hidden" name="cancel_return" value = "<?php echo base_url()?>paymentStatus?msg=payment_failed">
        <input type="hidden" id="update_success_url" name="return" value="">
        <input type="hidden" name="notify_url" value="<?php echo base_url(); ?>ipn_paypal">
    </form>







	<script type="text/javascript" src="<?php echo base_url('frequent_changing/js/online_payment_front.js'); ?>"></script>
	<script src="<?php echo base_url(); ?>assets/POS/js/media.js"></script>
	<script src="<?php echo base_url(); ?>assets/bootstrap/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url(); ?>frequent_changing/js/signup.js"></script>
	<script src="<?php echo base_url(); ?>assets/notify/toastr.js"></script>
</body>
</html>

