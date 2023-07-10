<?php
require_once FCPATH . '/vendor/autoload.php';
require __DIR__ . '/../../../../autoload.php';
// require_once FCPATH . '/vendor/phpmailer/phpmailer/src/Exception.php';
// require_once FCPATH . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
// require_once FCPATH . '/vendor/phpmailer/phpmailer/src/SMTP.php';


//require_once FCPATH . '/composer';
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// /* Exception class. */

// $email = new PHPMailer(TRUE);


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Patient extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('patient_model');
        $this->load->model('donor/donor_model');
        $this->load->model('appointment/appointment_model');
        $this->load->model('services/service_model');
        $this->load->model('bed/bed_model');
        $this->load->model('lab/lab_model');
        $this->load->model('finance/finance_model');
        $this->load->model('finance/pharmacy_model');
        $this->load->model('sms/sms_model');
        $this->load->module('sms');
        $this->load->model('prescription/prescription_model');
        $this->load->model('home/home_model');
        require APPPATH . 'third_party/stripe/stripe-php/init.php';
        $this->load->model('medicine/medicine_model');
        $this->load->model('doctor/doctor_model');
        $this->load->module('paypal');
        if (!$this->ion_auth->in_group(array('admin', 'adminmedecin', 'Nurse', 'Patient', 'Doctor', 'Laboratorist', 'Accountant', 'Receptionist', 'adminmedecin'))) {
            // redirect('home/permission');
        }

        $identity = $this->session->userdata["identity"];
        $this->id_organisation = $this->home_model->get_id_organisation($identity);
        $this->path_logo = $this->home_model->get_logo_organisation($this->id_organisation);
        $this->nom_organisation = $this->home_model->get_nom_organisation($this->id_organisation);
        $this->code_organisation = $this->home_model->get_code_organisation($this->id_organisation);
        $this->id_serviceUser = $this->home_model->get_code_service($identity);
    }

    public function index()
    {

        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['groups'] = $this->donor_model->getBloodBank();
        $data['settings'] = $this->settings_model->getSettings();
        $data['regions'] = array('Dakar', 'Ziguinchor', 'Diourbel', 'Saint-Louis', 'Tambacounda', 'Kaolack', 'Thiès', 'Louga', 'Fatick', 'Kolda', 'Matam', 'Kaffrine', 'Kédougou', 'Sédhiou');
        $data['religions'] = array('Musulmane', 'Chretienne', 'Autres');
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('patient', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function calendar()
    {
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('calendar', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }
        $data = array();
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['groups'] = $this->donor_model->getBloodBank();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the header file
    }


    public function addNew()
    {



        $id = $this->input->post('id');
        $redirect = $this->input->get('redirect');
        if (empty($redirect)) {
            $redirect = $this->input->post('redirect');
        }
        $name = $this->input->post('name');
        $last_name = $this->input->post('last_name');
        $password = $this->input->post('password');
        $sms = $this->input->post('sms');
        $doctor = ''; //$this->input->post('doctor');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $age = $this->input->post('age');
        $sex = $this->input->post('sex');
        $birthdate = $this->input->post('birthdate');
        $bloodgroup = $this->input->post('bloodgroup');
        $patient_id = $this->input->post('p_id');
        $matricule = $this->input->post('matricule');
        $grade = $this->input->post('grade');
        $birth_position = $this->input->post('birth_position');
        $nom_contact = $this->input->post('nom_contact');
        $phone_contact = $this->input->post('phone_contact');
        $religion = $this->input->post('religion');
        $region = $this->input->post('region');
        $urlModal = $this->input->post('urlModal');
        $estCivil = $this->input->post('estCivil');
        $passport = $this->input->post('passport');
        $email = $this->input->post('email');
        $phone_recuperation = $this->input->post('phone_recuperation');
        $phone_contact_recuperation = $this->input->post('phone_contact_recuperation');
        $nom_mutuelle = $this->input->post('nom_mutuelle');
        $num_police = $this->input->post('num_police');
        $date_valid = $this->input->post('date_valid');
        $charge_mutuelle = $this->input->post('charge_mutuelle');

        // if (empty($patient_id)) {
        //     // $patient_id = rand(10000, 1000000);
        // }
        // if (empty($id)) {     // Adding New Patient
        //     if ($this->ion_auth->email_check($email)) {
        //         $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
        //         redirect('patient/addNewView');
        //     } else {

        //     }
        // } else {
        //     // $add_date = $this->patient_model->getPatientById($id, $this->id_organisation)->add_date;
        //     //  $registration_time = $this->patient_model->getPatientById($id, $this->id_organisation)->registration_time;
        // }


        $email = $this->input->post('email');
        if (empty($email)) {
            //  $email = $name . '@' . $phone . '.com';
        }



        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Password Field
        if (empty($id)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|min_length[3]|max_length[100]|xss_clean');
        }
        // Validating Email Field
        $this->form_validation->set_rules('email', 'Email', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Doctor Field
        //   $this->form_validation->set_rules('doctor', 'Doctor', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('address', 'Address', 'trim|min_length[2]|max_length[500]|xss_clean');
        // Validating Phone Field           
        $this->form_validation->set_rules('phone', 'Phone', 'trim|min_length[2]|max_length[50]|xss_clean');
        // Validating Email Field
        $this->form_validation->set_rules('sex', 'Sex', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('birthdate', 'Birth Date', 'trim|min_length[2]|max_length[500]|xss_clean');
        // Validating Phone Field           
        //  $this->form_validation->set_rules('bloodgroup', 'Blood Group', 'trim|min_length[1]|max_length[10]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $this->session->set_flashdata('feedback', lang('validation_error'));
                redirect("patient/editPatient?id=$id");
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $data['doctors'] = $this->doctor_model->getDoctor();
                $data['groups'] = $this->donor_model->getBloodBank();
                $this->load->view('home/dashboard'); // just the header file
                $this->load->view('add_new', $data);
                $this->load->view('home/footer'); // just the header file
            }
        } else {
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
                'upload_path' => "./uploads/imgUsers/",
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => False,
                'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "1768",
                'max_width' => "2024"
            );

            $this->load->library('Upload', $config);
            $this->upload->initialize($config);
            $matricule = $this->input->post('matricule');
            $grade = $this->input->post('grade');
            $birth_position = $this->input->post('birth_position');
            $nom_contact = $this->input->post('nom_contact');
            $phone_contact = $this->input->post('phone_contact');
            $religion = $this->input->post('religion');
            if ($this->upload->do_upload('img_url')) {
                $path = $this->upload->data();
                $img_url = "uploads/imgUsers/" . $path['file_name'];
                $data = array();
                $data = array(
                    'img_url' => $img_url,
                    'name' => $name, 'last_name' => $last_name, 'status' => 1, 'id_organisation' => $this->id_organisation,
                    'email' => $email,
                    'address' => $address,
                    'doctor' => $doctor,
                    'phone' => $phone,
                    'sex' => $sex,
                    'age' => $age,
                    'birthdate' => $birthdate,
                    'bloodgroup' => $bloodgroup,
                    'matricule' => $matricule,
                    'grade' => $grade,
                    'birth_position' => $birth_position,
                    'nom_contact' => $nom_contact,
                    'phone_contact' => $phone_contact,
                    'religion' => $religion, 'region' => $region,
                    'estCivil' => $estCivil,
                    'passport' => $passport,
                    'phone_recuperation' => $phone_recuperation,
                    'phone_contact_recuperation' => $phone_contact_recuperation
                );
            } else {
                //$error = array('error' => $this->upload->display_errors());
                $data = array();
                $data = array(
                    'name' => $name, 'last_name' => $last_name, 'status' => 1, 'id_organisation' => $this->id_organisation,
                    'email' => $email,
                    'doctor' => $doctor,
                    'address' => $address,
                    'phone' => $phone,
                    'sex' => $sex,
                    'age' => $age,
                    'birthdate' => $birthdate,
                    'bloodgroup' => $bloodgroup,
                    'matricule' => $matricule,
                    'grade' => $grade,
                    'birth_position' => $birth_position,
                    'nom_contact' => $nom_contact,
                    'phone_contact' => $phone_contact,
                    'religion' => $religion, 'region' => $region,
                    'estCivil' => $estCivil,
                    'passport' => $passport,
                    'phone_recuperation' => $phone_recuperation,
                    'phone_contact_recuperation' => $phone_contact_recuperation
                );
            }




            if (empty($id)) {     // Adding New Patient
                /* if ($this->ion_auth->email_check($email)) {
                  $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                  redirect('patient/addNewView');
                  } else { */

                /// IMPORT 
                $passwordGenerate = '12345';
                $password = $this->ion_auth_model->hash_password($passwordGenerate);
                $dfg = 5;
                $add_date = date('m/d/y');
                $registration_time = time();


                $ion_user_id = $this->db->get_where('users', array('email' => $email))->row()->id;
                // $this->patient_model->insertPatient($data);
                //  $patient_user_id = $this->db->get_where('patient', array('email' => $email))->row()->id;
                $last_patient_user_id = $this->patient_model->insertPatient($data);
                log_message('ecomed', 'addNew patient -  insertPatient');
                log_message('ecomed', json_encode($data));
                $patient_user_id = $last_patient_user_id; //$this->db->get_where('patient', array('email' => $email))->row()->id;
                $count_patient = $this->db->get_where('patient', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
                $patient_id = 'P-' . $this->code_organisation . '-' . str_pad($count_patient, 4, "0", STR_PAD_LEFT);
                $id_info = array('ion_user_id' => $ion_user_id, 'patient_id' => $patient_id);
                $this->patient_model->updatePatient($patient_user_id, $id_info, $this->id_organisation);
                $base_url = str_replace(array('http://', 'https://', ' '), '', base_url()) . "auth/patientlogin";
                //sms
                $set['settings'] = $this->settings_model->getSettings();
                $autosms = $this->sms_model->getAutoSmsByType('patient');
                $message = isset($autosms->message);
                $to = $phone;
                $name1 = explode(' ', $name);
                if (!isset($name1[1])) {
                    $name1[1] = null;
                }
                $data1 = array(
                    'firstname' => $name1[0],
                    'lastname' => $name1[1],
                    'name' => $name,
                    'base_url' => $base_url,
                    'email' => $email,
                    'code_patient' => $patient_id,
                    'password' => $password,
                    'doctor' => $doctor,
                    'company' => $set['settings']->system_vendor
                );

                $dataHospital = array(
                    'name' => $name,
                    'img_url' => $base_url,
                    'email' => $email,
                    'ion_user_id' => $patient_id,
                    'phone' => $phone,
                    'address' => $address
                );
                $this->patient_model->addHospitalIdToIonUser($dataHospital);
                $username = $this->input->post('name');
                $this->ion_auth->registerPatient($patient_id, $name, $last_name, $password, $email, $dfg, $phone, $address, $this->id_organisation, $patient_user_id);
                if (isset($autosms->status) == 'Active') {
                    $messageprint = $this->parser->parse_string($message, $data1);
                    $data2[] = array($to => $messageprint);
                    $this->sms->sendSms($to, $message, $data2);
                }


                //    $autoemail = $this->email_model->getAutoEmailByType('patient');

                $autoemail = $this->email_model->getAutoEmailByType('create_patient');
                if (isset($autoemail)) {
                    $emailSettings = $this->email_model->getEmailSettings();
                    $message1 = $autoemail->message;
                    $subject = $this->parser->parse_string($autoemail->name, $data1);
                    $messageprint2 = $this->parser->parse_string($message1, $data1);
                    $dataInsert = array(
                        'reciepient' => $email,
                        'subject' => $subject,
                        'message' => $messageprint2,
                        'date' => time(),
                        'user' => $this->ion_auth->get_user_id()
                    );
                    $this->email_model->insertEmail($dataInsert);
                    log_message('ecomed', 'addNew patient -  insertEmail');
                    log_message('ecomed', json_encode($dataInsert));
                }





                $this->session->set_flashdata('feedback', lang('added'));


                /// IMPORT 
                // $dfg = 5;
                // $this->ion_auth->register($username, $password, $email, $dfg);
                // $ion_user_id = $this->db->get_where('users', array('email' => $email))->row()->id;
                // $last_patient_user_id = $this->patient_model->insertPatient($data);
                // log_message('ecomed', 'addNew patient -  insertPatient');
                // log_message('ecomed', json_encode($data));
                // $patient_user_id = $last_patient_user_id; //$this->db->get_where('patient', array('email' => $email))->row()->id;
                // $count_patient = $this->db->get_where('patient', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
                // $patient_id = 'P-' . $this->code_organisation . '-' . str_pad($count_patient, 4, "0", STR_PAD_LEFT);
                // // $patient_id = $this->code_organisation . '' . $count_patient;
                // // if($estCivil == "non"){
                // //     $patient_id = $patient_id.''.$matricule;
                // // }
                // $id_info = array('ion_user_id' => $ion_user_id, 'patient_id' => $patient_id);


                // $this->patient_model->updatePatient($last_patient_user_id, $id_info, $this->id_organisation);
                // log_message('ecomed', 'addNew patient -  updatePatient');
                // log_message('ecomed', json_encode($data));
                // //sms
                // $phone_sms = '';
                // if (!empty($phone_recuperation)) {
                //     $phone_sms = $phone_recuperation;
                // } else {
                //     $phone_sms = $phone;
                // }

                // $data1 = array(
                //     'name' => $name . " " . $last_name,
                //     'company' => $this->nom_organisation,
                //     'code_patient' => $patient_id
                // );

                // $autosms = $this->sms_model->getAutoSmsByType('create_patient');
                // if (isset($autosms)) {
                //     $message = $autosms->message;
                //     $to = $phone_sms;


                //     $messageprint = $this->parser->parse_string($message, $data1);
                //     // Temp Special Chars / SMS
                //     $toReplace = array("é", "è", "à", "\r\n", "\r", "\n");
                //     $replaceBy   = array("e", "e", "a", "", "", "");
                //     $dataInsert = array(
                //         'recipient' => $phone_sms,
                //         'message' => str_replace($toReplace, $replaceBy, $messageprint),
                //         'date' => time(),
                //         'user' => $this->ion_auth->get_user_id()
                //     );
                //     $this->sms_model->insertSms($dataInsert);
                //     log_message('ecomed', 'addNew patient -  insertSms');
                //     log_message('ecomed', json_encode($dataInsert));
                // }
                //email

                // $passwordGenerate = '12121212';
                // $password = $this->ion_auth_model->hash_password($passwordGenerate);

                // $autoemail = $this->email_model->getAutoEmailByType('create_patient');
                // if (isset($autoemail)) {
                //     $emailSettings = $this->email_model->getEmailSettings();
                //     $message1 = $autoemail->message;
                //     $subject = $this->parser->parse_string($autoemail->name, $data1);
                //     $messageprint2 = $this->parser->parse_string($message1, $data1);
                //     $dataInsert = array(
                //         'reciepient' => $email,
                //         'subject' => $subject,
                //         'message' => $messageprint2,
                //         'date' => time(),
                //         'user' => $this->ion_auth->get_user_id()
                //     );
                //     $this->email_model->insertEmail($dataInsert);
                //     log_message('ecomed', 'addNew patient -  insertEmail');
                //     log_message('ecomed', json_encode($dataInsert));
                // }

                //end

                // $username = $name . " " . $last_name;
                // $this->phpMailer($email, $subject, $messageprint2,$username);



                $this->session->set_flashdata('feedback', lang('added'));
                // }
                //    }
            } else { // Updating Patient
                // $ion_user_id = $this->db->get_where('patient', array('patient_id' => $id))->row()->ion_user_id;


                $phone_sms = '';
                if (!empty($phone_recuperation)) {
                    $phone_sms = $phone_recuperation;
                } else {
                    $phone_sms = $phone;
                }


                $password = '';
                $this->patient_model->updateIonUser($username, $email, $password, $id, $this->id_organisation);
                $this->patient_model->updatePatient($id, $data, $this->id_organisation);
                log_message('ecomed', 'addNew patient -  updatePatient');
                log_message('ecomed', json_encode($data));
                // $autosms = $this->sms_model->getAutoSmsByType('patient');
                // if (isset($autosms)) {
                //     $message = $autosms->message;
                //     $to = $phone_sms;

                //     $data1 = array(
                //         'firstname' => $name,
                //         'lastname' => $last_name,
                //         'name' => $name,
                //         'doctor' => $doctor,
                //         'company' => ''
                //     );
                //     //   if (!empty($sms)) {
                //     // $this->sms->sendSmsDuringPatientRegistration($patient_user_id);

                //     $messageprint = $this->parser->parse_string($message, $data1);
                //     // Temp Special Chars / SMS
                //     $toReplace = array("é", "è", "à", "\r\n", "\r", "\n");
                //     $replaceBy   = array("e", "e", "a", "", "", "");
                //     $dataInsert = array(
                //         'recipient' => $phone,
                //         'message' => str_replace($toReplace, $replaceBy, $messageprint),
                //         'date' => time(),
                //         'user' => $this->ion_auth->get_user_id()
                //     );
                //     $this->sms_model->insertSms($dataInsert);
                //     log_message('ecomed', 'addNew patient -  insertSms');
                //     log_message('ecomed', json_encode($dataInsert));
                // }

                $autoemail = $this->email_model->getAutoEmailByType('modif_patient');
                if (isset($autoemail)) {
                    $emailSettings = $this->email_model->getEmailSettings();
                    $message1 = $autoemail->message;
                    $messageprint2 = $this->parser->parse_string($message1, $data1);
                    $dataInsert = array(
                        'reciepient' => $email,
                        'subject' => $autoemail->name,
                        'message' => $messageprint2,
                        'date' => time(),
                        'user' => $this->ion_auth->get_user_id()
                    );

                    // $this->email_model->insertEmail($dataInsert);
                }
                $this->session->set_flashdata('feedback', lang('updated'));
            }



            /*             * ***************parent assurrance******************************** */
            if (empty($id)) {
                $id = $last_patient_user_id;
            }
            $lien_parente = $this->input->post('lien_parente');
            $patient_id = $this->input->post('patient_id');

            $tab = array('lien_parente' => $lien_parente, 'parent_id' => $patient_id);

            $this->patient_model->updatePatient($id, $tab, $this->id_organisation);
            log_message('ecomed', 'addNew patient -  updatePatient');
            log_message('ecomed', json_encode($tab));
            if ($lien_parente) {
                redirect("patient/MedicalHistory?id=" . $patient_id . '&type=mutuellerelation');
            }
            /*             * **********************fin*****parent assurrance***************************************** */



            // Loading View
            if (!empty($redirect)) {
                if ($redirect == 'appointment/addNewView' || $redirect ==  'appointment') {
                    $redirect = $redirect . '?patient=' . $id;
                } else if ($redirect == 'finance/addPaymentView') {
                    $typetraitance = $this->input->post('typetraitance');
                    $partenaire = $this->input->post('partenairetraitance');
                    $redirect = $redirect . '?patient=' . $id . '&typetraitance=' . $typetraitance . '&partenairetraitance=' . $partenaire;
                } else if ($redirect == 'visite/ajout') {
                    $redirect = 'visite/ajout?patient=' . $id;
                }
                redirect($redirect);
            } else {
                redirect($urlModal);
            }
        }
    }


    function phpMailer($email, $subject, $body, $name)
    {
        // INTEGRATION PHPMAIL
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host       = 'email-smtp.us-east-1.amazonaws.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'AKIA3YNYOJUCSMPUHBXD';
            $mail->Password   = 'BGMcngyQBVCY31Ca9drB5lcmmSqGPVqxmPMsQNZ2AUI/';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('no-reply@ecomed24.com', 'ecoMed24');
            $mail->addAddress($email, $name);
            $mail->addAddress('abass.diagne@ecomed24.com');
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;


            $mail->send();
            echo 'Message est bien envoyé';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    function phpMailerAttachment($email, $subject, $body, $attachment, $name)
    {
        // INTEGRATION PHPMAIL
        $mail = new PHPMailer(true);


        try {
            //Server settings
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host       = 'email-smtp.us-east-1.amazonaws.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'AKIA3YNYOJUCSMPUHBXD';
            $mail->Password   = 'BGMcngyQBVCY31Ca9drB5lcmmSqGPVqxmPMsQNZ2AUI/';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('no-reply@ecomed24.com', 'ecoMed24');
            $mail->addAddress($email, $name);
            $mail->addAddress('abass.diagne@ecomed24.com');
            //  $mail->addReplyTo('abass.diagne@zuulu.net', 'Information');
            //  $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            $mail->addAttachment($attachment);    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            //    $mail->AltBody = 'Bienvenu a la plateforme ecomed24';

            $mail->send();
            echo 'Message est bien envoyé';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        // FIN INTEGRATION PHPMAIL
    }

    public function add_medications()
    {
        $doctor = $this->input->post('doctor');
        $current_medications = $this->input->post('current_medications');
        $patient_id = $this->input->post('patient_id');
        $redirect = $this->input->post('redirect');


        $data = array(
            'patient_id' => $patient_id,
            'doctor_id' => $doctor,
            'content' => $current_medications
        );

        $add = $this->patient_model->insertMedications($data);
        if ($add) {
            $this->session->set_flashdata('feedback', "Ajouté avec succès!");
            redirect($redirect);
        } else {
            $this->session->set_flashdata('feedback', lang('validation_error'));
            redirect($redirect);
        }
    }
    public function add_preconditions()
    {
        $doctor = $this->input->post('doctor');
        $preconditions = $this->input->post('preconditions');
        $patient_id = $this->input->post('patient_id');
        $redirect = $this->input->post('redirect');

        $data = array(
            'patient_id' => $patient_id,
            'doctor_id' => $doctor,
            'content' => $preconditions
        );

        $add = $this->patient_model->insertPresconditions($data);
        if ($add) {
            $this->session->set_flashdata('feedback', "Ajouté avec succès!");
            redirect($redirect);
        } else {
            $this->session->set_flashdata('feedback', lang('validation_error'));
            redirect($redirect);
        }
    }

    public function addNewJson()
    {
        $name = $_REQUEST['name'];
        $last_name = $_REQUEST['last_name'];

        $address = $_REQUEST['address'];
        $phone = $_REQUEST['phone'];
        $sex = $_REQUEST['sex'];
        $birthdate = $_REQUEST['birthdate'];
        $email = $_REQUEST['email'];
        $region = $_REQUEST['region'];

        $nom_mutuelle = $_REQUEST['nom_mutuelle'];
        $nom_mutuelle_text = $_REQUEST['nom_mutuelle_text'];
        $num_police = $_REQUEST['num_police'];
        $date_valid = $_REQUEST['date_valid'];
        $charge_mutuelle = $_REQUEST['charge_mutuelle'];


        $add_date = date('m/d/y');
        $registration_time = time();



        $data = array(
            'name' => $name, 'last_name' => $last_name, 'status' => 1, 'id_organisation' => $this->id_organisation,
            'email' => $email,
            'address' => $address,
            'phone' => $phone,
            'sex' => $sex,
            'birthdate' => $birthdate,
            'add_date' => $add_date,
            'registration_time' => $registration_time,
            'region' => $region
        );
        //var_dump($data);

        if ($name) {
            $last_patient_user_id = $this->patient_model->insertPatient($data);
            log_message('ecomed', 'addNew patient -  insertPatient');
            log_message('ecomed', json_encode($data));
            $count_patient = $this->db->get_where('patient', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
            // $patient_id = 'P-' . $this->code_organisation . '-' . str_pad($count_patient, 4, "0", STR_PAD_LEFT);
            $patient_id = $this->code_organisation . '' . $count_patient;
            $id_info = array('patient_id' => $patient_id);

            $this->patient_model->updatePatient($last_patient_user_id, $id_info, $this->id_organisation);
            log_message('ecomed', 'addNew patient -  updatePatient');
            log_message('ecomed', json_encode($id_info));
            $dataMut = array(
                'pm_idpatent' => $last_patient_user_id,
                'pm_idmutuelle' => $nom_mutuelle,
                'pm_numpolice' => $num_police,
                'pm_charge' => $charge_mutuelle,
                'pm_datevalid' => $date_valid, 'pm_status' => 1, 'id_organisation' => $this->id_organisation
            );
            $this->patient_model->insertMutuellePatient($dataMut);
            log_message('ecomed', 'addNew patient -  insertMutuellePatient');
            log_message('ecomed', json_encode($dataMut));
            echo json_encode(array(
                'result' => true, 'name' => $name . ' ' . $last_name, 'id' => $last_patient_user_id, 'patient_id' => $patient_id,
                'nom_mutuelle' => $nom_mutuelle_text, 'num_police' => $num_police,
                'date_valid' => $date_valid, 'charge_mutuelle' => $charge_mutuelle
            ));
        } else {
            echo json_encode(array('result' => false));
        }
    }

    function editPatient()
    {
        $data = array();
        $id = $this->input->get('id');
        $data['patient'] = $this->patient_model->getPatientById($id, $this->id_organisation);
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['groups'] = $this->donor_model->getBloodBank();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editPatientByJason()
    {
        $id = $this->input->get('id');
        $data['patient'] = $this->patient_model->getPatientById($id, $this->id_organisation);
        $data['doctor'] = $this->doctor_model->getDoctorById($data['patient']->doctor);
        echo json_encode($data);
    }


    function editOrganisationByJason()
    {
        $id = $this->input->get('id');
        $data['organisation'] = $this->patient_model->getOrganisation($id);
        echo json_encode($data);
    }

    function getPatientByJason()
    {
        $id = $this->input->get('id');
        $data['patient'] = $this->patient_model->getPatientById($id, $this->id_organisation);

        $doctor = $data['patient']->doctor;
        $data['doctor'] = $this->doctor_model->getDoctorById($doctor);



        echo json_encode($data);
    }

    function patientDetails()
    {
        $data = array();
        $id = $this->input->get('id');
        $data['patient'] = $this->patient_model->getPatientById($id, $this->id_organisation);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('details', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function report()
    {
        $data = array();
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['payment'] = $this->finance_model->getPaymentById($id, $this->id_organisation);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('diagnostic_report_details', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function addDiagnosticReport()
    {
        $id = $this->input->post('id');
        $invoice = $this->input->post('invoice');
        $patient = $this->input->post('patient');
        $report = $this->input->post('report');

        $date = time();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');


        // Validating Name Field
        $this->form_validation->set_rules('invoice', 'Invoice', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Password Field

        $this->form_validation->set_rules('report', 'Report', 'trim|min_length[1]|max_length[10000]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', lang('validation_error'));
            redirect('patient/report?id=' . $invoice);
        } else {

            //$error = array('error' => $this->upload->display_errors());
            $data = array();
            $data = array(
                'invoice' => $invoice,
                'date' => $date,
                'report' => $report
            );

            if (empty($id)) {     // Adding New department
                $this->patient_model->insertDiagnosticReport($data, $this->id_organisation);
                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating department
                $this->patient_model->updateDiagnosticReport($id, $data, $this->id_organisation);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect('patient/report?id=' . $invoice);
        }
    }

    function patientPayments()
    {
        $data['groups'] = $this->donor_model->getBloodBank();
        $data['settings'] = $this->settings_model->getSettings();

        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('patient_payments', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function patientPaymentsByFilter()
    {
        $data['groups'] = $this->donor_model->getBloodBank();
        $data['settings'] = $this->settings_model->getSettings();

        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('patient_payments_filter', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function caseList()
    {
        $data['settings'] = $this->settings_model->getSettings();
        $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
        $data['medical_histories'] = $this->patient_model->getMedicalHistory($this->id_organisation);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('case_list', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function documents()
    {
        $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
        $data['files'] = $this->patient_model->getPatientMaterial($this->id_organisation);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('documents', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function myCaseList()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $patient_id = $this->patient_model->getPatientByIonUserId($patient_ion_id, $this->id_organisation)->id;
            $data['medical_histories'] = $this->patient_model->getMedicalHistoryByPatientId($patient_id, $this->id_organisation);
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('my_case_list', $data);
            $this->load->view('home/footer'); // just the footer file
        }
    }

    function myDocuments()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $patient_id = $this->patient_model->getPatientByIonUserId($patient_ion_id, $this->id_organisation)->id;
            $data['files'] = $this->patient_model->getPatientMaterialByPatientId($patient_id, $this->id_organisation);
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('my_documents', $data);
            $this->load->view('home/footer'); // just the footer file
        }
    }

    function myPrescription()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $patient_id = $this->patient_model->getPatientByIonUserId($patient_ion_id, $this->id_organisation)->id;
            $data['doctors'] = $this->doctor_model->getDoctor();
            $data['prescriptions'] = $this->prescription_model->getPrescriptionByPatientId($patient_id);
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('my_prescription', $data);
            $this->load->view('home/footer'); // just the header file
        }
    }

    public function myPayment()
    {
        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $patient_id = $this->patient_model->getPatientByIonUserId($patient_ion_id, $this->id_organisation)->id;
            $data['settings'] = $this->settings_model->getSettings();
            $data['payments'] = $this->finance_model->getPaymentByPatientId($patient_id, $this->id_organisation);
            $this->load->view('home/dashboard'); // just the header file
            $this->load->view('my_payment', $data);
            $this->load->view('home/footer'); // just the header file
        }
    }
    function myPaymentHistory()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }


        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $patient = $this->patient_model->getPatientByIonUserId($patient_ion_id, $this->id_organisation)->id;
        }
        $data['settings'] = $this->settings_model->getSettings();
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 86399;
        }

        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;

        if (!empty($date_from)) {
            $data['payments'] = $this->finance_model->getPaymentByPatientIdByDate($patient, $date_from, $date_to, $this->id_organisation);
            $data['deposits'] = $this->finance_model->getDepositByPatientIdByDate($patient, $date_from, $date_to, $this->id_organisation);
            $data['gateway'] = $this->finance_model->getGatewayByName($data['settings']->payment_gateway, $this->id_organisation);
        } else {
            $data['payments'] = $this->finance_model->getPaymentByPatientId($patient, $this->id_organisation);
            $data['pharmacy_payments'] = $this->pharmacy_model->getPaymentByPatientId($patient, $this->id_organisation);
            $data['ot_payments'] = $this->finance_model->getOtPaymentByPatientId($patient, $this->id_organisation);
            $data['deposits'] = $this->finance_model->getDepositByPatientId($patient, $this->id_organisation);
            $data['gateway'] = $this->finance_model->getGatewayByName($data['settings']->payment_gateway, $this->id_organisation);
        }



        $data['patient'] = $this->patient_model->getPatientByid($patient, $this->id_organisation);
        $data['settings'] = $this->settings_model->getSettings();



        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('my_payments_history', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function deposit()
    {
        $id = $this->input->post('id');


        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $patient = $this->patient_model->getPatientByIonUserId($patient_ion_id, $this->id_organisation)->id;
        } else {
            $this->session->set_flashdata('feedback', lang('undefined_patient_id'));
            redirect('patient/myPaymentsHistory');
        }



        $payment_id = $this->input->post('payment_id');
        $date = time();

        $deposited_amount = $this->input->post('deposited_amount');

        $deposit_type = $this->input->post('deposit_type');

        if ($deposit_type != 'Card') {
            $this->session->set_flashdata('feedback', lang('undefined_payment_type'));
            redirect('patient/myPaymentsHistory');
        }

        $user = $this->ion_auth->get_user_id();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Patient Name Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Deposited Amount Field
        $this->form_validation->set_rules('deposited_amount', 'Deposited Amount', 'trim|min_length[1]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            redirect('patient/myPaymentsHistory');
        } else {
            $data = array();
            $data = array(
                'patient' => $patient,
                'date' => $date,
                'payment_id' => $payment_id,
                'deposited_amount' => $deposited_amount,
                'deposit_type' => $deposit_type,
                'user' => $user
            );
            if (empty($id)) {
                if ($deposit_type == 'Card') {
                    $payment_details = $this->finance_model->getPaymentById($payment_id, $this->id_organisation);
                    $gateway = $this->settings_model->getSettings()->payment_gateway;
                    if ($gateway == 'PayPal') {
                        $card_type = $this->input->post('card_type');
                        $card_number = $this->input->post('card_number');
                        $expire_date = $this->input->post('expire_date');
                        $cvv = $this->input->post('cvv_number');

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
                        $cvv = $this->input->post('cvv_number');
                        $token = $this->input->post('token');

                        $stripe = $this->db->get_where('paymentGateway', array('name =' => 'Stripe'))->row();
                        \Stripe\Stripe::setApiKey($stripe->secret);
                        $charge = \Stripe\Charge::create(array(
                            "amount" => $deposited_amount * 100,
                            "currency" => "usd",
                            "source" => $token
                        ));
                        $chargeJson = $charge->jsonSerialize();
                        redirect('patient/myPaymentHistory');
                    } elseif ($gateway == 'Pay U Money') {
                        redirect("payu/check?deposited_amount=" . "$deposited_amount" . '&payment_id=' . $payment_id);
                    } else {
                        $this->session->set_flashdata('feedback', lang('payment_failed_no_gateway_selected'));
                        redirect('patient/myPaymentHistory');
                    }
                } else {
                    $this->finance_model->insertDeposit($data);
                    $this->session->set_flashdata('feedback', lang('added'));
                }
            } else {
                $this->finance_model->updateDeposit($id, $data);

                $amount_received_id = $this->finance_model->getDepositById($id, $this->id_organisation)->amount_received_id;
                if (!empty($amount_received_id)) {
                    $amount_received_payment_id = explode('.', $amount_received_id);
                    $payment_id = $amount_received_payment_id[0];
                    $data_amount_received = array('amount_received' => $deposited_amount);
                    $this->finance_model->updatePayment($amount_received_payment_id[0], $data_amount_received);
                }

                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('patient/myPaymentHistory');
        }
    }

    function myInvoice()
    {
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['discount_type'] = $this->finance_model->getDiscountType();
        $data['payment'] = $this->finance_model->getPaymentById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('myInvoice', $data);
        $this->load->view('home/footer'); // just the footer fi
    }



    function addMedicalHistory()
    {
        $id = $this->input->post('id');
        $patient_id = $this->input->post('patient_id');


        $date = $this->input->post('date');
        $date_string = $this->input->post('date_string');
        $title = $this->input->post('title');
        $payment_id = $this->input->post('payment_id');
        $code = $this->input->post('code');
        $specialite = $this->input->post('specialite');
        $maladie = $this->input->post('maladie');
        $namePrestation = $this->input->post('namePrestation');
        $poids = $this->input->post('poids');
        $taille = $this->input->post('taille');
        $temperature = $this->input->post('temperature');
        $frequenceRespiratoire = $this->input->post('frequenceRespiratoire');
        $frequenceCardiaque = $this->input->post('frequenceCardiaque');
        $glycemyCapillaire = $this->input->post('glycemyCapillaire');
        $Saturationarterielle = $this->input->post('Saturationarterielle');
        $hypertensionSystolique = $this->input->post('hypertensionSystolique');
        $hypertensionDiastolique = $this->input->post('hypertensionDiastolique');
        $systolique = $this->input->post('systolique');
        $diastolique = $this->input->post('diastolique');
        $sucre = $this->input->post('sucre');
        $albumine = $this->input->post('albumine');
        $oeildroit = $this->input->post('oeildroit');
        $oeilgauche = $this->input->post('oeilgauche');
        $oreilledroite = $this->input->post('oreilledroite');
        $oreillegauche = $this->input->post('oreillegauche');
        $tensionArterielle = $this->input->post('tensionArterielle');
        $template = $this->input->post('template');
        $glycemyCapillaireUnite = $this->input->post('glycemyCapillaireUnite');
        $specialite_name = '';
        $count_patient_payment = $this->db->get_where('payment', array('patient =' => $patient_id))->num_rows() + 1;
        $count_patient = $this->db->get_where('medical_history', array('patient_id =' => $patient_id))->num_rows() + 1;

        if ($count_patient_payment > $count_patient) {
            $this->patient_model->updatePatientNumberPassage($patient_id,  array('number_passage' => $count_patient_payment), $this->id_organisation);
        } else {
            $this->patient_model->updatePatientNumberPassage($patient_id,  array('number_passage' => $count_patient), $this->id_organisation);
        }

        if (!empty($specialite)) {
            $specialite = $this->lab_model->getTemplateById($specialite);
            $specialite_name = $specialite->name;
        }

        if (!empty($oeildroit)) {
            $oeildroit = $oeildroit . ' / 10';
        }
        if (!empty($oeilgauche)) {
            $oeilgauche = $oeilgauche . ' / 10';
        }
        if (!empty($oreilledroite)) {
            $oreilledroite = $oreilledroite . ' / 10';
        }
        if (!empty($oreillegauche)) {
            $oreillegauche = $oreillegauche . ' / 10';
        }


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

        if (empty($Saturationarterielle)) {
            $Saturationarterielle = 'Non renseigné';
        }
        if (empty($systolique)) {
            $systolique = 'Non renseigné';
        }
        if (empty($diastolique)) {
            $diastolique = 'Non renseigné';
        }
        if (empty($tensionArterielle)) {
            $tensionArterielle = 'Non renseigné';
        }
        if (empty($oeildroit)) {
            $oeildroit = 'Non renseigné';
        }
        if (empty($oeilgauche)) {
            $oeilgauche = 'Non renseigné';
        }
        if (empty($oreilledroite)) {
            $oreilledroite = 'Non renseigné';
        }
        if (empty($oreillegauche)) {
            $oreillegauche = 'Non renseigné';
        }






        if (!empty($glycemyCapillaire)) {
            $glycemyCapillaire = $glycemyCapillaire . ' ' . $glycemyCapillaireUnite;
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
                'specialite' => $specialite_name,
                'namePrestation' => $namePrestation,
                'poids' => $poids,
                'taille' => $taille,
                'temperature' => $temperature,
                'frequenceRespiratoire' => $frequenceRespiratoire,
                'frequenceCardiaque' => $frequenceCardiaque,
                'glycemyCapillaire' => $glycemyCapillaire,
                'Saturationarterielle' => $Saturationarterielle,
                'hypertensionSystolique' => $hypertensionSystolique,
                'hypertensionDiastolique' => $hypertensionDiastolique,
                'systolique' => $systolique,
                'diastolique' => $diastolique,
                'sucre' => $sucre,
                'albumine' => $albumine,
                'oeildroit' => $oeildroit,
                'oeilgauche' => $oeilgauche,
                'oreilledroite' => $oreilledroite,
                'oreillegauche' => $oreillegauche,
                'tensionArterielle' => $tensionArterielle,
                'illness_id' => $maladie,
                'template_id' => $template,
            );

            if (empty($id)) {     // Adding New department

                $this->patient_model->insertMedicalHistory($data, $this->id_organisation);
                $inserted_id = $this->db->insert_id();
                $dataillnessConsultation = array(
                    'patient_id' => $patient_id,
                    'illness_id' => $maladie,
                    'medical_history_id' => $inserted_id,
                    'user_id' => $this->ion_auth->get_user_id(),
                    'createdDate' => $date,
                );
                $output = $this->patient_model->insertIllnessConsultation($dataillnessConsultation);
                $this->session->set_flashdata('feedback', lang('added'));
            } else { // Updating department
                $this->patient_model->updateMedicalHistory($id, $data, $this->id_organisation);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            // Loading View
            redirect($redirect);
        }
    }


    function addMedicalHistoryConsultation()
    {
        $requestData = $_REQUEST;
        $id = $requestData["id"];
        $data['id'] = $id;
        $data['specialite'] = $requestData["specialite"];
        $data['poids'] = $requestData["poids"];


        // Loading View
        redirect("patient/medicalHistory?id=" . $id . "&type=consultation");
        echo json_encode($data);
    }



    public function diagnosticReport()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if ($this->ion_auth->in_group(array('Patient'))) {
            $current_user = $this->ion_auth->get_user_id();
            $patient_user_id = $this->patient_model->getPatientByIonUserId($current_user, $this->id_organisation)->id;
            $data['payments'] = $this->finance_model->getPaymentByPatientId($patient_user_id);
        } else {
            $data['payments'] = $this->finance_model->getPayment();
        }

        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('diagnostic_report', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function medicalHistory()
    {
        $data = array();
        $id = $this->input->get('id');
        $dossier = $this->input->get('dossier');
        // if ($this->ion_auth->in_group(array('Patient'))) {
        //     $patient_ion_id = $this->ion_auth->get_user_id();
        //     $id = $this->patient_model->getPatientByIonUserId($patient_ion_id, $this->id_organisation)->id;
        // }
        $data['settings'] = $this->settings_model->getSettings();
        //   $data['payments'] = $this->finance_model->getPaymentByPatientId($id, $this->id_organisation);
        $data['templates'] = $this->lab_model->getTemplateMultiConsultation();
        $data['maladies'] = $this->home_model->getMaladie();
        // $data['current_medications'] = $this->db->query("select * from current_medications where patient_id = ".$id)->result_array();
        // $data['pre_conditions'] = $this->db->query("select * from pre_conditions where patient_id = ".$id)->result_array();

        $data['deposits'] = $this->finance_model->getDepositByPatientId($id);
        $data['patient'] = $this->patient_model->getPatientById($id, $this->id_organisation);
        $data['payments'] = $this->finance_model->getPaymentByPatientId($id, $data['patient']->id_organisation);

        $data['appointments'] = $this->appointment_model->getAppointmentByPatient($data['patient']->id, $data['patient']->id_organisation, $this->id_serviceUser);
        $data['patients'] = $this->patient_model->getPatient($data['patient']->id_organisation);
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['vitalSigns'] = $this->patient_model->getVitalSign($id);
        $data['prescriptions'] = $this->prescription_model->getPrescriptionByPatientId($id);
        $data['labs'] = $this->lab_model->getLabByPatientAnalyseId($id);
        $data['labsAnalyse'] = $this->lab_model->getLabByIdAnalyse($id);
        $data['hospitalisations'] = $this->patient_model->getPatientHospitalisation($id);
        $data['vaccinations'] = $this->patient_model->getVaccination($id);
        $data['visiteConsultations'] = $this->patient_model->getMedicalHistoryPatient($id);
        $data['labsImages'] = $this->lab_model->getLabByPatientImagerieId($id);
        $data['labsOrdonnance'] = $this->lab_model->getLabByPatientOrdonnanceId($id);
        $data['current_medications'] = $this->db->query("select * from current_medications where patient_id = " . $id)->result_array();
        $data['pre_conditions'] = $this->db->query("select * from pre_conditions where patient_id = " . $id)->result_array();
        //$data['labsAna'] = $this->lab_model->getLabByPatientAnalyseId($id, $this->id_organisation);
        $data['beds'] = $this->bed_model->getBedAllotmentsByPatientId($id);
        $data['medical_histories'] = $this->patient_model->getMedicalHistoryByPatientId($id, $data['patient']->id_organisation);
        $data['patient_materials'] = $this->patient_model->getPatientMaterialByPatientId($id, $data['patient']->id_organisation);
        $data['payments'] = $this->finance_model->getPaymentByPatientId($id, $data['patient']->id_organisation);
        $data['groups'] = $this->donor_model->getBloodBank();
        $data['regions'] = array('Dakar', 'Ziguinchor', 'Diourbel', 'Saint-Louis', 'Tambacounda', 'Kaolack', 'Thiès', 'Louga', 'Fatick', 'Kolda', 'Matam', 'Kaffrine', 'Kédougou', 'Sédhiou');
        $data['religions'] = array('Musulmane', 'Chetienne', 'Autres');
        $data['mutuelles'] = $this->patient_model->getMutuelle($data['patient']->id, $data['patient']->id_organisation);
        $data['mutuelles_relation'] = $this->patient_model->getPatientByIdParent($id, $data['patient']->id_organisation);
        $data['mutuellesInit'] = array();
        $data['lien_parente'] = '';
        $data['mutuelles_relationInit'] = array();
        if ($data['patient']->parent_id) {
            $data['mutuellesInit'] = $this->patient_model->getMutuelle($data['patient']->parent_id, $data['patient']->id_organisation);
            $data['mutuelles_relationInit'] = $this->patient_model->getPatientById($data['patient']->parent_id, $data['patient']->id_organisation);
            $lien_parente = "Autres";
            if ($data['patient']->lien_parente == "Pere") {
                $lien_parente = "Enfant";
            } else if ($data['patient']->lien_parente == "Mere") {
                $lien_parente = "Enfant";
            } else if ($data['patient']->lien_parente == "Enfant") {
                $lien_parente = "Pere/Mere";
            }
            $data['lien_parente'] = $lien_parente;
        }
        foreach ($data['appointments'] as $appointment) {
            $doctor_details = $this->doctor_model->getDoctorById($appointment->doctor);
            if (!empty($doctor_details)) {
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = '';
            }
            $timeline[$appointment->date + 1] = '<div class="panel-body profile-activity" >
                <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('appointment') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $appointment->date) . '</h5>
                                            <div class="activity terques">
                                                <span>
                                                    <i class="fa fa-stethoscope"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $appointment->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $doctor_name . '</h4>
                                                                    <p></p>
                                                                    <i class=" fa fa-clock-o"></i>
                                                                <p>' . $appointment->s_time . ' - ' . $appointment->e_time . '</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['prescriptions'] as $prescription) {
            $doctor_details = $this->doctor_model->getDoctorById($prescription->doctor);
            if (!empty($doctor_details)) {
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = '';
            }
            $timeline[$prescription->date + 2] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('prescription') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $prescription->date) . '</h5>
                                            <div class="activity purple">
                                                <span>
                                                    <i class="fa fa-medkit"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $prescription->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $doctor_name . '</h4>
                                                                    <a class="btn btn-info btn-xs detailsbutton" title="View" href="prescription/viewPrescription?id=' . $prescription->id . '"><i class="fa fa-eye"> View</i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['labs'] as $lab) {

            $doctor_details = $this->doctor_model->getDoctorById($lab->doctor);
            if (!empty($doctor_details)) {
                $lab_doctor = $doctor_details->name;
            } else {
                $lab_doctor = '';
            }

            $timeline[$lab->date + 3] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('lab') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $lab->date) . '</h5>
                                            <div class="activity blue">
                                                <span>
                                                    <i class="fa fa-flask"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $lab->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-user-md"></i>
                                                                <h4>' . $lab_doctor . '</h4>
                                                                  <!--  <a class="btn btn-xs invoicebutton" title="Lab" style="color: #fff;" href="lab/invoice?id=' . $lab->id . '"><i class="fa fa-file-text"></i>' . lang('report') . '</a>
                                                       --> </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['medical_histories'] as $medical_history) {
            $timeline[$medical_history->date + 4] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('case_history') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $medical_history->date) . '</h5>
                                            <div class="activity greenn">
                                                <span>
                                                    <i class="fa fa-file"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $medical_history->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-note"></i> 
                                                                <p>' . $medical_history->description . '</p>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['patient_materials'] as $patient_material) {
            $timeline[$patient_material->date + 5] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('documents') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $patient_material->date) . '</h5>
                                            <div class="activity purplee">
                                                <span>
                                                    <i class="fa fa-file-o"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $patient_material->date) . ' <a class="pull-right" title="' . lang('download') . '"  href="' . $patient_material->url . '" download=""> <i class=" fa fa-download"></i> </a> </h4>
                                                                
                                                                 <h4>' . $patient_material->title . '</h4>
                                                            
                                                                
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        if (!empty($timeline)) {
            $data['timeline'] = $timeline;
        }

        $data['id_organisation'] = $data['patient']->id_organisation;
        if (empty($dossier)) {
            $data['path_logo'] = $this->path_logo;
            $data['nom_organisation'] = $this->nom_organisation;
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('medical_history', $data);
            $this->load->view('home/footer'); // just the footer file
        } else {
            $this->load->view('home/appointmentcenterdashboard', $data); // just the header file
            $this->load->view('medical_history', $data);
            $this->load->view('footer', $data);
        }
    }

    function medicalHistory2()
    {
        $data = array();
        $id = $this->input->get('id');

        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $id = $this->patient_model->getPatientByIonUserId($patient_ion_id, $this->id_organisation)->id;
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['payments'] = $this->finance_model->getPaymentByPatientId($id, $this->id_organisation);
        // $data['current_medications'] = $this->db->query("select * from current_medications where patient_id = ".$id)->result_array();
        // $data['pre_conditions'] = $this->db->query("select * from pre_conditions where patient_id = ".$id)->result_array();

        $data['deposits'] = $this->finance_model->getDepositByPatientId($id);

        $data['patient'] = $this->patient_model->getPatientById($id, $this->id_organisation);
        $data['appointments'] = $this->appointment_model->getAppointmentByPatient($data['patient']->id, $this->id_organisation, $this->id_serviceUser);
        $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['prescriptions'] = $this->prescription_model->getPrescriptionByPatientId($id);
        $data['labs'] = $this->lab_model->getLabByPatientId($id);
        $data['beds'] = $this->bed_model->getBedAllotmentsByPatientId($id);
        $data['medical_histories'] = $this->patient_model->getMedicalHistoryByPatientId($id, $this->id_organisation);
        $data['patient_materials'] = $this->patient_model->getPatientMaterialByPatientId($id, $this->id_organisation);
        $data['groups'] = $this->donor_model->getBloodBank();
        $data['regions'] = array('Dakar', 'Ziguinchor', 'Diourbel', 'Saint-Louis', 'Tambacounda', 'Kaolack', 'Thiès', 'Louga', 'Fatick', 'Kolda', 'Matam', 'Kaffrine', 'Kédougou', 'Sédhiou');
        $data['religions'] = array('Musulmane', 'Chetienne', 'Autres');
        $data['mutuelles'] = $this->patient_model->getMutuelle($data['patient']->id, $this->id_organisation);
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
                $lien_parente = "Pere/Mere";
            }
            $data['lien_parente'] = $lien_parente;
        }
        foreach ($data['appointments'] as $appointment) {
            $doctor_details = $this->doctor_model->getDoctorById($appointment->doctor);
            if (!empty($doctor_details)) {
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = '';
            }
            $timeline[$appointment->date + 1] = '<div class="panel-body profile-activity" >
                <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('appointment') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $appointment->date) . '</h5>
                                            <div class="activity terques">
                                                <span>
                                                    <i class="fa fa-stethoscope"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $appointment->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $doctor_name . '</h4>
                                                                    <p></p>
                                                                    <i class=" fa fa-clock-o"></i>
                                                                <p>' . $appointment->s_time . ' - ' . $appointment->e_time . '</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['prescriptions'] as $prescription) {
            $doctor_details = $this->doctor_model->getDoctorById($prescription->doctor);
            if (!empty($doctor_details)) {
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = '';
            }
            $timeline[$prescription->date + 2] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('prescription') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $prescription->date) . '</h5>
                                            <div class="activity purple">
                                                <span>
                                                    <i class="fa fa-medkit"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $prescription->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $doctor_name . '</h4>
                                                                    <a class="btn btn-info btn-xs detailsbutton" title="View" href="prescription/viewPrescription?id=' . $prescription->id . '"><i class="fa fa-eye"> View</i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['labs'] as $lab) {

            $doctor_details = $this->doctor_model->getDoctorById($lab->doctor);
            if (!empty($doctor_details)) {
                $lab_doctor = $doctor_details->name;
            } else {
                $lab_doctor = '';
            }

            $timeline[$lab->date + 3] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('lab') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $lab->date) . '</h5>
                                            <div class="activity blue">
                                                <span>
                                                    <i class="fa fa-flask"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $lab->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-user-md"></i>
                                                                <h4>' . $lab_doctor . '</h4>
                                                                  <!--  <a class="btn btn-xs invoicebutton" title="Lab" style="color: #fff;" href="lab/invoice?id=' . $lab->id . '"><i class="fa fa-file-text"></i>' . lang('report') . '</a>
                                                       --> </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['medical_histories'] as $medical_history) {
            $timeline[$medical_history->date + 4] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('case_history') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $medical_history->date) . '</h5>
                                            <div class="activity greenn">
                                                <span>
                                                    <i class="fa fa-file"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $medical_history->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-note"></i> 
                                                                <p>' . $medical_history->description . '</p>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['patient_materials'] as $patient_material) {
            $timeline[$patient_material->date + 5] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('documents') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $patient_material->date) . '</h5>
                                            <div class="activity purplee">
                                                <span>
                                                    <i class="fa fa-file-o"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $patient_material->date) . ' <a class="pull-right" title="' . lang('download') . '"  href="' . $patient_material->url . '" download=""> <i class=" fa fa-download"></i> </a> </h4>
                                                                
                                                                 <h4>' . $patient_material->title . '</h4>
                                                            
                                                                
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        if (!empty($timeline)) {
            $data['timeline'] = $timeline;
        }

        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medical_history_new_in_progress', $data);
        $this->load->view('home/footer'); // just the footer file
    }
    function medicalHistoryJson()
    {
        $data = array();
        $id = $this->input->get('id');

        if ($this->ion_auth->in_group(array('Patient'))) {
            $patient_ion_id = $this->ion_auth->get_user_id();
            $id = $this->patient_model->getPatientByIonUserId($patient_ion_id, $this->id_organisation)->id;
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['payments'] = $this->finance_model->getPaymentByPatientId($id, $this->id_organisation);

        $data['deposits'] = $this->finance_model->getDepositByPatientId($id);
        $data['payments'] = $this->finance_model->getPaymentByPatientId($id, $this->id_organisation);
        $data['patient'] = $this->patient_model->getPatientById($id, $this->id_organisation);
        $data['appointments'] = $this->appointment_model->getAppointmentByPatient($data['patient']->id, $this->id_organisation);
        $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['prescriptions'] = $this->prescription_model->getPrescriptionByPatientId($id);
        $data['labs'] = $this->lab_model->getLabByPatientId($id);
        $data['beds'] = $this->bed_model->getBedAllotmentsByPatientId($id);
        $data['medical_histories'] = $this->patient_model->getMedicalHistoryByPatientId($id, $this->id_organisation);
        $data['patient_materials'] = $this->patient_model->getPatientMaterialByPatientId($id, $this->id_organisation);
        $data['groups'] = $this->donor_model->getBloodBank();
        $data['regions'] = array('Dakar', 'Ziguinchor', 'Diourbel', 'Saint-Louis', 'Tambacounda', 'Kaolack', 'Thiès', 'Louga', 'Fatick', 'Kolda', 'Matam', 'Kaffrine', 'Kédougou', 'Sédhiou');
        $data['religions'] = array('Musulmane', 'Chetienne', 'Autres');
        $data['mutuelles'] = $this->patient_model->getMutuelle($data['patient']->id, $this->id_organisation);
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
                $lien_parente = "Pere/Mere";
            }
            $data['lien_parente'] = $lien_parente;
        }
        foreach ($data['appointments'] as $appointment) {
            $doctor_details = $this->doctor_model->getDoctorById($appointment->doctor);
            if (!empty($doctor_details)) {
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = '';
            }
            $timeline[$appointment->date + 1] = '<div class="panel-body profile-activity" >
                <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('appointment') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $appointment->date) . '</h5>
                                            <div class="activity terques">
                                                <span>
                                                    <i class="fa fa-stethoscope"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $appointment->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $doctor_name . '</h4>
                                                                    <p></p>
                                                                    <i class=" fa fa-clock-o"></i>
                                                                <p>' . $appointment->s_time . ' - ' . $appointment->e_time . '</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['prescriptions'] as $prescription) {
            $doctor_details = $this->doctor_model->getDoctorById($prescription->doctor);
            if (!empty($doctor_details)) {
                $doctor_name = $doctor_details->name;
            } else {
                $doctor_name = '';
            }
            $timeline[$prescription->date + 2] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('prescription') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $prescription->date) . '</h5>
                                            <div class="activity purple">
                                                <span>
                                                    <i class="fa fa-medkit"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $prescription->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $doctor_name . '</h4>
                                                                    <a class="btn btn-info btn-xs detailsbutton" title="View" href="prescription/viewPrescription?id=' . $prescription->id . '"><i class="fa fa-eye"> View</i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['labs'] as $lab) {

            $doctor_details = $this->doctor_model->getDoctorById($lab->doctor);
            if (!empty($doctor_details)) {
                $lab_doctor = $doctor_details->name;
            } else {
                $lab_doctor = '';
            }

            $timeline[$lab->date + 3] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('lab') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $lab->date) . '</h5>
                                            <div class="activity blue">
                                                <span>
                                                    <i class="fa fa-flask"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $lab->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-user-md"></i>
                                                                <h4>' . $lab_doctor . '</h4>
                                                                    <a class="btn btn-xs invoicebutton" title="Lab" style="color: #fff;" href="lab/invoice?id=' . $lab->id . '"><i class="fa fa-file-text"></i>' . lang('report') . '</a>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['medical_histories'] as $medical_history) {
            $timeline[$medical_history->date + 4] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('case_history') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $medical_history->date) . '</h5>
                                            <div class="activity greenn">
                                                <span>
                                                    <i class="fa fa-file"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $medical_history->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-note"></i> 
                                                                <p>' . $medical_history->description . '</p>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($data['patient_materials'] as $patient_material) {
            $timeline[$patient_material->date + 5] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('documents') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $patient_material->date) . '</h5>
                                            <div class="activity purplee">
                                                <span>
                                                    <i class="fa fa-file-o"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $patient_material->date) . ' <a class="pull-right" title="' . lang('download') . '"  href="' . $patient_material->url . '" download=""> <i class=" fa fa-download"></i> </a> </h4>
                                                                
                                                                 <h4>' . $patient_material->title . '</h4>
                                                            
                                                                
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        if (!empty($timeline)) {
            $data['timeline'] = $timeline;
        }

        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        echo json_encode($timeline);
    }
    function editMedicalHistoryByJason()
    {
        $id = $this->input->get('id');
        $data['medical_history'] = $this->patient_model->getMedicalHistoryById($id, $this->id_organisation);
        $data['patient'] = $this->patient_model->getPatientById($data['medical_history']->patient_id, $this->id_organisation);
        echo json_encode($data);
    }

    function getCaseDetailsByJason()
    {
        $id = $this->input->get('id');
        $data['case'] = $this->patient_model->getMedicalHistoryById($id, $this->id_organisation);
        $patient = $data['case']->patient_id;
        $data['patient'] = $this->patient_model->getPatientById($patient, $this->id_organisation);
        echo json_encode($data);
    }

    function getPatientByAppointmentByDctorId($doctor_id)
    {
        $data = array();
        $appointments = $this->appointment_model->getAppointmentByDoctor($doctor_id, $this->id_organisation);
        foreach ($appointments as $appointment) {
            $patient_exists = $this->patient_model->getPatientById($appointment->patient, $this->id_organisation);
            if (!empty($patient_exists)) {
                $patients[] = $appointment->patient;
            }
        }

        if (!empty($patients)) {
            $patients = array_unique($patients);
        } else {
            $patients = '';
        }

        return $patients;
    }

    function patientMaterial()
    {
        $data = array();
        $id = $this->input->get('patient');
        $data['settings'] = $this->settings_model->getSettings();
        $data['patient'] = $this->patient_model->getPatientById($id, $this->id_organisation);
        $data['patient_materials'] = $this->patient_model->getPatientMaterialByPatientId($id, $this->id_organisation);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('patient_material', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function addPatientMaterial()
    {
        $title = $this->input->post('title');
        $patient_id = $this->input->post('patient');
        $img_url = $this->input->post('img_url');
        $date = time();
        $redirect = $this->input->post('redirect');

        if ($this->ion_auth->in_group(array('Patient'))) {
            if (empty($patient_id)) {
                $current_patient = $this->ion_auth->get_user_id();
                $patient_id = $this->patient_model->getPatientByIonUserId($current_patient, $this->id_organisation)->id;
            }
        }


        if (empty($redirect)) {
            //  $redirect = "patient/medicalHistory?id=" . $patient_id;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', lang('validation_error'));
            redirect($redirect);
        } else {

            if (!empty($patient_id)) {
                $patient_details = $this->patient_model->getPatientById($patient_id, $this->id_organisation);
                $patient_name = $patient_details->name;
                $patient_phone = $patient_details->phone;
                $patient_address = $patient_details->address;
            } else {
                $patient_name = 0;
                $patient_phone = 0;
                $patient_address = 0;
            }






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
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => False,
                'max_size' => "48000000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "3000",
                'max_width' => "2024"
            );

            $this->load->library('Upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('img_url')) {
                $path = $this->upload->data();
                $img_url = "uploads/" . $path['file_name'];
                $data = array();
                $data = array(
                    'date' => $date,
                    'title' => $title,
                    'url' => $img_url,
                    'patient' => $patient_id,
                    'patient_name' => $patient_name,
                    'patient_address' => $patient_address,
                    'patient_phone' => $patient_phone,
                    'date_string' => date('d-m-y', $date), 'id_organisation' => $this->id_organisation,
                );
            } else {
                $data = array();
                $data = array(
                    'date' => $date,
                    'title' => $title,
                    'patient' => $patient_id,
                    'patient_name' => $patient_name,
                    'patient_address' => $patient_address,
                    'patient_phone' => $patient_phone, 'id_organisation' => $this->id_organisation,
                    'date_string' => date('d-m-y', $date),
                );
                $this->session->set_flashdata('feedback', lang('upload_error'));
            }

            $this->patient_model->insertPatientMaterial($data);
            $this->session->set_flashdata('feedback', lang('added'));


            redirect($redirect);
        }
    }

    function deleteCaseHistory()
    {
        $id = $this->input->get('id');
        $redirect = $this->input->get('redirect');
        $case_history = $this->patient_model->getMedicalHistoryById($id, $this->id_organisation);
        $this->patient_model->deleteMedicalHistory($id, $this->id_organisation);
        $this->session->set_flashdata('feedback', lang('deleted'));
        if ($redirect == 'case') {
            redirect('patient/caseList');
        } else {
            redirect("patient/MedicalHistory?id=" . $case_history->patient_id);
        }
    }


    function addPatientMaterialLabo()
    {
        $nomLabo = $this->input->post('nomLabo');
        $prescripteur = $this->input->post('prescripteur');
        $patient_id = $this->input->post('patient');
        $img_url = $this->input->post('img_url');
        $date = time();
        $redirect = $this->input->post('redirect');

        if ($this->ion_auth->in_group(array('Patient'))) {
            if (empty($patient_id)) {
                $current_patient = $this->ion_auth->get_user_id();
                $patient_id = $this->patient_model->getPatientByIonUserId($current_patient, $this->id_organisation)->id;
            }
        }


        if (empty($redirect)) {
            //  $redirect = "patient/medicalHistory?id=" . $patient_id;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', lang('validation_error'));
            redirect($redirect);
        } else {

            if (!empty($patient_id)) {
                $patient_details = $this->patient_model->getPatientById($patient_id, $this->id_organisation);
                $patient_name = $patient_details->name;
                $patient_phone = $patient_details->phone;
                $patient_address = $patient_details->address;
            } else {
                $patient_name = 0;
                $patient_phone = 0;
                $patient_address = 0;
            }






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
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => False,
                'max_size' => "48000000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "3000",
                'max_width' => "2024"
            );

            $this->load->library('Upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('img_url')) {
                $path = $this->upload->data();
                $img_url = "uploads/" . $path['file_name'];
                $data = array();
                $data = array(
                    'date' => $date,
                    'nomLabo' => $nomLabo,
                    'prescripteur' => $prescripteur,
                    'importLabo' => "1",
                    'report' => "Importation laboratoire d'analyse",
                    'url' => $img_url,
                    'patient' => $patient_id,
                    'patient_name' => $patient_name,
                    'patient_address' => $patient_address,
                    'patient_phone' => $patient_phone,
                    'date_string' => date('d-m-y', $date), 'id_organisation' => $this->id_organisation,
                );
            } else {
                $this->session->set_flashdata('feedback', 'Erreur de validation ! (Format du fichier incorrect');
                redirect($redirect);
            }

            $this->patient_model->insertPatientMaterialLabo($data);
            $this->session->set_flashdata('feedback', lang('added'));


            redirect($redirect);
        }
    }


    function addPatientMaterialAll()
    {
        $nomLabo = $this->input->post('nomLabo');
        $prescripteur = $this->input->post('prescripteur');
        $patient_id = $this->input->post('patient');
        $img_url = $this->input->post('img_url');
        $type = $this->input->post('type');
        $date = time();
        $redirect = $this->input->post('redirect');

        if ($this->ion_auth->in_group(array('Patient'))) {
            if (empty($patient_id)) {
                $current_patient = $this->ion_auth->get_user_id();
                $patient_id = $this->patient_model->getPatientByIonUserId($current_patient, $this->id_organisation)->id;
            }
        }


        if (empty($redirect)) {
            //  $redirect = "patient/medicalHistory?id=" . $patient_id;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', lang('validation_error'));
            redirect($redirect);
        } else {

            if (!empty($patient_id)) {
                $patient_details = $this->patient_model->getPatientById($patient_id, $this->id_organisation);
                $patient_name = $patient_details->name;
                $patient_phone = $patient_details->phone;
                $patient_address = $patient_details->address;
            } else {
                $patient_name = 0;
                $patient_phone = 0;
                $patient_address = 0;
            }






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
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => False,
                'max_size' => "48000000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "3000",
                'max_width' => "2024"
            );

            $this->load->library('Upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('img_url')) {
                $path = $this->upload->data();
                $img_url = "uploads/" . $path['file_name'];
                $data = array();
                $data = array(
                    'date' => $date,
                    'title' => $nomLabo,
                    'url' => $img_url,
                    'patient' => $patient_id,
                    'category' => $type,
                    'patient_name' => $patient_name,
                    'patient_address' => $patient_address,
                    'patient_phone' => $patient_phone,
                    'date_string' => date('d-m-y', $date), 'id_organisation' => $this->id_organisation,
                );
            } else {
                $this->session->set_flashdata('feedback', 'Erreur de validation ! (Format du fichier incorrect');
                redirect($redirect);
            }

            // var_dump($data);
            // exit();
            $this->patient_model->insertPatientMaterial($data);
            $this->session->set_flashdata('feedback', lang('added'));


            redirect($redirect);
        }
    }



    function addVisiteConsultation()
    {
        $nomLabo = $this->input->post('nomLabo');
        $type = $this->input->post('type');
        $prescripteur = $this->input->post('prescripteur');
        $patient_id = $this->input->post('patient');
        $add_date = $this->input->post('add_date');
        $img_url = $this->input->post('img_url');
        $date = time();
        $redirect = $this->input->post('redirect');

        if ($this->ion_auth->in_group(array('Patient'))) {
            if (empty($patient_id)) {
                $current_patient = $this->ion_auth->get_user_id();
                $patient_id = $this->patient_model->getPatientByIonUserId($current_patient, $this->id_organisation)->id;
            }
        }


        if (empty($redirect)) {
            //  $redirect = "patient/medicalHistory?id=" . $patient_id;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', lang('validation_error'));
            redirect($redirect);
        } else {

            if (!empty($patient_id)) {
                $patient_details = $this->patient_model->getPatientById($patient_id, $this->id_organisation);
                $patient_name = $patient_details->name;
                $patient_phone = $patient_details->phone;
                $patient_address = $patient_details->address;
            } else {
                $patient_name = 0;
                $patient_phone = 0;
                $patient_address = 0;
            }






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
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => False,
                'max_size' => "48000000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "3000",
                'max_width' => "2024"
            );

            $this->load->library('Upload', $config);
            $this->upload->initialize($config);

            // var_dump($this->upload->do_upload('img_url'));
            // exit();
            if ($this->upload->do_upload('img_url')) {
                $path = $this->upload->data();
                $img_url = "uploads/" . $path['file_name'];
                $data = array();
                $data = array(
                    'date' => $date,
                    'nomLabo' => $nomLabo,
                    'prescripteur' => $prescripteur,
                    'type' => $type,
                    'add_date' => $add_date,
                    'patient' => $patient_id,
                    'url' => $img_url,
                    'patient_name' => $patient_name,
                    'patient_address' => $patient_address,
                    'patient_phone' => $patient_phone,
                    'date_string' => date('d-m-y', $date), 'id_organisation' => $this->id_organisation,
                );
            } else {
                $this->session->set_flashdata('feedback', 'Erreur de validation ! (Format du fichier incorrect');
                redirect($redirect);
                // $data = array();
                // $data = array(
                //     'date' => $date,
                //     'nomLabo' => $nomLabo,
                //     'prescripteur' => $prescripteur,
                //     'importLabo' => "3",
                //     'report' => "Importation une ordonnance médicalisé",
                //     'url' => $img_url,
                //     'patient' => $patient_id,
                //     'patient_name' => $patient_name,
                //     'patient_address' => $patient_address,
                //     'patient_phone' => $patient_phone,
                //     'date_string' => date('d-m-y', $date), 'id_organisation' => $this->id_organisation,
                // );
                // $this->session->set_flashdata('feedback', lang('upload_error'));
            }

            $this->patient_model->insertConsultationVisite($data);
            $this->session->set_flashdata('feedback', lang('added'));


            redirect($redirect);
        }
    }


    function addPatientVaccination()
    {
        $nomLabo = $this->input->post('nomLabo');
        $nature = $this->input->post('nature');
        $patient_id = $this->input->post('patient');
        $lot = $this->input->post('lot');
        $dossier = $this->input->post('dossier');
        $date = time();
        $add_date = $this->input->post('add_date');
        $redirect = $this->input->post('redirect');

        if ($this->ion_auth->in_group(array('Patient'))) {
            if (empty($patient_id)) {
                $current_patient = $this->ion_auth->get_user_id();
                $patient_id = $this->patient_model->getPatientByIonUserId($current_patient, $this->id_organisation)->id;
            }
        }


        if (empty($redirect)) {
            //  $redirect = "patient/medicalHistory?id=" . $patient_id;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', lang('validation_error'));
            redirect($redirect);
        } else {

            if (!empty($patient_id)) {
                $patient_details = $this->patient_model->getPatientById($patient_id, $this->id_organisation);
                $patient_name = $patient_details->name;
                $patient_phone = $patient_details->phone;
                $patient_address = $patient_details->address;
            } else {
                $patient_name = 0;
                $patient_phone = 0;
                $patient_address = 0;
            }







            $data = array();
            $data = array(
                'date' => $date,
                'nomLabo' => $nomLabo,
                'add_date' => $add_date,
                'prescripteur' => $this->ion_auth->get_user_id(),
                'dossier' => $dossier,
                'lot' => $lot,
                'nature' => $nature,
                'patient' => $patient_id,
                'patient_name' => $patient_name,
                'patient_address' => $patient_address,
                'patient_phone' => $patient_phone,
                'date_string' => date('d-m-y', $date),
                'id_organisation' => $this->id_organisation,
            );

            $this->patient_model->insertPatientVaccination($data);
            $this->session->set_flashdata('feedback', lang('added'));


            redirect($redirect);
        }
    }

    function addPatientMaterialOrdonnance()
    {
        $nomLabo = "une ordonnance";
        $prescripteur = $this->input->post('prescripteur');
        $patient_id = $this->input->post('patient');
        $img_url = $this->input->post('img_url');
        $date = time();
        $redirect = $this->input->post('redirect');

        if ($this->ion_auth->in_group(array('Patient'))) {
            if (empty($patient_id)) {
                $current_patient = $this->ion_auth->get_user_id();
                $patient_id = $this->patient_model->getPatientByIonUserId($current_patient, $this->id_organisation)->id;
            }
        }


        if (empty($redirect)) {
            //  $redirect = "patient/medicalHistory?id=" . $patient_id;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', lang('validation_error'));
            redirect($redirect);
        } else {

            if (!empty($patient_id)) {
                $patient_details = $this->patient_model->getPatientById($patient_id, $this->id_organisation);
                $patient_name = $patient_details->name;
                $patient_phone = $patient_details->phone;
                $patient_address = $patient_details->address;
            } else {
                $patient_name = 0;
                $patient_phone = 0;
                $patient_address = 0;
            }






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
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => False,
                'max_size' => "48000000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "3000",
                'max_width' => "2024"
            );

            $this->load->library('Upload', $config);
            $this->upload->initialize($config);

            // var_dump($this->upload->do_upload('img_url'));
            // exit();
            if ($this->upload->do_upload('img_url')) {
                $path = $this->upload->data();
                $img_url = "uploads/" . $path['file_name'];
                $data = array();
                $data = array(
                    'date' => $date,
                    'nomLabo' => $nomLabo,
                    'prescripteur' => $prescripteur,
                    'importLabo' => "3",
                    'report' => "Importation une ordonnance médicalisé",
                    'url' => $img_url,
                    'patient' => $patient_id,
                    'patient_name' => $patient_name,
                    'patient_address' => $patient_address,
                    'patient_phone' => $patient_phone,
                    'date_string' => date('d-m-y', $date), 'id_organisation' => $this->id_organisation,
                );
            } else {
                $this->session->set_flashdata('feedback', 'Erreur de validation ! (Format du fichier incorrect');
                redirect($redirect);
                // $data = array();
                // $data = array(
                //     'date' => $date,
                //     'nomLabo' => $nomLabo,
                //     'prescripteur' => $prescripteur,
                //     'importLabo' => "3",
                //     'report' => "Importation une ordonnance médicalisé",
                //     'url' => $img_url,
                //     'patient' => $patient_id,
                //     'patient_name' => $patient_name,
                //     'patient_address' => $patient_address,
                //     'patient_phone' => $patient_phone,
                //     'date_string' => date('d-m-y', $date), 'id_organisation' => $this->id_organisation,
                // );
                // $this->session->set_flashdata('feedback', lang('upload_error'));
            }

            $this->patient_model->insertPatientMaterialLabo($data);
            $this->session->set_flashdata('feedback', lang('added'));


            redirect($redirect);
        }
    }

    function addPatientHospitalisation()
    {
        $lieu = $this->input->post('lieu');
        $motif = $this->input->post('motif');
        $add_date = $this->input->post('add_date');
        $patient_id = $this->input->post('patient');
        $img_url = $this->input->post('img_url');
        $date = time();
        $redirect = $this->input->post('redirect');

        if ($this->ion_auth->in_group(array('Patient'))) {
            if (empty($patient_id)) {
                $current_patient = $this->ion_auth->get_user_id();
                $patient_id = $this->patient_model->getPatientByIonUserId($current_patient, $this->id_organisation)->id;
            }
        }


        if (empty($redirect)) {
            //  $redirect = "patient/medicalHistory?id=" . $patient_id;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', lang('validation_error'));
            redirect($redirect);
        } else {

            if (!empty($patient_id)) {
                $patient_details = $this->patient_model->getPatientById($patient_id, $this->id_organisation);
                $patient_name = $patient_details->name;
                $patient_phone = $patient_details->phone;
                $patient_address = $patient_details->address;
            } else {
                $patient_name = 0;
                $patient_phone = 0;
                $patient_address = 0;
            }






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
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => False,
                'max_size' => "48000000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "3000",
                'max_width' => "2024"
            );

            $this->load->library('Upload', $config);
            $this->upload->initialize($config);

            // var_dump($this->upload->do_upload('img_url'));
            // exit();
            if ($this->upload->do_upload('img_url')) {
                $path = $this->upload->data();
                $img_url = "uploads/" . $path['file_name'];
                $data = array();
                $data = array(
                    'date' => $date,
                    'lieu' => $lieu,
                    'motif' => $motif,
                    'add_date' => $add_date,
                    'url' => $img_url,
                    'prescripteur' => $this->ion_auth->get_user_id(),
                    'patient' => $patient_id,
                    'patient_name' => $patient_name,
                    'patient_address' => $patient_address,
                    'patient_phone' => $patient_phone,
                    'date_string' => date('d-m-y', $date), 'id_organisation' => $this->id_organisation,
                );
            } else {
                $this->session->set_flashdata('feedback', 'Erreur de validation ! (Format du fichier incorrect');
                redirect($redirect);
                // $data = array();
                // $data = array(
                //     'date' => $date,
                //     'nomLabo' => $nomLabo,
                //     'prescripteur' => $prescripteur,
                //     'importLabo' => "3",
                //     'report' => "Importation une ordonnance médicalisé",
                //     'url' => $img_url,
                //     'patient' => $patient_id,
                //     'patient_name' => $patient_name,
                //     'patient_address' => $patient_address,
                //     'patient_phone' => $patient_phone,
                //     'date_string' => date('d-m-y', $date), 'id_organisation' => $this->id_organisation,
                // );
                // $this->session->set_flashdata('feedback', lang('upload_error'));
            }

            $this->patient_model->insertPatientHospitalisation($data);
            $this->session->set_flashdata('feedback', lang('added'));


            redirect($redirect);
        }
    }


    function addVitalSign()
    {
        $frequenceRespiratoire = $this->input->post('frequenceRespiratoire');
        $frequenceCardiaque = $this->input->post('frequenceCardiaque');
        $saturationArterielle = $this->input->post('saturationArterielle');
        $temperature = $this->input->post('temperature');
        $systolique = $this->input->post('systolique');
        $diastolique = $this->input->post('diastolique');
        $tensionArterielle = $this->input->post('tensionArterielle');
        $patient_id = $this->input->post('patient');
        $date = time();
        $redirect = $this->input->post('redirect');

        if ($this->ion_auth->in_group(array('Patient'))) {
            if (empty($patient_id)) {
                $current_patient = $this->ion_auth->get_user_id();
                $patient_id = $this->patient_model->getPatientByIonUserId($current_patient, $this->id_organisation)->id;
            }
        }


        if (empty($redirect)) {
            //  $redirect = "patient/medicalHistory?id=" . $patient_id;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', lang('validation_error'));
            redirect($redirect);
        } else {

            if (!empty($patient_id)) {
                $patient_details = $this->patient_model->getPatientById($patient_id, $this->id_organisation);
                $patient_name = $patient_details->name;
                $patient_phone = $patient_details->phone;
                $patient_address = $patient_details->address;
            } else {
                $patient_name = 0;
                $patient_phone = 0;
                $patient_address = 0;
            }
            $data = array();
            $data = array(
                'date' => $date,
                'frequenceRespiratoire' => $frequenceRespiratoire,
                'frequenceCardiaque' => $frequenceCardiaque,
                'saturationArterielle' => $saturationArterielle,
                'temperature' => $temperature,
                'systolique' => $systolique,
                'diastolique' => $diastolique,
                'tensionArterielle' => $tensionArterielle,
                'patient' => $patient_id,
                'patient_name' => $patient_name,
                'patient_address' => $patient_address,
                'patient_phone' => $patient_phone,
                'prescripteur' => $this->ion_auth->get_user_id(),
                'date_string' => date('d-m-y', $date),
                'id_organisation' => $this->id_organisation,
            );

            $this->patient_model->insertVitalSign($data);
            $this->session->set_flashdata('feedback', lang('added'));


            redirect($redirect);
        }
    }

    function addPatientMaterialImage()
    {
        $nomLabo = $this->input->post('nomLabo');
        $prescripteur = $this->input->post('prescripteur');
        $patient_id = $this->input->post('patient');
        $img_url = $this->input->post('img_url');
        $date = time();
        $redirect = $this->input->post('redirect');

        if ($this->ion_auth->in_group(array('Patient'))) {
            if (empty($patient_id)) {
                $current_patient = $this->ion_auth->get_user_id();
                $patient_id = $this->patient_model->getPatientByIonUserId($current_patient, $this->id_organisation)->id;
            }
        }


        if (empty($redirect)) {
            //  $redirect = "patient/medicalHistory?id=" . $patient_id;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', lang('validation_error'));
            redirect($redirect);
        } else {

            if (!empty($patient_id)) {
                $patient_details = $this->patient_model->getPatientById($patient_id, $this->id_organisation);
                $patient_name = $patient_details->name;
                $patient_phone = $patient_details->phone;
                $patient_address = $patient_details->address;
            } else {
                $patient_name = 0;
                $patient_phone = 0;
                $patient_address = 0;
            }






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
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => False,
                'max_size' => "48000000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "3000",
                'max_width' => "2024"
            );

            $this->load->library('Upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('img_url')) {
                $path = $this->upload->data();
                $img_url = "uploads/" . $path['file_name'];
                $data = array();
                $data = array(
                    'date' => $date,
                    'nomLabo' => $nomLabo,
                    'prescripteur' => $prescripteur,
                    'importLabo' => "2",
                    'report' => "Importation d'imagerie médicale",
                    'url' => $img_url,
                    'patient' => $patient_id,
                    'patient_name' => $patient_name,
                    'patient_address' => $patient_address,
                    'patient_phone' => $patient_phone,
                    'date_string' => date('d-m-y', $date), 'id_organisation' => $this->id_organisation,
                );
            } else {
                $this->session->set_flashdata('feedback', 'Erreur de validation ! (Format du fichier incorrect');
                redirect($redirect);
            }

            $this->patient_model->insertPatientMaterialLabo($data);
            $this->session->set_flashdata('feedback', lang('added'));


            redirect($redirect);
        }
    }

    function deletePatientMaterial()
    {
        $id = $this->input->get('id');
        $redirect = $this->input->get('redirect');
        $patient_material = $this->patient_model->getPatientMaterialById($id, $this->id_organisation);
        $path = $patient_material->url;
        if (!empty($path)) {
            unlink($path);
        }
        $this->patient_model->deletePatientMaterial($id, $this->id_organisation);
        $this->session->set_flashdata('feedback', lang('deleted'));
        /*  if ($redirect == 'documents') {
            redirect('patient/documents');
        } else {
            redirect("patient/MedicalHistory?id=" . $patient_material->patient);
        }*/
        redirect("patient/MedicalHistory?id=" . $patient_material->patient . '&type=documents');
    }

    function delete()
    {
        $data = array();
        $id = $this->input->get('id');
        $user_data = $this->db->get_where('patient', array('id' => $id))->row();
        $path = $user_data->img_url;

        if (!empty($path)) {
            unlink($path);
        }
        $ion_user_id = $user_data->ion_user_id;
        $this->db->where('id', $ion_user_id);
        $this->db->delete('users');
        $this->patient_model->delete($id, $this->id_organisation);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('patient');
    }

    function getPatient()
    {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        //
        //          if ($limit == -1) {
        //          if (!empty($search)) {
        //          $data['patients'] = $this->patient_model->getPatientBysearch($search,$this->id_organisation);
        //          } else {
        //          $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
        //          }
        //          } else {
        //          if (!empty($search)) {
        //          $data['patients'] = $this->patient_model->getPatientByLimitBySearch($limit, $start, $search,$this->id_organisation);
        //          } else {
        //          $data['patients'] = $this->patient_model->getPatientByLimit($limit, $start,$this->id_organisation);
        //          }
        //          } */

        if ($limit == -1) {
            if (!empty($search)) {
                $data['patients'] = $this->patient_model->getPatientBysearch($search, $this->id_organisation);
            } else {
                $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
            }
        } else {
            if (!empty($search)) {
                $data['patients'] = $this->patient_model->getPatientByLimitBySearch($limit, $start, $search, $this->id_organisation);
            } else {
                $data['patients'] = $this->patient_model->getPatientByLimit($limit, $start, $this->id_organisation);
            }
        }
        $info = array();
        //$data['patients'] = $this->patient_model->getPatient($this->id_organisation);

        foreach ($data['patients'] as $patient) {

            //if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Laboratorist', 'Nurse', 'Doctor'))) {
            //   $options1 = '<a type="button" class="btn editbutton" title="Edit" data-toggle="modal" data-id="463"><i class="fa fa-edit"> </i> Edit</a>';
            $options1 = ' <a type="button" class="btn editbutton" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $patient->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
            //  }

            $options2 = '<a class="btn detailsbutton" title="' . lang('info') . '" style="color: #fff;" href="patient/patientDetails?id=' . $patient->id . '"><i class="fa fa-info"></i> ' . lang('info') . '</a>';

            $options3 = '<a class="btn green" title="' . lang('history') . '" style="color: #fff;" href="patient/medicalHistory?id=' . $patient->id . '"><i class="fa fa-stethoscope"></i> ' . lang('dossier') . '</a>';

            $options4 = '<a class="btn invoicebutton" title="' . lang('payment') . '" style="color: #fff;" href="finance/patientPaymentHistory?patient=' . $patient->id . '"><i class="fa fa-money-bill-alt"></i> ' . lang('payment') . '</a>';

            if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Accountant', 'Receptionist', 'Laboratorist', 'Nurse', 'Doctor', 'adminmedecin'))) {
                $options5 = ''; //<a class="btn delete_button" title="' . lang('delete') . '" href="patient/delete?id=' . $patient->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i> ' . lang('delete') . '</a>';
            }

            $options6 = ' <a type="button" class="btn detailsbutton inffo" title="' . lang('info') . '" data-toggle = "modal" data-id="' . $patient->id . '"><i class="fa fa-info"> </i> ' . lang('info') . '</a>';



            if ($this->ion_auth->in_group(array('Doctor', 'adminmedecin'))) {
                $options7 = '<a class="btn green detailsbutton" title="' . lang('instant_meeting') . '" style="color: #fff;" href="meeting/instantLive?id=' . $patient->id . '" onclick="return confirm(\'Are you sure you want to start a live meeting with this patient? SMS and Email will be sent to the Patient.\');"><i class="fa fa-headphones"></i> ' . lang('start_live') . '</a>';
            } else {
                $options7 = '';
            }

            $codePatient = '';
            if (!empty($patient->estCivil == 'non')) {
                $codePatient = $patient->patient_id . '' . $patient->matricule;
            } else {
                $codePatient = $patient->patient_id;
            }

            $phone_patient = '';

            if (!empty($patient->phone_recuperation)) {
                $phone_patient = $patient->phone_recuperation;
            } else {
                $phone_patient = $patient->phone;
            }


            $options5 = '';
            if ($this->ion_auth->in_group(array('admin', 'Receptionist', 'adminmedecin', 'Assistant'))) {
                $info[] = array(
                    $codePatient,
                    $patient->name . ' ' . $patient->last_name,
                    $phone_patient,
                    number_format($this->patient_model->getDueBalanceByPatientId($patient->id, $this->id_organisation), 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency,
                    $options1 . ' ' . $options6 . ' ' . $options3 . ' ' . $options4 . ' ' . $options5,
                    //  $options2
                );
            }

            if ($this->ion_auth->in_group(array('Accountant'))) {
                $info[] = array(
                    $patient->patient_id,
                    $patient->name . ' ' . $patient->last_name,
                    $phone_patient,
                    number_format($this->patient_model->getDueBalanceByPatientId($patient->id, $this->id_organisation), 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency,
                    $options6 . ' ' . $options4,
                    //  $options2
                );
            }
            if ($this->ion_auth->in_group(array('Doctor'))) {
                $info[] = array(
                    $patient->patient_id,
                    $patient->name . ' ' . $patient->last_name,
                    $phone_patient,
                    $options1 . ' ' . $options6 . ' ' . $options3,
                    //  $options2
                );
            }
            if ($this->ion_auth->in_group(array('Laboratorist', 'Nurse'))) {
                $info[] = array(
                    $patient->patient_id,
                    $patient->name . ' ' . $patient->last_name,
                    $phone_patient,
                    $options6 . ' ' . $options3,
                    //  $options2
                );
            }
        }


        if (!empty($data['patients']) && trim($search)) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get_where('patient', array('id_organisation' => $this->id_organisation))->num_rows(), //$this->db->get('patient')->num_rows(),
                "recordsFiltered" => count($this->patient_model->getPatientBysearch($search, $this->id_organisation)), //$this->db->get('patient')->num_rows(),
                "data" => $info
            );
        } else if (!empty($data['patients'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get_where('patient', array('id_organisation' => $this->id_organisation))->num_rows(), //$this->db->get('patient')->num_rows(),
                "recordsFiltered" => $this->db->get_where('patient', array('id_organisation' => $this->id_organisation))->num_rows(), //$this->db->get('patient')->num_rows(),
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


    function getPatientJson()
    {

        $id = $this->input->get('id');
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_patient'] = $id;

        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('patientJson', $data);
        $this->load->view('home/footer'); // just the header file

    }
    function getPatientPayments()
    {
        $requestData = $_REQUEST;

        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        if ($limit == -1) {
            if (!empty($search)) {
                $data['patients'] = $this->patient_model->getPatientBysearch($search, $this->id_organisation);
            } else {
                $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
            }
        } else {
            if (!empty($search)) {
                $data['patients'] = $this->patient_model->getPatientByLimitBySearch($limit, $start, $search, $this->id_organisation);
            } else {
                $data['patients'] = $this->patient_model->getPatientByLimit($limit, $start, $this->id_organisation);
            }
        }

        // $start = $requestData['start'];
        // $limit = $requestData['length'];
        // $search = $this->input->post('search')['value'];
        /*  if ($limit == -1) {
          if (!empty($search)) {
          $data['patients'] = $this->patient_model->getPatientBysearch($search);
          } else {
          $data['patients'] = $this->patient_model->getPatient();
          }
          } else {
          if (!empty($search)) {
          $data['patients'] = $this->patient_model->getPatientByLimitBySearch($limit, $start, $search);
          } else {
          $data['patients'] = $this->patient_model->getPatientByLimit($limit, $start);
          }
          } */

        //$data['patients'] = $this->patient_model->getPatient($this->id_organisation);

        foreach ($data['patients'] as $patient) {

            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Assistant', 'Laboratorist', 'Nurse', 'Doctor', 'adminmedecin'))) {
                //   $options1 = '<a type="button" class="btn editbutton" title="Edit" data-toggle="modal" data-id="463"><i class="fa fa-edit"> </i> Edit</a>';
                $options1 = ' <a type="button" class="btn editbutton" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $patient->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
            }

            $options2 = '<a class="btn detailsbutton" title="' . lang('info') . '" style="color: #fff;" href="patient/patientDetails?id=' . $patient->id . '"><i class="fa fa-info"></i> ' . lang('info') . '</a>';

            $options3 = '<a class="btn green" title="' . lang('history') . '" style="color: #fff;" href="patient/medicalHistory?id=' . $patient->id . '"><i class="fa fa-stethoscope"></i> ' . lang('history') . '</a>';

            $options4 = '<a class="btn btn-xs green" title="' . lang('payment') . ' ' . lang('history') . '" style="color: #fff;" href="finance/patientPaymentHistory?patient=' . $patient->id . '"><i class="fa fa-money-bill-alt"></i> ' . lang('payment_history') . '</a>';

            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Assistant', 'Laboratorist', 'Nurse', 'Doctor', 'adminmedecin'))) {
                $options5 = '<a class="btn delete_button" title="' . lang('delete') . '" href="patient/delete?id=' . $patient->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i> ' . lang('delete') . '</a>';
            }

            $due = number_format($this->patient_model->getDueBalanceByPatientId($patient->id, $this->id_organisation), 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency;

            $info[] = array(
                $patient->patient_id,
                $patient->name . ' ' . $patient->last_name,
                $patient->phone,
                $due,
                //  $options1 . ' ' . $options2 . ' ' . $options3 . ' ' . $options4 . ' ' . $options5,
                $options4
            );
        }

        if (!empty($data['patients']) && trim($search)) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get_where('patient', array('id_organisation' => $this->id_organisation))->num_rows(), //$this->db->get('patient')->num_rows(),
                "recordsFiltered" => count($this->patient_model->getPatientBysearch($search, $this->id_organisation)), //$this->db->get('patient')->num_rows(),
                "data" => $info
            );
        } else if (!empty($data['patients'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get_where('patient', array('id_organisation' => $this->id_organisation))->num_rows(), //$this->db->get('patient')->num_rows(),
                "recordsFiltered" => $this->db->get_where('patient', array('id_organisation' => $this->id_organisation))->num_rows(), //$this->db->get('patient')->num_rows(),
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

    function getPatientPaymentsByFilter()
    {

        $data['patients'] = $this->patient_model->getPatient($this->id_organisation);

        foreach ($data['patients'] as $patient) {

            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Assistant', 'Laboratorist', 'Nurse', 'Doctor', 'adminmedecin'))) {
                //   $options1 = '<a type="button" class="btn editbutton" title="Edit" data-toggle="modal" data-id="463"><i class="fa fa-edit"> </i> Edit</a>';
                $options1 = ' <a type="button" class="btn editbutton" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $patient->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
            }

            $options2 = '<a class="btn detailsbutton" title="' . lang('info') . '" style="color: #fff;" href="patient/patientDetails?id=' . $patient->id . '"><i class="fa fa-info"></i> ' . lang('info') . '</a>';

            $options3 = '<a class="btn green" title="' . lang('history') . '" style="color: #fff;" href="patient/medicalHistory?id=' . $patient->id . '"><i class="fa fa-stethoscope"></i> ' . lang('history') . '</a>';

            $options4 = '<a class="btn btn-xs green" title="' . lang('payment') . ' ' . lang('history') . '" style="color: #fff;" href="finance/patientPaymentHistory?patient=' . $patient->id . '"><i class="fa fa-money-bill-alt"></i> ' . lang('payment_history') . '</a>';

            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Assistant', 'Laboratorist', 'Nurse', 'Doctor', 'adminmedecin'))) {
                $options5 = '<a class="btn delete_button" title="' . lang('delete') . '" href="patient/delete?id=' . $patient->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i> ' . lang('delete') . '</a>';
            }

            $val = $this->patient_model->getDueBalanceByPatientId($patient->id, $this->id_organisation);
            if ($val > 0) {
                $due = number_format($val, 0, ",", ".") . ' ' . $this->settings_model->getSettings()->currency;

                $info[] = array(
                    $patient->patient_id,
                    $patient->name . ' ' . $patient->last_name,
                    $patient->phone,
                    $due,
                    //  $options1 . ' ' . $options2 . ' ' . $options3 . ' ' . $options4 . ' ' . $options5,
                    $options4
                );
            }
        }

        if (!empty($data['patients'])) {
            $output = array(
                "draw" => 0, //intval($requestData['draw']),
                "recordsTotal" => $this->db->get_where('patient', array('id_organisation' => $this->id_organisation))->num_rows(), //$this->db->get('patient')->num_rows(),
                "recordsFiltered" => count($data['patients']), //$this->db->get('patient')->num_rows(),
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

    function getCaseList()
    {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->patient_model->getMedicalHistoryBySearch($search, $this->id_organisation);
            } else {
                $data['cases'] = $this->patient_model->getMedicalHistory($this->id_organisation);
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->patient_model->getMedicalHistoryByLimitBySearch($limit, $start, $search, $this->id_organisation);
            } else {
                $data['cases'] = $this->patient_model->getMedicalHistoryByLimit($limit, $start, $this->id_organisation);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();

        foreach ($data['cases'] as $case) {

            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Assistant', 'Laboratorist', 'Nurse', 'Doctor', 'adminmedecin'))) {
                //   $options1 = '<a type="button" class="btn editbutton" title="Edit" data-toggle="modal" data-id="463"><i class="fa fa-edit"> </i> Edit</a>';
                $options1 = ' <a type="button" class="btn btn-info btn-xs btn_width editbutton" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $case->id . '"><i class="fa fa-edit"> </i> </a>';
            }
            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Assistant', 'Laboratorist', 'Nurse', 'Doctor', 'adminmedecin'))) {
                $options2 = '<a class="btn btn-info btn-xs btn_width delete_button" title="' . lang('delete') . '" href="patient/deleteCaseHistory?id=' . $case->id . '&redirect=case" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i></a>';
                $options3 = ' <a type="button" class="btn btn-info btn-xs btn_width detailsbutton case" title="' . lang('case') . '" data-toggle = "modal" data-id="' . $case->id . '"><i class="fa fa-file"> </i> </a>';
            }

            if (!empty($case->patient_id)) {
                $patient_info = $this->patient_model->getPatientById($case->patient_id, $this->id_organisation);
                if (!empty($patient_info)) {
                    $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                } else {
                    $patient_details = $case->patient_name . '</br>' . $case->patient_address . '</br>' . $case->patient_phone . '</br>';
                }
            } else {
                $patient_details = '';
            }

            $info[] = array(
                date('d/m/Y', $case->date),
                $patient_details,
                $case->title,
                $options3 . ' ' . $options1 . ' ' . $options2
                // $options4
            );
        }

        if (!empty($data['cases'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('medical_history')->num_rows(),
                "recordsFiltered" => $this->db->get('medical_history')->num_rows(),
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

    function getDocuments()
    {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['documents'] = $this->patient_model->getDocumentBySearch($search, $this->id_organisation);
            } else {
                $data['documents'] = $this->patient_model->getPatientMaterial($this->id_organisation);
            }
        } else {
            if (!empty($search)) {
                $data['documents'] = $this->patient_model->getDocumentByLimitBySearch($limit, $start, $search, $this->id_organisation);
            } else {
                $data['documents'] = $this->patient_model->getDocumentByLimit($limit, $start, $this->id_organisation);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();

        foreach ($data['documents'] as $document) {

            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Assistant', 'Laboratorist', 'Nurse', 'Doctor', 'adminmedecin'))) {
                //   $options1 = '<a type="button" class="btn editbutton" title="Edit" data-toggle="modal" data-id="463"><i class="fa fa-edit"> </i> Edit</a>';
                $options1 = '<a class="btn btn-info btn-xs" href="' . $document->url . '" download> ' . lang('download') . ' </a>';
            }
            if ($this->ion_auth->in_group(array('admin', 'Accountant', 'Receptionist', 'Assistant', 'Laboratorist', 'Nurse', 'Doctor', 'adminmedecin'))) {
                $options2 = '<a class="btn btn-info btn-xs delete_button" href="patient/deletePatientMaterial?id=' . $document->id . '&redirect=documents"onclick="return confirm(\'You want to delete the item??\');"> X </a>';
            }

            if (!empty($document->patient)) {
                $patient_info = $this->patient_model->getPatientById($document->patient, $this->id_organisation);
                if (!empty($patient_info)) {
                    $patient_details = $patient_info->name . '</br>' . $patient_info->address . '</br>' . $patient_info->phone . '</br>';
                } else {
                    $patient_details = $document->patient_name . '</br>' . $document->patient_address . '</br>' . $document->patient_phone . '</br>';
                }
            } else {
                $patient_details = '';
            }

            $info[] = array(
                date('d/m/Y', $document->date),
                $patient_details,
                $document->title,
                '<a class="example-image-link" href="' . $document->url . '" data-lightbox="example-1" data-title="' . $document->title . '">' . '<img class="example-image" src="' . $document->url . '" width="100px" height="100px"alt="image-1">' . '</a>',
                $options1 . ' ' . $options2
                // $options4
            );
        }

        if (!empty($data['documents'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('patient_material')->num_rows(),
                "recordsFiltered" => $this->db->get('patient_material')->num_rows(),
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

    function getMedicalHistoryByJason()
    {
        $data = array();

        $from_where = $this->input->get('from_where');
        $id = $this->input->get('id');



        /*  if ($this->ion_auth->in_group(array('Patient'))) {
          $patient_ion_id = $this->ion_auth->get_user_id();
          $id = $this->patient_model->getPatientByIonUserId($patient_ion_id, $this->id_organisation)->id;
          } */

        $patient = $this->patient_model->getPatientById($id, $this->id_organisation);

        $appointments = $this->appointment_model->getAppointmentByPatient($patient->id, $this->id_organisation);

        $patients = $this->patient_model->getPatient($this->id_organisation);
        $doctors = $this->doctor_model->getDoctor();
        // $data['prescriptions'] = $this->prescription_model->getPrescriptionByPatientId($id, $this->id_organisation);
        //$beds = $this->bed_model->getBedAllotmentsByPatientId($id);
        //  $orders = $this->order_model->getOrderByPatientId($id);
        $labs = $this->lab_model->getLabByPatientId($id, $this->id_organisation);

        $medical_histories = $this->patient_model->getMedicalHistoryByPatientId($id, $this->id_organisation);
        $patient_materials = $this->patient_model->getPatientMaterialByPatientId($id, $this->id_organisation);
        var_dump($patient_materials);

        $payments = $this->finance_model->getPaymentByPatientId($patient->id);
        $mutuelles = $this->patient_model->getMutuelle($patient->id, $this->id_organisation);

        foreach ($appointments as $appointment) {

            $doctor_details = $this->service_model->getServiceById($appointment->service);
            if (!empty($doctor_details)) {
                $doctor_name = $doctor_details->name_service;
            } else {
                $doctor_name = '';
            }

            $timeline[$appointment->date + 1] = '<div class="panel-body profile-activity" >
                <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('appointment') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $appointment->date) . '</h5>
                                            <div class="activity terques">
                                                <span>
                                                    <i class="fa fa-stethoscope"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $appointment->date) . '</h4>
                                                            <p></p>
                                                            <i class=" fa fa-user-md"></i>
                                                                <h4>' . $doctor_name . '</h4>
                                                                    <p></p>
                                                                    <i class=" fa fa-clock-o"></i>
                                                                <p>' . $appointment->s_time . ' - ' . $appointment->e_time . '</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
        }

        /*
          foreach ($data['prescriptions'] as $prescription) {
          $doctor_details = $this->doctor_model->getDoctorById($prescription->doctor);
          if (!empty($doctor_details)) {
          $doctor_name = $doctor_details->name;
          } else {
          $doctor_name = '';
          }
          $timeline[$prescription->date + 6] = '<div class="panel-body profile-activity" >
          <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('prescription') . '</span></h5>
          <h5 class="pull-right">' . date('d/m/Y', $prescription->date) . '</h5>
          <div class="activity purple">
          <span>
          <i class="fa fa-medkit"></i>
          </span>
          <div class="activity-desk">
          <div class="panel col-md-6">
          <div class="panel-body">
          <div class="arrow"></div>
          <i class=" fa fa-calendar"></i>
          <h4>' . date('d/m/Y', $prescription->date) . '</h4>
          <p></p>
          <i class=" fa fa-user-md"></i>
          <h4>' . $doctor_name . '</h4>
          <a class="btn btn-info btn-xs detailsbutton" title="View" href="prescription/viewPrescription?id=' . $prescription->id . '"><i class="fa fa-eye"> View</i></a>
          </div>
          </div>
          </div>
          </div>
          </div>';
          }
         */
        foreach ($labs as $lab) {

            $doctor_details = $this->doctor_model->getDoctorById($lab->doctor);
            if (!empty($doctor_details)) {
                $lab_doctor = $doctor_details->name;
            } else {
                $lab_doctor = '';
            }

            $timeline[$lab->date + 3] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('lab') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $lab->date) . '</h5>
                                            <div class="activity blue">
                                                <span>
                                                    <i class="fa fa-flask"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $lab->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-user-md"></i>
                                                                <h4>' . $lab_doctor . '</h4>
                                                                    <a class="btn btn-xs invoicebutton" title="Lab" style="color: #fff;" href="lab/invoice?id=' . $lab->id . '"><i class="fa fa-file-text"></i>' . lang('report') . '</a>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }


        foreach ($medical_histories as $medical_history) {
            $timeline[$medical_history->date + 4] = '<div class="panel-body profile-activity" >
                                            <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('case_history') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $medical_history->date) . '</h5>
                                            <div class="activity greenn">
                                                <span>
                                                    <i class="fa fa-file"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $medical_history->date) . '</h4>
                                                            <p></p>
                                                             <i class=" fa fa-note"></i> 
                                                                <p>' . $medical_history->description . '</p>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }

        foreach ($patient_materials as $patient_material) {
            $timeline[$patient_material->date + 5] = '<div class="panel-body profile-activity" >
                                           <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('documents') . '</span></h5>
                                            <h5 class="pull-right">' . date('d/m/Y', $patient_material->date) . '</h5>
                                            <div class="activity purplee">
                                                <span>
                                                    <i class="fa fa-file-o"></i>
                                                </span>
                                                <div class="activity-desk">
                                                    <div class="panel col-md-6">
                                                        <div class="panel-body">
                                                            <div class="arrow"></div>
                                                            <i class=" fa fa-calendar"></i>
                                                            <h4>' . date('d/m/Y', $patient_material->date) . ' <a class="pull-right" title="' . lang('download') . '"  href="' . $patient_material->url . '" download=""> <i class=" fa fa-download"></i> </a> </h4>
                                                                
                                                                 <h4>' . $patient_material->title . '</h4>
                                                            
                                                                
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>';
        }





        if (!empty($timeline)) {
            krsort($timeline);
            $timeline_value = '';
            foreach ($timeline as $key => $value) {
                $timeline_value .= $value;
            }
        }















        $all_appointments = '';
        foreach ($appointments as $appointment) {

            $status = '';

            if ($appointment->status == 'Pending Confirmation') {
                $status = '<span class="status-p bg-warning">' . lang('pending_confirmation') . '</span>';
            } elseif ($appointment->status == 'Confirmed') {
                $status = '<span class="status-p bg-success">' . lang('confirmed') . '</span>';
            } elseif ($appointment->status == 'Treated') {
                $status = '<span class="status-p bg-primary">' . lang('treated') . '</span>';
            } elseif ($appointment->status == 'Cancelled') {
                $status = '<span class="status-p bg-danger">' . lang('cancelled') . '</span>';
            }



            $patient_appointments = '<tr class = "">

        <td>' . date('d/m/Y', $appointment->date) . '
        </td>
        <td>' . $appointment->time_slot . '</td>
        <td>'
                . $appointment->servicename . '
        </td>
        <td>' . $status . '</td>
        <td></td>

        </tr>';

            $all_appointments .= $patient_appointments;
        }




        if (empty($all_appointments)) {
            $all_appointments = '';
        }



        $all_case = '';

        foreach ($medical_histories as $medical_history) {
            $patient_case = ' <tr class="">
                                                    <td>' . date("d-m-Y", $medical_history->date) . '</td>
                                                    <td>' . $medical_history->title . '</td>
                                                    <td>' . $medical_history->description . '</td>
                                                </tr>';

            $all_case .= $patient_case;
        }


        if (empty($all_case)) {
            $all_case = '';
        }
        $all_prescription = '';

        /* foreach ($data['prescriptions'] as $prescription) {
          $doctor_details = $this->doctor_model->getDoctorById($prescription->doctor);
          if (!empty($doctor_details)) {
          $prescription_doctor = $doctor_details->name;
          } else {
          $prescription_doctor = '';
          }
          $medicinelist = '';
          if (!empty($prescription->medicine)) {
          $medicine = explode('###', $prescription->medicine);

          foreach ($medicine as $key => $value) {
          $medicine_id = explode('***', $value);
          $medicine_details = $this->medicine_model->getMedicineById($medicine_id[0]);
          if (!empty($medicine_details)) {
          $medicine_name_with_dosage = $medicine_details->name . ' -' . $medicine_id[1];
          $medicine_name_with_dosage = $medicine_name_with_dosage . ' | ' . $medicine_id[3] . '<br>';
          rtrim($medicine_name_with_dosage, ',');
          $medicinelist .= '<p>' . $medicine_name_with_dosage . '</p>';
          }
          }
          } else {
          $medicinelist = '';
          }

          $option1 = '<a class="btn btn-info btn-xs btn_width" href="prescription/viewPrescription?id=' . $prescription->id . '"><i class="fa fa-eye">' . lang('view') . '</i></a>';
          $prescription_case = ' <tr class="">
          <td>' . date('m/d/Y', $prescription->date) . '</td>
          <td>' . $prescription_doctor . '</td>
          <td>' . $medicinelist . '</td>
          <td>' . $option1 . '</td>
          </tr>';

          $all_prescription .= $prescription_case;
          }

         */
        if (empty($all_prescription)) {
            $all_prescription = '';
        }


        $all_lab = '';

        foreach ($labs as $lab) {
            $doctor_details = $this->doctor_model->getDoctorById($lab->doctor);
            if (!empty($doctor_details)) {
                $lab_doctor = $doctor_details->name;
            } else {
                $lab_doctor = "";
            }
            $option1 = '<a class="btn btn-info btn-xs btn_width" href="lab/invoice?id=' . $lab->id . '"><i class="fa fa-eye">' . lang('report') . '</i></a>';
            $lab_class = ' <tr class="">
                                                    <td>' . $lab->id . '</td>
                                                    <td>' . date("m/d/Y", $lab->date) . '</td>
                                                    <td>' . $lab_doctor . '</td>
                                                         <td>' . $option1 . '</td>
                                                </tr>';

            $all_lab .= $lab_class;
        }


        if (empty($all_lab)) {
            $all_lab = '';
        }
        $all_bed = '';

        /* foreach ($beds as $bed) {


          $bed_case = ' <tr class="">
          <td>' . $bed->bed_id . '</td>
          <td>' . $bed->a_time . '</td>
          <td>' . $bed->d_time . '</td>

          </tr>';

          $all_bed .= $bed_case;
          }


          if (empty($all_bed)) {
          $all_bed = '';
          }
         */

        $all_material = '';
        foreach ($patient_materials as $patient_material) {

            if (!empty($patient_material->title)) {
                $patient_documents = $patient_material->title;
            }


            $patient_material = '
            
                                            <div class="panel col-md-3"  style="height: 200px; margin-right: 10px; margin-bottom: 36px; background: #f1f1f1; padding: 34px;">

                                                <div class="post-info">
                                                    <img src="' . $patient_material->url . '" height="100" width="100">
                                                </div>
                                                <div class="post-info">
                                                    
                                                ' . $patient_documents . '

                                                </div>
                                                <p></p>
                                                <div class="post-info">
                                                    <a class="btn btn-info btn-xs btn_width" href="' . $patient_material->url . '" download> ' . lang("download") . ' </a>
                                                    <a class="btn btn-info btn-xs btn_width" title="' . lang("delete") . '" href="patient/deletePatientMaterial?id=' . $patient_material->id . '"onclick="return confirm(\'' . lang('confirm_delete') . '\');"> X </a>
                                                </div>

                                                <hr>

                                            </div>';
            $all_material .= $patient_material;
        }

        if (empty($all_material)) {
            $all_material = ' ';
        }


        if (!empty($patient->img_url)) {
            $img = $patient->img_url;
        } else {
            $img = 'uploads/imgUsers/contact-512.png';
        }
        $paymentli = '';
        if ($this->ion_auth->in_group(array('admin', 'Receptionist', 'Assistant', 'Accountant', 'adminmedecin'))) {
            $paymentli = '   <li class="">
                            <a data-toggle="tab" href="#payment">' . lang('payments') . '</a>
                        </li>  ';
        }
        $assu = '';
        $lien_parente = "Autres";
        if ($patient->lien_parente == "Pere") {
            $lien_parente = "Enfant";
        } else if ($patient->lien_parente == "Mere") {
            $lien_parente = "Enfant";
        } else if ($patient->lien_parente == "Enfant") {
            $lien_parente = "Pere/Mere";
        }
        if ($this->ion_auth->in_group(array('admin', 'Receptionist', 'Assistant', 'adminmedecin'))) {
            $assu = '   <li class="">
                            <a data-toggle="tab" href="#mutuelle">' . lang('assurrance') . '</a> 
                        </li>
                    ';
        }

        $mut = '';
        if ($mutuelles) {
            $mut = '   <tr class="">
                                                <td>' . $mutuelles->nom . '</td>            
                                                <td>' . $mutuelles->pm_numpolice . '</td>
                                                <td>' . $mutuelles->pm_charge . '</td>
                                                <td>' . str_replace('-', '/', $mutuelles->pm_datevalid) . '</td>
                                                 
                                            </tr>';
        }

        foreach ($payments as $payment) {
            if ($payment->amount_received) {
                $payments_all = '    <tr class="">
                                        <td>' . date('d/m/Y H:i', $payment->date) . ' </td>
                                        <td> ' . $payment->code . '</td>
                                        <td> ' . number_format($payment->gross_total, 0, ",", ".") . ' FCFA </td>
                                        <td>' . number_format($payment->amount_received, 0, ",", ".") . ' FCFA 
                                            
                                         
                                           
                                        </td>

                                        <td>' . $payment->deposit_type . '</td>
                                    </tr>';
            } else {
                $payments_all = '    <tr class="">
                                        <td>' . date('d/m/Y H:i', $payment->date) . ' </td>
                                        <td> ' . $payment->code . '</td>
                                        <td> ' . number_format($payment->gross_total, 0, ",", ".") . ' FCFA </td>
                                        <td> </td>

                                        <td>' . $payment->deposit_type . '</td>
                                    </tr>';
            }
        }

        if (empty($payments_all)) {
            $payments_all = ' ';
        }




        $data['view'] = '
        <section class="col-md-3">
            <header class="panel-heading clearfix">
                <div class="">
                    ' . lang("patient_info2") . ' 
                </div>

            </header> 




  <aside class="profile-nav">
                <section class="">
                    <div class="user-heading round ">
                         <div class="user-img-circle">
                            <img class="avatar" src="' . $img . '" alt="" style="max-width: 110px; max-height: 110px;">
                          </div>
                        <h1> ' . $patient->name . ' ' . $patient->last_name . '</h1>
                        <p> ' . $patient->phone . ' </p>
                       
                           
                    </div>

                    <ul class="nav nav-pills nav-stacked">
                        <li>  <b> ' . lang('patient_id') . '</b> <span class="label pull-right r-activity">' . $patient->patient_id . '</span></li>
                        <li>  <b> ' . lang('gender') . '</b> <span class="label pull-right r-activity">' . $patient->sex . '</span></li>
                        <li>  <b> ' . lang('birth_date') . '</b> <span class="label pull-right r-activity">' . str_replace('-', '/', $patient->birthdate) . '</span></li>
                        <li>  <b> ' . lang('email') . '</b> <span class="label pull-right r-activity">' . $patient->email . '</span></li>
                        <li>  <b> ' . lang('address') . '</b> <span class="label pull-right r-activity">' . $patient->address . '</span></li>
                        <li>  <b> ' . lang('region') . '</b> <span class="label pull-right r-activity">' . $patient->region . '</span></li>
                     </ul>

                </section>
            </aside>


        </section>





        <section class="col-md-9">
            <header class="panel-heading clearfix">
                <div class="col-md-7">
                    ' . lang("dossier") . ' | ' . $patient->name . ' ' . $patient->last_name . '
                </div>

            </header>

            <section class="panel-body">   
                <header class="panel-heading tab-bg-dark-navy-blueee">
                    <ul class="nav nav-tabs">
                       <li class="active">
                            <a data-toggle="tab" href="#appointments">' . lang('appointments') . '</a>
                        </li>
                       
                        ' . $paymentli . '
                       ' . $assu . ' 
                        <li class="">
                            <a data-toggle="tab" href="#lab">' . lang('lab') . '</a>
                            
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#profile">' . lang('documents') . '</a>
                        </li>
                
                   
                    </ul>
                </header>
                <div class="panel">
                    <div class="tab-content">
                        <div id="appointments" class="tab-pane active">
                            <div class="">

                                <div class="adv-table editable-table ">
                                    <table class="table table-hover progress-table text-center" id="">
                                        <thead>
                                            <tr>
                                                <th>' . lang("date") . '</th>
                                                <th>' . lang("time_slot") . '</th>
                                                <th>' . lang("service") . '</th>
                                                <th>' . lang("status") . '</th>
                                                <th>' . lang("option") . '</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . $all_appointments . '
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="payment" class="tab-pane">
                          <section class="no-print col-md-12">
            <header class="panel-heading">
                <div class="panel-body no-print pull-right">
                    <a href="finance/addPaymentByPatientView?id=' . $patient->id . '&type=gen">
                        <div class="btn-group">
                            <button id="" class="btn btn-xs green">
                                <i class="fa fa-plus-circle"></i> ' . lang('add_payment') . ' 
                            </button>
                        </div>
                    </a>     
                </div>

            </header>
            <div class=" panel-body">
                <div class="adv-table editable-table ">




                    <header class="panel-heading col-md-12 row">
                       
                    </header>
                    <div class="space15"></div>

                    

                    <table class="table table-hover progress-table text-center patient-table" id="editable-samples">

                        <thead>
                            <tr>
                                <th class="">' . lang('date') . '</th>
                                <th class="">' . lang('invoice') . ' #</th>
                                <th class="">' . lang('amount') . '</th>
                                <th class="">' . lang('deposit') . '</th>
                                <th class="">' . lang('deposit_type') . '</th>
                                <th class="no-print"> ' . lang('options') . '</th>
                            </tr>
                        </thead>
                        <tbody>' .
            $payments_all
            . '

                        </tbody>

                    </table>
                </div>
            </div>

        </section>
                        </div>
                        
   <div id="mutuelle" class="tab-pane"> 
                            <div class="">
                                    <div class=" no-print">
                                        <a class="btn btn-info btn_width btn-xs pull-right" data-toggle="modal" href="patient/medicalHistory?id=' . $patient->id . '">
                                            <i class="fa fa-plus-circle"> </i> ' . lang('edit') . ' 
                                        </a>
                                    </div>

                                <div class="adv-table editable-table ">

                                    

                                    <table class="table table-hover progress-table text-center patient-table" id="">

                                        <thead>
                                            <tr>
                                                <th>' . lang('nom_mutuelle') . '</th>
                                                <th>' . lang('num_police') . '</th>
                                                <th>' . lang('charge_mutuelle') . '</th>
                                                <th>' . lang('date_valid') . '</th>
                                            
                                            </tr>
                                        </thead>
                                        <tbody>' . $mut . '
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="home" class="tab-pane">
                            <div class="">



                                <div class="adv-table editable-table ">


                                    <table class="table table-hover progress-table text-center" id="">
                                        <thead>
                                            <tr>
                                                <th>' . lang("date") . '</th>
                                                <th>' . lang("title") . '</th>
                                                <th>' . lang("description") . '</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . $all_case . '
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
            
         
                        <div id="lab" class="tab-pane"> <div class="">
                                <div class="adv-table editable-table ">
                                    <table class="table table-hover progress-table text-center" id="">
                                        <thead>
                                            <tr>
                                                <th>' . lang("id") . '</th>
                                                <th>' . lang("date") . '</th>
                                                <th>' . lang("doctor") . '</th>
                                                <th>' . lang("options") . '</th>
                                            </tr>
                                        </thead>
                                        <tbody>'
            . $all_lab .
            '</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
    

                        <div id="profile" class="tab-pane"> <div class="">

                                <div class="adv-table editable-table ">
                                    <div class="">
                                        ' . $all_material . '
                                    </div>
                                </div>
                            </div>
                        </div>

                       
                    </div>
                </div>
            </div>
        </div>
    </section>

</section>



</section>';


        echo json_encode($data);
    }

    public function getPatientinfo()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->patient_model->getPatientInfo($searchTerm, $this->id_organisation);

        echo json_encode($response);
    }

    public function getPatientinfoWithAddNewOption()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->patient_model->getPatientinfoWithAddNewOption($searchTerm, $this->id_organisation);

        echo json_encode($response);
    }

    public function getPatientinfoWithAddNewOptionByAppointmentCenter()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');
        $id_organisation = $this->input->post('id_organisation');

        // Get users
        $response = $this->patient_model->getPatientinfoWithAddNewOption($searchTerm, $id_organisation);

        echo json_encode($response);
    }

    public function getPatientinfoWithAddNewOptionLab()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->patient_model->getPatientinfoWithAddNewOptionLab($searchTerm, $this->id_organisation);

        echo json_encode($response);
    }

    public function getPatientinfoWithAddNewOptionByMutuelle()
    {
        $searchTerm = $this->input->post('searchTerm');
        $id = $this->input->post('id');
        $response = $this->patient_model->getPatientinfoWithAddNewOptionByMutuelle($searchTerm, $id, $this->id_organisation);
        echo json_encode($response);
    }

    public function getMutuelleInfo()
    {
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->patient_model->getMutuelleInfo($searchTerm, $this->id_organisation);
        echo json_encode($response);
    }

    function updateMutuelleByJason()
    {
        $redirect = $this->input->post('redirect');
        $patient_id = $this->input->post('patient_id');
        $idmutuelle = $this->input->post('mutuelle_id');
        $nom_mutuelle = $this->input->post('nom_mutuelle');
        $num_police = $this->input->post('num_police');
        $charge_mutuelle = $this->input->post('charge_mutuelle');
        $date_valid = $this->input->post('date_valid');
        $data = array(
            'pm_idpatent' => $patient_id,
            'pm_idmutuelle' => $nom_mutuelle,
            'pm_numpolice' => $num_police,
            'pm_charge' => $charge_mutuelle,
            'pm_datevalid' => $date_valid, 'pm_status' => 1, 'id_organisation' => $this->id_organisation
        );
        if (empty($idmutuelle)) {
            $response['patient'] = $this->patient_model->insertMutuellePatient($data);
        } else {
            $response['patient'] = $this->patient_model->updateMutuellePatient($idmutuelle, $data, $this->id_organisation);
        }


        if (!empty($redirect)) {
            redirect($redirect . '&type=mutuelleinfo');
        }

        redirect("patient/MedicalHistory?id=" . $patient_id . '&type=mutuelleinfo');
    }

    function deleteMutuellePatient()
    {
        $id = $this->input->get('id');
        $patient_id = $this->input->get('patient_id');

        $this->patient_model->deleteMutuellePatient($id, $this->id_organisation);
        $this->session->set_flashdata('feedback', lang('deleted'));

        redirect("patient/MedicalHistory?id=" . $patient_id . '&type=mutuelleinfo');
    }

    function deleteMutuelleRelation()
    {
        $id = $this->input->get('id');
        $patient_id = $this->input->get('patient_id');

        $this->patient_model->deleteMutuelleRelation($id, $this->id_organisation);
        $this->session->set_flashdata('feedback', lang('deleted'));

        redirect("patient/MedicalHistory?id=" . $patient_id . '&type=mutuelleinfo');
    }

    function editMutuelleByJason()
    {
        $id = $this->input->get('id');
        $data['mutuelle'] = $this->patient_model->getMutuelle($id, $this->id_organisation);
        echo json_encode($data);
    }

    function addNewMpatient()
    {
        $id = $this->input->post('id');
        $parent_id = $this->input->post('parent_id');
        $lien_parente = $this->input->post('lien_parente');
        $data = array('lien_parente' => $lien_parente, 'parent_id' => $parent_id);
        $data['mutuelle'] = $this->patient_model->addNewMpatient($id, $data, $this->id_organisation);

        redirect("patient/MedicalHistory?id=" . $parent_id);
    }
    function getPhoneUniqueByJason()
    {
        $num = $this->input->get('num');
        $patient = $this->input->get('patient');
        $data = $this->patient_model->getPhoneUniqueByJason($num, $patient);
        echo json_encode($data);
    }

    function addConsultationByJason()
    {
        $id = $this->input->get('id');
        $dataTab1 = $this->patient_model->addConsultationByConsultation($id, $this->id_organisation);
        $dataTab2 = $this->patient_model->addConsultationByLab($id, $this->id_organisation);
        $dataTab3  = $this->patient_model->addConsultationRDVByLab($id, $this->id_organisation);
        $dataTab4  = $this->patient_model->addBultinByLab($id, $this->id_organisation);
        $dataTab5  = $this->patient_model->addImagerieByLab($id, $this->id_organisation);

        $dataTab = array_merge($dataTab1, $dataTab2, $dataTab3, $dataTab4, $dataTab5);
        foreach ($dataTab as $key => $row) {
            $volume[$key]  = $row['date'];
        }
        $html = '';
        if (!empty($dataTab)) {
            array_multisort($volume, SORT_DESC, $dataTab);

            foreach ($dataTab as $value) {
                $html .= $value['html'];
            }
        }
        echo json_encode($html);
    }

    function addRendezVousByJason()
    {
        $id = $this->input->get('id');
        $dataTab1 = $this->patient_model->addRendezVousByConsultation($id, $this->id_organisation);
        $dataTab2 = $this->patient_model->addConsultationByLab($id, $this->id_organisation);

        $dataTab = array_merge($dataTab1, $dataTab2);
        foreach ($dataTab as $key => $row) {
            $volume[$key]  = $row['date'];
        }
        $html = '';
        if (!empty($dataTab)) {
            array_multisort($volume, SORT_DESC, $dataTab);

            foreach ($dataTab as $value) {
                $html .= $value['html'];
            }
        }
        echo json_encode($html);
    }

    function recuperationTemplate()
    {
        $data['template'] = $this->lab_model->getTemplateById(51);
        echo json_encode($data);
    }
}

/* End of file patient.php */
    /* Location: ./application/modules/patient/controllers/patient.php */
