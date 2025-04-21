CREATE DATABASE IF NOT EXISTS `diva` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `diva`;

CREATE TABLE IF NOT EXISTS `amis` (
  `id_amis` int(11) NOT NULL AUTO_INCREMENT,
  `id_membre1` int(11) NOT NULL,
  `id_membre2` int(11) NOT NULL,
  `accept` int(11) NOT NULL,
  PRIMARY KEY (`id_amis`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pub` int(11) NOT NULL,
  `coms` text NOT NULL,
  `send` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

CREATE TABLE IF NOT EXISTS `enregistrement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pub` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

CREATE TABLE IF NOT EXISTS `publication` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dtp` datetime NOT NULL,
  `react` int(11) NOT NULL,
  `send_pub` int(11) NOT NULL,
  `confidualiter` int(11) NOT NULL,
  `pub` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

CREATE TABLE IF NOT EXISTS `react` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pub` int(11) NOT NULL,
  `type_react` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

CREATE TABLE IF NOT EXISTS `texto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mp` varchar(255) NOT NULL,
  `send` int(11) NOT NULL,
  `receive` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `groupe` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=94 ;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `dtn` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `profil` varchar(255) NOT NULL,
  `couverture` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `activiter` int,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;


CREATE TABLE IF NOT EXISTS `vues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_story` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;


CREATE TABLE groupe (
  id int(11) NOT NULL AUTO_INCREMENT,
  admin int(11) NOT NULL,
  nom varchar(255),
  photo varchar(255),
  dtc datetime,
  PRIMARY KEY (`id`) 
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;


CREATE TABLE membre_groupe (
  id int(11) NOT NULL AUTO_INCREMENT,
  id_groupe int(11) NOT NULL,
  id_membre int(11) NOT NULL,
  PRIMARY KEY (`id`) 
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;
