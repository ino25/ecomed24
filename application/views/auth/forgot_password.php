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

<!--
<h1><?php echo lang('forgot_password_heading');?></h1>
<p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/forgot_password");?>

      <p>
      	<label for="identity"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label> <br />
      	<?php echo form_input($identity);?>
      </p>

      <p><?php echo form_submit('submit', lang('forgot_password_submit_btn'));?></p>

<?php echo form_close();?>
          </div>-->
<form class="form-signin" method="post" action="auth/forgot_password" style="max-width: 430px !important;">	
                <div class="login-form-head">
                         <p> 
                
                            <a href="/"  class="login form-signin-heading">
                                <img src="uploads/logos/logo_ecomed24.png" alt="" width="180" height="30"> 
                            </a>
                        </p> 
    
                        <div class="imgcontainer">
             
                        </div>
                    </div>

                
                <div class="login-wrap">
                    <div class="input-group_ p-0 shadow-sm text-center"><h4><?php echo lang('forgot_password_heading_title');?></h4>
                    <div class="input-group-append"><span class="input-group-text px-4"></span></div>
                    <div><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></div>
                    <p></p> <p></p>
                    </div>
                 
                    <input type="email" class="form-control" name="email" id="email" placeholder="Votre email " autocomplete="off" required="">
                   
                     <div class="submit-btn-area">
                    <button class="btn btn-lg btn-login btn-block" type="submit"><?php echo  lang('forgot_password_submit_btn');?> <i class="fa fa-arrow-right"></i></button>
                    </div>
                      <h5 style="text-decoration: underline;color:#2c71da !important;"><a  href="/"> Se connecter</a></h5>
                      <div id="infoMessage" style="color: red;"><?php echo $message;?></div>
          		
                </div>
</form>	     
            
        </div>
        </div>  
   
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="<?php echo base_url(); ?>common/js/jquery.js"></script>
        <script src="<?php echo base_url(); ?>common/js/bootstrap.min.js"></script>


    </body>
</html>