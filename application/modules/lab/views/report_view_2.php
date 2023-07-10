<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="container-fluid invoice-container col-md-8">
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
                            <input hidden type="text" id="logoHeaderBase64" value="<?php echo $enteteBase64 ?>">
                            <input hidden type="text" id="qrcodeBase64" value="<?php echo $qrcodeBase64 ?>">
                            <input hidden type="text" id="logoFooterBase64" value="<?php echo $footerBase64 ?>">
                            <input hidden type="text" id="signatureBase64" value="<?php echo $signatureBase64 ?>">

                        </div>
                    </div>
                </header>
                <br>
                <main>
                    <?php $patient_details = $this->patient_model->getPatientById($report_details->patient); ?>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('first_name'); ?></label>
                        <input type="text" class="form-control" id="name" name="name" id="exampleInputEmail1" value='<?php echo $patient_details->name; ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('last_name'); ?></label>
                        <input type="text" class="form-control" id="last_name" name="last_name" id="exampleInputEmail1" value='<?php echo $patient_details->last_name; ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('patient_ids'); ?></label>
                        <input type="text" class="form-control" id="code_patient" name="patient_id" id="exampleInputEmail1" value='<?php echo $patient_details->id; ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('date_of_birth'); ?></label>
                        <input type="text" class="form-control" name="date_of_birth" id="birthdate" value='<?php echo $patient_details->birthdate; ?>' placeholder="" readonly="">
                        <input type="hidden" class="form-control" id="age" name="age" value='<?php echo $patient_details->age; ?>' placeholder="" readonly="">

                    </div>
                    <div class="form-group col-md-2">
                        <label for="exampleInputEmail1"> <?php echo lang('age'); ?></label>
                        <input type="text" class="form-control" name="age" value='<?php echo $patient_details->age; ?>' placeholder="" readonly="">

                    </div>
                    <div class="form-group col-md-2">
                        <label for="exampleInputEmail1"> <?php echo lang('gender'); ?></label>
                        <input type="text" class="form-control" id="sexe" name="gender" id="exampleInputEmail1" value='<?php echo $patient_details->sex; ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('address'); ?></label>
                        <input type="text" class="form-control" id="address" name="address" id="exampleInputEmail1" value='<?php echo $patient_details->address; ?>' placeholder="" readonly="">
                        <input type="hidden" class="form-control" id="region" name="region" id="exampleInputEmail1" value='<?php echo $patient_details->region; ?>' placeholder="" readonly="">

                    </div>
                    <?php if (strtolower($lab_details->name) == 'pcr') { ?>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"> <?php echo lang('passport_number'); ?></label>
                            <input type="text" class="form-control" id="numero_passeport" name="passport" id="exampleInputEmail1" value='<?php echo $patient_details->passport; ?>' placeholder="" readonly="">
                            <input type="hidden" class="form-control" id="passport" value='<?php echo $patient_details->passport; ?>' placeholder="" readonly="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"> <?php echo lang('purpose_of_test'); ?></label>
                            <?php
                            $pur = $this->db->get_where('purpose', array('id' => $payments->purpose))->row();
                            $prescripteur = $this->db->get_where('users', array('id' => $payments->prescripteur))->row();
                            if (empty($prescripteur)) {
                                $prescripteur = ''; ?>
                                <input type="hidden" id="prescripteur" name="prescripteur" value="<?php echo $prescripteur; ?>">

                            <?php } else {
                                $prescripteur = $prescripteur->first_name . ' ' . $prescripteur->last_name; ?>
                                <input type="hidden" id="prescripteur" name="prescripteur" value="<?php echo $prescripteur; ?>">
                            <?php  }
                            if (empty($pur)) {
                                $purpo = '';
                            } else {
                                $purpo = $pur->name;
                            }
                            ?>
                            <input type="text" class="form-control" id="motif_voyage" name="purpose" id="motif_voyage" value='<?php echo $purpo; ?>' placeholder="" readonly="">
                            <input type="hidden" class="form-control" name="date_prescription" id="date_prescription" value='<?php echo $payments->date_string; ?>' placeholder="" readonly="">
                            <input type="hidden" class="form-control" name="" id="purpose" value='<?php echo $purpo; ?>' placeholder="" readonly="">
                        </div>
                    <?php } else { ?> <div class="form-group col-md-4 garbage no-print">asdasdsadasdasdasdasdasdasdasd</div> <?php } ?>

                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('report_id'); ?></label>
                        <input type="text" class="form-control" name="report_code" id="identifiant_rapport" value='<?php echo $report_details->report_code; ?>' placeholder="" readonly="">

                    </div>
                    <div class="col-md-12 hr_border">
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('type_of_sampling'); ?></label>
                        <input type="text" class="form-control" name="type_of" id="type_prelevement" value='<?php echo $this->db->get_where('sampling', array('id' => $report_details->sampling))->row()->name; ?>' placeholder="" readonly="">
                        <input type="hidden" class="form-control" id="type_of" value='<?php echo $this->db->get_where('sampling', array('id' => $report_details->sampling))->row()->name; ?>' placeholder="" readonly="">
                    </div>
                    <style>
                        .rowStyle {
                            background-color: #000 !important;
                        }
                    </style>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('sampling_date_time'); ?></label>
                        <input type="text" class="form-control" name="sampling_date" id="date_prelevement" value='<?php echo $report_details->sampling_date; ?>' placeholder="" readonly="">
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
                        <input type="hidden" class="form-control" name="report_code" id="speciality" value='<?php echo $lab_details->speciality; ?>' placeholder="" readonly="">
                    </div>
                    <div class="col-md-12">
                        <h4 class="text-center"><?php echo $lab_details->name; ?></h4>
                        <input type="hidden" value="<?php echo $lab_details->name; ?>" id="prestation">
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
                                                                                                                                        ?></span> </strong>
                                                    <input type="hidden" id="resultat" value="<?php
                                                                                                if ($det[15] == 'p') {
                                                                                                    echo lang('positive');
                                                                                                } else {
                                                                                                    echo lang('negative');
                                                                                                }
                                                                                                ?>">
                                                </td>
                                                <td class="col-4 border-0" style="width: 35%;"><strong><span class="prestationFacture"><?php
                                                                                                                                        if ($det[15] == 'p') {
                                                                                                                                            echo lang('positive');
                                                                                                                                        } else {
                                                                                                                                            echo lang('negative');
                                                                                                                                        }
                                                                                                                                        ?></span> </strong>
                                                </td>
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
                        <input type="hidden" id="conclusion" value="<?php echo $this->db->get_where('conclusion', array('id' => $report_details->conclusion))->row()->name; ?>">
                        <?php echo $this->db->get_where('conclusion', array('id' => $report_details->conclusion))->row()->name; ?>
                    </div>

                    <div class="col-md-12 pull-right">
                        <img class="sign_class pull-right imgy" src="<?php echo $signature; ?>" width="150" height="150" alt="alt" /><br>
                        <input type="hidden" id="signature" value="<?php echo $signature; ?>">
                    </div>

                    <!-- <div class="col-md-12 signatture_class pull-right">
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
                                <img class="sign_class pull-right imgy" src="<?php echo $signature; ?>" width="150" height="70" alt="alt" /><br>
                                <input type="hidden" id="signature" value="<?php echo $signature; ?>">
                            </div>
                            <span class=" sign_class pull-right"> --------------------------</span><br>
                            <div class="col-md-12"> <span class="sign_class pull-right"><?php echo lang('signature'); ?></span></div>
                        <?php } ?>
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
        <div class="col-md-4">
            <a class="btn btn-info btn-secondary pull-left" href="finance/paymentLabo"><?php echo lang('retour'); ?></a>
            <button type="submit" onclick="print()" class="btn btn-info btn-sm invoice_button pull-left" style="margin-left: 2%;"><i class="fa fa-print"></i> Imprimer</button>
            <button type="submit" onclick="download()" class="btn btn-info btn-sm detailsbutton pull-left download" style="margin-left: 2%;"><i class="fa fa-download"></i> Télécharger</button>
            <?php
            if (empty($report_details->transfer)) {
                if ($this->ion_auth->in_group(array('Laboratorist', 'Biologiste', 'admin' . 'Receptionist', 'Assistant', 'adminmedecin', 'Doctor'))) {
            ?>

                    <button id="transfer" data-id="<?php echo $report_details->id ?>" class="btn btn-info green btn-sm">
                        <i class="fa fa-paper-plane"></i> <?php echo lang('transfert'); ?>
                    </button>
                    <!-- <a class="btn btn-info btn-sm  pull-left" href="lab/transfer?id="><i class="fa fa-paper-plane"></i> <?php echo lang('transfert'); ?> </a> -->

            <?php
                }
            }
            ?>
            <!-- <button id="transfer" data-id="<?php echo $report_details->id ?>" class="btn btn-info green btn-sm">
                <i class="fa fa-paper-plane"></i> <?php echo lang('transfert'); ?>
            </button> -->
        </div>



        <div class="col-md-12 no-print">


        </div>
    </section>


    <div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"> <?php echo lang('transfert'); ?> </h4>
                </div>
                <div class="modal-body">
                    <form role="form" id="transferLabReport" action="finance/transfer" class="clearfix" method="post" enctype="multipart/form-data">

                        <div class="form-group col-md-12">
                            <label class="radio-inline"><input type="radio" class="medium" name="medium" value='email' checked><?php echo lang('email'); ?></label>
                            <label class="radio-inline"><input type="radio" class="medium" name="medium" value='whatsapp' disabled><?php echo lang('whatsapp'); ?> (Bientôt Disponible)</label>

                        </div>
                        <div class="form-group col-md-12 whatsapp hidden">
                            <label for="exampleInputEmail1"> <?php echo lang('whatsapp_number'); ?><span></span></label>
                            <input type="number" class="form-control" name="whatsapp" id="what_num" value='<?php echo $patient_details->phone; ?>' placeholder="">
                        </div>
                        <div class="form-group col-md-12 email_div">
                            <label for="exampleInputEmail1"> <?php echo lang('email'); ?></label>
                            <input type="email" class="form-control" name="email" id="email_id" value='<?php echo $patient_details->email; ?>' placeholder="" required="">
                            <input type="hidden" id="date_prescriptionEmail" name="date_prescription">
                            <input type="hidden" id="resultatPCR" name="resultatPCR">
                            <input type="hidden" id="conclusionPCR" name="conclusionPCR">
                            <input type="hidden" id="conclusionPCRConvert" name="conclusionPCRConvert">
                            <input type="hidden" id="name_patientEmail" name="name_patient">
                            <input type="hidden" id="id_patientEmail" name="id_patient">

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
    <input id="datejour" type="hidden" name="date" value='<?php echo date('d/m/Y'); ?>' placeholder="">
    <input id="nom_organisation" type="hidden" name="nom_organisation" value='<?php echo $nom_organisation ?>' placeholder="">
    <div class="modal fade" id="myModalSignature" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"> <?php echo lang('verification_signature'); ?> </h4>
                </div>
                <div class="modal-body" style="height: 150px;">
                    <form id="mysignformview" method="post">
                        <div class="form-group">
                            <label for="inputPin">Entrez le code PIN de signature </label>
                            <input type="password" id="inputPin" class="form-control" name="inputPin">
                        </div>
                        <div class="sign"></div>
                        <input type="hidden" name="docid" value='<?php echo $this->ion_auth->user()->row()->id; ?>'>
                        <input type="hidden" name="report_id" value="<?php echo $report_details->id; ?>">
                        <p class='error pull-left'></p>
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-primary pull-right" id='signUpload'><span class='looading'> <i class="fa fa-spinner fa-spin" style='display:none'></i> </span> Valider</button>
                        </div>


                    </form>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>

    <script>
        $(document).ready(function() {
            $('#signature').on('click', function() {
                $.ajax({
                    url: 'lab/otpGenerate',
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function(response) {
                    if (response.response === 'yes') {
                        $('#generate_id').val(response.generated_otp_id);
                        $('#myModal3').modal('show');
                    }
                });
            });

            $('#editLabTestForm').submit(function(e) {
                e.preventDefault();
                var otp = $('#otp').val();
                var id = $('#generate_id').val();
                var report_id = $('#report_id').val();
                $.ajax({
                    url: 'lab/otpMatch?otp=' + otp + '&id=' + id + '&report=' + report_id,
                    method: 'GET',
                    dataType: 'json',
                }).success(function(response) {
                    if (response.otp == 'yes') {
                        $('.signatture_class').html(" ");
                        $('.signatture_class').append(' <div class="col-md-12"><img class="imgy sign_class pull-right" src="' + response.signature.signature + '"width="150;"height="70"alt=""/></div><br><span class="sign_class pull-right" >---------------------------------</span><br> <div class="col-md-12"><span class="sign_class pull-right" ><?php echo lang('signature'); ?></span></div>')
                        $('.options').removeClass('hidden');
                        $('#myModal3').modal('hide');
                    } else {
                        $('#wrong_otp_msg').html(" ");
                        $('#wrong_otp_msg').append("Otp does not Match");
                    }
                });

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
    </script>
    <script>
        var name_patient = $('#name').val() + ' ' + $('#last_name').val();
        var code_patient = $('#code_patient').val();
        var birthdate = $('#birthdate').val();
        var age_patient = $('#age').val() + ' An(s) / years';
        var sexe_patient = $('#sexe').val();
        var genre
        if (sexe_patient === 'Masculin') {
            genre = 'Male'
        } else {
            genre = 'Female'
        }
        sexe_patient = $('#sexe').val() + ' / ' + genre;

        var address_patient = $('#address').val();
        var numero_passeport = $('#numero_passeport').val();
        var type_voyage = $('#motif_voyage').val();
        var date_prescription = $('#date_prescription').val();
        var date_prescription = date_prescription.match(/\d{2}\/\d{2}\/\d{4}/)[0];
        document.getElementById('date_prescriptionEmail').value = date_prescription;
        document.getElementById('name_patientEmail').value = name_patient;
        document.getElementById('id_patientEmail').value = code_patient;
        var medecin_prescripteur = $('#prescripteur').val();
        var numero_dossier = $('#identifiant_rapport').val();
        var date_heure_prelevement = $('#date_prelevement').val();
        var type_prelevement = $('#type_prelevement').val();
        var speciality = $('#speciality').val();
        var prestation = $('#prestation').val();
        var param_resultat = $('#param_resultat').val();
        var resultat = $('#resultat').val();

        var saut_ligne;
        if (name_patient.length > 15) {
            saut_ligne = '\n';
        } else {
            saut_ligne = '';
        }



        if (resultat == 'Positif') {
            resultat = 'POSITIF | DETECTED';
            document.getElementById('resultatPCR').value = resultat;
        }
        if (resultat == 'Négatif') {
            resultat = 'NEGATIF | NOT DETECTED';
            document.getElementById('resultatPCR').value = resultat;
        }



        var conclusion = $('#conclusion').val();
        document.getElementById('conclusionPCR').value = conclusion;


        var conclusionTranslate;
        if (conclusion == 'Recherche directe d\'ARN du SARS-Cov-2: Négative') {
            conclusionTranslate = 'Direct research of SARS-Cov-2 RNA: Negative';
            document.getElementById('conclusionPCRConvert').value = conclusionTranslate;
        }
        if (conclusion == 'Recherche directe d\'ARN du SARS-Cov-2: Positive') {
            conclusionTranslate = 'Direct research of SARS-Cov-2 RNA: Positive';
            document.getElementById('conclusionPCRConvert').value = conclusionTranslate;
        }
        //  var  conclusionTranslate = 'Direct research of SARS-Cov-2 RNA: Positive'
        var headerBase64 = $('#logoHeaderBase64').val();
        var footerBase64 = $('#logoFooterBase64').val();
        var signatureBase64 = $('#signatureBase64').val();
        var qrcodeBase64 = $('#qrcodeBase64').val();
        var datejour = $('#datejour').val();
        var nom_organisation = $('#nom_organisation').val();
        var qr_details = 'Patient Prénom: ' + name_patient + ', date de naissance: ' + birthdate + ', date de prélèvement:' + date_heure_prelevement + ', RÉSULTAT:' + resultat;
        var region = $('#region').val();

        $('#transfer').on('click', function() {
            var id = $(this).attr('data-id');
            $('#transferModal').modal('show');
        });

        var dd = {
            pageSize: 'A4',
            footer: [{
                    columns: [{
                        image: footerBase64,
                        width: 550,
                        height: 20
                    }],
                    margin: [0, -10, 0, 0]
                },
                {
                    alignment: 'justify',
                    widths: [90, 100, '*'],
                    columns: [{
                        // text: 'Résultats d\'analyses de ' + fisrt_name_patient + ' ' + last_name_patient + ' ,Imprimé par : ' + users + ', le ' + dateFooter + ' à ' + Heure,
                        text: "",
                        alignment: 'center',
                        fontSize: 12,
                        margin: 5
                    }]
                },
            ],
            content: [
                'Page Contents'
            ],
            content: [{
                    columns: [{
                        image: headerBase64,
                        width: 550,
                        height: 100
                    }]
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
                        widths: [110, '*', 30, 110, '*'],

                        // dontBreakRows: true,
                        // keepWithHeaderRows: 1,
                        body: [
                            [{
                                    text: [{
                                            text: 'Date: \n',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: 'Date:\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        },
                                        {
                                            text: 'ID Rapport: \n',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: 'Report ID:\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        },
                                        {
                                            text: 'Date de prélèvement: \n',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: 'Sample date:\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        },
                                        {
                                            text: 'Type de prélèvement: \n',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: 'Type of sample:\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        }, {
                                            text: 'Passeport :\n ',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: 'Passport:\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        },
                                        {
                                            text: 'Motif:\n ',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: 'Reasons :\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        }

                                    ],
                                },
                                {
                                    text: [{
                                            text: date_prescription + ' \n',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: '\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        },
                                        {
                                            text: numero_dossier + ' \n',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: date_heure_prelevement + ' \n',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: '\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        },
                                        {
                                            text: type_prelevement + ' \n',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: '\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        },
                                        {
                                            text: numero_passeport + ' \n',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: '\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        },
                                        {
                                            text: type_voyage + ' \n',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: '\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        }
                                    ],
                                    margin: [25, 0, 0, 0]
                                },
                                {
                                    text: ''
                                },
                                {
                                    text: [{
                                            text: 'Prénom et Nom: \n',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: 'Last and first name:\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        },
                                        saut_ligne,
                                        {
                                            text: 'Code : \n',
                                            fontSize: 11,
                                            bold: true,
                                            margin: 20
                                        },
                                        {
                                            text: 'Code:\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        },
                                        {
                                            text: 'Age :\n ',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: 'Age:\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        },
                                        {
                                            text: 'Sexe :\n ',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: 'Gender:\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        },
                                        {
                                            text: 'Adresse :\n ',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: 'Address:\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        },

                                    ],
                                    margin: [25, 0, 0, 0]
                                },
                                {
                                    text: [{
                                            text: name_patient + ' \n',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: '\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,
                                            margin: 20

                                        },
                                        {
                                            text: code_patient + ' \n',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: '\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        },
                                        {
                                            text: age_patient + ' \n',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: '\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        },
                                        {
                                            text: sexe_patient + ' \n',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: '\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        },
                                        {
                                            text: address_patient + ', ' + region + ' \n',
                                            fontSize: 11,
                                            bold: true
                                        },
                                        {
                                            text: '\n ',
                                            fontSize: 8,
                                            bold: false,
                                            italics: true,

                                        },



                                    ],
                                    margin: [25, 0, 0, 0]
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
                    // layout: 'noBorders',
                    table: {
                        widths: [70, "*", 30, 30],
                        lineColor: '#0D4D99',

                        body: [

                            [

                                {
                                    text: '',
                                    fontSize: 12,
                                }, {
                                    text: 'RÉSULTATS DES ANALYSES | TEST RESULTS',
                                    fontSize: 15,
                                    bold: true,
                                    color: '#0D4D99',
                                    alignment: 'center',
                                    fillColor: '#eeeeee',

                                }, {
                                    text: '',
                                    fontSize: 12,
                                },
                                {
                                    text: '',
                                    fontSize: 12,
                                },
                            ],
                        ]
                    },

                    layout: 'lightHorizontalLines',
                },
                {
                    fillColor: '#FAF9F5',
                    text: 'Biologie moléculaire | Molecular biology',
                    alignment: 'center',
                    fontSize: 13,
                    bold: true,
                },
                {
                    text: '',
                    style: 'header'
                },
                {
                    text: '',
                    style: 'header'
                },
                {
                    fillColor: '#FAF9F5',
                    text: 'RECHERCHE D’ARN DU SARS-COV-2(qRT-PCR) | PCR TEST FOR SARS-COV-2(qRT-PCR)',
                    alignment: 'center',
                    fontSize: 12,
                    bold: true,
                },
                {
                    text: '',
                    style: 'header'
                },
                {
                    text: '',
                    style: 'header'
                },
                {
                    text: [{
                            text: 'RÉSULTAT',
                            fontSize: 13
                        },
                        {
                            text: '      ',
                            fontSize: 12
                        },
                        {
                            text: '      ',
                            fontSize: 12
                        },
                        {
                            text: resultat,
                            italics: true,
                            fontSize: 13,
                            bold: true
                        },
                    ]
                },
                {
                    text: '',
                    style: 'header'
                },
                {
                    text: '',
                    style: 'header'
                },
                {
                    text: [{
                            text: "CONCLUSION",
                            fontSize: 13
                        },
                        {
                            text: '     ',
                            fontSize: 12
                        },
                        {
                            text: conclusion,
                            italics: true,
                            fontSize: 13,
                            bold: true
                        },
                    ]
                },
                {
                    text: [{
                            text: "            ",
                            fontSize: 13
                        },
                        {
                            text: '      ',
                            fontSize: 12
                        },
                        {
                            text: "            ",
                            fontSize: 13
                        },
                        {
                            text: '      ',
                            fontSize: 12
                        },
                        {
                            text: '      ',
                            fontSize: 12
                        },
                        {
                            text: conclusionTranslate,
                            italics: true,
                            fontSize: 13,
                            bold: true
                        },
                    ]
                },
                {
                    text: '',
                    style: 'header'
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
                        widths: [170, "*", 200],
                        body: [
                            [
                                {
                                    columns: [{
                                        image: qrcodeBase64,
                                        width: 120,
                                        height: 120,
                                        margin: [0, 10, 0, 0]
                                    }],
                                },
                                {
                                    text: '',
                                    style: 'header'
                                },
                                {
                                    columns: [{
                                        image: signatureBase64,
                                        width: 230,
                                        height: 230,
                                        margin: [0, -25, 0, 0]
                                    }],
                                },

                            ],
                        ],
                    },
                },
                {
                    text: 'Scanner ce QR Code à l\'aide de votre Smartphone connecté à internet pour vérifier l\'authenticité des informations contenues dans ce document',
                    alignment: 'left',
                    fontSize: 11,
                    margin: [0, -50, 0, 0]
                }
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

        async function download() {
            // pdfMake.createPdf(dd).download('Resultat_Analyse_' + name_patient + '.pdf');


            await pdfMake.createPdf(dd).download(nom_organisation + '_Resultat_Analyse_' + name_patient + '_' + datejour + '.pdf');
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
    </script>