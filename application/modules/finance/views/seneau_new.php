<style>
        input[type=number] {
            -moz-appearance: textfield;
        }

        /* Chrome */
        input::-webkit-inner-spin-button,
        input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Opéra*/
        input::-o-inner-spin-button,
        input::-o-outer-spin-button {
            -o-appearance: none;
            margin: 0
        }
</style>
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="top-nav">
            <code id="success" style="display:none" class="flashmessage pull-right"> Paiement SenEau effectué avec succès</code>                
        </div>
        <div id="reference" style="display: block">
            <section class="col-md-7">
                <header class="panel-heading">
                    <?php
                    if (!empty($category->id))
                        echo lang('service_seneau');
                    else
                        echo lang('service_seneau');
                    ?>
                </header>
                <div class="panel-body">
                    <div class="adv-table editable-table ">
                        <div class="clearfix">
                            <?php echo validation_errors(); ?>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Référence Client</label>
                                    <input type="number" class="form-control" name="customerReference" id="customerReference" value="" placeholder=""
                                    pattern="[0-9]{9}" required autocompleted="off">
                                    <code id="compteurID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>   
                                </div>
                                <div class="form-group col-md-12">
                                    <button id="submit" type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit_continuer'); ?></button>
                                    <a href="finance/menuService" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></a>
                                </div>
                            <div class="col-md-12">
                                <code id="error" class="flash_message" style="display:none"></code>        
                            </div>
                        </div>
                        <input type="hidden" id="formCustmer" value="<?php echo !empty($id_partenaire_zuuluPay) ? $id_partenaire_zuuluPay : ""; ?>">
                        <input type="hidden" id="PIN" value="<?php echo !empty($pin_decrypted) ? $pin_decrypted : ""; ?>">
                    </div>
                </div> 
            </section>
        </div>
        <div id="frais" style="display:none">
            <section class="col-md-9">
                <header class="panel-heading">
                    <?php
                    if (!empty($category->id))
                        echo lang('service_seneau');
                    else
                        echo lang('service_seneau');
                    ?>
                </header>
                <div class="panel-body">
                    <div class="adv-table editable-table ">
                        <div class="clearfix">
                                <div class="col-md-12">
                                    <label class="col-md-6 pull-left remove1">Nom client</label>
                                    <label class="col-md-6 pull-right remove1" id="nomClient" style="padding-top:-5px"></label>
                                    <div id="cacherNumeroTransaction" style="display:none">
                                        <label class="col-md-6 pull-left remove1">Numéro de transaction</label>
                                        <label class="col-md-6 pull-right remove1" id="idTransaction"></label>
                                        <label class="col-md-6 pull-left remove1">Date & Heure</label>
                                        <label class="col-md-6 pull-right remove1" id="dateHeure"></label>
                                    </div>
                                    <label class="col-md-6 pull-left remove1">Référence Client</label>
                                    <label class="col-md-6 pull-right remove1" id="referenceFacture"></label>
                                    <label class="col-md-6 pull-left remove1">Numéro de facture</label>
                                    <label class="col-md-6 pull-right remove1" id="numeroFacture"></label>
                                    <label class="col-md-6 pull-left remove1">Date d'échéance</label>
                                    <label class="col-md-6 pull-right remove1" id="delaiPaiement"></label>
                                    <label class="col-md-6 pull-left remove1">Montant</label>
                                    <label class="col-md-6 pull-right remove1" id="montantFacture"></label>
                                    <label class="col-md-6 pull-left remove1">Frais</label>
                                    <label class="col-md-6 pull-right remove1"  id="fraisFacture"></label>
                                    <label class="col-md-6 pull-left remove1">Total</label>
                                    <label class="col-md-6 pull-right remove1"id="totalconfirmation"></label>
                                    <input hidden type="text" id="convertmontant" name="montantfcfa" value="">
                                    <input hidden type="text" id="hiddenReferenceFacture" name="hiddenReferenceFacture" value="">
                                    <input hidden type="text" id="hiddenNumeroFacture" name="hiddenNumeroFacture" value="">
                                    <input hidden type="text" id="hiddenIdFacture" name="hiddenIdFacture" value="">
                                    <input hidden type="text" id="hiddenAmount" name="hiddenAmount" value="">
                                    <input hidden type="text" id="hiddenClient" name="hiddenClient" value="">
                                    <div id="cacherBouton">
                                        <div class="form-group col-md-12" style="padding-top:20px">
                                            <button onclick="validationSeneau()" name="submit" class="btn btn-info pull-right"><?php echo lang('submit_effectuer'); ?></button>
                                            <button id="retourInvoice" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></button>
                                        </div>
                                    </div>
                                    <div id="menuservice" style="display:none">
                                        <div class="form-group col-md-12" style="padding-top:20px">
                                            <a href="finance/expense" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour_service'); ?></a>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                         <code id="errorSenEau" class="flash_message" style="display:none"></code>        
                                    </div>
                                </div>
                        </div>
                    </div>
                </div> 
            </section>
        </div>
        <div id="factures"  style="display:none">
            <section class="col-md-12">
                <header class="panel-heading">
                    <?php
                    if (!empty($category->id))
                        echo lang('service_seneau');
                    else
                        echo lang('service_seneau');
                    ?>
                </header>
                <div class="panel-body">
                    <div class="adv-table editable-table ">
                        <div class="space15"></div>
                            <table class="table table-hover progress-table text-center">
                                <thead>
                                    <tr>
                                        <th><?php echo lang('client_service'); ?></th>
                                        <th><?php echo lang('montant_facture'); ?></th>
                                        <th><?php echo lang('invoice_id'); ?></th>
                                        <th><?php echo lang('delai_facture'); ?></th>
                                        <th class="option_th no-print"><?php echo lang('action_service'); ?></th>
                                    </tr>
                                </thead>
                                <tbody id="exemple">
                                    <style>
                                        .img_url{
                                            height:20px;
                                            width:20px;
                                            background-size: contain; 
                                            max-height:20px;
                                            border-radius: 100px;
                                        }
                                        .option_th{
                                            width:18%;
                                        }
                                    </style>
                                </tbody>
                            </table>
                            <div class="form-group col-md-12" style="padding-top:20px">
                                <button id="retourCredit" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></button>
                            </div>
                        </div>
                        
                    </div>
            </div>
        </section>
                       
        </div>
    </section>
</section>
<input hidden name="invoiceHidden" id="invoiceHidden" type="text" value="">
<!--main content end-->
<!--footer start-->
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>
<script> 

 $(document).ready(function () {
    var autoNumericInstance = new AutoNumeric.multiple('.money', {
    // currencySymbol: "Fcfa",
    // currencySymbolPlacement: "s",
// emptyInputBehavior: "min",
// selectNumberOnly: true,
// selectOnFocus: true,
// overrideMinMaxLimits: 'invalid',
// emptyInputBehavior: "min",
//     maximumValue : '100000',
//     minimumValue : "1000",
decimalPlaces : 0,
    decimalCharacter : ',',
    digitGroupSeparator : '.'
});
 });

</script>
<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    var formCustmer = $('#formCustmer').val();
    var pin = $('#PIN').val();
    $("#retourInvoice").click(function (e) {
        var reference = document.getElementById('reference');	
        var factures = document.getElementById('factures');
        var frais = document.getElementById('frais');
        
        reference.style['display'] = 'none';
        factures.style['display'] = 'block';
        frais.style['display'] = 'none';
    });
    $("#retourCredit").click(function (e) {
        var reference = document.getElementById('reference');	
        var factures = document.getElementById('factures');
        reference.style['display'] = 'block';
        factures.style['display'] = 'none';
    });
   $("#submit").click(function (e) {
    var compteurID = document.getElementById('compteurID');
    var customerReference = $('#customerReference').val();
    var nbreCustomerReference = customerReference.length;
    if(nbreCustomerReference < 4){
            compteurID.style['display'] = 'block';
        }
        else{
            var reponseAll =  invoiceSenEau("fr",customerReference,formCustmer,pin);
            console.log('-----------reponseAll---------------');
            console.log(reponseAll);
        }
        
       
            e.preventDefault(e);
          
        });  
    });
  </script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>

