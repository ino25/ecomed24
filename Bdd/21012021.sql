ALTER TABLE `payment` ADD `id_zuulupay` VARCHAR(255) NULL DEFAULT NULL AFTER `organisation_destinataire`;
ALTER TABLE `payment` ADD `date_Facture` VARCHAR(255) NULL DEFAULT NULL AFTER `id_zuulupay`