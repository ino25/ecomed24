<!--sidebar end-->
<!--main content start-->

<section id="main-content" class="">


    <section class="wrapper site-min-height">

        <input type="hidden" id="id_acte" value="<?php echo $id_acte ?>">
        <!-- <div class="state-overview col-md-12" style="padding: 23px 0px;">
            <div class="clearfix">
                <div class="col-lg-3 col-sm-6">
                    <section class="panel home_sec_blue">
                        <div class="symbol blue">
                            <i class="fa fa-hourglass-start"></i>
                        </div>
                        <div class="value">
                            <h3 class="count_pending">
                                <?php
                                //echo $payments['count_pending'];
                                ?>
                            </h3>
                            <p><?php echo lang('pending_'); ?></p>
                        </div>
                    </section>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <section class="panel home_sec_green">
                        <div class="symbol green">
                            <i class="fa fa-hourglass-half"></i>
                        </div>
                        <div class="value">
                            <h3 class="count_done">
                                <?php
                                //echo $payments['count_done'];
                                ?>
                            </h3>
                            <p><?php echo lang('done_'); ?></p>
                        </div>
                    </section>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <section class="panel home_sec_blue">
                        <div class="symbol blue">
                            <i class="fa fa-hourglass-end"></i>
                        </div>
                        <div class="value">
                            <h3 class="count_valid">
                                <?php
                                //echo $payments['count_valid'];
                                ?>
                            </h3>
                            <p><?php echo lang('valid_'); ?></p>
                        </div>
                    </section>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <section class="panel home_sec_green">
                        <div class="symbol green">
                            <i class="fa fa-check"></i>
                        </div>
                        <div class="value">
                            <h3 class="count_facturer">
                                <?php
                                //echo $payments['count_facturer'];
                                ?>
                            </h3>
                            <p><?php echo lang('facturer_'); ?></p>
                        </div>
                    </section>
                </div>

                <!--   <div class="col-lg-3 col-sm-6">
                            
                                 <a href="lab">
                                
                                 <section class="panel home_sec_green">
                                     <div class="symbol green">
                                         <i class="fa fa-flask"></i>
                                     </div>
                                     <div class="value">
                                         <h3 class="">
                <?php
                $this->db->where('id_organisation', $this->id_organisation);
                $this->db->from("lab");
                echo $this->db->count_all_results();
                ?>
                                         </h3>
                                         <p><?php echo lang('lab_report'); ?></p>
                                     </div>
                                 </section>
                                
                                 </a>
                             
                         </div>-->
        </div>
        </div>

        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <h2>Actes</h2>

            </header>

            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table ">
                    <table cellspacing="5" cellpadding="5" border="0">
                        <tbody>
                            <tr>
                                <td class="mode-bars active">
                                    <a href="finance/paymentLabo"> <i class="fas fa-list-ol"></i> Afficher par prestation</a>
                                </td>

                                <?php if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Receptionist', 'Assistant'))) { ?>
                                    <td class="mode-bars ">
                                        <a href="finance/payment"> <i class="fal fa-grip-vertical"></i> Afficher par dossier</a>
                                    </td>
                                <?php } ?>


                                <td>Type: </td>
                                <td>
                                    <select class="form-control" name="modeType" id="modeType">
                                        <option value=""> Tout </option>
                                        <option value='pending'> <?php echo lang('pending_'); ?> </option>
                                        <option value='done'> <?php echo lang('done_'); ?> </option>
                                        <option value='valid'> <?php echo lang('valid_'); ?> </option>
                                        <option value="demandpay"> Sous-traitance </option>
                                        <!-- <option value="cancelled"> ANNULÉ </option> -->
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <!--   <td>Type: </td>
                                <td>
                                    <select class="form-control" name="modeType" id="modeType">
                                        <option value=""> Tout </option>
                                        <option value="Nouveau"> Nouveau </option>
                                        <option value="En cours"> En cours </option>
                                        <option value="Annule"> Annule </option>
                                    </select>
                                </td>
                            </tr>-->
                        </tbody>
                    </table>
                    <div class="space15"></div>
                    <table class="table table-hover progress-table editable-sample editable-sample-paiement" id="editable-sample">
                        <thead>
                            <tr>
                                <th>STATUS</th>
                                <th>ID</th>
                                <th><?php echo lang('code'); ?></th>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('patient'); ?></th>
                                <th><?php echo lang('service'); ?></th>
                                <th><?php echo lang('acte'); ?></th>
                                <th><?php echo lang('status'); ?></th>
                                <th class="option_th no-print" style="width: 15%;"><?php echo lang('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
            </div>
            <input id="logo2" type="hidden" value="">
            <input id="logoBase64" type="hidden" value="">
            <input id="logoFooter" type="hidden" value="">
            <input id="logoBase64Footer" type="hidden" value="">
            <input id="signature" type="hidden" value="">
            <input id="signatureBase64" type="hidden" value="">
            <input id="users" type="hidden" value="<?php echo $this->ion_auth->user()->row()->first_name . ' ' . $this->ion_auth->user()->row()->last_name; ?>">
            <input id="datejour" type="hidden" name="date" value='<?php echo date('d/m/Y'); ?>' placeholder="">
            <input id="datejourfooter" type="hidden" name="date" value='<?php echo date('d/m/Y H:i'); ?>' placeholder="">
        </section>
        <!-- page end-->
    </section>
</section>

<?php //foreach ($payments['info'] as $value) { 
?>
<!---->
<!--<tr>-->
<!--    <td>--><?php //echo $value['status1']; 
                ?>
<!--</td>-->
<!--    <td>--><?php //echo $value['id']; 
                ?>
<!--</td>-->
<!--    <td>--><?php //echo $value['code']; 
                ?>
<!--</td>-->
<!--    <td>--><?php //echo $value['date']; 
                ?>
<!--</td>-->
<!--    <td>--><?php //echo $value['patient']; 
                ?>
<!--</td>-->
<!--    <td>--><?php //echo $value['name_service']; 
                ?>
<!--</td>-->
<!--    <td>--><?php //echo $value['prestation']; 
                ?>
<!--</td>-->
<!--    <td>--><?php //echo $value['status']; 
                ?>
<!--</td>-->
<!--    <td>--><?php //echo $value['options']; 
                ?>
<!--</td>-->
<!--	--><?php //} 
            ?>


<!--main content end-->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="myModalLabel">Infos Patient</h4>
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
<!--footer start-->
<div class="modal fade" id="sttChangeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog ">

        <div class="modal-content" id="sttChangeModalHtml">

        </div>
    </div>
</div>
<div class="modal fade" id="datalabModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog payment-content">
        <?php echo  $payment_patient = '';
        $payment_id = '';
        $id_prestation = '';
        $code_service = '';
        $email_organisation_light_origine = '';
        $id_organisation_light = '';


        ?>

        <div class="">
            <!-- <span id="btnPrintGenerik" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </span> -->
            <input hidden type="text" id="idPayRecuperation">
            <label hidden id="descriptionConfirmation"></label>
            <span onclick="print(this)" id="click" class="btn btn-light border text-black-50 shadow-none" data-attr="btn1"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </span>
            <span onclick="print(this)" class="btn btn-light border text-black-50 shadow-none" data-attr="btn2"><i class="fa fa-download"></i> <?php echo lang('download'); ?> </span>
            <!--<span id="btnSendGenerik"  class="sendlab btn btn-light border text-black-50 shadow-none" data-id="<?php echo  $payment_patient . "####" . $payment_id . "####" . $id_prestation . "####" . $code_service . "####" . $email_organisation_light_origine; ?>"  > <i class="fa fa-envelope"></i> <?php echo lang("send"); ?></span>-->

            <span type="button" class="btn btn-light border text-black-50 shadow-none pull-right" data-dismiss="modal" aria-hidden="true"><i class="fa fa-clone"></i> <?php echo lang('close'); ?></span>
        </div>

        <div class="modal-content" id="datalab">

        </div>
    </div>
</div>

<div class="modal fade" id="sendDatalabModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <!--<div class="">
    <span id="btnDownloadGenerik" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-download"></i>  <?php echo lang('send'); ?> </span> 
   <span type="button" class="btn btn-light border text-black-50 shadow-none pull-right" data-dismiss="modal" aria-hidden="true"><i class="fa fa-clone"></i>  <?php echo lang('close'); ?></span>
</div>-->

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Envoyer le Résultat des Analyses</h4>
            </div>
            <div class="modal-body row" id="sendDatalabModalContent">


            </div>
            <div style="display:none;" id="sendDatalabHtmlPdf">
            </div>
        </div>
    </div>
</div>
<!-- Add Medical History Modal-->
<div class="modal fade" id="addMedicalHistory" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <!-- <h4 class="modal-title"> <?php echo lang('add_case'); ?></h4> -->
                <span id="click" class="btn btn-light border text-black-50 shadow-none" data-attr="btn1"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </span>
                <span class="btn btn-light border text-black-50 shadow-none" data-attr="btn2"><i class="fa fa-download"></i> <?php echo lang('download'); ?> </span>
                <span class="btn btn-primary border text-black-50 shadow-none"><i class="fa fa-download"></i> Traiter </span>
            </div>
            <div class="modal-body">
                <div class="col-10 mx-auto">
                    <div class="accordion" id="listeConsultation">


                    </div>
                </div>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
<script>
    $(document).ready(function() {
        idacte = $('#id_acte').val();
        resultat = "";
        $.ajax({
            url: 'finance/generateRapportPDFBacterio?id=' + idacte,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function(response) {
            resultat = JSON.stringify(response, null, 2);
                const container = document.querySelector('.responseJson');
                // BACTERIO
                for (let speciality of response.specialtyList) {
                    for (let test of speciality.testList) {
                        let section;
                        for (let resultat of test.resultats) {
                            switch (resultat.type) {
                                case 'section':
                                    section = resultat;
                                    section.options = [];
                                    break;
                                default:
                                    section.options.push(resultat);
                                    break;
                            }
                        }
                        test.resultats = test.resultats.filter(elt => elt.type == 'section');
                    }
                }
                responseFinale = JSON.stringify(response, null, 2);
            var options = {
                url: "finance/genererDocumentBacterio",
                dataType: "json",
                type: "POST",
                data: {
                    test: JSON.stringify(responseFinale),
                    idpayment: idacte,
                }, // Our valid JSON string
                success: function(data, status, xhr) {
                    //...
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

        $(".flashmessage").delay(3000).fadeOut(100);

    });
    var dateAnnif = $('#annif').val();
    var datejourFooter = $('#datejourfooter').val();
    var users = $('#users').val();
    var dateFooter = datejourFooter.match(/\d{2}\/\d{2}\/\d{4}/)[0];
    var Heure = datejourFooter.match(/\d{2}:\d{2}/)[0];
    var dataUrl;



    function print(btn) {
        var idPayment = $('#idPayRecuperation').val();

        $.ajax({
            url: 'finance/generateRapportPDF?id=' + idPayment,
            method: 'GET',
            data: '',
            dataType: 'json'
        }).success(function(response) {
            console.log(response);
            var signature = response.signature;
            var covid = response.origins.type_prelevement;
            var {
                nom,
                adresse,
                numero_fixe,
                description_courte_activite,
                slogan,
                description_courte_services,
                horaires_ouverture,
                date_string,
                code,
                path_logo,
                entete,
                footer,
                type_prelevement,
                date_prelevement,
                heure_prelevement,
                motifVoyage,
                patientPassport
            } = response.origins;
            var {
                name: fisrt_name_patient,
                last_name: last_name_patient,
                patient_id,
                sex,
                address
            } = response.patientOrigins;
            var prescripteur;
            if (response.doctor === null) {
                prescripteur = ' ';
            }
            if (response.doctor != null) {
                prescripteur = 'Dr ' + response.doctor.first_name + ' ' + response.doctor.last_name;
            }


            var {
                first_name: first_name_doctor,
                last_name: last_name_doctor,
            } = response.UsersValider;

            var agePatient = response.age;
            if (agePatient === undefined) {
                agePatient = response.patientOrigins.age + ' An(s)';
            }

            var specialiteCovid = response.structure[0].name_specialite;
            var prestationCovid = response.structure[0].prestations[0].prestation;
            var param_resultatCovid = response.structure[0].prestations[0].resultats[1].nom_parametre;
            var resultatCovid = response.structure[0].prestations[0].resultats[1].resultats;
            var param_conclusionCovid = response.structure[0].prestations[0].resultats[0].nom_parametre;
            var conclusionCovid = response.structure[0].prestations[0].resultats[0].resultats;


            document.getElementById('logo2').value = entete;
            document.getElementById('logoFooter').value = footer;
            document.getElementById('signature').value = signature;

            // Condition pour faire la séparation des impressions entre COVID et NON COVID
            if (covid) {
                var tableResultats = response.structure.map(specialite => {
                    var entete = [{
                            text: specialite.name_specialite,
                            fontSize: 13,
                            bold: true,
                            alignment: 'center',
                            colSpan: 4
                        },
                        null,
                        null,
                        null
                    ];
                    prestations = specialite.prestations.map(prestation => {
                        var lignePrestation = [{
                                text: prestation.prestation,
                                alignment: 'left',
                                fontSize: 14,
                                bold: true,
                                colSpan: 4
                            },
                            null,
                            null,
                            null
                        ];

                        var resultats = prestation.resultats.map(resultat => {
                            return [{
                                    text: resultat.nom_parametre,
                                    fontSize: 11,
                                    alignemt: 'right',
                                    border: [false, false, false, false],
                                },
                                {
                                    text: resultat.resultats,
                                    fontSize: 13,
                                    alignemt: 'center',
                                    margin: [2, 0, 0, 0],
                                    border: [false, false, false, false],
                                },
                                {
                                    text: resultat.unite,
                                    fontSize: 5,
                                    alignemt: 'center',
                                    border: [false, false, false, false],
                                },
                                {
                                    text: resultat.valeurs,
                                    fontSize: 5,
                                    alignemt: 'center',
                                    border: [false, false, false, false],
                                }
                            ]
                        })
                        return [lignePrestation, ...resultats]
                    }).reduce((acc, element) => [...acc, ...element], [])

                    return [entete, ...prestations]
                }).reduce((acc, element) => [...acc, ...element], [])
                var interpretation = [{
                        style: 'tableExample',
                        // layout: 'noBorders',
                        table: {
                            widths: [70, "*", 30, 30],
                            lineColor: '#0D4D99',

                            body: [

                                [

                                    {
                                        text: '',
                                        fontSize: 12,
                                    }, {
                                        text: 'RÉSULTATS DES ANALYSES',
                                        fontSize: 15,
                                        bold: true,
                                        color: '#0D4D99',
                                        alignment: 'center',
                                        fillColor: '#eeeeee',

                                    }, {
                                        text: '',
                                        fontSize: 12,
                                    },
                                    {
                                        text: '',
                                        fontSize: 12,
                                    },
                                ],
                            ]
                        },

                        layout: 'lightHorizontalLines',
                    },
                    {
                        fillColor: '#FAF9F5',
                        text: specialiteCovid,
                        alignment: 'center',
                        fontSize: 13,
                        bold: true,
                    },
                    {
                        text: '',
                        style: 'header'
                    },
                    {
                        text: '',
                        style: 'header'
                    },
                    {
                        fillColor: '#FAF9F5',
                        text: prestationCovid,
                        alignment: 'center',
                        fontSize: 15,
                        bold: true,
                    },
                    {
                        text: '',
                        style: 'header'
                    },
                    {
                        text: '',
                        style: 'header'
                    },
                    {
                        text: [{
                                text: param_resultatCovid,
                                fontSize: 13
                            },
                            {
                                text: '      ',
                                fontSize: 12
                            },
                            {
                                text: '      ',
                                fontSize: 12
                            },
                            {
                                text: resultatCovid,
                                italics: true,
                                fontSize: 13,
                                bold: true
                            },
                        ]
                    },
                    {
                        text: '',
                        style: 'header'
                    },
                    {
                        text: '',
                        style: 'header'
                    },
                    {
                        text: [{
                                text: param_conclusionCovid,
                                fontSize: 13
                            },
                            {
                                text: '      ',
                                fontSize: 12
                            },
                            {
                                text: conclusionCovid,
                                italics: true,
                                fontSize: 13,
                                bold: true
                            },
                        ]
                    }
                ];

            } else {
                var tableResultats = response.structure.map(specialite => {
                    var entete = [{
                            text: specialite.name_specialite,
                            fontSize: 13,
                            bold: true,
                            alignment: 'center',
                            colSpan: 4
                        },
                        null,
                        null,
                        null
                    ];
                    var prestations = specialite.prestations.map(prestation => {
                        var lignePrestation = [{
                                text: prestation.prestation,
                                alignment: 'left',
                                fontSize: 10,
                                bold: true,
                                colSpan: 4
                            },
                            null,
                            null,
                            null
                        ];

                        var resultats = prestation.resultats.map(resultat => {
                            return [{
                                    text: resultat.nom_parametre,
                                    fontSize: 10,
                                },
                                {
                                    text: resultat.resultats,
                                    fontSize: 10,
                                    alignemt: 'right',
                                    margin: [2, 0, 0, 0]
                                },
                                {
                                    text: resultat.unite,
                                    fontSize: 10,
                                    alignemt: 'center'
                                },
                                {
                                    text: resultat.valeurs,
                                    fontSize: 10,
                                    alignemt: 'center'
                                }
                            ]
                        })
                        return [lignePrestation, ...resultats]
                    }).reduce((acc, element) => [...acc, ...element], [])

                    return [entete, ...prestations]
                }).reduce((acc, element) => [...acc, ...element], [])

                var interpretation = {
                    style: 'tableExample',
                    table: {
                        widths: ['*', 90, 90, 90],
                        headerRows: 1,
                        lineColor: '#0D4D99',
                        body: [
                            [{
                                    text: 'Analyse(s) Demandées',
                                    fontSize: 12,
                                    bold: true,
                                    color: '#0D4D99'
                                }, {
                                    text: 'Résultats',
                                    fontSize: 12,
                                    bold: true,
                                    color: '#0D4D99'
                                }, {
                                    text: 'Unité',
                                    fontSize: 12,
                                    bold: true,
                                    color: '#0D4D99'
                                },
                                {
                                    text: 'Valeurs Usuelles',
                                    fontSize: 12,
                                    bold: true,
                                    color: '#0D4D99'
                                },
                            ],
                            ...tableResultats
                        ]
                    },
                    layout: 'lightHorizontalLines',
                }
            }

            // FIN COVID

            document.querySelector('#descriptionConfirmation').innerHTML = horaires_ouverture;


            horaires_ouverture = document.getElementById('descriptionConfirmation').innerText;
            sex = sex.replace('Masculin', 'M').replace('Feminin', 'F');
            var logo = $('#logo2').val();
            var logoFooter = $('#logoFooter').val();
            var signature = $('#signature').val();
            var infos_details = 'Patient Prénom: ' + response.patientOrigins.name + ' ' + response.patientOrigins.last_name + ', date de naissance: ' + response.patientOrigins.birthdate + ', date de prélèvement:' + date_prelevement + ' à ' + heure_prelevement;


            var dd = {
                pageSize: 'A4',
                footer: [{
                        columns: [{
                            image: '/sampleImage.jpg/',
                            width: 550,
                            height: 20
                        }],
                        margin: [0, -10, 0, 0]
                    },
                    {
                        alignment: 'justify',
                        widths: [90, 100, '*'],
                        columns: [{
                            // text: 'Résultats d\'analyses de ' + fisrt_name_patient + ' ' + last_name_patient + ' ,Imprimé par : ' + users + ', le ' + dateFooter + ' à ' + Heure,
                            text: "Laboratoire agréé par le Ministère de la Santé et de l'Action sociale pour faire les tests covid",
                            alignment: 'center',
                            fontSize: 12,
                            margin: 5
                        }]
                    },
                ],
                content: [
                    'Page Contents'
                ],
                content: [{
                        columns: [{
                            image: logo2,
                            width: 550,
                            height: 100
                        }]
                    },
                    {
                        canvas: [{
                            type: 'line',
                            x1: 0,
                            y1: 5,
                            x2: 595 - 2 * 40,
                            y2: 5,
                            lineWidth: 0,
                            color: '#DADCD4'
                        }]
                    },
                    {
                        text: '',
                        style: 'header'
                    },
                    {
                        style: 'tableExample',
                        layout: 'noBorders',
                        table: {
                            headerRows: 1,
                            widths: [190, 100, '*'],

                            // dontBreakRows: true,
                            // keepWithHeaderRows: 1,
                            body: [
                                [{
                                        text: [{
                                                text: 'Date et Heure : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            date_string + '\n',
                                            {
                                                text: 'Médecin Prescripteur : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            prescripteur + '\n',
                                            {
                                                text: 'Numéro Dossier : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            code + '\n',
                                            {
                                                text: 'Date de prélèvement : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            date_prelevement + ' à ' + heure_prelevement + '\n',
                                            {
                                                text: 'Type de prélèvement : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            type_prelevement + '\n',
                                        ],
                                    },
                                    {
                                        text: ''
                                    },
                                    {
                                        text: [{
                                                text: 'Prénom et Nom : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            fisrt_name_patient + ' ' + last_name_patient + '\n',
                                            {
                                                text: 'Code : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            patient_id + '\n',
                                            {
                                                text: 'Age : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            agePatient + '\n',
                                            {
                                                text: 'Sexe : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            sex + '\n',
                                            {
                                                text: 'Adresse : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            address + '\n',
                                            {
                                                text: 'N° Passeport : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            patientPassport + '\n',
                                            {
                                                text: 'Motif du voyage : ',
                                                fontSize: 12,
                                                bold: true
                                            },
                                            motifVoyage + '\n',
                                        ],
                                        margin: [25, 0, 0, 0]
                                    },


                                ]
                            ],

                        }
                    },

                    {
                        text: '',
                        style: 'header'
                    },
                    interpretation,
                    {
                        text: '',
                        style: 'header'
                    },
                    {
                        text: '',
                        style: 'header'
                    },
                    {
                        style: 'tableExample',
                        layout: 'noBorders',
                        table: {
                            headerRows: 1,
                            widths: [150, "*", 200],
                            body: [
                                [{
                                        qr: infos_details,
                                        fit: '120',
                                        margin: [0, 40, 0, 0]

                                    },
                                    {
                                        text: '',
                                        style: 'header'
                                    },
                                    {
                                        columns: [{
                                            image: "data:image/png;base64,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",
                                            width: 230,
                                            height: 230,
                                            margin: [0, -25, 0, 0]
                                        }],
                                    },

                                ],
                            ],
                        },
                    },
                    {
                        text: 'Scanner ce QR Code à l\'aide de votre Smartphone connecté à internet pour vérifier l\'authenticité des informations contenues dans ce document',
                        alignment: 'left',
                        fontSize: 11,
                        margin: [0, -50, 0, 0]
                    }
                ],
                styles: {
                    header: {
                        fontSize: 18,
                        bold: true,
                        margin: [0, 0, 0, 10]
                    },
                    subheader: {
                        fontSize: 16,
                        bold: true,
                        margin: [0, 10, 0, 5]
                    },
                    tableExample: {
                        margin: [0, 5, 0, 15]
                    },
                    tableHeader: {
                        bold: true,
                        fontSize: 13,
                        color: 'black'
                    }
                },
                defaultStyle: {
                    // alignment: 'justify'
                }

            }

            toDataURL(logo, function(result) {
                dataUrl = result;
                // console.log('RESULT:', dataUrl);
                document.getElementById('logoBase64').value = dataUrl;
                var logo2 = $('#logoBase64').val();



                dd.content[0].columns[0].image = logo2;
                //dd.content[0].columns[2].image = logo2;
                // dd.content[0].table[0].columns[0].image = logo2;
                if (btn.getAttribute('data-attr') === "btn1") {

                    pdfMake.createPdf(dd).print();

                } else if (btn.getAttribute('data-attr') === "btn2") {
                    pdfMake.createPdf(dd).download('Resultat_Analyse_' + code + '.pdf');

                }
            })

            toDataURL(logoFooter, function(result) {
                dataUrl = result;
                // console.log('RESULT:', dataUrl);
                document.getElementById('logoBase64Footer').value = dataUrl;
                var logoFooter = $('#logoBase64Footer').val();
                dd.footer[0].columns[0].image = logoFooter;
                if (btn.getAttribute('data-attr') === "btn1") {

                    pdfMake.createPdf(dd).print();

                } else if (btn.getAttribute('data-attr') === "btn2") {
                    pdfMake.createPdf(dd).download('Resultat_Analyse_' + code + '.pdf');

                }
            })

            toDataURL(signature, function(result) {
                dataUrl = result;
                // console.log('RESULT:', dataUrl);
                document.getElementById('signatureBase64').value = dataUrl;
            })

        });





    }


    function toDataURL(url, callback) {
        var xhr = new XMLHttpRequest();
        xhr.onload = function() {
            var reader = new FileReader();
            reader.onloadend = function() {
                callback(reader.result);
            }
            reader.readAsDataURL(xhr.response);
        };
        xhr.open('GET', url);
        xhr.responseType = 'blob';
        xhr.send();
    }



    // var logo = $('#logo2').val();


    // function print() {

    //     // var paymentId = $(this).find('[name="payment"]').val();
    //     // alert(paymentID);
    //         // $.ajax({
    //         //     url: 'finance/generateRapportPDF',
    //         //     method: 'GET',
    //         //     data: '',
    //         //     dataType: 'json'
    //         // }).success(function(response) {
    //         //     var name = response.origins.nom;
    //         //    alert(name);
    //         // });
    // }
</script>


<?php $status = '';
if (isset($_GET['status'])) {
    $status = $_GET['status'];
} ?>


<script>
    $(document).ready(function() {

        var table = $('#editable-sample').DataTable({
            responsive: true,
            //   dom: 'lfrBtip',

            "processing": true,
            "serverSide": true,
            "searchable": true,
            "ajax": {
                url: "finance/getPaymentLab?status=<?php echo $status; ?>&all=true",
                type: 'POST',
            },
            scroller: {
                loadingIndicator: true
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
                    // {
                    // extend: 'excelHtml5',
                    // className: 'dt-button-icon-left dt-button-icon-excel',
                    // exportOptions: {
                    // columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
                    // }
                    // },
                    // {
                    // extend: 'pdfHtml5',
                    // className: 'dt-button-icon-left dt-button-icon-pdf',
                    // exportOptions: {
                    // columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
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
                [10, 25, 50, 100],
                ['10', '25', '50', '100']
            ],
            iDisplayLength: 10,
            "order": [
                [1, "desc"]
            ],

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

            // language: {
            //     "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json?<?php echo time(); ?>",
            //     processing: "Traitement en cours...",
            //     search: "_INPUT_",
            //     lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
            //     info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            //     infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            //     infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            //     infoPostFix: "",
            //     loadingRecords: "Chargement en cours...",
            //     zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
            //     emptyTable: "", //emptyTable: "Aucune donnée disponible dans le tableau",
            //     paginate: {
            //         first: "Premier",
            //         previous: "Pr&eacute;c&eacute;dent",
            //         next: "Suivant",
            //         last: "Dernier"
            //     },
            //     aria: {
            //         sortAscending: ": activer pour trier la colonne par ordre croissant",
            //         sortDescending: ": activer pour trier la colonne par ordre décroissant"
            //     },
            //     buttons: {
            //         pageLength: {
            //             _: "Afficher %d éléments",
            //             '-1': "Tout afficher"
            //         }
            //     }
            // }
        });
        table.buttons().container().appendTo('.custom_buttons');
        table.columns([0, 1]).visible(false);

        $('#modeType').click(function() {
            var typeMode = $('#modeType').val();
            table.search(typeMode).draw();
            // table.columns(0).search(typeMode).draw();

        });

        /* $('#modeTypeService').click( function() {
         var typeMode = $('#modeTypeService').val(); 
         table.search(typeMode).draw() ;
         } );
         */
        $(".editlab").click(function(e) {
            e.preventDefault(e);
            var id = $(this).attr('data-id');

        });
    });


    function pendingbutton(payment = '', patient = '', prestation = '', service = '') {
        /*var html = ' <div class="modal-header">';
        html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
        html += '<h4 class="modal-title">  <?php echo lang('change_stt'); ?></h4>';
        html += '</div>';
        html += '<div class="modal-body">';
        html += ' <form role="form" action="#" id="deposit-checkDepot" class="clearfix" method="post" enctype="multipart/form-data">';
        html += '<div class="form-group"> ';
        html += ' <label for="exampleInputEmail1"><?php echo lang('stt_encours'); ?></label> ';

        html += '  </div>';


        html += '<div class="form-group cashsubmit payment  right-six col-md-12">';
        html += ' <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>';
        html += ' <button type="button" name="submit2" id="pendingbutton" onclick="pendingbuttonJson(\'' + payment + '\', \'' + patient + '\', \'' + prestation + '\', \'' + service + '\')"   class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>';
        html += '  </div>';
        html += ' </form>';
        html += ' </div>';

        $('#sttChangeModal').trigger("reset");
        $('#sttChangeModalHtml').html(html);
        $('#sttChangeModal').modal('show');*/
        pendingbuttonJson(payment, patient, prestation, service);
    }

    function pendingbuttonJson(payment, patient, prestation, service) {

        $.ajax({
            url: 'finance/editStatutPaiementByJasonPending?id=' + payment + '&type=1&prestation=' + prestation + '&service=' + service,
            method: 'GET',
            data: '',
            dataType: 'json'
        }).success(function(response) {
            if (response.result) {

                var id = '#status-change' + prestation;
                var tt = '<span class="status-p bg-primary"> <?php echo lang("pending_") ?> </span>';
                $(id).empty().html(tt);
                //if (response.profil) {
                var idspanpending = '#spanpending' + prestation;
                var htmlspanpending = ' <a id="done' + prestation + '" class="green btn payment" href="finance/getPendingIBydActe?id=' + patient + '&payment=' + payment + '&prestation=' + prestation + '&service=' + service + '"  ><i class="fa  fa-hourglass-half"></i> <?php echo lang("done") ?> </a>';

                $(idspanpending).empty().html(htmlspanpending);
                //   }
                $('#sttChangeModal').modal('hide');
            }
        });
    }

    function finishbuttonJson(payment, prestation) {
        $.ajax({
            url: 'finance/editStatutPaiementByJasonFinishByPrestation?id=' + payment + '&type=4&prestation=' + prestation,
            method: 'GET',
            data: '',
            dataType: 'json'
        }).success(function(response) {
            if (response.result) {
                // $('#sttChangeModal').trigger("reset");   $('#sttChangeModal').modal('show');

                var id = '#status-change' + prestation;
                var tt = '<span class="status-p bg-success"> <?php echo lang("finish_") ?> </span>';
                $(id).empty().html(tt);

                var idspanpending = '#spanpending' + prestation;

                $(idspanpending).empty();
                $('#sttChangeModal').modal('hide');
            }
        });
    }

    function finishbutton(payment, prestation) {
        /*  var html = ' <div class="modal-header">';
        html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
        html += '<h4 class="modal-title">  <?php echo lang('change_stt'); ?></h4>';
        html += '</div>';
        html += '<div class="modal-body">';
        html += ' <form role="form" action="#" id="deposit-checkDepot" class="clearfix" method="post" enctype="multipart/form-data">';
        html += '<div class="form-group"> ';
        html += ' <label for="exampleInputEmail1"><?php echo lang('stt_finish'); ?></label> ';

        html += '  </div>';


        html += '<div class="form-group cashsubmit payment  right-six col-md-12">';
        html += ' <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>';
        html += ' <button type="button" name="submit2" id="finishbutton" onclick="finishbuttonJson(\'' + payment + '\', \'' + prestation + '\')"   class="btn btn-info row pull-right"> <?php echo lang('submit'); ?></button>';
        html += '  </div>';
        html += ' </form>';
        html += ' </div>';

        $('#sttChangeModal').trigger("reset");
        $('#sttChangeModalHtml').html(html);
        $('#sttChangeModal').modal('show');
*/
        finishbuttonJson(payment, prestation);
    }
    $(document).ready(function() {
        $(".editlab").click(function(e) {
            e.preventDefault(e);
            var id = $(this).attr('data-id');
            document.getElementById('idPayRecuperation').value = id;
            $('#datalabModal').trigger("reset");
            $('#datalab').empty();
            $('#datalabModal').modal('show');
            $.ajax({
                url: 'lab/editLabByJasonPayment?payment=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
                async: true,
            }).success(function(response) {

                $('#datalab').append(response);
            });
        });
        $(".table").on("click", ".sendlab", function(e) {
            e.preventDefault(e);
            var buff = $(this).attr('data-id').split("####");
            // var patientId = buff[0];
            var paymentId = buff[1];
            var idPrestation = buff[2];
            // var codeService = buff[3];
            var emailOrganisationOrigine = buff[4].trim() == "" || buff[4].trim() == "--" ? "" : buff[4].trim();
            var placeholder = buff[4].trim() == "" || buff[4].trim() == "--" ? "Non fourni. Veuillez saisir une adresse email" : "Email du sous-traitant";
            var idOrganisationLight = buff[5];
            // alert(emailOrganisationOrigine);
            $('#sendDatalabModal').trigger("reset");
            $('#sendDatalabModalContent').empty();
            $('#sendDatalabModal').modal('show');
            // var html =  '<form role="form" id="sendlabpdf" action="finance/editStatutPaiementByJasonAccept" class="clearfix" method="post" enctype="multipart/form-data">';
            var html = '<form role="form" id="sendlabpdf" action="finance/editStatutPaiementByJasonAccept" class="clearfix" method="post" enctype="multipart/form-data">';
            html += '				<div class="form-group col-md-12">';
            html += '           		 <label for="emailLight">Email du sous-traitant</label>';
            html += '            		<input type="email" class="form-control" name="emailLight" id="emailLight" value="' + emailOrganisationOrigine + '" placeholder="' + placeholder + '" min="2" max="100" required>';
            html += '    		    </div>';
            // html += '				<div class="form-group col-md-12">';
            // html += ' <div class="form-group has-feedback">';
            // html += '                    <label for="exampleInputEmail1"> <?php echo lang('choose_file'); ?> reçu</label>';
            // html += '                  <input type="file" class="form-control" placeholder="" name="filenameLight" required accept=".pdf, .doc ,.docs">';
            // html += '                     <span class="glyphicon glyphicon-file form-control-feedback"></span>';
            // html += '                 </div>';
            // html += '    		    </div>';
            html += '    <div class="form-group col-md-12" style="margin-top:-10px !important;">';
            html += ' 		<button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>';
            html += '        <input type="hidden" name="payment" value="' + paymentId + '" />';
            html += '        <input type="hidden" name="prestation" value="' + idPrestation + '" />';
            html += '        <input type="hidden" name="idOrganisationLight" value="' + idOrganisationLight + '" />';
            html += '        <input type="hidden" name="source" value="sendlabLight" />';
            // html += '        <span class="sendlabValid" data-id="'+paymentId+"####"+emailOrganisationOrigine+ '"  ><button id="" class="btn btn-info pull-right" style="background-color:#0F7D4F;" type="submit"><i class="fa fa-envelope"></i> <?php echo lang("send") ?></button></span>';
            html += '        <span class="sendlabValid" data-id="' + paymentId + "####" + idPrestation + '" > <button  name="submit" type="submit" id="submit" class="btn btn-info pull-right"  style="background-color:#0F7D4F;"><i class="fa fa-envelope"></i> <?php echo lang("send") ?></button></span>';
            html += '    </div>';
            html += '    </form>';
            // $.ajax({
            // url: 'lab/editLabByJasonPayment?payment=' + paymentId,
            // method: 'GET',
            // data: '',
            // dataType: 'json',
            // }).success(function(response) {
            $('#sendDatalabModalContent').append(html);
            // alert(response);
            // $('#sendDatalabHtmlPdf').html(response);
            // });
        });


        // $("#sendDatalabModal").on("click", ".sendlabValid", function(e) {
        // e.preventDefault(e);
        // var dataIdBuff = $(this).data("id").split("####");
        // var paymentId = dataIdBuff[0];
        // var idPrestation = dataIdBuff[1];
        // Generation + Sauvegarde PDF
        // var name = 'resultat_analyse-' + new Date().toJSON().slice(0, 10).replace(/-/g, '/') + '_' + paymentId + "_" + idPrestation;
        // alert(name);
        // savePDF('datalabPrint', name); // A finir
        // Envoi mail: à finir
        // Launch Update in AJAX
        // alert($("#submit").html());
        // $("#sendlabpdf").submit();
        // });
        $("#sendDatalabModal").on("submit", '#sendlabpdf', function(e) {
            // e.preventDefault();
            var paymentId = $(this).find('[name="payment"]').val();
            var idPrestation = $(this).find('[name="prestation"]').val();
            var emailLight = $(this).find('[name="emailLight"]').val();

            // Generation + Sauvegarde PDF
            var name = 'resultat_analyse_' + Date.now() + '_' + paymentId;
            // alert(name);
            // pdfToServer('datalabPrint', name); // A finir
            // pdfToServer('datalabPrint', name, paymentId, idPrestation, emailLight); // A finir
            // Envoi mail: à finir
            $.ajax({
                url: 'finance/sendEmailResultatsLight',
                method: 'POST',
                data: {
                    paymentId: paymentId,
                    name: name,
                    emailLight: emailLight,
                    // html: $("#sendDatalabHtmlPdf").html()
                    // html: $("head").html()
                },
                dataType: 'json',
                async: true,
            }).success(function(response) {
                // alert("ok");
                // alert(JSON.stringify(response));
            }).error(function(xhr, status, error) {
                // alert("ko");
                // alert(xhr.responseText);
            });

            // alert("after");
        });

    });




    document.getElementById("btnPrintGenerik").onclick = function() {
        printElementNew(document.getElementById("datalabPrint"));
    }
    document.getElementById("btnDownloadGenerik").onclick = function() {
        var name = 'resultat_analyse-' + new Date().toJSON().slice(0, 10).replace(/-/g, '/');
        downloadElementNew('datalabPrint', name);

    }

    function validation(event) {
        var bt = document.getElementById('submit');
        bt.disabled = true;
        var email = $('#emailLight').val();
        var ok = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email);
        if (ok == true) {
            bt.disabled = false;
            // document.getElementById('refMobRef').value = mobRef;
        } else {
            bt.disabled = true;
        }
    }
</script>
<script type="text/javascript">
    function afficherBulletin(id) {
        $.ajax({
            url: 'finance/afficherBulltin?id=' + id,
            method: 'GET',
            data: '',
            dataType: 'json',
            async: true,
        }).success(function(response) {
            console.log(response.report);
            document.getElementById('listeConsultation').innerHTML = response.report;
            $('#addMedicalHistory').modal('show');
        });
    }

    function infosPatient(id) {
        var iid = id;
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
            async: true,
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
            $('.ageClass').append(response.patient.age).end();
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
    }

    // $(document).ready(function() {
    //     setTimeout(function() {
    //         $.ajax({
    //             url: 'finance/getPaymentLabo',
    //             method: 'GET',
    //             data: '',
    //             dataType: 'json',
    //             async: true,
    //             success: function(response) {
    //                 $('.count_done').append(response.count_finish)
    //                 $('.count_valid').append(response.count_valid)
    //                 $('.count_pending').append(response.count_pending)
    //                 $('.count_facturer').append(response.count_facturer)
    //                 console.log(response);
    //             }
    //         })
    //     }, 1000)
    // })
</script>