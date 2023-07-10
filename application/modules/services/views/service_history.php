
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-3">
            <header class="panel-heading clearfix">
                <div class="">

                </div>

            </header> 

            <aside class="profile-nav">
                <section class="">
                    <div class="user-heading round">
                        <h1> <?php echo $service->name_service; ?> </h1>

                        <button type="button" class="btn btn-xs btn_width editbutton" data-toggle="modal" title="<?php echo lang('edit'); ?>" data-id="<?php echo $service->idservice; ?>" style="background-color:#fff;color:#0D4D96"><i class="fa fa-edit"></i> </button>   
                    </div>

                    <ul class="nav nav-pills nav-stacked">


                        <li>  <?php echo lang('department'); ?><span class="label pull-right r-activity"> <?php echo $service->name_department; ?></span></li>

                        <li class="list-group-item">
                            <span id="result" data-id="<?php echo $service->idservice; ?>"> <span class="color-green">Actif </span> </span>
                            <label class="switch pull-right">
                                <input  type="checkbox" id="checkbox" checked=""  onclick="fctSwitch();">
                                <span class="slider round" ></span>
                            </label>
                        </li>


                    </ul>

                </section>
            </aside>


        </section>





        <section class="col-md-9">
            <header class="panel-heading clearfix">
                <div class="col-md-7">

                </div>

                <div class="col-md-5 pull-right">
                    <button  data-type="button" type="button" class="btn  bg-blue no-print pull-right" onclick="javascript:window.print();"><?php echo lang('print'); ?></button>
                </div>
            </header>

            <section class="panel-body">   
                <header class="panel-heading tab-bg-dark-navy-blueee">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#timeSchedule"><?php echo lang('time_schedule'); ?></a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#holidays"><?php echo lang('holidays'); ?></a>
                        </li>

                        <li class="">
                            <a data-toggle="tab" href="#timeline"><?php echo lang('timeline'); ?></a> 
                        </li>
                    </ul>
                </header>
                <div class="panel">
                    <div class="tab-content">
                        <div id="holidays" class="tab-pane">


                            <header class="panel-heading">
                                <?php echo lang('holiday'); ?> 
                                <div class="col-md-4 clearfix pull-right">
                                    <a data-toggle="modal" href="#myModalHoliday">
                                        <div class="btn-group pull-right">
                                            <button type="button"  data-type="button"  id="" class="btn  bg-blue btn-xs">
                                                <i class="fa fa-plus-circle"></i>  <?php echo lang('add_new'); ?> 
                                            </button>
                                        </div>
                                    </a>  
                                </div>
                            </header>

                            <div class="adv-table editable-table">
                                <div class="space15"></div>
                                <table class="table table-hover progress-table text-center" id="editable-sample-holiday">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> <?php echo lang('dateFirst'); ?></th><th> <?php echo lang('dateEnd'); ?></th>
                                            <th> <?php echo lang('options'); ?></th><th> <?php echo lang('delete'); ?></th>

                                        </tr>
                                    </thead>
                                    <tbody>  
                                        <?php
                                        $i = 0;
                                        foreach ($holidays as $holiday) {
                                            $i = $i + 1;
                                            ?>
                                            <tr class="">
                                                <td style=""> <?php echo $i; ?> </td>
                                                <td><?php echo $holiday->date; ?></td>
                                                <td><?php echo $holiday->date2; ?></td>
                                                <td>
                                                    <button type="button" data-type="button" class="btn  btn-blue btn_width editbuttonHoliday " data-toggle="modal" data-id="<?php echo $holiday->id; ?>" id="editbuttonHoliday<?php echo $holiday->id; ?>"><i class="fa fa-edit"></i> </button>   
                                                </td>
                                                <td>
                                                    <a class="btn btn-xs btn_width delete_button" title="<?php echo lang('delete'); ?>" href="schedule/deleteHolidayService?id=<?php echo $holiday->id; ?>" onclick="return confirm('Êtes-vous sûr de bien vouloir supprimer ?');" style="background-color:#fff;color:#0D4D96"><i class="fa fa-trash"></i> </a>
                                                </td>

                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>

                            <!-- page end-->





                            <!-- Add Holiday Modal-->
                            <div class="modal fade" id="myModalHoliday" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title">   <?php echo lang('add'); ?> <?php echo lang('holiday'); ?></h4>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" action="schedule/addHolidayService" class='clearfix' method="post" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"> <?php echo lang('dateFirst'); ?></label>
                                                    <div class="input-group bootstrap-timepicker">
                                                        <input type="text" class="form-control default-date-picker" name="date" id="exampleInputEmail1" value="" autocomplete="off">
                                                    </div>

                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1"> <?php echo lang('dateEnd'); ?></label>
                                                    <div class="input-group bootstrap-timepicker">
                                                        <input type="text" class="form-control default-date-picker2" name="date2" id="exampleInputEmail2" value=""  autocomplete="off" >
                                                    </div>

                                                </div>
                                                <input type="hidden" name="service" value='<?php echo $service->idservice; ?>'>
                                                <input type="hidden" name="redirect" value='service/serviceHistory?id=<?php echo $service->idservice; ?>'>
                                                <input type="hidden" name="id" value="">
                                                <div class="form-group">
                                                    <button type="submit" name="submit" class="btn  bg-blue pull-right"> <?php echo lang('submit'); ?></button>
                                                </div>

                                            </form>

                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div>
                            <!-- Add Holiday Modal-->


                        </div>
                        <div id="timeSchedule" class="tab-pane active">

                            <section class="panel">
                                <header class="panel-heading">
                                    <?php echo lang('time_schedule'); ?> 
                                    <div class="col-md-4 clearfix pull-right">
                                         <a  data-type="button" class="btn bg-blue btn_width btn-xs" data-toggle="modal" href="#myModalScheduleEdit">
                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('add_new'); ?> 
                                        </a>
                                    </div>
                                </header>

                                <div class="panel-body">
                                    <div class="adv-table editable-table">
                                        <table class="table table-hover progress-table text-center" id="editable-sample-schedule">
                                            <thead>
                                                <tr>
                                                    <th> # </th>
                                                    <th> <?php echo lang('weekday'); ?></th>
                                                    <th> <?php echo lang('start_time'); ?></th>
                                                    <th> <?php echo lang('end_time'); ?></th>
                                                
                                                    <th> <?php echo lang('options'); ?></th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <?php
                                                $i = 0;
                                                foreach ($schedules as $schedule) {
                                                    $i = $i + 1;
                                                    ?>
                                                    <tr class="">
                                                        <td style=""> <?php echo $i; ?> </td> 
                                                        <td>  <?php $weekday = $schedule->weekday;
                                                echo lang($weekday);
                                                    ?></td> 
                                                        <td><?php echo $schedule->s_time; ?></td>
                                                        <td><?php echo $schedule->e_time; ?></td>
                                                   
                                                        <td>
                                                            <button type="button" data-type="button" class="btn  btn-blue btn_width editbuttonSchedule " data-toggle="modal" data-id="<?php echo $schedule->id; ?>"  data-jour="<?php echo lang($weekday); ?>" id="editbuttonSchedule<?php echo $schedule->id; ?>"><i class="fa fa-edit"></i> </button>   
                                                        </td>
                                                      
                                                    </tr>
<?php } ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div> 
                            </section>
                        </div>
                                <!-- Edit Time Slot Modal-->
                                <div class="modal fade" id="myModalScheduleEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header button">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title"><i class="fa fa-plus-circle"></i>  <?php echo lang('edit'); ?>  <?php echo lang('time_slot'); ?></h4>
                                            </div>
                                            <div class="modal-body">

                                                <form role="form" id="editTimeSlotForm" action="schedule/addScheduleService" method="post" enctype="multipart/form-data">
                                                   
<div class="form-group">
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
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1"> <?php echo lang('start_time'); ?></label>
                                                        <div class="input-group bootstrap-timepicker">
                                                            <input type="text" class="form-control timepicker-24" name="s_time" id="exampleInputEmail1" value="" required="">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
                                                            </span>
                                                        </div>

                                                    </div>
                                                    <div class="form-group ">
                                                        <label for="exampleInputEmail1"> <?php echo lang('end_time'); ?></label>
                                                        <div class="input-group bootstrap-timepicker">
                                                            <input type="text" class="form-control timepicker-24" name="e_time" id="exampleInputEmail2" value="" required="">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-default" type="button"><i class="fa fa-clock-o"></i></button>
                                                            </span>
                                                        </div>
                                                       
                                                    </div>


                                                    <input type="hidden" name="service" value="<?php echo $service->idservice; ?>">
                                                    <input type="hidden" name="redirect" value='service/serviceHistory?id=<?php echo $service->idservice; ?>'>
                                                    <input type="hidden" name="id" value="">

                                                    <button type="submit" name="submit" class="btn  bg-blue"> <?php echo lang('submit'); ?></button>
                                                </form>

                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <!-- Edit Time Slot Modal-->

                        
                     <div id="timeline" class="tab-pane"> 
                            <div class="">
                                <div class="">
                                    <section class="panel ">
                                        <header class="panel-heading">

                                        </header>


                                        <?php
                                        if (!empty($timeline)) {
                                            6 +
                                                    krsort($timeline);
                                            foreach ($timeline as $key => $value) {
                                                echo $value;
                                            }
                                        }
                                        ?>

                                    </section>
                                </div>
                            </div>
                        </div>    
                        
                        </div>

                       

                    </div>
                </div>
            </section>

        </section>



    </section>
    <!-- page end-->
</section>

<!--main content end-->
<!--footer start-->

<input type="hidden" name="stt" id="stt" value='<?php echo $service->status_service; ?>'>

<style>


    thead {
        background: #f1f1f1; 
        border-bottom: 1px solid #ddd; 
    }

    .btn_width{
        margin-bottom: 20px;
    }

    .tab-content{
        padding: 20px 0px;
    }

    .cke_editable {
        min-height: 1000px;
    }




</style>


<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/service.js"></script>
<script>
                                                            var stt = document.getElementById("stt").value;
                                                            if (stt == '0') {
                                                                $('#main-content').find('[data-type="button"]').addClass('hidden').end();
                                                                document.getElementById("checkbox").checked = false;
                                                                document.getElementById("result").innerHTML = '<span class="color-red">Inactif </span>';
                                                            }


                                                            function fctSwitch() {
                                                                var checkBox = document.getElementById("checkbox");
                                                                var text = document.getElementById("result");
                                                                var iid = $('#result').attr('data-id');
                                                                var status = 0;
                                                                if (checkBox.checked == true) {
                                                                    status = 1;
                                                                    text.innerHTML = '<span class="color-green">Actif </span>';
                                                                } else {
                                                                    text.innerHTML = '<span class="color-red">Inactif </span>';
                                                                }
                                                                $.ajax({
                                                                    url: 'service/statusServiceByJason?id=' + iid + '&status=' + status,
                                                                    method: 'GET',
                                                                    data: '',
                                                                    dataType: 'json',
                                                                }).success(function (response) {
                                                                    $('#main-content').find('[data-type="button"]').removeClass('hidden').end();
                                                                    if (status == 0) {
                                                                        $('#main-content').find('[data-type="button"]').addClass('hidden').end();
                                                                    }
                                                                });
                                                            }
                        /*                                   
var schedulestatus1 = document.getElementById("schedulestatus1").value;
                                                            $('#editable-sample-schedule').find('[id="editbuttonSchedule1"]').removeClass('hidden').end();
                                                            if (schedulestatus1 == '0') {
                                                                $('#editable-sample-schedule').find('[id="editbuttonSchedule1"]').addClass('hidden').end();
                                                                document.getElementById("checkbox1").checked = false;
                                                            }

                                                            var schedulestatus2 = document.getElementById("schedulestatus2").value;
                                                            $('#editable-sample-schedule').find('[id="editbuttonSchedule2"]').removeClass('hidden').end();
                                                            if (schedulestatus2 == '0') {
                                                                $('#editable-sample-schedule').find('[id="editbuttonSchedule2"]').addClass('hidden').end();
                                                                document.getElementById("checkbox2").checked = false;
                                                            }

                                                            var schedulestatus3 = document.getElementById("schedulestatus3").value;
                                                            $('#editable-sample-schedule').find('[id="editbuttonSchedule3"]').removeClass('hidden').end();
                                                            if (schedulestatus3 == '0') {
                                                                $('#editable-sample-schedule').find('[id="editbuttonSchedule3"]').addClass('hidden').end();
                                                                document.getElementById("checkbox3").checked = false;
                                                            }

                                                            var schedulestatus4 = document.getElementById("schedulestatus4").value;
                                                            $('#editable-sample-schedule').find('[id="editbuttonSchedule4"]').removeClass('hidden').end();
                                                            if (schedulestatus4 == '0') {
                                                                $('#editable-sample-schedule').find('[id="editbuttonSchedule4"]').addClass('hidden').end();
                                                                document.getElementById("checkbox4").checked = false;
                                                            }

                                                            var schedulestatus5 = document.getElementById("schedulestatus5").value;
                                                            $('#editable-sample-schedule').find('[id="editbuttonSchedule5"]').removeClass('hidden').end();
                                                            if (schedulestatus5 == '0') {
                                                                $('#editable-sample-schedule').find('[id="editbuttonSchedule5"]').addClass('hidden').end();
                                                                document.getElementById("checkbox5").checked = false;
                                                            }

                                                            var schedulestatus6 = document.getElementById("schedulestatus6").value;
                                                            $('#editable-sample-schedule').find('[id="editbuttonSchedule6"]').removeClass('hidden').end();
                                                            if (schedulestatus6 == '0') {
                                                                $('#editable-sample-schedule').find('[id="editbuttonSchedule6"]').addClass('hidden').end();
                                                                document.getElementById("checkbox6").checked = false;
                                                            }

                                                            var schedulestatus7 = document.getElementById("schedulestatus7").value;
                                                            $('#editable-sample-schedule').find('[id="editbuttonSchedule7"]').removeClass('hidden').end();
                                                            if (schedulestatus7 == '0') {
                                                                $('#editable-sample-schedule').find('[id="editbuttonSchedule7"]').addClass('hidden').end();
                                                                document.getElementById("checkbox7").checked = false;
                                                            }*/
                                                           /* function fctSwitchSchedule(id) {
                                                                var idd = "checkbox" + id;
                                                                var editbuttonSchedule = "editbuttonSchedule" + id;
                                                                var checkBox = document.getElementById(idd);
                                                                var status = 0;
                                                                if (checkBox.checked == true) {
                                                                    status = 1;
                                                                }
                                                                $.ajax({
                                                                    url: 'schedule/statusScheduleByJasonService?id=' + id + '&status=' + status,
                                                                    method: 'GET',
                                                                    data: '',
                                                                    dataType: 'json',
                                                                }).success(function (response) {
                                                                    $('#editable-sample-schedule').find('[id="' + editbuttonSchedule + '"]').removeClass('hidden').end();
                                                                    if (status == 0) {
                                                                        $('#editable-sample-schedule').find('[id="' + editbuttonSchedule + '"]').addClass('hidden').end();
                                                                    }
                                                                });
                                                            }
*/
                                                            $(document).ready(function () {

                                                                $(".editbuttonSchedule").click(function (e) {
                                                                    e.preventDefault(e);
                                                                    // Get the record's ID via attribute  
                                                                    var iid = $(this).attr('data-id');
                                                                    //var jour = $(this).attr('data-jour');
                                                                    $.ajax({
                                                                        url: 'schedule/editScheduleByJasonService?id=' + iid,
                                                                        method: 'GET',
                                                                        data: '',
                                                                        dataType: 'json',
                                                                    }).success(function (response) {
                                                                        // Populate the form fields with the data returned from server
                                                                        $('#editTimeSlotForm').find('[name="id"]').val(response.schedule.id).end();
                                                                       // $('#editTimeSlotForm').find('[name="weekday_jour"]').val(jour).end();
                                                                         $('#editTimeSlotForm').find('[name="weekday"]').val(response.schedule.weekday).end();
                                                                        $('#editTimeSlotForm').find('[name="s_time"]').val(response.schedule.s_time).end();
                                                                        $('#editTimeSlotForm').find('[name="e_time"]').val(response.schedule.e_time).end();
                                                                    
                                                                        $('#myModalScheduleEdit').modal('show');

                                                                    });
                                                                });

                                                                $(".editbuttonHoliday").click(function (e) {
                                                                    e.preventDefault(e);
                                                                    // Get the record's ID via attribute  
                                                                    var iid = $(this).attr('data-id');
                                                                    $.ajax({
                                                                        url: 'schedule/editHolidayByJasonService?id=' + iid,
                                                                        method: 'GET',
                                                                        data: '',
                                                                        dataType: 'json',
                                                                    }).success(function (response) {
                                                                        // Populate the form fields with the data returned from server
                                                                        $('#myModalHoliday').find('[name="id"]').val(response.holiday.id).end();
                                                                        $('#myModalHoliday').find('[name="date"]').val(response.holiday.date).end();
                                                                        $('#myModalHoliday').find('[name="date2"]').val(response.holiday.date2).end();
                                                                        $('#myModalHoliday').modal('show');

                                                                    });
                                                                });
                                                            });
</script>

