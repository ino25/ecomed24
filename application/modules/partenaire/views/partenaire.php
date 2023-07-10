<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <div class="col-md-5 no-print pull-right">
                    <a data-toggle="modal" href="#myModal">
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('add'); ?>
                            </button>
                        </div>
                    </a>
                </div>
                <h2>Partenaires</h2>
            </header>
            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table ">
                    <table border="0" cellspacing="5" cellpadding="5" style="float:left">
                        <tbody>
                            <tr>
                                <td><strong style="color:#0d4d99"> Relation: </strong></td>
                                <td><select class="form-control" name="modeType" id="modeType">
                                        <option value=""> Tout </option>
                                        <option value="prt0"> Prestataire </option>
                                        <option value="prt1"> Sous-traitance </option>

                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="space15"></div>
                    <table class="table table-hover progress-table" id="editable-sample">
                        <thead>
                            <tr>
                                <th style=""></th>
                                <th style="width:10px !important;"></th>
                                <th style="">Nom</th>
                                <th style="">Type</th>
                                <th style="">Adresse</th>
                                <th style="">Statut</th>
                                <th style="">Date ajout</th>
                                <th style="">Relation</th>
                                <th style="">Modifier</th>
                                <!--<th class="no-print" style="">Actions</th>-->
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
                            </style>

                            <?php foreach ($partenaires as $partenaire) {

                                $status = '';
                                if ($partenaire->partenariat_actif == '1') {
                                    $status = '<span class="status-p bg-success">ACTIF</span>';
                                    // $status = '';
                                } else {
                                    $status = '<span class="status-p bg-success2">INACTIF</span>';
                                }

                                $img_url;
                                if (!empty($partenaire->path_logo) && $partenaire->path_logo != '--') {
                                    $img_url = '<img style="max-width:200px;max-height:90px;" src="' . $partenaire->path_logo . '" alt="LgI">';
                                } else {
                                    $img_url = '<img style="max-width:200px;max-height:90px;" src="uploads/logosPartenaires/default.png" alt="Lgo">';
                                }
                                $partenairetype = '';
                                if ($partenaire->is_light == 1) {
                                    $partenairetype = 'Sous-traitance';
                                } else {
                                    $partenairetype = 'Prestataire';
                                }
                            ?>
                                <tr class="">
                                    <td>prt<?php echo $partenaire->is_light; ?></td>
                                    <td style="vertical-align:middle;"> <?php echo $img_url; ?></td>
                                    <td><?php echo $partenaire->nom; ?></td>
                                    <td style="vertical-align:middle;"> <?php echo $partenaire->type; ?></td>
                                    <td style="vertical-align:middle;"><?php echo $partenaire->adresse; ?></td>
                                    <td style="vertical-align:middle;"><?php echo $status; ?></td>
                                    </td>
                                    <td style="vertical-align:middle;"> <?php echo $partenaire->date_created; ?></td>
                                    <td style="vertical-align:middle;"> <?php echo $partenairetype; ?></td>
                                    <td style="vertical-align:middle;text-align: center;"><?php if($partenairetype == 'Sous-traitance') { ?>
                                    <a class="button" class="btn btn-xs btn_widt btn-liste" title="Modifier"  href="partenaire/editLightPartenaire?id=<?php echo $partenaire->idp ?>&idOrganisation=<?php echo $partenaire->id ?>"><i class="fa fa-pencil"></i> </a> <?php }?></td>
                                  
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_partenaire'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" action="partenaire/addNew" method="post" class="clearfix" enctype="multipart/form-data">

                    <div class="col-md-12 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('liste_partenaire'); ?></label>
                        <select class="form-control m-bot15 spartenaire" id="spartenaire" name="partenaire" required="">


                        </select>
                    </div>
                    <div id="category" class="col-md-12 panel" style="display:none">
                        <label for="exampleInputEmail1">Catégorie de Tarification</label>
                        <select name='category' class='form-control' required>
                            <option disabled value="" selected hidden>Sélectionner une Catégorie de Tarification</option>
                            <option value="privé">Sous-traitance privée</option>
                            <option value="publique">Sous-traitance publique</option>
                            <option value="hors-category">Hors-catégorie</option>
                        </select>
                    </div>

                    <div class="col-md-12 panel">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="myModalLightPartenaire" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
                            <input id="phone_patient_edit_light_partenaire" type="number" class="form-control" name="phone" onkeyup="numberChangePatientEditLightPartenaire(event)" value='' required />
                            <input type="hidden" id='phoneValide_patient_edit_light_partenaire' name="phone_recuperation" value='' required />
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
                        <input type="hidden" class="form-control" name="redirect" value="partenaire" id="exampleInputEmail1" placeholder="">
                    </div>

                    <div class="col-md-12 panel">
                        <button id="validationPatientEditLightPartenaire" type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!--main content end-->
<!--footer start-->


<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>

<script>
    $(document).ready(function() {
        document.getElementById('redirectLight').value = 'partenaire';
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

        table.buttons().container().appendTo('.custom_buttons');
        table.columns(0).visible(false);
        $('#modeType').click(function() {
            var typeMode = $('#modeType').val();
            table.search(typeMode).draw();
        });

        $("#spartenaire").select2({
            placeholder: '<?php echo lang('select_partenaire'); ?>',
            allowClear: true,
            ajax: {
                url: 'partenaire/searhPartenaireByAdd',
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

        $(document.body).on('change', '#spartenaire', function() {

            var v = $("select.spartenaire option:selected").val()
            if (v == 'add_new') {
                $('#myModalLightPartenaire').modal('show');
                document.getElementById('category').style.display = 'none';
            } else {

                $('#myModalLightPartenaire').hide();
                document.getElementById('category').style.display = 'block';
            }
        });
    });
</script>