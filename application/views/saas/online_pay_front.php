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
    $paymentSetting = paymentSettingSaas();
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
	<input type="hidden" value="<?php echo escape_output($is_trail_plan)?>" id="is_trail_plan">


	<section class="ftco-section">
		<div class="container">
			<div class="login-wrap">
				<div class="d-flex justify-content-center logo-area">
					<a href="<?php echo base_url();?>">
						<img src="<?php echo $site_logo;?>" alt="site-logo">
					</a>
				</div>
				<div class="d-flex">
					<div class="w-100">
						<h3 class="mb-2 auth-title">Sign Up</h3>
					</div>	
				</div>
				<?php
                $attributes = array('id' => 'singup_company');
                $read_only = '';
                $display = '';
                if(isset($update_plan) && $update_plan){
                    $read_only = "readonly";
                    $display = "none";
                }
                echo form_open_multipart(base_url('#'),$attributes); ?>
				<input type="hidden" id="plan_id" value="<?php echo escape_output($plan_id)?>" name="plan_id">
				<input type="hidden" id="package_type" value="<?php echo escape_output($package_type)?>" name="package_type">



				<input type="hidden" id="total_amount_payment" value="<?php echo escape_output($total_payable_amount)?>" name="total_amount_payment">
				<input type="hidden" name="update_plan" id="update_plan" class="update_plan" value="<?php echo isset($update_plan) && $update_plan?$update_plan:''?>">

				<div class="row form-wrapper">
					<div class="col-sm-12 col-md-6">
						<div class="auth-cart">
							<h5>Authentication Access</h5>
							<div class="row"> 
							<div class="col-sm-12 col-md-6">
								<div class="form-group mb-2">
									<label class="label" for="admin_name">Admin Name <span class="required_star">*</span></label></label>
									<input  class="form-control" placeholder="Admin Name" type="text" id="admin_name" name="admin_name" value="<?php echo set_value('admin_name'); ?>">
									<?php if (form_error('admin_name')) { ?>
									<div class="callout callout-danger my-2">
										<div class="error_paragraph d-flex align-items-center">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
												<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
												<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
											</svg> 
											<span class="ps-2">
												<?php echo form_error('admin_name'); ?>
											</span>
										</div>
									</div>
									<?php } ?>
								</div>
							</div>
							<div class="col-sm-12 col-md-6">
								<div class="form-group mb-2">
									<label class="label" for="email">Email Address <span class="required_star">*</span></label></label>
									<input  class="form-control" placeholder="Email Address"  type="text" id="email" name="email" value="<?php echo set_value('email'); ?>">
									<?php if (form_error('email')) { ?>
									<div class="callout callout-danger my-2">
										<div class="error_paragraph d-flex align-items-center">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
												<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
												<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
											</svg> 
											<span class="ps-2">
												<?php echo form_error('email_address'); ?>
											</span>
										</div>
									</div>
									<?php } ?>
								</div>
							</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group mb-2">
										<label class="label" for="password">Password <span class="required_star">*</span></label></label>
										<input type="password" name="password" class="form-control" placeholder="Password" id="password">
										<?php if (form_error('password')) { ?>
										<div class="callout callout-danger my-2">
											<div class="error_paragraph d-flex align-items-center">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
													<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
													<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
												</svg> 
												<span class="ps-2">
													<?php echo form_error('password'); ?>
												</span>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-2">
										<label class="label" for="confirm_password">Confirm Password <span class="required_star">*</span></label></label>
										<input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" id="confirm_password">
										<?php if (form_error('confirm_password')) { ?>
										<div class="callout callout-danger my-2">
											<div class="error_paragraph d-flex align-items-center">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
													<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
													<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
												</svg> 
												<span class="ps-2">
													<?php echo form_error('confirm_password'); ?>
												</span>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-6">
							<div class="auth-cart">
								<h5>Company Info</h5>
								<div class="row"> 
								<div class="col-sm-12 col-md-6">
									<div class="form-group mb-2">
										<label class="label" for="business_name">Business Name <span class="required_star">*</span></label></label>
										<input  class="form-control" placeholder="Business Name" type="text" id="business_name" name="business_name" value="<?php echo set_value('business_name'); ?>">
										<?php if (form_error('business_name')) { ?>
										<div class="callout callout-danger my-2">
											<div class="error_paragraph d-flex align-items-center">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
													<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
													<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
												</svg> 
												<span class="ps-2">
													<?php echo form_error('business_name'); ?>
												</span>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>
								<div class="col-sm-12 col-md-6">
									<div class="form-group mb-2">
										<label class="label" for="phone">Phone <span class="required_star">*</span></label></label>
										<input type="text" name="phone" class="form-control" placeholder="<?php echo lang('phone'); ?>" value="<?php echo set_value('phone'); ?>" id="phone">
										<?php if (form_error('phone')) { ?>
										<div class="callout callout-danger my-2">
											<div class="error_paragraph d-flex align-items-center">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
													<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
													<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
												</svg> 
												<span class="ps-2">
													<?php echo form_error('phone'); ?>
												</span>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>
								<div class="col-sm-12 col-md-6">
									<div class="form-group mb-2">
										<label class="label" for="address">Address <span class="required_star">*</span></label></label>
										<textarea name="address" class="form-control" placeholder="Address" id="address"></textarea>
										<?php if (form_error('address')) { ?>
										<div class="callout callout-danger my-2">
											<div class="error_paragraph d-flex align-items-center">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
													<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
													<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
												</svg> 
												<span class="ps-2">
													<?php echo form_error('address'); ?>
												</span>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>
								<div class="col-sm-12 col-md-6"> 
									<div class="form-group mb-2">
										<label class="label" for="zone">Zone <span class="required_star">*</span></label></label>
										<select name="zone_name" id="zone" class="select2 form-control">
											<option value="">Select</option>
											<?php foreach($timeZones as $zone){ ?>
												<option value="<?php echo escape_output($zone->zone_name) ?>" <?php echo set_select('zone_name', $zone->zone_name); ?>"><?php echo escape_output($zone->zone_name) ?></option>
											<?php } ?>
										</select>
										<?php if (form_error('zone_name')) { ?>
										<div class="callout callout-danger my-2">
											<div class="error_paragraph d-flex align-items-center">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
													<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
													<path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
												</svg> 
												<span class="ps-2">
													<?php echo form_error('zone_name'); ?>
												</span>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>

								<?php
                    if($is_trail_plan=="No"){
                    ?>
					<div class="col-md-6">
						<div class="form-group">
							<label class="label"> <?php echo lang('payment_type'); ?> <span class="required_star">*</span></label>
							<select tabindex="8" class="form-control select2" name="payment_type" id="payment_type">
								<option value=""><?php echo lang('select'); ?></option>
								<option <?=set_select('payment_type','1')?> value="1">One Time</option>
								<option <?=set_select('payment_type','2')?> value="2">Recurring</option>
							</select>
						</div>
						<?php if (form_error('payment_type')) { ?>
						<div class="txt_35 alert alert-error">
							<p><?php echo form_error('payment_type'); ?></p>
						</div>
						<?php } ?>
					</div>
					<div class="col-md-6 mt-7">
						<div class="form-group mb-2 d-flex flex-column">
							<label class="label"> <?php echo lang('payment_method'); ?> <span class="required_star">*</span></label>
							<select tabindex="8" class="form-control select2" name="payment_method" id="payment_method">
								<option value=""><?php echo lang('select'); ?></option>
								<?php if($paymentSetting->field_2==1):?>
									<option <?=set_select('payment_method','1')?> value="1">Paypal</option>
									<?php
								endif;
								?>
								<?php if($paymentSetting->field_3==1):?>
									<option id="stripe_hide" <?=set_select('payment_method','2')?> value="2">Stripe</option>
									<?php
								endif;
								?>
								<?php if($paymentSetting->field_5==1):?>
									<option <?=set_select('payment_method','3')?> value="3">Razorpay</option>
									<?php
								endif;
								?>
							</select>
						</div>
					</div>
					<?php
                    }
                    ?>

								

								</div>
							</div>
					</div>
					<div class="col-12 d-flex justify-content-center">
						<label class="checkmark-container">
							<a href="<?php echo base_url();?>#terms_and_condition" target="_blank">Terms & Condition</a>
							<input type="checkbox" id="term_condition" name="term_condition">
							<span class="checkmark"></span>
						</label>
					</div>
				</div>
				<div class="d-flex py-10 justify-content-center">
					<button type="submit" name="submit" value="submit" class="btn login-button btn-2 rounded submit me-1 payment_now">sign up</button>
				</div>
				<a href="<?php echo base_url()?>">Back to home</a>
				<?php echo form_close(); ?>
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


	<!-- razorpay JavaScript library -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<input type="hidden"
  value="<?php echo (isset($paymentSetting->field_4_key_1) && $paymentSetting->field_4_key_1 ? escape_output($paymentSetting->field_4_key_1) : '') ?>"
  id="key_id_razorpay">


</body>
</html>

