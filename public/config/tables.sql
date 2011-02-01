SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
CREATE TABLE IF NOT EXISTS `config` (
  `key` varchar(30) DEFAULT NULL,
  `value` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE IF NOT EXISTS `links` (
  `title` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `url` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `content` text CHARACTER SET utf8,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pagerank` float DEFAULT NULL,
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `title` (`title`,`url`,`content`),
  FULLTEXT KEY `content` (`content`),
  FULLTEXT KEY `url` (`url`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;
CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

