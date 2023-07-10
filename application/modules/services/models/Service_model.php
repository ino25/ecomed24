<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Service_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertService($data) {
        $table = 'setting_service';
        $this->db->insert($table, $data);
    }

    function getService($id = null) {
        $setting_service = 'setting_service';
        $setting_department = 'department';
        $this->db->select('*');
        $this->db->from($setting_service);
        $this->db->join($setting_department, $setting_department . '.id=' . $setting_service . '.id_department', 'left');
        if ($id) {
            $this->db->where($setting_service . '.idservice', $id);
        }
        $this->db->where($setting_service . '.status_service', 1);
       
        $this->db->order_by($setting_service . '.idservice', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
	
	function getGenericServicesAndCoverage($id_organisation) {
	   $query = $this->db->query("select setting_service.idservice, setting_service_specialite.idspe, setting_service.name_service, setting_service_specialite.name_specialite,setting_service.description_service,setting_service.code_service,(CASE WHEN setting_service_specialite_organisation.statut IS NULL THEN '0' ELSE setting_service_specialite_organisation.statut END) as est_couvert from setting_service left join setting_service_specialite on setting_service_specialite.id_service = setting_service.idservice left join setting_service_specialite_organisation on setting_service.idservice = setting_service_specialite_organisation.id_service and setting_service_specialite_organisation.id_specialite = setting_service_specialite.idspe and setting_service_specialite_organisation.id_organisation = ".$id_organisation." where setting_service.id_organisation is NULL and setting_service.status_service = 1 order by setting_service.idservice desc");
        return $query->result();
    }
	
	function getPrestationsPanier($id_organisation) {
		$query = $this->db->query("select payment_category.id as ID,setting_service.name_service, setting_service_specialite.name_specialite, payment_category.prestation, payment_category.code_prestation, payment_category.cotation, payment_category.coefficient from payment_category_panier join payment_category on payment_category.id = payment_category_panier.id_prestation join setting_service on setting_service.idservice = payment_category.id_service join setting_service_specialite on setting_service_specialite.id_service = setting_service.idservice and setting_service_specialite.idspe = payment_category.id_spe where payment_category_panier.id_organisation = ".$id_organisation." and payment_category_panier.statut = 1");
		return $query->result();
	}
	function addRemovePrestationPanier($id_organisation, $id_prestation, $statut) {
		// 3 88 96 1
		$existeDeja = $this->db->query("select id from payment_category_panier where id_organisation = ".$id_organisation." and id_prestation=".$id_prestation)->num_rows();
			
        if ($statut == 1) { // Si now couverte: on supprime de la table des exceptions
			if($existeDeja) {
				// Update
				$this->db->query("update payment_category_panier set statut = 1 where id_organisation = ".$id_organisation." and id_prestation=".$id_prestation);
			} else {
				// Insertion
				$this->db->query("insert into payment_category_panier (id_prestation, id_organisation, statut) values(".$id_prestation.", ".$id_organisation.", 1)");
			}
        } else { // Sinon: on insere
			if($existeDeja) {
				// Update
				$this->db->query("update payment_category_panier set statut = 0 where id_organisation = ".$id_organisation." and id_prestation=".$id_prestation);
			}
			// Devrait exister si passage à 0 donc pas de else
        }
    }
	
	
	function addRemoveServiceSpecialiteOrganisation($id_organisation, $id_service, $id_specialite, $statut) {
		// 3 88 96 1
		$existeDeja = $this->db->query("select id from setting_service_specialite_organisation where id_organisation = ".$id_organisation." and id_service=".$id_service." and id_specialite=".$id_specialite)->num_rows();
			
        if ($statut == 1) { // Si now couverte: on supprime de la table des exceptions
			if($existeDeja) {
				// Update
				$this->db->query("update setting_service_specialite_organisation set statut = 1 where id_organisation = ".$id_organisation." and id_service=".$id_service." and id_specialite=".$id_specialite);
			} else {
				// Insertion
				$this->db->query("insert into setting_service_specialite_organisation (id_service, id_specialite, id_organisation, statut) values(".$id_service.", ".$id_specialite.", ".$id_organisation.", 1)");
			}
        } else { // Sinon: on insere
			if($existeDeja) {
				// Update
				$this->db->query("update setting_service_specialite_organisation set statut = 0 where id_organisation = ".$id_organisation." and id_service=".$id_service." and id_specialite=".$id_specialite);
			}
			// Devrait exister si passage à 0 donc pas de else
        }
    }
	
	function getGenericServices() {
	   $query = $this->db->query("select * from setting_service left join setting_service_specialite on setting_service_specialite.id_service = setting_service.idservice where setting_service.id_organisation is NULL and setting_service.status_service = 1 order by setting_service.idservice desc");
        return $query->result();
    }
	
	function getGenericServicesLabo() {
	   $query = $this->db->query("select * from setting_service left join setting_service_specialite on setting_service_specialite.id_service = setting_service.idservice where setting_service.id_organisation is NULL and setting_service.status_service = 1 and code_service = 'labo' order by setting_service.idservice desc");
        return $query->result();
    }
	
	function getGenericServicesAutres() {
	   $query = $this->db->query("select * from setting_service left join setting_service_specialite on setting_service_specialite.id_service = setting_service.idservice where setting_service.id_organisation is NULL and setting_service.status_service = 1 and code_service != 'labo' order by setting_service.idservice desc");
        return $query->result();
    }
	
	function getGenericPrestations() {
        $query = $this->db->query("select payment_category.id, payment_category.prestation, payment_category.keywords, setting_service.name_service, setting_service.idservice, setting_service.code_service, setting_service_specialite.name_specialite, payment_category.cotation, payment_category.coefficient from payment_category join setting_service on setting_service.idservice = payment_category.id_service and setting_service.id_organisation is NULL and setting_service.status_service = 1 join setting_service_specialite on setting_service_specialite.idspe = payment_category.id_spe order by payment_category.id desc");
         return $query->result();
     }
	
	function getPrestationsOrganisationEncoreDispo($id_organisation) {
	   // $query = $this->db->query("select payment_category.id, payment_category.prestation, setting_service.name_service, setting_service.idservice, setting_service.code_service, setting_service_specialite.name_specialite,(CASE WHEN payment_category_panier.statut IS NULL THEN '0' ELSE payment_category_panier.statut END) as est_dans_panier from payment_category left join payment_category_organisation on payment_category_organisation.id_presta = payment_category.id and payment_category_organisation.id_organisation = ".$id_organisation." join setting_service_specialite_organisation on setting_service_specialite_organisation.id_service = payment_category.id_service and setting_service_specialite_organisation.id_organisation = ".$id_organisation." join setting_service on setting_service.idservice = setting_service_specialite_organisation.id_service and setting_service.status_service = 1 join setting_service_specialite on setting_service_specialite.idspe = payment_category.id_spe left join payment_category_panier on payment_category_panier.id_prestation = payment_category.id and payment_category_panier.id_organisation = ".$id_organisation." where payment_category_organisation.idpco IS NULL group by payment_category.id order by payment_category.id desc");
	   $query = $this->db->query("select payment_category.id, payment_category.prestation,payment_category.keywords, setting_service.name_service, setting_service.idservice, setting_service.code_service, setting_service_specialite.name_specialite,(CASE WHEN payment_category_panier.statut IS NULL THEN '0' ELSE payment_category_panier.statut END) as est_dans_panier from setting_service_specialite_organisation join payment_category on setting_service_specialite_organisation.id_service = payment_category.id_service and setting_service_specialite_organisation.id_organisation = ".$id_organisation." and payment_category.id_spe = setting_service_specialite_organisation.id_specialite left join payment_category_organisation on payment_category_organisation.id_presta = payment_category.id and payment_category_organisation.id_organisation = ".$id_organisation." join setting_service on setting_service.idservice = setting_service_specialite_organisation.id_service and setting_service.status_service = 1 join setting_service_specialite on setting_service_specialite.idspe = payment_category.id_spe left join payment_category_panier on payment_category_panier.id_prestation = payment_category.id and payment_category_panier.id_organisation = ".$id_organisation." where payment_category_organisation.idpco IS NULL group by payment_category.id order by payment_category.id desc;");
        return $query->result();
    }
	
	function getPrestationsOrganisation($id_organisation) {
	   $query = $this->db->query("select payment_category.id, payment_category.prestation,payment_category.keywords, setting_service.name_service, setting_service.idservice, setting_service.code_service, setting_service_specialite.name_specialite,payment_category_organisation.idpco, payment_category_organisation.id_presta, payment_category_organisation.tarif_public, payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm from payment_category_organisation join payment_category on payment_category_organisation.id_presta = payment_category.id and payment_category_organisation.id_organisation = ".$id_organisation." join setting_service_specialite_organisation on payment_category.id_service = setting_service_specialite_organisation.id_service and setting_service_specialite_organisation.id_organisation = ".$id_organisation." join setting_service on setting_service.idservice = setting_service_specialite_organisation.id_service and setting_service.status_service = 1 join setting_service_specialite on setting_service_specialite.idspe = payment_category.id_spe left join pco_changes_history on pco_changes_history.idpco = payment_category_organisation.idpco group by payment_category_organisation.id_presta order by pco_changes_history.id desc");
        return $query->result();
    }

	function getPCODetails($idpco, $id_organisation) {
	   $query = $this->db->query("select payment_category.id, payment_category.prestation,payment_category.keywords, setting_service.name_service, setting_service.idservice, setting_service.code_service, setting_service_specialite.name_specialite,payment_category_organisation.idpco, payment_category_organisation.id_presta, payment_category_organisation.tarif_public, payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm, payment_category_organisation.prix_public from payment_category_organisation join payment_category on payment_category_organisation.id_presta = payment_category.id and payment_category_organisation.id_organisation = ".$id_organisation." and payment_category_organisation.idpco = ". $idpco ." join setting_service_specialite_organisation on payment_category.id_service = setting_service_specialite_organisation.id_service and setting_service_specialite_organisation.id_organisation = ".$id_organisation." join setting_service on setting_service.idservice = setting_service_specialite_organisation.id_service and setting_service.status_service = 1 join setting_service_specialite on setting_service_specialite.idspe = payment_category.id_spe group by payment_category_organisation.id_presta order by payment_category.id desc");
        return $query->row();
    }
	
	function estCouverteDansPartenariatAssurance($id_assurance, $id_organisation, $id_prestation) {
		$id_partenariat = $this->db->query("select id from partenariat_sante_assurance where id_organisation_sante=".$id_organisation." and id_organisation_assurance=".$id_assurance)->row()->id;
		$query = $this->db->query("select (CASE WHEN sante_assurance_prestation.est_couverte IS NULL THEN '1' ELSE '0' END) as est_couverte from sante_assurance_prestation where id_partenariat_sante_assurance = ".$id_partenariat." AND id_payment_category=".$id_prestation);
		return $query->row()->est_couverte;
	}
	function getPrestationsServiceOrganisationByJson($id_service_specialite_organisation, $id_assurance = 0) { // $id_organisation déjà d
		$bonus_select ="";
		$bonus_clause ="";
		if($id_assurance) {
			$id_organisation = $this->db->query("select id_organisation from setting_service_specialite_organisation where id = ".$id_service_specialite_organisation)->row()->id_organisation;
			$id_partenariat = $this->db->query("select id from partenariat_sante_assurance where id_organisation_sante=".$id_organisation." and id_organisation_assurance=".$id_assurance)->row()->id;
			$bonus_select = ",(CASE WHEN sante_assurance_prestation.est_couverte IS NULL THEN '1' ELSE '0' END) as est_couverte ";
			// $bonus_select = ",(select 'maybe') as est_couverte ";
			$bonus_clause = " left join sante_assurance_prestation on sante_assurance_prestation.id_partenariat_sante_assurance = " . $id_partenariat . " AND sante_assurance_prestation.id_payment_category = payment_category_organisation.id_presta  ";
			// $bonus_clause = "  ";
		}
	   // $query = $this->db->query("select payment_category.id, payment_category.prestation, setting_service.name_service, setting_service.idservice, setting_service.code_service, setting_service_specialite.name_specialite,payment_category_organisation.idpco, payment_category_organisation.id_presta, payment_category_organisation.tarif_public, payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm from payment_category_organisation join payment_category on payment_category_organisation.id_presta = payment_category.id and payment_category_organisation.id_organisation = ".$id_organisation." join setting_service_specialite_organisation on payment_category.id_service = setting_service_specialite_organisation.id_service and setting_service_specialite_organisation.id_organisation = ".$id_organisation." join setting_service on setting_service.idservice = setting_service_specialite_organisation.id_service and setting_service.status_service = 1 and setting_service.idservice = ".$id_service." join setting_service_specialite on setting_service_specialite.idspe = payment_category.id_spe group by payment_category_organisation.id_presta order by payment_category.id desc");
	   $query = $this->db->query("select payment_category.id, payment_category.prestation,payment_category_organisation.tarif_public, payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm, setting_service_specialite.name_specialite ".$bonus_select." from setting_service_specialite_organisation join setting_service_specialite on setting_service_specialite.idspe = setting_service_specialite_organisation.id_specialite and setting_service_specialite_organisation.statut = 1 join setting_service on setting_service_specialite_organisation.id_service = setting_service.idservice and setting_service_specialite_organisation.id = ".$id_service_specialite_organisation." and setting_service_specialite_organisation.statut = 1 join payment_category on payment_category.id_service = setting_service.idservice and payment_category.id_spe = setting_service_specialite_organisation.id_specialite join payment_category_organisation on payment_category_organisation.id_presta = payment_category.id and payment_category_organisation.id_organisation = setting_service_specialite_organisation.id_organisation ".$bonus_clause." order by payment_category.prestation asc");
	   // $query = $this->db->query("select payment_category.id, payment_category.prestation,payment_category_organisation.tarif_public, payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm  from setting_service_specialite_organisation join setting_service on setting_service_specialite_organisation.id_service = setting_service.idservice and setting_service_specialite_organisation.id = 3 join payment_category on payment_category.id_service = setting_service.idservice and payment_category.id_spe = setting_service_specialite_organisation.id_specialite join payment_category_organisation on payment_category_organisation.id_presta = payment_category.id and payment_category_organisation.id_organisation = setting_service_specialite_organisation.id_organisation order by payment_category.prestation asc");
	   // select payment_category.id, payment_category.prestation,payment_category_organisation.tarif_public, payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm  from payment_category_organisation join payment_category on payment_category_organisation.id_presta = payment_category.id and payment_category.id_spe = 108 join setting_service_specialite_organisation on setting_service_specialite_organisation.id_specialite = payment_category.id_spe and payment_category.id_service = setting_service_specialite_organisation.id_service join setting_service on setting_service_specialite_organisation.id_service = setting_service.idservice order by payment_category.prestation asc
        return $query->result();
    }


    function getPrestationsServiceOrganisationLabo($id_service_specialite_organisation, $id_assurance = 0) { // $id_organisation déjà d
		$bonus_select ="";
		$bonus_clause ="";
		if($id_assurance) {
			$id_organisation = $this->db->query("select id_organisation from setting_service_specialite_organisation where id = ".$id_service_specialite_organisation)->row()->id_organisation;
			$id_partenariat = $this->db->query("select id from partenariat_sante_assurance where id_organisation_sante=".$id_organisation." and id_organisation_assurance=".$id_assurance)->row()->id;
			$bonus_select = ",(CASE WHEN sante_assurance_prestation.est_couverte IS NULL THEN '1' ELSE '0' END) as est_couverte ";
			// $bonus_select = ",(select 'maybe') as est_couverte ";
			$bonus_clause = " left join sante_assurance_prestation on sante_assurance_prestation.id_partenariat_sante_assurance = " . $id_partenariat . " AND sante_assurance_prestation.id_payment_category = payment_category_organisation.id_presta  ";
			// $bonus_clause = "  ";
		}
	   // $query = $this->db->query("select payment_category.id, payment_category.prestation, setting_service.name_service, setting_service.idservice, setting_service.code_service, setting_service_specialite.name_specialite,payment_category_organisation.idpco, payment_category_organisation.id_presta, payment_category_organisation.tarif_public, payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm from payment_category_organisation join payment_category on payment_category_organisation.id_presta = payment_category.id and payment_category_organisation.id_organisation = ".$id_organisation." join setting_service_specialite_organisation on payment_category.id_service = setting_service_specialite_organisation.id_service and setting_service_specialite_organisation.id_organisation = ".$id_organisation." join setting_service on setting_service.idservice = setting_service_specialite_organisation.id_service and setting_service.status_service = 1 and setting_service.idservice = ".$id_service." join setting_service_specialite on setting_service_specialite.idspe = payment_category.id_spe group by payment_category_organisation.id_presta order by payment_category.id desc");
	   $query = $this->db->query("select payment_category.id, payment_category.prestation,payment_category.tarif_public, payment_category.tarif_professionnel, payment_category.tarif_assurance, payment_category.tarif_ipm, setting_service_specialite.name_specialite from setting_service join setting_service_specialite on setting_service_specialite.id_service = setting_service.idservice and setting_service_specialite.idspe = ".$id_service_specialite_organisation." join payment_category on payment_category.id_service = setting_service.idservice and payment_category.id_spe = setting_service_specialite.idspe order by payment_category.prestation asc");
	   // $query = $this->db->query("select payment_category.id, payment_category.prestation,payment_category_organisation.tarif_public, payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm  from setting_service_specialite_organisation join setting_service on setting_service_specialite_organisation.id_service = setting_service.idservice and setting_service_specialite_organisation.id = 3 join payment_category on payment_category.id_service = setting_service.idservice and payment_category.id_spe = setting_service_specialite_organisation.id_specialite join payment_category_organisation on payment_category_organisation.id_presta = payment_category.id and payment_category_organisation.id_organisation = setting_service_specialite_organisation.id_organisation order by payment_category.prestation asc");
	   // select payment_category.id, payment_category.prestation,payment_category_organisation.tarif_public, payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm  from payment_category_organisation join payment_category on payment_category_organisation.id_presta = payment_category.id and payment_category.id_spe = 108 join setting_service_specialite_organisation on setting_service_specialite_organisation.id_specialite = payment_category.id_spe and payment_category.id_service = setting_service_specialite_organisation.id_service join setting_service on setting_service_specialite_organisation.id_service = setting_service.idservice order by payment_category.prestation asc
        return $query->result();
    }

    function getPrestationsImagerieServiceOrganisationByJson($id_service_specialite_organisation, $id_assurance = 0) { // $id_organisation déjà d
		$bonus_select ="";
		$bonus_clause ="";
		if($id_assurance) {
			$id_organisation = $this->db->query("select id_organisation from setting_service_specialite_organisation where id = ".$id_service_specialite_organisation)->row()->id_organisation;
			$id_partenariat = $this->db->query("select id from partenariat_sante_assurance where id_organisation_sante=".$id_organisation." and id_organisation_assurance=".$id_assurance)->row()->id;
			$bonus_select = ",(CASE WHEN sante_assurance_prestation.est_couverte IS NULL THEN '1' ELSE '0' END) as est_couverte ";
			// $bonus_select = ",(select 'maybe') as est_couverte ";
			$bonus_clause = " left join sante_assurance_prestation on sante_assurance_prestation.id_partenariat_sante_assurance = " . $id_partenariat . " AND sante_assurance_prestation.id_payment_category = payment_category_organisation.id_presta  ";
			// $bonus_clause = "  ";
		}
	   // $query = $this->db->query("select payment_category.id, payment_category.prestation, setting_service.name_service, setting_service.idservice, setting_service.code_service, setting_service_specialite.name_specialite,payment_category_organisation.idpco, payment_category_organisation.id_presta, payment_category_organisation.tarif_public, payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm from payment_category_organisation join payment_category on payment_category_organisation.id_presta = payment_category.id and payment_category_organisation.id_organisation = ".$id_organisation." join setting_service_specialite_organisation on payment_category.id_service = setting_service_specialite_organisation.id_service and setting_service_specialite_organisation.id_organisation = ".$id_organisation." join setting_service on setting_service.idservice = setting_service_specialite_organisation.id_service and setting_service.status_service = 1 and setting_service.idservice = ".$id_service." join setting_service_specialite on setting_service_specialite.idspe = payment_category.id_spe group by payment_category_organisation.id_presta order by payment_category.id desc");
	   $query = $this->db->query("select payment_category.id, payment_category.prestation,payment_category.tarif_public, payment_category.tarif_professionnel, payment_category.tarif_assurance, payment_category.tarif_ipm, setting_service_specialite.name_specialite from setting_service join setting_service_specialite on setting_service_specialite.id_service = setting_service.idservice and setting_service_specialite.idspe = ".$id_service_specialite_organisation." join payment_category on payment_category.id_service = setting_service.idservice and payment_category.id_spe = setting_service_specialite.idspe order by payment_category.prestation asc");
	   // $query = $this->db->query("select payment_category.id, payment_category.prestation,payment_category_organisation.tarif_public, payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm  from setting_service_specialite_organisation join setting_service on setting_service_specialite_organisation.id_service = setting_service.idservice and setting_service_specialite_organisation.id = 3 join payment_category on payment_category.id_service = setting_service.idservice and payment_category.id_spe = setting_service_specialite_organisation.id_specialite join payment_category_organisation on payment_category_organisation.id_presta = payment_category.id and payment_category_organisation.id_organisation = setting_service_specialite_organisation.id_organisation order by payment_category.prestation asc");
	   // select payment_category.id, payment_category.prestation,payment_category_organisation.tarif_public, payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm  from payment_category_organisation join payment_category on payment_category_organisation.id_presta = payment_category.id and payment_category.id_spe = 108 join setting_service_specialite_organisation on setting_service_specialite_organisation.id_specialite = payment_category.id_spe and payment_category.id_service = setting_service_specialite_organisation.id_service join setting_service on setting_service_specialite_organisation.id_service = setting_service.idservice order by payment_category.prestation asc
        return $query->result();
    }
    
    function getPrestationsSansService($id_assurance = 0,$id_organisation,$search='') {
		$bonus_select ="";
		$bonus_clause =""; 
		$search_nom =""; 
		// Ce bloc ne fait pas de sens ici: car id_assurance n'est jamais renseigné correctement
		if($id_assurance) {
			$id_partenariat = $this->db->query("select id from partenariat_sante_assurance where id_organisation_sante=".$id_organisation." and id_organisation_assurance=".$id_assurance)->row()->id;
			$bonus_select = ",(CASE WHEN sante_assurance_prestation.est_couverte IS NULL THEN '1' ELSE '0' END) as est_couverte ";
			$bonus_clause = " left join sante_assurance_prestation on sante_assurance_prestation.id_partenariat_sante_assurance = " . $id_partenariat . " AND sante_assurance_prestation.id_payment_category = payment_category_organisation.id_presta  ";
			
		}
		// End
                if(!empty($search)) {
                   $search_nom =" AND payment_category.prestation like '%" . $search . "%'";
                }
				$query = $this->db->query("select payment_category.id, payment_category.prestation,payment_category_organisation.tarif_public, payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance, payment_category_organisation.tarif_ipm, setting_service_specialite.name_specialite ".$bonus_select." from setting_service_specialite_organisation join setting_service_specialite on setting_service_specialite.idspe = setting_service_specialite_organisation.id_specialite and setting_service_specialite_organisation.statut = 1 join setting_service on setting_service_specialite_organisation.id_service = setting_service.idservice and setting_service_specialite_organisation.id_organisation = ".$id_organisation." and setting_service_specialite_organisation.statut = 1 join payment_category on payment_category.id_service = setting_service.idservice and payment_category.id_spe = setting_service_specialite_organisation.id_specialite join payment_category_organisation on payment_category_organisation.id_presta = payment_category.id and payment_category_organisation.id_organisation = setting_service_specialite_organisation.id_organisation ".$bonus_clause." order by payment_category.prestation asc");
				
                // $sql = "select payment_category.id,setting_service_specialite_organisation.statut,"
                    // . " payment_category.prestation,payment_category_organisation.tarif_public,"
                    // . " payment_category_organisation.tarif_professionnel,"
                    // . " payment_category_organisation.tarif_assurance,"
                    // . " payment_category_organisation.tarif_ipm ".$bonus_select." "
                    // . "from setting_service_specialite_organisation "
                    // . "join setting_service on setting_service_specialite_organisation.id_service = setting_service.idservice "
                    // . "join payment_category on payment_category.id_service = setting_service.idservice "
                    // . "and payment_category.id_spe = setting_service_specialite_organisation.id_specialite "
                    // . "join payment_category_organisation on payment_category_organisation.id_presta = payment_category.id "
                    // . "and payment_category_organisation.id_organisation = setting_service_specialite_organisation.id_organisation ".$bonus_clause."  ".$search_nom." "
                     // ." and payment_category_organisation.id_organisation =  ".$id_organisation." and setting_service_specialite_organisation.statut = 1 "
                    // . "order by payment_category.prestation asc";
              //  echo $sql;
	    // $query = $this->db->query($sql);
	    return $query->result();
    }


    function getPrestationsSansServiceLabo($search='') {
		$bonus_select ="";
		$bonus_clause =""; 
		$search_nom =""; 
		
                if(!empty($search)) {
                   $search_nom =" AND payment_category.prestation like '%" . $search . "%'";
                }
				$query = $this->db->query("select payment_category.id, payment_category.prestation,payment_category.tarif_public, payment_category.tarif_professionnel, payment_category.tarif_assurance, payment_category.tarif_ipm, setting_service_specialite.name_specialite ".$bonus_select."  from setting_service join setting_service_specialite on setting_service_specialite.id_service = setting_service.idservice join payment_category on payment_category.id_service = setting_service.idservice and payment_category.id_spe = setting_service_specialite.idspe and setting_service.code_service like 'labo' ".$bonus_clause." order by payment_category.prestation asc");
				
	    return $query->result();
    }


    function getPrestationsImagerieSansService($id_assurance = 0,$id_organisation,$search='') {
		$bonus_select ="";
		$bonus_clause =""; 
		$search_nom =""; 
		
                if(!empty($search)) {
                   $search_nom =" AND payment_category.prestation like '%" . $search . "%'";
                }
				$query = $this->db->query("select payment_category.id, payment_category.prestation,payment_category.tarif_public, payment_category.tarif_professionnel, payment_category.tarif_assurance, payment_category.tarif_ipm, setting_service_specialite.name_specialite ".$bonus_select."  from setting_service join setting_service_specialite on setting_service_specialite.id_service = setting_service.idservice join payment_category on payment_category.id_service = setting_service.idservice and payment_category.id_spe = setting_service_specialite.idspe and setting_service.code_service like '' ".$bonus_clause." order by payment_category.prestation asc");
				
	    return $query->result();
    }
	
	function getSuperPrestationParams($id_prestation) {
		$query = $this->db->query("select idpara, nom_parametre, unite, valeurs, ref_low, ref_high, type, set_of_code from payment_category_parametre where payment_category_parametre.id_prestation = ".$id_prestation." order by idpara ASC");
		return $query->result();
		
	}
	function getSuperPrestationDescription($id_prestation) {
		$query = $this->db->query("select description from payment_category where id=".$id_prestation);
		return $query->row();
	}
	
	function getSuperPrestationDescriptionAndKeywords($id_prestation) {
		$query = $this->db->query("select description, keywords from payment_category where id=".$id_prestation);
		return $query->row();
	}
	
	function editPrestationSpecialite($id_prestation, $newName, $nom_service) {
		$id_service = $this->db->query("select idservice from setting_service where name_service = \"" . $nom_service . "\" and id_organisation is NULL")->row()->idservice;
		$id_spe = $this->db->query("select (CASE WHEN `setting_service_specialite`.idspe IS NOT NULL THEN (SELECT `setting_service_specialite`.idspe) ELSE (SELECT '') END) as idspe from setting_service_specialite join setting_service on setting_service.idservice = setting_service_specialite.id_service and setting_service.idservice = ".$id_service."  and id_organisation is NULL where name_specialite = \"" . $newName . "\"")->row()->idspe;
		
		$this->db->query("update payment_category set id_spe = ".$id_spe." where id = ".$id_prestation);
		return "OK";
		
		// Check si le nom de la prestation existe déjà pour le service
		// $prestationExiste = $this->db->query("select id from payment_category join setting_service on setting_service.idservice = payment_category.id_service and setting_service.name_service = \"".$nomService."\" and setting_service.id_organisation is NULL and payment_category.prestation=\"".$newName."\" and payment_category.id != ".$id_prestation)->num_rows();
		// if($prestationExiste) {
			// return "KO";
		// }
		// $query = $this->db->query("update payment_category set prestation = \"".$newName."\" where id=".$id_prestation);
		// return "OK";
		// return $query->row();
	}

    function editPrestationName($id_prestation, $newName, $nomService) {
		// Check si le nom de la prestation existe déjà pour le service
		$prestationExiste = $this->db->query("select id from payment_category join setting_service on setting_service.idservice = payment_category.id_service and setting_service.name_service = \"".$nomService."\" and setting_service.id_organisation is NULL and payment_category.prestation=\"".$newName."\" and payment_category.id != ".$id_prestation)->num_rows();
		if($prestationExiste) {
			return "KO";
		}
		$query = $this->db->query("update payment_category set prestation = \"".$newName."\" where id=".$id_prestation);
		return "OK";
		// return $query->row();
	}

    function editParamName($id_prestation, $id_parametre, $newName) {
		
		$id_spe = $this->db->query("select id_specialite from payment_category_parametre where idpara =".$id_parametre)->row()->id_specialite." order by idpara ASC";
		// Check si le nom de la prestation existe déjà pour le service
		$parametreExiste = $this->db->query("select idpara from payment_category_parametre join payment_category on payment_category.id = payment_category_parametre.id_prestation and payment_category.id = ".$id_prestation." join setting_service_specialite on setting_service_specialite.idspe = payment_category_parametre.id_specialite and setting_service_specialite.idspe = ".$id_spe." where payment_category_parametre.nom_parametre =\"".$newName."\" and payment_category_parametre.idpara != ".$id_parametre)->num_rows()." order by payment_category_parametre.idpara ASC";
		if($parametreExiste) {
			return "KO";
		}
		$query = $this->db->query("update payment_category_parametre set nom_parametre = \"".$newName."\" where idpara=".$id_parametre);
		return "OK";
		// return $query->row();
	}
	
	function editParamUnite($id_parametre, $newUnite) {
		$query = $this->db->query("update payment_category_parametre set unite = \"".$newUnite."\" where idpara=".$id_parametre);
		return "OK";
		// return $query->row();
	}

    function editRefLow($id_parametre, $newRefLow) {
		
        if($query = $this->db->query("update payment_category_parametre set ref_low = \"".$newRefLow."\" where idpara=".$id_parametre)){
            return "OK";

        }
        
		// return $query->row();
	}

    function editRefHigh($id_parametre, $newRefHigh) {
		if($query = $this->db->query("update payment_category_parametre set ref_high = \"".$newRefHigh."\" where idpara=".$id_parametre)){
            return "OK";

        }
		// return $query->row();
	}
	
	function editParamValeurs($id_parametre, $newValeurs) {
		$query = $this->db->query("update payment_category_parametre set valeurs = \"".$newValeurs."\" where idpara=".$id_parametre);
		return "OK";
		// return $query->row();
	}
	
    function editPrestationDescription($id_prestation, $newDescription) {
		$query = $this->db->query("update payment_category set description = \"".$newDescription."\" where id=".$id_prestation);
		return "OK";
		// return $query->row();
	}
	
	
	function editPrestationKeywords($id_prestation, $newKeywords) {
		$query = $this->db->query("update payment_category set keywords = \"".$newKeywords."\" where id=".$id_prestation);
		return "OK";
		// return $query->row();
	}
	
	function getServiceByOrganisation($id_organisation, $id_service = '') {  
        $setting_service = 'setting_service';
        $setting_department = 'department';
        $this->db->select('*');
        $this->db->from($setting_service);
        $this->db->join($setting_department, $setting_department . '.id=' . $setting_service . '.id_department', 'left');
       $this->db->join("organisation", "organisation.id = department.id_organisation AND organisation.id = ".$id_organisation);
        if ($id_service) {
            $this->db->where($setting_service . '.idservice', $id_service);
        }
        $this->db->where($setting_service . '.status_service', 1);
       
        $this->db->order_by($setting_service . '.idservice', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getServiceById($id) {
        $table = 'setting_service';
        $this->db->where('idservice', $id);
        $query = $this->db->get($table);
        return $query->row();
    }

    function updateService($id,$data) {
        $table =  'setting_service';
        $this->db->where('idservice', $id);
        $this->db->update($table, $data);
    }

    function delete($id) {
        $table =  'setting_service';
        $this->db->where('idservice', $id);
        //$this->db->delete($table);
        $this->db->update($table, array('status_service' => NULL));
    }

    function editserviceBydepartement($id) {
        $table = 'setting_service';
        $this->db->where('id_department', $id);
        $query = $this->db->get($table);
        return $query->result();
    }

    function getServiceAll($id = null) {
        $setting_service = 'setting_service';
        $this->db->select('*');
        $this->db->from($setting_service);
        if ($id) {
            $this->db->where($setting_service . '.idservice', $id);
        }

        $this->db->or_like($setting_service . '.status_service', 1);
        $this->db->order_by($setting_service . '.idservice', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
    
     function getSericeinfoByJason($searchTerm,$id_organisation) {
         $table =  'setting_service';
        if (!empty($searchTerm)) {
            $this->db->select('*');
            //$this->db->where("name_service like '%" . $searchTerm . "%' AND id_organisation == ".$id_organisation);
            $this->db->where("name_service like '%" . $searchTerm . "%' ");
            $this->db->where('status_service', 1);
            $fetched_records = $this->db->get($table);
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
              $this->db->where('status_service', 1);
            //$this->db->where('id_organisation', $id_organisation);
            $this->db->limit(10);
            $fetched_records = $this->db->get($table);
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['idservice'], "text" => $user['name_service']);
        }
        return $data;
    }

	function getServicesCoverageByJson($searchTerm, $id_organisation,$id_serviceUser) {
		$extra_clause ="";
		if (!empty($searchTerm)) {
			$extra_clause = " where (setting_service.name_service like '%".$searchTerm."%' ";
			$extra_clause .= " or setting_service_specialite.name_specialite like '%".$searchTerm."%') ";
		}
                          $sql = "";
        if($id_serviceUser) {
            $sql .=  "and setting_service.idservice = ".$id_serviceUser." ";
        }
	   $query = $this->db->query("select setting_service.idservice,"
                   . " setting_service_specialite_organisation.id,"
                   . " setting_service_specialite_organisation.id_service,"
                   . " setting_service_specialite_organisation.id_specialite,"
                   . " setting_service.name_service,"
                   . " setting_service_specialite.name_specialite"
                   . " from setting_service_specialite_organisation "
                   . "join setting_service on setting_service.idservice = setting_service_specialite_organisation.id_service"
                   . " and setting_service_specialite_organisation.statut = 1 and setting_service.status_service = 1 and"
                   . " setting_service_specialite_organisation.id_organisation = ".$id_organisation." "
                   . "left join setting_service_specialite on setting_service_specialite.id_service = setting_service.idservice "
                   . "and setting_service_specialite_organisation.id_specialite = setting_service_specialite.idspe "
                   . "".$extra_clause."  " .$sql." order by setting_service.name_service asc");
  
		// Initialize Array with fetched data
		$data0 = $query->result_array();
        $data = array();
        $data[] = array("id" => 'vide', "text" => lang('all'));
        foreach ($data0 as $row) {
            // $data[] = array("id" => $row['idservice'], "text" => $row['name_service']." > ".$row['name_specialite']);
            if($row['name_specialite']){
            $data[] = array("id" => $row['id'], "text" => $row['name_service']." > ".$row['name_specialite']);
            }
        }
        return $data;
    }

    function getServicesCoverageByConsultationJson($searchTerm, $id_organisation,$id_serviceUser) {
		$extra_clause ="";
		if (!empty($searchTerm)) {
			$extra_clause = " where (setting_service.name_service like '%".$searchTerm."%'";
			$extra_clause .= " or setting_service_specialite.name_specialite like '%".$searchTerm."%') ";
		}
                          $sql = "";
        if($id_serviceUser) {
            $sql .=  "and setting_service.idservice = ".$id_serviceUser." ";
        }
	   $query = $this->db->query("select setting_service.idservice,"
                   . " setting_service_specialite.idspe as id,"
                   . " setting_service_specialite.id_service,"
                   . " setting_service.name_service,"
                   . " setting_service_specialite.name_specialite"
                   . " from setting_service "
                   . "left join setting_service_specialite on setting_service_specialite.id_service = setting_service.idservice and setting_service.code_service like 'labo' "
                   . "".$extra_clause."  " .$sql." order by setting_service.name_service asc");
  
		// Initialize Array with fetched data
		$data0 = $query->result_array();
        $data = array();
        foreach ($data0 as $row) {
            // $data[] = array("id" => $row['idservice'], "text" => $row['name_service']." > ".$row['name_specialite']);
            if($row['name_specialite']){
            $data[] = array("id" => $row['id'], "text" => $row['name_service']." > ".$row['name_specialite']);
            }
        }
        return $data;
    }


    function getServicesCoverageByConsultationJson2($searchTerm, $id_organisation,$id_serviceUser) {
		$extra_clause ="";
		if (!empty($searchTerm)) {
			$extra_clause = " where (setting_service.name_service like '%".$searchTerm."%'";
			$extra_clause .= " or setting_service_specialite.name_specialite like '%".$searchTerm."%') ";
		}
                          $sql = "";
        if($id_serviceUser) {
            $sql .=  "and setting_service.idservice = ".$id_serviceUser." ";
        }
	   $query = $this->db->query("select setting_service.idservice,"
                   . " setting_service_specialite.idspe as id,"
                   . " setting_service_specialite_organisation.id_service,"
                   . " setting_service_specialite_organisation.id_specialite,"
                   . " setting_service.name_service,"
                   . " setting_service_specialite.name_specialite"
                   . " from setting_service_specialite_organisation "
                   . "join setting_service on setting_service.idservice = setting_service_specialite_organisation.id_service and setting_service.code_service like 'labo' "
                   . " and setting_service_specialite_organisation.statut = 1 and setting_service.status_service = 1 "
                   . "left join setting_service_specialite on setting_service_specialite.id_service = setting_service.idservice "
                   . "and setting_service_specialite_organisation.id_specialite = setting_service_specialite.idspe "
                   . "".$extra_clause."  " .$sql." order by setting_service.name_service asc");
  
		// Initialize Array with fetched data
		$data0 = $query->result_array();
        $data = array();
        foreach ($data0 as $row) {
            // $data[] = array("id" => $row['idservice'], "text" => $row['name_service']." > ".$row['name_specialite']);
            if($row['name_specialite']){
            $data[] = array("id" => $row['id'], "text" => $row['name_service']." > ".$row['name_specialite']);
            }
        }
        return $data;
    }


    function getServicesCoverageByImagerieJson($searchTerm, $id_organisation,$id_serviceUser) {
        $extra_clause ="";
		if (!empty($searchTerm)) {
			$extra_clause = " where (setting_service.name_service like '%".$searchTerm."%'";
			$extra_clause .= " or setting_service_specialite.name_specialite like '%".$searchTerm."%') ";
		}
                          $sql = "";
        if($id_serviceUser) {
            $sql .=  "and setting_service.idservice = ".$id_serviceUser." ";
        }
	   $query = $this->db->query("select setting_service.idservice,"
                   . " setting_service_specialite.idspe as id,"
                   . " setting_service_specialite.id_service,"
                   . " setting_service.name_service,"
                   . " setting_service_specialite.name_specialite"
                   . " from setting_service "
                   . "left join setting_service_specialite on setting_service_specialite.id_service = setting_service.idservice and setting_service.code_service like '' "
                   . "".$extra_clause."  " .$sql." order by setting_service.name_service asc");
  
		// Initialize Array with fetched data
		$data0 = $query->result_array();
        $data = array();
        foreach ($data0 as $row) {
            // $data[] = array("id" => $row['idservice'], "text" => $row['name_service']." > ".$row['name_specialite']);
            if($row['name_specialite']){
            $data[] = array("id" => $row['id'], "text" => $row['name_service']." > ".$row['name_specialite']);
            }
        }
        return $data;
    }
    
    function getServicesRdvByJson($searchTerm, $id_organisation,$id_serviceUser) {
		$extra_clause ="";
		if (!empty($searchTerm)) {
			$extra_clause = " where (setting_service.name_service like '%".$searchTerm."%') ";
		
		}
                 $sql = "";
        if($id_serviceUser) {
            $sql .=  "and setting_service.idservice = ".$id_serviceUser." ";
        }
	   $query = $this->db->query("select * "
                   . "from setting_service  "
                   . "right join  setting_service_specialite_organisation "
                   . "on setting_service.idservice = setting_service_specialite_organisation.id_service "
                   . "and setting_service_specialite_organisation.statut = 1 and setting_service.status_service = 1 "
                   . "and setting_service_specialite_organisation.id_organisation = ".$id_organisation." "
                   . $extra_clause." "
                     . $sql." "
                   . " group by setting_service.idservice order by setting_service.name_service asc");

		$data0 = $query->result_array();
        $data = array();
        $data[] = array("id" => 'vide', "text" => lang('aucun_service'));
        foreach ($data0 as $row) {
            $data[] = array("id" => $row['idservice'], "text" => $row['name_service']);
        }
        return $data;
    }
    
    function getServicesRdv($id_organisation,$id_serviceUser) {
        $sql = "";
        if($id_serviceUser) {
            $sql .=  "and setting_service.idservice = ".$id_serviceUser." ";
        }
	  $query= $this->db->query("select setting_service.idservice,setting_service.name_service "
                   . "from setting_service  "
                   . "right join  setting_service_specialite_organisation "
                   . "on setting_service.idservice = setting_service_specialite_organisation.id_service "
                   . "and setting_service_specialite_organisation.statut = 1 and setting_service.status_service = 1 "
                   . "and setting_service_specialite_organisation.id_organisation = ".$id_organisation." "
                   . $sql
                   . " group by setting_service.idservice order by setting_service.name_service asc");

		
        return $query->result();

    }

	function getTablePrestationsOrganisationEncoreDispo($id_organisation) {
		// $query = $this->db->query("select payment_category.id, payment_category.prestation, setting_service.name_service, setting_service.idservice, setting_service.code_service, setting_service_specialite.name_specialite,(CASE WHEN payment_category_panier.statut IS NULL THEN '0' ELSE payment_category_panier.statut END) as est_dans_panier from payment_category left join payment_category_organisation on payment_category_organisation.id_presta = payment_category.id and payment_category_organisation.id_organisation = ".$id_organisation." join setting_service_specialite_organisation on setting_service_specialite_organisation.id_service = payment_category.id_service and setting_service_specialite_organisation.id_organisation = ".$id_organisation." join setting_service on setting_service.idservice = setting_service_specialite_organisation.id_service and setting_service.status_service = 1 join setting_service_specialite on setting_service_specialite.idspe = payment_category.id_spe left join payment_category_panier on payment_category_panier.id_prestation = payment_category.id and payment_category_panier.id_organisation = ".$id_organisation." where payment_category_organisation.idpco IS NULL group by payment_category.id order by payment_category.id desc");
		$query = $this->db->query("select payment_category.id, payment_category.prestation,payment_category.keywords, 
       setting_service.name_service, setting_service.idservice, setting_service.code_service, 
       setting_service_specialite.name_specialite,
       (CASE WHEN payment_category_panier.statut IS NULL THEN '0' ELSE payment_category_panier.statut END) 
           as est_dans_panier from setting_service_specialite_organisation join payment_category on 
               setting_service_specialite_organisation.id_service = payment_category.id_service and 
               setting_service_specialite_organisation.id_organisation = ".$id_organisation." and 
               payment_category.id_spe = setting_service_specialite_organisation.id_specialite left join 
               payment_category_organisation on payment_category_organisation.id_presta = payment_category.id and 
               payment_category_organisation.id_organisation = ".$id_organisation." join 
               setting_service on setting_service.idservice = setting_service_specialite_organisation.id_service and 
               setting_service.status_service = 1 join 
               setting_service_specialite on setting_service_specialite.idspe = payment_category.id_spe left join 
               payment_category_panier on payment_category_panier.id_prestation = payment_category.id and 
               payment_category_panier.id_organisation = ".$id_organisation." where 
               payment_category_organisation.idpco IS NULL group by 
               payment_category.id order by 
               payment_category.id desc;");
		return $query->result();
	}

	function getTablePrestationsOrganisationEncoreDispoBySearch($search, $id_organisation) {
		// $query = $this->db->query("select payment_category.id, payment_category.prestation, setting_service.name_service, setting_service.idservice, setting_service.code_service, setting_service_specialite.name_specialite,(CASE WHEN payment_category_panier.statut IS NULL THEN '0' ELSE payment_category_panier.statut END) as est_dans_panier from payment_category left join payment_category_organisation on payment_category_organisation.id_presta = payment_category.id and payment_category_organisation.id_organisation = ".$id_organisation." join setting_service_specialite_organisation on setting_service_specialite_organisation.id_service = payment_category.id_service and setting_service_specialite_organisation.id_organisation = ".$id_organisation." join setting_service on setting_service.idservice = setting_service_specialite_organisation.id_service and setting_service.status_service = 1 join setting_service_specialite on setting_service_specialite.idspe = payment_category.id_spe left join payment_category_panier on payment_category_panier.id_prestation = payment_category.id and payment_category_panier.id_organisation = ".$id_organisation." where payment_category_organisation.idpco IS NULL group by payment_category.id order by payment_category.id desc");
		$query = $this->db->query("select payment_category.id, payment_category.prestation,payment_category.keywords, 
       setting_service.name_service, setting_service.idservice, setting_service.code_service, 
       setting_service_specialite.name_specialite,
       (CASE WHEN payment_category_panier.statut IS NULL THEN '0' ELSE payment_category_panier.statut END) 
           as est_dans_panier from setting_service_specialite_organisation join payment_category on 
               setting_service_specialite_organisation.id_service = payment_category.id_service and 
               setting_service_specialite_organisation.id_organisation = ".$id_organisation." and 
               payment_category.id_spe = setting_service_specialite_organisation.id_specialite left join 
               payment_category_organisation on payment_category_organisation.id_presta = payment_category.id and 
               payment_category_organisation.id_organisation = ".$id_organisation." join 
               setting_service on setting_service.idservice = setting_service_specialite_organisation.id_service and 
               setting_service.status_service = 1 join 
               setting_service_specialite on setting_service_specialite.idspe = payment_category.id_spe left join 
               payment_category_panier on payment_category_panier.id_prestation = payment_category.id and 
               payment_category_panier.id_organisation = ".$id_organisation." where 
               setting_service.name_service like ".$search." OR
               payment_category.prestation like ".$search." OR
               payment_category.keywords like ".$search." OR
               setting_service_specialite.name_specialite like ".$search." where
               payment_category_organisation.idpco IS NULL group by 
               payment_category.id order by 
               payment_category.id desc;");
		return $query->result();
	}

	function getTablePrestationsOrganisationBySearch($search, $id_organisation) {
		$query = $this->db->select('payment_category.id, payment_category.prestation,payment_category.keywords,
       setting_service.name_service, setting_service.idservice, setting_service.code_service,
       setting_service_specialite.name_specialite,payment_category_organisation.idpco,
       payment_category_organisation.id_presta, payment_category_organisation.tarif_public,
       payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance,
       payment_category_organisation.tarif_ipm,payment_category_organisation.prix_public')
		->from('payment_category_organisation')
		->join('payment_category', 'payment_category_organisation.id_presta = payment_category.id AND
       payment_category_organisation.id_organisation = '.$id_organisation)
		->join('setting_service_specialite_organisation', 'payment_category.id_service = setting_service_specialite_organisation.id_service AND
       setting_service_specialite_organisation.id_organisation = '.$id_organisation)
		->join('setting_service', 'setting_service.idservice = setting_service_specialite_organisation.id_service AND
       setting_service.status_service = 1')
		->join('setting_service_specialite', 'setting_service_specialite.idspe = payment_category.id_spe')
		->join('pco_changes_history', 'pco_changes_history.idpco = payment_category_organisation.idpco', 'left')
			->group_start()
			->like('setting_service.name_service', $search)
			->or_like('payment_category.prestation', $search)
			->or_like('payment_category.keywords', $search)
			->or_like('setting_service_specialite.name_specialite', $search)
			->group_end()
			->group_by('payment_category_organisation.id_presta')
			->order_by('pco_changes_history.id', 'desc')
		->get();


//		$query = $this->db->query("select payment_category.id, payment_category.prestation,payment_category.keywords,
//       setting_service.name_service, setting_service.idservice, setting_service.code_service,
//       setting_service_specialite.name_specialite,payment_category_organisation.idpco,
//       payment_category_organisation.id_presta, payment_category_organisation.tarif_public,
//       payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance,
//       payment_category_organisation.tarif_ipm from
//       payment_category_organisation
//           join payment_category on
//       payment_category_organisation.id_presta = payment_category.id and
//       payment_category_organisation.id_organisation = ".$id_organisation."
//       join
//       setting_service_specialite_organisation on payment_category.id_service = setting_service_specialite_organisation.id_service and
//       setting_service_specialite_organisation.id_organisation = ".$id_organisation."
//       join setting_service on
//       setting_service.idservice = setting_service_specialite_organisation.id_service and
//       setting_service.status_service = 1
//       join setting_service_specialite on setting_service_specialite.idspe = payment_category.id_spe
//       left join
//       pco_changes_history on pco_changes_history.idpco = payment_category_organisation.idpco and
//                      setting_service.name_service like ".$search." OR
//               payment_category.prestation like ".$search." OR
//               payment_category.keywords like ".$search." OR
//               setting_service_specialite.name_specialite like ".$search."
//       group by payment_category_organisation.id_presta
//       order by pco_changes_history.id desc");
		return $query->result();
	}

	function getTablePrestationsOrganisationByLimitBySearch($limit, $start, $search, $id_organisation) {
		$query = $this->db->select('payment_category.id, payment_category.prestation,payment_category.keywords,
       setting_service.name_service, setting_service.idservice, setting_service.code_service,
       setting_service_specialite.name_specialite,payment_category_organisation.idpco,
       payment_category_organisation.id_presta, payment_category_organisation.tarif_public,
       payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance,
       payment_category_organisation.tarif_ipm, payment_category_organisation.prix_public')
			->from('payment_category_organisation')
			->join('payment_category', 'payment_category_organisation.id_presta = payment_category.id AND
       payment_category_organisation.id_organisation = '.$id_organisation)
			->join('setting_service_specialite_organisation', 'payment_category.id_service = setting_service_specialite_organisation.id_service AND
       setting_service_specialite_organisation.id_organisation = '.$id_organisation)
			->join('setting_service', 'setting_service.idservice = setting_service_specialite_organisation.id_service AND
       setting_service.status_service = 1')
			->join('setting_service_specialite', 'setting_service_specialite.idspe = payment_category.id_spe')
			->join('pco_changes_history', 'pco_changes_history.idpco = payment_category_organisation.idpco', 'left')
			->group_start()
			->like('setting_service.name_service', $search)
			->or_like('payment_category.prestation', $search)
			->or_like('payment_category.keywords', $search)
			->or_like('setting_service_specialite.name_specialite', $search)
			->group_end()
			->group_by('payment_category_organisation.id_presta')
			->order_by('pco_changes_history.id', 'desc')
			->limit($limit, $start)
			->get();


//		$query = $this->db->query("select payment_category.id, payment_category.prestation,payment_category.keywords,
//       setting_service.name_service, setting_service.idservice, setting_service.code_service,
//       setting_service_specialite.name_specialite,payment_category_organisation.idpco,
//       payment_category_organisation.id_presta, payment_category_organisation.tarif_public,
//       payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance,
//       payment_category_organisation.tarif_ipm from
//       payment_category_organisation
//           join payment_category on
//       payment_category_organisation.id_presta = payment_category.id and
//       payment_category_organisation.id_organisation = ".$id_organisation."
//       join
//       setting_service_specialite_organisation on payment_category.id_service = setting_service_specialite_organisation.id_service and
//       setting_service_specialite_organisation.id_organisation = ".$id_organisation."
//       join setting_service on
//       setting_service.idservice = setting_service_specialite_organisation.id_service and
//       setting_service.status_service = 1
//       join setting_service_specialite on setting_service_specialite.idspe = payment_category.id_spe
//       left join
//       pco_changes_history on pco_changes_history.idpco = payment_category_organisation.idpco and
//                      setting_service.name_service like ".$search." OR
//               payment_category.prestation like ".$search." OR
//               payment_category.keywords like ".$search." OR
//               setting_service_specialite.name_specialite like ".$search."
//       group by payment_category_organisation.id_presta
//       order by pco_changes_history.id desc");
		return $query->result();
	}

	function getTablePrestationsOrganisationByLimit($limit, $start, $id_organisation) {
		$query = $this->db->select('payment_category.id, payment_category.prestation,payment_category.keywords,
       setting_service.name_service, setting_service.idservice, setting_service.code_service,
       setting_service_specialite.name_specialite,payment_category_organisation.idpco,
       payment_category_organisation.id_presta, payment_category_organisation.tarif_public,
       payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance,
       payment_category_organisation.tarif_ipm, payment_category_organisation.prix_public')
			->from('payment_category_organisation')
			->join('payment_category', 'payment_category_organisation.id_presta = payment_category.id AND
       payment_category_organisation.id_organisation = '.$id_organisation)
			->join('setting_service_specialite_organisation', 'payment_category.id_service = setting_service_specialite_organisation.id_service AND
       setting_service_specialite_organisation.id_organisation = '.$id_organisation)
			->join('setting_service', 'setting_service.idservice = setting_service_specialite_organisation.id_service AND
       setting_service.status_service = 1')
			->join('setting_service_specialite', 'setting_service_specialite.idspe = payment_category.id_spe')
			->join('pco_changes_history', 'pco_changes_history.idpco = payment_category_organisation.idpco', 'left')
			->group_by('payment_category_organisation.id_presta')
			->order_by('pco_changes_history.id', 'desc')
			->limit($limit, $start)
			->get();


//		$query = $this->db->query("select payment_category.id, payment_category.prestation,payment_category.keywords,
//       setting_service.name_service, setting_service.idservice, setting_service.code_service,
//       setting_service_specialite.name_specialite,payment_category_organisation.idpco,
//       payment_category_organisation.id_presta, payment_category_organisation.tarif_public,
//       payment_category_organisation.tarif_professionnel, payment_category_organisation.tarif_assurance,
//       payment_category_organisation.tarif_ipm from
//       payment_category_organisation
//           join payment_category on
//       payment_category_organisation.id_presta = payment_category.id and
//       payment_category_organisation.id_organisation = ".$id_organisation."
//       join
//       setting_service_specialite_organisation on payment_category.id_service = setting_service_specialite_organisation.id_service and
//       setting_service_specialite_organisation.id_organisation = ".$id_organisation."
//       join setting_service on
//       setting_service.idservice = setting_service_specialite_organisation.id_service and
//       setting_service.status_service = 1
//       join setting_service_specialite on setting_service_specialite.idspe = payment_category.id_spe
//       left join
//       pco_changes_history on pco_changes_history.idpco = payment_category_organisation.idpco and
//                      setting_service.name_service like ".$search." OR
//               payment_category.prestation like ".$search." OR
//               payment_category.keywords like ".$search." OR
//               setting_service_specialite.name_specialite like ".$search."
//       group by payment_category_organisation.id_presta
//       order by pco_changes_history.id desc");
		return $query->result();
	}

	function getTableServicesRdv($id_organisation,$id_serviceUser) {
		$sql = "";
		if($id_serviceUser) {
			$sql .=  "and setting_service.idservice = ".$id_serviceUser." ";
		}
		$query = $this->db->select('setting_service.idservice,setting_service.name_service')
		->from('setting_service')
		->join('setting_service_specialite_organisation', 'setting_service.idservice = setting_service_specialite_organisation.id_service '
			. 'and setting_service_specialite_organisation.statut = 1 and setting_service.status_service = 1 '
			. 'and setting_service_specialite_organisation.id_organisation = '.$id_organisation.' '.$sql)
		->group_by('setting_service.idservice')
		->order_by('setting_service.name_service', 'asc')
		->get();

//		$query= $this->db->query('select setting_service.idservice,setting_service.name_service "
//			. "from setting_service  "
//			. "right join  setting_service_specialite_organisation "
//			. "on setting_service.idservice = setting_service_specialite_organisation.id_service "
//			. "and setting_service_specialite_organisation.statut = 1 and setting_service.status_service = 1 "
//			. "and setting_service_specialite_organisation.id_organisation = ".$id_organisation." "
//			. $sql
//			. " group by setting_service.idservice order by setting_service.name_service asc");


		return $query->result();

	}

	function getTableServicesRdvBySearch($search, $id_organisation,$id_serviceUser) {
		$sql = "";
		if($id_serviceUser) {
			$sql .=  "and setting_service.idservice = ".$id_serviceUser." ";
		}
		$query = $this->db->select('setting_service.idservice,setting_service.name_service')
			->from('setting_service')
			->join('setting_service_specialite_organisation', 'setting_service.idservice = setting_service_specialite_organisation.id_service '
				. 'and setting_service_specialite_organisation.statut = 1 and setting_service.status_service = 1 '
				. 'and setting_service_specialite_organisation.id_organisation = '.$id_organisation.' '.$sql)
			->group_start()
			->like('setting_service.idservice', $search)
			->or_like('setting_service.name_service', $search)
			->group_end()
			->group_by('setting_service.idservice')
			->order_by('setting_service.name_service', 'asc')
			->get();

		return $query->result();

	}

	function getTableServicesRdvByLimit($limit, $start, $id_organisation,$id_serviceUser) {
		$sql = "";
		if($id_serviceUser) {
			$sql .=  "and setting_service.idservice = ".$id_serviceUser." ";
		}
		$query = $this->db->select('setting_service.idservice,setting_service.name_service')
			->from('setting_service')
			->join('setting_service_specialite_organisation', 'setting_service.idservice = setting_service_specialite_organisation.id_service '
				. 'and setting_service_specialite_organisation.statut = 1 and setting_service.status_service = 1 '
				. 'and setting_service_specialite_organisation.id_organisation = '.$id_organisation.' '.$sql)
			->group_by('setting_service.idservice')
			->order_by('setting_service.name_service', 'asc')
			->limit($limit, $start)
			->get();

		return $query->result();

	}

	function getTableServicesRdvByLimitBySearch($limit, $start, $search, $id_organisation,$id_serviceUser) {
		$sql = "";
		if($id_serviceUser) {
			$sql .=  "and setting_service.idservice = ".$id_serviceUser." ";
		}
		$query = $this->db->select('setting_service.idservice,setting_service.name_service')
			->from('setting_service')
			->join('setting_service_specialite_organisation', 'setting_service.idservice = setting_service_specialite_organisation.id_service '
				. 'and setting_service_specialite_organisation.statut = 1 and setting_service.status_service = 1 '
				. 'and setting_service_specialite_organisation.id_organisation = '.$id_organisation.' '.$sql)
			->group_start()
			->like('setting_service.idservice', $search)
			->or_like('setting_service.name_service', $search)
			->group_end()
			->group_by('setting_service.idservice')
			->order_by('setting_service.name_service', 'asc')
			->limit($limit, $start)
			->get();

		return $query->result();

	}
}

