<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="container-fluid invoice-container col-md-10">
            <!-- Header -->
            <style>
                .rowStyle {
                    background-color: #0D4D99;
                    color: #ffffff;
                }
            </style>
            <style>
                @media screen {
                    .footer_class {
                        display: none;
                        margin-bottom: 0px;
                        position: fixed;
                    }

                    .btn {
                        margin-left: 5px;
                    }

                    .invoice-container {
                        border: 1px solid #eee !important;
                    }

                    .garbage {
                        display: none;
                    }
                }

                @media print {
                    .col-md-4 {
                        width: 33.33%;
                        float: left;
                    }

                    .col-md-6 {
                        width: 50%;
                        float: left;
                    }

                    .col-md-12 {
                        width: 100%;
                        text-align: center;
                    }

                    input {
                        border: none;
                    }

                    .footer_class {
                        visibility: visible;
                    }

                    .footer_info {
                        display: none;
                    }

                    .text-center {
                        text-align: center;
                    }

                    .invoice_footer {
                        right: 0;
                        left: 0;
                        position: fixed;
                        bottom: 0;
                        float: none !important;
                    }

                    .hr_border {
                        width: 100%;

                    }

                    .test_speciality {
                        left: 0;
                        right: 0;
                        width: 100%;
                        margin-top: 300px;
                    }

                    .col-sm-4 {
                        float: none;
                    }

                    .test_speciality {
                        padding-left: 150px !important;
                        padding-right: 150px !important;
                    }

                    .text_speciality {
                        border: 1px solid;
                        border-block-width: 2px !important;
                    }

                    .table>tbody>tr>td {
                        border-top: 0;
                    }

                    .qr_code {
                        height: 200px;
                        width: 200px;
                    }

                    .con {
                        width: 66.66%;
                        font-size: 24px;
                        font-weight: 600;
                    }

                    .sign_class {
                        float: right;
                    }

                    .imgy {
                        width: 200px;
                        height: 80px;
                    }
                }
            </style>
            <div class="panel panel-primary" id="invoice">
                <header>
                    <?php
                    $prestation = '';
                    if (isset($_GET['prestation'])) {
                        $prestation = $_GET['prestation'];
                    }
                    $payment = '';
                    if (isset($_GET['payment'])) {
                        $payment = $_GET['payment'];
                    }
                    $mode = '';
                    if (isset($_GET['mode'])) {
                        $mode = $_GET['mode'];
                    }
                    $patient_id = '';
                    if (isset($_GET['id'])) {
                        $patient_id = $_GET['id'];
                    }
                    $typ = '';
                    if (isset($_GET['typ'])) {
                        $typ = $_GET['typ'];
                    } ?>
                    <div class="row align-items-center">
                        <div class="col-sm-12 text-center text-sm-left mb-3 mb-sm-0">
                            <img id="logo" src="<?php echo !empty($entete) ? $entete : "uploads/entetePartenaires/default.png"; ?>" style="max-width:100%;height:18%" title="Koice" alt="Koice" />
                            <input hidden type="text" id="logo2" value="<?php echo !empty($entete) ? $entete : "uploads/entetePartenaires/default.png"; ?>">
                        </div>
                    </div>
                </header>
                <br>
                <main>
                    <?php $patient_details = $this->patient_model->getPatientById($report_details->patient); ?>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('first_name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php echo $patient_details->name; ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('last_name'); ?></label>
                        <input type="text" class="form-control" name="last_name" id="exampleInputEmail1" value='<?php echo $patient_details->last_name; ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('patient_ids'); ?></label>
                        <input type="text" class="form-control" name="patient_id" id="exampleInputEmail1" value='<?php echo $patient_details->id; ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('date_of_birth'); ?></label>
                        <input type="text" class="form-control" name="date_of_birth" id="exampleInputEmail1" value='<?php echo $patient_details->birthdate; ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="exampleInputEmail1"> <?php echo lang('age'); ?></label>
                        <input type="text" class="form-control" name="age" id="exampleInputEmail1" value='<?php echo $patient_details->age; ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="exampleInputEmail1"> <?php echo lang('gender'); ?></label>
                        <input type="text" class="form-control" name="gender" id="exampleInputEmail1" value='<?php echo $patient_details->sex; ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('address'); ?></label>
                        <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='<?php echo $patient_details->address; ?>' placeholder="" readonly="">
                    </div>
                    <?php if (strtolower($lab_details->name) == 'pcr') { ?>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"> <?php echo lang('passport_number'); ?></label>
                            <input type="text" class="form-control" name="passport" id="exampleInputEmail1" value='<?php echo $patient_details->passport; ?>' placeholder="" readonly="">
                            <input type="hidden" class="form-control" id="passport" value='<?php echo $patient_details->passport; ?>' placeholder="" readonly="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"> <?php echo lang('purpose_of_test'); ?></label>
                            <?php
                            $pur = $this->db->get_where('purpose', array('id' => $payments->purpose))->row();
                            if (empty($pur)) {
                                $purpo = '';
                            } else {
                                $purpo = $pur->name;
                            }
                            ?>
                            <input type="text" class="form-control" name="purpose" id="exampleInputEmail1" value='<?php echo $purpo; ?>' placeholder="" readonly="">
                            <input type="hidden" class="form-control" name="" id="purpose" value='<?php echo $purpo; ?>' placeholder="" readonly="">
                        </div>
                    <?php } else { ?> <div class="form-group col-md-4 garbage no-print">asdasdsadasdasdasdasdasdasdasd</div> <?php } ?>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('report_id'); ?></label>
                        <input type="text" class="form-control" name="report_code" id="exampleInputEmail1" value='<?php echo $report_details->report_code; ?>' placeholder="" readonly="">

                    </div>
                    <div class="col-md-12 hr_border">
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('type_of_sampling'); ?></label>
                        <input type="text" class="form-control" name="type_of" id="exampleInputEmail1" value='<?php echo $this->db->get_where('sampling', array('id' => $report_details->sampling))->row()->name; ?>' placeholder="" readonly="">
                        <input type="hidden" class="form-control" id="type_of" value='<?php echo $this->db->get_where('sampling', array('id' => $report_details->sampling))->row()->name; ?>' placeholder="" readonly="">
                    </div>
                    <style>
                        .rowStyle {
                            background-color: #000 !important;
                        }
                    </style>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('sampling_date_time'); ?></label>
                        <input type="text" class="form-control" name="sampling_date" id="exampleInputEmail1" value='<?php echo $report_details->sampling_date; ?>' placeholder="" readonly="">
                        <input type="hidden" class="form-control" id="sampling_date" value='<?php echo $report_details->sampling_date; ?>' placeholder="" readonly="">
                    </div>

                    <div class="form-group col-md-6"></div>
                    <div class="col-md-12 hr_border">
                        <hr>
                    </div>

                    <style>
                        @media screen {
                            .test_speciality {
                                padding-left: 150px !important;
                                padding-right: 150px !important;
                            }

                            .text_speciality {
                                border: 1px solid;
                                border-block-width: 2px !important;
                            }
                        }
                    </style>
                    <div class="col-md-12 test_speciality">
                        <h3 class="text-center text_speciality"><?php echo $lab_details->speciality; ?></h3>
                    </div>
                    <div class="col-md-12">
                        <h4 class="text-center"><?php echo $lab_details->name; ?></h4>
                    </div>

                    <div class="col-md-12">

                        <div>
                            <table class="table mb-0">
                                <thead class="rowStyle">
                                    <tr>
                                        <td class="col-1 border-0" style="width: 10%;"><strong>#</strong></td>
                                        <td class="col-3 border-0" style="width: 20%;"><strong><?php echo lang('parameter_name'); ?></strong></td>
                                        <td class="col-4 border-0" style="width: 35%;"><strong><?php echo lang('test_result'); ?></strong></td>
                                        <td class="col-4 border-0" style="width: 35%;"><strong><?php echo lang('reference_value'); ?></strong></td>


                                    </tr>
                                </thead>

                                <?php
                                if (!empty($report_details->details)) {
                                    $details_explode = explode("##", $report_details->details);
                                    $i = 0;
                                    foreach ($details_explode as $det) {
                                        $det_arr = array();
                                        $det_arr = explode("**", $det);
                                ?>
                                        <tr class="ligneFacture">
                                            <td class="col-1 border-0" style="width: 10%;"><strong><span class="idFacture"><?php echo ++$i; ?></span> </strong></td>
                                            <td class="col-3 border-0" style="width: 20%;"><strong><span class="prestationFacture"><?php echo $det_arr[2]; ?></span> </strong></td>
                                            <?php if ($det_arr[0] == 'off_switch') { ?>
                                                <td class="col-4 border-0" style="width: 35%;"><strong><span class="prestationFacture"><?php echo $det_arr[7]; ?></span> </strong></td>
                                                <td class="col-4 border-0" style="width: 35%;"><strong><span class="prestationFacture"><?php echo $det_arr[5] . '-' . $det_arr[4]; ?></span> </strong></td>

                                            <?php } else {
                                            ?>
                                                <td class="col-4 border-0" style="width: 35%;"><strong><span class="prestationFacture"><?php
                                                                                                                                        if ($det[15] == 'p') {
                                                                                                                                            echo lang('positive');
                                                                                                                                        } else {
                                                                                                                                            echo lang('negative');
                                                                                                                                        }
                                                                                                                                        ?></span> </strong></td>
                                                <td class="col-4 border-0" style="width: 35%;"><strong><span class="prestationFacture">NÉGATIVE</span> </strong></td>
                                            <?php } ?>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </table>
                        </div>

                        <?php ?>
                    </div>
                    <div class="form-group col-md-4">
                        <img style="margin-top:19px;" class="qr_code" src="<?php echo base_url(); ?>uploads/qrcode/<?php echo $report_details->qr_code; ?>" width="120" height="120" alt="alt" />
                    </div>
                    <div class="form-group con col-md-8" style="margin-top:37px;">
                        <label for="exampleInputEmail1"> <?php echo lang('conclusion'); ?>: </label>
                        <?php echo $this->db->get_where('conclusion', array('id' => $report_details->conclusion))->row()->name; ?>
                    </div>

                    <!-- <div class="col-md-12 pull-right">
                        <img class="sign_class pull-right imgy" src="<?php echo $signature; ?>" width="150" height="150" alt="alt" /><br>
                    </div> -->

                    <div class="col-md-12 signatture_class pull-right">
                        <?php
                        if (empty($user_signature)) {
                            if ($this->ion_auth->in_group(array('adminmedecin', 'Doctor'))) {
                        ?>
                                <button class=" no-print pull-right btn btn-sm btn-primary" id="signature"><?php echo lang('signature'); ?></button>
                            <?php } else { ?>
                                ------------------------------------<br>
                                <div class="col-md-12"> <span class="sign_class pull-right"><?php echo lang('signature'); ?></span></div>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="col-md-12">
                                <img class="sign_class pull-right imgy" src="<?php echo $user_signature; ?>" width="150" height="70" alt="alt" /><br>
                            </div>
                            <span class=" sign_class pull-right"> --------------------------</span><br>
                            <div class="col-md-12"> <span class="sign_class pull-right"><?php echo lang('signature'); ?></span></div>
                        <?php } ?>
                    </div>


                    <!-- <div class="col-md-12 hr_border">
                        <hr>
                    </div> -->
                    <div class="col-sm-12 text-center text-sm-center invoice_footer">
                        <p hidden class="text-3"><strong></strong> <span style=""> <?php echo $nom_organisation . ', ' . $settings->address . ',  Tel: ' . $settings->phone . ' Mail : ' . $settings->email; ?></span></p>
                        <div class="col-sm-12 text-center">
                            <img id="logo3" src="<?php echo !empty($footer) ? $footer : "uploads/entetePartenaires/defaultFooter.PNG"; ?>" style="max-width:76%;height:5%" title="Koice" alt="Koice" />
                            <input hidden type="text" id="logo4" value="<?php echo !empty($footer) ? $footer : "uploads/entetePartenaires/defaultFooter.PNG"; ?>">
                        </div>

                    </div>
                    <!--                <footer class="footer_class">
                                    <p class="text-3"><strong></strong> <span style=""> <?php echo $nom_organisation . ', ' . $settings->address . ',  Tel: ' . $settings->phone . ' Mail : ' . $settings->email; ?></span></p>
                                </footer>-->

            </div>



        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-4" style="padding-top: 15px;">
                    <a class="btn btn-info btn-secondary pull-left" href="finance/paymentLabo"><?php echo lang('retour'); ?></a>
                    <button class=" btn btn-sm btn-danger" id="reprendre"><?php echo lang('close-rejet'); ?></button>
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <form role="form" action="finance/editStatutPaiementValidReport" class="clearfix" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="docid" value='<?php echo $this->ion_auth->user()->row()->id; ?>'>
                        <input type="hidden" name="report_id" value="<?php echo $report_details->id; ?>">
                        <input type="hidden" name="payment_id" value="<?php echo $payments->id; ?>">
                        <input type="hidden" id="date_prescriptionEmail" name="date_prescription">
                        <input type="hidden" id="resultatPCR" name="resultatPCR">
                        <input type="hidden" id="conclusionPCR" name="conclusionPCR">
                        <input type="hidden" id="conclusionPCRConvert" name="conclusionPCRConvert">
                        <input type="hidden" id="name_patientEmail" name="name_patient">
                        <input type="hidden" id="id_patientEmail" name="id_patient">
                        <button style="display:none" id="validerActe" type="submit" name="submit" id="submit" class="btn btn-info pull-right" style="padding-top: -15px;"><?php echo lang('valid'); ?></button>
                    </form>
                </div>
            </div>





        </div>

        <!-- <div class="col-md-4 no-print options <?php if (empty($report_details->signature)) {
                                                        echo 'hidden';
                                                    } ?>">
            <div class="col-md-12 no-print">
                <a class="btn btn-info btn-sm invoice_button pull-left" onclick="javascript:window.print();"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
                <a class="btn btn-info btn-sm  pull-left" href="lab/download?id=<?php echo $report_details->id ?>"><i class="fa fa-download"></i> <?php echo lang('download'); ?> </a>
            </div> <?php
                    if (empty($report_details->transfer)) {
                        if ($this->ion_auth->in_group(array('Laboratorist', 'Biologiste'))) {
                    ?>
                    <div class="col-md-4 no-print">
                        <a class="btn btn-info btn-sm  pull-left" href="lab/addReport?patient_id=<?php echo $report_details->patient ?>&payment=<?php echo $report_details->payment ?>&lab_id=<?php echo $report_details->lab_id ?>&report_id=<?php echo $report_details->id ?>"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?> </a>
                    </div> <?php
                        }
                    }
                            ?>

            <div class="no-print col-md-8">
                <a href="finance/payentLabo" class="pull-left">
                    <div class="btn-group">
                        <button id="" class="btn btn-info green btn-sm">
                            <i class="fa fa-arrow-circle-left"></i> <?php echo lang('back_to_report_list'); ?>
                        </button>
                    </div>
                </a>

            </div><br>
            <?php
            if (empty($report_details->transfer)) {
                if ($this->ion_auth->in_group(array('Laboratorist', 'Biologiste', 'admin' . 'Receptionist', 'Assistant'))) {
            ?>
                    <div class="no-print col-md-12">
                        <button id="transfer" data-id="<?php echo $report_details->id ?>" class="btn btn-info green btn-sm">
                            <i class="fa fa-paper-plane"></i> <?php echo lang('transfert'); ?>
                        </button>
                                            <a class="btn btn-info btn-sm  pull-left" href="lab/transfer?id=" ><i class="fa fa-paper-plane"></i> <?php echo lang('transfert'); ?> </a>-->
        <!-- </div>
            <?php
                }
            }
            ?>
            </main>
        </div>  -->

        <!--</div>-->
    </section>


    <div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"> <?php echo lang('transfert'); ?> </h4>
                </div>
                <div class="modal-body">
                    <form role="form" id="transferLabReport" action="lab/transfer" class="clearfix" method="post" enctype="multipart/form-data">

                        <div class="form-group col-md-12">
                            <label class="radio-inline"><input type="radio" class="medium" name="medium" value='email' checked><?php echo lang('email'); ?></label>
                            <label class="radio-inline"><input type="radio" class="medium" name="medium" value='whatsapp'><?php echo lang('whatsapp'); ?></label>

                        </div>
                        <div class="form-group col-md-12 whatsapp hidden">
                            <label for="exampleInputEmail1"> <?php echo lang('whatsapp_number'); ?><span></span></label>
                            <input type="number" class="form-control" name="whatsapp" id="what_num" value='<?php echo $patient_details->phone; ?>' placeholder="">
                        </div>
                        <div class="form-group col-md-12 email_div">
                            <label for="exampleInputEmail1"> <?php echo lang('email'); ?></label>
                            <input type="email" class="form-control" name="email" id="email_id" value='<?php echo $patient_details->email; ?>' placeholder="" required="">
                        </div>




                        <input type="hidden" name="report_id" value="<?php echo $report_details->id; ?>">
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                        </div>
                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- Load Medicine -->

    <div class="modal fade" id="myModalReprendre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body" style="height: 150px;">
                    <h4><?php echo lang('stt_rejet') ?></h4>
                    <form role="form" action="finance/editStatutPaiementReprendreReport" class="clearfix" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="docid" value='<?php echo $this->ion_auth->user()->row()->id; ?>'>
                        <input type="hidden" name="report_id" value="<?php echo $report_details->id; ?>">
                        <input type="hidden" name="report_id" value="<?php echo $report_details->id; ?>">
                        <input type="hidden" name="payment_id" value="<?php echo $payments->id; ?>">
                        <p class='error pull-left'></p>
                        <div class="form-group">
                            <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal" aria-hidden="true">Fermer</button>
                            <button type="submit" name="submit" class="btn btn-primary pull-right" id='signUpload'><span class='looading'> <i class="fa fa-spinner fa-spin" style='display:none'></i> </span> Valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

    <div class="modal fade" id="myModalSignature" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"> <?php echo lang('verification_signature'); ?> </h4>
                </div>
                <div class="modal-body" style="height: 150px;">
                    <div class="form-group">
                        <label for="inputPin">Entrez le code PIN de signature pour afficher</label>
                        <input type="password" id="inputPinView" class="form-control" name="input" onkeyup="inputPinView(event)" autocomplete="off">
                        <input type="hidden" id="inputPinViewSHA1" class="form-control" name="inputPin">
                    </div>

                    <div class="error_pinview" style="display:none;font-weight: bold ; color:red; font-family: Verdana, Geneva, Tahoma, sans-serif;">
                        <h5></h5>
                    </div>
                    <div class="sign"></div>
                    <input type="hidden" id="docid" name="docid" value='<?php echo $this->ion_auth->user()->row()->id; ?>'>
                    <input type="hidden" name="report_id" value="<?php echo $report_details->id; ?>">

                    <!-- <button id="signUploadView" type="button" class="btn-xs btn-info signUploadView" name="submit" class="btn btn-primary pull-right"><span class='looading'> <i class="fa fa-spinner fa-eyes" style='display:none'></i> </span> Voir</button> -->
                    <button id="signUploadView" type="submit" name="submit" class="btn btn-primary"><span class='looading'> <i class="fa fa-eye" aria-hidden="true"></i></i> </span> Valider</button>
                </div>
            </div>
        </div>
    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->


    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"> <?php echo lang('otp_verfication'); ?> </h4>
                </div>
                <div class="modal-body">
                    <form role="form" id="editLabTestForm" class="clearfix" method="post" enctype="multipart/form-data">


                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1"> <?php echo lang('otp_code'); ?></label>
                            <input type="number" pattern="[0-9]{6}" class="form-control" name="otp" id="otp" value='' placeholder="" required="">
                            <span id="wrong_otp_msg"></span>
                        </div>

                        <input type="hidden" id="generate_id" value=''>
                        <input type="hidden" id="report_id" value="<?php echo $report_details->id; ?>">
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                        </div>
                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="sttChangeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog ">
            <div class="modal-content" id="sttChangeModalHtml">

            </div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
    <script>




    </script>
    <script>
        $(document).ready(function() {

            // $('#editLabTestForm').submit(function(e) {
            //     e.preventDefault();
            //     var otp = $('#otp').val();
            //     var id = $('#generate_id').val();
            //     var report_id = $('#report_id').val();
            //     $.ajax({
            //         url: 'lab/otpMatch?otp=' + otp + '&id=' + id + '&report=' + report_id,
            //         method: 'GET',

            //         dataType: 'json',
            //     }).success(function(response) {
            //         if (response.otp == 'yes') {
            //             $('.signatture_class').html(" ");
            //             $('.signatture_class').append(' <div class="col-md-12"><img class="imgy sign_class pull-right" src="' + response.signature.signature + '"width="150;"height="70"alt=""/></div><br><span class="sign_class pull-right" >---------------------------------</span><br> <div class="col-md-12"><span class="sign_class pull-right" ><?php echo lang('signature'); ?></span></div>')
            //             $('.options').removeClass('hidden');
            //             $('#myModal3').modal('hide');
            //         } else {
            //             $('#wrong_otp_msg').html(" ");
            //             $('#wrong_otp_msg').append("Otp does not Match");
            //         }
            //     });

            // });
            $('#transfer').on('click', function() {
                var id = $(this).attr('data-id');
                $('#transferModal').modal('show');
            });
            $('.medium').on('click', function() {
                var value = $('.medium:checked').val();
                if (value === 'email') {
                    $('.whatsapp').addClass('hidden');
                    $('.email_div').removeClass('hidden');
                    $('#what_num').prop('required', false);
                    $('#email_id').prop('required', true);
                } else {
                    $('.whatsapp').removeClass('hidden');
                    $('.email_div').addClass('hidden');
                    $('#what_num').prop('required', true);
                    $('#email_id').prop('required', false);
                }
            })
        });



        function rejetbuttonJson(payment) {
            $.ajax({
                url: 'finance/rejetbuttonJson',
                method: "POST",
                data: {
                    patient: <?php echo $patient->id; ?>,
                    prestation: '<?php echo $prestation; ?>',
                    payment: '<?php echo $payment; ?>'
                },
                async: false,
                dataType: 'json',
            }).success(function(response) {
                if (response) {
                    $('#valid').hide();
                    $('#rejet').hide();
                    $('#sttChangeModal').modal('hide');

                }
            });
        }
        $(document).ready(function() {

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#signUploadView").click(function(e) {
                var docid = $("#docid").val();
                var pin = $("#inputPinViewSHA1").val();
                pin = SHA1(pin);
                //alert('profile/viewSign?docid=' + docid + '&pin=' + pin);
                const danger = document.querySelector(".error_pinview");
                var bt = document.getElementById('validerActe');
                bt.style.display ="";
                danger.style.display = ""
                $.ajax({
                    url: 'profile/viewSign?docid=' + docid + '&pin=' + pin,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function(response) {
                    console.log("*********************************");
                    console.log(response.message);
                    console.log("*********************************");
                    if (response.error) {
                        // $('.sign').html('');
                        bt.style.display ="none";
                        danger.innerHTML = `<strong>${response.message}</strong>`;
                        
                        //$('.error').css('color', 'red').text(response.message);
                    } else {
                        var data = response.user_signature;
                        $('.signatture_class').html(" ");
                       $('.signatture_class').append(' <div class="col-md-12"><img class="imgy sign_class pull-right" src="' +  data[0].sign_name + '"width="150;"height="70"alt=""/></div><br><span class="sign_class pull-right" >---------------------------------</span><br> <div class="col-md-12"><span class="sign_class pull-right" ><?php echo lang('signature'); ?></span></div>')
                        $('.options').removeClass('hidden');
                       $('#myModalSignature').modal('hide');
                       bt.style.display ="block";
                    }
                });
            });

        });

        function inputPinView(event) {

            var pin = $("#inputPinView").val();
            var pinSHA1 = SHA1(pin);
            var bt = document.getElementById('signUploadView');
            const danger = document.querySelector(".error_pinview");
            danger.style.display = ""
            document.getElementById('inputPinViewSHA1').value = "";
            if (pin.length == 6) {
                danger.style.display = "none";
                document.getElementById('inputPinViewSHA1').value = pinSHA1;
                bt.disabled = false;
            } else {

                danger.innerHTML = `<strong>Veuillez entrer 6 chiffres</strong>`;
                bt.disabled = true;
            }

        }

        function SHA1(msg) {
            function rotate_left(n, s) {
                var t4 = (n << s) | (n >>> (32 - s));
                return t4;
            };

            function lsb_hex(val) {
                var str = '';
                var i;
                var vh;
                var vl;
                for (i = 0; i <= 6; i += 2) {
                    vh = (val >>> (i * 4 + 4)) & 0x0f;
                    vl = (val >>> (i * 4)) & 0x0f;
                    str += vh.toString(16) + vl.toString(16);
                }
                return str;
            };

            function cvt_hex(val) {
                var str = '';
                var i;
                var v;
                for (i = 7; i >= 0; i--) {
                    v = (val >>> (i * 4)) & 0x0f;
                    str += v.toString(16);
                }
                return str;
            };

            function Utf8Encode(string) {
                string = string.replace(/\r\n/g, '\n');
                var utftext = '';
                for (var n = 0; n < string.length; n++) {
                    var c = string.charCodeAt(n);
                    if (c < 128) {
                        utftext += String.fromCharCode(c);
                    } else if ((c > 127) && (c < 2048)) {
                        utftext += String.fromCharCode((c >> 6) | 192);
                        utftext += String.fromCharCode((c & 63) | 128);
                    } else {
                        utftext += String.fromCharCode((c >> 12) | 224);
                        utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                        utftext += String.fromCharCode((c & 63) | 128);
                    }
                }
                return utftext;
            };
            var blockstart;
            var i, j;
            var W = new Array(80);
            var H0 = 0x67452301;
            var H1 = 0xEFCDAB89;
            var H2 = 0x98BADCFE;
            var H3 = 0x10325476;
            var H4 = 0xC3D2E1F0;
            var A, B, C, D, E;
            var temp;
            msg = Utf8Encode(msg);
            var msg_len = msg.length;
            var word_array = new Array();
            for (i = 0; i < msg_len - 3; i += 4) {
                j = msg.charCodeAt(i) << 24 | msg.charCodeAt(i + 1) << 16 | msg.charCodeAt(i + 2) << 8 | msg.charCodeAt(i + 3);
                word_array.push(j);
            }
            switch (msg_len % 4) {
                case 0:
                    i = 0x080000000;
                    break;
                case 1:
                    i = msg.charCodeAt(msg_len - 1) << 24 | 0x0800000;
                    break;
                case 2:
                    i = msg.charCodeAt(msg_len - 2) << 24 | msg.charCodeAt(msg_len - 1) << 16 | 0x08000;
                    break;
                case 3:
                    i = msg.charCodeAt(msg_len - 3) << 24 | msg.charCodeAt(msg_len - 2) << 16 | msg.charCodeAt(msg_len - 1) << 8 | 0x80;
                    break;
            }
            word_array.push(i);
            while ((word_array.length % 16) != 14) word_array.push(0);
            word_array.push(msg_len >>> 29);
            word_array.push((msg_len << 3) & 0x0ffffffff);
            for (blockstart = 0; blockstart < word_array.length; blockstart += 16) {
                for (i = 0; i < 16; i++) W[i] = word_array[blockstart + i];
                for (i = 16; i <= 79; i++) W[i] = rotate_left(W[i - 3] ^ W[i - 8] ^ W[i - 14] ^ W[i - 16], 1);
                A = H0;
                B = H1;
                C = H2;
                D = H3;
                E = H4;
                for (i = 0; i <= 19; i++) {
                    temp = (rotate_left(A, 5) + ((B & C) | (~B & D)) + E + W[i] + 0x5A827999) & 0x0ffffffff;
                    E = D;
                    D = C;
                    C = rotate_left(B, 30);
                    B = A;
                    A = temp;
                }
                for (i = 20; i <= 39; i++) {
                    temp = (rotate_left(A, 5) + (B ^ C ^ D) + E + W[i] + 0x6ED9EBA1) & 0x0ffffffff;
                    E = D;
                    D = C;
                    C = rotate_left(B, 30);
                    B = A;
                    A = temp;
                }
                for (i = 40; i <= 59; i++) {
                    temp = (rotate_left(A, 5) + ((B & C) | (B & D) | (C & D)) + E + W[i] + 0x8F1BBCDC) & 0x0ffffffff;
                    E = D;
                    D = C;
                    C = rotate_left(B, 30);
                    B = A;
                    A = temp;
                }
                for (i = 60; i <= 79; i++) {
                    temp = (rotate_left(A, 5) + (B ^ C ^ D) + E + W[i] + 0xCA62C1D6) & 0x0ffffffff;
                    E = D;
                    D = C;
                    C = rotate_left(B, 30);
                    B = A;
                    A = temp;
                }
                H0 = (H0 + A) & 0x0ffffffff;
                H1 = (H1 + B) & 0x0ffffffff;
                H2 = (H2 + C) & 0x0ffffffff;
                H3 = (H3 + D) & 0x0ffffffff;
                H4 = (H4 + E) & 0x0ffffffff;
            }
            var temp = cvt_hex(H0) + cvt_hex(H1) + cvt_hex(H2) + cvt_hex(H3) + cvt_hex(H4);
            return temp.toLowerCase();
        }
    </script>
    <script>
        $(document).ready(function() {
            $(".flashmessage").delay(3000).fadeOut(100);


            $("#mysignform").validate({
                rules: {
                    inputsign: {
                        required: true,
                    },
                    inputPin: {
                        required: true,
                        minlength: 6,
                        maxlength: 6,
                        digits: true
                    }
                },
                messages: {
                    inputsign: {
                        required: "Veuillez ajouter une signature valide"
                    },
                    inputPin: {
                        required: "Veuillez définir un code PIN sécurisé et des chiffres uniquement",
                        minlength: "Veuillez saisir 6 chiffres ",
                        maxlength: "Veuillez saisir 6 chiffres "
                    }
                },
                submitHandler: function(form) { // for demo
                    var formdata = new FormData($('#mysignform')[0]);
                    //console.log();
                    //formdata.append('notes',CKEDITOR.instances['note_desc'].getData());
                    $.ajax({
                        url: 'Profile/uploadSign',
                        data: formdata,
                        contentType: false,
                        processData: false,
                        type: "post",
                        dataType: "json",
                        beforeSend: function() {
                            $('.looading').show();
                            $('#signUpload').prop('disabled', true);
                        },
                        success: function(response) {
                            $('.looading').hide();
                            $("#mysignform")[0].reset();
                            //$('#signUpload').prop('disabled',false);
                            if (response.error) {
                                $('#signUpload').text('Essayer plus tard');
                            } else {
                                $('#signUpload').text('Signature téléchargée');
                            }

                        }
                    });
                }
            });
            $('#reprendre').on('click', function() {
                $('#myModalReprendre').modal('show');
            });

            $('#signature').on('click', function() {
                $('#myModalSignature').modal('show');
            });

            // $('#signature').on('click', function() {
            //     $('#myModalSignature').modal('show');
            //     $("#mysignformview").validate({
            //         rules: {
            //             inputPin: {
            //                 required: true,
            //                 minlength: 6,
            //                 maxlength: 6,
            //                 digits: true
            //             }
            //         },
            //         messages: {
            //             inputPin: {
            //                 required: "Veuillez saisir un code PIN à 6 chiffres",
            //                 minlength: "Veuillez saisir 6 chiffres",
            //                 maxlength: "Veuillez saisir 6 chiffres"
            //             }
            //         },
            //         submitHandler: function(form) { // for demo
            //             var formdata = new FormData($('#mysignformview')[0]);


            //             $.ajax({
            //                 url: 'Profile/viewSignLab',
            //                 data: formdata,
            //                 contentType: false,
            //                 processData: false,
            //                 type: "post",
            //                 dataType: "json",
            //                 beforeSend: function() {
            //                     $('.looading').show();
            //                     $('#signUpload').prop('disabled', true);
            //                 },
            //                 success: function(response) {
            //                     $('.looading').hide();
            //                     $("#mysignformview")[0].reset();
            //                     $('#signUpload').prop('disabled', false);
            //                     if (response.error) {
            //                         $('.sign').html('');
            //                         $('.error').css('color', 'red').text(response.message);
            //                     } else {
            //                         var data = response.user_signature;
            //                         // console.log("***** RESULTAT *******")
            //                         // console.log(data)
            //                         // console.log("***** RESULTAT *******")
            //                         $('.signatture_class').html(" ");
            //                         $('.signatture_class').append(' <div class="col-md-12"><img class="imgy sign_class pull-right" src="' + data[0].sign_name + '"width="150;"height="70"alt=""/></div><br><span class="sign_class pull-right" >---------------------------------</span><br> <div class="col-md-12"><span class="sign_class pull-right" ><?php echo lang('signature'); ?></span></div>')
            //                         $('.options').removeClass('hidden');
            //                         $('#myModalSignature').modal('hide');
            //                     }

            //                 }
            //             });
            //         }
            //     });

            $(document).on('keypress', '#inputPin', function() {

                $('.error').text('');

            })

        });
    </script>