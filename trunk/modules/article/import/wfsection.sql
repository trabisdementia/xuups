# phpMyAdmin SQL Dump
# version 2.5.5-pl1
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Sep 23, 2004 at 11:59 PM
# Server version: 3.23.56
# PHP Version: 4.3.8
# 
# Database : `205test`
# 

# --------------------------------------------------------

#
# Table structure for table `wfs_article`
#

CREATE TABLE wfs_article (
  articleid int(11) unsigned NOT NULL auto_increment,
  categoryid int(11) NOT NULL default '0',
  uid int(11) NOT NULL default '0',
  title varchar(255) default NULL,
  maintext text,
  counter int(11) NOT NULL default '0',
  created int(10) NOT NULL default '0',
  changed int(10) default '0',
  nohtml int(1) NOT NULL default '0',
  nosmiley int(1) NOT NULL default '0',
  noxcodes int(1) NOT NULL default '0',
  nobreaks int(1) NOT NULL default '0',
  summary text,
  url varchar(255) default '',
  page int(11) unsigned NOT NULL default '1',
  groupid varchar(255) default NULL,
  published int(10) NOT NULL default '0',
  expired int(10) NOT NULL default '0',
  notifypub int(1) NOT NULL default '0',
  usertype varchar(5) default NULL,
  isframe int(1) NOT NULL default '0',
  htmlpage varchar(255) default '',
  rating double(6,4) NOT NULL default '0.0000',
  votes int(11) unsigned NOT NULL default '0',
  hits int(11) unsigned NOT NULL default '0',
  urlname varchar(255) default '',
  offline int(1) NOT NULL default '0',
  weight int(4) NOT NULL default '1',
  noshowart int(1) NOT NULL default '0',
  allowcom int(1) NOT NULL default '1',
  cmainmenu int(11) NOT NULL default '0',
  isforumid int(10) NOT NULL default '0',
  articleimg varchar(255) default NULL,
  subtitle varchar(255) default '',
  wrapurl varchar(255) default '',
  version decimal(3,2) NOT NULL default '0.00',
  spotlight int(11) NOT NULL default '0',
  spotlightmain int(11) NOT NULL default '0',
  PRIMARY KEY  (articleid),
  KEY categoryid (categoryid),
  KEY uid (uid),
  KEY CHANGED (changed)
) TYPE=MyISAM;

#
# Dumping data for table `wfs_article`
#

# --------------------------------------------------------

#
# Table structure for table `wfs_article_mod`
#

CREATE TABLE wfs_article_mod (
  requestid int(11) unsigned NOT NULL auto_increment,
  articleid int(8) unsigned NOT NULL default '0',
  categoryid int(8) unsigned NOT NULL default '0',
  title varchar(255) NOT NULL default '',
  subtitle varchar(255) NOT NULL default '',
  maintext text NOT NULL,
  summary text NOT NULL,
  url varchar(250) NOT NULL default '',
  urlname varchar(255) NOT NULL default '',
  requested int(10) NOT NULL default '0',
  modifysubmitter int(11) NOT NULL default '0',
  PRIMARY KEY  (requestid)
) TYPE=MyISAM;

#
# Dumping data for table `wfs_article_mod`
#


# --------------------------------------------------------

#
# Table structure for table `wfs_article_restore`
#

CREATE TABLE wfs_article_restore (
  restore_id int(11) NOT NULL auto_increment,
  restore_date int(11) NOT NULL default '0',
  articleid int(11) NOT NULL default '0',
  categoryid int(11) NOT NULL default '0',
  uid int(11) NOT NULL default '0',
  title varchar(255) default NULL,
  maintext text,
  counter int(11) NOT NULL default '0',
  created int(10) NOT NULL default '0',
  changed int(10) default '0',
  nohtml int(1) NOT NULL default '0',
  nosmiley int(1) NOT NULL default '0',
  noxcodes int(1) NOT NULL default '0',
  nobreaks int(1) NOT NULL default '0',
  summary text,
  url varchar(255) default '',
  page int(11) unsigned NOT NULL default '1',
  groupid varchar(255) default NULL,
  published int(10) NOT NULL default '0',
  expired int(10) NOT NULL default '0',
  notifypub int(1) NOT NULL default '0',
  usertype varchar(5) default NULL,
  isframe int(1) NOT NULL default '0',
  htmlpage varchar(255) default '',
  rating double(6,4) NOT NULL default '0.0000',
  votes int(11) unsigned NOT NULL default '0',
  hits int(11) unsigned NOT NULL default '0',
  urlname varchar(255) default '',
  offline int(1) NOT NULL default '0',
  weight int(4) NOT NULL default '1',
  noshowart int(1) NOT NULL default '0',
  allowcom int(1) NOT NULL default '1',
  cmainmenu int(11) NOT NULL default '0',
  isforumid int(10) NOT NULL default '0',
  articleimg varchar(255) default NULL,
  subtitle varchar(255) default NULL,
  wrapurl varchar(255) default '',
  version decimal(3,2) NOT NULL default '0.00',
  spotlight int(11) NOT NULL default '0',
  spotlightmain int(11) NOT NULL default '0',
  PRIMARY KEY  (restore_id),
  KEY categoryid (categoryid),
  KEY uid (uid),
  KEY CHANGED (changed)
) TYPE=MyISAM;

#
# Dumping data for table `wfs_article_restore`
#


# --------------------------------------------------------

#
# Table structure for table `wfs_broken`
#

CREATE TABLE wfs_broken (
  reportid int(5) NOT NULL auto_increment,
  lid int(11) NOT NULL default '0',
  sender int(11) NOT NULL default '0',
  ip varchar(20) NOT NULL default '',
  date varchar(11) NOT NULL default '0',
  confirmed enum('0','1') NOT NULL default '0',
  acknowledged enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (reportid),
  KEY lid (lid),
  KEY sender (sender),
  KEY ip (ip)
) TYPE=MyISAM;

#
# Dumping data for table `wfs_broken`
#


# --------------------------------------------------------

#
# Table structure for table `wfs_category`
#

CREATE TABLE wfs_category (
  id int(4) unsigned NOT NULL auto_increment,
  pid int(4) unsigned NOT NULL default '0',
  imgurl varchar(255) NOT NULL default '',
  displayimg int(10) NOT NULL default '0',
  title varchar(255) NOT NULL default '',
  description text NOT NULL,
  catdescription text NOT NULL,
  groupid varchar(255) default NULL,
  catfooter text NOT NULL,
  weight int(4) NOT NULL default '1',
  cmainmenu tinyint(10) NOT NULL default '0',
  nohtml tinyint(8) NOT NULL default '1',
  nosmileys tinyint(8) NOT NULL default '1',
  noxcodes tinyint(8) NOT NULL default '1',
  noimages tinyint(8) NOT NULL default '1',
  nobreaks tinyint(8) NOT NULL default '0',
  imgalign tinyint(8) NOT NULL default '0',
  template varchar(255) NOT NULL default 'wfsection_artindex.html',
  status int(1) NOT NULL default '1',
  groupcreate varchar(255) NOT NULL default '1 2 3',
  PRIMARY KEY  (id),
  KEY pid (pid),
  KEY id (id)
) TYPE=MyISAM;

#
# Dumping data for table `wfs_category`
#

# --------------------------------------------------------

#
# Table structure for table `wfs_checkin`
#

CREATE TABLE wfs_checkin (
  ci_id int(8) NOT NULL auto_increment,
  article_id tinyint(10) NOT NULL default '0',
  user_id tinyint(10) NOT NULL default '0',
  c_in_time int(10) NOT NULL default '0',
  c_out_time int(8) NOT NULL default '0',
  c_edit int(1) NOT NULL default '0',
  PRIMARY KEY  (ci_id)
) TYPE=MyISAM;

#
# Dumping data for table `wfs_checkin`
#

# --------------------------------------------------------

#
# Table structure for table `wfs_config`
#

CREATE TABLE wfs_config (
  filesbasepath varchar(255) NOT NULL default '',
  graphicspath varchar(255) NOT NULL default '',
  sgraphicspath varchar(255) NOT NULL default '',
  filebasepathtemp varchar(255) NOT NULL default '',
  htmlpath varchar(255) NOT NULL default '',
  logopath varchar(255) NOT NULL default ''
) TYPE=MyISAM;

#
# Dumping data for table `wfs_config`
#

INSERT INTO wfs_config VALUES ('modules/wfsection/cache/uploaded', 'modules/wfsection/images/article', 'modules/wfsection/images/category', 'modules/wfsection/cache/uploaded/temp', 'modules/wfsection/html', 'modules/wfsection/images/logos');

# --------------------------------------------------------

#
# Table structure for table `wfs_files`
#

CREATE TABLE wfs_files (
  fileid int(8) NOT NULL auto_increment,
  filerealname varchar(255) NOT NULL default '',
  filetext text NOT NULL,
  articleid int(8) unsigned NOT NULL default '0',
  fileshowname varchar(255) NOT NULL default '',
  date int(10) NOT NULL default '0',
  ext varchar(64) NOT NULL default '',
  mimetype varchar(64) NOT NULL default '',
  downloadname varchar(255) NOT NULL default '',
  counter int(8) unsigned NOT NULL default '0',
  filedescript text,
  groupid varchar(255) NOT NULL default '1 2 3',
  submit tinyint(11) NOT NULL default '1',
  uid int(11) NOT NULL default '1',
  PRIMARY KEY  (fileid),
  KEY articleid (articleid)
) TYPE=MyISAM;

#
# Dumping data for table `wfs_files`
#

# --------------------------------------------------------

#
# Table structure for table `wfs_indexpage`
#

CREATE TABLE wfs_indexpage (
  indid tinyint(8) NOT NULL auto_increment,
  pagename varchar(255) NOT NULL default '',
  indeximage varchar(255) NOT NULL default 'blank.png',
  indexheading varchar(255) NOT NULL default 'WF-Sections',
  indexheader text NOT NULL,
  indexfooter text NOT NULL,
  nohtml tinyint(8) NOT NULL default '1',
  nosmileys tinyint(8) NOT NULL default '1',
  noxcodes tinyint(8) NOT NULL default '1',
  noimages tinyint(8) NOT NULL default '1',
  nobreaks tinyint(4) NOT NULL default '0',
  indexheaderalign varchar(25) NOT NULL default 'left',
  indexfooteralign varchar(25) NOT NULL default 'center',
  isdefault tinyint(8) NOT NULL default '0',
  PRIMARY KEY  (indid),
  FULLTEXT KEY indexheading (indexheading),
  FULLTEXT KEY indexheader (indexheader),
  FULLTEXT KEY indexfooter (indexfooter)
) TYPE=MyISAM;

#
# Dumping data for table `wfs_indexpage`
#


INSERT INTO wfs_indexpage VALUES (1, 'index.php', 'wfsection_logo.gif', 'WF-Sections', '[b][u]Welcome to the world of WF-Sections beta2.[/u][/b]\r\n\r\nThis release contains several bugfixes and changes \r\nover the last version.\r\n\r\nHere are some links:\r\n\r\nFor Bug reports: [url=http://www.wf-projects.com]WF-Sections Forum[/url]\r\n\r\n[Chinese users] <a href=http://xoops.org.cn/modules/newbb/viewtopic.php?topic_id=141&forum=3&post_id=501#forumpost501>Xoops.org.CN</a>\r\n\r\nMany thanks for choosing WF-Sections.\r\n\r\n[color=0000CC][u][b]Note:[/b][/u] \r\nYou can change this text within the WF-Sections admin area \r\nwith the function [i]page management[/i] and choose to edit [i]index.php[/i].[/color]\r\n\r\n\r\n ', 'Wfsection FOOTER', 0, 0, 0, 0, 1, 'left', 'left', 1);
INSERT INTO wfs_indexpage VALUES (2, 'topten.php', 'wfsection_logo.gif', 'Top Ten Articles', 'Top Ten Articles', '', 0, 0, 0, 0, 0, 'left', 'left', 1);
INSERT INTO wfs_indexpage VALUES (3, 'submit.php', 'wfsection_logo.gif', 'Submit Article', 'heading', '', 0, 0, 0, 0, 0, 'left', 'left', 1);
INSERT INTO wfs_indexpage VALUES (4, 'article.php', 'wfsection_logo.gif', 'Article Archives', 'Article Archives', '', 0, 0, 1, 1, 1, 'left', 'Center', 1);

# --------------------------------------------------------

#
# Table structure for table `wfs_mainmenu`
#

CREATE TABLE wfs_mainmenu (
  mm_id tinyint(10) NOT NULL auto_increment,
  ca_id tinyint(10) NOT NULL default '0',
  mm_title varchar(255) NOT NULL default '',
  istype varchar(255) NOT NULL default '',
  groupid varchar(255) NOT NULL default '1 2 3',
  weight int(11) NOT NULL default '0',
  PRIMARY KEY  (mm_id),
  KEY ca_id (ca_id)
) TYPE=MyISAM;

#
# Dumping data for table `wfs_mainmenu`
#


# --------------------------------------------------------

#
# Table structure for table `wfs_mimetypes`
#

CREATE TABLE wfs_mimetypes (
  mime_id int(11) NOT NULL auto_increment,
  mime_ext varchar(60) NOT NULL default '',
  mime_types text NOT NULL,
  mime_name varchar(255) NOT NULL default '',
  mime_admin int(1) NOT NULL default '1',
  mime_user int(1) NOT NULL default '0',
  KEY mime_id (mime_id)
) TYPE=MyISAM;

#
# Dumping data for table `wfs_mimetypes`
#

INSERT INTO wfs_mimetypes VALUES (1, 'bin', 'application/octet-stream', 'Binary File/Linux Executable', 1, 0);
INSERT INTO wfs_mimetypes VALUES (2, 'dms', 'application/octet-stream', 'Amiga DISKMASHER Compressed Archive', 1, 0);
INSERT INTO wfs_mimetypes VALUES (3, 'class', 'application/octet-stream', 'Java Bytecode', 1, 0);
INSERT INTO wfs_mimetypes VALUES (4, 'so', 'application/octet-stream', 'UNIX Shared Library Function', 1, 0);
INSERT INTO wfs_mimetypes VALUES (5, 'dll', 'application/octet-stream', 'Dynamic Link Library', 1, 0);
INSERT INTO wfs_mimetypes VALUES (6, 'hqx', 'application/binhex application/mac-binhex application/mac-binhex40', 'Macintosh BinHex 4 Compressed Archive', 1, 0);
INSERT INTO wfs_mimetypes VALUES (7, 'cpt', 'application/mac-compactpro application/compact_pro', 'Compact Pro Archive', 1, 0);
INSERT INTO wfs_mimetypes VALUES (8, 'lha', 'application/lha application/x-lha application/octet-stream application/x-compress application/x-compressed application/maclha', 'Compressed Archive File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (9, 'lzh', 'application/lzh application/x-lzh application/x-lha application/x-compress application/x-compressed application/x-lzh-archive zz-application/zz-winassoc-lzh application/maclha application/octet-stream', 'Compressed Archive File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (10, 'sh', 'application/x-shar', 'UNIX shar Archive File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (11, 'shar', 'application/x-shar', 'UNIX shar Archive File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (12, 'tar', 'application/tar application/x-tar applicaton/x-gtar multipart/x-tar application/x-compress application/x-compressed', 'Tape Archive File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (13, 'gtar', 'application/x-gtar', 'GNU tar Compressed File Archive', 1, 0);
INSERT INTO wfs_mimetypes VALUES (14, 'ustar', 'application/x-ustar multipart/x-ustar', 'POSIX tar Compressed Archive', 1, 0);
INSERT INTO wfs_mimetypes VALUES (15, 'zip', 'application/zip application/x-zip application/x-zip-compressed application/octet-stream application/x-compress application/x-compressed multipart/x-zip', 'Compressed Archive File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (16, 'exe', 'application/exe application/x-exe application/dos-exe application/x-winexe application/msdos-windows application/x-msdos-program', 'Executable File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (17, 'wmz', 'application/x-ms-wmz', 'Windows Media Compressed Skin File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (18, 'wmd', 'application/x-ms-wmd', 'Windows Media Download File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (19, 'doc', 'application/msword application/doc appl/text application/vnd.msword application/vnd.ms-word application/winword application/word application/x-msw6 application/x-msword', 'Word Document', 1, 0);
INSERT INTO wfs_mimetypes VALUES (20, 'pdf', 'application/pdf application/acrobat application/x-pdf applications/vnd.pdf text/pdf', 'Acrobat Portable Document Format', 1, 0);
INSERT INTO wfs_mimetypes VALUES (21, 'eps', 'application/eps application/postscript application/x-eps image/eps image/x-eps', 'Encapsulated PostScript', 1, 0);
INSERT INTO wfs_mimetypes VALUES (22, 'ps', 'application/postscript application/ps application/x-postscript application/x-ps text/postscript', 'PostScript', 1, 0);
INSERT INTO wfs_mimetypes VALUES (23, 'smi', 'application/smil', 'SMIL Multimedia', 1, 0);
INSERT INTO wfs_mimetypes VALUES (24, 'smil', 'application/smil', 'Synchronized Multimedia Integration Language', 1, 0);
INSERT INTO wfs_mimetypes VALUES (25, 'wmlc', 'application/vnd.wap.wmlc ', 'Compiled WML Document', 1, 0);
INSERT INTO wfs_mimetypes VALUES (26, 'wmlsc', 'application/vnd.wap.wmlscriptc', 'Compiled WML Script', 1, 0);
INSERT INTO wfs_mimetypes VALUES (27, 'vcd', 'application/x-cdlink', 'Virtual CD-ROM CD Image File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (28, 'pgn', 'application/formstore', 'Picatinny Arsenal Electronic Formstore Form in TIFF Format', 1, 0);
INSERT INTO wfs_mimetypes VALUES (29, 'cpio', 'application/x-cpio', 'UNIX CPIO Archive', 1, 0);
INSERT INTO wfs_mimetypes VALUES (30, 'csh', 'application/x-csh', 'Csh Script', 1, 0);
INSERT INTO wfs_mimetypes VALUES (31, 'dcr', 'application/x-director', 'Shockwave Movie', 1, 0);
INSERT INTO wfs_mimetypes VALUES (32, 'dir', 'application/x-director', 'Macromedia Director Movie', 1, 0);
INSERT INTO wfs_mimetypes VALUES (33, 'dxr', 'application/x-director application/vnd.dxr', 'Macromedia Director Protected Movie File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (34, 'dvi', 'application/x-dvi', 'TeX Device Independent Document', 1, 0);
INSERT INTO wfs_mimetypes VALUES (35, 'spl', 'application/x-futuresplash', 'Macromedia FutureSplash File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (36, 'hdf', 'application/x-hdf', 'Hierarchical Data Format File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (37, 'js', 'application/x-javascript text/javascript', 'JavaScript Source Code', 1, 0);
INSERT INTO wfs_mimetypes VALUES (38, 'skp', 'application/x-koan application/vnd-koan koan/x-skm application/vnd.koan', 'SSEYO Koan Play File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (39, 'skd', 'application/x-koan application/vnd-koan koan/x-skm application/vnd.koan', 'SSEYO Koan Design File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (40, 'skt', 'application/x-koan application/vnd-koan koan/x-skm application/vnd.koan', 'SSEYO Koan Template File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (41, 'skm', 'application/x-koan application/vnd-koan koan/x-skm application/vnd.koan', 'SSEYO Koan Mix File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (42, 'latex', 'application/x-latex text/x-latex', 'LaTeX Source Document', 1, 0);
INSERT INTO wfs_mimetypes VALUES (43, 'nc', 'application/x-netcdf text/x-cdf', 'Unidata netCDF Graphics', 1, 0);
INSERT INTO wfs_mimetypes VALUES (44, 'cdf', 'application/cdf application/x-cdf application/netcdf application/x-netcdf text/cdf text/x-cdf', 'Channel Definition Format', 1, 0);
INSERT INTO wfs_mimetypes VALUES (45, 'swf', 'application/x-shockwave-flash application/x-shockwave-flash2-preview application/futuresplash image/vnd.rn-realflash', 'Macromedia Flash Format File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (46, 'sit', 'application/stuffit application/x-stuffit application/x-sit', 'StuffIt Compressed Archive File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (47, 'tcl', 'application/x-tcl', 'TCL/TK Language Script', 1, 0);
INSERT INTO wfs_mimetypes VALUES (48, 'tex', 'application/x-tex', 'LaTeX Source', 1, 0);
INSERT INTO wfs_mimetypes VALUES (49, 'texinfo', 'application/x-texinfo', 'TeX', 1, 0);
INSERT INTO wfs_mimetypes VALUES (50, 'texi', 'application/x-texinfo', 'TeX', 1, 0);
INSERT INTO wfs_mimetypes VALUES (51, 't', 'application/x-troff', 'TAR Tape Archive Without Compression', 1, 0);
INSERT INTO wfs_mimetypes VALUES (52, 'tr', 'application/x-troff', 'Unix Tape Archive = TAR without compression (tar)', 1, 0);
INSERT INTO wfs_mimetypes VALUES (53, 'src', 'application/x-wais-source', 'Sourcecode', 1, 0);
INSERT INTO wfs_mimetypes VALUES (54, 'xhtml', 'application/xhtml+xml', 'Extensible HyperText Markup Language File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (55, 'xht', 'application/xhtml+xml', 'Extensible HyperText Markup Language File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (56, 'au', 'audio/basic audio/x-basic audio/au audio/x-au audio/x-pn-au audio/rmf audio/x-rmf audio/x-ulaw audio/vnd.qcelp audio/x-gsm audio/snd', 'ULaw/AU Audio File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (57, 'XM', 'audio/xm audio/x-xm audio/module-xm audio/mod audio/x-mod', 'Fast Tracker 2 Extended Module', 1, 0);
INSERT INTO wfs_mimetypes VALUES (58, 'snd', 'audio/basic', 'Macintosh Sound Resource', 1, 0);
INSERT INTO wfs_mimetypes VALUES (59, 'mid', 'audio/mid audio/m audio/midi audio/x-midi application/x-midi audio/soundtrack', 'Musical Instrument Digital Interface MIDI-sequention Sound', 1, 0);
INSERT INTO wfs_mimetypes VALUES (60, 'midi', 'audio/mid audio/m audio/midi audio/x-midi application/x-midi', 'Musical Instrument Digital Interface MIDI-sequention Sound', 1, 0);
INSERT INTO wfs_mimetypes VALUES (61, 'kar', 'audio/midi audio/x-midi audio/mid x-music/x-midi', 'Karaoke MIDI File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (62, 'mpga', 'audio/mpeg audio/mp3 audio/mgp audio/m-mpeg audio/x-mp3 audio/x-mpeg audio/x-mpg video/mpeg', 'Mpeg-1 Layer3 Audio Stream', 1, 0);
INSERT INTO wfs_mimetypes VALUES (63, 'mp2', 'video/mpeg audio/mpeg', 'MPEG Audio Stream, Layer II', 1, 0);
INSERT INTO wfs_mimetypes VALUES (64, 'mp3', 'audio/mpeg audio/x-mpeg audio/mp3 audio/x-mp3 audio/mpeg3 audio/x-mpeg3 audio/mpg audio/x-mpg audio/x-mpegaudio', 'MPEG Audio Stream, Layer III', 1, 0);
INSERT INTO wfs_mimetypes VALUES (65, 'aif', 'audio/aiff audio/x-aiff sound/aiff audio/rmf audio/x-rmf audio/x-pn-aiff audio/x-gsm audio/x-midi audio/vnd.qcelp', 'Audio Interchange File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (66, 'aiff', 'audio/aiff audio/x-aiff sound/aiff audio/rmf audio/x-rmf audio/x-pn-aiff audio/x-gsm audio/mid audio/x-midi audio/vnd.qcelp', 'Audio Interchange File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (67, 'aifc', 'audio/aiff audio/x-aiff audio/x-aifc sound/aiff audio/rmf audio/x-rmf audio/x-pn-aiff audio/x-gsm audio/x-midi audio/mid audio/vnd.qcelp', 'Audio Interchange File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (68, 'm3u', 'audio/x-mpegurl audio/mpeg-url application/x-winamp-playlist audio/scpls audio/x-scpls', 'MP3 Playlist File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (69, 'ram', 'audio/x-pn-realaudio audio/vnd.rn-realaudio audio/x-pm-realaudio-plugin audio/x-pn-realvideo audio/x-realaudio video/x-pn-realvideo text/plain', 'RealMedia Metafile', 1, 0);
INSERT INTO wfs_mimetypes VALUES (70, 'rm', 'application/vnd.rn-realmedia audio/vnd.rn-realaudio audio/x-pn-realaudio audio/x-realaudio audio/x-pm-realaudio-plugin', 'RealMedia Streaming Media', 1, 0);
INSERT INTO wfs_mimetypes VALUES (71, 'rpm', 'audio/x-pn-realaudio audio/x-pn-realaudio-plugin audio/x-pnrealaudio-plugin video/x-pn-realvideo-plugin audio/x-mpegurl application/octet-stream', 'RealMedia Player Plug-in', 1, 0);
INSERT INTO wfs_mimetypes VALUES (72, 'ra', 'audio/vnd.rn-realaudio audio/x-pn-realaudio audio/x-realaudio audio/x-pm-realaudio-plugin video/x-pn-realvideo', 'RealMedia Streaming Media', 1, 0);
INSERT INTO wfs_mimetypes VALUES (73, 'wav', 'audio/wav audio/x-wav audio/wave audio/x-pn-wav', 'Waveform Audio', 1, 0);
INSERT INTO wfs_mimetypes VALUES (74, 'wax', ' audio/x-ms-wax', 'Windows Media Audio Redirector', 1, 0);
INSERT INTO wfs_mimetypes VALUES (75, 'wma', 'audio/x-ms-wma video/x-ms-asf', 'Windows Media Audio File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (76, 'bmp', 'image/bmp image/x-bmp image/x-bitmap image/x-xbitmap image/x-win-bitmap image/x-windows-bmp image/ms-bmp image/x-ms-bmp application/bmp application/x-bmp application/x-win-bitmap application/preview', 'Windows OS/2 Bitmap Graphics', 1, 0);
INSERT INTO wfs_mimetypes VALUES (77, 'gif', 'image/gif image/x-xbitmap image/gi_', 'Graphic Interchange Format', 1, 0);
INSERT INTO wfs_mimetypes VALUES (78, 'ief', 'image/ief', 'Image File - Bitmap graphics', 1, 0);
INSERT INTO wfs_mimetypes VALUES (79, 'jpeg', 'image/jpeg image/jpg image/jpe_ image/pjpeg image/vnd.swiftview-jpeg', 'JPEG/JIFF Image', 1, 0);
INSERT INTO wfs_mimetypes VALUES (80, 'jpg', 'image/jpeg image/jpg image/jp_ application/jpg application/x-jpg image/pjpeg image/pipeg image/vnd.swiftview-jpeg image/x-xbitmap', 'JPEG/JIFF Image', 1, 0);
INSERT INTO wfs_mimetypes VALUES (81, 'jpe', 'image/jpeg', 'JPEG/JIFF Image', 1, 0);
INSERT INTO wfs_mimetypes VALUES (82, 'png', 'image/png application/png application/x-png', 'Portable (Public) Network Graphic', 1, 0);
INSERT INTO wfs_mimetypes VALUES (83, 'tiff', 'image/tiff', 'Tagged Image Format File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (84, 'tif', 'image/tif image/x-tif image/tiff image/x-tiff application/tif application/x-tif application/tiff application/x-tiff', 'Tagged Image Format File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (85, 'ico', 'image/ico image/x-icon application/ico application/x-ico application/x-win-bitmap image/x-win-bitmap application/octet-stream', 'Windows Icon', 1, 0);
INSERT INTO wfs_mimetypes VALUES (86, 'wbmp', 'image/vnd.wap.wbmp', 'Wireless Bitmap File Format', 1, 0);
INSERT INTO wfs_mimetypes VALUES (87, 'ras', 'application/ras application/x-ras image/ras', 'Sun Raster Graphic', 1, 0);
INSERT INTO wfs_mimetypes VALUES (88, 'pnm', 'image/x-portable-anymap', 'PBM Portable Any Map Graphic Bitmap', 1, 0);
INSERT INTO wfs_mimetypes VALUES (89, 'pbm', 'image/portable bitmap image/x-portable-bitmap image/pbm image/x-pbm', 'UNIX Portable Bitmap Graphic', 1, 0);
INSERT INTO wfs_mimetypes VALUES (90, 'pgm', 'image/x-portable-graymap image/x-pgm', 'Portable Graymap Graphic', 1, 0);
INSERT INTO wfs_mimetypes VALUES (91, 'ppm', 'image/x-portable-pixmap application/ppm application/x-ppm image/x-p image/x-ppm', 'PBM Portable Pixelmap Graphic', 1, 0);
INSERT INTO wfs_mimetypes VALUES (92, 'rgb', 'image/rgb image/x-rgb', 'Silicon Graphics RGB Bitmap', 1, 0);
INSERT INTO wfs_mimetypes VALUES (93, 'xbm', 'image/x-xpixmap image/x-xbitmap image/xpm image/x-xpm', 'X Bitmap Graphic', 1, 0);
INSERT INTO wfs_mimetypes VALUES (94, 'xpm', 'image/x-xpixmap', 'BMC Software Patrol UNIX Icon File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (95, 'xwd', 'image/x-xwindowdump image/xwd image/x-xwd application/xwd application/x-xwd', 'X Windows Dump', 1, 0);
INSERT INTO wfs_mimetypes VALUES (96, 'igs', 'model/iges application/iges application/x-iges application/igs application/x-igs drawing/x-igs image/x-igs', 'Initial Graphics Exchange Specification Format', 1, 0);
INSERT INTO wfs_mimetypes VALUES (97, 'css', 'application/css-stylesheet text/css', 'Hypertext Cascading Style Sheet', 1, 0);
INSERT INTO wfs_mimetypes VALUES (98, 'html', 'text/html text/plain', 'Hypertext Markup Language', 1, 0);
INSERT INTO wfs_mimetypes VALUES (99, 'htm', 'text/html', 'Hypertext Markup Language', 1, 0);
INSERT INTO wfs_mimetypes VALUES (100, 'txt', 'text/plain application/txt browser/internal', 'Text File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (101, 'rtf', 'application/rtf application/x-rtf text/rtf text/richtext application/msword application/doc application/x-soffice', 'Rich Text Format File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (102, 'wml', 'text/vnd.wap.wml text/wml', 'Website META Language File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (103, 'wmls', 'text/vnd.wap.wmlscript', 'WML Script', 1, 0);
INSERT INTO wfs_mimetypes VALUES (104, 'etx', 'text/x-setext', 'SetText Structure Enhanced Text', 1, 0);
INSERT INTO wfs_mimetypes VALUES (105, 'xml', 'text/xml application/xml application/x-xml', 'Extensible Markup Language File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (106, 'xsl', 'text/xml', 'XML Stylesheet', 1, 0);
INSERT INTO wfs_mimetypes VALUES (107, 'php', 'application/x-httpd-php text/php application/php magnus-internal/shellcgi application/x-php', 'PHP Script', 1, 0);
INSERT INTO wfs_mimetypes VALUES (108, 'php3', 'text/php3 application/x-httpd-php', 'PHP Script', 1, 0);
INSERT INTO wfs_mimetypes VALUES (109, 'mpeg', 'video/mpeg', 'MPEG Movie', 1, 0);
INSERT INTO wfs_mimetypes VALUES (110, 'mpg', 'video/mpeg video/mpg video/x-mpg video/mpeg2 application/x-pn-mpg video/x-mpeg video/x-mpeg2a audio/mpeg audio/x-mpeg image/mpg', 'MPEG 1 System Stream', 1, 0);
INSERT INTO wfs_mimetypes VALUES (111, 'mpe', 'video/mpeg', 'MPEG Movie Clip', 1, 0);
INSERT INTO wfs_mimetypes VALUES (112, 'qt', 'video/quicktime audio/aiff audio/x-wav video/flc', 'QuickTime Movie', 1, 0);
INSERT INTO wfs_mimetypes VALUES (113, 'mov', 'video/quicktime video/x-quicktime image/mov audio/aiff audio/x-midi audio/x-wav video/avi', 'QuickTime Video Clip', 1, 0);
INSERT INTO wfs_mimetypes VALUES (114, 'avi', 'video/avi video/msvideo video/x-msvideo image/avi video/xmpg2 application/x-troff-msvideo audio/aiff audio/avi', 'Audio Video Interleave File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (115, 'movie', 'video/sgi-movie video/x-sgi-movie', 'QuickTime Movie', 1, 0);
INSERT INTO wfs_mimetypes VALUES (116, 'asf', 'audio/asf application/asx video/x-ms-asf-plugin application/x-mplayer2 video/x-ms-asf application/vnd.ms-asf video/x-ms-asf-plugin video/x-ms-wm video/x-ms-wmx', 'Advanced Streaming Format', 1, 0);
INSERT INTO wfs_mimetypes VALUES (117, 'asx', 'video/asx application/asx video/x-ms-asf-plugin application/x-mplayer2 video/x-ms-asf application/vnd.ms-asf video/x-ms-asf-plugin video/x-ms-wm video/x-ms-wmx video/x-la-asf', 'Advanced Stream Redirector File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (118, 'wmv', 'video/x-ms-wmv', 'Windows Media File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (119, 'wvx', 'video/x-ms-wvx', 'Windows Media Redirector', 1, 0);
INSERT INTO wfs_mimetypes VALUES (120, 'wm', 'video/x-ms-wm', 'Windows Media A/V File', 1, 0);
INSERT INTO wfs_mimetypes VALUES (121, 'wmx', 'video/x-ms-wmx', 'Windows Media Player A/V Shortcut', 1, 0);
INSERT INTO wfs_mimetypes VALUES (122, 'ice', 'x-conference-xcooltalk', 'Cooltalk Audio', 1, 0);
INSERT INTO wfs_mimetypes VALUES (123, 'rar', 'application/octet-stream', 'WinRAR Compressed Archive', 1, 0);
INSERT INTO wfs_mimetypes VALUES (124, 'apb', 'wwerwerwerwer', 'werwe', 1, 0);
INSERT INTO wfs_mimetypes VALUES (125, 'aaa', 'asasasasasasa', 'asasasas', 1, 0);
INSERT INTO wfs_mimetypes VALUES (126, 'asa', 'asasas', 'asasasas', 1, 0);
INSERT INTO wfs_mimetypes VALUES (127, 'aa', 'aaaaaaaaaaaaaaa', 'aaaaaaaaaaaa', 1, 0);

# --------------------------------------------------------

#
# Table structure for table `wfs_permissions`
#

CREATE TABLE wfs_permissions (
  paths varchar(255) NOT NULL default '1',
  fileman varchar(255) NOT NULL default '1',
  newsection varchar(255) NOT NULL default '1',
  downloads varchar(255) NOT NULL default '1',
  editarticle varchar(255) NOT NULL default '1',
  deletearticles varchar(255) NOT NULL default '1',
  adminrights varchar(255) NOT NULL default '1',
  moderator varchar(255) NOT NULL default '1',
  restore varchar(255) NOT NULL default '1',
  templates varchar(255) NOT NULL default '1',
  createarticles varchar(255) NOT NULL default '1',
  docapprove varchar(255) NOT NULL default '1',
  mimetypes varchar(255) NOT NULL default '1',
  reviews varchar(255) NOT NULL default '1',
  docstats varchar(255) NOT NULL default '1',
  doclinks varchar(255) NOT NULL default '1',
  indexpage varchar(255) NOT NULL default '1',
  importdoc varchar(255) NOT NULL default '1',
  uploads varchar(255) NOT NULL default '1'
) TYPE=MyISAM;

#
# Dumping data for table `wfs_permissions`
#

INSERT INTO wfs_permissions VALUES ('1', '1', '1', '1', '1 4', '1', '1', '1', '1', '1', '1 4', '1', '1', '1', '1', '1', '1', '1', '1');

# --------------------------------------------------------

#
# Table structure for table `wfs_related`
#

CREATE TABLE wfs_related (
  related_id int(10) unsigned NOT NULL auto_increment,
  related_idtopic int(11) NOT NULL default '0',
  related_topicid mediumint(8) unsigned NOT NULL default '0',
  related_catid int(11) NOT NULL default '0',
  related_idcheck int(11) NOT NULL default '0',
  related_weight tinyint(11) NOT NULL default '0',
  related_mod int(11) NOT NULL default '1',
  PRIMARY KEY  (related_id),
  KEY itemid (related_topicid)
) TYPE=MyISAM;

#
# Dumping data for table `wfs_related`
#

# --------------------------------------------------------

#
# Table structure for table `wfs_relatedlink`
#

CREATE TABLE wfs_relatedlink (
  relatedlink_id int(11) unsigned NOT NULL auto_increment,
  relatedlink_topicid int(11) unsigned NOT NULL default '0',
  relatedlink_url varchar(255) NOT NULL default '',
  relatedlink_urlname varchar(255) NOT NULL default '',
  relatedlink_weight tinyint(11) NOT NULL default '0',
  relatedlink_mod int(11) NOT NULL default '1',
  relatedlink_lid int(11) NOT NULL default '0',
  PRIMARY KEY  (relatedlink_id),
  KEY itemid (relatedlink_topicid)
) TYPE=MyISAM;

#
# Dumping data for table `wfs_relatedlink`
#

# --------------------------------------------------------

#
# Table structure for table `wfs_reviews`
#

CREATE TABLE wfs_reviews (
  review_id int(11) unsigned NOT NULL auto_increment,
  article_id int(11) NOT NULL default '0',
  introtext text NOT NULL,
  gameplaytext text NOT NULL,
  graphicstext text NOT NULL,
  musictext text NOT NULL,
  finaltext text NOT NULL,
  img_one varchar(255) NOT NULL default '',
  img_two varchar(255) NOT NULL default '',
  publisher varchar(255) NOT NULL default '',
  developer varchar(255) NOT NULL default '',
  websiteurl varchar(255) NOT NULL default '',
  websitename varchar(255) NOT NULL default '',
  released varchar(255) NOT NULL default '',
  genre varchar(255) NOT NULL default '',
  players varchar(255) NOT NULL default '',
  platform varchar(255) NOT NULL default '',
  playonline int(1) NOT NULL default '0',
  family int(11) NOT NULL default '0',
  difficulty int(11) NOT NULL default '0',
  curve varchar(255) NOT NULL default '',
  grading char(3) NOT NULL default '0',
  graphics int(11) NOT NULL default '0',
  sound int(11) NOT NULL default '0',
  gameplay int(11) NOT NULL default '0',
  concept int(11) NOT NULL default '0',
  value int(11) NOT NULL default '0',
  tilt int(11) NOT NULL default '0',
  display int(11) NOT NULL default '0',
  PRIMARY KEY  (review_id),
  KEY categoryid (article_id)
) TYPE=MyISAM;

#
# Dumping data for table `wfs_reviews`
#


# --------------------------------------------------------

#
# Table structure for table `wfs_spotlightblock`
#

CREATE TABLE wfs_spotlightblock (
  sid int(5) unsigned NOT NULL default '0',
  item int(5) unsigned NOT NULL default '1',
  image varchar(255) NOT NULL default 'blank.png',
  itemlength int(5) unsigned NOT NULL default '500',
  imagewidth int(5) unsigned NOT NULL default '150',
  imageheight int(5) unsigned NOT NULL default '150',
  sum_type tinyint(1) NOT NULL default '0'
) TYPE=MyISAM;

#
# Dumping data for table `wfs_spotlightblock`
#

INSERT INTO wfs_spotlightblock VALUES (1, 0, 'stories.gif', 50, 150, 150, 3);

# --------------------------------------------------------

#
# Table structure for table `wfs_templates`
#

CREATE TABLE wfs_templates (
  downloads varchar(255) NOT NULL default '',
  archives varchar(255) NOT NULL default '',
  artindex varchar(255) NOT NULL default '',
  catindex varchar(255) NOT NULL default '',
  articlepage varchar(255) NOT NULL default '',
  articleplainpage varchar(255) NOT NULL default '',
  toptentemp varchar(255) NOT NULL default '',
  artmenublock varchar(255) NOT NULL default '',
  bigartblock varchar(255) NOT NULL default '',
  mainmenublock varchar(255) NOT NULL default '',
  newartblock varchar(255) NOT NULL default '',
  newdownblock varchar(255) NOT NULL default '',
  topartblock varchar(255) NOT NULL default '',
  topicsblock varchar(255) NOT NULL default '',
  authorblock varchar(255) NOT NULL default '',
  spotlightblock varchar(255) NOT NULL default ''
) TYPE=MyISAM;

#
# Dumping data for table `wfs_templates`
#

INSERT INTO wfs_templates VALUES ('wfsection_downloads.html', 'wfsection_archive.html', 'wfsection_artindex.html', 'wfsection_catindex.html', 'wfsection_article.html', 'wfsection_htmlart.html', 'wfsection_topten.html', 'wfs_block_artmenu.html', 'wfs_block_bigstory.html', 'wfs_block_menu.html', 'wfs_block_new.html', 'wfs_block_newdown.html', 'wfs_block_top.html', 'wfs_block_topics.html', 'wfs_block_author.html', 'wfs_block_spotlight.html');

# --------------------------------------------------------

#
# Table structure for table `wfs_votedata`
#

CREATE TABLE wfs_votedata (
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

#
# Dumping data for table `wfs_votedata`
#

