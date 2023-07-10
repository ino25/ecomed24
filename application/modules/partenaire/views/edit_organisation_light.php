<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height row">
        <!-- page start-->
        <section class="col-md-10">
            <header class="panel-heading">Modifier Sous-traitant
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                    <?php echo validation_errors(); ?>
                        <form role="form" action="partenaire/editNewLight" method="post" class="clearfix" enctype="multipart/form-data">
                            <input type="hidden" class="form-control" name="idOrganisation" id="exampleInputEmail1" value="<?php echo $organisation->id ?>" placeholder="" required>
                            <input type="hidden" class="form-control" name="idPartenaire" id="exampleInputEmail1" value="<?php echo $partenaire->idp ?>" placeholder="" required>

                            <div class="col-md-12 panel">
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1"> Nom organisation</label>
                                    <input type="text" class="form-control" name="name" id="exampleInputEmail1" value="<?php echo $organisation->nom ?>" placeholder="" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">Type</label>
                                    <select class="form-control" name="type" required>
                                    <option value="Laboratoire d'Analyses" <?php
																if (!empty($setval) && $organisation->type == "Laboratoire d'Analyses") {
																	echo 'selected';
																}
																if (!empty($organisation->type) && $organisation->type == "Laboratoire d'Analyses") {
																	echo 'selected';
																}
																?>>Laboratoire d'Analyses</option>
                                    <option value="Polyclinique" <?php
																if (!empty($setval) && $organisation->type == "Polyclinique") {
																	echo 'selected';
																}
																if (!empty($organisation->type) && $organisation->type == "Polyclinique") {
																	echo 'selected';
																}
																?>>Polyclinique</option>
										<option value="Clinique" <?php
																if (!empty($setval) && $organisation->type == "Clinique") {
																	echo 'selected';
																}
																if (!empty($organisation->type) && $organisation->type == "Clinique") {
																	echo 'selected';
																}
																?>>Clinique</option>
											<option value="Pharmacie" <?php
																if (!empty($setval) && $organisation->type == "Pharmacie") {
																	echo 'selected';
																}
																if (!empty($organisation->type) && $organisation->type == "Pharmacie") {
																	echo 'selected';
																}
																?>>Pharmacie</option>
                                    <option value="Fournisseur Pharmacie" <?php
																if (!empty($setval) && $organisation->type == "Fournisseur Pharmacie") {
																	echo 'selected';
																}
																if (!empty($organisation->type) && $organisation->type == "Fournisseur Pharmacie") {
																	echo 'selected';
																}
																?>>Fournisseur Pharmacie</option>
										<option value="Assurance" <?php
																if (!empty($setval) && $organisation->type == "Assurance") {
																	echo 'selected';
																}
																if (!empty($organisation->type) && $organisation->type == "Assurance") {
																	echo 'selected';
																}
																?>>Assurance</option>
											<option value="IMP" <?php
																if (!empty($setval) && $organisation->type == "IPM") {
																	echo 'selected';
																}
																if (!empty($organisation->type) && $organisation->type == "IPM") {
																	echo 'selected';
																}
																?>>IPM</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">Téléphone</label>
                                    <input id="phone_patient_light_partenaire_edit" type="number" class="form-control" name="phone" onkeyup="numberChangePatientLightPartenaireEdit(event)" value='<?php echo $organisation->portable_responsable_legal ?>' required />
                                    <input type="hidden" id='phoneValide_patient_light_partenaire_edit' name="phone_recuperation" value='' required />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">email</label>
                                    <input type="email" class="form-control" id="name" name="email" value="<?php echo $organisation->email ?>" id="exampleInputEmail1" placeholder="" required>
                                </div>
                                <div class="col-md-12 panel">
                                    <label for="exampleInputEmail1">Catégorie de Tarification</label>
                                    <select name='category' class='form-control' required>
                                    <option value="privé" <?php
																if (!empty($setval) && $partenaire->category == "privé") {
																	echo 'selected';
																}
																if (!empty($partenaire->category) && $partenaire->category == "privé") {
																	echo 'selected';
																}
																?>>Sous-traitance privée</option>
                                    <option value="publique" <?php
																if (!empty($setval) && $partenaire->category == "publique") {
																	echo 'selected';
																}
																if (!empty($partenaire->category) && $partenaire->category == "publique") {
																	echo 'selected';
																}
																?>>Sous-traitance publique</option>
										<option value="hors-category" <?php
																if (!empty($setval) && $partenaire->category == "hors-category") {
																	echo 'selected';
																}
																if (!empty($partenaire->category) && $partenaire->category == "hors-category") {
																	echo 'selected';
																}
																?>>Hors-catégorie</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1">Adresse</label>
                                    <input type="text" class="form-control" name="adresse" id="exampleInputEmail1" value="<?php echo $organisation->adresse ?>" placeholder="" required>
                                </div>
                                <input type="hidden" class="form-control" name="redirect" value="partenaire" id="exampleInputEmail1" placeholder="">
                            </div>

                            <div class="col-md-12 panel">
                            <a href="partenaire" name="submit" class="btn btn-info btn-secondary pull-left"><?php echo lang('submit_retour'); ?></a>
                                <button id="validationPatientEditLightEditPartenaire" type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
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

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/webservice/autoNumeric2.min.js"></script>
<script src="https://unpkg.com/imask"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script> -->
<script>
    var element = document.getElementById('telephone');
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
        emptyInputBehavior: "0",
        maximumValue: '100000',
        minimumValue: "500",
        decimalPlaces: 0,
        decimalCharacter: ',',
        digitGroupSeparator: '.'
    });
</script>

<script>
    $(document).ready(function() {
        $('.pos_client').hide();
        $('.pos_client2').hide();
        $(document.body).on('change', '#pos_select', function() {

            var v = $("select.pos_select option:selected").val()
            if (v == 'add_new') {
                $('.pos_client').show();
            } else {
                $('.pos_client').hide();
            }
        });
        $(document.body).on('change', '#pos_select2', function() {
            var v = $("select.pos_select2 option:selected").val()
            if (v == 'add_newBeneficiaire') {
                $('.pos_client2').show();
            } else {
                $('.pos_client2').hide();
            }
        });

    });
</script>
<script>
    $(document).ready(function() {
        $("#pos_select").select2({
            placeholder: '<?php echo lang('select_category'); ?>',
            allowClear: true,
            ajax: {
                url: 'finance/getCategoryinfoWithAddNewOption',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });

        $("#pos_select2").select2({
            placeholder: '<?php echo lang('select_beneficiaire'); ?>',
            allowClear: true,
            ajax: {
                url: 'finance/getBeneficiaireinfoWithAddNewOption',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });

        $("#adoctors").select2({
            placeholder: '<?php echo lang('select_doctor'); ?>',
            allowClear: true,
            ajax: {
                url: 'doctor/getDoctorInfo',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }

        });

    });
</script>