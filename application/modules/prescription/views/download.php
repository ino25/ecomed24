<html>
    <link href="common/css/bootstrap.min.css" rel="stylesheet">
    <link href="common/css/bootstrap-reset.css" rel="stylesheet">
    <header>
        <img class="header_img" src="uploads/header.jpg" width="750" height="120" alt="alt"/>
    </header>
    <?php
    $organisation = $this->home_model->getOrganisationById($prescription->id_organisation);
    $doctor = $this->doctor_model->getDoctorByIonUserId($prescription->doctor);
    $patient = $this->patient_model->getPatientById($prescription->patient, $this->id_organisation);
    ?>


    <div class="col-md-12 invoice_head clearfix">

        <div class="col-md-6 text-left invoice_head_left">
            <h4>
                <?php echo $doctor->name ?>
            </h4>
            <h4>
                <?php echo $doctor->department ?>
            </h4>
            <h4>
                Tel: <?php echo $doctor->phone ?>
            </h4>
        </div>
        <div class="col-md-6 text-right invoice_head_right">

            <h4>
                <?php echo $organisation->nom ?>
            </h4>
            <h4>
                <?php echo $organisation->adresse ?>
            </h4>
            <h4>
                <?php echo $organisation->email ?>
            </h4>

        </div>



    </div>
    <div class="col-md-12 hr_border">
        <hr>

    </div>
    <div class="col-md-12 invoice_head clearfix">

        <div class="col-md-6 text-left invoice_head_left">

            <img style="margin-top:-20px;" class="qr_code" src="<?php echo base_url(); ?>uploads/qrcode/<?php echo $prescription->qr_code; ?>" width="70" height="70" alt="alt"/>
        </div>
        <div class="col-md-6 text-right invoice_head_right">

            <h4>
                <?php echo lang('date'); ?> : <?php echo date('d-m-Y', $prescription->date); ?>
            </h4>


        </div>



    </div>
    <div class="col-md-12 hr_border" style="margin: 0px;">
        <hr>

    </div>
    <div class="col-md-12 invoice_head clearfix">

        <div class="col-md-6 text-left invoice_head_left">
            <h4>  <?php echo lang('patient'); ?>: <?php
                if (!empty($patient)) {
                    echo $patient->name . ' ' . $patient->last_name . ' | ' . $patient->patient_id;
                }
                ?></h4>
            <h4>
                <?php echo lang('age'); ?>:
                <?php
                if (!empty($patient)) {
                    $birthDate = strtotime($patient->birthdate);
                    $birthDate = date('m/d/Y', $birthDate);
                    $birthDate = explode("/", $birthDate);
                    $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
                    echo $age . ' An(s)';
                }
                ?> , <?php echo $patient->sex; ?>
            </h4>
        </div>
        <div class="col-md-6 text-right invoice_head_right">

        </div>



    </div>
    <div class="col-md-12 hr_border" style="margin: 0px;">
        <hr>

    </div>
    <div class="col-md-12 invoice_head clearfix">


        <?php
        if (!empty($prescription->medicine)) {
            ?>


            <?php
            $medicine = $prescription->medicine;
            $medicine = explode('###', $medicine);
            foreach ($medicine as $key => $value) {
                ?>

                <?php $single_medicine = explode('***', $value); ?>
                <div class="col-md-9 text-left invoice_head_left">
                    <h4>  <strong> <?php echo lang('medicine'); ?> &nbsp; &nbsp; &nbsp;  :</strong> &nbsp; &nbsp; &nbsp; &nbsp;
                        <?php echo $this->medicine_model->getMasterMedicineById($single_medicine[0])->name . ' - ' . $single_medicine[1]; ?> , &nbsp; &nbsp; 
                        <?php echo $single_medicine[2] ?>

                    </h4>
                </div>
                <div class="col-md-3 text-right invoice_head_right">
                    <h4 class="text-right"> 
                        <?php echo $single_medicine[4]; ?> 
                    </h4>
                </div>

                <?php
            }
            ?>

        <?php } ?>
    </div>
    <div class="col-md-12 hr_border">

        <br><br>
    </div>
    <div class="col-md-12 invoice_head clearfix">


        <?php
        if (!empty($prescription->lab_test)) {
            ?>
            <h4>  <strong> <?php echo lang('lab_test'); ?> &nbsp;  :</strong>  &nbsp;

                <?php
                $lab = $prescription->lab_test;
                $lab = explode('##', $lab);
                ?>
                <ul style="padding-left:183px; margin-top: 12px;">
                    <?php foreach ($lab as $key => $value) {
                        ?>

                        <?php $single_lab = explode('*', $value); ?>

                        <li style="list-style: square inside !important;"><?php echo $single_lab[1]; ?></li>


                        <?php
                    }
                    ?>
                </ul>
            <?php } ?>
    </div>
    <div class="col-md-12 invoice_head clearfix">

        <div class="col-md-12 text-left invoice_head_left">
            <h4>
                <?php echo $prescription->advice; ?>
            </h4>
        </div>

    </div>
    <div class="col-md-12 hr_border">

        <br><br><br>

    </div>
    <div class="col-md-12 invoice_head clearfix">

        <div class="col-md-12 text-right invoice_head_right">
            <div class="col-md-12 signatture_class pull-right">
                <?php
                if (empty($prescription->signature)) {
                    if ($this->ion_auth->in_group(array('Doctor'))) {
                        ?>
                        <button class=" no-print pull-right btn btn-sm btn-primary" id="signature"><?php echo lang('signature'); ?></button>
                    <?php } else { ?>
                        ------------------------------------<br>
                        <div class="col-md-12"> <span class="sign_class pull-right"><?php echo lang('signature'); ?></span></div>
                        <?php
                    }
                } else {
                    $user_details = $this->db->get_where('users', array('id' => $prescription->doctor))->row();
                    ?> 
                    <div class="col-md-12">
                        <img class="sign_class pull-right imgy" src="<?php echo $user_details->signature; ?>" width="150" height="70" alt="alt"/><br>
                    </div>
                    <span class=" sign_class pull-right"> --------------------------</span><br>
                    <div class="col-md-12"> <span class="sign_class pull-right"><?php echo lang('signature'); ?></span></div>
                <?php } ?>
            </div>
        </div>

    </div>
    <style>

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
        .invoice_head_left{
            float: left;
        }
        .col-md-9{
            width: 70%;
        }
        .col-md-3{
            width: 20%;
        }
    </style>
</html>

