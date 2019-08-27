-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 27 août 2019 à 20:32
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
  PRIMARY KEY (`idI`,`idR`),
  KEY `idR_idx` (`idR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `contient`
--

INSERT INTO `contient` (`idI`, `idR`, `quantite`, `unite`) VALUES
(13, 12, 1, 'L'),
(14, 12, 10, 'G'),
(15, 12, 10, 'G'),
(17, 13, 3, 'Feuille'),
(18, 13, 1, 'Cm'),
(18, 14, 1, 'Gousse'),
(19, 13, 3, 'Cs'),
(20, 13, 600, 'Ml'),
(22, 14, 0.5, 'Gousse'),
(24, 14, 0.5, 'Botte'),
(26, 14, 2, 'Cs'),
(27, 14, 1, 'Pincée'),
(28, 14, 0.25, ''),
(29, 14, 100, 'Ml'),
(30, 14, 12, ''),
(31, 14, 1, 'Pincée');

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `etape`
--

INSERT INTO `etape` (`idE`, `photo`, `contenu`, `idR`) VALUES
(7, NULL, 'Mettre l\'eau dans une casserole. Tremper le konbu coupé en deux au moins 30 minutes. Vous pouvez faire cette opération la veille ou quelques heures avant. Laisser infuser au frais.', 12),
(8, NULL, 'Faire chauffer l\'eau a feu doux. Attendre environ 15 minutes jusqu\'au frémissement. Il ne faut jamais porter a ébullition car le gout de l\'algue serait trop fort. Retirer le konbu juste avant l\'ébullition et mettre le katsuobushi d\'un coup. Faire chauffer a feu moyen et porter a ébullition. Éteindre le feu immédiatement. Laisser infuser 10 minutes.', 12),
(9, NULL, 'Filtrer le dashi dans un bol avec une passoire. Laisser tomber les gouttes de dashi en pressant légèrement.', 12),
(11, NULL, 'Couper le chou chinois en 3, puis en lamelle de 7 mm.\r\nCouper le gingembre en fine julienne.\r\nSur feu vif, chauffer le dashi et, quand il bout, mettre le chou chinois.\r\nFaire cuire 5 minutes environ à feu moyen.\r\nAjouter le gingembre puis faire fondre le miso, retirer du feu et servir.', 13),
(12, '', 'Presser le citron vert.\nMixer tous les ingrédients sauf les gambas et le sel.\nCouper la tête des gambas et les décortiquer en laissant la queue.\nEntailler un peu le dos et retirer le filament noir.\nLes faire cuire dans le l\'eau bouillante avec le gros sel.\nBien les essorer et mélanger avec 3 cuillerées à soupe de sauce.', 14);

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

--
-- Déchargement des données de la table `favori`
--

INSERT INTO `favori` (`idU`, `idR`) VALUES
(2, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ingredient`
--

INSERT INTO `ingredient` (`idI`, `nom`, `photo`) VALUES
(1, 'Oeuf', 'https://www.agroportal.pt/wp-content/uploads/www.agropopular.comegg-157224_960_720-93617089280866fa2b3487ed1f7b9058b30d0f7a.png'),
(2, 'Curry en poudre', 'https://www.thespicery.com/pub/media/catalog/product/cache/c687aa7517cf01e65c009f6943c2b1e9//m/i/mild_curry_powder.png'),
(3, 'Poulet', NULL),
(8, 'Betterave', NULL),
(9, 'Bavette', NULL),
(10, 'Sucre', NULL),
(11, 'Basilic', NULL),
(12, 'Rouget', NULL),
(13, 'Eau', NULL),
(14, 'Konbu', NULL),
(15, 'Katsuobushi', NULL),
(16, 'Choux', NULL),
(17, 'Chou chinois', NULL),
(18, 'Gingembre', NULL),
(19, 'Miso blanc', NULL),
(20, 'Dashi', NULL),
(21, 'Persil', NULL),
(22, 'Ail', NULL),
(23, 'Oignon', NULL),
(24, 'Coriandre', NULL),
(25, 'Crevette', NULL),
(26, 'Nuoc-mam', NULL),
(27, 'Sucre de canne', NULL),
(28, 'Citron vert', NULL),
(29, 'Huile de sésame', NULL),
(30, 'Gambas', NULL),
(31, 'Gros sel', NULL);

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
  `cout` tinyint(1) NOT NULL,
  `facilite` tinyint(1) NOT NULL,
  `idU` int(11) NOT NULL,
  `pere` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idR`),
  KEY `idU_idx` (`idU`),
  KEY `idR_idx` (`pere`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `recette`
--

INSERT INTO `recette` (`idR`, `nom`, `tempsCuisson`, `tempsPrep`, `quantite`, `uniteQ`, `source`, `pays`, `cout`, `facilite`, `idU`, `pere`, `date`) VALUES
(1, 'Galette de courgettes', '00:05:00', '00:15:00', 2, 'Personnes', NULL, 'japon', 0, 0, 2, NULL, '2019-08-20 13:42:22'),
(12, 'Dashi', '00:20:00', '00:40:00', 1, 'L', 'Tokyo, les recettes cultes', 'Japon', 1, 0, 2, NULL, '2019-08-27 12:02:20'),
(13, 'Dashi au miso blanc et chou chinois', '00:05:00', '00:10:00', 4, 'Personne', 'Tokyo, les recettes cultes', 'Japon', 0, 0, 2, NULL, '2019-08-27 12:23:54'),
(14, 'Crevette à la coriandre', '00:05:00', '00:15:00', 4, 'Personne', 'Tokyo, les recettes cultes', 'Japon', 1, 1, 2, NULL, '2019-08-27 16:41:23');

-- --------------------------------------------------------

--
-- Structure de la table `saison`
--

DROP TABLE IF EXISTS `saison`;
CREATE TABLE IF NOT EXISTS `saison` (
  `idS` int(11) NOT NULL AUTO_INCREMENT,
  `saisoncol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idS`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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

--
-- Déchargement des données de la table `se_prepare_en`
--

INSERT INTO `se_prepare_en` (`idR`, `idS`) VALUES
(12, 1),
(13, 1),
(14, 1),
(12, 2),
(14, 2),
(12, 3),
(13, 3),
(14, 3),
(12, 4),
(13, 4),
(14, 4);

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `idT` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) NOT NULL,
  PRIMARY KEY (`idT`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tag`
--

INSERT INTO `tag` (`idT`, `nom`) VALUES
(1, 'Plat principal'),
(2, 'Entrée'),
(3, 'Soupe'),
(4, 'Léger'),
(5, 'Soir'),
(6, 'Dessert'),
(7, 'Pâte'),
(8, 'Tarte'),
(10, 'Salade'),
(11, 'Bouillon');

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

--
-- Déchargement des données de la table `tague`
--

INSERT INTO `tague` (`idR`, `idT`) VALUES
(13, 2),
(13, 4),
(13, 5),
(12, 11),
(13, 11);

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
  `status` enum('PENDING','USER','ADMIN','REJECTED') NOT NULL DEFAULT 'PENDING',
  PRIMARY KEY (`idU`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idU`, `nom`, `prenom`, `email`, `mdp`, `status`) VALUES
(2, 'Pépin', 'Thibaut', 'pepnou1@gmail.com', '$2y$10$u2TjG3mbeQvDMF0xKMd2fOcOLHy2xn4GFyUw5CPbkzmw2mWik137W', 'ADMIN');

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
  ADD CONSTRAINT `c_idR` FOREIGN KEY (`idR`) REFERENCES `recette` (`idR`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
