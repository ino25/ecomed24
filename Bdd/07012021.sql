/*ALTER TABLE `appointment` ADD `room_id` INT NULL AFTER `servicename`;
ALTER TABLE `appointment` ADD `live_meeting_link` VARCHAR(5000) NULL AFTER `room_id`;
ALTER TABLE `medical_history` CHANGE `payment_id` `payment_id` INT(50) NULL;
ALTER TABLE `prescription` ADD `id_organisation` INT NULL AFTER `doctorname`;
ALTER TABLE `prescription` ADD `organisation_destinataire` INT NULL AFTER `id_organisation`;
ALTER TABLE `prescription` ADD `patientlastname` VARCHAR(200) NULL AFTER `organisation_destinataire`;
ALTER TABLE `prescription` ADD `date_string` VARCHAR(100) NULL AFTER `patientlastname`;
ALTER TABLE `prescription` ADD `user` INT NULL AFTER `medicament`, ADD `etat` INT NULL AFTER `user`;
ALTER TABLE `prescription` ADD `code_facture` VARCHAR(100) NULL AFTER `etat`;*/