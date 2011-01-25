CREATE TABLE IF NOT EXISTS `config` (
  `key` varchar(30) DEFAULT NULL,
  `value` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE IF NOT EXISTS `links` (
  `title` varchar(50) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `content` text CHARACTER SET utf8,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pagerank` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=700
