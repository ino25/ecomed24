<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- invoice start-->
        <section class="col-md-6">






            <style>
				.panel{
                    border: 0px solid #5c5c47;
                    background: #fff !important;
                    height: 100%;
                    margin: 20px 5px 5px 5px;
                    border-radius: 0px !important;
                    color: #000;

                }
            </style>








            <div class="panel panel-primary" id="lab">
                <!--<div class="panel-heading navyblue"> INVOICE</div>-->
                <div class="panel-body" style="font-size: 10px;">
                    <div class="row invoice-list">

                        <!--<div class="text-center corporate-id">


                            <h3>
                                <?php echo $settings->title ?>
                            </h3>
                            <h4>
                                <?php echo $settings->address ?>
                            </h4>
                            <h4>
                                Tel: <?php echo $settings->phone ?>
                            </h4>
                            <img alt="" src="<?php echo $this->settings_model->getSettings()->logo; ?>" width="200" height="100">
                            <h4 style="font-weight: bold; margin-top: 20px; text-transform: uppercase;">
                                <?php echo lang('lab_report') ?>
                                <hr style="width: 200px; border-bottom: 1px solid #000; margin-top: 5px; margin-bottom: 5px;">
                            </h4>
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
                            <div class="col-md-6 pull-left row" style="text-align: left;">
                                <div class="col-md-12 row details" style="">
                                    <p>
                                        <?php $patient_info = $this->db->get_where('patient', array('id' => $lab->patient))->row(); ?>
                                        <label class="control-label"><?php echo lang('name'); ?> <?php echo lang('patient'); ?></label>
                                        <span style="text-transform: uppercase;">: 
                                            <?php
                                            if (!empty($patient_info)) {
                                                echo $patient_info->name . ' <br>';
                                            }
                                            ?>
                                        </span>
										<label class="control-label"><?php echo lang('last_name'); ?> <?php echo lang('patient'); ?></label>
                                        <span style="text-transform: uppercase;">: 
                                            <?php
                                            if (!empty($patient_info)) {
                                                echo $patient_info->last_name . ' <br>';
                                            }
                                            ?>
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-12 row details" style="">
                                    <p>
                                        <label class="control-label"><?php echo lang('patient_id'); ?> <?php echo lang("patient"); ?></label>
                                        <span style="text-transform: uppercase;">: 
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
                                        <label class="control-label"> <?php echo lang('address'); ?> <?php echo lang("patient"); ?></label>
                                        <span style="text-transform: uppercase;">: 
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
                                        <label class="control-label"> <?php echo lang('phone'); ?>  <?php echo lang('patient'); ?></label>
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
                                        <label class="control-label"> <?php echo lang('id'); ?> <?php echo lang('report'); ?>  <?php echo lang('lab'); ?> </label>
                                        <span style="text-transform: uppercase;"> : 
                                            <?php
                                            if (!empty($lab->code)) {
                                                echo $lab->code;
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
                                            if (!empty($lab->date)) {
                                                echo date('d/m/Y', $lab->date) . ' <br>';
                                            }
                                            ?>
                                        </span>
                                    </p>
                                </div>

                                <!--<div class="col-md-12 row details">
                                    <p>
                                        <label class="control-label"><?php echo lang('doctor'); ?>  </label>
                                        <span style="text-transform: uppercase;"> : 
                                            <?php
                                            if (!empty($lab->doctor)) {
                                                $doctor_details = $this->doctor_model->getDoctorById($lab->doctor);
                                                if (!empty($doctor_details)) {
                                                    echo $doctor_details->name. '<br>';
                                                }
                                            }
                                            ?>
                                        </span>
                                    </p>
                                </div>-->
                            </div>
                        </div>
                        <br>

                    </div> 


                    <div class="col-md-12 panel-body">
                        <?php
                        // if (!empty($lab->report)) {
                            // echo $lab->report;
                        // }
						$liste_analyses = "";
						$indice = 0;
						$at_least_one_valid = false;
						foreach($analyses as $analyse) {
							if($indice > 0) {
								$liste_analyses .= "<hr style='height:1px;margin-top:2px !important;margin-bottom:2px !important;border-width:0;color:gray;background-color:gray'/>";
							}
							
								$id_prestationBuff0 = explode("@@@@", $analyse->idPaymentConcatRelevantCategoryPart);
								$id_prestationBuff1 = explode("*", $id_prestationBuff0[1]);
								$id_prestation = $id_prestationBuff1[0];
							
								// Récupérer statut Reel
								$id_payment = $id_prestationBuff0[0];
								$this->db->where("id", $id_payment);
								$query = $this->db->get("payment");
								$payment = $query->row();
								$category_name = $payment->category_name;
								// echo "<br/>".$id_prestationBuff0[1]."<br/>".$category_name;
								$exploded_category_name1 = explode(",", $category_name);
								$is_valid = false;
								foreach($exploded_category_name1 as $exploded1) {
									$exploded2 = explode("*", $exploded1);
									$is_valid = $exploded2[0] == $id_prestationBuff1[0] && $exploded2[1] == $id_prestationBuff1[1] && $exploded2[2] == $id_prestationBuff1[2] && $exploded2[3] == $id_prestationBuff1[3] && $exploded2[4] == 3;
									if($is_valid) {
										$at_least_one_valid = true;
										break;
									}
								}
								// echo "<br/>".$is_valid;
                                                                var_dump($analyse);							
							$liste_analyses .= "<h6 style='text-transform:uppercase;font-weight:bold;'>".$analyse->resultats."<br/><span style='font-size:10px;text-transform:none;'>(".$analyse->code.")</span></h6>";
							
							if($is_valid) {
								$analyses_array[$indice]["prestation"] = ''/*$analyse->prestation*/;
								$analyses_array[$indice]["resultats"] = $analyse->resultats;
								$analyses_array[$indice]["unite"] = $analyse->unite;
								$analyses_array[$indice]["valeurs"] = $analyse->valeurs;
								$analyses_array[$indice]["code"] = $analyse->code;	
							}
							
							$indice++;
						}
						// print_r($analyses_array);
						if(!$at_least_one_valid) {
						?>
							<div style="text-align:center"><code style="font-weight:bold;font-size:1.1em">Aucune analyse validée pour le moment.</code></div>
						<?php
						} else {
						?>
										<table border='1' cellpadding='1' cellspacing='1' style='width:100%'>
											<caption>R&Eacute;SULTATS DES ANALYSES</caption>
											<thead>
                                                <tr>
                                                        <th scope='col'>Analyse(s) Demand&eacute;es</th>
                                                        <th scope='col'>R&eacute;sultats</th>
                                                        <th scope='col'>Unit&eacute;</th>
                                                        <th scope='col'>Valeurs Usuelles</th>
                                                </tr>
											</thead>
											<tbody>
												<?php
												foreach($analyses_array as $single_analyse) {
												?>
												<tr>
														<td style='font-weight:500;'><?php echo $single_analyse["prestation"]; ?><br/><span style='font-weight:400;'>(ID Acte: <?php echo $single_analyse["code"]; ?>)</td>
                                                        <td><?php echo $single_analyse["resultats"]; ?></td>
                                                        <td><?php echo $single_analyse["unite"]; ?></td>
                                                        <td><?php echo $single_analyse["valeurs"]; ?></td>
                                                </tr>
												<?php
												}
												?>
											</tbody>
                                        </table>
                                        <p>&nbsp;</p>
						<?php
						}
                        ?>
                    </div>


                </div>
            </div>



        </section>


        <section class="col-md-6">

            <div class="col-md-5 no-print" style="margin-top: 20px;">
                <div class="text-center col-md-12 row">
                    <?php if ($this->ion_auth->in_group(array('admin','adminmedecin', 'Laboratorist'))) { ?>
                    <a href="lab" class="btn btn-info btn-sm info pull-left"><i class="fa fa-arrow-circle-left"></i>  <?php echo lang('back_to_lab_module'); ?> </a>
                    <?php }?>
                    <?php if ($this->ion_auth->in_group(array('Patient'))) { ?>
                    <a href="lab/myLab" class="btn btn-info btn-sm info pull-left"><i class="fa fa-arrow-circle-left"></i>  <?php echo lang('back_to_lab_module'); ?> </a>
                    <?php }?>
                    <a class="btn btn-info btn-sm invoice_button pull-left" onclick="javascript:window.print();"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>

                    <a class="btn btn-info btn-sm detailsbutton pull-left download" id="download"><i class="fa fa-download"></i> <?php echo lang('download'); ?> </a>

                    <?php if ($this->ion_auth->in_group(array('admin','adminmedecin', 'Laboratorist'))) { ?>
                        <a href="lab/editLab?id=<?php echo $lab->id; ?>" class="btn btn-info btn-sm blue pull-left"><i class="fa fa-edit"></i> <?php echo lang('edit_report'); ?> </a>
                    <?php } ?>


                </div>

                <?php if ($this->ion_auth->in_group(array('admin','adminmedecin', 'Laboratorist'))) { ?>
                    <div class="no-print">


                        <a href="lab" class="pull-left">
                            <div class="btn-group">
                                <button id="" class="btn green btn-sm">
                                    <i class="fa fa-plus-circle"></i> <?php echo lang('add_a_new_report'); ?>
                                </button>
                            </div>
                        </a>
                    </div>
                <?php } ?>

            </div>











        </section>
        <!-- invoice end-->
    </section>
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



            .control-label{
                width: 100px;
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



            .control-label{
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

        </style>
		
<!--main content end-->
<!--footer start-->

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>

<script>
                        $(document).ready(function () {
                            $(".flashmessage").delay(3000).fadeOut(100);
                        });
</script>





<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>

<script>


                        $('#download').click(function () {
                            var pdf = new jsPDF('p', 'pt', 'letter');
                            pdf.addHTML($('#lab'), function () {
                                pdf.save('lab_id_<?php echo $lab->code; ?>.pdf');
                            });
                        });

                        // This code is collected but useful, click below to jsfiddle link.
</script>
