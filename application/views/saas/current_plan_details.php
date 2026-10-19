<?php
//get company information
$getCompanyInfo = getCompanyInfo();
?>
<!-- Main content -->
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
    if ($this->session->flashdata('exception_1')) {

        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body"><p><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception_1'));unset($_SESSION['exception_1']);
        echo '</p></div></div></section>';
    }
    ?>
    <section class="content-header">
        <h3 class="top-left-header">
        <?php echo lang('Current_Plan_Details'); ?>
        </h3>
    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <table class="table table-striped-columns">
                        <tbody>
                            <tr>
                                <th scope="row"><?php echo lang('plan_name'); ?></th>
                                <td><?php echo escape_output($plan_details->plan_name);?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?php echo lang('monthly_cost'); ?></th>
                                <td><?php echo getAmtCustom($getCompanyInfo->monthly_cost);?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?php echo lang('number_of_maximum_users'); ?></th>
                                <td><?php echo getAmtP($getCompanyInfo->number_of_maximum_users);?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?php echo lang('number_of_maximum_outlets'); ?></th>
                                <td><?php echo getAmtP($getCompanyInfo->number_of_maximum_outlets);?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?php echo lang('number_of_maximum_invoices'); ?></th>
                                <td><?php echo getAmtP($getCompanyInfo->number_of_maximum_invoices);?></td>
                            </tr>
                               
                                <tr>
                                    <th scope="row"><?php echo lang('activated_days'); ?></th>
                                    <td><?php echo escape_output($getCompanyInfo->access_day);?> <?php echo lang('days'); ?></td>
                                </tr>

                                <tr>
                                    <th scope="row"><?php echo lang('remaining_days'); ?></th>
                                    <td><?php echo escape_output(getRemainingAccessDay($company_id));?></td>
                                </tr>

                            <?php 
                                if($last_payment->payment_date){
                            ?>
                            <tr>
                                <th scope="row"><?php echo lang('last_payment_date'); ?></th>
                                <td><?php echo escape_output(date($this->session->userdata('date_format'), strtotime($last_payment->payment_date))); ?></td>
                            </tr>
                            <?php } ?>
                            <?php 
                                if($getCompanyInfo->access_day != '111' && $last_payment->payment_date){ 
                                $day_number = $getCompanyInfo->access_day;
                                $new_date = date('Y-m-d', strtotime($last_payment->payment_date . " + $day_number days"));
                            ?>
                            <tr>
                                <th scope="row"><?php echo lang('next_expired_date'); ?></th>
                                <td><?php echo escape_output(date($this->session->userdata('date_format'), strtotime($new_date))); ?></td>
                            </tr>
                            <?php } ?>
                            <?php 
                                if($count_invoice != ''){
                            ?>
                            <tr>
                                <th scope="row"><?php echo lang('created_invoice'); ?></th>
                                <td><?php echo getAmtP($count_invoice) ?></td>
                            </tr>
                            <?php 
                                }
                            ?>
                            <?php 
                                if($count_invoice != ''){
                                    $remainging_invoice = (int)$getCompanyInfo->number_of_maximum_invoices - (int) $count_invoice;
                            ?>
                            <tr>
                                <th scope="row"><?php echo lang('remaining_invoice'); ?></th>
                                <td><?php echo getAmtP($remainging_invoice) ?></td>
                            </tr>
                            <?php 
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>    
        </div>
    </div>
    
</section>