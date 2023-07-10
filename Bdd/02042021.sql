CREATE TABLE `execute_user` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `id_prestation` varchar(500) DEFAULT NULL,
  `id_payment` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `date_string` varchar(255) DEFAULT NULL,
  `statut` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`));
