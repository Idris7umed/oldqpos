<section class="main-content-wrapper">

    <?php
    if ($this->session->flashdata('exception')) {

        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body"><p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</p></div></div></section>';
    }
    ?>


    <?php
    if ($this->session->flashdata('exception_err')) {

        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <p><i class="icon fa fa-times"></i>';
        echo escape_output($this->session->flashdata('exception_err'));unset($_SESSION['exception_err']);
        echo '</p></div></div></section>';
    }
    ?>

    <section class="content-header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="top-left-header"><?php echo lang('companies')?> </h2>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('companies'); ?>" data-id_name="datatable">
            </div>
            <div class="col-md-6">

            </div>
        </div>
    </section>


        <div class="box-wrapper">
            <!-- general form elements -->
            <div class="table-box">
                <!-- /.box-header -->
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="ir_w_1"><?php echo lang('sn'); ?></th>
                                <th class="ir_w_9"><?php echo lang('business_name')?></th>
                                <th class="ir_w_6"><?php echo lang('phone')?></th>
                                <th class="ir_w_9"><?php echo lang('address')?></th>
                                <?php  if(!isFoodCourt()): ?>
                                    <th class="ir_w_6"><?php echo lang('plan')?></th>
                                    <th class="ir_w_6"><?php echo lang('last_payment')?></th>
                                    <th class="ir_w_10"><?php echo lang('access_remaining')?></th>
                                    <th class="ir_w_5 not-export-col"><?php echo lang('outlets')?></th>
                                <?php endif; ?>
                                <th class="ir_w_6 not-export-col text-center"><?php echo lang('actions')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($companies && !empty($companies)) {
                                $i = count($companies) - 1;
                            }
                            foreach ($companies as $spns) {
                                if($spns->id!=1):
                                ?>
                            <tr style="background-color: <?php echo isset($spns->payment_clear) && $spns->payment_clear=="No"?'#af1f1f29':''?>">
                                <td><?php echo escape_output($i--); ?></td>
                                <td>   <?php echo escape_output($spns->business_name) ?></td>

                                <td>   <?php echo escape_output($spns->phone) ?></td>
                                <td>   <?php echo escape_output($spns->address) ?></td>
                                <?php  if(!isFoodCourt()): ?>
                                    <td>   <?php echo escape_output(getPlanName($spns->plan_id)) ?></td>
                                    <td>   <?php echo escape_output(getLastPaymentDate($spns->id)) ?></td>
                                    <td>
                                        <?php
                                        if(isset($spns->payment_clear) && $spns->payment_clear=="No"):
                                            echo "0 day(s)";
                                        else:
                                            ?>
                                            <?php echo escape_output(getRemainingAccessDay($spns->id)) ?>
                                            <?php
                                        endif;
                                        ?>

                                    </td>
                                    <td>
                                        <a href="<?php echo base_url() ?>Service/companies/<?php echo escape_output($spns->id)?>/outlets"><button type="button"
                                            class="btn btn-xs btn-primary"><?php echo  (isFoodCourt()?lang('show'):lang('show_all'))?></button></a>
                                    </td>
                                <?php endif; ?>
                                <td>
                                    <div class="btn_group_wrap">
                                        <a class="btn btn-unique" href="<?php echo base_url() ?>Service/addEditCompany/<?php echo escape_output($this->custom->encrypt_decrypt($spns->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('edit'); ?>">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-cyan" href="<?php echo base_url() ?>Authentication/redirectUrl/<?php echo escape_output($this->custom->encrypt_decrypt($spns->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('login_as_company'); ?>">
                                            <i class="fa fa-sign-in"></i>
                                        </a>
                                        <a class="btn btn-unique" href="<?php echo base_url() ?>Service/customerManualPayment/<?php echo escape_output($this->custom->encrypt_decrypt($spns->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('send_onine_payment_link'); ?>">
                                            <i class="fa fa-send"></i>
                                        </a>
                                        <?php if($spns->is_block_all_user=="Yes"){ ?>
                                        <a class="btn btn-warning" href="<?php echo base_url() ?>Service/blockAllUser/<?php echo escape_output($this->custom->encrypt_decrypt($spns->id, 'encrypt')); ?>/No" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('unBlockAllUser'); ?>">
                                            <i class="fa fa-times"></i>
                                        </a>
                                        <?php } else {  ?>
                                         <a class="btn btn-warning" href="<?php echo base_url() ?>Service/blockAllUser/<?php echo escape_output($this->custom->encrypt_decrypt($spns->id, 'encrypt')); ?>/Yes" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-original-title="<?php echo lang('BlockAllUser'); ?>">
                                            <i class="fa fa-times"></i>
                                        </a>
                                        <?php } ?>

                                        <a class="delete btn btn-danger" href="<?php echo base_url() ?>Service/deleteCompany/<?php echo escape_output($this->custom->encrypt_decrypt($spns->id, 'encrypt')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            endif;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>

</section>
<div class="modal fade" id="add_payment_modal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <h3 class="modal-title" id="myModalLabel">
                    <?php echo lang('Manual_payment_for'); ?> "<span class="business_name_txt">---</span>"</h3>
            </div>
            <?php echo form_open(base_url() . 'Service/manualPayment', $arrayName = array('id' => 'manualPayment')) ?>
            <input type="hidden" id="hidden_company_id" name="hidden_company_id" value="">
            <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?php echo lang('expired_date')?> <span class="required_star">*</span></label>
                            
                            
                            <table>
                                    <tr>
                                        <td class="ir_w_100">
                                        <input type="text" readonly name="expired_date" id="expired_date" value="" placeholder="<?php echo lang('expired_date')?>" class="form-control start_date_today">


                                        </td>
                                        <td> 
                                        <div class="tooltip_custom"><i class="fa fa-question fa-lg form_question"></i>
                                <span class="tooltiptext_custom"><?php echo lang('Manual_payment_tooltip'); ?></span>
                            </div>
                                        </td>
                                    </tr>
                                </table>
                        </div>

                    </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label><?php echo lang('amount')?> <span class="required_star">*</span></label>
                        <input type="text" name="amount" id="amount" value="" placeholder="<?php echo lang('amount')?>" class="form-control integerchk customdatePicker">
                    </div>

                </div>
                <p>&nbsp;</p>
            </div>
            <div class="modal-footer">

                <button type="button"  data-dismiss="modal" aria-label="Close" class="btn btn-primary">
                    <?php echo lang('cancel'); ?></button>
                <button type="submit" name="submit" value="submit" class="btn btn-primary">
                    <?php echo lang('submit'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/datatable_custom/jquery-3.3.1.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/newDesign/js/forTable.js"></script>


<script src="<?php echo base_url(); ?>frequent_changing/js/custom_report.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/saas_company.js"></script>
