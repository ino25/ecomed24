
ALTER TABLE `lab` ADD `id_organisation` INT NULL;

ALTER TABLE `payment` ADD `service` INT NULL AFTER `doctor`;
ALTER TABLE `appointment` ADD `code` VARCHAR(25) NULL AFTER `id`;