ALTER TABLE `payment` ADD `libelle_prestation` VARCHAR(500) NULL DEFAULT NULL AFTER `prescripteur`;
ALTER TABLE `payment` ADD `patient_age` VARCHAR(255) NULL DEFAULT NULL AFTER `libelle_prestation`;
ALTER TABLE `payment` ADD `libelle_specialite` VARCHAR(500) NULL DEFAULT NULL AFTER `patient_age`;



ALTER TABLE `doctor` ADD `profession` VARCHAR(255) NOT NULL DEFAULT 'DR' AFTER `ion_user_id`;
ALTER TABLE `adminmedecin` ADD `profession` VARCHAR(255) NOT NULL DEFAULT 'DR' AFTER `ion_user_id`;


CREATE TABLE `biologiste` (
 `id` int(10) NOT NULL AUTO_INCREMENT,
 `img_url` varchar(100) DEFAULT NULL,
 `name` varchar(100) DEFAULT NULL,
 `email` varchar(100) DEFAULT NULL,
 `address` varchar(100) DEFAULT NULL,
 `phone` varchar(100) DEFAULT NULL,
 `department` varchar(100) DEFAULT NULL,
 `profile` varchar(100) DEFAULT NULL,
 `x` varchar(100) DEFAULT NULL,
 `y` varchar(10) DEFAULT NULL,
 `ion_user_id` varchar(100) DEFAULT NULL,
 `profession` varchar(255) NOT NULL DEFAULT 'DR',
 PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8


INSERT INTO `groups` (`id`, `name`, `description`, `label_fr`) VALUES ('13', 'Biologiste', 'Biologiste', 'Biologiste');
