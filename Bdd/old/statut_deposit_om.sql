-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 10 déc. 2020 à 23:36
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
-- Structure de la table `statut_deposit_om`
--

DROP TABLE IF EXISTS `statut_deposit_om`;
CREATE TABLE IF NOT EXISTS `statut_deposit_om` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_zuulupay` varchar(100) DEFAULT NULL,
  `patient` varchar(100) DEFAULT NULL,
  `id_organisation` int(11) DEFAULT NULL,
  `payment_id` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `deposited_amount` varchar(100) DEFAULT NULL,
  `amount_received_id` varchar(100) DEFAULT NULL,
  `deposit_type` varchar(100) DEFAULT NULL,
  `gateway` varchar(100) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `statut_deposit` varchar(255) DEFAULT NULL,
  `ref_om` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `statut_deposit_om`
--

INSERT INTO `statut_deposit_om` (`id`, `id_zuulupay`, `patient`, `id_organisation`, `payment_id`, `date`, `deposited_amount`, `amount_received_id`, `deposit_type`, `gateway`, `user`, `statut_deposit`, `ref_om`) VALUES
(63, NULL, '12', 3, '62', '1607623928', '100', '', 'OrangeMoney', NULL, '1', 'PENDING', NULL),
(64, NULL, '12', 3, '62', '1607625203', '100', '', 'OrangeMoney', NULL, '1', 'PENDING', 'PP349349.9455.D43493'),
(65, NULL, '1', 3, '64', '1607627762', '1000', '', 'OrangeMoney', NULL, '1', 'PENDING', 'PP______.____._____'),
(66, NULL, '1', 3, '65', '1607628005', '100', '', 'OrangeMoney', NULL, '1', 'PENDING', 'PP545656.5664.D43493'),
(67, NULL, '12', 3, '62', '1607633396', '100', '', 'OrangeMoney', NULL, '1', 'PENDING', 'PP549545.9569.F94549'),
(68, NULL, '12', 3, '62', '1607633545', '100', '', 'OrangeMoney', NULL, '1', 'PENDING', 'PP594695.6569.D59454'),
(69, NULL, '12', 3, '62', '1607635399', '600', '', 'OrangeMoney', NULL, '1', 'PENDING', 'PP456965.6965.G59454'),
(70, NULL, '12', 3, '62', '1607635576', '1000', '', 'OrangeMoney', NULL, '1', 'PENDING', 'PP956565.6669.F45045'),
(71, NULL, '3', 3, '66', '1607637244', '1200', '', 'OrangeMoney', NULL, '1', 'PENDING', 'PP545566.6656.B77878'),
(72, NULL, '3', 3, '67', '1607637732', '1000', '', 'OrangeMoney', NULL, '1', 'PEDDING', 'PP495435.3454.R45945'),
(73, NULL, '11', 3, '61', '1607642115', '1000', '', 'OrangeMoney', NULL, '1', 'PENDING', 'PP565656.9656.D49545'),
(74, NULL, '11', 3, '61', '1607642690', '1000', '', 'OrangeMoney', NULL, '1', 'PENDING', 'PP696767.7679.R56956'),
(75, NULL, '13', 3, '68', '1607642867', '1500', '', 'OrangeMoney', NULL, '1', 'PENDING', 'PP676776.5656.F56565'),
(76, NULL, '13', 3, '68', '1607643125', '1000', '', 'OrangeMoney', NULL, '1', 'PENDING', 'PP340545.4545.D45454');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
