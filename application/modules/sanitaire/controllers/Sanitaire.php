<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sanitaire extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('sanitaire_model');
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
        $this->entete = $this->home_model->get_entete($this->id_organisation);
        $this->footer = $this->home_model->get_footer($this->id_organisation);
        $this->nom_organisation = $this->home_model->get_nom_organisation($this->id_organisation);
        $this->id_partenaire_zuuluPay = $this->home_model->id_partenaire_zuuluPay($this->id_organisation);
        $this->pin_partenaire_zuuluPay_encrypted = $this->home_model->pin_partenaire_zuuluPay_encrypted($this->id_organisation);
        $this->code_organisation = $this->home_model->get_code_organisation($this->id_organisation);
        $this->entete = $this->home_model->get_entete($this->id_organisation);
    }


    function index()
    {
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 86399;
        }
        $data = array();

        $dateDebut = $this->input->get('debut');
        $dateFin = $this->input->get('fin');
        $typedepense = $this->input->get('type');




        $data['payments'] = $this->finance_model->getPaymentByDate($date_from, $date_to, $this->id_organisation);
        $data['ot_payments'] = $this->finance_model->getOtPaymentByDate($date_from, $date_to);
        $data['deposits'] = $this->finance_model->getDepositsByDate($date_from, $date_to);
        $data['expenses'] = $this->finance_model->getExpenseByDate($date_from, $date_to, $this->id_organisation);
        $data['sanitaires'] = $this->sanitaire_model->getSanitaireAll($this->id_organisation);

        if (!empty($typedepense)) {
            $date_debut = $dateDebut . ' 00:00';
            $date_debut = strtotime(str_replace('/', '-', $date_debut));
            $date_fin = $dateFin . ' 23:59';
            $date_fin = strtotime(str_replace('/', '-', $date_fin));
            $data['datePeriode'] = 'Du ' . $dateDebut . ' au ' . $dateFin;
            $data['sanitaires'] = $this->sanitaire_model->getTableSanitaireFilterTypeByLimitBySearch(10, 1, 'test', $this->id_organisation, $date_debut, $date_fin, $typedepense);
            $data['dateDebut'] = $dateDebut;
            $data['dateFin'] = $dateFin;
        } else if ($dateDebut) {
            $date_debut = $dateDebut . ' 00:00';
            $date_debut = strtotime(str_replace('/', '-', $date_debut));
            $date_fin = $dateFin . ' 23:59';
            $date_fin = strtotime(str_replace('/', '-', $date_fin));
            $data['sanitaires'] = $this->sanitaire_model->getSanitaireFilterDate($this->id_organisation, $date_debut, $date_fin);
            $data['datePeriode'] = 'Du ' . $dateDebut . ' au ' . $dateFin;
            $data['dateDebut'] = $dateDebut;
            $data['dateFin'] = $dateFin;
        } else {
            $data['sanitaires'] = $this->sanitaire_model->getSanitaireAll($this->id_organisation);
            $data['datePeriode'] = ' ' . $dateDebut . '  ' . $dateFin;
            $data['dateDebut'] = $dateDebut;
            $data['dateFin'] = $dateFin;
        }
        $data['from'] = $this->input->post('date_from');
        $data['to'] = $this->input->post('date_to');
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('all_sanitaire', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function getSanitaires()
    {
        //		$date_from = strtotime($this->input->post('date_from'));
        //		$date_to = strtotime($this->input->post('date_to'));
        //		if (!empty($date_to)) {
        //			$date_to = $date_to + 86399;
        //		}
        $data = array();

        $dateDebut = $this->input->get('debut');
        $dateFin = $this->input->get('fin');
        $typedepense = $this->input->get('type');

        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $settings = $this->settings_model->getSettings();
        $date_debut = $dateDebut . ' 00:00';
        $date_debut = strtotime(str_replace('/', '-', $date_debut));
        $date_fin = $dateFin . ' 23:59';
        $date_fin = strtotime(str_replace('/', '-', $date_fin));

        if ($limit == -1) {
            if (!empty($search)) {
                $data['sanitaires'] = $this->sanitaire_model->getTableSanitaireFilterTypeBySearch($search, $this->id_organisation, $date_debut, $date_fin, $typedepense);
            } else {
                $data['sanitaires'] = $this->sanitaire_model->getTableSanitaireFilterType($this->id_organisation, $date_debut, $date_fin, $typedepense);
            }
        } else {
            if (!empty($search)) {
                $data['sanitaires'] = $this->sanitaire_model->getTableSanitaireFilterTypeByLimitBySearch($limit, $start, $search, $this->id_organisation, $date_debut, $date_fin, $typedepense);
            } else {
                $data['sanitaires'] = $this->sanitaire_model->getTableSanitaireFilterTypeByLimit($limit, $start, $this->id_organisation, $date_debut, $date_fin, $typedepense);
            }
        }
        //        if ($Payment_encours) {
        //            $data['payments'] = $this->finance_model->getPaymentByFilter($this->id_organisation, $Payment_encours);
        //        } else {
        //            $data['payments'] = $this->finance_model->getPayment($this->id_organisation);
        //        }
        $i = 0;
        foreach ($data['sanitaires'] as $sanitaire) {
            $i++;
            //$button = '<a class="btn btn-info btn-xs btn_width delete_button" href="horaire/deleteScheduleService?id='.$schedule->id.'&service='.$service.'&weekday='.$schedule->weekday.'" onclick="return confirm("Souhaitez-vous supprimer cette hooraire ?");"><i class="fa fa-trash"> </i> '.lang('delete').'</a>';

            $resultat = '';
            if ($sanitaire->resultat == 'positive') {
                $resultat =  '<span style="color: rgba(255, 0, 0, 1.00);
			                                    font-weight: bold;"> Positif</span>';
            } else {
                $resultat =  '<span style="color: #279B38;
			                                    font-weight: bold;"> Négatif</span>';
            }

            $info[] = array(
                $sanitaire->dateString,
                $sanitaire->patientName . ' ' . $sanitaire->patientLast_Name,
                $sanitaire->phone,
                $sanitaire->age,
                $sanitaire->sex,
                $sanitaire->name,
                $sanitaire->sampling_date,
                $resultat,
                $sanitaire->resultat,
                $sanitaire->patientName,
                $sanitaire->patientLast_Name,
                $sanitaire->code,
                $sanitaire->address,
                $sanitaire->report_code,
                '',
                'RSA',
                '',
                '1',
                $sanitaire->date_string,
                ''
            );
        }

        if (!empty($data['sanitaires']) && trim($search)) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => count($this->sanitaire_model->getTableSanitaireFilterType($this->id_organisation, $date_debut, $date_fin, $typedepense)),
                "recordsFiltered" => count($this->sanitaire_model->getTableSanitaireFilterTypeBySearch($search, $this->id_organisation, $date_debut, $date_fin, $typedepense)),
                "data" => $info
            );
        } else if (!empty($data['sanitaires'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => count($this->sanitaire_model->getTableSanitaireFilterType($this->id_organisation, $date_debut, $date_fin, $typedepense)),
                "recordsFiltered" => count($this->sanitaire_model->getTableSanitaireFilterType($this->id_organisation, $date_debut, $date_fin, $typedepense)),
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


    function sarsCOV2()
    {
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 86399;
        }
        $data = array();

        $dateDebut = $this->input->get('debut');
        $dateFin = $this->input->get('fin');
        $typedepense = $this->input->get('type');




        $data['payments'] = $this->finance_model->getPaymentByDate($date_from, $date_to, $this->id_organisation);
        $data['ot_payments'] = $this->finance_model->getOtPaymentByDate($date_from, $date_to);
        $data['deposits'] = $this->finance_model->getDepositsByDate($date_from, $date_to);
        $data['expenses'] = $this->finance_model->getExpenseByDate($date_from, $date_to, $this->id_organisation);
        $data['sanitaires'] = $this->sanitaire_model->getSanitaireAllSarco($this->id_organisation);

        if (!empty($typedepense)) {
            $date_debut = $dateDebut . ' 00:00';
            $date_debut = strtotime(str_replace('/', '-', $date_debut));
            $date_fin = $dateFin . ' 23:59';
            $date_fin = strtotime(str_replace('/', '-', $date_fin));
            $data['datePeriode'] = 'Du ' . $dateDebut . ' au ' . $dateFin;
            $data['sanitaires'] = $this->sanitaire_model->getTableSanitaireFilterTypeByLimitBySearchSarco(10, 1, 'test', $this->id_organisation, $date_debut, $date_fin, $typedepense);
            $data['dateDebut'] = $dateDebut;
            $data['dateFin'] = $dateFin;
        } else if ($dateDebut) {
            $date_debut = $dateDebut . ' 00:00';
            $date_debut = strtotime(str_replace('/', '-', $date_debut));
            $date_fin = $dateFin . ' 23:59';
            $date_fin = strtotime(str_replace('/', '-', $date_fin));
            $data['sanitaires'] = $this->sanitaire_model->getSanitaireFilterDateSarco($this->id_organisation, $date_debut, $date_fin);
            $data['datePeriode'] = 'Du ' . $dateDebut . ' au ' . $dateFin;
            $data['dateDebut'] = $dateDebut;
            $data['dateFin'] = $dateFin;
        } else {
            $data['sanitaires'] = $this->sanitaire_model->getSanitaireAllSarco($this->id_organisation);
            $data['datePeriode'] = ' ' . $dateDebut . '  ' . $dateFin;
            $data['dateDebut'] = $dateDebut;
            $data['dateFin'] = $dateFin;
        }
        $data['from'] = $this->input->post('date_from');
        $data['to'] = $this->input->post('date_to');
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('all_sanitaire_sarco', $data);
        $this->load->view('home/footer'); // just the footer fi
    }


    function rapportActivite()
    {
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 86399;
        }
        $data = array();

        $dateDebut = $this->input->get('debut');
        $dateFin = $this->input->get('fin');
        $sexe = $this->input->get('type');
        $conclusion = $this->input->get('conclusion');



        $data['illness_conclusion'] = $this->sanitaire_model->getIllnessConclusion($this->id_organisation);
        $data['ot_payments'] = $this->finance_model->getOtPaymentByDate($date_from, $date_to);
        $data['deposits'] = $this->finance_model->getDepositsByDate($date_from, $date_to);
        $data['expenses'] = $this->finance_model->getExpenseByDate($date_from, $date_to, $this->id_organisation);

        if (!empty($sexe) && !empty($conclusion)) {
            $date_debut = $dateDebut . ' 00:00';
            $date_debut = strtotime(str_replace('/', '-', $date_debut));
            $date_fin = $dateFin . ' 23:59';
            $date_fin = strtotime(str_replace('/', '-', $date_fin));
            $data['datePeriode'] = 'Du ' . $dateDebut . ' au ' . $dateFin;
            $data['illness'] = $this->sanitaire_model->getIllnessConsultationSexeConclusion($this->id_organisation, $date_debut, $date_fin, $sexe, $conclusion);
            $data['dateDebut'] = $dateDebut;
            $data['dateFin'] = $dateFin;
        }else if (!empty($sexe)) {
            $date_debut = $dateDebut . ' 00:00';
            $date_debut = strtotime(str_replace('/', '-', $date_debut));
            $date_fin = $dateFin . ' 23:59';
            $date_fin = strtotime(str_replace('/', '-', $date_fin));
            $data['datePeriode'] = 'Du ' . $dateDebut . ' au ' . $dateFin;
            $data['illness'] = $this->sanitaire_model->getIllnessConsultationSexe($this->id_organisation, $date_debut, $date_fin, $sexe);
            $data['dateDebut'] = $dateDebut;
            $data['dateFin'] = $dateFin;
        }
         else if (!empty($conclusion)) {
            $date_debut = $dateDebut . ' 00:00';
            $date_debut = strtotime(str_replace('/', '-', $date_debut));
            $date_fin = $dateFin . ' 23:59';
            $date_fin = strtotime(str_replace('/', '-', $date_fin));
            $data['datePeriode'] = 'Du ' . $dateDebut . ' au ' . $dateFin;
            $data['illness'] = $this->sanitaire_model->getIllnessConsultationConclusion($this->id_organisation, $date_debut, $date_fin, $conclusion);
            $data['dateDebut'] = $dateDebut;
            $data['dateFin'] = $dateFin;
        } else if ($dateDebut) {
            $date_debut = $dateDebut . ' 00:00';
            $date_debut = strtotime(str_replace('/', '-', $date_debut));
            $date_fin = $dateFin . ' 23:59';
            $date_fin = strtotime(str_replace('/', '-', $date_fin));
            $data['illness'] = $this->sanitaire_model->getIllnessConsultationDate($this->id_organisation, $date_debut, $date_fin);
            $data['datePeriode'] = 'Du ' . $dateDebut . ' au ' . $dateFin;
            $data['dateDebut'] = $dateDebut;
            $data['dateFin'] = $dateFin;
        } else {
            $data['illness'] = $this->sanitaire_model->getIllnessConsultation($this->id_organisation);
            $data['datePeriode'] = ' ' . $dateDebut . '  ' . $dateFin;
            $data['dateDebut'] = $dateDebut;
            $data['dateFin'] = $dateFin;
        }
        $data['from'] = $this->input->post('date_from');
        $data['to'] = $this->input->post('date_to');
        $data['settings'] = $this->settings_model->getSettings();
        $data['id_organisation'] = $this->id_organisation;
        $data['path_logo'] = $this->path_logo;
        $data['nom_organisation'] = $this->nom_organisation;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('all_illness_consultation', $data);
        $this->load->view('home/footer'); // just the footer fi
    }


    function getSarsCOV2()
    {

        $data = array();

        $dateDebut = $this->input->get('debut');
        $dateFin = $this->input->get('fin');
        $typedepense = $this->input->get('type');

        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        $settings = $this->settings_model->getSettings();
        $date_debut = $dateDebut . ' 00:00';
        $date_debut = strtotime(str_replace('/', '-', $date_debut));
        $date_fin = $dateFin . ' 23:59';
        $date_fin = strtotime(str_replace('/', '-', $date_fin));

        if ($limit == -1) {
            if (!empty($search)) {
                $data['sanitaires'] = $this->sanitaire_model->getTableSanitaireFilterTypeBySearchSarco($search, $this->id_organisation, $date_debut, $date_fin, $typedepense);
            } else {
                $data['sanitaires'] = $this->sanitaire_model->getTableSanitaireFilterTypeSarco($this->id_organisation, $date_debut, $date_fin, $typedepense);
            }
        } else {
            if (!empty($search)) {
                $data['sanitaires'] = $this->sanitaire_model->getTableSanitaireFilterTypeByLimitBySearchSarco($limit, $start, $search, $this->id_organisation, $date_debut, $date_fin, $typedepense);
            } else {
                $data['sanitaires'] = $this->sanitaire_model->getTableSanitaireFilterTypeByLimitSarco($limit, $start, $this->id_organisation, $date_debut, $date_fin, $typedepense);
            }
        }
        //        if ($Payment_encours) {
        //            $data['payments'] = $this->finance_model->getPaymentByFilter($this->id_organisation, $Payment_encours);
        //        } else {
        //            $data['payments'] = $this->finance_model->getPayment($this->id_organisation);
        //        }
        $i = 0;

        foreach ($data['sanitaires'] as $sanitaire) {
            $i++;
            //$button = '<a class="btn btn-info btn-xs btn_width delete_button" href="horaire/deleteScheduleService?id='.$schedule->id.'&service='.$service.'&weekday='.$schedule->weekday.'" onclick="return confirm("Souhaitez-vous supprimer cette hooraire ?");"><i class="fa fa-trash"> </i> '.lang('delete').'</a>';

            $resultat = '';
            if ($sanitaire->resultats == 'Positif') {
                $resultat =  '<span style="color: rgba(255, 0, 0, 1.00);
			                                    font-weight: bold;"> Positif</span>';
            } else {
                $resultat =  '<span style="color: #279B38;
			                                    font-weight: bold;"> Négatif</span>';
            }

            $info[] = array(
                $sanitaire->date,
                $sanitaire->patientName . ' ' . $sanitaire->patientLast_Name,
                $sanitaire->phone,
                $sanitaire->age,
                $sanitaire->sex,
                $sanitaire->name,
                $sanitaire->sampling_date,
                $resultat,
                $sanitaire->resultats,
                $sanitaire->patientName,
                $sanitaire->patientLast_Name,
                $sanitaire->code,
                $sanitaire->address,
                $sanitaire->report_code,
                '',
                'RSA',
                '',
                '1',
                $sanitaire->date_string,
                ''
            );
        }

        if (!empty($data['sanitaires']) && trim($search)) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => count($this->sanitaire_model->getTableSanitaireFilterTypeSarco($this->id_organisation, $date_debut, $date_fin, $typedepense)),
                "recordsFiltered" => count($this->sanitaire_model->getTableSanitaireFilterTypeBySearch($search, $this->id_organisation, $date_debut, $date_fin, $typedepense)),
                "data" => $info
            );
        } else if (!empty($data['sanitaires'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => count($this->sanitaire_model->getTableSanitaireFilterTypeSarco($this->id_organisation, $date_debut, $date_fin, $typedepense)),
                "recordsFiltered" => count($this->sanitaire_model->getTableSanitaireFilterTypeBySearchSarco($this->id_organisation, $date_debut, $date_fin, $typedepense)),
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
}

/* End of file prescription.php */
/* Location: ./application/modules/prescription/controllers/prescription.php */
