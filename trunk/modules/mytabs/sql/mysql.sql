CREATE TABLE `mytabs_page` (
  `pageid` int(10) unsigned NOT NULL auto_increment,
  `pagetitle` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`pageid`)
) TYPE=MyISAM;

CREATE TABLE `mytabs_tab` (
  `tabid` int(10) unsigned NOT NULL auto_increment,
  `tabpageid` int(10) unsigned NOT NULL default '0',
  `tabtitle` varchar(255) NOT NULL DEFAULT '',
  `taborder` int(10) unsigned NOT NULL default '0',
  `tabgroups` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`tabid`)
) TYPE=MyISAM;

CREATE TABLE `mytabs_pageblock` (
  `pageblockid` int(10) unsigned NOT NULL auto_increment,
  `blockid` int(10) unsigned NOT NULL default '0',
  `tabid` int(10) unsigned NOT NULL default '1',
  `pageid` int(10) unsigned NOT NULL default '1',
  `title` varchar(255) NOT NULL DEFAULT '',
  `options` longtext NOT NULL,
  `priority` int(10) unsigned NOT NULL default '0',
  `showalways` enum('yes','no','time') NOT NULL default 'yes',
  `fromdate` int unsigned NOT NULL default 0,
  `todate` int unsigned NOT NULL default 0,
  `note` varchar(255) NOT NULL default '',
  `pbcachetime` int NOT NULL default 0,
  `cachebyurl` tinyint NOT NULL default 0,
  `groups` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`pageblockid`),
  KEY `page` (`pageid`, `tabid`, `blockid`, `priority`),
  KEY `showalways` (`showalways`)
) TYPE=MyISAM;

