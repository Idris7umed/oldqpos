<script type="text/javascript" src="<?php echo base_url(); ?>frequent_changing/js/add_supplier_payment.js"></script>

<!-- Main content -->
<section class="main-content-wrapper">
    
    <section class="content-header">
        <h3 class="top-left-header">
            <?php echo escape_output($title); ?>
        </h3>
    </section>

        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <?php echo form_open(base_url() . 'Service/addManualPayment/' .(isset($encrypted_id) && $encrypted_id?$encrypted_id:''), $arrayName = array('id' => 'add_plan')) ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('Company')?> <span class="required_star">*</span></label>
                                <select tabindex="2" class="w-100 form-control select2" id="company"
                                        name="company">
                                    <option  value=""><?php echo lang('select'); ?></option>
                                    <?php
                                    foreach ($companies as $value):
                                        if($value->id!=1):
                                    ?>
                                    <option data-interval="<?php echo $value->price_interval ?>" data-monthly-cost="<?php echo $value->monthly_cost ?>" data-interval2="<?php echo $value->price_for_month2 ?>"  value="<?php echo escape_output($value->id)?>"><?php echo escape_output($value->business_name)?></option>
                                    <?php
                                    endif;
                                    endforeach;
                                    ?>

                                </select>
                            </div>
                            <?php if (form_error('company')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('company'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo lang('amount'); ?> <span class="required_star">*</span></label>
                                <input tabindex="1" type="text"  name="amount" class="form-control integerchk" id="payment_price"
                                       placeholder="<?php echo lang('amount'); ?>" value="">
                            </div>
                            <?php if (form_error('amount')) { ?>
                                <div class="callout callout-danger my-2">
                                    <?php echo form_error('amount'); ?>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <input type="hidden" name="<?php echo escape_output($this->security->get_csrf_token_name()); ?>"
                       value="<?php echo escape_output($this->security->get_csrf_hash()); ?>" />

                <div class="box-footer">
                    <button type="submit" name="submit" value="submit" class="btn bg-blue-btn me-2">
                        <i data-feather="upload"></i>
                        <?php echo lang('submit'); ?>
                    </button>

                    <a class="btn bg-blue-btn" href="<?php echo base_url() ?>Service/paymentHistory">
                        <i data-feather="corner-up-left"></i>
                        <?php echo lang('back'); ?>
                    </a>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    
    
</section>