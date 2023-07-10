<html>
    <link href="common/css/bootstrap.min.css" rel="stylesheet">
    <link href="common/css/bootstrap-reset.css" rel="stylesheet">
    <header>
        <img id="logo" src="<?php echo!empty($path_logo) ? $path_logo : "uploads/logosPartenaires/default.png"; ?>" style="max-width:100px;height:50px;float: right;" title="Koice" alt="Koice" />
    </header>
    <?php
//    $organisation = $this->home_model->getOrganisationById($prescription->id_organisation);
//    $doctor = $this->doctor_model->getDoctorByIonUserId($prescription->doctor);
//    $patient = $this->patient_model->getPatientById($prescription->patient, $this->id_organisation);
    $patient_details = $this->patient_model->getPatientById($report_details->patient);
    ?>

    <hr>
    <div class="col-md-12 invoice_head clearfix">

        <div class="col-md-6 text-left invoice_head_left">
            <h4>
                <?php echo lang('first_name'); ?>: <?php echo $patient_details->name; ?>
            </h4>

            <h4>
                <?php echo lang('patient_ids'); ?>: <?php echo $patient_details->id; ?>
            </h4>

            <h4>
                <?php echo lang('gender'); ?>: <?php echo $patient_details->sex; ?>
            </h4>
        </div>
        <div class="col-md-6 text-right invoice_head_right">

            <h4>
                <?php echo lang('last_name'); ?>: <?php echo $patient_details->last_name; ?>
            </h4>
            <h4>
                <?php echo lang('date_of_birth'); ?>: <?php echo $patient_details->birthdate; ?>
            </h4>

        </div>
        <?php if (strtolower($lab_details->name) == 'pcr') { ?>
            <div class="col-md-12">
                <div class="col-md-6 text-left invoice_head_left">

                    <h4>
                        <?php echo lang('passport'); ?>: <?php echo $patient_details->passport; ?>
                    </h4>


                </div>
                <div class="col-md-6 text-right invoice_head_right">

                    <h4>
                        <?php echo lang('purpose_of_test'); ?>: <?php echo $this->db->get_where('purpose', array('id' => $payments->purpose))->row()->name; ?>
                    </h4>

                </div>
            </div>
        <?php } ?>


    </div>
    <hr>
    <div class="col-md-12 invoice_head clearfix">

        <div class="col-md-6 text-left invoice_head_left">
            <h4>
                <?php echo lang('type_of_sampling'); ?>: <?php echo $this->db->get_where('sampling', array('id' => $report_details->sampling))->row()->name; ?>
            </h4>

            <h4>
                <?php echo lang('report_id'); ?>: <strong><?php echo $report_details->report_code; ?></strong>
            </h4>


        </div>
        <div class="col-md-6 text-right invoice_head_right">

            <h4>
                <?php echo lang('sampling_date'); ?>: <strong><?php echo $report_details->sampling_date; ?></strong>
            </h4>


        </div>
    </div>

    <hr> 
    <div class="col-md-12 test_speciality"> 
        <h3 class="text-center text_speciality"><?php echo $lab_details->speciality; ?></h3>
    </div>
    <div class="col-md-12">   <h4 class="text-center"><?php echo $lab_details->name; ?></h4></div>
    <div class="col-md-12 invoice_head clearfix">

        <table class="table mb-0 table-bordered" style="border:1px solid">
            <thead class="rowStyle thead-dark" style="color: #000 !important;">
                <tr>
                    <td class="col-1 border-0" style="width: 10%;"><strong>#</strong></td>
                    <td class="col-3 border-0" style="width: 40%;"><strong><?php echo lang('parameter_name'); ?></strong></td>
                    <td class="col-4 border-0" style="width: 25%;"><strong><?php echo lang('test_result'); ?></strong></td>
                    <td class="col-4 border-0" style="width: 25%;"><strong><?php echo lang('reference_value'); ?></strong></td>


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
                                        if ($det[6] == 'positive') {
                                            echo lang('positive');
                                        } else {
                                            echo lang('negative');
                                        }
                                        ?></span> </strong></td>
                            <td class="col-4 border-0" style="width: 35%;"><strong><span class="prestationFacture"><?php
                                        if ($det[4] == 'positive') {
                                            echo lang('positive');
                                        } else {
                                            echo lang('negative');
                                        }
                                        ?></span> </strong></td> 
                        <?php } ?>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>


    </div>
    <div class="col-md-12 hr_border">

        <br><br>
    </div>

    <div class="col-md-12">
        <div class="form-group col-md-4">
            <img  class="qr_code" src="<?php echo base_url(); ?>uploads/qrcode/<?php echo $report_details->qr_code; ?>" width="70" height="70" alt="alt"/>
        </div>
        <div class="form-group con clearfix col-md-8 pull-right">
            <label for="exampleInputEmail1"> <?php echo lang('conclusion'); ?>: </label>
           <strong> <?php echo $this->db->get_where('conclusion', array('id' => $report_details->conclusion))->row()->name; ?> </strong>
        </div>
    </div>

    <div class="col-md-12 invoice_head clearfix">

        <div class="col-md-12 text-right invoice_head_right">
            <div class="col-md-12 signatture_class pull-right">
                <?php if (empty($report_details->signature)) { ?>

                    ------------------------------------<br>
                    <div class="col-md-12"> <span class="sign_class pull-right"><?php echo lang('signature'); ?></span></div>
                    <?php
                } else {
                    $user_details = $this->db->get_where('users', array('id' => $report_details->user))->row();
                    ?> 
                    <div class="col-md-12">
                        <img class="sign_class pull-right imgy" src="<?php echo $user_details->signature; ?>" width="150" height="70" alt="alt"/><br>
                    </div>
                    <span class=" sign_class pull-right"> -------------------------------</span><br>
                    <div class="col-md-12"> <span class="sign_class pull-right"><?php echo lang('signature'); ?></span></div>
                <?php } ?>
            </div>
        </div>

    </div>
    <style>
        h4{
            font-size: 11px;
        }
        .header_img{
            width: 1200px;
            height: 140px;
        }
        .col-md-6 {
            width: 45%;

        }
        .col-md-12 {
            width: 100%;

        }
        .invoice_head_right{
            float: right;

        }
        thead{
            background-color: #000 !important;
            height:4.6cm;
        }
         .con{
             width: 66.66%;
                        font-size: 20px;
                        font-weight: 500;
                        margin-top: -80px;
                    }
                    
        .invoice_head_left{
            float: left;
        }
        .col-md-9{
            width: 70%;
        }
        .col-md-3{
            width: 20%;
        }
         .col-md-4{
            width: 30%;
        }
        .col-md-8{
            width: 60%;
        }
        .rowStyle {
            background-color: #000 !important;
        }
        td{
            text-align: center !important;
            font-size: 13px !important;;
        }
    </style>
</html>

