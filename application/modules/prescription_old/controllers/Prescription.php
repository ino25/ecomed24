<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prescription extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('prescription_model');
        $this->load->model('medicine/medicine_model');
        $this->load->model('patient/patient_model');
        $this->load->model('doctor/doctor_model');
        $this->load->model('home/home_model');
        $this->load->model('partenaire/partenaire_model');
        if (!$this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor', 'Patient', 'Nurse','adminmedecin'))) {
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

        if ($this->ion_auth->in_group(array('Patient'))) {
            redirect('home/permission');
        }

        $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
        $data['doctors'] = $this->doctor_model->getDoctor();
        if ($this->ion_auth->in_group(array('Doctor','adminmedecin'))) {
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
        $this->load->view('home/footer'); // just the header file
    }

    function all()
    {

        if (!$this->ion_auth->in_group(array('admin', 'Doctor', 'Pharmacist','adminmedecin'))) {
            redirect('home/permission');
        }

        $data['medicines'] = $this->medicine_model->getMedicine();
        $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
        $data['doctors'] = $this->doctor_model->getDoctor();
        $data['prescriptions'] = $this->prescription_model->getPrescription($this->id_organisation);
        $data['settings'] = $this->settings_model->getSettings();

        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('all_prescription', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addPrescriptionView()
    {

        if (!$this->ion_auth->in_group(array('admin', 'Doctor','adminmedecin'))) {
            redirect('home/permission');
        }

        $data = array();
        $data['medicines'] = $this->medicine_model->getMedicine();
        $data['patients'] = $this->patient_model->getPatient($this->id_organisation);
        $data['doctors'] = $this->doctor_model->getDoctor();

        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_prescription_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewPrescription()
    {

        if (!$this->ion_auth->in_group(array('admin', 'Doctor','adminmedecin'))) {
            redirect('home/permission');
        }

        $id = $this->input->post('id');
        $tab = $this->input->post('tab');
        $date = $this->input->post('date');
        $date_string = $this->input->post('date_string');
        $etat = $this->input->post('choicepartenaire');
        $destinataire = $this->input->post('partenaire');
        $count_ordonance = $this->db->get_where('expense', array('id_organisation =' => $this->id_organisation))->num_rows() + 1;
        // $codeFacture = 'O-' . $this->code_organisation . '-' . str_pad($count_ordonance, 4, "0", STR_PAD_LEFT);
        $codeFacture = 'O' . $this->code_organisation . '' . $count_ordonance;

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
            );
            if (empty($id)) {
                $this->prescription_model->insertPrescription($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->prescription_model->updatePrescription($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }

            if (!empty($admin)) {
                if ($this->ion_auth->in_group(array('Doctor','adminmedecin'))) {
                    redirect('prescription');
                } else {
                    redirect('prescription/all');
                }
            } else {
                redirect('prescription');
            }
        }
    }

    function viewPrescription()
    {
        $id = $this->input->get('id');
        $data['prescription'] = $this->prescription_model->getPrescriptionById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('prescription_view_1', $data);
        $this->load->view('home/footer'); // just the header file
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
            $this->load->view('add_new_category_view',$data);
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

    function getPrescriptionListByDoctor() {
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
            $patientdetails = $this->patient_model->getPatientById($prescription->patient,$this->id_organisation);
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

    function getPrescriptionList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        // if ($limit == -1) {
        //     if (!empty($search)) {
        //         $data['prescriptions'] = $this->prescription_model->getPrescriptionBysearch($search);
        //     } else {
        //         $data['prescriptions'] = $this->prescription_model->getPrescription($this->id_organisation);
        //     }
        // } else {
        //     if (!empty($search)) {
        //         $data['prescriptions'] = $this->prescription_model->getPrescriptionByLimitBySearch($limit, $start, $search);
        //     } else {
        //         $data['prescriptions'] = $this->prescription_model->getPrescriptionByLimit($limit, $start);
        //     }
        // }
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
            $option3 = '<a class="btn btn-info btn-xs btn_width" href="prescription/editPrescription?id=' . $prescription->id . '" data-id="' . $prescription->id . '"><i class="fa fa-edit"></i> ' . lang('edit'). '</a>';
            
            $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="prescription/delete?id=' . $prescription->id . '&admin=' . $prescription->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i></a>';
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
            $patientdetails = $this->patient_model->getPatientById($prescription->patient,$this->id_organisation);
            if (!empty($patientdetails)) {
                $patientname = $patientdetails->name;
            } else {
                $patientname = $prescription->patientname;
            }
            $doctordetails = $this->doctor_model->getDoctorById($prescription->doctor);
            if (!empty($doctordetails)) {
                $doctorname = $doctordetails->name;
            } else {
                $doctorname = $prescription->doctorname;
            }

            if($this->ion_auth->in_group(array('Pharmacist', 'Doctor', 'Receptionist','adminmedecin'))){
                $option2 = '';
                $option3 = '';
            }

            $transferts = '';
            $organisation_dest = $this->home_model->getOrganisationById($prescription->organisation_destinataire);
            if($prescription->organisation_destinataire){
                if(!empty($organisation_dest) && $this->id_organisation === $prescription->id_organisation){
                    
                    $transferts .= '<br/>Transfert vers ' . $organisation_dest->nom ;
                    $option3 = '';
                }else if (!empty($organisation_dest) && $this->id_organisation === $prescription->organisation_destinataire){
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
                $prescription->patientname.' '.$prescription->patientlastname,
                $medicinelist,
                $prescription->code_facture.' '.$transferts,
                $option1 . ' ' . $option3 . ' ' . $options4
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

      function searhPartenaire() {
        $searchTerm = $this->input->post('searchTerm');
        $response = $this->partenaire_model->searhPartenaire($searchTerm, $this->id_organisation);
        echo json_encode($response);
    }
}

/* End of file prescription.php */
/* Location: ./application/modules/prescription/controllers/prescription.php */
