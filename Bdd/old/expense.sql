-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 22 oct. 2020 à 22:21
-- Version du serveur :  5.5.35
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `dbzuulumed`
--

-- --------------------------------------------------------

--
-- Structure de la table `expense`
--

DROP TABLE IF EXISTS `expense`;
CREATE TABLE IF NOT EXISTS `expense` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) DEFAULT NULL,
  `beneficiaire` varchar(255) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `amount` varchar(100) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `datestring` varchar(1000) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=262 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `expense`
--

INSERT INTO `expense` (`id`, `category`, `beneficiaire`, `date`, `note`, `amount`, `user`, `datestring`, `status`) VALUES
(1, 'securite', NULL, '1602712949', '10', '10000', '1', '14/10/20', NULL),
(2, 'sdfsdfs', NULL, '1602713945', '10', '780', '1', '14/10/20', NULL),
(3, 'Honoraires Medecin', NULL, '1603109002', NULL, NULL, '1', '19/10/20', NULL),
(4, 'Honoraires Medecin', NULL, '1603109046', NULL, NULL, '1', '19/10/20', NULL),
(5, 'Honoraires Medecin', NULL, '1603109052', NULL, NULL, '1', '19/10/20', NULL),
(6, 'Honoraires Medecin', NULL, '1603119459', NULL, NULL, '1', '19/10/20', NULL),
(7, 'Honoraires Medecin', NULL, '1603119488', NULL, NULL, '1', '19/10/20', NULL),
(8, 'Honoraires Medecin', NULL, '1603119583', NULL, NULL, '1', '19/10/20', NULL),
(9, 'Honoraires Medecin', NULL, '1603120159', NULL, NULL, '1', '19/10/20', NULL),
(10, 'Honoraires Medecin', NULL, '1603121721', NULL, NULL, '1', '19/10/20', NULL),
(11, 'Honoraires Medecin', NULL, '1603122817', NULL, NULL, '1', '19/10/20', NULL),
(12, 'Honoraires Medecin', NULL, '1603123129', NULL, NULL, '1', '19/10/20', NULL),
(13, 'Honoraires Medecin', NULL, '1603123439', NULL, NULL, '1', '19/10/20', NULL),
(14, 'Honoraires Medecin', NULL, '1603123542', NULL, NULL, '1', '19/10/20', NULL),
(15, 'Honoraires Medecin', NULL, '1603123744', NULL, NULL, '1', '19/10/20', NULL),
(261, 'Honoraires Medecin', NULL, '1603379072', 'TEST argent', '.', '1', '22/10/20', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
