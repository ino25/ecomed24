<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Doctor_model extends CI_model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function insertDoctor($data)
    {
        $this->db->insert('doctor', $data);
    }

    function getDoctor()
    {
        $query = $this->db->get('doctor');
        return $query->result();
    }

    function getDoctorByOrganisation($id_organisation)
    {
        $this->db->select('*');
        $this->db->from('doctor');
        $this->db->join('users', 'users.id = doctor.ion_user_id');
        $query = $this->db->get();
        return $query->result();
    }

    function getDoctorBySearch($search)
    {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('phone', $search);
        $this->db->or_like('address', $search);
        $this->db->or_like('email', $search);
        $this->db->or_like('department', $search);
        $query = $this->db->get('doctor');
        return $query->result();
    }

    function getDoctorByLimit($limit, $start)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('doctor');
        return $query->result();
    }

    function getDoctorByLimitBySearch($limit, $start, $search)
    {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('name', $search);
        $this->db->or_like('phone', $search);
        $this->db->or_like('address', $search);
        $this->db->or_like('email', $search);
        $this->db->or_like('department', $search);

        $this->db->limit($limit, $start);
        $query = $this->db->get('doctor');
        return $query->result();
    }

    function getDoctorById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('doctor');
        return $query->row();
    }

    function getDoctorUsersById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        return $query->row();
    }

    function getDoctorAdminById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('adminmedecin');
        return $query->row();
    }

    function getDoctorByIonUserId($id)
    {
        $this->db->where('doctor.ion_user_id', $id);
        $this->db->where('adminmedecin.ion_user_id', $id);
        $query = $this->db->get('doctor');
        $query = $this->db->get('adminmedecin');
        return $query->row();
    }

    function updateDoctor($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('doctor', $data);
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('doctor');
    }

    function updateIonUser($username, $email, $password, $ion_user_id)
    {
        $uptade_ion_user = array(
            'username' => $username,
            'email' => $email,
            'password' => $password
        );
        $this->db->where('id', $ion_user_id);
        $this->db->update('users', $uptade_ion_user);
    }

    function getDoctorinfoWithAddNewOption($searchTerm, $id_organisation) {
        if (!empty($searchTerm)) {

            $query = $this->db->query("select doctor.ion_user_id,doctor.name,doctor.phone from doctor,users where doctor.ion_user_id = users.id and users.id_organisation = " . $id_organisation . " and doctor.name like '%" . $searchTerm . "%' or doctor.phone like '%" . $searchTerm . "%'
            UNION ALL
            select adminmedecin.ion_user_id,adminmedecin.name,adminmedecin.phone from adminmedecin,users where adminmedecin.ion_user_id = users.id and users.id_organisation = " . $id_organisation . " and adminmedecin.name like '%" . $searchTerm . "%' or adminmedecin.phone like '%" . $searchTerm . "%'");
            $users = $query->result_array();
        } else {
            $this->db->select('*');
            $query = $this->db->query("select doctor.ion_user_id,doctor.name,doctor.phone from doctor,users where doctor.ion_user_id = users.id and users.id_organisation = " . $id_organisation . "
            UNION ALL
            select adminmedecin.ion_user_id,adminmedecin.name,adminmedecin.phone from adminmedecin,users where adminmedecin.ion_user_id = users.id and users.id_organisation = " . $id_organisation . " ");
            $users = $query->result_array();
            // $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        $data[] = array("id" => 'vide', "text" => "Aucun medecin");
        foreach ($users as $user) {
            $data[] = array("id" => $user['ion_user_id'], "text" => 'DR '.$user['name'].' ( ' . $user['phone'] . ')');
        }
        return $data;
    }

    function getDoctorInfo($searchTerm)
    {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where("name like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('doctor');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            // $this->db->where("name like '%".$searchTerm."%' ");
            //  $this->db->or_where("id like '%".$searchTerm."%' ");
            $this->db->limit(10);
            $fetched_records = $this->db->get('doctor');
            $users = $fetched_records->result_array();
        }


        if ($this->ion_auth->in_group(array('Doctor', 'adminmedecin'))) {
            $doctor_ion_id = $this->ion_auth->get_user_id();
            $this->db->select('*');
            $this->db->where('ion_user_id', $doctor_ion_id);
            $fetched_records = $this->db->get('doctor');
            $users = $fetched_records->result_array();
        }


        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['name'] . ' (' . lang('id') . ': ' . $user['id'] . ')');
        }
        return $data;
    }

    function getDoctorWithAddNewOption($searchTerm)
    {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where("name like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('doctor');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            // $this->db->where("name like '%".$searchTerm."%' ");
            //  $this->db->or_where("id like '%".$searchTerm."%' ");
            $this->db->limit(10);
            $fetched_records = $this->db->get('doctor');
            $users = $fetched_records->result_array();
        }


        if ($this->ion_auth->in_group(array('Doctor', 'adminmedecin'))) {
            $doctor_ion_id = $this->ion_auth->get_user_id();
            $this->db->select('*');
            $this->db->where('ion_user_id', $doctor_ion_id);
            $fetched_records = $this->db->get('doctor');
            $users = $fetched_records->result_array();
        }



        // Initialize Array with fetched data
        $data = array();
        $data[] = array("id" => 'add_new', "text" => lang('add_new'));
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['name'] . ' (' . lang('id') . ': ' . $user['id'] . ')');
        }
        return $data;
    }

    function getDoctorWithAddNewOptionLab($searchTerm, $id_organisation)
    {
        if (!empty($searchTerm)) {
            $query = $this->db->query("select doctor.* from doctor join users on users.id = doctor.ion_user_id AND users.id_organisation = " . $id_organisation . " where (doctor.name like '%" . $searchTerm . "%' or doctor.id like '%" . $searchTerm . "%') AND users.id_organisation = " . $id_organisation);

            // $this->db->select('*');
            // $this->db->where("name like '%" . $searchTerm . "%' ");
            // $this->db->or_where("id like '%" . $searchTerm . "%' ");
            // $this->db->join('users', 'users.id = doctor.ion_user_id AND users.id_organisation = '.$id_organisation.'');
            // $fetched_records = $this->db->get('doctor');
            $users = $query->result_array();
        } else {
            $this->db->select('doctor.*');
            $this->db->join('users', 'users.id = doctor.ion_user_id AND users.id_organisation = ' . $id_organisation . '');
            // $this->db->where("name like '%".$searchTerm."%' ");
            //  $this->db->or_where("id like '%".$searchTerm."%' ");
            $this->db->limit(10);
            $fetched_records = $this->db->get('doctor');
            $users = $fetched_records->result_array();
        }


        if ($this->ion_auth->in_group(array('Doctor', 'adminmedecin'))) {
            $doctor_ion_id = $this->ion_auth->get_user_id();
            $this->db->select('*');
            $this->db->where('ion_user_id', $doctor_ion_id);
            $fetched_records = $this->db->get('doctor');
            $users = $fetched_records->result_array();
        }



        // Initialize Array with fetched data
        $data = array();
        // $data[] = array("id" => 'add_new', "text" => lang('add_new'));
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['name'] . ' (' . lang('id') . ': ' . $user['id'] . ')');
        }
        return $data;
    }
}
