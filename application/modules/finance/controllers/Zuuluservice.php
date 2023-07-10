<?php




if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Zuuluservice extends MX_Controller {

     private static $code = '';
    function __construct() {
        parent::__construct();

       // $this->load->model('zuuluservice_model');

        if (!$this->ion_auth->in_group(array('admin','adminmedecin'))) {
            redirect('home/permission');
        }
        
        $identity = $this->session->userdata["identity"];
        self::$code = $this->settings_model->getCode($identity);  
        
    }

    public function index() {
        $code = self::$code;
     //   $data['zuuluservices'] = $this->zuuluservice_model->getZuulu($code);
        $data['settings'] = $this->settings_model->getSettingsId(self::$code);
        $data['menus'] = $this->settings_model->getMenuByName(self::$code);
        $this->load->view('home/dashboard',$data);
        $this->load->view('zuuluservice', $data);
        $this->load->view('home/footer'); // just the header file
    }


    public function creditNew() {
        $code = self::$code;
     //   $data['zuuluservices'] = $this->zuuluservice_model->getZuulu($code);
        $data['settings'] = $this->settings_model->getSettingsId(self::$code);
        $data['menus'] = $this->settings_model->getMenuByName(self::$code);
        $this->load->view('home/dashboard',$data);
        $this->load->view('credit_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function woyofalNew() {
        $code = self::$code;
     //   $data['zuuluservices'] = $this->zuuluservice_model->getZuulu($code);
        $data['settings'] = $this->settings_model->getSettingsId(self::$code);
        $data['menus'] = $this->settings_model->getMenuByName(self::$code);
        $this->load->view('home/dashboard',$data);
        $this->load->view('woyofal_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function seneauNew() {
        $code = self::$code;
     //   $data['zuuluservices'] = $this->zuuluservice_model->getZuulu($code);
        $data['settings'] = $this->settings_model->getSettingsId(self::$code);
        $data['menus'] = $this->settings_model->getMenuByName(self::$code);
        $this->load->view('home/dashboard',$data);
        $this->load->view('seneau_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function senelecNew() {
        $code = self::$code;
     //   $data['zuuluservices'] = $this->zuuluservice_model->getZuulu($code);
        $data['settings'] = $this->settings_model->getSettingsId(self::$code);
        $data['menus'] = $this->settings_model->getMenuByName(self::$code);
        $this->load->view('home/dashboard',$data);
        $this->load->view('senelec_new', $data);
        $this->load->view('home/footer'); // just the header file
    }
    
    public function confirmationCredit() {
        $code = self::$code;
     //   $data['zuuluservices'] = $this->zuuluservice_model->getZuulu($code);
        $data['settings'] = $this->settings_model->getSettingsId(self::$code);
        $data['menus'] = $this->settings_model->getMenuByName(self::$code);
        $this->load->view('home/dashboard',$data);
        $this->load->view('credit_confirmation', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function confirmationWoyofal() {
        $code = self::$code;
     //   $data['zuuluservices'] = $this->zuuluservice_model->getZuulu($code);
        $data['settings'] = $this->settings_model->getSettingsId(self::$code);
        $data['menus'] = $this->settings_model->getMenuByName(self::$code);
        $this->load->view('home/dashboard',$data);
        $this->load->view('woyofal_confirmation', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function factureSenEau() {
        $code = self::$code;
     //   $data['zuuluservices'] = $this->zuuluservice_model->getZuulu($code);
        $data['settings'] = $this->settings_model->getSettingsId(self::$code);
        $data['menus'] = $this->settings_model->getMenuByName(self::$code);
        $this->load->view('home/dashboard',$data);
        $this->load->view('seneau_facture', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function sendZuulumedAction() {

       /* $this->load->library('HttpClient', array(
            'headers' => array(
                 'Authorization: SomekeyHere',
                 'Content-Type: application/json',
            ),
            'data' => array(
                'FN' => 'GPD',
                'fromCustmer' => '2214060000',
                'PIN' => 'PIN',
                'mobNo' => 'mobNo',
                'mobNo' => '100',
                'fromPartnerId' => '2214060000',
                'transferTypeId' => '326',

            ),
            'url' => 'https://test.zuulu.net:5051/zuulu',
        ));

        if($this->httpclient->post()){
            var_dump($this->httpclient->getResults());
        } else {
            echo $this->httpclient->getErrorMsg();
        }*/



  #This url define speific Target for guzzle
  $url        = 'https://test.zuulu.net:5051/zuulu';



$client = new Client(); 
$client->setUri($url);
     //$client->setAdapter('Zend\Http\Client\Adapter\Curl');

        $client->setOptions(array('timeout' => 30));

        $method = $this->params()->fromQuery('method', 'get');
        $client->setUri('https://test.zuulu.net:5051/zuulu');
        $client->setMethod('POST');
        // $client->setParameterPOST(); 
        $content = '<?xml version="1.0" encoding="UTF-8" ?>';
        $content .= '<Request FN="GPD" fromCustmer="2214060000" PIN="771177" mobNo="781156335" amount=100 LN="FR" fromPartnerId="2214060000" transferTypeId="326" >';
        $content .= '</Request>';

    
        $client->setRawBody($content);
        $response = $client->send();
		var_dump($response);
		exit();
		

        /*    if (!$response->isSuccess()) {
          $message = $response->getStatusCode() . ': ' . $response->getReasonPhrase();
          $response = $this->getResponse();
          $response->setContent($message);
          return $response;
          } */
        $body = $response->getBody();
       
        $bodyXml = simplexml_load_string($body); //$body  = json_encode($body);

        $ResponseStatus = $bodyXml->ResponseStatus;
        $ResponseCode = $bodyXml->ResponseCode;
        $ResponseMessage = 'validation ok';
        if ($ResponseCode == '200') {
            $this->getServiceLocator()->get("ZuulumedLog")->crit('sucess: zuulumed api xml');
            $this->getServiceLocator()->get("ZuulumedLog")->crit($body);
        } else {

            $ResponseMessage = $bodyXml->ResponseMessage->descriptionErreur;
            $this->getServiceLocator()->get("ZuulumedLog")->err($ResponseCode . '--' . $ResponseMessage);
            $this->getServiceLocator()->get("ZuulumedLog")->err($body);
        }

        echo json_encode($ResponseMessage);
        exit;
        /*  }else{
          $response = 'fromCustmer est vide.';
          } */
    }

   
}

/* End of file department.php */
/* Location: ./application/modules/department/controllers/department.php */
