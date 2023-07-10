<style>
    .ui-widget.ui-widget-content {
        display: none !important;
    }
</style>


<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="">

            <header class="panel-heading" style="margin-top:41px;">
                <div class="col-md-4 no-print pull-right">
                    <?php if ($this->ion_auth->in_group(array('admin', 'Receptionist', 'Doctor', 'adminmedecin', 'Assistant'))) { ?>
                        <a data-toggle="modal" href="#myModaladdPatient">
                            <div class="btn-group pull-right">
                                <button id="" class="btn green btn-xs">
                                    <i class="fa fa-plus-circle"></i> <?php echo lang('add'); ?>
                                </button>
                            </div>
                        </a>
                    <?php } ?>
                </div>
                <h2>Patients</h2>
            </header>
            <div class="panel-body panel-bodyAlt">

                <div class="adv-table editable-table ">

                    <div class="space15"></div>
                    <table class="table table-hover progress-table" id="editable-sample">
                        <thead>
                            <tr>
                                <th><?php echo lang('patient_id'); ?></th>
                                <th><?php echo lang('patient'); ?></th>
                                <th><?php echo lang('phone'); ?></th>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Receptionist', 'Accountant', 'adminmedecin', 'Assistant'))) { ?>
                                    <th><?php echo lang('due_balance'); ?></th>
                                <?php } ?>
                                <th class="no-print"><?php echo lang('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <style>
                                tbody td {
                                    text-align: left !important;
                                }

                                .img_url {
                                    height: 20px;
                                    width: 20px;
                                    background-size: contain;
                                    max-height: 20px;
                                    border-radius: 100px;
                                }
                            </style>
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






<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title" id="modal-title"> <?php echo lang('edit_patient'); ?></h4>

            </div>
            <div class="modal-body row">
                <form role="form" id="editPatientForm" action="patient/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="redirect" value='patient'>
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
                    <!-- <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('phoneNumber'); ?></label>
                        <input type="text" class="form-control" name="mobNo6" id="mobNo6" value="" placeholder="" onkeyup="recuperationPatientEdit(event)" autocompleted="off">
                        <input type="hidden" class="form-control" name="phone" id="phone6" value='' placeholder="" required="">
                       
                        <code id="phoneID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>
                        <code class="flash_message flash_message_phone_unique col-md-12"></code>
                    </div> -->
                    <div class="form-group  col-md-6">
                        <label for="inputPhone">Téléphone</label>
                        <input id="phone_patient_edit" type="number" class="form-control" name="phone" onkeyup="numberChangePatientEdit(event)" value='' required />
                        <input type="hidden" id='phoneValide_patient_edit' name="phone_recuperation" value='' />
                        <input type="hidden" class="form-control" name="urlModal" id="urlModal2" value='' placeholder="">

                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('email'); ?></label>
                        <input type="text" class="form-control" name="email" id="exampleInputEmail1" value='' placeholder="" min="2" max="100">
                    </div>
                    <div class="col-md-12 padding0">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"><?php echo lang('passport_number'); ?></label>
                            <input type="text" class="form-control" name="passport" id="exampleInputEmail1" value='' placeholder="" min="2" max="50">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"><?php echo lang('address'); ?></label>
                            <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='' placeholder="" min="2" max="500">
                        </div>
                        <div class="form-group col-md-4">
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
                    </div>
                    <div class="form-group  col-md-12 ">
                        <input type="checkbox" name="choice_pos_matricule" id="customCheckedit" value="0"> <?php echo lang('choice_pos_matricule') ?><br>
                    </div>
                    <div class="pos_matricule" id="pos_matriculeedit" style="display: none">
                        <div class="form-group col-md-12">
                            <label>Civil : </label><input type="radio" onclick="javascript:yesnoCheck();" name="estCivil" id="noCheck" value="oui" checked> <label>Militaire : </label> <input type="radio" onclick="javascript:yesnoCheck();" name="estCivil" id="yesCheck" value="non">
                        </div>
                        <div id="ifYes" style="display:none">
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('matricule'); ?></label>
                                <input type="text" class="form-control" name="matricule" id="matricule" value='' placeholder="" min="2" max="100">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('grade'); ?></label>
                                <input type="text" class="form-control" name="grade" id="grade" value='' placeholder="" min="2" max="100">
                            </div>
                        </div>
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
                            <label><?php echo lang('nom_contact'); ?></label>
                            <input type="text" class="form-control" type="text" name="nom_contact" value="">
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="inputPhone"><?php echo lang('phone_contact'); ?></label>
                            <input id="phone_patient_contact_edit" type="number" class="form-control" name="phone_contact" onkeyup="numberChangePatientContactEdit(event)" value='' />
                            <input type="hidden" id='phoneValide_patient_contact_edit' name="phone_contact_recuperation" value='' />

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

                        <!--
                                        <div class="form-group last col-md-6">
                                            <div style="text-align:center;" class="col-md-12">
                                                <video id="video" width="200" height="200" autoplay></video>
                                                <div class="snap" id="snap">Capture Photo</div>
                                                <canvas id="canvas" width="200" height="200"></canvas>
                                                Right click on the captured image and save. Then select the saved image from the left side's Select Image button.
                                            </div>
                                        </div>
                    -->


                        <!-- <div class="form-group col-md-6">
                            <input type="checkbox" name="sms" value="sms"> <?php echo lang('send_sms') ?><br>
                        </div> -->

                    </div>
                    <input type="hidden" name="id" id="id" value=''>
                    <input type="hidden" name="p_id" value='<?php
                                                            if (!empty($patient->patient_id)) {
                                                                echo $patient->patient_id;
                                                            }
                                                            ?>'>
                    <section class="col-md-12">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button id="validationPatientEdit" type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                    </section>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Edit Patient Modal-->








<!--<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title"> <?php echo lang('patient_fiche'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" id="editPatientForm" action="patient/addNew" class="clearfix" method="post" enctype="multipart/form-data">
				<input type="hidden" name="redirect" value='patient'>
                    <div class="form-group last col-md-4">
                        <div class="">

                            <div class="col-md-12 patientImgClass">
                            </div>
                            <!--<div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="//www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" id="img1" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                            </div>--
                            <div class="col-md-12">
                                <label for="exampleInputEmail1"><?php echo lang('number'); ?>: <span class="patientIdClass"></span></label>
                            </div>


                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('name'); ?></label>
                                <div class="nameClass"></div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('last_name'); ?></label>
                                <div class="lastnameClass"></div>
                            </div>


                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('phone'); ?></label>
                                <div class="phoneClass"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('gender'); ?></label>
                                <div class="genderClass"></div>
                            </div>

                        </div>

                    </div>




                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"><?php echo lang('email'); ?></label>
                        <div class="emailClass"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label><?php echo lang('age'); ?></label>
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


                    <div class="form-group col-md-4">
                        <label><?php echo lang('birth_date'); ?></label>
                        <div class="birthdateClass"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label><?php echo lang('birth_position'); ?></label>
                        <div class="birth_positionClass"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('matricule'); ?></label>
                        <div class="matriculeClass"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('grade'); ?></label>
                        <div class="gradeClass"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('nom_contact'); ?></label>
                        <div class="nom_contactClass"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('phone_contact'); ?></label>
                        <div class="phone_contactClass"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('religion'); ?></label>
                        <div class="religionClass"></div>
                    </div>



                    <div class="form-group col-md-4">
                    </div>
                    <div class="form-group col-md-4">
                    </div>








                </form>
                <div class="form-group col-md-12"> <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button></div>

            </div><!-- /.modal-content --

        </div><!-- /.modal-dialog --
    </div>

</div>-->


<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo lang('patient_fiche'); ?></h4>
            </div>
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
                        <label><?php echo lang('age'); ?></label>
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
                <div class='row'>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('birth_date'); ?></label>
                        <div class="birthdateClass"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label><?php echo lang('birth_position'); ?></label>
                        <div class="birth_positionClass"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('matricule'); ?></label>
                        <div class="matriculeClass"></div>
                    </div>
                </div>
                <div class='row'>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('grade'); ?></label>
                        <div class="gradeClass"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('nom_contact'); ?></label>
                        <div class="nom_contactClass"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('phone_contact'); ?></label>
                        <div class="phone_contactClass"></div>
                    </div>
                </div>
                <div class='row'>
                    <div class="form-group col-md-4">
                        <label><?php echo lang('religion'); ?></label>
                        <div class="religionClass"></div>
                    </div>



                    <div class="form-group col-md-4">
                    </div>
                    <div class="form-group col-md-4">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <center>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo lang('close'); ?></button>
                </center>
            </div>
        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div>

</div>




<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>

<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>

<!--
<script>


    var video = document.getElementById('video');
    // Get access to the camera!
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        // Not adding `{ audio: true }` since we only want video now
        navigator.mediaDevices.getUserMedia({video: true}).then(function (stream) {
            video.src = window.URL.createObjectURL(stream);
            video.play();
        });
    }

    // Elements for taking the snapshot
    var canvas = document.getElementById('canvas');
    var context = canvas.getContext('2d');
    var video = document.getElementById('video');
    // Trigger photo take
    document.getElementById("snap").addEventListener("click", function () {
        context.drawImage(video, 0, 0, 200, 200);
    });

</script>

-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
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
    $('#birth_date').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,

    });
    $('#editbirth').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
        endDate: new Date()
    });

    /* var checkbox = document.getElementById('customCheck');
     var pos_matricule = document.getElementById('pos_matricule');

     checkbox.onclick = function() {
         if (this.checked) {
             pos_matricule.style['display'] = 'block';
         } else {
             pos_matricule.style['display'] = 'none';

         }
     };*/
    var checkboxedit = document.getElementById('customCheckedit');
    var pos_matriculeedit = document.getElementById('pos_matriculeedit');
    checkboxedit.onclick = function() {
        if (this.checked) {
            pos_matriculeedit.style['display'] = 'block';
        } else {
            pos_matriculeedit.style['display'] = 'none';

        }
    };

    $(".table").on("click", ".editbutton", function() {
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
            var img_tag = JSON.stringify(response.patient.img_url) !== "null" ? "<img class='avatar' src='" + response.patient.img_url + "' alt='' style='max-width: 200px; max-height: 150px;margin-bottom:10px;'>" : "<img class='avatar' src='uploads/imgUsers/contact-512.png' alt='' style='max-width: 200px; max-height: 150px;margin-bottom:10px;'>";
            var age = parseInt(response.patient.age);
            $('#editPatientForm').find('[name="age"]').val(age).end();
            $('#editPatientForm').find('[name="img"]').html(img_tag);
            $('#editPatientForm').find('[name="id"]').val(response.patient.id).end();
            $('#editPatientForm').find('[name="name"]').val(response.patient.name).end();
            $('#editPatientForm').find('[name="last_name"]').val(response.patient.last_name).end();
            // $('#editPatientForm').find('[name="password"]').val(response.patient.password).end()
            $('#editPatientForm').find('[name="email"]').val(response.patient.email).end();
            $('#editPatientForm').find('[name="address"]').val(response.patient.address).end();
            $('#editPatientForm').find('[name="phone"]').val(response.patient.phone).end();
            $('#editPatientForm').find('[name="phone_recuperation"]').val(response.patient.phone_recuperation).end();
            $('#editPatientForm').find('[name="sex"]').val(response.patient.sex).end();
            $('#editPatientForm').find('[name="birthdate"]').val(response.patient.birthdate).end();
            $('#editPatientForm').find('[name="bloodgroup"]').val(response.patient.bloodgroup).end();
            $('#editPatientForm').find('[name="p_id"]').val(response.patient.patient_id).end();
            $('#editPatientForm').find('[name="phone_contact_recuperation"]').val(response.patient.phone_contact_recuperation).end();
            $('#editPatientForm').find('[name="matricule"]').val(response.patient.matricule).end();
            $('#editPatientForm').find('[name="grade"]').val(response.patient.grade).end();
            $('#editPatientForm').find('[name="birth_position"]').val(response.patient.birth_position).end();
            $('#editPatientForm').find('[name="nom_contact"]').val(response.patient.nom_contact).end();
            $('#editPatientForm').find('[name="phone_contact"]').val(response.patient.phone_contact).end();
            $('#editPatientForm').find('[name="religion"]').val(response.patient.religion).end();
            $('#editPatientForm').find('[name="region"]').val(response.patient.region).end();
            $('#editPatientForm').find('[name="passport"]').val(response.patient.passport).end();

            if (response.patient.estCivil === 'non') {
                document.getElementById("yesCheck").checked = true;
                document.getElementById("noCheck").checked = false;
                document.getElementById('ifYes').style.display = 'block';
            }
            // if (typeof response.patient.img_url !== 'undefined' && response.patient.img_url != '') {
            // $("#img").attr("src", response.patient.img_url);
            // }

            if (response.doctor !== null) {
                var option1 = new Option(response.doctor.name + '-' + response.doctor.id, response.doctor.id, true, true);
            } else {
                var option1 = new Option(' ' + '-' + '', '', true, true);
            }

            // var date_naissance = $('#birthdate2').val();
            // var d = new Date();
            // var curday = d.getDate();
            // var curmonth = d.getMonth() + 1; // getMonth returns 0 - 11, January is 0, etc, so need to add 1!
            // var curyear = d.getFullYear();

            // if (typeof date_naissance == "string") {
            //     var dateparts = date_naissance.split("/");
            //     var userday = dateparts[0];
            //     var usermonth = dateparts[1];
            //     var useryear = dateparts[2];
            // } else {
            //     var userday = date_naissance.getDate();
            //     var usermonth = date_naissance.getMonth() + 1; // getMonth returns 0 - 11, January is 0, etc, so need to add 1!
            //     var useryear = date_naissance.getFullYear();

            // }

            // if ((curmonth < usermonth) || ((curmonth == usermonth) && (curday < userday))) {
            //     var age = curyear - useryear - 1;
            //     document.getElementById('age').value = age;
            // } else {
            //     var age = curyear - useryear;
            //     document.getElementById('age').value = age;
            // }
            //$('#editPatientForm').find('[name="doctor"]').append(option1).trigger('change');


            // $('.js-example-basic-single.doctor').val(response.patient.doctor).trigger('change');

            // var contactEdit = $('#phone_contact2').val();
            // contactEdit = contactEdit.replace(/^221/, '');
            // document.getElementById('contactEdit').value = contactEdit;
            var urlModal2 = location.pathname.split("/").slice(2).join("/");
            document.getElementById('urlModal2').value = urlModal2;
            $('#myModal2').modal('show');

        });
    });
</script>

<script type="text/javascript">
    var contactEdit = document.getElementById('contactEdit');
    var maskOptionsContactEdit = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var maskOptionsContact = IMask(contactEdit, maskOptionsContactEdit);
    maskOptionsContact.value = "{-- --- -- --";

    var mobNo6 = document.getElementById('mobNo6');
    var maskOptionsmobNo6 = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var maskOptionsContact = IMask(mobNo6, maskOptionsmobNo6);
    maskOptionsContact.value = "{-- --- -- --";

    function editContact(event) {
        var num = $('#contactEdit').val();
        var numFormat = num.replace(/[^\d]/g, '');
        document.getElementById('phone_contact2').value = numFormat;

    }

    // function recuperationNumeroEdit(event) {
    // var bt = document.getElementById('validationPatientEdit');
    // bt.disabled = true;
    // var num = $('#mobEdit').val();
    // var numFormat = num.replace(/[^\d]/g, '');
    // document.getElementById('phoneEdit').value = numFormat;
    // var numeroTelephone = $('#phoneEdit').val();
    // if (numeroTelephone.length != 12) {
    // bt.disabled = true;
    // } else {
    // bt.disabled = false;
    // }

    // }
</script>


<script type="text/javascript">
    $(".table").on("click", ".inffo", function() {
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
        $('.birthdateClass').html("").end();
        $('.ageClass').html("").end();
        $('.bloodgroupClass').html("").end();
        $('.matriculeClass').html("").end();

        $('.doctorClass').html("").end();
        $('.gradeClass').html("").end();
        $('.birth_positionClass').html("").end();
        $('.nom_contactClass').html("").end();
        $('.phone_contactClass').html("").end();
        $('.religionClass').html("").end();
        $('.regionClass').html("").end();

        $.ajax({
            url: 'patient/getPatientByJason?id=' + iid,
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
            var codePatient;
            if (response.patient.estCivil === "non") {
                codePatient = response.patient.patient_id + '' + response.patient.matricule;
            } else {
                codePatient = response.patient.patient_id;
            }
            $('.patientIdClass').append(codePatient).end();
            $('.nameClass').append(response.patient.name).end();
            $('.lastnameClass').append(response.patient.last_name).end();
            $('.emailClass').append(response.patient.email).end();
            $('.addressClass').append(response.patient.address).end();
            $('.phoneClass').append(response.patient.phone).end();
            $('.genderClass').append(response.patient.sex).end();
            $('.birthdateClass').append(response.patient.birthdate).end();
            $('.ageClass').append(response.patient.age).end();
            $('.bloodgroupClass').append(response.patient.bloodgroup).end();

            $('.matriculeClass').append(response.patient.matricule).end();
            $('.gradeClass').append(response.patient.grade).end();
            $('.birth_positionClass').append(response.patient.birth_position).end();
            $('.nom_contactClass').append(response.patient.nom_contact).end();
            $('.phone_contactClass').append(response.patient.phone_contact).end();
            $('.religionClass').append(response.patient.religion).end();
            $('.regionClass').append(response.patient.region).end();

            if (response.doctor !== null) {
                //    $('.doctorClass').append(response.doctor.name).end()
            } else {
                //     $('.doctorClass').append('').end()
            }

            // if (typeof response.patient.img_url !== 'undefined' && response.patient.img_url != '') {
            // $("#img1").attr("src", response.patient.img_url);
            // }


            $('#infoModal').modal('show');

        });
    });

    function recuperationPatientEdit(event) {
        var bt = document.getElementById('validationPatientEdit');
        var num = $('#mobNo6').val();
        var numFormat = num.replace(/[^\d]/g, '');
        document.getElementById('phone6').value = numFormat;
        var numeroTelephone = $('#phone6').val();
        if (numeroTelephone.length != 12) {
            bt.disabled = true;
        } else {
            bt.disabled = false;
        }

    }
</script>





<script>
    $(document).ready(function() {
        var table = $('#editable-sample').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "patient/getPatient",
                type: 'POST',
            },

            scroller: {
                loadingIndicator: true
            },
            fixedHeader: true,

            // dom: "",
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
            alengthMenu: [
                [10, 25, 50, 100, -1],
                ['10', '25', '50', '100', 'Tout afficher']
            ],
            iDisplayLength: 10,
            "order": [
                [0, "desc"]
            ],
            "language": {
                "processing": "<div style='margin:-10px'><span style='margin:-10px' class='fa-stack fa-lg'>\n\
                            <i  style='margin:-10px' class='fa fa-spinner fa-spin fa-stack-2x fa-fw'></i>\n\
                       </span>&emsp;Traitement en cours ...</div>",
                // "select": {
                //     "rows": {
                //         _: '%d rows selected',
                //         0: 'Click row to select',
                //         1: '1 row selected'
                //     }
                // },
                // processing: "Traitement en cours...",
                // processing: "<span class='fa-stack fa-lg'>\n\
                //             <i class='fa fa-spinner fa-spin fa-stack-2x fa-fw'></i>\n\
                //        </span>&emsp;Processing ...",
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
            // language: {
            //     "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json?<?php echo time(); ?>",
            //     "processing": "<span class='fa-stack fa-lg'>\n\
            //                 <i class='fa fa-spinner fa-spin fa-stack-2x fa-fw'></i>\n\
            //            </span>&emsp;Processing ...",
            //     "select": {
            //         "rows": {
            //             _: '%d rows selected',
            //             0: 'Click row to select',
            //             1: '1 row selected'
            //         }
            //     },
            //     // processing: "Traitement en cours...",
            //     // processing: "<span class='fa-stack fa-lg'>\n\
            //     //             <i class='fa fa-spinner fa-spin fa-stack-2x fa-fw'></i>\n\
            //     //        </span>&emsp;Processing ...",
            //     search: "_INPUT_",
            //     lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
            //     info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            //     infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            //     infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            //     infoPostFix: "",
            //     loadingRecords: "Chargement en cours...",
            //     zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
            //     emptyTable: "", //emptyTable: "Aucune donnée disponible dans le tableau",
            //     paginate: {
            //         first: "Premier",
            //         previous: "Pr&eacute;c&eacute;dent",
            //         next: "Suivant",
            //         last: "Dernier"
            //     },
            //     aria: {
            //         sortAscending: ": activer pour trier la colonne par ordre croissant",
            //         sortDescending: ": activer pour trier la colonne par ordre décroissant"
            //     },
            //     buttons: {
            //         pageLength: {
            //             _: "Afficher %d éléments",
            //             '-1': "Tout afficher"
            //         }
            //     }
            // }
        });
        table.buttons().container().appendTo('.custom_buttons');
    });
</script>







<script>
    $(document).ready(function() {
        $("#doctorchoose").select2({
            placeholder: '<?php echo lang('select_doctor'); ?>',
            allowClear: true,
            ajax: {
                url: 'doctor/getDoctorinfo',
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
        $("#doctorchoose1").select2({
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



    });
</script>




<script>
    function recuperationEditAge() {
        var date_naissance = $('#birthdate2').val();
        var d = new Date();
        var curday = d.getDate();
        var curmonth = d.getMonth() + 1; // getMonth returns 0 - 11, January is 0, etc, so need to add 1!
        var curyear = d.getFullYear();

        if (typeof date_naissance == "string") {
            var dateparts = date_naissance.split("/");
            var userday = dateparts[0];
            var usermonth = dateparts[1];
            var useryear = dateparts[2];
        } else {
            var userday = date_naissance.getDate();
            var usermonth = date_naissance.getMonth() + 1; // getMonth returns 0 - 11, January is 0, etc, so need to add 1!
            var useryear = date_naissance.getFullYear();

        }

        if ((curmonth < usermonth) || ((curmonth == usermonth) && (curday < userday))) {
            var age = curyear - useryear - 1;
            document.getElementById('age').value = age;
        } else {
            var age = curyear - useryear;
            document.getElementById('age').value = age;
        }
    }
    $(document).ready(function() {

        $(".flashmessage").delay(3000).fadeOut(100);

    });
</script>