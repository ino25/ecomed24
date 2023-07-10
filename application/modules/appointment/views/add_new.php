<!-- <style>
    .ui-widget.ui-widget-content {
        display: none !important;
    }
</style> -->
<!--sidebar end-->
<!--main content start-->
<style>
    .datepicker-dropdown {
        margin-bottom: 100px;
        z-index: 1000;
    }
</style>
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel col-md-8 row">
            <header class="panel-heading">
                <?php
                if (!empty($appointment->id))
                    echo lang('edit_appointment');
                else
                    echo lang('add_appointment2');
                $patient_id = ''; if (isset($_GET['patient'])) { $patient_id = $_GET['patient']; }

                 $type = ''; if (isset($_GET['type'])) { $type = $_GET['type']; }
                ?>
            </header>


            <style>
                .panel {
                    background: transparent;
                }

                .payment_label {
                    margin-left: -2%;
                }
            </style>


            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <?php echo validation_errors(); ?>
                    <?php echo $this->session->flashdata('feedback'); ?>
                </div>
                <form role="form" action="appointment/addNew" class="clearfix row" method="post" enctype="multipart/form-data" id="editRdvForm">
                    <div class="col-md-12 panel" style="padding-top:10px;">
                        <div class="col-md-3 payment_label">
                            <label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label>
                        </div>
                        <div class="col-md-9">
                            <select class="form-control m-bot15  pos_select" id="pos_select" name="patient" value=''>
                                <?php if (!empty($patients)) { ?>
                                    <!--    <option value="<?php echo $patients[0]->id; ?>" selected="selected"><?php echo $patients[0]->name . ' ' . $patients[0]->last_name; ?> - <?php echo $patients[0]->phone; ?></option>  -->
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="pos_client clearfix">
                        <!-- <div class="col-md-8 payment pad_bot pull-right">
                            <div class="col-md-3 payment_label"> 
                                <label for="exampleInputEmail1"> <?php echo lang('name'); ?></label>
                            </div>
                            <div class="col-md-9"> 
                                <input type="text" class="form-control pay_in" name="p_name" value='<?php
                                                                                                    if (!empty($payment->p_name)) {
                                                                                                        echo $payment->p_name;
                                                                                                    }
                                                                                                    ?>' placeholder="">
                            </div>
                        </div>
                        <div class="col-md-8 payment pad_bot pull-right">
                            <div class="col-md-3 payment_label"> 
                                <label for="exampleInputEmail1"> <?php echo lang('last_name'); ?></label>
                            </div>
                            <div class="col-md-9"> 
                                <input type="text" class="form-control pay_in" name="last_p_name" value='<?php
                                                                                                            if (!empty($payment->last_p_name)) {
                                                                                                                echo $payment->last_p_name;
                                                                                                            }
                                                                                                            ?>' placeholder="">
                            </div>
                        </div>
                        <div class="col-md-8 payment pad_bot pull-right">
                            <div class="col-md-3 payment_label"> 
                                <label for="exampleInputEmail1"> <?php echo lang('email'); ?></label>
                            </div>
                            <div class="col-md-9"> 
                                <input type="text" class="form-control pay_in" name="p_email" value='<?php
                                                                                                        if (!empty($payment->p_email)) {
                                                                                                            echo $payment->p_email;
                                                                                                        }
                                                                                                        ?>' placeholder="">
                            </div>
                        </div>
                        <div class="col-md-8 payment pad_bot pull-right">
                            <div class="col-md-3 payment_label"> 
                                <label for="exampleInputEmail1"> <?php echo lang('phone'); ?></label>
                            </div>
                            <div class="col-md-9"> 
                                <input type="text" class="form-control pay_in" name="p_phone" value='<?php
                                                                                                        if (!empty($payment->p_phone)) {
                                                                                                            echo $payment->p_phone;
                                                                                                        }
                                                                                                        ?>' placeholder="">
                            </div>
                        </div>
                        <div class="col-md-8 payment pad_bot pull-right">
                            <div class="col-md-3 payment_label"> 
                                <label for="exampleInputEmail1"><?php echo lang('age'); ?></label>
                            </div>
                            <div class="col-md-9"> 
                                <input type="text" class="form-control pay_in" name="p_age" value='<?php
                                                                                                    if (!empty($payment->p_age)) {
                                                                                                        echo $payment->p_age;
                                                                                                    }
                                                                                                    ?>' placeholder="">
                            </div>
                        </div> 
                        <div class="col-md-8 payment pad_bot pull-right">
                            <div class="col-md-3 payment_label"> 
                                <label for="exampleInputEmail1"> <?php echo lang('gender'); ?></label>
                            </div>
                            <div class="col-md-9"> 
                                <select class="form-control m-bot15" name="p_gender" value=''>

                                    <option value="Masculin" <?php
                                                                if (!empty($patient->sex)) {
                                                                    if ($patient->sex == 'Masculin') {
                                                                        echo 'selected';
                                                                    }
                                                                }
                                                                ?> > Masculin </option>   
                                    <option value="Feminin" <?php
                                                            if (!empty($patient->sex)) {
                                                                if ($patient->sex == 'Feminin') {
                                                                    echo 'selected';
                                                                }
                                                            }
                                                            ?> > Feminin </option>
                                </select>
                            </div>
                        </div> -->
                    </div>
                    <div class="col-md-12 panel">
                        <div class="col-md-3 payment_label">
                            <label for="exampleInputEmail1"> <?php echo lang('service'); ?></label>
                        </div>
                        <div class="col-md-9">

                            <select class="form-control m-bot15  add_service" id="idservice_add" name="service" required="">

                            </select>
                        </div>
                    </div>
                    <!-- <div class="col-md-12 panel">
                        <div class="col-md-3 payment_label"> 
                            <label for="exampleInputEmail1">  <?php echo lang('doctor'); ?></label>
                        </div>
                        <div class="col-md-9"> 
                            <select class="form-control m-bot15" id="adoctors" name="doctor" value=''>  
                                <?php if (!empty($doctors)) { ?>
                                  
                                <?php } ?>
                            </select>
                        </div>
                    </div>-->


                    <div class="col-md-12 panel">
                        <div class="col-md-3 payment_label">
                            <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                        </div>
                        <div class="col-md-9 panel">
                                <input type="text" class="form-control form-control-inline input-medium dateRDV" id="date_add"  name="date" value='' placeholder="" autocomplete="off" required="">
                   
                        </div>
                    </div>

                    <div class="col-md-12 panel">
                        <div class="col-md-3 payment_label">
                            <label class=""><?php echo lang('available_slots'); ?></label>
                        </div>
                        <div class="col-md-9">
                          <select class="form-control m-bot15" name="time_slot" id="aslots_add"> 

                        </select>
                        </div>
                    </div>


                    <div class="col-md-12 panel">
                        <div class="col-md-3 payment_label">
                            <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='<?php
                                                                                                                    if (!empty($appointment->remarks)) {
                                                                                                                        echo $appointment->remarks;
                                                                                                                    }
                                                                                                                    ?>' placeholder="">
                        </div>
                    </div>


                    <div class="col-md-12 panel">
                        <div class="col-md-3 payment_label">
                            <label for="exampleInputEmail1"> <?php echo lang('appointment'); ?> <?php echo lang('status'); ?></label>
                        </div>
                        <div class="col-md-9">
                            <select class="form-control m-bot15" name="status" value=''>
                                <option value="Pending Confirmation" <?php
                                                                        if (!empty($appointment->status)) {
                                                                            if ($appointment->status == 'Pending Confirmation') {
                                                                                echo 'selected';
                                                                            }
                                                                        }
                                                                        ?>> <?php echo lang('pending_confirmation'); ?> </option>
                                <option value="Confirmed" <?php
                                                            if (!empty($appointment->status)) {
                                                                if ($appointment->status == 'Confirmed') {
                                                                    echo 'selected';
                                                                }
                                                            }
                                                            ?>> <?php echo lang('confirmed'); ?> </option>
                               
                             
                            </select>
                        </div>
                    </div>

                    <!--     <div class="col-md-12 panel">
                         <div class="col-md-3 payment_label"> 
                         </div>
                         <div class="col-md-9"> 
                             <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br>
                         </div>
                     </div>
                    -->





                    <input type="hidden" name="id" id="appointment_id" value='<?php
                                                                                if (!empty($appointment->id)) {
                                                                                    echo $appointment->id;
                                                                                }
                                                                                ?>'>

                    <div class="col-md-12 panel">
                        <div class="col-md-3 payment_label">
                        </div>
                        <div class="col-md-9">
                                    <a href="appointment" class="btn btn-info btn-secondary pull-left"> <?php echo lang('close'); ?></a>
                      
                            <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                        </div>
                    </div>


                </form>
            </div>

        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->


<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/appointment.js"></script>
<script>
    $(document).ready(function() {
         document.getElementById('redirectaddNew').value = 'appointment/addNewView';
  
        $('.pos_client').hide();
        $(document.body).on('change', '#pos_select', function() {

            var v = $("select.pos_select option:selected").val()
            if (v == 'add_new') {
                $('#myModaladdPatient').modal('show');
                // $('.pos_client').show();
            } else {
                // $('.pos_client').hide();
            }
        });
   var is_patient = '<?php echo $patient_id; ?>';
   if(is_patient){
              $.ajax({
                    url: 'patient/editPatientByJason?id=' + is_patient,
                    method: 'GET',
                    data: '',
                    dataType: 'json'
                }).success(function (response) {
        var name =  response.patient.name +' '+response.patient.last_name + '  (Code Patient: ' + response.patient.patient_id + ')';
                    var patient_opt = new Option(name, response.patient.id, true, true);
                    $('#editRdvForm').find('[name="patient"]').append(patient_opt).trigger('change');
                      });
   }

    var is_type = '<?php echo $type; ?>';
    if(is_type){ $('#myModaladdPatient').modal('show'); }
    });
</script>


<?php if (!empty($appointment->id)) { ?>


<?php } else { ?>

    <script type="text/javascript">
     

        $(document).ready(function() {
         /*   $('#date').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                });*/
        });

    </script>

<?php } ?>

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
        $("#idservice_add").select2({
            placeholder: '<?php echo lang('select_service'); ?>',
            allowClear: true,
            ajax: {
                 // url: 'services/getSericeinfoByJason',
				url: 'services/getServicesRdvByJson',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });
    });
</script>