<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mutuelle_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertMutuelle($code, $data) {
        $table = $code . '_insurance';
        $this->db->insert($table, $data);
    }

    function getMutuelle($code) {
        $table = $code . '_insurance';
        $this->db->where('status', 1);
        $query = $this->db->get($table);
        return $query->result();
    }

    function getMutuelleById($id, $code) {
        $table = $code . '_insurance';
        $this->db->where('id', $id);
        $query = $this->db->get($table);
        return $query->row();
    }

    function updateMutuelle($id, $code, $data) {
        $table = $code . '_insurance';
        $this->db->where('id', $id);
        $this->db->update($table, $data);
    }

    function delete($id, $code) {
        $table = $code . '_insurance';
        $this->db->where('id', $id);
        $this->db->update($table, array('status' => NULL));
    }

    function getMutuelleByJason($searchTerm, $code) {
        $table = $code . '_insurance';
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where("insurance_name like '%" . $searchTerm . "%' ");
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
            $data[] = array("id" => $user['id'] . '-' . $user['discount'], "text" => $user['insurance_name'] );
        }
        return $data;
    }

    function listeActeByJason($id, $code) {
        $table = $code . '_insurance';
        $acte_category = $code . '_acte_category';
        $result = array();
        $this->db->where('id', $id);
        //$this->db->or_where('status', 1);
        $query = $this->db->get($table);
        $tab = $query->row();
      
        $disease_charge = json_decode($tab->disease_charge);
       
        foreach ($disease_charge as $key => $value) {
            $this->db->where('id', $key);
            $query = $this->db->get($acte_category);
            $tabcategory = $query->row();
            $result[] = (object) array('id' => $tabcategory->id, 'category' => $tabcategory->category, 'price_public' => $tabcategory->price_public, 'charge' => $value);
        }
      // $result = (object) $result;  
     
        return $result;
    }

}
