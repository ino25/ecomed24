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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/facture/css/stylesheet.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/facture/vendor/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/facture/vendor/font-awesome/css/all.min.css" />
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
    <link rel="stylesheet" href="<?php echo base_url(); ?>common/css/jquery-ui.css" />
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

    <!-- Google Fonts -->

    <style>
        @import url('https://fonts.googleapis.com/css?family=Ubuntu&display=swap');
    </style>





    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->


    <?php if ($this->db->get('settings')->row()->language == 'arabic') { ?>
        <style>
            #main-content {
                margin-right: 211px;
                margin-left: 0px;
            }

            body {
                background: #f1f1f1;

            }
        </style>

    <?php } ?>

</head>

<body>
    <section id="container" class=" <?php if (isset($afficheMenu) && !$afficheMenu) {
                                        echo "sidebar-closed";
                                    } ?>">
        <!--header start-->
        <header class="header white-bg" style="border-bottom:1px solde #4E4E4E;box-shadow: 1px 0 1px #4E4E4E;">
            <div class="sidebar-toggle-box" style="">
                <div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-dedent fa-bars tooltips"></div><a href="/" class="">
                    <img src="uploads/logos/logo_ecomed24.png" alt="" width="110" height="18" style="margin-left:5px;">
                </a>
            </div>
            <!--logo start-->
            <?php
            $settings_title = $this->db->get('settings')->row()->title;
            $settings_title = explode(' ', $settings_title);
            ?>
            <div style="">

            </div>
            <!--logo end-->
            <div style="">
                <div class="nav notify-row" id="top_menu" style="margin-left:26px;margin-top:0;">
                    <img src="<?php echo !empty($path_logo) ? $path_logo : "uploads/logosPartenaires/default.png"; ?>" style="max-width:90px;max-height:40px;float:left;" />
                </div>
                <div class="nav notify-row top-menu" style="margin-left:0;">
                    <h4 style="text-align:center;margin-top:0;font-weight:550;letter-spacing:-1px;"><?php echo !empty($nom_organisation) ? $nom_organisation : ""; ?></h4>
                </div>
                <div class="top-nav " style="position:relative;margin-top:10px;margin-right:0px;">
                    <ul class="nav pull-right top-menu2" style="margin-top:3px;">
                        <!-- user login dropdown start-->
                        <li class="dropdown user user-menu hidden-xs">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">

                                <?php
                                $identity = $this->session->userdata["identity"];
                                $idAndImg = $this->db->query("select id, default_img_url from users where email = \"" . $identity . "\"")->row();
                                $group_id = $this->db->query("select group_id from users_groups where user_id = " . $idAndImg->id)->row()->group_id;
                                $group = $this->db->query("select name from `groups` where id=" . $group_id)->row();
                                $group_name = $group->name;
                                $group_name = strtolower($group_name);
                                $avatar = $idAndImg->default_img_url;
                                if ($group_name != "admin") {
                                    $this->db->where("ion_user_id", $idAndImg->id);
                                    $query = $this->db->get($group_name);
                                    $ter = $query->row();
                                    if (isset($ter)) {
                                        $avatar = $ter->img_url;
                                    }
                                } else {
                                    $avatar = $idAndImg->default_img_url;
                                }



                                if (!empty($avatar)) {
                                ?>
                                    <img src="<?php echo $avatar; ?>" width='45px' height='45px' class="user-image img-circle" alt="User Image">
                                <?php } else { ?>
                                    <img src="uploads/imgUsers/24_519.png" width='45px' height='45px' class="user-image img-circle" alt="User Image">
                                <?php } ?>
                                <span class="hidden-xs"><?php echo $this->ion_auth->user()->row()->first_name . ' ' . $this->ion_auth->user()->row()->last_name; ?></span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <?php
                                    if (!empty($avatar)) {
                                    ?>
                                        <img src="<?php echo $avatar; ?>" width='84px' height='84px' class="img-circle" alt="User Image">
                                    <?php } else { ?>
                                        <img src="uploads/imgUsers/24_519.png" width='84px' height='84px' class="img-circle" alt="User Image">
                                    <?php } ?>
                                    <p>
                                        <?php echo $this->ion_auth->user()->row()->first_name . ' ' . $this->ion_auth->user()->row()->last_name; ?> <br>

                                        <!--<small>Aujourd'hui: <?php echo date('d, M Y'); ?></small>-->
                                    </p>

                                </li>
                                <!-- Menu Body -->
                                <!--<li class="user-body">-->
                                <!--<div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Link 1</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Link 2</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Link 3</a>
                  </div>
                </div>-->
                                <!-- /.row -->
                                <!--</li>-->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="profile/editNonProfilUser" class="btn btn-default btn-flat">Mes infos</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="auth/logout" class="btn btn-default btn-flat">Déconnexion</a>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown visible-xs" style="float:left;">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#" style="">
                                <!--<img alt="" src="uploads/user.png">-->
                                <i class="fa fa-user" style="font-size:18px;"></i>
                                <span class="username"><?php echo $this->ion_auth->user()->row()->first_name . ' ' . $this->ion_auth->user()->row()->last_name; ?></span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu ">
                                <div class="log-arrow-up"></div>
                                <?php //if (!$this->ion_auth->in_group('admin')) { 
                                ?>
                                <!--<li><a href=""><i class="fa fa-dashboard"></i> <?php // echo lang('dashboard'); 
                                                                                    ?></a></li>-->
                                <?php //} 
                                ?>
                                <li><a href="profile"><i class=" fa fa-edit"></i>&nbsp;Modifier mes infos</a></li>
                            </ul>
                        </li>
                        <?php if ($this->ion_auth->in_group(array('admin', 'adminmedecin'))) { ?>

                            <li class="dropdown" style="float:left;">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#" style="">
                                    <!--<img alt="" src="uploads/settings.png">-->
                                    <i class="fa fa-cog" style="font-size:18px;"></i>
                                    <span class="username">Paramètres</span>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu ">
                                    <div class="log-arrow-up"></div>
                                    <?php //if (!$this->ion_auth->in_group('admin')) { 
                                    ?>
                                    <!--<li><a href=""><i class="fa fa-dashboard"></i> <?php // echo lang('dashboard'); 
                                                                                        ?></a></li>-->
                                    <?php //} 
                                    ?>
                                    <!--<li><a href="settings"><i class=" fa fa-edit"></i>&nbsp;<?php echo lang('edit') . " " ?>Organisation</a></li>-->
                                    <!--<li><a><i class="fa fa-user"></i> <?php // echo $this->ion_auth->get_users_groups()->row()->name 
                                                                            ?></a></li>-->
                                    <li><a href="department"><i class="fa fa-sitemap"></i> Gérer <?php echo lang("departments"); ?></a></li>
                                    <li><a href="services"><i class="fa fa-sitemap"></i> Gérer <?php echo lang("services"); ?></a></li>
                                    <li><a href="users"><i class="fa fa-edit"></i> Gérer Utilisateurs</a></li>
                                    <li><a href="settings/language"><i class="fa fa-language"></i> Gérer <?php echo lang('language'); ?></a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <li class="dropdown" style="float:left;">
                            <a class="dropdown-toggle" href="auth/logout" style="">
                                <!--<img alt="" src="uploads/settings.png">-->
                                <i class="fa fa-sign-out" style="font-size:18px;"></i>
                                <span class="username">Déconnexion</span>
                                <!--<b class="caret"></b>-->
                            </a>
                        </li>
                        <li class="dropdown" style="float:left;">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#" style="">
                                <!--<img alt="" src="uploads/help-alt.png">-->
                                <i class="fa fa-question" style="font-size:18px;"></i>
                                <span class="username"></span>
                            </a>
                        </li>
                        <!-- user login dropdown end -->
                    </ul>
                    <?php
                    $message = $this->session->flashdata('feedback');
                    if (!empty($message)) {
                    ?>
                        <code class="flashmessage pull-right"> <?php echo $message; ?></code>
                    <?php } ?>
                </div>
            </div>
        </header>
        <!--header end-->
        <!--sidebar start-->

        <!--sidebar start-->
        <aside>
            <div id="sidebar" class="nav-collapse" <?php if (isset($afficheMenu) && !$afficheMenu) { ?> style="height: 1266px; margin-left: -210px;" <?php } ?>>
                <!-- sidebar menu start-->

                <div class="user-panel hidden-xs">
                    <div class="pull-left image">
                        <?php
                        if (!empty($avatar)) {
                        ?>
                            <img src="<?php echo $avatar; ?>" width='45px' height='45px' class="img-circle" alt="User Image">
                        <?php } else { ?>
                            <img src="uploads/imgUsers/24_519.png" width='45px' height='45px' class="img-circle" alt="User Image">
                        <?php } ?>
                    </div>
                    <div class="pull-left info_user">
                        <p><?php echo $this->ion_auth->user()->row()->first_name . ' ' . $this->ion_auth->user()->row()->last_name; ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Connecté</a>
                    </div>
                </div>

                <ul class="sidebar-menu" id="nav-accordion">
                    <li style='position:relative'>
                        <div class="form-group" style='margin-bottom:3px;padding:0px 6px'>
                            <input type="text" placeholder='Trouver un patient...' style='border: 1px solid #223344;padding:3px !important;padding-left:40px !important;border:0;background-position:15px center;background-repeat:no-repeat;background-image: url("uploads/search-15w.png");' class="form-control" id="search_patient">
                        </div>
                        <div id="myInputautocomplete-list" class="autocomplete-items">

                        </div>
                    </li>
                    <li>
                        <a href="home">
                            <i class="fa fa-home"></i>
                            <span>Accueil</span>
                        </a>
                    </li>

                    <?php if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Nurse', 'Receptionist', 'adminmedecin','Assistant'))) { ?>
                        <li><a href="appointment/calendar"><i class="fa fa-calendar-alt"></i><?php echo lang('calendar'); ?></a></li>
                    <?php } ?>

                    <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                        <!--<li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-user-md"></i>
                                    <span><?php // echo lang('doctor'); 
                                            ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a href="doctor"><i class="fa fa-user"></i><?php // echo lang('list_of_doctors'); 
                                                                                    ?></a></li>
                                    <li><a href="appointment/treatmentReport"><i class="fa fa-history"></i><?php // echo lang('treatment_history'); 
                                                                                                            ?></a></li>
                                </ul>
                            </li>-->
                    <?php } ?>
                    <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Nurse', 'Doctor', 'Receptionist','Assistant', 'adminmedecin'))) { ?>

                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-users-medical"></i>
                                <span>Dossier Médicaux</span>
                            </a>
                            <ul class="sub">
                                <li><a href="patient"><i class="fa fa-user"></i><?php echo lang('patient_list'); ?></a></li>

                                <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'adminmedecin'))) { ?>
                                    <li><a href="patient/patientPayments"><i class="fa fa-money-check"></i><?php echo lang('patient_paiement'); ?></a></li>
                                <?php } ?>

                                <?php if (!$this->ion_auth->in_group(array('Accountant', 'Receptionist'))) { ?>
                                    <!-- <li><a href="patient/caseList"><i class="fa fa-book"></i><?php echo lang('case'); ?> <?php echo lang('manager'); ?></a></li>
                                        <li><a href="patient/documents"><i class="fa fa-file"></i><?php echo lang('documents'); ?></a></li> -->
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Nurse', 'Doctor', 'Receptionist','Assistant', 'adminmedecin'))) { ?>

                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-calendar-plus"></i>
                                <span><?php echo lang('programmation_horaire'); ?></span>
                            </a>
                            <ul class="sub">
                                <li><a href="horaire"><i class="fa fa-list-alt"></i><?php echo lang('service'); ?></a></li>
                                <li><a href="horaire/employe"><i class="fa fa-user"></i><?php echo lang('doctor'); ?></a></li>

                            </ul>
                        </li>
                    <?php } ?>


                    <?php if ($this->ion_auth->in_group(array('admin', 'Nurse', 'Receptionist'))) { ?>
                        <!--<li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-clock"></i> 
                                    <span><?php echo lang('schedule'); ?></span>
                                </a>
                                <ul class="sub"> 
                                    <li><a href="schedule"><i class="fa fa-list-alt"></i><?php echo lang('all'); ?> <?php echo lang('schedule'); ?></a></li>
                                    <li><a href="schedule/allHolidays"><i class="fa fa-list-alt"></i><?php echo lang('holidays'); ?></a></li> 
                                </ul>
                            </li>-->
                    <?php } ?>

                    <?php
                    if ($this->ion_auth->in_group(array('Doctor'))) {
                    ?>
                        <!--<li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-clock"></i> 
                                    <span><?php echo lang('schedule'); ?></span>
                                </a>
                                <ul class="sub"> 
                                    <li><a href="schedule/timeSchedule"><i class="fa fa-list-alt"></i><?php echo lang('all'); ?> <?php echo lang('schedule'); ?></a></li>
                                    <li><a href="schedule/holidays"><i class="fa fa-list-alt"></i><?php echo lang('holidays'); ?></a></li> 
                                </ul>
                            </li>-->
                    <?php } ?>


                    <?php if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Nurse', 'Receptionist', 'Assistant', 'adminmedecin'))) { ?>
                        <li><a href="appointment"><i class="fa fa-list-alt"></i><?php echo lang('appointment_menu'); ?></a></li>
                    <?php } ?>
                    <?php if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Nurse', 'Receptionist'))) { ?>
                        <!-- <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-calendar-check"></i> 
                                    <span><?php echo lang('appointment_menu'); ?></span>
                                </a>
                                <ul class="sub"> 
                                
                                    <li><a href="appointment"><i class="fa fa-list-alt"></i><?php echo lang('all_schedule'); ?></a></li>
                                 
                                        <?php if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Receptionist'))) { ?>
                                    <li><a href="appointment/addNewView"><i class="fa fa-plus-circle"></i><?php echo lang('add_schedule'); ?></a></li>
                                     <?php } ?>
                               <li><a href="appointment/todays"><i class="fa fa-list-alt"></i><?php echo lang('todays'); ?></a></li>
                                    <li><a href="appointment/upcoming"><i class="fa fa-list-alt"></i><?php echo lang('upcoming'); ?></a></li>
                                    <!--  <li><a href="appointment/request"><i class="fa fa-list-alt"></i><?php echo lang('request'); ?></a></li>
                                  <?php if ($this->ion_auth->in_group(array('admin', 'Doctor'))) { ?>
                                        <li><a href="meeting"><i class="fa fa-headphones"></i><?php echo lang('live'); ?> <?php echo lang('now'); ?></a></li>
                                    <?php } ?>-->
                        <!--   </ul>
                            </li> -->
                    <?php } ?>


                    <?php if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Receptionist', 'Patient'))) { ?>
                        <!--   <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-headphones"></i> 
                                    <span><?php echo lang('live'); ?> <?php echo lang('meetings'); ?></span>
                                </a>
                                <ul class="sub"> 
                                      <?php if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Receptionist'))) { ?>
                                        <li><a href="meeting/addNewView"><i class="fa fa-plus-circle"></i><?php echo lang('create'); ?> </a></li>
                                    <?php } ?>
                                    <li><a href="meeting"><i class="fa fa-video"></i><?php echo lang('live'); ?> <?php echo lang('now'); ?></a></li>
                                    <li><a href="meeting/upcoming"><i class="fa fa-list-alt"></i><?php echo lang('upcoming'); ?> </a></li>
                                    <li><a href="meeting/previous"><i class="fa fa-list-alt"></i><?php echo lang('previous'); ?> </a></li>
                                     <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                     <li><a href="meeting/settings"><i class="fa fa-headphones"></i><?php echo lang('zoom'); ?> <?php echo lang('settings'); ?></a></li>
                                      <?php } ?> 
                                </ul>
                            </li>-->
                    <?php } ?>








                    <?php if ($this->ion_auth->in_group('admin')) { ?>
                        <!--<li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-users"></i>
                                    <span><?php // echo lang('human_resources'); 
                                            ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a href="nurse"><i class="fa fa-user"></i><?php // echo lang('nurse'); 
                                                                                    ?></a></li>
                                    <li><a href="pharmacist"><i class="fa fa-user"></i><?php // echo lang('pharmacist'); 
                                                                                        ?></a></li>
                                    <li><a href="laboratorist"><i class="fa fa-user"></i><?php // echo lang('laboratorist'); 
                                                                                            ?></a></li>
                                    <li><a href="accountant"><i class="fa fa-user"></i><?php // echo lang('accountant'); 
                                                                                        ?></a></li>
                                    <li><a href="receptionist"><i class="fa fa-user"></i><?php // echo lang('receptionist'); 
                                                                                            ?></a></li>
                                </ul>
                            </li>-->
                    <?php } ?>

                    <?php if ($this->ion_auth->in_group(array('admin', 'Receptionist','Assistant', 'Laboratorist', 'Doctor', 'adminmedecin','Biologiste'))) { ?>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fas fa-file-medical-alt"></i>
                                <span><?php echo lang('payment_management'); ?></span>
                            </a>
                            <ul class="sub">

                                <?php if ($this->ion_auth->in_group(array('admin', 'Receptionist','Assistant'))) { ?>
                                    <li><a href="finance/payment"><i class="fas fa-file-medical-alt"></i> <?php echo lang('liste_actes_menu2'); ?></a></li>

                                <?php } ?>
                                <?php if ($this->ion_auth->in_group(array('Doctor', 'Laboratorist', 'adminmedecin','Biologiste'))) { ?>

                                    <li><a href="finance/paymentLabo"><i class="fa fa-money-check"></i><?php echo lang('liste_actes_menu2'); ?></a></li>
                                <?php } ?>
                                <?php if ($this->ion_auth->in_group(array('Receptionist', 'Doctor', 'adminmedecin','Assistant','Biologiste'))) { ?>

                                    <li><a href="finance/addPaymentView"><i class="fa fa-plus-circle"></i><?php echo lang('add_acte'); ?></a></li>
                                <?php } ?>

                            </ul>
                        </li>
                    <?php } ?>

                    <?php if ($this->ion_auth->in_group(array('admin', 'adminmedecin'))) { ?>

                        <li><a href="finance/paymentCategory"><i class="fa fa-medkit"></i><?php echo lang('payment_procedures_menu'); ?></a></li>
                        <li><a href="finance/insurance"><i class="fa fa-shield-alt"></i><?php echo "Tiers-Payants" ?></a></li>
                        <!--<li class="sub-menu"><a href="partenaire"><i class="fa fa-exchange"></i><?php echo lang('gest_partenaire_menu'); ?></a>-->

                        </li>
                    <?php } ?>
                    <?php if ($this->ion_auth->in_group(array('Receptionist', 'admin', 'adminmedecin', 'Accountant','Assistant'))) { ?>
                        <li class="sub-menu"><a href="#"><i class="fa fa-list"></i><?php echo lang('gest_partenaire_menu_facturartion'); ?></a>
                            <ul class="sub">
                                <li><a href="partenaire/listeFacturePrestation"><i class="fa fa-list"></i><?php echo lang('facturer_partenaire'); ?></a></li>
                                <li><a href="partenaire/factures"><i class="fa fa-list"></i><?php echo lang('menu_factures'); ?></a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if ($this->ion_auth->in_group(array('Receptionist', 'admin', 'adminmedecin', 'Assistant'))) { ?>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-money-check"></i>
                                <span><?php echo lang('expense_management_menu'); ?></span>
                            </a>
                            <ul class="sub">
                                <li><a href="finance/menuService"><i class="fa fa-money-check"></i><?php echo lang('service_zuulu'); ?></a></li>
                                <li><a href="finance/expense"><i class="fa fa-money-check"></i><?php echo lang('expense_menu'); ?></a></li>
                                <li><a href="finance/addExpenseView"><i class="fa fa-plus-circle"></i><?php echo lang('add_expense_menu'); ?></a></li>
                                <li><a href="finance/expenseCategory"><i class="fa fa-edit"></i><?php echo lang('expense_categories'); ?> </a></li>


                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-money-check"></i>
                                <span style="font-size:97%;"><?php echo lang('depot_transfert_menu'); ?></span>
                            </a>
                            <ul class="sub">
                                <li><a href="depot/ajoutdepot"><i class="fa fa-plus-circle"></i><span style="font-size:97%;"><?php echo lang('depot_menu'); ?></span></a></li>
                                <!-- <li><a  href="depot/ajouttransfert"><i class="fa fa-plus-circle"></i><?php echo lang('add_transfert'); ?></a></li> -->
                                <li><a href="depot/operationFinanciere"><i class="fa fa-edit"></i><?php echo lang('liste_depot_transfert_menu'); ?> </a></li>

                            </ul>
                        </li>
                    <?php } ?>

                    <?php if ($this->ion_auth->in_group(array('Receptionist'))) { ?>
                        <!--  <li>
                                <a href="appointment/calendar" >
                                    <i class="fa fa-calendar"></i>
                                    <span> <?php echo lang('calendar'); ?> </span>
                                </a>
                            </li> -->
                        <!-- <li><a href="finance/paymentCategory"><i class="fa fa-medkit"></i><?php echo lang('payment_procedures_menu'); ?></a></li> -->
                        <li><a href="finance/insurance"><i class="fa fa-shield-alt"></i><?php echo "Gestion Tiers-Payants" ?></a></li>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-money-check"></i>
                                <span><?php echo lang('expense_management_menu'); ?></span>
                            </a>
                            <ul class="sub">
                                <li><a href="finance/menuService"><i class="fa fa-money-check"></i><?php echo lang('service_zuulu'); ?></a></li>
                                <li><a href="finance/expense"><i class="fa fa-money-check"></i><?php echo lang('expense_menu'); ?></a></li>
                                <li><a href="finance/addExpenseView"><i class="fa fa-plus-circle"></i><?php echo lang('add_expense_menu'); ?></a></li>
                                <li><a href="finance/expenseCategory"><i class="fa fa-edit"></i><?php echo lang('expense_categories'); ?> </a></li>


                            </ul>
                        </li>
                    <?php } ?>




                        <!-- <?php if ($this->ion_auth->in_group(array('Doctor','adminmedecin'))) { ?>
                            <li>
                                <a href="prescription/all" >
                                    <i class="fas fa-prescription"></i>
                                    <span> <?php echo lang('prescription'); ?> </span>
                                </a>
                            </li>
                        <?php } ?> -->


                    <?php

                    ?>

                    <?php
                    if ($this->ion_auth->in_group(array('Accountant'))) {
                    ?>
                        <!-- <li>
                                <a href="finance/UserActivityReport">
                                    <i class="fa fa-file-user"></i>
                                    <span><?php echo lang('user_activity_report'); ?></span>
                                </a>
                            </li>-->
                    <?php
                    }
                    ?>


                    <?php if ($this->ion_auth->in_group(array('admin', 'Laboratorist'))) { ?>
                        <!--    <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-flask"></i>
                                    <span><?php echo lang('labs_menu'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="lab"><i class="fa fa-file-medical"></i><?php echo lang('lab_reports_analyse'); ?></a></li>
                                    <li><a  href="lab/addLabView"><i class="fa fa-plus-circle"></i><?php echo lang('libelle_report_2'); ?></a></li>
                                   
                                </ul>
                            </li>-->
                    <?php } ?>

                    <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                        <!--<li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-medkit"></i>
                                    <span><?php echo lang('medicine'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="medicine"><i class="fa fa-medkit"></i><?php echo lang('medicine_list'); ?></a></li>
                                    <li><a  href="medicine/addMedicineView"><i class="fa fa-plus-circle"></i><?php echo lang('add_medicine'); ?></a></li>
                                    <li><a  href="medicine/medicineCategory"><i class="fa fa-edit"></i><?php echo lang('medicine_category'); ?></a></li>
                                    <li><a  href="medicine/addCategoryView"><i class="fa fa-plus-circle"></i><?php echo lang('add_medicine_category'); ?></a></li>
                                    <li><a  href="medicine/medicineStockAlert"><i class="fa fa-plus-circle"></i><?php echo lang('medicine_stock_alert'); ?></a></li>

                                </ul>
                            </li>-->
                    <?php } ?>








                    <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist'))) { ?>
                        <!--<li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fas fa-capsules"></i>
                                    <span><?php echo lang('pharmacy'); ?></span>
                                </a>
                                <ul class="sub">
                                    <?php if (!$this->ion_auth->in_group(array('Pharmacist'))) { ?>
                                        <li><a  href="finance/pharmacy/home"><i class="fa fa-home"></i> <?php echo lang('dashboard'); ?></a></li>
                                    <?php } ?>
                                    <li><a  href="finance/pharmacy/payment"><i class="fa fa-money-check"></i> <?php echo lang('sales'); ?></a></li>
                                    <li><a  href="finance/pharmacy/addPaymentView"><i class="fa fa-plus-circle"></i><?php echo lang('add_new_sale'); ?></a></li>
                                    <li><a  href="finance/pharmacy/expense"><i class="fa fa-money-check"></i><?php echo lang('expense'); ?></a></li>
                                    <li><a  href="finance/pharmacy/addExpenseView"><i class="fa fa-plus-circle"></i><?php echo lang('add_expense'); ?></a></li>
                                    <li><a  href="finance/pharmacy/expenseCategory"><i class="fa fa-edit"></i><?php echo lang('expense_categories'); ?> </a></li>


                                    <?php if ($this->ion_auth->in_group(array('admin', 'Pharmacist'))) { ?>
                                        <li class="sub-menu">
                                            <a href="javascript:;" >
                                                <i class="fas fa-file-medical-alt"></i>
                                                <span><?php echo lang(''); ?> <?php echo lang('report'); ?></span>
                                            </a>
                                            <ul class="sub">
                                                <li><a  href="finance/pharmacy/financialReport"><i class="fa fa-book"></i><?php echo lang('pharmacy'); ?> <?php echo lang('report'); ?> </a></li>
                                                <li><a  href="finance/pharmacy/monthly"><i class="fa fa-chart-bar"></i> <?php echo lang('monthly_sales'); ?> </a></li>
                                                <li><a  href="finance/pharmacy/daily"><i class="fa fa-chart-bar"></i> <?php echo lang('daily_sales'); ?> </a></li>
                                                <li><a  href="finance/pharmacy/monthlyExpense"><i class="fa fa-chart-area"></i> <?php echo lang('monthly_expense'); ?> </a></li>
                                                <li><a  href="finance/pharmacy/dailyExpense"><i class="fa fa-chart-area"></i> <?php echo lang('daily_expense'); ?> </a></li>                              
                                            </ul>
                                        </li> 
                                    <?php } ?>



                                </ul>
                            </li>-->
                    <?php } ?>










                    <?php if ($this->ion_auth->in_group(array('admin', 'Laboratorist'))) { ?>
                        <!--<li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa  fa-hand-holding-water"></i>
                                    <span><?php echo lang('donor') ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="donor"><i class="fa fa-user"></i><?php echo lang('donor_list'); ?></a></li>
                                    <li><a  href="donor/addDonorView"><i class="fa fa-plus-circle"></i><?php echo lang('add_donor'); ?></a></li>
                                    <li><a  href="donor/bloodBank"><i class="fa fa-tint"></i><?php echo lang('blood_bank'); ?></a></li>
                                </ul>
                            </li>-->
                    <?php } ?>
                    <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                        <!--<li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fas fa-procedures"></i>
                                    <span><?php echo lang('bed'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="bed"><i class="fas fa-procedures"></i><?php echo lang('bed_list'); ?></a></li>
                                    <li><a  href="bed/addBedView"><i class="fa fa-plus-circle"></i><?php echo lang('add_bed'); ?></a></li>
                                    <li><a  href="bed/bedCategory"><i class="fa fa-edit"></i><?php echo lang('bed_category'); ?></a></li>
                                    <li><a  href="bed/bedAllotment"><i class="fas fa-bed"></i><?php echo lang('bed_allotments'); ?></a></li>
                                    <li><a  href="bed/addAllotmentView"><i class="fa fa-plus-circle"></i><?php echo lang('add_allotment'); ?></a></li>
                                </ul>
                            </li>-->
                    <?php } ?>

                    <!-- <?php if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Doctor'))) { ?>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-medkit"></i>
                                <span><?php echo lang('consultation'); ?></span>
                            </a>
                            <ul class="sub">
                                <?php if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Doctor'))) { ?>

                                    <li><a href="visite/ajoutConsultation"><i class="fa fa-plus-circle"></i> <?php echo lang('new_consultation'); ?> </a></li>

                                    <li><a href="visite/listeConsultation"><i class="fa fa-edit"></i> <?php echo lang('liste_consultation'); ?> </a></li>


                                <?php } ?>

                            </ul>
                        </li>

                    <?php } ?> -->

                    <!-- <?php if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Doctor'))) { ?>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-medkit"></i>
                                    <span><?php echo lang('visite_general'); ?></span>
                                </a>
                                <ul class="sub">
                                    <?php if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Doctor'))) { ?>
                                    
                                        <li><a  href="visite/ajout"><i class="fa fa-plus-circle"></i> <?php echo lang('nouvelle_visite_general'); ?> </a></li>
                                        
                                         <li><a  href="visite/liste"><i class="fa fa-edit"></i> <?php echo lang('liste_visite_general'); ?> </a></li>


                                    <?php } ?>

                                </ul>
                            </li>
                        <?php } ?>  -->

                    <?php if ($this->ion_auth->in_group(array('admin', 'adminmedecin'))) { ?>
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-chart-bar"></i>
                                <span><?php echo lang('report') . "s"; ?></span>
                            </a>
                            <ul class="sub">
                                <?php if ($this->ion_auth->in_group(array('admin', 'adminmedecin'))) { ?>
                                    <li><a href="finance/financialReport"><i class="fa fa-book"></i><?php echo lang('financial_report'); ?></a></li>
                                    <!--  <li> <a href="finance/AllUserActivityReport">  <i class="fa fa-home"></i>   <span><?php echo lang('user_activity_report'); ?></span> </a></li>-->
                                <?php } ?>

                                <?php if ($this->ion_auth->in_group(array('admin', 'adminmedecin'))) { ?>
                                    <!-- <li><a  href="finance/doctorsCommission"><i class="fa fa-edit"></i><?php echo lang('doctors_commission'); ?> </a></li> -->
                                    <li><a href="finance/monthly"><i class="fa fa-chart-bar"></i> <?php echo lang('monthly_sales'); ?> </a></li>
                                    <li><a href="finance/daily"><i class="fa fa-chart-bar"></i> <?php echo lang('daily_sales'); ?> </a></li>
                                    <li><a href="finance/monthlyExpense"><i class="fa fa-chart-area"></i> <?php echo lang('monthly_expense'); ?> </a></li>
                                    <li><a href="finance/dailyExpense"><i class="fa fa-chart-area"></i> <?php echo lang('daily_expense'); ?> </a></li>



                                <?php } ?>

                                <!--<li><a  href="report/birth"><i class="fas fa-file-medical"></i><?php echo lang('birth_report'); ?></a></li>
                                    <li><a  href="report/operation"><i class="fa fa-wheelchair"></i><?php echo lang('operation_report'); ?></a></li>
                                    <li><a  href="report/expire"><i class="fas fa-file-medical"></i><?php echo lang('expire_report'); ?></a></li>-->

                            </ul>
                        </li>
                    <?php } ?>




                    <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                        <!--<li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-bells"></i>
                                    <span><?php echo lang('notice'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="notice"><i class="fa fa-bells"></i><?php echo lang('notice'); ?></a></li>
                                    <li><a  href="notice/addNewView"><i class="fa fa-list-alt"></i><?php echo lang('add_new'); ?></a></li>
                                </ul>
                            </li> -->
                    <?php } ?>


                    <?php if ($this->ion_auth->in_group(array('admin'))) { ?>

                        <!--<li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fas fa-globe"></i>
                                    <span><?php echo lang('website'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a href="frontend" target="_blank" ><i class="fa fa-globe"></i><?php echo lang('visit_site'); ?></a></li>
                                    <li><a href="frontend/settings"><i class="fa fa-cog"></i><?php echo lang('website_settings'); ?></a></li>
                                    <li><a href="slide"><i class="fa fa-wrench"></i><?php echo lang('slides'); ?></a></li>
                                    <li><a href="service"><i class="fab fa-servicestack"></i><?php echo lang('services'); ?></a></li>
                                    <li><a href="featured"><i class="fa fa-address-card"></i><?php echo lang('featured_doctors'); ?></a></li>
                                </ul>
                            </li>

                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-cogs"></i>
                                    <span><?php echo lang('settings'); ?></span>
                                </a>
                                <ul class="sub"> 
                                    <li><a href="settings"><i class="fa fa-cog"></i><?php echo lang('system_settings'); ?></a></li>

                                    <li><a href="pgateway"><i class="fa fa-credit-card"></i><?php echo lang('payment_gateway'); ?></a></li>
                                    <li><a href="settings/language"><i class="fa fa-language"></i><?php echo lang('language'); ?></a></li>
                                    <?php if ($this->ion_auth->in_group(array('admin'))) { ?>

                                        <li><a href="import"><i class="fa fa-arrow-right"></i><?php echo lang('bulk'); ?> <?php echo lang('import'); ?></a></li>
                                    <?php } ?>
                                    <li><a href="settings/backups"><i class="fa fa-database"></i><?php echo lang('backup_database'); ?></a></li>
                                </ul>
                            </li>-->





                    <?php } ?>










                    <?php if ($this->ion_auth->in_group('Accountant')) { ?>

                        <!-- <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-money-bill-alt"></i>
                                    <span><?php echo lang('payments'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li>
                                        <a href="finance/payment" >
                                            <i class="fa fa-money-check"></i>
                                            <span> <?php echo lang('payments'); ?> </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="finance/addPaymentView" >
                                            <i class="fa fa-plus-circle"></i>
                                            <span> <?php echo lang('add_payment'); ?> </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="finance/paymentCategory" >
                                            <i class="fa fa-edit"></i>
                                            <span> <?php echo lang('payment_procedures'); ?> </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>-->
                        <li><a href="finance/menuService"><i class="fa fa-money-check"></i><?php echo lang('service_zuulu'); ?></a></li>
                        <li>
                            <a href="finance/expense">
                                <i class="fa fa-money-check"></i>
                                <span> <?php echo lang('expense_menu'); ?> </span>
                            </a>
                        </li>
                        <li>
                            <a href="finance/addExpenseView">
                                <i class="fa fa-plus-circle"></i>
                                <span> <?php echo lang('add_expense_menu'); ?> </span>
                            </a>
                        </li>
                        <li>
                            <a href="finance/expenseCategory">
                                <i class="fa fa-edit"></i>
                                <span> <?php echo lang('expense_categories'); ?> </span>
                            </a>
                        </li>
                        <!--  <li>
                                <a href="finance/doctorsCommission" >
                                    <i class="fa fa-edit"></i>
                                    <span> <?php echo lang('doctors_commission'); ?> </span>
                                </a>
                            </li>-->
                        <li class="sub-menu">
                            <a href="javascript:;">
                                <i class="fa fa-chart-bar"></i>
                                <span><?php echo lang('report') . "s"; ?></span>
                            </a>
                            <ul class="sub">
                                    <li><a href="finance/financialReport"><i class="fa fa-book"></i><?php echo lang('financial_report'); ?></a></li>
                                    <!--  <li> <a href="finance/AllUserActivityReport">  <i class="fa fa-home"></i>   <span><?php echo lang('user_activity_report'); ?></span> </a></li>-->
                            

                                    <!-- <li><a  href="finance/doctorsCommission"><i class="fa fa-edit"></i><?php echo lang('doctors_commission'); ?> </a></li> -->
                                    <li><a href="finance/monthly"><i class="fa fa-chart-bar"></i> <?php echo lang('monthly_sales'); ?> </a></li>
                                    <li><a href="finance/daily"><i class="fa fa-chart-bar"></i> <?php echo lang('daily_sales'); ?> </a></li>
                                    <li><a href="finance/monthlyExpense"><i class="fa fa-chart-area"></i> <?php echo lang('monthly_expense'); ?> </a></li>
                                    <li><a href="finance/dailyExpense"><i class="fa fa-chart-area"></i> <?php echo lang('daily_expense'); ?> </a></li>

                                <!--<li><a  href="report/birth"><i class="fas fa-file-medical"></i><?php echo lang('birth_report'); ?></a></li>
                                    <li><a  href="report/operation"><i class="fa fa-wheelchair"></i><?php echo lang('operation_report'); ?></a></li>
                                    <li><a  href="report/expire"><i class="fas fa-file-medical"></i><?php echo lang('expire_report'); ?></a></li>-->

                            </ul>
                        </li>
                        <!-- <li>
                            <a href="finance/financialReport">
                                <i class="fa fa-book"></i>
                                <span> <?php echo lang('financial_report'); ?> </span><span id="test">test</span>
                            </a>
                        </li> -->
                    <?php } ?>

                    <?php if ($this->ion_auth->in_group('Pharmacist')) { ?>
                        <li>
                            <a href="medicine">
                                <i class="fa fa-medkit"></i>
                                <span> <?php echo lang('medicine_list'); ?> </span>
                            </a>
                        </li>
                        <li>
                            <a href="medicine/addMedicineView">
                                <i class="fa fa-plus-circle"></i>
                                <span> <?php echo lang('add_medicine'); ?> </span>
                            </a>
                        </li>
                        <li>
                            <a href="medicine/medicineCategory">
                                <i class="fa fa-medkit"></i>
                                <span> <?php echo lang('medicine_category'); ?> </span>
                            </a>
                        </li>
                        <li>
                            <a href="medicine/addCategoryView">
                                <i class="fa fa-plus-circle"></i>
                                <span> <?php echo lang('add_medicine_category'); ?> </span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($this->ion_auth->in_group('Nurse')) { ?>
                        <!-- <li>
                                <a href="bed" >
                                    <i class="fa fa-procedures"></i>
                                    <span> <?php echo lang('bed_list'); ?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="bed/bedCategory" >
                                    <i class="fa fa-edit"></i>
                                    <span> <?php echo lang('bed_category'); ?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="bed/bedAllotment" >
                                    <i class="fa fa-plus-circle"></i>
                                    <span> <?php echo lang('bed_allotments'); ?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="donor" >
                                    <i class="fa fa-medkit"></i>
                                    <span> <?php echo lang('donor'); ?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="donor/bloodBank" >
                                    <i class="fa fa-tint"></i>
                                    <span> <?php echo lang('blood_bank'); ?> </span>
                                </a>
                            </li>-->
                    <?php } ?>

                    <?php if ($this->ion_auth->in_group('Patient')) { ?>

                        <!--    <li>
                                <a href="lab/myLab" >
                                    <i class="fa fa-file-medical-alt"></i>
                                    <span> <?php echo lang('diagnosis'); ?> <?php echo lang('reports'); ?> </span>
                                </a>
                            </li>

                            <li>
                                <a href="patient/calendar" >
                                    <i class="fa fa-calendar"></i>
                                    <span> <?php echo lang('appointment'); ?> <?php echo lang('calendar'); ?> </span>
                                </a>
                            </li>

                            <li>
                                <a href="patient/myCaseList" >
                                    <i class="fa fa-file-medical"></i>
                                    <span>  <?php echo lang('cases'); ?> </span>
                                </a>
                            </li>
                            <li>
                                <a href="patient/myPrescription" >
                                    <i class="fa fa-medkit"></i>
                                    <span> <?php echo lang('prescription'); ?>  </span>
                                </a>
                            </li>

                            <li>
                                <a href="patient/myDocuments" >
                                    <i class="fa fa-file-upload"></i>
                                    <span> <?php echo lang('documents'); ?> </span>
                                </a>
                            </li>

                            <li>
                                <a href="patient/myPaymentHistory" >
                                    <i class="fa fa-money-bill-alt"></i>
                                    <span> <?php echo lang('payment'); ?> </span>      
                                </a>
                            </li>

                            <li>
                                <a href="report/myreports" >
                                    <i class="fa fa-file-medical-alt"></i>
                                    <span> <?php echo lang('other'); ?> <?php echo lang('reports'); ?> </span>
                                </a>
                            </li>

                            <li>
                                <a href="donor" >
                                    <i class="fa fa-user"></i>
                                    <span><?php echo lang('donor'); ?></span>
                                </a>
                            </li>-->

                    <?php } ?>

                    <?php if ($this->ion_auth->in_group('im')) { ?>
                        <li>
                            <a href="patient/addNewView">
                                <i class="fa fa-user"></i>
                                <span> <?php echo lang('add_patient'); ?> </span>
                            </a>
                        </li>
                        <li>
                            <a href="finance/addPaymentView">
                                <i class="fa fa-user"></i>
                                <span> <?php echo lang('add_payment'); ?> </span>
                            </a>
                        </li>
                    <?php } ?>








                    <!--<li>
                            <a href="profile" >
                                <i class="fa fa-user"></i>
                                <span> <?php echo lang('profile'); ?> </span>
                            </a>
                        </li>-->

                    <!--multi level menu start-->

                    <!--multi level menu end-->


                    <!--  <li>
                                <a href="zuuluservice">
                                    <i class="fa fa-sitemap"></i>
                                    <span><?php echo lang('service_zuulu'); ?></span>
                                </a>
                            </li>

                       -->

                </ul>

                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->

        </script>