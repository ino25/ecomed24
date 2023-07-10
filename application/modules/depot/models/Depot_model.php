<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Depot_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertVisite($data) {
        $this->db->insert('depot', $data);
    }

    function insertOperation($data) {
        $this->db->insert('operation_financiere', $data);
    }

    function getOperationOrganisationById($id_organisation) {
        // $this->db->where('payment_category.id', $id);
		$this->db->query("SET time_zone = '+00:00';");
        $query = $this->db->query("select DATE_FORMAT(operation_financiere.date_string,'%y/%m/%d %H:%i') AS dateOp,operation_financiere.date_string AS dateOriginal,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%Y %H:%i:%s') as formeTimes,
        DATE_FORMAT(operation_financiere.date_string, '%d/%m/%y %H:%i') AS dateFormat,operation_financiere.`code` AS recu,operation_financiere.initiateur,
        operation_financiere.type AS type,operation_financiere.description as description,operation_financiere.amount as montant,operation_financiere.destinataire as destinataire,operation_financiere.statut as statut,operation_financiere.statut as statut,operation_financiere.reference as reference FROM operation_financiere
        WHERE operation_financiere.id_organisation = " . $id_organisation . "
        AND DATE_FORMAT(FROM_UNIXTIME(`date`), '%Y-%m')=date_format(now(), '%Y-%m')
        ORDER BY dateFormat DESC");
        return $query->result();
    }

    function getOperationByFilterType($id_organisation, $date_debut, $date_fin, $type) {
        // $this->db->where('payment_category.id', $id);
		$this->db->query("SET time_zone = '+00:00';");
        $query = $this->db->query("select DATE_FORMAT(operation_financiere.date_string,'%y/%m/%d %H:%i') AS dateOp,operation_financiere.date_string AS dateOriginal,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%Y %H:%i:%s') as formeTimes,
        DATE_FORMAT(operation_financiere.date_string, '%d/%m/%y %H:%i') AS dateFormat,operation_financiere.`code` AS recu,operation_financiere.initiateur,
        operation_financiere.type AS type,operation_financiere.description as description,operation_financiere.amount as montant,operation_financiere.destinataire as destinataire,operation_financiere.statut as statut,operation_financiere.reference as reference FROM operation_financiere
        WHERE operation_financiere.id_organisation = " . $id_organisation . "
        AND date >= " . $date_debut . "
        AND date <= " . $date_fin . "
        AND type like '%" . $type . "%'
        ORDER BY dateFormat DESC");
        return $query->result();
    }

    function getOperationOrganisationByFilter($id_organisation, $date_debut, $date_fin) {
        // $this->db->where('payment_category.id', $id);
		$this->db->query("SET time_zone = '+00:00';");
        $query = $this->db->query("select DATE_FORMAT(operation_financiere.date_string,'%y/%m/%d %H:%i') AS dateOp,operation_financiere.date_string AS dateOriginal,DATE_FORMAT(FROM_UNIXTIME(`date`), '%d/%m/%Y %H:%i:%s') as formeTimes,
        DATE_FORMAT(operation_financiere.date_string, '%d/%m/%y %H:%i') AS dateFormat,operation_financiere.`code` AS recu,operation_financiere.initiateur,
        operation_financiere.type AS type,operation_financiere.description as description,operation_financiere.amount as montant,operation_financiere.destinataire as destinataire,operation_financiere.statut as statut,operation_financiere.reference as reference FROM operation_financiere
        WHERE operation_financiere.id_organisation = " . $id_organisation . "
        AND date >= " . $date_debut . "
        AND date <= " . $date_fin . "
        ORDER BY dateFormat DESC");
        return $query->result();
    }
}
