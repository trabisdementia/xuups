CREATE TABLE `xteste_post` (
  `id` int(11) NOT NULL auto_increment,
  `category_id` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `body` LONGTEXT NOT NULL,
  `created` int(11) NOT NULL default '0',
  `published` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

CREATE TABLE `xteste_category` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
