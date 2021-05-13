-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 13 mai 2021 à 15:13
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `journaldumeme`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id_articles` int(11) NOT NULL AUTO_INCREMENT,
  `nom_produits` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `image_article` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id_articles`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id_articles`, `nom_produits`, `content`, `image_article`, `date`) VALUES
(2, 'Etre développeur', 'Voila la tête d\'un invite de commandes développeur aprés tous les ajouts fais par un dév pour bosser !', './libraries/assets/article/Article_1-4r5z9b.jpg', '2021-05-13');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id_comments` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `date` datetime(6) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_articles` int(11) NOT NULL,
  PRIMARY KEY (`id_comments`),
  KEY `id_users` (`id_users`),
  KEY `id_articles` (`id_articles`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id_comments`, `content`, `date`, `id_users`, `id_articles`) VALUES
(5, 'Alors je crois qu\'on approche d\'une mise en ligne :D', '2021-05-13 12:21:21.000000', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id_roles` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id_roles`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id_roles`, `nom`) VALUES
(1, 'Super_Admin'),
(2, 'Admin'),
(3, 'Users');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_users` int(11) NOT NULL AUTO_INCREMENT,
  `id_roles` int(11) NOT NULL,
  `civ` varchar(255) DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `date_Naissance` date DEFAULT NULL,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`id_users`),
  KEY `id_roles` (`id_roles`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_users`, `id_roles`, `civ`, `nom`, `prenom`, `date_Naissance`, `pseudo`, `email`, `passwd`, `avatar`) VALUES
(1, 1, NULL, 'l\'admin', 'soso', NULL, 'admin', 'sofiane.créateur@original.fr', '$2y$10$iYCxcnDMdR4Qd5KkEza.y.BWt8L43XHFEvBPnbqSoiiLUR28EJu2C', './libraries/assets/users_photo/1.jpeg'),
(2, 3, NULL, 'soso', 'soso', NULL, 'soso', 'soso@lala.fr', '$2y$10$vZoUywZ38xsveEwmv0Mn3.We8wUge9wJg.UJ9YMTzSbFimnX/V2Uq', './libraries/assets/users_photo/avatar.jpg'),
(3, 3, NULL, 'eaze', 'aze', NULL, 'zazae', 'jfrancoisbs@yahoo.fr', '$2y$10$ZNjZvfbDSkq2cewBplpwG.w2JJbGjmvjWdElBsC.1BXNGWljCbZ12', './libraries/assets/users_photo/avatar.jpg'),
(4, 3, NULL, 'test', 'test', NULL, 'tonton', 'sosoallan@gmail.com', '$2y$10$0VU.c8zGARSIcb7nGvsBLOX7Fknq.2N1bp1KdHetazUN.yarzkpQ.', './libraries/assets/users_photo/avatar.jpg'),
(16, 3, NULL, 'azeaeazeaze', 'azeazeaezazeaze', NULL, 'zaeazeazeazeaze', 'ssasazsz@azeazeaze.fr', '$2y$10$yhCGMicXHvfM/UiRuInp.evO9B3/Qv3Fg0yV9si10uJrcHOTAYUOC', './libraries/assets/users_photo/avatar.jpg'),
(17, 3, NULL, 'flo', 'flo', NULL, 'flo', 'flo@sensei.fr', '$2y$10$5BN7xDDciTomvAveFDjPx.hIcPNyFen71GBXGW2hrkPHxqP83umJy', './libraries/assets/users_photo/avatar.jpg'),
(19, 3, NULL, 'test', 'test', NULL, 'test', 'jfrancoisbss@yahoo.fr', '$2y$10$0gHJvAutOjWZyZJykdAmc.fLp3U74v/2rrrhdpx5UZRn25BuOLpia', './libraries/assets/users_photo/avatar.jpg');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_fk2` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_fk1` FOREIGN KEY (`id_articles`) REFERENCES `articles` (`id_articles`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fkidroles` FOREIGN KEY (`id_roles`) REFERENCES `roles` (`id_roles`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
