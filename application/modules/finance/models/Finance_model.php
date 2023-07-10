<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Finance_model extends CI_model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function insertPayment($data)
    {
        $this->db->insert('payment', $data);
    }


    function insertTransactions($data)
    {
        $this->db->insert('transactions', $data);
    }

    function insertPCR($data)
    {
        $this->db->insert('PCR', $data);
    }

    function updatePCR($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('PCR', $data);
    }

    function getPayment($id_organisation = '')
    {
        // $this->db->order_by('id', 'desc');
        // $this->db->where('id_organisation', $id_organisation);
        // $this->db->or_where('organisation_destinataire', $id_organisation);
        // $query = $this->db->get('payment');
        $clauseInit = !empty($id_organisation) ? "(id_organisation = " . $id_organisation . " or organisation_destinataire = " . $id_organisation . ") and" : "";
        $this->db->query("SET time_zone = '+00:00';");
        $query = $this->db->query("select *,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateFormat from payment where bulletinAnalyse like '' AND " . $clauseInit . " patient is not NULL order by id desc");
        return $query->result();
    }


    function afficherBulletin($id, $id_organisation)
    {
        $this->db->select('lab.report');
        $this->db->from('lab');
        $this->db->join('organisation', 'organisation.id=lab.id_organisation', 'left');
        $this->db->join('users', 'users.id=lab.user', 'left');
        $this->db->join('users_groups', 'users_groups.user_id=users.id', 'left');
        $this->db->join('groups', 'groups.id=users_groups.group_id', 'left');
        $this->db->where('lab.id_organisation', $id_organisation);
        $this->db->where('lab.payment', $id);

        $query = $this->db->get();


        return $query->row();
    }

    function getPaymentByLabo($id_organisation = '')
    {
        $this->db->query("SET time_zone = '+00:00';");
        $this->db->select('payment.id as id,payment.code as code, payment.patient as patient, payment.date as date,DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y %H:%i") AS dateFormat, payment.category_name as category_name, patient.name as name, patient.last_name as last_name, payment.organisation_destinataire as organisation_destinataire, payment.organisation_light_origin as organisation_light_origin, payment.id_organisation as id_organisation, payment.etat as etat, payment.etatlight as etatlight, payment.status as status');
        $this->db->from('payment');
        $this->db->where('payment.bulletinAnalyse', '');
        $this->db->join("patient", "patient.id = payment.patient");
        $this->db->where('payment.id_organisation', $id_organisation);
        $this->db->or_where('organisation_destinataire', $id_organisation);
        $this->db->order_by('payment.id', 'desc');
        $this->db->limit(1000);
        $query = $this->db->get();
        return $query->result();
    }



    // function getPaymentByLaboByid($id,$presta) {
    //     $lab_data = 'payment'; $lab = 'lab'; $payment_category = 'payment_category';
    //      $this->db->select('*');
    //      $this->db->from($lab_data);
    //      // $this->db->join($lab, $lab . '.id=' . $payment_category . '.id_lab', 'left');
    //        $this->db->join($payment_category, $payment_category . '.id=' . $lab_data . '.id_prestation', 'left');
    //      $this->db->where($lab_data . '.id_prestation', $presta);

    //       $this->db->where($lab_data . '.id_payment', $id);
    //      $query = $this->db->get();
    //      return $query->row();
    //  }

    function getUserByIdJson($id) {
        $query = $this->db->query("select first_name, last_name, phone, email from users where id = " . $id . "");
        return $query->row();
    }
    function getOrganisationJson($id) {
        $query = $this->db->query("select * from organisation where id = " . $id . "");
        return $query->row();
    }
    
    function getPatient($id) {
        $query = $this->db->query("select patient_id, CONCAT(name,' ', last_name) as namePatient, age, sex, birthdate from patient where id = " . $id . "");
        return $query->row();
    }
  
    

    function doctorsList($id) {
        $query = $this->db->query("select users.first_name as doctorFirstName , users.last_name as doctorLastName from doctor,users where doctor.ion_user_id = users.id and users.id_organisation = " . $id . "");
        return $query->result_array();
    }

    function getPrestationId($id)
    {
        $query = $this->db->query("select * from payment_category where id = " . $id . "");
        return $query->row();
    }

    function getPrestationOrganisation($id_presta, $id_organisation)
    {
        $query = $this->db->query("select round(tarif_assurance) as prix_assurance, round(tarif_ipm) as prix_ipm from payment_category_organisation where id_presta = " . $id_presta . " AND id_organisation = " . $id_organisation . "");
        return $query->row();
    }

    function getPrestationIdJSON($id)
    {
        $query = $this->db->query("select id, id_spe , prestation as testOrdered, ' ' as observations from payment_category where id = " . $id . "");
        return $query->row();
    }

    function listeResultatPrestationId($id)
    {
        $query = $this->db->query("select * from payment_category_parametre where id_specialite = " . $id . " order by idpara ASC");
        return $query->result_array();
    }

    function getSpecialiteId($id)
    {
        $query = $this->db->query("select * from setting_service_specialite where idspe = " . $id . "");
        return $query->row();
    }

    function getSpecialiteIdJSON($id)
    {
        $query = $this->db->query("select idspe as specialtyID,name_specialite as specialtyName, setting_service_specialite.code_specialite, idspe as testList from setting_service_specialite where idspe = " . $id . " ");
        return $query->row();
    }

    function getPrelevementJSON($id)
    {
        $query = $this->db->query("select date_prelevement, numeroRegistre, prescripteur from lab where payment = " . $id . "");
        return $query->row();
    }


    function getSpecialiteConsultation($searchTerm)
    {
        if (!empty($searchTerm)) {

            $query = $this->db->query("select setting_service_specialite.idspe, setting_service_specialite.name_specialite FROM setting_service_specialite LEFT JOIN payment_category ON payment_category.id_spe = setting_service_specialite.idspe WHERE
            payment_category.`prestation` like '%consultation%' and setting_service_specialite.name_specialite like '%" . $searchTerm . "%'");
            $users = $query->result_array();
        } else {
            $this->db->select('*');
            $query = $this->db->query("select setting_service_specialite.idspe, setting_service_specialite.name_specialite FROM setting_service_specialite LEFT JOIN payment_category ON payment_category.id_spe = setting_service_specialite.idspe WHERE
            payment_category.`prestation` like '%consultation%'");

            $users = $query->result_array();
        }
        // Initialize Array with fetched data

        foreach ($users as $user) {
            //  $data[] = array("id" => $user['name'], "text" => $user['phone']);
            $data[] = array("id" => $user['name_specialite'], "text" => $user['name_specialite']);
        }
        return $data;
    }

    function getParamPrestation($idPayment, $idPresta)
    {
        $query = $this->db->query("select lab_data.id_para ,payment_category_parametre.type ,payment_category_parametre.nom_parametre,lab_data.resultats,payment_category_parametre.unite,payment_category_parametre.valeurs from lab_data 
        join lab ON lab.id = lab_data.id_lab and lab_data.id_prestation = " . $idPresta . " and lab_data.id_payment = " . $idPayment . "
        join payment_category_parametre ON payment_category_parametre.idpara = lab_data.id_para order by payment_category_parametre.idpara ASC");
        return $query->result();
    }

    function getParamPrestationJsonPatient($patient, $idPresta, $idPayment)
    {
        $query = $this->db->query("select payment_category_parametre.idpara,payment_category_parametre.nom_parametre,lab_data.resultats,payment_category_parametre.unite,payment_category_parametre.valeurs from lab_data 
        join lab ON lab.id = lab_data.id_lab and lab_data.id_prestation = " . $idPresta . "
        join payment_category_parametre ON payment_category_parametre.idpara = lab_data.id_para and lab.patient = " . $patient . " order by payment_category_parametre.idpara ASC");
        return $query->result();
    }


    function getParamPrestationResultat($patient, $id_para, $id_payment)
    {
        $query = $this->db->query("select lab.date_prelevement as resultDate, lab_data.resultats from payment_category_parametre, payment_category , lab, lab_data where payment_category_parametre.id_prestation = payment_category.id  and lab.id_presta = payment_category.id and lab_data.id_lab = lab.id
        and lab.patient = " . $patient . " and lab_data.id_para = " . $id_para . " and lab.payment != " . $id_payment . " group by lab_data.id_lab order by lab_data.id_lab desc;");
        return $query->result();
    }

    function getParamPrestationResultatType($patient, $id_para, $id_payment)
    {
        $query = $this->db->query("select lab.date_prelevement as resultDate, lab_data.resultats from payment_category_parametre, payment_category , lab, lab_data where payment_category_parametre.id_prestation = payment_category.id  and lab.id_presta = payment_category.id and lab_data.id_lab = lab.id
        and lab.patient = " . $patient . " and lab_data.id_para = " . $id_para . " and lab.payment != " . $id_payment . " group by lab_data.id_lab order by lab_data.id_lab desc;");
        return $query->result();
    }

    function getParamPrestationResultatDate($patient, $id_para)
    {
        $query = $this->db->query("select lab.date_prelevement as resultDate from payment_category_parametre, payment_category , lab, lab_data where payment_category_parametre.id_prestation = payment_category.id  and lab.id_presta = payment_category.id and lab_data.id_lab = lab.id
        and lab.patient = " . $patient . " and lab_data.id_para = " . $id_para . " group by lab_data.id_lab order by lab_data.id_lab desc;");
        return $query->result();
    }
    

    function getPaymentId($id, $id_organisation)
    {
        $query = $this->db->query("select * from payment where 
        id_organisation = " . $id_organisation . "
        And id = " . $id . "");
        return $query->row();
    }

    function getPaymentIdSansOrganisation($id)
    {
        $query = $this->db->query("select * from payment where 
         id = " . $id . "");
        return $query->row();
    }




    function getPaymentBySearch($search)
    {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('amount', $search);
        $this->db->or_like('gross_total', $search);
        $this->db->or_like('patient_name', $search);
        $this->db->or_like('patient_phone', $search);
        $this->db->or_like('patient_address', $search);
        $this->db->or_like('remarks', $search);
        $this->db->or_like('doctor_name', $search);
        $this->db->or_like('flat_discount', $search);
        $this->db->or_like('date_string', $search);
        $query = $this->db->get('payment');
        return $query->result();
    }

    function getPaymentByLimit($limit, $start)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('payment');
        return $query->result();
    }

    function getGatewayByName($name)
    {
        $this->db->where('name', $name);
        $query = $this->db->get('paymentGateway')->row();
        return $query;
    }

    function getPaymentByLimitBySearch($limit, $start, $search)
    {

        $this->db->like('id', $search);
        $this->db->or_like('amount', $search);
        $this->db->or_like('gross_total', $search);
        $this->db->order_by('id', 'desc');
        $this->db->or_like('patient_name', $search);
        $this->db->or_like('patient_phone', $search);
        $this->db->or_like('patient_address', $search);
        $this->db->or_like('remarks', $search);
        $this->db->or_like('doctor_name', $search);
        $this->db->or_like('flat_discount', $search);
        $this->db->or_like('date_string', $search);
        $this->db->limit($limit, $start);
        $query = $this->db->get('payment');
        return $query->result();
    }

    function getPaymentById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('payment');
        return $query->row();
    }
    function getPaymentByCode($id)
    {
        $this->db->where('code', $id);
        $query = $this->db->get('payment');
        return $query->row();
    }
    function getPaymentByPatientId($id)
    {
        $this->db->query("SET time_zone = '+00:00';");
        $query = $this->db->query("select payment.*, DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(`date`),@@session.time_zone, '+00:00'), '%d/%m/%y %H:%i') as formeTimes from payment
        WHERE payment.patient = " . $id . "
        and bulletinAnalyse = ''
        order by id desc");
        return $query->result();
    }

    function getPaymentByPatientIdByDate($id, $date_from, $date_to)
    {
        $this->db->query("SET time_zone = '+00:00';");
        if (!empty($date_from) && !empty($date_to)) {
            $sql = "select payment.* , DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(`date`),@@session.time_zone, '+00:00'), '%d/%m/%y %H:%i') as formeTimes from payment
        WHERE payment.patient = " . $id . "
        AND payment.bulletinAnalyse = ''
        AND payment.date >= " . $date_from . "
        AND payment.date <= " . $date_to . "
        order by id desc";
        } else if (!empty($date_from) && empty($date_to)) {
            $sql = "select payment.* , DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(`date`),@@session.time_zone, '+00:00'), '%d/%m/%y %H:%i') as formeTimes from payment
        WHERE payment.patient = " . $id . "
        AND payment.bulletinAnalyse = ''
        AND payment.date >= " . $date_from . "
        order by id desc";
        } else if (!empty($date_to)  && empty($date_from)) {
            $sql = "select payment.* , DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(`date`),@@session.time_zone, '+00:00'), '%d/%m/%y %H:%i') as formeTimes from payment
        WHERE payment.patient = " . $id . "
        AND payment.bulletinAnalyse = ''
        AND payment.date <= " . $date_to . "
        order by id desc";
        } else {
            $sql = "select payment.* , DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(`date`),@@session.time_zone, '+00:00'), '%d/%m/%y %H:%i') as formeTimes from payment
        WHERE payment.patient = " . $id . " 
        AND payment.bulletinAnalyse = ''
        order by id desc";
        }
        // var_dump($sql);
        /* var_dump("select payment.*, DATE_FORMAT(FROM_UNIXTIME(`date`), DATE_FORMAT(CONVERT_TZ(FROM_UNIXTIME(`date`),@@session.time_zone, '+00:00'), '%d/%m/%y %H:%i') as formeTimes from payment
        WHERE payment.patient = " . $id . "
        AND payment.date >= " .$date_from. "
        AND payment.date <= " .$date_to. "
        order by id desc");*/
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getPaymentByUserId($id)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('user', $id);
        $query = $this->db->get('payment');
        return $query->result();
    }

    function thisMonthPayment($id_organisation)
    {
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('patient_deposit')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('m/Y', time()) == date('m/Y', $q->date)) {
                $total[] = $q->deposited_amount;
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisMonthExpense($id_organisation)
    {
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('expense')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('m/Y', time()) == date('m/Y', $q->date)) {
                $total[] = $q->amount;
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisMonthAppointment($id_organisation, $id_serviceUser = '')
    {
        $this->db->where('id_organisation', $id_organisation);
        if ($id_serviceUser) {
            $this->db->where('service', $id_serviceUser);
        }
        $query = $this->db->get('appointment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('m/Y', time()) == date('m/Y', $q->date)) {
                $total[] = '1';
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisDayPayment($id_organisation)
    {
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('patient_deposit')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('d/m/Y', time()) == date('d/m/Y', $q->date)) {
                $total[] = $q->deposited_amount;
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisDayExpense($id_organisation)
    {
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('expense')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('d/m/Y', time()) == date('d/m/Y', $q->date)) {
                $total[] = $q->amount;
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisDayAppointment($id_organisation, $id_serviceUser = '')
    {
        $this->db->where('id_organisation', $id_organisation);
        if ($id_serviceUser) {
            $this->db->where('service', $id_serviceUser);
        }
        $query = $this->db->get('appointment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('d/m/Y', time()) == date('d/m/Y', $q->date)) {
                $total[] = '1';
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisYearPayment($id_organisation)
    {
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('patient_deposit')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('Y', time()) == date('Y', $q->date)) {
                $total[] = $q->deposited_amount;
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisYearExpense($id_organisation)
    {
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('expense')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('Y', time()) == date('Y', $q->date)) {
                $total[] = $q->amount;
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisYearAppointment($id_organisation, $id_serviceUser = '')
    {
        $this->db->where('id_organisation', $id_organisation);
        if ($id_serviceUser) {
            $this->db->where('service', $id_serviceUser);
        }
        $query = $this->db->get('appointment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('Y', time()) == date('Y', $q->date)) {
                $total[] = '1';
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisMonthAppointmentTreated($id_organisation, $id_serviceUser = '')
    {
        $this->db->where('id_organisation', $id_organisation);
        if ($id_serviceUser) {
            $this->db->where('service', $id_serviceUser);
        }
        $query = $this->db->get('appointment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('m/Y', time()) == date('m/Y', $q->date)) {
                if ($q->status == 'Treated') {
                    $total[] = '1';
                }
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function thisMonthAppointmentCancelled($id_organisation, $id_serviceUser = '')
    {
        $this->db->where('id_organisation', $id_organisation);
        if ($id_serviceUser) {
            $this->db->where('service', $id_serviceUser);
        }
        $query = $this->db->get('appointment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('m/Y', time()) == date('m/Y', $q->date)) {
                if ($q->status == 'Cancelled') {
                    $total[] = '1';
                }
            }
        }
        if (!empty($total)) {
            return array_sum($total);
        } else {
            return 0;
        }
    }

    function getPaymentPerMonthThisYear($id_organisation)
    {
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('payment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('Y', time()) == date('Y', $q->date)) {
                if (date('m', $q->date) == '01') {
                    $total['january'][] = $q->amount_received;
                }
                if (date('m', $q->date) == '02') {
                    $total['february'][] = $q->amount_received;
                }
                if (date('m', $q->date) == '03') {
                    $total['march'][] = $q->amount_received;
                }
                if (date('m', $q->date) == '04') {
                    $total['april'][] = $q->amount_received;
                }
                if (date('m', $q->date) == '05') {
                    $total['may'][] = $q->amount_received;
                }
                if (date('m', $q->date) == '06') {
                    $total['june'][] = $q->amount_received;
                }
                if (date('m', $q->date) == '07') {
                    $total['july'][] = $q->amount_received;
                }
                if (date('m', $q->date) == '08') {
                    $total['august'][] = $q->amount_received;
                }
                if (date('m', $q->date) == '09') {
                    $total['september'][] = $q->amount_received;
                }
                if (date('m', $q->date) == '10') {
                    $total['october'][] = $q->amount_received;
                }
                if (date('m', $q->date) == '11') {
                    $total['november'][] = $q->amount_received;
                }
                if (date('m', $q->date) == '12') {
                    $total['december'][] = $q->amount_received;
                }
            }
        }


        if (!empty($total['january'])) {
            $total['january'] = array_sum($total['january']);
        } else {
            $total['january'] = 0;
        }
        if (!empty($total['february'])) {
            $total['february'] = array_sum($total['february']);
        } else {
            $total['february'] = 0;
        }
        if (!empty($total['march'])) {
            $total['march'] = array_sum($total['march']);
        } else {
            $total['march'] = 0;
        }
        if (!empty($total['april'])) {
            $total['april'] = array_sum($total['april']);
        } else {
            $total['april'] = 0;
        }
        if (!empty($total['may'])) {
            $total['may'] = array_sum($total['may']);
        } else {
            $total['may'] = 0;
        }
        if (!empty($total['june'])) {
            $total['june'] = array_sum($total['june']);
        } else {
            $total['june'] = 0;
        }
        if (!empty($total['july'])) {
            $total['july'] = array_sum($total['july']);
        } else {
            $total['july'] = 0;
        }
        if (!empty($total['august'])) {
            $total['august'] = array_sum($total['august']);
        } else {
            $total['august'] = 0;
        }
        if (!empty($total['september'])) {
            $total['september'] = array_sum($total['september']);
        } else {
            $total['september'] = 0;
        }
        if (!empty($total['october'])) {
            $total['october'] = array_sum($total['october']);
        } else {
            $total['october'] = 0;
        }
        if (!empty($total['november'])) {
            $total['november'] = array_sum($total['november']);
        } else {
            $total['november'] = 0;
        }
        if (!empty($total['december'])) {
            $total['december'] = array_sum($total['december']);
        } else {
            $total['december'] = 0;
        }

        return $total;
    }

    function getExpensePerMonthThisYear($id_organisation)
    {
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('expense')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('Y', time()) == date('Y', $q->date)) {
                if (date('m', $q->date) == '01') {
                    $total['january'][] = $q->amount;
                }
                if (date('m', $q->date) == '02') {
                    $total['february'][] = $q->amount;
                }
                if (date('m', $q->date) == '03') {
                    $total['march'][] = $q->amount;
                }
                if (date('m', $q->date) == '04') {
                    $total['april'][] = $q->amount;
                }
                if (date('m', $q->date) == '05') {
                    $total['may'][] = $q->amount;
                }
                if (date('m', $q->date) == '06') {
                    $total['june'][] = $q->amount;
                }
                if (date('m', $q->date) == '07') {
                    $total['july'][] = $q->amount;
                }
                if (date('m', $q->date) == '08') {
                    $total['august'][] = $q->amount;
                }
                if (date('m', $q->date) == '09') {
                    $total['september'][] = $q->amount;
                }
                if (date('m', $q->date) == '10') {
                    $total['october'][] = $q->amount;
                }
                if (date('m', $q->date) == '11') {
                    $total['november'][] = $q->amount;
                }
                if (date('m', $q->date) == '12') {
                    $total['december'][] = $q->amount;
                }
            }
        }


        if (!empty($total['january'])) {
            $total['january'] = array_sum($total['january']);
        } else {
            $total['january'] = 0;
        }
        if (!empty($total['february'])) {
            $total['february'] = array_sum($total['february']);
        } else {
            $total['february'] = 0;
        }
        if (!empty($total['march'])) {
            $total['march'] = array_sum($total['march']);
        } else {
            $total['march'] = 0;
        }
        if (!empty($total['april'])) {
            $total['april'] = array_sum($total['april']);
        } else {
            $total['april'] = 0;
        }
        if (!empty($total['may'])) {
            $total['may'] = array_sum($total['may']);
        } else {
            $total['may'] = 0;
        }
        if (!empty($total['june'])) {
            $total['june'] = array_sum($total['june']);
        } else {
            $total['june'] = 0;
        }
        if (!empty($total['july'])) {
            $total['july'] = array_sum($total['july']);
        } else {
            $total['july'] = 0;
        }
        if (!empty($total['august'])) {
            $total['august'] = array_sum($total['august']);
        } else {
            $total['august'] = 0;
        }
        if (!empty($total['september'])) {
            $total['september'] = array_sum($total['september']);
        } else {
            $total['september'] = 0;
        }
        if (!empty($total['october'])) {
            $total['october'] = array_sum($total['october']);
        } else {
            $total['october'] = 0;
        }
        if (!empty($total['november'])) {
            $total['november'] = array_sum($total['november']);
        } else {
            $total['november'] = 0;
        }
        if (!empty($total['december'])) {
            $total['december'] = array_sum($total['december']);
        } else {
            $total['december'] = 0;
        }

        return $total;
    }

    function getOtPaymentByPatientId($id)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $id);
        $query = $this->db->get('ot_payment');
        return $query->result();
    }

    function getOtPaymentByUserId($id)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('user', $id);
        $query = $this->db->get('ot_payment');
        return $query->result();
    }

    function insertDeposit($data)
    {
        $this->db->insert('patient_deposit', $data);
    }

    function getExecuteUser($id)
    {
        $this->db->where('id_payment', $id);
        $query = $this->db->get('execute_user');
        return $query->row();
    }


    function insertExecute_user($data)
    {
        $this->db->insert('execute_user', $data);
    }

    function insertDepositOM($data)
    {
        $this->db->insert('statut_deposit_om', $data);
    }

    function getDeposit()
    {
        $query = $this->db->get('patient_deposit');
        return $query->result();
    }

    function updateDeposit($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('patient_deposit', $data);
    }

    function updateRenseignementClinique($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('payment', $data);
    }

    function updateOrganisationLight($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('organisation', $data);
    }

    function getDepositById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('patient_deposit');
        return $query->row();
    }

    function getDepositByInvoiceId($id)
    {
        $this->db->where('payment_id', $id);
        $query = $this->db->get('patient_deposit');
        return $query->row();
    }

    function getDepositByPatientId($id)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $id);
        $query = $this->db->get('patient_deposit');
        return $query->result();
    }

    function getDepositByPatientIdByDate($id, $date_from, $date_to)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('patient', $id);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get('patient_deposit');
        return $query->result();
    }

    function getDepositByUserId($id)
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('user', $id);
        $query = $this->db->get('patient_deposit');
        return $query->result();
    }

    function deleteDeposit($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('patient_deposit');
    }

    function deleteDepositByInvoiceId($id)
    {
        $this->db->where('payment_id', $id);
        //$this->db->delete('patient_deposit');
        $this->db->update('patient_deposit', array('status' => 'cancelled'));
    }

    function getPendingPaymentByPatientId($id)
    {
        $this->db->where('patient', $id);
        $this->db->where('status', 'pending');
        $query = $this->db->get('payment');
        return $query->result();
    }

    function getStatusPaymentByPatientId($id, $status)
    {
        $this->db->where('patient', $id);
        $this->db->where('status', $status);
        $query = $this->db->get('payment');
        return $query->result();
    }

    // function getPendingPrestationsByPatientId($id) {
    // // $this->db->where('patient', $id);
    // // $this->db->where('status', 'pending');
    // $query = $this->db->query("select payment.* from payment where status='pending' and patient=".$id);
    // return $query->result();
    // }

    function getPaymentByPatientIdByStatus($id)
    {
        $this->db->where('patient', $id);
        $this->db->where('status', 'unpaid');
        $query = $this->db->get('payment');
        return $query->result();
    }

    function getOtPaymentByPatientIdByStatus($id)
    {
        $this->db->where('patient', $id);
        $this->db->where('status', 'unpaid');
        $query = $this->db->get('ot_payment');
        return $query->result();
    }

    function updatePayment($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('payment', $data);
    }

    function updatePaymentByCode($id, $data)
    {
        $this->db->where('code', $id);
        $this->db->update('payment', $data);
    }
    function insertOtPayment($data)
    {
        $this->db->insert('ot_payment', $data);
    }

    function getOtPayment()
    {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('ot_payment');
        return $query->result();
    }

    function getOtPaymentById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('ot_payment');
        return $query->row();
    }

    function updateOtPayment($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('ot_payment', $data);
    }

    function deleteOtPayment($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('ot_payment');
    }

    function addRemoveInsuranceCoverage($id_partenariat, $id_payment_category, $status)
    {
        if ($status == 1) { // Si now couverte: on supprime de la table des exceptions
            $array = array('id_partenariat_sante_assurance' => $id_partenariat, 'id_payment_category' => $id_payment_category);
            $this->db->where($array);
            $this->db->delete('sante_assurance_prestation');
        } else { // Sinon: on insere
            $data = array(
                'id_partenariat_sante_assurance' => $id_partenariat,
                'id_payment_category' => $id_payment_category,
                'est_couverte' => 0
            );
            $this->db->insert('sante_assurance_prestation', $data);
        }
    }

    function insertPaymentCategory($data)
    {
        $this->db->insert('payment_category', $data);
    }

    function insertInsurance($data)
    {

        $query = $this->db->insert('partenariat_sante_assurance', $data);
        if ($this->db->affected_rows() > 0) {
            return "ok";
        } else {
            $e = $this->db->error();
            return "Erreur " . $e['message'] . " " . $e["code"];
        }
    }

    function getInsuranceCoverage($id_partenariat, $id_organisation)
    {
        // $query = $this->db->get('payment_category');
        // $query = $this->db->query("select payment_category.id, payment_category.prestation, payment_category.description, payment_category.tarif_public, payment_category.tarif_professionnel, payment_category.tarif_assurance, setting_service.name_service, (CASE WHEN sante_assurance_prestation.est_couverte IS NULL THEN '1' ELSE '0' END) as est_couverte from payment_category join setting_service on payment_category.id_service = setting_service.idservice join department on department.id = setting_service.id_department and department.id_organisation = " . $id_organisation . " left join sante_assurance_prestation on sante_assurance_prestation.id_partenariat_sante_assurance = " . $id_partenariat . " AND sante_assurance_prestation.id_payment_category = payment_category.id order by payment_category.id desc");
        $query = $this->db->query("select payment_category.id, payment_category.prestation, payment_category.description, payment_category_organisation.tarif_public, payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance,payment_category_organisation.tarif_ipm, setting_service.name_service, setting_service_specialite.name_specialite, (CASE WHEN sante_assurance_prestation.est_couverte IS NULL THEN '1' ELSE '0' END) as est_couverte from payment_category_organisation join payment_category on payment_category.id = payment_category_organisation.id_presta and payment_category_organisation.id_organisation = " . $id_organisation . " join setting_service on payment_category.id_service = setting_service.idservice join setting_service_specialite on setting_service_specialite.idspe = payment_category.id_spe left join sante_assurance_prestation on sante_assurance_prestation.id_partenariat_sante_assurance = " . $id_partenariat . " AND sante_assurance_prestation.id_payment_category = payment_category.id order by payment_category.id desc");

        return $query->result();
    }


    function getPrestationAssurance($id_organisation,$id_organisation_assurance, $id_prestation)
    {
        // $query = $this->db->get('payment_category');
        // $query = $this->db->query("select payment_category.id, payment_category.prestation, payment_category.description, payment_category.tarif_public, payment_category.tarif_professionnel, payment_category.tarif_assurance, setting_service.name_service, (CASE WHEN sante_assurance_prestation.est_couverte IS NULL THEN '1' ELSE '0' END) as est_couverte from payment_category join setting_service on payment_category.id_service = setting_service.idservice join department on department.id = setting_service.id_department and department.id_organisation = " . $id_organisation . " left join sante_assurance_prestation on sante_assurance_prestation.id_partenariat_sante_assurance = " . $id_partenariat . " AND sante_assurance_prestation.id_payment_category = payment_category.id order by payment_category.id desc");
        $query = $this->db->query("SELECT id_partenariat_sante_assurance,id_payment_category, est_couverte, id, id_organisation_sante, id_organisation_assurance,partenariat_actif FROM sante_assurance_prestation JOIN `partenariat_sante_assurance` ON partenariat_sante_assurance.id = sante_assurance_prestation.id_partenariat_sante_assurance where id_organisation_assurance=" . $id_organisation_assurance . " And id_organisation_sante=" . $id_organisation . " AND id_payment_category=" . $id_prestation . "");

        return $query->row();
    }

    function getTransactionStatus($id_payment)
    {
        $query = $this->db->query("select * from transactions where id_payment = " . $id_payment . "");
        return $query->result();
    }


    function getListeFacturesDisponible($id_organisation)
    {
        $query = $this->db->query("select payment.date, transactions.id, payment_category.prestation,organisation.nom,patient.name, patient.last_name, transactions.amount from transactions
         JOIN payment ON payment.id = transactions.id_payment 
         JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
         JOIN organisation ON organisation.id = transactions.id_organisation_assurance_ipm
         JOIN patient ON patient.id = transactions.id_patient_payeur 
         where id_organisation_origine = " . $id_organisation . " AND Facturer ='1'
UNION ALL select payment.date, transactions.id, payment_category.prestation,organisation.nom, patient.name, patient.last_name, transactions.amount from transactions 
         JOIN payment ON payment.id = transactions.id_payment 
         JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
         JOIN organisation ON organisation.id = transactions.id_organisation_origine
         JOIN patient ON patient.id = transactions.id_patient_payeur where id_organisation_destinataire = " . $id_organisation . " AND Facturer ='1'
UNION ALL select payment.date, transactions.id, payment_category.prestation,organisation.nom, patient.name, patient.last_name, transactions.amount from transactions
         JOIN payment ON payment.id = transactions.id_payment
         JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
         JOIN organisation ON organisation.id = transactions.id_organisation_light
         JOIN patient ON patient.id = transactions.id_patient_payeur 
         where id_organisation_origine = " . $id_organisation . " AND Facturer ='1'");
        return $query->result();
    }
    
    function getListeFacturesDisponibleByPartenaire($id_organisation, $id)
    {
        $query = $this->db->query("select payment.date, transactions.id, payment_category.prestation,organisation.nom,patient.name, patient.last_name, transactions.amount, transactions.id_patient_payeur from transactions
         JOIN payment ON payment.id = transactions.id_payment 
         JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
         JOIN organisation ON organisation.id = transactions.id_organisation_assurance_ipm
         JOIN patient ON patient.id = transactions.id_patient_payeur 
         where id_organisation_origine = " . $id_organisation . " AND Facturer ='1' AND id_organisation_assurance_ipm = " . $id . "
UNION ALL select payment.date, transactions.id, payment_category.prestation,organisation.nom, patient.name, patient.last_name, transactions.amount, transactions.id_patient_payeur from transactions 
         JOIN payment ON payment.id = transactions.id_payment 
         JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
         JOIN organisation ON organisation.id = transactions.id_organisation_origine
         JOIN patient ON patient.id = transactions.id_patient_payeur where id_organisation_destinataire = " . $id_organisation . " AND Facturer ='1' AND id_organisation_origine = " . $id . "
UNION ALL select payment.date, transactions.id, payment_category.prestation,organisation.nom, patient.name, patient.last_name, transactions.amount, transactions.id_patient_payeur from transactions
         JOIN payment ON payment.id = transactions.id_payment
         JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
         JOIN organisation ON organisation.id = transactions.id_organisation_light
         JOIN patient ON patient.id = transactions.id_patient_payeur 
         where id_organisation_origine = " . $id_organisation . " AND Facturer ='1' AND id_organisation_light = " . $id . "");
        return $query->result();
    }


    


    function getListeFacturesDisponibleByPatient($id_organisation, $id, $patient, $date_debut, $date_fin)
    {
        $query = $this->db->query("select id,date, transactionName,nom,name, last_name, amount, id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%Y %H:%i') as transactionDate, CONCAT('ACT00', '_', id) as transactionReference, notation, amount as toBePaid, transactionAmount from (select transactions.id,payment.date, payment_category.prestation as transactionName,organisation.nom,patient.name, patient.last_name, transactions.amount, transactions.id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%d/%m/%Y %H:%i') as transactionDate, CONCAT('ACT00', '_', transactions.id) as transactionReference, CONCAT(payment_category.cotation, '', payment_category.coefficient) as notation, transactions.amount as toBePaid, transactions.to_Pay as transactionAmount from transactions
         JOIN payment ON payment.id = transactions.id_payment 
         JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
         JOIN payment_category_organisation ON payment_category_organisation.id_presta = payment_category.id
         JOIN organisation ON organisation.id = transactions.id_organisation_assurance_ipm
         JOIN patient ON patient.id = transactions.id_patient_payeur 
         where id_organisation_origine = " . $id_organisation . " AND Facturer ='1' AND id_organisation_assurance_ipm = " . $id . " AND payment.`date` >= " . $date_debut. " AND payment.`date` <= " . $date_fin. " AND patient.id = " . $patient. "
UNION ALL select transactions.id, payment.date, payment_category.prestation as transactionName,organisation.nom, patient.name, patient.last_name, transactions.amount, transactions.id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%d/%m/%Y %H:%i') as transactionDate, CONCAT('ACT00', '_', transactions.id) as transactionReference, CONCAT(payment_category.cotation, '', payment_category.coefficient) as notation, transactions.amount as toBePaid, transactions.to_Pay as transactionAmount from transactions 
         JOIN payment ON payment.id = transactions.id_payment 
         JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
         JOIN payment_category_organisation ON payment_category_organisation.id_presta = payment_category.id
         JOIN organisation ON organisation.id = transactions.id_organisation_origine
         JOIN patient ON patient.id = transactions.id_patient_payeur where id_organisation_destinataire = " . $id_organisation . " AND Facturer ='1' AND id_organisation_origine = " . $id . "
          AND payment.`date` >= " . $date_debut. " AND payment.`date` <= " . $date_fin. " AND patient.id = " . $patient. "
UNION ALL select transactions.id, payment.date, payment_category.prestation as transactionName,organisation.nom, patient.name, patient.last_name, transactions.amount, transactions.id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%d/%m/%Y %H:%i') as transactionDate, CONCAT('ACT00', '_', transactions.id) as transactionReference, CONCAT(payment_category.cotation, '', payment_category.coefficient) as notation, transactions.amount as toBePaid, transactions.to_Pay as transactionAmount from transactions
         JOIN payment ON payment.id = transactions.id_payment
         JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
         JOIN payment_category_organisation ON payment_category_organisation.id_presta = payment_category.id
         JOIN organisation ON organisation.id = transactions.id_organisation_light
         JOIN patient ON patient.id = transactions.id_patient_payeur 
         where id_organisation_origine = " . $id_organisation . " AND Facturer ='1' AND id_organisation_light = " . $id . " AND payment.`date` >= " . $date_debut. " AND payment.`date` <= " . $date_fin. " AND patient.id = " . $patient. " ) T1 Group By id ");
        return $query->result();
    }


    function getListeFacturesDisponibleByPay($id_organisation, $id, $patient, $date_debut, $date_fin)
    {
        $query = $this->db->query("select id,date, transactionName,nom,name, last_name, amount, id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%Y %H:%i') as transactionDate, CONCAT('ACT00', '_', id) as transactionReference, notation, amount as toBePaid, transactionAmount from (select transactions.id,payment.date, payment_category.prestation as transactionName,organisation.nom,patient.name, patient.last_name, transactions.amount, transactions.id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%d/%m/%Y %H:%i') as transactionDate, CONCAT('ACT00', '_', transactions.id) as transactionReference, CONCAT(payment_category.cotation, '', payment_category.coefficient) as notation, transactions.amount as toBePaid, transactions.to_Pay as transactionAmount from transactions
         JOIN payment ON payment.id = transactions.id_payment 
         JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
         JOIN payment_category_organisation ON payment_category_organisation.id_presta = payment_category.id
         JOIN organisation ON organisation.id = transactions.id_organisation_assurance_ipm
         JOIN patient ON patient.id = transactions.id_patient_payeur 
         where id_organisation_origine = " . $id_organisation . " AND Facturer ='2' AND id_organisation_assurance_ipm = " . $id . " AND payment.`date` >= " . $date_debut. " AND payment.`date` <= " . $date_fin. " AND patient.id = " . $patient. "
UNION ALL select transactions.id, payment.date, payment_category.prestation as transactionName,organisation.nom, patient.name, patient.last_name, transactions.amount, transactions.id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%d/%m/%Y %H:%i') as transactionDate, CONCAT('ACT00', '_', transactions.id) as transactionReference, CONCAT(payment_category.cotation, '', payment_category.coefficient) as notation, transactions.amount as toBePaid, transactions.to_Pay as transactionAmount from transactions 
         JOIN payment ON payment.id = transactions.id_payment 
         JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
         JOIN payment_category_organisation ON payment_category_organisation.id_presta = payment_category.id
         JOIN organisation ON organisation.id = transactions.id_organisation_origine
         JOIN patient ON patient.id = transactions.id_patient_payeur where id_organisation_destinataire = " . $id_organisation . " AND Facturer ='2' AND id_organisation_origine = " . $id . "
          AND payment.`date` >= " . $date_debut. " AND payment.`date` <= " . $date_fin. " AND patient.id = " . $patient. "
UNION ALL select transactions.id, payment.date, payment_category.prestation as transactionName,organisation.nom, patient.name, patient.last_name, transactions.amount, transactions.id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%d/%m/%Y %H:%i') as transactionDate, CONCAT('ACT00', '_', transactions.id) as transactionReference, CONCAT(payment_category.cotation, '', payment_category.coefficient) as notation, transactions.amount as toBePaid, transactions.to_Pay as transactionAmount from transactions
         JOIN payment ON payment.id = transactions.id_payment
         JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
         JOIN payment_category_organisation ON payment_category_organisation.id_presta = payment_category.id
         JOIN organisation ON organisation.id = transactions.id_organisation_light
         JOIN patient ON patient.id = transactions.id_patient_payeur 
         where id_organisation_origine = " . $id_organisation . " AND Facturer ='2' AND id_organisation_light = " . $id . " AND payment.`date` >= " . $date_debut. " AND payment.`date` <= " . $date_fin. " AND patient.id = " . $patient. " ) T1 Group By id ");
        return $query->result();
    }

  

    function getListeFacturesDisponibleByPayCode($code)
    {
        $query = $this->db->query("select id,date, transactionName,nom,name, last_name, amount, id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%Y %H:%i') as transactionDate, CONCAT('ACT00', '_', id) as transactionReference, notation, amount as toBePaid, transactionAmount from (select transactions.id,payment.date, payment_category.prestation as transactionName,organisation.nom,patient.name, patient.last_name, transactions.amount, transactions.id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%d/%m/%Y %H:%i') as transactionDate, CONCAT('ACT00', '_', transactions.id) as transactionReference, CONCAT(payment_category.cotation, '', payment_category.coefficient) as notation, transactions.amount as toBePaid, transactions.to_Pay as transactionAmount from transactions
         JOIN payment ON payment.id = transactions.id_payment 
         JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
         JOIN payment_category_organisation ON payment_category_organisation.id_presta = payment_category.id
         JOIN organisation ON organisation.id = transactions.id_organisation_assurance_ipm
         JOIN patient ON patient.id = transactions.id_patient_payeur 
         where transactions.code_facture = '" . $code . "' 
UNION ALL select transactions.id, payment.date, payment_category.prestation as transactionName,organisation.nom, patient.name, patient.last_name, transactions.amount, transactions.id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%d/%m/%Y %H:%i') as transactionDate, CONCAT('ACT00', '_', transactions.id) as transactionReference, CONCAT(payment_category.cotation, '', payment_category.coefficient) as notation, transactions.amount as toBePaid, transactions.to_Pay as transactionAmount from transactions 
         JOIN payment ON payment.id = transactions.id_payment 
         JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
         JOIN payment_category_organisation ON payment_category_organisation.id_presta = payment_category.id
         JOIN organisation ON organisation.id = transactions.id_organisation_origine
         JOIN patient ON patient.id = transactions.id_patient_payeur where transactions.code_facture = '" . $code . "' 
UNION ALL select transactions.id, payment.date, payment_category.prestation as transactionName,organisation.nom, patient.name, patient.last_name, transactions.amount, transactions.id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%d/%m/%Y %H:%i') as transactionDate, CONCAT('ACT00', '_', transactions.id) as transactionReference, CONCAT(payment_category.cotation, '', payment_category.coefficient) as notation, transactions.amount as toBePaid, transactions.to_Pay as transactionAmount from transactions
         JOIN payment ON payment.id = transactions.id_payment
         JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
         JOIN payment_category_organisation ON payment_category_organisation.id_presta = payment_category.id
         JOIN organisation ON organisation.id = transactions.id_organisation_light
         JOIN patient ON patient.id = transactions.id_patient_payeur 
         where transactions.code_facture = '" . $code . "'  ) T1 Group By id ");
        return $query->result();
    }


    function getListeFacturesGroupByPatient($id_organisation, $id, $date_debut, $date_fin)
    {
        $query = $this->db->query("select id_patient_payeur as id_patient, name as firstName, last_name as lastName, pm_numpolice as policyNumber FROM (select transactions.id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%Y-%m-%d %H:%i') as date, transactions.id, transactions.id_patient_payeur as id_patient, payment_category.prestation,organisation.nom,patient.name, patient.last_name, transactions.amount, patient_mutuelle.pm_numpolice from transactions
        JOIN payment ON payment.id = transactions.id_payment 
        JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
        JOIN organisation ON organisation.id = transactions.id_organisation_assurance_ipm
        JOIN patient ON patient.id = transactions.id_patient_payeur 
        JOIN patient_mutuelle ON patient_mutuelle.pm_idpatent = patient.id
        where id_organisation_origine = " . $id_organisation . " AND Facturer ='1' AND id_organisation_assurance_ipm = " . $id. " AND payment.`date` >= " . $date_debut. " AND payment.`date` <= " . $date_fin. "
UNION ALL select transactions.id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%Y-%m-%d %H:%i') as date, transactions.id, transactions.id_patient_payeur,payment_category.prestation,organisation.nom, patient.name, patient.last_name, transactions.amount,' ' as pm_numpolice from transactions 
        JOIN payment ON payment.id = transactions.id_payment 
        JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
        JOIN organisation ON organisation.id = transactions.id_organisation_origine
        JOIN patient ON patient.id = transactions.id_patient_payeur
         where id_organisation_destinataire = " . $id_organisation . " AND Facturer ='1' AND id_organisation_origine = " . $id. " AND payment.`date` >= " . $date_debut. " AND payment.`date` <= " . $date_fin. "
UNION ALL select transactions.id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%Y-%m-%d %H:%i') as date, transactions.id, transactions.id_patient_payeur, payment_category.prestation,organisation.nom, patient.name, patient.last_name, transactions.amount, ' ' as pm_numpolice from transactions
        JOIN payment ON payment.id = transactions.id_payment
        JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
        JOIN organisation ON organisation.id = transactions.id_organisation_light
        JOIN patient ON patient.id = transactions.id_patient_payeur 
        where id_organisation_origine = " . $id_organisation . " AND Facturer ='1' AND id_organisation_light = " . $id. " AND payment.`date` >= " . $date_debut. " AND payment.`date` <= " . $date_fin. ") T1 Group By id_patient_payeur");
       
        return $query->result();
    }   


    function getListeFacturesGroupByPay($id_organisation, $id, $date_debut, $date_fin)
    {
        $query = $this->db->query("select id_patient_payeur as id_patient, name as firstName, last_name as lastName, pm_numpolice as policyNumber FROM (select transactions.id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%Y-%m-%d %H:%i') as date, transactions.id, transactions.id_patient_payeur as id_patient, payment_category.prestation,organisation.nom,patient.name, patient.last_name, transactions.amount, patient_mutuelle.pm_numpolice from transactions
        JOIN payment ON payment.id = transactions.id_payment 
        JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
        JOIN organisation ON organisation.id = transactions.id_organisation_assurance_ipm
        JOIN patient ON patient.id = transactions.id_patient_payeur 
        JOIN patient_mutuelle ON patient_mutuelle.pm_idpatent = patient.id
        where id_organisation_origine = " . $id_organisation . " AND Facturer ='2' AND id_organisation_assurance_ipm = " . $id. " AND payment.`date` >= " . $date_debut. " AND payment.`date` <= " . $date_fin. "
UNION ALL select transactions.id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%Y-%m-%d %H:%i') as date, transactions.id, transactions.id_patient_payeur,payment_category.prestation,organisation.nom, patient.name, patient.last_name, transactions.amount,' ' as pm_numpolice from transactions 
        JOIN payment ON payment.id = transactions.id_payment 
        JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
        JOIN organisation ON organisation.id = transactions.id_organisation_origine
        JOIN patient ON patient.id = transactions.id_patient_payeur
         where id_organisation_destinataire = " . $id_organisation . " AND Facturer ='2' AND id_organisation_origine = " . $id. " AND payment.`date` >= " . $date_debut. " AND payment.`date` <= " . $date_fin. "
UNION ALL select transactions.id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%Y-%m-%d %H:%i') as date, transactions.id, transactions.id_patient_payeur, payment_category.prestation,organisation.nom, patient.name, patient.last_name, transactions.amount, ' ' as pm_numpolice from transactions
        JOIN payment ON payment.id = transactions.id_payment
        JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
        JOIN organisation ON organisation.id = transactions.id_organisation_light
        JOIN patient ON patient.id = transactions.id_patient_payeur 
        where id_organisation_origine = " . $id_organisation . " AND Facturer ='2' AND id_organisation_light = " . $id. " AND payment.`date` >= " . $date_debut. " AND payment.`date` <= " . $date_fin. ") T1 Group By id_patient_payeur");
       
        return $query->result();
    } 


    function getListeFacturesGroupByPayCode($code)
    {
        $query = $this->db->query("select id_patient_payeur as id_patient, name as firstName, last_name as lastName, pm_numpolice as policyNumber FROM (select transactions.id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%Y-%m-%d %H:%i') as date, transactions.id, transactions.id_patient_payeur as id_patient, payment_category.prestation,organisation.nom,patient.name, patient.last_name, transactions.amount, patient_mutuelle.pm_numpolice from transactions
        JOIN payment ON payment.id = transactions.id_payment 
        JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
        JOIN organisation ON organisation.id = transactions.id_organisation_assurance_ipm
        JOIN patient ON patient.id = transactions.id_patient_payeur 
        JOIN patient_mutuelle ON patient_mutuelle.pm_idpatent = patient.id
        where transactions.code_facture = '" . $code . "' 
UNION ALL select transactions.id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%Y-%m-%d %H:%i') as date, transactions.id, transactions.id_patient_payeur,payment_category.prestation,organisation.nom, patient.name, patient.last_name, transactions.amount,' ' as pm_numpolice from transactions 
        JOIN payment ON payment.id = transactions.id_payment 
        JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
        JOIN organisation ON organisation.id = transactions.id_organisation_origine
        JOIN patient ON patient.id = transactions.id_patient_payeur
         where transactions.code_facture = '" . $code . "' 
UNION ALL select transactions.id_patient_payeur, DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%Y-%m-%d %H:%i') as date, transactions.id, transactions.id_patient_payeur, payment_category.prestation,organisation.nom, patient.name, patient.last_name, transactions.amount, ' ' as pm_numpolice from transactions
        JOIN payment ON payment.id = transactions.id_payment
        JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation
        JOIN organisation ON organisation.id = transactions.id_organisation_light
        JOIN patient ON patient.id = transactions.id_patient_payeur 
        where transactions.code_facture = '" . $code . "' ) T1 Group By id_patient_payeur");
       
        return $query->result();
    } 

    function updateTransactionStatus($id_prestation, $payment, $data) {
        $this->db->where('id_prestation_organisation', $id_prestation);
        $this->db->where('id_payment', $payment);
        $this->db->update('transactions', $data);
    }

    function updateTransactions($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('transactions', $data);
    }

    function updatePaymentPro($id, $data) {
        $this->db->where('idpro', $id);
        $this->db->update('payment_pro', $data);
    }



    function updateTransactionFacturer($payment, $data) {
        $this->db->where('id_payment', $payment);
        $this->db->where('status', 'VALIDÉ');
        $this->db->update('transactions', $data);
    }

    function getPatientAssurance($id_organisation,$id_organisation_assurance, $id_patient)
    {
        // $query = $this->db->get('payment_category');
        // $query = $this->db->query("select payment_category.id, payment_category.prestation, payment_category.description, payment_category.tarif_public, payment_category.tarif_professionnel, payment_category.tarif_assurance, setting_service.name_service, (CASE WHEN sante_assurance_prestation.est_couverte IS NULL THEN '1' ELSE '0' END) as est_couverte from payment_category join setting_service on payment_category.id_service = setting_service.idservice join department on department.id = setting_service.id_department and department.id_organisation = " . $id_organisation . " left join sante_assurance_prestation on sante_assurance_prestation.id_partenariat_sante_assurance = " . $id_partenariat . " AND sante_assurance_prestation.id_payment_category = payment_category.id order by payment_category.id desc");
        $query = $this->db->query("select * from patient_mutuelle where id_organisation=" . $id_organisation . " And pm_idpatent=" . $id_patient . " AND pm_idmutuelle=" . $id_organisation_assurance . "");

        return $query->row();
    }

    function getTypeTiersPayant($id_partenariat)
    {
        $query = $this->db->query("select organisation.type from partenariat_sante_assurance join organisation on organisation.id = partenariat_sante_assurance.id_organisation_assurance and partenariat_sante_assurance.id = " . $id_partenariat);
        return $query->row();
    }

    
    function getPaymentCategory()
    {
        // $query = $this->db->get('payment_category');
        $query = $this->db->query("select payment_category.id, payment_category.prestation, payment_category.description, payment_category.tarif_public, payment_category.tarif_professionnel, payment_category.tarif_assurance, setting_service.name_service from payment_category join setting_service on payment_category.id_service = setting_service.idservice where payment_category.prestation not like 'Frais de Service' order by id desc");
        return $query->result();
    }

    function getTiersPayantByOrganisation($id_organisation_sante)
    {
        // $query = $this->db->get('payment_category');
        $query = $this->db->query("select partenariat_sante_assurance.id as idPartenariat, organisation.id as idTiersPayant, organisation.nom as nomTiersPayant, organisation.nom_commercial as nomCommercialTiersPayant, organisation.path_logo as pathLogoTiersPayant, organisation.adresse as adresseTiersPayant, organisation.region as regionTiersPayant, organisation.departement as departementTiersPayant, organisation.arrondissement as arrondissementTiersPayant, organisation.collectivite as collectiviteTiersPayant, organisation.pays as paysTiersPayant, organisation.email as emailTiersPayant, organisation.type as typeTiersPayant, partenariat_sante_assurance.partenariat_actif from partenariat_sante_assurance join organisation on organisation.id = partenariat_sante_assurance.id_organisation_assurance and partenariat_sante_assurance.id_organisation_sante = " . $id_organisation_sante . " where organisation.est_active = 1 order by partenariat_sante_assurance.id desc");
        return $query->result();
    }

    function getAssurances()
    {
        $this->db->where('type', "Assurance");
        $query = $this->db->get('organisation');
        return $query->result();
    }

    function getFacturePartenaires($id_organisation)
    {
        $query = $this->db->query("select organisation.nom,(select organisation.nom from organisation where organisation.id = payment_pro.id_organisation_destinataire limit 1) as destinataire, payment_pro.* from payment_pro join organisation on organisation.id = payment_pro.id_organisation where payment_pro.id_organisation = ".$id_organisation." UNION ALL select organisation.nom, (select organisation.nom from organisation where organisation.id = payment_pro.id_organisation limit 1) as destinataire, payment_pro.* from payment_pro join organisation on organisation.id = payment_pro.id_organisation_destinataire where payment_pro.id_organisation_destinataire = ".$id_organisation."");
        return $query->result();
    }


    function getPartenaireFacture($id)
    {
        $this->db->where('codefacture', $id);
        $query = $this->db->get('payment_pro');
        return $query->row();
    }


    function getAssurancesNonEncorePartenaire($id_organisation)
    {
        $query = $this->db->query("select organisation.* from organisation left join partenariat_sante_assurance on partenariat_sante_assurance.id_organisation_assurance = organisation.id and partenariat_sante_assurance.id_organisation_sante = " . $id_organisation . " WHERE partenariat_sante_assurance.id_organisation_assurance IS NULL and (organisation.type='Assurance' OR organisation.type='IPM')");
        return $query->result();
    }

    function getPaymentCategoryByOrganisation($id_organisation)
    {
        // $query = $this->db->get('payment_category');
        $query = $this->db->query("select payment_category.id, payment_category.prestation, payment_category.description, payment_category.tarif_public, payment_category.tarif_professionnel, payment_category.tarif_assurance, payment_category.tarif_ipm,setting_service.name_service "
            . " from payment_category"
            . " join setting_service on payment_category.id_service = setting_service.idservice "
            . " join department on department.id = setting_service.id_department and department.id_organisation = " . $id_organisation . ""
            . " order by id desc");
        return $query->result();
    }

    function getSettingService()
    {
        $query = $this->db->get('setting_service');
        return $query->result();
    }

    function getSettingServiceByOrganisation($id_organisation, $id_service = null)
    {
        $setting_service = 'setting_service';
        $setting_department = 'department';
        $this->db->select('*');
        $this->db->from($setting_service);
        $this->db->join($setting_department, $setting_department . '.id=' . $setting_service . '.id_department', 'left');
        $this->db->join("organisation", "organisation.id = department.id_organisation AND organisation.id = " . $id_organisation);
        if ($id_service) {
            $this->db->where($setting_service . '.idservice', $id_service);
        }
        $this->db->like($setting_service . '.status_service', 1);

        $this->db->order_by($setting_service . '.idservice', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getPaymentCategoryById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('payment_category');
        return $query->row();
    }

    function getDoctorCommissionByCategory($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('payment_category');
        return $query->row();
    }

    function updatePaymentCategory($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('payment_category', $data);
    }

    function updatePaymentTransfert($id, $data)
    {
        $this->db->where('codefacture', $id);
        $this->db->update('payment_pro', $data);
    }

    function deletePayment($id)
    {
        $this->db->where('id', $id);
        //$this->db->delete('payment');
        $this->db->update('payment', array('status' => 'cancelled'));
    }

    function deletePaymentCategory($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('payment_category');
    }

    function insertExpense($data)
    {
        $this->db->insert('expense', $data);
    }

    function insertFileSend($data)
    {
        $this->db->insert('file_sent', $data);
    }


    function getFileSend($id_payment)
    {
        $this->db->where('id_payment', $id_payment);
        $query = $this->db->get('file_sent');
        return $query->row();
    }

    function insertPaymentPro($data)
    {
        $this->db->insert('payment_pro', $data);
    }

    function insertServiceCategory($data)
    {
        $this->db->insert('service_category', $data);
    }

    function getExpense($id_organisation)
    {

        $query = $this->db->query("select expense.* from expense where expense.id_organisation = '" . $id_organisation . "' order by expense.id desc");
        return $query->result();


        // $this->db->where('id_organisation', $id_organisation);
        // $this->db->order_by('id', 'desc');
        // $query = $this->db->get('expense');
        // return $query->result();
    }

    function getExpenseBySearch($search)
    {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('amount', $search);
        $this->db->or_like('datestring', $search);
        $this->db->or_like('category', $search);
        $query = $this->db->get('expense');
        return $query->result();
    }

    function getExpenseByLimit($limit, $start)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('expense');
        return $query->result();
    }

    function getExpenseByLimitBySearch($limit, $start, $search)
    {

        $this->db->like('id', $search);
        $this->db->or_like('amount', $search);
        $this->db->order_by('id', 'desc');
        $this->db->or_like('datestring', $search);
        $this->db->or_like('category', $search);
        $this->db->limit($limit, $start);
        $query = $this->db->get('expense');
        return $query->result();
    }

    function getExpenseById($id)
    {
        $query = $this->db->query("select expense.id,expense.category,expense.beneficiaire,expense.date,expense.heure,expense.note,expense.amount,expense.`user`,expense.datestring,
        expense.`status`,expense.numeroTransaction,expense.numeroFacture,expense.referenceClient,expense.codeType,expense.codeFacture,users.first_name,users.last_name
        from expense 
        join users on users.id = expense.user
        where expense.id = " . $id . "");
        return $query->row();
    }

    function getFacturePro($id)
    {
        $query = $this->db->query("select * from payment_pro where codefacture = '" . $id . "'");
       
        return $query->row();
    }


    function getOrganisationById($id)
    {
        $query = $this->db->query("select * from organisation where id = " . $id . "");
        return $query->row();
    }
    function getOrganisationByLightId($id)
    {
        $query = $this->db->query("select * from partenariat_sante where idp = " . $id . "");
        return $query->row();
    }

    function getExpenseBySuperUsers($id)
    {
        $query = $this->db->query("select expense.id,expense.category,expense.beneficiaire,expense.date,expense.heure,expense.note,expense.amount,expense.`user`,expense.datestring,
        expense.`status`,expense.numeroTransaction,expense.numeroFacture,expense.referenceClient,expense.codeType,expense.codeFacture,superusers.first_name,superusers.last_name
        from expense 
        join superusers on superusers.id = expense.user
        where expense.id = " . $id . "");
        return $query->row();
    }

    function updateExpense($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('expense', $data);
    }

    function updateOrganisation($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('organisation', $data);
    }

    function updatePartenaire($id, $data)
    {
        $this->db->where('idp', $id);
        $this->db->update('partenariat_sante', $data);
    }

    function insertExpenseCategory($data)
    {
        $this->db->insert('expense_category', $data);
    }

    function insertTypePrelevement($data)
    {
        $this->db->insert('type_prelevement', $data);
    }

    function getExpenseCategory($id_organisation)
    {
        $this->db->where('status', 1);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('expense_category');
        return $query->result();
    }


    function getServiceCategory($id_organisation)
    {
        $this->db->where('status', 1);
        $this->db->where('id_organisation', $id_organisation);
        $query = $this->db->get('service_category');
        return $query->result();
    }

    function getExpenseCategoryById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('expense_category');
        return $query->row();
    }


    function getServiceCategoryById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('service_category');
        return $query->row();
    }

    function updateExpenseCategory($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('expense_category', $data);
    }

    function updateServiceCategory($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('service_category', $data);
    }

    function updateTypePrelevement($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('type_prelevement', $data);
    }

    function deleteExpense($id)
    {
        $this->db->where('id', $id);
        $this->db->update('expense', array('status' => NULL));
        //$this->db->delete('expense');
    }

    function deleteExpenseCategory($id)
    {
        $this->db->where('id', $id);
        //$this->db->delete('expense_category');
        $this->db->update('expense_category', array('status' => NULL));
    }

    function getDiscountType()
    {
        $query = $this->db->get('settings');
        return $query->row()->discount;
    }

    function getPaymentByDoctor($doctor)
    {
        $this->db->select('*');
        $this->db->from('payment');
        $this->db->where('doctor', $doctor);
        $query = $this->db->get();
        return $query->result();
    }

    function getDepositAmountByPaymentId($payment_id)
    {
        $this->db->select('*');
        $this->db->from('patient_deposit');
        $this->db->where('payment_id', $payment_id);
        $query = $this->db->get();
        $total = array();
        $deposited_total = array();
        $total = $query->result();

        foreach ($total as $deposit) {
            $deposited_total[] = $deposit->deposited_amount;
        }

        if (!empty($deposited_total)) {
            $deposited_total = array_sum($deposited_total);
        } else {
            $deposited_total = 0;
        }

        return $deposited_total;
    }

    function getPaymentByDate($date_from, $date_to, $id_organisation)
    {
        $this->db->select('*');
        $this->db->from('patient_deposit');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $query->result();
    }

    function getPaymentByDoctorDate($doctor, $date_from, $date_to)
    {
        $this->db->select('*');
        $this->db->from('payment');
        $this->db->where('doctor', $doctor);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $query->result();
    }

    function getDepositByPaymentId($payment_id)
    {
        $this->db->select('*');
        $this->db->from('patient_deposit');
        $this->db->where('payment_id', $payment_id);
        $query = $this->db->get();
        $total = array();
        $deposited_total = array();
        $total = $query->result();
        return $total;
    }

    function getOtPaymentByDate($date_from, $date_to)
    {
        $this->db->select('*');
        $this->db->from('ot_payment');
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $query->result();
    }

    function getDepositsByDate($date_from, $date_to)
    {
        $this->db->select('*');
        $this->db->from('patient_deposit');
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $query->result();
    }

    function getExpenseByDate($date_from, $date_to, $id_organisation)
    {
        $this->db->select('*');
        $this->db->from('expense');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $query->result();
    }

    function getExpensePaymentByDate($date_from, $date_to, $id_organisation)
    {
        $this->db->select('*');
        $this->db->from('expense');
        $this->db->where('id_organisation', $id_organisation);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $query->result();
    }

    function makeStatusPaid($id, $patient_id, $data, $data1)
    {
        $this->db->where('patient', $patient_id);
        $this->db->where('status', 'paid-last');
        $this->db->update('payment', $data);
        $this->db->where('id', $id);
        $this->db->update('payment', $data1);
    }

    function makePaidByPatientIdByStatus($id, $data, $data1)
    {
        $this->db->where('patient', $id);
        $this->db->where('status', 'paid-last');
        $this->db->update('payment', $data1);

        $this->db->where('patient', $id);
        $this->db->where('status', 'paid-last');
        $this->db->update('ot_payment', $data1);

        $this->db->where('patient', $id);
        $this->db->where('status', 'unpaid');
        $this->db->update('payment', $data);

        $this->db->where('patient', $id);
        $this->db->where('status', 'unpaid');
        $this->db->update('ot_payment', $data);
    }

    function makeOtStatusPaid($id)
    {
        $this->db->where('id', $id);
        $this->db->update('ot_payment', array('status' => 'paid'));
    }

    function lastPaidInvoice($id)
    {
        $this->db->where('patient', $id);
        $this->db->where('status', 'paid-last');
        $query = $this->db->get('payment');
        return $query->result();
    }

    function lastOtPaidInvoice($id)
    {
        $this->db->where('patient', $id);
        $this->db->where('status', 'paid-last');
        $query = $this->db->get('ot_payment');
        return $query->result();
    }

    function amountReceived($id, $data)
    {
        $this->db->where('id', $id);
        $query = $this->db->update('payment', $data);
    }

    function otAmountReceived($id, $data)
    {
        $this->db->where('id', $id);
        $query = $this->db->update('ot_payment', $data);
    }

    function getThisMonth()
    {
        $payments = $this->db->get('patient_deposit')->result();
        foreach ($payments as $payment) {
            if (date('m/y', $payment->date) == date('m/y', time())) {
                $this_month_payment[] = $payment->deposited_amount;
            }
        }
        if (!empty($this_month_payment)) {
            $this_month_payment = array_sum($this_month_payment);
        } else {
            $this_month_payment = 0;
        }

        $expenses = $this->db->get('expense')->result();
        foreach ($expenses as $expense) {
            if (date('m/y', $expense->date) == date('m/y', time())) {
                $this_month_expense[] = $expense->amount;
            }
        }

        if (!empty($this_month_expense)) {
            $this_month_expense = array_sum($this_month_expense);
        } else {
            $this_month_expense = 0;
        }

        $appointments = $this->db->get('appointment')->result();
        foreach ($appointments as $appointment) {
            if (date('m/y', $appointment->date) == date('m/y', time())) {
                $this_month_appointment[] = 1;
            }
        }

        if (!empty($this_month_appointment)) {
            $this_month_appointment = array_sum($this_month_appointment);
        } else {
            $this_month_appointment = 0;
        }

        $this_month_details = array($this_month_payment, $this_month_expense, $this_month_appointment);
        return $this_month_details;
    }

    function getPaymentByUserIdByDate($user, $date_from, $date_to)
    {
        $this->db->order_by('id', 'desc');
        $this->db->select('*');
        $this->db->from('payment');
        $this->db->where('user', $user);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $query->result();
    }

    function getOtPaymentByUserIdByDate($user, $date_from, $date_to)
    {
        $this->db->order_by('id', 'desc');
        $this->db->select('*');
        $this->db->from('ot_payment');
        $this->db->where('user', $user);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $query->result();
    }

    function getDepositByUserIdByDate($user, $date_from, $date_to)
    {
        $this->db->order_by('id', 'desc');
        $this->db->select('*');
        $this->db->from('patient_deposit');
        $this->db->where('user', $user);
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $query->result();
    }

    function getDueBalanceByPatientId($patient)
    {
        $query = $this->db->get_where('payment', array('patient' => $patient->id))->result();
        $deposits = $this->db->get_where('patient_deposit', array('patient' => $patient->id))->result();
        $balance = array();
        $deposit_balance = array();
        foreach ($query as $gross) {
            $balance[] = $gross->gross_total;
        }
        $balance = array_sum($balance);


        foreach ($deposits as $deposit) {
            $deposit_balance[] = $deposit->deposited_amount;
        }
        $deposit_balance = array_sum($deposit_balance);



        $bill_balance = $balance;

        return $due_balance = $bill_balance - $deposit_balance;
    }

    function getFirstRowPaymentById()
    {

        //  $this->load->database();
        $last = $this->db->order_by('id', "asc")
            ->limit(1)
            ->get('payment')
            ->row();
        return $last;
    }

    function getFirstRowPaymentByIdByOrganisation($id_organisation)
    {

        //  $this->load->database();
        $last = $this->db->order_by('id', "asc")
            ->where("id_organisation", $id_organisation)
            ->limit(1)
            ->get('payment')
            ->row();
        return $last;
    }

    function getLastRowPaymentById()
    {

        // $this->load->database();
        $last = $this->db->order_by('id', "desc")
            ->limit(1)
            ->get('payment')
            ->row();
        return $last;
    }

    function getLastRowPaymentByIdByOrganisation($id_organisation)
    {

        // $this->load->database();
        $last = $this->db->order_by('id', "desc")
            ->where("id_organisation", $id_organisation)
            ->limit(1)
            ->get('payment')
            ->row();
        return $last;
    }

    function getPreviousPaymentById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('payment');
        return $query->previous_row();
    }

    function getPreviousPaymentByIdByOrganisation($id, $id_organisation)
    {
        $array = array('id' => $id, 'id_organisation' => $id_organisation);
        $this->db->where($array);
        $query = $this->db->get('payment');
        return $query->previous_row();
    }

    function getNextPaymentById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('payment');
        return $query->row();
    }

    function getNextPaymentByIdByOrganisation($id, $id_organisation)
    {
        $array = array('id' => $id, 'id_organisation' => $id_organisation);
        $this->db->where($array);
        $query = $this->db->get('payment');
        return $query->row();
    }

    function getIdCategoryByCode($id)
    {
        $this->db->where('code', $id);
        $query = $this->db->get('expense_category');
        return $query->row();
    }

    function editCategoryServiceByJason($id)
    {
        $this->db->where('id_service', $id);
        //$this->db->where('tarif_public is NOT NULL', NULL, FALSE);
        $query = $this->db->get('payment_category');
        return $query->result();
    }

    function editCategoryServiceByJasonParametre($id)
    {
        $payment_category = 'payment_category';
        $payment_category_parametre = 'payment_category_parametre';
        $setting_service_specialite = 'setting_service_specialite';
        $this->db->select('*');
        $this->db->from($payment_category_parametre);
        $this->db->join($setting_service_specialite, $setting_service_specialite . '.idspe=' . $payment_category_parametre . '.id_specialite', 'left');
        $this->db->order_by('idpara', 'ASC');
        //  $this->db->join($payment_category, $payment_category . '.idspe=' . $payment_category_parametre . '.id_specialite', 'left');
        $this->db->where($payment_category_parametre . '.id_prestation', $id);

        $query = $this->db->get();
        return $query->result();
    }

    function getCategoryinfoWithAddNewOption($searchTerm, $organisation)
    {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where('id_organisation', $organisation);
            $this->db->where("category like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('expense_category');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('id_organisation', $organisation);
            // $this->db->where("name like '%".$searchTerm."%' ");
            //  $this->db->or_where("id like '%".$searchTerm."%' ");
            $this->db->limit(10);
            $fetched_records = $this->db->get('expense_category');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        $data[] = array("id" => 'add_new', "text" => lang('add_new'));
        foreach ($users as $user) {
            $data[] = array("id" => $user['category'], "text" => $user['category']);
            // $data[] = array("id" => $user['id'], "text" => $user['name'] .' '.$user['last_name'] . ' ('.lang('phone').': ' . $user['phone'].')');
        }
        return $data;
    }


    function getServiceinfoWithAddNewOption($searchTerm, $organisation)
    {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where('id_organisation', $organisation);
            $this->db->where("category like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('service_category');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('id_organisation', $organisation);
            // $this->db->where("name like '%".$searchTerm."%' ");
            //  $this->db->or_where("id like '%".$searchTerm."%' ");
            $this->db->limit(10);
            $fetched_records = $this->db->get('service_category');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        $data[] = array("id" => 'add_new', "text" => lang('add_new'));
        foreach ($users as $user) {
            $data[] = array("id" => $user['montant'], "text" => $user['category'] . ' (' . $user['amount'] . ')');
            // $data[] = array("id" => $user['id'], "text" => $user['name'] .' '.$user['last_name'] . ' ('.lang('phone').': ' . $user['phone'].')');
        }
        return $data;
    }


    function getPrelevement($searchTerm, $organisation)
    {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where('id_organisation', $organisation);
            $this->db->where("category like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('type_prelevement');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('id_organisation', $organisation);
            // $this->db->where("name like '%".$searchTerm."%' ");
            //  $this->db->or_where("id like '%".$searchTerm."%' ");
            $this->db->limit(10);
            $fetched_records = $this->db->get('type_prelevement');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        $data[] = array("id" => 'add_new', "text" => lang('add_new'));
        foreach ($users as $user) {
            $data[] = array("id" => $user['category'], "text" => $user['category']);
            // $data[] = array("id" => $user['id'], "text" => $user['name'] .' '.$user['last_name'] . ' ('.lang('phone').': ' . $user['phone'].')');
        }
        return $data;
    }


    function getBeneficiaireinfoWithAddNewOption($searchTerm, $id_organisation)
    {
        if (!empty($searchTerm)) {

            $query = $this->db->query("select accountant.name,accountant.phone from accountant,users where accountant.ion_user_id = users.id and users.id_organisation = " . $id_organisation . " and accountant.name like '%" . $searchTerm . "%' or accountant.phone like '%" . $searchTerm . "%'
            UNION ALL
            select CONCAT(doctor.profession, ' ', doctor.name) as name,doctor.phone from doctor,users where doctor.ion_user_id = users.id and users.id_organisation = " . $id_organisation . " and doctor.name like '%" . $searchTerm . "%' or doctor.phone like '%" . $searchTerm . "%'
            UNION ALL
            select laboratorist.name,laboratorist.phone from laboratorist,users where laboratorist.ion_user_id = users.id and users.id_organisation = " . $id_organisation . " and laboratorist.name like '%" . $searchTerm . "%' or laboratorist.phone like '%" . $searchTerm . "%'
            UNION ALL
            select pharmacist.name,pharmacist.phone from pharmacist,users where pharmacist.ion_user_id = users.id and users.id_organisation = " . $id_organisation . " and pharmacist.name like '%" . $searchTerm . "%' or pharmacist.phone like '%" . $searchTerm . "%'
            UNION ALL
            select nurse.name,nurse.phone from nurse,users where nurse.ion_user_id = users.id and users.id_organisation = " . $id_organisation . " and nurse.name like '%" . $searchTerm . "%' or nurse.phone like '%" . $searchTerm . "%'
            UNION ALL
            select assistant.name,assistant.phone from assistant,users where assistant.ion_user_id = users.id and users.id_organisation = " . $id_organisation . " and assistant.name like '%" . $searchTerm . "%' or assistant.phone like '%" . $searchTerm . "%'
            UNION ALL
            select adminmedecin.name,adminmedecin.phone from adminmedecin,users where adminmedecin.ion_user_id = users.id and users.id_organisation = " . $id_organisation . " and adminmedecin.name like '%" . $searchTerm . "%' or adminmedecin.phone like '%" . $searchTerm . "%'
            UNION ALL
            select name,phone from beneficiaire beneficiaire.id_organisation = " . $id_organisation . " and where name like '%" . $searchTerm . "%' or phone like '%" . $searchTerm . "%'
            UNION ALL
            select receptionist.name,receptionist.phone from receptionist,users where receptionist.ion_user_id = users.id and users.id_organisation = " . $id_organisation . " and where receptionist.name like '%" . $searchTerm . "%' or receptionist.phone like '%" . $searchTerm . "%'");
            $users = $query->result_array();
        } else {
            $this->db->select('*');
            // $this->db->where("name like '%".$searchTerm."%' ");
            //  $this->db->or_where("id like '%".$searchTerm."%' ");
            // $this->db->limit(10);
            // $fetched_records = $this->db->get('receptionist');
            $query = $this->db->query("select accountant.name,accountant.phone from accountant,users where accountant.ion_user_id = users.id and users.id_organisation = " . $id_organisation . "
            UNION ALL
            select CONCAT(doctor.profession, ' ', doctor.name) as name,doctor.phone from doctor,users where doctor.ion_user_id = users.id and users.id_organisation = " . $id_organisation . "
            UNION ALL
            select laboratorist.name,laboratorist.phone from laboratorist,users where laboratorist.ion_user_id = users.id and users.id_organisation = " . $id_organisation . "
            UNION ALL
            select pharmacist.name,pharmacist.phone from pharmacist,users where pharmacist.ion_user_id = users.id and users.id_organisation = " . $id_organisation . "
            UNION ALL
            select nurse.name,nurse.phone from nurse,users where nurse.ion_user_id = users.id and users.id_organisation = " . $id_organisation . "
            UNION ALL
            select assistant.name,assistant.phone from assistant,users where assistant.ion_user_id = users.id and users.id_organisation = " . $id_organisation . "
            UNION ALL
            select CONCAT(adminmedecin.profession, ' ', adminmedecin.name) as name,adminmedecin.phone from adminmedecin,users where adminmedecin.ion_user_id = users.id and users.id_organisation = " . $id_organisation . "
            UNION ALL
            select receptionist.name,receptionist.phone from receptionist,users where receptionist.ion_user_id = users.id and users.id_organisation = " . $id_organisation . "
            UNION ALL
            select name,phone from beneficiaire where beneficiaire.id_organisation = " . $id_organisation . "");
            $users = $query->result_array();
            // $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        $data[] = array("id" => 'add_newBeneficiaire', "text" => lang('add_new'));
        foreach ($users as $user) {
            //  $data[] = array("id" => $user['name'], "text" => $user['phone']);
            $data[] = array("id" => $user['name'] . ' ' . $user['phone'], "text" => $user['name'] . ' ' . ' (' . lang('phone') . ': ' . $user['phone'] . ')');
        }
        return $data;
    }

    function insertExpenseBeneficiaire($data)
    {
        $this->db->insert('beneficiaire', $data);
    }

    function updateExpenseBeneficiaire($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('beneficiaire', $data);
    }

    function getPaymentCategoryByOrganisationById($id, $id_organisation)
    {
        // $this->db->where('payment_category.id', $id);
        $query = $this->db->query("select payment_category.id, payment_category.prestation, payment_category.description, payment_category.tarif_public, payment_category.tarif_professionnel, payment_category.tarif_assurance, setting_service.name_service from payment_category join setting_service on payment_category.id_service = setting_service.idservice join department on department.id = setting_service.id_department and department.id_organisation = " . $id_organisation . " and payment_category.id = " . $id . " order by id desc");
        return $query->row();
    }

    function getPaymentByFilter($id_organisation, $status)
    {
        // $this->db->where('id_organisation', $id_organisation);
        // $this->db->where('status', $status);
        // $query = $this->db->get('payment');
        $this->db->query("SET time_zone = '+00:00';");
        $clauseInit = $id_organisation != null && !empty($id_organisation) ? "id_organisation = " . $id_organisation : "";
        $and = !empty($clauseInit) ? " and " : "";
        $clauseInit2 = $status != null && !empty(trim($status)) ? $and . " status = \"" . $status . "\" and " : "";
        $query = $this->db->query("select *,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateFormat from payment where  " . $clauseInit . " " . $clauseInit2 . " patient is not null AND payment.bulletinAnalyse is null ");
        return $query->result();
    }

    function getPaymentExpenseByOrganisationById($id_organisation)
    {
        // $this->db->where('payment_category.id', $id);
        $this->db->query("SET time_zone = '+00:00';");
        $query = $this->db->query("select DATE_FORMAT(expense.datestring,'%y/%m/%d %H:%i') AS dateOp,DATE_FORMAT(expense.datestring, '%d/%m/%y %H:%i') AS dateFormat,expense.codeFacture AS recu,expense.beneficiaire,
         expense.category AS specialite,expense.note as libelle,expense.amount as montant,CONCAT('-',expense.amount) as concatMontant,'' as category_name,'depense' as type,
         '' as libelle_prestation, '' as libelle_specialite,users.first_name,users.last_name, users.email FROM expense
         join users on users.id = expense.user
         WHERE expense.id_organisation = " . $id_organisation . "
         AND DATE_FORMAT(FROM_UNIXTIME(`date`), '%Y-%m')=date_format(now(), '%Y-%m')
         UNION ALL
         select DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateOp,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateFormat,payment.`code` As recu,CONCAT(payment.patient_name,' ',payment.patient_phone) as beneficiaire,
         '' as specialite,'' as libelle,
         payment.amount_received as montant,
         payment.amount_received as concatMontant,
         payment.category_name,
         'recette' as type,
         payment.libelle_prestation as libelle_prestation, payment.libelle_specialite as libelle_specialite,users.first_name,users.last_name,users.email
         from payment
         join users on users.id = payment.user
         WHERE payment.amount_received > 0
         AND payment.id_organisation = " . $id_organisation . "
         AND DATE_FORMAT(FROM_UNIXTIME(`date`), '%Y-%m')=date_format(now(), '%Y-%m')
         ORDER BY dateFormat DESC");
        return $query->result();
    }


    function getPaymentExpenseByOrganisation($id_organisation)
    {
        // $this->db->where('payment_category.id', $id);
        $this->db->query("SET time_zone = '+00:00';");
        $query = $this->db->query("select DATE_FORMAT(expense.datestring,'%y/%m/%d %H:%i') AS dateOp,DATE_FORMAT(expense.datestring, '%d/%m/%y %H:%i') AS dateFormat,expense.codeFacture AS recu,expense.beneficiaire,
         expense.category AS specialite,expense.note as libelle,expense.amount as montant,CONCAT('-',expense.amount) as concatMontant,'' as category_name,'depense' as type,
         '' as libelle_prestation, '' as libelle_specialite FROM expense
         WHERE expense.id_organisation = " . $id_organisation . "
         UNION ALL
         select DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateOp,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateFormat,payment.`code` As recu,CONCAT(payment.patient_name,' ',payment.patient_phone) as beneficiaire,
         '' as specialite,'' as libelle,
         payment.amount_received as montant,
         payment.amount_received as concatMontant,
         payment.category_name,
         'recette' as type,
         payment.libelle_prestation as libelle_prestation, payment.libelle_specialite as libelle_specialite
         from payment
         WHERE payment.amount_received > 0
         AND payment.id_organisation = " . $id_organisation . "
         ORDER BY dateFormat DESC");
        return $query->result();
    }

    function getPEByFilterType($id_organisation, $date_debut, $date_fin, $type)
    {
        // $this->db->where('payment_category.id', $id);
        $this->db->query("SET time_zone = '+00:00';");
        $query = $this->db->query("select * from (
            (
            select DATE_FORMAT(expense.datestring,'%y/%m/%d %H:%i') AS dateOp,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateFormat,
                    expense.codeFacture AS recu,expense.beneficiaire,
                     expense.category AS specialite,expense.note as libelle,expense.amount as montant,CONCAT('-',expense.amount) as concatMontant,'' as category_name,'depense' as type, 
                     '' as libelle_prestation, '' as libelle_specialite, users.first_name,users.last_name,users.email FROM expense
                     join users on users.id = expense.user
                     WHERE expense.id_organisation = " . $id_organisation . "
                     AND date >= " . $date_debut . "
                     AND date <= " . $date_fin . " )
                     UNION
                     (
                     select DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateOp,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateFormat,
                     payment.`code` As recu,CONCAT(payment.patient_name,' ',payment.patient_phone) as beneficiaire,
                     '' as specialite,'' as libelle,
                     payment.amount_received as montant,
                     payment.amount_received as concatMontant,
                     payment.category_name,
                     'recette' as type,
                     payment.libelle_prestation as libelle_prestation, payment.libelle_specialite as libelle_specialite,users.first_name,users.last_name,users.email
                     from payment
                     join users on users.id = payment.user
                     WHERE payment.amount_received > 0
                     AND payment.id_organisation = " . $id_organisation . "
                      AND date >= " . $date_debut . "
                     AND date <= " . $date_fin . ")
                     ) T
                     where type like '%" . $type . "%'
                     ORDER BY dateFormat DESC");
        return $query->result();
    }

    function getPaymentExpenseByOrganisationByFilter($id_organisation, $date_debut, $date_fin)
    {
        // $this->db->where('payment_category.id', $id);
        $this->db->query("SET time_zone = '+00:00';");
        $query = $this->db->query("select DATE_FORMAT(expense.datestring,'%y/%m/%d %H:%i') AS dateOp,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateFormat,
        expense.codeFacture AS recu,expense.beneficiaire,
         expense.category AS specialite,expense.note as libelle,expense.amount as montant,CONCAT('-',expense.amount) as concatMontant,'' as category_name,'depense' as type,
         '' as libelle_prestation, '' as libelle_specialite,users.first_name,users.last_name,users.email
         FROM expense
         join users on users.id = expense.user
         WHERE expense.id_organisation = " . $id_organisation . "
         AND date >= " . $date_debut . "
         AND date <= " . $date_fin . "
         UNION ALL
         select DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateOp,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateFormat,
         payment.`code` As recu,CONCAT(payment.patient_name,' ',payment.patient_phone) as beneficiaire,
         '' as specialite,'' as libelle,
         payment.amount_received as montant,
         payment.amount_received as concatMontant,
         payment.category_name,
         'recette' as type,
         payment.libelle_prestation as libelle_prestation, payment.libelle_specialite as libelle_specialite,users.first_name,users.last_name,users.email
         from payment
         join users on users.id = payment.user
         WHERE payment.amount_received > 0
         AND payment.id_organisation = " . $id_organisation . "
         AND date >= " . $date_debut . "
         AND date <= " . $date_fin . "
         ORDER BY dateFormat DESC");
        return $query->result();
    }

    function getPaymentCategoryByOrganisationById2($id)
    {
        $payment_category = 'payment_category';
        $setting_service = 'setting_service';
        $department = 'department';
        $payment_category_parametre = 'payment_category_parametre';
        $this->db->select('payment_category.id, payment_category.prestation, payment_category.description, payment_category.tarif_public, payment_category.tarif_professionnel, payment_category.tarif_assurance, setting_service.name_service, setting_service.code_service');
        $this->db->from($payment_category);
        $this->db->join($setting_service, $setting_service . '.idservice=' . $payment_category . '.id_service', 'left');
        $this->db->join($department, $department . '.id=' . $setting_service . '.id_department', 'left');
        $this->db->where($payment_category . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getValidPrestationsByPatientIdActe($patient, $presta)
    {
        $this->db->select('*');
        $this->db->from('lab_data');
        $this->db->join("lab", "lab_data.id_lab = lab.id");
        $this->db->join("patient", "patient.id = lab.patient");

        ///$this->db->where('lab.patient"', $id_organisation);
        $this->db->where('patient.id', $patient);
        $this->db->where('lab_data.id_prestation', $presta);
        $query = $this->db->get();
        return $query->row();
    }

    function getDepositByInvoiceIdPayment($id)
    {
        $this->db->query("SET time_zone = '+00:00';");
        $query = $this->db->query(
            "select (CASE WHEN `users`.first_name IS NOT NULL THEN (SELECT `users`.first_name) ELSE (CASE WHEN patient_deposit.deposit_type like '%Orange%' THEN (SELECT statut_deposit_om.numero_om from statut_deposit_om where statut_deposit_om.id_transaction_externe = patient_deposit.id_transaction_externe AND statut_deposit_om.payment_id = patient_deposit.payment_id LIMIT 1) ELSE (SELECT 'zuuluPay') END) END) as first_name,(CASE WHEN `users`.last_name IS NOT NULL THEN (SELECT `users`.last_name) ELSE (SELECT '') END) as last_name,patient_deposit.id,patient,patient_deposit.id_organisation,payment_id,date,deposited_amount,deposit_type,'0' AS type,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') as formeTimes from patient_deposit 
        left join `users` ON `users`.id = patient_deposit.`user`
        WHERE patient_deposit.payment_id = " . $id . "
        UNION ALL
        select statut_deposit_om.numero_om as first_name,'' as last_name,statut_deposit_om.id,patient,statut_deposit_om.id_organisation,payment_id,date,deposited_amount,deposit_type,'1' AS type,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') as formeTimes from statut_deposit_om 
        join `users` ON `users`.id = statut_deposit_om.`user`
        WHERE statut_deposit_om.payment_id = " . $id . "
        AND statut_deposit LIKE '%PENDING%'
        ORDER BY id DESC"
        );
        // $query = $this->db->query("select (CASE WHEN `users`.first_name IS NOT NULL THEN (SELECT `users`.first_name) ELSE (SELECT 'zuuluPay') END) as first_name,(CASE WHEN `users`.last_name IS NOT NULL THEN (SELECT `users`.last_name) ELSE (SELECT '') END) as last_name,patient_deposit.id,patient,patient_deposit.id_organisation,payment_id,date,deposited_amount,deposit_type,'0' AS type,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') as formeTimes from patient_deposit 
        // left join `users` ON `users`.id = patient_deposit.`user`
        // WHERE patient_deposit.payment_id = " . $id . "
        // UNION ALL
        // select (CASE WHEN `users`.first_name IS NOT NULL THEN (SELECT `users`.first_name) ELSE (SELECT '') END) as first_name,(CASE WHEN `users`.last_name IS NOT NULL THEN (SELECT `users`.last_name) ELSE (SELECT '') END) as last_name,statut_deposit_om.id,patient,statut_deposit_om.id_organisation,payment_id,date,deposited_amount,deposit_type,'1' AS type,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') as formeTimes from statut_deposit_om 
        // join `users` ON `users`.id = statut_deposit_om.`user`
        // WHERE statut_deposit_om.payment_id = " . $id . "
        // AND statut_deposit LIKE '%PENDING%'
        // ORDER BY id DESC"
        // );
        return $query->result();
    }
    function listePrestationyJason($id, $searchTerm)
    {
        if (!empty($searchTerm)) {
            $this->db->select('*');

            $this->db->where("prestation like '%" . $searchTerm . "%' ");
            //  $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('payment_category');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');

            $this->db->limit(10);
            $fetched_records = $this->db->get('payment_category');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        // $data[] = array("id" => 'add_new', "text" => lang('add_new'));
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['prestation']);
            // $data[] = array("id" => $user['id'], "text" => $user['name'] .' '.$user['last_name'] . ' ('.lang('phone').': ' . $user['phone'].')');
        }
        return $data;
    }

    function getListePrestationsParamtres()
    {
        $payment_category = 'payment_category';
        $setting_service = 'setting_service';
        $payment_category_parametre = 'payment_category_parametre';
        $this->db->select('*');
        $this->db->from($payment_category);
        $this->db->join($setting_service, $setting_service . '.idservice=' . $payment_category . '.id_service', 'left');
        $this->db->join($payment_category_parametre, $payment_category_parametre . '.id_prestation=' . $payment_category . '.id', 'left');
        $this->db->order_by('idpara', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function getListePrestationsParamtresById($id)
    {
        $payment_category = 'payment_category';
        $setting_service = 'setting_service';
        $payment_category_parametre = 'payment_category_parametre';
        $this->db->select('*');
        $this->db->from($payment_category);
        $this->db->join($setting_service, $setting_service . '.idservice=' . $payment_category . '.id_service', 'left');
        $this->db->join($payment_category_parametre, $payment_category_parametre . '.id_prestation=' . $payment_category . '.id', 'left');

        $this->db->where($payment_category . '.id', $id);
        $this->db->order_by('idpara', 'ASC');
        $query = $this->db->get();
        return $query->row();
    }

    function insertPretation($data)
    {
        $this->db->insert('payment_category_organisation', $data);
    }

    function listCategoryByOrganisation($id_organisation)
    {
        $this->db->select('*');
        $this->db->from('payment_category_organisation');
        $this->db->join('payment_category', 'payment_category.id=payment_category_organisation.id_presta', 'left');
        //    $this->db->join('setting_service_specialite','setting_service_specialite.id_service=payment_category.id_service', 'left');
        $this->db->join('setting_service', 'setting_service.idservice=payment_category.id_service', 'left');
        //  
        $this->db->where('payment_category_organisation.id_organisation', $id_organisation);
        $query = $this->db->get();
        return $query->result();
    }

    function editCategoryServiceById($id)
    {
        $payment_category = 'payment_category';

        $setting_service_specialite = 'setting_service_specialite';
        $this->db->select('*');
        $this->db->from($payment_category);
        $this->db->join($setting_service_specialite, $setting_service_specialite . '.id_service=' . $payment_category . '.id_service', 'left');
        $this->db->where($payment_category . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function editResultats($id, $payment)
    {
        $payment_category = 'lab_data';
        $this->db->select('*');
        $this->db->from($payment_category);
        $this->db->where($payment_category . '.id_para', $id);
        $this->db->where($payment_category . '.id_payment', $payment);
        $query = $this->db->get();
        return $query->row();
    }

    function updatePaymentByLabo($patient, $id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('patient', $patient);
        $this->db->from('payment');
        $query = $this->db->get();
        return $query->result();
    }
    function existResultats($id, $presta)
    {
        $payment_category = 'lab_data';
        $setting_service_specialite = 'lab';
        $this->db->select('lab_data.id as id, lab.id as idlab, lab_data.resultats as resultats, lab_data.id_para as id_para');
        $this->db->from($payment_category);
        $this->db->join($setting_service_specialite, $setting_service_specialite . '.id=' . $payment_category . '.id_lab', 'left');
        if ($presta != 'all') {
            $this->db->where($payment_category . '.id_prestation', $presta);
        }
        $this->db->where($payment_category . '.id_payment', $id);
        $query = $this->db->get();
        return $query->row();
    }
    function existResultatsLab($id)
    {
        $payment_category = 'lab_data';
        $setting_service_specialite = 'lab';
        $this->db->select('lab_data.id as id, lab.id as idlab');
        $this->db->from($payment_category);
        $this->db->join($setting_service_specialite, $setting_service_specialite . '.id=' . $payment_category . '.id_lab', 'left');

        $this->db->where($payment_category . '.id_payment', $id);
        $query = $this->db->get();
        return $query->row();
    }
    function existLab($presta, $payment)
    {
        $lab = 'lab';
        $this->db->select('*');
        $this->db->from($lab);
        $this->db->where($lab . '.payment', $payment);
        $this->db->where($lab . '.id_presta', $presta);
        $query = $this->db->get();
        return $query->row();
    }
    function getFirstRowLabByIdByOrganisation($id_organisation, $type)
    {
        $payment_category = 'lab_data';
        $setting_service_specialite = 'lab';
        $this->db->select('lab_data.*, lab.patient');
        $this->db->from($payment_category);
        $this->db->join($setting_service_specialite, $setting_service_specialite . '.id=' . $payment_category . '.id_lab', 'left');
        $this->db->where($payment_category . '.status', $type);
        $this->db->where($setting_service_specialite . '.id_organisation', $id_organisation);
        $this->db->order_by('lab_data.id', "asc");
        // $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    function getLastRowLabByIdByOrganisation($id_organisation, $type)
    {     //    var_dump($id_organisation,$type);
        $payment_category = 'lab_data';
        $setting_service_specialite = 'lab';
        $this->db->select('lab_data.*, lab.patient');
        $this->db->from($payment_category);
        $this->db->join($setting_service_specialite, $setting_service_specialite . '.id=' . $payment_category . '.id_lab', 'left');
        $this->db->where($payment_category . '.status', $type);
        $this->db->where($setting_service_specialite . '.id_organisation', $id_organisation);
        $this->db->order_by('lab_data.id', "desc");
        //       $this->db->group_by($payment_category.".id_prestation"); 
        // $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    function getNextLabByIdByOrganisation($id, $id_organisation, $prestation, $type)
    {
        $payment_category = 'lab_data';
        $setting_service_specialite = 'lab';
        $this->db->select('*');
        $this->db->from($payment_category);
        $this->db->join($setting_service_specialite, $setting_service_specialite . '.id=' . $payment_category . '.id_lab', 'left');
        $this->db->where($payment_category . '.status', $type);
        $this->db->where($setting_service_specialite . '.id_organisation', $id_organisation);
        $this->db->where($payment_category . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getPreviousLabByIdByOrganisation($id, $id_organisation, $type)
    {
        $payment_category = 'lab_data';
        $setting_service_specialite = 'lab';
        $this->db->select('*');
        $this->db->from($payment_category);
        $this->db->join($setting_service_specialite, $setting_service_specialite . '.id=' . $payment_category . '.id_lab', 'left');
        $this->db->where($payment_category . '.status', $type);
        $this->db->where($setting_service_specialite . '.id_organisation', $id_organisation);
        $this->db->where($payment_category . '.id', $id);
        $query = $this->db->get();
        return $query->previous_row();
    }

    function parametreValue($id)
    {
        $payment_category_parametre = 'payment_category_parametre';
        $this->db->select('*');
        $this->db->from($payment_category_parametre);
        $this->db->where($payment_category_parametre . '.idpara', $id);
        $this->db->order_by('idpara', 'ASC');
        $query = $this->db->get();
        return $query->row();
    }

    function parametreValueCount($id)
    {
        $payment_category_parametre = 'payment_category_parametre';
        $this->db->select('count(*) as nombre');
        $this->db->from($payment_category_parametre);
        $this->db->where($payment_category_parametre . '.id_prestation ', $id);
        $this->db->order_by('idpara', 'ASC');
        $query = $this->db->get();
        return $query->row();
    }

    function getPaymentByIdByservice($id)
    {
        $this->db->select('*');
        $this->db->from('payment');
        $this->db->join('setting_service', ' setting_service.idservice = payment.service', 'left');
        $this->db->where('payment.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function existResultatsPara($id, $presta)
    {
        $payment_category = 'lab_data';
        $setting_service_specialite = 'lab';
        $this->db->select('lab_data.id as id, lab.id as idlab, lab_data.resultats as resultats, lab_data.id_para as id_para, lab_data.id_prestation as id_presta');
        $this->db->from($payment_category);
        $this->db->join($setting_service_specialite, $setting_service_specialite . '.id=' . $payment_category . '.id_lab', 'left');
        $this->db->where($payment_category . '.id_prestation', $presta);
        $this->db->where($payment_category . '.id_payment', $id);
        $this->db->order_by('id_para', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function prestationNameText($presta)
    {
        $payment_category_parametre = 'payment_category_parametre';
        $payment_category = 'payment_category';
        $type = 'textcode';
        $this->db->select('payment_category.prestation');
        $this->db->from($payment_category_parametre);
        $this->db->join($payment_category, $payment_category . '.id=' . $payment_category_parametre . '.id_prestation', 'left');
        $this->db->where($payment_category_parametre . '.id_prestation', $presta);
        $this->db->where($payment_category_parametre . '.type', $type);
        $this->db->order_by('idpara', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    function editCategoryServiceBySpe($id)
    {
        $payment_category = 'payment_category';

        $setting_service_specialite = 'setting_service_specialite';
        $this->db->select('*');
        $this->db->from($payment_category);
        $this->db->join($setting_service_specialite, $setting_service_specialite . '.idspe=' . $payment_category . '.id_spe', 'left');
        $this->db->where($payment_category . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }


    function getTestPcr($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('payment_category');
        return $query->row();
    }


    function getPCR($id) {
        $this->db->where('payment', $id);
        $query = $this->db->get('PCR');
        return $query->row();
    }

    function prestationDetailsByID($id) {
        $payment_category = 'payment_category';
        $setting_service_specialite = 'setting_service_specialite';
        $this->db->select('setting_service_specialite.idspe, setting_service_specialite.name_specialite, setting_service_specialite.id_service, setting_service_specialite.code_specialite, payment_category.code_prestation');
        $this->db->from($payment_category);
        $this->db->where($payment_category . '.id', $id);
        $this->db->join($setting_service_specialite, $setting_service_specialite . '.idspe =' . $payment_category . '.id_spe', 'left');
          
        
        $query = $this->db->get();
        return $query->row();
    }

    // function editCategoryServiceBySpeJSON($id)
    // {
    //     $payment_category = 'payment_category';

    //     $setting_service_specialite = 'setting_service_specialite';
    //     $this->db->select('*');
    //     $this->db->from($payment_category);
    //     $this->db->join($setting_service_specialite, $setting_service_specialite . '.idspe=' . $payment_category . '.id_spe', 'left');
    //     $this->db->where($payment_category . '.id', $id);
    //     $query = $this->db->get();
    //     return $query->row();
    // }

    function getPurpose()
    {
        return $this->db->get('purpose')->result();
    }

    function getTablePayment($id_organisation, $status)
    {
        // $this->db->where('id_organisation', $id_organisation);
        // $this->db->where('status', $status);
        // $query = $this->db->get('payment');
        $this->db->query("SET time_zone = '+00:00';");
        $clauseInit = $id_organisation != null && !empty($id_organisation) ? "id_organisation = " . $id_organisation : "";
        $and = !empty($clauseInit) ? " and " : "";
        $clauseInit2 = $status != null && !empty(trim($status)) ? $and . " status = \"" . $status . "\" and " : "";
        $query = $this->db->query("select *,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateFormat from payment where  " . $clauseInit . " " . $clauseInit2 . " patient is not null AND payment.bulletinAnalyse is null ");
        return $query->result();
    }

    function getTablePaymentBySearch($search, $id_organisation, $status)
    {
        $this->db->select("*,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateFormat");
        $this->db->order_by('id', 'desc');
        if (trim($id_organisation) && $id_organisation != null) {
            $this->db->where('id_organisation', $id_organisation);
        }
        if (($status) && $status != null) {
            $this->db->where('status', $status);
        }
        $this->db->where('patient is NOT NULL');
        $this->db->where('bulletinAnalyse', '');
        $this->db->group_start();
        $this->db->like('id', $search);
        $this->db->or_like('status', $search);
        $this->db->or_like('amount', $search);
        $this->db->or_like('gross_total', $search);
        $this->db->or_like('patient_name', $search);
        $this->db->or_like('patient_phone', $search);
        $this->db->or_like('patient_address', $search);
        $this->db->or_like('remarks', $search);
        $this->db->or_like('doctor_name', $search);
        $this->db->or_like('flat_discount', $search);
        $this->db->or_like('date_string', $search);
        $this->db->or_like('date_string', $search);
        $this->db->or_like('code', $search);
        $this->db->group_end();
        $query = $this->db->get('payment');
        return $query->result();
    }

    function getTablePaymentByLimit($limit, $start, $id_organisation, $status)
    {
        $this->db->select("*,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateFormat");
        $this->db->order_by('id', 'desc');
        if (trim($id_organisation) && $id_organisation != null) {
            $this->db->where('id_organisation', $id_organisation);
        }
        if (($status) && $status != null) {
            $this->db->where('status', $status);
        }
        $this->db->where('patient is NOT NULL');
        $this->db->where('bulletinAnalyse', '');
        $this->db->limit($limit, $start);
        $query = $this->db->get('payment');
        return $query->result();
    }

    function getTablePaymentByLimitBySearch($limit, $start, $search, $id_organisation, $status)
    {
        $this->db->select("*,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateFormat");
        $this->db->order_by('id', 'desc');
        if (trim($id_organisation) && $id_organisation != null) {
            $this->db->where('id_organisation', $id_organisation);
        }
        if (($status) && $status != null) {
            $this->db->where('status', $status);
        }
        $this->db->where('patient is NOT NULL');
        $this->db->where('bulletinAnalyse', '');
        $this->db->group_start();
        $this->db->like('id', $search);
        $this->db->or_like('status', $search);
        $this->db->or_like('amount', $search);
        $this->db->or_like('gross_total', $search);
        $this->db->or_like('patient_name', $search);
        $this->db->or_like('patient_phone', $search);
        $this->db->or_like('patient_address', $search);
        $this->db->or_like('remarks', $search);
        $this->db->or_like('doctor_name', $search);
        $this->db->or_like('flat_discount', $search);
        $this->db->or_like('date_string', $search);
        $this->db->or_like('code', $search);
        $this->db->group_end();
        $this->db->limit($limit, $start);
        $query = $this->db->get('payment');
        return $query->result();
    }

    function getTableTiersPayantByOrganisation($id_organisation_sante)
    {
        $query = $this->db->select('partenariat_sante_assurance.id as idPartenariat, 
       organisation.id as idTiersPayant, organisation.nom as nomTiersPayant, 
       organisation.nom_commercial as nomCommercialTiersPayant, organisation.path_logo as pathLogoTiersPayant, 
       organisation.adresse as adresseTiersPayant, organisation.region as regionTiersPayant, 
       organisation.departement as departementTiersPayant, 
       organisation.arrondissement as arrondissementTiersPayant, 
       organisation.collectivite as collectiviteTiersPayant, organisation.pays as paysTiersPayant, 
       organisation.email as emailTiersPayant, organisation.type as typeTiersPayant, 
       partenariat_sante_assurance.partenariat_actif')
            ->from('partenariat_sante_assurance')
            ->join('organisation', 'organisation.id = partenariat_sante_assurance.id_organisation_assurance 
                             and partenariat_sante_assurance.id_organisation_sante = ' . $id_organisation_sante)
            ->where('organisation.est_active', 1)
            ->order_by('partenariat_sante_assurance.id', 'desc')
            ->get();
        // $query = $this->db->get('payment_category');
        //		$query = $this->db->query("select partenariat_sante_assurance.id as idPartenariat,
        //       organisation.id as idTiersPayant, organisation.nom as nomTiersPayant,
        //       organisation.nom_commercial as nomCommercialTiersPayant, organisation.path_logo as pathLogoTiersPayant,
        //       organisation.adresse as adresseTiersPayant, organisation.region as regionTiersPayant,
        //       organisation.departement as departementTiersPayant,
        //       organisation.arrondissement as arrondissementTiersPayant,
        //       organisation.collectivite as collectiviteTiersPayant, organisation.pays as paysTiersPayant,
        //       organisation.email as emailTiersPayant, organisation.type as typeTiersPayant,
        //       partenariat_sante_assurance.partenariat_actif
        //from partenariat_sante_assurance
        //    join organisation on organisation.id = partenariat_sante_assurance.id_organisation_assurance
        //                             and partenariat_sante_assurance.id_organisation_sante = " . $id_organisation_sante . "
        //                             where organisation.est_active = 1
        //                             order by partenariat_sante_assurance.id desc");
        return $query->result();
    }

    function getTableTiersPayantByOrganisationBySearch($search, $id_organisation_sante)
    {
        $query = $this->db->select('partenariat_sante_assurance.id as idPartenariat, 
       organisation.id as idTiersPayant, organisation.nom as nomTiersPayant, 
       organisation.nom_commercial as nomCommercialTiersPayant, organisation.path_logo as pathLogoTiersPayant, 
       organisation.adresse as adresseTiersPayant, organisation.region as regionTiersPayant, 
       organisation.departement as departementTiersPayant, 
       organisation.arrondissement as arrondissementTiersPayant, 
       organisation.collectivite as collectiviteTiersPayant, organisation.pays as paysTiersPayant, 
       organisation.email as emailTiersPayant, organisation.type as typeTiersPayant, 
       partenariat_sante_assurance.partenariat_actif')
            ->from('partenariat_sante_assurance')
            ->join('organisation', 'organisation.id = partenariat_sante_assurance.id_organisation_assurance 
                             and partenariat_sante_assurance.id_organisation_sante = ' . $id_organisation_sante)
            ->where('organisation.est_active', 1)
            ->group_start()
            ->like('organisation.nom', $search)
            ->or_like('organisation.type', $search)
            ->or_like('organisation.adresse', $search)
            ->group_end()
            ->order_by('partenariat_sante_assurance.id', 'desc')
            ->get();

        return $query->result();
    }

    function getTableTiersPayantByOrganisationByLimit($limit, $start, $id_organisation_sante)
    {
        $query = $this->db->select('partenariat_sante_assurance.id as idPartenariat, 
       organisation.id as idTiersPayant, organisation.nom as nomTiersPayant, 
       organisation.nom_commercial as nomCommercialTiersPayant, organisation.path_logo as pathLogoTiersPayant, 
       organisation.adresse as adresseTiersPayant, organisation.region as regionTiersPayant, 
       organisation.departement as departementTiersPayant, 
       organisation.arrondissement as arrondissementTiersPayant, 
       organisation.collectivite as collectiviteTiersPayant, organisation.pays as paysTiersPayant, 
       organisation.email as emailTiersPayant, organisation.type as typeTiersPayant, 
       partenariat_sante_assurance.partenariat_actif')
            ->from('partenariat_sante_assurance')
            ->join('organisation', 'organisation.id = partenariat_sante_assurance.id_organisation_assurance 
                             and partenariat_sante_assurance.id_organisation_sante = ' . $id_organisation_sante)
            ->where('organisation.est_active', 1)
            ->limit($limit, $start)
            ->order_by('partenariat_sante_assurance.id', 'desc')
            ->get();

        return $query->result();
    }

    function getTableTiersPayantByOrganisationByLimitBySearch($limit, $start, $search, $id_organisation_sante)
    {
        $query = $this->db->select('partenariat_sante_assurance.id as idPartenariat, 
       organisation.id as idTiersPayant, organisation.nom as nomTiersPayant, 
       organisation.nom_commercial as nomCommercialTiersPayant, organisation.path_logo as pathLogoTiersPayant, 
       organisation.adresse as adresseTiersPayant, organisation.region as regionTiersPayant, 
       organisation.departement as departementTiersPayant, 
       organisation.arrondissement as arrondissementTiersPayant, 
       organisation.collectivite as collectiviteTiersPayant, organisation.pays as paysTiersPayant, 
       organisation.email as emailTiersPayant, organisation.type as typeTiersPayant, 
       partenariat_sante_assurance.partenariat_actif')
            ->from('partenariat_sante_assurance')
            ->join('organisation', 'organisation.id = partenariat_sante_assurance.id_organisation_assurance 
                             and partenariat_sante_assurance.id_organisation_sante = ' . $id_organisation_sante)
            ->where('organisation.est_active', 1)
            ->group_start()
            ->like('organisation.nom', $search)
            ->or_like('organisation.type', $search)
            ->or_like('organisation.adresse', $search)
            ->group_end()
            ->limit($limit, $start)
            ->order_by('partenariat_sante_assurance.id', 'desc')
            ->get();

        return $query->result();
    }

    function getTablePaymentByLabo($id_organisation = '')
    {
        $this->db->query("SET time_zone = '+00:00';");
        $this->db->select('payment.id as id,payment.code as code, payment.patient as patient, payment.date as date,DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y %H:%i") AS dateFormat, payment.category_name as category_name, patient.name as name, patient.last_name as last_name, payment.organisation_destinataire as organisation_destinataire, payment.organisation_light_origin as organisation_light_origin, payment.id_organisation as id_organisation, payment.etat as etat, payment.etatlight as etatlight, payment.status as status, payment.statutLight as statutLight');
        $this->db->from('payment');
        $this->db->where('payment.bulletinAnalyse', '');
        $this->db->join("patient", "patient.id = payment.patient");
        $this->db->where('payment.id_organisation', $id_organisation);
        $this->db->or_where('organisation_destinataire', $id_organisation);
        $this->db->order_by('payment.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getTablePaymentByLaboBySearch($search, $id_organisation = '')
    {
        $this->db->query("SET time_zone = '+00:00';");
        $this->db->select('payment.id as id,payment.code as code, payment.patient as patient, payment.date as date,DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y %H:%i") AS dateFormat, payment.category_name as category_name, patient.name as name, patient.last_name as last_name, payment.organisation_destinataire as organisation_destinataire, payment.organisation_light_origin as organisation_light_origin, payment.id_organisation as id_organisation, payment.etat as etat, payment.etatlight as etatlight, payment.status as status, payment.statutLight as statutLight');
        $this->db->from('payment');
        $this->db->where('payment.bulletinAnalyse', '');
        $this->db->join("patient", "patient.id = payment.patient");
        $this->db->group_start();
        $this->db->like('payment.code', $search);
        $this->db->or_like('payment.status', $search);
        $this->db->or_like('patient.name', $search);
        $this->db->or_like('patient.last_name', $search);
        $this->db->group_end();
        $this->db->where('payment.id_organisation', $id_organisation);
        $this->db->or_where('organisation_destinataire', $id_organisation);
        $this->db->order_by('payment.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getTablePaymentByLaboByLimit($limit, $start, $id_organisation = '')
    {
        $this->db->query("SET time_zone = '+00:00';");
        $this->db->select('payment.id as id,payment.code as code, payment.patient as patient, payment.date as date,DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y %H:%i") AS dateFormat, payment.category_name as category_name, patient.name as name, patient.last_name as last_name, payment.organisation_destinataire as organisation_destinataire, payment.organisation_light_origin as organisation_light_origin, payment.id_organisation as id_organisation, payment.etat as etat, payment.etatlight as etatlight, payment.status as status, payment.statutLight as statutLight');
        $this->db->from('payment');
        $this->db->where('payment.bulletinAnalyse', '');
        $this->db->join("patient", "patient.id = payment.patient");
        $this->db->where('payment.id_organisation', $id_organisation);
        $this->db->or_where('organisation_destinataire', $id_organisation);
        $this->db->limit($limit, $start);
        $this->db->order_by('payment.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getTablePaymentByLaboByLimitBySearch($limit, $start, $search, $id_organisation = '')
    {
        $this->db->query("SET time_zone = '+00:00';");
        $this->db->select('payment.id as id,payment.code as code, payment.patient as patient, payment.date as date,DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y %H:%i") AS dateFormat, payment.category_name as category_name, patient.name as name, patient.last_name as last_name, payment.organisation_destinataire as organisation_destinataire, payment.organisation_light_origin as organisation_light_origin, payment.id_organisation as id_organisation, payment.etat as etat, payment.etatlight as etatlight, payment.status as status, payment.statutLight as statutLight');
        $this->db->from('payment');
        $this->db->where('payment.bulletinAnalyse', '');
        $this->db->join("patient", "patient.id = payment.patient");
        $this->db->group_start();
        $this->db->like('code', $search);
        $this->db->or_like('payment.status', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('last_name', $search);
        $this->db->group_end();
        $this->db->where('payment.id_organisation', $id_organisation);
        $this->db->or_where('organisation_destinataire', $id_organisation);
        $this->db->limit($limit, $start);
        $this->db->order_by('payment.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
}
