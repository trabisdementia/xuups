CREATE TABLE `smartblocks_fallback_location` (
  `fallback_location` int(11) NOT NULL auto_increment,
  `fallback_pattern` text NOT NULL,
  `fallback_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`fallback_location`)
) TYPE=MyISAM;

CREATE TABLE `smartblocks_pageblock` (
  `pageblockid` int(10) unsigned NOT NULL auto_increment,
  `blockid` int(10) unsigned NOT NULL default '0',
  `moduleid` int(11) NOT NULL default '0',
  `location` int(11) NOT NULL default '0',
  `placement` tinyint unsigned NOT NULL default '1',
  `title` varchar(255) NOT NULL DEFAULT '',
  `options` longtext NOT NULL,
  `priority` int(10) unsigned NOT NULL default '0',
  `falldown` tinyint unsigned NOT NULL default '0',
  `showalways` enum('yes','no','time') NOT NULL default 'yes',
  `fromdate` int unsigned NOT NULL default 0,
  `todate` int unsigned NOT NULL default 0,
  `note` varchar(255) NOT NULL default '',
  `pbcachetime` int NOT NULL default 0,
  `cachebyurl` tinyint NOT NULL default 0,
  `groups` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`pageblockid`),
  KEY `page` (`placement`, `moduleid`,`location`, `falldown`, `blockid`, `priority`),
  KEY `showalways` (`showalways`)
) TYPE=MyISAM;
