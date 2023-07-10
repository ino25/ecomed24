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
        <link rel="stylesheet" href="<?php echo base_url(); ?>common/assets/bootstrap-datepicker/css/datepicker.css" />
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
            <header class="header white-bg" style="border-bottom:1px solde #4E4E4E;box-shadow: 1px 0 1px #4E4E4E;">
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
				<div style="">
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
                </div>
                <!--logo end-->
				
				<div style="">
					
					<div class="top-nav " style="position:relative;margin-top:10px;margin-right:0px;">

						<ul class="nav pull-right top-menu">
							<!-- user login dropdown start-->
							<li class="dropdown">
								<a data-toggle="dropdown" class="dropdown-toggle" href="#">
									<img alt="" src="uploads/favicon.png" width="21" height="23">
									<!--<span class="username"><?php //echo $this->ion_auth->user()->row()->username; ?></span>-->
									<span class="username">Super Admin</span>
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
				</div>
            </header>
            <!--header end-->
            <!--sidebar start-->

            <!--sidebar start-->
            <aside>
                <div id="sidebar"  class="nav-collapse">
                    <!-- sidebar menu start-->
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a href="home/superhome"> 
                                <i class="fa fa-hospital"></i>
                                <span>Gestion <?php echo lang('organisations'); ?></span>
                            </a>
                        </li>
                          <!--<li><a  href="home/paymentCategoryAdmin"><i class="fa fa-medkit"></i><?php echo lang('payment_procedures_menu'); ?></a></li>--> 
							
                          <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-sitemap"></i>
                                    <span>Gestion Données</span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="home/superservices"><i class="fa fa-hospitals"></i><?php echo lang('services'); ?> & Spécialités</a></li>
                                    <li><a  href="home/superprestations"><i class="fa fa-medkit"></i><?php echo lang('payment_procedures'); ?></a></li>
                                    <!--<li><a  href="email/sendView"><i class="fa fa-location-arrow"></i><?php //echo lang('new'); ?></a></li>
                                    <li><a  href="email/sent"><i class="fa fa-list-alt"></i><?php //echo lang('sent'); ?></a></li>
                                   
                                    <li><a  href="email/settings"><i class="fa fa-cogs"></i><?php //echo lang('settings'); ?></a></li>-->
                               
                                </ul>
                            </li> 
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-sitemap"></i>
                                    <span>Tiers-payant</span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="home/tiersPayant"><i class="fa fa-hospitals"></i>Gestion Tiers-payant</a></li>
                               
                                </ul>
                            </li> 
							
							<li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-mail-bulk"></i>
                                    <span>Gestion <?php echo lang('email'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="email/autoEmailTemplate"><i class="fa fa-robot"></i><?php echo lang('autoemailtemplate'); ?></a></li>
                                    <!--<li><a  href="email/sendView"><i class="fa fa-location-arrow"></i><?php //echo lang('new'); ?></a></li>
                                    <li><a  href="email/sent"><i class="fa fa-list-alt"></i><?php //echo lang('sent'); ?></a></li>
                                   
                                    <li><a  href="email/settings"><i class="fa fa-cogs"></i><?php //echo lang('settings'); ?></a></li>-->
                               
                                </ul>
                            </li> 
                      
                         <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-sms"></i>
                                    <span>Gestion <?php echo lang('sms'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="sms/autoSMSTemplate"><i class="fa fa-robot"></i><?php echo lang('autosmstemplate'); ?></a></li>
                                    <!--<li><a  href="sms/sendView"><i class="fa fa-location-arrow"></i><?php //echo lang('write_message'); ?></a></li>
                                    <li><a  href="sms/sent"><i class="fa fa-list-alt"></i><?php //echo lang('sent_messages'); ?></a></li>
                                  
                                        <li><a  href="sms"><i class="fa fa-cogs"></i><?php //echo lang('sms_settings'); ?></a></li>-->
                                
                                </ul>
                        </li>
                        <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fab fa-whatsapp"></i>
                                    <span>Gestion <?php echo lang('whatsapp'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="whatsapp/autoWhatsappTemplate"><i class="fa fa-robot"></i><?php echo lang('whatsapp_template'); ?></a></li>
                                   
                                </ul>
                        </li>
                        <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-medkit"></i>
                                    <span> <?php echo lang('medicine'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="medicine/masterMedicineList"><i class="fa fa-medkit"></i><?php echo lang('master_medicine_list'); ?></a></li>
                                    <li><a  href="medicine/addMedicineVieww"><i class="fa fa-plus-circle"></i><?php echo lang('add_medicine'); ?></a></li>
                                    <li><a  href="medicine/medicineCategoryList"><i class="fa fa-edit"></i><?php echo lang('medicine_category'); ?></a></li>
                                    <li><a  href="medicine/medicineTypeList"><i class="fa fa-edit"></i><?php echo lang('medicine_type'); ?></a></li>
                                    <li><a  href="medicine/requestMedicineList"><i class="fa fa-medkit"></i><?php echo lang('request_medicine'); ?></a></li>
<!--                                    <li><a  href="sms/sent"><i class="fa fa-list-alt"></i><?php //echo lang('sent_messages'); ?></a></li>
                                  
                                        <li><a  href="sms"><i class="fa fa-cogs"></i><?php //echo lang('sms_settings'); ?></a></li>-->
                                
                                </ul>
                        </li>
                        <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-medkit"></i>
                                    <span> <?php echo lang('lab_tests'); ?></span>
                                </a>
                                <ul class="sub">
                                    <li><a  href="lab/masterLabList"><i class="fa fa-medkit"></i><?php echo lang('master_lab_test'); ?></a></li>
                                    <li><a  href="lab/addLabTestMasterView"><i class="fa fa-plus-circle"></i><?php echo lang('add_lab_test'); ?></a></li>
                                  
                                    <li><a  href="lab/requestLabTestList"><i class="fa fa-medkit"></i><?php echo lang('request_lab_test'); ?></a></li>
<!--                                    <li><a  href="sms/sent"><i class="fa fa-list-alt"></i><?php //echo lang('sent_messages'); ?></a></li>
                                  
                                        <li><a  href="sms"><i class="fa fa-cogs"></i><?php //echo lang('sms_settings'); ?></a></li>-->
                                
                                </ul>
                        </li>
                        <li>
                            <a href="home/template"> 
                                <i class="fa fa-file-medical"></i>
                                <span>Modèle Laboratoire</span>
                            </a>
                        </li>
                        <li>
                            <a href="home/settings"> 
                               <i class="fa fa-cog"></i>
                                <span><?php echo lang('whatsapp_settings'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="home/templateConsultation"> 
                                <i class="fa fa-file-medical"></i>
                                <span>Modèle Consultation</span>
                            </a>
                        </li>
                        <li>
                            <a href="home/templateMaladie"> 
                                <i class="fa fa-file-medical"></i>
                                <span>Les maladies </span>
                            </a>
                        </li>
                        
                      
                    </ul>

                    <!-- sidebar menu end-->
                </div>
            </aside>
            <!--sidebar end-->




