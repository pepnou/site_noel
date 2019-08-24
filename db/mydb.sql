-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 24 août 2019 à 10:21
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mydb`
--

-- --------------------------------------------------------

--
-- Structure de la table `contient`
--

DROP TABLE IF EXISTS `contient`;
CREATE TABLE IF NOT EXISTS `contient` (
  `idI` int(11) NOT NULL,
  `idR` int(11) NOT NULL,
  `quantite` float NOT NULL,
  `unite` varchar(45) DEFAULT NULL,
  `idRC` int(11) NOT NULL,
  `cat` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idI`,`idR`,`idRC`),
  KEY `idR_idx` (`idR`),
  KEY `idR_idx1` (`idRC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `etape`
--

DROP TABLE IF EXISTS `etape`;
CREATE TABLE IF NOT EXISTS `etape` (
  `idE` int(11) NOT NULL AUTO_INCREMENT,
  `photo` varchar(255) DEFAULT NULL,
  `contenu` text,
  `idR` int(11) NOT NULL,
  PRIMARY KEY (`idE`),
  KEY `idR_idx` (`idR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `favori`
--

DROP TABLE IF EXISTS `favori`;
CREATE TABLE IF NOT EXISTS `favori` (
  `idU` int(11) NOT NULL,
  `idR` int(11) NOT NULL,
  PRIMARY KEY (`idU`,`idR`),
  KEY `idR_idx` (`idR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ingredient`
--

DROP TABLE IF EXISTS `ingredient`;
CREATE TABLE IF NOT EXISTS `ingredient` (
  `idI` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idI`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

DROP TABLE IF EXISTS `photo`;
CREATE TABLE IF NOT EXISTS `photo` (
  `idP` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `idR` int(11) NOT NULL,
  PRIMARY KEY (`idP`),
  KEY `idR_idx` (`idR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `recette`
--

DROP TABLE IF EXISTS `recette`;
CREATE TABLE IF NOT EXISTS `recette` (
  `idR` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `tempsCuisson` time NOT NULL,
  `tempsPrep` time NOT NULL,
  `quantite` float NOT NULL,
  `uniteQ` varchar(45) NOT NULL,
  `source` varchar(255) DEFAULT NULL,
  `pays` varchar(45) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `type` varchar(45) NOT NULL,
  `cout` tinyint(1) NOT NULL,
  `facilite` tinyint(1) NOT NULL,
  `idU` int(11) NOT NULL,
  `pere` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idR`),
  KEY `idU_idx` (`idU`),
  KEY `idR_idx` (`pere`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `saison`
--

DROP TABLE IF EXISTS `saison`;
CREATE TABLE IF NOT EXISTS `saison` (
  `idS` int(11) NOT NULL AUTO_INCREMENT,
  `saisoncol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idS`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `saison`
--

INSERT INTO `saison` (`idS`, `saisoncol`) VALUES
(1, 'printemps'),
(2, 'été'),
(3, 'automne'),
(4, 'hiver');

-- --------------------------------------------------------

--
-- Structure de la table `se_prepare_en`
--

DROP TABLE IF EXISTS `se_prepare_en`;
CREATE TABLE IF NOT EXISTS `se_prepare_en` (
  `idR` int(11) NOT NULL,
  `idS` int(11) NOT NULL,
  PRIMARY KEY (`idR`,`idS`),
  KEY `idS_idx` (`idS`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `idT` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) NOT NULL,
  PRIMARY KEY (`idT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tague`
--

DROP TABLE IF EXISTS `tague`;
CREATE TABLE IF NOT EXISTS `tague` (
  `idR` int(11) NOT NULL,
  `idT` int(11) NOT NULL,
  PRIMARY KEY (`idR`,`idT`),
  KEY `idT_idx` (`idT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `idU` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) NOT NULL,
  `prenom` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `status` enum('PENDING','USER','ADMIN') NOT NULL DEFAULT 'PENDING',
  PRIMARY KEY (`idU`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ustensile`
--

DROP TABLE IF EXISTS `ustensile`;
CREATE TABLE IF NOT EXISTS `ustensile` (
  `idUs` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) NOT NULL,
  `photo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idUs`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `utilise`
--

DROP TABLE IF EXISTS `utilise`;
CREATE TABLE IF NOT EXISTS `utilise` (
  `idUs` int(11) NOT NULL,
  `idR` int(11) NOT NULL,
  PRIMARY KEY (`idUs`,`idR`),
  KEY `idR_idx` (`idR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contient`
--
ALTER TABLE `contient`
  ADD CONSTRAINT `c_idI` FOREIGN KEY (`idI`) REFERENCES `ingredient` (`idI`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `c_idR` FOREIGN KEY (`idR`) REFERENCES `recette` (`idR`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `c_idRC` FOREIGN KEY (`idRC`) REFERENCES `recette` (`idR`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `etape`
--
ALTER TABLE `etape`
  ADD CONSTRAINT `e_idR` FOREIGN KEY (`idR`) REFERENCES `recette` (`idR`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `favori`
--
ALTER TABLE `favori`
  ADD CONSTRAINT `f_idR` FOREIGN KEY (`idR`) REFERENCES `recette` (`idR`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `f_idU` FOREIGN KEY (`idU`) REFERENCES `user` (`idU`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `p_idR` FOREIGN KEY (`idR`) REFERENCES `recette` (`idR`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `recette`
--
ALTER TABLE `recette`
  ADD CONSTRAINT `r_idR` FOREIGN KEY (`pere`) REFERENCES `recette` (`idR`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `r_idU` FOREIGN KEY (`idU`) REFERENCES `user` (`idU`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `se_prepare_en`
--
ALTER TABLE `se_prepare_en`
  ADD CONSTRAINT `s_idR` FOREIGN KEY (`idR`) REFERENCES `recette` (`idR`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `s_idS` FOREIGN KEY (`idS`) REFERENCES `saison` (`idS`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `tague`
--
ALTER TABLE `tague`
  ADD CONSTRAINT `t_idR` FOREIGN KEY (`idR`) REFERENCES `recette` (`idR`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `t_idT` FOREIGN KEY (`idT`) REFERENCES `tag` (`idT`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `utilise`
--
ALTER TABLE `utilise`
  ADD CONSTRAINT `ut_idR` FOREIGN KEY (`idR`) REFERENCES `recette` (`idR`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ut_idUs` FOREIGN KEY (`idUs`) REFERENCES `ustensile` (`idUs`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
