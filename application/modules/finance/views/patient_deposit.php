<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height wrapper-paiement">
        <!-- page start-->
        <section class="no-print col-md-7">
			<div class='thumbnail'>
				<header class="panel-heading">
                <?php echo lang('payment_history'); ?>



                <!--  <div class="panel-body no-print pull-right">
                      <a data-toggle="modal" href="#myModal">
                          <div class="btn-group">
                              <button id="" class="btn btn-xs green">
                                  <i class="fa fa-plus-circle"></i> <?php echo lang('deposit'); ?>
                              </button>
                          </div>
                      </a>   
                  </div>
  
                  <div class="panel-body no-print pull-right">
                      <a data-toggle="modal" href="#myModal5">
                          <div class="btn-group">
                              <button id="" class="btn btn-xs green">
                                  <i class="fa fa-file"></i> <?php echo lang('invoice'); ?>
                              </button>
                          </div>
                      </a>   
                  </div>-->

                <div class="panel-body no-print pull-right">
                    <a href="finance/addPaymentView?patient=<?php echo $patient->id; ?>&type=gen&page=historique">
                        <div class="btn-group">
                            <button id="" class="btn btn-xs green">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('add'); ?>
                            </button>
                        </div>
                    </a>
                </div>

            </header>
            <div class=" panel-body">
                <div class="adv-table editable-table ">
                    <section class="col-md-12 no-print">
                        <form role="form" class="f_report" action="finance/patientPaymentHistory" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <!--     <label class="control-label col-md-3">Date Range</label> -->
                                <div class="col-md-6">
                                    <div class="input-group input-large" data-date="13/07/2013" data-date-format="mm/dd/yyyy">
									<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                        <input type="text" class="form-control dpd1" name="date_from" value="<?php
                                                                                                                if (!empty($date_from)) {
                                                                                                                    echo date('m/d/Y', $date_from);
                                                                                                                }
                                                                                                                ?>" placeholder="<?php echo lang('date_from'); ?>" readonly="">
                                        <span class="input-group-addon"><?php echo lang('to'); ?></span>
                                        <input type="text" class="form-control dpd2" name="date_to" value="<?php
                                                                                                            if (!empty($date_to)) {
                                                                                                                echo date('m/d/Y', $date_to);
                                                                                                            }
                                                                                                            ?>" placeholder="<?php echo lang('date_to'); ?>" readonly="">
                                        <input type="hidden" class="form-control dpd2" name="patient" value="<?php echo $patient->id; ?>">
                                    </div>
                                    <div class="row"></div>
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-6 no-print">
                                    <button type="submit" name="submit" class="btn btn-info range_submit"><?php echo lang('submit'); ?></button>
                                </div>
                            </div>
                        </form>
                    </section>

                    <header class="panel-heading col-md-12 row">
                        <?php echo lang('all_bills'); ?> & <?php echo lang('deposits'); ?>
                    </header>
                    <div class="space15"></div>
                    <table class="table table-hover progress-table " id="editable-samples">
                        <thead>
                            <tr>
                                <th class=""><?php echo lang('date'); ?></th>
                                <th class=""><?php echo lang('invoice'); ?> #</th>
                                <th class=""><?php echo lang('amount'); ?></th>
                                <th class=""><?php echo lang('deposit'); ?></th>
                                <!-- <th class=""><?php echo lang('deposit_type'); ?></th>-->
                                <th class="no-print" style="width:35%;"><?php echo lang('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <style>
                                .img_url {
                                    height: 20px;
                                    width: 20px;
                                    background-size: contain;
                                    max-height: 20px;
                                    border-radius: 100px;
                                }

                                .option_th {
                                    width: 33%;
                                }
                            </style>

                            <?php
                            $dates = array();
                            $datess = array();
                            foreach ($payments as $payment) {
                                $dates[] = $payment->date;
                            }
                            foreach ($deposits as $deposit) {
                                $datess[] = $deposit->date;
                            }
                            $dat = array_merge($dates, $datess);
                            $dattt = array_unique($dat);
                            asort($dattt);

                            $total_pur = array();

                            $total_p = array();
                            ?>

                            <?php
                            foreach ($dattt as $key => $value) {
                                foreach ($payments as $payment) {
                                    if ($payment->date == $value) {
                            ?>
                                        <tr class="">
                                            <td><?php echo $payment->formeTimes; ?></td>
                                            <td> <?php echo $payment->code; ?></td>
                                            <td><?php if(!empty($payment->frais_service)){
                                                echo number_format($payment->gross_total + $payment->frais_service, 0, ",", ".");
                                            }else echo number_format($payment->gross_total, 0, ",", "."); ?> <?php echo $settings->currency; ?> </td>
                                            <td>
                                                <?php
                                                if (!empty($payment->amount_received)) {
                                                    echo number_format($payment->amount_received, 0, ",", ".") . ' ' . $settings->currency;
                                                }
                                                ?>
                                            </td>

                                            <!--  <td> <?php echo $payment->deposit_type; ?></td>-->


                                            <?php
                                            $actif = ' depositbutton ';
                                            if ($payment->gross_total + $payment->frais_service <= $payment->amount_received) {
                                                $actif = ' pointer-events  ';
                                            }
                                            ?>

                                            <td class="no-print">
                                                <?php if ($this->ion_auth->in_group(array('admin','adminmedecin', 'Accountant'))) { ?>
                                                    <!--     <a class="btn-xs btn-info" title="<?php echo lang('edit'); ?>" style="width: 25%;" href="finance/editPayment?id=<?php echo $payment->id; ?>"><i class="fa fa-edit"> </i></a>
                                                --> <?php } ?>
                                                <a class="btn-info btn-xs invoicebutton" title="<?php echo lang('invoice'); ?>" style="color: #fff; width: 25%;padding-left:3px;padding-right:3px;" href="finance/invoice?id=<?php echo $payment->id; ?>"><i class="fa fa-file-invoice"></i> <?php echo lang('invoice'); ?></a>
                                                <a href="#" class="btn-info btn-xs <?php echo $actif; ?>" data-gross_total="<?php echo $payment->gross_total + $payment->frais_service; ?>" data-amount_received="<?php echo $payment->amount_received; ?>" data-payment="<?php echo $payment->id; ?>" data-payment2="<?php echo $payment->code; ?>" data-patient="<?php echo $patient->id; ?>" style="margin-left: 2px;padding-left:3px;padding-right:3px;"><i class="fa fa-plus-circle"></i> <?php echo lang('deposit'); ?></a>
                                                <a href="#" class="btn-info btn-xs depositbuttonhisto" data-payment="<?php echo $payment->id; ?>" data-patient="<?php echo $patient->id; ?>" style="margin-left: 2px;padding-left:3px;padding-right:3px;"><i class="fa fa-info-circle"></i> <?php echo lang('info'); ?></a>


                                                <?php if ($this->ion_auth->in_group(array('admin','adminmedecin', 'Accountant'))) { ?>
                                                    <!--    <a class="btn-xs btn-info delete_button" title="<?php echo lang('delete'); ?>" style="width: 25%;"  href="finance/delete?id=<?php echo $payment->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
                                                --> <?php } ?>
                                                </button>
                                            </td>
                                        </tr>

                                <?php
                                    }
                                }
                                ?>


                                <?php
                                /*   foreach ($deposits as $deposit) {
                              if ($deposit->date == $value) {
                              if (!empty($deposit->deposited_amount) && empty($deposit->amount_received_id)) {
                              ?>

                              <tr class="">
                              <td><?php echo date('d-m-y', $deposit->date); ?></td>
                              <td><?php echo $deposit->payment_id; ?></td>
                              <td></td>
                              <td><?php echo number_format($deposit->deposited_amount,0, ",", "."); ?> <?php echo $settings->currency; ?> </td>
                              <td> <?php echo $deposit->deposit_type; ?></td>
                              <td  class="no-print">
                              <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                              <button type="button" class="btn-xs btn-info editbutton" title="<?php echo lang('edit'); ?>" style="width: 25%;" data-toggle="modal" data-id="<?php echo $deposit->id; ?>"><i class="fa fa-edit"></i> </button>
                              <?php } ?>
                              <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                              <a class="btn-xs btn-info delete_button" title="<?php echo lang('delete'); ?>" style="width: 25%;" href="finance/deleteDeposit?id=<?php echo $deposit->id; ?>&patient=<?php echo $patient->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a>
                              <?php } ?>
                              </td>
                              </tr>
                              <?php
                              }
                              }
                              } */
                                ?>
                            <?php } ?>



                        </tbody>

                    </table>
                </div>
            
            <div class="form-group col-md-12">
                <a href="patient/patientPayments" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('retour'); ?></a>

            </div>
			</div>
			</div>
        </section>


        <section class="no-print thumbnail col-md-5">
            <header class="panel-heading">
                <?php echo "Details"; ?>
            </header>

            <div class="">
                <section class="m_t">
                    <!--<div class="panel-body profile">
                        <div class="task-thumb-details">

                            <?php echo lang('identity'); ?>: <h1><a href="patient/medicalHistory?id=<?php echo $patient->id; ?>"><?php echo $patient->name . ' ' . $patient->last_name; ?></a></h1> <br>

                            <?php echo lang('address'); ?>: <p> <?php echo $patient->address; ?></p>
                        </div>
                    </div>-->
                    <table class="table table-hover personal-task">
                        <tbody>
						<tr>
                                <td>
                                    <i class=" fa fa-user"></i> <?php echo lang('identity'); ?>
                                </td>
                                <td><h1><a href="patient/medicalHistory?id=<?php echo $patient->id; ?>"><?php echo $patient->name . ' ' . $patient->last_name; ?></a></h1></td>

                            </tr>
							<tr>
                                <td>
                                    <i class=" fa fa-map-marker"></i> <?php echo lang('address'); ?>
                                </td>
                                <td><?php echo $patient->address; ?></td>

                            </tr>
                            <tr>
                                <td>
                                    <i class=" fa fa-envelope"></i> Email 
                                </td>
                                <td><?php echo $patient->email; ?></td>

                            </tr>
                            <tr>
                                <td>
                                    <i class="fa fa-phone"></i> Phone 
                                </td>
                                <td><?php echo $patient->phone; ?></td>

                            </tr>

                        </tbody>
                    </table>
                </section>

                <?php
                $total_bill = array();
                $total_frais_service = array();
               // var_dump($payments);
                foreach ($payments as $payment) {
                    $total_bill[] = $payment->gross_total;
                    $total_frais_service[] = $payment->frais_service;
                }
               
                if (!empty($total_bill)) {
                    $total_bill = array_sum($total_bill) + array_sum($total_frais_service) ;
                } else {
                    $total_bill = 0;
                }
                ?>






                <section class="panel">
                    <div class="weather-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <p> <i class="fa fa-money"></i>
                                        <?php echo lang('total_bill_amount'); ?></p>
                                </div>
                                <div class="col-xs-8">
                                    <p>
                                        <?php $total_payable_bill = $total_bill;
                                        echo number_format($total_payable_bill, 0, ",", "."); ?> <?php echo $settings->currency; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="panel">
                    <div class="weather-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <p> <i class="fa fa-money"></i>
                                        <?php echo lang('total_deposit_amount'); ?></p>
                                </div>
                                <div class="col-xs-8">
                                    <p>

                                        <?php
                                        // $total_deposit = array();
                                        $total_amount_received = array();
                                        // foreach ($deposits as $deposit) {
                                        foreach ($payments as $payment) {
                                            // $total_deposit[] = $deposit->deposited_amount;
                                            $total_amount_received[] = !empty($payment->amount_received) ? $payment->amount_received : 0;
                                        }
                                        // echo number_format(array_sum($total_deposit), 0, ",", ".");
                                        echo number_format(array_sum($total_amount_received), 0, ",", ".");
                                        ?> <?php echo $settings->currency; ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="panel red" style="">
                    <div class="weather-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <p> <i class="fa fa-money"></i>
                                        <?php echo lang('due_solde'); ?></p>
                                </div>
                                <div class="col-xs-8">
                                   <p>

                                        <?php
                                        // $totalpp = $total_payable_bill - array_sum($total_deposit);
                                        $totalpp = $total_payable_bill - array_sum($total_amount_received);

                                        echo number_format($totalpp, 0, ",", ".");
                                        ?> <?php echo $settings->currency; ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->



<script>
    $(document).ready(function() {
        $('#editable-samplee').DataTable();
    });
</script>






<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_deposit'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="payu/check" id="deposit-form" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('invoice'); ?></label>
                        <select class="form-control m-bot15 js-example-basic-single" id="" name="payment_id" value=''>
                            <option value="">Select .....</option>
                            <?php foreach ($payments as $payment) { ?>
                                <option value="<?php echo $payment->id; ?>" <?php
                                                                            if (!empty($deposit->payment_id)) {
                                                                                if ($deposit->payment_id == $payment->id) {
                                                                                    echo 'selected';
                                                                                }
                                                                            }
                                                                            ?>><?php echo $payment->id; ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('deposit_amount'); ?></label>
                        <input type="text" class="form-control" name="deposited_amount" id="exampleInputEmail1" value='' placeholder="">
                    </div>



                    <div class="form-group">
                        <div class="payment_label">
                            <label for="exampleInputEmail1"><?php echo lang('deposit_type'); ?></label>
                        </div>
                        <div class="">
                            <select class="form-control m-bot15 js-example-basic-single selecttype" id="selecttype" name="deposit_type" value=''>
                                <?php if ($this->ion_auth->in_group(array('admin','adminmedecin', 'Accountant', 'Receptionist'))) { ?>
                                    <option value="Cash"> <?php echo lang('cash'); ?> </option>
                                    <option value="Card"> <?php echo lang('card'); ?> </option>
                                <?php } ?>

                            </select>
                        </div>

                        <?php
                        $payment_gateway = $settings->payment_gateway;
                        ?>



                        <div class="card">

                            <hr>
                            <div class="col-md-12 payment pad_bot">
                                <label for="exampleInputEmail1"> <?php echo lang('accepted'); ?> <?php echo lang('cards'); ?></label>
                                <div class="payment pad_bot">
                                    <img src="uploads/card.png" width="100%">
                                </div>
                            </div>
                            <?php
                            if ($payment_gateway == 'PayPal') {
                            ?>

                                <div class="col-md-12 payment pad_bot">
                                    <label for="exampleInputEmail1"> <?php echo lang('card'); ?> <?php echo lang('type'); ?></label>
                                    <select class="form-control m-bot15" name="card_type" value=''>

                                        <option value="Mastercard"> <?php echo lang('mastercard'); ?> </option>
                                        <option value="Visa"> <?php echo lang('visa'); ?> </option>
                                        <option value="American Express"> <?php echo lang('american_express'); ?> </option>
                                    </select>
                                </div>
                            <?php } ?>
                            <?php if ($payment_gateway != 'Pay U Money') { ?>
                                <div class="col-md-12 payment pad_bot">
                                    <label for="exampleInputEmail1"> <?php echo lang('card'); ?> <?php echo lang('number'); ?></label>
                                    <input type="text" class="form-control pay_in" id="card" name="card_number" value='' placeholder="">
                                </div>



                                <div class="col-md-8 payment pad_bot">
                                    <label for="exampleInputEmail1"> <?php echo lang('expire'); ?> <?php echo lang('date'); ?></label>
                                    <input type="text" class="form-control pay_in" id="expire" data-date="" data-date-format="MM YY" placeholder="Expiry (MM/YY)" name="expire_date" maxlength="7" aria-describedby="basic-addon1" value='' placeholder="">
                                </div>
                                <div class="col-md-4 payment pad_bot">
                                    <label for="exampleInputEmail1"> <?php echo lang('cvv'); ?> </label>
                                    <input type="text" class="form-control pay_in" id="cvv" maxlength="3" name="cvv_number" value='' placeholder="">
                                </div>

                        </div>

                    <?php
                            }
                    ?>

                    </div>



                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="patient" value='<?php echo $patient->id; ?>'>
                    <div class="form-group cashsubmit payment  right-six col-md-12">
					<button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                    <div class="form-group cardsubmit  right-six col-md-12 hidden">
                        <button type="submit" name="pay_now" id="submit-btn" class="btn btn-info row pull-right" <?php if ($settings->payment_gateway == 'Stripe') {
                                                                                                                    ?>onClick="stripePay(event);" <?php }
                                                                                                                                                    ?>> <?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Patient Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('edit_deposit'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editDepositform" action="finance/deposit" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="payment_label">
                        <label for="exampleInputEmail1"><?php echo lang('invoice'); ?></label>
                        <select class="form-control m-bot15 js-example-basic-single" id="" name="payment_id" value=''>
                            <option value="">Select .....</option>
                            <?php foreach ($payments as $payment) { ?>
                                <option value="<?php echo $payment->id; ?>" <?php
                                                                            if (!empty($deposit->payment_id)) {
                                                                                if ($deposit->payment_id == $payment->id) {
                                                                                    echo 'selected';
                                                                                }
                                                                            }
                                                                            ?>><?php echo $payment->id; ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('deposit_amount'); ?></label>
                        <input type="text" class="form-control" name="deposited_amount" id="exampleInputEmail1" value='' placeholder="">
                    </div>


                    <div class="form-group">
                        <div class="payment_label">
                            <label for="exampleInputEmail1"><?php echo lang('deposit_type'); ?></label>
                        </div>
                        <div class="">
                            <select class="form-control m-bot15 js-example-basic-single selecttype" id="selecttype" name="deposit_type" value=''>
                                <?php if ($this->ion_auth->in_group(array('admin','adminmedecin', 'Accountant', 'Receptionist'))) { ?>
                                    <option value="Cash"> <?php echo lang('cash'); ?> </option>
                                    <option value="Card" disabled=""> <?php echo lang('card'); ?> </option>
                                    <option value="" disabled=""> <?php echo lang('zuulupay'); ?> </option>
                                    <option value="" disabled=""> <?php echo lang('agent_zuulupay'); ?> </option>
                                <?php } ?>

                            </select>
                        </div>

                        <?php
                        $payment_gateway = $settings->payment_gateway;
                        ?>



                        <div class="card">

                            <hr>
                            <div class="col-md-12 payment pad_bot">
                                <label for="exampleInputEmail1"> <?php echo lang('accepted'); ?> <?php echo lang('cards'); ?></label>
                                <div class="payment pad_bot">
                                    <img src="uploads/card.png" width="100%">
                                </div>
                            </div>

                            <?php
                            if ($payment_gateway == 'PayPal') {
                            ?>
                                <div class="col-md-12 payment pad_bot">
                                    <label for="exampleInputEmail1"> <?php echo lang('card'); ?> <?php echo lang('type'); ?></label>
                                    <select class="form-control m-bot15" name="card_type" value=''>

                                        <option value="Mastercard"> <?php echo lang('mastercard'); ?> </option>
                                        <option value="Visa"> <?php echo lang('visa'); ?> </option>
                                        <option value="American Express"> <?php echo lang('american_express'); ?> </option>
                                    </select>
                                </div>
                            <?php } ?>
                            <?php if ($payment_gateway != 'Pay U Money') { ?>
                                <div class="col-md-12 payment pad_bot">
                                    <label for="exampleInputEmail1"> <?php echo lang('card'); ?> <?php echo lang('number'); ?></label>
                                    <input type="text" class="form-control pay_in" id="card1" name="card_number" value='<?php
                                                                                                                        if (!empty($payment->p_email)) {
                                                                                                                            echo $payment->p_email;
                                                                                                                        }
                                                                                                                        ?>' placeholder="">
                                </div>



                                <div class="col-md-8 payment pad_bot">
                                    <label for="exampleInputEmail1"> <?php echo lang('expire'); ?> <?php echo lang('date'); ?></label>
                                    <input type="text" class="form-control pay_in" data-date="" id="expire1" data-date-format="MM YY" placeholder="Expiry (MM/YY)" name="expire_date" maxlength="7" aria-describedby="basic-addon1" value='<?php
                                                                                                                                                                                                                                            if (!empty($payment->p_phone)) {
                                                                                                                                                                                                                                                echo $payment->p_phone;
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                            ?>' placeholder="">
                                </div>
                                <div class="col-md-4 payment pad_bot">
                                    <label for="exampleInputEmail1"> <?php echo lang('cvv'); ?> </label>
                                    <input type="text" class="form-control pay_in" id="cvv1" maxlength="3" name="cvv_number" value='<?php
                                                                                                                                    if (!empty($payment->p_age)) {
                                                                                                                                        echo $payment->p_age;
                                                                                                                                    }
                                                                                                                                    ?>' placeholder="">
                                </div>

                        </div>

                    <?php
                            }
                    ?>

                    </div>



                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="patient" value='<?php echo $patient->id; ?>'>
                    <div class="form-group cashsubmit payment  right-six col-md-12">
						<button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                    <div class="form-group cardsubmit  right-six col-md-12 hidden">
                        <button type="submit" name="pay_now" id="submit-btn1" class="btn btn-info row pull-right" <?php if ($settings->payment_gateway == 'Stripe') {
                                                                                                                    ?>onClick="stripePay1(event);" <?php }
                                                                                                                                                    ?>> <?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Patient Modal-->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i> <?php echo lang('choose_payment_type'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="clearfix">
                    <div class="col-lg-12 clearfix">
                        <a href="finance/addPaymentByPatientView?id=<?php echo $patient->id; ?>&type=gen">
                            <div class="col-lg-6">
                                <div class="flat-carousal" style="background: #39B27C;">
                                    <div id="owl-demo" class="owl-carousel owl-theme" style="opacity: 1; display: block;">
                                        <?php echo lang('add_general_payment'); ?> <i style="float: right; font-size: 18px;" class="fa fa-arrow-circle-o-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="finance/addPaymentByPatientView?id=<?php echo $patient->id; ?>&type=ot">
                            <div class="col-lg-6">
                                <div class="flat-carousal" style="background: #39B27C;">
                                    <div id="owl-demo" class="owl-carousel owl-theme" style="opacity: 1; display: block;">
                                        <?php echo lang('add_ot_payment'); ?> <i style="float: right; font-size: 18px;" class="fa fa-arrow-circle-o-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="col-lg-3"></div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>











<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header no-print">
                <button type="button" class="close no-print" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('invoice'); ?></h4>
            </div>
            <div class="modal-body clearfix">
                <div class="panel panel-primary">
                    <!--<div class="panel-heading navyblue"> INVOICE</div>-->
                    <div class="panel" id="invoice" style="font-size: 10px;">
                        <div class="row invoice-list">
                            <div class="text-center corporate-id top_title">
                                <img alt="" src="<?php echo $this->settings_model->getSettings()->logo; ?>" width="200" height="100">
                                <h3>
                                    <?php echo $settings->title ?>
                                </h3>
                                <h4>
                                    <?php echo $settings->address ?>
                                </h4>
                                <h4>
                                    Tel: <?php echo $settings->phone ?>
                                </h4>
                            </div>
                            <div class="col-lg-4 col-sm-4" style="float: left;">
                                <h4><?php echo lang('payment_to'); ?>:</h4>
                                <p>
                                    <?php echo $settings->title; ?> <br>
                                    <?php echo $settings->address; ?><br>
                                    Tel: <?php echo $settings->phone; ?>
                                </p>
                            </div>
                            <?php if (!empty($payment->patient)) { ?>
                                <div class="col-lg-4 col-sm-4" style="float: left;">
                                    <h4><?php echo lang('bill_to'); ?>:</h4>
                                    <p>
                                        <?php
                                        if (!empty($patient->name)) {
                                            echo $patient->name . ' ' . $patient->last_name . ' <br>';
                                        }
                                        if (!empty($patient->address)) {
                                            echo $patient->address . ' <br>';
                                        }
                                        if (!empty($patient->phone)) {
                                            echo $patient->phone . ' <br>';
                                        }
                                        ?>
                                    </p>
                                </div>
                            <?php } ?>
                            <div class="col-lg-4 col-sm-4" style="float: left;">
                                <h4><?php echo lang('invoice_info'); ?></h4>
                                <ul class="unstyled">
                                    <li>Date : <?php echo date('m/d/Y'); ?></li>
                                </ul>
                            </div>
                            <br>
                        </div>
                        <table class="table table-hover progress-table " id="editable-samples">
                            <thead>
                                <tr>
                                    <th class=""><?php echo lang('date'); ?></th>
                                    <th class=""><?php echo lang('invoice'); ?> #</th>
                                    <th class=""><?php echo lang('bill_amount'); ?></th>
                                    <th class=""><?php echo lang('deposit'); ?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <style>
                                    .img_url {
                                        height: 20px;
                                        width: 20px;
                                        background-size: contain;
                                        max-height: 20px;
                                        border-radius: 100px;
                                    }

                                    .option_th {
                                        width: 33%;
                                    }
                                </style>

                                <?php
                                $dates = array();
                                $datess = array();
                                foreach ($payments as $payment) {
                                    $dates[] = $payment->date;
                                }
                                foreach ($deposits as $deposit) {
                                    $datess[] = $deposit->date;
                                }
                                $dat = array_merge($dates, $datess);
                                $dattt = array_unique($dat);
                                asort($dattt);

                                $total_pur = array();

                                $total_p = array();
                                ?>

                                <?php
                                foreach ($dattt as $key => $value) {
                                    foreach ($payments as $payment) {
                                        if ($payment->date == $value) {
                                ?>
                                            <tr class="">
                                                <td><?php echo date('d/m/y', $payment->date); ?></td>
                                                <td> <?php echo $payment->id; ?></td>
                                                <td><?php echo $settings->currency; ?> <?php echo $payment->gross_total; ?></td>
                                                <td><?php
                                                    if (!empty($payment->amount_received)) {
                                                        echo $settings->currency;
                                                    }
                                                    ?> <?php echo $payment->amount_received; ?>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <?php
                                    foreach ($deposits as $deposit) {
                                        if ($deposit->date == $value) {
                                            if (!empty($deposit->deposited_amount) && empty($deposit->amount_received_id)) {
                                    ?>

                                                <tr class="">
                                                    <td><?php echo date('d-m-y ', $deposit->date); ?></td>
                                                    <td><?php echo $deposit->payment_id; ?></td>
                                                    <td></td>
                                                    <td><?php echo $settings->currency; ?> <?php echo $deposit->deposited_amount; ?></td>
                                                </tr>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-lg-8 invoice-bbock pull-right total_section">
                                <ul class="unstyled amounts">
                                    <li><strong><?php echo lang('grand_total'); ?> : </strong><?php echo $settings->currency; ?> <?php echo $total_payable_bill = $total_bill; ?></li>
                                    <li><strong><?php echo lang('amount_received'); ?> : </strong><?php echo $settings->currency; ?> <?php echo array_sum($total_deposit); ?></li>
                                    <li><strong><?php echo lang('amount_to_be_paid'); ?> : </strong><?php echo $settings->currency; ?> <?php echo $total_payable_bill - array_sum($total_deposit); ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <div class="panel col-md-12 no-print">
                        <a class="btn btn-info invoice_button" onclick="javascript:window.print();"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
                    </div>

                    <div class="text-center invoice-btn clearfix">
                        <a class="btn btn-info btn-sm detailsbutton pull-left download" id="download"><i class="fa fa-download"></i> <?php echo lang('download'); ?> </a>
                    </div>

                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="myModaldeposit2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_deposit'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="clearfix">
                <form role="form" action="finance/checkDepot" id="deposit-checkDepot"  method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('invoice'); ?></label>
                        <select class="form-control m-bot15" id="paymentid" name="paymentid">

                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo lang('reste_a_payer'); ?> : <span id="reste"></span> <?php echo $settings->currency; ?></label>
                        
                        <input type="hidden" name="patient" value='<?php echo $patient->id; ?>'>
                        <input type="hidden" name="name" value='<?php echo $patient->name; ?>'>
                        <input type="hidden" name="lastname" value='<?php echo $patient->last_name; ?>'>
                        <input type="hidden" name="patientId" value='<?php echo $patient->patient_id; ?>'>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('deposit_amount'); ?></label>
                        <input type="text" class="form-control money" name="deposited" id="deposited" onkeyup="recuperationDepot(event)" value='' placeholder="">
                    </div>
                    <code id="errorDepotCash" class="flash_message" style="display:none">Le montant est superieur au montant dû</code>
                    <div class="form-group">
                        <input  type="hidden" class="form-control" name="deposited_amount" id="deposited_amount" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <div class="payment_label pull-left">
                            <label for="exampleInputEmail1"><?php echo lang('deposit_type'); ?></label>
                        </div>
                        <div class="">
                            <select class="form-control m-bot15 js-example-basic-single selecttype" id="selecttype" name="deposit_type" value=''>
                                <?php if ($this->ion_auth->in_group(array('admin','adminmedecin', 'Accountant', 'Receptionist'))) { ?>
                                    <option value="Cash"> <?php echo lang('cash'); ?> </option>
                                    <option value="OrangeMoney"> <?php echo lang('orange_money'); ?> </option>
                                    <option value="zuulupay" disabled=""> <?php echo lang('zuulupay'); ?> </option>
                                    <option value="" disabled=""> <?php echo lang('carte_bancaire'); ?> </option>
                                    <option value="" disabled=""> <?php echo lang('demande'); ?> </option>
                                <?php } ?>

                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="patient" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="redirect" value='finance/patientPaymentHistory?patient=<?php echo $patient->id; ?>'>
                    <div id="bouttonSuivant">
                        <div class="form-group cashsubmit payment  right-six col-md-12">
							<button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                            <button type="submit" name="submit2" id="subCash" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                        </div>
                    </div>
                </form>
                <div id="bouttonOrangeMoney" style="display: none;">
                    <div class="form-group cashsubmit payment  right-six col-md-12">
						<button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit2" id="interfaceOrangemoney" class="btn btn-info row pull-right"><?php echo lang('submit_continuer'); ?></button>
                    </div>
                </div>
                <code id="prestationID" class="flash_message" style="display:none">Veuillez selectionner au moins une prestation</code>
                </div>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="myModaldeposithisto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                </div>
                <div class="modal-body">

                    <table class="table table-hover progress-table " id="editable-samples">
                        <thead>
                            <tr>
                                <th class=""><?php echo lang('date'); ?></th>
                                <th class=""><?php echo lang('deposit'); ?></th>
                                <th class=""><?php echo lang('deposit_type'); ?></th>
                                <th class=""><?php echo lang('effectuer_par'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="bdoy">


                        </tbody>

                    </table>


                    <div class="form-group modal-header">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                    </div>


                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<style>
    @media print {

        .modal-content {
            width: 100%;
        }


        .modal {
            overflow: hidden;
        }
    }
</style>


<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/paiement.js?<?php echo time(); ?>"></script>
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>
<script>
    var autoNumericInstance = new AutoNumeric.multiple('.money', {
        // currencySymbol: "Fcfa",
        // currencySymbolPlacement: "s",
        // emptyInputBehavior: "min",
        // selectNumberOnly: true,
        // selectOnFocus: true,
        overrideMinMaxLimits: 'invalid',
        emptyInputBehavior: "min",
        maximumValue: '100000',
        minimumValue: "0",
        decimalPlaces: 0,
        decimalCharacter: ',',
        digitGroupSeparator: '.'
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".editbutton").click(function(e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#editDepositform').trigger("reset");
            $.ajax({
                url: 'finance/editDepositbyJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                // Populate the form fields with the data returned from server
                if (response.deposit.deposit_type != 'Card') {
                    $('#editDepositform').find('[name="id"]').val(response.deposit.id).end()
                    $('#editDepositform').find('[name="patient"]').val(response.deposit.patient).end()
                    $('#editDepositform').find('[name="payment_id"]').val(response.deposit.payment_id).end()
                    $('#editDepositform').find('[name="date"]').val(response.deposit.date).end()
                    $('#editDepositform').find('[name="deposited_amount"]').val(response.deposit.deposited_amount).end()

                    $('#myModal2').modal('show');

                } else {
                    alert('Payement Processed By Card can not be edited. Thanks.')
                }
            });
        });

        $(".depositbutton").click(function(e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var patient = $(this).attr('data-patient');
            var payment = $(this).attr('data-payment');
            var payment2 = $(this).attr('data-payment2');

            $('#myModaldeposit2').trigger("reset");
            $('#myModaldeposit2').modal('show');

            var amount_received = $(this).attr('data-amount_received');
            var gross_total = $(this).attr('data-gross_total');
            var reste = gross_total - amount_received;
            $('#myModaldeposit2').find('[id="reste"]').html(reste).end();
            $('#myModaldeposit2').find('[id="reste1"]').html(reste).end();

            var option1 = new Option(payment2, payment, true, true);
            $('#myModaldeposit2').find('[name="paymentid"]').empty().append(option1).trigger('change');
        });

        $(".depositbuttonhisto").click(function(e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var patient = $(this).attr('data-patient');
            var payment = $(this).attr('data-payment');
            $.ajax({
                url: 'finance/listeDepositbyJason?payment=' + payment,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                var html = '';
                if (response) {
                    html += response;

                } else {
                    html += 'Historique vide.';
                }

                $('#myModaldeposithisto').trigger("reset");
                $('#myModaldeposithisto').modal('show');



                $('#myModaldeposithisto').find('[id="bdoy"]').html(html).end();
            });


        });
    });
</script>



<script>
    $(document).ready(function() {
        $('.card').hide();
        $(document.body).on('change', '#selecttype', function() {

            var v = $("select.selecttype option:selected").val()
            if (v == 'Card') {
                $('.card').show();
                $('.cardsubmit').removeClass('hidden');
                $('.cashsubmit').addClass('hidden');
            } else {
                $('.card').hide();
                $('.cashsubmit').removeClass('hidden');
                $('.cardsubmit').addClass('hidden');
            }
        });

        $("#interfaceOrangemoney").click(function(e) {
            $.ajax({
            url: 'finance/depotom',
            method: 'POST',
            data: '',
            dataType: 'json',
            }).success(function (response) {

            });
       // window.location.href = 'finance/depotOM';
        });


    });
</script>



<script>
    $(document).ready(function() {
        $(".flashmessage").delay(3000).fadeOut(100);
    });

    
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>


<script>
    $('#download').click(function() {
        var pdf = new jsPDF('p', 'pt', 'letter');
        pdf.addHTML($('#invoice'), function() {
            pdf.save('invoice.pdf');
        });
    });

    function recuperationDepot(event){
        var amount = $('#deposited').val();
        var amountFormat = amount.replace(/[^\d]/g, '');
        amountFormat = parseInt(amountFormat);
        document.getElementById('deposited_amount').value = amountFormat;
        var reste = document.getElementById("reste").innerHTML;
        reste = parseInt(reste);
        var bt = document.getElementById('interfaceOrangemoney');
        var btCash = document.getElementById('subCash');
        var errorDepotCash = document.getElementById('errorDepotCash');
        errorDepotCash.style.display = 'none';
        bt.disabled = false;
        btCash.disabled = false;
        if(amountFormat > reste ){
            bt.disabled = true;
            btCash.disabled = true;
            errorDepotCash.style.display = 'block';
        }
         

    }
    // This code is collected but useful, click below to jsfiddle link.
</script>