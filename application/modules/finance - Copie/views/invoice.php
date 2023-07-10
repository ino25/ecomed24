<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- invoice start-->
        <section class="col-md-6">
            <div class="panel panel-primary" id="invoice">
                <!--<div class="panel-heading navyblue"> INVOICE</div>-->
                <div class="panel-body" style="font-size: 10px;">
                    <div class="row invoice-list">

                        <!--<div class="col-md-12 invoice_head clearfix">

                            <div class="col-md-6 text-left invoice_head_left">
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
                            <div class="col-md-6 text-right invoice_head_right">
                                <img alt="" src="<?php echo $this->settings_model->getSettings()->logo; ?>" width="200" height="100">
                            </div>



                        </div>-->
						<div class="col-md-12 invoice_head clearfix">

                            <div class="col-md-4 text-center invoice_head_left">
                                <img src="<?php echo !empty($path_logo) ? $path_logo : "uploads/logosPartenaires/default.png"; ?>" style="max-width:180px;max-height:80px;"/>
								
                            </div>
                            <div class="col-md-8 text-center invoice_head_right">
                                <h6><?php echo !empty($organisation) ? $organisation->description_courte_activite : ""; ?><h6>
                                <h3 style="margin-top:2px;margin-bottom:2px;">
								<?php echo $nom_organisation; ?>
								</h3>
                                <span><?php echo !empty($organisation) ? $organisation->description_courte_services : ""; ?></span>
                                <h6 style="text-transform:italic;"><?php echo !empty($organisation) ? $organisation->slogan : ""; ?></h6>
								
                                <h6><?php echo !empty($organisation) && !empty($organisation->horaires_ouverture) ? "Horaires d'ouverture:" : ""; ?></h6>
								<p>
								<?php echo !empty($organisation) ? $organisation->horaires_ouverture : ""; ?>
								</p>
                            </div>
                        </div>
						<div class="col-md-12 hr_border">
                            <hr>
                        </div>
						<div class="col-md-12 clearfix" style="margin-top:2px;">

                            <div class="col-md-12">
                                <p class="pull-left">
									<?php echo !empty($organisation) ? $organisation->prenom_responsable_legal2." ".$organisation->nom_responsable_legal2 : ""; ?><br/>
									<?php echo !empty($organisation) ? $organisation->fonction_responsable_legal2 : ""; ?><br/>
									<?php echo !empty($organisation) ? $organisation->description_courte_responsable_legal2 : ""; ?>
								</p>
                                <p class="text-right pull-right">
									<?php echo !empty($organisation) ? $organisation->prenom_responsable_legal." ".$organisation->nom_responsable_legal : ""; ?><br/>
									<?php echo !empty($organisation) ? $organisation->fonction_responsable_legal : ""; ?><br/>
									<?php echo !empty($organisation) ? $organisation->description_courte_responsable_legal : ""; ?>
								</p>
                            </div>
                        </div>

                        <div class="col-md-12 hr_border">
                            <hr>
                        </div>


                        <div class="col-md-12">
                            <h4 class="text-center" style="font-weight: bold; margin-top: 20px; text-transform: uppercase;">
                                <?php echo lang('invoice') ?>
                            </h4>
                        </div>

                        <div class="col-md-12 hr_border">
                            <hr>
                        </div>


                        <div class="col-md-12">
                            <div class="col-md-6 pull-left row" style="text-align: left;">
                                <div class="col-md-12 row details" style="">
                                    <p>
                                        <?php $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row(); ?>
                                        <label class="control-label"><?php echo lang('patient'); ?> </label>
                                        <span style="text-transform: uppercase;"> : 
                                            <?php
                                            if (!empty($patient_info)) {
                                                echo $patient_info->name .'  '.$patient_info->last_name.' <br>';
                                            }
                                            ?>
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-12 row details" style="">
                                    <p>
                                        <label class="control-label"><?php echo lang('number'); ?>  </label>
                                        <span style="text-transform: uppercase;"> : 
                                            <?php
                                            if (!empty($patient_info)) {
                                                echo $patient_info->patient_id . ' <br>';
                                            }
                                            ?>
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-12 row details" style="">
                                    <p>
                                        <label class="control-label"> <?php echo lang('address'); ?> </label>
                                        <span style="text-transform: uppercase;"> : 
                                            <?php
                                            if (!empty($patient_info)) {
                                                echo $patient_info->address . ' <br>';
                                            }
                                            ?>
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-12 row details" style="">
                                    <p>
                                        <label class="control-label"><?php echo lang('phone'); ?>  </label>
                                        <span style="text-transform: uppercase;"> : 
                                            <?php
                                            if (!empty($patient_info)) {
                                                echo $patient_info->phone . ' <br>';
                                            }
                                            ?>
                                        </span>
                                    </p>
                                </div>


                            </div>

                            <div class="col-md-6 pull-right" style="text-align: left;">

                                <div class="col-md-12 row details" style="">
                                    <p>
                                        <label class="control-label"><?php echo lang('invoice'); ?>  </label>
                                        <span style="text-transform: uppercase;"> : 
                                            <?php
                                            if (!empty($payment->id)) {
                                                echo $payment->code;
                                            }
                                            ?>
                                        </span>
                                    </p>
                                </div>


                                <div class="col-md-12 row details">
                                    <p>
                                        <label class="control-label"><?php echo lang('date'); ?>  </label>
                                        <span style="text-transform: uppercase;"> : 
                                            <?php
                                            if (!empty($payment->date)) {
                                                echo date('d/m/Y', $payment->date) . ' <br>';
                                            }
                                            ?>
                                        </span>
                                    </p>
                                </div>

                                <div class="col-md-12 row details">
                                    <p>
                                        <label class="control-label"><?php echo lang('service'); ?>  </label>
                                        <span style="text-transform: uppercase;"> : 
                                            <?php
                                            if (!empty($payment->service)) {
                                                $doc_details = $this->service_model->getServiceById($payment->service);
                                                if (!empty($doc_details)) {
                                                    echo $doc_details->name_service . ' <br>';
                                                }
                                            }
                                            ?>
                                        </span>
                                    </p>
                                </div>



                            </div>

                        </div>






                    </div> 

                    <div class="col-md-12 hr_border">
                        <hr>
                    </div>




                    <table class="table table-striped table-hover">

                        <thead class="theadd">
                            <tr>
                                <th>#</th>
                                <th><?php echo lang('description'); ?></th>
                                <th><?php echo lang('unit_price'); ?></th>
                                <th><?php echo lang('qty'); ?></th>
                                <th><?php echo lang('amount'); ?></th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (!empty($payment->category_name)) {
                                $category_name = $payment->category_name;
                                $category_name1 = explode(',', $category_name);
                                $i = 0;
                                foreach ($category_name1 as $category_name2) {
                                    $i = $i + 1;
                                    $category_name3 = explode('*', $category_name2);
                                    if ($category_name3[3] > 0 && $category_name3[1]) {
                                       ?>  

                                        <tr>
                                            <td><?php echo $i; ?> </td>
                                            <td><?php echo $this->finance_model->getPaymentcategoryById($category_name3[0])->prestation; ?> </td>
                                            <td class=""><?php echo number_format($category_name3[1], 0, ",", "."); ?>  <?php echo $settings->currency; ?> </td>
                                            <td class=""> <?php echo $category_name3[3]; ?> </td>
                                            <td class=""> <?php echo number_format($category_name3[1] * $category_name3[3], 0, ",", "."); ?> <?php echo $settings->currency; ?></td>
											<td class="no-print" style="padding-top:2px;">
											<?php
											// Check si de Type Labos
											$prestation_en_cours = $this->finance_model->getPaymentCategoryByOrganisationById2($category_name3[0]);
											$est_labo = $prestation_en_cours->code_service == "labo" ? TRUE : FALSE;
											if($est_labo) {
											?>
												<a style="cursor: pointer;" class="pull-right editbutton2" data-toggle="modal" data-id="<?php echo $category_name2; ?>">
												<div class="pull-right" style="font-size:24px;color:#f7bb19;"><i class="fa fa-ticket-alt" style="margin-top:0;"></i></div>
												</a>
											<?php
											}
											?>
											</td>
                                        </tr>
                                        <?php
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

                    <div class="">
                        <div class="col-lg-4 invoice-block pull-right">
                            <ul class="unstyled amounts">
                                <li><strong><?php echo lang('sub_total'); ?> : </strong><?php echo number_format($payment->amount, 0, ",", "."); ?> <?php echo $settings->currency; ?> </li>
                                <?php if (!empty($payment->remarks)) { ?>
                                <li><strong><?php echo lang('nom_mutuelle'); ?> : </strong> <?php echo $payment->remarks; ?></li>
                                 <li><strong><?php echo lang('charge_mutuelless'); ?> : </strong> <?php echo  number_format($payment->charge_mutuelle, 0, ",", "."); ?> <?php echo $settings->currency; ?> </li>
                                  <?php } ?>
                                    <li><strong><?php echo lang('discount'); ?> : </strong>  <?php
                                        $discount = explode('*', $payment->discount);
                                        if (!empty($discount[1])) {
                                            echo $discount[0] . ' %  =  ' . $settings->currency . ' ' . $discount[1];
                                        } else {
                                            echo number_format($discount[0], 0, ",", ".");
                                        }
                                        ?>
                                    <?php
                                        if ($discount_type == 'percentage') {
                                            echo '(%) : ';
                                        } else {
                                            echo ' ' . $settings->currency;
                                        }
                                        ?>
                                    </li>
                                   
                                    <?php if (!empty($payment->vat)) { ?>
                                    <li><strong>VAT :</strong>   <?php
                                        if (!empty($payment->vat)) {
                                            echo $payment->vat;
                                        } else {
                                            echo '0';
                                        }
                                        ?> % = <?php echo number_format($payment->flat_vat, 0, ",", "."); ?> <?php echo $settings->currency; ?> </li>
                                <?php } ?>
                                <li><strong><?php echo lang('grand_total'); ?> : </strong> <?php $g = $payment->gross_total; echo number_format($g, 0, ",", "."); ?> <?php echo $settings->currency; ?> </li>
                                <li><strong><?php echo lang('amount_received'); ?> : </strong> <?php $r = $this->finance_model->getDepositAmountByPaymentId($payment->id); echo number_format($r, 0, ",", "."); ?>  <?php echo $settings->currency; ?> </li>
                                <li><strong><?php echo lang('amount_to_be_paid'); ?> : </strong><?php $rp = $g - $r; echo number_format($rp, 0, ",", "."); ?>  <?php echo $settings->currency; ?> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12 invoice_footer">
                        <div class="row pull-left" style="">
                           <strong><?php echo lang('effectuer_par'); ?> : </strong>
                        </div><br>
                        <div class="row pull-left" style="">
                        <?php echo $this->ion_auth->user()->row()->first_name .' '.$this->ion_auth->user()->row()->last_name; ?>
                        </div>
                    </div>
                    <div class="col-md-12 hr_border">
                        <hr>
                    </div>
                   
                </div>
                <div class="text-center">
                        20<?php echo date('y'); ?> &copy;  Powered by ecoMed24.
                     </div>
        </section>


        <section class="col-md-6">
            <div class="col-md-5 no-print" style="margin-top: 20px;">
                 <?php 
 $page = '';
 if(isset($_GET['page'])){
          $page = $_GET['page'];                                           
 } ?>
                 <?php if($page == 'patient'){  ?>
                                                        <a href="patient/medicalHistory?id=<?php echo $payment->patient; ?>&type=payment" class="btn btn-info btn-sm info pull-left"><i class="fa fa-arrow-circle-left"></i>  <?php echo lang('back_to_patient'); ?> </a> 
                                                      <?php } else if($page == 'historique'){ ?>
                                                          <a href="finance/patientPaymentHistory?patient=<?php echo $payment->patient; ?>" class="btn btn-info btn-sm info pull-left"><i class="fa fa-arrow-circle-left"></i>  <?php echo lang('back_to_payment_histo'); ?>  </a>
 <?php } ?>
                                                          
                 <?php   if ($this->ion_auth->in_group(array('Receptionist'))) { ?>
                <a href="finance/payment" class="btn btn-info btn-sm info pull-left"><i class="fa fa-arrow-circle-left"></i>  <?php echo lang('back_to_payment_modules'); ?> </a>
              <?php   } else { ?>
                  <a href="finance/paymentLabo" class="btn btn-info btn-sm info pull-left"><i class="fa fa-arrow-circle-left"></i>  <?php echo lang('back_to_payment_modules'); ?> </a>
            <?php  } ?>
                <div class="text-center col-md-12 row">
                    <a class="btn btn-info btn-sm invoice_button pull-left" id="btnPrint0"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
                  
                    <a class="btn btn-info btn-sm detailsbutton pull-left download" id="download" style="display:none;"><i class="fa fa-download"></i> <?php echo lang('download'); ?> </a>
                </div>

                <div class="no-print" style="display:none;">
                    <a href="finance/addPaymentView" class="pull-left">
                        <div class="btn-group">
                            <button id="" class="btn btn-info green btn-sm">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('add_another_payment'); ?>
                            </button>
                        </div>
                    </a>

                </div>

                <div class="panel_button" style="display:none;">

                    <div class="text-center invoice-btn no-print pull-left ">
                        <a href="finance/previousInvoice?id=<?php echo $payment->id ?>"class="btn btn-info btn-lg green previousone1"><i class="glyphicon glyphicon-chevron-left"></i> </a>
                        <a href="finance/nextInvoice?id=<?php echo $payment->id ?>"class="btn btn-info btn-lg green nextone1 "><i class="glyphicon glyphicon-chevron-right"></i> </a>

                    </div>

                </div>

            </div>

        </section>


        <style>

            th{
                text-align: center;
            }

            td{
                text-align: center;
            }

            tr.total{
                color: green;
            }



            .control-label, .control-label2{
                width: 100px;
            }
			.control-label2{
                font-weight:800;
            }



            h1{
                margin-top: 5px;
            }


            .print_width{
                width: 50%;
                float: left;
            } 

            ul.amounts li {
                padding: 0px !important;
            }

            .invoice-list {
                margin-bottom: 10px;
            }




            .panel{
                border: 0px solid #5c5c47;
                background: #fff !important;
                height: 100%;
                margin: 20px 5px 5px 5px;
                border-radius: 0px !important;
                min-height: 700px;

            }



            .table.main{
                margin-top: -50px;
            }



            .control-label, .control-label2{
                margin-bottom: 0px;
            }

            tr.total td{
                color: green !important;
            }

            .theadd th{
                background: #edfafa !important;
                background: #fff!important;
            }

            td{
                font-size: 12px;
                padding: 5px;
                font-weight: bold;
            }

            .details{
                font-weight: bold;
            }

            hr{
                border-bottom: 0px solid #f1f1f1 !important;
            }

            .corporate-id {
                margin-bottom: 5px;
            }

            .adv-table table tr td {
                padding: 5px 10px;
            }



            .btn{
                margin: 10px 10px 10px 0px;
            }

            .invoice_head_left h3{
                color: #2f80bf !important;
                font-family: cursive;
            }


            .invoice_head_right{
                margin-top: 10px;
            }

            .invoice_footer{
                margin-bottom: 10px;
            }










            @media print {

                h1{
                    margin-top: 5px;
                }

                #main-content{
                    padding-top: 0px;
                }

                .print_width{
                    width: 50%;
                    float: left;
                } 

                ul.amounts li {
                    padding: 0px !important;
                }

                .invoice-list {
                    margin-bottom: 10px;
                }

                .wrapper{
                    margin-top: 0px;
                }

                .wrapper{
                    padding: 0px 0px !important;
                    background: #fff !important;

                }



                .wrapper{
                    border: 2px solid #777;
                }

                .panel{
                    border: 0px solid #5c5c47;
                    background: #fff !important;
                    padding: 0px 0px;
                    height: 100%;
                    margin: 5px 5px 5px 5px;
                    border-radius: 0px !important;

                }

                .site-min-height {
                    min-height: 950px;
                }



                .table.main{
                    margin-top: -50px;
                }



                .control-label{
                    margin-bottom: 0px;
                }

                tr.total td{
                    color: green !important;
                }

                .theadd th{
                    background: #777 !important;
                }

                td{
                    font-size: 12px;
                    padding: 5px;
                    font-weight: bold;
                }

                .details{
                    font-weight: bold; 
                }

                hr{
                    border-bottom: 0px solid #f1f1f1 !important;
                }

                .corporate-id {
                    margin-bottom: 5px;
                }

                .adv-table table tr td {
                    padding: 5px 10px;
                }

                .invoice_head{
                    width: 100%;
                }

                .invoice_head_left{
                    float: left;
                    width: 40%;
                    color: #2f80bf;
                    font-family: cursive;
                }

                .invoice_head_right{
                    float: right;
                    width: 40%;
                    margin-top: 10px;
                }

                .hr_border{
                    width: 100%;
                }

                .invoice_footer{
                    margin-bottom: 10px;
                }


            }

			.modal-dialog {
			  max-width: 350px; /* New width for default modal */
			}
		
	
        </style>
        <style id="dynamic-style">
		/* Default pour Modal */
			@media screen {
			  #printSection {
				  display: none;
			  }
			}

			@media print {
			  body {
				overflow:hidden;
			  }
			  body * {
				visibility:hidden;
			  }
			  #printSection, #printSection * {
				visibility:visible;
			  }
			  #printSection {
				position:absolute;
				left:0;
				top:0;
			  }
			}
        </style>


		<!-- Edit Event Modal-->
		<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header no-print" style="border-bottom:0;">
					<div class="panel-body" style="font-size: 10px;">
							<!--<div class="row invoice-list">
								<div class="col-md-12" style="">

									<div class="col-md-12 row details" style="">-->
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<!--<h4 class="modal-title" style="text-align:center;">Labels d'échantillons</h4>-->
						<!--</div>
						</div>
						</div>-->
					</div>
					</div>
					<div class="modal-body">
						<!--<div class="panel-body" style="font-size: 10px;">-->
							<div class="row invoice-list" style="font-size: 10px;">
								<div class="col-md-12" style="">
		
									<div class="col-md-12 row details" style="">
										<p>
											<span style="text-transform: uppercase;"> 
											<label class="control-label2">ID Acte: </label>
											<span class="modal_id_acte">
											...
											</span>
											</span>
										</p>
									</div>
									<div class="col-md-12 row details" style="">
										<p>
											<span style="text-transform: uppercase;"> 
											<label class="control-label2">Patient: </label>
											<span class="modal_identite_patient">
											...
											</span>
											</span>
											<br/><span style="text-transform: uppercase;"> 
											<label class="control-label2">Date de naissance: </label>
											<span class="modal_date_naissance_patient">
											...
											</span>
											</span>
											<br/><span style="text-transform: uppercase;"> 
											<label class="control-label2">Téléphone: </label>
											<span class="modal_tel_patient">
											...
											</span>
											</span>
											<br/><span style="text-transform: uppercase;"> 
											<label class="control-label2">Sexe: </label>
											<span class="modal_sexe_patient">
											...
											</span>
											</span>
										</p>
									</div>
									
									<div class="col-md-12 row details" style="">
										<p>
											<span style="text-transform: uppercase;font-weight:bold;" class=""> 
											<label class="control-label2">Prélèvement</label><br/>
											</span>
											<span style="text-transform: uppercase;"> 
											<label class="control-label2" style="font-weight:400 !important;font-style:italic;">Effectué le:</label><br/>
											</span>
											<span style="text-transform: uppercase;"> 
											<label class="control-label2" style="font-weight:400 !important;font-style:italic;">Par:</label>
											</span>
										</p>
									</div>
								</div>

								<div class="col-md-12 hr_border" style="margin-top:1px;margin-bottom:1px;">
									<hr>
								</div>
								<div class="col-md-12" style="">
		
									<div class="col-md-12 row details" style="">
										<p>
											<span style="text-transform: uppercase;"> 
											<label class="control-label2">ID Acte: </label>
											<span class="modal_id_acte">
											...
											</span>
											</span>
										</p>
									</div>
									<div class="col-md-12 row details" style="">
										<p>
											<span style="text-transform: uppercase;"> 
											<label class="control-label2">Patient: </label>
											<span class="modal_identite_patient">
											...
											</span>
											</span>
											<br/><span style="text-transform: uppercase;"> 
											<label class="control-label2">Date de naissance: </label>
											<span class="modal_date_naissance_patient">
											...
											</span>
											</span>
											<br/><span style="text-transform: uppercase;"> 
											<label class="control-label2">Téléphone: </label>
											<span class="modal_tel_patient">
											...
											</span>
											</span>
											<br/><span style="text-transform: uppercase;"> 
											<label class="control-label2">Sexe: </label>
											<span class="modal_sexe_patient">
											...
											</span>
											</span>
										</p>
									</div>
									
									<div class="col-md-12 row details" style="">
										<p>
											<span style="text-transform: uppercase;font-weight:bold;" class=""> 
											<label class="control-label2">Prélèvement</label><br/>
											</span>
											<span style="text-transform: uppercase;"> 
											<label class="control-label2" style="font-weight:400 !important;font-style:italic;">Effectué le:</label><br/>
											</span>
											<span style="text-transform: uppercase;"> 
											<label class="control-label2" style="font-weight:400 !important;font-style:italic;">Par:</label>
											</span>
										</p>
									</div>
								</div>

								<div class="col-md-12 hr_border" style="margin-top:1px;margin-bottom:1px;">
									<hr>
								</div>
								<div class="col-md-12" style="">
		
									<div class="col-md-12 row details" style="">
										<p>
											<span style="text-transform: uppercase;"> 
											<label class="control-label2">ID Acte: </label>
											<span class="modal_id_acte">
											...
											</span>
											</span>
										</p>
									</div>
									<div class="col-md-12 row details" style="">
										<p>
											<span style="text-transform: uppercase;"> 
											<label class="control-label2">Patient: </label>
											<span class="modal_identite_patient">
											...
											</span>
											</span>
											<br/><span style="text-transform: uppercase;"> 
											<label class="control-label2">Date de naissance: </label>
											<span class="modal_date_naissance_patient">
											...
											</span>
											</span>
											<br/><span style="text-transform: uppercase;"> 
											<label class="control-label2">Téléphone: </label>
											<span class="modal_tel_patient">
											...
											</span>
											</span>
											<br/><span style="text-transform: uppercase;"> 
											<label class="control-label2">Sexe: </label>
											<span class="modal_sexe_patient">
											...
											</span>
											</span>
										</p>
									</div>
									
									<div class="col-md-12 row details" style="">
										<p>
											<span style="text-transform: uppercase;font-weight:bold;" class=""> 
											<label class="control-label2">Prélèvement</label><br/>
											</span>
											<span style="text-transform: uppercase;"> 
											<label class="control-label2" style="font-weight:400 !important;font-style:italic;">Effectué le:</label><br/>
											</span>
											<span style="text-transform: uppercase;"> 
											<label class="control-label2" style="font-weight:400 !important;font-style:italic;">Par:</label>
											</span>
										</p>
									</div>
								</div>
							</div>
						<!--</div>-->

					</div>
				</div><!-- /.modal-content -->
				<div class="modal-footer no-print" style="padding-top:0;margin-top:0;">
					<a class="btn btn-info btn-secondary btn-sm pull-left" data-dismiss="modal">Retour</a>
					<a class="btn btn-info btn-sm invoice_button pull-right" id="btnPrint" style="cursor: pointer;" ><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
				  </div>
				
			</div><!-- /.modal-dialog -->
		</div>
		<!-- Edit Event Modal-->


        <script src="<?php echo base_url(); ?>common/js/ecomed24.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function () {
			$("#btnPrint0").click(function (e) {
				e.preventDefault(e);
				// Readaptation au k où un print des tickets a été fait auparavant
				$("#dynamic-style").text("");
				
				var $printSection = document.getElementById("printSection");
				
				if ($printSection) {
					document.body.removeChild($printSection);
				}
				
				window.print();
				// alert($("#dynamic-style").text());
			});
			$(".editbutton2").click(function (e) {
				e.preventDefault(e);
				// Get the record's ID via attribute  
				var iid = $(this).attr('data-id');
				var paymentCode = <?php echo json_encode($payment->code); ?>;
				var prestationId = (iid.split("*"))[0];
				// var acteId = paymentCode+"-"+prestationId;
				var acteId = paymentCode+""+prestationId;
				var identitePatient = <?php echo json_encode($patient_info->last_name.", ".$patient_info->name); ?>;
				var telPatient = <?php echo json_encode($patient_info->phone); ?>;
				var dateNaissancePatient = <?php echo json_encode($patient_info->birthdate); ?>;
				var sexePatient = <?php echo json_encode($patient_info->sex); ?>;
				sexePatient = sexePatient == "Masculin" ? "M" : "F";
				// var sexePatient = <?php echo $patient_info->sex == "Masculin" ? "M" : "F"; ?>;
				// alert("$(this).attr('data-id'): "+paymentCode+"-"+prestationId);
				// $('#editServiceForm').trigger("reset");
				// $.ajax({
					// url: 'service/editServiceByJason?id=' + iid,
					// method: 'GET',
					// data: '',
					// dataType: 'json',
				// }).success(function (response) {
					// Populate the form fields with the data returned from server
					// $('#editServiceForm').find('[name="id"]').val(response.service.id).end()
					// $('#editServiceForm').find('[name="title"]').val(response.service.title).end()
					// $('#editServiceForm').find('[name="description"]').val(response.service.description).end()
					$('.modal_id_acte').text(acteId);
					$('.modal_identite_patient').text(identitePatient);
					$('.modal_tel_patient').text(telPatient);
					$('.modal_date_naissance_patient').text(dateNaissancePatient);
					$('.modal_sexe_patient').text(sexePatient);
					$('#myModal2').modal('show');
				// });
			});
		});
		</script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>

        <script>


                        $('#download').click(function () {
                            var pdf = new jsPDF('p', 'pt', 'letter');
                            pdf.addHTML($('#invoice'), function () {
                                pdf.save('invoice_id_<?php echo $payment->code; ?>.pdf');
                            });
                        });

                        // This code is collected but useful, click below to jsfiddle link.
        </script>
        <script>
			document.getElementById("btnPrint").onclick = function () {
				printElement(document.getElementById("myModal2"));
			}

			function printElement(elem) {
				var domClone = elem.cloneNode(true);
				
				var $printSection = document.getElementById("printSection");
				
				if (!$printSection) {
					var $printSection = document.createElement("div");
					$printSection.id = "printSection";
					document.body.appendChild($printSection);
				}
				
				$printSection.innerHTML = "";
				$printSection.appendChild(domClone);
				$("#dynamic-style").text(
					"@media screen {" +
					  "#printSection {" +
						  "display: none;" +
					  "}" +
					"}" +
					"@media print {" +
					  "body * {" +
						"visibility:hidden;" +
					  "}" +
					  "#printSection, #printSection * {" +
						"visibility:visible;" +
					  "}" +
					  "#printSection {" +
						"position:absolute;" +
						"left:0;" +
						"top:0;" + 
					  "}" +
					"}" 
				);
				
				window.print();
			}
        </script>



    </section>
    <!-- invoice end-->
</section>
</section>
<!--main content end-->
<!--footer start-->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
                        $(document).ready(function () {
                            $(".flashmessage").delay(3000).fadeOut(100);
                        });
</script>
