<?php

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Request;
use Guzzle\Http\Client;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Visite extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('visite_model');
        $this->load->model('home/home_model');
        $this->load->model('patient/patient_model');
        $this->load->model('doctor/doctor_model');
        $this->load->model('lab/lab_model');
        $this->load->model('donor/donor_model');
        require APPPATH . 'third_party/stripe/stripe-php/init.php';
        if (!$this->ion_auth->in_group(array('admin','adminmedecin', 'Accountant', 'Receptionist', 'Nurse', 'Laboratorist', 'Doctor'))) {
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

    public function index() {
        $data['visites'] = $this->visite_model->getVisite($this->id_organisation);    
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('visite', $data);
        $this->load->view('home/footer', $data); // just the header file
      
    }

     public function liste() {
        $data['visites'] = $this->visite_model->getVisite($this->id_organisation);    
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('visite', $data);
        $this->load->view('home/footer', $data); // just the header file
    }

    public function listeConsultation() {
        $data['visites'] = $this->visite_model->getConsultation($this->id_organisation);    
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('visite_consultation', $data);
        $this->load->view('home/footer', $data); // just the header file
    }

    public function ajout() {
        $data['visites'] = $this->visite_model->getVisite($this->id_organisation);    
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['templates'] = $this->lab_model->getTemplate();
        $data['groups'] = $this->donor_model->getBloodBank();
        $data['settings'] = $this->settings_model->getSettings();
        $data['regions'] = array('Dakar', 'Ziguinchor', 'Diourbel', 'Saint-Louis', 'Tambacounda', 'Kaolack', 'Thiès', 'Louga', 'Fatick', 'Kolda', 'Matam', 'Kaffrine', 'Kédougou', 'Sédhiou');
        $data['religions'] = array('Musulman', 'Chretien', 'Autres');
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer', $data); // just the header file
    }

    public function ajoutConsultation() {
        $data['visites'] = $this->visite_model->getVisite($this->id_organisation);    
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['groups'] = $this->donor_model->getBloodBank();
        $data['settings'] = $this->settings_model->getSettings();
        $data['template'] = $this->lab_model->getTemplateById(28);
        $data['regions'] = array('Dakar', 'Ziguinchor', 'Diourbel', 'Saint-Louis', 'Tambacounda', 'Kaolack', 'Thiès', 'Louga', 'Fatick', 'Kolda', 'Matam', 'Kaffrine', 'Kédougou', 'Sédhiou');
        $data['religions'] = array('Musulman', 'Chretien', 'Autres');
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_consultation', $data);
        $this->load->view('home/footer', $data); // just the header file
    }

    function addNew() {
        $patient_id = $this->input->post('patient_id');
        $patient = $this->input->post('patienthidden');
        $description = $this->input->post('descriptionhidden');
        $taille = $this->input->post('taillehidden');
        $poids = $this->input->post('poidshidden');
        $perimetre_thoracique = $this->input->post('perimetrethoraciquehidden');
        $pignet = $this->input->post('pignethidden');
        $systolique = $this->input->post('systoliquehidden');
        $diastolique = $this->input->post('diastoliquehidden');
        $tensionArterielle = $this->input->post('tensionArteriellehidden');
        $sucre = $this->input->post('textsurcrehidden');
        $albumine = $this->input->post('textalbuminehidden');

        $oeildroit = $this->input->post('oeildroitehidden');
        $droit10 = '10';
        $gauche10 = '10';
        $oeilgauche = $this->input->post('oeilgauchehidden');
        $oreilledroite = $this->input->post('oreilledroitehidden');
        $oreilledroite10 = '10';
        $oreillegauche = $this->input->post('oreillegauchehidden');
        $oeilgauche10 = '10';
        $type = $this->input->post('type');
        $bu = $this->input->post('buhidden');
        $dextro = $this->input->post('dextrohidden');
        $rvhidden = $this->input->post('rvhidden');
        $user = $this->ion_auth->get_user_id();


        $img_url = $this->input->post('img_url');
        $date = time();
        $redirect = $this->input->post('redirect');


        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Patient Field
        $this->form_validation->set_rules('patient', 'Patient', 'trim|min_length[1]|max_length[100]|xss_clean');




        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', lang('validation_error'));
            redirect($redirect);
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
                'max_size' => "48000000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "3000",
                'max_width' => "2024"
            );

            $this->load->library('Upload', $config);
            $this->upload->initialize($config);
            if (!empty($patient_id)) {
                $patient_details = $this->patient_model->getPatientById($patient_id, $this->id_organisation);
                $patient_name = $patient_details->name;
                $patient_last_name = $patient_details->last_name;
                $patient_phone = $patient_details->phone;
                $patient_code = $patient_details->patient_id;
                $patient_adresse = $patient_details->address;
                $patient_sexe = $patient_details->sex;
                $patient_birthday = $patient_details->birthdate;
            } else {
                $patient_name = 0;
                $patient_phone = 0;
            }
            if ($this->upload->do_upload('img_url')) {
                $path = $this->upload->data();
                $img_url = "uploads/" . $path['file_name'];
                $data = array();
                $data = array(
                    'date' => $date,
                    'patient_id' => $patient_id,
                    'patient' => $patient,
                    'id_organisation ' => $this->id_organisation,
                    'taille' => $taille,
                    'poids' => $poids,
                    'perimetre_thoracique' => $perimetre_thoracique,
                    'pignet' => $pignet,
                    'systolique' => $systolique,
                    'diastolique' => $diastolique,
                    'tension_arterielle' => $tensionArterielle,
                    'sucre' => $sucre,
                    'albumine' => $albumine,
                    'oeil_droit' => $oeildroit,
                    'droit10' => $droit10,
                    'gauche10' => $gauche10,
                    'description' => $description,
                    'oeil_gauche' => $oeilgauche,
                    'oreille_droite' => $oreilledroite,
                    'oreilledroite10' => $oreilledroite10,
                    'oreille_gauche' => $oreillegauche,
                    'oeilgauche10' => $oeilgauche10,
                    'patient_name' => $patient_name,
                    'patient_last_name' => $patient_last_name,
                    'patient_phone' => $patient_phone,
                    'url' => $img_url,
                    'date_string' => date('d-m-Y H:i', $date),
                    'patient_code' => $patient_code,
                    'type' => $type,
                    'patient_address' => $patient_adresse,
                    'patient_sexe' => $patient_sexe,
                    'patient_birthday' => $patient_birthday,
                    'bu' => $bu,
                    'dextro' => $dextro,
                    'rdv' => $rvhidden,
                    'user' => $this->ion_auth->get_user_id(),
                );
            } else {
                $data = array();
                $data = array(
                    'date' => $date,
                    'patient' => $patient,
                    'patient_id' => $patient_id,
                    'id_organisation ' => $this->id_organisation,
                    'taille' => $taille,
                    'poids' => $poids,
                    'perimetre_thoracique' => $perimetre_thoracique,
                    'pignet' => $pignet,
                    'systolique' => $systolique,
                    'diastolique' => $diastolique,
                    'tension_arterielle' => $tensionArterielle,
                    'sucre' => $sucre,
                    'albumine' => $albumine,
                    'oeil_droit' => $oeildroit,
                    'droit10' => $droit10,
                    'gauche10' => $gauche10,
                    'description' => $description,
                    'oeil_gauche' => $oeilgauche,
                    'oreille_droite' => $oreilledroite,
                    'oreilledroite10' => $oreilledroite10,
                    'oreille_gauche' => $oreillegauche,
                    'patient_name' => $patient_name,
                    'patient_last_name' => $patient_last_name,
                    'patient_phone' => $patient_phone,
                    'oeilgauche10' => $oeilgauche10,
                    'patient_code' => $patient_code,
                    'date_string' => date('d-m-y', $date),
                    'type' => $type,
                    'patient_address' => $patient_adresse,
                    'patient_sexe' => $patient_sexe,
                    'patient_birthday' => $patient_birthday,
                    'bu' => $bu,
                    'dextro' => $dextro,
                    'rdv' => $rvhidden,
                    'user' => $this->ion_auth->get_user_id(),
                );
                $this->session->set_flashdata('feedback', lang('upload_error'));
            }

            $this->visite_model->insertVisite($data); 
            $this->session->set_flashdata('feedback', lang('added'));

            if(!empty($type) ){
                redirect('visite/listeConsultation');
            }else{
                redirect('visite/liste');
            }

        }
    }

    function visiteInvoice() {
        $id = $this->input->get('id');
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['settings'] = $this->settings_model->getSettings();
        $data['visite'] = $this->visite_model->getVisiteById($id);
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $data['organisation'] = $this->home_model->getOrganisationById($this->id_organisation);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('visite_invoice', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function consultationInvoice() {
        $id = $this->input->get('id');
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $data['settings'] = $this->settings_model->getSettings();
        $data['visite'] = $this->visite_model->getVisiteById($id);
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $data['organisation'] = $this->home_model->getOrganisationById($this->id_organisation);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('consultation_invoice', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

}

/* End of file service.php */
/* Location: ./application/modules/service/controllers/service.php */
