CREATE TABLE `setting_service_specialite_organisation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_service` int(11) NOT NULL,
  `id_specialite` int(11) NOT NULL,
  `id_organisation` int(11) NOT NULL,
  `statut` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `payment_category_organisation` (
  `idpco` int(11) NOT NULL AUTO_INCREMENT,
  `id_presta` int(11) NOT NULL,
  `id_organisation` int(11) NOT NULL,
  `statut` int(1) DEFAULT NULL,
  `tarif_public` decimal(15,6) DEFAULT NULL,
  `tarif_professionnel` decimal(15,6) DEFAULT NULL,
  `tarif_assurance` decimal(15,6) DEFAULT NULL,
  `tarif_ipm` decimal(15,6) DEFAULT NULL,
  PRIMARY KEY (`idpco`)
);

CREATE TABLE `payment_category_panier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_prestation` int(11) NOT NULL,
  `id_organisation` int(11) NOT NULL,
  `statut` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ALTER TABLE `payment_category_organisation` CHANGE `tarif_ipm` `tarif_ipm` DECIMAL(15,6) NULL DEFAULT NULL;