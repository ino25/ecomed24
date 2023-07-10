<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Medicine_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertMedicine($data) {
        $this->db->insert('medicine', $data);
    }

    function insertRequestMedicine($data) {
        $this->db->insert('request_medicine', $data);
    }

    function updateRequestMedicine($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('request_medicine', $data);
    }

    function getRequestMedicineById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('request_medicine');
        return $query->row();
    }

    function deleteRequestMedicine($id) {
        $this->db->where('id', $id);
        $this->db->delete('request_medicine');
    }

    function getMedicine() {
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getLatestMedicine() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getMedicineLimitByNumber($number) {
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('medicine', $number);
        return $query->result();
    }

    function getMedicineByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('medicine', 50, $data_range_1);
        return $query->result();
    }

    function getMedicineByStockAlert() {
        $this->db->where('quantity <=', 20);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getMedicineByStockAlertByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->where('quantity <=', 20);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('medicine', 50, $data_range_1);
        return $query->result();
    }

    function getMedicineById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('medicine');
        return $query->row();
    }

    function getMedicineByKeyByStockAlert($page_number, $key) {
        $data_range_1 = 50 * $page_number;

        $this->db->where('quantity <=', 20);
        $this->db->or_like('name', $key);
        $this->db->or_like('company', $key);

        $this->db->order_by('id', 'asc');
        $query = $this->db->get('medicine', 50, $data_range_1);
        return $query->result();
    }

    function getMedicineByKey($page_number, $key) {
        $data_range_1 = 50 * $page_number;
        $this->db->like('name', $key);
        $this->db->or_like('company', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('medicine', 50, $data_range_1);
        return $query->result();
    }

    function getMedicineByKeyForPos($key) {
        $this->db->like('name', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function updateMedicine($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('medicine', $data);
    }

//---------------------------------
    function insertMasterMedicine($data) {
        $this->db->insert('master_medicine', $data);
    }

    function insertMasterMedicinee($data2) {
        $this->db->insert('master_medicine', $data2);
    }

    function getMasterMedicine() {
        $this->db->order_by('id', 'asc');
//        $this->db->where('status', 'Active');
        $query = $this->db->get('master_medicine');
        return $query->result();
    }

    function getMasterMedicineById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('master_medicine');
        return $query->row();
    }

    function updateMasterMedicine($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('master_medicine', $data);
    }

    function deleteMasterMedicine($id) {
        $this->db->where('id', $id);
        $this->db->delete('master_medicine');
    }

    //----------------------------------
    function insertMedicineCategory($data) {

        $this->db->insert('medicine_category', $data);
    }

    function getMedicineCategory() {
        $query = $this->db->get('medicine_category');
        return $query->result();
    }

    function getMedicineCategoryById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('medicine_category');
        return $query->row();
    }

    function getMedicineCategoryByName($id) {
        $this->db->where('category', $id);
        $query = $this->db->get('medicine_category');
        return $query->result();
    }

//---------------------------
    function insertMedicineType($data) {

        $this->db->insert('medicine_type', $data);
    }

    function getMedicineType() {
        $query = $this->db->get('medicine_type');
        return $query->result();
    }

    function getMedicineTypeById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('medicine_type');
        return $query->row();
    }

    function updateMedicineType($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('medicine_type', $data);
    }

    function deleteMedicineType($id) {
        $this->db->where('id', $id);
        $this->db->delete('medicine_type');
    }

    function getMedicineTypeByName($id) {
        $this->db->where('type', $id);
        $query = $this->db->get('medicine_type');
        return $query->result();
    }

    //---------------------
    function totalStockPrice() {
        $query = $this->db->get('medicine')->result();
        $stock_price = array();
        foreach ($query as $medicine) {
            $stock_price[] = $medicine->price * $medicine->quantity;
        }

        if (!empty($stock_price)) {
            return array_sum($stock_price);
        } else {
            return 0;
        }
    }

    function updateMedicineCategory($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('medicine_category', $data);
    }

    function deleteMedicine($id) {
        $this->db->where('id', $id);
        $this->db->delete('medicine');
    }

    function deleteMedicineCategory($id) {
        $this->db->where('id', $id);
        $this->db->delete('medicine_category');
    }

    //----------------------------------------
    function getMasterMedicineBySearch($search) {
        $this->db->order_by('id', 'desc');
//        $this->db->where('status', 'Active');
        $this->db->like('id', $search);
        $this->db->or_like('category', $search);
        $this->db->or_like('name', $search);

        $this->db->or_like('description', $search);
        $query = $this->db->get('master_medicine');
        return $query->result();
    }

    function getMasterMedicineByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);
//        $this->db->where('status', 'Active');
        $this->db->order_by('id', 'desc');

        $this->db->or_like('category', $search);
        $this->db->or_like('name', $search);

        $this->db->or_like('description', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('master_medicine');
        return $query->result();
    }

    function getMasterMedicineByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
//        $this->db->where('status', 'Active');
        $this->db->limit($limit, $start);
        $query = $this->db->get('master_medicine');
        return $query->result();
    }

    //-------------------------------------
    function getMasterMedicineBySearchByPharmacist($search) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Active');
        $this->db->like('id', $search);
        $this->db->or_like('category', $search);
        $this->db->or_like('name', $search);

        $this->db->or_like('description', $search);
        $query = $this->db->get('master_medicine');
        return $query->result();
    }

    function getMasterMedicineByPharmacist() {
        $this->db->order_by('id', 'asc');
        $this->db->where('status', 'Active');
        $query = $this->db->get('master_medicine');
        return $query->result();
    }

    function getMasterMedicineByLimitBySearchByPharmacist($limit, $start, $search) {

        $this->db->like('id', $search);
        $this->db->where('status', 'Active');
        $this->db->order_by('id', 'desc');

        $this->db->or_like('category', $search);
        $this->db->or_like('name', $search);

        $this->db->or_like('description', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('master_medicine');
        return $query->result();
    }

    function getMasterMedicineByLimitByPharmacist($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Active');
        $this->db->limit($limit, $start);
        $query = $this->db->get('master_medicine');
        return $query->result();
    }

    //-------------------------------------
    function getRequestMedicineByPharmacistSearch($id_organisation, $search) {
        $this->db->order_by('id', 'desc');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->like('id', $search);
        $this->db->or_like('category', $search);
        $this->db->or_like('name', $search);
//        $this->db->or_like('e_date', $search);
        $this->db->or_like('generic', $search);
        $this->db->or_like('company', $search);

        $query = $this->db->get('request_medicine');
        return $query->result();
    }

    function getRequestMedicineByPharmacist($id_organisation) {
        $this->db->order_by('id', 'asc');
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('request_medicine');
        return $query->result();
    }

    function getRequestMedicineByPharmacistLimitBySearch($id_organisation, $limit, $start, $search) {

        $this->db->like('id', $search);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->order_by('id', 'desc');

        $this->db->or_like('category', $search);
        $this->db->or_like('name', $search);
//        $this->db->or_like('e_date', $search);
        $this->db->or_like('generic', $search);
        $this->db->or_like('company', $search);
//        $this->db->or_like('effects', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('request_medicine');
        return $query->result();
    }

    function getRequestMedicineByPharmacistLimit($id_organisation, $limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->limit($limit, $start);
        $query = $this->db->get('request_medicine');
        return $query->result();
    }

    //------------------------------------
    function getMedicineByPharmacistSearch($id_organisation, $search) {
        $this->db->order_by('id', 'desc');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->like('id', $search);
        $this->db->or_like('category', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('e_date', $search);
        $this->db->or_like('generic', $search);
        $this->db->or_like('company', $search);

        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getMedicineByPharmacist($id_organisation) {
        $this->db->order_by('id', 'asc');
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getMedicineByPharmacistLimitBySearch($id_organisation, $limit, $start, $search) {

        $this->db->like('id', $search);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->order_by('id', 'desc');

        $this->db->or_like('category', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('e_date', $search);
        $this->db->or_like('generic', $search);
        $this->db->or_like('company', $search);
//        $this->db->or_like('effects', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getMedicineByPharmacistLimit($id_organisation, $limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->limit($limit, $start);
        $query = $this->db->get('medicine');
        return $query->result();
    }

//-------------------------------------
    function getRequestMedicineBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('category', $search);
        $this->db->or_like('name', $search);
//        $this->db->or_like('e_date', $search);
        $this->db->or_like('generic', $search);
        $this->db->or_like('company', $search);
//        $this->db->or_like('effects', $search);
        $query = $this->db->get('request_medicine');
        return $query->result();
    }

    function getRequestMedicine() {
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('request_medicine');
        return $query->result();
    }

    function getRequestMedicineByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('category', $search);
        $this->db->or_like('name', $search);
//        $this->db->or_like('e_date', $search);
        $this->db->or_like('generic', $search);
        $this->db->or_like('company', $search);
//        $this->db->or_like('effects', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('request_medicine');
        return $query->result();
    }

    function getRequestMedicineByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('request_medicine');
        return $query->result();
    }

    function getMedicineBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('category', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('e_date', $search);
        $this->db->or_like('generic', $search);
        $this->db->or_like('company', $search);
        $this->db->or_like('effects', $search);
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getMedicineByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getMedicineByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('category', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('e_date', $search);
        $this->db->or_like('generic', $search);
        $this->db->or_like('company', $search);
        $this->db->or_like('effects', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('medicine');
        return $query->result();
    }

    function getMedicineNameByAvailablity($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where('status', 'Active');
            $this->db->where("name like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('master_medicine');
            $query = $fetched_records->result();
        } else {
            $this->db->select('*');
            $this->db->limit(10);
            $this->db->where('status', 'Active');
            $fetched_records = $this->db->get('master_medicine');
            $query = $fetched_records->result();
        }

        return $query;
    }

    function getMedicineInfo($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            //   $this->db->where('quantity >', '0');
             $this->db->where('status', 'Active');
            $this->db->where("name like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $this->db->or_where("category like '%" . $searchTerm . "%' ");
            $this->db->or_where("company like '%" . $searchTerm . "%' ");
            $this->db->or_where("description like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('master_medicine');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            // $this->db->where('quantity >', '0');
            $this->db->limit(10);
             $this->db->where('status', 'Active');
            $fetched_records = $this->db->get('master_medicine');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'] . '*' . $user['name'] . '*' . $user['dosage'], "text" => $user['name'].' '.$user['dosage'].' '.$user['type'] );
        }
        return $data;
    }

    function getMedicineInfoForPharmacySale($id_organisation, $searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where('id_organisation', $id_organisation);
//            $this->db->where('pharmacist_id', $pharmacist_id);
            $this->db->where('quantity >', '0');
            $this->db->where("name like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('medicine');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('id_organisation', $id_organisation);
//            $this->db->where('pharmacist_id', $pharmacist_id);
            $this->db->where('quantity >', '0');
            $this->db->limit(10);
            $fetched_records = $this->db->get('medicine');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'] . '*' . (float) $user['s_price'] . '*' . $user['name'] . '*' . $user['company'] . '*' . $user['quantity'], "text" => $user['name']);
        }
        return $data;
    }

    function getMedicineByImportedId($id, $organisation) {
        return $this->db->where('imported_id', $id)->where('id_organisation', $organisation)->get('medicine')->row();
    }

}
