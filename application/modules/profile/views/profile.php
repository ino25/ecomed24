<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper site-min-height">
		<!-- page start-->
		<div class="col-md-7 row">
			<div class="thumbnail">
				<section class="panel">
					<header class="panel-heading">
						<?php echo lang('manage_profile'); ?>
					</header>
					<div class="panel-body">
						<div class="adv-table editable-table ">
							<div class="clearfix">

								<?php // echo validation_errors(); 
								?>
								<?php if (!empty(validation_errors())) { ?>
									<code class="" style=""> <?php echo validation_errors(); ?></code>
								<?php } ?>

								<?php if (!empty($display_errors)) { ?>
									<code class="" style=""> <?php echo $display_errors; ?></code>
								<?php } ?>

								<form role="form" action="profile/editProfilUser" class="clearfix" method="post" enctype="multipart/form-data">
									</fieldset>
									<div class="form-group">
										<label for="inputPrenom">Prenom</label>
										<input type="text" class="form-control" name="prenom" id="inputPrenom" value='<?php
																														if (!empty($setval)) {
																															echo set_value('prenom');
																														}
																														if (!empty($profile->first_name)) {
																															echo $profile->first_name;
																														}
																														?>' required readonly>
									</div>
									<div class="form-group">
										<label for="inputPrenom">Nom</label>
										<input type="text" class="form-control" name="nom" id="inputNom" value='<?php
																												if (!empty($setval)) {
																													echo set_value('nom');
																												}
																												if (!empty($profile->last_name)) {
																													echo $profile->last_name;
																												}
																												?>' required readonly>
									</div>
									<div class="form-group">
										<label for="inputImage"><?php echo lang('image'); ?></label>
										<input type="file" id="inputImage" name="img_url">
										<span class="help-block"><?php echo lang('recommended_size'); ?> : 225x225 pixels
											<?php
											if (!empty($profile->img_url)) {
											?><br /> Image Actuelle:<br /> <img class="avatar" style="max-width:50px;max-height:50px;" src="<?php echo base_url() . $profile->img_url;
																																			?> " /> <?php }
																																					?>
										</span>
									</div>
									<div class="form-group">
										<label for="inputPhone">Téléphone</label>
										<input type="number" class="form-control" name="phone" id="inputPhone" value='<?php
																														if (!empty($setval)) {
																															echo set_value('phone');
																														}
																														if (!empty($profile->phone)) {
																															echo $profile->phone;
																														}
																														?>' readonly>
									</div>
									<div class="form-group">
										<label for="inputEmail">Email</label>
										<input type="email" class="form-control" name="email" id="inputEmail" value='<?php
																														if (!empty($setval)) {
																															echo set_value('email');
																														}
																														if (!empty($profile->email)) {
																															echo $profile->email;
																														}
																														?>' required readonly>
									</div>
									<div class="form-group">
										<label for="inputPassword">Mot de passe</label>
										<input type="password" class="form-control" name="password" id="inputPassword" value='<?php
																																if (!empty($setval)) {
																																	echo set_value('password');
																																}
																																// if (!empty($user->password)) {
																																// echo $user->password;
																																// }
																																?>' <?php if (empty($profile->id)) { ?> required <?php } ?>>
									</div>
									<div class="form-group">
										<label for="inputAdresse">Adresse</label>
										<input type="text" class="form-control" name="adresse" id="inputAdresse" value='<?php
																														if (!empty($setval)) {
																															echo set_value('adresse');
																														}
																														if (!empty($profile->adresse)) {
																															echo $profile->adresse;
																														}
																														?>' required>
									</div>
									</fieldset>
									<!-- <fieldset>
									<div class="form-group">
										<label for="inputRegion">R&eacute;gion</label>
										<select class="form-control" name="region" id="inputRegion" required>
											<option value="Veuillez sélectionner une région" data-extravalue="Veuillez sélectionner une région">Veuillez sélectionner une région</option>
											<?php foreach ($regions_senegal as $region) : ?>
											<option value="<?php echo $region->label; ?>" data-extravalue="<?php echo $region->id; ?>"
											<?php
												if (!empty($setval) && set_value('region') == $region->label) {
													echo 'selected';
												}
												if (!empty($profile->region) && $profile->region == $region->label) {
													echo 'selected';
												}
											?>
											><?php echo $region->label; ?></option>
											<?php endforeach; ?>
											<?php //if ((!empty($setval) && !empty(set_value("region"))) || !empty($organisation->region)) { 
											?> <script>//alert("before");fnRegionChange;alert("after");	</script> <?php //} 
																														?>
										</select>
									</div>
									<div class="form-group">
										<label for="inputDepartement">D&eacute;partement</label>
										<select class="form-control" name="departement" id="inputDepartement" required>
											<option value="---" data-extravalue="---">---</option>
										</select>
									</div>
									<div class="form-group">
										<label for="inputArrondissement">Arrondissement</label>
										<select class="form-control" name="arrondissement" id="inputArrondissement" required>
											<option value="---" data-extravalue="---">---</option>
										</select>
									</div>
									<div class="form-group">
										<label for="inputCollectivite">Collectivit&eacute;</label>
										<select class="form-control" name="collectivite" id="inputCollectivite" required>
											<option value="---" data-extravalue="---">---</option>
										</select>
									</div>
									<div class="form-group">
										<label for="inputPays">Pays</label>
										<select class="form-control" name="pays" id="inputPays" required>
											<option value="Senegal">Senegal</option>
										</select>
									</div>
								</fieldset> -->

									<input type="hidden" name="groupe" value='<?php
																				if (!empty($setval)) {
																					echo set_value('groupe');
																				}
																				if (!empty($profile->groupe)) {
																					echo $profile->groupe;
																				}
																				?>'>

									<input type="hidden" name="id" value='<?php
																			if (!empty($setval)) {
																				echo set_value('id');
																			}
																			if (!empty($profile->id)) {
																				echo $profile->id;
																			}
																			?>'>

									<div class="form-group">
										<a id="" class="btn btn-info btn-secondary pull-left" href="home">
											Retour
										</a>
										<button type="submit" name="submit" class="btn btn-primary pull-right"><?php echo lang('edit'); ?></button>
									</div>
								</form>
							</div>
						</div>

					</div>
				</section>
			</div>
		</div>
		<div class="col-sm-5">
			<div class="thumbnail">
				<header class="panel-heading">
					Télécharger la signature
				</header>
				<div class="panel-body">

					<?php
					//print_r($user_signature);
					//echo empty($user_signature);
					if (count($user_signature) > 0) {
					?>
						<div class="form-group">
							<label for="inputPin">Entrez le code PIN de signature pour afficher</label>
							<input type="password" id="inputPinView" class="form-control" name="input" onkeyup="inputPinView(event)" autocomplete="off">
							<input type="hidden" id="inputPinViewSHA1" class="form-control" name="inputPin">
						</div>
						<input id="docid" type="hidden" name="docid" value='<?php
																			if (!empty($setval)) {
																				echo set_value('id');
																			}
																			if (!empty($profile->id)) {
																				echo $profile->id;
																			}
																			?>'>
						<p class='error pull-left'></p>

						<div class="error_pinview" style="display:none;font-weight: bold ; color:red; font-family: Verdana, Geneva, Tahoma, sans-serif;">
							<h5></h5>
						</div>


						<!-- <button id="signUploadView" type="button" class="btn-xs btn-info signUploadView" name="submit" class="btn btn-primary pull-right"><span class='looading'> <i class="fa fa-spinner fa-eyes" style='display:none'></i> </span> Voir</button> -->
						<button id="signUploadView" type="submit" name="submit" class="btn btn-primary"><span class='looading'> <i class="fa fa-eye" aria-hidden="true"></i></i> </span> Voir</button>

						<div class="sign"></div>

						<!-- <button type="submit" name="submit" class="btn btn-primary pull-right" id='signUpload'><span class='looading'> <i class="fa fa-spinner fa-spin" style='display:none'></i> </span> Afficher</button> -->


					<?php } else { ?>
						<form role="form" action="profile/uploadSign" class="clearfix" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label for="inputsign">Signature</label>
								<input type="file" id="inputsign" class="form-control" name="inputsign" accept=".jpg, .jpeg, .png">
								<span class="help-block">Formats pris en charge e.g <span style="color:green">jpg,jpeg,gif,png</span>. Et la taille doit être <span style="color:red">5mb</span>. </span>
							</div>
							<div class="form-group">
								<label for="inputPin">Signature PIN</label>
								<input type="password" id="inputPin" class="form-control" name="input" onkeyup="inputSigne(event)">
								<input type="hidden" id="inputPinSHA1" class="form-control" name="inputPin">
								<span class="help-block">Définir un code PIN sécurisé. </span>
							</div>
							<div class="form-group">
								<input type="hidden" name="docid" value='<?php
																			if (!empty($setval)) {
																				echo set_value('id');
																			}
																			if (!empty($profile->id)) {
																				echo $profile->id;
																			}
																			?>'>
								<div class="error_pin" style="display:none;font-weight: bold ; color:red; font-family: Verdana, Geneva, Tahoma, sans-serif;">
									<h5></h5>
								</div>
								<button type="submit" name="submit" class="btn btn-primary pull-right" id='signUpload'><span class='looading'> <i class="fa fa-spinner fa-spin" style='display:none'></i> </span> Télécharger</button>
							</div>

						</form>
					<?php } ?>
				</div>
			</div>
		</div>
		<!-- page end-->
	</section>
</section>
<!--main content end-->
<!--footer start-->
<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>


<script type="text/javascript">
	$(document).ready(function() {
		$("#signUploadView").click(function(e) {
			var docid = $("#docid").val();
			var pin = $("#inputPinViewSHA1").val();
			pin = SHA1(pin);
			// alert('profile/viewSign?docid=' + docid + '&pin=' + pin);
			const danger = document.querySelector(".error_pinview");
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
					
					danger.innerHTML = `<strong>${response.message}</strong>`;
					//$('.error').css('color', 'red').text(response.message);
				} else {
					var data = response.user_signature;

					$('.sign').html('<img src="' + data[0].sign_name + '" width="100%" alt="signature" class="tumbnail">');
					$('#signUpload').text('View');
				}
			});
		});

	});
</script>
<script>
	$(document).ready(function() {

		// $("#mysignform").validate({
		// 		rules: {
		// 			inputsign: {
		// 				required: true,
		// 			},
		// 			inputPin: {
		// 				required: true,
		// 				minlength: 6,
		// 				maxlength: 6,
		// 				digits: true
		// 			}
		// 		},
		// 		messages: {
		// 			inputsign: {
		// 				required: "Please add valid signature"
		// 			},
		// 			inputPin: {
		// 				required: "Please set a secure PIN & digits only",
		// 				minlength:"Please enter 6 digits ",
		// 				maxlength:"Please enter 6 digits "
		// 			}
		// 		},
		// 		submitHandler: function (form) { // for demo
		// 		   var formdata = new FormData($('#mysignform')[0]);
		// 		   //console.log();
		// 		   //formdata.append('notes',CKEDITOR.instances['note_desc'].getData());
		// 			$.ajax({
		// 				url: 'Profile/uploadSign',
		// 				data : formdata,
		// 				contentType: false,
		// 				processData: false,
		// 				type : "post",
		// 				dataType : "json",
		// 				beforeSend:function(){
		// 					$('.looading').show();
		// 					$('#signUpload').prop('disabled',true);

		// 				},
		// 				success : function(response) {
		// 					$('.looading').hide();
		// 					$("#mysignform")[0].reset();
		// 					//$('#signUpload').prop('disabled',false);
		// 					if(response.error ){
		// 						$('#signUpload').text('Try Later');
		// 					}else{
		// 						$('#signUpload').text('Signature Uploaded');
		// 					}

		// 				}
		// 			});
		// 		}
		// });



		// $("#mysignformview").validate({
		// 	rules: {
		// 		inputPin: {
		// 			required: true,
		// 			minlength: 6,
		// 			maxlength: 6,
		// 			digits: true
		// 		}
		// 	},
		// 	messages: {
		// 		inputPin: {
		// 			required: "Please Enter 6 digits PIN",
		// 			minlength: "Please enter 6 digits",
		// 			maxlength: "Please enter 6 digits"
		// 		}
		// 	},
		// 	submitHandler: function(form) { // for demo
		// 		var formdata = new FormData($('#mysignformview')[0]);
		// 		//console.log();
		// 		//formdata.append('notes',CKEDITOR.instances['note_desc'].getData());
		// 		$.ajax({
		// 			url: 'Profile/viewSign',
		// 			data: formdata,
		// 			contentType: false,
		// 			processData: false,
		// 			type: "post",
		// 			dataType: "json",
		// 			beforeSend: function() {
		// 				$('.looading').show();
		// 				$('#signUpload').prop('disabled', true);
		// 			},
		// 			success: function(response) {
		// 				$('.looading').hide();
		// 				$("#mysignformview")[0].reset();
		// 				$('#signUpload').prop('disabled', false);
		// 				if (response.error) {
		// 					$('.sign').html('');
		// 					$('.error').css('color', 'red').text(response.message);
		// 				} else {
		// 					var data = response.user_signature;

		// 					$('.sign').html('<img src="' + data[0].sign_name + '" width="100%" alt="signature" class="tumbnail">');
		// 					$('#signUpload').text('View');
		// 				}

		// 			}
		// 		});
		// 	}
		// });

		$(document).on('keypress', '#inputPin', function() {

			$('.error').text('');

		})

	});
</script>

<script>
	// alert("before");
	// var emptySetVal = <?php echo (int)empty($setval); ?>;
	// alert(emptySetVal);
	var setValRegion = <?php echo json_encode(!empty($setval) ? set_value("region") : ""); ?>;
	// alert("setValRegion: " + setValRegion);
	var setValDepartment = <?php echo json_encode(!empty($setval) ? set_value("departement") : "") ?>;
	// alert("setValDepartment:" + setValDepartment);
	var setValArrondissement = <?php echo json_encode(!empty($setval) ? set_value("arrondissement") : "") ?>;
	// alert("setValArrondissement: " + setValArrondissement);
	var setValCollectivite = <?php echo json_encode(!empty($setval) ? set_value("collectivite") : "") ?>;
	// alert("setValCollectivite: "+setValCollectivite);

	// var emptyOrganisation = <?php echo (int)(!empty($user->id) ? $user->id : "0"); ?>
	// alert("emptyOrganisation: " + emptyOrganisation);
	var userRegion = <?php echo json_encode(!empty($profile->region) ? $profile->region : "") ?>;
	// alert("organisationRegion: " + organisationRegion);
	var userDepartement = <?php echo json_encode(!empty($profile->departement) ? $profile->departement : "") ?>;
	// alert("organisationDepartement: "+organisationDepartement);
	var userArrondissement = <?php echo json_encode(!empty($profile->arrondissement) ? $profile->arrondissement : "") ?>;
	// alert("organisationArrondissement: "+organisationArrondissement);
	var userCollectivite = <?php echo json_encode(!empty($profile->collectivite) ? $profile->collectivite : "") ?>;
	// alert("organisationCollectivite: "+organisationCollectivite);

	// idRegionBuff = "---";
	// idDepartementBuff = "---";
	// idArrondissementBuff = "---";

	function inputSigne(event) {

		var pin = $("#inputPin").val();
		var pinSHA1 = SHA1(pin);
		var bt = document.getElementById('signUpload');
		const danger = document.querySelector(".error_pin");
		danger.style.display = ""
		if (pin.length == 6) {
			danger.style.display = "none";
			document.getElementById('inputPinSHA1').value = pinSHA1;
			bt.disabled = false;
		} else {

			danger.innerHTML = `<strong>Veuillez entrer 6 chiffres</strong>`;
			bt.disabled = true;
		}

	}


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

	function fnRegionChange() {
		var idDepartementBuff = "";
		// alert("during");
		// var id=$(this).val();
		// var id=$("option:selected", this).attr("data-extravalue"); // Worked with changed event
		var id = $("option:selected", $(document).find("#inputRegion")).attr("data-extravalue"); // Works with both Change and onLoad
		// alert(id);
		$.ajax({
			url: "<?php echo site_url('home/getDepartementsByRegion'); ?>",
			method: "POST",
			data: {
				id: id
			},
			async: false,
			dataType: 'json',
			success: function(data) {
				var html = '<option value="Veuillez sélectionner un département" data-extravalue="Veuillez sélectionner un département" selected>Veuillez sélectionner un département</option>';
				var i;
				for (i = 0; i < data.length; i++) {
					html += '<option value=\'' + data[i].label + '\' data-extravalue=\'' + data[i].id + '\'';
					if (setValDepartment == data[i].label) {
						html += ' selected';
						idDepartementBuff = data[i].id;
					}
					if (userDepartement == data[i].label) {
						html += ' selected';
						// alert("found matching Departement");
						idDepartementBuff = data[i].id;
					}
					html += '>' + data[i].label + '</option>';
				}
				$('#inputDepartement').html(html);

			}
		});
		return idDepartementBuff;
	};


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


	function fnDepartementChange(id) {
		var idArrondissementBuff = "";
		// var id=$(this).val();
		// var id=$("option:selected", this).attr("data-extravalue");
		// var id=$("option:selected", $(document).find("#inputDepartement")).attr("data-extravalue");
		var id = id != "" ? id : $("option:selected", $(document).find("#inputDepartement")).attr("data-extravalue"); // Contien Id departementBuff
		// alert(id);
		$.ajax({
			url: "<?php echo site_url('home/getArrondissementsByDepartement'); ?>",
			method: "POST",
			data: {
				id: id
			},
			async: false,
			dataType: 'json',
			success: function(data) {
				var html = '<option value="Veuillez sélectionner un arrondissement" data-extravalue="Veuillez sélectionner un arrondissement" selected>Veuillez sélectionner un arrondissement</option>';
				var i;
				for (i = 0; i < data.length; i++) {
					html += '<option value=\'' + data[i].label + '\' data-extravalue=\'' + data[i].id + '\'';
					// alert(organisationArrondissement);
					// alert(data[i].label);
					if (setValArrondissement == data[i].label) {
						html += ' selected';
						idArrondissementBuff = data[i].id;
					}
					if (userArrondissement == data[i].label) {
						html += ' selected';
						// alert("found matching Arrondissement");
						idArrondissementBuff = data[i].id;
					}
					html += '>' + data[i].label + '</option>';
				}
				$('#inputArrondissement').html(html);

			}
		});
		return idArrondissementBuff;
	};

	function fnArrondissementChange(id) {
		// var id=$(this).val();
		// var id=$("option:selected", this).attr("data-extravalue");
		// var id=$("option:selected", $(document).find("#inputArrondissement")).attr("data-extravalue");
		var id = id != "" ? id : $("option:selected", $(document).find("#inputArrondissement")).attr("data-extravalue");
		// alert(id);
		$.ajax({
			url: "<?php echo site_url('home/getCollectivitesByArrondissement'); ?>",
			method: "POST",
			data: {
				id: id
			},
			async: false,
			dataType: 'json',
			success: function(data) {
				var html = '<option value="Veuillez sélectionner une collectivité" data-extravalue="Veuillez sélectionner une collectivité" selected>Veuillez sélectionner une collectivité</option>';
				var i;
				for (i = 0; i < data.length; i++) {
					html += '<option value=\'' + data[i].label + '\' data-extravalue=\'' + data[i].id + '\'';
					if (setValCollectivite == data[i].label) {
						html += ' selected';
					}
					if (userCollectivite == data[i].label) {
						html += ' selected';
					}
					html += '>' + data[i].label + '</option>';
				}
				$('#inputCollectivite').html(html);

			}
		});
		return false;
	};

	$(document).ready(function() {
		var idDepartementBuff;
		var idArrondissementBuff;
		<?php if ((!empty($setval) && !empty(set_value("region"))) || !empty($profile->region)) { ?>
			// alert("region present");
			// $(document).find("#inputDepartement").children().remove();
			idDepartementBuff = fnRegionChange();
			// alert("afterRegionChange");
		<?php } ?>
		<?php if ((!empty($setval) && !empty(set_value("departement"))) || !empty($profile->departement)) { ?>
			// $(document).find("#inputArrondissement").children().remove();
			// alert("idDepartementBuff: " +idDepartementBuff);
			idArrondissementBuff = fnDepartementChange(idDepartementBuff);
		<?php } ?>
		<?php if ((!empty($setval) && !empty(set_value("arrondissement"))) || !empty($profile->arrondissement)) { ?>
			// $(document).find("#inputCollectivite").children().remove();
			// alert("idArrondissementBuff: " +idArrondissementBuff);
			fnArrondissementChange(idArrondissementBuff);
		<?php } ?>
		// Gestion Listes Regions/Departements/Arrondissement/Collectivite au changement
		$('#inputRegion').on("change", function() {
			idDepartementBuff = fnRegionChange();
		});
		$('#inputDepartement').on("change", function() {
			idArrondissementBuff = fnDepartementChange(idDepartementBuff);
		});
		$('#inputArrondissement').on("change", function() {
			fnArrondissementChange(idArrondissementBuff);
		});
	});
</script>