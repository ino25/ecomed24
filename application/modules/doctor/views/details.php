<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->

        <div class="state-overview col-md-12" style="padding: 23px 0px;">
            <div class="clearfix">
                <div class="col-lg-3 col-sm-6">
                    <section class="panel home_sec_blue">
                        <a href="patient">
                            <div class="symbol blue">
                                <i class="fa fa-users-medical"></i>
                            </div>
                            <div class="value">
                                <h3 class="">
                                    <?php
                                    $this->db->where('id_organisation', $this->id_organisation);
                                    $this->db->from("patient");
                                    echo $this->db->count_all_results();
                                    ?>
                                </h3>
                                <p><?php echo lang('patient'); ?></p>
                            </div>
                        </a>
                    </section>
                </div>
                <!-- <div class="col-lg-3 col-sm-6">
                    <section class="panel home_sec_green">
                        <a href="finance/paymentLabo">
                            <div class="symbol green">
                                <i class="fa fa-flask"></i>
                            </div>
                            <div class="value">
                                <h3 class="">
                                    <?php
                                    $this->db->where('id_organisation', $this->id_organisation);
                                    $this->db->from("lab");
                                    echo $this->db->count_all_results();
                                    ?>
                                </h3>
                                <p><?php echo lang('lab_report'); ?></p>
                            </div>
                            </a>
                    </section>
                    
                </div> -->
                <div class="col-lg-3 col-sm-6">
                        <section class="panel home_sec_blue">
                        <a>
                            <div class="symbol blue">
                                <i class="fa fa-file"></i>
                            </div>
                            <div class="value">
                                <h3 class="">
                                    <?php
                                    $this->db->where('id_organisation', $this->id_organisation);
                                    $this->db->where('status', 'pending');
                                    $this->db->from("payment");
                                    echo $this->db->count_all_results();
                                    ?>
                                </h3>
                                <p><?php echo lang('acte_encour'); ?></p>
                            </div>
                        </section>
                        <?php if ($this->ion_auth->in_group('Doctor', 'adminmedecin')) { ?>
                        </a>
                    <?php } ?>
                </div>
                <div class="col-lg-3 col-sm-6">
                        <section class="panel home_sec_yellow">
                        <a href="appointment">
                            <div class="symbol green">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="value">
                                <h3 class="">
                                    <?php
                                    $this->db->where('id_organisation', $this->id_organisation);
                                    $this->db->where('service', $this->id_serviceUser);
                                    $this->db->from("appointment");
                                    echo $this->db->count_all_results();
                                    ?>
                                </h3>
                                <p><?php echo lang('appointment'); ?></p>
                            </div>
                            </a>
                        </section>
                </div>
            </div>
            <div class="state-overview col-md-8 panel row">
                <div id="calendar" class="tab-pane active">
                    <div class="">
                        <div class="panel-body">
                            <aside>
                                <section class="panel">
                                    <div class="panel-body">
                                        <div id="calendar" class="has-toolbar calendar_view"></div>
                                    </div>
                                </section>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
            </div>
            <div class="col-md-3">
                <section class="panel">
                    <header class="panel-heading">
                        <?php
                        $nom_jour_fr = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
                        $mois_fr = array(
                            "", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août",
                            "septembre", "octobre", "novembre", "décembre"
                        );
                        list($nom_jour, $jour, $mois, $annee) = explode('/', date("w/d/n/Y"));
                        echo $nom_jour_fr[$nom_jour] . ' ' . $jour . ' ' . $mois_fr[$mois] . ' ' . $annee;
                        ?>
                    </header>
                    <div class="panel-body">
                        <div class="home_section">
                            <?php echo lang('appointment'); ?> : <?php echo $this_day['appointment']; ?>
                            <hr>
                        </div>
                    </div>
                </section>
                <section class="panel">
                    <header class="panel-heading">
                        <?php
                        $nom_jour_fr = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
                        $mois_fr = array(
                            "", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août",
                            "septembre", "octobre", "novembre", "décembre"
                        );
                        list($nom_jour, $jour, $mois, $annee) = explode('/', date("w/d/n/Y"));
                        echo $mois_fr[$mois] . ' ' . $annee;
                        ?>
                    </header>
                    <div class="panel-body">
                        <div class="home_section">
                            <?php echo lang('appointment'); ?> : <?php echo $this_month['appointment']; ?>
                            <hr>
                        </div>
                    </div>
                </section>
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo date('Y'); ?>
                    </header>
                    <div class="home_section">
                        <?php echo lang('appointment'); ?> : <?php echo $this_year['appointment']; ?>
                        <hr>
                    </div>
            </div>
    </section>
    </div>
    </div>
    <!-- page end-->
</section>
</section>
<!--main content end-->
<!--footer start-->
<!-- Add Patient Material Modal-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i> <?php echo lang('add'); ?> <?php echo lang('files'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="patient/addPatientMaterial" class="clearfix row" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="exampleInputEmail1" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('file'); ?></label>
                        <input type="file" name="img_url">
                    </div>

                    <input type="hidden" name="patient" value='<?php echo $patient->id; ?>'>

                    <div class="form-group col-md-6">
                        <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Patient Modal-->


<!-- Add Medical History Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i> <?php echo lang('add_medical_history'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="patient/addMedicalHistory" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3"><?php echo lang('description'); ?></label>
                        <div class="col-md-9">
                            <textarea class="ckeditor form-control" name="description" value="" rows="10"></textarea>
                        </div>
                    </div>

                    <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="id" value=''>
                    <section class="">
                        <button type="submit" name="submit" class="btn btn-info submit_button">Submit</button>
                    </section>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Medical History Modal-->

<!-- Edit Medical History Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> <?php echo lang('edit_medical_history'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="medical_historyEditForm" action="patient/addMedicalHistory" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label col-md-3"><?php echo lang('description'); ?></label>
                        <div class="col-md-9">
                            <textarea class="ckeditor form-control editor" id="editor" name="description" value="" rows="10"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="id" value=''>
                    <section class="">
                        <button type="submit" name="submit" class="btn btn-info submit_button">Submit</button>
                    </section>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="cmodal">
    <div class="modal-dialog modal-lg" role="document" style="width: 80%;">
        <div class="modal-content">
            <!--
            <div class="modal-header">
                <h5 class="modal-title"><?php echo lang('patient') . " " . lang('history'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            -->
            <div id='medical_history'>
                <div class="col-md-12">

                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-12">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$current_user = $this->ion_auth->get_user_id();
if ($this->ion_auth->in_group('Doctor', 'adminmedecin')) {
    $doctor_id = $this->db->get_where('doctor', array('ion_user_id' => $current_user))->row()->id;
}
?>



<!-- Add Appointment Modal-->
<div class="modal fade" id="addAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg"">
        <div class=" modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title"> <?php echo lang('add_appointment'); ?></h4>
        </div>
        <div class="modal-body">
            <form role="form" action="appointment/addNew" class="clearfix row" method="post" enctype="multipart/form-data">
                <div class="col-md-4 panel">
                    <label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label>
                    <select class="form-control m-bot15  pos_select" id="pos_select" name="patient" value=''>

                    </select>
                </div>

                <div class="pos_client clearfix">
                    <div class="col-md-8 payment pad_bot pull-right">
                        <div class="col-md-3 payment_label">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('name'); ?></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control pay_in" name="p_name" value='' placeholder="">
                        </div>
                    </div>
                    <div class="col-md-8 payment pad_bot pull-right">
                        <div class="col-md-3 payment_label">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('email'); ?></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control pay_in" name="p_email" value='' placeholder="">
                        </div>
                    </div>
                    <div class="col-md-8 payment pad_bot pull-right">
                        <div class="col-md-3 payment_label">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('phone'); ?></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control pay_in" name="p_phone" value='' placeholder="">
                        </div>
                    </div>
                    <div class="col-md-8 payment pad_bot pull-right">
                        <div class="col-md-3 payment_label">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('age'); ?></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control pay_in" name="p_age" value='' placeholder="">
                        </div>
                    </div>
                    <div class="col-md-8 payment pad_bot pull-right">
                        <div class="col-md-3 payment_label">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('gender'); ?></label>
                        </div>
                        <div class="col-md-9">
                            <select class="form-control m-bot15" name="p_gender" value=''>

                                <option value="Male" <?php
                                                        if (!empty($patient->sex)) {
                                                            if ($patient->sex == 'Male') {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?>> Male </option>
                                <option value="Female" <?php
                                                        if (!empty($patient->sex)) {
                                                            if ($patient->sex == 'Female') {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?>> Female </option>
                                <option value="Others" <?php
                                                        if (!empty($patient->sex)) {
                                                            if ($patient->sex == 'Others') {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?>> Others </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 panel">
                    <label for="exampleInputEmail1"> <?php echo lang('doctor'); ?></label>
                    <select class="form-control js-example-basic-single" id="adoctors" name="doctor" value=''>
                        <option value="">Select .....</option>
                        <option value="<?php echo $doctor->id; ?>"><?php echo $doctor->name; ?> </option>
                    </select>
                </div>


                <div class="col-md-4 panel">
                    <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                    <input type="text" class="form-control default-date-picker" id="date" readonly="" name="date" id="exampleInputEmail1" value='' placeholder="">
                </div>

                <div class="col-md-6 panel">
                    <label class=""><?php echo lang('available_slots'); ?></label>
                    <select class="form-control m-bot15" name="time_slot" id="aslots" value=''>

                    </select>
                </div>



                <div class="col-md-6 panel">
                    <label for="exampleInputEmail1"> <?php echo lang('appointment'); ?> <?php echo lang('status'); ?></label>
                    <select class="form-control m-bot15" name="status" value=''>
                        <option value="Pending Confirmation" <?php
                                                                ?>> <?php echo lang('pending_confirmation'); ?> </option>
                        <option value="Confirmed" <?php
                                                    ?>> <?php echo lang('confirmed'); ?> </option>
                        <option value="Treated" <?php
                                                ?>> <?php echo lang('treated'); ?> </option>
                        <option value="Cancelled" <?php
                                                    ?>> <?php echo lang('cancelled'); ?> </option>
                    </select>
                </div>

                <div class="col-md-8 panel">
                    <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                    <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                </div>


                <div class="col-md-6 panel">
                    <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br>
                </div>

                <input type="hidden" name="redirect" value='doctor/details'>

                <div class="col-md-12 panel">
                    <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                </div>

            </form>

        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>
<!-- Add Appointment Modal-->







<!-- Edit Event Modal-->
<div class="modal fade" id="editAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg"">
        <div class=" modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title"> <?php echo lang('edit_appointment'); ?></h4>
        </div>
        <div class="modal-body">
            <form role="form" id="editAppointmentForm" action="appointment/addNew" class="clearfix row" method="post" enctype="multipart/form-data">
                <div class="col-md-4 panel">
                    <label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label>
                    <select class="form-control m-bot15  pos_select patient" id="pos_select" name="patient" value=''>

                    </select>
                </div>
                <div class="pos_client clearfix" id="patientregistration">
                    <div class="col-md-8 payment pad_bot pull-right">
                        <div class="col-md-3 payment_label">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('name'); ?></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control pay_in" name="p_name" value='' placeholder="">
                        </div>
                    </div>
                    <div class="col-md-8 payment pad_bot pull-right">
                        <div class="col-md-3 payment_label">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('email'); ?></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control pay_in" name="p_email" value='' placeholder="">
                        </div>
                    </div>
                    <div class="col-md-8 payment pad_bot pull-right">
                        <div class="col-md-3 payment_label">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('phone'); ?></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control pay_in" name="p_phone" value='' placeholder="">
                        </div>
                    </div>
                    <div class="col-md-8 payment pad_bot pull-right">
                        <div class="col-md-3 payment_label">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('age'); ?></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control pay_in" name="p_age" value='' placeholder="">
                        </div>
                    </div>
                    <div class="col-md-8 payment pad_bot pull-right">
                        <div class="col-md-3 payment_label">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('gender'); ?></label>
                        </div>
                        <div class="col-md-9">
                            <select class="form-control m-bot15" name="p_gender" value=''>

                                <option value="Male" <?php
                                                        if (!empty($patient->sex)) {
                                                            if ($patient->sex == 'Male') {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?>> Male </option>
                                <option value="Female" <?php
                                                        if (!empty($patient->sex)) {
                                                            if ($patient->sex == 'Female') {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?>> Female </option>
                                <option value="Others" <?php
                                                        if (!empty($patient->sex)) {
                                                            if ($patient->sex == 'Others') {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?>> Others </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 panel">
                    <label for="exampleInputEmail1"> <?php echo lang('doctor'); ?></label>
                    <select class="form-control m-bot15 js-example-basic-single doctor" id="adoctors1" name="doctor" value=''>
                        <option value="">Select .....</option>
                        <option value="<?php echo $doctor->id; ?>"><?php echo $doctor->name; ?> </option>
                    </select>
                </div>


                <div class="col-md-4 panel">
                    <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                    <input type="text" class="form-control default-date-picker" readonly="" id="date1" name="date" id="exampleInputEmail1" value='' placeholder="">
                </div>

                <div class="col-md-6 panel">
                    <label class=""><?php echo lang('available_slots'); ?></label>
                    <select class="form-control" name="time_slot" id="aslots1" value=''>

                    </select>
                </div>




                <div class="col-md-6 panel">
                    <label for="exampleInputEmail1"> <?php echo lang('appointment'); ?> <?php echo lang('status'); ?></label>
                    <select class="form-control m-bot15" name="status" value=''>
                        <option value="Pending Confirmation" <?php
                                                                ?>> <?php echo lang('pending_confirmation'); ?> </option>
                        <option value="Confirmed" <?php
                                                    ?>> <?php echo lang('confirmed'); ?> </option>
                        <option value="Treated" <?php
                                                ?>> <?php echo lang('treated'); ?> </option>
                        <option value="Cancelled" <?php
                                                    ?>> <?php echo lang('cancelled'); ?> </option>
                    </select>
                </div>

                <div class="col-md-8 panel">
                    <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                    <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                </div>


                <div class="col-md-6 panel">
                    <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br>
                </div>



                <input type="hidden" name="redirect" value='doctor/details'>
                <input type="hidden" name="id" id="appointment_id" value=''>

                <div class="col-md-12 panel">
                    <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                </div>

            </form>

        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>
<!-- Edit Event Modal-->


<!-- Add Holiday Modal-->
<div class="modal fade" id="holidayModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add'); ?> <?php echo lang('holiday'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="schedule/addHoliday" class="clearfix row" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                        <div class="input-group bootstrap-timepicker">
                            <input type="text" class="form-control default-date-picker" name="date" id="validationCustom01" value='' readonly="" required="required">
                        </div>

                    </div>
                    <input type="hidden" name="doctor" value='<?php echo $doctor->id; ?>'>
                    <input type="hidden" name="redirect" value='doctor/details'>
                    <input type="hidden" name="id" value=''>
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Holiday Modal-->




<!-- Edit Holiday Modal-->
<div class="modal fade" id="editHolidayModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('edit'); ?> <?php echo lang('holiday'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editHolidayForm" action="schedule/addHoliday" class="clearfix row" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                        <div class="input-group bootstrap-timepicker">
                            <input type="text" class="form-control default-date-picker" name="date" id="exampleInputEmail1" value='' readonly="" required="">
                        </div>
                    </div>
                    <input type="hidden" name="doctor" value='<?php echo $doctor->id; ?>'>
                    <input type="hidden" name="redirect" value='doctor/details'>
                    <input type="hidden" name="id" value=''>
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Holiday Modal-->



<!-- Add Time Slot Modal-->
<div class="modal fade" id="addScheduleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add'); ?> <?php echo lang('schedule'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="schedule/addSchedule" class="clearfix row" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('weekday'); ?></label>
                        <select class="form-control m-bot15" id="weekday" name="weekday" value=''>
                            <option value="Friday"><?php echo lang('friday') ?></option>
                            <option value="Saturday"><?php echo lang('saturday') ?></option>
                            <option value="Sunday"><?php echo lang('sunday') ?></option>
                            <option value="Monday"><?php echo lang('monday') ?></option>
                            <option value="Tuesday"><?php echo lang('tuesday') ?></option>
                            <option value="Wednesday"><?php echo lang('wednesday') ?></option>
                            <option value="Thursday"><?php echo lang('thursday') ?></option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('start_time'); ?></label>
                        <div class="input-group bootstrap-timepicker">
                            <input type="text" class="form-control timepicker-default" name="s_time" id="exampleInputEmail1" value=''>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
                            </span>
                        </div>

                    </div>
                    <div class="form-group bootstrap-timepicker col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('end_time'); ?></label>
                        <div class="input-group bootstrap-timepicker">
                            <input type="text" class="form-control timepicker-default" name="e_time" id="exampleInputEmail1" value=''>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group col-md-5">
                        <label for="exampleInputEmail1"><?php echo lang('appointment') ?> <?php echo lang('duration') ?> </label>
                        <select class="form-control" name="duration" value=''>

                            <option value="3" <?php
                                                if (!empty($settings->duration)) {
                                                    if ($settings->duration == '3') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?>> 15 Minitues </option>

                            <option value="4" <?php
                                                if (!empty($settings->duration)) {
                                                    if ($settings->duration == '4') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?>> 20 Minitues </option>

                            <option value="6" <?php
                                                if (!empty($settings->duration)) {
                                                    if ($settings->duration == '6') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?>> 30 Minitues </option>

                            <option value="9" <?php
                                                if (!empty($settings->duration)) {
                                                    if ($settings->duration == '9') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?>> 45 Minitues </option>

                            <option value="12" <?php
                                                if (!empty($settings->duration)) {
                                                    if ($settings->duration == '12') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?>> 60 Minitues </option>

                        </select>
                    </div>

                    <input type="hidden" name="doctor" value='<?php echo $doctor_id; ?>'>
                    <input type="hidden" name="redirect" value='doctor/details'>
                    <input type="hidden" name="id" value=''>

                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Time Slot Modal-->





<!-- Edit Time Slot Modal-->
<div class="modal fade" id="editSceduleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i> <?php echo lang('edit'); ?> <?php echo lang('time_slot'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editTimeSlotForm" action="schedule/addSchedule" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('start_time'); ?></label>
                        <div class="input-group bootstrap-timepicker">
                            <input type="text" class="form-control timepicker-default" name="s_time" id="exampleInputEmail1" value=''>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
                            </span>
                        </div>

                    </div>
                    <div class="form-group bootstrap-timepicker">
                        <label for="exampleInputEmail1"> <?php echo lang('end_time'); ?></label>
                        <div class="input-group bootstrap-timepicker">
                            <input type="text" class="form-control timepicker-default" name="e_time" id="exampleInputEmail1" value=''>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group bootstrap-timepicker">
                        <label for="exampleInputEmail1"> <?php echo lang('weekday'); ?></label>
                        <div class="input-group bootstrap-timepicker">
                            <select class="form-control m-bot15" id="weekday" name="weekday" value=''>
                                <option value="Friday"><?php echo lang('friday') ?></option>
                                <option value="Saturday"><?php echo lang('saturday') ?></option>
                                <option value="Sunday"><?php echo lang('sunday') ?></option>
                                <option value="Monday"><?php echo lang('monday') ?></option>
                                <option value="Tuesday"><?php echo lang('tuesday') ?></option>
                                <option value="Wednesday"><?php echo lang('wednesday') ?></option>
                                <option value="Thursday"><?php echo lang('thursday') ?></option>
                            </select>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('appointment') ?> <?php echo lang('duration') ?> </label>
                        <select class="form-control m-bot15" name="duration" value=''>

                            <option value="3" <?php
                                                if (!empty($settings->duration)) {
                                                    if ($settings->duration == '3') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?>> 15 Minitues </option>

                            <option value="4" <?php
                                                if (!empty($settings->duration)) {
                                                    if ($settings->duration == '4') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?>> 20 Minitues </option>

                            <option value="6" <?php
                                                if (!empty($settings->duration)) {
                                                    if ($settings->duration == '6') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?>> 30 Minitues </option>

                            <option value="9" <?php
                                                if (!empty($settings->duration)) {
                                                    if ($settings->duration == '9') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?>> 45 Minitues </option>

                            <option value="12" <?php
                                                if (!empty($settings->duration)) {
                                                    if ($settings->duration == '12') {
                                                        echo 'selected';
                                                    }
                                                }
                                                ?>> 60 Minitues </option>

                        </select>
                    </div>

                    <input type="hidden" name="doctor" value="<?php echo $doctorr; ?>">
                    <input type="hidden" name="redirect" value='doctor/details'>
                    <input type="hidden" name="id" value=''>
                    <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Time Slot Modal-->






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
</style>


<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $(".editScheduleButton").click(function(e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#editTimeSlotForm').trigger("reset");
            $('#editScheduleModal').modal('show');
            $.ajax({
                url: 'schedule/editScheduleByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                // Populate the form fields with the data returned from server
                $('#editTimeSlotForm').find('[name="id"]').val(response.schedule.id).end()
                $('#editTimeSlotForm').find('[name="s_time"]').val(response.schedule.s_time).end()
                $('#editTimeSlotForm').find('[name="e_time"]').val(response.schedule.e_time).end()
                $('#editTimeSlotForm').find('[name="weekday"]').val(response.schedule.weekday).end()
            });
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function() {
        $(".editbutton").click(function(e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#myModal2').modal('show');
            $.ajax({
                url: 'patient/editMedicalHistoryByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                // Populate the form fields with the data returned from server
                $('#medical_historyEditForm').find('[name="id"]').val(response.medical_history.id).end()
                $('#medical_historyEditForm').find('[name="date"]').val(response.medical_history.date).end()
                CKEDITOR.instances['editor'].setData(response.medical_history.description)
            });
        });
    });
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
</script>





<script type="text/javascript">
    $(document).ready(function() {
        $(".editHoliday").click(function(e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#editHolidayForm').trigger("reset");
            $('#editHolidayModal').modal('show');
            $.ajax({
                url: 'schedule/editHolidayByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                // Populate the form fields with the data returned from server
                var date = new Date(response.holiday.date * 1000);
                $('#editHolidayForm').find('[name="id"]').val(response.holiday.id).end()
                $('#editHolidayForm').find('[name="date"]').val(date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear()).end()
            });
        });
    });
</script>



<script>
    $(document).ready(function() {
        $('.pos_client').hide();
        $(document.body).on('change', '#pos_select', function() {

            var v = $("select.pos_select option:selected").val()
            if (v == 'add_new') {
                $('.pos_client').show();
            } else {
                $('.pos_client').hide();
            }
        });

    });
</script>


<script type="text/javascript">
    $(document).ready(function() {
        $(".editAppointmentButton").click(function(e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            var id = $(this).attr('data-id');

            $('#editAppointmentForm').trigger("reset");
            $('#patientregistration').css('display', 'none');
            // $('.pos_client').hide();
            $('#editAppointmentModal').modal('show');
            $.ajax({
                url: 'appointment/editAppointmentByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                var de = response.appointment.date * 1000;
                var d = new Date(de);
                var da = d.getDate() + '-' + (d.getMonth() + 1) + '-' + d.getFullYear();
                // Populate the form fields with the data returned from server
                $('#editAppointmentForm').find('[name="id"]').val(response.appointment.id).end()
                // $('#editAppointmentForm').find('[name="patient"]').val(response.appointment.patient).end()
                $('#editAppointmentForm').find('[name="doctor"]').val(response.appointment.doctor).end()
                $('#editAppointmentForm').find('[name="date"]').val(da).end()
                $('#editAppointmentForm').find('[name="status"]').val(response.appointment.status).end()
                $('#editAppointmentForm').find('[name="remarks"]').val(response.appointment.remarks).end()
                var option = new Option(response.patient.name + '-' + response.patient.id, response.patient.id, true, true);
                $('#editAppointmentForm').find('[name="patient"]').append(option).trigger('change');
                $('.js-example-basic-single.doctor').val(response.appointment.doctor).trigger('change');
                //  $('.js-example-basic-single.patient').val(response.appointment.patient).trigger('change');




                var date = $('#date1').val();
                var doctorr = $('#adoctors1').val();
                var appointment_id = $('#appointment_id').val();
                // $('#default').trigger("reset");
                /* $.ajax({
                     url: 'schedule/getAvailableSlotByDoctorByDateByAppointmentIdByJason?date=' + date + '&doctor=' + doctorr + '&appointment_id=' + appointment_id,
                     method: 'GET',
                     data: '',
                     dataType: 'json',
                 }).success(function (response) {
                     $('#aslots1').find('option').remove();
                     var slots = response.aslots;
                     $.each(slots, function (key, value) {
                         $('#aslots1').append($('<option>').text(value).val(value)).end();
                     });

                     $("#aslots1").val(response.current_value)
                             .find("option[value=" + response.current_value + "]").attr('selected', true);
                     //  $('#aslots1 option[value=' + response.current_value + ']').attr("selected", "selected");
                     //   $("#default-step-1 .button-next").trigger("click");
                     if ($('#aslots1').has('option').length == 0) {                    //if it is blank. 
                         $('#aslots1').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
                     }
                     // Populate the form fields with the data returned from server
                     //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
                 });*/
            });
        });
    });
</script>












<script type="text/javascript">
    $(document).ready(function() {
        $("#adoctors").change(function() {
            // Get the record's ID via attribute  
            var iid = $('#date').val();
            var doctorr = $('#adoctors').val();
            $('#aslots').find('option').remove();
            // $('#default').trigger("reset");
            $.ajax({
                url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + iid + '&doctor=' + doctorr,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                var slots = response.aslots;
                $.each(slots, function(key, value) {
                    $('#aslots').append($('<option>').text(value).val(value)).end();
                });
                //   $("#default-step-1 .button-next").trigger("click");
                if ($('#aslots').has('option').length == 0) { //if it is blank. 
                    $('#aslots').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
                }
                // Populate the form fields with the data returned from server
                //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
            });
        });

    });

    $(document).ready(function() {
        var iid = $('#date').val();
        var doctorr = $('#adoctors').val();
        $('#aslots').find('option').remove();
        // $('#default').trigger("reset");
        $.ajax({
            url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + iid + '&doctor=' + doctorr,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function(response) {
            var slots = response.aslots;
            $.each(slots, function(key, value) {
                $('#aslots').append($('<option>').text(value).val(value)).end();
            });
            //   $("#default-step-1 .button-next").trigger("click");
            if ($('#aslots').has('option').length == 0) { //if it is blank. 
                $('#aslots').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
            }
            // Populate the form fields with the data returned from server
            //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
        });

    });




    $(document).ready(function() {
        $('#date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
            })
            //Listen for the change even on the input
            .change(dateChanged)
            .on('changeDate', dateChanged);
    });

    function dateChanged() {
        // Get the record's ID via attribute  
        var iid = $('#date').val();
        var doctorr = $('#adoctors').val();
        $('#aslots').find('option').remove();
        // $('#default').trigger("reset");
        $.ajax({
            url: 'schedule/getAvailableSlotByDoctorByDateByJason?date=' + iid + '&doctor=' + doctorr,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function(response) {
            var slots = response.aslots;
            $.each(slots, function(key, value) {
                $('#aslots').append($('<option>').text(value).val(value)).end();
            });
            //   $("#default-step-1 .button-next").trigger("click");
            if ($('#aslots').has('option').length == 0) { //if it is blank. 
                $('#aslots').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
            }


            // Populate the form fields with the data returned from server
            //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
        });

    }
</script>












<script type="text/javascript">
    $(document).ready(function() {
        $("#adoctors1").change(function() {
            // Get the record's ID via attribute 
            var id = $('#appointment_id').val();
            var date = $('#date1').val();
            var doctorr = $('#adoctors1').val();
            $('#aslots1').find('option').remove();
            // $('#default').trigger("reset");
            /* $.ajax({
                 url: 'schedule/getAvailableSlotByDoctorByDateByAppointmentIdByJason?date=' + date + '&doctor=' + doctorr + '&appointment_id=' + id,
                 method: 'GET',
                 data: '',
                 dataType: 'json',
             }).success(function (response) {
                 var slots = response.aslots;
                 $.each(slots, function (key, value) {
                     $('#aslots1').append($('<option>').text(value).val(value)).end();
                 });
                 //   $("#default-step-1 .button-next").trigger("click");
                 if ($('#aslots1').has('option').length == 0) {                    //if it is blank. 
                     $('#aslots1').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
                 }
                 // Populate the form fields with the data returned from server
                 //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
             });*/
        });
    });

    $(document).ready(function() {
        var id = $('#appointment_id').val();
        var date = $('#date1').val();
        var doctorr = $('#adoctors1').val();
        $('#aslots1').find('option').remove();
        // $('#default').trigger("reset");
        /* $.ajax({
             url: 'schedule/getAvailableSlotByDoctorByDateByAppointmentIdByJason?date=' + date + '&doctor=' + doctorr + '&appointment_id=' + id,
             method: 'GET',
             data: '',
             dataType: 'json',
         }).success(function (response) {
             var slots = response.aslots;
             $.each(slots, function (key, value) {
                 $('#aslots1').append($('<option>').text(value).val(value)).end();
             });
             //   $("#default-step-1 .button-next").trigger("click");
             if ($('#aslots1').has('option').length == 0) {                    //if it is blank. 
                 $('#aslots1').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
             }
             // Populate the form fields with the data returned from server
             //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
         });*/

    });




    $(document).ready(function() {
        $('#date1').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
            })
            //Listen for the change even on the input
            .change(dateChanged1)
            .on('changeDate', dateChanged1);
    });

    function dateChanged1() {
        // Get the record's ID via attribute  
        var id = $('#appointment_id').val();
        var iid = $('#date1').val();
        var doctorr = $('#adoctors1').val();
        $('#aslots1').find('option').remove();
        // $('#default').trigger("reset");
        /* $.ajax({
             url: 'schedule/getAvailableSlotByDoctorByDateByAppointmentIdByJason?date=' + iid + '&doctor=' + doctorr + '&appointment_id=' + id,
             method: 'GET',
             data: '',
             dataType: 'json',
         }).success(function (response) {
             var slots = response.aslots;
             $.each(slots, function (key, value) {
                 $('#aslots1').append($('<option>').text(value).val(value)).end();
             });
             //   $("#default-step-1 .button-next").trigger("click");
             if ($('#aslots1').has('option').length == 0) {                    //if it is blank. 
                 $('#aslots1').append($('<option>').text('No Further Time Slots').val('Not Selected')).end();
             }


             // Populate the form fields with the data returned from server
             //  $('#default').find('[name="staff"]').val(response.appointment.staff).end()
         });*/

    }
</script>



<script>
    $(document).ready(function() {
        var table = $('#editable-sample').DataTable({
            responsive: true,
            fixedHeader: true,
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
                    // columns: [0,1],
                    // }
                    // },
                    // {
                    // extend: 'pdfHtml5',
                    // className: 'dt-button-icon-left dt-button-icon-pdf',
                    // exportOptions: {
                    // columns: [0,1],
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
                [0, "desc"]
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

        table.buttons().container()
            .appendTo('.custom_buttons');
    });
</script>


<script>
    $(document).ready(function() {
        $("#pos_select").select2({
            placeholder: '<?php echo lang('select_patient'); ?>',
            allowClear: true,
            ajax: {
                url: 'patient/getPatientinfoWithAddNewOption',
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
        $(".patient").select2({
            placeholder: '<?php echo lang('select_patient'); ?>',
            allowClear: true,
            ajax: {
                url: 'patient/getPatientinfo',
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
        $("#add_doctor").select2({
            placeholder: '<?php echo lang('select_doctor'); ?>',
            allowClear: true,
            ajax: {
                url: 'doctor/getDoctorWithAddNewOption',
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
    $(document).ready(function() {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>