CREATE TABLE `smartobject_meta` (
  `metakey` varchar(50) NOT NULL default '',
  `metavalue` varchar(255) NOT NULL default '',
  PRIMARY KEY (`metakey`)
) TYPE=MyISAM COMMENT='SmartObject by The SmartFactory <www.smartfactory.ca>' ;

INSERT INTO `smartobject_meta` VALUES ('version','2');

CREATE TABLE `smartobject_link` (
  `linkid` int(11) NOT NULL auto_increment,
  `date` int(11) NOT NULL default '0',
  `from_uid` int(11) NOT NULL default '0',
  `from_email` varchar(255) NOT NULL default '',
  `from_name` varchar(255) NOT NULL default '',
  `to_uid` int(11) NOT NULL default '0',
  `to_email` varchar(255) NOT NULL default '',
  `to_name` varchar(255) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `subject` varchar(255) NOT NULL default '',
  `body` TEXT NOT NULL,
  `mid` int(11) NOT NULL default '0',
  `mid_name` varchar(255) NOT NULL default '',

  PRIMARY KEY  (`linkid`)
) TYPE=MyISAM COMMENT='SmartObject by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartobject_tag` (
  `tagid` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` TEXT NOT NULL,
  PRIMARY KEY  (`tagid`)
) TYPE=MyISAM COMMENT='SmartObject by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartobject_tag_text` (
  `tagid` int(11) NOT NULL default 0,
  `language` varchar(255) NOT NULL default '',
  `value` TEXT NOT NULL,
  PRIMARY KEY  (`tagid`, `language`)
) TYPE=MyISAM COMMENT='SmartObject by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartobject_adsense` (
  `adsenseid` int(11) NOT NULL auto_increment,
  `format` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `style` TEXT NOT NULL,
  `border_color` varchar(6) NOT NULL default '',
  `background_color` varchar(6) NOT NULL default '',
  `link_color` varchar(6) NOT NULL default '',
  `url_color` varchar(6) NOT NULL default '',
  `text_color` varchar(6) NOT NULL default '',
  `client_id` varchar(100) NOT NULL default '',
  `tag` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`adsenseid`)
) TYPE=MyISAM COMMENT='SmartObject by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartobject_rating` (
  `ratingid` int(11) NOT NULL auto_increment,
  `dirname` VARCHAR(255) NOT NULL,
  `item` VARCHAR(255) NOT NULL,
  `itemid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `rate` int(1) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY  (`ratingid`)
) TYPE=MyISAM COMMENT='SmartObject by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartobject_currency` (
  `currencyid` int(11) NOT NULL auto_increment,
  `iso4217` VARCHAR(15) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `symbol`  VARCHAR(15) NOT NULL,
  `rate` float NOT NULL,
  `default_currency` int(1) NOT NULL,
  PRIMARY KEY  (`currencyid`)
) TYPE=MyISAM COMMENT='SmartObject by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

INSERT INTO `smartobject_currency` VALUES (2, 'EUR', 'Euro', '€', 0.65, 0);
INSERT INTO `smartobject_currency` VALUES (3, 'USD', 'American dollar', '$', 0.9, 0);
INSERT INTO `smartobject_currency` VALUES (1, 'CAD', 'Canadian dollar', '$', 1, 1);

 CREATE TABLE `smartobject_file` (
`fileid` INT( 11 ) NOT NULL auto_increment,
`caption` VARCHAR( 255 ) NOT NULL ,
`url` VARCHAR( 255 ) NOT NULL ,
`description` TEXT NOT NULL,
`moduleid` INT( 11 ) NOT NULL ,
`name` VARCHAR( 255 ) NOT NULL ,
`itemid` INT( 11 ) NOT NULL ,
`item` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY  (`fileid`)
)  TYPE=MyISAM COMMENT='SmartObject by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

CREATE TABLE `smartobject_urllink` (
`urllinkid` INT( 11 ) NOT NULL auto_increment,
`caption` VARCHAR( 255 ) NOT NULL ,
`url` VARCHAR( 255 ) NOT NULL ,
`description` TEXT NOT NULL ,
`moduleid` INT( 11 ) NOT NULL ,
`name` VARCHAR( 255 ) NOT NULL ,
`itemid` INT( 11 ) NOT NULL ,
`item` VARCHAR( 255 ) NOT NULL ,
`target` VARCHAR( 10 ) NOT NULL,
PRIMARY KEY  (`urllinkid`)
) ENGINE = MYISAM COMMENT='SmartObject by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;

