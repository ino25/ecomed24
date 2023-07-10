

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/appointment.js"></script>

<style>
    .ui-widget.ui-widget-content {
        display: none !important;
    }
	.panel-heading{
		background:#e6e9ed;
	}
	.panel-group {
	margin-bottom: 0;
	}
	.mytextarea{
	width: 100%;
	border: 1px solid gainsboro;
	padding: 8px 12px;
	}
	.panel-group .panel {
	border-radius: 0;
	box-shadow: none;
	}
	.panel-group .panel .panel-heading {
	padding: 0;
	}
	.panel-group .panel .panel-heading h4 a {
	background: #f6f9fc;
	display: block;
	font-size: 15px;
	line-height: 20px;
	padding: 15px;
	text-decoration: none;
	transition: 0.15s all ease-in-out;
	}
	.panel-group .panel .panel-heading h4 a:hover, .panel-group .panel .panel-heading h4 a:not(.collapsed) {
	/*background: #fff;*/
	transition: 0.15s all ease-in-out;
	}
	.panel-group .panel .panel-heading h4 a:not(.collapsed) i:before {
	content: "-";
	font-size: 30px;
	line-height: 10px;
	}
	.panel-group .panel .panel-heading h4 a i {
	color: #999;
	font-size: 12px;
	}
	.panel-group .panel .panel-body {
	padding-top: 0;
	}
	.panel-group .panel .panel-heading + .panel-collapse > .list-group,
	.panel-group .panel .panel-heading + .panel-collapse > .panel-body {
	border-top: none;
	border: 1px solid gainsboro;
	border-top: none;
	}
	.panel-group .panel + .panel {
	border-top: none;
	margin-top: 0;
	}
	.dataTables_wrapper .dataTables_filter input{
	width:148px !important;
	}
	
	.panel-group .panel .panel-body.patient-table {
		width:90% !important;
	}
	.panel-group .panel .panel-body {
		width:100%;
		overflow-x:scroll;
		font-size:80%;
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
                    <?php //echo lang('patient_info2'); ?>
					<?php echo lang('dossier'); ?> | <?php echo $patient->name . ' ' . $patient->last_name; ?>
                </div>

            </header>
            <aside class="profile-nav">
                <section class="row">
					<div class='col-sm-4'>
						<div class="user-heading round ">
							<div class="user-img-circle">
								<img class="avatar" src="<?php echo !empty($patient->img_url) ? $patient->img_url : 'uploads/imgUsers/contact-512.png' ?>" alt="" style="max-width: 110px; max-height: 110px;">
							</div>
							<p> <?php echo $patient->phone; ?> </p>
							<?php if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Receptionist','adminmedecin'))) { ?>
								<button type="button" class="btn btn-info btn-xs btn_width editPatient" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $patient->id; ?>"><i class="fa fa-edit"> </i> <?php echo lang('edit'); ?></button>
							<?php } ?>
						</div>
					</div>
					<div class='col-sm-4' style="padding:65px">
						<ul class="nav nav-pills nav-stacked">
							<li class="text-center"> <?php echo $patient->name . ' ' . $patient->last_name; ?> </li>
							<li> <?php echo lang('gender'); ?><span class="label pull-right r-activity"><?php echo $patient->sex; ?></span></li>
						</ul>
					</div>
					<div class='col-sm-4' style="padding:65px">
						<ul class="nav nav-pills nav-stacked">
							<!--  <li class="active"> <?php echo lang('patient'); ?> <?php echo lang('name') . ' ' . lang('last_name'); ?><span class="label pull-right r-activity"><?php echo $patient->name; ?></span></li> -->
							<li> <?php echo lang('patient_id'); ?> <span class="label pull-right r-activity"><?php echo $patient->patient_id; ?></span></li>
							<li> <?php echo lang('birth_date'); ?><span class="label pull-right r-activity"><?php echo str_replace('-', '/', $patient->birthdate); ?></span></li>
							<!--<li> <?php echo lang('email'); ?><span class="label pull-right r-activity"><?php echo $patient->email; ?></span></li>
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
								<li class="pos_matriculeinfo" style="height: 300px;display: none"> <?php echo lang('religion'); ?><span class="pull-right" style="height: 200px;"><?php echo $patient->religion; ?></span></li>-->
						</ul>
					</div>
                </section>
            </aside>
			</div>
        </section>
        <section class="col-md-12">
			<div class="thumbnail">
				<div class="row">
					<div class='col-sm-4'>
						<header class="panel-heading clearfix">
							<div>Fiche Patient</div>
						</header>
						<!--<div class="pxlr-club-faq">-->
							<!--<div class="content">-->
								<div class="panel-group" id="accordion" role="tablist"
									aria-multiselectable="true">
									<div class="panel panel-default">
										<div class="panel-heading" id="headingOne" role="tab">
											<h4 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse"
													data-parent="#accordion" href="#collapseOne"
													aria-expanded="false" aria-controls="collapseOne">Informations personnelles <i
													class="pull-right fa fa-plus"></i></a>
											</h4>
										</div>
										<div class="panel-collapse collapse" id="collapseOne" role="tabpanel"
											aria-labelledby="headingOne">
											<div class="panel-body pxlr-faq-body">
												<!--<p><b> <?php echo lang('birth_position'); ?> : </b> <?php echo str_replace('-', '/', $patient->birthdate); ?> </p>-->
												<p><b> <?php echo lang('birth_position'); ?> : </b> <?php echo $patient->birth_position ; ?> </p>
												<p><b> <?php echo lang('address'); ?> : </b> <?php echo $patient->address; ?> </p>
												<p><b> Ville : </b> </p>
												<p><b> <?php echo lang('region'); ?> : </b> <?php echo $patient->region; ?> </p>
												<p><b> <?php echo lang('email'); ?> : </b> <?php echo $patient->email; ?> </p>
												<p><b> <?php echo lang('phoneNumber'); ?> : </b> <?php echo $patient->phone_contact; ?> </p>
												<!--<p><b> Name : </b> <?php echo $patient->email; ?> </p>-->
												<p><b> <?php echo lang('matricule'); ?> : </b> <?php echo $patient->matricule; ?> </p>
												<p><b> <?php echo lang('grade'); ?> : </b> <?php echo $patient->grade; ?> </p>
												<p><b> <?php echo lang('nom_contact'); ?> : </b> <?php echo $patient->nom_contact; ?></p>
												<p><b> <?php echo lang('phone_contact'); ?> : </b> <?php echo $patient->phone_contact; ?></p>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" id="headingTwo" role="tab">
											<h4 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse"
													data-parent="#accordion" href="#collapseTwo"
													aria-expanded="false" aria-controls="collapseTwo">Signes vitaux <i
													class="pull-right fa fa-plus"></i></a>
											</h4>
										</div>
										<div class="panel-collapse collapse" id="collapseTwo" role="tabpanel"
											aria-labelledby="headingTwo">
											<div class="panel-body pxlr-faq-body">
												<p><b>Informations M&eacute;dicales</b></p>
												<ul type='circle'>
													<li><b><?php echo lang('blood_group'); ?> : </b> <?php echo $patient->bloodgroup;?> </li>
													<li><b><?php echo lang('height'); ?> : </b>  </li>
													<li><b><?php echo lang('weight'); ?> : </b>  </li>
													<li><b><?php echo lang('breast'); ?> : </b></li>
													<li><b><?php echo lang('temperature'); ?> : </b> </li>
													<li><b><?php echo lang('blood_pressure'); ?> : </b>  </li>
													<li><b><?php echo lang('respiration'); ?> : </b>  </li>
													<li><b><?php echo lang('pulse'); ?> : </b>  </li>
													<li><b><?php echo lang('vision'); ?> : </b>  </li>
													<li><b><?php echo lang('audition'); ?> : </b>  </li>
												</ul>
												<p><b>Allergies</b></p>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" id="headingThree" role="tab">
											<h4 class="panel-title"><a class="collapsed" role="button"
												data-toggle="collapse"
												data-parent="#accordion"
												href="#collapseThree"
												aria-expanded="false"
												aria-controls="collapseThree"><?php echo lang('known_pre_conditions'); ?> <i
												class="pull-right fa fa-plus"></i></a></h4>
										</div>
										<div class="panel-collapse collapse" id="collapseThree" role="tabpanel"
											aria-labelledby="headingThree">
											<div class="panel-body pxlr-faq-body">
												<?php if (!$this->ion_auth->in_group('Patient')) { ?>
												<div class=" no-print">
													<a class="btn btn-info btn_width btn-xs pull" data-toggle="modal" href="#add-pre-conditions">
													<i class="fa fa-plus-circle"> </i> <?php echo lang('add'); ?>
													</a>
												</div>
												<?php } if(count($pre_conditions) > 0 ){
													foreach($pre_conditions as $medi){
													?>
												<p><?php echo $medi['content'];?></p>
												<p><span class="label label-default"><i class="fa fa-clock"></i> <?php echo date('d , M Y  h:i:s A',strtotime($medi['date_time']));?> </span></p>
												<?php } }else{ ?>
												<p><b><?php echo lang('none_yet_f'); ?>!</b></p>
												<?php } ?>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" id="headingThree" role="tab">
											<h4 class="panel-title"><a class="collapsed" role="button"
												data-toggle="collapse"
												data-parent="#accordion"
												href="#collapseFour"
												aria-expanded="false"
												aria-controls="collapseThree"><?php echo lang('current_medication'); ?><i
												class="pull-right fa fa-plus"></i></a></h4>
										</div>
										<div class="panel-collapse collapse" id="collapseFour" role="tabpanel"
											aria-labelledby="headingThree">
											<div class="panel-body pxlr-faq-body">
												<?php if (!$this->ion_auth->in_group('Patient')) { ?>
												<div class=" no-print">
													<a class="btn btn-info btn_width btn-xs pull" data-toggle="modal" href="#addcurrentMedication">
													<i class="fa fa-plus-circle"> </i> <?php echo lang('add'); ?>
													</a>
												</div>
												<?php } 
													if(count($current_medications) > 0 ){
														foreach($current_medications as $medi){
													?>
												<p><?php echo $medi['content'];?></p>
												<p><span class="label label-default"><i class="fa fa-clock"></i> <?php echo date('d , M Y  h:i:s A',strtotime($medi['date_time']));?> </span></p>
												<?php } }else{ ?>
												<p><b><?php echo lang('none_yet_m'); ?>!</b></p>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							<!--</div>-->
						<!--</div>-->
					</div>
					<div class='col-sm-4'>
						<header class="panel-heading clearfix">
							<div><?php echo lang('medical_history2'); ?></div>
						</header>
						<div class="pxlr-club-faq">
							<div class="content">
								<div class="panel-group" id="accordion" role="tablist"
									aria-multiselectable="true">
									<div class="panel panel-default">
										<div class="panel-heading" id="headingOne" role="tab">
											<h4 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse"
													data-parent="#accordion" href="#infocollapseOne"
													aria-expanded="false" aria-controls="collapseOne"><?php echo lang('appointments'); ?> <i
													class="pull-right fa fa-plus"></i></a>
											</h4>
										</div>
										<div class="panel-collapse collapse" id="infocollapseOne" role="tabpanel"
											aria-labelledby="headingOne">
											
											<div class="panel-body pxlr-faq-body" style="">
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
												
												<div class="adv-table editable-table " id="div-consultation">
												
												<script>
												// alert("ok");
												// alert($("#table-consultation").html());	
												// alert($("#div-consultation").html());	
												// alert($("#table-consultation").css("width"));	
												// alert($("#div-consultation").css("width"));	
												</script>
												
												<table class="table table-hover progress-table text-center_ patient-table" id="table-consultation">
													<thead>
														<tr>
															<th style=""><?php echo lang('date'); ?></th>
															<!--<th style=""><?php echo lang('time_slot'); ?></th>-->
															<th style=""><?php echo "Horaire" ?></th>
															<th style=""><?php echo lang('service'); ?></th>
															<th style=""><?php echo lang('status'); ?></th>
															<th style="" class="no-print">
															<?php if (!$this->ion_auth->in_group('Patient')) { ?>
															<?php echo lang('options'); ?>
															<?php } ?>
															</th>
														</tr>
													</thead>
													<tbody>
														<?php 
															foreach ($appointments as $appointment) {
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
															<td style=""><?php echo date('d/m/y', $appointment->date); ?></td>
															<td style=""><?php echo $appointment->time_slot; ?></td>
															<td style=""><?php echo $appointment->servicename; ?></td>
															<td style=""><?php echo $status; ?></td>
															<td  style="" class="no-print">
															<?php if ($this->ion_auth->in_group('Doctor')) { ?>
																<?php if ($appointment->status == 'Pending Confirmation' || $appointment->status == 'Confirmed' ) { ?>
																<button type="button" class="btn btn-info btn-xs btn_width editAppointmentButton" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $appointment->id; ?>"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></button>
																<?php if ($appointment->status == 'Confirmed' ) { ?>
																<a class="btn btn-info btn-xs btn_width detailsbutton" title=" <?php echo lang('start_live');  ?>" style="color: #fff;" href="meeting/instantLive?id=<?php echo $appointment->id; ?>" target="_blank" ><i class="fa fa-headphones"></i> <?php echo lang('live'); ?> </a>
																<?php } ?>  <?php } ?>
															<?php } ?>
															</td>
														</tr>
														<?php }  ?>
													</tbody>
												</table>
												
												<script>
												// alert("ok");
												// alert($("#table-consultation").html());	
												// alert($("#div-consultation").html());	
												// alert($("#table-consultation").css("width"));	
												// alert($("#div-consultation").css("width"));	
												</script>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" id="headingTwo" role="tab">
											<h4 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse"
													data-parent="#accordion" href="#infocollapseTwo"
													aria-expanded="false" aria-controls="collapseTwo">Consultations  <i
													class="pull-right fa fa-plus"></i></a>
											</h4>
										</div>
										<div class="panel-collapse collapse" id="infocollapseTwo" role="tabpanel"
											aria-labelledby="headingTwo">
											<?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
											<div class=" no-print">
												<span class="btn btn-info btn_width btn-xs addConsultation"  id="addConsultation" data-id="<?php echo $patient->id; ?>">
												<i class="fa fa-plus-circle"> </i> <?php echo lang('add'); ?>
												</span>
											</div>
											<?php } ?>
											<div class="panel-body pxlr-faq-body">
												<table class="table table-hover progress-table text-center_ patient-table" id="">
													<thead>
														<tr>
															<th><?php echo lang('date'); ?></th>
															<th><?php echo lang('libelle'); ?></th>
															<th><?php echo lang('cons_patient'); ?></th>
															<th><?php echo lang('cons_effectuer'); ?></th>
															<?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
															<th class="no-print"><?php echo lang('options'); ?></th>
															<?php } ?>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($medical_histories as $medical_history) { ?>
														<tr class="">
															<td><?php echo date('d/m/Y H:i', $medical_history->date); ?></td>
															<td><?php echo $medical_history->title; ?></td>
															<td><?php echo $medical_history->patient_name.' '.$medical_history->patient_last_name; ?></td>
															<td><?php echo $medical_history->first_name.' '.$medical_history->last_name; ?></td>
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
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" id="headingThree" role="tab">
											<h4 class="panel-title"><a class="collapsed" role="button"
												data-toggle="collapse"
												data-parent="#accordion"
												href="#infocollapseThree"
												aria-expanded="false"
												aria-controls="infocollapseThree">Analyses Labo <i
												class="pull-right fa fa-plus"></i></a></h4>
										</div>
										<div class="panel-collapse collapse" id="infocollapseThree" role="tabpanel"
											aria-labelledby="headingThree">
											<div class="panel-body pxlr-faq-body">
												<table class="table table-hover progress-table text-center patient-table" id="">
													<thead>
														<tr>
															<th><?php echo lang('id'); ?></th>
															<th><?php echo lang('date'); ?></th>
															<th class="no-print"><?php echo lang('options'); ?></th>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($labs as $lab) { ?>
														<tr class="">
															<td><?php echo $lab->code; ?></td>
															<td><?php echo date('d/m/Y', $lab->date); ?></td>
															<td class="no-print">
																<span class="btn btn-info btn-xs btn_width editlab" data-id="<?php echo $lab->id; ?>" ><i class="fa fa-eye"></i> <?php echo lang('report_'); ?></span>
															</td>
														</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" id="headingThree" role="tab">
											<h4 class="panel-title"><a class="collapsed" role="button"
												data-toggle="collapse"
												data-parent="#accordion"
												href="#inffcollapseFour"
												aria-expanded="false"
												aria-controls="inffcollapseFour"><?php echo lang('medical_documents'); ?><i
												class="pull-right fa fa-plus"></i></a></h4>
										</div>
										<div class="panel-collapse collapse" id="inffcollapseFour" role="tabpanel"
											aria-labelledby="headingThree">
											<div class="panel-body pxlr-faq-body">
												<div class=" no-print">
													<a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#myModal1">
													<i class="fa fa-plus-circle"> </i> <?php echo lang('add'); ?>
													</a>
												</div>
												<div class="adv-table editable-table ">
													<div class="">
														<?php foreach ($patient_materials as $patient_material) { ?>
														<div class="col-md-12" style="background: #f1f1f1;padding:8px 8px;margin-bottom12px;border-bottom:1px solid gainsboro;">
															<div class="col-sm-4">
																<a class="example-image-link" href="<?php echo $patient_material->url; ?>" data-lightbox="example-1">
																<img class="example-image" src="<?php echo $patient_material->url; ?>" alt="image-1" height="100" width="100" /></a>
																<!--  <img src="<?php echo $patient_material->url; ?>" height="100" width="100">-->
															</div>
															<div class="col-sm-8">
																<?php
																	if (!empty($patient_material->title)) {
																		echo $patient_material->title;
																	}
																	?>
															</div>
															<p></p>
															<div class="col-sm-12">
																<a class="btn btn-info btn-xs " href="<?php echo $patient_material->url; ?>" download> <?php echo lang('download'); ?> </a>
																<?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
																<a class="btn btn-info btn-xs" title="<?php echo lang('delete'); ?>" href="patient/deletePatientMaterial?id=<?php echo $patient_material->id; ?>" onclick="return confirm('<?php echo lang('confirm_delete'); ?>');"> X </a>
																<?php } ?>
															</div>
														</div>
														<?php } ?>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" id="headingThree" role="tab">
											<h4 class="panel-title"><a class="collapsed" role="button"  data-toggle="collapse"
												data-parent="#accordion"
												href="#infocollapseFour"
												aria-expanded="false"
												aria-controls="infocollapseFour">Ordonnance (Prescription)<i
												class="pull-right fa fa-plus"></i></a></h4>
										</div>
										<div class="panel-collapse collapse" id="infocollapseFour" role="tabpanel"
											aria-labelledby="headingThree">
											<div class="panel-body pxlr-faq-body">
												<?php if ($this->ion_auth->in_group(array('Doctor'))) { ?>
												<div class=" no-print">
													<a class="btn btn-info btn_width btn-xs" href="prescription/addPrescriptionView">
													<i class="fa fa-plus-circle"> </i> <?php echo lang('add'); ?>
													</a>
												</div>
												<?php } ?>
												<div class="adv-table editable-table ">
													<table class="table table-hover progress-table text-center patient-table" id="">
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
																		if ($this->ion_auth->in_group('Doctor')) {
																			$current_user = $this->ion_auth->get_user_id();
																			$doctor_table_id = $this->doctor_model->getDoctorByIonUserId($current_user)->id;
																			if ($prescription->doctor == $doctor_table_id) {
																		?>
																	<a type="button" class="btn-info btn-xs btn_width" data-toggle="modal" href="prescription/editPrescription?id=<?php echo $prescription->id; ?>"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></a>
																	<a class="btn-info btn-xs btn_width delete_button" href="prescription/delete?id=<?php echo $prescription->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> <?php echo lang('delete'); ?></a>
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
									</div>
									<!--<div class="panel panel-default">
										<div class="panel-heading" id="headingThree" role="tab">
											<h4 class="panel-title"><a class="collapsed" role="button"  data-toggle="collapse"
																	   data-parent="#accordion"
																	   href="#collapseFour"
																	   aria-expanded="false"
																	   aria-controls="collapseThree">Other medical documents<i
															class="pull-right fa fa-plus"></i></a></h4>
										</div>
										<div class="panel-collapse collapse" id="collapseFour" role="tabpanel"
											 aria-labelledby="headingThree">
											<div class="panel-body pxlr-faq-body">
										<p>Anim pariatur cliche reprehenderit, enim eiusmod high life
													accusamus terry richardson ad squid. 3 wolf </p>
											</div>
										</div>
										</div>-->
								</div>




							</div>
						</div>
					</div>
					<div class='col-sm-4'>
						<header class="panel-heading clearfix">
							<div>Administration</div>
						</header>
						<div class="pxlr-club-faq">
							<div class="content">
								<div class="panel-group" id="accordion" role="tablist"
									aria-multiselectable="true">
									<div class="panel panel-default">
										<div class="panel-heading" id="headingOne" role="tab">
											<h4 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse"
													data-parent="#accordion" href="#admincollapseOne"
													aria-expanded="false" aria-controls="admincollapseOne"><?php echo lang('mutuelle_relations'); ?><i
													class="pull-right fa fa-plus"></i></a>
											</h4>
										</div>
										<div class="panel-collapse collapse" id="admincollapseOne" role="tabpanel"
											aria-labelledby="headingOne">
											<div class="panel-body pxlr-faq-body">
												<?php if (!$lien_parente) { ?>
												<div class=" no-print right col-md-6">
													<a class="btn btn-info btn_width btn-xs right" data-toggle="modal" href="#myModalPatient">

													<i class="fa fa-plus-circle"> </i> <?php echo lang('add'); ?>
													</a>
												</div>
												<div class=" no-print left col-md-6">
													<select class="form-control m-bot15" id="patient_mutuelle" name="patient_mutuelle">
													</select>
												</div>
												<?php }  ?>
												<div class=" no-print left col-md-6"></div>
												<div class=" no-print right col-md-6 liste_patient_mutuelle" id="liste_patient_mutuelle"></div>
												<div class="adv-table editable-table ">
													<table class="table table-hover progress-table text-center patient-table" id="">
														<thead>
															<tr>
																<th class="text-center"><?php echo lang('name'); ?></th>
																<th class="text-center"><?php echo lang('last_name'); ?></th>
																<th class="text-center"><?php echo lang('birth_date'); ?></th>
																<th class="text-center"><?php echo lang('lien_parente'); ?></th>
																<?php if (!$lien_parente) { ?>
																<th class="no-print text-center"><?php echo lang('options'); ?></th>
																<?php }  ?>
															</tr>
														</thead>
														<tbody>
															<?php foreach ($mutuelles_relation as $key => $value) { ?>
															<tr class="">
																<td><?php echo $value->name; ?></td>
																<td><?php echo $value->last_name; ?></td>
																<td><?php echo str_replace('-', '/', $value->birthdate);  ?></td>
																<td><?php echo $value->lien_parente;  ?></td>
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

																<td><?php echo str_replace('-', '/', $mutuelles_relationInit->birthdate);  ?></td>
																<td><?php echo $lien_parente;  ?></td>
																<?php if (!$lien_parente) { ?>
																<td class="no-print">
																</td>
																<?php }  ?>
															</tr>
															<?php }   ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" id="headingTwo" role="tab">
											<h4 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse"
													data-parent="#accordion" href="#admincollapseTwo"
													aria-expanded="false" aria-controls="admincollapseTwo"><?php echo lang('mutuelles'); ?><i
													class="pull-right fa fa-plus"></i></a>
											</h4>
										</div>
										<div class="panel-collapse collapse" id="admincollapseTwo" role="tabpanel"
											aria-labelledby="headingTwo">
											<div class="panel-body pxlr-faq-body">
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
													<table class="table table-hover progress-table text-center patient-table" id="">
														<thead>
															<tr>
																<th><?php echo lang('nom_mutuelle'); ?></th>
																<th><?php echo lang('num_police'); ?></th>
																<th><?php echo lang('charge_mutuelle'); ?></th>
																<th><?php echo lang('date_valid'); ?></th>
																<?php if ($mutuelles) {  ?> 
																<th class="no-print"><?php echo lang('options'); ?></th>
																<?php }  ?>
															</tr>
														</thead>
														<tbody>
															<?php if ($mutuelles) {  ?>
															<tr class="">
																<td><?php echo $mutuelles->nom; ?></td>
																<td><?php echo $mutuelles->pm_numpolice;  ?></td>
																<td><?php echo $mutuelles->pm_charge;  ?></td>
																<td><?php echo str_replace('-', '/', $mutuelles->pm_datevalid);  ?></td>
																<td class="no-print">
																	<button type="button" class="btn btn-info btn-xs btn_width editbuttonMutuelle" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $mutuelles->idpm; ?>" data-idparent="<?php echo $mutuelles->pm_idpatent; ?>"> <i class="fa fa-edit"></i> </button>
																	<a class="btn btn-info btn-xs btn_width delete_button" title="<?php echo lang('delete'); ?>" href="patient/deleteMutuellePatient?id=<?php echo $mutuelles->idpm; ?>&patient_id=<?php echo $patient->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
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
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" id="headingThree" role="tab">
											<h4 class="panel-title"><a class="collapsed" role="button"
												data-toggle="collapse"
												data-parent="#accordion"
												href="#admincollapseThree"
												aria-expanded="false"
												aria-controls="admincollapseThree"><?php echo lang('payments'); ?><i
												class="pull-right fa fa-plus"></i></a></h4>
										</div>
										<div class="panel-collapse collapse" id="admincollapseThree" role="tabpanel"
											aria-labelledby="headingThree">
											<div class="panel-body pxlr-faq-body">
												<div class="no-print">
													<a  class="btn btn-info btn_width btn-xs pull" href="finance/addPaymentView?patient=<?php echo $patient->id; ?>&type=gen&page=patient">
													<i class="fa fa-plus-circle"></i> <?php echo lang('add'); ?>
													</a>
												</div>
												<div class="adv-table editable-table ">
													<table class="table table-hover progress-table text-center_ patient-table" id="editable-sample">
														<thead>
															<tr>
																<th class=""><?php echo lang('date'); ?></th>
																<th class=""><?php echo lang('invoice'); ?> #</th>
																<th class=""><?php echo lang('amount'); ?></th>
																<!--<th class=""><?php echo lang('deposit'); ?></th>
																	<th class=""><?php echo lang('deposit_type'); ?></th>-->
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
																<td><?php echo date('d/m/Y', $payment->date); ?></td>
																<td> <?php echo $payment->code; ?></td>
																<td><?php echo number_format($payment->gross_total, 0, ",", "."); ?> <?php echo $settings->currency; ?> </td>
																<!--<td>
																	<?php
																		if (!empty($payment->amount_received)) {
																			echo number_format($payment->amount_received, 0, ",", ".") . ' ' . $settings->currency;
																		}
																		?>
																	</td>
																	
																	<!-- <td> <?php echo $payment->deposit_type; ?></td>-->
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
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" id="headingThree" role="tab">
											<h4 class="panel-title"><a class="collapsed" role="button"
												data-toggle="collapse"
												data-parent="#accordion"
												href="#admincollapseFour"
												aria-expanded="false"
												aria-controls="collapseThree"><?php echo lang('documents'); ?>
												<i
													class="pull-right fa fa-plus"></i></a>
											</h4>
										</div>
										<div class="panel-collapse collapse" id="admincollapseFour" role="tabpanel"
											aria-labelledby="headingThree">
											<div class="panel-body pxlr-faq-body">
												<div class=" no-print">
													<a class="btn btn-info btn_width btn-xs" data-toggle="modal" href="#myModal1">
													<i class="fa fa-plus-circle"> </i> <?php echo lang('add'); ?>
													</a>
												</div>
												<div class="adv-table editable-table ">
													<div class="">
														<?php foreach ($patient_materials as $patient_material) { ?>
														<div class="col-md-12" style="background: #f1f1f1;padding:8px 8px;margin-bottom12px;border-bottom:1px solid gainsboro;">
															<div class="col-sm-4">
																<a class="example-image-link" href="<?php echo $patient_material->url; ?>" data-lightbox="example-1">
																<img class="example-image" src="<?php echo $patient_material->url; ?>" alt="image-1" height="100" width="100" /></a>
																<!--  <img src="<?php echo $patient_material->url; ?>" height="100" width="100">-->
															</div>
															<div class="col-sm-8">
																<?php
																	if (!empty($patient_material->title)) {
																		echo $patient_material->title;
																	}
																	?>
															</div>
															<p></p>
															<div class="col-sm-12">
																<a class="btn btn-info btn-xs " href="<?php echo $patient_material->url; ?>" download> <?php echo lang('download'); ?> </a>
																<?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
																<a class="btn btn-info btn-xs" title="<?php echo lang('delete'); ?>" href="patient/deletePatientMaterial?id=<?php echo $patient_material->id; ?>" onclick="return confirm('<?php echo lang('confirm_delete'); ?>');"> X </a>
																<?php } ?>
															</div>
														</div>
														<?php } ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>














							</div>
						</div>


					</div>











				</div>
			
                <div class="form-group col-md-12" style="margin-top:30px;">
                    <a href="patient" name="submit" class="btn btn-info btn-secondary pull-left">Retour</a></div>
			</div>
		</section>

    </section>
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
                    
                       <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo $patient->name; ?><?php echo $patient->last_name; ?></label>
                        <div class=""> <?php echo $patient->sex; ?></div> <div class=""> <?php echo $patient->birthdate; ?></div>
                    </div>
                             <h4 class="text-green mb-4 text-center">Fiche de consultation</h4>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium default-date-picker_" name="date" id="dateCons" value='' placeholder="" readonly="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-12">

                        <label for="exampleInputEmail1"><?php echo lang('motif'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium" name="title" id="exampleInputEmail1" value='' placeholder="" required="">

                    </div>
                    <div class="form-group col-md-12">
                        <label class=""><?php echo lang('description'); ?></label>
                        <div class="">
                            <textarea class="ckeditor form-control" name="description" value="" rows="10" minlength="3" required="" ></textarea>
                        </div>
                    </div>

                    <input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>&type=consultation'>
                    <div class="form-group col-md-12">

                        <div class="form-group col-md-8">   <button type="submit" name="submit" class="btn btn-info submit_button pull-left" id="rediriger">Valider</button><br/>
                      </div> 
                     </div>    
                    <div class="form-group col-md-12">
                        <div class="form-group col-md-8">
                     <!--   <button type="submit" name="submit" class="btn btn-info submit_button pull-left" id="rediriger"><i class="fa fa-plus"></i> Ordonnance</button>
                     
                        <button type="submit" name="submit" class="btn btn-info submit_button pull-right" id="rediriger"><i class="fa fa-plus"></i> Laboratoire</button>-->
                         </div>
                        <div class="form-group col-md-4">
                          
                        <!--     <select class="form-control m-bot15" name="time_slot" id="" required="">
                                  <option value="09h-16h">--  Autres actions --</option>
                        <option value="09h-16h">Enregistrer un Rendez-vous</option>
                        <option value="09h-16h">Transferer chez un medecin</option>
                        <option value="09h-16h">Demande Hospitalisation</option>
                    </select>-->
                        </div>

                   

                    </div>
                    
                      </div>
                <div class="col-sm-6" id="accordion-style-1">
                 
			<div class="row">
				<div class="col-12">
					<h4 class="text-green mb-4 text-center"><?php echo lang('history'); ?>  des consultations</h4>
				</div>
				<div class="col-10 mx-auto">
   <div class="accordion" id="listeConsultation">
						
    
           </div>     </div>                   
                         
    
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
if ($this->ion_auth->in_group(array('Doctor','adminmedecin'))) {
    $tru = $this->db->get_where('doctor', array('ion_user_id' => $current_user))->row();
    if(isset($tru)) {
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

                    <input type="hidden" name="patient"  value='<?php echo $patient->id; ?>'>
                </div>

                <div class="col-md-6 panel">
                    <label for="exampleInputEmail1"> <?php echo lang('service'); ?></label>
                    <select class="form-control m-bot15" id="idservice_add" name="service" required="">

                    </select>
                </div>



 <div class="col-md-12">
               <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium dateRDV" id="date_add"  name="date" value='' placeholder="" autocomplete="off" required="">
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

                        <?php if (!$this->ion_auth->in_group('Patient')) { ?>
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
<!--- Add currenct Medications --->
<!-- Add Appointment Modal-->
<div class="modal fade" id="addcurrentMedication" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title"> Current Medications</h4>
			</div>
			<div class="modal-body">
				<form role="form" id="current_medications" class="clearfix row" action="patient/add_medications" method="post" enctype="multipart/form-data">


















					<div class="col-md-12 form-group">
						<label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label>
						<input type="text" class="form-control m-bot15 " id="pos_select_" name="patient_name" value='<?php echo $patient->name . ' ' . $patient->last_name; ?>' readonly="" required="">
						<input type="hidden" name="patient"  value='<?php echo $patient->id; ?>'>
						<?php  $current_user = $this->ion_auth->get_user_id();
							$doctor_table_id = $this->doctor_model->getDoctorByIonUserId($current_user)->id;
							?>
						<input type="hidden" name="doctor"  value='<?php echo $doctor_table_id ?>'>

					</div>




					<div class="form-group col-md-12">
						<label for="exampleInputEmail1">Current Medications</label>
						<textarea rows="5" class='mytextarea' required name='current_medications' placeholder='Write the current Medications of patients...'></textarea>

					</div>

					<input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>'>

					<input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>





					<div class="form-group col-md-12">
						<button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
						<button type="submit" name="submit" class="btn btn-info submit_button pull-right"><?php echo lang('submit'); ?></button>
					</div>

				</form>

			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- Add Appointment Modal-->
<!---- End of currenct medication MOdal --->
<!---- Start Add Pre Conditions --->
<div class="modal fade" id="add-pre-conditions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class=" modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title"> <?php echo lang('add'); ?></h4>
			</div>
			<div class="modal-body">
				<form role="form" id="add_preconditions" class="clearfix row" action="patient/add_preconditions" method="post" enctype="multipart/form-data">
					<div class="col-md-12 form-group">
						<label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label>
						<input type="text" class="form-control m-bot15 " id="pos_select_" name="patient_name" value='<?php echo $patient->name . ' ' . $patient->last_name; ?>' readonly="" required="">
						<input type="hidden" name="patient"  value='<?php echo $patient->id; ?>'>
						<?php  $current_user = $this->ion_auth->get_user_id();
							$doctor_table_id = $this->doctor_model->getDoctorByIonUserId($current_user)->id;
							?>
						<input type="hidden" name="doctor"  value='<?php echo $doctor_table_id ?>'>
					</div>
					<div class="form-group col-md-12">
						<label for="exampleInputEmail1"><?php echo lang('known_pre_conditions'); ?></label>
						<textarea rows="5" class='mytextarea' required name='preconditions' placeholder='Saisir les pré-conditions connues du Patient...'></textarea>
					</div>
					<input type="hidden" name="redirect" value='patient/medicalHistory?id=<?php echo $patient->id; ?>'>
					<input type="hidden" name="patient_id" value='<?php echo $patient->id; ?>'>
					<div class="form-group col-md-12">
						<button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
						<button type="submit" name="submit" class="btn btn-info submit_button pull-right"><?php echo lang('submit'); ?></button>
					</div>
				</form>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>
<!--- END  Pre Conditions ----->
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
                        <input type="text" class="form-control  form-control-inline input-medium dateRDV" id="date_edit"  name="date" id="exampleInputEmail1" value='' placeholder="" required="" autocomplete="off">
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

                      
                           <option id="PendingConfirmation"  value="Pending Confirmation" <?php
                                ?> > <?php echo lang('pending_confirmation'); ?> </option>
                            <option id="Confirmed" value="Confirmed" <?php
                                ?> > <?php echo lang('confirmed'); ?> </option>
                            <option id="Treated" value="Treated" <?php
                                ?> > <?php echo lang('treated'); ?> </option>




                            <option id="Cancelled" value="Cancelled" <?php
                                ?> > <?php echo lang('cancelled'); ?> </option>
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

				<input type="hidden" name="patient"  value=''>
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
                    <div class="form-group col-md-6">
                        <label><?php echo lang('birth_date'); ?></label>
                        <input class="form-control form-control-inline input-medium before_now" type="text" id="birthdate2" name="birthdate" value="" placeholder="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('phoneNumber'); ?></label>
                        <input type="text" class="form-control" name="mobNo6" id="mobEdit" value="" placeholder="" onkeyup="recuperationNumeroChargephoneNumber(event,'mobEdit','phoneEdit','required')" required autocompleted="off">
                        <input type="hidden" class="form-control" name="phone" id="phoneEdit" value='' placeholder="" required="">
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
                            <input type="text" class="form-control" name="mobNo3" id="contactEdit" value="" onkeyup="recuperationNumeroChargephoneNumber(event,'contactEdit','phone_contact2')" placeholder="" autocompleted="off">
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
                        <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
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
                    <div class="form-group col-md-6">
                        <label><?php echo lang('birth_date'); ?></label>
                        <input id="birthdates" class="form-control form-control-inline input-medium before_now" type="text" id="birthdate" name="birthdate" value="" placeholder="" autocomplete="off">
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
                            <input type="text" class="form-control" name="mobNo3" id="mobNo4phone_contact" value="" placeholder="" onkeyup="recuperationNumeroChargephoneNumber(event,'mobNo4phone_contact','phone4phone_contact')"  autocompleted="off">
                            <input type="hidden" class="form-control" name="nom_contact" id="phone4phone_contact" value='' placeholder="" >
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
                    <div class="form-group col-md-6">
                        <label><?php echo lang('birth_date'); ?></label>
                        <input id="birthdates" class="form-control form-control-inline input-medium before_now" type="text" id="birthdate" name="birthdate" value="" placeholder="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('phoneNumber'); ?></label>
                        <input type="text" class="form-control" name="mobNo4" id="mobNo4" value="" placeholder=""  autocompleted="off">
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
                            <input type="text" class="form-control" name="mobNo3" id="mobNo5" value="" placeholder="" onkeyup="recuperationNumeroChargephoneNumber(event,'mobNo5','phonecontact2','required')"  autocompleted="off">
                            <input type="hidden" class="form-control" name="phone_contact" id="phonecontact2" value='' placeholder="" >
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
                                <?php if ($this->ion_auth->in_group(array('admin', 'adminmedecin','Accountant', 'Receptionist'))) { ?>
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
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="" readonly="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium" name="patient" id="exampleInputEmail1" value='<?php echo $patient->name.' '.$patient->last_name; ?>' placeholder="" readonly="">
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
    <input type="hidden" name="customCheck2" id="customCheck2" value=''> <input type="hidden" name="customCheckedit" id="customCheckedit" value=''>
    
<div class="modal fade" id="datalabModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content" id="datalab">
            
        </div>
          </div>
      </div>
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


<script type="text/javascript">
    
	// alert("init 0");
        $(document).ready(function() {
			
        var bt = document.getElementById('rediriger');
        if(bt){bt.disabled = true;}
        setTimeout(() => {
            $(".flashmessage").delay(3000).fadeOut(100);
            CKEDITOR.instances.description.on('key',function(e){
                var description = CKEDITOR.instances['description'].getData().length;
                if(description < 12){
                    bt.disabled = true;
                }else{
                    bt.disabled = false;
                }
            });
        }, 3000);


    });
    
    var type = '<?php echo $type; ?>';
var tabid_select = '#tab'+type; var divid_select = '#'+type;
if(type){
  $('.nav-tabs li').removeClass('active');  $('.tab-pane').hide();
  $(tabid_select).toggleClass('active');
    $(divid_select).show();
    }
    $('.nav-tabs a').click(function(){ 
  var divid_select = $(this).attr("href");
  var tabid_select = $(this).attr("data-id");
     $('.nav-tabs li').removeClass('active');  $('.tab-pane').hide();
  $(tabid_select).toggleClass('active');
    $(divid_select).show();
}); 
</script>
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript">
    if($.fn.datepicker.dates) {
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
    var checkbox7 = document.getElementById('customCheck7');
    var pos_matriculeedit = document.getElementById('pos_matricule7');
    checkbox7.onclick = function() {
        if (this.checked) {
            pos_matriculeedit.style['display'] = 'block';
        } else {
            pos_matriculeedit.style['display'] = 'none';

        }
    };
	// alert("init 1");
    // document.getElementById('customCheckinfo').onclick = function() {
        // if (this.checked) {
            // $('.pos_matriculeinfo').show();
        // } else {
            // $('.pos_matriculeinfo').hide();

        // }
    // };
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
                var date = new Date(response.medical_history.date * 1000);
                var de = date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();

                $('#medical_historyEditForm').find('[name="id"]').val(response.medical_history.id).end()
                $('#medical_historyEditForm').find('[name="date"]').val(de).end()
                $('#medical_historyEditForm').find('[name="title"]').val(response.medical_history.title).end()
                CKEDITOR.instances['editor'].setData(response.medical_history.description)
                if(response.medical_history.first_name && response.medical_history.first_name){
                     $('#medical_historyEditForm').find('[id="effectuer_par"]').html(response.medical_history.first_name + ' '+response.medical_history.last_name).end()
                } else {
                     $('#medical_historyEditForm').find('[id="effectuer_par"]').html(response.medical_history.username).end()
                }
                
            });
        });
        $(".editbuttonMutuelle").click(function(e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            var idparent = $(this).attr('data-idparent');
            $('#myModalMutuelle').modal('show');
            $.ajax({
                url: 'patient/editMutuelleByJason?id=' + idparent,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {

                $('#mutuelleEditForm').find('[name="mutuelle_id"]').val(response.mutuelle.idpm).end()
                $('#mutuelleEditForm').find('[name="nom_mutuelle"]').val(response.mutuelle.id).end()
                $('#mutuelleEditForm').find('[name="num_police"]').val(response.mutuelle.pm_numpolice).end()
                $('#mutuelleEditForm').find('[name="charge_mutuelle"]').val(response.mutuelle.pm_charge).end()
                $('#mutuelleEditForm').find('[name="date_valid"]').val(response.mutuelle.pm_datevalid).end()

                var option1 = new Option(response.mutuelle.nom, response.mutuelle.id, true, true);
                $('#mutuelleEditForm').find('[name="nom_mutuelle"]').append(option1).trigger('change');
            });
        });
		
    });
</script>


<script type="text/javascript">
// alert("init 2");
    $(document).ready(function() {
        
	// alert("init 2_1");
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

// alert("init 2_2");
    function recuperationDepot(event){
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
        if(amountFormat > reste ){
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
				var realTime = dateTime + (60*60) * 1000;
				var realTime = new Date(realTime);
                               var  mou= realTime.getMonth()+1;
				if(mou < 10) {
                                    mou= '0'+mou;
                                }
				var da = realTime.getDate() + '/' + mou + '/' + realTime.getFullYear();
                // Populate the form fields with the data returned from server
                $('#editAppointmentForm').find('[name="id"]').val(response.appointment.id).end()
                $('#editAppointmentForm').find('[name="patient"]').val(response.appointment.patient).end()
                //  $('#editAppointmentForm').find('[name="doctor"]').val(response.appointment.doctor).end()
                $('#editAppointmentForm').find('[name="date"]').val(da).end()
                $('#editAppointmentForm').find('[name="status"]').val(response.appointment.status).end()
                $('#editAppointmentForm').find('[name="remarks"]').val(response.appointment.remarks).end()
                $('#editAppointmentForm').find('[name="patient_name"]').val(response.patient.name + ' '+response.patient.last_name).end()
                $('#editAppointmentForm').find('[name="service_name"]').val(response.appointment.servicename).end()
                $('#editAppointmentForm').find('[name="patient"]').val(response.patient.id).end()
                $('#editAppointmentForm').find('[name="service"]').val(response.appointment.service).end()
                
               /* var option = new Option(response.patient.name + ' '+response.patient.last_name+ '-' + response.patient.phone, response.patient.id, true, true);
                $('#editAppointmentForm').find('[name="patient"]').append(option).trigger('change');
                var option1 = new Option(response.appointment.servicename + '-' + response.appointment.service, response.appointment.service, true, true);
                $('#editAppointmentForm').find('[name="service"]').append(option1).trigger('change');*/
				if(response.appointment.status == 'Confirmed') {
					$('#PendingConfirmation').hide();
				}
          
            });
              $('#editAppointmentModal').modal('show');
        });
        
           $(".editlab").click(function(e) {
            e.preventDefault(e);
            var id = $(this).attr('data-id');
            $('#datalabModal').trigger("reset");
            $('#datalabModal').modal('show');
            $.ajax({
                url: 'lab/editLabByJason?id=' + id,
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
// alert("init 3_0");
/*

    $(document).ready(function() {
        $('#date1').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
            })
            //Listen for the change even on the input
            .change(dateChanged1)
            .on('changeDate', dateChanged1);
    });*/


    /*var checkbox5 = document.getElementById('customCheck5');
    var pos_matricule5 = document.getElementById('pos_matricule5');
    checkbox5.onclick = function() {
        if (this.checked) {
            pos_matricule5.style['display'] = 'block';
        } else {
            pos_matricule5.style['display'] = 'none';

        }
    };*/
	// alert($("#table-consultation").css("width"));
	// alert($("#div-consultation").css("width"));
	// alert("init 3_1");
</script>

<script>

	// alert("init 3_2");
    $(document).ready(function() {
        
		/* $('#editable-sample').DataTable({
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
           /*     dom: {
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


        }); */
	
		// alert("init 3_3");
        $('.patient-table').DataTable({
            responsive: true,
            dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 pull-left'B><'col-sm-4 pull-right'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: {
               buttons: [
             
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
			lengthMenu: [[10, 25, 50, 100, -1], ['10', '25', '50', '100', 'Tout afficher']],
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

		
		// alert($("#table-consultation").html());	
		// alert($("#div-consultation").html());	
		// alert($("#table-consultation").css("width"));	
		// alert($("#div-consultation").css("width"));	
// $(".addConsultation").click(function() {
		// alert("we got there at least 1");
		// });	
    });
</script>



<script type="text/javascript">
	// alert("init 4");
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
     
// alert("init 4_1");

        $(".editPatient").click(function() {
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
                // Populate the form fields with the data returned from server


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


                $('#editPatientForm').find('[name="matricule"]').val(response.patient.matricule).end()
                $('#editPatientForm').find('[name="grade"]').val(response.patient.grade).end()
                $('#editPatientForm').find('[name="birth_position"]').val(response.patient.birth_position).end()
                $('#editPatientForm').find('[name="nom_contact"]').val(response.patient.nom_contact).end()
                // $('#editPatientForm').find('[name="phone_contact"]').val(response.patient.phone_contact).end()
                $('#editPatientForm').find('[name="religion"]').val(response.patient.religion).end()
                $('#editPatientForm').find('[name="region"]').val(response.patient.region).end()
                if (typeof response.patient.img_url !== 'undefined' && response.patient.img_url != '') {
                    $("#img").attr("src", response.patient.img_url);
                }



  var numeroTelephone = response.patient.phone;
            numeroTelephone = numeroTelephone.replace(/^221/, '');
            if(response.patient.phone_contact) {
                var valcontactEdit = response.patient.phone_contact;
                  valcontactEdit = valcontactEdit.replace(/^221/, '');
                  $('#editPatientForm').find('[name="mobNo3"]').val(valcontactEdit).end()
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
	    var da = d.getDate() + '/' + d.getMonth()+1 + '/' + d.getFullYear();
            $('#dateCons').val(da);
                $('#addMedicalHistory').modal('show');
            });
        });
    });
</script>

<script>
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
                console.log(response);
                console.log(response.patient.parent_id);
                // alert('editPatientByJason');
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
    $(document).ready(function() {
        $(".flashmessage").delay(3000).fadeOut(100);
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



  var numeroTelephone = response.patient.phone;
            numeroTelephone = numeroTelephone.replace(/^221/, '');
            if(response.patient.phone_contact) {
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

            $('#myModalPatientEdit').modal('show');

        });
    });
</script>