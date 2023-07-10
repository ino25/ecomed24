ALTER TABLE `payment` ADD `category_name_pro` VARCHAR(1000) NULL AFTER `category_name`;
ALTER TABLE `payment` ADD `code_pro` VARCHAR(255) NULL AFTER `code`;



CREATE TABLE `payment_pro` (
  `idpro` int(11) NOT NULL,
  `codepro` varchar(255) DEFAULT NULL,
  `codefacture` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `payment_pro` ADD PRIMARY KEY (`idpro`);
ALTER TABLE `payment_pro` MODIFY `idpro` int(11) NOT NULL AUTO_INCREMENT;