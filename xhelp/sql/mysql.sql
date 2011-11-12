# phpMyAdmin SQL Dump
# version 2.5.6-rc1
# http://www.phpmyadmin.net
#
# $Id: mysql.sql,v 1.62 2005/11/23 20:01:51 ackbarr Exp $

# --------------------------------------------------------

#
# Table structure for table `xhelp_departments`
#

CREATE TABLE xhelp_departments (
    id int(11) NOT NULL auto_increment,
    department varchar(35) NOT NULL default '',
    PRIMARY KEY (id),
    KEY department (department)
) TYPE=MyISAM;

#
# Structure for the `xhelp_department_mailbox` table :
#

CREATE TABLE xhelp_department_mailbox (
  id int(11) NOT NULL auto_increment,
  departmentid int(11) default NULL,
  emailaddress varchar(255) default NULL,
  server varchar(50) default NULL,
  serverport int(11) default NULL,
  username varchar(50) default NULL,
  password varchar(50) default NULL,
  priority tinyint(4) default NULL,
  mboxtype int(11) NOT NULL default 1,
  active int(11) NOT NULL default 1,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `departmentid` (`departmentid`),
  KEY `emailaddress` (`emailaddress`),
  KEY `mboxtype` (`mboxtype`),
  KEY `active` (`active`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xhelp_files`
#

CREATE TABLE xhelp_files (
    id int(11) NOT NULL auto_increment,
    filename varchar(255) NOT NULL default '',
    ticketid int(11) NOT NULL default '0',
    responseid int(11) NOT NULL default '0',
    mimetype varchar(255) NOT NULL default '',
    PRIMARY KEY (id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xhelp_logmessages`
#

CREATE TABLE xhelp_logmessages (
    id int(11) NOT NULL auto_increment,
    uid int(11) NOT NULL default '0',
    ticketid int(11) NOT NULL default '0',
    lastUpdated int(11) NOT NULL default '0',
    action varchar(255) NOT NULL default '',
    PRIMARY KEY (id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xhelp_mailevent`
#

CREATE TABLE xhelp_mailevent (
  id int(11) NOT NULL auto_increment,
  mbox_id int(11) NOT NULL default '0',
  event_desc text,
  event_class int(11) NOT NULL default '0',
  posted int(11) NOT NULL default '0',
  PRIMARY KEY(id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xhelp_mimetypes`
#

CREATE TABLE xhelp_mimetypes (
  mime_id int(11) NOT NULL auto_increment,
  mime_ext varchar(60) NOT NULL default '',
  mime_types text NOT NULL,
  mime_name varchar(255) NOT NULL default '',
  mime_admin int(1) NOT NULL default '1',
  mime_user int(1) NOT NULL default '0',
  KEY mime_id (mime_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Dumping data for table `xhelp_mimetypes`
#

INSERT INTO xhelp_mimetypes VALUES (1, 'bin', 'application/octet-stream', 'Binary File/Linux Executable', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (2, 'dms', 'application/octet-stream', 'Amiga DISKMASHER Compressed Archive', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (3, 'class', 'application/octet-stream', 'Java Bytecode', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (4, 'so', 'application/octet-stream', 'UNIX Shared Library Function', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (5, 'dll', 'application/octet-stream', 'Dynamic Link Library', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (6, 'hqx', 'application/binhex application/mac-binhex application/mac-binhex40', 'Macintosh BinHex 4 Compressed Archive', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (7, 'cpt', 'application/mac-compactpro application/compact_pro', 'Compact Pro Archive', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (8, 'lha', 'application/lha application/x-lha application/octet-stream application/x-compress application/x-compressed application/maclha', 'Compressed Archive File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (9, 'lzh', 'application/lzh application/x-lzh application/x-lha application/x-compress application/x-compressed application/x-lzh-archive zz-application/zz-winassoc-lzh application/maclha application/octet-stream', 'Compressed Archive File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (10, 'sh', 'application/x-shar', 'UNIX shar Archive File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (11, 'shar', 'application/x-shar', 'UNIX shar Archive File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (12, 'tar', 'application/tar application/x-tar applicaton/x-gtar multipart/x-tar application/x-compress application/x-compressed', 'Tape Archive File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (13, 'gtar', 'application/x-gtar', 'GNU tar Compressed File Archive', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (14, 'ustar', 'application/x-ustar multipart/x-ustar', 'POSIX tar Compressed Archive', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (15, 'zip', 'application/zip application/x-zip application/x-zip-compressed application/octet-stream application/x-compress application/x-compressed multipart/x-zip', 'Compressed Archive File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (16, 'exe', 'application/exe application/x-exe application/dos-exe application/x-winexe application/msdos-windows application/x-msdos-program', 'Executable File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (17, 'wmz', 'application/x-ms-wmz', 'Windows Media Compressed Skin File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (18, 'wmd', 'application/x-ms-wmd', 'Windows Media Download File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (19, 'doc', 'application/msword application/doc appl/text application/vnd.msword application/vnd.ms-word application/winword application/word application/x-msw6 application/x-msword', 'Word Document', 1, 1);
INSERT INTO xhelp_mimetypes VALUES (20, 'pdf', 'application/pdf application/acrobat application/x-pdf applications/vnd.pdf text/pdf', 'Acrobat Portable Document Format', 1, 1);
INSERT INTO xhelp_mimetypes VALUES (21, 'eps', 'application/eps application/postscript application/x-eps image/eps image/x-eps', 'Encapsulated PostScript', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (22, 'ps', 'application/postscript application/ps application/x-postscript application/x-ps text/postscript', 'PostScript', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (23, 'smi', 'application/smil', 'SMIL Multimedia', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (24, 'smil', 'application/smil', 'Synchronized Multimedia Integration Language', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (25, 'wmlc', 'application/vnd.wap.wmlc ', 'Compiled WML Document', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (26, 'wmlsc', 'application/vnd.wap.wmlscriptc', 'Compiled WML Script', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (27, 'vcd', 'application/x-cdlink', 'Virtual CD-ROM CD Image File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (28, 'pgn', 'application/formstore', 'Picatinny Arsenal Electronic Formstore Form in TIFF Format', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (29, 'cpio', 'application/x-cpio', 'UNIX CPIO Archive', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (30, 'csh', 'application/x-csh', 'Csh Script', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (31, 'dcr', 'application/x-director', 'Shockwave Movie', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (32, 'dir', 'application/x-director', 'Macromedia Director Movie', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (33, 'dxr', 'application/x-director application/vnd.dxr', 'Macromedia Director Protected Movie File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (34, 'dvi', 'application/x-dvi', 'TeX Device Independent Document', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (35, 'spl', 'application/x-futuresplash', 'Macromedia FutureSplash File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (36, 'hdf', 'application/x-hdf', 'Hierarchical Data Format File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (37, 'js', 'application/x-javascript text/javascript', 'JavaScript Source Code', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (38, 'skp', 'application/x-koan application/vnd-koan koan/x-skm application/vnd.koan', 'SSEYO Koan Play File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (39, 'skd', 'application/x-koan application/vnd-koan koan/x-skm application/vnd.koan', 'SSEYO Koan Design File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (40, 'skt', 'application/x-koan application/vnd-koan koan/x-skm application/vnd.koan', 'SSEYO Koan Template File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (41, 'skm', 'application/x-koan application/vnd-koan koan/x-skm application/vnd.koan', 'SSEYO Koan Mix File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (42, 'latex', 'application/x-latex text/x-latex', 'LaTeX Source Document', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (43, 'nc', 'application/x-netcdf text/x-cdf', 'Unidata netCDF Graphics', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (44, 'cdf', 'application/cdf application/x-cdf application/netcdf application/x-netcdf text/cdf text/x-cdf', 'Channel Definition Format', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (45, 'swf', 'application/x-shockwave-flash application/x-shockwave-flash2-preview application/futuresplash image/vnd.rn-realflash', 'Macromedia Flash Format File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (46, 'sit', 'application/stuffit application/x-stuffit application/x-sit', 'StuffIt Compressed Archive File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (47, 'tcl', 'application/x-tcl', 'TCL/TK Language Script', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (48, 'tex', 'application/x-tex', 'LaTeX Source', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (49, 'texinfo', 'application/x-texinfo', 'TeX', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (50, 'texi', 'application/x-texinfo', 'TeX', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (51, 't', 'application/x-troff', 'TAR Tape Archive Without Compression', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (52, 'tr', 'application/x-troff', 'Unix Tape Archive = TAR without compression (tar)', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (53, 'src', 'application/x-wais-source', 'Sourcecode', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (54, 'xhtml', 'application/xhtml+xml', 'Extensible HyperText Markup Language File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (55, 'xht', 'application/xhtml+xml', 'Extensible HyperText Markup Language File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (56, 'au', 'audio/basic audio/x-basic audio/au audio/x-au audio/x-pn-au audio/rmf audio/x-rmf audio/x-ulaw audio/vnd.qcelp audio/x-gsm audio/snd', 'ULaw/AU Audio File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (57, 'XM', 'audio/xm audio/x-xm audio/module-xm audio/mod audio/x-mod', 'Fast Tracker 2 Extended Module', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (58, 'snd', 'audio/basic', 'Macintosh Sound Resource', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (59, 'mid', 'audio/mid audio/m audio/midi audio/x-midi application/x-midi audio/soundtrack', 'Musical Instrument Digital Interface MIDI-sequention Sound', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (60, 'midi', 'audio/mid audio/m audio/midi audio/x-midi application/x-midi', 'Musical Instrument Digital Interface MIDI-sequention Sound', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (61, 'kar', 'audio/midi audio/x-midi audio/mid x-music/x-midi', 'Karaoke MIDI File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (62, 'mpga', 'audio/mpeg audio/mp3 audio/mgp audio/m-mpeg audio/x-mp3 audio/x-mpeg audio/x-mpg video/mpeg', 'Mpeg-1 Layer3 Audio Stream', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (63, 'mp2', 'video/mpeg audio/mpeg', 'MPEG Audio Stream, Layer II', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (64, 'mp3', 'audio/mpeg audio/x-mpeg audio/mp3 audio/x-mp3 audio/mpeg3 audio/x-mpeg3 audio/mpg audio/x-mpg audio/x-mpegaudio', 'MPEG Audio Stream, Layer III', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (65, 'aif', 'audio/aiff audio/x-aiff sound/aiff audio/rmf audio/x-rmf audio/x-pn-aiff audio/x-gsm audio/x-midi audio/vnd.qcelp', 'Audio Interchange File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (66, 'aiff', 'audio/aiff audio/x-aiff sound/aiff audio/rmf audio/x-rmf audio/x-pn-aiff audio/x-gsm audio/mid audio/x-midi audio/vnd.qcelp', 'Audio Interchange File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (67, 'aifc', 'audio/aiff audio/x-aiff audio/x-aifc sound/aiff audio/rmf audio/x-rmf audio/x-pn-aiff audio/x-gsm audio/x-midi audio/mid audio/vnd.qcelp', 'Audio Interchange File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (68, 'm3u', 'audio/x-mpegurl audio/mpeg-url application/x-winamp-playlist audio/scpls audio/x-scpls', 'MP3 Playlist File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (69, 'ram', 'audio/x-pn-realaudio audio/vnd.rn-realaudio audio/x-pm-realaudio-plugin audio/x-pn-realvideo audio/x-realaudio video/x-pn-realvideo text/plain', 'RealMedia Metafile', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (70, 'rm', 'application/vnd.rn-realmedia audio/vnd.rn-realaudio audio/x-pn-realaudio audio/x-realaudio audio/x-pm-realaudio-plugin', 'RealMedia Streaming Media', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (71, 'rpm', 'audio/x-pn-realaudio audio/x-pn-realaudio-plugin audio/x-pnrealaudio-plugin video/x-pn-realvideo-plugin audio/x-mpegurl application/octet-stream', 'RealMedia Player Plug-in', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (72, 'ra', 'audio/vnd.rn-realaudio audio/x-pn-realaudio audio/x-realaudio audio/x-pm-realaudio-plugin video/x-pn-realvideo', 'RealMedia Streaming Media', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (73, 'wav', 'audio/wav audio/x-wav audio/wave audio/x-pn-wav', 'Waveform Audio', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (74, 'wax', ' audio/x-ms-wax', 'Windows Media Audio Redirector', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (75, 'wma', 'audio/x-ms-wma video/x-ms-asf', 'Windows Media Audio File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (76, 'bmp', 'image/bmp image/x-bmp image/x-bitmap image/x-xbitmap image/x-win-bitmap image/x-windows-bmp image/ms-bmp image/x-ms-bmp application/bmp application/x-bmp application/x-win-bitmap application/preview', 'Windows OS/2 Bitmap Graphics', 1, 1);
INSERT INTO xhelp_mimetypes VALUES (77, 'gif', 'image/gif image/x-xbitmap image/gi_', 'Graphic Interchange Format', 1, 1);
INSERT INTO xhelp_mimetypes VALUES (78, 'ief', 'image/ief', 'Image File - Bitmap graphics', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (79, 'jpeg', 'image/jpeg image/jpg image/jpe_ image/pjpeg image/vnd.swiftview-jpeg', 'JPEG/JIFF Image', 1, 1);
INSERT INTO xhelp_mimetypes VALUES (80, 'jpg', 'image/jpeg image/jpg image/jp_ application/jpg application/x-jpg image/pjpeg image/pipeg image/vnd.swiftview-jpeg image/x-xbitmap', 'JPEG/JIFF Image', 1, 1);
INSERT INTO xhelp_mimetypes VALUES (81, 'jpe', 'image/jpeg', 'JPEG/JIFF Image', 1, 1);
INSERT INTO xhelp_mimetypes VALUES (82, 'png', 'image/png application/png application/x-png', 'Portable (Public) Network Graphic', 1, 1);
INSERT INTO xhelp_mimetypes VALUES (83, 'tiff', 'image/tiff', 'Tagged Image Format File', 1, 1);
INSERT INTO xhelp_mimetypes VALUES (84, 'tif', 'image/tif image/x-tif image/tiff image/x-tiff application/tif application/x-tif application/tiff application/x-tiff', 'Tagged Image Format File', 1, 1);
INSERT INTO xhelp_mimetypes VALUES (85, 'ico', 'image/ico image/x-icon application/ico application/x-ico application/x-win-bitmap image/x-win-bitmap application/octet-stream', 'Windows Icon', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (86, 'wbmp', 'image/vnd.wap.wbmp', 'Wireless Bitmap File Format', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (87, 'ras', 'application/ras application/x-ras image/ras', 'Sun Raster Graphic', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (88, 'pnm', 'image/x-portable-anymap', 'PBM Portable Any Map Graphic Bitmap', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (89, 'pbm', 'image/portable bitmap image/x-portable-bitmap image/pbm image/x-pbm', 'UNIX Portable Bitmap Graphic', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (90, 'pgm', 'image/x-portable-graymap image/x-pgm', 'Portable Graymap Graphic', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (91, 'ppm', 'image/x-portable-pixmap application/ppm application/x-ppm image/x-p image/x-ppm', 'PBM Portable Pixelmap Graphic', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (92, 'rgb', 'image/rgb image/x-rgb', 'Silicon Graphics RGB Bitmap', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (93, 'xbm', 'image/x-xpixmap image/x-xbitmap image/xpm image/x-xpm', 'X Bitmap Graphic', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (94, 'xpm', 'image/x-xpixmap', 'BMC Software Patrol UNIX Icon File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (95, 'xwd', 'image/x-xwindowdump image/xwd image/x-xwd application/xwd application/x-xwd', 'X Windows Dump', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (96, 'igs', 'model/iges application/iges application/x-iges application/igs application/x-igs drawing/x-igs image/x-igs', 'Initial Graphics Exchange Specification Format', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (97, 'css', 'application/css-stylesheet text/css', 'Hypertext Cascading Style Sheet', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (98, 'html', 'text/html text/plain', 'Hypertext Markup Language', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (99, 'htm', 'text/html', 'Hypertext Markup Language', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (100, 'txt', 'text/plain application/txt browser/internal', 'Text File', 1, 1);
INSERT INTO xhelp_mimetypes VALUES (101, 'rtf', 'application/rtf application/x-rtf text/rtf text/richtext application/msword application/doc application/x-soffice', 'Rich Text Format File', 1, 1);
INSERT INTO xhelp_mimetypes VALUES (102, 'wml', 'text/vnd.wap.wml text/wml', 'Website META Language File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (103, 'wmls', 'text/vnd.wap.wmlscript', 'WML Script', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (104, 'etx', 'text/x-setext', 'SetText Structure Enhanced Text', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (105, 'xml', 'text/xml application/xml application/x-xml', 'Extensible Markup Language File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (106, 'xsl', 'text/xml', 'XML Stylesheet', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (107, 'php', 'text/php application/x-httpd-php application/php magnus-internal/shellcgi application/x-php', 'PHP Script', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (108, 'php3', 'text/php3 application/x-httpd-php', 'PHP Script', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (109, 'mpeg', 'video/mpeg', 'MPEG Movie', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (110, 'mpg', 'video/mpeg video/mpg video/x-mpg video/mpeg2 application/x-pn-mpg video/x-mpeg video/x-mpeg2a audio/mpeg audio/x-mpeg image/mpg', 'MPEG 1 System Stream', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (111, 'mpe', 'video/mpeg', 'MPEG Movie Clip', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (112, 'qt', 'video/quicktime audio/aiff audio/x-wav video/flc', 'QuickTime Movie', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (113, 'mov', 'video/quicktime video/x-quicktime image/mov audio/aiff audio/x-midi audio/x-wav video/avi', 'QuickTime Video Clip', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (114, 'avi', 'video/avi video/msvideo video/x-msvideo image/avi video/xmpg2 application/x-troff-msvideo audio/aiff audio/avi', 'Audio Video Interleave File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (115, 'movie', 'video/sgi-movie video/x-sgi-movie', 'QuickTime Movie', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (116, 'asf', 'audio/asf application/asx video/x-ms-asf-plugin application/x-mplayer2 video/x-ms-asf application/vnd.ms-asf video/x-ms-asf-plugin video/x-ms-wm video/x-ms-wmx', 'Advanced Streaming Format', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (117, 'asx', 'video/asx application/asx video/x-ms-asf-plugin application/x-mplayer2 video/x-ms-asf application/vnd.ms-asf video/x-ms-asf-plugin video/x-ms-wm video/x-ms-wmx video/x-la-asf', 'Advanced Stream Redirector File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (118, 'wmv', 'video/x-ms-wmv', 'Windows Media File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (119, 'wvx', 'video/x-ms-wvx', 'Windows Media Redirector', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (120, 'wm', 'video/x-ms-wm', 'Windows Media A/V File', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (121, 'wmx', 'video/x-ms-wmx', 'Windows Media Player A/V Shortcut', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (122, 'ice', 'x-conference-xcooltalk', 'Cooltalk Audio', 0, 0);
INSERT INTO xhelp_mimetypes VALUES (123, 'rar', 'application/octet-stream', 'WinRAR Compressed Archive', 0, 0);

# --------------------------------------------------------

#
# Table structure for table `xhelp_responses`
#

CREATE TABLE xhelp_responses (
  id int(11) NOT NULL auto_increment,
  uid int(11) NOT NULL default '0',
  ticketid int(11) NOT NULL default '0',
  message mediumtext NOT NULL,
  timeSpent int(11) NOT NULL default '0',
  updateTime int(11) NOT NULL default '0',
  userIP varchar(255) NOT NULL default '',
  private int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY ticketid (ticketid,uid),
  KEY updateTime (updateTime)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xhelp_responsetemplates`
#

CREATE TABLE xhelp_responsetemplates (
    id int(11) NOT NULL auto_increment,
    uid int(11) NOT NULL default '0',
    name varchar(255) NOT NULL default '',
    response mediumtext NOT NULL,
    PRIMARY KEY (id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xhelp_staff`
#

CREATE TABLE xhelp_staff (
    id int(11) NOT NULL auto_increment,
    uid int(11) NOT NULL default '0',
    email varchar(255) NOT NULL default '',
    responseTime int(11) NOT NULL default '0',
    numReviews int(11) NOT NULL default '0',
    callsClosed int(11) NOT NULL default '0',
    attachSig int(11) NOT NULL default '0',
    rating int(11) NOT NULL default '0',
    allDepartments int(11) NOT NULL default '0',
    ticketsResponded int(11) NOT NULL default '0',
    notify int(11) NOT NULL default '0',
    permTimestamp int(11) NOT NULL default '0',
    PRIMARY KEY (id),
    KEY uid (uid)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xhelp_jstaffdept`
#

CREATE TABLE xhelp_jstaffdept (
    id int(11) NOT NULL auto_increment,
    uid int(11) NOT NULL default '0',
    department int(11) NOT NULL default '0',
    PRIMARY KEY (id),
    KEY uid (uid, department)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xhelp_staffreview`
#

CREATE TABLE xhelp_staffreview (
    id int(11) NOT NULL auto_increment,
    staffid int(11) NOT NULL default '0',
    rating int(11) NOT NULL default '0',
    ticketid int(11) NOT NULL default '0',
    responseid int(11) NOT NULL default '0',
    comments mediumtext,
    submittedBy int(11) NOT NULL default '0',
    userIP varchar(255) NOT NULL default '',
    PRIMARY KEY (id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xhelp_tickets`
#

CREATE TABLE xhelp_tickets (
  id int(11) NOT NULL auto_increment,
  uid int(11) NOT NULL default '0',
  subject varchar(255) NOT NULL default '',
  description mediumtext,
  department int(11) NOT NULL default '0',
  priority int(11) NOT NULL default '0',
  status int(11) NOT NULL default '1',
  posted int(11) NOT NULL default '0',
  lastUpdated int(11) NOT NULL default '0',
  ownership int(11) NOT NULL default '0',
  closedBy int(11) NOT NULL default '0',
  totalTimeSpent int(11) NOT NULL default '0',
  userIP varchar(25) NOT NULL default '',
  serverid int(11) default NULL,
  emailHash varchar(100) default NULL,
  email varchar(100) default NULL,
  overdueTime int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY subject (subject),
  KEY emailHash (emailHash),
  KEY status(status)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xhelp_meta`
#

CREATE TABLE xhelp_meta (
  metakey varchar(50) NOT NULL default '',
  metavalue varchar(255) NOT NULL default '',
  PRIMARY KEY (metakey)
) TYPE=MyISAM;

INSERT INTO xhelp_meta VALUES ('version', '0.78');

# --------------------------------------------------------

#
# Table structure for table `xhelp_roles`
#

CREATE TABLE xhelp_roles (
  id int(11) NOT NULL auto_increment,
  name varchar(35) NOT NULL default '',
  description mediumtext,
  tasks int(11) NOT NULL default '0',
  PRIMARY KEY(id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xhelp_staffroles`
#

CREATE TABLE xhelp_staffroles (
  uid int(11) NOT NULL default '0',
  roleid int(11) NOT NULL default '0',
  deptid int(11) NOT NULL default '0',
  PRIMARY KEY(uid, roleid, deptid)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xhelp_ticket_submit_emails`
#

CREATE TABLE xhelp_ticket_submit_emails (
  ticketid int(11) NOT NULL default '0',
  uid int(11) NOT NULL default '0',
  email varchar(100) NOT NULL default '',
  suppress int(11) NOT NULL default '0',
  PRIMARY KEY(ticketid, email)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xhelp_saved_searches`
#

CREATE TABLE xhelp_saved_searches (
  id int(11) NOT NULL auto_increment,
  uid int(11) NOT NULL default '0',
  name varchar(50) NOT NULL default '',
  search mediumtext NOT NULL,
  pagenav_vars mediumtext NOT NULL,
  hasCustFields int(11) NOT NULL default '0',
  PRIMARY KEY(id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xhelp_status`
#

CREATE TABLE xhelp_status (
  id int(11) NOT NULL auto_increment,
  state int(11) NOT NULL default '0',
  description varchar(50) NOT NULL default '',
  PRIMARY KEY(id),
  KEY state (state)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xhelp_ticket_field_departments`
#

CREATE TABLE xhelp_ticket_field_departments (
  fieldid int(11) NOT NULL default '0',
  deptid int(11) NOT NULL default '0',
  PRIMARY KEY  (fieldid,deptid)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xhelp_ticket_fields`
#

CREATE TABLE xhelp_ticket_fields (
  id int(11) NOT NULL auto_increment,
  name varchar(64) NOT NULL default '',
  description tinytext NOT NULL,
  fieldname varchar(64) NOT NULL default '',
  controltype int(11) NOT NULL default '0',
  datatype varchar(64) NOT NULL default '',
  required tinyint(1) NOT NULL default '0',
  fieldlength int(11) NOT NULL default '0',
  weight int(11) NOT NULL default '0',
  fieldvalues mediumtext NOT NULL,
  defaultvalue varchar(100) NOT NULL default '',
  validation mediumtext NOT NULL,
  PRIMARY KEY  (id),
  KEY weight (weight)
) TYPE=MyISAM; 

# --------------------------------------------------------

#
# Table structure for table `xhelp_ticket_values`
#

CREATE TABLE xhelp_ticket_values (
  ticketid int(11) NOT NULL default '0',
  PRIMARY KEY  (ticketid)
) TYPE=MyISAM; 

# --------------------------------------------------------

#
# Table structure for table `xhelp_notifications`
#

CREATE TABLE xhelp_notifications (
  notif_id int(11) NOT NULL default '0',
  staff_setting int(11) NOT NULL default '0',
  user_setting int(11) NOT NULL default '0',
  staff_options mediumtext NOT NULL,
  PRIMARY KEY (notif_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xhelp_ticket_lists`
#

CREATE TABLE xhelp_ticket_lists (
  id int(11) NOT NULL auto_increment,
  uid int(11) NOT NULL default '0',
  searchid int(11) NOT NULL default '0',
  weight int(11) NOT NULL default '0',
  PRIMARY KEY (id),
  KEY ticketList (uid, searchid)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `xhelp_bayes_categories`
#

CREATE TABLE xhelp_bayes_categories (
  category_id varchar(250) NOT NULL default '',
  probability double NOT NULL default '0',
  word_count bigint(20) NOT NULL default '0',
  PRIMARY KEY  (category_id)
) TYPE=MyISAM;
# --------------------------------------------------------


#
# Table structure for table `xhelp_bayes_wordfreqs`
#

CREATE TABLE xhelp_bayes_wordfreqs (
  word varchar(50) NOT NULL default '',
  category_id varchar(250) NOT NULL default '',
  count bigint(20) NOT NULL default '0',
  PRIMARY KEY  (word,category_id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `xhelp_ticket_solutions`
#

CREATE TABLE xhelp_ticket_solutions (
    id int(11) NOT NULL auto_increment,
    ticketid int(11) NOT NULL,
    url TEXT,
    title varchar(255) NOT NULL,
    description TEXT,
    uid int(11) NOT NULL,
    posted int(11) NOT NULL,
    PRIMARY KEY (id),
    KEY ticketid (ticketid),
    KEY uid (uid)
) TYPE=MyISAM;