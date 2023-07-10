
INSERT INTO `groups` (`id`, `name`, `description`, `label_fr`) VALUES (NULL, 'adminmedecin', 'adminmedecin', 'Médecin-chef');
CREATE TABLE IF NOT EXISTS `adminmedecin` (
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

UPDATE `dbzuulumed`.`groups` SET `label_fr` = 'Médecin gérant' WHERE `groups`.`id` = 11;