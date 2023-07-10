<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Horaire_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
 function listDoctor($id_organisation, $id=NULL,$id_serviceUser) {
        $this->db->select('users.*, users.id as iduser,setting_service.name_service');
        $this->db->from('users');
        $this->db->join('organisation', 'organisation.id=users.id_organisation', 'left');
        $this->db->join('users_groups', 'users_groups.user_id=users.id', 'left');
        $this->db->join('groups', 'groups.id=users_groups.group_id', 'left');
        $this->db->join('setting_service', 'setting_service.idservice=users.service', 'left');
        $this->db->where('users.id_organisation', $id_organisation);
        $this->db->where('groups.name', 'Doctor');
         if($id_serviceUser) {
              $this->db->where('users.service', $id_serviceUser);
        }
        if($id){
        $this->db->where('users.id', $id);
        }
        $query = $this->db->get();

        return  $query->result();
 }
 
  function getScheduleByDoctor($doctor) {
        $this->db->where('doctor', $doctor);
        $query = $this->db->get('time_schedule');
        return $query->result();
    }
    
    function getScheduleByService($service) {
        $this->db->where('service', $service);
        $query = $this->db->get('time_schedule_service');
        return $query->result();
    }
    
     function getScheduleByDoctorByWeekday($doctor, $weekday) {
        $this->db->where('doctor', $doctor);
        $this->db->where('weekday', $weekday);
        $query = $this->db->get('time_schedule');
        return $query->result();
    }
    
     function getScheduleByServiceByWeekday($doctor, $weekday) {
        $this->db->where('service', $doctor);
        $this->db->where('weekday', $weekday);
        $query = $this->db->get('time_schedule_service');
        return $query->result();
    }
    
     function getScheduleByDoctorByWeekdayById($doctor, $weekday, $id) {
        $this->db->where_not_in('id', $id);
        $this->db->where('doctor', $doctor);
        $this->db->where('weekday', $weekday);
        $query = $this->db->get('time_schedule');
        return $query->result();
    }
     function getScheduleByServiceByWeekdayById($doctor, $weekday, $id) {
        $this->db->where_not_in('id', $id);
        $this->db->where('service', $doctor);
        $this->db->where('weekday', $weekday);
        $query = $this->db->get('time_schedule_service');
        return $query->result();
    }
    
      function updateSchedule($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('time_schedule', $data);
    }

    function deleteSchedule($id) {
        $this->db->where('id', $id);
        $this->db->delete('time_schedule');
    }
    
      function updateScheduleService($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('time_schedule_service', $data);
    }

    function deleteScheduleService($id) {
        $this->db->where('id', $id);
        $this->db->delete('time_schedule_service');
    }
    
     function insertTimeSlot($data) {
        $this->db->insert('time_slot', $data);
    }
    
     function insertTimeSlotService($data) {
        $this->db->insert('time_slot_service', $data);
    }
    
      function insertSchedule($data) {
        $this->db->insert('time_schedule', $data);
    }
      function insertScheduleService($data) {
        $this->db->insert('time_schedule_service', $data);
    }
    
     function deleteTimeSlotByDoctorByWeekday($doctor, $weekday) {
        $this->db->where('doctor', $doctor);
        $this->db->where('weekday', $weekday);
        $this->db->delete('time_slot');
    }
     function deleteTimeSlotByserviceByWeekday($doctor, $weekday) {
        $this->db->where('service', $doctor);
        $this->db->where('weekday', $weekday);
        $this->db->delete('time_slot_service');
    }
    
     function getAvailableSlotByDoctorByDateByAppointmentId($date, $doctor, $appointment_id) { //var_dump($date);
          if($date){
         $newDateFormatTab = explode('/', $date);
         $newDate =  $newDateFormatTab[1].'/'.$newDateFormatTab[0].'/'.$newDateFormatTab[2];
     }    
        $weekday = strftime("%A", strtotime($newDate));
     $date = strtotime($newDate);
        $this->db->where('date', $date);
        $this->db->where('service', $doctor);
        $holiday = $this->db->get('holidays_service')->result();
       
        
        if (empty($holiday)) {

            $this->db->where('date', $date);
            $this->db->where('service', $doctor);
            $query = $this->db->get('appointment')->result();


            $this->db->where('service', $doctor);
            $this->db->where('weekday', $weekday);          
            $this->db->order_by('s_time_key', 'asc');
            $query1 = $this->db->get('time_slot_service')->result();

            $availabletimeSlot = array();
            $bookedTimeSlot = array();

            foreach ($query1 as $timeslot) {
                $availabletimeSlot[] = $timeslot->s_time . ' - ' . $timeslot->e_time;
            }
            foreach ($query as $bookedTime) {              
                if ($bookedTime->status != 'Cancelled') {
                    if ($bookedTime->id != $appointment_id) {
                        $bookedTimeSlot[] = $bookedTime->time_slot;
                    }
                }
            }

            $availableSlot = array_diff($availabletimeSlot, $bookedTimeSlot);
        } else {
            $availableSlot = array();
        }

        return $availableSlot;
    }
    
    function getAvailableSlotByDoctorByDate($date, $doctor) {
              if($date){
         $newDateFormatTab = explode('/', $date);
         $newDate =  $newDateFormatTab[1].'/'.$newDateFormatTab[0].'/'.$newDateFormatTab[2];
     }    
        $weekday = strftime("%A", strtotime($newDate));
$date = strtotime($newDate);
        $this->db->where('date', $date);
        $this->db->where('service', $doctor);
        $holiday = $this->db->get('holidays_service')->result();

        if (empty($holiday)) {
            $this->db->where('date', $date); 
            $this->db->where('service', $doctor);
            $query = $this->db->get('appointment')->result();


            $this->db->where('service', $doctor);  
            $this->db->where('weekday', $weekday);
            $this->db->order_by('s_time_key', 'asc');
            $query1 = $this->db->get('time_slot_service')->result();

            $availabletimeSlot = array();
            $bookedTimeSlot = array();

            foreach ($query1 as $timeslot) {
                $availabletimeSlot[] = $timeslot->s_time . ' - ' . $timeslot->e_time;
            } 
            foreach ($query as $bookedTime) {
                if ($bookedTime->status != 'Cancelled') {
                    $bookedTimeSlot[] = $bookedTime->time_slot;
                }
            }

            $availableSlot = array_diff($availabletimeSlot, $bookedTimeSlot);
        } else {
            $availableSlot = array();
        }

        return $availableSlot;
    }

	function listTableDoctor($id_organisation, $id=NULL,$id_serviceUser) {
		$this->db->select('users.*, users.id as iduser,setting_service.name_service');
		$this->db->from('users');
		$this->db->join('organisation', 'organisation.id=users.id_organisation', 'left');
		$this->db->join('users_groups', 'users_groups.user_id=users.id', 'left');
		$this->db->join('groups', 'groups.id=users_groups.group_id', 'left');
		$this->db->join('setting_service', 'setting_service.idservice=users.service', 'left');
		$this->db->where('users.id_organisation', $id_organisation);
		$this->db->where('groups.name', 'Doctor');
		if($id_serviceUser) {
			$this->db->where('users.service', $id_serviceUser);
		}
		if($id){
			$this->db->where('users.id', $id);
		}
		$query = $this->db->get();

		return  $query->result();
	}

	function listTableDoctorBySearch($search, $id_organisation, $id=NULL,$id_serviceUser) {
		$this->db->select('users.*, users.id as iduser,setting_service.name_service');
		$this->db->from('users');
		$this->db->join('organisation', 'organisation.id=users.id_organisation', 'left');
		$this->db->join('users_groups', 'users_groups.user_id=users.id', 'left');
		$this->db->join('groups', 'groups.id=users_groups.group_id', 'left');
		$this->db->join('setting_service', 'setting_service.idservice=users.service', 'left');
		$this->db->where('users.id_organisation', $id_organisation);
		$this->db->where('groups.name', 'Doctor');
		if($id_serviceUser) {
			$this->db->where('users.service', $id_serviceUser);
		}
		if($id){
			$this->db->where('users.id', $id);
		}
		$this->db->group_start();
		$this->db->like('users.first_name', $search);
		$this->db->or_like('users.last_name', $search);
		$this->db->or_like('users.email', $search);
		$this->db->or_like('users.phone', $search);
		$this->db->or_like('setting_service.name_service', $search);
		$this->db->group_end();
		$query = $this->db->get();

		return  $query->result();
	}

	function listTableDoctorByLimit($limit, $start, $id_organisation, $id=NULL,$id_serviceUser) {
		$this->db->select('users.*, users.id as iduser,setting_service.name_service');
		$this->db->from('users');
		$this->db->join('organisation', 'organisation.id=users.id_organisation', 'left');
		$this->db->join('users_groups', 'users_groups.user_id=users.id', 'left');
		$this->db->join('groups', 'groups.id=users_groups.group_id', 'left');
		$this->db->join('setting_service', 'setting_service.idservice=users.service', 'left');
		$this->db->where('users.id_organisation', $id_organisation);
		$this->db->where('groups.name', 'Doctor');
		if($id_serviceUser) {
			$this->db->where('users.service', $id_serviceUser);
		}
		if($id){
			$this->db->where('users.id', $id);
		}
		$this->db->limit($limit, $start);
		$query = $this->db->get();

		return  $query->result();
	}

	function listTableDoctorByLimitBySearch($limit, $start, $search, $id_organisation, $id=NULL,$id_serviceUser) {
		$this->db->select('users.*, users.id as iduser,setting_service.name_service');
		$this->db->from('users');
		$this->db->join('organisation', 'organisation.id=users.id_organisation', 'left');
		$this->db->join('users_groups', 'users_groups.user_id=users.id', 'left');
		$this->db->join('groups', 'groups.id=users_groups.group_id', 'left');
		$this->db->join('setting_service', 'setting_service.idservice=users.service', 'left');
		$this->db->where('users.id_organisation', $id_organisation);
		$this->db->where('groups.name', 'Doctor');
		if($id_serviceUser) {
			$this->db->where('users.service', $id_serviceUser);
		}
		if($id){
			$this->db->where('users.id', $id);
		}
		$this->db->group_start();
		$this->db->like('users.first_name', $search);
		$this->db->or_like('users.last_name', $search);
		$this->db->or_like('users.email', $search);
		$this->db->or_like('users.phone', $search);
		$this->db->or_like('setting_service.name_service', $search);
		$this->db->group_end();
		$this->db->limit($limit, $start);
		$query = $this->db->get();

		return  $query->result();
	}

	function getTableScheduleByDoctor($doctor) {
		$this->db->where('doctor', $doctor);
		$query = $this->db->get('time_schedule');
		return $query->result();
	}

	function getTableScheduleByDoctorBySearch($doctor, $search) {
		$this->db->where('doctor', $doctor);
		$this->db->group_start();
		$this->db->like('weekday', $search);
		$this->db->or_like('s_time', $search);
		$this->db->or_like('e_time', $search);
		$this->db->group_end();
		$query = $this->db->get('time_schedule');
		return $query->result();
	}

	function getTableScheduleByDoctorByLimit($doctor, $limit, $start) {
		$this->db->where('doctor', $doctor);
		$this->db->limit($limit, $start);
		$query = $this->db->get('time_schedule');
		return $query->result();
	}

	function getTableScheduleByDoctorByLimitBySearch($doctor, $limit, $start, $search) {
		$this->db->where('doctor', $doctor);
		$this->db->group_start();
		$this->db->like('weekday', $search);
		$this->db->or_like('s_time', $search);
		$this->db->or_like('e_time', $search);
		$this->db->group_end();
		$this->db->limit($limit, $start);
		$query = $this->db->get('time_schedule');
		return $query->result();
	}

	function getTableScheduleByService($service) {
		$this->db->where('service', $service);
		$query = $this->db->get('time_schedule_service');
		return $query->result();
	}

	function getTableScheduleByServiceBySearch($service, $search) {
		$this->db->where('service', $service);
		$this->db->group_start();
		$this->db->like('weekday', $search);
		$this->db->or_like('s_time', $search);
		$this->db->or_like('e_time', $search);
		$this->db->group_end();
		$query = $this->db->get('time_schedule_service');
		return $query->result();
	}

	function getTableScheduleByServiceByLimit($service, $limit, $start) {
		$this->db->where('service', $service);
		$this->db->limit($limit, $start);
		$query = $this->db->get('time_schedule_service');
		return $query->result();
	}

	function getTableScheduleByServiceByLimitBySearch($service, $limit, $start, $search) {
		$this->db->where('service', $service);
		$this->db->group_start();
		$this->db->like('weekday', $search);
		$this->db->or_like('s_time', $search);
		$this->db->or_like('e_time', $search);
		$this->db->group_end();
		$this->db->limit($limit, $start);
		$query = $this->db->get('time_schedule_service');
		return $query->result();
	}
}
