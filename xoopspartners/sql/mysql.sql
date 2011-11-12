# phpMyAdmin MySQL-Dump
# version 2.3.2
# http://www.phpmyadmin.net/ (download page)
#
# --------------------------------------------------------

#
# Table structure for `partners` table
#

CREATE TABLE partners (
  id int(10) NOT NULL auto_increment,
  weight int(10) NOT NULL default '0',
  hits int(10) NOT NULL default '0',
  url varchar(150) NOT NULL default '',
  image varchar(150) NOT NULL default '',
  title varchar(50) NOT NULL default '',
  description varchar(255) default NULL,
  status tinyint(1) NOT NULL default '1',
  PRIMARY KEY (id),
  KEY status(status)
) ENGINE=MyISAM;