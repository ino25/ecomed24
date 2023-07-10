
ALTER TABLE `payment` ADD `status_presta` VARCHAR(100) NULL AFTER `status`;
ALTER TABLE `payment` ADD `status_paid` VARCHAR(20) NOT NULL DEFAULT 'unpaid' AFTER `status_presta`;