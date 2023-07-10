  $(document).ready(function () { 
        $(".table").on("click", ".editbuttonAppointment", function () {
            // e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            var id = $(this).attr('data-id');

            $('#editAppointmentForm').trigger("reset");
            // $('#myModal2').modal('show');
            $.ajax({
                url: 'appointment/editAppointmentByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
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
                // $('#editAppointmentForm').find('[name="service"]').val(response.appointment.service).end()
                $('#editAppointmentForm').find('[name="date"]').val(da).end()
                $('#editAppointmentForm').find('[name="status"]').val(response.appointment.status).end()
                $('#editAppointmentForm').find('[name="remarks"]').val(response.appointment.remarks).end()
                $('#editAppointmentForm').find('[name="patient_name"]').val(response.patient.name + ' '+response.patient.last_name).end()
                $('#editAppointmentForm').find('[name="service_name"]').val(response.appointment.servicename).end()
                $('#editAppointmentForm').find('[name="patient"]').val(response.patient.id).end()
                $('#editAppointmentForm').find('[name="service"]').val(response.appointment.service).end()
               // var option = new Option(response.appointment.time_slot, response.appointment.time_slot, true, true);
               // $('#editAppointmentForm').find('[name="time_slot"]').append(option).trigger('change');
              dateChangedEdit();

if(response.appointment.status == 'Confirmed') {
    $('#PendingConfirmation').hide();
}


            });
		$('#myModal2').modal('show');
        });
        
         
    });
    
    
    $(document).ready(function () {
        $('#date_edit').change(dateChangedEdit);
              //  .on('changeDate', dateChangedAdd);
        $('#idservice_edit').change(dateChangedEdit); 
       // $('#aslots_edit').click(dateChangedEdit); 
    });

    function dateChangedEdit() {
     
        var servicer = $('#idservice_edit').val();
                var appointment_id = $('#appointment_id').val();
                       var date = $('#date_edit').val();
             var current_value = $('#aslots_edit').val();  
       // $('#aslots_edit').find('option').remove();
        // $('#default').trigger("reset");
        if(servicer && date) { 
  

                // $('#default').trigger("reset");
                $.ajax({
                    url: 'horaire/getAvailableSlotByDoctorByDateByAppointmentIdByJason?date=' + date + '&service=' + servicer + '&appointment_id=' + appointment_id,
                    method: 'GET',
dataType: 'json',
                }).success(function (response) {
                  //  $('#aslots_edit').find('option').remove();
                    var slots = response.aslots;
                    $.each(slots, function (key, value) {
                        $('#aslots_edit').append($('<option>').text(value).val(value)).end();
                    });

                    $("#aslots_edit").val("'" +response.current_value+"'").find("option[value='" + response.current_value + "']").attr('selected', true);
                    //  $('#aslots_edit option[value=' + response.current_value + ']').attr("selected", "selected");
                    //   $("#default-step-1 .button-next").trigger("click");
                    if ($('#aslots_edit').has('option').length == 0) {                    //if it is blank. 
                        $('#aslots_edit').append($('<option>').text('horaire  non disponible').val('')).end();
                    }
                   
                });
    }

    }
    
    
    $(document).ready(function () {
       $('#date_add').change(dateChangedAdd);
              //  .on('changeDate', dateChangedAdd);
        $('#idservice_add').change(dateChangedAdd);       
    });

    function dateChangedAdd() {
        // Get the record's ID via attribute  
        var iid = $('#date_add').val(); 
        var servicer = $('#idservice_add').val();
        $('#aslots_add').find('option').remove();
        // $('#default').trigger("reset");
        if(servicer && iid) {
        $.ajax({
             url: 'horaire/getAvailableSlotByDoctorByDateByJason?date=' + iid + '&service=' + servicer,
            ///url: 'horaire/getAvailableSlotByDoctorByDateByAppointmentIdByJason?date=' + iid + '&service=' + servicer + '&appointment_id=' + id,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function (response) {
            var slots = response.aslots;
            $.each(slots, function (key, value) {
                $('#aslots_add').append($('<option>').text(value).val(value)).end();
            });
            //   $("#default-step-1 .button-next").trigger("click");
            if ($('#aslots_add').has('option').length == 0) {                    //if it is blank. 
                $('#aslots_add').append($('<option>').text('Horaire non disponible').val('')).end();
            }
        });
        }
    }

