<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Import_model extends CI_Model
{

    function insertData($data)
    {
        $this->db->insert_batch('student', $data);
    }

    function dataEntry($data, $tablename)
    {
        $this->db->insert($tablename, $data);
    }

    function dataEntryUpdate($id, $data, $table)
    {
        $this->db->where('idpara', $id);
        $this->db->update($table, $data);
    }

    function dataEntryUpdate2($id, $data, $table)
    {
        $this->db->where('id', $id);
        $this->db->update($table, $data);
    }

    function dataEntryUpdate3($data, $id_organisation, $service)
    {

        $this->db->select('*');
        $this->db->where('id_presta', $data);
        $this->db->where('id_organisation', $data);
        $this->db->where('service_pco', $service);
        $this->db->from('payment_category_organisation');
        $query = $this->db->get();
        $queryn =  $query->result();
        // $this->db->delete('payment_category_organisation');
        if (empty($queryn)) {
            $this->db->insert('payment_category_organisation', array('status_pco'  => $data, 'service_pco'  => $service, 'id_organisation'  => $id_organisation));
        }
    }

    function dataEntryUpdate4($service, $id_organisation)
    {
        $this->db->where('service_pco', $service);
        $this->db->where('id_organisation', $id_organisation);

        $this->db->update('payment_category_organisation', array('status_pco'  => NULL));
    }
    function dataEntryUpdate5($data, $service, $id_organisation)
    {
        $this->db->where('service_pco', $service);
        $this->db->where('id_organisation', $id_organisation);
        $this->db->where('id_presta', $data);
        $this->db->update('payment_category_organisation', array('status_pco'  => 1));
    }
    function getTable($data)
    {
        $query = $this->db->list_fields($data);
        return $query;
    }

    /* function headerExist($data, $table) {
        foreach ($data as $data) {
            if ($this->db->field_exists($data, $table)) {

                $booleanValue[] = 'true';
            } else {
                $booleanValue[] = 'false';
            }
        }
        if (array_search('false', $booleanValue)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
*/
    function headerExist($data, $table)
    {
        foreach ($data as $data1) {
            if ($this->db->field_exists($data1, $table) || $this->db->field_exists($data1, 'users')) {

                $booleanValue[] = 'true';
            } else {
                $booleanValue[] = 'false';
            }
        }
        if (array_search('false', $booleanValue)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function headerExistForPanier($data)
    {
        $headerFields = array("Service", "Spécialité", "Prestation", "Tarif Public", "Tarif Professionnel", "Tarif Assurance", "Tarif IPM");
        foreach ($data as $data1) {
            // if ($this->db->field_exists($data, $table)) {
            if (in_array($data1, $headerFields)) {
                $booleanValue[] = 'true';
            } else {
                $booleanValue[] = 'false';
            }
        }
        if (in_array('false', $booleanValue)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    

    function headerExistForOrglight($data)
    {
        $headerFields = array("Partenaire", "Type", "Spécialité", "Adresse", "Contact", "Telephone", "e-Mail");
        foreach ($data as $data1) {
            // if ($this->db->field_exists($data, $table)) {
            if (in_array($data1, $headerFields)) {
                $booleanValue[] = 'true';
            } else {
                $booleanValue[] = 'false';
            }
        }
        if (in_array('false', $booleanValue)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function headerExistForGenericServicesSpecialites($data)
    {
        $headerFields = array("Service", "Spécialité");
        foreach ($data as $data1) {
            // if ($this->db->field_exists($data, $table)) {
            if (in_array($data1, $headerFields)) {
                $booleanValue[] = 'true';
            } else {
                $booleanValue[] = 'false';
            }
        }
        if (in_array('false', $booleanValue)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function headerExistForGenericPatient($data)
    {
        $headerFields = array("Prénom", "Nom", "Téléphone", "Age", "Sexe", "Adresse", "Région");
        foreach ($data as $data1) {
            // if ($this->db->field_exists($data, $table)) {
            if (in_array($data1, $headerFields)) {
                $booleanValue[] = 'true';
            } else {
                $booleanValue[] = 'false';
            }
        }
        if (in_array('false', $booleanValue)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function headerExistForGenericDepense($data)
    {
        $headerFields = array("Date", "Reçu", "Catégorie", "Bénéficiaire", "Téléphone_Bénéficiaire", "Montant", "Libelle");
        foreach ($data as $data1) {
            // if ($this->db->field_exists($data, $table)) {
            if (in_array($data1, $headerFields)) {
                $booleanValue[] = 'true';
            } else {
                $booleanValue[] = 'false';
            }
        }
        if (in_array('false', $booleanValue)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function headerExistForGenericRecette($data)
    {
        $headerFields = array("Date", "Reçu", "Prénom", "Nom", "Age", "Téléphone", "Montant", "Adresse", "Spécialité", "Docteur", "Libelle");
        foreach ($data as $data1) {
            // if ($this->db->field_exists($data, $table)) {
            if (in_array($data1, $headerFields)) {
                $booleanValue[] = 'true';
            } else {
                $booleanValue[] = 'false';
            }
        }
        if (in_array('false', $booleanValue)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function headerExistForGenericPrestationsLabo($data)
    {
        $headerFields = array("Service", "Spécialité", "Prestation", "Machine", "Prelevement", "Methode" , "Cotation", "Coefficient", "Description", "Mots-clés", "Paramètres", "Unité", "Norme", "Alias", "Code", "Unite Secondaire","Type","set_of_code","Min","Max");
        foreach ($data as $data1) {
            // if ($this->db->field_exists($data, $table)) {
            if (in_array($data1, $headerFields)) {
                $booleanValue[] = 'true';
            } else {
                $booleanValue[] = 'false';
            }
        }
        if (in_array('false', $booleanValue)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    function headerExistForPanierTiersPayant($data)
    {
        $headerFields = array("ID", "Service", "Spécialité", "Prestation", "PAF", "Pro-Professionnel", "Pro-Public", "Tarif Assurance", "Tarif IPM");
        foreach ($data as $data1) {
            // if ($this->db->field_exists($data, $table)) {
            if (in_array($data1, $headerFields)) {
                $booleanValue[] = 'true';
            } else {
                $booleanValue[] = 'false';
            }
        }
        if (in_array('false', $booleanValue)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    

    function headerExistForGenericTiersPayant($data)
    {
        $headerFields = array("id", "prestation", "nomenclature_prestation", "code_prestation", "cotation", "coefficient");
        foreach ($data as $data1) {
            // if ($this->db->field_exists($data, $table)) {
            if (in_array($data1, $headerFields)) {
                $booleanValue[] = 'true';
            } else {
                $booleanValue[] = 'false';
            }
        }
        if (in_array('false', $booleanValue)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function headerExistForGenericPrestationsAutres($data)
    {
        $headerFields = array("Service", "Spécialité", "Prestation", "Description", "Mots-clés");
        foreach ($data as $data1) {
            // if ($this->db->field_exists($data, $table)) {
            if (in_array($data1, $headerFields)) {
                $booleanValue[] = 'true';
            } else {
                $booleanValue[] = 'false';
            }
        }
        if (in_array('false', $booleanValue)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function headerMaladie($data)
    {
        $headerFields = array("CODE", "AFFECTION", "GROUPE", "SOUS GROUPE");
        foreach ($data as $data1) {
            // if ($this->db->field_exists($data, $table)) {
            if (in_array($data1, $headerFields)) {
                $booleanValue[] = 'true';
            } else {
                $booleanValue[] = 'false';
            }
        }
        if (in_array('false', $booleanValue)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function dataEntryOrganisation($data, $tablename)
    {
        $this->db->insert($tablename, $data);
    }

    function dataEntryUpdateOrganisation($id, $data, $table)
    {
        $this->db->where('id', $id);
        $this->db->update($table, $data);
    }

    function dataEntryUpdatePatientOrganisation($id, $data, $table)
    {
        $this->db->where('id', $id);
        $this->db->update($table, $data);
    }

    function dataEntryOrganisationLiaison($data, $tablename)
    {
        $this->db->insert($tablename, $data);
    }

    function insert($data)
    {
        $this->db->insert_batch('patient', $data);
    }

    function dataEntryOrganisationLiaisonUpdate($id, $data, $table)
    {
        $this->db->where('idp', $id);
        $this->db->update($table, $data);
    }
}
