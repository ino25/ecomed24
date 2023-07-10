<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Partenaire_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getPartenaires($id_organisation) {
        $query = $this->db->query(
            "select * from partenariat_sante, organisation where (partenariat_sante.id_organisation_origin = organisation.id or partenariat_sante.id_organisation_destinataire = organisation.id) and (partenariat_sante.id_organisation_origin = " . $id_organisation . " or partenariat_sante.id_organisation_destinataire=" . $id_organisation . ") AND organisation.id != " . $id_organisation . " GROUP BY organisation.id order by partenariat_sante.idp DESC;"
        );
        return $query->result();
    }

    function getPartenairesDemande($id_organisation) {
        $organisation = 'organisation';
        $partenariat_sante = 'partenariat_sante';
        $this->db->select('*');
        $this->db->from($organisation);
        $this->db->join($partenariat_sante, $partenariat_sante . '.id_organisation_origin=' . $organisation . '.id', 'left');

        $this->db->where($partenariat_sante . '.id_organisation_destinataire', $id_organisation);
        $this->db->where($partenariat_sante . '.partenariat_actif', 1);
        $this->db->order_by($partenariat_sante . '.idp', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function searhPartenaire($searchTerm, $id_organisation) {
        $table = 'organisation';
        $partenariat_sante = 'partenariat_sante';
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->join($partenariat_sante, $partenariat_sante . '.id_organisation_destinataire=' . $table . '.id', 'left');
$this->db->where($partenariat_sante . '.id_organisation_origin', $id_organisation);
 $this->db->where("organisation.id != " . $id_organisation . " AND nom like '%" . $searchTerm . "%' AND organisation.type != 'Assurance' AND organisation.is_light = 0");
            $this->db->where($partenariat_sante . '.partenariat_actif', 1);
            $this->db->order_by($partenariat_sante . '.idp', 'desc');
            $this->db->limit(10);
            $query = $this->db->get();
            $users = $query->result();
        } else {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->join($partenariat_sante, $partenariat_sante . '.id_organisation_destinataire=' . $table . '.id', 'left');
            $this->db->where($partenariat_sante . '.id_organisation_origin', $id_organisation);
             $this->db->where("organisation.id != " . $id_organisation . " AND organisation.type != 'Assurance' AND organisation.is_light = 0");
            $this->db->where($partenariat_sante . '.partenariat_actif', 1);
            $this->db->order_by($partenariat_sante . '.idp', 'desc');
            $this->db->limit(10);
            $query = $this->db->get();
            $users = $query->result();
        }

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user->id, "text" => $user->nom);
        }
        return $data;
    }

    function searhPartenaireLight($searchTerm, $id_organisation) {
        $table = 'organisation';
        $partenariat_sante = 'partenariat_sante';
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->join($partenariat_sante, $partenariat_sante . '.id_organisation_origin=' . $table . '.id', 'left');
 $this->db->where("partenariat_sante.id_organisation_destinataire = " . $id_organisation . " AND nom like '%" . $searchTerm . "%' AND organisation.is_light = 1" );
            //$this->db->where($partenariat_sante . '.partenariat_actif', 1);

            //$this->db->order_by($partenariat_sante . '.idp', 'desc');
            $this->db->limit(10);
            $query = $this->db->get();
            $users = $query->result();
        } else {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->join($partenariat_sante, $partenariat_sante . '.id_organisation_origin=' . $table . '.id', 'left');
            $this->db->where("partenariat_sante.id_organisation_destinataire = " . $id_organisation . " AND organisation.is_light = 1" );
            //$this->db->where($partenariat_sante . '.partenariat_actif', 1);
            //$this->db->where($table . '.is_light', 1);
            //$this->db->order_by($partenariat_sante . '.idp', 'desc');
            $this->db->limit(10);
            $query = $this->db->get();
            $users = $query->result();
        }

        // Initialize Array with fetched data
        $data = array();
        $data[] = array("id" => 'add_new', "text" => 'Ajouter sous-traitant');
        IF($users) {
        foreach ($users as $user) {
            $data[] = array("id" => $user->id, "text" => $user->nom);
        }
        }
        return $data;
    }
    

    function searhPartenaireByAdd($searchTerm, $id_organisation) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
         //   $this->db->where('id', $id_organisation);
            $this->db->where("nom like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $this->db->where("is_light", "0");
            $fetched_records = $this->db->get('organisation');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
       //     $this->db->where('id', $id_organisation);
            // $this->db->where("name like '%".$searchTerm."%' ");
            //  $this->db->or_where("id like '%".$searchTerm."%' ");
            $this->db->where("is_light", "0");
            $this->db->limit(10);
            $fetched_records = $this->db->get('organisation');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        $data[] = array("id" => 'add_new', "text" => 'Ajouter sous-traitant');
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['nom']);
            // $data[] = array("id" => $user['id'], "text" => $user['name'] .' '.$user['last_name'] . ' ('.lang('phone').': ' . $user['phone'].')');
        }
        return $data;
    }

    function insertPartenaire($data) {
        $table = 'partenariat_sante';
        $this->db->insert($table, $data);
    }

    function insertPartenaireLight($data) {
        $table = 'organisation';
        $this->db->insert($table, $data);
    }

    function insertPartenaireLightAssocier($data) {
        $table = 'partenariat_sante';
        $this->db->insert($table, $data);
    }

    function payButton($idpayment, $id_organisation ) {
        $organisation = 'organisation';
        $partenariat_sante = 'partenariat_sante';
        $payment = 'payment';
        $patient = 'patient';
        $this->db->select('organisation.*,patient.name,patient.last_name,patient.phone,patient.sex,payment.patient as patient_id,payment.*');
        $this->db->from($organisation);
        $this->db->where($organisation . '.id', $id_organisation);

            $this->db->join($payment, $payment . '.id_organisation =' . $organisation . '.id', 'left');
          //  $this->db->where($payment . '.id_organisation', $id_organisation);
        
        $this->db->join($patient, $patient . '.id =' . $payment . '.patient', 'left');
        $this->db->where($payment . '.id', $idpayment);
        
        $query = $this->db->get();
        return $query->row();
    }


    function payButtonJson($idpayment) {
        $query = $this->db->query('select CONCAT(patient.name," ",patient.last_name) as patientName,patient.phone,patient.sex as patientGender,patient.patient_id as patientID,patient.passport as passport,patient.birthdate as patientDOB, patient.age as patientAge,payment.patient as patient_id,payment.qr_code as resultQR,payment.date_string as receivedDate,payment.date_rendu,payment.doctor, payment.*, lab.date_prelevement as collectedDate, purpose.name as motif, CONCAT("Dr ",users.first_name," ",users.last_name) as orderingDoctor, lab.numeroRegistre as orderNumber, doctor_signature.sign_name as signature
        from payment 
        LEFT JOIN lab ON lab.payment = payment.id
        LEFT JOIN patient ON patient.id = payment.patient 
        LEFT JOIN purpose ON purpose.id = payment.purpose
        LEFT JOIN users ON users.id = payment.doctor
        LEFT JOIN doctor_signature ON doctor_signature.doc_id = users.id
        where payment.id ='.$idpayment.'');
        return $query->row();
    }

    function payButtonJsonDestinataireBAckup($idpayment, $id_organisation ) {
        $organisation = 'organisation';
        $partenariat_sante = 'partenariat_sante';
        $payment = 'payment';
        $patient = 'patient';
        $users = 'users';
        $purpose = 'purpose';
        $lab = 'lab';
        $signature = 'doctor_signature';
        $this->db->select('CONCAT(organisation.adresse," ",organisation.numero_fixe,"/",organisation.portable_responsable_legal,"-",organisation.email) as organisationAddress, CONCAT(patient.name," ",patient.last_name) as patientName,patient.phone,patient.sex as patientGender,patient.patient_id as patientID,patient.passport as passport,patient.birthdate as patientDOB, patient.age as patientAge,payment.patient as patient_id,payment.qr_code as resultQR,payment.date_string as receivedDate,payment.date_rendu,payment.doctor, payment.*, lab.date_prelevement as collectedDate, purpose.name as motif, CONCAT("Dr ",users.first_name," ",users.last_name) as orderingDoctor, users.id_organisation as orderingOrganisationID, organisation.nom as orderingOrganisationName, lab.numeroRegistre as orderNumber, doctor_signature.sign_name as signature ');
        $this->db->from($organisation);
        $this->db->where($organisation . '.id', $id_organisation);

            $this->db->join($payment, $payment . '.organisation_destinataire =' . $organisation . '.id', 'left');
          //  $this->db->where($payment . '.id_organisation', $id_organisation);
        
        $this->db->join($patient, $patient . '.id =' . $payment . '.patient', 'left');
        $this->db->join($lab, $lab . '.payment =' . $payment . '.id', 'left');
        $this->db->join($purpose, $purpose . '.id =' . $payment . '.purpose', 'left');
        $this->db->join($users, $users . '.id =' . $payment . '.doctor', 'left');
        $this->db->join($signature, $signature . '.doc_id =' . $users . '.id', 'left');
        $this->db->where($payment . '.id', $idpayment);
        
        $query = $this->db->get();
        return $query->row();
    }

    function payButtonJsonDestinataire($idpayment) {
        $query = $this->db->query('select CONCAT(organisation.adresse," ",organisation.numero_fixe,"/",organisation.portable_responsable_legal,"-",organisation.email) as organisationAddress, CONCAT(patient.name," ",patient.last_name) as patientName,patient.phone,patient.sex as patientGender,patient.patient_id as patientID,patient.passport as passport,patient.birthdate as patientDOB, patient.age as patientAge,payment.patient as patient_id,payment.qr_code as resultQR,payment.date_string as receivedDate,payment.date_rendu,payment.doctor, payment.*, lab.date_prelevement as collectedDate, purpose.name as motif, CONCAT("Dr ",users.first_name," ",users.last_name) as orderingDoctor, users.id_organisation as orderingOrganisationID, organisation.nom as orderingOrganisationName, lab.numeroRegistre as orderNumber, doctor_signature.sign_name as signature
        from payment 
        Join organisation ON organisation.id = payment.organisation_destinataire
        LEFT JOIN lab ON lab.payment = payment.id
        LEFT JOIN patient ON patient.id = payment.patient 
        LEFT JOIN purpose ON purpose.id = payment.purpose
        LEFT JOIN users ON users.id = payment.doctor
        LEFT JOIN doctor_signature ON doctor_signature.doc_id = users.id
        where payment.id ='.$idpayment.'');
        return $query->row();
     }


    function payButtonJsonPCR($idpayment) {
        $query = $this->db->query('select patient.phone,patient.sex as patientGender,patient.patient_id as patientID,patient.passport as passport,patient.birthdate as patientDOB, patient.age as patientAge,payment.patient as patient_id,payment.qr_code as resultQR,payment.date_string as receivedDate,payment.*, lab.date_prelevement as collectedDate, purpose.name as motif, CONCAT("Dr ",users.first_name," ",users.last_name) as orderingDoctor, lab.numeroRegistre as orderNumber,PCR.resultat, PCR.conclusion, PCR.type_de_prelevement, PCR.prestation, PCR.specialite, PCR.date_rendu as collectionData, PCR.signature as signature
        from payment 
        join patient on patient.id = payment.patient 
        join lab on lab.payment = payment.id
        join purpose on purpose.id = payment.purpose
        join users on users.id = payment.doctor
        join PCR on PCR.payment = payment.id
        where payment.id = '.$idpayment.'');
        return $query->row();
    }

    function payButtonJsonPCRMoleculaire($idpayment) {
        $query = $this->db->query('select patient.name as patientFirstName, patient.last_name as patientLastName, patient.phone,patient.sex as patientGender,patient.patient_id as patientID,patient.passport as passport,patient.birthdate as patientDOB, patient.age as patientAge,payment.patient as patient_id,payment.qr_code as resultQR,payment.date_string as receivedDate,payment.*, lab.date_prelevement as collectedDate, CONCAT("Dr ",users.first_name," ",users.last_name) as orderingDoctor, lab.numeroRegistre as orderNumber,PCR.resultat, PCR.conclusion, PCR.type_de_prelevement, PCR.prestation, PCR.specialite, PCR.date_rendu as collectionData, PCR.signature as signature, PCR.note as note
        from payment 
        join patient on patient.id = payment.patient 
        join lab on lab.payment = payment.id
        join users on users.id = payment.doctor
        join PCR on PCR.payment = payment.id
        where payment.id = '.$idpayment.'');
        return $query->row();
    }
    
     function payButtonByCode($idpayment, $id_organisation ) {
        $organisation = 'organisation';
        $partenariat_sante = 'partenariat_sante';
        $payment = 'payment';
        $patient = 'patient';
        $this->db->select('*');
        $this->db->from($organisation);

            $this->db->join($payment, $payment . '.id_organisation =' . $organisation . '.id', 'left');
          //  $this->db->where($payment . '.id_organisation', $id_organisation);
        
        $this->db->join($patient, $patient . '.id =' . $payment . '.patient', 'left');
        $this->db->where($payment . '.code', $idpayment);
        
        $query = $this->db->get();
        return $query->row();
    }
    
    function infoPartenaire($idpayment, $id_organisation, $type) {
        $organisation = 'organisation';
        $payment = 'payment';$patient = 'patient';
        $this->db->select('*');
        $this->db->from($organisation);
        if ($type == 'origin') {
            $this->db->join($payment, $payment . '.organisation_destinataire =' . $organisation . '.id', 'left');
            $this->db->where($payment . '.organisation_destinataire', $id_organisation);
        } else {
            $this->db->join($payment, $payment . '.id_organisation =' . $organisation . '.id', 'left');
            $this->db->where($payment . '.id_organisation', $id_organisation);
        }
        $this->db->join($patient, $patient . '.id =' . $payment . '.patient', 'left');
        $this->db->where($payment . '.id', $idpayment); 
        $query = $this->db->get();  
        return $query->row();
    }

    function payListeFacture($id_origin, $id_organisation, $etat, $status) {
        $organisation = 'organisation';
        $payment = 'payment';
        $this->db->select('*');
        $this->db->from($organisation);
        $this->db->join($payment, $payment . '.id_organisation =' . $organisation . '.id', 'left');
        $this->db->where($payment . '.id_organisation', $id_origin);
        $this->db->where($payment . '.organisation_destinataire', $id_organisation);
        $this->db->where($payment . '.etat', $etat);
        $this->db->where($payment . '.status', $status);
        $query = $this->db->get();
        return $query->result();
    }
    
      function payListeFactureByaLL($id_organisation, $etat, $etatlight, $etat_assurance, $status,$status2=false,$idDestinataire=null,$date1=null,$date2=null) {
			
			// Call depuis listeFacturePrestation (OK)
			// $origins = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, 1, false, 'accept');
            // $originsLight = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, false, 1, 'accept');
			
			// Call depuis listePrestationByPartenaire (OK)
			// $origins = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, 1, false, 'accept', false, $id, $date1, $date2);
			// $originsLight = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, false, 1, 'accept', false, $id, $date1, $date2);
			
			// Call depuis validFaurePartenaire (OK)
			// $origins = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, 1, false, 'accept', false, $id, $date1, $date2);
			// $originsLight = $this->partenaire_model->payListeFactureByaLL($this->id_organisation, false, 1, 'accept', false, $id, $date1, $date2);
			
        $organisation = 'organisation';
        $payment = 'payment';   $patient = 'patient';
        $this->db->select('payment.id as id, payment.date as date, payment.code as code,payment.status_paid_pro as status_paid_pro,payment.status as status, organisation.nom as nom, patient.patient_id as patient,payment.category_name_pro as category_name_pro, payment.organisation_destinataire as organisation_destinataire, payment.organisation_light_origin as organisation_light_origin,payment.etat as etat,payment.etatlight as etatlight,payment.id_organisation as id_organisation, payment.category_name_assurance as category_name_assurance,payment.organisation_assurance as organisation_assurance,payment.etat_assurance as etat_assurance');
        $this->db->from($organisation);
		// if($etat) {
			$this->db->join($payment, $payment . '.id_organisation =' . $organisation . '.id', 'left');
		// } 
		// else if($etatLight) {
			// $this->db->join($payment, $payment . '.organisation_destinataire =' . $organisation . '.id', 'left');
		// }
        $this->db->join($patient, $patient . '.id =' . $payment . '.patient', 'left');
        if(!empty($idDestinataire)) {
			if($etat_assurance) {
				$this->db->where($payment . '.organisation_assurance ='. $idDestinataire); 
			}else if($etat) {
				$this->db->where($payment . '.organisation_destinataire !='. $idDestinataire); 
			} else if($etatlight) {
				$this->db->where($payment . '.organisation_destinataire ='. $idDestinataire); 
			}
         //$this->db->where($payment . '.date <='. $date1);
        }
       
		if($etat_assurance) {
			$this->db->where($payment . '.etat_assurance', $etat_assurance);
		}else if($etat) {
			$this->db->where($payment . '.etat', $etat);
		}
         else if($etatlight) {
			$this->db->where($payment . '.etatlight', $etatlight);
		}
           $this->db->where($payment . '.status', $status);
       if($status2) { $this->db->or_where($payment . '.status', $status2); }
         $this->db->where($payment . '.id_organisation', $organisation);
         $this->db->order_by($payment . '.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function payListeFactureByaLLAssurance($id_organisation, $etat, $etatlight, $status,$status2=false,$idDestinataire=null,$date1=null,$date2=null) {

        
    $organisation = 'organisation';
    $payment = 'payment';   $patient = 'patient';
    $this->db->select('payment.id as id, payment.date as date, payment.code as code,payment.status_paid_pro as status_paid_pro,payment.status as status, organisation.nom as nom, patient.patient_id as patient,payment.category_name_pro as category_name_pro, payment.organisation_destinataire as organisation_destinataire, payment.organisation_light_origin as organisation_light_origin,payment.etat as etat,payment.etatlight as etatlight,payment.id_organisation as id_organisation');
    $this->db->from($organisation);
    $this->db->join($payment, $payment . '.id_organisation =' . $organisation . '.id', 'left');
    $this->db->join($patient, $patient . '.id =' . $payment . '.patient', 'left');
    $this->db->where($payment . '.organisation_assurance ='. $idDestinataire); 
    $this->db->where($payment . '.status', $status);
 //  if($status2) { $this->db->or_where($payment . '.status', $status2); }
   //  $this->db->where($payment . '.id_organisation', $organisation);
     $this->db->order_by($payment . '.id', 'desc');
    $query = $this->db->get();
    return $query->result();
}

     function payListeFactureByGroup($id_organisation, $etat, $status,$status2,$idDestinataire=null,$date1=null,$date2=null) {  
        $organisation = 'organisation';
        $payment = 'payment';   $patient = 'payment_pro';
        $this->db->select('payment.id as id, payment.date as date,payment.gross_total as gross_total, payment.code as code,payment.status_paid_pro as status_paid_pro,payment.status as status, payment.status_paid as status_paid,organisation.nom as nom, payment.patient as patient,payment.category_name_pro as category_name_pro, payment.organisation_destinataire as organisation_destinataire,payment.etat as etat,payment.id_organisation as id_organisation');
        $this->db->from($payment);
        ///$this->db->join($payment, $patient . '.codepro =' . $payment . '.code_pro', 'left');
        $this->db->join($organisation, $payment . '.id_organisation =' . $organisation . '.id', 'left');
        
        if(!empty($idDestinataire)) {
        $this->db->where($payment . '.organisation_destinataire !='. $idDestinataire); 
         //$this->db->where($payment . '.date <='. $date1);
        }
        $this->db->where($payment . '.patient', null);
        $this->db->where($payment . '.etat', $etat);
        $this->db->where($payment . '.status', $status);
       if($status2) { $this->db->or_where($payment . '.status', $status2); }
       //  $this->db->where($payment . '.id_organisation', $organisation);
         $this->db->order_by($payment . '.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }


    function payListeFacturePaidByGroup($id_organisation, $etat, $status,$status2,$idDestinataire=null,$date1=null,$date2=null) {  
        $organisation = 'organisation';
        $payment = 'payment';   $patient = 'payment_pro';
        $this->db->select('payment.id as id, payment.date as date,payment.gross_total as gross_total, payment.code as code,payment.status_paid_pro as status_paid_pro,payment.status as status, payment.status_paid as status_paid,organisation.nom as nom, payment.patient as patient,payment.category_name_pro as category_name_pro, payment.organisation_destinataire as organisation_destinataire,payment.etat as etat,payment.id_organisation as id_organisation');
        $this->db->from($payment);
        ///$this->db->join($payment, $patient . '.codepro =' . $payment . '.code_pro', 'left');
        $this->db->join($organisation, $payment . '.id_organisation =' . $organisation . '.id', 'left');
        
        if(!empty($idDestinataire)) {
        $this->db->where($payment . '.organisation_destinataire !='. $idDestinataire); 
         //$this->db->where($payment . '.date <='. $date1);
        }
       $this->db->where($payment . '.patient', null);
        $this->db->where($payment . '.etat', $etat);
        $this->db->where($payment . '.status', $status);
       if($status2) { $this->db->or_where($payment . '.status', $status2); }
       //  $this->db->where($payment . '.id_organisation', $organisation);
         $this->db->order_by($payment . '.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
    
     function payListeFactureByGroup2($id_organisation,$id, $etat, $status,$status2) {  
        $payment_pro = 'payment_pro';
        $this->db->select('*');
        $this->db->from($payment_pro);
      
 $this->db->where($payment_pro . '.codefacture', $id);
      
        $query = $this->db->get();
        return $query->result();
    }
    
    
     function getPartenairesById($id) {
        $organisation = 'organisation';
        $this->db->select('*');
        $this->db->from($organisation);
        $this->db->where($organisation . '.id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
     function prixPro($buff0_1) {
       $prix_pro_interneSQL = $this->db->query("select payment_category_organisation.tarif_professionnel "
               . "from payment_category_organisation "
               . "join payment_category "
               . "on payment_category_organisation.id_presta = payment_category.id "
               . "and payment_category.id = ".$buff0_1);
        return $prix_pro_interneSQL->row()->tarif_professionnel;
    }


    function searhPartenaireLightOriginByFacture($searchTerm, $id_organisation) {
        $table = 'organisation';
        $partenariat_sante = 'partenariat_sante';
        if (!empty($searchTerm)) {
     		
			$query = $this->db->query("select organisation.id, organisation.nom from transactions JOIN payment ON payment.id = transactions.id_payment JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation JOIN organisation ON organisation.id = transactions.id_organisation_assurance_ipm JOIN patient ON patient.id = transactions.id_patient_payeur where transactions.id_organisation_origine = ".$id_organisation." AND organisation.nom like '%" . $searchTerm . "%' GROUP BY organisation.id UNION ALL select organisation.id, organisation.nom from transactions JOIN payment ON payment.id = transactions.id_payment JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation JOIN organisation ON organisation.id = transactions.id_organisation_origine JOIN patient ON patient.id = transactions.id_patient_payeur where transactions.id_organisation_destinataire = ".$id_organisation."  AND organisation.nom like '%" . $searchTerm . "%' GROUP BY organisation.id UNION ALL select organisation.id, organisation.nom from transactions JOIN payment ON payment.id = transactions.id_payment JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation JOIN organisation ON organisation.id = transactions.id_organisation_light JOIN patient ON patient.id = transactions.id_patient_payeur where transactions.id_organisation_origine = ".$id_organisation." AND organisation.nom like '%" . $searchTerm . "%' GROUP BY organisation.id Limit 10");
            $users = $query->result();
        } else {
			$query = $this->db->query("select organisation.id, organisation.nom from transactions JOIN payment ON payment.id = transactions.id_payment JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation JOIN organisation ON organisation.id = transactions.id_organisation_assurance_ipm JOIN patient ON patient.id = transactions.id_patient_payeur where id_organisation_origine = ".$id_organisation." GROUP BY organisation.id UNION ALL select organisation.id, organisation.nom from transactions JOIN payment ON payment.id = transactions.id_payment JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation JOIN organisation ON organisation.id = transactions.id_organisation_origine JOIN patient ON patient.id = transactions.id_patient_payeur where id_organisation_destinataire = ".$id_organisation." GROUP BY organisation.id UNION ALL select organisation.id, organisation.nom from transactions JOIN payment ON payment.id = transactions.id_payment JOIN payment_category ON payment_category.id = transactions.id_prestation_organisation JOIN organisation ON organisation.id = transactions.id_organisation_light JOIN patient ON patient.id = transactions.id_patient_payeur where id_organisation_origine = ".$id_organisation."  GROUP BY organisation.id");
            $users = $query->result();
        }

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user->id, "text" => $user->nom);
        }
        return $data;
    }

    function searhPartenaireLightOriginByFacturebackup($searchTerm, $id_organisation) {
        $table = 'organisation';
        $partenariat_sante = 'partenariat_sante';
        if (!empty($searchTerm)) {
     		
			$query = $this->db->query("select organisation.* from partenariat_sante join organisation on partenariat_sante.id_organisation_origin = organisation.id and partenariat_sante.id_organisation_destinataire = ".$id_organisation." and (organisation.est_active OR organisation.is_light) AND nom like '%" . $searchTerm . "%' order by organisation.nom asc limit 10");
            $users = $query->result();
        } else {
			$query = $this->db->query("select organisation.* from partenariat_sante join organisation on partenariat_sante.id_organisation_origin = organisation.id and partenariat_sante.id_organisation_destinataire = ".$id_organisation." and (organisation.est_active OR organisation.is_light) order by organisation.nom asc limit 10");
            $users = $query->result();
        }

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user->id, "text" => $user->nom);
        }
        return $data;
    }
	
	function searhPartenaireByFature($searchTerm, $id_organisation) {
        $table = 'organisation';
        $partenariat_sante = 'partenariat_sante';
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->join($partenariat_sante, $partenariat_sante . '.id_organisation_origin=' . $table . '.id', 'left');
            $this->db->where($partenariat_sante .".id_organisation_origin == " . $id_organisation . " AND nom like '%" . $searchTerm . "%' AND organisation.type != 'Assurance'");

            //$this->db->where($partenariat_sante . ".partenariat_actif IS NULL");
            $this->db->where('organisation.est_active', 1);
            $this->db->order_by($partenariat_sante . '.idp', 'desc');
            $this->db->limit(10);
            $query = $this->db->get();
            $users = $query->result();
        } else {
            $this->db->select('*');
            $this->db->from($table);
            $this->db->join($partenariat_sante, $partenariat_sante . '.id_organisation_destinataire=' . $table . '.id', 'left');
         
            $this->db->where($partenariat_sante .".id_organisation_origin", $id_organisation);
            //$this->db->where($partenariat_sante . ".partenariat_actif IS NULL");
            $this->db->where('organisation.est_active', 1);
            $this->db->order_by($partenariat_sante . '.idp', 'desc');
            $this->db->limit(10);
            $query = $this->db->get();
            $users = $query->result();
        }

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user->id, "text" => $user->nom);
        }
        return $data;
    }
    
     function insertPaymentPro($data) {
        $table = 'payment_pro';
        $this->db->insert($table, $data);
    }


    
    function getPaymentProByID($idFacture) {
        // $this->db->where('payment_category.id', $id);
		$this->db->query("SET time_zone = '+00:00';");
        $query = $this->db->query("select DATE_FORMAT(FROM_UNIXTIME(`dateDebut`), '%d/%m/%y') AS dateDebut,
        DATE_FORMAT(FROM_UNIXTIME(`dateFin`), '%d/%m/%y') AS dateFin,date AS dateEmise
        FROM payment_pro
         WHERE codefacture =  '". $idFacture . "'
         ORDER BY dateEmise DESC");
         return $query->row();
    }
    
     function infoPartenaireByNewPatient($id) {        // var_dump($id);
        $organisation = 'organisation';
        $this->db->select('*');
        $this->db->from($organisation);
        $this->db->where($organisation . '.id', $id); 
        $query = $this->db->get();  
        return $query->row();
    }

	function getTablePartenaires($id_organisation) {
		$organisation = 'organisation';
		$partenariat_sante = 'partenariat_sante';
		$this->db->select('*');
		$this->db->from($organisation);
		$this->db->join($partenariat_sante, $partenariat_sante . '.id_organisation_destinataire=' . $organisation . '.id', 'left');
		//$this->db->where($organisation . '.is_light', 0);
		$this->db->where($partenariat_sante . '.id_organisation_origin', $id_organisation);
		$this->db->where($partenariat_sante . '.partenariat_actif', 1);
		$this->db->order_by($partenariat_sante . '.idp', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	function getTablePartenairesBySearch($search, $id_organisation) {
		$organisation = 'organisation';
		$partenariat_sante = 'partenariat_sante';
		$this->db->select('*');
		$this->db->from($organisation);
		$this->db->join($partenariat_sante, $partenariat_sante . '.id_organisation_destinataire=' . $organisation . '.id', 'left');
		//$this->db->where($organisation . '.is_light', 0);
		$this->db->where($partenariat_sante . '.id_organisation_origin', $id_organisation);
		$this->db->where($partenariat_sante . '.partenariat_actif', 1);
		$this->db->order_by($partenariat_sante . '.idp', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	function getTablePartenairesByLimit($limit, $start, $id_organisation) {
		$organisation = 'organisation';
		$partenariat_sante = 'partenariat_sante';
		$this->db->select('*');
		$this->db->from($organisation);
		$this->db->join($partenariat_sante, $partenariat_sante . '.id_organisation_destinataire=' . $organisation . '.id', 'left');
		//$this->db->where($organisation . '.is_light', 0);
		$this->db->where($partenariat_sante . '.id_organisation_origin', $id_organisation);
		$this->db->where($partenariat_sante . '.partenariat_actif', 1);
		$this->db->order_by($partenariat_sante . '.idp', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	function getTablePartenairesByLimitBySearch($limit, $start, $search, $id_organisation) {
		$organisation = 'organisation';
		$partenariat_sante = 'partenariat_sante';
		$this->db->select('*');
		$this->db->from($organisation);
		$this->db->join($partenariat_sante, $partenariat_sante . '.id_organisation_destinataire=' . $organisation . '.id', 'left');
		//$this->db->where($organisation . '.is_light', 0);
		$this->db->where($partenariat_sante . '.id_organisation_origin', $id_organisation);
		$this->db->where($partenariat_sante . '.partenariat_actif', 1);
		$this->db->order_by($partenariat_sante . '.idp', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	function payTableListeFactureByGroup($id_organisation, $etat, $status,$status2,$idDestinataire=null,$date1=null,$date2=null) {
		$organisation = 'organisation';
		$payment = 'payment';
		$patient = 'payment_pro';
		$this->db->select('payment.id as id, payment.date as date,payment.gross_total as gross_total, payment.code as code,payment.status_paid_pro as status_paid_pro,payment.status as status, payment.status_paid as status_paid,organisation.nom as nom, payment.patient as patient,payment.category_name_pro as category_name_pro, payment.organisation_destinataire as organisation_destinataire,payment.etat as etat,payment.id_organisation as id_organisation');
		$this->db->from($payment);
		$this->db->where($payment . '.id_organisation', $id_organisation);
		///$this->db->join($payment, $patient . '.codepro =' . $payment . '.code_pro', 'left');
		$this->db->join($organisation, $payment . '.id_organisation =' . $organisation . '.id', 'left');

		if(!empty($idDestinataire)) {
			$this->db->where($payment . '.organisation_destinataire !='. $idDestinataire);
			//$this->db->where($payment . '.date <='. $date1);
		}
		$this->db->where($payment . '.organisation_destinataire', $id_organisation);
		$this->db->where($payment . '.patient', null);
		$this->db->where($payment . '.etat', $etat);
		$this->db->where($payment . '.status', $status);
		if($status2) { $this->db->or_where($payment . '.status', $status2); }
		//  $this->db->where($payment . '.id_organisation', $organisation);
		$this->db->order_by($payment . '.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	function payTableListeFactureByGroupBySearch($search, $id_organisation, $etat, $status,$status2,$idDestinataire=null,$date1=null,$date2=null) {
		$organisation = 'organisation';
		$payment = 'payment';   $patient = 'payment_pro';
		$this->db->select('payment.id as id, payment.date as date,payment.gross_total as gross_total, payment.code as code,payment.status_paid_pro as status_paid_pro,payment.status as status, payment.status_paid as status_paid,organisation.nom as nom, payment.patient as patient,payment.category_name_pro as category_name_pro, payment.organisation_destinataire as organisation_destinataire,payment.etat as etat,payment.id_organisation as id_organisation');
		$this->db->from($payment);
		$this->db->where($payment . '.id_organisation', $id_organisation);
		///$this->db->join($payment, $patient . '.codepro =' . $payment . '.code_pro', 'left');
		$this->db->join($organisation, $payment . '.id_organisation =' . $organisation . '.id', 'left');

		if(!empty($idDestinataire)) {
			$this->db->where($payment . '.organisation_destinataire !='. $idDestinataire);
			//$this->db->where($payment . '.date <='. $date1);
		}
		$this->db->where($payment . '.organisation_destinataire', $id_organisation);
		$this->db->where($payment . '.patient', null);
		$this->db->where($payment . '.etat', $etat);
		$this->db->where($payment . '.status', $status);
		if($status2) { $this->db->or_where($payment . '.status', $status2); }
		$this->db->group_start();
		$this->db->like('payment.code', $search);
		$this->db->or_like('payment.nom', $search);
		$this->db->or_like('payment.gross_total', $search);
		$this->db->or_like('payment.status_paid_pro', $search);
		$this->db->group_end();
		//  $this->db->where($payment . '.id_organisation', $organisation);
		$this->db->order_by($payment . '.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	function payTableListeFactureByGroupByLimit($limit, $start, $id_organisation, $etat, $status,$status2,$idDestinataire=null,$date1=null,$date2=null) {
		$organisation = 'organisation';
		$payment = 'payment';   $patient = 'payment_pro';
		$this->db->select('payment.id as id, payment.date as date,payment.gross_total as gross_total, payment.code as code,payment.status_paid_pro as status_paid_pro,payment.status as status, payment.status_paid as status_paid,organisation.nom as nom, payment.patient as patient,payment.category_name_pro as category_name_pro, payment.organisation_destinataire as organisation_destinataire,payment.etat as etat,payment.id_organisation as id_organisation');
		$this->db->from($payment);
		$this->db->where($payment . '.id_organisation', $id_organisation);
		///$this->db->join($payment, $patient . '.codepro =' . $payment . '.code_pro', 'left');
		$this->db->join($organisation, $payment . '.id_organisation =' . $organisation . '.id', 'left');

		if(!empty($idDestinataire)) {
			$this->db->where($payment . '.organisation_destinataire !='. $idDestinataire);
			//$this->db->where($payment . '.date <='. $date1);
		}
		$this->db->where($payment . '.organisation_destinataire', $id_organisation);
		$this->db->where($payment . '.patient', null);
		$this->db->where($payment . '.etat', $etat);
		$this->db->where($payment . '.status', $status);
		if($status2) { $this->db->or_where($payment . '.status', $status2); }
		$this->db->limit($limit, $start);
		//  $this->db->where($payment . '.id_organisation', $organisation);
		$this->db->order_by($payment . '.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	function payTableListeFactureByGroupByLimitBySearch($limit, $start, $search, $id_organisation, $etat, $status,$status2,$idDestinataire=null,$date1=null,$date2=null) {
		$organisation = 'organisation';
		$payment = 'payment';   $patient = 'payment_pro';
		$this->db->select('payment.id as id, payment.date as date,payment.gross_total as gross_total, payment.code as code,payment.status_paid_pro as status_paid_pro,payment.status as status, payment.status_paid as status_paid,organisation.nom as nom, payment.patient as patient,payment.category_name_pro as category_name_pro, payment.organisation_destinataire as organisation_destinataire,payment.etat as etat,payment.id_organisation as id_organisation');
		$this->db->from($payment);
		$this->db->where($payment . '.id_organisation', $id_organisation);
		///$this->db->join($payment, $patient . '.codepro =' . $payment . '.code_pro', 'left');
		$this->db->join($organisation, $payment . '.id_organisation =' . $organisation . '.id', 'left');

		if(!empty($idDestinataire)) {
			$this->db->where($payment . '.organisation_destinataire !='. $idDestinataire);
			//$this->db->where($payment . '.date <='. $date1);
		}
		$this->db->where($payment . '.organisation_destinataire', $id_organisation);
		$this->db->where($payment . '.patient', null);
		$this->db->where($payment . '.etat', $etat);
		$this->db->where($payment . '.status', $status);
		if($status2) { $this->db->or_where($payment . '.status', $status2); }
		$this->db->group_start();
		$this->db->like('payment.code', $search);
		$this->db->or_like('payment.nom', $search);
		$this->db->or_like('payment.gross_total', $search);
		$this->db->or_like('payment.status_paid_pro', $search);
		$this->db->group_end();
		$this->db->limit($limit, $start);
		//  $this->db->where($payment . '.id_organisation', $organisation);
		$this->db->order_by($payment . '.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

   

}
