<!--sidebar end-->
<!--main content start-->
<script type="text/javascript" src="<?php echo base_url(); ?>common/js/google-loader.js"></script>
<section id="main-content">
    <section class="wrapper site-min-height">
        <!--state overview start-->

        <div class="modal fade" tabindex="-1" role="dialog" id="cmodal">
            <div class="modal-dialog modal-lg" role="document" style="width: 80%;">
            
                <div class="modal-content">
                    <!--
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo lang('patient') . " " . lang('history'); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    -->
                    <div id='medical_history'>
                        <div class="col-md-12">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo lang('close'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="cmodal_rdv">
            <div class="modal-dialog modal-lg" role="document" style="width: 80%;">
                <div class="modal-content">

                    <div id='medical_history_rdv'>
                        <div class="col-md-12">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo lang('close'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($this->ion_auth->in_group(array('Doctor'))) { ?>
            <div class="state-overview col-md-5" style="padding: 23px 0px;">
                <header class="panel-heading">
                    <i class="fa fa-user"></i> <?php echo lang('todays_appointments'); ?>
                </header>
                <div class="panel-body">
                    <div class="adv-table editable-table ">
                        <div class="space15"></div>
                        <table class="table table-hover progress-table text-center" id="editable-samplee">
                            <thead>
                                <tr>
                                    <th> <?php echo lang('patient_id'); ?></th>
                                    <th> <?php echo lang('name'); ?></th>
                                    <th> <?php echo lang('date-time'); ?></th>
                                    <th> <?php echo lang('status'); ?></th>
                                    <th> <?php echo lang('options'); ?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <style>
                                    .img_url {
                                        height: 20px;
                                        width: 20px;
                                        background-size: contain;
                                        max-height: 20px;
                                        border-radius: 100px;
                                    }
                                </style>

                                <?php
                                foreach ($appointments as $appointment) {
                                    if ($appointment->date == strtotime(date('Y-m-d'))) {
                                ?>
                                        <tr class="">
                                            <td> <?php echo $this->db->get_where('pfatient', array('id' => $appointment->patient))->row()->id; ?></td>
                                            <td> <?php echo $this->db->get_where('patient', array('id' => $appointment->patient))->row()->name; ?></td>

                                            <td class="center"> <strong> <?php echo $appointment->s_time; ?> </strong></td>
                                            <td>
                                                <?php echo $appointment->status; ?>
                                            </td>
                                            <td>

                                                <a class="btn detailsbutton" title="<?php lang('history') ?>" style="color: #fff;" href="patient/medicalHistory?id=<?php echo $appointment->patient ?>"><i class="fa fa-stethoscope"></i> <?php echo lang('history'); ?></a>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        <?php } ?>

        <?php if ($this->ion_auth->in_group(array('admin','adminmedecin'))) { ?>
            <input type="hidden" id="formCustmer" value="<?php echo !empty($id_partenaire_zuuluPay) ? $id_partenaire_zuuluPay : ""; ?>">
            <input type="hidden" id="PIN" value="<?php echo !empty($pin_decrypted) ? $pin_decrypted : ""; ?>">

            <div class="state-overview col-md-12" style="padding: 23px 0px;">
                <div class="clearfix">
                    <div class="col-lg-3 col-sm-6">
                        <?php if ($this->ion_auth->in_group(array('admin','adminmedecin'))) { ?>
                            <a href="patient">
                            <?php } ?>
                            <section class="panel home_sec_blue">
                                <div class="symbol blue">
                                    <i class="fa fa-users-medical"></i>
                                </div>
                                <div class="value">
                                    <h3 class="">
                                        <?php
                                        $this->db->where('id_organisation', $this->id_organisation);
                                        $this->db->from("patient");
                                        echo $this->db->count_all_results();
                                        ?>
                                    </h3>
                                    <p><?php echo lang('patient'); ?></p>
                                </div>
                            </section>
                            <?php if ($this->ion_auth->in_group(array('admin','adminmedecin'))) { ?>
                            </a>
                        <?php } ?>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <?php if ($this->ion_auth->in_group(array('admin','adminmedecin'))) { ?>
                           
                            <?php } ?>
                            <section class="panel home_sec_green">
                                <div class="symbol green">
                                    <i class="fa fa-flask"></i>
                                </div>
                                <div class="value">
                                    <h3 class="">
                                        <?php
                                        $this->db->where('id_organisation', $this->id_organisation);
                                        $this->db->where('bulletinAnalyse', '');
                                        $this->db->or_where('organisation_destinataire', $id_organisation);
                                        $this->db->from("payment");
                                        echo $this->db->count_all_results();
                                        ?>
                                    </h3>
                                    <p><?php echo lang('lab_report'); ?></p>
                                </div>
                            </section>
                            <?php if ($this->ion_auth->in_group(array('admin','adminmedecin'))) { ?>
                            
                        <?php } ?>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <?php if ($this->ion_auth->in_group(array('admin','adminmedecin'))) { ?>
                            <a>
                            <?php } ?>
                            <section class="panel home_sec_blue">
                                <div class="symbol blue">
                                    <i class="fa fa-file"></i>
                                </div>
                                <div class="value">
                                    <h3 class="">
                                        <?php
                                        $this->db->where('id_organisation', $this->id_organisation);
                                        $this->db->where('status', 'pending');
                                        $this->db->from("payment");
                                        echo $this->db->count_all_results();
                                        ?>
                                    </h3>
                                    <p><?php echo lang('acte_encour'); ?></p>
                                </div>
                            </section>
                            <?php if ($this->ion_auth->in_group(array('admin','adminmedecin'))) { ?>
                            </a>
                        <?php } ?>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <?php if ($this->ion_auth->in_group(array('admin','adminmedecin'))) { ?>
                            <a href="patient/patientPayments">

                                <section class="panel home_sec_yellow">
                                    <div class="symbol green">
                                        <i class="fa fa-money-check"></i>
                                    </div>
                                    <div class="value">
                                        <h3 class="">
                                            <?php
                                            $this->db->where('id_organisation', $this->id_organisation);
                                            $this->db->where('status_paid', 'unpaid');
                                            $this->db->where('gross_total !=', 0);
                                            $this->db->from("payment");
                                            echo $this->db->count_all_results();
                                            ?>
                                        </h3>
                                        <p><?php echo lang('facture_impayer'); ?></p>
                                    </div>
                                </section>

                            </a>
                        <?php } ?>
                    </div>



                    <?php if ($this->ion_auth->in_group(array('admin','adminmedecin'))) { ?>
                        <div class="col-lg-5 col-sm-6">

                            <div id="piechart_acte" class="panel" style=""></div>
                        </div>
                        <div class="col-lg-7 col-sm-6">
                            <div class="col-lg-5 col-sm-6">
                                <section class="panel ">
                                    <header class="panel-heading bl"> Etat des comptes </header>
                                    <div class="panel-body">
                                        <div class="home_section">
                                            Compte Principal : <span id="soldeDisponible"></span>
                                            
                                            <hr>
                                        </div>
                                        <div class="home_section">
                                            Compte Encaissement : <span id="soldeEncaissement"></span>
                                            
                                            <hr>
                                        </div>
                   
                                        <!-- <div class="home_section">
                                            Compte Payroll : 0 FCFA
                                            <hr>
                                        </div> -->

                                    </div>
                                </section>
                            </div>

                            <div class="col-lg-5 col-sm-6">
                                <section class="panel">
                                    <header class="panel-heading bl">
                                        <?php
                                        $nom_jour_fr = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
                                        $mois_fr = array(
                                            "", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août",
                                            "Septembre", "Octobre", "Novembre", "Décembre"
                                        );
                                        list($nom_jour, $jour, $mois, $annee) = explode('/', date("w/d/n/Y"));
                                        echo $mois_fr[$mois] . ' ' . $annee;
                                        ?>
                                    </header>
                                    <div class="panel-body">
                                        <div class="home_section">
                                            <?php echo lang('income'); ?> : <?php echo number_format($this_month['payment'], 0, '.', '.'); ?> FCFA
                                            <hr>
                                        </div>
                                        <div class="home_section">
                                            <?php echo lang('expense'); ?> : <?php echo number_format($this_month['expense'], 0, '.', '.'); ?> FCFA
                                            <hr>
                                        </div>
                                        <div class="home_section">
                                            <?php echo lang('appointment'); ?> : <?php echo $this_month['appointment']; ?>
                                            <hr>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($this->ion_auth->in_group(array('admin','adminmedecin'))) { ?>

                        <div class="col-lg-8 col-sm-12">
                            <div id="chart_div" class="panel" style=""></div>

                        </div>

                        <div class="col-lg-4 col-sm-6">

                            <div id="piechart_3d" class="panel" style=""></div>
                        </div>




                    <?php } ?>



                </div>





                <?php if ($this->ion_auth->in_group(array('admin','adminmedecin'))) { ?>


                    <?php if (!$this->ion_auth->in_group('Doctor')) { ?>
                        <div class="col-md-8">

                            <aside class="calendar_ui col-md-12 panel calendar_ui">
                                <section class="">
                                    <div class="">
                                        <div id="calendar" class="has-toolbar calendar_view"></div>
                                    </div>
                                </section>
                            </aside>
                        </div>


                    <?php } else { ?>
                        <div class="state-overview col-md-7 panel row">
                            <table cellspacing="5" cellpadding="5" border="0">
                                <tbody>
                                    <tr>
                                        <td>Recherche par date: </td>
                                        <td>
                                            <input class="form-control form-control-inline input-medium default-date-picker" type="text" id="search_date" name="search_date" value="" placeholder="" autocomplete="off">
                                        </td>
                                    </tr>


                                </tbody>
                            </table>
                            <aside class="calendar_ui">
                                <section class="">
                                    <div class="">
                                        <div id="calendar" class="has-toolbar calendar_view"></div>
                                    </div>
                                </section>
                            </aside>
                        </div>
                    <?php } ?>
                    <div class="col-md-4">
                        <section class="panel">
                            <header class="panel-heading">
                                <?php
                                $nom_jour_fr = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
                                $mois_fr = array(
                                    "", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août",
                                    "septembre", "octobre", "novembre", "décembre"
                                );
                                list($nom_jour, $jour, $mois, $annee) = explode('/', date("w/d/n/Y"));
                                echo $nom_jour_fr[$nom_jour] . ' ' . $jour . ' ' . $mois_fr[$mois] . ' ' . $annee;
                                ?>
                            </header>
                            <div class="panel-body">
                                <div class="home_section">
                                    <?php echo lang('income'); ?> : <?php echo number_format($this_day['payment'], 0, '.', '.'); ?> FCFA
                                    <hr>
                                </div>
                                <div class="home_section">
                                    <?php echo lang('expense'); ?> : <?php echo number_format($this_day['expense'], 0, '.', '.'); ?> FCFA
                                    <hr>
                                </div>
                                <div class="home_section">
                                    <?php echo lang('appointment'); ?> : <?php echo $this_day['appointment']; ?>
                                    <hr>
                                </div>
                            </div>
                        </section>

                        <section class="panel">
                            <header class="panel-heading">
                                <?php
                                $nom_jour_fr = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
                                $mois_fr = array(
                                    "", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août",
                                    "septembre", "octobre", "novembre", "décembre"
                                );
                                list($nom_jour, $jour, $mois, $annee) = explode('/', date("w/d/n/Y"));
                                echo $mois_fr[$mois] . ' ' . $annee;
                                ?>
                            </header>
                            <div class="panel-body">
                                <div class="home_section">
                                    <?php echo lang('income'); ?> : <?php echo number_format($this_month['payment'], 0, '.', '.'); ?> FCFA
                                    <hr>
                                </div>
                                <div class="home_section">
                                    <?php echo lang('expense'); ?> : <?php echo number_format($this_month['expense'], 0, '.', '.'); ?> FCFA
                                    <hr>
                                </div>
                                <div class="home_section">
                                    <?php echo lang('appointment'); ?> : <?php echo $this_month['appointment']; ?>
                                    <hr>
                                </div>
                            </div>
                        </section>


                        <section class="panel">
                            <header class="panel-heading">
                                <?php echo date('Y'); ?>
                            </header>
                            <div class="panel-body">
                                <div class="home_section">
                                    <?php echo lang('income'); ?> : <?php echo number_format($this_year['payment'], 0, '.', '.'); ?> FCFA
                                    <hr>
                                </div>
                                <div class="home_section">
                                    <?php echo lang('expense'); ?> : <?php echo number_format($this_year['expense'], 0, '.', '.'); ?> FCFA
                                    <hr>
                                </div>
                                <div class="home_section">
                                    <?php echo lang('appointment'); ?> : <?php echo $this_year['appointment']; ?>
                                    <hr>
                                </div>
                            </div>
                        </section>
                    </div>

                <?php } ?>



            </div>



        <?php } ?>


        <!-- DASHBOARD POUR LA SECRETAIRE --->

        <?php if ($this->ion_auth->in_group(array('Receptionist','Nurse','Assistant'))) { ?>
            <div class="state-overview col-md-12" style="padding: 23px 0px;">
                <div class="clearfix">
                <div class="col-lg-3 col-sm-6">
                            <section class="panel home_sec_blue">
                            <a href="patient">
                                <div class="symbol blue">
                                    <i class="fa fa-users-medical"></i>
                                </div>
                                <div class="value">
                                    <h3 class="">
                                        <?php
                                        $this->db->where('id_organisation', $this->id_organisation);
                                        $this->db->from("patient");
                                        echo $this->db->count_all_results();
                                        ?>
                                    </h3>
                                    <p><?php echo lang('patient'); ?></p>
                                </div>
                                </a>
                            </section>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <?php if ($this->ion_auth->in_group('Receptionist','Nurse','Assistant')) { ?>
                            
                            <?php } ?>
                            <section class="panel home_sec_blue">
                            <a href="finance/payment?status=pending">
                                <div class="symbol blue">
                                    <i class="fa fa-file"></i>
                                </div>
                                <div class="value">
                                    <h3 class="">
                                        <?php
                                        $this->db->where('id_organisation', $this->id_organisation);
                                        $this->db->where('status', 'pending');
                                        $this->db->from("payment");
                                        echo $this->db->count_all_results();
                                        ?>
                                    </h3>
                                    <p><?php echo lang('acte_encour'); ?></p>
                                </div>
                                </a>
                            </section>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                            <section class="panel home_sec_yellow">
                            <a href="appointment">
                                <div class="symbol green">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <div class="value">
                                    <h3 class="">
                                    <?php
                                        $this->db->where('id_organisation', $this->id_organisation);
                                        $this->db->from("appointment");
                                        echo $this->db->count_all_results();
                                        ?>
                                    </h3>
                                    <p><?php echo lang('appointment'); ?></p>
                                </div>
                                </a>
                            </section>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <aside class="calendar_ui col-md-12 panel calendar_ui">
                    <section class="">
                        <div class="">
                            <div id="calendar" class="has-toolbar calendar_view"></div>
                        </div>
                    </section>
                </aside>
            </div>
            <div class="col-md-4">
                <section class="panel">
                    <header class="panel-heading">
                        <?php
                        $nom_jour_fr = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
                        $mois_fr = array(
                            "", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août",
                            "septembre", "octobre", "novembre", "décembre"
                        );
                        list($nom_jour, $jour, $mois, $annee) = explode('/', date("w/d/n/Y"));
                        echo $nom_jour_fr[$nom_jour] . ' ' . $jour . ' ' . $mois_fr[$mois] . ' ' . $annee;
                        ?>
                    </header>
                    <div class="panel-body">
                        <div class="home_section">
                            <?php echo lang('income'); ?> : <?php echo number_format($this_day['payment'], 0, '.', '.'); ?> FCFA
                            <hr>
                        </div>
                        <div class="home_section">
                            <?php echo lang('expense'); ?> : <?php echo number_format($this_day['expense'], 0, '.', '.'); ?> FCFA
                            <hr>
                        </div>
                        <div class="home_section">
                            <?php echo lang('appointment'); ?> : <?php echo $this_day['appointment']; ?>
                            <hr>
                        </div>
                    </div>
                </section>

                <section class="panel">
                    <header class="panel-heading">
                        <?php
                        $nom_jour_fr = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
                        $mois_fr = array(
                            "", "janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août",
                            "septembre", "octobre", "novembre", "décembre"
                        );
                        list($nom_jour, $jour, $mois, $annee) = explode('/', date("w/d/n/Y"));
                        echo $mois_fr[$mois] . ' ' . $annee;
                        ?>
                    </header>
                    <div class="panel-body">
                        <div class="home_section">
                            <?php echo lang('income'); ?> : <?php echo number_format($this_month['payment'], 0, '.', '.'); ?> FCFA
                            <hr>
                        </div>
                        <div class="home_section">
                            <?php echo lang('expense'); ?> : <?php echo number_format($this_month['expense'], 0, '.', '.'); ?> FCFA
                            <hr>
                        </div>
                        <div class="home_section">
                            <?php echo lang('appointment'); ?> : <?php echo $this_month['appointment']; ?>
                            <hr>
                        </div>
                    </div>
                </section>


                <section class="panel">
                    <header class="panel-heading">
                        <?php echo date('Y'); ?>
                    </header>
                    <div class="panel-body">
                        <div class="home_section">
                            <?php echo lang('income'); ?> : <?php echo number_format($this_year['payment'], 0, '.', '.'); ?> FCFA
                            <hr>
                        </div>
                        <div class="home_section">
                            <?php echo lang('expense'); ?> : <?php echo number_format($this_year['expense'], 0, '.', '.'); ?> FCFA
                            <hr>
                        </div>
                        <div class="home_section">
                            <?php echo lang('appointment'); ?> : <?php echo $this_year['appointment']; ?>
                            <hr>
                        </div>
                    </div>
                </section>
            </div>

        <?php } ?>



        </div>







        <!-- FIN DASHBOARD POUR LA SECRETAIRE -->

        <?php if ($this->ion_auth->in_group(array('Laboratorist'))) { ?>
            <div class="state-overview col-md-12" style="padding: 23px 0px;">
                <div class="clearfix">

                    <div class="col-lg-3 col-sm-6">

                        <a href="">

                            <section class="panel home_sec_green">
                                <div class="symbol green">
                                    <i class="fa fa-flask"></i>
                                </div>
                                <div class="value">
                                    <h3 class="">
                                        <?php
                                        $this->db->where('id_organisation', $this->id_organisation);
                                        $this->db->from("lab");
                                        echo $this->db->count_all_results();
                                        ?>
                                    </h3>
                                    <p><?php echo lang('lab_report'); ?></p>
                                </div>
                            </section>

                        </a>

                    </div>
                    <div class="col-lg-3 col-sm-6">

                        <a href="finance/payment?status=pending">

                            <section class="panel home_sec_blue">
                                <div class="symbol blue">
                                    <i class="fa fa-file"></i>
                                </div>
                                <div class="value">
                                    <h3 class="">
                                        <?php
                                        $this->db->where('id_organisation', $this->id_organisation);
                                        $this->db->where('status', 'pending');
                                        $this->db->from("payment");
                                        echo $this->db->count_all_results();
                                        ?>
                                    </h3>
                                    <p><?php echo lang('acte_encour'); ?></p>
                                </div>
                            </section>

                        </a>

                    </div>
                </div>
            </div>

        <?php } ?>




        <style>
            table {
                box-shadow: none;
            }

            .fc-head {

                box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .16), 0 2px 10px 0 rgba(0, 0, 0, .12);

            }

            .panel-body {
                background: #fff;
            }

            thead {
                background: #fff;
            }

            .panel-body {
                background: #fff;
            }

            .state-overview .panel-heading {
                border-radius: 0px;
                background: #fff !important;
                color: #000;
                padding-left: 10px;
                font-size: 13px !important;
                margin-top: 3px;
                text-align: center;
            }

            .add_patient {
                background: #009988;
            }

            .add_appointment {
                background: #f8d347;
            }

            .add_prescription {
                background: blue;
            }

            .add_lab_report {}

            .y-axis li span {
                display: block;
                margin: -20px 0 0 -25px;
                padding: 0 20px;
                width: 40px;
            }

            .sale_color {
                background: #69D2E7 !important;
                padding: 10px !important;
                font-size: 5px;
                margin-right: 10px;
            }

            .expense_color {
                background: #F38630 !important;
                padding: 10px !important;
                font-size: 5px;
                margin-right: 10px;
            }

            audio,
            canvas,
            progress,
            video {
                display: inline-block;
                vertical-align: baseline;
                width: 100% !important;
                height: 101% !important;
                margin-bottom: 18%;
            }


            .panel-heading {
                margin-top: 0px;
            }
        </style>


        <!--state overview end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
<!--footer end-->
</section>

<!-- js placed at the end of the document so the pages load faster -->




<script src="<?php echo base_url(); ?>common/js/codearistos.min.js"></script>
<script src="<?php echo base_url(); ?>common/js/autoNumeric.min.js"></script>
<script>
    $(document).ready(function() {
        var autoNumericInstance = new AutoNumeric.multiple('.money', {
            // currencySymbol: "Fcfa",
            // currencySymbolPlacement: "s",
            // emptyInputBehavior: "min",
            // selectNumberOnly: true,
            // selectOnFocus: true,
            overrideMinMaxLimits: 'invalid',
            emptyInputBehavior: "min",
            //  maximumValue : '100000',
            //  minimumValue : "100",
            decimalPlaces: 0,
            decimalCharacter: ',',
            digitGroupSeparator: '.'
        });

    });
</script>

<script>
    $(document).ready(function() {
        var formCustmer = $('#formCustmer').val();
    var pin = $('#PIN').val();
    var reponseAll =  solde("fr",formCustmer,pin); 

    });
    
</script>


<script type="text/javascript">
    google.charts.load("current", {
        packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
            "Juilliet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"
        ];

        var d = new Date();
        var selectedMonthName = months[d.getMonth()] + ', ' + d.getFullYear();


        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Recette', <?php
                        if (!empty($this_month['payment'])) {
                            echo $this_month['payment'];
                        } else {
                            echo '0';
                        }
                        ?>],
            ['Dépense', <?php
                        if (!empty($this_month['expense'])) {
                            echo $this_month['expense'];
                        } else {
                            echo '0';
                        }
                        ?>],
        ]);

        var options = {
            title: selectedMonthName,
            is3D: true,
        };
        // var done = JSON.stringify(data,null,4)
        // console.log("les donnees sont "+done);

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);


        var data_acte = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['<?php echo lang('new_'); ?>', <?php
                                            if (!empty($actes['new'])) {
                                                echo $actes['new'];
                                            } else {
                                                echo '0';
                                            }
                                            ?>],
            ['<?php echo lang('pending_'); ?>', <?php
                                                if (!empty($actes['pending'])) {
                                                    echo $actes['pending'];
                                                } else {
                                                    echo '0';
                                                }
                                                ?>],
            ['<?php echo lang('done_'); ?>', <?php
                                                if (!empty($actes['done'])) {
                                                    echo $actes['done'];
                                                } else {
                                                    echo '0';
                                                }
                                                ?>],
            ['<?php echo lang('valid_'); ?>', <?php
                                                if (!empty($actes['valid'])) {
                                                    echo $actes['valid'];
                                                } else {
                                                    echo '0';
                                                }
                                                ?>],
            ['<?php echo lang('finish_'); ?>', <?php
                                                if (!empty($actes['finish'])) {
                                                    echo $actes['finish'];
                                                } else {
                                                    echo '0';
                                                }
                                                ?>],
        ]);

        var options_acte = {
            title: 'Etat des actes',
            is3D: true,
        };
        // var done = JSON.stringify(data,null,4)
        // console.log("les donnees sont "+done);

        var chart = new google.visualization.PieChart(document.getElementById('piechart_acte'));
        chart.draw(data_acte, options_acte);
    }
</script>




<script type="text/javascript">
    google.charts.load("current", {
        packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var months = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        var d = new Date();
        var selectedMonthName = months[d.getMonth()] + ', ' + d.getFullYear();

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Treated', <?php
                        if (!empty($this_month['appointment_treated'])) {
                            echo $this_month['appointment_treated'];
                        } else {
                            echo '0';
                        }
                        ?>],
            ['cancelled', <?php
                            if (!empty($this_month['appointment_cancelled'])) {
                                echo $this_month['appointment_cancelled'];
                            } else {
                                echo '0';
                            }
                            ?>],
        ]);

        var options = {
            title: selectedMonthName + ' Appointment',
            pieHole: 0.4,
        };

        // var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        // chart.draw(data, options);
    }
</script>



<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawVisualization);

    function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
            ['Mois', 'Recettes', 'Dépenses'],
            ['Jan', <?php echo $this_year['payment_per_month']['january']; ?>, <?php echo $this_year['expense_per_month']['january']; ?>],
            ['Fev', <?php echo $this_year['payment_per_month']['february']; ?>, <?php echo $this_year['expense_per_month']['february']; ?>],
            ['Mar', <?php echo $this_year['payment_per_month']['march']; ?>, <?php echo $this_year['expense_per_month']['march']; ?>],
            ['Avr', <?php echo $this_year['payment_per_month']['april']; ?>, <?php echo $this_year['expense_per_month']['april']; ?>],
            ['Mai', <?php echo $this_year['payment_per_month']['may']; ?>, <?php echo $this_year['expense_per_month']['may']; ?>],
            ['Juin', <?php echo $this_year['payment_per_month']['june']; ?>, <?php echo $this_year['expense_per_month']['june']; ?>],
            ['Juil', <?php echo $this_year['payment_per_month']['july']; ?>, <?php echo $this_year['expense_per_month']['july']; ?>],
            ['Août', <?php echo $this_year['payment_per_month']['august']; ?>, <?php echo $this_year['expense_per_month']['august']; ?>],
            ['Sept', <?php echo $this_year['payment_per_month']['september']; ?>, <?php echo $this_year['expense_per_month']['september']; ?>],
            ['Oct', <?php echo $this_year['payment_per_month']['october']; ?>, <?php echo $this_year['expense_per_month']['october']; ?>],
            ['Nov', <?php echo $this_year['payment_per_month']['november']; ?>, <?php echo $this_year['expense_per_month']['november']; ?>],
            ['Dec', <?php echo $this_year['payment_per_month']['december']; ?>, <?php echo $this_year['expense_per_month']['december']; ?>],
        ]);

        var options = {
            title: new Date().getFullYear() + ' <?php echo lang('per_month_income_expense'); ?>',
            vAxis: {
                title: 'FCFA'
            },
            hAxis: {
                title: '<?php echo lang('months'); ?>'
            },
            seriesType: 'bars',
            series: {
                5: {
                    type: 'line'
                }
            }
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }

</script>

