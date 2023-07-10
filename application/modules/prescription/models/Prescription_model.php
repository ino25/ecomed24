<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prescription_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertPrescription($data) {
        $this->db->insert('prescription', $data);
    }

    function insertTransferPrescription($data) {
        $this->db->insert('transfer_prescription', $data);
    }
  function updateTransferPrescription($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('transfer_prescription', $data);
    }
    function getPrescription($id_organisation) {
        $this->db->where('id_organisation', $id_organisation);
        $this->db->or_where('organisation_destinataire', $id_organisation);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('prescription');
        return $query->result();
    }

    function getPrescriptionById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('prescription');
        return $query->row();
    }

    function getPrescriptionByPatientId($patient_id) {
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $patient_id);
        $query = $this->db->get('prescription');
        return $query->result();
    }

    function getPrescriptionByDoctorId($doctor_id) {
        $this->db->order_by('id', 'desc');
        $this->db->where('doctor', $doctor_id);
        $query = $this->db->get('prescription');
        return $query->result();
    }

    function updatePrescription($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('prescription', $data);
    }

    function deletePrescription($id) {
        $this->db->where('id', $id);
        $this->db->delete('prescription');
    }

    function getPrescriptionBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);
        $query = $this->db->get('prescription');
        return $query->result();
    }

    function getPrescriptionByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('prescription');
        return $query->result();
    }

    function getPrescriptionByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('prescription');
        return $query->result();
    }

    //-----------------------------------------
	function getTransferedPrescription() {
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('transfer_prescription');
		return $query->result();
	}
    function getTransferedPrescriptionBySearchByPharmacist($pharmacist, $search) {
        $this->db->order_by('id', 'desc');
        $this->db->where('pharmacist', $pharmacist);
        $this->db->like('id', $search);
        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);
        $query = $this->db->get('transfer_prescription');
        return $query->result();
    }

    function getTransferedPrescriptionByPharmacist($pharmacist) {
        $this->db->order_by('id', 'desc');
        $this->db->where('pharmacist', $pharmacist);
        $query = $this->db->get('transfer_prescription');
        return $query->result();
    }

    function getTransferedPrescriptionByLimitBySearchByPharmacist($pharmacist,$limit, $start, $search) {

        $this->db->like('id', $search);
        $this->db->where('pharmacist', $pharmacist);
        $this->db->order_by('id', 'desc');

        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('transfer_prescription');
        return $query->result();
    }

    function getTransferedPrescriptionByLimitByPharmacist($pharmacist,$limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->where('pharmacist', $pharmacist);
        $this->db->limit($limit, $start);
        $query = $this->db->get('transfer_prescription');
        return $query->result();
    }

//-------------------------------------------
    function getTransferedPrescriptionBySearchByDoctor($doctor, $search) {
        $this->db->order_by('id', 'desc');
        $this->db->where('doctor', $doctor);
        $this->db->like('id', $search);
        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);
        $query = $this->db->get('transfer_prescription');
        return $query->result();
    }

    function getTransferedPrescriptionByDoctor($doctor) {
        $this->db->order_by('id', 'desc');
        $this->db->where('doctor', $doctor);
        $query = $this->db->get('transfer_prescription');
        return $query->result();
    }

    function getTransferedPrescriptionByLimitBySearchByDoctor($doctor, $limit, $start, $search) {

        $this->db->like('id', $search);
        $this->db->where('doctor', $doctor);
        $this->db->order_by('id', 'desc');

        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('transfer_prescription');
        return $query->result();
    }

    function getTransferedPrescriptionByLimitByDoctor($doctor, $limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->where('doctor', $doctor);
        $this->db->limit($limit, $start);
        $query = $this->db->get('transfer_prescription');
        return $query->result();
    }

    //----------------------------------
    //----------------------------------
    function getPrescriptionByDoctor($doctor_id) {
        $this->db->order_by('id', 'desc');
        $this->db->where('doctor', $doctor_id);
        $query = $this->db->get('prescription');
        return $query->result();
    }

    function getPrescriptionBySearchByDoctor($doctor, $search) {
        $this->db->order_by('id', 'desc');
        $this->db->where('doctor', $doctor);
        $this->db->like('id', $search);
        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);
        $query = $this->db->get('prescription');
        return $query->result();
    }

    function getPrescriptionByLimitByDoctor($doctor, $limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->where('doctor', $doctor);
        $this->db->limit($limit, $start);
        $query = $this->db->get('prescription');
        return $query->result();
    }

    function getPrescriptionByLimitBySearchByDoctor($doctor, $limit, $start, $search) {

        $this->db->like('id', $search);
        $this->db->where('doctor', $doctor);
        $this->db->order_by('id', 'desc');

        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('prescription');
        return $query->result();
    }

    function getUserById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        return $query->row();
    }

}
