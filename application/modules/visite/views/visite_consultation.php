<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <div class="col-md-4 no-print pull-right">
                    <a href="visite/ajoutConsultation">
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i>Ajouter une  <?php echo lang('consultation_general'); ?>
                            </button>
                        </div>
                    </a>
                </div>
                <h2><?php echo lang('liste_consultation'); ?></h2>
            </header>
            
            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table">
                    <div class="space15"></div>
                    <table class="table table-hover progress-table" id="editable-sample">
                        <thead>
                            <tr>
                                <th><?php echo lang('date'); ?></th>
                                <th>CODE</th>
                                <th><?php echo lang('patient'); ?></th>
                                <th>TELEPHONE</th>
                                <!-- <th style="min-width:20%"><?php echo lang('antecedant'); ?></th> -->
                                <!-- <th style="min-width:20%"><?php echo lang('effectuer_par'); ?></th> -->
                                <th style="min-width:20%">DOSSIER</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($visites)) {
                                foreach ($visites as $visite) {
                                    $options2 = '<a class="btn btn-info btn-xs invoicebutton" title="' . lang('invoice') . '" style="color: #fff;" href="visite/consultationInvoice?id=' . $visite->idv . '"><i class="fa fa-file-invoice"></i> </a>';
                            ?>
                                    <tr class="">
                                        <td><?php echo date('d-m-y  H:i', $visite->date); ?></td>
                                        <td><?php echo $visite->patient_code; ?> </td>
                                        <td><?php echo $visite->patient_name.' '.$visite->patient_last_name; ?> </td>
                                        <td><?php echo $visite->patient_phone; ?> </td>
                                        <!-- <td style="min-width:20%"><?php
                                                                $by = $this->home_model->getUserById($visite->user);
                                                                $identite = $by->first_name . " " . $by->last_name;
                                                                echo $identite;
                                                                ?> -->
                                        <td style="min-width:20%"><?php echo $options2 ?> </td>
                                    </tr>
                            <?php }
                            } ?>
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






<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".editbutton").click(function(e) {
            e.preventDefault(e);
            // Get the record's ID via attribute  
            var iid = $(this).attr('data-id');
            $('#editServiceForm').trigger("reset");
            $.ajax({
                url: 'service/editServiceByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                // Populate the form fields with the data returned from server
                $('#editServiceForm').find('[name="id"]').val(response.service.id).end()
                $('#editServiceForm').find('[name="title"]').val(response.service.title).end()
                $('#editServiceForm').find('[name="description"]').val(response.service.description).end()
                $('#myModal2').modal('show');
            });
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
    });
</script>






<script>
    $(document).ready(function() {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>