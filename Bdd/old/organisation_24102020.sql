-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  Dim 25 oct. 2020 à 00:27
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
-- Base de données :  `dbzuulumed`
--

-- --------------------------------------------------------

--
-- Structure de la table `organisation`
--

CREATE TABLE `organisation` (
  `id` bigint(20) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `nom_commercial` varchar(255) DEFAULT NULL,
  `path_logo` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `departement` varchar(255) NOT NULL,
  `arrondissement` varchar(255) NOT NULL,
  `collectivite` varchar(255) NOT NULL,
  `pays` varchar(255) DEFAULT 'Sénégal',
  `email` varchar(255) NOT NULL,
  `numero_fixe` varchar(45) DEFAULT NULL,
  `prenom_responsable_legal` varchar(255) DEFAULT NULL,
  `nom_responsable_legal` varchar(255) DEFAULT NULL,
  `portable_responsable_legal` varchar(45) DEFAULT NULL,
  `id_partenaire_zuuluPay` varchar(20) NOT NULL,
  `pin_partenaire_zuuluPay_encrypted` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `est_active` int(1) DEFAULT '0',
  `date_creation` int(11) NOT NULL,
  `date_mise_a_jour` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `organisation`
--

INSERT INTO `organisation` (`id`, `nom`, `nom_commercial`, `path_logo`, `adresse`, `region`, `departement`, `arrondissement`, `collectivite`, `pays`, `email`, `numero_fixe`, `prenom_responsable_legal`, `nom_responsable_legal`, `portable_responsable_legal`, `id_partenaire_zuuluPay`, `pin_partenaire_zuuluPay_encrypted`, `type`, `est_active`, `date_creation`, `date_mise_a_jour`) VALUES
(1, 'Centre Médical Ademis', 'Centre Médical Ademis', 'uploads/logosPartenaires/2214020000_221402000019.png', 'Camberene', 'Dakar', 'Dakar', 'Parcelles Assainies', 'Camberene', 'Senegal', 'kheush@hotmail.com', '', 'Pape Amadou', 'Niang Diallo', NULL, '2214020000', '3e02d8a45df3ab404f27dcce9e0ce7253737b6cc0b7b820944503edf08e91ecd45ca71b91639b75c182d491596cc464a095cf894580004c4ee5aa9a192a1bb1e9zPOQNnkp9xsFKAaXPTWmzGC6XQs1lL7o813BqNuZFI=', 'Clinique', 1, 1603485308, 1603486098);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `organisation`
--
ALTER TABLE `organisation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `organisation`
--
ALTER TABLE `organisation`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
