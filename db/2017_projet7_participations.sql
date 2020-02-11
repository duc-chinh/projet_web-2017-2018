-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Dim 29 Avril 2018 à 14:13
-- Version du serveur :  5.7.14
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `2017_projet7_participations`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `cid` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`cid`, `nom`) VALUES
(1, 'Examens'),
(2, 'Cours'),
(3, 'TPs');

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

CREATE TABLE `evenements` (
  `eid` int(11) NOT NULL,
  `intitule` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `dateDebut` datetime NOT NULL,
  `dateFin` datetime NOT NULL,
  `type` enum('ouvert','ferme') NOT NULL,
  `cid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `evenements`
--

INSERT INTO `evenements` (`eid`, `intitule`, `description`, `dateDebut`, `dateFin`, `type`, `cid`) VALUES
(1, 'Examen Progweb', 'Examen de programmation WEB', '2018-05-05 10:00:00', '2018-05-05 12:00:00', 'ferme', 1),
(2, 'Examen BD', 'Examen des bases de données', '2018-05-12 14:00:00', '2018-05-12 17:00:00', 'ferme', 1),
(3, 'TP de programmation fonctionnelle', 'TP de programmation fonctionnelle', '2018-01-04 00:00:00', '2018-06-08 00:00:00', 'ouvert', 3),
(4, 'Cours d\'Analyse', 'Analyse 2', '2018-03-07 00:00:00', '2018-06-09 00:00:00', 'ouvert', 2);

-- --------------------------------------------------------

--
-- Structure de la table `identifications`
--

CREATE TABLE `identifications` (
  `pid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `valeur` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `identifications`
--

INSERT INTO `identifications` (`pid`, `tid`, `valeur`) VALUES
(1, 1, '66400990216635'),
(2, 1, '662333188825'),
(2, 2, '82CVT552'),
(3, 4, 'Brouillard Patrick'),
(4, 1, '66299937877425'),
(4, 4, 'Pires Simon'),
(5, 3, 'A4410134');

-- --------------------------------------------------------

--
-- Structure de la table `inscriptions`
--

CREATE TABLE `inscriptions` (
  `pid` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `inscriptions`
--

INSERT INTO `inscriptions` (`pid`, `eid`, `uid`) VALUES
(1, 1, 1),
(2, 1, 1),
(2, 3, 1),
(4, 1, 1),
(4, 3, 1),
(1, 2, 2),
(1, 4, 2),
(2, 4, 2),
(5, 1, 2),
(4, 2, 3),
(5, 3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `itypes`
--

CREATE TABLE `itypes` (
  `tid` int(11) NOT NULL,
  `nom` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `itypes`
--

INSERT INTO `itypes` (`tid`, `nom`) VALUES
(1, 'Code barre'),
(2, 'No RFID'),
(3, 'Passeport'),
(4, 'Nom et Prénom');

-- --------------------------------------------------------

--
-- Structure de la table `participations`
--

CREATE TABLE `participations` (
  `ptid` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `participations`
--

INSERT INTO `participations` (`ptid`, `eid`, `pid`, `date`, `uid`) VALUES
(1, 1, 1, '2018-05-05 10:02:00', 2),
(2, 1, 2, '2018-05-05 10:03:00', 2),
(3, 1, 5, '2018-05-05 10:02:30', 3),
(4, 2, 1, '2018-05-12 15:00:00', 1),
(5, 3, 2, '2018-03-02 10:00:00', 2),
(6, 3, 3, '2018-03-02 10:01:00', 2),
(7, 3, 4, '2018-03-02 10:05:00', 2),
(8, 3, 2, '2018-03-09 10:00:00', 3),
(9, 3, 2, '2018-03-18 10:00:00', 2),
(10, 4, 1, '2018-03-14 11:00:00', 2),
(11, 4, 2, '2018-03-14 11:01:00', 2),
(12, 4, 3, '2018-03-14 11:00:00', 3),
(13, 4, 4, '2018-03-14 11:02:00', 3),
(14, 4, 5, '2018-03-14 11:02:00', 2),
(15, 4, 5, '2018-03-21 11:00:00', 2),
(16, 4, 5, '2018-03-30 11:00:00', 3),
(17, 2, 5, '2018-03-30 11:00:02', 3);

-- --------------------------------------------------------

--
-- Structure de la table `personnes`
--

CREATE TABLE `personnes` (
  `pid` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `personnes`
--

INSERT INTO `personnes` (`pid`, `nom`, `prenom`) VALUES
(1, 'Beauvais', 'Jean-Luc'),
(2, 'Petit', 'Nicolas'),
(3, 'Brouillard', 'Patrick'),
(4, 'Pires', 'Simon'),
(5, 'Dulot', 'André');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`uid`, `login`, `mdp`, `role`) VALUES
(1, 'admin', '$2y$10$WUXmfWOTO3gf.QIwxuHH0ecG51cmEsgW5YmHbQaAHcYL6wV11GgOm', 'admin'),
(2, 'test', '$2y$10$rwE2jgPjPrw1i8DBi5xgY.aZuqV..6w9ZEFQmiYAy1G3slnJpKFVy', 'user'),
(3, 'test2', '$2y$10$CWdR4CMwVmeTY4imSDiU2.Gj16M85FC1sDhzHRxjh0SUDGJ6cbD2G', 'user');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cid`);

--
-- Index pour la table `evenements`
--
ALTER TABLE `evenements`
  ADD PRIMARY KEY (`eid`),
  ADD KEY `cid` (`cid`);

--
-- Index pour la table `identifications`
--
ALTER TABLE `identifications`
  ADD PRIMARY KEY (`pid`,`tid`),
  ADD KEY `tid` (`tid`);

--
-- Index pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD PRIMARY KEY (`pid`,`eid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `eid` (`eid`);

--
-- Index pour la table `itypes`
--
ALTER TABLE `itypes`
  ADD PRIMARY KEY (`tid`);

--
-- Index pour la table `participations`
--
ALTER TABLE `participations`
  ADD PRIMARY KEY (`ptid`),
  ADD KEY `eid` (`eid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `uid` (`uid`);

--
-- Index pour la table `personnes`
--
ALTER TABLE `personnes`
  ADD PRIMARY KEY (`pid`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `evenements`
--
ALTER TABLE `evenements`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `itypes`
--
ALTER TABLE `itypes`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `participations`
--
ALTER TABLE `participations`
  MODIFY `ptid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT pour la table `personnes`
--
ALTER TABLE `personnes`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `evenements`
--
ALTER TABLE `evenements`
  ADD CONSTRAINT `evenements_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `identifications`
--
ALTER TABLE `identifications`
  ADD CONSTRAINT `identifications_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `itypes` (`tid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `identifications_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `personnes` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD CONSTRAINT `inscriptions_ibfk_1` FOREIGN KEY (`eid`) REFERENCES `evenements` (`eid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscriptions_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `personnes` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscriptions_ibfk_3` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `participations`
--
ALTER TABLE `participations`
  ADD CONSTRAINT `participations_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participations_ibfk_2` FOREIGN KEY (`eid`) REFERENCES `evenements` (`eid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participations_ibfk_3` FOREIGN KEY (`pid`) REFERENCES `personnes` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
