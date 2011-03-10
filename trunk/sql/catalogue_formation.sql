-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Jeu 10 Mars 2011 à 14:16
-- Version du serveur: 5.5.8
-- Version de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `catalogue_formation`
--

-- --------------------------------------------------------

--
-- Structure de la table `contenu_devis`
--

CREATE TABLE IF NOT EXISTS `contenu_devis` (
  `ID_CONTENU_DEVIS` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ID_DEVIS` int(11) unsigned NOT NULL,
  `ID_FORMATION` int(11) unsigned NOT NULL,
  `NOMBRE_PARTICIPANT` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID_CONTENU_DEVIS`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `contenu_devis`
--


-- --------------------------------------------------------

--
-- Structure de la table `contenu_panier`
--

CREATE TABLE IF NOT EXISTS `contenu_panier` (
  `ID_CONTENU_PANIER` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ID_PANIER` int(111) unsigned NOT NULL,
  `ID_DEVIS` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID_CONTENU_PANIER`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `contenu_panier`
--


-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

CREATE TABLE IF NOT EXISTS `devis` (
  `ID_DEVIS` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ID_UTILISATEUR` int(11) unsigned NOT NULL,
  `DATE_DEVIS` int(11) unsigned NOT NULL,
  `VALIDEE` tinyint(1) unsigned NOT NULL,
  `PRIX` int(10) unsigned NOT NULL DEFAULT '0',
  `COMMENTAIRE` text,
  PRIMARY KEY (`ID_DEVIS`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Contenu de la table `devis`
--


-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

CREATE TABLE IF NOT EXISTS `formation` (
  `ID_FORMATION` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `NOM` varchar(255) NOT NULL,
  `OBJECTIF` text NOT NULL,
  `PROGRAMME` text NOT NULL,
  `INTERVENANT` int(11) unsigned NOT NULL,
  `PREREQUIS` text NOT NULL,
  `DUREE` varchar(255) NOT NULL,
  `LIEU` varchar(255) NOT NULL,
  `NIVCOMP` smallint(2) unsigned NOT NULL,
  `THEME` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID_FORMATION`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Contenu de la table `formation`
--


-- --------------------------------------------------------

--
-- Structure de la table `inscription_formation`
--

CREATE TABLE IF NOT EXISTS `inscription_formation` (
  `ID_INS_FORMA` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ID_FORMATION` int(11) unsigned NOT NULL,
  `ID_UTILISATEUR` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID_INS_FORMA`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `inscription_formation`
--


-- --------------------------------------------------------

--
-- Structure de la table `intervenant`
--

CREATE TABLE IF NOT EXISTS `intervenant` (
  `ID_INTERVENANT` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `NOM` varchar(255) NOT NULL,
  `PRENOM` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `METIER` varchar(255) NOT NULL,
  `ETABLISSEMENT` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_INTERVENANT`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Contenu de la table `intervenant`
--


-- --------------------------------------------------------

--
-- Structure de la table `nivcomp`
--

CREATE TABLE IF NOT EXISTS `nivcomp` (
  `ID_NIVCOMP` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `NOM` varchar(20) NOT NULL,
  PRIMARY KEY (`ID_NIVCOMP`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Contenu de la table `nivcomp`
--

INSERT INTO `nivcomp` (`ID_NIVCOMP`, `NOM`) VALUES
(1, 'Généraliste'),
(2, 'Pratique'),
(3, 'Scientifique');

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE IF NOT EXISTS `panier` (
  `ID_PANIER` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ID_UTILISATEUR` int(11) unsigned NOT NULL,
  `PRIX` int(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID_PANIER`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `panier`
--


-- --------------------------------------------------------

--
-- Structure de la table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `ID_SESSION` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `DATE_DEBUT` varchar(255) NOT NULL,
  `DATE_FIN` varchar(255) NOT NULL,
  `FORMATION` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID_SESSION`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Contenu de la table `session`
--


-- --------------------------------------------------------

--
-- Structure de la table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `ID_STATUS` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `NOM` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_STATUS`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Contenu de la table `status`
--

INSERT INTO `status` (`ID_STATUS`, `NOM`) VALUES
(1, 'Salarié'),
(2, 'Responsable Formation'),
(3, 'Etudiant'),
(4, 'Demandeur d''Emploi');

-- --------------------------------------------------------

--
-- Structure de la table `tarif`
--

CREATE TABLE IF NOT EXISTS `tarif` (
  `ID_TARIF` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `NIVCOMP` int(11) unsigned NOT NULL,
  `STATUS` int(11) unsigned NOT NULL,
  `PRIX` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID_TARIF`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tarif`
--


-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

CREATE TABLE IF NOT EXISTS `theme` (
  `ID_THEME` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `NOM` varchar(255) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  PRIMARY KEY (`ID_THEME`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Contenu de la table `theme`
--


-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `ID_UTILISATEUR` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `NOM` varchar(255) NOT NULL,
  `PRENOM` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `MOTDEPASSE` varchar(255) NOT NULL,
  `STATUS` int(11) unsigned NOT NULL,
  `ENTREPRISE` tinyint(1) NOT NULL,
  `NOM_ENTREPRISE` varchar(255) DEFAULT NULL,
  `CONTACT_ENTREPRISE` varchar(255) DEFAULT NULL,
  `TEL_CONTACT_ENT` varchar(20) DEFAULT NULL,
  `MAIL_CONTACT_ENT` varchar(255) DEFAULT NULL,
  `DATEINSCRIPT` int(11) unsigned NOT NULL,
  `NIVEAU` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID_UTILISATEUR`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ID_UTILISATEUR`, `NOM`, `PRENOM`, `EMAIL`, `MOTDEPASSE`, `STATUS`, `ENTREPRISE`, `NOM_ENTREPRISE`, `CONTACT_ENTREPRISE`, `TEL_CONTACT_ENT`, `MAIL_CONTACT_ENT`, `DATEINSCRIPT`, `NIVEAU`) VALUES
(1, 'admin', 'Admin', 'admin@admin.fr', 'd033e22ae348aeb5660fc2140aec35850c4da997', 4, 0, NULL, NULL, NULL, NULL, 1299644116, 100),
(2, 'user', 'user', 'user@user.fr', '12dea96fec20593566ab75692c9949596833adc9', 2, 1, 'Magret Tech', 'User Man', '+33 6 64 64 64 64', 'user@magret.tech', 1299644238, 1);

-- --------------------------------------------------------

--
-- Structure de la table `visites`
--

CREATE TABLE IF NOT EXISTS `visites` (
  `ID_PAGE` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `NOM_PAGE` varchar(255) NOT NULL,
  `VISITES` int(50) unsigned NOT NULL,
  PRIMARY KEY (`ID_PAGE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `visites`
--

