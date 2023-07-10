<!--sidebar end-->
<!--main content start-->
<script type="text/javascript" src="<?php echo base_url(); ?>common/js/google-loader.js"></script>
<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>

<section id="main-content">
	<section class="wrapper site-min-height">
		<!-- page start-->
		<section class="col-md-7">
			<div class="thumbnail">
				<section class="panel">
					<header class="panel-heading">
						<?php
						if (!empty($user->id)) {
							echo "Modifier mes infos";
							// print_r($user);
						} else {
							echo "Ajouter un utilisateur";
							// echo var_dump($organisation);
							// echo (int)empty($organisation->id);
							// echo (int)is_null($organisation->id);
						}
						?>
					</header>

					<?php
					$self_page = !empty($user->id) && $this->session->userdata["email"] == $user->email;
					?>
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

								<form role="form" action="profile/addNonProfil" class="clearfix" method="post" enctype="multipart/form-data">


									<?php
									// echo set_value('id_service');
									// echo set_value('service');
									// echo var_dump($setval);
									// echo var_dump($setting_services);
									?>

									<?php
									// echo var_dump($setting_services);
									// foreach($setting_services as $service)
									// {

									// echo $service->idservice;
									// echo $service->name_service;

									// }
									?>
									<fieldset>
										<input type="hidden" name="groupe" value="<?php echo $user->groupe ?>">
										<!-- <div style="display: none;">
							   <div class="col-md-12 panel">
									<div class="form-group  col-md-6">
										<label for="inputGroupe">Rôle</label>
										<select  class="form-control" name="groupe" id="inputGroupe" required>
											<option value="Veuillez sélectionner un rôle" selected>Veuillez sélectionner un rôle</option>
											<option value="1" <?php
																if (!empty($setval) && set_value('groupe') == "1") {
																	echo 'selected';
																}
																if (!empty($user->groupe) && $user->groupe == "1") {
																	echo 'selected';
																}
																?>>Administrateur</option>
											<option value="11" <?php
																if (!empty($setval) && set_value('groupe') == "11") {
																	echo 'selected';
																}
																if (!empty($user->groupe) && $user->groupe == "11") {
																	echo 'selected';
																}
																?>><?php echo lang('adminmedecin'); ?></option>

											<option value="4" <?php
																if (!empty($setval) && set_value('groupe') == "4") {
																	echo 'selected';
																}
																if (!empty($user->groupe) && $user->groupe == "4") {
																	echo 'selected';
																}
																?>>Médecin</option>
											<option value="3" <?php
																if (!empty($setval) && set_value('groupe') == "3") {
																	echo 'selected';
																}
																if (!empty($user->groupe) && $user->groupe == "3") {
																	echo 'selected';
																}
																?>>Comptable</option>
											<option value="6" <?php
																if (!empty($setval) && set_value('groupe') == "6") {
																	echo 'selected';
																}
																if (!empty($user->groupe) && $user->groupe == "6") {
																	echo 'selected';
																}
																?>>Infirmière</option>
											<option value="7" <?php
																if (!empty($setval) && set_value('groupe') == "7") {
																	echo 'selected';
																}
																if (!empty($user->groupe) && $user->groupe == "7") {
																	echo 'selected';
																}
																?>>Pharmacien</option>
											<option value="8" <?php
																if (!empty($setval) && set_value('groupe') == "8") {
																	echo 'selected';
																}
																if (!empty($user->groupe) && $user->groupe == "8") {
																	echo 'selected';
																}
																?>>Technicien de Laboratoire</option>
											<option value="10" <?php
																if (!empty($setval) && set_value('groupe') == "10") {
																	echo 'selected';
																}
																if (!empty($user->groupe) && $user->groupe == "10") {
																	echo 'selected';
																}
																?>>Réceptionniste</option>
										</select>
									</div>

									<div class="form-group col-md-6">
										<label for="exampleInputEmail1"> <?php echo lang('service'); ?></label>
										<select class="form-control m-bot15  add_service" id="idservice_add" name="service">

											<?php if (!empty($service)) {  ?>
												<option value="<?php echo $service; ?>"> <?php echo $name_service; ?> </option>
											<?php } ?>
										</select>
									</div>
								</div>
							   </div> -->

										<div class="col-md-12 panel">
											<div class="form-group col-md-6">
												<label for="inputPrenom">Prenom</label>
												<input type="text" class="form-control" name="prenom" id="inputPrenom" value='<?php
																																if (!empty($setval)) {
																																	echo set_value('prenom');
																																}
																																if (!empty($user->first_name)) {
																																	echo $user->first_name;
																																}
																																?>' required <?php if ($self_page) { ?> readonly <?php } ?>>
											</div>
											<div class="form-group  col-md-6">
												<label for="inputPrenom">Nom</label>
												<input type="text" class="form-control" name="nom" id="inputNom" value='<?php
																														if (!empty($setval)) {
																															echo set_value('nom');
																														}
																														if (!empty($user->last_name)) {
																															echo $user->last_name;
																														}
																														?>' required <?php if ($self_page) { ?> readonly <?php } ?>>
											</div>
										</div>
										<div class="col-md-12 panel">
											<div class="form-group  col-md-6">
												<label for="inputImage"><?php echo lang('image'); ?></label>
												<input type="file" id="inputImage" name="img_url">
												<span class="help-block"><?php echo lang('recommended_size'); ?> : 225x225 pixels
													<?php
													if (!empty($user->img_url)) {
													?><br /> Image Actuelle:<br /> <img class="avatar" style="max-width:50px;max-height:50px;" src="<?php echo base_url() . $user->img_url;
																																					?> " /> <?php }
																																					?>
												</span>
											</div>
											<div class="form-group  col-md-6">
												<label for="inputPhone">Téléphone</label>
												<input type="number" class="form-control" name="phone" id="inputPhone" value='<?php
																																if (!empty($setval)) {
																																	echo set_value('phone');
																																}
																																if (!empty($user->phone)) {
																																	echo $user->phone;
																																}
																																?>' <?php if ($self_page) { ?> readonly <?php } ?>>
											</div>
										</div>
										<div class="col-md-12 panel">
											<div class="form-group  col-md-6">
												<label for="inputEmail">Email</label>
												<input type="email" class="form-control" name="email" id="inputEmail" value='<?php
																																if (!empty($setval)) {
																																	echo set_value('email');
																																}
																																if (!empty($user->email)) {
																																	echo $user->email;
																																}
																																?>' required <?php if ($self_page) { ?> readonly <?php } ?>>
											</div>
											<div class="form-group  col-md-6">
												<label for="inputPassword">Mot de passe</label>
												<input type="password" class="form-control" name="password" id="inputPassword" value='<?php
																																		if (!empty($setval)) {
																																			echo set_value('password');
																																		}
																																		// if (!empty($user->password)) {
																																		// echo $user->password;
																																		// }
																																		?>' <?php if (empty($user->id)) { ?> required <?php } ?>>
											</div>
										</div>
										<div class="form-group  col-md-6">
											<label for="inputAdresse">Adresse</label>
											<input type="text" class="form-control" name="adresse" id="inputAdresse" value='<?php
																															if (!empty($setval)) {
																																echo set_value('adresse');
																															}
																															if (!empty($user->adresse)) {
																																echo $user->adresse;
																															}
																															?>' required>
										</div>
										<div style="display: none;">
											<div class="form-group  col-md-6">
												<label for="inputPays">Pays</label>
												<select class="form-control" name="pays" id="inputPays">
													<option value="Senegal">Senegal</option>
												</select>
											</div>
										</div>

									</fieldset>
									<!--<fieldset>
								<div class="form-group  col-md-6">
									<label for="inputRegion">R&eacute;gion</label>
									<select class="form-control" name="region" id="inputRegion" >
										<option value="Veuillez sélectionner une région" data-extravalue="Veuillez sélectionner une région">Veuillez sélectionner une région</option>
										<?php foreach ($regions_senegal as $region) : ?>
										<option value="<?php echo $region->label; ?>" data-extravalue="<?php echo $region->id; ?>"
										<?php
											if (!empty($setval) && set_value('region') == $region->label) {
												echo 'selected';
											}
											if (!empty($user->region) && $user->region == $region->label) {
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
								<div class="form-group  col-md-6">
									<label for="inputDepartement">D&eacute;partement</label>
									<select class="form-control" name="departement" id="inputDepartement" >
										<option value="---" data-extravalue="---">---</option>
									</select>
								</div>
								<div class="form-group  col-md-6">
									<label for="inputArrondissement">Arrondissement</label>
									<select class="form-control" name="arrondissement" id="inputArrondissement" >
										<option value="---" data-extravalue="---">---</option>
									</select>
								</div>
								<div class="form-group  col-md-6">
									<label for="inputCollectivite">Collectivit&eacute;</label>
									<select class="form-control" name="collectivite" id="inputCollectivite" >
										<option value="---" data-extravalue="---">---</option>
									</select>
								</div>
								<div class="form-group  col-md-6">
									<label for="inputPays">Pays</label>
									<select class="form-control" name="pays" id="inputPays" >
										<option value="Senegal">Senegal</option>
									</select>
								</div>
							</fieldset> -->

									<input type="hidden" name="id" value='<?php
																			if (!empty($setval)) {
																				echo set_value('id');
																			}
																			if (!empty($user->id)) {
																				echo $user->id;
																			}
																			?>'>
									<?php $submit_text = empty($user->id) ? lang('add') : lang('edit'); ?>
									<div class="form-group col-md-12">
										<a id="" class="btn btn-info btn-secondary pull-left" href="home">
											Retour
										</a>
										<button type="submit" name="submit" class="btn btn-info pull-right"><?php echo $submit_text; ?></button>
									</div>

								</form>
							</div>
						</div>
					</div>
				</section>
			</div>
		</section>
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
						<form id="mysignformview" method="post">
							<div class="form-group">
								<label for="inputPin">Entrez le code PIN pour afficher la signature</label>
								<input type="password" id="inputPin" class="form-control" name="inputPin">
							</div>
							<input type="hidden" name="docid" value='<?php
																		if (!empty($setval)) {
																			echo set_value('id');
																		}
																		if (!empty($profile->id)) {
																			echo $profile->id;
																		}
																		?>'>
							<p class='error pull-left'></p>

							<div class="sign"></div>

							<button type="submit" name="submit" class="btn btn-primary pull-right" id='signUpload'><span class='looading'> <i class="fa fa-spinner fa-spin" style='display:none'></i> </span> Afficher</button>

						</form>

					<?php } else { ?>
						<form id="mysignform" method="post">
							<div class="form-group">
								<label for="inputsign">Signature</label>
								<input type="file" id="inputsign" class="form-control" name="inputsign" accept=".jpg, .jpeg, .png">
								<span class="help-block">Formats pris en charge, par exemple <span style="color:green">jpg,jpeg,gif,png</span>. Et la taille doit être <span style="color:red">5mb</span>. </span>
							</div>
							<div class="form-group">
								<label for="inputPin">Signature PIN</label>
								<input type="password" id="inputPin" class="form-control" name="inputPin">
								<span class="help-block">Définir un code sécurisé. </span>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    
	$("#mysignform").validate({
			rules: {
				inputsign: {
					required: true,
				},
				inputPin: {
					required: true,
					minlength: 6,
					maxlength: 6,
					digits: true
				}
			},
			messages: {
				inputsign: {
					required: "Please add valid signature"
				},
				inputPin: {
					required: "Please set a secure PIN & digits only",
					minlength:"Please enter 6 digits ",
					maxlength:"Please enter 6 digits "
				}
			},
			submitHandler: function (form) { // for demo
			   var formdata = new FormData($('#mysignform')[0]);
			   //console.log();
			   //formdata.append('notes',CKEDITOR.instances['note_desc'].getData());
				$.ajax({
					url: 'Profile/uploadSign',
					data : formdata,
					contentType: false,
					processData: false,
					type : "post",
					dataType : "json",
					beforeSend:function(){
						$('.looading').show();
						$('#signUpload').prop('disabled',true);
					},
					success : function(response) {
						$('.looading').hide();
						$("#mysignform")[0].reset();
						//$('#signUpload').prop('disabled',false);
						if(response.error ){
							$('#signUpload').text('Try Later');
						}else{
							$('#signUpload').text('Signature Uploaded');
						}
							
					}
				});
			}
	});
	
	
	$("#mysignformview").validate({
			rules: {
				inputPin: {
					required: true,
					minlength: 6,
					maxlength: 6,
					 digits: true
				}
			},
			messages: {
				inputPin: {
					required: "Veuillez saisir un code PIN à 6 chiffres",
					minlength:"Veuillez saisir 6 chiffres",
					maxlength:"Veuillez saisir 6 chiffres"
				}
			},
			submitHandler: function (form) { // for demo
			   var formdata = new FormData($('#mysignformview')[0]);
			   //console.log();
			   //formdata.append('notes',CKEDITOR.instances['note_desc'].getData());
				$.ajax({
					url: 'Profile/viewSign',
					data : formdata,
					contentType: false,
					processData: false,
					type : "post",
					dataType : "json",
					beforeSend:function(){
						$('.looading').show();
						$('#signUpload').prop('disabled',true);
					},
					success : function(response) {
						$('.looading').hide();
						$("#mysignformview")[0].reset();
						$('#signUpload').prop('disabled',false);
						if(response.error ){
							$('.sign').html('');
							$('.error').css('color','red').text(response.message);
						}else{
							var data =  response.user_signature;
							$('.sign').html('<img src="'+data[0].sign_name+'" width="100%" alt="signature" class="tumbnail">');
							$('#signUpload').text('View');
						}
							
					}
				});
			}
	});
	
	$(document).on('keypress','#inputPin',function(){
		
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

function fnRegionChange(){ 
				var idDepartementBuff = "";
				// alert("during");
                // var id=$(this).val();
                // var id=$("option:selected", this).attr("data-extravalue"); // Worked with changed event
                var id=$("option:selected", $(document).find("#inputRegion")).attr("data-extravalue"); // Works with both Change and onLoad
				// alert(id);
                $.ajax({
                    url : "<?php echo site_url('home/getDepartementsByRegion');?>",
                    method : "POST",
                    data : {id: id},
                    async : false,
                    dataType : 'json',
                    success: function(data){
                        var html = '<option value="Veuillez sélectionner un département" data-extravalue="Veuillez sélectionner un département" selected>Veuillez sélectionner un département</option>';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value=\''+data[i].label+'\' data-extravalue=\''+data[i].id+'\'';
							if (setValDepartment == data[i].label) {
							html += ' selected';
							idDepartementBuff = data[i].id;
							}
							if (userDepartement == data[i].label) { 
							html += ' selected';
							// alert("found matching Departement");
							idDepartementBuff = data[i].id;
							}
							html += '>'+data[i].label+'</option>';
                        }
                        $('#inputDepartement').html(html);
 
                    }
                });
                return idDepartementBuff;
        };
		
function fnDepartementChange(id){ 
				var idArrondissementBuff = "";
                // var id=$(this).val();
                // var id=$("option:selected", this).attr("data-extravalue");
               // var id=$("option:selected", $(document).find("#inputDepartement")).attr("data-extravalue");
               var id = id != "" ? id : $("option:selected", $(document).find("#inputDepartement")).attr("data-extravalue"); // Contien Id departementBuff
				// alert(id);
                $.ajax({
                    url : "<?php echo site_url('home/getArrondissementsByDepartement');?>",
                    method : "POST",
                    data : {id: id},
                    async : false,
                    dataType : 'json',
                    success: function(data){
                        var html = '<option value="Veuillez sélectionner un arrondissement" data-extravalue="Veuillez sélectionner un arrondissement" selected>Veuillez sélectionner un arrondissement</option>';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value=\''+data[i].label+'\' data-extravalue=\''+data[i].id+'\'';
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
							html += '>'+data[i].label+'</option>';
                        }
                        $('#inputArrondissement').html(html);
 
                    }
                });
                return idArrondissementBuff;
        };
function fnArrondissementChange(id){ 
                // var id=$(this).val();
                // var id=$("option:selected", this).attr("data-extravalue");
                // var id=$("option:selected", $(document).find("#inputArrondissement")).attr("data-extravalue");
                var id = id != "" ? id : $("option:selected", $(document).find("#inputArrondissement")).attr("data-extravalue");
				// alert(id);
                $.ajax({
                    url : "<?php echo site_url('home/getCollectivitesByArrondissement');?>",
                    method : "POST",
                    data : {id: id},
                    async : false,
                    dataType : 'json',
                    success: function(data){
                        var html = '<option value="Veuillez sélectionner une collectivité" data-extravalue="Veuillez sélectionner une collectivité" selected>Veuillez sélectionner une collectivité</option>';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value=\''+data[i].label+'\' data-extravalue=\''+data[i].id+'\'';
							if (setValCollectivite == data[i].label) {
							html += ' selected';
							}
							if (userCollectivite == data[i].label) { 
							html += ' selected';
							}
							html += '>'+data[i].label+'</option>';
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
		$('#inputRegion').on("change", function() { idDepartementBuff = fnRegionChange(); });
		$('#inputDepartement').on("change", function() { idArrondissementBuff = fnDepartementChange(idDepartementBuff); });
		$('#inputArrondissement').on("change", function() { fnArrondissementChange(idArrondissementBuff); }); 
});
</script>