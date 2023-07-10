<!--sidebar end-->
<!--main content start-->
	<script>
	// alert("before");
	// $(document).ready(function () {

	// }); // ready
	</script>
	
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel col-md-9">
            <header class="panel-heading">
                <?php
                if (!empty($visite->id))
                    echo lang('add_depot');
                else
                    echo lang('add_depot');
                ?>
            </header>
            <div class="panel-body" id="depot">
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

                                        <div class="form-group col-md-5">
                                            <label for="exampleInputEmail1">Montant</label>
                                            <input class="form-control money" type="text" name="amount" id="amount" min="100" max="100000" value="" placeholder="" required autocompleted="off">
                                            <code id="montantID" class="flash_message" style="display:none">Cette valeur doit être comprise entre 100 et 100.000 FCFA</code>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="exampleInputEmail1">Vers Compte</label>
                                            <select class="form-control m-bot15" id="compteservice" name="compteservice" value=''>
                                                <option value="compteservice">Compte Service</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <table style="width:100%">
                                                <tr>
                                                    <th style="width: 50%;" colspan="2">
                                                        <div class="radio">
                                                            <label><input type="radio" id="orangemoney" name="choix" value="orangemoney" checked><strong class="grandeligne">Orange Money</strong></label>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 50%;" colspan="2">
                                                        <div class="radio">
                                                            <label><input type="radio" id="cartebancaire" name="choix" value="cartebancaire"><strong class="grandeligne">Carte Bancaire (Visa/Master Card)</strong></label>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 50%;">
                                                        <div class="radio disabled">
                                                            <label><input type="radio" id="cheque" name="choix" value="cheque" disabled><strong class="grandeligne">Chèque</strong></label>
                                                        </div>
                                                    </th>
                                                    <th style="width: 50%;">
                                                        <label><span class="petiteligne">Bientôt disponible</span></label>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 50%;">
                                                        <div class="radio disabled">
                                                            <label><input type="radio" id="cash" name="choix" value="cash" disabled><strong class="grandeligne">Récupération Cash</strong></label>
                                                        </div>
                                                    </th>
                                                    <th style="width: 50%;">
                                                        <label><span class="petiteligne">Bientôt disponible</span></label>
                                                    </th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="form-group col-md-10">
                                            <div class="form-group col-md-12" style="padding-top:20px">
                                                <button id="continuer" type="submit" name="submit" class="btn btn-info pull-right" style="margin-left:15px">Continuer</button>
												<a class="btn btn-info pull-right preview2" id="preview2" style="display:none;">Continuer</a>
                                                <a href="depot/operationFinanciere" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body" id="confirmation" style="display: none;">
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
                                        <label class="grandeligne">Vous êtes sur le point d’effectuer un dépôt Orange Money de <span id="montantConfirmation"></span> vers le compte service</label>
                                        <div class="form-group col-md-6" style="margin-top: 10px;">
                                            <label for="exampleInputEmail1">Numero compte orange money</label>
                                            <input type="text" class="form-control" name="mobNo" id="mobNo" value="" placeholder="" pattern="[0-9]{9}" required autocompleted="off">
                                            <code id="phoneID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>
                                        </div>
                                        <div class="form-group col-md-10">
                                            <div class="form-group col-md-12" style="padding-top:20px">
                                                <button id="validationOrange" type="submit" name="submit" class="btn btn-info pull-right" style="margin-left:15px">Continuer</button>
                                                <button id="retourOrange" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           <!-- <div class="panel-body" id="successCB" style="display: none;">
                <div class="alert alert-success text-center" style="display:none;" id="successWrapper">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <p id="successP"><?php // echo $this->session->flashdata('success'); ?></p>
                </div>
				<div class="form-group col-md-10">
					<div class="form-group col-md-12" style="padding-top:20px">-->
						<!--<button id="continuer" type="submit" name="submit" class="btn btn-info pull-right" style="margin-left:15px">Continuer</button>
						<a class="btn btn-info pull-right preview2" id="preview2" style="display:none;">Continuer</a>-->
						<!-- <a href="depot/ajoutdepot" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php // echo lang('submit_retour'); ?></a>-->
					<!--</div>
				</div>
            </div>-->
            <div class="col-md-12" id="validationdepotorange" style="display:none;padding-top:30px">
                <label class="grandeligne">Saisissez le code USSD suivant sur votre téléphone .</label>
                <label class="grandeligne">CODE USSD : <span id="msgussd"></span></label>
                <div class="form-group col-md-10" style="padding-top:20px">
                    <label class="grandeligne">Pour valider le dépôt, veuillez saisir le code de référence Orange Money et cliquez sur OK</label>
                    <label for="exampleInputEmail1" style="padding-top: 10px;">Code de référence</label>
                    <input type="text" class="form-control" name="mobRef" id="mobRef" value="" placeholder="" pattern="[0-9]{9}" required autocompleted="off" onkeyup="validation(event)">
                <code id="phoneID" class="flash_message" style="display:none">Veuillez respecter le format requis</code>
                </div>
                <div class="form-group col-md-10">
                    <button id="rediriger" type="submit" name="submit" class="btn btn-info pull-right">OK</button>
                    <button id="retourConfirmation" type="submit" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></button>
                </div>
            </div>
            <input hidden id="formCustmer" value="<?php echo !empty($id_partenaire_zuuluPay) ? $id_partenaire_zuuluPay : ""; ?>">
            <input hidden id="PIN" value="<?php echo !empty($pin_decrypted) ? $pin_decrypted : ""; ?>">
        </section>
        <!-- page end-->
    </section>
</section>

<a data-toggle="modal" href="#myModal" id="successCBTrigger">&nbsp;</a>


		
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">
					<div class="alert alert-success text-center" style="" id="successWrapper">
					<!--<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>-->
						<p id="successP"><?php // echo $this->session->flashdata('success'); ?></p>
					</div>
				</h4>
            </div> 
            <div class="modal-body">
                <div class="clearfix" method="post">
                    <section class="">
						<button type="button" class="btn btn-info btn-secondary pull-left" data-dismiss="modal">Retour</button>
                    </section>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
		
<!--main content end-->
<!--footer start-->
<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/paiement.js"></script>
<script  src="<?php echo base_url()?>common/js/jquery.LoadingBox.js"></script>
<script  src="<?php echo base_url()?>common/js/CommonFunctionFresh.js"></script>
<script  src="<?php echo base_url()?>common/js/xmltojson.js"></script>
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
		// $( "#successCBTrigger" ).trigger( "click" );
		// DEBUT ORABANK
		$("#cartebancaire").on("click", function() {
			$("#preview2").show();
			$("#continuer").hide();
		});
		$("#orangemoney").on("click", function() { // Prévoir click on other options: pour hide preview2
			$("#preview2").hide();
			$("#continuer").show();
		});
		
		<?php if($this->session->flashdata('response') && $this->session->flashdata('response') != "") {
		?>

		// alert("In Response handling");
		<?php $response = $this->session->flashdata('response');
		$success = (explode("|", $response["Transaction_Status_information"]))[1] == "SUCCESS" ? true : false;
		// Fetch partnerId
		$partnerId = $id_partenaire_zuuluPay;
		// Fetch partnerPIN
		$partnerPIN = $pin_decrypted;
		// Init Request Params (partially from response)
		$ttType = "CI";
		$transferTypeId = "1179";
		$reverse="true";
		$isLocal="true";
		// [Transaction_Response] => 111111|ZUULU1606901266|XOF|100000.00|CC|VISA|01
		$amount = (explode(".", ((explode("|", $response["Transaction_Response"]))[3])))[0];
		$FN="WP";
		$isExternal="true";
		$external_channel = "ORABANK";
		$status = $success ? "SUCCESS" : "FAILURE";
		$DataBlockBitmap = $response["DataBlockBitmap"];
		$Transaction_Response = $response["Transaction_Response"];
		$Transaction_related_information = $response["Transaction_related_information"];
		$Transaction_Status_information = $response["Transaction_Status_information"];
		$Merchant_Information = $response["Merchant_Information"] != "NULL" ? $response["Merchant_Information"] : "";
		$Fraud_Block = $response["Fraud_Block"] != "NULL" ? $response["Fraud_Block"] : "";
		$DCC_Block = $response["DCC_Block"] != "NULL" ? $response["DCC_Block"] : "";
		$Additional = $response["Additional"] != "NULL" ? $response["Additional"] : "";
		?>
			// alert("In Response 2");
			var partnerId = <?php echo json_encode($partnerId); ?>;
			// alert("partnerId: "+partnerId);
			// Fetch partnerPIN
			var partnerPIN = <?php echo json_encode($partnerPIN); ?>;
			// alert("partnerPIN: "+partnerPIN);
			// Init Request Params (partially from response)
			var ttType = <?php echo json_encode($ttType); ?>;
			var transferTypeId = <?php echo json_encode($transferTypeId); ?>;
			var reverse= <?php echo json_encode($reverse); ?>; 
			var isLocal= <?php echo json_encode($isLocal); ?>;
			var amount = <?php echo json_encode($amount); ?>;
			var FN= <?php echo json_encode($FN); ?>;
			var isExternal= <?php echo json_encode($isExternal); ?>;
			var external_channel = <?php echo json_encode($external_channel); ?>;
			var status = <?php echo json_encode($status); ?>;
			var DataBlockBitmap = <?php echo json_encode($DataBlockBitmap); ?>;
			var Transaction_Response = <?php echo json_encode($Transaction_Response); ?>;
			var Transaction_related_information = <?php echo json_encode($Transaction_related_information); ?>;
			var Transaction_Status_information = <?php echo json_encode($Transaction_Status_information); ?>;
			var Merchant_Information = <?php echo json_encode($Merchant_Information); ?>;
			var Fraud_Block = <?php echo json_encode($Fraud_Block); ?>;
			var DCC_Block = <?php echo json_encode($DCC_Block); ?>;
			var Additional = <?php echo json_encode($Additional); ?>;
			// alert("In Response Before call");
			
			depotCBToZuuluPay(partnerId, partnerPIN, ttType, transferTypeId, reverse, isLocal, amount, FN, isExternal, external_channel, status, DataBlockBitmap, Transaction_Response, Transaction_related_information, Transaction_Status_information, Merchant_Information, Fraud_Block, DCC_Block, Additional);
			// alert("In Response After call");
			
		// setTimeout(function(){
		  // lb.close();
		// }, 10000000);
		<?php } ?>
	  $('.preview2').on("click", function(){
		  // alert("clicked");
			var id = (new Date()).getTime();
			// var id = "payment_popup";
			
			  var w = screen.availWidth;
			  var h = screen.availHeight;
			// var myWindow = window.open('<?php echo base_url()?>depot/view_popup?montant='+$("#amount").val()+'', id,
	// "toolbar=no,scrollbars=yes,location=no,statusbar=no,menubar=no,resizable=no,width="+w+",height="+h+",left = 0,top = 0");
			
			var windowURL = <?php echo json_encode(base_url()); ?>;
			  windowURL += 'depot/view_popup?montant='+$("#amount").val();
			// var myWindow = window.open(windowURL, id, "width="+w+",height="+h+",left = 0,top = 0");
			var myWindow = window.open(windowURL, id, "width="+w+",height="+h+",left = 0,top = 0");
			
			// var getData = $("#montant").val();
			// $.get("http://127.0.0.1:8080/orab-standalone/bcit-ci-CodeIgniter-b73eb19/payment/view_popup", getData).done(function(htmlContent) {
				// myWindow.document.write(htmlContent);
				myWindow.focus();
			// });
			// myWindow.addEventListener("unload", function() { // CAUSES IT TO MISBEHAVE ON FIRFOX & SAFARI
			  // // myWindow.opener.location.reload();
			  // alert("Vous avez annulé votre transaction.");
			// });
			// myWindow.addEventListener("load", function() {
			  // alert($("#overlay").attr("style"));
		
			// });
			
			// var timer = setInterval(function() {   
				// if(myWindow.closed) {  
					// clearInterval(timer);  
					// alert('closed');  
					// myWindow.opener.location.reload(true)
				// }  
			// }, 1000); 
		}
	  );
		// e.preventDefault();
		// alert("1");
		<?php if($this->session->flashdata('requestParameter') && $this->session->flashdata('requestUrl')){ ?>
		// alert("2");
		// $( ".preview2" ).trigger( "click" );
		// alert("3");
		<?php } ?>
	  // }); // on
		
		//END ORABANK
        var bt = document.getElementById('rediriger');
        bt.disabled = true;
        $("#continuer").click(function(e) {
            if (document.getElementById('orangemoney').checked) {
                var errormontant = document.getElementById('montantID');
                var depot = document.getElementById('depot');
                var confirmation = document.getElementById('confirmation');
                var amount = $('#amount').val();
                document.querySelector("#montantConfirmation").innerHTML = amount + ' FCFA';
                amount = amount.replace(".", "").replace(".", "").replace(".", "");
                errormontant.style['display'] = 'none';
                if (parseInt(amount) < 100 || parseInt(amount) > 100000) {
                    errormontant.style['display'] = 'block';
                } else {
                    depot.style['display'] = 'none';
                    confirmation.style['display'] = 'block';
                }
            }

        });
        $("#rediriger").click(function(e) {
        var phone = $('#mobNo').val();
        var amount = $('#amount').val();
        var mobRef = $('#mobRef').val();
        var bt = document.getElementById('rediriger');
        bt.disabled = true;
        var phoneFormat = phone.replace(/[^\d]/g, '');
        amount = amount.replace(".", "").replace(".", "").replace(".", "");
        var type = 'depot';
        var description = 'Dépôt Orange Money';
        var statut = 'PENDING';
        var destinataire = 'Compte Service';
        $.ajax({
            url: 'depot/confirmationorangemoney?amount=' + amount + '&phone=' + phoneFormat + '&type=' + type + '&description=' + description + '&statut=' + statut + '&destinataire=' + destinataire + '&reference=' + mobRef,
            method: 'POST',
            data: '',
            dataType: 'json',
        }).success(function (response) {

        });
        window.location.href = 'depot/operationFinanciere';
        });

        $("#retourOrange").click(function(e) {
            var depot = document.getElementById('depot');
            var confirmation = document.getElementById('confirmation');
            depot.style['display'] = 'block';
            confirmation.style['display'] = 'none';
        });

        $("#retourConfirmation").click(function(e) {
            var depot = document.getElementById('depot');
            var validationdepotorange = document.getElementById('validationdepotorange');
            var confirmation = document.getElementById('confirmation');
            depot.style['display'] = 'none';
            validationdepotorange.style['display'] = 'none';
            confirmation.style['display'] = 'block';
        });

        $("#validationOrange").click(function(e) {
            var errormontant = document.getElementById('montantID');
            var depot = document.getElementById('depot');
            var errorphone = document.getElementById('phoneID');
            var formCustmer = $('#formCustmer').val();
            var validationdepotorange = document.getElementById('validationdepotorange');
            var pin = $('#PIN').val();
            var phone = $('#mobNo').val();
            var amount = $('#amount').val();
            var amountFormat = $('#amount').val();
            amount = amount.replace(".", "").replace(".", "").replace(".", "");
            var phoneFormat = phone.replace(/[^\d]/g, '');
            var nbreCaratere = phoneFormat.length;
            errorphone.style['display'] = 'none';
            if (nbreCaratere != 12) {
                errorphone.style['display'] = 'block';
            } else {
                depot.style['display'] = 'none';
                confirmation.style['display'] = 'none';
                validationdepotorange.style['display'] = 'block';
                var reponseAll = depotOrangeMoney("fr", amount, phoneFormat, formCustmer, pin);


            }
        });



    });
</script>
<script>
    function validation(event) {
        var bt = document.getElementById('rediriger');
        bt.disabled = true;
        var phone = $('#mobNo').val();
        var amount = $('#amount').val();
        var mobRef = $('#mobRef').val();
        var phoneFormat = phone.replace(/[^\d]/g, '');
        amount = amount.replace(".", "").replace(".", "").replace(".", "");
        var type = 'depot';
        var description = 'Dépôt Orange Money';
        var statut = 'PENDING';
        var destinataire = 'Compte Service';
        var nbreCaratere = phoneFormat.length;
        var ref = /PP\d{6}\.\d{4}\.[A-Z]\d{5}/.test(mobRef);
        if(ref == true){
            bt.disabled = false;
        }else{
            bt.disabled = true;
        }
    }
</script>
