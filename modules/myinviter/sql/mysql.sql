CREATE TABLE `myinviter_waiting` (
  `wt_id` int(11) unsigned NOT NULL auto_increment,
  `wt_userid` mediumint(11) default NULL ,
  `wt_email` varchar(50) NOT NULL default '',
  `wt_name` varchar(50) NOT NULL default '',
  `wt_date` int(11) NOT NULL default '0',
  PRIMARY KEY  (`wt_id`)
) TYPE=MyISAM;

CREATE TABLE `myinviter_blacklist` (
  `bl_id` int(11) unsigned NOT NULL auto_increment,
  `bl_email` varchar(50) NOT NULL default '',
  `bl_date` int(11) NOT NULL default '0',
  PRIMARY KEY  (`bl_id`)
) TYPE=MyISAM;
