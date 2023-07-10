<!DOCTYPE html>
<html lang="en" <?php if ($this->db->get('settings')->row()->language == 'arabic') { ?> dir="rtl" <?php } ?>>
    <head>
        <base href="<?php echo base_url(); ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Rizvi">
        <meta name="keyword" content="Php, Hospital, Clinic, Management, Software, Php, CodeIgniter, Hms, Accounting">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>uploads/faviconZ.png">
        <title><?php echo $this->router->fetch_class(); ?> | <?php echo $this->db->get('settings')->row()->system_vendor; ?> </title>
        <!-- Bootstrap core CSS -->
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
        <!--<link rel="stylesheet" href="common/assets/bootstrap-datepicker/css/datepicker.css" />-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/bootstrap-daterangepicker/daterangepicker-bs3.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/bootstrap-datetimepicker/css/datetimepicker.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/bootstrap-timepicker/compiled/timepicker.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/jquery-multi-select/css/multi-select.css" />
        <link href="<?php echo base_url(); ?>common/css/invoice-print.css" rel="stylesheet" media="print">
        <link href="<?php echo base_url(); ?>common/assets/fullcalendar/fullcalendar.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/select2/css/select2.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/css/lightbox.css"/>
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
        <section id="container" class="">
            <!--header start-->
            <header class="header white-bg">
                <div class="sidebar-toggle-box" style="">
                    <div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-dedent fa-bars tooltips"></div><a href="/"  class="" >
                                <img src="uploads/logos/logo_ecomed24.png" alt="" width="110" height="18" style="margin-left:5px;">
                            </a>
                </div>
                <!--logo start-->
                <?php
                $settings_title = $this->db->get('settings')->row()->title;
                $settings_title = explode(' ', $settings_title);
                ?>
                <!--<a href="" class="logo">
                    <strong>
                        <?php echo $settings_title[0]; ?>
                        <span>
                            <?php
                            if (!empty($settings_title[1])) {
                                echo $settings_title[1];
                            }
                            ?>
                        </span>
                    </strong>
                </a>-->
                <!--logo end-->
				
                <div class="top-nav ">

                    <ul class="nav pull-right top-menu">
                        <!-- user login dropdown start-->
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <img alt="" src="uploads/favicon.png" width="21" height="23">
                                <!--<span class="username"><?php //echo $this->ion_auth->user()->row()->username; ?></span>-->
                                <span class="username"><?php echo $patient->name . ' ' . $patient->last_name; ?></span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu extended logout">
								<div class="log-arrow-up"></div>
                           
                                <li><a href="auth/logout"><i class="fa fa-key"></i> <?php echo lang('log_out'); ?></a></li>
                            </ul>
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
            </header>
            <!--header end-->
            <!--sidebar start-->

            <!--sidebar start-->
            <!-- <aside>
                <div id="sidebar"  class="nav-collapse"> -->
                    <!-- sidebar menu start-->
                    <!-- <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a href="home/appointmentcenterhome"> 
                                <i class="fa fa-hospitals"></i>
                                <span><?php echo lang('organisations'); ?></span>
                            </a>
                        </li>
                        <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-calendar-check"></i> 
                                    <span><?php echo lang('appointment_menu'); ?></span>
                                </a>
                                <ul class="sub"> 
                                
                                    <li><a href="#">Bientôt disponible</a></li> -->
                                   <!-- <li><a href="appointment"><i class="fa fa-list-alt"></i><?php echo lang('all_schedule'); ?></a></li>
                                 
                                        <?php if ($this->ion_auth->in_group(array('admin','adminmedecin', 'Doctor', 'Receptionist'))) { ?>
                                    <li><a href="appointment/addNewView"><i class="fa fa-plus-circle"></i><?php echo lang('add_schedule'); ?></a></li>
                                     <?php } ?>
                               <li><a href="appointment/todays"><i class="fa fa-list-alt"></i><?php echo lang('todays'); ?></a></li>
                                    <li><a href="appointment/upcoming"><i class="fa fa-list-alt"></i><?php echo lang('upcoming'); ?></a></li>
                                    <li><a href="appointment/calendar"><i class="fa fa-list-alt"></i><?php echo lang('calendar'); ?></a></li>-->
                                <!-- </ul>
                            </li>
                      
                    </ul> -->

                    <!-- sidebar menu end-->
                <!-- </div>
            </aside> -->
            <!--sidebar end-->




