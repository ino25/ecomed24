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
                $etat = '';
                if (isset($_GET['etat'])) {
                    $etat = $_GET['etat'];
                } ?>
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

                    <form role="form" id="editLabForm" class="clearfix" action="finance/editStatutPaiementByJasonValid" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="payment_id" value="<?php echo $payments->id; ?>">
                        <input type="hidden" name="etat" value="<?php echo $etat; ?>">
                        <input type="hidden" name="pcr" value="<?php echo $PCR; ?>">
                        <div class="form-group col-md-4">
                            <label> <?php echo lang('first_name'); ?></label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php echo $patient->name; ?>' placeholder="" readonly="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"> <?php echo lang('last_name'); ?></label>
                            <input type="text" class="form-control" name="last_name" id="exampleInputEmail1" value='<?php echo $patient->last_name; ?>' placeholder="" readonly="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"> <?php echo lang('patient_ids'); ?></label>
                            <input type="text" class="form-control" name="patient_id" id="exampleInputEmail1" value='<?php echo $patient->id; ?>' placeholder="" readonly="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"> <?php echo lang('date_of_birth'); ?></label>
                            <input type="text" class="form-control" name="birthdate" id="exampleInputEmail1" value='<?php echo $patient->birthdate; ?>' placeholder="" readonly="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1"> <?php echo lang('age'); ?></label>
                            <input type="text" class="form-control" name="age" id="exampleInputEmail1" value='<?php echo $patient->age; ?>' placeholder="" readonly="">
                            <input type="hidden" class="form-control" name="phone" id="exampleInputEmail1" value='<?php echo $patient->phone; ?>' placeholder="">
                            <input type="hidden" class="form-control" name="email" id="exampleInputEmail1" value='<?php echo $patient->email; ?>' placeholder="">
                            <input type="hidden" class="form-control" name="passport" id="exampleInputEmail1" value='<?php echo $patient->passport; ?>' placeholder="">
                            <input type="hidden" class="form-control" name="id_presta" id="exampleInputEmail1" value='<?php echo $prestation; ?>' placeholder="">
                            <input type="hidden" class="form-control" name="id_doctor" id="exampleInputEmail1" value='<?php echo $payments->doctor; ?>' placeholder="">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1"> <?php echo lang('gender'); ?></label>
                            <input type="text" class="form-control" name="sex" id="exampleInputEmail1" value='<?php echo $patient->sex; ?>' placeholder="" readonly="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"> <?php echo lang('address'); ?></label>
                            <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='<?php echo $patient->address; ?>' placeholder="" readonly="">
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
                                                                                                                            ?>' placeholder="" readonly="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1"><?php echo lang('sampling_date_time'); ?></label>
                            <div class="input-group" id="id_0">
                                <input type="text" value="<?php
                                                            if (!empty($payments->date_prelevement)) {
                                                                echo $payments->date_prelevement;
                                                            }
                                                            ?>" class="form-control <?php if (empty($payments->date_prelevement)) { ?> datetimepicker_ip <?php } ?>" name="date_prevelement" required="" readonly autocomplete="off">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Renseignement Clinique</label>
                            <textarea rows="3" cols="35" name="renseignementClinique" readonly=""><?php echo $payments->renseignementClinique; ?></textarea>
                        </div>
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

                            <div class="col-md-12" style="padding-top:35px;">
                                <a class="btn btn-info btn-secondary pull-left" href="finance/paymentLabo"><?php echo lang('retour'); ?></a>
                                <?php if ($mode != 'on') { ?>
                                    <span id="rejet" class="btn btn-info btn-danger " <?php if ($typ == 'deb' || $typ == 'fin') {
                                                                                            echo 'disabled';
                                                                                        } ?> onclick="rejetbutton('<?php echo $payment; ?>')"><?php echo lang('close-rejet'); ?></span>
                                    <button id="validerActe" type="submit" name="submit" id="submit" <?php if ($typ == 'deb' || $typ == 'fin') {
                                                                                                    echo 'disabled';
                                                                                                } ?> class="btn btn-info pull-right"><?php echo lang('valid'); ?></button>
                                <?php } ?>
                            </div>

                        </div>

                        <?php if ($prestation == 'all') { ?>
                            <input type="hidden" name="redirect" value="finance/payment">
                        <?php } else { ?>
                            <input type="hidden" name="redirect" value="finance/paymentLabo">
                        <?php } ?>


                        <input type="hidden" name="prestation" value="<?php echo $prestation; ?>">
                        <input type="hidden" name="payment" value="<?php echo $payment; ?>">

                        <input type="hidden" name="patient" value="<?php echo $patient_id; ?>">

                    </form>
                    <div class="col-md-12 signatture_class pull-right">
                        <?php
                        if (empty($user_signature)) {
                            if ($this->ion_auth->in_group(array('adminmedecin', 'Doctor'))) {
                        ?>
                                <button class=" no-print pull-right btn btn-sm btn-primary" style="display:none" id="signature"><?php echo lang('signature'); ?></button>
                            <?php } else { ?>
                                ------------------------------------<br>
                                <div class="col-md-12"> <span class="sign_class pull-right"><?php echo lang('signature'); ?></span></div>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="col-md-12">
                                <img class="sign_class pull-right imgy" src="<?php echo $user_signature; ?>" width="150" height="70" alt="alt" /><br>
                            </div>
                            <span class=" sign_class pull-right"> --------------------------</span><br>
                            <div class="col-md-12"> <span class="sign_class pull-right"><?php echo lang('signature'); ?></span></div>
                        <?php } ?>
                    </div>
            </div>
        </div>
        </div>



    </section>
    <section class="col-md-4" style="display:none">
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





    </div>
    </div>



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

<div class="modal fade" id="myModalSignature" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('verification_signature'); ?> </h4>
            </div>
            <div class="modal-body" style="height: 150px;">
                <div class="form-group">
                    <label for="inputPin">Entrez le code PIN de signature pour afficher</label>
                    <input type="password" id="inputPinView" class="form-control" name="input" onkeyup="inputPinView(event)" autocomplete="off">
                    <input type="hidden" id="inputPinViewSHA1" class="form-control" name="inputPin">
                </div>

                <div class="error_pinview" style="display:none;font-weight: bold ; color:red; font-family: Verdana, Geneva, Tahoma, sans-serif;">
                    <h5></h5>
                </div>
                <div class="sign"></div>
                <input type="hidden" id="docid" name="docid" value='<?php echo $this->ion_auth->user()->row()->id; ?>'>
                <!-- <input type="text" name="report_id" value="<?php echo $report_details->id; ?>"> -->

                <!-- <button id="signUploadView" type="button" class="btn-xs btn-info signUploadView" name="submit" class="btn btn-primary pull-right"><span class='looading'> <i class="fa fa-spinner fa-eyes" style='display:none'></i> </span> Voir</button> -->
                <button id="signUploadView" type="submit" name="submit" class="btn btn-primary"><span class='looading'> <i class="fa fa-eye" aria-hidden="true"></i></i> </span> Valider</button>
            </div>
        </div>
    </div>
</div><!-- /.modal-content -->

<div class="modal fade" id="sttChangeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content" id="sttChangeModalHtml">

        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>



<script type="text/javascript">
    $(document).ready(function() {
        $("#signUploadView").click(function(e) {
            var docid = $("#docid").val();
            var pin = $("#inputPinViewSHA1").val();
            pin = SHA1(pin);
            //alert('profile/viewSign?docid=' + docid + '&pin=' + pin);
            const danger = document.querySelector(".error_pinview");
            var bt = document.getElementById('validerActe');
            bt.style.display = "";
            danger.style.display = ""
            $.ajax({
                url: 'profile/viewSign?docid=' + docid + '&pin=' + pin,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                console.log("*********************************");
                console.log(response.message);
                console.log("*********************************");
                if (response.error) {
                    // $('.sign').html('');
                    bt.style.display = "none";
                    danger.innerHTML = `<strong>${response.message}</strong>`;

                    //$('.error').css('color', 'red').text(response.message);
                } else {
                    var data = response.user_signature;
                    $('.signatture_class').html(" ");
                    $('.signatture_class').append(' <div class="col-md-12"><img class="imgy sign_class pull-right" src="' + data[0].sign_name + '"width="150;"height="70"alt=""/></div><br><span class="sign_class pull-right" >---------------------------------</span><br> <div class="col-md-12"><span class="sign_class pull-right" ><?php echo lang('signature'); ?></span></div>')
                    $('.options').removeClass('hidden');
                    $('#myModalSignature').modal('hide');
                    bt.style.display = "block";
                }
            });
        });

    });

    function inputPinView(event) {

        var pin = $("#inputPinView").val();
        var pinSHA1 = SHA1(pin);
        var bt = document.getElementById('signUploadView');
        const danger = document.querySelector(".error_pinview");
        danger.style.display = ""
        document.getElementById('inputPinViewSHA1').value = "";
        if (pin.length == 6) {
            danger.style.display = "none";
            document.getElementById('inputPinViewSHA1').value = pinSHA1;
            bt.disabled = false;
        } else {

            danger.innerHTML = `<strong>Veuillez entrer 6 chiffres</strong>`;
            bt.disabled = true;
        }

    }

    function SHA1(msg) {
        function rotate_left(n, s) {
            var t4 = (n << s) | (n >>> (32 - s));
            return t4;
        };

        function lsb_hex(val) {
            var str = '';
            var i;
            var vh;
            var vl;
            for (i = 0; i <= 6; i += 2) {
                vh = (val >>> (i * 4 + 4)) & 0x0f;
                vl = (val >>> (i * 4)) & 0x0f;
                str += vh.toString(16) + vl.toString(16);
            }
            return str;
        };

        function cvt_hex(val) {
            var str = '';
            var i;
            var v;
            for (i = 7; i >= 0; i--) {
                v = (val >>> (i * 4)) & 0x0f;
                str += v.toString(16);
            }
            return str;
        };

        function Utf8Encode(string) {
            string = string.replace(/\r\n/g, '\n');
            var utftext = '';
            for (var n = 0; n < string.length; n++) {
                var c = string.charCodeAt(n);
                if (c < 128) {
                    utftext += String.fromCharCode(c);
                } else if ((c > 127) && (c < 2048)) {
                    utftext += String.fromCharCode((c >> 6) | 192);
                    utftext += String.fromCharCode((c & 63) | 128);
                } else {
                    utftext += String.fromCharCode((c >> 12) | 224);
                    utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
            }
            return utftext;
        };
        var blockstart;
        var i, j;
        var W = new Array(80);
        var H0 = 0x67452301;
        var H1 = 0xEFCDAB89;
        var H2 = 0x98BADCFE;
        var H3 = 0x10325476;
        var H4 = 0xC3D2E1F0;
        var A, B, C, D, E;
        var temp;
        msg = Utf8Encode(msg);
        var msg_len = msg.length;
        var word_array = new Array();
        for (i = 0; i < msg_len - 3; i += 4) {
            j = msg.charCodeAt(i) << 24 | msg.charCodeAt(i + 1) << 16 | msg.charCodeAt(i + 2) << 8 | msg.charCodeAt(i + 3);
            word_array.push(j);
        }
        switch (msg_len % 4) {
            case 0:
                i = 0x080000000;
                break;
            case 1:
                i = msg.charCodeAt(msg_len - 1) << 24 | 0x0800000;
                break;
            case 2:
                i = msg.charCodeAt(msg_len - 2) << 24 | msg.charCodeAt(msg_len - 1) << 16 | 0x08000;
                break;
            case 3:
                i = msg.charCodeAt(msg_len - 3) << 24 | msg.charCodeAt(msg_len - 2) << 16 | msg.charCodeAt(msg_len - 1) << 8 | 0x80;
                break;
        }
        word_array.push(i);
        while ((word_array.length % 16) != 14) word_array.push(0);
        word_array.push(msg_len >>> 29);
        word_array.push((msg_len << 3) & 0x0ffffffff);
        for (blockstart = 0; blockstart < word_array.length; blockstart += 16) {
            for (i = 0; i < 16; i++) W[i] = word_array[blockstart + i];
            for (i = 16; i <= 79; i++) W[i] = rotate_left(W[i - 3] ^ W[i - 8] ^ W[i - 14] ^ W[i - 16], 1);
            A = H0;
            B = H1;
            C = H2;
            D = H3;
            E = H4;
            for (i = 0; i <= 19; i++) {
                temp = (rotate_left(A, 5) + ((B & C) | (~B & D)) + E + W[i] + 0x5A827999) & 0x0ffffffff;
                E = D;
                D = C;
                C = rotate_left(B, 30);
                B = A;
                A = temp;
            }
            for (i = 20; i <= 39; i++) {
                temp = (rotate_left(A, 5) + (B ^ C ^ D) + E + W[i] + 0x6ED9EBA1) & 0x0ffffffff;
                E = D;
                D = C;
                C = rotate_left(B, 30);
                B = A;
                A = temp;
            }
            for (i = 40; i <= 59; i++) {
                temp = (rotate_left(A, 5) + ((B & C) | (B & D) | (C & D)) + E + W[i] + 0x8F1BBCDC) & 0x0ffffffff;
                E = D;
                D = C;
                C = rotate_left(B, 30);
                B = A;
                A = temp;
            }
            for (i = 60; i <= 79; i++) {
                temp = (rotate_left(A, 5) + (B ^ C ^ D) + E + W[i] + 0xCA62C1D6) & 0x0ffffffff;
                E = D;
                D = C;
                C = rotate_left(B, 30);
                B = A;
                A = temp;
            }
            H0 = (H0 + A) & 0x0ffffffff;
            H1 = (H1 + B) & 0x0ffffffff;
            H2 = (H2 + C) & 0x0ffffffff;
            H3 = (H3 + D) & 0x0ffffffff;
            H4 = (H4 + E) & 0x0ffffffff;
        }
        var temp = cvt_hex(H0) + cvt_hex(H1) + cvt_hex(H2) + cvt_hex(H3) + cvt_hex(H4);
        return temp.toLowerCase();
    }
</script>
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
        $(".flashmessage").delay(3000).fadeOut(100);
        $('#signature').on('click', function() {
            $('#myModalSignature').modal('show');
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

                    // addedHtml += "<td style='font-weight:500;'>" + prestation + " " + "<br/> <span style='font-weight:400;'> (" + codePayment + ")</span>" + "<input type='hidden' id='prestations_" + idPaymentConcatRelevantCategoryPart + "' name='prestations[]' value=\"" + codePayment + "\" /> </td>";
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
                            if (prestas[7] === 'sous_section') {
                                addedHtml += "<tr>";
                                addedHtml += "<td style='font-weight:500;'><strong style='font-size: 1.2em'>" + prestas[1] + "</strong><input class='form-control shadow' size='35' readonly type='hidden' id='' name='' value=\"" + prestas[1] + " \" /><input type='hidden' id='' name='idParam[]' value=\"" + prestas[0] + "\" />\n\
                     <input type='hidden' id='' name='nomParam[]' value=\"" + prestas[1] + "\" /><input type='hidden' id='' name='values[]' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /><input type='hidden' id='' name='idPrestation[]' value=\"" + idPrestation + "\" /><input type='hidden' id='' name='codes[]' value=\"" + idPayment + "\" /></td>";
                                addedHtml += "<td style='width:45%><input class='form-control shadow' size='15' max-length='15' type='hidden' readonly id='resultats_" + prestas[0] + "' name='resultats[]' value=\"" + prestas[4] + "\" /></td>";
                                addedHtml += "<td style='width:15%'><input class='form-control shadow' size='5' readonly max-length='5' type='hidden' id='' name='' value=\"" + prestas[2] + "\" /><strong style='font-size: 1.2em'>" + prestas[2] + "</strong></td>";
                                addedHtml += "<td style='width:15%'><input class='form-control shadow' size='5' readonly  max-length='5' type='hidden'  id='' name='' value=\"" + prestas[3] + "\" placeholder='' /><strong style='font-size: 1.2em'>" + prestas[3] + "</strong></td>";
                                addedHtml += "<td class='ref_low_td' style='width:10%;padding-top:15px'><input class='form-control shadow' size='5' readonly  max-length='5' type='hidden'  id='' name='' value=\"" + prestas[5] + "\" placeholder='' /><strong style='font-size: 1.2em'>" + prestas[5] + "</strong></td>";
                                addedHtml += "<td class='ref_high_td' style='width:10%;padding-top:15px'><input class='form-control shadow' size='5' readonly  max-length='5' type='hidden'  id='' name='' value=\"" + prestas[6] + "\" placeholder='' /><strong style='font-size: 1.2em'>" + prestas[6] + "</strong></td>";

                                addedHtml += "</tr>";
                            } else if (prestas[7] === 'section') {
                                addedHtml += "<tr>";
                                addedHtml += "<td style='font-weight:500;'><strong style='font-size: 1.2em'>" + prestas[1] + "</strong><input class='form-control shadow' size='35' readonly type='hidden' id='' name='' value=\"" + prestas[1] + " \" /><input type='hidden' id='' name='idParam[]' value=\"" + prestas[0] + "\" />\n\
                     <input type='hidden' id='' name='nomParam[]' value=\"" + prestas[1] + "\" /><input type='hidden' id='' name='values[]' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /><input type='hidden' id='' name='idPrestation[]' value=\"" + idPrestation + "\" /><input type='hidden' id='' name='codes[]' value=\"" + idPayment + "\" /></td>";
                                addedHtml += "<td style='width:45%><input class='form-control shadow' size='15' max-length='15' type='hidden' readonly id='resultats_" + prestas[0] + "' name='resultats[]' value=\"" + prestas[4] + "\" /></td>";
                                addedHtml += "<td style='width:15%'><input class='form-control shadow' size='5' readonly max-length='5' type='hidden' id='' name='' value=\"" + prestas[2] + "\" /><strong style='font-size: 1.2em'>" + prestas[2] + "</strong></td>";
                                addedHtml += "<td style='width:15%'><input class='form-control shadow' size='5' readonly  max-length='5' type='hidden'  id='' name='' value=\"" + prestas[3] + "\" placeholder='' /><strong style='font-size: 1.2em'>" + prestas[3] + "</strong></td>";
                                addedHtml += "<td class='ref_low_td' style='width:10%;padding-top:15px'><input class='form-control shadow' size='5' readonly  max-length='5' type='hidden'  id='' name='' value=\"" + prestas[5] + "\" placeholder='' /><strong style='font-size: 1.2em'>" + prestas[5] + "</strong></td>";
                                addedHtml += "<td class='ref_high_td' style='width:10%;padding-top:15px'><input class='form-control shadow' size='5' readonly  max-length='5' type='hidden'  id='' name='' value=\"" + prestas[6] + "\" placeholder='' /><strong style='font-size: 1.2em'>" + prestas[6] + "</strong></td>";

                                addedHtml += "</tr>";
                            } else {
                                addedHtml += "<tr>";
                                addedHtml += "<td style='font-weight:500;'><strong style='font-size: 1.2em'>" + prestas[1] + "</strong><input class='form-control shadow' size='35' readonly type='hidden' id='' name='' value=\"" + prestas[1] + " \" /><input type='hidden' id='' name='idParam[]' value=\"" + prestas[0] + "\" />\n\
                     <input type='hidden' id='' name='nomParam[]' value=\"" + prestas[1] + "\" /><input type='hidden' id='' name='values[]' value=\"" + idPaymentConcatRelevantCategoryPart + "\" /><input type='hidden' id='' name='idPrestation[]' value=\"" + idPrestation + "\" /><input type='hidden' id='' name='codes[]' value=\"" + idPayment + "\" /></td>";
                                addedHtml += "<td style='width:45%><input class='form-control shadow' size='15' max-length='15' type='hidden' readonly id='resultats_" + prestas[0] + "' name='resultats[]' value=\"" + prestas[4] + "\" /><strong style='font-size: 1.2em'>" + prestas[4] + "</strong></td>";
                                addedHtml += "<td style='width:15%'><input class='form-control shadow' size='5' readonly max-length='5' type='hidden' id='' name='' value=\"" + prestas[2] + "\" /><strong style='font-size: 1.2em'>" + prestas[2] + "</strong></td>";
                                addedHtml += "<td style='width:15%'><input class='form-control shadow' size='5' readonly  max-length='5' type='hidden'  id='' name='' value=\"" + prestas[3] + "\" placeholder='' /><strong style='font-size: 1.2em'>" + prestas[3] + "</strong></td>";
                                addedHtml += "<td class='ref_low_td' style='width:10%;padding-top:15px'><input class='form-control shadow' size='5' readonly  max-length='5' type='hidden'  id='' name='' value=\"" + prestas[5] + "\" placeholder='' /><strong style='font-size: 1.2em'>" + prestas[5] + "</strong></td>";
                                addedHtml += "<td class='ref_high_td' style='width:10%;padding-top:15px'><input class='form-control shadow' size='5' readonly  max-length='5' type='hidden'  id='' name='' value=\"" + prestas[6] + "\" placeholder='' /><strong style='font-size: 1.2em'>" + prestas[6] + "</strong></td>";

                                addedHtml += "</tr>";
                            }

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


                speciality = data[i].nom_specialite;
                prestation = prestation;
            }

            $("#report_body").html(addedHtml);
            $("#speciality").html(speciality);
            $("#prestation").html(prestation + ' (' + codePayment + ')');
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