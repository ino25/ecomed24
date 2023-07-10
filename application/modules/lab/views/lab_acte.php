<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="container-fluid invoice-container col-md-12">
            <div style="display:none">
                <?php
                $prestation = '';
                if (isset($_GET['prestation'])) {
                    $prestation = $_GET['prestation'];
                }
                $payment = '';
                if (isset($_GET['payment'])) {
                    $payment = $_GET['payment'];
                }
                $PCR = '';
                $PCR = $this->db->get_where('PCR', array('payment' => $payments->id))->row()->id;
                if (isset($PCR)) {
                    $PCR = $PCR;
                }
                ?>
            </div>
            <!-- Header -->
            <style>
                .titreResultat {
                    background-color: #F5F5F5;
                    color: #0D4D99;
                    font-weight: bold;
                    font-style: italic;
                    font-size: 1.5em;
                    text-align: center;
                    height: 40px;
                }

                .rowStyle {
                    background-color: #0D4D99;
                    color: #ffffff;
                }

                .invoice-container {
                    border: 1px solid #eee !important;
                }
            </style>
            <div class="panel panel-primary" id="invoice">
                <header>
                    <div class="row align-items-center">
                        <div class="col-sm-12 text-center text-sm-left mb-3 mb-sm-0">
                            <img id="logo" src="<?php echo !empty($entete) ? $entete : "uploads/entetePartenaires/default.png"; ?>" style="max-width:100%;max-height:150px" title="Koice" alt="Koice" />
                            <input hidden type="text" id="logo2" value="<?php echo !empty($entete) ? $entete : "uploads/entetePartenaires/default.png"; ?>">
                        </div>
                    </div>
                </header>
                <main>

                    <form role="form" id="editLabForm" class="clearfix" action="lab/addLabNewPayment" method="post" enctype="multipart/form-data">
                      <?php if(!empty($PCR)) { ?>
                        <input type="hidden" class="form-control" name="PCR" id="exampleInputEmail1" value='<?php echo $PCR; ?>' placeholder="">
<?php } else { ?>
    <input type="hidden" class="form-control" name="PCR" id="exampleInputEmail1" value='' placeholder="">
    <?php } ?>
                        <input type="hidden" name="payment_id" value="<?php echo $payments->id; ?>">
                        <div class="form-group col-md-4">
                            <label> <?php echo lang('first_name'); ?></label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php echo $patient->name; ?>' placeholder="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"> <?php echo lang('last_name'); ?></label>
                            <input type="text" class="form-control" name="last_name" id="exampleInputEmail1" value='<?php echo $patient->last_name; ?>' placeholder="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"> <?php echo lang('patient_ids'); ?></label>
                            <input type="text" class="form-control" name="patient_id" id="exampleInputEmail1" value='<?php echo $patient->id; ?>' placeholder="" readonly="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"> <?php echo lang('date_of_birth'); ?></label>
                            <input type="text" class="form-control" name="birthdate" id="exampleInputEmail1" value='<?php echo $patient->birthdate; ?>' placeholder="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1"> <?php echo lang('age'); ?></label>
                            <input type="text" class="form-control" name="age" id="exampleInputEmail1" value='<?php echo $patient->age; ?>' placeholder="">
                            <input type="hidden" class="form-control" name="phone" id="exampleInputEmail1" value='<?php echo $patient->phone; ?>' placeholder="">
                            <input type="hidden" class="form-control" name="email" id="exampleInputEmail1" value='<?php echo $patient->email; ?>' placeholder="">
                            <input type="hidden" class="form-control" name="passport" id="exampleInputEmail1" value='<?php echo $patient->passport; ?>' placeholder="">
                            <input type="hidden" class="form-control" name="id_presta" id="exampleInputEmail1" value='<?php echo $prestation; ?>' placeholder="">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1"> <?php echo lang('gender'); ?></label>
                            <input type="text" class="form-control" name="sex" id="exampleInputEmail1" value='<?php echo $patient->sex; ?>' placeholder="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"> <?php echo lang('address'); ?></label>
                            <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='<?php echo $patient->address; ?>' placeholder="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Prescripteur Pr/Dr/Mme/Mr/</label>
                            <input type="text" class="form-control" name="doctor" id="exampleInputEmail1" value='<?php if (!empty($payments->doctor_name)) {
                                                                                                                        echo $payments->doctor_name;
                                                                                                                    } else echo 'Non renseigné '  ?>' placeholder="" readonly="">
                            <input type="hidden" name="doctor" value="<?php echo $payments->doctor_name ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Date prescription</label>
                            <input type="text" class="form-control" name="dateprescription" id="exampleInputEmail1" value='<?php echo $payments->date_string; ?>' placeholder="" readonly="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"> <?php echo lang('report_id'); ?></label>
                            <input type="text" class="form-control" name="code_identifiant" id="exampleInputEmail1" value='<?php
                                                                                                                            if (!empty($resulLab->numero_identifiant)) {
                                                                                                                                echo $resulLab->numero_identifiant;
                                                                                                                            } else {
                                                                                                                                echo $payments->code . '-LAB-' . $prestation;
                                                                                                                            }
                                                                                                                            ?>' placeholder="" readonly="">
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Numéro de Régistre</label>
                            <input type="text" class="form-control" name="numeroRegistre" id="exampleInputEmail1" value='<?php
                                                                                                                            if (!empty($resulLab->numeroRegistre)) {
                                                                                                                                echo $resulLab->numeroRegistre;
                                                                                                                            } else {
                                                                                                                                echo $payments->code . '-LAB-' . $prestation;
                                                                                                                            }
                                                                                                                            ?>' placeholder="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"><?php echo lang('sampling_date_time'); ?></label>
                            <div class="input-group" id="id_0">
                                <input type="text" value="<?php
                                                            if (!empty($payments->date_prelevement)) {
                                                                echo $payments->date_prelevement;
                                                            }
                                                            ?>" class="form-control <?php if (empty($payments->date_prelevement)) { ?> datetimepicker_ip <?php } ?>" name="date_prelevement" required="" autocomplete="off">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Renseignement Clinique</label>
                            <textarea rows="3" cols="35" name="renseignementClinique"><?php echo $payments->renseignementClinique; ?></textarea>
                        </div>

                        <?php if (!empty($payments->purpose)) { ?>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"> <?php echo lang('passport_number'); ?></label>
                                <input type="text" class="form-control" name="" id="exampleInputEmail1" value='<?php echo $patient->passport; ?>' placeholder="">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1"> <?php echo lang('purpose_of_test'); ?></label>
                                <input type="text" class="form-control" name="purpose" id="exampleInputEmail1" value='<?php echo $this->db->get_where('purpose', array('id' => $payments->purpose))->row()->name; ?>' placeholder="">
                            </div>
                        <?php } ?>

                        <div class="row">
                            <div class="panel-default">
                            </div>
                        </div>

                        <div class=" no-print">
                            <span class="hr"></span>
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #F5F5F5;
                    color: #0D4D99;
                    font-weight: bold;
                    font-style: italic;
                    font-size: 1.5em;
                    text-align: center;">R&Eacute;SULTATS DES ANALYSES</div>
                            </div>




                            <!-- <div class="col-md-8 panel"> 
                                </div> -->

                        </div>
                        <div class="col-md-12 lab pad_bot" id="zero_group">
                        </div>
                        <div class="col-md-12 lab pad_bot" id="">
                            <h3 style="text-align: center;"><span id="speciality"></span> </h3>
                        </div>
                        <div class="col-md-12 lab pad_bot" id="">
                            <h4 style="text-align: center;"><span id="prestation"></span> </h4>
                        </div>
                        <div class="col-md-12 lab pad_bot" id="report_group">
                            <table class="table table-hover progress-table text-center" cellpadding="1" cellspacing="1" style="width:100%" id='report_table' style="display:none">
                                <!--<caption>R&Eacute;SULTATS DES ANALYSES</caption>-->
                                <thead style="margin-top:5px;">
                                    <tr>
                                        <th style="text-transform:none !important;" scope="col">Analyse(s) Demand&eacute;es</th>
                                        <th style="text-transform:none !important;" scope="col">R&eacute;sultats</th>
                                        <th style="text-transform:none !important;" scope="col">Unit&eacute;</th>
                                        <th style="text-transform:none !important;" scope="col">Valeurs Usuelles</th>
                                        <th style="text-transform:none !important;" scope="col">Min</th>
                                        <th style="text-transform:none !important;" scope="col">Max</th>
                                    </tr>
                                </thead>
                                <tbody id='report_body'>
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
                        <div class="col-md-12" style="padding-top:35px;">
                            <a href="finance/paymentLabo" class="btn btn-info btn-secondary pull-left"><?php echo lang('retour'); ?></a>
                            <button type="submit" name="submit" id="submit" class="btn btn-info pull-right"><?php echo lang('add'); ?></button>
                        </div>


            </div>
        </div>
        </div>



    </section>
    <section class="col-md-3" style="display: none;">
        <header class="panel-heading no-print" style="color:#fff"> effectuer Résultats d'Analyse
        </header>
        <div class="col-md-12 no-print" style="margin-top: 45px;">



        </div>

        </form>

        </main>



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

            hr {
                border-bottom: 1.5px solid black !important;
            }

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
    function valueStrong(id) {

    }

    function updateDataRequired(id, min, max) {
        var values = document.getElementById('resultats_' + id);
        var values_p = document.getElementById('resultats_' + id).value;
        //   onkeyup='updateDataRequired(\"" + prestas[0] + "\", \"" + prestas[5] + "\", \"" + prestas[6] + "\")'
        values_p = parseFloat(values_p);
        var ref_low = parseFloat(min);
        var ref_high = parseFloat(max);
        if (values.value.length > 0) {
            if (values_p < ref_low) {
                $('#ref_low' + id).css({
                    'color': 'red',
                    "fontSize": "20px",
                    'background-color': 'yellow'
                });
                $('#ref_high' + id).css({
                    'color': 'black',
                    "fontSize": "12px",
                    'background-color': 'transparent'
                });
            } else if (values_p > ref_high) {
                $('#ref_high' + id).css({
                    'color': 'red',
                    "fontSize": "20px",
                    'background-color': 'yellow'
                });
                $('#ref_low' + id).css({
                    'color': 'black',
                    "fontSize": "12px",
                    'background-color': 'transparent'
                });
            } else if (values_p >= ref_low && values_p <= ref_high) {
                $('#ref_low' + id).css({
                    'color': 'black',
                    "fontSize": "12px",
                    'background-color': 'transparent'
                });
                $('#ref_high' + id).css({
                    'color': 'black',
                    "fontSize": "12px",
                    'background-color': 'transparent'
                });
            }
        }

        // var values_p = document.getElementById(id + 'values_p');
        // var ref_low_p = document.getElementById(id + 'ref_low_p');
        // var ref_high_p = document.getElementById(id + 'ref_high_p');

        // if (values_p.value.length > 0) {
        // 	ref_low_p.required = false;
        // 	ref_high_p.required = false;
        // } else {
        // 	ref_low_p.required = true;
        // 	ref_high_p.required = true;
        // }


    }
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

                    // addedHtml += "<tr class='oooo'>";
                    // addedHtml += "<td></td>";
                    // addedHtml += "<td></td>";
                    // addedHtml += "<div>" + prestation + " " + "<span> (" + codePayment + ")</span>" + "<input type='hidden' id='prestations' name='prestations' value=\"" + idPrestation + "\" /> </div>";
                    // addedHtml += "<td></td>";
                    // addedHtml += "<td>";
                    // addedHtml += "</td>";
                    // addedHtml += "<td></td>";
                    // addedHtml += "</tr>";
                    var tabDetails = details.split('|');
                    for (ii = 0; ii < tabDetails.length; ii++) {

                        if (tabDetails[ii]) {

                            var prestas = tabDetails[ii].split('##');
                            var set_of_code = prestas[8].split(',');

                            if (prestas[7] === 'setofcode') {
                                if (prestas[8]) {
                                    addedHtml += "<tr>";
                                    addedHtml += "<td style='font-weight:500;padding-top:15px'><strong>" + prestas[1] + "</strong><input class='form-control shadow' size='35' readonly type='hidden' id='' name='' value=\"" + prestas[1] + " \" /><input type='hidden' id='' name='idParam[]' value=\"" + prestas[0] + "\" />\n\
                                        <input type='hidden' id='' name='nomParam[]' value=\"" + prestas[1] + "\" /><input type='hidden' id='' name='values[]' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /><input type='hidden' id='' name='idPrestation[]' value=\"" + idPrestation + "\" /><input type='hidden' id='' name='codes[]' value=\"" + idPayment + "\"/></td>";
                                    addedHtml += "<td style='width:40%'><select class='form-control m-bot15' id='resultats_" + prestas[0] + "' name='resultats[]' value=\"" + prestas[4] + "\" required=''>";
                                    addedHtml += '<option value="Non renseigné">Non renseigné</option>';
                                    for (var j = 0; j < set_of_code.length; j++) {
                                        addedHtml += '<option value="' + set_of_code[j] + '">' + set_of_code[j] + '</option>';
                                    }
                                    addedHtml += '</select></td>';
                                    addedHtml += "<td style='width:25%;padding-top:15px'><input class='form-control shadow'readonly  type='hidden' id='' name='' value=\"" + prestas[2] + "\" />  <strong>" + prestas[2] + "</strong></td>";
                                    addedHtml += "<td style='width:25%;padding-top:15px'><input class='form-control shadow' readonly  type='hidden'  id='' name='' value=\"" + prestas[3] + "\" placeholder='' /><strong>" + prestas[3] + "</strong></td>";
                                    addedHtml += "<td class='ref_low_td' style='width:10%;padding-top:15px'><input class='form-control shadow ref_low' readonly  type='hidden'  id='' name='' value=\"" + prestas[5] + "\" placeholder='' /><strong id='ref_low" + prestas[0] + "'>" + prestas[5] + "</strong></td>";
                                    addedHtml += "<td class='ref_high_td' style='width:10%;padding-top:15px'><input class='form-control shadow ref_high' readonly  type='hidden'  id='' name='' value=\"" + prestas[6] + "\" placeholder='' /><strong id='ref_high" + prestas[0] + "'>" + prestas[6] + "</strong></td>";
                                    addedHtml += "</tr>";
                                }

                            } else if (prestas[7] === 'textcode') {
                                addedHtml += "<tr>";
                                addedHtml += "<td align='right' valign='top'><strong align='right' valign='top'>" + prestas[1] + "</strong></td><td style='font-weight:500;padding-top:15px'><input class='form-control shadow' size='35' readonly type='hidden' id='' name='' value=\"" + prestas[1] + " \" /><input type='hidden' id='' name='idParam[]' value=\"" + prestas[0] + "\" />\n\
                                        <input type='hidden' id='' name='nomParam[]' value=\"" + prestas[1] + "\" /><input type='hidden' id='' name='values[]' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /><input type='hidden' id='' name='idPrestation[]' value=\"" + idPrestation + "\" /><input type='hidden' id='' name='codes[]' value=\"" + idPayment + "\"/>\n\
                                         <textarea id='resultats_" + prestas[0] + "' name='resultats[]' required='' name='resultats[]' rows='5' cols='62'>" + prestas[8] + "\</textarea></td>";
                                addedHtml += "<td>\n\
                                    ";
                                addedHtml += "<td><input class='form-control shadow'readonly  type='hidden' id='' name='' value=\"" + prestas[2] + "\" /></td>";
                                addedHtml += "<td><input class='form-control shadow' readonly  type='hidden'  id='' name='' value=\"" + prestas[3] + "\" placeholder='' /></td>";
                                addedHtml += "<td><input class='form-control shadow ref_low' readonly  type='hidden'  id='' name='' value=\"" + prestas[5] + "\" placeholder='' /></td>";
                                addedHtml += "<td><input class='form-control shadow ref_high' readonly  type='hidden'  id='' name='' value=\"" + prestas[6] + "\" placeholder='' /></td>";
                                addedHtml += "</tr>";
                            } else if (prestas[7] === 'section') {
                                addedHtml += "<tr>";
                                addedHtml += "<td align='right' valign='top'><strong align='right' valign='top'>" + prestas[1] + "</strong></td><td style='font-weight:500;padding-top:15px'><input class='form-control shadow' size='35' readonly type='hidden' id='' name='' value=\"" + prestas[1] + " \" /><input type='hidden' id='' name='idParam[]' value=\"" + prestas[0] + "\" />\n\
                                        <input type='hidden' id='' name='nomParam[]' value=\"" + prestas[1] + "\" /><input type='hidden' id='' name='values[]' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /><input type='hidden' id='' name='idPrestation[]' value=\"" + idPrestation + "\" /><input type='hidden' id='' name='codes[]' value=\"" + idPayment + "\"/>\n\
                                         <textarea hidden id='resultats_" + prestas[0] + "' name='resultats[]' name='resultats[]' rows='5' cols='62'>non renseigner</textarea></td>";
                                addedHtml += "<td>\n\
                                    ";
                                addedHtml += "<td><input class='form-control shadow'readonly  type='hidden' id='' name='' value=\"" + prestas[2] + "\" /></td>";
                                addedHtml += "<td><input class='form-control shadow' readonly  type='hidden'  id='' name='' value=\"" + prestas[3] + "\" placeholder='' /></td>";
                                addedHtml += "<td><input class='form-control shadow ref_low' readonly  type='hidden'  id='' name='' value=\"" + prestas[5] + "\" placeholder='' /></td>";
                                addedHtml += "<td><input class='form-control shadow ref_high' readonly  type='hidden'  id='' name='' value=\"" + prestas[6] + "\" placeholder='' /></td>";
                                addedHtml += "</tr>";
                            } else if (prestas[7] === 'sous_section') {
                                addedHtml += "<tr>";
                                addedHtml += "<td align='right' valign='top'><strong align='right' valign='top'>" + prestas[1] + "</strong></td><td style='font-weight:500;padding-top:15px'><input class='form-control shadow' size='35' readonly type='hidden' id='' name='' value=\"" + prestas[1] + " \" /><input type='hidden' id='' name='idParam[]' value=\"" + prestas[0] + "\" />\n\
                                        <input type='hidden' id='' name='nomParam[]' value=\"" + prestas[1] + "\" /><input type='hidden' id='' name='values[]' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /><input type='hidden' id='' name='idPrestation[]' value=\"" + idPrestation + "\" /><input type='hidden' id='' name='codes[]' value=\"" + idPayment + "\"/>\n\
                                         <textarea hidden id='resultats_" + prestas[0] + "' name='resultats[]' name='resultats[]' rows='5' cols='62'>non renseigner</textarea></td>";
                                addedHtml += "<td>\n\
                                    ";
                                addedHtml += "<td><input class='form-control shadow'readonly  type='hidden' id='' name='' value=\"" + prestas[2] + "\" /></td>";
                                addedHtml += "<td><input class='form-control shadow' readonly  type='hidden'  id='' name='' value=\"" + prestas[3] + "\" placeholder='' /></td>";
                                addedHtml += "<td><input class='form-control shadow ref_low' readonly  type='hidden'  id='' name='' value=\"" + prestas[5] + "\" placeholder='' /></td>";
                                addedHtml += "<td><input class='form-control shadow ref_high' readonly  type='hidden'  id='' name='' value=\"" + prestas[6] + "\" placeholder='' /></td>";
                                addedHtml += "</tr>";
                            } else {
                                addedHtml += "<tr>";
                                addedHtml += "<td style='font-weight:500;padding-top:15px'><strong>" + prestas[1] + "</strong><input class='form-control shadow' size='35' readonly type='hidden' id='' name='' value=\"" + prestas[1] + " \" /><input type='hidden' id='' name='idParam[]' value=\"" + prestas[0] + "\" />\n\
                                        <input type='hidden' id='' name='nomParam[]' value=\"" + prestas[1] + "\" /><input type='hidden' id='' name='values[]' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /><input type='hidden' id='' name='idPrestation[]' value=\"" + idPrestation + "\" /><input type='hidden' id='' name='codes[]' value=\"" + idPayment + "\"/></td>";
                                addedHtml += "<td style='width:40%'><input onkeyup='updateDataRequired(\"" + prestas[0] + "\", \"" + prestas[5] + "\", \"" + prestas[6] + "\")' class='form-control shadow' type='text' id='resultats_" + prestas[0] + "' name='resultats[]' value=\"" + prestas[4] + "\" required='' /></td>";
                                addedHtml += "<td style='width:25%;padding-top:15px'><input class='form-control shadow'readonly  type='hidden' id='' name='' value=\"" + prestas[2] + "\" />  <strong>" + prestas[2] + "</strong></td>";
                                addedHtml += "<td style='width:25%;padding-top:15px'><input class='form-control shadow' readonly  type='hidden'  id='' name='' value=\"" + prestas[3] + "\" placeholder='' /><strong>" + prestas[3] + "</strong></td>";
                                addedHtml += "<td class='ref_low_td' style='width:10%;padding-top:15px'><input class='form-control shadow ref_low' readonly  type='hidden'  id='' name='' value=\"" + prestas[5] + "\" placeholder='' /><strong id='ref_low" + prestas[0] + "'>" + prestas[5] + "</strong></td>";
                                addedHtml += "<td class='ref_high_td' style='width:10%;padding-top:15px'><input class='form-control shadow ref_high' readonly  type='hidden'  id='' name='' value=\"" + prestas[6] + "\" placeholder='' /><strong id='ref_high" + prestas[0] + "'>" + prestas[6] + "</strong></td>";
                                addedHtml += "</tr>";
                            }


                        }
                    }

                    $(document).ready(function() {
                        $(document).on('input', '.resultats', function() {
                            let ref_low = parseFloat($(this).closest('tr').find(".ref_low").val());
                            let ref_high = parseFloat($(this).closest('tr').find(".ref_high").val());
                            let enteredValue = parseFloat($(this).closest('tr').find(".resultats").val());
                            if (enteredValue < ref_low) {
                                $(this).closest('tr').find(".ref_low_td").css({
                                    'color': 'red',
                                    "fontSize": "20px",
                                    "fontWeight": "bold"
                                });
                                $(this).closest('tr').find(".ref_high_td").css({
                                    'color': 'black',
                                    "fontSize": "12px",
                                    'background-color': 'transparent'
                                });
                            }
                            if (enteredValue > ref_high) {
                                $(this).closest('tr').find(".ref_high_td").css({
                                    'color': 'red',
                                    "fontSize": "20px",
                                    "fontWeight": "bold"
                                });
                                $(this).closest('tr').find(".ref_low_td").css({
                                    'color': 'black',
                                    "fontSize": "12px",
                                    'background-color': 'transparent'
                                });
                            }
                            if (enteredValue >= ref_low && enteredValue <= ref_high) {
                                $(this).closest('tr').find(".ref_high_td").css({
                                    'color': 'black',
                                    "fontSize": "12px",
                                    'background-color': 'transparent'
                                });
                                $(this).closest('tr').find(".ref_low_td").css({
                                    'color': 'black',
                                    "fontSize": "12px",
                                    'background-color': 'transparent'
                                });

                            }
                            if (enteredValue.toString() == 'NaN') {
                                $(this).closest('tr').find(".ref_high_td").css({
                                    'color': 'black',
                                    "fontSize": "12px",
                                    'background-color': 'transparent'
                                });
                                $(this).closest('tr').find(".ref_low_td").css({
                                    'color': 'black',
                                    "fontSize": "12px",
                                    'background-color': 'transparent'
                                });
                            }
                        });
                    });



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
                prestation = prestation;
            }

            $("#report_body").html(addedHtml);
            $("#speciality").html(speciality);
            $("#prestation").html(prestation + ' (' + codePayment + ')');


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

        // alert(idPrestation);
        var currentHtml = $("#report_body").html();
        var addedHtml = "<tr>";
        addedHtml += "<td>" + prestation + "<input type='hidden' id='prestations_" + idPaymentConcatRelevantCategoryPart + "' name='prestations_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + prestation + "\" /><input type='hidden' id='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' name='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /> </td>";
        addedHtml += "<td><input required class='form-control shadow' size='15' max-length='15' type='text' id='resultats_" + idPaymentConcatRelevantCategoryPart + "' name='resultats_" + idPaymentConcatRelevantCategoryPart + "' value='' placeholder='' /></td>";
        addedHtml += "<td><input required class='form-control shadow' size='5' max-length='5' type='text' id='unite_" + idPaymentConcatRelevantCategoryPart + "' name='unite_" + idPaymentConcatRelevantCategoryPart + "' value='' placeholder='' /></td>";
        addedHtml += "<td><input required class='form-control shadow' size='5' max-length='5' type='text'  id='valeurs_" + idPaymentConcatRelevantCategoryPart + "' name='valeurs_" + idPaymentConcatRelevantCategoryPart + "' value='' placeholder='' /></td>";
        addedHtml += "</tr>";
        $("#report_body").html(currentHtml + addedHtml);
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
                if (details) {
                    alert(details);
                    var addedHtml = "<tr>";
                    addedHtml += "<td style='font-weight:1500;'>" + prestation + " " + "<br/><span style='font-weight:1500;'>(" + dodeacte + ": " + codePayment + ")</span>" + "<input type='hidden' id='prestations_" + idPaymentConcatRelevantCategoryPart + "' name='prestations_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + prestation + "\" /><input type='hidden' id='codes_" + idPaymentConcatRelevantCategoryPart + "' name='codes_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + codePayment + "\" /><input type='hidden' id='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' name='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /> </td>";
                    // addedHtml += "<td></td>";
                    // addedHtml += "<td></td>";
                    // addedHtml += "<td></td>";
                    addedHtml += "</tr>";
                    for (ii = 0; ii < details.length; ii++) {
                        addedHtml += "<tr>";
                        addedHtml += "<td style='font-weight:500;'>" + details[ii].prestation + " " + "<br/><span style='font-weight:400;'>(" + dodeacte + ": " + codePayment + ")</span>" + "<input type='hidden' id='prestations_" + idPaymentConcatRelevantCategoryPart + "' name='prestations_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + prestation + "\" /><input type='hidden' id='codes_" + idPaymentConcatRelevantCategoryPart + "' name='codes_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + codePayment + "\" /><input type='hidden' id='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' name='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /> </td>";
                        addedHtml += "<td><input class='form-control shadow' size='15' max-length='15' type='text' id='resultats_" + idPaymentConcatRelevantCategoryPart + "' name='resultats_" + idPaymentConcatRelevantCategoryPart + "' value='' placeholder='' /></td>";
                        addedHtml += "<td><input class='form-control shadow' size='5' max-length='5' type='text' id='unite_" + idPaymentConcatRelevantCategoryPart + "' name='unite_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + defaultUnite + "\" placeholder='' /></td>";
                        addedHtml += "<td><input class='form-control shadow' size='5' max-length='5' type='text'  id='valeurs_" + idPaymentConcatRelevantCategoryPart + "' name='valeurs_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + defaultValeurs + "\" placeholder='' /></td>";
                        addedHtml += "</tr>";

                        $("#report_body").html(currentHtml + addedHtml);
                    }
                } else {
                    var addedHtml = "<tr>";
                    addedHtml += "<td style='font-weight:500;'>" + prestation + " " + "<br/><span style='font-weight:400;'>(" + dodeacte + ": " + codePayment + ")</span>" + "<input type='hidden' id='prestations_" + idPaymentConcatRelevantCategoryPart + "' name='prestations_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + prestation + "\" /><input type='hidden' id='codes_" + idPaymentConcatRelevantCategoryPart + "' name='codes_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + codePayment + "\" /><input type='hidden' id='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' name='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /> </td>";
                    addedHtml += "<td><input class='form-control shadow' size='15' max-length='15' type='text' id='resultats_" + idPaymentConcatRelevantCategoryPart + "' name='resultats_" + idPaymentConcatRelevantCategoryPart + "' value='' placeholder='' /></td>";
                    addedHtml += "<td><input class='form-control shadow' size='5' max-length='5' type='text' id='unite_" + idPaymentConcatRelevantCategoryPart + "' name='unite_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + defaultUnite + "\" placeholder='' /></td>";
                    addedHtml += "<td><input class='form-control shadow' size='5' max-length='5' type='text'  id='valeurs_" + idPaymentConcatRelevantCategoryPart + "' name='valeurs_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + defaultValeurs + "\" placeholder='' /></td>";
                    addedHtml += "</tr>";

                    $("#report_body").html(currentHtml + addedHtml);
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