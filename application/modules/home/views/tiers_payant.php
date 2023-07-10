<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <div class="col-md-11">
                <header class="panel-heading">
                    Gestion des Tiers-payant
                    <div class="col-md-11 no-print pull-right">
                        <a href="home/editTiersPayant">
                            <div class="btn-group pull-right" style="margin-top:12px">
                                <button id="" class="btn green btn-xs">
                                    <i class="fa fa-plus-circle"></i> Ajouter Tiers-payant
                                </button>
                            </div>
                        </a>
                    </div>
                </header>
                <div class="panel-body">
                    <div class="adv-table editable-table ">
                        <div class="space15"></div>
                        <table class="table table-hover progress-table text-center" id="editable-sample">
                            <thead>
                                <tr>
                                    <th class="pull-left" style="width:30%">CODE</th>
                                    <th class="pull-left" style="width:30%">PRIX ASSURANCE</th>
                                    <th class="pull-left" style="width:30%">PRIX IPM</th>
                                    <th class="option_th no-print" style="width:10%">MODIFIER</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tiers_payants as $tiers) { ?>
                                    <tr>
                                        <td class="pull-left" style="width:30%; text-align: left"> <?php echo $tiers->code?></td>
                                        <td class="pull-left" style="width:30%; text-align: left"> <?php echo $tiers->prix_assurance; ?></td>
                                        <td class="pull-left" style="width:30%; text-align: left"> <?php echo $tiers->prix_ipm; ?></td>
                                        <td class="option_th no-print" style="width:10%">
                                            <a href="home/editTiersPayant?id=<?php echo $tiers->id; ?>" class="btn btn-info btn-xs btn_width editbutton" title="<?php echo lang('edit'); ?>" data-toggle="modal" data-id="<?php echo $tiers->id; ?>"><i class="fa fa-edit"> </i></a>
                                        </td>
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

                                    .option_th {
                                        width: 18%;
                                    }
                                </style>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
<!-- Alassane -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $(".flashmessage").delay(3000).fadeOut(100);
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
                    // columns: [0,1,2,3],
                    // }
                    // },
                    // {
                    // extend: 'pdfHtml5',
                    // className: 'dt-button-icon-left dt-button-icon-pdf',
                    // exportOptions: {
                    // columns: [0,1,2,3],
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

        table.buttons().container().appendTo('.custom_buttons');
    });
</script>