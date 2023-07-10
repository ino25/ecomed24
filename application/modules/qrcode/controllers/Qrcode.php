<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Qrcode extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('finance/finance_model');
        $this->load->model('doctor/doctor_model');
        $this->load->model('patient/patient_model');
        $this->load->model('finance/pharmacy_model');
        $this->load->model('accountant/accountant_model');
        $this->load->model('receptionist/receptionist_model');
        $this->load->model('home/home_model');
        $this->load->model('depot/depot_model');
        $this->load->model('donor/donor_model');
        $this->load->model('lab/lab_model');

        $this->signature = $this->home_model->get_signature($this->id_organisation);

    }

    function index() {
        $id = $this->input->get('id');
        $data['prescription'] = $this->prescription_model->getPrescriptionById($id);
        $data['settings'] = $this->settings_model->getSettings();

        $this->load->view('qrcode', $data);
    }

    function resultat() {
        $id = $this->input->get('id');
        $data['report_details'] = $this->lab_model->getReportbyId($id);
        $data['settings'] = $this->settings_model->getSettings();
        $id_doctor = $data['payments']->doctor;
        $data['signature'] = $this->db->query("select * from doctor_signature where doc_id = '$id_doctor'")->row();
        $data['signature'] = $data['signature']->sign_name;
        $data['signature'] = $this->signature;
        if (isset($data['signature'])) {
            $data['signature'] = $this->signature;
        } else {
            $data['signature'] = 'uploads/entetePartenaires/signatureDefault.png';
        }

        $this->load->view('resultat', $data);
    }

    function resultatLabo() {
        $id = $this->input->get('id');
        $data['payments'] = $this->finance_model->getPaymentByID($id);
        $data['settings'] = $this->settings_model->getSettings();
        $id_doctor = $data['payments']->doctor;
        // $data['signature'] = $this->db->query("select * from doctor_signature where doc_id = '$id_doctor'")->row();
        // $data['signature'] = $data['signature']->sign_name;

        $data['signature'] = $this->signature;
        if (isset($data['signature'])) {
            $data['signature'] = $this->signature;
        } else {
            $data['signature'] = 'uploads/entetePartenaires/signatureDefault.png';
        }
       
        $this->load->view('resultatlabo', $data);
    }

}
