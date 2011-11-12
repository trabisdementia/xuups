CREATE TABLE `smartmail_newsletter` (
  `newsletter_id` int unsigned NOT NULL auto_increment,
  `newsletter_name` varchar(255) NOT NULL,
  `newsletter_description` text NOT NULL,
  `newsletter_template` varchar(255) NOT NULL default "",
  `newsletter_from_name` varchar(255) NOT NULL default "",
  `newsletter_from_email` varchar(255) NOT NULL default "",
  `newsletter_email` varchar(255) NOT NULL default "",
  `newsletter_confirm_text` text,
  PRIMARY KEY (`newsletter_id`)
) TYPE=InnoDB;

CREATE TABLE `smartmail_rule` (
  `rule_id` int unsigned NOT NULL auto_increment,
  `newsletterid` int unsigned NOT NULL default '0',
  `rule_weekday` tinyint unsigned NOT NULL default 0,
  `rule_timeofday` varchar(15) NOT NULL default '',
  PRIMARY KEY (`rule_id`),
  KEY `newsletterid` (`newsletterid`)
) TYPE=InnoDB;

CREATE TABLE `smartmail_dispatch` (
  `dispatch_id` int unsigned NOT NULL auto_increment,
  `newsletterid` int unsigned NOT NULL,
  `dispatch_time` int unsigned NOT NULL,
  `dispatch_subject` varchar(255) NOT NULL default "",
  `dispatch_status` tinyint NOT NULL default 0,
  `dispatch_content` text,
  `dispatch_receivers` int NOT NULL default 0,
  PRIMARY KEY (`dispatch_id`)
) TYPE=InnoDB;

CREATE TABLE `smartmail_block` (
  `nb_id` int(12) unsigned NOT NULL auto_increment,
  `b_id` int(11) unsigned NOT NULL,
  `newsletterid` int(11) unsigned NOT NULL,
  `dispatchid` int(11) unsigned NOT NULL default 0,
  `nb_title` varchar(255) NOT NULL default '',
  `nb_position` tinyint unsigned NOT NULL default 1,
  `nb_weight` mediumint unsigned NOT NULL default 0,
  `nb_options` text NOT NULL default '',
  `nb_override` int(12) NOT NULL default 0,
  PRIMARY KEY (`nb_id`),
  KEY `bynewsletter` (`newsletterid`, `nb_weight`)
) TYPE=InnoDB;

CREATE TABLE `smartmail_subscriber` (
  `subscriber_id` int unsigned NOT NULL auto_increment,
  `uid` int NOT NULL default 0,
  `newsletterid` int unsigned NOT NULL,
  PRIMARY KEY (`subscriber_id`),
  KEY `newsletterid` (`newsletterid`),
  UNIQUE KEY `user_list` (`uid`,`newsletterid`)
) TYPE=InnoDB;