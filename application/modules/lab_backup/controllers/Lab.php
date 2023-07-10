<?php

require_once FCPATH . '/vendor/autoload.php';
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lab extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('lab_model');
        $this->load->model('doctor/doctor_model');
        $this->load->model('patient/patient_model');
        $this->load->model('accountant/accountant_model');
        $this->load->model('receptionist/receptionist_model');
        $this->load->model('home/home_model');
        $this->load->model('finance/finance_model');
        $this->load->module('finance');

        // if (!$this->ion_auth->in_group(array('admin', 'Laboratorist'))) {
        //redirect('home/permission');
        // }
        $identity = $this->session->userdata["identity"];
        $this->id_organisation = $this->home_model->get_id_organisation($identity);
        $this->path_logo = $this->home_model->get_logo_organisation($this->id_organisation);
        $this->nom_organisation = $this->home_model->get_nom_organisation($this->id_organisation);
        $this->code_organisation = $this->home_model->get_code_organisation($this->id_organisation);
        $this->entete = $this->home_model->get_entete($this->id_organisation);
        $this->footer = $this->home_model->get_footer($this->id_organisation);
        $this->signature = $this->home_model->get_signature($this->id_organisation);
    }

    public function index()
    {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }

        /* if ($this->ion_auth->in_group(array('Receptionist'))) {
          redirect('lab/lab1');
          } */

        $id = $this->input->get('id');

        $data['settings'] = $this->settings_model->getSettings();
        $data['labs'] = $this->lab_model->getLab();

        if (!empty($id)) {
            $data['lab_single'] = $this->lab_model->getLabById($id);
            $data['patients'] = $this->patient_model->getPatientById($data['lab_single']->patient, $this->id_organisation);
            $data['doctors'] = $this->doctor_model->getDoctorById($data['lab_single']->doctor);
        }
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['templates'] = $this->lab_model->getTemplate();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->lab_model->getLabCategory();

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('lab_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function editLab()
    {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }

        /*  if ($this->ion_auth->in_group(array('Receptionist'))) {
          redir */

        $id = $this->input->get('id');

        $data['settings'] = $this->settings_model->getSettings();
        $data['labs'] = $this->lab_model->getLab();

        if (!empty($id)) {
            $data['lab_single'] = $this->lab_model->getLabById($id);
            $data['patients'] = $this->patient_model->getPatientById($data['lab_single']->patient, $this->id_organisation);
            $data['doctors'] = $this->doctor_model->getDoctorById($data['lab_single']->doctor);
        }
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['templates'] = $this->lab_model->getTemplate();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->lab_model->getLabCategory();
        $data['lab_data'] = $this->lab_model->getLabDataByLab($id);

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('lab', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function lab()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }

        $id = $this->input->get('id');

        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['templates'] = $this->lab_model->getTemplate();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->lab_model->getLabCategory();
        $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
        $data['doctors'] = $this->doctor_model->getDoctor();

        $data['settings'] = $this->settings_model->getSettings();
        $data['labs'] = $this->lab_model->getLab();

        if (!empty($id)) {
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_lab_view', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('lab_view', $data);
            $this->load->view('home/footer'); // just the header file
        }
    }

    public function lab1()
    {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $id = $this->input->get('id');

        $data['settings'] = $this->settings_model->getSettings();
        $data['labs'] = $this->lab_model->getLab();

        if (!empty($id)) {
            $data['lab_single'] = $this->lab_model->getLabById($id);
        }

        $data['templates'] = $this->lab_model->getTemplate();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->lab_model->getLabCategory();
        $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
        $data['doctors'] = $this->doctor_model->getDoctor();

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('lab_1', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addLabView()
    {
        $data = array();

        $id = $this->input->get('id');

        if (!empty($id)) {
            $data['lab'] = $this->lab_model->getLabById($id);
            $data['patients'] = $this->patient_model->getPatientById($data['lab_single']->patient, $this->id_organisation);
            $data['doctors'] = $this->doctor_model->getDoctorById($data['lab_single']->doctor);
        }
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['templates'] = $this->lab_model->getTemplate();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->lab_model->getLabCategory();
        // $data['patients'] = $this->patient_model->getPatient();
        // $data['doctors'] = $this->doctor_model->getDoctor();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_lab_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addLab()
    {
        $id = $this->input->post('id');

        $report = $this->input->post('report');

        $patient = $this->input->post('patient');

        $redirect = $this->input->post('redirect');

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
        $add_date = date('m/d/y');

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
        $date = $this->input->post('date');
        if (!empty($date)) {
            $date = strtotime($date);
        } else {
            $date = time();
        }
        $date_string = date('d/m/Y', $date);
        $discount = $this->input->post('discount');
        $amount_received = $this->input->post('amount_received');
        $user = $this->ion_auth->get_user_id();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Category Field
        // $this->form_validation->set_rules('category_amount[]', 'Category', 'min_length[1]|max_length[100]');
        // Validating Price Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Price Field
        $this->form_validation->set_rules('discount', 'Discount', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            redirect('lab/addLabView');
        } else {
            if (!empty($p_name)) {

                $data_p = array(
                    'patient_id' => $patient_id,
                    'name' => $p_name, 'last_name' => $last_p_name,
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

            if (!empty($patient)) {
                $patient_details = $this->patient_model->getPatientById($patient, $this->id_organisation);
                $patient_name = $patient_details->name;
                $patient_phone = $patient_details->phone;
                $patient_address = $patient_details->address;
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

            $data = array();

            if (empty($id)) {
                $data = array(
                    // 'category_name' => $category_name,
                    'report' => $report,
                    'patient' => $patient,
                    'date' => $date,
                    'doctor' => $doctor,
                    'user' => $user,
                    'patient_name' => $patient_name,
                    'patient_phone' => $patient_phone,
                    'patient_address' => $patient_address,
                    'doctor_name' => $doctor_name,
                    'date_string' => $date_string,
                    'id_organisation' => $this->id_organisation
                );

                $this->lab_model->insertLab($data);
                $inserted_id = $this->db->insert_id();
                $count_rapports = $this->db->get_where('lab', array('id_organisation =' => $this->id_organisation))->num_rows();
                // $codeRapport = 'RA-' . $this->code_organisation . '-' . str_pad($count_rapports, 4, "0", STR_PAD_LEFT);
                $codeRapport = 'RA' . $this->code_organisation . '' . $count_rapports;
                $this->lab_model->updateLab($inserted_id, array("code" => $codeRapport));
                $this->session->set_flashdata('feedback', "Ajouté");
                redirect($redirect);
            } else {
                $data = array(
                    //   'category_name' => $category_name,
                    'report' => $report,
                    'patient' => $patient,
                    'doctor' => $doctor,
                    'user' => $user,
                    'patient_name' => $patient_details->name,
                    'patient_phone' => $patient_details->phone,
                    'patient_address' => $patient_details->address,
                    'doctor_name' => $doctor_details->name,
                );
                $this->lab_model->updateLab($id, $data);
                $this->session->set_flashdata('feedback', "Actualisé");
                redirect($redirect);
            }
        }
    }

    public function addLabNew()
    {
        $id = $this->input->post('id');

        $report = $this->input->post('report');

        $patient = $this->input->post('patient');

        // $prestations[] = $this->input->post('prestations');
        // $resultats[] = $this->input->post('resultats');
        // $unite[] = $this->input->post('unite');
        // $valeurs[] = $this->input->post('valeurs');

        $redirect = $this->input->post('redirect');

        // $p_name = $this->input->post('p_name');  $last_p_name = $this->input->post('last_p_name');
        // $p_email = $this->input->post('p_email');
        // if (empty($p_email)) {
        // $p_email = $p_name . '-' . rand(1, 1000) . '-' . $p_name . '-' . rand(1, 1000) . '@example.com';
        // }
        // if (!empty($p_name)) {
        // $password = $p_name . '-' . rand(1, 100000000);
        // }
        // $p_phone = $this->input->post('p_phone');
        // $p_age = $this->input->post('p_age');
        // $p_gender = $this->input->post('p_gender');
        // $add_date = date('m/d/y');
        // $patient_id = rand(10000, 1000000);
        // $d_name = $this->input->post('d_name');
        // $d_email = $this->input->post('d_email');
        // if (empty($d_email)) {
        // $d_email = $d_name . '-' . rand(1, 1000) . '-' . $d_name . '-' . rand(1, 1000) . '@example.com';
        // }
        // if (!empty($d_name)) {
        // $password = $d_name . '-' . rand(1, 100000000);
        // }
        // $d_phone = $this->input->post('d_phone');

        $doctor = $this->input->post('doctor');
        $date = $this->input->post('date');
        if (!empty($date)) {
            $date = str_replace('/', '-', $date); // Necessaire pour être interprété correctement par strtotime
            $date = strtotime($date);
        } else {
            $date = time();
        }
        $date_string = date('d/m/Y', $date);
        // $discount = $this->input->post('discount');
        // $amount_received = $this->input->post('amount_received');
        $user = $this->ion_auth->get_user_id();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Category Field
        // $this->form_validation->set_rules('category_amount[]', 'Category', 'min_length[1]|max_length[100]');
        // Validating Price Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Price Field
        // $this->form_validation->set_rules('discount', 'Discount', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (empty($id)) { // Creation
                redirect('lab/addLabView'); // Redirection vers creation
            } else {
                redirect('lab/editLab?id=' . $id); // Redirection vers edition
            }
        } else {
            // if(empty($id)) {
            $prefix = "<table border='1' cellpadding='1' cellspacing='1' style='width:100%'>
					<caption>R&Eacute;SULTATS DES ANALYSES</caption>
					<thead>
						<tr>
							<th scope='col'>Analyse(s) Demand&eacute;es</th>
							<th scope='col'>R&eacute;sultats</th>
							<th scope='col'>Unit&eacute;</th>
							<th scope='col'>Valeurs Usuelles</th>
						</tr>
					</thead>
					<tbody>";
            $radical = "";
            $indice = 0;
            $fakeBool = "false";
            $idPaymentConcatRelevantCategoryPartArray = array();
            $labDataArray = array();
            $labDataIdArray = array();
            foreach ($this->input->post() as $key => $value) {
                // $fakeBool .= $key.": ".$value." ";
                if (strpos($key, "resultats_") !== false) {
                    $fakeBool = "true";
                    // $indice ++;
                    // Recuperer derniere partie du name
                    $last_part = explode("_", $key)[1];

                    // Recuperer equivalent resultats, unite, valeurs
                    $idPaymentConcatRelevantCategoryPart = $this->input->post('idPaymentConcatRelevantCategoryPart_' . $last_part);
                    $idPaymentConcatRelevantCategoryPartArray[$idPaymentConcatRelevantCategoryPart] = $idPaymentConcatRelevantCategoryPart;
                    $prestation = $this->input->post('prestations_' . $last_part);
                    $code = $this->input->post('codes_' . $last_part);
                    $resultats = $this->input->post('resultats_' . $last_part);
                    $unite = $this->input->post('unite_' . $last_part);
                    $valeurs = $this->input->post('valeurs_' . $last_part);
                    $radical .= "<tr>
							<td style='font-weight:500;'>" . $prestation . "<br/><span style='font-weight:400;'>(ID Acte: " . $code . ")</td>
							<td>" . $resultats . "</td>
							<td>" . $unite . "</td>
							<td>" . $valeurs . "</td>
						</tr>";

                    // Serialisation Unité et Valeurs pour la prestation dans prestation_lab_default_values
                    $id_prestationBuff0 = explode("@@@@", $idPaymentConcatRelevantCategoryPart);
                    $id_prestationBuff1 = explode("*", $id_prestationBuff0[1]);
                    $id_prestation = $id_prestationBuff1[0];

                    $labDataArray[$idPaymentConcatRelevantCategoryPart] = array(
                        "idPaymentConcatRelevantCategoryPart" => $idPaymentConcatRelevantCategoryPart,
                        "prestation" => $prestation,
                        "id_prestation" => $id_prestation,
                        "code" => $code,
                        "resultats" => $resultats,
                        "unite" => $unite,
                        "valeurs" => $valeurs,
                    );

                    if (!empty($unite) || !empty($valeurs)) { // Seulement si au moins l'un des 2 est renseigné
                        $this->lab_model->insertUpdatePrestationLabDefaultValues(array("id_prestation" => $id_prestation, "default_unite" => $unite, "default_valeurs" => $valeurs));
                    }
                    // End 

                    if (!empty($id)) {
                        $labDataId = $this->input->post('labDataId_' . $last_part);
                        $labDataIdArray[$idPaymentConcatRelevantCategoryPart] = $labDataId;
                    }

                    // $this->form_validation->set_rules($key, 'First Name', 'trim|required|max_length[50]');
                }
            }
            $suffix = "</tbody>
					</table>
					<p>&nbsp;</p>
				";

            $body = $prefix . $radical . $suffix;
            // } 
            // else { // Edition
            // $body = $report;
            // }
            // $this->session->set_flashdata('feedback', "Body: ".$body);
            // redirect('lab/addLabView');
            // if (!empty($p_name)) {
            // $data_p = array(
            // 'patient_id' => $patient_id,
            // 'name' => $p_name,'last_name' => $last_p_name,
            // 'email' => $p_email,
            // 'phone' => $p_phone,
            // 'sex' => $p_gender,
            // 'age' => $p_age,
            // 'add_date' => $add_date,
            // 'how_added' => 'from_pos'
            // );
            // $username = $this->input->post('p_name');
            // Adding New Patient
            // if ($this->ion_auth->email_check($p_email)) {
            // $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
            // } else {
            // $dfg = 5;
            // $this->ion_auth->register($username, $password, $p_email, $dfg);
            // $ion_user_id = $this->db->get_where('users', array('email' => $p_email))->row()->id;
            // $last_patient_user_id = $this->patient_model->insertPatient($data_p);
            // $patient_user_id = $last_patient_user_id;//$this->db->get_where('patient', array('email' => $p_email))->row()->id;
            // $count_patient = $this->db->get_where('patient', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
            // $patient_id = 'P-' . $this->code_organisation . '-' . str_pad($count_patient, 4, "0", STR_PAD_LEFT);
            // $id_info = array('ion_user_id' => $ion_user_id, 'patient_id' => $patient_id);
            // $this->patient_model->updatePatient($patient_user_id, $id_info,$this->id_organisation);
            // }
            //    }
        }

        // if (!empty($d_name)) {
        // $data_d = array(
        // 'name' => $d_name,
        // 'email' => $d_email,
        // 'phone' => $d_phone,
        // );
        // $username = $this->input->post('d_name');
        // Adding New Patient
        // if ($this->ion_auth->email_check($d_email)) {
        // $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
        // } else {
        // $dfgg = 4;
        // $this->ion_auth->register($username, $password, $d_email, $dfgg);
        // $ion_user_id = $this->db->get_where('users', array('email' => $d_email))->row()->id;
        // $this->doctor_model->insertDoctor($data_d);
        // $doctor_user_id = $this->db->get_where('doctor', array('email' => $d_email))->row()->id;
        // $id_info = array('ion_user_id' => $ion_user_id);
        // $this->doctor_model->updateDoctor($doctor_user_id, $id_info);
        // }
        // }
        // if ($patient == 'add_new') {
        // $patient = $patient_user_id;
        // }
        // if ($doctor == 'add_new') {
        // $doctor = $doctor_user_id;
        // }

        if (!empty($patient)) {
            $patient_details = $this->patient_model->getPatientById($patient, $this->id_organisation);
            $patient_name = $patient_details->name;
            $patient_phone = $patient_details->phone;
            $patient_address = $patient_details->address;
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

        $data = array();

        if (empty($id)) {
            $data = array(
                // 'category_name' => $category_name,
                'report' => $body,
                'patient' => $patient,
                'date' => $date,
                'doctor' => $doctor,
                'user' => $user,
                'patient_name' => $patient_name,
                'patient_phone' => $patient_phone,
                'patient_address' => $patient_address,
                'doctor_name' => $doctor_name,
                'date_string' => $date_string,
                'id_organisation' => $this->id_organisation
            );

            $this->lab_model->insertLab($data);
            $inserted_id = $this->db->insert_id();
            $count_rapports = $this->db->get_where('lab', array('id_organisation =' => $this->id_organisation))->num_rows();
            // $codeRapport = 'RA-' . $this->code_organisation . '-' . str_pad($count_rapports, 4, "0", STR_PAD_LEFT);
            $codeRapport = 'RA' . $this->code_organisation . '' . $count_rapports;
            $this->lab_model->updateLab($inserted_id, array("code" => $codeRapport));
            // Update Payment for each prestation
            $individualIdPaymentArray = array();
            // $buffer = "abc";
            foreach ($idPaymentConcatRelevantCategoryPartArray as $individualIdPaymentConcatRelevantCategoryPart) {
                // Status: 2
                // 40@@@@13*22500*1*1*1
                $buff = explode("@@@@", $individualIdPaymentConcatRelevantCategoryPart);
                $individualIdPayment = $buff[0];
                $individualIdPaymentArray[] = $buff[0];
                $individualRelevantCategoryPart = $buff[1];
                // Update Payment 
                // Update CategoryPart
                // where id = individualIdPayment
                // Remove Category Part
                // Update with same but 2 at last
                $paymentCurrentlyInDB = $this->finance_model->getPaymentById($individualIdPayment);
                $categoryNameCurrentlyInDB = $paymentCurrentlyInDB->category_name;
                // Génère : good goy miss moy
                $newIndividualRelevantCategoryPartBuff = explode("*", $individualRelevantCategoryPart);
                // $newIndividualRelevantCategoryPartBuff[4] = "2";
                // $buffer = $labDataArray[$individualIdPaymentConcatRelevantCategoryPart]["resultats"];
                // $buffer = empty($labDataArray[$individualIdPaymentConcatRelevantCategoryPart]["resultats"]) ? "empty" : "not empty";

                $newIndividualRelevantCategoryPartBuff[4] = empty($labDataArray[$individualIdPaymentConcatRelevantCategoryPart]["resultats"]) || empty($labDataArray[$individualIdPaymentConcatRelevantCategoryPart]["unite"]) || empty($labDataArray[$individualIdPaymentConcatRelevantCategoryPart]["valeurs"]) ? "1-1" : "2"; // On update seulement toutes les valeurs sont renseignées (sinon: on met un statut intermediare 1_1) 

                $newIndividualRelevantCategoryPart = implode("*", $newIndividualRelevantCategoryPartBuff);

                // Modif pour labDataArray
                $labDataArray[$individualIdPaymentConcatRelevantCategoryPart]["idPaymentConcatRelevantCategoryPart"] = $individualIdPayment . "@@@@" . $newIndividualRelevantCategoryPart;

                $str = str_replace($individualRelevantCategoryPart, $newIndividualRelevantCategoryPart, $categoryNameCurrentlyInDB, $count);
                // $strpos = strpos($categoryNameCurrentlyInDB, $individualRelevantCategoryPart);
                // $strlength = strlen($individualRelevantCategoryPart);
                // Remplacer

                $this->finance_model->updatePayment($individualIdPayment, array("category_name" => $str));

                // $this->session->set_flashdata('feedback', "ABC individualIdPayment: ".$individualIdPayment." categoryNameCurrentlyInDB ".$categoryNameCurrentlyInDB." str ".$str." newIndividualRelevantCategoryPart ".$newIndividualRelevantCategoryPart);
            }
            // Update Whole Payment if all prestations 2
            foreach ($individualIdPaymentArray as $singleIdPayment) {
                $query = $this->db->query("select count(*) as total from payment where id =" . $singleIdPayment . " and status = 'pending' and (category_name like '%*%*%*%*%1,%' or category_name like '%*%*%*%*%1')"); // Check s'il reste encore des prestations à mettre à jour
                $num = $query->row()->total;
                if (!$num) { // Si plus aucune prestation à mettre à jour
                    $this->finance_model->updatePayment($singleIdPayment, array("status" => "done"));
                }
            }

            $labData = array(
                "id_lab" => $inserted_id,
            );
            foreach ($labDataArray as $singleLabData) {
                // Insertion dans lab_data
                // id, id_lab, idPaymentConcatRelevantCategoryPart, prestation, code, resultats, unite, valeurs  	
                $finalLabData = array_merge($labData, $singleLabData);
                $this->lab_model->insertLabData($finalLabData);
            }

            $this->session->set_flashdata('feedback', "Ajouté");
            redirect($redirect);
        } else { // Mise à jour
            $data = array(
                //   'category_name' => $category_name,
                'report' => $body,
            );
            $this->lab_model->updateLab($id, $data);

            $individualIdPaymentArray = array();
            foreach ($idPaymentConcatRelevantCategoryPartArray as $individualIdPaymentConcatRelevantCategoryPart) {
                // Status: 2
                // 40@@@@13*22500*1*1*1
                $buff = explode("@@@@", $individualIdPaymentConcatRelevantCategoryPart);
                $individualIdPayment = $buff[0];
                $individualIdPaymentArray[] = $buff[0];
                $individualRelevantCategoryPart = $buff[1];
                // Update Payment 
                // Update CategoryPart
                // where id = individualIdPayment
                // Remove Category Part
                // Update with same but 2 at last
                $paymentCurrentlyInDB = $this->finance_model->getPaymentById($individualIdPayment);
                $categoryNameCurrentlyInDB = $paymentCurrentlyInDB->category_name;
                // Génère : good goy miss moy
                $newIndividualRelevantCategoryPartBuff = explode("*", $individualRelevantCategoryPart);
                // $newIndividualRelevantCategoryPartBuff[4] = "2";
                // $buffer = $labDataArray[$individualIdPaymentConcatRelevantCategoryPart]["resultats"];
                // $buffer = empty($labDataArray[$individualIdPaymentConcatRelevantCategoryPart]["resultats"]) ? "empty" : "not empty";

                $newIndividualRelevantCategoryPartBuff[4] = empty($labDataArray[$individualIdPaymentConcatRelevantCategoryPart]["resultats"]) || empty($labDataArray[$individualIdPaymentConcatRelevantCategoryPart]["unite"]) || empty($labDataArray[$individualIdPaymentConcatRelevantCategoryPart]["valeurs"]) ? "1-1" : "2"; // On update seulement toutes les valeurs sont renseignées (sinon: on met un statut intermediare 1_1)
                $newIndividualRelevantCategoryPart = implode("*", $newIndividualRelevantCategoryPartBuff);

                // Modif pour labDataArray
                $labDataArray[$individualIdPaymentConcatRelevantCategoryPart]["idPaymentConcatRelevantCategoryPart"] = $individualIdPayment . "@@@@" . $newIndividualRelevantCategoryPart;
                $labDataIdArray[$individualIdPayment . "@@@@" . $newIndividualRelevantCategoryPart] = $labDataIdArray[$individualIdPaymentConcatRelevantCategoryPart]; // On cree un nouvelle entrée dans labDataIdArray avec la bonne clé et l'ancienne valeur

                $str = str_replace($individualRelevantCategoryPart, $newIndividualRelevantCategoryPart, $categoryNameCurrentlyInDB, $count);
                // $strpos = strpos($categoryNameCurrentlyInDB, $individualRelevantCategoryPart);
                // $strlength = strlen($individualRelevantCategoryPart);
                // Remplacer

                $this->finance_model->updatePayment($individualIdPayment, array("category_name" => $str));

                // $this->session->set_flashdata('feedback', "ABC individualIdPayment: ".$individualIdPayment." categoryNameCurrentlyInDB ".$categoryNameCurrentlyInDB." str ".$str." newIndividualRelevantCategoryPart ".$newIndividualRelevantCategoryPart);
            }
            // Update Whole Payment if all prestations 2
            foreach ($individualIdPaymentArray as $singleIdPayment) {
                $query = $this->db->query("select count(*) as total from payment where id =" . $singleIdPayment . " and status = 'pending' and (category_name like '%*%*%*%*%1,%' or category_name like '%*%*%*%*%1')"); // Check s'il reste encore des prestations à mettre à jour
                $num = $query->row()->total;
                if (!$num) { // Si plus aucune prestation à mettre à jour
                    $this->finance_model->updatePayment($singleIdPayment, array("status" => "done"));
                }
            }

            $labData = array(
                "id_lab" => $id,
            );
            // $key = "abc";
            foreach ($labDataArray as $singleLabData) {
                // Insertion dans lab_data
                // id, id_lab, idPaymentConcatRelevantCategoryPart, prestation, code, resultats, unite, valeurs  	
                $finalLabData = array_merge($labData, $singleLabData);
                // $key = array_key_first($labDataArray);
                $key = $singleLabData["idPaymentConcatRelevantCategoryPart"];
                $this->lab_model->updateLabData($labDataIdArray[$key], $finalLabData);
            }

            $this->session->set_flashdata('feedback', "Actualisé");
            redirect($redirect);
        }
    }

    // function editLab() {
    // if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Laboratorist', 'Nurse', 'Patient'))) {
    // $data = array();
    // $data['settings'] = $this->settings_model->getSettings();
    // $data['categories'] = $this->lab_model->getLabCategory();
    // $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
    // $data['doctors'] = $this->doctor_model->getDoctor();
    // $id = $this->input->get('id');
    // $data['lab'] = $this->lab_model->getLabById($id);
    // $this->load->view('home/dashboard'); // just the header file
    // $this->load->view('add_lab_view', $data);
    // $this->load->view('home/footer'); // just the footer file
    // }
    // }

    function delete()
    {
        if ($this->ion_auth->in_group(array('admin', 'Laboratorist'))) {
            $id = $this->input->get('id');
            $this->lab_model->deleteLab($id);
            $this->session->set_flashdata('feedback', lang('deleted'));
            redirect('lab/lab');
        } else {
            redirect('home/permission');
        }
    }

    public function addTemplateView()
    {
        $data = array();
        $id = $this->input->get('id');
        if (!empty($id)) {
            $data['template'] = $this->lab_model->getTemplateById($id);
        }
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/superdashboard', $data); // just the header file
        $this->load->view('add_template', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function getTemplateByIdByJason()
    {
        $id = $this->input->get('id');
        $data['template'] = $this->lab_model->getTemplateById($id);
        echo json_encode($data);
    }

    function getUniqueTemplate()
    {
        $requestData = $_REQUEST;
        $id_acte = $requestData["idActe"];
        $payment = $this->finance_model->getPaymentById($id_acte);

        $template = $this->getUniqueTemplatePrefix();

        if (!empty($payment->category_name)) {
            $category_name = $payment->category_name;
            $category_name1 = explode(',', $category_name);
            foreach ($category_name1 as $category_name2) {
                $category_name3 = explode('*', $category_name2);
                if ($category_name3[3] > 0) {
                    $prestation = $this->finance_model->getPaymentcategoryById($category_name3[0])->prestation;
                    $template .= $this->getUniqueTemplateRow($prestation);
                }
            }
        }

        $template .= $this->getUniqueTemplateSuffix();
        $data['template'] = $template;
        echo json_encode($data);
    }

    function getUniqueTemplatePrefix()
    {
        // $id = $this->input->get('id');
        $prefix = "<table border='1' cellpadding='1' cellspacing='1' style='width:100%'>
				<caption>R&Eacute;SULTATS DES ANALYSES</caption>
				<thead>
					<tr>
						<th scope='col'>Analyse(s) Demand&eacute;es</th>
						<th scope='col'>R&eacute;sultats</th>
						<th scope='col'>Unit&eacute;</th>
						<th scope='col'>Valeurs Usuelles</th>
					</tr>
				</thead>
				<tbody>";
        return $prefix;
    }

    function getUniqueTemplateRow($prestation)
    {
        // $id = $this->input->get('id');
        $row = "<tr>
						<td>" . $prestation . "</td>
						<td>...</td>
						<td>...</td>
						<td>...</td>
					</tr>";
        return $row;
    }

    function getUniqueTemplateSuffix()
    {
        // $id = $this->input->get('id');
        $suffix = "</tbody>
			</table>
			<p>&nbsp;</p>
		";
        return $suffix;
    }

    public function addTemplate()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $template = $this->input->post('template');
        $type = $this->input->post('type');
        $user = $this->ion_auth->get_user_id();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('report', 'Report', 'trim|min_length[1]|max_length[10000]|xss_clean');
        // Validating Price Field
        $this->form_validation->set_rules('user', 'User', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            redirect('lab/addTemplate');
        } else {
            $data = array();
            if (empty($id)) {
                $data = array(
                    'name' => $name,
                    'template' => $template,
                    'user' => $user,
                    'type' => $type,
                );
                $this->lab_model->insertTemplate($data);
                $inserted_id = $this->db->insert_id();
                $this->session->set_flashdata('feedback', lang('added'));
                if (!empty($type)) {
                    redirect("lab/template");
                } else {
                    redirect("lab/templateConsultation");
                }

                // redirect("lab/addTemplateView?id=" . "$inserted_id");
            } else {
                $data = array(
                    'name' => $name,
                    'template' => $template,
                    'user' => $user,
                    'type' => $type,
                );
                $this->lab_model->updateTemplate($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
                if (!empty($type)) {
                    redirect("lab/template");
                } else {
                    redirect("lab/templateConsultation");
                }
                // redirect("lab/addTemplateView?id=" . "$id");
            }
        }
    }

    function editTemplate()
    {
        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        $id = $this->input->get('id');
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['template'] = $this->lab_model->getTemplateById($id);
        $this->load->view('home/superdashboard', $data); // just the header file
        $this->load->view('add_template', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function deleteTemplate()
    {
        $id = $this->input->get('id');
        $this->lab_model->deleteTemplate($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('lab/template');
    }

    public function labCategory()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['categories'] = $this->lab_model->getLabCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('lab_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addLabCategoryView()
    {
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_lab_category');
        $this->load->view('home/footer'); // just the header file
    }

    public function addLabCategory()
    {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $description = $this->input->post('description');
        $reference = $this->input->post('reference_value');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Name Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('reference_value', 'Reference Value', 'trim|required|min_length[1]|max_length[1000]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('type', 'Type', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $this->session->set_flashdata('feedback', lang('vaidation_error'));
                redirect('lab/editLabCategory?id=' . $id);
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_lab_category', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $data = array();
            $data = array(
                'category' => $category,
                'description' => $description,
                'reference_value' => $reference,
            );
            if (empty($id)) {
                $this->lab_model->insertLabCategory($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->lab_model->updateLabCategory($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('lab/labCategory');
        }
    }

    function editLabCategory()
    {
        $data = array();
        $id = $this->input->get('id');
        $data['category'] = $this->lab_model->getLabCategoryById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_lab_category', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function deleteLabCategory()
    {
        $id = $this->input->get('id');
        $this->lab_model->deleteLabCategory($id);
        redirect('lab/labCategory');
    }

    function invoice()
    {
        $data = array();
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['lab'] = $this->lab_model->getLabById($id);

        $data['organisation'] = $this->home_model->getOrganisationById($this->id_organisation);

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('invoice', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function patientLabHistory()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $patient = $this->input->get('patient');
        if (empty($patient)) {
            $patient = $this->input->post('patient');
        }

        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 86399;
        }

        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;

        if (!empty($date_from)) {
            $data['labs'] = $this->lab_model->getLabByPatientIdByDate($patient, $date_from, $date_to);
            $data['deposits'] = $this->lab_model->getDepositByPatientIdByDate($patient, $date_from, $date_to);
        } else {
            $data['labs'] = $this->lab_model->getLabByPatientId($patient);
            $data['pharmacy_labs'] = $this->pharmacy_model->getLabByPatientId($patient);
            $data['ot_labs'] = $this->lab_model->getOtLabByPatientId($patient);
            $data['deposits'] = $this->lab_model->getDepositByPatientId($patient);
        }



        $data['patient'] = $this->patient_model->getPatientByid($patient, $this->id_organisation);
        $data['settings'] = $this->settings_model->getSettings();

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('patient_deposit', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function financialReport()
    {
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 86399;
        }
        $data = array();
        $data['lab_categories'] = $this->lab_model->getLabCategory();
        $data['expense_categories'] = $this->lab_model->getExpenseCategory();

        // if(empty($date_from)&&empty($date_to)) {
        //    $data['labs']=$this->lab_model->get_lab();
        //     $data['ot_labs']=$this->lab_model->get_ot_lab();
        //     $data['expenses']=$this->lab_model->get_expense();
        // }
        // else{

        $data['labs'] = $this->lab_model->getLabByDate($date_from, $date_to);
        $data['ot_labs'] = $this->lab_model->getOtLabByDate($date_from, $date_to);
        $data['deposits'] = $this->lab_model->getDepositsByDate($date_from, $date_to);
        $data['expenses'] = $this->lab_model->getExpenseByDate($date_from, $date_to);
        // } 
        $data['from'] = $this->input->post('date_from');
        $data['to'] = $this->input->post('date_to');
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('financial_report', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function getLab()
    {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        $orderColumn = intval($this->input->post('order')[0][column]);
        $orderDirection = $this->input->post('order')[0][dir];

        $orderColumnMapping = array(0 => "lab.code", 1 => "lab.date", 2 => "patient_name", 3 => "numero_demande", 4 => "id_organisation_source_demande");
        $orderColumn = $orderColumnMapping[$orderColumn];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['labs'] = $this->lab_model->getLabByOrganisationBySearch($this->id_organisation, $search, $orderColumn, $orderDirection);
            } else {
                $data['labs'] = $this->lab_model->getLabByOrganisation($this->id_organisation, $orderColumn, $orderDirection);
            }
        } else {
            if (!empty($search)) {
                $data['labs'] = $this->lab_model->getLabByOrganisationByLimitBySearch($this->id_organisation, $limit, $start, $search, $orderColumn, $orderDirection);
                $data['labsNoLimit'] = $this->lab_model->getLabByOrganisationBySearch($this->id_organisation, $search, $orderColumn, $orderDirection);
            } else {
                $data['labs'] = $this->lab_model->getLabByOrganisationByLimit($this->id_organisation, $limit, $start, $orderColumn, $orderDirection);
                $data['labsNoLimit'] = $this->lab_model->getLabByOrganisation($this->id_organisation, $orderColumn, $orderDirection);
            }
        }
        //  $data['labs'] = $this->lab_model->getLab();

        foreach ($data['labs'] as $lab) {
            // $date = date('d-m-y', $lab->date);
            $date = $lab->date != "" ? date('d/m/Y', $lab->date) : "";
            // $date = $lab->date." ".date('d/m/Y', $lab->date)." ";
            if ($this->ion_auth->in_group(array('admin', 'Laboratorist', 'Doctor', 'adminmedecin'))) {
                $options1 = ' <a class="btn btn-info btn-xs editbutton" title="' . lang('edit') . '" href="lab/editLab?id=' . $lab->id . '"><i class="fa fa-edit"> </i> ' . lang('') . '</a>';
            } else {
                $options1 = '';
            }

            $options2 = '<a class="btn btn-xs invoicebutton" title="' . lang('lab') . '" style="color: #fff;" href="lab/invoice?id=' . $lab->id . '"><i class="fa fa-file"></i> ' . lang('') . '</a>';

            if ($this->ion_auth->in_group(array('admin', 'Doctor', 'Laboratorist', 'adminmedecin'))) {
                $options3 = '<a class="btn btn-info btn-xs delete_button" title="' . lang('delete') . '" href="lab/delete?id=' . $lab->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i>' . lang('') . '</a>';
            } else {
                $options3 = '';
            }

            $doctor_info = $this->doctor_model->getDoctorById($lab->doctor);
            if (!empty($doctor_info)) {
                $doctor = $doctor_info->name;
            } else {
                if (!empty($lab->doctor_name)) {
                    $doctor = $lab->doctor_name;
                } else {
                    $doctor = ' ';
                }
            }

            $demandeur = "";
            if (!empty($lab->id_organisation_source_demande)) { // Non utilisée pour l'instant
                $organisation = $this->home_model->getOrganisationById($lab->id_organisation_source_demande);
                $demandeur = $organisation->nom;
            }

            $patient_info = $this->patient_model->getPatientById($lab->patient, $this->id_organisation);
            if (!empty($patient_info)) {
                $patient_details = $patient_info->name . ' ' . $patient_info->last_name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
            } else {
                $patient_details = ' ';
            }

            $analyses = $this->db->query("select * from lab_data where id_lab = " . $lab->id)->result();
            $liste_analyses = "";
            $indice = 0;
            foreach ($analyses as $analyse) {
                if ($indice > 0) {
                    $liste_analyses .= "<hr style='height:1px;margin-top:2px !important;margin-bottom:2px !important;border-width:0;color:gray;background-color:gray'/>";
                }

                $id_prestationBuff0 = explode("@@@@", $analyse->idPaymentConcatRelevantCategoryPart);
                $id_prestationBuff1 = explode("*", $id_prestationBuff0[1]);
                $id_prestation = $id_prestationBuff1[0];

                // Récupérer statut Reel
                $id_payment = $id_prestationBuff0[0];
                $this->db->where("id", $id_payment);
                $query = $this->db->get("payment");
                $payment = $query->row();
                $category_name = $payment->category_name;
                // echo "<br/>".$id_prestationBuff0[1]."<br/>".$category_name;
                $exploded_category_name1 = explode(",", $category_name);
                $is_valid = false;
                foreach ($exploded_category_name1 as $exploded1) {
                    $exploded2 = explode("*", $exploded1);
                    $is_valid = $exploded2[0] == $id_prestationBuff1[0] && $exploded2[1] == $id_prestationBuff1[1] && $exploded2[2] == $id_prestationBuff1[2] && $exploded2[3] == $id_prestationBuff1[3] && $exploded2[4] == 3;
                    if ($is_valid) {
                        break;
                    }
                }
                // echo "<br/>".$is_valid;

                $statut = (empty($analyse->resultats) || empty($analyse->unite) || empty($analyse->valeurs)) ? "<span style='text-transform:none;font-weight:300;color:red;'><a style='color:red;text-transform:capitalize;' href='lab/editLab?id=" . $analyse->id_lab . "'>à finaliser <i class='fa fa-edit' style='font-size:10px;'></i></a></span>" : (!$is_valid ? "<span style='text-transform:none;font-weight:300;color:green;'>Effectué</span>" : "<span style='text-transform:none;font-weight:300;color:green;'>Validé</span>");
                $liste_analyses .= "<h6 style='text-transform:uppercase;font-weight:bold;'>" . $analyse->prestation . "<br/><span style='font-size:10px;text-transform:none;'>(" . $analyse->code . ")</span><br/>" . $statut . "</h6>";
                $indice++;
            }
            $info[] = array(
                $lab->code,
                $date,
                $patient_details,
                $liste_analyses,
                $lab->numero_demande,
                $demandeur,
                $options1 . ' ' . $options2,
                // $options2 . ' ' . $options3
            );
        }



        // $this->session->set_flashdata('feedback', "ABC: ".$this->id_organisation);
        // $this->session->set_flashdata('feedback', "ABC: ".$orderColumn."".$orderDirection);
        // $this->session->set_flashdata('feedback', "ABC: start: ".$start." limit: ".$limit);

        if (!empty($data['labs'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get_where('lab', array('id_organisation' => $this->id_organisation))->num_rows(),
                // "recordsFiltered" => count($data['labs']),
                "recordsFiltered" => count($data['labsNoLimit']),
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

    function getDefaultPrestationLabValuesJson()
    {
        $requestData = $_REQUEST;
        $id_prestation = $requestData['idPrestation'];

        // $data = array("test"=>"Here we are");
        $data = $this->lab_model->getPrestationLabDefaultValues($id_prestation);

        echo json_encode($data);
    }

    public function myLab()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $data['templates'] = $this->lab_model->getTemplate();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->lab_model->getLabCategory();
        $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
        $data['doctors'] = $this->doctor_model->getDoctor();

        $data['settings'] = $this->settings_model->getSettings();

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('my_lab', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function getPatientinfoWithAddNewOption()
    {
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->lab_model->getPatientinfoWithAddNewOption($searchTerm);
        echo json_encode($response);
    }

    function getMyLab()
    {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['labs'] = $this->lab_model->getLabBysearch($search);
            } else {
                $data['labs'] = $this->lab_model->getLab();
            }
        } else {
            if (!empty($search)) {
                $data['labs'] = $this->lab_model->getLabByLimitBySearch($limit, $start, $search);
            } else {
                $data['labs'] = $this->lab_model->getLabByLimit($limit, $start);
            }
        }

        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_user_id = $this->ion_auth->get_user_id();
            $patient_id = $this->patient_model->getPatientByIonUserId($patient_user_id, $this->id_organisation)->id;
        }

        foreach ($data['labs'] as $lab) {
            if ($patient_id == $lab->patient) {
                $date = date('d-m-y', $lab->date);

                $options2 = '<a class="btn btn-xs invoicebutton" title="' . lang('lab') . '" style="color: #fff;" href="lab/invoice?id=' . $lab->id . '"><i class="fa fa-file"></i> ' . lang('') . '</a>';

                $doctor_info = $this->doctor_model->getDoctorById($lab->doctor);
                if (!empty($doctor_info)) {
                    $doctor = $doctor_info->name;
                } else {
                    if (!empty($lab->doctor_name)) {
                        $doctor = $lab->doctor_name;
                    } else {
                        $doctor = ' ';
                    }
                }


                $patient_info = $this->patient_model->getPatientById($lab->patient, $this->id_organisation);
                if (!empty($patient_info)) {
                    $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                } else {
                    $patient_details = ' ';
                }
                $info[] = array(
                    $lab->id,
                    $patient_details,
                    $date,
                    $options2,
                    // $options2 . ' ' . $options3
                );
            }
        }


        if (!empty($data['labs'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('lab')->num_rows(),
                "recordsFiltered" => $this->db->get('lab')->num_rows(),
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

    public function addLabNewPayment()
    {
        $id = $this->input->post('id');
        $idlab = $this->input->post('idlab');
        $report = $this->input->post('report');
        $category = $this->input->post('category');
        $patient = $this->input->post('patient_id');
        $doctor_id = $this->input->post('doctor_id');
        $doctor = $this->input->post('doctor');
        $prestations = $this->input->post('prestations');
        $idPrestation = $this->input->post('idPrestation');
        $resultats = $this->input->post('resultats');
        $param = $this->input->post('idParam');
        $nom_param = $this->input->post('nomParam');
        $codes = $this->input->post('codes');
        $values = $this->input->post('values');
        $redirect = $this->input->post('redirect');
        $payment = $this->input->post('payment_id');
        $numeroRegistre = $this->input->post('numeroRegistre');
        $code_identifiant = $this->input->post('code_identifiant');
        $renseignementClinique = $this->input->post('renseignementClinique');
        $date_prelevement = $this->input->post('date_prelevement');
        $patientID = $this->input->post('patientIDReport');
        $patientNameReport = $this->input->post('patientNameReport');
        $name = $this->input->post('name');
        $last_name = $this->input->post('last_name');
        $status = $this->input->post('status');
        $birthdate = $this->input->post('birthdate');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $sex = $this->input->post('sex');
        $age = $this->input->post('age');
        $passport = $this->input->post('passport');
        $id_presta = $this->input->post('id_presta');

        $dataPatient = array(
            'name' => $name, 
            'last_name' => $last_name,
            'id_organisation' => $this->id_organisation,
            'email' => $email,
            'address' => $address,
            'phone' => $phone,
            'sex' => $sex,
            'age' => $age,
            'birthdate' => $birthdate,
            'passport' => $passport,
            'phone' => $phone,
            'doctor_name' => $doctor,
            'date_prelevement' => $date_prelevement,
        );

    

        /*         * ***** Integration Category prelevement */
        $c_category = $this->input->post('c_category');
        $c_description = $this->input->post('c_description');
        $category_id = rand(10000, 1000000);
        if ($category == 'add_new') {
            $this->form_validation->set_rules('c_category', 'Category Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            $this->form_validation->set_rules('c_description', 'Category Description', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        }
        /*         * ***** FIN Integration Category prelevement */



        /*             * * VALIDATION CATEGORY */

        if ($category == 'add_new') {
            $data = array();
            $data = array(
                'category' => $c_category, 'status' => 1,
                'description' => $c_description, 'id_organisation' => $this->id_organisation
            );
            if (empty($id)) {
                $this->finance_model->insertTypePrelevement($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->finance_model->updateTypePrelevement($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }

            $category = $c_category;
            //    }
        }
        /** FIN VALIDATION CATEGORY */

        $idPayment = $this->input->post('payment_id');
        $date = $this->input->post('date');
        
        if (!empty($date)) {
            $date = str_replace('/', '-', $date); // Necessaire pour être interprété correctement par strtotime
            $date = strtotime($date);
        } else {
            $date = time();
        }
        $date_string = date('d/m/Y', $date);
        // $discount = $this->input->post('discount');
        // $amount_received = $this->input->post('amount_received');
        $user = $this->ion_auth->get_user_id();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');




        $data = array();
        $dataClinique = array();
        $body = '';
        $data = array(
            // 'category_name' => $category_name,
            'report' => $body,
            'patient' => $patient,
            'date' => $date,
            'doctor' => $doctor_id,
            'payment' => $idPayment,
            'user' => $user,
            'doctor_name' => $doctor,
            'date_string' => $date_string,
            'id_organisation' => $this->id_organisation,
            'numeroRegistre' => $numeroRegistre,
            'date_prelevement' => $date_prelevement,
            'numero_identifiant' => $code_identifiant,
            'id_presta' => $id_presta,

        );



        $dataPayment = array(
            'doctor_name' => $doctor,
            'user' => $user,
            'date_prelevement' => $date_prelevement,

        );

        $this->finance_model->updatePayment($payment, $dataPayment);
        
        if (empty($id)) {
            $this->finance_model->updateRenseignementClinique($idPayment, array('renseignementClinique' => $renseignementClinique));


            $inserted_id = $idlab;
            if (empty($idlab)) {
                
                $this->lab_model->insertLab($data);
                $inserted_id = $this->db->insert_id();
                $count_rapports = $this->db->get_where('lab', array('id_organisation =' => $this->id_organisation))->num_rows();
                // $codeRapport = 'RA-' . $this->code_organisation . '-' . str_pad($count_rapports, 4, "0", STR_PAD_LEFT);
                $codeRapport = 'RA' . $this->code_organisation . '' . $count_rapports;
                $this->lab_model->updateLab($inserted_id, array("code" => $codeRapport));
            }
            // Update Payment for each prestation
            $individualIdPaymentArray = array();






            foreach ($param as $key => $singleLabData) {
                $status = 1;
                if ($resultats[$key]) {
                    $status = 2;
                }
                $labData = array(
                    "id_lab" => $inserted_id,
                    "idPaymentConcatRelevantCategoryPart" => $values[$key],
                    "id_para" => $param[$key],
                    "id_prestation" => $id_presta,
                    "id_payment" => $codes[$key],
                    "resultats" => $resultats[$key],
                    "status" => $status,
                );
                // Insertion dans lab_data
                // id, id_lab, idPaymentConcatRelevantCategoryPart, prestation, code, resultats, unite, valeurs  	
                // var_dump($labData);
                // exit();
                $this->lab_model->insertLabData($labData);
                $idLab = $inserted_id;
                $payment = $codes[$key];
                // $idPrestation = $idPrestation[$key];
            }


           
            $dataPatient = array(
                'name' => $name, 
                'last_name' => $last_name,
                'status' => 1, 
                'id_organisation' => $this->id_organisation,
                'email' => $email,
                'address' => $address,
                'phone' => $phone,
                'sex' => $sex,
                'age' => $age,
                'birthdate' => $birthdate,
                'passport' => $passport,
                'phone' => $phone,
            );
    
           
    
            $this->patient_model->updatePatient($patient, $dataPatient, $this->id_organisation);
    

            $this->session->set_flashdata('feedback', "Ajouté");
            // redirect($redirect);
        } else { // Mise à jour
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
              
                $this->lab_model->updateLab($idlab, $data);
            }







            //  exit();
            $this->session->set_flashdata('feedback', "Actualisé");
        }
        $this->lab_model->updateLab($inserted_id, array("payment" => $payment));
        $sql = "select count(*) as total from lab_data where id_lab =" . $idLab . " and id_payment =" . $payment . " and status = '1';";

        // var_dump($payment.'----'.$prestations); 
        $query = $this->db->query($sql);
        $num = intval($query->row()->total);     //  var_dump($num); exit();       //   
        if (empty($num)) { // Si plus aucune prestation à mettre à jour
            //var_dump($payment.'----'.$prestations);  exit();
            $this->finance->changeStatusPrestationByFinance($payment, 2, $id_presta);
        }
        redirect($redirect);
    }

    function editLabByJason()
    {
        $id = $this->input->get('id');
        $data['patients'] = $this->patient_model->getPatientById($id);
        $data = $this->lab_model->getLabById($id)->report;
        echo json_encode($data);
    }

    function editLabByJasonAnalyse()
    {
        $id = $this->input->get('id');
        $data['patients'] = $this->patient_model->getPatientById($id);
        $data = $this->lab_model->getLabById($id)->report;
        echo json_encode($data);
    }

    function editLabByJasonPro()
    {
        $id = $this->input->get('id');
        $data = $this->lab_model->getLabById($id)->report_pro;
        echo json_encode($data);
    }

    function editLabByJasonPayment()
    {
        $id = $this->input->get('payment');
        $tab = $this->lab_model->getLabByPayment($id);
        $data = $tab->report;
        if ($tab->id_organisation == $this->id_organisation) {
            $data = $tab->report_pro;
        }
        //$data = $tab->report;
        echo json_encode($data);
    }


    function masterLabList()
    {
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);

        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/superdashboard', $data); // just the header file
        $this->load->view('master_lab', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function addLabTestMasterView()
    {
        $data['request'] = $this->input->get('request');
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);

        $data['settings'] = $this->settings_model->getSettings();

        $data['settings'] = $this->settings_model->getSettings();
        if ($this->ion_auth->in_group(array('admin', 'Laboratorist', 'Biologiste','adminmedecin'))) {
            $this->load->view('home/dashboard', $data); // just the header file
        } else {
            $this->load->view('home/superdashboard', $data); // just the header file
        }
        $this->load->view('add_master_lab_test_view', $data);
        $this->load->view('home/footer'); // just the header file
    }


    function addMasterLabTest()
    {
        $id = $this->input->post('id');
        $request = $this->input->post('request');
        $speciality = $this->input->post('speciality');
        $name = $this->input->post('name');
        $description = $this->input->post('description');
        $status = $this->input->post('status');

        $data = array(
            'speciality' => $speciality,
            'name' => $name,
            'description' => $description,
            'status' => $status,
        );
        if (empty($id)) {
            $test1 = $this->lab_model->insertMasterLabTest($data);
            $inserted_id = $this->db->insert_id();
        } else {
            $test1 = $this->lab_model->updateMasterLabTest($id, $data);
            $inserted_id = $id;
            $parameters = $this->lab_model->getParameterByLabTest($id);
            foreach ($parameters as $par) {
                $this->lab_model->deleteParameter($par->id);
            }
        }

        $total_table_row = $this->input->post('total_table_row');

        $parameter_name = $this->input->post('parameter_name');

        $parameter_description = $this->input->post('parameter_description');
        for ($i = 0; $i <= $total_table_row; $i++) {

            $para_meter = $parameter_name[$i];

            if (!empty($para_meter)) {
                $para[$i] = $parameter_name[$i];
                $unit_of_measure = array();
                $references_type = array();
                $high = array();
                $low = array();
                $positive_negative = array();
                $para_des = $parameter_description[$i];

                $unit_of_measure = $this->input->post('unit_of_measure-' . ($i + 1));

                $references_type = $this->input->post('references_' . ($i + 1));

                $num_of_resource = $this->input->post('num_of_resource_' . ($i + 1));
                $ref_new = array();
                $k1 = 0;
                for ($k = 0; $k < count($references_type); $k++) {

                    if ($references_type[$k] == 'on') {
                        continue;
                    } elseif ($references_type[$k + 1] == 'on' && $references_type[$k] == 'off_switch') {
                        $ref_new[$k1] = 'on';
                        $k1++;
                    } elseif ($references_type[$k] = 'off_switch' && $references_type[$k + 1] != 'on') {
                        $ref_new[$k1] = 'off_switch';
                        $k1++;
                    }
                }

                $high = $this->input->post('high-' . ($i + 1));

                $low = $this->input->post('low-' . ($i + 1));
                $positive_negative = $this->input->post('positive_negative-' . ($i + 1));
                for ($j = 0; $j < count($ref_new); $j++) {
                    $data_update = array();
                    $data_update = array(
                        'high' => $high[$j],
                        'low' => $low[$j],
                        'reference_type' => $ref_new[$j],
                        'positive_negative' => $positive_negative[$j],
                        'parameter_name' => $para_meter,
                        'parameter_description' => $para_des,
                        'unit_of_measure' => $unit_of_measure[$j],
                        'test_id' => $inserted_id
                    );

                    $test[] = $this->lab_model->addParameter($data_update);
                }
            } else {
                continue;
            }
        }
        if (!empty($test)) {
            $data_up = array('parameter' => implode("**", $para));
            $this->lab_model->updateMasterLabTest($inserted_id, $data_up);
            if (empty($id)) {
                $this->session->set_flashdata('feedback', "Ajouté");
            } else {
                $this->session->set_flashdata('feedback', "mis à jour");
            }
            redirect('lab/masterLabList');
        } else {
            redirect('lab/masterLabList');
        }
    }

    function addRequestMasterLabTest()
    {
        $id = $this->input->post('id');

        $speciality = $this->input->post('speciality');
        $name = $this->input->post('name');
        $description = $this->input->post('description');
        $status = $this->input->post('status');

        $data = array(
            'speciality' => $speciality,
            'name' => $name,
            'description' => $description,
            'status' => $status,
            'accept' => 'pending',
            'id_organisation' => $this->id_organisation
        );
        if (empty($id)) {
            $test1 = $this->lab_model->insertRequestMasterLabTest($data);
            $inserted_id = $this->db->insert_id();
        } else {
            $test1 = $this->lab_model->updateMasterLabTest($id, $data);
            $inserted_id = $id;
            $parameters = $this->lab_model->getParameterByLabTest($id);
            foreach ($parameters as $par) {
                $this->lab_model->deleteParameter($par->id);
            }
        }

        $total_table_row = $this->input->post('total_table_row');

        $parameter_name = $this->input->post('parameter_name');

        $parameter_description = $this->input->post('parameter_description');
        for ($i = 0; $i <= $total_table_row; $i++) {

            $para_meter = $parameter_name[$i];

            if (!empty($para_meter)) {
                $para[$i] = $parameter_name[$i];
                $unit_of_measure = array();
                $references_type = array();
                $high = array();
                $low = array();
                $positive_negative = array();
                $para_des = $parameter_description[$i];

                $unit_of_measure = $this->input->post('unit_of_measure-' . ($i + 1));

                $references_type = $this->input->post('references_' . ($i + 1));

                $num_of_resource = $this->input->post('num_of_resource_' . ($i + 1));
                $ref_new = array();
                $k1 = 0;
                for ($k = 0; $k < count($references_type); $k++) {

                    if ($references_type[$k] == 'on') {
                        continue;
                    } elseif ($references_type[$k + 1] == 'on' && $references_type[$k] == 'off_switch') {
                        $ref_new[$k1] = 'on';
                        $k1++;
                    } elseif ($references_type[$k] = 'off_switch' && $references_type[$k + 1] != 'on') {
                        $ref_new[$k1] = 'off_switch';
                        $k1++;
                    }
                }

                $high = $this->input->post('high-' . ($i + 1));

                $low = $this->input->post('low-' . ($i + 1));
                $positive_negative = $this->input->post('positive_negative-' . ($i + 1));
                for ($j = 0; $j < count($ref_new); $j++) {
                    $data_update = array();
                    $data_update = array(
                        'high' => $high[$j],
                        'low' => $low[$j],
                        'reference_type' => $ref_new[$j],
                        'positive_negative' => $positive_negative[$j],
                        'parameter_name' => $para_meter,
                        'parameter_description' => $para_des,
                        'unit_of_measure' => $unit_of_measure[$j],
                        'request_test_id' => $inserted_id
                    );

                    $test[] = $this->lab_model->addParameter($data_update);
                }
            } else {
                continue;
            }
        }
        if (!empty($test)) {
            $data_up = array('parameter' => implode("**", $para));
            $this->lab_model->updateRequestedLabTest($inserted_id, $data_up);
            if (empty($id)) {
                $this->session->set_flashdata('feedback', "demandé");
            } else {
                $this->session->set_flashdata('feedback', "mis à jour");
            }
            redirect('lab/allActiveLabTest');
        } else {
            redirect('lab/allActiveLabTest');
        }
    }


    function requestLabTestList()
    {
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
        if (isset($data['pin_partenaire_zuuluPay_encrypted'])) {
            $data['pin_partenaire_zuuluPay_encrypted'] = $data['pin_partenaire_zuuluPay_encrypted'];
        } else {
            $data['pin_partenaire_zuuluPay_encrypted'] = '';
        }

        $data['settings'] = $this->settings_model->getSettings();
        if ($this->ion_auth->in_group(array('admin', 'Laboratorist', 'Biologiste','adminmedecin'))) {
            $this->load->view('home/dashboard', $data); // just the header file
        } else {
            $this->load->view('home/superdashboard', $data); // just the header file
        }
        $this->load->view('request_lab_test', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function getMasterLabList()
    {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['labs'] = $this->lab_model->getMasterLabBySearch($search);
            } else {
                $data['labs'] = $this->lab_model->getMasterLab();
            }
        } else {
            if (!empty($search)) {
                $data['labs'] = $this->lab_model->getMasterLabByLimitBySearch($limit, $start, $search);
            } else {
                $data['labs'] = $this->lab_model->getMasterLabByLimit($limit, $start);
            }
        }

        //  $data['appointments'] = $this->appointment_model->getAppointment();
        $i = 0;
        foreach ($data['labs'] as $lab) {
            $i = $i + 1;
            $settings = $this->settings_model->getSettings();

            if ($lab->status == 'active') {
                $active = ' <label class="switch"><input type="checkbox" class="references_class" name="" data-id="' . $lab->id . '" value="on" checked/><span class="slider round"></span></label>';
            } else {
                $active = ' <label class="switch"><input type="checkbox" class="references_class" name="" data-id="' . $lab->id . '" value="on"/><span class="slider round"></span></label>';
            }


            $option1 = '<a class="btn btn-info btn-xs btn_width" href="lab/editMasterLab?id=' . $lab->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
            if ($lab != 96) {
                $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="lab/deleteMasterLab?id=' . $lab->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            } else {
                $option2 = ' ';
            }
            $info[] = array(
                $lab->id,
                $lab->name,
                $lab->description,
                $lab->speciality,
                //                $quan . '<br>' . $load,
                $active,
                $option1 . ' ' . $option2
                //  $options2
            );
        }

        if (!empty($data['labs'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('master_lab_test')->num_rows(),
                "recordsFiltered" => $this->db->get('master_lab_test')->num_rows(),
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

    function deleteMasterLab()
    {
        $id = $this->input->get('id');
        $parameters = $this->lab_model->getParameterByLabTest($id);
        if (!empty($parameters)) {
            foreach ($parameters as $para) {
                $test = $this->lab_model->deleteParameter($para->id);
            }
        }
        $this->lab_model->deleteMasterLabTest($id);
        $this->session->set_flashdata('feedback', "supprimé");
        redirect('lab/masterLabList');
    }

    function editMasterLab()
    {
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);

        $data['lab_test'] = $this->lab_model->getMasterLabById($id);
        $data['parameters'] = $this->lab_model->getParameterByLabTest($id);
        $this->load->view('home/superdashboard', $data); // just the header file
        $this->load->view('add_master_lab_test_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function updateLabTestStatus()
    {
        $id = $this->input->get('id');
        $value = $this->input->get('value');
        $data = array('status' => $value);
        $this->lab_model->updateMasterLabTest($id, $data);
        $data['response'] = 'update';
        echo json_encode($data);
    }

    function allActiveLabTest()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['settings'] = $this->settings_model->getSettings();

        $data['settings'] = $this->settings_model->getSettings();
        if ($this->ion_auth->in_group(array('admin', 'Laboratorist', 'Biologiste','adminmedecin'))) {
            $this->load->view('home/dashboard', $data); // just the header file
        } else {
            $this->load->view('home/superdashboard', $data); // just the header file
        }
        $this->load->view('all_active_lab_test', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function getAllActiveLabList()
    {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['labs'] = $this->lab_model->getMasterLabBySearch($search);
            } else {
                $data['labs'] = $this->lab_model->getMasterLab();
            }
        } else {
            if (!empty($search)) {
                $data['labs'] = $this->lab_model->getMasterLabByLimitBySearch($limit, $start, $search);
            } else {
                $data['labs'] = $this->lab_model->getMasterLabByLimit($limit, $start);
            }
        }

        //  $data['appointments'] = $this->appointment_model->getAppointment();
        $i = 0;
        $count = 0;
        foreach ($data['labs'] as $lab) {
            $i = $i + 1;
            $settings = $this->settings_model->getSettings();

            //            if ($lab->status == 'active') {
            //               $active=' <label class="switch"><input type="checkbox" class="references_class" name="" data-id="'.$lab->id.'" value="on" checked/><span class="slider round"></span></label>';
            //                
            //            } else {
            //                $active=' <label class="switch"><input type="checkbox" class="references_class" name="" data-id="'.$lab->id.'" value="on"/><span class="slider round"></span></label>';
            //            }
            //            

            $load = '<button type="button" class="btn btn-info btn-xs btn_width load" data-toggle="modal" data-id="' . $lab->id . '">' . lang('import') . '</button>';
            if ($lab->status == 'active') {
                if (empty($lab->insert_organ)) {
                    $info[] = array(
                        $lab->id,
                        $lab->name,
                        $lab->description,
                        $lab->speciality,
                        $load
                    );
                    $count++;
                } else {

                    $insert_orgaan = explode("**", $lab->insert_organ);

                    if (!in_array($this->id_organisation, $insert_orgaan)) {
                        $info[] = array(
                            $lab->id,
                            $lab->name,
                            $lab->description,
                            $lab->speciality,
                            $load
                        );
                        $count++;
                    } else {
                        $info1[] = array(
                            $lab->id,
                            $lab->name,
                            $lab->description,
                            $lab->speciality,
                            $load
                        );
                    }
                }
            } else {
                $info1[] = array(
                    $lab->id,
                    $lab->name,
                    $lab->description,
                    $lab->speciality,
                    $load
                );
            }
        }

        if ($count != 0) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
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

    function importLabTest()
    {
        $add_price = $this->input->post('add_price');
        $id = $this->input->post('id');
        if (!empty($id)) {
            $status = $this->input->post('status');
            $data_up = array(
                'status' => $status,
                'add_price' => $add_price
            );
            $this->lab_model->updateImportedLabTest($id, $data_up);
            $this->session->set_flashdata('feedback', "mis à jour");
            redirect('lab/allLabTestByOrganisation');
        } else {
            $imported_id = $this->input->post('imported_id');
            $code = rand(pow(10, 2), pow(10, 3) - 1);
            $lab_master = $this->lab_model->getMasterLabTestById($imported_id);
            $data = array(
                'speciality' => $lab_master->speciality,
                'name' => $lab_master->name,
                'description' => $lab_master->description,
                'parameter' => $lab_master->parameter,
                'add_price' => $add_price,
                'master_id' => $lab_master->id,
                'id_organisation' => $this->id_organisation,
                'status' => 'active',
                'code' => $code
            );
            $this->lab_model->insertLabTest($data);
            $inserted_id = $this->db->insert_id();
            if (empty($lab_master->insert_organ)) {
                $data_up = array('insert_organ' => $this->id_organisation);
            } else {
                $insert_organ = $lab_master->insert_organ . '**' . $this->id_organisation;
                $data_up = array('insert_organ' => $insert_organ);
            }
            $this->lab_model->updateMasterLabTest($imported_id, $data_up);
            $this->session->set_flashdata('feedback', "importé");
            redirect('lab/allActiveLabTest');
        }
    }

    function allLabTestByOrganisation()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['settings'] = $this->settings_model->getSettings();

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('all_lab_test', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function getAllImportedLabList()
    {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        $organisation = $this->id_organisation;
        if ($limit == -1) {
            if (!empty($search)) {
                $data['labs'] = $this->lab_model->getImportedLabBySearch($organisation, $search);
            } else {
                $data['labs'] = $this->lab_model->getImportedLab($organisation);
            }
        } else {
            if (!empty($search)) {
                $data['labs'] = $this->lab_model->getImportedLabByLimitBySearch($organisation, $limit, $start, $search);
            } else {
                $data['labs'] = $this->lab_model->getImportedLabByLimit($organisation, $limit, $start);
            }
        }

        //  $data['appointments'] = $this->appointment_model->getAppointment();
        $i = 0;
        foreach ($data['labs'] as $lab) {
            $i = $i + 1;
            $settings = $this->settings_model->getSettings();

            if ($lab->status == 'active') {
                $active = ' <label class="switch"><input type="checkbox" class="references_class" name="" data-id="' . $lab->id . '" value="on" checked/><span class="slider round"></span></label>';
            } else {
                $active = ' <label class="switch"><input type="checkbox" class="references_class" name="" data-id="' . $lab->id . '" value="on"/><span class="slider round"></span></label>';
            }

            $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $lab->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</button>';
            //  $option1 = '<a class="btn btn-info btn-xs btn_width" href="lab/editMasterLab?id=' . $lab->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
            if ($lab->master_id != 96) {
                $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="lab/deleteLabTest?id=' . $lab->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            } else {
                $option2 = ' ';
            }
            $info[] = array(
                $lab->id,
                $lab->name,
                $lab->description,
                $lab->speciality,
                $lab->add_price,
                //                $quan . '<br>' . $load,
                $active,
                $option1 . ' ' . $option2
                //  $options2
            );
        }

        if (!empty($data['labs'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('lab_test')->num_rows(),
                "recordsFiltered" => $this->db->get('lab_test')->num_rows(),
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

    function updateImportedLabTestStatus()
    {
        $id = $this->input->get('id');
        $value = $this->input->get('value');
        $data = array('status' => $value);
        $this->lab_model->updateImportedLabTest($id, $data);
        $data['response'] = 'update';
        echo json_encode($data);
    }

    function editImportedLabTestByJason()
    {
        $id = $this->input->get('id');
        $data['lab'] = $this->lab_model->getLabTestImportedById($id);
        echo json_encode($data);
    }

    function deleteLabTest()
    {
        $id = $this->input->get('id');
        $import_lab = $this->lab_model->getLabTestImportedById($id);
        $master_lab = $this->lab_model->getMasterLabById($import_lab->master_id);
        $master_lab_explode = explode("**", $master_lab->insert_organ);

        if (count($master_lab_explode) == 1) {
            $insert_organ = ' ';
        } else {

            $index = array_search($this->id_organisation, $master_lab_explode);

            unset($master_lab_explode[$index]);

            $insert_organ = implode('**', $master_lab_explode);
        }
        $data_up = array('insert_organ' => $insert_organ);
        $this->lab_model->updateMasterLabTest($master_lab->id, $data_up);

        $this->lab_model->deleteImportedLabTest($id);
        $this->session->set_flashdata('feedback', "supprimé");
        redirect('lab/allLabTestByOrganisation');
    }

    function getRequestedMasterLabList()
    {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        $organisation = $this->id_organisation;
        if ($this->ion_auth->in_group(array('Laboratorist', 'admin'))) {

            if ($limit == -1) {
                if (!empty($search)) {
                    $data['labs'] = $this->lab_model->getRequestedMasterLabBySearchByOrganisation($organisation, $search);
                } else {
                    $data['labs'] = $this->lab_model->getRequestedMasterLabByOrganisation($organisation);
                }
            } else {
                if (!empty($search)) {
                    $data['labs'] = $this->lab_model->getRequestedMasterLabByLimitBySearchByOrganisation($organisation, $limit, $start, $search);
                } else {
                    $data['labs'] = $this->lab_model->getRequestedMasterLabByLimitByOrganisation($organisation, $limit, $start);
                }
            }
        } else {
            if ($limit == -1) {
                if (!empty($search)) {
                    $data['labs'] = $this->lab_model->getRequestedMasterLabBySearch($search);
                } else {
                    $data['labs'] = $this->lab_model->getRequestedMasterLab();
                }
            } else {
                if (!empty($search)) {
                    $data['labs'] = $this->lab_model->getRequestedMasterLabByLimitBySearch($limit, $start, $search);
                } else {
                    $data['labs'] = $this->lab_model->getRequestedMasterLabByLimit($limit, $start);
                }
            }
        }
        //  $data['appointments'] = $this->appointment_model->getAppointment();
        $i = 0;
        foreach ($data['labs'] as $lab) {
            $i = $i + 1;
            $settings = $this->settings_model->getSettings();

            if ($lab->accept == 'pending') {
                $approved = '<a type="button" class="btn btn-info btn-xs btn_width" href="lab/approvedLabTest?id=' . $lab->id . '">' . lang('approved') . '</a>';
            } else {
                $approved = ' ';
            }
            if ($lab->accept == 'pending') {
                $decline = '<a type="button" class="btn btn-warning btn-xs btn_width" href="lab/declineLabTest?id=' . $lab->id . '">' . lang('decline') . '</a>';
            } else {
                $decline = ' ';
            }

            if ($lab->accept == 'pending') {
                $lang_acc = '<span>' . lang('pending') . '</span>';
            } elseif ($lab->accept == 'decline') {
                $lang_acc = '<span>' . lang('decline') . '</span>';
            } else {
                $lang_acc = '<span>' . lang('approved') . '</span>';
            }


            $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="lab/deleteRequestedMasterLab?id=' . $lab->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            if (!$this->ion_auth->in_group(array('Laboratorist', 'admin'))) {

                $info[] = array(
                    $lab->id,
                    $lab->name,
                    $lab->description,
                    $lab->speciality,
                    $lang_acc,
                    $approved . ' ' . $decline . ' ' . $option2
                    //  $options2
                );
            } else {

                $info[] = array(
                    $lab->id,
                    $lab->name,
                    $lab->description,
                    $lab->speciality,
                    $lang_acc,
                    $option2
                    //  $options2
                );
            }
        }

        if (!empty($data['labs'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('request_lab_test')->num_rows(),
                "recordsFiltered" => $this->db->get('request_lab_test')->num_rows(),
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

    function deleteRequestedMasterLab()
    {
        $id = $this->input->get('id');
        $request_details = $this->lab_model->getRequestedMasterLabTestById($id);
        if ($request_details->accept == 'pending' || $request_details->accept == 'decline') {
            $parameters = $this->lab_model->getParameterByRequestedLabTest($id);
            if (!empty($parameters)) {
                foreach ($parameters as $para) {
                    $test = $this->lab_model->deleteParameter($para->id);
                }
            }
        }

        $this->lab_model->deleteRequestedMasterLabTest($id);
        $this->session->set_flashdata('feedback', "supprimé");
        redirect('lab/requestLabTestList');
    }

    function declineLabTest()
    {
        $id = $this->input->get('id');
        $data = array('accept' => 'decline');
        $this->lab_model->updateRequestedLabTest($id, $data);
        $this->session->set_flashdata('feedback', "diminué");
        redirect('lab/requestLabTestList');
    }

    function approvedLabTest()
    {
        $id = $this->input->get('id');
        $request_details = $this->lab_model->getRequestedMasterLabTestById($id);
        $data = array(
            'speciality' => $request_details->speciality,
            'name' => $request_details->name,
            'description' => $request_details->description,
            'parameter' => $request_details->parameter,
            'status' => 'active',
        );

        $test1 = $this->lab_model->insertMasterLabTest($data);
        $inserted_id = $this->db->insert_id();

        $parameters = $this->lab_model->getParameterByRequestedLabTest($id);
        if (!empty($parameters)) {
            foreach ($parameters as $para) {
                $data_up = array();
                $data_up = array('test_id' => $inserted_id);
                $test = $this->lab_model->updateParameterLabTest($para->id, $data_up);
            }
        }
        $data_now = array('accept' => 'approved');
        $this->lab_model->updateRequestedLabTest($id, $data_now);
        $this->session->set_flashdata('feedback', "approuvé");
        redirect('lab/requestLabTestList');
    }

    public function getLabListForSelect2()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->lab_model->getMasterLabInfo($searchTerm);

        echo json_encode($response);
    }

    public function getLabListForPayment()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->lab_model->getLabInfo($this->id_organisation, $searchTerm);

        echo json_encode($response);
    }

    function getMasterLabIdForPcr()
    {
        $id = $this->input->get('id');
        $lab_details = $this->lab_model->getLabTestImportedById($id);
        if (strtolower($lab_details->name) == 'pcr') {
            $data['response'] = 'pcr';
        } else {
            $data['response'] = 'no';
        }
        echo json_encode($data);
    }

    function getLabParaMeterDetails()
    {
        $id = $this->input->get('id');
        $data['lab_parameter'] = $this->lab_model->getParameterId($id);
        echo json_encode($data);
    }
    function addReport()
    {
        $report_id = $this->input->get('report_id');

        if (!empty($report_id)) {
            $data['report_details'] = $this->lab_model->getReportbyId($report_id);
            $data['report_id'] = $report_id;
        } else {
            $data['report_id'] = ' ';
            $data['report_details'] = array();
        }
        $patient_id = $this->input->get('patient_id');
        $data['payment'] = $this->input->get('payment');
        $lab_id = $this->input->get('lab_id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['entete'] = $this->entete;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['payments'] = $this->finance_model->getPaymentById($this->input->get('payment'));
        $data['organisation'] = $this->home_model->getOrganisationById($this->id_organisation);
        $data['patient_details'] = $this->patient_model->getPatientById($patient_id);
        $data['lab_details'] = $this->lab_model->getLabTestImportedById($lab_id);
        $data['type_of_sampling'] = $this->lab_model->getTypeSampling();
        $data['conclusions'] = $this->lab_model->getConclusion();

        $this->load->view('home/dashboard', $data);
        $this->load->view('add_report', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function addNewReport()
    {
        $report_id = $this->input->post('report_id');
        $report_code = $this->input->post('report_code');
        $redirect = $this->input->post('redirect');
        $conclusion_add = $this->input->post('conclusion');
        $status = "EFFECTUÉ";
        if ($conclusion_add == 'add_new') {
            $data_con = array('name' => $this->input->post('new_conclusion'));
            $this->lab_model->insertConclusion($data_con);
            $conclusion = $this->db->insert_id('conclusion');
        } else {
            $conclusion = $conclusion_add;
        }

        $type_of_sampling_add = $this->input->post('type_of_sampling');
        if ($type_of_sampling_add == 'add_new') {
            $data_samp = array('name' => $this->input->post('new_sampling'));
            $this->lab_model->insertSampling($data_samp);
            $sampling = $this->db->insert_id('sampling');
        } else {
            $sampling = $type_of_sampling_add;
        }
        $lab_id = $this->input->post('lab_id');
        $payment_id = $this->input->post('payment_id');
        $patient_id = $this->input->post('patient_id');

        $lab_details = $this->lab_model->getLabTestImportedById($lab_id);
        $lab_details_explode = explode("**", $lab_details->parameter);



        foreach ($lab_details_explode as $para) {
            $lab_parameter = $this->lab_model->getMasterLabTestByIdByName($lab_details->master_id, $para);
            if (count($lab_parameter) > 1) {
                $selected_item = $this->input->post('parameter_' . $para . '_' . $lab_details->master_id);
                $parameter_details = $this->lab_model->getParameterId($selected_item);
                if ($parameter_details->reference_type == 'off_switch') {
                    $high = $this->input->post('high_' . $parameter_details->parameter_name . '_' . $parameter_details->id);
                    //$low = $this->input->post('low_' . $parameter_details->parameter_name . '_' . $parameter_details->id);
                    $details_con[] = $parameter_details->reference_type . '**' . $lab_id . '**' . $parameter_details->parameter_name . '**' . $parameter_details->unit_of_measure . '**' . $parameter_details->high . '**' . $parameter_details->low . '**' . $parameter_details->id . '**' . $high;
                } else {
                    $pos_neg = $this->input->post('pos_' . $parameter_details->parameter_name . '_' . $parameter_details->id);
                    $details_con[] = $parameter_details->reference_type . '**' . $lab_id . '**' . $parameter_details->parameter_name . '**' . $parameter_details->unit_of_measure . '**' . $parameter_details->positive_negative . '**' . $parameter_details->id . '**' . $pos_neg;
                }
            } else {
                foreach ($lab_parameter as $lab_parameter) {
                    if ($lab_parameter->reference_type == 'off_switch') {
                        $high = $this->input->post('high_' . $lab_parameter->parameter_name . '_' . $lab_parameter->id);
                        // $low = $this->input->post('high_' . $lab_parameter->parameter_name . '_' . $lab_parameter->id);
                        $details_con[] = $lab_parameter->reference_type . '**' . $lab_id . '**' . $lab_parameter->parameter_name . '**' . $lab_parameter->unit_of_measure . '**' . $lab_parameter->high . '**' . $lab_parameter->low . '**' . $lab_parameter->id . '**' . $high;
                    } else {
                        $pos_neg = $this->input->post('pos_' . $lab_parameter->parameter_name . '_' . $lab_parameter->id);
                        $details_con[] = $lab_parameter->reference_type . '**' . $lab_id . '**' . $lab_parameter->parameter_name . '**' . $lab_parameter->unit_of_measure . '**' . $pos_neg . '**' . $lab_parameter->id . '**' . $pos_neg;
                    }
                }
            }
        }

        $details = implode("##", $details_con);
        $data = array(
            'patient' => $patient_id,
            'payment' => $payment_id,
            'details' => $details,
            'lab_id' => $lab_id,
            'conclusion' => $conclusion,
            'status' => $status,
            'sampling' => $sampling,
            'sampling_date' => $this->input->post('date_time'),
            'id_organisation' => $this->id_organisation,
            'report_code' => $report_code
        );


        if (empty($report_id)) {
            $data['user'] = $this->ion_auth->get_user_id();
            $this->lab_model->insertReport($data);
            $inserted_id = $this->db->insert_id('lab_report');
        } else {
            // var_dump($pos_neg, $conclusion, $report_id, $data);
            // exit();
            $this->lab_model->updateLabReport($report_id, $data);
            $inserted_id = $report_id;
        }


        $name = $this->input->post('name');
        $last_name = $this->input->post('last_name');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $age = $this->input->post('age');
        $sex = $this->input->post('gender');
        $email = $this->input->post('email');
        $birthdate = $this->input->post('birthdate');
        $passport = $this->input->post('passport');
        $purpose = $this->input->post('purpose');



        $dataPatient = array(
            'name' => $name, 
            'last_name' => $last_name,
            'status' => 1, 
            'id_organisation' => $this->id_organisation,
            'email' => $email,
            'address' => $address,
            'phone' => $phone,
            'sex' => $sex,
            'age' => $age,
            'birthdate' => $birthdate,
            'passport' => $passport,
            'phone' => $phone,
            'email' => $email
        );

        $dataPayment = array(
            'status' => 'done',
        );

        $this->patient_model->updatePatient($patient_id, $dataPatient, $this->id_organisation);

        $this->finance_model->updatePayment($payment_id, $dataPayment);




        $patient_details = $this->patient_model->getPatientById($patient_id);
        $link = lang('patient') . ' ' . lang('name') . ':' . $patient_details->name . ' ' . $patient_details->last_name .
            ',' . lang('date_of_birth') . ':' . $patient_details->birthdate .
            ',' . lang('prestation') . ':' . $lab_details->name .
            ',' . lang('test_date') . ':' . $this->input->post('date_time') .
            ',' . lang('result') . ':' . $this->db->get_where('conclusion', array('id' => $conclusion))->row()->name;

        $data_get = $this->generate_qrcode($lab_details->name, $link);
        $data_update = array('qr_code' => $data_get['file']);

        $this->lab_model->updateLabReport($inserted_id, $data_update);



        //  redirect('lab/reportView?id=' . $inserted_id);
        redirect($redirect);
    }

    function reportView()
    {
        $id = $this->input->get('id');
        $edit = $this->input->get('edit');
        $data['report_details'] = $this->lab_model->getReportbyId($id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['entete'] = $this->entete;
        $data['footer'] = $this->footer;
        $data['signature'] = $this->signature;
        $data['organisation'] = $this->home_model->getOrganisationById($this->id_organisation);
        $data['payments'] = $this->finance_model->getPaymentById($data['report_details']->payment);
        $data['lab_details'] = $this->lab_model->getLabTestImportedById($data['report_details']->lab_id);
       

        if (isset($data['signature'])) {
            $data['signature'] = $this->signature;
        } else {
            $data['signature'] = 'uploads/entetePartenaires/signatureDefault.png';
        }

        $this->load->view('home/dashboard', $data);
        if(!empty($edit)){
            $this->load->view('report_view_edit', $data);
        }else{
            $this->load->view('report_view', $data);
        }
        
        $this->load->view('home/footer'); // just the header file
    }


    function reportViewResultat()
    {
        $id = $this->input->get('id');
        $data['report_details'] = $this->lab_model->getReportbyId($id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['entete'] = $this->entete;
        $data['footer'] = $this->footer;
        $data['organisation'] = $this->home_model->getOrganisationById($this->id_organisation);
        $data['payments'] = $this->finance_model->getPaymentById($data['report_details']->payment);
        $data['lab_details'] = $this->lab_model->getLabTestImportedById($data['report_details']->lab_id);
        $signature = $data['report_details']->doc_id;
        // $data['user_signature'] = $this->db->query("select * from doctor_signature where doc_id = '$signature'")->row();
   
        // if (isset($data['user_signature'])) {
        //     $data['user_signature'] = $data['user_signature']->sign_name;
        // } else {
        //     $data['user_signature'] = '';
        // }
        // var_dump(( $data['user_signature']));
        // exit();
        $qrCode = 'uploads/qrcode/'.$data['report_details']->qr_code;
         // Format the image SRC:  data:{mime};base64,{data} entete;
         $img_file_qrcode = $qrCode;
         $imgData_qrcode = base64_encode(file_get_contents($img_file_qrcode));
         $data['qrcodeBase64'] = 'data:' . mime_content_type($img_file_qrcode) . ';base64,' . $imgData_qrcode;
        
        $data['user_signature'] = $this->signature;

        if (isset($data['user_signature'])) {
            $data['user_signature'] = $this->signature;
        } else {
            $data['user_signature'] = 'uploads/entetePartenaires/signatureDefault.png';
        }

        if (isset($data['footer'])) {
            $data['footer'] = $this->footer;
        } else {
            $data['footer'] = 'uploads/entetePartenaires/defaultFooter.PNG';
        }

        // Format the image SRC:  data:{mime};base64,{data} entete;
        $img_file_entete = $data['entete'];
        $imgData_entete = base64_encode(file_get_contents($img_file_entete));
        $data['enteteBase64'] = 'data:' . mime_content_type($img_file_entete) . ';base64,' . $imgData_entete;

        // Format the image SRC:  data:{mime};base64,{data} footer;
        $img_file_footer = $data['footer'];
        $imgData_footer = base64_encode(file_get_contents($img_file_footer));
        $data['footerBase64'] = 'data:' . mime_content_type($img_file_footer) . ';base64,' . $imgData_footer;

        // Format the image SRC:  data:{mime};base64,{data} signature;
        $img_file_signature = $data['user_signature'];
        $imgData_signature = base64_encode(file_get_contents($img_file_signature));
        $data['signatureBase64'] = 'data:' . mime_content_type($img_file_signature) . ';base64,' . $imgData_signature;


        

        $this->load->view('home/dashboard', $data);
        $this->load->view('report_view_2', $data);
        $this->load->view('home/footer'); // just the header file
    }


    function reportViewResultatSignature()
    {
        $id = $this->input->get('id');
        $data['report_details'] = $this->lab_model->getReportbyId($id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['entete'] = $this->entete;
        $data['footer'] = $this->footer;
        $data['organisation'] = $this->home_model->getOrganisationById($this->id_organisation);
        $data['payments'] = $this->finance_model->getPaymentById($data['report_details']->payment);
        $data['lab_details'] = $this->lab_model->getLabTestImportedById($data['report_details']->lab_id);
        $signature = $data['report_details']->doc_id;
        $data['user_signature'] = $this->db->query("select * from doctor_signature where doc_id = '$signature'")->row();
   
        if (isset($data['user_signature'])) {
            $data['user_signature'] = $data['user_signature']->sign_name;
        } else {
            $data['user_signature'] = '';
        }
        // var_dump(( $data['user_signature']));
        // exit();
        $qrCode = 'uploads/qrcode/'.$data['report_details']->qr_code;
         // Format the image SRC:  data:{mime};base64,{data} entete;
         $img_file_qrcode = $qrCode;
         $imgData_qrcode = base64_encode(file_get_contents($img_file_qrcode));
         $data['qrcodeBase64'] = 'data:' . mime_content_type($img_file_qrcode) . ';base64,' . $imgData_qrcode;
        
        // $data['signature'] = $this->signature;

        // if (isset($data['signature'])) {
        //     $data['signature'] = $this->signature;
        // } else {
        //     $data['signature'] = 'uploads/entetePartenaires/signatureDefault.png';
        // }

        if (isset($data['footer'])) {
            $data['footer'] = $this->footer;
        } else {
            $data['footer'] = 'uploads/entetePartenaires/defaultFooter.PNG';
        }

        // Format the image SRC:  data:{mime};base64,{data} entete;
        $img_file_entete = $data['entete'];
        $imgData_entete = base64_encode(file_get_contents($img_file_entete));
        $data['enteteBase64'] = 'data:' . mime_content_type($img_file_entete) . ';base64,' . $imgData_entete;

        // Format the image SRC:  data:{mime};base64,{data} footer;
        $img_file_footer = $data['footer'];
        $imgData_footer = base64_encode(file_get_contents($img_file_footer));
        $data['footerBase64'] = 'data:' . mime_content_type($img_file_footer) . ';base64,' . $imgData_footer;

        // Format the image SRC:  data:{mime};base64,{data} signature;
        $img_file_signature = $data['user_signature'];
        $imgData_signature = base64_encode(file_get_contents($img_file_signature));
        $data['signatureBase64'] = 'data:' . mime_content_type($img_file_signature) . ';base64,' . $imgData_signature;


        

        $this->load->view('home/dashboard', $data);
        $this->load->view('report_view_2', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function generate_qrcode($name, $data)
    {

        $this->load->library('ciqrcode');

        /* Data */
        $hex_data = bin2hex($data);
        $save_name = $name . rand() . '.png';

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

        $report_details = $this->lab_model->getReportById($report_id);
        $data['report_details'] = $this->lab_model->getReportById($report_id);

        $generate_otp = $this->db->get_where('generated_otp', array('id' => $id))->row()->otp;

        if ($generate_otp == $otp) {
            $data['otp'] = 'yes';
            $data['signature'] = $this->db->get_where('users', array('id' => $report_details->user))->row();

            $data_up = array('signature' => 'yes');
            $this->lab_model->updateLabReport($report_id, $data_up);
        } else {
            $data['otp'] = 'no';
        }


        echo json_encode($data);
    }

    function transfer()
    {
        $id = $this->input->post('report_id');
        $data['date_prescription'] = $this->input->post('date_prescription');
        $data['conclusionPCRConvert'] = $this->input->post('conclusionPCRConvert');
        $data['conclusionPCR'] = $this->input->post('conclusionPCR');
        $data['resultatPCR'] = $this->input->post('resultatPCR');
        $data['report_details'] = $this->lab_model->getReportbyId($id);
        $patient = $this->patient_model->getPatientById($data['report_details']->patient);
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['entete'] = $this->entete;
        $data['footer'] = $this->footer;
        $data['signature'] = 'uploads/imgUsers/signature.PNG';
        $data['organisation'] = $this->home_model->getOrganisationById($this->id_organisation);
        $data['payments'] = $this->finance_model->getPaymentById($data['report_details']->payment);
        $data['lab_details'] = $this->lab_model->getLabTestImportedById($data['report_details']->lab_id);
        $image = '';
        if(!empty($data['footer'])){
            $image = $data['footer'];
        }else{
            $image = "uploads/entetePartenaires/defaultFooter.PNG";
        }

        error_reporting(0);
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
        $mpdf->SetHTMLFooter('
<div style="text-align:right;font-weight: bold; font-size: 8pt; font-style: italic;">' .
                '<img class="foot" src="'.$image.'" width="750" height="60" alt="alt"/>' .
                '</div>', 'O');
        $html = $this->load->view('pdf_download', $data, true);
        $mpdf->WriteHTML($html);

        $filename = "lab-report--00" . $id . ".pdf";
        // $mpdf->Output();
        $mpdf->Output('uploads/invoicefile/' . $filename, 'F');
        $medium = $this->input->post('medium');

        if ($medium == 'email') {
            $patientemail = $this->input->post('email');

            $id_organisation = $this->id_organisation;
            $email = $this->db->get_where('organisation', array('id' => $id_organisation))->row()->email;

            $subject = lang('lab_report');
            $this->load->library('encryption');
            $this->email->from($email);
            $this->email->to($patientemail);
            $this->email->subject($subject);
            $this->email->message('<br>Please Find your Lab Report');
            $this->email->attach('uploads/invoicefile/' . $filename);
            if ($this->email->send()) {
                unlink('uploads/invoicefile/' . $filename);
                $this->session->set_flashdata('feedback', lang('lab_status'));
                $data_transfer = array('transfer' => 'yes', 'status' => 'Envoyé');
                $this->lab_model->updateLabReport($id, $data_transfer);
                redirect("finance/paymentlabo");
            } else {
                unlink(APPPATH . '../invoicefile/' . $filename);
                $this->session->set_flashdata('feedback', lang('not') . ' ' . 'able to deliver Lab Report');
                redirect("finance/paymentlabo");
            }
        } else {
            $whatsapp_message = $this->db->get_where('autowhatsapptemplate', array('type' => 'Whatsapp_lab'))->row();
            if ($whatsapp_message->status == 'Active') {
                $message = $whatsapp_message->message;
                $organisation_details = $this->db->get_where('organisation', array('id' => $id_organisation))->row();
                $data1 = array(
                    'name' => $patient->name . ' ' . $patient->last_name,
                    'lastname' => $patient->last_name,
                    'firstname' => $patient->name,
                    'sample_date' => $data['report_details']->sampling_date,
                    'numero_telephone' => $organisation_details->numero_fixe,
                    'company' => $organisation_details->nom_commercial
                );
                $messageprint = $this->parser->parse_string($message, $data1);
            } else {
                $messageprint = 'Lab Report';
            }
            $to = $this->input->post('whatsapp');
            $whatsapp_cre = $this->db->get_where('whatsapp_settings', array('id' => 1))->row();
            $url =  'https://api.chat-api.com/instance' . $whatsapp_cre->instance_id . '/sendFile?token=' . $whatsapp_cre->token;
            $url1 =  'https://api.chat-api.com/instance' . $whatsapp_cre->instance_id . '/message?token=' . $whatsapp_cre->token;
            $imageLocation = base_url() . 'uploads/invoicefile/' . $filename;
            $data1 = [
                'phone' => $to,
                'body' => $messageprint,

            ];
            $send1 = json_encode($data1);
            $options1 = stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-type: application/json',
                    'content' => $send1,
                ]
            ]);
            $result1 = file_get_contents($url1, false, $options1);
            $result_array1 = json_decode($result1, true);

            $data = [
                'phone' => $to,
                'body' => $imageLocation,
                'filename' => $filename,
                'caption' => 'test',
            ];
            $send = json_encode($data);

            $options = stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-type: application/json',
                    'content' => $send,
                ]
            ]);
            // Send a request

            $result = file_get_contents($url, false, $options);
            $result_array = json_decode($result, true);

            if ($result_array['sent'] && $result_array1['sent']) {
                unlink('uploads/invoicefile/' . $filename);
                $this->session->set_flashdata('feedback', 'Send Lab Report');
                $data_transfer = array('transfer' => 'yes');
                $this->lab_model->updateLabReport($id, $data_transfer);
                redirect("finance/paymentlabo");
            } else {
                unlink(APPPATH . '../invoicefile/' . $filename);
                $this->session->set_flashdata('feedback', lang('not') . ' ' . 'able to deliver Lab Report');
                redirect("finance/paymentlabo");
            }
        }
    }

    function download()
    {
        $id = $this->input->get('id');
        $data['report_details'] = $this->lab_model->getReportbyId($id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['organisation'] = $this->home_model->getOrganisationById($this->id_organisation);
        $data['payments'] = $this->finance_model->getPaymentById($data['report_details']->payment);
        $data['lab_details'] = $this->lab_model->getLabTestImportedById($data['report_details']->lab_id);

        error_reporting(0);
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
        $mpdf->SetHTMLFooter('
<div style="text-align:center;font-weight: bold; font-size: 8pt;">' .
            '<span> <strong></strong> <span style="">' . $data['nom_organisation'] . ', ' . $data['settings']->address . ',  Tel: ' . $data['settings']->phone . ' Mail : ' . $data['settings']->email . '</span>' .
            '</div>', 'O');
        $html = $this->load->view('pdf_download', $data, true);
        $mpdf->WriteHTML($html);

        $filename = "lab_report--00" . $id . ".pdf";

        $mpdf->Output($filename, 'D');

        redirect("lab/reportView?id=" . "$id");
    }
}

/* End of file lab.php */
/* Location: ./application/modules/lab/controllers/lab.php */