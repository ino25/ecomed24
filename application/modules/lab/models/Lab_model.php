<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lab_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertLab($data) {
        $this->db->insert('lab', $data);
    }

    function insertLabData($data) {
        $this->db->insert('lab_data', $data);
    }

    function updateLabData($id_lab_data, $data) {
        $this->db->where('id', $id_lab_data);
        $this->db->update('lab_data', $data);
    }

    function getLab() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('lab');
        return $query->result();
    }

    function getLabDataByLab($id_lab) {
        $this->db->order_by('id', 'asc');
        $this->db->where('id_lab', $id_lab);
        $query = $this->db->get('lab_data');
        return $query->result();
    }

    function getPrestationLabDefaultValues($id_prestation) {
        $this->db->order_by('id', 'desc');
        $this->db->limit(1, 0);
        $this->db->where('id_prestation', $id_prestation);
        $query = $this->db->get('prestation_lab_default_values');
        return $query->row();
    }

    function getLabByOrganisation($id_organisation, $orderColumn, $orderDirection) {
        // $this->db->order_by('id', 'desc');
        $this->db->order_by($orderColumn, $orderDirection);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('lab');
        return $query->result();
    }

    function getLabBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('patient_name', $search);
        $this->db->or_like('patient_phone', $search);
        $this->db->or_like('patient_address', $search);
        $this->db->or_like('doctor_name', $search);
        $this->db->or_like('date_string', $search);
        $query = $this->db->get('lab');
        return $query->result();
    }

    function getLabByOrganisationBySearch($id_organisation, $search, $orderColumn, $orderDirection) {
        // $this->db->order_by('id', 'desc');
        // $this->db->order_by($orderColumn, $orderDirection);
        // $this->db->like('id', $search);
        // $this->db->or_like('code', $search);
        // $this->db->or_like('patient_name', $search);
        // $this->db->or_like('patient_phone', $search);
        // $this->db->or_like('patient_address', $search);
        // $this->db->or_like('doctor_name', $search);
        // $this->db->or_like('date_string', $search);
        // $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->query("select lab.* from lab where (id like '%" . $search . "%' or code like '%" . $search . "%' or patient_name like '%" . $search . "%' or patient_phone like '%" . $search . "%' or patient_address like '%" . $search . "%' or date_string like '%" . $search . "%') and id_organisation = " . $id_organisation . " order by " . $orderColumn . " " . $orderDirection);
        // $query = $this->db->get('lab');
        return $query->result();
    }

    function getLabByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('lab');
        return $query->result();
    }

    function getLabByOrganisationByLimit($id_organisation, $limit, $start, $orderColumn, $orderDirection) {
        $this->db->order_by($orderColumn, $orderDirection);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->limit($limit, $start);
        $query = $this->db->get('lab');
        return $query->result();
    }

    function getLabByLimitBySearch($limit, $start, $search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('patient_name', $search);
        $this->db->or_like('patient_phone', $search);
        $this->db->or_like('patient_address', $search);
        $this->db->or_like('doctor_name', $search);
        $this->db->or_like('date_string', $search);
        $this->db->limit($limit, $start);
        $query = $this->db->get('lab');
        return $query->result();
    }

    function getLabByOrganisationByLimitBySearch($id_organisation, $limit, $start, $search, $orderColumn, $orderDirection) {
        // $this->db->order_by('id', 'desc');
        // $this->db->order_by($orderColumn, $orderDirection);
        // $this->db->like('id', $search);
        // $this->db->or_like('code', $search);
        // $this->db->or_like('patient_name', $search);
        // $this->db->or_like('patient_phone', $search);
        // $this->db->or_like('patient_address', $search);
        // $this->db->or_like('doctor_name', $search);
        // $this->db->or_like('date_string', $search);
        // $this->db->where('id_organisation', $id_organisation);
        // $this->db->limit($limit, $start);

        $query = $this->db->query("select lab.* from lab where (id like '%" . $search . "%' or code like '%" . $search . "%' or patient_name like '%" . $search . "%' or patient_phone like '%" . $search . "%' or patient_address like '%" . $search . "%' or date_string like '%" . $search . "%') and id_organisation = " . $id_organisation . " order by " . $orderColumn . " " . $orderDirection . " limit " . $start . ", " . $limit);
        // $query = $this->db->get('lab');
        return $query->result();
    }

    function getLabById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('lab');
        return $query->row();
    }

 

    function getLabByIdAnalyse($id) {
        $query = $this->db->query("select lab.id, lab.numero_demande, lab.category, lab.patient, lab.payment, lab.demendeur, lab.doctor, lab.date, lab.category_name, lab.report, lab.report_pro, lab.status, lab.user, lab.patient_name, lab.patient_phone, lab.patient_address, lab.doctor_name, lab.date_string, lab.id_organisation, lab.code, lab.consultation, lab.numeroRegistre, lab.idPayement, lab.prescripteur, lab.nomLabo, lab.url, lab.importLabo from lab join patient on patient.id = lab.patient AND patient.id = " . $id . " where importLabo like 'analyse' order by lab.id desc");
        // var_dump($query);
        // exit();
        return $query->result();
    }

    function getLabByPatientId($id) {
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $id);
        $query = $this->db->get('lab');
        return $query->result();
    }

    function getLabByPatientAnalyseId($id) {
        $query = $this->db->query("select lab.id, lab.numero_demande, lab.category, lab.patient, lab.payment, lab.demendeur, lab.doctor, lab.date, lab.category_name, lab.report, lab.report_pro, lab.status, lab.user, lab.patient_name, lab.patient_phone, lab.patient_address, lab.doctor_name, lab.date_string, lab.id_organisation, lab.code, lab.consultation, lab.numeroRegistre, lab.idPayement, lab.prescripteur, lab.nomLabo, lab.url, lab.importLabo from lab join patient on patient.id = lab.patient AND patient.id = " . $id . " where importLabo like '1' or importLabo like 'analyse' order by lab.id desc");
        // var_dump($query);
        // exit();
        return $query->result();
    }

  


    function getLabByPatientImagerieId($id) {
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $id);
        $this->db->where('importLabo', '2');
        $query = $this->db->get('lab');
        return $query->result();
    }


    function getLabByPatientOrdonnanceId($id) {
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $id);
        $this->db->where('importLabo', '3');
        $query = $this->db->get('lab');
        return $query->result();
    }

    // function getLabByPatientAnalyseId($id, $id_organisation) {
    //     $this->db->select('*');
    //     $this->db->from('lab');
    //     $this->db->join('organisation', 'organisation.id=lab.id_organisation', 'left');
    //     $this->db->join('users', 'users.id=lab.user', 'left');
    //     $this->db->join('users_groups', 'users_groups.user_id=users.id', 'left');
    //     $this->db->join('groups', 'groups.id=users_groups.group_id', 'left');
    //     $this->db->where('lab.id_organisation', $id_organisation);
    //     $this->db->like('lab.consultation', '0', 'before');
    //     $this->db->where('lab.patient', $id);
    //     $query = $this->db->get('lab');
    //     return $query->result();
    // }

    function getLabByPatientIdByDate($id, $date_from, $date_to) {
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $id);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get('lab');
        return $query->result();
    }

    function getLabByUserId($id) {
        $this->db->order_by('id', 'desc');
        $this->db->where('user', $id);
        $query = $this->db->get('lab');
        return $query->result();
    }

    function getOtLabByPatientId($id) {
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $id);
        $query = $this->db->get('ot_lab');
        return $query->result();
    }

    function getLabByPatientIdByStatus($id) {
        $this->db->where('patient', $id);
        $this->db->where('status', 'unpaid');
        $query = $this->db->get('lab');
        return $query->result();
    }

    function updateLab($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('lab', $data);
    }

    function insertLabCategory($data) {

        $this->db->insert('lab_category', $data);
    }

    function insertUpdatePrestationLabDefaultValues($data) {
        // Check s'il existe
        $num_rows = $this->db->get_where('prestation_lab_default_values', array('id_prestation =' => $data->id_prestation))->num_rows();
        if ($num_rows) { // Update si existant
            $this->db->query("select id from prestation_lab_default_values where id_prestation=" . $data->id_prestation);
            $id = $query->row()->id;
            $this->db->query("update prestation_lab_default_values set default_unite = " . $data->default_unite . ", default_valeurs=" . $data->default_valeurs . " where id = " . $id);
        } else { // Insert sinon
            $this->db->insert('prestation_lab_default_values', $data);
        }
    }

    function getLabCategory() {
        $query = $this->db->get('lab_category');
        return $query->result();
    }

    function getLabCategoryById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('lab_category');
        return $query->row();
    }

    function updateLabCategory($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('lab_category', $data);
    }

    function deleteLab($id) {
        $this->db->where('id', $id);
        $this->db->delete('lab');
    }

    function deleteLabCategory($id) {
        $this->db->where('id', $id);
        $this->db->delete('lab_category');
    }

    function getLabByDoctor($doctor) {
        $this->db->select('*');
        $this->db->from('lab');
        $this->db->where('doctor', $doctor);
        $query = $this->db->get();
        return $query->result();
    }

    function getLabByDate($date_from, $date_to) {
        $this->db->select('*');
        $this->db->from('lab');
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $query->result();
    }

    function getLabByDoctorDate($doctor, $date_from, $date_to) {
        $this->db->select('*');
        $this->db->from('lab');
        $this->db->where('doctor', $doctor);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $query->result();
    }

    function getLabByUserIdByDate($user, $date_from, $date_to) {
        $this->db->order_by('id', 'desc');
        $this->db->select('*');
        $this->db->from('lab');
        $this->db->where('user', $user);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $query->result();
    }

    function insertTemplate($data) {
        $this->db->insert('template', $data);
    }

    function getTemplate() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('template');
        return $query->result();
    }

    function getTemplateMultiConsultation() {
        $this->db->order_by('id', 'desc');
        $this->db->where('type', 'consultation');
        $query = $this->db->get('template');
        return $query->result();
    }

    function getTemplateMultiConsultationDefault() {
        $this->db->order_by('id', 'desc');
        $this->db->where('type', 'consultation');
        $this->db->where('id', '51');
        $query = $this->db->get('template');
        return $query->result();
    }

    function getTemplateLabo() {
        $this->db->order_by('id', 'desc');
        $this->db->where('type', 'labo');
        $query = $this->db->get('template');
        return $query->result();
    }

    function getTemplateConsultation() {
        $this->db->order_by('id', 'desc');
        $this->db->where('type', 'consultation');
        $query = $this->db->get('template');
        return $query->result();
    }

    function updateTemplate($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('template', $data);
    }

    function getTemplateById($id) {
        $this->db->where('id', $id);    
        $this->db->where('type', 'consultation');
        $query = $this->db->get('template');
        return $query->row();
    }

    

    function deletetemplate($id) {
        $this->db->where('id', $id);
        $this->db->delete('template');
    }

    function getSericeinfoByJason($searchTerm) {
        $table = 'setting_service';
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where("name_service like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get($table);
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->limit(10);
            $fetched_records = $this->db->get($table);
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['idservice'], "text" => $user['name_service']);
        }
        return $data;
    }

    function getPatientinfoWithAddNewOption($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where("name like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('patient');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
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
            $data[] = array("id" => $user['id'], "text" => $user['name'] . ' ' . $user['last_name'] . ' (' . lang('phone') . ': ' . $user['phone'] . ')');
        }
        return $data;
    }

    function updateLabDataPaiement($id_lab_data, $payment, $data) {
        $this->db->where('id_para', $id_lab_data);
        $this->db->where('id_payment', $payment);
        $this->db->update('lab_data', $data);
    }
    
     function updateLabDataPaiement2($id_lab_data, $payment, $data) {
        $this->db->where('id_prestation', $id_lab_data);
        $this->db->where('id_payment', $payment);
        $this->db->update('lab_data', $data);
    }
     function updateLabByPayment($payment,$data) {
        $this->db->where('payment', $payment);
        $this->db->update('lab', $data);
    }
    function getLabByPayment($payment) {
        $this->db->where('payment', $payment);
         $query = $this->db->get('lab');
        return $query->row();
    }


    function insertMasterLabTest($data) {
        return $this->db->insert('master_lab_test', $data);
    }

    function addParameter($data) {
        return $this->db->insert('master_parameter_lab_test', $data);
    }

    function getMasterLabBySearch($search) {
        $this->db->order_by('id', 'desc');

        $this->db->like('id', $search);
        $this->db->or_like('speciality', $search);
        $this->db->or_like('name', $search);

        $this->db->or_like('description', $search);
        $query = $this->db->get('master_lab_test');
        return $query->result();
    }

    function getMasterLabByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('speciality', $search);
        $this->db->or_like('name', $search);

        $this->db->or_like('description', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('master_lab_test');
        return $query->result();
    }

    function getMasterLabByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);
        $query = $this->db->get('master_lab_test');
        return $query->result();
    }

    function getMasterLab() {
        $this->db->order_by('id', 'asc');
//        $this->db->where('status', 'Active');
        $query = $this->db->get('master_lab_test');
        return $query->result();
    }

    function getParameterByLabTest($test_id) {
        return $this->db->where('test_id', $test_id)->get('master_parameter_lab_test')->result();
    }

    function getParameterId($id) {
        return $this->db->where('id', $id)->get('master_parameter_lab_test')->row();
    }

    function deleteParameter($id) {
        $this->db->where('id', $id);
        return $this->db->delete('master_parameter_lab_test');
    }

    function deleteMasterLabTest($id) {
        $this->db->where('id', $id);
        $this->db->delete('master_lab_test');
    }

    function getMasterLabById($id) {
        return $this->db->where('id', $id)->get('master_lab_test')->row();
    }

    function updateMasterLabTest($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('master_lab_test', $data);
    }

    function getMasterLabTestByIdByName($id, $parameter) {
        return $this->db->where('test_id', $id)->where('parameter_name', $parameter)->get('master_parameter_lab_test')->result();
    }

    function getMasterLabTestById($id) {

        $this->db->where('id', $id);
        $query = $this->db->get('master_lab_test');
        return $query->row();
    }

    function getMasterLabTestByName($id) {

        $this->db->where('name', $id);
        $query = $this->db->get('master_lab_test');
        return $query->row();
    }

    function insertLabTest($data) {
        $this->db->insert('lab_test', $data);
    }

    function getImportedLabBySearch($organisation, $search) {
        $this->db->order_by('id', 'desc');

        $this->db->like('id', $search);
        $this->db->or_like('speciality', $search);
        $this->db->or_like('name', $search);

        $this->db->or_like('description', $search);
        $this->db->where('id_organisation', $organisation);
        $query = $this->db->get('lab_test');
        return $query->result();
    }

    function getImportedLabByLimitBySearch($organisation, $limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('speciality', $search);
        $this->db->or_like('name', $search);

        $this->db->or_like('description', $search);

        $this->db->limit($limit, $start);
        $this->db->where('id_organisation', $organisation);
        $query = $this->db->get('lab_test');
        return $query->result();
    }

    function getImportedLabByLimit($organisation, $limit, $start) {
        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);
        $this->db->where('id_organisation', $organisation);
        $query = $this->db->get('lab_test');
        return $query->result();
    }

    function getImportedLab($organisation) {
        $this->db->order_by('id', 'asc');
//        $this->db->where('status', 'Active');
        $this->db->where('id_organisation', $organisation);
        $query = $this->db->get('lab_test');
        return $query->result();
    }

    function updateImportedLabTest($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('lab_test', $data);
    }

    function getLabTestImportedById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('lab_test');
        return $query->row();
    }

    function deleteImportedLabTest($id) {
        $this->db->where('id', $id);
        $this->db->delete('lab_test');
    }

    function insertRequestMasterLabTest($data) {
        return $this->db->insert('request_lab_test', $data);
    }

    function getRequestedMasterLabBySearch($search) {
        $this->db->order_by('id', 'desc');

        $this->db->like('id', $search);
        $this->db->or_like('speciality', $search);
        $this->db->or_like('name', $search);

        $this->db->or_like('description', $search);
        $query = $this->db->get('request_lab_test');
        return $query->result();
    }

    function getRequestedMasterLabByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('speciality', $search);
        $this->db->or_like('name', $search);

        $this->db->or_like('description', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('request_lab_test');
        return $query->result();
    }

    function getRequestedMasterLabByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);
        $query = $this->db->get('request_lab_test');
        return $query->result();
    }

    function getRequestedMasterLab() {
        $this->db->order_by('id', 'asc');
//        $this->db->where('status', 'Active');
        $query = $this->db->get('request_lab_test');
        return $query->result();
    }

    function getRequestedMasterLabBySearchByOrganisation($organisation, $search) {
        $this->db->order_by('id', 'desc');

        $this->db->like('id', $search);
        $this->db->or_like('speciality', $search);
        $this->db->or_like('name', $search);

        $this->db->or_like('description', $search);
        $this->db->where('id_organisation', $organisation);
        $query = $this->db->get('request_lab_test');
        return $query->result();
    }

    function getRequestedMasterLabByLimitBySearchByOrganisation($organisation, $limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('speciality', $search);
        $this->db->or_like('name', $search);

        $this->db->or_like('description', $search);

        $this->db->limit($limit, $start);
        $this->db->where('id_organisation', $organisation);
        $query = $this->db->get('request_lab_test');
        return $query->result();
    }

    function getRequestedMasterLabByLimitByOrganisation($organisation, $limit, $start) {
        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);
        $this->db->where('id_organisation', $organisation);
        $query = $this->db->get('request_lab_test');
        return $query->result();
    }

    function getRequestedMasterLabByOrganisation($organisation) {
        $this->db->order_by('id', 'asc');
        $this->db->where('id_organisation', $organisation);
        $query = $this->db->get('request_lab_test');
        return $query->result();
    }

    function getRequestedMasterLabTestById($id) {
        return $this->db->where('id', $id)->get('request_lab_test')->row();
    }

    function getParameterByRequestedLabTest($test_id) {
        return $this->db->where('request_test_id', $test_id)->get('master_parameter_lab_test')->result();
    }

    function deleteRequestedMasterLabTest($id) {
        $this->db->where('id', $id);
        $this->db->delete('request_lab_test');
    }

    function updateRequestedLabTest($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('request_lab_test', $data);
    }

    function updateParameterLabTest($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('master_parameter_lab_test', $data);
    }

    function getMasterLabInfo($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where('status', 'active');
            $this->db->where("speciality like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $this->db->or_where("name like '%" . $searchTerm . "%' ");
            $this->db->or_where("description like '%" . $searchTerm . "%' ");

            $fetched_records = $this->db->get('master_lab_test');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('status', 'active');
            $this->db->limit(10);
            $fetched_records = $this->db->get('master_lab_test');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'] . '*' . $user['name'] . '*' . $user['speciality'], "text" => $user['name']);
        }
        return $data;
    }

    function getLabInfo($organisation, $searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where('status', 'active');
            $this->db->where('id_organisation', $organisation);
            $this->db->where("speciality like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $this->db->or_where("name like '%" . $searchTerm . "%' ");
            $this->db->or_where("description like '%" . $searchTerm . "%' ");

            $fetched_records = $this->db->get('lab_test');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('status', 'active');
            $this->db->where('id_organisation', $organisation);
            $this->db->limit(10);
            $fetched_records = $this->db->get('lab_test');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['name']);
        }
        return $data;
    }

    function getPrestationsLabOrganisationByJson($id_organisation, $id, $payment_id) {
        if (empty($payment_id)) {
            return $this->db->where('id', $id)->where('status', 'active')->get('lab_test')->result();
        } else {
            return $this->db->where('id_organisation', $id_organisation)->where('status', 'active')->get('lab_test')->result();
        }
    }

    function getMasterLabByOrganisation($organisation, $id, $search) {

        $this->db->like('id', $search);

        $this->db->or_like('name', $search);

        $this->db->where('id_organisation', $organisation);
        $query = $this->db->get('lab_test');
        return $query->result();
    }

    function getTypeSampling() {
        return $this->db->get('sampling')->result();
    }

    function getConclusion() {
        return $this->db->get('conclusion')->result();
    }

    function insertConclusion($data) {
        $this->db->insert('conclusion', $data);
    }

    function insertSampling($data) {
        $this->db->insert('sampling', $data);
    }


    function insertReport($data) {
        $this->db->insert('lab_report', $data);
    }

    function getReportbyId($id) {
        return $this->db->where('id', $id)->get('lab_report')->row();
    }

    function getReportPaymentbyId($id) {
        return $this->db->where('payment', $id)->get('lab_report')->row();
    }

    function updateLabReport($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('lab_report', $data);
    }


   

    function getLabReportByPaymentByLabId($payment_id, $lab_id) {
        return $this->db->where('lab_id', $lab_id)->where('payment', $payment_id)->get('lab_report')->row();
    }


    function getLabReportByPaymentId($payment_id) {
        return $this->db->where('payment', $payment_id)->get('lab_report')->row();
        
    }


    
}
