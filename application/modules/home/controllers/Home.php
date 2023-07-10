<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MX_Controller
{

    var $id_organisation = '';
    var $path_logo = '';
    var $nom_organisation = '';

    function __construct()
    {
        parent::__construct();
        $this->load->model('finance/finance_model');
        $this->load->model('appointment/appointment_model');
        $this->load->model('notice/notice_model');
        $this->load->model('home_model');
        $this->load->model('services/service_model');
        $this->load->model('lab/lab_model');
        $this->load->model('patient/patient_model');
        $this->load->library('Excel');
        $this->load->model('import/import_model');
        $this->load->helper('file');
        $this->load->library('form_validation');
        $this->load->model('donor/donor_model');
        $this->load->model('services/service_model');
        $this->load->model('bed/bed_model');
        $this->load->model('lab/lab_model');
        $this->load->model('finance/finance_model');
        $this->load->model('finance/pharmacy_model');
        $this->load->model('sms/sms_model');
        $this->load->module('sms');
        $this->load->model('prescription/prescription_model');
        require APPPATH . 'third_party/stripe/stripe-php/init.php';
        $this->load->model('medicine/medicine_model');
        $this->load->model('doctor/doctor_model');
        $this->load->module('paypal');
        // $this->form_validation->CI =& $this;

        $identity = $this->session->userdata["identity"];

        $this->id_organisation = $this->home_model->get_id_organisation($identity);
        $this->path_logo = $this->home_model->get_logo_organisation($this->id_organisation);
        $this->nom_organisation = $this->home_model->get_nom_organisation($this->id_organisation);
        $this->id_partenaire_zuuluPay = $this->home_model->id_partenaire_zuuluPay($this->id_organisation);
        $this->pin_partenaire_zuuluPay_encrypted = $this->home_model->pin_partenaire_zuuluPay_encrypted($this->id_organisation);
        $this->code_organisation = $this->home_model->get_code_organisation($this->id_organisation);

        $this->id_serviceUser = $this->home_model->get_code_service($identity);
    }

    public function index()
    {

        // A optimiser
        $identity = $this->session->userdata["identity"];
        if ($identity == 'superadmin@zuulumed.net' || $identity == 'superadminlabo@zuulumed.net') {
            redirect('home/superhome');
        } else if ($identity == 'appointmentcenter@zuulumed.net') {
            redirect('patient/medicalHistory');
        }
        // Fin

        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        $data['sum'] = $this->home_model->getSum('gross_total', 'payment');
        $data['payments'] = $this->finance_model->getPayment();
        $data['notices'] = $this->notice_model->getNotice();
        $data['this_month'] = $this->finance_model->getThisMonth();
        $data['expenses'] = $this->finance_model->getExpense($this->id_organisation);

        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        if ($this->ion_auth->in_group(array('Doctor'))) {
            redirect('doctor/details');
        } else {
            $data['appointments'] = $this->appointment_model->getAppointment($this->id_organisation, $this->id_serviceUser);
        }

        if ($this->ion_auth->in_group(array('Receptionist'))) {
            // redirect('finance/addPaymentView');
        }
        if ($this->ion_auth->in_group(array('Accountant'))) {
            redirect('finance/financialReport');
        }


        if ($this->ion_auth->in_group(array('Pharmacist'))) {
            redirect('finance/pharmacy/home');
        }

        // if ($this->ion_auth->in_group(array('Patient'))) {
        //     redirect('patient/medicalHistory');
        // }
        if ($this->ion_auth->in_group(array('Laboratorist'))) {
            redirect('finance/paymentLabo');
        }
        if ($this->ion_auth->in_group(array('Biologiste'))) {
            redirect('finance/paymentLabo');
        }

        if ($this->ion_auth->in_group(array('superlabo'))) {
            redirect('home/superPrestations');
        }



        $data['this_month']['payment'] = $this->finance_model->thisMonthPayment($this->id_organisation);
        $data['this_month']['expense'] = $this->finance_model->thisMonthExpense($this->id_organisation);
        $data['this_month']['appointment'] = $this->finance_model->thisMonthAppointment($this->id_organisation, $this->id_serviceUser);

        $data['this_day']['payment'] = $this->finance_model->thisDayPayment($this->id_organisation);
        $data['this_day']['expense'] = $this->finance_model->thisDayExpense($this->id_organisation);
        $data['this_day']['appointment'] = $this->finance_model->thisDayAppointment($this->id_organisation, $this->id_serviceUser);

        $data['this_year']['payment'] = $this->finance_model->thisYearPayment($this->id_organisation);
        $data['this_year']['expense'] = $this->finance_model->thisYearExpense($this->id_organisation);
        $data['this_year']['appointment'] = $this->finance_model->thisYearAppointment($this->id_organisation, $this->id_serviceUser);

        $data['this_month']['appointment'] = $this->finance_model->thisMonthAppointment($this->id_organisation, $this->id_serviceUser);
        $data['this_month']['appointment_treated'] = $this->finance_model->thisMonthAppointmentTreated($this->id_organisation, $this->id_serviceUser);
        $data['this_month']['appointment_cancelled'] = $this->finance_model->thisMonthAppointmentCancelled($this->id_organisation, $this->id_serviceUser);

        $data['this_year']['payment_per_month'] = $this->finance_model->getPaymentPerMonthThisYear($this->id_organisation);


        $data['this_year']['expense_per_month'] = $this->finance_model->getExpensePerMonthThisYear($this->id_organisation);

        $data['actes']['new'] = count($this->finance_model->getPaymentByFilter($this->id_organisation, 'new'));
        $data['actes']['pending'] = count($this->finance_model->getPaymentByFilter($this->id_organisation, 'pending'));
        $data['actes']['done'] = count($this->finance_model->getPaymentByFilter($this->id_organisation, 'done'));
        $data['actes']['valid'] = count($this->finance_model->getPaymentByFilter($this->id_organisation, 'valid'));
        $data['actes']['finish'] = count($this->finance_model->getPaymentByFilter($this->id_organisation, 'finish'));
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);


        $this->load->view('dashboard', $data); // just the header file
        $this->load->view('home', $data);
        $this->load->view('footer', $data);
    }




    function settings()
    {
        $data = array();
        $data['whatsapp'] = $this->db->get_where('whatsapp_settings', array('id' => 1))->row();
        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('whatsapp', $data);
        $this->load->view('footer', $data);
    }

    public function dossierpatient()
    {
        $data = array();
        $id = $this->input->get('id');
        $patient = $this->home_model->getUsersPatientById($id);
        $data['settings'] = $this->settings_model->getSettings();
        //   $data['payments'] = $this->finance_model->getPaymentByPatientId($id, $this->id_organisation);
        $data['templates'] = $this->lab_model->getTemplateMultiConsultation();
        $data['maladies'] = $this->home_model->getMaladie();
        // $data['current_medications'] = $this->db->query("select * from current_medications where patient_id = ".$id)->result_array();
        // $data['pre_conditions'] = $this->db->query("select * from pre_conditions where patient_id = ".$id)->result_array();

        $data['deposits'] = $this->finance_model->getDepositByPatientId($id);
        $data['payments'] = $this->finance_model->getPaymentByPatientId($id, $patient->id_organisation);
        $data['patient'] = $this->patient_model->getPatientById($id, $patient->id_organisation);
        $data['appointments'] = $this->appointment_model->getAppointmentByPatient($data['patient']->id, $patient->id_organisation, $this->id_serviceUser);
        $data['patients'] = $this->patient_model->getPatient($patient->id_organisation);
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
        $data['medical_histories'] = $this->patient_model->getMedicalHistoryByPatientId($id, $patient->id_organisation);
        $data['patient_materials'] = $this->patient_model->getPatientMaterialByPatientId($id, $patient->id_organisation);
        $data['payments'] = $this->finance_model->getPaymentByPatientId($id, $patient->id_organisation);
        $data['groups'] = $this->donor_model->getBloodBank();
        $data['regions'] = array('Dakar', 'Ziguinchor', 'Diourbel', 'Saint-Louis', 'Tambacounda', 'Kaolack', 'Thiès', 'Louga', 'Fatick', 'Kolda', 'Matam', 'Kaffrine', 'Kédougou', 'Sédhiou');
        $data['religions'] = array('Musulmane', 'Chetienne', 'Autres');
        $data['mutuelles'] = $this->patient_model->getMutuelle($data['patient']->id, $patient->id_organisation);
        $data['mutuelles_relation'] = $this->patient_model->getPatientByIdParent($id, $patient->id_organisation);
        $data['mutuellesInit'] = array();
        $data['lien_parente'] = '';
        $data['mutuelles_relationInit'] = array();
        if ($data['patient']->parent_id) {
            $data['mutuellesInit'] = $this->patient_model->getMutuelle($data['patient']->parent_id, $patient->id_organisation);
            $data['mutuelles_relationInit'] = $this->patient_model->getPatientById($data['patient']->parent_id, $patient->id_organisation);
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

       
        $this->load->view('appointmentcenterdashboard', $data); // just the header file
        $this->load->view('patient/medical_history', $data);
        $this->load->view('footer', $data);
    }

    public function superhome()
    {
        $data = array();
        // $data['settings'] = $this->settings_model->getSettings();

        // $buff = $this->encryption->encrypt("198686");
        // $buff2 = $this->encryption->decrypt($buff);
        // $this->session->set_flashdata('feedback', $buff." <br/>".$buff2);

        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('superhome', $data);
        $this->load->view('footer', $data);
    }

    public function tiersPayant()
    {
        $data = array();
        $data['tiers_payants'] = $this->home_model->getTiersPayant();
        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('tiers_payant', $data);
        $this->load->view('footer', $data);
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
            redirect('addTemplate');
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
                    redirect("home/template");
                } else {
                    redirect("home/templateConsultation");
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
                    redirect("home/template");
                } else {
                    redirect("home/templateConsultation");
                }
                // redirect("lab/addTemplateView?id=" . "$id");
            }
        }
    }

    public function addTemplateView()
    {
        $data = array();
        $id = $this->input->get('id');
        if (!empty($id)) {
            $data['template'] = $this->lab_model->getTemplateById($id);
        }
        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('add_template', $data);
        $this->load->view('footer'); // just the header file
    }

    public function addTiersPayant()
    {
        $data = array();
        $id = $this->input->post('id');
        $code = $this->input->post('code');
        $prix_assurance = $this->input->post('prix_assurance');
        $prix_ipm = $this->input->post('prix_ipm');
        $data = array();
        $data = array(
            "code" => $code,
            "prix_assurance" => $prix_assurance,
            "prix_ipm" => $prix_ipm
        );
        if (empty($id)) {
            if ($code) {
                $this->home_model->insertTiersPayant($data);
            }
        } else {
            $this->home_model->updateTiersPayant($id, $data);
        }

        $this->session->set_flashdata('feedback', 'Modification effectuée avec succès');
        redirect('home/tiersPayant');
    }


    public function editTiersPayant()
    {
        $data = array();
        $id = $this->input->get('id');
        $data['tiers_payant'] = $this->home_model->getTiersPayantById($id);
        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('add_tiers_payant', $data);
        $this->load->view('footer'); // just the header file
    }

    function editTemplate()
    {
        $data = array();
        $id = $this->input->get('id');
        $data['template'] = $this->lab_model->getTemplateById($id);
        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('add_template', $data);
        $this->load->view('footer'); // just the footer file
    }

    public function template()
    {
        $data = array();
        $data['templates'] = $this->lab_model->getTemplateLabo();

        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('template', $data);
        $this->load->view('footer'); // just the header file
    }

    public function templateConsultation()
    {
        $data = array();
        $data['templates'] = $this->lab_model->getTemplateConsultation();

        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('template_consultation', $data);
        $this->load->view('footer'); // just the header file
    }


    public function templateMaladie()
    {
        $data = array();
        $data['templates'] = $this->home_model->getMaladie();

        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('template_maladie', $data);
        $this->load->view('footer'); // just the header file
    }

    public function superOrganisationUsers()
    {
        $data = array();
        // $data['settings'] = $this->settings_model->getSettings();

        // $buff = $this->encryption->encrypt("198686");
        // $buff2 = $this->encryption->decrypt($buff);
        // $this->session->set_flashdata('feedback', $buff." <br/>".$buff2);
        $id = $this->input->get('id');
        $data["organisation"] = $this->home_model->getOrganisationById($id);
        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('superOrganisationUsers', $data);
        $this->load->view('footer', $data);
    }


    public function payment()
    {
        $data = array();
        $id = $this->input->get('id');
        $data['payments'] = $this->finance_model->getPayment($id);
        $data["organisation"] = $this->home_model->getOrganisationById($id);
        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('payment', $data);
        $this->load->view('footer', $data);
    }





    public function superOrganisationPatient()
    {
        $data = array();
        $id = $this->input->get('id');
        $data['patients'] = $this->patient_model->getPatient($id);
        $data["organisation"] = $this->home_model->getOrganisationById($id);
        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('patient', $data);
        $this->load->view('footer', $data);
    }

    public function superAddOrganisation()
    {
        $data = array();
        // $data['settings'] = $this->settings_model->getSettings();
        $data['regions_senegal'] = $this->home_model->getRegionsSenegal();

        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('superAddOrganisation', $data);
        $this->load->view('footer', $data);
    }

    public function superAddOrganisationUser()
    {
        $data = array();
        // $data['settings'] = $this->settings_model->getSettings();
        $data['regions_senegal'] = $this->home_model->getRegionsSenegal();
        $idOrganisation = $this->input->get("idOrganisation");
        $data['organisation'] = $this->home_model->getOrganisationById($idOrganisation);

        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('superAddOrganisationUser', $data);
        $this->load->view('footer', $data);
    }

    public function search_patients()
    {

        $q = $this->input->get('search_query');

        $data = $this->db->query("SELECT * FROM `patient` where (patient_id like '%$q%' or name like '%$q%' or last_name like '%$q%' or email like '%$q%' or phone like '%$q%' or matricule like '%$q%') and id_organisation = " . $this->id_organisation . " LIMIT 8")->result_array();
        echo json_encode($data);
        // $data = array();
        // $data['settings'] = $this->settings_model->getSettings();
        // $data['regions_senegal'] = $this->home_model->getRegionsSenegal();
        // $idOrganisation = $this->input->get("idOrganisation");
        // $data['organisation'] = $this->home_model->getOrganisationById($idOrganisation);

        // $this->load->view('superdashboard', $data); // just the header file
        // $this->load->view('superAddOrganisationUser', $data);
        // $this->load->view('footer', $data);
    }


    public function superEditOrganisationUser()
    {
        $data = array();
        $id = $this->input->get('id');
        $idOrganisation = $this->input->get('idOrganisation');
        $data['user'] = $this->home_model->getUserById($id);
        $data['regions_senegal'] = $this->home_model->getRegionsSenegal();
        // $this->session->set_flashdata('feedback2', print_r());
        $data['organisation'] = $this->home_model->getOrganisationById($idOrganisation);

        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('superAddOrganisationUser', $data);
        $this->load->view('footer', $data);
    }

    public function superEditOrganisation()
    {
        $data = array();
        $id = $this->input->get('id');
        $data['organisation'] = $this->home_model->getOrganisationById($id);
        // $this->session->set_flashdata('feedback2', print_r());
        $data['organisation']->pin_partenaire_zuuluPay = $this->encryption->decrypt($data['organisation']->pin_partenaire_zuuluPay_encrypted);
        $data['regions_senegal'] = $this->home_model->getRegionsSenegal();

        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('superAddOrganisation', $data);
        $this->load->view('footer', $data);
    }

    public function paymentCategoryAdmin()
    {
        $data['services'] = $this->service_model->getService();
        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('service', $data);
        $this->load->view('footer', $data);
    }

    public function superServices()
    {
        $data['services'] = $this->service_model->getGenericServices();
        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('superservices', $data);
        $this->load->view('footer', $data);
    }

    public function superPrestations()
    {
        $data['services'] = $this->service_model->getGenericPrestations();
        if ($this->ion_auth->in_group(array('superlabo'))) {
            $this->load->view('dashboard', $data);  // just the header file
        } else {
            $this->load->view('superdashboard', $data);  // just the header file
        }

        $this->load->view('superprestations');
        $this->load->view('footer', $data);
    }

    function getSpecId($nom_service, $nom_specialite)
    {
        $id_service = $this->db->query("select idservice from setting_service where name_service = \"" . $nom_service . "\" and id_organisation is NULL")->row()->idservice;
        $id_spe = $this->db->query("select (CASE WHEN `setting_service_specialite`.idspe IS NOT NULL THEN (SELECT `setting_service_specialite`.idspe) ELSE (SELECT '') END) as idspe from setting_service_specialite join setting_service on setting_service.idservice = setting_service_specialite.id_service and setting_service.idservice = " . $id_service . "  and id_organisation is NULL where name_specialite = \"" . $nom_specialite . "\"")->row()->idspe;
        return $id_spe;
    }

    function getSuperPrestations()
    {
        $type = $this->input->post('type');
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                // $data['cases'] = $this->sms_model->getAutoSMSTemplateBySearch($search);
                $data['prestations'] = $this->service_model->getGenericPrestations();
            } else {
                // $data['cases'] = $this->sms_model->getAutoSMSTemplate();
                $data['prestations'] = $this->service_model->getGenericPrestations();
            }
        } else {
            if (!empty($search)) {
                // $data['cases'] = $this->sms_model->getAutoSMSTemplateByLimitBySearch($limit, $start, $search);
                $data['prestations'] = $this->service_model->getGenericPrestations();
            } else {
                // $data['cases'] = $this->sms_model->getAutoSMSTemplateByLimit($limit, $start);
                $data['prestations'] = $this->service_model->getGenericPrestations();
            }
        }
        //  $data['patients'] = $this->patient_model->getVisitor();
        $i = 0;
        $count = 0;

        // echo "<script language=\"javascript\">alert('Here I am');</script>";
        foreach ($data['prestations'] as $prestation) {
            $i = $i + 1;

            if ($this->ion_auth->in_group(array('admin', 'adminmedecin'))) {

                $options1 = '<a href="javascript:;" class="btn btn-info btn-xs btn_width disabled" data-id=""><i class="fa fa-edit"></i></a>';
                // $options1 = ' <a type="button" class="btn btn-success btn-xs btn_width editbutton1" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $case->id . '"><i class="fa fa-edit"> </i></a>';
                // $options1 = '<a type='button" class="btn btn-success btn-xs btn_width" title="" . lang('edit') . '"data-toggle = "modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i></a>';
                //    $options2 = '<a class="btn btn-danger btn-xs btn_width" title="' . lang('delete') . '" href="sms/deleteTemplate?id=' . $case->id . '&redirect=sms/smsTemplate" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash-o"></i></a>';
            }
            $type = "Autre";
            if ($prestation->code_service == "labo") {
                $type = "Laboratoire";
            }
            if ($prestation->code_service == "MEDGEN") {
                $type = "Medecine générale";
            }

            //  $type = $prestation->code_service == "labo" ? "Laboratoire" : "Autre";
            $info[] = array(
                "id" => $prestation->id,
                "prestation" => $prestation->prestation,
                "keywords" => $prestation->keywords,
                "service" => $prestation->name_service,
                "specialite" => $prestation->name_specialite,
                "specialiteid" => $this->getSpecId($prestation->name_service, $prestation->name_specialite), // to get current specialite id
                "type" => $type,
                "cotation" => $prestation->cotation,
                "coefficient" => $prestation->coefficient,
                "cotationCoefficiant" => $prestation->cotation . ":" . $prestation->coefficient,
                "options" => $options1
            );

            // $info[] = array(
            // "indice" => "ABD",
            // "prestation" => "ABD",
            // "service" => "ABD",
            // "specialite" => "ABD",
            // "type" => "ABD",
            //  "options" => "ABD"
            // );
            // $count = $count + 1;
        }

        if (!empty($data['prestations'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => count($data['prestations']),
                "recordsFiltered" => count($data['prestations']),
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


    function getPrestationsOrganisationEncoreDispo()
    {
        $type = $this->input->post('type');
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                // $data['cases'] = $this->sms_model->getAutoSMSTemplateBySearch($search);
                $data['prestations'] = $this->service_model->getPrestationsOrganisationEncoreDispo($this->id_organisation);
            } else {
                // $data['cases'] = $this->sms_model->getAutoSMSTemplate();
                $data['prestations'] = $this->service_model->getPrestationsOrganisationEncoreDispo($this->id_organisation);
            }
        } else {
            if (!empty($search)) {
                // $data['cases'] = $this->sms_model->getAutoSMSTemplateByLimitBySearch($limit, $start, $search);
                //$data['prestations'] = $this->service_model->getPrestationsOrganisationEncoreDispo($this->id_organisation);
                $data['prestations'] = $this->service_model->getTablePrestationsOrganisationEncoreDispoBySearch($search, $this->id_organisation);
            } else {
                // $data['cases'] = $this->sms_model->getAutoSMSTemplateByLimit($limit, $start);
                $data['prestations'] = $this->service_model->getPrestationsOrganisationEncoreDispo($this->id_organisation);
            }
        }
        //  $data['patients'] = $this->patient_model->getVisitor();
        $i = 0;
        $count = 0;

        // echo "<script language=\"javascript\">alert('Here I am');</script>";
        foreach ($data['prestations'] as $prestation) {
            $i = $i + 1;
            $options1 = "";
            if ($this->ion_auth->in_group(array('admin', 'adminmedecin'))) {
                $est_dans_panier = $prestation->est_dans_panier;
                $id = $prestation->id;
                $options1 = '<a href="javascript:;" class="btn btn-info btn-xs btn_width " data-id=""><i class="fa fa-edit"></i></a>';

                $options1 = '<span id="result_' . $id . '" data-id="est_couvert_' . $id . '" data-name="est_couvert_' . $id . '">';
                if (!empty(est_dans_panier) && $est_dans_panier == "1") {
                    $options1 .= '<span class="color-green">Oui</span>';
                } else {
                    $options1 .= '<span class="color-red">Non</span>';
                }
                $options1 .= '</span>';
                $options1 .= '<label class="switch pull-right">';
                $options1 .= '<input  type="checkbox" id="checkbox_' . $id . '"';
                $options1 .= !empty(est_dans_panier) && $est_dans_panier == 1  ? " checked " : " ";
                $options1 .= ' onclick="fctSwitch(' . $id . ');">';
                $options1 .= '<span class="slider round" ></span>';
                $options1 .= '</label>';
            }
            $type = "Autre";
            if ($prestation->code_service == "labo") {
                $type = "Laboratoire";
            }
            if ($prestation->code_service == "MEDGEN") {
                $type = "Medecine générale";
            }
            $info[] = array(
                "id" => $prestation->id,
                "prestation" => $prestation->prestation,
                "keywords" => $prestation->keywords,
                "service" => $prestation->name_service,
                "specialite" => $prestation->name_specialite,
                "type" => $type,
                "options" => $options1
            );
            // $info[] = array(
            // "indice" => "ABD",
            // "prestation" => "ABD",
            // "service" => "ABD",
            // "specialite" => "ABD",
            // "type" => "ABD",
            //  "options" => "ABD"
            // );
            // $count = $count + 1;
        }

        if (!empty($data['prestations'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => count($data['prestations']),
                "recordsFiltered" => count($data['prestations']),
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

    function getPCODetails()
    {

        $idpco = $this->input->get('idpco');
        $data['details'] = $this->service_model->getPCODetails($idpco, $this->id_organisation);
        $data['details']->tarif_public = explode(".", $data['details']->tarif_public)[0];
        $data['details']->tarif_professionnel = explode(".", $data['details']->tarif_professionnel)[0];
        $data['details']->tarif_assurance = explode(".", $data['details']->tarif_assurance)[0];
        $data['details']->tarif_ipm = explode(".", $data['details']->tarif_ipm)[0];
        $data['details']->prix_public = explode(".", $data['details']->prix_public)[0];
        echo json_encode($data);
    }

    function getPrestationsOrganisation()
    {
        $type = $this->input->post('type');
        /*  $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                // $data['cases'] = $this->sms_model->getAutoSMSTemplateBySearch($search);
                $data['prestations'] = $this->service_model->getPrestationsOrganisation($this->id_organisation);
            } else {
                // $data['cases'] = $this->sms_model->getAutoSMSTemplate();
                $data['prestations'] = $this->service_model->getPrestationsOrganisation($this->id_organisation);
            }
        } else {
            if (!empty($search)) {
                // $data['cases'] = $this->sms_model->getAutoSMSTemplateByLimitBySearch($limit, $start, $search);
                $data['prestations'] = $this->service_model->getPrestationsOrganisation($this->id_organisation);
            } else {
                // $data['cases'] = $this->sms_model->getAutoSMSTemplateByLimit($limit, $start);
                $data['prestations'] = $this->service_model->getPrestationsOrganisation($this->id_organisation);
            }
        }*/

        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                // $data['cases'] = $this->sms_model->getAutoSMSTemplateBySearch($search);
                $data['prestations'] = $this->service_model->getTablePrestationsOrganisationBySearch($search, $this->id_organisation);
            } else {
                // $data['cases'] = $this->sms_model->getAutoSMSTemplate();
                $data['prestations'] = $this->service_model->getPrestationsOrganisation($this->id_organisation);
            }
        } else {
            if (!empty($search)) {
                // $data['cases'] = $this->sms_model->getAutoSMSTemplateByLimitBySearch($limit, $start, $search);
                $data['prestations'] = $this->service_model->getTablePrestationsOrganisationByLimitBySearch($limit, $start, $search, $this->id_organisation);
            } else {
                // $data['cases'] = $this->sms_model->getAutoSMSTemplateByLimit($limit, $start);
                $data['prestations'] = $this->service_model->getTablePrestationsOrganisationByLimit($limit, $start, $this->id_organisation);
            }
        }

        //$data['prestations'] = $this->service_model->getPrestationsOrganisation($this->id_organisation);
        //  $data['patients'] = $this->patient_model->getVisitor();
        $i = 0;
        $count = 0;

        // echo "<script language=\"javascript\">alert('Here I am');</script>";
        foreach ($data['prestations'] as $prestation) {
            $i = $i + 1;

            $options1 = '';
            if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Accountant', 'Receptionist', 'Assistant'))) {

                $options1 .= ' <a type="button" class="btn btn-info btn-xs btn_width editPrices" title="' . lang('editPrices') . '" onClick="editPrices(' . $prestation->idpco . ' );" data-toggle = "modal" data-id="' . $prestation->idpco . '"><i class="fa fa-money-check-edit"> </i></a>';
            }
            // if ($this->ion_auth->in_group(array('admin', 'adminmedecin', 'Accountant'))) {

            //     $options1 .= ' <a type="button" class="btn btn-info btn-xs btn_width editModele" title="' . lang('modeletitle') . '" onClick="editModele(' . $prestation->id . ' );" data-toggle = "modal" data-id="' . $prestation->id . '"><i class="fa fa-list"> </i></a>';
            // }

            /*else {
                $options1 .= '';
            }*/
            $type = "Autre";
            if ($prestation->code_service == "labo") {
                $type = "Laboratoire";
            }
            if ($prestation->code_service == "MEDGEN") {
                $type = "Medecine générale";
            }
            $info[] = array(
                "id" => $prestation->id,
                "prestation" => $prestation->prestation,
                "keywords" => $prestation->keywords,
                "service" => $prestation->name_service,
                "specialite" => $prestation->name_specialite,
                "type" => $type,
                "tarifPublic" => number_format($prestation->tarif_public, 0, ",", ".") . " FCFA",
                "prixPublic" => number_format($prestation->prix_public, 0, ",", ".") . " FCFA",
                "tarifProfessionnel" => number_format($prestation->tarif_professionnel, 0, ",", ".") . " FCFA",
                "tarifAssurance" => number_format($prestation->tarif_assurance, 0, ",", ".") . " FCFA",
                "tarifIPM" => number_format($prestation->tarif_ipm, 0, ",", ".") . " FCFA",
                "options" => $options1
            );
            // $info[] = array(
            // "indice" => "ABD",
            // "prestation" => "ABD",
            // "service" => "ABD",
            // "specialite" => "ABD",
            // "type" => "ABD",
            //  "options" => "ABD"
            // );
            // $count = $count + 1;
        }

        if (!empty($data['prestations'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => count($data['prestations']),
                "recordsFiltered" => count($data['prestations']),
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

    function editPrestationSpecialite()
    {
        $requestData = $_REQUEST;
        $idPrestation = $requestData["idPrestation"];
        $newSpecialite = $requestData["newSpecialite"];
        $nomService = $requestData["nomService"];

        // $idPrestation = $this->input->post('idPrestation');
        // $newName = $this->input->post('newName');

        $edit = $this->service_model->editPrestationSpecialite($idPrestation, $newSpecialite, $nomService);
        echo json_encode($edit);
    }

    function editPrestationName()
    {
        $requestData = $_REQUEST;
        $idPrestation = $requestData["idPrestation"];
        $newName = $requestData["newName"];
        $nomService = $requestData["nomService"];


        // $idPrestation = $this->input->post('idPrestation');
        // $newName = $this->input->post('newName');

        $edit = $this->service_model->editPrestationName($idPrestation, $newName, $nomService);
        echo json_encode($edit);
    }

    function editParamName()
    {
        $requestData = $_REQUEST;
        $idPrestation = $requestData["idPrestation"];
        $idParametre = $requestData["idParametre"];
        $newName = $requestData["newName"];
        // $nomService = $requestData["nomService"];

        // $idPrestation = $this->input->post('idPrestation');
        // $newName = $this->input->post('newName');

        $edit = $this->service_model->editParamName($idPrestation, $idParametre, $newName);
        echo json_encode($edit);
    }

    function editParamUnite()
    {
        $requestData = $_REQUEST;
        $idParametre = $requestData["idParametre"];
        $newUnite = $requestData["newUnite"];
        // $nomService = $requestData["nomService"];

        // $idPrestation = $this->input->post('idPrestation');
        // $newName = $this->input->post('newName');

        $edit = $this->service_model->editParamUnite($idParametre, $newUnite);
        echo json_encode($edit);
    }

    function editParamValeurs()
    {
        $requestData = $_REQUEST;
        $idParametre = $requestData["idParametre"];
        $newValeurs = $requestData["newValeurs"];
        // $nomService = $requestData["nomService"];

        // $idPrestation = $this->input->post('idPrestation');
        // $newName = $this->input->post('newName');

        $edit = $this->service_model->editParamValeurs($idParametre, $newValeurs);
        echo json_encode($edit);
    }

    function editRefLow()
    {
        $requestData = $_REQUEST;
        $idParametre = $requestData["idParametre"];
        $newRefLow = $requestData["newRefLow"];
        // $nomService = $requestData["nomService"];

        // $idPrestation = $this->input->post('idPrestation');
        // $newName = $this->input->post('newName');

        $edit = $this->service_model->editRefLow($idParametre, $newRefLow);
        echo json_encode($edit);
    }


    function editRefHigh()
    {
        $requestData = $_REQUEST;
        $idParametre = $requestData["idParametre"];
        $newRefHigh = $requestData["newRefHigh"];
        // $nomService = $requestData["nomService"];

        // $idPrestation = $this->input->post('idPrestation');
        // $newName = $this->input->post('newName');

        $edit = $this->service_model->editRefHigh($idParametre, $newRefHigh);
        echo json_encode($edit);
    }

    function editPrestationDescription()
    {
        $requestData = $_REQUEST;
        $idPrestation = $requestData["idPrestation"];
        $newDescription = $requestData["newDescription"];
        // $nomService = $requestData["nomService"];

        // $idPrestation = $this->input->post('idPrestation');
        // $newName = $this->input->post('newName');

        $edit = $this->service_model->editPrestationDescription($idPrestation, $newDescription);
        echo json_encode($edit);
    }


    function editPrestationKeywords()
    {
        $requestData = $_REQUEST;
        $idPrestation = $requestData["idPrestation"];
        $newKeywords = $requestData["newKeywords"];
        // $nomService = $requestData["nomService"];

        // $idPrestation = $this->input->post('idPrestation');
        // $newName = $this->input->post('newName');

        $edit = $this->service_model->editPrestationKeywords($idPrestation, $newKeywords);
        echo json_encode($edit);
    }

    function getSuperPrestationDetails()
    {
        $idPrestation = $this->input->get('idPrestation');
        $typePrestation = $this->input->get('typePrestation');
        $nomPrestation = $this->input->get('nomPrestation');
        $cotation = $this->input->get('cotation');
        $coefficient = $this->input->get('coefficient');
        $params = array();


        $description = $this->service_model->getSuperPrestationDescription($idPrestation);

        $description = trim($description->description) == "" ? "Non fournie" : $description->description;

        if ($typePrestation == "Laboratoire") {
            $params = $this->service_model->getSuperPrestationParams($idPrestation);

            $html = '<table class="details">';
            $html .= '<thead>';
            $html .= '	<tr>';
            // $html .= '	  <th scope="col" rowspan="2" style="border-right: 2px solid #ddd !important;width:30% !important;">Description Prestation</th>';
            $html .= '	  <th scope="col" rowspan="2" style="border-right: 2px solid #ddd !important;width:30% !important;">Description de<br/> ' . $nomPrestation . '</th>';
            $html .= '	  <th scope="col" colspan="3">Liste Paramètres</th>';
            $html .= '	</tr>';
            $html .= '	<tr>';
            $html .= '	  <th scope="col">Nom</th>';
            $html .= '	  <th scope="col">Unité</th>';
            $html .= '	  <th scope="col">Norme</th>';
            $html .= '	</tr>';
            $html .= '  </thead>';

            $html .= '  <tbody>';

            $indice = 0;
            foreach ($params as $param) {
                if ($indice == 0) {
                    $html .= '    <tr>';
                    $html .= '  	<td scope="row" style="border-right: 2px solid #ddd !important;" data-label="Description" rowspan="' . count($params) . '">' . $description . '</td>';
                    $html .= '  	<td data-label="Column 2">' . $param->nom_parametre . '</td>';
                    $html .= '  	<td data-label="Column 3">' . $param->unite . '</td>';
                    $html .= '  	<td data-label="Column 4">' . $param->valeurs . '</td>';
                    $html .= '    </tr>';
                } else {
                    $html .= '    <tr>';
                    $html .= '  	<td data-label="Column 3">' . $param->nom_parametre . '</td>';
                    $html .= '  	<td data-label="Column 4">' . $param->unite . '</td>';
                    $html .= '  	<td data-label="Column 4">' . $param->valeurs . '</td>';
                    $html .= '    </tr>';
                }
                $indice++;
            }
            $html .= '  </tbody>';
            $html .= '  </table>';
        } else {

            $html = '<table class="details">';
            $html .= '<thead>';
            $html .= '	<tr>';
            // $html .= '	  <th scope="col" rowspan="2" style="border-right: 2px solid #ddd !important;width:30% !important;">Description Prestation</th>';
            $html .= '	  <th scope="col" style="border-right: 2px solid #ddd !important;width:30% !important;">Description de<br/> ' . $nomPrestation . '</th>';
            $html .= '	</tr>';
            $html .= '  </thead>';

            $html .= '  <tbody>';
            $html .= '    <tr>';
            $html .= '  	<td scope="row" style="border-right: 2px solid #ddd !important;" data-label="Description">' . $description . '	</td>';
            $html .= '    </tr>';
            $html .= '  </tbody>';
            $html .= '  </table>';
        }




        $data["html"] = $html;
        echo json_encode($data);
    }

    function getSuperDuperPrestationDetails()
    {
        $idPrestation = $this->input->get('idPrestation');
        $typePrestation = $this->input->get('typePrestation');
        $nomPrestation = $this->input->get('nomPrestation');
        $nomService = $this->input->get('nomService');
        $params = array();


        $descriptionAndKeywords = $this->service_model->getSuperPrestationDescriptionAndKeywords($idPrestation);

        $description = trim($descriptionAndKeywords->description) == "" ? "Non fournie" : $descriptionAndKeywords->description;
        $keywords = trim($descriptionAndKeywords->keywords) == "" ? "Non fournie" : $descriptionAndKeywords->keywords;

        if ($typePrestation == "Laboratoire" || $typePrestation == "Medecine générale") {
            $params = $this->service_model->getSuperPrestationParams($idPrestation);
            $_SESSION['params'] = $params;
            $html = '<div class="btn-group pull-right">';
            $html .= '<button id="editbtnsub" class="btn btn-primary editbtnsub"><i class="fas fa-edit"></i>&nbsp;Éditer</button>';
            $html .= '</div>';
            $html .= '<table class="details" data-id="' . $nomService . '@@@@' . $idPrestation . '">';
            $html .= '<thead>';
            $html .= '	<tr>';
            // $html .= '	  <th scope="col" rowspan="2" style="border-right: 2px solid #ddd !important;width:30% !important;">Description Prestation</th>';
            $html .= '	  <th scope="col" rowspan="2" style="border-right: 2px solid #ddd !important;width:30% !important;">Description</th>';
            $html .= '	  <th scope="col" rowspan="2" style="border-right: 2px solid #ddd !important;width:30% !important;">Mots-clés</th>';
            $html .= '	  <th scope="col" colspan="7">Liste Paramètres</th>';
            $html .= '	</tr>';
            $html .= '	<tr>';
            $html .= '	  <th scope="col">Analyse</th>';
            $html .= '	  <th scope="col">Type de réesultat</th>';
            $html .= '	  <th scope="col">Options</th>';
            $html .= '	  <th scope="col">Unité</th>';
            $html .= '	  <th scope="col">Référence min</th>';
            $html .= '	  <th scope="col">Référence max</th>';
            $html .= '	  <th scope="col">Valeurs usuelles</th>';
            $html .= '	</tr>';
            $html .= '  </thead>';

            $html .= '  <tbody>';

            $indice = 0;
            foreach ($params as $param) {

                $nom_paramete = trim($param->nom_parametre) == "" ? "Non fournie" : $param->nom_parametre;
                $unite = trim($param->unite) == "" ? "Non fournie" : $param->unite;
                $valeurs = trim($param->valeurs) == "" ? "Non fournie" : $param->valeurs;
                $ref_low = trim($param->ref_low) == "" ? "Non fournie" : $param->ref_low;
                $ref_high = trim($param->ref_high) == "" ? "Non fournie" : $param->ref_high;
                $type = trim($param->type) == "" ? "Non fournie" : $param->type;
                $set_of_code = trim($param->set_of_code) == "" ? "Non fournie" : $param->set_of_code;

                if ($indice == 0) {
                    $html .= '    <tr>';
                    $html .= '  	<td scope="row" style="border-right: 2px solid #ddd !important;" id="description-' . $idPrestation . '" data-label="Description" rowspan="' . count($params) . '" class="edit00"><img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit00"/>' . $description . '</td>';
                    $html .= '  	<td scope="row" style="border-right: 2px solid #ddd !important;" id="keywords-' . $idPrestation . '" data-label="Mots-clés" rowspan="' . count($params) . '" class="edit01"><img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit01"/>' . $keywords . '</td>';
                    $html .= '  	<td data-label="Column 2" class="edit021" id="nomParam-' . $idPrestation . '-' . $param->idpara . '">' . $nom_paramete . '</td>';
                    $html .= '  	<td data-label="Column 2" class="edit021" id="nomParam-' . $idPrestation . '-' . $param->idpara . '">' . $type . '</td>';
                    $html .= '  	<td data-label="Column 2" class="edit021" id="nomParam-' . $idPrestation . '-' . $param->idpara . '">' . $set_of_code . '</td>';
                    $html .= '  	<td data-label="Column 3" class="edit022" id="unite-' . $idPrestation . '-' . $param->idpara . '">' . $unite . '</td>';
                    $html .= '  	<td data-label="Column 4" class="edit024" id="ref_low-' . $idPrestation . '-' . $param->idpara . '">' . $ref_low . '</td>';
                    $html .= '  	<td data-label="Column 4" class="edit025" id="ref_high-' . $idPrestation . '-' . $param->idpara . '">' . $ref_high . '</td>';
                    $html .= '  	<td data-label="Column 4" class="edit023" id="valeurs-' . $idPrestation . '-' . $param->idpara . '">' . $valeurs . '</td>';

                    $html .= '    </tr>';
                } else {
                    $html .= '    <tr>';
                    $html .= '  	<td data-label="Column 2" class="edit021" id="nomParam-' . $idPrestation . '-' . $param->idpara . '">' . $nom_paramete . '</td>';
                    $html .= '  	<td data-label="Column 2" class="edit021" id="nomParam-' . $idPrestation . '-' . $param->idpara . '">' . $type . '</td>';
                    $html .= '  	<td data-label="Column 2" class="edit021" id="nomParam-' . $idPrestation . '-' . $param->idpara . '">' . $set_of_code . '</td>';
                    $html .= '  	<td data-label="Column 3" class="edit022" id="unite-' . $idPrestation . '-' . $param->idpara . '">' . $unite . '</td>';
                    $html .= '  	<td data-label="Column 4" class="edit024" id="ref_low-' . $idPrestation . '-' . $param->idpara . '">' . $ref_low . '</td>';
                    $html .= '  	<td data-label="Column 4" class="edit025" id="ref_high-' . $idPrestation . '-' . $param->idpara . '">' . $ref_high . '</td>';
                    $html .= '  	<td data-label="Column 4" class="edit023" id="valeurs-' . $idPrestation . '-' . $param->idpara . '">' . $valeurs . '</td>';

                    $html .= '    </tr>';
                }
                $indice++;
            }
            $html .= '  </tbody>';
            $html .= '  </table>';
        } else {
            $html = '<div class="btn-group pull-right">';
            $html .= '<button id="editbtnsub" class="btn btn-primary editbtnsub"><i class="fas fa-edit"></i>&nbsp;Éditer</button>';
            $html .= '</div>';
            $html .= '<table class="details" data-id="' . $nomService . '@@@@' . $idPrestation . '">';
            $html .= '<thead>';
            $html .= '	<tr>';
            // $html .= '	  <th scope="col" rowspan="2" style="border-right: 2px solid #ddd !important;width:30% !important;">Description Prestation</th>';
            $html .= '	  <th scope="col" style="border-right: 2px solid #ddd !important;width:60% !important;">Description</th>';
            $html .= '	  <th scope="col" style="border-right: 2px solid #ddd !important;width:40% !important;">Mots-clés</th>';
            $html .= '	</tr>';
            $html .= '  </thead>';

            $html .= '  <tbody>';
            $html .= '    <tr>';
            $html .= '  	<td scope="row" style="border-right: 2px solid #ddd !important;" id="description-' . $idPrestation . '" data-label="Description" class="edit00"><img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit00"/>' . $description . '	</td>';
            $html .= '  	<td scope="row" style="border-right: 2px solid #ddd !important;" id="keywords-' . $idPrestation . '" data-label="Mots-clés" class="edit01"><img src="uploads/pen_2.png" style="width:12px;height:12px;margin-right:0.5em;" class="edit01"/>' . $keywords . '	</td>';
            $html .= '    </tr>';
            $html .= '  </tbody>';
            $html .= '  </table>';
        }




        $data["html"] = $html;
        echo json_encode($data);
    }

    function addPrestationForm()
    {
        $sid = $_POST['Service'];
        $speid = $_POST['Specialite'];
        $prestation = $_POST['Prestaion'];
        $keywords = $_POST['name'];
        $desc = $_POST['desc'];
        $cotation = $_POST['cotation'];
        $coefficient = $_POST['coefficient'];


        $record = $this->db->query("insert into payment_category(prestation,description,keywords,id_service,id_spe,cotation,coefficient) values('" . preg_replace('/\'/', "\\\'", $_POST['Prestaion']) . "','" . preg_replace('/\'/', "\\\'", $_POST['desc']) . "','" . preg_replace('/\'/', "\\\'", $_POST['name']) . "'," . $sid . "," . $speid . ", '" . preg_replace('/\'/', "\\\'", $_POST['cotation']) . "', '" . preg_replace('/\'/', "\\\'", $_POST['coefficient']) . "')");

        //    $this->db->query("insert into payment_category(prestation,description,keywords,id_service,id_spe, cotation, coefficient) values('" . preg_replace('/\'/', "\\\'", $_POST['Prestaion']) . "','" . preg_replace('/\'/', "\\\'", $_POST['desc']) . "','" . preg_replace('/\'/', "\\\'", $_POST['name']) . "'," . $sid . "," . $speid . ",'" . preg_replace('/\'/', "\\\'", $_POST['cotation']) . ")");

        $id = $this->db->insert_id();

        if (isset($_POST["new"])) {
            $paralistnew = $_POST["new"];
            foreach ($paralistnew as $obj) {
                $arr = array();
                foreach ($obj as $k => $v) {
                    array_push($arr, $v);
                };
                $type = preg_replace('/\'/', "\\\'", $arr[1]);
                if ($type == 'numerical') {
                    $this->db->query(
                        "insert into payment_category_parametre(
                            id_prestation, id_specialite,
                            nom_parametre,
                            type,
                            unite,
                            ref_low,
                            ref_high,
                            valeurs                           
                            ) values(" . $id . "," . $speid . ",'"
                            . preg_replace('/\'/', "\\\'", $arr[0]) . "','"
                            . preg_replace('/\'/', "\\\'", $arr[1]) . "','"
                            . preg_replace('/\'/', "\\\'", $arr[2]) . "','"
                            . preg_replace('/\'/', "\\\'", $arr[3]) . "','"
                            . preg_replace('/\'/', "\\\'", $arr[4]) . "','"
                            . preg_replace('/\'/', "\\\'", $arr[5]) . "')"
                    );
                } elseif ($type == 'setofcode') {
                    $this->db->query(
                        "insert into payment_category_parametre(
                            id_prestation, id_specialite,
                            nom_parametre,
                            type,
                            set_of_code,
                            valeurs                           
                            ) values(" . $id . "," . $speid . ",'"
                            . preg_replace('/\'/', "\\\'", $arr[0]) . "','"
                            . preg_replace('/\'/', "\\\'", $arr[1]) . "','"
                            . preg_replace('/\'/', "\\\'", $arr[2]) . "','"
                            . preg_replace('/\'/', "\\\'", $arr[3]) . "')"
                    );
                } elseif ($type == 'textcode') {
                    $this->db->query(
                        "insert into payment_category_parametre(
                            id_prestation, id_specialite,
                            nom_parametre,
                            type,
                            set_of_code,
                            valeurs                           
                            ) values(" . $id . "," . $speid . ",'"
                            . preg_replace('/\'/', "\\\'", $arr[0]) . "','"
                            . preg_replace('/\'/', "\\\'", $arr[1]) . "','"
                            . preg_replace('/\'/', "\\\'", $arr[2]) . "','"
                            . preg_replace('/\'/', "\\\'", $arr[3]) . "')"
                    );
                } elseif ($type == 'section') {
                    $this->db->query(
                        "insert into payment_category_parametre(
                            id_prestation, id_specialite,
                            nom_parametre,
                            type,
                            set_of_code,
                            valeurs                           
                            ) values(" . $id . "," . $speid . ",'"
                            . preg_replace('/\'/', "\\\'", $arr[0]) . "','"
                            . preg_replace('/\'/', "\\\'", $arr[1]) . "','"
                            . preg_replace('/\'/', "\\\'", $arr[2]) . "','"
                            . preg_replace('/\'/', "\\\'", $arr[3]) . "')"
                    );
                } elseif ($type == 'sous_section') {
                    $this->db->query(
                        "insert into payment_category_parametre(
                            id_prestation, id_specialite,
                            nom_parametre,
                            type,
                            set_of_code,
                            valeurs                           
                            ) values(" . $id . "," . $speid . ",'"
                            . preg_replace('/\'/', "\\\'", $arr[0]) . "','"
                            . preg_replace('/\'/', "\\\'", $arr[1]) . "','"
                            . preg_replace('/\'/', "\\\'", $arr[2]) . "','"
                            . preg_replace('/\'/', "\\\'", $arr[3]) . "')"
                    );
                }
            }
        }
    }

    function getServiceName()
    {
        $query = $this->db->query('select idservice,name_service,code_service from setting_service where code_service IN ("labo","MEDGEN")');


        echo json_encode($query->result_array());
    }

    public function getAllSpecialiteIdsAndNamesID()
    {
        // Search term
        $id = $this->input->get('id');
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->home_model->getAllSpecialiteIdsAndNames($searchTerm, $id);

        echo json_encode($response);
    }

    function getAllSpecialiteIdsAndNames()
    {
        $query = $this->db->query("select idspe,name_specialite from setting_service_specialite where id_service = '85'");
        echo json_encode($query->result());
    }

    function getPrestationDetails()
    {
        try {
            $idPrestation = $this->input->get('idPrestation');
            $typePrestation = $this->input->get('typePrestation');
            $nomPrestation = $this->input->get('nomPrestation');
            $nomService = $this->input->get('nomService');
            $speid = $this->input->get('specialiteid');
            $cotation = $this->input->get('cotation');
            $coefficient = $this->input->get('coefficient');
            $descriptionAndKeywords = $this->service_model->getSuperPrestationDescriptionAndKeywords($idPrestation);
            $description = trim($descriptionAndKeywords->description) == "" ? "Non fournie" : $descriptionAndKeywords->description;
            $keywords = trim($descriptionAndKeywords->keywords) == "" ? "Non fournie" : $descriptionAndKeywords->keywords;
            $cotation = trim($cotation) == "" ? "Non fournie" : $cotation;
            $coefficient = trim($coefficient) == "" ? "Non fournie" : $coefficient;
            if ($typePrestation == "Laboratoire" || $typePrestation == "Medecine générale") {
                $params = $this->service_model->getSuperPrestationParams($idPrestation);

                $obj = [$typePrestation, $description, $keywords, $params, $idPrestation, $speid, $nomPrestation, $cotation, $coefficient];
            } else
                $obj = [$typePrestation, $description, $keywords, $idPrestation, $speid, $cotation, $coefficient];

            echo json_encode($obj);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    function deletePrestationName()
    {
        // Check si le nom de la prestation existe déjà pour le service
        $idpara = $this->input->get('id');
        $query = $this->db->query("DELETE FROM payment_category_parametre WHERE idpara = " . $idpara)->num_rows();
        return "OK";
        // return $query->row();
    }

    function editPrestationDetailsForm()
    {
        try {

            if (isset($_POST['desc']) && isset($_POST['name'])) {
                $this->db->query("update payment_category set description = '" . preg_replace('/\'/', "\\\'", $_POST['desc']) . "', keywords = '" . preg_replace('/\'/', "\\\'", $_POST['name']) . "', cotation = '" . preg_replace('/\'/', "\\\'", $_POST['cotation']) . "', coefficient = '" . preg_replace('/\'/', "\\\'", $_POST['coefficient']) . "' where id = " . $_POST['preid'] . "");
            }

            if (isset($_POST['old'])) {
                $paralistold = $_POST["old"];
                $params = $this->service_model->getSuperPrestationParams($_POST['preid']);

                for ($i = 0; $i < count($params); $i++) {
                    $type = preg_replace('/\'/', "\\\'", $paralistold[$i]["type_p"]);
                    if ($type == 'numerical') {
                        if (isset($paralistold[$i]['idpara_p'])) {
                            $this->db->query("update payment_category_parametre set 
                                nom_parametre = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["nom_p"]) . "',
                                type = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["type_p"]) . "',
                                unite = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["unit_p"]) . "', 
                                ref_low = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["ref_low_p"]) . "', 
                                ref_high = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["ref_high_p"]) . "', 
                                valeurs = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["values_p"]) . "',
                                set_of_code = '' 
                                where idpara = " . $paralistold[$i]["idpara_p"] . " ");
                        } else {
                            $this->db->query("delete from payment_category_parametre where idpara = " . $params[$i]->idpara . " ");
                        }
                    } elseif ($type == 'setofcode') {
                        if (isset($paralistold[$i]['idpara_p'])) {
                            $this->db->query("update payment_category_parametre set 
                                nom_parametre = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["nom_p"]) . "',
                                type = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["type_p"]) . "',
                                unite = '', 
                                set_of_code = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["code_p"]) . "', 
                                valeurs = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["values_p"]) . "', 
                                ref_low = '', 
                                ref_high = ''
                                where idpara = " . $paralistold[$i]["idpara_p"] . " ");
                        } else {
                            $this->db->query("delete from payment_category_parametre where idpara = " . $params[$i]->idpara . " ");
                        }
                    } elseif ($type == 'textcode') {
                        if (isset($paralistold[$i]['idpara_p'])) {
                            $this->db->query("update payment_category_parametre set 
                                nom_parametre = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["nom_p"]) . "',
                                type = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["type_p"]) . "',
                                unite = '', 
                                set_of_code = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["code_p"]) . "', 
                                valeurs = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["values_p"]) . "', 
                                ref_low = '', 
                                ref_high = ''
                                where idpara = " . $paralistold[$i]["idpara_p"] . " ");
                        } else {
                            $this->db->query("delete from payment_category_parametre where idpara = " . $params[$i]->idpara . " ");
                        }
                    } elseif ($type == 'section') {
                        if (isset($paralistold[$i]['idpara_p'])) {
                            $this->db->query("update payment_category_parametre set 
                                nom_parametre = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["nom_p"]) . "',
                                type = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["type_p"]) . "',
                                unite = '', 
                                set_of_code = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["code_p"]) . "', 
                                valeurs = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["values_p"]) . "', 
                                ref_low = '', 
                                ref_high = ''
                                where idpara = " . $paralistold[$i]["idpara_p"] . " ");
                        } else {
                            $this->db->query("delete from payment_category_parametre where idpara = " . $params[$i]->idpara . " ");
                        }
                    } elseif ($type == 'sous_section') {
                        if (isset($paralistold[$i]['idpara_p'])) {
                            $this->db->query("update payment_category_parametre set 
                                nom_parametre = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["nom_p"]) . "',
                                type = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["type_p"]) . "',
                                unite = '', 
                                set_of_code = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["code_p"]) . "', 
                                valeurs = '" . preg_replace('/\'/', "\\\'", $paralistold[$i]["values_p"]) . "', 
                                ref_low = '', 
                                ref_high = ''
                                where idpara = " . $paralistold[$i]["idpara_p"] . " ");
                        } else {
                            $this->db->query("delete from payment_category_parametre where idpara = " . $params[$i]->idpara . " ");
                        }
                    }
                }
            }
            if (isset($_POST["new"])) {
                $paralistnew = $_POST["new"];

                foreach ($paralistnew as $obj) {
                    $arr = array();
                    foreach ($obj as $k => $v) {
                        array_push($arr, $v);
                    }
                    $type = preg_replace('/\'/', "\\\'", $arr[1]);
                    if ($type == 'numerical') {
                        $this->db->query(
                            "insert into payment_category_parametre(id_prestation,id_specialite,
                    nom_parametre,
                    type,
                    unite,
                    ref_low,
                    ref_high,
                    valeurs ) values(" . $_POST['preid'] . "," . $_POST['speid'] . ",'"
                                . preg_replace('/\'/', "\\\'", $arr[0]) . "','"
                                . preg_replace('/\'/', "\\\'", $arr[1]) . "','"
                                . preg_replace('/\'/', "\\\'", $arr[2]) . "','"
                                . preg_replace('/\'/', "\\\'", $arr[3]) . "','"
                                . preg_replace('/\'/', "\\\'", $arr[4]) . "','"
                                . preg_replace('/\'/', "\\\'", $arr[5]) . "')"
                        );
                    } elseif ($type == 'setofcode') {
                        $this->db->query(
                            "insert into payment_category_parametre(
                    id_prestation, id_specialite,
                    nom_parametre,
                    type,
                    set_of_code,
                    valeurs                           
                    ) values(" . $_POST['preid'] . "," . $_POST['speid'] . ",'"
                                . preg_replace('/\'/', "\\\'", $arr[0]) . "','"
                                . preg_replace('/\'/', "\\\'", $arr[1]) . "','"
                                . preg_replace('/\'/', "\\\'", $arr[2]) . "','"
                                . preg_replace('/\'/', "\\\'", $arr[3]) . "')"
                        );
                    } elseif ($type == 'textcode') {
                        $this->db->query(
                            "insert into payment_category_parametre(
                    id_prestation, id_specialite,
                    nom_parametre,
                    type,
                    set_of_code,
                    valeurs                           
                    ) values(" . $_POST['preid'] . "," . $_POST['speid'] . ",'"
                                . preg_replace('/\'/', "\\\'", $arr[0]) . "','"
                                . preg_replace('/\'/', "\\\'", $arr[1]) . "','"
                                . preg_replace('/\'/', "\\\'", $arr[2]) . "','"
                                . preg_replace('/\'/', "\\\'", $arr[3]) . "')"
                        );
                    } elseif ($type == 'section') {
                        $this->db->query(
                            "insert into payment_category_parametre(
                    id_prestation, id_specialite,
                    nom_parametre,
                    type,
                    set_of_code,
                    valeurs                           
                    ) values(" . $_POST['preid'] . "," . $_POST['speid'] . ",'"
                                . preg_replace('/\'/', "\\\'", $arr[0]) . "','"
                                . preg_replace('/\'/', "\\\'", $arr[1]) . "','"
                                . preg_replace('/\'/', "\\\'", $arr[2]) . "','"
                                . preg_replace('/\'/', "\\\'", $arr[3]) . "')"
                        );
                    } elseif ($type == 'sous_section') {
                        $this->db->query(
                            "insert into payment_category_parametre(
                    id_prestation, id_specialite,
                    nom_parametre,
                    type,
                    set_of_code,
                    valeurs                           
                    ) values(" . $_POST['preid'] . "," . $_POST['speid'] . ",'"
                                . preg_replace('/\'/', "\\\'", $arr[0]) . "','"
                                . preg_replace('/\'/', "\\\'", $arr[1]) . "','"
                                . preg_replace('/\'/', "\\\'", $arr[2]) . "','"
                                . preg_replace('/\'/', "\\\'", $arr[3]) . "')"
                        );
                    }
                }
            }
            $result = $this->service_model->getSuperPrestationParams($_POST['preid']);
            echo json_encode($result);
        } catch (Exception $e) {
            print_r('Caught exception: ',  $e->getMessage(), "\n");
        } catch (InvalidArgumentException $e) {
            print_r('Caught exception: ',  $e->getMessage(), "\n");
        }
    }

    function importPrestationInfo()
    {
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
                // SI OK
                $path = $_FILES["filename"]["tmp_name"];
                $tablename = $this->input->post('tablename');

                // $this->importPrestation($path, $tablename);
            } else {

                $this->session->set_flashdata('feedback', lang('wrong_file_format'));

                redirect('home/paymentCategory');
            }
        }
    }

    function importPrestation($file, $tablename)
    {
        $typeService = 'labo';
        $sqlService = $this->db->query("select idservice from setting_service  where code_service = \"" . $typeService . "\"");
        $idService = $sqlService->row()->idservice;
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
                $count_update = 0;
                $count_insert = 0;
                for ($row = 2; $row <= $highestRow; $row++) {
                    $rowData = [];
                    $rowData2 = [];

                    $tarif_public_ok = false;
                    $tarif_professionnel_ok = false;
                    $tarif_assurance_ok = false;

                    for ($column = 0; $column < $highestColumn; $column++) {
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Prestations') {
                            $nomPrestation = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Specialites') {
                            $nomService = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Parametres') {
                            $nomParametre = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Unite') {
                            $nomUnite = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Norme') {
                            $nomNorme = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Specialites' && $nomService) {

                            $sqlService = $this->db->query("select idspe from setting_service_specialite  where id_service = \"" . $idService . "\" and name_specialite = \"" . $nomService . "\"");
                            $sqlTab = $sqlService->num_rows();
                            if ($sqlTab != 0) {
                                $idSpe = $sqlService->row()->idspe;
                            } else {
                                $this->db->query("insert into setting_service_specialite(name_specialite,id_service) value(\"" . $nomService . "\",\"" . $idService . "\")");
                                $idSpe = $this->db->insert_id();
                            }
                            $rowData[] = $idSpe;
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Prestations' && $nomPrestation) {
                            $sqlPrestations = $this->db->query("select id from payment_category where prestation = \"" . $nomPrestation . "\"");
                            $sqlTab = $sqlPrestations->num_rows();
                            if ($sqlTab != 0) {
                                $idPrestations = $sqlPrestations->row()->id;
                            } else {

                                $this->db->query("insert into payment_category(prestation,id_service,id_spe) value(\"" . $nomPrestation . "\",\"" . $idService . "\",\"" . $idSpe . "\")");
                                $idPrestations = $this->db->insert_id();
                            }
                            $rowData[] = $idPrestations;
                        } else if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Parametres'  && $nomParametre) {
                            $rowData[] = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        } else if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Unite') {
                            $rowData[] = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        } else if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Norme') {
                            $rowData[] = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }
                    }

                    $rowData2 = array("id_specialite", "id_prestation", "nom_parametre", "unite", "valeurs");
                    $data = array_combine($rowData2, $rowData);

                    $sqlPara = $this->db->query("select idpara from payment_category_parametre where nom_parametre = \"" . $nomParametre . "\"");
                    $sqlTab = $sqlPara->num_rows();
                    if ($sqlTab != 0) {
                        $idPara = $sqlPara->row()->idpara;
                        $this->import_model->dataEntryUpdate($idPara, $data, 'payment_category_parametre');
                        $count_update++;
                    } else {
                        if ($nomParametre) {
                            $this->import_model->dataEntry($data, 'payment_category_parametre');
                            $count_insert++;
                        }
                    }
                }
                $message_parametre = $count_update . " mise(s) a jour <br/>" . $count_insert . " ajout(s)<br/>";
            } else {
                $this->session->set_flashdata('feedback', lang('wrong_file_format'));
            }
        }
        $this->session->set_flashdata('feedback', $message_parametre);
        redirect('home/paymentCategory');
    }

    function importServicesSpecialitesInfo()
    {

        // echo "<script language=\"javascript\">alert('Here I am');</script>";
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

            // $this->importServicesSpecialites($path, $tablename);
            if (in_array($_FILES['filename']['type'], $mimes) && in_array($extension, $allowedExts)) {
                // SI OK
                $path = $_FILES["filename"]["tmp_name"];
                // $tablename = $this->input->post('tablename');

                $this->importServicesSpecialites($path);
            } else {

                $this->session->set_flashdata('feedback', lang('wrong_file_format'));

                redirect('home/superservices');
            }
        }
    }


    function importTiersPayant()
    {

        // echo "<script language=\"javascript\">alert('Here I am');</script>";
        if (isset($_FILES["filenameLabo"]["name"])) {

            // Validation format
            $file_name = $_FILES['filenameLabo']['name'];

            $temp = explode(".", $_FILES["filenameLabo"]["name"]);
            $extension = end($temp);
            $mimes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            $allowedExts = ['xl', 'xls', 'xlsx'];
            // SI OK
            $path = $_FILES["filenameLabo"]["tmp_name"];
            $tablename = $this->input->post('tablename');

            // $this->importServicesSpecialites($path, $tablename);
            if (in_array($_FILES['filenameLabo']['type'], $mimes) && in_array($extension, $allowedExts)) {
                // SI OK
                $path = $_FILES["filenameLabo"]["tmp_name"];
                // $tablename = $this->input->post('tablename');

                $this->importTiersPayantFile($path);
            } else {

                $this->session->set_flashdata('feedback', lang('wrong_file_format'));

                redirect('home/superprestations');
            }
        }
    }


    function importPrestationsInfoLabo()
    {

        // echo "<script language=\"javascript\">alert('Here I am');</script>";
        if (isset($_FILES["filenameLabo"]["name"])) {

            // Validation format
            $file_name = $_FILES['filenameLabo']['name'];

            $temp = explode(".", $_FILES["filenameLabo"]["name"]);
            $extension = end($temp);
            $mimes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            $allowedExts = ['xl', 'xls', 'xlsx'];
            // SI OK
            $path = $_FILES["filenameLabo"]["tmp_name"];
            $tablename = $this->input->post('tablename');

            // $this->importServicesSpecialites($path, $tablename);
            if (in_array($_FILES['filenameLabo']['type'], $mimes) && in_array($extension, $allowedExts)) {
                // SI OK
                $path = $_FILES["filenameLabo"]["tmp_name"];
                // $tablename = $this->input->post('tablename');

                $this->importPrestationsLabo($path);
            } else {

                $this->session->set_flashdata('feedback', lang('wrong_file_format'));

                redirect('home/superprestations');
            }
        }
    }

    function importMaladie()
    {

        // echo "<script language=\"javascript\">alert('Here I am');</script>";
        if (isset($_FILES["filenameLabo"]["name"])) {

            // Validation format
            $file_name = $_FILES['filenameLabo']['name'];

            $temp = explode(".", $_FILES["filenameLabo"]["name"]);
            $extension = end($temp);
            $mimes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            $allowedExts = ['xl', 'xls', 'xlsx'];
            // SI OK
            $path = $_FILES["filenameLabo"]["tmp_name"];
            $tablename = $this->input->post('tablename');

            // $this->importServicesSpecialites($path, $tablename);
            if (in_array($_FILES['filenameLabo']['type'], $mimes) && in_array($extension, $allowedExts)) {
                // SI OK
                $path = $_FILES["filenameLabo"]["tmp_name"];
                // $tablename = $this->input->post('tablename');

                $this->importPrestationsMaladie($path);
            } else {

                $this->session->set_flashdata('feedback', lang('wrong_file_format'));

                redirect('home/templateMaladie');
            }
        }
    }

    function importPrestationsInfoPanier()
    {

        if (isset($_FILES["filenamePanier"]["name"])) {

            // Validation format
            $file_name = $_FILES['filenamePanier']['name'];

            $temp = explode(".", $_FILES["filenamePanier"]["name"]);
            $extension = end($temp);
            $mimes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            $allowedExts = ['xl', 'xls', 'xlsx'];
            // SI OK
            $path = $_FILES["filenamePanier"]["tmp_name"];
            $tablename = $this->input->post('tablename');

            // $this->importServicesSpecialites($path, $tablename);
            if (in_array($_FILES['filenamePanier']['type'], $mimes) && in_array($extension, $allowedExts)) {
                // SI OK
                $path = $_FILES["filenamePanier"]["tmp_name"];
                // $tablename = $this->input->post('tablename');

                // echo "<script language=\"javascript\">alert('".$path."');</script>";
                $this->importPrestationsPanier($path);
            } else {

                $this->session->set_flashdata('feedback', lang('wrong_file_format'));

                redirect('finance/paymentCategoryPanier');
            }
        }
    }

    function importPrestationsInfoAutres()
    {

        // echo "<script language=\"javascript\">alert('Here I am');</script>";
        if (isset($_FILES["filenameAutres"]["name"])) {

            // Validation format
            $file_name = $_FILES['filenameAutres']['name'];

            $temp = explode(".", $_FILES["filenameAutres"]["name"]);
            $extension = end($temp);
            $mimes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            $allowedExts = ['xl', 'xls', 'xlsx'];
            // SI OK
            $path = $_FILES["filenameAutres"]["tmp_name"];
            $tablename = $this->input->post('tablename');

            // $this->importServicesSpecialites($path, $tablename);
            if (in_array($_FILES['filenameAutres']['type'], $mimes) && in_array($extension, $allowedExts)) {
                // SI OK
                $path = $_FILES["filenameAutres"]["tmp_name"];
                // $tablename = $this->input->post('tablename');

                $this->importPrestationsAutres($path);
            } else {

                $this->session->set_flashdata('feedback', lang('wrong_file_format'));

                redirect('home/superprestations');
            }
        }
    }

    function importServicesSpecialites($file)
    {
        $object = PHPExcel_IOFactory::load($file);

        // echo "<script language=\"javascript\">alert('Here I am 2');</script>";
        foreach ($object->getWorksheetIterator() as $worksheet) {
            // echo "<script language=\"javascript\">alert('Here I am 2.2');</script>";
            $highestRow = $worksheet->getHighestDataRow();    //get Highest Row
            // echo "<script language=\"javascript\">alert('Here I am 2.3');</script>";
            $highestColumnLetter = $worksheet->getHighestDataColumn(); //get column highest as  letter
            // echo "<script language=\"javascript\">alert('Here I am 2.4');</script>";
            $highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumnLetter); // convert letter to column index in number
            // echo "<script language=\"javascript\">alert('Here I am 2.5');</script>";
            for ($column1 = 0; $column1 < $highestColumn; $column1++) {

                // echo "<script language=\"javascript\">alert('Here I am 2.6');</script>";
                $rowData1[] = $worksheet->getCellByColumnAndRow($column1, 1)->getValue();
                // echo "<script language=\"javascript\">alert('".$worksheet->getCellByColumnAndRow($column1, 1)->getValue()."');</script>";
                // echo "<script language=\"javascript\">alert('Here I am 2.7');</script>";
            }


            $headerexist = $this->import_model->headerExistForGenericServicesSpecialites($rowData1); // get boolean header exist or not

            // echo "<script language=\"javascript\">alert('Here I am 2.8');</script>";

            // echo "<script language=\"javascript\">alert('Here I am 3');</script>";
            if ($headerexist) {

                $exist_name = [];
                $exist_name2 = [];
                // $erreur_tarifs = [];

                $exist_rows = "";
                $exist_rows2 = "";
                // $erreur_tarifs_rows = "";

                $message2 = "";

                // echo "<script language=\"javascript\">alert('Here I am 4');</script>";
                for ($row = 2; $row <= $highestRow; $row++) {

                    // echo "<script language=\"javascript\">alert('Here I am 5');</script>";
                    $rowData = [];
                    $rowData2 = [];

                    $nomService = "";
                    $nomSpecialite = "";

                    $serviceExiste;
                    $specialiteExiste;
                    // $tarif_public_ok = false;
                    // $tarif_professionnel_ok = false;
                    // $tarif_assurance_ok = false;

                    for ($column = 0; $column < $highestColumn; $column++) {

                        // echo "<script language=\"javascript\">alert('Here I am 6');</script>";
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Service') {
                            $nomService = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Spécialité') {
                            $nomSpecialite = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Service') { // Cas Service: Fetch ID Service

                            $serviceExiste = $this->db->query("select idservice from setting_service where name_service = \"" . $nomService . "\" and id_organisation is NULL")->num_rows();

                            // echo "<script language=\"javascript\">alert('".$serviceExiste."');</script>";
                            if (!$serviceExiste) {
                                $code_service = strpos(" " . $nomService, "Laboratoire") ? "labo" : ""; // Extra " " pour eviter confusion entre false et strpos 0 si en debut de haystack

                                // echo "<script language=\"javascript\">alert('".$nomService."');</script>";
                                // echo "<script language=\"javascript\">alert('".$code_service."');</script>";
                                $this->db->query("insert into setting_service (name_service, status_service, code_service) VALUES(\"" . $nomService . "\", 1, \"" . $code_service . "\")");
                            }

                            // echo "<script language=\"javascript\">alert('".$this->db->insert_id()."');</script>";
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Spécialité') { // Cas Service: Fetch ID Service


                            // echo "<script language=\"javascript\">alert('Colonne Spe before');</script>";
                            // echo "<script language=\"javascript\">alert('".$nomService."');</script>";
                            // echo "<script language=\"javascript\">alert('".$nomSpecialite."');</script>";

                            $specialiteExiste = $this->db->query("select idspe from setting_service_specialite join setting_service on setting_service.idservice = setting_service_specialite.id_service and setting_service.name_service = \"" . $nomService . "\" and setting_service.id_organisation is NULL and setting_service_specialite.name_specialite=\"" . $nomSpecialite . "\"")->num_rows();




                            if (!$specialiteExiste) {
                                $id_service = $this->db->query("select idservice from setting_service where name_service = \"" . $worksheet->getCellByColumnAndRow($column - 1, $row)->getCalculatedValue() . "\" and id_organisation is NULL")->row()->idservice;
                                $this->db->query("insert into setting_service_specialite (name_specialite, id_service) VALUES(\"" . $nomSpecialite . "\", " . $id_service . ")");


                                // echo "<script language=\"javascript\">alert('".$this->db->insert_id()."');</script>";
                            }
                        }
                        // elseif ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Spécialité') { // Cas Service: Fetch ID Service
                        // $rowData[] = $this->db->query("select idspe from setting_service_specialite join setting_service on setting_service_specialite.id_service = setting_service.idservice and setting_service_specialite.id_service = ".."where name_service = '" . $nomService . "'")->num_rows() != 0 ? $this->db->query("select idservice from setting_service where name_service = '" . $nomService . "'")->row()->idservice : null;
                        // } 
                        // else {
                        // if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Tarif Public') { // Cas Tarifs: Remove Dots '.'
                        // $tarif = str_replace(".", "", $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue());
                        // $tarif = str_replace(",", "", $tarif); // Cas Excel Local Client avec "," comme separateur milliers
                        // $tarif = str_replace(" ", "", $tarif); // Cas Excel Local Client avec " " comme separateur milliers
                        // $rowData[] = $tarif;
                        // if ($tarif >= "1000" && $tarif <= "100000") {
                        // $tarif_public_ok = true;
                        // }
                        // } else if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Tarif Professionnel') { // Cas Tarifs: Remove Dots '.'
                        // $tarif = str_replace(".", "", $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue());
                        // $tarif = str_replace(",", "", $tarif); // Cas Excel Local Client avec "," comme separateur milliers
                        // $tarif = str_replace(" ", "", $tarif); // Cas Excel Local Client avec " " comme separateur milliers
                        // $rowData[] = $tarif;
                        // if ($tarif >= "1000" && $tarif <= "100000") {
                        // $tarif_professionnel_ok = true;
                        // }
                        // } else if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Tarif Assurance') { // Cas Tarifs: Remove Dots '.'
                        // $tarif = str_replace(".", "", $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue());
                        // $tarif = str_replace(",", "", $tarif); // Cas Excel Local Client avec "," comme separateur milliers
                        // $tarif = str_replace(" ", "", $tarif); // Cas Excel Local Client avec " " comme separateur milliers
                        // $rowData[] = $tarif;
                        // if ($tarif >= "1000" && $tarif <= "100000") {
                        // $tarif_assurance_ok = true;
                        // }
                        // } 
                        // else {
                        // $rowData[] = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        // }
                        // }
                    }

                    // $prestationExiste = 0;
                    // $prestationExiste = $this->db->query("select payment_category.id from payment_category join setting_service on (payment_category.id_service = setting_service.idservice and setting_service.name_service = '" . $nomService . "' and payment_category.prestation ='" . $nomPrestation . "') join department on department.id = setting_service.id_department and department.id_organisation = ".$this->id_organisation)->num_rows();
                    // $serviceExiste = $this->db->query("select idservice from setting_service  join department on department.id = setting_service.id_department and department.id_organisation = ".$this->id_organisation." where name_service = '" . $nomService . "'")->num_rows();

                    // if ($serviceExiste) { // Si prestation existante (meme service / mme prestation): refus
                    // $exist_name[] = $row;
                    // $exist_rows = implode(',', $exist_name);
                    // } 
                    if ($specialiteExiste) { // Si Service non existant: refus
                        $exist_name2[] = $row;
                        $exist_rows2 = implode(',', $exist_name2);
                    }
                    // if (!$tarif_public_ok || !$tarif_assurance_ok || !$tarif_professionnel_ok) { // Si Service non existant: refus
                    // $erreur_tarifs[] = $row;
                    // $erreur_tarifs_rows = implode(',', $erreur_tarifs);
                    // }
                    // if (!$prestationExiste && $serviceExiste && $tarif_public_ok && $tarif_assurance_ok && $tarif_professionnel_ok) {
                    // array_push($rowData, date('d/m/y'));
                    // array_push($rowData2, 'add_date');
                    // $rowData2 = array("id_service", "prestation", "description", "tarif_public", "tarif_professionnel", "tarif_assurance");
                    // $data = array_combine($rowData2, $rowData);

                    // $this->import_model->dataEntry($data, $tablename);
                    // $this->import_model->dataEntryPrestation($data);
                    // }
                }

                $verbe_exist_name = count($exist_name) > 1 ? "contiennent" : "contient";
                $verbe_exist_name2 = count($exist_name2) > 1 ? "contiennent" : "contient";
                // $verbe_erreur_tarifs = count($erreur_tarifs) > 1 ? "contiennent" : "contient";

                $message2 .= count($exist_name) ? 'Lignes numéro ' . $exist_rows . ' ' . $verbe_exist_name . ' un service déjà existant!' . "<br/>" : "";
                $message2 .= count($exist_name2) ? "Lignes numéro " . $exist_rows2 . " " . $verbe_exist_name2 . " une spécialité déjà existante!" . "<br/>" : "";
                // $message2 .= count($erreur_tarifs) ? "Lignes numéro " . $erreur_tarifs_rows . " " . $verbe_erreur_tarifs . " un tarif non compris entre 1.000 et 100.000 Fcfa!" . "<br/>" : "";

                $count_errors = count($exist_name) + count($exist_name2);
                $import_error_label = $count_errors ? "erreurs" : "erreur";
                $import_status_label = !$count_errors ? lang('successful_data_import') : lang('successful_data_import_with_errors');
                // $import_status_label = lang('successful_data_import');
                $this->session->set_flashdata('feedback', $import_status_label . " " . $count_errors . " " . $import_error_label);
                // $this->session->set_flashdata('feedback', $import_status_label);
                $this->session->set_flashdata('message2', $message2);
            } else {
                $this->session->set_flashdata('feedback', lang('wrong_file_format'));
            }

            // echo "<script language=\"javascript\">alert('End of Row ".$row."');</script>";
        }

        // echo "<script language=\"javascript\">alert('About to head out');</script>";
        redirect('home/superservices');

        // echo "<script language=\"javascript\">alert('out');</script>";
    }


    function importTiersPayantFile($file)
    {
        $object = PHPExcel_IOFactory::load($file);
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestDataRow();    //get Highest Row
            $highestColumnLetter = $worksheet->getHighestDataColumn(); //get column highest as  letter
            $highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumnLetter); // convert letter to column index in number
            for ($column1 = 0; $column1 < $highestColumn; $column1++) {
                $rowData1[] = $worksheet->getCellByColumnAndRow($column1, 1)->getCalculatedValue();
            }


            $headerexist = $this->import_model->headerExistForGenericTiersPayant($rowData1); // get boolean header exist or not

            if ($headerexist) {

                $missing_name = [];
                $missing_name2 = [];
                $exist_name = [];
                $exist_name2 = [];
                // $erreur_tarifs = [];

                $missing_rows = "";
                $missing_rows2 = "";
                $exist_rows = "";
                $exist_rows2 = "";
                // $erreur_tarifs_rows = "";

                $message2 = "";

                $nomPrestationBuff = "";
                for ($row = 2; $row <= $highestRow; $row++) {

                    $rowData = [];
                    $rowData2 = [];

                    $id = "";
                    $prestation = "";
                    $nomenclature_prestation = "";
                    $code_prestation = "";
                    $cotation = "";
                    $coefficient = "";

                    for ($column = 0; $column < $highestColumn; $column++) {

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'id') {
                            $id = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'prestation') {
                            $prestation = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'nomenclature_prestation') {
                            $nomenclature_prestation = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'code_prestation') {
                            $code_prestation = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'cotation') {
                            $cotation = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'coefficient') {
                            $coefficient = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'id') { // Cas Service: Fetch ID Service

                            $serviceExiste = $this->db->query("select id from payment_category where id = \"" . $id . "\" ");
                            if ($serviceExiste) {

                                $this->db->query("UPDATE payment_category SET code_prestation = \"" . $worksheet->getCellByColumnAndRow($column + 3, $row)->getCalculatedValue() . "\", cotation = \"" . $worksheet->getCellByColumnAndRow($column + 4, $row)->getCalculatedValue() . "\" , nomenclature_prestation = \"" . $worksheet->getCellByColumnAndRow($column + 2, $row)->getCalculatedValue() . "\", coefficient = \"" . $worksheet->getCellByColumnAndRow($column + 5, $row)->getCalculatedValue() . "\" WHERE payment_category.id = \"" .  $id . "\" ");
                                //    $this->db->query("update payment_category set nomenclature_prestation = \"" . $nomenclature_prestation . "\", code_prestation = \"" . $code_prestation . "\" , cotation = \"" . $cotation . "\"  where payment_category.id = " . $id);
                            }

                            if (!$serviceExiste) {

                                break;
                            }
                        }
                    }
                }
                $verbe_missing_name = count($missing_name) > 1 ? "contiennent" : "contient";
                $verbe_missing_name2 = count($missing_name2) > 1 ? "contiennent" : "contient";
                // $verbe_erreur_tarifs = count($erreur_tarifs) > 1 ? "contiennent" : "contient";

                $message2 .= count($missing_name) ? 'Lignes numéro ' . $missing_rows . ' ' . $verbe_missing_name . ' un service non existant!' . "<br/>" : "";
                $message2 .= count($missing_name2) ? "Lignes numéro " . $missing_rows2 . " " . $verbe_missing_name2 . " une spécialité non existante!" . "<br/>" : "";
                // $message2 .= count($erreur_tarifs) ? "Lignes numéro " . $erreur_tarifs_rows . " " . $verbe_erreur_tarifs . " un tarif non compris entre 1.000 et 100.000 Fcfa!" . "<br/>" : "";

                $count_errors = count($missing_name) + count($missing_name2);
                $import_error_label = $count_errors ? "erreurs" : "erreur";
                $import_status_label = !$count_errors ? lang('successful_data_import') : lang('successful_data_import_with_errors');
                // $import_status_label = lang('successful_data_import');
                $this->session->set_flashdata('feedback', $import_status_label . " " . $count_errors . " " . $import_error_label);
                // $this->session->set_flashdata('feedback', $import_status_label);
                $this->session->set_flashdata('message2', $message2);
            } else {
                $this->session->set_flashdata('feedback', lang('wrong_file_format'));
            }

            // echo "<script language=\"javascript\">alert('End of Row ".$row."');</script>";
        }

        // echo "<script language=\"javascript\">alert('About to head out');</script>";
        redirect('home/superprestations');

        // echo "<script language=\"javascript\">alert('".print_r($missing_name)."');</script>";
        // echo "<script language=\"javascript\">alert('".print_r($missing_name2)."');</script>";
        // echo "<script language=\"javascript\">alert('out');</script>";
    }

    function importPrestationsLabo($file)
    {
        $object = PHPExcel_IOFactory::load($file);
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestDataRow();    //get Highest Row
            $highestColumnLetter = $worksheet->getHighestDataColumn(); //get column highest as  letter
            $highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumnLetter); // convert letter to column index in number
            for ($column1 = 0; $column1 < $highestColumn; $column1++) {
                $rowData1[] = $worksheet->getCellByColumnAndRow($column1, 1)->getCalculatedValue();
            }


            $headerexist = $this->import_model->headerExistForGenericPrestationsLabo($rowData1); // get boolean header exist or not

            if ($headerexist) {

                $missing_name = [];
                $missing_name2 = [];
                $exist_name = [];
                $exist_name2 = [];
                // $erreur_tarifs = [];

                $missing_rows = "";
                $missing_rows2 = "";
                $exist_rows = "";
                $exist_rows2 = "";
                // $erreur_tarifs_rows = "";

                $message2 = "";

                $nomPrestationBuff = "";
                for ($row = 2; $row <= $highestRow; $row++) {

                    $rowData = [];
                    $rowData2 = [];

                    $nomService = "";
                    $nomSpecialite = "";
                    $nomPrestation = "";
                    $machine = "";
                    $prelevement = "";
                    $methode = "";
                    $cotation = "";
                    $coefficient = "";
                    $description = "";
                    $keywords = "";
                    $nomParametre = "";
                    $unite = "";
                    $norme = "";
                    $alias = "";
                    $code = "";
                    $unite_secondaire = "";

                    $id_service = "";
                    $id_spe = "";
                    $id_prestation = "";
                    $id_parametre = "";

                    $serviceExiste;
                    $specialiteExiste;
                    $prestationExiste;
                    $parametreExiste;
                    // $tarif_public_ok = false;
                    // $tarif_professionnel_ok = false;
                    // $tarif_assurance_ok = false;

                    for ($column = 0; $column < $highestColumn; $column++) {

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Service') {
                            $nomService = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Spécialité') {
                            $nomSpecialite = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Prestation') {
                            $nomPrestation = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Machine') {
                            $machine = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Prelevement') {
                            $prelevement = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Methode') {
                            $methode = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Cotation') {
                            $methode = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Coefficient') {
                            $methode = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Description') {
                            $description = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Mots-clés') {
                            $keywords = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Paramètres') {
                            $nomParametre = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Unité') {
                            $unite = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Norme') {
                            $norme = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Alias') {
                            $alias = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Code') {
                            $code = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Unite Secondaire') {
                            $unite_secondaire = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Service') { // Cas Service: Fetch ID Service

                            $serviceExiste = $this->db->query("select idservice from setting_service where name_service = \"" . $nomService . "\" and id_organisation is NULL")->num_rows();


                            // echo "<script language=\"javascript\">alert(\"".$nomService."\");</script>";
                            if (!$serviceExiste) {

                                // echo "<script language=\"javascript\">alert(\"".$nomService." n'existe pas! \");</script>";
                                break;
                            }
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Spécialité') { // Cas Service: Fetch ID Service
                            $specialiteExiste = $this->db->query("select idspe from setting_service_specialite join setting_service on setting_service.idservice = setting_service_specialite.id_service and setting_service.name_service = \"" . $nomService . "\" and setting_service.id_organisation is NULL and setting_service_specialite.name_specialite=\"" . $nomSpecialite . "\"")->num_rows();


                            // echo "<script language=\"javascript\">alert(\"".$nomSpecialite."\");</script>";

                            if (!$specialiteExiste && trim($nomSpecialite) != "") {

                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." n'existe pas! \");</script>";
                                break;
                            }
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Prestation') { // Cas Service: Fetch ID Service
                            $prestationExiste = $this->db->query("select id from payment_category join setting_service on setting_service.idservice = payment_category.id_service and setting_service.name_service = \"" . $nomService . "\" and setting_service.id_organisation is NULL and payment_category.prestation=\"" . $nomPrestation . "\"")->num_rows();


                            // echo "<script language=\"javascript\">alert(\"".$nomPrestation."\");</script>";
                            if ($prestationExiste) {
                                // Do nothing else but get id_prestation

                                // echo "<script language=\"javascript\">alert(\"".$nomPrestation." existe! \");</script>";

                                $id_prestation = $this->db->query("select id from payment_category join setting_service on setting_service.idservice = payment_category.id_service and setting_service.name_service = \"" . $nomService . "\" and setting_service.id_organisation is NULL and payment_category.prestation=\"" . $nomPrestation . "\"")->row()->id;

                                $id_service = $this->db->query("select idservice from setting_service where name_service = \"" . $worksheet->getCellByColumnAndRow($column - 2, $row)->getCalculatedValue() . "\" and id_organisation is NULL")->row()->idservice;
                                $id_spe = $this->db->query("select (CASE WHEN `setting_service_specialite`.idspe IS NOT NULL THEN (SELECT `setting_service_specialite`.idspe) ELSE (SELECT '') END) as idspe from setting_service_specialite join setting_service on setting_service.idservice = setting_service_specialite.id_service and setting_service.idservice = " . $id_service . "  and id_organisation is NULL where name_specialite = \"" . $worksheet->getCellByColumnAndRow($column - 1, $row)->getCalculatedValue() . "\"")->row()->idspe;

                                // Mise à jour (description & keywords)

                                $this->db->query("update payment_category set machine = \"" . $worksheet->getCellByColumnAndRow($column + 1, $row)->getCalculatedValue() . "\", prelevement = \"" . $worksheet->getCellByColumnAndRow($column + 2, $row)->getCalculatedValue() . "\", method = \"" . $worksheet->getCellByColumnAndRow($column + 3, $row)->getCalculatedValue() . "\", cotation = \"" . $worksheet->getCellByColumnAndRow($column + 4, $row)->getCalculatedValue() . "\",  coefficient = \"" . $worksheet->getCellByColumnAndRow($column + 5, $row)->getCalculatedValue() . "\" ,  description = \"" . $worksheet->getCellByColumnAndRow($column + 6, $row)->getCalculatedValue() . "\" ,  keywords = \"" . $worksheet->getCellByColumnAndRow($column + 7, $row)->getCalculatedValue() . "\" where payment_category.id = " . $id_prestation . "");
                            } else { // Sinon, on insere


                                // echo "<script language=\"javascript\">alert(\"".$nomPrestation." n'existe pas! \");</script>";

                                $id_service = $this->db->query("select idservice from setting_service where name_service = \"" . $worksheet->getCellByColumnAndRow($column - 2, $row)->getCalculatedValue() . "\" and id_organisation is NULL")->row()->idservice;
                                $id_spe = $this->db->query("select (CASE WHEN `setting_service_specialite`.idspe IS NOT NULL THEN (SELECT `setting_service_specialite`.idspe) ELSE (SELECT '') END) as idspe from setting_service_specialite join setting_service on setting_service.idservice = setting_service_specialite.id_service and setting_service.idservice = " . $id_service . "  and id_organisation is NULL where name_specialite = \"" . $worksheet->getCellByColumnAndRow($column - 1, $row)->getCalculatedValue() . "\"")->row()->idspe;

                                $this->db->query("insert into payment_category (prestation, machine, prelevement, method, cotation, coefficient, description, keywords, id_service, id_spe ) VALUES(\"" . $nomPrestation . "\",\"" . $worksheet->getCellByColumnAndRow($column + 1, $row)->getCalculatedValue() . "\",\"" . $worksheet->getCellByColumnAndRow($column + 2, $row)->getCalculatedValue() . "\",\"" .  $worksheet->getCellByColumnAndRow($column + 3, $row)->getCalculatedValue() . "\",\"" .  $worksheet->getCellByColumnAndRow($column + 4, $row)->getCalculatedValue() . "\",\"" .  $worksheet->getCellByColumnAndRow($column + 5, $row)->getCalculatedValue() . "\",\"" . $worksheet->getCellByColumnAndRow($column + 6, $row)->getCalculatedValue() . "\",\"" . $worksheet->getCellByColumnAndRow($column + 7, $row)->getCalculatedValue() . "\",\"" . $id_service . "\",\"" . $id_spe . "\")");
                                $id_prestation = $this->db->insert_id();
                            }
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Paramètres') { // Cas Service: Fetch ID Service

                            $parametreExiste = $this->db->query("select idpara from payment_category_parametre join payment_category on payment_category.id = payment_category_parametre.id_prestation and payment_category.id = " . $id_prestation . " join setting_service_specialite on setting_service_specialite.idspe = payment_category_parametre.id_specialite and setting_service_specialite.idspe = " . $id_spe . " where payment_category_parametre.nom_parametre =\"" . $nomParametre . "\"")->num_rows();


                            // echo "<script language=\"javascript\">alert(\"S k Parametre existe: ".$parametreExiste."\");</script>";

                            if ($parametreExiste) {
                                // Update Unite / Valeurs

                                // echo "<script language=\"javascript\">alert(\"".$nomParametre." existe! \");</script>";

                                $id_parametre = $this->db->query("select idpara from payment_category_parametre join payment_category on payment_category.id = payment_category_parametre.id_prestation and payment_category.id = " . $id_prestation . " join setting_service_specialite on setting_service_specialite.idspe = payment_category_parametre.id_specialite and setting_service_specialite.idspe = " . $id_spe . " where payment_category_parametre.nom_parametre =\"" . $nomParametre . "\"")->row()->idpara;


                                // echo "<script language=\"javascript\">alert(\"Id Parametre: ".$id_parametre."\");</script>";

                                $this->db->query("update payment_category_parametre set unite=\"" . $worksheet->getCellByColumnAndRow($column + 1, $row)->getCalculatedValue() . "\", valeurs=\"" . $worksheet->getCellByColumnAndRow($column + 2, $row)->getCalculatedValue() . "\", alias=\"" . $worksheet->getCellByColumnAndRow($column + 3, $row)->getCalculatedValue() . "\", code=\"" . $worksheet->getCellByColumnAndRow($column + 4, $row)->getCalculatedValue() . "\", unit_second=\"" . $worksheet->getCellByColumnAndRow($column + 5, $row)->getCalculatedValue() . "\" , type=\"" . $worksheet->getCellByColumnAndRow($column + 6, $row)->getCalculatedValue() . "\" , set_of_code=\"" . $worksheet->getCellByColumnAndRow($column + 7, $row)->getCalculatedValue() . "\"  , ref_low=\"" . $worksheet->getCellByColumnAndRow($column + 8, $row)->getCalculatedValue() . "\" , ref_high=\"" . $worksheet->getCellByColumnAndRow($column + 9, $row)->getCalculatedValue() . "\" where idpara = " . $id_parametre);


                                // echo "<script language=\"javascript\">alert(\"Id Parametre: ".$id_parametre."\");</script>";
                            } else { // Sinon, on insere	


                                $this->db->query("insert into payment_category_parametre (id_prestation, id_specialite, nom_parametre, unite, valeurs, alias, code, unit_second, type, set_of_code, ref_low, ref_high) VALUES(" . $id_prestation . "," . $id_spe . ", \"" . $nomParametre . "\", \"" . $worksheet->getCellByColumnAndRow($column + 1, $row)->getCalculatedValue() . "\", \"" . $worksheet->getCellByColumnAndRow($column + 2, $row)->getCalculatedValue() . "\", \"" . $worksheet->getCellByColumnAndRow($column + 3, $row)->getCalculatedValue() . "\",  \"" . $worksheet->getCellByColumnAndRow($column + 4, $row)->getCalculatedValue() . "\",  \"" . $worksheet->getCellByColumnAndRow($column + 5, $row)->getCalculatedValue() . "\",  \"" . $worksheet->getCellByColumnAndRow($column + 6, $row)->getCalculatedValue() . "\",  \"" . $worksheet->getCellByColumnAndRow($column + 7, $row)->getCalculatedValue() . "\",  \"" . $worksheet->getCellByColumnAndRow($column + 8, $row)->getCalculatedValue() . "\",  \"" . $worksheet->getCellByColumnAndRow($column + 9, $row)->getCalculatedValue() . "\")");

                                $id_parametre = $this->db->insert_id();

                                // echo "<script language=\"javascript\">alert(\"Id Parametre: ".$id_parametre."\");</script>";
                            }
                        }
                        // elseif ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Spécialité') { // Cas Service: Fetch ID Service
                        // $rowData[] = $this->db->query("select idspe from setting_service_specialite join setting_service on setting_service_specialite.id_service = setting_service.idservice and setting_service_specialite.id_service = ".."where name_service = '" . $nomService . "'")->num_rows() != 0 ? $this->db->query("select idservice from setting_service where name_service = '" . $nomService . "'")->row()->idservice : null;
                        // } 
                        // else {
                        // if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Tarif Public') { // Cas Tarifs: Remove Dots '.'
                        // $tarif = str_replace(".", "", $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue());
                        // $tarif = str_replace(",", "", $tarif); // Cas Excel Local Client avec "," comme separateur milliers
                        // $tarif = str_replace(" ", "", $tarif); // Cas Excel Local Client avec " " comme separateur milliers
                        // $rowData[] = $tarif;
                        // if ($tarif >= "1000" && $tarif <= "100000") {
                        // $tarif_public_ok = true;
                        // }
                        // } else if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Tarif Professionnel') { // Cas Tarifs: Remove Dots '.'
                        // $tarif = str_replace(".", "", $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue());
                        // $tarif = str_replace(",", "", $tarif); // Cas Excel Local Client avec "," comme separateur milliers
                        // $tarif = str_replace(" ", "", $tarif); // Cas Excel Local Client avec " " comme separateur milliers
                        // $rowData[] = $tarif;
                        // if ($tarif >= "1000" && $tarif <= "100000") {
                        // $tarif_professionnel_ok = true;
                        // }
                        // } else if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Tarif Assurance') { // Cas Tarifs: Remove Dots '.'
                        // $tarif = str_replace(".", "", $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue());
                        // $tarif = str_replace(",", "", $tarif); // Cas Excel Local Client avec "," comme separateur milliers
                        // $tarif = str_replace(" ", "", $tarif); // Cas Excel Local Client avec " " comme separateur milliers
                        // $rowData[] = $tarif;
                        // if ($tarif >= "1000" && $tarif <= "100000") {
                        // $tarif_assurance_ok = true;
                        // }
                        // } 
                        // else {
                        // $rowData[] = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        // }
                        // }
                    }

                    // $prestationExiste = 0;
                    // $prestationExiste = $this->db->query("select payment_category.id from payment_category join setting_service on (payment_category.id_service = setting_service.idservice and setting_service.name_service = '" . $nomService . "' and payment_category.prestation ='" . $nomPrestation . "') join department on department.id = setting_service.id_department and department.id_organisation = ".$this->id_organisation)->num_rows();
                    // $serviceExiste = $this->db->query("select idservice from setting_service  join department on department.id = setting_service.id_department and department.id_organisation = ".$this->id_organisation." where name_service = '" . $nomService . "'")->num_rows();

                    if (!$serviceExiste) { // Si prestation existante (meme service / mme prestation): refus
                        $missing_name[] = $row;
                        $missing_rows = implode(',', $missing_name);
                    } elseif (!$specialiteExiste) { // Si Service non existant: refus
                        $missing_name2[] = $row;
                        $missing_rows2 = implode(',', $missing_name2);
                    }
                    // elseif ($prestationExiste) { // Si Service non existant: refus
                    // $exist_name[] = $row;
                    // $exist_rows = implode(',', $exist_name);
                    // } 

                    // if (!$tarif_public_ok || !$tarif_assurance_ok || !$tarif_professionnel_ok) { // Si Service non existant: refus
                    // $erreur_tarifs[] = $row;
                    // $erreur_tarifs_rows = implode(',', $erreur_tarifs);
                    // }
                    // if (!$prestationExiste && $serviceExiste && $tarif_public_ok && $tarif_assurance_ok && $tarif_professionnel_ok) {
                    // array_push($rowData, date('d/m/y'));
                    // array_push($rowData2, 'add_date');
                    // $rowData2 = array("id_service", "prestation", "description", "tarif_public", "tarif_professionnel", "tarif_assurance");
                    // $data = array_combine($rowData2, $rowData);

                    // $this->import_model->dataEntry($data, $tablename);
                    // $this->import_model->dataEntryPrestation($data);
                    // }
                }

                $verbe_missing_name = count($missing_name) > 1 ? "contiennent" : "contient";
                $verbe_missing_name2 = count($missing_name2) > 1 ? "contiennent" : "contient";
                // $verbe_erreur_tarifs = count($erreur_tarifs) > 1 ? "contiennent" : "contient";

                $message2 .= count($missing_name) ? 'Lignes numéro ' . $missing_rows . ' ' . $verbe_missing_name . ' un service non existant!' . "<br/>" : "";
                $message2 .= count($missing_name2) ? "Lignes numéro " . $missing_rows2 . " " . $verbe_missing_name2 . " une spécialité non existante!" . "<br/>" : "";
                // $message2 .= count($erreur_tarifs) ? "Lignes numéro " . $erreur_tarifs_rows . " " . $verbe_erreur_tarifs . " un tarif non compris entre 1.000 et 100.000 Fcfa!" . "<br/>" : "";

                $count_errors = count($missing_name) + count($missing_name2);
                $import_error_label = $count_errors ? "erreurs" : "erreur";
                $import_status_label = !$count_errors ? lang('successful_data_import') : lang('successful_data_import_with_errors');
                // $import_status_label = lang('successful_data_import');
                $this->session->set_flashdata('feedback', $import_status_label . " " . $count_errors . " " . $import_error_label);
                // $this->session->set_flashdata('feedback', $import_status_label);
                $this->session->set_flashdata('message2', $message2);
            } else {
                $this->session->set_flashdata('feedback', lang('wrong_file_format'));
            }

            // echo "<script language=\"javascript\">alert('End of Row ".$row."');</script>";
        }

        // echo "<script language=\"javascript\">alert('About to head out');</script>";
        redirect('home/superprestations');

        // echo "<script language=\"javascript\">alert('".print_r($missing_name)."');</script>";
        // echo "<script language=\"javascript\">alert('".print_r($missing_name2)."');</script>";
        // echo "<script language=\"javascript\">alert('out');</script>";
    }

    function importPrestationsAutres($file)
    {
        $object = PHPExcel_IOFactory::load($file);
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestDataRow();    //get Highest Row
            $highestColumnLetter = $worksheet->getHighestDataColumn(); //get column highest as  letter
            $highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumnLetter); // convert letter to column index in number
            for ($column1 = 0; $column1 < $highestColumn; $column1++) {
                $rowData1[] = $worksheet->getCellByColumnAndRow($column1, 1)->getCalculatedValue();
            }


            $headerexist = $this->import_model->headerExistForGenericPrestationsAutres($rowData1); // get boolean header exist or not

            if ($headerexist) {

                $missing_name = [];
                $missing_name2 = [];
                $exist_name = [];
                // $exist_name2 = [];
                // $erreur_tarifs = [];

                $missing_rows = "";
                $missing_rows2 = "";
                $exist_rows = "";
                // $exist_rows2 = "";
                // $erreur_tarifs_rows = "";

                $message2 = "";

                $nomPrestationBuff = "";
                for ($row = 2; $row <= $highestRow; $row++) {

                    $rowData = [];
                    $rowData2 = [];

                    $nomService = "";
                    $nomSpecialite = "";
                    $nomPrestation = "";
                    $description = "";
                    $keywords = "";
                    // $nomParametre = "";
                    // $unite = "";
                    // $norme = "";

                    $id_service = "";
                    $id_spe = "";
                    $id_prestation = "";
                    // $id_parametre = "";

                    $serviceExiste;
                    $specialiteExiste;
                    $prestationExiste;
                    // $parametreExiste;
                    // $tarif_public_ok = false;
                    // $tarif_professionnel_ok = false;
                    // $tarif_assurance_ok = false;

                    for ($column = 0; $column < $highestColumn; $column++) {

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Service') {
                            $nomService = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Spécialité') {
                            $nomSpecialite = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Prestation') {
                            $nomPrestation = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Description') {
                            $description = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Mots-clés') {
                            $keywords = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Service') { // Cas Service: Fetch ID Service

                            $serviceExiste = $this->db->query("select idservice from setting_service where name_service = \"" . $nomService . "\" and id_organisation is NULL")->num_rows();


                            // echo "<script language=\"javascript\">alert(\"".$nomService."\");</script>";
                            if (!$serviceExiste) {

                                // echo "<script language=\"javascript\">alert(\"".$nomService." n'existe pas! \");</script>";
                                break;
                            }
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Spécialité') { // Cas Service: Fetch ID Service
                            $specialiteExiste = $this->db->query("select idspe from setting_service_specialite join setting_service on setting_service.idservice = setting_service_specialite.id_service and setting_service.name_service = \"" . $nomService . "\" and setting_service.id_organisation is NULL and setting_service_specialite.name_specialite=\"" . $nomSpecialite . "\"")->num_rows();


                            // echo "<script language=\"javascript\">alert(\"".$nomSpecialite."\");</script>";

                            if (!$specialiteExiste && trim($nomSpecialite) != "") {

                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." n'existe pas! \");</script>";
                                break;
                            }
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Prestation') { // Cas Service: Fetch ID Service
                            $prestationExiste = $this->db->query("select id from payment_category join setting_service on setting_service.idservice = payment_category.id_service and setting_service.name_service = \"" . $nomService . "\" and setting_service.id_organisation is NULL and payment_category.prestation=\"" . $nomPrestation . "\"")->num_rows();


                            // echo "<script language=\"javascript\">alert(\"".$nomPrestation."\");</script>";
                            if ($prestationExiste) {
                                // Do nothing else but get id_prestation

                                // echo "<script language=\"javascript\">alert(\"".$nomPrestation." existe! \");</script>";

                                $id_prestation = $this->db->query("select id from payment_category join setting_service on setting_service.idservice = payment_category.id_service and setting_service.name_service = \"" . $nomService . "\" and setting_service.id_organisation is NULL and payment_category.prestation=\"" . $nomPrestation . "\"")->row()->id;

                                $id_service = $this->db->query("select idservice from setting_service where name_service = \"" . $worksheet->getCellByColumnAndRow($column - 2, $row)->getCalculatedValue() . "\" and id_organisation is NULL")->row()->idservice;
                                $id_spe = $this->db->query("select (CASE WHEN `setting_service_specialite`.idspe IS NOT NULL THEN (SELECT `setting_service_specialite`.idspe) ELSE (SELECT '') END) as idspe from setting_service_specialite join setting_service on setting_service.idservice = setting_service_specialite.id_service and setting_service.idservice = " . $id_service . "  and id_organisation is NULL where name_specialite = \"" . $worksheet->getCellByColumnAndRow($column - 1, $row)->getCalculatedValue() . "\"")->row()->idspe;

                                // Mise à jour (description & keywords)
                                $this->db->query("update payment_category set description = \"" . $worksheet->getCellByColumnAndRow($column + 1, $row)->getCalculatedValue() . "\", keywords = \"" . $worksheet->getCellByColumnAndRow($column + 2, $row)->getCalculatedValue() . "\"  where payment_category.id = " . $id_prestation);

                                // echo "<script language=\"javascript\">alert(\"Id Prestation: ".$id_prestation."\");</script>";
                                // $this->db->query("insert into setting_service_specialite (name_specialite, id_service) VALUES(\"".$nomSpecialite."\", ".$id_service.")");;
                            } else { // Sinon, on insere


                                // echo "<script language=\"javascript\">alert(\"".$nomPrestation." n'existe pas! \");</script>";

                                $id_service = $this->db->query("select idservice from setting_service where name_service = \"" . $worksheet->getCellByColumnAndRow($column - 2, $row)->getCalculatedValue() . "\" and id_organisation is NULL")->row()->idservice;
                                $id_spe = $this->db->query("select (CASE WHEN `setting_service_specialite`.idspe IS NOT NULL THEN (SELECT `setting_service_specialite`.idspe) ELSE (SELECT '') END) as idspe from setting_service_specialite join setting_service on setting_service.idservice = setting_service_specialite.id_service and setting_service.idservice = " . $id_service . "  and id_organisation is NULL where name_specialite = \"" . $worksheet->getCellByColumnAndRow($column - 1, $row)->getCalculatedValue() . "\"")->row()->idspe;

                                $this->db->query("insert into payment_category (prestation, description, keywords, id_service, id_spe) VALUES(\"" . $nomPrestation . "\",\"" . $worksheet->getCellByColumnAndRow($column + 1, $row)->getCalculatedValue() . "\",\"" . $worksheet->getCellByColumnAndRow($column + 2, $row)->getCalculatedValue() . "\", " . $id_service . ", " . $id_spe . ")");
                                $id_prestation = $this->db->insert_id();
                            }
                        }
                    }


                    if (!$serviceExiste) { // Si prestation existante (meme service / mme prestation): refus
                        $missing_name[] = $row;
                        $missing_rows = implode(',', $missing_name);
                    } elseif (!$specialiteExiste) { // Si Service non existant: refus
                        $missing_name2[] = $row;
                        $missing_rows2 = implode(',', $missing_name2);
                    }
                }

                $verbe_missing_name = count($missing_name) > 1 ? "contiennent" : "contient";
                $verbe_missing_name2 = count($missing_name2) > 1 ? "contiennent" : "contient";
                // $verbe_erreur_tarifs = count($erreur_tarifs) > 1 ? "contiennent" : "contient";

                $message2 .= count($missing_name) ? 'Lignes numéro ' . $missing_rows . ' ' . $verbe_missing_name . ' un service non existant!' . "<br/>" : "";
                $message2 .= count($missing_name2) ? "Lignes numéro " . $missing_rows2 . " " . $verbe_missing_name2 . " une spécialité non existante!" . "<br/>" : "";
                // $message2 .= count($erreur_tarifs) ? "Lignes numéro " . $erreur_tarifs_rows . " " . $verbe_erreur_tarifs . " un tarif non compris entre 1.000 et 100.000 Fcfa!" . "<br/>" : "";

                $count_errors = count($missing_name) + count($missing_name2);
                $import_error_label = $count_errors ? "erreurs" : "erreur";
                $import_status_label = !$count_errors ? lang('successful_data_import') : lang('successful_data_import_with_errors');
                // $import_status_label = lang('successful_data_import');
                $this->session->set_flashdata('feedback', $import_status_label . " " . $count_errors . " " . $import_error_label);
                // $this->session->set_flashdata('feedback', $import_status_label);
                $this->session->set_flashdata('message2', $message2);
            } else {
                $this->session->set_flashdata('feedback', lang('wrong_file_format'));
            }

            // echo "<script language=\"javascript\">alert('End of Row ".$row."');</script>";
        }

        // echo "<script language=\"javascript\">alert('About to head out');</script>";
        redirect('home/superprestations');

        // echo "<script language=\"javascript\">alert('".print_r($missing_name)."');</script>";
        // echo "<script language=\"javascript\">alert('".print_r($missing_name2)."');</script>";
        // echo "<script language=\"javascript\">alert('out');</script>";
    }

    function importPrestationsMaladie($file)
    {
        $object = PHPExcel_IOFactory::load($file);
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestDataRow();    //get Highest Row
            $highestColumnLetter = $worksheet->getHighestDataColumn(); //get column highest as  letter
            $highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumnLetter); // convert letter to column index in number
            for ($column1 = 0; $column1 < $highestColumn; $column1++) {
                $rowData1[] = $worksheet->getCellByColumnAndRow($column1, 1)->getCalculatedValue();
            }


            $headerexist = $this->import_model->headerMaladie($rowData1); // get boolean header exist or not


            if ($headerexist) {

                $missing_name = [];
                $missing_name2 = [];
                $exist_name = [];
                // $exist_name2 = [];
                // $erreur_tarifs = [];

                $missing_rows = "";
                $missing_rows2 = "";
                $exist_rows = "";
                // $exist_rows2 = "";
                // $erreur_tarifs_rows = "";

                $message2 = "";

                $nomPrestationBuff = "";
                for ($row = 2; $row <= $highestRow; $row++) {

                    $rowData = [];
                    $rowData2 = [];

                    $code = "";
                    $affection = "";
                    $groupe_maladie = "";
                    $sous_groupe = "";
                    $maladieExiste = "";

                    for ($column = 0; $column < $highestColumn; $column++) {

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'CODE') {
                            $code = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'AFFECTION') {
                            $affection = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'GROUPE') {
                            $groupe_maladie = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'SOUS GROUPE') {
                            $sous_groupe = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        $maladieExiste = $this->db->query("select code from illness where code = \"" . $code . "\"")->num_rows();
                        if (!$maladieExiste) {
                            $this->db->query("insert into illness (code, affection, groupe_maladie, sous_groupe) VALUES(\"" . $code . "\",\"" . $worksheet->getCellByColumnAndRow($column + 1, $row)->getCalculatedValue() . "\",\"" . $worksheet->getCellByColumnAndRow($column + 2, $row)->getCalculatedValue() . "\",\"" . $worksheet->getCellByColumnAndRow($column + 3, $row)->getCalculatedValue() . "\")");
                        }

                        // var_dump("insert into illness (code, affection, groupe_maladie, sous_groupe) VALUES(\"" . $code . "\",\"" . $worksheet->getCellByColumnAndRow($column + 1, $row)->getCalculatedValue() . "\",\"" . $worksheet->getCellByColumnAndRow($column + 2, $row)->getCalculatedValue() . "\",\"" . $worksheet->getCellByColumnAndRow($column + 3, $row)->getCalculatedValue() . "\")");
                        // exit();
                    }




                    if (!$code) { // Si prestation existante (meme service / mme prestation): refus
                        $missing_name[] = $row;
                        $missing_rows = implode(',', $missing_name);
                    } elseif (!$affection) { // Si Service non existant: refus
                        $missing_name2[] = $row;
                        $missing_rows2 = implode(',', $missing_name2);
                    }
                }

                $verbe_missing_name = count($missing_name) > 1 ? "contiennent" : "contient";
                $verbe_missing_name2 = count($missing_name2) > 1 ? "contiennent" : "contient";
                // $verbe_erreur_tarifs = count($erreur_tarifs) > 1 ? "contiennent" : "contient";

                $message2 .= count($missing_name) ? 'Lignes numéro ' . $missing_rows . ' ' . $verbe_missing_name . ' un service non existant!' . "<br/>" : "";
                $message2 .= count($missing_name2) ? "Lignes numéro " . $missing_rows2 . " " . $verbe_missing_name2 . " une spécialité non existante!" . "<br/>" : "";
                // $message2 .= count($erreur_tarifs) ? "Lignes numéro " . $erreur_tarifs_rows . " " . $verbe_erreur_tarifs . " un tarif non compris entre 1.000 et 100.000 Fcfa!" . "<br/>" : "";

                $count_errors = count($missing_name) + count($missing_name2);
                $import_error_label = $count_errors ? "erreurs" : "erreur";
                $import_status_label = !$count_errors ? lang('successful_data_import') : lang('successful_data_import_with_errors');
                // $import_status_label = lang('successful_data_import');
                $this->session->set_flashdata('feedback', $import_status_label . " " . $count_errors . " " . $import_error_label);
                // $this->session->set_flashdata('feedback', $import_status_label);
                $this->session->set_flashdata('message2', $message2);
            } else {
                $this->session->set_flashdata('feedback', lang('wrong_file_format'));
            }

            // echo "<script language=\"javascript\">alert('End of Row ".$row."');</script>";
        }

        // echo "<script language=\"javascript\">alert('About to head out');</script>";
        redirect('home/templateMaladie');

        // echo "<script language=\"javascript\">alert('".print_r($missing_name)."');</script>";
        // echo "<script language=\"javascript\">alert('".print_r($missing_name2)."');</script>";
        // echo "<script language=\"javascript\">alert('out');</script>";
    }

    function importPrestationsPanier2($file)
    {
        $object = PHPExcel_IOFactory::load($file);
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestDataRow();    //get Highest Row
            $highestColumnLetter = $worksheet->getHighestDataColumn(); //get column highest as  letter
            $highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumnLetter); // convert letter to column index in number
            for ($column1 = 0; $column1 < $highestColumn; $column1++) {
                $rowData1[] = $worksheet->getCellByColumnAndRow($column1, 1)->getCalculatedValue();
            }


            // $headerexist = $this->import_model->headerExistForGenericPrestationsLabo($rowData1); 

            $headerexist = $this->import_model->headerExistForPanierTiersPayant($rowData1); // get boolean header exist or not
            // $headerExistForPanier = $headerexist ? "TRUE" : "FALSE";
            // echo "<script language=\"javascript\">alert('".$headerExistForPanier."');</script>";
            if ($headerexist) {

                $missing_name = [];
                $missing_name2 = [];
                $missing_name3 = [];
                // $exist_name2 = [];
                // $erreur_tarifs = [];

                $missing_rows = "";
                $missing_rows2 = "";
                $missing_rows3 = "";
                // $exist_rows2 = "";
                // $erreur_tarifs_rows = "";

                $message2 = "";

                $nomPrestationBuff = "";
                for ($row = 2; $row <= $highestRow; $row++) {

                    $rowData = [];
                    $rowData2 = [];

                    $nomService = "";
                    $nomSpecialite = "";
                    $nomPrestation = "";
                    $IDPrestationFichier = "";
                    $description = "";
                    // $nomParametre = "";
                    // $unite = "";
                    // $norme = "";

                    $id_service = "";
                    $id_spe = "";
                    $id_prestation = "";
                    // $id_parametre = "";

                    $serviceExiste;
                    $specialiteExiste;
                    $prestationExiste;
                    // $parametreExiste;
                    $tarif_public_ok = false;
                    $tarif_professionnel_ok = false;
                    $tarif_assurance_ok = false;
                    $tarif_ipm_ok = false;
                    $prix_assurance = "";
                    $prix_ipm = "0";
                    $prix_public_ok = false;
                    for ($column = 0; $column < $highestColumn; $column++) {

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'ID') {
                            $IDPrestationFichier = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Service') {
                            $nomService = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Spécialité') {
                            $nomSpecialite = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Prestation') {
                            $nomPrestation = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Service') { // Cas Service: Fetch ID Service

                            $serviceExiste = $this->db->query("select idservice from setting_service where name_service = \"" . $nomService . "\" and id_organisation is NULL")->num_rows();


                            // echo "<script language=\"javascript\">alert(\"".$nomService."\");</script>";
                            if (!$serviceExiste) {

                                // echo "<script language=\"javascript\">alert(\"".$nomService." n'existe pas! \");</script>";
                                break;
                            }
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Spécialité') { // Cas Service: Fetch ID Service
                            $specialiteExiste = $this->db->query("select idspe from setting_service_specialite join setting_service on setting_service.idservice = setting_service_specialite.id_service and setting_service.name_service = \"" . $nomService . "\" and setting_service.id_organisation is NULL and setting_service_specialite.name_specialite=\"" . $nomSpecialite . "\"")->num_rows();


                            // echo "<script language=\"javascript\">alert(\"".$nomSpecialite."\");</script>";

                            if (!$specialiteExiste) {

                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." n'existe pas! \");</script>";
                                break;
                            }
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Prestation') { // Cas Service: Fetch ID Service
                            $prestationExiste = $this->db->query("select id from payment_category join setting_service on setting_service.idservice = payment_category.id_service and setting_service.name_service = \"" . $nomService . "\" and setting_service.id_organisation is NULL and payment_category.prestation=\"" . $nomPrestation . "\"")->num_rows();


                            if (!$prestationExiste) {

                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." n'existe pas! \");</script>";
                                break;
                            } else { // On insere

                                if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'ID') { // Cas Service: Fetch ID Service
                                    $IDprestationExiste = $this->db->query("select id from payment_category where id= \"" . $IDPrestationFichier . "\"");
                                    $prestations_panier = $this->home_model->getPrestationById($IDprestationExiste);
                                    $prix_assurance = $prestations_panier->coefficient;
                                }

                                // $prix_assurance = $prestations_panier->coefficient;
                                // foreach ($prestations_panier as $row) {
                                //     if ($row->cotation) {
                                //         $tiers_payant = $this->home_model->getTiersPayantByIdCotation($row->cotation);
                                //         if ($tiers_payant) {
                                //             $assurance = intval($tiers_payant->prix_assurance);
                                //             $ipm = intval($tiers_payant->prix_ipm);
                                //             $coefficient = intval($row->coefficient);
                                //             $prix_ipm = $ipm * $coefficient;
                                //             $prix_assurance = $assurance * $coefficient;
                                //         }
                                //     }


                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." existe! \");</script>";
                                $tarif_public = str_replace(".", "", $worksheet->getCellByColumnAndRow($column + 1, $row)->getCalculatedValue());
                                $tarif_public = str_replace(",", "", $tarif_public); // Cas Excel Local Client avec "," comme separateur milliers
                                $tarif_public = str_replace(" ", "", $tarif_public); // Cas Excel Local Client avec " " comme separateur milliers
                                // if (($tarif_public >= "1000" && $tarif_public <= "1000000") || $tarif_public === "0") {
                                if ($tarif_public >= "0" && $tarif_public <= "1000000") {
                                    $tarif_public_ok = true;
                                }

                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." Tarif Public.".$tarif_public." \");</script>";
                                $tarif_professionnel = str_replace(".", "", $worksheet->getCellByColumnAndRow($column + 2, $row)->getCalculatedValue());
                                $tarif_professionnel = str_replace(",", "", $tarif_professionnel); // Cas Excel Local Client avec "," comme separateur milliers
                                $tarif_professionnel = str_replace(" ", "", $tarif_professionnel); // Cas Excel Local Client avec " " comme separateur milliers
                                // if (($tarif_professionnel >= "1000" && $tarif_professionnel <= "1000000") || $tarif_professionnel === "0") {
                                if ($tarif_professionnel >= "0" && $tarif_professionnel <= "1000000") {
                                    $tarif_professionnel_ok = true;
                                }

                                $prix_public = str_replace(".", "", $worksheet->getCellByColumnAndRow($column + 3, $row)->getCalculatedValue());
                                $prix_public = str_replace(",", "", $prix_public); // Cas Excel Local Client avec "," comme separateur milliers
                                $prix_public = str_replace(" ", "", $prix_public); // Cas Excel Local Client avec " " comme separateur milliers
                                // if (($tarif_professionnel >= "1000" && $tarif_professionnel <= "1000000") || $tarif_professionnel === "0") {
                                if ($prix_public >= "0" && $prix_public <= "1000000") {
                                    $prix_public_ok = true;
                                }

                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." Tarif Pro.".$tarif_professionnel." \");</script>";
                                // $tarif_assurance = str_replace(".", "", $worksheet->getCellByColumnAndRow($column + 3, $row)->getCalculatedValue());
                                // $tarif_assurance = str_replace(",", "", $tarif_assurance); // Cas Excel Local Client avec "," comme separateur milliers
                                // $tarif_assurance = str_replace(" ", "", $tarif_assurance); // Cas Excel Local Client avec " " comme separateur milliers
                                $tarif_assurance = $prix_assurance;
                                // if (($tarif_assurance >= "1000" && $tarif_assurance <= "1000000") || $tarif_assurance === "0") {
                                if ($tarif_assurance >= "0" && $tarif_assurance <= "1000000") {
                                    $tarif_assurance_ok = true;
                                }

                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." Tarif Assurance.".$tarif_assurance." \");</script>";
                                // $tarif_ipm = str_replace(".", "", $worksheet->getCellByColumnAndRow($column + 4, $row)->getCalculatedValue());
                                // $tarif_ipm = str_replace(",", "", $tarif_ipm); // Cas Excel Local Client avec "," comme separateur milliers
                                // $tarif_ipm = str_replace(" ", "", $tarif_ipm); // Cas Excel Local Client avec " " comme separateur milliers
                                // if (($tarif_ipm >= "1000" && $tarif_ipm <= "1000000") || $tarif_ipm === "0") {
                                $tarif_ipm = $prix_ipm;
                                if ($tarif_ipm >= "0" && $tarif_ipm <= "1000000") {
                                    $tarif_ipm_ok = true;
                                }

                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." Tarif IPM.".$tarif_ipm." \");</script>";
                                $id_prestation = $this->db->query("select id from payment_category join setting_service on setting_service.idservice = payment_category.id_service and setting_service.name_service = \"" . $nomService . "\" and setting_service.id_organisation is NULL and payment_category.prestation=\"" . $nomPrestation . "\"")->row()->id;


                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." a pour id:".$id_prestation." \");</script>";
                                $prestationExistePourOrganisation = $this->db->query("select idpco from payment_category_organisation where id_organisation = " . $this->id_organisation . " and id_presta=" . $id_prestation)->num_rows();

                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." existe pour Organisation?:".$prestationExistePourOrganisation." \");</script>";
                            }
                            if ($tarif_public_ok && $tarif_professionnel_ok && $tarif_assurance_ok && $tarif_ipm_ok && $prix_public_ok) {
                                if ($prestationExistePourOrganisation) {
                                    $this->db->query("update payment_category_organisation set tarif_public = " . $tarif_public . ", tarif_professionnel = " . $tarif_professionnel . ", tarif_assurance = " . $tarif_assurance . ", tarif_ipm = " . $tarif_ipm . " , prix_public = " . $prix_public . " where id_organisation=" . $this->id_organisation . " and id_presta=" . $id_prestation);

                                    $this->db->query("delete from payment_category_panier where id_prestation = " . $id_prestation . " and id_organisation=" . $this->id_organisation);

                                    $idpco = $this->db->query("select idpco from payment_category_organisation where id_organisation = " . $this->id_organisation . " and id_presta=" . $id_prestation)->row()->idpco;

                                    $date_pco = time();
                                    $user_pco = $this->ion_auth->get_user_id();
                                    $this->db->query("insert into pco_changes_history (idpco, new_tarif_public, new_tarif_professionnel, new_tarif_assurance, new_tarif_ipm, date, changed_by_user, is_initial, new_prix_public) values(" . $idpco . "," . $tarif_public . "," . $tarif_professionnel . "," . $tarif_assurance . "," . $tarif_ipm . ", " . $date_pco . ", " . $user_pco . ", " . "0" . ", " . $prix_public . ")");
                                } else {

                                    $this->db->query("insert into payment_category_organisation (id_presta, id_organisation, statut, tarif_public, tarif_professionnel, tarif_assurance, tarif_ipm, prix_public) values(" . $id_prestation . "," . $this->id_organisation . ",1," . $tarif_public . "," . $tarif_professionnel . "," . $tarif_assurance . "," . $tarif_ipm . "," . $prix_public . ")");

                                    $idpco = $this->db->insert_id();

                                    $this->db->query("delete from payment_category_panier where id_prestation = " . $id_prestation . " and id_organisation=" . $this->id_organisation);

                                    $date_pco = time();
                                    $user_pco = $this->ion_auth->get_user_id();
                                    $this->db->query("insert into pco_changes_history (idpco, new_tarif_public, new_tarif_professionnel, new_tarif_assurance, new_tarif_ipm, date, changed_by_user, is_initial, new_prix_public ) values(" . $idpco . "," . $tarif_public . "," . $tarif_professionnel . "," . $tarif_assurance . "," . $tarif_ipm . ", " . $date_pco . ", " . $user_pco . ", " . "1" . ", " . $prix_public . ")");
                                }
                            } else {
                                break;
                            }
                        }
                    }
                    //   }


                    if (!$serviceExiste) { // Si prestation existante (meme service / mme prestation): refus
                        $missing_name[] = $row;
                        $missing_rows = implode(',', $missing_name);
                    } elseif (!$specialiteExiste) { // Si Service non existant: refus
                        $missing_name2[] = $row;
                        $missing_rows2 = implode(',', $missing_name2);
                    } elseif (!$prestationExiste) { // Si Service non existant: refus
                        $missing_name3[] = $row;
                        $missing_rows3 = implode(',', $missing_name3);
                    }
                }

                $verbe_missing_name = count($missing_name) > 1 ? "contiennent" : "contient";
                $verbe_missing_name2 = count($missing_name2) > 1 ? "contiennent" : "contient";
                $verbe_missing_name3 = count($missing_name3) > 1 ? "contiennent" : "contient";
                // $verbe_erreur_tarifs = count($erreur_tarifs) > 1 ? "contiennent" : "contient";

                $message2 .= count($missing_name) ? 'Lignes numéro ' . $missing_rows . ' ' . $verbe_missing_name . ' un service non existant!' . "<br/>" : "";
                $message2 .= count($missing_name2) ? "Lignes numéro " . $missing_rows2 . " " . $verbe_missing_name2 . " une spécialité non existante!" . "<br/>" : "";
                $message2 .= count($missing_name3) ? "Lignes numéro " . $missing_rows3 . " " . $verbe_missing_name3 . " une prestation non existante!" . "<br/>" : "";
                // $message2 .= count($erreur_tarifs) ? "Lignes numéro " . $erreur_tarifs_rows . " " . $verbe_erreur_tarifs . " un tarif non compris entre 1.000 et 100.000 Fcfa!" . "<br/>" : "";

                $count_errors = count($missing_name) + count($missing_name2) + count($missing_name3);
                $import_error_label = $count_errors ? "erreurs" : "erreur";
                $import_status_label = !$count_errors ? lang('successful_data_import') : lang('successful_data_import_with_errors');
                // $import_status_label = lang('successful_data_import');
                $this->session->set_flashdata('feedback', $import_status_label . " " . $count_errors . " " . $import_error_label);
                // $this->session->set_flashdata('feedback', $import_status_label);
                $this->session->set_flashdata('message2', $message2);

                redirect('finance/paymentCategory');
            } else {

                $this->session->set_flashdata('feedback', lang('wrong_file_format'));

                redirect('finance/paymentCategoryPanier');
            }
        }
    }



    function importPrestationsPanier($file)
    {
        $object = PHPExcel_IOFactory::load($file);
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestDataRow();    //get Highest Row
            $highestColumnLetter = $worksheet->getHighestDataColumn(); //get column highest as  letter
            $highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumnLetter); // convert letter to column index in number

            // echo "<script language=\"javascript\">alert('Highest Row ".$highestRow."');</script>";
            for ($column1 = 0; $column1 < $highestColumn; $column1++) {
                $rowData1[] = $worksheet->getCellByColumnAndRow($column1, 1)->getCalculatedValue();
            }


            // echo "<script language=\"javascript\">alert('Testing 123');</script>";

            $headerexist = $this->import_model->headerExistForPanierTiersPayant($rowData1);
            //  $headerexist = $this->import_model->headerExistForPanier($rowData1); // get boolean header exist or not
            // $headerExistForPanier = $headerexist ? "TRUE" : "FALSE";
            // echo "<script language=\"javascript\">alert('".$headerExistForPanier."');</script>";
            if ($headerexist) {

                $missing_name = [];
                $missing_name2 = [];
                $missing_name3 = [];
                // $exist_name2 = [];
                // $erreur_tarifs = [];

                $missing_rows = "";
                $missing_rows2 = "";
                $missing_rows3 = "";
                // $exist_rows2 = "";
                // $erreur_tarifs_rows = "";

                $message2 = "";

                $nomPrestationBuff = "";
                for ($row = 2; $row <= $highestRow; $row++) {

                    $rowData = [];
                    $rowData2 = [];

                    $nomService = "";
                    $nomSpecialite = "";
                    $nomPrestation = "";
                    $description = "";
                    // $nomParametre = "";
                    // $unite = "";
                    // $norme = "";

                    $id_service = "";
                    $id_spe = "";
                    $id_prestation = "";
                    $IDPrestationFichier = "";
                    $prix_assurance = "0";
                    $prix_ipm = "0";
                    // $id_parametre = "";

                    // $parametreExiste;
                    $tarif_public_ok = false;
                    $tarif_professionnel_ok = false;
                    $tarif_assurance_ok = false;

                    for ($column = 0; $column < $highestColumn; $column++) {
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'ID') {
                            $IDPrestationFichier = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Service') {
                            $nomService = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Spécialité') {
                            $nomSpecialite = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Prestation') {
                            $nomPrestation = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }

                        $IDRows = $this->home_model->getPrestationById($IDPrestationFichier);
                        $coefficient = $IDRows->coefficient;
                        $id_prestation_list = $IDRows->id;
                        $cotation = $IDRows->cotation;
                        $tiers_payant = $this->home_model->getTiersPayantByIdCotation($cotation);
                        if ($tiers_payant) {
                            $assurance = intval($tiers_payant->prix_assurance);
                            $ipm = intval($tiers_payant->prix_ipm);
                            $coefficient = intval($coefficient);
                            $prix_ipm = $ipm * $coefficient;
                            $prix_assurance = $assurance * $coefficient;
                        }
                        if (!$id_prestation_list) {
                            break;
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Service') { // Cas Service: Fetch ID Service

                            $serviceExiste = $this->db->query("select idservice from setting_service where name_service = \"" . $nomService . "\" and id_organisation is NULL")->num_rows();


                            // echo "<script language=\"javascript\">alert(\"".$nomService."\");</script>";
                            if (!$serviceExiste) {

                                // echo "<script language=\"javascript\">alert(\"".$nomService." n'existe pas! \");</script>";
                                break;
                            }
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Spécialité') { // Cas Service: Fetch ID Service
                            $specialiteExiste = $this->db->query("select idspe from setting_service_specialite join setting_service on setting_service.idservice = setting_service_specialite.id_service and setting_service.name_service = \"" . $nomService . "\" and setting_service.id_organisation is NULL and setting_service_specialite.name_specialite=\"" . $nomSpecialite . "\"")->num_rows();


                            // echo "<script language=\"javascript\">alert(\"".$nomSpecialite."\");</script>";

                            if (!$specialiteExiste) {

                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." n'existe pas! \");</script>";
                                break;
                            }
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Prestation') { // Cas Service: Fetch ID Service
                            $prestationExiste = $this->db->query("select id from payment_category join setting_service on setting_service.idservice = payment_category.id_service and setting_service.name_service = \"" . $nomService . "\" and setting_service.id_organisation is NULL and payment_category.prestation=\"" . $nomPrestation . "\"")->num_rows();
                            //  $prestationByid = $this->db->query("select coefficient from payment_category where id=\"" . $IDPrestationFichier . "\"");
                            // $thiers_payant = $this->home_model->getTiersPayantByIdCotation($IDPrestationFichier);
                            // $coef = $thiers_payant->coefficient;
                            if (!$prestationExiste) {

                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." n'existe pas! \");</script>";
                                break;
                            } else { // On insere

                                //  $IDprestationExiste = $this->db->query("select id from payment_category where id= \"" . $IDPrestationFichier . "\"");
                                // $prestations_panier = $this->db->query("select id from payment_category where id= \"" . $IDPrestationFichier . "\"")->row()->id;
                                // // $this->home_model->getPrestationById($IDprestationExiste);
                                // $prix_assurance = $prestations_panier->coefficient;
                                // $prix_ipm = $prestations_panier->coefficient;



                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." existe! \");</script>";
                                $tarif_public = str_replace(".", "", $worksheet->getCellByColumnAndRow($column + 1, $row)->getCalculatedValue());
                                $tarif_public = str_replace(",", "", $tarif_public); // Cas Excel Local Client avec "," comme separateur milliers
                                $tarif_public = str_replace(" ", "", $tarif_public); // Cas Excel Local Client avec " " comme separateur milliers
                                // if (($tarif_public >= "1000" && $tarif_public <= "1000000") || $tarif_public === "0") {
                                if ($tarif_public >= "0" && $tarif_public <= "1000000") {
                                    $tarif_public_ok = true;
                                }

                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." Tarif Public.".$tarif_public." \");</script>";
                                $tarif_professionnel = str_replace(".", "", $worksheet->getCellByColumnAndRow($column + 2, $row)->getCalculatedValue());
                                $tarif_professionnel = str_replace(",", "", $tarif_professionnel); // Cas Excel Local Client avec "," comme separateur milliers
                                $tarif_professionnel = str_replace(" ", "", $tarif_professionnel); // Cas Excel Local Client avec " " comme separateur milliers
                                // if (($tarif_professionnel >= "1000" && $tarif_professionnel <= "1000000") || $tarif_professionnel === "0") {
                                if ($tarif_professionnel >= "0" && $tarif_professionnel <= "1000000") {
                                    $tarif_professionnel_ok = true;
                                }

                                $prix_public = str_replace(".", "", $worksheet->getCellByColumnAndRow($column + 3, $row)->getCalculatedValue());
                                $prix_public = str_replace(",", "", $prix_public); // Cas Excel Local Client avec "," comme separateur milliers
                                $prix_public = str_replace(" ", "", $prix_public); // Cas Excel Local Client avec " " comme separateur milliers
                                // if (($tarif_professionnel >= "1000" && $tarif_professionnel <= "1000000") || $tarif_professionnel === "0") {
                                if ($prix_public >= "0" && $prix_public <= "1000000") {
                                    $prix_public_ok = true;
                                }

                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." Tarif Pro.".$tarif_professionnel." \");</script>";
                                //  $tarif_assurance = str_replace(".", "", $worksheet->getCellByColumnAndRow($column + 4, $row)->getCalculatedValue());
                                $tarif_assurance = str_replace(",", "", $prix_assurance); // Cas Excel Local Client avec "," comme separateur milliers
                                $tarif_assurance = str_replace(" ", "", $tarif_assurance); // Cas Excel Local Client avec " " comme separateur milliers
                                // if (($tarif_assurance >= "1000" && $tarif_assurance <= "1000000") || $tarif_assurance === "0") {
                                if ($tarif_assurance >= "0" && $tarif_assurance <= "1000000") {
                                    $tarif_assurance_ok = true;
                                }

                                // $tarif_ipm = str_replace(".", "", $worksheet->getCellByColumnAndRow($column + 5, $row)->getCalculatedValue());
                                $tarif_ipm = str_replace(",", "", $prix_ipm); // Cas Excel Local Client avec "," comme separateur milliers
                                $tarif_ipm = str_replace(" ", "", $tarif_ipm); // Cas Excel Local Client avec " " comme separateur milliers
                                // if (($tarif_ipm >= "1000" && $tarif_ipm <= "1000000") || $tarif_ipm === "0") {
                                if ($tarif_ipm >= "0" && $tarif_ipm <= "1000000") {
                                    $tarif_ipm_ok = true;
                                }

                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." Tarif IPM.".$tarif_ipm." \");</script>";
                                $id_prestation = $this->db->query("select id from payment_category join setting_service on setting_service.idservice = payment_category.id_service and setting_service.name_service = \"" . $nomService . "\" and setting_service.id_organisation is NULL and payment_category.prestation=\"" . $nomPrestation . "\"")->row()->id;


                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." a pour id:".$id_prestation." \");</script>";
                                $prestationExistePourOrganisation = $this->db->query("select idpco from payment_category_organisation where id_organisation = " . $this->id_organisation . " and id_presta=" . $id_prestation)->num_rows();

                                // echo "<script language=\"javascript\">alert(\"".$nomSpecialite." existe pour Organisation?:".$prestationExistePourOrganisation." \");</script>";

                                if ($tarif_public_ok && $tarif_professionnel_ok && $tarif_assurance_ok && $tarif_ipm_ok && $prix_public_ok) {
                                    if ($prestationExistePourOrganisation) {
                                        $this->db->query("update payment_category_organisation set tarif_public = " . $tarif_public . ", tarif_professionnel = " . $tarif_professionnel . ", tarif_assurance = " . $tarif_assurance . ", tarif_ipm = " . $tarif_ipm . " , prix_public = " . $prix_public . " where id_organisation=" . $this->id_organisation . " and id_presta=" . $id_prestation);

                                        $this->db->query("delete from payment_category_panier where id_prestation = " . $id_prestation . " and id_organisation=" . $this->id_organisation);

                                        $idpco = $this->db->query("select idpco from payment_category_organisation where id_organisation = " . $this->id_organisation . " and id_presta=" . $id_prestation)->row()->idpco;

                                        $date_pco = time();
                                        $user_pco = $this->ion_auth->get_user_id();
                                        $this->db->query("insert into pco_changes_history (idpco, new_tarif_public, new_tarif_professionnel, new_tarif_assurance, new_tarif_ipm, date, changed_by_user, is_initial, new_prix_public) values(" . $idpco . "," . $tarif_public . "," . $tarif_professionnel . "," . $tarif_assurance . "," . $tarif_ipm . ", " . $date_pco . ", " . $user_pco . ", " . "0" . ", " . $prix_public . ")");
                                    } else {

                                        $this->db->query("insert into payment_category_organisation (id_presta, id_organisation, statut, tarif_public, tarif_professionnel, tarif_assurance, tarif_ipm, prix_public) values(" . $id_prestation . "," . $this->id_organisation . ",1," . $tarif_public . "," . $tarif_professionnel . "," . $tarif_assurance . "," . $tarif_ipm . "," . $prix_public . ")");

                                        $idpco = $this->db->insert_id();

                                        $this->db->query("delete from payment_category_panier where id_prestation = " . $id_prestation . " and id_organisation=" . $this->id_organisation);

                                        $date_pco = time();
                                        $user_pco = $this->ion_auth->get_user_id();
                                        $this->db->query("insert into pco_changes_history (idpco, new_tarif_public, new_tarif_professionnel, new_tarif_assurance, new_tarif_ipm, date, changed_by_user, is_initial, new_prix_public ) values(" . $idpco . "," . $tarif_public . "," . $tarif_professionnel . "," . $tarif_assurance . "," . $tarif_ipm . ", " . $date_pco . ", " . $user_pco . ", " . "1" . ", " . $prix_public . ")");
                                    }
                                } else {
                                    break;
                                }
                            }
                        }
                    }


                    if (!$serviceExiste) { // Si prestation existante (meme service / mme prestation): refus
                        $missing_name[] = $row;
                        $missing_rows = implode(',', $missing_name);
                    } elseif (!$specialiteExiste) { // Si Service non existant: refus
                        $missing_name2[] = $row;
                        $missing_rows2 = implode(',', $missing_name2);
                    } elseif (!$prestationExiste) { // Si Service non existant: refus
                        $missing_name3[] = $row;
                        $missing_rows3 = implode(',', $missing_name3);
                    }
                }

                $verbe_missing_name = count($missing_name) > 1 ? "contiennent" : "contient";
                $verbe_missing_name2 = count($missing_name2) > 1 ? "contiennent" : "contient";
                $verbe_missing_name3 = count($missing_name3) > 1 ? "contiennent" : "contient";
                // $verbe_erreur_tarifs = count($erreur_tarifs) > 1 ? "contiennent" : "contient";

                $message2 .= count($missing_name) ? 'Lignes numéro ' . $missing_rows . ' ' . $verbe_missing_name . ' un service non existant!' . "<br/>" : "";
                $message2 .= count($missing_name2) ? "Lignes numéro " . $missing_rows2 . " " . $verbe_missing_name2 . " une spécialité non existante!" . "<br/>" : "";
                $message2 .= count($missing_name3) ? "Lignes numéro " . $missing_rows3 . " " . $verbe_missing_name3 . " une prestation non existante!" . "<br/>" : "";
                // $message2 .= count($erreur_tarifs) ? "Lignes numéro " . $erreur_tarifs_rows . " " . $verbe_erreur_tarifs . " un tarif non compris entre 1.000 et 100.000 Fcfa!" . "<br/>" : "";

                $count_errors = count($missing_name) + count($missing_name2) + count($missing_name3);
                $import_error_label = $count_errors ? "erreurs" : "erreur";
                $import_status_label = !$count_errors ? lang('successful_data_import') : lang('successful_data_import_with_errors');
                // $import_status_label = lang('successful_data_import');
                $this->session->set_flashdata('feedback', $import_status_label . " " . $count_errors . " " . $import_error_label);
                // $this->session->set_flashdata('feedback', $import_status_label);
                $this->session->set_flashdata('message2', $message2);

                redirect('finance/paymentCategory');
            } else {
                $this->session->set_flashdata('feedback', lang('wrong_file_format'));

                redirect('finance/paymentCategoryPanier');
            }

            // echo "<script language=\"javascript\">alert('End of Row ".$row."');</script>";
        }

        // echo "<script language=\"javascript\">alert('About to head out');</script>";

        // echo "<script language=\"javascript\">alert('".print_r($missing_name)."');</script>";
        // echo "<script language=\"javascript\">alert('".print_r($missing_name2)."');</script>";
        // echo "<script language=\"javascript\">alert('out');</script>";
    }



    function editPaymentCategoryPrices()
    {

        $idpco = $this->input->post("idpco");
        $tarif_public = str_replace(".", "", explode(" ", $this->input->post("tarif_public"))[0]);
        $tarif_professionnel = str_replace(".", "", explode(" ", $this->input->post("tarif_professionnel"))[0]);
        $tarif_assurance = str_replace(".", "", explode(" ", $this->input->post("tarif_assurance"))[0]);
        $tarif_ipm = str_replace(".", "", explode(" ", $this->input->post("tarif_ipm"))[0]);
        $prix_public = str_replace(".", "", explode(" ", $this->input->post("prix_public"))[0]);



        // echo "<script language=\"javascript\">alert(\"".$idpco."\");</script>";
        // echo "<script language=\"javascript\">alert(\"".$tarif_public."\");</script>";
        // echo "<script language=\"javascript\">alert(\"".$tarif_professionnel."\");</script>";
        // echo "<script language=\"javascript\">alert(\"".$tarif_assurance."\");</script>";
        // echo "<script language=\"javascript\">alert(\"".$tarif_ipm."\");</script>";
        // var_dump("update payment_category_organisation set tarif_public = " . $tarif_public . ", prix_public = " . $prix_public . ", tarif_professionnel = " . $tarif_professionnel . " where idpco=" . $idpco . " and id_organisation=" . $this->id_organisation);
        //         exit();
        $this->db->query("update payment_category_organisation set tarif_public = " . $tarif_public . ", prix_public = " . $prix_public . ", tarif_professionnel = " . $tarif_professionnel . " where idpco=" . $idpco . " and id_organisation=" . $this->id_organisation);

        $date_pco = time();
        $user_pco = $this->ion_auth->get_user_id();
        $this->db->query("insert into pco_changes_history (idpco, new_tarif_public, new_tarif_professionnel, new_tarif_assurance, new_tarif_ipm, new_prix_public, date, changed_by_user, is_initial) values(" . $idpco . "," . $tarif_public . "," . $tarif_professionnel . "," . $tarif_assurance . "," . $tarif_ipm . "," . $prix_public . ", " . $date_pco . ", " . $user_pco . ", " . "0" . ")");

        $this->session->set_flashdata('feedback', "Tarifs mis à jour avec succès");
        redirect('finance/paymentCategory');
    }


    public function createPrestationsTiersPayant()
    {
        $objPHPExcel = PHPExcel_IOFactory::load("files/downloads/master_data_prestations_tiers_payant.xlsx");
        $objPHPExcel->setActiveSheetIndex(0);

        $generic_services = $this->home_model->getGeneriquePrestation();

        $excel_row = 2;

        foreach ($generic_services as $row) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->id);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->prestation);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->nomenclature_prestation);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->code_prestation);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->cotation);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->coefficient);
            $excel_row++;
        }

        // $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        // $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="master_data_prestations_tiers_payant' . time() . '.xlsx"');
        ob_end_clean();
        $object_writer->save('php://output');
    }


    public function createPrestationsTemplateLabo()
    {
        $objPHPExcel = PHPExcel_IOFactory::load("files/downloads/master_data_prestations_labo_blank.xlsx");
        $objPHPExcel->setActiveSheetIndex(0);

        $generic_services = $this->service_model->getGenericServicesLabo();

        $excel_row = 2;

        foreach ($generic_services as $row) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->name_service);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->name_specialite);
            $excel_row++;
        }

        // $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        // $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="master_data_prestations_labo' . time() . '.xlsx"');
        ob_end_clean();
        $object_writer->save('php://output');
    }

    public function createPrestationsTemplatePanier()
    {
        $objPHPExcel = PHPExcel_IOFactory::load("files/downloads/master_data_prestations_panier_blank.xlsx");
        $objPHPExcel->setActiveSheetIndex(0);



        // echo "<script language=\"javascript\">alert('Here I am');</script>";
        // echo "<script language=\"javascript\">alert('".$this->id_organisation."');</script>";
        $prestations_panier = $this->service_model->getPrestationsPanier($this->id_organisation);

        // echo "<script language=\"javascript\">alert('".count($prestations_panier)."');</script>";
        $excel_row = 2;
        $prix_assurance = "";
        $prix_ipm = "";
        foreach ($prestations_panier as $row) {
            if ($row->cotation) {
                $tiers_payant = $this->home_model->getTiersPayantByIdCotation($row->cotation);
                if ($tiers_payant) {
                    $assurance = intval($tiers_payant->prix_assurance);
                    $ipm = intval($tiers_payant->prix_ipm);
                    $coefficient = intval($row->coefficient);
                    $prix_ipm = $ipm * $coefficient;
                    $prix_assurance = $assurance * $coefficient;
                }
            }
            // setting_service.name_service, setting_service_specialite.name_specialite, payment_category.prestation
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->ID);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->name_service);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->name_specialite);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->prestation);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $prix_assurance);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $prix_ipm);

            $excel_row++;
        }

        // $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        // $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="master_data_prestations_panier_blank.xlsx"');
        ob_end_clean();
        $object_writer->save('php://output');
    }

    public function createPrestationsTemplateAutres()
    {
        $objPHPExcel = PHPExcel_IOFactory::load("files/downloads/master_data_prestations_autres_blank.xlsx");
        $objPHPExcel->setActiveSheetIndex(0);

        $generic_services = $this->service_model->getGenericServicesAutres();

        $excel_row = 2;

        foreach ($generic_services as $row) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->name_service);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->name_specialite);
            $excel_row++;
        }

        // $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        // $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="master_data_prestations_autres' . time() . '.xlsx"');
        ob_end_clean();
        $object_writer->save('php://output');
    }


    public function paymentCategory()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        // $data['categories'] = $this->finance_model->getPaymentCategory();
        $data['categories'] = $this->home_model->getPaymentCategory();
        $data['settings'] = $this->settings_model->getSettings();

        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('payment_category', $data);
        $this->load->view('footer', $data);
    }
    public function getListeSpecialites()
    {

        // $requestData = $_REQUEST;
        $id_prestation = $this->input->get("idPrestation");
        $nom_service = $this->input->get("nomService");
        $nom_specialite = $this->input->get("nomSpecialite");

        $id_current_specialite = $this->home_model->getIdCurrentSpecialite($nom_service, $nom_specialite);
        $data['specialites'] = $this->home_model->getCurrentSpecialiteAndPossibleList($nom_service, $nom_specialite);
        $selectHtml = "";

        $selectHtml .= "<option value='" . $nom_specialite . "'>" . $nom_specialite . "</option>";
        foreach ($data['specialites'] as $specialite) {
            $selectHtml .= "<option value='" . $specialite->name_specialite . "'>" . $specialite->name_specialite . "</option>";
        }
        echo json_encode($selectHtml);
    }

    public function getOrganisations()
    {
        $requestData = $_REQUEST;
        $data['organisations'] = $this->home_model->getOrganisations();

        foreach ($data['organisations'] as $organisation) {
            $options_edit = '<a class="button" class="btn btn-xs btn_widt btn-liste" title="Modifier Organisation"  href="home/superEditOrganisation?id=' . $organisation->id . '"><i class="fa fa-edit"></i> </a>';
            $options_edit .= '<a class="button" style="margin-left:15px;" class="btn btn-xs btn_widt btn-liste" title="Liste Adminstrateurs"  href="home/superOrganisationUsers?id=' . $organisation->id . '"><i class="fa fa-hospital-user"></i> </a>';
            $options_edit .= '<a class="button" style="margin-left:15px;" class="btn btn-xs btn_widt btn-liste" title="Liste Patients"  href="home/superOrganisationPatient?id=' . $organisation->id . '"><i class="fa fa-users-medical"></i> </a>';
            $options_edit .= '<a class="button" style="margin-left:15px;" class="btn btn-xs btn_widt btn-liste" title="Liste Actes"  href="home/payment?id=' . $organisation->id . '"><i class="fa fa-file"></i> </a>';
            $options_edit .= '<a class="button" style="margin-left:15px;" class="btn btn-xs btn_widt btn-liste" title="Recettes & Dépenses"  href="home/financialReport?id=' . $organisation->id . '"><i class="fa fa-money-bill-alt"></i> </a>';
            $options_edit2 = '<a class="button" style="margin-left:15px;" class="btn btn-xs btn_widt btn-liste" title="Ajouter Organisation light"  href="home/organisationslight?id=' . $organisation->id . '"><i class="fa fa-folder-plus"></i> </a>';
            $options_edit2 .= '<a class="button" style="margin-left:15px;" class="btn btn-xs btn_widt btn-liste" title="Ajouter Organisation"  href="home/organisationsnolight?id=' . $organisation->id . '"><i class="fa fa-building"></i> </a>';

            // $options_edit = '';
            $status = '';
            if ($organisation->est_active == '1') {
                $status = '<span class="status-p bg-success2">ACTIF</span>';
                // $status = '';
            } else {
                $status = '<span class="status-p bg-success2">INACTIF</span>';
            }
            $img_url = '';
            if ($organisation->path_logo && !empty($organisation->path_logo)) {
                // $img_url = '<a href="#"><img src="' . $organisation->path_logo . '" alt=""> </a>';
                $img_url = '<img style="max-width:200px;max-height:90px;" src="' . $organisation->path_logo . '" alt="Lgo">';
                // $img_url = '';
            } else {
                $img_url = '<img style="max-width:200px;max-height:90px;" src="uploads/logosPartenaires/default.png" alt="Lgo">';
            }

            // $buff = $organisation->pin_partenaire_zuuluPay_encrypted;
            // $buff2 = $this->encryption->decrypt($buff);
            // $this->session->set_flashdata('feedback', $buff." <br/>".$buff2);
            // $this->session->set_flashdata('feedback', "abc: ".$organisation->date_mise_a_jour."def");
            // $mise_a_jour = $organisation->date_mise_a_jour != "" ? date('d/m/Y H:i:s', $organisation->date_mise_a_jour) : "";
            $info[] = array(
                $organisation->id,
                $organisation->code,
                $img_url,
                $organisation->nom,
                $organisation->type,
                $organisation->adresse,
                $organisation->prenom_responsable_legal . " " . $organisation->nom_responsable_legal,
                // $organisation->portable_responsable_legal, 
                $status,
                $options_edit, $options_edit2
            );
        }

        if (!empty($data['organisations'])) {
            $output = array(
                //  "draw" => intval($requestData['draw']),
                "recordsTotal" => count($data['organisations']),
                "recordsFiltered" => count($data['organisations']),
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

    public function getOrganisationsForAppointment()
    {
        $requestData = $_REQUEST;
        $data['organisations'] = $this->home_model->getOrganisationsForAppointment();

        foreach ($data['organisations'] as $organisation) {
            $options_edit = '<a class="button" class="btn btn-xs btn_widt btn-liste" title="Calendrier Organisation"  href="appointment/calendarForAppointment?id_organisation=' . $organisation->id . '"><i class="fa fa-calendar-check"></i></a>';
            // $options_edit = '';
            $status = '';
            if ($organisation->est_active == '1') {
                $status = '<span class="status-p bg-success2">ACTIF</span>';
                // $status = '';
            } else {
                $status = '<span class="status-p bg-success2">INACTIF</span>';
            }
            $img_url = '';
            if ($organisation->path_logo && !empty($organisation->path_logo)) {
                // $img_url = '<a href="#"><img src="' . $organisation->path_logo . '" alt=""> </a>';
                $img_url = '<img style="max-width:200px;max-height:90px;" src="' . $organisation->path_logo . '" alt="Lgo">';
                // $img_url = '';
            } else {
                $img_url = '<img style="max-width:200px;max-height:90px;" src="uploads/logosPartenaires/default.png" alt="Lgo">';
            }

            // $buff = $organisation->pin_partenaire_zuuluPay_encrypted;
            // $buff2 = $this->encryption->decrypt($buff);
            // $this->session->set_flashdata('feedback', $buff." <br/>".$buff2);
            // $this->session->set_flashdata('feedback', "abc: ".$organisation->date_mise_a_jour."def");
            // $mise_a_jour = $organisation->date_mise_a_jour != "" ? date('d/m/Y H:i:s', $organisation->date_mise_a_jour) : "";
            $info[] = array(
                // $organisation->id,
                // $organisation->code,
                $img_url,
                $organisation->nom,
                $organisation->type,
                // date('d/m/Y H:i:s', $organisation->date_creation),
                // $mise_a_jour,
                // $this->encryption->decrypt($organisation->pin_partenaire_zuuluPay_encrypted),
                // $organisation->numero_fixe, 
                $organisation->adresse,
                $organisation->prenom_responsable_legal . " " . $organisation->nom_responsable_legal,
                // $organisation->portable_responsable_legal, 
                $status,
                $options_edit
            );
        }

        if (!empty($data['organisations'])) {
            $output = array(
                //  "draw" => intval($requestData['draw']),
                "recordsTotal" => count($data['organisations']),
                "recordsFiltered" => count($data['organisations']),
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

    public function getOrganisationUsers()
    {
        $requestData = $_REQUEST;
        $id_organisation = $requestData["id"];
        $data['organisationUsers'] = $this->home_model->getOrganisationUsers($id_organisation);

        // $this->session->set_flashdata('feedback', print_r($data));
        // $this->session->set_flashdata('feedback', "abc: ".$id_organisation." ".$data['organisationUsers']);
        foreach ($data['organisationUsers'] as $user) {
            $options_edit = '<a class="button" class="btn btn-xs btn_widt btn-liste" title="Modifier Organisation"  href="home/superEditOrganisationUser?id=' . $user->id . '&idOrganisation=' . $user->id_organisation . '"><i class="fa fa-edit"></i> </a>';
            // $options_edit .= '<a class="button" style="margin-left:15px;" class="btn btn-xs btn_widt btn-liste" title="Modifier Liste Utilisateurs"  href="home/superOrganisationUsers?id=' . $organisation->id . '"><i class="fa fa-hospital-user"></i> </a>';
            // $options_edit = '';
            $status = '';
            if ($user->active == '1') {
                $status = '<span class="status-p bg-success2">ACTIF</span>';
                // $status = '';
            } else {
                $status = '<span class="status-p bg-success2">INACTIF</span>';
            }
            $options_Patient = '<a class="button" class="btn btn-xs btn_widt btn-liste" title="Modifier Organisation"  href="home/superEditOrganisationUser?id=' . $user->id . '&idOrganisation=' . $user->id_organisation . '"><i class="fa fa-profil"></i> </a>';
            $img_url = '';
            // if ($organisation->path_logo) {
            // $img_url = '<img src="'.$organisation->path_logo.'" alt="Lgo">';
            // }

            // $buff = $organisation->pin_partenaire_zuuluPay_encrypted;
            // $buff2 = $this->encryption->decrypt($buff);
            // $this->session->set_flashdata('feedback', $buff." <br/>".$buff2);

            $last_login = $user->last_login != "" ? date('d/m/Y H:i:s', $user->last_login) : "";
            $info[] = array(
                // $user->id,
                // $img_url,
                $user->first_name . " " . $user->last_name,
                $user->groupLabelFr,
                $user->phone,
                // $this->encryption->decrypt($organisation->pin_partenaire_zuuluPay_encrypted),
                // $organisation->numero_fixe, 
                $user->email,
                $last_login,
                // date('d/m/Y H:i:s', $user->created_on), 
                // $organisation->portable_responsable_legal, 
                $status,
                $options_edit,

            );
        }

        if (!empty($data['organisationUsers'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => count($data['organisationUsers']),
                "recordsFiltered" => count($data['organisationUsers']),
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

    public function getOrganisationAdminUsers()
    {
        $requestData = $_REQUEST;
        $id_organisation = $requestData["id"];
        $data['organisationUsers'] = $this->home_model->getOrganisationAdminUsers($id_organisation);

        // $this->session->set_flashdata('feedback', print_r($data));
        // $this->session->set_flashdata('feedback', "abc: ".$id_organisation." ".$data['organisationUsers']);
        foreach ($data['organisationUsers'] as $user) {
            $options_edit = '<a class="button" class="btn btn-xs btn_widt	 btn-liste" title="Modifier Organisation"  href="home/superEditOrganisationUser?id=' . $user->id . '&idOrganisation=' . $user->id_organisation . '"><i class="fa fa-edit"></i> </a>';
            // $options_edit .= '<a class="button" style="margin-left:15px;" class="btn btn-xs btn_widt btn-liste" title="Modifier Liste Utilisateurs"  href="home/superOrganisationUsers?id=' . $organisation->id . '"><i class="fa fa-hospital-user"></i> </a>';
            // $options_edit = '';
            $status = '';
            if ($user->active == '1') {
                $status = '<span class="status-p bg-success2">ACTIF</span>';
                // $status = '';
            } else {
                $status = '<span class="status-p bg-success2">INACTIF</span>';
            }
            $img_url = '';
            // if ($organisation->path_logo) {
            // $img_url = '<img src="'.$organisation->path_logo.'" alt="Lgo">';
            // }

            // $buff = $organisation->pin_partenaire_zuuluPay_encrypted;
            // $buff2 = $this->encryption->decrypt($buff);
            // $this->session->set_flashdata('feedback', $buff." <br/>".$buff2);

            $last_login = $user->last_login != "" ? date('d/m/Y H:i:s', $user->last_login) : "";
            $info[] = array(
                // $user->id,
                // $img_url,
                $user->first_name . " " . $user->last_name,
                $user->groupLabelFr,
                $user->phone,
                // $this->encryption->decrypt($organisation->pin_partenaire_zuuluPay_encrypted),
                // $organisation->numero_fixe, 
                $user->email,
                $last_login,
                // date('d/m/Y H:i:s', $user->created_on), 
                // $organisation->portable_responsable_legal, 
                $status,
                $options_edit
            );
        }

        if (!empty($data['organisationUsers'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => count($data['organisationUsers']),
                "recordsFiltered" => count($data['organisationUsers']),
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

    function getDepartementsByRegion()
    {
        // $id_region = $this->input->post('id');
        $requestData = $_REQUEST;
        $id_region = $requestData["id"];
        $data = $this->home_model->getDepartementsByRegion($id_region);
        echo json_encode($data);
    }

    function getArrondissementsByDepartement()
    {
        // $id_departement = $this->input->post('id');
        $requestData = $_REQUEST;
        $id_departement = $requestData["id"];
        $data = $this->home_model->getArrondissementsByDepartement($id_departement);
        echo json_encode($data);
    }

    function getCollectivitesByArrondissement()
    {
        // $id_departement = $this->input->post('id');
        $requestData = $_REQUEST;
        $id_arrondissement = $requestData["id"];
        $data = $this->home_model->getCollectivitesByArrondissement($id_arrondissement);
        echo json_encode($data);
    }

    function clientHistory()
    {
        $data = array();
        $id = $this->input->get('id');

        $data['clients'] = $this->home_model->getSettingById($id);
        $data['employee_histories'] = $this->settings_model->getSettingsHistoryId($id);

        $data['tabMenu'] = $this->settings_model->getMenu($data['clients']->code);

        foreach ($data['employee_histories'] as $patient_history) {
            if ($patient_history->category == 'employe') {
                $description_tab = explode(',', str_replace('}', '', str_replace('{', '', str_replace('"', '', $patient_history->description))));
                $description_tab1 = explode(':', $description_tab[0]);
                $description_tab2 = explode(':', $description_tab[1]);
                $description_email = explode(':', $description_tab[2]);
                $description_adress = explode(':', $description_tab[3]);
                $description_phone = explode(':', $description_tab[4]);
                $description_dep = explode(':', $description_tab[5]);
                $description_service = explode(':', $description_tab[6]);
                $description_poste = explode(':', $description_tab[7]);


                $description = '<b> Prenom:</b> ' . $description_tab1[1] . ', <b> Nom:</b> ' . $description_tab2[1];
                $description .= ', <b>Email:</b> ' . $description_email[1] . ',  <b> Telephone:</b> ' . $description_adress[1];
                $description .= ', <b>Genre:</b> ' . $description_phone[1] . ', <b> Departement:</b> ' . $description_dep[1] . ', <b> Service:</b> ' . $description_service[1] . ', <b> Poste:</b> ' . $description_poste[1];

                $timeline[] = '<div class="panel-body profile-activity" >
          <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('patient_info') . '</span></h5>
          <h5 class="pull-right"><i class=" fa fa-calendar"></i>' . $patient_history->date . '</h5>
          <div class="activity purplee">
          <span>
          <i class="fa fa-user"></i>
          </span>
          <div class="activity-desk">
          <div class="panel_ col-md-6">
          <div class="panel-body">
          <div class="arrow"></div>
          <i class=" fa fa-list"></i>
          <h4> ' . $patient_history->title . ' <a class="pull-right" title="" > <i class=" fa fa-user"></i> par  ' . $patient_history->user_name . '</a> </h4>
          <p></p>

          <p>' . $description . '</p>


          </div>
          </div>
          </div>
          </div>
          </div>';
            } else if ($patient_history->category == 'status') {
                $description_tab = explode(',', str_replace('}', '', str_replace('{', '', str_replace('"', '', $patient_history->description))));
                $description_tab0 = explode(':', $description_tab[0]);
                $desc0 = 'actif';
                if ($description_tab0[1] == '0') {
                    $desc0 = 'inactif';
                }
                $description = '<b>Changement statut en :</b> ' . $desc0;

                $timeline[] = '<div class="panel-body profile-activity" >
          <h5 class="pull-left"><span class="label pull-right r-activity">' . lang('patient_info') . '</span></h5>
          <h5 class="pull-right"><i class=" fa fa-calendar"></i>' . $patient_history->date . '</h5>
          <div class="activity purplee">
          <span>
          <i class="fa fa-user"></i>
          </span>
          <div class="activity-desk">
          <div class="panel_ col-md-6">
          <div class="panel-body">
          <div class="arrow"></div>
          <i class=" fa fa-list"></i>
          <h4> ' . $patient_history->title . ' <a class="pull-right" title="" > <i class=" fa fa-user"></i> par  ' . $patient_history->user_name . '</a> </h4>
          <p></p>

          <p>' . $description . '</p>


          </div>
          </div>
          </div>
          </div>
          </div>';
            } else if ($patient_history->category == 'document') {

                $description_tab = explode(',', str_replace('}', '', str_replace('{', '', str_replace('"', '', $patient_history->description))));

                $description_tab0 = explode(':', $description_tab[1]);
                $description = str_replace('\/', '/', $description_tab0[1]);


                $timeline[] = '<div class="panel-body profile-activity" >
          <h5 class="pull-left"><span class="label pull-right r-activity"></span></h5>
          <h5 class="pull-right"><i class=" fa fa-calendar"></i>' . $patient_history->date . '</h5>
          <div class="activity purplee">
          <span>
          <i class="fa fa-file"></i>
          </span>
          <div class="activity-desk">
          <div class="panel_ col-md-6">
          <div class="panel-body">
          <div class="arrow"></div>
          <i class=" fa fa-list"></i>
          <h4> ' . $patient_history->title . '
          <a class="pull-right" title="" > <i class=" fa fa-user"></i> par  ' . $patient_history->user_name . '</a>
          </h4>


          <p> <a class="" title="' . lang('download') . '"  href="' . $description . '" download=""> <i class=" fa fa-download"></i> Télécharger</a>
          </p>

          </div>
          </div>
          </div>
          </div>
          </div>';
            }
        }

        if (!empty($timeline)) {
            $data['timeline'] = $timeline;
        }
        $this->load->view('home/admdashboard', $data); // just the header file
        $this->load->view('home/client_history', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function updateClient()
    {

        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $title = $this->input->post('title');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $currency = $this->input->post('currency');
        $logo = $this->input->post('logo');
        $buyer = $this->input->post('buyer');
        $p_code = $this->input->post('p_code');
        $code = $this->input->post('code');
        $responsable_name = $this->input->post('responsable_name');
        $responsable_phone = $this->input->post('responsable_phone');

        if (!empty($email)) {
            // $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            // Validating Name Field
            $this->form_validation->set_rules('name', 'System Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            // Validating Title Field
            $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            // Validating Email Field
            $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            // Validating Address Field    
            $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[1]|max_length[500]|xss_clean');
            // Validating Phone Field           
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[1]|max_length[50]|xss_clean');
            // Validating Currency Field   
            $this->form_validation->set_rules('currency', 'Currency', 'trim|min_length[1]|max_length[50]|xss_clean');
            // Validating Logo Field   
            $this->form_validation->set_rules('logo', 'Logo', 'trim|min_length[1]|max_length[1000]|xss_clean');
            // Validating Department Field   
            $this->form_validation->set_rules('buyer', 'Buyer', 'trim|min_length[5]|max_length[500]|xss_clean');
            // Validating Phone Field           
            $this->form_validation->set_rules('p_code', 'Purchase Code', 'trim|min_length[5]|max_length[50]|xss_clean');
            $this->form_validation->set_rules('responsable', 'responsable', 'trim|min_length[1]|max_length[50]|xss_clean');
            $this->form_validation->set_rules('phone_responsable', 'phone responsable', 'trim|min_length[1]|max_length[50]|xss_clean');
            if (empty($id)) {
                $code = date('dmHis');
            }
            if ($this->form_validation->run() == FALSE) {
                $data = array();
                $data['settings'] = $this->settings_model->getSettings();

                $this->load->view('home/admdashboard', $data); // just the header file
                $this->load->view('home/admhome', $data);
                $this->load->view('home/footer'); // just the footer file
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
                    'upload_path' => "./uploads/",
                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => False,
                    'max_size' => "60480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    // 'max_height' => "1768",
                    // 'max_width' => "2024"
                );

                $this->load->library('Upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('img_url')) {
                    $path = $this->upload->data();
                    $img_url = "uploads/" . $path['file_name'];
                    $data = array();
                    $data = array(
                        'system_vendor' => $name,
                        'title' => $title,
                        'address' => $address,
                        'phone' => $phone,
                        'email' => $email,
                        'currency' => $currency,
                        'codec_username' => $buyer,
                        'codec_purchase_code' => $p_code,
                        'logo' => $img_url,
                        'responsable_phone' => $responsable_phone,
                        'responsable_name' => $responsable_name, 'status' => 1, 'code' => $code
                    );
                } else {
                    $data = array();
                    $data = array(
                        'system_vendor' => $name,
                        'title' => $title,
                        'address' => $address,
                        'phone' => $phone,
                        'email' => $email,
                        'currency' => $currency,
                        'codec_username' => $buyer,
                        'codec_purchase_code' => $p_code,
                        'responsable_phone' => $responsable_phone,
                        'responsable_name' => $responsable_name, 'status' => 1, 'code' => $code
                    );
                }

                //$error = array('error' => $this->upload->display_errors());
                if (empty($id)) {

                    $this->home_model->addSettingsClient($data);
                    $this->home_model->addClientSQL($code);
                    $title = 'Creation client';
                } else {
                    $title = 'modification client';
                    $this->home_model->updateSettingsClient($id, $data);
                }
                $data_insert = array('client_id' => $id, 'client_name' => $title, 'title' => $title, 'category' => 'client', 'description' => json_encode($data), 'date' => date('d/m/y H:i'), 'user_id' => $this->ion_auth->user()->row()->id, 'user_name' => $this->ion_auth->user()->row()->username);

                $this->home_model->addClientHistoryId($data_insert);
                $this->session->set_flashdata('feedback', lang('updated'));
                // Loading View
                if (empty($id)) {
                    redirect('home/admhome');
                } else {
                    $idp = 'home/clientHistory?id=' . $id;
                    redirect($idp);
                }
            }
        } else {
            $this->session->set_flashdata('feedback', lang('email_required'));
            redirect('home/admhome', 'refresh');
        }
    }



    public function financialReport()
    {
        $data = array();
        $id = $this->input->get('id');
        $data['paymentExpense'] = $this->finance_model->getPaymentExpenseByOrganisation($id);
        $data["organisation"] = $this->home_model->getOrganisationById($id);
        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('financial_report', $data);
        $this->load->view('footer', $data);
    }

    function addOrganisation()
    {

        $id = $this->input->post('id');
        $nom = $this->input->post('nom');
        $nom_commercial = $this->input->post('nom_commercial');
        $description_courte_activite = $this->input->post('description_courte_activite');
        $description_courte_services = $this->input->post('description_courte_services');
        $slogan = $this->input->post('slogan');
        $horaires_ouverture = $this->input->post('horaires_ouverture');
        $logo = $this->input->post('logo');
        $path_logo = "";
        $entete = $this->input->post('entete');
        $footer = $this->input->post('footer');
        $signature = $this->input->post('signature');
        $path_footer = "";
        $path_entete = "";
        $path_signature = "";
        $adresse = $this->input->post('adresse');
        $region = $this->input->post('region');
        $departement = $this->input->post('departement');
        $arrondissement = $this->input->post('arrondissement');
        $collectivite = $this->input->post('collectivite');
        $pays = $this->input->post('pays');
        $email = $this->input->post('email');
        $numero_fixe = $this->input->post('numero_fixe');
        $prenom_responsable_legal = $this->input->post('prenom_responsable_legal');
        $nom_responsable_legal = $this->input->post('nom_responsable_legal');
        $portable_responsable_legal = $this->input->post('portable_responsable_legal');
        $fonction_responsable_legal = $this->input->post('fonction_responsable_legal');
        $description_courte_responsable_legal = $this->input->post('description_courte_responsable_legal');
        $prenom_responsable_legal2 = $this->input->post('prenom_responsable_legal2');
        $nom_responsable_legal2 = $this->input->post('nom_responsable_legal2');
        $portable_responsable_legal2 = $this->input->post('portable_responsable_legal2');
        $fonction_responsable_legal2 = $this->input->post('fonction_responsable_legal2');
        $description_courte_responsable_legal2 = $this->input->post('description_courte_responsable_legal2');
        $id_partenaire_zuuluPay = $this->input->post('id_partenaire_zuuluPay');
        $pin_partenaire_zuuluPay = $this->input->post('pin_partenaire_zuuluPay');
        $type = $this->input->post('type');

        // if (!empty($email)) {
        // $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('nom', 'nom', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('nom_commercial', 'nom_commercial', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('description_courte_activite', 'description_courte_activite', 'trim|max_length[255]|xss_clean');
        $this->form_validation->set_rules('description_courte_services', 'description_courte_services', 'trim|max_length[255]|xss_clean');
        $this->form_validation->set_rules('slogan', 'slogan', 'trim|max_length[255]|xss_clean');
        $this->form_validation->set_rules('horaires_ouverture', 'horaires_ouverture', 'trim|xss_clean');
        $this->form_validation->set_rules('adresse', 'adresse', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('region', 'region', array('trim', 'required', 'min_length[1]', 'max_length[255]', 'xss_clean', array('region_validate', function ($abcd) {
            if ($abcd == "Veuillez sélectionner une région" || $abcd == "---") {
                $this->form_validation->set_message('region_validate', 'Région non sélectionnée');
                return false;
            } else {
                // User picked something.
                return true;
            }
        })));
        $this->form_validation->set_rules('departement', 'departement', array('trim', 'required', 'min_length[1]', 'max_length[255]', 'xss_clean', array('departement_validate', function ($abcd) {
            if ($abcd == "Veuillez sélectionner un département" || $abcd == "---") {
                $this->form_validation->set_message('departement_validate', 'Département non sélectionné');
                return false;
            } else {
                // User picked something.
                return true;
            }
        })));
        // $this->form_validation->set_rules('arrondissement', 'arrondissement', array('trim', 'required','min_length[1]','max_length[255]','xss_clean', array('arrondissement_validate', function($abcd)
        // {
        // if($abcd == "Veuillez sélectionner un arrondissement" || $abcd == "---")
        // {
        // $this->form_validation->set_message('arrondissement_validate', 'Arrondissement non sélectionné');
        // return false;
        // } 
        // else
        // {
        // // User picked something.
        // return true;
        // }
        // })));
        $this->form_validation->set_rules('arrondissement', 'arrondissement', array('trim', 'min_length[1]', 'max_length[255]', 'xss_clean'));
        // $this->form_validation->set_rules('collectivite', 'collectivite', array('trim', 'required','min_length[1]','max_length[255]','xss_clean', array('collectivite_validate', function($abcd)
        // {
        // if($abcd == "Veuillez sélectionner une collectivité" || $abcd == "---")
        // {
        // $this->form_validation->set_message('collectivite_validate', 'Collectivité non sélectionnée');
        // return false;
        // } 
        // else
        // {
        // // User picked something.
        // return true;
        // }
        // })));
        $this->form_validation->set_rules('collectivite', 'collectivite', array('trim', 'min_length[1]', 'max_length[255]', 'xss_clean'));
        $this->form_validation->set_rules('pays', 'pays', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|min_length[5]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('numero_fixe', 'numero_fixe', 'trim|min_length[9]|max_length[45]|xss_clean');
        $this->form_validation->set_rules('prenom_responsable_legal', 'prenom_responsable_legal', 'trim|required|min_length[2]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('nom_responsable_legal', 'nom_responsable_legal', 'trim|required|min_length[2]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('portable_responsable_legal', 'portable_responsable_legal', 'trim|required|min_length[9]|max_length[45]|xss_clean');
        $this->form_validation->set_rules('fonction_responsable_legal', 'fonction_responsable_legal', 'trim|max_length[45]|xss_clean');
        $this->form_validation->set_rules('description_courte_responsable_legal', 'description_courte_responsable_legal', 'trim|max_length[45]|xss_clean');
        $this->form_validation->set_rules('prenom_responsable_legal2', 'prenom_responsable_legal2', 'trim|min_length[2]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('nom_responsable_legal2', 'nom_responsable_legal2', 'trim|min_length[2]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('portable_responsable_legal2', 'portable_responsable_legal2', 'trim|min_length[9]|max_length[45]|xss_clean');
        $this->form_validation->set_rules('fonction_responsable_legal2', 'fonction_responsable_legal2', 'trim|max_length[45]|xss_clean');
        $this->form_validation->set_rules('description_courte_responsable_legal2', 'description_courte_responsable_legal2', 'trim|max_length[45]|xss_clean');
        //   $this->form_validation->set_rules('id_partenaire_zuuluPay', 'id_partenaire_zuuluPay', 'trim|required|min_length[10]|max_length[10]|xss_clean');
        $this->form_validation->set_rules('pin_partenaire_zuuluPay', 'pin_partenaire_zuuluPay', 'trim|required|min_length[4]|max_length[12]|xss_clean');
        $this->form_validation->set_rules('type', 'type', array('trim', 'required', 'min_length[1]', 'max_length[255]', 'xss_clean', array('type_validate', function ($abcd) {
            if ($abcd == "Veuillez sélectionner un type" || $abcd == "---") {
                $this->form_validation->set_message('type_validate', 'Type non sélectionné');
                return false;
            } else {
                // User picked something.
                return true;
            }
        })));
        $this->form_validation->set_rules('logo', 'logo', 'trim|min_length[1]|max_length[1000]|xss_clean');

        // if (empty($id)) {
        // $code = date('dmHis');
        // }
        // if ($this->form_validation->run($this) === FALSE) {
        if ($this->form_validation->run($this) === FALSE) {
            $data = array();
            // $data['settings'] = $this->settings_model->getSettings();
            // $data['organisations'] = $this->home_model->getOrganisations();
            $data['regions_senegal'] = $this->home_model->getRegionsSenegal();
            $data['setval'] = 'setval';
            if (!empty($id)) {
                $data['organisation']->id = $id;
                // ($data['organisation'])->pin_partenaire_zuuluPay = $this->encryption->decrypt(($data['organisation'])->pin_partenaire_zuuluPay_encrypted);
            }
            $this->load->view('superdashboard', $data); // just the header file
            $this->load->view('superAddOrganisation', $data);
            $this->load->view('footer', $data);
            return;

            // $this->session->set_flashdata('feedback', "Erreur formulaire:".validation_errors());

            // redirect('home/superAddOrganisation', 'refresh');

            // $this->load->view('home/superdashboard', $data); // just the header file
            // $this->load->view('home/superhome', $data);
            // $this->load->view('home/footer'); // just the footer file

        }
        // else {
        // $this->session->set_flashdata('feedback', "Formulaire OK");

        // $this->load->view('home/superdashboard', $data); // just the header file
        // $this->load->view('home/superhome', $data);
        // $this->load->view('home/footer'); // just the footer file
        // }
        else {

            $file_name = $_FILES['logo']['name'];
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


            // Entete 
            $file_name_entete = $_FILES['entete']['name'];
            $file_name_pieces_entete = explode('_', $file_name_entete);
            $new_file_name_entete = '';
            $count_entete = 1;
            foreach ($file_name_pieces_entete as $piece) {
                if ($count_entete !== 1) {
                    $piece = ucfirst($piece);
                }

                $new_file_name_entete .= $piece;
                $count_entete++;
            }


            // Footer 
            $file_name_footer = $_FILES['footer']['name'];
            $file_name_pieces_footer = explode('_', $file_name_footer);
            $new_file_name_footer = '';
            $count_footer = 1;
            foreach ($file_name_pieces_footer as $piece) {
                if ($count_footer !== 1) {
                    $piece = ucfirst($piece);
                }

                $new_file_name_footer .= $piece;
                $count_footer++;
            }

            // Signature 
            $file_name_signature = $_FILES['footer']['name'];
            $file_name_pieces_footer = explode('_', $file_name_signature);
            $new_file_name_signature = '';
            $count_signature = 1;
            foreach ($file_name_pieces_signature as $piece) {
                if ($count_signature !== 1) {
                    $piece = ucfirst($piece);
                }

                $new_file_name_signature .= $piece;
                $count_signature++;
            }




            $config = array(
                'file_name' => $id_partenaire_zuuluPay . "_" . $new_file_name,
                'upload_path' => "./uploads/entetePartenaires/",
                'allowed_types' => "gif|jpg|png|jpeg",
                // 'overwrite' => false,
                'max_size' => "60480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                // 'max_height' => "200",
                // 'max_width' => "90"
            );

            $config_entete = array(
                'file_name' => $id_partenaire_zuuluPay . "_" . $new_file_name_entete,
                'upload_path' => "./uploads/entetePartenaires/",
                'allowed_types' => "gif|jpg|png|jpeg",
                // 'overwrite' => false,
                'max_size' => "60480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                // 'max_height' => "200",
                // 'max_width' => "90"
            );


            $config_footer = array(
                'file_name' => $id_partenaire_zuuluPay . "_" . $new_file_name_footer,
                'upload_path' => "./uploads/entetePartenaires/",
                'allowed_types' => "gif|jpg|png|jpeg",
                // 'overwrite' => false,
                'max_size' => "60480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                // 'max_height' => "200",
                // 'max_width' => "90"
            );

            $config_signature = array(
                'file_name' => $id_partenaire_zuuluPay . "_" . $new_file_name_signature,
                'upload_path' => "./uploads/entetePartenaires/",
                'allowed_types' => "gif|jpg|png|jpeg",
                // 'overwrite' => false,
                'max_size' => "60480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                // 'max_height' => "200",
                // 'max_width' => "90"
            );



            $this->load->library('upload', $config);
            $this->load->library('upload', $config_entete);
            $this->load->library('upload', $config_footer);
            $this->load->library('upload', $config_signature);
            $this->upload->initialize($config);
            $this->upload->initialize($config_entete);
            $this->upload->initialize($config_footer);
            $this->upload->initialize($config_signature);



            if ($this->upload->do_upload('logo')) {
                $path = $this->upload->data();
                $img_url = "uploads/entetePartenaires/" . $path['file_name'];
                $data = array();

                $data['path_logo'] = $img_url;
                $logo = "uploads/entetePartenaires/" . $path['file_name'];

                $dataImg = array(
                    'path_logo' => $img_url
                );
            } else if ($this->upload->do_upload('entete')) {
                $path = $this->upload->data();
                $img_url = "uploads/entetePartenaires/" . $path['file_name'];
                $data = array();

                $data['entete'] = "uploads/entetePartenaires/" . $path['file_name'];
                $entete = "uploads/entetePartenaires/" . $path['file_name'];

                $dataImg = array(
                    'entete' => $entete
                );
            } else if ($this->upload->do_upload('footer')) {
                $path = $this->upload->data();
                $img_url = "uploads/entetePartenaires/" . $path['file_name'];
                $data = array();

                $data['footer'] = "uploads/entetePartenaires/" . $path['file_name'];
                $footer = "uploads/entetePartenaires/" . $path['file_name'];

                $dataImg = array(
                    'footer' => $footer
                );
            } else if ($this->upload->do_upload('signature')) {
                $path = $this->upload->data();
                $img_url = "uploads/entetePartenaires/" . $path['file_name'];
                $data = array();

                $data['footer'] = "uploads/entetePartenaires/" . $path['file_name'];
                $footer = "uploads/entetePartenaires/" . $path['file_name'];

                $dataImg = array(
                    'signature' => $footer
                );
            } else { // Si pas d'upload effectif
                if (trim($new_file_name) != "") { // S k fichier uploadé tout court // Si oui: erreur upload
                    $data = array();
                    // $data['settings'] = $this->settings_model->getSettings();
                    // $data['organisations'] = $this->home_model->getOrganisations();
                    $data['regions_senegal'] = $this->home_model->getRegionsSenegal();
                    $data['setval'] = 'setval';
                    $data['display_errors'] = "Upload Not ok: " . $this->upload->display_errors();

                    if (!empty($id)) {
                        $data['organisation']->id = $id;
                        // ($data['organisation'])->pin_partenaire_zuuluPay = $this->encryption->decrypt(($data['organisation'])->pin_partenaire_zuuluPay_encrypted);
                    }
                    $this->load->view('superdashboard', $data); // just the header file
                    $this->load->view('superAddOrganisation', $data);
                    $this->load->view('footer', $data);
                    return;
                } else { // Sinon: pas de tentative d'upload
                    $dataImg = array(); // Pas d'image à insérer ou mettre à jour
                }
            }

            //$error = array('error' => $this->upload->display_errors());
            // $array_merged = array();
            $output = "before";
            $arrondissement = ($arrondissement == "Veuillez sélectionner un arrondissement" || $arrondissement == "---") ? "" : $arrondissement;
            $collectivite = ($collectivite == "Veuillez sélectionner une collectivité" || $collectivite == "---") ? "" : $collectivite;
            if (empty($id)) {
                $pin_partenaire_zuuluPay_encrypted = $this->encryption->encrypt($pin_partenaire_zuuluPay);
                $data_insert = array('nom' => $nom, 'nom_commercial' => $nom_commercial, 'description_courte_activite' => $description_courte_activite, 'description_courte_services' => $description_courte_services, 'slogan' => $slogan, 'horaires_ouverture' => $horaires_ouverture, 'adresse' => $adresse, 'region' => $region, 'departement' => $departement, 'arrondissement' => $arrondissement, 'collectivite' => $collectivite, 'pays' => $pays, 'email' => $email, 'numero_fixe' => $numero_fixe, 'prenom_responsable_legal' => $prenom_responsable_legal, 'nom_responsable_legal' => $nom_responsable_legal, 'portable_responsable_legal' =>  $portable_responsable_legal, 'fonction_responsable_legal' =>  $fonction_responsable_legal, 'description_courte_responsable_legal' =>  $description_courte_responsable_legal, 'prenom_responsable_legal2' => $prenom_responsable_legal2, 'nom_responsable_legal2' => $nom_responsable_legal2, 'portable_responsable_legal2' =>  $portable_responsable_legal2, 'fonction_responsable_legal2' =>  $fonction_responsable_legal2, 'description_courte_responsable_legal2' =>  $description_courte_responsable_legal2, 'id_partenaire_zuuluPay' => $id_partenaire_zuuluPay, 'pin_partenaire_zuuluPay_encrypted' => $pin_partenaire_zuuluPay_encrypted, 'type' => $type, 'est_active' => 1, 'date_creation' => strtotime(date('Y-m-d H:i:s')));
                $array_merged = array_merge($data_insert, $dataImg);

                $output = $this->home_model->addOrganisation($array_merged);
                // $this->home_model->addSettingsClient($data);
                // $this->home_model->addClientSQL($code);
                // $title = 'Creation client';
            } else {
                $pin_partenaire_zuuluPay_encrypted = $this->encryption->encrypt($pin_partenaire_zuuluPay);
                $data_update = array('nom' => $nom, 'nom_commercial' => $nom_commercial, 'description_courte_activite' => $description_courte_activite, 'description_courte_services' => $description_courte_services, 'slogan' => $slogan, 'horaires_ouverture' => $horaires_ouverture, 'adresse' => $adresse, 'region' => $region, 'departement' => $departement, 'arrondissement' => $arrondissement, 'collectivite' => $collectivite, 'pays' => $pays, 'email' => $email, 'numero_fixe' => $numero_fixe, 'prenom_responsable_legal' => $prenom_responsable_legal, 'nom_responsable_legal' => $nom_responsable_legal, 'portable_responsable_legal' =>  $portable_responsable_legal, 'fonction_responsable_legal' =>  $fonction_responsable_legal, 'description_courte_responsable_legal' =>  $description_courte_responsable_legal, 'prenom_responsable_legal2' => $prenom_responsable_legal2, 'nom_responsable_legal2' => $nom_responsable_legal2, 'portable_responsable_legal2' =>  $portable_responsable_legal2, 'fonction_responsable_legal2' =>  $fonction_responsable_legal2, 'description_courte_responsable_legal2' =>  $description_courte_responsable_legal2, 'id_partenaire_zuuluPay' => $id_partenaire_zuuluPay, 'pin_partenaire_zuuluPay_encrypted' => $pin_partenaire_zuuluPay_encrypted, 'type' => $type, 'est_active' => 1, 'date_mise_a_jour' => strtotime(date('Y-m-d H:i:s')));
                // $this->session->set_flashdata('feedback', "Merge: ".count($dataImg));
                $array_merged = array_merge($data_update, $dataImg);
                $this->home_model->updateOrganisation($id, $array_merged);
                // var_dump(array_merge($array_merged));
                // exit();
                // $this->home_model->updateSettingsClient($id, $data);
            }
            // $data_insert = array('client_id' => $id, 'client_name' => $title, 'title' => $title, 'category' => 'client', 'description' => json_encode($data), 'date' => date('d/m/y H:i'), 'user_id' => $this->ion_auth->user()->row()->id, 'user_name' => $this->ion_auth->user()->row()->username);

            // $this->home_model->addClientHistoryId($data_insert);

            // Loading View
            if (empty($id)) {
                $message = $output == "ok" ? "Organisation " . lang('added') : "Erreur lors de l'insertion: " . $output;
                $this->session->set_flashdata('feedback', $message);
                redirect('home/superhome');
            } else {
                // $message = $output == "ok" ? "Organisation modifiée" : $output;
                $message = "Organisation modifiée";
                // $this->session->set_flashdata('feedback', $message." ".$arrondissement." ".$collectivite);
                $this->session->set_flashdata('feedback', $message);
                redirect('home/superhome');
            }
        }
        // } else {
        // $this->session->set_flashdata('feedback', lang('email_required'));
        // redirect('home/admhome', 'refresh');
        // }
    }

    function addOrganisationAdmin()
    {

        $id = $this->input->post('id');
        $groupe = $this->input->post('groupe');
        $prenom = $this->input->post('prenom');
        $nom = $this->input->post('nom');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $adresse = $this->input->post('adresse');
        $region = $this->input->post('region');
        $departement = $this->input->post('departement');
        $arrondissement = $this->input->post('arrondissement');
        $collectivite = $this->input->post('collectivite');
        $pays = $this->input->post('pays');


        // if (!empty($email)) {
        // $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // $this->form_validation->set_rules('groupe', 'groupe', 'trim|required|min_length[4]|max_length[255]|xss_clean|callback_groupe_validate');
        $this->form_validation->set_rules('nom', 'nom', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('prenom', 'nom', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('phone', 'phone', 'trim|min_length[9]|max_length[45]|xss_clean');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|min_length[5]|max_length[255]|xss_clean');
        if (empty($id)) {
            $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[4]|max_length[12]|xss_clean');
        }
        $this->form_validation->set_rules('adresse', 'adresse', 'trim|required|min_length[1]|max_length[255]|xss_clean');
        $this->form_validation->set_rules('groupe', 'groupe', array('trim', 'required', 'min_length[1]', 'max_length[255]', 'xss_clean', array('groupe_validate', function ($abcd) {
            if ($abcd == "Veuillez sélectionner un rôle" || $abcd == "---") {
                $this->form_validation->set_message('groupe_validate', 'Rôle non sélectionné');
                return false;
            } else {
                // User picked something.
                return true;
            }
        })));
        // $this->form_validation->set_rules('region', 'region', array('trim', 'required', 'min_length[1]', 'max_length[255]', 'xss_clean', array('region_validate', function ($abcd) {
        //     if ($abcd == "Veuillez sélectionner une région" || $abcd == "---") {
        //         $this->form_validation->set_message('region_validate', 'Région non sélectionnée');
        //         return false;
        //     } else {
        //         // User picked something.
        //         return true;
        //     }
        // })));
        // $this->form_validation->set_rules('departement', 'departement', array('trim', 'required', 'min_length[1]', 'max_length[255]', 'xss_clean', array('departement_validate', function ($abcd) {
        //     if ($abcd == "Veuillez sélectionner un département" || $abcd == "---") {
        //         $this->form_validation->set_message('departement_validate', 'Département non sélectionné');
        //         return false;
        //     } else {
        //         // User picked something.
        //         return true;
        //     }
        // })));
        // $this->form_validation->set_rules('arrondissement', 'arrondissement', array('trim', 'required','min_length[1]','max_length[255]','xss_clean', array('arrondissement_validate', function($abcd)
        // {
        // if($abcd == "Veuillez sélectionner un arrondissement" || $abcd == "---")
        // {
        // $this->form_validation->set_message('arrondissement_validate', 'Arrondissement non sélectionné');
        // return false;
        // } 
        // else
        // {
        // // User picked something.
        // return true;
        // }
        // })));
        $this->form_validation->set_rules('arrondissement', 'arrondissement', array('trim', 'min_length[1]', 'max_length[255]', 'xss_clean'));
        // $this->form_validation->set_rules('collectivite', 'collectivite', array('trim', 'required','min_length[1]','max_length[255]','xss_clean', array('collectivite_validate', function($abcd)
        // {
        // if($abcd == "Veuillez sélectionner une collectivité" || $abcd == "---")
        // {
        // $this->form_validation->set_message('collectivite_validate', 'Collectivité non sélectionnée');
        // return false;
        // } 
        // else
        // {
        // // User picked something.
        // return true;
        // }
        // })));
        $this->form_validation->set_rules('collectivite', 'collectivite', array('trim', 'min_length[1]', 'max_length[255]', 'xss_clean'));
        $this->form_validation->set_rules('pays', 'pays', 'trim|required|min_length[1]|max_length[255]|xss_clean');


        // if (empty($id)) {
        // $code = date('dmHis');
        // }
        if ($this->form_validation->run($this) === FALSE) {
            $data = array();
            // $data['settings'] = $this->settings_model->getSettings();
            // $data['organisations'] = $this->home_model->getOrganisations();
            $data['regions_senegal'] = $this->home_model->getRegionsSenegal();

            $idOrganisation = $this->input->post("idOrganisation");
            $data['organisation'] = $this->home_model->getOrganisationById($idOrganisation);

            $data['setval'] = 'setval';

            if (!empty($id)) {
                $data['user']->id = $id;
            }

            $this->load->view('superdashboard', $data); // just the header file
            $this->load->view('superAddOrganisationUser', $data);
            $this->load->view('footer', $data);
            return;

            // $this->session->set_flashdata('feedback', "Erreur formulaire:".validation_errors());

            // redirect('home/superAddOrganisation', 'refresh');

            // $this->load->view('home/superdashboard', $data); // just the header file
            // $this->load->view('home/superhome', $data);
            // $this->load->view('home/footer'); // just the footer file

        }
        // else {
        // $this->session->set_flashdata('feedback', "Formulaire OK");

        // $this->load->view('home/superdashboard', $data); // just the header file
        // $this->load->view('home/superOrganisationUsers', $data);
        // $this->load->view('home/footer'); // just the footer file
        // }
        else {

            $username = $this->input->post('prenom');
            $arrondissement = ($arrondissement == "Veuillez sélectionner un arrondissement" || $arrondissement == "---") ? "" : $arrondissement;
            $collectivite = ($collectivite == "Veuillez sélectionner une collectivité" || $collectivite == "---") ? "" : $collectivite;
            // Data
            if (empty($id)) {     // Adding New Doctor
                /*if ($this->ion_auth->email_check($email)) {
						$this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
						
						$data['regions_senegal'] = $this->home_model->getRegionsSenegal();
				
						$idOrganisation = $this->input->post("idOrganisation");
						$data['organisation'] = $this->home_model->getOrganisationById($idOrganisation);
						
						$data['setval'] = 'setval';
						$this->load->view('superdashboard', $data); // just the header file
						$this->load->view('superAddOrganisationUser', $data);
						$this->load->view('footer', $data);
						return;
						
					} else {*/
                $dfg = 1;
                $idCompany = $this->input->post('idOrganisation');
                $company = $this->db->get_where('organisation', array('id' => $idCompany))->row()->nom;
                $this->ion_auth->register($username, $password, $email, $dfg);
                $this->ion_auth->reset_activation($email, $username, $company);
                $this->ion_auth->register($username, $password, $email, $dfg);
                $ion_user_id = $this->db->get_where('users', array('email' => $email))->row()->id;
                // $this->doctor_model->insertDoctor($data);
                // $doctor_user_id = $this->db->get_where('doctor', array('email' => $email))->row()->id;
                // $id_info = array('ion_user_id' => $ion_user_id);
                $data = array('first_name' => $prenom, 'last_name' => $nom, 'phone' => $phone, 'adresse' => $adresse, 'region' => $region, 'departement' => $departement, 'arrondissement' => $arrondissement, 'collectivite' => $collectivite, 'pays' => $pays, 'id_organisation' => $this->input->post('idOrganisation'));

                $this->home_model->updateOrganisationAdmin($ion_user_id, $data);
                $this->home_model->updateUsersGroups($ion_user_id, $groupe);

                $this->session->set_flashdata('feedback', "Administrateur ajouté");
                //}
            } else { // Updating Doctor
                // $ion_user_id = $this->db->get_where('users', array('id' => $id))->row()->ion_user_id;
                // $ion_user_id = $this->db->get_where('doctor', array('id' => $id))->row()->ion_user_id;
                if ($this->ion_auth->email_check_and_not_own($email, $id)) {
                    $this->session->set_flashdata('feedback', lang('this_email_address_is_already_registered'));
                    // redirect('users/addNonAdminUser');
                    // $data = array();
                    $data['regions_senegal'] = $this->home_model->getRegionsSenegal();

                    $idOrganisation = $this->input->post("idOrganisation");
                    $data['organisation'] = $this->home_model->getOrganisationById($idOrganisation);

                    $data['setval'] = 'setval';

                    if (!empty($id)) { // Uniquement pour set le password à not required // Autrement setval est suffisant
                        $data['user']->id = $id;
                    }

                    $this->home_model->updateUsersGroups($id, $groupe);
                    $this->load->view('superdashboard', $data); // just the header file
                    $this->load->view('superAddOrganisationUser', $data);
                    $this->load->view('footer', $data);
                    return;
                } else {
                    if (empty($password)) {
                        $password = $this->db->get_where('users', array('id' => $id))->row()->password;
                    } else {
                        $password = $this->ion_auth_model->hash_password($password);
                    }
                    $this->home_model->updateIonUser($username, $email, $password, $id);


                    // $this->doctor_model->updateDoctor($id, $data);
                    $data = array('first_name' => $prenom, 'last_name' => $nom, 'phone' => $phone, 'adresse' => $adresse, 'region' => $region, 'departement' => $departement, 'arrondissement' => $arrondissement, 'collectivite' => $collectivite, 'pays' => $pays, 'id_organisation' => $this->input->post('idOrganisation'));

                    $this->home_model->updateOrganisationAdmin($id, $data);

                    $this->home_model->updateUsersGroups($id, $groupe);
                    $this->session->set_flashdata('feedback', "Administrateur modifié");
                }
            }
            // Loading View
            // redirect('superAddOrganisation');
            $idOrganisation = $this->input->post('idOrganisation');
            $data["organisation"] = $this->home_model->getOrganisationById($idOrganisation);
            $this->load->view('superdashboard', $data); // just the header file
            $this->load->view('superOrganisationUsers', $data);
            $this->load->view('footer', $data);
            // OLD
            // $output ="before";
            // if (empty($id)) {
            // $pin_partenaire_zuuluPay_encrypted = $this->encryption->encrypt($pin_partenaire_zuuluPay);
            // $data_insert = array('nom' => $nom, 'nom_commercial' => $nom_commercial, 'path_logo' => $path_logo, 'adresse' => $adresse, 'region' => $region, 'departement' => $departement, 'arrondissement' => $arrondissement, 'collectivite' => $collectivite, 'pays' => $pays, email => $email, 'numero_fixe' => $numero_fixe, 'prenom_responsable_legal' => $prenom_responsable_legal, 'nom_responsable_legal' => $nom_responsable_legal, 'portable_responsable_legal' =>  $portable_responsable_legal, 'id_partenaire_zuuluPay' => $id_partenaire_zuuluPay, 'pin_partenaire_zuuluPay_encrypted' => $pin_partenaire_zuuluPay_encrypted, 'type' => $type, 'est_active' => 1, 'date_creation' => strtotime(date('Y-m-d H:i:s')));
            // $output = $this->home_model->addOrganisation($data_insert);
            // }  else {
            // $pin_partenaire_zuuluPay_encrypted = $this->encryption->encrypt($pin_partenaire_zuuluPay);
            // $data_update = array('nom' => $nom, 'nom_commercial' => $nom_commercial, 'path_logo' => $path_logo, 'adresse' => $adresse, 'region' => $region, 'departement' => $departement, 'arrondissement' => $arrondissement, 'collectivite' => $collectivite, 'pays' => $pays, email => $email, 'numero_fixe' => $numero_fixe, 'prenom_responsable_legal' => $prenom_responsable_legal, 'nom_responsable_legal' => $nom_responsable_legal, 'portable_responsable_legal' =>  $portable_responsable_legal, 'id_partenaire_zuuluPay' => $id_partenaire_zuuluPay, 'pin_partenaire_zuuluPay_encrypted' => $pin_partenaire_zuuluPay_encrypted, 'type' => $type, 'est_active' => 1, 'date_mise_a_jour' => strtotime(date('Y-m-d H:i:s')));
            // $this->home_model->updateOrganisation($id, $data_update);
            // }

            // Loading View
            // if (empty($id)) {
            // $message = $output == "ok" ? "Organisation " . lang('added') : "Erreur lors de l'insertion";
            // $this->session->set_flashdata('feedback', $message);
            // redirect('home/superhome');
            // }  else {
            // $message = "Organisation modifiée";
            // $this->session->set_flashdata('feedback', $message);
            // redirect('home/superhome');
            // }

            // END OLD
        }
        // } else {
        // $this->session->set_flashdata('feedback', lang('email_required'));
        // redirect('home/admhome', 'refresh');
        // }
    }



    public function permission()
    {
        $this->load->view('permission');
    }

    public function organisationslight()
    {
        $data = array();
        $idOrganisation = $this->input->get('id');
        $data['organisation'] = $this->home_model->getOrganisationById($idOrganisation)->nom;

        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('organisationslight', $data);
        $this->load->view('footer', $data);
    }

    public function getOrganisationsLight()
    {
        $id = $this->input->get('id');
        $data['organisations'] = $this->home_model->getOrganisationsLight($id);

        foreach ($data['organisations'] as $organisation) {
            // $options_edit = '<a class="button"  class="btn btn-xs btn_widt btn-liste" title="Modifier Organisation"  href="home/superEditOrganisation?id=' . $organisation->id . '"><i class="fa fa-edit"></i> </a>';
            $options_edit = '<span class="button" readonly class="btn btn-xs btn_widt btn-liste" title="A venir"  ><i class="fa fa-edit"></i> </span>';
            $option2 = '<label class="switch "><input disabled  type="checkbox" id="checkbox_335" onclick="fctSwitch();"><span class="slider round"></span></label>';
            $option3 = '<label class="switch "><input disabled  type="checkbox" id="checkbox_335" onclick="fctSwitch();"><span class="slider round"></span></label>';

            $info[] = array(
                $organisation->id,
                $organisation->nom,
                $organisation->phone,
                $organisation->email,
                $options_edit, $option2, $option3
            );
        }

        if (!empty($data['organisations'])) {
            $output = array(
                //  "draw" => intval($requestData['draw']),
                // "recordsTotal" => count($data['organisations']),
                //  "recordsFiltered" => count($data['organisations']),
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

    public function getOrganisationsnoLight()
    {
        $id = $this->input->get('id');
        $data['organisations'] = $this->home_model->getOrganisationsNoLight($id);

        foreach ($data['organisations'] as $organisation) {
            $option2 = '<label class="switch"><input type="checkbox" disabled id="checkbox_335" onclick="fctSwitch(335);"><span class="slider round"></span></label>';
            $option3 = '<label class="switch"><input type="checkbox" disabled id="checkbox_335" onclick="fctSwitch(335);"><span class="slider round"></span></label>';

            $info[] = array(
                $organisation->id,
                $organisation->nom,
                $organisation->phone,
                $organisation->email,
                $option2, $option3
            );
        }

        if (!empty($data['organisations'])) {
            $output = array(
                //  "draw" => intval($requestData['draw']),
                // "recordsTotal" => count($data['organisations']),
                //  "recordsFiltered" => count($data['organisations']),
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

    function importOrganisationLight()
    {
        if (isset($_FILES["filename"]["name"])) {

            // Validation format
            $file_name = $_FILES['filename']['name'];

            $temp = explode(".", $_FILES["filename"]["name"]);
            $extension = end($temp);
            $mimes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            $allowedExts = ['xl', 'xls', 'xlsx'];

            // SI OK
            $path = $_FILES["filename"]["tmp_name"];
            $idOrganisationOrigin = $this->input->post('idOrganisationOrigin');

            $this->importOrganisationLightDetail($path, $idOrganisationOrigin);

            if (in_array($_FILES['filename']['type'], $mimes) && in_array($extension, $allowedExts)) {
                // SI OK
                $path = $_FILES["filename"]["tmp_name"];
                $idOrganisationOrigin = $this->input->post('idOrganisationOrigin');

                // $this->importOrganisationLightDetail($path, $idOrganisationOrigin);
            } else {

                $this->session->set_flashdata('feedback', lang('wrong_file_format'));

                redirect('home/organisationslight?id=' . $idOrganisationOrigin);
            }
        }
    }



    function importPatientOrganisation()
    {
        if (isset($_FILES["filename"]["name"])) {

            // Validation format
            $file_name = $_FILES['filename']['name'];

            $temp = explode(".", $_FILES["filename"]["name"]);
            $extension = end($temp);
            $mimes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            $allowedExts = ['xl', 'xls', 'xlsx'];

            // SI OK
            $path = $_FILES["filename"]["tmp_name"];
            $idOrganisationOrigin = $this->input->post('idOrganisationOrigin');

            $this->importPatientOrganisationDetail($path, $idOrganisationOrigin);

            if (in_array($_FILES['filename']['type'], $mimes) && in_array($extension, $allowedExts)) {
                // SI OK
                $path = $_FILES["filename"]["tmp_name"];
                $idOrganisationOrigin = $this->input->post('idOrganisationOrigin');

                // $this->importPatientOrganisationDetail($path, $idOrganisationOrigin);
            } else {

                $this->session->set_flashdata('feedback', lang('wrong_file_format'));

                redirect('home/superOrganisationPatient?id=' . $idOrganisationOrigin);
            }
        }
    }

    function importPatientOrganisationDetail($file, $tableName)
    {
        $object = PHPExcel_IOFactory::load($file);

        // echo "<script language=\"javascript\">alert('Here I am 2');</script>";
        foreach ($object->getWorksheetIterator() as $worksheet) {
            // echo "<script language=\"javascript\">alert('Here I am 2.2');</script>";
            $highestRow = $worksheet->getHighestDataRow();    //get Highest Row
            // echo "<script language=\"javascript\">alert('Here I am 2.3');</script>";
            $highestColumnLetter = $worksheet->getHighestDataColumn(); //get column highest as  letter
            // echo "<script language=\"javascript\">alert('Here I am 2.4');</script>";
            $highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumnLetter); // convert letter to column index in number
            // echo "<script language=\"javascript\">alert('Here I am 2.5');</script>";
            for ($column1 = 0; $column1 < $highestColumn; $column1++) {

                // echo "<script language=\"javascript\">alert('Here I am 2.6');</script>";
                $rowData1[] = $worksheet->getCellByColumnAndRow($column1, 1)->getValue();
                // echo "<script language=\"javascript\">alert('".$worksheet->getCellByColumnAndRow($column1, 1)->getValue()."');</script>";
                // echo "<script language=\"javascript\">alert('Here I am 2.7');</script>";
            }


            $headerexist = $this->import_model->headerExistForGenericPatient($rowData1); // get boolean header exist or not

            // echo "<script language=\"javascript\">alert('Here I am 2.8');</script>";

            // echo "<script language=\"javascript\">alert('Here I am 3');</script>";
            if ($headerexist) {

                $exist_name = [];
                $exist_name2 = [];
                // $erreur_tarifs = [];

                $exist_rows = "";
                $exist_rows2 = "";
                // $erreur_tarifs_rows = "";

                $message2 = "";

                // echo "<script language=\"javascript\">alert('Here I am 4');</script>";
                for ($row = 2; $row <= $highestRow; $row++) {

                    // echo "<script language=\"javascript\">alert('Here I am 5');</script>";
                    $rowData = [];
                    $rowData2 = [];

                    $prenom = "";
                    $nom = "";
                    $phone = "";
                    $age = "";
                    $sexe = "";
                    $address = "";
                    $region = "";
                    $patient_id = "";


                    // $tarif_public_ok = false;
                    // $tarif_professionnel_ok = false;
                    // $tarif_assurance_ok = false;

                    for ($column = 0; $column < $highestColumn; $column++) {

                        // echo "<script language=\"javascript\">alert('Here I am 6');</script>";
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Prénom') {
                            $prenom = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Nom') {
                            $nom = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Téléphone') {
                            $phone = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Age') {
                            $age = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Sexe') {
                            $sexe = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Adresse') {
                            $address = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Région') {
                            $region = $worksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                        }
                        $code_organisation = $this->home_model->get_code_organisation($this->$tableName);
                        $count_patient = $this->db->get_where('patient', array('id_organisation =' => $tableName))->num_rows() + 1;
                        // $patient_id = 'P-' . $this->code_organisation . '-' . str_pad($count_patient, 4, "0", STR_PAD_LEFT);
                        $patient_id = $this->code_organisation . '' . $count_patient;

                        $patientExiste = $this->db->query("select id from patient where name like \"" . $prenom . "\" and last_name like \"" . $nom . "\" and phone = \"" . $phone . "\"")->num_rows();
                    }
                    if (!$patientExiste) {
                        $data = array(
                            'name' => $prenom, 'last_name' => $nom,
                            'status' => 1,
                            'id_organisation' => $tableName,
                            'address' => $address,
                            'phone' => $phone,
                            'sex' => $sexe,
                            'age' => $age, 'region' => $region
                        );
                        $code_organisation = $this->home_model->get_code_organisation($tableName);
                        $last_patient_user_id = $this->patient_model->insertPatient($data);
                        $count_patient = $this->db->get_where('patient', array('id_organisation =' => $tableName))->num_rows() + 1;
                        // $last_patient_user_id = $this->db->query("insert into patient (id_organisation, name, last_name, phone, age, sex, address, region) VALUES(\"" . $tableName . "\",\"" . $prenom . "\",\"" . $nom . "\",\"" . $phone . "\",\"" . $age . "\", \"" . $sexe . "\", \"" . $address . "\",\"" . $region . "\")");
                        // $count_patient = $this->db->get_where('patient', array('id_organisation =' => $tableName))->num_rows() + 1;
                        $patient_id = 'P' . $code_organisation . '' . $count_patient;
                        $id_info = array('patient_id' => $patient_id);


                        $this->patient_model->updatePatient($last_patient_user_id, $id_info, $tableName);
                    }
                    if ($patientExiste) { // Si Service non existant: refus
                        $exist_name2[] = $row;
                        $exist_rows2 = implode(',', $exist_name2);
                    }
                }

                $verbe_exist_name = count($exist_name) > 1 ? "contiennent" : "contient";
                $verbe_exist_name2 = count($exist_name2) > 1 ? "contiennent" : "contient";
                // $verbe_erreur_tarifs = count($erreur_tarifs) > 1 ? "contiennent" : "contient";

                $message2 .= count($exist_name) ? 'Lignes numéro ' . $exist_rows . ' ' . $verbe_exist_name . ' un service déjà existant!' . "<br/>" : "";
                $message2 .= count($exist_name2) ? "Lignes numéro " . $exist_rows2 . " " . $verbe_exist_name2 . " une spécialité déjà existante!" . "<br/>" : "";
                // $message2 .= count($erreur_tarifs) ? "Lignes numéro " . $erreur_tarifs_rows . " " . $verbe_erreur_tarifs . " un tarif non compris entre 1.000 et 100.000 Fcfa!" . "<br/>" : "";

                $count_errors = count($exist_name) + count($exist_name2);
                $import_error_label = $count_errors ? "erreurs" : "erreur";
                $import_status_label = !$count_errors ? lang('successful_data_import') : lang('successful_data_import_with_errors');
                // $import_status_label = lang('successful_data_import');
                $this->session->set_flashdata('feedback', $import_status_label . " " . $count_errors . " " . $import_error_label);
                // $this->session->set_flashdata('feedback', $import_status_label);
                $this->session->set_flashdata('message2', $message2);
            } else {
                $this->session->set_flashdata('feedback', lang('wrong_file_format'));
            }
        }

        redirect('home/superOrganisationPatient?id=' . $tableName);
    }

    function importOrganisationLightDetail($file, $tablename)
    {

        $object = PHPExcel_IOFactory::load($file);
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();    //get Highest Row
            $highestColumnLetter = $worksheet->getHighestColumn(); //get column highest as  letter
            $highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumnLetter); // convert letter to column index in number
            for ($column1 = 0; $column1 < $highestColumn; $column1++) {
                $rowData1[] = $worksheet->getCellByColumnAndRow($column1, 1)->getValue();
            }



            //$headerexist = $this->import_model->headerExist($rowData1, $tablename); // get boolean header exist or not
            //var_dump($headerexist);

            //  if ($headerexist) {

            $exist_name = [];
            $missing_service = [];
            $erreur_tarifs = [];

            $exist_rows = "";
            $missing_service_rows = "";
            $erreur_tarifs_rows = "";

            $message2 = "";
            $nomAdresse = "--";
            $roweMail = "--";
            $rowType = "--";

            $count_update = 0;
            $count_insert = 0;
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = [];
                $rowData2 = [];

                $tarif_public_ok = false;
                $tarif_professionnel_ok = false;
                $tarif_assurance_ok = false;

                for ($column = 0; $column < $highestColumn; $column++) {
                    if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Partenaire') {
                        $nomPartenaire = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                    }


                    if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Type') {
                        $rowType = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                    }

                    if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Spécialité(s)') {
                        $rowSpe = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                    }

                    if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Adresse') {
                        $nomAdresse = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                    }
                    if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Contact') {
                        $rowContact =   $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                    }

                    if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Telephone') {
                        $rowTelephone =   $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                    }
                    if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'e-Mail') {
                        $roweMail =   $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                    }
                    // $nomPartenaire ='ll++-';  $nomAdresse ='ll';  $roweMail= 'll';  $rowType= 'll';
                    $rowData = array($nomPartenaire, '--', $nomAdresse, '--', '--', '--', '--', $roweMail, '--', '--', $rowType, '--', 1);
                }
                //  var_dump($rowData);

                $rowData2 = array(
                    "nom", "path_logo", "adresse", "region", "departement", "arrondissement", "collectivite", "email",
                    "id_partenaire_zuuluPay", "pin_partenaire_zuuluPay_encrypted", "type", "date_creation", "is_light"
                );
                $data = array_combine($rowData2, $rowData);

                $sqlPara = $this->db->query("select id from organisation where nom = \"" . $nomPartenaire . "\" and is_light = 1");
                $sqlTab = $sqlPara->num_rows();


                if ($sqlTab != 0) {
                    $idPara = $sqlPara->row()->id;
                    $inserted_id =  $this->import_model->dataEntryUpdateOrganisation($idPara, $data, 'organisation');
                    //var_dump($idPara);  var_dump($tablename); 
                    $sqlParaSante = $this->db->query("select idp from partenariat_sante where id_organisation_origin = \"" . $idPara . "\" and id_organisation_destinataire = \"" . $tablename . "\" and partenariat_actif = 1");
                    if ($sqlParaSante->num_rows() != 0) {
                        $idParaSante =   $sqlParaSante->row()->idp;
                        //var_dump($idParaSante); exit();

                        $this->import_model->dataEntryOrganisationLiaisonUpdate($idParaSante, array("partenariat_actif" => 0), 'partenariat_sante');
                    }
                    $dataLiaison = array("id_organisation_destinataire" => $tablename, "id_organisation_origin" => $idPara);
                    $this->import_model->dataEntryOrganisationLiaison($dataLiaison, 'partenariat_sante');

                    $count_update++;
                } else {
                    if ($nomPartenaire) {
                        $this->import_model->dataEntryOrganisation($data, 'organisation');
                        $inserted_id = $this->db->insert_id();

                        $dataLiaison = array("id_organisation_destinataire" => $tablename, "id_organisation_origin" => $inserted_id);
                        $this->import_model->dataEntryOrganisationLiaison($dataLiaison, 'partenariat_sante');
                        $count_insert++;
                    }
                }
            }
            if ($count_insert) {
                $message_parametre = $count_insert . " ajout(s)<br/>";
            }
            if ($count_update) {
                $message_parametre = $count_update . " mise(s) a jour ";
            }

            // } else {
            //     $this->session->set_flashdata('feedback', lang('wrong_file_format'));
            // }
        }
        $this->session->set_flashdata('feedback', $message_parametre);
        //redirect('home/paymentCategory');
        redirect('home/organisationslight?id=' . $tablename);
    }


    public function organisationsnolight()
    {
        $data = array();
        $idOrganisation = $this->input->get('id');
        $data['organisation'] = $this->home_model->getOrganisationById($idOrganisation)->nom;

        $this->load->view('superdashboard', $data); // just the header file
        $this->load->view('organisationsnolight', $data);
        $this->load->view('footer', $data);
    }




    public function createOrganisationTemplate()
    {
        $objPHPExcel = PHPExcel_IOFactory::load("files/downloads/master_data_prestations_panier_blank.xlsx");
        $objPHPExcel->setActiveSheetIndex(0);

        $excel_row = 1;

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, 'Partenaire');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, 'Type');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, 'Spécialité(s)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, 'Adresse');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, 'Contact');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, 'Telephone');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, 'e-Mail');


        $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="master_data_prestations_panier_' . time() . '.xlsx"');
        ob_end_clean();
        $object_writer->save('php://output');
    }


    public function importOrganisationPatientTemplate()
    {
        $objPHPExcel = PHPExcel_IOFactory::load("files/downloads/master_data_prestations_panier_blank.xlsx");
        $objPHPExcel->setActiveSheetIndex(0);

        $excel_row = 1;

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, 'Prénom');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, 'Nom');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, 'Téléphone');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, 'Age');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, 'Sexe');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, 'Adresse');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, 'Région');


        $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="liste_des_patients' . time() . '.xlsx"');
        ob_end_clean();
        $object_writer->save('php://output');
    }

    public function importOrganisationDepenseTemplate()
    {
        $objPHPExcel = PHPExcel_IOFactory::load("files/downloads/depense_xl_formatter.xlsx");
        $objPHPExcel->setActiveSheetIndex(0);

        $excel_row = 1;

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, 'Date');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, 'Reçu');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, 'Catégorie');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, 'Bénéficiaire');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, 'Téléphone_Bénéficiaire');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, 'Montant');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, 'Libelle');


        $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="liste_des_dépenses' . time() . '.xlsx"');
        ob_end_clean();
        $object_writer->save('php://output');
    }

    function importDepenseOrganisation()
    {
        if (isset($_FILES["filename"]["name"])) {

            // Validation format
            $file_name = $_FILES['filename']['name'];

            $temp = explode(".", $_FILES["filename"]["name"]);
            $extension = end($temp);
            $mimes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            $allowedExts = ['xl', 'xls', 'xlsx'];

            // SI OK
            $path = $_FILES["filename"]["tmp_name"];
            $idOrganisationOrigin = $this->input->post('idOrganisationOrigin');

            $this->importDepenseOrganisationDetail($path, $idOrganisationOrigin);

            if (in_array($_FILES['filename']['type'], $mimes) && in_array($extension, $allowedExts)) {
                // SI OK
                $path = $_FILES["filename"]["tmp_name"];
                $idOrganisationOrigin = $this->input->post('idOrganisationOrigin');
            } else {

                $this->session->set_flashdata('feedback', lang('wrong_file_format'));

                redirect('home/financialReport?id=' . $idOrganisationOrigin);
            }
        }
    }

    function importDepenseOrganisationDetail($file, $tableName)
    {
        $object = PHPExcel_IOFactory::load($file);

        // echo "<script language=\"javascript\">alert('Here I am 2');</script>";
        foreach ($object->getWorksheetIterator() as $worksheet) {
            // echo "<script language=\"javascript\">alert('Here I am 2.2');</script>";
            $highestRow = $worksheet->getHighestDataRow();    //get Highest Row
            // echo "<script language=\"javascript\">alert('Here I am 2.3');</script>";
            $highestColumnLetter = $worksheet->getHighestDataColumn(); //get column highest as  letter
            // echo "<script language=\"javascript\">alert('Here I am 2.4');</script>";
            $highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumnLetter); // convert letter to column index in number
            // echo "<script language=\"javascript\">alert('Here I am 2.5');</script>";
            for ($column1 = 0; $column1 < $highestColumn; $column1++) {

                // echo "<script language=\"javascript\">alert('Here I am 2.6');</script>";
                $rowData1[] = $worksheet->getCellByColumnAndRow($column1, 1)->getValue();
                // echo "<script language=\"javascript\">alert('".$worksheet->getCellByColumnAndRow($column1, 1)->getValue()."');</script>";
                // echo "<script language=\"javascript\">alert('Here I am 2.7');</script>";
            }


            $headerexist = $this->import_model->headerExistForGenericDepense($rowData1); // get boolean header exist or not

            // echo "<script language=\"javascript\">alert('Here I am 2.8');</script>";

            // echo "<script language=\"javascript\">alert('Here I am 3');</script>";
            if ($headerexist) {


                $exist_name = [];
                $exist_name2 = [];
                // $erreur_tarifs = [];

                $exist_rows = "";
                $exist_rows2 = "";
                // $erreur_tarifs_rows = "";

                $message2 = "";

                // echo "<script language=\"javascript\">alert('Here I am 4');</script>";
                for ($row = 2; $row <= $highestRow; $row++) {

                    // echo "<script language=\"javascript\">alert('Here I am 5');</script>";
                    $rowData = [];
                    $rowData2 = [];



                    $date = "";
                    $recu = "";
                    $categorie = "";
                    $beneficiaire = "";
                    $phoneBeneficiaire = "";
                    $montant = "";
                    $libelle = "";
                    $datehr = "";
                    $dateStmp = "";


                    // $tarif_public_ok = false;
                    // $tarif_professionnel_ok = false;
                    // $tarif_assurance_ok = false;

                    for ($column = 0; $column < $highestColumn; $column++) {

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Date') {
                            $date = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                            $datehr =  date('d-m-y', PHPExcel_Shared_Date::ExcelToPHP($date));
                            $conversionhr =  date('d/m/Y H:i', PHPExcel_Shared_Date::ExcelToPHP($date));
                            $dateStmp = strtotime($conversionhr);
                        }


                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Reçu') {
                            $recu = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Catégorie') {
                            $categorie = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Bénéficiaire') {
                            $beneficiaire = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Téléphone_Bénéficiaire') {
                            $phoneBeneficiaire =   $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Montant') {
                            $montant =   $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Libelle') {
                            $libelle =   $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }

                        $user = $this->ion_auth->get_user_id();


                        $expenseExiste = $this->db->query("select id from expense where id_organisation = \"" . $tableName . "\"  and datestring like \"" . $datehr . "\" and category like \"" . $categorie . "\" and beneficiaire like \"%" . $beneficiaire . "%\" and amount = \"" . $montant . "\"")->num_rows();
                    }
                    if (!$expenseExiste) {
                        $data = array(
                            'datestring' => $datehr,
                            'category' => $categorie,
                            'status' => 1,
                            'id_organisation' => $tableName,
                            'beneficiaire' => $beneficiaire . ' ' . $phoneBeneficiaire,
                            'codeFacture' => $recu,
                            'codeType' => 'codeCourante',
                            'note' => $libelle,
                            'amount' => $montant,
                            'date' => $dateStmp,
                            'user' => $user

                        );
                        $last_patient_user_id = $this->finance_model->insertExpense($data);

                        $this->finance_model->updateExpense($last_patient_user_id, $data);
                    }
                    if ($expenseExiste) { // Si Service non existant: refus
                        $exist_name2[] = $row;
                        $exist_rows2 = implode(',', $exist_name2);
                    }
                }

                $verbe_exist_name = count($exist_name) > 1 ? "contiennent" : "contient";
                $verbe_exist_name2 = count($exist_name2) > 1 ? "contiennent" : "contient";
                // $verbe_erreur_tarifs = count($erreur_tarifs) > 1 ? "contiennent" : "contient";

                $message2 .= count($exist_name) ? 'Lignes numéro ' . $exist_rows . ' ' . $verbe_exist_name . ' un service déjà existant!' . "<br/>" : "";
                $message2 .= count($exist_name2) ? "Lignes numéro " . $exist_rows2 . " " . $verbe_exist_name2 . " une spécialité déjà existante!" . "<br/>" : "";
                // $message2 .= count($erreur_tarifs) ? "Lignes numéro " . $erreur_tarifs_rows . " " . $verbe_erreur_tarifs . " un tarif non compris entre 1.000 et 100.000 Fcfa!" . "<br/>" : "";

                $count_errors = count($exist_name) + count($exist_name2);
                $import_error_label = $count_errors ? "erreurs" : "erreur";
                $import_status_label = !$count_errors ? lang('successful_data_import') : lang('successful_data_import_with_errors');
                // $import_status_label = lang('successful_data_import');
                $this->session->set_flashdata('feedback', $import_status_label . " " . $count_errors . " " . $import_error_label);
                // $this->session->set_flashdata('feedback', $import_status_label);
                $this->session->set_flashdata('message2', $message2);
            } else {
                $this->session->set_flashdata('feedback', lang('wrong_file_format'));
            }
        }

        redirect('home/financialReport?id=' . $tableName);
    }

    public function importOrganisationRecetteTemplate()
    {
        $objPHPExcel = PHPExcel_IOFactory::load("files/downloads/recette_xl_formatter.xlsx");
        $objPHPExcel->setActiveSheetIndex(0);

        $excel_row = 1;

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, 'Date');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, 'Reçu');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, 'Prénom');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, 'Nom');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, 'Age');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, 'Téléphone');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, 'Montant');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, 'Adresse');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, 'Spécialité');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, 'Docteur');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, 'Libelle');





        $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="liste_des_recettes' . time() . '.xlsx"');
        ob_end_clean();
        $object_writer->save('php://output');
    }

    function importRecetteOrganisation()
    {
        if (isset($_FILES["filename"]["name"])) {

            // Validation format
            $file_name = $_FILES['filename']['name'];

            $temp = explode(".", $_FILES["filename"]["name"]);
            $extension = end($temp);
            $mimes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            $allowedExts = ['xl', 'xls', 'xlsx'];

            // SI OK
            $path = $_FILES["filename"]["tmp_name"];
            $idOrganisationOrigin = $this->input->post('idOrganisationOrigin');

            $this->importRecetteOrganisationDetail($path, $idOrganisationOrigin);

            if (in_array($_FILES['filename']['type'], $mimes) && in_array($extension, $allowedExts)) {
                // SI OK
                $path = $_FILES["filename"]["tmp_name"];
                $idOrganisationOrigin = $this->input->post('idOrganisationOrigin');
            } else {

                $this->session->set_flashdata('feedback', lang('wrong_file_format'));

                redirect('home/financialReport?id=' . $idOrganisationOrigin);
            }
        }
    }

    function importRecetteOrganisationDetail($file, $tableName)
    {
        $object = PHPExcel_IOFactory::load($file);

        // echo "<script language=\"javascript\">alert('Here I am 2');</script>";
        foreach ($object->getWorksheetIterator() as $worksheet) {
            // echo "<script language=\"javascript\">alert('Here I am 2.2');</script>";
            $highestRow = $worksheet->getHighestDataRow();    //get Highest Row
            // echo "<script language=\"javascript\">alert('Here I am 2.3');</script>";
            $highestColumnLetter = $worksheet->getHighestDataColumn(); //get column highest as  letter
            // echo "<script language=\"javascript\">alert('Here I am 2.4');</script>";
            $highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumnLetter); // convert letter to column index in number
            // echo "<script language=\"javascript\">alert('Here I am 2.5');</script>";
            for ($column1 = 0; $column1 < $highestColumn; $column1++) {

                // echo "<script language=\"javascript\">alert('Here I am 2.6');</script>";
                $rowData1[] = $worksheet->getCellByColumnAndRow($column1, 1)->getValue();
                // echo "<script language=\"javascript\">alert('".$worksheet->getCellByColumnAndRow($column1, 1)->getValue()."');</script>";
                // echo "<script language=\"javascript\">alert('Here I am 2.7');</script>";
            }


            $headerexist = $this->import_model->headerExistForGenericRecette($rowData1); // get boolean header exist or not

            // echo "<script language=\"javascript\">alert('Here I am 2.8');</script>";

            // echo "<script language=\"javascript\">alert('Here I am 3');</script>";
            if ($headerexist) {


                $exist_name = [];
                $exist_name2 = [];
                // $erreur_tarifs = [];

                $exist_rows = "";
                $exist_rows2 = "";
                // $erreur_tarifs_rows = "";

                $message2 = "";

                // echo "<script language=\"javascript\">alert('Here I am 4');</script>";
                for ($row = 2; $row <= $highestRow; $row++) {

                    // echo "<script language=\"javascript\">alert('Here I am 5');</script>";
                    $rowData = [];
                    $rowData2 = [];



                    $date = "";
                    $recu = "";
                    $prenom = "";
                    $nom = "";
                    $age = "";
                    $phone = "";
                    $montant = "";
                    $address = "";
                    $specialite = "";
                    $doctor = "";
                    $libelle = "";
                    $datehr = "";


                    // $tarif_public_ok = false;
                    // $tarif_professionnel_ok = false;
                    // $tarif_assurance_ok = false;

                    for ($column = 0; $column < $highestColumn; $column++) {

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Date') {
                            $date = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                            $datehr =  date('m-d-y H:i', PHPExcel_Shared_Date::ExcelToPHP($date));
                            $conversionhr =  date('d-m-Y H:i', PHPExcel_Shared_Date::ExcelToPHP($date));
                            $dateStmp = strtotime($conversionhr);
                        }


                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Reçu') {
                            $recu = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Prénom') {
                            $prenom = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Nom') {
                            $nom = $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Age') {
                            $age =   $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }

                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Téléphone') {
                            $phone =   $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Montant') {
                            $montant =   $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Adresse') {
                            $address =   $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Spécialité') {
                            $specialite =   $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Docteur') {
                            $doctor =   $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }
                        if ($worksheet->getCellByColumnAndRow($column, 1)->getValue() === 'Libelle') {
                            $libelle =   $worksheet->getCellByColumnAndRow($column, $row)->getValue();
                        }

                        $user = $this->ion_auth->get_user_id();
                        $patient_name = $prenom . ' ' . $nom;


                        $recetteExiste = $this->db->query("select id from payment where id_organisation = \"" . $tableName . "\"  and date_string like \"" . $datehr . "\" and code like \"" . $recu . "\" and patient_name like \"%" . $patient_name . "%\" and patient_phone = \"" . $phone . "\" and amount_received = \"" . $montant . "\" and libelle_prestation like \"" . $libelle . "\"")->num_rows();
                    }
                    if (!$recetteExiste) {
                        $data = array(
                            'date_string' => $datehr,
                            'libelle_prestation' => $libelle,
                            'libelle_specialite' => $specialite,
                            'status' => 'finish',
                            'deposit_type' => 'Cash',
                            'id_organisation' => $tableName,
                            'patient_name' => $patient_name,
                            'patient_phone' => $phone,
                            'patient_age' => $age,
                            'patient_address' => $address,
                            'doctor_name' => $doctor,
                            'amount_received' => $montant,
                            'date' => $dateStmp,
                            'code' => $recu,
                            'user' => $user

                        );
                        $last_patient_user_id = $this->finance_model->insertPayment($data);
                        $inserted_id = $this->db->insert_id();
                        $this->finance_model->updatePayment($last_patient_user_id, $data);

                        $data1 = array(
                            'date' => $dateStmp,
                            'patient' => $patient_name,
                            'payment_id' => $inserted_id,
                            'deposited_amount' => $montant,
                            'amount_received_id' => $inserted_id . '.' . 'gp',
                            'user' => $user,
                            'id_organisation' => $tableName
                        );
                        $this->finance_model->insertDeposit($data1);
                    }
                    if ($recetteExiste) { // Si Service non existant: refus
                        $exist_name2[] = $row;
                        $exist_rows2 = implode(',', $exist_name2);
                    }
                }

                $verbe_exist_name = count($exist_name) > 1 ? "contiennent" : "contient";
                $verbe_exist_name2 = count($exist_name2) > 1 ? "contiennent" : "contient";
                // $verbe_erreur_tarifs = count($erreur_tarifs) > 1 ? "contiennent" : "contient";

                $message2 .= count($exist_name) ? 'Lignes numéro ' . $exist_rows . ' ' . $verbe_exist_name . ' un service déjà existant!' . "<br/>" : "";
                $message2 .= count($exist_name2) ? "Lignes numéro " . $exist_rows2 . " " . $verbe_exist_name2 . " une spécialité déjà existante!" . "<br/>" : "";
                // $message2 .= count($erreur_tarifs) ? "Lignes numéro " . $erreur_tarifs_rows . " " . $verbe_erreur_tarifs . " un tarif non compris entre 1.000 et 100.000 Fcfa!" . "<br/>" : "";

                $count_errors = count($exist_name) + count($exist_name2);
                $import_error_label = $count_errors ? "erreurs" : "erreur";
                $import_status_label = !$count_errors ? lang('successful_data_import') : lang('successful_data_import_with_errors');
                // $import_status_label = lang('successful_data_import');
                $this->session->set_flashdata('feedback', $import_status_label . " " . $count_errors . " " . $import_error_label);
                // $this->session->set_flashdata('feedback', $import_status_label);
                $this->session->set_flashdata('message2', $message2);
            } else {
                $this->session->set_flashdata('feedback', lang('wrong_file_format'));
            }
        }

        redirect('home/financialReport?id=' . $tableName);
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
        $this->load->view('lab/master_lab', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function addNewSettings()
    {
        $id = $this->input->post('id');
        $instance_id = $this->input->post('instance_id');
        $status_changed = $this->input->post('status_changed');
        $token = $this->input->post('token');
        $data = array();
        $data = array(
            'token' => $token,
            'instance_id' => $instance_id,
            'status_changed' => $status_changed
        );
        if (empty($id)) {
            $this->home_model->insertWhatsappSettings($data);
        } else {
            $this->home_model->updateWhatsappSettings($id, $data);
        }
        redirect('home/settings');
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
