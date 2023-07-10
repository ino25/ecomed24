<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Sanitaire_model extends CI_model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}





	function getSanitaireAll($id_organisation)
	{
		// $this->db->where('payment_category.id', $id);
		$this->db->query("SET time_zone = '+00:00';");
		$query = $this->db->query("select DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y') AS dateString,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.age, patient.phone, patient.address, patient.region, patient.passport,SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, '*', 9), '*', -1) as resultat, lab_report.sampling_date,payment.code, purpose.name, lab_report.report_code , lab_report.date_string from lab_report 
INNER JOIN patient ON patient.id = lab_report.patient
INNER JOIN payment ON payment.id = lab_report.payment
LEFT JOIN purpose ON purpose.id = lab_report.sampling 
Where SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, '*', 5), '*', -1) like 'PCR'
AND lab_report.id_organisation = " . $id_organisation . "
AND DATE_FORMAT(FROM_UNIXTIME(`date`), '%Y-%m')=date_format(now(), '%Y-%m')
ORDER BY dateFormat DESC");
		return $query->result();
	}

	function getSanitaireFilterType($id_organisation, $date_debut, $date_fin, $type)
	{
		// $this->db->where('payment_category.id', $id);
		$this->db->query("SET time_zone = '+00:00';");
		$query = $this->db->query("select DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y') AS dateString,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.age, patient.phone, patient.address, patient.region, patient.passport,SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, '*', 9), '*', -1) as resultat, lab_report.sampling_date, payment.code, purpose.name, lab_report.report_code, lab_report.date_string from lab_report 
        INNER JOIN patient ON patient.id = lab_report.patient
        INNER JOIN payment ON payment.id = lab_report.payment
        LEFT JOIN purpose ON purpose.id = lab_report.sampling 
        Where SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, '*', 5), '*', -1) like 'PCR'
        AND lab_report.id_organisation = " . $id_organisation . "
        AND payment.date >= " . $date_debut . "
        AND payment.date <= " . $date_fin . "
        AND SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, '*', 9), '*', -1) like '%" . $type . "%'
        ORDER BY dateFormat DESC");
		return $query->result();
	}

	function getSanitaireFilterDate($id_organisation, $date_debut, $date_fin)
	{
		// $this->db->where('payment_category.id', $id);
		$this->db->query("SET time_zone = '+00:00';");
		$query = $this->db->query("select DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y') AS dateString,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.age, patient.phone, patient.address, patient.region, patient.passport,SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, '*', 9), '*', -1) as resultat, lab_report.sampling_date, payment.code, purpose.name, lab_report.report_code, lab_report.date_string from lab_report 
        INNER JOIN patient ON patient.id = lab_report.patient
        INNER JOIN payment ON payment.id = lab_report.payment
        LEFT JOIN purpose ON purpose.id = lab_report.sampling 
        Where SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, '*', 5), '*', -1) like 'PCR'
        AND lab_report.id_organisation = " . $id_organisation . "
        AND payment.date >= " . $date_debut . "
        AND payment.date <= " . $date_fin . "
        ORDER BY dateFormat DESC");
		return $query->result();
	}

	function getTableSanitaireFilterType($id_organisation, $date_debut, $date_fin, $type)
	{
		$sql = '';
		if (trim($date_debut)) {
			$sql .= " AND payment.date >= " . $date_debut;
		}
		if (trim($date_fin)) {
			$sql .= " AND payment.date <= " . $date_fin;
		}
		if (trim($type)) {
			$sql .= " AND SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, '*', 9), '*', -1) like '%" . $type . "%'";
		}
		$this->db->query("SET time_zone = '+00:00';");

		$query = $this->db->select('DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y") AS dateString,DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y %H:%i") AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.age, patient.phone, patient.address, patient.region, patient.passport,SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, "*", 9), "*", -1) as resultat, lab_report.sampling_date, payment.code, purpose.name, lab_report.report_code, lab_report.date_string')
			->from('lab_report')
			->join('patient', 'patient.id = lab_report.patient', 'inner')
			->join('payment', 'payment.id = lab_report.payment', 'inner')
			->join('purpose', 'purpose.id = lab_report.sampling', 'left')
			->where('SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, "*", 5), "*", -1) like "PCR"
        AND lab_report.id_organisation = ' . $id_organisation . $sql)
			->order_by('dateFormat', 'desc')
			->get();
		return $query->result();
	}

	function getTableSanitaireFilterTypeBySearch($search, $id_organisation, $date_debut, $date_fin, $type)
	{
		$sql = '';
		if (trim($date_debut)) {
			$sql .= " AND payment.date >= " . $date_debut;
		}
		if (trim($date_fin)) {
			$sql .= " AND payment.date <= " . $date_fin;
		}
		if (trim($type)) {
			$sql .= " AND SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, '*', 9), '*', -1) like '%" . $type . "%'";
		}
		$this->db->query("SET time_zone = '+00:00';");

		$query = $this->db->select('DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y") AS dateString,DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y %H:%i") AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.age, patient.phone, patient.address, patient.region, patient.passport,SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, "*", 9), "*", -1) as resultat, lab_report.sampling_date, payment.code, purpose.name, lab_report.report_code, lab_report.date_string')
			->from('lab_report')
			->join('patient', 'patient.id = lab_report.patient', 'inner')
			->join('payment', 'payment.id = lab_report.payment', 'inner')
			->join('purpose', 'purpose.id = lab_report.sampling', 'left')
			->where('SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, "*", 5), "*", -1) like "PCR"
        AND lab_report.id_organisation = ' . $id_organisation . $sql)
			->group_start()
			->like('lab_report.sampling_date', $search)
			->or_like('patient.name', $search)
			->or_like('patient.last_name', $search)
			//->or_like('dateFormat', $search)
			->or_like('patient.sex', $search)
			->group_end()
			->order_by('dateFormat', 'desc')
			->get();
		return $query->result();
	}

	function getTableSanitaireFilterTypeByLimit($limit, $start, $id_organisation, $date_debut, $date_fin, $type)
	{
		$sql = '';
		if (trim($date_debut)) {
			$sql .= " AND payment.date >= " . $date_debut;
		}
		if (trim($date_fin)) {
			$sql .= " AND payment.date <= " . $date_fin;
		}
		if (trim($type)) {
			$sql .= " AND SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, '*', 9), '*', -1) like '%" . $type . "%'";
		}
		$this->db->query("SET time_zone = '+00:00';");

		$query = $this->db->select('DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y") AS dateString,DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y %H:%i") AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.age, patient.phone, patient.address, patient.region, patient.passport,SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, "*", 9), "*", -1) as resultat, lab_report.sampling_date, payment.code, purpose.name, lab_report.report_code, lab_report.date_string')
			->from('lab_report')
			->join('patient', 'patient.id = lab_report.patient', 'inner')
			->join('payment', 'payment.id = lab_report.payment', 'inner')
			->join('purpose', 'purpose.id = lab_report.sampling', 'left')
			->where('SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, "*", 5), "*", -1) like "PCR"
        AND lab_report.id_organisation = ' . $id_organisation . $sql)
			->limit($limit, $start)
			->order_by('dateFormat', 'desc')
			->get();
		return $query->result();
	}

	function getTableSanitaireFilterTypeByLimitBySearch($limit, $start, $search, $id_organisation, $date_debut, $date_fin, $type)
	{
		// $this->db->where('payment_category.id', $id);
		$sql = '';
		if (trim($date_debut)) {
			$sql .= " AND payment.date >= " . $date_debut;
		}
		if (trim($date_fin)) {
			$sql .= " AND payment.date <= " . $date_fin;
		}
		if (trim($type)) {
			$sql .= " AND SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, '*', 9), '*', -1) like '%" . $type . "%'";
		}
		$this->db->query("SET time_zone = '+00:00';");

		$query = $this->db->select('DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y") AS dateString,DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y %H:%i") AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.age, patient.phone, patient.address, patient.region, patient.passport,SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, "*", 9), "*", -1) as resultat, lab_report.sampling_date, payment.code, purpose.name, lab_report.report_code, lab_report.date_string')
			->from('lab_report')
			->join('patient', 'patient.id = lab_report.patient', 'inner')
			->join('payment', 'payment.id = lab_report.payment', 'inner')
			->join('purpose', 'purpose.id = lab_report.sampling', 'left')
			->where('SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, "*", 5), "*", -1) like "PCR"
        AND lab_report.id_organisation = ' . $id_organisation . $sql)
			->group_start()
			->like('lab_report.sampling_date', $search)
			->or_like('patient.name', $search)
			->or_like('patient.last_name', $search)
			//->or_like('dateFormat', $search)
			->or_like('patient.sex', $search)
			->group_end()
			->limit($limit, $start)
			->order_by('dateFormat', 'desc')
			->get();
		return $query->result();
	}

	function getTableSanitaireFilterTypeBySearchSarco($search, $id_organisation, $date_debut, $date_fin, $type)
	{
		$sql = '';
		if (trim($date_debut)) {
			$sql .= " AND payment.date >= " . $date_debut;
		}
		if (trim($date_fin)) {
			$sql .= " AND payment.date <= " . $date_fin;
		}
		if (trim($type)) {
			$sql .= " AND lab_data.resultat <= " . $type;
		}
		$this->db->query("SET time_zone = '+00:00';");

		$query = $this->db->select('patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.address, patient.phone, patient.patient_id as code, payment_category.prestation as name, payment_category_parametre.nom_parametre, lab_data.resultats, payment.date, organisation.nom,
lab_data.id_para, lab.numero_identifiant as report_code, lab.heure_prelevement,lab_data.id_prestation, lab.date_prelevement as sampling_date, payment.date_string')
			->from('lab_data')
			->join('payment', 'payment.id = lab_data.id_payment', 'inner')
			->join('lab', 'lab.id = lab_data.id_lab', 'inner')
			->join('payment_category_parametre', 'payment_category_parametre.idpara = lab_data.id_para', 'inner')
			->join('payment_category', 'payment_category.id = lab_data.id_prestation', 'inner')
			->join('patient', 'patient.id = payment.patient', 'inner')
			->join('patient', 'patient.id = payment.patient', 'inner')
			->join('organisation', 'organisation.id = payment.id_organisation', 'inner')
			->where('lab_data.id_para = 817 and (payment.status like "valid" or payment.status like "Envoyé") AND organisation.id = ' . $id_organisation . $sql)
			->group_start()
			->like('patient.name', $search)
			->or_like('patient.last_name', $search)
			->or_like('patient.sex', $search)
			->group_end()
			->order_by('payment.id', 'desc')
			->get();

		return $query->result();
	}


	function getTableSanitaireFilterTypeSarco($id_organisation, $date_debut, $date_fin, $type)
	{
		$sql = '';
		if (trim($date_debut)) {
			$sql .= " AND payment.date >= " . $date_debut;
		}
		if (trim($date_fin)) {
			$sql .= " AND payment.date <= " . $date_fin;
		}
		if (trim($type)) {
			$sql .= " AND lab_data.resultat <= " . $type;
		}
		$this->db->query("SET time_zone = '+00:00';");

		$query = $this->db->select('patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.address, patient.phone, patient.patient_id as code, payment_category.prestation as name, payment_category_parametre.nom_parametre, lab_data.resultats, payment.date, organisation.nom,
lab_data.id_para, lab.numero_identifiant as report_code, lab.heure_prelevement,lab_data.id_prestation, lab.date_prelevement as sampling_date, payment.date_string')
			->from('lab_data')
			->join('payment', 'payment.id = lab_data.id_payment', 'inner')
			->join('lab', 'lab.id = lab_data.id_lab', 'inner')
			->join('payment_category_parametre', 'payment_category_parametre.idpara = lab_data.id_para', 'inner')
			->join('payment_category', 'payment_category.id = lab_data.id_prestation', 'inner')
			->join('patient', 'patient.id = payment.patient', 'inner')
			->join('patient', 'patient.id = payment.patient', 'inner')
			->join('organisation', 'organisation.id = payment.id_organisation', 'inner')
			->where('lab_data.id_para = 817 and (payment.status like "valid" or payment.status like "Envoyé") AND organisation.id = ' . $id_organisation . $sql)
			->group_start()
			->group_end()
			->order_by('payment.id', 'desc')
			->get();
		return $query->result();
	}


	function getTableSanitaireFilterTypeByLimitBySearchSarco($limit, $start, $search, $id_organisation, $date_debut, $date_fin, $type)
	{
		$sql = '';
		if (trim($date_debut)) {
			$sql .= " AND payment.date >= " . $date_debut;
		}
		if (trim($date_fin)) {
			$sql .= " AND payment.date <= " . $date_fin;
		}
		if (trim($type)) {
			$sql .= " AND lab_data.resultat <= " . $type;
		}
		$this->db->query("SET time_zone = '+00:00';");

		$query = $this->db->select('patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.address, patient.phone, patient.patient_id as code, payment_category.prestation as name, payment_category_parametre.nom_parametre, lab_data.resultats, payment.date, organisation.nom,
lab_data.id_para, lab.numero_identifiant as report_code, lab.heure_prelevement,lab_data.id_prestation, lab.date_prelevement as sampling_date, payment.date_string')
			->from('lab_data')
			->join('payment', 'payment.id = lab_data.id_payment', 'inner')
			->join('lab', 'lab.id = lab_data.id_lab', 'inner')
			->join('payment_category_parametre', 'payment_category_parametre.idpara = lab_data.id_para', 'inner')
			->join('payment_category', 'payment_category.id = lab_data.id_prestation', 'inner')
			->join('patient', 'patient.id = payment.patient', 'inner')
			->join('patient', 'patient.id = payment.patient', 'inner')
			->join('organisation', 'organisation.id = payment.id_organisation', 'inner')
			->where('lab_data.id_para = 817 and (payment.status like "valid" or payment.status like "Envoyé") AND organisation.id = ' . $id_organisation . $sql)
			->group_start()
			->like('patient.name', $search)
			->or_like('patient.last_name', $search)
			->or_like('patient.sex', $search)
			->limit($limit, $start)
			->order_by('payment.id', 'desc')
			->get();
		return $query->result();
	}

	function getTableSanitaireFilterTypeByLimitSarco($limit, $start, $id_organisation, $date_debut, $date_fin, $type)
	{
		$sql = '';
		if (trim($date_debut)) {
			$sql .= " AND payment.date >= " . $date_debut;
		}
		if (trim($date_fin)) {
			$sql .= " AND payment.date <= " . $date_fin;
		}
		if (trim($type)) {
			$sql .= " AND lab_data.resultat <= " . $type;
		}
		$this->db->query("SET time_zone = '+00:00';");

		$query = $this->db->select('patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.address, patient.phone, patient.patient_id as code, payment_category.prestation as name, payment_category_parametre.nom_parametre, lab_data.resultats, payment.date, organisation.nom,
lab_data.id_para, lab.numero_identifiant as report_code, lab.heure_prelevement,lab_data.id_prestation, lab.date_prelevement as sampling_date, payment.date_string')
			->from('lab_data')
			->join('payment', 'payment.id = lab_data.id_payment', 'inner')
			->join('lab', 'lab.id = lab_data.id_lab', 'inner')
			->join('payment_category_parametre', 'payment_category_parametre.idpara = lab_data.id_para', 'inner')
			->join('payment_category', 'payment_category.id = lab_data.id_prestation', 'inner')
			->join('patient', 'patient.id = payment.patient', 'inner')
			->join('patient', 'patient.id = payment.patient', 'inner')
			->join('organisation', 'organisation.id = payment.id_organisation', 'inner')
			->where('lab_data.id_para = 817 and (payment.status like "valid" or payment.status like "Envoyé") AND organisation.id = ' . $id_organisation . $sql)
			->limit($limit, $start)
			->order_by('payment.id', 'desc')
			->get();
		return $query->result();
	}

	function getSanitaireAllSarco($id_organisation)
	{
		// $this->db->where('payment_category.id', $id);
		$this->db->query("SET time_zone = '+00:00';");
		$query = $this->db->query('select patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.address, patient.phone, patient.patient_id as code, payment_category.prestation as name, payment_category_parametre.nom_parametre, lab_data.resultats, payment.date, organisation.nom,
		lab_data.id_para, lab.numero_identifiant as report_code, lab.heure_prelevement,lab_data.id_prestation, lab.date_prelevement as sampling_date, payment.date_string
		FROM `lab_data`
		JOIN payment ON payment.id = lab_data.id_payment
		JOIN lab ON lab.id = lab_data.id_lab
		JOIN payment_category_parametre ON payment_category_parametre.idpara = lab_data.id_para
		JOIN payment_category ON payment_category.id = lab_data.id_prestation
		JOIN patient ON patient.id = payment.patient
		JOIN organisation ON organisation.id = payment.id_organisation
		Where organisation.id = ' . $id_organisation . ' 
		and lab_data.id_para = 817
		and (payment.status like "valid" or payment.status like "Envoyé")
		AND DATE_FORMAT(FROM_UNIXTIME(payment.`date`), "%Y-%m")=date_format(now(), "%Y-%m")
		 order by payment.id desc');
		return $query->result();
	}

	function getIllnessConsultation($id_organisation)
	{
		// $this->db->where('payment_category.id', $id);
		$this->db->query("SET time_zone = '+00:00';");
		$query = $this->db->query('select patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.address, patient.phone, patient.patient_id as code, template.name as name, illness.affection as groupe, illness.groupe_maladie as sous_groupe, illness_consultation.createdDate, patient.number_passage
		FROM `illness_consultation`
		JOIN patient ON patient.id = illness_consultation.patient_id
		JOIN illness ON illness.id = illness_consultation.illness_id
		JOIN medical_history ON medical_history.id = illness_consultation.medical_history_id
		JOIN template ON template.id = medical_history.template_id
		Where medical_history.id_organisation = ' . $id_organisation . ' 
		AND DATE_FORMAT(FROM_UNIXTIME(illness_consultation.`createdDate`), "%Y-%m")=date_format(now(), "%Y-%m")
		UNION ALL		 
		select patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.address, patient.phone, patient.patient_id as code, payment_category.prestation as name, payment_category_parametre.nom_parametre as groupe, lab_data.resultats as sous_groupe,payment.date as createdDate, patient.number_passage from lab_data
		JOIN payment ON payment.id = lab_data.id_payment
		JOIN lab ON lab.id = lab_data.id_lab
		JOIN payment_category_parametre ON payment_category_parametre.idpara = lab_data.id_para
		JOIN payment_category ON payment_category.id = lab_data.id_prestation
		JOIN patient ON patient.id = payment.patient
		JOIN organisation ON organisation.id = payment.id_organisation
		Where organisation.id = ' . $id_organisation . ' 
		and (payment.status like "valid" or payment.status like "Envoyé")
		AND DATE_FORMAT(FROM_UNIXTIME(payment.`date`), "%Y-%m")=date_format(now(), "%Y-%m")
		order by createdDate desc');
		return $query->result();
	}

	
	function getIllnessConsultationDate($id_organisation, $date_debut, $date_fin)
	{
		// $this->db->where('payment_category.id', $id);
		$this->db->query("SET time_zone = '+00:00';");
		$query = $this->db->query('select patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.address, patient.phone, patient.patient_id as code, template.name as name, illness.affection as groupe, illness.groupe_maladie as sous_groupe, illness_consultation.createdDate,patient.number_passage
		FROM `illness_consultation`
		JOIN patient ON patient.id = illness_consultation.patient_id
		JOIN illness ON illness.id = illness_consultation.illness_id
		JOIN medical_history ON medical_history.id = illness_consultation.medical_history_id
		JOIN template ON template.id = medical_history.template_id
		Where medical_history.id_organisation = ' . $id_organisation . ' 
		AND illness_consultation.createdDate >= ' . $date_debut . '
        AND illness_consultation.createdDate <= ' . $date_fin . '
		AND DATE_FORMAT(FROM_UNIXTIME(illness_consultation.`createdDate`), "%Y-%m")=date_format(now(), "%Y-%m")
		UNION ALL		 
		select patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.address, patient.phone, patient.patient_id as code, payment_category.prestation as name, payment_category_parametre.nom_parametre as groupe, lab_data.resultats as sous_groupe,payment.date as createdDate, patient.number_passage from lab_data
		JOIN payment ON payment.id = lab_data.id_payment
		JOIN lab ON lab.id = lab_data.id_lab
		JOIN payment_category_parametre ON payment_category_parametre.idpara = lab_data.id_para
		JOIN payment_category ON payment_category.id = lab_data.id_prestation
		JOIN patient ON patient.id = payment.patient
		JOIN organisation ON organisation.id = payment.id_organisation
		Where organisation.id = ' . $id_organisation . ' 
		AND payment.date >= ' . $date_debut . '
        AND payment.date <= ' . $date_fin . '
		and (payment.status like "valid" or payment.status like "Envoyé")
		AND DATE_FORMAT(FROM_UNIXTIME(payment.`date`), "%Y-%m")=date_format(now(), "%Y-%m")
		order by createdDate desc');
		return $query->result();
	}


	function getIllnessConsultationSexe($id_organisation, $date_debut, $date_fin, $sexe)
	{
		// $this->db->where('payment_category.id', $id);
		$this->db->query("SET time_zone = '+00:00';");
		$query = $this->db->query('select patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.address, patient.phone, patient.patient_id as code, template.name as name, illness.affection as groupe, illness.groupe_maladie as sous_groupe, illness_consultation.createdDate, patient.number_passage
		FROM `illness_consultation`
		JOIN patient ON patient.id = illness_consultation.patient_id
		JOIN illness ON illness.id = illness_consultation.illness_id
		JOIN medical_history ON medical_history.id = illness_consultation.medical_history_id
		JOIN template ON template.id = medical_history.template_id
		Where medical_history.id_organisation = ' . $id_organisation . ' 
		AND illness_consultation.createdDate >= ' . $date_debut . '
        AND illness_consultation.createdDate <= ' . $date_fin . '
		AND patient.sex like "' . $sexe . '"
		AND DATE_FORMAT(FROM_UNIXTIME(illness_consultation.`createdDate`), "%Y-%m")=date_format(now(), "%Y-%m")
		UNION ALL		 
		select patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.address, patient.phone, patient.patient_id as code, payment_category.prestation as name, payment_category_parametre.nom_parametre as groupe, lab_data.resultats as sous_groupe,payment.date as createdDate, patient.number_passage from lab_data
		JOIN payment ON payment.id = lab_data.id_payment
		JOIN lab ON lab.id = lab_data.id_lab
		JOIN payment_category_parametre ON payment_category_parametre.idpara = lab_data.id_para
		JOIN payment_category ON payment_category.id = lab_data.id_prestation
		JOIN patient ON patient.id = payment.patient
		JOIN organisation ON organisation.id = payment.id_organisation
		Where organisation.id = ' . $id_organisation . ' 
		AND payment.date >= ' . $date_debut . '
        AND payment.date <= ' . $date_fin . '
		AND patient.sex like "' . $sexe . '"
		and (payment.status like "valid" or payment.status like "Envoyé")
		AND DATE_FORMAT(FROM_UNIXTIME(payment.`date`), "%Y-%m")=date_format(now(), "%Y-%m")
		order by createdDate desc');
		return $query->result();
	}

	function getIllnessConsultationConclusion($id_organisation, $date_debut, $date_fin, $conclusion)
	{
		// $this->db->where('payment_category.id', $id);
		$this->db->query("SET time_zone = '+00:00';");
		$query = $this->db->query('select patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.address, patient.phone, patient.patient_id as code, template.name as name, illness.affection as groupe, illness.groupe_maladie as sous_groupe, illness_consultation.createdDate, patient.number_passage
		FROM `illness_consultation`
		JOIN patient ON patient.id = illness_consultation.patient_id
		JOIN illness ON illness.id = illness_consultation.illness_id
		JOIN medical_history ON medical_history.id = illness_consultation.medical_history_id
		JOIN template ON template.id = medical_history.template_id
		Where medical_history.id_organisation = ' . $id_organisation . ' 
		AND illness_consultation.createdDate >= ' . $date_debut . '
        AND illness_consultation.createdDate <= ' . $date_fin . '
		AND template.id = "' . $conclusion . '"
		AND DATE_FORMAT(FROM_UNIXTIME(illness_consultation.`createdDate`), "%Y-%m")=date_format(now(), "%Y-%m")
		UNION ALL		 
		select patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.address, patient.phone, patient.patient_id as code, payment_category.prestation as name, payment_category_parametre.nom_parametre as groupe, lab_data.resultats as sous_groupe,payment.date as createdDate, patient.number_passage from lab_data
		JOIN payment ON payment.id = lab_data.id_payment
		JOIN lab ON lab.id = lab_data.id_lab
		JOIN payment_category_parametre ON payment_category_parametre.idpara = lab_data.id_para
		JOIN payment_category ON payment_category.id = lab_data.id_prestation
		JOIN patient ON patient.id = payment.patient
		JOIN organisation ON organisation.id = payment.id_organisation
		Where organisation.id = ' . $id_organisation . ' 
		AND payment.date >= ' . $date_debut . '
        AND payment.date <= ' . $date_fin . '
		AND payment_category.id = "' . $conclusion . '"
		and (payment.status like "valid" or payment.status like "Envoyé")
		AND DATE_FORMAT(FROM_UNIXTIME(payment.`date`), "%Y-%m")=date_format(now(), "%Y-%m")
		order by createdDate desc');
		return $query->result();
	}

	function getIllnessConsultationSexeConclusion($id_organisation, $date_debut, $date_fin, $conclusion, $sexe)
	{
		// $this->db->where('payment_category.id', $id);
		$this->db->query("SET time_zone = '+00:00';");
		$query = $this->db->query('select patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.address, patient.phone, patient.patient_id as code, template.name as name, illness.affection as groupe, illness.groupe_maladie as sous_groupe, illness_consultation.createdDate, patient.number_passage
		FROM `illness_consultation`
		JOIN patient ON patient.id = illness_consultation.patient_id
		JOIN illness ON illness.id = illness_consultation.illness_id
		JOIN medical_history ON medical_history.id = illness_consultation.medical_history_id
		JOIN template ON template.id = medical_history.template_id
		Where medical_history.id_organisation = ' . $id_organisation . ' 
		AND illness_consultation.createdDate >= ' . $date_debut . '
        AND illness_consultation.createdDate <= ' . $date_fin . '
		AND template.id = "' . $conclusion . '"
		AND patient.sex = "' . $sexe . '"
		AND DATE_FORMAT(FROM_UNIXTIME(illness_consultation.`createdDate`), "%Y-%m")=date_format(now(), "%Y-%m")
		UNION ALL		 
		select patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.address, patient.phone, patient.patient_id as code, payment_category.prestation as name, payment_category_parametre.nom_parametre as groupe, lab_data.resultats as sous_groupe,payment.date as createdDate, patient.number_passage from lab_data
		JOIN payment ON payment.id = lab_data.id_payment
		JOIN lab ON lab.id = lab_data.id_lab
		JOIN payment_category_parametre ON payment_category_parametre.idpara = lab_data.id_para
		JOIN payment_category ON payment_category.id = lab_data.id_prestation
		JOIN patient ON patient.id = payment.patient
		JOIN organisation ON organisation.id = payment.id_organisation
		Where organisation.id = ' . $id_organisation . ' 
		AND payment.date >= ' . $date_debut . '
        AND payment.date <= ' . $date_fin . '
		AND payment_category.id = "' . $conclusion . '"
		AND patient.sex = "' . $sexe . '"
		and (payment.status like "valid" or payment.status like "Envoyé")
		AND DATE_FORMAT(FROM_UNIXTIME(payment.`date`), "%Y-%m")=date_format(now(), "%Y-%m")
		order by createdDate desc');
		return $query->result();
	}

	function getIllnessConclusion($id_organisation)
	{
		// $this->db->where('payment_category.id', $id);
		$this->db->query("SET time_zone = '+00:00';");
		$query = $this->db->query('select template.id as id, template.name as affection
		FROM `illness_consultation`
		JOIN patient ON patient.id = illness_consultation.patient_id
		JOIN illness ON illness.id = illness_consultation.illness_id
		JOIN medical_history ON medical_history.id = illness_consultation.medical_history_id
		JOIN template ON template.id = medical_history.template_id
		Where medical_history.id_organisation = ' . $id_organisation . ' 
		group by id
		UNION ALL		 
		select payment_category.id as id, payment_category.prestation as affection from lab_data
		JOIN payment ON payment.id = lab_data.id_payment
		JOIN lab ON lab.id = lab_data.id_lab
		JOIN payment_category_parametre ON payment_category_parametre.idpara = lab_data.id_para
		JOIN payment_category ON payment_category.id = lab_data.id_prestation
		JOIN patient ON patient.id = payment.patient
		JOIN organisation ON organisation.id = payment.id_organisation
		Where organisation.id = ' . $id_organisation . '  
		AND (payment.status like "valid" or payment.status like "Envoyé") AND DATE_FORMAT(FROM_UNIXTIME(payment.`date`), "%Y-%m")=date_format(now(), "%Y-%m")
		group by id');
		return $query->result();
	}

	function getSanitaireFilterDateSarco($id_organisation, $date_debut, $date_fin)
	{
		// $this->db->where('payment_category.id', $id);
		$this->db->query("SET time_zone = '+00:00';");
		$query = $this->db->query('select patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.address, patient.phone, patient.patient_id as code, payment_category.prestation as name, payment_category_parametre.nom_parametre, lab_data.resultats, payment.date, organisation.nom,
		lab_data.id_para, lab.numero_identifiant as report_code, lab.heure_prelevement,lab_data.id_prestation, lab.date_prelevement as sampling_date, payment.date_string
		FROM `lab_data`
		JOIN payment ON payment.id = lab_data.id_payment
		JOIN lab ON lab.id = lab_data.id_lab
		JOIN payment_category_parametre ON payment_category_parametre.idpara = lab_data.id_para
		JOIN payment_category ON payment_category.id = lab_data.id_prestation
		JOIN patient ON patient.id = payment.patient
		JOIN organisation ON organisation.id = payment.id_organisation
		Where organisation.id = ' . $id_organisation . ' and lab_data.id_para = 817
		and (payment.status like "valid" or payment.status like "Envoyé")
		AND payment.date >= ' . $date_debut . '
        AND payment.date <= ' . $date_fin . '
		 order by payment.id desc');
		return $query->result();
	}
}
