-- pco_changes_history
	-- id
	-- idpco
	-- new_tarif_public
	-- new_tarif_professionel
	-- new_tarif_assurance
	-- new_tarif_ipm
	-- date
	-- changed_by
	-- is_initial
	
CREATE TABLE `pco_changes_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idpco` int(11) NOT NULL,
  `new_tarif_public` decimal(15,6) DEFAULT 0,
  `new_tarif_professionnel` decimal(15,6) DEFAULT 0,
  `new_tarif_assurance` decimal(15,6) DEFAULT 0,
  `new_tarif_ipm` decimal(15,6) DEFAULT 0,
   `date` varchar(100) DEFAULT NULL,
  `changed_by_user` int(11) NOT NULL,
  `is_initial` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
);