<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Zuuluservice_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertDepartment($code, $data) {
        $table = $code . '_setting_department';
        $this->db->insert($table, $data);
    }

    function getDepartment($code) {
        $table = $code . '_setting_department';
        $query = $this->db->get($table);
        return $query->result();
    }

    function getDepartmentById($id, $code) {
        $this->db->where('iddepartment', $id);
        $table = $code . '_setting_department';
        $query = $this->db->get($table);
        return $query->row();
    }

     function getCode($id) {
         $code = '';
        $this->db->where('email', $id); 
        $table = 'users';
        $query = $this->db->get($table);
        $codeTab = $query->row();       
        if(is_object($codeTab)) {
          $code = $codeTab->compagny_code;
        } 
        return $code;
    }
    
    function updateDepartment($id, $code, $data) {
        $this->db->where('iddepartment', $id);
        $table = $code . '_setting_department';
        $this->db->update($table, $data);
    }

    function delete($id, $code) {
        $table = $code . '_setting_department';
        $this->db->where('iddepartment', $id);
        $this->db->delete($table);
    }

}
