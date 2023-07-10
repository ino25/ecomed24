<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- invoice start-->
        <section class="col-md-8">






            <style>
                .panel {
                    border: 0px solid #5c5c47;
                    background: #fff !important;
                    height: 100%;
                    margin: 20px 5px 5px 5px;
                    border-radius: 0px !important;
                    color: #000;

                }
            </style>








            <div class="panel panel-primary" id="invoice">
                <!--<div class="panel-heading navyblue"> INVOICE</div>-->
                <div class="panel-body" style="font-size: 10px;">
                    <div class="row invoice-list">

                        <!--<div class="text-center corporate-id">


                            <h3>
                                <?php echo $settings->title ?>
                            </h3>
                            <h4>
                                <?php echo $settings->address ?>
                            </h4>
                            <h4>
                                Tel: <?php echo $settings->phone ?>
                            </h4>
                            <img alt="" src="<?php echo $this->settings_model->getSettings()->logo; ?>" width="200" height="100">
                            <h4 style="font-weight: bold; margin-top: 20px; text-transform: uppercase;">
                                <?php echo lang('lab_report') ?>
                                <hr style="width: 200px; border-bottom: 1px solid #000; margin-top: 5px; margin-bottom: 5px;">
                            </h4>
                        </div>-->
                        <div class="col-md-12 invoice_head clearfix">

                            <div class="col-md-4 text-center invoice_head_left">
                                <img src="<?php echo !empty($path_logo) ? $path_logo : "uploads/logosPartenaires/default.png"; ?>" style="max-width:180px;max-height:80px;" />

                            </div>
                            <div class="col-md-8 text-center invoice_head_right">
                                <h6><?php echo !empty($organisation) ? $organisation->description_courte_activite : ""; ?><h6>
                                        <h3 style="margin-top:2px;margin-bottom:2px;">
                                            <?php echo $nom_organisation; ?>
                                        </h3>
                                        <span><?php echo !empty($organisation) ? $organisation->description_courte_services : ""; ?></span>
                                        <h6 style="text-transform:italic;"><?php echo !empty($organisation) ? $organisation->slogan : ""; ?></h6>

                                        <h6><?php echo !empty($organisation) && !empty($organisation->horaires_ouverture) ? "Horaires d'ouverture:" : ""; ?></h6>
                                        <p>
                                            <?php echo !empty($organisation) ? $organisation->horaires_ouverture : ""; ?>
                                        </p>
                            </div>
                        </div>
                        <div class="col-md-12 hr_border">
                            <hr>
                        </div>
                        <div class="col-md-12 clearfix" style="margin-top:2px;">
                            <h2 class="text-center">CONSULTATION GENERALE </h2>
                            <!-- <div class="col-md-12">
                                <p class="pull-left">
                                    <?php echo !empty($organisation) ? $organisation->prenom_responsable_legal2 . " " . $organisation->nom_responsable_legal2 : ""; ?><br />
                                    <?php echo !empty($organisation) ? $organisation->fonction_responsable_legal2 : ""; ?><br />
                                    <?php echo !empty($organisation) ? $organisation->description_courte_responsable_legal2 : ""; ?>
                                </p>
                                <p class="text-right pull-right">
                                    <?php echo !empty($organisation) ? $organisation->prenom_responsable_legal . " " . $organisation->nom_responsable_legal : ""; ?><br />
                                    <?php echo !empty($organisation) ? $organisation->fonction_responsable_legal : ""; ?><br />
                                    <?php echo !empty($organisation) ? $organisation->description_courte_responsable_legal : ""; ?>
                                </p>
                            </div> -->

                        </div>
                        <div class="col-md-12 hr_border">
                            <hr>
                        </div>



                        <div class="col-md-12">
                            <div class="col-md-4">
                                <h5>Code Patient : </h5>
                                <h6><?php echo $visite->patient_code; ?></h6>
                            </div>
                            <div class="col-md-4">
                                <h5>Patient : </h5>
                                <h6><?php echo $visite->patient_name . ' ' . $visite->patient_last_name; ?></h6>
                            </div>
                            <div class="col-md-4">
                                <h5>Téléphone :</h5>
                                <h6><?php echo $visite->patient_phone; ?></h6>
                            </div>
                        </div>
                    </div>
                    <h5 class="text-center" style="font-weight: bold;text-transform: uppercase;padding-top:15px">
                        Résumé Médical
                    </h5>
                </div>
                <p style="padding-top: 10px;"></p>
                <div class="col-md-12">
                    <h5><?php echo $visite->description; ?></h5>
                </div>
                <div class="col-md-12 hr_border">   
                </div>
                <div class="col-md-12">
                    <br>
                    <div class="col-md-3">
                        <h5>Pignet</h5>
                    </div>
                    <div class="col-md-9">
                        <h5>Taille : <?php if (empty($visite->oeil_droit)) {
                                                echo 'Non renseigné';
                                            } else echo $visite->taille . '(cm)'; ?> | Poids : <?php if (empty($visite->poids)) {
                                                                                            echo 'Non renseigné';
                                                                                        } else echo $visite->poids . 'kg'; ?> | 	Périmètre Thoracique : <?php if (empty($visite->perimetre_thoracique)) {
                                                                                            echo 'Non renseigné';
                                                                                        } else echo $visite->perimetre_thoracique . 'cm'; ?></h5>
                    </div>
                </div>
                <div class="col-md-12" style="padding-top:25px"></div>
                <div class="col-md-12">
                    <div class="col-md-3">
                        <h5>Tension Artérielle</h5>
                    </div>
                    <div class="col-md-9">
                        <h5></strong> T. Systolique (mmHg) : <?php echo $visite->systolique; ?> mmHg | T. Diastolique (mmHg) : <?php echo $visite->diastolique; ?> mmHg </h5>
                    </div>
                </div>
                <div class="col-md-12">
                    <br>
                    <div class="col-md-3">
                        <h5>Urines</h5>
                    </div>
                    <div class="col-md-9">
                        <h5>Sucre : <?php if (empty($visite->sucre)) {
                                        echo 'Non renseigné';
                                    } else echo $visite->sucre; ?> | Albumine : <?php if (empty($visite->albumine)) {
                                                                            echo 'Non renseigné';
                                                                        } else echo $visite->albumine; ?></h5>
                    </div>
                </div>

                <div class="col-md-12">
                    <br>
                    <div class="col-md-3">
                        <h5>Acuite Visuelle</h5>
                    </div>
                    <div class="col-md-9">
                        <h5>Oeil droite : <?php if (empty($visite->oeil_droit)) {
                                                echo 'Non renseigné';
                                            } else echo $visite->oeil_droit . '/10'; ?> | Oeil gauche : <?php if (empty($visite->oeil_gauche)) {
                                                                                            echo 'Non renseigné';
                                                                                        } else echo $visite->oeil_gauche . '/10'; ?></h5>
                    </div>
                </div>
                <div class="col-md-12">
                    <br>
                    <div class="col-md-3">
                        <h5>Acuite Auditive</h5>
                    </div>
                    <div class="col-md-9">
                        <h5>Oreille droite : <?php if (empty($visite->oreille_droite)) {
                                                    echo 'Non renseigné';
                                                } else echo $visite->oreille_droite . '/10'; ?> | Oreille gauche : <?php if (empty($visite->oreille_gauche)) {
                                                                                                    echo 'Non renseigné';
                                                                                                } else echo $visite->oreille_gauche . '/10'; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="padding-top:25px">

            </div>
            <div class="col-md-12">
                <div class="col-md-12 invoice_footer">
                    <div class="row pull-left" style="">
                        <strong><?php echo lang('effectuer_par'); ?> : </strong>
                    </div><br>
                    <div class="row pull-left" style="">
                        <?php echo $this->ion_auth->user()->row()->username . ' ' . $this->ion_auth->user()->row()->last_name; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="text-center">
                    20<?php echo date('y'); ?> &copy; Powered by ecoMed24.
                </div>
            </div>
            <br>

            </div>



            </div>
            </div>



        </section>


        <section class="col-md-4">

            <div class="col-md-5 no-print" style="margin-top: 20px;">
                <div class="text-center col-md-12 row">
                    <a class="btn btn-info btn-sm invoice_button pull-left" onclick="javascript:window.print();"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
                    <a class="btn btn-info btn-sm detailsbutton pull-left download" id="download"><i class="fa fa-download"></i> <?php echo lang('download'); ?> </a>
                    <a href="visite/ajout">
                        <div class="btn-group pull-left">
                            <button id="" class="btn green btn-sm">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('ajouter_visite_generale'); ?>
                            </button>
                        </div>
                    </a>
                    <a href="visite/liste" class="btn btn-info btn-sm info pull-left"><i class="fa fa-arrow-circle-left"></i> <?php echo lang('submit_retour'); ?> </a>
                </div>
            </div>
        </section>
        <!-- invoice end-->
    </section>
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
        min-height: 700px;

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
        background: #fff !important;
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
        border-bottom: 0px solid #f1f1f1 !important;
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

    .invoice_head_left h3 {
        color: #2f80bf !important;
        font-family: cursive;
    }


    .invoice_head_right {
        margin-top: 10px;
    }

    .invoice_footer {
        margin-bottom: 10px;
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
        }

        .panel {
            border: 0px solid #5c5c47;
            background: #fff !important;
            padding: 0px 0px;
            height: 100%;
            margin: 5px 5px 5px 5px;
            border-radius: 0px !important;

        }

        .site-min-height {
            min-height: 950px;
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
            background: #777 !important;
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
            border-bottom: 0px solid #f1f1f1 !important;
        }

        .corporate-id {
            margin-bottom: 5px;
        }

        .adv-table table tr td {
            padding: 5px 10px;
        }

        .invoice_head {
            width: 100%;
        }

        .invoice_head_left {
            float: left;
            width: 40%;
            color: #2f80bf;
            font-family: cursive;
        }

        .invoice_head_right {
            float: right;
            width: 40%;
            margin-top: 10px;
        }

        .hr_border {
            width: 100%;
        }

        .invoice_footer {
            margin-bottom: 10px;
        }


    }
</style>

<!--main content end-->
<!--footer start-->

<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/autoNumeric.min.js"></script>

<script>
    $(document).ready(function() {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
</script>


<script>
    var autoNumericInstance = new AutoNumeric.multiple('.money', {
        currencySymbol: " FCFA",
        currencySymbolPlacement: "s",
        emptyInputBehavior: "min",
        // maximumValue : "100000",
        // minimumValue : "1000",
        decimalPlaces: 0,
        decimalCharacter: ',',
        digitGroupSeparator: '.'
    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>

<script>
    $('#download').click(function() {
        var pdf = new jsPDF('p', 'pt', 'letter');
        pdf.addHTML($('#invoice'), function() {
            pdf.save('invoice_id_<?php echo $expense->codeFacture; ?>.pdf');
        });
    });

    // This code is collected but useful, click below to jsfiddle link.
</script>