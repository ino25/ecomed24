<!--sidebar end-->
<!--main content start-->



<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <h2>Factures Partenaires</h2>
            </header>
            <div class="container">
                <h2>Informations JSON DOSSIER ACTES </h2>
                <div class="panel panel-default">
                    <div class="responseJson" class="panel-body" style=" white-space: break-spaces;
                    font-family: monospace;
                    font-size: 12px;
                    color: brown;"></div>
                </div>
            </div>
            <input type="text" name="code_facture" id="code_facture" value="<?php echo $code_facture; ?>">

            <div class="panel-body panel-bodyAlt">
                <form action="partenaire/genereFactures" id="genereFactures" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="adv-table editable-table ">
                        <table border="0" cellspacing="5" cellpadding="5" style="float:left">
                            <tbody>
                                <tr>
                                    <td><strong style="color:#0d4d99"> Statut: </strong></td>
                                    <td><select class="form-control" name="modeType" id="modeType">
                                            <option value=""> Tout </option>
                                            <option value="zpae"> Payé </option>
                                            <option value="noypaid">Non payé </option>
                                            <option value="enattente">En attente </option>

                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="space15"> </div>
                        <table class="table table-hover progress-table" id="dataTable-liste">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Date Facture</th>
                                    <th><?php echo lang('number'); ?></th>
                                    <th><?php echo lang('sent_to'); ?></th>
                                    <th>Par</th>
                                    <th><?php echo lang('amount'); ?></th>
                                    <th><?php echo lang('Status'); ?></th>
                                    <th><?php echo lang('options'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listeCommandes as $key => $commande) { ?>
                                    <tr class="">
                                        <td> <?php echo $commande[0]; ?> </td>
                                        <td><?php echo $commande[1]; ?></td>
                                        <td> <?php echo $commande[2]; ?></td>
                                        <td> <?php echo $commande[3]; ?></td>
                                        <td> <?php echo $commande[4]; ?></td>
                                        <td> <?php echo $commande[5]; ?></td>
                                        <td> <?php echo $commande[6]; ?></td>
                                        <td> <?php echo $commande[7]; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
                <a id="" class="btn btn-info btn-secondary pull-left" href="partenaire/relation">
                    Retour
                </a>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<div class="modal fade" id="myModaldeposit2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('add_deposit'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="finance/checkDepotPro" id="deposit-checkDepot" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('invoice_f'); ?></label>
                        <select class="form-control m-bot15" id="paymentid" name="paymentid">

                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo lang('reste_a_payer'); ?> : <span id="reste"></span> <?php echo $settings->currency; ?></label>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('deposit_amount'); ?></label>
                        <input type="text" class="form-control money" name="deposited_amount" id="deposited_amount" value='' placeholder="">
                    </div>
                    <div class="form-group">
                        <!--  <input  type="hidden" class="form-control" name="deposited_amount" id="deposited_amount" value='' placeholder="">-->
                    </div>
                    <div class="form-group">
                        <div class="payment_label pull-left">
                            <label for="exampleInputEmail1"><?php echo lang('deposit_type'); ?></label>
                        </div>
                        <div class="">
                            <select class="form-control m-bot15 js-example-basic-single selecttype" id="selecttype" name="deposit_type" onchange="caisseUpdate(event)">
                                <?php if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Accountant', 'Receptionist'))) { ?>
                                    <option value="OrangeMoney"> <?php echo 'OrangeMoney'; ?> </option>
                                    <option value="zuulupay"> <?php echo lang('zuulupay'); ?> </option>
                                    <option value="Cash"> <?php echo 'Virement'; ?> </option>
                                    <option value="" disabled=""> <?php echo lang('carte_bancaire'); ?> </option>
                                    <option value="" disabled=""> <?php echo lang('demande'); ?> </option>
                                    <option value="Cheque" disabled=""> <?php echo 'Cheque'; ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="id" value=''>
                    <input type="hidden" name="patient" id="patient" value=''>
                    <input type="hidden" name="redirect" value='partenaire/factures'>
                    <div class="form-group cashsubmit payment  right-six col-md-12" id="bouttonSuivant">
                        <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                        <button type="submit" name="submit2" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>
                    </div>

                </form>


            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<!--main content end-->
<!--footer start-->

<script src="<?php echo base_url(); ?>common/js/ecomed24.min.js"></script>
<script>
    $(document).ready(function() {
        code_facture = $('#code_facture').val();
        $.ajax({
            url: 'partenaire/paiementFacture?id=' + code_facture,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function(response) {
            // Populate the form fields with the data returned from server
            console.log('*** RESPONSE FACTURE ****');
            console.log(response);
            resultatFinal = JSON.stringify(response);
            resultat = JSON.stringify(response, null, 2);
            const container = document.querySelector('.responseJson');
            container.innerText = JSON.stringify(response, null, 2);
            var options = {
                url: "partenaire/genererDocumentFactureCode",
                dataType: "json",
                type: "POST",
                data: {
                    test: JSON.stringify(resultatFinal),
                }, // Our valid JSON string
                success: function(data, status, xhr) {
                },
                error: function(xhr, status, error) {
                    //...
                }
            };
            $.ajax(options);

        });

    });
</script>
<script>
    $(document).ready(function() {
        var table2 = $('#dataTable-liste').DataTable({
            responsive: true,
            "processing": true,
            // "serverSide": true,
            "searchable": true,
            scroller: {
                loadingIndicator: true
            },
            fixedHeader: true,
            dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 pull-left'B><'col-sm-4 pull-right'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: {
                buttons: [
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
            //"order": [[0, "desc"]],
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
        table2.buttons().container().appendTo('.custom_buttons');
        table2.columns(0).visible(false);
        $('#modeType').click(function() {
            var typeMode = $('#modeType').val();
            table2.search(typeMode).draw();
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
                        searchTerm: params.term,
                        organisation: params.term,
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
<script src="<?php echo base_url(); ?>common/js/facture.js"></script>