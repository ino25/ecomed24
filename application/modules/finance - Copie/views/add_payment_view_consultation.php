<style>
    .ui-widget.ui-widget-content {
        display: none !important;
    }
</style>


<?php
$current_user = $this->ion_auth->get_user_id();
if ($this->ion_auth->in_group('Doctor')) {
    $doctor_id = $this->db->get_where('doctor', array('ion_user_id' => $current_user))->row()->id;
    $doctordetails = $this->db->get_where('doctor', array('id' => $doctor_id))->row();
}
if ($this->ion_auth->in_group('adminmedecin')) {
    $doctor_id = $this->db->get_where('adminmedecin', array('ion_user_id' => $current_user))->row()->id;
    $adminmedecindetails = $this->db->get_where('adminmedecin', array('id' => $doctor_id))->row();
}
?>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="">
            <header class="panel-heading" style="margin-top:41px;">
                <h2>
                    <?php
                    if (!empty($payment->id))
                        echo "Demande Analyse";
                    else
                        echo "Demande Analyse";

                    $patient_id = '';
                    if (isset($_GET['patient'])) {
                        $patient_id = $_GET['patient'];
                    }
                    $type = '';
                    if (isset($_GET['typetraitance'])) {
                        $type = $_GET['typetraitance'];
                    }
                    $partenaire = '';
                    if (isset($_GET['partenairetraitance'])) {
                        $partenaire = $_GET['partenairetraitance'];
                    }
                    ?>
                </h2>
            </header>
            <div class="">
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
                                            /* padding-top: 10px;*/
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
                                            /* width: 20%;*/
                                            float: right;
                                            margin-bottom: 10px;
                                            padding: 10px;
                                            height: 39px;
                                            text-align: center;
                                            border-bottom: 1px solid #f1f1f1;
                                        }

                                        .remove1 {
                                            /* width: 80%;*/
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
                                            text-align: left;
                                        }
                                    </style>
                                    <form role="form" id="editPaymentForm" class="clearfix" action="finance/addPaymentConsultation" method="post" enctype="multipart/form-data">
                                        <input type="hidden" class="form-control pay_in" name="consultation" value='1'>
                                        <input type="hidden" class="form-control pay_in" name="nameHeader" value="BULLETIN D'ANALYSE">

                                        <div class="col-md-12 thumbnail row">


                                            <div style="display: none;">
                                                <div class="col-md-6 payment pad_bot" id="organisation">
                                                    <input type="checkbox" value="0" id="choicepartenaire" name="choicepartenaire" />
                                                    <label for="exampleInputEmail1"> <?php echo lang('choicepartenaire'); ?></label>
                                                </div>
                                                <div class="col-md-6 payment pad_bot" id="light">
                                                    <input type="checkbox" value="0" id="choicepartenaire_light" name="choicepartenaire_light" />
                                                    <label for="exampleInputEmail1"> <?php echo lang('choicepartenaire_light'); ?></label>
                                                </div>

                                                <div class="col-md-12 payment pad_bot liste_partenaire " id="liste_partenaire" style="display: none">
                                                    <label for="exampleInputEmail1"> <?php echo lang('partenaire'); ?></label>
                                                    <select id="spartenaire" name="partenaire">

                                                    </select>
                                                </div>

                                                <div class="col-md-12 payment pad_bot liste_partenaire_light " id="liste_partenaire_light" style="display: none">
                                                    <label for="exampleInputEmail1"> <?php echo lang('partenaire'); ?></label>
                                                    <select class="form-control m-bot16" id="lightpartenaire" name="lightpartenaire">

                                                    </select>
                                                </div>

                                            </div>

                                            <div class="col-md-4 payment pad_bot">
                                                <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                                                <select class="form-control m-bot15  pos_select" id="pos_select" name="patient" value='' <?php if ($patient_id) { ?> readonly <?php } ?>>

                                                </select>
                                                <code id="patientID" class="flash_message" style="display:none">Veuillez selectionner un patient</code>

                                            </div>
                                            <?php if ($this->ion_auth->in_group(array('Doctor', 'adminmedecin', 'Biologiste'))) { ?>
                                                <div class="form-group col-md-4">
                                                    <label for="exampleInputEmail1"> <?php echo lang('prinscritor'); ?></label>

                                                    <input type="hidden" name="doctor" id="doctorchoos" value='<?php echo $this->ion_auth->user()->row()->id; ?>'>
                                                    <input type="text" class="form-control" name="" id="" value='DR <?php echo $this->ion_auth->user()->row()->first_name . ' ' . $this->ion_auth->user()->row()->last_name; ?>' readonly="">

                                                </div>
                                            <?php } else { ?>
                                                <div class="col-md-4 payment pad_bot">
                                                    <label for="exampleInputEmail1"><?php echo lang('prinscritor'); ?></label>
                                                    <select class="form-control m-bot15 doctorchoose" id="doctorchoose" name="doctor" value=''>
                                                        <?php if (!empty($prescription->doctor)) { ?>
                                                            <option value="<?php echo $doctors->id; ?>" selected="selected"><?php echo $doctors->name; ?> - (<?php echo lang('id'); ?> : <?php echo $doctors->id; ?>)</option>
                                                        <?php } ?>
                                                    </select>

                                                </div>
                                            <?php } ?>

                                            <div class="col-md-4 payment pad_bot liste_service">
                                                <label for="exampleInputEmail1"> <?php echo lang('service'); ?></label>
                                                <select class="form-control m-bot15  add_service" id="add_service" name="service" value=''>

                                                </select>
                                                <code id="serviceID" class="flash_message" style="display:none">Veuillez selectionner un service</code>
                                            </div>
                                            <div class="info-mutuelle col-md-12 " style="margin:15px;text-align: center;"></div>


                                            <div class="col-md-3  payment">
                                                <div class="form-group last">
                                                    <label for="exampleInputEmail1"> <?php echo lang('select'); ?></label>
                                                    <select name="category_name[]" class="multi-select" multiple="" id="my_multi_select3">
                                                        <option>
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-9 qfloww left0" id="qfloww">
                                                <label class=" col-md-10 remove1_">SERVICE > PRESTATION</label>
                                                <label class=" col-md-2 remove pull-right"></label>
                                                <div class="col-md-12_ qfloww2">
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display: none;">
                                            <div class="col-md-12-">
                                                <div class="col-md-12- right-six-">
                                                    <div class="col-md-12 payment- right-six-  actePro" style="display: block">
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
                                                    <div class="col-md-12 payment right-six actePro" style="display: block">
                                                        <div class="payment_label">
                                                            <label for="exampleInputEmail1"><?php echo lang('nom_mutuelle'); ?> </label>
                                                        </div>
                                                        <div class="">
                                                            <input type="text" class="form-control pay_in" name="remarks" id="remarks" value='<?php
                                                                                                                                                if (!empty($payment->remarks)) {




                                                                                                                                                    echo $payment->remarks;
                                                                                                                                                }
                                                                                                                                                ?>' placeholder=" " readonly="">
                                                            <input type="hidden" class="form-control pay_in" name="remarksId" id="remarksId" value='<?php
                                                                                                                                                    if (!empty($payment->remarksId)) {

                                                                                                                                                        echo $payment->remarksId;
                                                                                                                                                    }
                                                                                                                                                    ?>' placeholder=" " readonly="">
                                                            <input type="hidden" class="form-control pay_in" name="remarksType" id="remarksType" value='<?php
                                                                                                                                                        if (!empty($payment->remarksType)) {

                                                                                                                                                            echo $payment->remarksType;
                                                                                                                                                        }
                                                                                                                                                        ?>' placeholder=" " readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 payment right-six actePro" style="display: block">
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
                                                    <div class="col-md-12 payment right-six actePro" style="display: block">
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
                                                                                                                                                ?>' placeholder="" autocomplete="off" readonly>
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
                                                    <div id="light_depot">
                                                        <?php if (empty($payment->id)) { ?>
                                                            <!-- <div class="col-md-12 payment right-six actePro" style="display: block">-->
                                                            <div class="col-md-12 payment right-six" style="display: block">
                                                                <!-- <div class="payment_label">
                                                                    <label for="exampleInputEmail1"><?php echo lang('deposit_type'); ?></label>
                                                                </div> -->
                                                                <div style="display: none;">
                                                                    <select class="form-control m-bot15 js-example-basic-single selecttype" id="selecttype" name="deposit_type" value='' onchange="caisseUpdate(event)">
                                                                        <?php // if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist'))) { 
                                                                        ?>
                                                                        <option value="Cash"> <?php echo lang('cash'); ?> </option>
                                                                        <option value="OrangeMoney"> <?php echo lang('orange_money'); ?> </option>
                                                                        <option value="zuulupay" disabled=""> <?php echo lang('zuulupay'); ?> </option>
                                                                        <option value="" disabled=""> <?php echo lang('carte_bancaire'); ?> </option>
                                                                        <option value="" disabled=""> <?php echo lang('demande'); ?> </option>
                                                                        <?php // } 
                                                                        ?>

                                                                    </select>
                                                                </div>



                                                            </div>
                                                        <?php } ?>
                                                        <!--<div class="col-md-12 payment right-six actePro" style="display: block">-->
                                                        <div class="col-md-12 payment right-six" style="display: block">
                                                            <!-- <div class="payment_label">
                                                                <label for="exampleInputEmail1"><?php
                                                                                                if (empty($payment)) {
                                                                                                    echo lang('deposited_amount');
                                                                                                } else {
                                                                                                    echo lang('deposit') . ' 1 <br>';
                                                                                                    echo date('d/m/Y', $payment->date);
                                                                                                };
                                                                                                ?> </label>
                                                            </div> -->
                                                            <div id="visibleamount_received" style="display: none;">
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
                                                                                                                                                                                    ?> onkeyup="depotcash(event)" readonly>
                                                            </div>
                                                            <code id="errorDepotCash" class="flash_message" style="display:none">Le montant est superieur au montant dû</code>
                                                        </div>
                                                        <div class="col-md-12 payment right-six" id="cacheamount_received" style="display:none">
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
                                                                                                                                                                                            ?> onkeyup="depotOM(event)">

                                                            <code id="errorDepotOM" class="flash_message" style="display:none">Le depôt est superieur au montant dû</code>
                                                            <code id="amount_receivedID" class="flash_message" style="display:none">Veuillez saisir le montant du dépôt</code>
                                                            <code id="montantID" class="flash_message" style="display:none">Cette valeur doit être comprise entre 100 et 100.000 FCFA</code>
                                                        </div>

                                                    </div>

                                                    <?php
                                                    if (!empty($payment)) {
                                                        $deposits = $this->finance_model->getDepositByPaymentId($payment->id);
                                                        $i = 1;
                                                        foreach ($deposits as $deposit) {

                                                            if (empty($deposit->amount_received_id)) {
                                                                $i = $i + 1;
                                                    ?>
                                                                <div class="col-md-12 payment right-six">
                                                                    <div class="payment_label">
                                                                        <label for="exampleInputEmail1"><?php echo lang('deposit'); ?> <?php
                                                                                                                                        echo $i . '<br>';
                                                                                                                                        echo date('d/m/Y', $deposit->date);
                                                                                                                                        ?>
                                                                        </label>
                                                                    </div>
                                                                    <div class="">
                                                                        <input type="text" class="form-control pay_in" name="deposit_edit_amount[]" id="amount_received" value='<?php echo $deposit->deposited_amount; ?>' <?php
                                                                                                                                                                                                                            if ($deposit->deposit_type == 'Card') {
                                                                                                                                                                                                                                echo 'readonly';
                                                                                                                                                                                                                            }
                                                                                                                                                                                                                            ?>>
                                                                        <input type="hidden" class="form-control pay_in" name="deposit_edit_id[]" id="amount_received" value='<?php echo $deposit->id; ?>' placeholder=" ">
                                                                    </div>

                                                                </div>
                                                    <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <?php
                                                    $page = '';
                                                    if (isset($_GET['page'])) {
                                                        $page = $_GET['page'];
                                                    }
                                                    ?>
                                                    <div class="col-md-12 pull-left payment right-six">
                                                        <div class="payment_label">
                                                            <label for="exampleInputEmail1">Renseignement Clinique
                                                            </label>
                                                        </div>
                                                        <textarea rows="4" cols="35" name="renseignementClinique"></textarea>
                                                    </div>
                                                    
                                                    <div class="form-group cardsubmit  right-six col-md-12 hidden">
                                                        <button type="submit" name="pay_now" id="submit-btn" class="btn btn-info row pull-right" <?php if ($settings->payment_gateway == 'Stripe') { ?>onClick="stripePay(event);" <?php } ?>> <?php echo lang('submit'); ?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group cashsubmit payment  right-six col-md-12" id="bouttonSuivant">
                                                        <?php if ($page == 'patient') { ?>
                                                            <a href="patient/medicalHistory?id=<?php echo $patient_id; ?>&type=payment" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></a>
                                                        <?php } else if ($page == 'consultation') { ?>
                                                            <a href="patient/medicalHistory?id=<?php echo $patient_id; ?>&type=consultation&spec=<?php echo $specialite; ?>&poids=<?php echo $poids; ?>&taille=<?php echo $taille; ?>&temp=<?php echo $temperature; ?>&frRes=<?php echo $frequenceRespiratoire; ?>&frCar=<?php echo $frequenceCardiaque; ?>&glyCap=<?php echo $glycemyCapillaire; ?>&syst=<?php echo $systolique; ?>&diast=<?php echo $diastolique; ?>&sat=<?php echo $Saturationarterielle; ?>" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></a>
                                                        <?php } else if ($page == 'historique') { ?>
                                                            <a href="finance/patientPaymentHistory?patient=<?php echo $patient_id; ?>" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></a>

                                                        <?php } else { ?>
                                                            <a href="finance/payment" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></a>
                                                        <?php } ?>
                                                        <!--<a href="finance/payment" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></a>-->
                                                        <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                                                    </div>
                                        <input type="hidden" name="id" value='<?php
                                                                                if (!empty($payment->id)) {
                                                                                    echo $payment->id;
                                                                                }
                                                                                ?>'>

                                </div>
                                </form>
                                <div class="col-md-5 row pull-right" id="bouttonOrangeMoney" style="display: none;">
                                    <div class="form-group">
                                        <table style="width: 100%;margin-left:25%">
                                            <tr>
                                                <th>
                                                    <a href="finance/payment" class="btn btn-info btn-secondary"> <?php echo lang('close'); ?></a>
                                                </th>
                                                <th>
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
        </section>
        </div>
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
                <p>Nous validons le paiement du patient <strong id="textOptSelect"></strong> d'un montant de <strong id="montantConfirmation"></strong></p>
                <p>Le traitement durera moins de 10 minutes. Nous vous notifions par SMS dès que ce sera terminé.</p>
            </div>
            <form role="form" class="clearfix" action="finance/addPaymentOM" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idtransaction" id="idTransaction" value="">
                <input type="hidden" name="refPatient" id="refPatient" value="">
                <input type="hidden" name="refService" id="refService" value="">
                <input type="hidden" name="list_id" id="list_id" value="">
                <input type="hidden" name="refQuantity" id="refQuantity" value="1">
                <input type="hidden" name="refSubtotal" id="refSubtotal" value="">
                <input type="hidden" name="refDepot" id="refDepot" value="">
                <input type="hidden" name="refChargeMutuelle" id="refChargeMutuelle" value="">
                <input type="hidden" name="refRemarks" id="refRemarks" value="">
                <input type="hidden" name="refRemarksId" id="refRemarksId" value="">
                <input type="hidden" name="refRemarksType" id="refRemarksType" value="">
                <input type="hidden" name="refChoicePartenaire" id="refChoicePartenaire" value="">
                <input type="hidden" name="refPartenaire" id="refPartenaire" value="">
                <input type="hidden" name="refGross" id="refGross" value="">
                <input type="hidden" name="refDis_id" id="refDis_id" value="">
                <input type="hidden" name="refSelecttype" id="refSelecttype" value="">
                <input type="hidden" name="refPrestation" id="refPrestation" value="">
                <input type="hidden" name="refMobRef" id="refMobRef" value="">
                <input type="hidden" name="refNumOM" id="refNumOM" value="">
                <input type="hidden" name="doctor" id="idDoctor" value="">

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">OK</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/paiementConsultation.js?<?php echo time(); ?>"></script>
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        <?php if ($this->ion_auth->in_group(array('Doctor', 'adminmedecin'))) : ?>
            var idDoctor = $('#doctorchoos').val();
            document.getElementById('idDoctor').value = idDoctor;
        <?php else : ?>
            $(document.body).on('change', '#doctorchoose', function() {
                var idDoctor = $("select.doctorchoose option:selected").val();
                document.getElementById('idDoctor').value = idDoctor;
            })
        <?php endif; ?>
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {

        $('#searchPresta').on("keyup", function(event) {
            $('.multi-select').multiSelect('refresh');
            var term = $("#searchPresta").val();

            chargeListePrestation(term);
        });

        var is_patient = '<?php echo $patient_id; ?>';
        var type = '<?php echo $type; ?>';
        var partenaire = '<?php echo $partenaire; ?>';
        // if(is_patient) {
        // alert("ok");
        // } else {
        // alert("no patient");
        // }
        if (is_patient) {
            $.ajax({
                url: 'patient/editPatientByJason?id=' + is_patient,
                method: 'GET',
                data: '',
                async: false,
                dataType: 'json',
                // delai: 250
            }).success(function(response) {
                var name = response.patient.name + ' ' + response.patient.last_name + '  (Code Patient: ' + response.patient.patient_id + ')';
                var patient_opt = new Option(name, response.patient.id, true, true);
                $('#editPaymentForm').find('[name="patient"]').append(patient_opt).trigger('change');
            });
        }

        if (type) {
            if (type == 1) {
                document.getElementById("choicepartenaire").checked = true;
                fctcheckbox()
            }

            if (type == 2) {
                document.getElementById("choicepartenaire_light").checked = true;
                fctcheckbox_light();
            }
        }

        if (partenaire) {
            if (type == 1) {
                $.ajax({
                    url: 'partenaire/infoPartenaireByNewPatient?partenaire=' + partenaire,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                    // delai: 250
                }).success(function(response) {
                    if (response) {
                        var name = response.nom;
                        var patient_opt = new Option(name, response.id, true, true);
                        $('#editPaymentForm').find('[name="partenaire"]').append(patient_opt).trigger('change');
                    }
                });
            }
            if (type == 2) {
                $.ajax({
                    url: 'partenaire/infoPartenaireByNewPatient?partenaire=' + partenaire,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                    // delai: 250
                }).success(function(response) {
                    if (response) {
                        var name = response.nom;
                        var patient_opt = new Option(name, response.id, true, true);
                        $('#editPaymentForm').find('[name="lightpartenaire"]').append(patient_opt).trigger('change');
                    }
                });
            }

        }

    });

    $.fn.datepicker.dates["fr"] = {
        days: [
            "Dimanche",
            "Lundi",
            "Mardi",
            "Mercredi",
            "Jeudi",
            "Vendredi",
            "Samedi",
        ],
        daysShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
        daysMin: ["D", "L", "M", "M", "J", "V", "S"],
        months: [
            "Janvier",
            "Février",
            "Mars",
            "Avril",
            "Mai",
            "Juin",
            "Juillet",
            "Aout",
            "Septembre",
            "Octobre",
            "Novembre",
            "Décembre",
        ],
        monthsShort: [
            "Jan",
            "Fév",
            "Mar",
            "Avr",
            "Mai",
            "Jun",
            "Jul",
            "Aou",
            "Sep",
            "Oct",
            "Nov",
            "Déc",
        ],
        today: "Aujourd'hui",
        clear: "Effacer",
        format: "dd/mm/yyyy",
        titleFormat: "MM yyyy" /* Leverages same syntax as 'format' */ ,
        weekStart: 1,

    };
    $('#birthdate').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
    });
</script>
<script>
    var checkbox = document.getElementById('choicepartenaire');
    var pos_matricule = document.getElementById('liste_partenaire');

    var checkbox_light = document.getElementById('choicepartenaire_light');
    var pos_matricule_light = document.getElementById('liste_partenaire_light');

    checkbox.onclick = function() {
        // document.getElementById('pos_select').value = '';
        // document.getElementById('add_service').value = '';
        $(".qfloww2").html("");
        $("#subtotal").val("0");
        $("#remarks").val("");
        $("#charge_mutuelle").val("0");
        $("#gross").val("0");
        $('.multi-select').empty().multiSelect('refresh');
        //  $('.multi-select').remove();
        // var option1 = new Option('', '', true, true);
        // $('#editPaymentForm').find('[name="patient"]').append(option1).trigger('change');
        document.getElementById('typetraitance').value = '';
        if (this.checked) {
            document.getElementById('typetraitance').value = 1;
            var option2 = new Option('', '', true, true);
            $('#editPaymentForm').find('[name="service"]').append(option2).trigger('change');
            document.getElementById('choicepartenaire').value = '1';
            document.getElementById('liste_partenaire').style.display = 'block';
            document.getElementById('choicepartenaire_light').value = '0';
            document.getElementById('light').style.display = 'none';
            var tt = '<label class=" col-md-4 remove1"><?php echo lang('procedures') ?></label>\n\
            <label class=" col-md-2 remove pull-left"><?php echo lang('price') . ' ' . lang('public') ?></label><label class=" col-md-3 remove pull-left">Prise en charge</label><label class=" col-md-2 remove pull-left">Prix final</label><label class=" col-md-1 remove pull-right"></label>\n\
            <div class="col-md-12 qfloww2"></div>';
            document.getElementById('qfloww').innerHTML = tt;
            $('.actePro').hide();
            var patient_opt = new Option('', '', true, true);
            $('#lightpartenaire').append(patient_opt).trigger('change');
        } else {

            document.getElementById('choicepartenaire').value = '0';
            document.getElementById('light').style.display = 'block';
            document.getElementById('liste_partenaire').style.display = 'none';
            document.getElementById('choicepartenaire_light').value = '0';
            document.getElementById('liste_partenaire_light').style.display = 'none';


            var tt = '<div class="col-md-12 qfloww2"><label class=" col-md-4 remove1"><?php echo lang('procedures') ?></label>\n\
            <label class=" col-md-2 remove pull-left"><?php echo lang('price_init') ?></label>\n\
            <label class=" col-md-3 remove pull-left"><?php echo lang('charge_mutuelless') ?></label>\n\
            <label class=" col-md-2 remove pull-left"><?php echo lang('price_final') ?></label>\n\
\n\<label class=" col-md-1 remove pull-right"></label></div>\n\
            <div class="col-md-12 qfloww2"></div>';
            document.getElementById('qfloww').innerHTML = tt;
            $('.actePro').show();

            //alert('avant----'+$("#spartenaire").val()); 
            var patient_opt = new Option('', '', true, true);
            $('#spartenaire').append(patient_opt).trigger('change');

            var patient_opt = new Option('', '', true, true);
            $('#lightpartenaire').append(patient_opt).trigger('change');

        }


    };


    checkbox_light.onclick = function() {
        // document.getElementById('pos_select').value = '';
        // document.getElementById('add_service').value = '';
        $(".qfloww2").html("");
        $("#subtotal").val("0");
        $("#remarks").val("");
        $("#charge_mutuelle").val("0");
        $("#gross").val("0");
        document.getElementById("spartenaire").selectedIndex = null;
        //  $('.multi-select').remove();
        // var option1 = new Option('', '', true, true);
        // $('#editPaymentForm').find('[name="patient"]').append(option1).trigger('change');
        // var option2 = new Option('', '', true, true);
        //  $('#editPaymentForm').find('[name="service"]').append(option2).trigger('change');
        var $exampleMulti = $('.multi-select').empty().multiSelect('refresh');
        document.getElementById('light_depot').style.display = 'block';
        document.getElementById('typetraitance').value = '';
        if (this.checked) {
            document.getElementById('typetraitance').value = 2;

            document.getElementById('organisation').style.display = 'none';
            document.getElementById('liste_partenaire_light').style.display = 'block';
            document.getElementById('liste_partenaire').style.display = 'none';
            document.getElementById('choicepartenaire_light').value = '1';
            document.getElementById('choicepartenaire').value = '0';
            document.getElementById('light_depot').style.display = 'none';
            $exampleMulti.val(null).trigger("change");
            var tt = '<label class=" col-md-4 remove1"><?php echo lang('procedures') ?></label>\n\
            <label class=" col-md-4 remove pull-left"><?php echo lang('price') . ' ' . lang('pro') ?></label><label class=" col-md-2 remove pull-left"></label>\n\
            <div class="col-md-12 qfloww2"></div>';
            document.getElementById('qfloww').innerHTML = tt;
            $('.actePro').hide();
            var patient_opt = new Option('', '', true, true);
            $('#spartenaire').append(patient_opt).trigger('change');
        } else {

            document.getElementById('choicepartenaire_light').value = '0';
            document.getElementById('choicepartenaire').value = '0';
            document.getElementById('organisation').style.display = 'block';
            document.getElementById('liste_partenaire_light').style.display = 'none';
            document.getElementById('light_partenaire').style.display = 'none';
            document.getElementById('light_depot').style.display = 'block';




            var tt = '<label class=" col-md-4 remove1"><?php echo lang('procedures') ?></label>\n\
            <label class=" col-md-2 remove pull-left"><?php echo lang('price_init') ?></label>\n\
            <label class=" col-md-3 remove pull-left"><?php echo lang('charge_mutuelless') ?></label>\n\
            <label class=" col-md-2 remove pull-right"><?php echo lang('price_final') ?></label>\n\
            <div class="col-md-12 qfloww2"></div>';
            document.getElementById('qfloww').innerHTML = tt;
            $('.actePro').show();

            var patient_opt = new Option('', '', true, true);
            $('#spartenaire').append(patient_opt).trigger('change');

            var patient_opt = new Option('', '', true, true);
            $('#lightpartenaire').append(patient_opt).trigger('change');

        }

    };

    function fctcheckbox_light() {
        $(".qfloww2").html("");
        $("#subtotal").val("0");
        $("#remarks").val("");
        $("#charge_mutuelle").val("0");
        $("#gross").val("0");
        document.getElementById("spartenaire").selectedIndex = null;

        var $exampleMulti = $('.multi-select').empty().multiSelect('refresh');
        document.getElementById('light_depot').style.display = 'block';
        document.getElementById('organisation').style.display = 'none';
        document.getElementById('liste_partenaire_light').style.display = 'block';
        document.getElementById('liste_partenaire').style.display = 'none';
        document.getElementById('choicepartenaire_light').value = '1';
        document.getElementById('choicepartenaire').value = '0';
        document.getElementById('light_depot').style.display = 'none';
        $exampleMulti.val(null).trigger("change");
        var tt = '<label class=" col-md-4 remove1"><?php echo lang('procedures') ?></label>\n\
            <label class=" col-md-4 remove pull-left"><?php echo lang('price') . ' ' . lang('pro') ?></label><label class=" col-md-2 remove pull-left"></label>\n\
            <div class="col-md-12 qfloww2"></div>';
        document.getElementById('qfloww').innerHTML = tt;
        $('.actePro').hide();
        var patient_opt = new Option('', '', true, true);
        $('#spartenaire').append(patient_opt).trigger('change');
    }

    function fctcheckbox() {
        // document.getElementById('pos_select').value = '';
        // document.getElementById('add_service').value = '';
        $(".qfloww2").html("");
        $("#subtotal").val("0");
        $("#remarks").val("");
        $("#charge_mutuelle").val("0");
        $("#gross").val("0");
        $('.multi-select').empty().multiSelect('refresh');

        var option2 = new Option('', '', true, true);
        $('#editPaymentForm').find('[name="service"]').append(option2).trigger('change');
        document.getElementById('choicepartenaire').value = '1';
        document.getElementById('liste_partenaire').style.display = 'block';
        document.getElementById('choicepartenaire_light').value = '0';
        document.getElementById('light').style.display = 'none';
        var tt = '<label class=" col-md-4 remove1"><?php echo lang('procedures') ?></label>\n\
            <label class=" col-md-2 remove pull-left"><?php echo lang('price_init') ?></label>\n\
            <label class=" col-md-3 remove pull-left"><?php echo lang('charge_mutuelless') ?></label>\n\
            <label class=" col-md-1 remove pull-right"></label>\n\
            <label class=" col-md-2 remove pull-left"><?php echo lang('price_final') ?></label>\n\
            <div class="col-md-12 qfloww2"></div>';
        document.getElementById('qfloww').innerHTML = tt;
        $('.actePro').hide();
        var patient_opt = new Option('', '', true, true);
        $('#lightpartenaire').append(patient_opt).trigger('change');
    }

    $(document).ready(function() {
        document.getElementById('redirectaddNew').value = 'finance/addPaymentView';
        $('#lightpartenaire').change(function() {
            document.getElementById('partenairetraitance').value = document.getElementById('lightpartenaire').value;
        });
        $('#spartenaire').change(function() {

            document.getElementById('partenairetraitance').value = document.getElementById('spartenaire').value;

        });
        <?php if ($patient_id) { ?>
            $("select").select2("readonly", true);
        <?php } ?>

        $("#pos_select").select2({
            placeholder: 'Selectionnez un patient',
            allowClear: true,
            ajax: {
                url: 'patient/getPatientinfoWithAddNewOption',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });

        $(document.body).on('change', '#doctorchoose', function() {

            var v = $("select.doctorchoose option:selected").val()
            if (v == 'vide') {
                var patient_opt = new Option('', '', true, true);
                $('#doctorchoose').append(patient_opt).trigger('change');
            }
        });

        $("#doctorchoose").select2({
            placeholder: 'Selectionnez un medecin',
            allowClear: true,
            ajax: {
                url: 'doctor/getDoctorinfoWithAddNewOption',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term
                    };
                },
                processResults: function(response) {
                    console.log("La response des medecins");
                    console.log(response);
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });

        $('.ms-selectable input.search-input').attr('placeholder', 'Selectionnez une prestation');


    });






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
            var idpatient2 = $('#idpatient2').val();
            var subtotal = $('#subtotal').val();
            var charge_mutuelle = $('#charge_mutuelle').val();
            var dis_id = $('#dis_id').val();
            var remarks = $('#remarks').val();
            var remarksId = $('#remarksId').val();
            var remarksType = $('#remarksType').val();
            var choicePartenaire = $('#choicepartenaire').val();
            var spartenaire = $('#spartenaire').val();
            var gross = $('#gross').val();
            var amount_received = $('#amount_receivedIDNone').val();
            var liste = document.getElementById('pos_select');
            var myElementValue = liste.value;
            var liste_service = document.getElementById('add_service');
            var myElementService = liste_service.value;
            var patientID = document.getElementById('patientID');
            var serviceID = document.getElementById('serviceID');
            var prestationID = document.getElementById('prestationID');
            var amount_receivedID = document.getElementById('amount_receivedID');
            var montantID = document.getElementById('montantID');
            var amount = amount_received.replace(".", "").replace(".", "").replace(".", "");
            var listeselecttype = document.getElementById('selecttype');
            var textOptSelect = listeselecttype.options[listeselecttype.selectedIndex].text;
            var prestation = document.getElementById('my_multi_select3');
            var elementPrestation = prestation.value;
            patientID.style['display'] = 'none';
            serviceID.style['display'] = 'none';
            prestationID.style['display'] = 'none';
            amount_receivedID.style['display'] = 'none';
            montantID.style['display'] = 'none';
            if (myElementValue == '') {
                patientID.style['display'] = 'block';
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
                document.getElementById('refRemarksId').value = remarksId;
                document.getElementById('refRemarksType').value = remarksType;
                document.getElementById('refChoicePartenaire').value = choicePartenaire;
                document.getElementById('refPartenaire').value = spartenaire;
                document.getElementById('refGross').value = gross;
                document.getElementById('refDis_id').value = dis_id;
                document.getElementById('refSelecttype').value = textOptSelect;
                document.getElementById('refPrestation').value = elementPrestation;
                document.getElementById('refMobRef').value = mobRef;

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
            document.querySelector("#montantConfirmation").innerHTML = amount_received + ' FCFA';
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
            // var statut = 'PEDDING';
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

    function depotcash(event) {
        var brut = $('#gross').val();
        var depotcash = $('#amount_received').val();
        depotcash = parseInt(depotcash);
        brut = parseInt(brut);
        var bt = document.getElementById('submit1');
        var errorDepotCash = document.getElementById('errorDepotCash');
        errorDepotCash.style.display = 'none';

        bt.disabled = false;
        if (depotcash > brut) {
            bt.disabled = true;
            errorDepotCash.style.display = 'block';
        }

    }

    function depotOM(event) {
        var brut = $('#gross').val();
        var depotOM = $('#amount_receivedIDNone').val();
        depotOM = depotOM.replace(/[^\d]/g, '')
        depotOM = parseInt(depotOM);
        brut = parseInt(brut);
        var bt = document.getElementById('interfaceOrangemoney');
        var errorDepotOM = document.getElementById('errorDepotOM');
        errorDepotOM.style.display = 'none';
        bt.disabled = false;
        if (depotOM > brut) {
            bt.disabled = true;
            errorDepotOM.style.display = 'block';
        }

    }
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