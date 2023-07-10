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
                <h4 style="float:right;color:#0d4d99;font-weight: bold;"><?php if (!empty($datePeriode)) {
                                                                                echo $datePeriode;
                                                                            }  ?></h4>
                <h2><?php echo lang('financial_report'); ?></h2>


            </header>

            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table">
                    <div class="space15"></div>
                    <div class="col-lg-6 col-md-6">
                        <table border="0" cellspacing="5" cellpadding="5" style="float:left">
                            <tbody>
                                <tr>
                                    <td><strong style="color:#0d4d99"> Période: </strong></td>
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
                                </tr>
                            </tbody>
                        </table>
                        <table border="0" cellspacing="5" cellpadding="5" style="float:left">
                            <tbody>
                                <tr>
                                    <td><strong style="color:#0d4d99"> Type: </strong></td>
                                    <td><select class="form-control" name="modeType" id="modeType" onchange="typeUpdate(event)">
                                            <option value=""> Tout </option>
                                            <option value="recette"> Recettes </option>
                                            <option value="depense"> Dépenses </option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-2 col-md-4">
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div style="float:right;padding-top:10px;color:#0d4d99">
                            <h3 id="montantAfficher"></h3>
                        </div>
                    </div>
                    <table class="table table-hover progress-table" id="editable-sample">
                        <thead>
                            <tr>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('recu'); ?></th>
                                <th><?php echo lang('patient_beneficiaire'); ?></th>
                                <th><?php echo lang('amount'); ?></th>
                                <th><?php echo lang('libelle'); ?></th>
                                <th>EFFECTUER PAR </th>
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
                                            <span class="positive money"><?php echo $paymentExpenses->concatMontant; ?></span> <span class="positive">FCFA</span>
                                            <?php $total_amount[] = $paymentExpenses->concatMontant; ?>
                                        <?php } ?>
                                        <?php
                                        if ($paymentExpenses->concatMontant < 0) { ?>
                                            <span class="negative money"><?php echo $paymentExpenses->concatMontant; ?></span> <span class="negative">FCFA</span>
                                            <?php $total_amount[] = $paymentExpenses->concatMontant; ?>
                                        <?php } ?>

                                    </td>
                                    <!-- <td style="vertical-align:middle;">
                                        <?php if (!empty($paymentExpenses->category_name)) {
                                            $id_prestationBuff0 = explode(",", $paymentExpenses->category_name);
                                            $separator = '';
                                            foreach ($id_prestationBuff0 as $id_prestationBuff) {
                                                $id_prestationBuff1 = explode("*", $id_prestationBuff);
                                                $separator = ($this->db->query("select distinct name_service from payment_category join setting_service on payment_category.id_service = setting_service.idservice and payment_category.id = " . $id_prestationBuff1[0])->row())->name_service;
                                            }
                                            echo $separator;
                                            echo $paymentExpenses->specialite;
                                        } else {
                                            echo  $paymentExpenses->libelle_specialite;
                                        } ?>
                                    </td> -->

                                    <td style="vertical-align:middle;">
                                        <?php if (!empty($paymentExpenses->category_name)) {
                                            $id_prestationBuff0 = explode(",", $paymentExpenses->category_name);
                                            $separator = '';
                                            foreach ($id_prestationBuff0 as $id_prestationBuff) {
                                                $id_prestationBuff1 = explode("*", $id_prestationBuff);
                                                // $this->db->where('id', $id_prestationBuff1[0]);
                                                // $query = $this->db->get('payment_category');

                                                $this->db->select('prestation as name');
                                                $this->db->where('id', $id_prestationBuff1[0]);
                                                $this->db->from('payment_category');
                                                $query1 = $this->db->get_compiled_select();

                                                $this->db->select('name as name');
                                                $this->db->where('id', $id_prestationBuff1[0]);
                                                $this->db->from('lab_test');
                                                $query2 = $this->db->get_compiled_select();
                                                $query = $this->db->query($query1 . ' UNION ' . $query2);

                                                $result = $query->row();
                                                $separator .= $result->name . ' , ';
                                            }
                                            echo $separator;
                                            echo $paymentExpenses->libelle;
                                        } else {
                                            echo  $paymentExpenses->libelle_prestation;
                                        } ?></td>
                                        <td><?php echo $paymentExpenses->first_name.' '.$paymentExpenses->last_name.' '.$paymentExpenses->email; ?></td>
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
            <!-- SHOW PERIODE -->
            <!-- <div class="modal fade" id="editAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class=" modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title pull-left">
                                PERIODE :
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="col-md-5 mb-6">
                                    <label for="validationCustom02">Date Début</label>
                                    <div class="datepicker2 date input-group p-0 shadow-sm">
                                        <input type="text" class="form-control form-control-inline input-medium afert_now" name="dateDebut" id="dateDebut" value='' autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-5 mb-6">
                                    <label for="validationCustom02">Date Fin</label>
                                    <div class="datepicker2 date input-group p-0 shadow-sm">
                                        <input type="text" class="form-control form-control-inline input-medium afert_now" name="dateFin" id="dateFin" value='' autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3" style="padding-top: 28px;">
                                    <button id="validerPeriode" class="btn btn-primary" type="submit">Valider</button>
                                </div>
                                <div class="modal-footer" style="text-align: center;">
                                    <button id="fermer" type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- FIN -->
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
<!--main content end-->
<!--footer start-->


<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/autoNumeric.min.js"></script>
<script>
    $(document).ready(function() {
        // $('#editAppointmentModal').modal('show');
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
        var recette = 'recette';
        var depense = 'depense';

        if (myElementValue != 'parPeriode') {
            if (typeValue.indexOf(recette) != -1) {
                var typeElement = 'recette';
                var url = `debut=${debut}&fin=${fin}&type=${typeElement}&periode=${myElementValue}`;
                window.location.search = url;
            } else if (typeValue.indexOf(depense) != -1) {
                var typeElement = 'depense';
                var url = `debut=${debut}&fin=${fin}&type=${typeElement}&periode=${myElementValue}`;
                window.location.search = url;
            } else {
                var url = `debut=${debut}&fin=${fin}&periode=${myElementValue}`
                window.location.search = url;

            }
        } else {
            if (typeValue.indexOf(recette) != -1) {
                var typeElement = 'recette';
                var url = window.location.search + `&type=${typeElement}`;
                window.location.search = url;
            } else if (typeValue.indexOf(depense) != -1) {
                var typeElement = 'depense';
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


    // function caisseUpdate(eventObj) {
    //     if (eventObj.offsetY >= 0)
    //         return;
    //     updatePeriode(eventObj.target.value);
    //     var listeType = document.getElementById('modeType');
    //     var typeValue = listeType.value;

    //     if (eventObj.target.value != 'parPeriode') {

    //         var url = `debut=${debut}&fin=${fin}&periode=${eventObj.target.value}`
    //         window.location.search = url;
    //         document.querySelector('#modeType').value = urlParams.get('type') == 'recette' ? 'recette' : urlParams.get('type') == 'depense' ? 'depense' : '';
    //         var datePeriode = `Du ${debut} au ${fin}`;
    //         document.querySelector("#datePeriode").innerHTML = datePeriode;


    //     } else {
    //         $('#editAppointmentModal').modal('show');
    //         $("#validerPeriode").click(function(e) {
    //             var debut = $('#birthdates').val();
    //             var fin = $('#date_fin').val();
    //             var url = `debut=${debut}&fin=${fin}&periode=${eventObj.target.value}`
    //             window.location.search = url;
    //             document.querySelector('#modeType').value = urlParams.get('type') == 'recette' ? 'recette' : urlParams.get('type') == 'depense' ? 'depense' : '';
    //         })

    //     }

    // }
</script>
<script>
    var total = 0;


    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        document.querySelector('#selectperiode').value = urlParams.get('periode') || 'ceMoisCi';
        document.querySelector('#modeType').value = urlParams.get('type') == 'recette' ? 'recette' : urlParams.get('type') == 'depense' ? 'depense' : '';

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
                    {
                    extend: 'excelHtml5',
                    className: 'dt-button-icon-left dt-button-icon-excel',
                    exportOptions: {
                    columns: [0, 1, 2, 3, 4,5],
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