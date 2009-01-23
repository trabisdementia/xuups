CREATE TABLE `mship_ips` (
  `ipstart` varchar(10) NOT NULL default '',
  `ipend` varchar(10) NOT NULL default '',
  `ccode` varchar(2) NOT NULL default '',
  `ccode2` varchar(3) NOT NULL default '',
  `cname` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`ipstart`),
  KEY `ipstart` (`ipstart`),
  KEY `ipend` (`ipend`)
) ENGINE=MyISAM;
