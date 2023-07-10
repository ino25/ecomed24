<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Poste_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertPoste($data) {
        $table = 'setting_poste';  
        $this->db->insert($table, $data);
    }

    function getPoste($id = null) {
        $table = 'setting_poste';
        $setting_service = 'setting_service';
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join($setting_service, $setting_service . '.idservice=' . $table . '.id_service', 'left');
        if ($id) {
            $this->db->where($setting_service . '.idservice', $id);
        }
        //$this->db->like($setting_service . '.status_service', 1);

        $this->db->where($table.'.status_poste', 1);
        $this->db->order_by($setting_service . '.idservice', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getPosteById($id) {
        $table = 'setting_poste';
        $this->db->where('idposte', $id);
        $query = $this->db->get($table);
        return $query->row();
    }

    function updatePoste($id, $data) {
        $table =  'setting_poste';
        $this->db->where('idposte', $id);
        $this->db->update($table, $data);
    }

    function delete($id) {
        $table = 'setting_poste';
        $this->db->where('idposte', $id);
        //$this->db->delete($table);
        $this->db->update($table, array('status_poste' => NULL));
    }
 function editposteByservice($id) {
        $table ='setting_poste';
        $this->db->where('id_service', $id);
        $query = $this->db->get($table);
        return $query->result();
    }
}
