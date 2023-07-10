<!DOCTYPE html>
<html lang="fr" <?php if ($this->db->get('settings')->row()->language == 'arabic') { ?> dir="rtl" <?php } ?>>

<head>
    <base href="<?php echo base_url(); ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Rizvi">
    <meta name="keyword" content="Php, Hospital, Clinic, Management, Software, Php, CodeIgniter, Hms, Accounting">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>uploads/faviconZ.png">
    <title><?php echo $this->router->fetch_class(); ?> | <?php echo $this->db->get('settings')->row()->system_vendor; ?> </title>
    <!-- Web Fonts INVOICE
======================= -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900' type='text/css'>
    <!-- Bootstrap core CSS -->
    <!-- <link rel="stylesheet" type="text/css" href="common/css/stylesheet2.css"/> -->
    <!-- Web Fonts INVOICE -->

    <link href="<?php echo base_url(); ?>common/css/bootstrap.min.css?<?php echo time(); ?>" rel="stylesheet">
    <link href="<?php echo base_url(); ?>common/css/bootstrap-reset.css?<?php echo time(); ?>" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url(); ?>common/assets/fontawesome5pro/css/all.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>common/assets/DataTables/datatables.css?<?php echo time(); ?>" rel="stylesheet" />
    <!-- <link href="common/assets/font-awesome/css/font-awesome.css" rel="stylesheet" /> -->
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>common/css/style.css?<?php echo time(); ?>" rel="stylesheet">
    <link href="<?php echo base_url(); ?>common/css/style-responsive.css" rel="stylesheet" />
    <link rel="stylesheet" href="common/css/jquery-ui.css" />
    <!--<link rel="stylesheet" href="common/assets/bootstrap-datepicker/css/datepicker.css" /> -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/bootstrap-datetimepicker/css/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/bootstrap-timepicker/compiled/timepicker.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/jquery-multi-select/css/multi-select.css" />
    <link href="<?php echo base_url(); ?>common/css/invoice-print.css" rel="stylesheet" media="print">
    <link href="<?php echo base_url(); ?>common/assets/fullcalendar/fullcalendar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/select2/css/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/css/lightbox.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link href="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/themes/blitzer/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script src="https://github.com/pipwerks/PDFObject/blob/master/pdfobject.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/jquery-ui.js" type="text/javascript"></script>

    <!-- Google Fonts -->

    <style>
        @import url('https://fonts.googleapis.com/css?family=Ubuntu&display=swap');
    </style>
</head>

<body>
    <?php
    $patient_details = $this->patient_model->getPatientById($payments->patient);
    $entete = $this->home_model->get_entete($payments->id_organisation);
    $footer = $this->home_model->get_footer($payments->id_organisation);

    ?>
    <header>
        <img class="header_img" src="<?php echo !empty($entete) ? $entete : "uploads/entetePartenaires/default.png"; ?>" width="750" height="120" alt="alt" />
    </header>



    <div class="col-md-12 invoice_head clearfix">

        <div class="col-md-6 text-left invoice_head_left">
            <h5>
                Date: <strong><?php echo date('d/m/Y', $payments->date) ?></strong>
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
                Code : <strong><?php echo $patient_details->patient_id; ?></strong>
            </h5>
            <h5>
                Age: <strong><?php echo $patient_details->age; ?> An(s) / years</strong>
            </h5>
            <h5>
                Sexe: <strong><?php if ($patient_details->sex === 'Feminin') {
                                    echo 'Feminin / Female';
                                } else {
                                    echo 'Masculin / Male';
                                }; ?></strong>
            </h5>
            <h5>
                Adresse: <strong><?php echo $patient_details->address; ?></strong>
            </h5>


        </div>



    </div>
    <br>
    <div class="panel panel-default">
        <div class="panel" style="background-color:#eeeeee; text-align:center;">
            <h4 style="color:#0D4D99;font-weight: bold;font-style: italic;font-size: 1.2em;">R&Eacute;SULTATS DES ANALYSES</h4>
        </div>
    </div>

    <div class="col-md-12 lab pad_bot" id="report_group">
        <table border="0" cellspacing="0" cellpadding="0">
            <!--<caption>R&Eacute;SULTATS DES ANALYSES</caption>-->

            <tbody>
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
                                <tr>
                                    <td class="text-center" style="text-transform:none !important;width:25%;"></td>
                                    <td class="text-center" style="text-transform:none !important;font-style: italic; font-size:1.2em;width:30%;color:#0D4D99"></td>
                                    <td class="text-center" style="text-transform:none !important;width:10%;"></td>
                                    <td class="text-center" style="text-transform:none !important;width:35%;"></td>
                                </tr>

                                <tr>
                                    <td class="text-center" style="text-transform:none !important;width:25%;"></td>
                                    <td class="text-center" style="text-transform:none !important;font-style: italic; font-size:1.2em;width:30%;color:#0D4D99;text-align:center"><strong><?php echo $valuep ?></strong></td>
                                    <td class="text-center" style="text-transform:none !important;width:10%;"></td>
                                    <td class="text-center" style="text-transform:none !important;width:35%;"></td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="text-transform:none !important;width:25%;"></td>
                                    <td class="text-center" style="text-transform:none !important;font-style: italic; font-size:1.2em;width:30%;color:#0D4D99"></td>
                                    <td class="text-center" style="text-transform:none !important;width:10%;"></td>
                                    <td class="text-center" style="text-transform:none !important;width:35%;"></td>
                                </tr>
                                <?php  }
                            foreach ($category_name as $category_name2) {
                                if ($category_name2) {
                                    if ($category_name2->prestation != 'Frais de Service') { ?>
                                        <tr>
                                            <td class="text-center" style="font-style: italic;font-size: 1em;width:30%; text-align:left"><strong><?php echo  $category_name2->prestation; ?></strong></td>
                                            <td class="text-center" style="text-transform:none !important;width:25%;"></td>
                                            <td class="text-center" style="text-transform:none !important;width:10%;"></td>
                                            <td class="text-center" style="text-transform:none !important;width:35%;"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center" style="text-transform:none !important;width:25%;"></td>
                                            <td class="text-center" style="text-transform:none !important;font-style: italic; font-size:1.2em;width:30%;color:#0D4D99"></td>
                                            <td class="text-center" style="text-transform:none !important;width:10%;"></td>
                                            <td class="text-center" style="text-transform:none !important;width:35%;"></td>
                                        </tr>

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
                                            if ($ref_type != 'textcode') {


                                        ?>

                                                <tr>
                                                    <td class="text-center" style="font-style: italic;font-size:1.0em;width:25%;"><?php if (empty($tab->nom_parametre)) {
                                                                                                                                        echo $category_name2->prestation;
                                                                                                                                    } else {
                                                                                                                                        echo $tab->nom_parametre;
                                                                                                                                    } ?></td>
                                                    <td class="text-center" style="font-style: italic;font-size:1.0em;width:30%;text-align:center"><?php echo $resultat; ?></td>
                                                    <td class="text-center" style="font-style: italic;font-size:1.0em;width:10%;"><?php echo $unite; ?></td>
                                                    <td class="text-center" style="font-style: italic;font-size:1.0em;width:35%;text-align:right"><?php if (empty($valeurs)) {
                                                                                                                                                        if ($ref_high) {
                                                                                                                                                            echo $ref_low . ' - ' . $ref_high;
                                                                                                                                                        }
                                                                                                                                                    } else echo $valeurs; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center" style="text-transform:none !important;width:25%;"></td>
                                                    <td class="text-center" style="text-transform:none !important;font-style: italic; font-size:1.2em;width:30%;color:#0D4D99"></td>
                                                    <td class="text-center" style="text-transform:none !important;width:10%;"></td>
                                                    <td class="text-center" style="text-transform:none !important;width:35%;"></td>
                                                </tr>


                <?php
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                ?>


            </tbody>
        </table>
    
        <hr><br>
                        <div class="col-md-12">
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

                            ?>

                                        <?php  }
                                    foreach ($category_name as $category_name2) {
                                        if ($category_name2) {
                                            $tabbs = $this->finance_model->existResultatsPara($payments->id, intval($category_name2->id));

                                            $name_textcode = $this->finance_model->prestationNameText(intval($category_name2->id));

                                            if (!empty($name_textcode)) {
                                                $name_prestation = $name_textcode->prestation ? $name_textcode->prestation : '';
                                        ?>

                                                <center><strong style="text-transform:none !important;font-style: italic; font-size:1.2em;width:30%;color:#0D4D99;text-align:center"><?php echo $name_prestation ?></strong></center>

                                                <?php  }
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
                                                if ($ref_type == 'textcode') {
                                                ?>
                                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1"><?php if (empty($tab->nom_parametre)) {
                                                                                            echo $category_name2->prestation;
                                                                                        } else {
                                                                                            echo $tab->nom_parametre;
                                                                                        } ?></label>
                                        </div>


                                        <div class="form-group">
                                            <textarea cols="70" rows="3" readonly><?php echo $resultat; ?></textarea>
                                        </div>


                            <?php
                                                }
                                            }
                                        }
                                    }
                                }
                            }


                            ?>



                        </div>

                    </div>

            <p>&nbsp;</p>

            <br>
        </div>
        <div class="col-md-3 invoice_head_left" style="padding-top: 30px;">
            <img class="qr_code" src="<?php echo base_url(); ?>uploads/qrcode/<?php echo $payments->qr_code; ?>" width="130" height="130" alt="alt" />

        </div>
        <div class="col-md-7 invoice_head_right">
            <img class="qr_code" src="<?php echo $signature ?>" style="margin-left:20%" width="220" height="220" alt="alt" />
        </div>
        <br>

        <div class="col-md-9">
            <p style="font-style: italic;font-size:0.8em">Scanner ce QR Code à l'aide de votre Smartphone connecté à internet pour vérifier l'authenticité des informations contenues dans ce document</p>
        </div>

        <br>
        <hr>
        <div class="col-md-12 hr_border">
            <div class="text-center footer_class">
                <img class="foot" src="<?php echo !empty($footer) ? $footer : "uploads/entetePartenaires/defaultFooter.PNG"; ?>" alt="alt" />
            </div>

        </div>


        <style>
            .header_img {
                max-width: 100%;
                height: 18%
            }

            .foot {
                max-width: 100%;
                height: 16;
            }

            .col-md-6 {
                width: 50%;

            }

            .col-md-12 {
                width: 100%;

            }

            .invoice_head_right {
                float: right;

            }

            .invoice_head_left {
                float: left;
            }

            .col-md-9 {
                width: 70%;
            }

            .col-md-12 {
                width: 100%;
            }

            /* .col-md-3 {
        width: 20%;
    } */

    h5 {
        font-weight: bold;
        font-style: italic;
        font-size: 0.8em;
        margin: 0px;
    }
        </style>
</body>

</html>