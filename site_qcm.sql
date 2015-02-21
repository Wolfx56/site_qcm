-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Sam 21 Février 2015 à 17:56
-- Version du serveur :  5.6.20-log
-- Version de PHP :  5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `site_qcm`
--

-- --------------------------------------------------------

--
-- Structure de la table `identifiant`
--

CREATE TABLE IF NOT EXISTS `identifiant` (
`ID` int(11) NOT NULL,
  `Login` varchar(30) NOT NULL,
  `Prenom` varchar(30) NOT NULL,
  `Nom` varchar(30) NOT NULL,
  `Statut` varchar(30) NOT NULL,
  `Admin` tinyint(1) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `identifiant`
--

INSERT INTO `identifiant` (`ID`, `Login`, `Prenom`, `Nom`, `Statut`, `Admin`) VALUES
(1, 'fauchery01', 'Hugo', 'Fauchery', 'Etudiant', 1),
(8, 'bourrat02', 'Florent', 'Bourrat', 'Etudiant', 1);

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
`Num_q` int(11) NOT NULL,
  `Id` int(11) NOT NULL,
  `Intitule` text NOT NULL,
  `Type` tinyint(1) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Contenu de la table `question`
--

INSERT INTO `question` (`Num_q`, `Id`, `Intitule`, `Type`) VALUES
(45, 30, 'Oui', 2),
(44, 29, 'Quel age avez vous ?', 1),
(43, 29, 'Combien avons nous de doigts ?', 1),
(42, 29, 'Quel est le chiffre de la Vie ?', 1);

-- --------------------------------------------------------

--
-- Structure de la table `questionnaire`
--

CREATE TABLE IF NOT EXISTS `questionnaire` (
`Id` int(11) NOT NULL,
  `Titre` text NOT NULL,
  `Login` varchar(30) NOT NULL,
  `Code` varchar(50) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Contenu de la table `questionnaire`
--

INSERT INTO `questionnaire` (`Id`, `Titre`, `Login`, `Code`) VALUES
(30, 'Qcm comme ca', 'bourrat02', 'ce36d7d9838d38f514b7ae1cc5adcd62'),
(29, 'Test a la con', 'bourrat02', '491827d274f22fe8e75e3013ea8f30ff');

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE IF NOT EXISTS `reponse` (
`Id` int(11) NOT NULL,
  `Num_q` int(11) NOT NULL,
  `Intitule_r` text NOT NULL,
  `Juste` tinyint(1) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Contenu de la table `reponse`
--

INSERT INTO `reponse` (`Id`, `Num_q`, `Intitule_r`, `Juste`) VALUES
(45, 44, 'entre 15 et 30', 1),
(44, 44, '-15', 0),
(43, 43, '20', 0),
(42, 43, '10', 1),
(41, 43, '5', 0),
(40, 42, 'La réponse D', 0),
(39, 42, '42', 1),
(38, 42, '45', 0),
(37, 42, '35', 0),
(46, 44, 'Plus de 30', 0),
(47, 45, 'ouiii', 1),
(48, 45, 'Ouuiiiiiii', 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `identifiant`
--
ALTER TABLE `identifiant`
 ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `question`
--
ALTER TABLE `question`
 ADD PRIMARY KEY (`Num_q`), ADD KEY `Id` (`Id`);

--
-- Index pour la table `questionnaire`
--
ALTER TABLE `questionnaire`
 ADD PRIMARY KEY (`Id`), ADD KEY `Login` (`Login`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
 ADD PRIMARY KEY (`Id`), ADD KEY `Num_q` (`Num_q`), ADD KEY `Num_q_2` (`Num_q`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `identifiant`
--
ALTER TABLE `identifiant`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
MODIFY `Num_q` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT pour la table `questionnaire`
--
ALTER TABLE `questionnaire`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
