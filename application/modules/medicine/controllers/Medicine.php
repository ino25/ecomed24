<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Medicine extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('medicine_model');
        $this->load->model('home/home_model');
//        if (!$this->ion_auth->in_group(array('admin', 'Pharmacist', 'Doctor','adminmedecin'))) {
//            redirect('home/permission');
//        }
        $identity = $this->session->userdata["identity"];
        $this->id_organisation = $this->home_model->get_id_organisation($identity);
        $this->path_logo = $this->home_model->get_logo_organisation($this->id_organisation);
        $this->nom_organisation = $this->home_model->get_nom_organisation($this->id_organisation);
        $this->id_partenaire_zuuluPay = $this->home_model->id_partenaire_zuuluPay($this->id_organisation);
        $this->pin_partenaire_zuuluPay_encrypted = $this->home_model->pin_partenaire_zuuluPay_encrypted($this->id_organisation);
        $this->code_organisation = $this->home_model->get_code_organisation($this->id_organisation);
    }

    public function index() {

        $data['medicines'] = $this->medicine_model->getMedicine();
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $data['types'] = $this->medicine_model->getMedicineType();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);

        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function medicineList() {

        $data['medicines'] = $this->medicine_model->getMasterMedicine();
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['types'] = $this->medicine_model->getMedicineType();
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);

        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('master_medicine', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function requestMedicineList() {

        $data['medicines'] = $this->medicine_model->getMasterMedicine();
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['types'] = $this->medicine_model->getMedicineType();
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);

        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/superdashboard', $data); // just the header file
        $this->load->view('request_medicine', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function masterMedicineList() {

        $data['medicines'] = $this->medicine_model->getMasterMedicine();
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['types'] = $this->medicine_model->getMedicineType();
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);

        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/superdashboard', $data); // just the header file
        $this->load->view('master_medicine', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function requestMedicine() {

        $data['medicines'] = $this->medicine_model->getMasterMedicine();
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['types'] = $this->medicine_model->getMedicineType();
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);

        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('request_medicine', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addMedicineVieww() {
        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['types'] = $this->medicine_model->getMedicineType();
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
        $this->load->view('home/superdashboard', $data); // just the header file
        $this->load->view('add_new_medicine_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function medicineByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['medicines'] = $this->medicine_model->getMedicineByPageNumber($page_number);
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function medicineStockAlert() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = '0';
        $data['medicines'] = $this->medicine_model->getMedicineByStockAlert($page_number);
        //  $data['medicines'] = $this->medicine_model->getMedicineByStockAlertByPageNumber($page_number);
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['pagee_number'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $data['alert'] = 'Alert Stock';
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine_stock_alert', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function medicineStockAlertByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $data['medicines'] = $this->medicine_model->getMedicineByStockAlert($page_number);
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['pagee_number'] = $page_number;
        $data['alert'] = 'Alert Stock';
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine_stock_alert', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function searchMedicine() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['medicines'] = $this->medicine_model->getMedicineByKey($page_number, $key);
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function searchMedicineInAlertStock() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['medicines'] = $this->medicine_model->getMedicineByKeyByStockAlert($page_number, $key);
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine_stock_alert', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addMedicineView() {
        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_medicine_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewMedicine() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $category = $this->input->post('category');
        $price = $this->input->post('price');
        $box = $this->input->post('box');
        $s_price = $this->input->post('s_price');
        $quantity = $this->input->post('quantity');
        $generic = $this->input->post('generic');
        $company = $this->input->post('company');
        $effects = $this->input->post('effects');
        $e_date = $this->input->post('e_date');
        if ((empty($id))) {
            $add_date = date('m/d/y');
        } else {
            $add_date = $this->db->get_where('medicine', array('id' => $id))->row()->add_date;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Category Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Purchase Price Field
        $this->form_validation->set_rules('price', 'Purchase Price', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Store Box Field
        $this->form_validation->set_rules('box', 'Store Box', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Selling Price Field
        $this->form_validation->set_rules('s_price', 'Selling Price', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Quantity Field
        $this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Generic Name Field
        $this->form_validation->set_rules('generic', 'Generic Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Company Name Field
        $this->form_validation->set_rules('company', 'Company', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Effects Field
        $this->form_validation->set_rules('effects', 'Effects', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Expire Date Field
        $this->form_validation->set_rules('e_date', 'Expire Date', 'trim|required|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['categories'] = $this->medicine_model->getMedicineCategory();
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_new_medicine_view', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array('name' => $name,
                'category' => $category,
                'price' => $price,
                'box' => $box,
                's_price' => $s_price,
                'quantity' => $quantity,
                'generic' => $generic,
                'company' => $company,
                'effects' => $effects,
                'add_date' => $add_date,
                'e_date' => $e_date,
            );
            if (empty($id)) {
                $this->medicine_model->insertMedicine($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->medicine_model->updateMedicine($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('medicine');
        }
    }

    public function importMedicine() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $pharmacist_id = $this->input->post('pharmacist_id');
        $category = $this->input->post('category');
        $description = $this->input->post('description');
        $imported_id = $this->input->post('imported_id');
        $type = $this->input->post('type');
        $s_price = $this->input->post('s_price');
        $quantity = $this->input->post('quantity');
        $generic = $this->input->post('generic');
        $company = $this->input->post('company');
//        $effects = $this->input->post('effects');
        $e_date = $this->input->post('e_date');
        if ((empty($id))) {
            $add_date = date('m/d/y');
        } else {
            $add_date = $this->db->get_where('medicine', array('id' => $id))->row()->add_date;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field

        $this->form_validation->set_rules('s_price', 'Selling Price', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Quantity Field
        $this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            redirect('medicine/masterMedicineList');
        } else {
            $medicin_details = $this->medicine_model->getMasterMedicineById($imported_id);
            $medicinename = $this->medicine_model->getMasterMedicineById($imported_id)->name;
            $medicinecategory = $this->medicine_model->getMasterMedicineById($imported_id)->category;
            $medicinetype = $this->medicine_model->getMasterMedicineById($imported_id)->type;
            $medicinegeneric = $this->medicine_model->getMasterMedicineById($imported_id)->generic;
            $medicinecompany = $this->medicine_model->getMasterMedicineById($imported_id)->company;
            $medicinedescription = $this->medicine_model->getMasterMedicineById($imported_id)->description;
            $data = array();
            $data = array('name' => $medicinename,
                'category' => $medicinecategory,
                'type' => $medicinetype,
                'imported_id' => $imported_id,
                's_price' => $s_price,
                'quantity' => $quantity,
                'description' => $medicinedescription,
                'generic' => $medicinegeneric,
                'company' => $medicinecompany,
                'id_organisation' => $this->id_organisation,
                'pharmacist_id' => $pharmacist_id,
                'add_date' => $add_date,
                'e_date' => $e_date,
                'status' => 'active'
            );
            if (empty($id)) {


                $this->medicine_model->insertMedicine($data);
                $inserted_id = $this->db->insert_id();
                if (empty($medicin_details->insert_organ)) {
                    $data_up = array('insert_organ' => $this->id_organisation);
                } else {
                    $insert_organ = $medicin_details->insert_organ . '**' . $this->id_organisation;
                    $data_up = array('insert_organ' => $insert_organ);
                }
                $this->medicine_model->updateMasterMedicine($imported_id, $data_up);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->medicine_model->updateMedicine($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('medicine');
        }
    }

    public function addMasterMedicine() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $category = $this->input->post('category');
        $dosage = $this->input->post('dosage');
        $type = $this->input->post('type');
        $redirect = $this->input->post('redirect');
//        $quantity = $this->input->post('quantity');
        $generic = $this->input->post('generic');
        $company = $this->input->post('company');
        $description = $this->input->post('description');
        $status = $this->input->post('status');
        if ((empty($id))) {
            $add_date = date('m/d/y');
        } else {
            $add_date = $this->db->get_where('medicine', array('id' => $id))->row()->add_date;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Category Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Purchase Price Field
        $this->form_validation->set_rules('dosage', 'Dosage', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Store Box Field
        $this->form_validation->set_rules('type', 'type', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Selling Price Field
//        $this->form_validation->set_rules('s_price', 'Selling Price', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Quantity Field
//        $this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Generic Name Field
//        $this->form_validation->set_rules('generic', 'Generic Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
//        // Validating Company Name Field
//        $this->form_validation->set_rules('company', 'Company', 'trim|min_length[2]|max_length[100]|xss_clean');
//        // Validating Effects Field
//        $this->form_validation->set_rules('effects', 'Effects', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Expire Date Field
//        $this->form_validation->set_rules('e_date', 'Expire Date', 'trim|required|min_length[1]|max_length[100]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['types'] = $this->medicine_model->getMedicineType();
            $data['categories'] = $this->medicine_model->getMedicineCategory();
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/superdashboard', $data); // just the header file
            $this->load->view('add_new_medicine_view', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array('name' => $name,
                'category' => $category,
                'dosage' => $dosage,
                'type' => $type,
//                's_price' => $s_price,
//                'quantity' => $quantity,
                'generic' => $generic,
                'company' => $company,
                'description' => $description,
                'add_date' => $add_date,
                'status' => $status,
            );
            if (empty($id)) {
                $this->medicine_model->insertMasterMedicine($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->medicine_model->updateMasterMedicine($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            if ($redirect == 'medicine') {
                redirect('medicine/addMasterMedicineView');
            } else {
                redirect('medicine/masterMedicineList');
            }
        }
    }

    public function addRequestMedicine() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $category = $this->input->post('category');
        $dosage = $this->input->post('dosage');
        $type = $this->input->post('type');
        $pharmacist_id = $this->input->post('pharmacist_id');
        $quantity = $this->input->post('quantity');
        $s_price = $this->input->post('s_price');
        $e_date = $this->input->post('e_date');
        $generic = $this->input->post('generic');
        $company = $this->input->post('company');
        $description = $this->input->post('description');
        $status = $this->input->post('status');
        if ((empty($id))) {
            $add_date = date('m/d/y');
        } else {
            $add_date = $this->db->get_where('medicine', array('id' => $id))->row()->add_date;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Category Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Purchase Price Field
        $this->form_validation->set_rules('dosage', 'Dosage', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Store Box Field
        $this->form_validation->set_rules('type', 'type', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Selling Price Field
//        $this->form_validation->set_rules('s_price', 'Selling Price', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Quantity Field
//        $this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Generic Name Field
//        $this->form_validation->set_rules('generic', 'Generic Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
//        // Validating Company Name Field
//        $this->form_validation->set_rules('company', 'Company', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Effects Field
//        $this->form_validation->set_rules('effects', 'Effects', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Expire Date Field
//        $this->form_validation->set_rules('e_date', 'Expire Date', 'trim|required|min_length[1]|max_length[100]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['types'] = $this->medicine_model->getMedicineType();
            $data['categories'] = $this->medicine_model->getMedicineCategory();
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_new_medicine_view', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array('name' => $name,
                'category' => $category,
                'dosage' => $dosage,
                'type' => $type,
                'id_organisation' => $this->id_organisation,
                'pharmacist_id' => $pharmacist_id,
                'quantity' => $quantity,
                's_price' => $s_price,
                'e_date' => $e_date,
                'generic' => $generic,
                'company' => $company,
                'description' => $description,
                'add_date' => $add_date,
                'status' => 'Pending',
            );
            if (empty($id)) {
                $this->medicine_model->insertRequestMedicine($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->medicine_model->updateRequestMedicine($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('medicine/requestMedicine');
        }
    }

    function addRequestFromPrescription() {
        $name = $this->input->post('name');
        $category = $this->input->post('category');
        $dosage = $this->input->post('dosage');
        $type = $this->input->post('type');
        $generic = $this->input->post('generic');
        $company = $this->input->post('company');
        $description = $this->input->post('description');
    }

    function declineMedicine() {
        $data = array();
        $id = $this->input->get("id");
        $data = array('status' => 'Decline');
        $this->medicine_model->updateRequestMedicine($id, $data);
        redirect('medicine/requestMedicineList');
    }

    function approvedMedicine() {
        $data = array();
        $id = $this->input->get("id");
        $data = array('status' => 'Approved');
        $this->medicine_model->updateRequestMedicine($id, $data);

        $medicinename = $this->medicine_model->getRequestMedicineById($id)->name;
        $medicinecategory = $this->medicine_model->getRequestMedicineById($id)->category;
        $medicinetype = $this->medicine_model->getRequestMedicineById($id)->type;
        $medicinegeneric = $this->medicine_model->getRequestMedicineById($id)->generic;
        $medicinecompany = $this->medicine_model->getRequestMedicineById($id)->company;
        $medicinedescription = $this->medicine_model->getRequestMedicineById($id)->description;
        $medicinedosage = $this->medicine_model->getRequestMedicineById($id)->dosage;
        $medicineprice = $this->medicine_model->getRequestMedicineById($id)->s_price;
        $medicineqty = $this->medicine_model->getRequestMedicineById($id)->quantity;
        $pharmacist_id = $this->medicine_model->getRequestMedicineById($id)->pharmacist_id;
        $medicineexdate = $this->medicine_model->getRequestMedicineById($id)->e_date;
        $medicine_id_organisation = $this->medicine_model->getRequestMedicineById($id)->id_organisation;

        $data = array();
        $data = array('name' => $medicinename,
            'category' => $medicinecategory,
            'dosage' => $medicinedosage,
            'type' => $medicinetype,
//                's_price' => $s_price,
//                'quantity' => $quantity,
            'generic' => $medicinegeneric,
            'company' => $medicinecompany,
            'description' => $medicinedescription,
            'add_date' => $add_date,
            'status' => 'Active',
        );
        $this->medicine_model->insertMasterMedicine($data);
        $imported_id = $this->db->insert_id();
        $data = array();
        $data = array('name' => $medicinename,
            'category' => $medicinecategory,
            'type' => $medicinetype,
            'imported_id' => $imported_id,
            's_price' => $medicineprice,
            'quantity' => $medicineqty,
            'id_organisation' => $medicine_id_organisation,
            'description' => $medicinedescription,
            'generic' => $medicinegeneric,
            'company' => $medicinecompany,
            'pharmacist_id' => $pharmacist_id,
            'add_date' => $add_date,
            'e_date' => $medicineexdate,
        );
//            if (empty($id)) {
        $this->medicine_model->insertMedicine($data);

        $this->session->set_flashdata('feedback', lang('added'));
//            } else {
//                $this->medicine_model->updateMedicine($id, $data);
//                $this->session->set_flashdata('feedback', lang('updated'));
//            }
//            redirect('medicine');
//        }


        redirect('medicine/requestMedicineList');
    }

    public function approvedMedicinee() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $category = $this->input->post('category');
        $dosage = $this->input->post('dosage');
        $type = $this->input->post('type');
        $pharmacist_id = $this->input->post('pharmacist_id');
//        $quantity = $this->input->post('quantity');
        $generic = $this->input->post('generic');
        $company = $this->input->post('company');
        $description = $this->input->post('description');
        $status = $this->input->post('status');
        if ((empty($id))) {
            $add_date = date('m/d/y');
        } else {
            $add_date = $this->db->get_where('medicine', array('id' => $id))->row()->add_date;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
// Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
// Validating Category Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[2]|max_length[100]|xss_clean');
// Validating Purchase Price Field
        $this->form_validation->set_rules('dosage', 'Dosage', 'trim|required|min_length[1]|max_length[100]|xss_clean');
// Validating Store Box Field
        $this->form_validation->set_rules('type', 'type', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Selling Price Field
//        $this->form_validation->set_rules('s_price', 'Selling Price', 'trim|required|min_length[1]|max_length[100]|xss_clean');
// Validating Quantity Field
//        $this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|min_length[1]|max_length[100]|xss_clean');
// Validating Generic Name Field
        $this->form_validation->set_rules('generic', 'Generic Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
// Validating Company Name Field
        $this->form_validation->set_rules('company', 'Company', 'trim|min_length[2]|max_length[100]|xss_clean');
// Validating Effects Field
//        $this->form_validation->set_rules('effects', 'Effects', 'trim|min_length[2]|max_length[100]|xss_clean');
// Validating Expire Date Field
//        $this->form_validation->set_rules('e_date', 'Expire Date', 'trim|required|min_length[1]|max_length[100]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['types'] = $this->medicine_model->getMedicineType();
            $data['categories'] = $this->medicine_model->getMedicineCategory();
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_new_medicine_view', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array('name' => $name,
                'category' => $category,
                'dosage' => $dosage,
                'type' => $type,
                'pharmacist_id' => $pharmacist_id,
//                'quantity' => $quantity,
                'generic' => $generic,
                'company' => $company,
                'description' => $description,
                'add_date' => $add_date,
                'status' => 'Pending',
            );
            if (empty($id)) {
                $this->medicine_model->insertRequestMedicine($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->medicine_model->updateRequestMedicine($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('medicine/requestMedicine');
        }
    }

    function editMedicine() {
        $data = array();
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $id = $this->input->get('id');
        $data['medicine'] = $this->medicine_model->getMedicineById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_medicine_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function load() {
        $id = $this->input->post('id');
        $qty = $this->input->post('qty');
        $previous_qty = $this->db->get_where('medicine', array('id' => $id))->row()->quantity;
        $new_qty = $previous_qty + $qty;
        $data = array();
        $data = array('quantity' => $new_qty);
        $this->medicine_model->updateMedicine($id, $data);
        $this->session->set_flashdata('feedback', lang('medicine_loaded'));
        redirect('medicine');
    }

    function editMedicineByJason() {
        $id = $this->input->get('id');
        $data['medicine'] = $this->medicine_model->getMedicineById($id);
        echo json_encode($data);
    }

    function editMasterMedicineByJason() {
        $id = $this->input->get('id');
        $data['medicine'] = $this->medicine_model->getMasterMedicineById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $import_medicine = $this->medicine_model->getMedicineById($id);
        $master_medicine = $this->medicine_model->getMasterMedicineById($import_medicine->imported_id);
        $master_medicine_explode = explode("**", $master_medicine->insert_organ);
        if (count($master_medicine_explode) == 1) {
            $insert_organ = ' ';
        } else {

            $index = array_search($this->id_organisation, $master_medicine_explode);

            unset($master_medicine_explode[$index]);

            $insert_organ = implode('**', $master_medicine_explode);
        }
        $data_up = array('insert_organ' => $insert_organ);
        $this->medicine_model->updateMasterMedicine($master_medicine->id, $data_up);
        $this->medicine_model->deleteMedicine($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('medicine');
    }

    function deleteMasterMedicine() {
        $id = $this->input->get('id');
        $this->medicine_model->deleteMasterMedicine($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('medicine/masterMedicineList');
    }

    function deleteRequestMedicine() {
        $id = $this->input->get('id');
        $this->medicine_model->deleteRequestMedicine($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('medicine/requestMedicineList');
    }

    public function medicineCategory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('medicine_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addCategoryView() {
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_category_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function medicineCategoryList() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
        $data['categories'] = $this->medicine_model->getMedicineCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/superdashboard', $data); // just the header file
        $this->load->view('medicine_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addCategoryVieww() {
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_category_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewCategory() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $description = $this->input->post('description');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
// Validating Category Name Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[2]|max_length[100]|xss_clean');
// Validating Description Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_new_category_view');
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array('category' => $category,
                'description' => $description
            );
            if (empty($id)) {
                $this->medicine_model->insertMedicineCategory($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->medicine_model->updateMedicineCategory($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('medicine/medicineCategoryList');
        }
    }

    function edit_category() {
        $data = array();
        $id = $this->input->get('id');
        $data['medicine'] = $this->medicine_model->getMedicineCategoryById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_category_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editMedicineCategoryByJason() {
        $id = $this->input->get('id');
        $data['medicinecategory'] = $this->medicine_model->getMedicineCategoryById($id);
        echo json_encode($data);
    }

    function deleteMedicineCategory() {
        $id = $this->input->get('id');
        $this->medicine_model->deleteMedicineCategory($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('medicine/medicineCategoryList');
    }

//-------------------------------------
    public function medicineTypeList() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['id_partenaire_zuuluPay'] = $this->id_partenaire_zuuluPay;
        $data['pin_partenaire_zuuluPay_encrypted'] = $this->pin_partenaire_zuuluPay_encrypted;
        $data['pin_decrypted'] = $this->encryption->decrypt($this->pin_partenaire_zuuluPay_encrypted);
        $data['types'] = $this->medicine_model->getMedicineType();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/superdashboard', $data); // just the header file
        $this->load->view('medicine_type', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addTypeVieww() {
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_type_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewType() {
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $description = $this->input->post('description');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
// Validating Category Name Field
        $this->form_validation->set_rules('type', 'Type', 'trim|required|min_length[2]|max_length[100]|xss_clean');
// Validating Description Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/superdashboard', $data); // just the header file
            $this->load->view('add_new_type_view');
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array('type' => $type,
                'description' => $description
            );
            if (empty($id)) {
                $this->medicine_model->insertMedicineType($data);
                $this->session->set_flashdata('feedback', lang('added'));
            } else {
                $this->medicine_model->updateMedicineType($id, $data);
                $this->session->set_flashdata('feedback', lang('updated'));
            }
            redirect('medicine/medicineTypeList');
        }
    }

    function editType() {
        $data = array();
        $id = $this->input->get('id');
        $data['medicine'] = $this->medicine_model->getMedicineTypeById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_type_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editMedicineTypeByJason() {
        $id = $this->input->get('id');
        $data['medicinetype'] = $this->medicine_model->getMedicineTypeById($id);
        echo json_encode($data);
    }

    function deleteMedicineType() {
        $id = $this->input->get('id');
        $this->medicine_model->deleteMedicineType($id);
        $this->session->set_flashdata('feedback', lang('deleted'));
        redirect('medicine/medicineTypeList');
    }

    function getMedicineList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
//        if ($this->ion_auth->in_group(array('Pharmacist'))) {
//            $pharmacist_ion_id = $this->ion_auth->get_user_id();
//            $pharmacist_id = $this->db->get_where('pharmacist', array('ion_user_id' => $pharmacist_ion_id))->row()->id;
        if ($limit == -1) {
            if (!empty($search)) {
                $data['medicines'] = $this->medicine_model->getMedicineByPharmacistSearch($this->id_organisation, $search);
            } else {
                $data['medicines'] = $this->medicine_model->getMedicineByPharmacist($this->id_organisation);
            }
        } else {
            if (!empty($search)) {
                $data['medicines'] = $this->medicine_model->getMedicineByPharmacistLimitBySearch($this->id_organisation, $limit, $start, $search);
            } else {
                $data['medicines'] = $this->medicine_model->getMedicineByPharmacistLimit($this->id_organisation, $limit, $start);
            }
        }

        $i = 0;
        foreach ($data['medicines'] as $medicine) {
            $i = $i + 1;
            $settings = $this->settings_model->getSettings();
            if ($medicine->quantity <= 0) {
                $quan = '<p class="os">Stock Out</p>';
            } else {
                $quan = $medicine->quantity;
            }
            $load = '<button type="button" class="btn btn-info btn-xs btn_width load" data-toggle="modal" data-id="' . $medicine->id . '">' . lang('load') . '</button>';
            $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $medicine->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</button>';
            if ($medicine->status == 'active') {
                $active = ' <label class="switch"><input type="checkbox" class="references_class" name="" data-id="' . $medicine->id . '" value="on" checked/><span class="slider round"></span></label>';
            } else {
                $active = ' <label class="switch"><input type="checkbox" class="references_class" name="" data-id="' . $medicine->id . '" value="on"/><span class="slider round"></span></label>';
            }
            $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="medicine/delete?id=' . $medicine->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            $info[] = array(
                $medicine->name,
                $medicine->category,
                $medicine->type,
                $medicine->dosage,
//                $settings->currency . $medicine->price,
                $settings->currency . $medicine->s_price,
                $quan . '<br>' . $load,
                $medicine->generic,
                $medicine->company,
                $medicine->description,
                $active,
                $medicine->e_date,
                $option2
                    //  $options2
            );
        }

        if (!empty($data['medicines'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('medicine')->num_rows(),
                "recordsFiltered" => $this->db->get('medicine')->num_rows(),
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

    function updateMedicineStatus() {
        $id = $this->input->get('id');
        $value = $this->input->get('value');
        $data = array('status' => $value);
        $this->medicine_model->updateMedicine($id, $data);
        $data['response'] = 'update';
        echo json_encode($data);
    }

    function getRequestMedicineList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($this->ion_auth->in_group(array('Pharmacist'))) {
//            $pharmacist_ion_id = $this->ion_auth->get_user_id();
//            $pharmacist_id = $this->db->get_where('pharmacist', array('ion_user_id' => $pharmacist_ion_id))->row()->id;
            if ($limit == -1) {
                if (!empty($search)) {
                    $data['medicines'] = $this->medicine_model->getRequestMedicineByPharmacistSearch($this->id_organisation, $search);
                } else {
                    $data['medicines'] = $this->medicine_model->getRequestMedicineByPharmacist($this->id_organisation);
                }
            } else {
                if (!empty($search)) {
                    $data['medicines'] = $this->medicine_model->getRequestMedicineByPharmacistLimitBySearch($this->id_organisation, $limit, $start, $search);
                } else {
                    $data['medicines'] = $this->medicine_model->getRequestMedicineByPharmacistLimit($this->id_organisation, $limit, $start);
                }
            }
        } else {
            if ($limit == -1) {
                if (!empty($search)) {
                    $data['medicines'] = $this->medicine_model->getRequestMedicineBySearch($search);
                } else {
                    $data['medicines'] = $this->medicine_model->getRequestMedicine();
                }
            } else {
                if (!empty($search)) {
                    $data['medicines'] = $this->medicine_model->getRequestMedicineByLimitBySearch($limit, $start, $search);
                } else {
                    $data['medicines'] = $this->medicine_model->getRequestMedicineByLimit($limit, $start);
                }
            }
        }

//  $data['appointments'] = $this->appointment_model->getAppointment();
        $i = 0;
        foreach ($data['medicines'] as $medicine) {
            $i = $i + 1;
            $settings = $this->settings_model->getSettings();
            if ($medicine->quantity <= 0) {
                $quan = '<p class="os">Stock Out</p>';
            } else {
                $quan = $medicine->quantity;
            }
            if ($medicine->status == 'Pending') {
                $approved = '<a type="button" class="btn btn-info btn-xs btn_width" href="medicine/approvedMedicine?id=' . $medicine->id . '">' . lang('approved') . '</a>';
            } else {
                $approved = ' ';
            }
            if ($medicine->status == 'Pending') {
                $decline = '<a type="button" class="btn btn-warning btn-xs btn_width" href="medicine/declineMedicine?id=' . $medicine->id . '">' . lang('decline') . '</a>';
            } else {
                $decline = ' ';
            }
//            $approved = '<a type="button" class="btn btn-info btn-xs btn_width" href="medicine/approvedMedicine?id=' . $medicine->id . '">' . lang('approved') . '</a>';
            $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $medicine->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</button>';

            $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="medicine/deleteRequestMedicine?id=' . $medicine->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            if ($this->ion_auth->in_group(array('Pharmacist'))) {
                $info[] = array(
                    $i,
                    $medicine->name,
                    $medicine->category,
                    $medicine->type,
//                $quan . '<br>' . $load,
                    $medicine->generic,
                    $medicine->company,
                    $medicine->description,
                    $medicine->status,
                    $option2
                        //  $options2
                );
            }
            if (!$this->ion_auth->in_group(array('Pharmacist'))) {
                $info[] = array(
                    $i,
                    $medicine->name,
                    $medicine->category,
                    $medicine->type,
//                $quan . '<br>' . $load,
                    $medicine->generic,
                    $medicine->company,
                    $medicine->description,
                    $medicine->status,
                    $option2 . ' ' . $approved . ' ' . $decline
                        //  $options2
                );
            }
        }

        if (!empty($data['medicines'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('request_medicine')->num_rows(),
                "recordsFiltered" => $this->db->get('request_medicine')->num_rows(),
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

    function getMasterMedicineList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        if ($this->ion_auth->in_group(array('Pharmacist'))) {
            if ($limit == -1) {
                if (!empty($search)) {
                    $data['medicines'] = $this->medicine_model->getMasterMedicineBySearchByPharmacist($search);
                } else {
                    $data['medicines'] = $this->medicine_model->getMasterMedicineByPharmacist();
                }
            } else {
                if (!empty($search)) {
                    $data['medicines'] = $this->medicine_model->getMasterMedicineByLimitBySearchByPharmacist($limit, $start, $search);
                } else {
                    $data['medicines'] = $this->medicine_model->getMasterMedicineByLimitByPharmacist($limit, $start);
                }
            }
        } else {
            if ($limit == -1) {
                if (!empty($search)) {
                    $data['medicines'] = $this->medicine_model->getMasterMedicineBySearch($search);
                } else {
                    $data['medicines'] = $this->medicine_model->getMasterMedicine();
                }
            } else {
                if (!empty($search)) {
                    $data['medicines'] = $this->medicine_model->getMasterMedicineByLimitBySearch($limit, $start, $search);
                } else {
                    $data['medicines'] = $this->medicine_model->getMasterMedicineByLimit($limit, $start);
                }
            }
        }
//  $data['appointments'] = $this->appointment_model->getAppointment();
        $i = 0;
        $count = 0;
        foreach ($data['medicines'] as $medicine) {
            $i = $i + 1;
            $settings = $this->settings_model->getSettings();

            $import = '<button type="button" class="btn btn-info btn-xs btn_width load" data-toggle="modal" data-id="' . $medicine->id . '">' . lang('import') . '</button>';
            $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $medicine->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</button>';

            $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="medicine/deleteMasterMedicine?id=' . $medicine->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            if ($this->ion_auth->in_group(array('Pharmacist'))) {
                if ($medicine->status == 'Active') {
                    if (empty($medicine->insert_organ)) {
                        $info[] = array(
                            $medicine->name,
                            $medicine->category,
                            $medicine->type,
                            $medicine->dosage,
                            $medicine->generic,
                            $medicine->company,
                            $medicine->description,
                            $import
                                //  $options2
                        );
                        $count++;
                    } else {

                        $insert_orgaan = explode("**", $medicine->insert_organ);

                        if (!in_array($this->id_organisation, $insert_orgaan)) {
                            $info[] = array(
                                $medicine->name,
                                $medicine->category,
                                $medicine->type,
                                $medicine->dosage,
                                $medicine->generic,
                                $medicine->company,
                                $medicine->description,
                                $import
                                    //  $options2
                            );
                            $count++;
                        } else {
                            $info1[] = array(
                                $medicine->name,
                                $medicine->category,
                                $medicine->type,
                                $medicine->dosage,
                                $medicine->generic,
                                $medicine->company,
                                $medicine->description,
                                $import
                            );
                        }
                    }
                } else {
                    $info1[] = array(
                        $medicine->name,
                        $medicine->category,
                        $medicine->type,
                        $medicine->dosage,
                        $medicine->generic,
                        $medicine->company,
                        $medicine->description,
                        $import
                    );
                }
            } else {
                if ($medicine->status == 'Active') {
                    $active = ' <label class="switch"><input type="checkbox" class="references_class" name="" data-id="' . $medicine->id . '" value="on" checked/><span class="slider round"></span></label>';
                } else {
                    $active = ' <label class="switch"><input type="checkbox" class="references_class" name="" data-id="' . $medicine->id . '" value="on"/><span class="slider round"></span></label>';
                }
                $info[] = array(
                    $medicine->name,
                    $medicine->category,
                    $medicine->type,
                    $medicine->dosage,
                    $medicine->generic,
                    $medicine->company,
                    $medicine->description,
                    $active,
                    $option1 . ' ' . $option2
                );
                $count++;
            }
        }

        if ($count != 0) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('master_medicine')->num_rows(),
                "recordsFiltered" => $this->db->get('master_medicine')->num_rows(),
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

    function updateMasterMedicineStatus() {
        $id = $this->input->get('id');
        $value = $this->input->get('value');
        $data = array('status' => $value);
        $this->medicine_model->updateMasterMedicine($id, $data);
        $data['response'] = 'update';
        echo json_encode($data);
    }

    function getMasterMedicineForPharmacist() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['medicines'] = $this->medicine_model->getMasterMedicineBySearchByPharmacist($search);
            } else {
                $data['medicines'] = $this->medicine_model->getMasterMedicineByPharmacist();
            }
        } else {
            if (!empty($search)) {
                $data['medicines'] = $this->medicine_model->getMasterMedicineByLimitBySearchByPharmacist($limit, $start, $search);
            } else {
                $data['medicines'] = $this->medicine_model->getMasterMedicineByLimitByPharmacist($limit, $start);
            }
        }

//  $data['appointments'] = $this->appointment_model->getAppointment();
        $i = 0;
        foreach ($data['medicines'] as $medicine) {
            $i = $i + 1;
            $settings = $this->settings_model->getSettings();
            if ($medicine->quantity <= 0) {
                $quan = '<p class="os">Stock Out</p>';
            } else {
                $quan = $medicine->quantity;
            }
            $load = '<button type="button" class="btn btn-info btn-xs btn_width load" data-toggle="modal" data-id="' . $medicine->id . '">' . lang('import') . '</button>';
            $option1 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $medicine->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</button>';

            $option2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="medicine/deleteMasterMedicine?id=' . $medicine->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i> ' . lang('delete') . '</a>';
            $info[] = array(
                $i,
                $medicine->name,
                $medicine->category,
                $medicine->type,
//                $quan . '<br>' . $load,
                $medicine->generic,
                $medicine->company,
                $medicine->description,
                $medicine->status,
                $load
                    //  $options2
            );
        }

        if (!empty($data['medicines'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('master_medicine')->num_rows(),
                "recordsFiltered" => $this->db->get('master_medicine')->num_rows(),
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

    public function getMedicinenamelist() {
        $searchTerm = $this->input->post('searchTerm');

        $response = $this->medicine_model->getMedicineNameByAvailablity($searchTerm);
        $data = array();
        foreach ($response as $responses) {
            if ($responses->status == 'Active') {
                $data[] = array("id" => $responses->id, "data-id" => $responses->id, "data-med_name" => $responses->doges, "text" => $responses->name . ' ' . $responses->dosage . ' ' . $responses->type);
            }
        }

        echo json_encode($data);
    }

    public function getMedicineListForSelect2() {
// Search term
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->medicine_model->getMedicineInfo($searchTerm);

        echo json_encode($response);
    }

    public function getMedicineForPharmacyMedicine() {
// Search term
        $searchTerm = $this->input->post('searchTerm');
//        $pharmacist_ion_id = $this->ion_auth->get_user_id();
//        $pharmacist_id = $this->db->get_where('pharmacist', array('ion_user_id' => $pharmacist_ion_id))->row()->id;
// Get users
        $response = $this->medicine_model->getMedicineInfoForPharmacySale($this->id_organisation, $searchTerm);

        echo json_encode($response);
    }

    public function addNewMedicineLightJson() {
//$id = $this->input->post('id');
        $designation = $this->input->post('designation');
        $name_gen = $this->input->post('name_gen');
        $company = $this->input->post('Company');
        $category = $this->input->post('med_Category');
        $effects = $this->input->post('effets_secondaires');

        $add_date = date('m/d/y');

        $data = array();
        $data = array(
            'name' => $designation,
            'category' => $category,
            's_price' => 0,
            'quantity' => 1,
            'generic' => $name_gen,
            'company' => $company,
            'effects' => $effects,
            'add_date' => $add_date,
                // 'e_date' => $e_date,
        );

        $this->medicine_model->insertMedicine($data);
        $this->session->set_flashdata('feedback', lang('added'));
        echo json_encode(array('error' => false));
    }

   

}

/* End of file medicine.php */
/* Location: ./application/modules/medicine/controllers/medicine.php */
