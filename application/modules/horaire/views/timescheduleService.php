<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading" style="margin-top:41px;">
                <div class="col-md-4 clearfix pull-right">
                    <a data-toggle="modal" href="#myModal">
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i>  <?php echo lang('add'); ?> 
                            </button>
                        </div>
                    </a>  
                </div>
               <h2><?php echo lang('time_schedule'); ?> (<?php  $tr = $this->db->get_where('setting_service', array('idservice' => $doctorr))->row(); echo $tr->name_service; ?>)</h2>
            </header>

            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table">
                    <table class="table table-hover progress-table text-center_" id="editable-sample">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> <?php echo lang('weekday'); ?></th>
                                <th> <?php echo lang('start_time'); ?></th>
                                <th> <?php echo lang('end_time'); ?></th>
                                <th> <?php echo lang('duration'); ?></th>
                                <th> <?php echo lang('options'); ?></th>

                            </tr>
                        </thead>
                        <tbody> 

                        </tbody>
                    </table>

                </div>
            </div> 
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->


<?php
//$i = 0;
//foreach ($schedules as $schedule) {
//	$i = $i + 1;
//	?>
<!--    <tr class="">-->
<!--        <td style=""> --><?php //echo $i; ?><!--</td>-->
<!--        <td> --><?php //echo lang($schedule->weekday); ?><!--</td>-->
<!--        <td>--><?php //echo $schedule->s_time; ?><!--</td>-->
<!--        <td>--><?php //echo $schedule->e_time; ?><!--</td>-->
<!--        <td>--><?php //echo $schedule->duration * 5 . ' ' . lang('minutes'); ?><!--</td>-->
<!--        <td>-->
<!--            <!---->
<!--                                        <button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="--><?php //echo $schedule->id; ?><!--"><i class="fa fa-edit"></i> --><?php //echo lang('edit'); ?><!--</button>   -->
<!--                              -->-->
<!--            <a class="btn btn-info btn-xs btn_width delete_button" href="horaire/deleteScheduleService?id=--><?php //echo $schedule->id; ?><!--&service=--><?php //echo $doctorr; ?><!--&weekday=--><?php //echo $schedule->weekday; ?><!--" onclick="return confirm('Souhaitez-vous supprimer cette hooraire ?');"><i class="fa fa-trash"> </i> --><?php //echo lang('delete'); ?><!--</a>-->
<!--        </td>-->
<!--    </tr>-->
<?php //} ?>

<!-- Add Time Slot Modal-->
<div class="modal fade ajouthoraire" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo lang('add'); ?> <?php echo lang('time_slot'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="horaire/addScheduleService" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group bootstrap-timepicker">
                        <label for="exampleInputEmail1"> <?php echo lang('weekday'); ?></label>
                        <div class="input-group bootstrap-timepicker">
                            <select class="form-control m-bot15" id="weekday" name="weekday" value='' required=""> 
                               
                                <option value="Monday"><?php echo lang('monday') ?></option>
                                <option value="Tuesday"><?php echo lang('tuesday') ?></option>
                                <option value="Wednesday"><?php echo lang('wednesday') ?></option>
                                <option value="Thursday"><?php echo lang('thursday') ?></option>
                                 <option value="Friday"><?php echo lang('friday') ?></option>
                                <option value="Saturday"><?php echo lang('saturday') ?></option>
                                <option value="Sunday"><?php echo lang('sunday') ?></option>
                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('start_time'); ?></label>
                        <div class="input-group bootstrap-timepicker">
                            <input type="text" class="form-control timepicker-24" name="s_time" id="exampleInputEmail1" value='' required="">
                            <span class="input-group-btn">
                                <button class="btn btn-info btnclock" type="button"><i class="fa fa-clock"></i></button>
                            </span>
                        </div>

                    </div>
                    <div class="form-group bootstrap-timepicker">
                        <label for="exampleInputEmail1"> <?php echo lang('end_time'); ?></label>
                        <div class="input-group bootstrap-timepicker">
                            <input type="text" class="form-control timepicker-24" name="e_time" id="exampleInputEmail1" value='' required="">
                            <span class="input-group-btn">
                                <button class="btn btn-info btnclock" type="button"><i class="fa fa-clock"></i></button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('appointment') ?> <?php echo lang('duration') ?> </label>
                        <select class="form-control m-bot15" name="duration" value='' required="">

                           <!-- <option value="3" <?php
                            if (!empty($settings->duration)) {
                                if ($settings->duration == '3') {
                                    echo 'selected';
                                }
                            }
                            ?> > 15 Minutes </option>-->

                        

                            <option value="6" <?php
                            if (!empty($settings->duration)) {
                                if ($settings->duration == '6') {
                                    echo 'selected';
                                }
                            }
                            ?> > 30 Minutes </option>

                            <option value="12" <?php
                            if (!empty($settings->duration)) {
                                if ($settings->duration == '12') {
                                    echo 'selected';
                                }
                            }
                            ?> > 60 Minutes </option>

                        </select>
                    </div>

                    <input type="hidden" name="service" value='<?php echo $doctorr; ?>'>
                    <input type="hidden" name="redirect" value='horaire/timeScheduleService?service=<?php echo $doctorr;?>'>
                    <input type="hidden" name="id" value=''>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Time Slot Modal-->





<!-- Edit Time Slot Modal-->
<div class="modal fade ajouthoraire" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i>  <?php echo lang('edit'); ?>  <?php echo lang('time_slot'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editTimeSlotForm" action="horaire/addScheduleService" method="post" enctype="multipart/form-data">
                    
                     <div class="form-group bootstrap-timepicker">
                        <label for="exampleInputEmail1"> <?php echo lang('weekday'); ?></label>
                        <div class="input-group bootstrap-timepicker">
                            <select class="form-control m-bot15" id="weekday" name="weekday" value='' required=""> 
                              
                                <option value="Monday"><?php echo lang('monday') ?></option>
                                <option value="Tuesday"><?php echo lang('tuesday') ?></option>
                                <option value="Wednesday"><?php echo lang('wednesday') ?></option>
                                <option value="Thursday"><?php echo lang('thursday') ?></option>
                                  <option value="Friday"><?php echo lang('friday') ?></option>
                                <option value="Saturday"><?php echo lang('saturday') ?></option>
                                <option value="Sunday"><?php echo lang('sunday') ?></option>
                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('start_time'); ?></label>
                        <div class="input-group bootstrap-timepicker">
                            <input type="text" class="form-control timepicker-24" name="s_time" id="exampleInputEmail1" value='' required="">
                            <span class="input-group-btn">
                                <button class="btn btn-info btnclock" type="button"><i class="fa fa-clock"></i></button>
                            </span>
                        </div>

                    </div>
                    <div class="form-group bootstrap-timepicker">
                        <label for="exampleInputEmail1"> <?php echo lang('end_time'); ?></label>
                        <div class="input-group bootstrap-timepicker">
                            <input type="text" class="form-control timepicker-24" name="e_time" id="exampleInputEmail1" value='' required="">
                            <span class="input-group-btn">
                                <button class="btn btn-info btnclock" type="button"><i class="fa fa-clock"></i></button>
                            </span>
                        </div>
                    </div>
                   

                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('appointment') ?> <?php echo lang('duration') ?> </label>
                        <select class="form-control m-bot15" name="duration" value=''>

                          <!--  <option value="3" <?php
                            if (!empty($settings->duration)) {
                                if ($settings->duration == '3') {
                                    echo 'selected';
                                }
                            }
                            ?> > 15 Minutes </option>-->


                            <option value="6" <?php
                            if (!empty($settings->duration)) {
                                if ($settings->duration == '6') {
                                    echo 'selected';
                                }
                            }
                            ?> > 30 Minutes </option>

                            <option value="12" <?php
                            if (!empty($settings->duration)) {
                                if ($settings->duration == '12') {
                                    echo 'selected';
                                }
                            }
                            ?> > 60 Minutes </option>

                        </select>
                    </div>

                    <input type="hidden" name="service" value="<?php echo $doctorr; ?>">
                    <input type="hidden" name="redirect" value='horaire/timeScheduleService?service=<?php echo $doctorr; ?>'>
                    <input type="hidden" name="id" value=''>
                    <button type="submit" name="submit" class="btn btn-info  pull-right"> <?php echo lang('submit'); ?></button>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Edit Time Slot Modal-->



<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script type="text/javascript">
                                        $(document).ready(function () {
                                        $(".editbutton").click(function (e) {
                                        e.preventDefault(e);
                                        // Get the record's ID via attribute  
                                        var iid = $(this).attr('data-id');
                                        $('#editTimeSlotForm').trigger("reset");
                                        $('#myModal2').modal('show');
                                        $.ajax({
                                        url: 'horaire/editScheduleByJason?id=' + iid,
                                                method: 'GET',
                                                data: '',
                                                dataType: 'json',
                                        }).success(function (response) {
                                        // Populate the form fields with the data returned from server
                                        $('#editTimeSlotForm').find('[name="id"]').val(response.schedule.id).end()
                                                $('#editTimeSlotForm').find('[name="s_time"]').val(response.schedule.s_time).end()
                                                $('#editTimeSlotForm').find('[name="e_time"]').val(response.schedule.e_time).end()
                                                $('#editTimeSlotForm').find('[name="weekday"]').val(response.schedule.weekday).end()
                                        });
                                        });
                                        });</script>


<script>
    $(document).ready(function () {
    var table = $('#editable-sample').DataTable({
    responsive: true,
            fixedHeader: true,
        "processing": true,
        "serverSide": true,
        "searchable": true,
        "ajax": {
            url: "horaire/getTimescheduleServices?service=<?= $doctorr; ?>",
            type: 'POST',
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
							// columns: [0,1,2,3,4],
						// }
					// },
					// {
						// extend: 'pdfHtml5',
						// className: 'dt-button-icon-left dt-button-icon-pdf',
						// exportOptions: {
							// columns: [0,1,2,3,4],
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
    });</script>


<script>
    $(document).ready(function () {
    $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>
