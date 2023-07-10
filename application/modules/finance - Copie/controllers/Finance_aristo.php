<?php

require_once FCPATH . '/vendor/autoload.php';

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Finance extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('finance_model');
        $this->load->model('doctor/doctor_model');
        $this->load->model('patient/patient_model');
        $this->load->model('finance/pharmacy_model');
        $this->load->model('accountant/accountant_model');
        $this->load->model('receptionist/receptionist_model');
        $this->load->model('home/home_model');
        $this->load->model('depot/depot_model');
        $this->load->model('donor/donor_model');
        $this->load->model('lab/lab_model');
        $this->load->module('sms');
// Bulk
        $this->load->library('Excel');
        $this->load->model('import/import_model');
        $this->load->helper('file');
        $this->load->model('services/service_model');
        require APPPATH . 'third_party/stripe/stripe-php/init.php';
        $this->load->module('paypal');
        $this->load->model('partenaire/partenaire_model');

        if (!$this->ion_auth->in_group(array('admin', 'adminmedecin', 'Accountant', 'Receptionist', 'Assistant', 'Nurse', 'Laboratorist', 'Doctor', 'adminmedecin', 'Biologiste'))) {
            redirect('home/permission');
        }

        $identity = $this->session->userdata["identity"];

        $this->id_organisation = $this->home_model->get_id_organisation($identity);
        $this->path_logo = $this->home_model->get_logo_organisation($this->id_organisation);
        $this->nom_organisation = $this->home_model->get_nom_organisation($this->id_organisation);
        $this->id_partenaire_zuuluPay = $this->home_model->id_partenaire_zuuluPay($this->id_organisation);
        $this->pin_partenaire_zuuluPay_encrypted = $this->home_model->pin_partenaire_zuuluPay_encrypted($this->id_organisation);
        $this->code_organisation = $this->home_model->get_code_organisation($this->id_organisation);
        $this->entete = $this->home_model->get_entete($this->id_organisation);
    }

    public function index() {

        redirect('finance/financial_report');
    }

    function insurance() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        } else {
            $data['tiers_payant'] = $this->finance_model->getTiersPayantByOrganisation($this->id_organisation);
            $data['settings'] = $this->settings_model->getSettings();

            $data['id_organisation'] = $this->id_organisation;
            $data['path_logo'] = $this->path_logo;
            $data['nom_organisation'] = $this->nom_organisation;

            $this->load->view('home/dashboard', $data);
            $this->load->view('insurance', $data);
            $this->load->view('home/footer');
        }
    }

    function import() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        } else {

            $data['id_organisation'] = $this->id_organisation;
            $data['path_logo'] = $this->path_logo;
            $data['nom_organisation'] = $this->nom_organisation;

            $this->load->view('home/dashboard', $data);
            $this->load->view('import', $data);
            $this->load->view('home/footer');
        }
    }

    function importPrestationInfo() {
        if (isset($_FILES["filename"]["name"])) {
// Validation format
            $file_name = $_FILES['filename']['name'];

            $temp = explode(".", $_FILES["filename"]["name"]);
            $extension = end($temp);
            $mimes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            $allowedExts = ['xl', 'xls', 'xlsx'];
// SI OK
            $path = $_FILES["filename"]["tmp_name"];
            $tablename = $this->input->post('tablename');

            $this->importPrestation($path, $tablename);
            if (in_array($_FILES['filename']['type'], $mimes) && in_array($extension, $allowedExts)) {
                
            } else {

                $this->session->set_flashdata('feedback', lang('wrong_file_format'));

                redirect('finance/paymentCategory');
            }
        } else {

            $this->session->set_flashdata('feedback', lang('wrong_file_format'));

            redirect('finance/paymentCategory');
        }
    }

    function importPrestation2($file, $tablename) {
        $object = PHPExcel_IOFactory::load($file);
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();    //get Highest Row
            $highestColumnLetter = $worksheet->getHighestColumn(); //get column highest as  letter
            $highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumnLetter); // convert letter to column index in number
            for ($column1 = 0; $column1 < $highestColumn; $column1++) {
                $rowData1[] = $worksheet->getCellByColumnAndRow($column1, 1)->getValue();
            }


            $headerexist = $this->import_model->headerExist($rowData1, $tablename); // get boolean header exist or not


            if ($headerexist) {

                $exist_name = [];
                $missing_service = [];
                $erreur_tarifs = [];

                $exist_rows = "";
                $missing_service_rows = "";
                $erreur_tarifs_rows = "";

                $message2 = "";

                for ($row = 2; $row <= $highestRow; $row++) {
                    $rowData = [];
                    $rowData2 = [];

                    $tarif_public_ok = false;
                    $tarif_professionnel_ok = false;
                    $tarif_assurance_ok = false;

                    for ($column = 0; $column < $highestColumn; $column++) {
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Prestation') {
                            $nomPrestation = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Service') {
                            $nomService = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Service') { // Cas Service: Fetch ID Service
                            $rowData[] = $this->db->query("select idservice from setting_service join department on department.id = setting_service.id_department and department.id_organisation = " . $this->id_organisation . " where name_service = \"" . $nomService . "\"")->num_rows() != 0 ? $this->db->query("select idservice from setting_service join department on department.id = setting_service.id_department and department.id_organisation = " . $this->id_organisation . " where name_service = \"" . $nomService . "\"")->row()->idservice : null;
                        } else {
                            if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Tarif Public') { // Cas Tarifs: Remove Dots '.'
                                $tarif = str_replace(".", "", $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue());
                                $tarif = str_replace(",", "", $tarif); // Cas Excel Local Client avec "," comme separateur milliers
                                $tarif = str_replace(" ", "", $tarif); // Cas Excel Local Client avec " " comme separateur milliers
                                $rowData[] = $tarif;
                                if ($tarif >= "1000" && $tarif <= "100000") {
                                    $tarif_public_ok = true;
                                }
                            } else if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Tarif Professionnel') { // Cas Tarifs: Remove Dots '.'
                                $tarif = str_replace(".", "", $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue());
                                $tarif = str_replace(",", "", $tarif); // Cas Excel Local Client avec "," comme separateur milliers
                                $tarif = str_replace(" ", "", $tarif); // Cas Excel Local Client avec " " comme separateur milliers
                                $rowData[] = $tarif;
                                if ($tarif >= "1000" && $tarif <= "100000") {
                                    $tarif_professionnel_ok = true;
                                }
                            } else if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Tarif Assurance') { // Cas Tarifs: Remove Dots '.'
                                $tarif = str_replace(".", "", $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue());
                                $tarif = str_replace(",", "", $tarif); // Cas Excel Local Client avec "," comme separateur milliers
                                $tarif = str_replace(" ", "", $tarif); // Cas Excel Local Client avec " " comme separateur milliers
                                $rowData[] = $tarif;
                                if ($tarif >= "1000" && $tarif <= "100000") {
                                    $tarif_assurance_ok = true;
                                }
                            } else {
                                $rowData[] = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                            }
                        }
                    }

// $prestationExiste = 0;
                    $prestationExiste = $this->db->query("select payment_category.id from payment_category join setting_service on (payment_category.id_service = setting_service.idservice and setting_service.name_service = \"" . $nomService . "\" and payment_category.prestation ='" . $nomPrestation . "') join department on department.id = setting_service.id_department and department.id_organisation = " . $this->id_organisation)->num_rows();
                    $serviceExiste = $this->db->query("select idservice from setting_service  join department on department.id = setting_service.id_department and department.id_organisation = " . $this->id_organisation . " where name_service = \"" . $nomService . "\"")->num_rows();

                    if ($prestationExiste) { // Si prestation existante (meme service / mme prestation): refus
                        $exist_name[] = $row;
                        $exist_rows = implode(',', $exist_name);
                    }
                    if (!$serviceExiste) { // Si Service non existant: refus
                        $missing_service[] = $row;
                        $missing_service_rows = implode(',', $missing_service);
                    }
                    if (!$tarif_public_ok || !$tarif_assurance_ok || !$tarif_professionnel_ok) { // Si Service non existant: refus
                        $erreur_tarifs[] = $row;
                        $erreur_tarifs_rows = implode(',', $erreur_tarifs);
                    }
                    if (!$prestationExiste && $serviceExiste && $tarif_public_ok && $tarif_assurance_ok && $tarif_professionnel_ok) {
// array_push($rowData, date('d/m/y'));
// array_push($rowData2, 'add_date');
                        $rowData2 = array("id_service", "prestation", "description", "tarif_public", "tarif_professionnel", "tarif_assurance");
                        $data = array_combine($rowData2, $rowData);

                        $this->import_model->dataEntry($data, $tablename);
// $this->import_model->dataEntryPrestation($data);
                    }
                }

                $verbe_exist_name = count($exist_name) > 1 ? "contiennent" : "contient";
                $verbe_missing_service = count($missing_service) > 1 ? "contiennent" : "contient";
                $verbe_erreur_tarifs = count($erreur_tarifs) > 1 ? "contiennent" : "contient";

                $message2 .= count($exist_name) ? 'Lignes numéro ' . $exist_rows . ' ' . $verbe_exist_name . ' une prestation déjà existante!' . "<br/>" : "";
                $message2 .= count($missing_service) ? "Lignes numéro " . $missing_service_rows . " " . $verbe_missing_service . " un Service qui n'existe pas!" . "<br/>" : "";
                $message2 .= count($erreur_tarifs) ? "Lignes numéro " . $erreur_tarifs_rows . " " . $verbe_erreur_tarifs . " un tarif non compris entre 1.000 et 100.000 Fcfa!" . "<br/>" : "";

                $count_errors = count($exist_name) + count($missing_service) + count($erreur_tarifs);
                $import_error_label = $count_errors ? lang("import_errors") : lang("import_error");
                $import_status_label = !$count_errors ? lang('successful_data_import') : lang('successful_data_import_with_errors');
                $this->session->set_flashdata('feedback', $import_status_label . " " . $count_errors . " " . $import_error_label);
                $this->session->set_flashdata('message2', $message2);
            } else {
                $this->session->set_flashdata('feedback', lang('wrong_file_format'));
            }
        }
        redirect('finance/import');
    }

    function importPrestation($file, $tablename) {
        $object = PHPExcel_IOFactory::load($file);
        $rowData1 = array();
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();    //get Highest Row
            $highestColumnLetter = $worksheet->getHighestColumn(); //get column highest as  letter
            $highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumnLetter); // convert letter to column index in number
            for ($column1 = 0; $column1 < $highestColumn; $column1++) {
                $rowData1[] = $worksheet->getCellByColumnAndRow($column1, 1)->getValue();
            }


            $headerexist = true; //$this->import_model->headerExist($rowData1, $tablename); // get boolean header exist or not


            if ($headerexist) {

                $exist_name = [];
                $missing_service = [];
                $erreur_tarifs = [];

                $exist_rows = "";
                $missing_service_rows = "";
                $erreur_tarifs_rows = "";

                $message2 = "";
                $count_update = 0;
                $idPrestationstab = array();
                $idPrestations = 0;
                for ($row = 1; $row <= $highestRow; $row++) {
                    $rowData = [];
                    $rowData2 = [];

                    $tarif_public_ok = false;
                    $public = 0;
                    $tarif_professionnel_ok = false;
                    $pro = 0;
                    $tarif_assurance_ok = false;
                    $ass = 0;
                    $ipm = 0;

                    for ($column = 0; $column < $highestColumn; $column++) {

                        $x = 2;
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() != " ") {
                            $x = 1;
                        }

                        if ($worksheet->getCellByColumnAndRow($column, $x)->getValue() === 'Prestations') {
                            $nomPrestation = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                            if ($nomPrestation) {
                                $sqlPrestations = $this->db->query("select id from payment_category where prestation = \"" . $nomPrestation . "\"");
                                $sqlTab = $sqlPrestations->num_rows();
                                if ($sqlTab != 0) {
                                    $idPrestations = $sqlPrestations->row()->id;
                                }
                            }
                        }


                        if ($worksheet->getCellByColumnAndRow($column, $x)->getValue() === 'Tarif Public') {
                            $public = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                            $rowData[] = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, $x)->getValue() === 'Tarif Pro') {
                            $pro = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                            $rowData[] = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, $x)->getValue() === 'Tarif Assurance') {
                            $ass = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                            $rowData[] = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, $x)->getValue() === 'Tarif IPM') {
                            $ipm = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                            $rowData[] = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }
                    }

                    if ($public) {
                        $rowData2 = array("tarif_public", "tarif_professionnel", "tarif_assurance", "tarif_ipm");
                        $data = array_combine($rowData2, $rowData);

                        if ($idPrestations) {
                            $this->import_model->dataEntryUpdate2($idPrestations, $data, 'payment_category');
                            $this->import_model->dataEntryUpdate3($idPrestations, $this->id_organisation, 'labo');
                            $count_update++;
                            $idPrestationstab[] = $idPrestations;
                        }
                    }
                }
                if (count($idPrestationstab) > 0) {
                    $this->import_model->dataEntryUpdate4('labo', $this->id_organisation);

                    foreach ($idPrestationstab as $idPrestationn)
                        $this->import_model->dataEntryUpdate5($idPrestationn, 'labo', $this->id_organisation);
                }
                $message_parametre = $count_update . " mise(s) a jour <br/>";
            } else {
                $this->session->set_flashdata('feedback', lang('wrong_file_format'));
            }
        }

        $this->session->set_flashdata('feedback', $message_parametre);
        redirect('finance/paymentCategory');
    }

    public function menuService() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);

        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data);
        $this->load->view('zuuluservice', $data);
        $this->load->view('home/footer');
    }

    public function creditNew() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
        $this->load->view('home/dashboard', $data);
        $this->load->view('credit_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function depotOM() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
        $this->load->view('home/dashboard', $data);
        $this->load->view('depotom_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function woyofalNew() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
        $this->load->view('home/dashboard', $data);
        $this->load->view('woyofal_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function seneauNew() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data);
        $this->load->view('seneau_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function senelecNew() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data);
        $this->load->view('senelec_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function rapidoNew() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data);
        $this->load->view('rapido_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function confirmationCredit() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $code = $this->input->get('code');
        $amount = $this->input->get('amount');
        $phone = $this->input->get('phone');
        $numeroTransaction = $this->input->get('transaction');
        $heure = $this->input->get('heure');
        $tab = $this->finance_model->getIdCategoryByCode($code);
        $type = $this->input->get('type');
        $count_payment = $this->db->get_where('expense', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
// $codeFacture = 'R-' . $this->code_organisation . '-' . str_pad($count_payment, 4, "0", STR_PAD_LEFT);
        $codeFacture = 'R' . $this->code_organisation . '' . $count_payment;

        $date = time();
        $data = array(
            'category' => $type,
            'amount' => $amount,
            'note' => $numeroTransaction,
            'numeroTransaction' => $numeroTransaction,
            'referenceClient' => $phone,
            'id_organisation' => $this->id_organisation,
            'beneficiaire' => $phone,
            'heure' => $heure,
            'status' => 2,
            'user' => $this->ion_auth->get_user_id(),
            'date' => $date,
            'codeType' => $type,
            'datestring' => date('d/m/y H:i', $date),
            'codeFacture' => $codeFacture,
        );

        $this->finance_model->insertExpense($data);
        echo json_encode($data);
    }

    public function confirmationSeneau() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $code = $this->input->get('code');
        $amount = $this->input->get('amount');
        $client = $this->input->get('client');
        $numeroTransaction = $this->input->get('transaction');
        $numeroFacture = $this->input->get('numeroFacture');
        $refenceClient = $this->input->get('referenceClient');
        $heure = $this->input->get('heure');
        $tab = $this->finance_model->getIdCategoryByCode($code);
        $type = $this->input->get('type');
        $count_payment = $this->db->get_where('expense', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
// $codeFacture = 'R-' . $this->code_organisation . '-' . str_pad($count_payment, 4, "0", STR_PAD_LEFT);
        $codeFacture = 'R' . $this->code_organisation . '' . $count_payment;

        $date = time();
        $data = array(
            'category' => $type,
            'amount' => $amount,
            'note' => $numeroFacture,
            'beneficiaire' => $client,
            'heure' => $heure,
            'numeroTransaction' => $numeroTransaction,
            'referenceClient' => $refenceClient,
            'id_organisation' => $this->id_organisation,
            'numeroFacture' => $numeroFacture,
            'codeType' => $type,
            'status' => 2,
            'user' => $user = $this->ion_auth->get_user_id(),
            'date' => $date,
            'datestring' => date('d/m/y H:i', $date),
            'codeFacture' => $codeFacture,
        );

        $this->finance_model->insertExpense($data);
        echo json_encode($data);
    }

    public function confirmationSenelec() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $code = $this->input->get('code');
        $amount = $this->input->get('amount');
        $client = $this->input->get('referenceClient');
        $numeroTransaction = $this->input->get('transaction');
        $numeroFacture = $this->input->get('numeroFacture');
        $refenceClient = $this->input->get('referenceClient');
        $heure = $this->input->get('heure');
        $tab = $this->finance_model->getIdCategoryByCode($code);
        $type = $this->input->get('type');
        $count_payment = $this->db->get_where('expense', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
// $codeFacture = 'R-' . $this->code_organisation . '-' . str_pad($count_payment, 4, "0", STR_PAD_LEFT);
        $codeFacture = 'R' . $this->code_organisation . '' . $count_payment;
        $date = time();
        $data = array(
            'category' => $type,
            'amount' => $amount,
            'note' => $numeroFacture,
            'beneficiaire' => $client,
            'heure' => $heure,
            'numeroTransaction' => $numeroTransaction,
            'referenceClient' => $refenceClient,
            'numeroFacture' => $numeroFacture,
            'id_organisation' => $this->id_organisation,
            'codeType' => $type,
            'status' => 2,
            'user' => $user = $this->ion_auth->get_user_id(),
            'date' => $date,
            'datestring' => date('d/m/y H:i', $date),
            'codeFacture' => $codeFacture,
        );

        $this->finance_model->insertExpense($data);
        echo json_encode($data);
    }

    public function confirmationWoyofal() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $code = $this->input->get('code');
        $amount = $this->input->get('amount');
        $client = $this->input->get('phone');
        $codegenerer = $this->input->get('codeRecharge');
        $numeroTransaction = $this->input->get('transaction');
        $referenceClient = $this->input->get('numeroCompteur');
        $tab = $this->finance_model->getIdCategoryByCode($code);
        $type = $this->input->get('type');
        $count_payment = $this->db->get_where('expense', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
// $codeFacture = 'R-' . $this->code_organisation . '-' . str_pad($count_payment, 4, "0", STR_PAD_LEFT);
        $codeFacture = 'R' . $this->code_organisation . '' . $count_payment;
        $date = time();
        $data = array(
            'category' => $type,
            'amount' => $amount,
            'note' => $codegenerer,
            'beneficiaire' => $client,
            'numeroTransaction' => $numeroTransaction,
            'referenceClient' => wordwrap($referenceClient, 4, '-', true),
            'id_organisation' => $this->id_organisation,
            'codeType' => $type,
            'status' => 2,
            'user' => $user = $this->ion_auth->get_user_id(),
            'date' => $date,
            'datestring' => date('d/m/y H:i', $date),
            'codeFacture' => $codeFacture,
        );

        $this->finance_model->insertExpense($data);
        echo json_encode($data);
    }

    public function factureSenEau() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data);
        $this->load->view('seneau_facture', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function payment() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['settings'] = $this->settings_model->getSettings();

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('payment', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function paymentLabo() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['settings'] = $this->settings_model->getSettings();

        $data['payments'] = $this->getPaymentLabo();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('payment_labo', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function amountDistribution() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['payments'] = $this->finance_model->getPayment();

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('amount_distribution', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addPaymentView() {
        $data = array();
        $data['discount_type'] = $this->finance_model->getDiscountType($this->id_organisation);
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->finance_model->getPaymentCategory($this->id_organisation);
        $data['gateway'] = $this->finance_model->getGatewayByName($data['settings']->payment_gateway, $this->id_organisation);
        $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
        $data['groups'] = $this->donor_model->getBloodBank();
        $data['type_of_purpose'] = $this->finance_model->getPurpose();
        $data['religions'] = array('Musulman', 'Chretien', 'Autres');
        $data['regions'] = array('Dakar', 'Ziguinchor', 'Diourbel', 'Saint-Louis', 'Tambacounda', 'Kaolack', 'Thiès', 'Louga', 'Fatick', 'Kolda', 'Matam', 'Kaffrine', 'Kédougou', 'Sédhiou');
        $this->load->view('home/dashboard', $data); // just the header file

        $this->load->view('add_payment_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addPaymentViewConsultation() {
        $data = array();
        $idCons = $this->input->get('idCons');
        $data['discount_type'] = $this->finance_model->getDiscountType($this->id_organisation);
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->finance_model->getPaymentCategory($this->id_organisation);
        $data['gateway'] = $this->finance_model->getGatewayByName($data['settings']->payment_gateway, $this->id_organisation);
        $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
        $data['groups'] = $this->donor_model->getBloodBank();
        $data['religions'] = array('Musulman', 'Chretien', 'Autres');
        $data['regions'] = array('Dakar', 'Ziguinchor', 'Diourbel', 'Saint-Louis', 'Tambacounda', 'Kaolack', 'Thiès', 'Louga', 'Fatick', 'Kolda', 'Matam', 'Kaffrine', 'Kédougou', 'Sédhiou');

        $data['specialite'] = $this->input->post('specialite');
        $data['namePrestation'] = $this->input->post('namePrestation');
        $data['poids'] = $this->input->post('poids');
        $data['taille'] = $this->input->post('taille');
        $data['temperature'] = $this->input->post('temperature');
        $data['frequenceRespiratoire'] = $this->input->post('frequenceRespiratoire');
        $data['frequenceCardiaque'] = $this->input->post('frequenceCardiaque');
        $data['glycemyCapillaire'] = $this->input->post('glycemyCapillaire');
        $data['Saturationarterielle'] = $this->input->post('Saturationarterielle');
        $data['hypertensionSystolique'] = $this->input->post('hypertensionSystolique');
        $data['hypertensionDiastolique'] = $this->input->post('hypertensionDiastolique');
        $data['systolique'] = $this->input->post('systolique');
        $data['diastolique'] = $this->input->post('diastolique');
        $data['tensionArterielle'] = $this->input->post('tensionArterielle');
        $data['glycemyCapillaireUnite'] = $this->input->post('glycemyCapillaireUnite');
        $this->load->view('home/dashboard', $data); // just the header file
        if ($idCons === '1') {
            $this->load->view('add_payment_view_consultation', $data);
        }
        if ($idCons === '2') {

            $this->load->view('add_payment_view_imagerie', $data);
        }

        $this->load->view('home/footer'); // just the header file
    }

    public function addPayment() {
        $id = $this->input->post('id');
        $item_selected = array();
        $quantity = array();
        $category_selected = array();
// $amount_by_category = $this->input->post('category_amount');
        $category_selected = $this->input->post('category_name');
        $item_selected = $this->input->post('category_id');

        $quantity = $this->input->post('quantity');
        $remarks = $this->input->post('remarks');
        $remarksId = $this->input->post('remarksId');
        $remarksType = $this->input->post('remarksType');
        $doctorInitial = $this->input->post('doctor');
        $renseignementClinique = $this->input->post('renseignementClinique');
        $charge_mutuelle = $this->input->post('charge_mutuelle') ? $this->input->post('charge_mutuelle') : 0;
// $service = $this->input->post('service'); 
        $id_service_specialite_organisation = $this->input->post('service'); // NEW
        $service = '';

        if (!empty($id_service_specialite_organisation)) {
            $service = $this->db->query("select id_service from setting_service_specialite_organisation where id =" . $id_service_specialite_organisation)->row()->id_service; // NEW
        }
// if(!empty($doctorSelect)){
//     $doctorChoisi = $doctorSelect;
//     var_dump($doctorChoisi.' '.$doctorInitial);
//     exit();
// }
// if(empty($doctorSelect)){
//     $doctorChoisi = $doctorSelect;
//     var_dump($doctorChoisi.' '.$doctorInitial);
//     exit();
// }
        $etat = $this->input->post('choicepartenaire');
        $etatlight = $this->input->post('choicepartenaire_light');
        $destinataire = $this->input->post('partenaire');
        $destinatairelight = $this->input->post('lightpartenaire');
        $amount_received = $this->input->post('amount_received');
        $page = $this->input->post('page');

        $amount_received = !empty($amount_received) ? $amount_received : 0;
        if (empty($item_selected)) {
            $this->session->set_flashdata('feedback', lang('select_an_item'));
            redirect('finance/addPaymentView');
        } else {
            $item_quantity_array = array();
            $item_quantity_array = array_combine($item_selected, $quantity);
        }

        $cat_and_price = array();
        $cat_and_price_pro = array();
        $category_name_pro = '';
        if (!empty($item_quantity_array)) {
            foreach ($item_quantity_array as $key => $value) {
                $service_explode = array();
                $service_explode = explode("-", $key);
// $current_item = $this->finance_model->getPaymentCategoryById($key, $this->id_organisation);
                if ($service_explode[0] == 'service') {
                    if ($etat == '1' && $destinataire) {
                        $current_item = $this->db->query("select payment_category_organisation.tarif_public, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm, payment_category_organisation.tarif_professionnel from payment_category_organisation where id_presta =" . $service_explode[1] . " and id_organisation=" . $destinataire)->row();
                        $buff_org = $destinataire;
                    } else if ($etatlight == '1' && $destinatairelight) {
                        $current_item = $this->db->query("select payment_category_organisation.tarif_public, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm, payment_category_organisation.tarif_professionnel from payment_category_organisation where id_presta =" . $service_explode[1] . " and id_organisation=" . $this->id_organisation)->row();
                        $buff_org = $destinatairelight;
                        $destinataire = $destinatairelight;
                    } else {
                        $current_item = $this->db->query("select payment_category_organisation.tarif_public, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm from payment_category_organisation where id_presta =" . $service_explode[1] . " and id_organisation=" . $this->id_organisation)->row();
                        $buff_org = $this->id_organisation;
                    }

// if (!empty($remarks) && $etat) {


                    if (!empty($remarks) && !$etatlight) {
// Check si prestation couverte dans partenariat
                        $id_partenariat_buff = $this->db->query("select id from partenariat_sante_assurance where id_organisation_sante=" . $buff_org . " and id_organisation_assurance=" . $remarksId)->row()->id;
                        $est_couverte = $this->db->query("select (CASE WHEN sante_assurance_prestation.est_couverte IS NULL THEN '1' ELSE '0' END) as est_couverte from payment_category left join sante_assurance_prestation on sante_assurance_prestation.id_partenariat_sante_assurance = " . $id_partenariat_buff . " AND sante_assurance_prestation.id_payment_category = " . $service_explode[1])->row()->est_couverte;

                        if ($est_couverte) {
                            if ($remarksType == "IPM") {
                                $category_price = intval($current_item->tarif_ipm);
                            } else if ($remarksType == "Assurance") {
                                $category_price = intval($current_item->tarif_assurance);
                            }
                        } else {
                            $category_price = intval($current_item->tarif_public);
                        }
                    } else {
                        $category_price = intval($current_item->tarif_public);
                    }

                    $category_type = "";
                    $qty = $value;
                    if ($etat == '1' || $etatlight == '1' || $amount_received > 0) {
                        $cat_and_price[] = $service_explode[1] . '*' . $category_price . '*' . $service . '*' . $qty . '*1' . '*service';
                        if (isset($current_item->tarif_professionnel)) {
                            $cat_and_price_pro[] = $service_explode[1] . '*' . intval($current_item->tarif_professionnel) . '*' . $service . '*' . $qty . '*1' . '*service';
                        }
                    } else {
                        $cat_and_price[] = $service_explode[1] . '*' . $category_price . '*' . $service . '*' . $qty . '*0' . '*service';
                    }
                } else {

                    $lab_details = $this->lab_model->getLabTestImportedById($service_explode[1]);
                    $qty = $value;
                    $category_price = $lab_details->add_price;

                    $cat_and_price[] = $lab_details->id . '*' . $lab_details->add_price . '*' . $lab_details->name . '*' . $qty . '*1' . '*lab';
                }
                $amount_by_category[] = $category_price * $qty;
            }
            $category_name = implode(',', $cat_and_price);
            if ($cat_and_price_pro) {
                $category_name_pro = implode(',', $cat_and_price_pro);
            }
        } else {
            $this->session->set_flashdata('feedback', lang('attend_the_required_fields'));
            redirect('finance/addPaymentView');
        }

        $patient = $this->input->post('patient');

        $p_name = $this->input->post('p_name');
        $last_p_name = $this->input->post('last_p_name');
        $p_email = $this->input->post('p_email');
        if (empty($p_email)) {
            $p_email = $p_name . '-' . rand(1, 1000) . '-' . $p_name . '-' . rand(1, 1000) . '@example.com';
        }
        if (!empty($p_name)) {
            $password = $p_name . '-' . rand(1, 100000000);
        }
        $p_phone = $this->input->post('p_phone');
        $p_age = $this->input->post('p_age');
        $p_gender = $this->input->post('p_gender');
        $add_date = date('m/d/y HH:i');

        $patient_id = rand(10000, 1000000);

        $d_name = $this->input->post('d_name');
        $d_email = $this->input->post('d_email');
        if (empty($d_email)) {
            $d_email = $d_name . '-' . rand(1, 1000) . '-' . $d_name . '-' . rand(1, 1000) . '@example.com';
        }
        if (!empty($d_name)) {
            $password = $d_name . '-' . rand(1, 100000000);
        }
        $d_phone = $this->input->post('d_phone');

        $doctor = $this->input->post('doctor');
        $date = time();
        $date_string = date('d/m/Y H:i', $date);
        $discount = $this->input->post('discount');
        if (empty($discount)) {
            $discount = 0;
        }

        $deposit_type = $this->input->post('deposit_type');
        $user = $this->ion_auth->get_user_id();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

// Validating Category Field
// $this->form_validation->set_rules('category_amount[]', 'Category', 'min_length[1]|max_length[100]');
// Validating Price Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Price Field
        $this->form_validation->set_rules('discount', 'Discount', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            redirect('finance/addPaymentView');
        } else {
            $pcr_exist = $this->input->post('pcr_exist');
            if (!empty($pcr_exist)) {
                $passport = $this->input->post('passport');
                $type_of_purpose = $this->input->post('type_pf_purpose');
                
                $type_of_new = $this->input->post('type_of_new');
                if ($type_of_purpose == 'add_new') {
                    $data_purpose = $this->db->insert('purpose', array('name' => $type_of_new));
                    $inserted_id_purpose = $this->db->insert_id('purpose');
                     $data['purpose'] = $inserted_id_purpose;
                     $purpose=$inserted_id_purpose;
                } else {
                    $data['purpose'] = $type_of_purpose;
                    $purpose=$type_of_purpose;
                }
            } else {
                $data['purpose'] = ' ';
            }
            if (!empty($p_name)) {



                $data_p = array(
                    'patient_id' => $patient_id,
                    'name' => $p_name,
                    'last_name' => $last_p_name,
                    'email' => $p_email,
                    'phone' => $p_phone,
                    'sex' => $p_gender,
                    'age' => $p_age,
                    'add_date' => $add_date,
                    'how_added' => 'from_pos',
                );
                $username = $this->input->post('p_name');
// Adding New Patient
                if ($this->ion_auth->email_check($p_email)) {
                    $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                } else {
                    $dfg = 5;
                    $this->ion_auth->register($username, $password, $p_email, $dfg);
                    $ion_user_id = $this->db->get_where('users', array('email' => $p_email))->row()->id;
                    $last_patient_user_id = $this->patient_model->insertPatient($data_p);
                    $patient_user_id = $last_patient_user_id; //$this->db->get_where('patient', array('email' => $p_email))->row()->id;

                    $count_patient = $this->db->get_where('patient', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
// $patient_id = 'P-' . $this->code_organisation . '-' . str_pad($count_patient, 4, "0", STR_PAD_LEFT);
                    $patient_id = 'P' . $this->code_organisation . '' . $count_patient;
                    $id_info = array('ion_user_id' => $ion_user_id, 'patient_id' => $patient_id);
                    $this->patient_model->updatePatient($patient_user_id, $id_info, $this->id_organisation);
                }
//    }
            } else {
                if (!empty($pcr_exist)) {
                    $data_p = array('passport' => $passport);
                    $this->patient_model->updatePatient($patient, $data_p, $this->id_organisation);
                }
            }

            if (!empty($d_name)) {

                $data_d = array(
                    'name' => $d_name,
                    'email' => $d_email,
                    'phone' => $d_phone,
                );
                $username = $this->input->post('d_name');
// Adding New Patient
                if ($this->ion_auth->email_check($d_email)) {
                    $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                } else {
                    $dfgg = 4;
                    $this->ion_auth->register($username, $password, $d_email, $dfgg);
                    $ion_user_id = $this->db->get_where('users', array('email' => $d_email))->row()->id;
                    $this->doctor_model->insertDoctor($data_d);
                    $doctor_user_id = $this->db->get_where('doctor', array('email' => $d_email))->row()->id;
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->doctor_model->updateDoctor($doctor_user_id, $id_info);
                }
            }


            if ($patient == 'add_new') {
                $patient = $patient_user_id;
            }

            if ($doctor == 'add_new') {
                $doctor = $doctor_user_id;
            }




            $amount = array_sum($amount_by_category);
            $sub_total = $amount;
            $discount_type = $this->finance_model->getDiscountType($this->id_organisation);
            if (!empty($doctor)) {
                $all_cat_name = explode(',', $category_name);
                foreach ($all_cat_name as $indiviual_cat_nam) {
                    $indiviual_cat_nam1 = explode('*', $indiviual_cat_nam);
                    $qty = $indiviual_cat_nam1[3];
                    $d_commission = $this->finance_model->getPaymentCategoryById($indiviual_cat_nam1[0], $this->id_organisation)->d_commission;
                    $h_commission = 100 - $d_commission;
                    $hospital_amount_per_unit = $indiviual_cat_nam1[1] * $h_commission / 100;
                    $hospital_amount_by_category[] = $hospital_amount_per_unit * $qty;
                }
                $hospital_amount = array_sum($hospital_amount_by_category);
                if ($discount_type == 'flat') {
                    $flat_discount = $discount;
                    $gross_total = $sub_total - $flat_discount - $charge_mutuelle;
                    $doctor_amount = $amount - $hospital_amount - $flat_discount;
                } else {
                    $flat_discount = $sub_total * ($discount / 100);
                    $gross_total = $sub_total - $flat_discount - $charge_mutuelle;
                    $doctor_amount = $amount - $hospital_amount - $flat_discount;
                }
            } else {
                $doctor_amount = '0';
                if ($discount_type == 'flat') {
                    $flat_discount = $discount;
                    $gross_total = $sub_total - $flat_discount - $charge_mutuelle;
                    $hospital_amount = $gross_total;
                } else {
                    $flat_discount = $amount * ($discount / 100);
                    $gross_total = $sub_total - $flat_discount - $charge_mutuelle;
                    $hospital_amount = $gross_total;
                }
            }
            $data = array();

            if (!empty($patient)) {
                $patient_details = $this->patient_model->getPatientById($patient, $this->id_organisation);
                $patient_name = $patient_details->name . ' ' . $patient_details->last_name;
                $patient_phone = $patient_details->phone;
                $patient_address = $patient_details->address;
                $patient_email = $patient_details->email;
            } else {
                $patient_name = 0;
                $patient_phone = 0;
                $patient_address = 0;
            }

            if (!empty($doctor)) {
                $doctor_details = $this->doctor_model->getDoctorById($doctor);
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = 0;
            }

            if (empty($id)) {

                $data = array(
                    'category_name' => $category_name,
                    'category_name_pro' => $category_name_pro,
                    'patient' => $patient,
                    'date' => $date,
                    'amount' => $sub_total,
                    'doctor' => $doctor, 'service' => $service,
                    'discount' => $discount,
                    'flat_discount' => $flat_discount,
                    'gross_total' => ($etatlight == '1' && $destinatairelight) ? 0 : $gross_total,
                    'hospital_amount' => ($etatlight == '1' && $destinatairelight) ? 0 : $hospital_amount,
                    'doctor_amount' => ($etatlight == '1' && $destinatairelight) ? 0 : $doctor_amount,
                    'user' => $user,
                    'patient_name' => $patient_name,
                    'patient_phone' => $patient_phone,
                    'patient_address' => $patient_address,
                    'doctor_name' => $doctor_name,
                    'date_string' => $date_string, 'id_organisation' => $this->id_organisation,
                    'remarks' => $remarks,
                    'charge_mutuelle' => $charge_mutuelle,
                    'etat' => $etat,
                    'etatlight' => ($etatlight == '1' && $destinatairelight) ? $etatlight : '',
                    'organisation_destinataire' => $destinataire,
                    'organisation_light_origin' => $destinatairelight,
                    'prescripteur' => $doctorInitial,
                    'renseignementClinique' => $renseignementClinique,
                    'purpose'=>$purpose
                );

                $this->finance_model->insertPayment($data);
                $inserted_id = $this->db->insert_id();
                $count_payment = $this->db->get_where('payment', array('id_organisation =' => $this->id_organisation))->num_rows();
                $codeFacture = "ABC";
                if ($etat == '1' || $etatlight == '1') {
// $codeFacture = 'CO-' . $this->code_organisation . '-' . str_pad($count_payment, 4, "0", STR_PAD_LEFT);
                    $codeFacture = 'CO' . $this->code_organisation . '' . $count_payment;
                } else {
// $codeFacture = 'F-' . $this->code_organisation . '-' . str_pad($count_payment, 4, "0", STR_PAD_LEFT);
                    $codeFacture = 'F' . $this->code_organisation . '' . $count_payment;
                }

                $this->finance_model->updatePayment($inserted_id, array('code' => $codeFacture), $this->id_organisation);
//sms
                $set['settings'] = $this->settings_model->getSettings();
                $autosms = $this->sms_model->getAutoSmsByType('payment');
                $message = $autosms->message;
                $to = $patient_phone;
                $name1 = explode(' ', $patient_name);
                if (!isset($name1[1])) {
                    $name1[1] = null;
                }
                $data1 = array(
                    'firstname' => $name1[0],
                    'lastname' => $name1[1],
                    'name' => $patient_name,
                    'amount' => $gross_total,
                );

                if ($autosms->status == 'Active') {
                    $messageprint = $this->parser->parse_string($message, $data1);
                    $data2[] = array($to => $messageprint);
// $this->sms->sendSms($to, $message, $data2);
                }
//end
//email 

                $autoemail = $this->email_model->getAutoEmailByType('payment');
                if ($autoemail->status == 'Active') {
                    $emailSettings = $this->email_model->getEmailSettings();
                    $message1 = $autoemail->message;
                    $messageprint1 = $this->parser->parse_string($message1, $data1);
                    $this->email->from($emailSettings->admin_email);
                    $this->email->to($patient_email);
                    $this->email->subject('Payment confirmation');
                    $this->email->message($messageprint1);
                    $this->email->send();
                }


                if ($amount_received && $etatlight != '1' && !$destinatairelight) {
                    $data1 = array(
                        'date' => $date,
                        'patient' => $patient,
                        'deposited_amount' => $amount_received,
                        'payment_id' => $inserted_id,
                        'amount_received_id' => '',
                        'deposit_type' => $deposit_type,
                        'user' => $user,
                        'id_organisation' => $this->id_organisation
                    );
                    $this->finance_model->insertDeposit($data1);
                }
                $status = 'new';
                $statuspaid = 'unpaid';
                if ($amount_received > 0) {
                    $status = 'pending';
                }
                $rece = $amount_received + $discount + $charge_mutuelle;
// if ($rece >= $gross_total) {
                if ($rece >= $sub_total) {
                    $statuspaid = 'paid';
                }
                if ($etat == '1' || $etatlight == '1') {
                    $status = 'pending';
                }
                $data_payment = array('amount_received' => $amount_received, 'deposit_type' => $deposit_type, 'status' => $status, 'status_paid' => $statuspaid);
                $this->finance_model->updatePayment($inserted_id, $data_payment, $this->id_organisation);

// if($amount_received && $amount_received > 0) {
// if($amount_received) {
                if ($etatlight != '1') {
                    $payment_details = $this->finance_model->getPaymentById($inserted_id);
                    $data1Email = array(
                        'name' => $patient_name,
                        'codeFacture' => $payment_details->code,
                        'company' => $this->nom_organisation,
                        'amount' => number_format($amount_received, 0, '', '.') . " FCFA",
                        'payment_method' => $deposit_type,
                        'montant_total' => number_format($payment_details->gross_total, 0, '', '.') . " FCFA",
                        'total_depots' => number_format($payment_details->amount_received, 0, '', '.') . " FCFA",
                        'restant' => number_format(($payment_details->gross_total - $payment_details->amount_received), 0, '', '.') . " FCFA"
                    );
                    $data1SMS = $data1Email;

// SMS
                    if ($amount_received > 0) {
// echo "<script language=\"javascript\">alert('Payment Made');</script>";
                        $autosms = $this->sms_model->getAutoSmsByType('payment');
                    } else {
// echo "<script language=\"javascript\">alert('No Payment Made');</script>";
                        $autosms = $this->sms_model->getAutoSmsByType('emptyPayment');
                    }
                    $message = $autosms->message;
// $subject = $autosms->name;  
                    $to = $patient_phone;

                    $messageprint = $this->parser->parse_string($message, $data1SMS);
// Temp Special Chars / SMS
                    $toReplace = array("é", "è", "à", "\r\n", "\r", "\n");
                    $replaceBy = array("e", "e", "a", "", "", "");
                    $dataInsert = array(
                        'recipient' => $to,
                        // 'message' => $messageprint,
                        'message' => str_replace($toReplace, $replaceBy, $messageprint),
                        'date' => time(),
                        'user' => $this->ion_auth->get_user_id()
                    );
                    $this->sms_model->insertSms($dataInsert);

// $set['settings'] = $this->settings_model->getSettings();
// $autosms = $this->sms_model->getAutoSmsByType('payment');
// $message = $autosms->message;
// $to = $patient_phone;
// $name1 = explode(' ', $patient_name);
// if (!isset($name1[1])) {
// $name1[1] = null;
// }
// $data1 = array(
// 'firstname' => $name1[0],
// 'lastname' => $name1[1],
// 'name' => $patient_name,
// 'amount' => $gross_total,
// );
// if ($autosms->status == 'Active') {
// $messageprint = $this->parser->parse_string($message, $data1);
// $data2[] = array($to => $messageprint);
// // $this->sms->sendSms($to, $message, $data2);
// }
// // end
// Email
// PRESTATIONS DE SANTÉ | PAIEMENT | {name} | {company}
// Cher {name},
// Vous avez effectué un paiement de {amount} via {payment_method} au profit de {company}.
// Montant total : {montant_total}
// Déjà payé : {total_depots}
// Solde à payer : {restant}
// Merci de votre confiance
// {company} via ecoMed24.

                    if ($amount_received > 0) {
                        $autoemail = $this->email_model->getAutoEmailByType('payment');
                    } else {
                        $autoemail = $this->email_model->getAutoEmailByType('emptyPayment');
                    }

                    $message1 = $autoemail->message;
                    $subject = $this->parser->parse_string($autoemail->name, $data1Email);
                    $messageprint2 = $this->parser->parse_string($message1, $data1Email);
// Temp Special Chars / SMS
// $toReplace = array("é", "è", "à", "\n");
// $replaceBy   = array("e", "e", "a", "");
                    $dataInsertEmail = array(
                        'reciepient' => $patient_email,
                        'subject' => $subject,
                        'message' => $messageprint2,
                        // 'message' => str_replace($toReplace, $replaceBy, $messageprint2),
                        'date' => time(),
                        'user' => $this->ion_auth->get_user_id()
                    );
                    $this->email_model->insertEmail($dataInsertEmail);

// if ($autoemail->status == 'Active') {
// $emailSettings = $this->email_model->getEmailSettings();
// $message1 = $autoemail->message;
// $messageprint1 = $this->parser->parse_string($message1, $data1);
// $this->email->from($emailSettings->admin_email);
// $this->email->to($patient_email);
// $this->email->subject('Payment confirmation');
// $this->email->message($messageprint1);
// $this->email->send();
// }
// }
                }

                $this->session->set_flashdata('feedback', lang('added'));
                if ($etat == '1') {
                    redirect("finance/invoicepro?id=" . $inserted_id);
                } else if ($etatlight == '1') {
                    if ($this->ion_auth->in_group(array('Receptionist', 'Assistant'))) {
                        redirect("finance/payment");
                    }
                    redirect("finance/paymentLabo");
                } else {
                    redirect("finance/invoice?id=" . $inserted_id . "&page=" . $page);
                }

//   }
            } else {
                $deposit_edit_amount = $this->input->post('deposit_edit_amount');
                $deposit_edit_id = $this->input->post('deposit_edit_id');
                if (!empty($deposit_edit_amount)) {
                    $deposited_edit = array_combine($deposit_edit_id, $deposit_edit_amount);
                    foreach ($deposited_edit as $key_deposit => $value_deposit) {
                        $data_deposit = array(
                            'deposited_amount' => $value_deposit
                        );
                        $this->finance_model->updateDeposit($key_deposit, $data_deposit, $this->id_organisation);
                    }
                }


                $a_r_i = $id . '.' . 'gp';
                $deposit_id = $this->db->get_where('patient_deposit', array('amount_received_id' => $a_r_i))->row();
                $status = 'new';
                if ($amount_received > 0) {
                    $status = 'pending';
                }
                $data = array(
                    'category_name' => $category_name,
                    'patient' => $patient,
                    'doctor' => $doctor,
                    'amount' => $sub_total,
                    'discount' => $discount,
                    'flat_discount' => $flat_discount,
                    'gross_total' => $gross_total,
                    'amount_received' => $amount_received,
                    'hospital_amount' => $hospital_amount,
                    'doctor_amount' => $doctor_amount,
                    'user' => $user,
                    'patient_name' => $patient_details->name,
                    'patient_phone' => $patient_details->phone,
                    'patient_address' => $patient_details->address,
                    'doctor_name' => $doctor_details->name,
                    'remarks' => $remarks, 'status' => $status,
                    'prescripteur' => $doctorInitial
                );

                if (!empty($deposit_id->id)) {
                    $data1 = array(
                        'date' => $date,
                        'patient' => $patient,
                        'payment_id' => $id,
                        'deposited_amount' => $amount_received,
                        'user' => $user
                    );
                    $this->finance_model->updateDeposit($deposit_id->id, $data1, $this->id_organisation);
                } else {
                    $data1 = array(
                        'date' => $date,
                        'patient' => $patient,
                        'payment_id' => $id,
                        'deposited_amount' => $amount_received,
                        'amount_received_id' => $id . '.' . 'gp',
                        'user' => $user,
                        'id_organisation' => $this->id_organisation
                    );
                    $this->finance_model->insertDeposit($data1);
                }
                $this->finance_model->updatePayment($id, $data, $this->id_organisation);

// if($amount_received && $amount_received > 0) {
// if($amount_received) {

                $payment_details = $this->finance_model->getPaymentById($inserted_id);
                $data1Email = array(
                    'name' => $patient_name,
                    'company' => $this->nom_organisation,
                    'amount' => number_format($amount_received, 0, '', '.') . " FCFA",
                    'payment_method' => $deposit_type,
                    'montant_total' => number_format($payment_details->gross_total, 0, '', '.') . " FCFA",
                    'total_depots' => number_format($payment_details->amount_received, 0, '', '.') . " FCFA",
                    'restant' => number_format(($payment_details->gross_total - $payment_details->amount_received), 0, '', '.') . " FCFA"
                );
                $data1SMS = $data1Email;

// SMS
                if ($amount_received > 0) {
                    $autosms = $this->sms_model->getAutoSmsByType('payment');
                } else {
                    $autosms = $this->sms_model->getAutoSmsByType('emptyPayment');
                }
                $message = $autosms->message;
// $subject = $autosms->name;  
                $to = $patient_phone;

                $messageprint = $this->parser->parse_string($message, $data1SMS);
// Temp Special Chars / SMS
                $toReplace = array("é", "è", "à", "\r\n", "\r", "\n");
                $replaceBy = array("e", "e", "a", "", "", "");
                $dataInsert = array(
                    'recipient' => $to,
                    'message' => $messageprint,
                    'date' => time(),
                    'user' => $this->ion_auth->get_user_id()
                );
                $this->sms_model->insertSms($dataInsert);

// $set['settings'] = $this->settings_model->getSettings();
// $autosms = $this->sms_model->getAutoSmsByType('payment');
// $message = $autosms->message;
// $to = $patient_phone;
// $name1 = explode(' ', $patient_name);
// if (!isset($name1[1])) {
// $name1[1] = null;
// }
// $data1 = array(
// 'firstname' => $name1[0],
// 'lastname' => $name1[1],
// 'name' => $patient_name,
// 'amount' => $gross_total,
// );
// if ($autosms->status == 'Active') {
// $messageprint = $this->parser->parse_string($message, $data1);
// $data2[] = array($to => $messageprint);
// // $this->sms->sendSms($to, $message, $data2);
// }
// // end
// Email
// PRESTATIONS DE SANTÉ | PAIEMENT | {name} | {company}
// Cher {name},
// Vous avez effectué un paiement de {amount} via {payment_method} au profit de {company}.
// Montant total : {montant_total}
// Déjà payé : {total_depots}
// Solde à payer : {restant}
// Merci de votre confiance
// {company} via ecoMed24.

                $autoemail = $this->email_model->getAutoEmailByType('payment');
                $message1 = $autoemail->message;
                $subject = $this->parser->parse_string($autoemail->name, $data1Email);
                $messageprint2 = $this->parser->parse_string($message1, $data1Email);
                $dataInsertEmail = array(
                    'reciepient' => $patient_email,
                    'subject' => $subject,
                    'message' => $messageprint2,
                    'date' => time(),
                    'user' => $this->ion_auth->get_user_id()
                );
                $this->email_model->insertEmail($dataInsertEmail);

// if ($autoemail->status == 'Active') {
// $emailSettings = $this->email_model->getEmailSettings();
// $message1 = $autoemail->message;
// $messageprint1 = $this->parser->parse_string($message1, $data1);
// $this->email->from($emailSettings->admin_email);
// $this->email->to($patient_email);
// $this->email->subject('Payment confirmation');
// $this->email->message($messageprint1);
// $this->email->send();
// }
// }

                $this->session->set_flashdata('feedback', lang('updated'));
                if ($etat == '1') {
                    redirect("finance/invoicepro?id=" . "$id");
                } else {
                    redirect("finance/invoice?id=" . $id . "&page=" . $page);
                }
            }
        }
    }

    public function addPaymentConsultation() {
        $id = $this->input->post('id');
        $item_selected = array();
        $quantity = array();
        $category_selected = array();
// $amount_by_category = $this->input->post('category_amount');
        $category_selected = $this->input->post('category_name');
        $item_selected = $this->input->post('category_id');
        $quantity = $this->input->post('quantity');
        $remarks = $this->input->post('remarks');
        $remarksId = $this->input->post('remarksId');
        $remarksType = $this->input->post('remarksType');
        $doctorInitial = $this->input->post('doctor');
        $nameHeader = $this->input->post('nameHeader');
        $consultation = $this->input->post('consultation');
        $renseignementClinique = $this->input->post('renseignementClinique');
        $charge_mutuelle = $this->input->post('charge_mutuelle') ? $this->input->post('charge_mutuelle') : 0;
// $service = $this->input->post('service'); 
        $id_service_specialite_organisation = $this->input->post('service'); // NEW
        $service = '';

        if (!empty($id_service_specialite_organisation)) {
            $service = $this->db->query("select id_service from setting_service_specialite_organisation where id =" . $id_service_specialite_organisation)->row()->id_service; // NEW
        }
// if(!empty($doctorSelect)){
//     $doctorChoisi = $doctorSelect;
//     var_dump($doctorChoisi.' '.$doctorInitial);
//     exit();
// }
// if(empty($doctorSelect)){
//     $doctorChoisi = $doctorSelect;
//     var_dump($doctorChoisi.' '.$doctorInitial);
//     exit();
// }
        $etat = $this->input->post('choicepartenaire');
        $etatlight = $this->input->post('choicepartenaire_light');
        $destinataire = $this->input->post('partenaire');
        $destinatairelight = $this->input->post('lightpartenaire');
        $amount_received = $this->input->post('amount_received');
        $page = $this->input->post('page');

        $amount_received = !empty($amount_received) ? $amount_received : 0;
        if (empty($item_selected)) {
            $this->session->set_flashdata('feedback', lang('select_an_item'));
            redirect('finance/addPaymentView');
        } else {
            $item_quantity_array = array();
            $item_quantity_array = array_combine($item_selected, $quantity);
        }
        $cat_and_price = array();
        $cat_and_price_pro = array();
        $category_name_pro = '';
        if (!empty($item_quantity_array)) {
            foreach ($item_quantity_array as $key => $value) {
// $current_item = $this->finance_model->getPaymentCategoryById($key, $this->id_organisation);

                if ($etat == '1' && $destinataire) {
                    $current_item = $this->db->query("select payment_category_organisation.tarif_public, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm, payment_category_organisation.tarif_professionnel from payment_category_organisation where id_presta =" . $key . " and id_organisation=" . $destinataire)->row();
                    $buff_org = $destinataire;
                } else if ($etatlight == '1' && $destinatairelight) {
                    $current_item = $this->db->query("select payment_category_organisation.tarif_public, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm, payment_category_organisation.tarif_professionnel from payment_category_organisation where id_presta =" . $key . " and id_organisation=" . $this->id_organisation)->row();
                    $buff_org = $destinatairelight;
                    $destinataire = $destinatairelight;
                } else {
                    $current_item = $this->db->query("select payment_category_organisation.tarif_public, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm from payment_category_organisation where id_presta =" . $key . " and id_organisation=" . $this->id_organisation)->row();
                    $buff_org = $this->id_organisation;
                }

// if (!empty($remarks) && $etat) {


                if (!empty($remarks) && !$etatlight) {
// Check si prestation couverte dans partenariat
                    $id_partenariat_buff = $this->db->query("select id from partenariat_sante_assurance where id_organisation_sante=" . $buff_org . " and id_organisation_assurance=" . $remarksId)->row()->id;
                    $est_couverte = $this->db->query("select (CASE WHEN sante_assurance_prestation.est_couverte IS NULL THEN '1' ELSE '0' END) as est_couverte from payment_category left join sante_assurance_prestation on sante_assurance_prestation.id_partenariat_sante_assurance = " . $id_partenariat_buff . " AND sante_assurance_prestation.id_payment_category = " . $key)->row()->est_couverte;

                    if ($est_couverte) {
                        if ($remarksType == "IPM") {
                            $category_price = intval($current_item->tarif_ipm);
                        } else if ($remarksType == "Assurance") {
                            $category_price = intval($current_item->tarif_assurance);
                        }
                    } else {
                        $category_price = intval($current_item->tarif_public);
                    }
                } else {
                    $category_price = intval($current_item->tarif_public);
                }
                /*  } else {
                  $category_price = intval($current_item->tarif_public);
                  } */
// $category_type = $current_item->type;
                $category_type = "";
                $qty = $value;
                if ($etat == '1' || $etatlight == '1' || $amount_received > 0) {
                    $cat_and_price[] = $key . '*' . $category_price . '*' . $service . '*' . $qty . '*1';
                    if (isset($current_item->tarif_professionnel)) {
                        $cat_and_price_pro[] = $key . '*' . intval($current_item->tarif_professionnel) . '*' . $service . '*' . $qty . '*1';
                    }
                } else {
                    $cat_and_price[] = $key . '*' . $category_price . '*' . $service . '*' . $qty . '*7';
                }

                $amount_by_category[] = $category_price * $qty;
            }
            $category_name = implode(',', $cat_and_price);
            if ($cat_and_price_pro) {
                $category_name_pro = implode(',', $cat_and_price_pro);
            }
        } else {
            $this->session->set_flashdata('feedback', lang('attend_the_required_fields'));
            redirect('finance/addPaymentView');
        }

        $patient = $this->input->post('patient');

        $p_name = $this->input->post('p_name');
        $last_p_name = $this->input->post('last_p_name');
        $p_email = $this->input->post('p_email');
        if (empty($p_email)) {
            $p_email = $p_name . '-' . rand(1, 1000) . '-' . $p_name . '-' . rand(1, 1000) . '@example.com';
        }
        if (!empty($p_name)) {
            $password = $p_name . '-' . rand(1, 100000000);
        }
        $p_phone = $this->input->post('p_phone');
        $p_age = $this->input->post('p_age');
        $p_gender = $this->input->post('p_gender');
        $add_date = date('m/d/y HH:i');

        $patient_id = rand(10000, 1000000);

        $d_name = $this->input->post('d_name');
        $d_email = $this->input->post('d_email');
        if (empty($d_email)) {
            $d_email = $d_name . '-' . rand(1, 1000) . '-' . $d_name . '-' . rand(1, 1000) . '@example.com';
        }
        if (!empty($d_name)) {
            $password = $d_name . '-' . rand(1, 100000000);
        }
        $d_phone = $this->input->post('d_phone');

        $doctor = $this->input->post('doctor');
        $date = time();
        $date_string = date('d/m/Y H:i', $date);
        $discount = $this->input->post('discount');
        if (empty($discount)) {
            $discount = 0;
        }

        $deposit_type = $this->input->post('deposit_type');
        $user = $this->ion_auth->get_user_id();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

// Validating Category Field
// $this->form_validation->set_rules('category_amount[]', 'Category', 'min_length[1]|max_length[100]');
// Validating Price Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Price Field
        $this->form_validation->set_rules('discount', 'Discount', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            redirect('finance/addPaymentView');
        } else {
            if (!empty($p_name)) {

                $data_p = array(
                    'patient_id' => $patient_id,
                    'name' => $p_name,
                    'last_name' => $last_p_name,
                    'email' => $p_email,
                    'phone' => $p_phone,
                    'sex' => $p_gender,
                    'age' => $p_age,
                    'add_date' => $add_date,
                    'how_added' => 'from_pos'
                );
                $username = $this->input->post('p_name');
// Adding New Patient
                if ($this->ion_auth->email_check($p_email)) {
                    $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                } else {
                    $dfg = 5;
                    $this->ion_auth->register($username, $password, $p_email, $dfg);
                    $ion_user_id = $this->db->get_where('users', array('email' => $p_email))->row()->id;
                    $last_patient_user_id = $this->patient_model->insertPatient($data_p);
                    $patient_user_id = $last_patient_user_id; //$this->db->get_where('patient', array('email' => $p_email))->row()->id;

                    $count_patient = $this->db->get_where('patient', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
// $patient_id = 'P-' . $this->code_organisation . '-' . str_pad($count_patient, 4, "0", STR_PAD_LEFT);
                    $patient_id = 'P' . $this->code_organisation . '' . $count_patient;
                    $id_info = array('ion_user_id' => $ion_user_id, 'patient_id' => $patient_id);
                    $this->patient_model->updatePatient($patient_user_id, $id_info, $this->id_organisation);
                }
//    }
            }

            if (!empty($d_name)) {

                $data_d = array(
                    'name' => $d_name,
                    'email' => $d_email,
                    'phone' => $d_phone,
                );
                $username = $this->input->post('d_name');
// Adding New Patient
                if ($this->ion_auth->email_check($d_email)) {
                    $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                } else {
                    $dfgg = 4;
                    $this->ion_auth->register($username, $password, $d_email, $dfgg);
                    $ion_user_id = $this->db->get_where('users', array('email' => $d_email))->row()->id;
                    $this->doctor_model->insertDoctor($data_d);
                    $doctor_user_id = $this->db->get_where('doctor', array('email' => $d_email))->row()->id;
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->doctor_model->updateDoctor($doctor_user_id, $id_info);
                }
            }


            if ($patient == 'add_new') {
                $patient = $patient_user_id;
            }

            if ($doctor == 'add_new') {
                $doctor = $doctor_user_id;
            }




            $amount = array_sum($amount_by_category);
            $sub_total = $amount;
            $discount_type = $this->finance_model->getDiscountType($this->id_organisation);
// if (!empty($doctor)) {
//     $all_cat_name = explode(',', $category_name);
//     // foreach ($all_cat_name as $indiviual_cat_nam) {
//     //     $indiviual_cat_nam1 = explode('*', $indiviual_cat_nam);
//     //     $qty = $indiviual_cat_nam1[3];
//     //     $d_commission = $this->finance_model->getPaymentCategoryById($indiviual_cat_nam1[0], $this->id_organisation)->d_commission;
//     //     $h_commission = 100 - $d_commission;
//     //     $hospital_amount_per_unit = $indiviual_cat_nam1[1] * $h_commission / 100;
//     //     $hospital_amount_by_category[] = $hospital_amount_per_unit * $qty;
//     // }
//     // $hospital_amount = array_sum($hospital_amount_by_category);
//     if ($discount_type == 'flat') {
//         $flat_discount = $discount;
//         $gross_total = $sub_total - $flat_discount - $charge_mutuelle;
//         $doctor_amount = $amount - $hospital_amount - $flat_discount;
//     } else {
//         $flat_discount = $sub_total * ($discount / 100);
//         $gross_total = $sub_total - $flat_discount - $charge_mutuelle;
//         $doctor_amount = $amount - $hospital_amount - $flat_discount;
//     }
// } else {
            $doctor_amount = '0';
            if ($discount_type == 'flat') {
                $flat_discount = $discount;
                $gross_total = $sub_total - $flat_discount - $charge_mutuelle;
                $hospital_amount = $gross_total;
            } else {
                $flat_discount = $amount * ($discount / 100);
                $gross_total = $sub_total - $flat_discount - $charge_mutuelle;
                $hospital_amount = $gross_total;
            }

            $data = array();

            if (!empty($patient)) {
                $patient_details = $this->patient_model->getPatientById($patient, $this->id_organisation);
                $patient_name = $patient_details->name . ' ' . $patient_details->last_name;
                $patient_phone = $patient_details->phone;
                $patient_address = $patient_details->address;
                $patient_email = $patient_details->email;
            } else {
                $patient_name = 0;
                $patient_phone = 0;
                $patient_address = 0;
            }

            if (!empty($doctor)) {
                $doctor_details = $this->doctor_model->getDoctorUsersById($doctor);
                $doctor_name = 'DR ' . $doctor_details->first_name . ' ' . $doctor_details->last_name;
            } else {
                $doctor_name = 0;
            }

            if (empty($id)) {

                $data = array(
                    'category_name' => $category_name,
                    'category_name_pro' => $category_name_pro,
                    'patient' => $patient,
                    'date' => $date,
                    'amount' => $sub_total,
                    'doctor' => $doctor, 'service' => $service,
                    'discount' => $discount,
                    'flat_discount' => $flat_discount,
                    'gross_total' => ($etatlight == '1' && $destinatairelight) ? 0 : $gross_total,
                    'hospital_amount' => ($etatlight == '1' && $destinatairelight) ? 0 : $hospital_amount,
                    'doctor_amount' => ($etatlight == '1' && $destinatairelight) ? 0 : $doctor_amount,
                    'user' => $user,
                    'patient_name' => $patient_name,
                    'patient_phone' => $patient_phone,
                    'patient_address' => $patient_address,
                    'doctor_name' => $doctor_name,
                    'date_string' => $date_string, 'id_organisation' => $this->id_organisation,
                    'remarks' => $remarks,
                    'charge_mutuelle' => $charge_mutuelle,
                    'renseignementClinique' => $renseignementClinique,
                    'etat' => $etat,
                    'etatlight' => ($etatlight == '1' && $destinatairelight) ? $etatlight : '',
                    'organisation_destinataire' => $destinataire,
                    'organisation_light_origin' => $destinatairelight,
                    'prescripteur' => $doctorInitial
                );

                $this->finance_model->insertPayment($data);
                $inserted_id = $this->db->insert_id();
                $count_payment = $this->db->get_where('payment', array('id_organisation =' => $this->id_organisation))->num_rows();
                $codeFacture = "ABC";
                if ($etat == '1' || $etatlight == '1') {
// $codeFacture = 'CO-' . $this->code_organisation . '-' . str_pad($count_payment, 4, "0", STR_PAD_LEFT);
                    $codeFacture = 'CO' . $this->code_organisation . '' . $count_payment;
                } else {
// $codeFacture = 'F-' . $this->code_organisation . '-' . str_pad($count_payment, 4, "0", STR_PAD_LEFT);
                    $codeFacture = 'F' . $this->code_organisation . '' . $count_payment;
                }

                $this->finance_model->updatePayment($inserted_id, array('code' => $codeFacture), $this->id_organisation);
//sms
                $set['settings'] = $this->settings_model->getSettings();
                $autosms = $this->sms_model->getAutoSmsByType('payment');
                $message = $autosms->message;
                $to = $patient_phone;
                $name1 = explode(' ', $patient_name);
                if (!isset($name1[1])) {
                    $name1[1] = null;
                }
                $data1 = array(
                    'firstname' => $name1[0],
                    'lastname' => $name1[1],
                    'name' => $patient_name,
                    'amount' => $gross_total,
                );

                if ($autosms->status == 'Active') {
                    $messageprint = $this->parser->parse_string($message, $data1);
                    $data2[] = array($to => $messageprint);
// $this->sms->sendSms($to, $message, $data2);
                }
//end
//email 
// $autoemail = $this->email_model->getAutoEmailByType('payment');
// if ($autoemail->status == 'Active') {
//     $emailSettings = $this->email_model->getEmailSettings();
//     $message1 = $autoemail->message;
//     $messageprint1 = $this->parser->parse_string($message1, $data1);
//     $this->email->from($emailSettings->admin_email);
//     $this->email->to($patient_email);
//     $this->email->subject('Payment confirmation');
//     $this->email->message($messageprint1);
//     $this->email->send();
// }


                if ($amount_received && $etatlight != '1' && !$destinatairelight) {
                    $data1 = array(
                        'date' => $date,
                        'patient' => $patient,
                        'deposited_amount' => $amount_received,
                        'payment_id' => $inserted_id,
                        'amount_received_id' => '',
                        'deposit_type' => $deposit_type,
                        'user' => $user,
                        'id_organisation' => $this->id_organisation
                    );
                    $this->finance_model->insertDeposit($data1);
                }
                $status = 'demander';
                $statuspaid = 'demander';
                $data_payment = array('amount_received' => $amount_received, 'deposit_type' => $deposit_type, 'status' => $status, 'status_paid' => $statuspaid);
                $this->finance_model->updatePayment($inserted_id, $data_payment, $this->id_organisation);

// GENERER RAPPORT CONSULTATION INO

                $payment = $inserted_id;

                $origins = $this->partenaire_model->payButton($payment, $this->id_organisation);

                $patientOrigins = $origins->patient;
                $tabuser = $this->home_model->getUserById($origins->user);

                $users = $this->home_model->getUserById($doctor);

                $data['UsersValider'] = $users;
                $patientID = $this->patient_model->getPatientById($patientOrigins);
                $doctorID = $this->home_model->getUserById($doctor);

// IMPORT FOREACT

                if (!empty($origins->category_name)) {
                    $category_name = $origins->category_name;
                    $category_name1 = explode(',', $category_name);
                    $i = 0;
                    $cat = array();
                    foreach ($category_name1 as $key => $category_name2) {
                        $category_name3 = explode('*', $category_name2);
                        if ($category_name3[3] > 0 && $category_name3[1]) {
                            $value = $this->finance_model->editCategoryServiceBySpe($category_name3[0]);
                            $cat[$value->id_spe][$key] = $value;
                        }
                    }

//ksort($cat, SORT_NUMERIC);
                    $data['cat'] = $cat;
                    $structure = array();
                    foreach ($category_name1 as $key => $category_name2) {
                        $category_name3 = explode('*', $category_name2);
                        $value = $this->finance_model->getPrestationId($category_name3[0]);
                        $id_spec = $value->id_spe;
                        $value1 = current(array_filter($structure, function ($element) use ($id_spec) {
                                    return $element->idspe == $id_spec;
                                }));
                        if (empty($value1)) {
                            $value1 = $this->finance_model->getSpecialiteId($value->id_spe);
                            $value1->prestations = array();
                            array_push($structure, $value1);
                        }
                        $value->resultats = $this->finance_model->getParamPrestation($payment, $value->id);
                        array_push($value1->prestations, $value);
                    }
                }

                if (empty($origins->entete)) {
                    $origins->entete = 'uploads/entetePartenaires/default.png';
                }
                $data['structure'] = $structure;
                $html_patient = '<!DOCTYPE html>';
                $html_patient = '<html lang="fr">';
                $html_patient .= ' <head>';
                $html_patient .= '<meta charset="utf-8" />';
                $html_patient .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
                $html_patient .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
                $html_patient .= '<link href="" rel="icon" />';
                $html_patient .= "<title>Résultats d'Analyses</title>";
                $html_patient .= '<meta name="author" content="">';
                $html_patient .= '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" type="text/css">';
                $html_patient .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'common/css/bootstrap.min.css"/>';
                $html_patient .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'common/assets/fontawesome5pro/css/all.min.css"/>';
                $html_patient .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'common/css/stylesheet.css"/>';
                $html_patient .= '</head>';
                $html_patient .= '<body>';
                $html_patient .= '<div class="container-fluid invoice-container" id="datalabPrint">';

                $html_patient .= '  <header>';
                $html_patient .= ' <div class="row">';
                $html_patient .= '    <div class="col-sm-7 text-center text-sm-left mb-3 mb-sm-0" style="float:left;">';
                if ($origins->path_logo) {
                    $html_patient .= '                      <img  id="logo" src="' . $origins->entete . '" style="max-width:500px;max-height:200px;float:left;"/>';
                }
                $html_patient .= '    </div>';
                $html_patient .= '  <hr>';
                $html_patient .= ' </header>';

                $html_patient .= '  <main>';

// $html_patient .= ' <div class="row">';
// $html_patient .= '    <div class="col-sm-6 text-sm-right"> </div>';
// $html_patient .= '  </div>';


                $html_patient .= '  <hr style="border-top: 2px solid #0D4D99;">';
                $html_patient .= '  <div class="row">';
                $html_patient .= '   <div class="col-sm-6 text-sm-right order-sm-1" style="float:left;">';

                $html_patient2 = '      <address>';
                $html_patient2 .= '     <strong>' . lang('patient') . ': </strong><span class="prenomNom">' . $patientID->name . ' ' . $patientID->last_name . '</span><br />';
                $html_patient2 .= '     <strong>' . lang('phone') . ': </strong>' . $patientID->phone . ' <br />';
                $html_patient2 .= '     <strong> Age :  </strong>' . $patientID->age . ' An(s) <br />';
                $html_patient2 .= '	   <strong>' . lang('gender') . ' : </strong>' . $patientID->sex . ' <br />';
                $html_patient2 .= '      </address>';
                $html_patient2 .= '    </div>';
                $html_patient2 .= '    <div class="col-sm-6 order-sm-0" style="float:left;">';
                $html_patient2 .= '      <address>';

                $html_patient2 .= '      <strong>' . lang('date') . ' de prescription : </strong>' . date('d/m/Y', $origins->date) . ' <br />';
                $html_patient2 .= '     <strong>' . lang('numorde') . ' : </strong>' . $origins->code . ' <br />';
                $html_patient2 .= '      <strong> Médecin Prescripteur </strong> DR :' . $doctorID->first_name . ' ' . $doctorID->last_name . ' <br />';
                $html_patient2 .= '      </address>';

                $html_patient3 = '   </div>';
                $html_patient3 .= '  </div>  ';

                $html_patient3 .= ' <div class="col-md-12">';
                $html_patient3 .= '     <h4 class="text-center" style="font-weight: bold; margin-top: 20px; text-transform: uppercase;">';
                $html_patient3 .= '' . $nameHeader . '';
                $html_patient3 .= '   </h4>';
                $html_patient3 .= '  </div>';

                $html_patient3 .= ' <div class="card">';
                $html_patient3 .= '   <div class="card-header px-2 py-0">';
                $html_patient3 .= '     <table class="table mb-0">';
                $html_patient3 .= '        <thead>';
                $html_patient3 .= '          <tr>';
                $html_patient3 .= '            <td class="border-0" style="width:35%"><strong>EXAMEN DEMANDÉ</strong></td>';
                $html_patient3 .= '			<td class="text-center border-0" style="width:18%;margin-left:5%"><strong></strong></td>';
                $html_patient3 .= '            <td class="text-center border-0" style="width:18%"><strong></strong></td>';
                $html_patient3 .= '			<td class="text-center border-0" style="width:19%"><strong></strong></td>';

                $html_patient3 .= '          </tr>';
                $html_patient3 .= '       </thead>';
                $html_patient3 .= '     </table>';
                $html_patient3 .= '   </div>';
                $html_patient3 .= '   <div class="card-body px-2">';
                $html_patient3 .= '     <div class="table-responsive">';
                $html_patient3 .= '       <table class="table">';

                $html_patient3 .= '         <tbody>';

                if (!empty($origins->category_name)) {
                    $category_name = $origins->category_name;
                    $category_name1 = explode(',', $category_name);
                    $i = 0;
                    $cat = array();
                    foreach ($category_name1 as $key => $category_name2) {
                        $category_name3 = explode('*', $category_name2);
                        if ($category_name3[3] > 0 && $category_name3[1]) {
                            $value = $this->finance_model->editCategoryServiceBySpe($category_name3[0]);
                            $cat[$value->id_spe][$key] = $value;
                        }
                    }
                }

                if (!empty($origins->category_name)) {

                    foreach ($cat as $key => $category_name) {
                        $category_nameid = current($category_name);
                        if ($category_nameid) {
                            $valuep = $category_nameid->name_specialite;
                            $html_patient3 .= '       <tr>';
                            $html_patient3 .= '         <td class="text-center"  colspan="4" style="width:40%;border:1px dotted #9e9e9e;    text-align: center;"><strong>' . $valuep . '</strong></td>';
                            $html_patient3 .= '       </tr>';
                        }
                        foreach ($category_name as $category_name2) {
// var_dump($category_name2);


                            if ($category_name2) {

                                $html_patient3 .= '       <tr>';
                                $html_patient3 .= '         <td class="" style="width:40%"><strong>' . $category_name2->prestation . '</strong></td>';
                                $html_patient3 .= '  <td class="text-center" style="width:20%"></td>';
                                $html_patient3 .= '     <td class="text-center" style="width:20%"></td>';
                                $html_patient3 .= '      <td class="text-center" style="width:20%"></td>';
                                $html_patient3 .= '       </tr>';

                                $tabbs = $this->finance_model->existResultatsPara($payment, intval($category_name2->id));
                                foreach ($tabbs as $tabb) {


                                    $resultat = $tabb->resultats;
                                    $para = $tabb->id_para;
                                    $presta = $tabb->id_presta;
                                    $tab = $this->finance_model->parametreValue($para);
                                    $unite = $tab->unite ? $tab->unite : '';
                                    $valeurs = $tab->valeurs ? $tab->valeurs : '';
                                    $modele = '';
                                    if ($presta && $this->id_organisation) {
                                        $modeleTab = $this->home_model->getModeleByLaboPaiement($presta, $this->id_organisation);
                                        if (!empty($modeleTab)) {
                                            $modele = $modeleTab->is_modele;
                                        }
                                    }
                                    if ($modele != 0) {
                                        $html_patient3 .= '       <tr>';
                                        $html_patient3 .= '         <td class="" style="width:40%">' . $tab->nom_parametre . '</td>';
                                        $html_patient3 .= '  <td class="text-center" style="width:60%">' . $resultat . ' </td>';
                                        $html_patient3 .= '     <td class="text-center"></td>';
                                        $html_patient3 .= '      <td class="text-center"></td>';
                                        $html_patient3 .= '      </tr>';
                                    } else {
                                        $html_patient3 .= '       <tr>';
                                        $html_patient3 .= '         <td class="" style="width:40%">' . $tab->nom_parametre . '</td>';
                                        $html_patient3 .= '  <td class="text-center" style="width:20%">' . $resultat . ' </td>';
                                        $html_patient3 .= '     <td class="text-center" style="width:20%">' . $unite . ' </td>';
                                        $html_patient3 .= '      <td class="text-center" style="width:20%,font-style: italic;">' . $valeurs . '</td>';
                                        $html_patient3 .= '      </tr>';
                                    }
                                }
                            }
                        }
                    }
                }

                $html_patient3 .= '         </tbody>';
                $html_patient3 .= '       </table>';
                $html_patient3 .= '      </div>';
                $html_patient3 .= '   </div>';
                $html_patient3 .= '  </div>';
                $html_patient3 .= '  </main>';
                $html_patient3 .= '  <br/>';
                $html_patient3 .= '</div>';
                $html_patient3 .= ' <footer class="text-center mt-4">';
                $html_patient3 .= '  <p class=""><strong></strong> ';
                $html_patient3 .= $origins->nom . ' ' . $origins->adresse . ' ' . $origins->region . ' , ' . $origins->pays . ' ';
                if (!empty($origins->number_fixe)) {
                    $html_patient3 .= ' Tel:' . $origins->number_fixe . ' ';
                }
                if (!empty($origins->email)) {
                    $html_patient3 .= ' Mail:' . $origins->email;
                }
                $html_patient3 .= '.</p>';

                $html_patient3 .= ' </footer>';
                $html_patient3 .= '</body>';
                $html_patient3 .= '</html>';

                $html1 = $html_patient . $html_patient2 . $html_patient3;
//   $html2 = $html_patient . $html_patient2_1 . $html_patient3;

                $dataLab = array('report' => $html1,
                    'patient' => $patientOrigins,
                    'doctor' => $doctor,
                    'payment' => $payment,
                    'id_organisation' => $this->id_organisation,
                    'date' => $date,
                    'user' => $user,
                    'patient_name' => $patient_name,
                    'patient_phone' => $patient_phone,
                    'patient_address' => $patient_address,
                    'doctor_name' => '',
                    'date_string' => $date_string,
                    'consultation' => $consultation
                );
//  var_dump($dataLab);
//  exit();
                $this->lab_model->insertLab($dataLab);
                $inserted_id = $this->db->insert_id();
                $count_rapports = $this->db->get_where('lab', array('id_organisation =' => $this->id_organisation))->num_rows();
// $codeRapport = 'RA-' . $this->code_organisation . '-' . str_pad($count_rapports, 4, "0", STR_PAD_LEFT);
                $codeRapport = 'RA' . $this->code_organisation . '' . $count_rapports;
                $this->lab_model->updateLab($inserted_id, array("code" => $codeRapport));

// var_dump($data);
// exit();
// $data['UsersValider'] = $users;
// FIN GENERER RAPPORT CONSULTATION
// if($amount_received && $amount_received > 0) {
// if($amount_received) {
                if ($etatlight != '1') {
                    $payment_details = $this->finance_model->getPaymentById($inserted_id);
                    $data1Email = array(
                        'name' => $patient_name,
                        'codeFacture' => $payment_details->code,
                        'company' => $this->nom_organisation,
                        'amount' => number_format($amount_received, 0, '', '.') . " FCFA",
                        'payment_method' => $deposit_type,
                        'montant_total' => number_format($payment_details->gross_total, 0, '', '.') . " FCFA",
                        'total_depots' => number_format($payment_details->amount_received, 0, '', '.') . " FCFA",
                        'restant' => number_format(($payment_details->gross_total - $payment_details->amount_received), 0, '', '.') . " FCFA"
                    );
                    $data1SMS = $data1Email;

// SMS
                    if ($amount_received > 0) {
// echo "<script language=\"javascript\">alert('Payment Made');</script>";
                        $autosms = $this->sms_model->getAutoSmsByType('payment');
                    } else {
// echo "<script language=\"javascript\">alert('No Payment Made');</script>";
                        $autosms = $this->sms_model->getAutoSmsByType('emptyPayment');
                    }
                    $message = $autosms->message;
// $subject = $autosms->name;  
                    $to = $patient_phone;

                    $messageprint = $this->parser->parse_string($message, $data1SMS);
// Temp Special Chars / SMS
                    $toReplace = array("é", "è", "à", "\r\n", "\r", "\n");
                    $replaceBy = array("e", "e", "a", "", "", "");
                    $dataInsert = array(
                        'recipient' => $to,
                        // 'message' => $messageprint,
                        'message' => str_replace($toReplace, $replaceBy, $messageprint),
                        'date' => time(),
                        'user' => $this->ion_auth->get_user_id()
                    );
                    $this->sms_model->insertSms($dataInsert);

// $set['settings'] = $this->settings_model->getSettings();
// $autosms = $this->sms_model->getAutoSmsByType('payment');
// $message = $autosms->message;
// $to = $patient_phone;
// $name1 = explode(' ', $patient_name);
// if (!isset($name1[1])) {
// $name1[1] = null;
// }
// $data1 = array(
// 'firstname' => $name1[0],
// 'lastname' => $name1[1],
// 'name' => $patient_name,
// 'amount' => $gross_total,
// );
// if ($autosms->status == 'Active') {
// $messageprint = $this->parser->parse_string($message, $data1);
// $data2[] = array($to => $messageprint);
// // $this->sms->sendSms($to, $message, $data2);
// }
// // end
// Email
// PRESTATIONS DE SANTÉ | PAIEMENT | {name} | {company}
// Cher {name},
// Vous avez effectué un paiement de {amount} via {payment_method} au profit de {company}.
// Montant total : {montant_total}
// Déjà payé : {total_depots}
// Solde à payer : {restant}
// Merci de votre confiance
// {company} via ecoMed24.

                    if ($amount_received > 0) {
                        $autoemail = $this->email_model->getAutoEmailByType('payment');
                    } else {
                        $autoemail = $this->email_model->getAutoEmailByType('emptyPayment');
                    }

                    $message1 = $autoemail->message;
                    $subject = $this->parser->parse_string($autoemail->name, $data1Email);
                    $messageprint2 = $this->parser->parse_string($message1, $data1Email);
// Temp Special Chars / SMS
// $toReplace = array("é", "è", "à", "\n");
// $replaceBy   = array("e", "e", "a", "");
                    $dataInsertEmail = array(
                        'reciepient' => $patient_email,
                        'subject' => $subject,
                        'message' => $messageprint2,
                        // 'message' => str_replace($toReplace, $replaceBy, $messageprint2),
                        'date' => time(),
                        'user' => $this->ion_auth->get_user_id()
                    );
                    $this->email_model->insertEmail($dataInsertEmail);
                }







                $this->session->set_flashdata('feedback', lang('added'));
                if ($etat == '1') {
                    redirect("finance/invoicepro?id=" . $inserted_id);
                } else if ($etatlight == '1') {
                    if ($this->ion_auth->in_group(array('Receptionist', 'Assistant'))) {
                        redirect("finance/payment");
                    }
                    redirect("finance/paymentLabo");
                } else {
                    redirect("patient/medicalHistory?id=" . $patient . "&type=consultation");
                }

//   }
            } else {
                $deposit_edit_amount = $this->input->post('deposit_edit_amount');
                $deposit_edit_id = $this->input->post('deposit_edit_id');
                if (!empty($deposit_edit_amount)) {
                    $deposited_edit = array_combine($deposit_edit_id, $deposit_edit_amount);
                    foreach ($deposited_edit as $key_deposit => $value_deposit) {
                        $data_deposit = array(
                            'deposited_amount' => $value_deposit
                        );
                        $this->finance_model->updateDeposit($key_deposit, $data_deposit, $this->id_organisation);
                    }
                }


                $a_r_i = $id . '.' . 'gp';
                $deposit_id = $this->db->get_where('patient_deposit', array('amount_received_id' => $a_r_i))->row();
                $status = 'demander';
                $data = array(
                    'category_name' => $category_name,
                    'patient' => $patient,
                    'doctor' => $doctor,
                    'amount' => $sub_total,
                    'discount' => $discount,
                    'flat_discount' => $flat_discount,
                    'gross_total' => $gross_total,
                    'amount_received' => $amount_received,
                    'hospital_amount' => $hospital_amount,
                    'doctor_amount' => $doctor_amount,
                    'user' => $user,
                    'patient_name' => $patient_details->name,
                    'patient_phone' => $patient_details->phone,
                    'patient_address' => $patient_details->address,
                    'doctor_name' => $doctor_details->name,
                    'remarks' => $remarks, 'status' => $status,
                    'prescripteur' => $doctorInitial
                );

                if (!empty($deposit_id->id)) {
                    $data1 = array(
                        'date' => $date,
                        'patient' => $patient,
                        'payment_id' => $id,
                        'deposited_amount' => $amount_received,
                        'user' => $user
                    );
                    $this->finance_model->updateDeposit($deposit_id->id, $data1, $this->id_organisation);
                } else {
                    $data1 = array(
                        'date' => $date,
                        'patient' => $patient,
                        'payment_id' => $id,
                        'deposited_amount' => $amount_received,
                        'amount_received_id' => $id . '.' . 'gp',
                        'user' => $user,
                        'id_organisation' => $this->id_organisation
                    );
                    $this->finance_model->insertDeposit($data1);
                }
                $this->finance_model->updatePayment($id, $data, $this->id_organisation);

// if($amount_received && $amount_received > 0) {
// if($amount_received) {

                $payment_details = $this->finance_model->getPaymentById($inserted_id);
                $data1Email = array(
                    'name' => $patient_name,
                    'company' => $this->nom_organisation,
                    'amount' => number_format($amount_received, 0, '', '.') . " FCFA",
                    'payment_method' => $deposit_type,
                    'montant_total' => number_format($payment_details->gross_total, 0, '', '.') . " FCFA",
                    'total_depots' => number_format($payment_details->amount_received, 0, '', '.') . " FCFA",
                    'restant' => number_format(($payment_details->gross_total - $payment_details->amount_received), 0, '', '.') . " FCFA"
                );
                $data1SMS = $data1Email;

// SMS
                if ($amount_received > 0) {
                    $autosms = $this->sms_model->getAutoSmsByType('payment');
                } else {
                    $autosms = $this->sms_model->getAutoSmsByType('emptyPayment');
                }
                $message = $autosms->message;
// $subject = $autosms->name;  
                $to = $patient_phone;

                $messageprint = $this->parser->parse_string($message, $data1SMS);
// Temp Special Chars / SMS
                $toReplace = array("é", "è", "à", "\r\n", "\r", "\n");
                $replaceBy = array("e", "e", "a", "", "", "");
                $dataInsert = array(
                    'recipient' => $to,
                    'message' => $messageprint,
                    'date' => time(),
                    'user' => $this->ion_auth->get_user_id()
                );
                $this->sms_model->insertSms($dataInsert);

                $autoemail = $this->email_model->getAutoEmailByType('payment');
                $message1 = $autoemail->message;
                $subject = $this->parser->parse_string($autoemail->name, $data1Email);
                $messageprint2 = $this->parser->parse_string($message1, $data1Email);
                $dataInsertEmail = array(
                    'reciepient' => $patient_email,
                    'subject' => $subject,
                    'message' => $messageprint2,
                    'date' => time(),
                    'user' => $this->ion_auth->get_user_id()
                );
                $this->email_model->insertEmail($dataInsertEmail);

                $this->session->set_flashdata('feedback', lang('updated'));
                if ($etat == '1') {
                    redirect("finance/invoicepro?id=" . "$id");
                } else {
                    redirect("finance/invoice?id=" . $id . "&page=" . $page);
                }
            }
        }
    }

    public function addPaymentOM() {
        $id = $this->input->post('id');
        $item_selected = array();
        $quantity = array();
        $amount = $this->input->get('amount');
        $category_selected = array();
// $amount_by_category = $this->input->post('category_amount');
        $category_selected = $this->input->post('refPrestation');
        $item_selected = explode('|', $this->input->post('list_id'));
        $quantity = $this->input->post('quantity');
        $remarks = $this->input->post('refRemarks');
        $remarksId = $this->input->post('refRemarksId');
        $doctorInitial = $this->input->post('doctor');
        $remarksType = $this->input->post('refRemarksType');
        $charge_mutuelle = $this->input->post('refChargeMutuelle');
        $service = $this->input->post('refService');
        $id_service_specialite_organisation = $this->input->post('refService'); // NEW
        $service = '';
        if (!empty($id_service_specialite_organisation)) {
            $service = $this->db->query("select id_service from setting_service_specialite_organisation where id =" . $id_service_specialite_organisation)->row()->id_service; // NEW
        }
        $etat = $this->input->post('refChoicePartenaire');
        $destinataire = $this->input->post('refPartenaire');
        $refMobRef = $this->input->post('refMobRef');
        $idtransaction = $this->input->post('idtransaction');
        $refNumOM = $this->input->post('refNumOM');
        $type_statut = 'PENDING';

        if (empty($item_selected)) {
            $this->session->set_flashdata('feedback', lang('select_an_item'));

            redirect('finance/addPaymentView');
        }
        $cat_and_price = array();

        if (!empty($item_selected)) {
            foreach ($item_selected as $value) {
// $current_item = $this->finance_model->getPaymentCategoryById($value, $this->id_organisation);
// NEW
                if ($etat == '1' && $destinataire) {
                    $current_item = $this->db->query("select payment_category_organisation.tarif_public, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm from payment_category_organisation where id_presta =" . $value . " and id_organisation=" . $destinataire)->row();
                    $buff_org = $destinataire;
                } else {
                    $current_item = $this->db->query("select payment_category_organisation.tarif_public, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm from payment_category_organisation where id_presta =" . $value . " and id_organisation=" . $this->id_organisation)->row();
                    $buff_org = $this->id_organisation;
                }

                if ($remarks) {

// Check si prestation couverte dans partenariat
                    $id_partenariat_buff = $this->db->query("select id from partenariat_sante_assurance where id_organisation_sante=" . $buff_org . " and id_organisation_assurance=" . $remarksId)->row()->id;
                    $est_couverte = $this->db->query("select (CASE WHEN sante_assurance_prestation.est_couverte IS NULL THEN '1' ELSE '0' END) as est_couverte from payment_category left join sante_assurance_prestation on sante_assurance_prestation.id_partenariat_sante_assurance = " . $id_partenariat_buff . " AND sante_assurance_prestation.id_payment_category = " . $value)->row()->est_couverte;

                    if ($est_couverte) {
                        if ($remarksType == "IPM") {
                            $category_price = intval($current_item->tarif_ipm);
                        } else if ($remarksType == "Assurance") {
                            $category_price = intval($current_item->tarif_assurance);
                        }
                    } else {
                        $category_price = intval($current_item->tarif_public);
                    }
                } else {
                    $category_price = intval($current_item->tarif_public);
                }
// END
// if ($remarks) {
// $category_price = intval($current_item->tarif_assurance);
// } else {
// $category_price = intval($current_item->tarif_public);
// }
// $category_price = intval($current_item->tarif_public);
// $category_type = $current_item->type;
                $category_type = "";
                $qty = "1";
                if ($etat == '1') {
                    $cat_and_price[] = $value . '*' . $category_price . '*' . $service . '*' . $qty . '*1';
                } else {
                    $cat_and_price[] = $value . '*' . $category_price . '*' . $service . '*' . $qty . '*0';
                }

                $amount_by_category[] = $category_price * $qty;
            }
            $category_name = implode(',', $cat_and_price);
        } else {
            $this->session->set_flashdata('feedback', lang('attend_the_required_fields'));
            redirect('finance/addPaymentView');
        }

        $patient = $this->input->post('refPatient');

        $p_name = $this->input->post('p_name');
        $last_p_name = $this->input->post('last_p_name');
        $p_email = $this->input->post('p_email');
        if (empty($p_email)) {
            $p_email = $p_name . '-' . rand(1, 1000) . '-' . $p_name . '-' . rand(1, 1000) . '@example.com';
        }
        if (!empty($p_name)) {
            $password = $p_name . '-' . rand(1, 100000000);
        }
        $p_phone = $this->input->post('p_phone');
        $p_age = $this->input->post('p_age');
        $p_gender = $this->input->post('p_gender');
        $add_date = date('m/d/y HH:i');

        $patient_id = rand(10000, 1000000);

        $d_name = $this->input->post('d_name');
        $d_email = $this->input->post('d_email');
        if (empty($d_email)) {
            $d_email = $d_name . '-' . rand(1, 1000) . '-' . $d_name . '-' . rand(1, 1000) . '@example.com';
        }
        if (!empty($d_name)) {
            $password = $d_name . '-' . rand(1, 100000000);
        }
        $d_phone = $this->input->post('d_phone');

        $doctor = $this->input->post('doctor');
        $date = time();
        $date_string = date('d-m-y HH:mm', $date);
        $discount = $this->input->post('discount');
        if (empty($discount)) {
            $discount = 0;
        }
//$amount_received = $this->input->post('amount_received');
        $amount_received = $this->input->post('refDepot');
        $deposit_type = $this->input->post('refSelecttype');
        $user = $this->ion_auth->get_user_id();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

// Validating Category Field
// $this->form_validation->set_rules('category_amount[]', 'Category', 'min_length[1]|max_length[100]');
// Validating Price Field
        $this->form_validation->set_rules('refPatient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Price Field
        $this->form_validation->set_rules('discount', 'Discount', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            redirect('finance/addPaymentView');
        } else {
            if (!empty($p_name)) {

                $data_p = array(
                    'patient_id' => $patient_id,
                    'name' => $p_name,
                    'last_name' => $last_p_name,
                    'email' => $p_email,
                    'phone' => $p_phone,
                    'sex' => $p_gender,
                    'age' => $p_age,
                    'add_date' => $add_date,
                    'how_added' => 'from_pos'
                );
                $username = $this->input->post('p_name');
// Adding New Patient
                if ($this->ion_auth->email_check($p_email)) {
                    $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                } else {
                    $dfg = 5;
                    $this->ion_auth->register($username, $password, $p_email, $dfg);
                    $ion_user_id = $this->db->get_where('users', array('email' => $p_email))->row()->id;
                    $last_patient_user_id = $this->patient_model->insertPatient($data_p);
                    $patient_user_id = $last_patient_user_id; //$this->db->get_where('patient', array('email' => $p_email))->row()->id;

                    $count_patient = $this->db->get_where('patient', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
// $patient_id = 'P-' . $this->code_organisation . '-' . str_pad($count_patient, 4, "0", STR_PAD_LEFT);
                    $patient_id = 'P' . $this->code_organisation . '' . $count_patient;
                    $id_info = array('ion_user_id' => $ion_user_id, 'patient_id' => $patient_id);
                    $this->patient_model->updatePatient($patient_user_id, $id_info, $this->id_organisation);
                }
//    }
            }

            if (!empty($d_name)) {

                $data_d = array(
                    'name' => $d_name,
                    'email' => $d_email,
                    'phone' => $d_phone,
                );
                $username = $this->input->post('d_name');
// Adding New Patient
                if ($this->ion_auth->email_check($d_email)) {
                    $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                } else {
                    $dfgg = 4;
                    $this->ion_auth->register($username, $password, $d_email, $dfgg);
                    $ion_user_id = $this->db->get_where('users', array('email' => $d_email))->row()->id;
                    $this->doctor_model->insertDoctor($data_d);
                    $doctor_user_id = $this->db->get_where('doctor', array('email' => $d_email))->row()->id;
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->doctor_model->updateDoctor($doctor_user_id, $id_info);
                }
            }


            if ($patient == 'add_new') {
                $patient = $patient_user_id;
            }

            if ($doctor == 'add_new') {
                $doctor = $doctor_user_id;
            }

            $amount = array_sum($amount_by_category);
            $sub_total = $amount;
            $discount_type = $this->finance_model->getDiscountType($this->id_organisation);
            if (!empty($doctor)) {
                $all_cat_name = explode(',', $category_name);
                foreach ($all_cat_name as $indiviual_cat_nam) {
                    $indiviual_cat_nam1 = explode('*', $indiviual_cat_nam);
                    $qty = $indiviual_cat_nam1[3];
                    $d_commission = $this->finance_model->getPaymentCategoryById($indiviual_cat_nam1[0], $this->id_organisation)->d_commission;
                    $h_commission = 100 - $d_commission;
                    $hospital_amount_per_unit = $indiviual_cat_nam1[1] * $h_commission / 100;
                    $hospital_amount_by_category[] = $hospital_amount_per_unit * $qty;
                }
                $hospital_amount = array_sum($hospital_amount_by_category);
                if ($discount_type == 'flat') {
                    $flat_discount = $discount;
                    $gross_total = $sub_total - $flat_discount - $charge_mutuelle;
                    $doctor_amount = $amount - $hospital_amount - $flat_discount;
                } else {
                    $flat_discount = $sub_total * ($discount / 100);
                    $gross_total = $sub_total - $flat_discount - $charge_mutuelle;
                    $doctor_amount = $amount - $hospital_amount - $flat_discount;
                }
            } else {
                $doctor_amount = '0';
                if ($discount_type == 'flat') {
                    $flat_discount = $discount;
                    $gross_total = $sub_total - $flat_discount - $charge_mutuelle;
                    $hospital_amount = $gross_total;
                } else {
                    $flat_discount = $amount * ($discount / 100);
                    $gross_total = $sub_total - $flat_discount - $charge_mutuelle;
                    $hospital_amount = $gross_total;
                }
            }
            $data = array();

            if (!empty($patient)) {
                $patient_details = $this->patient_model->getPatientById($patient, $this->id_organisation);
                $patient_name = $patient_details->name . ' ' . $patient_details->last_name;
                $patient_phone = $patient_details->phone;
                $patient_address = $patient_details->address;
                $patient_email = $patient_details->email;
            } else {
                $patient_name = 0;
                $patient_phone = 0;
                $patient_address = 0;
            }

            if (!empty($doctor)) {
                $doctor_details = $this->doctor_model->getDoctorById($doctor);
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = 0;
            }

            if (empty($id)) {
                $data = array(
                    'category_name' => $category_name,
                    'patient' => $patient,
                    'date' => $date,
                    'amount' => $sub_total,
                    'doctor' => $doctor,
                    'service' => $service,
                    'discount' => $discount,
                    'flat_discount' => $flat_discount,
                    'gross_total' => $gross_total,
                    'hospital_amount' => $hospital_amount,
                    'doctor_amount' => $doctor_amount,
                    'user' => $user,
                    'patient_name' => $patient_name,
                    'patient_phone' => $patient_phone,
                    'patient_address' => $patient_address,
                    'doctor_name' => $doctor_name,
                    'date_string' => $date_string,
                    'id_organisation' => $this->id_organisation,
                    'remarks' => $remarks,
                    'charge_mutuelle' => $charge_mutuelle,
                    'etat' => $etat,
                    'organisation_destinataire' => $destinataire,
                    'prescripteur' => $doctorInitial
                );

                $this->finance_model->insertPayment($data);
                $inserted_id = $this->db->insert_id();
                $count_payment = $this->db->get_where('payment', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
                if ($etat == '1') {
// $codeFacture = 'CO-' . $this->code_organisation . '-' . str_pad($count_payment, 4, "0", STR_PAD_LEFT);
                    $codeFacture = 'CO' . $this->code_organisation . '' . $count_payment;
                } else {
// $codeFacture = 'F-' . $this->code_organisation . '-' . str_pad($count_payment, 4, "0", STR_PAD_LEFT);
                    $codeFacture = 'F' . $this->code_organisation . '' . $count_payment;
                }

                $this->finance_model->updatePayment($inserted_id, array('code' => $codeFacture), $this->id_organisation);

                if ($amount_received) {
                    $data1 = array(
                        'date' => $date,
                        'patient' => $patient,
                        'deposited_amount' => $amount_received,
                        'payment_id' => $inserted_id,
                        'amount_received_id' => '',
                        'deposit_type' => $deposit_type,
                        'id_organisation' => $this->id_organisation,
                        'statut_deposit' => 'PENDING',
                        'id_transaction_externe' => $idtransaction,
                        'ref_om' => $refMobRef,
                        'numero_om' => $refNumOM,
                        'user' => $user
                    );
                    $this->finance_model->insertDepositOM($data1);
                }
                $status = 'new';
                $statuspaid = 'unpaid';
                if ($amount_received > 0) {
//$status = 'pending';
                }
                $rece = $amount_received + $discount + $charge_mutuelle;
// if ($rece >= $gross_total) {
                if ($rece >= $sub_total) {
// $statuspaid = 'paid';
                }

                if ($etat == '1') {
//$status = 'pending';
                }
                $data_payment = array('deposit_type' => $deposit_type, 'status' => $status, 'status_paid' => $statuspaid);
                $this->finance_model->updatePayment($inserted_id, $data_payment, $this->id_organisation);

                $this->session->set_flashdata('feedback', lang('added'));
                if ($etat == '1') {
                    redirect("finance/invoicepro?id=" . "$inserted_id");
                } else {
                    redirect("finance/invoice?id=" . "$inserted_id");
                }

//   }
            } else {
                $deposit_edit_amount = $this->input->post('deposit_edit_amount');
                $deposit_edit_id = $this->input->post('deposit_edit_id');
                if (!empty($deposit_edit_amount)) {
                    $deposited_edit = array_combine($deposit_edit_id, $deposit_edit_amount);
                    foreach ($deposited_edit as $key_deposit => $value_deposit) {
                        $data_deposit = array(
                            'deposited_amount' => $value_deposit
                        );
                        $this->finance_model->updateDeposit($key_deposit, $data_deposit, $this->id_organisation);
                    }
                }


                $a_r_i = $id . '.' . 'gp';
                $deposit_id = $this->db->get_where('patient_deposit', array('amount_received_id' => $a_r_i))->row();
                $status = 'new';
                if ($amount_received > 0) {
// $status = 'pending';
                }
                $data = array(
                    'category_name' => $category_name,
                    'patient' => $patient,
                    'doctor' => $doctor,
                    'amount' => $sub_total,
                    'discount' => $discount,
                    'flat_discount' => $flat_discount,
                    'gross_total' => $gross_total,
                    'amount_received' => '',
                    'hospital_amount' => $hospital_amount,
                    'doctor_amount' => $doctor_amount,
                    'user' => $user,
                    'patient_name' => $patient_details->name,
                    'patient_phone' => $patient_details->phone,
                    'patient_address' => $patient_details->address,
                    'doctor_name' => $doctor_details->name,
                    'remarks' => $remarks, 'status' => $status,
                    'prescripteur' => $doctorInitial
                );

                if (!empty($deposit_id->id)) {
                    $data1 = array(
                        'date' => $date,
                        'patient' => $patient,
                        'payment_id' => $id,
                        'deposited_amount' => $amount_received,
                        'user' => $user
                    );
                    $this->finance_model->updateDeposit($deposit_id->id, $data1, $this->id_organisation);
                } else {
                    $data1 = array(
                        'date' => $date,
                        'patient' => $patient,
                        'payment_id' => $id,
                        'deposited_amount' => $amount_received,
                        'amount_received_id' => $id . '.' . 'gp',
                        'user' => $user,
                        'id_organisation' => $this->id_organisation
                    );
                    $this->finance_model->insertDeposit($data1);
                }
                $this->finance_model->updatePayment($id, $data, $this->id_organisation);
                $this->session->set_flashdata('feedback', lang('updated'));
                if ($etat == '1') {
                    redirect("finance/invoicepro?id=" . "$id");
                } else {
                    redirect("finance/invoice?id=" . "$id");
                }
            }
        }
    }

    function editPayment() {
        if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Accountant', 'Receptionist', 'Assistant'))) {
            $data = array();
            $data['discount_type'] = $this->finance_model->getDiscountType($this->id_organisation);
            $data['settings'] = $this->settings_model->getSettings();
            $data['categories'] = $this->finance_model->getPaymentCategory($this->id_organisation);
// $data['patients'] = $this->patient_model->getPatient();
//  $data['doctors'] = $this->doctor_model->getDoctor();
            $id = $this->input->get('id');
            $data['payment'] = $this->finance_model->getPaymentById($id, $this->id_organisation);
            $data['patients'] = $this->patient_model->getPatientById($data['payment']->patient, $this->id_organisation);
            $data['doctors'] = $this->doctor_model->getDoctorById($data['payment']->doctor);
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('add_payment_view', $data);
            $this->load->view('home/footer'); // just the footer file
        }
    }

    function delete() {
        if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Accountant', 'Receptionist', 'Assistant'))) {
            $id = $this->input->get('id');
            $this->finance_model->deletePayment($id);
            $this->finance_model->deleteDepositByInvoiceId($id);
            $this->session->set_flashdata('feedback', lang('deleted'));
            redirect('finance/payment');
        }
    }

    public function otPayment() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['ot_payments'] = $this->finance_model->getOtPayment();

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('ot_payment', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addOtPaymentView() {
        $data = array();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['discount_type'] = $this->finance_model->getDiscountType();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->finance_model->getPaymentCategory();
        $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_ot_payment', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addOtPayment() {
        $id = $this->input->post('id');
        $patient = $this->input->post('patient');
        $doctor_c_s = $this->input->post('doctor_c_s');
        $doctor_a_s_1 = $this->input->post('doctor_a_s_1');
        $doctor_a_s_2 = $this->input->post('doctor_a_s_2');
        $doctor_anaes = $this->input->post('doctor_anaes');
        $n_o_o = $this->input->post('n_o_o');

        $c_s_f = $this->input->post('c_s_f');
        $a_s_f_1 = $this->input->post('a_s_f_1');
        $a_s_f_2 = $this->input->post('a_s_f_2');
        $anaes_f = $this->input->post('anaes_f');
        $ot_charge = $this->input->post('ot_charge');
        $cab_rent = $this->input->post('cab_rent');
        $seat_rent = $this->input->post('seat_rent');
        $others = $this->input->post('others');

        $discount = $this->input->post('discount');
        $vat = $this->input->post('vat');
        $amount_received = $this->input->post('amount_received');

        $date = time();
        $user = $this->ion_auth->get_user_id();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

// Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|required|min_length[2]|max_length[100]|xss_clean');
// Validating Consultant surgeon Field
        $this->form_validation->set_rules('doctor_c_s', 'Consultant surgeon', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Assistant Surgeon Field
        $this->form_validation->set_rules('doctor_a_s_1', 'Assistant Surgeon (1)', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Assistant Surgeon Field
        $this->form_validation->set_rules('doctor_a_s_2', 'Assistant Surgeon(2)', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Anaesthisist Field
        $this->form_validation->set_rules('doctor_anaes', 'Anaesthisist', 'trim|min_length[2]|max_length[100]|xss_clean');
// Validating Nature Of Operation Field
        $this->form_validation->set_rules('n_o_o', 'Nature Of Operation', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Consultant Surgeon Fee Field
        $this->form_validation->set_rules('c_s_f', 'Consultant Surgeon Fee', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Assistant surgeon fee Field
        $this->form_validation->set_rules('a_s_f_1', 'Assistant surgeon fee', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Assistant surgeon fee Field
        $this->form_validation->set_rules('a_s_f_2', 'Assistant surgeon fee', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Anaesthesist Field
        $this->form_validation->set_rules('anaes_f', 'Anaesthesist', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating OT Charge Field
        $this->form_validation->set_rules('ot_charge', 'OT Charge', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Cabin Rent Field
        $this->form_validation->set_rules('cab_rent', 'Cabin Rent', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Seat Rent Field
        $this->form_validation->set_rules('seat_rent', 'Seat Rent', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Others Field
        $this->form_validation->set_rules('others', 'Others', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Discount Field
        $this->form_validation->set_rules('discount', 'Discount', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo 'form validate noe nai re';
// redirect('accountant/add_new'); 
        } else {
            $doctor_fees = $c_s_f + $a_s_f_1 + $a_s_f_2 + $anaes_f;
            $hospital_fees = $ot_charge + $cab_rent + $seat_rent + $others;
            $amount = $doctor_fees + $hospital_fees;
            $discount_type = $this->finance_model->getDiscountType();

            if ($discount_type == 'flat') {
                $amount_with_discount = $amount - $discount;
                $gross_total = $amount_with_discount + $amount_with_discount * ($vat / 100);
                $flat_discount = $discount;
                $flat_vat = $amount_with_discount * ($vat / 100);
                $hospital_fees = $hospital_fees - $flat_discount;
            } else {
                $flat_discount = $amount * ($discount / 100);
                $amount_with_discount = $amount - $amount * ($discount / 100);
                $gross_total = $amount_with_discount + $amount_with_discount * ($vat / 100);
                $discount = $discount . '*' . $amount * ($discount / 100);
                $flat_vat = $amount_with_discount * ($vat / 100);
                $hospital_fees = $hospital_fees - $flat_discount;
            }

            $data = array();

            if (empty($id)) {
                $data = array(
                    'patient' => $patient,
                    'doctor_c_s' => $doctor_c_s,
                    'doctor_a_s_1' => $doctor_a_s_1,
                    'doctor_a_s_2' => $doctor_a_s_2,
                    'doctor_anaes' => $doctor_anaes,
                    'n_o_o' => $n_o_o,
                    'c_s_f' => $c_s_f,
                    'a_s_f_1' => $a_s_f_1,
                    'a_s_f_2' => $a_s_f_2,
                    'anaes_f' => $anaes_f,
                    'ot_charge' => $ot_charge,
                    'cab_rent' => $cab_rent,
                    'seat_rent' => $seat_rent,
                    'others' => $others,
                    'discount' => $discount,
                    'date' => $date,
                    'amount' => $amount,
                    'doctor_fees' => $doctor_fees,
                    'hospital_fees' => $hospital_fees,
                    'gross_total' => $gross_total,
                    'flat_discount' => $flat_discount,
                    'amount_received' => $amount_received,
                    'status' => 'unpaid',
                    'user' => $user
                );
                $this->finance_model->insertOtPayment($data);
                $inserted_id = $this->db->insert_id();
                $data1 = array(
                    'date' => $date,
                    'patient' => $patient,
                    'deposited_amount' => $amount_received,
                    'amount_received_id' => $inserted_id . '.' . 'ot',
                    'user' => $user,
                    'id_organisation' => $this->id_organisation
                );
                $this->finance_model->insertDeposit($data1);

                $this->session->set_flashdata('feedback', lang('added'));
                redirect("finance/otInvoice?id=" . "$inserted_id");
            } else {
                $a_r_i = $id . '.' . 'ot';
                $deposit_id = $this->db->get_where('patient_deposit', array('amount_received_id' => $a_r_i))->row()->id;
                $data = array(
                    'patient' => $patient,
                    'doctor_c_s' => $doctor_c_s,
                    'doctor_a_s_1' => $doctor_a_s_1,
                    'doctor_a_s_2' => $doctor_a_s_2,
                    'doctor_anaes' => $doctor_anaes,
                    'n_o_o' => $n_o_o,
                    'c_s_f' => $c_s_f,
                    'a_s_f_1' => $a_s_f_1,
                    'a_s_f_2' => $a_s_f_2,
                    'anaes_f' => $anaes_f,
                    'ot_charge' => $ot_charge,
                    'cab_rent' => $cab_rent,
                    'seat_rent' => $seat_rent,
                    'others' => $others,
                    'discount' => $discount,
                    'amount' => $amount,
                    'doctor_fees' => $doctor_fees,
                    'hospital_fees' => $hospital_fees,
                    'gross_total' => $gross_total,
                    'flat_discount' => $flat_discount,
                    'amount_received' => $amount_received,
                    'user' => $user
                );
                $data1 = array(
                    'date' => $date,
                    'patient' => $patient,
                    'deposited_amount' => $amount_received,
                    'user' => $user
                );
                $this->finance_model->updateDeposit($deposit_id, $data1);
                $this->finance_model->updateOtPayment($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
                redirect("finance/otInvoice?id=" . "$id");
            }
        }
    }

    function editOtPayment() {
        if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Accountant'))) {
            $data = array();
            $data['discount_type'] = $this->finance_model->getDiscountType();
            $data['settings'] = $this->settings_model->getSettings();
            $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
            $id = $this->input->get('id');
            $data['ot_payment'] = $this->finance_model->getOtPaymentById($id);
            $data['doctors'] = $this->doctor_model->getDoctor();
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('add_ot_payment', $data);
            $this->load->view('home/footer'); // just the footer file
        }
    }

    function otInvoice() {
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['discount_type'] = $this->finance_model->getDiscountType();
        $data['ot_payment'] = $this->finance_model->getOtPaymentById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('ot_invoice', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function otPaymentDetails() {
        $id = $this->input->get('id');
        $patient = $this->input->get('patient');
        $data['patient'] = $this->patient_model->getPatientByid($patient, $this->id_organisation);
        $data['settings'] = $this->settings_model->getSettings();
        $data['discount_type'] = $this->finance_model->getDiscountType();
        $data['ot_payment'] = $this->finance_model->getOtPaymentById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('ot_payment_details', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function otPaymentDelete() {
        if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Accountant'))) {
            $id = $this->input->get('id');
            $this->finance_model->deleteOtPayment($id);
            $this->session->set_flashdata('feedback', lang('deleted'));
            redirect('finance/otPayment');
        }
    }

    function addPaymentByPatient() {
        $data = array();
        $id = $this->input->get('id');
        $data['patient'] = $this->patient_model->getPatientById($id, $this->id_organisation);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('choose_payment_type', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function addPaymentByPatientView() {
        $id = $this->input->get('id');
        $type = $this->input->get('type');
        $data = array();
        $data['discount_type'] = $this->finance_model->getDiscountType($this->id_organisation);
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->finance_model->getPaymentCategory($this->id_organisation);
        $data['gateway'] = $this->finance_model->getGatewayByName($data['settings']->payment_gateway, $this->id_organisation);
        $data['doctors'] = $this->doctor_model->getDoctor();

        $data['patient'] = $this->patient_model->getPatientById($id, $this->id_organisation);

        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        if ($type == 'gen') {
            $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
            $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
            $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_payment_view_single', $data);
            $this->load->view('home/footer'); // just the footer fi
        } else {
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_ot_payment_view_single', $data);
            $this->load->view('home/footer'); // just the footer fi
        }







        /* $data['id'] = $id;
          $data['type'] = $type;
          $data['patient'] = $this->patient_model->getPatientById($id, $this->id_organisation);
          $data['discount_type'] = $this->finance_model->getDiscountType($this->id_organisation);
          $data['settings'] = $this->settings_model->getSettings();
          $data['categories'] = $this->finance_model->getPaymentCategory($this->id_organisation);
          $data['gateway'] = $this->finance_model->getGatewayByName($data['settings']->payment_gateway, $this->id_organisation);
          $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
          $data['doctors'] = $this->doctor_model->getDoctor();
          $data['id_organisation'] = $this->id_organisation;
          $data['path_logo'] = $this->path_logo;
          $data['nom_organisation'] = $this->nom_organisation;
          $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
          $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
          $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
          $data['regions'] = array('Dakar', 'Ziguinchor', 'Diourbel', 'Saint-Louis', 'Tambacounda', 'Kaolack', 'Thiès', 'Louga', 'Fatick', 'Kolda', 'Matam', 'Kaffrine', 'Kédougou', 'Sédhiou');

          $this->load->view('home/dashboard', $data); // just the header file
          $this->load->view('add_payment_view', $data);
          $this->load->view('home/footer'); // just the header file

         */
    }

    public function paymentCategory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
// $data['categories'] = $this->finance_model->getPaymentCategory();
//$data['categories'] = $this->finance_model->getPaymentCategoryByOrganisation($this->id_organisation);
        $data['categories'] = $this->service_model->getPrestationsOrganisation($this->id_organisation);
        $data['settings'] = $this->settings_model->getSettings();

        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $this->load->view('home/dashboard', $data); // just the header file
// $this->load->view('payment_category', $data);
        $this->load->view('payment_category');
        $this->load->view('home/footer'); // just the header file
    }

    public function paymentCategoryPanier() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
// $data['categories'] = $this->service_model->getPrestationsOrganisation($this->id_organisation);
        $data['prestations'] = $this->service_model->getPrestationsOrganisationEncoreDispo($this->id_organisation);
        $data['settings'] = $this->settings_model->getSettings();

        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $this->load->view('home/dashboard', $data); // just the header file
// $this->load->view('payment_category', $data);
        $this->load->view('payment_category_panier', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function insuranceCoverage() {
        $idPartenariat = $this->input->get("id");
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
// $data['categories'] = $this->finance_model->getPaymentCategory();
        $data['categories'] = $this->finance_model->getInsuranceCoverage($idPartenariat, $this->id_organisation);
        $data['typeTiersPayant'] = $this->finance_model->getTypeTiersPayant($idPartenariat);
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_partenariat'] = $idPartenariat;
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('insurance_coverage', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addInsuranceView() {
// $data['setting_services'] = $this->finance_model->getSettingService();
        $data['assurances'] = $this->finance_model->getAssurancesNonEncorePartenaire($this->id_organisation);
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_insurance', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addInsurance() {
        $id = $this->input->post('id');
        $idAssurance = $this->input->post('assurance');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $data = array();
        $data = array(
            'id_organisation_assurance' => $idAssurance,
            'id_organisation_sante' => $this->id_organisation
        );
        if (empty($id)) {
            $output = $this->finance_model->insertInsurance($data);
            $this->session->set_flashdata('feedback', "Tiers-Payant Ajouté");
        }
// else {
// $this->finance_model->updatePaymentCategory($id, $data,$this->id_organisation);
// $this->session->set_flashdata('feedback', lang('procedure') . " " . lang('updated2'));
// }
        redirect('finance/insurance');
    }

    function addRemoveInsuranceCoverage() {
        $id_partenariat = $this->input->get('idPartenariat');
        $id_payment_category = $this->input->get('idPaymentCategory');
        $status = $this->input->get('status');

        $result = $this->finance_model->addRemoveInsuranceCoverage($id_partenariat, $id_payment_category, $status);

        echo json_encode("");
    }

    public function addPaymentCategoryView() {
// $data['setting_services'] = $this->finance_model->getSettingService();
        $data['setting_services'] = $this->finance_model->getSettingServiceByOrganisation($this->id_organisation);
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_payment_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addPaymentCategory() {
        $id = $this->input->post('id');
        $prestation = $this->input->post('prestation');
        $description = $this->input->post('description');
        $tarif_public = str_replace(".", "", $this->input->post('tarif_public')); // Suppression du "." de AutoNumeric.js
        $tarif_professionnel = str_replace(".", "", $this->input->post('tarif_professionnel'));
        $tarif_assurance = str_replace(".", "", $this->input->post('tarif_assurance'));
        $tarif_ipm = str_replace(".", "", $this->input->post('tarif_ipm'));
        $service = $this->input->post('service');
// if (empty($c_price)) {
// $c_price = 0;
// }


        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
// Validating Category Name Field
// $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[1]|max_length[100]|xss_clean');
// Validating Description Field
// $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[1]|max_length[100]|xss_clean');
// Validating Description Field
// $this->form_validation->set_rules('c_price', 'Category price', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Doctor Commission Rate Field
// $this->form_validation->set_rules('d_commission', 'Doctor Commission rate', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Description Field
// $this->form_validation->set_rules('type', 'Type', 'trim|min_length[1]|max_length[100]|xss_clean');
// if ($this->form_validation->run() == FALSE) {
// if (!empty($id)) {
// $this->session->set_flashdata('feedback', lang('validation_error'));
// redirect('finance/editPaymentCategory?id=' . $id);
// } else {
// $data = array();
// $data['setval'] = 'setval';
// $this->load->view('home/dashboard'); // just the header file
// $this->load->view('add_payment_category', $data);
// $this->load->view('home/footer'); // just the header file
// }
// } else {
        $data = array();

        if (empty($id)) {
            $data = array(
                'prestation' => $prestation,
                'description' => $description,
                'tarif_public' => $tarif_public,
                'tarif_professionnel' => $tarif_professionnel,
                'tarif_assurance' => $tarif_assurance,
                'tarif_ipm' => $tarif_ipm,
                'id_service' => $service
            );
            $this->finance_model->insertPaymentCategory($data);
            $this->session->set_flashdata('feedback', lang('procedure') . " " . lang('added'));
        } else {
            $data = array(
                'description' => $description,
                'tarif_public' => $tarif_public,
                'tarif_professionnel' => $tarif_professionnel,
                'tarif_assurance' => $tarif_assurance,
                'tarif_ipm' => $tarif_ipm
            );
            $this->finance_model->updatePaymentCategory($id, $data);
            $this->session->set_flashdata('feedback', lang('procedure') . " " . lang('updated2'));
        }
        redirect('finance/paymentCategory');
// }
    }

    function editPaymentCategory() {
        $data = array();
        $id = $this->input->get('id');
        $data['category'] = $this->finance_model->getPaymentCategoryById($id, $this->id_organisation);
// $data['setting_services'] = $this->finance_model->getSettingService();

        $data['setting_services'] = $this->finance_model->getSettingServiceByOrganisation($this->id_organisation);
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_payment_category', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function deletePaymentCategory() {
        $id = $this->input->get('id');
        $this->finance_model->deletePaymentCategory($id, $this->id_organisation);
        redirect('finance/paymentCategory');
    }

    public function expense() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['settings'] = $this->settings_model->getSettings();
        $data['expenses'] = $this->finance_model->getExpense($this->id_organisation);

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('expense', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpenseView() {
        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->finance_model->getExpenseCategory($this->id_organisation);
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_expense_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpense() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $beneficiaire = $this->input->post('beneficiaire');
        $date = time();
        $amount = $this->input->post('amount');
        $amount = str_replace(".", "", $amount);
        $codeType = "codeCourante";
        $user = $this->ion_auth->get_user_id();
        $note = $this->input->post('note');
        $count_payment = $this->db->get_where('expense', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
// $codeFacture = 'R-' . $this->code_organisation . '-' . str_pad($count_payment, 4, "0", STR_PAD_LEFT);
        $codeFacture = 'R' . $this->code_organisation . '' . $count_payment;

        /*         * ***** Integration Category dépense */
        $c_category = $this->input->post('c_category');
        $c_description = $this->input->post('c_description');
        $category_id = rand(10000, 1000000);
        if ($category == 'add_new') {
            $this->form_validation->set_rules('c_category', 'Category Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            $this->form_validation->set_rules('c_description', 'Category Description', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        }
        /*         * ***** FIN Integration Category dépense */
        /*         * ***** Integration beneficiaire dépense */
        $c_name = $this->input->post('c_name');
        $c_lastName = $this->input->post('c_last_name');
        $c_beneficiaire = $c_name . ' ' . $c_lastName;
        $telephone = $this->input->post('telephone');
        $beneficiaire_id = rand(10000, 1000000);
        if ($beneficiaire == 'add_newBeneficiaire') {
            $this->form_validation->set_rules('c_name', 'Beneficiaire Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            $this->form_validation->set_rules('c_last_name', 'Last Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            $this->form_validation->set_rules('telephone', 'telephone', 'trim|required|min_length[4]|max_length[100]|xss_clean');
        }
        /*         * ***** FIN Integration Category dépense */

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

// Validating Category Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[1]|max_length[100]|xss_clean');
//  $this->form_validation->set_rules('beneficiaire', 'Beneficiaire', 'trim|required|min_length[1]|max_length[100]|xss_clean');
// Validating Generic Name Field
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required|min_length[1]|max_length[100]|xss_clean');
// Validating Note Field
        $this->form_validation->set_rules('note', 'Note', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $this->session->set_flashdata('feedback', lang('validation_error'));
                redirect('finance/editExpense?id=' . $id);
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $data['settings'] = $this->settings_model->getSettings();
                $data['categories'] = $this->finance_model->getExpenseCategory();
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_expense_view', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {

            /*             * * VALIDATION CATEGORY */

            if ($category == 'add_new') {
                $data = array();
                $data = array(
                    'category' => $c_category, 'status' => 1,
                    'description' => $c_description, 'id_organisation' => $this->id_organisation
                );
                if (empty($id)) {
                    $this->finance_model->insertExpenseCategory($data);
                    $this->session->set_flashdata('feedback', lang('added'));
                } else {
                    $this->finance_model->updateExpenseCategory($id, $data);
                    $this->session->set_flashdata('feedback', lang('updated'));
                }

                $category = $c_category;
//    }
            }
            /** FIN VALIDATION CATEGORY */
            /*             * * VALIDATION BENEFICIAIRE */

            if ($beneficiaire == 'add_newBeneficiaire') {
                $data = array();
                $data = array(
                    'name' => $c_beneficiaire,
                    'phone' => $telephone,
                    'id_organisation' => $this->id_organisation
                );
                if (empty($id)) {
                    $this->finance_model->insertExpenseBeneficiaire($data);
                    $this->session->set_flashdata('feedback', lang('added'));
                } else {
                    $this->finance_model->updateExpenseBeneficiaire($id, $data);
                    $this->session->set_flashdata('feedback', lang('updated'));
                }

                $beneficiaire = $c_beneficiaire . ' ' . $telephone;
//    }
            }
            /** FIN VALIDATION CATEGORY */
            $data = array();
            if (empty($id)) {
                $data = array(
                    'category' => $category,
                    'date' => $date, 'status' => 1,
                    'datestring' => date('d/m/y H:i', $date),
                    'amount' => $amount,
                    'note' => $note,
                    'user' => $user,
                    'id_organisation' => $this->id_organisation,
                    'beneficiaire' => $beneficiaire,
                    'codeType' => $codeType,
                    'codeFacture' => $codeFacture
                );
            } else {
                $data = array(
                    'category' => $category,
                    'amount' => $amount,
                    'note' => $note,
                    'user' => $user,
                    'id_organisation' => $this->id_organisation,
                    'beneficiaire' => $beneficiaire,
                    'codeType' => $codeType,
                    'codeFacture' => $codeFacture
                );
            }
            if (empty($id)) {
                $this->finance_model->insertExpense($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->finance_model->updateExpense($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('finance/expense');
        }
    }

    function editExpense() {
        $data = array();
        $data['categories'] = $this->finance_model->getExpenseCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $id = $this->input->get('id');
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['expense'] = $this->finance_model->getExpenseById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_expense_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function deleteExpense() {
        $id = $this->input->get('id');
        $this->finance_model->deleteExpense($id);
        redirect('finance/expense');
    }

    public function expenseCategory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['categories'] = $this->finance_model->getExpenseCategory($this->id_organisation);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('expense_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpenseCategoryView() {

        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_expense_category');
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpenseCategory() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $description = $this->input->post('description');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
// Validating Category Name Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[1]|max_length[100]|xss_clean');
// Validating Description Field
// $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $this->session->set_flashdata('feedback', lang('validation_error'));
                redirect('finance/editExpenseCategory?id=' . $id);
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_expense_category', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $data = array();
            $data = array(
                'category' => $category, 'status' => 1,
                'description' => $description, 'id_organisation' => $this->id_organisation
            );
            if (empty($id)) {
                $this->finance_model->insertExpenseCategory($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->finance_model->updateExpenseCategory($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('finance/expenseCategory');
        }
    }

    function editExpenseCategory() {
        $data = array();
        $id = $this->input->get('id');
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['category'] = $this->finance_model->getExpenseCategoryById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_expense_category', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function deleteExpenseCategory() {
        $id = $this->input->get('id');
        $this->finance_model->deleteExpenseCategory($id);
        redirect('finance/expenseCategory');
    }

    function invoice() {
        $id = $this->input->get('id');

        $data['discount_type'] = $this->finance_model->getDiscountType();
        $data['payment'] = $this->finance_model->getPaymentById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $data['organisation'] = $this->home_model->getOrganisationById($this->id_organisation);
        if (!empty($data['payment']->prescripteur)) {
            $doctor_details = $this->home_model->getUserById($data['payment']->prescripteur);
            $data['doctor'] = $doctor_details;
        }


        $this->load->view('home/dashboardInvoice', $data); // just the header file
        $this->load->view('invoice_2', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function invoicepro() {
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['discount_type'] = $this->finance_model->getDiscountType();
        $data['payment'] = $this->finance_model->getPaymentById($id);

        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $data['organisation'] = $this->home_model->getOrganisationById($this->id_organisation);

        $this->load->view('home/dashboardInvoice', $data); // just the header file
        $this->load->view('invoice_2', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function printInvoice() {
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['discount_type'] = $this->finance_model->getDiscountType();
        $data['payment'] = $this->finance_model->getPaymentById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('print_invoice', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function expenseInvoice() {
        $id = $this->input->get('id');
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['settings'] = $this->settings_model->getSettings();
        $data['expense'] = $this->finance_model->getExpenseById($id);
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        if (empty($data['expense'])) {
            $data['expense'] = $this->finance_model->getExpenseBySuperUsers($id);
        }
        $data['organisation'] = $this->home_model->getOrganisationById($this->id_organisation);
        $this->load->view('home/dashboardInvoice', $data); // just the header file
        $this->load->view('expense_invoice_2', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

// public function createPDF($fileName,$html) {
//     ob_start(); 
//     // Include the main TCPDF library (search for installation path).
//     $this->load->library('Pdf');
//     // create new PDF document
//     $pdf = new TCPDF('PDF_PAGE_ORIENTATION', 'PDF_UNIT', 'PDF_PAGE_FORMAT', true, 'UTF-8', false);
//     // set document information
//     $pdf->SetCreator('PDF_CREATOR');
//     $pdf->SetAuthor('TcPdf');
//     $pdf->SetTitle('TcPdf');
//     $pdf->SetSubject('TcPdf');
//     $pdf->SetKeywords('TcPdf');
//     // set default header data
//     $pdf->SetHeaderData('PDF_HEADER_LOGO', 'PDF_HEADER_LOGO_WIDTH', 'PDF_HEADER_TITLE', 'PDF_HEADER_STRING');
//     // set header and footer fonts
//     $pdf->setHeaderFont(Array('PDF_FONT_NAME_MAIN', '', 'PDF_FONT_SIZE_MAIN'));
//     $pdf->setFooterFont(Array('PDF_FONT_NAME_DATA', '', 'PDF_FONT_SIZE_DATA'));
//     $pdf->SetPrintHeader(false);
//     $pdf->SetPrintFooter(false);
//     // set default monospaced font
//     $pdf->SetDefaultMonospacedFont('PDF_FONT_MONOSPACED');
//     // set margins
//     $pdf->SetMargins('PDF_MARGIN_LEFT', 0, 'PDF_MARGIN_RIGHT');
//     $pdf->SetHeaderMargin(0);
//     $pdf->SetFooterMargin(0);
//     // set auto page breaks
//     //$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//     $pdf->SetAutoPageBreak(TRUE, 0);
//     // set image scale factor
//     $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//     // set some language-dependent strings (optional)
//     if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
//         require_once(dirname(__FILE__).'/lang/eng.php');
//         $pdf->setLanguageArray($l);
//     }       
//     // set font
//     $pdf->SetFont('dejavusans', '', 10);
//     // add a page
//     $pdf->AddPage();
//     // output the HTML content
//     $pdf->writeHTML($html, true, false, true, false, '');
//     // reset pointer to the last page
//     $pdf->lastPage();       
//     ob_end_clean();
//     //Close and output PDF document
//     $pdf->Output($fileName, 'F');        
// }

    function amountReceived() {
        $id = $this->input->post('id');
        $amount_received = $this->input->post('amount_received');
        $previous_amount_received = $this->db->get_where('payment', array('id' => $id))->row()->amount_received;
        $amount_received = $amount_received + $previous_amount_received;
        $data = array();
        $data = array('amount_received' => $amount_received);
        $this->finance_model->amountReceived($id, $data);
        redirect('finance/invoice?id=' . $id);
    }

    function otAmountReceived() {
        $id = $this->input->post('id');
        $amount_received = $this->input->post('amount_received');
        $previous_amount_received = $this->db->get_where('ot_payment', array('id' => $id))->row()->amount_received;
        $amount_received = $amount_received + $previous_amount_received;
        $data = array();
        $data = array('amount_received' => $amount_received);
        $this->finance_model->otAmountReceived($id, $data);
        redirect('finance/oTinvoice?id=' . $id);
    }

    function patientListeActe() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $patient = $this->input->get('patient');
        $data = $this->finance_model->getPaymentByPatientId($patient);
        echo json_encode($data);
    }

    function patientPaymentHistory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $patient = $this->input->get('patient');
        if (empty($patient)) {
            $patient = $this->input->post('patient');
        }
        $data['settings'] = $this->settings_model->getSettings();
        $date_from = strtotime($this->input->post('date_from'));  //var_dump($date_from.'---'.$this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));     //   var_dump($date_to.'---'.$this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 86399;
        }

        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;

        /*  if (!empty($date_from)) {
          $data['payments'] = $this->finance_model->getPaymentByPatientIdByDate($patient, $date_from, $date_to);
          $data['deposits'] = $this->finance_model->getDepositByPatientIdByDate($patient, $date_from, $date_to);
          $data['gateway'] = $this->finance_model->getGatewayByName($data['settings']->payment_gateway);
          } else {
          $data['payments'] = $this->finance_model->getPaymentByPatientId($patient);
          $data['pharmacy_payments'] = $this->pharmacy_model->getPaymentByPatientId($patient);
          $data['ot_payments'] = $this->finance_model->getOtPaymentByPatientId($patient);
          $data['deposits'] = $this->finance_model->getDepositByPatientId($patient);
          $data['gateway'] = $this->finance_model->getGatewayByName($data['settings']->payment_gateway);
          } */

        $data['payments'] = $this->finance_model->getPaymentByPatientIdByDate($patient, $date_from, $date_to);
        $data['deposits'] = $this->finance_model->getDepositByPatientIdByDate($patient, $date_from, $date_to);
        $data['gateway'] = $this->finance_model->getGatewayByName($data['settings']->payment_gateway);

        $data['patient'] = $this->patient_model->getPatientByid($patient, $this->id_organisation);

        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('patient_deposit', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function deposit() {
        $id = $this->input->post('id');
        $patient = $this->input->post('patient');
        $payment_id = $this->input->post('payment_id');
        $date = time();

        $deposited_amount = $this->input->post('deposited_amount');

        $deposit_type = $this->input->post('deposit_type');

        if (empty($deposit_type)) {
            $deposit_type = 'Cash';
        }

        $user = $this->ion_auth->get_user_id();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
// Validating Patient Name Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Deposited Amount Field
        $this->form_validation->set_rules('deposited_amount', 'Deposited Amount', 'trim|min_length[1]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            redirect('finance/patientPaymentHistory?patient=' . $patient);
        } else {
            $data = array();
            $data = array(
                'patient' => $patient,
                'date' => $date,
                'payment_id' => $payment_id,
                'deposited_amount' => $deposited_amount,
                'deposit_type' => $deposit_type,
                'user' => $user,
                'id_organisation' => $this->id_organisation
            );
            if (empty($id)) {
                /*  if ($deposit_type == 'Card') {
                  $payment_details = $this->finance_model->getPaymentById($payment_id);
                  $gateway = $this->settings_model->getSettings()->payment_gateway;

                  if ($gateway == 'PayPal') {
                  $card_type = $this->input->post('card_type');
                  $card_number = $this->input->post('card_number');
                  $expire_date = $this->input->post('expire_date');
                  $cvv = $this->input->post('cvv');

                  $all_details = array(
                  'patient' => $payment_details->patient,
                  'date' => $payment_details->date,
                  'amount' => $payment_details->amount,
                  'doctor' => $payment_details->doctor_name,
                  'discount' => $payment_details->discount,
                  'flat_discount' => $payment_details->flat_discount,
                  'gross_total' => $payment_details->gross_total,
                  'status' => 'unpaid',
                  'patient_name' => $payment_details->patient_name,
                  'patient_phone' => $payment_details->patient_phone,
                  'patient_address' => $payment_details->patient_address,
                  'deposited_amount' => $deposited_amount,
                  'payment_id' => $payment_details->id,
                  'card_type' => $card_type,
                  'card_number' => $card_number,
                  'expire_date' => $expire_date,
                  'cvv' => $cvv,
                  'from' => 'patient_payment_details',
                  'user' => $user
                  );
                  $this->paypal->Do_direct_payment($all_details);
                  } elseif ($gateway == 'Stripe') {
                  $card_number = $this->input->post('card_number');
                  $expire_date = $this->input->post('expire_date');
                  $cvv = $this->input->post('cvv');
                  $token = $this->input->post('token');
                  $stripe = $this->db->get_where('paymentGateway', array('name =' => 'Stripe'))->row();
                  \Stripe\Stripe::setApiKey($stripe->secret);
                  $charge = \Stripe\Charge::create(array(
                  "amount" => $deposited_amount * 100,
                  "currency" => "usd",
                  "source" => $token
                  ));
                  $chargeJson = $charge->jsonSerialize();
                  // redirect("finance/invoice?id=" . "$inserted_id");
                  } elseif ($gateway == 'Pay U Money') {
                  redirect("payu/check?deposited_amount=" . "$deposited_amount" . '&payment_id=' . $payment_id);
                  } else {
                  $this->session->set_flashdata('feedback', lang('payment_failed_no_gateway_selected'));
                  redirect("finance/invoice?id=" . "$payment_id");
                  }
                  } else { */
                $this->finance_model->insertDeposit($data);
                $this->session->set_flashdata('feedback', lang('added'));
//  }
            } else {
                $this->finance_model->updateDeposit($id, $data);

                $amount_received_id = $this->finance_model->getDepositById($id)->amount_received_id;
                if (!empty($amount_received_id)) {
                    $amount_received_payment_id = explode('.', $amount_received_id);
                    $payment_id = $amount_received_payment_id[0];

//$data_amount_received = array('amount_received' => $deposited_amount, 'status' => 'pending');
                    $data_amount_received = array('amount_received' => $deposited_amount);
                    $this->finance_model->updatePayment($amount_received_payment_id[0], $data_amount_received);
                }

                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('finance/patientPaymentHistory?patient=' . $patient);
        }
    }

    function editDepositByJason() {
        $id = $this->input->get('id');
        $data['deposit'] = $this->finance_model->getDepositById($id);
        echo json_encode($data);
    }

    function deleteDeposit() {
        $id = $this->input->get('id');
        $patient = $this->input->get('patient');

        $amount_received_id = $this->finance_model->getDepositById($id)->amount_received_id;
        if (!empty($amount_received_id)) {
            $amount_received_payment_id = explode('.', $amount_received_id);
            $payment_id = $amount_received_payment_id[0];
            $data_amount_received = array('amount_received' => NULL);
            $this->finance_model->updatePayment($amount_received_payment_id[0], $data_amount_received);
        }

        $this->finance_model->deleteDeposit($id);

        redirect('finance/patientPaymentHistory?patient=' . $patient);
    }

    function getPendingPaymentByPatientId() {
        $requestData = $_REQUEST;
        $id_patient = $requestData["id"];
        $data = $this->finance_model->getPendingPaymentByPatientId($id_patient);
        echo json_encode($data);
    }

    function getPendingPrestationsByPatientId() {
        $requestData = $_REQUEST;
        $id_patient = $requestData["id"];
        $data = $this->finance_model->getPendingPaymentByPatientId($id_patient);

        $resultArray = array();
        $result = count($data) > 0 ? "<option value='Veuillez sélectionner une prestation' data-extravalue='0'>Veuillez sélectionner une prestation</option>" : "<option value='Pas de prestation en cours' data-extravalue='0'>Pas de prestation en cours</option>";
        foreach ($data as $entry) {
            $dataTab = explode(',', $entry->category_name);
            foreach ($dataTab as $value) {
                $status = "";
                $valueTab = explode('*', $value);
                $id_prestation = $valueTab[0];

                $current_prestation = $this->finance_model->getPaymentCategoryByOrganisationById($id_prestation, $this->id_organisation);
                if (!isset($valueTab[4])) {
// $status = "En attente";
                } else {
                    $detail_nom = '';

                    $details = $this->finance_model->editCategoryServiceByJasonParametre($current_prestation->id);
                    $nom_specialite = '';
                    foreach ($details as $detail) {
                        $resultats = '';
                        $resultatsTab = $this->finance_model->editResultats($detail->idpara, $entry->id);
                        if ($resultatsTab) {
                            $resultats = $resultatsTab->resultats;
                        }
                        $detail_nom .= $detail->idpara . '##' . $detail->nom_parametre . '##' . $detail->unite . '##' . $detail->valeurs . '##' . $resultats . '|';
                        $nom_specialite = $detail->name_specialite;
                    }
                    if ($valueTab[4] == '1') {
                        $resultArray[] = array("value" => $entry->id . "@@@@" . $value, "details" => $detail_nom, "code" => $entry->code, "extraValue" => $current_prestation->id, "text" => $current_prestation->prestation, "nom_specialite" => $nom_specialite);
                        $result .= "<option value='" . $entry->id . "@@@@" . $value . "' data-extravalue='" . $current_prestation->id . "'>";
                        $result .= $current_prestation->prestation;
                        $result .= "</option>";
                    }
                }
            }
        }

// echo json_encode(array('result' => $result));
// echo json_encode($result);
        echo json_encode($resultArray);
// echo json_encode($data);
    }

    function invoicePatientTotal() {
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['discount_type'] = $this->finance_model->getDiscountType();
        $data['payments'] = $this->finance_model->getPaymentByPatientIdByStatus($id);
        $data['ot_payments'] = $this->finance_model->getOtPaymentByPatientIdByStatus($id);
        $data['patient_id'] = $id;
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('invoicePT', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function lastPaidInvoice() {
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['discount_type'] = $this->finance_model->getDiscountType();
        $data['payments'] = $this->finance_model->lastPaidInvoice($id);
        $data['ot_payments'] = $this->finance_model->lastOtPaidInvoice($id);
        $data['patient_id'] = $id;
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('LPInvoice', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function makePaid() {
        $id = $this->input->get('id');
        $patient_id = $this->finance_model->getPaymentById($id)->patient;
        $data = array();
        $data = array('status' => 'paid');
        $data1 = array();
        $data1 = array('status' => 'paid-last');
        $this->finance_model->makeStatusPaid($id, $patient_id, $data, $data1);
        $this->session->set_flashdata('feedback', lang('paid'));
        redirect('finance/invoice?id=' . $id);
    }

    function makePaidByPatientIdByStatus() {
        $id = $this->input->get('id');
        $data = array();
        $data = array('status' => 'paid-last');
        $data1 = array();
        $data1 = array('status' => 'paid');
        $this->finance_model->makePaidByPatientIdByStatus($id, $data, $data1);
        $this->session->set_flashdata('feedback', lang('paid'));
        redirect('patient');
    }

    function makeOtStatusPaid() {
        $id = $this->input->get('id');
        $this->finance_model->makeOtStatusPaid($id);
        $this->session->set_flashdata('feedback', lang('paid'));
        redirect("finance/otInvoice?id=" . "$id");
    }

    function doctorsCommission() {
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 86399;
        }
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['payments'] = $this->finance_model->getPaymentByDate($date_from, $date_to, $this->id_organisation);
        $data['ot_payments'] = $this->finance_model->getOtPaymentByDate($date_from, $date_to);
        $data['settings'] = $this->settings_model->getSettings();
        $data['from'] = $this->input->post('date_from');
        $data['to'] = $this->input->post('date_to');
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('doctors_commission', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function docComDetails() {
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 86399;
        }
        $doctor = $this->input->get('id');
        if (empty($doctor)) {
            $doctor = $this->input->post('doctor');
        }
        $data['doctor'] = $doctor;
        if (!empty($date_from)) {
            $data['payments'] = $this->finance_model->getPaymentByDoctorDate($doctor, $date_from, $date_to);
        } else {
            $data['payments'] = $this->finance_model->getPaymentByDoctor($doctor);
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['from'] = $this->input->post('date_from');
        $data['to'] = $this->input->post('date_to');
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('doc_com_view', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function financialReport() {
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 86399;
        }
        $data = array();
        $data['payment_categories'] = $this->finance_model->getPaymentCategory();
        $data['expense_categories'] = $this->finance_model->getExpenseCategory($this->id_organisation);

        $dateDebut = $this->input->get('debut');
        $dateFin = $this->input->get('fin');
        $typedepense = $this->input->get('type');

        $data['payments'] = $this->finance_model->getPaymentByDate($date_from, $date_to, $this->id_organisation);
        $data['ot_payments'] = $this->finance_model->getOtPaymentByDate($date_from, $date_to);
        $data['deposits'] = $this->finance_model->getDepositsByDate($date_from, $date_to);
        $data['expenses'] = $this->finance_model->getExpenseByDate($date_from, $date_to, $this->id_organisation);

        if (!empty($typedepense)) {
            $date_debut = $dateDebut . ' 00:00';
            $date_debut = strtotime(str_replace('/', '-', $date_debut));
            $date_fin = $dateFin . ' 23:59';
            $date_fin = strtotime(str_replace('/', '-', $date_fin));
            $data['datePeriode'] = 'Du ' . $dateDebut . ' au ' . $dateFin;

            $data['paymentExpense'] = $this->finance_model->getPEByFilterType($this->id_organisation, $date_debut, $date_fin, $typedepense);
        } else if ($dateDebut) {
            $date_debut = $dateDebut . ' 00:00';
            $date_debut = strtotime(str_replace('/', '-', $date_debut));
            $date_fin = $dateFin . ' 23:59';
            $date_fin = strtotime(str_replace('/', '-', $date_fin));
            $data['paymentExpense'] = $this->finance_model->getPaymentExpenseByOrganisationByFilter($this->id_organisation, $date_debut, $date_fin);
            $data['datePeriode'] = 'Du ' . $dateDebut . ' au ' . $dateFin;
        } else {
            $data['paymentExpense'] = $this->finance_model->getPaymentExpenseByOrganisationById($this->id_organisation);
            $data['datePeriode'] = 'Du ' . $dateDebut . ' au ' . $dateFin;
        }
        $data['from'] = $this->input->post('date_from');
        $data['to'] = $this->input->post('date_to');
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('financial_report', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function UserActivityReport() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if ($this->ion_auth->in_group(array('Accountant'))) {
            $user = $this->ion_auth->get_user_id();
            $data['user'] = $this->accountant_model->getAccountantByIonUserId($user);
        }
        if ($this->ion_auth->in_group(array('Receptionist', 'Assistant'))) {
            $user = $this->ion_auth->get_user_id();
            $data['user'] = $this->receptionist_model->getReceptionistByIonUserId($user);
        }
        $hour = 0;
        $TODAY_ON = $this->input->get('today');
        $YESTERDAY_ON = $this->input->get('yesterday');
        $ALL = $this->input->get('all');

        $today = strtotime($hour . ':00:00');
        $today_last = strtotime($hour . ':00:00') + 86399;
        $data['payments'] = $this->finance_model->getPaymentByUserIdByDate($user, $today, $today_last);
        $data['ot_payments'] = $this->finance_model->getOtPaymentByUserIdByDate($user, $today, $today_last);
        $data['deposits'] = $this->finance_model->getDepositByUserIdByDate($user, $today, $today_last);
        $data['day'] = 'Today';
        if (!empty($YESTERDAY_ON)) {
            $today = strtotime($hour . ':00:00');
            $yesterday = strtotime('-1 day', $today);
            $data['day'] = 'Yesterday';
            $data['payments'] = $this->finance_model->getPaymentByUserIdByDate($user, $yesterday, $today);
            $data['ot_payments'] = $this->finance_model->getOtPaymentByUserIdByDate($user, $yesterday, $today);
            $data['deposits'] = $this->finance_model->getDepositByUserIdByDate($user, $yesterday, $today);
        }
        if (!empty($ALL)) {
            $data['day'] = 'All';
            $data['payments'] = $this->finance_model->getPaymentByUserId($user);
            $data['ot_payments'] = $this->finance_model->getOtPaymentByUserId($user);
            $data['deposits'] = $this->finance_model->getDepositByUserId($user);
        }
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('user_activity_report', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function getCategoryinfoWithAddNewOption() {
// Search term
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->finance_model->getCategoryinfoWithAddNewOption($searchTerm, $this->id_organisation);

        echo json_encode($response);
    }

    public function getBeneficiaireinfoWithAddNewOption() {
// Search term
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->finance_model->getBeneficiaireinfoWithAddNewOption($searchTerm, $this->id_organisation);

        echo json_encode($response);
    }

    public function getSpecialiteConsultation() {

        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->finance_model->getSpecialiteConsultation($searchTerm);

        echo json_encode($response);
    }

    function UserActivityReportDateWise() {
        $data = array();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if ($this->ion_auth->in_group(array('Accountant'))) {
            $user = $this->input->post('user');
            $data['user'] = $this->accountant_model->getAccountantByIonUserId($user);
        }
        if ($this->ion_auth->in_group(array('Receptionist', 'Assistant'))) {
            $user = $this->input->post('user');
            $data['user'] = $this->receptionist_model->getReceptionistByIonUserId($user);
        }
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 86399;
        }

        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;

        $data['payments'] = $this->finance_model->getPaymentByUserIdByDate($user, $date_from, $date_to);
        $data['ot_payments'] = $this->finance_model->getOtPaymentByUserIdByDate($user, $date_from, $date_to);
        $data['deposits'] = $this->finance_model->getDepositByUserIdByDate($user, $date_from, $date_to);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('user_activity_report', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function AllUserActivityReport() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $user = $this->input->get('user');

        if (!empty($user)) {
            $user_group = $this->db->get_where('users_groups', array('user_id' => $user))->row()->group_id;
            if ($user_group == '3') {
                $data['user'] = $this->accountant_model->getAccountantByIonUserId($user);
            }
            if ($user_group == '10') {
                $data['user'] = $this->receptionist_model->getReceptionistByIonUserId($user);
            }
            $data['settings'] = $this->settings_model->getSettings();
            $hour = 0;
            $TODAY_ON = $this->input->get('today');
            $YESTERDAY_ON = $this->input->get('yesterday');
            $ALL = $this->input->get('all');

            $today = strtotime($hour . ':00:00');
            $today_last = strtotime($hour . ':00:00') + 86399;
            $data['payments'] = $this->finance_model->getPaymentByUserIdByDate($user, $today, $today_last);
            $data['ot_payments'] = $this->finance_model->getOtPaymentByUserIdByDate($user, $today, $today_last);
            $data['deposits'] = $this->finance_model->getDepositByUserIdByDate($user, $today, $today_last);
            $data['day'] = 'Today';

            if (!empty($YESTERDAY_ON)) {
                $today = strtotime($hour . ':00:00');
                $yesterday = strtotime('-1 day', $today);
                $data['payments'] = $this->finance_model->getPaymentByUserIdByDate($user, $yesterday, $today);
                $data['ot_payments'] = $this->finance_model->getOtPaymentByUserIdByDate($user, $yesterday, $today);
                $data['deposits'] = $this->finance_model->getDepositByUserIdByDate($user, $yesterday, $today);
                $data['day'] = 'Yesterday';
            }

            if (!empty($ALL)) {
                $data['payments'] = $this->finance_model->getPaymentByUserId($user);
                $data['ot_payments'] = $this->finance_model->getOtPaymentByUserId($user);
                $data['deposits'] = $this->finance_model->getDepositByUserId($user);
                $data['day'] = 'All';
            }


            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('user_activity_report', $data);
            $this->load->view('home/footer'); // just the header file
        }

        if (empty($user)) {
            $hour = 0;
            $today = strtotime($hour . ':00:00');
            $today_last = strtotime($hour . ':00:00') + 86399;
            $data['accountants'] = $this->accountant_model->getAccountant();
            $data['receptionists'] = $this->receptionist_model->getReceptionist();
            $data['settings'] = $this->settings_model->getSettings();
            $data['payments'] = $this->finance_model->getPaymentByDate($today, $today_last, $this->id_organisation);
            $data['ot_payments'] = $this->finance_model->getOtPaymentByDate($today, $today_last);
            $data['deposits'] = $this->finance_model->getDepositsByDate($today, $today_last);
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('all_user_activity_report', $data);
            $this->load->view('home/footer'); // just the header file
        }
    }

    function AllUserActivityReportDateWise() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $user = $this->input->post('user');

        if (!empty($user)) {
            $user_group = $this->db->get_where('users_groups', array('user_id' => $user))->row()->group_id;
            if ($user_group == '3') {
                $data['user'] = $this->accountant_model->getAccountantByIonUserId($user);
            }
            if ($user_group == '10') {
                $data['user'] = $this->receptionist_model->getReceptionistByIonUserId($user);
            }
            $date_from = strtotime($this->input->post('date_from'));
            $date_to = strtotime($this->input->post('date_to'));
            if (!empty($date_to)) {
                $date_to = $date_to + 86399;
            }

            $data['settings'] = $this->settings_model->getSettings();
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['payments'] = $this->finance_model->getPaymentByUserIdByDate($user, $date_from, $date_to);
            $data['ot_payments'] = $this->finance_model->getOtPaymentByUserIdByDate($user, $date_from, $date_to);
            $data['deposits'] = $this->finance_model->getDepositByUserIdByDate($user, $date_from, $date_to);

            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('user_activity_report', $data);
            $this->load->view('home/footer'); // just the header file
        }

        if (empty($user)) {
            $hour = 0;
            $today = strtotime($hour . ':00:00');
            $today_last = strtotime($hour . ':00:00') + 86399;
            $data['accountants'] = $this->accountant_model->getAccountant();
            $data['receptionists'] = $this->receptionist_model->getReceptionist();
            $data['settings'] = $this->settings_model->getSettings();
            $data['payments'] = $this->finance_model->getPaymentByDate($today, $today_last, $this->id_organisation);
            $data['ot_payments'] = $this->finance_model->getOtPaymentByDate($today, $today_last);
            $data['deposits'] = $this->finance_model->getDepositsByDate($today, $today_last);
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('all_user_activity_report', $data);
            $this->load->view('home/footer'); // just the header file
        }
    }

    function getPayment() {
        $requestData = $_REQUEST;
// $start = $requestData['start'];
//  $limit = $requestData['length'];
//  $search = $this->input->post('search')['value'];
        $settings = $this->settings_model->getSettings();

        $Payment_encours = $this->input->get('status');
        $Payment_all = $this->input->get('all');

        /* if ($limit == -1) {
          if (!empty($search)) {
          $data['payments'] = $this->finance_model->getPaymentBysearch($search);
          } else {
          $data['payments'] = $this->finance_model->getPayment();
          }
          } else {
          if (!empty($search)) {
          $data['payments'] = $this->finance_model->getPaymentByLimitBySearch($limit, $start, $search);
          } else {
          $data['payments'] = $this->finance_model->getPaymentByLimit($limit, $start);
          }
          } */

        if ($Payment_encours) {
            $data['payments'] = $this->finance_model->getPaymentByFilter($this->id_organisation, $Payment_encours);
        } else {
            $data['payments'] = $this->finance_model->getPayment($this->id_organisation);
        }
        $i = 0;
        foreach ($data['payments'] as $payment) {
            $date = $payment->dateFormat;

            $discount = $payment->discount;
            if (empty($discount)) {
                $discount = 0;
            }

            if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Accountant'))) {
//  $options1 = ' <a class="btn btn-info btn-xs editbutton" title="' . lang('edit') . '" href="finance/editPayment?id=' . $payment->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
            }
//'Receptionist', 'Nurse', 'Laboratorist', 'Doctor'
            $options2 = '';
            if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Accountant', 'Receptionist', 'adminmedecin', 'Assistant'))) {
                $options2 = '<a class="btn green btn-xs_ invoicebutton payment" title="' . lang('invoice_f') . '" style="color: #fff;" href="finance/invoice?id=' . $payment->id . '"><i class="fa fa-file-invoice"></i> ' . lang('invoice_f') . '</a>';
            }
            if ($payment->etatlight = 1) {
                $options2 = '';
            }
            $options4 = '';
            if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Receptionist', 'Assistant'))) {
                if ($payment->gross_total > $payment->amount_received) {
                    $options4 = '  <button id="depot' . $payment->id . '" class="green btn depositbutton payment" onclick="depositbutton(' . $payment->id . ')"  data-gross_total="' . $payment->gross_total . '"  data-amount_received="' . $payment->amount_received . '" data-payment="' . $payment->id . '" data-patient="' . $payment->patient . '" style="" ><i class="fa fa-plus-circle"></i> ' . lang('paye') . '</button>';
                }
            }

            $options3 = '';
//<a class="btn btn-info btn-xs invoicebutton" title="' . lang('print') . '" style="color: #fff;" href="finance/printInvoice?id=' . $payment->id . '"target="_blank"> <i class="fa fa-print"></i> ' . lang('print') . '</a>';
            if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Laboratorist', 'Assistant'))) {
                if ($payment->status == 'new') {
//  $options3 = '<a class="btn  btn-xs- delete_button" title="' . lang('delete') . '" href="finance/delete?id=' . $payment->id . '" onclick="return confirm(\'Êtes-vous sûr de bien vouloir annuler cet acte ?\');"><i class="fa fa-trash"></i> ' . lang('cancel') . '</a>';
                }
            }
            $options1 = '';
            if ($payment->status == 'new') {
                if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Receptionist', 'Assistant'))) {
                    $options1 .= '<button id="pending' . $payment->id . '" class="green btn  payment" onclick="pendingbutton(' . $payment->id . ')"  ><i class="fa  fa-hourglass-start"></i> ' . lang('pending') . '</button>';
                }
            } else if ($payment->status == 'pending') {
                if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Laboratorist', 'Assistant'))) {
//$options1 .= '  <button id="done' . $payment->id . '" class="green btn" onclick="donebutton(' . $payment->id . ')"  ><i class="fa  fa-hourglass-half"></i> ' . lang('done') . '</button>';
// $options1 = '  <a id="done' . $payment->id . '" class="green btn payment" href="finance/getPendingIBydActe?id=' . $payment->patient . '&payment=' . $payment->id . '&prestation=all"  ><i class="fa  fa-hourglass-half"></i> ' . lang('done') . '</a>';

                    if ($payment->status_presta == 'pending' && $this->ion_auth->in_group(array('admin'))) {
//$options1 .= '  <button id="valid' . $payment->id . '" class="green btn" onclick="validbutton(' . $payment->id . ')"  ><i class="fa fa-hourglass-end"></i> ' . lang('valid') . '</button>';
                    }
                }
            } else if ($payment->status == 'done') {
                if ($this->ion_auth->in_group(array('admin', 'Doctor'))) {
// $options1 .= '  <button id="valid' . $payment->id . '" class="green btn" onclick="validbutton(' . $payment->id . ')"  ><i class="fa fa-hourglass-end"></i> ' . lang('valid') . '</button>';
//          $options1 = '  <a id="valid' . $payment->id . '" class="green btn  payment" href="finance/getValidIBydActe?id=' . $payment->patient . '&payment=' . $payment->id .'&prestation=all&payment=' . $payment->id . '"  ><i class="fa  fa-hourglass-end"></i> ' . lang('valid') . '</a>';

                    if ($payment->status_presta == 'pending' && $this->ion_auth->in_group(array('admin'))) {
// $options1 .= '  <button id="finish' . $payment->id . '" class="green btn" onclick="finishbutton(' . $payment->id . ')"  ><i class="fa fa-check"></i> ' . lang('finish') . '</button>';
                    }
                }
            } else if ($payment->status == 'valid') {
                if ($this->ion_auth->in_group(array('admin', 'Receptionist', 'adminmedecin', 'Assistant'))) {
                    $options1 .= '  <button id="finish' . $payment->id . '" class="green btn payment" onclick="finishbutton(' . $payment->id . ')"  ><i class="fa fa-check"></i> ' . lang('finish') . '</button>';
                }
            }
            $options1 = '<span id="spanpending' . $payment->id . '">  ' . $options1 . ' </span>';
            if ($payment->status == 'cancelled' || $payment->etat == 1 || $payment->etatlight == 1) {
                $options2 = '';
                $options4 = '';
                $options3 = '';
// $options1 = '';
            }


            $doctor_details = $this->doctor_model->getDoctorById($payment->doctor);
            $organisation_dest = array();
            if ($payment->organisation_destinataire) {
                $organisation_dest = $this->home_model->getOrganisationById($payment->organisation_destinataire);
                if ($this->id_organisation == $payment->organisation_destinataire) {
                    $data['payments'] = $this->finance_model->getPayment($payment->organisation_destinataire);

                    if ($payment->status == 'pending') {
                        if ($this->ion_auth->in_group(array('admin', 'Laboratorist', 'Assistant'))) {
//  $options1 = '  <a id="done' . $payment->id . '" class="green btn payment" href="finance/getPendingIBydActe?id=' . $payment->patient . '&payment=' . $payment->id .'&prestation=all"  ><i class="fa  fa-hourglass-half"></i> ' . lang('done') . '</a>';
                        }
                    } else if ($payment->status == 'done') {

                        if ($this->ion_auth->in_group(array('admin', 'Doctor'))) {
//  $options1 = '  <a id="valid' . $payment->id . '" class="green btn payment" href="finance/getValidIBydActe?id=' . $payment->patient . '&payment=' . $payment->id .'&prestation=all&payment=' . $payment->id . '"  ><i class="fa  fa-hourglass-end"></i> ' . lang('valid') . '</a>';
                        }
                    } else if ($payment->status == 'valid') {
                        if ($this->ion_auth->in_group(array('admin', 'Receptionist', 'adminmedecin', 'Assistant'))) {
                            if (!$payment->etat && !$payment->etatlight) {
                                $options1 .= '  <button id="finish' . $payment->id . '" class="green btn payment" onclick="finishbutton(' . $payment->id . ')"  ><i class="fa fa-check"></i> ' . lang('finish') . '</button>';
                            }
                        }
                    } else if ($payment->status == 'finish') {
                        if ($this->ion_auth->in_group(array('admin', 'Receptionist', 'Assistant'))) {
// $options1 = '  <button id="pay' . $payment->id . '" class="green btn payment" onclick="paybutton(' . $payment->id . ')"  ><i class="fa fa-money-bill-alt"></i> ' . lang('pay_transfert') . '</button>';
                        }
                    }
                }
            }
            if ($payment->status != 'new') {
                if ($payment->status != 'pending') {
                    if ($payment->status != 'done') {
                        $options1 .= ''; //  <span class="editlab" data-id="' . $payment->id . '"  onclick="editlab(' . $payment->id . ')" ><button id="" class="green btn payment"><i class="fa fa-eye"></i> ' . lang("report_") . '</button></span>';
                    }
                }
            }

            if (!empty($doctor_details)) {
                $doctor = $doctor_details->name;
            } else {
                if (!empty($payment->doctor_name)) {
                    $doctor = $payment->doctor_name;
                } else {
                    $doctor = $payment->doctor_name;
                }
            }

            $patient_info = $this->db->get_where('patient', array('id' => $payment->patient))->row();
            if (!empty($patient_info)) {
                $patient_details = $patient_info->name . ' ' . $patient_info->last_name . '</br>' . $patient_info->phone;
            } else {
                $patient_details = ' ';
            }
            $status = '';
            if ($payment->status == 'new') {
                $status = '<span class="status-p bg-info-paid">' . lang('new_') . '</span>';
            } else if ($payment->status == 'pending') {
                $status = '<span class="status-p bg-primary">' . lang('pending_') . '</span>';
            } else if ($payment->status == 'done') {
                $status = '<span class="status-p bg-primary">' . lang('done_') . '</span>';
            } else if ($payment->status == 'valid') {
                $status = '<span class="status-p bg-primary">' . lang('valid_') . '</span>';
            } else if ($payment->status == 'finish') {
                $status = '<span class="status-p bg-success">' . lang('finish_') . '</span>';
            } else if ($payment->status == 'cancelled') {
                $status = '<span class="status-p bg-danger">' . lang('cancelled') . '</span>';
            } else if ($payment->status == 'accept') {
                $status = '<span class="status-p bg-success">' . lang('accept_') . '</span>';
            }

            if (!empty($organisation_dest) && $this->id_organisation == $payment->id_organisation) {
                if ($payment->status == 'accept' || $payment->status == 'demandpay') {
// $status = '<span class="status-p bg-success">' . lang('demandpay_') . '</span>';
                    $status = '<span class="status-p bg-success">' . lang('accept_') . '</span>';
                }
                if ($payment->etat == '1') {
                    $status .= '<br/>Transfert vers ' . $organisation_dest->nom;
                } else if ($payment->etatlight) {
                    $status .= '<br/>Transfert pour ' . $organisation_dest->nom;
                }
            } else if (!empty($organisation_dest) && $this->id_organisation == $payment->organisation_destinataire) {
                if ($payment->status == 'accept' || $payment->status == 'demandpay') {
// $status = '<span class="status-p bg-danger">' . lang('demandpay_') . '</span>';
                    $status = '<span class="status-p bg-success">' . lang('accept_') . '</span>';
                }
                $status .= '<br/>provenant de  ' . $this->home_model->getOrganisationById($payment->id_organisation)->nom;
            }
            if ($payment->etatlight && $payment->status == 'valid') {
// $options1 = '  <button id="factur' . $payment->id . '" class="green btn payment" onclick="facturebutton(\'' . $payment->id . '\', \'' . $id_prestation . '\')"  ><i class="fa fa-check"></i> ' . lang('facturer') . '</button>';
                $options2 = '';
//  $options4 = '  <button id="depot' . $payment->id . '" class="green btn depositbutton payment" onclick="depositbutton(' . $payment->id . ')"  data-gross_total="' . $payment->gross_total . '"  data-amount_received="' . $payment->amount_received . '" data-payment="' . $payment->id . '" data-patient="' . $payment->patient . '" style="" ><i class="fa fa-plus-circle"></i> ' . lang('paye') . '</button>';
            }

            $info[] = array(
                $payment->status, $payment->id, $payment->code,
                $date,
                '<button class="btn btn-link" style ="background:white;" onclick="infosPatient(' . $payment->patient . ')"><span  class="inffo" data-id="' . $payment->patient . '" >' . $patient_details . '</span></button>',
                number_format($payment->gross_total, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency,
                number_format($this->finance_model->getDepositAmountByPaymentId($payment->id), 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency,
                number_format(($payment->gross_total - $this->finance_model->getDepositAmountByPaymentId($payment->id)), 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency,
                '<span id="status-change' . $payment->id . '">' . $status . '</span>',
                $options2 . ' ' . $options4 . ' ' . $options1 . ' ' . $options3
//  $options2
            );
            $i++;
        }








        if (!empty($data['payments'])) {
            $output = array(
//"draw" => intval($requestData['draw']),
                "recordsTotal" => $i,
                "recordsFiltered" => $i,
                "data" => $info
            );
        } else {
            $output = array(
// "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }




        echo json_encode($output);
    }

    function getPaymentLabo() {
        $settings = $this->settings_model->getSettings();
        $Payment_encours = $this->input->get('status');
        $data['payments'] = $this->finance_model->getPaymentByLabo($this->id_organisation);
        $count_pending = 0;
        $count_done = 0;
        $count_valid = 0;
        $count_finish = 0;
        $info = array();
        foreach ($data['payments'] as $payment) {
            $date = $payment->dateFormat;
// $date = ('ino');
//$patient = $data->patient;
// $patient_name = $data->patient_name;
// $date = date('d/m/Y h:m', $data->date);
            $dataTab = explode(',', $payment->category_name);
            foreach ($dataTab as $value) {
                $valueTab = explode('*', $value);
                if (count($valueTab) == 5) {
                    $valueTab[5] = ' ';
                }

                if (isset($valueTab[4])) {
                    if ($valueTab[5] == 'service' || empty($valueTab[5])) {
                        $status = "";
                        $status1 = "new";

                        $id_prestation = $valueTab[0];

                        $current_prestation = $this->finance_model->getPaymentCategoryByOrganisationById2($id_prestation);
                        $code_service = '';
                        $modele = '';
                        $service_name = '';
                        if ($id_prestation && $this->id_organisation) {
                            $modeleTab = $this->home_model->getModeleByLaboPaiement($id_prestation, $this->id_organisation);
                            if (!empty($modeleTab)) {
                                $modele = $modeleTab->is_modele;
                            }
                        }
                        if (isset($current_prestation->code_service)) {
                            $code_service = $current_prestation->code_service;
                            $service_name = $current_prestation->name_service;
                        }
                        $options1 = '';
                        if ($valueTab[4] == 0) {
                            $status = '<span class="status-p  bg-info-paid">' . lang('new_') . '</span>';
                            $status1 = 'new';
                            if ($this->ion_auth->in_group(array('admin', 'Receptionist', 'adminmedecin', 'Assistant'))) {

                                $options1 .= '<button id="pending' . $id_prestation . '" class="green btn payment" onclick="pendingbutton(\'' . $payment->id . '\', \'' . $payment->patient . '\', \'' . $id_prestation . '\', \'' . $code_service . '\');"  ><i class="fa  fa-hourglass-start"></i> ' . lang('pending') . '</button>';
                            }
                        } else if ($valueTab[4] == 1) {
                            $status = '<span class="status-p bg-primary">' . lang('pending_') . '</span>';
                            $status1 = 'pending';
                            $count_pending++;
                            if ($this->ion_auth->in_group(array('Laboratorist', 'adminmedecin', 'Assistant', 'Biologiste'))) {
                                $options1 = '  <a id="done' . $id_prestation . '" class="green btn payment" href="finance/getPendingIBydActe?id=' . $payment->patient . '&payment=' . $payment->id . '&prestation=' . $id_prestation . '&service=' . $code_service . '&modele=' . $modele . '&nameservice=' . $service_name . '"  ><i class="fa  fa-hourglass-half"></i> ' . lang('done') . '</a>';
                            }
                        } else if ($valueTab[4] == 2) {
                            $status = '<span class="status-p bg-primary">' . lang('done_') . '</span>';
                            $status1 = 'done';
                            $count_done++;
                            if (!$payment->etat) {
                                if ($this->ion_auth->in_group(array('Doctor', 'adminmedecin', 'Biologiste'))) {
                                    $options1 = '  <a id="valid' . $id_prestation . '" class="green btn payment" href="finance/getValidIBydActe?id=' . $payment->patient . '&payment=' . $payment->id . '&prestation=' . $id_prestation . '&service=' . $code_service . '&modele=' . $modele . '&nameservice=' . $service_name . '"  ><i class="fa  fa-hourglass-end"></i> ' . lang('valid') . '</a>';
                                }
                                if ($this->ion_auth->in_group(array('Laboratorist', 'Assistant'))) {
                                    $options1 = '  <a id="reprende' . $id_prestation . '" class="green btn payment" href="finance/getReprendreIBydActe?id=' . $payment->patient . '&payment=' . $payment->id . '&prestation=' . $id_prestation . '&service=' . $code_service . '&modele=' . $modele . '&nameservice=' . $service_name . '"  ><i class="fa  fa-hourglass-end"></i> Reprendre</a>';
                                }
                            }
                        } else if ($valueTab[4] == 3) {
                            $status = '<span class="status-p bg-primary">' . lang('valid_') . '</span>';
                            $status1 = 'valid';
                            $count_valid++;
                            if ($this->ion_auth->in_group(array('Receptionist', 'adminmedecin', 'admin', 'Assistant', 'Biologiste'))) {
                                if (!$payment->etat && !$payment->etatlight) {
                                    $options1 = '  <button id="finish' . $id_prestation . '" class="green btn payment" onclick="finishbutton(\'' . $payment->id . '\', \'' . $id_prestation . '\')"  ><i class="fa fa-check"></i> ' . lang('finish') . '</button>';
                                }
                            }
                        } else if ($valueTab[4] == 4) {
                            $status = '<span class="status-p bg-success">' . lang('finish_') . '</span>';
                            $status1 = 'finish';
                            $count_finish++;
                        } else if ($valueTab[4] == 5) {
                            if ($payment->etatlight == 1) {
                                $status = '<span class="status-p bg-success" style="text-transform: uppercase;">' . lang('sent') . '</span>';
                            } else {
                                $status = '<span class="status-p bg-success">' . lang('accept_') . '</span>';
                            }
                            $status1 = 'finish';
                            $count_finish++;
                        }
                        if ($valueTab[4] == 7) {
                            $status = '<span class="status-p  bg-secondary">' . lang('demander_') . '</span>';
                            $status1 = 'new';
                            if ($this->ion_auth->in_group(array('admin', 'Receptionist', 'adminmedecin', 'Assistant'))) {

                                $options1 .= '<button id="pending' . $payment->id . '" class="green btn payment" onclick="afficherBulletin(\'' . $payment->id . '\');"  ><i class="fa  fa-hourglass-start"></i> ' . lang('pending') . '</button>';
                            }
                        }


                        if ($payment->etat == 1) {
                            $options2 = '';
                            $options4 = '';
                            $options3 = '';
                            $options1 = '';
                        }

                        $organisation_dest = array();

                        if ($payment->organisation_destinataire) {
                            $organisation_dest = $this->home_model->getOrganisationById($payment->organisation_destinataire);

                            if ($this->id_organisation == $payment->organisation_destinataire) {
// $data['payments'] = $this->finance_model->getPayment($payment->organisation_destinataire);
                                if ($valueTab[4] == 1) {
                                    if ($this->ion_auth->in_group(array('Laboratorist', 'adminmedecin', 'Assistant', 'Biologiste'))) {
                                        $options1 .= '  <a id="done' . $id_prestation . '" class="green btn  payment" href="finance/getPendingIBydActe?id=' . $payment->patient . '&payment=' . $payment->id . '&prestation=' . $id_prestation . '&service=' . $code_service . '&modele=' . $modele . '"  ><i class="fa  fa-hourglass-half"></i> ' . lang('done') . '</a>';
                                    }
                                } else if ($valueTab[4] == 2) {
                                    if ($this->ion_auth->in_group(array('Doctor', 'adminmedecin', 'Biologiste'))) {
                                        $options1 .= '  <a id="valid' . $id_prestation . '" class="green btn payment" href="finance/getValidIBydActe?id=' . $payment->patient . '&payment=' . $payment->id . '&prestation=' . $id_prestation . '&service=' . $code_service . '&modele=' . $modele . '"  ><i class="fa  fa-hourglass-end"></i> ' . lang('valid') . '</a>';
                                    }
                                    if ($this->ion_auth->in_group(array('Laboratorist', 'Assistant'))) {
                                        $options1 = '  <a id="reprende' . $id_prestation . '" class="green btn payment" href="finance/getReprendreIBydActe?id=' . $payment->patient . '&payment=' . $payment->id . '&prestation=' . $id_prestation . '&service=' . $code_service . '&modele=' . $modele . '"  ><i class="fa  fa-hourglass-end"></i> Reprendre</a>';
                                    }
                                } else if ($valueTab[4] == 3) {
                                    if ($this->ion_auth->in_group(array('admin', 'Receptionist', 'Assistant'))) {

// $options1 .= '  <button id="finish' . $id_prestation . '" class="green btn payment" onclick="finishbutton(' . $payment->id . ',' . $id_prestation . ')"  ><i class="fa fa-check"></i> ' . lang('finish') . '</button>';
                                    }
                                }
                            }
                        }

                        if (!empty($organisation_dest) && $this->id_organisation == $payment->id_organisation && $payment->etat == 1 && $valueTab[4] == 3 && $this->ion_auth->in_group(array('Doctor', 'adminmedecin', 'Biologiste'))) {
                            $options1 .= '  <a id="validextern' . $id_prestation . '" class="green btn  payment" href="finance/validexterneBydActe?id=' . $payment->patient . '&payment=' . $payment->id . '&prestation=' . $id_prestation . '&service=' . $code_service . '&modele=' . $modele . '"  ><i class="fa fa-exchange"></i> ' . lang('validextern') . '</a>';
                        }
                        if (!empty($organisation_dest) && $this->id_organisation == $payment->id_organisation) {
                            if ($valueTab[4] == 6) {
                                $status = '<span class="status-p bg-danger">' . lang('demandpay_') . '</span>';
                                $status1 = 'finish';
                                $count_finish++;
                            }
                            if ($payment->etat) {
                                $status .= '<br/>Transfert vers ' . $organisation_dest->nom;
                            } else if ($payment->etatlight) {
                                $status .= '<br/>Transfert pour ' . $organisation_dest->nom;
                            }
                        } else if (!empty($organisation_dest) && $this->id_organisation == $payment->organisation_destinataire) {
                            if ($valueTab[4] == 6) {
                                $status = '<span class="status-p bg-success">' . lang('demandpay_') . '</span>';
                                $status1 = 'finish';
                                $count_finish++;
                            }
                            $status .= '<br/>provenant de  ' . $this->home_model->getOrganisationById($payment->id_organisation)->nom;
                        }
                        $options1 = '<span id="spanpending' . $id_prestation . '">  ' . $options1 . ' </span>';
                        if ($payment->etatlight && $payment->status == 'accept') {
// $options1 = '  <button id="factur' . $id_prestation . '" class="green btn payment" onclick="facturebutton(\'' . $payment->id . '\', \'' . $id_prestation . '\')"  ><i class="fa fa-check"></i> ' . lang('facturer') . '</button>';
//    $options4 = '  <button id="depot' . $payment->id . '" class="green btn depositbutton payment" onclick="depositbutton(' . $payment->id . ')"  data-payment="' . $payment->id . '" data-patient="' . $payment->patient . '" style="" ><i class="fa fa-plus-circle"></i> ' . lang('paye') . '</button>';
                        }
                        if ($code_service == 'labo') {
                            if ($payment->status != 'demander') {
                                if ($payment->status != 'new') {
                                    if ($payment->status != 'done') {
                                        if ($payment->status != 'pending') {

                                            if ($payment->etatlight && ($payment->status == "valid")) {

                                                $email_organisation_light_origine = $this->home_model->get_email_organisation($payment->organisation_light_origin);
                                                $id_organisation_light = $payment->organisation_light_origin;
                                                if ($this->ion_auth->in_group(array('Laboratorist', 'adminmedecin', 'Doctor', 'admin', 'Biologiste'))) {
                                                    $options1 .= '  <span class="sendlab" data-id="' . $payment->patient . "####" . $payment->id . "####" . $id_prestation . "####" . $code_service . "####" . $email_organisation_light_origine . "####" . $id_organisation_light . '"  ><button id="" class="green btn payment" style="background-color:#0F7D4F;"><i class="fa fa-envelope"></i> ' . lang("send") . '</button></span>';
                                                }
                                            }

                                            $options1 .= '  <span	 class="editlab" data-id="' . $payment->id . '"  onclick="editlab(' . $payment->id . ')" ><button id="" class="green btn payment"><i class="fa fa-eye"></i> ' . lang("report_") . '</button></span>';
                                        } else { // Solution temporaire jusqu'aux Résultats partiels (pour eviter ke le bouton ne saute au passage partiel aux status après Terminé (car si seuleemnt 1/x est au niveau suivant: status en pending à nouveau)
                                            $dataTabInner = explode(',', $payment->category_name);
                                            $all_ok = array();
                                            foreach ($dataTabInner as $valueInner) {
                                                $valueTabInner = explode('*', $valueInner);
                                                if (isset($valueTabInner[4])) {
                                                    $all_ok[] = $valueTabInner[4] != 0 && $valueTabInner[4] != 1 && $valueTabInner[4] != 2 ? 'true' : 'false';
                                                }
                                            }
                                            if (!in_array('false', $all_ok)) {
                                                $options1 .= '  <span	 class="editlab" data-id="' . $payment->id . '"  onclick="editlab(' . $payment->id . ')" ><button id="" class="green btn payment"><i class="fa fa-eye"></i> ' . lang("report_") . '</button></span>';
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        $options1 = '<span>  ' . $options1 . ' </span>';
                        if (isset($valueTab[4]) && isset($current_prestation)) {

                            $info[] = array(
                                'status1' => $status1, 'id' => $payment->id, 'code' => $payment->code . '' . $current_prestation->id,
                                'date' => $date,
                                'patient' => '<button class="btn btn-link" style ="background:white;" onclick="infosPatient(' . $payment->patient . ')"><span  class="inffo" data-id="' . $payment->patient . '" >' . $payment->name . ' ' . $payment->last_name . '</span></button>',
                                'name_service' => $current_prestation->name_service,
                                'prestation' => $current_prestation->prestation,
                                'status' => '<span id="status-change' . $id_prestation . '">' . $status . '</span>',
                                'options' => $options1
                            );
                        }
                    }
                    if ($valueTab[5] == 'lab') {
                        $lab_details = $this->lab_model->getLabTestImportedById($valueTab[0]);
                        $data['lab_details'] = $this->lab_model->getLabTestImportedById($valueTab[0]);
                        $nameLab = isset($data['lab_details']->name) && $data['lab_details']->name != null ? $data['lab_details']->name : "";
                        $specialityLab = isset($data['lab_details']->speciality) && $data['lab_details']->speciality != null ? $data['lab_details']->speciality : "";


                        $report_exist = $this->lab_model->getLabReportByPaymentByLabId($payment->id, $valueTab[0]);
                        if (empty($report_exist)) {
                            $status = '<span class="status-p bg-primary">' . lang('pending_') . '</span>';
                            // 'adminmedecin', 'Assistant',
                            if ($this->ion_auth->in_group(array('Laboratorist', 'Biologiste'))) {
                                $options1 = '  <a id="done' . $valueTab[0] . '" class="green btn payment" href="lab/addReport?patient_id=' . $payment->patient . '&payment=' . $payment->id . '&lab_id=' . $valueTab[0] . '"><i class="fa fa-hourglass-half"></i> ' . lang('add_report') . '</a>';
                           $options2=' ';
                                } else {
                                $options1 = ' ';
                                $options2=' ';
                            }
                        } else {
                            if (empty($report_exist->transfer)) {
                                $status = '<span class="status-p bg-primary">' . lang('done_') . '</span>';
                                $options2 = '  <a id="done' . $valueTab[0] . '" class="green btn payment" href="lab/addReport?patient_id=' . $payment->patient . '&payment=' . $payment->id . '&lab_id=' . $valueTab[0] . '&report_id=' . $report_exist->id . '"><i class="fa fa-edit"></i> ' . lang('edit_report') . '</a>';
                                $options1 = '  <a id="done' . $valueTab[0] . '" class="green btn payment" href="lab/reportView?id=' . $report_exist->id . '"><i class="fa fa-eye"></i> ' . lang('view_report') . '</a>';
                            } else {
                                $status = '<span class="status-p bg-primary">' . lang('send_') . '</span>';
                                $options1 = '  <a id="done' . $valueTab[0] . '" class="green btn payment" href="lab/reportView?id=' . $report_exist->id . '"><i class="fa fa-eye"></i> ' . lang('view_report') . '</a>';
                            
                                $options2=' ';
                            }
                        }

                        $options11 = '<span>  ' . $options2 . ' '.$options1.' </span>';
                      
                        if (isset($valueTab[4])) {
                      
                            $info[] = array(
                                'status1' => 'pending', 'id' => $payment->id, 'code' => $payment->code . '' . $valueTab[0],
                                'date' => $date,
                                'patient' => '<button class="btn btn-link" style ="background:white;" onclick="infosPatient(' . $payment->patient . ')"><span  class="inffo" data-id="' . $payment->patient . '" >' . $payment->name . ' ' . $payment->last_name . '</span></button>',
                                'name_service' => $nameLab,
                                'prestation' => $specialityLab,
                                'status' => '<span id="status-change_lab' . $valueTab[0] . '">' . $status . '</span>',
                                'options' => $options11
                            );
                        }
                    }
                }
            }
        }



        return array('info' => $info, 'count_pending' => $count_pending, 'count_done' => $count_done, 'count_valid' => $count_valid, 'count_finish' => $count_finish);
    }

    function afficherBulltin() {
        $id = $this->input->get('id');
        $dataTab1 = $this->finance_model->afficherBulletin($id, $this->id_organisation);

        echo json_encode($dataTab1);
    }

    function previousInvoice() {
        $id = $this->input->get('id');
        $data1 = $this->finance_model->getFirstRowPaymentByIdByOrganisation($this->id_organisation);
        if ($id == $data1->id) {
            $data = $this->finance_model->getLastRowPaymentByIdByOrganisation($this->id_organisation);
            redirect('finance/invoice?id=' . $data->id);
        } else {
            for ($id1 = $id - 1; $id1 >= $data1->id; $id1--) {

                $data = $this->finance_model->getPreviousPaymentByIdByOrganisation($id1, $this->id_organisation);
                if (!empty($data)) {
                    redirect('finance/invoice?id=' . $data->id);
                    break;
                } elseif ($id1 == $data1->id) {
                    $data = $this->finance_model->getLastRowPaymentByIdByOrganisation($this->id_organisation);
                    redirect('finance/invoice?id=' . $data->id);
                } else {
                    continue;
                }
            }
        }
    }

    function nextInvoice() {
        $id = $this->input->get('id');

        $data1 = $this->finance_model->getLastRowPaymentByIdByOrganisation($this->id_organisation);
//  echo $data1->id;
//  echo $id;
//  die();
//$id1 = $id + 1;
        if ($id == $data1->id) {
            $data = $this->finance_model->getFirstRowPaymentByIdByOrganisation($this->id_organisation);
            redirect('finance/invoice?id=' . $data->id);
        } else {
            for ($id1 = $id + 1; $id1 <= $data1->id; $id1++) {

                $data = $this->finance_model->getNextPaymentByIdByOrganisation($id1, $this->id_organisation);

                if (!empty($data)) {
                    redirect('finance/invoice?id=' . $data->id);
                    break;
                } elseif ($id1 == $data1->id) {
                    $data = $this->finance_model->getFirstRowPaymentByIdByOrganisation($this->id_organisation);
                    redirect('finance/invoice?id=' . $data->id);
                } else {
                    continue;
                }
            }
        }
    }

    function daily() {
        $data = array();
        $year = $this->input->get('year');
        $month = $this->input->get('month');

        if (empty($year)) {
            $year = date('Y');
        }
        if (empty($month)) {
            $month = date('m');
        }

        $first_minute = mktime(0, 0, 0, $month, 1, $year);
        $last_minute = mktime(23, 59, 59, $month, date("t", $first_minute), $year);

        $payments = $this->finance_model->getPaymentByDate($first_minute, $last_minute, $this->id_organisation);
        $all_payments = array();
        foreach ($payments as $payment) {
            $date = date('D d-m-y', $payment->date);
            if (array_key_exists($date, $all_payments)) {
                $all_payments[$date] = $all_payments[$date] + $payment->deposited_amount;
            } else {
                $all_payments[$date] = $payment->deposited_amount;
            }
        }

        $data['year'] = $year;
        $data['month'] = $month;
        $data['first_minute'] = $first_minute;
        $data['last_minute'] = $last_minute;
        $data['all_payments'] = $all_payments;
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('daily', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function dailyExpense() {
        $data = array();
        $year = $this->input->get('year');
        $month = $this->input->get('month');

        if (empty($year)) {
            $year = date('Y');
        }
        if (empty($month)) {
            $month = date('m');
        }

        $first_minute = mktime(0, 0, 0, $month, 1, $year);
        $last_minute = mktime(23, 59, 59, $month, date("t", $first_minute), $year);

        $expenses = $this->finance_model->getExpenseByDate($first_minute, $last_minute, $this->id_organisation);
        $all_expenses = array();
        foreach ($expenses as $expense) {
            $date = date('D d-m-y', $expense->date);
            if (array_key_exists($date, $all_expenses)) {
                $all_expenses[$date] = $all_expenses[$date] + $expense->amount;
            } else {
                $all_expenses[$date] = $expense->amount;
            }
        }

        $data['year'] = $year;
        $data['month'] = $month;
        $data['first_minute'] = $first_minute;
        $data['last_minute'] = $last_minute;
        $data['all_expenses'] = $all_expenses;
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('daily_expense', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function monthly() {
        $data = array();
        $year = $this->input->get('year');

        if (empty($year)) {
            $year = date('Y');
        }


        $first_minute = mktime(0, 0, 0, 1, 1, $year);
        $last_minute = mktime(23, 59, 59, 12, 31, $year);

        $payments = $this->finance_model->getPaymentByDate($first_minute, $last_minute, $this->id_organisation);
        $all_payments = array();
        foreach ($payments as $payment) {
            $month = date('m-Y', $payment->date);
            if (array_key_exists($month, $all_payments)) {
                $all_payments[$month] = $all_payments[$month] + $payment->deposited_amount;
            } else {
                $all_payments[$month] = $payment->deposited_amount;
            }
        }

        $data['year'] = $year;
        $data['first_minute'] = $first_minute;
        $data['last_minute'] = $last_minute;
        $data['all_payments'] = $all_payments;
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $data['organisation'] = $this->home_model->getOrganisationById($this->id_organisation);

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('monthly', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function monthlyExpense() {
        $data = array();
        $year = $this->input->get('year');

        if (empty($year)) {
            $year = date('Y');
        }


        $first_minute = mktime(0, 0, 0, 1, 1, $year);
        $last_minute = mktime(23, 59, 59, 12, 31, $year);

        $expenses = $this->finance_model->getExpenseByDate($first_minute, $last_minute, $this->id_organisation);
        $all_expenses = array();
        foreach ($expenses as $expense) {
            $month = date('m-Y', $expense->date);
            if (array_key_exists($month, $all_expenses)) {
                $all_expenses[$month] = $all_expenses[$month] + $expense->amount;
            } else {
                $all_expenses[$month] = $expense->amount;
            }
        }

        $data['year'] = $year;
        $data['first_minute'] = $first_minute;
        $data['last_minute'] = $last_minute;
        $data['all_expenses'] = $all_expenses;
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('monthly_expense', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function editCategoryServiceByJason() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $id = $this->input->get('id');
        $tab = $this->finance_model->editCategoryServiceByJason($id, $this->id_organisation);

        echo json_encode($tab);
    }

    function editMutuelleFinanceByJason() {
        $id = $this->input->get('patient');
        $id_service_specialite_organisation = $this->input->get('id_service_specialite_organisation');
        $id_assurance = $this->input->get('id_assurance');
        $search = $this->input->get('search');
        $from = $this->input->get('from');
        $id_service_specialite_organisation = intval($id_service_specialite_organisation);
        if ($from == 'service') {
            if (!empty($id_service_specialite_organisation)) {
                $data['services'] = $this->service_model->getPrestationsServiceOrganisationByJson($id_service_specialite_organisation, $id_assurance);
            } else {
// $data['temoin'] = $id_assurance;
                $data['services'] = $this->service_model->getPrestationsSansService($id_assurance, $this->id_organisation, $search);
            }
        } else {

            if (!empty($id_service_specialite_organisation)) {
                $data['labs'] = $this->lab_model->getPrestationsLabOrganisationByJson($this->id_organisation, $id_service_specialite_organisation, $id_assurance);
            } else {
// $data['temoin'] = $id_assurance;
                $data['labs'] = $this->lab_model->getMasterLabByOrganisation($this->id_organisation, $id_service_specialite_organisation, $search);
            }
        }

        $data['patient'] = $this->patient_model->getPatientById($id, $this->id_organisation);
        $data['mutuelles'] = $this->patient_model->getMutuelle($id, $this->id_organisation);
        $data['mutuelles_relation'] = $this->patient_model->getPatientByIdParent($id, $this->id_organisation);
        $data['mutuellesInit'] = array();
        $data['lien_parente'] = '';
        $data['mutuelles_relationInit'] = array();
        if ($data['patient']->parent_id) {
            $data['mutuellesInit'] = $this->patient_model->getMutuelle($data['patient']->parent_id, $this->id_organisation);
            $data['mutuelles_relationInit'] = $this->patient_model->getPatientById($data['patient']->parent_id, $this->id_organisation);
            $lien_parente = "Autres";
            if ($data['patient']->lien_parente == "Pere") {
                $lien_parente = "Enfant";
            } else if ($data['patient']->lien_parente == "Mere") {
                $lien_parente = "Enfant";
            } else if ($data['patient']->lien_parente == "Enfant") {
                $lien_parente = "Parent";
            }
            $data['lien_parente'] = $lien_parente;
        }

        if (!empty($id_service_specialite_organisation)) {
            $data['services'] = $this->service_model->getPrestationsServiceOrganisationByJson($id_service_specialite_organisation, $id_assurance);
            $data['labs'] = $this->lab_model->getPrestationsLabOrganisationByJson($this->id_organisation, $id_service_specialite_organisation, $id_assurance);
        } else {
            $id_assurance = isset($data['mutuelles']->pm_idmutuelle) && $data['mutuelles']->pm_idmutuelle != null ? $data['mutuelles']->pm_idmutuelle : 0;
// On recupére
            $data['services'] = $this->service_model->getPrestationsSansService($id_assurance, $this->id_organisation, $search);
            $data['labs'] = $this->lab_model->getMasterLabByOrganisation($this->id_organisation, $id_service_specialite_organisation, $search);
        }

        echo json_encode($data);
    }

    function editMutuelleImagerieFinanceByJason() {
        $id = $this->input->get('patient');
        $id_service_specialite_organisation = $this->input->get('id_service_specialite_organisation');
        $id_assurance = $this->input->get('id_assurance');
        $search = $this->input->get('search');

        $id_service_specialite_organisation = intval($id_service_specialite_organisation);
        if (!empty($id_service_specialite_organisation)) {
            $data['services'] = $this->service_model->getPrestationsImagerieServiceOrganisationByJson($id_service_specialite_organisation, $id_assurance);
        } else {
// $data['temoin'] = $id_assurance;
            $data['services'] = $this->service_model->getPrestationsImagerieSansService($id_assurance, $this->id_organisation, $search);
        }
        $data['patient'] = $this->patient_model->getPatientById($id, $this->id_organisation);
        $data['mutuelles'] = $this->patient_model->getMutuelle($id, $this->id_organisation);
        $data['mutuelles_relation'] = $this->patient_model->getPatientByIdParent($id, $this->id_organisation);
        $data['mutuellesInit'] = array();
        $data['lien_parente'] = '';
        $data['mutuelles_relationInit'] = array();
        if ($data['patient']->parent_id) {
            $data['mutuellesInit'] = $this->patient_model->getMutuelle($data['patient']->parent_id, $this->id_organisation);
            $data['mutuelles_relationInit'] = $this->patient_model->getPatientById($data['patient']->parent_id, $this->id_organisation);
            $lien_parente = "Autres";
            if ($data['patient']->lien_parente == "Pere") {
                $lien_parente = "Enfant";
            } else if ($data['patient']->lien_parente == "Mere") {
                $lien_parente = "Enfant";
            } else if ($data['patient']->lien_parente == "Enfant") {
                $lien_parente = "Parent";
            }
            $data['lien_parente'] = $lien_parente;
        }

        if (!empty($id_service_specialite_organisation)) {
            $data['services'] = $this->service_model->getPrestationsImagerieServiceOrganisationByJson($id_service_specialite_organisation, $id_assurance);
        } else {
            $id_assurance = isset($data['mutuelles']->pm_idmutuelle) && $data['mutuelles']->pm_idmutuelle != null ? $data['mutuelles']->pm_idmutuelle : 0;
// On recupére
            $data['services'] = $this->service_model->getPrestationsImagerieSansService($id_assurance, $this->id_organisation, $search);
        }

        echo json_encode($data);
    }

    function editImagerieMutuelleFinanceByJason() {
        $id = $this->input->get('patient');
        $id_service_specialite_organisation = $this->input->get('id_service_specialite_organisation');
        $id_assurance = $this->input->get('id_assurance');
        $search = $this->input->get('search');

        $id_service_specialite_organisation = intval($id_service_specialite_organisation);
        if (!empty($id_service_specialite_organisation)) {
            $data['services'] = $this->service_model->getPrestationsImagerieServiceOrganisationByJson($id_service_specialite_organisation, $id_assurance);
        } else {
// $data['temoin'] = $id_assurance;
            $data['services'] = $this->service_model->getPrestationsImagerieSansService($id_assurance, $this->id_organisation, $search);
        }
        $data['patient'] = $this->patient_model->getPatientById($id, $this->id_organisation);
        $data['mutuelles'] = $this->patient_model->getMutuelle($id, $this->id_organisation);
        $data['mutuelles_relation'] = $this->patient_model->getPatientByIdParent($id, $this->id_organisation);
        $data['mutuellesInit'] = array();
        $data['lien_parente'] = '';
        $data['mutuelles_relationInit'] = array();
        if ($data['patient']->parent_id) {
            $data['mutuellesInit'] = $this->patient_model->getMutuelle($data['patient']->parent_id, $this->id_organisation);
            $data['mutuelles_relationInit'] = $this->patient_model->getPatientById($data['patient']->parent_id, $this->id_organisation);
            $lien_parente = "Autres";
            if ($data['patient']->lien_parente == "Pere") {
                $lien_parente = "Enfant";
            } else if ($data['patient']->lien_parente == "Mere") {
                $lien_parente = "Enfant";
            } else if ($data['patient']->lien_parente == "Enfant") {
                $lien_parente = "Parent";
            }
            $data['lien_parente'] = $lien_parente;
        }

        if (!empty($id_service_specialite_organisation)) {
            $data['services'] = $this->service_model->getPrestationsImagerieServiceOrganisationByJson($id_service_specialite_organisation, $id_assurance);
        } else {
            $id_assurance = isset($data['mutuelles']->pm_idmutuelle) && $data['mutuelles']->pm_idmutuelle != null ? $data['mutuelles']->pm_idmutuelle : 0;
// On recupére
            $data['services'] = $this->service_model->getPrestationsImagerieSansService($id_assurance, $this->id_organisation, $search);
        }

        echo json_encode($data);
    }

// function estCouverteDansPartenariatAssurance()
// {
// $id_assurance = $this->input->get('id_assurance');
// $id_organisation = $this->id_organisation;
// $id_prestation = $this->input->get('id_prestation');
// $data['est_couverte'] = $this->service_model->estCouverteDansPartenariatAssurance($id_assurance, $id_organisation, $id_prestation);
// echo json_encode($data);
// }

    function editTproFinanceByJason() {
        $organisation = $this->input->get('organisation');
        $search = $this->input->get('search');
        $from = $this->input->get('from');
        $id_organisation = intval($this->input->get('id_organisation'));
// $service = $this->input->get('service');
        $id_service_specialite_organisation = intval($this->input->get('id_service_specialite_organisation'));
// $data['services'] = $this->finance_model->editCategoryServiceByJason($service, $organisation);
        $data = array();

        if (!empty($id_service_specialite_organisation)) {
            $data['services'] = $this->service_model->getPrestationsServiceOrganisationByJson($id_service_specialite_organisation);
            $data['labs'] = $this->lab_model->getPrestationsLabOrganisationByJson($id_service_specialite_organisation, $id_assurance);
        } else {
            $id_assurance = 0;
            if ($id_organisation) {
                $data['services'] = $this->service_model->getPrestationsSansService($id_assurance, $id_organisation, $search);
                $data['labs'] = $this->lab_model->getMasterLabByOrganisation($this->id_organisation, $search);
            }
        }


        echo json_encode($data);
    }

    function editTproFinanceByJasonParametre() {
        $prestation = $this->input->get('prestation');
        $data['prestations'] = $this->finance_model->editCategoryServiceByJasonParametre($prestation);
        echo json_encode($data);
    }

    function checkDepotOM() {
        $deposited_amount_old = $this->input->post('deposited_amount');
        $invoice_id = $this->input->post('paymentid');
        $redirect = $this->input->post('redirect');
        $refMobRef = $this->input->post('refMobRef');
        $patient = $this->input->post('patient');
        $idtransaction = $this->input->post('idtransaction');
        $refNumOM = $this->input->post('refNumOM');
        $statut_deposit = $this->input->post('statut_deposit');
        $p_name = $this->input->post('name');
        $p_lastName = $this->input->post('lastname');
        $p_id = $this->input->post('patientId');

        $payment = $this->finance_model->getPaymentById($invoice_id, $this->id_organisation);

        $date = time();
        $user = $this->ion_auth->get_user_id();

        $deposit_type = 'OrangeMoney';
        $deposited_amount = intval($deposited_amount_old) + intval($payment->amount_received);

        if ($payment->gross_total < $deposited_amount) {
            $this->session->set_flashdata('feedback', lang('erreur_max_depot'));

            redirect($redirect);
        }


        $data_amount_received = array('status_paid' => 'unpaid');
        $this->finance_model->updatePayment($invoice_id, $data_amount_received, $this->id_organisation);

        $data1 = array(
            'date' => $date,
            'patient' => $patient,
            'deposited_amount' => $deposited_amount_old,
            'payment_id' => $invoice_id,
            'amount_received_id' => '',
            'deposit_type' => $deposit_type,
            'id_organisation' => $this->id_organisation,
            'statut_deposit' => 'PENDING',
            'user' => $user,
            'id_transaction_externe' => $idtransaction,
            'ref_om' => $refMobRef,
            'numero_om' => $refNumOM,
        );
        $this->finance_model->insertDepositOM($data1);

        $this->session->set_flashdata('feedback', lang('updated'));

        redirect($redirect);
    }

    function checkDepot() {
        $deposited_amount_old = $this->input->post('deposited_amount');
        $invoice_id = $this->input->post('paymentid');
        $redirect = $this->input->post('redirect');
        $patient = $this->input->post('patient');
        $p_name = $this->input->post('name');
        $p_lastName = $this->input->post('lastname');
        $p_id = $this->input->post('patientId');

        $payment = $this->finance_model->getPaymentById($invoice_id, $this->id_organisation);

        $date = time();
        $user = $this->ion_auth->get_user_id();

        $deposit_type = $this->input->post('deposit_type');
        $deposited_amount = intval($deposited_amount_old) + intval($payment->amount_received);
        if ($deposit_type === 'Cash') {


            if ($payment->gross_total < $deposited_amount) {
                $this->session->set_flashdata('feedback', lang('erreur_max_depot'));

                redirect($redirect);
            }

            $status_paid = 'unpaid';
            $status = $payment->status;

            if ($payment->gross_total == $deposited_amount) {
                $status_paid = 'paid';
                if ($payment->status == "demandpay") {
                    $status = "finish";
                    $this->changeStatusPrestationByFinance($payment->id, 4, 'all');
                }
            }
            /* $data = array('patient' => $patient,
              'date' => $date,
              'payment_id' => $invoice_id,
              'deposited_amount' => $deposited_amount,
              'deposit_type' => $deposit_type,
              'user' => $user
              );

              $this->finance_model->updateDeposit($invoice_id, $data, $this->id_organisation); */


            if ($payment->status == "new") {
                $data_amount_received = array('amount_received' => $deposited_amount, 'status' => 'pending', 'status_paid' => $status_paid);
                $this->changeStatusPrestationByFinance($invoice_id, 1, 'all');
            } else {
                $data_amount_received = array('amount_received' => $deposited_amount, 'status_paid' => $status_paid, 'status' => $status);
            }

            $this->finance_model->updatePayment($invoice_id, $data_amount_received, $this->id_organisation);

            $data1 = array(
                'date' => $date,
                'patient' => $patient,
                'deposited_amount' => $deposited_amount_old,
                'payment_id' => $invoice_id,
                'amount_received_id' => '',
                'deposit_type' => $deposit_type,
                'id_organisation' => $this->id_organisation,
                'user' => $user
            );
            $this->finance_model->insertDeposit($data1);

            $patient_details = $this->patient_model->getPatientById($patient, $this->id_organisation);
            $payment_details = $this->finance_model->getPaymentById($invoice_id);
            $data1Email = array(
                'name' => $patient_details->name . " " . $patient_details->last_name,
                'company' => $this->nom_organisation,
                'amount' => number_format($deposited_amount_old, 0, '', '.') . " FCFA",
                'payment_method' => $deposit_type,
                'montant_total' => number_format($payment_details->gross_total, 0, '', '.') . " FCFA",
                'total_depots' => number_format($payment_details->amount_received, 0, '', '.') . " FCFA",
                'restant' => number_format(($payment_details->gross_total - $payment_details->amount_received), 0, '', '.') . " FCFA"
            );
            $data1SMS = $data1Email;

// SMS
            $autosms = $this->sms_model->getAutoSmsByType('payment');
            $message = $autosms->message;
// $subject = $autosms->name;  
// $to = $patient_phone;

            $messageprint = $this->parser->parse_string($message, $data1SMS);
// Temp Special Chars / SMS
            $toReplace = array("é", "è", "à", "\r\n", "\r", "\n");
            $replaceBy = array("e", "e", "a", "", "", "");
            $dataInsert = array(
                'recipient' => $patient_details->phone,
                'message' => str_replace($toReplace, $replaceBy, $messageprint),
                'date' => time(),
                'user' => $this->ion_auth->get_user_id()
            );
            $this->sms_model->insertSms($dataInsert);

// Email	
// PRESTATIONS DE SANTÉ | PAIEMENT | {name} | {company}
// Cher {name},
// Vous avez effectué un paiement de {amount} via {payment_method} au profit de {company}.
// Montant total : {montant_total}
// Déjà payé : {total_depots}
// Solde à payer : {restant}
// Merci de votre confiance
// {company} via ecoMed24.

            $autoemail = $this->email_model->getAutoEmailByType('payment');
            $message1 = $autoemail->message;
            $subject = $this->parser->parse_string($autoemail->name, $data1Email);
            $messageprint2 = $this->parser->parse_string($message1, $data1Email);
            $dataInsertEmail = array(
                'reciepient' => $patient_details->email,
                'subject' => $subject,
                'message' => $messageprint2,
                'date' => time(),
                'user' => $this->ion_auth->get_user_id()
            );
            $this->email_model->insertEmail($dataInsertEmail);

            $this->session->set_flashdata('feedback', lang('updated'));

            redirect($redirect);
        } else if ($deposit_type === "OrangeMoney") {
            $data['depot'] = $deposited_amount_old;
            $data['paymentid'] = $invoice_id;
            $data['patient'] = $patient;
            $data['p_name'] = $p_name;
            $data['p_id'] = $p_id;
            $data['p_lastName'] = $p_lastName;
            $data['id_organisation'] = $this->id_organisation;
            $data['path_logo'] = $this->path_logo;
            $data['nom_organisation'] = $this->nom_organisation;
            $data['redirect'] = $redirect;
            $data['settings'] = $this->settings_model->getSettings();
            $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
            $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
            $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('depotom_new', $data);
            $this->load->view('home/footer');
        }
    }

    function editStatutPaiementByJasonPending() {
        $id = $this->input->get('id');
        $type = $this->input->get('type');
        $prestation = $this->input->get('prestation');
        $this->changeStatusPrestationByFinance($id, $type, $prestation);
        $patient = $this->finance_model->getPaymentById($id);
        $profil = false;
        if ($this->ion_auth->in_group(array('admin', 'Laboratorist', 'Assistant'))) {
            $profil = true;
        }

        echo json_encode(array('result' => true, 'profil' => $profil, 'patient' => $patient->patient));
    }

    function editStatutPaiementByJasonValid() {
        $id = $this->input->post('payment');
        $prestation = $this->input->post('prestation');
        $patient = $this->input->post('patient');
        $statut = 'Valider';
        $date = time();
        $date_string = date('d-m-Y H:i', $date);
        $data = array(
            'id_payment' => $id,
            'date' => $date,
            'id_prestation' => $prestation,
            'statut' => $statut,
            'date_string' => $date_string,
            'user' => $this->ion_auth->get_user_id(),
        );
        $this->finance_model->insertExecute_user($data);
// $redirect = $this->input->post('redirect');
        $this->changeStatusPrestationByFinance($id, 3, $prestation);
        $this->lab_model->updateLabDataPaiement2($prestation, $id, array('status' => 3));

        /* $redirect = 'finance/getValidIBydActe?mode=on&id=' . $patient . '&payment=' . $id . '&prestation=' . $prestation . '';
          redirect($redirect); */
        redirect('finance/paymentLabo');
    }

    function editStatutPaiementByJasonReprendre() {
        $id = $this->input->post('payment');
        $prestation = $this->input->post('prestation');
        $patient = $this->input->post('patient');
        $resultats = $this->input->post('resultats');
        $param = $this->input->post('idParam');
        $codes = $this->input->post('codes');
        foreach ($param as $key => $singleLabData) {
// Insertion dans lab_data
// id, id_lab, idPaymentConcatRelevantCategoryPart, prestation, code, resultats, unite, valeurs 
            $status = 1;
            if ($resultats[$key]) {
                $status = 2;
            }
            $labData = array(
                "resultats" => $resultats[$key],
                "status" => $status,
            );
            $idLab = $id;
            $payment = $codes[$key];
// $idPrestation = $idPrestation[$key];  
            $this->lab_model->updateLabDataPaiement($param[$key], $payment, $labData);
        }
// $redirect = $this->input->post('redirect');
// $this->changeStatusPrestationByFinance($id, 2, $prestation);
// $this->lab_model->updateLabDataPaiement2($prestation, $id, array('status' => 2));
        /* $redirect = 'finance/getValidIBydActe?mode=on&id=' . $patient . '&payment=' . $id . '&prestation=' . $prestation . '';
          redirect($redirect); */
        $this->session->set_flashdata('feedback', lang('updated'));
        redirect('finance/paymentLabo');
    }

    function savePDFChunks() {
        $rnd = base64_encode($_POST['fileName']);
        $chunkNum = $_POST['chunkNum'];
        $pdf = base64_decode($_POST['pdfData']);
// $fname = "files/sent/" .$_POST['fileName'] . "_" . $rnd . ".pdf"; // name the file
        $fname = "files/sent/" . $_POST['fileName'] . ".pdf"; // name the file
        if ($chunkNum == "0") {
            $file = fopen($fname, 'w');
        } // open the file write
        else {
            $file = fopen($fname, 'a');
        } // append chunk
        fwrite($file, $pdf); //save data
        fclose($file);
        echo '{"file":"' . $fname . '", "chunkNum":"' . $chunkNum . '"}';
    }

    function sendEmailResultatsLight() {


// echo "<script language=\"javascript\">alert('Payment Made');</script>";		
        $requestData = $_REQUEST;
        $paymentId = $requestData["paymentId"];
        $emailLight = $requestData["emailLight"];
// $html = $requestData["html"];
        $name = $requestData["name"];

// ob_start();
        $html = $this->getEmailPrefix();
        $html .= $this->lab_model->getLabByPayment($paymentId)->report;
        $html .= "";
        try {
            $mpdf = new \Mpdf\Mpdf([
                'debug' => true,
                'allow_output_buffering' => true
            ]);
// $mpdf->debug = true;
            $data["html"] = $html;
// $render = $this->load->view("home/htmlToPDF", $data,false);
            $mpdf->WriteHTML($html);
// $mpdf->WriteHTML("<table><tr><td>HELLO WORLD</td></tr></table>");
            $mpdf->Output(FCPATH . 'files/sent/' . $name . ".pdf", \Mpdf\Output\Destination::FILE);
// $output = $mpdf->Output();
        } catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception 
//       name used for catch
// Process the exception, log, print etc.
// echo json_encode($e->getMessage());
        }
// file_put_contents(FCPATH . 'files/sent/'.$name.".pdf", $output);
// ob_end_clean();

        $attachment_path = FCPATH . 'files/sent/' . $name . ".pdf";
        $payment = $this->finance_model->getPaymentById($paymentId);
        $nom_organisation_prestataire = $this->home_model->get_nom_organisation($payment->id_organisation);
        $nro_commande = $payment->code;
        $patient_details = $this->patient_model->getPatientById($payment->patient, $payment->id_organisation);
        $patient_full_name = $patient_details->name . " " . $patient_details->last_name;
        $patient_id = $patient_details->patient_id;
// $nom_responsable_legal_organisation_light_origin = $this->home_model->get_champ_organisation($fied_name, $id_organisation)
        $nom_organisation_light_origin = $this->home_model->get_nom_organisation($payment->organisation_light_origin);
// $liste_prestations_nom_service_nom_prestation_date = "<p>";
        $liste_prestations_nom_service_nom_prestation_date = "";

        $date = date('d/m/Y H:i', $payment->date);
        $dataTab = explode(',', $payment->category_name);
        foreach ($dataTab as $value) {
            $valueTab = explode('*', $value);

            $id_prestation = $valueTab[0];
            $current_prestation = $this->finance_model->getPaymentCategoryByOrganisationById2($id_prestation);
            $liste_prestations_nom_service_nom_prestation_date .= "Code: " . $payment->code . '' . $current_prestation->id . " | " . "Date: " . $date . " | " . "Service: " . $current_prestation->name_service . " | " . "Prestation: " . $current_prestation->prestation . "<br/>";
        }
// $liste_prestations_nom_service_nom_prestation_date .= "</p>";

        $data1Email = array(
            'nom_organisation_prestataire' => $nom_organisation_prestataire,
            'nro_commande' => $nro_commande,
            'patient_full_name' => $patient_full_name,
            'patient_id' => $patient_id,
            // 'nom_responsable_legal_organisation_light_origin' => $nom_responsable_legal_organisation_light_origin,
            'nom_organisation_light_origin' => $nom_organisation_light_origin,
            'liste_prestations_nom_service_nom_prestation_date' => $liste_prestations_nom_service_nom_prestation_date
        );

        $autoemail = $this->email_model->getAutoEmailByType('resultat_analyses_light');

        $message1 = $autoemail->message;
        $subject = $this->parser->parse_string($autoemail->name, $data1Email, true);
        $messageprint2 = $this->parser->parse_string($message1, $data1Email, true);
        $dataInsertEmail = array(
            'reciepient' => $emailLight,
            'subject' => $subject,
            'message' => $messageprint2,
            'date' => time(),
            'user' => $this->ion_auth->get_user_id(),
            'attachment_path' => $attachment_path,
        );
        $this->email_model->insertEmail($dataInsertEmail);

        echo json_encode(true);
// echo json_encode("<script language=\"javascript\">alert('It's ok');</script>");
    }

// function sendEmailFactureLight() {
// echo "<script language=\"javascript\">alert('Payment Made');</script>";		
// }

    function editStatutPaiementByJasonAccept() {
        $id = $this->input->post('payment');
        $prestation = $this->input->post('prestation');
        $patient = $this->input->post('patient');
        $source = $this->input->post('source');
        $emailLight = $this->input->post('emailLight');
        $idOrganisationLight = $this->input->post('idOrganisationLight');
        $statut = 'Valider';
        $date = time();
        $date_string = date('d-m-Y H:i', $date);
        $data = array(
            'id_payment' => $id,
            'date' => $date,
            'id_prestation' => $prestation,
            'statut' => $statut,
            'date_string' => $date_string,
            'user' => $this->ion_auth->get_user_id(),
        );
        $this->finance_model->insertExecute_user($data);
//          $file_name = $_FILES['filenameLight']['name'];
//     $file_name_pieces = explode('_', $file_name);
//     $new_file_name = '';
//     $count = 1;
//     foreach ($file_name_pieces as $piece) {
//         if ($count !== 1) {
//             $piece = ucfirst($piece);
//         }
//         $new_file_name .= $piece;
//         $count++;
//     }
//     $config = array(
//         'file_name' => $new_file_name,
//         'upload_path' => "./uploads/",
//         'allowed_types' => "gif|jpg|png|jpeg|pdf",
//         'overwrite' => False,
//         'max_size' => "48000000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
//         'max_height' => "3000",
//         'max_width' => "2024"
//     );
//     $this->load->library('Upload', $config);
//     $this->upload->initialize($config);
//     $path = $this->upload->data();
//     $img_url = "uploads/" . $path['file_name'];
// var_dump($img_url);
// exit();
// $redirect = $this->input->post('redirect');
        /* $redirect = 'finance/validexterneBydActe?mode=on&id=' . $patient . '&payment=' . $id . '&prestation=' . $prestation . '';
          redirect($redirect); */
        if ($source == "sendlabLight") {
            $this->changeStatusPrestationByFinance($id, 5, 'all');
        } else {
            $this->changeStatusPrestationByFinance($id, 5, $prestation);
        }
        $data = array(
            'email' => $emailLight,
        );
        $this->finance_model->updateOrganisationLight($idOrganisationLight, $data);

        redirect('finance/paymentLabo');
    }

    function editStatutPaiementByJasonFinishByPrestation() {
        $id = $this->input->get('id');
        $prestation = $this->input->get('prestation');
        $this->changeStatusPrestationByFinance($id, 4, $prestation);
        echo json_encode(array('result' => true));
    }

    function editStatutPaiementByJasonFinish() {
        $id = $this->input->get('id');
        $type = $this->input->get('type');
        $this->finance_model->updatePayment($id, array("status" => "finish"));

        echo json_encode(array('result' => true));
    }

    function editStatutPaiementByJasonDone() {
        $id = $this->input->get('id');
        $type = $this->input->get('type');
        $data = $this->finance_model->getPaymentById($id);
        $patient = $data->patient;
        $patient_name = $data->patient_name;
        $date = date('d/m/Y H:i', $data->date);
        $dataTab = explode(',', $data->category_name);
        $result = ' ';
        $result .= "";
        $result_ss = "";
        foreach ($dataTab as $value) {
            $status = "";
            $valueTab = explode('*', $value);
            $id_prestation = $valueTab[0];

            $current_prestation = $this->finance_model->getPaymentCategoryByOrganisationById($id_prestation, $this->id_organisation);

            if ($valueTab[4] == '1') {
                $status = '<span class="status-p bg-primary">' . lang('pending_') . '</span>';
            } else if ($valueTab[4] == '2') {
                $status = '<span class="status-p bg-primary">' . lang('done_') . '</span>';
            } else if ($valueTab[4] == '3') {
                $status = '<span class="status-p bg-primary">' . lang('valid_') . '</span>';
            } else if ($valueTab[4] == '4') {
                $status = '<span class="status-p bg-success">' . lang('finish_') . '</span>';
            }

            $disable = '';
            if ($valueTab[4] == 1 && $status) {
// $result .= ' <div class="modal-dialog">';
                $result .= '<tr>'
                        . '<td><input type="checkbox" onchange="toggleSelect(' . $id_prestation . ')" class="statusPresta"  name="check' . $id_prestation . '" id="check' . $id_prestation . '" value="' . $value . '" ></td>'
                        . ' <td>' . $date . '</td>'
                        . '<td>' . $patient_name . '</td>'
                        . '<td>' . $current_prestation->name_service . '</td>'
                        . '<td>' . $current_prestation->prestation . '</td>'
                        . '<td>' . $status . '</td>'
                        . '</tr>';
            } else {
                $result .= '<tr class="opac">'
                        . '<td></td>'
                        . ' <td>' . $date . '</td>'
                        . '<td>' . $patient_name . '</td>'
                        . '<td>' . $current_prestation->name_service . '</td>'
                        . '<td>' . $current_prestation->prestation . '</td>'
                        . '<td>' . $status . '</td>'
                        . '</tr>';
            }
        }


        echo json_encode(array('result' => $result));
    }

    function changeStatusPrestation() {
        $payment = $this->input->post('payment');
        $type = $this->input->post('type');
        $checktAB = $this->input->post('idPrestation');
        $this->changeStatusPrestationByFinance($payment, $type, $checktAB);
        redirect('finance/payment');
    }

    function changeStatusPrestationByFinance($payment, $type, $idPrestation) {

        $category_name = $this->finance_model->getPaymentById($payment)->category_name;

        $checktABnewTab = explode(',', $category_name);
        $valuenew = array();
        foreach ($checktABnewTab as $value) {
            $checktABnewTab = explode('*', $value);
            $id = intval($checktABnewTab[0]);
// $valuenew .= implode("*", $checktABnewTab2).','; 
            if (is_array($checktABnewTab) && count($checktABnewTab) > 3) {
                if ($idPrestation == '' || $idPrestation == 'all') {
                    $check = $checktABnewTab[0] . '*' . $checktABnewTab[1] . '*' . $checktABnewTab[2] . '*' . $checktABnewTab[3] . '*' . $type;
                    $category_name = str_replace($value, $check, $category_name);
                } else {
                    if ($idPrestation == $id) {
                        $check = $checktABnewTab[0] . '*' . $checktABnewTab[1] . '*' . $checktABnewTab[2] . '*' . $checktABnewTab[3] . '*' . $type;
                        $category_name = str_replace($value, $check, $category_name);
                    } else {
                        $check = $checktABnewTab[0] . '*' . $checktABnewTab[1] . '*' . $checktABnewTab[2] . '*' . $checktABnewTab[3] . '*' . $checktABnewTab[4];
                    }
                }
//  }
                $valuenew[] = $check;
            }
        }
        $valueFinish = implode(",", $valuenew);
        /* / } else {
          $category_name = str_replace('*1*0', '*1*1', $category_name);
          } */

//var_dump($category_name);  // exit();
        $this->finance_model->updatePayment($payment, array("category_name" => $category_name));

        if ($type == 2) {
            $sql = "select count(*) as total from payment where id =" . $payment . " and (category_name like '%*%*%*%*%0' or category_name like '%*%*%*%*%1' or category_name like '%*%*%*%*%3' or category_name like '%*%*%*%*%4' or category_name like '%*%*%*%*%5')";
// var_dump($sql);

            $query = $this->db->query($sql);
            $num = intval($query->row()->total);            // var_dump($num); //exit();
            if (empty($num)) {

                $this->finance_model->updatePayment($payment, array("status" => "done", "status_presta" => "finish"));
            } else {
                $this->finance_model->updatePayment($payment, array("status" => "pending", "status_presta" => "pending"));
            }
        } else if ($type == 3) {
            $sql = "select count(*) as total from payment where id =" . $payment . " and (category_name like '%*%*%*%*%0' or category_name like '%*%*%*%*%1' or category_name like '%*%*%*%*%2' or category_name like '%*%*%*%*%4' or category_name like '%*%*%*%*%5')";

            $query = $this->db->query($sql);
            $num = intval($query->row()->total);
            if (empty($num)) {
                $this->finance_model->updatePayment($payment, array("status" => "valid", "status_presta" => "finish"));
                $t_labo = $this->finance_model->getPaymentByIdByservice($payment);
//  if ($t_labo->code_service == 'labo') {
                $this->generateRapport($payment);
//  }
            } else {
                $this->finance_model->updatePayment($payment, array("status" => "pending", "status_presta" => "pending"));
            }
        } else if ($type == 1) {
            $sql = "select count(*) as total from payment where id =" . $payment . " and (category_name like '%*%*%*%*%0' or category_name like '%*%*%*%*%2' or category_name like '%*%*%*%*%3' or category_name like '%*%*%*%*%4' or category_name like '%*%*%*%*%5')  ";
// var_dump($sql);
            $query = $this->db->query($sql);
            $num = $query->row()->total;
            if (!empty($num)) {

                $this->finance_model->updatePayment($payment, array("status" => "new", "status_presta" => "pending"));
            } else {
                $this->finance_model->updatePayment($payment, array("status" => "pending", "status_presta" => "finish"));
            }
        } else if ($type == 4) {
            $sql = "select count(*) as total from payment where id =" . $payment . " and  (category_name like '%*%*%*%*%0' or category_name like '%*%*%*%*%1' or category_name like '%*%*%*%*%2' or category_name like '%*%*%*%*%3' or category_name like '%*%*%*%*%5') ";
            $query = $this->db->query($sql); //var_dump($sql);
            $num = $query->row()->total;    // var_dump($num);   exit();
            if (empty($num)) {
                $this->finance_model->updatePayment($payment, array("status" => "finish", "status_presta" => "finish"));
            } else {
                $this->finance_model->updatePayment($payment, array("status" => "pending", "status_presta" => "pending"));
            }
        } else if ($type == 5) {
            $sql = "select count(*) as total from payment where id =" . $payment . " and  (category_name like '%*%*%*%*%0' or category_name like '%*%*%*%*%1' or category_name like '%*%*%*%*%2' or category_name like '%*%*%*%*%3' or category_name like '%*%*%*%*%4') ";
            $query = $this->db->query($sql); //var_dump($sql);
            $num = $query->row()->total;    // var_dump($num);   exit();
            if (empty($num)) {
                $this->finance_model->updatePayment($payment, array("status" => "accept", "status_presta" => "finish"));
            } else {
                $this->finance_model->updatePayment($payment, array("status" => "pending", "status_presta" => "pending"));
            }
        } else if ($type == 6) {

            $this->finance_model->updatePayment($payment, array("status" => "demandpay", "status_presta" => "finish"));
        }
    }

    public function rapport() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['settings'] = $this->settings_model->getSettings();
        $data['expenses'] = $this->finance_model->getExpense($this->id_organisation);
        $data['dd'] = $this->finance_model->getExpense($this->id_organisation);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('rapport', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function getPendingIBydActe() {
        $requestData = $_REQUEST;
        $id = $requestData["id"];
        $prestation = $requestData["prestation"];
        $payment = $requestData["payment"];
        $name_service = isset($requestData["nameservice"]) && $requestData["nameservice"] != null ? $requestData["nameservice"] : null;
        $modele = isset($requestData["modele"]) && $requestData["modele"] != null ? $requestData["modele"] : null;

        if (isset($requestData["service"])) {
            $service = $requestData["service"];
        }



        $data['patient'] = $this->patient_model->getPatientById($id, $this->id_organisation);
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['entete'] = $this->entete;
        $data['prestation'] = $prestation;
        $data['settings'] = $this->settings_model->getSettings();
        $data['prestations'] = $this->finance_model->getPrestationId($prestation, $this->id_organisation);
        $data['payments'] = $this->finance_model->getPaymentId($payment, $this->id_organisation);
        $id_spec = $data['prestations']->id_spe;
        $data['listeResultats'] = $this->finance_model->listeResultatPrestationId($id_spec);
        if (!empty($data['payments']->prescripteur)) {
            $doctor_details = $this->home_model->getUserById($data['payments']->prescripteur);
            $data['doctor'] = $doctor_details;
        }
        if ($prestation) {
            $data['lab'] = $this->finance_model->existResultats($payment, $prestation);
            $data['idlab'] = $this->finance_model->existResultatsLab($payment);
        }
        $this->load->view('home/dashboard', $data);
        if (isset($service) && $service == 'labo' && $data['prestations']->prestation == 'EXAMEN MICROBIO URINES (ECBU)') {
// var_dump($data);
            $this->load->view('analyse_ECBU', $data);
        } else if (isset($service) && $service == 'labo' && $data['prestations']->prestation == 'PRELEVEMENT VAGINAL') {
// var_dump($data);
            $this->load->view('prelevement_vaginal', $data);
        } else if (isset($service) && $service == 'labo' && $data['prestations']->prestation == 'EXAMEN MYCOLOGIQUE') {
// var_dump($data);
            $this->load->view('examen_mycologique', $data);
        } else if (isset($service) && $service == 'labo' && $data['prestations']->prestation == 'COPROCULTURE') {
// var_dump($data);
            $this->load->view('coproculture', $data);
        } else if (isset($service) && $service == 'labo' && $modele == 0) {
            $this->load->view('lab/lab_acte', $data);
        } else if (isset($service) && $service == 'labo' && $modele != 0) {
            $data['template'] = $this->lab_model->getTemplateById($modele);
            $this->load->view('modele_resultat', $data);
        } else {
            $data['template'] = $this->lab_model->getTemplateById(51);
            $data['service_name'] = $name_service;

            $this->load->view('consultation_medical', $data);
        }
        $this->load->view('home/footer');
    }

    function getReprendreIBydActe() {
        $requestData = $_REQUEST;
        $id = $requestData["id"];
        $prestation = $requestData["prestation"];
        $payment = $requestData["payment"];
        $service = '';
        $modele = isset($requestData["modele"]) && $requestData["modele"] != null ? $requestData["modele"] : null;
        if (isset($requestData["service"])) {
            $service = $requestData["service"];
        }



        $data['patient'] = $this->patient_model->getPatientById($id, $this->id_organisation);
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['prestation'] = $prestation;
        $data['settings'] = $this->settings_model->getSettings();
        $data['prestations'] = $this->finance_model->getPrestationId($prestation, $this->id_organisation);
        $data['payments'] = $this->finance_model->getPaymentId($payment, $this->id_organisation);
        if ($prestation) {
            $data['lab'] = $this->finance_model->existResultats($payment, $prestation);
            $data['idlab'] = $this->finance_model->existResultatsLab($payment);
        }
        $this->load->view('home/dashboard', $data);
        if (isset($service) && $service == 'labo' && $modele == 0) {
            $this->load->view('lab/reprendre_acte_valid', $data);
        } else if (isset($service) && $service == 'labo' && $modele != 0) {
            $data['lab'] = $this->finance_model->existResultats($payment, $prestation);
            $this->load->view('lab/reprendre_modele_valid', $data);
        } else {

            $this->load->view('consultation_medical', $data);
        }
        $this->load->view('home/footer');
    }

    function addMedicalHistory() {
        $id = $this->input->post('id');
        $patient_id = $this->input->post('patient_id');

        $date = $this->input->post('date');
        $date_string = $this->input->post('date_string');
        $title = $this->input->post('title');
        $payment_id = $this->input->post('payment_id');
        $code = $this->input->post('code');
        $prestation = $this->input->post('prestation');
        $specialite = $this->input->post('specialite');
        $namePrestation = $this->input->post('namePrestation');
        $poids = $this->input->post('poids');
        $taille = $this->input->post('taille');
        $temperature = $this->input->post('temperature');
        $frequenceRespiratoire = $this->input->post('frequenceRespiratoire');
        $frequenceCardiaque = $this->input->post('frequenceCardiaque');
        $Saturationarterielle = $this->input->post('Saturationarterielle');
        $glycemyCapillaireUnite = $this->input->post('glycemyCapillaireUnite');
        $glycemyCapillaire = $this->input->post('glycemyCapillaire');
        $systolique = $this->input->post('systolique');
        $diastolique = $this->input->post('diastolique');
        $tensionArterielle = $this->input->post('tensionArterielle');
        $HypertensionSystolique = $this->input->post('HypertensionSystolique');

        if (empty($specialite)) {
            $specialite = 'Non renseigné';
        }
        if (empty($namePrestation)) {
            $namePrestation = 'Non renseigné';
        }
        if (empty($poids)) {
            $poids = 'Non renseigné';
        }
        if (empty($taille)) {
            $taille = 'Non renseigné';
        }
        if (empty($temperature)) {
            $temperature = 'Non renseigné';
        }
        if (empty($frequenceRespiratoire)) {
            $frequenceRespiratoire = 'Non renseigné';
        }
        if (empty($frequenceCardiaque)) {
            $frequenceCardiaque = 'Non renseigné';
        }
        if (empty($glycemyCapillaire)) {
            $glycemyCapillaire = 'Non renseigné';
        }

        if (!empty($glycemyCapillaire)) {
            $glycemyCapillaire = $glycemyCapillaire . ' ' . $glycemyCapillaireUnite;
        }

        if (empty($Saturationarterielle)) {
            $Saturationarterielle = 'Non renseigné';
        }
        if (empty($systolique)) {
            $systolique = 'Non renseigné';
        }
        if (empty($diastolique)) {
            $diastolique = 'Non renseigné';
        }




        if (!empty($date)) {
            $date = strtotime($date);
        } else {
            $date = time();
        }

        $description = $this->input->post('description');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $redirect = $this->input->post('redirect');
        if (empty($redirect)) {
            $redirect = 'patient/medicalHistory?id=' . $patient_id;
        }

// Validating Name Field
        $this->form_validation->set_rules('date', 'Date', 'trim|min_length[1]|max_length[100]|xss_clean');

// Validating Title Field
        $this->form_validation->set_rules('title', 'Title', 'trim|min_length[1]|max_length[100]|xss_clean');

// Validating Password Field

        $this->form_validation->set_rules('description', 'Description', 'trim|min_length[5]|max_length[10000]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("patient/editMedicalHistory?id=$id");
            } else {
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new');
                $this->load->view('home/footer'); // just the header file
            }
        } else {

            if (!empty($patient_id)) {
                $patient_details = $this->patient_model->getPatientById($patient_id, $this->id_organisation);
                $patient_name = $patient_details->name;
                $patient_last_name = $patient_details->last_name;
                $patient_phone = $patient_details->phone;
                $patient_address = $patient_details->address;
            } else {
                $patient_name = 0;
                $patient_phone = 0;
                $patient_address = 0;
            }

//$error = array('error' => $this->upload->display_errors());
            $data = array();
            $data = array(
                'patient_id' => $patient_id,
                'date' => $date,
                'title' => $title,
                'description' => $description,
                'patient_name' => $patient_name,
                'patient_last_name' => $patient_last_name,
                'patient_phone' => $patient_phone,
                'patient_address' => $patient_address,
                'date_string' => $date_string,
                'payment_id' => $payment_id,
                'code' => $code,
                'user' => $this->ion_auth->get_user_id(),
                'id_organisation' => $this->id_organisation,
                'specialite' => $specialite,
                'namePrestation' => $namePrestation,
                'poids' => $poids,
                'taille' => $taille,
                'temperature' => $temperature,
                'frequenceRespiratoire' => $frequenceRespiratoire,
                'frequenceCardiaque' => $frequenceCardiaque,
                'glycemyCapillaire' => $glycemyCapillaire,
                'Saturationarterielle' => $Saturationarterielle,
                'HypertensionSystolique' => $HypertensionSystolique,
                'systolique' => $systolique,
                'diastolique' => $diastolique,
                'tensionArterielle' => $tensionArterielle,
            );

            if (empty($id)) {
// Adding New department
                $this->patient_model->insertMedicalHistory($data, $this->id_organisation);
                $this->changeStatusPrestationByFinance($payment_id, 3, $prestation);
// $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating department
                $this->patient_model->updateMedicalHistory($id, $data, $this->id_organisation);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
// Loading View
            redirect($redirect);
        }
    }

    function getPendingPrestationsByPatientIdActe() {
        $requestData = $_REQUEST;
        $id_patient = $requestData["id"];
        $prestation = $requestData["prestation"];
        $payment = $requestData["payment"];

//$data = $this->finance_model->getPendingPaymentByPatientId($id_patient);
        $data = $this->finance_model->updatePaymentByLabo($id_patient, $payment);
        $resultArray = array();
        $result = count($data) > 0 ? "<option value='Veuillez sélectionner une prestation' data-extravalue='0'>Veuillez sélectionner une prestation</option>" : "<option value='Pas de prestation en cours' data-extravalue='0'>Pas de prestation en cours</option>";
        foreach ($data as $entry) {
            $dataTab = explode(',', $entry->category_name);
            $details = array();
            foreach ($dataTab as $value) {
                $status = "";
                $valueTab = explode('*', $value);
                $id_prestation = $valueTab[0];

                $current_prestation = $this->finance_model->getPaymentCategoryByOrganisationById2($id_prestation);

                if (!isset($valueTab[4])) {
// $status = "En attente";
                } else {
                    $detail_nom = '';
// if ($current_prestation->level) {
                    $details = $this->finance_model->editCategoryServiceByJasonParametre($current_prestation->id);
                    $nom_specialite = '';
                    foreach ($details as $detail) {
                        $resultats = '';
                        $resultatsTab = $this->finance_model->editResultats($detail->idpara, $entry->id);
                        if ($resultatsTab) {
                            $resultats = $resultatsTab->resultats;
                        }
                        $detail_nom .= $detail->idpara . '##' . $detail->nom_parametre . '##' . $detail->unite . '##' . $detail->valeurs . '##' . $resultats . '|';
                        $nom_specialite = $detail->name_specialite;
                    }
//  }
                    if (($valueTab[4] == '1' || $valueTab[4] == '1-1') && $prestation == $current_prestation->id) {

                        $resultArray[] = array("value" => $entry->id . "@@@@" . $value, "details" => $detail_nom, "code" => $entry->code, "idPayment" => $entry->id, "extraValue" => $current_prestation->id, "text" => $current_prestation->prestation, "nom_specialite" => $nom_specialite,);
                        $result .= "<option value='" . $entry->id . "@@@@" . $value . "' data-extravalue='" . $current_prestation->id . "'>";
                        $result .= $current_prestation->prestation;
                        $result .= "</option>";
                    } else if (($valueTab[4] == '1' || $valueTab[4] == '1-1') && $prestation == 'all') {
                        $resultArray[] = array("value" => $entry->id . "@@@@" . $value, "details" => $detail_nom, "code" => $entry->code, "idPayment" => $entry->id, "extraValue" => $current_prestation->id, "text" => $current_prestation->prestation, "nom_specialite" => $nom_specialite,);
                        $result .= "<option value='" . $entry->id . "@@@@" . $value . "' data-extravalue='" . $current_prestation->id . "'>";
                        $result .= $current_prestation->prestation;
                        $result .= "</option>";
                    }
                }
            }
        }

// echo json_encode(array('result' => $result));
// echo json_encode($result);
        echo json_encode($resultArray);
// echo json_encode($data);
    }

    function getValidIBydActe() {
        $requestData = $_REQUEST;
        $id = $requestData["id"];
        $prestation = $requestData["prestation"];
        $payment = $requestData["payment"];
        $service = '';
        $data['entete'] = $this->entete;

        if ($prestation) {
            $data['lab'] = $this->finance_model->existResultats($payment, $prestation);
            $data['idlab'] = $this->finance_model->existResultatsLab($payment);
        }
        $modele = isset($requestData["modele"]) && $requestData["modele"] != null ? $requestData["modele"] : null;
        if (isset($requestData["service"])) {
            $service = $requestData["service"];
        }



        $data['patient'] = $this->patient_model->getPatientById($id, $this->id_organisation);
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['prestation'] = $prestation;
        $data['settings'] = $this->settings_model->getSettings();
        $data['prestations'] = $this->finance_model->getPrestationId($prestation, $this->id_organisation);
        $data['payments'] = $this->finance_model->getPaymentId($payment, $this->id_organisation);
        if (!empty($data['payments']->prescripteur)) {
            $doctor_details = $this->home_model->getUserById($data['payments']->prescripteur);
            $data['doctor'] = $doctor_details;
        }

        if ($prestation) {
            $data['lab'] = $this->finance_model->existResultats($payment, $prestation);
            $data['idlab'] = $this->finance_model->existResultatsLab($payment);
        }
        $this->load->view('home/dashboard', $data);
        if (isset($service) && $service == 'labo' && $modele == 0) {
            $this->load->view('lab/lab_acte_valid', $data);
        } else if (isset($service) && $service == 'labo' && $modele != 0) {
            $data['template'] = $this->lab_model->getTemplateById($modele);
            $this->load->view('lab/lab_modele_valid', $data);
        }

        $this->load->view('home/footer');
    }

    function getValidPrestationsByPatientIdActe() {
        $requestData = $_REQUEST;
        $id_patient = $requestData['id'];
        $payment = $requestData['payment'];
        $idPrestation = $requestData['prestation'];
        $data = $this->finance_model->getPaymentById($payment);
        $resultArray = array();
// $result = count($data) > 0 ? "<option value='Veuillez sélectionner une prestation' data-extravalue='0'>Veuillez sélectionner une prestation</option>" : "<option value='Pas de prestation en cours' data-extravalue='0'>Pas de prestation effectue</option>";

        if ($idPrestation == 'all') {

            $dataTab = explode(',', $data->category_name);
            foreach ($dataTab as $value) {
                $status = "";
                $valueTab = explode('*', $value);
                $id_prestation = $valueTab[0];
                $current_prestation = $this->finance_model->getPaymentCategoryByOrganisationById2($id_prestation);
                if (isset($current_prestation)) {
                    $detail_nom = '';

                    $details = $this->finance_model->editCategoryServiceByJasonParametre($current_prestation->id);
                    $nom_specialite = '';
                    foreach ($details as $detail) {
                        $resultats = '';
                        $resultatsTab = $this->finance_model->editResultats($detail->idpara, $data->id);
                        if ($resultatsTab) {
                            $resultats = $resultatsTab->resultats;
                        }
                        $detail_nom .= $detail->idpara . '##' . $detail->nom_parametre . '##' . $detail->unite . '##' . $detail->valeurs . '##' . $resultats . '|';
                        $nom_specialite = $detail->name_specialite;
                    }

//if (($valueTab[4] == '2'))
                    {
                        $resultArray[] = array("value" => $data->id . "@@@@" . $value, "details" => $detail_nom, "code" => $data->code, "idPayment" => $data->id, "extraValue" => $current_prestation->id, "text" => $current_prestation->prestation, "nom_specialite" => $nom_specialite);
                        /*  $result .= "<option value='" . $data->id . "@@@@" . '' . "' data-extravalue='" . $current_prestation->id . "'>";
                          $result .= $current_prestation->prestation;
                          $result .= "</option>"; */
                    }
                }
            }
        } else {
            $current_prestation = $this->finance_model->getPaymentCategoryByOrganisationById2($idPrestation);
            if (isset($current_prestation)) {
                $detail_nom = '';

                $details = $this->finance_model->editCategoryServiceByJasonParametre($current_prestation->id);
                $nom_specialite = '';
                foreach ($details as $detail) {
                    $resultats = '';
                    $resultatsTab = $this->finance_model->editResultats($detail->idpara, $data->id);
                    if ($resultatsTab) {
                        $resultats = $resultatsTab->resultats;
                    }
                    $detail_nom .= $detail->idpara . '##' . $detail->nom_parametre . '##' . $detail->unite . '##' . $detail->valeurs . '##' . $resultats . '|';
                    $nom_specialite = $detail->name_specialite;
                }
                $resultArray[] = array(
                    "value" => $data->id . "@@@@" . $data->category_name, "details" => $detail_nom,
                    "code" => $data->code, "idPayment" => $data->id, "extraValue" => $current_prestation->id, "text" => $current_prestation->prestation, "nom_specialite" => $nom_specialite
                );
            }
        }
        echo json_encode($resultArray);
    }

    function listeDepositbyJason() {
        $id = $this->input->get('payment');
        $datasdeposits = $this->finance_model->getDepositByInvoiceIdPayment($id);

        $html = '';
        $badge = '';

        foreach ($datasdeposits as $value) {
            if ($value->type === '1') {
                $badge = '<span class="badge badge-primary" style="background-color:#0A3B76">En attente <i class="fa fa-hourglass-half"></i></span>';
            } else {
                $badge = '';
            }
            $deposited_amount = intval($value->deposited_amount);
            $html .= ' <tr><td class="">' . $badge . ' ' . $value->formeTimes . '</td>'
                    . '<td class="">' . $deposited_amount = number_format($deposited_amount, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency . ' </td>'
                    . '<td class="">' . $value->deposit_type . '</td>'
                    . '<td class="">' . $value->first_name . ' ' . $value->last_name . '</td></tr>';
        }
        echo json_encode($html);
    }

    function listePrestationyJason() {
        $id = $this->input->get('service');
        $searchTerm = $this->input->post('searchTerm');
        $datasdeposits = $this->finance_model->listePrestationyJason($id, $searchTerm);
        echo json_encode($datasdeposits);
    }

    function getListePrestationsParamtres() {
        $infoTab = $this->home_model->getPaymentCategory();
        foreach ($infoTab as $value) {
            $info[] = array(
                $value->name_specialite,
                $value->prestation,
                $value->id,
            );
        }
//  '<span class="btn btn-info btn-xs editbutton"  onclick="detailParametre( '.$value->idspe.' )"><i class="fa fa-eye"> </i></span>' ,
        $output = array(
//"draw" => intval($requestData['draw']),
// "recordsTotal" => $this->db->get_where('patient', array('id_organisation' => $this->id_organisation))->num_rows(), //$this->db->get('patient')->num_rows(),
// "recordsFiltered" => count($info),
            "data" => $info
        );
        echo json_encode($output);
    }

    public function importParametre() {
        $id = $this->input->post('id');
        foreach ($id as $value) {
            $data_p = array(
                'id_presta' => $value,
                'id_organisation' => $this->id_organisation, 'status_pco' => 1
            );

            $this->finance_model->insertPretation($data_p);
        }
        redirect('finance/paymentCategory');
    }

    function confirmImportPrestation() {
        $id = $this->input->post('id');
// $datasdeposits = array();
        foreach ($id as $value) {
            $datasdeposits[] = $this->finance_model->getListePrestationsParamtresById($value);
        }
        $data['id'] = $id;
        $data['prestations'] = $datasdeposits;
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('import', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function downloadPrestationInfo() {
        $id = $this->input->post('id');

        $timestamp = time();
        $filename = 'Liste_prestation_Ecomed24_' . date('d-m-Y', $timestamp) . '.xls';

        header("Content-type: application/octet-stream");
//  header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");

//header("Expires: 0");
//header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//header("Cache-Control: private",false);

        $fields = array('Specialites', 'Prestations', 'Tarif Public', 'Tarif Pro', 'Tarif Assurance', 'Tarif IPM');
        $excelData = implode("\t", array_values($fields)) . "\n";
        $rowData = array();

        foreach ($id as $k => $value) {
            $row = $this->finance_model->editCategoryServiceById($value);

            $rowData = array($row->name_specialite, $row->prestation);
            $excelData .= implode("\t", array_values($rowData)) . "\n";
        }
        echo $excelData;
    }

    function importPrestationExel2() {
        redirect("finance/import_fichier");
    }

    function import_fichier() {
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['depot'] = $depot_amount;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('import_fichier', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function newImport() {

        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['settings'] = $this->settings_model->getSettings();

        $this->load->view('home/dashboard', $data);
        $this->load->view('newImport', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function previousLabvalid() {
        $id = $this->input->get('id');
        $patient = $this->input->get('patient');
        $payment = $this->input->get('payment');
        $prestation = $this->input->get('prestation');
        $type = $this->input->get('type');
        $data1 = $this->finance_model->getFirstRowLabByIdByOrganisation($this->id_organisation, $type);

        $idlab = $prestation . '' . $payment;
        $idlast = $data1->id_prestation . '' . $data1->id_payment;

        if (isset($data1)) {
            if ($idlab == $idlast) {
                $data = $this->finance_model->getLastRowLabByIdByOrganisation($this->id_organisation, $type);
                if ($type == 2) {
                    redirect('finance/getValidIBydActe?typ=deb&id=' . $data->patient . '&payment=' . $data->id_payment . '&prestation=' . $data->id_prestation);
                } else if ($type == 3) {
                    redirect('finance/validexterneBydActe?typ=deb&id=' . $data->patient . '&payment=' . $data->id_payment . '&prestation=' . $data->id_prestation);
                }
            } else {
                for ($id1 = $id - 1; $id1 >= $idlast; $id1--) {

                    $data = $this->finance_model->getPreviousLabByIdByOrganisation($id1, $this->id_organisation, $type);
                    if (!empty($data)) {
                        if ($type == 2) {
                            redirect('finance/getValidIBydActe?id=' . $data->patient . '&payment=' . $data->id_payment . '&prestation=' . $data->id_prestation);
                        } else if ($type == 3) {
                            redirect('finance/validexterneBydActe?id=' . $data->patient . '&payment=' . $data->id_payment . '&prestation=' . $data->id_prestation);
                        }
                        break;
                    } elseif ($id1 == $idlast) {
                        $data = $this->finance_model->getLastRowLabByIdByOrganisation($this->id_organisation, $type);
                        if ($type == 2) {
                            redirect('finance/getValidIBydActe?typ=deb&id=' . $data->patient . '&payment=' . $data->id_payment . '&prestation=' . $data->id_prestation);
                        } else if ($type == 3) {
                            redirect('finance/validexterneBydActe?typ=deb&id=' . $data->patient . '&payment=' . $data->id_payment . '&prestation=' . $data->id_prestation);
                        }
                    } else {
                        continue;
                    }
                }
            }
        } else {
            redirect('finance/getValidIBydActe?typ=deb&id=' . $patient . '&payment=' . $payment . '&prestation=' . $prestation);
        }
    }

    function nextLabvalid() {
        $id = $this->input->get('id');
        $patient = $this->input->get('patient');
        $payment = $this->input->get('payment');
        $prestation = $this->input->get('prestation');
        $type = $this->input->get('type');
        $data1 = $this->finance_model->getLastRowLabByIdByOrganisation($this->id_organisation, $type);
        $idlab = $prestation . '' . $payment;
        $idlast = $data1->id_prestation . '' . $data1->id_payment;

        if (isset($data1)) {
            if ($idlab == $idlast) {
                $data = $this->finance_model->getFirstRowLabByIdByOrganisation($this->id_organisation, $type);
                if ($type == 2) {
                    redirect('finance/getValidIBydActe?typ=fin&id=' . $data->patient . '&payment=' . $data->id_payment . '&prestation=' . $data->id_prestation . '&patient=' . $patient);
                } else if ($type == 3) {
                    redirect('finance/validexterneBydActe?typ=fin&id=' . $data->patient . '&payment=' . $data->id_payment . '&prestation=' . $data->id_prestation . '&patient=' . $patient);
                }
            } else {
                for ($id1 = $id + 1; $id1 <= $idlast; $id1++) {

                    $data = $this->finance_model->getNextLabByIdByOrganisation($id1, $this->id_organisation, $prestation, $type);
//   var_dump($data); exit();
                    if (!empty($data)) {
                        if ($type == 2) {
                            redirect('finance/getValidIBydActe?typ=&id=' . $data->patient . '&payment=' . $data->id_payment . '&prestation=' . $data->id_prestation . '&patient=' . $patient);
                        } else if ($type == 3) {
                            redirect('finance/validexterneBydActe?typ=fin&id=' . $data->patient . '&payment=' . $data->id_payment . '&prestation=' . $data->id_prestation . '&patient=' . $patient);
                        }
                        break;
                    } elseif ($id1 == $idlast) {
                        $data = $this->finance_model->getFirstRowLabByIdByOrganisation($this->id_organisation, $type);
                        if ($type == 2) {
                            redirect('finance/getValidIBydActe?typ=fin&id=' . $data->patient . '&payment=' . $data->id_payment . '&prestation=' . $data->id_prestation . '&patient=' . $patient);
                        } else if ($type == 3) {
                            redirect('finance/validexterneBydActe?typ=fin&id=' . $data->patient . '&payment=' . $data->id_payment . '&prestation=' . $data->id_prestation);
                        }
                        continue;
                    }
                }
            }
        } else {
            redirect('finance/getValidIBydActe?typ=fin&id=' . $patient . '&payment=' . $payment . '&prestation=' . $prestation . '&patient=' . $patient);
        }
    }

    function rejetbuttonJson() {
        $payment = $this->input->get('payment');
        $checktAB = $this->input->get('prestation');      //  var_dump($payment, 2, $checktAB);
        $this->changeStatusPrestationByFinance($payment, 1, $checktAB);
//redirect('finance/paymentLabo');
        echo json_encode(true);
    }

    function validexterneBydActe() {
        $requestData = $_REQUEST;
        $id = $requestData["id"];
        $prestation = $requestData["prestation"];
        $payment = $requestData["payment"];
        $service = '';
        $modele = isset($requestData["modele"]) && $requestData["modele"] != null ? $requestData["modele"] : null;
        if (isset($requestData["service"])) {
            $service = $requestData["service"];
        }

        $data['patient'] = $this->patient_model->getPatientById($id, $this->id_organisation);
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['prestation'] = $prestation;
        $data['settings'] = $this->settings_model->getSettings();
        $data['prestations'] = $this->finance_model->getPrestationId($prestation, $this->id_organisation);
        $data['payments'] = $this->finance_model->getPaymentId($payment, $this->id_organisation);
        if ($prestation) {
            $data['lab'] = $this->finance_model->existResultats($payment, $prestation);
            $data['idlab'] = $this->finance_model->existResultatsLab($payment);
        }
        $this->load->view('home/dashboard', $data);
        if (isset($service) && $service == 'labo' && $modele == 0) {
            $this->load->view('lab/valid_externe', $data);
        } else if (isset($service) && $service == 'labo' && $modele != 0) {
            $data['template'] = $this->lab_model->getTemplateById($modele);
            $this->load->view('lab/valid_modele_externe', $data);
        }
        $this->load->view('home/footer');
    }

    function validFactures() {

        $payment = $this->input->post('id');
        $deb = $this->input->post('deb');
        $fin = $this->input->post('fin');

        if (is_array($payment) && isset($payment) && isset($payment[0])) {
            $id = $payment[0];
            $origins = $this->partenaire_model->infoPartenaire($id, $this->id_organisation, 'origin');
            $data['destinatairs'] = $this->partenaire_model->infoPartenaire($id, $origins->id_organisation, '');
            $data['origins'] = $origins;
            foreach ($payment as $value) {
                $prestations = $this->partenaire_model->payButton($value, $origins->id_organisation, '');
                $data['prestations'][] = $prestations;

                $count_payment = $this->db->get_where('payment', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
// $codeFacture = 'F-' . $this->code_organisation . '-' . str_pad($count_payment, 4, "0", STR_PAD_LEFT);
                $codeFacture = 'F' . $this->code_organisation . '' . $count_payment;

                $this->changeStatusPrestationByFinance($value, 6, 'all');

                $this->finance_model->updatePayment($value, array('code' => $codeFacture, 'ref' => $prestations->code), $this->id_organisation);
            }

            $data['settings'] = $this->settings_model->getSettings();
            $data['id'] = $payment;

            $data['id_organisation'] = $this->id_organisation;
            $data['path_logo'] = $this->path_logo;
            $data['nom_organisation'] = $this->nom_organisation;

            $data['deb'] = $deb;
            $data['fin'] = $fin;
            $data['invoice_id'] = $codeFacture;
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('partenaire/valid_facture', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            $this->session->set_flashdata('feedback', lang('error'));

            redirect('partenaire');
        }
    }

    function checkDepotPro() {
// $deposited_amount_old = $this->input->post('deposited_amount');
        $pro_invoice_id = $this->input->post('payment');
// $redirect = $this->input->post('redirect');
// $patient = $this->input->post('patient');
// $p_name = $this->input->post('name');
// $p_lastName = $this->input->post('lastname');
// $p_id = $this->input->post('patientId');
// $payment = $this->finance_model->getPaymentById($invoice_id, $this->id_organisation);
        $payment_pro_entry = $this->finance_model->getPaymentByCode($pro_invoice_id);
        $code_original_entryInit = $this->partenaire_model->payListeFactureByGroup2(null, $pro_invoice_id, null, null, null);
        $code_original_entry = $code_original_entryInit[0]->codepro;
        $payment_original_entry = $this->finance_model->getPaymentByCode($code_original_entry);

// $date = time();
// $user = $this->ion_auth->get_user_id();
// $deposit_type = $this->input->post('deposit_type');

        $status_paid = 'paid';
        $status_original_entry = $payment_original_entry->status;
        $status_pro_entry = $payment_pro_entry->status;

// $data_amount_received = array('amount_received' => $payment->gross_total, 'status' => $status, 'status_paid' => $status_paid);
//  var_dump($data_amount_received); exit();
// $this->changeStatusPrestationByFinance($payment->id, 4, 'all');
        if ($payment_original_entry->gross_total == $payment_original_entry->amount_received) { // Si le paiement avait été fait en intégralité à la création
            if ($payment_original_entry->status == "demandpay") {
                $status_original_entry = "finish";
                $this->changeStatusPrestationByFinance($payment_original_entry->id, 4, 'all');
            }
        }

        $status_pro_entry = "finish";
        $update_payment_original_entry = array('status_paid_pro' => $status_paid, 'status' => $status_original_entry);
        $update_payment_pro_entry = array('status_paid_pro' => $status_paid, 'status' => $status_pro_entry);

        $this->finance_model->updatePayment($payment_original_entry->id, $update_payment_original_entry, $this->id_organisation);
        $this->finance_model->updatePayment($payment_pro_entry->id, $update_payment_pro_entry, $this->id_organisation);

// $data1 = array(
// 'date' => $date,
// 'patient' => '',
// 'deposited_amount' => $deposited_amount_old,
// 'payment_id' => $invoice_id,
// 'amount_received_id' => '',
// 'deposit_type' => $deposit_type, 'id_organisation' => $this->id_organisation,
// 'user' => $user
// );
// $this->finance_model->insertDeposit($data1);
//$patient_details = $this->patient_model->getPatientById($patient, $this->id_organisation);	
// $payment_details = $this->finance_model->getPaymentById($invoice_id);
// $data1Email = array(
// 'name' => "xx ",
// 'company' => $this->nom_organisation,
// 'amount' => number_format($deposited_amount_old, 0, '', '.') . " FCFA",
// 'payment_method' => $deposit_type,
// 'montant_total' => number_format($payment_details->gross_total, 0, '', '.') . " FCFA",
// 'total_depots' => number_format($payment_details->amount_received, 0, '', '.') . " FCFA",
// 'restant' => number_format(($payment_details->gross_total - $payment_details->amount_received), 0, '', '.') . " FCFA"
// );
// $data1SMS = $data1Email;
// SMS
// $autosms = $this->sms_model->getAutoSmsByType('payment');
// $message = $autosms->message;
// $subject = $autosms->name;  
// $to = $patient_phone;
// $autoemail = $this->email_model->getAutoEmailByType('payment');
// $message1 = $autoemail->message;
// $subject = $this->parser->parse_string($autoemail->name, $data1Email);
// $messageprint2 = $this->parser->parse_string($message1, $data1Email);
// $dataInsertEmail = array(
// 'reciepient' => $patient_details->email,
// 'subject' => $subject,
// 'message' => $messageprint2,
// 'date' => time(),
// 'user' => $this->ion_auth->get_user_id()
// );
// $this->email_model->insertEmail($dataInsertEmail);

        $this->session->set_flashdata('feedback', lang('updated'));

        redirect('partenaire/factures');
        /* }else if($deposit_type === "OrangeMoney"){

          } */
    }

    function generateRapportPDF() {

        $payment = $this->input->get('id');
        $origins = $this->partenaire_model->payButton($payment, $this->id_organisation);
        $patientOrigins = $origins->patient;
        $tabuser = $this->home_model->getUserById($origins->user);
        $patient = $this->patient_model->getPatientById($patientOrigins, $this->id_organisation);
        $usersValider = $this->finance_model->getExecuteUser($payment);
        $users = $this->home_model->getUserById($usersValider->user);
        $data['UsersValider'] = $users;

// IMPORT FOREACT

        if (!empty($origins->category_name)) {
            $category_name = $origins->category_name;
            $category_name1 = explode(',', $category_name);
            $i = 0;
            $cat = array();
            foreach ($category_name1 as $key => $category_name2) {
                $category_name3 = explode('*', $category_name2);
                if ($category_name3[3] > 0 && $category_name3[1]) {
                    $value = $this->finance_model->editCategoryServiceBySpe($category_name3[0]);
                    $cat[$value->id_spe][$key] = $value;
                }
            }

//ksort($cat, SORT_NUMERIC);
            $data['cat'] = $cat;
            $structure = array();
            foreach ($category_name1 as $key => $category_name2) {
                $category_name3 = explode('*', $category_name2);
                $value = $this->finance_model->getPrestationId($category_name3[0]);
                $id_spec = $value->id_spe;
                $value1 = current(array_filter($structure, function ($element) use ($id_spec) {
                            return $element->idspe == $id_spec;
                        }));
                if (empty($value1)) {
                    $value1 = $this->finance_model->getSpecialiteId($value->id_spe);
                    $value1->prestations = array();
                    array_push($structure, $value1);
                }
                $value->resultats = $this->finance_model->getParamPrestation($payment, $value->id);
                array_push($value1->prestations, $value);
            }



            $data['structure'] = $structure;
        }



// if (!empty($origins->category_name)) {
//     foreach ($cat as $key => $category_name) {
//         $category_nameid =  current($category_name);
//         if ($category_nameid) {
//             $valuep = $category_nameid->name_specialite;
//         }
//         foreach ($category_name as $category_name2) {
//             // var_dump($category_name2);
//             if ($category_name2) {
//                 $html_patient3 .= '       <tr>';
//                 $html_patient3 .= '         <td class="" style="width:40%"><strong>' . $category_name2->prestation . '</strong></td>';
//                 $html_patient3 .= '  <td class="text-center" style="width:20%"></td>';
//                 $html_patient3 .= '     <td class="text-center" style="width:20%"></td>';
//                 $html_patient3 .= '      <td class="text-center" style="width:20%"></td>';
//                 $html_patient3 .= '       </tr>';
//                 $tabbs = $this->finance_model->existResultatsPara($payment, intval($category_name2->id));
//                 foreach ($tabbs as $tabb) {
//                     $resultat = $tabb->resultats;
//                     $para = $tabb->id_para;
//                     $presta = $tabb->id_presta;
//                     $tab = $this->finance_model->parametreValue($para);
//                     $unite = $tab->unite ? $tab->unite : '';
//                     $valeurs = $tab->valeurs ? $tab->valeurs : '';
//                     $modele =  '';
//                     if ($presta && $this->id_organisation) {
//                         $modeleTab = $this->home_model->getModeleByLaboPaiement($presta, $this->id_organisation);
//                         if (!empty($modeleTab)) {
//                             $modele = $modeleTab->is_modele;
//                         }
//                     }
//                     if ($modele != 0) {
//                         $html_patient3 .= '       <tr>';
//                         $html_patient3 .= '         <td class="" style="width:40%">' . $tab->nom_parametre . '</td>';
//                         $html_patient3 .= '  <td class="text-center" style="width:60%">' . $resultat . ' </td>';
//                         $html_patient3 .= '     <td class="text-center"></td>';
//                         $html_patient3 .= '      <td class="text-center"></td>';
//                         $html_patient3 .= '      </tr>';
//                     } else {
//                         $html_patient3 .= '       <tr>';
//                         $html_patient3 .= '         <td class="" style="width:40%">' . $tab->nom_parametre . '</td>';
//                         $html_patient3 .= '  <td class="text-center" style="width:20%">' . $resultat . ' </td>';
//                         $html_patient3 .= '     <td class="text-center" style="width:20%">' . $unite . ' </td>';
//                         $html_patient3 .= '      <td class="text-center" style="width:20%,font-style: italic;">' . $valeurs . '</td>';
//                         $html_patient3 .= '      </tr>';
//                     }
//                 }
//             }
//         }
//     }
// }
// $html_patient3 .= '         </tbody>';
// FIN IMPORT 
        $data['patientOrigins'] = $patient;
        if (!empty($data['patientOrigins']->birthdate)) {
            $today = date("Y-m-d");
// $dateOfBirth = strtotime("$today -2 months -20 days");
            $dateOfBirth = strtotime($data['patientOrigins']->birthdate);
            $birthday = date("Y-m-d", $dateOfBirth);
            $diff = date_diff(date_create($today), date_create($birthday));
// echo $diff->y;
            if ($diff->y > 0) {
                $data['age'] = $diff->y . ' An(s)';
            } else if ($diff->m > 0) {
                $data['age'] = $diff->m . ' Mois';
            } else if ($diff->d > 0) {
                $data['age'] = $diff->d . ' Jours';
            }
        }



        $data['origins'] = $origins;
        $data['patientOrigins'] = $patient;
        $data['tabuser'] = $tabuser;

        if (!empty($origins->prescripteur)) {
            $doctor_details = $this->home_model->getUserById($origins->prescripteur);
            $data['doctor'] = $doctor_details;
        }


        echo json_encode($data);
    }

    function generateRapport($payment) {
        $origins = $this->partenaire_model->payButton($payment, $this->id_organisation);
        $mode = false;
        if (isset($origins->organisation_destinataire)) {
            $destinatairs = $this->partenaire_model->getPartenairesById($origins->organisation_destinataire);
        }
        if (empty($origins)) {
            $origins = $this->partenaire_model->infoPartenaire($payment, $this->id_organisation, 'origin');
            $destinatairs = $this->partenaire_model->getPartenairesById($origins->id_organisation);
            $mode = true;
        }



        $patientOrigins = $origins->patient;
        $patient = $this->patient_model->getPatientById($patientOrigins, $this->id_organisation);
        $data['patientOrigins'] = $patient;
        $age = '';

        $age = $data['patientOrigins']->age;
        if (!empty($age)) {
            $age = $data['patientOrigins']->age . ' An(s)';
        }



        $tabuser = $this->home_model->getUserById($origins->user);
        $settings = $this->settings_model->getSettings();

        if (!empty($origins->prescripteur)) {
            $doctor_details = $this->home_model->getUserById($origins->prescripteur);
            $doctor_name = 'DR ' . $doctor_details->first_name . ' ' . $doctor_details->last_name;
            $data['doctor'] = $doctor_details;
        }


        if (empty($origins->prescripteur)) {
            $doctor_name = ' ';
        }

        $html_patient = '<!DOCTYPE html>';
        $html_patient = '<html lang="fr">';
        $html_patient .= ' <head>';
        $html_patient .= '<meta charset="utf-8" />';
        $html_patient .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        $html_patient .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
        $html_patient .= '<link href="" rel="icon" />';
        $html_patient .= "<title>Résultats d'Analyses</title>";
        $html_patient .= '<meta name="author" content="">';
        $html_patient .= '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" type="text/css">';
        $html_patient .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'common/css/bootstrap.min.css"/>';
        $html_patient .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'common/assets/fontawesome5pro/css/all.min.css"/>';
        $html_patient .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'common/css/stylesheet.css"/>';
        $html_patient .= '</head>';
        $html_patient .= '<body>';
        $html_patient .= '<div class="container-fluid invoice-container" id="datalabPrint">';

        $html_patient .= '  <header>';
        $html_patient .= ' <div class="row align-items-center">';
        $html_patient .= '    <div class="col-sm-7 text-center text-sm-left mb-3 mb-sm-0" style="float:left;">';
        if ($origins->path_logo) {
            $html_patient .= '                      <img  id="logo" src="' . $origins->path_logo . '" alt="Logo Partenaire"/>';
        }
        $html_patient .= '    </div>';
        $html_patient .= '   <div class="col-sm-5 text-center text-sm-right" style="float:right;">';
        $html_patient .= ' <strong>' . $origins->nom . '</strong>';
        $html_patient .= '     <address>';
        if (!empty($origins->numero_fixe)) {
            $html_patient .= $origins->numero_fixe . '<br />';
        }
        if (!empty($origins->email)) {
            $html_patient .= $origins->email . '<br />';
        }
        if (!empty($origins->slogan)) {
            $html_patient .= $origins->slogan . '<br />';
        }
        if (!empty($origins->horaires_ouverture)) {
            $html_patient .= $origins->horaires_ouverture;
        }

        $html_patient .= '    </address>';
        $html_patient .= '   </div>';
        $html_patient .= '   </div>';
        $html_patient .= '  <hr>';
        $html_patient .= ' </header>';

        $html_patient .= '  <main>';

        $html_patient .= ' <div class="row">';
        $html_patient .= '    <div class="col-sm-6">';
        if (!empty($origins->prenom_responsable_legal) && !empty($origins->nom_responsable_legal)) {
            $html_patient .= $origins->prenom_responsable_legal . '  ' . $origins->nom_responsable_legal . '<br />';
        }
        if (!empty($origins->fonction_responsable_legal)) {
            $html_patient .= $origins->fonction_responsable_legal . '<br /> ';
        }
        if (!empty($origins->description_courte_responsable_legal)) {
            $html_patient .= $origins->description_courte_responsable_legal;
        }
        $html_patient .= '</div>';
        $html_patient .= '    <div class="col-sm-6 text-sm-right"> </div>';

        $html_patient .= '  </div>';

        $html_patient .= '  <hr>';
        $html_patient .= '  <div class="row">';
        $html_patient .= '   <div class="col-sm-6 text-sm-right order-sm-1" style="float:left;">';

        $html_patient2 = '      <address>';
        $html_patient2 .= '     <strong>' . lang('patient') . ' </strong><span class="prenomNom">' . $origins->name . ' ' . $origins->last_name . '</span><br />';
        $html_patient2 .= '     <strong>' . lang('phone') . ' </strong>' . $origins->phone . ' <br />';
        $html_patient2 .= '      <strong>' . lang('age') . ' </strong>' . $age . ' <br />';
        $html_patient2 .= '	   <strong>' . lang('gender') . ' </strong>' . $origins->sex . ' <br />';
        $html_patient2 .= '      </address>';
        $html_patient2 .= '    </div>';
        $html_patient2 .= '    <div class="col-sm-6 order-sm-0" style="float:left;">';
        $html_patient2 .= '      <address>';
        $html_patient2 .= '     <strong>' . lang('number') . ' </strong>' . $origins->patient . ' <br />';
        $html_patient2 .= '      <strong>' . lang('date') . ' </strong>' . date('d/m/Y', $origins->date) . ' <br />';
        $html_patient2 .= '     <strong>' . lang('numorde') . ' </strong>' . $origins->code . ' <br />';
        $html_patient2 .= '      <strong> Medecin Prescripteur  </strong> ' . $doctor_name . ' <br />';
        $html_patient2 .= '      </address>';

        $html_patient2_1 = '      <address>';
        $html_patient2_1 .= '     <strong>' . lang('patient') . '  </strong>' . $origins->patient . ' <br />';
        $html_patient2_1 .= '      </address>';
        $html_patient2_1 .= '    </div>';
        $html_patient2_1 .= '    <div class="col-sm-6 order-sm-0" style="float:right;">';
        $html_patient2_1 .= '      <address>';

        $html_patient2_1 .= '      <strong>' . lang('date') . ' </strong>' . date('d/m/Y', $origins->date) . ' <br />';
        $html_patient2_1 .= '     <strong>' . lang('numorde') . ' </strong>' . $origins->code . ' <br />';
        $html_patient2_1 .= '      <strong> Medecin Prescripteur </strong> Docteur ' . $doctor_name . ' <br />';
        $html_patient2_1 .= '      </address>';

        $html_patient3 = '   </div>';
        $html_patient3 .= '  </div>  ';

        $html_patient3 .= ' <div class="col-md-12">';
        $html_patient3 .= '     <h4 class="text-center" style="font-weight: bold; margin-top: 20px; text-transform: uppercase;">';
        $html_patient3 .= lang('report1');
        $html_patient3 .= '   </h4>';
        $html_patient3 .= '  </div>';

        $html_patient3 .= ' <div class="card">';
        $html_patient3 .= '   <div class="card-header px-2 py-0">';
        $html_patient3 .= '     <table class="table mb-0">';
        $html_patient3 .= '        <thead>';
        $html_patient3 .= '          <tr>';
        $html_patient3 .= '            <td class="border-0" style="width:35%"><strong>Analyse(s) Demand&eacute;es</strong></td>';
        $html_patient3 .= '			<td class="text-center border-0" style="width:18%;margin-left:5%"><strong>R&eacute;sultats</strong></td>';
        $html_patient3 .= '            <td class="text-center border-0" style="width:18%"><strong>Unit&eacute;</strong></td>';
        $html_patient3 .= '			<td class="text-center border-0" style="width:19%"><strong>Valeurs Usuelles</strong></td>';

        $html_patient3 .= '          </tr>';
        $html_patient3 .= '       </thead>';
        $html_patient3 .= '     </table>';
        $html_patient3 .= '   </div>';
        $html_patient3 .= '   <div class="card-body px-2">';
        $html_patient3 .= '     <div class="table-responsive">';
        $html_patient3 .= '       <table class="table">';

        $html_patient3 .= '         <tbody>';

        if (!empty($origins->category_name)) {
            $category_name = $origins->category_name;
            $category_name1 = explode(',', $category_name);
            $i = 0;
            $cat = array();
            foreach ($category_name1 as $key => $category_name2) {
                $category_name3 = explode('*', $category_name2);
                if ($category_name3[3] > 0 && $category_name3[1]) {
                    $value = $this->finance_model->editCategoryServiceBySpe($category_name3[0]);
                    $cat[$value->id_spe][$key] = $value;
                }
            }
        }
// ksort($cat, SORT_NUMERIC);


        if (!empty($origins->category_name)) {

            foreach ($cat as $key => $category_name) {
                $category_nameid = current($category_name);
                if ($category_nameid) {
                    $valuep = $category_nameid->name_specialite;
                    $html_patient3 .= '       <tr>';
                    $html_patient3 .= '         <td class="text-center"  colspan="4" style="width:40%;border:1px dotted #9e9e9e;    text-align: center;"><strong>' . $valuep . '</strong></td>';
                    $html_patient3 .= '       </tr>';
                }
                foreach ($category_name as $category_name2) {
// var_dump($category_name2);


                    if ($category_name2) {

                        $html_patient3 .= '       <tr>';
                        $html_patient3 .= '         <td class="" style="width:40%"><strong>' . $category_name2->prestation . '</strong></td>';
                        $html_patient3 .= '  <td class="text-center" style="width:20%"></td>';
                        $html_patient3 .= '     <td class="text-center" style="width:20%"></td>';
                        $html_patient3 .= '      <td class="text-center" style="width:20%"></td>';
                        $html_patient3 .= '       </tr>';

                        $tabbs = $this->finance_model->existResultatsPara($payment, intval($category_name2->id));
                        foreach ($tabbs as $tabb) {


                            $resultat = $tabb->resultats;
                            $para = $tabb->id_para;
                            $presta = $tabb->id_presta;
                            $tab = $this->finance_model->parametreValue($para);
                            $unite = $tab->unite ? $tab->unite : '';
                            $valeurs = $tab->valeurs ? $tab->valeurs : '';
                            $modele = '';
                            if ($presta && $this->id_organisation) {
                                $modeleTab = $this->home_model->getModeleByLaboPaiement($presta, $this->id_organisation);
                                if (!empty($modeleTab)) {
                                    $modele = $modeleTab->is_modele;
                                }
                            }
                            if ($modele != 0) {
                                $html_patient3 .= '       <tr>';
                                $html_patient3 .= '         <td class="" style="width:40%">' . $tab->nom_parametre . '</td>';
                                $html_patient3 .= '  <td class="text-center" style="width:60%">' . $resultat . ' </td>';
                                $html_patient3 .= '     <td class="text-center"></td>';
                                $html_patient3 .= '      <td class="text-center"></td>';
                                $html_patient3 .= '      </tr>';
                            } else {
                                $html_patient3 .= '       <tr>';
                                $html_patient3 .= '         <td class="" style="width:40%">' . $tab->nom_parametre . '</td>';
                                $html_patient3 .= '  <td class="text-center" style="width:20%">' . $resultat . ' </td>';
                                $html_patient3 .= '     <td class="text-center" style="width:20%">' . $unite . ' </td>';
                                $html_patient3 .= '      <td class="text-center" style="width:20%,font-style: italic;">' . $valeurs . '</td>';
                                $html_patient3 .= '      </tr>';
                            }
                        }
                    }
                }
            }
        }

        $html_patient3 .= '         </tbody>';
        $html_patient3 .= '       </table>';
        $html_patient3 .= '      </div>';
        $html_patient3 .= '   </div>';
        $html_patient3 .= '  </div>';
        $html_patient3 .= '  </main>';
        $html_patient3 .= '  <br/>';
        $html_patient3 .= '</div>';
        $html_patient3 .= ' <footer class="text-center mt-4">';
        $html_patient3 .= '  <p class=""><strong></strong> ';
        $html_patient3 .= $origins->nom . ' ' . $origins->adresse . ' ' . $origins->region . ' , ' . $origins->pays . ' ';
        if (!empty($origins->number_fixe)) {
            $html_patient3 .= ' Tel:' . $origins->number_fixe . ' ';
        }
        if (!empty($origins->email)) {
            $html_patient3 .= ' Mail:' . $origins->email;
        }
        $html_patient3 .= '.</p>';

        $html_patient3 .= ' </footer>';
        $html_patient3 .= '</body>';
        $html_patient3 .= '</html>';

        $html1 = $html_patient . $html_patient2 . $html_patient3;
        $html2 = $html_patient . $html_patient2_1 . $html_patient3;
        $this->lab_model->updateLabByPayment(intval($payment), array("report" => $html1, "report_pro" => $html1, "patient" => $origins->patient_id, "patient_name" => $origins->name . ' ' . $origins->last_name, "patient_phone" => $origins->phone, "idPayement" => $origins->id, "nomLabo" => $origins->nom, "prescripteur" => $doctor_name, "importLabo" => "analyse"));
    }

    function updatePaiementPro() {
        $pro_invoice_id = $this->input->post('id');
        $amount = $this->input->post('amount');
        $phone = $this->input->post('refNumOM');
        $estPro = 1;
        $deposit_type = $this->input->post('deposit_type'); //OrangeMoney
        $idtransaction = $this->input->post('idTransaction');
        $reference = $this->input->post('refMobRef');

        $payment_pro_entry = $this->finance_model->getPaymentByCode($pro_invoice_id);
        $init = $this->partenaire_model->payListeFactureByGroup2(null, $pro_invoice_id, null, null, null);
        $code_original_entry = $init[0]->codepro;
        $payment_original_entry = $this->finance_model->getPaymentByCode($code_original_entry);

        $date = time();
        $data = array(
            'date' => $date,
            'deposited_amount' => $amount,
            'payment_id' => $payment_original_entry->id,
            'estPro' => $estPro,
            'amount_received_id' => '',
            'deposit_type' => $deposit_type,
            'id_organisation' => $this->id_organisation,
            'statut_deposit' => 'PENDING',
            'id_transaction_externe' => $idtransaction,
            'ref_om' => $reference,
            'numero_om' => $phone,
            'user' => $this->ion_auth->get_user_id(),
        );

        $this->finance_model->insertDepositOM($data);
// $payment = $this->finance_model->getPaymentById($invoice_id, $this->id_organisation);
// if ($payment->gross_total == $payment->amount_received) { // Si le paiement avait été fait en intégralité à la création
// if ($payment->status == "accept") {
// $status = "finish";
// $this->changeStatusPrestationByFinance($payment->id, 4, 'all');
// }
// }
// $status = $payment->status;
        $status_paid = 'pending';
// $update_payment = array('status_paid_pro' => $status_paid, 'status' => $status);
        $update_payment = array('status_paid_pro' => $status_paid);
        $this->finance_model->updatePayment($payment_original_entry->id, $update_payment, $this->id_organisation);
        $this->finance_model->updatePayment($payment_pro_entry->id, $update_payment, $this->id_organisation);

//    $data_payment = array('deposit_type' => $deposit_type, 'status_paid' => 'paid');
//    $this->finance_model->updatePayment($payment, $data, $this->id_organisation);

        $this->session->set_flashdata('feedback', lang('added'));

        redirect("partenaire/factures");
    }

    function getEmailPrefix() {
        $html = '<head>';
        $html .= '     ';
        $html .= '        <meta charset="utf-8">';
        $html .= '        <!-- Bootstrap core CSS -->';

        $html .= '			<link href="' . base_url() . 'common/css/bootstrap.min.css" rel="stylesheet">';
        $html .= '			<link href="' . base_url() . 'common/css/bootstrap-reset.css" rel="stylesheet">';
        $html .= '			<!--external css-->';
        $html .= '			<link href="' . base_url() . 'common/assets/fontawesome5pro/css/all.min.css" rel="stylesheet" />';
        $html .= '			<link href="' . base_url() . 'common/assets/DataTables/datatables.css?<?php echo time(); ?>" rel="stylesheet" />';
        $html .= '			<!-- Custom styles for this template -->';
        $html .= '			<link href="' . base_url() . 'common/css/style.css?<?php echo time(); ?>" rel="stylesheet">';
        $html .= '			<link href="' . base_url() . 'common/css/style-responsive.css" rel="stylesheet" />';
        $html .= '			<link href="' . base_url() . 'common/css/invoice-print.css" rel="stylesheet" media="print">';
        $html .= '            @import url("https://fonts.googleapis.com/css?family=Ubuntu&display=swap");';
        $html .= '			#sidebar, .header, .site-footer {';
        $html .= '				display: none ;';
        $html .= '			}';
        $html .= '    </head>';
        return $html;
    }

    function listeModeleByLabo() {
        $id = $this->input->get('id');
        $modele = array();
        $result = $this->home_model->listeModeleByLabo();
        if ($id) {
            $modele = $this->home_model->getModeleByLabo($id, $this->id_organisation);
        }
        echo json_encode(array('liste' => $result, 'modele' => $modele));
    }

    function updateModeleByLabo() {
        $id = intval($this->input->post('liste-modele'));
        $idpco = intval($this->input->post('idpco'));
        if ($idpco) {
            $data = array('is_modele' => $id);
            $modele = $this->home_model->updateModeleByLabo($idpco, $data);
        }
        $this->session->set_flashdata('feedback', lang('updated'));

        redirect('finance/paymentCategory');
    }

}

/* End of file finance.php */
/* Location: ./application/modules/finance/controllers/finance.php */
