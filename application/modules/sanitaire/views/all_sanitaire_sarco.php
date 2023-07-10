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
                <h2>Rapport sanitaire Recherche directe d'ARN du SARS-Cov-2</h2>


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
                                        <td>
                                            <div class="social-option"> <select class="form-control" id="selectperiode">
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
                                            <option value="Négatif"> Négatif </option>
                                            <option value="Positif"> Positif </option>
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
                                <th> <?php echo lang('name'); ?> & <?php echo lang('last_name'); ?></th>
                                <th> <?php echo lang('phone'); ?></th>
                                <th> <?php echo lang('age_annee'); ?></th>
                                <th> <?php echo lang('sex'); ?></th>
                                <th> <?php echo lang('date_prelevement'); ?></th>
                                <th> <?php echo lang('view_report'); ?></th>
                                <th><?php echo lang('numero_dossier'); ?></th>
                                <th style="display:none"><?php echo lang('name'); ?></th>
                                <th style="display:none"><?php echo lang('last_name'); ?></th>
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
                            <?php foreach ($sanitaires as $sanitaire) { ?>
                                <tr class="">
                                    <td style="vertical-align:middle;"><?php echo $sanitaire->patientName. ' '.$sanitaire->patientLast_Name; ?> </td>
                                    <td style="vertical-align:middle;"><?php echo $sanitaire->phone; ?></td>
                                    <td style="vertical-align:middle;"><?php echo $sanitaire->age; ?> </td>
                                    <td style="vertical-align:middle;"><?php echo $sanitaire->sex; ?></td>
                                    <td style="vertical-align:middle;"><?php echo $sanitaire->sampling_date; ?></td>
                                    <td style="vertical-align:middle;"><?php echo $sanitaire->resultats; ?> </td>
                                    <td style="vertical-align:middle;"><?php echo $sanitaire->report_code; ?></td>
                                    <td style="display:none"><?php echo $sanitaire->patientName; ?></td>
                                    <td style="display:none"><?php echo $sanitaire->patientLast_Name; ?></td>
                                    <td style="display:none"><?php echo $sanitaire->address; ?></td>
                                    <td style="display:none"><?php echo $sanitaire->report_code; ?></td>
                                    <td style="display:none"></td>
                                    <td style="display:none">RSA</td>
                                    <td style="display:none"></td>
                                    <td style="display:none">1</td>
                                    <td style="display:none"><?php echo $sanitaire->date_string; ?></td>
                                    <td style="display:none"></td>
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
        var positif = 'Positif';
        var negatif = 'Négatif';

        if (myElementValue != 'parPeriode') {
            if (typeValue.indexOf(recette) != -1) {
                var typeElement = 'Positif';
                var url = `debut=${debut}&fin=${fin}&type=${typeElement}&periode=${myElementValue}`;
                window.location.search = url;
            } else if (typeValue.indexOf(depense) != -1) {
                var typeElement = 'Négatif';
                var url = `debut=${debut}&fin=${fin}&type=${typeElement}&periode=${myElementValue}`;
                window.location.search = url;
            } else {
                var url = `debut=${debut}&fin=${fin}&periode=${myElementValue}`
                window.location.search = url;

            }
        } else {
            if (typeValue.indexOf(recette) != -1) {
                var typeElement = 'Positif';
                var url = window.location.search + `&type=${typeElement}`;
                window.location.search = url;
            } else if (typeValue.indexOf(depense) != -1) {
                var typeElement = 'Négatif';
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
            document.querySelector('#modeType').value = urlParams.get('type') == 'Négatif' ? 'Négatif' : urlParams.get('type') == 'Positif' ? 'Positif' : '';
            var datePeriode = `Du ${debut} au ${fin}`;
            document.querySelector("#datePeriode").innerHTML = datePeriode;


        } else {
            $('#editAppointmentModal').modal('show');
            $("#validerPeriode").click(function(e) {
                var debut = $('#birthdates').val();
                var fin = $('#date_fin').val();
                var url = `debut=${debut}&fin=${fin}&periode=${eventObj.target.value}`
                window.location.search = url;
                document.querySelector('#modeType').value = urlParams.get('type') == 'Négatif' ? 'Négatif' : urlParams.get('type') == 'Positif' ? 'Positif' : '';
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
    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        document.querySelector('#selectperiode').value = urlParams.get('periode') || 'aujourdhui';
        document.querySelector('#modeType').value = urlParams.get('type') == 'Positif' ? 'Positif' : urlParams.get('type') == 'Négatif' ? 'Négatif' : '';
        var table = $('#editable-sample').DataTable({
            responsive: true,

            fixedHeader: true,
            dom: "<'row'<'col-sm-4 pull-left'l><'col-sm-4 pull-left'B><'col-sm-4 pull-right'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: {
                buttons: [
                    {
                    extend: 'excelHtml5',
                    className: 'dt-button-icon-left dt-button-icon-excel',
                    exportOptions: {
                    columns: [7,8,1,2,3,4,5,6,9,10,11,12,13,14,15,16],
                    }
                    },
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
        $('#modeType').click(function() {
            var typeMode = $('#modeType').val();
            table.search(typeMode).draw();
        });
    });
</script>