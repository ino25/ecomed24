
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
				<div class="clearfix no-print col-md-6 pull-right">
                    <a href="appointment/addNewViewByAppointmentCenter?id_organisation=<?php echo $id_organisation; ?>">
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i>  <?php echo lang('add_appointment2'); ?> 
                            </button>
                        </div>
                    </a>
                </div>
                <?php echo lang('calendar'); ?> des <?php echo lang('appointment'); ?> (<?php echo $nom_organisation; ?>)				 
            </header>
            <div class="panel-body">
                <aside>
                    <section class="panel">
                        <div class="panel-body">
                            <div id="calendarAppointmentCenter" class="has-toolbar calendar_view"></div>
                        </div>
                    </section>
                </aside>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
<div class="modal fade" tabindex="-1" role="dialog" id="cmodal">
    <div class="modal-dialog modal-lg" role="document" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id='medical_history'>
                <div class="col-md-12">

                </div> 
            </div>
            <div class="modal-footer">
                <div class="col-md-12">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var id_organisation = <?php echo json_encode($id_organisation); ?>;
        // alert(id_organisation);

        $('#calendarAppointmentCenter').fullCalendar({
            lang: 'en',
            events: 'appointment/getAppointmentByJson?id_organisation=' + id_organisation,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay',
            },
            /*    timeFormat: {// for event elements
             'month': 'h:mm TT A {h:mm TT}', // default
             'week': 'h:mm TT A {h:mm TT}', // default
             'day': 'h:mm TT A {h:mm TT}'  // default
             },
             
             */
            timeFormat: 'H:mm ',

            eventRender: function(event, element) {
                element.find('.fc-time').html(element.find('.fc-time').text());
                element.find('.fc-title').html(element.find('.fc-title').text());

            },
            // eventClick: function (event) { 
            // $('#medical_history').html("");
            // if (event.id) {
            // $.ajax({
            // url: 'patient/getMedicalHistoryByJason?id=' + event.id + '&from_where=calendar',
            // method: 'GET',
            // data: '',
            // dataType: 'json',
            // }).success(function (response) {
            // Populate the form fields with the data returned from server
            // $('#medical_history').html("");
            // $('#medical_history').append(response.view);
            // });
            //alert(event.id);

            // }

            // $('#cmodal').modal('show');
            // },

            /*  eventMouseover: function (calEvent, domEvent) {
             var layer = "8888888888<div id='events-layer' class='fc-transparent' style='position:absolute; width:100%; height:100%; top:-1px; text-align:right; z-index:100'>Description</div>";
             $(this).append(layer);
             },
             
             eventMouseout: function (calEvent, domEvent) {
             $(this).append(layer);
             },*/
             
            

            slotDuration: '00:5:00',
            businessHours: false,
            slotEventOverlap: false,
            editable: false,
            selectable: false,
            lazyFetching: true,
            minTime: "6:00:00",
            maxTime: "24:00:00",
            defaultView: 'month',
            allDayDefault: false,
            displayEventEnd: true,
            timezone: false,

        });
        
            });
</script>