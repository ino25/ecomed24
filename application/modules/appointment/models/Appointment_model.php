<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Appointment_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertAppointment($data) {

        $this->db->insert('appointment', $data);
       
    }

    function getAppointment($id_organisation, $id_serviceUser) {
        $this->db->order_by('id', 'desc');
        $this->db->where('id_organisation', $id_organisation);
        if($id_serviceUser) {
        $this->db->where('service', $id_serviceUser);
        }
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getAppointmentBySearch($search, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getAppointmentByLimit($limit, $start, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('appointment');
        return $query->result();
    }
    
    function getAppoinmentListByDate($id_organisation, $date) {
        $this->db->order_by('id', 'desc');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->where('date', $date);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getAppointmentByLimitBySearch($limit, $start, $search, $id_organisation) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);
$this->db->where('id_organisation', $id_organisation);
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getAppointmentForCalendar($id_organisation, $id_serviceUser) {
        $this->db->order_by('id', 'asc');
        $this->db->where('id_organisation', $id_organisation);
         if($id_serviceUser) {
        $this->db->where('service', $id_serviceUser);
        }
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getAppointmentByDoctor($doctor, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('doctor', $doctor);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getAppointmentRequest($id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('request', 'Yes');
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getAppointmentRequestByDoctor($doctor, $id_organisation) {
        $this->db->where('request', 'Yes');
        $this->db->where('doctor', $doctor);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getAppointmentByPatient($patient, $id_organisation,$id_serviceUser) {
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $patient);
        $this->db->where('id_organisation', $id_organisation);
          if($id_serviceUser) {
        $this->db->where('service', $id_serviceUser);
        }
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getAppointmentByStatus($status, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', $status);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getAppointmentByStatusByDoctor($status, $doctor, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', $status);
        $this->db->where('doctor', $doctor);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getAppointmentById($id, $id_organisation) {
        $this->db->where('id', $id);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('appointment');
        return $query->row();
    }

    function getAppointmentByDate($date_from, $date_to, $id_organisation) {
        $this->db->select('*');
        $this->db->from('appointment');
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get();
        return $query->result();
    }

    function getAppointmentByDoctorByToday($doctor_id, $id_organisation) {
        $today = strtotime(date('Y-m-d'));
        $this->db->where('doctor', $doctor_id);
        $this->db->where('date', $today);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function updateAppointment($id, $data, $id_organisation) {
        $this->db->where('id', $id);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->update('appointment', $data);
    }

    function delete($id, $id_organisation) {
        $this->db->where('id', $id);
        $this->db->where('id_organisation', $id_organisation);
       // $this->db->delete('appointment');
        $this->db->update('appointment', array('status' => 'Cancelled'));
    }

    function updateIonUser($username, $email, $password, $ion_user_id, $id_organisation) {
        $uptade_ion_user = array(
            'username' => $username,
            'email' => $email,
            'password' => $password
        );
        $this->db->where('id', $ion_user_id);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->update('users', $uptade_ion_user);
    }

    function getRequestAppointment($id_organisation,$id_serviceUser) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Requested');
        $this->db->where('id_organisation', $id_organisation);
         if($id_serviceUser) {
        $this->db->where('service', $id_serviceUser);
        }
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getRequestAppointmentBySearch($search, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Requested');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->like('id', $search);
        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getRequestAppointmentByLimit($limit, $start, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Requested');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getRequestAppointmentByLimitBySearch($limit, $start, $search, $id_organisation) {
        $this->db->where('status', 'Requested');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getPendingAppointment($id_organisation,$id_serviceUser) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Pending Confirmation');
        $this->db->where('id_organisation', $id_organisation);
         if($id_serviceUser) {
        $this->db->where('service', $id_serviceUser);
        }
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getPendingAppointmentBySearch($search, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Pending Confirmation');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->like('id', $search);
        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getPendingAppointmentByLimit($limit, $start, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Pending Confirmation');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getPendingAppointmentByLimitBySearch($limit, $start, $search, $id_organisation) {
        $this->db->where('status', 'Pending Confirmation');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getConfirmedAppointment($id_organisation,$id_serviceUser) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Confirmed');
        $this->db->where('id_organisation', $id_organisation);
         if($id_serviceUser) {
        $this->db->where('service', $id_serviceUser);
        }
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getConfirmedAppointmentBySearch($search, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Confirmed');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->like('id', $search);
        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getConfirmedAppointmentByLimit($limit, $start, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Confirmed');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getConfirmedAppointmentByLimitBySearch($limit, $start, $search, $id_organisation) {
        $this->db->where('status', 'Confirmed');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getTreatedAppointment($id_organisation,$id_serviceUser) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Treated');
        $this->db->where('id_organisation', $id_organisation);
         if($id_serviceUser) {
        $this->db->where('service', $id_serviceUser);
        }
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getTreatedAppointmentBySearch($search, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Treated');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->like('id', $search);
        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getTreatedAppointmentByLimit($limit, $start, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Treated');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getTreatedAppointmentByLimitBySearch($limit, $start, $search, $id_organisation) {
        $this->db->where('status', 'Treated');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getCancelledAppointment($id_organisation,$id_serviceUser) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Cancelled');
        $this->db->where('id_organisation', $id_organisation);
         if($id_serviceUser) {
        $this->db->where('service', $id_serviceUser);
        }
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getCancelledAppointmentBySearch($search, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Cancelled');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->like('id', $search);
        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getCancelledAppointmentByLimit($limit, $start, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Cancelled');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getCancelledAppointmentByLimitBySearch($limit, $start, $search, $id_organisation) {
        $this->db->where('status', 'Cancelled');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('patientname', $search);
        $this->db->or_like('doctorname', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getAppointmentListByDoctor($doctor, $id_organisation) {
        $this->db->where('doctor', $doctor);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getAppointmentListBySearchByDoctor($doctor, $search, $id_organisation) {
        $this->db->where('doctor', $doctor);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->order_by('id', 'desc');
        $this->db->group_start();
	    $this->db->like('id', $search);
	    $this->db->or_like('patientname', $search);
	    $this->db->or_like('doctorname', $search);
		$this->db->group_end();
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getAppointmentListByLimitByDoctor($doctor, $limit, $start, $id_organisation) {
        $this->db->where('doctor', $doctor);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getAppointmentListByLimitBySearchByDoctor($doctor, $limit, $start, $search, $id_organisation) {
        $this->db->where('doctor', $doctor);
		$this->db->where('id_organisation', $id_organisation);
        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

	    $this->db->group_start();
	    $this->db->like('id', $search);
	    $this->db->or_like('patientname', $search);
	    $this->db->or_like('doctorname', $search);
	    $this->db->group_end();

        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getRequestAppointmentByDoctor($doctor, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Requested');
        $this->db->where('doctor', $doctor);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getRequestAppointmentBySearchByDoctor($doctor, $search, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Requested')
                ->where('doctor', $doctor)
               
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        return $query->result();
    }

    function getRequestAppointmentByLimitByDoctor($doctor, $limit, $start, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Requested');
        $this->db->where('doctor', $doctor);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getRequestAppointmentByLimitBySearchByDoctor($doctor, $limit, $start, $search, $id_organisation) {

        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Requested')
                ->where('doctor', $doctor)
                 ->where('id_organisation', $id_organisation)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        return $query->result();
    }

    function getCancelledAppointmentByDoctor($doctor, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Cancelled');
        $this->db->where('doctor', $doctor);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getCancelledAppointmentBySearchByDoctor($doctor, $search, $id_organisation) {
        $this->db->order_by('id', 'desc');
        
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Cancelled')
                ->where('doctor', $doctor)
                 ->where('id_organisation', $id_organisation)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        return $query->result();
    }

    function getCancelledAppointmentByLimitByDoctor($doctor, $limit, $start, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Cancelled');
        $this->db->where('doctor', $doctor);
         $this->db->where('id_organisation', $id_organisation);
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getCancelledAppointmentByLimitBySearchByDoctor($doctor, $limit, $start, $search, $id_organisation) {

        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Cancelled')
                ->where('doctor', $doctor)
                 ->where('id_organisation', $id_organisation)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        return $query->result();
    }

    function getPendingAppointmentByDoctor($doctor, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Pending Confirmation');
        $this->db->where('doctor', $doctor);
         $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getPendingAppointmentBySearchByDoctor($doctor, $search, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Pending Confirmation')
                ->where('doctor', $doctor)
                 ->where('id_organisation', $id_organisation)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        return $query->result();
    }

    function getPendingAppointmentByLimitByDoctor($doctor, $limit, $start, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Pending Confirmation');
        $this->db->where('doctor', $doctor);
          $this->db->where('id_organisation', $id_organisation);
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getPendingAppointmentByLimitBySearchByDoctor($doctor, $limit, $start, $search, $id_organisation) {

        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Pending Confirmation')
                ->where('doctor', $doctor)
                 ->where('id_organisation', $id_organisation)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        return $query->result();
    }

    function getTreatedAppointmentByDoctor($doctor, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Treated');
        $this->db->where('doctor', $doctor);
          $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getTreatedAppointmentBySearchByDoctor($doctor, $search, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Treated')
                ->where('doctor', $doctor)
                 ->where('id_organisation', $id_organisation)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        return $query->result();
    }

    function getTreatedAppointmentByLimitByDoctor($doctor, $limit, $start, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Treated');
        $this->db->where('doctor', $doctor);
          $this->db->where('id_organisation', $id_organisation);
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getTreatedAppointmentByLimitBySearchByDoctor($doctor, $limit, $start, $search, $id_organisation) {

        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Treated')
                ->where('doctor', $doctor)
                 ->where('id_organisation', $id_organisation)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        return $query->result();
    }

    function getConfirmedAppointmentByDoctor($doctor, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Confirmed');
        $this->db->where('doctor', $doctor);
          $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getConfirmedAppointmentBySearchByDoctor($doctor, $search, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Confirmed')
                ->where('doctor', $doctor)
                 ->where('id_organisation', $id_organisation)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        return $query->result();
    }

    function getConfirmedAppointmentByLimitByDoctor($doctor, $limit, $start, $id_organisation) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', 'Confirmed');
        $this->db->where('doctor', $doctor);
          $this->db->where('id_organisation', $id_organisation);
        $this->db->limit($limit, $start);
        $query = $this->db->get('appointment');
        return $query->result();
    }

    function getConfirmedAppointmentByLimitBySearchByDoctor($doctor, $limit, $start, $search, $id_organisation) {

        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->select('*')
                ->from('appointment')
                ->where('status', 'Confirmed')
                ->where('doctor', $doctor)
                 ->where('id_organisation', $id_organisation)
                ->where("(id LIKE '%" . $search . "%' OR patientname LIKE '%" . $search . "%' OR doctorname LIKE '%" . $search . "%')", NULL, FALSE)
                ->get();
        return $query->result();
    }

}
