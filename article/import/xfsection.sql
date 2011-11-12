# $Id: xfsection.sql,v 1.2 2005/06/20 15:03:23 ohwada Exp $

# 2004/03/27 K.OHWADA
# add excle powerpoint

# 2003/10/11 K.OHWADA
# rename module and table wfs to xfs
#   change this file name wfsection.sql to xfsection.sql
# view and edit for pure html file
#   add field nocr, enaamp

# phpMyAdmin MySQL-Dump
# version 2.2.6
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Jun 18, 2003 at 11:43 PM
# Server version: 3.23.51
# PHP Version: 4.3.0
# WF-Section Version 1 Stable
# Database : `WF-Sections`
# --------------------------------------------------------

#
# Table structure for table `xfs_article`
#

# add field nobr, enaamp
CREATE TABLE xfs_article (
  articleid int(8) unsigned NOT NULL auto_increment,
  categoryid int(8) unsigned NOT NULL default '0',
  uid int(5) NOT NULL default '0',
  title varchar(255) default NULL,
  maintext text NOT NULL,
  counter int(8) unsigned NOT NULL default '0',
  created int(10) NOT NULL default '0',
  changed int(10) NOT NULL default '0',
  nohtml tinyint(1) NOT NULL default '0',
  nosmiley tinyint(1) NOT NULL default '0',
  summary text NOT NULL,
  url varchar(255) NOT NULL default '',
  page int(8) unsigned NOT NULL default '1',
  groupid varchar(255) default NULL,
  submit int(10) NOT NULL default '1',
  published int(10) NOT NULL default '0',
  expired int(10) NOT NULL default '0',
  notifypub tinyint(1) NOT NULL default '0',
  type varchar(5) NOT NULL default '',
  ishtml int(10) NOT NULL default '0',
  htmlpage varchar(255) NOT NULL default '',
  rating double(6,4) NOT NULL default '0.0000',
  votes int(11) unsigned NOT NULL default '0',
  hits int(11) unsigned NOT NULL default '0',
  urlname varchar(255) NOT NULL default '',
  offline int(10) NOT NULL default '0',
  weight int(4) NOT NULL default '1',
  noshowart int(10) NOT NULL default '0',
  nobr tinyint(1) NOT NULL default '0',	
  enaamp tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (articleid),
  KEY categoryid (categoryid),
  KEY uid (uid),
  KEY changed (changed)
) TYPE=MyISAM;


#
# Table structure for table `xfs_broken`
#

CREATE TABLE xfs_broken (
  reportid int(5) NOT NULL auto_increment,
  lid int(11) unsigned NOT NULL default '0',
  sender int(11) unsigned NOT NULL default '0',
  ip varchar(20) NOT NULL default '',
  PRIMARY KEY  (reportid),
  KEY lid (lid),
  KEY sender (sender),
  KEY ip (ip)
) TYPE=MyISAM;

#
# Table structure for table `xfs_category`
#

CREATE TABLE xfs_category (
  id int(4) unsigned NOT NULL auto_increment,
  pid int(4) unsigned NOT NULL default '0',
  imgurl varchar(20) NOT NULL default '',
  displayimg int(10) NOT NULL default '0',
  title varchar(50) NOT NULL default '',
  description text NOT NULL,
  catdescription text NOT NULL,
  groupid varchar(255) default NULL,
  catfooter text NOT NULL,
  orders int(4) NOT NULL default '1',
  editaccess varchar(255) NOT NULL default '1 2 3',
  PRIMARY KEY  (id),
  KEY pid (pid)
) TYPE=MyISAM;

#
# Table structure for table `xfs_config`
#

# chnage indexheading
CREATE TABLE xfs_config (
  articlesapage int(10) NOT NULL default '10',
  filesbasepath varchar(255) NOT NULL default '',
  graphicspath varchar(255) NOT NULL default '',
  sgraphicspath varchar(255) NOT NULL default '',
  smiliepath varchar(255) NOT NULL default '',
  htmlpath varchar(255) NOT NULL default '',
  toppagetype varchar(255) NOT NULL default '',
  wysiwygeditor int(10) NOT NULL default '1',
  showcatpic int(10) NOT NULL default '0',
  comments int(10) NOT NULL default '0',
  blockscroll int(10) NOT NULL default '0',
  blockheight int(10) NOT NULL default '50',
  blockamount int(10) NOT NULL default '5',
  blockdelay int(10) NOT NULL default '1',
  submenus int(10) NOT NULL default '0',
  webmstonly int(10) NOT NULL default '0',
  lastart int(10) NOT NULL default '10',
  numuploads int(10) NOT NULL default '5',
  timestamp text NOT NULL,
  autoapprove int(10) NOT NULL default '0',
  showauthor int(10) NOT NULL default '1',
  showcomments int(10) NOT NULL default '1',
  showfile int(10) NOT NULL default '1',
  showrated int(10) NOT NULL default '1',
  showvotes int(10) NOT NULL default '1',
  showupdated int(10) NOT NULL default '1',
  showhits int(10) NOT NULL default '1',
  showMarticles int(10) NOT NULL default '1',
  showMupdated int(10) NOT NULL default '1',
  anonpost int(10) NOT NULL default '0',
  notifysubmit int(10) NOT NULL default '0',
  shortart int(10) NOT NULL default '0',
  shortcat int(10) NOT NULL default '0',
  novote int(10) NOT NULL default '1',
  realname int(10) NOT NULL default '0',
  indexheading varchar(255) NOT NULL default 'XF-Sections',
  indexheader text NOT NULL,
  indexfooter text NOT NULL,
  groupid varchar(255) NOT NULL default '1 2 3',
  indeximage varchar(255) NOT NULL default '',
  noicons int(10) NOT NULL default '1',
  summary varchar(255) NOT NULL default '1',
  aidxpathtype tinyint(4) NOT NULL default '1',
  aidxorder varchar(32) NOT NULL default 'weight',
  selmimetype text NOT NULL,
  wfsmode varchar(50) NOT NULL default '666',
  imgwidth int(10) NOT NULL default '100',
  imgheight int(10) NOT NULL default '100',
  filesize int(10) NOT NULL default '2097152',
  picon int(10) NOT NULL default '1',
  PRIMARY KEY  (articlesapage)
) TYPE=MyISAM;

#
# Dumping data for table `xfs_config`
#

# wfs -> xfs
# add excle
INSERT INTO xfs_config VALUES (10, 'modules/xfsection/cache/uploaded', 'modules/xfsection/images/article', 'modules/xfsection/images/category', 'uploads', 'modules/xfsection/html', '1', 1, 0, 0, 0, 100, 1, 25, 0, 0, 10, 1, 'Y/n/j', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 'XF-Sections', 'This is a test header 2', 'This is a test footer', '1 2 3', 'logo.gif', 1, '1', 1, 'weight', 'doc lha lzh pdf gtar swf tar tex texinfo texi zip Zip au XM snd mid midi kar mpga mp2 mp3 aif aiff aifc m3u ram rm rpm ra wav wax bmp gif ief jpeg jpg jpe png tiff tif ico pbm ppm rgb xbm xpm css html htm asc txt rtx rtf mpeg mpg mpe qt mov mxu avi xls ppt', '666', 100, 100, 2097152, 1);
# --------------------------------------------------------

#
# Table structure for table `xfs_files`
#

CREATE TABLE xfs_files (
  fileid int(8) NOT NULL auto_increment,
  filerealname varchar(255) NOT NULL default '',
  filetext text NOT NULL,
  articleid int(8) unsigned NOT NULL default '0',
  fileshowname varchar(255) NOT NULL default '',
  date int(10) NOT NULL default '0',
  ext varchar(64) NOT NULL default '',
  minetype varchar(64) NOT NULL default '',
  downloadname varchar(255) NOT NULL default '',
  counter int(8) unsigned NOT NULL default '0',
  filedescript text,
  groupid varchar(255) NOT NULL default '1 2 3',
  PRIMARY KEY  (fileid),
  KEY articleid (articleid)
) TYPE=MyISAM;

#
# Table structure for table `xfs_votedata`
#

CREATE TABLE xfs_votedata (
  ratingid int(11) unsigned NOT NULL auto_increment,
  lid int(11) unsigned NOT NULL default '0',
  ratinguser int(11) NOT NULL default '0',
  rating tinyint(3) unsigned NOT NULL default '0',
  ratinghostname varchar(60) NOT NULL default '',
  ratingtimestamp int(10) NOT NULL default '0',
  PRIMARY KEY  (ratingid),
  KEY ratinguser (ratinguser),
  KEY ratinghostname (ratinghostname),
  KEY lid (lid)
) TYPE=MyISAM;

