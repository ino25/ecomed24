

ALTER TABLE `patient` ADD `nom_mutuelle` VARCHAR(100) NULL AFTER `region`, ADD `num_police` VARCHAR(100) NULL AFTER `nom_mutuelle`, ADD `date_valid` VARCHAR(100) NULL AFTER `num_police`, ADD `charge_mutuelle` INT NULL AFTER `date_valid`;

ALTER TABLE `expense_category` ADD `code` VARCHAR(100) NULL AFTER `y`;
INSERT INTO `expense_category` (`id`, `category`, `description`, `x`, `y`, `code`, `status`) VALUES 
(NULL, 'Achat de crédit', NULL, NULL, NULL, 'awoyofal', '2'),
(NULL, 'Achat de woyofal', NULL, NULL, NULL, 'awoyofal', '2'),
(NULL, 'Paiement facture Seneau', NULL, NULL, NULL, 'aseneau', '2'),
(NULL, 'Paiement facture Senelec', NULL, NULL, NULL, 'fsenelec', '2');

ALTER TABLE `expense` ADD `status` INT NULL AFTER `datestring`;


ALTER TABLE `patient` ADD `lien_parente` VARCHAR(100) NULL AFTER `charge_mutuelle`, ADD `parent_id` INT NULL AFTER `lien_parente`, ADD `parent_name` VARCHAR(200) NULL AFTER `parent_id`;

ALTER TABLE `expense_category` ADD `status` INT NULL AFTER `code`;

