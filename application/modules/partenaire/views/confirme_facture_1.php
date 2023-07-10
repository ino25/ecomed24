<section id="main-content" class="invoice-pro">
    <section class="wrapper site-min-height">
        <section class="col-md-12">

            <div id="div-listePrestationExel" style="display:block">
                <!-- <header class="panel-heading">
                 <?php //echo lang('confirm_import'); 
                    ?>
ino
            </header> -->

                <div class="panel-body col-md-12">
                    <section id="main-content-">
                        <section class="wrapper site-min-height">
                            <!--  <form  action="finance/validFactures" id="genereFactures" class="clearfix" method="post" enctype="multipart/form-data"> -->
                            <section class="col-md-12">
                                <div class="panel panel-primary" id="invoice">
                                    <div class="panel-body" id="editPaymentForm">
                                        <div class="col-md-12" id="body-print" style="background-color: #fff">
                                            <div class="row invoice-list">
                                                <div class="col-md-12 invoice_head clearfix">
                                                    <div class="col-md-4  invoice_head_left" style="float:left">
                                                        <?php if ($destinatairs->path_logo) { ?>
                                                            <img src="<?php echo $destinatairs->path_logo; ?>" style="max-width:220px;max-height:150px;margin-top:-12px" />
                                                            <input hidden type="text" id="logo2" value="<?php echo !empty($destinatairs->path_logo) ? $destinatairs->path_logo : "uploads/logosPartenaires/default.png"; ?>">
                                                        <?php } ?>
                                                        <input hidden id="descOrganisation" type="text" value="<?php echo !empty($destinatairs) ? $destinatairs->description_courte_activite : ""; ?>">
                                                        <input hidden id="slogan" type="text" value="<?php echo !empty($destinatairs) ? $destinatairs->slogan : ""; ?>">
                                                        <input hidden id="horaire" type="text" value="<?php echo !empty($destinatairs) && !empty($destinatairs->horaires_ouverture) ? "Horaires d'ouverture:" : ""; ?>">
                                                        <label hidden id="horaireOuverture"><?php echo $destinatairs->horaires_ouverture; ?></label>
                                                    </div>
                                                    <div class="col-md-8 invoice_head_right" style="float:right">
                                                        <table style="width:100%">
                                                            <tr>
                                                                <th>
                                                                    <h4 class="blue">
                                                                        <label class="control-label pull-right blue"><?php echo lang('invoice_f') ?> <?php echo 'NRO'; ?> </label>
                                                                    </h4>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    <h3 class="blue"><label class="control-label pull-right blue"><?php echo $code; ?></label></h3>
                                                                    <input hidden id="codeFacture" type="text" value="<?php echo $code; ?>">
                                                                    <input hidden id="dateDebut" type="text" value="<?php echo $dateDebut; ?>">
                                                                    <input hidden id="dateFin" type="text" value="<?php echo $dateFin; ?>">
                                                                </th>
                                                            </tr>
                                                        </table>
                                                        <br>

                                                    </div>
                                                </div>
                                                <div class="col-md-12 invoice_head clearfix">
                                                    <div class="col-md-5  invoice_head_left" style="float:left;">
                                                        <table style="width:100%">
                                                            <tr>
                                                                <th>
                                                                    <h4>
                                                                        <label class="control-label pull-left">
                                                                            <span style="font-size:12px;font-weight: normal;"> </span> <span class="blue"> <?php echo  $destinatairs->nom  ?></span>
                                                                            <input hidden id="destinataireNom" type="text" value="<?php echo  $destinatairs->nom  ?>">
                                                                            <input hidden id="destinatairePortable_responsable_legal" type="text" value="<?php echo  $destinatairs->portable_responsable_legal;  ?>">
                                                                            <input hidden id="destinataireFixe" type="text" value="<?php echo  $destinatairs->numero_fixe;  ?>">
                                                                            <input hidden id="destinataireEmail" type="text" value="<?php echo  $destinatairs->email  ?>">
                                                                        </label>
                                                                    </h4>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    <h4>
                                                                        <label class="control-label">
                                                                            <span class="" style="font-weight: normal;">
                                                                                <?php echo  $destinatairs->adresse; ?><br>
                                                                                <span style="float: left;"><?php echo  $destinatairs->region . ' , ' . $destinatairs->pays; ?></span>
                                                                                <input hidden id="destinataireAdresse" type="text" value="<?php echo  $destinatairs->adresse; ?>">
                                                                            </span>
                                                                        </label>
                                                                        <input hidden id="destinataireRegion" type="text" value="<?php echo  $destinatairs->region; ?>">
                                                                        <input hidden id="destinatairePays" type="text" value="<?php echo  $destinatairs->pays; ?>">
                                                                    </h4>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    <h4>
                                                                        <label class="control-label pull-left" style="">
                                                                            Emise le : <?php echo  $dateEmise; ?>
                                                                            <input hidden id="dateEmise" type="text" value="<?php echo  $dateEmise; ?>">
                                                                        </label>
                                                                    </h4>
                                                                </th>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-5 invoice_head_right" style="float:right;">
                                                        <table style="width:100%;">
                                                            <tr>
                                                                <th>
                                                                    <h4>
                                                                        <label class="control-label pull-right pp100" style="">
                                                                            <span class="blue"> <?php echo  $origins->nom  ?></span>
                                                                            <input hidden id="origineNom" type="text" value="<?php echo  $origins->nom  ?>">
                                                                            <input hidden id="originePortable_responsable_legal" type="text" value="<?php echo  $origins->portable_responsable_legal;  ?>">
                                                                            <input hidden id="origineFixe" type="text" value="<?php echo  $origins->numero_fixe;  ?>">
                                                                            <input hidden id="origineEmail" type="text" value="<?php echo  $origins->email  ?>">
                                                                        </label>
                                                                    </h4>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    <h4>
                                                                        <label class="control-label pull-right pp100" style="">
                                                                            <span style="font-weight: normal;"> <?php echo $origins->adresse != null && trim($origins->adresse) != "" && trim($origins->adresse) != "--" ? trim($origins->adresse) : ""; ?></span>
                                                                            <input hidden id="origineAdresse" type="text" value="<?php echo $origins->adresse != null && trim($origins->adresse) != "" && trim($origins->adresse) != "--" ? trim($origins->adresse) : ""; ?>">
                                                                        </label>
                                                                    </h4>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    <h4>
                                                                        <?php
                                                                        $originsRegion = $origins->region != null && trim($origins->region) != "" && trim($origins->region) != "--" ? trim($origins->region) . ", " : "";
                                                                        ?>
                                                                        <input hidden id="origineRegion" type="text" value="<?php
                                                                                                                            $originsRegion = $origins->region != null && trim($origins->region) != "" && trim($origins->region) != "--" ? trim($origins->region) . ", " : "";
                                                                                                                            ?>">
                                                                        <label class="control-label pull-right pp100" style="">
                                                                            <span style="font-weight: normal;"> <?php echo  $originsRegion . $origins->pays; ?></span>
                                                                            <input hidden id="originePays" type="text" value="<?php echo  $originsRegion . $origins->pays; ?>">
                                                                        </label>
                                                                    </h4>
                                                                </th>
                                                            </tr>

                                                            <tr>
                                                                <th>
                                                                    <h4>
                                                                        <label class="control-label pull-right pp100" style="">
                                                                            <span style="font-weight: normal;">

                                                                                Période : Du <?php echo $dateDebut; ?> Au <?php echo $dateFin; ?>
                                                                            </span>
                                                                        </label>
                                                                    </h4>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    <h4>
                                                                        <label class="control-label pull-right pp100" style="">

                                                                            A payer avant le : <?php
                                                                                                echo  date('d/m/Y', strtotime(date($dateEmise, 'Y-m-d') . ' + 15 DAY')); ?>
                                                                            <input hidden id="echeance" type="text" value="<?php echo  date('d/m/Y', strtotime(date($dateEmise, 'Y-m-d') . ' + 15 DAY')); ?>">
                                                                        </label>
                                                                    </h4>
                                                                </th>
                                                            </tr>
                                                        </table>

                                                    </div>
                                                </div>

                                            </div>




                                        </div>



                                        <table class="table table-hover progress-table text-center editable-sample editable-sample-paiement " id="editable-sample-">
                                            <thead class="theadd">
                                                <tr>

                                                    <th><?php echo lang('date'); ?></th>
                                                    <th><?php echo lang('reference'); ?></th>
                                                    <th><?php echo lang('patient'); ?></th>
                                                    <th><?php echo lang('payment_procedures'); ?></th>
                                                    <th><?php echo lang('amount'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $total = 0;
                                                $prix = 0;
                                                foreach ($prestationTab as $prestations) {      ?>

                                                    <?php if (isset($prestations->category_name_pro)) {
                                                        $category_name = $prestations->category_name_pro;
                                                        $category_name1 = explode(',', $category_name);
                                                        $i = 0;
                                                        foreach ($category_name1 as $category_name2) {
                                                            $i = $i + 1;
                                                            $category_name3 = explode('*', $category_name2);
                                                            if ($category_name3[3] > 0 && $category_name3[1]) { ?>
                                                                <tr class="ligneFacture">

                                                                    <td class="dateFacture"> <?php echo date('d/m/Y', $prestations->date); ?> </td>
                                                                    <td class="codeFacture"> <?php echo $prestations->code_pro; ?></td>
                                                                    <td class="codePatientFacture"> <?php echo $prestations->patient_id; ?> </td>
                                                                    <td class="prestationFacture"> <?php echo $this->finance_model->getPaymentcategoryById($category_name3[0])->prestation; ?></td>
                                                                    <?php
                                                                    $prix = $prix + $category_name3[1];
                                                                    ?>
                                                                    <td class="montantFacture">
                                                                        <?php
                                                                        // echo number_format($category_name3[1], 0, ",", ".") . ' ' . $settings->currency; 
                                                                        echo number_format($category_name3[1], 0, ",", ".") . ' ' . $settings->currency;
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                <?php

                                                                // $total =  $total + $category_name3[1];
                                                                $total =  $total + $category_name3[1];
                                                            }
                                                        }
                                                    }
                                                }

                                                ?>


                                            </tbody>
                                        </table>

                                        <div class="col-md-12 hr_border">
                                            <hr>
                                        </div>

                                        <div class="">
                                            <div class="col-lg-4 invoice-block pull-left">
                                                <h4></h4>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="col-lg-4 invoice-block pull-right">
                                                <ul class="unstyled amounts">
                                                    <li><strong><?php echo  lang('grand_total_ht'); ?>: </strong><span class="htFacture"><?php echo  number_format($total, 0, ",", ".") . ' ' .  $settings->currency; ?> </span></li>
                                                    <li><strong><?php echo  lang('tva'); ?>%: </strong><span class="tvaFacture"><?php echo  '0'; ?> <?php echo $settings->currency; ?></span></li>
                                                    <li><strong><?php echo  lang('grand_total_ttc'); ?>: </strong><span class="ttcFacture"><?php echo  number_format($total, 0, ",", ".") . ' ' .  $settings->currency; ?></span></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="col-md-12 invoice_footer">
                                            <div class="col-md-12 row" style="margin-bottom:40px">
                                                <table>
                                                    <?php
                                                    if ($mode && ($pay == 'demandpay')  && $payStatusPro == "unpaid") {
                                                    ?>
                                                        <tr>
                                                            <th>

                                                                <label class="control-label" style="">
                                                                    <span style="font-weight: normal;">
                                                                        Merci de régler la facture avant échéance via virement bancaire, zuuluPay, Orange Money...
                                                                    </span>

                                                                </label>

                                                            </th>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                    <input hidden id="users" type="text" value="<?php echo $this->ion_auth->user()->row()->first_name . ' ' . $this->ion_auth->user()->row()->last_name; ?>">
                                                    <input id="datejourfooter" type="hidden" name="date" value='<?php echo date('d/m/Y H:i'); ?>' placeholder="">
                                                    <tr>
                                                        <th>

                                                            <label class="control-label" style="">
                                                                <?php echo 'Nous vous remercions de votre fidelité'; ?>
                                                            </label>

                                                        </th>
                                                    </tr>
                                                </table>

                                            </div>
                                            <div class="col-md-12">
                                                <!--<div class="row" style=""><?php echo  lang('effectuer_par'); ?> : <?php echo  $this->ion_auth->user()->row()->first_name . ' ' . $this->ion_auth->user()->row()->last_name; ?> </div>-->

                                            </div>



                                        </div>
                                    </div>

                                    <div class="col-md-12 hr_border no-print">
                                        <?php //if ($mode && $pay == 'accept') { 
                                        ?>
                                        <?php
                                        // var_dump($mode.'-'.$pay.'-'.$payStatusPro);
                                        if ($modelight && ($pay == 'demandpay')  && $payStatusPro == "unpaid") { ?>
                                            <div class="form-group  pull-left col-md-12 ">
                                                <div class="payment_label ">
                                                    <div class="col-md-12">
                                                        <form role="form" action="finance/checkDepotPro" id="deposit-checkDepot" class="clearfix" method="post" enctype="multipart/form-data">
                                                            <input type="hidden" id="payment" name="payment" value="<?php if (isset($_GET['id'])) {
                                                                                                                        echo $_GET['id'];
                                                                                                                    } ?>">
                                                            <input type="hidden" id="amount" name="amount" value="<?php echo $total; ?>">

                                                            <span class="">
                                                                <button type="submit" name="submit" id="submit1light" class="btn btn-info row pull-right" style="background-color:#0F7D4F;"><i class="fa fa-money-check"></i> Marquer Payé</button>
                                                            </span>

                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        // var_dump($mode.'-'.$pay.'-'.$payStatusPro);
                                        if ($mode && ($pay == 'demandpay')  && $payStatusPro == "unpaid") { ?>
                                            <div class="form-group  pull-left col-md-12 ">
                                                <div class="payment_label ">
                                                    <div class="col-md-4">
                                                        <form role="form" action="finance/checkDepotPro" id="deposit-checkDepot" class="clearfix" method="post" enctype="multipart/form-data">
                                                            <!--  <label for="exampleInputEmail1"><?php echo lang('pay_type'); ?></label>-->
                                                            <select class="form-control m-bot15 " id="" name="" onchange="caisseUpdate(event)" required="">
                                                                <?php if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Accountant', 'Receptionist'))) { ?>
                                                                    <option value=""> Choisir un moyen de paiement </option>
                                                                    <option value="zuuluPay"> <?php echo lang('zuulupay'); ?> </option>
                                                                    <option value="OrangeMoney"> <?php echo 'OrangeMoney'; ?> </option>
                                                                    <option value="Cash"> <?php echo 'Virement'; ?> </option>
                                                                    <option value="" disabled=""> <?php echo lang('carte_bancaire'); ?> </option>
                                                                    <option value="" disabled=""> <?php echo lang('demande'); ?> </option>
                                                                    <option value="Cheque" disabled=""> <?php echo 'Cheque'; ?> </option>
                                                                <?php } ?>

                                                            </select>
                                                    </div>
                                                    <input type="hidden" id="payment" name="payment" value="<?php if (isset($_GET['id'])) {
                                                                                                                echo $_GET['id'];
                                                                                                            } ?>">
                                                    <input type="hidden" id="amount" name="amount" value="<?php echo $total; ?>">

                                                    <div class="col-md-4" id="bouttonSuivant" style="display: none;padding-top:5px">
                                                        <span class="">
                                                            <button type="submit" name="submit" id="submit1" class="btn btn-info row pull-left"> <?php echo lang('pay'); ?></button>
                                                        </span>

                                                    </div>
                                                    </form>
                                                    <div id="" class="col-md-4">
                                                        <span class="" id="bouttonOrangeMoney" style="display: none;padding-top:5px">
                                                            <button id="interfaceOrangemoney" name="" id="submit-pay" class="btn btn-info row pull-left"> <?php echo lang('submit_continuer'); ?></button>
                                                        </span>
                                                        <span class="" id="bouttonZuuluPay" style="display: none;padding-top:5px">
                                                            <button id="interfaceZuuluPay" name="" id="submit-pay" class="btn btn-info row pull-left"> <?php echo lang('submit_continuer'); ?></button>
                                                        </span>
                                                    </div>

                                                </div>
                                                <!-- <div class=" col-md-6 pull-right">
                                                </div> -->
                                            </div>
                                        <?php } ?>
                                        <div class="form-group pull-right  col-md-12 ">

                                            <div class="ignorepdf" style="display:block">
                                                <a href="partenaire/factures" class="btn btn-info btn-secondary pull-left">Retour</a>

                                                <button type="submit" onclick="download()" class="btn btn-info row pull-left" style="margin-left: 40%;"><i class="fa fa-download"></i> <?php echo lang('download'); ?></button>
                                                <button type="submit" onclick="print()" style="margin-left: 2%;" class="btn btn-secondary btn-sm invoice_button pull-right" id="btnPrintGenerik"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <footer>
                                        <div class="col-md-12 hr_border_invoice no-print">
                                        </div>
                                        <div class="col-md-12 hr_border no-print">
                                            <div class="text-center col-md-12 "> <span style=""> <?php echo  $destinatairs->adresse . ', ' . $destinatairs->region . ', ' . $destinatairs->pays . ' Tel: ' . $destinatairs->numero_fixe . ' Mail:' . $destinatairs->email; ?></span>
                                            </div>
                                    </footer>
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
                                                                    padding-top: 0px;
                                                                    padding-bottom: 10px;
                                                                    border: none;

                                                                }
                                                            </style>
                                                            <header class="panel-heading">
                                                                <?php echo lang('paiement_facture'); ?>
                                                            </header>
                                                            <br>
                                                            <!-- <label class="grandeligne">Vous êtes sur le point d’effectuer un paiement d'un montant de <span class="money" id="montantsubtotal"></span> à partir de votre compte Orange Money</label> -->
                                                            <div class="form-group col-md-7" style="margin-top: 10px;">
                                                                <label class="grandeligne">Veuillez saisir le numéro de compte orange money</label>
                                                            </div>
                                                            <div class="form-group col-md-6" style="margin-top: 10px;">
                                                                <label for="exampleInputEmail1">Numero compte orange money</label>
                                                                <input type="text" class="form-control" name="mobNo" id="mobNo" value="" placeholder="" pattern="[0-9]{9}" required autocompleted="off" onkeyup="recuperationOM(event)">
                                                                <code id="phoneID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>
                                                            </div>
                                                            <div class="form-group col-md-7">
                                                                <button id="validationOrange" type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit_continuer'); ?></button>
                                                                <button onclick="reloadPage()" id="retourInterfaceActe" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" id="validationdepotorange" style="display:none;">
                                    <header class="panel-heading">
                                        <?php echo lang('paiement_facture'); ?>
                                    </header>
                                    <br>
                                    <label class="grandeligne">Merci de saisir le code USSD suivant sur votre téléphone .</label>
                                    <label class="grandeligne">CODE USSD : <span id="msgussd"></span></label>
                                    <div class="form-group col-md-7" style="padding-top:20px">
                                        <label class="grandeligne">Entrer la référence OrangeMoney reçue et cliquer "Continuer"</label>
                                        <label for="exampleInputEmail1" style="padding-top: 10px;">Code de référence</label>
                                        <input type="text" class="form-control" name="mobRef" id="mobRef" value="" placeholder="" pattern="[0-9]{9}" required autocompleted="off" onkeyup="validation(event)">
                                        <code class="flash_message" style="display:none">Veuillez respecter le format requis</code>
                                    </div>
                                    <div class="form-group col-md-7">
                                        <button type="submit" id="rediriger" data-toggle="modal" href="#myModalPopup" data-backdrop="static" name="submit" class="btn btn-info pull-right"><?php echo lang('submit_continuer'); ?></button>
                                        <button id="retourConfirmation" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></button>
                                    </div>

                                </div>

                                <div class="card-body" id="confirmZuuluPay" style="display:none">
                                    <div class="form-row col-md-12 panel">
                                        <div class="col-md-6">
                                            <label for="validationCustom01"><strong>Montant</strong></label>
                                            <input type="text" class="form-control" name="amountformat" id="amountValidationFormat" value="" readonly>
                                            <input type="hidden" class="form-control" name="amount" id="amountValidation" value="<?php echo $total; ?>" readonly>
                                            <label class="col-md-10 col-form-label"><span style="color:red;display:none" id="errorTransfertSolde">Le montant du paiement est supérieur au solde actuel</span></label>

                                        </div>
                                        <div class="col-md-6 mb-4">

                                        </div>
                                    </div>
                                    <div class="form-row col-md-12 panel">
                                        <div class="col-md-6 mb-6">

                                            <label class="col-form-label">Débiter : <strong><?php echo  $origins->nom;  ?> </strong></label>
                                            <input id="id_origin" type="hidden" class="form-control" value="<?php echo  $origins->id_partenaire_zuuluPay;  ?>">
                                            <input id="pin_origin" type="hidden" class="form-control" value="<?php echo  $this->encryption->decrypt($origins->pin_partenaire_zuuluPay_encrypted);  ?>">
                                            <select class="form-control m-bot15 " id="compte1" name="compte1" onchange="compteDebite(event)" required="">
                                                <option value=""> Choisir le compte </option>
                                                <option value="service"> Compte Principal </option>
                                                <option value="encaissement"> Compte Encaissement </option>
                                            </select>
                                            <div class="col-form-label">
                                                <div id="serviceDisponible" style="display:none;">Solde Actuel : <span id="soldeDisponible"></span>
                                                    <span hidden id="soldePrincipal"></span>
                                                    <input id="soldeServiceInitial" type="hidden">
                                                    <input id="soldeEncaissementInitial" type="hidden">
                                                </div>
                                                <div id="encaissementDisponible" style="display:none;">Solde Actuel : <span id="soldeEncaissement"></span></div>
                                            </div>

                                        </div>
                                        <div class="col-md-6 mb-6">

                                            <label class="col-form-label">Créditer : <strong><?php echo  $destinatairs->nom;  ?> </strong></label>
                                            <input id="id_destinataire" type="hidden" class="form-control" value="<?php echo  $destinatairs->id_partenaire_zuuluPay;  ?>">
                                            <input id="pin_destinataire" type="hidden" class="form-control" value="<?php echo  $this->encryption->decrypt($destinatairs->pin_partenaire_zuuluPay_encrypted);  ?>">
                                            <input type="text" class="form-control" name="compte2" id="validationCustom01" value="Compte encaissement" readonly>



                                        </div>
                                    </div>
                                    <div id="btnInterne" class=" col-md-12 panel">
                                        <div class="row col-12" style="display: flex; justify-content: flex-end;">
                                            <input type="hidden" class="form-control" name="refMobRef" id="refMobRef" value="">
                                            <input type="hidden" class="form-control" name="payment" value="">
                                            <input type="hidden" class="form-control" name="origin" value="<?php echo  $origins->nom;  ?>"> <input type="hidden" class="form-control" name="originID" value="<?php echo  $origins->id;  ?>">
                                            <input type="hidden" class="form-control" name="destinataire" value="<?php echo  $destinatairs->nom;  ?>"> <input type="hidden" class="form-control" name="destinataireID" value="<?php echo  $destinatairs->id;  ?>">
                                            <input type="hidden" class="form-control" name="description_type" id="description_type2" value="">
                                            <input type="hidden" class="form-control" name="deposit_type" id="deposit_type2" value="">
                                            <button onclick="reloadPage()" id="retourInterfaceFacture" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></button>
                                            <label class="col-md-10 col-form-label"><span style="color:red;display:none" id="errorTransfert">Vous avez saisi votre propre numéro comme bénéficiaire. Veuillez saisir un numéro différent</span></label>

                                            <div id="btnDefault" style="display: block;">
                                                <button class="btn btn btn-lg" type="submit" style="background-color:#0D4D96;color:#ffffff;margin-left:5%" disabled>Continuer</button>
                                            </div>
                                            <div id="btnService" style="display: none;">
                                                <button class="btn btn btn-lg" type="submit" style="background-color:#0D4D96;color:#ffffff;margin-left:5%">Continuer</button>
                                            </div>
                                            <div id="btnEncaissement" style="display: none;">
                                                <button class="btn btn btn-lg" type="submit" style="background-color:#0D4D96;color:#ffffff;margin-left:5%">Continuer</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="fraisZuulupay" style="display: none">
                                    <div id="success" class="top-nav" style="display: none">
                                        <code class="flashmessage pull-right"> Paiement de facture effectué avec succès</code>
                                    </div>
                                    <header class="panel-heading">
                                        <?php echo lang('paiement_facture'); ?> De <strong><?php echo  $origins->nom;  ?> </strong> Vers <strong><?php echo  $destinatairs->nom;  ?> </strong>
                                    </header>
                                    <br>
                                    <div class="col-md-12">
                                        <label class="col-md-5 col-form-label">Montant : </label>
                                        <label class="col-md-5 col-form-label" id="amountpay"></label>
                                        <label class="col-md-2 col-form-label"></label><br>
                                        <label class="col-md-5 col-form-label">Frais : </label>
                                        <label class="col-md-5 col-form-label" id="feeAmountpay"></label>
                                        <label class="col-md-2 col-form-label"></label><br>
                                        <label class="col-md-5 col-form-label">Montant Total : </label>
                                        <label class="col-md-5 col-form-label" id="totalAmountpay"></label>
                                        <label class="col-md-2 col-form-label"></label><br>
                                        <div id="validationachat" style="display: none">
                                            <label class="col-md-5 col-form-label">Numéro de transaction : </label>
                                            <label class="col-md-5 col-form-label" id="numeroTransaction"></label>
                                            <label class="col-md-2 col-form-label"></label><br>
                                            <label class="col-md-5 col-form-label">Date & Heure : </label>
                                            <label class="col-md-5 col-form-label" id="dateHeure"></label>
                                            <label class="col-md-2 col-form-label"></label><br>
                                        </div>
                                        <br><br>
                                        <label class="col-md-10 col-form-label"><span style="color:red;display:none" id="errorPay"></span></label>
                                        <input type="hidden" id="UnformattedTotalAmount">
                                        <input type="hidden" id="idPayment" value="<?php echo $id; ?>">
                                    </div>
                                    <div id="btnSucces" class="form-group col-md-12" style="padding-top:20px;display:none">
                                        <a href="partenaire/factures" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour_facture'); ?></a>
                                    </div>
                                    <div id="btnEffectuer" class="form-group col-md-8" style="padding-top:20px">
                                        <button id="validerZuulupay" type="submit" name="submit" class="btn btn-info pull-right" style="margin-left:15px"><?php echo lang('submit_effectuer'); ?></button>
                                        <button id="validerZuulupayEncaissement" type="submit" name="submit" class="btn btn-info pull-right" style="margin-left:15px"><?php echo lang('submit_effectuer'); ?></button>
                                        <button id="retourZuulupay" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></button>
                                    </div>
                                </div>


                            </section>

                        </section>


                    </section>

                </div>

                <section class="col-md-12">

                </section>

            </div>

            <div id="div-importPrestationExel" style="display:none">

            </div>

            <div class="col-md-12">
                <?php
                $message2 = $this->session->flashdata('message2');
                if (!empty($message2)) {
                ?>
                    <code class="flash_message pull-right"> <?php echo $message2; ?></code>
                <?php } ?>
            </div>
        </section>
    </section>
</section>
<input hidden id="formCustmer" value="<?php echo !empty($origins->id_partenaire_zuuluPay) ? $origins->id_partenaire_zuuluPay : ""; ?>">
<input hidden id="PIN" value="<?php echo !empty($pin_decrypted) ? $pin_decrypted : ""; ?>">

<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">
                    <div class="alert alert-danger text-center" id="successWrapper">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p id="danger"><?php echo lang('error_config_zuulupay'); ?></p>
                    </div>
                </h4>
            </div>
            <div class="modal-body">
                <div class="clearfix" method="post">
                    <section class="">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal">Retour</button>
                    </section>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
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
                <p>Nous validons le paiement de la facture </p>
                <p>Le traitement durera moins de 10 minutes. Nous vous notifions par SMS dès que ce sera terminé.</p>
            </div>
            <form role="form" class="clearfix" action="finance/updatePaiementPro" method="post" enctype="multipart/form-data">
                <input type="hidden" class="form-control" name="id" value="<?php echo $id; ?>">
                <input type="hidden" class="form-control" name="amount" id="amountid" value="">
                <input type="hidden" class="form-control" name="refMobRef" id="refMobRef2" value="">
                <input type="hidden" class="form-control" name="payment" value="">
                <input type="hidden" class="form-control" name="origin" value="<?php echo  $origins->nom;  ?>"> <input type="hidden" class="form-control" name="originID" value="<?php echo  $origins->id;  ?>">
                <input type="hidden" class="form-control" name="destinataire" value="<?php echo  $destinatairs->nom;  ?>"> <input type="hidden" class="form-control" name="destinataireID" value="<?php echo  $destinatairs->id;  ?>">
                <input type="hidden" class="form-control" name="description_type" id="description_type" value="">
                <input type="hidden" class="form-control" name="deposit_type" id="deposit_type" value="">
                <input type="hidden" class="form-control" name="refNumOM" id="refNumOM" value="">
                <input type="hidden" class="form-control" name="idTransaction" id="idTransaction" value="">

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">OK</button>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
    .flash_message {
        padding: 3px;
        text-align: center;
        margin-left: 0px;
        margin-top: 0px;
    }
</style>

<script src="<?php echo base_url(); ?>common/js/ecomed24.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/facture.js"></script>
<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>

<!-- #######################################################################-->

<script>
    $(document).ready(function() {
        var formCustmer = $('#id_origin').val();
        var pin = $('#pin_origin').val();
        var reponseAll = solde("fr", formCustmer, pin);
        var bt = document.getElementById('rediriger');
        var btvalidationOrange = document.getElementById('validationOrange');
        btvalidationOrange.disabled = true;


        $("#interfaceOrangemoney").click(function(e) {
            //var mobRef = $('#mobRef').val();
            //   document.getElementById('refMobRef').value = mobRef;
            window.scrollTo(0, 0);
            var editPaymentForm = document.getElementById('editPaymentForm');
            var confirmation = document.getElementById('confirmation');
            var bouttonOrangeMoney = document.getElementById('bouttonOrangeMoney');
            var confirmZuuluPay = document.getElementById('confirmZuuluPay');
            var invoice = document.getElementById('invoice');
            invoice.style['display'] = 'none';
            bouttonOrangeMoney.style['display'] = 'none';
            editPaymentForm.style['display'] = 'none';
            confirmation.style['display'] = 'block';
            confirmZuuluPay.style['display'] = 'none';

        });

        $("#interfaceZuuluPay").click(function(e) { //confirmZuuluPay
            //var mobRef = $('#mobRef').val();
            //   document.getElementById('refMobRef').value = mobRef;
            window.scrollTo(0, 0);
            var amount = $('#amountValidation').val();
            document.getElementById('amountValidationFormat').value = formatCurrencyFacturaction(amount);
            var editPaymentForm = document.getElementById('editPaymentForm');
            var confirmation = document.getElementById('confirmation');
            var bouttonOrangeMoney = document.getElementById('bouttonOrangeMoney');
            var confirmZuuluPay = document.getElementById('confirmZuuluPay');
            var invoice = document.getElementById('invoice');
            invoice.style['display'] = 'none';
            bouttonOrangeMoney.style['display'] = 'none';
            editPaymentForm.style['display'] = 'none';
            confirmation.style['display'] = 'none';
            confirmZuuluPay.style['display'] = 'block';

        });



        $("#rediriger").click(function(e) {

            var amount = $('#amount').val();
            var phone = $('#mobNo').val();
            /* var subtotal = $('#subtotal').val();
             var charge_mutuelle = $('#charge_mutuelle').val();
             var amount = $('#amount_receivedIDNone').val();
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
             var elementPrestation = prestation.value;*/
            //amount = amount_received.replace(".", "").replace(".", "").replace(".", "");
            //  alert("le prix total " + subtotal + " prise en charge " + charge_mutuelle + " le montant du depot " + amount_received + " le numero patient " + myElementValue + " le numero service " + myElementService + " le detail du patient " + textOptSelect + " les prestations " + elementPrestation + " idprestation " + idcategory);
            $.ajax({
                url: 'finance/addpaymentom?amount_received=' + amount,
                method: 'POST',
                data: '',
                dataType: 'json',
            }).success(function(response) {

            });

        });
        $("#btnService").click(function(e) {
            var amountValidation = $('#amountValidation').val();
            // var amountValidation = 10;
            var formCustmer = $('#id_origin').val();
            var pin = $('#pin_origin').val();
            var to_Custmer = $('#id_destinataire').val();
            var to_pin = $('#pin_destinataire').val();
            var reponseAll = loadDonsZuuluService("fr", formCustmer, pin, to_Custmer, to_pin, amountValidation);
        });
        $("#btnEncaissement").click(function(e) {
            var amountValidation = $('#amountValidation').val();
            //var amountValidation = 10;
            var formCustmer = $('#id_origin').val();
            var pin = $('#pin_origin').val();
            var to_Custmer = $('#id_destinataire').val();
            var to_pin = $('#pin_destinataire').val();
            var reponseAll = loadDonsZuuluEncaissement("fr", formCustmer, pin, to_Custmer, to_pin, amountValidation);
        });
        $("#retourZuulupay").click(function(e) {
            var fraisZuulupay = document.getElementById('fraisZuulupay');
            var confirmZuuluPay = document.getElementById('confirmZuuluPay');
            fraisZuulupay.style['display'] = 'none';
            confirmZuuluPay.style['display'] = 'block';
            var invoice = document.getElementById('invoice');
            invoice.style['display'] = 'none';
        });
        $("#validerZuulupay").click(function(e) {
            var amountValidation = $('#UnformattedTotalAmount').val();
            //var amountValidation = 10;
            var formCustmer = $('#id_origin').val();
            var pin = $('#pin_origin').val();
            var to_Custmer = $('#id_destinataire').val();
            var to_pin = $('#pin_destinataire').val();
            var idPayment = $('#idPayment').val();
            //alert(formCustmer+' '+pin+' '+to_Custmer+' '+to_pin+' '+amountValidation+' '+idPayment);
            var reponseAll = validationZuuluService("fr", formCustmer, pin, to_Custmer, to_pin, amountValidation, idPayment);
        });
        $("#validerZuulupayEncaissement").click(function(e) {
            var amountValidation = $('#UnformattedTotalAmount').val();
            var formCustmer = $('#id_origin').val();
            var pin = $('#pin_origin').val();
            var to_Custmer = $('#id_destinataire').val();
            var to_pin = $('#pin_destinataire').val();
            var idPayment = $('#idPayment').val();
            //alert(formCustmer+' '+pin+' '+to_Custmer+' '+to_pin+' '+amountValidation+' '+idPayment);
            var reponseAll = validationZuuluEncaissement("fr", formCustmer, pin, to_Custmer, to_pin, amountValidation, idPayment);
        });

        $("#validationOrange").click(function(e) {
            var amount = $('#amountValidation').val();
            document.getElementById('amountid').value = amount;
            var phone = $('#mobNo').val();
            var phoneFormat = phone.replace(/[^\d]/g, '');
            var editPaymentForm = document.getElementById('editPaymentForm');
            var validationdepotorange = document.getElementById('validationdepotorange');
            var confirmation = document.getElementById('confirmation');
            var formCustmer = $('#id_destinataire').val();
            var pin = $('#pin_destinataire').val();
            var invoice = document.getElementById('invoice');
            invoice.style['display'] = 'none';
            document.getElementById('refNumOM').value = phoneFormat;
            if (formCustmer && pin) {
                editPaymentForm.style['display'] = 'none';
                confirmation.style['display'] = 'none';
                validationdepotorange.style['display'] = 'block';
                console.log("fr" + '--' + amount + '--' + phoneFormat + '--' + formCustmer + '--' + pin);
                var reponseAll = paiementOrangeMoneyOrganisation("fr", amount, phoneFormat, formCustmer, pin);

            } else {
                $('#myModal').modal('show');
            }


            //  }
        });

        // $("#retourInterfaceActe").click(function(e) {
        //     var editPaymentForm = document.getElementById('editPaymentForm');
        //     var confirmation = document.getElementById('confirmation');
        //     var bouttonOrangeMoney = document.getElementById('bouttonOrangeMoney');
        //     bouttonOrangeMoney.style['display'] = 'block';
        //     editPaymentForm.style['display'] = 'block';
        //     confirmation.style['display'] = 'none';
        // });

        $("#retourConfirmation").click(function(e) {
            var editPaymentForm = document.getElementById('editPaymentForm');
            var validationdepotorange = document.getElementById('validationdepotorange');
            var confirmation = document.getElementById('confirmation');
            editPaymentForm.style['display'] = 'none';
            validationdepotorange.style['display'] = 'none';
            confirmation.style['display'] = 'block';
        });



        var table = $('#editable-sample').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            // "serverSide": true,
            "searchable": true,
            scroller: {
                loadingIndicator: true
            },
            fixedHeader: true,
            dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 pull-left'B><'col-sm-4 pull-right'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: {
                // buttons: [],
                dom: {
                    button: {
                        className: 'h4 btn btn-secondary dt-button-custom'
                    },
                    buttonLiner: {
                        tag: null
                    }
                }
            },
            lengthMenu: [
                [10, 25, 50, 100, -1],
                ['10', '25', '50', '100', 'Tout afficher']
            ],
            iDisplayLength: 10,
            "order": [
                [1, "desc"]
            ],
            language: {
                // "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json",
                processing: "Traitement en cours...",
                search: "_INPUT_",
                lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
                info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                infoPostFix: "",
                loadingRecords: "Chargement en cours...",
                zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
                emptyTable: "", //emptyTable: "Aucune donnée disponible dans le tableau",
                paginate: {
                    first: "Premier",
                    previous: "Pr&eacute;c&eacute;dent",
                    next: "Suivant",
                    last: "Dernier"
                },
                aria: {
                    sortAscending: ": activer pour trier la colonne par ordre croissant",
                    sortDescending: ": activer pour trier la colonne par ordre décroissant"
                },
                buttons: {
                    pageLength: {
                        _: "Afficher %d éléments",
                        '-1': "Tout afficher"
                    }
                }
            }
        });
        table.buttons().container().appendTo('.custom_buttons');
        //table.columns(0).visible(false);
        $('#modeType').click(function() {
            var typeMode = $('#modeType').val();
            table.columns(0).search(typeMode).draw();
        });


    });


    function importPrestationExel() {
        $('#div-listePrestationExel').hide();
        $('#div-importPrestationExel').show();
    }

    function RetourimportPrestationExel() {
        $('#div-listePrestationExel').show();
        $('#div-importPrestationExel').hide();
    }
    document.getElementById("btnPrintGenerik").onclick = function() {
        printElementNew(document.getElementById("div-listePrestationExel"));
    }
    document.getElementById("btnDownloadGenerik").onclick = function() {
        var name = 'facture-' + new Date().toJSON().slice(0, 10).replace(/-/g, '/');
        $('.ignorepdf').hide();
        downloadElementNew('invoice', name);

    }

    function compteDebite(eventObj) {
        var soldeService = document.getElementById('serviceDisponible');
        var soldeEncaissement = document.getElementById('encaissementDisponible');
        var btnService = document.getElementById('btnService');
        var btnEncaissement = document.getElementById('btnEncaissement');
        var btnDefault = document.getElementById('btnDefault');
        var errorTransfert = document.getElementById('errorTransfert');
        var errorTransfertSolde = document.getElementById('errorTransfertSolde');
        var amountValidation = $('#amountValidation').val();
        var formCustmer = $('#id_origin').val();
        var pin = $('#pin_origin').val();
        var to_Custmer = $('#id_destinataire').val();
        var to_pin = $('#pin_destinataire').val();
        var soldeServiceInitial = $('#soldeServiceInitial').val();
        var soldeServiceFormat = parseInt(soldeServiceInitial.replace(/[^\d]/g, ''));
        var soldeEncaissementInitial = $('#soldeEncaissementInitial').val();
        var soldeEncaissementFormat = parseInt(soldeEncaissementInitial.replace(/[^\d]/g, ''));
        // var bouttonOrangeMoney = document.getElementById('bouttonOrangeMoney');
        // var cacheamount_received = document.getElementById('cacheamount_received');
        errorTransfert.style['display'] = 'none';
        errorTransfertSolde.style['display'] = 'none';
        // alert("solde service"+soldeServiceFormat+" montant"+amountValidation);
        // alert(typeof soldeServiceFormat);
        // alert(typeof soldeEncaissementFormat);
        // alert(typeof amountValidation);
        if (eventObj.target.value == 'service') {
            soldeService.style['display'] = 'block';
            btnService.style['display'] = 'block';
            soldeEncaissement.style['display'] = 'none';
            btnEncaissement.style['display'] = 'none';
            btnDefault.style['display'] = 'none';
            if (formCustmer == to_Custmer) {
                btnDefault.style['display'] = 'block';
                errorTransfert.style['display'] = 'block';
                soldeService.style['display'] = 'none';
                soldeEncaissement.style['display'] = 'none';
                btnService.style['display'] = 'none';
                btnEncaissement.style['display'] = 'none';
            } else if (amountValidation > soldeServiceFormat) {
                errorTransfertSolde.style['display'] = 'block';
                btnDefault.style['display'] = 'block';
                soldeService.style['display'] = 'block';
                soldeEncaissement.style['display'] = 'none';
                btnService.style['display'] = 'none';
                btnEncaissement.style['display'] = 'none';

            }

        } else if (eventObj.target.value == 'encaissement') {
            soldeService.style['display'] = 'none';
            btnService.style['display'] = 'none';
            soldeEncaissement.style['display'] = 'block';
            btnEncaissement.style['display'] = 'block';
            btnDefault.style['display'] = 'none';
            if (formCustmer == to_Custmer) {
                btnDefault.style['display'] = 'block';
                errorTransfert.style['display'] = 'block';
                soldeService.style['display'] = 'none';
                soldeEncaissement.style['display'] = 'none';
                btnService.style['display'] = 'none';
                btnEncaissement.style['display'] = 'none';
            } else if (amountValidation > soldeEncaissementFormat) {
                errorTransfertSolde.style['display'] = 'block';
                btnDefault.style['display'] = 'block';
                soldeService.style['display'] = 'none';
                soldeEncaissement.style['display'] = 'block';
                btnService.style['display'] = 'none';
                btnEncaissement.style['display'] = 'none';

            }
        } else {
            btnDefault.style['display'] = 'block';
            soldeService.style['display'] = 'none';
            soldeEncaissement.style['display'] = 'none';
            btnService.style['display'] = 'none';
            btnEncaissement.style['display'] = 'none';
        }

    }

    function recuperationOM(event) {
        var btvalidationOrange = document.getElementById('validationOrange');
        var phone = $('#mobNo').val();
        var phoneFormat = phone.replace(/[^\d]/g, '');
        var nbreCaratere = parseInt(phoneFormat.length);
        if (nbreCaratere != 12) {
            btvalidationOrange.disabled = true;
        } else {
            btvalidationOrange.disabled = false;
        }
    }

    function validation(event) {
        var btrediriger = document.getElementById('rediriger');
        btrediriger.disabled = true;
        var mobRef = $('#mobRef').val();
        var ref = /PP\d{6}\.\d{4}\.[A-Z]\d{5}/.test(mobRef);
        if (ref == true) {
            btrediriger.disabled = false;
            document.getElementById('refMobRef2').value = mobRef;
        } else {
            bt.disabled = true;
        }
    }

    function reloadPage() {
        window.location.reload(true);
    }

    function formatCurrencyFacturaction(number) {
        return (number || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' FCFA';
    }
</script>
<script>
    var datejourFooter = $('#datejourfooter').val();
    var dateFooter = datejourFooter.match(/\d{2}\/\d{2}\/\d{4}/)[0];
    var Heure = datejourFooter.match(/\d{2}:\d{2}/)[0];
    var dateHeure = $('#dateEmise').val();
    //var dateHeure = '13/03/2020';
    var codeFacture = $('#codeFacture').val();
    var destinataireNom = $('#destinataireNom').val();
    var destinataireAdresse = $('#destinataireAdresse').val();
    var destinataireAdresseFooter = $('#destinataireAdresse').val();
    var destinatairePays = $('#destinatairePays').val();
    var destinatairePortable_responsable_legal = $('#destinatairePortable_responsable_legal').val();
    var destinatairePortable_responsable_Footer = $('#destinatairePortable_responsable_legal').val();
    var destinataireEmail = $('#destinataireEmail').val();
    var destinataireEmailFooter = $('#destinataireEmail').val();
    var destinataireFixe = $('#destinataireFixe').val();
    var destinataireRegion = $('#destinataireRegion').val();
    var origineNom = $('#origineNom').val();
    var origineAdresse = $('#origineAdresse').val();
    var originePays = $('#originePays').val();
    var originePortable_responsable_legal = $('#originePortable_responsable_legal').val();
    var origineEmail = $('#origineEmail').val();
    var origineRegion = $('#origineRegion').val();
    var origineFixe = $('#origineFixe').val();
    var dateDebut = $('#dateDebut').val();
    var dateFin = $('#dateFin').val();
    var echeance = $('#echeance').val();
    var nomOrganisation = 'Hopital ZFS';
    var users = $('#users').val();
    var htFacture = document.querySelector('.htFacture').textContent;
    var tvaFacture = document.querySelector('.tvaFacture').textContent;
    var ttcFacture = document.querySelector('.ttcFacture').textContent;
    var descOrganisation = $('#descOrganisation').val();
    var slogan = $('#slogan').val();
    var horaire = $('#horaire').val();
    var horaireOuverture = document.getElementById('horaireOuverture').innerText;

    // var address = $('#address').val();
    var address = 'Dakar - Guédiawaye';
    // var phone = $('#phone').val();
    var phone = '221781156335';
    // var email = $('#email').val();
    var email = 'ibnou@gmail.com';
    // var beneficiaire = $('#beneficiaire').val();
    var beneficiaire = 'IBNOU ABASS DIAGNE';
    // var typeOperation = $('#typeOperation').val();
    var typeOperation = 'Achat Crédit';
    // var reference = $('#reference').val();
    var reference = 'ID Zuulupay';

    // portable 
    if (destinatairePortable_responsable_Footer == '') {
        destinatairePortable_responsable_Footer = '';
    } else {
        destinatairePortable_responsable_Footer = 'Tel : ' + destinatairePortable_responsable_Footer + ', ';
    }
    // fin portable

    // adresse
    if (destinataireAdresseFooter == '') {
        destinataireAdresseFooter = '';
    } else {
        destinataireAdresseFooter = 'Adresse : ' + destinataireAdresseFooter + ', ';
    }
    // fin Adresse 

    // adresse
    if (destinataireEmailFooter == '') {
        destinataireEmailFooter = '';
    } else {
        destinataireEmailFooter = 'Email : ' + destinataireEmailFooter;
    }
    // fin Adresse 

    // Origin adresse
    if (origineAdresse == '') {
        origineAdresse = 'Non renseigné';
    } else {
        origineAdresse = origineAdresse;
    }
    // fin origin Adresse 

    // Origin portable
    if (originePortable_responsable_legal == '') {
        originePortable_responsable_legal = 'Non renseigné';
    } else {
        originePortable_responsable_legal = originePortable_responsable_legal;
    }
    // fin originePortable_responsable_legal 

    // Origin fixe
    if (origineFixe == '') {
        origineFixe = 'Non renseigné';
    } else {
        origineFixe = origineFixe;
    }
    // fin fixe 

    // Origin Email
    if (origineEmail == '') {
        origineEmail = 'Non renseigné';
    } else {
        origineEmail = origineEmail;
    }
    // fin fixe 


    // DESTINATAIRE

    // destinataire adresse
    if (destinataireAdresse == '') {
        destinataireAdresse = 'Non renseigné';
    } else {
        destinataireAdresse = destinataireAdresse;
    }
    // fin destinataire Adresse 

    // destinataire portable
    if (destinatairePortable_responsable_legal == '') {
        destinatairePortable_responsable_legal = 'Non renseigné';
    } else {
        destinatairePortable_responsable_legal = destinatairePortable_responsable_legal;
    }
    // fin destinatairePortable_responsable_legal 

    // destinataire fixe
    if (destinataireFixe == '') {
        destinataireFixe = 'Non renseigné';
    } else {
        destinataireFixe = destinataireFixe;
    }
    // fin fixe 

    // destinataire Email
    if (destinataireEmail == '') {
        destinataireEmail = 'Non renseigné';
    } else {
        destinataireEmail = destinataireEmail;
    }
    // fin fixe 

    async function download() {
        // pdfMake.createPdf(dd).download();
        await pdfMake.createPdf(dd).download('Facture_' + codeFacture + '.pdf');
        setTimeout(() => {
            window.location.reload(true);
        }, 2000);

    }

    async function print() {
        pdfMake.createPdf(dd).print();
        setTimeout(() => {
            window.location.reload(true);
        }, 2000);
    }

    var dd = {
        pageSize: 'A4',
        footer: function(currentPage, pageCount) {
            return {
                table: {
                    widths: ['*', 100],
                    body: [
                        [{
                                text: destinataireNom + ', ' + destinataireAdresseFooter + destinatairePortable_responsable_Footer + ', Imprimé par : ' + users + ', le ' + dateFooter + ' à ' + Heure,
                                alignment: 'center',
                                fontSize: 9,
                            },
                            {
                                text: 'Page ' + pageCount,
                                alignment: 'right'
                            }
                        ]
                    ]
                },
                layout: 'noBorders'
            };
        },
        content: [
            'Page Contents'
        ],
        content: [{
                alignment: 'justify',
                columns: [

                    {
                        image: '/images/logo.png',
                        alignment: 'left',
                        widths: 100
                    },
                    {
                        text: [descOrganisation + '\n' + slogan + '\n' + horaire + '\n', {
                            text: horaireOuverture,
                            color: 'gray',
                            italics: true
                        }],
                        alignment: 'center',
                        widths: [100, '*']
                    },

                    {
                        text: 'FACTURE',
                        style: 'header',
                        color: '#0D4D99',
                        margin: 30,
                        widths: ['*', 150]
                    }
                ]
            },
            {
                canvas: [{
                    type: 'line',
                    x1: 0,
                    y1: 5,
                    x2: 595 - 2 * 40,
                    y2: 5,
                    lineWidth: 0,
                    color: '#DADCD4'
                }]
            },
            {
                text: '',
                style: 'header'
            },
            {
                alignment: 'justify',
                columns: [
                    [{
                        text: 'Emise le :',
                        style: 'tableHeader',
                        fit: [50, 50]
                    }, {
                        text: dateHeure,
                        fit: [50, 50]
                    }],
                    [{
                        text: 'Numéro Facture :',
                        style: 'tableHeader',
                        fit: [50, 50],
                        alignment: 'right'
                    }, {
                        text: codeFacture,
                        fit: [50, 50],
                        alignment: 'right'
                    }],
                    // {
                    //   text: 'Numéro Facture : FA03230', style: 'tableHeader', alignment: 'right',
                    //   widths: ['*', '*', '*', 200]
                    // }
                ]
            },
            {
                canvas: [{
                    type: 'line',
                    x1: 0,
                    y1: 5,
                    x2: 595 - 2 * 40,
                    y2: 5,
                    lineWidth: 0,
                    color: '#DADCD4'
                }]
            },
            {
                alignment: 'justify',
                columns: [
                    [{
                        text: 'Période :',
                        style: 'tableHeader',
                        fit: [50, 50]
                    }, {
                        text: 'Du ' + dateDebut + ' Au ' + dateFin,
                        fit: [50, 50]
                    }],
                    [{
                        text: 'A payer avant le :',
                        style: 'tableHeader',
                        fit: [50, 50],
                        alignment: 'right'
                    }, {
                        text: echeance,
                        fit: [50, 50],
                        alignment: 'right'
                    }],
                    // {
                    //   text: 'Numéro Facture : FA03230', style: 'tableHeader', alignment: 'right',
                    //   widths: ['*', '*', '*', 200]
                    // }
                ]
            },
            {
                canvas: [{
                    type: 'line',
                    x1: 0,
                    y1: 5,
                    x2: 595 - 2 * 40,
                    y2: 5,
                    lineWidth: 0,
                    color: '#DADCD4'
                }]
            },
            {
                text: '',
                style: 'header'
            },

            {
                style: 'tableExample',
                layout: 'noBorders',
                table: {
                    headerRows: 1,
                    widths: [170, 120, '*'],

                    // dontBreakRows: true,
                    // keepWithHeaderRows: 1,
                    body: [
                        [{
                            text: destinataireNom,
                            style: 'tableHeader',
                            color: '#0D4D99'
                        }, {
                            text: '',
                            style: 'tableHeader'
                        }, {
                            text: origineNom,
                            style: 'tableHeader',
                            color: '#0D4D99'
                        }],
                        [{
                                text: [{
                                        text: 'Adresse : ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    destinataireAdresse + '\n',
                                    {
                                        text: 'Téléphone mobile: ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    destinatairePortable_responsable_legal + '\n',
                                    {
                                        text: 'Téléphone Fixe : ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    destinataireFixe + '\n',
                                    {
                                        text: 'Email : ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    destinataireEmail + '\n',
                                ],

                            },
                            {
                                text: ''
                            },
                            {
                                text: [{
                                        text: 'Adresse : ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    origineAdresse + '\n',
                                    {
                                        text: 'Téléphone mobile : ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    originePortable_responsable_legal + '\n',
                                    {
                                        text: 'Téléphone Fixe : ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    origineFixe + '\n',
                                    {
                                        text: 'Email : ',
                                        fontSize: 12,
                                        bold: true
                                    },
                                    origineEmail + '\n',
                                ],
                            },


                        ]
                    ],

                }
            },
            {
                text: '',
                style: 'header'
            },
            {
                style: 'tableExample',
                table: {
                    widths: [60, 80, 80, '*', 80],
                    headerRows: 1,
                    lineColor: '#0D4D99',
                    body: [
                        [{
                                text: 'Date',
                                style: 'tableHeader',
                                color: '#0D4D99'
                            }, {
                                text: 'Référence',
                                style: 'tableHeader',
                                color: '#0D4D99'
                            }, {
                                text: 'Patient',
                                style: 'tableHeader',
                                color: '#0D4D99'
                            },
                            {
                                text: 'Prestation',
                                style: 'tableHeader',
                                color: '#0D4D99'
                            },
                            {
                                text: 'Montant',
                                style: 'tableHeader',
                                alignment: 'right',
                                color: '#0D4D99'
                            },
                        ],
                        ...Array.from(document.querySelectorAll('.ligneFacture'))
                        .map(e => ([{
                                text: e.querySelector('.dateFacture').textContent,
                                fontSize: 10,
                            },
                            {
                                text: e.querySelector('.codeFacture').textContent,
                                fontSize: 10,
                            },
                            {
                                text: e.querySelector('.codePatientFacture').textContent,
                                fontSize: 10,
                            },
                            {
                                text: e.querySelector('.prestationFacture').textContent,
                                fontSize: 10,
                            },
                            {
                                text: e.querySelector('.montantFacture').textContent,
                                fontSize: 10,
                                alignment: 'right'
                            },
                        ])),
                    ]
                },
                layout: 'lightHorizontalLines',
            },
            {
                style: 'tableExample',
                table: {
                    widths: ['*', 130, 80],
                    body: [
                        [{
                            rowSpan: 3,
                            text: ''
                        }, 'Total HT', {
                            text: htFacture,
                            alignment: 'right'
                        }],
                        [{
                            rowSpan: 3,
                            text: ''
                        }, 'TVA', {
                            text: tvaFacture,
                            alignment: 'right'
                        }],
                        [{
                            rowSpan: 3,
                            text: ''
                        }, 'Total TTC', {
                            text: ttcFacture,
                            alignment: 'right'
                        }],
                    ]
                },
                layout: {
                    fillColor: function(rowIndex, node, columnIndex) {
                        return '#F7F7F7';
                    }
                }
            },
            {
                canvas: [{
                    type: 'line',
                    x1: 0,
                    y1: 5,
                    x2: 595 - 2 * 40,
                    y2: 5,
                    lineWidth: 0,
                    color: '#DADCD4'
                }]
            },
            {
                text: '',
                style: 'header'
            },
            // {
            //     alignment: 'justify',
            //     columns: [
            //         [{
            //             text: 'Effectué par :',
            //             style: 'tableHeader',
            //             fit: [50, 50]
            //         }, {
            //             text: effectuerPar,
            //             fit: [50, 50]
            //         }],
            //         //[{ text: 'Numéro Facture :', style: 'tableHeader',fit: [50, 50],alignment: 'right'}, { text: 'FA03230',fit: [50, 50],alignment: 'right'}],
            //         // {
            //         //   text: 'Numéro Facture : FA03230', style: 'tableHeader', alignment: 'right',
            //         //   widths: ['*', '*', '*', 200]
            //         // }
            //     ]
            // },
        ],
        styles: {
            header: {
                fontSize: 18,
                bold: true,
                margin: [0, 0, 0, 10]
            },
            subheader: {
                fontSize: 16,
                bold: true,
                margin: [0, 10, 0, 5]
            },
            tableExample: {
                margin: [0, 5, 0, 15]
            },
            tableHeader: {
                bold: true,
                fontSize: 13,
                color: 'black'
            }
        },
        defaultStyle: {
            // alignment: 'justify'
        }

    }


    function toDataURL(url, callback) {
        var xhr = new XMLHttpRequest();
        xhr.onload = function() {
            var reader = new FileReader();
            reader.onloadend = function() {
                callback(reader.result);
            }
            reader.readAsDataURL(xhr.response);
        };
        xhr.open('GET', url);
        xhr.responseType = 'blob';
        xhr.send();
    }
    var logo = $('#logo2').val();
    toDataURL(logo, function(dataUrl) {
        console.log('RESULT:', dataUrl);
        dd.content[0].columns[0].image = dataUrl;
    })
    document.querySelectorAll('.ligneFacture').forEach(e => {
        console.log(e.querySelector('.dateFacture').textContent);
        console.log(e.querySelector('.codeFacture').textContent);
        console.log(e.querySelector('.codePatientFacture').textContent);
        console.log(e.querySelector('.prestationFacture').textContent);
        console.log(e.querySelector('.montantFacture').textContent);
    })

    const avengers = ['thor', 'captain america', 'hulk'];
    avengers.forEach((item, index) => {
        console.log(index, item)
    })
</script>