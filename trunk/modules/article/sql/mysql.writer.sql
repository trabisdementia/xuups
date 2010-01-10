# 
# Table structure for table `art_writer`
# 

CREATE TABLE `art_writer` (
  `writer_id` mediumint(8) unsigned NOT NULL auto_increment,
  `writer_name` varchar(255) NOT NULL default '',
  `writer_avatar` varchar(64) NOT NULL default '',
  `writer_profile` text,
  `writer_uid` mediumint(8) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`writer_id`),
  KEY `writer_name` (`writer_name`)
) TYPE=MyISAM;