<style>
    p.dotted {
        border-style: dotted;
    }

    p.dashed {
        border-style: dashed;
    }

    p.solid {
        border-style: solid;
    }

    p.double {
        border-style: double;
    }

    p.groove {
        border-style: groove;
    }

    p.ridge {
        border-style: ridge;
    }

    p.inset {
        border-style: inset;
    }

    p.outset {
        border-style: outset;
    }

    p.none {
        border-style: none;
    }

    p.hidden {
        border-style: hidden;
    }

    p.mix {
        border-style: dotted dashed solid double;
    }
</style>

<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="container-fluid invoice-container col-md-12">
            <div style="display:none">
                <?php
                $prestation = '';
                if (isset($_GET['prestation'])) {
                    $prestation = $_GET['prestation'];
                }
                $payment = '';
                if (isset($_GET['payment'])) {
                    $payment = $_GET['payment'];
                }
                $mode = '';
                if (isset($_GET['mode'])) {
                    $mode = $_GET['mode'];
                }
                $patient_id = '';
                if (isset($_GET['id'])) {
                    $patient_id = $_GET['id'];
                }
                $email_light = '';
                if (isset($_GET['emaillight'])) {
                    $email_light = $_GET['emaillight'];
                }

                $id_light = '';
                if (isset($_GET['idlight'])) {
                    $id_light = $_GET['idlight'];
                    $id_light_info = $this->db->get_where('organisation', array('id' => $id_light))->row();
                }
                $typ = '';
                if (isset($_GET['typ'])) {
                    $typ = $_GET['typ'];
                } ?>
            </div>
            <!-- Header -->
            <style>
                .titreResultat {
                    background-color: #F5F5F5;
                    color: #0D4D99;
                    font-weight: bold;
                    font-style: italic;
                    font-size: 1.5em;
                    text-align: center;
                    height: 40px;
                }

                .rowStyle {
                    background-color: #0D4D99;
                    color: #ffffff;
                }

                .invoice-container {
                    border: 1px solid #eee !important;
                }
            </style>
            <div class="panel panel-primary" id="invoice">
                <header>
                    <div class="row align-items-center">
                        <div class="col-sm-12 text-center text-sm-left mb-3 mb-sm-0">
                            <img id="logo" src="<?php echo !empty($entete) ? $entete : "uploads/entetePartenaires/default.png"; ?>" style="max-width:100%;max-height:150px" title="Koice" alt="Koice" />
                            <input hidden type="text" id="logo2" value="<?php echo !empty($entete) ? $entete : "uploads/entetePartenaires/default.png"; ?>">
                        </div>
                    </div>
                </header>
                <main>
                    <input type="hidden" name="payment_id" value="<?php echo $payments->id; ?>">
                    <div class="form-group col-md-4">
                        <label> <?php echo lang('first_name'); ?></label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" value='<?php echo $patient->name; ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('last_name'); ?></label>
                        <input type="text" class="form-control" name="last_name" id="exampleInputEmail1" value='<?php echo $patient->last_name; ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('patient_ids'); ?></label>
                        <input type="text" class="form-control" name="patient_id" id="exampleInputEmail1" value='<?php echo $patient->id; ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('date_of_birth'); ?></label>
                        <input type="text" class="form-control" name="birthdate" id="exampleInputEmail1" value='<?php echo $patient->birthdate; ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="exampleInputEmail1"> <?php echo lang('age'); ?></label>
                        <input type="text" class="form-control" name="age" id="exampleInputEmail1" value='<?php echo $patient->age; ?>' placeholder="" readonly="">
                        <input type="hidden" class="form-control" name="phone" id="exampleInputEmail1" value='<?php echo $patient->phone; ?>' placeholder="">
                        <input type="hidden" class="form-control" name="email" id="exampleInputEmail1" value='<?php echo $patient->email; ?>' placeholder="">
                        <input type="hidden" class="form-control" name="passport" id="exampleInputEmail1" value='<?php echo $patient->passport; ?>' placeholder="">
                        <input type="hidden" class="form-control" name="id_presta" id="exampleInputEmail1" value='<?php echo $prestation; ?>' placeholder="">
                    </div>

                    <div class="form-group col-md-2">
                        <label for="exampleInputEmail1"> <?php echo lang('gender'); ?></label>
                        <input type="text" class="form-control" name="sex" id="exampleInputEmail1" value='<?php echo $patient->sex; ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('address'); ?></label>
                        <input type="text" class="form-control" name="address" id="exampleInputEmail1" value='<?php echo $patient->address; ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Prescripteur Pr/Dr/Mme/Mr/</label>
                        <input type="text" class="form-control" name="doctor" id="exampleInputEmail1" value='<?php if (!empty($payments->doctor_name)) {
                                                                                                                    echo $payments->doctor_name;
                                                                                                                } else echo 'Non renseigné '  ?>' placeholder="" readonly="">
                        <input type="hidden" name="doctor" value="<?php echo $payments->doctor_name ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Date prescription</label>
                        <input type="text" class="form-control" name="dateprescription" id="exampleInputEmail1" value='<?php echo $payments->date_string; ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('report_id'); ?></label>
                        <input type="text" class="form-control" name="code_identifiant" id="exampleInputEmail1" value='<?php
                                                                                                                        if (!empty($resulLab->numero_identifiant)) {
                                                                                                                            echo $resulLab->numero_identifiant;
                                                                                                                        } else {
                                                                                                                            echo $payments->code . '-LAB-' . $prestation;
                                                                                                                        }
                                                                                                                        ?>' placeholder="" readonly="">
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Numéro de Régistre</label>
                        <input type="text" class="form-control" name="numeroRegistre" id="exampleInputEmail1" value='<?php
                                                                                                                        if (!empty($resulLab->numeroRegistre)) {
                                                                                                                            echo $resulLab->numeroRegistre;
                                                                                                                        } else {
                                                                                                                            echo $payments->code . '-LAB-' . $prestation;
                                                                                                                        }
                                                                                                                        ?>' placeholder="" readonly="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"><?php echo lang('sampling_date_time'); ?></label>
                        <div class="input-group" id="id_0">
                            <input type="text" value="<?php
                                                        if (!empty($resulLab->date_prelevement)) {
                                                            echo $resulLab->date_prelevement;
                                                        }
                                                        ?>" class="form-control <?php if (empty($resulLab->date_prelevement)) { ?> datetimepicker_ip <?php } ?>" name="date_prevelement" required="" autocomplete="off" readonly="">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1">Renseignement Clinique</label>
                        <textarea rows="3" cols="35" name="renseignementClinique" readonly=""><?php echo $payments->renseignementClinique; ?></textarea>
                    </div>


                    <div class=" no-print">
                        <span class="hr"></span>
                        <div class="panel-heading" style="background-color: #F5F5F5;
                    color: #0D4D99;
                    font-weight: bold;
                    font-style: italic;
                    font-size: 1.5em;
                    text-align: center;">R&Eacute;SULTATS DES ANALYSES</div>
                    </div>
                    <?php if (!empty($origins->category_name)) {
                        $category_name = $origins->category_name;
                        $category_name1 = explode(',', $category_name);
                        $i = 0;
                        $cat = array();
                        foreach ($category_name1 as $key => $category_name2) {
                            $category_name3 = explode('*', $category_name2);
                            if ($category_name3[3] > 0 && $category_name3[1]) {
                                $value = $this->finance_model->editCategoryServiceBySpe($category_name3[0]);
                                $cat[$value->id_spe][$key] = $value;
                            }
                        }
                    }
                    if (!empty($origins->category_name)) {

                        foreach ($cat as $key => $category_name) {
                            $category_nameid =  current($category_name);
                            if ($category_nameid) {
                                $valuep = $category_nameid->name_specialite;


                                if ($valuep != 'Frais de Service') {
                    ?>

                                    <div class="row">
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-8">
                                            <h4 style="text-align:center;font-size:1.2em;color: #0D4D99;font-weight:bold"><?php echo $valuep ?></h4>
                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                    </div>

                                    <?php  }
                                foreach ($category_name as $category_name2) {

                                    if ($category_name2) {
                                        $count_prestation = $this->finance_model->parametreValueCount($category_name2->id);
                                        $count_prestation = intval($count_prestation->nombre);
                                        if ($count_prestation > 1) {
                                            if ($category_name2->prestation != 'Frais de Service') { ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel-heading" style="background-color: #F5F5F5">
                                                            <h5 style="
                        color: #0D4D99;
                        font-weight: bold;
                        font-style: italic;
                        font-size: 0.7em;
                        height: 10px;
                        text-align: center;"><?php echo  $category_name2->prestation; ?></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <?php

                                                $tabbs = $this->finance_model->existResultatsPara($payment, intval($category_name2->id));

                                                foreach ($tabbs as $tabb) {

                                                    $tabPresta = array();
                                                    $resultat = $tabb->resultats;
                                                    $para = $tabb->id_para;
                                                    $presta = $tabb->id_presta;
                                                    $tab = $this->finance_model->parametreValue($para);
                                                    $unite = $tab->unite ? $tab->unite : '';
                                                    $valeurs = $tab->valeurs ? $tab->valeurs : '';
                                                    $ref_low = $tab->ref_low ? $tab->ref_low : '';
                                                    $ref_high = $tab->ref_high ? $tab->ref_high : '';
                                                    $ref_type = $tab->type ? $tab->type : '';
                                                    $modele =  '';
                                                    if ($presta && $this->id_organisation) {
                                                        $modeleTab = $this->home_model->getModeleByLaboPaiement($presta, $this->id_organisation);
                                                        if (!empty($modeleTab)) {
                                                            $modele = $modeleTab->is_modele;
                                                        }
                                                    }
                                                    if ($ref_type == 'section') {
                                                ?>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <h4 style="font-size:1.0em;font-weight:bold"><?php if (empty($tab->nom_parametre)) {
                                                                                                                    echo $category_name2->prestation;
                                                                                                                } else {
                                                                                                                    echo $tab->nom_parametre;
                                                                                                                } ?></h4>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <h4 style="font-size:0.9em;font-weight:bold"></h4>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <h4 style="font-size:0.9em;font-style:italic"></h4>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <h4 style="font-size:0.9em;font-style:italic"></h4>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    <?php }
                                                    if ($ref_type == 'sous_section') { ?>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <h4 style="font-size:0.9em;font-weight:bold"><?php if (empty($tab->nom_parametre)) {
                                                                                                                    echo $category_name2->prestation;
                                                                                                                } else {
                                                                                                                    echo $tab->nom_parametre;
                                                                                                                } ?></h4>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <h4 style="font-size:0.9em;font-weight:bold"></h4>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <h4 style="font-size:0.9em;font-style:italic"></h4>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <h4 style="font-size:0.9em;font-style:italic"></h4>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    <?php }
                                                    if ($ref_type == 'numerical') { ?>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <h4 style="font-size:0.9em;font-weight:bold"><?php if (empty($tab->nom_parametre)) {
                                                                                                                    echo $category_name2->prestation;
                                                                                                                } else {
                                                                                                                    echo $tab->nom_parametre;
                                                                                                                } ?></h4>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <h4 style="font-size:0.9em;font-weight:bold"><?php echo $resultat; ?></h4>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <h4 style="font-size:0.9em;font-style:italic"><?php echo $unite; ?></h4>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <h4 style="font-size:0.9em;font-style:italic"><?php if (empty($valeurs)) {
                                                                                                                    if ($ref_high) {
                                                                                                                        echo $ref_low . ' - ' . $ref_high;
                                                                                                                    }
                                                                                                                } else echo $valeurs; ?></h4>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    <?php }
                                                    if ($ref_type == 'textcode') { ?>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <h4 style="font-size:0.9em;font-weight:bold"><?php if (empty($tab->nom_parametre)) {
                                                                                                                    echo $category_name2->prestation;
                                                                                                                } else {
                                                                                                                    echo $tab->nom_parametre;
                                                                                                                } ?></h4>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <p class="groove"><?php echo $resultat; ?></p>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    <?php }
                                                    if ($ref_type == 'setofcode') { ?>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <h4 style="font-size:0.9em;font-weight:bold"><?php if (empty($tab->nom_parametre)) {
                                                                                                                    echo $category_name2->prestation;
                                                                                                                } else {
                                                                                                                    echo $tab->nom_parametre;
                                                                                                                } ?></h4>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <h4 style="font-size:0.9em;font-weight:bold"><?php echo $resultat; ?></h4>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <h4 style="font-size:0.9em;font-style:italic"></h4>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <h4 style="font-size:0.9em;font-style:italic"><?php if (empty($valeurs)) {
                                                                                                                    if ($ref_high) {
                                                                                                                        echo $ref_low . ' - ' . $ref_high;
                                                                                                                    }
                                                                                                                } else echo $valeurs; ?></h4>
                                                            </div>
                                                        </div>
                                                        <br>
                                                <?php
                                                    }
                                                }
                                            }
                                        } else {

                                            if ($category_name2->prestation != 'Frais de Service') { ?>
                                                <br>
                                                <?php

                                                $tabbs = $this->finance_model->existResultatsPara($payment, intval($category_name2->id));

                                                foreach ($tabbs as $tabb) {

                                                    $tabPresta = array();
                                                    $resultat = $tabb->resultats;
                                                    $para = $tabb->id_para;
                                                    $presta = $tabb->id_presta;
                                                    $tab = $this->finance_model->parametreValue($para);
                                                    $unite = $tab->unite ? $tab->unite : '';
                                                    $valeurs = $tab->valeurs ? $tab->valeurs : '';
                                                    $ref_low = $tab->ref_low ? $tab->ref_low : '';
                                                    $ref_high = $tab->ref_high ? $tab->ref_high : '';
                                                    $ref_type = $tab->type ? $tab->type : '';
                                                    $modele =  '';
                                                    if ($presta && $this->id_organisation) {
                                                        $modeleTab = $this->home_model->getModeleByLaboPaiement($presta, $this->id_organisation);
                                                        if (!empty($modeleTab)) {
                                                            $modele = $modeleTab->is_modele;
                                                        }
                                                    }
                                                    if ($ref_type == 'section') {
                                                ?>
                                                        <br>
                                                        <div class="panel-default" style="background-color: #F5F5F5">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <h4 style="font-size:1.0em;font-weight:bold;padding-top:5px"><?php if (empty($tab->nom_parametre)) {
                                                                                                                                        echo $category_name2->prestation;
                                                                                                                                    } else {
                                                                                                                                        echo $tab->nom_parametre;
                                                                                                                                    } ?></h4>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <h4 style="font-size:0.9em;font-weight:bold;padding-top:5px"></h4>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <h4 style="font-size:0.9em;font-style:italic;padding-top:5px"></h4>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <h4 style="font-size:0.9em;font-style:italic;padding-top:5px"></h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    <?php }
                                                    if ($ref_type == 'sous_section') { ?>
                                                        <div class="panel-default" style="background-color: #F5F5F5">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <h4 style="font-size:0.9em;font-weight:bold;padding-top:5px"><?php if (empty($tab->nom_parametre)) {
                                                                                                                                        echo $category_name2->prestation;
                                                                                                                                    } else {
                                                                                                                                        echo $tab->nom_parametre;
                                                                                                                                    } ?></h4>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <h4 style="font-size:0.9em;font-weight:bold;padding-top:5px"></h4>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <h4 style="font-size:0.9em;font-style:italic;padding-top:5px"></h4>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <h4 style="font-size:0.9em;font-style:italic;padding-top:5px"></h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    <?php }
                                                    if ($ref_type == 'numerical') { ?>
                                                        <div class="panel-default" style="background-color: #F5F5F5">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <h4 style="font-size:0.9em;font-weight:bold;padding-top:5px"><?php if (empty($tab->nom_parametre)) {
                                                                                                                                        echo $category_name2->prestation;
                                                                                                                                    } else {
                                                                                                                                        echo $tab->nom_parametre;
                                                                                                                                    } ?></h4>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <h4 style="font-size:0.9em;font-weight:bold;padding-top:5px"><?php echo $resultat; ?></h4>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <h4 style="font-size:0.9em;font-style:italic;padding-top:5px"><?php echo $unite; ?></h4>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <h4 style="font-size:0.9em;font-style:italic;padding-top:5px"><?php if (empty($valeurs)) {
                                                                                                                                        if ($ref_high) {
                                                                                                                                            echo $ref_low . ' - ' . $ref_high;
                                                                                                                                        }
                                                                                                                                    } else echo $valeurs; ?></h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <br>
                                                    <?php }
                                                    if ($ref_type == 'textcode') { ?>
                                                        <div class="panel-default" style="background-color: #F5F5F5">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <h4 style="font-size:0.9em;font-weight:bold;padding-top:5px"><?php if (empty($tab->nom_parametre)) {
                                                                                                                                        echo $category_name2->prestation;
                                                                                                                                    } else {
                                                                                                                                        echo $tab->nom_parametre;
                                                                                                                                    } ?></h4>
                                                                </div>
                                                                <div class="col-md-9" style="padding-top:5px">
                                                                    <p class="groove"><?php echo $resultat; ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    <?php }
                                                    if ($ref_type == 'setofcode') { ?>
                                                        <div class="panel-default" style="background-color: #F5F5F5">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <h4 style="font-size:0.9em;font-weight:bold;padding-top:5px"><?php if (empty($tab->nom_parametre)) {
                                                                                                                        echo $category_name2->prestation;
                                                                                                                    } else {
                                                                                                                        echo $tab->nom_parametre;
                                                                                                                    } ?></h4>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <h4 style="font-size:0.9em;font-weight:bold;padding-top:5px"><?php echo $resultat; ?></h4>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <h4 style="font-size:0.9em;font-style:italic;padding-top:5px"></h4>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <h4 style="font-size:0.9em;font-style:italic;padding-top:5px"><?php if (empty($valeurs)) {
                                                                                                                        if ($ref_high) {
                                                                                                                            echo $ref_low . ' - ' . $ref_high;
                                                                                                                        }
                                                                                                                    } else echo $valeurs; ?></h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                    <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    ?>
                    <p>&nbsp;</p>

                    <br><br>


                    <div class="col-md-4 invoice_head_left">
                        <img class="qr_code" src="<?php echo base_url(); ?>uploads/qrcode/<?php echo $payments->qr_code; ?>" width="150" height="150" alt="alt" />

                    </div>
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4 invoice_head_right">
                        <img src="<?php echo $signature ?>" style="margin-top:-25px" width="250" height="250" alt="alt" />
                    </div>
                    <div class="col-md-12 invoice_head clearfix">
                        <p style="font-style: italic;font-size:1em">Scanner ce QR Code à l'aide de votre Smartphone connecté à internet pour vérifier l'authenticité des informations contenues dans ce document</p>
                    </div>






                    <input type="hidden" name="prestation" value="<?php echo $prestation; ?>">
                    <input type="hidden" name="payment" value="<?php echo $payment; ?>">

                    <input type="hidden" name="patient" value="<?php echo $patient_id; ?>">


            </div>
        </div>
        </div>
        <div class="col-md-8">
            <a class="btn btn-info btn-secondary pull-left" href="finance/paymentLabo"><?php echo lang('retour'); ?></a>
            <a class="btn btn-info btn-sm invoice_button pull-left" href="<?php echo base_url(); ?>uploads/invoicefile/lab-report--00<?php echo $payments->id . '.pdf'; ?>" onclick="window.open(this.href, 'PDF', 'height=800, width= 1000, top=100, left=300, toolbar=no, menubar=no, location=no, resizable=yes, scrollbars=no,status=no' );return false;"><i class="fa fa-print"></i>Imprimer</a>
            <a class="btn btn-info btn-xs btn_width" href="<?php echo base_url(); ?>uploads/invoicefile/lab-report--00<?php echo $payments->id . '.pdf'; ?>" download> <i class="fa fa-download"></i>Télécharger</a>

            <?php
            if (empty($payments->transfer)) {
                if ($this->ion_auth->in_group(array('Laboratorist', 'Biologiste', 'admin' . 'Receptionist', 'Assistant', 'adminmedecin', 'Doctor'))) {
            ?>

                    <?php if (!empty($email_light)) { ?>
                        <button id="transferlight" data-id="<?php echo $payments->id ?>" class="btn btn-info green btn-sm">
                            <i class="fa fa-paper-plane"></i> <?php if (!empty($email_light)) {
                                                                    echo 'Envoyer à ' . $id_light_info->nom;
                                                                } else {
                                                                    echo lang('transfert');
                                                                }  ?>
                        </button>
                    <?php } else { ?>
                        <button id="transfer" data-id="<?php echo $payments->id ?>" class="btn btn-info green btn-sm">
                            <i class="fa fa-paper-plane"></i> <?php echo lang('transfert');
                                                            }  ?>
                        </button>
                    <?php } ?>

                    <!-- <a class="btn btn-info btn-sm  pull-left" href="lab/transfer?id="><i class="fa fa-paper-plane"></i> <?php echo lang('transfert'); ?> </a> -->

                <?php

            }
                ?>
        </div>






    </section>



    <style>
        th {
            text-align: center;
        }

        td {
            text-align: center;
        }

        tr.total {
            color: green;
        }



        .control-label {
            width: 100px;
        }



        h1 {
            margin-top: 5px;
        }


        .print_width {
            width: 50%;
            float: left;
        }

        ul.amounts li {
            padding: 0px !important;
        }

        .invoice-list {
            margin-bottom: 10px;
        }




        .panel {
            border: 0px solid #5c5c47;
            background: #fff !important;
            height: 100%;
            margin: 20px 5px 5px 5px;
            border-radius: 0px !important;

        }



        .table.main {
            margin-top: -50px;
        }



        .control-label {
            margin-bottom: 0px;
        }

        tr.total td {
            color: green !important;
        }

        .theadd th {
            background: #edfafa !important;
        }

        td {
            font-size: 12px;
            padding: 5px;
            font-weight: bold;
        }

        .details {
            font-weight: bold;
        }

        hr {
            border-bottom: 2px solid green !important;
        }

        .corporate-id {
            margin-bottom: 5px;
        }

        .adv-table table tr td {
            padding: 5px 10px;
        }



        .btn {
            margin: 10px 10px 10px 0px;
        }












        @media print {

            h1 {
                margin-top: 5px;
            }

            #main-content {
                padding-top: 0px;
            }

            .print_width {
                width: 50%;
                float: left;
            }

            ul.amounts li {
                padding: 0px !important;
            }

            .invoice-list {
                margin-bottom: 10px;
            }

            .wrapper {
                margin-top: 0px;
            }

            .wrapper {
                padding: 0px 0px !important;
                background: #fff !important;

            }



            .wrapper {
                border: 2px solid #777;
                min-height: 910px;
            }

            .panel {
                border: 0px solid #5c5c47;
                background: #fff !important;
                padding: 0px 0px;
                height: 100%;
                margin: 5px 5px 5px 5px;
                border-radius: 0px !important;

            }



            .table.main {
                margin-top: -50px;
            }



            .control-label {
                margin-bottom: 0px;
            }

            tr.total td {
                color: green !important;
            }

            .theadd th {
                background: #edfafa !important;
            }

            td {
                font-size: 12px;
                padding: 5px;
                font-weight: bold;
            }

            .details {
                font-weight: bold;
            }

            hr {
                border-bottom: 2px solid green !important;
            }

            .corporate-id {
                margin-bottom: 5px;
            }

            .adv-table table tr td {
                padding: 5px 10px;
            }
        }
    </style>









</section>

</section>
</section>
<div class="modal fade" id="transferModallight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('transfert'); ?> </h4>
            </div>
            <div class="modal-body">
                <form role="form" id="transferLabReport" action="finance/transferLaboLight" class="clearfix" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-12">
                        <label class="radio-inline"><input type="radio" class="medium" name="medium" value='email' checked><?php echo lang('email'); ?></label>
                        <label class="radio-inline"><input type="radio" class="medium" name="medium" value='whatsapp' disabled><?php echo lang('whatsapp'); ?> (Bientôt Disponible)</label>
                    </div>
                    <div class="form-group col-md-12 whatsapp hidden">
                        <label for="exampleInputEmail1"> <?php echo lang('whatsapp_number'); ?><span></span></label>
                        <input type="number" class="form-control" name="whatsapp" id="what_num" value="<?php echo $patient->phone; ?>" placeholder="">
                    </div>
                    <div class="form-group col-md-12 email_div">
                        <label for="exampleInputEmail1"> <?php echo lang('email'); ?></label>
                        <input type="email" class="form-control" name="email" id="email_id" value="<?php if (!empty($email_light)) {
                                                                                                        echo $email_light;
                                                                                                    } else {
                                                                                                        echo $patient->email;
                                                                                                    }
                                                                                                    ?>" placeholder="" required="">
                        <input type="hidden" id="name_patientEmail" name="name_patient" value="<?php echo $patient->name . ' ' . $patient->last_name; ?>">
                        <input type="hidden" name="id_patient" value="<?php echo $patient->patient_id; ?>">

                    </div>




                    <input type="hidden" name="report_id" value="<?php echo $payments->id; ?>">
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"> <?php echo lang('transfert'); ?> </h4>
            </div>
            <div class="modal-body">
                <form role="form" id="transferLabReport" action="finance/transferLabo" class="clearfix" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-12">
                        <label class="radio-inline"><input type="radio" class="medium" name="medium" value='email' checked><?php echo lang('email'); ?></label>
                        <label class="radio-inline"><input type="radio" class="medium" name="medium" value='whatsapp' disabled><?php echo lang('whatsapp'); ?> (Bientôt Disponible)</label>
                    </div>
                    <div class="form-group col-md-12 whatsapp hidden">
                        <label for="exampleInputEmail1"> <?php echo lang('whatsapp_number'); ?><span></span></label>
                        <input type="number" class="form-control" name="whatsapp" id="what_num" value="<?php echo $patient->phone; ?>" placeholder="">
                    </div>
                    <div class="form-group col-md-12 email_div">
                        <label for="exampleInputEmail1"> <?php echo lang('email'); ?></label>
                        <input type="email" class="form-control" name="email" id="email_id" value="<?php if (!empty($email_light)) {
                                                                                                        echo $email_light;
                                                                                                    } else {
                                                                                                        echo $patient->email;
                                                                                                    }
                                                                                                    ?>" placeholder="" required="">
                        <input type="hidden" id="name_patientEmail" name="name_patient" value="<?php echo $patient->name . ' ' . $patient->last_name; ?>">
                        <input type="hidden" name="id_patient" value="<?php echo $patient->patient_id; ?>">

                    </div>




                    <input type="hidden" name="report_id" value="<?php echo $payments->id; ?>">
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Load Medicine -->
<!-- /.modal-dialog -->

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>


<script>
    $(document).ready(function() {
        $('#transfer').on('click', function() {
            var id = $(this).attr('data-id');
            $('#transferModal').modal('show');
        });
        $('#transferlight').on('click', function() {
            var id = $(this).attr('data-id');
            $('#transferModallight').modal('show');
        });

    });
</script>