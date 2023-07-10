<!--main content start-->
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
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading" style="margin-top:41px;">
                <h2><?php echo lang('operation_financiere'); ?></h2>
            </header>
            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table">
                    <div class="space15"></div>
                    <div class="col-lg-8 col-md-8">
                        <table border="0" cellspacing="5" cellpadding="5" style="float:left">
                            <tbody>
                                <tr>
                                    <td><strong style="color:#0d4d99"> Période: </strong></td>
                                    <td><select onchange="caisseUpdate(event)" class="form-control" id="selectperiode">
                                            <option value="ceMoisCi">Ce mois-ci</option>
                                            <option value="aujourdhui">Aujourd'hui</option>
                                            <option value="cetteSemaine">Cette semaine</option>
                                            <option value="30DerniersJours">30 derniers jours</option>
                                            <option value="leMoisDernier">Le mois dernier</option>
                                            <option value="ceTrimestre">Ce trimestre</option>
                                            <option value="ceSemestre">Ce semestre</option>
                                            <option value="cetteAnnee">Cette année</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table border="0" cellspacing="5" cellpadding="5" style="float:left">
                            <tbody>
                                <tr>
                                    <td><strong style="color:#0d4d99"> Type: </strong></td>
                                    <td><select class="form-control" name="modeType" id="modeType" onchange="typeUpdate(event)">
                                            <option value=""> Tout </option>
                                            <option value="depot"> Dépôt Orange Money </option>
                                            <option value="interne"> Transfert Interne </option>
                                            <option value="externe"> Transfert Externe </option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-2 col-md-4">
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div style="float:right;padding-top:10px;color:#0d4d99">
                            <h3 id="montantAfficher"></h3>
                        </div>
                    </div>
                    <table class="table table-hover progress-table text-center" id="editable-sample">
                        <thead>
                            <tr>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('recu'); ?></th>
                                <th><?php echo lang('de_vers'); ?></th>
                                <th><?php echo lang('amount'); ?></th>
                                <th><?php echo lang('type'); ?></th>
                                <th><?php echo lang('statut'); ?></th>
                                <td syle="display:none"></td>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($operationFinanciere as $operationFinancieres) { ?>
                                <tr class="">
                                    <td style="vertical-align:middle;"><?php echo $operationFinancieres->dateOp; ?> </td>
                                    <td style="vertical-align:middle;"><?php echo $operationFinancieres->reference; ?></td>
                                    <td style="vertical-align:middle;"><?php echo $operationFinancieres->initiateur . ' / ' . $operationFinancieres->destinataire; ?> </td>
                                    <td style="vertical-align:middle;"><span class="money"><?php echo $operationFinancieres->montant; ?></span> FCFA
                                        <?php $total_amount[] = $operationFinancieres->montant; ?>
                                    </td>
                                    <td style="vertical-align:middle;"><?php echo $operationFinancieres->description; ?>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <?php if ($operationFinancieres->statut == 'PENDING') { ?>
                                            <span class="status-p bg-primary"><?php echo 'En attente'; ?></span>
                                        <?php } ?>
                                        <?php if ($operationFinancieres->statut == 'VALIDATED') { ?>
                                            <span class="status-p bg-primary"><?php echo 'Validée'; ?></span>
                                        <?php } ?>
                                        <?php if ($operationFinancieres->statut == 'DENIED') { ?>
                                            <span class="status-p bg-primary"> <?php echo 'Annulée'; ?></span>
                                        <?php } ?>
                                    <td style="display:none"><?php echo $operationFinancieres->type; ?></td>
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
                    <table>
                        <?php
                        if (!empty($total_amount)) {
                            $total_amount = array_sum($total_amount);
                        } else {
                            $total_amount = 0;
                        }
                        ?>
                        <tr>
                            <th></th>
                            <th></th>
                            <th style="text-align:right"></th>
                            <th><input hidden id="montantTotal" value="<?php echo number_format($total_amount, 0, '.', '.'); ?>" /></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </table>
                </div>
            </div>
    </section>
    <!-- page end-->
</section>
</section>
<!--main content end-->
<!--footer start-->


<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/autoNumeric.min.js"></script>
<script>
    $(document).ready(function() {
        var montantTotal = $('#montantTotal').val();
        document.querySelector('#montantAfficher').innerHTML = 'Total :' + montantTotal + ' FCFA';

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
<script>
    var total = 0;
    var debut, fin;

    function updatePeriode(libellePeriode) {
        let d = new Date();
        let d1;
        let day = d.getDate();

        switch (libellePeriode) {
            case 'ceMoisCi':
                debut = `1/${d.getMonth() + 1}/${d.getFullYear()}`;
                fin = `${day}/${d.getMonth() + 1}/${d.getFullYear()}`;
                break;
            case 'aujourdhui':
                debut = `${d.getDate()}/${d.getMonth() + 1}/${d.getFullYear()}`;
                fin = `${day}/${d.getMonth() + 1}/${d.getFullYear()}`;
                break;
            case 'cetteSemaine':
                d1 = new Date();
                d1.setDate(d1.getDate() - d1.getDay() + 1);
                debut = `${d1.getDate()}/${d1.getMonth() + 1}/${d1.getFullYear()}`;
                fin = `${day}/${d.getMonth() + 1}/${d.getFullYear()}`;
                break;
            case '30DerniersJours':
                d1 = new Date();
                d1.setDate(d1.getDate() - 29);
                debut = `${d1.getDate()}/${d1.getMonth() + 1}/${d1.getFullYear()}`;
                fin = `${day}/${d.getMonth() + 1}/${d.getFullYear()}`;
                break;
            case 'leMoisDernier':
                d1 = new Date();
                d1.setFullYear(d1.getFullYear(), d1.getMonth(), 0);
                debut = `1/${d1.getMonth() + 1}/${d1.getFullYear()}`;
                fin = `${d1.getDate()}/${d1.getMonth() + 1}/${d1.getFullYear()}`;
                break;
            case 'ceTrimestre':
                debut = `1/${(d.getMonth() + 1) % 3}/${d.getFullYear()}`;
                fin = `${day}/${d.getMonth() + 1}/${d.getFullYear()}`;
                break;
            case 'ceSemestre':
                debut = `1/${(d.getMonth() + 1) % 6}/${d.getFullYear()}`;
                fin = `${day}/${d.getMonth() + 1}/${d.getFullYear()}`;
                break;
            case 'cetteAnnee':
                debut = `1/1/${d.getFullYear()}`;
                fin = `${day}/${d.getMonth() + 1}/${d.getFullYear()}`;
                break;
        }
    }

    function typeUpdate(eventObj) {
        var liste = document.getElementById('selectperiode');
        var myElementValue = liste.value;
        var listeType = document.getElementById('modeType');
        var typeValue = listeType.value;
        updatePeriode(myElementValue);
        var depot = 'depot';
        var interne = 'interne';
        var externe = 'externe';

        if (typeValue.indexOf(depot) != -1) {
            var typeElement = 'depot';
            var url = `debut=${debut}&fin=${fin}&type=${typeElement}&periode=${myElementValue}`;
            window.location.search = url;
        } else if (typeValue.indexOf(interne) != -1) {
            var typeElement = 'interne';
            var url = `debut=${debut}&fin=${fin}&type=${typeElement}&periode=${myElementValue}`;
            window.location.search = url;
        } else if (typeValue.indexOf(externe) != -1) {
            var typeElement = 'externe';
            var url = `debut=${debut}&fin=${fin}&type=${typeElement}&periode=${myElementValue}`;
            window.location.search = url;
        } else {
            var url = `debut=${debut}&fin=${fin}&periode=${myElementValue}`
            window.location.search = url;
        }



    }

    function caisseUpdate(eventObj) {
        updatePeriode(eventObj.target.value);
        var listeType = document.getElementById('modeType');
        var typeValue = listeType.value;

        //alert(typeValue);

        var url = `debut=${debut}&fin=${fin}&periode=${eventObj.target.value}`

        window.location.search = url;
        document.querySelector('#modeType').value = urlParams.get('type') == 'depot' ? 'depot' : urlParams.get('type') == 'interne' ? 'interne' : urlParams.get('type') == 'externe' ? 'externe' : '';

    }
</script>
<script>
    var total = 0;


    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        document.querySelector('#selectperiode').value = urlParams.get('periode') || 'ceMoisCi';
        document.querySelector('#modeType').value = urlParams.get('type') == 'depot' ? 'depot' : urlParams.get('type') == 'interne' ? 'interne' : urlParams.get('type') == 'externe' ? 'externe' : '';

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
                    // {
                        // extend: 'print',
                        // text: 'Imprimer',
                        // className: 'dt-button-icon-left dt-button-icon-imprimer',
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
            },
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;
                console.log("voir le resultat " + data);
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                total = api
                    .column(4)
                    .data()
                    .reduce(function(a, data) {
                        console.log("voir le resultatB " + intVal(data.concatMontant));
                        return intVal(a) + intVal(data.concatMontant);
                    }, 0);

                pageTotal = api
                    .column(3)
                    .data()
                    .reduce(function(a, data) {
                        return intVal(a) + intVal(data.concatMontant);
                    }, 0);
                console.log(pageTotal + '---total-----------' + total);
                $(api.column(3).footer()).html(pageTotal);
            }

        });
        table.buttons().container().appendTo('.custom_buttons');
        // $('#modeType').click( function() {
        //     var typeMode = $('#modeType').val(); 
        //     table.search(typeMode).draw() ;
        // } );
    });
</script>