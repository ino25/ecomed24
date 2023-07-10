<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">

        <?php
        $doctor = $this->doctor_model->getDoctorById($prescription->doctor);
        $patient = $this->patient_model->getPatientById($prescription->patient, $this->id_organisation);
        ?>

        <div class="col-md-8 panel bg_container margin_top" id="prescription">
            <div class="bg_prescription">
                <div class="panel-body">
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
                                    <img src="<?php echo !empty($path_logo) ? $path_logo : "uploads/logosPartenaires/default.png"; ?>" style="max-width:180px;max-height:80px;" />

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
                                        <?php echo !empty($organisation) ? $organisation->prenom_responsable_legal2 . " " . $organisation->nom_responsable_legal2 : ""; ?><br />
                                        <?php echo !empty($organisation) ? $organisation->fonction_responsable_legal2 : ""; ?><br />
                                        <?php echo !empty($organisation) ? $organisation->description_courte_responsable_legal2 : ""; ?>
                                    </p>
                                    <p class="text-right pull-right">
                                        <?php echo !empty($organisation) ? $organisation->prenom_responsable_legal . " " . $organisation->nom_responsable_legal : ""; ?><br />
                                        <?php echo !empty($organisation) ? $organisation->fonction_responsable_legal : ""; ?><br />
                                        <?php echo !empty($organisation) ? $organisation->description_courte_responsable_legal : ""; ?>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-12 hr_border">
                                <hr>
                            </div>
                        </div>
                        <hr>
                        <div class="panel-body">
                            <div class="">
                                <h5 class="col-md-4 prescription"><?php echo lang('date'); ?> : <?php echo date('d-m-Y', $prescription->date); ?></h5>
                                <h5 class="col-md-3 prescription"><?php echo lang('prescription'); ?> <?php echo lang('id'); ?> : <?php echo $prescription->id; ?></h5>
                            </div>
                        </div>

                        <hr>
                        <div class="panel-body">
                            <div class="">
                                <h5 class="col-md-4 patient_name"><?php echo lang('patient'); ?>: <?php
                                                                                                    if (!empty($patient)) {
                                                                                                        echo $patient->name . ' ' . $patient->last_name;
                                                                                                    }
                                                                                                    ?>
                                </h5>
                                <h5 class="col-md-3 patient"><?php echo lang('patient_id'); ?>: <?php
                                                                                                if (!empty($patient)) {
                                                                                                    echo $patient->patient_id;
                                                                                                }
                                                                                                ?></h5>
                                <h5 class="col-md-3 patient"><?php echo lang('age'); ?>:
                                    <?php
                                    if (!empty($patient)) {
                                        $birthDate = strtotime($patient->birthdate);
                                        $birthDate = date('m/d/Y', $birthDate);
                                        $birthDate = explode("/", $birthDate);
                                        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
                                        echo $age . ' An(s)';
                                    }
                                    ?>
                                </h5>
                                <h5 class="col-md-2 patient text-right"><?php echo lang('gender'); ?>: <?php echo $patient->sex; ?></h5>
                            </div>
                        </div>

                        <hr>

                        <div class="col-md-12 clearfix" style="margin: 50px 0px;">



                            <div class="col-md-5 left_panel">

                                <div class="panel-body">
                                    <div class="pull-left">
                                        <h5><strong><?php echo lang('history'); ?>: </strong> <br> <br> <?php echo $prescription->symptom; ?></h5>
                                    </div>
                                </div>

                                <hr>

                                <div class="panel-body">
                                    <div class="pull-left">
                                        <h5><strong><?php echo lang('note'); ?>:</strong> <br> <br> <?php echo $prescription->note; ?></h5>
                                    </div>
                                </div>




                                <hr>

                                <div class="panel-body">
                                    <div class="pull-left">
                                        <h5><strong><?php echo lang('advice'); ?>: </strong> <br> <br> <?php echo $prescription->advice; ?></h5>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-7">

                                <div class="panel-body">

                                    <!-- <div class="panel-body">
                                <div class="pull-left"><br> <?php echo $prescription->medicament; ?></h5>
                                </div>
                            </div> -->
                                    <?php
                                    if (!empty($prescription->medicine)) {
                                    ?>
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <th><?php echo lang('medicine'); ?></th>
                                                <th><?php echo lang('instruction'); ?></th>
                                                <th class="text-right"><?php echo lang('frequency'); ?></th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $medicine = $prescription->medicine;
                                                $medicine = explode('###', $medicine);
                                                foreach ($medicine as $key => $value) {
                                                ?>
                                                    <tr>
                                                        <?php $single_medicine = explode('***', $value); ?>

                                                        <td class=""><?php echo $this->medicine_model->getMedicineById($single_medicine[0])->name . ' - ' . $single_medicine[1]; ?> </td>
                                                        <td class=""><?php echo $single_medicine[3] . ' - ' . $single_medicine[4]; ?> </td>
                                                        <td class="text-right"><?php echo $single_medicine[2] ?> </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    <?php } ?>
                                </div>


                            </div>

                        </div>


                        <!--                 
                <div class="panel-body">
                    <h5 style="text-align: center;"><?php echo lang(''); ?> <br> <br> <?php echo $settings->default_text_for_prescription; ?></h5>
                </div>
                -->

                    </div>
                    <div class="panel-body prescription_footer">
                        <div class="col-md-8 pull-left">
                            <div class="col-md-12 invoice_footer">
                                <div class="row pull-left" style="">
                                    <strong><?php echo lang('prinscrit'); ?> : </strong>
                                </div><br>
                                <div class="row pull-left" style="">
                                    <div>
                                        <h4><?php

                                            if (!empty($doctor)) {
                                                echo $doctor->name;
                                            }
                                            ?></h4>

                                    </div>
                                </div>
                            </div>
                            <h2 class='doctor'>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    20<?php echo date('y'); ?> &copy; Powered by ecoMed24.
                </div>
            </div>
            
        </div>
        <!-- invoice start-->
        <section class="col-md-4 margin_top">
            <div class="panel-primary clearfix">
                <!--<div class="panel-heading navyblue"> INVOICE</div>-->
                <div class="panel_button clearfix">
                    <div class="text-center invoice-btn no-print pull-left">
                        <a class="btn btn-info btn-lg invoice_button" onclick="javascript:window.print();"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
                    </div>
                </div>

                <div class="panel_button clearfix">
                    <div class="text-center invoice-btn no-print pull-left">
                        <a class="btn btn-info btn-sm detailsbutton pull-left download" id="download"><i class="fa fa-download"></i> <?php echo lang('download'); ?> </a>
                    </div>
                </div>
                <div class="panel_button clearfix">
                        <div class="text-center invoice-btn no-print pull-left">
                            <a class="btn btn-info btn-lg info" href='prescription/all'><i class="fa fa-medkit"></i> <?php echo lang('liste_ordonnance'); ?> </a>
                        </div>
                    <?php if ($this->ion_auth->in_group(array('Doctor'))) { ?>
                        <div class="text-center invoice-btn no-print pull-left">
                            <a class="btn btn-info btn-lg info" href='prescription'><i class="fa fa-medkit"></i> <?php echo lang('all'); ?> <?php echo lang('prescriptions'); ?> </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="panel_button">
                    <?php if ($this->ion_auth->in_group(array('admin', 'Doctor'))) { ?>
                        <div class="text-center invoice-btn no-print pull-left">
                            <a class="btn btn-info btn-lg green" href="prescription/addPrescriptionView"><i class="fa fa-plus-circle"></i> <?php echo lang('add_prescription'); ?> </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <!-- invoice end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->


<style>
    hr {
        margin-top: 0px;
        margin-bottom: 0px;
        border: 0;
        border-top: 1px solid #000;
    }

    .panel-body {
        background: #f1f2f7;
    }

    thead {
        background: transparent;
    }

    .bg_prescription {
        min-height: 810px;
        margin-top: 10px;
    }

    .prescription_footer {
        margin-bottom: 10px;
    }

    .bg_container {
        border: 1px solid #f1f1f1;
    }

    .panel {
        background: #fff;
    }

    .panel-body {
        background: #fff;
    }

    .margin_top {
        margin-top: 20px;
    }

    .wrapper {
        margin: 0px;
        padding: 60px 30px 0px 30px;
    }

    .doctor {
        color: #2f80bf;
    }

    .hospital {
        color: #2f80bf;
    }

    hr {
        border-top: 1px solid #f1f1f1;
    }

    .panel_button {
        margin: 10px;
    }

    .left_panel {
        border-right: 1px solid #ccc;
        margin-left: -15px;
    }

    th {
        border-bottom: 0px;
    }

    .col-md-4 {
        margin-right: 0px !important;
    }

    .patient {
        font-size: 12px;
    }

    .patient_name {
        font-size: 12px;
    }

    .prescription {
        font-size: 12px;
    }

    p {
        font-size: 12px;
    }




    @media print {

        .left_panel {
            border-right: 1px solid #ccc;
            margin-left: -15px;
        }

        .wrapper {
            margin: 0px;
            padding: 0px 10px 0px 0px;
        }

        .patient {
            width: 23%;
            float: left;
        }

        .patient_name {
            width: 31%;
            float: left;
        }

        .text-right {
            float: right;
        }

        .doctor {
            color: #2f80bf !important;
            font-size: 25px;
        }

        .hospital {
            color: #2f80bf !important;
        }

        .prescription {
            float: left;
        }


        .top_title {
            width: 70%;
        }

        .top_logo {
            width: 30%;
        }

        .col-md-6 {
            width: 50%;
            float: left;
        }

        .col-md-5 {
            width: 45%;
            float: left;
        }

        .col-md-7 {
            width: 55%;
            float: left;
        }

        th {
            border-bottom: 0px;
        }


    }
</style>



<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>

<script>
    $('#download').click(function() {
        var pdf = new jsPDF('p', 'pt', 'letter');
        pdf.addHTML($('#prescription'), function() {
            pdf.save('prescription_id_<?php echo $prescription->id; ?>.pdf');
        });
    });

    // This code is collected but useful, click below to jsfiddle link.
</script>

<script type="text/javascript">
    // window.print();
</script>