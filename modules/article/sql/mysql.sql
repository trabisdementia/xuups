-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jan 24, 2006 at 06:00 AM
-- Server version: 4.1.13
-- PHP Version: 5.1.0RC1
-- 
-- For Article 0.80
-- 
-- 
-- Database: `x230`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for TABLE `art_artcat`
-- 

-- the links for category-article for multiple category purpose
CREATE TABLE `art_artcat` (
  `ac_id` 			int(11) 		unsigned NOT NULL auto_increment,	
  `art_id` 			int(11) 		unsigned NOT NULL default '0',		# article ID created by `art_article`
  `cat_id` 			mediumint(4)	unsigned NOT NULL default '0',		# category ID created by `art_category`
  `uid` 			mediumint(8)	unsigned NOT NULL default '0',		# article submitter's UID
  `ac_register`		int(10) 		unsigned NOT NULL default '0',		# time for registered to the category
  `ac_publish`		int(10) 		unsigned NOT NULL default '0',		# time for published to the category
  `ac_feature`		int(10) 		unsigned NOT NULL default '0',		# time for marked as feature in the category
  PRIMARY KEY  		(`ac_id`),
  KEY `cat_id` 		(`cat_id`),
  KEY `art_id` 		(`art_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for TABLE `art_article`
-- 

-- structure for article
CREATE TABLE `art_article` (
  `art_id` 				int(11) 		unsigned NOT NULL auto_increment,	# article ID
  `cat_id` 				mediumint(4) 	unsigned NOT NULL default '0',		# ID of basic category for the article
  `uid` 				mediumint(8) 	unsigned NOT NULL default '0',		# submitter's UID
  `writer_id` 			mediumint(8) 	unsigned NOT NULL default '0',		# author's ID
  `art_source` 			varchar(255) 	NOT NULL default '',				# source of the article, could be text or url
  `art_title` 			varchar(255) 	NOT NULL default '',				# article title
  `art_keywords`		varchar(255) 	NOT NULL default '',				# article keywords
  `art_summary`			text,												# summary text, optional
  `art_image` 			varchar(255) 	NOT NULL default '',				# spotlight image for the article: file name, caption 
  `art_template`		varchar(255)	NOT NULL default '',				# specified template, will overwrite module template and category template
  `art_pages`			text,												# page info: page No, subject, page body ID
  `art_categories`		varchar(255)	NOT NULL default '',				# serialized array for article categories
  `art_topics`			varchar(255) 	NOT NULL default '',				# serialized array for article topics
  `art_elinks`			text,												# serialized array for article external links: url, title
  `art_forum`			int(10) 		unsigned NOT NULL default '0',		# forum ID for storing comments on the article
  `art_time_create`		int(10) 		unsigned NOT NULL default '0',		# time for being created
  `art_time_submit`		int(10) 		unsigned NOT NULL default '0',		# time for being submitted to its basic category
  `art_time_publish`	int(10)			unsigned NOT NULL default '0',		# time for being published to its basic category
  `art_counter`			int(10) 		unsigned NOT NULL default '0',		# view count
  `art_rating`			int(10) 		unsigned NOT NULL default '0',		# total rating value sum
  `art_rates`			int(10) 		unsigned NOT NULL default '0',		# total rating count
  `art_comments`		int(10) 		unsigned NOT NULL default '0',		# total comment count
  `art_trackbacks`		int(10) 		unsigned NOT NULL default '0',		# total trackback count
  PRIMARY KEY  			(`art_id`),
  KEY `cat_id` 			(`cat_id`),
  KEY `art_title` 		(`art_title`),
  KEY `uid` 			(`uid`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for TABLE `art_arttop`
-- 

-- the linkship for topic-article
CREATE TABLE `art_arttop` (
  `at_id` 			int(11) 		unsigned NOT NULL auto_increment,
  `art_id` 			int(11) 		unsigned NOT NULL default '0',		# article ID
  `top_id` 			mediumint(8) 	unsigned NOT NULL default '0',		# topic ID
  `uid` 			mediumint(8) 	unsigned NOT NULL default '0',		# article submitter's UID
  `at_time` 		int(10) 		unsigned NOT NULL default '0',		# time for added to the topic
  PRIMARY KEY  		(`at_id`),
  KEY `art_id` 		(`art_id`,`top_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for TABLE `art_category`
-- 

-- structure for category
CREATE TABLE `art_category` (
  `cat_id` 				mediumint(4) 	unsigned NOT NULL auto_increment,	# category ID
  `cat_title` 			varchar(255) 	NOT NULL default '',				# category title
  `cat_pid` 			mediumint(4) 	unsigned NOT NULL default '0',		# ID of parent category
  `cat_description`		text,												# description
  `cat_image` 			varchar(255) 	NOT NULL default '',				# category spotlight image: file name
  `cat_order` 			mediumint(4) 	unsigned NOT NULL default '99',		# sorting order
  `cat_template` 		varchar(255) 	NOT NULL default 'default',			# specified template
  `cat_entry` 			int(11) 		unsigned NOT NULL default '0',		# Entry article ID
  `cat_sponsor` 		text,												# serialized array for sponsors
  `cat_moderator` 		varchar(255) 	NOT NULL default '',				# serialized array for moderator IDs
  `cat_track` 			varchar(255) 	NOT NULL default '',				# serialized array for parent category IDs
  `cat_lastarticles`	text,												# serialized array for last article IDs in the category
  PRIMARY KEY  			(`cat_id`),
  KEY `cat_order` 		(`cat_order`),
  KEY `cat_pid` 		(`cat_pid`),
  KEY `cat_title` 		(`cat_title`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for TABLE `art_file`
-- 

-- for attachments
CREATE TABLE `art_file` (
  `file_id` 		int(11) 		unsigned NOT NULL auto_increment,	# file ID
  `art_id` 			int(11) 		unsigned NOT NULL default '0',		# article ID the file belonging to
  `file_name` 		varchar(255) 	NOT NULL default '',
  PRIMARY KEY  		(`file_id`),
  KEY `art_id` 		(`art_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for TABLE `art_pingback`
-- 

-- article pingbacks
CREATE TABLE `art_pingback` (
  `pb_id` 			int(11) 		unsigned NOT NULL auto_increment,
  `art_id` 			int(11) 		unsigned NOT NULL default '0',		# article ID
  `pb_time` 		int(10) 		unsigned NOT NULL default '0',		# pinged time
  `pb_host` 		varchar(255) 	NOT NULL default '',				# pinged hostname
  `pb_url` 			varchar(255) 	NOT NULL default '',				# pinged url
  PRIMARY KEY  		(`pb_id`),
  KEY `art_id` 		(`art_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for TABLE `art_rate`
-- 

-- article rating data
CREATE TABLE `art_rate` (
  `rate_id` 		int(11) 		unsigned NOT NULL auto_increment,
  `art_id` 			int(11) 		NOT NULL default '0',				# article ID
  `uid` 			mediumint(8) 	unsigned NOT NULL default '0',		# rating submitter's UID
  `rate_ip` 		int(11) 		NOT NULL default '0',				# rating submitter's IP
  `rate_rating` 	tinyint(3) 		unsigned NOT NULL default '0',		# rating value
  `rate_time` 		int(10) 		unsigned NOT NULL default '0',		# rating time
  PRIMARY KEY  		(`rate_id`),
  KEY `art_id` 		(`art_id`),
  KEY `uid` 		(`uid`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for TABLE `art_spotlight`
-- 

CREATE TABLE `art_spotlight` (
  `sp_id` 			int(11) 		NOT NULL auto_increment,
  `art_id` 			int(11) 		NOT NULL default '0',				# article ID
  `uid` 			mediumint(8) 	unsigned NOT NULL default '0',		# UID for the moderator marking the spotlight
  `sp_time` 		int(10) 		NOT NULL default '0',				# marking time
  `sp_image` 		varchar(255) 	NOT NULL default '',				# specified spotlight image
  `sp_categories` 	varchar(255) 	NOT NULL default '',				# allowed categories for articles
  `sp_note` 		text,												# editor's notes
  PRIMARY KEY  		(`sp_id`),
  KEY `art_id` 		(`art_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for TABLE `art_text`
-- 

-- article body text
CREATE TABLE `art_text` (
  `text_id` 		int(11) 		NOT NULL auto_increment,
  `art_id` 			int(11) 		NOT NULL default '0',			# article ID
  `text_title` 		varchar(255) 	NOT NULL default '',			# subtitle
  `text_body` 		mediumtext,										# text body
  `dohtml` 			tinyint(1) 		NOT NULL default '1',			# allow HTML
  `dosmiley` 		tinyint(1) 		NOT NULL default '1',			# allow smiley
  `doxcode` 		tinyint(1) 		NOT NULL default '1',			# allow xoopscode
  `doimage` 		tinyint(1) 		NOT NULL default '1',			# allow image
  `dobr` 			tinyint(1) 		NOT NULL default '0',			# allow line break
  PRIMARY KEY  		(`text_id`),
  KEY `art_id` 		(`art_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for TABLE `art_topic`
-- 

-- article topic structure
CREATE TABLE `art_topic` (
  `top_id` 			mediumint(8) 	unsigned NOT NULL auto_increment,
  `cat_id` 			mediumint(4) 	unsigned NOT NULL default '0',		# category ID
  `top_title` 		varchar(255) 	NOT NULL default '',				# topic title
  `top_description`	text,												# description
  `top_template` 	varchar(255) 	NOT NULL default 'default',			# specified template
  `top_order` 		mediumint(8) 	unsigned NOT NULL default '1',		# sorting order
  `top_time` 		int(10) 		unsigned NOT NULL default '0',		# created time
  `top_expire` 		int(10) 		unsigned NOT NULL default '0',		# expiring time
  `top_sponsor` 	text,												# serialized array for sponsors
  PRIMARY KEY  		(`top_id`),
  KEY `cat_id` 		(`cat_id`),
  KEY `top_order` 	(`top_order`),
  KEY `top_title` 	(`top_title`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for TABLE `art_trackback`
-- 

-- trackback structure
CREATE TABLE `art_trackback` (
  `tb_id` 			int(11) 		unsigned NOT NULL auto_increment,
  `art_id` 			int(11) 		unsigned NOT NULL default '0',		# article ID
  `tb_status` 		tinyint(1) 		unsigned NOT NULL default '0',		# status, approved or not
  `tb_time` 		int(10) 		unsigned NOT NULL default '0',		# tracked time
  `tb_title` 		varchar(255) 	NOT NULL default '',				# title
  `tb_url` 			varchar(255) 	NOT NULL default '',				# url
  `tb_excerpt` 		text,												# summary
  `tb_blog_name` 	varchar(255) 	NOT NULL default '',				# blog or site name
  `tb_ip` 			int(11) 		NOT NULL default '0',				# sender's IP
  PRIMARY KEY  		(`tb_id`),
  KEY `art_id` 		(`art_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for TABLE `art_tracked`
-- 

-- tracked urls
CREATE TABLE `art_tracked` (
  `td_id` 			int(11) 		unsigned NOT NULL auto_increment,
  `art_id` 			int(11) 		unsigned NOT NULL default '0',		# article ID
  `td_time` 		int(10) 		unsigned NOT NULL default '0',		# tracked time
  `td_url` 			varchar(255) 	NOT NULL default '',				# tracked URL
  PRIMARY KEY  		(`td_id`),
  KEY `art_id` 		(`art_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for TABLE `art_writer`
-- 

-- writer structure
CREATE TABLE `art_writer` (
  `writer_id` 		mediumint(8) 	unsigned NOT NULL auto_increment,
  `writer_name` 	varchar(255) 	NOT NULL default '',				# writer's name
  `writer_avatar` 	varchar(64) 	NOT NULL default '',				# writer's avatar
  `writer_profile` 	text,												# profile
  `writer_uid` 		mediumint(8) 	unsigned NOT NULL default '0',		# UID if the writer is a registered member
  `uid` 			mediumint(8) 	unsigned NOT NULL default '0',		# UID of user who adds the writer
  PRIMARY KEY  		(`writer_id`),
  KEY `writer_name`	(`writer_name`)
) TYPE=MyISAM;