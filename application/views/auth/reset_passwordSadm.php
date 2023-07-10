<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?php echo base_url(); ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Rizvi">
        <meta name="keyword" content="Php, Hospital, Clinic, Management, Software, Php, CodeIgniter, Hms, Accounting">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>uploads/faviconZ.png">

        <title>Login - <?php echo $this->db->get('settings')->row()->system_vendor; ?></title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url(); ?>common/css/bootstrap.min.css?<?php echo time(); ?>" rel="stylesheet">
        <link href="<?php echo base_url(); ?>common/css/bootstrap-reset.css?<?php echo time(); ?>" rel="stylesheet">
        <!--external css-->
        <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet" />
        <!-- Custom styles for this template -->
        <link href="<?php echo base_url(); ?>common/css/style.css?<?php echo time(); ?>" rel="stylesheet">
        <link href="<?php echo base_url(); ?>common/css/style-responsive.css" rel="stylesheet" />

        <link href="<?php echo base_url(); ?>common/assets/fontawesome5pro/css/all.min.css" rel="stylesheet" />

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="login-body">

        <div class="container">

            <style>


                form{

                    padding: 0px;
                    border: none;


                }


            </style>

            <div class="login-box logini_box_new">

<!--<h1><?php echo lang('reset_password_heading'); ?></h1>-->
                <!--
                <?php echo form_open('auth/reset_password/' . $code); ?>
                   <div class="login-form-head">
                                        <p> </p><h2 class="login form-signin-heading" style="text-transform:none;">ecoMed 24<br><br></h2>
                                
                                            <a href="/">
                                            </a>
                                        <p></p>
                                        <br>
                    
                                        <div class="imgcontainer">
                             
                                        </div>
                                    </div>
                
                                <div id="infoMessage"><?php echo $message; ?></div>
                                <div class="login-wrap">
                                    <div class="input-group p-0 shadow-sm">
                                    <div class="input-group-append"><span class="input-group-text px-4"></span></div>
                                     
                                    </div>
                                    <h5><?php echo lang('reset_password_new_password_label'); ?></h5>
                        <p>
                                <label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length); ?></label> <br />
                <?php echo form_input($new_password); ?>
                        </p>
                
                        <p>
                <?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm'); ?> <br />
                <?php echo form_input($new_password_confirm); ?>
                        </p>
                
                <?php echo form_input($user_id); ?>
                <?php echo form_hidden($csrf); ?>
                
                        <p><?php echo form_submit('submit', lang('reset_password_submit_btn')); ?></p>
                </div>
                <?php echo form_close(); ?>
                -->


                <form class="form-signin" method="post" action="auth/reset_passwordSadm/<?php echo $code; ?>"  style="max-width: 430px !important;">	
                    <div class="login-form-head">
                        <p> </p><h2 class="login form-signin-heading" style="text-transform:none;">ecoMed 24<br><br></h2>

                        <a href="/">
                        </a>
                        <p></p>
                        <br>

                        <div class="imgcontainer">

                        </div>
                    </div>

                    <div id="infoMessage"><?php echo $message; ?></div>
                    <div class="login-wrap">
                        <div class="input-group p-0 shadow-sm">
                            <div class="input-group-append"><span class="input-group-text px-4"></span></div>

                        </div>
                        <h5><?php echo lang('reset_password_new_password_label'); ?></h5>
                        <input type="password" class="form-control" name="new" value="" id="new" pattern="<?php echo $pattern; ?>" autocomplete="off" >
                        <?php echo lang('reset_password_new_password_confirm_label'); ?> <br />
                        <input type="password" class="form-control" name="new_confirm" value="" id="new_confirm" pattern="<?php echo $pattern; ?>" autocomplete="off" >
                        <small>Utilisez au moins huit caractères avec des lettres, des chiffres et des symboles</small>
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" id="user_id">
                        <?php echo form_hidden($csrf); ?>
                        
                        <div class="submit-btn-area">
                            <button class="btn btn-lg btn-login btn-block" type="submit"><?php echo lang('reset_password_submit_btn'); ?> <i class="fa fa-arrow-right"></i></button>
                        </div>
                        <h5 style="text-decoration: underline;color:#2c71da !important;"><a href="/"> Se connecter</a></h5>


                    </div>
                </form>	


            </div>
        </div>


        <!-- js placed at the end of the document so the pages load faster -->
        <script src="<?php echo base_url(); ?>common/js/jquery.js"></script>
        <script src="<?php echo base_url(); ?>common/js/bootstrap.min.js"></script>


    </body>
</html>