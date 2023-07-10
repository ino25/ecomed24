<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="">
            <header class="panel-heading">
                <?php
                if (!empty($payment->id))
                    echo lang('edit_payment');
                else
                    echo lang('add_new_payment2');
                ?>
            </header>
            <div class="">   <input type="hidden" value="0" id="choicepartenaire" name="choicepartenaire" />
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <!--  <div class="col-lg-12"> -->
                        <div class="">
                            <!--   <section class="panel"> -->
                            <section class="">
                                <!--   <div class="panel-body"> -->
                                <div class="">
                                    <style>
                                        .payment {
                                            padding-top: 10px;
                                            padding-bottom: 0px;
                                            border: none;

                                        }

                                        .pad_bot {
                                            padding-bottom: 5px;
                                        }

                                        form {

                                            padding: 15px 0px;
                                        }

                                        .modal-body form {
                                            background: #fff;
                                            padding: 21px;
                                        }

                                        .remove {
                                            width: 20%;
                                            float: right;
                                            margin-bottom: 10px;
                                            padding: 10px;
                                            height: 39px;
                                            text-align: center;
                                            border-bottom: 1px solid #f1f1f1;
                                        }

                                        .remove1 {

                                            float: left;
                                            margin-bottom: 10px;
                                            border-bottom: 1px solid #f1f1f1;
                                        }

                                        form input {
                                            border: none;
                                        }

                                        .pos_box_title {
                                            border: none;
                                        }
                                          .payment_label {
                                            text-align: left !important;
                                        }
                                    </style>

                                    <form role="form" id="editPaymentForm" class="clearfix" action="finance/addPayment" method="post" enctype="multipart/form-data">

                                        <div class="col-md-5 row">
                                            <!--
                                            <div class="pull-right">
                                                <a data-toggle="modal" href="#myModal">
                                                    <div class="btn-group">
                                                        <button id="" class="btn green">
                                                            <i class="fa fa-plus-circle"></i> <?php echo lang('register_new_patient'); ?>
                                                        </button>
                                                    </div>
                                                </a>
                                            </div>
                                            -->

                                            <!--
                                            <div class="col-md-8 payment pad_bot">
                                                <div class="col-md-3 payment_label"> 
                                                    <label for="exampleInputEmail1"><?php echo lang('date'); ?> </label>
                                                </div>
                                                <div class="col-md-9"> 
                                                    <input type="text" class="form-control  default-date-picker" name="date" id="" value='<?php
                                                                                                                                            if (!empty($payment->date)) {
                                                                                                                                                echo date('d-m-Y');
                                                                                                                                            } else {
                                                                                                                                                echo date('d-m-Y');
                                                                                                                                            }
                                                                                                                                            ?>' placeholder=" ">
                                                </div>

                                            </div>
                                            -->

                                            <div class="col-md-12 payment pad_bot panel">
                                                <label for="exampleInputEmail1"><?php echo lang('patient'); ?> <?php echo lang('name'); ?></label>
                                                <input class="form-control m-bot15" type="text" value="<?php echo $patient->name . ' ' . $patient->last_name . ' (' . $patient->patient_id . ') '; ?>" readonly>
                                                <input type="hidden" name="patient" value="<?php echo $patient->id; ?>">
                                                <input type="hidden" id="pos_select" value="<?php echo $patient->id; ?>">

                                            </div>

                                            <div class="info-mutuelle col-md-12 "></div>

                                            <div class="col-md-12 payment pad_bot liste_service">
                                                <label for="exampleInputEmail1"> <?php echo lang('service'); ?></label>
                                                <select class="form-control m-bot15  add_service" id="add_service" name="service" required="">

                                                </select>
                                                <code id="serviceID" class="flash_message" style="display:none">Veuillez selectionner un service</code>
                                            </div>

                                            <div class="col-md-12 payment">
                                                <div class="form-group last">
                                                    <label for="exampleInputEmail1"> <?php echo lang('select'); ?></label>
                                                    <select name="category_name[]" id="" class="multi-select" multiple="" id="my_multi_select3">

                                                    </select>
                                                </div>

                                            </div>



                                        </div>


                                        <div class="col-md-7">
                                            <div class="col-md-12 qfloww" id="qfloww">
                                                <label class=" col-md-4 remove1"><?php echo lang('procedures') ?></label>
                                                <label class=" col-md-2 remove pull-left"><?php echo lang('price_init') ?></label>
                                                <label class=" col-md-3 remove pull-left"><?php echo lang('charge_mutuelless') ?></label>
                                                <label class=" col-md-2 remove pull-right"><?php echo lang('price_final') ?></label>
                                                <div class="col-md-12 qfloww2">
                                                </div>
                                            </div>

                                            <div class="col-md-12-">
                                                <div class="col-md-12- right-six-">
                                                    <div class="col-md-12 payment- right-six-">
                                                        <div class="payment_label">
                                                            <label for="exampleInputEmail1"><?php echo lang('sub_total'); ?> <?php echo $settings->currency; ?></label>
                                                        </div>
                                                        <div class="">
                                                            <input type="number" class="form-control pay_in" name="subtotal" id="subtotal" value='<?php
                                                                                                                                                    if (!empty($payment->amount)) {

                                                                                                                                                        echo $payment->amount;
                                                                                                                                                    }
                                                                                                                                                    ?>' placeholder=" " disabled>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-12 payment right-six">
                                                        <div class="payment_label">
                                                            <label for="exampleInputEmail1"><?php echo lang('nom_mutuelle'); ?> </label>
                                                        </div>
                                                        <div class="">
                                                            <input type="text" class="form-control pay_in" name="remarks" id="remarks" value='<?php
                                                                                                                                                if (!empty($payment->remarks)) {

                                                                                                                                                    echo $payment->remarks;
                                                                                                                                                }
                                                                                                                                                ?>' placeholder=" " readonly="">
                                                        </div>

                                                    </div>
                                                    <div class="col-md-12 payment right-six">
                                                        <div class="payment_label">
                                                            <label for="exampleInputEmail1"><?php echo lang('charge_mutuelless'); ?> <?php echo $settings->currency; ?><?php
                                                                                                                                                                        if ($discount_type == 'percentage') {
                                                                                                                                                                            echo ' (%)';
                                                                                                                                                                        }
                                                                                                                                                                        ?> </label>
                                                        </div>
                                                        <div class="">
                                                            <input type="number" class="form-control pay_in" name="charge_mutuelle" id="charge_mutuelle" value='<?php
                                                                                                                                                                if (!empty($payment->discount)) {
                                                                                                                                                                    $discount = explode('*', $payment->discount);
                                                                                                                                                                    echo $discount[0];
                                                                                                                                                                } else {
                                                                                                                                                                    echo 0;
                                                                                                                                                                }
                                                                                                                                                                ?>' placeholder="" readonly="">
                                                        </div>

                                                    </div>
                                                    <div class="col-md-12 payment right-six">
                                                        <div class="payment_label">
                                                            <label for="exampleInputEmail1"><?php echo lang('discount'); ?> <?php echo $settings->currency; ?><?php
                                                                                                                                                                if ($discount_type == 'percentage') {
                                                                                                                                                                    echo ' (%)';
                                                                                                                                                                }
                                                                                                                                                                ?> </label>
                                                        </div>
                                                        <div class="">
                                                            <input type="number" class="form-control pay_in" name="discount" id="dis_id" value='<?php
                                                                                                                                                if (!empty($payment->discount)) {
                                                                                                                                                    $discount = explode('*', $payment->discount);
                                                                                                                                                    echo $discount[0];
                                                                                                                                                }
                                                                                                                                                ?>' placeholder="" autocomplete="off">
                                                        </div>

                                                    </div>

                                                    <div class="col-md-12 payment right-six">
                                                        <div class="payment_label">
                                                            <label for="exampleInputEmail1"><?php echo lang('gross_total'); ?> <?php echo $settings->currency; ?></label>
                                                        </div>
                                                        <div class="">
                                                            <input type="number" class="form-control pay_in" name="grsss" id="gross" value='<?php
                                                                                                                                            if (!empty($payment->gross_total)) {

                                                                                                                                                echo $payment->gross_total;
                                                                                                                                            }
                                                                                                                                            ?>' placeholder=" " disabled>
                                                        </div>

                                                    </div>
                                                    <?php if (empty($payment->id)) { ?>
                                                        <div class="col-md-12 payment right-six actePro" style="display: block">
                                                            <div class="payment_label">
                                                                <label for="exampleInputEmail1"><?php echo lang('deposit_type'); ?></label>
                                                            </div>
                                                            <div class="">
                                                                <select class="form-control m-bot15 js-example-basic-single selecttype" id="selecttype" name="deposit_type" value='' onchange="caisseUpdate(event)">
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
                                                    <?php } ?>
                                                    <div class="col-md-12 payment right-six actePro" style="display: block">
                                                        <div class="payment_label">
                                                            <label for="exampleInputEmail1"><?php
                                                                                            if (empty($payment)) {
                                                                                                echo lang('deposited_amount');
                                                                                            } else {
                                                                                                echo lang('deposit') . ' 1 <br>';
                                                                                                echo date('d/m/Y', $payment->date);
                                                                                            };
                                                                                            ?> </label>
                                                        </div>
                                                        <div id="visibleamount_received">
                                                            <input type="number" class="form-control" name="amount_received" id="amount_received" value='<?php
                                                                                                                                                            if (!empty($payment->amount_received)) {

                                                                                                                                                                echo $payment->amount_received;
                                                                                                                                                            }
                                                                                                                                                            ?>' placeholder=" " <?php
                                                                                                                                                                                if (!empty($payment->deposit_type)) {
                                                                                                                                                                                    if ($payment->deposit_type == 'Card') {
                                                                                                                                                                                        echo 'readonly';
                                                                                                                                                                                    }
                                                                                                                                                                                }
                                                                                                                                                                                ?>>
                                                        </div>
                                                        <div id="cacheamount_received" style="display:none">
                                                            <input type="text" class="form-control money" name="amount_receivedID" id="amount_receivedIDNone" value='<?php
                                                                                                                                                                        if (!empty($payment->amount_received)) {

                                                                                                                                                                            echo $payment->amount_received;
                                                                                                                                                                        }
                                                                                                                                                                        ?>' placeholder=" " <?php
                                                                                                                                                                                            if (!empty($payment->deposit_type)) {
                                                                                                                                                                                                if ($payment->deposit_type == 'Card') {
                                                                                                                                                                                                    echo 'readonly';
                                                                                                                                                                                                }
                                                                                                                                                                                            }
                                                                                                                                                                                            ?>>
                                                        </div>
                                                        <code id="amount_receivedID" class="flash_message" style="display:none">Veuillez saisir le montant du dépôt</code>
                                                        <code id="montantID" class="flash_message" style="display:none">Cette valeur doit être comprise entre 100 et 100.000 FCFA</code>
                                                    </div>



 <?php 
 $page = '';
 if(isset($_GET['page'])){
          $page = $_GET['page'];                                           
 } ?>
<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                                                    <div class="form-group cashsubmit payment  right-six col-md-12" id="bouttonSuivant">
                                                       <?php if($page == 'patient'){  ?>
                                                        <a href="patient/medicalHistory?id=<?php echo $patient->id; ?>&type=payment" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></a>
                                                      <?php } else if($page == 'historique'){ ?>
                                                          <a href="finance/patientPaymentHistory?patient=<?php echo $patient->id; ?>" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></a>
                                                       
 <?php } else { ?>
                                                          <a href="finance/payment" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></a>
                                                        <?php } ?>
                                                        <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                                                    </div>
                                                    <div class="form-group cardsubmit  right-six col-md-12 hidden">
                                                        <button type="submit" name="pay_now" id="submit-btn" class="btn btn-info row pull-right" <?php if ($settings->payment_gateway == 'Stripe') { ?>onClick="stripePay(event);" <?php }                              ?>> <?php echo lang('submit'); ?></button>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>












                                        <!--
                                        <div class="col-md-12 payment">
                                            <div class="col-md-3 payment_label"> 
                                              <label for="exampleInputEmail1">Vat (%)</label>
                                            </div>
                                            <div class="col-md-9"> 
                                              <input type="text" class="form-control pay_in" name="vat" id="exampleInputEmail1" value='<?php
                                                                                                                                        if (!empty($payment->vat)) {
                                                                                                                                            echo $payment->vat;
                                                                                                                                        }
                                                                                                                                        ?>' placeholder="%">
                                            </div>
                                        </div>
                                        -->

                                        <input type="hidden" name="id" value='<?php
                                                                                if (!empty($payment->id)) {
                                                                                    echo $payment->id;
                                                                                }
                                                                                ?>'>
                                        <div class="row">
                                        </div>
                                        <div class="form-group">
                                        </div>

                                </div>
                                </form>

                                <div class="col-md-7 row pull-right" id="bouttonOrangeMoney" style="display: none;">
                                    <div class="form-group">
                                        <table style="width:100%">
                                            <tr>
                                                <th style="width: 80%;">
                                                    <a href="finance/payment" class="btn btn-info btn-secondary"> <?php echo lang('close'); ?></a>
                                                </th>
                                                <th style="width: 20%;">
                                                    <button id="interfaceOrangemoney" name="submit2" id="submit1" class="btn btn-info row"> <?php echo lang('submit_continuer'); ?></button>
                                                </th>
                                            </tr>
                                        </table>
                                    </div>
                                    <code id="prestationID" class="flash_message" style="display:none">Veuillez selectionner au moins une prestation</code>
                                </div>
                                <div class="panel-body" id="confirmation" style="display: none;">
                                    <div class="adv-table editable-table ">
                                        <div class="clearfix">
                                            <div class="col-lg-12">
                                                <div class="no-print">
                                                    <div class="adv-table editable-table">
                                                        <div class="clearfix">
                                                            <style>
                                                                .clearfix {
                                                                    padding-top: 10px;
                                                                    padding-bottom: 20px;
                                                                    border: none;

                                                                }


                                                                .petiteligne {
                                                                    font-size: 14px;
                                                                }

                                                                .grandeligne {
                                                                    font-size: 1.2em;
                                                                }
                                                            </style>
                                                            <!-- <label class="grandeligne">Vous êtes sur le point d’effectuer un paiement d'un montant de <span class="money" id="montantsubtotal"></span> à partir de votre compte Orange Money</label> -->
                                                            <div class="form-group col-md-7" style="margin-top: 10px;">
                                                                <label class="grandeligne">Veuillez saisir le numéro de compte orange money</label>
                                                            </div>
                                                            <div class="form-group col-md-6" style="margin-top: 10px;">
                                                                <label for="exampleInputEmail1">Numero compte orange money</label>
                                                                <input type="text" class="form-control" name="mobNo" id="mobNo" value="" placeholder="" pattern="[0-9]{9}" required autocompleted="off">
                                                                <code id="phoneID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>
                                                            </div>
                                                            <div class="form-group col-md-7">
                                                                <button id="validationOrange" type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit_continuer'); ?></button>
                                                                <button id="retourInterfaceActe" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" id="validationdepotorange" style="display:none;padding-top:30px">
                                    <label class="grandeligne">Le patient doit saisir le code USSD suivant sur son téléphone .</label>
                                    <label class="grandeligne">CODE USSD : <span id="msgussd"></span></label>
                                    <div class="form-group col-md-7" style="padding-top:20px">
                                        <label class="grandeligne">Entrer la référence OrangeMoney reçue par le patient et cliquer "Continuer"</label>
                                        <label for="exampleInputEmail1" style="padding-top: 10px;">Code de référence</label>
                                        <input type="text" class="form-control" name="mobRef" id="mobRef" value="" placeholder="" pattern="[0-9]{9}" required autocompleted="off" onkeyup="validation(event)">
                                        <code id="phoneID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>
                                    </div>
                                    <div class="form-group col-md-7">
                                        <button type="submit" id="rediriger" data-toggle="modal" href="#myModalPopup" data-backdrop="static" name="submit" class="btn btn-info pull-right"><?php echo lang('submit_continuer'); ?></button>
                                        <button id="retourConfirmation" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></button>
                                    </div>
                                </div>
                        </div>
                        <input hidden id="formCustmer" value="<?php echo !empty($id_partenaire_zuuluPay) ? $id_partenaire_zuuluPay : ""; ?>">
                        <input hidden id="PIN" value="<?php echo !empty($pin_decrypted) ? $pin_decrypted : ""; ?>">



                    </div>
        </section>
        </div>
        </div>
        </div>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="myModalPopup">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Paiement OrangeMoney</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <br>
            <div class="modal-body" style="padding-top: 15px;">
            <p>Nous validons le paiement du patient <strong><?php echo $patient->name . ' ' . $patient->last_name . ' (' . $patient->patient_id . ') '; ?></strong> d'un montant de <strong id="montantConfirmation"></strong></p>
                <p>Le traitement durera moins de 10 minutes. Nous vous notifions par SMS dès que ce sera terminé.</p>
            </div>
            <form role="form" class="clearfix" action="finance/addPaymentOM" method="post" enctype="multipart/form-data">
                <input hidden  type="text" name="refPatient" id="refPatient" value="">
                <input hidden type="text" name="refService" id="refService" value="">
                <input hidden type="text" name="list_id" id="list_id" value="">
                <input hidden type="text" name="refQuantity" id="refQuantity" value="1">
                <input hidden type="text" name="refSubtotal" id="refSubtotal" value="">
                <input hidden type="text" name="refDepot" id="refDepot" value="">
                <input hidden type="text" name="refChargeMutuelle" id="refChargeMutuelle" value="">
                <input hidden type="text" name="refRemarks" id="refRemarks" value="">
                <input hidden type="text" name="refGross" id="refGross" value="">
                <input hidden type="text" name="refDis_id" id="refDis_id" value="">
                <input hidden type="text" name="refSelecttype" id="refSelecttype" value="">
                <input hidden type="text" name="refPrestation" id="refPrestation" value="">
                <input hidden type="text" name="refMobRef" id="refMobRef" value="">
                <input hidden type="text" name="refNumOM" id="refNumOM" value="">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">OK</button>
                </div>
            </form>
            
        </div>
    </div>
</div>
    </section>

</section>
</section>
<!--main content end-->
<!--footer start-->

<!-- Add Patient Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Patient Registration</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="patient/addNew?redirect=payment" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Address</label>
                        <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Phone</label>
                        <input type="text" class="form-control" name="phone" id="exampleInputEmail1" value='' placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Image</label>
                        <input type="file" name="img_url">
                    </div>

                    <input type="hidden" name="id" value=''>

                    <section class="">
                        <button type="submit" name="submit" class="btn btn-info">Submit</button>
                    </section>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Patient Modal-->

<div class="modal fade" id="myModaladdPatient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title"> <?php echo lang('register_new_patient'); ?></h4>

            </div>
            <div class="modal-body row">
                <form role="form" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="name" value='' placeholder="" required="" min="2" max="100">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('last_name'); ?></label>
                        <input type="text" class="form-control" name="last_name" id="last_name" value='' placeholder="" required="" min="2" max="100">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('sex'); ?></label>
                        <select class="form-control" name="sex" id="sex" required="">
                            <option value=""></option>

                            <option value="Masculin" <?php
                                                        if (!empty($patient->sex)) {
                                                            if ($patient->sex == 'Masculin') {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?>> <?php echo lang('male'); ?> </option>
                            <option value="Feminin" <?php
                                                    if (!empty($patient->sex)) {
                                                        if ($patient->sex == 'Feminin') {
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?>> <?php echo lang('female'); ?></option>
                            <!--<option value="Autres" <?php
                                                        if (!empty($patient->sex)) {
                                                            if ($patient->sex == 'Autres') {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?> >  <?php echo lang('others'); ?></option>-->
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label><?php echo lang('birth_date'); ?></label>
                        <input class="form-control form-control-inline input-medium before_now" type="text" name="birthdate" id="birthdate" value="" placeholder="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('phone'); ?></label>
                        <input type="text" class="form-control" name="phone" id="phone" value='' placeholder="" min="2" max="50" required="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('email'); ?></label>
                        <input type="text" class="form-control" name="email" id="email" value='' placeholder="" min="2" max="100">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                        <input type="text" class="form-control" name="address" id="address" value='' placeholder="" min="2" max="500">
                    </div>
                    <div class="form-group col-md-6">
                        <label><?php echo lang('region'); ?></label>
                        <select class="form-control" name="region" id="region">
                            <option value=""></option>
                            <?php foreach ($regions as $value => $region) { ?>
                                <option value="<?php echo $region; ?>"> <?php echo $region; ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class=" col-md-12" style="background: #cccccc47;">
                        <div class=" col-md-6">
                            <label><?php echo lang('nom_mutuelle'); ?></label>
                            <select class="form-control" id="nom_mutuelle" name="nom_mutuelle"></select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo lang('num_police'); ?></label>
                            <input type="text" class="form-control form-control-inline input-medium" name="num_police" id="num_police" value=''>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo lang('charge_mutuelle'); ?> </label>
                            <input type="number" class="form-control form-control-inline input-medium" name="charge_mutuelle" id="charge_mutuelle_patient" value='' min="1" max="100">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo lang('date_valid'); ?></label>
                            <input type="text" class="form-control form-control-inline input-medium afert_now" name="date_valid" id="date_valid" value='' autocomplete="off">
                        </div>

                    </div>

                    <section class="col-md-12 form-group">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" id="createPatient" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                    </section>

                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>


<style>
    .patient {
        background: #fff;
        padding: 10px;
    }
</style>



<!--
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="vendor/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>common/js/ajaxrequest-codearistos.min.js"></script>-->

<script>
    $(document).ready(function() {
        $('.add_service').empty();
        var id = $('#pos_select').val();
        var opt = '';
        $('.multi-select').multiSelect('refresh');
        //$('.multi-select').multiSelect('select_all');
        $(".qfloww2").html("");
        $("#subtotal").val("0");
        $("#remarks").val("");
        $("#charge_mutuelle").val("0");
        $("#gross").val("0");
        $.ajax({
            url: 'finance/editMutuelleFinanceByJason?patient=' + id,
            method: 'GET',
            data: '',
            dataType: 'json',
            delai: 250
        }).success(function(response) {
            console.log(response);
            $('select.multi-select').empty();
            $('.info-mutuelle').empty();
            $('#remarks').val('');
            var tt = new Date();
            var now = tt.getTime();
            console.log('-----------response------------');
            console.log(response);
            var charge = 0;
            var is_assurrance = false;
            var remise = 0;
            if (response.lien_parente) {
                //secondaire
                var html = '<div class="">' + response.lien_parente + ' de ' + response.mutuelles_relationInit.name + ' ' + response.mutuelles_relationInit.last_name + '</div>';
                if (response.mutuellesInit) {
                    var datepm = response.mutuellesInit.pm_datevalid;
                    html += '<div class=""><b>Tiers payant: </b>' + response.mutuellesInit.nom + '</div>';
                    html += '<div class=""><b>Numero: </b>' + response.mutuellesInit.pm_numpolice + '</div>';
                    html += '<div class=""><b>Prise en charge %: </b>' + response.mutuellesInit.pm_charge + '</div>';
                    html += '<div class=""><b>Date de validite: </b>' + response.mutuellesInit.pm_datevalid + '</div>';
                    is_assurrance = true;
                    charge = response.mutuellesInit.pm_charge;
                    var parts = datepm.split("-");

                    var userEnteredDateISO = parts[2] + "-" + parts[1] + "-" + parts[0];
                    var userEnteredDateObj = new Date(userEnteredDateISO).getTime();
                    if (userEnteredDateObj < now) {
                        html += '<div class=""><b class="btn-danger">Date de validité est dépassée.</b></div>';
                    }
                    $('#remarks').val(response.mutuellesInit.nom);

                } else {
                    html += '<div class=""><b>Aucun Tiers payant.</b></div>';
                }

            } else {
                // pricipa
                var html = '<div class=""></div>';
                if (response.mutuelles) {
                    var datepm = response.mutuelles.pm_datevalid;
                    html += '<div class=""><b>Tiers payant: </b>' + response.mutuelles.nom + '</div>';
                    html += '<div class=""><b>Numero: </b>' + response.mutuelles.pm_numpolice + '</div>';
                    html += '<div class=""><b>Prise en charge %: </b>' + response.mutuelles.pm_charge + '</div>';
                    html += '<div class=""><b>Date de validite: </b>' + datepm + '</div>';

                    is_assurrance = true;
                    charge = response.mutuelles.pm_charge;

                    var parts = datepm.split("-");

                    var userEnteredDateISO = parts[2] + "-" + parts[1] + "-" + parts[0];
                    var userEnteredDateObj = new Date(userEnteredDateISO + "T00:00:00Z").getTime();
                    if (userEnteredDateObj < now) {
                        html += '<div class=""><b class="btn-danger">Date de validité est dépassée.</b></div>';
                    }
                    $('#remarks').val(response.mutuelles.nom);
                } else {
                    html += '<div class=""><b>Aucun Tiers payant.</b></div>';
                }



            }
            html += '<input type="hidden" id="charge" value="' + charge + '" />';
            var remise = 0;
            $('.info-mutuelle').append(html);

            $('.multi-select').multiSelect('refresh');
            console.log('-------------opt-------------');
            console.log(opt);
        });

    });
</script>
<script src="<?php echo base_url(); ?>common/js/paiement.js?<?php echo time(); ?>"></script>
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>
<script>
    function caisseUpdate(eventObj) {
        var bouttonSuivant = document.getElementById('bouttonSuivant');
        var bouttonOrangeMoney = document.getElementById('bouttonOrangeMoney');
        var cacheamount_received = document.getElementById('cacheamount_received');
        var visibleamount_received = document.getElementById('visibleamount_received');
        if (eventObj.target.value == 'OrangeMoney') {
            bouttonSuivant.style['display'] = 'none';
            visibleamount_received.style['display'] = 'none';
            cacheamount_received.style['display'] = 'block';
            bouttonOrangeMoney.style['display'] = 'block';
        } else {
            var bouttonSuivant = document.getElementById('bouttonSuivant');
            bouttonSuivant.style['display'] = 'block';
            bouttonOrangeMoney.style['display'] = 'none';
            cacheamount_received.style['display'] = 'none';
            visibleamount_received.style['display'] = 'block';
        }

    }
    $(document).ready(function() {
        var bt = document.getElementById('rediriger');
        bt.disabled = true;
        $("#interfaceOrangemoney").click(function(e) {
            var mobRef = $('#mobRef').val();
            var myElementValue = $('#pos_select').val();
            var subtotal = $('#subtotal').val();
            var charge_mutuelle = $('#charge_mutuelle').val();
            var dis_id = $('#dis_id').val();
            var remarks = $('#remarks').val();
            var gross = $('#gross').val();
            var amount_received = $('#amount_receivedIDNone').val();
            
            var liste_service = document.getElementById('add_service');
            var myElementService = liste_service.value;
            var serviceID = document.getElementById('serviceID');
            var prestationID = document.getElementById('prestationID');
            var amount_receivedID = document.getElementById('amount_receivedID');
            var montantID = document.getElementById('montantID');
            var amount = amount_received.replace(".", "").replace(".", "").replace(".", "");
            var listeselecttype = document.getElementById('selecttype');
            var textOptSelect = listeselecttype.options[listeselecttype.selectedIndex].text;
            // var prestation = document.getElementById('my_multi_select3');
            // var elementPrestation = prestation.value;
            serviceID.style['display'] = 'none';
            prestationID.style['display'] = 'none';
            amount_receivedID.style['display'] = 'none';
            montantID.style['display'] = 'none';
            var Formatamount_received = amount_received.replace(/[^\d]/g, '');
            Formatamount_received = formatCurrencyFacture(Formatamount_received);
       // alert(amount_received);
            if (myElementValue == '') {
                window.scrollTo(0, 0);
            } else if (myElementService == '') {
                serviceID.style['display'] = 'block';
                window.scrollTo(0, 0);
            } else if (subtotal == 0 && dis_id == 0) {
                prestationID.style['display'] = 'block';

            } else if (amount_received == 0) {
                amount_receivedID.style['display'] = 'block';

            } else if (amount < 100) {
                montantID.style['display'] = 'block';

            } else {
                window.scrollTo(0, 0);
                var editPaymentForm = document.getElementById('editPaymentForm');
                var confirmation = document.getElementById('confirmation');
                var bouttonOrangeMoney = document.getElementById('bouttonOrangeMoney');
                bouttonOrangeMoney.style['display'] = 'none';
                editPaymentForm.style['display'] = 'none';
                confirmation.style['display'] = 'block';
                document.getElementById('refPatient').value = myElementValue;
                document.getElementById('refService').value = myElementService;
                document.getElementById('refSubtotal').value = subtotal;
                document.getElementById('refDepot').value = amount;
                document.getElementById('refChargeMutuelle').value = charge_mutuelle;
                document.getElementById('refRemarks').value = remarks;
                document.getElementById('refGross').value = gross;
                document.getElementById('refDis_id').value = dis_id;
                document.getElementById('refSelecttype').value = textOptSelect;
                document.querySelector("#montantConfirmation").innerHTML = Formatamount_received;
                // document.getElementById('refPrestation').value = elementPrestation;


            }


        });
        $("#retourInterfaceActe").click(function(e) {
            var editPaymentForm = document.getElementById('editPaymentForm');
            var confirmation = document.getElementById('confirmation');
            var bouttonOrangeMoney = document.getElementById('bouttonOrangeMoney');
            bouttonOrangeMoney.style['display'] = 'block';
            editPaymentForm.style['display'] = 'block';
            confirmation.style['display'] = 'none';
        });

        $("#validationOrange").click(function(e) {
            var editPaymentForm = document.getElementById('editPaymentForm');
            var errorphone = document.getElementById('phoneID');
            var formCustmer = $('#formCustmer').val();
            var validationdepotorange = document.getElementById('validationdepotorange');
            var pin = $('#PIN').val();
            var phone = $('#mobNo').val();
            var amount = $('#amount_receivedIDNone').val();
            amount = amount.replace(".", "").replace(".", "").replace(".", "");
            var phoneFormat = phone.replace(/[^\d]/g, '');
            var nbreCaratere = phoneFormat.length;
            errorphone.style['display'] = 'none';
            if (nbreCaratere != 12) {
                errorphone.style['display'] = 'block';
            } else {
                confirmation.style['display'] = 'none';
                validationdepotorange.style['display'] = 'block';
                // alert("fr" + amount + phoneFormat + formCustmer + pin)
                document.getElementById('refNumOM').value = phoneFormat;
                var reponseAll = paiementOrangeMoney("fr", amount, phoneFormat, formCustmer, pin);


            }
        });
        $("#retourConfirmation").click(function(e) {
            var editPaymentForm = document.getElementById('editPaymentForm');
            var validationdepotorange = document.getElementById('validationdepotorange');
            var confirmation = document.getElementById('confirmation');
            editPaymentForm.style['display'] = 'none';
            validationdepotorange.style['display'] = 'none';
            confirmation.style['display'] = 'block';
        });

        $("#rediriger").click(function(e) {

            var subtotal = $('#subtotal').val();
            var charge_mutuelle = $('#charge_mutuelle').val();
            var amount_received = $('#amount_receivedIDNone').val();
            var liste = document.getElementById('pos_select');
            var myElementValue = liste.value;
            var liste_service = document.getElementById('add_service');
            var myElementService = liste_service.value;
            var textOptSelect = liste.options[liste.selectedIndex].text;
            var phone = $('#mobNo').val();
            var idcategory = $('#list_id').val();
            document.querySelector("#textOptSelect").innerHTML = textOptSelect;
            var prestation = document.getElementById('my_multi_select3');
            var elementPrestation = prestation.value;
            amount = amount_received.replace(".", "").replace(".", "").replace(".", "");
            //  alert("le prix total " + subtotal + " prise en charge " + charge_mutuelle + " le montant du depot " + amount_received + " le numero patient " + myElementValue + " le numero service " + myElementService + " le detail du patient " + textOptSelect + " les prestations " + elementPrestation + " idprestation " + idcategory);
            $.ajax({
                url: 'finance/addpaymentom?amount_received=' + amount,
                method: 'POST',
                data: '',
                dataType: 'json',
            }).success(function(response) {

            });
            // var mobRef = $('#mobRef').val();
            // var bt = document.getElementById('rediriger');
            // bt.disabled = true;
            // var phoneFormat = phone.replace(/[^\d]/g, '');
            // amount = amount.replace(".", "").replace(".", "").replace(".", "");
            // var type = 'depot';
            // var description = 'Dépôt Orange Money';
            // var statut = 'PENDING';
            // var destinataire = 'Compte Service';
            // $.ajax({
            //     url: 'depot/confirmationorangemoney?amount=' + amount + '&phone=' + phoneFormat + '&type=' + type + '&description=' + description + '&statut=' + statut + '&destinataire=' + destinataire + '&reference=' + mobRef,
            //     method: 'POST',
            //     data: '',
            //     dataType: 'json',
            // }).success(function (response) {

            // });
            // window.location.href = 'depot/operationFinanciere';
        });


    });
</script>
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
<script>
    var element = document.getElementById('mobNo');
    var ref = document.getElementById('mobRef');
    var maskOptions = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var patternMask = IMask(ref, {
        mask: '{PP}000000.0000.[a]00000',
        lazy: false,
    });
    var mask = IMask(element, maskOptions);
    mask.value = "{-- --- -- --";
    var el = IMask(ref, patternMask);
    el.value = "{------ ---- ------";
    //alert(element);

    function formatCurrencyFacture(number) {
        return (number || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' FCFA';
    }

    function validation(event) {
        var bt = document.getElementById('rediriger');
        bt.disabled = true;
        var phone = $('#mobNo').val();
        var amount = $('#amount_received').val();
        var mobRef = $('#mobRef').val();
        var phoneFormat = phone.replace(/[^\d]/g, '');
        amount = amount.replace(".", "").replace(".", "").replace(".", "");
        var type = 'depot';
        var description = 'Dépôt Orange Money';
        var statut = 'PENDING';
        var destinataire = 'Compte Service';
        var nbreCaratere = phoneFormat.length;
        var ref = /PP\d{6}\.\d{4}\.[A-Z]\d{5}/.test(mobRef);
        if (ref == true) {
            bt.disabled = false;
            document.getElementById('refMobRef').value = mobRef;
        } else {
            bt.disabled = true;
        }
    }
</script>