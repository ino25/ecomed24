<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transfert extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('transfert_model');
        $this->load->model('doctor/doctor_model');
        $this->load->model('patient/patient_model');
        $this->load->model('accountant/accountant_model');
        $this->load->model('receptionist/receptionist_model');
        $this->load->model('home/home_model');
        $this->load->model('finance/finance_model');
        if (!$this->ion_auth->in_group(array('admin','adminmedecin', 'Laboratorist'))) {
            redirect('home/permission');
        }
        $identity = $this->session->userdata["identity"];
        $this->id_organisation = $this->home_model->get_id_organisation($identity);
        $this->path_logo = $this->home_model->get_logo_organisation($this->id_organisation);
        $this->nom_organisation = $this->home_model->get_nom_organisation($this->id_organisation);
        $this->code_organisation = $this->home_model->get_code_organisation($this->id_organisation);
    }

    function index() {
        
    }

   

}

/* End of file lab.php */
/* Location: ./application/modules/lab/controllers/lab.php */