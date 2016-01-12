-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 12 Janvier 2016 à 15:32
-- Version du serveur :  5.6.25
-- Version de PHP :  5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `wf3_team`
--

-- --------------------------------------------------------

--
-- Structure de la table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `title` varchar(70) NOT NULL,
  `description` varchar(255) NOT NULL,
  `game_time` int(11) NOT NULL,
  `released_date` datetime NOT NULL,
  `platform_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `games`
--

INSERT INTO `games` (`id`, `img`, `title`, `description`, `game_time`, `released_date`, `platform_id`, `user_id`) VALUES
(13, 'http://www.n-3ds.com/wp-content/uploads/2011/04/3ds-zelda-ocarina-of-time-site-officiel.jpg', 'The Legend of Zelda: Ocarina of Time', 'The Legend of Zelda: Ocarina of Time, est un jeu vidéo d''action-aventure développé par Nintendo EAD et édité par Nintendo. Il est sorti fin 1998 sur Nintendo 64.', 60, '1998-11-21 00:00:00', 7, 1),
(15, 'http://cdn.supersoluce.com/file/docs/docid_4f71559d8f152f5d660058a2/elemid_4ee9d6ec0a2fe93f0e00000c/final-fantasy-vii-pc.jpg', 'Final Fantasy VII', 'Final Fantasy VII est un jeu vidéo de rôle développé par Square sous la direction de Yoshinori Kitase et sorti en 1997, constituant le septième opus de la série Final Fantasy.', 60, '1997-01-31 00:00:00', 15, 2),
(16, 'http://musiquesdepub.com/wp-content/uploads/2015/12/dxar5kfrmswtvmet3msb.jpg', 'Just Cause 3', 'Just Cause 3 est un jeu vidéo d''action-aventure développé par Avalanche Studios et édité par Square Enix, sorti le 1?? décembre 2015 sur PlayStation 4, Xbox One et Windows. Il s''agit du troisième opus de la série Just Cause', 30, '2015-12-01 00:00:00', 2, 3),
(17, 'http://gunxblast.fr/wp-content/uploads/2014/09/ff15prev.jpg', 'FIFA 15', 'FIFA 15 est un jeu vidéo développé par Electronic Arts et édité par EA Sports sorti le 25 septembre 2014. C''est le 21? jeu de la franchise FIFA Football et la suite de FIFA 14.', 99, '2014-09-23 00:00:00', 1, 5),
(19, 'http://www.rockstargames.com/V/img/global/facebook/index-en_us-480.jpg', 'Grand Theft Auto V', 'Grand Theft Auto V est un jeu vidéo d''action-aventure, développé par Rockstar North et édité par Rockstar Games.', 99, '2013-09-17 00:00:00', 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `platforms`
--

CREATE TABLE IF NOT EXISTS `platforms` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `platforms`
--

INSERT INTO `platforms` (`id`, `name`) VALUES
(1, 'Xbox'),
(2, 'Playstation 4'),
(3, 'Wii U'),
(4, 'Megadrive'),
(5, 'Wii U'),
(6, 'Megadrive'),
(7, 'N64'),
(8, 'Nes'),
(9, 'Wii'),
(10, 'PSone'),
(11, 'GameBoy'),
(12, 'N64'),
(13, 'Nes'),
(14, 'Wii'),
(15, 'PSone'),
(16, 'GameBoy');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `name` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipcode` varchar(5) NOT NULL,
  `city` varchar(255) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `lat` varchar(15) DEFAULT NULL,
  `lng` varchar(15) DEFAULT NULL,
  `role` varchar(15) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created_at`, `updated_at`, `name`, `firstname`, `address`, `zipcode`, `city`, `tel`, `lat`, `lng`, `role`) VALUES
(1, 'aubertcam@gmail.com', '$2y$10$HvjPrF1QHsK9bAYI4eNciO5MzH5Xn5k3ECRZWQ2eoan8/40ZDNFmi', '2016-01-11 15:51:40', '2016-01-11 15:51:40', '', '', '', '', '', '', NULL, NULL, ''),
(2, 'camoulox@hotmail.com', '$2y$10$Do1l987SZSZ8E2Ol5KBq8u9QSZGD0r9CSrt2pDHVH6cE6LKriANvm', '2016-01-11 16:50:53', '2016-01-11 16:50:53', 'Aubio', 'Camos', '43 quai de Valmy', '75010', 'Paris', '0622458741', NULL, NULL, ''),
(3, 'olivier.dutranois@gmail.com', '$2y$10$4uHu3mRALSYbPT3x/cebYOGqXGl5f1zLKQD4N/QVTnrrAV.mgvdRK', '2016-01-11 16:58:16', '2016-01-11 16:58:16', 'Dutranois', 'Olivier', '5 rue du pressoir', '95400', 'Villiers le Bel', '0622417852', NULL, NULL, ''),
(4, 'camimos@hoti.com', '$2y$10$dZ91l1O31AVmijVnGQXjlOLp7mcgPClWpsOsdcqAj4E2HJ7DEFqV6', '2016-01-11 17:08:44', '2016-01-11 17:08:44', 'Zibou', 'Cajou', '43 quai de Valmy', '75010', 'Paris', '0622458741', '48.8695034', '2.366272', NULL),
(5, 'riton@hotmail.com', '$2y$10$HU7htIdILOW41J8JSas/Dubl6gwMqSz5d134urxXNd2ivSAzVPqYu', '2016-01-11 17:14:49', '2016-01-11 17:14:49', 'Aubio', 'Camos', '43 quai de Valmy', '75010', 'Paris', '0622458741', '48.8695034', '2.366272', NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `platform_id` (`platform_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `platform_id_2` (`platform_id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- Index pour la table `platforms`
--
ALTER TABLE `platforms`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT pour la table `platforms`
--
ALTER TABLE `platforms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `fk_platform` FOREIGN KEY (`platform_id`) REFERENCES `platforms` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
