<!--sidebar end-->
<!--main content start-->
<style>
    span.hr {
        display: block;
        height: 2px;
        border: 1;
        border-top: 2px solid #0D4D99;
        margin: 0;
        width: 100%;
        padding: 0;
        padding-bottom: 10px;
    }
</style>
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-12">
            <header class="panel-heading">
                <?php echo lang('add'); ?> <?php echo lang('consultation_medical'); ?>
            </header>
            <center>
                <div class="sidebar-toggle-box" style="">
                    <div class="nav notify-row" id="top_menu">
                        <img src="<?php echo !empty($entete) ? $entete : "uploads/entetePartenaires/default.png"; ?>" style="max-width:800px;max-height:200px;float:left;" />
                    </div>
                </div>
            </center>
            <div class="no-print">
                <div class="adv-table editable-table ">
                    <div class="clearfix">


                        <div class="col-md-12 panel">
                            <span class="hr"></span>
                            <div class="row">
                                <div class="col-md-6 pull-left">
                                    <h3 style="color:#0D4D99">Infos Patient</h3>
                                    <div class='row'>
                                        <div class="form-group col-md-4">
                                            <label><strong>Code Patient : </strong></label>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span><?php echo $patient->patient_id; ?></span>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class="form-group col-md-4">
                                            <label><strong>Prénom et Nom : </strong></label>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span><?php echo $patient->name . ' ' . $patient->last_name; ?></span>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class="form-group col-md-4">
                                            <label><strong>Téléphone : </strong></label>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span><?php echo $patient->phone; ?></span>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class="form-group col-md-4">
                                            <label><strong>Age : </strong></label>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span><?php echo $patient->age; ?> An(s)</span>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class="form-group col-md-4">
                                            <label><strong>Sexe : </strong></label>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span><?php echo $patient->sex; ?></span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6 pull-right">
                                    <h3 style="color:#0D4D99">Infos Actes</h3>
                                    <div class='row'>
                                        <div class="form-group col-md-4">
                                            <label><strong>Prescripteur Pr/Dr/Mme/Mr/ : </strong></label>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span><?php if (!empty($doctor)) {
                                                        echo 'Dr ' . $doctor->first_name . ' ' . $doctor->last_name;
                                                    } else echo 'Non renseigné '  ?> </span>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class="form-group col-md-4">
                                            <label><strong>Service : </strong></label>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span><?php echo $nom_organisation; ?></span>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class="form-group col-md-4">
                                            <label><strong>Date prescription : </strong></label>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span><?php echo $payments->date_string; ?></span>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class="form-group col-md-4">
                                            <label><strong>Numéro Dossier : </strong></label>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <span><?php echo $payments->code; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <span class="hr"></span>
                        </div>
                        <input type="hidden" name="payment_id" value="<?php echo $payments->id; ?>">

                        <div class='form-group col-md-6'>
                            <div class="form-group col-md-5">
                                <label><strong>Numéro de Régistre : </strong></label>
                            </div>
                            <div class="form-group col-md-5">
                                <input type="text" class="form-control pay_in " name="numeroRegistre" value='' placeholder="">
                            </div>
                        </div>
                        <div class='form-group col-md-6'>
                            <div class="form-group col-md-6">
                                <label><strong>Renseignement Clinique : </strong></label>
                            </div>
                            <div class="form-group col-md-6">
                                <textarea rows="4" cols="35" name="renseignementClinique"><?php echo $payments->renseignementClinique; ?></textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <span class="hr"></span>

            </div>

            <div class="">
                <form role="form" action="finance/addMedicalHistory" class="clearfix" method="post" enctype="multipart/form-data">

                    <input type="hidden" class="form-control form-control-inline input-medium default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="" readonly="">
                    <input type="hidden" class="form-control" name="date_string" id="today" value='' placeholder="" readonly="">
                    <div class="row">
                        <div class="col-md-4 lab pad_bot">
                            <label for="exampleInputEmail1">Service</label>
                            <input type="text" class="form-control" name="specialite" value='<?php echo $service_name; ?>' placeholder="" readonly="">
                        </div>
                        <div class="col-md-4 lab pad_bot">
                            <label for="exampleInputEmail1">Prestation</label>
                            <input type="text" class="form-control" name="namePrestation" value='<?php echo $prestations->prestation; ?>' placeholder="" readonly="">
                        </div>
                       
                    </div>
                    <br>
                    <!-- <div class="col-md-3 lab pad_bot">
                        <label for="exampleInputEmail1">CODE</label>
                        <input type="text" class="form-control" name="patient" id="patient" value='<?php echo $patient->patient_id; ?>' placeholder="" readonly="">
                        <input hidden value="<?php echo $patient->id; ?>" name="patient_id">
                    </div>
                    <div class="col-md-3 lab pad_bot">
                        <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                        <input type="text" class="form-control" name="patient" id="patient" value='<?php echo $patient->name . ' ' . $patient->last_name; ?>' placeholder="" readonly="">
                    </div>
                    <div class="col-md-3 lab pad_bot">
                        <label for="exampleInputEmail1">Age / An(s)</label>
                        <input type="text" class="form-control" name="age" id="agePoidsTaille" value='<?php echo $patient->age; ?>' placeholder="" readonly="">

                    </div>
                    <div class="col-md-3 lab pad_bot">
                        <label for="exampleInputEmail1">Sexe</label>
                        <input type="text" class="form-control" name="sexe" id="patient" value='<?php echo $patient->sex; ?>' placeholder="" readonly="">

                    </div> -->

                    <span class="hr"></span>
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color: #F5F5F5;text-align:center"><?php echo $prestations->prestation ?></div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-4 lab pad_bot">
                            <label for="exampleInputEmail1">Poids (kg)</label>
                            <input type="number" class="form-control pay_in " id="poids" name="poids" value='' step="0.1" placeholder="" min="0.3" max="150" onchange="poidsNormal(event)">
                            <div id="NormalPoids">
                            </div>
                        </div>

                        <div class="col-md-4 lab pad_bot">
                            <label for="exampleInputEmail1">Taille (cm)</label>
                            <input type="number" class="form-control pay_in " id="taille" name="taille" value='' placeholder="" min="44" max="230" onchange="tailleNormal(event)">
                            <div id="NormalTaille">
                            </div>
                        </div>
                        <div class="col-md-4 lab pad_bot">
                            <label for="exampleInputEmail1">Température (°C)</label>
                            <input type="number" class="form-control pay_in " step="0.1" id="temperature" name="temperature" value='' placeholder="" min="34.0" max="40.0">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 lab pad_bot">
                            <label for="exampleInputEmail1">Fréquence Respiratoire(mn)</label>
                            <input type="number" class="form-control pay_in " id="frequenceRespiratoire" name="frequenceRespiratoire" value='' placeholder="" min="10" max="40">
                        </div>
                        <div class="col-md-4 lab pad_bot">
                            <label for="exampleInputEmail1">Fréquence Cardiaque(bpm)</label>
                            <input type="number" class="form-control pay_in " id="frequenceCardiaque" name="frequenceCardiaque" value='' placeholder="" min="60" max="160">
                        </div>
                        <div class="col-md-4 lab pad_bot">
                            <label for="exampleInputEmail1">Saturation en O<sub>2</sub></label>
                            <input type="number" class="form-control pay_in " id="Saturationarterielle" name="Saturationarterielle" value='' placeholder="">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 lab pad_bot">
                            <label for="exampleInputEmail1">Glycémie Capillaire</label>
                            <input type="number" class="form-control pay_in " id="glycemyCapillaire" name="glycemyCapillaire" value='' placeholder="">
                        </div>
                        <div class="col-md-2 lab pad_bot">
                            <label for="exampleInputEmail1">Unité</label>
                            <select class="form-control m-bot15" id="glycemyCapillaireUnite" name="glycemyCapillaireUnite" value=''>
                                <option value="g/l">(g/l)</option>
                                <option value="mmlo/l">(mmlo/l)</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 lab pad_bot">
                            <label for="exampleHorairesOuverture">Tension Artérielle </label>
                        </div>
                        <div class="col-md-4 lab pad_bot">
                            <label for="exampleInputEmail1"><?php echo lang('systolique'); ?></label>
                            <input type="number" class="form-control pay_in " id="systolique" name="systolique" value='' placeholder="" onchange="donneTension(event)" onkeyup="tensionArterielles(event)" min="50" max="250">
                            <div id="systoleDonne"></div>
                            <div id="systoleDonnes"></div>
                        </div>
                        <div class="col-md-4 lab pad_bot">
                            <label for="exampleInputEmail1"><?php echo lang('diastolique'); ?></label>
                            <input type="number" class="form-control pay_in " id="diastolique" name="diastolique" value='' placeholder="" onchange="donneTension(event)" onkeyup="tensionArterielles(event)" min="30" max="200">
                            <div id="diastoleDonne"></div>
                            <div id="diastoleDonnes"></div>
                        </div>
                        <div class="col-md-4 lab pad_bot">
                            <label for="exampleInputEmail1"><?php echo lang('resultat'); ?></label>
                            <div id="tension"></div>
                            <input type="text" class="form-control pay_in " id="tensionArterielle" name="tensionArterielle" value='' placeholder="" readonly>
                            <input type="hidden" class="form-control pay_in" id="tensionName" name="tensionArterielle" value="">
                            <input type="hidden" class="form-control pay_in" id="hypertensionSystolique" name="hypertensionSystolique" value="">
                            <input type="hidden" class="form-control pay_in" id="hypertensionDiastolique" name="hypertensionDiastolique" value="">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group col-md-12">
                        <label class=""><?php echo lang('observation_medical'); ?></label>
                        <textarea class="form-control ckeditor" name="description" id="description" value="" rows="70" cols="70" required="">
                        <?php
                        if (!empty($setval)) {
                            echo set_value('template');
                        }
                        if (!empty($template->template)) {
                            echo $template->template;
                        }
                        ?></textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <input type="hidden" name="code" value='<?php echo $payments->code; ?>'>
                        <input type="hidden" name="payment_id" value='<?php echo $payments->id; ?>'>
                        <input type="hidden" name="prestation" value='<?php echo $prestations->prestation; ?>'>
                    </div>

                    <input type="hidden" name="prestation" value='<?php echo $prestations->id; ?>'>
                    <input type="hidden" name="redirect" value='finance/paymentLabo'>
                    <div class="col-md-12 lab">
                        <a href="finance/paymentLabo" class="btn btn-info btn-secondary pull-left"><?php echo lang('retour'); ?></a>
                        <button type="submit" name="submit" id="validationConsultation" class="btn btn-info pull-right"><?php echo lang('effectuer'); ?></button>
                    </div>
                </form>
            </div>

        </section>






    </section>
    <!-- page end-->
</section>
</section>
<!--main content end-->
<!--footer start-->






<!-- Add Department Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_medical_history'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" action="patient/addMedicalHistory" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                        <select class="form-control m-bot15 js-example-basic-single" name="patient_id" value=''>
                            <?php foreach ($patients as $patient) { ?>
                                <option value="<?php echo $patient->id; ?>"> <?php echo $patient->name . ' ' . $patient->last_name; ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('title'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium" name="title" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-12">
                        <label class=""><?php echo lang('description'); ?></label>
                        <textarea class="ckeditor form-control" name="description" value="" rows="10"></textarea>
                    </div>
                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="redirect" value='patient/caseList'>
                    <section class="col-md-12">
                        <button type="submit" name="submit" class="btn btn-info submit_button pull-right"> <?php echo lang('submit'); ?></button>
                    </section>
                </form>


            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>
<!-- Add Department Modal-->

<!-- Edit Department Modal-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('edit_medical_history'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" id="medical_historyEditForm" class="clearfix" action="patient/addMedicalHistory" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium default-date-picker" name="date" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                        <select class="form-control m-bot15 patient" id="patientchoose1" name="patient_id" value=''>

                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('title'); ?></label>
                        <input type="text" class="form-control form-control-inline input-medium" name="title" id="exampleInputEmail1" value='' placeholder="">
                    </div>
                    <div class="form-group col-md-12">
                        <label class=""><?php echo lang('description'); ?></label>
                        <div class="">
                            <textarea class="ckeditor form-control editor" id="editor" name="description" value="" rows="10"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="redirect" value='patient/caseList'>
                    <div class="col-md-12">
                        <button type="submit" name="submit" class="btn btn-info submit_button pull-right">Submit</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>






<div class="modal fade" id="caseModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close no-print" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('case'); ?> <?php echo lang('details'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" id="medical_historyEditForm" class="clearfix" action="patient/addMedicalHistory" method="post" enctype="multipart/form-data">
                    <div class="form-group col-md-12 row">
                        <div class="form-group col-md-6 case_date_block">
                            <label for="exampleInputEmail1"><?php echo lang('case'); ?> <?php echo lang('creation'); ?> <?php echo lang('date'); ?></label>
                            <div class="case_date"></div>
                        </div>
                        <div class="form-group col-md-6 case_patient_block">
                            <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                            <div class="case_patient"></div>
                            <div class="case_patient_id"></div>
                        </div>
                        <div>
                            <hr>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"><?php echo lang('title'); ?> </label>
                        <div class="case_title"></div>
                        <hr>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1"> <?php echo lang('details'); ?></label>
                        <div class="case_details"></div>
                        <hr>
                    </div>


                    <div class="panel col-md-12">
                        <h5 class="pull-right">
                            <?php echo $settings->title . '<br>' . $settings->address; ?>
                        </h5>
                    </div>


                    <div class="panel col-md-12 no-print">
                        <a class="btn btn-info invoice_button pull-right" onclick="javascript:window.print();"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
                    </div>

                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>



<style>
    @media print {

        .modal-content {
            width: 100%;
        }


        .modal {
            overflow: hidden;
        }

        .case_date_block {
            width: 50%;
            float: left;
        }

        .case_patient_block {
            width: 50%;
            float: left;
        }

    }
</style>








<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script type="text/javascript">
    $(".table").on("click", ".editbutton", function() {
        // Get the record's ID via attribute  
        var iid = $(this).attr('data-id');

        $.ajax({
            url: 'patient/editMedicalHistoryByJason?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function(response) {
            // Populate the form fields with the data returned from server
            var de = response.medical_history.date * 1000;
            var d = new Date(de);
            var da = d.getDate() + '-' + (d.getMonth() + 1) + '-' + d.getFullYear();
            $('#medical_historyEditForm').find('[name="id"]').val(response.medical_history.id).end()
            $('#medical_historyEditForm').find('[name="date"]').val(da).end()
            //   $('#medical_historyEditForm').find('[name="patient"]').val(response.medical_history.patient_id).end()
            $('#medical_historyEditForm').find('[name="title"]').val(response.medical_history.title).end()
            CKEDITOR.instances['editor'].setData(response.medical_history.description)
            var option = new Option(response.patient.name + '-' + response.patient.id, response.patient.id, true, true);
            $('#medical_historyEditForm').find('[name="patient_id"]').append(option).trigger('change');
            //   $('.js-example-basic-single.patient').val(response.medical_history.patient_id).trigger('change');

            $('#myModal2').modal('show');

        });
    });
</script>

<script type="text/javascript">
    $(".table").on("click", ".case", function() {
        // Get the record's ID via attribute  
        var iid = $(this).attr('data-id');

        $('.case_date').html("").end()
        $('.case_details').html("").end()
        $('.case_title').html("").end()
        $('.case_patient').html("").end()
        $('.case_patient_id').html("").end()
        $.ajax({
            url: 'patient/getCaseDetailsByJason?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function(response) {
            // Populate the form fields with the data returned from server
            var de = response.case.date * 1000;
            var d = new Date(de);


            var monthNames = [
                "January", "February", "March",
                "April", "May", "June", "July",
                "August", "September", "October",
                "November", "December"
            ];

            var day = d.getDate();
            var monthIndex = d.getMonth();
            var year = d.getFullYear();

            var da = day + ' ' + monthNames[monthIndex] + ', ' + year;


            $('.case_date').append(da).end()
            $('.case_patient').append(response.patient.name).end()
            $('.case_patient_id').append('ID: ' + response.patient.id).end()
            $('.case_title').append(response.case.title).end()
            $('.case_details').append(response.case.description).end()






            $('#caseModal').modal('show');

        });
    });

    dateaujourdhui = new Date();
    document.getElementById("today").value = dateaujourdhui.toLocaleDateString();
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
                url: "patient/getCaseList",
                type: 'POST',
            },
            scroller: {
                loadingIndicator: true
            },
            fixedHeader: true,
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
                    // columns: [0, 1, 2],
                    // }
                    // },
                    // {
                    // extend: 'pdfHtml5',
                    // className: 'dt-button-icon-left dt-button-icon-pdf',
                    // exportOptions: {
                    // columns: [0, 1, 2],
                    // }
                    // },
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
            lengthMenu: [
                [10, 25, 50, 100, -1],
                ['10', '25', '50', '100', 'Tout afficher']
            ],
            iDisplayLength: 10,
            "order": [
                [0, "desc"]
            ],
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

        table.buttons().container()
            .appendTo('.custom_buttons');
    });
</script>
<script>
    $(document).ready(function() {
        $("#patientchoose").select2({
            placeholder: '<?php echo lang('select_patient'); ?>',
            allowClear: true,
            ajax: {
                url: 'patient/getPatientinfo',
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
        $("#patientchoose1").select2({
            placeholder: '<?php echo lang('select_patient'); ?>',
            allowClear: true,
            ajax: {
                url: 'patient/getPatientinfo',
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
        var bt = document.getElementById('validationConsultation');
        bt.disabled = true;
        setTimeout(() => {
            $(".flashmessage").delay(3000).fadeOut(100);
            CKEDITOR.instances.description.on('key', function(e) {
                var description = CKEDITOR.instances['description'].getData().length;
                if (description < 12) {
                    bt.disabled = true;
                } else {
                    bt.disabled = false;
                }
            });
        }, 3000);

    });
</script>
<script type="text/javascript">
    function donneTension(event) {
        var bt = document.getElementById('validationConsultation');
        var systolique = $('#systolique').val();
        systolique = parseInt(systolique);
        var diastolique = $('#diastolique').val();
        diastolique = parseInt(diastolique);
        var tensionArterielle = document.getElementById('tensionArterielle');
        tensionArterielle.style['display'] = 'block';
        $('#diastoleDonnes').html(``);
        $('#systoleDonnes').html(``);
        bt.disabled = false;
        if (diastolique < 30) {
            bt.disabled = true;
            $('#diastoleDonnes').html(`<code class="flash_message">la valeur du diastole doit être supérieur à 30 et inférieur 200</code>`);

        }
        if (diastolique > 200) {
            $('#diastoleDonnes').html(`<code class="flash_message">la valeur du diastole doit être supérieur à 30 et inférieur 200</code>`);
            bt.disabled = true;
        }
        if (systolique < 50) {
            $('#systoleDonnes').html(`<code class="flash_message">la valeur du diastole doit être supérieur à 50 et inférieur 250</code>`);
            bt.disabled = true;
        }
        if (systolique > 250) {
            $('#systoleDonnes').html(`<code class="flash_message">la valeur du diastole doit être supérieur à 50 et inférieur 250</code>`);
            bt.disabled = true;
        }
    }

    function tensionArterielles(event) {
        var systolique = $('#systolique').val();
        systolique = parseInt(systolique);
        var diastolique = $('#diastolique').val();
        diastolique = parseInt(diastolique);
        var tensionArterielle = document.getElementById('tensionArterielle');
        tensionArterielle.style['display'] = 'block';
        $('#tension').html(``);
        if (systolique > 0 && diastolique > 0) {
            if ((systolique >= 50 && systolique <= 120) && (diastolique >= 30 && diastolique <= 80)) {
                tensionArterielle.style['display'] = 'none';
                $('#tension').html(`
                <strong><span style="background-color:#006400;color:#FFFFFF" class="form-control pay_in ">Optimale</span>  </strong>
                `);
                document.getElementById('tensionName').value = 'Optimal';
            } else if ((systolique >= 120 && systolique <= 140) && (diastolique >= 80 && diastolique <= 90)) {
                tensionArterielle.style['display'] = 'none';
                $('#tension').html(`
                <strong> <span style="background-color:#FFD700;color:#FFFFFF" class="form-control pay_in ">Normale</span>  </strong>
                `);
                document.getElementById('tensionName').value = 'Normale';
            } else if ((systolique >= 140 && systolique <= 250) && (diastolique >= 90 && diastolique <= 200)) {
                tensionArterielle.style['display'] = 'none';
                $('#tension').html(`
               <strong><span style="background-color:#FF0000;color:#FFFFFF" class="form-control pay_in ">Élevée</span></strong>
                `);
                document.getElementById('tensionName').value = 'Élevée';
            }
        }

        $('#systoleDonne').html(``);
        $('#diastoleDonne').html(``);
        if (systolique >= 140 && systolique <= 250) {
            $('#systoleDonne').html(`<code class="flash_message">Hypertension Systolique</code>`);
            document.getElementById('hypertensionSystolique').value = 'Hypertension Systolique';
        }
        if (diastolique >= 90 && diastolique <= 200) {
            $('#diastoleDonne').html(`<code class="flash_message">Hypertension Diastolique</code>`);
            document.getElementById('hypertensionDiastolique').value = 'Hypertension Diastolique';
        }

    }

    function poidsNormal(event) {
        var age = $('#agePoidsTaille').val();
        var poids = $('#poids').val();
        var bt = document.getElementById('validationConsultation');
        poids = parseFloat(poids);
        age = parseFloat(age);
        bt.disabled = false;
        $('#NormalPoids').html(``);
        if ((age >= 0 && age <= 1) && (poids < 0.3)) {
            $('#NormalPoids').html(`<code class="flash_message">le poids ne correspond pas à un enfant de ${age} an</code>`);
            bt.disabled = true;
        } else if ((age >= 0 && age <= 1) && (poids > 12)) {
            $('#NormalPoids').html(`<code class="flash_message">le poids ne correspond pas à un enfant de ${age} an</code>`);
            bt.disabled = true;
        } else if ((age > 1 && age <= 4) && (poids < 6)) {
            $('#NormalPoids').html(`<code class="flash_message">le poids ne correspond pas à un enfant de ${age} ans </code>`);
            bt.disabled = true;
        } else if ((age > 1 && age <= 4) && (poids > 23)) {
            $('#NormalPoids').html(`<code class="flash_message">le poids ne correspond pas à un enfant de ${age} ans </code>`);
            bt.disabled = true;
        } else if ((age >= 5 && age <= 14) && (poids < 12)) {
            $('#NormalPoids').html(`<code class="flash_message">le poids ne correspond pas à un enfant de ${age} ans </code>`);
            bt.disabled = true;
        } else if ((age >= 5 && age <= 14) && (poids > 78)) {
            $('#NormalPoids').html(`<code class="flash_message">le poids ne correspond pas à un enfant de ${age} ans </code>`);
            bt.disabled = true;
        } else if ((age >= 15) && (poids > 150)) {
            $('#NormalPoids').html(`<code class="flash_message">le poids ne correspond pas à un adulte de ${age} ans </code>`);
            bt.disabled = true;
        }
    }

    function tailleNormal(event) {
        var age = $('#agePoidsTaille').val();
        var taille = $('#taille').val();
        age = parseFloat(age);
        $('#NormalTaille').html(``);
        var bt = document.getElementById('validationConsultation');
        bt.disabled = false;
        if ((age >= 0 && age <= 1) && (taille < 44)) {
            $('#NormalTaille').html(`<code class="flash_message">la taille ne correspond pas à un enfant de ${age} an</code>`);
            bt.disabled = true;
        }
        if ((age >= 0 && age <= 1) && (taille > 81)) {
            $('#NormalTaille').html(`<code class="flash_message">la taille ne correspond pas à un enfant de ${age} an</code>`);
            bt.disabled = true;
        } else if ((age > 1 && age <= 4) && (taille < 70)) {
            $('#NormalTaille').html(`<code class="flash_message">la taille ne correspond pas à un enfant de ${age} ans </code>`);
            bt.disabled = true;
        } else if ((age > 1 && age <= 4) && (taille > 113)) {
            $('#NormalTaille').html(`<code class="flash_message">la taille ne correspond pas à un enfant de ${age} ans </code>`);
            bt.disabled = true;
        } else if ((age >= 5 && age <= 14) && (taille < 100)) {
            $('#NormalTaille').html(`<code class="flash_message">la taille ne correspond pas à un enfant de ${age} ans </code>`);
            bt.disabled = true;
        } else if ((age >= 5 && age <= 14) && (taille > 178)) {
            $('#NormalTaille').html(`<code class="flash_message">la taille ne correspond pas à un enfant de ${age} ans </code>`);
            bt.disabled = true;
        } else if ((age >= 15) && (taille > 230)) {
            $('#NormalTaille').html(`<code class="flash_message">la taille ne correspond pas à un adulte de ${age} ans </code>`);
            bt.disabled = true;
        }
    }
</script>