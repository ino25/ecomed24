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
		$query = $this->db->query("select DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y') AS dateString,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex,patient.phone, patient.address, patient.region, patient.passport,SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, '*', 9), '*', -1) as resultat, lab_report.sampling_date,payment.code, purpose.name, lab_report.report_code , lab_report.date_string from lab_report 
INNER JOIN patient ON patient.id = lab_report.patient
INNER JOIN payment ON payment.id = lab_report.payment
LEFT JOIN purpose ON purpose.id = lab_report.sampling 
Where SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, '*', 5), '*', -1) like 'PCR'
AND lab_report.id_organisation = " . $id_organisation . "
AND DATE_FORMAT(FROM_UNIXTIME(`date`), '%Y-%m')=date_format(now(), '%Y-%m')
ORDER BY dateFormat DESC");
		return $query->result();
	}


	function getSanitaireAllSARSCOVID2($id_organisation)
	{
		// $this->db->where('payment_category.id', $id);
		$this->db->query("SET time_zone = '+00:00';");
		$query = $this->db->query("select DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%d/%m/%y') AS dateString,DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%d/%m/%y %H:%i') AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex,patient.phone, patient.address, patient.region, patient.passport,PCR.resultat as resultat, PCR.heure_de_prelevement,payment.code, purpose.name, PCR.date_rendu as sampling_date from PCR 
INNER JOIN payment ON payment.id = PCR.payment
INNER JOIN patient ON patient.id = payment.patient
LEFT JOIN purpose ON purpose.id = payment.purpose
LEFT JOIN lab ON lab.payment = payment.id 
Where payment.id_organisation = " . $id_organisation . "
AND DATE_FORMAT(FROM_UNIXTIME(payment.`date`), '%Y-%m')=date_format(now(), '%Y-%m')
ORDER BY dateFormat DESC");
		return $query->result();
	}


	function getSanitaireFilterType($id_organisation, $date_debut, $date_fin, $type)
	{
		// $this->db->where('payment_category.id', $id);
		$this->db->query("SET time_zone = '+00:00';");
		$query = $this->db->query("select DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y') AS dateString,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex,patient.phone, patient.address, patient.region, patient.passport,SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, '*', 9), '*', -1) as resultat, lab_report.sampling_date, payment.code, purpose.name, lab_report.report_code, lab_report.date_string from lab_report 
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
		$query = $this->db->query("select DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y') AS dateString,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%y %H:%i') AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex,patient.phone, patient.address, patient.region, patient.passport,SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, '*', 9), '*', -1) as resultat, lab_report.sampling_date, payment.code, purpose.name, lab_report.report_code, lab_report.date_string from lab_report 
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

		$query = $this->db->select('DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y") AS dateString,DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y %H:%i") AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex,patient.phone, patient.address, patient.region, patient.passport,SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, "*", 9), "*", -1) as resultat, lab_report.sampling_date, payment.code, purpose.name, lab_report.report_code, lab_report.date_string')
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

		$query = $this->db->select('DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y") AS dateString,DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y %H:%i") AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex,patient.phone, patient.address, patient.region, patient.passport,SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, "*", 9), "*", -1) as resultat, lab_report.sampling_date, payment.code, purpose.name, lab_report.report_code, lab_report.date_string')
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

		$query = $this->db->select('DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y") AS dateString,DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y %H:%i") AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex,patient.phone, patient.address, patient.region, patient.passport,SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, "*", 9), "*", -1) as resultat, lab_report.sampling_date, payment.code, purpose.name, lab_report.report_code, lab_report.date_string')
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

		$query = $this->db->select('DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y") AS dateString,DATE_FORMAT(FROM_UNIXTIME(`date`), "%d/%m/%y %H:%i") AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex,patient.phone, patient.address, patient.region, patient.passport,SUBSTRING_INDEX(SUBSTRING_INDEX(lab_report.details, "*", 9), "*", -1) as resultat, lab_report.sampling_date, payment.code, purpose.name, lab_report.report_code, lab_report.date_string')
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
		die();
	}

	function getTableSanitaireFilterTypeByLimitBySearchSARSCOVID2($limit, $start, $search, $id_organisation, $date_debut, $date_fin, $type)
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
			$sql .= " AND PCR.resultat like '%" . $type . "%'";
		}
		$this->db->query("SET time_zone = '+00:00';");

		$query = $this->db->select('DATE_FORMAT(FROM_UNIXTIME(payment.`date`), "%d/%m/%y") AS dateString,DATE_FORMAT(FROM_UNIXTIME(payment.`date`), "%d/%m/%y %H:%i") AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.phone, patient.address, patient.region, patient.passport,PCR.resultat as resultat, PCR.date_rendu as sampling_date, payment.code, purpose.name as motif, PCR.heure_de_prelevement, lab.numero_identifiant')
			->from('PCR')
			->join('payment', 'payment.id = PCR.payment', 'inner')
			->join('patient', 'patient.id = payment.patient', 'inner')
			->join('purpose', 'purpose.id = payment.purpose', 'left')
			->join('lab', 'lab.payment = payment.id', 'left')
			->where(' payment.id_organisation = ' . $id_organisation . $sql)
			->group_start()
			->like('PCR.resultat', $search)
			->or_like('patient.name', $search)
			->or_like('patient.last_name', $search)
			//->or_like('dateFormat', $search)
			->or_like('patient.sex', $search)
			->group_end()
			->limit($limit, $start)
			->order_by('dateFormat', 'desc')
			->get();
		return $query->result();
		die();
	}

	function getSanitaireFilterDateSARSCOVID2($id_organisation, $date_debut, $date_fin)
	{
		// $this->db->where('payment_category.id', $id);
		$this->db->query("SET time_zone = '+00:00';");
		$query = $this->db->query('select DATE_FORMAT(FROM_UNIXTIME(payment.`date`), "%d/%m/%y") AS dateString,DATE_FORMAT(FROM_UNIXTIME(payment.`date`), "%d/%m/%y %H:%i") AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex,patient.phone, patient.address, patient.region, patient.passport,PCR.resultat as resultat, PCR.heure_de_prelevement,payment.code, purpose.name, PCR.date_rendu as sampling_date from PCR 
		INNER JOIN payment ON payment.id = PCR.payment
		INNER JOIN patient ON patient.id = payment.patient
		LEFT JOIN purpose ON purpose.id = payment.purpose
		LEFT JOIN lab ON lab.payment = payment.id 
		Where payment.id_organisation = ' . $id_organisation . '
		AND payment.date >= ' . $date_debut . '
        AND payment.date <= ' . $date_fin . '
		ORDER BY dateFormat DESC');
		return $query->result();
	}

	function getTableSanitaireFilterTypeBySearchSARSCOVID2($search, $id_organisation, $date_debut, $date_fin, $type)
	{
		$sql = '';
		if (trim($date_debut)) {
			$sql .= " AND payment.date >= " . $date_debut;
		}
		if (trim($date_fin)) {
			$sql .= " AND payment.date <= " . $date_fin;
		}
		if (trim($type)) {
			$sql .= " AND PCR.resultat like '%" . $type . "%'";
		}
		$this->db->query("SET time_zone = '+00:00';");

		$query = $this->db->select('select DATE_FORMAT(FROM_UNIXTIME(payment.`date`), "%d/%m/%y") AS dateString,DATE_FORMAT(FROM_UNIXTIME(payment.`date`), "%d/%m/%y %H:%i") AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.phone, patient.address, patient.region, patient.passport,PCR.resultat as resultat, PCR.date_rendu as sampling_date, payment.code, purpose.name as motif, PCR.heure_de_prelevement, lab.numero_identifiant')
			->from('PCR')
			->join('payment', 'payment.id = PCR.payment', 'inner')
			->join('patient', 'patient.id = payment.patient', 'inner')
			->join('purpose', 'purpose.id = payment.purpose', 'left')
			->join('lab', 'lab.payment = payment.id', 'left')
			->where('payment.id_organisation = ' . $id_organisation . $sql)
			->group_start()
			->like('PCR.date_rendu', $search)
			->or_like('patient.name', $search)
			->or_like('patient.last_name', $search)
			//->or_like('dateFormat', $search)
			->or_like('patient.sex', $search)
			->group_end()
			->order_by('dateFormat', 'desc')
			->get();
		return $query->result();
	}

	function getTableSanitaireFilterTypeSARSCOVID2($id_organisation, $date_debut, $date_fin, $type)
	{
		$sql = '';
		if (trim($date_debut)) {
			$sql .= " AND payment.date >= " . $date_debut;
		}
		if (trim($date_fin)) {
			$sql .= " AND payment.date <= " . $date_fin;
		}
		if (trim($type)) {
			$sql .= " AND PCR.resultat like '%" . $type . "%'";
		}
		$this->db->query("SET time_zone = '+00:00';");

		$query = $this->db->select('DATE_FORMAT(FROM_UNIXTIME(payment.`date`), "%d/%m/%y") AS dateString,DATE_FORMAT(FROM_UNIXTIME(payment.`date`), "%d/%m/%y %H:%i") AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.phone, patient.address, patient.region, patient.passport,PCR.resultat as resultat, PCR.date_rendu as sampling_date, payment.code, purpose.name as motif, PCR.heure_de_prelevement, lab.numero_identifiant')
			->from('PCR')
			->join('payment', 'payment.id = PCR.payment', 'inner')
			->join('patient', 'patient.id = payment.patient', 'inner')
			->join('purpose', 'purpose.id = payment.purpose', 'left')
			->join('lab', 'lab.payment = payment.id', 'left')
			->where('payment.id_organisation = ' . $id_organisation . $sql)
			->order_by('dateFormat', 'desc')
			->get();
		return $query->result();
	}

	function getTableSanitaireFilterTypeByLimitSARSCOVID2($limit, $start, $id_organisation, $date_debut, $date_fin, $type)
	{
		$sql = '';
		if (trim($date_debut)) {
			$sql .= " AND payment.date >= " . $date_debut;
		}
		if (trim($date_fin)) {
			$sql .= " AND payment.date <= " . $date_fin;
		}
		if (trim($type)) {
			$sql .= " AND PCR.resultat like '%" . $type . "%'";
		}
		$this->db->query("SET time_zone = '+00:00';");

		$query = $this->db->select('DATE_FORMAT(FROM_UNIXTIME(payment.`date`), "%d/%m/%y") AS dateString,DATE_FORMAT(FROM_UNIXTIME(payment.`date`), "%d/%m/%y %H:%i") AS dateFormat, patient.name as patientName, patient.last_name as patientLast_Name, patient.age, patient.sex, patient.phone, patient.address, patient.region, patient.passport,PCR.resultat as resultat, PCR.date_rendu as sampling_date, payment.code, purpose.name as motif, PCR.heure_de_prelevement, lab.numero_identifiant')
			->from('PCR')
			->join('payment', 'payment.id = PCR.payment', 'inner')
			->join('patient', 'patient.id = payment.patient', 'inner')
			->join('purpose', 'purpose.id = payment.purpose', 'left')
			->join('lab', 'lab.payment = payment.id', 'left')
			->where('payment.id_organisation = ' . $id_organisation . $sql)
			->limit($limit, $start)
			->order_by('dateFormat', 'desc')
			->get();
		return $query->result();
	}
}
