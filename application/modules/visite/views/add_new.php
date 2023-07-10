<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <form role="form" action="visite/addNew" id="visiteaddNew" method="post" enctype="multipart/form-data">
        <section class="wrapper site-min-height">
            <!-- page start-->
            <section class="panel">
                <header class="panel-heading">
                    <h2><?php
                        if (!empty($visite->id))
                            echo lang('visite_general');
                        else
                            echo lang('visite_general');

                        $patient_id = '';
                        if (isset($_GET['patient'])) {
                            $patient_id = $_GET['patient'];
                        }

                        ?></h2>
                </header>
                <div class="panel-body">
                    <div class="adv-table editable-table ">
                        <div class="clearfix">
                            <div class="col-lg-12">
                                <div class="no-print">
                                    <div class="adv-table editable-table ">
                                        <div class="clearfix">
                                            <style>
                                                .lab {
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

                                            <div class="" id="visitegenerale">
                                                <div class="col-md-12 lab pad_bot">
                                                    <div class="col-md-6 lab pad_bot">
                                                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                                                        <input type="text" class="form-control" id="dateViste" name="date" value='<?php
                                                                                                                                    if (!empty($lab->date)) {
                                                                                                                                        echo date('d/m/Y', $lab->date);
                                                                                                                                    } else {
                                                                                                                                        echo date('d/m/Y');
                                                                                                                                    }
                                                                                                                                    ?>' placeholder="" readonly>
                                                    </div>
                                                    <div class="col-md-6 lab pad_bot">
                                                        <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                                                        <select class="form-control m-bot15  pos_select" id="pos_select" name="patient" value=''>
                                                            <?php if (!empty($payment)) { ?>
                                                                <option value="<?php echo $patients->id; ?>" selected="selected"><?php echo $patients->name; ?> - <?php echo $patients->id; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <!-- <div class="col-md-4 lab pad_bot">
                                                        <label for="exampleInputEmail1"> <?php echo lang('template'); ?></label>
                                                        <select class="form-control m-bot15 js-example-basic-multiple template" id="template" name="template" value=''>
                                                            <option value="">Select .....</option>
                                                            <?php foreach ($templates as $template) { ?>
                                                                <option value="<?php echo $template->id; ?>"><?php echo $template->name; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>  -->
                                                    <!-- <div class="col-md-10 lab pad_bot">
                                                    <div class="form-group">
                                                        <label for="exampleHorairesOuverture" style="font-size: 1.2em;">Antécédants Médicaux</label>
                                                        <textarea class="ckeditor form-control" id="antecedant" value='' name="description" rows="3">
                                                            </textarea>
                                                    </div>
                                                </div> -->
                                                    <div class="col-md-12 lab pad_bot">
                                                        <label for="exampleInputEmail1"> <?php echo lang('antecedant'); ?></label>
                                                        <textarea class="ckeditor form-control" id="editor" name="description" value="" rows="10">
                                                         </textarea>
                                                    </div>
                                                    <br><br><br>
                                                    <div class="col-md-12 lab pad_bot">
                                                        <table style="width:100%">
                                                            <tr>
                                                                <th style="width: 15%;"><label for="exampleInputEmail1"><?php echo lang('taille'); ?></label>
                                                                    <input type="number" class="form-control money " id="taille" name="taille" value='' placeholder="" onkeyup="recuperationResultat(event)">
                                                                </th>
                                                                <th style="width: 3%;"></th>
                                                                <th style="width: 15%;"><label for="exampleInputEmail1"><?php echo lang('poids'); ?></label>
                                                                    <input type="number" class="form-control" id="poids" name="poids" value='' placeholder="" onkeyup="recuperationResultat(event)">
                                                                </th>
                                                                <th style="width: 3%;"></th>
                                                                <th style="width: 25%;"><label for="exampleInputEmail1"><?php echo lang('perimetre_thoracique'); ?></label>
                                                                    <input type="number" class="form-control money " id="perimetre_thoracique" name="perimetre_thoracique" value='' placeholder="" onkeyup="recuperationResultat(event)">
                                                                </th>
                                                                <th style="width: 5%;">
                                                                <th>
                                                                <th style="width: 35%;"><label for="exampleInputEmail1"><?php echo lang('pignet'); ?></label>
                                                                    <div id="pignetRecuperer"></div>
                                                                    <input type="text" class="form-control pay_in " id="pignetVisible" name="pignet" value='' placeholder="" readonly>
                                                                <th style="width: 5%;">
                                                                <th>

                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <br><br><br>
                                                    <div class="col-md-12 lab pad_bot">
                                                        <label for="exampleHorairesOuverture" style="font-size: 1.2em;">Tension Artérielle </label>
                                                        <br>
                                                        <table style="width:100%">
                                                            <tr>
                                                                <th style="width: 3%;"> </th>
                                                                <th style="width: 27%;"><label for="exampleInputEmail1"><?php echo lang('systolique'); ?></label>
                                                                    <input type="number" class="form-control pay_in " id="systolique" name="systolique" value='' placeholder="" onkeyup="tensionArterielles(event)">
                                                                </th>
                                                                <th style="width: 1%;"> </th>
                                                                <th style="width: 2%;"> </th>
                                                                <th style="width: 27%;"><label for="exampleInputEmail1"><?php echo lang('diastolique'); ?></label>
                                                                    <input type="number" class="form-control pay_in " id="diastolique" name="diastolique" value='' placeholder="" onkeyup="tensionArterielles(event)">
                                                                </th>
                                                                <th style="width: 2%;"></th>
                                                                <th style="width: 39%;"><label for="exampleInputEmail1"><?php echo lang('resultat'); ?></label>
                                                                    <div id="tension"></div>
                                                                    <input type="text" class="form-control pay_in " id="tensionArterielle" name="tensionArterielle" value='' placeholder="" readonly>
                                                                </th>
                                                                <th style="width: 2%;">
                                                                <th>

                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <br><br><br>
                                                    <div class="col-md-12 lab pad_bot">
                                                        <label for="exampleHorairesOuverture" style="font-size: 1.2em;">Urines </label>
                                                        <br>
                                                        <table style="width:100%">
                                                            <tr>
                                                                <th style="width: 2%;"> </th>
                                                                <th style="width: 25%;"><label for="exampleInputEmail1">Sucre</label>
                                                                    <select class="form-control m-bot15" id="sucre" name="sucre" value=''>
                                                                        <option value=""></option>
                                                                        <option value="positif">Positif</option>
                                                                        <option value="negatif">Négatif</option>
                                                                    </select>
                                                                </th>
                                                                <th style="width: 3%;"> </th>
                                                                <th style="width: 25%;"><label for="exampleInputEmail1">Albumine</label>
                                                                    <select class="form-control m-bot15" id="albumine" name="albumine" value=''>
                                                                        <option value=""></option>
                                                                        <option value="positif">Positif</option>
                                                                        <option value="negatif">Négatif</option>
                                                                    </select>
                                                                </th>
                                                                </th>
                                                                <th style="width: 10%;"></th>

                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <br><br><br>
                                                    <div class="col-md-12 lab pad_bot">
                                                        <label for="exampleHorairesOuverture" style="font-size: 1.2em;">Acuite Visuelle </label>
                                                        <table style="width:100%">
                                                            <tr>
                                                                <th style="width: 3%;"></th>
                                                                <th style="width: 12%;"><label for="exampleInputEmail1">Oeil droit</label></th>
                                                                <th style="width: 11%;"><input type="number" class="form-control pay_in " id="oeildroite" name="oeildroit" value='' placeholder="" max="10" onkeyup="conditionOeilDroite()">
                                                                    <code id="montantID" class="flash_message" style="display:none">Cette valeur doit être comprise entre 0 et 10</code>
                                                                </th>
                                                                <th style="width: 3%;">/</th>
                                                                <th style="width: 12%;"><input type="text" class="form-control pay_in " name="droit10" value='10' placeholder="" readonly></th>
                                                                <th style="width: 6%;"></th>
                                                                <th style="width: 15%;"><label for="exampleInputEmail1">Oeil Gauche</label></th>
                                                                <th style="width: 10%;"><input type="number" class="form-control pay_in " id="oeilgauche" name="oeildroit" value='' placeholder="" onkeyup="conditionOeilGauche()">
                                                                    <code id="montantGauche" class="flash_message" style="display:none">Cette valeur doit être comprise entre 0 et 10</code>
                                                                </th>
                                                                <th style="width: 2%;">/</th>
                                                                <th style="width: 10%;"><input type="text" class="form-control pay_in " name="oeilgauche" value='10' placeholder="" readonly></th>
                                                                <th style="width: 20%;"></th>


                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <br><br><br>
                                                    <div class="col-md-12 lab pad_bot">
                                                        <label for="exampleHorairesOuverture" style="font-size: 1.2em;">Acuite Auditive </label>
                                                        <table style="width:100%">
                                                            <tr>
                                                                <th style="width: 3%;"></th>
                                                                <th style="width: 12%;"><label for="exampleInputEmail1">Oreille droite</label></th>
                                                                <th style="width: 12%;"><input type="number" class="form-control pay_in " id="oreilledroite" name="oreilledroite" value='' placeholder="" onkeyup="conditionOreilleDroite()">
                                                                    <code id="montantoreilledroite" class="flash_message" style="display:none">Cette valeur doit être comprise entre 0 et 10</code>
                                                                </th>
                                                                <th style="width: 3%;">/</th>
                                                                <th style="width: 12%;"><input type="text" class="form-control pay_in " name="orei" value='10' placeholder="" readonly></th>
                                                                <th style="width: 6%;">
                                                                <th>
                                                                <th style="width: 15%;"><label for="exampleInputEmail1">Oreille Gauche</label></th>
                                                                <th style="width: 10%;"><input type="number" class="form-control pay_in " id="oreillegauche" name="oreillegauche" value='' placeholder="" onkeyup="conditionOreilleGauche()">
                                                                    <code id="montantoreillegauche" class="flash_message" style="display:none">Cette valeur doit être comprise entre 0 et 10</code>
                                                                </th>
                                                                <th style="width: 2%;">/</th>
                                                                <th style="width: 10%;"><input type="text" class="form-control pay_in " name="oeilgauche10" value='10' placeholder="" readonly></th>
                                                                <th style="width: 20%;">
                                                                <th>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <br><br><br>
                                                    <div class="col-md-10 lab pad_bot">
                                                        <div class=" no-print" style="padding-top: 15px;">
                                                            <i class="fa fa-plus-circle"> </i> <?php echo lang('radioscopie'); ?>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="exampleInputEmail1"> <?php echo lang('document'); ?></label>
                                                            <input type="file" name="img_url">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-10 lab">
                                                        <a href="visite/liste" class="btn btn-info btn-secondary pull-left">Retour</a>
                                                        <button id="continuer" type="button" name="submit" class="btn btn-info pull-right" style="margin-left:15px">Continuer</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
            <section>
                <div class="panel-body" id="pageconfirmation" style="display: none;">
                    <div class="adv-table editable-table ">
                        <div class="clearfix">
                            <div>
                                <div class="col-md-12">
                                    <table>
                                        <tr>
                                            <th style="width: 25%;"><label class="grandeligne">Date</label></th>
                                            <th style="width: 10%;"></th>
                                            <th style="width: 65%;"><label class="petiteligne" id="dateConfirmation"></label></th>

                                        </tr>
                                        <tr>
                                            <th style="width: 25%;"><label class="grandeligne">Patient</label></th>
                                            <th style="width: 10%;"></th>
                                            <th style="width: 65%;"><label class="petiteligne" id="patientConfirmation"></label></th>

                                        </tr>
                                        <tr>
                                            <th style="width: 25%;"><label class="grandeligne">Pignet</label></th>
                                            <th style="width: 10%;"></th>
                                            <th style="width: 65%;"><label class="petiteligne" id="pignetConfirmation"></label></th>

                                        </tr>
                                        <tr>
                                            <th style="width: 25%;"><label class="grandeligne">Tension Artérielle</label></th>
                                            <th style="width: 10%;"></th>
                                            <th style="width: 65%;"><label class="petiteligne" id="tensionArterielleConfirmation"></label></th>

                                        </tr>
                                        <tr>
                                            <th style="width: 25%;"><label class="grandeligne">Urine</label></th>
                                            <th style="width: 10%;"></th>
                                            <th style="width: 65%;"><label class="petiteligne" id="urineConfirmation"></label></th>

                                        </tr>
                                        <tr>
                                            <th style="width: 25%;"><label class="grandeligne">Acuite Visuelle</label></th>
                                            <th style="width: 10%;"></th>
                                            <th style="width: 65%;"><label class="petiteligne" id="visuelleConfirmation"></label></th>

                                        </tr>
                                        <tr>
                                            <th style="width: 25%;"><label class="grandeligne">Acuite Auditive</label></th>
                                            <th style="width: 10%;"></th>
                                            <th style="width: 65%;"><label class="petiteligne" id="auditiveConfirmation"></label></th>

                                        </tr>
                                    </table>
                                    <br><br><br>
                                    <hr>
                                    <table>
                                        <tr>
                                            <th style="width: 25%;"><label class="grandeligne"><?php echo lang('antecedant'); ?></label></th>
                                            <th style="width: 10%;"></th>
                                            <th style="width: 65%;"><label class="petiteligne" id="descriptionConfirmation"></label></th>
                                        </tr>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 lab">
                        <a id="retour" class="btn btn-info btn-secondary pull-left" style="padding-top: 10px;">Retour</a>
                        <form role="form" novalidate action="visite/addNew" class="clearfix row" method="post" enctype="multipart/form-data">
                            <input hidden type="text" id="datehidden" name="datehidden" value="">
                            <input hidden type="text" id="patienthidden" name="patienthidden" value="">
                            <input hidden type="text" id="taillehidden" name="taillehidden" value="">
                            <input hidden type="text" id="poidshidden" name="poidshidden" value="">
                            <input hidden type="text" id="perimetrethoraciquehidden" name="perimetrethoraciquehidden" value="">
                            <input hidden type="text" id="systoliquehidden" name="systoliquehidden" value="">
                            <input hidden type="text" id="diastoliquehidden" name="diastoliquehidden" value="">
                            <input hidden type="text" id="textsurcrehidden" name="textsurcrehidden" value="">
                            <input hidden type="text" id="textalbuminehidden" name="textalbuminehidden" value="">
                            <input hidden type="text" id="oeildroitehidden" name="oeildroitehidden" value="">
                            <input hidden type="text" id="oeilgauchehidden" name="oeilgauchehidden" value="">
                            <input hidden type="text" id="oreilledroitehidden" name="oreilledroitehidden" value="">
                            <input hidden type="text" id="oreillegauchehidden" name="oreillegauchehidden" value="">
                            <input hidden type="text" id="descriptionhidden" name="descriptionhidden" value="">
                            <input hidden type="text" id="filehidden" name="img_url" value="">
                            <input type="hidden" id="patient_id" name="patient_id" value="">
                            <button type="submit" name="submit" class="btn btn-info pull-right" style="margin-left:15px"><?php echo lang('submit_effectuer'); ?></button>
                        </form>
                    </div>
                </div>
            </section>
            <!-- page end-->
        </section>
    </form>
</section>


<!--main content end-->
<!--footer start-->
<script src="<?php echo base_url(); ?>common/js/ecomed24.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/paiement.js"></script>
<script>
    $(document).ready(function() {
        var id = 23;
        if (id) {
            $.ajax({
                url: 'lab/getTemplateByIdByJason?id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function(response) {
                var data = CKEDITOR.instances.editor.getData();
                if (response.template.template != null) {
                    var data1 = data + response.template.template;
                    CKEDITOR.instances['editor'].setData(data1)
                    console.log('Succéss ' + data1);
                } else {
                    var data1 = data;
                    console.log('Echec ' + data1);
                    CKEDITOR.instances['editor'].setData(data1);
                }
                CKEDITOR.instances['editor'].setData(data1)
            });
        }

        // });

        $('input[type="file"]').change(function(e) {
            var file = e.target.files[0].name;
            document.getElementById('filehidden').value = file;
            // alert('Le fichier "' + file + '" a été sélectionné.');
        });

        var is_patient = '<?php echo $patient_id; ?>';
        if (is_patient) {
            $.ajax({
                url: 'patient/editPatientByJason?id=' + is_patient,
                method: 'GET',
                data: '',
                dataType: 'json'
            }).success(function(response) {
                var name = response.patient.name + ' ' + response.patient.last_name + '  (Code Patient: ' + response.patient.patient_id + ')';
                var patient_opt = new Option(name, response.patient.id, true, true);
                $('#pos_select').append(patient_opt).trigger('change');
                <?php  $patient_id = '';  if (isset($_GET['patient'])) { $patient_id = $_GET['patient']; }  ?> 
                $('#myModaladdPatient').modal('show');
            });
        }
        $("#pos_select").select2({
            placeholder: 'Selectionnez un patient',
            allowClear: true,
            ajax: {
                url: 'patient/getPatientinfoWithAddNewOption',
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

        $('.ms-selectable input.search-input').attr('placeholder', 'Selectionnez une prestation');

        document.getElementById('redirectaddNew').value = 'visite/ajout';
        var is_patient = '<?php echo $patient_id; ?>';
    });
</script>
<script>
    function recuperationResultat(event) {
        var pignet;
        var taille = $('#taille').val();
        var poids = $('#poids').val();
        var perimetre_thoracique = $('#perimetre_thoracique').val();
        var poidsThoracique = parseInt(poids) + parseInt(perimetre_thoracique);
        var pignetVisible = document.getElementById('pignetVisible');
        pignet = parseInt(taille) - poidsThoracique;
        pignetVisible.style['display'] = 'block';
        $('#pignetRecuperer').html(``);
        if (taille > 1 && poids > 1 && perimetre_thoracique > 1) {
            if (pignet <= 15) {
                pignetVisible.style['display'] = 'none';
                $('#pignetRecuperer').html(`
                <span style="background-color:#07864F;color:#FFFFFF" class="form-control pay_in ">Apte à tous travaux</span>  
                `);
            } else if (pignet >= 16 && pignet <= 25) {
                pignetVisible.style['display'] = 'none';
                $('#pignetRecuperer').html(`
                <span style="background-color:#FFD30C;color:#FFFFFF" class="form-control pay_in ">Apte aux travaux moyens</span>  
                `);
            } else if (pignet >= 26 && pignet <= 35) {
                pignetVisible.style['display'] = 'none';
                $('#pignetRecuperer').html(`
                <span style="background-color:#FFA60C;color:#FFFFFF" class="form-control pay_in ">Apte aux travaux légers</span>  
                `);
            } else if (pignet >= 35) {
                pignetVisible.style['display'] = 'none';
                $('#pignetRecuperer').html(`
                <span style="background-color:#FF2C0C;color:#FFFFFF" class="form-control pay_in ">Inapte</span>  
                `);
            }

        }

    }


    function tensionArterielles(event) {
        var systolique = $('#systolique').val();
        systolique = parseInt(systolique);
        var diastolique = $('#diastolique').val();
        diastolique = parseInt(diastolique);
        var tensionArterielle = document.getElementById('tensionArterielle');
        tensionArterielle.style['display'] = 'block';
        $('#tension').html(``);
        if (systolique > 0 && diastolique > 0) {
            if ((systolique >= 0 && systolique <= 100) && (diastolique >= 0 && diastolique <= 60)) {
                tensionArterielle.style['display'] = 'none';
                $('#tension').html(`
                <span style="background-color:#ffa680;color:#FFFFFF" class="form-control pay_in ">Faible</span>  
                `);
            } 
            else if ((systolique >= 100 && systolique <= 120) && (diastolique >= 60 && diastolique <= 80)) {
                tensionArterielle.style['display'] = 'none';
                $('#tension').html(`
                <span style="background-color:#07864F;color:#FFFFFF" class="form-control pay_in ">Optimale</span>  
                `);
            } else if ((systolique >= 120 && systolique <= 130) && (diastolique >= 80 && diastolique <= 85)) {
                tensionArterielle.style['display'] = 'none';
                $('#tension').html(`
                <span style="background-color:#09B56A;color:#FFFFFF" class="form-control pay_in ">Normale</span>  
                `);
            } else if ((systolique >= 130 && systolique <= 139) && (diastolique >= 85 && diastolique <= 89)) {
                tensionArterielle.style['display'] = 'none';
                $('#tension').html(`
                <span style="background-color:#B7FF0C;color:#FFFFFF" class="form-control pay_in ">Normale haute</span>  
                `);
            } else if ((systolique >= 140 && systolique <= 159) && (diastolique >= 90 && diastolique <= 99)) {
                tensionArterielle.style['display'] = 'none';
                $('#tension').html(`
                <span style="background-color:#FFD30C;color:#FFFFFF" class="form-control pay_in ">Hypertention de niveau 1</span>  
                `);
            } else if ((systolique >= 160 && systolique <= 179) || (diastolique >= 100 && diastolique <= 109)) {
                tensionArterielle.style['display'] = 'none';
                $('#tension').html(`
                <span style="background-color:#FFA60C;color:#FFFFFF" class="form-control pay_in ">Hypertention de niveau 2</span>  
                `);
            } else if ((systolique >= 180) && (diastolique >= 110)) {
                tensionArterielle.style['display'] = 'none';
                $('#tension').html(`
                <span style="background-color:#FF2C0C;color:#FFFFFF" class="form-control pay_in ">Hypertention de niveau 3</span>  
                `);
            }
        }

        //Taille en centimètre-(poids+perimètre thoracique)
    }


    $("#continuer").click(function(e) {
        var liste, texte;
        var date = $('#dateViste').val();
        var patient_id = document.getElementById('pos_select');
        var typeValueid = patient_id.value;
        var description = CKEDITOR.instances['editor'].getData();
        liste = document.getElementById("pos_select");
        var patient = liste.options[liste.selectedIndex].text;
        var sucre = document.getElementById('sucre');
        var textsurcre = sucre.value;
        var albumine = document.getElementById('albumine');
        var textalbumine = albumine.value;
        var systolique = $('#systolique').val();
        var diastolique = $('#diastolique').val();
        var taille = $('#taille').val();
        var poids = $('#poids').val();
        var perimetre_thoracique = $('#perimetre_thoracique').val();
        var oeildroite = $("#oeildroite").val();
        var oeilgauche = $("#oeilgauche").val();
        var oreilledroite = $("#oreilledroite").val();
        // alert(description);
        var oreillegauche = $("#oreillegauche").val();
        // alert(patient + " " + date + " " + description + " " + systolique + " " + diastolique + " " + taille + " " + poids + " " + perimetre_thoracique + " " + textsurcre + " " + textalbumine + " " + oeildroite + " " + oeilgauche);
        // if (patient != null && date != null && textsurcre != null && systolique != null && diastolique != null && taille != null && poids != null && perimetre_thoracique != null && oeildroite != null && oeilgauche != null) {
        //     alert("not null");
        // }

        var visitegeneral = document.getElementById('visitegenerale');
        visitegenerale.style['display'] = 'none';
        var visitegeneral = document.getElementById('pageconfirmation');
        window.scrollTo(0, 0);
        pageconfirmation.style['display'] = 'block';

        document.querySelector('#dateConfirmation').innerHTML = date;
        document.querySelector('#patientConfirmation').innerHTML = patient;
        document.querySelector('#pignetConfirmation').innerHTML = 'Taille:' + taille + ' cm | ' + 'Poids: ' + poids + ' kg | ' + 'Périmètre Thoracique: ' + perimetre_thoracique + ' (cm)';
        document.querySelector('#tensionArterielleConfirmation').innerHTML = 'T.Systolique: ' + systolique + ' (mmHg) | ' + 'T.Diastolique: ' + diastolique + ' (mmHg)';
        document.querySelector('#urineConfirmation').innerHTML = 'Sucre: ' + textsurcre + ' | ' + 'Albumine: ' + textalbumine;
        document.querySelector('#visuelleConfirmation').innerHTML = 'Oeil droit: ' + oeildroite + '/10 | ' + 'Oeil gauche' + oeilgauche + '/10';
        document.querySelector('#auditiveConfirmation').innerHTML = 'Oreille droite: ' + oreilledroite + '/10 | ' + 'Oreille gauche ' + oreillegauche + '/10';
        document.querySelector('#descriptionConfirmation').innerHTML = description;


        // Les inputs hidden
        document.getElementById('datehidden').value = date;
        document.getElementById('patienthidden').value = patient;
        document.getElementById('taillehidden').value = taille;
        document.getElementById('poidshidden').value = poids;
        document.getElementById('perimetrethoraciquehidden').value = perimetre_thoracique;
        document.getElementById('systoliquehidden').value = systolique;
        document.getElementById('diastoliquehidden').value = diastolique;
        document.getElementById('textsurcrehidden').value = textsurcre;
        document.getElementById('textalbuminehidden').value = textalbumine;
        document.getElementById('oeildroitehidden').value = oeildroite;
        document.getElementById('oeilgauchehidden').value = oeilgauche;
        document.getElementById('oreilledroitehidden').value = oreilledroite;
        document.getElementById('oreillegauchehidden').value = oreillegauche;
        document.getElementById('descriptionhidden').value = description;
        document.getElementById('patient_id').value = typeValueid;

    });

    $("#retour").click(function(e) {
        var visitegeneral = document.getElementById('visitegenerale');
        visitegenerale.style['display'] = 'block';
        var visitegeneral = document.getElementById('pageconfirmation');
        pageconfirmation.style['display'] = 'none';
    });

    function conditionOeilGauche() {
        var oeilgauche = $("#oeilgauche").val();
        var bt = document.getElementById('continuer');
        var montantGauche = document.getElementById('montantGauche');
        montantGauche.style['display'] = 'none';
        if (oeilgauche >= 11) {
            bt.disabled = true;
            montantGauche.style['display'] = 'block';
        } else {
            bt.disabled = false;
            montantGauche.style['display'] = 'none';
        }

    }

    function conditionOeilDroite() {
        var oeildroite = $("#oeildroite").val();
        var bt = document.getElementById('continuer');
        var montantID = document.getElementById('montantID');
        montantID.style['display'] = 'none';
        if (oeildroite >= 11) {
            bt.disabled = true;
            montantID.style['display'] = 'block';
        } else {
            bt.disabled = false;
            montantID.style['display'] = 'none';
        }

    }

    function conditionOreilleDroite() {
        var oreilledroite = $("#oreilledroite").val();
        var bt = document.getElementById('continuer');
        var montantoreilledroite = document.getElementById('montantoreilledroite');
        montantoreilledroite.style['display'] = 'none';
        if (oreilledroite >= 11) {
            bt.disabled = true;
            montantoreilledroite.style['display'] = 'block';
        } else {
            bt.disabled = false;
            montantoreilledroite.style['display'] = 'none';
        }

    }

    function conditionOreilleGauche() {
        var oreillegauche = $("#oreillegauche").val();
        var bt = document.getElementById('continuer');
        var montantoreillegauche = document.getElementById('montantoreillegauche');
        montantoreillegauche.style['display'] = 'none';
        if (oreillegauche >= 11) {
            bt.disabled = true;
            montantoreillegauche.style['display'] = 'block';
        } else {
            bt.disabled = false;
            montantoreillegauche.style['display'] = 'none';
        }

    }

    // $(document).ready(function() {
    //     $('input[type="file"]').change(function(e) {
    //         var file = e.target.files[0].name;
    //         document.getElementById('filehidden').value = file;
    //         // alert('Le fichier "' + file + '" a été sélectionné.');
    //     });
    // });
</script>