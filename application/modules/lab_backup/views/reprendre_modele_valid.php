<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <form role="form" id="editLabForm" class="clearfix" action="finance/editStatutPaiementByJasonReprendre" method="post" enctype="multipart/form-data">

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
                    $mode = '';
                    if (isset($_GET['mode'])) {
                        $mode = $_GET['mode'];
                    }
                    $patient_id = '';
                    if (isset($_GET['id'])) {
                        $patient_id = $_GET['id'];
                    }
                    $typ = '';
                    if (isset($_GET['typ'])) {
                        $typ = $_GET['typ'];
                    }

                    echo lang('valid_lab_report');
                    ?>
                </header>
                <div class="no-print">
                    <div class="adv-table editable-table ">
                        <div class="clearfix">
                            <style>
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


                            <div class="col-md-12">
                                <div class="col-md-4 lab pad_bot">
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

                                </div>
                                <div class="col-md-3" style="padding-top:35px;">
                                        <a href="finance/paymentLabo" class="btn btn-info btn-secondary pull-left"><?php echo lang('retour'); ?></a>
                                        <button type="submit" name="submit" id="submit" class="btn btn-info pull-right"><?php echo lang('edit'); ?></button>
                                </div>


                            </div>
                            <div class="col-md-12 lab pad_bot" id="zero_group">
                            </div>
                            <div class="col-md-12 lab pad_bot" id="report_group">
                                <!-- <label for="exampleInputEmail1">R&eacute;sultats des analyses</label> -->
                                <table class="table table-hover progress-table text-center" cellpadding="1" cellspacing="1" style="width:100%" id='report_table' style="display:none">
                                    <!--<caption>R&Eacute;SULTATS DES ANALYSES</caption>-->
                                    <thead style="margin-top:5px;">
                                        <!-- <tr>
                                            <th style="text-transform:none !important;" scope="col">Analyse(s) Demand&eacute;es</th>
                                            <th style="text-transform:none !important;" scope="col">R&eacute;sultats</th>
                                            <th style="text-transform:none !important;" scope="col">Unit&eacute;</th>
                                            <th style="text-transform:none !important;" scope="col">Valeurs Usuelles</th>
                                        </tr> -->
                                    </thead>
                                    <tbody id='report_body'>
                                    </tbody>
                                </table>
                                <div><h4><?php echo $prestations->prestation ?></h4></div>
                                <div class="col-md-11"> 
                                    <textarea class="ckeditor form-control" name="resultats[]" value="" rows="10"><?php echo $lab->resultats ?>
                                    </textarea>
                                </div>

                                <p>&nbsp;</p>

                            </div>
                            <?php if ($prestation == 'all') { ?>
                                <input type="hidden" name="redirect" value="finance/payment">
                            <?php } else { ?>
                                <input type="hidden" name="redirect" value="finance/paymentLabo">
                            <?php } ?>


                            <input type="hidden" name="prestation" value="<?php echo $prestation; ?>">
                            <input type="hidden" name="payment" value="<?php echo $payment; ?>">

                            <input type="hidden" name="patient" value="<?php echo $patient_id; ?>">


                        </div>
                    </div>
                </div>



            </section>
            <section class="col-md-4">
                <header class="panel-heading no-print" style="color:#fff">
                    Valider Résultats d'Analyse </header>
                <div class="col-md-12 no-print" style="margin-top: 45px;">
                    <div class="panel_button">

                        <!-- <div class="text-center col-md-12 row">
                        <a href="finance/previousLabvalid?id=<?php echo $lab->id; ?>&patient=<?php echo $patient_id; ?>&payment=<?php echo $payment; ?>&prestation=<?php echo $prestation; ?>&type=2" class="btn btn-info btn-lg green previousone1   <?php if ($typ == 'deb') {
                                                                                                                                                                                                                                                            echo 'disabled';
                                                                                                                                                                                                                                                        } ?> "><i class="glyphicon glyphicon-chevron-left"></i> </a>
                        <a href="finance/nextLabvalid?id=<?php echo $lab->id; ?>&patient=<?php echo $patient_id; ?>&payment=<?php echo $payment; ?>&prestation=<?php echo $prestation; ?>&type=2" class="btn btn-info btn-lg green nextone1   <?php if ($typ == 'fin') {
                                                                                                                                                                                                                                                    echo 'disabled';
                                                                                                                                                                                                                                                } ?> "><i class="glyphicon glyphicon-chevron-right"></i> </a>

                    </div>-->

                    </div>

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

            hr {
                border-bottom: 2px solid green !important;
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

<div class="modal fade" id="sttChangeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content" id="sttChangeModalHtml">

        </div>
    </div>
</div>

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

        url: 'finance/getValidPrestationsByPatientIdActe',
        method: "POST",
        data: {
            id: <?php echo $patient->id; ?>,
            prestation: '<?php echo $prestation; ?>',
            payment: '<?php echo $payment; ?>'
        },
        async: false,
        dataType: 'json',
        success: function(data) {
            var html = "";
            // html = data;
            // alert("html: "+html);
            var i;
            // alert(data.length);

            //$("#submit").attr("disabled", true);
            $("#report_body").html("");
            $("#zero_group").html("");
            if (data.length == 0) {

                $("#report_group").hide();
                $("#report_table").hide();
                $("#zero_group").html("<code style='font-weight:bold;'>Pas de prestation effectue pour ce patient</code>");
                $("#zero_group").show();
            } else {
                ;
                $("#report_group").show();
                $("#report_table").show();
                $("#zero_group").hide();
            }
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

                    addedHtml += "<input type='hidden' id='prestations_" + idPaymentConcatRelevantCategoryPart + "' name='prestations[]' value=\"" + codePayment + "\" /> </td>";
                    // addedHtml += "<td></td>";
                    // addedHtml += "<td></td>";
                    // addedHtml += "<td></td>";
                    // addedHtml += "</tr>";
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
                            // addedHtml += "<tr>";
                            addedHtml += "<div><input class='form-control shadow' size='35' readonly type='hidden' id='' name='' value=\"" + prestas[1] + " \" /><input type='hidden' id='' name='idParam[]' value=\"" + prestas[0] + "\" />\n\
                     <input type='hidden' id='' name='nomParam[]' value=\"" + prestas[1] + "\" /><input type='hidden' id='' name='values[]' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /><input type='hidden' id='' name='idPrestation[]' value=\"" + idPrestation + "\" /><input type='hidden' id='' name='codes[]' value=\"" + idPayment + "\" /></div>";
                          //  addedHtml += "<td style='width:20%'><input class='form-control shadow' type='text' id='resultats_" + prestas[0] + "' name='resultats[]' value=\"" + prestas[4] + "\" required='' /></td>";
                            addedHtml += "<div><input class='form-control shadow' size='5' readonly max-length='5' type='hidden' id='' name='' value=\"" + prestas[2] + "\" /></div>";
                            addedHtml += "<div><input class='form-control shadow' size='5' readonly  max-length='5' type='hidden'  id='' name='' value=\"" + prestas[3] + "\"/></div>";
                            // addedHtml += "</tr>";


                        }
                    }
                } else {
                    addedHtml += "<tr>";
                    addedHtml += "<td style='font-weight:500;'>" + prestation + " " + "<br/><span style='font-weight:400;'>(" + dodeacte + ": " + codePayment + ")</span>" + "<input type='hidden' id='prestations_" + idPaymentConcatRelevantCategoryPart + "' name='prestations_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + prestation + "\" /><input type='hidden' id='codes_" + idPaymentConcatRelevantCategoryPart + "' name='codes_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + codePayment + "\" /><input type='hidden' id='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' name='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /> </td>";
                    addedHtml += "<td><input class='form-control shadow' size='15' max-length='15' type='text' id='resultats_" + idPaymentConcatRelevantCategoryPart + "' name='resultats_" + idPaymentConcatRelevantCategoryPart + "' value='' placeholder='' /></td>";
                    addedHtml += "<td><input class='form-control shadow' size='5' max-length='5' type='text' id='unite_" + idPaymentConcatRelevantCategoryPart + "' name='unite_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + defaultUnite + "\" placeholder='' /></td>";
                    addedHtml += "<td><input class='form-control shadow' size='5' max-length='5' type='text'  id='valeurs_" + idPaymentConcatRelevantCategoryPart + "' name='valeurs_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + defaultValeurs + "\" placeholder='' /></td>";
                    addedHtml += "</tr>";

                    $("#report_body").html(currentHtml + addedHtml);
                }


            }

            $("#report_body").html(addedHtml);
        }
    });



    function fnPrestationForceChange(idPrestation, codePayment, idPaymentConcatRelevantCategoryPart, prestation) {

        //$("#submit").removeAttr("disabled", false);

        var defaultUnite = JSON.stringify(data) !== "null" ? data.default_unite : "";
        var defaultValeurs = JSON.stringify(data) !== "null" ? data.default_valeurs : "";

        var dodeacte = '<?php echo lang('code_acte'); ?>';
        var currentHtml = $("#report_body").html();
        var addedHtml = "<tr>";
        addedHtml += "<td style='font-weight:500;'>" + prestation + " " + "<br/><span style='font-weight:400;'>(" + dodeacte + ": " + codePayment + ")</span>" + "<input type='hidden' id='prestations_" + idPaymentConcatRelevantCategoryPart + "' name='prestations_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + prestation + "\" /><input type='hidden' id='codes_" + idPaymentConcatRelevantCategoryPart + "' name='codes_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + codePayment + "\" /><input type='hidden' id='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' name='idPaymentConcatRelevantCategoryPart_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /> </td>";
        addedHtml += "<td><input class='form-control shadow' size='15' max-length='15' type='text' id='resultats_" + idPaymentConcatRelevantCategoryPart + "' name='resultats_" + idPaymentConcatRelevantCategoryPart + "' value='' placeholder=''  readonly /></td>";
        addedHtml += "<td><input class='form-control shadow' size='5' max-length='5' type='text' id='unite_" + idPaymentConcatRelevantCategoryPart + "' name='unite_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + defaultUnite + "\" placeholder=''  readonly /></td>";
        addedHtml += "<td><input class='form-control shadow' size='5' max-length='5' type='text'  id='valeurs_" + idPaymentConcatRelevantCategoryPart + "' name='valeurs_" + idPaymentConcatRelevantCategoryPart + "' value=\"" + defaultValeurs + "\" placeholder=''  readonly /></td>";
        addedHtml += "</tr>";
        $("#report_body").html(currentHtml + addedHtml);


    }
</script>



<script>
    // 
    function rejetbutton(payment) {
        var html = ' <div class="modal-header">';
        html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
        html += '<h4 class="modal-title">  <?php echo lang('change_stt'); ?></h4>';
        html += '</div>';
        html += '<div class="modal-body">';
        html += ' <form role="form" action="#" id="" class="clearfix" method="post" enctype="multipart/form-data">';
        html += '<div class="form-group"> ';
        html += ' <label for="exampleInputEmail1"><?php echo lang('stt_rejet'); ?></label> ';

        html += '  </div>';


        html += '<div class="form-group cashsubmit payment  right-six col-md-12">';
        html += ' <button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal" aria-hidden="true"> <?php echo lang('no'); ?></button>';
        html += ' <span id="rejetbuttonJson*" onclick="rejetbuttonJson(' + payment + ')"   class="btn btn-info row pull-right"> <?php echo lang('yes'); ?></span>';
        html += '  </div>';
        html += ' </form>';
        html += ' </div>';

        $('#sttChangeModal').trigger("reset");
        $('#sttChangeModalHtml').html(html);
        $('#sttChangeModal').modal('show');
    }

    function rejetbuttonJson(payment) {
        $.ajax({
            url: 'finance/rejetbuttonJson',
            method: "POST",
            data: {
                patient: <?php echo $patient->id; ?>,
                prestation: '<?php echo $prestation; ?>',
                payment: '<?php echo $payment; ?>'
            },
            async: false,
            dataType: 'json',
        }).success(function(response) {
            if (response) {
                $('#valid').hide();
                $('#rejet').hide();
                $('#sttChangeModal').modal('hide');

            }
        });
    }
    $(document).ready(function() {

    });
</script>