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
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/assets/select2/css/select2.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>common/css/lightbox.css"/>
		
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
            <form class="form-signin" method="post" action="auth/otp_auth">
				
                <div class="login-form-head">
                        <p> 
                               <br>
                            <a href="/"  class="login form-signin-heading">
                                <img src="uploads/logos/logo_ecomed24.png" alt="" width="180" height="30"> 
                            </a>
                        </p>
                     
                        <!-- <h2>Ouverture de Connexion</h2	> -->
                        <div class="imgcontainer">
                            <!-- <img src="/assets/images/author/img_avatar2.png" alt="Avatar" class="avatar"> -->
                        </div>
                    </div>
				<?php
				// $message = $this->session->flashdata('message');
				?>
                <div id="infoMessage" style="text-align:center;"><?php echo $message; ?></div>
                <div class="login-wrap" id="login-wrap">
                    <div class="input-group p-0 shadow-sm">
                    <div class="input-group-append"><span class="input-group-text px-4"><!--<i class="fa fa-user"></i>--></span></div>
                     
                    </div>
                   <input type="text" class="form-control" name="otp" placeholder="Code de vérification" pattern="[0-9]{6}" required>
                  <!--  <input type="password" class="form-control"  name="password" placeholder="Mot de passe">-->




                   <!--     
                          <label class="checkbox">
                              <input type="checkbox" value="remember-me"> Remember me
                              <span class="pull-right">
                                  <a data-toggle="modal" href="#myModal"> Forgot Password?</a>
              
                              </span>
                          </label> 
                    -->
                    
                     <div class="submit-btn-area">
					 <input type="hidden" name="phone" id="phone" value="<?php echo $phone; ?>">
					 <input type="hidden" name="email" id="email" value="<?php echo $email; ?>">
					 <input type="hidden" name="password" id="password" value="<?php echo $password; ?>">
					 <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                    <button class="btn btn-login btn-secondary pull-left" style="width:50%;" id="resend_otp">Renvoyer le code</button>
                    <button class="btn btn-login pull-right" type="submit" style="width:40%;">Valider <i class="fa fa-arrow-right"></i></button>
					<?php // echo $phone." ".$email." ".$password." ".$id; ?>
                    </div>
					
                </div>


            </form>
        </div>
        </div>


        <!-- js placed at the end of the document so the pages load faster -->
        <script src="<?php echo base_url(); ?>common/js/jquery.js"></script>
        <script src="<?php echo base_url(); ?>common/js/bootstrap.min.js"></script>


    </body>
</html>

<script>
  // function updateLogin(login,pwd) {
      // $('.form-signin').find('[name="identity"]').val(login).end();
      // $('.form-signin').find('[name="password"]').val(pwd).end();
  // }
 $(document).ready(function() {
	$("#resend_otp").click(function(e) {
		e.preventDefault();
		var phone = $("#phone").val();
		var email = $("#email").val();
		// var password = $("#password").val();
		var id = $("#id").val();
		
		$.ajax({
			url: 'auth/resend_otp?phone=' + phone + "&email=" + email + "&id=" + id,
			method: 'GET',
			data: '',
			dataType: 'json',
		}).success(function(response) {
			// var img_tag = JSON.stringify(response.patient.img_url) !== "null" ? "<img class='avatar' src='" + response.patient.img_url + "' alt='' style='max-width: 200px; max-height: 150px;margin-bottom:10px;'>" : "<img class='avatar' src='uploads/imgUsers/contact-512.png' alt='' style='max-width: 200px; max-height: 150px;margin-bottom:10px;'>";
			$("#infoMessage").html(response.message);
		});
	});
 });
   </script> 
     <style>
                            tr{
                              cursor: pointer;
                            }
                        </style>
