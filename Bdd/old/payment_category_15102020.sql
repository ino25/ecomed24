-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 15 oct. 2020 à 16:14
-- Version du serveur :  5.7.17
-- Version de PHP :  7.1.3

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
-- Structure de la table `payment_category`
--

CREATE TABLE `payment_category` (
  `id` int(10) NOT NULL,
  `prestation` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `tarif_public` varchar(100) DEFAULT NULL,
  `tarif_professionnel` varchar(100) DEFAULT NULL,
  `tarif_assurance` varchar(100) DEFAULT NULL,
  `id_service` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `payment_category`
--

INSERT INTO `payment_category` (`id`, `prestation`, `description`, `tarif_public`, `tarif_professionnel`, `tarif_assurance`, `id_service`) VALUES
(3, 'Sage Femme', '', '5000', '4500', '5500', 1),
(4, 'Consultation Pre-natale', '', '10000', '8500', '15000', 1),
(5, 'Consultation Gynecologique', '', '10000', '8500', '15000', 1),
(6, 'Medecine Generale', '', '5000', '4250', '7500', 1),
(7, 'AC ANTI-HBc', '', '15000', '12750', '22500', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `payment_category`
--
ALTER TABLE `payment_category`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `payment_category`
--
ALTER TABLE `payment_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
