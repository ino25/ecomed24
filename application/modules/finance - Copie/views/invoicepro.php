<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- invoice start-->
        <section class="col-md-6">
            <div class="panel panel-primary" id="invoice">
                <!--<div class="panel-heading navyblue"> INVOICE</div>-->
                <div class="panel-body" style="font-size: 10px;">
                    <div class="row invoice-list">

                       
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
                                <?php echo lang('commande') ?>
                            </h4>
                        </div>

                        <div class="col-md-12 hr_border">
                            <hr>
                        </div>


                        <div class="col-md-12">
                            <div class="col-md-6 pull-left row" style="text-align: left;">
                          <?php $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row(); ?>
                                <div class="col-md-12 row details" style="">
                                    <p>
                                        <label class="control-label"><?php echo lang('patient'); ?>  </label>
                                        <span style="text-transform: uppercase;"> : 
                                            <?php 
                                            if (!empty($patient_info)) {
                                                echo $patient_info->patient_id . ' <br>';
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


                            </div>

                            <div class="col-md-6 pull-right" style="text-align: left;">

                                <div class="col-md-12 row details" style="">
                                    <p>
                                        <label class="control-label"><?php echo lang('number'); ?>  </label>
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
                                        <label class="control-label"><?php echo lang('partenaire'); ?>  </label>
                                        <span style="text-transform: uppercase;"> : 
                                            <?php
                                            if (!empty($payment->service)) {
                                                $doc_details = $this->home_model->getOrganisationById($payment->organisation_destinataire);
                                                if (!empty($doc_details)) {
                                                    echo $doc_details->nom . ' <br>';
                                                }
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
                            
                                <th><?php echo lang('amount'); ?></th>
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
                                    if ($category_name3[3] > 0) {
                                        ?>  

                                        <tr>
                                            <td><?php echo $i; ?> </td>
                                            <td><?php echo $this->finance_model->getPaymentcategoryById($category_name3[0])->prestation; ?> </td>
                                        
                                            <td class=""> <?php echo number_format($category_name3[1] * $category_name3[3], 0, ",", "."); ?> <?php echo $settings->currency; ?></td>
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
                                <li><strong><?php echo lang('grand_total'); ?> : </strong> <?php $g = $payment->gross_total; echo number_format($g, 0, ",", "."); ?> <?php echo $settings->currency; ?> </li>
                                <li><strong><?php echo lang('amount_received'); ?> : </strong> <?php $r = $this->finance_model->getDepositAmountByPaymentId($payment->id); echo number_format($r, 0, ",", "."); ?>  <?php echo $settings->currency; ?> </li>
                                <li><strong><?php echo lang('amount_to_be_paid'); ?> : </strong> <?php $rp = $g - $r; echo number_format($rp, 0, ",", "."); ?> <?php echo $settings->currency; ?> </li>
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
               <?php   if ($this->ion_auth->in_group(array('Receptionist'))) { ?>
                <a href="finance/payment" class="btn btn-info btn-sm info pull-left"><i class="fa fa-arrow-circle-left"></i>  <?php echo lang('back_to_payment_modules'); ?> </a>
              <?php   } else { ?>
                  <a href="finance/paymentLabo" class="btn btn-info btn-sm info pull-left"><i class="fa fa-arrow-circle-left"></i>  <?php echo lang('back_to_payment_modules'); ?> </a>
            <?php  } ?>
                <div class="text-center col-md-12 row">
                    <a class="btn btn-info btn-sm invoice_button pull-left" onclick="javascript:window.print();"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
                  
                    <a class="btn btn-info btn-sm detailsbutton pull-left download" id="download"><i class="fa fa-download"></i> <?php echo lang('download'); ?> </a>
                </div>

                <div class="no-print">
                    <a href="finance/addPaymentView" class="pull-left">
                        <div class="btn-group">
                            <button id="" class="btn btn-info green btn-sm">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('add_another_payment'); ?>
                            </button>
                        </div>
                    </a>

                </div>

                <div class="panel_button">

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




        <script src="<?php echo base_url(); ?>common/js/ecomed24.min.js"></script>
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
