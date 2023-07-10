<!--sidebar end-->
<!--main content start-->
<script type="text/javascript" src="<?php echo base_url(); ?>common/js/google-loader.js"></script>
<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>

<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="col-md-7">
            <header class="panel-heading">
				<h2>
                <?php
                if (!empty($organisation->id))
                    echo "Modifier Organisation";
                else
                    echo "Ajouter une Organisation";
					// echo var_dump($organisation);
					// echo (int)empty($organisation->id);
					// echo (int)is_null($organisation->id);
                ?>
				<?php // print_r($organisation); ?>
				</h2>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <?php // echo validation_errors(); ?>
						<?php if(!empty(validation_errors())) { ?>
						<code class="" style=""> <?php echo validation_errors(); ?></code>
						<?php } ?>
						
						<?php if(!empty($display_errors)) { ?>
						<code class="" style=""> <?php echo $display_errors; ?></code>
						<?php } ?>
						
                        <form role="form" action="home/addOrganisation" class="clearfix" method="post" enctype="multipart/form-data">
						
							
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
								<div style="display:none">
								<div class="form-group">
									<label for="inputIdZuuluPay">Id zuuluPay</label>
									<input type="number" class="form-control" name="id_partenaire_zuuluPay" id="inputIdZuuluPay" value='2214010000'>
								</div>
								<div class="form-group">
									<label for="inputPINZuuluPay">PIN zuuluPay</label>
									<input type="password" class="form-control" name="pin_partenaire_zuuluPay" id="inputPINZuuluPay" value='55667788'>
									 
								</div>
								</div>
								<div class="form-group">
									<label for="inputType">Type</label>
									<select class="form-control" name="type" id="inputType" required>
										<option value="Veuillez sélectionner un type" selected>Veuillez sélectionner un type</option>
										<option value="Laboratoire d'Analyses" <?php
										if (!empty($setval) && set_value('type') == "Laboratoire d'Analyses") {
											echo 'selected';
										}
										if (!empty($organisation->type) && $organisation->type == "Laboratoire d'Analyses") {
											echo 'selected';
										}
										?>>Laboratoire d'Analyses</option>
										<option value="Polyclinique" <?php
										if (!empty($setval) && set_value('type') == "Polyclinique") {
											echo 'selected';
										}
										if (!empty($organisation->type) && $organisation->type == "Polyclinique") {
											echo 'selected';
										}
										?>>Polyclinique</option>
										<option value="Clinique" 
										<?php
										if (!empty($setval) && set_value('type') == "Clinique") {
											echo 'selected';
										}
										if (!empty($organisation->type) && $organisation->type == "Clinique") {
											echo 'selected';
										}
										?>>Clinique</option>
										<option value="Pharmacie" <?php
										if (!empty($setval) && set_value('type') == "Pharmacie") {
											echo 'selected';
										}
										if (!empty($organisation->type) && $organisation->type == "Pharmacie") {
											echo 'selected';
										}
										?>>Pharmacie</option>
										<option value="Fournisseur Pharmacie" <?php
										if (!empty($setval) && set_value('type') == "Fournisseur Pharmacie") {
											echo 'selected';
										}
										if (!empty($organisation->type) && $organisation->type == "Fournisseur Pharmacie") {
											echo 'selected';
										}
										?>>Fournisseur Pharmacie</option>
										<option value="Fournisseur Laboratoire" <?php
										if (!empty($setval) && set_value('type') == "Fournisseur Laboratoire") {
											echo 'selected';
										}
										if (!empty($organisation->type) && $organisation->type == "Fournisseur Laboratoire") {
											echo 'selected';
										}
										?>>Fournisseur Laboratoire</option>
										<option value="Assurance" <?php
										if (!empty($setval) && set_value('type') == "Assurance") {
											echo 'selected';
										}
										if (!empty($organisation->type) && $organisation->type == "Assurance") {
											echo 'selected';
										}
										?>>Assurance</option>
										<option value="IPM" <?php
										if (!empty($setval) && set_value('type') == "IPM") {
											echo 'selected';
										}
										if (!empty($organisation->type) && $organisation->type == "IPM") {
											echo 'selected';
										}
										?>>IPM</option>
									</select>
								</div>
							</fieldset>
							<fieldset>
								<div class="form-group">
									<label for="inputNom">Nom Organisation</label>
									<input type="text" class="form-control" name="nom" id="inputNom" value='<?php
									if (!empty($setval)) {
										echo set_value('nom');
									}
									if (!empty($organisation->nom)) {
										echo $organisation->nom;
									}
									?>' required >
								</div>
								<div class="form-group">
									<label for="inputNomCommercial">Nom Commercial</label>
									<input type="text" class="form-control" name="nom_commercial" id="inputNomCommercial" value="<?php
									if (!empty($setval)) {
										echo set_value('nom_commercial');
									}
									if (!empty($organisation->nom_commercial)) {
										echo $organisation->nom_commercial;
									}
									?>" required >
								</div>
								<div class="form-group">
									<label for="inputDescriptionCourteActivite">Description Courte Activité</label>
									<input type="text" class="form-control" name="description_courte_activite" id="inputDescriptionCourteActivite" value="<?php
									if (!empty($setval)) {
										echo set_value('description_courte_activite');
									}
									if (!empty($organisation->description_courte_activite)) {
										echo $organisation->description_courte_activite;
									}
									?>" >
								</div>
								<div class="form-group">
									<label for="inputDescriptionCourteServices">Description Courte Services</label>
									<input type="text" class="form-control" name="description_courte_services" id="inputDescriptionCourteServices" value="<?php
									if (!empty($setval)) {
										echo set_value('description_courte_services');
									}
									if (!empty($organisation->description_courte_services)) {
										echo $organisation->description_courte_services;
									}
									?>" >
								</div>
								<div class="form-group">
									<label for="inputSlogan">Slogan</label>
									<input type="text" class="form-control" name="slogan" id="inputSlogan" value="<?php
									if (!empty($setval)) {
										echo set_value('slogan');
									}
									if (!empty($organisation->slogan)) {
										echo $organisation->slogan;
									}
									?>" >
								</div>
								<div class="form-group">
									<label for="exampleHorairesOuverture">Horaires d'ouverture</label>
									<textarea class="ckeditor form-control" id="horaires_ouverture" name="horaires_ouverture" value="" rows="10"><?php
										if (!empty($setval)) {
											echo set_value('horaires_ouverture');
										}
										if (!empty($organisation->horaires_ouverture)) {
											echo $organisation->horaires_ouverture;
										}
										?>
									</textarea>
								</div>
								<div class="form-group">
									<label for="inputLogo"><?php echo lang('logo'); ?></label>
									<input type="file" class="form-control" name="logo" id="inputLogo" value='<?php
									// if (!empty($setval)) { // NOt possible:  security reasons
										// echo set_value('logo');
									// }
									?>' >
									<span class="help-block"><?php echo lang('recommended_size'); ?> : 200x90 pixels
									<?php 
									if (!empty($organisation->path_logo)) {
										?><br/> Logo actuel:<br/> <img style="width:100px;height:45px;" src="<?php echo base_url().$organisation->path_logo; 
									?> "/> <?php }
									?>
									</span>
								</div>
								<div class="form-group">
									<label for="inputLogo">Image En-tête</label>
									<input type="file" class="form-control" name="entete" id="inputEntete" value='<?php
									// if (!empty($setval)) { // NOt possible:  security reasons
										// echo set_value('logo');
									// }
									?>' >
									<span class="help-block"><?php echo lang('recommended_size'); ?> : 820 x 261 pixels
									<?php 
									if (!empty($organisation->entete)) {
										?><br/> En-tête actuel:<br/> <img style="width:100px;height:45px;" src="<?php echo base_url().$organisation->entete; 
									?> "/> <?php }
									?>
									</span>
								</div>

								<div class="form-group">
									<label for="inputLogo">Image Footer</label>
									<input type="file" class="form-control" name="footer" id="inputFooter" value='<?php
									// if (!empty($setval)) { // NOt possible:  security reasons
										// echo set_value('logo');
									// }
									?>' >
									<span class="help-block"><?php echo lang('recommended_size'); ?> : 820 x 261 pixels
									<?php 
									if (!empty($organisation->entete)) {
										?><br/> Footer actuel:<br/> <img style="width:200px;height:25px;" src="<?php echo base_url().$organisation->footer; 
									?> "/> <?php }
									?>
									</span>
								</div>

								<div class="form-group">
									<label for="inputLogo">Signature</label>
									<input type="file" class="form-control" name="signature" id="inputSignature" value='<?php
									// if (!empty($setval)) { // NOt possible:  security reasons
										// echo set_value('logo');
									// }
									?>' >
									<span class="help-block"><?php echo lang('recommended_size'); ?> : 320 x 320 pixels
									<?php 
									if (!empty($organisation->entete)) {
										?><br/> Signature actuelle:<br/> <img style="width:100px;height:45px;" src="<?php echo base_url().$organisation->signature; 
									?> "/> <?php }
									?>
									</span>
								</div>
								
								<div class="form-group">
									<label for="inputAdresse">Adresse</label>
									<input type="text" class="form-control" name="adresse" id="inputAdresse" value="<?php
									if (!empty($setval)) {
										echo set_value('adresse');
									}
									if (!empty($organisation->adresse)) {
										echo $organisation->adresse;
									}
									?>" required >
								</div>
							</fieldset>
							<fieldset>
								<div class="form-group">
									<label for="inputRegion">R&eacute;gion</label>
									<select class="form-control" name="region" id="inputRegion" required>
										<option value="Veuillez sélectionner une région" data-extravalue="Veuillez sélectionner une région">Veuillez sélectionner une région</option>
										<?php foreach($regions_senegal as $region):?>
										<option value="<?php echo $region->label;?>" data-extravalue="<?php echo $region->id;?>"
										<?php
										if (!empty($setval) && set_value('region') == $region->label) {
											echo 'selected';
										}
										if (!empty($organisation->region) && $organisation->region == $region->label) {
											echo 'selected';
										}
										?>
										><?php echo $region->label;?></option>
										<?php endforeach;?>
										<?php //if ((!empty($setval) && !empty(set_value("region"))) || !empty($organisation->region)) { ?> <script>//alert("before");fnRegionChange;alert("after");	</script> <?php //} ?>
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
									<select class="form-control" name="arrondissement" id="inputArrondissement">
										<option value="---" data-extravalue="---">---</option>
									</select>
								</div>
								<div class="form-group">
									<label for="inputCollectivite">Collectivit&eacute;</label>
									<select class="form-control" name="collectivite" id="inputCollectivite">
										<option value="---" data-extravalue="---">---</option>
									</select>
								</div>
								<div class="form-group">
									<label for="inputPays">Pays</label>
									<select class="form-control" name="pays" id="inputPays" required>
										<option value="Senegal">Senegal</option>
									</select>
								</div>
								<div class="form-group">
									<label for="inputEmail">Email</label>
									<input type="email" class="form-control" name="email" id="inputEmail" value='<?php
									if (!empty($setval)) {
										echo set_value('email');
									}
									if (!empty($organisation->email)) {
										echo $organisation->email;
									}
									?>' required >
								</div>
								<div class="form-group">
									<label for="inputPortableResponsable">Tel. Mobile</label>
									<input type="number" class="form-control" name="portable_responsable_legal" id="inputNumeroFixe" value='<?php
									if (!empty($setval)) {
										echo set_value('portable_responsable_legal');
									}
									if (!empty($organisation->portable_responsable_legal)) {
										echo $organisation->portable_responsable_legal;
									}
									?>' required>
								</div>
								<div class="form-group">
									<label for="inputNumeroFixe">Tel. Fixe</label>
									<input type="number" class="form-control" name="numero_fixe" id="inputNumeroFixe" value='<?php
									if (!empty($setval)) {
										echo set_value('numero_fixe');
									}
									if (!empty($organisation->numero_fixe)) {
										echo $organisation->numero_fixe;
									}
									?>' >
								</div>
							</fieldset>
							<fieldset>
								<div class="form-group">
									<label for="inputPrenomResponsable">Prénom responsable legal</label>
									<input type="text" class="form-control" name="prenom_responsable_legal" id="inputPrenomResponsable" value='<?php
									if (!empty($setval)) {
										echo set_value('prenom_responsable_legal');
									}
									if (!empty($organisation->prenom_responsable_legal)) {
										echo $organisation->prenom_responsable_legal;
									}
									?>' required>
								</div>
								<div class="form-group">
									<label for="inputNomResponsable">Nom responsable legal</label>
									<input type="text" class="form-control" name="nom_responsable_legal" id="inputNomResponsable" value='<?php
									if (!empty($setval)) {
										echo set_value('nom_responsable_legal');
									}
									if (!empty($organisation->nom_responsable_legal)) {
										echo $organisation->nom_responsable_legal;
									}
									?>' required>
								</div>
								
								<div class="form-group">
									<label for="inputFonctionResponsable">Fonction Responsable legal</label>
									<input type="text" class="form-control" name="fonction_responsable_legal" id="inputFonctionResponsable" value='<?php
									if (!empty($setval)) {
										echo set_value('fonction_responsable_legal');
									}
									if (!empty($organisation->fonction_responsable_legal)) {
										echo $organisation->fonction_responsable_legal;
									}
									?>' >
								</div>
								<div class="form-group">
									<label for="inputDescriptionResponsable">Description Courte Responsable Legal</label>
									<input type="text" class="form-control" name="description_courte_responsable_legal" id="inputDescriptionResponsable" value='<?php
									if (!empty($setval)) {
										echo set_value('description_courte_responsable_legal');
									}
									if (!empty($organisation->description_courte_responsable_legal)) {
										echo $organisation->description_courte_responsable_legal;
									}
									?>' >
								</div>
								
								<div class="form-group">
									<label for="inputPrenomResponsable2">Prénom Second responsable legal</label>
									<input type="text" class="form-control" name="prenom_responsable_legal2" id="inputPrenomResponsable2" value='<?php
									if (!empty($setval)) {
										echo set_value('prenom_responsable_legal2');
									}
									if (!empty($organisation->prenom_responsable_legal2)) {
										echo $organisation->prenom_responsable_legal2;
									}
									?>' >
								</div>
								<div class="form-group">
									<label for="inputNomResponsable2">Nom Second responsable legal</label>
									<input type="text" class="form-control" name="nom_responsable_legal2" id="inputNomResponsable2" value='<?php
									if (!empty($setval)) {
										echo set_value('nom_responsable_legal2');
									}
									if (!empty($organisation->nom_responsable_legal2)) {
										echo $organisation->nom_responsable_legal2;
									}
									?>' >
								</div>
								<div class="form-group">
									<label for="inputPortableResponsable2">Portable Second Responsable legal</label>
									<input type="number" class="form-control" name="portable_responsable_legal2" id="inputPortableResponsable2" value='<?php
									if (!empty($setval)) {
										echo set_value('portable_responsable_legal2');
									}
									if (!empty($organisation->portable_responsable_legal2)) {
										echo $organisation->portable_responsable_legal2;
									}
									?>' >
								</div>
								<div class="form-group">
									<label for="inputFonctionResponsable2">Fonction Second Responsable legal</label>
									<input type="text" class="form-control" name="fonction_responsable_legal2" id="inputFonctionResponsable2" value='<?php
									if (!empty($setval)) {
										echo set_value('fonction_responsable_legal2');
									}
									if (!empty($organisation->fonction_responsable_legal2)) {
										echo $organisation->fonction_responsable_legal2;
									}
									?>' >
								</div>
								<div class="form-group">
									<label for="inputDescriptionResponsable2">Description Courte Second Responsable Legal</label>
									<input type="text" class="form-control" name="description_courte_responsable_legal2" id="inputDescriptionResponsable2" value='<?php
									if (!empty($setval)) {
										echo set_value('description_courte_responsable_legal2');
									}
									if (!empty($organisation->description_courte_responsable_legal2)) {
										echo $organisation->description_courte_responsable_legal2;
									}
									?>' >
								</div>
                                                         
							</fieldset>
									
                            <input type="hidden" name="id" value='<?php
                            if (!empty($organisation->id)) {
                               echo $organisation->id;
                            }
                            ?>'>
							<?php $submit_text = empty($organisation->id) ? lang('add') : lang('edit'); ?>
                            <div class="form-group col-md-12">
								<a id="" class="btn btn-info btn-secondary pull-left" href="home/superhome">
										Retour
								</a>
                                <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo $submit_text; ?></button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->

<script src="<?php echo base_url(); ?>common/assets/jquery-file-upload/js/jquery.imagesloader-1.0.1.js"></script>
<script src="<?php echo base_url(); ?>common/js/autoNumeric.min.js"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script-->

<script>
var autoNumericInstance = new AutoNumeric.multiple('.money', {
    // currencySymbol: "Fcfa",
    // currencySymbolPlacement: "s",
	// emptyInputBehavior: "min",
	selectNumberOnly: true,
	selectOnFocus: true,
	overrideMinMaxLimits: 'invalid',
	emptyInputBehavior: "min",
    maximumValue : '100000',
    minimumValue : "1000",
	decimalPlaces : 0,
    decimalCharacter : ',',
    digitGroupSeparator : '.'
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

// var emptyOrganisation = <?php echo (int)(!empty($organisation->id) ? $organisation->id : "0"); ?>
// alert("emptyOrganisation: " + emptyOrganisation);
var organisationRegion = <?php echo json_encode(!empty($organisation->region) ? $organisation->region : "") ?>;
// alert("organisationRegion: " + organisationRegion);
var organisationDepartement = <?php echo json_encode(!empty($organisation->departement) ? $organisation->departement : "") ?>;
// alert("organisationDepartement: "+organisationDepartement);
var organisationArrondissement = <?php echo json_encode(!empty($organisation->arrondissement) ? $organisation->arrondissement : "") ?>;
// alert("organisationArrondissement: "+organisationArrondissement);
var organisationCollectivite = <?php echo json_encode(!empty($organisation->collectivite) ? $organisation->collectivite : "") ?>;
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
							if (organisationDepartement == data[i].label) { 
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
							if (organisationArrondissement == data[i].label) { 
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
							if (organisationCollectivite == data[i].label) { 
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
		<?php if ((!empty($setval) && !empty(set_value("region"))) || !empty($organisation->region)) { ?>	
			// alert("region present");
			// $(document).find("#inputDepartement").children().remove();
			idDepartementBuff = fnRegionChange();
		<?php } ?>
		<?php if ((!empty($setval) && !empty(set_value("departement"))) || !empty($organisation->departement)) { ?>
			// $(document).find("#inputArrondissement").children().remove();
			// alert("idDepartementBuff: " +idDepartementBuff);
			idArrondissementBuff = fnDepartementChange(idDepartementBuff);
		<?php } ?>
		<?php if ((!empty($setval) && !empty(set_value("arrondissement"))) || !empty($organisation->arrondissement)) { ?>
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
