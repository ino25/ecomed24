
ALTER TABLE `organisation` ADD `is_light` INT NULL DEFAULT '0' AFTER `is_transfert`;
ALTER TABLE `payment` ADD `etatlight` INT NULL DEFAULT NULL AFTER `etat`;
ALTER TABLE `payment` ADD `organisation_light_origin` INT NULL DEFAULT NULL AFTER `etatlight`;
