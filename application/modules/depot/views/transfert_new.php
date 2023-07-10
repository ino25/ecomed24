<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <div id="success" class="top-nav" style="display: none;padding-top:15px">
                <code class="flashmessage pull-right"> Transfert Interne effecué avec succès</code>
            </div>
            <header class="panel-heading">
                <?php echo lang('add_transfert'); ?>
            </header>
            <header class="panel-heading tab-bg-dark-navy-blueee">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#transfertInterne"><?php echo lang('transfert_interne'); ?></a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#transfertExterne"><?php echo lang('transfert_externe'); ?></a>
                    </li>
                </ul>
            </header>
            <div class="panel">
                <div class="tab-content">
                    <div id="transfertInterne" class="tab-pane active">
                        <div class="col-lg-10">
                            <div class="adv-table editable-table">
                                <div class="clearfix">
                                    <style>
                                        .clearfix {
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

                                        .separation {
                                            clear: both;
                                            position: absolute;
                                            margin-top: 10px;
                                            margin-left: 250px;
                                            height: 200px;
                                            width: 5px;
                                            background: black;
                                        }

                                        .petiteligne {
                                            font-size: 14px;
                                        }

                                        .grandeligne {
                                            font-size: 1.2em;
                                        }

                                        .remove1 {
                                            background-color: #fff;
                                            color: #555;
                                            font-size: 1.2em;
                                        }

                                        hr {
                                            height: 1px;
                                            margin: -0.5em 0;
                                            padding: 0;
                                            color: #0D4D99;
                                            background-color: #0D4D99;
                                            border: 0;
                                        }
                                    </style>
                                    <div id="interfaceInterne">
                                        <div class="form-group col-md-5">
                                            <label for="exampleInputEmail1">Montant</label>
                                            <input class="form-control money" type="text" name="amount" id="amount" min="100" max="100000" value="" placeholder="" required autocompleted="off">
                                            <code id="montantID" class="flash_message" style="display:none">Cette valeur doit être comprise entre 100 et 100.000 FCFA</code>
                                            <code id="montantsup" class="flash_message" style="display:none">Le montant saisi est supérieur au solde du Compte Encaissement</code>
                                        </div>
                                        <div class="form-group col-md-8"></div>
                                        <div class="form-group col-md-5">
                                            <label for="exampleInputEmail1">Débiter</label>
                                            <select class="form-control m-bot15" id="compteencaissement" name="compteencaissement" value=''>
                                                <option value="compteencaissement">Compte Encaissement</option>
                                            </select>
                                            <div class="col-form-label">
                                                Solde Actuel : <span id="soldeEncaissement"><img src="<?php echo base_url(); ?>common/img/chargement.gif" style="width: 100px;"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="exampleInputEmail1">Créditer</label>
                                            <select class="form-control m-bot15" id="compteservice" name="compteservice" value=''>
                                                <option value="compteservice">Compte Service</option>
                                            </select>
                                            <div class="col-form-label">
                                                Solde Actuel : <span id="soldeDisponible"><img src="<?php echo base_url(); ?>common/img/chargement.gif" style="width: 100px;"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-10">
                                            <div class="form-group col-md-12" style="padding-top:20px">
                                                <button id="continuer" type="submit" name="submit" class="btn btn-info pull-right" style="margin-left:15px">Continuer</button>
                                                <button id="retourCredit" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="confirmationInterne" class="tab-pane" style="display: none;">
                                        <label class="grandeligne">Vous êtes sur le point d’effectuer un transfert de <span id="montantConfirmation"></span> du compte Encaissement vers le compte service</label>
                                        <div class="col-md-10" style="padding-top: 20px;">
                                            <table style="padding-top: 20px;">
                                                <tr>
                                                    <th style="width: 30%;"><label class="pull-left remove1">Montant</label></th>
                                                    <th style="width: 5%;"></th>
                                                    <th style="width: 60%;"><label class="pull-right remove1" id="amountconfirmation"></label></label></th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 30%;"><label class="pull-left remove1">Frais</label></th>
                                                    <th style="width: 5%;"></th>
                                                    <th style="width: 60%;"><label class="pull-right remove1" id="feeAmount"></label></label></th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 30%;"><label class="pull-left remove1">Total</label></th>
                                                    <th style="width: 5%;"></th>
                                                    <th style="width: 60%;"><label class="pull-right remove1" id="totalconfirmation"></label></label></th>
                                                </tr>
                                            </table>
                                            <input hidden type="text" id="convertmontant" name="montantfcfa" value="">
                                        </div>
                                        <div class="form-group col-md-7">
                                            <div class="form-group col-md-7" style="padding-top:20px">
                                                <button id="validationInterne" type="submit" name="submit" class="btn btn-info pull-right" style="margin-left:15px">Effectuer</button>
                                                <button id="retourInterne" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="validertransfertInterne" class="tab-pane" style="display: none;">
                                        <div class="col-md-10" style="padding-top: 20px;">
                                            <table style="padding-top: 20px;">
                                                <tr>
                                                    <th style="width: 30%;"><label class="pull-left remove1">Numéro Transaction</label></th>
                                                    <th style="width: 5%;"></th>
                                                    <th style="width: 60%;"><label class="pull-right remove1" id="idTransaction"></label></th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 30%;"><label class="pull-left remove1">Date</label></th>
                                                    <th style="width: 5%;"></th>
                                                    <th style="width: 60%;"><label class="pull-right remove1" id="dateTransaction"></label></th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 30%;"><label class="pull-left remove1">Heure</label></th>
                                                    <th style="width: 5%;"></th>
                                                    <th style="width: 60%;"><label class="pull-right remove1" id="heureTransaction"></label></th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 30%;"><label class="pull-left remove1">Montant</label></th>
                                                    <th style="width: 5%;"></th>
                                                    <th style="width: 60%;"><label class="pull-right remove1" id="validationmontant"></label></th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="form-group col-md-7">
                                            <div class="form-group col-md-7" style="padding-top:20px">
                                                <a href="depot/operationFinanciere" type="submit" name="submit" class="btn btn-info btn-secondary pull-left">Retour Liste Opération</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <code id="error" class="flash_message" style="display:none"></code>
                                    </div>
                                    <div class="col-md-12">
                                        <code id="errorCredit" class="flash_message" style="display:none"></code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="transfertExterne" class="tab-pane">
                        <div class="grandeligne" style="float:right;padding-top:10px" id="soldePrincipal">
                            <img src="<?php echo base_url(); ?>common/img/chargement.gif" style="width: 100px;">
                        </div>
                        <div class="clearfix">
                            <div id="interfaceExterne">
                                <div class="form-group col-md-5">
                                    <label for="exampleInputEmail1"><?php echo lang('identifiant'); ?></label>
                                    <input type="text" class="form-control" name="mobNo" id="mobNo" value="" placeholder="" onkeyup="identifiantExterne(event)" pattern="[0-9]{9}" required autocompleted="off">
                                    <div id="notification"></div>
                                    <div id="notificationMembre"></div>
                                </div>
                                <div class="form-group col-md-9">
                                    <hr>
                                </div>
                                <div id="client"></div>
                                <div id="partners"></div>
                                <div id="noClient"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="formCustmer" value="<?php echo !empty($id_partenaire_zuuluPay) ? $id_partenaire_zuuluPay : ""; ?>">
            <input type="hidden" id="PIN" value="<?php echo !empty($pin_decrypted) ? $pin_decrypted : ""; ?>">
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->

<!--main content end-->
<!--footer start-->
<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/paiement.js?<?php echo time(); ?>"></script>
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>
<script>
    var autoNumericInstance = new AutoNumeric.multiple('.money', {
        // currencySymbol: "Fcfa",
        // currencySymbolPlacement: "s",
        // emptyInputBehavior: "min",
        // selectNumberOnly: true,
        // selectOnFocus: true,
        overrideMinMaxLimits: 'invalid',
        emptyInputBehavior: "min",
        maximumValue: '100000',
        minimumValue: "100",
        decimalPlaces: 0,
        decimalCharacter: ',',
        digitGroupSeparator: '.'
    });
</script>
<script>
    var element = document.getElementById('mobNo');
    var maskOptions = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var mask = IMask(element, maskOptions);
    mask.value = "{-- --- -- --";
</script>
<script>
    $(document).ready(function() {
        var formCustmer = $('#formCustmer').val();
        var pin = $('#PIN').val();
        var reponseAll = solde("fr", formCustmer, pin);

        $("#continuer").click(function(e) {
            var amount = $('#amount').val();
            var amountFormat = $('#amount').val();
            document.querySelector("#montantConfirmation").innerHTML = amountFormat + ' FCFA';
            amount = amount.replace(".", "").replace(".", "").replace(".", "");
            var formCustmer = $('#formCustmer').val();
            var pin = $('#PIN').val();
            var montantsup = document.getElementById('montantsup');
            var soldeEncaissement = document.getElementById("soldeEncaissement").innerHTML;
            soldeEncaissement = soldeEncaissement.replace(".", "").replace(".", "").replace(".", "").replace("FCFA", "");
            soldeEncaissement = parseInt(soldeEncaissement);
            montantsup.style['display'] = 'none';
            if (amount > soldeEncaissement) {
                montantsup.style['display'] = 'block';
            } else {
                transfertInterne("fr", amount, formCustmer, pin);
            }


        });

        $("#retourInterne").click(function(e) {
            var interfaceInterne = document.getElementById('interfaceInterne');
            var confirmationInterne = document.getElementById('confirmationInterne');
            interfaceInterne.style['display'] = 'block';
            confirmationInterne.style['display'] = 'none';

        });



        $("#validationInterne").click(function(e) {
            var amount = $('#amount').val();
            var amountFormat = $('#amount').val();
            document.querySelector("#montantConfirmation").innerHTML = amountFormat + ' FCFA';
            document.querySelector("#validationmontant").innerHTML = amountFormat + ' FCFA';
            amount = amount.replace(".", "").replace(".", "").replace(".", "");
            var formCustmer = $('#formCustmer').val();
            var pin = $('#PIN').val();

            validationInterne("fr", amount, formCustmer, pin);
        });

        $("#retourAccueil").click(function(e) {
            var interfaceInterne = document.getElementById('interfaceInterne');
            var confirmationInterne = document.getElementById('confirmationInterne');
            var validertransfertInterne = document.getElementById('validertransfertInterne');
            var success = document.getElementById('validertransfertInterne');
            interfaceInterne.style['display'] = 'block';
            confirmationInterne.style['display'] = 'none';
            validertransfertInterne.style['display'] = 'none';
            success.style['display'] = 'none';
        });

        
    });
</script>
<script>
     function identifiantExterne(event) {
        var formCustmer = $('#formCustmer').val();
        var pin = $('#PIN').val();
        var phone = $('#mobNo').val();
        var phoneFormat = phone.replace(/[^\d]/g, '');
        if(phoneFormat.length >= 10){
            transfertExterne("fr", phoneFormat, formCustmer, pin);
        }
    }

</script>