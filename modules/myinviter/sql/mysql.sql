CREATE TABLE `myinviter_item` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `userid` mediumint(11) default NULL ,
  `email` varchar(50) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `date` int(11) NOT NULL default '0',
  `status` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY status (`status`)
) TYPE=MyISAM;
