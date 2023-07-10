ALTER TABLE `medical_history` ADD `sucre` VARCHAR(255) NULL DEFAULT NULL AFTER `HypertensionDiastolique`, ADD `albumine` VARCHAR(255) NULL DEFAULT NULL AFTER `sucre`, ADD `oeildroit` VARCHAR(255) NULL DEFAULT NULL AFTER `albumine`, ADD `oeilgauche` VARCHAR(255) NULL DEFAULT NULL AFTER `oeildroit`, ADD `oreilledroite` VARCHAR(255) NULL DEFAULT NULL AFTER `oeilgauche`, ADD `oreillegauche` VARCHAR(255) NULL DEFAULT NULL AFTER `oreilledroite`;


ALTER TABLE `lab` ADD `idPayement` VARCHAR(255) NULL DEFAULT NULL AFTER `numeroRegistre`;

ALTER TABLE `lab` ADD `prescripteur` VARCHAR(255) NULL DEFAULT NULL AFTER `idPayement`;

ALTER TABLE `lab` ADD `nomLabo` VARCHAR(255) NULL DEFAULT NULL AFTER `prescripteur`;

====================================================================================
ALTER TABLE `lab` ADD `url` VARCHAR(500) NULL DEFAULT NULL AFTER `nomLabo`;
ALTER TABLE `lab` ADD `importLabo` VARCHAR(255) NOT NULL DEFAULT '0' AFTER `url`;
ALTER TABLE `lab` CHANGE `importLabo` `importLabo` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0';
==================================================================================
ALTER TABLE `payment` ADD `bulletinAnalyse` VARCHAR(255) NOT NULL AFTER `renseignementClinique`;
UPDATE payment SET bulletinAnalyse = "1" WHERE status_paid LIKE "demander"
================================================================================
DROP TABLE IF EXISTS `current_medications`;
CREATE TABLE IF NOT EXISTS `current_medications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
=================================================================================
DROP TABLE IF EXISTS `pre_conditions`;
CREATE TABLE IF NOT EXISTS `pre_conditions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
==============================================================================


==============================================================================
ALTER TABLE `lab` ADD `type` VARCHAR(255) NULL DEFAULT NULL AFTER `importLabo`;
==============================================================================
CREATE TABLE `vital_sign` ( `id` int(100) NOT NULL AUTO_INCREMENT, `id_organisation` int(11) DEFAULT NULL, `prescripteur` varchar(100) DEFAULT NULL, `frequenceRespiratoire` varchar(100) DEFAULT NULL, `frequenceCardiaque` varchar(100) DEFAULT NULL, `saturationArterielle` varchar(100) DEFAULT NULL, `temperature` varchar(100) DEFAULT NULL, `systolique` varchar(100) DEFAULT NULL, `diastolique` varchar(100) DEFAULT NULL, `tensionArterielle` varchar(100) DEFAULT NULL, `ion_user_id` varchar(100) DEFAULT NULL, `add_date` varchar(100) DEFAULT NULL, `patient` varchar(100) DEFAULT NULL, `patient_name` varchar(100) DEFAULT NULL, `patient_address` varchar(500) DEFAULT NULL, `patient_phone` varchar(100) DEFAULT NULL, `date_string` varchar(100) DEFAULT NULL, `date` varchar(100) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=211 DEFAULT CHARSET=utf8
==================================================================
ALTER TABLE `patient` ADD `estCivil` VARCHAR(255) NULL DEFAULT NULL AFTER `parent_name`;
=================================================================
 CREATE TABLE `visite_consultation` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `patient` varchar(100) DEFAULT NULL,
  `payment` int(11) DEFAULT NULL,
  `add_date` varchar(255) NOT NULL,
  `doctor` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `patient_name` varchar(100) DEFAULT NULL,
  `patient_phone` varchar(100) DEFAULT NULL,
  `patient_address` varchar(100) DEFAULT NULL,
  `date_string` varchar(100) DEFAULT NULL,
  `id_organisation` int(11) DEFAULT NULL,
  `prescripteur` varchar(255) DEFAULT NULL,
  `nomLabo` varchar(255) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=304 DEFAULT CHARSET=utf8

========================================================================
CREATE TABLE `vaccination` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `patient` varchar(100) DEFAULT NULL,
  `lot` varchar(100) DEFAULT NULL,
  `add_date` varchar(255) NOT NULL,
  `doctor` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `nature` varchar(250) DEFAULT NULL,
  `patient_name` varchar(100) DEFAULT NULL,
  `patient_phone` varchar(100) DEFAULT NULL,
  `patient_address` varchar(100) DEFAULT NULL,
  `date_string` varchar(100) DEFAULT NULL,
  `id_organisation` int(11) DEFAULT NULL,
  `prescripteur` varchar(255) DEFAULT NULL,
  `nomLabo` varchar(255) DEFAULT NULL,
  `dossier` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=304 DEFAULT CHARSET=utf8

==========================================================================

CREATE TABLE `hospitalization` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `patient` varchar(100) DEFAULT NULL,
  `lieu` varchar(500) DEFAULT NULL,
  `add_date` varchar(255) NOT NULL,
  `doctor` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `nature` varchar(250) DEFAULT NULL,
  `patient_name` varchar(100) DEFAULT NULL,
  `patient_phone` varchar(100) DEFAULT NULL,
  `patient_address` varchar(100) DEFAULT NULL,
  `date_string` varchar(100) DEFAULT NULL,
  `id_organisation` int(11) DEFAULT NULL,
  `prescripteur` varchar(255) DEFAULT NULL,
  `url` varchar(1000) DEFAULT NULL,
  `nomLabo` varchar(255) DEFAULT NULL,
  `motif` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=304 DEFAULT CHARSET=utf8
======================================================================================
ALTER TABLE `payment` CHANGE `bulletinAnalyse` `bulletinAnalyse` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

=========================================================================================
ALTER TABLE `organisation` ADD `footer` VARCHAR(500) NULL DEFAULT NULL AFTER `entete`;
==========================================================================================
ALTER TABLE `payment` ADD `patientPassport` VARCHAR(255) NULL DEFAULT NULL AFTER `bulletinAnalyse`, ADD `motifVoyage` VARCHAR(500) NULL DEFAULT NULL AFTER `patientPassport`;
========================================================================================
ALTER TABLE `payment` ADD `date_prelevement` VARCHAR(255) NULL DEFAULT NULL AFTER `motifVoyage`, ADD `heure_prelevement` VARCHAR(255) NULL DEFAULT NULL AFTER `date_prelevement`;
=========================================================================================
CREATE TABLE `type_prelevement` ( `id` int(10) NOT NULL AUTO_INCREMENT, `category` varchar(100) DEFAULT NULL, `description` varchar(100) DEFAULT NULL, `x` varchar(100) DEFAULT NULL, `y` varchar(100) DEFAULT NULL, `code` varchar(100) DEFAULT NULL, `status` int(11) DEFAULT NULL, `id_organisation` int(11) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=utf8
======================================================================================
ALTER TABLE `payment` ADD `type_prelevement` VARCHAR(255) NULL DEFAULT NULL AFTER `heure_prelevement`;
====================================================================================================================================
CREATE TABLE IF NOT EXISTS `doctor_signature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_id` int(11) NOT NULL,
  `sign_name` varchar(200) NOT NULL,
  `pin` varchar(200) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1
===================================================================================================================================================
ALTER TABLE `lab` ADD `type_prelevement` VARCHAR(255) NULL DEFAULT NULL AFTER `type`, ADD `date_prelevement` VARCHAR(255) NULL DEFAULT NULL AFTER `type_prelevement`, ADD `heure_prelevement` VARCHAR(255) NULL DEFAULT NULL AFTER `date_prelevement`;

==================================================================================
INSERT INTO `autoemailtemplate` (`name`, `message`, `type`, `status`) VALUES
('ACTIVATION DE COMPTE ECOMED24', " <table class='email-wrapper' width='100%' cellpadding='0' cellspacing='0'
  style='width: 100%;margin: 0;padding: 0;background-color: #F5F7F9;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
  <tr>
    <td
      style='font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
      <table class='email-content' width='100%' cellpadding='0' cellspacing='0'
        style='width: 100%;margin: 0;padding: 0;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>

        <tr>
          <td class='email-masthead'
            style='padding: 25px 0;text-align: center;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
            <a class='email-masthead_name'
              style='color: #839197;font-size: 16px;font-weight: bold;text-decoration: none;text-shadow: 0 1px 0 white;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>

               Bienvenue chez ecoMed24 !
            </a>
          </td>
        </tr>

        <tr>
          <td class='email-body' width='100%'
            style='width: 100%;margin: 0;padding: 0;border-top: 1px solid #E7EAEC;border-bottom: 1px solid #E7EAEC;background-color: #FFFFFF;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
            <table class='email-body_inner' width='570' cellpadding='0' cellspacing='0'
              style='width: 570px;margin: 0 auto;padding: 0;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>

              <tr>
                <td class='content-cell'
                  style='padding: 35px;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                  <h1
                    style='margin-top: 0;color: #292E31;font-size: 19px;font-weight: bold;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                    Activation de votre compte ecoMed24 </h1>
					<h3
                    style='margin-top: 0;color: #292E31;font-size: 14px;font-weight: bold;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                    Cher {name} </h3>
                  <p
                    style='margin-top: 0;color: #839197;font-size: 16px;line-height: 1.5em;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                    Votre compte est créé par la structure {company}.
					Veuillez activer votre compte.</p>

                  <table class='body-action' width='100%' cellpadding='0' cellspacing='0'
                    style='width: 100%;margin: 30px auto;padding: 0;text-align: center;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                    <tr>
                      <td
                        style='font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                        <div
                          style='font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                            <a href='{reset_url}' class='button button--blue'
                            style='color: #ffffff;display: inline-block;width: 200px;background-color: #0854a5;border-radius: 3px;font-size: 15px;line-height: 45px;text-align: center;text-decoration: none;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'><b
                              style='font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                              Activez votre compte</b></a>
                        </div>
                      </td>
                    </tr>
                  </table>
                  <p
                    style='margin-top: 0;color: #839197;font-size: 16px;line-height: 1.5em;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                    Merci,<br>L'équipe ecoMed24</p>

                  <table class='body-sub'
                    style='margin-top: 25px;padding-top: 25px;border-top: 1px solid #E7EAEC;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                    <tr>
                      <td
                        style='font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                        <p class='sub'
                          style='margin-top: 0;color: #839197;font-size: 12px;line-height: 1.5em;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                          Si le bouton ci-dessus ne fonctionne pas pour vous,
                          veuillez copier et coller le lien suivant dans un navigateur.
                        </p>
                        <p class='sub'
                          style='margin-top: 0;color: #839197;font-size: 12px;line-height: 1.5em;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                          <a href='{reset_url}'
                            style='color: #0854a5;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>ici</a>
                        </p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td
            style='font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
            <table class='email-footer' width='570' cellpadding='0' cellspacing='0'
              style='width: 570px;margin: 0 auto;padding: 0;text-align: center;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
              <tr>
                <td class='content-cell'
                  style='padding: 35px;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                  <p class='sub center'
                    style='margin-top: 0;color: #839197;font-size: 12px;line-height: 1.5em;text-align: center;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;'>
                    zuulu Financial Services SA, 47 Bis, Rue MZ 81, Mermoz-Pyrotechnie, Dakar
                  </p>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>", 'reset_activation', 'Inactive');
====================================================================================================================

LABO TEST 

=========================================================================================
CREATE TABLE IF NOT EXISTS `master_lab_test` ( `id` int(100) NOT NULL AUTO_INCREMENT, `speciality` varchar(1000) DEFAULT NULL, `name` varchar(1000) DEFAULT NULL, `description` varchar(1000) DEFAULT NULL, `status` varchar(1000) DEFAULT NULL, `id_organisation` varchar(1000) DEFAULT NULL, `parameter` varchar(1000) DEFAULT NULL, `insert_organ` varchar(1000) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=109 DEFAULT CHARSET=utf8
=========================================================================================
INSERT INTO `master_lab_test` (`id`, `speciality`, `name`, `description`, `status`, `id_organisation`, `parameter`, `insert_organ`) VALUES
(107, '', 'TEST 1', '', 'active', NULL, 'Param 1', '3'),
(108, 'BIology', 'PCR', 'Covid PCR', 'active', NULL, 'PCR', '253**3')
==========================================================================================
CREATE TABLE IF NOT EXISTS `lab_test` ( `id` int(100) NOT NULL AUTO_INCREMENT, `speciality` varchar(1000) DEFAULT NULL, `name` varchar(1000) DEFAULT NULL, `description` varchar(1000) DEFAULT NULL, `status` varchar(1000) DEFAULT NULL, `id_organisation` varchar(1000) DEFAULT NULL, `parameter` varchar(1000) DEFAULT NULL, `add_price` varchar(1000) DEFAULT NULL, `master_id` varchar(1000) DEFAULT NULL, `code` varchar(100) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8
======================================================================================================
INSERT INTO `lab_test` (`id`, `speciality`, `name`, `description`, `status`, `id_organisation`, `parameter`, `add_price`, `master_id`, `code`) VALUES (3, 'asasaas', 'asassas', 'asasa', 'active', '3', 'asas**asdas', '4000', '95', '010'), (4, 'sdfsdf', 'sdfsdfds', 'dsfdsf', 'active', '3', 'dsfdsf', '700', '93', '200'), (5, 'CSC', 'CSC', 'sadada', 'active', '3', 'asdasd**upoi', '400', '91', '004'), (7, 'Blood Test', 'CBC', 'CBC test', 'inactive', '3', 'CBC Count', '400', '97', '092'), (8, 'Alp', 'AlP', 'ALP', 'active', '3', 'Alp ', '300', '99', '005'), (9, 'Lipid Profile', 'Lipid Profile', 'lipid profile', 'active', '3', 'lpdd', '700', '100', '093'), (11, 'BIology', 'PCR', 'Covid PCR', 'active', '253', 'PCR', '10000', '108', '010'), (12, 'BIology', 'PCR', 'Covid PCR', 'active', '3', 'PCR', '1000', '108', '382'), (13, '', 'TEST 1', '', 'active', '3', 'Param 1', '2450', '107', '494')
=======================================================================================================
CREATE TABLE IF NOT EXISTS `request_lab_test` ( `id` int(100) NOT NULL AUTO_INCREMENT, `speciality` varchar(1000) DEFAULT NULL, `name` varchar(1000) DEFAULT NULL, `description` varchar(1000) DEFAULT NULL, `status` varchar(1000) DEFAULT NULL, `id_organisation` varchar(1000) DEFAULT NULL, `parameter` varchar(1000) DEFAULT NULL, `insert_organ` varchar(1000) DEFAULT NULL, `accept` varchar(1000) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=utf8
===========================================================================================================
INSERT INTO `request_lab_test` (`id`, `speciality`, `name`, `description`, `status`, `id_organisation`, `parameter`, `insert_organ`, `accept`) VALUES (95, 'asasaas', 'asassas', 'asasa', 'active', '3', 'asas**asdas', NULL, 'approved'), (96, 'AlT', 'ALT', 'Alt', 'active', '3', 'alt measure', NULL, 'approved'), (97, 'Lipid Profile', 'Lipid Profile', 'lipid profile', 'active', '3', 'lpdd', NULL, 'approved')
=======================================================================================================
CREATE TABLE IF NOT EXISTS `purpose` ( `id` int(100) NOT NULL AUTO_INCREMENT, `name` varchar(1000) DEFAULT NULL, `description` varchar(1000) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8
================================================================================================================
INSERT INTO `purpose` (`id`, `name`, `description`) VALUES (1, 'Traveling', 'Traveling'), (2, 'Medical', NULL), (3, 'Medical', NULL), (7, 'Personal Sickness', NULL), (13, 'Sick', NULL), (12, 'Education', NULL)
============================================================================================================================
CREATE TABLE IF NOT EXISTS `lab_report` ( `id` int(100) NOT NULL AUTO_INCREMENT, `payment` varchar(1000) DEFAULT NULL, `patient` varchar(1000) DEFAULT NULL, `details` varchar(1000) DEFAULT NULL, `lab_id` varchar(1000) DEFAULT NULL, `conclusion` varchar(1000) DEFAULT NULL, `sampling` varchar(1000) DEFAULT NULL, `sampling_date` varchar(1000) DEFAULT NULL, `id_organisation` varchar(1000) DEFAULT NULL, `qr_code` varchar(1000) DEFAULT NULL, `signature` varchar(1000) DEFAULT NULL, `transfer` varchar(1000) DEFAULT NULL, `user` varchar(1000) DEFAULT NULL, `report_code` varchar(100) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8
=======================================================================================================================================
ALTER TABLE `payment` ADD `purpose` VARCHAR(1000) NULL DEFAULT NULL AFTER `type_prelevement`;
=====================================================================================================
ALTER TABLE `patient` ADD `passport` VARCHAR(1000) NULL DEFAULT NULL AFTER `estCivil`;
=============================================================================================================
 CREATE TABLE IF NOT EXISTS `transfer_prescription` (
    ->   `id` int(100) NOT NULL AUTO_INCREMENT,
    ->   `id_organisation` varchar(50) DEFAULT NULL,
    ->   `date` varchar(100) DEFAULT NULL,
    ->   `date_string` varchar(500) DEFAULT NULL,
    ->   `patient` varchar(100) DEFAULT NULL,
    ->   `doctor` varchar(100) DEFAULT NULL,
    ->   `symptom` varchar(100) DEFAULT NULL,
    ->   `advice` varchar(1000) DEFAULT NULL,
    ->   `state` varchar(100) DEFAULT NULL,
    ->   `dd` varchar(100) DEFAULT NULL,
    ->   `medicine` varchar(1000) DEFAULT NULL,
    ->   `validity` varchar(100) DEFAULT NULL,
    ->   `note` varchar(1000) DEFAULT NULL,
    ->   `patientname` varchar(1000) DEFAULT NULL,
    ->   `patientlastname` varchar(500) DEFAULT NULL,
    ->   `user` varchar(50) DEFAULT NULL,
    ->   `doctorname` varchar(1000) DEFAULT NULL,
    ->   `medicament` varchar(500) DEFAULT NULL,
    ->   `etat` int(11) DEFAULT NULL,
    ->   `organisation_destinataire` int(11) DEFAULT NULL,
    ->   `code_facture` varchar(250) DEFAULT NULL,
    ->   `img_url` varchar(500) DEFAULT NULL,
    ->   `renew_date` varchar(50) DEFAULT NULL,
    ->   `pharmacist` varchar(50) DEFAULT NULL,
    ->   `status` varchar(100) DEFAULT NULL,
    ->   `prescription_id` varchar(1000) DEFAULT NULL,
    ->   `add_date` varchar(1000) DEFAULT NULL,
    ->   PRIMARY KEY (`id`)
    -> ) ENGINE=MyISAM AUTO_INCREMENT=144 DEFAULT CHARSET=utf8;

============================================================================================================

INSERT INTO `transfer_prescription` (`id`, `id_organisation`, `date`, `date_string`, `patient`, `doctor`, `symptom`, `advice`, `state`, `dd`, `medicine`, `validity`, `note`, `patientname`, `patientlastname`, `user`, `doctorname`, `medicament`, `etat`, `organisation_destinataire`, `code_facture`, `img_url`, `renew_date`, `pharmacist`, `status`, `prescription_id`, `add_date`) VALUES
    -> (143, '3', '1639914242', '12/19/2021', '211', '992', NULL, '<p>Avoid Red Meat</p>\r\n', NULL, NULL, '12*** 100 ***1+1+0******After food###15*** 5/20mg ***1+1+1******After food', NULL, NULL, 'Aurnab', 'Das', '992', NULL, NULL, 0, NULL, 'O2530001', NULL, NULL, NULL, 'Expired', '56', '1639981083'),
    -> (142, '3', '1639914242', '12/19/2021', '211', '992', NULL, '<p>Avoid Red Meat</p>\r\n', NULL, NULL, '12*** 100 ***1+1+0******After food###15*** 5/20mg ***1+1+1******After food', NULL, NULL, 'Aurnab', 'Das', '992', NULL, NULL, 0, NULL, 'O2530001', NULL, NULL, NULL, 'Expired', '56', '1639980541'),
    -> (141, '3', '1639914242', '12/19/2021', '211', '992', NULL, '<p>Avoid Red Meat</p>\r\n', NULL, NULL, '12*** 100 ***1+1+0******After food###15*** 5/20mg ***1+1+1******After food', NULL, NULL, 'Aurnab', 'Das', '992', NULL, NULL, 0, NULL, 'O2530001', NULL, NULL, NULL, 'Expired', '56', '1639980326'),
    -> (140, '3', '1639914242', '12/19/2021', '211', '992', NULL, '<p>Avoid Red Meat</p>\r\n', NULL, NULL, '12*** 100 ***1+1+0******After food###15*** 5/20mg ***1+1+1******After food', NULL, NULL, 'Aurnab', 'Das', '992', NULL, NULL, 0, NULL, 'O2530001', NULL, NULL, NULL, 'Expired', '56', '1639980031');

===========================================================================================================

CREATE TABLE IF NOT EXISTS `whatsapp_settings` ( `id` int(100) NOT NULL AUTO_INCREMENT, `instance_id` varchar(1000) DEFAULT NULL, `token` varchar(1000) DEFAULT NULL, `status_changed` varchar(1000) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8

========================================================================================================
INSERT INTO `whatsapp_settings` (`id`, `instance_id`, `token`, `status_changed`) VALUES (1, '392410', '85m978c1utk6zqdz', '1')
========================================================================================================
CREATE TABLE IF NOT EXISTS `sampling` ( `id` int(100) NOT NULL AUTO_INCREMENT, `name` varchar(1000) DEFAULT NULL, `description` varchar(1000) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8
======================================================================================================
INSERT INTO `sampling` (`id`, `name`, `description`) VALUES (1, 'Blood', NULL), (6, 'nose', NULL), (5, 'Saliva', NULL), (7, 'PCR', NULL)
=====================================================================================================
CREATE TABLE IF NOT EXISTS `conclusion` ( `id` int(100) NOT NULL AUTO_INCREMENT, `name` varchar(1000) DEFAULT NULL, `description` varchar(1000) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8
=====================================================================================================
 INSERT INTO `conclusion` (`id`, `name`, `description`) VALUES (1, 'Good Report', NULL), (6, 'Covid not detected ', NULL), (5, 'Covid Detected', NULL), (7, 'Négatif ', NULL)
====================================================================================================
CREATE TABLE IF NOT EXISTS `master_parameter_lab_test` ( `id` int(100) NOT NULL AUTO_INCREMENT, `high` varchar(1000) DEFAULT NULL, `low` varchar(1000) DEFAULT NULL, `reference_type` varchar(1000) DEFAULT NULL, `positive_negative` varchar(1000) DEFAULT NULL, `parameter_name` varchar(1000) DEFAULT NULL, `parameter_description` varchar(1000) DEFAULT NULL, `id_organisation` varchar(1000) DEFAULT NULL, `test_id` varchar(1000) DEFAULT NULL, `unit_of_measure` varchar(1000) DEFAULT NULL, `request_test_id` varchar(1000) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8

==================================================================================================
INSERT INTO `master_parameter_lab_test` (`id`, `high`, `low`, `reference_type`, `positive_negative`, `parameter_name`, `parameter_description`, `id_organisation`, `test_id`, `unit_of_measure`, `request_test_id`) VALUES (51, '10', '30', 'off_switch', 'positive', 'Param 1', '', NULL, '107', 'g/ml', NULL), (52, '', '', 'on', 'negative', 'PCR', 'PCR', NULL, '108', '', NULL), (53, '', '', 'on', 'positive', 'Résultat', 'Résultat du test', NULL, NULL, '', '98'), (54, '', '', 'on', 'positive', 'RECHERCHE D’ARN DU SARS-COV2 (qRT-PCR)', '', NULL, '109', '', '99');
===============================================================================================================
ALTER TABLE `lab_report` ADD `doc_id` VARCHAR(255) NULL DEFAULT NULL AFTER `report_code`;
===============================================================================================================
ALTER TABLE `lab_report` ADD `status` VARCHAR(255) NULL DEFAULT NULL AFTER `doc_id`;
===============================================================================================================
CREATE TABLE IF NOT EXISTS `master_medicine` ( `id` int(50) NOT NULL AUTO_INCREMENT, `name` varchar(200) CHARACTER SET utf8 DEFAULT NULL, `category` varchar(200) CHARACTER SET utf8 DEFAULT NULL, `dosage` varchar(200) CHARACTER SET utf8 DEFAULT NULL, `type` varchar(200) CHARACTER SET utf8 DEFAULT NULL, `generic` varchar(200) CHARACTER SET utf8 DEFAULT NULL, `company` varchar(200) CHARACTER SET utf8 DEFAULT NULL, `description` varchar(500) CHARACTER SET utf8 DEFAULT NULL, `add_date` varchar(100) CHARACTER SET utf8 DEFAULT NULL, `status` varchar(200) CHARACTER SET utf8 DEFAULT NULL, `insert_organ` varchar(1000) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=latin1
=====================================================================================================================================
INSERT INTO `master_medicine` (`id`, `name`, `category`, `dosage`, `type`, `generic`, `company`, `description`, `add_date`, `status`, `insert_organ`) VALUES
(41, 'adasd', 'Antalgiques non opioides /antipyretiques, anti-inflammatoires', '10mg', 'Cold', '', '', 'asdsad', '12/23/21', 'Active', NULL),
(42, 'adasdas', 'Antalgiques non opioides /antipyretiques, anti-inflammatoires', '10mg', 'Cold', '', '', '', '12/23/21', 'Active', NULL),
(43, 'gjghjjhjhj', 'Antalgiques non opioides /antipyretiques, anti-inflammatoires', '10mg', 'Cold', '', '', '', '12/23/21', 'Active', NULL),
(44, 'asdasd', 'Antalgiques non opioides /antipyretiques, anti-inflammatoires', '10mg', 'Cold', '', '', '', NULL, 'Deactive', NULL),
(17, 'Amikacine', 'Anti- bactériens', '1g', 'injectable', ' ', ' ', 'Amiklin', '12/21/21', 'Active', NULL),
(18, 'Amoxicilline', 'Anti- bactériens', '500mg', 'gélule', ' ', ' ', 'Clamoxyl', '12/21/21', 'Active', NULL),
(19, 'Amoxicilline', 'Anti- bactériens', '500mg', 'comprimé', ' ', ' ', 'Clamoxyl', '12/21/21', 'Active', NULL),
(20, 'Amoxicillicine', 'Anti- bactériens', '250mg', 'dispersible', ' ', ' ', 'Clamoxyl', '12/21/21', 'Active', NULL),
(21, 'Amoxicillicine', 'Anti- bactériens', '250mg', 'suspension', ' ', ' ', 'Clamoxyl', '12/21/21', 'Active', NULL),
(22, 'Amoxicilline', 'Anti- bactériens', '250mg', 'buvable', ' ', ' ', 'Clamoxyl', '12/21/21', 'Active', NULL),
(23, 'Amoxicilline+Acide Clavulanique', 'Anti- bactériens', '500mg/62,5mg', 'gélule', ' ', ' ', 'Augmentin', '12/21/21', 'Active', NULL),
(24, 'Ampicilline', 'Anti- bactériens', '1g', 'injectable', ' ', ' ', 'Totapen', '12/21/21', 'Active', NULL),
(25, 'Azithromycine', 'Anti- bactériens', '500mg', 'comprimé', ' ', ' ', 'Zithromax', '12/21/21', 'Active', NULL),
(26, 'Benzathine -benzylpénicilline', 'Anti- bactériens', '2,4mui', 'injectable', ' ', ' ', 'Extenlliline', '12/21/21', 'Active', NULL),
(27, 'Benzathine-benzylpénicilline', 'Anti- bactériens', '1,2mui', 'injectable', ' ', ' ', 'Extencilline', '12/21/21', 'Active', NULL),
(28, 'Benzylpénicilline', 'Anti- bactériens', '1mui', 'injectable', ' ', ' ', 'PéniG', '12/21/21', 'Active', NULL),
(29, 'Céfazoline', 'Anti- bactériens', '1g', 'injectable', ' ', ' ', 'Céfacidal', '12/21/21', 'Active', NULL),
(30, 'Céfixime', 'Anti- bactériens', '200mg', 'comprimé', ' ', ' ', 'Oroken', '12/21/21', 'Active', NULL),
(31, 'Kétamine', 'Hypnotiques /Anesthésiques généraux', '50mg', 'injectable', ' ', ' ', 'Kétalar', '12/21/21', 'Active', NULL),
(32, 'Propofol', 'Hypnotiques /Anesthésiques généraux', '20mg/ml', 'injectable', ' ', ' ', 'Diprivan', '12/21/21', 'Active', NULL),
(33, 'Etomidate', 'Hypnotiques /Anesthésiques généraux', '20mg/10ml', 'injectable', ' ', ' ', 'Hypnomidate', '12/21/21', 'Active', NULL),
(34, 'Diazépam', 'Hypnotiques /Anesthésiques généraux', '10mg/ml', 'injectable', ' ', ' ', 'Valium', '12/21/21', 'Active', NULL),
(35, 'Midazolam', 'Hypnotiques /Anesthésiques généraux', '5mg/ml', 'injectable', ' ', ' ', 'Hypnovel', '12/21/21', 'Active', NULL),
(36, 'Thiopental', 'Hypnotiques /Anesthésiques généraux', '1g', 'injectable', ' ', ' ', 'Pentothal', '12/21/21', 'Active', NULL),
(37, 'Dropéridol', 'Hypnotiques /Anesthésiques généraux', '2,5mg/ml', 'injectable', ' ', ' ', 'Droleptan', '12/21/21', 'Active', NULL)
===============================================================================================================================================================
CREATE TABLE IF NOT EXISTS `medicine_type` ( `id` int(50) NOT NULL AUTO_INCREMENT, `type` varchar(100) CHARACTER SET utf8 DEFAULT NULL, `description` varchar(500) CHARACTER SET utf8 DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1
=============================================================================================================
INSERT INTO `medicine_type` (`id`, `type`, `description`) VALUES (1, 'Cold', 'sdfsfdsf'), (3, 'tablet', NULL), (4, 'injectable', NULL), (5, 'gélule', NULL), (6, 'comprimé', NULL), (7, 'dispersible', NULL), (8, 'suspension', NULL), (9, 'buvable', NULL)
============================================================================================================
CREATE TABLE IF NOT EXISTS `medicine_category` ( `id` int(100) NOT NULL AUTO_INCREMENT, `category` varchar(100) DEFAULT NULL, `description` varchar(100) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8
=============================================================================================================
INSERT INTO `medicine_category` (`id`, `category`, `description`) VALUES (8, 'Antalgiques non opioides /antipyretiques, anti-inflammatoires', 'Antalgiques non opioides /antipyretiques, anti-inflammatoires'), (6, 'Anti- bactériens', NULL), (7, 'Hypnotiques /Anesthésiques généraux', NULL), (10, 'asdasd', 'asdadsa')
======================================================================================================
CREATE TABLE IF NOT EXISTS `request_medicine` ( `id` int(50) NOT NULL AUTO_INCREMENT, `name` varchar(200) CHARACTER SET utf8 DEFAULT NULL, `category` varchar(200) CHARACTER SET utf8 DEFAULT NULL, `dosage` varchar(200) CHARACTER SET utf8 DEFAULT NULL, `type` varchar(200) CHARACTER SET utf8 DEFAULT NULL, `generic` varchar(200) CHARACTER SET utf8 DEFAULT NULL, `company` varchar(200) CHARACTER SET utf8 DEFAULT NULL, `description` varchar(500) CHARACTER SET utf8 DEFAULT NULL, `add_date` varchar(100) CHARACTER SET utf8 DEFAULT NULL, `status` varchar(200) CHARACTER SET utf8 DEFAULT NULL, `pharmacist_id` varchar(200) CHARACTER SET utf8 DEFAULT NULL, `s_price` varchar(200) CHARACTER SET utf8 DEFAULT NULL, `quantity` varchar(200) CHARACTER SET utf8 DEFAULT NULL, `e_date` varchar(200) CHARACTER SET utf8 DEFAULT NULL, `id_organisation` varchar(200) CHARACTER SET utf8 DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1
===============================================================================================================================
 INSERT INTO `request_medicine` (`id`, `name`, `category`, `dosage`, `type`, `generic`, `company`, `description`, `add_date`, `status`, `pharmacist_id`, `s_price`, `quantity`, `e_date`, `id_organisation`) VALUES (12, 'asdasd', 'Antalgiques non opioides /antipyretiques, anti-inflammatoires', '10mg', 'Cold', '', '', '', '12/23/21', 'Approved', '7', '100', '2000', '26-08-2022', '253'), (13, 'sdasdasdasd', 'Antalgiques non opioides /antipyretiques, anti-inflammatoires', '10mg', 'Cold', '', '', '', '12/23/21', 'Pending', '7', '', 'asdsdsa', '28-07-2022', '253')
=================================================================================================================================
Drop table medicine
=================================================================================================================================
CREATE TABLE IF NOT EXISTS `medicine` ( `id` int(100) NOT NULL AUTO_INCREMENT, `name` varchar(100) DEFAULT NULL, `category` varchar(100) DEFAULT NULL, `price` varchar(100) DEFAULT NULL, `type` varchar(100) DEFAULT NULL, `s_price` varchar(100) DEFAULT NULL, `quantity` int(100) DEFAULT NULL, `generic` varchar(100) DEFAULT NULL, `company` varchar(100) DEFAULT NULL, `imported_id` varchar(100) DEFAULT NULL, `e_date` varchar(70) DEFAULT NULL, `add_date` varchar(100) DEFAULT NULL, `pharmacist_id` int(50) DEFAULT NULL, `description` varchar(500) DEFAULT NULL, `id_organisation` varchar(100) DEFAULT NULL, `status` varchar(1000) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8
=================================================================================================
INSERT INTO `medicine` (`id`, `name`, `category`, `price`, `type`, `s_price`, `quantity`, `generic`, `company`, `imported_id`, `e_date`, `add_date`, `pharmacist_id`, `description`, `id_organisation`, `status`) VALUES (19, 'Tedex', 'Antibiotic', NULL, 'Cold', '6', 48, 'sfdfdfdf', 'dfdfdf', '12', '30-11-2021', '11/30/21', 6, 'dfdfdf', '3', 'active'), (26, 'Bizoran', 'Pressure', NULL, 'tablet', '10', 3000, 'Amlodipine Besilate', ' ', '15', '30-06-2022', '12/15/21', 4, 'Hypertension', '3', 'active'), (27, 'Codex', 'scanner', NULL, 'Cold', '5', 10, 'khjhkjhkj', 'hkjhkjh', NULL, '30-11-2021', NULL, 4, 'hkjhkjh', '3', NULL), (28, 'asdasd', 'Antalgiques non opioides /antipyretiques, anti-inflammatoires', NULL, 'Cold', '100', 2000, '', '', NULL, '26-08-2022', NULL, 7, '', '253', NULL)
======================================================================================================
CREATE TABLE IF NOT EXISTS `autowhatsapptemplate` ( `id` int(100) NOT NULL AUTO_INCREMENT, `name` varchar(1000) DEFAULT NULL, `message` varchar(10000) DEFAULT NULL, `type` varchar(1000) DEFAULT NULL, `status` varchar(100) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8
===========================================================================================================================
INSERT INTO `autowhatsapptemplate` (`id`, `name`, `message`, `type`, `status`) VALUES
(3, 'PRESTATIONS DE SANTÉ | PAIEMENT | {name} | {company}', '<p>Cher&nbsp;{name},</p>\r\n\r\n<p>Vous avez effectu&eacute; un paiement de {amount} via {payment_method} au profit de {company}.</p>\r\n\r\n<p>Montant total&nbsp;: {montant_total}</p>\r\n\r\n<p>D&eacute;j&agrave; pay&eacute;&nbsp;: {total_depots}</p>\r\n\r\n<p>Solde &agrave;&nbsp;payer&nbsp;: {restant}</p>\r\n\r\n<p>Merci de votre confiance</p>\r\n\r\n<p>{company} via ecoMed24.</p>\r\n', 'payment', 'Active'),
(4, 'RENDEZ-VOUS | ATTENTE DE CONFIRMATION | {name} | {company}', '<p>Cher&nbsp;{name},</p>\r\n\r\n<p>Votre rendez-vous du {appointmentdate} &agrave; {time_slot} avec {company} est en attente de confirmation. Nous vous informerons d&egrave;s qu&rsquo;il sera confirm&eacute;.</p>\r\n\r\n<p>Pour annuler, merci de nous contacter au {company_number}.</p>\r\n\r\n<p>Merci de votre confiance</p>\r\n\r\n<p>{company} via ecoMed24.</p>\r\n', 'appointment_creation', 'Active'),
(5, 'RENDEZ-VOUS | CONFIRMATION | {name} | {company}', '<p>Cher&nbsp;{name},</p>\r\n\r\n<p>Votre rendez-vous du {appointmentdate} &agrave; {time_slot} avec {company} est <strong>confirm&eacute;</strong>.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Rejoignez-nous sur votre ordinateur ou votre telephone mobile.</p>\r\n\r\n<pre>\r\n&lt;a href=&#39;{link}&#39;&gt;Cliquez ici pour rejoindre la teleconsultation&lt;/a&gt;</pre>\r\n\r\n<p>Pour confirmer ou annuler, merci de nous contacter au {company_number}.</p>\r\n\r\n<p>Merci de votre confiance</p>\r\n\r\n<p>{company} via ecoMed24.</p>\r\n', 'appointment_confirmation', 'Active'),
(7, 'Patient - Consultation vidéo ', 'Dear {patient_name}, You have a Live Video Meeting with {doctor_name} on {start_time}. For more information contact with {hospital_name} .', 'meeting_creation', 'Inactive'),
(6, 'send joining confirmation to Doctor', 'Dear {name}, You are appointed as a doctor&nbsp; in {department}. Thank You {company}', 'doctor', 'Inactive'),
(1, 'DOSSIER PATIENT | OUVERTURE | {name} | {company}', '<p>Cher&nbsp;{name},</p>\r\n\r\n<p>Nous confirmons l&rsquo;ouverture de votre dossier patient aupr&egrave;s de l&rsquo;institution {company}. Votre code patient est {code_patient}.</p>\r\n\r\n<p>Merci de votre confiance</p>\r\n\r\n<p>{company} via ecoMed24.</p>\r\n', 'create_patient', 'Active'),
(2, 'Patient - Modification compte2', 'Dear&nbsp;{name},You are registred to {company} as a patient to {doctor}.L&#39;&eacute;quipeecoMed24', 'modif_patient', 'Inactive'),
(8, 'Patient - nouveau mot de passe', 'Dear&nbsp;{name},', 'password_patient', 'Inactive'),
(9, NULL, NULL, NULL, NULL),
(10, 'RENDEZ-VOUS | RAPPEL | {name} | {company}', '<p><strong>Rappel</strong><strong> | Rendez-vous</strong></p>\r\n\r\n<p>Prestataire: {company}</p>\r\n\r\n<p>Patient : {name}<br />\r\nDate du Rendez-vous&nbsp;:&nbsp;<strong>{appointmentdate}</strong><strong> </strong><strong>{time_slot}.</strong><br />\r\n<br />\r\n<strong>Vous </strong><strong>serez contact&eacute; par e-mail</strong><strong>, SMS et/ou un appel t&eacute;l&eacute;phonique avant votre rendez-vous.</strong></p>\r\n\r\n<p>Pour confirmer ou annuler, nous contacter&nbsp;au {numero_telephone}.</p>\r\n\r\n<p>Merci de votre confiance</p>\r\n\r\n<p>{company} via ecoMed24.</p>\r\n', 'appointment_reminder', 'Active'),
(11, 'PRESTATIONS DE SANTÉ | CREATION | {name} | {company}', '<p>Cher&nbsp;{name},</p>\r\n\r\n<p>Vous pouvez procéder dès maintenant au paiement de {restant} au profit de {company} via zuuluPay (Facture: {codeFacture}).</p>\r\n\r\n<p>Montant total&nbsp;: {montant_total}</p>\r\n\r\n<p>D&eacute;j&agrave; pay&eacute;&nbsp;: {total_depots}</p>\r\n\r\n<p>Solde &agrave;&nbsp;payer&nbsp;: {restant}</p>\r\n\r\n<p>Merci de votre confiance</p>\r\n\r\n<p>{company} via ecoMed24.</p>\r\n', 'emptyPayment', 'Active'),
(12, 'ACTIVATION DE COMPTE ECOMED24', '<table class=\'email-wrapper\' width=\'100%\' cellpadding=\'0\' cellspacing=\'0\' style=\'width: 100%;margin: 0;padding: 0;background-color: #F5F7F9;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n  <tr>\n    <td\n      style=\'font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n      <table class=\'email-content\' width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'\n        style=\'width: 100%;margin: 0;padding: 0;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n       \n        <tr>\n          <td class=\'email-masthead\'\n            style=\'padding: 25px 0;text-align: center;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n            <a class=\'email-masthead_name\'\n              style=\'color: #839197;font-size: 16px;font-weight: bold;text-decoration: none;text-shadow: 0 1px 0 white;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                ecoMed24\n            </a>\n          </td>\n        </tr>\n        <tr>\n          <td class=\'email-body\' width=\'100%\'\n            style=\'width: 100%;margin: 0;padding: 0;border-top: 1px solid #E7EAEC;border-bottom: 1px solid #E7EAEC;background-color: #FFFFFF;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n            <table class=\'email-body_inner\' width=\'570\' cellpadding=\'0\' cellspacing=\'0\'\n              style=\'width: 570px;margin: 0 auto;padding: 0;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n              <tr>\n                <td class=\'content-cell\'\n                  style=\'padding: 35px;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                  <h1\n                    style=\'margin-top: 0;color: #292E31;font-size: 19px;font-weight: bold;text-align: left;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    Vérification de votre adresse e-mail</h1>\n                  <p\n                    style=\'margin-top: 0;color: #839197;font-size: 16px;line-height: 1.5em;text-align: left;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    ecoMed24 vous invite à activer votre compte.</p>\n                  <table class=\'body-action\' width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'\n                    style=\'width: 100%;margin: 30px auto;padding: 0;text-align: center;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    <tr>\n                      <td\n                        style=\'font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                        <div\n                          style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                            <a href=\'{activation_url}\' class=\'button button--blue\'\n                            style=\'color: #ffffff;display: inline-block;width: 200px;background-color: #0854a5;border-radius: 3px;font-size: 15px;line-height: 45px;text-align: center;text-decoration: none;-webkit-text-size-adjust: none;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'><b\n                              style=\'font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                              Activez votre compte</b></a>\n                        </div>\n                      </td>\n                    </tr>\n                  </table>\n                  <p\n                    style=\'margin-top: 0;color: #839197;font-size: 16px;line-height: 1.5em;text-align: left;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    Merci,<br>L\'équipe ecoMed24</p>\n                  <table class=\'body-sub\'\n                    style=\'margin-top: 25px;padding-top: 25px;border-top: 1px solid #E7EAEC;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    <tr>\n                      <td\n                        style=\'font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                        <p class=\'sub\'\n                          style=\'margin-top: 0;color: #839197;font-size: 12px;line-height: 1.5em;text-align: left;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                          Si le bouton ci-dessus ne fonctionne pas pour vous,\n                          veuillez copier et coller le lien suivant dans un navigateur.\n                        </p>\n                        <p class=\'sub\'\n                          style=\'margin-top: 0;color: #839197;font-size: 12px;line-height: 1.5em;text-align: left;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                          <a href=\'{activation_url}\'\n                            style=\'color: #0854a5;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>{activation_url}</a>\n                        </p>\n                      </td>\n                    </tr>\n                  </table>\n                </td>\n              </tr>\n            </table>\n          </td>\n        </tr>\n        <tr>\n          <td\n            style=\'font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n            <table class=\'email-footer\' width=\'570\' cellpadding=\'0\' cellspacing=\'0\'\n              style=\'width: 570px;margin: 0 auto;padding: 0;text-align: center;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n              <tr>\n                <td class=\'content-cell\'\n                  style=\'padding: 35px;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                  <p class=\'sub center\'\n                    style=\'margin-top: 0;color: #839197;font-size: 12px;line-height: 1.5em;text-align: center;font-family: Arial,  Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    zuulu Financial Services SA, 47 Bis, Rue MZ 81, Mermoz-Pyrotechnie, Dakar\n                  </p>\n                </td>\n              </tr>\n            </table>\n          </td>\n        </tr>\n      </table>\n    </td>\n  </tr>\n</table>', 'account_activation_by_email', 'Inactive'),
(13, 'MOT DE PASSE OUBLIE ECOMED24', '<table class=\'email-wrapper\' width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'\n  style=\'width: 100%;margin: 0;padding: 0;background-color: #F5F7F9;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n  <tr>\n    <td\n      style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n      <table class=\'email-content\' width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'\n        style=\'width: 100%;margin: 0;padding: 0;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n     \n        <tr>\n          <td class=\'email-masthead\'\n            style=\'padding: 25px 0;text-align: center;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n            <a class=\'email-masthead_name\'\n              style=\'color: #839197;font-size: 16px;font-weight: bold;text-decoration: none;text-shadow: 0 1px 0 white;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n          \n                ecoMed24\n            </a>\n          </td>\n        </tr>\n       \n        <tr>\n          <td class=\'email-body\' width=\'100%\'\n            style=\'width: 100%;margin: 0;padding: 0;border-top: 1px solid #E7EAEC;border-bottom: 1px solid #E7EAEC;background-color: #FFFFFF;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n            <table class=\'email-body_inner\' width=\'570\' cellpadding=\'0\' cellspacing=\'0\'\n              style=\'width: 570px;margin: 0 auto;padding: 0;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n            \n              <tr>\n                <td class=\'content-cell\'\n                  style=\'padding: 35px;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                  <h1\n                    style=\'margin-top: 0;color: #292E31;font-size: 19px;font-weight: bold;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    Mot de passe oublié </h1>\n                  <p\n                    style=\'margin-top: 0;color: #839197;font-size: 16px;line-height: 1.5em;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    ecoMed24 vous invite à reinialiser votre mot de passe.</p>\n                \n                  <table class=\'body-action\' width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'\n                    style=\'width: 100%;margin: 30px auto;padding: 0;text-align: center;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    <tr>\n                      <td\n                        style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                        <div\n                          style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                            <a href=\'{reset_url}\' class=\'button button--blue\'\n                            style=\'color: #ffffff;display: inline-block;width: 200px;background-color: #0854a5;border-radius: 3px;font-size: 15px;line-height: 45px;text-align: center;text-decoration: none;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'><b\n                              style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                              Changer votre mot de passe</b></a>\n                        </div>\n                      </td>\n                    </tr>\n                  </table>\n                  <p\n                    style=\'margin-top: 0;color: #839197;font-size: 16px;line-height: 1.5em;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    Merci,<br>L\'équipe ecoMed24</p>\n                 \n                  <table class=\'body-sub\'\n                    style=\'margin-top: 25px;padding-top: 25px;border-top: 1px solid #E7EAEC;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    <tr>\n                      <td\n                        style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                        <p class=\'sub\'\n                          style=\'margin-top: 0;color: #839197;font-size: 12px;line-height: 1.5em;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                          Si le bouton ci-dessus ne fonctionne pas pour vous,\n                          veuillez copier et coller le lien suivant dans un navigateur.\n                        </p>\n                        <p class=\'sub\'\n                          style=\'margin-top: 0;color: #839197;font-size: 12px;line-height: 1.5em;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                          <a href=\'{reset_url}\'\n                            style=\'color: #0854a5;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>ici</a>\n                        </p>\n                      </td>\n                    </tr>\n                  </table>\n                </td>\n              </tr>\n            </table>\n          </td>\n        </tr>\n        <tr>\n          <td\n            style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n            <table class=\'email-footer\' width=\'570\' cellpadding=\'0\' cellspacing=\'0\'\n              style=\'width: 570px;margin: 0 auto;padding: 0;text-align: center;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n              <tr>\n                <td class=\'content-cell\'\n                  style=\'padding: 35px;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                  <p class=\'sub center\'\n                    style=\'margin-top: 0;color: #839197;font-size: 12px;line-height: 1.5em;text-align: center;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    zuulu Financial Services SA, 47 Bis, Rue MZ 81, Mermoz-Pyrotechnie, Dakar\n                  </p>\n                </td>\n              </tr>\n            </table>\n          </td>\n        </tr>\n      </table>\n    </td>\n  </tr>\n</table>', 'forgot_password_by_email', 'Inactive'),
(14, 'MOT DE PASSE OUBLIE ECOMED24', '<table class=\'email-wrapper\' width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'\n  style=\'width: 100%;margin: 0;padding: 0;background-color: #F5F7F9;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n  <tr>\n    <td\n      style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n      <table class=\'email-content\' width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'\n        style=\'width: 100%;margin: 0;padding: 0;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n     \n        <tr>\n          <td class=\'email-masthead\'\n            style=\'padding: 25px 0;text-align: center;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n            <a class=\'email-masthead_name\'\n              style=\'color: #839197;font-size: 16px;font-weight: bold;text-decoration: none;text-shadow: 0 1px 0 white;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n          \n                ecoMed24\n            </a>\n          </td>\n        </tr>\n       \n        <tr>\n          <td class=\'email-body\' width=\'100%\'\n            style=\'width: 100%;margin: 0;padding: 0;border-top: 1px solid #E7EAEC;border-bottom: 1px solid #E7EAEC;background-color: #FFFFFF;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n            <table class=\'email-body_inner\' width=\'570\' cellpadding=\'0\' cellspacing=\'0\'\n              style=\'width: 570px;margin: 0 auto;padding: 0;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n            \n              <tr>\n                <td class=\'content-cell\'\n                  style=\'padding: 35px;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                  <h1\n                    style=\'margin-top: 0;color: #292E31;font-size: 19px;font-weight: bold;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    Mot de passe oublié </h1>\n                  <p\n                    style=\'margin-top: 0;color: #839197;font-size: 16px;line-height: 1.5em;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    ecoMed24 vous invite à reinialiser votre mot de passe.</p>\n                \n                  <table class=\'body-action\' width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'\n                    style=\'width: 100%;margin: 30px auto;padding: 0;text-align: center;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    <tr>\n                      <td\n                        style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                        <div\n                          style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                            <a href=\'{reset_url}\' class=\'button button--blue\'\n                            style=\'color: #ffffff;display: inline-block;width: 200px;background-color: #0854a5;border-radius: 3px;font-size: 15px;line-height: 45px;text-align: center;text-decoration: none;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'><b\n                              style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                              Changer votre mot de passe</b></a>\n                        </div>\n                      </td>\n                    </tr>\n                  </table>\n                  <p\n                    style=\'margin-top: 0;color: #839197;font-size: 16px;line-height: 1.5em;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    Merci,<br>L\'équipe ecoMed24</p>\n                 \n                  <table class=\'body-sub\'\n                    style=\'margin-top: 25px;padding-top: 25px;border-top: 1px solid #E7EAEC;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    <tr>\n                      <td\n                        style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                        <p class=\'sub\'\n                          style=\'margin-top: 0;color: #839197;font-size: 12px;line-height: 1.5em;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                          Si le bouton ci-dessus ne fonctionne pas pour vous,\n                          veuillez copier et coller le lien suivant dans un navigateur.\n                        </p>\n                        <p class=\'sub\'\n                          style=\'margin-top: 0;color: #839197;font-size: 12px;line-height: 1.5em;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                          <a href=\'{reset_url}\'\n                            style=\'color: #0854a5;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>ici</a>\n                        </p>\n                      </td>\n                    </tr>\n                  </table>\n                </td>\n              </tr>\n            </table>\n          </td>\n        </tr>\n        <tr>\n          <td\n            style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n            <table class=\'email-footer\' width=\'570\' cellpadding=\'0\' cellspacing=\'0\'\n              style=\'width: 570px;margin: 0 auto;padding: 0;text-align: center;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n              <tr>\n                <td class=\'content-cell\'\n                  style=\'padding: 35px;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                  <p class=\'sub center\'\n                    style=\'margin-top: 0;color: #839197;font-size: 12px;line-height: 1.5em;text-align: center;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    zuulu Financial Services SA, 47 Bis, Rue MZ 81, Mermoz-Pyrotechnie, Dakar\n                  </p>\n                </td>\n              </tr>\n            </table>\n          </td>\n        </tr>\n      </table>\n    </td>\n  </tr>\n</table>', 'forgot_password_by_email', 'Inactive'),
(15, 'MOT DE PASSE OUBLIE ECOMED24', '<table class=\'email-wrapper\' width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'\n  style=\'width: 100%;margin: 0;padding: 0;background-color: #F5F7F9;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n  <tr>\n    <td\n      style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n      <table class=\'email-content\' width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'\n        style=\'width: 100%;margin: 0;padding: 0;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n     \n        <tr>\n          <td class=\'email-masthead\'\n            style=\'padding: 25px 0;text-align: center;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n            <a class=\'email-masthead_name\'\n              style=\'color: #839197;font-size: 16px;font-weight: bold;text-decoration: none;text-shadow: 0 1px 0 white;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n          \n                ecoMed24\n            </a>\n          </td>\n        </tr>\n       \n        <tr>\n          <td class=\'email-body\' width=\'100%\'\n            style=\'width: 100%;margin: 0;padding: 0;border-top: 1px solid #E7EAEC;border-bottom: 1px solid #E7EAEC;background-color: #FFFFFF;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n            <table class=\'email-body_inner\' width=\'570\' cellpadding=\'0\' cellspacing=\'0\'\n              style=\'width: 570px;margin: 0 auto;padding: 0;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n            \n              <tr>\n                <td class=\'content-cell\'\n                  style=\'padding: 35px;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                  <h1\n                    style=\'margin-top: 0;color: #292E31;font-size: 19px;font-weight: bold;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    Mot de passe oublié </h1>\n                  <p\n                    style=\'margin-top: 0;color: #839197;font-size: 16px;line-height: 1.5em;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    ecoMed24 vous invite à reinialiser votre mot de passe.</p>\n                \n                  <table class=\'body-action\' width=\'100%\' cellpadding=\'0\' cellspacing=\'0\'\n                    style=\'width: 100%;margin: 30px auto;padding: 0;text-align: center;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    <tr>\n                      <td\n                        style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                        <div\n                          style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                            <a href=\'{reset_url}\' class=\'button button--blue\'\n                            style=\'color: #ffffff;display: inline-block;width: 200px;background-color: #0854a5;border-radius: 3px;font-size: 15px;line-height: 45px;text-align: center;text-decoration: none;-webkit-text-size-adjust: none;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'><b\n                              style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                              Changer votre mot de passe</b></a>\n                        </div>\n                      </td>\n                    </tr>\n                  </table>\n                  <p\n                    style=\'margin-top: 0;color: #839197;font-size: 16px;line-height: 1.5em;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    Merci,<br>L\'équipe ecoMed24</p>\n                 \n                  <table class=\'body-sub\'\n                    style=\'margin-top: 25px;padding-top: 25px;border-top: 1px solid #E7EAEC;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    <tr>\n                      <td\n                        style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                        <p class=\'sub\'\n                          style=\'margin-top: 0;color: #839197;font-size: 12px;line-height: 1.5em;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                          Si le bouton ci-dessus ne fonctionne pas pour vous,\n                          veuillez copier et coller le lien suivant dans un navigateur.\n                        </p>\n                        <p class=\'sub\'\n                          style=\'margin-top: 0;color: #839197;font-size: 12px;line-height: 1.5em;text-align: left;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                          <a href=\'{reset_url}\'\n                            style=\'color: #0854a5;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>ici</a>\n                        </p>\n                      </td>\n                    </tr>\n                  </table>\n                </td>\n              </tr>\n            </table>\n          </td>\n        </tr>\n        <tr>\n          <td\n            style=\'font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n            <table class=\'email-footer\' width=\'570\' cellpadding=\'0\' cellspacing=\'0\'\n              style=\'width: 570px;margin: 0 auto;padding: 0;text-align: center;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n              <tr>\n                <td class=\'content-cell\'\n                  style=\'padding: 35px;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                  <p class=\'sub center\'\n                    style=\'margin-top: 0;color: #839197;font-size: 12px;line-height: 1.5em;text-align: center;font-family: Arial, Helvetica, sans-serif;-webkit-box-sizing: border-box;box-sizing: border-box;\'>\n                    zuulu Financial Services SA, 47 Bis, Rue MZ 81, Mermoz-Pyrotechnie, Dakar\n                  </p>\n                </td>\n              </tr>\n            </table>\n          </td>\n        </tr>\n      </table>\n    </td>\n  </tr>\n</table>', 'forgot_password_by_email', 'Inactive'),
(16, 'RESULTAT DES ANALYSES DU PRESTATAIRE {nom_organisation_prestataire} | COMMANDE: {nro_commande} | PATIENT {patient_full_name} ({patient_id})', '<p>Cher&nbsp;Partenaire,</p>\r\n\r\n<p>Veuillez recevoir en pièce-jointe le résultat des analyses ci-après:</p>\r\n\r\n<p>{liste_prestations_nom_service_nom_prestation_date}</p>\r\n\r\n<p>Merci de votre confiance</p>\r\n\r\n<p>{nom_organisation_prestataire} via ecoMed24.</p>\r\n', 'resultat_analyses_light', 'Active'),
(17, 'FACTURE {nro_facture} DU PRESTATAIRE {nom_organisation_prestataire} | PERIODE: {periode_facture}', '<p>Cher&nbsp;Partenaire,</p>\r\n\r\n<p>Veuillez recevoir en pièce-jointe la facture numéro {nro_facture} pour la periode {periode_facture}.</p>\r\n\r\n<p>Merci de votre confiance</p>\r\n\r\n<p>{nom_organisation_prestataire} via ecoMed24.</p>\r\n', 'facture_light', 'Active'),
(18, 'Lab Report', 'Dear {name},Please Find your Lab report.', 'Whatsapp_lab', 'Active')
===================================================================================================================================================


