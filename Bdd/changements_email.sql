ALTER TABLE `email` ADD `attachment_path` VARCHAR(1000) NULL DEFAULT NULL AFTER `reciepient`;
ALTER TABLE `email` CHANGE `subject` `subject` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;