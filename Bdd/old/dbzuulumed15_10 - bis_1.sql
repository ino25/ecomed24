ALTER TABLE `patient` ADD `last_name` VARCHAR(100) NULL AFTER `name`;
ALTER TABLE `patient` ADD `status` INT NULL AFTER `how_added`;

CREATE TABLE `setting_department` (
  `iddepartment` int(11) UNSIGNED NOT NULL,
  `name_department` varchar(100) NOT NULL,
  `description_department` varchar(1000) NOT NULL,
  `x` varchar(10) DEFAULT NULL,
  `y` varchar(10) DEFAULT NULL,
  `status_department` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `2509172043_setting_department`
--

INSERT INTO `setting_department` (`iddepartment`, `name_department`, `description_department`, `x`, `y`, `status_department`) VALUES
(1, 'dep', '<p>d</p>\r\n', NULL, NULL, NULL),
(2, 'laboo', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `2509172043_setting_poste`
--

CREATE TABLE `setting_poste` (
  `idposte` int(11) UNSIGNED NOT NULL,
  `name_poste` varchar(100) NOT NULL,
  `description_poste` varchar(1000) NOT NULL,
  `x` varchar(10) DEFAULT NULL,
  `y` varchar(10) DEFAULT NULL,
  `status_poste` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `2509172043_setting_service`
--

CREATE TABLE `setting_service` (
  `idservice` int(11) UNSIGNED NOT NULL,
  `name_service` varchar(100) NOT NULL,
  `description_service` varchar(1000) NOT NULL,
  `id_department` int(11) DEFAULT NULL,
  `x` varchar(10) DEFAULT NULL,
  `y` varchar(10) DEFAULT NULL,
  `status_service` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `2509172043_setting_service`
--

INSERT INTO `setting_service` (`idservice`, `name_service`, `description_service`, `id_department`, `x`, `y`, `status_service`) VALUES
(1, 'Generaliste', '', 1, NULL, NULL, 1),
(2, 'laboo**************', '', 2, NULL, NULL, 1);

ALTER TABLE `setting_service`
  ADD PRIMARY KEY (`idservice`);