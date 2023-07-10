-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 11 nov. 2020 à 15:42
-- Version du serveur :  5.7.17
-- Version de PHP :  7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `dbzuulumednew`
--

-- --------------------------------------------------------

--
-- Structure de la table `lab_data`
--

CREATE TABLE `lab_data` (
  `id` int(20) NOT NULL,
  `id_lab` int(11) NOT NULL,
  `idPaymentConcatRelevantCategoryPart` varchar(765) NOT NULL,
  `prestation` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `resultats` varchar(255) NOT NULL,
  `unite` varchar(255) NOT NULL,
  `valeurs` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `lab_data`
--
ALTER TABLE `lab_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `lab_data`
--
ALTER TABLE `lab_data`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
