-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le :  Dim 19 avr. 2020 à 19:11
-- Version du serveur :  5.7.26
-- Version de PHP :  7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `lgvdata`
--
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `backofficeaccess`
--

INSERT INTO `backofficeaccess` (`id_access`, `user_access`, `pwd_access`, `role_access`, `csrf_access`, `honeypot_access`) VALUES
(1, 'lgvcmsAdmin', 'c26dff3684d353fc7816987502066e09ac219eec07ce877c95dc8b921445912fe17cd069302ea3a5e66b2752aeeecd600ff6cc57965536b7350f341eef5c0961', 'admin', '', '');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

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
) ENGINE=MyISAM AUTO_INCREMENT=173 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `contenu`
--

INSERT INTO `contenu` (`contenu_id`, `rang`, `titre`, `soustitre`, `sousrubriques_id`, `contenuhtml`, `image`, `image2`, `type`, `author`, `themes`, `contenu_date`, `othertext1`, `othertext2`, `othertext3`, `sousrubriques_preview`, `contenu_rank_preview`, `gps_coordinates`) VALUES
(129, 1, 'Image 1', 'Image', 54, '<div class=\"slide-bg-image overlay-light parallax parallax-section1\" data-background-img=\"/public/filesbank/20191107_165058_dxo.jpg\">\r\n<div class=\"js-Slide-fullscreen-height container\">\r\n<div class=\"intro-content\">\r\n<div class=\"intro-content-inner\">\r\n<h2 class=\"h2\">Welcome to LGV CMS</h2>\r\n<p class=\"lead\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '/domainedesvieuxcelliers/public/filesbank/cool-meeting.jpg', '/domainedesvieuxcelliers/public/filesbank/cool-meeting.jpg', 'gallery', '', '', '2020-04-19 15:14:25', '', '', '', 0, 0, NULL),
(130, 2, 'Image 2', '', 54, '<div class=\"slide-bg-image overlay-light parallax parallax-section1\" data-background-img=\"/public/filesbank/domaine_piscine_transat2.jpg\">\r\n<div class=\"js-Slide-fullscreen-height container\">\r\n<div class=\"intro-content\">\r\n<div class=\"intro-content-inner\">\r\n<h2 class=\"h2\">Fast</h2>\r\n<p class=\"lead\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '/domainedesvieuxcelliers/public/filesbank/creative-creativity-design-700px.jpg', '', 'gallery', '', '', '2020-04-19 15:15:08', '', '', '', 0, 0, NULL),
(131, 3, 'Image 3', '', 54, '<div class=\"slide-bg-image overlay-light parallax parallax-section1\" data-background-img=\"/public/filesbank/terasse_piscine.jpg\">\r\n<div class=\"js-Slide-fullscreen-height container\">\r\n<div class=\"intro-content\">\r\n<div class=\"intro-content-inner\">\r\n<h2 class=\"h2\">Easy</h2>\r\n<p class=\"lead\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '/domainedesvieuxcelliers/public/filesbank/idea-2123972_1280.jpg', '', 'gallery', '', '', '2020-04-19 15:15:22', '', '', '', 0, 0, NULL),
(134, 3, 'Vue drone', '', 55, '<div class=\"nf-item exterieur\">\r\n<div class=\"item-box\">\r\n<div style=\"cursor: pointer;\" class=\"cbox-gallary1\" href=\"../../filesbank/img-20170702-wa0003.jpg\" title=\"vue drone\"><img class=\"item-container\" src=\"../../filesbank/img-20170702-wa0003.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Vue du domaine du ciel</h5>\r\n<p class=\"white\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '', '', 'gallery', '', '', '2020-02-10 20:29:07', '', '', '', 0, 0, NULL),
(135, 2, 'FaÃ§ade cÃ´tÃ© cour', '', 55, '<div class=\"nf-item exterieur\">\r\n<div class=\"item-box\">\r\n<div class=\"cbox-gallary1\" style=\"cursor: pointer;\" href=\"../../filesbank/maison_garanche_suite_001_dxo.jpg\" title=\"fa&ccedil;ade domaine\"><img class=\"item-container\" src=\"../../filesbank/maison_garanche_suite_001_dxo.jpg\" />\r\n<div class=\"item-mask\">\r\n<div class=\"item-caption\">\r\n<h5 class=\"white\">Fa&ccedil;ade c&ocirc;t&eacute; cour</h5>\r\n<p class=\"white\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>', '', '', 'gallery', '', '', '2020-02-10 20:27:37', '', '', '', 0, 0, NULL),
(137, 1, 'Preloader', '', 61, '<section id=\"preloader\">\r\n<div class=\"loader\" id=\"loader\">\r\n<div class=\"loader-img\"></div>\r\n</div>\r\n</section>', NULL, NULL, 'content', '', '', '2019-11-05 18:56:11', '', '', '', 0, 0, NULL),
(138, 2, 'Menu Desktop', '', 53, '<!-- Header (\"header--dark\", \"header-transparent\", \"header--sticky\")--><header id=\"header\" class=\"header header-transparent header--sticky sticky--on\"><!-- Nav Bar --><nav id=\"navigation\" class=\"header-nav\">\r\n<div class=\"container\">\r\n<div class=\"row d-flex flex-md-row align-items-center\">\r\n<div class=\"nav-menu ml-auto singlepage-nav\">\r\n<ul class=\"\">\r\n<li class=\"nav-menu-item\" style=\"text-align: center;\"><a href=\"#intro\">Accueil</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#about\">A propos</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#work\">Photos</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#social\">R&eacute;server</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#contact-section\">Contact</a></li>\r\n</ul>\r\n</div>\r\n<div class=\"nav-icons\">\r\n<div class=\"nav-icon-item d-lg-none\"><span class=\"nav-icon-trigger menu-mobile-btn align-middle\"><i class=\"ion\"></i></span></div>\r\n</div>\r\n</div>\r\n</div>\r\n</nav><!-- End Nav Bar --></header><!-- End Header -->', NULL, NULL, 'content', '', '', '2020-02-17 20:05:31', '', '', '', 0, 0, NULL),
(139, -1, 'Menu Mobile', '', 53, '<p></p>\r\n<!-- Header (\"header--dark\", \"header-transparent\", \"header--sticky\")--><header id=\"header\" class=\"header header-transparent header--sticky sticky--on\"><!-- Nav Bar --><nav id=\"navigation\" class=\"header-nav\">\r\n<div class=\"container\">\r\n<div class=\"row d-flex flex-md-row align-items-center\">\r\n<div class=\"logo mr-auto\"><!--logo--> <a href=\"index.html\"> <img class=\"logo-dark\" src=\"img/logo-black.png\" alt=\"Mazel\" /> <img class=\"logo-light\" src=\"img/logo-white.png\" alt=\"Mazel\" /> </a> <!--End logo--></div>\r\n<div class=\"nav-menu ml-auto singlepage-nav\">\r\n<ul class=\"\">\r\n<li class=\"nav-menu-item\"><a href=\"#intro\">Home</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#about\">About</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#work\">Work</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#service\">Service</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#blog\">News</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#pricing\">Pricing</a></li>\r\n<li class=\"nav-menu-item\"><a href=\"#contact-section\">Contact</a></li>\r\n</ul>\r\n</div>\r\n<div class=\"nav-icons\">\r\n<div class=\"nav-icon-item d-lg-none\"><span class=\"nav-icon-trigger menu-mobile-btn align-middle\"><i class=\"ion\"></i></span></div>\r\n<div class=\"nav-icon-item\"><span class=\"nav-icon-trigger sidebar-menu_btn align-middle\"><i class=\"ion ion-navicon\"></i></span></div>\r\n</div>\r\n</div>\r\n</div>\r\n</nav><!-- End Nav Bar --></header><!-- End Header -->', NULL, NULL, 'content', '', '', '2020-02-02 21:16:50', '', '', '', 0, 0, NULL),
(140, 1, 'My presentation', 'Pr&eacute;sentation', 60, '<p></p>\r\n<!--About Section-->\r\n<section id=\"about\" class=\"wow fadeIn ptb ptb-sm-80\">\r\n<div class=\"container\">\r\n<div class=\"row text-center\">\r\n<div class=\"col-md-8 offset-md-2\">\r\n<h3 class=\"h4\">Presentation</h3>\r\n<div class=\"spacer-15\"></div>\r\n<p class=\"lead\"></p>\r\n</div>\r\n</div>\r\n</div>\r\n</section>\r\n<!-- End About Section--><hr />', '', '', 'gallery', '', '', '2020-04-19 15:16:46', '', '', '', 0, 0, NULL),
(154, 1, 'Fiche de contact', '', 59, '<section id=\"contact-section\" class=\"ptb ptb-sm-80\">\r\n<div class=\"container\">\r\n<div class=\"row\">\r\n<div class=\"col-md-4\">\r\n<div class=\"contact-box-left\">\r\n<div class=\"contact-icon-left\"><i class=\"ion ion-ios-location\"></i></div>\r\n<h6>Address</h6>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</section>', NULL, NULL, 'content', '', '', '2020-04-19 15:13:19', '', '', '', 0, 0, NULL),
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
(172, 1, 'Legal notice', '', 65, '<!-- The Modal -->\r\n<div id=\"mentionsLegalesModal\" class=\"dvc-modal\"><!-- Modal content -->\r\n<div class=\"dvc-modal-content\"><span class=\"dvc-close\">&times;</span>\r\n<p>Legal notice</p>\r\n</div>\r\n</div>', NULL, NULL, 'content', '', '', '2020-04-19 15:33:04', '', '', '', 0, 0, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `fichiers`
--

INSERT INTO `fichiers` (`fichiers_id`, `fichiers_chemin`, `fichiers_nom`, `fichiers_type`, `fichiers_libelle`, `fichiers_meta`, `fichiers_thumbnailpath`, `fichiers_thumbnail`) VALUES
(39, 'filesbank/', 'favpng_airbnb-logo-business-organization_9uz1ph0x.png', 'png', 'air bnb', '', 'filesbank/', '1581356339_FAVPNG_airbnb-logo-business-organization_9uZ1ph0x.png');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `meta`
--

INSERT INTO `meta` (`meta_id`, `meta_key`, `meta_value`, `rubrique_id`) VALUES
(7, 'author', 'lgv cms', 73),
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

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
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

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
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `sousrubrique`
--

INSERT INTO `sousrubrique` (`id`, `libelle`, `rang`, `rubriques_id`) VALUES
(53, 'Menu', 2, 73),
(54, 'Carousel', 3, 73),
(55, 'Portfolio', 5, 73),
(59, 'Contact', 7, 73),
(60, 'PrÃ©sentation', 4, 73),
(61, 'Preloader', 1, 73),
(63, 'GPS Map', 8, 73),
(64, 'air bnb', 6, 73),
(65, 'Legal Notice', 9, 73);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;
