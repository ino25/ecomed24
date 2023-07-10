<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Whatsapp_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    

    function getAutoWhatsappTemplate() {
        $this->db->order_by('id', 'asc');
		$this->db->where('status', "Active");
        $query = $this->db->get('autowhatsapptemplate');
        return $query->result();
    }

    function getAutoWhatsappTemplateBySearch($search) {
        // $this->db->order_by('id', 'asc');
        // $this->db->like('id', $search);
        // $this->db->or_like('message', $search);
		$query = $this->db->query("select * from autowhatsapptemplate where (id like '%".$search."%' or message like '%".$search."%') AND status = 'Active' order by id asc");
        // $query = $this->db->get('autowhatsapptemplate');
        return $query->result();
    }

    function getAutoWhatsappTemplateByLimit($limit, $start) {
        $this->db->order_by('id', 'asc');
		$this->db->where('status', "Active");
        $this->db->limit($limit, $start);
        $query = $this->db->get('autowhatsapptemplate');
        return $query->result();
    }

    function getAutoWhatsappTemplateByLimitBySearch($limit, $start, $search) {

        // $this->db->like('id', $search);
        // $this->db->order_by('id', 'asc');
        // $this->db->or_like('message', $search);
        // $this->db->limit($limit, $start);
        // $query = $this->db->get('autowhatsapptemplate');
		$this->db->select('*');
        $this->db->where("message like '%" . $search . "%' ");
        $this->db->or_where("id like '%" . $search . "%' ");
        $this->db->where('status', 'Active');
        $this->db->limit($limit, $start);
        $query = $this->db->get('autowhatsapptemplate');
        return $query->result();
    }

    function getAutoWhatsappTemplateById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('autowhatsapptemplate');
        return $query->row();
    }

    function getAutoWhatsappTemplateTag($type) {
        $this->db->order_by('id', 'desc');
        $this->db->where('type', $type);
        $query = $this->db->get('autowhatsappshortcode');
        return $query->result();
    }

    function updateAutoWhatsappTemplate($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('autowhatsapptemplate', $data);
    }

   

    function getAutoWhatsappByType($type) {

        $this->db->where('type', $type);
        $query = $this->db->get('autowhatsapptemplate');
        return $query->row();
    }
    
}