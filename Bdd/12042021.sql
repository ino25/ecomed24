ALTER TABLE `payment` ADD `prescripteur` VARCHAR(255) NULL DEFAULT NULL AFTER `organisation_destinataire`;


CREATE TABLE `assistant` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `img_url` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `x` varchar(100) DEFAULT NULL,
  `ion_user_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8

INSERT INTO `groups` (`id`, `name`, `description`, `label_fr`) VALUES ('12', 'Assistant', 'Assistant', 'Assistant');
