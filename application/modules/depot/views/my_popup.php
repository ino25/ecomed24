<html>
<head>
    <title>Standalone Paiement par carte: zuuluPay / Orabank</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script  src="<?php echo base_url()?>common/js/jquery.LoadingBox.js"></script>
    <style type="text/css">
        .panel-title {
        display: inline;
        font-weight: bold;
        }
        .display-table {
            display: table;
        }
        .display-tr {
            display: table-row;
        }
        .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 61%;
        }
    </style>
</head>
<?php 

if($this->session->flashdata('response')) { ?>
	<script>
	window.opener.location.reload(true);
	// window.opener.location.href = <?php echo json_encode(base_url()); ?> + 'depot/depotSuccess';
	window.close();
	</script>
<?php } 
	// echo "test";
	$montant = $this->input->get("montant");
	$amountBuff = explode(" ", $montant);
	$amount = str_replace(".", "", $amountBuff[0]);
?>	
	<form role="form" action="<?php echo base_url(); ?>depot/callOrab" method="post" class="require-validation" id="payment-form">
		<input class='form-control money' size='6' name="montant" id="montant" type='hidden' value='<?php echo $amount; ?>' />
    </form>
<?php					
	// print_r($this->input);
?>

	<?php //if($this->session->flashdata('requestParameter') && $this->session->flashdata('requestUrl')){ ?>
		<form action="<?php echo $this->session->flashdata('requestUrl'); ?>" method="post" name="network_online_payment" id="network_online_payment">
			<input type="hidden" name="requestParameter" value='<?php echo $this->session->flashdata('requestParameter'); ?>'>
			<input type="submit" value="Submit" style="display:none;">
		</form>
	<?php //} ?>
	
<script type="text/javascript">
<?php if(!$this->session->flashdata('requestParameter') && !$this->session->flashdata('requestUrl') && (!isset($_REQUEST['responseParameter']) || $_REQUEST['responseParameter'] == '')){ ?>
// alert("before submit");
$("#payment-form").submit(); 
<?php } ?>

<?php if($this->session->flashdata('requestParameter') && $this->session->flashdata('requestUrl') && (!isset($_REQUEST['responseParameter']) || $_REQUEST['responseParameter'] == '')){ ?>
	$("#network_online_payment").submit();

	var lb = new $.LoadingBox({

		// if the element doesn't exist, it will create a one new with the predefined html structure and css
		mainElementID: 'loading-box', 

		// animation speed
		fadeInSpeed: 'normal',
		fadeOutSpeed: 'normal',

		// opacity
		opacity: 0.9,

		// background color
		backgroundColor: "#EAEAEA",

		// width / height of the loading GIF
		loadingImageWitdth: "200px",
		loadingImageHeigth: "200px",

		// path to the loading gif
		loadingImageSrc: "<?php echo base_url(); ?>common/js/loading-wheel.gif"
		
	});
	setTimeout(function(){
	  lb.close();
	}, 10000000);
<?php } ?>	
</script>
</html>