-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Sam 05 Mars 2011 à 16:10
-- Version du serveur: 5.1.53
-- Version de PHP: 5.3.4

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
  `ID_CONTENU_DEVIS` int(11) unsigned NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `DATE_DEVIS` date NOT NULL,
  PRIMARY KEY (`ID_DEVIS`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `panier`
--


-- --------------------------------------------------------

--
-- Structure de la table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `ID_SESSION` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `DATE_DEBUT` date NOT NULL,
  `DATE_FIN` date NOT NULL,
  `FORMATION` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ID_SESSION`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `status`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `DESC` text NOT NULL,
  PRIMARY KEY (`ID_THEME`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `STATUS` int(11) unsigned NOT NULL,
  `DATEINSCRIPT` date NOT NULL,
  `NIVEAU` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID_UTILISATEUR`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `utilisateur`
--


-- --------------------------------------------------------

--
-- Structure de la table `visites`
--

CREATE TABLE IF NOT EXISTS `visites` (
  `ID_PAGE` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `NOM_PAGE` varchar(255) NOT NULL,
  `VISITES` int(50) unsigned NOT NULL,
  PRIMARY KEY (`ID_PAGE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `visites`
--

