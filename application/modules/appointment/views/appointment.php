<style>
    .ui-widget.ui-widget-content {
        display: none !important;
    }
</style>
<?php  $patient_id = '';  if (isset($_GET['patient'])) { $patient_id = $_GET['patient']; }  ?> 
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading" style="margin-top:41px;">
                <div class="clearfix no-print col-md-8 pull-right">
                    <a data-toggle="modal" href="#myModal">
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i>  <?php echo lang('add'); ?> 
                            </button>
                        </div>
                    </a>
                </div>
                <h2><?php echo lang('appointment'); ?></h2>
            </header>

            <div class="col-md-12">
          
                <header class="panel-heading tab-bg-dark-navy-blueee row">
                    <ul class="nav nav-tabs col-md-8">
                        <li class="active">
                            <a data-toggle="tab" href="#all"><?php echo lang('all'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#pending"><?php echo lang('pending_confirmation'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#confirmed"><?php echo lang('confirmed'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#treated"><?php echo lang('treated'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#cancelled"><?php echo lang('cancelled'); ?></a>
                        </li>
                       <!-- <li class="">
                            <a data-toggle="tab" href="#requested"><?php echo lang('requested'); ?></a>
                        </li>-->
                    </ul>

                   <div class="pull-right col-md-4">
                       <!--<div class="pull-right custom_buttonss">
					
				
					<label class="radio-inline">
					  <input type="radio" value="today" checked name='filter_date'><?php echo lang('today'); ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" value="week" name='filter_date'> <?php echo lang('ThisWeek'); ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" value="month" name='filter_date'><?php echo lang('ThisMonth'); ?>
					</label>
				
					</div>-->
                   
                   </div>
					
                </header>
            </div>
			
            <div class="">
                <div class="tab-content">
                    <div id="pending" class="tab-pane">
                        <div class="">
                            <div class="panel-body panel-bodyAlt">
                                <div class="adv-table editable-table ">
                                    <div class="space15"></div>
                                    <table class="table table-hover progress-table" id="editable-sample1" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th> <?php echo lang('id'); ?></th>
                                                <th> <?php echo lang('patient'); ?></th>
                                                <th> <?php echo lang('service'); ?></th>
                                                <th> <?php echo lang('date-time'); ?></th>
                                               <!--<th> <?php echo lang('remarks'); ?></th>--->
                                                <th> <?php echo lang('doctor'); ?></th>
                                                <th> <?php echo lang('status'); ?></th>
                                                <th> <?php echo lang('options'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <style>

                                            .img_url{
                                                height:20px;
                                                width:20px;
                                                background-size: contain; 
                                                max-height:20px;
                                                border-radius: 100px;
                                            }

                                        </style>



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="confirmed" class="tab-pane">
                        <div class="">
                            <div class="panel-body panel-bodyAlt">
                                <div class="adv-table editable-table ">
                                    <div class="space15"></div>
                                    <table class="table table-hover progress-table" id="editable-sample2" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th> <?php echo lang('id'); ?></th>
                                                <th> <?php echo lang('patient'); ?></th>
                                                <th> <?php echo lang('service'); ?></th>
                                                <th> <?php echo lang('date-time'); ?></th>
                                               <!--<th> <?php echo lang('remarks'); ?></th>--->
                                                <th> <?php echo lang('doctor'); ?></th>
                                                <th> <?php echo lang('status'); ?></th>
                                                <th> <?php echo lang('options'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <style>

                                            .img_url{
                                                height:20px;
                                                width:20px;
                                                background-size: contain; 
                                                max-height:20px;
                                                border-radius: 100px;
                                            }

                                        </style>



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="treated" class="tab-pane">
                        <div class="">
                            <div class="panel-body panel-bodyAlt">
                                <div class="adv-table editable-table ">
                                    <div class="space15"></div>
                                    <table class="table table-hover progress-table" id="editable-sample3" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th> <?php echo lang('id'); ?></th>
                                                <th> <?php echo lang('patient'); ?></th>
                                                <th> <?php echo lang('service'); ?></th>
                                                <th> <?php echo lang('date-time'); ?></th>
                                              <!--<th> <?php echo lang('remarks'); ?></th>--->
                                                <th> <?php echo lang('doctor'); ?></th>
                                                <th> <?php echo lang('status'); ?></th>
                                                <th> <?php echo lang('options'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <style>

                                            .img_url{
                                                height:20px;
                                                width:20px;
                                                background-size: contain; 
                                                max-height:20px;
                                                border-radius: 100px;
                                            }

                                        </style>



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="cancelled" class="tab-pane">
                        <div class="">
                            <div class="panel-body panel-bodyAlt">
                                <div class="adv-table editable-table ">
                                    <div class="space15"></div>
                                    <table class="table table-hover progress-table" id="editable-sample4" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th> <?php echo lang('id'); ?></th>
                                                <th> <?php echo lang('patient'); ?></th>
                                                <th> <?php echo lang('service'); ?></th>
                                                <th> <?php echo lang('date-time'); ?></th>
                                               <!--<th> <?php echo lang('remarks'); ?></th>--->
                                                <th> <?php echo lang('doctor'); ?></th>
                                                <th> <?php echo lang('status'); ?></th>
                                                <th> <?php echo lang('options'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <style>

                                            .img_url{
                                                height:20px;
                                                width:20px;
                                                background-size: contain; 
                                                max-height:20px;
                                                border-radius: 100px;
                                            }

                                        </style>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="all" class="tab-pane active">
                        <div class="">
                            <div class="panel-body panel-bodyAlt">
                                <div class="adv-table editable-table ">

                                    <div class="space15"></div>
                                    <table class="table table-hover progress-table" id="editable-sample5" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th> <?php echo lang('id'); ?></th>
                                                <th> <?php echo lang('patient'); ?></th>
                                                <th> <?php echo lang('service'); ?></th>
                                                <th> <?php echo lang('date-time'); ?></th>
                                                <!--<th> <?php echo lang('remarks'); ?></th>--->
                                                <th> <?php echo lang('doctor'); ?></th>
                                                <th> <?php echo lang('status'); ?></th>
                                                <th> <?php echo lang('options'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <style>

                                            .img_url{
                                                height:20px;
                                                width:20px;
                                                background-size: contain; 
                                                max-height:20px;
                                                border-radius: 100px;
                                            }

                                        </style>



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="requested" class="tab-pane">
                        <div class="">
                            <div class="panel-body panel-bodyAlt">
                                <div class="adv-table editable-table ">
                                    <div class="space15"></div>
                                    <table class="table table-hover progress-table" id="editable-sample6" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th> <?php echo lang('id'); ?></th>
                                                <th> <?php echo lang('patient'); ?></th>
                                                <th> <?php echo lang('service'); ?></th>
                                                <th> <?php echo lang('date-time'); ?></th>
                                                <!--<th> <?php echo lang('remarks'); ?></th>--->
                                                <th> <?php echo lang('doctor'); ?></th>
                                                <th> <?php echo lang('status'); ?></th>
                                                <th> <?php echo lang('options'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <style>

                                            .img_url{
                                                height:20px;
                                                width:20px;
                                                background-size: contain; 
                                                max-height:20px;
                                                border-radius: 100px;
                                            }

                                        </style>



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->




<!-- Add Appointment Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add_appointment2'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" id="addAppointmentForm" action="appointment/addNew" method="post" class="clearfix" enctype="multipart/form-data">
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label> 
                        <select class="form-control m-bot15 pos_select" id="pos_select" name="patient" value='' required=""> 


                        </select>
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1">  <?php echo lang('service'); ?></label> 
                        <select class="form-control m-bot15" id="idservice_add" name="service" value='' required="">  

                        </select>
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium dateRDV" id="date_add"  name="date" value='' placeholder="" autocomplete="off" required="">
                    </div>
                    <div class="col-md-6 panel">
                        <label class=""><?php echo lang('available_slots'); ?></label>
                        <select class="form-control m-bot15" name="time_slot" id="aslots_add" > 

                        </select>
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('appointment_status'); ?> </label> 
                        <select class="form-control m-bot15" name="status" value=''> 
                            <option value="Pending Confirmation" <?php
                                ?> > <?php echo lang('pending_confirmation'); ?> </option>
                            <option value="Confirmed" <?php
                                ?> > <?php echo lang('confirmed'); ?> </option>
                            <option value="Treated" class="hide" <?php
                                ?> > <?php echo lang('treated'); ?> </option>
                            <option value="Cancelled"  class="hide" <?php
                                ?> > <?php echo lang('cancelled'); ?> </option>
                        </select>
                    </div>
                    <div class="col-md-12 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                        <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <!--  <div class="col-md-6 panel">
                          <label> <?php echo lang('send_sms'); ?>  </label> <br>
                          <input type="checkbox" name="sms" class="" value="sms">  <?php echo lang('yes'); ?>
                      </div>-->
                    <div class="col-md-12 panel">
                              <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Appointment Modal-->

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





<!-- Edit Event Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('edit_appointment'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" id="editAppointmentForm" action="appointment/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('patient'); ?></label> 
                        <input type="text" class="form-control m-bot15 " id="pos_select_" name="patient_name" value='' readonly="" required=""> 
                        
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1">  <?php echo lang('service'); ?></label> 
                        <input type="text" class="form-control m-bot15 " id="service_edit" name="service_name" value='' readonly="" required="">
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?></label>
                        <input type="text" class="form-control  form-control-inline input-medium dateRDV" id="date_edit"  name="date"  value='' placeholder="" required="" autocomplete="off">
                    </div>
                    <div class="col-md-6 panel">
                        <label class=""><?php echo lang('available_slots'); ?></label>
                        <select class="form-control m-bot15" name="time_slot" id="aslots_edit"  > 
                          
                        </select>
                    </div>
                    <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('appointment_status'); ?> </label> 
                        <select class="form-control m-bot15" name="status" value=''>
                            <option id="PendingConfirmation"  value="Pending Confirmation" <?php
                                ?> > <?php echo lang('pending_confirmation'); ?> </option>
                            <option id="Confirmed" value="Confirmed" <?php
                                ?> > <?php echo lang('confirmed'); ?> </option>
                            <option id="Treated" value="Treated"  <?php
                                ?> > <?php echo lang('treated'); ?> </option>
                            <option id="Cancelled" value="Cancelled" <?php
                                ?> > <?php echo lang('cancelled'); ?> </option>
                        </select>
                    </div>

                    <div class="col-md-12 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('remarks'); ?></label>
                        <input type="text" class="form-control" name="remarks" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <!--    <div class="col-md-6 panel">
                            <label> <?php echo lang('send_sms'); ?> ? </label> <br>
                            <input type="checkbox" name="sms" class="" value="sms">  <?php echo lang('yes'); ?>
                        </div> -->
                    <input type="hidden" name="id" id="appointment_id" value=''>
                    <input type="hidden" name="patient"  value=''>
                    <input type="hidden" name="service" id="idservice_edit" value='' required="">
                    <div class="col-md-12 panel">
<button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Event Modal-->

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/appointment.js"></script>
<script type="text/javascript">
  document.getElementById('redirectaddNew').value = 'appointment';   
 

</script>
<script type="text/javascript">
  
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".table").on("click", ".history", function () {

            //e.preventDefault(e);
            // Get the record's ID via attribute   
            var iid = $(this).attr('data-id');
            //var id = $(this).attr('data-id');
            console.log(iid);
            $('#editAppointmentForm').trigger("reset");
            /*$.ajax({
                url: 'patient/getMedicalHistoryByjason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                $('#medical_history').html("");
                $('#medical_history').append(response.view);

            });
            $('#cmodal').modal('show');*/
        window.location.href = "patient/medicalHistory?id=" + iid ;
        });
    });
</script>



<script>
    $(document).ready(function () {
        $(document.body).on('change', '#pos_select', function () {

            var v = $("select.pos_select option:selected").val()
            if (v == 'add_new') {
                 window.location.href = "appointment/addNewView?type=addModal" ;
               // $('#myModaladdPatient').modal('show');
            } else {
              // $('#myModaladdPatient').modal('hide');
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
                    $('#addAppointmentForm').find('[name="patient"]').append(patient_opt).trigger('change');
                    
                    $('#myModal').modal('show'); 
                      });
   }

    });


</script>










<script type="text/javascript">
  

   








</script>












<script type="text/javascript">
 








</script>
<script>
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $.fn.dataTable
                .tables({visible: true, api: true})
                .columns.adjust();
    })
</script>


<script>


    $(document).ready(function () {
        var table = $('#editable-sample5').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "appointment/getAppoinmentList",
                type: 'POST',
            },
            scroller: {
                loadingIndicator: true
            },
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
				  }
				  ,
				  buttonLiner: {
					   tag: null
				  }
				 }
			},
			lengthMenu: [[10, 25, 50, 100, -1], ['10', '25', '50', '100', 'Tout afficher']],
            iDisplayLength: 10,
            "order": [[0, "desc"]],
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
                    emptyTable: "",//emptyTable: "Aucune donnée disponible dans le tableau",
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
        table.buttons().container().appendTo('.custom_buttons');
    });
</script>
<script>


    $(document).ready(function () {
        var table = $('#editable-sample6').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
           "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "appointment/getRequestedAppoinmentList",
                type: 'POST',
            },
            scroller: {
                loadingIndicator: true
            },
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
				  }
				  ,
				  buttonLiner: {
					   tag: null
				  }
				 }
			},
			lengthMenu: [[10, 25, 50, 100, -1], ['10', '25', '50', '100', 'Tout afficher']],
            iDisplayLength: 10,
            "order": [[0, "desc"]],
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
                    emptyTable: "",//emptyTable: "Aucune donnée disponible dans le tableau",
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
        table.buttons().container().appendTo('.custom_buttons');
    });
</script>

<script>


    $(document).ready(function () {
        var table = $('#editable-sample1').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "appointment/getPendingAppoinmentList",
                type: 'POST',
            },
            scroller: {
                loadingIndicator: true
            },
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
				  }
				  ,
				  buttonLiner: {
					   tag: null
				  }
				 }
			},
			lengthMenu: [[10, 25, 50, 100, -1], ['10', '25', '50', '100', 'Tout afficher']],
            iDisplayLength: 10,
            "order": [[0, "desc"]],
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
                    emptyTable: "",//emptyTable: "Aucune donnée disponible dans le tableau",
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
        table.buttons().container().appendTo('.custom_buttons');
    });
</script>
<script>


    $(document).ready(function () {
        var table = $('#editable-sample2').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "appointment/getConfirmedAppoinmentList",
                type: 'POST',
            },
            scroller: {
                loadingIndicator: true
            },
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
				  }
				  ,
				  buttonLiner: {
					   tag: null
				  }
				 }
			},
			lengthMenu: [[10, 25, 50, 100, -1], ['10', '25', '50', '100', 'Tout afficher']],
            iDisplayLength: 10,
            "order": [[0, "desc"]],
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
                    emptyTable: "",//emptyTable: "Aucune donnée disponible dans le tableau",
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
        table.buttons().container().appendTo('.custom_buttons');
    });
</script>

<script>


    $(document).ready(function () {
        var table = $('#editable-sample3').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "appointment/getTreatedAppoinmentList",
                type: 'POST',
            },
            scroller: {
                loadingIndicator: true
            },
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
				  }
				  ,
				  buttonLiner: {
					   tag: null
				  }
				 }
			},
			lengthMenu: [[10, 25, 50, 100, -1], ['10', '25', '50', '100', 'Tout afficher']],
            iDisplayLength: 10,
            "order": [[0, "desc"]],
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
                    emptyTable: "",//emptyTable: "Aucune donnée disponible dans le tableau",
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
        table.buttons().container().appendTo('.custom_buttons');
    });
</script>

<script>


    $(document).ready(function () {
        var table = $('#editable-sample4').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
          "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "appointment/getCancelledAppoinmentList",
                type: 'POST',
            },
            scroller: {
                loadingIndicator: true
            },
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
				  }
				  ,
				  buttonLiner: {
					   tag: null
				  }
				 }
			},
			lengthMenu: [[10, 25, 50, 100, -1], ['10', '25', '50', '100', 'Tout afficher']],
            iDisplayLength: 10,
            "order": [[0, "desc"]],
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
                    emptyTable: "",//emptyTable: "Aucune donnée disponible dans le tableau",
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
        table.buttons().container().appendTo('.custom_buttons');
    });
</script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
<script>
    $(document).ready(function () {
        $("#pos_select").select2({
            placeholder: '<?php echo lang('select_patient'); ?>',
            allowClear: true,
            ajax: {
                url: 'patient/getPatientinfoWithAddNewOption',
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