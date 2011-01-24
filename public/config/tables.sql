--
-- MySQL 5.1.41
-- Mon, 10 Jan 2011 10:31:48 +0000
--

CREATE DATABASE `spiderel` DEFAULT CHARSET latin1;

USE `spiderel`;

CREATE TABLE `config` (
   `key` varchar(30),
         `value` text
               ) ENGINE=MyISAM DEFAULT CHARSET=latin1;

                     INSERT INTO `config` (`key`, `value`) VALUES 
                           ('robots', '/home/champion/Projects/spider/public/robots.txt'),
                                 ('test1', 'tee'),
                                       ('url', 'http://dapion.com'),
                                             ('path', 'http://dapion.com/'),
                                                   ('browser', 'spiderel'),
                                                         ('domain', 'dapion.com'),
                                                               ('follow_sub_domain', ''),
                                                                     ('admin_user', 'admin'),
                                                                           ('admin_password', 'parola'),
                                                                                 ('agent', 'spiderel');

                                                                                       CREATE TABLE `links` (
                                                                                                `title` varchar(50),
                                                                                                            `url` varchar(250),
                                                                                                                           `content` text CHARSET utf8,
                                                                                                                                             `id` int(11) not null auto_increment,
                                                                                                                                                                  `pagerank` float,
                                                                                                                                                                                          PRIMARY KEY (`id`)
                                                                                                                                                                                                                  ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

                                                                                                                                                                                                                                          -- [Table `links` is empty]

