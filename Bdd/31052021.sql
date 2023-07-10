ALTER TABLE `medical_history` ADD `specialite` VARCHAR(255) NULL DEFAULT NULL AFTER `patient_last_name`;
ALTER TABLE `medical_history` ADD `poids` VARCHAR(255) NULL DEFAULT NULL AFTER `specialite`;
ALTER TABLE `medical_history` ADD `taille` VARCHAR(255) NULL DEFAULT NULL AFTER `poids`;
ALTER TABLE `medical_history` ADD `temperature` VARCHAR(255) NULL DEFAULT NULL AFTER `taille`;
ALTER TABLE `medical_history` ADD `frequenceRespiratoire` VARCHAR(255) NULL DEFAULT NULL AFTER `temperature`;
ALTER TABLE `medical_history` ADD `frequenceCardiaque` VARCHAR(255) NULL DEFAULT NULL AFTER `frequenceRespiratoire`;
ALTER TABLE `medical_history` ADD `glycemyCapillaire` VARCHAR(255) NULL DEFAULT NULL AFTER `frequenceCardiaque`;
ALTER TABLE `medical_history` ADD `Saturationarterielle` VARCHAR(255) NULL DEFAULT NULL AFTER `glycemyCapillaire`;
ALTER TABLE `medical_history` ADD `SaturationVeineux` VARCHAR(255) NULL DEFAULT NULL AFTER `Saturationarterielle`;
ALTER TABLE `medical_history` ADD `systolique` VARCHAR(255) NULL DEFAULT NULL AFTER `SaturationVeineux`;
ALTER TABLE `medical_history` ADD `diastolique` VARCHAR(255) NULL DEFAULT NULL AFTER `systolique`;
ALTER TABLE `medical_history` ADD `tensionArterielle` VARCHAR(255) NULL DEFAULT NULL AFTER `diastolique`;
ALTER TABLE `medical_history` ADD `namePrestation` VARCHAR(255) NULL DEFAULT NULL AFTER `tensionArterielle`;


DELETE FROM template where id = 51;
INSERT INTO `template` (`id`, `name`, `template`, `user`, `x`, `type`) VALUES
(51, 'Consulltation Général Important !!!', '<table align=\"left\" border=\"2\" cellpadding=\"2\" cellspacing=\"2\" style=\"width:500px\">\r\n	<caption>Motif de la consultation</caption>\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">\r\n			<p>&nbsp;</p>\r\n\r\n			<p>&nbsp;</p>\r\n			</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<table align=\"left\" border=\"2\" cellpadding=\"2\" cellspacing=\"2\" style=\"width:500px\">\r\n	<caption>Ant&eacute;c&eacute;dents pathologiques et terrains</caption>\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">\r\n			<p>&nbsp;</p>\r\n\r\n			<p>&nbsp;</p>\r\n			</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<table align=\"left\" border=\"2\" cellpadding=\"2\" cellspacing=\"2\" style=\"width:500px\">\r\n	<caption>Histoire de la maladie</caption>\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">\r\n			<p>&nbsp;</p>\r\n\r\n			<p>&nbsp;</p>\r\n			</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<table align=\"left\" border=\"2\" cellpadding=\"2\" cellspacing=\"2\" style=\"width:500px\">\r\n	<caption>Examens physiques</caption>\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">\r\n			<p>&nbsp;</p>\r\n\r\n			<p>&nbsp;</p>\r\n			</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<table align=\"left\" border=\"2\" cellpadding=\"2\" cellspacing=\"2\" style=\"width:500px\">\r\n	<caption>Examens paracliniques</caption>\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">\r\n			<p>&nbsp;</p>\r\n\r\n			<p>&nbsp;</p>\r\n			</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<table align=\"left\" border=\"2\" cellpadding=\"2\" cellspacing=\"2\" style=\"width:500px\">\r\n	<caption>Diagnostic</caption>\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">\r\n			<p>&nbsp;</p>\r\n\r\n			<p>&nbsp;</p>\r\n			</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<table align=\"left\" border=\"2\" cellpadding=\"2\" cellspacing=\"2\" style=\"width:500px\">\r\n	<caption>Traitement</caption>\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">\r\n			<p>&nbsp;</p>\r\n\r\n			<p>&nbsp;</p>\r\n			</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<table align=\"left\" border=\"2\" cellpadding=\"2\" cellspacing=\"2\" style=\"width:500px\">\r\n	<caption>Observation</caption>\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">\r\n			<p>&nbsp;</p>\r\n\r\n			<p>&nbsp;</p>\r\n			</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n', '2', NULL, '');


ALTER TABLE `medical_history` ADD `HypertensionSystolique` VARCHAR(255) NULL DEFAULT NULL AFTER `namePrestation`, ADD `HypertensionDiastolique` VARCHAR(255) NULL DEFAULT NULL AFTER `HypertensionSystolique`;

UPDATE `setting_service_specialite` SET `name_specialite` = 'Médecine générale' WHERE `setting_service_specialite`.`name_specialite` = 'Medecine générale';


ALTER TABLE `payment` ADD `renseignementClinique` VARCHAR(255) NULL DEFAULT NULL AFTER `libelle_specialite`;

ALTER TABLE `lab` ADD `consultation` VARCHAR(255) NOT NULL DEFAULT '0' AFTER `code`;


ALTER TABLE `lab` ADD `numeroRegistre` VARCHAR(500) NOT NULL AFTER `consultation`;


ALTER TABLE `organisation` ADD `entete` VARCHAR(500) NOT NULL AFTER `path_logo`;