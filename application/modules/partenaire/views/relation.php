Payment<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <h2><?php echo lang('list_partenaire'); ?></h2>

            </header>
            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table "> 
                    <div class="space15"></div>
                    <table class="table table-hover progress-table" id="editable-sample">
                        <thead>
                            <tr>
                                <th style="">Date</th>
                                <th style="width:10px !important;"><?php echo lang('logo'); ?></th>
                                <th style="">Nom</th>
                                <th style="">Type</th>
                                <th style="">Adresse</th>
                                <th style="">Statut</th>
                                <th class="no-print" style="">Actions</th>
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

                        <?php
                        foreach ($partenaires as $partenaire) {

                            $status = '';
                            if ($partenaire->partenariat_actif == '1') {
                                $status = '<span class="status-p bg-success">ACTIF</span>';
                                // $status = '';
                            } else {
                                $status = '<span class="status-p bg-success2">INACTIF</span>';
                            }

                            $img_url = '';
                            if ($partenaire->path_logo && !empty($partenaire->path_logo)) {
                                $img_url = '<img style="max-width:200px;max-height:90px;" src="' . $partenaire->path_logo . '" alt="Lgo">';
                            } else {
                                $img_url = '<img style="max-width:200px;max-height:90px;" src="uploads/logosPartenaires/default.png" alt="Lgo">';
                            }
                            ?>
                            <tr class="" >
                                <td style="vertical-align:middle;"> <?php echo $partenaire->date_created; ?></td>
                                <td style="vertical-align:middle;"> <?php echo $img_url; ?></td>
                                <td style="vertical-align:middle;"><?php echo $partenaire->nom; ?></td>   
                                <td style="vertical-align:middle;"> <?php echo $partenaire->type; ?></td>
                                <td style="vertical-align:middle;" ><?php echo $partenaire->adresse; ?></td>
                                <td style="vertical-align:middle;"><?php echo $status; ?></td>
                                <?php if ($this->ion_auth->in_group(array('admin','adminmedecin', 'Accountant'))) { ?>
                                    <td class="no-print">
                                        <a data-toggle="modal" href="partenaire/listeFacture?id=<?php echo $partenaire->id;?>">
                                            <div class="btn-group">
                                                <button id="" class="btn green btn-xs">
                                                    <i class="fa fa fa-money-bill-alt"></i> <?php echo lang('invoice_f'); ?>
                                                </button>
                                            </div>
                                        </a>
                                       
                                    </td>
                                <?php } ?>
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
                <h4 class="modal-title">  <?php echo lang('add_partenaire'); ?></h4>
            </div>
            <div class="modal-body row">
                <form role="form" action="partenaire/addNew" method="post" class="clearfix" enctype="multipart/form-data">

                    <div class="col-md-12 panel">
                        <label for="exampleInputEmail1">  <?php echo lang('liste_partenaire'); ?></label> 
                        <select class="form-control m-bot15" id="spartenaire" name="partenaire" required="">  

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

<!--main content end-->
<!--footer start-->


<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>

<script>
    $(document).ready(function () {
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
                            // columns: [0, 1, 2, 3, 4, 5],
                        // }
                    // },
                    // {
                        // extend: 'pdfHtml5',
                        // className: 'dt-button-icon-left dt-button-icon-pdf',
                        // exportOptions: {
                            // columns: [0, 1, 2, 3, 4, 5],
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


        $("#spartenaire").select2({
            placeholder: '<?php echo lang('select_partenaire'); ?>',
            allowClear: true,
            ajax: {
                url: 'partenaire/searhPartenaire',
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