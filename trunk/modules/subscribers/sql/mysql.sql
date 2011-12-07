CREATE TABLE `subscribers_user` (
  `user_id` int(11) NOT NULL auto_increment,
  `user_email` varchar(100) NOT NULL default '',
  `user_name` varchar(100) NOT NULL default '',
  `user_country` varchar(100) NOT NULL default '',
  `user_phone` varchar(100) NOT NULL default '',
  `user_created` int(11) NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM;

CREATE TABLE `subscribers_waiting` (
  `wt_id` int(11) unsigned NOT NULL auto_increment,
  `wt_subject` varchar(150) NOT NULL default '',
  `wt_body` text NOT NULL,
  `wt_toemail` varchar(100) NOT NULL default '',
  `wt_toname` varchar(100) NOT NULL default '',
  `wt_created` int(11) NOT NULL default '0',
  `wt_priority` int(5) NOT NULL default '0',
  PRIMARY KEY  (`wt_id`)
) ENGINE=MyISAM;
