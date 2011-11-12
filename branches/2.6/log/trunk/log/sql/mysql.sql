CREATE TABLE `log_item` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `dirname` varchar(50) NOT NULL default '',
  `category` varchar(50) NOT NULL default '',
  `content` TEXT NOT NULL,
  `uid` int(11) NOT NULL default '0',
  `time` int(11) NOT NULL default '0',
  PRIMARY KEY (`id`),
  KEY dirname (`dirname`),
  KEY category (`category`),
  KEY uid (`uid`),
  KEY dircat (`dirname`, `category`),
  KEY uiddir (`uid`, `dirname`)
) ENGINE=MyISAM;
