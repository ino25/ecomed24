<?php

require_once FCPATH . '/vendor/autoload.php';
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prescription extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('prescription_model');
        $this->load->model('medicine/medicine_model');
        $this->load->model('pharmacist/pharmacist_model');
        $this->load->model('patient/patient_model');
        $this->load->model('doctor/doctor_model');
        $this->load->model('home/home_model');
        $this->load->model('partenaire/partenaire_model');
        if (!$this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor', 'Patient', 'Nurse', 'adminmedecin'))) {
            redirect('home/permission');
        }

        $identity = $this->session->userdata["identity"];
        $this->id_organisation = $this->home_model->get_id_organisation($identity);
        $this->path_logo = $this->home_model->get_logo_organisation($this->id_organisation);
        $this->nom_organisation = $this->home_model->get_nom_organisation($this->id_organisation);
        $this->id_partenaire_zuuluPay = $this->home_model->id_partenaire_zuuluPay($this->id_organisation);
        $this->pin_partenaire_zuuluPay_encrypted = $this->home_model->pin_partenaire_zuuluPay_encrypted($this->id_organisation);
        $this->code_organisation = $this->home_model->get_code_organisation($this->id_organisation);
    }

    public function index()
    {
        $this->all();
        /*  if ($this->ion_auth->in_group(array('Patient'))) {
          redirect('home/permission');
          }

          $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
          $data['doctors'] = $this->doctor_model->getDoctor();
          if ($this->ion_auth->in_group(array('Doctor'))) {
          $current_user = $this->ion_auth->get_user_id();
          $doctor_id = $this->db->get_where('doctor', array('ion_user_id' => $current_user))->row()->id;
          }
          $data['prescriptions'] = $this->prescription_model->getPrescriptionByDoctorId($doctor_id);
          $data['settings'] = $this->settings_model->getSettings();
          $data['id_organisation'] = $this->id_organisation;
          $data['path_logo'] = $this->path_logo;
          $data['nom_organisation'] = $this->nom_organisation;
          $this->load->view('home/dashboard', $data); // just the header file
          $this->load->view('prescription', $data);
          $this->load->view('home/footer'); // just the header file */
    }

    function all()
    {

        if (!$this->ion_auth->in_group(array('admin', 'Doctor', 'Pharmacist', 'adminmedecin'))) {
            redirect('home/permission');
        }

        $data['medicines'] = $this->medicine_model->getMedicine();
        $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['prescriptions'] = $this->prescription_model->getPrescription($this->id_organisation);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pharmacists'] = $this->pharmacist_model->getPharmacist();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('all_prescription', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function genererDocument()
    {
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $accessKey = 'ODBiYzNkNzItYWE2Ni00ZGIzLWE0YzgtY2MzYjYzODkwZmRjOjA4MjQ5MjQ';
        $DWSRenderURL = 'https://eu.dws3.docmosis.com/api/render';
        $templateName =  'ecoMed24.dev/LabResultTemplate_V1.docx';
        $outputName = 'WelcomeOuput.pdf';

        $data = '{
            "organisationID":"257",
            "doctorList":[
               {
                  "doctorFirstName":"MAODO",
                  "doctorLastName":"DIEYE2 "
               },
               {
                  "doctorFirstName":"Khalifa Babacar",
                  "doctorLastName":"GUEYE1"
               },
               {
                  "doctorFirstName":"AIDA",
                  "doctorLastName":"TOURE"
               },
               {
                  "doctorFirstName":"AIDA",
                  "doctorLastName":"TOURE"
               },
               {
                  "doctorFirstName":"AHMAD",
                  "doctorLastName":"NIANG 2"
               },
               {
                  "doctorFirstName":"Amadou",
                  "doctorLastName":"BATHILY"
               },
               {
                  "doctorFirstName":"Dr",
                  "doctorLastName":"DIAZ"
               },
               {
                  "doctorFirstName":"Jean David",
                  "doctorLastName":"BONKOUNGOU"
               },
               {
                  "doctorFirstName":"Ndeye",
                  "doctorLastName":"Waré"
               }
            ],
            "organisationAddress":"Parcelle Nord villa N 780, Thies 339510919/764308448-ahmadouboye@yahoo.fr",
            "resultQR":"http://localhost/aristo2/uploads/qrcode/asda1427197380.png",
            "organisationLogo":"image:base64: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",
            "patientName":"Modou inoooo Dieyeee",
            "patientID":"00321",
            "patientDOB":"06/01/1955",
            "patientAge":"67",
            "patientGender":"M",
            "receivedDate":"12/12/2022 23:12",
            "receivedTime":"",
            "collectedDate":"12/12/2022 23:13",
            "collectedTime":"",
            "reportedDate":"",
            "reportedTime":"",
            "orderingDoctor":"Dr Ibnou Diagne",
            "orderingOrganisationID":"257",
            "orderingOrganisationName":"Laboratoires Noflaye",
            "orderNumber":"1061",
            "clinicalNotes":"",
            "specialtyList":[
               {
                  "specialtyID":"293",
                  "specialtyName":"Hormonologie",
                  "testList":[
                     {
                        "id":"864",
                        "id_spe":"293",
                        "testOrdered":"ACTH-Corticotrophine",
                        "observations":" ",
                        "resultats":[
                           {
                              "id_para":"593",
                              "nom_parametre":"ACTH-Corticotrophine",
                              "resultats":"30",
                              "unite":"ng/l",
                              "valeurs":"5 - 60",
                              "testAnterieurs":[
                                 {
                                    "resultDate":"12/12/2022 23:09",
                                    "resultats":"6"
                                 },
                                 {
                                    "resultDate":"02/12/2022 18:44",
                                    "resultats":"50"
                                 }
                              ]
                           },
                           {
                              "id_para":"594",
                              "nom_parametre":"ACTH-Corticotrophine",
                              "resultats":"14",
                              "unite":"pmol/l",
                              "valeurs":"1,1 - 13,2",
                              "testAnterieurs":[
                                 {
                                    "resultDate":"12/12/2022 23:09",
                                    "resultats":"13"
                                 },
                                 {
                                    "resultDate":"02/12/2022 18:44",
                                    "resultats":"1"
                                 }
                              ]
                           }
                        ]
                     }
                  ]
               }
            ]
         }';

        $request = array(
            "accessKey" => $accessKey,
            "templateName" => "$templateName",
            "outputName" => "$outputName",
            "data" => "$data",
            "devMode" => "yes"
        );


        $requestHeaders = array('Content-Type' => 'multipart/form-data');

        $ch = curl_init($DWSRenderURL);

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $responseData = curl_exec($ch);

        if ($responseData != false) {

            $headers = curl_getinfo($ch);
            curl_close($ch);

            if ($headers['http_code'] == '200') {

                $tempDirName = "uploads/invoicefile/";
                $tempFileName = realpath($tempDirName) . "/" . $outputName;

                $renderedFile = file_put_contents($tempFileName, $responseData);

                //  echo "File saved to $tempFileName\n";
                //  $ressource = fopen('C:/Users/limou/Documents/ecomed24/WelcomeOuput.docx', 'rb');
                //     echo fread($ressource, filesize('WelcomeOuput.docx'));
                $this->load->view('home/dashboard', $data); // just the header file
                $this->load->view('generateDocument', $data);
                $this->load->view('home/footer'); // just the header file

            } else {
                // failed - check error and result message
                echo "Failed:" . $responseData . "\n";
            }
        } else {

            echo "curlexec failed.\n\nDocmosis Cloud must be used via HTTPS.\n\nCheck your CA certificates, or try un-commenting CURLOPT_SSL_VERIFYPEER line (for troubleshooting only)";
        }
    }

    public function addPrescriptionView()
    {

        if (!$this->ion_auth->in_group(array('Doctor', 'adminmedecin'))) {
            redirect('home/permission');
        }

        $data = array();
        $data['medicines'] = $this->medicine_model->getMasterMedicine();
        $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['types'] = $this->medicine_model->getMedicineType();
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_prescription_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function uploadPresceiption()
    {
        $date = $this->input->post('date');
        //        $patient_id = $this->input->post('patient');
        $img_url = $this->input->post('img_url');

        $redirect = $this->input->post('redirect');

        $date = time();

        $codeFacture = 'O' . $this->code_organisation . '' . str_pad($count_ordonance, 4, "0", STR_PAD_LEFT);
        $patient = $this->input->post('patient');
        $doctor = $this->input->post('doctor');

        if (empty($redirect)) {
            $redirect = "patient/medicalHistory?id=" . $patient;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', lang('validation_error'));
            redirect($redirect);
        } else {



            $patientname = $this->patient_model->getPatientById($patient, $this->id_organisation)->name;
            $patientlastname = $this->patient_model->getPatientById($patient, $this->id_organisation)->last_name;

            $file_name = $_FILES['img_url']['name'];
            $file_name_pieces = explode('_', $file_name);
            $new_file_name = '';
            $count = 1;
            foreach ($file_name_pieces as $piece) {
                if ($count !== 1) {
                    $piece = ucfirst($piece);
                }

                $new_file_name .= $piece;
                $count++;
            }
            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./uploads/",
                'allowed_types' => "gif|jpg|png|jpeg|pdf|docx|doc|odt",
                'overwrite' => False,
                'max_size' => "48000000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "10000",
                'max_width' => "10000"
            );

            $this->load->library('Upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('img_url')) {
                $path = $this->upload->data();
                $img_url = "uploads/" . $path['file_name'];
                $data = array();
                $data = array(
                    'date' => $date,
                    'id_organisation' => $this->id_organisation,
                    'img_url' => $img_url,
                    'doctor' => $doctor,
                    'patient' => $patient,
                    'patientname' => $patientname,
                    'patientlastname' => $patientlastname,
                    'code_facture' => $codeFacture,
                );
            } else {
                $data = array();
                $data = array(
                    'date' => $date,
                    'id_organisation' => $this->id_organisation,
                    'doctor' => $doctor,
                    'patient' => $patient,
                    'patientname' => $patientname,
                    'patientlastname' => $patientlastname,
                    'code_facture' => $codeFacture,
                );
                $this->session->set_flashdata('feedback', lang('upload_error'));
            }

            $this->prescription_model->insertPrescription($data);

            $this->session->set_flashdata('feedback', lang('added'));

            redirect($redirect);
        }
    }

    public function addNewPrescription()
    {

        if (!$this->ion_auth->in_group(array('admin', 'Doctor', 'adminmedecin'))) {
            redirect('home/permission');
        }

        $id = $this->input->post('id');
        $tab = $this->input->post('tab');
        $date = $this->input->post('date');
        $date_string = $this->input->post('date_string');
        $etat = $this->input->post('choicepartenaire');
        $destinataire = $this->input->post('partenaire');
        $count_ordonance = $this->db->get_where('expense', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
        $codeFacture = 'O' . $this->code_organisation . '' . str_pad($count_ordonance, 4, "0", STR_PAD_LEFT);
        $labtest = $this->input->post('labtest');
        if (!empty($labtest)) {
            $lab_test = implode("##", $labtest);
        } else {
            $lab_test = ' ';
        }

        if (!empty($date)) {
            $date = strtotime($date);
        } else {
            $date = time();
        }

        $patient = $this->input->post('patient');
        $doctor = $this->input->post('doctor');
        $symptom = $this->input->post('symptom');
        $medicine = $this->input->post('medicine');
        $medicament = $this->input->post('medicament');
        $dosage = $this->input->post('dosage');
        $frequency = $this->input->post('frequency');
        $days = $this->input->post('days');
        $instruction = $this->input->post('instruction');
        $note = $this->input->post('note');
        $admin = $this->input->post('admin');

        $advice = $this->input->post('advice');

        $report = array();

        if (!empty($medicine)) {
            foreach ($medicine as $key => $value) {
                $report[$value] = array(
                    'dosage' => $dosage[$key],
                    'frequency' => $frequency[$key],
                    'days' => $days[$key],
                    'instruction' => $instruction[$key],
                );

                // }
            }

            foreach ($report as $key1 => $value1) {
                $final[] = $key1 . '***' . implode('***', $value1);
            }

            $final_report = implode('###', $final);
        } else {
            $final_report = '';
        }





        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Doctor Field
        $this->form_validation->set_rules('doctor', 'Doctor', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Advice Field
        $this->form_validation->set_rules('symptom', 'History', 'trim|min_length[1]|max_length[1000]|xss_clean');
        // Validating Do And Dont Name Field
        $this->form_validation->set_rules('note', 'Note', 'trim|min_length[1]|max_length[1000]|xss_clean');

        // Validating Advice Field
        $this->form_validation->set_rules('advice', 'Advice', 'trim|min_length[1]|max_length[1000]|xss_clean');

        // Validating Validity Field
        $this->form_validation->set_rules('validity', 'Validity', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect('prescription/editPrescription?id=' . $id);
            } else {
                $data = array();

                $data['setval'] = 'setval';
                $data['medicines'] = $this->medicine_model->getMedicine();
                $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
                $data['doctors'] = $this->doctor_model->getDoctor();
                $data['settings'] = $this->settings_model->getSettings();
                $this->load->view('home/dashboard', $data); // just the header file
                $this->load->view('add_new_prescription_view', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $data = array();
            $patientname = $this->patient_model->getPatientById($patient, $this->id_organisation)->name;
            $patientlastname = $this->patient_model->getPatientById($patient, $this->id_organisation)->last_name;
            $doctorname = $this->doctor_model->getDoctorById($doctor)->name;
            $data = array(
                'date' => $date,
                'patient' => $patient,
                'doctor' => $doctor,
                'symptom' => $symptom,
                'medicine' => $final_report,
                'note' => $note,
                'advice' => $advice,
                'patientname' => $patientname,
                'patientlastname' => $patientlastname,
                'doctorname' => $doctorname,
                'date_string' => $date_string,
                'medicament' => $medicament,
                'id_organisation' => $this->id_organisation,
                'user' => $this->ion_auth->get_user_id(),
                'etat' => $etat,
                'organisation_destinataire' => $destinataire,
                'code_facture' => $codeFacture,
                'lab_test' => $lab_test
            );
            if (empty($id)) {


                $this->prescription_model->insertPrescription($data);
                $inserted_id = $this->db->insert_id();
                $link = base_url() . 'qrcode?id=' . $inserted_id;
                $data_get = $this->generate_qrcode($link);
                $data_update = array('qr_code' => $data_get['file']);
                // var_dump($link.' , '.$data_get.' , '.$data_get['file']);
                // exit();
                $this->prescription_model->updatePrescription($inserted_id, $data_update);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->prescription_model->updatePrescription($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }

            if (!empty($admin)) {
                if ($this->ion_auth->in_group(array('Doctor'))) {
                    redirect('prescription');
                } else {
                    redirect('prescription/all');
                }
            } else {
                redirect('prescription');
            }
        }
    }


    public function downloadMediciament()
    {
        // Set up the token endpoint and parameters
        $tokenEndpoint = "https://icdaccessmanagement.who.int/connect/token";
        $clientId = "a54b020b-d933-4263-8551-4abe94555bf0_46cf15f9-3bf4-4ec4-b1d6-4d5502eba407";
        $clientSecret = "hW/TVRzhE9mGPz5AXmSdr7itMY3uftYkW2icJc8MDRM=";
        $scope = "icdapi_access";

        // Set up the curl request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenEndpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            "client_id" => $clientId,
            "client_secret" => $clientSecret,
            "grant_type" => "client_credentials",
            "scope" => $scope
        )));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Make the request and store the response
        $response = curl_exec($ch);
        curl_close($ch);

        // Parse the JSON response
        $data = json_decode($response, true);

        // Extract the access token
        $accessToken = $data["access_token"];
        $medicament = $this->input->post('medicament');
        // Set up the API endpoint and parameters
        $endpoint = "https://id.who.int/icd/entity/";
        $identifiant = "448895267";
        $search = "search?q={$medicament}";
        $useFlexisearch = "useFlexisearch=false";
        $flatResults = "flatResults=true";
        $highlightingEnabled = "highlightingEnabled=true";
        $url = "{$endpoint}{$search}&{$useFlexisearch}&{$flatResults}&{$highlightingEnabled}";


        // Set up the curl request with the access token
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "API-Version: v2",
            "Accept-Language: en",
            "Authorization: Bearer {$accessToken}"
        ));

        // Make the request and store the response
        $response = curl_exec($ch);
        curl_close($ch);


        // Parse the JSON response and extract the desired data
        $data = json_decode($response);

        // Affichage des maladies
        foreach ($data->destinationEntities as $chapter) {
            foreach ($chapter->matchingPVs as $matchingPVs) {
                echo 'propertyID : '.$matchingPVs->propertyId . " | label : ". $matchingPVs->label . " | foundationUri : " .$matchingPVs->foundationUri. "\n";
                
            }
        }
        // echo "Preferred term: {$preferredTerm}";
    }

    function generate_qrcode($data)
    {

        $this->load->library('ciqrcode');

        /* Data */
        $hex_data = bin2hex($data);
        $save_name = 'asda' . rand() . '.png';

        /* QR Code File Directory Initialize */
        $dir = './uploads/qrcode/';
        if (!file_exists($dir)) {
            mkdir($dir, 0775, true);
        }

        /* QR Configuration  */
        $config['cacheable'] = true;
        $config['imagedir'] = $dir;
        $config['quality'] = true;
        $config['size'] = '1024';
        $config['black'] = array(255, 255, 255);
        $config['white'] = array(255, 255, 255);
        $this->ciqrcode->initialize($config);

        /* QR Data  */
        $params['data'] = $data;
        $params['level'] = 'L';
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $save_name;

        $this->ciqrcode->generate($params);

        /* Return Data */
        $return = array(
            'content' => $data,
            'file' => $save_name
        );

        return $return;
    }

    public function renewPrescription()
    {

        if (!$this->ion_auth->in_group(array('admin', 'Doctor', 'adminmedecin'))) {
            redirect('home/permission');
        }

        $id = $this->input->post('id');
        $renew_id = $this->input->post('renew_id');
        $renew_date = $this->input->post('renew_date');

        if (!empty($renew_date)) {
            $renew_date = strtotime($renew_date);
        } else {
            $renew_date = time();
        }

        $data = array();
        $prescriptiondate = $this->prescription_model->getPrescriptionById($renew_id)->date;
        $prescriptionpatient = $this->prescription_model->getPrescriptionById($renew_id)->patient;
        $prescriptiondoctor = $this->prescription_model->getPrescriptionById($renew_id)->doctor;
        $prescriptionsymptom = $this->prescription_model->getPrescriptionById($renew_id)->symptom;
        $prescriptionmedicine = $this->prescription_model->getPrescriptionById($renew_id)->medicine;
        $prescriptionnote = $this->prescription_model->getPrescriptionById($renew_id)->note;
        $prescriptionadvice = $this->prescription_model->getPrescriptionById($renew_id)->advice;
        $prescriptionpatientname = $this->prescription_model->getPrescriptionById($renew_id)->patientname;
        $prescriptionpatientlastname = $this->prescription_model->getPrescriptionById($renew_id)->patientlastname;
        $prescriptiondoctorname = $this->prescription_model->getPrescriptionById($renew_id)->doctorname;
        $prescriptiondate_string = $this->prescription_model->getPrescriptionById($renew_id)->date_string;
        $prescriptionmedicament = $this->prescription_model->getPrescriptionById($renew_id)->medicament;
        $prescription_id_organisation = $this->prescription_model->getPrescriptionById($renew_id)->id_organisation;
        $prescriptionuser = $this->prescription_model->getPrescriptionById($renew_id)->user;
        $prescriptionetat = $this->prescription_model->getPrescriptionById($renew_id)->etat;
        $prescription_organisation_destinataire = $this->prescription_model->getPrescriptionById($renew_id)->organisation_destinataire;
        $prescriptioncode_facture = $this->prescription_model->getPrescriptionById($renew_id)->code_facture;
        $data = array(
            'renew_date' => $renew_date,
            'date' => $prescriptiondate,
            'patient' => $prescriptionpatient,
            'doctor' => $prescriptiondoctor,
            'symptom' => $prescriptionsymptom,
            'medicine' => $prescriptionmedicine,
            'note' => $prescriptionnote,
            'advice' => $prescriptionadvice,
            'patientname' => $prescriptionpatientname,
            'patientlastname' => $prescriptionpatientlastname,
            'doctorname' => $prescriptiondoctorname,
            'date_string' => $prescriptiondate_string,
            'medicament' => $prescriptionmedicament,
            'id_organisation' => $prescription_id_organisation,
            'user' => $prescriptionuser,
            'etat' => $prescriptionetat,
            'organisation_destinataire' => $prescription_organisation_destinataire,
            'code_facture' => $prescriptioncode_facture,
        );

        $this->prescription_model->insertPrescription($data);
        $this->session->set_flashdata('feedback', lang('added'));

        if (!empty($admin)) {
            if ($this->ion_auth->in_group(array('Doctor'))) {
                redirect('prescription');
            } else {
                redirect('prescription/all');
            }
        } else {
            redirect('prescription');
        }
    }

    public function transferPrescription()
    {

        if (!$this->ion_auth->in_group(array('admin', 'Doctor', 'adminmedecin'))) {
            redirect('home/permission');
        }

        $id = $this->input->post('id');
        $transfer_id = $this->input->post('transfer_id');
        $pharmacist = $this->input->post('pharmacist');

        if (!empty($renew_date)) {
            $renew_date = strtotime($renew_date);
        } else {
            $renew_date = time();
        }

        $data = array();
        $prescriptiondate = $this->prescription_model->getPrescriptionById($transfer_id)->date;
        $prescriptionpatient = $this->prescription_model->getPrescriptionById($transfer_id)->patient;
        $prescriptiondoctor = $this->prescription_model->getPrescriptionById($transfer_id)->doctor;
        $prescriptionsymptom = $this->prescription_model->getPrescriptionById($transfer_id)->symptom;
        $prescriptionmedicine = $this->prescription_model->getPrescriptionById($transfer_id)->medicine;
        $prescriptionnote = $this->prescription_model->getPrescriptionById($transfer_id)->note;
        $prescriptionadvice = $this->prescription_model->getPrescriptionById($transfer_id)->advice;
        $prescriptionpatientname = $this->prescription_model->getPrescriptionById($transfer_id)->patientname;
        $prescriptionpatientlastname = $this->prescription_model->getPrescriptionById($transfer_id)->patientlastname;
        $prescriptiondoctorname = $this->prescription_model->getPrescriptionById($transfer_id)->doctorname;
        $prescriptiondate_string = $this->prescription_model->getPrescriptionById($transfer_id)->date_string;
        $prescriptionmedicament = $this->prescription_model->getPrescriptionById($transfer_id)->medicament;
        $prescription_id_organisation = $pharmacist;
        $prescriptionuser = $this->prescription_model->getPrescriptionById($transfer_id)->user;
        $prescriptionetat = $this->prescription_model->getPrescriptionById($transfer_id)->etat;
        $prescription_organisation_destinataire = $this->prescription_model->getPrescriptionById($transfer_id)->organisation_destinataire;
        $prescriptioncode_facture = $this->prescription_model->getPrescriptionById($transfer_id)->code_facture;
        $doctor_details = $this->doctor_model->getDoctorById($prescriptiondoctor);
        $data = array(
            'date' => $prescriptiondate,
            'patient' => $prescriptionpatient,
            'doctor' => $prescriptiondoctor,
            'symptom' => $prescriptionsymptom,
            'medicine' => $prescriptionmedicine,
            'note' => $prescriptionnote,
            'advice' => $prescriptionadvice,
            'patientname' => $prescriptionpatientname,
            'patientlastname' => $prescriptionpatientlastname,
            'doctorname' => $prescriptiondoctorname,
            'date_string' => $prescriptiondate_string,
            'medicament' => $prescriptionmedicament,
            'id_organisation' => $prescription_id_organisation,
            'user' => $prescriptionuser,
            'etat' => $prescriptionetat,
            'organisation_destinataire' => $prescription_organisation_destinataire,
            'code_facture' => $prescriptioncode_facture,
            'status' => 'Pending',
            'prescription_id' => $transfer_id,
            'add_date' => time()
        );

        $this->prescription_model->insertTransferPrescription($data);

        $prescription_id = $transfer_id;
        $data_up['prescription'] = $this->prescription_model->getPrescriptionById($prescription_id);
        $data_up['settings'] = $this->settings_model->getSettings();
        $data_up['id_organisation'] = $this->id_organisation;
        $data_up['path_logo'] = $this->path_logo;
        $data_up['address'] = $this->address;
        $data_up['nom_organisation'] = $this->nom_organisation;
        $data_up['download'] = 'download';

        error_reporting(0);
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
        $mpdf->SetHTMLFooter('
<div style="text-align:right;font-weight: bold; font-size: 8pt; font-style: italic;">' .
            '<img class="foot" src="uploads/FooterA4.jpeg" width="750" height="60" alt="alt"/>' .
            '</div>', 'O');
        $html = $this->load->view('download', $data_up, true);
        $mpdf->WriteHTML($html);

        $filename = "prescription--00" . $id . ".pdf";

        $mpdf->Output('uploads/invoicefile/' . $filename, 'F');
        $id_organisation = $this->id_organisation;
        $email = $this->db->get_where('organisation', array('id' => $pharmacist))->row()->email;

        $subject = lang('prescription');
        $this->load->library('encryption');
        $this->email->from($email);
        $this->email->to($doctor_details->email);
        $this->email->subject($subject);
        $this->email->message('<br>Please Find Prescription');
        $this->email->attach('uploads/invoicefile/' . $filename);
        if ($this->email->send()) {
            unlink('uploads/invoicefile/' . $filename);
            //                $this->session->set_flashdata('feedback', 'Send Lab Report');
            //                $data_transfer = array('transfer' => 'yes');
            //                $this->lab_model->updateLabReport($id, $data_transfer);
        } else {
            unlink(APPPATH . '../invoicefile/' . $filename);
        }
        $this->session->set_flashdata('feedback', lang('added'));

        if ($this->ion_auth->in_group(array('Doctor'))) {
            redirect('prescription/transferedPrescription');
        }
    }

    function transferedPrescription()
    {
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('transfer_prescription', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function receivedPrescription()
    {
        $data = array();
        $id = $this->input->get("id");
        $data = array('status' => 'Received');
        $this->prescription_model->updateTransferPrescription($id, $data);
        redirect('prescription/transferedPrescription');
    }

    function deliveredPrescription()
    {
        $data = array();
        $id = $this->input->get("id");
        $data = array('status' => 'Delivered');
        $this->prescription_model->updateTransferPrescription($id, $data);
        redirect('prescription/transferedPrescription');
    }

    function expiredPrescription()
    {
        $data = array();
        $id = $this->input->get("id");
        $data = array('status' => 'Expeired');
        $this->prescription_model->updateTransferPrescription($id, $data);
        redirect('prescription/transferedPrescription');
    }

    function viewPrescription()
    {
        $id = $this->input->get('id');
        $data['prescription'] = $this->prescription_model->getPrescriptionById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['address'] = $this->address;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('prescription_view_1', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function download()
    {
        $redirect = $this->input->get('redirect');
        $id = $this->input->get('id');
        $data['prescription'] = $this->prescription_model->getPrescriptionById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['address'] = $this->address;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['download'] = 'download';

        error_reporting(0);
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
        $mpdf->SetHTMLFooter('
<div style="text-align:right;font-weight: bold; font-size: 8pt; font-style: italic;">' .
            '<img class="foot" src="uploads/FooterA4.jpeg" width="750" height="60" alt="alt"/>' .
            '</div>', 'O');
        $html = $this->load->view('download', $data, true);
        $mpdf->WriteHTML($html);

        $filename = "prescription--00" . $id . ".pdf";

        $mpdf->Output($filename, 'D');
        if (empty($redirect)) {
            redirect("prescription/all");
        } else {
            redirect("prescription/viewPrescription?id=" . $id);
        }
    }

    function viewPrescriptionPrint()
    {
        $id = $this->input->get('id');
        $data['prescription'] = $this->prescription_model->getPrescriptionById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('prescription_view_print', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function editPrescription()
    {
        $data = array();
        $id = $this->input->get('id');
        // $data['patients'] = $this->patient_model->getPatient();
        // $data['doctors'] = $this->doctor_model->getDoctor();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['medicines'] = $this->medicine_model->getMedicine();
        $data['prescription'] = $this->prescription_model->getPrescriptionById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['patients'] = $this->patient_model->getPatientById($data['prescription']->patient, $this->id_organisation);
        $data['doctors'] = $this->doctor_model->getDoctorById($data['prescription']->doctor);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_prescription_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editPrescriptionProvenant()
    {
        $data = array();
        $id = $this->input->get('id');
        // $data['patients'] = $this->patient_model->getPatient();
        // $data['doctors'] = $this->doctor_model->getDoctor();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['medicines'] = $this->medicine_model->getMedicine();
        $data['prescription'] = $this->prescription_model->getPrescriptionById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['patients'] = $this->patient_model->getPatientById($data['prescription']->patient, $this->id_organisation);
        $data['doctors'] = $this->doctor_model->getDoctorById($data['prescription']->doctor);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_prescription_provenant', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editPrescriptionByJason()
    {
        $id = $this->input->get('id');
        $data['prescription'] = $this->prescription_model->getPrescriptionById($id);
        echo json_encode($data);
    }

    function getPrescriptionByPatientIdByJason()
    {
        $id = $this->input->get('id');
        $prescriptions = $this->prescription_model->getPrescriptionByPatientId($id);
        foreach ($prescriptions as $prescription) {
            $lists[] = ' <div class="pull-left prescription_box" style = "padding: 10px; background: #fff;"><div class="prescription_box_title">Prescription Date</div> <div>' . date('d-m-Y', $prescription->date) . '</div> <div class="prescription_box_title">Medicine</div> <div>' . $prescription->medicine . '</div> </div> ';
        }
        $data['prescription'] = $lists;
        $lists = NULL;
        echo json_encode($data);
    }

    function delete()
    {
        $id = $this->input->get('id');
        $admin = $this->input->get('admin');
        $patient = $this->input->get('patient');
        $this->prescription_model->deletePrescription($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        if (!empty($patient)) {
            redirect('patient/caseHistory?patient_id=' . $patient);
        } elseif (!empty($admin)) {
            redirect('prescription/all');
        } else {
            redirect('prescription');
        }
    }

    public function prescriptionCategory()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['categories'] = $this->prescription_model->getPrescriptionCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('prescription_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addCategoryView()
    {
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_category_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewCategory()
    {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $description = $this->input->post('description');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Name Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_new_category_view', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array(
                'category' => $category,
                'description' => $description
            );
            if (empty($id)) {
                $this->prescription_model->insertPrescriptionCategory($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->prescription_model->updatePrescriptionCategory($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('prescription/prescriptionCategory');
        }
    }

    function edit_category()
    {
        $data = array();
        $id = $this->input->get('id');
        $data['prescription'] = $this->prescription_model->getPrescriptionCategoryById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_category_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editPrescriptionCategoryByJason()
    {
        $id = $this->input->get('id');
        $data['prescriptioncategory'] = $this->prescription_model->getPrescriptionCategoryById($id);
        echo json_encode($data);
    }

    function deletePrescriptionCategory()
    {
        $id = $this->input->get('id');
        $this->prescription_model->deletePrescriptionCategory($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('prescription/prescriptionCategory');
    }

    function getPrescriptionListByDoctor()
    {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $doctor_ion_id = $this->ion_auth->get_user_id();
        $doctor = $this->db->get_where('doctor', array('ion_user_id' => $doctor_ion_id))->row()->id;
        if ($limit == -1) {
            if (!empty($search)) {
                $data['prescriptions'] = $this->prescription_model->getPrescriptionBysearchByDoctor($doctor, $search);
            } else {
                $data['prescriptions'] = $this->prescription_model->getPrescriptionByDoctor($doctor);
            }
        } else {
            if (!empty($search)) {
                $data['prescriptions'] = $this->prescription_model->getPrescriptionByLimitBySearchByDoctor($doctor, $limit, $start, $search);
            } else {
                $data['prescriptions'] = $this->prescription_model->getPrescriptionByLimitByDoctor($doctor, $limit, $start);
            }
        }


        //  $data['patients'] = $this->patient_model->getVisitor();
        $i = 0;
        $option1 = '';
        $option2 = '';
        $option3 = '';
        foreach ($data['prescriptions'] as $prescription) {
            //$i = $i + 1;
            $settings = $this->settings_model->getSettings();

            $option1 = '<a class="btn btn-info btn-xs btn_width" href="prescription/viewPrescription?id=' . $prescription->id . '"><i class="fa fa-eye">' . lang('view') . ' ' . lang('prescription') . ' </i></a>';
            $option3 = '<a class="btn btn-info btn-xs btn_width" href="prescription/editPrescription?id=' . $prescription->id . '" data-id="' . $prescription->id . '"><i class="fa fa-edit"></i> ' . lang('edit') . ' ' . lang('prescription') . '</a>';
            $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="prescription/delete?id=' . $prescription->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i></a>';
            $options4 = '<a class="btn btn-info btn-xs invoicebutton" title="' . lang('print') . '" style="color: #fff;" href="prescription/viewPrescriptionPrint?id=' . $prescription->id . '"target="_blank"> <i class="fa fa-print"></i> ' . lang('print') . '</a>';

            if (!empty($prescription->medicine)) {
                $medicine = explode('###', $prescription->medicine);
                $medicinelist = '';
                foreach ($medicine as $key => $value) {
                    $medicine_id = explode('***', $value);
                    $medicine_name_with_dosage = $this->medicine_model->getMedicineById($medicine_id[0])->name . ' -' . $medicine_id[1];
                    $medicine_name_with_dosage = $medicine_name_with_dosage . ' | ' . $medicine_id[3] . '<br>';
                    rtrim($medicine_name_with_dosage, ',');
                    $medicinelist .= '<p>' . $medicine_name_with_dosage . '</p>';
                }
            }
            $patientdetails = $this->patient_model->getPatientById($prescription->patient, $this->id_organisation);
            if (!empty($patientdetails)) {
                $patientname = $patientdetails->name;
            } else {
                $patientname = $prescription->patientname;
            }
            $info[] = array(
                $prescription->id,
                date('d-m-y H:i', $prescription->date),
                $patientname,
                $prescription->patient,
                $medicinelist,
                $option1 . ' ' . $option3 . ' ' . $option2 . ' ' . $options4
            );
            $i = $i + 1;
        }

        if ($data['prescriptions']) {
            $output = array(
                "draw" => intval($requestData['draw']),
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

    function getPrescriptionList()
    {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $data['prescriptions'] = $this->prescription_model->getPrescription($this->id_organisation);

        //  $data['patients'] = $this->patient_model->getVisitor();
        $i = 0;
        $option1 = '';
        $option2 = '';
        $option3 = '';
        foreach ($data['prescriptions'] as $prescription) {
            //$i = $i + 1;
            $settings = $this->settings_model->getSettings();

            $option1 = '<a class="btn btn-info btn-xs detailsbutton" title="Infos" href="prescription/viewPrescription?id=' . $prescription->id . '"><i class="fa fa-info"></i> ' . lang('info') . '</a>';
            $option3 = ''; //<a class="btn btn-info btn-xs btn_width" href="prescription/editPrescription?id=' . $prescription->id . '" data-id="' . $prescription->id . '"><i class="fa fa-edit"></i> ' . lang('edit'). '</a>';
            if (!empty($prescription->img_url)) {
                $file = '<a class="btn btn-info btn-xs btn_width" target="_blank" href=" ' . $prescription->img_url . '" ><i class="fa fa-eye"></i> File</a>';
            } else {
                $file = '';
            }
            if (empty($prescription->img_url)) {
                $renew = '<button type="button" class="btn btn-info btn-xs btn_width load" data-toggle="modal" data-id="' . $prescription->id . '">' . lang('renew') . '</button>';
            } else {
                $renew = '';
            }
            if (empty($prescription->img_url)) {
                $transfer = '<button type="button" class="btn btn-info btn-xs btn_width transfer" data-toggle="modal" data-id="' . $prescription->id . '">' . lang('transfer') . '</button>';
            } else {
                $transfer = '';
            }
            $download = '<a class="btn btn-info btn-sm detailsbutton pull-left download" href="prescription/download?id=' . $prescription->id . '" id="download"><i class="fa fa-download"></i>' . lang('download') . '</a>';
            $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="prescription/delete?id=' . $prescription->id . '&admin=' . $prescription->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i></a>';
            $options4 = '<a class="btn btn-info btn-xs invoicebutton" title="' . lang('print') . '" style="color: #fff;" href="prescription/viewPrescriptionPrint?id=' . $prescription->id . '"target="_blank"> <i class="fa fa-print"></i> ' . lang('print') . '</a>';

            if (!empty($prescription->medicine)) {
                $medicine = explode('###', $prescription->medicine);
                $medicinelist = '';
                foreach ($medicine as $key => $value) {
                    $medicine_id = explode('***', $value);
                    $medicine_name_with_dosage = $this->medicine_model->getMasterMedicineById($medicine_id[0])->name . ' -' . $medicine_id[1];
                    $medicine_name_with_dosage = $medicine_name_with_dosage . ' | ' . $medicine_id[3] . '<br>';
                    rtrim($medicine_name_with_dosage, ',');
                    $medicinelist .= '<p>' . $medicine_name_with_dosage . '</p>';
                }
            } else {
                $medicinelist = '';
            }
            $patientdetails = $this->patient_model->getPatientById($prescription->patient, $this->id_organisation);
            if (!empty($patientdetails)) {
                $patientname = $patientdetails->name;
            } else {
                $patientname = $prescription->patientname;
            }
            $patient_id = $patientdetails->patient_id;
            $doctordetails = $this->prescription_model->getUserById($prescription->doctor);
            $doctorname = '';
            if (isset($doctordetails)) {
                $doctorname = $doctordetails->first_name . ' ' . $doctordetails->last_name;
            }

            if ($this->ion_auth->in_group(array('Pharmacist', 'Doctor', 'Receptionist'))) {
                $option2 = '';
                $option3 = '';
            }

            $transferts = '';
            $organisation_dest = $this->home_model->getOrganisationById($prescription->organisation_destinataire);
            if ($prescription->organisation_destinataire) {
                if (!empty($organisation_dest) && $this->id_organisation === $prescription->id_organisation) {

                    $transferts .= '<br/>Transfert vers ' . $organisation_dest->nom;
                    $option3 = '';
                } else if (!empty($organisation_dest) && $this->id_organisation === $prescription->organisation_destinataire) {
                    $id = $prescription->id_organisation;
                    $patient = $prescription->patient;
                    $transferts .= '<br/>provenant de ' . $this->home_model->getOrganisationById($prescription->id_organisation)->nom;
                    // $option3 = '<a class="btn btn-info btn-xs btn_width" href="prescription/editPrescriptionProvenant?id=' . $prescription->id .'&idpartenaire='.$id .'&idpatient='.$patient.'"><i class="fa fa-edit"></i> ' . lang('edit'). '</a>';
                    $option3 = '';
                }
            }



            $info[] = array(
                date('d-m-y H:i', $prescription->date),
                $doctorname,
                $prescription->patientname . ' ' . $prescription->patientlastname,
                $medicinelist,
                $patient_id,
                $file,
                $option1 . ' ' . $option3 . ' ' . $options4 . ' ' . $renew . ' ' . $transfer . ' ' . $download
            );
            $i = $i + 1;
        }

        if ($data['prescriptions']) {
            $output = array(
                "draw" => intval($requestData['draw']),
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

    function getTransferedPrescriptionList()
    {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        if ($this->ion_auth->in_group(array('Pharmacist'))) {
            $pharmacist_ion_id = $this->ion_auth->get_user_id();
            $pharmacist = $this->db->get_where('pharmacist', array('ion_user_id' => $pharmacist_ion_id))->row()->id;
            if ($limit == -1) {
                if (!empty($search)) {
                    $data['prescriptions'] = $this->prescription_model->getTransferedPrescriptionBySearchByPharmacist($pharmacist, $search);
                } else {
                    $data['prescriptions'] = $this->prescription_model->getTransferedPrescriptionByPharmacist($pharmacist);
                }
            } else {
                if (!empty($search)) {
                    $data['prescriptions'] = $this->prescription_model->getTransferedPrescriptionByLimitBySearchByPharmacist($pharmacist, $limit, $start, $search);
                } else {
                    $data['prescriptions'] = $this->prescription_model->getTransferedPrescriptionByLimitByPharmacist($pharmacist, $limit, $start);
                }
            }
        }
        if ($this->ion_auth->in_group(array('Doctor'))) {
            $doctor_ion_id = $this->ion_auth->get_user_id();
            $doctor = $this->ion_auth->user()->row()->id;
            if ($limit == -1) {
                if (!empty($search)) {
                    $data['prescriptions'] = $this->prescription_model->getTransferedPrescriptionBySearchByDoctor($doctor, $search);
                } else {
                    $data['prescriptions'] = $this->prescription_model->getTransferedPrescriptionByDoctor($doctor);
                }
            } else {
                if (!empty($search)) {
                    $data['prescriptions'] = $this->prescription_model->getTransferedPrescriptionByLimitBySearchByDoctor($doctor, $limit, $start, $search);
                } else {
                    $data['prescriptions'] = $this->prescription_model->getTransferedPrescriptionByLimitByDoctor($doctor, $limit, $start);
                }
            }
        } else {
            $data['prescriptions'] = $this->prescription_model->getTransferedPrescription();
        }

        //  $data['patients'] = $this->patient_model->getVisitor(); 
        $i = 0;
        $option1 = '';
        $option2 = '';
        $option3 = '';
        foreach ($data['prescriptions'] as $prescription) {
            //$i = $i + 1;
            $settings = $this->settings_model->getSettings();

            $option1 = '<a class="btn btn-info btn-xs btn_width" href="prescription/viewPrescription?id=' . $prescription->prescription_id . '"><i class="fa fa-eye">' . lang('view') . ' ' . lang('prescription') . ' </i></a>';
            $option3 = '<a class="btn btn-info btn-xs btn_width" href="prescription/editPrescription?id=' . $prescription->id . '" data-id="' . $prescription->id . '"><i class="fa fa-edit"></i> ' . lang('edit') . ' ' . lang('prescription') . '</a>';
            $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="prescription/delete?id=' . $prescription->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i></a>';
            $options4 = '<a class="btn btn-info btn-xs invoicebutton" title="' . lang('print') . '" style="color: #fff;" href="prescription/viewPrescriptionPrint?id=' . $prescription->prescription_id . '"target="_blank"> <i class="fa fa-print"></i> ' . lang('print') . '</a>';
            $download = '<a class="btn btn-info btn-sm detailsbutton pull-left download" href="prescription/download?id=' . $prescription->prescription_id . '"><i class="fa fa-download"></i>' . lang('download') . '</a>';
            if (!empty($prescription->medicine)) {
                $medicine = explode('###', $prescription->medicine);

                $medicinelist = '';
                foreach ($medicine as $key => $value) {
                    $medicine_id = explode('***', $value);

                    $medicine_name_with_dosage = $this->medicine_model->getMasterMedicineById($medicine_id[0])->name . ' -' . $medicine_id[1];

                    $medicine_name_with_dosage = $medicine_name_with_dosage . ' | ' . $medicine_id[3] . '<br>';
                    rtrim($medicine_name_with_dosage, ',');
                    $medicinelist .= '<p>' . $medicine_name_with_dosage . '</p>';
                }
            }
            $patientdetails = $this->patient_model->getPatientById($prescription->patient, $this->id_organisation);
            if (!empty($patientdetails)) {
                $patientname = $patientdetails->name;
            } else {
                $patientname = $prescription->patientname;
            }
            $doctordetails = $this->prescription_model->getUserById($prescription->doctor);
            $doctorname = '';
            if (isset($doctordetails)) {
                $doctorname = $doctordetails->first_name . ' ' . $doctordetails->last_name;
            }
            if ($prescription->status == 'Pending') {
                $received = '<a type="button" class="btn btn-info btn-xs btn_width" href="prescription/receivedPrescription?id=' . $prescription->id . '">' . lang('received') . '</a>';
            } elseif ($prescription->status == 'Delivered') {
                $received = ' ';
            } else {
                $received = ' ';
            }
            if ($prescription->status == 'Pending') {
                $delivered = '<a type="button" class="btn btn-warning btn-xs btn_width" href="prescription/deliveredPrescription?id=' . $prescription->id . '">' . lang('delivered') . '</a>';
            } elseif ($prescription->status == 'Received') {
                $delivered = '<a type="button" class="btn btn-warning btn-xs btn_width" href="prescription/deliveredPrescription?id=' . $prescription->id . '">' . lang('delivered') . '</a>';
            } else {
                $delivered = '';
            }
            if ($prescription->status == 'Pending') {
                $status = lang('pending_');
            } elseif ($prescription->status == 'Received') {
                $status = lang('received');
            } else {
                $status = lang('expired');
            }
            if ($this->ion_auth->in_group(array('Pharmacist'))) {
                $info[] = array(
                    date('d-m-y H:i', $prescription->date),
                    $doctorname,
                    $prescription->patientname . ' ' . $prescription->patientlastname,
                    $medicinelist,
                    $status,
                    $option1 . ' ' . $options4 . ' ' . $received . ' ' . $delivered . ' ' . $download,
                );
            } else {
                $info[] = array(
                    date('d-m-y H:i', $prescription->date),
                    $doctorname,
                    $prescription->patientname . ' ' . $prescription->patientlastname,
                    $medicinelist,
                    $prescription->status,
                    $option1 . ' ' . $options4 . ' ' . $download,
                );
            }
            $i = $i + 1;
        }

        if ($data['prescriptions']) {
            $output = array(
                "draw" => intval($requestData['draw']),
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

    function searhPartenaire()
    {
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->partenaire_model->searhPartenaire($searchTerm, $this->id_organisation);
        echo json_encode($response);
    }

    function otpGenerate()
    {
        $id = $this->ion_auth->get_user_id();
        $users = $this->db->get_where('users', array('id' => $id))->row();
        $phone = $users->phone;
        $email = $users->email;

        $id = $users->id;
        $random_otp = mt_rand(100000, 999999); // A optimiser
        $this->db->query("insert into generated_otp (user_id, mobile_number, email, otp, date_created) VALUES(" . $id . ", \"" . $phone . "\",\"" . $email . "\",\"" . $random_otp . "\",\"" . time() . "\")");
        $inserted_id = $this->db->insert_id('generated_otp');
        $min_avant_expiration = $this->ion_auth->config->item('otp_expiration', 'ion_auth') / 60;

        // Envoi SMS par SMS
        $dataInsert = array(
            'recipient' => $phone,
            // 'message' => $messageprint,
            'message' => "Votre code de vérification valide pour " . $min_avant_expiration . " minutes: " . $random_otp . ". Merci d'utiliser ecoMed24!",
            'date' => time(),
            'user' => $id
        );
        $insert = $this->sms_model->insertLabSms($dataInsert);
        $data['message'] = $dataInsert['message'];
        if ($insert) {
            $data['response'] = 'yes';
            $data['generated_otp_id'] = $inserted_id;
        } else {
            $data['response'] = 'no';
        }
        echo json_encode($data);
    }

    function otpMatch()
    {
        $id = $this->input->get('id');
        $otp = $this->input->get('otp');
        $report_id = $this->input->get('report');

        $report_details = $this->prescription_model->getPrescriptionById($report_id);
        $data['prescription_details'] = $this->prescription_model->getPrescriptionById($report_id);

        $generate_otp = $this->db->get_where('generated_otp', array('id' => $id))->row()->otp;

        if ($generate_otp == $otp) {
            $data['otp'] = 'yes';
            $data['signature'] = $this->db->get_where('users', array('id' => $report_details->user))->row();

            $data_up = array('signature' => 'yes');
            $this->prescription_model->updatePrescription($report_id, $data_up);
        } else {
            $data['otp'] = 'no';
        }

        echo json_encode($data);
    }

    function getAvailablePharmacyList()
    {
        $id = $this->input->get('id');
        $organisations = $this->db->get('organisation')->result();

        $option = '<option value="" selected disabled>' . lang('no_pharmacy') . '</option>';
        foreach ($organisations as $organ) {
            $prescription_list = $this->prescription_model->getPrescriptionById($id);
            if (!empty($prescription_list->medicine)) {
                $medicine_explode = explode("###", $prescription_list->medicine);
                $lang = array();
                foreach ($medicine_explode as $med) {
                    $med_explore = explode("***", $med);

                    $med_details = $this->medicine_model->getMedicineByImportedId($med_explore[0], $organ->id);
                    if (!empty($med_details)) {
                        $lang[] = 'exist';
                    } else {
                        $lang[] = 'nexist';
                    }
                }

                if (!in_array('nexist', $lang)) {
                    $option .= '<option value="' . $organ->id . '">' . $organ->nom . '</option>';
                }
            }
        }
        $data['state'] = $option;
        echo json_encode($data);
    }
}

/* End of file prescription.php */
/* Location: ./application/modules/prescription/controllers/prescription.php */
