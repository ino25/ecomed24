CREATE TABLE `generated_otp` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `date_created` int(11) unsigned NOT NULL,
  `is_valid` int(1) DEFAULT 1,
  PRIMARY KEY (`id`)
);