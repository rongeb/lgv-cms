-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Hôte : db5000296361.hosting-data.io
-- Généré le : ven. 17 avr. 2020 à 20:02
-- Version du serveur :  5.7.28-log
-- Version de PHP : 7.0.33-0+deb9u7

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dbs289593`
--
DROP DATABASE IF EXISTS `lgvdata`;
CREATE DATABASE IF NOT EXISTS `lgvdata` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `lgvdata`;

-- --------------------------------------------------------

--
-- Structure de la table `backofficeaccess`
--

DROP TABLE IF EXISTS `backofficeaccess`;
CREATE TABLE IF NOT EXISTS `backofficeaccess` (
  `id_access` int(11) NOT NULL AUTO_INCREMENT,
  `user_access` varchar(128) COLLATE utf8_bin NOT NULL,
  `pwd_access` varchar(512) COLLATE utf8_bin NOT NULL,
  `role_access` enum('anonymous','user','admin','') COLLATE utf8_bin NOT NULL,
  `csrf_access` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `honeypot_access` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id_access`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `backofficeaccess`
--

INSERT INTO `backofficeaccess` (`id_access`, `user_access`, `pwd_access`, `role_access`, `csrf_access`, `honeypot_access`) VALUES
(1, 'cmjaffre', '21666517e386bd23e5edc7fbe3ef3277cedd1f3bf120cac4e3c20ef1105ff348cd9fcbb231e9189fbc3dab52a80655e74603c6a038be3cb2749c1ec57034ac1c', 'admin', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `commentaire_id` int(11) NOT NULL AUTO_INCREMENT,
  `commentaire_msg` text COLLATE utf8_bin,
  `commentaire_row1` varchar(256) COLLATE utf8_bin DEFAULT '',
  `commentaire_row2` varchar(256) COLLATE utf8_bin DEFAULT '',
  `commentaire_row3` varchar(256) COLLATE utf8_bin DEFAULT '',
  `commentaire_row4` varchar(256) COLLATE utf8_bin DEFAULT '',
  `commentaire_position` int(11) DEFAULT '0',
  `commentaire_type` varchar(128) COLLATE utf8_bin DEFAULT '',
  `commentaire_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `commentaire_status` tinyint(4) NOT NULL,
  `commentaire_contenuid` int(11) NOT NULL,
  PRIMARY KEY (`commentaire_id`),
  KEY `commentaire_contenuid` (`commentaire_contenuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Structure de la table `contenu`
--

DROP TABLE IF EXISTS `contenu`;
CREATE TABLE IF NOT EXISTS `contenu` (
  `contenu_id` int(11) NOT NULL AUTO_INCREMENT,
  `rang` int(11) DEFAULT '-1',
  `titre` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `soustitre` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `sousrubriques_id` int(11) NOT NULL,
  `contenuhtml` text COLLATE utf8_bin,
  `image` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `image2` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `type` enum('content','gallery','blog','mapcontent') COLLATE utf8_bin DEFAULT NULL,
  `author` varchar(256) COLLATE utf8_bin DEFAULT '',
  `themes` varchar(256) COLLATE utf8_bin DEFAULT '',
  `contenu_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `othertext1` varchar(256) COLLATE utf8_bin DEFAULT '',
  `othertext2` varchar(256) COLLATE utf8_bin DEFAULT '',
  `othertext3` varchar(256) COLLATE utf8_bin DEFAULT '',
  `sousrubriques_preview` int(11) NOT NULL DEFAULT '0',
  `contenu_rank_preview` int(11) NOT NULL DEFAULT '0',
  `gps_coordinates` json DEFAULT NULL,
  PRIMARY KEY (`contenu_id`),
  KEY `sousrubriques_id` (`sousrubriques_id`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `contenu`
--

INSERT INTO `contenu` (`contenu_id`, `rang`, `titre`, `soustitre`, `sousrubriques_id`, `contenuhtml`, `image`, `image2`, `type`, `author`, `themes`, `contenu_date`, `othertext1`, `othertext2`, `othertext3`, `sousrubriques_preview`, `contenu_rank_preview`, `gps_coordinates`) VALUES
(129, 1, 'Image 1', 'Image', 54, '<div class=\"slide-bg-image overlay-light parallax parallax-section1\" data-background-img=\"/public/filesbank/20191107_165058_dxo.jpg\">\r\n<div class=\"js-Slide-fullscreen-height container\">\r\n<div class=\"intro-content\">\r\n<div class=\"intro-content-inner\">\r\n<h2 class=\"h2\">Bienvenue dans le Beaujolais</h2>\r\n<p class=\"lead\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '/domainedesvieuxcelliers/public/filesbank/cool-meeting.jpg', '/domainedesvieuxcelliers/public/filesbank/cool-meeting.jpg', 'gallery', '', '', '2020-04-08 16:28:43', '', '', '', 0, 0, NULL),
(130, 2, 'Image 2', '', 54, '<div class=\"slide-bg-image overlay-light parallax parallax-section1\" data-background-img=\"/public/filesbank/domaine_piscine_transat2.jpg\">\r\n<div class=\"js-Slide-fullscreen-height container\">\r\n<div class=\"intro-content\">\r\n<div class=\"intro-content-inner\">\r\n<h2 class=\"h2\">D&eacute;tente</h2>\r\n<p class=\"lead\">Profitez de la piscine</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '/domainedesvieuxcelliers/public/filesbank/creative-creativity-design-700px.jpg', '', 'gallery', '', '', '2020-04-08 16:29:39', '', '', '', 0, 0, NULL),
(131, 3, 'Image 3', '', 54, '<div class=\"slide-bg-image overlay-light parallax parallax-section1\" data-background-img=\"/public/filesbank/terasse_piscine.jpg\">\r\n<div class=\"js-Slide-fullscreen-height container\">\r\n<div class=\"intro-content\">\r\n<div class=\"intro-content-inner\">\r\n<h2 class=\"h2\">Domaine du vieux cellier</h2>\r\n<p class=\"lead\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '/domainedesvieuxcelliers/public/filesbank/idea-2123972_1280.jpg', '', 'gallery', '', '', '2020-04-08 16:30:05', '', '', '', 0, 0, NULL),
(134, 3, 'Vue drone', '', 55, '<div class=\"nf-item exterieur\">\r\n<div class=\"item-box\">\r\n<div style=\"cursor: pointer;\" class=\"cbox-gallary1\" href=\"../../filesbank/img-20170702-wa0003.jpg\" title=\"vue drone\"><img class=\"item-container\" src=\"../../filesbank/img-20170702-wa0003.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Vue du domaine du ciel</h5>\r\n<p class=\"white\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '', '', 'gallery', '', '', '2020-02-10 20:29:07', '', '', '', 0, 0, NULL),
(135, 2, 'FaÃ§ade cÃ´tÃ© cour', '', 55, '<div class=\"nf-item exterieur\">\r\n<div class=\"item-box\">\r\n<div class=\"cbox-gallary1\" style=\"cursor: pointer;\" href=\"../../filesbank/maison_garanche_suite_001_dxo.jpg\" title=\"fa&ccedil;ade domaine\"><img class=\"item-container\" src=\"../../filesbank/maison_garanche_suite_001_dxo.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Fa&ccedil;ade c&ocirc;t&eacute; cour</h5>\r\n<p class=\"white\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '', '', 'gallery', '', '', '2020-02-10 20:27:37', '', '', '', 0, 0, NULL),
(137, 1, 'Preloader', '', 61, '<section id=\"preloader\">\r\n<div class=\"loader\" id=\"loader\">\r\n<div class=\"loader-img\"></div>\r\n</div>\r\n</section>', NULL, NULL, 'content', '', '', '2019-11-05 18:56:11', '', '', '', 0, 0, NULL),
(138, 2, 'Menu Desktop', '', 53, '<!-- Header (\"header--dark\", \"header-transparent\", \"header--sticky\")--><header id=\"header\" class=\"header header-transparent header--sticky sticky--on\"><!-- Nav Bar --><nav id=\"navigation\" class=\"header-nav\">\r\n<div class=\"container\">\r\n<div class=\"row d-flex flex-md-row align-items-center\">\r\n<div class=\"nav-menu ml-auto singlepage-nav\">\r\n<ul class=\"\">\r\n<li class=\"nav-menu-item\" style=\"text-align: center;\"><a href=\"#intro\">Accueil</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#about\">A propos</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#work\">Photos</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#social\">R&eacute;server</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#contact-section\">Contact</a></li>\r\n</ul>\r\n</div>\r\n<div class=\"nav-icons\">\r\n<div class=\"nav-icon-item d-lg-none\"><span class=\"nav-icon-trigger menu-mobile-btn align-middle\"><i class=\"ion\"></i></span></div>\r\n</div>\r\n</div>\r\n</div>\r\n</nav><!-- End Nav Bar --></header><!-- End Header -->', NULL, NULL, 'content', '', '', '2020-02-17 20:05:31', '', '', '', 0, 0, NULL),
(139, -1, 'Menu Mobile', '', 53, '<p></p>\r\n<!-- Header (\"header--dark\", \"header-transparent\", \"header--sticky\")--><header id=\"header\" class=\"header header-transparent header--sticky sticky--on\"><!-- Nav Bar --><nav id=\"navigation\" class=\"header-nav\">\r\n<div class=\"container\">\r\n<div class=\"row d-flex flex-md-row align-items-center\">\r\n<div class=\"logo mr-auto\"><!--logo--> <a href=\"index.html\"> <img class=\"logo-dark\" src=\"img/logo-black.png\" alt=\"Mazel\" /> <img class=\"logo-light\" src=\"img/logo-white.png\" alt=\"Mazel\" /> </a> <!--End logo--></div>\r\n<div class=\"nav-menu ml-auto singlepage-nav\">\r\n<ul class=\"\">\r\n<li class=\"nav-menu-item\"><a href=\"#intro\">Home</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#about\">About</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#work\">Work</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#service\">Service</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#blog\">News</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#pricing\">Pricing</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#contact-section\">Contact</a></li>\r\n</ul>\r\n</div>\r\n<div class=\"nav-icons\">\r\n<div class=\"nav-icon-item d-lg-none\"><span class=\"nav-icon-trigger menu-mobile-btn align-middle\"><i class=\"ion\"></i></span></div>\r\n<div class=\"nav-icon-item\"><span class=\"nav-icon-trigger sidebar-menu_btn align-middle\"><i class=\"ion ion-navicon\"></i></span></div>\r\n</div>\r\n</div>\r\n</div>\r\n</nav><!-- End Nav Bar --></header><!-- End Header -->', NULL, NULL, 'content', '', '', '2020-02-02 21:16:50', '', '', '', 0, 0, NULL),
(140, 1, 'Le domaine du vieux cellier', 'Pr&eacute;sentation', 60, '<p></p>\r\n<!--About Section-->\r\n<section id=\"about\" class=\"wow fadeIn ptb ptb-sm-80\">\r\n<div class=\"container\">\r\n<div class=\"row text-center\">\r\n<div class=\"col-md-8 offset-md-2\">\r\n<h3 class=\"h4\">Domaine du vieux cellier</h3>\r\n<div class=\"spacer-15\"></div>\r\n<p class=\"lead\">Marielle et Christian vous accueillent au sein du domaine du vieux cellier.<br /><br />Ils seront heureux de vous accueillir et de vous faire d&eacute;couvir leurs vins :<br />Brouilly, Coteaux Bourguignons, Bourgogne, Bourgogne aligot&eacute;, Beaujolais ros&eacute;.<br /><br />Cette demeure de charme au milieu des vignes du Beaujolais vous offrira des moments agr&eacute;ables en famille ou entre amis (jusqu\'&agrave; 12 personnes).<br />Situ&eacute; &agrave; proximit&eacute; du mont Brouilly, le domaine est id&eacute;alement situ&eacute; pour visiter les villages et paysages du Beaujolais. Lyon est facilement accessible &agrave; partir du domaine via l\'autoroute A6.</p>\r\n</div>\r\n</div>\r\n</div>\r\n</section>\r\n<!-- End About Section--><hr />', '', '', 'gallery', '', '', '2020-02-17 20:02:54', '', '', '', 0, 0, NULL),
(154, 1, 'Fiche de contact', '', 59, '<section id=\"contact-section\" class=\"ptb ptb-sm-80\">\r\n<div class=\"container\">\r\n<div class=\"row\">\r\n<div class=\"col-md-4\">\r\n<div class=\"contact-box-left\">\r\n<div class=\"contact-icon-left\"><i class=\"ion ion-ios-location\"></i></div>\r\n<h6>Adresse</h6>\r\n<p>313 route de Saint Pierre</p>\r\n<p>Garanche</p>\r\n<p>69220 Charentay</p>\r\n</div>\r\n</div>\r\n<div class=\"col-md-4\">\r\n<div class=\"contact-box-left\">\r\n<div class=\"contact-icon-left\"><i class=\"ion ion-ios-telephone\"></i></div>\r\n<h6>Num&eacute;ro de t&eacute;l&eacute;phone</h6>\r\n<p><span>+33 (0) 6 07 99 77 82</span></p>\r\n</div>\r\n</div>\r\n<div class=\"col-md-4\">\r\n<div class=\"contact-box-left\">\r\n<div class=\"contact-icon-left\"><i class=\"ion ion-ios-email\"></i></div>\r\n<h6>Email</h6>\r\n<p><a href=\"mailto:christianjaffrevins@bbox.fr\">christianjaffrevins@bbox.fr</a></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>', NULL, NULL, 'content', '', '', '2020-02-17 19:55:49', '', '', '', 0, 0, NULL),
(155, 1, 'Filtres portfolio', '', 55, '<div class=\"container\">\r\n<h3>Galerie d\'images</h3>\r\n<div class=\"spacer-60\"></div>\r\n<!-- work Filter -->\r\n<div class=\"row\">\r\n<ul class=\"col container-filter categories-filter mb-0\">\r\n<li><a class=\"categories active\" data-filter=\"*\">Toutes les images</a></li>\r\n<li><a class=\"categories\" data-filter=\".interieur\">Int&eacute;rieur</a></li>\r\n<li><a class=\"categories\" data-filter=\".exterieur\">Ext&eacute;rieur</a></li>\r\n<li><a class=\"categories\" data-filter=\".vins\">Vins</a></li>\r\n<li><a class=\"categories\" data-filter=\".vigne\">Vignes</a></li>\r\n</ul>\r\n</div>\r\n<!-- End work Filter --></div>', NULL, NULL, 'content', '', '', '2020-02-17 20:51:17', '', '', '', 0, 0, NULL),
(156, 4, 'Cuisine', '', 55, '<div class=\"nf-item interieur\">\r\n<div class=\"item-box\">\r\n<div style=\"cursor: pointer;\" class=\"cbox-gallary1\" href=\"../../filesbank/photos_maisons_rbnb_017_dxo.jpg\" title=\"cuisine\"><img class=\"item-container\" src=\"../../filesbank/photos_maisons_rbnb_017_dxo.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Cuisine</h5>\r\n<p class=\"white\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '', '', 'gallery', '', '', '2020-02-10 20:44:46', '', '', '', 0, 0, NULL),
(157, 5, 'Cuisine 2', '', 55, '<div class=\"nf-item interieur\">\r\n<div class=\"item-box\">\r\n<div style=\"cursor: pointer;\" class=\"cbox-gallary1\" href=\"../../filesbank/photos_maisons_rbnb_012_dxo.jpg\" title=\"Plan de travail\"><img class=\"item-container\" src=\"../../filesbank/photos_maisons_rbnb_012_dxo.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Plan de travail de la cuisine</h5>\r\n<p class=\"white\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '', '', 'gallery', '', '', '2020-02-10 20:45:11', '', '', '', 0, 0, NULL),
(158, 10, 'Salon cheminÃ©e', '', 55, '<div class=\"nf-item interieur\">\r\n<div class=\"item-box\">\r\n<div style=\"cursor: pointer;\" class=\"cbox-gallary1\" href=\"../../filesbank/photos_maisons_rbnb_001_dxo_dxo.jpg\"><img class=\"item-container\" src=\"../../filesbank/photos_maisons_rbnb_001_dxo_dxo.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Chemin&eacute;e du salon</h5>\r\n<p class=\"white\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '', '', 'gallery', '', '', '2020-02-10 20:54:36', '', '', '', 0, 0, NULL),
(159, 6, 'Salon buffet', '', 55, '<div class=\"nf-item interieur\">\r\n<div class=\"item-box\">\r\n<div style=\"cursor: pointer;\" class=\"cbox-gallary1\" href=\"../../filesbank/photos_maisons_rbnb_008_dxo.jpg\" title=\"Buffet\"><img class=\"item-container\" src=\"../../filesbank/photos_maisons_rbnb_008_dxo.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Salon - buffet</h5>\r\n<p class=\"white\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '', '', 'gallery', '', '', '2020-02-10 20:45:55', '', '', '', 0, 0, NULL),
(160, 9, 'Salon cÃ´tÃ© cuisine', '', 55, '<div class=\"nf-item interieur\">\r\n<div class=\"item-box\">\r\n<div style=\"cursor: pointer;\" class=\"cbox-gallary1\" href=\"../../filesbank/photos_maisons_rbnb_011_dxo.jpg\" title=\"salon c&ocirc;t&eacute; cuisine\"><img class=\"item-container\" src=\"../../filesbank/photos_maisons_rbnb_011_dxo.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Salon c&ocirc;t&eacute; cuisine</h5>\r\n<p class=\"white\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '', '', 'gallery', '', '', '2020-02-10 20:52:55', '', '', '', 0, 0, NULL),
(161, 8, 'Chambre', '', 55, '<div class=\"nf-item interieur\">\r\n<div class=\"item-box\">\r\n<div style=\"cursor: pointer;\" class=\"cbox-gallary1\" href=\"../../filesbank/3188eafe-222a-439a-8dc9-ea1a326835dc_dxo.jpg\" title=\"Chambre 1\"><img class=\"item-container\" src=\"../../filesbank/3188eafe-222a-439a-8dc9-ea1a326835dc_dxo.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Chambre</h5>\r\n<p class=\"white\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '', '', 'gallery', '', '', '2020-02-10 20:51:01', '', '', '', 0, 0, NULL),
(162, 7, 'Foyer', '', 55, '<div class=\"nf-item interieur\">\r\n<div class=\"item-box\">\r\n<div style=\"cursor: pointer;\" class=\"cbox-gallary1\" href=\"../../filesbank/photos_maisons_rbnb_042.jpg\" title=\"Foyer\"><img class=\"item-container\" src=\"../../filesbank/photos_maisons_rbnb_042.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Foyer</h5>\r\n<p class=\"white\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '', '', 'gallery', '', '', '2020-02-10 20:49:49', '', '', '', 0, 0, NULL),
(163, 11, 'Vendange', '', 55, '<div class=\"nf-item vigne\">\r\n<div class=\"item-box\">\r\n<div style=\"cursor: pointer;\" class=\"cbox-gallary1\" href=\"../../filesbank/img-20200112-wa0002_portfolio.jpg\" title=\"Vendanges\"><img class=\"item-container\" src=\"../../filesbank/img-20200112-wa0002_portfolio.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Vendanges</h5>\r\n<p class=\"white\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '', '', 'gallery', '', '', '2020-02-10 20:55:57', '', '', '', 0, 0, NULL),
(164, 12, 'Vendangeur', '', 55, '<div class=\"nf-item vigne\">\r\n<div class=\"item-box\">\r\n<div style=\"cursor: pointer;\" class=\"cbox-gallary1\" href=\"../../filesbank/img-20200112-wa0004_portfolio.jpg\" title=\"Vendangeurs\"><img class=\"item-container\" src=\"../../filesbank/img-20200112-wa0004_portfolio.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Equipe de vendangeurs</h5>\r\n<p class=\"white\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '', '', 'gallery', '', '', '2020-02-10 20:56:46', '', '', '', 0, 0, NULL),
(165, 13, 'Vigne en automne', '', 55, '<div class=\"nf-item vigne\">\r\n<div class=\"item-box\">\r\n<div style=\"cursor: pointer;\" class=\"cbox-gallary1\" href=\"../../filesbank/20191107_165112_portfolio.jpg\" title=\"Vignes en automne\"><img class=\"item-container\" src=\"../../filesbank/20191107_165112_portfolio.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Vignes en automne</h5>\r\n<p class=\"white\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '', '', 'gallery', '', '', '2020-02-10 20:57:46', '', '', '', 0, 0, NULL),
(166, 14, 'transat portfolio', '', 55, '<div class=\"nf-item exterieur\">\r\n<div class=\"item-box\">\r\n<div style=\"cursor: pointer;\" class=\"cbox-gallary1\" href=\"../../filesbank/domaine_piscine_transat_portfolio.jpg\"><img class=\"item-container\" src=\"../../filesbank/domaine_piscine_transat_portfolio.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Transats devant la piscine du domaine</h5>\r\n<p class=\"white\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '', '', 'gallery', '', '', '2020-02-10 21:05:28', '', '', '', 0, 0, NULL),
(167, 15, 'terasse portfolio', '', 55, '<div class=\"nf-item exterieur\">\r\n<div class=\"item-box\">\r\n<div style=\"cursor: pointer;\" class=\"cbox-gallary1\" href=\"../../filesbank/terasse_piscine_portfolio.jpg\" title=\"terrasse et piscine\"><img class=\"item-container\" src=\"../../filesbank/terasse_piscine_portfolio.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Terrasse et piscine du domaine</h5>\r\n<p class=\"white\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '', '', 'gallery', '', '', '2020-02-10 21:02:45', '', '', '', 0, 0, NULL),
(168, 1, 'map GPS', '', 63, '<!-- Map Section -->\r\n<section class=\"map\">\r\n<div id=\"map\"></div>\r\n</section>\r\n<!-- Map Section -->', NULL, NULL, 'content', '', '', '2020-02-09 22:21:47', '', '', '', 0, 0, NULL),
(169, 1, 'Air bnb', '', 64, '<!-- Social Section -->\r\n<section id=\"social\" class=\"gray-bg ptb ptb-sm-80\">\r\n<div class=\"container text-center\">\r\n<div class=\"row\">\r\n<div class=\"col-md-8 offset-md-2\">\r\n<h3>Retrouvez le domaine sur</h3>\r\n</div>\r\n</div>\r\n<div class=\"spacer-60\"></div>\r\n<div class=\"row\">\r\n<div class=\"col-12\">\r\n<div class=\"page-icon-top\"><img class=\"dvc-airbnb-img img-fluid\" src=\"../../filesbank/favpng_airbnb-logo-business-organization_9uz1ph0x.png\" /></div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>\r\n<!-- End Social Section -->', NULL, NULL, 'content', '', '', '2020-02-10 21:11:11', '', '', '', 0, 0, NULL),
(170, 16, 'Brouilly', '', 55, '<div class=\"nf-item vins\">\r\n<div class=\"item-box\">\r\n<div style=\"cursor: pointer;\" class=\"cbox-gallary1\" href=\"../../filesbank/brouilly-x1.jpg\" title=\"Vin rouge Brouilly domaine du vieux cellier\"><img class=\"item-container\" src=\"../../filesbank/brouilly-x1.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Brouilly</h5>\r\n<p class=\"white\">6&euro; ttc/la bouteille</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '', '', 'gallery', '', '', '2020-02-20 21:19:48', '', '', '', 0, 0, NULL),
(171, 17, 'Bougogne aligoté', '', 55, '<div class=\"nf-item vins\">\r\n<div class=\"item-box\">\r\n<div style=\"cursor: pointer;\" class=\"cbox-gallary1\" href=\"../../filesbank/aligote-x1.jpg\" title=\"Vin blanc Bourgogne aligot&eacute; domaine du vieux cellier\"><img class=\"item-container\" src=\"../../filesbank/aligote-x1.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Bourgogne aligot&eacute;</h5>\r\n<p class=\"white\">5&euro; ttc/la bouteille</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '', '', 'gallery', '', '', '2020-02-20 21:18:50', '', '', '', 0, 0, NULL),
(172, 1, 'Mentions légales', '', 65, '<!-- The Modal -->\r\n<div id=\"mentionsLegalesModal\" class=\"dvc-modal\"><!-- Modal content -->\r\n<div class=\"dvc-modal-content\"><span class=\"dvc-close\">&times;</span>\r\n<p>Mentions l&eacute;gales</p>\r\n<br />\r\n<p>D&eacute;finitions</p>\r\n<p><strong>Client</strong>&nbsp;:&nbsp;tout professionnel ou personne physique capable au sens des articles 1123 et suivants du Code civil, ou personne morale, qui visite le Site objet des pr&eacute;sentes conditions g&eacute;n&eacute;rales. <br /><strong>Prestations et Services</strong>&nbsp;: https://romgeb.fr/domaineduvieuxcellier/public/sitepublic/displaypublicpage/index met &agrave; disposition des Clients.<br /><strong>Contenu</strong>&nbsp;:&nbsp;Ensemble des &eacute;l&eacute;ments constituants l&rsquo;information pr&eacute;sente sur le Site, notamment textes &ndash; images &ndash; vid&eacute;os. Informations clients&nbsp;: Ci apr&egrave;s d&eacute;nomm&eacute; &laquo;&nbsp;Information (s)&nbsp;&raquo; qui correspondent &agrave; l&rsquo;ensemble des donn&eacute;es personnelles susceptibles d&rsquo;&ecirc;tre d&eacute;tenues par https://romgeb.fr/domaineduvieuxcellier/public/sitepublic/displaypublicpage/index pour la gestion de votre compte, de la gestion de la relation client et &agrave; des fins d&rsquo;analyses et de statistiques.<br /><strong>Utilisateur</strong> : Internaute se connectant, utilisant le site susnomm&eacute;.<br /><strong>Informations personnelles</strong> : &laquo; Les informations qui permettent, sous quelque forme que ce soit, directement ou non, l\'identification des personnes physiques auxquelles elles s\'appliquent &raquo; (article 4 de la loi n&deg; 78-17 du 6 janvier 1978). Les termes &laquo;&nbsp;donn&eacute;es &agrave; caract&egrave;re personnel&nbsp;&raquo;, &laquo;&nbsp;personne concern&eacute;e&nbsp;&raquo;, &laquo;&nbsp;sous traitant&nbsp;&raquo; et &laquo;&nbsp;donn&eacute;es sensibles&nbsp;&raquo; ont le sens d&eacute;fini par le R&egrave;glement G&eacute;n&eacute;ral sur la Protection des Donn&eacute;es (RGPD&nbsp;: n&deg; 2016-679)</p>\r\n<p>1. Pr&eacute;sentation du site internet.<br />En vertu de l\'article 6 de la loi n&deg; 2004-575 du 21 juin 2004 pour la confiance dans l\'&eacute;conomie num&eacute;rique, il est pr&eacute;cis&eacute; aux utilisateurs du site internet&nbsp;https://romgeb.fr/domaineduvieuxcellier/public/sitepublic/displaypublicpage/index&nbsp;l\'identit&eacute; des diff&eacute;rents intervenants dans le cadre de sa r&eacute;alisation et de son suivi: Propri&eacute;taire : Christian Jaffre &ndash; 313 route de Saint Pierre 69220 Charentay Responsable publication : Christian Jaffre &ndash; christianjaffrevins@bbox.fr Le responsable publication est une personne physique ou une personne morale. Webmaster : Romuald Gebleux &ndash; rongeb@yahoo.ca H&eacute;bergeur : 1and1 &ndash; 7 Place de la Gare 57200 Sarreguemines 0970 808 911 D&eacute;l&eacute;gu&eacute; &agrave; la protection des donn&eacute;es : Christian Jaffre &ndash; christianjaffrevins@bbox.fr Veuillez consulter notre politique de confidentialit&eacute; afin de conna&icirc;tre vos droits en mati&egrave;re de protection de vos Donn&eacute;es &agrave; Caract&egrave;re Personnel.</p>\r\n<p></p>\r\n<p>2. G&eacute;n&eacute;ralit&eacute;s <br />L&rsquo;utilisation de ce site implique l&rsquo;acceptation pleine et enti&egrave;re des conditions d&rsquo;utilisation ci-apr&egrave;s d&eacute;crites. Ces conditions d&rsquo;utilisation sont susceptibles d&rsquo;&ecirc;tre modifi&eacute;es ou compl&eacute;t&eacute;es &agrave; tout moment, les utilisateurs du site sont donc invit&eacute;s &agrave; les consulter de mani&egrave;re r&eacute;guli&egrave;re. Ce site est normalement accessible &agrave; tout moment aux utilisateurs. Une interruption pour raison de maintenance technique peut toutefois &ecirc;tre d&eacute;cid&eacute;e par Christian Jaffre, qui s&rsquo;efforcera alors de communiquer pr&eacute;alablement aux utilisateurs les dates et heures de l&rsquo;intervention. Le site est mis &agrave; jour r&eacute;guli&egrave;rement par Christian Jaffre ou ses partenaires. De la m&ecirc;me fa&ccedil;on, les mentions l&eacute;gales peuvent &ecirc;tre modifi&eacute;es &agrave; tout moment : elles s&rsquo;imposent n&eacute;anmoins &agrave; l&rsquo;utilisateur qui est invit&eacute; &agrave; s&rsquo;y r&eacute;f&eacute;rer le plus souvent possible afin d&rsquo;en prendre connaissance.</p>\r\n<p></p>\r\n<p>3. Description des services fournis<br />Ce site a pour objet de fournir une information concernant l&rsquo;ensemble des services offerts et missions effectu&eacute;es par l&rsquo;entreprise ou la personne physique repr&eacute;sent&eacute;e. Celle-ci, ainsi Christian Jaffre, s&rsquo;efforcent de fournir sur le site des informations aussi pr&eacute;cises que possible. Toutefois, elles ne peuvent &ecirc;tre tenues responsables des omissions, des inexactitudes et des carences dans la mise &agrave; jour, qu&rsquo;elles soient de son fait ou du fait des tiers partenaires qui lui fournissent ces informations. Toutes les informations indiqu&eacute;es sur ce site sont donn&eacute;es &agrave; titre indicatif, et sont susceptibles d&rsquo;&eacute;voluer. Par ailleurs, les renseignements y figurant ne sont pas exhaustifs. Ils sont donn&eacute;s sous r&eacute;serve de modifications ayant &eacute;t&eacute; apport&eacute;es depuis leur mise en ligne.</p>\r\n<p></p>\r\n<p>4. Limitations contractuelles sur les donn&eacute;es techniques<br />Le site Internet ne pourra &ecirc;tre tenu responsable de dommages mat&eacute;riels li&eacute;s &agrave; l&rsquo;utilisation du site. De plus, l&rsquo;utilisateur du site s&rsquo;engage &agrave; acc&eacute;der au site en utilisant un mat&eacute;riel r&eacute;cent, ne contenant pas de virus et avec un navigateur de derni&egrave;re g&eacute;n&eacute;ration mis &agrave; jour.</p>\r\n<p><br />5. Propri&eacute;t&eacute; intellectuelle et contrefa&ccedil;ons<br />Sauf mention contraire, Christian Jaffre est propri&eacute;taire des droits de propri&eacute;t&eacute; intellectuelle ou d&eacute;tient les droits d&rsquo;usage sur tous les &eacute;l&eacute;ments accessibles sur le site, notamment les textes, images, graphismes, logo, ic&ocirc;nes, sons, logiciels. Toute reproduction, repr&eacute;sentation, modification, publication, adaptation de tout ou partie des &eacute;l&eacute;ments du site, quel que soit le moyen ou le proc&eacute;d&eacute; utilis&eacute;, est interdite, sauf autorisation &eacute;crite pr&eacute;alable de Top On Web SA. Toute exploitation non autoris&eacute;e du site ou de l&rsquo;un quelconque des &eacute;l&eacute;ments qu&rsquo;il contient sera consid&eacute;r&eacute;e comme constitutive d&rsquo;une contrefa&ccedil;on et poursuivie conform&eacute;ment aux dispositions l&eacute;gales.</p>\r\n<p></p>\r\n<p>6. Limitations de responsabilit&eacute;<br />Christian Jaffre ou l&rsquo;entreprise repr&eacute;sent&eacute;e ne pourront &ecirc;tre tenues responsables des dommages directs et indirects caus&eacute;s au mat&eacute;riel de l&rsquo;utilisateur, lors de l&rsquo;acc&egrave;s &agrave; ce site, et r&eacute;sultant soit de l&rsquo;utilisation d&rsquo;un mat&eacute;riel ne r&eacute;pondant pas aux sp&eacute;cifications indiqu&eacute;es au point 4, soit de l&rsquo;apparition d&rsquo;un bug ou d&rsquo;une incompatibilit&eacute;. Ils ne pourront &eacute;galement &ecirc;tre tenus responsables des dommages indirects (tels par exemple qu&rsquo;une perte de march&eacute; ou perte d&rsquo;une chance) cons&eacute;cutifs &agrave; l&rsquo;utilisation de ce site.</p>\r\n<p></p>\r\n7. Les cookies<br />\r\n<p>Outre la r&eacute;colte de donn&eacute;es personnelles via un formulaire de contact ou l\'usage d\'un autre formulaire, certaines donn&eacute;es peuvent &ecirc;tre r&eacute;cup&eacute;r&eacute;es &agrave; travers des cookies plac&eacute;s sur le site internet.</p>\r\n<p>Un cookie est un fichier plac&eacute; par un site sur le navigateur que vous utilisez pour surfer sur internet. Il permet de vous reconnaitre &agrave; chaque visite que vous effectuez sur le site concern&eacute;. Les cookies peuvent &ecirc;tre plac&eacute;s par le propri&eacute;taire du site internet ou par des prestataires externes en fonction de leur but expliqu&eacute; ci-apr&egrave;s.</p>\r\n<p>Les diff&eacute;rents cookies utilis&eacute;s sur ce site<br />Les cookies techniques ou fonctionnels :<br />Il s\'agit des cookies implant&eacute;s par le site web que vous visitez dans le but de faciliter votre navigation, comme ceux qui retiennent la langue que vous utilisez.<br /><br />Ces cookies sont :<br /><br />Nom Utilit&eacute; Expiration apr&egrave;s<br />PHPSESSID Strictement technique, permet au serveur distant de maintenir une session active 1 an<br /><br />Les cookies li&eacute;s aux r&eacute;seaux sociaux :<br />Aucun<br /><br />Les cookies li&eacute;s aux statistiques :<br />Aucun<br /><br />Les cookies sont stock&eacute;s sur votre navigateur et transmettent au propri&eacute;taire du site internet et &agrave; ses prestataires externes les informations demand&eacute;es. Vous pouvez cependant &agrave; tout instant supprimer ces cookies en vous rendant dans l\'historique de votre navigateur. Ces cookies sont :<br />Aucun</p>\r\n<br />\r\n<p>8. Droit applicable et attribution de juridiction.<br />Tout litige en relation avec l&rsquo;utilisation du site&nbsp;https://romgeb.fr/domaineduvieuxcellier/public/sitepublic/displaypublicpage/index&nbsp;est soumis au droit fran&ccedil;ais. En dehors des cas o&ugrave; la loi ne le permet pas, il est fait attribution exclusive de juridiction aux tribunaux comp&eacute;tents.</p>\r\n</div>\r\n</div>', NULL, NULL, 'content', '', '', '2020-02-22 14:33:16', '', '', '', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `fichiers`
--

DROP TABLE IF EXISTS `fichiers`;
CREATE TABLE IF NOT EXISTS `fichiers` (
  `fichiers_id` int(11) NOT NULL AUTO_INCREMENT,
  `fichiers_chemin` varchar(384) COLLATE utf8_bin DEFAULT NULL,
  `fichiers_nom` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `fichiers_type` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `fichiers_libelle` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `fichiers_meta` text COLLATE utf8_bin NOT NULL,
  `fichiers_thumbnailpath` varchar(384) COLLATE utf8_bin NOT NULL,
  `fichiers_thumbnail` varchar(128) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`fichiers_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `fichiers`
--

INSERT INTO `fichiers` (`fichiers_id`, `fichiers_chemin`, `fichiers_nom`, `fichiers_type`, `fichiers_libelle`, `fichiers_meta`, `fichiers_thumbnailpath`, `fichiers_thumbnail`) VALUES
(21, 'filesbank/', '3188eafe-222a-439a-8dc9-ea1a326835dc_dxo.jpg', 'jpg', 'chambre', 'chambre lit double', 'filesbank/', '1579678699_3188eafe-222a-439a-8dc9-ea1a326835dc_DxO.jpg'),
(22, 'filesbank/', '20191107_165058_dxo.jpg', 'jpg', '', '', 'filesbank/', '1579678784_20191107_165058_DxO.jpg'),
(23, 'filesbank/', '20191107_165112_(1)_dxo.jpg', 'jpg', '', '', 'filesbank/', '1579678795_20191107_165112_(1)_DxO.jpg'),
(24, 'filesbank/', 'img-20170702-wa0003.jpg', 'jpg', 'vue drone', 'vue drone', 'filesbank/', '1579678825_IMG-20170702-WA0003.jpg'),
(25, 'filesbank/', 'maison_garanche_suite_001_dxo.jpg', 'jpg', '', '', 'filesbank/', '1579678847_MAISON_GARANCHE_SUITE_001_DxO.jpg'),
(26, 'filesbank/', 'photos_maisons_rbnb_001_dxo_dxo.jpg', 'jpg', '', '', 'filesbank/', '1579678860_PHOTOS_MAISONS_RBNB_001_DxO_DxO.jpg'),
(27, 'filesbank/', 'photos_maisons_rbnb_008_dxo.jpg', 'jpg', '', '', 'filesbank/', '1579678869_PHOTOS_MAISONS_RBNB_008_DxO.jpg'),
(28, 'filesbank/', 'photos_maisons_rbnb_011_dxo.jpg', 'jpg', '', '', 'filesbank/', '1579678883_PHOTOS_MAISONS_RBNB_011_DxO.jpg'),
(29, 'filesbank/', 'photos_maisons_rbnb_012_dxo.jpg', 'jpg', '', '', 'filesbank/', '1579678893_PHOTOS_MAISONS_RBNB_012_DxO.jpg'),
(30, 'filesbank/', 'photos_maisons_rbnb_017_dxo.jpg', 'jpg', '', '', 'filesbank/', '1579678908_PHOTOS_MAISONS_RBNB_017_DxO.jpg'),
(31, 'filesbank/', 'photos_maisons_rbnb_042.jpg', 'jpg', '', '', 'filesbank/', '1579678922_PHOTOS_MAISONS_RBNB_042.jpg'),
(32, 'filesbank/', 'domaine_piscine_transat2.jpg', 'jpg', '', '', 'filesbank/', '1580237134_domaine_piscine_transat2.jpg'),
(33, 'filesbank/', 'terasse_piscine.jpg', 'jpg', '', '', 'filesbank/', '1580237459_terasse_piscine.jpg'),
(34, 'filesbank/', 'img-20200112-wa0002_portfolio.jpg', 'jpg', 'vendange', '', 'filesbank/', '1580676299_IMG-20200112-WA0002_portfolio.jpg'),
(35, 'filesbank/', 'img-20200112-wa0004_portfolio.jpg', 'jpg', 'vendageurs', '', 'filesbank/', '1580676318_IMG-20200112-WA0004_portfolio.jpg'),
(36, 'filesbank/', '20191107_165112_portfolio.jpg', 'jpg', 'vigne automne', '', 'filesbank/', '1580676344_20191107_165112_portfolio.jpg'),
(37, 'filesbank/', 'domaine_piscine_transat_portfolio.jpg', 'jpg', 'transat portfolio', '', 'filesbank/', '1580676367_domaine_piscine_transat_portfolio.jpg'),
(38, 'filesbank/', 'terasse_piscine_portfolio.jpg', 'jpg', 'terasse piscine portfolio', '', 'filesbank/', '1580676393_terasse_piscine_portfolio.jpg'),
(39, 'filesbank/', 'favpng_airbnb-logo-business-organization_9uz1ph0x.png', 'png', 'air bnb', '', 'filesbank/', '1581356339_FAVPNG_airbnb-logo-business-organization_9uZ1ph0x.png'),
(40, 'filesbank/', 'aligote-x1.jpg', 'jpg', 'bougogne aligoté', '', 'filesbank/', 'Aligote-X1.jpg'),
(41, 'filesbank/', 'brouilly-x1.jpg', 'jpg', 'Brouilly', '', 'filesbank/', 'Brouilly-X1.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `filesupload`
--

DROP TABLE IF EXISTS `filesupload`;
CREATE TABLE IF NOT EXISTS `filesupload` (
  `filesupload_id` int(11) NOT NULL AUTO_INCREMENT,
  `filesupload_name` varchar(256) COLLATE utf8_bin NOT NULL,
  `filesupload_path` text COLLATE utf8_bin NOT NULL,
  `filesupload_type` varchar(32) COLLATE utf8_bin NOT NULL,
  `filesupload_comment` text COLLATE utf8_bin,
  `filesupload_status` enum('waiting','validated','refused','obsolete') COLLATE utf8_bin NOT NULL DEFAULT 'waiting',
  `filesupload_thumbnail` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `filesupload_thumbnailpath` text COLLATE utf8_bin,
  `filesupload_author` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `filesupload_userid` varchar(384) COLLATE utf8_bin DEFAULT NULL,
  `filesupload_email` varchar(384) COLLATE utf8_bin DEFAULT NULL,
  `filesupload_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `filesupload_lat` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `filesupload_lng` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`filesupload_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Structure de la table `htmltemplate`
--

DROP TABLE IF EXISTS `htmltemplate`;
CREATE TABLE IF NOT EXISTS `htmltemplate` (
  `htmltemplate_id` int(11) NOT NULL AUTO_INCREMENT,
  `htmltemplate_label` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `htmltemplate_model` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`htmltemplate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `htmltemplate`
--

INSERT INTO `htmltemplate` (`htmltemplate_id`, `htmltemplate_label`, `htmltemplate_model`) VALUES
(10, 'Default Image Slider', '<div class=\"slide-bg-image overlay-light parallax parallax-section1\" data-background-img=\"img/full/11.jpg\">\r\n<div class=\"js-Slide-fullscreen-height container\">\r\n<div class=\"intro-content\">\r\n<div class=\"intro-content-inner\">\r\n<h2 class=\"h2\">Welcome to Mazel</h2>\r\n<p class=\"lead\">We carry a passion for performance marketing</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>'),
(11, 'porfolio', '<div class=\"nf-item vins\">\r\n<div class=\"item-box\">\r\n<div style=\"cursor: pointer;\" class=\"cbox-gallary1\" href=\"../../filesbank/brouilly-x1.jpg\" title=\"Vin rouge Brouilly domaine du vieux cellier\"><img class=\"item-container\" src=\"../../filesbank/brouilly-x1.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Brouilly du domaine</h5>\r\n<p class=\"white\">6&euro; ttc/la bouteille</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>');

-- --------------------------------------------------------

--
-- Structure de la table `linktocontenu`
--

DROP TABLE IF EXISTS `linktocontenu`;
CREATE TABLE IF NOT EXISTS `linktocontenu` (
  `linktocontenu_id` int(11) NOT NULL AUTO_INCREMENT,
  `contenu_id` int(11) NOT NULL,
  `rang` int(11) DEFAULT NULL,
  `titre` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `soustitre` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `sousrubriques_id` int(11) NOT NULL,
  `contenuhtml` text COLLATE utf8_bin,
  `image` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `image2` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `type` enum('linktocontenu') COLLATE utf8_bin NOT NULL,
  `author` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `themes` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `othertext1` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `othertext2` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `othertext3` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `gps_coordinates` json DEFAULT NULL,
  `linktosousrubrique_id` int(11) NOT NULL,
  `linktorubrique_id` int(11) NOT NULL,
  `contenu_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`linktocontenu_id`),
  KEY `contenu_id` (`contenu_id`),
  KEY `sousrubriques_id` (`sousrubriques_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_msg` text COLLATE utf8_bin NOT NULL,
  `message_row1` varchar(256) COLLATE utf8_bin NOT NULL,
  `message_row2` varchar(256) COLLATE utf8_bin NOT NULL,
  `message_row3` varchar(256) COLLATE utf8_bin NOT NULL,
  `message_row4` varchar(256) COLLATE utf8_bin NOT NULL,
  `message_position` int(11) NOT NULL DEFAULT '0',
  `message_type` varchar(128) COLLATE utf8_bin NOT NULL,
  `message_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Structure de la table `meta`
--

DROP TABLE IF EXISTS `meta`;
CREATE TABLE IF NOT EXISTS `meta` (
  `meta_id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_key` varchar(256) CHARACTER SET latin1 NOT NULL,
  `meta_value` varchar(512) CHARACTER SET latin1 NOT NULL,
  `rubrique_id` int(11) NOT NULL,
  PRIMARY KEY (`meta_id`),
  KEY `rubrique_id` (`rubrique_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `meta`
--

INSERT INTO `meta` (`meta_id`, `meta_key`, `meta_value`, `rubrique_id`) VALUES
(6, 'description', 'Domaine des celliers', 73),
(7, 'author', 'Domaine des celliers', 73),
(8, 'keywords', 'beaujolais village brouilly crus vins', 73),
(9, 'viewport', 'width=device-width, initial-scale=1, shrink-to-fit=no', 73);

-- --------------------------------------------------------

--
-- Structure de la table `privatespacelogin`
--

DROP TABLE IF EXISTS `privatespacelogin`;
CREATE TABLE IF NOT EXISTS `privatespacelogin` (
  `privatespacelogin_id` int(11) NOT NULL AUTO_INCREMENT,
  `space_id_fk` int(11) NOT NULL,
  `privatespacelogin_validate` tinyint(1) NOT NULL DEFAULT '0',
  `privatespacelogin_pwd` varchar(255) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_email` varchar(512) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_firstname` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_lastname` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_company` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_streetnumber` varchar(10) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_streetline_1` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_streetline_2` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_streetline_3` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_zipcode` varchar(15) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_city` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_homephone` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_mobilephone` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_website` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_lastconn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`privatespacelogin_id`),
  KEY `privatespacelogin_email` (`privatespacelogin_email`(333)),
  KEY `privatespacelogin_pwd` (`privatespacelogin_pwd`),
  KEY `space_id_fk` (`space_id_fk`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `privatespacelogin`
--

INSERT INTO `privatespacelogin` (`privatespacelogin_id`, `space_id_fk`, `privatespacelogin_validate`, `privatespacelogin_pwd`, `privatespacelogin_email`, `privatespacelogin_firstname`, `privatespacelogin_lastname`, `privatespacelogin_company`, `privatespacelogin_streetnumber`, `privatespacelogin_streetline_1`, `privatespacelogin_streetline_2`, `privatespacelogin_streetline_3`, `privatespacelogin_zipcode`, `privatespacelogin_city`, `privatespacelogin_homephone`, `privatespacelogin_mobilephone`, `privatespacelogin_website`, `privatespacelogin_lastconn`) VALUES
(1, 3, 0, 'ce26be1f9903f7fbcac01cc28acb63438a4c4d9728a4de9e3606736c4440b4a3824444bf8f154889f0cb880b0c5a1f8c7bac0dd37acb5fa20cc920c7e5fc147b', 'anit_private@anit.org', 'First Name 1', 'Last Name 2', 'my company is nÂ°1', '1', 'Test street 1', 'Test street 2', 'Test street 3', 'H1N2A5', 'My Town', '0010123456789', '001012345689', 'mywebsite.com', '2018-03-27 17:12:40');

-- --------------------------------------------------------

--
-- Structure de la table `rubrique`
--

DROP TABLE IF EXISTS `rubrique`;
CREATE TABLE IF NOT EXISTS `rubrique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(128) COLLATE utf8_bin NOT NULL,
  `rang` int(11) NOT NULL DEFAULT '-1',
  `scope` enum('public','private') COLLATE utf8_bin NOT NULL DEFAULT 'public',
  `spaceId` int(11) NOT NULL DEFAULT '-1',
  `filename` varchar(128) COLLATE utf8_bin NOT NULL,
  `contactForm` tinyint(1) NOT NULL DEFAULT '0',
  `messageForm` tinyint(1) NOT NULL DEFAULT '0',
  `updateForm` tinyint(1) NOT NULL DEFAULT '0',
  `fileuploadForm` tinyint(1) NOT NULL DEFAULT '0',
  `publishing` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `libelle` (`libelle`),
  KEY `filename` (`filename`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `rubrique`
--

INSERT INTO `rubrique` (`id`, `libelle`, `rang`, `scope`, `spaceId`, `filename`, `contactForm`, `messageForm`, `updateForm`, `fileuploadForm`, `publishing`) VALUES
(73, 'Page principal', 1, 'public', -1, 'index.phtml', 1, 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `sousrubrique`
--

DROP TABLE IF EXISTS `sousrubrique`;
CREATE TABLE IF NOT EXISTS `sousrubrique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `rang` int(11) NOT NULL DEFAULT '-1',
  `rubriques_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rubriques_id` (`rubriques_id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `sousrubrique`
--

INSERT INTO `sousrubrique` (`id`, `libelle`, `rang`, `rubriques_id`) VALUES
(53, 'Menu', 2, 73),
(54, 'Carroussel principal', 3, 73),
(55, 'Portfolio', 5, 73),
(59, 'Formulaire de contact', 7, 73),
(60, 'PrÃ©sentation du gite', 4, 73),
(61, 'Preloader', 1, 73),
(63, 'Carte GPS', 8, 73),
(64, 'air bnb', 6, 73),
(65, 'Mentions légales', 9, 73);

-- --------------------------------------------------------

--
-- Structure de la table `space`
--

DROP TABLE IF EXISTS `space`;
CREATE TABLE IF NOT EXISTS `space` (
  `space_id` int(11) NOT NULL AUTO_INCREMENT,
  `space_name` varchar(255) COLLATE utf8_bin DEFAULT '',
  `space_token` varchar(512) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`space_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
