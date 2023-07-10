<!-- Add Patient Modal-->
<!--sidebar end-->
<!--main content start-->
<style>
    body {
        font-family: Helvetica, sans-serif;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0;
        /* <-- Apparently some margin are still there even though it's hidden */
    }

    input[type=number] {
        -moz-appearance: textfield;
        /* Firefox */
    }

    .container {
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
        padding: 10px;
    }

    #phone,
    .btn {
        padding-top: 6px;
        padding-bottom: 6px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    /* .btn {
		color: #ffffff;
		background-color: #428BCA;
		border-color: #357EBD;
		font-size: 14px;
		outline: none;
		cursor: pointer;
		padding-left: 12px;
		padding-right: 12px;
	} */

    .btn:focus,
    .btn:hover {
        background-color: #3276B1;
        border-color: #285E8E;
    }

    .btn:active {
        box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    }

    .alert {
        padding: 15px;
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-info {
        border-color: #bce8f1;
        color: #31708f;
        background-color: #d9edf7;
    }

    .alert-error {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<div class="modal fade" id="myModaladdPatient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title"> <?php echo lang('register_new_patient'); ?></h4>

            </div>
            <div class="modal-body row">

                <form role="form" action="patient/addNew" class="clearfix" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="redirect" id="redirectaddNew" value='patient'>
                    <input type="hidden" name="typetraitance" id="typetraitance" value=''>
                    <input type="hidden" name="partenairetraitance" id="partenairetraitance" value=''>
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
                        <input id="birthdates" class="form-control form-control-inline input-medium before_now" type="text" name="birthdate" value="" placeholder="" autocomplete="off" onchange="recuperationAge()">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Age</label>
                        <input type="number" class="form-control" name="age" id="agesFooter" value='' placeholder="" min="0" max="100">
                        <input id="datesjourFooter" type="hidden" name="date" value='<?php echo date('d/m/Y'); ?>' placeholder="">
                        <input type="hidden" class="form-control" name="urlModal" id="urlModal" value='' placeholder="" required="">
                    </div>
                    <!-- <div class="form-group col-md-6">
                        <label for="mobNo2"><?php echo lang('phoneNumber'); ?></label>
                        <code class="flash_message flash_message_phone_unique col-md-12"></code>
                        <input type="text" class="form-control" name="mobNo2" id="mobNo2" value="" placeholder="" onkeyup="recuperationNumero(event)" required autocompleted="off">
                        <input type="hidden" class="form-control" name="phone" id="phone2" value='' placeholder="" required="">
                        <input type="hidden" class="form-control" name="urlModal" id="urlModal" value='' placeholder="" required="">
                        <code id="phoneID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>
                    </div> -->
                    <div class="form-group  col-md-6">
                        <label for="inputPhone">Téléphone</label>
                        <input id="phone_patient" type="number" class="form-control" name="phone" onkeyup="numberChangePatient(event)" value='' required />
                        <input type="hidden" id='phoneValide_patient' name="phone_recuperation" value='' />

                    </div>

                    <div class="form-group col-md-6">
                        <label for="email"><?php echo lang('email'); ?></label>
                        <input type="text" class="form-control" name="email" id="email" value='' placeholder="" min="2" max="100">
                    </div>
                    <div class="col-md-12 padding0">
                        <div class="form-group col-md-6">
                            <label for="address"><?php echo lang('address'); ?></label>
                            <input type="text" class="form-control" name="address" id="address" value='' placeholder="" min="2" max="500">
                        </div>
                        <div class="form-group col-md-6">
                            <label><?php echo lang('region'); ?></label>
                            <select class="form-control" id='region' name="region">
                                <option value=""></option>
                                <?php if (isset($regions)) {
                                    foreach ($regions as $value => $region) { ?>
                                        <option value="<?php echo $region; ?>" <?php
                                                                                if (!empty($patient->region)) {
                                                                                    if ($region == $patient->region) {
                                                                                        echo 'selected';
                                                                                    }
                                                                                }
                                                                                ?>> <?php echo $region; ?> </option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group  col-md-12 ">
                        <input type="checkbox" name="choice_pos_matricule" id="customCheck" value="0"> <?php echo lang('choice_pos_matricule') ?><br>
                    </div>
                    <div class="pos_matricule" id="pos_matricule" style="display: none">
                        <div class="form-group col-md-12">
                            <label>Civil : </label>
                            <input type="radio" onclick="javascript:yesAddCheck();" name="estCivil" id="noValid" value="oui" checked> <label>Militaire : </label> <input type="radio" onclick="javascript:yesAddCheck();" name="estCivil" id="yesValid" value="non">
                        </div>
                        <div id="ifYesValid" style="display:none">
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('matricule'); ?></label>
                                <input type="text" class="form-control" name="matricule" id="matriculeValid" value='' placeholder="" min="2" max="100">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?php echo lang('grade'); ?></label>
                                <input type="text" class="form-control" name="grade" id="gradeValid" value='' placeholder="" min="2" max="100">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"><?php echo lang('blood_group'); ?></label>
                            <select class="form-control " name="bloodgroup">
                                <option value=""></option>
                                <?php if (isset($groups)) {
                                    foreach ($groups as $group) { ?>
                                        <option value="<?php echo $group->group; ?>" <?php
                                                                                        if (!empty($patient->bloodgroup)) {
                                                                                            if ($group->group == $patient->bloodgroup) {
                                                                                                echo 'selected';
                                                                                            }
                                                                                        }
                                                                                        ?>> <?php echo $group->group; ?> </option>
                                <?php }
                                } ?>
                            </select>
                        </div>


                        <div class="form-group col-md-6">
                            <label><?php echo lang('birth_position'); ?></label>
                            <input class="form-control" type="text" name="birth_position" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label><?php echo lang('nom_contact'); ?></label>
                            <input class="form-control" type="text" name="nom_contact" value="">
                        </div>
                        <!-- <div class="form-group col-md-6">
                            <label><?php echo lang('phone_contact'); ?></label>
                            <input type="text" class="form-control" name="mobNo3" id="mobNo3" value="" placeholder="" onkeyup="recuperationNumeroChargephoneNumber(event,'mobNo3','phonecontact','')" required autocompleted="off">
                            <input type="hidden" class="form-control" name="phone_contact" id="phonecontact" value='' placeholder="" required="">
                            <code id="phoneID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>
                        </div> -->

                        <div class="form-group  col-md-6">
                            <label for="inputPhone"><?php echo lang('phone_contact'); ?></label>
                            <input id="phone_contact" type="number" class="form-control" name="phone_contact" onkeyup="numberChangeContactPatient(event)" value='' />
                            <input type="hidden" id='phone_contact_recuperation' name="phone_contact_recuperation" value='' />

                        </div>
                        <div class="form-group col-md-6">
                            <label><?php echo lang('religion'); ?></label>
                            <select class="form-control" name="religion">
                                <option value=""></option>
                                <?php if (isset($religions)) {
                                    foreach ($religions as $value => $religion) { ?>
                                        <option value="<?php echo $religion; ?>" <?php
                                                                                    if (!empty($patient->religion)) {
                                                                                        if ($value == $patient->region) {
                                                                                            echo 'selected';
                                                                                        }
                                                                                    }
                                                                                    ?>> <?php echo $religion; ?> </option>
                                <?php }
                                } ?>
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
                    </div>
                    <!-- <div class="form-group  col-md-12 ">
                        <input type="checkbox" name="choice_pos_matricule2" id="customCheck2" value="0"> <?php echo lang('assurance') ?><br>
                    </div> 
                    <div class="pos_matricule2" id="pos_matricule2" style="display: none">
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
                    <section class="col-md-12">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button id="validationPatient" type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                    </section>

                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>
<div class="modal fade" id="myModalLight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Ajouter sous-traitant</h4>
            </div>
            <div class="modal-body row">
                <form role="form" action="partenaire/addNewLight" method="post" class="clearfix" enctype="multipart/form-data">
                    <input type="hidden" name="typetraitance" id="typetraitance" value=''>
                    <input type="hidden" name="partenairetraitance" id="partenairetraitance" value=''>
                    <div class="col-md-12 panel">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1"> Nom organisation</label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1" value="" placeholder="" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Type</label>
                            <select class="form-control" name="type" required>
                                <option value="Laboratoire d'Analyses">Laboratoire d'Analyses</option>
                                <option value="Polyclinique">Polyclinique</option>
                                <option value="Clinique">Clinique</option>
                                <option value="Pharmacie">Pharmacie</option>
                                <option value="Fournisseur Pharmacie">Fournisseur Pharmacie</option>
                                <option value="Assurance">Assurance</option>
                                <option value="IPM">IPM</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Téléphone</label>
                            <input id="phone_patient_edit_light" type="number" class="form-control" name="phone" onkeyup="numberChangePatientEditLight(event)" value='' required />
                            <input type="hidden" id='phoneValide_patient_edit_light' name="phone_recuperation" value='' required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">email</label>
                            <input type="email" class="form-control" id="name" name="email" id="exampleInputEmail1" placeholder="" required>
                        </div>
                        <div class="col-md-12 panel">
                            <label for="exampleInputEmail1">Catégorie de Tarification</label>
                            <select name='category' class='form-control' required>
                                <option disabled value="" selected hidden>Sélectionner une Catégorie de Tarification</option>
                                <option value="privé">Sous-traitance privée</option>
                                <option value="publique">Sous-traitance publique</option>
                                <option value="hors-category">Hors-catégorie</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Adresse</label>
                            <input type="text" class="form-control" name="adresse" id="exampleInputEmail1" placeholder="" required>
                        </div>
                        <input id="redirectLight" type="hidden" class="form-control" name="redirect" id="exampleInputEmail1" placeholder="">
                    </div>

                    <div class="col-md-12 panel">
                        <button id="validationPatientEditLight" type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Add Patient ACTE -->



<footer class="site-footer">
    <div class="text-center">
        20<?php echo date('y'); ?> &copy; Powered by ecoMed24.
        <a href="<?php echo current_url() . '#'; ?>" class="go-top">
            <i class="fa fa-angle-up"></i>
        </a>
    </div>
</footer>

<!--footer end-->
</section>



<!-- js placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url(); ?>common/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>common/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/jquery.scrollTo.min.js"></script>

<script src="<?php echo base_url(); ?>common/js/moment.min.js"></script>

<!--
<script src="<?php echo base_url(); ?>common/js/jquery.nicescroll.js" type="text/javascript"></script>
-->

<script type="text/javascript" src="<?php echo base_url(); ?>common/assets/DataTables/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/respond.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>common/js/jquery-ui.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url(); ?>common/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>common/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>common/assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url(); ?>common/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>-->

<script type="text/javascript" src="<?php echo base_url(); ?>common/assets/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>common/assets/jquery-multi-select/js/jquery.quicksearch.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>common/assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>common/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script src="<?php echo base_url(); ?>common/js/advanced-form-components.js"></script>
<script src="<?php echo base_url(); ?>common/js/jquery.cookie.js"></script>
<!--common script for all pages-->
<script src="<?php echo base_url(); ?>common/js/common-scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>

<script>
    $(document).ready(function(e) {
        $("#notes_taking").validate({
            rules: {
                date_note: {
                    required: true
                },
                title_note: {
                    required: true
                },
                note_desc: {
                    required: true
                }
            },
            messages: {
                date_note: {
                    required: "Please pick the date"
                },
                title_note: {
                    required: "Enter Titre"
                },
                note_desc: {
                    required: "Write Notes"
                }
            },
            submitHandler: function(form) { // for demo
                var formdata = new FormData($('#notes_taking')[0]);
                //console.log();
                formdata.append('notes', CKEDITOR.instances['note_desc'].getData());
                $.ajax({
                    url: 'meeting/save_notes',
                    data: formdata,
                    contentType: false,
                    processData: false,
                    type: "post",
                    dataType: "json",
                    beforeSend: function() {
                        // $('.notes_loader').html('<i class="fa fa-spinner fa-spin"></i> Notes adding... ')
                        $('.notes_loader').html('<img src="uploads/loading-wheel.gif" style="width:15px;height:15px;margin-left:0.5em;" /> Mise à jour en cours... ')
                    },
                    success: function(response) {
                        if (response.error) {

                        } else {
                            $('.notes_loader').html('<i class="fa fa-check" style="color:green"></i> Mise à jour effectuée.');
                        }

                    }
                });
            }
        });



        $(document).on('click', '#resend_otp_patient_record', function() {

            var patient_email = $("#patient_email").val();
            var patient_phone = $("#patient_phone").val();
            var patient_id = $("#patient_id").val();
            var patient_phone_masked = maskAllButLast4(patient_phone);
            var patient_email_masked = maskEmail(patient_email);
            // alert(patient_email_masked);
            $.ajax({
                url: 'meeting/request_access',
                type: "POST",
                data: {
                    'patient_id': patient_id,
                    'patient_phone': patient_phone,
                    'patient_email': patient_email
                },
                // contentType: false,
                // processData: false,
                dataType: "json",
                beforeSend: function() {
                    $('.change_section').html('<img src="uploads/loading-wheel.gif" style="width:15px;height:15px;margin-left:0.5em;" /> Envoi du code de vérification... ')
                },
                success: function(response) {
                    if (response.error) {

                    } else {
                        // alert(JSON.stringify(response));
                        // alert(response.patient_id);
                        // alert(response.patient_phone);
                        // alert(response.patient_email);
                        // alert(response.current_user_id);
                        $('.change_section').html('');
                        $('.round-lg span').html('2');
                        $('.request_title').text("Demander l'accès au dossier");
                        <?php $min_avant_expiration = $this->config->item('otp_expiration', 'ion_auth') / 60; ?>
                        $('.change_section').html('<div style="text-align:center"><i class="fa fa-exclamation-triangle" style="font-size:30px;color:red;"></i><p style="width:80%;margin:auto;color:#000;text-align:center;font-size:95%;">Un nouveau code de vérification a été envoyé au patient.</p></div><form><div class="col-sm-12 padding"><input type="text" placeholder="Code de vérification" class="form-control auth_code"  pattern="^[0-9]{6}$" required><input type="hidden" name="patient_email" id="patient_email" value="' + patient_email + '"><input type="hidden" name="patient_phone" id="patient_phone" value="' + patient_phone + '"><input type="hidden" name="patient_id" id="patient_id" value="' + patient_id + '"></div><div class="col-sm-12"><button class="btn btn-login btn-secondary pull-left" style="width:60%;" id="resend_otp_patient_record">Renvoyer le code</button><button type="submit" class="btn btn-primary pull-right btn_continue" style="width:35%;">Valider</button></div></form>');
                    }

                }
            });


        });

        $(document).on('click', '.btn_request_access', function() {

            var patient_email = $("#patient_email").val();
            var patient_phone = $("#patient_phone").val();
            var patient_id = $("#patient_id").val();
            var patient_phone_masked = maskAllButLast4(patient_phone);
            var patient_email_masked = maskEmail(patient_email);
            // alert(patient_email_masked);
            $.ajax({
                url: 'meeting/request_access',
                type: "POST",
                data: {
                    'patient_id': patient_id,
                    'patient_phone': patient_phone,
                    'patient_email': patient_email
                },
                // contentType: false,
                // processData: false,
                dataType: "json",
                beforeSend: function() {
                    $('.change_section').html('<img src="uploads/loading-wheel.gif" style="width:15px;height:15px;margin-left:0.5em;" /> Envoi du code de vérification... ');
                },
                success: function(response) {
                    if (response.error) {

                    } else {
                        // alert(JSON.stringify(response));
                        // alert(response.patient_id);
                        // alert(response.patient_phone);
                        // alert(response.patient_email);
                        // alert(response.current_user_id);
                        $('.change_section').html('');
                        $('.round-lg span').html('2');
                        $('.request_title').text("Demander l'accès au dossier");
                        <?php $min_avant_expiration = $this->config->item('otp_expiration', 'ion_auth') / 60; ?>
                        $('.change_section').html('<div style="text-align:center"><i class="fa fa-exclamation-triangle" style="font-size:30px;color:red;"></i><p style="width:80%;margin:auto;color:#000;text-align:center;font-size:95%;">Un code de vérification valide pour <?php echo $min_avant_expiration ?> minutes a été envoyé au patient par SMS au ' + patient_phone_masked + ' et par email à l\'adresse ' + patient_email_masked + '.</p></div><form><div class="col-sm-12 padding"><input type="text" placeholder="Code de vérification" class="form-control auth_code"  pattern="^[0-9]{6}$" required><input type="hidden" name="patient_email" id="patient_email" value="' + patient_email + '"><input type="hidden" name="patient_phone" id="patient_phone" value="' + patient_phone + '"><input type="hidden" name="patient_id" id="patient_id" value="' + patient_id + '"></div><div class="col-sm-12"><button class="btn btn-login btn-secondary pull-left" style="width:60%;" id="resend_otp_patient_record" >Renvoyer le code</button><button type="submit" class="btn btn-primary pull-right btn_continue" style="width:35%;">Valider</button></div></form>');
                    }

                }
            });


        });

        $(document).on('click', '.btn_continue', function(e) {
            // e.preventDefault();
            if ($('.auth_code').val() == "" || !matchExact("[0-9]{6}", $('.auth_code').val())) {
                // No action for now
                // alert('Please Enter the Authorization Code');
            } else {
                var auth_code = $('.auth_code').val();
                var patient_email = $("#patient_email").val();
                var patient_phone = $("#patient_phone").val();
                var patient_id = $("#patient_id").val();
                // alert(patient_email);
                // alert(patient_phone);
                // alert(patient_id);
                $.ajax({
                    url: 'meeting/check_code',
                    data: {
                        'auth_code': auth_code,
                        'patient_id': patient_id,
                        'patient_phone': patient_phone,
                        'patient_email': patient_email
                    },
                    type: "post",
                    dataType: "json",
                    beforeSend: function() {
                        // $('.change_section').html('<i class="fa fa-spinner fa-spin"></i> Authorizing... ')
                        $('.change_section').html('<img src="uploads/loading-wheel.gif" style="width:15px;height:15px;margin-left:0.5em;" /> Vérification... ')
                    },
                    success: function(response) {
                        if (response.error) {

                            // alert(JSON.stringify(response));
                            // alert(response.message);
                            var errorMessage = response.message != null && response.message != "" ? response.message : '<i class="fa fa-exclamation-triangle" style="font-size:30px;color:red;"></i><p style="width:80%;margin:auto;color:#000;text-align:center;font-size:95%;">Le code de vérification saisi est incorrect. Merci de rééssayer.</p>';
                            // alert(errorMessage);
                            $('.change_section').html('<div style="text-align:center">' + errorMessage + '</div><form><div class="col-sm-12 padding"><input type="text" placeholder="Code de vérification" class="form-control auth_code"  pattern="^[0-9]{6}$" required><input type="hidden" name="patient_email" id="patient_email" value="' + patient_email + '"><input type="hidden" name="patient_phone" id="patient_phone" value="' + patient_phone + '"><input type="hidden" name="patient_id" id="patient_id" value="' + patient_id + '"></div><div class="col-sm-12"><button class="btn btn-login btn-secondary pull-left" style="width:60%;" id="resend_otp_patient_record" >Renvoyer le code</button><button type="submit" class="btn btn-primary pull-right btn_continue" style="width:35%;">Valider</button></div></form>');

                        } else {

                            // alert(JSON.stringify(response.patient_record.birthdate));
                            // alert(JSON.stringify(response.age));
                            var img_tag = JSON.stringify(response.patient_record.img_url) !== "null" ? "<img src='" + response.patient_record.img_url + "' width='60px' height='60px' class='user-image img-circle' alt='Image'>" : "<img src='uploads/imgUsers/contact-512.png'  width='60px' height='60px' class='user-image img-circle' alt='Image'>";

                            $('.change_section').html('');
                            // $('.patient_full_details').html("<div class='col-sm-12' style='border: 2px solid gainsboro; padding: 15px 15px;'><div class='row'><div class='col-sm-3'>"+img_tag+"</div><div class='col-sm-9'><div class='row'><div class='col-sm-6'><p><strong> Patient: </strong>"+response.patient_record.name+" "+response.patient_record.last_name+"</p></div><div class='col-sm-6'><p><strong> Age: </strong> "+response.age+"</p></div></div><div class='row'><div class='col-sm-6'><p ><strong> Téléphone : </strong>"+response.patient_record.phone+"</p></div><div class='col-sm-6'><p><strong> Sexe : </strong> "+response.patient_record.sex+"</p></div></div></div></div><div class='row' style='margin-top:15px'><div class='col-sm-6' ><h5> Allergies</h5><ul type='none'><li>Item 1</li><li>Item 2</li><li>Item 3</li></ul></div><div class='col-sm-6'><h5> Known Health Conditions</h5><ul type='none'><li>Item 1</li><li>Item 2</li><li>Item 3</li></ul></div></div><div class='row' style='margin-top:15px;padding-top:40px'><div class='col-sm-6'> <button type='button' class='btn btn-success form-control'> Medical Notes </button></div><div class='col-sm-6'> <button type='button' class='btn btn-success form-control'> Lab Results </button></div><div class='col-sm-6'> <button type='button' class='btn form-control btn-success'> Documents </button></div><div class='col-sm-6'> <button type='button' class='btn btn-success form-control'> Medications </button></div></div></div></div></div>");
                            // $('.patient_full_details').html("<div class='col-sm-12' style='border: 2px solid gainsboro; padding: 15px 15px;'><div class='row'><div class='col-sm-3'>"+img_tag+"</div><div class='col-sm-9'><div class='row'><div class='col-sm-6'><p><strong> Patient: </strong>"+response.patient_record.name+" "+response.patient_record.last_name+"</p></div><div class='col-sm-6'><p><strong> Age: </strong> "+response.age+"</p></div></div><div class='row'><div class='col-sm-6'><p ><strong> Téléphone : </strong>"+response.patient_record.phone+"</p></div><div class='col-sm-6'><p><strong> Sexe : </strong> "+response.patient_record.sex+"</p></div></div></div></div><div class='row' style='margin-top:15px'><div class='col-sm-6' ><h5> Allergies</h5><ul type='none'><li>Bientôt disponible</li></ul></div><div class='col-sm-6'><h5>Maladies connues</h5><ul type='none'><li>Bientôt disponible</li></ul></div></div><div class='row' style='margin-top:15px;padding-top:40px'><div class='col-sm-6'> <button type='button' class='btn btn-success form-control'> Medical Notes </button></div><div class='col-sm-6'> <button type='button' class='btn btn-success form-control'> Lab Results </button></div><div class='col-sm-6'> <button type='button' class='btn form-control btn-success'> Documents </button></div><div class='col-sm-6'> <button type='button' class='btn btn-success form-control'> Medications </button></div></div></div></div></div>");
                            // var html = "<div class='col-sm-12' style='border: 2px solid gainsboro; padding: 15px 15px;'><div class='row'><div class='col-sm-3'>"+img_tag+"</div><div class='col-sm-9'><div class='row'><div class='col-sm-6'><p><strong> Patient: </strong>"+response.patient_record.name+" "+response.patient_record.last_name+"</p></div><div class='col-sm-6'><p><strong> Age: </strong> "+response.age+"</p></div></div><div class='row'><div class='col-sm-6'><p ><strong> Téléphone : </strong>"+response.patient_record.phone+"</p></div><div class='col-sm-6'><p><strong> Sexe : </strong> "+response.patient_record.sex+"</p></div></div></div></div><div class='row' style='margin-top:15px'><div class='col-sm-6' ><h5> Allergies</h5><ul type='none'><li>Bientôt disponible</li></ul></div><div class='col-sm-6'><h5>Maladies connues</h5><ul type='none'><li>Bientôt disponible</li></ul></div></div><div class='row' style='margin-top:15px;padding-top:40px'><div class='col-sm-6'> <button type='button' class='btn btn-success form-control'> Medical Notes </button></div><div class='col-sm-6'> <button type='button' class='btn btn-success form-control'> Lab Results </button></div><div class='col-sm-6'> <button type='button' class='btn form-control btn-success'> Documents </button></div><div class='col-sm-6'> <button type='button' class='btn btn-success form-control'> Medications </button></div></div></div></div></div>";
                            var html = "<style>.ui-widget.ui-widget-content {display: none !important;} .panel-heading2{background:#e6e9ed !important;}</style>";
                            html += "<div class='col-sm-12' style='border: 2px solid gainsboro; padding: 15px 15px;'><div class='row'><div class='col-sm-3'>" + img_tag + "</div><div class='col-sm-9'><div class='row'><div class='col-sm-6'><p><strong> Patient: </strong>" + response.patient_record.name + " " + response.patient_record.last_name + "</p></div><div class='col-sm-6'><p><strong> Age: </strong> " + response.age + "</p></div></div><div class='row'><div class='col-sm-6'><p ><strong> Téléphone : </strong>" + response.patient_record.phone + "</p></div><div class='col-sm-6'><p><strong> Sexe : </strong> " + response.patient_record.sex + "</p></div></div></div></div><div class='row' style='margin-top:15px'><div class='col-sm-6' ><h5> Allergies</h5><ul type='none'><li>Bientôt disponible</li></ul></div><div class='col-sm-6'><h5>Maladies connues</h5><ul type='none'><li>Bientôt disponible</li></ul></div></div>";
                            // html += '<section class="panel-body">';
                            html += '		<header class="panel-heading panel-heading2 tab-bg-dark-navy-blueee" style="margin-top:15px;">';
                            html += '		<ul class="nav nav-tabs">';
                            html += '		<li class="active"  id="tabconsultation">';
                            html += '		    <a data-toggle="tab" href="#consultation" data-id="tabconsultation" >Consultations</a>';
                            html += '		</li>';
                            // html += '		<li class=""  id="tabprescription">';
                            // html += '		    <a data-toggle="tab" href="#prescription" data-id="tabprescription" ><?php echo lang('prescriptions'); ?></a>';
                            // html += '		</li>';
                            html += '		<li class=""  id="tablab">';
                            html += '		    <a data-toggle="tab" href="#lab" data-id="tablab" ><?php echo lang('labs'); ?></a>';
                            html += '		</li>';
                            html += '		<li class=""  id="tabdocuments">';
                            html += '		    <a data-toggle="tab" href="#documents" data-id="tabdocuments" ><?php echo lang('documents'); ?></a>';
                            html += '		</li>';
                            html += '		</ul>';
                            html += '		</header>';
                            html += '		<div class="panel" style="font-size:80%;">';
                            html += '			<div class="tab-content">';
                            html += '				<div id="consultation" class="tab-pane active">';
                            html += '					<div class="">';
                            html += '						<div class="adv-table editable-table ">';
                            html += '							<table class="table table-hover progress-table text-center_ patient-table" id="">';
                            html += '								<thead>';
                            html += '									<tr>';
                            html += '										<th><?php echo lang('date'); ?></th>';
                            html += '										<th><?php echo lang('libelle'); ?></th>';
                            html += '										<th><?php echo lang('cons_effectuer'); ?></th>';
                            <?php if (!$this->ion_auth->in_group(array('Patient'))) { ?>
                                html += '										<th class="no-print"><?php echo lang('options'); ?></th>';
                            <?php } ?>
                            html += '									</tr>';
                            html += '								</thead>';
                            html += '								<tbody>';
                            var medical_histories = response.medical_histories;
                            // alert(JSON.stringify(medical_histories));
                            for (i = 0; i < medical_histories.length; i++) {
                                var unixTime = medical_histories[i]['date'];
                                var myDate = new Date(unixTime * 1000);
                                var date = myDate.getDate();
                                var month = myDate.getMonth();
                                var year = myDate.getFullYear();
                                var fullDate = pad(date) + "/" + pad(month + 1) + "/" + year;
                                html += '									<tr class="">';
                                html += '											<td>' + fullDate + '</td>';
                                html += '											<td>' + medical_histories[i]['title'] + '</td>';
                                html += '											<td>' + medical_histories[i]['first_name'] + ' ' + medical_histories[i]['last_name'] + '</td>';
                                html += '											<td><button type="button" class="btn btn-info btn-xs btn_width editbutton" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="' + medical_histories[i]['id'] + '"><i class="fa fa-eye"></i> </button></td>';
                                html += '									</tr>';
                            }
                            html += '								</tbody>';
                            html += '							</table>';
                            html += '						</div>';
                            html += '					</div>';
                            html += '				</div>';


                            html += '				<div id="lab" class="tab-pane">';
                            html += '					<div class="">';
                            html += '						<div class="adv-table editable-table ">';
                            html += '							<table class="table table-hover progress-table text-center_ patient-table" id="">';
                            html += '								<thead>';
                            html += '									<tr>';
                            html += '										<th><?php echo lang('id'); ?></th>';
                            html += '										<th><?php echo lang('date'); ?></th>';
                            html += '										<th class="no-print"><?php echo lang('options'); ?></th>';
                            html += '									</tr>';
                            html += '								</thead>';
                            html += '								<tbody>';
                            var labs = response.labs;
                            // alert(JSON.stringify(medical_histories));
                            for (i = 0; i < labs.length; i++) {
                                if (labs[i]["report"]) {
                                    var unixTime = labs[i]['date'];
                                    var myDate = new Date(unixTime * 1000);
                                    var date = myDate.getDate();
                                    var month = myDate.getMonth();
                                    var year = myDate.getFullYear();
                                    var fullDate = pad(date) + "/" + pad(month + 1) + "/" + year;
                                    html += '									<tr class="">';
                                    html += '											<td>' + labs[i]["code"] + '</td>';
                                    html += '											<td>' + fullDate + '</td>';
                                    html += '											<td><button type="button" class="btn btn-info btn-xs btn_width editlab" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="' + labs[i]['id'] + '"><i class="fa fa-eye"></i> </button></td>';
                                    html += '									</tr>';
                                }
                            }
                            html += '								</tbody>';
                            html += '							</table>';
                            html += '						</div>';
                            html += '					</div>';
                            html += '				</div>';


                            html += '				<div id="documents" class="tab-pane">';
                            html += '					<div class="">';
                            html += '						<div class="adv-table editable-table ">';
                            html += '							<div class="">';
                            var patient_materials = response.patient_materials;
                            for (i = 0; i < patient_materials.length; i++) {
                                html += '									<div class="panel col-md-3" style="height: 200px; margin-right: 10px; margin-bottom: 36px; background: #f1f1f1; padding: 34px;">';
                                html += '										<div class="post-info">';
                                html += '											<a class="example-image-link" href="' + patient_materials[i]["url"] + '" data-lightbox="example-1"><img class="example-image" src="' + patient_materials[i]["url"] + '" alt="image-1" height="100" width="100" /></a>';
                                html += '										</div>';
                                html += '										<div class="post-info">';
                                if (patient_materials[i]["title"] != "") {
                                    html += patient_materials[i]["title"];
                                }
                                html += '										</div>';
                                html += '										<p></p>';
                                html += '										<div class="post-info">';
                                html += '											<a class="btn btn-info btn-xs btn_width" href="' + patient_materials[i]["url"] + '" download> <?php echo lang('download'); ?> </a>';
                                html += '										</div>';
                                html += '									</div>';
                            }
                            html += '							</div>';
                            html += '						</div>';
                            html += '					</div>';
                            html += '				</div>';



                            html += '			</div>';
                            html += '		</div>';
                            // html += '		</section>';
                            html += '</div>';
                            $('.patient_full_details').html(html);
                            $('.patient-table').DataTable({
                                responsive: true,
                                // dom: "<'row'<'col-sm-6 pull-left'l><'col-sm-6 pull-right'f>>" +
                                // "<'row'<'col-sm-12'tr>>" +
                                // "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                                dom: "<'row'<'col-sm-12'l>>" +
                                    "<'row'<'col-sm-12'f>>" +
                                    "<'row'<'col-sm-12'tr>>" +
                                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                                lengthMenu: [
                                    [5, 10, 25, 50, 100, -1],
                                    ['5', '10', '25', '50', '100', 'Tout afficher']
                                ],
                                iDisplayLength: 5,
                                "order": [
                                    //  [0, "desc"]
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
                                    if (response.medical_history.first_name && response.medical_history.first_name) {
                                        $('#medical_historyEditForm').find('[id="effectuer_par"]').html(response.medical_history.first_name + ' ' + response.medical_history.last_name).end()
                                    } else {
                                        $('#medical_historyEditForm').find('[id="effectuer_par"]').html(response.medical_history.username).end()
                                    }

                                });
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

                        }

                    }
                });


            }


        });


    });
</script>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<script src="<?php echo base_url(); ?>common/js/lightbox.js"></script>
<script class="include" type="text/javascript" src="<?php echo base_url(); ?>common/js/jquery.dcjqaccordion.2.7.js"></script>
<!--script for this page only-->
<script src="<?php echo base_url(); ?>common/js/editable-table.js"></script>
<script src="<?php echo base_url(); ?>common/assets/fullcalendar/fullcalendar.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>common/assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script src="<?php echo base_url(); ?>common/js/webservice/CommonFunction.js?<?php echo time(); ?>"></script>
<script src="<?php echo base_url(); ?>common/js/webservice/xmltojson.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>



<?php
$language = $this->db->get('settings')->row()->language;

if ($language == 'english') {
    $lang = 'en';
} elseif ($language == 'spanish') {
    $lang = 'es';
} elseif ($language == 'french') {
    $lang = 'fr';
} elseif ($language == 'portuguese') {
    $lang = 'pt';
} elseif ($language == 'arabic') {
    $lang = 'ar';
} elseif ($language == 'italian') {
    $lang = 'it';
}
?>



<script src='<?php echo base_url(); ?>common/assets/fullcalendar/locale/<?php echo $lang; ?>.js'></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#calendar').fullCalendar({
            lang: 'en',
            events: 'appointment/getAppointmentByJason',
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
            eventClick: function(event) {
                $('#medical_history').html("");
                if (event.id) {
                    /* $.ajax({
                           url: 'patient/getMedicalHistoryByJason?id=' + event.id + '&from_where=calendar',
                           method: 'GET',
                           data: '',
                           dataType: 'json',
                       }).success(function(response) {
                           // Populate the form fields with the data returned from server
                           $('#medical_history').html("");
                           $('#medical_history').append(response.view);
                       });*/
                    //alert(event.id);
                    window.location.href = "patient/medicalHistory?id=" + event.id;
                }

                /* $('#cmodal').modal('show');*/

            },

            /* eventMouseover: function (calEvent, domEvent) {
             var layer = "<div id='events-layer' class='fc-transparent' style='position:absolute; width:100%; height:100%; top:-1px; text-align:right; z-index:100'>Description</div>";
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


<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script>
    var element = document.getElementById('mobNo2');
    var mobNo3 = document.getElementById('mobNo3');
    var mobNo4 = document.getElementById('mobNo4');
    var mobNo7 = document.getElementById('mobNo7');
    var mobNo8 = document.getElementById('mobNo8');
    var mobNo9 = document.getElementById('mobNo9');
    var mobNo10 = document.getElementById('mobNo10');
    var maskOptions = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var mask = IMask(element, maskOptions);
    mask.value = "{-- --- -- --";

    var maskOptions3 = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var mask3 = IMask(mobNo3, maskOptions3);
    mask3.value = "{-- --- -- --";

    var maskOptions4 = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var mask4 = IMask(mobNo4, maskOptions4);
    mask4.value = "{-- --- -- --";


    var maskOptions7 = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var mask7 = IMask(mobNo7, maskOptions7);
    mask7.value = "{-- --- -- --";


    var maskOptions8 = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var mask8 = IMask(mobNo8, maskOptions8);
    mask8.value = "{-- --- -- --";


    var maskOptions9 = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var mask9 = IMask(mobNo9, maskOptions9);
    mask9.value = "{-- --- -- --";

    var maskOptions10 = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var mask10 = IMask(mobNo10, maskOptions10);
    mask10.value = "{-- --- -- --";
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".js-example-basic-single").select2();

        $(".js-example-basic-multiple").select2();


        $('#search_date').on("change", function(e) {

            var date = $('#search_date').val();
            e.preventDefault(e);

            $.ajax({
                url: 'appointment/getAppoinmentListByDate?date=' + date,
                method: 'GET',
            }).success(function(response) {
                $('#medical_history_rdv').html("");
                $('#medical_history_rdv').append(response);
            });
            $('#cmodal_rdv').modal('show');
        });
        $('.datetimepicker_ip').datetimepicker({
            format: "dd/mm/yyyy hh:ii",
            autoclose: true,
            todayBtn: true,
            isRTL: false,

        });
    });
</script>

<script>
    $(document).ready(function() {
        var bt = document.getElementById('validationPatient');
        // bt.disabled = true;
        // var btCharge = document.getElementById('validationPatientCharge');
        // if (btCharge) {
        //     btCharge.disabled = true;
        // }
        // var btChargeEdit = document.getElementById('validationPatientChargeEdit');
        // if (btChargeEdit) {
        //     btChargeEdit.disabled = true;
        // }

        $('.wrapper').click(function() {
            $('#myInputautocomplete-list').html('');
            $('#search_patient').val('');
        });

        $('#search_patient').keyup(function() {



            var search_query = $(this).val();
            if (search_query == "") {
                $('#myInputautocomplete-list').html('');
                return;
            }
            var form_data = {
                search_query: search_query
            }
            var resp_data_format = "";
            $.ajax({
                url: 'home/search_patients',
                data: form_data,
                method: "get",
                dataType: "json",
                success: function(response) {

                    if (response.length > 0) {
                        var html = "";

                        for (var i = 0; i < response.length; i++) {

                            var single = response[i];

                            if (single['img_url'] == null) {
                                single['img_url'] = 'uploads/imgUsers/contact-512.png';
                            }


                            html += '<div class="text-center"> <img src="' + single['img_url'] + '" width="30" height="30">  <a href="patient/medicalHistory?id=' + single["id"] + '"><strong>' + single['name'] + ' </strong> ' + single['last_name'] + ' <small> ' + single['patient_id'] + ' </small>  </a> </div>';
                        }


                    } else {
                        html += '<div>Aucun résultat trouvé</div>';
                    }

                    $('#myInputautocomplete-list').html(html);
                }
            });

        });






        $('.timepicker-default').timepicker({
            defaultTime: 'value'
        });

    });
</script>




<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    var phoneInput;
    var phoneInput_patient_edit_dossier;
    var phoneInput_patient_edit_contact_dossier;
    var phone_contact_patient;
    var phoneInput_patient;
    var phoneInput_patient_edit;
    var phoneInput_patient_contact_edit;
    var phone_patient_edit_light;
    var phone_patient_edit_light_partenaire;


    $(document).ready(function() {
        const phoneInputField = document.querySelector("#phone");
        const phoneInputField_patient = document.querySelector("#phone_patient");
        const phoneInputField_patient_edit = document.querySelector("#phone_patient_edit");
        const phoneInputField_patient_contact_edit = document.querySelector("#phone_patient_contact_edit");
        const phone_contact = document.querySelector("#phone_contact");

        const phoneInputField_patient_edit_dossier = document.querySelector("#phone_patient_edit_dossier");
        const phoneInputField_patient_contact_edit_dossier = document.querySelector("#phone_patient_contact_edit_dossier");
        const phone_patient_edit_light_number = document.querySelector("#phone_patient_edit_light");
        const phone_patient_edit_light_number_partenaire = document.querySelector("#phone_patient_edit_light_partenaire");
        var queryString = window.location.href;

    
        if (queryString.indexOf('users') !== -1) {

            phoneInput = window.intlTelInput(phoneInputField, {
                preferredCountries: ["SN", "bf", "ca", "us", "fr", "co", "in", "de"],
                initialCountry: "auto",
                geoIpLookup: getIp,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

        } else if (queryString.indexOf('partenaire') !== -1) {
            
            phone_patient_edit_light_patenaire = window.intlTelInput(phone_patient_edit_light_number_partenaire, {
                preferredCountries: ["SN", "bf", "ca", "us", "fr", "co", "in", "de"],
                initialCountry: "auto",
                geoIpLookup: getIp,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

        }
        else if (queryString.indexOf('patient') !== -1) {
            phone_contact_patient = window.intlTelInput(phone_contact, {
                preferredCountries: ["SN", "bf", "ca", "us", "fr", "co", "in", "de"],
                initialCountry: "auto",
                geoIpLookup: getIp,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

            phoneInput_patient = window.intlTelInput(phoneInputField_patient, {
                preferredCountries: ["SN", "bf", "ca", "us", "fr", "co", "in", "de"],
                initialCountry: "auto",
                geoIpLookup: getIp,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

            phoneInput_patient_edit = window.intlTelInput(phoneInputField_patient_edit, {
                preferredCountries: ["SN", "bf", "ca", "us", "fr", "co", "in", "de"],
                initialCountry: "auto",
                geoIpLookup: getIp,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });


            phoneInput_patient_contact_edit = window.intlTelInput(phoneInputField_patient_contact_edit, {
                preferredCountries: ["SN", "bf", "ca", "us", "fr", "co", "in", "de"],
                initialCountry: "auto",
                geoIpLookup: getIp,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });


        }
 
        else {
            phone_contact_patient = window.intlTelInput(phone_contact, {
                preferredCountries: ["SN", "bf", "ca", "us", "fr", "co", "in", "de"],
                initialCountry: "auto",
                geoIpLookup: getIp,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

            phoneInput_patient = window.intlTelInput(phoneInputField_patient, {
                preferredCountries: ["SN", "bf", "ca", "us", "fr", "co", "in", "de"],
                initialCountry: "auto",
                geoIpLookup: getIp,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

            phoneInput_patient_edit = window.intlTelInput(phoneInputField_patient_edit, {
                preferredCountries: ["SN", "bf", "ca", "us", "fr", "co", "in", "de"],
                initialCountry: "auto",
                geoIpLookup: getIp,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });


            phoneInput_patient_contact_edit = window.intlTelInput(phoneInputField_patient_contact_edit, {
                preferredCountries: ["SN", "bf", "ca", "us", "fr", "co", "in", "de"],
                initialCountry: "auto",
                geoIpLookup: getIp,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });


        }

    });







    //	const info = document.querySelector(".alert-info");
    // const danger = document.querySelector(".alert-danger");

    function numberChangePatientEditDossier(event) {

        event.preventDefault();

        var bt = document.getElementById('validationPatientEditDossier');
        var phoneNumber2 = phoneInput_patient_edit_dossier.getNumber();
        // danger.style.display = "";
        // info.style.display = "";
        if (phoneNumber2.indexOf('+') == -1) {

            bt.disabled = true;

            //danger.innerHTML = `Format numéro téléphone incorrect <strong>${phoneNumber2}</strong>`;
        } else {
            //info.innerHTML = `Numéro de téléphone : <strong>${phoneNumber2}</strong>`;

            document.getElementById('phoneValide_patient_edit_dossier').value = phoneNumber2;
            bt.disabled = false;

        }


    }


    function numberChangePatientContactEditDossier(event) {

        event.preventDefault();


        var bt = document.getElementById('validationPatientEditDossier');
        var phoneNumber2 = phoneInput_patient_edit_contact_dossier.getNumber();
        // danger.style.display = "";
        // info.style.display = "";

        if (phoneNumber2.indexOf('+') == -1) {

            bt.disabled = true;

            //danger.innerHTML = `Format numéro téléphone incorrect <strong>${phoneNumber2}</strong>`;
        } else {
            //info.innerHTML = `Numéro de téléphone : <strong>${phoneNumber2}</strong>`;

            document.getElementById('phoneValide_patient_contact_edit_dossier').value = phoneNumber2;
            bt.disabled = false;

        }


    }

    function numberChange(event) {

        event.preventDefault();

        var bt = document.getElementById('valider');
        var phoneNumber2 = phoneInput.getNumber();
        // danger.style.display = "";
        // info.style.display = "";
        if (phoneNumber2.indexOf('+') == -1) {

            bt.disabled = true;

            //danger.innerHTML = `Format numéro téléphone incorrect <strong>${phoneNumber2}</strong>`;
        } else {
            //info.innerHTML = `Numéro de téléphone : <strong>${phoneNumber2}</strong>`;

            document.getElementById('phoneValide').value = phoneNumber2;
            bt.disabled = false;

        }


    }


    function numberChangePatient(event) {

        event.preventDefault();

        var bt = document.getElementById('validationPatient');
        var phoneNumber2 = phoneInput_patient.getNumber();
        // danger.style.display = "";
        // info.style.display = "";
        if (phoneNumber2.indexOf('+') == -1) {

            bt.disabled = true;

            //danger.innerHTML = `Format numéro téléphone incorrect <strong>${phoneNumber2}</strong>`;
        } else {
            //info.innerHTML = `Numéro de téléphone : <strong>${phoneNumber2}</strong>`;

            document.getElementById('phoneValide_patient').value = phoneNumber2;
            bt.disabled = false;

        }


    }

    function numberChangeContactPatient(event) {

        event.preventDefault();

        var bt = document.getElementById('validationPatient');
        var phoneNumber2 = phone_contact_patient.getNumber();
        // danger.style.display = "";
        // info.style.display = "";
        if (phoneNumber2.indexOf('+') == -1) {

            bt.disabled = true;

            //danger.innerHTML = `Format numéro téléphone incorrect <strong>${phoneNumber2}</strong>`;
        } else {
            //info.innerHTML = `Numéro de téléphone : <strong>${phoneNumber2}</strong>`;

            document.getElementById('phone_contact_recuperation').value = phoneNumber2;
            bt.disabled = false;

        }


    }



    function numberChangePatientEdit(event) {

        event.preventDefault();
        var bt = document.getElementById('validationPatientEdit');
        var phoneNumber2 = phoneInput_patient_edit.getNumber();
        // danger.style.display = "";
        // info.style.display = "";

        if (phoneNumber2.indexOf('+') == -1) {

            bt.disabled = true;

            //danger.innerHTML = `Format numéro téléphone incorrect <strong>${phoneNumber2}</strong>`;
        } else {
            //info.innerHTML = `Numéro de téléphone : <strong>${phoneNumber2}</strong>`;

            document.getElementById('phoneValide_patient_edit').value = phoneNumber2;
            bt.disabled = false;

        }


    }


    function numberChangePatientEditLight(event) {

        event.preventDefault();
        var bt = document.getElementById('validationPatientEditLight');
        var phoneNumber2 = phone_patient_edit_light.getNumber();
        // danger.style.display = "";
        // info.style.display = "";

        if (phoneNumber2.indexOf('+') == -1) {
            bt.disabled = true;

            //danger.innerHTML = `Format numéro téléphone incorrect <strong>${phoneNumber2}</strong>`;
        } else {
            //info.innerHTML = `Numéro de téléphone : <strong>${phoneNumber2}</strong>`;
            bt.disabled = false;
            document.getElementById('phoneValide_patient_edit_Light').value = phoneNumber2;
            //    bt.disabled = false;

        }


    }

    function numberChangePatientEditLightPartenaire(event) {

        event.preventDefault();
        var bt = document.getElementById('validationPatientEditLightPartenaire');
        var phoneNumber2 = phone_patient_edit_light_patenaire.getNumber();
        // danger.style.display = "";
        // info.style.display = "";

        if (phoneNumber2.indexOf('+') == -1) {
            bt.disabled = true;

            //danger.innerHTML = `Format numéro téléphone incorrect <strong>${phoneNumber2}</strong>`;
        } else {
            //info.innerHTML = `Numéro de téléphone : <strong>${phoneNumber2}</strong>`;
            bt.disabled = false;
            document.getElementById('phoneValide_patient_edit_Light_partenaire').value = phoneNumber2;
            //    bt.disabled = false;

        }


    }


    function numberChangePatientContactEdit(event) {

        event.preventDefault();

        var bt = document.getElementById('validationPatientEdit');
        var phoneNumber2 = phoneInput_patient_contact_edit.getNumber();
        // danger.style.display = "";
        // info.style.display = "";
        if (phoneNumber2.indexOf('+') == -1) {

            bt.disabled = true;

            //danger.innerHTML = `Format numéro téléphone incorrect <strong>${phoneNumber2}</strong>`;
        } else {
            //info.innerHTML = `Numéro de téléphone : <strong>${phoneNumber2}</strong>`;

            document.getElementById('phoneValide_patient_contact_edit').value = phoneNumber2;
            bt.disabled = false;

        }


    }


    function getIp(callback) {
        fetch('https://ipinfo.io/json?token=a6703e9674cfb8', {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then((resp) => resp.json())
            .catch(() => {
                return {
                    country: 'auto',
                };
            })
            .then((resp) => callback(resp.country));
    }
</script>
<script type="text/javascript">
    if ($.fn.datepicker.dates) {
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
    $('#birthdates').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
        endDate: new Date()
    });
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

    });
    $('#date_valid').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
    });

    $('#date').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,

    });
    $('#date_add').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
        startDate: new Date()

    });
    $('#date_edit').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
        startDate: new Date()

    });
    $('#date_validAssurance').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
        startDate: new Date()

    });

    $('#date_fin').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,

    });

    $('#birthdate2').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
        endDate: new Date()
    });

    $('#add_date').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
        endDate: new Date()
    });
    $('#add_date1').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
        endDate: new Date()
    });
    $('#add_dateVaccination').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
        endDate: new Date()
    });

    $('#date_end_prestation').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
        endDate: new Date()
    });

    $('#add_hospitalisation').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
    });
    // $('#birth_position2').datepicker({
    // language: "fr",
    // format: "dd/mm/yyyy",
    // todayHighlight: true,
    // autoclose: true,
    // });

    $('.dpd1').datepicker({
        language: "fr",
        format: "dd-mm-yyyy",
        todayHighlight: true,
        autoclose: true,
    });
    $('.dpd2').datepicker({
        language: "fr",
        format: "dd-mm-yyyy",
        todayHighlight: true,
        autoclose: true,
    });

    $('.dateRDV').datepicker({
        language: "fr",
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
    });

    // function recuperationNumero(event) {
    //     var bt = document.getElementById('validationPatient');
    //     //   bt.disabled = true;
    //     var num = $('#mobNo2').val();
    //     var numFormat = num.replace(/[^\d]/g, '');
    //     document.getElementById('phone2').value = numFormat;
    //     var numeroTelephone = $('#phone2').val();
    //     // if (numeroTelephone.length != 12) {
    //     //     bt.disabled = true;
    //     // } else {
    //     //     bt.disabled = false;
    //     // }

    // }

    function recuperationNumeroCharge(event) {
        var bt = document.getElementById('validationPatientCharge');
        var num = $('#mobNo4').val();
        var numFormat = num.replace(/[^\d]/g, '');
        document.getElementById('phone4phoneNumber').value = numFormat;
        // var numeroTelephone = $('#phone4phoneNumber').val();
        // if (numeroTelephone.length != 12) {
        //     bt.disabled = true;
        // } else {
        //     bt.disabled = false;
        // }

    }






    function recuperationContact(event) {
        var num = $('#mobNo5').val();
        var numFormat = num.replace(/[^\d]/g, '');
        document.getElementById('phonecontact2').value = numFormat;

    }

    function recuperationCharge(event) {

        var num = $('#mobNo8').val();
        var numFormat = num.replace(/[^\d]/g, '');
        document.getElementById('phone_').value = numFormat;

    }

    function recuperationPersonneCharge(event) {

        var num = $('#mobNo4').val();
        var numFormat = num.replace(/[^\d]/g, '');
        document.getElementById('phone4phoneNumber').value = numFormat;

    }


    var checkbox = document.getElementById('customCheck');
    var pos_matricule = document.getElementById('pos_matricule');

    // var checkbox2 = document.getElementById('customCheck2');
    var pos_matricule2 = document.getElementById('pos_matricule2');



    checkbox.onclick = function() {
        if (this.checked) {
            pos_matricule.style['display'] = 'block';
        } else {
            pos_matricule.style['display'] = 'none';

        }
    };

    /*checkbox2.onclick = function() {
        if (this.checked) {
            pos_matricule2.style['display'] = 'block';
        } else {
            pos_matricule2.style['display'] = 'none';

        }
    };*/



    var urlModal = location.pathname.split("/").slice(2).join("/");
    document.getElementById('urlModal').value = urlModal;

    $('.flash_message_phone_unique').empty();
    //rf fct generik
    // function recuperationNumeroChargephoneNumber(event, id_phone_format, id_phone, required = '') {
    //     var bt = document.getElementById('validationPatient');
    //     var id = '#' + id_phone_format;
    //     var patient = $('#id').val();
    //     var num = $(id).val();
    //     var numFormat = num.replace(/[^\d]/g, '');
    //     document.getElementById(id_phone).value = numFormat;

    //     var btvalidationPatientCharge = document.getElementById('validationPatientCharge');
    //     var btvalidationPatientChargeEdit = document.getElementById('validationPatientChargeEdit');

    //     // console.log(num.length +' !---'+required);
    //     console.log(numFormat + '----' + numFormat.length + ' ---' + required);

    // if (numFormat.length != 12) {
    //     bt.disabled = true;
    //     btvalidationPatientCharge = true;
    //     btvalidationPatientChargeEdit = true;

    // } else {
    //     bt.disabled = false;
    //     btvalidationPatientCharge = false;
    //     btvalidationPatientChargeEdit = false;
    // }
    /* bt.disabled = true;
       $('.flash_message_phone_unique').empty();
         if (num.length != 12 && !required) {
            bt.disabled = true;
        } else {
            if(numFormat.length == 12){ 
                $.ajax({
                           url: 'patient/getPhoneUniqueByJason?num=' + numFormat+'&patient='+patient,
                           method: 'GET',
                           data: '',
                           dataType: 'json',
                       }).success(function(response) {
                          
                            if(response) {
                            
      console.log(response+'-***----phone unique');
                           $('.flash_message_phone_unique').empty().html('Ce numéro est déjà enrégistré.');
                          } else {
                               bt.disabled = false; 
                                  console.log('-ok--');
                          }
                       });
                   
                // bt.disabled = false;      
            }
           
        }*/
    // }
</script>

<script type="text/javascript">
    function printElementNew(elem) {

        window.print();
    }


    function downloadElementNew(elem, name) {
        var id = '#' + elem;
        var pdf = new jsPDF('p', 'pt', 'letter');

        pdf.addHTML($(id), function() {
            pdf.save(name + '.pdf');
        });
        $('.ignorepdf').show();
    }

    function dump(obj) {
        var out = '';
        for (var i in obj) {
            out += i + ": " + obj[i] + "\n";
        }

        alert(out);

        // or, if you wanted to avoid alerts...

        // var pre = document.createElement('pre');
        // pre.innerHTML = out;
        // document.body.appendChild(pre)
    }

    function recuperationAge() {

        var date_naissance = $('#birthdates').val();
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
            document.getElementById('agesFooter').value = age;
        } else {
            var age = curyear - useryear;
            document.getElementById('agesFooter').value = age;
        }

    }

    function downloadElementNew(elem, name) {
        var id = '#' + elem;
        var pdf = new jsPDF('p', 'pt', 'letter');

        pdf.addHTML($(id), function() {
            pdf.save(name + '.pdf');
        });
        $('.ignorepdf').show();
    }

    var chunkBytes = 300000;

    function pdfToServer(elem, name, paymentId, idPrestation, emailLight) {
        var id = '#' + elem;
        var doc = new jsPDF('p', 'pt', 'letter');
        // $(id).parent().css('display', 'block');
        doc.addHTML($(id), function() {
            fileName = name;
            reportFile = "files/sent/" + btoa(fileName) + ".pdf"
            console.log('pdfToServer ' + name + '');
            var pdf = doc.output();
            chunks = [];
            while (pdf) {
                if (pdf.length < chunkBytes) {
                    chunks.push(pdf);
                    break;
                } else {
                    chunks.push(pdf.substr(0, chunkBytes));
                    pdf = pdf.substr(chunkBytes);
                }
            }
            // console.log("chunks.length="+chunks.length);
            // document.getElementById('uploadingpercent').innerHTML="0%";  
            // document.getElementById('uploadingpdf').style.display="block";
            totalChunks = chunks.length;
            saveChunk(totalChunks, chunks, fileName);
            // doc.save("abc.pdf");

            sendEmail(paymentId, name, emailLight);
        });

        // doc.fromHTML($(id).html(), 10, 10);
        // doc.text(10, 10, 'This is a test EUEEUEUEEUEUEEUEUEEUE');
        // doc.autoPrint();

    }

    function sendEmail(paymentId, name, emailLight) {
        $.ajax({
            url: 'finance/sendEmailResultatsLight?paymentId=' + paymentId + "&name=" + name + "&emailLight=" + emailLight,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function(response) {
            // alert("ok");
        });
    }

    function saveChunk(totalChunks, chunks, fileName) {
        // alert(totalChunks +"::::"+ fileName + "::::" + chunks);
        var chunkNum = totalChunks - chunks.length;
        console.log("saveChunk chunks.length=" + chunks.length + " chunkNum=" + chunkNum);
        var chunk = chunks.shift();
        var aChunk = btoa(chunk);
        console.log("aChunk.length=" + aChunk.length);
        var data = new FormData();
        data.append("chunkNum", chunkNum);
        data.append("fileName", fileName);
        data.append("pdfData", aChunk);

        var xhr = new XMLHttpRequest();
        xhr.onload = ajaxSuccess;
        xhr.onerror = ajaxError;
        xhr.open('post', 'finance/savePDFChunks', true);
        xhr.send(data);
    }

    function ajaxSuccess() {
        console.log('ajaxSuccess()');
        if (chunks.length > 0) {
            // var prog=(totalChunks-chunks.length)/totalChunks;
            // alert(Math.floor(prog*100)+"%");
            // document.getElementById('uploadingpercent').innerHTML=Math.floor(prog*100)+"%";
            // window.setTimeout("saveChunk()", 200);
        } else {
            // console.log('pdfToServer completed '+reportFile);
            // alert("pdfToServer completed "+chunks.length);
            // document.getElementById('downloadpdf').style.display="block";
            // document.getElementById('uploadingpdf').style.display="none";
            // var element = document.getElementById('pdfData');
            // element.href = "javascript:openPdfFile(); ";
            // element.target = "";
        }
    }

    function ajaxError() {
        alert("error");
    }
</script>





<script>
    $('.multi-select').multiSelect({
        selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder=' Rechercher...'>",
        selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder=''  id='searchPresta' >",
        afterInit: function(ms) {
            var that = this,
                $selectableSearch = that.$selectableUl.prev(),
                $selectionSearch = that.$selectionUl.prev(),
                selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                .on('keydown', function(e) {
                    if (e.which === 40) {
                        that.$selectableUl.focus();
                        return false;
                    }
                });

            that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                .on('keydown', function(e) {
                    if (e.which == 40) {
                        that.$selectionUl.focus();
                        return false;
                    }
                });
        },
        afterSelect: function() {
            this.qs1.cache();
            this.qs2.cache();
        },
        afterDeselect: function() {
            this.qs1.cache();
            this.qs2.cache();
        }
    });
</script>

<script>
    $('#my_multi_select3').multiSelect()
</script>

<script>
    $('.default-date-picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    });

    $('.afert_now').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        minDate: 0
    });

    $('.before_now').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        maxDate: 0
    });

    $('#date_valid').datepicker({
        dateFormat: "yy-mm-dd",
        autoclose: true,
        language: 'fr',
        minDate: -3
    });

    $('#date').on('changeDate', function() {
        $('#date').datepicker('hide');
    });

    $('#date1').on('changeDate', function() {
        $('#date1').datepicker('hide');
    });
</script>













<script type="text/javascript" src="<?php echo base_url(); ?>common/assets/select2/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>common/js/select2_fr.min.js"></script>



<script type="text/javascript">
    $(document).ready(function() {
        var windowH = $(window).height() - 60;
        var wrapperH = $('#container').height() - 60;
        if (windowH > wrapperH) {
            $('#sidebar').css('height', (windowH) + 'px');
        } else {
            $('#sidebar').css('height', (wrapperH) + 'px');
        }
        var windowSize = window.innerWidth;
        if (windowSize < 768) {
            $('#sidebar').removeAttr('style');
        }
    });

    function onElementHeightChange(elm, callback) {
        var lastHeight = elm.clientHeight,
            newHeight;
        (function run() {
            newHeight = elm.clientHeight;
            if (lastHeight != newHeight)
                callback();
            lastHeight = newHeight;
            if (elm.onElementHeightChangeTimer)
                clearTimeout(elm.onElementHeightChangeTimer);
            elm.onElementHeightChangeTimer = setTimeout(run, 200);
        })();
    }




    onElementHeightChange(document.body, function() {
        var windowH = $(window).height();
        var wrapperH = $('#container').height();
        if (windowH > wrapperH) {
            $('#sidebar').css('height', (windowH) + 'px');
        } else {
            $('#sidebar').css('height', (wrapperH) + 'px');
        }

        var windowSize = $(window).width();
        if (windowSize < 768) {
            $('#sidebar').removeAttr('style');
        }
    });







    $(window).resize(function() {

        /*  if (width == GetWidth()) {
              return;
          }

          var width = GetWidth();

          if (width < 600) {
              $('#sidebar').hide();
          } else {
              $('#sidebar').show();
          }*/

    });
</script>


<script>
    CKEDITOR.replace("description", {
        height: 400
    });
</script>

<script>
    function matchExact(r, str) {
        var match = str.match(r);
        return match && str === match[0];
    }

    function maskAllButLast4(cc) {
        return cc.replace(/.(?=.{4,}$)/g, '*')
    }

    function maskEmail(email) {
        if (email.trim() == null || email.trim() == "") {
            return "";
        }
        buff = email.split("@");

        part1 = buff[0];
        buff2 = buff[1].split(".");
        part2 = buff2[0];
        extension = buff2[1];

        part1_length = part1.length;
        part2_length = part2.length;


        for (i = 0; i < part1_length; i++) {
            // part1[i] = '*';
            part1 = replaceAt(part1, i, '*');
        }
        for (i = 0; i < part2_length; i++) {
            // part2[i] = '*';
            part2 = replaceAt(part2, i, '*');
        }

        return part1 + "@" + part2 + "." + extension;
    }

    function replaceAt(string, index, replace) {
        return string.substring(0, index) + replace + string.substring(index + 1);
    }

    function pad(n) {
        return n < 10 ? '0' + n : n
    }
</script>

<script type="text/javascript">
    function yesnoCheck() {
        if (document.getElementById('yesCheck').checked) {
            document.getElementById('ifYes').style.display = 'block';
            $('#matricule').prop('required', true);
            $('#grade').prop('required', true);
        } else {
            document.getElementById('ifYes').style.display = 'none';
            $('#matricule').prop('required', false);
            $('#grade').prop('required', false);
        }

    }

    function yesAddCheck() {
        if (document.getElementById('yesValid').checked) {
            document.getElementById('ifYesValid').style.display = 'block';
            $('#matriculeValid').prop('required', true);
            $('#gradeValid').prop('required', true);
        } else {
            document.getElementById('ifYesValid').style.display = 'none';
            $('#matriculeValid').prop('required', false);
            $('#gradeValid').prop('required', false);
        }

    }
</script>

</body>

</html>