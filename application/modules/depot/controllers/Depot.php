<?php
require_once APPPATH."libraries/NetworkonlineBitmapPaymentIntegration.php";

// use GuzzleHttp\ClientInterface;
// use GuzzleHttp\Exception\BadResponseException;
// use GuzzleHttp\Psr7\Request;
// use Guzzle\Http\Client;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Depot extends MX_Controller {

    function __construct() {
		// echo "<script language=\"javascript\">alert('".$this->session->userdata["identity"]."');</script>";
		// echo "<script language=\"javascript\">alert('".base_url().'depot/successOrab'."');</script>";
        parent::__construct();
        $this->load->model('depot_model');
        $this->load->model('home/home_model');
        require APPPATH . 'third_party/stripe/stripe-php/init.php';
        if (!$this->ion_auth->in_group(array('admin','adminmedecin', 'Accountant', 'Receptionist','Assistant', 'Nurse', 'Laboratorist', 'Doctor','adminmedecin'))) {
            redirect('home/permission');
        }

        $identity = $this->session->userdata["identity"];
        $this->id_organisation = $this->home_model->get_id_organisation($identity);
        $this->path_logo = $this->home_model->get_logo_organisation($this->id_organisation);
        $this->nom_organisation = $this->home_model->get_nom_organisation($this->id_organisation);
        $this->id_partenaire_zuuluPay = $this->home_model->id_partenaire_zuuluPay($this->id_organisation);
        $this->pin_partenaire_zuuluPay_encrypted = $this->home_model->pin_partenaire_zuuluPay_encrypted($this->id_organisation);
        $this->code_organisation = $this->home_model->get_code_organisation($this->id_organisation);
		
		// ORABANK
		$this->merchantKey = "";
		$this->merchantId = "";
		$this->collaboratorId = "";
		$this->iv = "";
    }
	
	public function index() {
        //$data['visites'] = $this->visite_model->getVisite($this->id_organisation);    
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('depot_new', $data);
        $this->load->view('home/footer', $data); // just the header file
    }
	
	public function ajoutdepot() {
        //$data['visites'] = $this->visite_model->getVisite($this->id_organisation);    
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('depot_new', $data);
        $this->load->view('home/footer', $data); // just the header file
    }

    public function ajouttransfert() {
        //$data['visites'] = $this->visite_model->getVisite($this->id_organisation);    
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('transfert_new', $data);
        $this->load->view('home/footer', $data); // just the header file
    }

    public function confirmationOrangeMoney() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $amount = $this->input->get('amount');
        $statut = $this->input->get('statut');
        $phone = $this->input->get('phone');
        $destinataire = $this->input->get('destinataire');
		$description = $this->input->get('description');
		$idtransaction = $this->input->get('idtransaction');
        $type = $this->input->get('type');
        $reference = $this->input->get('reference');
        $count_depot = $this->db->get_where('operation_financiere', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
        // $code= 'OM-' . $this->code_organisation . '-' . str_pad($count_depot, 4, "0", STR_PAD_LEFT);
        $code= 'OM' . $this->code_organisation . '' . $count_depot;

        $date = time();
        $data = array(
            'amount' => $amount,
            'id_organisation' => $this->id_organisation,
            'initiateur' => $phone,
            'user' => $user = $this->ion_auth->get_user_id(),
            'date' => $date,
            'type' => $type,
            'destinataire' => $destinataire,
            'statut' => $statut,
			'description' => $description,
			'id_transaction_externe' => $idtransaction,
            'date_string' => date('d/m/y H:i', $date),
            'code' => $code,
            'reference' => $reference,
        );
        $this->depot_model->insertOperation($data);
       
        echo json_encode($data);
        
    }


    public function confirmationInterne() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $amount = $this->input->get('amount');
        $statut = $this->input->get('statut');
        $initiateur = $this->input->get('initiateur');
        $destinataire = $this->input->get('destinataire');
        $description = $this->input->get('description');
        $numeroTransaction = $this->input->get('numeroTransaction');
        $type = $this->input->get('type');
        $count_depot = $this->db->get_where('operation_financiere', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
        // $code= 'TI-' . $this->code_organisation . '-' . str_pad($count_depot, 4, "0", STR_PAD_LEFT);
        $code= 'TI' . $this->code_organisation . '' . $count_depot;

        $date = time();
        $data = array(
            'amount' => $amount,
            'id_organisation' => $this->id_organisation,
            'initiateur' => $initiateur,
            'user' => $user = $this->ion_auth->get_user_id(),
            'date' => $date,
            'type' => $type,
            'id_zuulupay' => $numeroTransaction,
            'destinataire' => $destinataire,
            'statut' => $statut,
            'description' => $description,
            'date_string' => date('d/m/y H:i', $date),
            'code' => $code,
        );
        $this->depot_model->insertOperation($data);
        echo json_encode($data);
    }

    function operationFinanciere() {
        
        $data = array();
        $date_debut = $this->input->get('debut');
        $date_fin = $this->input->get('fin');
        $typeoperation = $this->input->get('type');

        if (!empty($typeoperation)) {
            $date_debut = $date_debut . ' 00:00';
            $date_debut = strtotime(str_replace('/', '-', $date_debut));
            $date_fin = $date_fin . ' 23:59';
            $date_fin = strtotime(str_replace('/', '-', $date_fin));
            $data['operationFinanciere'] = $this->depot_model->getOperationByFilterType($this->id_organisation, $date_debut, $date_fin, $typeoperation);
        } else if ($date_debut) {
            $date_debut = $date_debut . ' 00:00';
            $date_debut = strtotime(str_replace('/', '-', $date_debut));
            $date_fin = $date_fin . ' 23:59';
            $date_fin = strtotime(str_replace('/', '-', $date_fin));
            $data['operationFinanciere'] = $this->depot_model->getOperationOrganisationByFilter($this->id_organisation, $date_debut, $date_fin);
        } else {
            $data['operationFinanciere'] = $this->depot_model->getOperationOrganisationById($this->id_organisation);
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('operation_financiere', $data);
        $this->load->view('home/footer'); // just the footer fi
    }
	
	function view_popup()
	{
		
		// echo "<script language=\"javascript\">alert('in view popup');</script>";
		$this->load->view('my_popup');
	}
	
	public function callOrab()
    {
		
		$this->load->library('form_validation');
		
		$amountBuff = explode(" ", $this->input->post('montant'));
		$amount = str_replace(".", "", $amountBuff[0]);
		// $amount = str_replace(".", "", $this->input->post('montant'));
		// $amount = $this->input->post('montant');
		
		$networkOnlineArray = array('Network_Online_setting' => array(
											
											'merchantKey'    => $this->merchantKey, 	  	   	    	// The Network Online Test
											'merchantId'     => $this->merchantId, 																

											
											'collaboratorId' => $this->collaboratorId,
											'iv' 			 => $this->iv, // Used for initializing CBC encryption mode
											'url'	         => false              // Set to false if you are using testing environment , set to true if you are using live environment
								),
								'Block_Existence_Indicator' => array(
											'transactionDataBlock' => true,
											'billingDataBlock' 	   => true,
											'shippingDataBlock'    => true,
											'paymentDataBlock'     => false,
											'merchantDataBlock'    => false,
											'otherDataBlock'       => false,
											'DCCDataBlock' 		   => false
								),
								'Field_Existence_Indicator_Transaction' => array(
											'merchantOrderNumber'  => 'ZUULU'.time(), 
											'amount'  			   => $amount,
											//'amount'  			   => '4012.00',
											// 'successUrl'           => $this->baseurl(),
											// 'failureUrl'           => $this->baseurl(),
											// 'successUrl'           => base_url().'depot/successOrab',
											// 'failureUrl'           => base_url().'depot/successOrab',
											'successUrl'           => base_url().'depot/successOrab',
											'failureUrl'           => base_url().'depot/successOrab',
											//'successUrl'           => "http://localhost/zencart_v155e/index.php?main_page=checkout_process",
											//'failureUrl'           => "http://localhost/zencart_v155e/index.php?main_page=checkout_process",
											'transactionMode'      => 'INTERNET',
											'payModeType'          => 'CC',
											'transactionType'      => '01',
											'currency'             => 'XOF'
											//'currency'             => 'USD'
								),
								'Field_Existence_Indicator_Billing' => array(
											'billToFirstName'       => 'Cheikh Alassane', 
											'billToLastName'        => 'SARR',
											'billToStreet1'         => 'Villa Khadija',
											'billToStreet2'         => 'Route du Ngor Diarama',
											'billToCity'       	    => 'Dakar',
											'billToState'      	    => 'Dakar',
											'billtoPostalCode'      => '12700',
											'billToCountry'         => 'SN',
											'billToEmail'           => '',
											'billToMobileNumber'    => '766459226',
											'billToPhoneNumber1'    => '',
											'billToPhoneNumber2'    => '',
											'billToPhoneNumber3'    => ''
								),
								'Field_Existence_Indicator_Shipping' => array(
											'shipToFirstName'    => 'Cheikh Alassane', 
											'shipToLastName'     => 'SARR', 
											'shipToStreet1'      => 'Villa Khadija', 
											'shipToStreet2'      => 'Route du Ngor Diarama', 
											'shipToCity'         => 'Dakar',
											'shipToState'        => 'Dakar',
											'shipToPostalCode'   => '',
											'shipToCountry'      => 'SN',
											'shipToPhoneNumber1' => '',
											'shipToPhoneNumber2' => '',
											'shipToPhoneNumber3' => '',
											'shipToMobileNumber' => '766459226'
								),
								'Field_Existence_Indicator_Payment' => array(
											'cardNumber'  	  => '', // 1. Card Number  
											'expMonth'  	  => '', 				 // 2. Expiry Month 
											'expYear'  		  => '',             // 3. Expiry Year
											'CVV'  			  => '',              // 4. CVV  
											'cardHolderName'  => '',          // 5. Card Holder Name 
											'cardType'  	  => '',             // 6. Card Type
											'custMobileNumber'=> '',       // 7. Customer Mobile Number
											'paymentID' 	  => '',           // 8. Payment ID 
											'OTP'  			  => '',           // 9. OTP field 
											'gatewayID'  	  => '',             // 10.Gateway ID 
											'cardToken'   	  => ''              // 11.Card Token 
								),
								'Field_Existence_Indicator_Merchant'  => array(
													'UDF1'   => '', // This is a ‘user-defined field’ that can be used to send additional information about the transaction.
													'UDF2'   => '', 			   // This is a ‘user-defined field’ that can be used to send additional information about the transaction.
													'UDF3'   => '',             // This is a ‘user-defined field’ that can be used to send additional information about the transaction.
													'UDF4'   => '',             // This is a ‘user-defined field’ that can be used to send additional information about the transaction.
													'UDF5'   => '',             // This is a ‘user-defined field’ that can be used to send additional information about the transaction.
													'UDF6'   => '',             // This is a ‘user-defined field’ that can be used to send additional information about the transaction.
													'UDF7'   => '',             // This is a ‘user-defined field’ that can be used to send additional information about the transaction.
													'UDF8'   => '',             // This is a ‘user-defined field’ that can be used to send additional information about the transaction.
													'UDF9'   => '',             // This is a ‘user-defined field’ that can be used to send additional information about the transaction.
													'UDF10'  => ''              // This is a ‘user-defined field’ that can be used to send additional information about the transaction.								
								),
								'Field_Existence_Indicator_OtherData'  => array(
										'custID'			     => '',  
										//'custID'			     => '12345',  
										'transactionSource'      => '',  					
										'productInfo'            => '',  						
										'isUserLoggedIn'         => '', 	 						
										'itemTotal'              => '', 
										'itemCategory'           => '', 						
										'ignoreValidationResult' => ''
								),
								'Field_Existence_Indicator_DCC'   => array(
										'DCCReferenceNumber' => '', // DCC Reference Number
										'foreignAmount'	     => '', // Foreign Amount
										'ForeignCurrency'    => ''  // Foreign Currency
								)
							);

		$networkOnlineObject = new NetworkonlineBitmapPaymentIntegration($networkOnlineArray);
		
		$requestParameter = $networkOnlineObject->NeoPostData;

		if($networkOnlineObject->url)
			$requestUrl = 'https://NeO.network.ae/direcpay/secure/PaymentTxnServlet';
		else
			$requestUrl = 'https://uat-NeO.network.ae/direcpay/secure/PaymentTxnServlet';
		
		
        $this->session->set_flashdata('requestUrl', $requestUrl);
        $this->session->set_flashdata('requestParameter', $requestParameter);
		
		
		// Session NetworkOnlineObject
		
		// if($this->session->userdata('networkOnlineObject') != null) {
			// $this->session->unset_userdata('networkOnlineObject');
		// }
        // $this->session->set_userdata('networkOnlineObject', $networkOnlineObject);
		
		$data = array();
        $data['setval'] = 'setval';
		
        $this->load->view('my_popup', $data);
		
        // redirect('payment', 'refresh');
    }
	
	function successOrab() {
		// if(isset($_REQUEST['responseParameter']) && $_REQUEST['responseParameter'] != '' && $this->session->userdata('networkOnlineObject') != null){
		if(isset($_REQUEST['responseParameter']) && $_REQUEST['responseParameter'] != ''){
				
			// $networkOnlineObject = $this->session->userdata('networkOnlineObject');
			$response = $this->decryptData($_REQUEST['responseParameter'],$this->merchantKey,$this->iv);
			// $response = "ABC";
							
			// echo '<pre>';
				// print_r($response);
			// echo '<pre>';
			// $success = (explode("|", $response["Transaction_Status_information"]))[1] == "SUCCESS" ? true : false; 
			
			// $this->session->set_flashdata('success', $success);
			
			// if($success) {
				// $this->session->set_flashdata('success', 'Transaction effectuée avec succès.');
			// } else {
				// $this->session->set_flashdata('success', 'Echec de la transaction.');
			// }
			$this->session->set_flashdata('response', $response);
			// $this->session->set_flashdata('final_redirection', 'ok');
			// redirect('payment', 'refresh');
			// echo "<script language=\"javascript\">alert('".$response."');</script>";
			// echo "<script language=\"javascript\">alert('".$this->session->flashdata("response")."');</script>";
			$this->load->view('my_popup');
				// $networkOnlineObject->AddLog('Network Online Response : '.print_r($response, TRUE),'16');
		}
	}
	
	// public function final_redirection() {
		// $this->session->set_flashdata('success', $this->input->get("success"));
		// $this->session->set_flashdata('response', $this->input->get("response"));
		// redirect('payment', 'refresh');
	// }
	public function decryptData( $data, $key, $iv ){
		
		if($data){
			
			
//			list($merchantId,$encryptString) = explode("||", $data);
//			$enc   	 	  = $this->encryptMethod;
//			$mode  	      = $this->encryptMode;
//			$iv    	      = $iv;
//			$encrypt_key  = $key;		
//			$EncText 	  = base64_decode($encryptString);
//			$padtext      = mcrypt_decrypt($enc, base64_decode($encrypt_key), $EncText, $mode, $iv);
//			$pad 	      = ord($padtext{strlen($padtext) - 1});	

			$enc   	   = 'AES-256-CBC';
			//$mode  	   = MCRYPT_MODE_CBC;
			$iv    	   = $this->iv;
			list($merchantId,$encryptString) = explode("||", $data);
			$base64_decode_key  = base64_decode( $key );
			$options            = 0;
			$text      			= openssl_decrypt( $encryptString, $enc, $base64_decode_key, $options, $iv );

			//$reponseParameters = explode("|",$text);
			$reponseArray = explode("||",$text);
			
			$blockEI 			 = $reponseArray[0]; // It has to contains Seven indicators
			$bitmapString        = str_split($blockEI);
			$blockEIArrayKey     = array(
											'Transaction_Response', 			   //Same as Request 
											'Transaction_related_information',    // Transaction related information 
											'Transaction_Status_information',    //  Transaction Status information 
											'Merchant_Information',    			//   Merchant Information 
											'Fraud_Block',    			       //    Fraud Block 
											'DCC_Block',    			      //     DCC Block 
											'Additional'    			     //      Additional Block Like Card Mask 
										);	
			//
			$bit 		  = 0;
			$blockEIArray = array();

			foreach($blockEIArrayKey as $blockValues){
				$blockEIArray[$blockValues] = $bitmapString[$bit];
				$bit++;
			}
			$blockEIArray = array_filter($blockEIArray);
			// Remove the first element from Array to map with the bit map values 
			array_shift($reponseArray);
			$resposeAssignedArray = array();
			$res 				  = 0;
			foreach($blockEIArray as $key => $value){
					$resposeAssignedArray[$key] =  $reponseArray[$res];
				$res++;
			}
					$TransactionResposeValue['text']		    = $merchantId.'||'.$text;
					$TransactionResposeValue['merchantId']		= $merchantId;
					$TransactionResposeValue['DataBlockBitmap']	= $blockEI;
			foreach($blockEIArrayKey as $key => $value){
					if(isset($resposeAssignedArray[$value]))
						$TransactionResposeValue[$value] = $resposeAssignedArray[$value];
					else
						$TransactionResposeValue[$value] = 'NULL';
			}
			
			return $TransactionResposeValue;		
			
		}else{
			return false;
		}
		
	}
	
	function baseurl(){
		if(isset($_SERVER['HTTPS'])){
			$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
		}
		else{
			$protocol = 'http';
		}
		return $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}


}

/* End of file service.php */
/* Location: ./application/modules/service/controllers/service.php */
