<!--sidebar end-->
<!--main content start-->
<style>
    span.hr {
        display: block;
        height: 2px;
        border: 1;
        border-top: 2px solid #0D4D99;
        margin: 0;
        width: 100%;
        padding: 0;
        padding-bottom: 10px;
    }

    .lab {
        padding-top: 10px;
        padding-bottom: 20px;
        border: none;

    }

    .pad_bot {
        padding-bottom: 5px;
    }

    form {
        background: #ffffff;
        padding: 20px 0px;
    }

    .modal-body form {
        background: #fff;
        padding: 21px;
    }

    .remove {
        float: right;
        margin-top: -45px;
        margin-right: 42%;
        margin-bottom: 41px;
        width: 94px;
        height: 29px;
    }

    .remove1 span {
        width: 33%;
        height: 50px !important;
        padding: 10px
    }

    .qfloww {
        padding: 10px 0px;
        height: 370px;
        background: #f1f2f9;
        overflow: auto;
    }

    .remove1 {
        background: #5A9599;
        color: #fff;
        padding: 5px;
    }


    .span2 {
        padding: 6px 12px;
        font-size: 14px;
        font-weight: 400;
        line-height: 1;
        color: #555;
        text-align: center;
        background-color: #eee;
        border: 1px solid #ccc
    }
</style>
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->

        <form role="form" id="editLabForm" class="clearfix" action="lab/addLabNewPayment" method="post" enctype="multipart/form-data">

            <section class="panel col-md-12 no-print">
                <header class="panel-heading no-print">
                    <?php
                    $prestation = '';
                    if (isset($_GET['prestation'])) {
                        $prestation = $_GET['prestation'];
                    }
                    $payment = '';
                    if (isset($_GET['payment'])) {
                        $payment = $_GET['payment'];
                    }
                    ?>
                    Résultats d'Analyse
                </header>
                <center>
                    <div class="sidebar-toggle-box" style="">
                        <div class="nav notify-row" id="top_menu">
                            <img src="<?php echo !empty($entete) ? $entete : "uploads/entetePartenaires/default.png"; ?>" style="max-width:800px;max-height:200px;float:left;" />
                        </div>
                    </div>
                </center>

                <div class="no-print">
                    <div class="adv-table editable-table ">
                        <div class="clearfix">


                            <div class="col-md-12 panel">
                                <span class="hr"></span>
                                <hr>
                                <input type="hidden" name="payment_id" value="<?php echo $payments->id; ?>">
                                <div class="row">
                                    <div class="col-md-6 pull-left">
                                        <h3 style="color:#0D4D99">Infos Patient</h3>
                                        <div class='row'>
                                            <div class="form-group col-md-4">
                                                <label><strong>Code Patient : </strong></label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span><?php echo $patient->patient_id; ?></span>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class="form-group col-md-4">
                                                <label><strong>Prénom et Nom : </strong></label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span><?php echo $patient->name . ' ' . $patient->last_name; ?></span>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class="form-group col-md-4">
                                                <label><strong>Téléphone : </strong></label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span><?php echo $patient->phone; ?></span>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class="form-group col-md-4">
                                                <label><strong>Age : </strong></label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span><?php echo $patient->age; ?> An(s)</span>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class="form-group col-md-4">
                                                <label><strong>Sexe : </strong></label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span><?php echo $patient->sex; ?></span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6 pull-right">
                                        <h3 style="color:#0D4D99">Infos Actes</h3>
                                        <div class='row'>
                                            <div class="form-group col-md-4">
                                                <label><strong>Prescripteur Pr/Dr/Mme/Mr/ : </strong></label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span><?php if (!empty($doctor)) {
                                                            echo 'Dr ' . $doctor->first_name . ' ' . $doctor->last_name;
                                                        } else echo 'Non renseigné '  ?> </span>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class="form-group col-md-4">
                                                <label><strong>Service : </strong></label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span><?php echo $nom_organisation; ?></span>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class="form-group col-md-4">
                                                <label><strong>Date prescription : </strong></label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span><?php echo $payments->date_string; ?></span>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class="form-group col-md-4">
                                                <label><strong>Numéro Dossier : </strong></label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <span><?php echo $payments->code; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                            </div>

                            <div class='form-group col-md-6'>
                                <div class="form-group col-md-5">
                                    <label><strong>Numéro de Régistre : </strong></label>
                                </div>
                                <div class="form-group col-md-5">
                                    <input type="text" class="form-control pay_in " name="numeroRegistre" value='' placeholder="">
                                </div>
                            </div>
                            <div class='form-group col-md-6'>
                                <div class="form-group col-md-6">
                                    <label><strong>Renseignement Clinique : </strong></label>
                                </div>
                                <div class="form-group col-md-6">
                                    <textarea rows="4" cols="35" name="renseignementClinique"><?php echo $payments->renseignementClinique; ?></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <span class="hr"></span>
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color: #F5F5F5;text-align:center"><?php echo $prestations->prestation ?></div>
                    </div>
                    <!-- <div class="col-md-4 lab pad_bot">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input type="text" class="form-control pay_in " name="date" value='<?php
                                                                                            if (!empty($lab->date)) {
                                                                                                echo date('d/m/Y', $lab->date);
                                                                                            } else {
                                                                                                echo date('d/m/Y');
                                                                                            }
                                                                                            ?>' placeholder="" readonly>
                    </div>

                    <div class="col-md-4 lab pad_bot">
                        <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                        <select class="form-control m-bot15 pos_select" id="pos_select" name="patient" value='' required readonly>
                            <option value="<?php echo $patient->id; ?>"><?php echo $patient->name . ' ' . $patient->last_name; ?></option>
                        </select>

                    </div> -->




                    <!-- <div class="col-md-8 panel"> 
                                </div> -->

                </div>
                <div class="col-md-12 lab pad_bot" id="zero_group">
                </div>
                <!-- <div class="col-md-12 lab pad_bot" id="">
                    <label for="exampleInputEmail1"><?php echo lang("speciality") ?> : <span id="speciality"></span> </label>
                </div> -->
                <div class="col-md-12 lab pad_bot" id="report_group">
                    <!-- <label for="exampleInputEmail1">R&eacute;sultats des analyses</label> -->
                    <table class="table table-hover progress-table text-center" cellpadding="1" cellspacing="1" style="width:100%" id='report_table' style="display:none">
                        <!--<caption>R&Eacute;SULTATS DES ANALYSES</caption>-->
                        <!-- <thead style="margin-top:5px;">
                            <tr>

                                <th style="text-transform:none !important;" scope="col">Analyse(s) Demand&eacute;es</th>
                                <th style="text-transform:none !important;" scope="col">R&eacute;sultats</th>
                                <th style="text-transform:none !important;" scope="col">Unit&eacute;</th>
                                <th style="text-transform:none !important;" scope="col">Valeurs Usuelles</th>
                            </tr>
                        </thead> -->
                        <div id='report_body2'></div>
                        <tbody id='report_body' style="display:none">

                        </tbody>
                    </table>

                    <p>&nbsp;</p>
                    <!--<textarea class="ckeditor form-control" style="display:none;" id="editor" name="report" value="" rows="10"><?php
                                                                                                                                    if (!empty($setval)) {
                                                                                                                                        echo set_value('report');
                                                                                                                                    }
                                                                                                                                    if (!empty($lab->report)) {
                                                                                                                                        echo $lab->report;
                                                                                                                                    }
                                                                                                                                    ?>
</textarea>-->
                </div>
                <div class="col-md-3" style="padding-top:35px;">
                    <a href="finance/paymentLabo" class="btn btn-info btn-secondary pull-left"><?php echo lang('retour'); ?></a>
                    <button type="submit" name="submit" id="submit" class="btn btn-info pull-right"><?php echo lang('add'); ?></button>
                </div>
                <?php if ($prestation == 'all') { ?>
                    <input type="hidden" name="redirect" value="finance/payment">
                <?php } else { ?>
                    <input type="hidden" name="redirect" value="finance/paymentLabo">
                <?php } ?>


                <input type="hidden" name="id" id="id_lab" value='<?php
                                                                    if (!empty($lab->id)) {
                                                                        echo $lab->id;
                                                                    }
                                                                    ?>'>
                <input type="hidden" name="idlab" id="idlab" value='<?php
                                                                    if (!empty($idlab->idlab)) {
                                                                        echo $idlab->idlab;
                                                                    }
                                                                    ?>'>

                <div class="col-md-12 lab">

                </div>


                </div>
                </div>
                </div>



            </section>
            <section class="col-md-3">
                <header class="panel-heading no-print" style="color:#fff"> effectuer Résultats d'Analyse
                </header>
                <div class="col-md-12 no-print" style="margin-top: 45px;">



                </div>

            </section>

        </form>





        <style>
            th {
                text-align: center;
            }

            td {
                text-align: center;
            }

            tr.total {
                color: green;
            }



            .control-label {
                width: 100px;
            }



            h1 {
                margin-top: 5px;
            }


            .print_width {
                width: 50%;
                float: left;
            }

            ul.amounts li {
                padding: 0px !important;
            }

            .invoice-list {
                margin-bottom: 10px;
            }




            .panel {
                border: 0px solid #5c5c47;
                background: #fff !important;
                height: 100%;
                margin: 20px 5px 5px 5px;
                border-radius: 0px !important;

            }



            .table.main {
                margin-top: -50px;
            }



            .control-label {
                margin-bottom: 0px;
            }

            tr.total td {
                color: green !important;
            }

            .theadd th {
                background: #edfafa !important;
            }

            td {
                font-size: 12px;
                padding: 5px;
                font-weight: bold;
            }

            .details {
                font-weight: bold;
            }

            /* hr {
                border-bottom: 2px solid green !important;
            } */

            .corporate-id {
                margin-bottom: 5px;
            }

            .adv-table table tr td {
                padding: 5px 10px;
            }



            .btn {
                margin: 10px 10px 10px 0px;
            }












            @media print {

                h1 {
                    margin-top: 5px;
                }

                #main-content {
                    padding-top: 0px;
                }

                .print_width {
                    width: 50%;
                    float: left;
                }

                ul.amounts li {
                    padding: 0px !important;
                }

                .invoice-list {
                    margin-bottom: 10px;
                }

                .wrapper {
                    margin-top: 0px;
                }

                .wrapper {
                    padding: 0px 0px !important;
                    background: #fff !important;

                }



                .wrapper {
                    border: 2px solid #777;
                    min-height: 910px;
                }

                .panel {
                    border: 0px solid #5c5c47;
                    background: #fff !important;
                    padding: 0px 0px;
                    height: 100%;
                    margin: 5px 5px 5px 5px;
                    border-radius: 0px !important;

                }



                .table.main {
                    margin-top: -50px;
                }



                .control-label {
                    margin-bottom: 0px;
                }

                tr.total td {
                    color: green !important;
                }

                .theadd th {
                    background: #edfafa !important;
                }

                td {
                    font-size: 12px;
                    padding: 5px;
                    font-weight: bold;
                }

                .details {
                    font-weight: bold;
                }

                hr {
                    border-bottom: 2px solid green !important;
                }

                .corporate-id {
                    margin-bottom: 5px;
                }

                .adv-table table tr td {
                    padding: 5px 10px;
                }
            }
        </style>









    </section>

</section>
</section>
<!--main content end-->
<!--footer start-->

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>



<script>
    $(document).ready(function() {
        var tot = 0;
        $(".ms-selected").click(function() {
            var id = $(this).data('idd');
            $('#id-div' + id).remove();
            $('#idinput-' + id).remove();
            $('#mediidinput-' + id).remove();

        });
        $.each($('select.multi-select option:selected'), function() {
            var id = $(this).data('idd');
            if ($('#idinput-' + id).length) {

            } else {
                if ($('#id-div' + id).length) {

                } else {

                    $("#editLabForm .qfloww").append('<div class="remove1 col-md-12" id="id-div' + id + '"> <span class="col-md-3 span1">  ' + $(this).data("cat_name") + '</span><span class="col-md-4 span2">Value: </span><span class="col-md-4 span3">Reference Value:<br> ' + $(this).data('id') + '</span></div>')
                }
                var input2 = $('<input>').attr({
                    type: 'text',
                    class: "remove col-md-3",
                    id: 'idinput-' + id,
                    name: 'valuee[]',
                    value: '1',
                }).appendTo('#editLabForm .qfloww');

                $('<input>').attr({
                    type: 'hidden',
                    class: "remove",
                    id: 'mediidinput-' + id,
                    name: 'lab_test_id[]',
                    value: id,
                }).appendTo('#editLabForm .qfloww');
            }


        });
    });
</script>



<script>
    $(document).ready(function() {
        $('.multi-select').change(function() {
            var tot = 0;
            $(".ms-selected").click(function() {
                var id = $(this).data('idd');
                $('#id-div' + id).remove();
                $('#idinput-' + id).remove();
                $('#mediidinput-' + id).remove();

            });
            $.each($('select.multi-select option:selected'), function() {
                var id = $(this).data('idd');
                if ($('#idinput-' + id).length) {

                } else {
                    if ($('#id-div' + id).length) {

                    } else {

                        $("#editLabForm .qfloww").append('<div class="remove1 col-md-12" id="id-div' + id + '"> <span class="col-md-3 span1">  ' + $(this).data("cat_name") + '</span><span class="col-md-4 span2">Value: </span><span class="col-md-4 span3">Reference Value:<br> ' + $(this).data('id') + '</span></div>')
                    }
                    var input2 = $('<input>').attr({
                        type: 'text',
                        class: "remove col-md-3",
                        id: 'idinput-' + id,
                        name: 'valuee[]',
                        value: '1',
                    }).appendTo('#editLabForm .qfloww');

                    $('<input>').attr({
                        type: 'hidden',
                        class: "remove",
                        id: 'mediidinput-' + id,
                        name: 'lab_test_id[]',
                        value: id,
                    }).appendTo('#editLabForm .qfloww');
                }


            });

        });
    });
</script>



<script>
    $.ajax({

        url: 'finance/getPendingPrestationsByPatientIdActe',
        method: "POST",
        data: {
            id: <?php echo $patient->id; ?>,
            payment: '<?php echo $payment; ?>',
            prestation: '<?php echo $prestation; ?>'
        },
        async: false,
        dataType: 'json',
        success: function(data) {
            var html = "";
            speciality = '';
            // html = data;
            // alert("html: "+html);
            var i;
            // alert(data.length);

            //$("#submit").attr("disabled", true);
            $("#report_body2").html("");
            $("#report_body").html("");
            $("#zero_group").html("");
            console.log('****** LES DONNEES ****************')
            console.log(data);
            if (data.length == 0) {
                // $("#prestations_en_cours").attr("readonly", true);
                // $("#prestations_en_cours").css("pointer-events","none");
                $("#report_group").hide();
                $("#report_table").hide();
                $("#zero_group").html("<code style='font-weight:bold;'>Pas de prestation en cours pour ce patient</code>");
                $("#zero_group").show();
            } else {
                // $("#prestations_en_cours").removeAttr("readonly", false);
                // $("#prestations_en_cours").css("pointer-events","auto");
                // $("#prestations_en_cours").removeAttr("disabled", false);
                $("#report_group").show();
                $("#report_table").show();
                $("#zero_group").hide();
            }
            // $('#prestations_en_cours').html(html);
            var addedHtml = "";

            var addedHtml2 = "";
            for (i = 0; i < data.length; i++) {
                var idPrestation = data[i].extraValue; // Works with both Change and onLoad
                var codePayment = data[i].code;
                var idPayment = data[i].idPayment;
                var idPaymentConcatRelevantCategoryPart = data[i].value;
                var prestation = data[i].text;
                var details = data[i].details;
                // alert(idPrestation+" "+idPaymentConcatRelevantCategoryPart+" "+prestation);
                //fnPrestationForceChange(idPrestation, codePayment, idPaymentConcatRelevantCategoryPart, prestation,data[i].details);
                var dodeacte = '';
                var defaultUnite = '';
                var defaultValeurs = '';
                if (details) {

                    addedHtml += "<tr class='oooo'>";

                    addedHtml += "<td style='font-weight:500;'>" + prestation + " " + "<br/> <span style='font-weight:400;'> (" + codePayment + ")</span>" + "<input type='hidden' id='prestations' name='prestations' value=\"" + idPrestation + "\" /> </td>";
                    addedHtml += "<td></td>";
                    addedHtml += "<td></td>";
                    addedHtml += "<td></td>";
                    addedHtml += "</tr>";
                    var tabDetails = details.split('|');
                    for (ii = 0; ii < tabDetails.length; ii++) {

                        if (tabDetails[ii]) {
                            var prestas = tabDetails[ii].split('##');
                            /*addedHtml += "<tr>";
                             addedHtml += "<td style='font-weight:500;'>"+prestas[1]+" "+"<br/><input type='hidden' id='prestations_"+idPaymentConcatRelevantCategoryPart+"' name='prestations_"+idPaymentConcatRelevantCategoryPart+"' value=\""+prestation+"\" /><input type='hidden' id='codes_"+idPaymentConcatRelevantCategoryPart+"' name='codes_"+idPaymentConcatRelevantCategoryPart+"' value=\""+codePayment+"\" /><input type='hidden' id='idPaymentConcatRelevantCategoryPart_"+idPaymentConcatRelevantCategoryPart+"' name='idPaymentConcatRelevantCategoryPart_"+idPaymentConcatRelevantCategoryPart+"' value=\""+idPaymentConcatRelevantCategoryPart+"\" /><br/><span style='font-weight:400;'>("+codePayment+"-"+prestas[0]+" )</span></td>";
                             addedHtml += "<td><input class='form-control shadow' size='15' max-length='15' type='text' id='resultats_"+idPaymentConcatRelevantCategoryPart+"' name='resultats_"+idPaymentConcatRelevantCategoryPart+"' value='' placeholder='' /></td>";
                             addedHtml += "<td><input class='form-control shadow' size='5' readonly max-length='5' type='text' id='unite_"+idPaymentConcatRelevantCategoryPart+"' name='unite_"+idPaymentConcatRelevantCategoryPart+"' value=\""+prestas[2]+"\" placeholder='' /></td>";
                             addedHtml += "<td><input class='form-control shadow' size='5' readonly  max-length='5' type='text'  id='valeurs_"+idPaymentConcatRelevantCategoryPart+"' name='valeurs_"+idPaymentConcatRelevantCategoryPart+"' value=\""+prestas[3]+"\" placeholder='' /></td>";
                             addedHtml += "</tr>";
                             */
                            if (prestas[1] === 'Aspect') {
                                addedHtml2 += "<h4>Examen macroscopique :</h4>";
                                addedHtml2 += "<div class='row'>";
                                addedHtml2 += "<div class='col-md-8 lab pad_bot'>";
                                addedHtml2 += '<label for="exampleInputEmail1">' + prestas[1] + '</label>';
                                addedHtml2 += "<select class='form-control m-bot15' id='resultats_" + prestas[0] + "' name='resultats[]' value=\"" + prestas[4] + "\" required=''>";
                                addedHtml2 += '<option value="Non renseigné">Non renseigné</option>';
                                addedHtml2 += '<option value="Liquidiennes">Liquidiennes</option>';
                                addedHtml2 += '<option value="Pâteuses">Pâteuses</option>';
                                addedHtml2 += '<option value="Dures">Dures</option>';
                                addedHtml2 += '<option value="Molles">Molles</option>';
                                addedHtml2 += '</select>';
                                addedHtml2 += '</div>';
                                addedHtml2 += '</div>';
                                addedHtml2 += '</br>';
                                addedHtml2 += "<h4>Examen microscopique :</h4>";

                            }
                            if (prestas[1] === 'Cellules épithéliales') {
                                addedHtml2 += "<div class='row'>";
                                addedHtml2 += "<div class='col-md-6 lab pad_bot'>";
                                addedHtml2 += '<label for="exampleInputEmail1">' + prestas[1] + '</label>';
                                addedHtml2 += "<select class='form-control m-bot15' id='resultats_" + prestas[0] + "' name='resultats[]' value=\"" + prestas[4] + "\" required=''>";
                                addedHtml2 += '<option value="Non renseigné">Non renseigné</option>';
                                addedHtml2 += '<option value="Non demandé">Non demandé</option>';
                                addedHtml2 += '<option value="Absence">Absence</option>';
                                addedHtml2 += '<option value="Présence">Présence</option>';
                                addedHtml2 += '<option value="Polymorphes">Polymorphes</option>';
                                addedHtml2 += '</select>';
                                addedHtml2 += '</div>';

                            }
                            if (prestas[1] === 'Débris alimentaires') {
                                addedHtml2 += "<div class='col-md-6 lab pad_bot'>";
                                addedHtml2 += '<label for="exampleInputEmail1">' + prestas[1] + '</label>';
                                addedHtml2 += "<select class='form-control m-bot15' id='resultats_" + prestas[0] + "' name='resultats[]' value=\"" + prestas[4] + "\" required=''>";
                                addedHtml2 += '<option value="Non renseigné">Non renseigné</option>';
                                addedHtml2 += '<option value="Non demandé">Non demandé</option>';
                                addedHtml2 += '<option value="Absence">Absence</option>';
                                addedHtml2 += '<option value="Présence">Présence</option>';
                                addedHtml2 += '</select>';
                                addedHtml2 += '</div>';
                                addedHtml2 += '</div>';


                            }
                            if (prestas[1] === 'Filaments mycéliens') {
                                addedHtml2 += "<div class='row'>";
                                addedHtml2 += "<div class='col-md-6 lab pad_bot'>";
                                addedHtml2 += '<label for="exampleInputEmail1">' + prestas[1] + '</label>';
                                addedHtml2 += "<select class='form-control m-bot15' id='resultats_" + prestas[0] + "' name='resultats[]' value=\"" + prestas[4] + "\" required=''>";
                                addedHtml2 += '<option value="Non renseigné">Non renseigné</option>';
                                addedHtml2 += '<option value="Non demandé">Non demandé</option>';
                                addedHtml2 += '<option value="Absence">Absence</option>';
                                addedHtml2 += '<option value="Présence">Présence</option>';
                                addedHtml2 += '</select>';
                                addedHtml2 += '</div>';

                            }
                            if (prestas[1] === 'Levures') {
                                addedHtml2 += "<div class='col-md-6 lab pad_bot'>";
                                addedHtml2 += '<label for="exampleInputEmail1">' + prestas[1] + '</label>';
                                addedHtml2 += "<select class='form-control m-bot15' id='resultats_" + prestas[0] + "' name='resultats[]' value=\"" + prestas[4] + "\" required=''>";
                                addedHtml2 += '<option value="Non renseigné">Non renseigné</option>';
                                addedHtml2 += '<option value="Non demandé">Non demandé</option>';
                                addedHtml2 += '<option value="Absence">Absence</option>';
                                addedHtml2 += '<option value="Présence">Présence</option>';
                                addedHtml2 += '<option value="Présence+">Présence+</option>';
                                addedHtml2 += '<option value="Présence++">Présence++</option>';
                                addedHtml2 += '<option value="Présence+++">Présence+++</option>';
                                addedHtml2 += '</select>';
                                addedHtml2 += '</div>';
                                addedHtml2 += '</div>';

                            }
                            if (prestas[1] === 'Larves') {
                                addedHtml2 += "<div class='col-md-6 lab pad_bot'>";
                                addedHtml2 += '<label for="exampleInputEmail1">' + prestas[1] + '</label>';
                                addedHtml2 += "<select class='form-control m-bot15' id='resultats_" + prestas[0] + "' name='resultats[]' value=\"" + prestas[4] + "\" required=''>";
                                addedHtml2 += '<option value="Non renseigné">Non renseigné</option>';
                                addedHtml2 += '<option value="Non demandé">Non demandé</option>';
                                addedHtml2 += '<option value="Absence">Absence</option>';
                                addedHtml2 += '<option value="Présence">Présence</option>';
                                addedHtml2 += '</select>';
                                addedHtml2 += '</div>';
                                addedHtml2 += '</div>';


                            }
                            if (prestas[1] === 'Œufs S. Haematobium') {
                                addedHtml2 += "<div class='row'>";
                                addedHtml2 += "<div class='col-md-6 lab pad_bot'>";
                                addedHtml2 += '<label for="exampleInputEmail1">' + prestas[1] + '</label>';
                                addedHtml2 += "<select class='form-control m-bot15' id='resultats_" + prestas[0] + "' name='resultats[]' value=\"" + prestas[4] + "\" required=''>";
                                addedHtml2 += '<option value="Non renseigné">Non renseigné</option>';
                                addedHtml2 += '<option value="Non demandé">Non demandé</option>';
                                addedHtml2 += '<option value="Absence">Absence</option>';
                                addedHtml2 += '<option value="Présence">Présence</option>';
                                addedHtml2 += '</select>';
                                addedHtml2 += '</div>';

                            }
                            if (prestas[1] === 'Kystes') {
                                addedHtml2 += "<div class='col-md-6 lab pad_bot'>";
                                addedHtml2 += '<label for="exampleInputEmail1">' + prestas[1] + '</label>';
                                addedHtml2 += "<select class='form-control m-bot15' id='resultats_" + prestas[0] + "' name='resultats[]' value=\"" + prestas[4] + "\" required=''>";
                                addedHtml2 += '<option value="Non renseigné">Non renseigné</option>';
                                addedHtml2 += '<option value="Non demandé">Non demandé</option>';
                                addedHtml2 += '<option value="Absence">Absence</option>';
                                addedHtml2 += '<option value="Présence">Présence</option>';
                                addedHtml2 += '<option value="Présence+">Présence+</option>';
                                addedHtml2 += '<option value="Présence++">Présence++</option>';
                                addedHtml2 += '<option value="Présence+++">Présence+++</option>';
                                addedHtml2 += '</select>';
                                addedHtml2 += '</div>';
                                addedHtml2 += '</div>';


                            }
                            if (prestas[1] === 'Parasites') {
                                addedHtml2 += "<div class='col-md-6 lab pad_bot'>";
                                addedHtml2 += '<label for="exampleInputEmail1">' + prestas[1] + '</label>';
                                addedHtml2 += "<select class='form-control m-bot15' id='resultats_" + prestas[0] + "' name='resultats[]' value=\"" + prestas[4] + "\" required=''>";
                                addedHtml2 += '<option value="Non renseigné">Non renseigné</option>';
                                addedHtml2 += '<option value="Non demandé">Non demandé</option>';
                                addedHtml2 += '<option value="Absence">Absence</option>';
                                addedHtml2 += '<option value="Présence">Présence</option>';
                                addedHtml2 += '</select>';
                                addedHtml2 += '</div>';
                                addedHtml2 += '</div>';
                            }


                            if (prestas[1] === 'Flores végétatives') {
                                addedHtml2 += "<div class='row'>";
                                addedHtml2 += "<div class='col-md-6 lab pad_bot'>";
                                addedHtml2 += '<label for="exampleInputEmail1">' + prestas[1] + '</label>';
                                addedHtml2 += "<select class='form-control m-bot15' id='resultats_" + prestas[0] + "' name='resultats[]' value=\"" + prestas[4] + "\" required=''>";
                                addedHtml2 += '<option value="Non renseigné">Non renseigné</option>';
                                addedHtml2 += '<option value="Non demandé">Non demandé</option>';
                                addedHtml2 += '<option value="Absence">Absence</option>';
                                addedHtml2 += '<option value="Présence">Présence</option>';
                                addedHtml2 += '</select>';
                                addedHtml2 += '</div>';

                            }

                            if (prestas[1] === 'Conclusion') {
                                addedHtml2 += '<div class="col-md-8 lab pad_bot">';
                                addedHtml2 += '<label for="exampleInputEmail1">' + prestas[1] + '</label>';
                                addedHtml2 += "<textarea rows='6' cols='100' id='resultats_" + prestas[0] + "' name='resultats[]' value=\"" + prestas[4] + "\">Absence de signes biologiques d'infection du tractus urinaire, Infection urinaire à Escherichia coli (antibiogramme joint), Polymicrobiens</textarea>";
                                addedHtml2 += "</div>";
                            }




                            addedHtml += "<tr>";
                            addedHtml += "<td style='font-weight:500;padding-top:15px'><strong> " + prestas[1] + "</strong><input class='form-control shadow' size='35' readonly type='hidden' id='' name='' value=\"" + prestas[1] + " \" /><input type='hidden' id='' name='idParam[]' value=\"" + prestas[0] + "\" />\n\
                     <input type='hidden' id='' name='nomParam[]' value=\"" + prestas[1] + "\" /><input type='hidden' id='' name='values[]' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /><input type='hidden' id='' name='idPrestation[]' value=\"" + idPrestation + "\" /><input type='hidden' id='' name='codes[]' value=\"" + idPayment + "\" /></td>";
                            addedHtml += "<td style='width:20%'><input class='form-control shadow' type='text' id='resultats_" + prestas[0] + "' name='resultats[]' value=\"" + prestas[4] + "\" /></td>";
                            addedHtml += "<td style='width:25%;padding-top:15px'><input class='form-control shadow'readonly  type='hidden' id='' name='' value=\"" + prestas[2] + "\" />  <strong>" + prestas[2] + "</strong></td>";
                            addedHtml += "<td style='width:25%;padding-top:15px'><input class='form-control shadow' readonly  type='hidden'  id='' name='' value=\"" + prestas[3] + "\" placeholder='' /><strong>" + prestas[3] + "</strong></td>";
                            addedHtml += "</tr>";


                        }
                    }
                }

                /*else {
                                    var addedHtml = "<tr>";
                                    addedHtml += "<td style='font-weight:500;'>" + prestation + " " + "<br/><span style='font-weight:400;'>(" + dodeacte + ": " + codePayment + ")</span>" + "<input type='hidden' id='prestations_" + idPaymentConcatRelevantCategoryPart + "' name='prestations_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + prestation + "\" /><input type='hidden' id='codes_" + idPaymentConcatRelevantCategoryPart + "' name='codes_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + codePayment + "\" /><input type='hidden' id='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' name='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /> </td>";
                                    addedHtml += "<td><input class='form-control shadow' size='15' max-length='15' type='text' id='resultats_" + idPaymentConcatRelevantCategoryPart + "' name='resultats_" + idPaymentConcatRelevantCategoryPart + "' value='' placeholder='' /></td>";
                                    addedHtml += "<td><input class='form-control shadow' size='5' max-length='5' type='text' id='unite_" + idPaymentConcatRelevantCategoryPart + "' name='unite_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + defaultUnite + "\" placeholder='' /></td>";
                                    addedHtml += "<td><input class='form-control shadow' size='5' max-length='5' type='text'  id='valeurs_" + idPaymentConcatRelevantCategoryPart + "' name='valeurs_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + defaultValeurs + "\" placeholder='' /></td>";
                                    addedHtml += "</tr>";

                                    //$("#report_body").html(currentHtml + addedHtml);
                                }*/

                speciality = data[i].nom_specialite;
            }
            $("#report_body2").html(addedHtml2);
            $("#report_body").html(addedHtml);

            //   $("#speciality").html(speciality);


            // if(i == 0) {
            // html = '<option value="Aucun acte en cours disponible" data-extravalue="Aucun acte en cours disponible" selected>Aucun acte en cours disponible</option>';
            // } else {
            // html = '<option value="Veuillez sélectionner un acte" data-extravalue="Veuillez sélectionner un acte" selected>Veuillez sélectionner un acte</option>';
            // }

        }
    });
    // return idDepartementBuff;


    $('#prestations_en_cours').on("change", function() {
        fnPrestationChange();
    });

    function fnPrestationChange() {

        //$("#submit").removeAttr("disabled", false);
        // Remove from List
        var idPrestation = $("option:selected", $(document).find("#prestations_en_cours")).attr("data-extravalue"); // Works with both Change and onLoad
        var idPaymentConcatRelevantCategoryPart = $("option:selected", $(document).find("#prestations_en_cours")).val();
        var prestation = $("option:selected", $(document).find("#prestations_en_cours")).text();

        $("#prestations_en_cours option[value='" + $("option:selected", $(document).find("#prestations_en_cours")).val() + "']").remove();


        var currentHtml = $("#report_body").html();
        var currentHtml2 = $("#report_body2").html();



        var addedHtml = "<tr>";
        addedHtml += "<td>" + prestation + "<input type='hidden' id='prestations_" + idPaymentConcatRelevantCategoryPart + "' name='prestations_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + prestation + "\" /><input type='hidden' id='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' name='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /> </td>";
        addedHtml += "<td><input required class='form-control shadow' size='15' max-length='15' type='text' id='resultats_" + idPaymentConcatRelevantCategoryPart + "' name='resultats_" + idPaymentConcatRelevantCategoryPart + "' value='' placeholder='' /></td>";
        addedHtml += "<td><input required class='form-control shadow' size='5' max-length='5' type='text' id='unite_" + idPaymentConcatRelevantCategoryPart + "' name='unite_" + idPaymentConcatRelevantCategoryPart + "' value='' placeholder='' /></td>";
        addedHtml += "<td><input required class='form-control shadow' size='5' max-length='5' type='text'  id='valeurs_" + idPaymentConcatRelevantCategoryPart + "' name='valeurs_" + idPaymentConcatRelevantCategoryPart + "' value='' placeholder='' /></td>";
        addedHtml += "</tr>";
        $("#report_body").html(currentHtml + addedHtml);
        $("#report_body2").html(currentHtml2 + addedHtml2);
    };

    function fnPrestationForceChange(idPrestation, codePayment, idPaymentConcatRelevantCategoryPart, prestation, details) {

        ///$("#submit").removeAttr("disabled", false);

        $.ajax({
            url: "<?php echo site_url('lab/getDefaultPrestationLabValuesJson'); ?>",
            method: "POST",
            data: {
                idPrestation: idPrestation
            },
            async: false,
            dataType: 'json',
            success: function(data) {
                // alert("success");
                // console.log("JSON.stringify(data): " + JSON.stringify(data));
                // console.log("typeof(JSON.stringify(data)): " + typeof(JSON.stringify(data)));
                // console.log("typeof(data): " + typeof(data));
                // console.log("data.length: " + data.length);
                // var html = "";
                // html = data;
                // alert("html: "+html);
                // var i;
                // alert(data.length);

                // for(i=0; i<data.length; i++){ // Valeur unique
                // alert(data.length);
                var defaultUnite = JSON.stringify(data) !== "null" ? data.default_unite : "";
                var defaultValeurs = JSON.stringify(data) !== "null" ? data.default_valeurs : "";
                var resultatsValeurs = JSON.stringify(data) !== "null" ? data.resultatsValeurs : "";
                // var defaultUnite = "test";
                // var defaultValeurs = "test";
                // }

                // var idPrestation=data[i].extraValue; // Works with both Change and onLoad
                // var codePayment = data[i].code;
                // var idPaymentConcatRelevantCategoryPart = data[i].value;
                // var prestation = data[i].text;
                var dodeacte = '<?php echo lang('code_acte'); ?>';
                var currentHtml = $("#report_body").html();
                var currentHtml2 = $("#report_body2").html();
                if (details) {
                    alert(details);
                    var addedHtml = "<tr>";
                    addedHtml += "<td style='font-weight:500;'>" + prestation + " " + "<br/><span style='font-weight:400;'>(" + dodeacte + ": " + codePayment + ")</span>" + "<input type='hidden' id='prestations_" + idPaymentConcatRelevantCategoryPart + "' name='prestations_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + prestation + "\" /><input type='hidden' id='codes_" + idPaymentConcatRelevantCategoryPart + "' name='codes_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + codePayment + "\" /><input type='hidden' id='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' name='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /> </td>";
                    addedHtml += "<td></td>";
                    addedHtml += "<td></td>";
                    addedHtml += "<td></td>";
                    addedHtml += "</tr>";
                    for (ii = 0; ii < details.length; ii++) {
                        // addedHtml += "<tr>";
                        // addedHtml += "<td style='font-weight:500;'>" + details[ii].prestation + " " + "<br/><span style='font-weight:400;'>(" + dodeacte + ": " + codePayment + ")</span>" + "<input type='hidden' id='prestations_" + idPaymentConcatRelevantCategoryPart + "' name='prestations_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + prestation + "\" /><input type='hidden' id='codes_" + idPaymentConcatRelevantCategoryPart + "' name='codes_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + codePayment + "\" /><input type='hidden' id='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' name='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /> </td>";
                        // addedHtml += "<td><input class='form-control shadow' size='15' max-length='15' type='text' id='resultats_" + idPaymentConcatRelevantCategoryPart + "' name='resultats_" + idPaymentConcatRelevantCategoryPart + "' value='' placeholder='' />test</td>";
                        // addedHtml += "<td><input class='form-control shadow' size='5' max-length='5' type='text' id='unite_" + idPaymentConcatRelevantCategoryPart + "' name='unite_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + defaultUnite + "\" placeholder='' /></td>";
                        // addedHtml += "<td><input class='form-control shadow' size='5' max-length='5' type='text'  id='valeurs_" + idPaymentConcatRelevantCategoryPart + "' name='valeurs_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + defaultValeurs + "\" placeholder='' /></td>";
                        // addedHtml += "</tr>";

                        $("#report_body").html(currentHtml + addedHtml);
                        $("#report_body2").html(currentHtml2 + addedHtml2);
                    }
                } else {
                    var addedHtml = "<tr>";
                    addedHtml += "<td style='font-weight:500;'>" + prestation + " " + "<br/><span style='font-weight:400;'>(" + dodeacte + ": " + codePayment + ")</span>" + "<input type='hidden' id='prestations_" + idPaymentConcatRelevantCategoryPart + "' name='prestations_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + prestation + "\" /><input type='hidden' id='codes_" + idPaymentConcatRelevantCategoryPart + "' name='codes_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + codePayment + "\" /><input type='hidden' id='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' name='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /> </td>";
                    addedHtml += "<td><input class='form-control shadow' size='15' max-length='15' type='text' id='resultats_" + idPaymentConcatRelevantCategoryPart + "' name='resultats_" + idPaymentConcatRelevantCategoryPart + "' value='' placeholder='' /></td>";
                    addedHtml += "<td><input class='form-control shadow' size='5' max-length='5' type='text' id='unite_" + idPaymentConcatRelevantCategoryPart + "' name='unite_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + defaultUnite + "\" placeholder='' /></td>";
                    addedHtml += "<td><input class='form-control shadow' size='5' max-length='5' type='text'  id='valeurs_" + idPaymentConcatRelevantCategoryPart + "' name='valeurs_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + defaultValeurs + "\" placeholder='' /></td>";
                    addedHtml += "</tr>";

                    $("#report_body").html(currentHtml + addedHtml);
                    $("#report_body2").html(currentHtml2 + addedHtml2);
                }


            }
        });
    };

    function fnActeChange(idActe) {
        // alert(idActe);
        // alert("Debut");
        $.ajax({
            url: 'lab/getUniqueTemplate',
            method: 'GET',
            data: {
                idActe: idActe
            },
            dataType: 'json',
        }).success(function(response) {
            // alert(response);
            var data = CKEDITOR.instances.editor.getData();
            if (response.template != null) {
                var data1 = data + response.template;
            } else {
                var data1 = data;
            }
            CKEDITOR.instances['editor'].setData(data1)
        }).error(function(jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            // alert(msg);
        });
        // alert("Fin");
    };
</script>



<script>
    $(document).ready(function() {



    });
</script>