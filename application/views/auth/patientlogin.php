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
              <?php  $environment = $this->config->item('environment', 'ion_auth'); ?>
<div class="login-box logini_box_new">
            <form class="form-signin" method="post" action="auth/patientlogin">
				
                  <div class="login-form-head">
						<p> 
                               <br>
                            <a href="/"  class="login form-signin-heading">
                                <img src="uploads/logos/logo_ecomed24.png" alt="" width="180" height="30"> 
                            </a>
                        </p>
                        <!--<p><h2 class="login form-signin-heading" style="text-transform:none;"><?php echo "ecoMed 24"; ?><br/><br/></h2>
                
                            <a href="/">
                               <!--  <img src="uploads/logo_login.png" alt="" width="180" height="60">-->
                            <!--</a>-->
                        <!--</p>
                        <br>-->
                        <!-- <h2>Ouverture de Connexion</h2	> -->
                        <div class="imgcontainer">
                            <!-- <img src="/assets/images/author/img_avatar2.png" alt="Avatar" class="avatar"> -->
                        </div>
                    </div>
                
                
              
                <div class="login-wrap">
                    <input type="text" class="form-control" name="identity"  placeholder="ID PATIENT" autofocus required>
                    <input type="hidden" class="form-control"  name="password" placeholder="Mot de passe" value="12345">




                  <!--  <p><a data-toggle="modal" href="#myModal"> Forgot Password?</a></p>-->
                    <!--     
                          <label class="checkbox">
                              <input type="checkbox" value="remember-me"> Remember me
                              <span class="pull-right">
                                  <a data-toggle="modal" href="#myModal"> Forgot Password?</a>
              
                              </span>
                          </label> 
                    -->
                     <div id="signupForm"> <label class="error"><?php echo $message; ?></label></div>
                     <div class="submit-btn-area">
                    <button class="btn btn-lg btn-login btn-block" type="submit">Connexion <i class="fa fa-arrow-right"></i></button>
                    </div>
                      <!-- <h5  style="text-decoration: none;color:#2c71da !important;"><a href="auth/fPasswordSadm"> <?php echo lang('forgot_password_heading');?>?</a></h5> -->
            
  <style>
                        table, th, td {
                            border: 1px solid #f1f2f7;
                            border-collapse: collapse;
                        }
                        th, td {
                            padding: 2px;
                            text-align: left;
                            font-size:12px;
                        }
                        td,th,h4{
                            color:#aaa;
                            
                        }
                    </style>
                </div>


            </form>
        </div>
        </div>









        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="auth/forgot_password">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Forgot Password ?</h4>
                        </div>

                        <div class="modal-body">
                            <p>Enter your e-mail address below to reset your password.</p>
                            <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                            <input class="btn btn-success" type="submit" name="submit" value="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <!-- js placed at the end of the document so the pages load faster -->
        <script src="<?php echo base_url(); ?>common/js/jquery.js"></script>
        <script src="<?php echo base_url(); ?>common/js/bootstrap.min.js"></script>


    </body>
</html>

<script>
  function updateLogin(login,pwd) {
      $('.form-signin').find('[name="identity"]').val(login).end();
      $('.form-signin').find('[name="password"]').val(pwd).end();
  }
   </script> 
     <style>
                            tr{
                              cursor: pointer;
                            }
                        </style>
