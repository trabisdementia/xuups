CREATE TABLE `extcal_cat` (
  `cat_id` int(11) NOT NULL auto_increment,
  `cat_name` varchar(255) NOT NULL,
  `cat_desc` text NOT NULL,
  `cat_color` varchar(6) NOT NULL,
  PRIMARY KEY  (`cat_id`)
) COMMENT='eXtCal By Zoullou' ;

CREATE TABLE `extcal_event` (
  `event_id` int(11) NOT NULL auto_increment,
  `cat_id` int(11) NOT NULL default '0',
  `event_title` varchar(255) NOT NULL default '',
  `event_desc` text NOT NULL,
  `event_contact` varchar(255) NOT NULL default '',
  `event_url` varchar(255) NOT NULL default '',
  `event_email` varchar(255) NOT NULL default '',
  `event_address` text NOT NULL,
  `event_approved` tinyint(1) NOT NULL default '0',
  `event_start` int(11) NOT NULL default '0',
  `event_end` int(11) NOT NULL default '0',
  `event_submitter` int(11) NOT NULL default '0',
  `event_submitdate` int(11) NOT NULL default '0',
  `event_nbmember` tinyint(4) NOT NULL default '0',
  `event_isrecur` tinyint(1) NOT NULL,
  `event_recur_rules` varchar(255) NOT NULL,
  `event_recur_start` int(11) NOT NULL,
  `event_recur_end` int(11) NOT NULL,
  `dohtml` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`event_id`)
) COMMENT='eXtCal By Zoullou' ;

CREATE TABLE `extcal_eventmember` (
  `eventmember_id` int(11) NOT NULL auto_increment,
  `event_id` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`eventmember_id`),
  UNIQUE KEY `eventmember` (`event_id`,`uid`)
) COMMENT='eXtCal By Zoullou' ;

CREATE TABLE `extcal_eventnotmember` (
  `eventnotmember_id` int(11) NOT NULL auto_increment,
  `event_id` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`eventnotmember_id`),
  UNIQUE KEY `eventnotmember` (`event_id`,`uid`)
) COMMENT='eXtCal By Zoullou' ;

CREATE TABLE `extcal_file` (
  `file_id` int(11) NOT NULL auto_increment,
  `file_name` varchar(255) NOT NULL,
  `file_nicename` varchar(255) NOT NULL,
  `file_mimetype` varchar(255) NOT NULL,
  `file_size` int(11) NOT NULL,
  `file_download` int(11) NOT NULL,
  `file_date` int(11) NOT NULL,
  `file_approved` tinyint(1) NOT NULL,
  `event_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY  (`file_id`)
) COMMENT='eXtCal By Zoullou' ;
