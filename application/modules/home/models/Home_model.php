<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home_model extends CI_model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getSum($field, $table)
    {
        $this->db->select_sum($field);
        $query = $this->db->get($table);
        return $query->result();
    }

    public function addOrganisation($data)
    {
        $query = $this->db->insert('organisation', $data);
        if ($this->db->affected_rows() > 0) {
            // Update Code organisation
            $last_insert_id = $this->db->insert_id();
            // updateOrganisation($last_insert_id, array("code" => $this->db->count_all('organisation'))); // Peut créer soucis si 2 créations simultanées
            // $this->updateOrganisation($last_insert_id, array("code" => str_pad($last_insert_id, 3, "0", STR_PAD_LEFT)));
            $this->updateOrganisation($last_insert_id, array("code" => $last_insert_id));
            return "ok";
        } else {
            $e = $this->db->error();
            return "Erreur " . $e['message'] . " " . $e["code"];
        }
    }


    function getAllSpecialiteIdsAndNames($searchTerm, $id)
    {
        if (!empty($searchTerm)) {
            $this->db->select('idspe,name_specialite');
            $this->db->where('id_service ', $id);
            $this->db->where("name_specialite  like '%" . $searchTerm . "%' ");
            $this->db->or_where("idspe like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('setting_service_specialite ');
            $specialite = $fetched_records->result_array();
        } else {
            $this->db->select('idspe,name_specialite');
            $this->db->where('id_service ', $id);
            // $this->db->where("name like '%".$searchTerm."%' ");
            //  $this->db->or_where("id like '%".$searchTerm."%' ");
            $this->db->limit(100);
            $fetched_records = $this->db->get('setting_service_specialite ');
            $specialite = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
      //  $data[] = array("id" => 'add_new', "text" => lang('add_new'));
        foreach ($specialite as $specialites) {
            $data[] = array("id" => $specialites['idspe'], "text" => $specialites['name_specialite']);
            // $data[] = array("id" => $user['id'], "text" => $user['name'] .' '.$user['last_name'] . ' ('.lang('phone').': ' . $user['phone'].')');
        }
        return $data;
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

    function updateOrganisationAdmin($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }

    function updateUserEntry($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }

    function getMaladie() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('illness');
        $this->db->limit(10000);
        return $query->result();
    }

    function getPatientById($id)
    {
        $this->db->where('patient_id', $id);
        // $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('patient');
        return $query->row();
    }


    function getUsersPatientById($id)
    {
        $this->db->where('id', $id);
        // $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('patient');
        return $query->row();
    }


    public function updateOrganisation($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('organisation', $data);
        // if($this->db->affected_rows() > 0) {
        // return "ok";
        // } else {
        // $e = $this->db->error();
        // return "Erreur ".$e['message']." ".$e["code"]; 
        // }
    }

    public function getOrganisations()
    {
        $this->db->where('organisation.is_light', 0);
        // $this->db->select_sum($field);
        $query = $this->db->get("organisation");

        $this->db->order_by('id', 'desc');
        return $query->result();
    }

    public function getOrganisationsForAppointment()
    {
        // $this->db->select_sum($field);
        $this->db->where('type != ', "Assurance");
        $query = $this->db->get("organisation");
        $this->db->order_by('id', 'desc');
        return $query->result();
    }

    public function getIdCurrentSpecialite($nom_service, $nom_specialite) {
        $id_service = $this->db->query("select idservice from setting_service where name_service = \"" . $nom_service . "\" and id_organisation is NULL")->row()->idservice;
        $id_spe = $this->db->query("select (CASE WHEN `setting_service_specialite`.idspe IS NOT NULL THEN (SELECT `setting_service_specialite`.idspe) ELSE (SELECT '') END) as idspe from setting_service_specialite join setting_service on setting_service.idservice = setting_service_specialite.id_service and setting_service.idservice = " . $id_service . "  and id_organisation is NULL where name_specialite = \"" . $nom_specialite . "\"")->row()->idspe;
        return $id_spe;
    }

    public function getCurrentSpecialiteAndPossibleList($nom_service, $nom_specialite) {
        $id_service = $this->db->query("select idservice from setting_service where name_service = \"" . $nom_service . "\" and id_organisation is NULL")->row()->idservice;
        $result = $this->db->query("select (CASE WHEN `setting_service_specialite`.idspe IS NOT NULL THEN (SELECT `setting_service_specialite`.idspe) ELSE (SELECT '') END) as idspe, (CASE WHEN `setting_service_specialite`.name_specialite IS NOT NULL THEN (SELECT `setting_service_specialite`.name_specialite) ELSE (SELECT '') END) as name_specialite from setting_service_specialite join setting_service on setting_service.idservice = setting_service_specialite.id_service and setting_service.idservice = " . $id_service . "  and id_organisation is NULL where name_specialite != \"" . $nom_specialite . "\"")->result();
        return $result;
    }

    // public function getOrganisationUsers($id_organisation) {
    // $this->db->where('id_organisation', $id_organisation);
    // $query = $this->db->get("users");
    // $this->db->order_by('id', 'desc');
    // return $query->result();
    // }

    public function getOrganisationUsers($id_organisation)
    {
        $query = $this->db->query("select users.*, `groups`.id AS groupId, `groups`.name as groupName, `groups`.label_fr as groupLabelFr from users join users_groups on users_groups.user_id = users.id and users.id_organisation = '" . $id_organisation . "' join `groups` on users_groups.group_id = `groups`.id order by users.id desc");
        return $query->result();
    }

    public function getOrganisationAdminUsers($id_organisation)
    {
        $query = $this->db->query("select users.*,users.id AS idUsers, `groups`.id AS groupId, `groups`.name as groupName, `groups`.label_fr as groupLabelFr from users join users_groups on users_groups.user_id = users.id and users.id_organisation = '" . $id_organisation . "' join `groups` on users_groups.group_id = `groups`.id and `groups`.id = 1 UNION ALL select users.*,users.id AS idUsers, `groups`.id AS groupId, `groups`.name as groupName, `groups`.label_fr as groupLabelFr from users join users_groups on users_groups.user_id = users.id and users.id_organisation = '" . $id_organisation . "' join `groups` on users_groups.group_id = `groups`.id and `groups`.id = 14 order by idUsers desc");
        return $query->result();
    }


    function updateUsersGroups($id,$group) {
        $uptade_ion_user = array(
          'group_id' => $group
      );
      $this->db->where('user_id', $id);
      $this->db->update('users_groups', $uptade_ion_user);
  }

    public function getOrganisationNonAdminUsers($id_organisation)
    { // Exclusion Patients egalement
        $query = $this->db->query("select users.*, `groups`.id AS groupId, `groups`.name as groupName, `groups`.label_fr as groupLabelFr from users join users_groups on users_groups.user_id = users.id and users.id_organisation = '" . $id_organisation . "' join `groups` on users_groups.group_id = `groups`.id and `groups`.id != 1 and `groups`.id != 5 order by users.id desc");
        return $query->result();
    }

    public function getOrganisationNonPatientUsers($id_organisation)
    { // Exclusion Patients egalement
        $query = $this->db->query("select users.*, `groups`.id AS groupId, `groups`.name as groupName, `groups`.label_fr as groupLabelFr from users join users_groups on users_groups.user_id = users.id and users.id_organisation = '" . $id_organisation . "' join `groups` on users_groups.group_id = `groups`.id and `groups`.id != 5 order by users.id desc");
        return $query->result();
    }

    public function getOrganisationById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get("organisation");
        // $this->db->where('id', $id);
        return $query->row();
    }

    function getGeneriquePrestation() {
        $query = $this->db->query("select * from payment_category order by id desc");
         return $query->result();
     }

     function getPrestationById($id) {
        $this->db->where('id', $id);    
        $query = $this->db->get('payment_category');
        return $query->row();
     }

     function getTiersPayantById($id) {
        $this->db->where('id', $id);    
        $query = $this->db->get('tiers_payant');
        return $query->row();
    }

    function getTiersPayantByIdCotation($id) {
        $this->db->where('code', $id);    
        $query = $this->db->get('tiers_payant');
        return $query->row();
    }

    function getTiersPayant() {  
        $query = $this->db->query("select * from tiers_payant order by id desc");
        return $query->result();
    }
    public function getUserById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get("users");
        // $this->db->where('id', $id);
        return $query->row();
    }

    public function getRegionsSenegal()
    {
        // $this->db->select_sum($field);
        $this->db->order_by('label', 'asc');
        $query = $this->db->get("region_senegal");
        return $query->result();
    }

    public function getDepartementsByRegion($id_region)
    {
        // $this->db->select_sum($field);
        $this->db->where('id_region', $id_region);
        $this->db->order_by('label', 'asc');
        $query = $this->db->get("departement_senegal");
        return $query->result();
    }

    public function getArrondissementsByDepartement($id_departement)
    {
        // $this->db->select_sum($field);
        $this->db->where('id_departement', $id_departement);
        $this->db->order_by('label', 'asc');
        $query = $this->db->get("arrondissement_senegal");
        return $query->result();
    }

    public function getCollectivitesByArrondissement($id_arrondissement)
    {
        // $this->db->select_sum($field);
        $this->db->where('id_arrondissement', $id_arrondissement);
        $this->db->order_by('label', 'asc');
        $query = $this->db->get("collectivite_senegal");
        return $query->result();
    }

    function get_id_organisation($email)
    {
        $id_organisation = '';
        $this->db->where('email', $email);
        $query = $this->db->get("users");
        $rowRes = $query->row();
        if (is_object($rowRes)) {
            $id_organisation = $rowRes->id_organisation;
        }
        return $id_organisation;
    }

    function get_champ_organisation($fied_name, $id_organisation)
    {
        $field_value = '';
        $this->db->where('id', $id_organisation);
        $query = $this->db->get("organisation");
        $rowRes = $query->row();
        if (is_object($rowRes)) {
            $field_value = $rowRes->path_logo;
        }
        return $field_value;
    }

    function get_logo_organisation($id_organisation)
    {
        $field_value = '';
        $this->db->where('id', $id_organisation);
        $query = $this->db->get("organisation");
        $rowRes = $query->row();
        if (is_object($rowRes)) {
            $field_value = $rowRes->path_logo;
        }
        return $field_value;
    }


    function get_signature($id_organisation)
    {
        $field_value = '';
        $this->db->where('id', $id_organisation);
        $query = $this->db->get("organisation");
        $rowRes = $query->row();
        if (is_object($rowRes)) {
            $field_value = $rowRes->signature;
        }
        return $field_value;
    }

    function get_footer($id_organisation)
    {
        $field_value = '';
        $this->db->where('id', $id_organisation);
        $query = $this->db->get("organisation");
        $rowRes = $query->row();
        if (is_object($rowRes)) {
            $field_value = $rowRes->footer;
        }
        return $field_value;
    }

    function get_entete($id_organisation)
    {
        $field_value = '';
        $this->db->where('id', $id_organisation);
        $query = $this->db->get("organisation");
        $rowRes = $query->row();
        if (is_object($rowRes)) {
            $field_value = $rowRes->entete;
        }
        return $field_value;
    }

    function get_nom_organisation($id_organisation)
    {
        $field_value = '';
        $this->db->where('id', $id_organisation);
        $query = $this->db->get("organisation");
        $rowRes = $query->row();
        if (is_object($rowRes)) {
            $field_value = $rowRes->nom;
        }
        return $field_value;
    }

    function get_email_organisation($id_organisation)
    {
        $field_value = '';
        $this->db->where('id', $id_organisation);
        $query = $this->db->get("organisation");
        $rowRes = $query->row();
        if (is_object($rowRes)) {
            $field_value = $rowRes->email;
        }
        return $field_value;
    }

    function get_numero_fixe_organisation($id_organisation)
    {
        $field_value = '';
        $this->db->where('id', $id_organisation);
        $query = $this->db->get("organisation");
        $rowRes = $query->row();
        if (is_object($rowRes)) {
            $field_value = $rowRes->numero_fixe;
        }
        return $field_value;
    }

    function get_code_organisation($id_organisation)
    {
        $field_value = '';
        $this->db->where('id', $id_organisation);
        $query = $this->db->get("organisation");
        $rowRes = $query->row();
        if (is_object($rowRes)) {
            $field_value = $rowRes->code;
        }
        return $field_value;
    }

    function id_partenaire_zuuluPay($id_organisation)
    {
        $field_value = '';
        $this->db->where('id', $id_organisation);
        $query = $this->db->get("organisation");
        $rowRes = $query->row();
        if (is_object($rowRes)) {
            $field_value = $rowRes->id_partenaire_zuuluPay;
        }
        return $field_value;
    }

    function pin_partenaire_zuuluPay_encrypted($id_organisation)
    {
        $field_value = '';
        $this->db->where('id', $id_organisation);
        $query = $this->db->get("organisation");
        $rowRes = $query->row();
        if (is_object($rowRes)) {
            $field_value = $rowRes->pin_partenaire_zuuluPay_encrypted;
        }
        return $field_value;
    }

    function getPaymentCategory()
    {
        // $query = $this->db->get('payment_category');
        // $query = $this->db->query("select payment_category.id, payment_category.prestation, payment_category.description,  setting_service_specialite.name_specialite, payment_category.tarif_public, payment_category.tarif_professionnel, payment_category.tarif_assurance"
        $this->db->select('*');
        $this->db->from('setting_service_specialite');
        $this->db->join('setting_service', 'setting_service.idservice=setting_service_specialite.id_service', 'left');
        $this->db->join('payment_category', 'payment_category.id_spe=setting_service_specialite.idspe', 'right');
        $this->db->where('code_service', 'labo');
        $query = $this->db->get();
        return $query->result();
    }

    function get_code_service($email)
    {
        $field_value = '';

        $this->db->select('*');
        $this->db->from('users');
        // $this->db->join('setting_service','setting_service.idservice=users.service', 'left');
        $this->db->where('users.email', $email);
        $query = $this->db->get();
        $rowRes = $query->row();
        if (is_object($rowRes)) {
            $field_value = $rowRes->service;
        }
        return $field_value;
    }

    public function getOrganisationsLight($id)
    {
        $this->db->select('*');
        $this->db->from('organisation');
        $this->db->join('partenariat_sante', 'partenariat_sante.id_organisation_origin=organisation.id', 'left');
        $this->db->where('organisation.is_light = 1 and partenariat_sante.id_organisation_destinataire = ' . $id);
        $this->db->where('partenariat_sante.partenariat_actif', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function getOrganisationsNoLight($id)
    {
        $this->db->select('*');
        $this->db->from('organisation');
        $this->db->join('partenariat_sante', 'partenariat_sante.id_organisation_destinataire=organisation.id', 'left');
        $this->db->where('organisation.is_light = 0 and partenariat_sante.id_organisation_origin = ' . $id);
        // $this->db->where('partenariat_sante.id_organisation_origin', 3);
        $query = $this->db->get();
        return $query->result();
    }




    public function listeModeleByLabo()
    {
        // $this->db->select_sum($field);
        $this->db->where('type', 'labo');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get("template");
        return $query->result();
    }

    public function getModeleByLabo($id, $organisation)
    {
        $this->db->select('*');
        $this->db->from('payment_category_organisation');
        $this->db->join('template', 'template.id=payment_category_organisation.is_modele', 'left');
        $this->db->where('payment_category_organisation.id_presta = ' . $id . ' and payment_category_organisation.id_organisation= ' . $organisation);
        $query = $this->db->get();

        $result = $query->row();
        return $result;
    }
    public function updateModeleByLabo($id, $data)
    {
        $this->db->where('idpco', $id);
        $this->db->update('payment_category_organisation', $data);
    }
    public function getModeleByLaboPaiement($id, $organisation)
    {

        $this->db->where('payment_category_organisation.id_presta = ' . $id . ' and payment_category_organisation.id_organisation= ' . $organisation);


        $query = $this->db->get("payment_category_organisation");


        $result = array();
        if ($query->row() != null) {
            $result = $query->row();
        }
        return $result;
    }

    function insertWhatsappSettings($data) {
        $this->db->insert('whatsapp_settings', $data);
    }

    function insertPatientUsers($data) {
        $this->db->insert('patientusers', $data);
    }
    function insertAppointmentcenterusers($data) {
        $this->db->insert('appointmentcenterusers', $data);
    }

    function updateWhatsappSettings($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('whatsapp_settings', $data);
    }

    function insertTiersPayant($data) {
        $this->db->insert('tiers_payant', $data);
    }

    function updateTiersPayant($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('tiers_payant', $data);
    }
}
