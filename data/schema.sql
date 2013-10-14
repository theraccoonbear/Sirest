DROP TABLE IF EXISTS Users;
CREATE TABLE Users (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` char(40) NOT NULL DEFAULT '',
  `resetkey` char(64) NOT NULL DEFAULT '',
  `created` DATETIME NOT NULL,
  `modified` DATETIME NOT NULL DEFAULT '1970-01-01 00:00:01',
  UNIQUE KEY username_idx (`username`),
  UNIQUE KEY email_idx (`email`),
  KEY resetkey_idx (`resetkey`),
  PRIMARY KEY(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS Stores;
CREATE TABLE Stores (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `app` varchar(255) NOT NULL DEFAULT '',
  `key` varchar(255) NOT NULL DEFAULT '',
  `data` TEXT NOT NULL,
  `created` DATETIME NOT NULL,
  `modified` DATETIME NOT NULL DEFAULT '1970-01-01 00:00:01',
  UNIQUE KEY key_idx (`key`),
  PRIMARY KEY(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cake_sessions`;
CREATE TABLE IF NOT EXISTS `cake_sessions` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `data` text,
  `expires` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;