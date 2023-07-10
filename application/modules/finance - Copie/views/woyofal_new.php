<section id="main-content">
    <section class="wrapper site-min-height">  
        <div id="success" class="top-nav" style="display: none">
            <code class="flashmessage pull-right"> Achat de Woyofal effectué avec succès</code>                
        </div>
        <!-- page start-->
        <section class="col-md-7">
            <header class="panel-heading">
                <?php
                if (!empty($category->id))
                    echo lang('service_woyofal');
                else
                    echo lang('service_woyofal');
                ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <?php echo validation_errors(); ?>
                        <div  id="achat"  style="display: block">
                            <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo lang('phoneNumber'); ?></label>
                                    <input type="text" class="form-control" name="mobNo" id="mobNo" value="" placeholder=""
                                    pattern="[0-9]{9}" required autocompleted="off">
                                    <!-- <small class="form-text text-muted">Format requis 786485686.
                                    </small> -->
                                    <code id="phoneID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>
                                </div> 
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo lang('numero_compteur'); ?></label>
                                    <input type="text" class="form-control" name="numeroCompteur" id="numeroCompteur" value="" placeholder=""
                                    pattern="[0-9]{9}" required autocompleted="off">
                                    <code id="compteurID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>   
                                </div> 
                                 
                                <div class="form-group">
                                    <label><?php echo lang('amountService'); ?></label>
                                    <input class="form-control money" type="text" name="amount"  id="amount" min="100" max="100000" value="" placeholder="" required autocompleted="off"> 
                                    <code id="montantID" class="flash_message" style="display:none">Cette valeur doit être compris entre 1.000 et 100.000 FCFA</code>     
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
                                    <label class="col-md-8 pull-left remove1">Numéro compteur</label>
                                    <label class="col-md-4 pull-right remove1" id="numCompteur"></label>
                                    <label class="col-md-8 pull-left remove1">Montant</label>
                                    <label class="col-md-4 pull-right remove1" id="amountconfirmation"></label>
                                    <label class="col-md-8 pull-left remove1">Frais</label>
                                    <label class="col-md-4 pull-right remove1"  id="feeAmount"></label>
                                    <label class="col-md-8 pull-left remove1">Total</label>
                                    <label class="col-md-4 pull-right remove1"id="totalconfirmation"></label>
                                    <input hidden type="text" id="convertmontant" name="montantfcfa" value="">
                                </div>
                                    <div class="form-group col-md-12" style="padding-top:20px">
                                        <button id="valider" type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit_effectuer'); ?></button>
                                        <button id="retourCredit" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></button>
                                    </div>
                                    
                                </div>
                        </div>
                        <div id="validationachat" style="display: none">
                        <div class="col-md-12">
                                    <label class="col-md-8 pull-left remove1">Numéro de Téléphone</label>
                                    <label class="col-md-4 pull-right remove1" id="phonevalidation"></label>
                                    <label class="col-md-8 pull-left remove1">Numéro Transaction</label>
                                    <label class="col-md-4 pull-right remove1" id="idTransaction"></label>
                                    <label class="col-md-8 pull-left remove1">Numéro Compteur</label>
                                    <label class="col-md-4 pull-right remove1" id="numeroCompteurWoyofal"></label>
                                    <label class="col-md-8 pull-left remove1">Code de recharge</label>
                                    <label class="col-md-4 pull-right remove1" id="codeRecharge"></label>
                                    <label class="col-md-8 pull-left remove1">Montant</label>
                                    <label class="col-md-4 pull-right remove1" id="amountconfirmationvalidation"></label>
                                </div>
                                <div class="form-group col-md-12" style="padding-top:20px">
                                        <a href="finance/expense" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour_service'); ?></a>
                                        
                                </div>
                                <div class="col-md-12">
                                         <code id="errorWoyofal" class="flash_message" style="display:none"></code>        
                                </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <code id="error" class="flash_message" style="display:none"></code>        
                </div>
                </div> 
                <input type="hidden" id="formCustmer" value="<?php echo !empty($id_partenaire_zuuluPay) ? $id_partenaire_zuuluPay : ""; ?>">
                <input type="hidden" id="PIN" value="<?php echo !empty($pin_decrypted) ? $pin_decrypted : ""; ?>">
            </div>
            
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->

<!--main content end-->
<!--footer start-->

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>
<script>
    var element = document.getElementById('mobNo');
    var compteur = document.getElementById('numeroCompteur');
    var maskOptions = {
        mask: "{(+221)} 00 000 00 00",
    lazy: false,
    };
    var maskCompt = {
        mask: "{} 0000-0000-000",
    lazy: false,
    };
    var mask = IMask(element, maskOptions);
    var maskCompteur = IMask(compteur, maskCompt);
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
    maximumValue : '100000',
    minimumValue : "1000",
decimalPlaces : 0,
    decimalCharacter : ',',
    digitGroupSeparator : '.'
});
</script>

<script type="text/javascript">
  $(document).ready(function () {
    var formCustmer = $('#formCustmer').val();
    var pin = $('#PIN').val();
    $("#retourCredit").click(function (e) {
        var achat = document.getElementById('achat');	
        var confirmationachat = document.getElementById('confirmationachat');
        achat.style['display'] = 'block';
        confirmationachat.style['display'] = 'none';
    });
   $("#submit").click(function (e) {
    var errorphone = document.getElementById('phoneID');
    var errormontant = document.getElementById('montantID');
    var compteurID = document.getElementById('compteurID');
    var phone = $('#mobNo').val();
    var amount = $('#amount').val();
    amount = amount.replace(".","").replace(".","").replace(".","");
        var numeroCompteur = $('#numeroCompteur').val();
        var phoneFormat = phone.replace(/[^\d]/g, '');
        var compteurFormat = numeroCompteur.replace(/[^\d]/g, '');
        var nbreCaratere = phoneFormat.length;
        var nbrecompteurFormat = compteurFormat.length;
        var nbrenumeroCompteur = numeroCompteur.length;
        errorphone.style['display'] = 'none';
        errormontant.style['display'] = 'none';
        compteurID.style['display'] = 'none';
        
        if(nbreCaratere != 12){
            errorphone.style['display'] = 'block';
        }
        else if(nbrecompteurFormat != 11){
            compteurID.style['display'] = 'block';
        }
        else if(parseInt(amount) < 1000 || parseInt(amount) > 100000){
            errormontant.style['display'] = 'block';
        }
        else{
            var phoneFormat = phone.replace(/[^\d]/g, '');
            var compteurFormat = numeroCompteur.replace(/[^\d]/g, '');
           // alert("le numeroTelephone"+phoneFormat+ " compteur : "+compteurFormat);
            var reponseAll =  loadDonsWoyofal("fr",phoneFormat,amount,compteurFormat,formCustmer,pin);
            console.log('-----------reponseAll---------------');
            console.log(reponseAll);
        }
        
       
            e.preventDefault(e);
          
            // $.ajax({
            //     url: 'finance/confirmationCredit',
            //     method: 'POST',
            //     data: '',
            //     dataType: 'json',
            // }).success(function (response) {
              
            // });
        });

   
        $("#valider").click(function (e) {
       var phoneFormat = $('#mobNo').val();
       var phone = phoneFormat.replace(/[^\d]/g, '');
        var amount = $('#amount').val();
        amount = amount.replace(".","").replace(".","").replace(".","");
        var formatCompteur = $('#numeroCompteur').val();
        var numeroCompteur = formatCompteur.replace(/[^\d]/g, '');
        var amountFCFA = $('#convertmontant').val();
       // alert("le numeroTelephone"+phone+ " compteur : "+numeroCompteur);
        var reponseAll =  validationWoyofal("fr",phone,amount,numeroCompteur,amountFCFA,formCustmer,pin);
		
            e.preventDefault(e);
         	
            // $.ajax({
            //     url: 'finance/confirmationCredit',
            //     method: 'POST',
            //     data: '',
            //     dataType: 'json',
            // }).success(function (response) {
              
            
                
                
            // });
        });
        
        
    });
  </script>