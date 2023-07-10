ALTER TABLE `patient`
  DROP `nom_mutuelle`,
  DROP `num_police`,
  DROP `date_valid`,
  DROP `charge_mutuelle`;

ALTER TABLE `payment` ADD `etat` INT NULL AFTER `charge_mutuelle`;
ALTER TABLE `payment` ADD `organisation_destinataire` INT NULL AFTER `etat`;

ALTER TABLE `lab_data` ADD `id_prestation` INT NULL AFTER `prestation`;

ALTER TABLE `sms` ADD `is_corrected` TINYINT(1) NULL DEFAULT NULL AFTER `recipient`;
ALTER TABLE `sms` ADD `corrected_number` VARCHAR(255) NULL AFTER `is_corrected`;

DROP TABLE `lab_data`
CREATE TABLE `lab_data` (
  `id` int(20) NOT NULL,
  `id_lab` int(11) NOT NULL,
  `idPaymentConcatRelevantCategoryPart` varchar(765) NOT NULL,
  `id_para` varchar(255) NOT NULL,
  `id_prestation` int(11) DEFAULT NULL,
  `id_payment` varchar(255) NOT NULL,
  `resultats` varchar(255) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `valeurs` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `lab_data`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `lab_data`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

CREATE TABLE `partenariat_sante_assurance` (
  `id` int(20) NOT NULL,
  `id_organisation_sante` int(11) NOT NULL,
  `id_organisation_assurance` int(11) NOT NULL,
  `partenariat_actif` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `partenariat_sante_assurance`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `partenariat_sante_assurance`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `payment_category` ADD `id_spe` INT NULL AFTER `id_service`;

CREATE TABLE `payment_category_organisation` (
  `idpco` int(11) NOT NULL,
  `id_presta` int(11) NOT NULL,
  `id_organisation` int(11) NOT NULL,
  `status_pco` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `payment_category_organisation`
  ADD PRIMARY KEY (`idpco`);
ALTER TABLE `payment_category_organisation`
  MODIFY `idpco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


CREATE TABLE `payment_category_parametre` (
  `idpara` int(10) NOT NULL,
  `id_prestation` int(11) DEFAULT NULL,
  `id_specialite` int(11) DEFAULT NULL,
  `nom_parametre` varchar(255) DEFAULT NULL,
  `unite` varchar(255) DEFAULT NULL,
  `valeurs` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `payment_category_parametre`
  ADD PRIMARY KEY (`idpara`);
ALTER TABLE `payment_category_parametre`
  MODIFY `idpara` int(10) NOT NULL AUTO_INCREMENT;

CREATE TABLE `setting_service_specialite` (
  `idspe` int(11) UNSIGNED NOT NULL,
  `name_specialite` varchar(100) DEFAULT NULL,
  `id_service` varchar(100) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `setting_service_specialite`
  ADD PRIMARY KEY (`idspe`);

ALTER TABLE `setting_service_specialite`
  MODIFY `idspe` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `setting_service` ADD `code_service` VARCHAR(100) NULL AFTER `status_service`;