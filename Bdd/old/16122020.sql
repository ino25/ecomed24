ALTER TABLE `medical_history` ADD `date_string` VARCHAR(255) NULL DEFAULT NULL AFTER `registration_time`,
 ADD `payment_id` INT(50) NOT NULL AFTER `date_string`, ADD `prestation` VARCHAR(255) NOT NULL AFTER `payment_id`;
ALTER TABLE `medical_history` ADD `code` VARCHAR(255) NULL DEFAULT NULL AFTER `prestation`;
ALTER TABLE `medical_history` ADD `user` VARCHAR(255) NULL DEFAULT NULL AFTER `code`;
ALTER TABLE `medical_history` ADD `patient_last_name` VARCHAR(255) NULL DEFAULT NULL AFTER `user`;