<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel col-md-9">
            <header class="panel-heading">
                <?php
                if (!empty($visite->id))
                    echo lang('add_new_payment3');
                else
                    echo lang('add_new_payment3');
                ?>
            </header>
            <div class="panel-body" id="confirmation">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="col-lg-12">
                            <div class="no-print">
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
                                        </style>
                                        <div class="form-group col-md-9" style="margin-top: 10px;">
                                            <label class="grandeligne">Veuillez saisir le numéro de compte orange money</label>
                                        </div>
                                        <div class="form-group col-md-9" style="margin-top: 10px;">
                                            <label for="exampleInputEmail1">Numero compte orange money</label>
                                            <input type="text" class="form-control" name="mobNo" id="mobNo" value="" placeholder="" pattern="[0-9]{9}" required autocompleted="off">
                                            <code id="phoneID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>
                                        </div>
                                        <div class="form-group col-md-10">
                                            <div class="form-group col-md-12" style="padding-top:20px">
                                                <button id="validationOrange" type="submit" name="submit" class="btn btn-info pull-right" style="margin-left:15px">Continuer</button>
                                                <a href="<?php echo $redirect ; ?>" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="validationdepotorange" style="display:none;padding-top:30px">
                <label class="grandeligne">Le patient doit saisir le code USSD suivant sur son téléphone .</label>
                <label class="grandeligne">CODE USSD : <span id="msgussd"></span></label>
                <div class="form-group col-md-10" style="padding-top:20px">
                    <label class="grandeligne">Entrer la référence OrangeMoney reçue par le patient et cliquer "Continuer"</label>
                    <label for="exampleInputEmail1" style="padding-top: 10px;">Code de référence</label>
                    <input type="text" class="form-control" name="mobRef" id="mobRef" value="" placeholder="" pattern="[0-9]{9}" required autocompleted="off" onkeyup="validation(event)">
                    <code id="phoneID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>
                </div>
                <div class="form-group col-md-10">
                <button type="submit" id="rediriger" data-toggle="modal" data-backdrop="static" href="#myModalPopup" name="submit" class="btn btn-info pull-right"><?php echo lang('submit_continuer'); ?></button>
                    <button id="retourConfirmation" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></button>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<div class="modal" tabindex="-1" role="dialog" id="myModalPopup">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Paiement OrangeMoney</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <br>
            <div class="modal-body" style="padding-top: 15px;">
                <p>Nous validons le paiement du patient <strong><?php echo $p_name.' '.$p_lastName ; ?></strong> d'un montant de <strong id="montantConfirmation"></strong></p>
                <p>Le traitement durera moins de 10 minutes. Nous vous notifions par SMS dès que ce sera terminé.</p>
            </div>
            <form role="form" class="clearfix" action="finance/checkDepotOM" method="post" enctype="multipart/form-data">
            <input hidden  id="formCustmer" value="<?php echo !empty($id_partenaire_zuuluPay) ? $id_partenaire_zuuluPay : ""; ?>">
            <input hidden id="PIN" value="<?php echo !empty($pin_decrypted) ? $pin_decrypted : ""; ?>">
            <input hidden id="depot" name="deposited_amount" value="<?php echo $depot; ?>">
            <input hidden id="paymentid" name="paymentid" value="<?php echo $paymentid ; ?>">
            <input hidden id="patient" name="patient"  value="<?php echo $patient ; ?>">
            <input hidden id="p_name" value="<?php echo $p_name ; ?>">
            <input hidden id="p_id" value="<?php echo $p_id ; ?>">
            <input hidden id="p_lastName" value="<?php echo $p_lastName ; ?>">
            <input hidden name="statut_deposit" id="statut_deposit" value="PENDING">
            <input hidden name="refMobRef" id="refMobRef" value="">
            <input hidden type="text" name="idtransaction" id="idTransaction" value="">
            <input hidden type="text" name="refNumOM" id="refNumOM" value="">
            <input hidden name="redirect" value='<?php echo $redirect ; ?>'>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">OK</button>
                </div>
            </form>
            
        </div>
    </div>
</div>
<!--main content end-->
<!--footer start-->
<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/paiement.js"></script>
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
    var ref = document.getElementById('mobRef');
    var maskOptions = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var patternMask = IMask(ref, {
        mask: '{PP}000000.0000.[a]00000',
        lazy: false,
    });
    var mask = IMask(element, maskOptions);
    mask.value = "{-- --- -- --";
    var el = IMask(ref, patternMask);
    el.value = "{------ ---- ------";
</script>
<script>
    // or without UI element
    // var masked = IMask.PatternMasked({
    //   mask: '{#}000[aaa]/NIC-`*[**]'
    // });
</script>
<script>
    $(document).ready(function() {
        var bt = document.getElementById('rediriger');
        bt.disabled = true;
        
        // $("#rediriger").click(function(e) {
        //     var phone = $('#mobNo').val();
        //     var amount = $('#depot').val();
        //     var mobRef = $('#mobRef').val();
        //     var bt = document.getElementById('rediriger');
        //     bt.disabled = true;
        //     var phoneFormat = phone.replace(/[^\d]/g, '');
        //     amount = amount.replace(".", "").replace(".", "").replace(".", "");
        //     var type = 'depot';
        //     var description = 'Dépôt Orange Money';
        //     var statut = 'PENDING';
        //     var destinataire = 'Compte Service';
        //     $.ajax({
        //         url: 'depot/confirmationorangemoney?amount=' + amount + '&phone=' + phoneFormat + '&type=' + type + '&description=' + description + '&statut=' + statut + '&destinataire=' + destinataire + '&reference=' + mobRef,
        //         method: 'POST',
        //         data: '',
        //         dataType: 'json',
        //     }).success(function(response) {

        //     });
        //     window.location.href = 'depot/operationFinanciere';
        // });

        $("#retourOrange").click(function(e) {
            var confirmation = document.getElementById('confirmation');
            confirmation.style['display'] = 'none';
        });

        $("#retourConfirmation").click(function(e) {
            var validationdepotorange = document.getElementById('validationdepotorange');
            var confirmation = document.getElementById('confirmation');
            validationdepotorange.style['display'] = 'none';
            confirmation.style['display'] = 'block';
        });

        $("#validationOrange").click(function(e) {
            var errormontant = document.getElementById('montantID');
            var errorphone = document.getElementById('phoneID');
            var formCustmer = $('#formCustmer').val();
            var validationdepotorange = document.getElementById('validationdepotorange');
            var pin = $('#PIN').val();
            var phone = $('#mobNo').val();
            var amount = $('#depot').val();
            var formatAmount = formatCurrencyFacture(amount);
            document.querySelector("#montantConfirmation").innerHTML = formatAmount;
            var phoneFormat = phone.replace(/[^\d]/g, '');
            var nbreCaratere = phoneFormat.length;
            errorphone.style['display'] = 'none';
            if (nbreCaratere != 12) {
                errorphone.style['display'] = 'block';
            } else {
               // alert("fr" + amount + phoneFormat + formCustmer + pin);
                confirmation.style['display'] = 'none';
                validationdepotorange.style['display'] = 'block';
                document.getElementById('refNumOM').value = phoneFormat;
                var reponseAll = paiementOrangeMoney("fr", amount, phoneFormat, formCustmer, pin);


            }
        });



    });
</script>
<script>
    function validation(event) {
        var bt = document.getElementById('rediriger');
        bt.disabled = true;
        var phone = $('#mobNo').val();
        var amount = $('#depot').val();
        var mobRef = $('#mobRef').val();
        var phoneFormat = phone.replace(/[^\d]/g, '');
        var type = 'depot';
        var description = 'Dépôt Orange Money';
        var statut = 'PENDING';
        var destinataire = 'Compte Service';
        var nbreCaratere = phoneFormat.length;
        var ref = /PP\d{6}\.\d{4}\.[A-Z]\d{5}/.test(mobRef);
        if (ref == true) {
            bt.disabled = false;
            document.getElementById('refMobRef').value = mobRef;
        } else {
            bt.disabled = true;
        }
    }
    function formatCurrencyFacture(number) {
        return (number || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' FCFA';
    }
</script>