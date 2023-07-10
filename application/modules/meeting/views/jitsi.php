<style>
.round.round-lg {
    height: 32px;
    width: 32px;
    text-align:center;
	color:white;
    -moz-border-radius: 20px;
    border-radius: 20px;
    font-size: 1.5em;
}
.appoint{
	border: 2px solid gainsboro;
    border-left: none;
    border-right: none;
    padding: 14px 15px;
    text-align: justify;
}
.padding{
   padding :0px;
}
.mb-20{
	margin-bottom:20px;
	overflow:hidden;
}
.round.blue {
    background-color: #3EA6CE;
}
@media ( min-width: 768px ) {
    .grid-divider {
        position: relative;
        padding: 0;
    }
    .grid-divider>[class*='col-'] {
        position: static;
    }
    .grid-divider>[class*='col-']:nth-child(n+2):before {
        content: "";
        border-left: 1px solid #DDD;
        position: absolute;
        top: 0;
        bottom: 0;
    }
    .col-padding {
        padding: 0 15px;
    }
}

</style>
<section id="main-content">
    <section class="wrapper site-min-height">

        <?php
        $appointment_details = $this->appointment_model->getAppointmentById($appointmentid,$id_organisation);
        $doctor_details = $this->doctor_model->getDoctorById($appointment_details->doctor); 
        $doctor_name  =''; if(isset($doctor_details)) { $doctor_name = $doctor_details->name; }
        $patient_details = $this->patient_model->getPatientById($appointment_details->patient,$id_organisation);
        $patient_name = $patient_details->name .' '.$patient_details->last_name;
        $patient_phone = $patient_details->phone;
        $patient_email = $patient_details->email;
        $patient_id = $appointment_details->patient;
        $service = $this->service_model->getServiceById($appointment_details->service)->name_service; 

        $display_name = $this->ion_auth->user()->row()->username;
        $email = $this->ion_auth->user()->row()->email;
        $userloginid = $this->ion_auth->user()->row()->id;
		
        ?>


        <!-- page start-->
        <section class="col-md-8">

         <div class="thumbnail">
            <!--<header class="panel-heading">
                <h3><?php echo lang('live'); ?></h3>
            </header>-->

                <div class="">
					<div class="tab-content"  id="meeting">
						<input type="hidden" name="appointmentid" id="appointmentid"value="<?php echo $appointmentid; ?>">
						<input type="hidden" name="username" id="username"value="<?php echo $display_name; ?>">
						<input type="hidden" name="email" id="email" value="<?php echo $email; ?>">
					</div>
                </div>
         </div>
		 <section>
		<div class='thumbnail'>
				<form id='notes_taking' method='post' action="">
				<input type='hidden' name='patient_id' value='<?php echo  $patient_id;?>'>
				<input type='hidden' name='patient_name' value='<?php echo  $patient_name;?>'>
				<input type='hidden' name='id_organisation' value='<?php echo  $id_organisation;?>'>
				<input type='hidden' name='patient_phone' value='<?php echo $patient_phone;?>'>
				<input type='hidden' name='doctor_id' value='<?php echo $userloginid;?>'>
			  <div class="form-group">
				<label for="note_desc">Description</label>
				<textarea class="form-control ckeditor" id="note_desc" name="note_desc" rows="20" cols="20"></textarea>
			  </div>
		      <div class='form-group text-right'>
			 <span class='notes_loader' style='vertical-align:middle'></span> <button type='submit' class='btn btn-primary take_notes'> Valider </button>
			  </div>
			  </form>
			</div>
		</section>
        </section>
        <section class="col-md-4">
            <!--<header class="panel-heading">
                <?php echo lang('appointment'); ?> <?php echo lang('details'); ?> 
            </header>

            <div class="">
                <div class="tab-content"  id="">
                    <aside class="profile-nav">
                        <section class="">


                            <ul class="nav nav-pills nav-stacked">-->
                              <!--  <li class="active"> <?php echo lang('doctor'); ?> <?php echo lang('name'); ?><span class="label pull-right r-activity"><?php echo $doctor_name; ?></span></li> -->
                               <!-- <li>  <?php echo lang('service'); ?> <span class="label pull-right r-activity"><?php echo $service; ?></span></li>
                                <li>  <?php echo lang('patient'); ?>  <span class="label pull-right r-activity"><?php echo $patient_name; ?></span></li>
                              
                                <li>   <?php echo lang('date'); ?> <span class="label pull-right r-activity"><?php echo date('d/m/Y', $appointment_details->date); ?></span></li>
                                <li> <?php echo lang('hour'); ?><span class="label pull-right r-activity"><?php echo $appointment_details->time_slot; ?></span></li>
                            </ul>

                        </section>
                    </aside>
                </div>
            </div>-->
		   <!--<div class="page-header">
				<h3>Dossier Patient</h3>
			</div>-->
    <div class=" patient_full_details grid-divider">
		<div class="col-sm-12 padding part_1">
		  <div class="col-padding">
			<div class="mb-20">
			<div class="col-sm-1 padding">
				<div class="round  round-lg blue">
				   <span> 1 </span>
				</div>
			</div>
			<div class='col-sm-11' style='padding-top:6px'><h4 class='request_title'>Demander l'accès au dossier</h4>
			</div>
			</div>
			
			<div class='col-sm-12 padding' style="border: 2px solid gainsboro;padding: 24px 0px;">
			   <div class="mb-20">
			   <div class="col-sm-6">
				 <p><strong> <?php echo $patient_name; ?> </strong></p>
			   </div>
			   <div class="col-sm-6">
				<p><strong> <?php echo $this->ion_auth->maskAllButLast4($patient_phone); ?> </strong> </p>
			   </div>
			   </div>
			   
			   <div class='col-sm-12 mb-20 appoint'>
				<h4>Commentaires du rendez-vous</h4>
				
				<p><?php echo $appointment_details->remarks != "" ? $appointment_details->remarks : "Non fourni"; ?></p>	
			   
			   </div>
			   
			   <div class='col-sm-12 change_section text-center'>
			   <form>
				<input type="hidden" name="patient_email" id="patient_email" value="<?php echo $patient_email; ?>" />
				<input type="hidden" name="patient_phone" id="patient_phone" value="<?php echo $patient_phone; ?>" />
				<input type="hidden" name="patient_id" id="patient_id" value="<?php echo $patient_id; ?>" />
				<button  type='submit' class='btn btn-primary btn_request_access'>Demander l'accès</button>
				</form>
			   </div>
			
			</div>
		  </div>
		</div>
	</div>
        </section>


        <!-- page end-->
    </section>
</section>


<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('details_medical'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="medical_historyEditForm" class="clearfix row" action="patient/addMedicalHistory" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="" readonly="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                        <?php $patientnom = ''; if(isset($patient)) { $patientnom = $patient->name.' '.$patient->last_name; } ?>
                        <input type="text" class="form-control form-control-inline input-medium" name="patient" id="exampleInputEmail1" value='<?php echo $patientnom; ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-13">
                        <label for="exampleInputEmail1"><?php echo lang('title'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium" name="title" id="exampleInputEmail1" value='' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-12">
                        <label class=""><?php echo lang('observation_medical'); ?></label>
                        <div class="">
                            <textarea class="ckeditor form-control editor" id="editor" name="description" value="" rows="4" readonly></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 invoice_footer">
                        <div class="row pull-left">
                            <strong><?php echo lang('effectuer_par'); ?> : </strong>
                        </div><br>
                        <div class="row pull-left"  id="effectuer_par">

                       
                        </div>
                    </div>
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

<div class="modal fade" id="datalabModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
    <div class="modal-content" id="datalab">
            
    </div>
	</div>
</div>
	  
<script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"
></script>


<script src="https://meet.jit.si/external_api.js"></script>
<script>
    $(document).ready(function () {
        //  console.log($('#email').val());
        const domain = "teleconsultation.ecomed24.com";
        document.getElementById('meeting');
        const options = {
            roomName: "<?php echo $appointment_details->room_id; ?>",
            height: 500,
            parentNode: document.querySelector("#meeting"),
            userInfo: {
                email: $('#email').val(),
                displayName: $('#username').val()
            },
            enableClosePage: true,
            SHOW_PROMOTIONAL_CLOSE_PAGE: true,
            // ALWAYS_TRUST_MODE_ENABLED=true
        };
        const api = new JitsiMeetExternalAPI(domain, options);
    });
</script> 

<style>
.dataTables_wrapper .dataTables_filter input {
	margin-top:15px;
	width:200px !important;
}
</style>