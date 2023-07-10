<style>
    .ui-widget.ui-widget-content {
        display: none !important;
    }

    .panel-heading {
        background: #e6e9ed;
    }

    hr.new3 {
        border-top: 1px dotted red;
    }

    .pdfobject-container {
        height: 30rem;
        border: 1rem solid rgba(0, 0, 0, .1);
    }

    
</style>
<?php

$type = '';
if (isset($_GET['type'])) {
    $type = $_GET['type'];
}  ?>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-12">
            <div class='thumbnail'>
                <header class="panel-heading clearfix">
                    <div class="">
                        <?php echo lang('patient_info2'); ?>
                    </div>

                </header>
                <aside class="profile-nav">
                    <section class="row">
                        <div class='col-sm-4'>
                            <div class="user-heading round ">
                                <div class="user-img-circle">
                                    <img class="avatar" src="<?php echo !empty($patient->img_url) ? $patient->img_url : 'uploads/imgUsers/contact-512.png' ?>" alt="" style="max-width: 110px; max-height: 110px;">
                                </div>
                                <h1> <?php echo $patient->name . ' ' . $patient->last_name; ?> </h1>
                                <p> <?php echo $patient->phone; ?> </p>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Receptionist', 'Assistant', 'adminmedecin'))) { ?>
                                    <button type="button" class="btn btn-info btn-xs btn_width editPatientForm" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $patient->id; ?>"><i class="fa fa-edit"> </i> <?php echo lang('edit'); ?></button>
                                <?php } ?>

                            </div>
                        </div>
                        <div class='col-sm-8'>
                            <ul class="nav nav-pills nav-stacked">
                                <!--  <li class="active"> <?php echo lang('patient'); ?> <?php echo lang('name') . ' ' . lang('last_name'); ?><span class="label pull-right r-activity"><?php echo $patient->name; ?></span></li> -->
                                <li> <?php echo lang('patient_id'); ?> <span class="label pull-right r-activity"><?php echo $patient->patient_id; ?></span></li>
                                <li> <?php echo lang('gender'); ?><span class="label pull-right r-activity"><?php echo $patient->sex; ?></span></li>
                                <li> <?php echo lang('birth_date'); ?><span class="label pull-right r-activity"><?php echo str_replace('-', '/', $patient->birthdate); ?></span></li>
                                <?php if (!empty($patient->age)) { ?>
                                    <li> Age<span class="label pull-right r-activity"><?php echo $patient->age . ' An(s)'; ?></span></li>
                                <?php } ?>
                                <li> <?php echo lang('email'); ?><span class="label pull-right r-activity"><?php echo $patient->email; ?></span></li>
                                <li> <?php echo lang('address'); ?><span class="label pull-right r-activity"><?php echo $patient->address; ?></span></li>
                                <li> <?php echo lang('region'); ?><span class="label pull-right r-activity"><?php echo $patient->region; ?></span></li>
                                <li class="">
                                    <input type="checkbox" name="choice_pos_matriculeinfo" id="customCheckinfo" value="0"> <?php echo lang('choice_pos_matricule') ?>
                                </li>

                                <li class="pos_matriculeinfo" style="display: none"> <?php echo lang('matricule'); ?><span class="label pull-right r-activity"><?php echo $patient->matricule; ?></span></li>
                                <li class="pos_matriculeinfo" style="display: none"> <?php echo lang('grade'); ?><span class="label pull-right r-activity"><?php echo $patient->grade; ?></span></li>
                                <li class="pos_matriculeinfo" style="display: none"> <?php echo lang('birth_position'); ?><span class="label pull-right r-activity"><?php echo $patient->birth_position; ?></span></li>
                                <li class="pos_matriculeinfo" style="display: none"> <?php echo lang('nom_contact'); ?><span class="label pull-right r-activity"><?php echo $patient->nom_contact; ?></span></li>
                                <li class="pos_matriculeinfo" style="display: none"> <?php echo lang('phone_contact'); ?><span class="label pull-right r-activity"><?php echo $patient->phone_contact; ?></span></li>
                                <li class="pos_matriculeinfo" style="height: 300px;display: none"> <?php echo lang('religion'); ?><span class="pull-right" style="height: 200px;"><?php echo $patient->religion; ?></span></li>
                            </ul>
                        </div>
                    </section>
                </aside>

            </div>
        </section>





        <section class="col-md-12">
            <div class='thumbnail'>
                <header class="panel-heading clearfix">
                    <div class="col-md-7">
                        <?php echo lang('dossier'); ?> | <?php echo $patient->name . ' ' . $patient->last_name; ?>
                    </div>

                    <!-- <div class="col-md-5 pull-right">
                    <button class="btn btn-info green no-print pull-right" onclick="javascript:window.print();"><?php echo lang('print'); ?></button>
                </div>-->
                </header>

                <section class="panel-body">
                    <header class="panel-heading tab-bg-dark-navy-blueee">
                        <ul class="nav nav-tabs">
                            <li class="active" id="tabappointments">
                                <a data-toggle="tab" data-id="tabappointments" href="#appointments"><?php echo lang('appointments'); ?></a>
                            </li>
                            <?php if ($this->ion_auth->in_group(array('admin', 'Receptionist', 'Assistant', 'Accountant', 'adminmedecin'))) { ?>
                                <li class="" id="tabpayment">
                                    <a data-toggle="tab" href="#payment" data-id="tabpayment"><?php echo lang('payments'); ?></a>
                                </li>
                            <?php } ?>
                            <?php if ($this->ion_auth->in_group(array('admin', 'Receptionist', 'Assistant', 'adminmedecin'))) { ?>
                                <li class="" id="tabmutuelleinfo">
                                    <a data-toggle="tab" href="#mutuelleinfo" data-id="tabmutuelleinfo"><?php echo lang('mutuelles'); ?></a>
                                </li>
                                <li class="" id="tabmutuellerelation">
                                    <a data-toggle="tab" href="#mutuellerelation" data-id="tabmutuellerelation">
                                        <?php if (!$lien_parente) { ?>
                                            <?php echo lang('mutuelle_relations'); ?>
                                        <?php } else { ?>
                                            <?php echo lang('responsable'); ?>
                                        <?php } ?>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($this->ion_auth->in_group(array('Doctor', 'adminmedecin'))) { ?>
                                <li class="" id="tabconsultation">
                                    <a data-toggle="tab" href="#consultation" data-id="tabconsultation"><?php echo lang('consultation_medicals'); ?></a>
                                </li>

                                <!--<li class=""  id="tabprescription">
                            <a data-toggle="tab" href="#prescription" data-id="tabprescription" ><?php echo lang('prescriptions'); ?></a>
                        </li>-->
                                <li class="" id="tablab">
                                    <a data-toggle="tab" href="#lab" data-id="tablab">Analyses Labo</a>
                                </li>
                            <?php } ?>
                            <li class="" id="tabdocuments">
                                <a data-toggle="tab" href="#documents" data-id="tabdocuments">Images médicales</a>
                            </li>
                            <li class="" id="tabordonnances">
                                <a data-toggle="tab" href="#ordonnance" data-id="tabordonnances">Ordonnance</a>
                            </li>
                            <!--   <li class="">
                            <a data-toggle="tab" href="#contact"><?php echo lang('bed'); ?></a>
                        </li>-->
                            <?php if ($this->ion_auth->in_group(array('admin', 'adminmedecin'))) { ?>
                                <li class="" id="tabtimeline">
                                    <a data-toggle="tab" href="#timeline" data-id="tabtimeline"><?php echo lang('timeline'); ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </header>
                    <div class="panel">
                        <div class="tab-content">
                            <div id="appointments" class="tab-pane active">
                                <div class="">
                                    <?php if (!$this->ion_auth->in_group('Patient')) { ?>
                                        <div class=" no-print">
                                            <a class="btn btn-info btn_width btn-xs pull" data-toggle="modal" href="#addAppointmentModal">
                                                <i class="fa fa-plus-circle"> </i> <?php echo lang('add'); ?>
                                            </a>
                                        </div>
                                    <?php } else { ?>
                                        <div class=" no-print">
                                            <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#addAppointmentModal">
                                                <i class="fa fa-plus-circle"> </i> <?php echo lang('request_a_appointment'); ?>
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <div class="adv-table editable-table ">



                                        <table class="table table-hover progress-table text-center_ patient-table " id="">

                                            <thead>
                                                <tr>
                                                    <th><?php echo lang('date'); ?></th>
                                                    <th><?php echo lang('time_slot'); ?></th>
                                                    <th><?php echo lang('service'); ?></th>
                                                    <th><?php echo lang('status'); ?></th>
                                                    <?php if (!$this->ion_auth->in_group('Patient')) { ?>
                                                        <th class="no-print"><?php echo lang('options'); ?></th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($appointments as $appointment) {
                                                    $status = '';

                                                    if ($appointment->status == 'Pending Confirmation') {
                                                        $status = '<span class="status-p bg-warning">' . lang('pending_confirmation') . '</span>';
                                                    } elseif ($appointment->status == 'Confirmed') {
                                                        $status = '<span class="status-p bg-success">' . lang('confirmed') . '</span>';
                                                    } elseif ($appointment->status == 'Treated') {
                                                        $status = '<span class="status-p bg-primary">' . lang('treated') . '</span>';
                                                    } elseif ($appointment->status == 'Cancelled') {
                                                        $status = '<span class="status-p bg-danger">' . lang('cancelled') . '</span>';
                                                    }

                                                ?>
                                                    <tr class="">

                                                        <td><?php echo date('d/m/Y', $appointment->date); ?></td>
                                                        <td><?php echo $appointment->time_slot; ?></td>
                                                        <td><?php echo $appointment->servicename; ?></td>
                                                        <td><?php echo $status; ?></td>
                                                        <?php if ($this->ion_auth->in_group(array('Doctor', 'adminmedecin', 'admin', 'Receptionist', 'Assistant'))) { ?>
                                                            <td class="no-print">
                                                                <?php if ($appointment->status == 'Pending Confirmation' || $appointment->status == 'Confirmed') { ?>
                                                                    <button type="button" class="btn btn-info btn-xs btn_width editAppointmentButton" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $appointment->id; ?>"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></button>
                                                                    <?php if ($appointment->status == 'Confirmed') { ?>
                                                                        <a class="btn btn-info btn-xs btn_width detailsbutton" title=" <?php echo lang('start_live');  ?>" style="color: #fff;" href="meeting/instantLive?id=<?php echo $appointment->id; ?>" target="_blank"><i class="fa fa-headphones"></i> <?php echo lang('live'); ?> </a>


                                                                    <?php } ?> <?php } ?>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="payment" class="tab-pane">
                                <div class="">
                                    <div class="no-print">
                                        <a class="btn btn-info btn_width btn-xs pull" href="finance/addPaymentView?patient=<?php echo $patient->id; ?>&type=gen&page=patient">

                                            <i class="fa fa-plus-circle"></i> <?php echo lang('add'); ?>

                                        </a>

                                    </div>

                                    <div class="adv-table editable-table ">

                                        <table class="table table-hover progress-table text-center_ patient-table" id="editable-samples">

                                            <thead>
                                                <tr>
                                                    <th class=""><?php echo lang('date'); ?></th>
                                                    <th class=""><?php echo lang('invoice'); ?> #</th>
                                                    <th class=""><?php echo lang('amount'); ?></th>
                                                    <th class=""><?php echo lang('deposit'); ?></th>
                                                    <th class=""><?php echo lang('deposit_type'); ?></th>
                                                    <th class="no-print"><?php echo lang('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <style>
                                                    .img_url {
                                                        height: 20px;
                                                        width: 20px;
                                                        background-size: contain;
                                                        max-height: 20px;
                                                        border-radius: 100px;
                                                    }

                                                    .option_th {
                                                        width: 33%;
                                                    }
                                                </style>

                                                <?php
                                                $dates = array();
                                                $datess = array();
                                                if ($payments) {
                                                    foreach ($payments as $payment) {
                                                        $dates[] = $payment->date;
                                                    }
                                                }
                                                foreach ($deposits as $deposit) {
                                                    $datess[] = $deposit->date;
                                                }
                                                $dat = array_merge($dates, $datess);
                                                $dattt = array_unique($dat);
                                                asort($dattt);

                                                $total_pur = array();

                                                $total_p = array();
                                                ?>

                                                <?php
                                                foreach ($dattt as $key => $value) {
                                                    if ($payments) {
                                                        foreach ($payments as $payment) {
                                                            if ($payment->date == $value) {
                                                ?>
                                                                <tr class="">
                                                                    <td><?php echo date('d/m/Y H:i', $payment->date); ?></td>
                                                                    <td> <?php echo $payment->code; ?></td>
                                                                    <td><?php echo number_format($payment->gross_total, 0, ",", "."); ?> <?php echo $settings->currency; ?> </td>
                                                                    <td>
                                                                        <?php
                                                                        if (!empty($payment->amount_received)) {
                                                                            echo number_format($payment->amount_received, 0, ",", ".") . ' ' . $settings->currency;
                                                                        }
                                                                        ?>
                                                                    </td>

                                                                    <td> <?php echo $payment->deposit_type; ?></td>


                                                                    <?php $actif = ' depositbutton ';
                                                                    if ($payment->gross_total  <= $payment->amount_received) {
                                                                        $actif = ' pointer-events  ';
                                                                    } ?>
                                                                    <td class="no-print">

                                                                        <a class="btn-xs invoicebutton" title="<?php echo lang('invoice'); ?>" style="color: #fff; width: 25%;" href="finance/invoice?id=<?php echo $payment->id; ?>&page=patient"><i class="fa fa-file-invoice"></i> <?php echo lang('invoice'); ?> </a>
                                                                        <a class="btn-xs  green <?php echo $actif; ?>" data-gross_total="<?php echo $payment->gross_total; ?>" data-amount_received="<?php echo $payment->amount_received; ?>" data-payment="<?php echo $payment->id; ?>" data-payment2="<?php echo $payment->code; ?>" data-patient="<?php echo $patient->id; ?>" style="margin-left: 10px;" href="#"><i class="fa fa-plus-circle"></i> <?php echo lang('deposit'); ?></a>

                                                                    </td>
                                                                </tr>

                                                    <?php
                                                            }
                                                        }
                                                    }
                                                    ?>


                                                    <?php
                                                    /*  foreach ($deposits as $deposit) {
                                if ($deposit->date == $value) {
                                    if (!empty($deposit->deposited_amount) && empty($deposit->amount_received_id)) {
                                        ?>

                                        <tr class="">
                                            <td><?php echo date('d/m/Y', $deposit->date); ?></td>
                                            <td><?php echo $deposit->payment_id; ?></td>
                                            <td></td>
                                            <td><?php echo $settings->currency; ?> <?php echo $deposit->deposited_amount; ?></td>
                                            <td> <?php echo $deposit->deposit_type; ?></td>  
                                            <td  class="no-print"> 
                                                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?>
                                                    <button type="button" class="btn-xs btn-info editbutton" title="<?php echo lang('edit'); ?>" style="width: 25%;" data-toggle="modal" data-id="<?php echo $deposit->id; ?>"><i class="fa fa-edit"></i> </button> 
                                                <?php } ?>
                                                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant'))) { ?> 
                                                    <a class="btn-xs btn-info delete_button" title="<?php echo lang('delete'); ?>" style="width: 25%;" href="finance/deleteDeposit?id=<?php echo $deposit->id; ?>&patient=<?php echo $patient->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }*/
                                                    ?>
                                                <?php } ?>



                                            </tbody>

                                        </table>
                                    </div>
                                </div>


                            </div>
                            <div id="consultation" class="tab-pane">
                                <div class="">

                                    <?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
                                        <div class=" no-print">
                                            <span class="btn btn-info btn_width btn-xs" id="addConsultation" data-id="<?php echo $patient->id; ?>">
                                                <i class="fa fa-plus-circle"> </i> <?php echo lang('add'); ?>
                                            </span>
                                        </div>
                                    <?php } ?>

                                    <div class="adv-table editable-table ">

                                        <table class="table table-hover progress-table text-center_ patient-table" id="">

                                            <thead>
                                                <tr>
                                                    <th><?php echo lang('date'); ?></th>
                                                    <th>Service / Prestation</th>
                                                    <th>Patient </th>
                                                    <th><?php echo lang('cons_effectuer'); ?></th>
                                                    <?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
                                                        <th class="no-print"><?php echo lang('options'); ?></th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($medical_histories as $medical_history) { ?>
                                                    <tr class="">

                                                        <td><?php echo  date('d/m/Y H:i', $medical_history->date); ?></td>
                                                        <td><?php echo $medical_history->specialite . ' / ' . $medical_history->namePrestation; ?></td>
                                                        <td><?php echo $medical_history->patient_name . ' ' . $medical_history->patient_last_name; ?></td>
                                                        <td><?php echo $medical_history->first_name . ' ' . $medical_history->last_name; ?></td>
                                                        <?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
                                                            <td class="no-print">
                                                                <button type="button" class="btn btn-info btn-xs btn_width editbutton" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $medical_history->id; ?>"><i class="fa fa-eye"></i> </button>
                                                                <!-- <a class="btn btn-info btn-xs btn_width delete_button" title="<?php echo lang('delete'); ?>" href="patient/deleteCaseHistory?id=<?php echo $medical_history->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a> -->
                                                                <!-- <a type="button" class="btn btn-info btn-xs btn_width detailsbutton case" data-toggle = "modal" data-id="<?php echo $medical_history->id; ?>"><i class="fa fa-file"> </i> </a> -->
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>




                                        <!--
                                                                        <form role="form" action="patient/addMedicalHistory" class="clearfix" method="post" enctype="multipart/form-data">
                                                                            <div class="form-group col-md-12">
                                                                                <label class=""> <?php echo lang('case'); ?> <?php echo lang('history'); ?></label>
                                                                                <div class="">
                                                                                    <textarea class="ckeditor form-control" name="description" id="description" value="" rows="100" cols="50">      
                                    <?php foreach ($medical_histories as $medical_history) { ?>         
                                                                                                                                                                                                <td><?php echo $medical_history->description; ?></td>
                                    <?php } ?>
                                                                                    </textarea>
                                                                                </div>
                                                                            </div>
                                    
                                                                            <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
                                                                            <input type="hidden" name="id" value='<?php echo $medical_history->id ?>'>
                                                                            <div class="form-group col-md-12">
                                                                                <button type="submit" name="submit" class="btn btn-info submit_button pull-right"><?php echo lang('save'); ?></button>
                                                                            </div>
                                                                        </form>
                                    
                                    -->



                                    </div>
                                </div>
                            </div>
                            <div id="prescription" class="tab-pane">
                                <div class="">
                                    <?php if ($this->ion_auth->in_group(array('Doctor', 'adminmedecin'))) { ?>
                                        <div class=" no-print">
                                            <a class="btn btn-info btn_width btn-xs" href="prescription/addPrescriptionView">
                                                <i class="fa fa-plus-circle"> </i> <?php echo lang('add'); ?>
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <div class="adv-table editable-table ">



                                        <table class="table table-hover progress-table text-center_ patient-table" id="">

                                            <thead>
                                                <tr>

                                                    <th><?php echo lang('date'); ?></th>
                                                    <th><?php echo lang('doctor'); ?></th>
                                                    <th><?php echo lang('medicine'); ?></th>
                                                    <th class="no-print"><?php echo lang('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($prescriptions as $prescription) { ?>
                                                    <tr class="">
                                                        <td><?php echo date('m/d/Y', $prescription->date); ?></td>
                                                        <td>
                                                            <?php
                                                            $doctor_details = $this->doctor_model->getDoctorById($prescription->doctor);
                                                            if (!empty($doctor_details)) {
                                                                $prescription_doctor = $doctor_details->name;
                                                            } else {
                                                                $prescription_doctor = '';
                                                            }
                                                            echo $prescription_doctor;
                                                            ?>

                                                        </td>
                                                        <td>

                                                            <?php
                                                            if (!empty($prescription->medicine)) {
                                                                $medicine = explode('###', $prescription->medicine);

                                                                foreach ($medicine as $key => $value) {
                                                                    $medicine_id = explode('***', $value);
                                                                    $medicine_details = $this->medicine_model->getMedicineById($medicine_id[0]);
                                                                    if (!empty($medicine_details)) {
                                                                        $medicine_name_with_dosage = $medicine_details->name . ' -' . $medicine_id[1];
                                                                        $medicine_name_with_dosage = $medicine_name_with_dosage . ' | ' . $medicine_id[3] . '<br>';
                                                                        rtrim($medicine_name_with_dosage, ',');
                                                                        echo '<p>' . $medicine_name_with_dosage . '</p>';
                                                                    }
                                                                }
                                                            }
                                                            ?>


                                                        </td>
                                                        <td class="no-print">
                                                            <a class="btn-xs green" href="prescription/viewPrescription?id=<?php echo $prescription->id; ?>"><i class="fa fa-eye"> <?php echo lang('view'); ?> </i></a>
                                                            <?php
                                                            if ($this->ion_auth->in_group(array('Doctor', 'adminmedecin'))) {
                                                                $current_user = $this->ion_auth->get_user_id();
                                                                $doctor_table_id = $this->doctor_model->getDoctorByIonUserId($current_user)->id;
                                                                if ($prescription->doctor == $doctor_table_id) {
                                                            ?>
                                                                    <a type="button" class="btn-info btn-xs btn_width" data-toggle="modal" href="prescription/editPrescription?id=<?php echo $prescription->id; ?>"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></a>
                                                                    <a class="btn-info btn-xs btn_width delete_button" href="prescription/delete?id=<?php echo $prescription->id; ?>" onclick="return confirm('<?php echo lang('confirm_delete'); ?>');"><i class="fa fa-trash"></i> <?php echo lang('delete'); ?></a>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <a class="btn-xs invoicebutton" title="<?php echo lang('print'); ?>" style="color: #fff;" href="prescription/viewPrescriptionPrint?id=<?php echo $prescription->id; ?>" target="_blank"> <i class="fa fa-print"></i> <?php echo lang('print'); ?></a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="lab" class="tab-pane">
                                <div class=" no-print">
                                    <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#myModalLabo">
                                        <i class="fa fa-plus-circle"> </i> <?php echo lang('add'); ?>
                                    </a>
                                </div>
                                <div class="">
                                    <div class="adv-table editable-table ">



                                        <table class="table table-hover progress-table text-center_ patient-table" id="">

                                            <thead>
                                                <tr>
                                                    <th><?php echo lang('date'); ?></th>
                                                    <th>LABO</th>
                                                    <th>PRESCRIPTEUR</th>
                                                    <th>RÉSULTATS</th>
                                                    <th class="no-print"><?php echo lang('options'); ?></th>

                                                </tr>
                                            </thead>
                                            <tbody height="15">
                                                <?php foreach ($labs as $lab) {
                                                    if ($lab->report) { ?>
                                                        <tr style="text-align:left !important;height:30px !important;">
                                                            <td style="text-align:left !important;height:30px !important;"><?php echo date('d/m/Y', $lab->date); ?></td>
                                                            <td style="text-align:left !important;height:30px !important;"><?php echo $lab->nomLabo; ?></td>
                                                            <td style="text-align:left !important;height:30px !important;"><?php echo $lab->prescripteur; ?></td>
                                                            <?php if ($lab->importLabo === "1") { ?>
                                                                <td style="text-align:left !important;height:30px !important;">
                                                                    <!-- <a class="btn btn-info btn-xs btn_width" href="<?php echo $lab->url; ?>" data-lightbox="example-1" data-title="Résultat Analyse"><i class="fa fa-eye"></i> <?php echo lang('report_'); ?></a> -->

                                                                    <a class="btn btn-info btn-xs btn_width" href="<?php echo $lab->url; ?>" onclick="window.open(this.href, 'PDF', 'height=600, width= 800, top=100, left=300, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no,status=no' );return false;"><i class="fa fa-eye"></i> <?php echo lang('report_'); ?></a>

                                                                    <!-- <input id="btnShow" type="button" value="Show PDF" />
                                                                    <div id="dialog" style="display: none">
                                                                    </div> -->
                                                                    <!-- <a href="#" id="btnShow">this link</a>
                                                                    <div id="dialog" style="display: none;">
                                                                        <div>
                                                                            <iframe id="frame"></iframe>
                                                                        </div>
                                                                    </div> -->
                                                                    <!-- <embed src="<?php echo $lab->url; ?>" frameborder="0" width="100%" height="400px">
                                                                    <div id="example1"></div> -->
                                                                </td>
                                                            <?php } else { ?>
                                                                <td style="text-align:left !important;height:30px !important;">
                                                                    <span class="btn btn-info btn-xs btn_width editlab" data-id="<?php echo $lab->id; ?>"><i class="fa fa-eye"></i> <?php echo lang('report_'); ?></span>

                                                                </td>
                                                            <?php  } ?>

                                                            <?php if (!empty($lab->importLabo)) { ?>
                                                                <td style="text-align:left !important;height:30px !important;">
                                                                    <a class="btn btn-info btn-xs btn_width" href="<?php echo $lab->url; ?>" download> <i class="fa fa-download"></i> TÉLÉCHARGER </a>
                                                                </td>
                                                            <?php } else { ?>
                                                                <td style="text-align:left !important;height:30px !important;">
                                                                    <span class="btn btn-info btn-xs btn_width downloadlab" data-id="<?php echo $lab->idPayement; ?>"><i class="fa fa-download"></i> TÉLÉCHARGER</span>
                                                                </td>
                                                            <?php  } ?>

                                                            </div>
                                                        </tr>
                                                <?php }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>



                            <div id="documents" class="tab-pane">
                            <div class=" no-print">
                                    <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#myModalImage">
                                        <i class="fa fa-plus-circle"> </i> <?php echo lang('add'); ?>
                                    </a>
                                </div>
                                <div class="">
                                    <div class="adv-table editable-table ">



                                        <table class="table table-hover progress-table text-center_ patient-table" id="">

                                            <thead>
                                                <tr>
                                                    <th><?php echo lang('date'); ?></th>
                                                    <th>CENTRE IMAGERIE</th>
                                                    <th>PRESCRIPTEUR</th>
                                                    <th>IMAGES</th>
                                                    <th class="no-print"><?php echo lang('options'); ?></th>

                                                </tr>
                                            </thead>
                                            <tbody height="15">
                                                <?php foreach ($labsImages as $lab) {
                                                    if ($lab->report) { ?>
                                                        <tr style="text-align:left !important;height:30px !important;">
                                                            <td style="text-align:left !important;height:30px !important;"><?php echo date('d/m/Y', $lab->date); ?></td>
                                                            <td style="text-align:left !important;height:30px !important;"><?php echo $lab->nomLabo; ?></td>
                                                            <td style="text-align:left !important;height:30px !important;"><?php echo $lab->prescripteur; ?></td>
                                                            <?php if (!empty($lab->importLabo)) { ?>
                                                                <td style="text-align:left !important;height:30px !important;">
                                                                    <!-- <a class="btn btn-info btn-xs btn_width" href="<?php echo $lab->url; ?>" data-lightbox="example-1" data-title="Résultat Analyse"><i class="fa fa-eye"></i> <?php echo lang('report_'); ?></a> -->

                                                                    <a class="btn btn-info btn-xs btn_width" href="<?php echo $lab->url; ?>" onclick="window.open(this.href, 'PDF', 'height=600, width= 800, top=100, left=300, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no,status=no' );return false;"><i class="fa fa-eye"></i> IMAGE</a>

                                                                    <!-- <input id="btnShow" type="button" value="Show PDF" />
                                                                    <div id="dialog" style="display: none">
                                                                    </div> -->
                                                                    <!-- <a href="#" id="btnShow">this link</a>
                                                                    <div id="dialog" style="display: none;">
                                                                        <div>
                                                                            <iframe id="frame"></iframe>
                                                                        </div>
                                                                    </div> -->
                                                                    <!-- <embed src="<?php echo $lab->url; ?>" frameborder="0" width="100%" height="400px">
                                                                    <div id="example1"></div> -->
                                                                </td>
                                                            <?php } else { ?>
                                                                <td style="text-align:left !important;height:30px !important;">
                                                                    <span class="btn btn-info btn-xs btn_width editlab" data-id="<?php echo $lab->id; ?>"><i class="fa fa-eye"></i> IMAGE</span>

                                                                </td>
                                                            <?php  } ?>

                                                            <?php if (!empty($lab->importLabo)) { ?>
                                                                <td style="text-align:left !important;height:30px !important;">
                                                                    <a class="btn btn-info btn-xs btn_width" href="<?php echo $lab->url; ?>" download> <i class="fa fa-download"></i> TÉLÉCHARGER </a>
                                                                </td>
                                                            <?php } else { ?>
                                                                <td style="text-align:left !important;height:30px !important;">
                                                                    <span class="btn btn-info btn-xs btn_width downloadlab" data-id="<?php echo $lab->idPayement; ?>"><i class="fa fa-download"></i> TÉLÉCHARGER</span>
                                                                </td>
                                                            <?php  } ?>

                                                            </div>
                                                        </tr>
                                                <?php }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="ordonnance" class="tab-pane">
                            <div class=" no-print">
                                    <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#myModalOrdonnance">
                                        <i class="fa fa-plus-circle"> </i> <?php echo lang('add'); ?>
                                    </a>
                                </div>
                                <div class="">
                                    <div class="adv-table editable-table ">



                                        <table class="table table-hover progress-table text-center_ patient-table" id="">

                                            <thead>
                                                <tr>
                                                    <th><?php echo lang('date'); ?></th>
                                                    <th>PRESCRIPTEUR</th>
                                                    <th>ORDONNANCE</th>
                                                    <th class="no-print"><?php echo lang('options'); ?></th>

                                                </tr>
                                            </thead>
                                            <tbody height="15">
                                                <?php foreach ($labsOrdonnance as $lab) {
                                                    if ($lab->report) { ?>
                                                        <tr style="text-align:left !important;height:30px !important;">
                                                            <td style="text-align:left !important;height:30px !important;"><?php echo date('d/m/Y', $lab->date); ?></td>
                                                            <td style="text-align:left !important;height:30px !important;"><?php echo $lab->prescripteur; ?></td>
                                                            <?php if ($lab->importLabo === "3") { ?>
                                                                <td style="text-align:left !important;height:30px !important;">
                                                                    <!-- <a class="btn btn-info btn-xs btn_width" href="<?php echo $lab->url; ?>" data-lightbox="example-1" data-title="Résultat Analyse"><i class="fa fa-eye"></i> <?php echo lang('report_'); ?></a> -->

                                                                    <a class="btn btn-info btn-xs btn_width" href="<?php echo $lab->url; ?>" onclick="window.open(this.href, 'PDF', 'height=600, width= 800, top=100, left=300, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no,status=no' );return false;"><i class="fa fa-eye"></i> ORDONNANCE</a>

                                                                    <!-- <input id="btnShow" type="button" value="Show PDF" />
                                                                    <div id="dialog" style="display: none">
                                                                    </div> -->
                                                                    <!-- <a href="#" id="btnShow">this link</a>
                                                                    <div id="dialog" style="display: none;">
                                                                        <div>
                                                                            <iframe id="frame"></iframe>
                                                                        </div>
                                                                    </div> -->
                                                                    <!-- <embed src="<?php echo $lab->url; ?>" frameborder="0" width="100%" height="400px">
                                                                    <div id="example1"></div> -->
                                                                </td>
                                                            <?php } else { ?>
                                                                <td style="text-align:left !important;height:30px !important;">
                                                                    <span class="btn btn-info btn-xs btn_width editlab" data-id="<?php echo $lab->id; ?>"><i class="fa fa-eye"></i> ORDONNANCE</span>

                                                                </td>
                                                            <?php  } ?>

                                                            <?php if (!empty($lab->importLabo)) { ?>
                                                                <td style="text-align:left !important;height:30px !important;">
                                                                    <a class="btn btn-info btn-xs btn_width" href="<?php echo $lab->url; ?>" download> <i class="fa fa-download"></i> TÉLÉCHARGER </a>
                                                                </td>
                                                            <?php } else { ?>
                                                                <td style="text-align:left !important;height:30px !important;">
                                                                    <span class="btn btn-info btn-xs btn_width downloadlab" data-id="<?php echo $lab->idPayement; ?>"><i class="fa fa-download"></i> TÉLÉCHARGER</span>
                                                                </td>
                                                            <?php  } ?>

                                                            </div>
                                                        </tr>
                                                <?php }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>



                            <div id="documents" class="tab-pane">
                                <div class="">
                                    <div class=" no-print">
                                        <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#myModal">
                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('add'); ?>
                                        </a>
                                    </div>
                                    <div class="adv-table editable-table ">
                                        <div class="">
                                            <?php foreach ($patient_materials as $patient_material) { ?>
                                                <div class="panel col-md-3" style="height: 200px; margin-right: 10px; margin-bottom: 36px; background: #f1f1f1; padding: 34px;">

                                                    <div class="post-info">
                                                        <a class="example-image-link" href="<?php echo $patient_material->url; ?>" data-lightbox="example-1">
                                                            <img class="example-image" src="<?php echo $patient_material->url; ?>" alt="image-1" height="100" width="100" /></a>
                                                        <!--  <img src="<?php echo $patient_material->url; ?>" height="100" width="100">-->
                                                    </div>
                                                    <div class="post-info">
                                                        <?php
                                                        if (!empty($patient_material->title)) {
                                                            echo $patient_material->title;
                                                        }
                                                        ?>

                                                    </div>
                                                    <p></p>
                                                    <div class="post-info">
                                                        <a class="btn btn-info btn-xs btn_width" href="<?php echo $patient_material->url; ?>" download> <?php echo lang('download'); ?> </a>
                                                        <?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
                                                            <a class="btn btn-info btn-xs btn_width" title="<?php echo lang('delete'); ?>" href="patient/deletePatientMaterial?id=<?php echo $patient_material->id; ?>" onclick="return confirm('<?php echo lang('confirm_delete'); ?>');"> X </a>
                                                        <?php } ?>

                                                    </div>

                                                    <hr>

                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            

                            <div id="mutuelleinfo" class="tab-pane">
                                <div class="">
                                    <?php if (empty($mutuelles)) {  ?>
                                        <?php if (!$lien_parente) { ?>
                                            <div class=" no-print">
                                                <a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#myModalMutuelle">
                                                    <i class="fa fa-plus-circle"> </i> <?php echo lang('add'); ?>
                                                </a>
                                            </div>
                                        <?php }  ?>
                                    <?php }  ?>
                                    <div class="adv-table editable-table ">



                                        <table class="table table-hover progress-table text-center_ patient-table" id="">

                                            <thead>
                                                <tr>
                                                    <th><?php echo lang('nom_mutuelle'); ?></th>
                                                    <th><?php echo lang('num_police'); ?></th>
                                                    <th><?php echo lang('charge_mutuelle'); ?></th>
                                                    <th><?php echo lang('date_valid'); ?></th>
                                                    <?php if ($mutuelles) {  ?> <th class="no-print"><?php echo lang('options'); ?></th> <?php }  ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($mutuelles) {  ?>
                                                    <tr class="">
                                                        <td><?php echo $mutuelles->nom; ?></td>
                                                        <td><?php echo $mutuelles->pm_numpolice;  ?></td>
                                                        <td><?php echo $mutuelles->pm_charge;  ?></td>
                                                        <td><?php
                                                            $pm_datevalid =  str_replace('-', '/', $mutuelles->pm_datevalid);
                                                            echo $pm_datevalid;
                                                            $buff = explode("/", $mutuelles->pm_datevalid);
                                                            $buff_1 = $buff[2] . "-" . $buff[1] . "-" . $buff[0];
                                                            if (strtotime(date("Y-m-d")) > strtotime($buff_1)) {
                                                                echo   '<span class="error"></br> <b class="btn-danger">La date de validité est dépassée.</b></span>';
                                                            } ?>

                                                        </td>
                                                        <td class="no-print">
                                                            <button type="button" class="btn btn-info btn-xs btn_width editbuttonMutuelle" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $mutuelles->idpm; ?>" data-idparent="<?php echo $mutuelles->pm_idpatent; ?>"> <i class="fa fa-edit"></i> </button>
                                                            <a class="btn btn-info btn-xs btn_width delete_button" title="<?php echo lang('delete'); ?>" href="patient/deleteMutuellePatient?id=<?php echo $mutuelles->idpm; ?>&patient_id=<?php echo $patient->id; ?>" onclick="return confirm('<?php echo lang('confirm_delete'); ?>');"><i class="fa fa-trash"></i> </a>
                                                            <input id="idpatientConsultation" type="hidden" value="<?php echo $patient->id; ?>">
                                                        </td>
                                                    </tr>
                                                <?php }  ?>

                                                <?php if ($mutuellesInit) {  ?>
                                                    <tr class="">
                                                        <td><?php echo $mutuellesInit->nom; ?></td>
                                                        <td><?php echo $mutuellesInit->pm_numpolice;  ?></td>
                                                        <td><?php echo $mutuellesInit->pm_charge;  ?></td>
                                                        <td><?php echo str_replace('-', '/', $mutuellesInit->pm_datevalid);  ?></td>

                                                    </tr>
                                                <?php }  ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="mutuellerelation" class="tab-pane">
                                <div class="">
                                    <?php if (!$lien_parente) { ?>
                                        <div class=" no-print right col-md-6">
                                            <a class="btn btn-info btn_width btn-xs right" data-toggle="modal" href="#myModalPatient">
                                                <i class="fa fa-plus-circle"> </i> <?php echo lang('add'); ?>
                                            </a>
                                        </div>
                                        <!--  <div class=" no-print left col-md-6">

                                        <select class="form-control m-bot15" id="patient_mutuelle" name="patient_mutuelle">

                                        </select>
                                    </div>-->
                                    <?php }  ?>
                                    <div class=" no-print left col-md-6"></div>
                                    <div class=" no-print right col-md-6 liste_patient_mutuelle" id="liste_patient_mutuelle"></div>

                                    <div class="adv-table editable-table ">



                                        <table class="table table-hover progress-table text-center_ patient-table" id="">

                                            <thead>
                                                <tr>
                                                    <th><?php echo lang('name'); ?></th>
                                                    <th><?php echo lang('last_name'); ?></th>
                                                    <th class="text-center"><?php echo lang('birth_date'); ?></th>

                                                    <th class="text-center"><?php echo lang('lien_parente'); ?></th>
                                                    <?php if (!$lien_parente) { ?>
                                                        <th class="no-print"><?php echo lang('options'); ?></th><?php }  ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($mutuelles_relation as $key => $value) { ?>
                                                    <tr class="">
                                                        <td><?php echo $value->name; ?></td>
                                                        <td><?php echo $value->last_name; ?></td>
                                                        <td class="text-center"><?php echo str_replace('-', '/', $value->birthdate);  ?></td>
                                                        <td class="text-center"><?php echo $value->lien_parente;  ?></td>
                                                        <td class="no-print">
                                                            <button type="button" class="btn btn-info btn-xs btn_width editbuttonPatient" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $value->id; ?>" data-idparent="<?php echo $patient->id; ?>"> <i class="fa fa-edit"></i> </button>
                                                            <!--<a class="btn btn-info btn-xs btn_width delete_button" title="<?php echo lang('delete'); ?>" href="patient/deleteMutuelleRelation?id=<?php echo $value->id; ?>&patient_id=<?php echo $patient->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
                                                   -->
                                                        </td>
                                                    </tr>
                                                <?php }  ?>

                                                <?php if ($mutuelles_relationInit) {  ?>
                                                    <tr class="">
                                                        <td><?php echo $mutuelles_relationInit->name; ?></td>
                                                        <td><?php echo $mutuelles_relationInit->last_name; ?></td>
                                                        <td class="text-center"><?php echo str_replace('-', '/', $mutuelles_relationInit->birthdate);  ?></td>
                                                        <td class="text-center"><?php echo $lien_parente;  ?></td>
                                                        <?php if (!$lien_parente) { ?>
                                                            <td class="no-print">
                                                            </td> <?php }  ?>
                                                    </tr>
                                                <?php }   ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <a href="patient" name="submit" class="btn btn-info btn-secondary pull-left">Retour</a>
                    </div>
                </section>
            </div>
        </section>



    </section>
    <!-- page end-->
</section>
</section>
<!--main content end-->
<!--footer start-->

<!-- Add Imagerie medicale Material Modal-->
<div class="modal fade" id="myModalOrdonnance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> Ajouter une ordonnance médicale</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="patient/addPatientMaterialOrdonnance" class="clearfix row" method="post" enctype="multipart/form-data">
                    
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> Médecin prescripteur</label>
                        <input type="text" class="form-control" name="prescripteur" id="exampleInputEmail1" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('document'); ?></label>
                        <input type="file" name="img_url" required>
                        <small class="form-text text-muted">Format requis : gif / jpg / png / jpeg / pdf</small> </label>
                    </div>

                    <input type="hidden" name="patient" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>&type=ordonnance'>
                    <div class="form-group col-md-12">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<!-- Add Imagerie medicale Material Modal-->
<div class="modal fade" id="myModalImage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> Ajouter une image médicale</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="patient/addPatientMaterialImage" class="clearfix row" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> Centre d'Imagerie</label>
                        <input type="text" class="form-control" name="nomLabo" id="exampleInputEmail1" placeholder="Centre d'Imagerie" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> Médecin prescripteur</label>
                        <input type="text" class="form-control" name="prescripteur" id="exampleInputEmail1" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('document'); ?></label>
                        <input type="file" name="img_url" required>
                        <small class="form-text text-muted">Format requis : gif / jpg / png / jpeg / pdf</small> </label>
                    </div>

                    <input type="hidden" name="patient" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>&type=documents'>
                    <div class="form-group col-md-12">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<!-- Add Analyse Labo Material Modal-->
<div class="modal fade" id="myModalLabo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> Ajouter un résultat d'analyse</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="patient/addPatientMaterialLabo" class="clearfix row" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> Laboratoire d'analyse</label>
                        <input type="text" class="form-control" name="nomLabo" id="exampleInputEmail1" placeholder="Nom du Labo" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> Médecin prescripteur</label>
                        <input type="text" class="form-control" name="prescripteur" id="exampleInputEmail1" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('document'); ?></label>
                        <input type="file" name="img_url" required>
                        <small class="form-text text-muted">Format requis : gif / jpg / png / jpeg / pdf</small> </label>
                    </div>

                    <input type="hidden" name="patient" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>&type=lab'>
                    <div class="form-group col-md-12">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<!-- Add Patient Material Modal-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_new_document'); ?> </h4>
            </div>
            <div class="modal-body">
                <form role="form" action="patient/addPatientMaterial" class="clearfix row" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('description'); ?></label>
                        <input type="text" class="form-control" name="title" id="exampleInputEmail1" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('document'); ?></label>
                        <input type="file" name="img_url">
                    </div>

                    <input type="hidden" name="patient" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>&type=documents'>
                    <div class="form-group col-md-12">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Patient Modal-->


<!-- Add Medical History Modal-->
<div class="modal fade" id="addMedicalHistory" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 1400px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_case'); ?></h4>
            </div>
            <div class="modal-body">

                <form role="form" action="patient/addMedicalHistory" class="clearfix row" method="post" enctype="multipart/form-data">
                    <div class="col-sm-6">
                        <h4 class="text-green mb-4 text-center">Information du <?php echo lang('patient'); ?> </h4>
                        <input type="hidden" class="form-control" name="date_string" id="today" value='' placeholder="" readonly="" required="">
                        <center>

                            <div class="col-md-12 patientImgClass">
                            </div>
                            <h3 class="media-heading"><span><?php echo $patient->name; ?></span> <span><?php echo $patient->last_name; ?></span><small> <span><?php echo $patient->region; ?></span> </small></h3>
                            <p><strong> <?php echo lang('number'); ?>: </strong> <span><?php echo $patient->patient_id; ?></span> </p>
                            <span class="label label-primary"><i class='fa fa-user'></i> <span><?php echo $patient->sex; ?></span></span>

                            <span class="label label-info"> <i class='fa fa-phone'></i> <span><?php echo $patient->phone; ?></span></span>

                            <span class="label label-success"> <i class='fa fa-envelope'></i> <span><?php echo $patient->email; ?> </span> </span>

                        </center>
                        <hr>

                        <div class='row'>

                            <div class="form-group col-md-4">
                                <label><?php echo lang('age');  ?>/ An(s)</label>
                                <div><?php echo $patient->age; ?></div>
                                <input type="hidden" step="0.1" id="agePoidsTaille" value="<?php echo $patient->age; ?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                                <div><?php echo $patient->address; ?></div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"><?php echo lang('region'); ?></label>
                                <div><?php echo $patient->region; ?></div>
                            </div>
                        </div>
                        <hr>

                        <h4 class="text-green mb-4 text-center">Fiche de consultation</h4>

                        <div class="row">

                            <div class="col-md-6 payment pad_bot">
                                <label for="exampleInputEmail1">Service</label>
                                <select class="form-control m-bot15 js-example-basic-multiple template" id="template" name="specialite" value=''>
                                    <option value="">Selectionner un service</option>
                                    <?php foreach ($templates as $template) { ?>
                                        <option value="<?php echo $template->id; ?>"><?php echo $template->name; ?> </option>
                                    <?php } ?>
                                </select>

                            </div>
                            <input type="hidden" class="form-control" name="namePrestation" value='Consultation' placeholder="">
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 lab pad_bot">
                                <label for="exampleInputEmail1">Poids (kg)</label>
                                <input type="number" class="form-control pay_in " id="poids" name="poids" value='' step="0.1" placeholder="" min="0.3" max="150" onchange="poidsNormal(event)">
                                <div id="NormalPoids">
                                </div>
                            </div>

                            <div class="col-md-4 lab pad_bot">
                                <label for="exampleInputEmail1">Taille (cm)</label>
                                <input type="number" class="form-control pay_in " id="taille" name="taille" value='' placeholder="" min="44" max="230" onchange="tailleNormal(event)">
                                <div id="NormalTaille">
                                </div>
                            </div>
                            <div class="col-md-4 lab pad_bot">
                                <label for="exampleInputEmail1">Température (°C)</label>
                                <input type="number" class="form-control pay_in " step="0.1" id="temperature" name="temperature" value='' placeholder="" min="34.0" max="40.0">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 lab pad_bot">
                                <label for="exampleInputEmail1">Fréquence Respiratoire(mn)</label>
                                <input type="number" class="form-control pay_in " id="frequenceRespiratoire" name="frequenceRespiratoire" value='' placeholder="" min="10" max="40">
                            </div>
                            <div class="col-md-4 lab pad_bot">
                                <label for="exampleInputEmail1">Fréquence Cardiaque(bpm)</label>
                                <input type="number" class="form-control pay_in " id="frequenceCardiaque" name="frequenceCardiaque" value='' placeholder="" min="60" max="160">
                            </div>
                            <div class="col-md-4 lab pad_bot">
                                <label for="exampleInputEmail1">Saturation en O<sub>2</sub></label>
                                <input type="number" class="form-control pay_in " id="Saturationarterielle" name="Saturationarterielle" value='' placeholder="">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 lab pad_bot">
                                <label for="exampleInputEmail1">Glycémie Capillaire</label>
                                <input type="number" class="form-control pay_in " id="glycemyCapillaire" name="glycemyCapillaire" value='' placeholder="">
                            </div>
                            <div class="col-md-2 lab pad_bot">
                                <label for="exampleInputEmail1">Unité</label>
                                <select class="form-control m-bot15" id="glycemyCapillaireUnite" name="glycemyCapillaireUnite" value=''>
                                    <option value="g/l">(g/l)</option>
                                    <option value="mmlo/l">(mmlo/l)</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 lab pad_bot">
                                <label for="exampleHorairesOuverture">Tension Artérielle </label>
                            </div>
                            <div class="col-md-4 lab pad_bot">
                                <label for="exampleInputEmail1"><?php echo lang('systolique'); ?></label>
                                <input type="number" class="form-control pay_in " id="systolique" name="systolique" value='' placeholder="" onchange="donneTension(event)" onkeyup="tensionArterielles(event)" min="50" max="250">
                                <div id="systoleDonne"></div>
                                <div id="systoleDonnes"></div>
                            </div>
                            <div class="col-md-4 lab pad_bot">
                                <label for="exampleInputEmail1"><?php echo lang('diastolique'); ?></label>
                                <input type="number" class="form-control pay_in " id="diastolique" name="diastolique" value='' placeholder="" onchange="donneTension(event)" onkeyup="tensionArterielles(event)" min="30" max="200">
                                <div id="diastoleDonne"></div>
                                <div id="diastoleDonnes"></div>
                            </div>
                            <div class="col-md-4 lab pad_bot">
                                <label for="exampleInputEmail1"><?php echo lang('resultat'); ?></label>
                                <div id="tension"></div>
                                <input type="text" class="form-control pay_in " id="tensionArterielle" name="tensionArterielle" value='' placeholder="" readonly>
                                <input type="hidden" class="form-control pay_in" id="tensionName" name="tensionArterielle" value="">
                                <input type="hidden" class="form-control pay_in" id="hypertensionSystolique" name="hypertensionSystolique" value="">
                                <input type="hidden" class="form-control pay_in" id="hypertensionDiastolique" name="hypertensionDiastolique" value="">
                            </div>
                        </div>
                        <hr>
                        
                        
                        <div style="display:none">
                        <hr>
                        <div class="row">
                            <div class="col-md-12 lab pad_bot">
                                <label for="exampleHorairesOuverture">Urines </label>
                            </div>
                            <div class="col-md-6 lab pad_bot">
                                <label for="exampleInputEmail1">Sucre</label>
                                <select class="form-control m-bot15" name="sucre" value=''>
                                    <option value="Non renseigné">Non renseigné</option>
                                    <option value="positif">Positif</option>
                                    <option value="negatif">Négatif</option>
                                </select>
                            </div>
                            <div class="col-md-6 lab pad_bot">
                                <label for="exampleInputEmail1">Albumine</label>
                                <select class="form-control m-bot15" name="albumine" value=''>
                                    <option value="Non renseigné">Non renseigné</option>
                                    <option value="positif">Positif</option>
                                    <option value="negatif">Négatif</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 lab pad_bot">
                                <label for="exampleHorairesOuverture">Acuite Visuelle</label>
                            </div>
                            <br>
                            <div class="col-md-6">
                                <label for="exampleHorairesOuverture" style="float:left">Oeil droit</label>
                                <div class="col-md-3">
                                    <input type="number" class="form-control pay_in" id="oeildroit" name="oeildroit" value='' placeholder="" min="0" max="10">
                                </div>
                                <div class="col-md-1">/
                                </div>
                                <div class="col-md-3">
                                    <input type="number" class="form-control pay_in " id="oeildroitsur" name="oeildroitsur" value='10' placeholder="" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="exampleHorairesOuverture" style="float:left">Oeil gauche</label>
                                <div class="col-md-3">

                                    <input type="number" class="form-control pay_in" id="oeilgauche" name="oeilgauche" value='' placeholder="" min="0" max="10">
                                </div>
                                <div class="col-md-1">/
                                </div>
                                <div class="col-md-3">
                                    <input type="number" class="form-control pay_in " id="oeilgauchesur" name="oeilgauchesur" value='10' placeholder="" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 lab pad_bot">
                                <label for="exampleHorairesOuverture">Acuite Auditive</label>
                            </div>
                            </br>
                            <div class="col-md-6">
                                <label for="exampleHorairesOuverture" style="float:left">Oreille droite</label>
                                <div class="col-md-3">
                                    <input type="number" class="form-control pay_in" id="oreilledroite" name="oreilledroite" value='' placeholder="" min="0" max="10">
                                </div>
                                <div class="col-md-1">/
                                </div>
                                <div class="col-md-3">
                                    <input type="number" class="form-control pay_in " id="oreilledroitesur" name="oreilledroitesur" value='10' placeholder="" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="exampleHorairesOuverture" style="float:left">Oreille gauche</label>
                                <div class="col-md-3">

                                    <input type="number" class="form-control pay_in" id="oreillegauche" name="oreillegauche" value='' placeholder="" min="0" max="10">
                                </div>
                                <div class="col-md-1">/
                                </div>
                                <div class="col-md-3">
                                    <input type="number" class="form-control pay_in " id="oreillegauchesur" name="oreillegauchesur" value='10' placeholder="" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>

                        </div>            
                        
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="">
                                    <!-- <textarea hidden class="ckeditor form-control" id="template" value="" rows="10" minlength="3" required=""></textarea> -->
                                    <textarea class="ckeditor form-control" id="editorConsultation" name="description" name="report" value="" rows="10"><?php
                                                                                                                                                        if (!empty($setval)) {
                                                                                                                                                            echo set_value('report');
                                                                                                                                                        }
                                                                                                                                                        if (!empty($lab_single->report)) {
                                                                                                                                                            echo $lab_single->report;
                                                                                                                                                        }
                                                                                                                                                        ?>
                                </textarea>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
                        <input type="hidden" name="id" value=''>
                        <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>&type=consultation'>
                        <div class="row">
                            <div class="form-group col-md-8">
                                <button type="button" class="btn btn-info btn-secondary" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                                <button id="validationConsultation" type="submit" name="submit" class="btn btn-info submit_button">Valider</button>
                                <br />
                            </div>
                        </div>
                        <hr>
                        <div class="form-group col-md-12">
                            <div class="form-group col-md-12">
                                <button class="btn btn-info submit_button pull-left" data-toggle="modal" formaction="finance/addPaymentViewConsultation?patient=<?php echo $patient->id; ?>&type=consultation&page=consultation&idCons=1"><i class="fa fa-plus"></i> Demander Analyse</button>
                                <button class="btn btn-info submit_button pull-left" data-toggle="modal" href="#" style="margin-left:5px" formaction="finance/addPaymentViewConsultation?patient=<?php echo $patient->id; ?>&type=consultation&page=consultation&idCons=2"><i class="fa fa-plus"></i> Radio</button>
                                <a class="btn btn-info submit_button pull-left" data-toggle="modal" href="#addAppointmentModalConsultation" style="margin-left:5px"><i class="fa fa-plus"></i> Rendez-vous</a>
                                <a class="btn btn-info submit_button pull-left" data-toggle="modal" href="#" style="margin-left:5px" disabled><i class="fa fa-plus"></i> Ordonnance</a>

                            </div>
                            <!-- <div class="form-group col-md-4">

                                    <select class="form-control m-bot15" name="time_slot" id="" required="">
                                  <option value="09h-16h">--  Autres actions --</option>
                                    <option value="09h-16h">Enregistrer un Rendez-vous</option>
                                    <option value="09h-16h">Transferer chez un medecin</option>
                                    <option value="09h-16h">Demande Hospitalisation</option>
                                </select>
                                        </div> -->
                        </div>

                    </div>
                    <div class="col-sm-6" id="accordion-style-1">

                        <div class="row">
                            <div class="col-12">
                                <h4 class="text-green mb-4 text-center"><?php echo lang('history'); ?> des consultations</h4>
                            </div>
                            <div class="col-10 mx-auto">
                                <div class="accordion" id="listeConsultation">


                                </div>
                            </div>


                        </div>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Add Medical History Modal-->

<!-- Edit Medical History Modal-->


<?php
$current_user = $this->ion_auth->get_user_id();
$doctor_id = '';
if ($this->ion_auth->in_group(array('Doctor', 'adminmedecin'))) {
    $tru = $this->db->get_where('doctor', array('ion_user_id' => $current_user))->row();
    if (isset($tru)) {
        $doctor_id = $tru->id;
    }
}
?>

<div class="modal fade" id="myModalMutuelle" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('mutuelle'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="mutuelleEditForm" class="clearfix row" action="patient/updateMutuelleByJason" method="post" enctype="multipart/form-data">
                    <div class=" col-md-6">
                        <label><?php echo lang('nom_mutuelle'); ?></label>
                        <select class="form-control" id="nom_mutuelle" name="nom_mutuelle" required=""></select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('num_police'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium" name="num_police" id="num_police" value='' required="">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('charge_mutuelle'); ?> </label>
                        <input type="number" class="form-control form-control-inline input-medium" name="charge_mutuelle" id="charge_mutuelle" value='' min="1" max="100" required="">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('date_valid'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium afert_now" name="date_valid" id="date_validAssurance" value='' autocomplete="off" required="">
                    </div>
                    <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>'>

                    <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="mutuelle_id" value=''>

                    <div class="form-group col-md-12">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit" class="btn btn-info submit_button pull-right"><?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<!-- Add Appointment Modal-->
<div class="modal fade" id="addAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg"">
        <div class=" modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title"> <?php echo lang('add'); ?></h4>
        </div>
        <div class="modal-body">
            <form role="form" action="appointment/addNew" class="clearfix row" method="post" enctype="multipart/form-data">
                <div class="col-md-6 panel">
                    <label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label>
                    <input type="text" class="form-control m-bot15 " id="pos_select_" name="patient_name" value='<?php echo $patient->name . ' ' . $patient->last_name; ?>' readonly="" required="">

                    <input type="hidden" name="patient" value='<?php echo $patient->id; ?>'>
                </div>
                <div class="col-md-6 panel">
                    <label for="exampleInputEmail1"> <?php echo lang('service'); ?></label>
                    <select class="form-control m-bot15" id="idservice_add" name="service" required="">

                    </select>
                </div>

                <div class="col-md-12">
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium dateRDV" id="date_add" name="date" value='' placeholder="" autocomplete="off" required="">
                    </div>
                    <div class="col-md-6 panel">
                        <label class=""><?php echo lang('available_slots'); ?></label>
                        <select class="form-control m-bot15" name="time_slot" id="aslots_add">

                        </select>
                    </div>
                </div>
                <div class="col-md-6 panel">
                    <label for="exampleInputEmail1"> <?php echo lang('appointment_status'); ?> </label>
                    <select class="form-control m-bot15" name="status" value=''>

                        <?php if ($this->ion_auth->in_group(array('Doctor', 'adminmedecin'))) { ?>
                            <option value="Confirmed" <?php
                                                        ?>> <?php echo lang('confirmed'); ?> </option>
                        <?php } else if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Assistant', 'Nurse', 'Laboratorist', 'Biologiste'))) { ?>
                            <option value="Pending Confirmation" <?php
                                                                    ?>> <?php echo lang('pending_confirmation'); ?> </option>
                            <option value="Confirmed" <?php
                                                        ?>> <?php echo lang('confirmed'); ?> </option>
                            <option value="Treated" class="hide" <?php
                                                                    ?>> <?php echo lang('treated'); ?> </option>
                            <option value="Cancelled" class="hide" <?php ?>> <?php echo lang('cancelled'); ?> </option>
                        <?php } else { ?>
                            <option value="Requested" <?php ?>> <?php echo lang('requested'); ?> </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-md-12 panel">
                    <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                    <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                </div>




                <div class="col-md-5 panel">
                    <!-- <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br> -->
                </div>

                <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>'>

                <input type="hidden" name="request" value='<?php
                                                            if ($this->ion_auth->in_group(array('Patient'))) {
                                                                echo 'Yes';
                                                            }
                                                            ?>'>

                <div class="col-md-12 panel">
                    <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                    <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                </div>

            </form>

        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>
<!-- Add Appointment Modal-->


<!-- Add Appointment Modal Consultation-->
<div class="modal fade" id="addAppointmentModalConsultation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class=" modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="appointment/addNew" class="clearfix row" method="post" enctype="multipart/form-data">
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label>
                        <input type="text" class="form-control m-bot15 " id="pos_select_" name="patient_name" value='<?php echo $patient->name . ' ' . $patient->last_name; ?>' readonly="" required="">

                        <input type="hidden" name="patient" value='<?php echo $patient->id; ?>'>
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('service'); ?></label>
                        <select class="form-control m-bot15" id="idservice_addConsultation" name="service" required="">

                        </select>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-6 panel">
                            <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                            <input type="text" class="form-control form-control-inline input-medium dateRDV" id="date_add" name="date" value='' placeholder="" autocomplete="off" required="">
                        </div>
                        <div class="col-md-6 panel">
                            <label class=""><?php echo lang('available_slots'); ?></label>
                            <select class="form-control m-bot15" name="time_slot" id="aslots_add">

                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('appointment_status'); ?> </label>
                        <select class="form-control m-bot15" name="status" value=''>

                            <?php if ($this->ion_auth->in_group(array('Doctor', 'adminmedecin'))) { ?>
                                <option value="Confirmed" <?php
                                                            ?>> <?php echo lang('confirmed'); ?> </option>
                            <?php } else if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Assistant', 'Nurse', 'Laboratorist', 'Biologiste'))) { ?>
                                <option value="Pending Confirmation" <?php
                                                                        ?>> <?php echo lang('pending_confirmation'); ?> </option>
                                <option value="Confirmed" <?php
                                                            ?>> <?php echo lang('confirmed'); ?> </option>
                                <option value="Treated" class="hide" <?php
                                                                        ?>> <?php echo lang('treated'); ?> </option>
                                <option value="Cancelled" class="hide" <?php ?>> <?php echo lang('cancelled'); ?> </option>
                            <?php } else { ?>
                                <option value="Requested" <?php ?>> <?php echo lang('requested'); ?> </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-12 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                        <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                    </div>




                    <div class="col-md-5 panel">
                        <!-- <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br> -->
                    </div>

                    <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>&type=consultation'>

                    <input type="hidden" name="request" value='<?php
                                                                if ($this->ion_auth->in_group(array('Patient'))) {
                                                                    echo 'Yes';
                                                                }
                                                                ?>'>

                    <div class="col-md-12 panel">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Appointment Modal Consultation-->






<!-- Edit Event Modal-->
<div class="modal fade" id="editAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class=" modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('edit_appointment'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editAppointmentForm" class="clearfix row" action="appointment/addNew" method="post" enctype="multipart/form-data">
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label>
                        <input type="text" class="form-control m-bot15 " id="pos_select_" name="patient_name" value='' readonly="" required="">



                    </div>

                    <div class="col-md-4 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('service'); ?></label>
                        <input type="text" class="form-control m-bot15 " id="service_edit" name="service_name" value='' readonly="" required="">



                    </div>

                    <div class="col-md-12">
                        <div class="col-md-6 panel">
                            <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                            <input type="text" class="form-control  form-control-inline input-medium dateRDV" id="date_edit" name="date" id="exampleInputEmail1" value='' placeholder="" required="" autocomplete="off">
                        </div>
                        <div class="col-md-6 panel">
                            <label class=""><?php echo lang('available_slots'); ?></label>
                            <select class="form-control m-bot15" name="time_slot" id="aslots_edit" value=''>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('appointment_status'); ?> </label>
                        <select class="form-control m-bot15" name="status" value=''>


                            <option id="PendingConfirmation" value="Pending Confirmation" <?php
                                                                                            ?>> <?php echo lang('pending_confirmation'); ?> </option>
                            <option id="Confirmed" value="Confirmed" <?php
                                                                        ?>> <?php echo lang('confirmed'); ?> </option>
                            <option id="Treated" value="Treated" <?php
                                                                    ?>> <?php echo lang('treated'); ?> </option>




                            <option id="Cancelled" value="Cancelled" <?php
                                                                        ?>> <?php echo lang('cancelled'); ?> </option>
                        </select>
                    </div>

                    <div class="col-md-12 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                        <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                    </div>




                    <div class="col-md-6 panel">
                        <!-- <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br>-->
                    </div>



                    <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>'>>
                    <input type="hidden" name="id" id="appointment_id" value=''>

                    <input type="hidden" name="patient" value=''>
                    <input type="hidden" name="service" value=''>
                    <div class="col-md-12 panel">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>

                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Event Modal-->




<!-- Edit Patient Modal-->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('edit_patient'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" id="editPatientForm" action="patient/addNew" class="clearfix" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="" required="" min="2" max="100">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('last_name'); ?></label>
                        <input type="text" class="form-control" name="last_name" id="exampleInputlast_name" value='' placeholder="" required="" min="2" max="100">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('sex'); ?></label>
                        <select class="form-control" name="sex" required="">
                            <option value=""></option>

                            <option value="Masculin" <?php
                                                        if (!empty($patient->sex)) {
                                                            if ($patient->sex == 'Masculin') {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?>> <?php echo lang('male'); ?> </option>
                            <option value="Feminin" <?php

                                                    if (!empty($patient->sex)) {
                                                        if ($patient->sex == 'Feminin') {
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?>> <?php echo lang('female'); ?></option>
                            <!--<option value="Autres" <?php
                                                        if (!empty($patient->sex)) {
                                                            if ($patient->sex == 'Autres') {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?> >  <?php echo lang('others'); ?></option>-->
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('birth_date'); ?></label>
                        <input class="form-control form-control-inline input-medium before_now" type="text" id="birthdate2" name="birthdate" value="" placeholder="" autocomplete="off" onchange="recuperationEditAge()">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Age</label>
                        <input type="number" class="form-control" name="age" id="age" value="" placeholder="" min="0" max="100">
                        <input id="datejour" type="hidden" name="date" value='<?php echo date('d/m/Y'); ?>' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('phoneNumber'); ?></label>
                        <input type="text" class="form-control" name="mobNo6" id="mobNo6" value="" placeholder="" onkeyup="recuperationPatientEdit(event)" autocompleted="off">
                        <input type="hidden" class="form-control" name="phone" id="phone6" value='' placeholder="" required="">
                        <input type="hidden" class="form-control" name="urlModal" id="urlModal2" value='' placeholder="" required="">
                        <code id="phoneID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('email'); ?></label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="" min="2" max="100">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                        <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='' placeholder="" min="2" max="500">
                    </div>
                    <div class="form-group col-md-6">
                        <label><?php echo lang('region'); ?></label>
                        <select class="form-control" name="region">
                            <option value=""></option>
                            <?php foreach ($regions as $value => $region) { ?>
                                <option value="<?php echo $region; ?>" <?php
                                                                        if (!empty($patient->region)) {
                                                                            if ($region == $patient->region) {
                                                                                echo 'selected';
                                                                            }
                                                                        }
                                                                        ?>> <?php echo $region; ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group  col-md-12 ">
                        <input type="checkbox" name="choice_pos_matricule7" id="customCheck7" value="0"> <?php echo lang('choice_pos_matricule') ?><br>
                    </div>
                    <div class="pos_matricule" id="pos_matricule7" style="display: none">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo lang('blood_group'); ?></label>
                            <select class="form-control " name="bloodgroup">
                                <option value=""></option>
                                <?php foreach ($groups as $group) { ?>
                                    <option value="<?php echo $group->group; ?>" <?php
                                                                                    if (!empty($patient->bloodgroup)) {
                                                                                        if ($group->group == $patient->bloodgroup) {
                                                                                            echo 'selected';
                                                                                        }
                                                                                    }
                                                                                    ?>> <?php echo $group->group; ?> </option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="form-group col-md-6">
                            <label><?php echo lang('birth_position'); ?></label>
                            <input class="form-control" type="text" id="birth_position2" name="birth_position" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo lang('matricule'); ?></label>
                            <input type="text" class="form-control" name="matricule" id="matricule" value='' placeholder="" min="2" max="100">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo lang('grade'); ?></label>
                            <input type="text" class="form-control" name="grade" id="grade" value='' placeholder="" min="2" max="100">
                        </div>

                        <div class="form-group col-md-6">
                            <label><?php echo lang('nom_contact'); ?></label>
                            <input type="text" class="form-control" type="text" name="nom_contact" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label><?php echo lang('phone_contact'); ?></label>
                            <input type="text" class="form-control" name="contactEdit" id="contactEdit" value="" onkeyup="editContact(event)" placeholder="" autocompleted="off">
                            <input class="form-control" type="hidden" id="phone_contact2" name="phone_contact" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label><?php echo lang('religion'); ?></label>
                            <select class="form-control" name="religion">
                                <option value=""></option>
                                <?php foreach ($religions as $value => $religion) { ?>
                                    <option value="<?php echo $religion; ?>" <?php
                                                                                if (!empty($patient->religion)) {
                                                                                    if ($value == $patient->region) {
                                                                                        echo 'selected';
                                                                                    }
                                                                                }
                                                                                ?>> <?php echo $religion; ?> </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group last col-md-6">
                            <label class="control-label">Image</label>
                            <div class="">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new" name="img" style="max-width: 200px; max-height: 150px;">
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Choisir un fichier</span>
                                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Modifier</span>
                                            <input type="file" class="default" name="img_url" />
                                        </span>
                                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Supprimer</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>'>

                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="p_id" value='<?php
                                                            if (!empty($patient->patient_id)) {
                                                                echo $patient->patient_id;
                                                            }
                                                            ?>'>







                    <section class="col-md-12">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit" id="validationPatientEdit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                    </section>

                </form>

            </div>
        </div>
    </div>
</div>
<!-- Edit Patient Modal-->



<!-- Add Patient Modal-->
<div class="modal fade" id="myModalPatient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title"> <?php echo lang('register_new_patient'); ?></h4>

            </div>
            <div class="modal-body row">
                <form role="form" action="patient/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>

                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('lien_parente'); ?></label>
                        <select class="form-control" name="lien_parente">
                            <option value="Pere"> <?php echo lang("pere"); ?> </option>
                            <option value="Mere"> <?php echo lang("mere"); ?> </option>
                            <option value="Enfant"> <?php echo lang("enfant"); ?> </option>
                            <option value="Autres"> <?php echo lang("others"); ?> </option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="" required="" min="2" max="100">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('last_name'); ?></label>
                        <input type="text" class="form-control" name="last_name" id="exampleInputlast_name" value='' placeholder="" required="" min="2" max="100">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('sex'); ?></label>
                        <select class="form-control" name="sex" required="">
                            <option value=""></option>

                            <option value="Masculin" <?php
                                                        if (!empty($patient->sex)) {
                                                            if ($patient->sex == 'Masculin') {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?>> <?php echo lang('male'); ?> </option>
                            <option value="Feminin" <?php
                                                    if (!empty($patient->sex)) {
                                                        if ($patient->sex == 'Feminin') {
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?>> <?php echo lang('female'); ?></option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('birth_date'); ?></label>
                        <input id="birthdates" class="form-control form-control-inline input-medium before_now" type="text" id="birthdate" name="birthdate" value="" placeholder="" autocomplete="off" onchange="recuperationEdit2()">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Age</label>
                        <input type="number" class="form-control" name="age" id="age2" value="" placeholder="" min="0" max="100">
                        <input id="datejour2" type="hidden" name="date" value='<?php echo date('d/m/Y'); ?>' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('phoneNumber'); ?></label>
                        <input type="text" class="form-control" name="mobNo4" id="mobNo4phoneNumber" value="" placeholder="" onkeyup="recuperationNumeroChargephoneNumber(event,'mobNo4phoneNumber','phone4phoneNumber','required')" required="" autocompleted="off" min="12">
                        <input type="hidden" class="form-control" name="phone" id="phone4phoneNumber" value='' placeholder="" required="">
                        <input type="hidden" class="form-control" name="urlModal" id="urlModal_phoneNumber" value='' placeholder="" required="">
                        <code id="phoneID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('email'); ?></label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="" min="2" max="100">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                        <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='' placeholder="" min="2" max="500">
                    </div>
                    <div class="form-group col-md-6">
                        <label><?php echo lang('region'); ?></label>
                        <select class="form-control" name="region">
                            <option value=""></option>
                            <?php foreach ($regions as $value => $region) { ?>
                                <option value="<?php echo $region; ?>" <?php
                                                                        if (!empty($patient->region)) {
                                                                            if ($region == $patient->region) {
                                                                                echo 'selected';
                                                                            }
                                                                        }
                                                                        ?>> <?php echo $region; ?> </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group  col-md-12 ">
                        <input type="checkbox" name="choice_pos_matricule" id="customCheck" value="0"> <?php echo lang('choice_pos_matricule') ?><br>
                    </div>
                    <div class="pos_matricule" id="pos_matricule" style="display: none">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo lang('blood_group'); ?></label>
                            <select class="form-control " name="bloodgroup">
                                <option value=""></option>
                                <?php foreach ($groups as $group) { ?>
                                    <option value="<?php echo $group->group; ?>" <?php
                                                                                    if (!empty($patient->bloodgroup)) {
                                                                                        if ($group->group == $patient->bloodgroup) {
                                                                                            echo 'selected';
                                                                                        }
                                                                                    }
                                                                                    ?>> <?php echo $group->group; ?> </option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="form-group col-md-6">
                            <label><?php echo lang('birth_position'); ?></label>
                            <input class="form-control" type="text" name="birth_position" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo lang('matricule'); ?></label>
                            <input type="text" class="form-control" name="matricule" id="matricule" value='' placeholder="" min="2" max="100">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo lang('grade'); ?></label>
                            <input type="text" class="form-control" name="grade" id="grade" value='' placeholder="" min="2" max="100">
                        </div>

                        <div class="form-group col-md-6">
                            <label><?php echo lang('nom_contact'); ?></label>
                            <input class="form-control" type="text" name="nom_contact" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label><?php echo lang('phone_contact'); ?></label>
                            <input type="text" class="form-control" name="mobNo3" id="mobNo4phone_contact" value="" placeholder="" onkeyup="recuperationNumeroChargephoneNumber(event,'mobNo4phone_contact','phone4phone_contact')" autocompleted="off">
                            <input type="hidden" class="form-control" name="nom_contact" id="phone4phone_contact" value='' placeholder="">
                            <code id="phoneID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>
                        </div>
                        <div class="form-group col-md-6">
                            <label><?php echo lang('religion'); ?></label>
                            <select class="form-control" name="religion">
                                <option value=""></option>
                                <?php foreach ($religions as $value => $religion) { ?>
                                    <option value="<?php echo $religion; ?>" <?php
                                                                                if (!empty($patient->religion)) {
                                                                                    if ($value == $patient->region) {
                                                                                        echo 'selected';
                                                                                    }
                                                                                }
                                                                                ?>> <?php echo $religion; ?> </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group last col-md-6">
                            <label class="control-label">Image</label>
                            <div class="">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                        <img src="//www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Choisir un fichier</span>
                                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Modifier</span>
                                            <input type="file" class="default" name="img_url" />
                                        </span>
                                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Supprimer</a>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                    <!--   <div class="form-group  col-md-12 ">
                        <input type="checkbox" name="choice_pos_matricule5" id="customCheck5" value="0"> <?php echo lang('assurance') ?><br>
                    </div>
                    <div class="pos_matricule5" id="pos_matricule5" style="display: none">
                        <div class=" col-md-12">
                            <div class=" col-md-6">
                                <label><?php echo lang('nom_mutuelle'); ?></label>
                                <select class="form-control" id="nom_mutuelle" name="nom_mutuelle"></select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('num_police'); ?></label>
                                <input type="text" class="form-control form-control-inline input-medium" name="num_police" id="num_police" value=''>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('charge_mutuelle'); ?> </label>
                                <input type="number" class="form-control form-control-inline input-medium" name="charge_mutuelle" id="charge_mutuelle_patient" value='' min="1" max="100">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('date_valid'); ?></label>
                                <input type="text" class="form-control form-control-inline input-medium afert_now" name="date_valid" id="date_valid" value='' autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br>
                        </div>
                    </div>-->
                    <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>&type=mutuellerelation'>
                    <section class="col-md-12">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                    </section>

                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>

<!-- Add Patient Modal-->
<div class="modal fade" id="myModalPatientEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title"> <?php echo lang('register_new_patient'); ?></h4>

            </div>
            <div class="modal-body row">
                <form id="editPatientForm" role="form" action="patient/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="id" value=''>

                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('lien_parente'); ?></label>
                        <select class="form-control" name="lien_parente">
                            <option value="Pere"> <?php echo lang("pere"); ?> </option>
                            <option value="Mere"> <?php echo lang("mere"); ?> </option>
                            <option value="Enfant"> <?php echo lang("enfant"); ?> </option>
                            <option value="Autres"> <?php echo lang("others"); ?> </option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='' placeholder="" required="" min="2" max="100">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('last_name'); ?></label>
                        <input type="text" class="form-control" name="last_name" id="exampleInputlast_name" value='' placeholder="" required="" min="2" max="100">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('sex'); ?></label>
                        <select class="form-control" name="sex" required="">
                            <option value=""></option>

                            <option value="Masculin" <?php
                                                        if (!empty($patient->sex)) {
                                                            if ($patient->sex == 'Masculin') {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?>> <?php echo lang('male'); ?> </option>
                            <option value="Feminin" <?php
                                                    if (!empty($patient->sex)) {
                                                        if ($patient->sex == 'Feminin') {
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?>> <?php echo lang('female'); ?></option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('birth_date'); ?></label>
                        <input type="text" class="form-control form-control-inline" name="birthdate" id="birthdates2" value='' autocomplete="off" required="" onchange="recuperationAge2()">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Age</label>
                        <input type="number" class="form-control" name="age" id="age3" value="" placeholder="" min="0" max="100">
                        <input id="datejour3" type="hidden" name="date" value='<?php echo date('d/m/Y'); ?>' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('phoneNumber'); ?></label>
                        <input type="text" class="form-control" name="mobNo4" id="mobNo4" value="" placeholder="" autocompleted="off">
                        <input type="hidden" class="form-control" name="phone" id="phone4" value='' placeholder="" required="">
                        <input type="hidden" class="form-control" name="urlModal" id="urlModal" value='' placeholder="" required="">
                        <code id="phoneID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('email'); ?></label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="" min="2" max="100">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                        <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='' placeholder="" min="2" max="500">
                    </div>
                    <div class="form-group col-md-6">
                        <label><?php echo lang('region'); ?></label>
                        <select class="form-control" name="region">
                            <option value=""></option>
                            <?php foreach ($regions as $value => $region) { ?>
                                <option value="<?php echo $region; ?>" <?php
                                                                        if (!empty($patient->region)) {
                                                                            if ($region == $patient->region) {
                                                                                echo 'selected';
                                                                            }
                                                                        }
                                                                        ?>> <?php echo $region; ?> </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group  col-md-12 ">
                        <input type="checkbox" name="choice_pos_matricule" id="customCheckEditMutuelle" value="0"> <?php echo lang('choice_pos_matricule') ?><br>
                    </div>
                    <div class="pos_matricule" id="pos_matriculeEditMutuelle" style="display: none">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo lang('blood_group'); ?></label>
                            <select class="form-control " name="bloodgroup">
                                <option value=""></option>
                                <?php foreach ($groups as $group) { ?>
                                    <option value="<?php echo $group->group; ?>" <?php
                                                                                    if (!empty($patient->bloodgroup)) {
                                                                                        if ($group->group == $patient->bloodgroup) {
                                                                                            echo 'selected';
                                                                                        }
                                                                                    }
                                                                                    ?>> <?php echo $group->group; ?> </option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="form-group col-md-6">
                            <label><?php echo lang('birth_position'); ?></label>
                            <input class="form-control" type="text" name="birth_position" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo lang('matricule'); ?></label>
                            <input type="text" class="form-control" name="matricule" id="matricule" value='' placeholder="" min="2" max="100">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo lang('grade'); ?></label>
                            <input type="text" class="form-control" name="grade" id="grade" value='' placeholder="" min="2" max="100">
                        </div>

                        <div class="form-group col-md-6">
                            <label><?php echo lang('nom_contact'); ?></label>
                            <input class="form-control" type="text" name="nom_contact" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label><?php echo lang('phone_contact'); ?></label>
                            <input type="text" class="form-control" name="mobNo3" id="mobNo5" value="" placeholder="" onkeyup="recuperationNumeroChargephoneNumber(event,'mobNo5','phonecontact2','required')" autocompleted="off">
                            <input type="hidden" class="form-control" name="phone_contact" id="phonecontact2" value='' placeholder="">
                            <code id="phoneID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>
                        </div>
                        <div class="form-group col-md-6">
                            <label><?php echo lang('religion'); ?></label>
                            <select class="form-control" name="religion">
                                <option value=""></option>
                                <?php foreach ($religions as $value => $religion) { ?>
                                    <option value="<?php echo $religion; ?>" <?php
                                                                                if (!empty($patient->religion)) {
                                                                                    if ($value == $patient->region) {
                                                                                        echo 'selected';
                                                                                    }
                                                                                }
                                                                                ?>> <?php echo $religion; ?> </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group last col-md-6">
                            <label class="control-label">Image</label>
                            <div class="">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                        <img src="//www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Choisir un fichier</span>
                                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Modifier</span>
                                            <input type="file" class="default" name="img_url" />
                                        </span>
                                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Supprimer</a>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                    <!--   <div class="form-group  col-md-12 ">
                        <input type="checkbox" name="choice_pos_matricule5" id="customCheck5" value="0"> <?php echo lang('assurance') ?><br>
                    </div>
                    <div class="pos_matricule5" id="pos_matricule5" style="display: none">
                        <div class=" col-md-12">
                            <div class=" col-md-6">
                                <label><?php echo lang('nom_mutuelle'); ?></label>
                                <select class="form-control" id="nom_mutuelle" name="nom_mutuelle"></select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('num_police'); ?></label>
                                <input type="text" class="form-control form-control-inline input-medium" name="num_police" id="num_police" value=''>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('charge_mutuelle'); ?> </label>
                                <input type="number" class="form-control form-control-inline input-medium" name="charge_mutuelle" id="charge_mutuelle_patient" value='' min="1" max="100">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('date_valid'); ?></label>
                                <input type="text" class="form-control form-control-inline input-medium afert_now" name="date_valid" id="date_valid" value='' autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br>
                        </div>
                    </div>-->
                    <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>&type=mutuellerelation'>
                    <section class="col-md-12">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                    </section>

                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>

<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header no-print">
                <button type="button" class="close no-print" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('invoice'); ?></h4>
            </div>
            <div class="modal-body clearfix">
                <div class="panel panel-primary">
                    <!--<div class="panel-heading navyblue"> INVOICE</div>-->
                    <div class="panel" id="invoice" style="font-size: 10px;">
                        <div class="row invoice-list">
                            <div class="text-center corporate-id top_title">
                                <img alt="" src="<?php echo $this->settings_model->getSettings()->logo; ?>" width="200" height="100">
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
                            <div class="col-lg-4 col-sm-4" style="float: left;">
                                <h4><?php echo lang('payment_to'); ?>:</h4>
                                <p>
                                    <?php echo $settings->title; ?> <br>
                                    <?php echo $settings->address; ?><br>
                                    Tel: <?php echo $settings->phone; ?>
                                </p>
                            </div>
                            <?php if (!empty($payment->patient)) { ?>
                                <div class="col-lg-4 col-sm-4" style="float: left;">
                                    <h4><?php echo lang('bill_to'); ?>:</h4>
                                    <p>
                                        <?php
                                        if (!empty($patient->name)) {
                                            echo $patient->name . ' ' . $patient->last_name .  ' <br>';
                                        }
                                        if (!empty($patient->address)) {
                                            echo $patient->address . ' <br>';
                                        }
                                        if (!empty($patient->phone)) {
                                            echo $patient->phone . ' <br>';
                                        }
                                        ?>
                                    </p>
                                </div>
                            <?php } ?>
                            <div class="col-lg-4 col-sm-4" style="float: left;">
                                <h4><?php echo lang('invoice_info'); ?></h4>
                                <ul class="unstyled">
                                    <li>Date : <?php echo date('m/d/Y'); ?></li>
                                </ul>
                            </div>
                            <br>
                        </div>



                        <table class="table table-hover progress-table text-center_ patient-table" id="editable-samples">

                            <thead>
                                <tr>
                                    <th class=""><?php echo lang('date'); ?></th>
                                    <th class=""><?php echo lang('invoice'); ?> #</th>
                                    <th class=""><?php echo lang('bill_amount'); ?></th>
                                    <th class=""><?php echo lang('deposit'); ?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <style>
                                    .img_url {
                                        height: 20px;
                                        width: 20px;
                                        background-size: contain;
                                        max-height: 20px;
                                        border-radius: 100px;
                                    }

                                    .option_th {
                                        width: 33%;
                                    }
                                </style>

                                <?php
                                $dates = array();
                                $datess = array();
                                foreach ($payments as $payment) {
                                    $dates[] = $payment->date;
                                }
                                foreach ($deposits as $deposit) {
                                    $datess[] = $deposit->date;
                                }
                                $dat = array_merge($dates, $datess);
                                $dattt = array_unique($dat);
                                asort($dattt);

                                $total_pur = array();

                                $total_p = array();
                                ?>

                                <?php
                                foreach ($dattt as $key => $value) {
                                    foreach ($payments as $payment) {
                                        if ($payment->date == $value) {
                                ?>
                                            <tr class="">
                                                <td><?php echo date('d/m/Y', $payment->date); ?></td>
                                                <td> <?php echo $payment->id; ?></td>
                                                <td><?php echo $settings->currency; ?> <?php echo $payment->gross_total; ?></td>
                                                <td><?php
                                                    if (!empty($payment->amount_received)) {
                                                        echo $settings->currency;
                                                    }
                                                    ?> <?php echo $payment->amount_received; ?>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <?php
                                    foreach ($deposits as $deposit) {
                                        if ($deposit->date == $value) {
                                            if (!empty($deposit->deposited_amount) && empty($deposit->amount_received_id)) {
                                    ?>

                                                <tr class="">
                                                    <td><?php echo date('d/m/Y', $deposit->date); ?></td>
                                                    <td><?php echo $deposit->payment_id; ?></td>
                                                    <td></td>
                                                    <td><?php echo $settings->currency; ?> <?php echo $deposit->deposited_amount; ?></td>
                                                </tr>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php
                        $total_bill = array();
                        foreach ($payments as $payment) {
                            $total_bill[] = $payment->gross_total;
                        }
                        if (!empty($total_bill)) {
                            $total_bill = array_sum($total_bill);
                        } else {
                            $total_bill = 0;
                        }
                        ?>
                        <?php echo $settings->currency; ?>
                        <?php
                        $total_deposit = array();
                        foreach ($deposits as $deposit) {
                            $total_deposit[] = $deposit->deposited_amount;
                        }
                        echo array_sum($total_deposit);
                        ?>
                        <div class="row">
                            <div class="col-lg-8 invoice-block pull-right total_section">
                                <ul class="unstyled amounts">
                                    <li><strong><?php echo lang('grand_total'); ?> : </strong><?php echo $settings->currency; ?> <?php echo $total_payable_bill = $total_bill; ?></li>
                                    <li><strong><?php echo lang('amount_received'); ?> : </strong><?php echo $settings->currency; ?> <?php echo array_sum($total_deposit); ?></li>
                                    <li><strong><?php echo lang('amount_to_be_paid'); ?> : </strong><?php echo $settings->currency; ?> <?php echo $total_payable_bill - array_sum($total_deposit); ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <div class="panel col-md-12 no-print">
                        <a class="btn btn-info invoice_button" onclick="javascript:window.print();"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
                    </div>

                    <div class="text-center invoice-btn clearfix">
                        <a class="btn btn-info btn-sm detailsbutton pull-left download" id="download"><i class="fa fa-download"></i> <?php echo lang('download'); ?> </a>
                    </div>

                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<div class="modal fade" id="myModaldeposit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_deposit'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="finance/checkDepot" id="deposit-checkDepot" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('invoice'); ?></label>
                        <select class="form-control m-bot15 js-example-basic-single" id="" name="payment_id" value=''>
                            <option value="">Select .....</option>
                            <?php foreach ($payments as $payment) {
                                if ($payment->gross_total >=  $payment->amount_received) {
                            ?>
                                    <option value="<?php echo $payment->id; ?>" <?php
                                                                                if (!empty($deposit->payment_id)) {
                                                                                    if ($deposit->payment_id == $payment->id) {
                                                                                        echo 'selected';
                                                                                    }
                                                                                }
                                                                                ?>><?php echo $payment->id; ?> </option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('deposit_amount'); ?></label>
                        <input type="text" class="form-control" name="deposited_amount" id="exampleInputEmail1" value='' placeholder="">
                    </div>



                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="patient" value='<?php echo $patient->id; ?>&type=payment'>
                    <div class="form-group cashsubmit payment  right-six col-md-12">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                    <div class="form-group cardsubmit  right-six col-md-12 hidden">
                        <button type="submit" name="pay_now" id="submit-btn" class="btn btn-info row pull-right" <?php if ($settings->payment_gateway == 'Stripe') {
                                                                                                                    ?>onClick="stripePay(event);" <?php }
                                                                                                                                                    ?>> <?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="myModaldeposit2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_deposit'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="finance/checkDepot" id="deposit-form" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('invoice'); ?></label>
                        <select class="form-control m-bot15" id="paymentid" name="paymentid">

                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo lang('reste_a_payer'); ?> : <span id="reste"></span> <?php echo $settings->currency; ?></label>
                        <input type="hidden" name="patient" value='<?php echo $patient->id; ?>'>
                        <input type="hidden" name="name" value='<?php echo $patient->name; ?>'>
                        <input type="hidden" name="lastname" value='<?php echo $patient->last_name; ?>'>
                        <input type="hidden" name="patientId" value='<?php echo $patient->patient_id; ?>'>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('deposit_amount'); ?></label>
                        <input type="text" class="form-control money" name="deposited" id="deposited" onkeyup="recuperationDepot(event)" value='' placeholder="">
                        <code id="errorDepotCash" class="flash_message" style="display:none">Le montant est superieur au montant dû</code>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="deposited_amount" id="deposited_amount" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <div class="payment_label pull-left">
                            <label for="exampleInputEmail1"><?php echo lang('deposit_type'); ?></label>
                        </div>
                        <div class="">
                            <select class="form-control m-bot15 js-example-basic-single selecttype" id="selecttype" name="deposit_type" value=''>
                                <?php if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Accountant', 'Receptionist', 'Assistant'))) { ?>
                                    <option value="Cash"> <?php echo lang('cash'); ?> </option>
                                    <option value="OrangeMoney"> <?php echo lang('orange_money'); ?> </option>
                                    <option value="zuulupay" disabled=""> <?php echo lang('zuulupay'); ?> </option>
                                    <option value="" disabled=""> <?php echo lang('carte_bancaire'); ?> </option>
                                    <option value="" disabled=""> <?php echo lang('demande'); ?> </option>
                                <?php } ?>

                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="patient" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>&type=payment'>
                    <div class="form-group cashsubmit payment  right-six col-md-12">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit2" id="subCash" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>
                <div id="bouttonOrangeMoney" style="display: none;">
                    <div class="form-group cashsubmit payment  right-six col-md-12">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit2" id="interfaceOrangemoney" class="btn btn-info row pull-right"><?php echo lang('submit_continuer'); ?></button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('details_medical'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="medical_historyEditForm" class="clearfix row" action="patient/addMedicalHistory" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <center>

                            <div class="col-md-12 patientImgClass">
                            </div>
                            <h3 class="media-heading"><span class="nameClass"></span> <span class="lastnameClass"></span><small> <span class="regionClass"></span> </small></h3>
                            <p><strong> <?php echo lang('number'); ?>: </strong> <span class="patientIdClass"></span> </p>
                            <span class="label label-primary"><i class='fa fa-user'></i> <span class="genderClass"></span></span>

                            <span class="label label-info"> <i class='fa fa-phone'></i> <span class="phoneClass"></span></span>

                            <span class="label label-success"> <i class='fa fa-envelope'></i> <span class="emailClass"> </span> </span>

                        </center>
                        <hr>
                        <div class='row'>
                            <div class="form-group col-md-4">
                                <label><?php echo lang('age');  ?>/ An(s)</label>
                                <div class="ageClass"></div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                                <div class="addressClass"></div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"><?php echo lang('region'); ?></label>
                                <div class="regionClass"></div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class="form-group col-md-6 pull-left">
                                <span class="label label-default"><i class='fas fa-calendar-alt'></i> <span class="dateConsultationClass"></span></span>

                            </div>
                            <div class="form-group col-md-6 pull-right">
                                <span class="label label-default"><i class='fas fa-edit'></i> <span class="prescriptClass"></span></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Service / Prestation</label>
                                <div class="specialitePrestation"></div>
                            </div>

                        </div>

                        <hr>
                        <div class='row'>
                            <div class="form-group col-md-4">
                                <label>Poids (kg)</label>
                                <div class="poidsClass"></div>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Taille (cm)</label>
                                <div class="tailleClass"></div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Température (°C)</label>
                                <div class="temperatureClass"></div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class="form-group col-md-3">
                                <label>Fréquence Respiratoire (mn)</label>
                                <div class="frequenceRespiratoire"></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Fréquence Cardiaque (bpm)</label>
                                <div class="frequenceCardiaque"></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Glycémie Capillaire </label>
                                <div class="glycemy"></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Saturation en O<sub>2</sub></label>
                                <div class="Saturationarterielle"></div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class="col-md-12 lab pad_bot">
                                <label for="exampleHorairesOuverture">Tension Artérielle </label>
                            </div>
                            <div class="form-group col-md-4">
                                <label><?php echo lang('systolique'); ?></label>
                                <div class="systole"></div>
                            </div>
                            <div class="form-group col-md-4">
                                <label><?php echo lang('diastolique'); ?></label>
                                <div class="diastole"></div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Résultat</label>
                                <div class="tensionArterielle"></div>
                            </div>
                        </div>
                        <div style="display:none">
                        <hr>
                        <div class='row'>
                            <div class="col-md-12 lab pad_bot">
                                <label for="exampleHorairesOuverture">Urines </label>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Sucre</label>
                                <div class="sucre"></div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Albumine</label>
                                <div class="albumine"></div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class="col-md-12 lab pad_bot">
                                <label for="exampleHorairesOuverture">Acuite Visuelle </label>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Oeil droit</label>
                                <div class="oeildroit"></div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Oeil gauche</label>
                                <div class="oeilgauche"></div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class="col-md-12 lab pad_bot">
                                <label for="exampleHorairesOuverture">Acuite Auditive </label>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Oreille droite</label>
                                <div class="oreilledroite"></div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Oreille gauche</label>
                                <div class="oreillegauche"></div>
                            </div>
                        </div>

                        </div>
                        
                    </div>
                    <hr>
                    <div class="form-group col-md-12">
                        <label class=""><?php echo lang('observation_medical'); ?></label>
                        <div class="">
                            <textarea class="ckeditor form-control editor" id="editor" name="description" value="" rows="4" readonly></textarea>
                        </div>
                    </div>
                    <!-- <div class="col-md-12 invoice_footer">
                        <div class="row pull-left">
                            <strong><?php echo lang('effectuer_par'); ?> : </strong>
                        </div><br>
                        <div class="row pull-left" id="effectuer_par">


                        </div>
                    </div> -->
                    <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="id" value=''>
                    <!-- <div class="panel col-md-12 no-print">
                        <a class="btn btn-info invoice_button pull-right" onclick="javascript:window.print();"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
                    </div> -->
                    <div class="form-group modal-header">
                        <button type="button" class="btn btn-info btn-secondary pull-right" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<input type="hidden" name="customCheck2" id="customCheck2" value=''> <input type="hidden" name="customCheckedit" id="customCheckedit" value=''>

<div class="modal fade" id="datalabModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog payment-content">
        <div class="modal-content" id="datalab">

        </div>
    </div>
</div>
<input id="logo2" type="hidden" value="">
<input id="logoBase64" type="hidden" value="">
<label hidden id="descriptionConfirmation"></label>
<input id="users" type="hidden" value="<?php echo $this->ion_auth->user()->row()->first_name . ' ' . $this->ion_auth->user()->row()->last_name; ?>">
<input id="datejour" type="hidden" name="date" value='<?php echo date('d/m/Y'); ?>' placeholder="">
<input id="datejourfooter" type="hidden" name="date" value='<?php echo date('d/m/Y H:i'); ?>' placeholder="">
<style>
    thead {
        background: #f1f1f1;
        border-bottom: 1px solid #ddd;
    }

    .btn_width {
        margin-bottom: 20px;
    }

    .tab-content {
        padding: 20px 0px;
    }

    .cke_editable {
        min-height: 1000px;
    }
</style>


<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/appointment.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var queryString = window.location.search;
        var urlParams = new URLSearchParams(queryString);
        var type = urlParams.get('type');
        var poids = urlParams.get('poids');
        var taille = urlParams.get('taille');
        var spec = urlParams.get('spec');
        var temp = urlParams.get('temp');
        var frRes = urlParams.get('frRes');
        var frCar = urlParams.get('frCar');
        var glyCap = urlParams.get('glyCap');
        var syst = urlParams.get('syst');
        var diast = urlParams.get('diast');
        var sat = urlParams.get('sat');
        var idpatientConsultation = urlParams.get('id');

        if (type === 'consultation') {
            
            var idPatient = $("#idPatientRecupere").val()
            $.ajax({
                url: 'patient/getPatientByJason?id=' + idPatient,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                $('.idpatientClassinfo').append(response.patient.patient_id).end();
                $('.ageClassinfo').append(response.patient.age + ' An(s)').end();
                $('.genderClassinfo').append(response.patient.sex).end();


            });
            $.ajax({
                url: 'patient/addConsultationByJason?id=' + idpatientConsultation,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                document.getElementById('listeConsultation').innerHTML = response;
                var d = new Date();
                var da = d.getDate() + '/' + d.getMonth() + 1 + '/' + d.getFullYear();
                $('#dateCons').val(da);
                $('#addMedicalHistory').modal('show');
                document.getElementById("poids").value = poids;
                document.getElementById("taille").value = taille;
                document.getElementById("specialite").value = spec;
                document.getElementById("temperature").value = temp;
                document.getElementById("frequenceRespiratoire").value = frRes;
                document.getElementById("frequenceCardiaque").value = frCar;
                document.getElementById("glycemyCapillaire").value = glyCap;
                document.getElementById("systolique").value = syst;
                document.getElementById("diastolique").value = diast;
                document.getElementById("Saturationarterielle").value = sat;

            });



            $.ajax({
                url: 'patient/recuperationTemplate',
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                CKEDITOR.instances['template'].setData(response.template.template);
            });
        }
        else {
            $('.idpatientClassinfo').html("").end();
            $('.genderClassinfo').html("").end();
            $('.ageClassinfo').html("").end();
        }

        var bt = document.getElementById('rediriger');
        if (bt) {
            bt.disabled = true;
        }
        setTimeout(() => {
            $(".flashmessage").delay(3000).fadeOut(100);
            CKEDITOR.instances.description.on('key', function(e) {
                var description = CKEDITOR.instances['description'].getData().length;
                if (description < 12) {
                    bt.disabled = true;
                } else {
                    bt.disabled = false;
                }
            });
        }, 3000);

    });

    var type = '<?php echo $type; ?>';
    var tabid_select = '#tab' + type;
    var divid_select = '#' + type;
    if (type) {
        $('.nav-tabs li').removeClass('active');
        $('.tab-pane').hide();
        $(tabid_select).toggleClass('active');
        $(divid_select).show();
    }
    $('.nav-tabs a').click(function() {
        var divid_select = $(this).attr("href");
        var tabid_select = $(this).attr("data-id");
        $('.nav-tabs li').removeClass('active');
        $('.tab-pane').hide();
        $(tabid_select).toggleClass('active');
        $(divid_select).show();
    });
</script>
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript">
    if ($.fn.datepicker.dates) {
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
    }
    $('#birthdates3').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
    });
    $('#date').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
    });
    $('#birthdate').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
    });
    $('#date_valid').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
    });
    $('#birthdateEdit').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
    });
    $('#birthdates2').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
    });

    dateaujourdhui = new Date();
    document.getElementById("today").value = dateaujourdhui.toLocaleDateString();
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
</script>
<script type="text/javascript">
    $(".table").on("click", ".editbutton", function() {
        //    e.preventDefault(e);
        // Get the record's ID via attribute  
        var iid = $(this).attr('data-id');

        $("#img1").attr("src", "uploads/cardiology-patient-icon-vector-6244713.jpg");

        $('.patientImgClass').html("").end();
        $('.patientIdClass').html("").end();
        $('.nameClass').html("").end();
        $('.lastnameClass').html("").end();
        $('.emailClass').html("").end();
        $('.addressClass').html("").end();
        $('.phoneClass').html("").end();
        $('.genderClass').html("").end();
        $('.poidsClass').html("").end();
        $('.Saturationarterielle').html("").end();
        $('.hypertensionSystolique').html("").end();
        $('.hypertensionDiastolique').html("").end();
        $('.ageClass').html("").end();
        $('.bloodgroupClass').html("").end();
        $('.temperatureClass').html("").end();
        $('.specialitePrestation').html("").end();
        $('.doctorClass').html("").end();
        $('.frequenceRespiratoire').html("").end();
        $('.tailleClass').html("").end();
        $('.frequenceCardiaque').html("").end();
        $('.glycemy').html("").end();
        $('.tensionArterielle').html("").end();
        $('.systole').html("").end();
        $('.sucre').html("").end();
        $('.albumine').html("").end();
        $('.oeildroit').html("").end();
        $('.oeilgauche').html("").end();
        $('.oreilledroite').html("").end();
        $('.oreillegauche').html("").end();
        $('.regionClass').html("").end();
        $('.dateConsultationClass').html("").end();
        $('.prescriptClass').html("").end();
        $('#myModal2').modal('show');
        $.ajax({
            url: 'patient/editMedicalHistoryByJason?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function(response) {
            // Populate the form fields with the data returned from server

            // alert(JSON(response.patient.img_url));
            var img_tag = JSON.stringify(response.patient.img_url) !== "null" ? "<img class='avatar' src='" + response.patient.img_url + "' alt='' style='max-width: 200px; max-height: 150px;margin-bottom:10px;'>" : "<img class='avatar' src='uploads/imgUsers/contact-512.png' alt='' style='max-width: 200px; max-height: 150px;margin-bottom:10px;'>";
            // alert(img_tag);
            $('.patientImgClass').append(img_tag).end();
            // alert($('.patientImgClass').html());
            $('.patientIdClass').append(response.patient.patient_id).end();
            $('.nameClass').append(response.patient.name).end();
            $('.lastnameClass').append(response.patient.last_name).end();
            $('.emailClass').append(response.patient.email).end();
            $('.addressClass').append(response.patient.address).end();
            $('.phoneClass').append(response.patient.phone).end();
            $('.genderClass').append(response.patient.sex).end();
            $('.poidsClass').append(response.medical_history.poids).end();
            $('.ageClass').append(response.patient.age).end();
            $('.bloodgroupClass').append(response.patient.bloodgroup).end();
            $('.specialitePrestation').append(response.medical_history.specialite + ' / ' + response.medical_history.namePrestation).end();
            $('.dateConsultationClass').append('Date Consultation : ' + response.medical_history.date_string).end();
            $('.prescriptClass').append('Medecin Prescripteur : Dr ' + response.medical_history.first_name + ' ' + response.medical_history.last_name).end();
            $('.temperatureClass').append(response.medical_history.temperature).end();
            $('.frequenceRespiratoire').append(response.medical_history.frequenceRespiratoire).end();
            $('.tailleClass').append(response.medical_history.taille).end();
            $('.glycemy').append(response.medical_history.glycemyCapillaire).end();
            $('.frequenceCardiaque').append(response.medical_history.frequenceCardiaque).end();
            $('.systole').append(response.medical_history.systolique).end();
            $('.sucre').append(response.medical_history.sucre).end();
            $('.albumine').append(response.medical_history.albumine).end();
            $('.oeildroit').append(response.medical_history.oeildroit).end();
            $('.oeilgauche').append(response.medical_history.oeilgauche).end();
            $('.oreilledroite').append(response.medical_history.oreilledroite).end();
            $('.oreillegauche').append(response.medical_history.oreillegauche).end();
            $('.diastole').append(response.medical_history.diastolique).end();
            $('.hypertensionSystolique').append(response.medical_history.HypertensionSystolique).end();
            $('.hypertensionDiastolique').append(response.medical_history.HypertensionDiastolique).end();
            $('.Saturationarterielle').append(response.medical_history.Saturationarterielle).end();
            $('.regionClass').append(response.patient.region).end();
            $('.tensionArterielle').append(response.medical_history.tensionArterielle).end();
            CKEDITOR.instances['editor'].setData(response.medical_history.description);
            if (response.doctor !== null) {
                //    $('.doctorClass').append(response.doctor.name).end()
            } else {
                //     $('.doctorClass').append('').end()
            }

            // if (typeof response.patient.img_url !== 'undefined' && response.patient.img_url != '') {
            // $("#img1").attr("src", response.patient.img_url);
            // }


            $('#myModal2').modal('show');

        });
    });
</script>
<script type="text/javascript">
    var checkbox7 = document.getElementById('customCheck7');
    var pos_matriculeedit = document.getElementById('pos_matricule7');
    checkbox7.onclick = function() {
        if (this.checked) {
            pos_matriculeedit.style['display'] = 'block';
        } else {
            pos_matriculeedit.style['display'] = 'none';

        }
    };
    document.getElementById('customCheckinfo').onclick = function() {
        if (this.checked) {
            $('.pos_matriculeinfo').show();
        } else {
            $('.pos_matriculeinfo').hide();

        }
    };

    var checkbox2 = document.getElementById('customCheck2');
    var pos_matricule2 = document.getElementById('pos_matricule2');
    checkbox2.onclick = function() {
        if (this.checked) {
            pos_matricule2.style['display'] = 'block';
        } else {
            pos_matricule2.style['display'] = 'none';

        }
    };
    var checkbox = document.getElementById('customCheck');
    var pos_matricule = document.getElementById('pos_matricule');
    checkbox.onclick = function() {
        if (this.checked) {
            pos_matricule.style['display'] = 'block';
        } else {
            pos_matricule.style['display'] = 'none';

        }
    };


    document.getElementById('customCheckEditMutuelle').onclick = function() {
        if (this.checked) {
            //document.getElementById('pos_matriculeEditMutuelle').style['display'] = 'block';
            $('#pos_matriculeEditMutuelle').show();
        } else {
            // document.getElementById('pos_matriculeEditMutuelle').style['display'] = 'none';
            $('#pos_matriculeEditMutuelle').hide();
        }
    };
</script>


<script type="text/javascript">
    $(document).ready(function() {

        $(".editPrescription").click(function(e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#myModal5').modal('show');
            $.ajax({
                url: 'prescription/editPrescriptionByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                // Populate the form fields with the data returned from server
                $('#prescriptionEditForm').find('[name="id"]').val(response.prescription.id).end()
                $('#prescriptionEditForm').find('[name="patient"]').val(response.prescription.patient).end()
                $('#prescriptionEditForm').find('[name="doctor"]').val(response.prescription.doctor).end()

                CKEDITOR.instances['editor1'].setData(response.prescription.symptom)
                CKEDITOR.instances['editor2'].setData(response.prescription.medicine)
                CKEDITOR.instances['editor3'].setData(response.prescription.note)
            });
        });
    });

    function recuperationDepot(event) {
        var amount = $('#deposited').val();
        var amountFormat = amount.replace(/[^\d]/g, '');
        amountFormat = parseInt(amountFormat);
        document.getElementById('deposited_amount').value = amountFormat;
        var reste = document.getElementById("reste").innerHTML;
        reste = parseInt(reste);
        var bt = document.getElementById('interfaceOrangemoney');
        var btCash = document.getElementById('subCash');
        var errorDepotCash = document.getElementById('errorDepotCash');
        errorDepotCash.style.display = 'none';
        bt.disabled = false;
        btCash.disabled = false;
        if (amountFormat > reste) {
            bt.disabled = true;
            btCash.disabled = true;
            errorDepotCash.style.display = 'block';
        }


    }
</script>


<script type="text/javascript">
    $(document).ready(function() {
        $(".editAppointmentButton").click(function(e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            var id = $(this).attr('data-id');

            $('#editAppointmentForm').trigger("reset");
            // $('#editAppointmentModal').modal('show');
            $.ajax({
                url: 'appointment/editAppointmentByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                var de = response.appointment.date * 1000;
                var d = new Date(de);

                var dateTime = d.getTime();
                var realTime = dateTime + (60 * 60) * 1000;
                var realTime = new Date(realTime);
                var mou = realTime.getMonth() + 1;
                if (mou < 10) {
                    mou = '0' + mou;
                }
                var da = realTime.getDate() + '/' + mou + '/' + realTime.getFullYear();
                // Populate the form fields with the data returned from server
                $('#editAppointmentForm').find('[name="id"]').val(response.appointment.id).end()
                $('#editAppointmentForm').find('[name="patient"]').val(response.appointment.patient).end()
                //  $('#editAppointmentForm').find('[name="doctor"]').val(response.appointment.doctor).end()
                $('#editAppointmentForm').find('[name="date"]').val(da).end()
                $('#editAppointmentForm').find('[name="status"]').val(response.appointment.status).end()
                $('#editAppointmentForm').find('[name="remarks"]').val(response.appointment.remarks).end()
                $('#editAppointmentForm').find('[name="patient_name"]').val(response.patient.name + ' ' + response.patient.last_name).end()
                $('#editAppointmentForm').find('[name="service_name"]').val(response.appointment.servicename).end()
                $('#editAppointmentForm').find('[name="patient"]').val(response.patient.id).end()
                $('#editAppointmentForm').find('[name="service"]').val(response.appointment.service).end()

                /* var option = new Option(response.patient.name + ' '+response.patient.last_name+ '-' + response.patient.phone, response.patient.id, true, true);
                 $('#editAppointmentForm').find('[name="patient"]').append(option).trigger('change');
                 var option1 = new Option(response.appointment.servicename + '-' + response.appointment.service, response.appointment.service, true, true);
                 $('#editAppointmentForm').find('[name="service"]').append(option1).trigger('change');*/
                if (response.appointment.status == 'Confirmed') {
                    $('#PendingConfirmation').hide();
                }

            });
            $('#editAppointmentModal').modal('show');
        });

        $(".editlab").click(function(e) {
            e.preventDefault(e);
            var id = $(this).attr('data-id');
            $('#datalabModal').trigger("reset");
            $('#datalab').empty();
            $('.idpatientClassinfo').html("").end();
            $('.genderClassinfo').html("").end();
            $('.ageClassinfo').html("").end();
            var idPatient = $("#idPatientRecupere").val();
            $.ajax({
                url: 'patient/getPatientByJason?id=' + idPatient,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                $('.idpatientClassinfo').append(response.patient.patient_id).end();
                $('.ageClassinfo').append(response.patient.age + ' An(s)').end();
                $('.genderClassinfo').append(response.patient.sex).end();


            });
            $('#datalabModal').trigger("reset");
            $('#datalabModal').modal('show');


            $.ajax({
                url: 'lab/editLabByJasonAnalyse?id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                $('#datalab').append(response);
            });
        });


        $(".depositbutton").click(function(e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var patient = $(this).attr('data-patient');
            var payment = $(this).attr('data-payment');
            var payment2 = $(this).attr('data-payment2');

            $('#myModaldeposit2').trigger("reset");
            $('#myModaldeposit2').modal('show');

            var amount_received = $(this).attr('data-amount_received');
            var gross_total = $(this).attr('data-gross_total');
            var reste = gross_total - amount_received;
            $('#myModaldeposit2').find('[id="reste"]').html(reste).end();

            var option1 = new Option(payment2, payment, true, true);
            $('#myModaldeposit2').find('[name="paymentid"]').empty().append(option1).trigger('change');
        });
    });
</script>



<script type="text/javascript">
    function donneTension(event) {
        var bt = document.getElementById('validationConsultation');
        var systolique = $('#systolique').val();
        systolique = parseInt(systolique);
        var diastolique = $('#diastolique').val();
        diastolique = parseInt(diastolique);
        var tensionArterielle = document.getElementById('tensionArterielle');
        tensionArterielle.style['display'] = 'block';
        $('#diastoleDonnes').html(``);
        $('#systoleDonnes').html(``);
        bt.disabled = false;
        if (diastolique < 30) {
            bt.disabled = true;
            $('#diastoleDonnes').html(`<code class="flash_message">la valeur du diastole doit être supérieur à 30 et inférieur 200</code>`);

        }
        if (diastolique > 200) {
            $('#diastoleDonnes').html(`<code class="flash_message">la valeur du diastole doit être supérieur à 30 et inférieur 200</code>`);
            bt.disabled = true;
        }
        if (systolique < 50) {
            $('#systoleDonnes').html(`<code class="flash_message">la valeur du diastole doit être supérieur à 50 et inférieur 250</code>`);
            bt.disabled = true;
        }
        if (systolique > 250) {
            $('#systoleDonnes').html(`<code class="flash_message">la valeur du diastole doit être supérieur à 50 et inférieur 250</code>`);
            bt.disabled = true;
        }
    }

    function editContact(event) {
        var num = $('#contactEdit').val();
        var numFormat = num.replace(/[^\d]/g, '');
        document.getElementById('phone_contact2').value = numFormat;

    }

    function tensionArterielles(event) {

        var systolique = $('#systolique').val();
        systolique = parseInt(systolique);
        var diastolique = $('#diastolique').val();
        diastolique = parseInt(diastolique);
        var tensionArterielle = document.getElementById('tensionArterielle');
        tensionArterielle.style['display'] = 'block';




        $('#tension').html(``);
        if (systolique > 0 && diastolique > 0) {
            if ((systolique >= 50 && systolique <= 120) && (diastolique >= 30 && diastolique <= 80)) {
                tensionArterielle.style['display'] = 'none';
                $('#tension').html(`
                <strong><span style="background-color:#006400;color:#FFFFFF" class="form-control pay_in ">Optimale</span>  </strong>
                `);
                document.getElementById('tensionName').value = 'Optimal';
            } else if ((systolique >= 120 && systolique <= 140) && (diastolique >= 80 && diastolique <= 90)) {
                tensionArterielle.style['display'] = 'none';
                $('#tension').html(`
                <strong> <span style="background-color:#FFD700;color:#FFFFFF" class="form-control pay_in ">Normale</span>  </strong>
                `);
                document.getElementById('tensionName').value = 'Normale';
            } else if ((systolique >= 140 && systolique <= 250) && (diastolique >= 90 && diastolique <= 200)) {
                tensionArterielle.style['display'] = 'none';
                $('#tension').html(`
               <strong><span style="background-color:#FF0000;color:#FFFFFF" class="form-control pay_in ">Élevée</span></strong>
                `);
                document.getElementById('tensionName').value = 'Élevée';
            }
        }

        $('#systoleDonne').html(``);
        $('#diastoleDonne').html(``);
        if (systolique >= 140 && systolique <= 250) {
            $('#systoleDonne').html(`<code class="flash_message">Hypertension Systolique</code>`);
            document.getElementById('hypertensionSystolique').value = 'Hypertension Systolique';
        }
        if (diastolique >= 90 && diastolique <= 200) {
            $('#diastoleDonne').html(`<code class="flash_message">Hypertension Diastolique</code>`);
            document.getElementById('hypertensionDiastolique').value = 'Hypertension Diastolique';
        }

    }

    function poidsNormal(event) {
        var age = $('#agePoidsTaille').val();
        var poids = $('#poids').val();
        var bt = document.getElementById('validationConsultation');
        poids = parseFloat(poids);
        age = parseFloat(age);
        bt.disabled = false;
        $('#NormalPoids').html(``);
        if ((age >= 0 && age <= 1) && (poids < 0.3)) {
            $('#NormalPoids').html(`<code class="flash_message">le poids ne correspond pas à un enfant de ${age} an</code>`);
            bt.disabled = true;
        } else if ((age >= 0 && age <= 1) && (poids > 12)) {
            $('#NormalPoids').html(`<code class="flash_message">le poids ne correspond pas à un enfant de ${age} an</code>`);
            bt.disabled = true;
        } else if ((age > 1 && age <= 4) && (poids < 6)) {
            $('#NormalPoids').html(`<code class="flash_message">le poids ne correspond pas à un enfant de ${age} ans </code>`);
            bt.disabled = true;
        } else if ((age > 1 && age <= 4) && (poids > 23)) {
            $('#NormalPoids').html(`<code class="flash_message">le poids ne correspond pas à un enfant de ${age} ans </code>`);
            bt.disabled = true;
        } else if ((age >= 5 && age <= 14) && (poids < 12)) {
            $('#NormalPoids').html(`<code class="flash_message">le poids ne correspond pas à un enfant de ${age} ans </code>`);
            bt.disabled = true;
        } else if ((age >= 5 && age <= 14) && (poids > 78)) {
            $('#NormalPoids').html(`<code class="flash_message">le poids ne correspond pas à un enfant de ${age} ans </code>`);
            bt.disabled = true;
        } else if ((age >= 15) && (poids < 37)) {
            $('#NormalPoids').html(`<code class="flash_message">le poids ne correspond pas à un adulte de ${age} ans </code>`);
            bt.disabled = true;
        } else if ((age >= 15) && (poids > 150)) {
            $('#NormalPoids').html(`<code class="flash_message">le poids ne correspond pas à un adulte de ${age} ans </code>`);
            bt.disabled = true;
        }
    }

    function tailleNormal(event) {
        var age = $('#agePoidsTaille').val();
        var taille = $('#taille').val();
        age = parseFloat(age);
        $('#NormalTaille').html(``);
        var bt = document.getElementById('validationConsultation');
        bt.disabled = false;
        if ((age >= 0 && age <= 1) && (taille < 44)) {
            $('#NormalTaille').html(`<code class="flash_message">la taille ne correspond pas à un enfant de ${age} an</code>`);
            bt.disabled = true;
        }
        if ((age >= 0 && age <= 1) && (taille > 81)) {
            $('#NormalTaille').html(`<code class="flash_message">la taille ne correspond pas à un enfant de ${age} an</code>`);
            bt.disabled = true;
        } else if ((age > 1 && age <= 4) && (taille < 70)) {
            $('#NormalTaille').html(`<code class="flash_message">la taille ne correspond pas à un enfant de ${age} ans </code>`);
            bt.disabled = true;
        } else if ((age > 1 && age <= 4) && (taille > 113)) {
            $('#NormalTaille').html(`<code class="flash_message">la taille ne correspond pas à un enfant de ${age} ans </code>`);
            bt.disabled = true;
        } else if ((age >= 5 && age <= 14) && (taille < 100)) {
            $('#NormalTaille').html(`<code class="flash_message">la taille ne correspond pas à un enfant de ${age} ans </code>`);
            bt.disabled = true;
        } else if ((age >= 5 && age <= 14) && (taille > 178)) {
            $('#NormalTaille').html(`<code class="flash_message">la taille ne correspond pas à un enfant de ${age} ans </code>`);
            bt.disabled = true;
        } else if ((age >= 15) && (taille < 148)) {
            $('#NormalTaille').html(`<code class="flash_message">la taille ne correspond pas à un adulte de ${age} ans </code>`);
            bt.disabled = true;
        } else if ((age >= 15) && (taille > 230)) {
            $('#NormalTaille').html(`<code class="flash_message">la taille ne correspond pas à un adulte de ${age} ans </code>`);
            bt.disabled = true;
        }
    }
</script>

<script>
    $(document).ready(function() {
        $('#editable-sample').DataTable({
            responsive: true,
            fixedHeader: true,
            dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 pull-left'B><'col-sm-4 pull-right'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: {
                /* buttons: [
                     // {
                     // extend: 'pageLength',
                     // }, /
                     {
                         extend: 'excelHtml5',
                         className: 'dt-button-icon-left dt-button-icon-excel',
                         exportOptions: {
                             columns: [0, 1],
                         }
                     },
                     {
                         extend: 'pdfHtml5',
                         className: 'dt-button-icon-left dt-button-icon-pdf',
                         exportOptions: {
                             columns: [0, 1],
                         }
                     },
                 ],*/
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
                [0, "desc"]
            ],
            language: {
                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json?<?php echo time(); ?>",
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
        $('.patient-table').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 pull-left'B><'col-sm-4 pull-right'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: {
                buttons: [
                    // {
                    // extend: 'pageLength',
                    // },
                    // {
                    // extend: 'excelHtml5',
                    // className: 'dt-button-icon-left dt-button-icon-excel',
                    // exportOptions: {
                    // columns: [0,1,2,3,4,5],
                    // }
                    // },
                    // {
                    // extend: 'pdfHtml5',
                    // className: 'dt-button-icon-left dt-button-icon-pdf',
                    // exportOptions: {
                    // columns: [0,1,2,3,4,5],
                    // }
                    // },
                ],
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
                //  [0, "desc"]
            ],
            language: {
                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json?<?php echo time(); ?>",
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
    });
</script>



<script type="text/javascript">
    $(document).ready(function() {

        $("#idservice_add").select2({
            placeholder: '<?php echo lang('select_service'); ?>',
            allowClear: true,
            ajax: {
                url: 'services/getServicesRdvByJson',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term // search term
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


        $("#idservice_addConsultation").select2({
            placeholder: '<?php echo lang('select_service'); ?>',
            allowClear: true,
            ajax: {
                url: 'services/getServicesRdvByJson',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term // search term
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

        $(".editPatientForm").click(function() {
            //    e.preventDefault(e);
            // Get the record's ID via attribute 

            var iid = $(this).attr('data-id');
            $('#editPatientForm').trigger("reset");
            $.ajax({
                url: 'patient/editPatientByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                var img_tag = JSON.stringify(response.patient.img_url) !== "null" ? "<img class='avatar' src='" + response.patient.img_url + "' alt='' style='max-width: 200px; max-height: 150px;margin-bottom:10px;'>" : "<img class='avatar' src='uploads/imgUsers/contact-512.png' alt='' style='max-width: 200px; max-height: 150px;margin-bottom:10px;'>";
                var age = parseInt(response.patient.age);
                $('#editPatientForm').find('[name="age"]').val(age).end();
                $('#editPatientForm').find('[name="id"]').val(response.patient.id).end()
                $('#editPatientForm').find('[name="name"]').val(response.patient.name).end()
                $('#editPatientForm').find('[name="last_name"]').val(response.patient.last_name).end()
                // $('#editPatientForm').find('[name="password"]').val(response.patient.password).end()
                $('#editPatientForm').find('[name="email"]').val(response.patient.email).end()
                $('#editPatientForm').find('[name="address"]').val(response.patient.address).end()
                // $('#editPatientForm').find('[name="phone"]').val(response.patient.phone).end()
                $('#editPatientForm').find('[name="sex"]').val(response.patient.sex).end()
                $('#editPatientForm').find('[name="birthdate"]').val(response.patient.birthdate).end()
                $('#editPatientForm').find('[name="bloodgroup"]').val(response.patient.bloodgroup).end()
                $('#editPatientForm').find('[name="p_id"]').val(response.patient.patient_id).end()
                $('#editPatientForm').find('[name="img"]').html(img_tag);
                $('#editPatientForm').find('[name="matricule"]').val(response.patient.matricule).end()
                $('#editPatientForm').find('[name="grade"]').val(response.patient.grade).end()
                $('#editPatientForm').find('[name="birth_position"]').val(response.patient.birth_position).end()
                $('#editPatientForm').find('[name="nom_contact"]').val(response.patient.nom_contact).end()
                $('#editPatientForm').find('[name="phone_contact"]').val(response.patient.phone_contact).end()
                $('#editPatientForm').find('[name="contactEdit"]').val(response.patient.phone_contact).end()
                $('#editPatientForm').find('[name="religion"]').val(response.patient.religion).end()
                $('#editPatientForm').find('[name="region"]').val(response.patient.region).end()

                if (typeof response.patient.img_url !== 'undefined' && response.patient.img_url != '') {
                    $("#img").attr("src", response.patient.img_url);
                }

                // var numeroTelephoneEdit = $('#phone6').val();
                // numeroTelephoneEdit = numeroTelephoneEdit.replace(/^221/, '');
                // document.getElementById('mobNo6').value = numeroTelephoneEdit;

                var numeroTelephone = response.patient.phone;
                numeroTelephone = numeroTelephone.replace(/^221/, '');
                document.getElementById('phone6').value = numeroTelephone;
                var contactEdit = $('#phone_contact2').val();
                contactEdit = contactEdit.replace(/^221/, '');
                document.getElementById('contactEdit').value = contactEdit;

                if (response.patient.phone_contact) {
                    var valcontactEdit = response.patient.phone_contact;
                    valcontactEdit = valcontactEdit.replace(/^221/, '');
                    $('#editPatientForm').find('[name="mobNo3"]').val(valcontactEdit).end()
                }

                var date_naissance = $('#birthdate2').val();
                var Age = '';
                if (date_naissance != '') {
                    date_naissance = date_naissance.split("/")[2];
                    date_naissance = parseInt(date_naissance);
                    var datejour = $('#datejour').val();
                    datejour = datejour.split("/")[2];
                    datejour = parseInt(datejour);
                    var Age = datejour - date_naissance;
                    document.getElementById('age').value = Age;

                }


                $('#editPatientForm').find('[name="mobNo6"]').val(numeroTelephone).end()


                $('.js-example-basic-single.doctor').val(response.patient.doctor).trigger('change');

                $('#infoModal').modal('show');
            });
        });

        $("#addConsultation").click(function() {
            //    e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#editPatientForm').trigger("reset");
            $.ajax({
                url: 'patient/addConsultationByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                document.getElementById('listeConsultation').innerHTML = response;
                var d = new Date();
                var da = d.getDate() + '/' + d.getMonth() + 1 + '/' + d.getFullYear();
                $('#dateCons').val(da);
                $('#addMedicalHistory').modal('show');
            });



            $.ajax({
                url: 'patient/recuperationTemplate',
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                CKEDITOR.instances['template'].setData(response.template.template);
            });
        });
    });
</script>

<script>
    var contactEdit = document.getElementById('contactEdit');
    var maskOptionsContactEdit = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var maskOptionsContact = IMask(contactEdit, maskOptionsContactEdit);
    maskOptionsContact.value = "{-- --- -- --";

    var mobNEdit = document.getElementById('mobNo4phoneNumber');
    var contactEdit = document.getElementById('mobNo4phone_contact');
    var maskOptionsEdit = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var maskOptionsContactEdit = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var maskEdit = IMask(mobNEdit, maskOptionsEdit);
    var maskOptionsContact = IMask(contactEdit, maskOptionsContactEdit);
    // maskOptionsEdit.value = "{-- --- -- --";
    maskOptionsContact.value = "{-- --- -- --";


    var mobNEdit2 = document.getElementById('mobEdit');
    var contactEdit2 = document.getElementById('contactEdit');
    var mobNo5 = document.getElementById('mobNo5');
    var maskOptionsEdit2 = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var maskOptionsContactEdit2 = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var maskOptionsmobNo5 = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };

    var mobNo6 = document.getElementById('mobNo6');
    var maskOptionsmobNo6 = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var maskOptionsContact = IMask(mobNo6, maskOptionsmobNo6);
    maskOptionsContact.value = "{-- --- -- --";
    var maskEdit2 = IMask(mobNEdit2, maskOptionsEdit2);
    var maskOptionsContact2 = IMask(contactEdit2, maskOptionsContactEdit2);
    var maskOptionsmobNo5 = IMask(mobNo5, maskOptionsmobNo5);


    $(document).ready(function() {
        $("#adoctors").select2({
            placeholder: '<?php echo lang('select_doctor'); ?>',
            allowClear: true,
            ajax: {
                url: 'doctor/getDoctorInfo',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term // search term
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
        $("#adoctors1").select2({
            placeholder: '<?php echo lang('select_doctor'); ?>',
            allowClear: true,
            ajax: {
                url: 'doctor/getDoctorInfo',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term // search term
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
        $('#patient_mutuelle').change(function(e) {

            var v = $(this).val();
            var readonly = '';
            var id = '';
            var name = '';
            var last_name = '';
            var phone = '';
            var birth_date = '';
            var sex = '';
            var selected_male = '';
            var selected_female = '';
            var selected_other_sex = '';
            var selected_pere = '';
            var selected_mere = '';
            var selected_enfant = '';
            var selected_other_parent = '';
            var res = v.split("*");

            id = res[0];
            name = res[1];
            last_name = res[2];
            phone = res[3];
            birth_date = res[4];
            readonly = ' readonly="" ';
            $.ajax({
                url: 'patient/editPatientByJason?id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                if (response.patient.parent_id) {
                    $(".liste_patient_mutuelle").append('<div class = "form-group medicine_sect col-md-12">Ce patient est deja pris a charge par un tuteur. </div>');
                } else {
                    $(".liste_patient_mutuelle").append('\n\
           <form role="form"  id="editPatientFormMutuelle" action="patient/addNewMpatient" class="clearfix" method="post" enctype="multipart/form-data">\n\
<section class="med_selected row" id="med_selected_section-' + id + '">\n\
          <div class = "form-group medicine_sect col-md-12"> \n\
\n\<div class="form-group col-md-12"><label for="exampleInputEmail1"><?php echo lang("lien_parente"); ?></label> <select class="form-control" name="lien_parente">\n\
<option value="Pere" ' + selected_pere + ' >  <?php echo lang("pere"); ?> </option>\n\
<option value="Mere" ' + selected_mere + ' >  <?php echo lang("mere"); ?> </option>\n\
<option value="Enfant" ' + selected_enfant + ' >  <?php echo lang("enfant"); ?> </option>\n\
<option value="Autres" ' + selected_other_parent + ' >  <?php echo lang("others"); ?> </option>\n\
</select> </div>\n\
 <div class="form-group col-md-6"> \n\
<label for="exampleInputEmail1">  <?php echo lang("name"); ?></label>\n\
<input type="text" class="form-control pay_in" name="p_name[]" value="' + name + '" required="" ' + readonly + '>\n\
</div>\n\
<div class="form-group col-md-6">\n\
<label for="exampleInputEmail1">  <?php echo lang("last_name"); ?></label>\n\
<input type="text" class="form-control pay_in" name="last_p_name[]" value="' + last_name + '" required=""  ' + readonly + '>\n\
</div>\n\
<div class="form-group col-md-6">\n\
<label for="exampleInputEmail1"> <?php echo lang("phone"); ?></label>\n\
<input type="text" class="form-control pay_in" name="p_phone[]" value="' + phone + '" placeholder=""  ' + readonly + '>\n\
</div>\n\
<div class="form-group col-md-6">\n\
<label><?php echo lang("birth_date"); ?></label>\n\
<input class="form-control form-control-inline input-medium default-date-picker" type="text" name="birthdate[]" value="' + birth_date + '"  ' + readonly + '  autocomplete="off" >\n\
</div>\n\
<input type="hidden" name="parent_id" value="<?php echo $patient->id; ?>">\n\
\n\<input type="hidden" name="id" value="' + id + '">\n\
</div>\n\
</div>\n\
</section>\n\
<section class="col-md-12"><button type="submit" name="submit" class="btn btn-info pull-right">Soumettre</button></section></form>\n\
');

                }
            });


        });


        $("#patient_mutuelle").select2({
            placeholder: '<?php echo lang('select_patient_mutuelle'); ?>',
            allowClear: true,
            ajax: {
                url: 'patient/getPatientinfoWithAddNewOptionByMutuelle',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        id: <?php echo $patient->id; ?> // search term
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
        $("#specialite").select2({

            placeholder: 'Selectionnez un service',
            allowClear: true,
            ajax: {
                url: 'finance/getSpecialiteConsultation',
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
                    alert(response)

                    return {
                        results: response

                    };

                },

                cache: true

            }

        });
        $("#nom_mutuelle").select2({
            placeholder: '<?php echo lang('select_nom_mutuelle'); ?>',
            allowClear: true,
            ajax: {
                url: 'patient/getMutuelleInfo',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term // search term
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


        $("#aservices1").select2({
            placeholder: '<?php echo lang('select_service'); ?>',
            allowClear: true,
            ajax: {
                url: 'services/getSericeinfoByJason',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term // search term
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
    });
</script>
<script>
    function recuperationPatientEdit(event) {
        var num = $('#mobNo6').val();
        var numFormat = num.replace(/[^\d]/g, '');
        document.getElementById('phone6').value = numFormat;
        var numeroTelephone = $('#phone6').val();


    }

    function recuperationEditAge() {
        var date_naissance = $('#birthdate2').val();
        var Age = '';
        if (date_naissance != '') {
            date_naissance = date_naissance.split("/")[2];
            date_naissance = parseInt(date_naissance);
            var datejour = $('#datejour').val();
            datejour = datejour.split("/")[2];
            datejour = parseInt(datejour);
            var Age = datejour - date_naissance;
            document.getElementById('age').value = Age;

        }
    }

    function recuperationEdit2() {
        var date_naissance = $('#birthdates').val();
        var Age = '';
        if (date_naissance != '') {
            date_naissance = date_naissance.split("/")[2];
            date_naissance = parseInt(date_naissance);
            var datejour = $('#datejour2').val();
            datejour = datejour.split("/")[2];
            datejour = parseInt(datejour);
            var Age = datejour - date_naissance;
            document.getElementById('age2').value = Age;

        } else {
            document.getElementById('age2').value = 'Non renseigné';
        }
    }

    function recuperationAge2() {
        var date_naissance = $('#birthdates2').val();
        var Age = '';
        if (date_naissance != '') {
            date_naissance = date_naissance.split("/")[2];
            date_naissance = parseInt(date_naissance);
            var datejour = $('#datejour3').val();
            datejour = datejour.split("/")[2];
            datejour = parseInt(datejour);
            var Age = datejour - date_naissance;
            document.getElementById('age3').value = Age;

        } else {
            document.getElementById('age3').value = 'Non renseigné';
        }
    }

    $(document).ready(function() {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>


<script>
    $(document).ready(function() {

        $(".flashmessage").delay(3000).fadeOut(100);

    });
    var datejourFooter = $('#datejourfooter').val();
    var users = $('#users').val();
    var dateFooter = datejourFooter.match(/\d{2}\/\d{2}\/\d{4}/)[0];
    var Heure = datejourFooter.match(/\d{2}:\d{2}/)[0];
    var dataUrl;



    $(".downloadlab").click(function(e) {
        e.preventDefault(e);
        var idPayment = $(this).attr('data-id');

        //   alert(datejourFooter+"------- "+users+"---------"+dateFooter+"-----------"+Heure+"-----------"+dataUrl);

        $.ajax({
            url: 'finance/generateRapportPDF?id=' + idPayment,
            method: 'GET',
            data: '',
            dataType: 'json'
        }).success(function(response) {
            console.log(response);

            var {
                nom,
                adresse,
                numero_fixe,
                description_courte_activite,
                slogan,
                description_courte_services,
                horaires_ouverture,
                date_string,
                code,
                path_logo
            } = response.origins;
            var {
                name: fisrt_name_patient,
                last_name: last_name_patient,
                patient_id,
                sex,
                address
            } = response.patientOrigins;
            var prescripteur;
            if (response.doctor === null) {
                prescripteur = ' ';
            }
            if (response.doctor != null) {
                prescripteur = 'DR ' + response.doctor.first_name + ' ' + response.doctor.last_name;
            }


            var {
                first_name: first_name_doctor,
                last_name: last_name_doctor,
            } = response.UsersValider;

            var agePatient = response.age;
            if (agePatient === undefined) {
                agePatient = response.patientOrigins.age + ' An(s)';
            }


            document.getElementById('logo2').value = path_logo;

            var tableResultats = response.structure.map(specialite => {
                var entete = [{
                        text: specialite.name_specialite,
                        fontSize: 13,
                        bold: true,
                        alignment: 'center',
                        colSpan: 4
                    },
                    null,
                    null,
                    null
                ];
                var prestations = specialite.prestations.map(prestation => {
                    var lignePrestation = [{
                            text: prestation.prestation,
                            alignment: 'left',
                            fontSize: 10,
                            bold: true,
                            colSpan: 4
                        },
                        null,
                        null,
                        null
                    ];

                    var resultats = prestation.resultats.map(resultat => {
                        return [{
                                text: resultat.nom_parametre,
                                fontSize: 10,
                            },
                            {
                                text: resultat.resultats,
                                fontSize: 10,
                                alignemt: 'right',
                                margin: [2, 0, 0, 0]
                            },
                            {
                                text: resultat.unite,
                                fontSize: 10,
                                alignemt: 'center'
                            },
                            {
                                text: resultat.valeurs,
                                fontSize: 10,
                                alignemt: 'center'
                            }
                        ]
                    })
                    return [lignePrestation, ...resultats]
                }).reduce((acc, element) => [...acc, ...element], [])

                return [entete, ...prestations]
            }).reduce((acc, element) => [...acc, ...element], [])
            document.querySelector('#descriptionConfirmation').innerHTML = horaires_ouverture;



            horaires_ouverture = document.getElementById('descriptionConfirmation').innerText;
            sex = sex.replace('Masculin', 'M').replace('Feminin', 'F');
            var logo = $('#logo2').val();
            var dd = {
                pageSize: 'A4',
                footer: function(currentPage, pageCount) {
                    return {
                        table: {
                            widths: ['*', 100],
                            body: [
                                [{
                                        text: nom + ', ' + adresse + ', Tel :' + numero_fixe + ', Résultats d\'analyses de ' + fisrt_name_patient + ' ' + last_name_patient + ' ,Imprimé par : ' + users + ', le ' + dateFooter + ' à ' + Heure,
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
                        widths: [90, 100, '*'],
                        columns: [{
                                image: logo2,
                                alignment: 'left',
                                widths: 100
                            },
                            {
                                text: [nom + '\n' + description_courte_activite + '\n' + slogan + '\n' + description_courte_services + '\n',

                                    {
                                        text: horaires_ouverture,
                                        color: 'gray',
                                        italics: true
                                    }
                                ],
                                alignment: 'center',

                            },

                            {
                                text: "Résultats des Analyses",
                                style: 'header',
                                color: '#0D4D99',
                                fontSize: 13,
                                margin: 15,
                            }
                        ]
                    },
                    {
                        alignment: 'justify',
                        widths: [90, 100, '*'],
                        columns: [{
                                text: 'DR ' + first_name_doctor + ' ' + last_name_doctor,
                                alignment: 'left',
                                widths: 100
                            },
                            {
                                text: '',

                            },

                            {
                                text: "",
                                style: 'header',
                                fontSize: 13,
                                margin: 15,
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
                        style: 'tableExample',
                        layout: 'noBorders',
                        table: {
                            headerRows: 1,
                            widths: [190, 100, '*'],

                            // dontBreakRows: true,
                            // keepWithHeaderRows: 1,
                            body: [
                                [{
                                    text: "Infos de l'acte",
                                    style: 'tableHeader',
                                    color: '#0D4D99'
                                }, {
                                    text: '',
                                    style: 'tableHeader'
                                }, {
                                    text: 'Infos Patient',
                                    style: 'tableHeader',
                                    color: '#0D4D99',
                                    margin: [25, 0, 0, 0]

                                }],
                                [{
                                        text: [{
                                                text: 'Date et Heure : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            date_string + '\n',
                                            {
                                                text: 'Médecin Prescripteur : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            prescripteur + '\n',
                                            {
                                                text: 'Numéro Dossier : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            code + '\n',
                                        ],
                                    },
                                    {
                                        text: ''
                                    },
                                    {
                                        text: [{
                                                text: 'Prénom et Nom : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            fisrt_name_patient + ' ' + last_name_patient + '\n',
                                            {
                                                text: 'Code Patient : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            patient_id + '\n',
                                            {
                                                text: 'Age : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            agePatient + '\n',
                                            {
                                                text: 'Sexe : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            sex + '\n',
                                            {
                                                text: 'Adresse : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            address + '\n',
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
                        table: {
                            widths: ['*', 90, 90, 90],
                            headerRows: 1,
                            lineColor: '#0D4D99',
                            body: [
                                [{
                                        text: 'Analyse(s) Demandées',
                                        fontSize: 12,
                                        bold: true,
                                        color: '#0D4D99'
                                    }, {
                                        text: 'Résultats',
                                        fontSize: 12,
                                        bold: true,
                                        color: '#0D4D99'
                                    }, {
                                        text: 'Unité',
                                        fontSize: 12,
                                        bold: true,
                                        color: '#0D4D99'
                                    },
                                    {
                                        text: 'Valeurs Usuelles',
                                        fontSize: 12,
                                        bold: true,
                                        color: '#0D4D99'
                                    },
                                ],
                                ...tableResultats
                            ]
                        },
                        layout: 'lightHorizontalLines',
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
                        text: '',
                        style: 'header'
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
                        text: '',
                        style: 'header'
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
                        text: '',
                        style: 'header'
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
                        text: '',
                        style: 'header'
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
                        text: '',
                        style: 'header'
                    },
                    {
                        alignment: 'right',
                        columns: [
                            [{
                                text: 'Le Biologiste ',
                                style: 'tableHeader',
                                decoration: 'underline',
                                fit: [50, 50]
                            }, {
                                text: '',
                                fit: [50, 50]
                            }],
                            //[{ text: 'Numéro Facture :', style: 'tableHeader',fit: [50, 50],alignment: 'right'}, { text: 'FA03230',fit: [50, 50],alignment: 'right'}],
                            // {
                            //   text: 'Numéro Facture : FA03230', style: 'tableHeader', alignment: 'right',
                            //   widths: ['*', '*', '*', 200]
                            // }
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
                        text: '',
                        style: 'header'
                    },
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

            toDataURL(logo, function(result) {
                dataUrl = result;
                console.log('RESULT:', dataUrl);
                document.getElementById('logoBase64').value = dataUrl;
                var logo2 = $('#logoBase64').val();
                dd.content[0].columns[0].image = logo2;

                //   pdfMake.createPdf(dd).print();

                pdfMake.createPdf(dd).download('Resultat_Analyse_' + code + '.pdf');

                // if (btn.getAttribute('data-attr') === "btn1") {

                //     pdfMake.createPdf(dd).print();

                // } else if (btn.getAttribute('data-attr') === "btn2") {
                //     pdfMake.createPdf(dd).download('Resultat_Analyse_' + code + '.pdf');

                // }
            })





        });





    });


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



    // var logo = $('#logo2').val();


    // function print() {

    //     // var paymentId = $(this).find('[name="payment"]').val();
    //     // alert(paymentID);
    //         // $.ajax({
    //         //     url: 'finance/generateRapportPDF',
    //         //     method: 'GET',
    //         //     data: '',
    //         //     dataType: 'json'
    //         // }).success(function(response) {
    //         //     var name = response.origins.nom;
    //         //    alert(name);
    //         // });
    // }
</script>

<script type="text/javascript">
    $(document).ready(function() {
            $.ajax({
                url: 'lab/getTemplateByIdByJason?id=' + 51,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                var data = CKEDITOR.instances.editor.getData();
                if (response.template.template != null) {
                    var data1 = data + response.template.template;
                } else {
                    var data1 = data;
                }
                CKEDITOR.instances['editorConsultation'].setData(data1)
            });
        $(document.body).on('change', '#template', function() {
            var iid = $("select.template option:selected").val();
            $.ajax({
                url: 'lab/getTemplateByIdByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                var data = CKEDITOR.instances.editor.getData();
                if (response.template.template != null) {
                    var data1 = data + response.template.template;
                } else {
                    var data1 = data;
                }
                CKEDITOR.instances['editorConsultation'].setData(data1)
            });
        });
    });
</script>


<script type="text/javascript">
    $(".table").on("click", ".editbuttonPatient", function() {
        //    e.preventDefault(e);
        // Get the record's ID via attribute  
        var iid = $(this).attr('data-id');
        $("#img").attr("src", "uploads/cardiology-patient-icon-vector-6244713.jpg");
        $('#editPatientForm').trigger("reset");
        $.ajax({
            url: 'patient/editPatientByJason?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function(response) {
            // Populate the form fields with the data returned from server

            $('#editPatientForm').find('[name="id"]').val(response.patient.id).end()
            $('#editPatientForm').find('[name="name"]').val(response.patient.name).end()
            $('#editPatientForm').find('[name="last_name"]').val(response.patient.last_name).end()
            // $('#editPatientForm').find('[name="password"]').val(response.patient.password).end()
            $('#editPatientForm').find('[name="email"]').val(response.patient.email).end()
            $('#editPatientForm').find('[name="address"]').val(response.patient.address).end()
            $('#editPatientForm').find('[name="phone"]').val(response.patient.phone).end()
            $('#editPatientForm').find('[name="sex"]').val(response.patient.sex).end()
            $('#editPatientForm').find('[name="birthdate"]').val(response.patient.birthdate).end()
            $('#editPatientForm').find('[name="bloodgroup"]').val(response.patient.bloodgroup).end()
            $('#editPatientForm').find('[name="p_id"]').val(response.patient.patient_id).end()

            $('#editPatientForm').find('[name="matricule"]').val(response.patient.matricule).end()
            $('#editPatientForm').find('[name="grade"]').val(response.patient.grade).end()
            $('#editPatientForm').find('[name="birth_position"]').val(response.patient.birth_position).end()
            $('#editPatientForm').find('[name="nom_contact"]').val(response.patient.nom_contact).end()
            $('#editPatientForm').find('[name="phone_contact"]').val(response.patient.phone_contact).end()
            $('#editPatientForm').find('[name="religion"]').val(response.patient.religion).end()
            $('#editPatientForm').find('[name="region"]').val(response.patient.region).end()
            var age = parseInt(response.patient.age);
            $('#editPatientForm').find('[name="age"]').val(age).end();




            var numeroTelephone = response.patient.phone;
            numeroTelephone = numeroTelephone.replace(/^221/, '');
            if (response.patient.phone_contact) {
                var valcontactEdit = response.patient.phone_contact;
                valcontactEdit = valcontactEdit.replace(/^221/, '');
                $('#editPatientForm').find('[name="mobNo3"]').val(valcontactEdit).end()
            }


            $('#editPatientForm').find('[name="mobNo4"]').val(numeroTelephone).end()

            var urlModal2 = location.pathname.split("/").slice(2).join("/");
            document.getElementById('urlModal2').value = urlModal2;


            if (typeof response.patient.img_url !== 'undefined' && response.patient.img_url != '') {
                $("#img").attr("src", response.patient.img_url);
            }

            if (response.doctor !== null) {
                var option1 = new Option(response.doctor.name + '-' + response.doctor.id, response.doctor.id, true, true);
            } else {
                var option1 = new Option(' ' + '-' + '', '', true, true);
            }


            //$('#editPatientForm').find('[name="doctor"]').append(option1).trigger('change');

            var optionbloodgroup = new Option(response.patient.bloodgroup, response.patient.bloodgroup, true, true);
            $('#editPatientForm').find('[name="bloodgroup"]').append(optionbloodgroup).trigger('change');

            var optionbloodlien_parente = new Option(response.patient.lien_parente, response.patient.lien_parente, true, true);
            $('#editPatientForm').find('[name="lien_parente"]').append(optionbloodlien_parente).trigger('change');

            // var optionbloodgroup = new Option(response.patient.bloodgroup, response.patient.bloodgroup, true, true);
            //$('#editPatientForm').find('[name="bloodgroup"]').append(optionbloodgroup).trigger('change');
            var date_naissance = $('#birthdates2').val();
            var Age = '';
            if (date_naissance != '') {
                date_naissance = date_naissance.split("/")[2];
                date_naissance = parseInt(date_naissance);
                var datejour = $('#datejour3').val();
                datejour = datejour.split("/")[2];
                datejour = parseInt(datejour);
                var Age = datejour - date_naissance;
                document.getElementById('age3').value = Age;

            }
            var num = $('#mobNo6').val();
            var numFormat = num.replace(/[^\d]/g, '');
            document.getElementById('phone6').value = numFormat;
            $('#myModalPatientEdit').modal('show');

        });
    });
</script>
<script src="<?php echo base_url(); ?>common/js/pdfobject.js"></script>
