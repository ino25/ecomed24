ALTER TABLE organisation ADD COLUMN code VARCHAR(3) AFTER id;

ALTER TABLE `patient` ADD `id_organisation` INT NULL AFTER `id`;
ALTER TABLE `payment` ADD `id_organisation` INT NULL AFTER `patient`;
ALTER TABLE `patient_deposit` ADD `id_organisation` INT NULL AFTER `patient`;
ALTER TABLE `medical_history` ADD `id_organisation` INT NULL AFTER `patient_id`;
ALTER TABLE `patient_material` ADD `id_organisation` INT NULL AFTER `id`;
ALTER TABLE `patient_mutuelle` ADD `id_organisation` INT NULL AFTER `pm_idpatent`;
ALTER TABLE `setting_service` ADD `id_organisation` INT NULL AFTER `idservice`;

ALTER TABLE `appointment` ADD `id_organisation` INT NULL AFTER `patient`;

ALTER TABLE `expense_category` ADD `id_organisation` INT NULL;

ALTER TABLE `payment` ADD `code` VARCHAR(25) NULL AFTER `id`;
ALTER TABLE `lab` ADD `id_organisation` INT NULL;

ALTER TABLE `payment` ADD `service` INT NULL AFTER `doctor`;
