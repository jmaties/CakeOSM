-- Adminer 3.3.3 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `nodes`;
CREATE TABLE `nodes` (
  `id` bigint(20) unsigned NOT NULL,
  `version` mediumint(8) unsigned NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `lat` decimal(15,12) NOT NULL,
  `lon` decimal(15,12) NOT NULL,
  `zoom` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `nodes` (`id`, `version`, `timestamp`, `title`, `description`, `lat`, `lon`, `zoom`) VALUES
(1,	1,	'2012-01-02 23:47:55',	'Geekia',	'Mola',	36.831877419463,	-2.457445155464,	2),
(2,	2,	'2012-01-02 23:48:46',	'Otra',	'Mola mas',	36.852170901701,	-2.469477545105,	0);

-- 2012-01-09 11:48:36
