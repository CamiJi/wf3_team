-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 12 Janvier 2016 à 10:38
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `platforms`
--

CREATE TABLE IF NOT EXISTS `platforms` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `platforms`
--
ALTER TABLE `platforms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
  ADD CONSTRAINT `fk_platforms` FOREIGN KEY (`platform_id`) REFERENCES `platforms` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
