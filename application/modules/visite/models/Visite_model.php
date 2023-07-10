<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Visite_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertVisite($data) {
      $pp =   $this->db->insert('visite', $data);
    }

      function getVisite($id_organisation) {
       $this->db->select('*');
            $this->db->from('visite');
            $this->db->join('patient', 'patient.id = visite.patient', 'left');
            $this->db->where('visite.id_organisation', $id_organisation);
            $this->db->order_by('idv', 'desc');
            $fetched_records = $this->db->get();
            $users = $fetched_records->result();
            return $users;
      }

      function getConsultation($id_organisation) {
        $this->db->select('*');
             $this->db->from('visite');
             $this->db->join('patient', 'patient.id = visite.patient', 'left');
             $this->db->where('visite.id_organisation', $id_organisation);
             $this->db->where('visite.type', 'consultation');
             $this->db->order_by('idv', 'desc');
             $fetched_records = $this->db->get();
             $users = $fetched_records->result();
             return $users;
       }

      function getVisiteById($id) {
        $this->db->where('idv', $id);
        $query = $this->db->get('visite');
        return $query->row();
    }
}
