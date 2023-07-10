<style>
     .separation {
        width: 100%;
        height: 10px;

    }
    .col-md-6 {
        width: 45%;

    }

    .col-md-7 {
        width: 50%;

    }

    .col-md-3 {
        width: 30%;

    }

    .col-md-5 {
        width: 35%;

    }

    .col-md-9 {
        width: 45%;
    }

    .col-md-2 {
        width: 3%;

    }

    .header_img {
        width: 750px;
        height: 25px;
        margin: -40px;
    }

    .qr_code {
        margin-top: -50px;
        width: 150px;
        height: 150px;
    }

    .signature {
        margin-top: -50px;
        width: 200px;
        height: 200px;

    }

    /* .codesignature {
        
        width: 100%;

    } */



    .col-md-12 {
        width: 100%;

    }

    .invoice_head_right {
        float: right;

    }

    .invoice_head_left {
        float: left;
    }

    h5 {
        font-weight: bold;
        font-style: italic;
        font-size: 0.9em;
        margin: 0px;
    }

    h4 {
        margin: 0px;
        font-size: 0.85em;
    }

    h3 {
        font-size: 0.9em;
    }
</style>
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

    p.groove_specialite {
        border-style: groove;
        color: #0D4D99;
        font-style: italic;
        font-size: 1.0em;
        background-color: #eeeeee;
        text-align: center;
        height: 25px;
        font-weight: bold;
        padding-top: 9px;
        text-decoration: underline;
    }

    p.groove_prestation {
        border-style: groove;
        color: #0D4D99;
        font-style: italic;
        font-size: 0.9em;
        background-color: #eeeeee;
        text-align: center;
        height: 25px;
        font-weight: bold;
        padding-top: 10px;
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
            <header>
                <img class="header_img" src="<?php echo !empty($entete) ? $entete : "uploads/entetePartenaires/default.png"; ?>" alt="alt" />
            </header>
            <?php
            $patient_details = $this->patient_model->getPatientById($payments->patient);
            ?>

            <br><br>
            <div class="col-md-12 invoice_head clearfix">

                <div class="col-md-6 text-left invoice_head_left">
                    <h5>
                        Date: <strong><?php echo date('d/m/Y H:i', $payments->date); ?></strong>
                    </h5>
                    <h5>
                        ID Rapport: <strong><?php echo $payments->code; ?></strong>
                    </h5>
                    <h5>
                        Date de pr&eacute;l&egrave;vement: <strong><?php echo $payments->date_prelevement; ?></strong>
                    </h5>
                    <h5>
                        Prescripteur: <strong><?php echo $payments->doctor_name; ?></strong>
                    </h5>

                    <h5>
                        Date rendue: <strong><?php echo $payments->date_rendu; ?></strong>
                    </h5>



                </div>
                <div class="col-md-6 invoice_head_right">
                    <h5>
                        Pr&eacute;nom et Nom : <strong><?php echo $patient_details->name . ' ' . $patient_details->last_name; ?></strong>
                    </h5>
                    <h5>
                        Code : <strong><?php echo $patient_details->id; ?></strong>
                    </h5>
                    <h5>
                        Age: <strong><?php echo $patient_details->age; ?> An(s)</strong>
                    </h5>
                    <h5>
                        Sexe: <strong><?php if ($patient_details->sex === 'Feminin') {
                                            echo 'Feminin';
                                        } else {
                                            echo 'Masculin';
                                        }; ?></strong>
                    </h5>
                    <h5>
                        Adresse: <strong><?php echo $patient_details->address; ?></strong>
                    </h5>


                </div>



            </div>
            <p class="groove_specialite"><?php echo  $category_name2->prestation; ?>R&Eacute;SULTATS DES ANALYSES</p>
            <table border="0" cellspacing="0" cellpadding="0" style="background-color: #F5F5F5;width:100%">
            <!--<caption>R&Eacute;SULTATS DES ANALYSES</caption>-->
            <thead style="margin-top:5px;">
                <tr>
                    <td class="text-center" style="text-transform:none !important;width:25%;">Analyse(s) Demand&eacute;es</td>
                    <td class="text-center" style="text-transform:none !important;width:30%;text-align:center">R&eacute;sultats</td>
                    <td class="text-center" style="text-transform:none !important;width:15%;">Unit&eacute;</td>
                    <td class="text-center" style="text-transform:none !important;width:35%;">Valeurs Usuelles</td>
                </tr>
            </thead>
            </table>
            <br>
            <div class="separation"></div>
            <?php if (!empty($payments->category_name)) {
                $category_name = $payments->category_name;
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
            if (!empty($payments->category_name)) {

                foreach ($cat as $key => $category_name) {
                    $category_nameid =  current($category_name);
                    if ($category_nameid) {
                        $valuep = $category_nameid->name_specialite;
                        if ($valuep != 'Frais de Service') {
            ?>
                            <div class="col-md-12 invoice_head clearfix">
                                <h4 style="text-align:center;font-size:15px;color: #0D4D99;font-weight:bold;padding-top:-22px;margin:5px"><?php echo $valuep ?></h4>
                            </div>

                            <?php  }
                        foreach ($category_name as $category_name2) {
                            if ($category_name2) {
                                $count_prestation = $this->finance_model->parametreValueCount($category_name2->id);
                                $count_prestation = intval($count_prestation->nombre);
                                if ($count_prestation > 1) {
                                    if ($category_name2->prestation != 'Frais de Service') { ?>
                                        <div class="col-md-12 invoice_head_left  clearfix" style="padding-top: -10px;">
                                            <p class="groove_prestation"><?php echo  $category_name2->prestation; ?></p>
                                        </div>
                                        <?php
                                        $tabbs = $this->finance_model->existResultatsPara($payments->id, intval($category_name2->id));
                                        foreach ($tabbs as $tabb) {


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
                                            if ($ref_type == 'numerical') {
                                        ?>
                                                <div class="col-md-12 invoice_head clearfix">
                                                    <div class="col-md-3 text-left invoice_head_left">
                                                        <h4 style="font-weight:bold"><?php if (empty($tab->nom_parametre)) {
                                                                                            echo $category_name2->prestation;
                                                                                        } else {
                                                                                            echo $tab->nom_parametre;
                                                                                        } ?></h4>
                                                    </div>
                                                    <div class="col-md-3 text-left invoice_head_left">
                                                        <h5 style="font-size:0.8em;font-weight:bold"><?php echo $resultat; ?></h5>
                                                    </div>
                                                    <div class="col-md-2 text-left invoice_head_left">
                                                        <h5 style="font-size:0.8em;text-align:center;font-weight:normal"><?php echo $unite; ?></h5>
                                                    </div>
                                                    <div class="col-md-5 text-right invoice_head_right">
                                                        <h5 style="font-size:0.7em;font-weight:normal"><?php if (empty($valeurs)) {
                                                                                                            if ($ref_high) {
                                                                                                                echo $ref_low . ' - ' . $ref_high;
                                                                                                            }
                                                                                                        } else echo $valeurs; ?></h5>
                                                    </div>
                                                </div>
                                                <div class="separation"></div>
                                            <?php }
                                            if ($ref_type == 'textcode') { ?>
                                                <div class="col-md-12">
                                                    <h4 style="font-weight:bold;padding-top:5px"><?php if (empty($tab->nom_parametre)) {
                                                                                                        echo $category_name2->prestation;
                                                                                                    } else {
                                                                                                        echo $tab->nom_parametre;
                                                                                                    } ?></h4>
                                                    <p style="border-width:0px; border-style:solid; border-color:#000000;margin-left:20px;padding-top:-10px;font-size:0.8em;font-weight:bold"><?php echo $resultat; ?></p>
                                                </div>
                                                <div class="separation"></div>
                                            <?php }
                                            if ($ref_type == 'setofcode') { ?>
                                                <div class="col-md-12 invoice_head clearfix" style="padding-top: -15px ;">
                                                    <div class="col-md-3 text-left invoice_head_left">
                                                        <h4 style="font-weight:bold"><?php if (empty($tab->nom_parametre)) {
                                                                                            echo $category_name2->prestation;
                                                                                        } else {
                                                                                            echo $tab->nom_parametre;
                                                                                        } ?></h4>
                                                    </div>
                                                    <div class="col-md-3 text-left invoice_head_left">
                                                        <h5 style="font-size:0.8em;font-weight:bold"><?php echo $resultat; ?></h5>
                                                    </div>
                                                    <div class="col-md-2 text-left invoice_head_left">
                                                        <h5 style="font-size:0.8em;text-align:center;font-weight:normal"><?php echo $unite; ?></h5>
                                                    </div>
                                                    <div class="col-md-5 text-right invoice_head_right">
                                                        <h5 style="font-size:0.8em;font-weight:normal"><?php if (empty($valeurs)) {
                                                                                                            if ($ref_high) {
                                                                                                                echo $ref_low . ' - ' . $ref_high;
                                                                                                            }
                                                                                                        } else echo $valeurs; ?></h5>
                                                    </div>

                                                </div>
                                                <div class="separation"></div>
                                            <?php

                                            }
                                            if ($ref_type == 'section' || $ref_type == 'sous_section') { ?>
                                                <div class="col-md-12">
                                                    <h3 style="font-weight:bold;text-decoration: underline;float:left"><?php if (empty($tab->nom_parametre)) {
                                                                                                                            echo $category_name2->prestation;
                                                                                                                        } else {
                                                                                                                            echo $tab->nom_parametre;
                                                                                                                        } ?></h3> </em>

                                                </div>
                                        <?php }
                                        } ?> <br>

                                    <?php     }
                                } else {

                                    if ($category_name2->prestation != 'Frais de Service') { ?>
                                        
                                        <?php
                                        $tabbs = $this->finance_model->existResultatsPara($payments->id, intval($category_name2->id));
                                        foreach ($tabbs as $tabb) {


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
                                            if ($ref_type == 'numerical') {
                                        ?>
                                                <div class="panel-default" style="background-color: #F5F5F5">
                                                    <div class="col-md-12 invoice_head clearfix">
                                                        <div class="col-md-3 text-left invoice_head_left">
                                                            <h4 style="font-weight:bold;padding-top:5px"><?php if (empty($tab->nom_parametre)) {
                                                                                                                echo $category_name2->prestation;
                                                                                                            } else {
                                                                                                                echo $tab->nom_parametre;
                                                                                                            } ?></h4>
                                                        </div>
                                                        <div class="col-md-3 text-left invoice_head_left">
                                                            <h5 style="font-size:0.8em;font-weight:bold;padding-top:5px"><?php echo $resultat; ?></h5>
                                                        </div>
                                                        <div class="col-md-2 text-left invoice_head_left">
                                                            <h5 style="font-size:0.8em;text-align:center;font-weight:normal;padding-top:5px"><?php echo $unite; ?></h5>
                                                        </div>
                                                        <div class="col-md-5 text-right invoice_head_right">
                                                            <h5 style="font-size:0.7em;font-weight:normal;padding-top:5px"><?php if (empty($valeurs)) {
                                                                                                                                if ($ref_high) {
                                                                                                                                    echo $ref_low . ' - ' . $ref_high;
                                                                                                                                }
                                                                                                                            } else echo $valeurs; ?></h5>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="separation"></div>
                                            <?php }
                                            if ($ref_type == 'textcode') { ?>
                                                <div class="panel-default" style="background-color: #F5F5F5">
                                                    <div class="col-md-12">
                                                        <h4 style="font-weight:bold;padding-top:5px"><?php if (empty($tab->nom_parametre)) {
                                                                                                            echo $category_name2->prestation;
                                                                                                        } else {
                                                                                                            echo $tab->nom_parametre;
                                                                                                        } ?></h4>
                                                        <p style="border-width:0px; border-style:solid; border-color:#000000;margin-left:20px;padding-top:-5px;font-size:0.8em;font-weight:bold"><?php echo $resultat; ?></p>
                                                    </div>
                                                </div>
                                                <div class="separation"></div>
                                            <?php }
                                            if ($ref_type == 'setofcode') { ?>
                                                <div class="panel-default" style="background-color: #F5F5F5">
                                                    <div class="col-md-12 invoice_head clearfix">
                                                        <div class="col-md-3 text-left invoice_head_left">
                                                            <h4 style="font-weight:bold;padding-top:5px"><?php if (empty($tab->nom_parametre)) {
                                                                                                                echo $category_name2->prestation;
                                                                                                            } else {
                                                                                                                echo $tab->nom_parametre;
                                                                                                            } ?></h4>
                                                        </div>
                                                        <div class="col-md-3 text-left invoice_head_left">
                                                            <h5 style="font-size:0.8em;font-weight:bold;padding-top:5px"><?php echo $resultat; ?></h5>
                                                        </div>
                                                        <div class="col-md-2 text-left invoice_head_left">
                                                            <h5 style="font-size:0.8em;text-align:center;font-weight:normal;padding-top:5px"><?php echo $unite; ?></h5>
                                                        </div>
                                                        <div class="col-md-5 text-right invoice_head_right">
                                                            <h5 style="font-size:0.8em;font-weight:normal;padding-top:5px"><?php if (empty($valeurs)) {
                                                                                                                                if ($ref_high) {
                                                                                                                                    echo $ref_low . ' - ' . $ref_high;
                                                                                                                                }
                                                                                                                            } else echo $valeurs; ?></h5>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="separation"></div>
                                            <?php

                                            }
                                            if ($ref_type == 'section' || $ref_type == 'sous_section') { ?>
                                                <div class="panel-default" style="background-color: #F5F5F5">
                                                    <div class="col-md-12">
                                                        <h3 style="font-weight:bold;text-decoration: underline;float:left"><?php if (empty($tab->nom_parametre)) {
                                                                                                                                echo $category_name2->prestation;
                                                                                                                            } else {
                                                                                                                                echo $tab->nom_parametre;
                                                                                                                            } ?></h3> </em>

                                                    </div>
                                                </div>
                                        <?php }
                                        } ?> <div class="separation"></div>

            <?php     }
                                }
                            }
                        }
                    }
                }
            }
            ?>
            <p>&nbsp;</p>
        </div>

        <div class="col-md-12">
            <img class="qr_code" src="<?php echo base_url(); ?>uploads/qrcode/<?php echo $payments->qr_code; ?>" alt="alt" />
            <img class="signature" style="margin-left: 45%;" src="<?php echo $signature ?>" alt="alt" />
            <p style="font-style: italic;font-size:0.7em">Scanner ce QR Code à l'aide de votre Smartphone connecté à internet pour vérifier l'authenticité des informations contenues dans ce document</p>
        </div>

        </div>

        </div>
        <br>
    </section>
</section>