<!--sidebar end-->
<!--main content start-->



<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel" id="sectionSearchPartenaire" style="display:block">
            <header class="panel-heading">
                <h2><?php echo lang('facturer_partenaire'); ?></h2>
            </header>
            <div class="">
                <form role="form" class="clearfix" action="partenaire/listePrestationByPartenaire" method="post" enctype="multipart/form-data">
                    <div class="col-md-3 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('search_partenaire'); ?></label>
                        <select class="form-control m-bot15" id="spartenaire" name="partenaire" required="">
                           <?php if($id_partenaire) {?>
                            <option value="<?php echo $id_partenaire;?>"><?php echo $nom_partenaire;?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('date_debut'); ?></label>
                        <input class="form-control  form-control-inline input-medium before_now" type="text" id="birthdates" name="date1" value="" placeholder="" autocomplete="off">
                    </div>
                    <div class="col-md-2 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('date_fin'); ?></label>
                        <input class="form-control  form-control-inline input-medium before_now" type="text" id="birthdate2" name="date2" value="" placeholder="" autocomplete="off">
                    </div>

                    <div class="col-md-2 panel">
                        <label for="exampleInputEmail1"> </label>
                        <button type="submit" class="btn btn-info form-control"> <?php echo lang('search'); ?></button>
                    </div>
                    <div class="">
                        <label id="errorPay" class="error col-md-12">
                            <span style='color:#000;'>Pour continuer, veuillez séléctionner un partenaire et une période de facturation</span>
                        </label>

                    </div>
                </form>

            </div>
            <div class="panel-body panel-bodyAlt">
                <div class="adv-table editable-table ">
                    <table class="table table-hover progress-table" id="dataTable-liste">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo lang('date_commande'); ?></th>
                                <th><?php echo lang('number'); ?></th>
                                <th><?php echo lang('prestation'); ?></th>
                                <th><?php echo lang('create_by'); ?></th>

                                <th><?php echo lang('patient'); ?></th>
                                <th><?php echo lang('amount'); ?></th>
                                <th>À FACTURER</th>
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
                <div class="">
                    <form role="form" class="clearfix" action="partenaire/genererFacturePartenaire" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="date_debut" name="date_debut" value="<?php echo $date_debut; ?>">
                        <input type="hidden" id="date_fin" name="date_fin" value="<?php echo $date_fin; ?>">
                        <input type="hidden" id="id_partenaire" name="id_partenaire" value="<?php echo $id_partenaire; ?>">
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-info form-control">Facturer</button>
                        </div>
                    </form>
                    <a id="" class="btn btn-info btn-secondary pull-left" href="partenaire/listeFacturePrestation">
                        Retour
                    </a>
                </div>
            </div>
        </section>
        <!-- page end-->

    </section>
</section>
<!--main content end-->
<!--footer start-->
<div class="modal fade" id="sendlabBillModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <!--<div class="">
    <span id="btnDownloadGenerik" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-download"></i>  <?php echo lang('send'); ?> </span> 
   <span type="button" class="btn btn-light border text-black-50 shadow-none pull-right" data-dismiss="modal" aria-hidden="true"><i class="fa fa-clone"></i>  <?php echo lang('close'); ?></span>
</div>-->

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Envoyer la facture</h4>
            </div>
            <div class="modal-body row" id="sendlabBillModalContent">


            </div>
            <div style="" id="sendlabBillHtmlPdf">
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>common/js/ecomed24.min.js"></script>

<script>
    $(document).ready(function() {
        $("#spartenaire").select2({
            placeholder: '<?php echo lang('select_partenaire'); ?>',
            allowClear: true,
            ajax: {
                url: 'partenaire/searhPartenaireLightOriginByFacture',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
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
            "order": [
                [0, "desc"]
            ],
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
                emptyTable: "Aucune donnée disponible dans le tableau",
                "zeroRecords": "Aucun élément correspondant trouvé",
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
        table2.columns([0]).visible(false);
        $("#sectionSearchPartenaire").on("click", "#searchPartenaire", function(e) {
            e.preventDefault(e);

            document.getElementById('confirmFactureDiv').style['display'] = 'none';
            var id = $('#spartenaire').val();
            var date1 = $('#birthdates').val();
            var date2 = $('#birthdate2').val();
          //  alert('listePrestationByPartenaire?' + id + ' + id + ' + date1 + ' + date1 + ' + date2 + ' + date2');

            $('#errorPay').empty();
            if (!id) {
                $('#errorPay').empty().html("Veuillez renseigner le partenaire").end();
            } else {

                $.ajax({
                    url: 'partenaire/listePrestationByPartenaire?id=' + id + '&date1=' + date1 + '&date2=' + date2,
                    method: 'GET',
                    data: '',
                    dataType: 'json',
                }).success(function(response) {
                    console.log("**** Partenaire ***");
                    console.log(response);
                    alert(JSON.stringify(response));
                    if (response.result) {
                        // table2.ajax.reload();
                        table2.clear().draw();
                        // table2.destroy();
                        if (response.message) {
                            table2.rows.add($(response.message));
                            document.getElementById('confirmFactureDiv').style['display'] = 'block';

                            console.log(response);

                            if (response.destinatairs) {
                                var resp = genereFacture(response.destinatairs, response.origins, response.prestations, date1, date2, id, response.total, response.tva, response.etatlight, response.emailOrganisationLightOrigine, response.assurance);

                                $('#sectionConfirmPartenaire').empty().html(resp).end();
                            }
                        }
                        table2.draw();
                        table2.columns([0]).visible(false);
                    } else {
                        $('#errorPay').empty().html(response.message).end();
                    }

                });
            }
        });
        $("#sectionSearchPartenaire").on("click", "#confirmFacture", function(e) {
            document.getElementById('sectionSearchPartenaire').style['display'] = 'none';
            document.getElementById('sectionConfirmPartenaire').style['display'] = 'block';
        });



        $("#validFacture").click(function(e) {
            document.getElementById('sectionSearchPartenaire').style['display'] = 'none';
            document.getElementById('sectionConfirmPartenaire').style['display'] = 'block';
        });


        function genereFacture(destinatairs, origins, message, date1, date2, id, total, tva, etatlight, emailOrganisationLightOrigine, assurance) {
            var periode = date1 + '-' + date2;
            var html = '<div class="panel-body_ col-md-12">';
            html += '                 <div class="panel panel-primary" id="invoice">';
            html += '                     <div class="panel-body_" id="editPaymentForm">';
            html += '                        <div class="col-md-12" id="body-print" style="background-color: #fff">';
            html += '                            <div class="row invoice-list">';
            html += '                               <div class="col-md-12 invoice_head clearfix">';
            html += '                                  <div class="col-md-4  invoice_head_left" style="float:left">';

            html += '                                        <img src="' + destinatairs.path_logo + '" style="max-width:220px;max-height:150px;margin-top:-12px" />';


            html += '                                </div>';
            html += '                               <div class="col-md-8 invoice_head_right" style="float:right">';
            html += '                                  <table style="width:100%">';
            html += '                                      <tr>';
            html += '                                          <th>';
            html += '                                              <h4 class="blue">';
            //  html += '                                                  <label class="control-label pull-right blue"><?php echo lang('invoice_f') ?> <?php echo 'NRO'; ?></label>';
            html += '                                              </h4>';
            html += '                                          </th>';
            html += '                                     </tr>';
            html += '                                     <tr>';
            html += '                                          <th>';
            //    html += '                                              <h3 class="blue"><label class="control-label pull-right blue">code</label></h3>';
            html += '                                          </th>';
            html += '                                     </tr>';
            html += '                                </table>';
            html += '                                <br>';

            html += '                           </div>';
            html += '                       </div>';
            html += '                       <div class="col-md-12 invoice_head clearfix">';
            html += '                           <div class="col-md-5  invoice_head_left" style="float:left;">';
            html += '                             <table style="width:100%">';
            html += '                                 <tr>';
            html += '                                     <th>';
            html += '                                       <h4>';
            html += '                                            <label class="control-label pull-left">';
            html += '                                                <span style="font-size:12px;font-weight: normal;"> </span> <span class="blue"> ' + destinatairs.nom + '</span>';
            html += '                                            </label>';
            html += '                                        </h4>';
            html += '                                   </th>';
            html += '                              </tr>';
            html += '                              <tr>';
            html += '                                 <th>';
            html += '                                     <h4>';
            html += '                                         <label class="control-label">';
            html += '                                             <span class="" style="font-weight: normal;">';
            html += destinatairs.adresse + ' <br>';
            html += '                                                <span style="float: left;"> ' + destinatairs.region + ' , ' + destinatairs.pays + '</span>';
            html += '                                            </span>';
            html += '                                        </label>';
            html += '                                    </h4>';
            html += '                                </th>';
            html += '                            </tr>';
            html += '                         <tr>';
            html += '                            <th>';
            html += '                               <h4>';
            html += '                                    <label class="control-label pull-left" style="">';
            var today = new Date();

            var dd = today.getDate();
            var mm = today.getMonth() + 1;

            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }
            var todayNew = dd + '/' + mm + '/' + yyyy;


            html += '                                          Emise le : ' + todayNew;
            html += '                                      </label>';
            html += '                                 </h4>';
            html += '                              </th>';
            html += '                          </tr>';
            html += '                      </table>';
            html += '                 </div>';
            html += '                <div class="col-md-5 invoice_head_right" style="float:right;">';
            html += '                    <table style="width:100%;">';
            html += '                       <tr>';
            html += '                          <th>';
            html += '                              <h4>';
            html += '                                  <label class="control-label pull-right pp100" style="">';
            html += '                                     <span class="blue">  ' + origins.nom + '</span>';
            html += '                                </label>';
            html += '                            </h4>';
            html += '                        </th>';
            html += '                    </tr>';
            html += '                   <tr>';
            html += '                       <th>';
            html += '                           <h4>';
            html += '                               <label class="control-label pull-right pp100" style="">';
            var originsAdresse = origins.adresse != null && origins.adresse.trim() != "" && origins.adresse.trim() != "--" ? origins.adresse.trim() : "";
            html += '                                  <span style="font-weight: normal;">  ' + originsAdresse + '</span>';
            html += '                              </label>';
            html += '                         </h4>';
            html += '                     </th>';
            html += '                 </tr>';
            html += '                <tr>';
            html += '                     <th>';
            html += '                        <h4>';
            html += '                           <label class="control-label pull-right pp100" style="">';
            var originsRegion = origins.region != null && origins.region.trim() != "" && origins.region.trim() != "--" ? origins.region.trim() + ", " : "";
            html += '                              <span style="font-weight: normal;"> ' + originsRegion + origins.pays + '</span>';
            html += '                          </label>';
            html += '                      </h4>';
            html += '                 </th>';
            html += '            </tr>';

            html += '            <tr>';
            html += '               <th>';
            html += '                   <h4>';
            html += '                      <label class="control-label pull-right pp100" style="">';
            html += '                          <span style="font-weight: normal;">';
            html += '                             Période : ' + periode;
            html += '                         </span>';
            html += '                     </label>';
            html += '                 </h4>';
            html += '             </th>';
            html += '         </tr>';
            html += '         <tr>';
            html += '            <th>';
            html += '                <h4>';
            html += '                   <label class="control-label pull-right pp100" style="">';
            today.setDate(today.getDate() + 15);
            var dd = today.getDate();
            var mm = today.getMonth() + 1;

            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }
            var today15jNew = dd + '/' + mm + '/' + yyyy;
            html += '                       A payer avant le : ' + today15jNew;
            html += '                  </label>';
            html += '              </h4>';
            html += '         </th>';
            html += '     </tr>';
            html += '  </table>';
            html += '  </div>';
            html += '  </div>';
            html += '  </div>';
            html += '  </div>';

            html += '<table class="table table-hover progress-table text-center_ editable-sample editable-sample-paiement " id="editable-sample-">';
            html += '   <thead class="theadd">';
            html += '        <tr>';

            html += '  <th><?php echo lang('date_commande'); ?></th>';
            html += '  <th><?php echo lang('number'); ?></th>';
            html += '  <th><?php echo lang('prestation'); ?></th>';
            html += '   <th><?php echo lang('patient'); ?></th>';
            html += '   <th><?php echo lang('amount'); ?></th>';
            html += '                 </tr>';
            html += '               </thead>';
            html += '               <tbody>';
            html += message;
            html += '               </tbody>';
            html += '            </table>';

            html += '           <div class="col-md-12 hr_border">';
            html += '              <hr>';
            html += '           </div>';

            html += '           <div class="">';
            html += '                <div class="col-lg-4 invoice-block pull-left">';
            html += '                    <h4></h4>';
            html += '               </div>';
            html += '             </div>';

            html += '  <div class="col-md-12">';
            html += '     <div class="col-lg-4 invoice-block pull-right">';
            html += '          <ul class="unstyled amounts">';

            html += '        <li><strong><?php echo lang('grand_total_ht'); ?>: </strong>' + total + ' </li>';
            html += '         <li><strong><?php echo lang('tva'); ?>: </strong>' + tva + '</li>';
            html += '         <li><strong><?php echo lang('grand_total_ttc'); ?>: </strong>' + total + '  </li>';

            html += '   </ul>';
            html += '  </div>';
            html += '  </div>';

            html += '<div class="col-md-12" id="bouttonSuivant" style="padding-top:5px">';
            html += '  <span id="returnFactureDiv" onclick="returnFactureDiv()" class="btn btn-info btn-secondary pull-left">Retour</span>';
            html += '<form  role="form" action="partenaire/listeFacturePrestation" class="clearfix" method="post" enctype="multipart/form-data">';
            html += '    <input type="hidden" id="date1"  name="date1" value="' + date1 + '">';
            html += '    <input type="hidden" id="date2"  name="date2" value="' + date2 + '">';
            html += '    <input type="hidden" id="idOrganisation"  name="idOrganisation" value="' + id + '">';
            html += '    <input type="hidden" id="emailOrganisationLightOrigine"  name="emailOrganisationLightOrigine" value="' + emailOrganisationLightOrigine + '">';
            html += '    <span class="">';
            if (assurance == 1) {
                emailOrganisationLightOrigine = emailOrganisationLightOrigine != null && emailOrganisationLightOrigine.trim() != "" && emailOrganisationLightOrigine.trim() != "" ? emailOrganisationLightOrigine.trim() : "";
                // alert(id + "####" + date1 + "####" + date2 + "####" + emailOrganisationLightOrigine);
                html += '        <span onclick="javascript:triggerSendlabBill(this);" data-id="' + id + '####' + date1 + '####' + date2 + '####' + emailOrganisationLightOrigine + '" id="sendlabBill_' + id + "_" + Date.now() + '" class="btn btn-info row pull-right sendlabBill" style="background-color:#0F7D4F;"><i class="fa fa-envelope"></i> <?php echo lang("send") ?> </span>';
            } else if (etatlight != 1) {
                html += '        <button type="submit" name="submit" id="submit1" class="btn btn-info row pull-right"> <?php echo lang('send'); ?></button>';
            } else {
                emailOrganisationLightOrigine = emailOrganisationLightOrigine != null && emailOrganisationLightOrigine.trim() != "" && emailOrganisationLightOrigine.trim() != "" ? emailOrganisationLightOrigine.trim() : "";
                // alert(id + "####" + date1 + "####" + date2 + "####" + emailOrganisationLightOrigine);
                html += '        <span onclick="javascript:triggerSendlabBill(this);" data-id="' + id + '####' + date1 + '####' + date2 + '####' + emailOrganisationLightOrigine + '" id="sendlabBill_' + id + "_" + Date.now() + '" class="btn btn-info row pull-right sendlabBill" style="background-color:#0F7D4F;"><i class="fa fa-envelope"></i> <?php echo lang("send") ?> </span>';
            }
            html += '    </span>';

            html += '</form>';
            html += ' </div>';
            //   </form>
            return html;

        }


        // $("#bouttonSuivant").on("click", ".sendlabBill", function(e) {
        // e.preventDefault(e);
        // alert("clicked");
        // var buff = $(this).attr('data-id').split("####");
        // alert(buff.length);
        // });

        // $("#sendlabBillModal").on("click", ".sendlabBillValid", function(e) {
        // e.preventDefault(e);
        // var dataIdBuff = $(this).data("id").split("####");
        // var idOrganisation = dataIdBuff[0];
        // var date1 = dataIdBuff[1];
        // var date2 = dataIdBuff[2];
        // var emailOrganisationLightOrigine = dataIdBuff[3];
        // Generation + Sauvegarde PDF
        // var name = 'facture-' + new Date().toJSON().slice(0, 10).replace(/-/g, '/') + '_' + idOrganisation;// A faire: Récupérer code Facture
        // alert(name);
        // savePDF('sendlabBillHtmlPdf', name); // A finir
        // Envoi mail: à finir
        // Launch Update in AJAX
        // alert($("#submit").html());
        // $("#sendlabBillpdf").submit();
        // });

        $("#sendlabBillModal").on("submit", "#sendlabBillpdf", function(e) {
            // e.preventDefault(e);

            // var idOrganisation = $(this).find('[name="idOrganisation"]').val();
            // var date1 = $(this).find('[name="date1"]').val();
            // var date2 = $(this).find('[name="date2"]').val();
            // var emailOrganisationLightOrigine = $(this).find('[name="emailLight"]').val();

            // var name = 'facture_' + Date.now() + '_' + idOrganisation;
            // $.ajax({
            // url: 'finance/sendEmailFactureLight',
            // type: 'POST',
            // data: {
            // "idOrganisation": idOrganisation,
            // "name": name,
            // "date1": date1,
            // "date2": date2,
            // "emailOrganisationLightOrigine": emailOrganisationLightOrigine,
            // "html": $("head").html()+$("#sendDatalabHtmlPdf").html()
            // },
            // dataType: 'json',
            // }).success(function(response) {
            // alert("ok");
            // alert(JSON.stringify(response));
            // }).error(function(xhr, status, error) { 
            // alert("ko");
            // alert(xhr.responseText);
            // });
        });

    });

    function triggerSendlabBill(elem) {
        // data-id="' + id + '####' + date1 + '####' + date2 + '####' + emailOrganisationLightOrigine + '"
        var elementId = "#" + elem.id;
        var buff = $(elementId).attr('data-id').split("####");
        var idOrganisation = buff[0];
        var date1 = buff[1];
        var date2 = buff[2];
        var emailOrganisationLightOrigine = buff[3].trim() == "" || buff[3].trim() == "--" ? "" : buff[3].trim();
        var placeholder = buff[3].trim() == "" || buff[3].trim() == "--" ? "Non fourni. Veuillez saisir une adresse email" : "Email du sous-traitant";
        // alert(id);
        // alert(emailOrganisationOrigine);
        $('#sendlabBillModal').trigger("reset");
        $('#sendlabBillModalContent').empty();
        $('#sendlabBillModal').modal('show');
        // var html =  '<form role="form" id="sendlabpdf" action="finance/editStatutPaiementByJasonAccept" class="clearfix" method="post" enctype="multipart/form-data">';
        var html = '<form role="form" id="sendlabBillpdf" action="partenaire/listeFacturePrestationAndSendLabBillPDF" class="clearfix" method="post" enctype="multipart/form-data">';
        html += '				<div class="form-group col-md-12">';
        html += '           		 <label for="emailOrganisationLightOrigine">Email du sous-traitant</label>';
        html += '            		<input type="email" class="form-control" name="emailOrganisationLightOrigine" id="emailOrganisationLightOrigine" value="' + emailOrganisationLightOrigine + '" placeholder="' + placeholder + '" min="2" max="100" required>';
        html += '    		    </div>';
        html += '    <div class="form-group col-md-12" style="margin-top:-10px !important;">';
        html += ' 		<button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('close'); ?></button>';
        html += '        <input type="hidden" id="name" name="name" value="' + 'facture_' + Date.now() + '_' + idOrganisation + '" />';
        html += '        <input type="hidden" id="date1" name="date1" value="' + date1 + '" />';
        html += '        <input type="hidden" id="date2" name="date2" value="' + date2 + '" />';
        html += '        <input type="hidden" id="idOrganisation" name="idOrganisation" value="' + idOrganisation + '" />';
        // html += '        <span class="sendlabValid" data-id="'+paymentId+"####"+emailOrganisationOrigine+ '"  ><button id="" class="btn btn-info pull-right" style="background-color:#0F7D4F;" type="submit"><i class="fa fa-envelope"></i> <?php echo lang("send") ?></button></span>';
        html += '        <span class="sendlabBillValid" data-id="' + idOrganisation + "####" + date1 + "####" + date2 + "####" + emailOrganisationLightOrigine + '" > <button type="submit" name="submit" id="submit" class="btn btn-info pull-right"  style="background-color:#0F7D4F;"><i class="fa fa-envelope"></i> <?php echo lang("send") ?></button></span>';
        html += '    </div>';
        html += '    </form>';
        // $.ajax({
        // url: 'lab/editLabByJasonPayment?payment=' + paymentId,
        // method: 'GET',
        // data: '',
        // dataType: 'json',
        // }).success(function(response) {
        $('#sendlabBillModalContent').append(html);
        // $('#sendlabBillHtmlPdf').html($('#sectionConfirmPartenaire').html());
        // $('#sendlabBillHtmlPdf').find('#bouttonSuivant').remove(); // #bouttonSuivant
        // });	
    }

    function returnFactureDiv() {
        document.getElementById('sectionSearchPartenaire').style['display'] = 'block';
        document.getElementById('sectionConfirmPartenaire').style['display'] = 'none';
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