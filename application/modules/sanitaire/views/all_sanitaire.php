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
            <input type="hidden" id="organisation" value="<?php echo $nom_organisation ?>">
            <input type="hidden" id="date_debuts" value="<?php echo $dateDebut ?>">
            <input type="hidden" id="date_fins" value="<?php echo $dateFin ?>">


            <header class="panel-heading" style="margin-top:41px;">
                <h4 style="float:right;color:#0d4d99;font-weight: bold;"><?php if (!empty($datePeriode)) {
                                                                                echo $datePeriode;
                                                                            }  ?></h4>
                <h2><?php echo lang('sanitaire'); ?> PCR</h2>


            </header>

            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table">
                    <div class="space15"></div>

                    <div class="col-lg-6 col-md-6">
                        <table border="0" cellspacing="5" cellpadding="5" style="float:left">
                            <tbody>
                                <div class="social-option">
                                    <tr>
                                        <td><strong style="color:#0d4d99"> Période: </strong></td>
                                        <td><div class="social-option"> <select class="form-control" id="selectperiode">
                                                <option value="aujourdhui">Aujourd'hui</option>
                                                <option value="ceMoisCi">Ce mois-ci</option>

                                                <option value="cetteSemaine">Cette semaine</option>
                                                <option value="30DerniersJours">30 derniers jours</option>
                                                <option value="leMoisDernier">Le mois dernier</option>
                                                <option value="ceTrimestre">Ce trimestre</option>
                                                <option value="ceSemestre">Ce semestre</option>
                                                <option value="cetteAnnee">Cette année</option>
                                                <option value="parPeriode">Par période</option>
                                            </select></div>
                                        </td>
                                    </tr>
                                </div>

                            </tbody>
                        </table>
                        <table border="0" cellspacing="5" cellpadding="5" style="float:left">
                            <tbody>
                                <tr>
                                    <td><strong style="color:#0d4d99"> Résultat: </strong></td>
                                    <td><select class="form-control" name="modeType" id="modeType" onchange="typeUpdate(event)">
                                            <option value=""> Tout </option>
                                            <option value="negative"> Négatif </option>
                                            <option value="positive"> Positif </option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-2 col-md-4">
                    </div>
                    <div class="col-lg-3 col-md-4">

                    </div>
                    <table class="table table-hover progress-table" id="editable-sample">
                        <thead>
                            <tr>
                                <th> <?php echo lang('date'); ?></th>
                                <th> <?php echo lang('name'); ?> & <?php echo lang('last_name'); ?></th>
                                <th> <?php echo lang('phone'); ?></th>
                                <th> <?php echo lang('age_annee'); ?></th>
                                <th> <?php echo lang('sex'); ?></th>
                                <th> <?php echo lang('motif'); ?></th>
                                <th> <?php echo lang('date_prelevement'); ?></th>
                                <th> <?php echo lang('view_report'); ?></th>
                                <th style="display:none"></th>
                                <th style="display:none"><?php echo lang('name'); ?></th>
                                <th style="display:none"><?php echo lang('last_name'); ?></th>
                                <th style="display:none"><?php echo lang('numero_dossier'); ?></th>
                                <th style="display:none"><?php echo lang('address_patient'); ?></th>
                                <th style="display:none"><?php echo lang('id_rapport'); ?></th>
                                <th style="display:none"><?php echo lang('origine_prelevement'); ?></th>
                                <th style="display:none"><?php echo lang('voyageur_sortant'); ?></th>
                                <th style="display:none"><?php echo lang('resultat_ct'); ?></th>
                                <th style="display:none"><?php echo lang('numero_visite'); ?></th>
                                <th style="display:none"><?php echo lang('date_rendu'); ?></th>
                                <th style="display:none"><?php echo lang('status'); ?></th>
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
            
            <!-- Add Patient Modal-->
            <div class="modal fade" id="editAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                            <h4 class="modal-title">PERIODE :</h4>

                        </div>
                        <div class="modal-body row" style="height: 120px;">
                            <div class="form-group col-md-6">
                                <label>Date Début</label>
                                <input id="birthdates" class="form-control form-control-inline input-medium before_now" type="text" name="birthdate" value="" placeholder="" autocomplete="off" onchange="recuperationAge()">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Date Fin</label>
                                <input type="text" class="form-control form-control-inline input-medium afert_now" name="date_valid" id="date_fin" value='' autocomplete="off" required="">
                            </div>

                            <section class="col-md-12">
                                <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>
                                <button id="validerPeriode" type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                            </section>


                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </div>
            </div>
        </section>
        <!-- page end-->
    </section>

</section>


<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/autoNumeric.min.js"></script>

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
            case 'parPeriode':
                break;
        }

    }

    function changementPeriode(eventObj) {
        if (eventObj.offsetY < 0)
            console.log(eventObj);
    }

    function typeUpdate(eventObj) {
        var liste = document.getElementById('selectperiode');
        var myElementValue = liste.value;
        var listeType = document.getElementById('modeType');
        var typeValue = listeType.value;
        updatePeriode(myElementValue);
        var negative = 'negative';
        var positive = 'positive';

        if (myElementValue != 'parPeriode') {
            if (typeValue.indexOf(negative) != -1) {
                var typeElement = 'negative';
                var url = `debut=${debut}&fin=${fin}&type=${typeElement}&periode=${myElementValue}`;
                window.location.search = url;
            } else if (typeValue.indexOf(positive) != -1) {
                var typeElement = 'positive';
                var url = `debut=${debut}&fin=${fin}&type=${typeElement}&periode=${myElementValue}`;
                window.location.search = url;
            } else {
                var url = `debut=${debut}&fin=${fin}&periode=${myElementValue}`
                window.location.search = url;

            }
        } else {
            if (typeValue.indexOf(negative) != -1) {
                var typeElement = 'negative';
                var url = window.location.search + `&type=${typeElement}`;
                window.location.search = url;
            } else if (typeValue.indexOf(positive) != -1) {
                var typeElement = 'positive';
                var url = window.location.search + `&type=${typeElement}`;
                window.location.search = url;
            } else {
                window.location.search

            }
        }






    }

    $('.social-option select').on('change', function(eventObj) {
        if (eventObj.offsetY >= 0)
            return;
        updatePeriode(eventObj.target.value);
        var listeType = document.getElementById('modeType');
        var typeValue = listeType.value;

        if (eventObj.target.value != 'parPeriode') {

            var url = `debut=${debut}&fin=${fin}&periode=${eventObj.target.value}`
            window.location.search = url;
            document.querySelector('#modeType').value = urlParams.get('type') == 'negative' ? 'negative' : urlParams.get('type') == 'positive' ? 'positive' : '';
            var datePeriode = `Du ${debut} au ${fin}`;
            document.querySelector("#datePeriode").innerHTML = datePeriode;


        } else {
            $('#editAppointmentModal').modal('show');
            $("#validerPeriode").click(function(e) {
                var debut = $('#birthdates').val();
                var fin = $('#date_fin').val();
                var url = `debut=${debut}&fin=${fin}&periode=${eventObj.target.value}`
                window.location.search = url;
                document.querySelector('#modeType').value = urlParams.get('type') == 'negative' ? 'negative' : urlParams.get('type') == 'positive' ? 'positive' : '';
            })

        }
    });

    
</script>
<script>
    var total = 0;
    var organisation = $('#organisation').val();
    var date_debut = $('#date_debuts').val();
    var date_fin = $('#date_fins').val();

    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        document.querySelector('#selectperiode').value = urlParams.get('periode') || 'aujourdhui';
        document.querySelector('#modeType').value = urlParams.get('type') == 'negative' ? 'negative' : urlParams.get('type') == 'positive' ? 'positive' : '';

        var table = $('#editable-sample').DataTable({
            responsive: true,
            "processing": true,
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "sanitaire/getSanitaires?debut=" + $('#date_debuts').val() + '&fin=' + $('#date_fins').val() + '&type=' + $('#modeType').val(),
                type: 'POST'
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
                    {
                        extend: 'excelHtml5',
                        className: 'dt-button-icon-left dt-button-icon-excel',
                        title: 'rapport_sanitaire_' + organisation + '_' + date_debut + '-' + date_fin,
                        exportOptions: {
                            columns: [13, 14, 11, 9, 10, 3, 4, 5, 15, 6, 7, 16, 17, 18, 2, 12, 19],
                        }
                    },
                    // {
                    // extend: 'pdfHtml5',
                    // className: 'dt-button-icon-left dt-button-icon-pdf',
                    // exportOptions: {
                    // columns: [0, 1, 2, 3, 4,5],
                    // }
                    // },
                    // {
                    // extend: 'print',
                    // text: 'Imprimer',
                    // className: 'dt-button-icon-left dt-button-icon-imprimer',
                    // exportOptions: {
                    // columns: [0, 1, 2, 3, 4,5],
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
           
            ,
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