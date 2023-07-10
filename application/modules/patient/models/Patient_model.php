<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Patient_model extends CI_model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function insertPatient($data)
    {
        $this->db->insert('patient', $data);
        $str = $this->db->insert_id();
        return $str;
    }

    function insertPresconditions($data)
    {
        $this->db->insert('pre_conditions', $data);
        $str = $this->db->insert_id();
        return $str;
    }
    
    function insertMedications($data)
    {
        $this->db->insert('current_medications', $data);
        $str = $this->db->insert_id();
        return $str;
    }

    function insertVitalSign($data)
    {
        $this->db->insert('vital_sign', $data);
        $str = $this->db->insert_id();
        return $str;
    }

    function insertIllnessConsultation($data)
    {
        $this->db->insert('illness_consultation', $data);
        $str = $this->db->insert_id();
        return $str;
    }

    function getPatient($id_organisation)
    {
        $this->db->order_by('id', 'desc');
        // $this->db->like('status', 1);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('patient');
        return $query->result();
    }
    
    function getVitalSign($id)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $id);
        $this->db->limit(1);
        $query = $this->db->get('vital_sign');
        return $query->result();
    }

    function getVaccination($id)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $id);
        $query = $this->db->get('vaccination');
        return $query->result();
    }

    function getPatientBySearch($search, $id_organisation)
    {
        $this->db->order_by('id', 'desc');
		$this->db->group_start();
	    $this->db->like('id', $search);
        $this->db->or_like('patient_id', $search);
	    $this->db->or_like('name', $search);
	    $this->db->or_like('phone', $search);
        $this->db->or_like('phone_recuperation', $search);
		$this->db->group_end();
	    //$this->db->or_like('address', $search);
        $this->db->where('status', 1);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('patient');
        return $query->result();
    }

    function getPatientByLimit($limit, $start, $id_organisation)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $this->db->like('status', 1);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('patient');
        return $query->result();
    }

    function getPatientByLimitBySearch($limit, $start, $search, $id_organisation)
    {
	    $this->db->order_by('id', 'desc');
	    $this->db->where('status', 1);
	    $this->db->where('id_organisation', $id_organisation);
	    $this->db->group_start();
        $this->db->like('id', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('phone', $search);
	    $this->db->group_end();
        //$this->db->or_like('address', $search);
        $this->db->limit($limit, $start);
        $query = $this->db->get('patient');
        return $query->result();
    }

    function getPatientById($id)
    {
        $this->db->where('id', $id);
        // $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('patient');
        return $query->row();
    }

 
    function getUserById($id, $id_organisation)
    {
        $this->db->where('id', $id);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('users');
        return $query->row();
    }

    function getPatientByIonUserId($id, $id_organisation)
    {
        $this->db->where('ion_user_id', $id);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('patient');
        return $query->row();
    }

    function getPatientByEmail($email, $id_organisation)
    {
        $this->db->where('email', $email);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('patient');
        return $query->row();
    }

    function updatePatient($id, $data, $id_organisation)
    {
        $this->db->where('id', $id);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->update('patient', $data);
    }

    function updatePatientNumberPassage($id, $data, $id_organisation)
    {
        $this->db->where('id', $id);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->update('patient', $data);
    }

    function delete($id, $id_organisation)
    {
        $this->db->where('id', $id);
        $this->db->where('id_organisation', $id_organisation);
        // $this->db->delete('patient');
        $this->db->update('patient', array('status' => NULL));
    }

    function insertMedicalHistory($data, $id_organisation)
    {
        $this->db->insert('medical_history', $data);
    }
    
    function insertPatientHospitalisation($data)
    {
        $this->db->insert('hospitalization', $data);
    }

    function getPatientHospitalisation($id)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $id);
        $query = $this->db->get('hospitalization');
        return $query->result();
    }

    function getMedicalHistoryByPatientId($id, $id_organisation)
    {
        $query = $this->db->query("select medical_history.id,medical_history.patient_id,medical_history.title,medical_history.description,
        medical_history.sucre, medical_history.albumine, medical_history.oeildroit, medical_history.oeilgauche, medical_history.oreilledroite, medical_history.oreillegauche,
        medical_history.specialite,medical_history.namePrestation,
        medical_history.patient_name,medical_history.patient_last_name,
        medical_history.date,medical_history.date_string,medical_history.payment_id,users.first_name,users.last_name,users.username from medical_history 
        join users ON users.id = medical_history.user 
        AND medical_history.id_organisation = " . $id_organisation . "
        AND medical_history.patient_id = " . $id . "
        Order By medical_history.id DESC");
        return $query->result();
    }

    function getMedicalHistory($id_organisation)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('medical_history');
        return $query->result();
    }

    function getMedicalHistoryBySearch($search, $id_organisation)
    {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('patient_name', $search);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('medical_history');
        return $query->result();
    }

    function getMedicalHistoryByLimit($limit, $start, $id_organisation)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->limit($limit, $start);
        $query = $this->db->get('medical_history');
        return $query->result();
    }

    function getMedicalHistoryByLimitBySearch($limit, $start, $search, $id_organisation)
    {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('patient_name', $search);
        $this->db->or_like('patient_phone', $search);
        $this->db->or_like('patient_address', $search);

        $this->db->or_like('description', $search);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->limit($limit, $start);
        $query = $this->db->get('medical_history');
        return $query->result();
    }

    function getMedicalHistoryById($id, $id_organisation)
    {
        // $this->db->where('id', $id);
        // $this->db->where('id_organisation', $id_organisation);
        // $query = $this->db->get('medical_history');
        $query = $this->db->query("select medical_history.id,medical_history.patient_id,medical_history.title,medical_history.description,medical_history.patient_name,medical_history.patient_last_name,
        medical_history.sucre, medical_history.albumine, medical_history.oeildroit, medical_history.oeilgauche, medical_history.oreilledroite, medical_history.oreillegauche,
        medical_history.specialite,medical_history.namePrestation,medical_history.poids,medical_history.taille,medical_history.temperature,
        medical_history.frequenceRespiratoire,medical_history.frequenceCardiaque,medical_history.glycemyCapillaire,
        medical_history.systolique,medical_history.diastolique,medical_history.tensionArterielle,medical_history.Saturationarterielle,medical_history.SaturationVeineux,
        medical_history.HypertensionSystolique,medical_history.HypertensionDiastolique,
        medical_history.date,medical_history.date_string,medical_history.payment_id,users.first_name,users.last_name,users.username from medical_history 
        join users ON users.id = medical_history.user 
        AND medical_history.id_organisation = " . $id_organisation . "
             AND medical_history.id = " . $id . "
        Order By medical_history.id DESC");
        return $query->row();
    }

    function updateMedicalHistory($id, $data, $id_organisation)
    {
        $this->db->where('id', $id);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->update('medical_history', $data);
    }

    function insertDiagnosticReport($data, $id_organisation)
    {
        $this->db->insert('diagnostic_report', $data);
    }

    function updateDiagnosticReport($id, $data, $id_organisation)
    {
        $this->db->where('id', $id);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->update('diagnostic_report', $data);
    }

    function getDiagnosticReport($id_organisation)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('diagnostic_report');
        return $query->result();
    }

    function getDiagnosticReportById($id, $id_organisation)
    {
        $this->db->where('id', $id);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('diagnostic_report');
        return $query->row();
    }

    function getDiagnosticReportByInvoiceId($id, $id_organisation)
    {
        $this->db->where('invoice', $id);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('diagnostic_report');
        return $query->row();
    }

    function getDiagnosticReportByPatientId($id, $id_organisation)
    {
        $this->db->where('patient', $id);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('diagnostic_report');
        return $query->result();
    }

    function insertPatientMaterial($data)
    {
        $this->db->insert('patient_material', $data);
    }

    function insertConsultationVisite($data)
    {
        $this->db->insert('visite_consultation', $data);
    }


    function insertPatientMaterialLabo($data)
    {
        $this->db->insert('lab', $data);
    }

    function getPatientMaterial($id_organisation)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('patient_material');
        return $query->result();
    }

    function getDocumentBySearch($search, $id_organisation)
    {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('patient_name', $search);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('patient_material');
        return $query->result();
    }

    function getVisiteConsultation($id)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('patient_id', $id);
        $query = $this->db->get('medical_history');
        return $query->result();
    }

    function getMedicalHistoryPatient($id) {
        $query = $this->db->query("select medical_history.id, medical_history.date, template.name from medical_history join template on template.id = medical_history.template_id where medical_history.patient_id = " . $id . " order by medical_history.id desc");
        // var_dump($query);
        // exit();
        return $query->result();
    }

    function getDocumentByLimit($limit, $start, $id_organisation)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->limit($limit, $start);
        $query = $this->db->get('patient_material');
        return $query->result();
    }

    function getDocumentByLimitBySearch($limit, $start, $search, $id_organisation)
    {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('date_string', $search);

        $this->db->or_like('patient_name', $search);
        $this->db->or_like('patient_phone', $search);
        $this->db->or_like('patient_address', $search);

        $this->db->or_like('title', $search);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->limit($limit, $start);
        $query = $this->db->get('patient_material');
        return $query->result();
    }

    function getPatientMaterialById($id, $id_organisation)
    {
        $this->db->where('id', $id);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('patient_material');
        return $query->row();
    }

    function getPatientMaterialByPatientId($id, $id_organisation)
    {
        $this->db->where('patient', $id);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('patient_material');
        return $query->result();
    }

    function deletePatientMaterial($id, $id_organisation)
    {
        $this->db->where('id', $id);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->delete('patient_material');
    }

    function deleteMedicalHistory($id, $id_organisation)
    {
        $this->db->where('id', $id);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->delete('medical_history');
    }

    function updateIonUser($username, $email, $password, $ion_user_id, $id_organisation)
    {
        $uptade_ion_user = array(
            'username' => $username,
            'email' => $email,
            // 'password' => $password
        );
        $this->db->where('id', $ion_user_id);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->update('users', $uptade_ion_user);
    }

    function getDueBalanceByPatientId($patient, $id_organisation)
    {
        // $query = $this->db->get_where('payment', array('patient' => $patient, 'id_organisation' => $id_organisation))->result();
        // $deposits = $this->db->get_where('patient_deposit', array('patient' => $patient))->result();
        // $balance = array();
        // $deposit_balance = array();
        // foreach ($query as $gross) {
        // $balance[] = $gross->gross_total;
        // }
        // $balance = array_sum($balance);

        // foreach ($deposits as $deposit) {
        // $deposit_balance[] = $deposit->deposited_amount;
        // }
        // $deposit_balance = array_sum($deposit_balance);

        $balance = $this->db->query('select SUM(gross_total) as sum_gross from payment where payment.bulletinAnalyse like "" and patient = ' . $patient . ' and id_organisation=' . $id_organisation)->row()->sum_gross;
        $frais_service = $this->db->query('select SUM(frais_service) as sum_gross from payment where payment.bulletinAnalyse like "" and patient = ' . $patient . ' and id_organisation=' . $id_organisation)->row()->sum_gross;
        $deposit_balance = $this->db->query('select SUM(deposited_amount) as sum_deposit from patient_deposit where patient = ' . $patient)->row()->sum_deposit;

       
        $bill_balance = $balance + $frais_service;

        return $due_balance = $bill_balance - $deposit_balance;
       
    }

    function getPatientInfo($searchTerm, $id_organisation)
    {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where("name like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $this->db->where('id_organisation', $id_organisation);
            $fetched_records = $this->db->get('patient');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('id_organisation', $id_organisation);
            // $this->db->where("name like '%".$searchTerm."%' ");
            //  $this->db->or_where("id like '%".$searchTerm."%' ");
            $this->db->limit(10);
            $fetched_records = $this->db->get('patient');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['name'] . ' ' . $user['last_name'] . ' (' . lang('phone') . ': ' . $user['phone'] . ')');
        }
        return $data;
    }

    function getPatientinfoWithAddNewOption($searchTerm, $id_organisation)
    {
        if (!empty($searchTerm)) {
            // $this->db->select('*');
            // $this->db->where("name like '%" . $searchTerm . "%' ");
            // $this->db->or_where("id like '%" . $searchTerm . "%' ");
            // $this->db->where('id_organisation', $id_organisation);
            // $fetched_records = $this->db->get('patient');
            $query = $this->db->query("select * from patient where (name like '" . $searchTerm . "%' or last_name like '" . $searchTerm . "%' or patient_id like '%" . $searchTerm . "%') AND id_organisation = " . $id_organisation);
            $users = $query->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('id_organisation', $id_organisation);
            // $this->db->where("name like '%".$searchTerm."%' ");
            //  $this->db->or_where("id like '%".$searchTerm."%' ");
            $this->db->limit(10);
            $fetched_records = $this->db->get('patient');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        $data[] = array("id" => 'add_new', "text" => lang('add_new'));
        foreach ($users as $user) {
            // $data[] = array("id" => $user['id'], "text" => $user['name'] . ' ' . $user['last_name'] . ' (' . lang('phone') . ': ' . $user['phone'] . ')');
            $data[] = array("id" => $user['id'], "text" => $user['name'] . ' ' . $user['last_name'] . ' (Code Patient: ' . $user['patient_id'] . ')');
        }
        return $data;
    }

    function getPatientinfoWithAddNewOptionLab($searchTerm, $id_organisation)
    {
        if (!empty($searchTerm)) {
            $query = $this->db->query("select * from patient where (name like '%" . $searchTerm . "%' or patient_id like '%" . $searchTerm . "%') AND id_organisation = " . $id_organisation);
            // $this->db->select('*');
            // $array = array('name like ' => $name, 'id <' => $id, 'date >' => $date);
            // $this->db->where($array); 
            // $this->db->where("name like '%" . $searchTerm . "%' ");
            // $this->db->or_where("id like '%" . $searchTerm . "%' ");
            // $this->db->where('id_organisation', $id_organisation);
            // $fetched_records = $this->db->get('patient');
            // $users = $fetched_records->result_array();
            $users = $query->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('id_organisation', $id_organisation);
            // $this->db->where("name like '%".$searchTerm."%' ");
            //  $this->db->or_where("id like '%".$searchTerm."%' ");
            $this->db->limit(10);
            $fetched_records = $this->db->get('patient');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        // $data[] = array("id" => 'add_new', "text" => lang('add_new'));
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['name'] . ' ' . $user['last_name'] . ' (Code Patient: ' . $user['patient_id'] . ')');
        }
        return $data;
    }

    function getPatientinfoWithAddNewOptionByMutuelle($searchTerm, $id, $id_organisation)
    {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where("name like '%" . $searchTerm . "%' ");
            //$this->db->or_where("id like '%" . $searchTerm . "%' ");
            $this->db->or_where("id != " . $id . " ");
            $this->db->where('id_organisation', $id_organisation);
            $fetched_records = $this->db->get('patient');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            // $this->db->where("name like '%".$searchTerm."%' ");
            //  $this->db->or_where("id like '%".$searchTerm."%' ");
            $this->db->or_where("id != " . $id . " ");
            $this->db->where('id_organisation', $id_organisation);
            $this->db->limit(10);
            $fetched_records = $this->db->get('patient');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        // $data[] = array("id" => 'add_new', "text" => lang('add_new'));
        foreach ($users as $user) {
            $data[] = array(
                "id" => $user['id'] . '*' . $user['name'] . '*' . $user['last_name'] . '*' . $user['phone'] . '*' . $user['birthdate'] . '*' . $user['sex'] . '*',
                "text" => $user['name'] . ' ' . $user['last_name'] . ' (' . lang('phone') . ': ' . $user['phone'] . ')'
            );
        }
        return $data;
    }

    function getMutuelleInfo($searchTerm, $id_organisation)
    {

        if (!empty($searchTerm)) {
            // $this->db->select('*');
            $this->db->select('organisation.id as id, organisation.nom as nom');
            $this->db->from('organisation');
            $this->db->join('partenariat_sante_assurance', 'organisation.id = partenariat_sante_assurance.id_organisation_assurance', 'left');
            $this->db->where("organisation.nom like '%" . $searchTerm . "%' ");
            $this->db->where('organisation.est_active', 1);
            $type_array = array('Assurance', 'IPM');
            // $this->db->where('organisation.type', "Assurance");
            $this->db->where_in('organisation.type', $type_array);
            $this->db->where('partenariat_sante_assurance.id_organisation_sante', $id_organisation);
            $fetched_records = $this->db->get();
            $users = $fetched_records->result();
        } else {
            $this->db->select('organisation.id as id, organisation.nom as nom');
            $this->db->from('organisation');
            $this->db->join('partenariat_sante_assurance', 'organisation.id = partenariat_sante_assurance.id_organisation_assurance', 'left');
            $this->db->where('organisation.est_active', 1);
            $type_array = array('Assurance', 'IPM');
            // $this->db->where('organisation.type', "Assurance");
            $this->db->where_in('organisation.type', $type_array);
            $this->db->where('partenariat_sante_assurance.id_organisation_sante', $id_organisation);
            $this->db->limit(10);
            $fetched_records = $this->db->get();
            $users = $fetched_records->result();
        }
        // Initialize Array with fetched data
        $data = array();

        foreach ($users as $user) {
            $data[] = array("id" => $user->id, "text" => $user->nom);
        }
        return $data;
    }

    function getMutuelleByPatient($id, $id_organisation)
    {
        $this->db->where('pm_idpatent', $id);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('patient_mutuelle');
        return $query->row();
    }

    function getMutuelle($id, $id_organisation)
    {
        $this->db->select('*');
        $this->db->from('patient_mutuelle');
        $this->db->join('organisation', 'organisation.id=patient_mutuelle.pm_idmutuelle', 'left');
        $this->db->where('patient_mutuelle.pm_idpatent', $id);
        $this->db->where('patient_mutuelle.pm_status', 1);
        // $this->db->where('patient_mutuelle.id_organisation', $id_organisation);
        $query = $this->db->get();
        return $query->row();

        /* $this->db->select('patient.date_valid as pm_datevalid, patient.charge_mutuelle as pm_charge,patient.num_police as pm_numpolice,'
          . 'patient.nom_mutuelle as idpm,organisation.nom as nom, patient.parent_id as pm_idpatent');
          $this->db->from('patient');
          $this->db->join('organisation', 'organisation.id=patient.nom_mutuelle', 'left');
          $this->db->where('patient.id', $id); */

        $query = $this->db->get();
        return $query->row();
    }

    function insertMutuellePatient($data)
    {
        $this->db->insert('patient_mutuelle', $data);
    }

    function insertPatientVaccination($data)
    {
        $this->db->insert('vaccination', $data);
    }
    

    function updateMutuellePatient($id, $data, $id_organisation)
    {
        $this->db->where('idpm', $id);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->update('patient_mutuelle', $data);
    }

    function deleteMutuellePatient($id, $id_organisation)
    {
        $this->db->where('idpm', $id);
        // $this->db->where('id_organisation', $id_organisation);
        // $this->db->delete('patient_mutuelle');
        $this->db->update('patient_mutuelle', array('pm_status' => NULL));
    }

    function getPatientByIdParent($id, $id_organisation)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('parent_id', $id);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('patient');
        return $query->result();
    }

    function getOrganisation($id)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('id', $id);
        $query = $this->db->get('organisation');
        return $query->row();
    }

    function deleteMutuelleRelation($id, $id_organisation)
    {
        $this->db->where('id', $id);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->update('patient', array('lien_parente' => NULL, 'parent_id' => NULL));
    }

    function addNewMpatient($id, $data, $id_organisation)
    {
        $this->db->where('id', $id);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->update('patient', $data);
    }

    function getPaymentById($id, $id_organisation)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $id);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('payment');
        return $query->result();
    }

    function getPhoneUniqueByJason($searchTerm, $patient)
    {
        $users = array();
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where('phone', $searchTerm);
            $fetched_records = $this->db->get('patient');
            $users = $fetched_records->result_array();
        }
        //var_dump($users);  var_dump(count($users));
        $result = false;
        if (count($users) > 0) {
            if ($patient) {
                if ($users[0]['id'] != $patient) {
                    $result = true;
                }
            } else {
                $result = true;
            }
        }
        return $result;
    }


    function addRendezVousByConsultation($id, $id_organisation)
    {
        $this->db->select('medical_history.title,medical_history.description,medical_history.poids, medical_history.taille, medical_history.temperature,
        medical_history.frequenceRespiratoire,medical_history.frequenceCardiaque,medical_history.glycemyCapillaire,
        medical_history.systolique,medical_history.diastolique,medical_history.tensionArterielle,medical_history.Saturationarterielle,medical_history.SaturationVeineux,
        medical_history.HypertensionSystolique,medical_history.HypertensionDiastolique,
        medical_history.date as dateCreate,organisation.nom, users.first_name,users.last_name,groups.label_fr  ');
        $this->db->from('medical_history');
        $this->db->join('organisation', 'organisation.id=medical_history.id_organisation', 'left');
        $this->db->join('users', 'users.id=medical_history.user', 'left');
        $this->db->join('users_groups', 'users_groups.user_id=users.id', 'left');
        $this->db->join('groups', 'groups.id=users_groups.group_id', 'left');
        $this->db->where('medical_history.id_organisation', $id_organisation);
        $this->db->where('medical_history.patient_id', $id);
        $query = $this->db->get();

        $dataTab = $query->result();
        $resulr = array();
        foreach ($dataTab as $key => $value) {


            $html = '<div class="card"><div class="card-header" id="heading' . $key . '"><h5 class="mb-0"><div class="btn_ btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse' . $key . '" aria-expanded="true" aria-controls="collapse' . $key . '">';
            $html .= '<span class="col-md-12" > <i class=""></i><i class="fa  fa-file mr-3"></i>   <span class="titlecons" >' . lang('consultation_medical') . '</span></span>';
            $html .= '<span class="col-md-12" >  <span class=" str1 pull-left" >';
            $html .= $value->nom . '<br/>';
            $html .= date('d/m/Y', $value->dateCreate);
            $html .= '</span><span class=" str2 pull-right" >';
            $html .= 'Dr ' . $value->first_name . ' ' . $value->last_name . '<br/>';
            $html .= $value->label_fr . '<br/>';
            $html .= '</span></span></div> </h5></div>';

            $html .= '<div id="collapse' . $key . '" class="collapse  fade" aria-labelledby="heading' . $key . '" data-parent="#accordionExample">';
            $html .= '<div class="card-body">';

            $html .= '<div class="row">';
            $html .=  '<div class="form-group col-md-4">';
            $html .=   '<label>Poids (kg)</label>';
            $html .=     '<div>' . $value->poids . '</div>';
            $html .= '</div>';

            $html .= '<div class="form-group col-md-4">';
            $html .=   '<label>Taille (cm)</label>';
            $html .=    '<div>' . $value->taille . '</div>';
            $html .=  '</div>';
            $html .=  '<div class="form-group col-md-4">';
            $html .=    '<label>Température (°C)</label>';
            $html .=    '<div>' . $value->temperature . '</div>';
            $html .=    '</div>';
            $html .=  '</div>';
            $html .= '<hr>';
            $html .=  '<div class="row">';
            $html .=   '<div class="form-group col-md-3">';
            $html .=    '<label>Fréquence Respiratoire (mn)</label>';
            $html .=   '<div>' . $value->frequenceRespiratoire . '</div>';
            $html .= '</div>';
            $html .=  '<div class="form-group col-md-3">';
            $html .=    '<label>Fréquence Cardiaque (bpm)</label>';
            $html .=     '<div>' . $value->frequenceCardiaque . '</div>';
            $html .= '</div>';
            $html .= '<div class="form-group col-md-3">';
            $html .=     '<label>Glycémie Capillaire (mmol/L)</label>';
            $html .=    '<div>' . $value->glycemyCapillaire . '</div>';
            $html .=  '</div>';
            $html .= '<div class="form-group col-md-3">';
            $html .= '<label>Saturation en O<sub>2</sub></label>';
            $html .=  '<div>' . $value->Saturationarterielle . '</div>';
            $html .= '</div>';
            $html .=  '</div>';
            $html .=   '<hr>';
            $html .=   '<div class="row">';
            $html .=  '<div class="form-group col-md-12">';
            $html .=    '<label>Tension Artérielle</label>';
            $html .=  '</div>';
            $html .=    '<div class="form-group col-md-4">';
            $html .=    '<label>T. Systolique (mmHg)</label>';
            $html .=  '<div>' . $value->systolique . '</div>';
            $html .=   '<div>' . $value->HypertensionSystolique . '</div>';
            $html .= '</div>';
            $html .= '<div class="form-group col-md-4">';
            $html .=   '<label>T. Diastolique (mmHg)</label>';
            $html .=   '<div>' . $value->diastolique . '</div>';
            $html .=   '<div>' . $value->HypertensionDiastolique . '</div>';
            $html .=  '</div>';
            $html .= '<div class="form-group col-md-4">';
            $html .=   '<label>Résultat</label>';
            $html .=   '<div>' . $value->tensionArterielle . '</div>';
            $html .=   '</div>';
            $html .=   '</div>';
            $html .=   '<hr>';
            $html .= '</div> <span class="col-md-12 pull-left" ><strong>Observation Médicale : </strong> <br>';
            $html .= $value->description;
            $html .= '</span></div></div></div>';
            $datee = $value->dateCreate;
            $resulr[] = array('date' => $datee, 'html' => $html);
        }
        return $resulr;
    }

    function addConsultationByConsultation($id, $id_organisation)
    {
        $this->db->select('medical_history.title,medical_history.description,medical_history.poids, medical_history.taille, medical_history.temperature,
        medical_history.sucre, medical_history.albumine, medical_history.oeildroit, medical_history.oeilgauche, medical_history.oreilledroite, medical_history.oreillegauche,
        medical_history.frequenceRespiratoire,medical_history.frequenceCardiaque,medical_history.glycemyCapillaire,
        medical_history.systolique,medical_history.diastolique,medical_history.tensionArterielle,medical_history.Saturationarterielle,medical_history.SaturationVeineux,
        medical_history.HypertensionSystolique,medical_history.HypertensionDiastolique,
        medical_history.date as dateCreate,organisation.nom, users.first_name,users.last_name,groups.label_fr, illness.affection');
        $this->db->from('medical_history');
        $this->db->join('organisation', 'organisation.id=medical_history.id_organisation', 'left');
        $this->db->join('users', 'users.id=medical_history.user', 'left');
        $this->db->join('users_groups', 'users_groups.user_id=users.id', 'left');
        $this->db->join('groups', 'groups.id=users_groups.group_id', 'left');
        $this->db->join('illness', 'illness.id=medical_history.illness_id', 'left');
        $this->db->where('medical_history.id_organisation', $id_organisation);
        $this->db->where('medical_history.patient_id', $id);
      
        $query = $this->db->get();

        $dataTab = $query->result();
        $resulr = array();
        foreach ($dataTab as $key => $value) {


            $html = '<div class="card"><div class="card-header" id="heading' . $key . '"><h5 class="mb-0"><div class="btn_ btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse' . $key . '" aria-expanded="true" aria-controls="collapse' . $key . '">';
            $html .= '<span class="col-md-12" > <i class=""></i><i class="fa  fa-file mr-3"></i>   <span class="titlecons" >' . lang('consultation_medical') . '</span></span>';
            $html .= '<span class="col-md-12" >  <span class=" str1 pull-left" >';
            $html .= $value->nom . '<br/>';
            $html .= date('d/m/Y', $value->dateCreate);
            $html .= '</span><span class=" str2 pull-right" >';
            $html .= 'Dr ' . $value->first_name . ' ' . $value->last_name . '<br/>';
            $html .= $value->label_fr . '<br/>';
            $html .= '</span></span></div> </h5></div>';

            $html .= '<div id="collapse' . $key . '" class="collapse  fade" aria-labelledby="heading' . $key . '" data-parent="#accordionExample">';
            $html .= '<div class="card-body">';

            $html .= '<div class="row">';
            $html .=  '<div class="form-group col-md-4">';
            $html .=   '<label>Poids (kg)</label>';
            $html .=     '<div>' . $value->poids . '</div>';
            $html .= '</div>';

            $html .= '<div class="form-group col-md-4">';
            $html .=   '<label>Taille (cm)</label>';
            $html .=    '<div>' . $value->taille . '</div>';
            $html .=  '</div>';
            $html .=  '<div class="form-group col-md-4">';
            $html .=    '<label>Température (°C)</label>';
            $html .=    '<div>' . $value->temperature . '</div>';
            $html .=    '</div>';
            $html .=  '</div>';
            $html .= '<hr>';
            $html .=  '<div class="row">';
            $html .=   '<div class="form-group col-md-3">';
            $html .=    '<label>Fréquence Respiratoire (mn)</label>';
            $html .=   '<div>' . $value->frequenceRespiratoire . '</div>';
            $html .= '</div>';
            $html .=  '<div class="form-group col-md-3">';
            $html .=    '<label>Fréquence Cardiaque (bpm)</label>';
            $html .=     '<div>' . $value->frequenceCardiaque . '</div>';
            $html .= '</div>';
            $html .= '<div class="form-group col-md-3">';
            $html .=     '<label>Glycémie Capillaire (mmol/L)</label>';
            $html .=    '<div>' . $value->glycemyCapillaire . '</div>';
            $html .=  '</div>';
            $html .= '<div class="form-group col-md-3">';
            $html .= '<label>Saturation en O<sub>2</sub></label>';
            $html .=  '<div>' . $value->Saturationarterielle . '</div>';
            $html .= '</div>';
            $html .=  '</div>';
            $html .=   '<hr>';
            $html .=   '<div class="row">';
            $html .=  '<div class="form-group col-md-12">';
            $html .=    '<label>Tension Artérielle</label>';
            $html .=  '</div>';
            $html .=    '<div class="form-group col-md-4">';
            $html .=    '<label>T. Systolique (mmHg)</label>';
            $html .=  '<div>' . $value->systolique . '</div>';
         //   $html .=   '<div>' . $value->HypertensionSystolique . '</div>';
            $html .= '</div>';
            $html .= '<div class="form-group col-md-4">';
            $html .=   '<label>T. Diastolique (mmHg)</label>';
            $html .=   '<div>' . $value->diastolique . '</div>';
          //  $html .=   '<div>' . $value->HypertensionDiastolique . '</div>';
            $html .=  '</div>';
            $html .= '<div class="form-group col-md-4">';
            $html .=   '<label>Résultat</label>';
            $html .=   '<div>' . $value->tensionArterielle . '</div>';
            $html .=   '</div>';
            $html .=   '</div>';
            // $html .=   '<hr>';
            // $html .=   '<div class="row">';
            // $html .=  '<div class="form-group col-md-12">';
            // $html .=    '<label>Urines</label>';
            // $html .=  '</div>';
            // $html .=    '<div class="form-group col-md-4">';
            // $html .=    '<label>Sucre</label>';
            // $html .=  '<div>' . $value->sucre . '</div>';
            // $html .= '</div>';
            // $html .= '<div class="form-group col-md-4">';
            // $html .=   '<label>Albumine</label>';
            // $html .=   '<div>' . $value->albumine . '</div>';
            // $html .=  '</div>';
            // $html .=  '</div>';
            // $html .=   '<hr>';
            // $html .=   '<div class="row">';
            // $html .=  '<div class="form-group col-md-12">';
            // $html .=    '<label>Acuite Visuelle</label>';
            // $html .=  '</div>';
            // $html .=    '<div class="form-group col-md-4">';
            // $html .=    '<label>Oeil droit</label>';
            // $html .=  '<div>' . $value->oeildroit . '</div>';
            // $html .= '</div>';
            // $html .= '<div class="form-group col-md-4">';
            // $html .=   '<label>Oeil gauche</label>';
            // $html .=   '<div>' . $value->oeilgauche . '</div>';
            // $html .=  '</div>';
            // $html .=  '</div>';
            // $html .=   '<hr>';
            // $html .=   '<div class="row">';
            // $html .=  '<div class="form-group col-md-12">';
            // $html .=    '<label>Acuite Auditive</label>';
            // $html .=  '</div>';
            // $html .=    '<div class="form-group col-md-4">';
            // $html .=    '<label>Oreille droite</label>';
            // $html .=  '<div>' . $value->oreilledroite . '</div>';
            // $html .= '</div>';
            // $html .= '<div class="form-group col-md-4">';
            // $html .=   '<label>Oreille gauche</label>';
            // $html .=   '<div>' . $value->oreillegauche . '</div>';
            // $html .=  '</div>';
            // $html .=  '</div>';
            $html .=   '<hr>';
            $html .= '<div class="form-group col-md-12">';
            $html .=   '<label>Conclusion</label>';
            $html .=   '<div>' . $value->affection . '</div>';
            $html .=   '</div>';
            $html .=   '<hr>';
            $html .= '</div> <span class="col-md-12 pull-left" ><strong>Observation Médicale : </strong> <br>';
            $html .= $value->description;
            $html .= '</span></div></div></div>';
            $datee = $value->dateCreate;
            $resulr[] = array('date' => $datee, 'html' => $html);
        }
        return $resulr;
    }

    function addConsultationByLab($id, $id_organisation)
    {
        $this->db->select('lab.report,lab.date as dateCreate,organisation.nom, users.first_name,users.last_name,groups.label_fr  ');
        $this->db->from('lab');
        $this->db->join('organisation', 'organisation.id=lab.id_organisation', 'left');
        $this->db->join('users', 'users.id=lab.user', 'left');
        $this->db->join('users_groups', 'users_groups.user_id=users.id', 'left');
        $this->db->join('groups', 'groups.id=users_groups.group_id', 'left');
        $this->db->where('lab.id_organisation', $id_organisation);
        $this->db->like('lab.consultation', '0', 'before');
        $this->db->like('lab.importLabo', 'analyse', 'before');
        $this->db->where('lab.patient', $id);
        
        $query = $this->db->get();

        $dataTab = $query->result();
        $resulr = array();
        foreach ($dataTab as $key => $value) {
            $key = 'cons' . $key;

            $html = '<div class="card"><div class="card-header" id="heading' . $key . '"><h5 class="mb-0"><div class="btn_ btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse' . $key . '" aria-expanded="true" aria-controls="collapse' . $key . '">';
            $html .= '<span class="col-md-12" > <i class=""></i><i class="fa  fa-flask mr-3"></i>   <span class="titlecons" >Analyse Laboratoire</span></span>';
            $html .= '<span class="col-md-12" >  <span class=" str1 pull-left" >';
            $html .= $value->nom . '<br/>';
            $html .= date('d/m/Y', $value->dateCreate);
            $html .= '</span><span class=" str2 pull-right" >';
            $html .= $value->first_name . ' ' . $value->last_name . '<br/>';
            $html .= $value->label_fr . '<br/>';
            $html .= '</span></span></div> </h5></div>';

            $html .= '<div id="collapse' . $key . '" class="collapse  fade" aria-labelledby="heading' . $key . '" data-parent="#accordionExample"><div class="card-body">';
            $html .= $value->report;
            $html .= '</div></div></div>';
            $datee = $value->dateCreate;
            $resulr[] = array('date' => $datee, 'html' => $html);
        }
        return $resulr;
    }


    function addBultinByLab($id, $id_organisation)
    {
        $this->db->select('lab.report,lab.date as dateCreate,organisation.nom, users.first_name,users.last_name,groups.label_fr  ');
        $this->db->from('lab');
        $this->db->join('organisation', 'organisation.id=lab.id_organisation', 'left');
        $this->db->join('users', 'users.id=lab.user', 'left');
        $this->db->join('users_groups', 'users_groups.user_id=users.id', 'left');
        $this->db->join('groups', 'groups.id=users_groups.group_id', 'left');
        $this->db->where('lab.id_organisation', $id_organisation);
        $this->db->like('lab.consultation', '1', 'before');
        $this->db->where('lab.patient', $id);
        
        $query = $this->db->get();

        $dataTab = $query->result();
        $resulr = array();
        foreach ($dataTab as $key => $value) {
            $key = 'cons' . $key;

            $html = '<div class="card"><div class="card-header" id="heading' . $key . '"><h5 class="mb-0"><div class="btn_ btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse' . $key . '" aria-expanded="true" aria-controls="collapse' . $key . '">';
            $html .= '<span class="col-md-12" > <i class=""></i><i class="fa  fa-flask mr-3"></i>   <span class="titlecons" >Demande Analyse</span></span>';
            $html .= '<span class="col-md-12" >  <span class=" str1 pull-left" >';
            $html .= $value->nom . '<br/>';
            $html .= date('d/m/Y', $value->dateCreate);
            $html .= '</span><span class=" str2 pull-right" >';
            $html .= $value->first_name . ' ' . $value->last_name . '<br/>';
            $html .= $value->label_fr . '<br/>';
            $html .= '</span></span></div> </h5></div>';

            $html .= '<div id="collapse' . $key . '" class="collapse  fade" aria-labelledby="heading' . $key . '" data-parent="#accordionExample"><div class="card-body">';
            $html .= $value->report;
            $html .= '</div></div></div>';
            $datee = $value->dateCreate;
            $resulr[] = array('date' => $datee, 'html' => $html);
        }
        return $resulr;
    }
    
    function addImagerieByLab($id, $id_organisation)
    {
        $this->db->select('lab.report,lab.date as dateCreate,organisation.nom, users.first_name,users.last_name,groups.label_fr  ');
        $this->db->from('lab');
        $this->db->join('organisation', 'organisation.id=lab.id_organisation', 'left');
        $this->db->join('users', 'users.id=lab.user', 'left');
        $this->db->join('users_groups', 'users_groups.user_id=users.id', 'left');
        $this->db->join('groups', 'groups.id=users_groups.group_id', 'left');
        $this->db->where('lab.id_organisation', $id_organisation);
        $this->db->like('lab.consultation', '2', 'before');
        $this->db->where('lab.patient', $id);
        
        $query = $this->db->get();

        $dataTab = $query->result();
        $resulr = array();
        foreach ($dataTab as $key => $value) {
            $key = 'cons' . $key;

            $html = '<div class="card"><div class="card-header" id="heading' . $key . '"><h5 class="mb-0"><div class="btn_ btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse' . $key . '" aria-expanded="true" aria-controls="collapse' . $key . '">';
            $html .= '<span class="col-md-12" > <i class=""></i><i class="fa  fa-flask mr-3"></i>   <span class="titlecons" >Demande Radio</span></span>';
            $html .= '<span class="col-md-12" >  <span class=" str1 pull-left" >';
            $html .= $value->nom . '<br/>';
            $html .= date('d/m/Y', $value->dateCreate);
            $html .= '</span><span class=" str2 pull-right" >';
            $html .= $value->first_name . ' ' . $value->last_name . '<br/>';
            $html .= $value->label_fr . '<br/>';
            $html .= '</span></span></div> </h5></div>';

            $html .= '<div id="collapse' . $key . '" class="collapse  fade" aria-labelledby="heading' . $key . '" data-parent="#accordionExample"><div class="card-body">';
            $html .= $value->report;
            $html .= '</div></div></div>';
            $datee = $value->dateCreate;
            $resulr[] = array('date' => $datee, 'html' => $html);
        }
        return $resulr;
    }


    function addConsultationRDVByLab($id, $id_organisation)
    {
        $this->db->select('appointment.code,appointment.date,appointment.s_time, appointment.e_time, appointment.add_date, appointment.status, appointment.patientname,appointment.servicename,
        organisation.nom, users.first_name,users.last_name,groups.label_fr,appointment.remarks');
        $this->db->from('appointment');
        $this->db->join('organisation', 'organisation.id=appointment.id_organisation', 'left');
        $this->db->join('users', 'users.id=appointment.user', 'left');
        $this->db->join('users_groups', 'users_groups.user_id=users.id', 'left');
        $this->db->join('groups', 'groups.id=users_groups.group_id', 'left');
        $this->db->where('appointment.id_organisation', $id_organisation);
        $this->db->where('appointment.patient', $id);
        $query = $this->db->get();
        
        $dataTab = $query->result();
        $resulr = array();
        foreach ($dataTab as $key => $value) {
            $key = 'cons' . $key;

            if ($value->status == 'Pending Confirmation') {
                $value->status = '<span class="status-p bg-warning">' . lang('pending_confirmation') . '</span>';
            } elseif ($value->status == 'Confirmed') {
                $value->status = '<span class="status-p bg-success">' . lang('confirmed') . '</span>';
            } elseif ($value->status == 'Treated') {
                $value->status = '<span class="status-p bg-primary">' . lang('treated') . '</span>';
            } elseif ($value->status == 'Cancelled') {
                $value->status = '<span class="status-p bg-danger">' . lang('cancelled') . '</span>';
            }

            

            $html = '<div class="card"><div class="card-header" id="heading' . $key . '"><h5 class="mb-0"><div class="btn_ btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse' . $key . '" aria-expanded="true" aria-controls="collapse' . $key . '">';
            $html .= '<span class="col-md-12" > <i class=""></i><i class="fa fa-calendar mr-3" aria-hidden="true"></i>   <span class="titlecons" >Rendez-vous</span></span>';
            $html .= '<span class="col-md-12" >  <span class=" str1 pull-left" >';
            $html .= $value->nom . '<br/>';
            $html .= date('d/m/Y', $value->date);
            $html .= '</span><span class=" str2 pull-right" >';
            $html .= $value->first_name . ' ' . $value->last_name . '<br/>';
            $html .= $value->label_fr . '<br/>';
            $html .= '</span></span></div> </h5></div>';

            $html .= '<div id="collapse' . $key . '" class="collapse  fade" aria-labelledby="heading' . $key . '" data-parent="#accordionExample"><div class="card-body">';

            $html .= '<div class="row">';
            $html .=  '<div class="form-group col-md-3">';
            $html .=   '<label>Date</label>';
            $html .=     '<div>' . date('d/m/Y', $value->date) . '</div>';
            $html .= '</div>';

            $html .= '<div class="form-group col-md-3">';
            $html .=   '<label>Créneau Horaire</label>';
            $html .=    '<div>' . $value->s_time . ' ' . $value->e_time . '</div>';
            $html .=  '</div>';
            $html .=  '<div class="form-group col-md-3">';
            $html .=    '<label>Service</label>';
            $html .=    '<div>' . $value->servicename. '</div>';
            $html .=    '</div>';
            $html .=  '<div class="form-group col-md-3">';
            $html .=    '<label>Statut</label>';
            $html .=    '<div>' . $value->status . '</div>';
            $html .=    '</div>';
            $html .=  '</div>';
            $html .= '<hr>';
            $html .= '<div class="row">';
            $html .=  '<div class="form-group col-md-12">';
            $html .=   '<label>Remarque</label>';
            $html .=     '<div>' . $value->remarks . '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div></div></div>';
            $datee = $value->date;
            $resulr[] = array('date' => $datee, 'html' => $html);
        }
        return $resulr;
    }

    function addConsultationActeByLab($id, $id_organisation)
    {
        $this->db->select('appointment.code,appointment.date,appointment.s_time, appointment.e_time, appointment.add_date, appointment.status, appointment.patientname,appointment.servicename,
        organisation.nom, users.first_name,users.last_name,groups.label_fr,appointment.remarks');
        $this->db->from('appointment');
        $this->db->join('organisation', 'organisation.id=appointment.id_organisation', 'left');
        $this->db->join('users', 'users.id=appointment.user', 'left');
        $this->db->join('users_groups', 'users_groups.user_id=users.id', 'left');
        $this->db->join('groups', 'groups.id=users_groups.group_id', 'left');
        $this->db->where('appointment.id_organisation', $id_organisation);
        $this->db->where('appointment.patient', $id);
        $query = $this->db->get();
        
        $dataTab = $query->result();
        $resulr = array();
        foreach ($dataTab as $key => $value) {
            $key = 'cons' . $key;

            if ($value->status == 'Pending Confirmation') {
                $value->status = '<span class="status-p bg-warning">' . lang('pending_confirmation') . '</span>';
            } elseif ($value->status == 'Confirmed') {
                $value->status = '<span class="status-p bg-success">' . lang('confirmed') . '</span>';
            } elseif ($value->status == 'Treated') {
                $value->status = '<span class="status-p bg-primary">' . lang('treated') . '</span>';
            } elseif ($value->status == 'Cancelled') {
                $value->status = '<span class="status-p bg-danger">' . lang('cancelled') . '</span>';
            }

            

            $html = '<div class="card"><div class="card-header" id="heading' . $key . '"><h5 class="mb-0"><div class="btn_ btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse' . $key . '" aria-expanded="true" aria-controls="collapse' . $key . '">';
            $html .= '<span class="col-md-12" > <i class=""></i><i class="fa fa-calendar mr-3" aria-hidden="true"></i>   <span class="titlecons" >Rendez-vous</span></span>';
            $html .= '<span class="col-md-12" >  <span class=" str1 pull-left" >';
            $html .= $value->nom . '<br/>';
            $html .= date('d/m/Y', $value->date);
            $html .= '</span><span class=" str2 pull-right" >';
            $html .= $value->first_name . ' ' . $value->last_name . '<br/>';
            $html .= $value->label_fr . '<br/>';
            $html .= '</span></span></div> </h5></div>';

            $html .= '<div id="collapse' . $key . '" class="collapse  fade" aria-labelledby="heading' . $key . '" data-parent="#accordionExample"><div class="card-body">';

            $html .= '<div class="row">';
            $html .=  '<div class="form-group col-md-3">';
            $html .=   '<label>Date</label>';
            $html .=     '<div>' . date('d/m/Y', $value->date) . '</div>';
            $html .= '</div>';

            $html .= '<div class="form-group col-md-3">';
            $html .=   '<label>Créneau Horaire</label>';
            $html .=    '<div>' . $value->s_time . ' ' . $value->e_time . '</div>';
            $html .=  '</div>';
            $html .=  '<div class="form-group col-md-3">';
            $html .=    '<label>Service</label>';
            $html .=    '<div>' . $value->servicename. '</div>';
            $html .=    '</div>';
            $html .=  '<div class="form-group col-md-3">';
            $html .=    '<label>Statut</label>';
            $html .=    '<div>' . $value->status . '</div>';
            $html .=    '</div>';
            $html .=  '</div>';
            $html .= '<hr>';
            $html .= '<div class="row">';
            $html .=  '<div class="form-group col-md-12">';
            $html .=   '<label>Remarque</label>';
            $html .=     '<div>' . $value->remarks . '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div></div></div>';
            $datee = $value->date;
            $resulr[] = array('date' => $datee, 'html' => $html);
        }
        return $resulr;
    }

	function getTablePatientBySearch($search, $id_organisation)
	{
		$this->db->order_by('id', 'desc');
		$this->db->like('id', $search);
		$this->db->or_like('name', $search);
		$this->db->or_like('status', 1);
		$this->db->where('id_organisation', $id_organisation);
		$query = $this->db->get('patient');
		return $query->result();
	}

	function getTablePatientByLimit($limit, $start, $id_organisation)
	{
		$this->db->order_by('id', 'desc');
		$this->db->limit($limit, $start);
		$this->db->like('status', 1);
		$this->db->where('id_organisation', $id_organisation);
		$query = $this->db->get('patient');
		return $query->result();
	}

	function getTablePatientByLimitBySearch($limit, $start, $search, $id_organisation)
	{

		$this->db->like('id', $search);

		$this->db->order_by('id', 'desc');

		$this->db->or_like('name', $search);
		$this->db->or_like('phone', $search);
		$this->db->or_like('address', $search);
		$this->db->or_like('status', 1);
		$this->db->where('id_organisation', $id_organisation);
		$this->db->limit($limit, $start);
		$query = $this->db->get('patient');
		return $query->result();
	}

    function addHospitalIdToIonUser($data) {
        $this->db->insert('patient_hospital', $data);
    }

    function insertHospital($data) {
        $this->db->insert('hospital', $data);
    }

    function getHospital() {
        $query = $this->db->get('hospital');
        return $query->result();
    }

    function getHospitalById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('hospital');
        return $query->row();
    }

    function updateHospital($id, $data) {

        $this->db->where('id', $id);
        $this->db->update('hospital', $data);
    }

    function updateHospitalByIonId($id, $data) {
        $this->db->where('ion_user_id', $id);
        $this->db->update('hospital', $data);
    }

    function activate($id, $data) {
        $this->db->where('id', $id);
        $this->db->or_where('hospital_ion_id', $id);
        $this->db->update('users', $data);
    }

    function deactivate($id, $data) {
        $this->db->where('hospital_ion_id', $id);
        $this->db->or_where('id', $id);
        $this->db->update('users', $data);
    }

   

    function getHospitalId($current_user_id) {
        $group_id = $this->db->get_where('users_groups', array('user_id' => $current_user_id))->row()->group_id;
        $group_name = $this->db->get_where('groups', array('id' => $group_id))->row()->name;
        $group_name = strtolower($group_name);
        $hospital_id = $this->db->get_where($group_name, array('ion_user_id' => $current_user_id))->row()->hospital_id;
        return $hospital_id;
    }
}
