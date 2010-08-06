# phpMyAdmin SQL Dump
# version 2.5.5-rc2
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Sep 01, 2004 at 11:30 AM
# Server version: 4.0.12
# PHP Version: 4.3.4
# 
# 

# --------------------------------------------------------

#
# Table structure for table `smartpartner_partner`
#

CREATE TABLE `smartpartner_partner` (
  `id` int(11) NOT NULL auto_increment,
  `weight` int(10) NOT NULL default '0',
  `hits` int(10) NOT NULL default '0',
  `hits_page` int(10) NOT NULL default '0',
  `url` varchar(150) default '',
  `image` varchar(150) NOT NULL default '',
  `image_url` varchar(255) NOT NULL default '',
  `title` varchar(50) NOT NULL default '',
  `summary` text NOT NULL,
  `description` text NOT NULL,
  `contact_name` varchar(255) NOT NULL default '',
  `contact_email` varchar(255) NOT NULL default '',
  `contact_phone` varchar(255) NOT NULL default '',
  `adress` text NOT NULL,
  `status` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `status` (`status`)
) TYPE=MyISAM COMMENT='SmartPartner by marcan' AUTO_INCREMENT=1 ;    

