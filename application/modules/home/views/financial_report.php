<!--sidebar end-->
<style>
    .negative {
        color: rgba(255, 0, 0, 1.00);
        font-weight: bold;
    }

    .positive {
        color: #279B38;
        font-weight: bold;
    }
</style>
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <div class="col-md-4 no-print pull-right">
                    <div class="btn-group pull-right" style="margin-right:5px;">
                        <button id="" class="btn green btn-xs downloadbutton">
                            <i class="fa fa-plus-circle"></i>&nbsp;Importer les dépenses
                        </button>
                    </div>
                </div>
                <div class="col-md-4 no-print pull-right">
                    <div class="btn-group pull-right" style="margin-right:5px;">
                        <button id="" class="btn green btn-xs downloadbutton2">
                            <i class="fa fa-plus-circle"></i>&nbsp;Importer les recettes
                        </button>
                    </div>
                </div>
                <h2>Rapport Financier : (<?php echo $organisation->nom; ?>)</h2>
            </header>

            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table">
                    <div class="space15"></div>

                    <table class="table table-hover progress-table" id="editable-sample">
                        <thead>
                            <tr>
                                <td>
                                    <select class="form-control" name="modeType" id="modeType">
                                        <option value=""> Tout </option>
                                        <option value="recette"> RECETTES </option>
                                        <option value='depense'> DEPENSES </option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('recu'); ?></th>
                                <th><?php echo lang('patient_beneficiaire'); ?></th>
                                <th><?php echo lang('amount'); ?></th>
                                <td syle="display:none"></td>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($paymentExpense as $paymentExpenses) { ?>
                                <tr class="">
                                    <td style="vertical-align:middle;"><?php echo $paymentExpenses->dateOp; ?> </td>
                                    <td style="vertical-align:middle;"><?php echo $paymentExpenses->recu; ?></td>
                                    <td style="vertical-align:middle;"><?php echo $paymentExpenses->beneficiaire; ?> </td>
                                    <td style="vertical-align:middle;">
                                        <?php
                                        if ($paymentExpenses->concatMontant > 0) { ?>
                                            <span class="positive money"><?php echo $paymentExpenses->concatMontant; ?></span> <span class="positive">FCFA</span><span style="display: none;">recette</span>
                                            <?php $total_amount[] = $paymentExpenses->concatMontant; ?>
                                        <?php } ?>
                                        <?php
                                        if ($paymentExpenses->concatMontant < 0) { ?>
                                            <span class="negative money"><?php echo $paymentExpenses->concatMontant; ?></span> <span class="negative">FCFA</span><span style="display: none;">depense</span>
                                            <?php $total_amount[] = $paymentExpenses->concatMontant; ?>
                                        <?php } ?>

                                    </td>
                                    <td style="display:none"><?php echo $paymentExpenses->type; ?></td>
                                </tr>
                            <?php } ?>
                            <style>
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
                    <a id="" class="btn btn-info btn-secondary pull-left" href="home/superhome">
                        Retour
                    </a>
                </div>
            </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
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
<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Importer la liste des dépenses (xls, xlsx) </h4>
            </div>

            <div class="modal-body">
                <div class="btn-group" style="margin-right:5px;">
                    <a id="" class="btn green btn-xs btn-secondary" href="home/importOrganisationDepenseTemplate">
                        <i class="fa fa-download"></i>&nbsp;Télécharger le fichier de référence
                    </a>
                </div>
                <form role="form" id="departmentEditForm" class="clearfix" action="home/importDepenseOrganisation" method="post" enctype="multipart/form-data">

                    <div class="form-group has-feedback">
                        <label for="exampleInputEmail1"> <?php echo lang('choose_file'); ?> rempli</label>
                        <input type="file" class="form-control" placeholder="" name="filename" required accept=".xls, .xlsx ,.csv">
                        <span class="glyphicon glyphicon-file form-control-feedback"></span>
                        <input type="hidden" name="idOrganisationOrigin" value="<?php echo $organisation->id; ?>">
                    </div>

                    <section class="">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit" class="btn btn-info submit_button pull-right"> <?php echo lang('submit') ?></button>
                    </section>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- RECETTE -->
<div class="modal fade" id="myModal3" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Importer la liste des recettes (xls, xlsx) </h4>
            </div>

            <div class="modal-body">
                <div class="btn-group" style="margin-right:5px;">
                    <a id="" class="btn green btn-xs btn-secondary" href="home/importOrganisationRecetteTemplate">
                        <i class="fa fa-download"></i>&nbsp;Télécharger le fichier de référence
                    </a>
                </div>
                <form role="form" id="departmentEditForm" class="clearfix" action="home/importRecetteOrganisation" method="post" enctype="multipart/form-data">

                    <div class="form-group has-feedback">
                        <label for="exampleInputEmail1"> <?php echo lang('choose_file'); ?> rempli</label>
                        <input type="file" class="form-control" placeholder="" name="filename" required accept=".xls, .xlsx ,.csv">
                        <span class="glyphicon glyphicon-file form-control-feedback"></span>
                        <input type="hidden" name="idOrganisationOrigin" value="<?php echo $organisation->id; ?>">
                    </div>

                    <section class="">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit" class="btn btn-info submit_button pull-right"> <?php echo lang('submit') ?></button>
                    </section>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--main content end-->
<!--footer start-->






<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/autoNumeric.min.js"></script>
<script>
    $(document).ready(function() {
        $(".downloadbutton").click(function(e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            $('#myModal2').modal('show');
        });
        $(".downloadbutton2").click(function(e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            $('#myModal3').modal('show');
        });
    });
</script>
<script>
    $(document).ready(function() {
        var autoNumericInstance = new AutoNumeric.multiple('.money', {
            // currencySymbol: "Fcfa",
            // currencySymbolPlacement: "s",
            // emptyInputBehavior: "min",
            // selectNumberOnly: true,
            // selectOnFocus: true,
            overrideMinMaxLimits: 'invalid',
            emptyInputBehavior: "min",
            //  maximumValue : '100000',
            //  minimumValue : "100",
            decimalPlaces: 0,
            decimalCharacter: ',',
            digitGroupSeparator: '.'
        });

    });
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
            $('.patientIdClass').append(response.patient.patient_id).end();
            $('.nameClass').append(response.patient.name).end();
            $('.lastnameClass').append(response.patient.last_name).end();
            $('.emailClass').append(response.patient.email).end();
            $('.addressClass').append(response.patient.address).end();
            $('.phoneClass').append(response.patient.phone).end();
            $('.genderClass').append(response.patient.sex).end();
            $('.birthdateClass').append(response.patient.birthdate).end();
            $('.ageClass').append(response.age).end();
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
</script>
<script>
    $(document).ready(function() {
        var table = $('#editable-sample').DataTable({
            responsive: true,

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
            // "order": [[0, "desc"]],
            aaSorting: [],
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

        table.buttons().container()
            .appendTo('.custom_buttons');
        $('#modeType').click(function() {
            var typeMode = $('#modeType').val();
            table.search(typeMode).draw();
        });
    });

    function typeUpdate(eventObj) {
        var listeType = document.getElementById('modeType');
        var typeValue = listeType.value;
        alert(typeValue);
        updatePeriode(myElementValue);
        var recette = 'recette';
        var depense = 'depense';

        if (typeValue.indexOf(recette) != -1) {
            var typeElement = 'F';
            var url = `debut=${debut}&fin=${fin}&type=${typeElement}&periode=${myElementValue}`;
            window.location.search = url;
        } else if (typeValue.indexOf(depense) != -1) {
            var typeElement = 'R';
            var url = `debut=${debut}&fin=${fin}&type=${typeElement}&periode=${myElementValue}`;
            window.location.search = url;
        } else {
            var url = `debut=${debut}&fin=${fin}&periode=${myElementValue}`
            window.location.search = url;

        }



    }
</script>






<script>
    $(document).ready(function() {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>