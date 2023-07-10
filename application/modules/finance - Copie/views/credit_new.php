<!--main content start-->

<section id="main-content">
    <section class="wrapper site-min-height">
        <div id="success" class="top-nav" style="display: none">
            <code class="flashmessage pull-right"> Achat de crédit effecué avec succès</code>
        </div>
        <!-- page start-->
        <section class="col-md-7">
            <header class="panel-heading">
                <?php
                if (!empty($category->id))
                    echo lang('service_credit');
                else
                    echo lang('service_credit');
                ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <?php echo validation_errors(); ?>
                        <div id="achat" style="display: block">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo lang('phoneNumber'); ?></label>
                                <input type="text" class="form-control" name="mobNo" id="mobNo" value="" placeholder="" pattern="[0-9]{9}" required autocompleted="off">
                                <code id="phoneID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>
                            </div>

                            <div class="form-group">
                                <label><?php echo lang('amountService'); ?></label>
                                <input class="form-control money" type="text" name="amount" id="amount" min="100" max="100000" value="" placeholder="" required autocompleted="off">
                                <code id="montantID" class="flash_message" style="display:none">Cette valeur doit être comprise entre 100 et 100.000 FCFA</code>
                            </div>
                            <div class="form-group col-md-12">
                                <button id="submit" type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit_continuer'); ?></button>
                                <a href="finance/menuService" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></a>
                            </div>
                        </div>
                        <div id="confirmationachat" style="display: none">
                            <div class="col-md-12">
                                <label class="col-md-8 pull-left remove1">Téléphone</label>
                                <label class="col-md-4 pull-right remove1" id="phone"></label>
                                <label class="col-md-8 pull-left remove1">Montant</label>
                                <label class="col-md-4 pull-right remove1" id="amountconfirmation"></label>
                                <label class="col-md-8 pull-left remove1">Frais</label>
                                <label class="col-md-4 pull-right remove1" id="feeAmount"></label>
                                <label class="col-md-8 pull-left remove1">Total</label>
                                <label class="col-md-4 pull-right remove1" id="totalconfirmation"></label>
                            </div>
                            <div class="form-group col-md-12" style="padding-top:20px">
                                <button id="valider" type="submit" name="submit" class="btn btn-info pull-right" style="margin-left:15px"><?php echo lang('submit_effectuer'); ?></button>
                                <button id="retourCredit" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></button>
                            </div>
                        </div>
                        <div id="validationachat" style="display: none">
                            <div class="col-md-12">
                                <label class="col-md-8 pull-left remove1">Numéro de Téléphone</label>
                                <label class="col-md-4 pull-right remove1" id="phonevalidation"></label>
                                <label class="col-md-8 pull-left remove1">Numéro Transaction</label>
                                <label class="col-md-4 pull-right remove1" id="idTransaction"></label>
                                <label class="col-md-8 pull-left remove1">Date</label>
                                <label class="col-md-4 pull-right remove1" id="dateTransaction"></label>
                                <label class="col-md-8 pull-left remove1">Heure</label>
                                <label class="col-md-4 pull-right remove1" id="heureTransaction"></label>
                                <label class="col-md-8 pull-left remove1">Montant</label>
                                <label class="col-md-4 pull-right remove1" id="amountconfirmationvalidation"></label>
                                <input hidden type="text" id="convertmontant" name="montantfcfa" value="">
                            </div>
                            <div class="form-group col-md-12" style="padding-top:20px">
                                <a href="finance/expense" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour_service'); ?></a>
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
                <input type="hidden" id="formCustmer" value="<?php echo !empty($id_partenaire_zuuluPay) ? $id_partenaire_zuuluPay : ""; ?>">
                <input type="hidden" id="PIN" value="<?php echo !empty($pin_decrypted) ? $pin_decrypted : ""; ?>">
            </div>
            <div id="ino" style="float:right"></div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
<!-- TEST INTEGRATION -->
<!--main content end-->
<!--footer start-->
<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>
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

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var formCustmer = $('#formCustmer').val();
        var pin = $('#PIN').val();
        solde("fr", formCustmer, pin);
        $("#retourCredit").click(function(e) {
            var achat = document.getElementById('achat');
            var confirmationachat = document.getElementById('confirmationachat');
            achat.style['display'] = 'block';
            confirmationachat.style['display'] = 'none';
        });
        $("#submit").click(function(e) {
            var errorphone = document.getElementById('phoneID');
            var errormontant = document.getElementById('montantID');
            var phone = $('#mobNo').val();
            var amount = $('#amount').val();
            var phoneFormat = phone.replace(/[^\d]/g, '');
            var nbreCaratere = phoneFormat.length;
            amount = amount.replace(".", "").replace(".", "").replace(".", "");
            errorphone.style['display'] = 'none';
            errormontant.style['display'] = 'none';
            if (nbreCaratere != 12) {
                errorphone.style['display'] = 'block';
            } else if (parseInt(amount) < 100 || parseInt(amount) > 100000) {
                errormontant.style['display'] = 'block';
            } else {
                var reponseAll = loadDons("fr", phone, amount, phoneFormat, formCustmer, pin);
                // console.log('-----------reponseAll---------------');
                // console.log(reponseAll);
            }


            e.preventDefault(e);


        });


        $("#valider").click(function(e) {
            var phoneFormat = $('#mobNo').val();
            var amountFCFA = $('#convertmontant').val();
            var amount = $('#amount').val();
            amount = amount.replace(".", "").replace(".", "").replace(".", "");
            var phone = phoneFormat.replace(/[^\d]/g, '');

            //alert(phone+"Le montant "+amount+" Le montant formatter "+amountFCFA+"le numeroTelephoneFormatter"+phoneFormat)
            // alert(phone+"***"+amount+"***"+amountFCFA);

            var reponseAll = validationCredit("fr", phone, amount, amountFCFA, phoneFormat, formCustmer, pin);
            //   console.log('-----------reponseAll---------------');
            // //   alert(amount+'********'+phone);
            //         console.log(reponseAll);


            e.preventDefault(e);

        });

    });
</script>