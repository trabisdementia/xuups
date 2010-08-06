# phpMyAdmin SQL Dump
# version 2.6.1
# http://www.phpmyadmin.net
# 
# Host: localhost
# Generation Time: May 18, 2005 at 09:44 PM
# Server version: 4.0.15
# PHP Version: 4.3.3
# 
# Database: `smart`
# 

# --------------------------------------------------------

# 
# Table structure for table `smartmedia_categories`
# 

CREATE TABLE `smartmedia_categories` (
  `categoryid` int(11) NOT NULL auto_increment,
  `parentid` int(11) NOT NULL default '0',
  `weight` int(11) NOT NULL default '0',
  `image` varchar(50) NOT NULL default '',
  `default_languageid` varchar(50) NOT NULL default 'english',
  PRIMARY KEY  (`categoryid`)
) TYPE=MyISAM ;

# 
# Dumping data for table `smartmedia_categories`
# 

# --------------------------------------------------------

# 
# Table structure for table `smartmedia_categories_text`
# 

CREATE TABLE `smartmedia_categories_text` (
  `categoryid` int(11) NOT NULL auto_increment,
  `languageid` varchar(50) NOT NULL default '',
  `title` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `meta_description` text NOT NULL,
  PRIMARY KEY  (`categoryid`,`languageid`)
) TYPE=MyISAM ;

# 
# Dumping data for table `smartmedia_categories_text`
# 

# --------------------------------------------------------

# 
# Table structure for table `smartmedia_clips`
# 

CREATE TABLE `smartmedia_clips` (
  `clipid` int(11) NOT NULL auto_increment,
  `folderid` int(11) NOT NULL default '0',
  `statusid` int(11) NOT NULL default '1',
  `created_date` int(11) NOT NULL default '0',
  `created_uid` int(11) NOT NULL default '0',
  `modified_date` int(11) NOT NULL default '0',
  `modified_uid` int(11) NOT NULL default '0',
  `languageid` varchar(50) NOT NULL default '',
  `duration` int(11) NOT NULL default '0',
  `formatid` int(11) NOT NULL default '0',
  `width` int(11) NOT NULL default '0',
  `height` int(11) NOT NULL default '0',
  `autostart` int(11) NOT NULL default '0',
  `image_hr` varchar(50) NOT NULL default '',
  `image_lr` varchar(50) NOT NULL default '',
  `file_hr` text NOT NULL,
  `file_lr` text NOT NULL,
  `weight` int(11) NOT NULL default '0',
  `counter` int(11) NOT NULL default '0',
  `default_languageid` varchar(50) NOT NULL default 'english',
  PRIMARY KEY  (`clipid`)
) TYPE=MyISAM ;

# --------------------------------------------------------

# 
# Table structure for table `smartmedia_clips_text`
# 

CREATE TABLE `smartmedia_clips_text` (
  `clipid` int(11) NOT NULL default '0',
  `languageid` varchar(50) NOT NULL default '',
  `title` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `meta_description` text NOT NULL,
  `tab_caption_1` varchar(50) NOT NULL default '',
  `tab_text_1` text NOT NULL,
  `tab_caption_2` varchar(50) NOT NULL default '',
  `tab_text_2` text NOT NULL,
  `tab_caption_3` varchar(50) NOT NULL default '',
  `tab_text_3` text NOT NULL,
  PRIMARY KEY  (`clipid`,`languageid`)
) TYPE=MyISAM;

# 
# Dumping data for table `smartmedia_clips_text`
# 

# --------------------------------------------------------

# 
# Table structure for table `smartmedia_folders`
# 

CREATE TABLE `smartmedia_folders` (
  `folderid` int(11) NOT NULL auto_increment,
  `statusid` int(11) NOT NULL default '0',
  `created_uid` int(11) NOT NULL default '0',
  `created_date` int(11) NOT NULL default '0',
  `modified_uid` int(11) NOT NULL default '0',
  `modified_date` int(11) NOT NULL default '0',
  `weight` int(11) NOT NULL default '0',
  `image_hr` varchar(50) NOT NULL default '',
  `image_lr` varchar(50) NOT NULL default '',
  `counter` int(11) NOT NULL default '0',
  `default_languageid` varchar(50) NOT NULL default 'english',
  PRIMARY KEY  (`folderid`)
) TYPE=MyISAM ;

# 
# Dumping data for table `smartmedia_folders`
# 

# --------------------------------------------------------

# 
# Table structure for table `smartmedia_folders_categories`
# 

CREATE TABLE `smartmedia_folders_categories` (
  `categoryid` int(11) NOT NULL default '0',
  `folderid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`categoryid`,`folderid`)
) TYPE=MyISAM;

# 
# Dumping data for table `smartmedia_folders_categories`
# 

# --------------------------------------------------------

# 
# Table structure for table `smartmedia_folders_text`
# 

CREATE TABLE `smartmedia_folders_text` (
  `folderid` int(11) NOT NULL default '0',
  `languageid` varchar(50) NOT NULL default '',
  `title` varchar(100) NOT NULL default '',
  `short_title` varchar(50) NOT NULL default '',
  `summary` text NOT NULL,
  `description` text NOT NULL,
  `meta_description` text NOT NULL,
  PRIMARY KEY  (`folderid`,`languageid`)
) TYPE=MyISAM;

# 
# Dumping data for table `smartmedia_folders_text`
# 

# --------------------------------------------------------

# 
# Table structure for table `smartmedia_formats`
# 

CREATE TABLE `smartmedia_formats` (
  `formatid` int(11) NOT NULL auto_increment,
  `template` text NOT NULL,
  `format` varchar(50) NOT NULL default '',
  `ext` char(3) NOT NULL default '',
  PRIMARY KEY  (`formatid`)
) TYPE=MyISAM AUTO_INCREMENT=8 ;

# 
# Dumping data for table `smartmedia_formats`
# 

INSERT INTO `smartmedia_formats` VALUES (1, '<object id="MediaPlayer" width="{CLIP_WIDTH}" height="{CLIP_HEIGHT}" classid="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95" standby="Loading Windows Media Player components..." type="application/x-oleobject">\r\n	<param name="FileName" value="{CLIP_URL}" valuetype="ref" ref />\r\n	<param name="AudioStream" value="1" />\r\n	<param name="AutoSize" value="0" />\r\n	<param name="AutoStart" value="{CLIP_AUTOSTART}" />\r\n	<param name="AnimationAtStart" value="0" />\r\n	<param name="AllowScan" value="-1" />\r\n	<param name="AllowChangeDisplaySize" value="-1" />\r\n	<param name="AutoRewind" value="0" />\r\n	<param name="Balance" value="0" />\r\n	<param name="BaseURL" value />\r\n	<param name="BufferingTime" value="5" />\r\n	<param name="CaptioningID" value />\r\n	<param name="ClickToPlay" value="-1" />\r\n	<param name="CursorType" value="0" />\r\n	<param name="CurrentPosition" value="-1" />\r\n	<param name="CurrentMarker" value="0" />\r\n	<param name="DefaultFrame" value />\r\n	<param name="DisplayBackColor" value="0" />\r\n	<param name="DisplayForeColor" value="16777215" />\r\n	<param name="DisplayMode" value="1" />\r\n	<param name="DisplaySize" value="2" />\r\n	<param name="Enabled" value="-1" />\r\n	<param name="EnableContextMenu" value="-1" />\r\n	<param name="EnablePositionControls" value="-1" />\r\n	<param name="EnableFullScreenControls" value="-1" />\r\n	<param name="EnableTracker" value="-1" />\r\n	<param name="InvokeURLs" value="-1" />\r\n	<param name="Language" value="-1" />\r\n	<param name="Mute" value="0" />\r\n	<param name="PlayCount" value="1" />\r\n	<param name="PreviewMode" value="0" />\r\n	<param name="Rate" value="1" />\r\n	<param name="SAMILang" value />\r\n	<param name="SAMIStyle" value />\r\n	<param name="SAMIFileName" value />\r\n	<param name="SelectionStart" value="-1" />\r\n	<param name="SelectionEnd" value="-1" />\r\n	<param name="SendOpenStateChangeEvents" value="-1" />\r\n	<param name="SendWarningEvents" value="-1" />\r\n	<param name="SendErrorEvents" value="-1" />\r\n	<param name="SendKeyboardEvents" value="0" />\r\n	<param name="SendMouseClickEvents" value="0" />\r\n	<param name="SendMouseMoveEvents" value="0" />\r\n	<param name="SendPlayStateChangeEvents" value="-1" />\r\n	<param name="ShowCaptioning" value="0" />\r\n	<param name="ShowControls" value="-1" />\r\n	<param name="ShowAudioControls" value="-1" />\r\n	<param name="ShowDisplay" value="-1" />\r\n	<param name="ShowGotoBar" value="0" />\r\n	<param name="ShowPositionControls" value="0" />\r\n	<param name="ShowStatusBar" value="-1" />\r\n	<param name="ShowTracker" value="-1" />\r\n	<param name="TransparentAtStart" value="0" />\r\n	<param name="VideoBorderWidth" value="5" />\r\n	<param name="VideoBorderColor" value="333333" />\r\n	<param name="VideoBorder3D" value="-1" />\r\n	<param name="Volume" value="-1" />\r\n	<param name="WindowlessVideo" value="-1" />\r\n	<embed \r\n		type="application/x-mplayer2" \r\n		pluginspage="http://www.microsoft.com/windows/mediaplayer/" \r\n		width="{CLIP_WIDTH}" \r\n		height="{CLIP_HEIGHT}" \r\n		src="{CLIP_URL}" \r\n		name="player" \r\n		autostart="{CLIP_AUTOSTART}" \r\n		showcontrols="1" \r\n		showstatusbar="1" \r\n		showdisplay="1">\r\n	</embed>\r\n</object>', 'Windows Media Player Movie', 'wmv');
INSERT INTO `smartmedia_formats` VALUES (2, '<OBJECT CLASSID="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B"\r\n    WIDTH="{CLIP_WIDTH}"\r\n    HEIGHT="{CLIP_HEIGHT}"\r\n    CODEBASE="http://www.apple.com/qtactivex/qtplugin.cab">\r\n  	<PARAM name="SRC" VALUE="{CLIP_URL}" />\r\n	<PARAM name="AUTOPLAY" VALUE="false" />\r\n	<PARAM name="CONTROLLER" VALUE="true" />\r\n  	<EMBED SRC="{CLIP_URL}"\r\n 		WIDTH="{CLIP_WIDTH}"\r\n		HEIGHT="{CLIP_HEIGHT}"\r\n		AUTOPLAY="{CLIP_AUTOPLAY}"\r\n		CONTROLLER="true"\r\n		PLUGINSPAGE="http://www.apple.com/quicktime/download/">\r\n	</EMBED>\r\n</OBJECT>', 'QuickTime Movie', 'mov');
INSERT INTO `smartmedia_formats` VALUES (3, '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" height="{CLIP_HEIGHT}" width="{CLIP_WIDTH}">\r\n	<param name="movie" value="{CLIP_URL}" />\r\n	<param name="quality" value="best" />\r\n	<param name="play" value="{CLIP_AUTOPLAY}" />\r\n	<embed \r\n		height="{CLIP_HEIGHT}" \r\n		pluginspage="http://www.macromedia.com/go/getflashplayer" \r\n		src="{CLIP_URL}" \r\n		type="application/x-shockwave-flash" \r\n		width="{CLIP_WIDTH}" \r\n		quality="best" \r\n		play="{CLIP_URL}" />\r\n	</embed>\r\n</object>', 'Flash', 'swf');
INSERT INTO `smartmedia_formats` VALUES (4, '<object id="MediaPlayer1" classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab# Version=5,1,52,701" standby="Loading Microsoft Windows® Media Player components..." type="application/x-oleobject" width="{CLIP_WIDTH}" height="{CLIP_HEIGHT}">\r\n	<param name="fileName" value="{CLIP_URL}" />\r\n	<param name="animationatStart" value="true" />\r\n	<param name="transparentatStart" value="true" />\r\n	<param name="autoStart" value="{CLIP_AUTOSTART}" />\r\n	<param name="showControls" value="true" />\r\n	<param name="Volume" value="-300" />\r\n	<embed \r\n		type="application/x-mplayer2" \r\n		pluginspage="http://www.microsoft.com/Windows/MediaPlayer/" \r\n		src="{CLIP_URL}" \r\n		name="MediaPlayer1" \r\n		width="{CLIP_WIDTH}" \r\n		height="{CLIP_HEIGHT}" \r\n		autostart="{CLIP_AUTOSTART}" \r\n		showcontrols="1" volume="-300">\r\n	</embed>\r\n</object>', 'Windows Media Player Audio', 'wma');
INSERT INTO `smartmedia_formats` VALUES (5, '<object id="RVOCX" classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" width="{CLIP_WIDTH}" height="{CLIP_HEIGHT}">\r\n	<param name="src" value="{CLIP_URL}" />\r\n	<param name="autostart" value="{CLIP_AUTOSTART}" />\r\n	<param name="controls" value="all" />\r\n	<param name="console" value="audio" />\r\n	<embed \r\n		type="audio/x-pn-realaudio-plugin" \r\n		src="{CLIP_URL}" \r\n		width="{CLIP_WIDTH}" \r\n		height="{CLIP_HEIGHT}" \r\n		autostart="{CLIP_AUTOSTART}" \r\n		controls="all" \r\n		console="audio">\r\n	</embed>\r\n</object>', 'Real Player Audio', 'rm');
INSERT INTO `smartmedia_formats` VALUES (6, '<object id="RVOCX" classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" width="{CLIP_WIDTH}" height="{CLIP_HEIGHT}">\r\n	<param name="src" value="{CLIP_URL}" />\r\n	<param name="autostart" value="{CLIP_AUTOSTART}" />\r\n	<param name="controls" value="imagewindow,all" />\r\n	<param name="console" value="video" />\r\n	<embed \r\n		type="audio/x-pn-realaudio-plugin" \r\n		src="{CLIP_URL}" \r\n		width="{CLIP_WIDTH}" \r\n		height="{CLIP_HEIGHT}" \r\n		autostart="{CLIP_AUTOSTART}" \r\n		controls="imagewindow,all" \r\n		console="video">\r\n	</embed>\r\n</object>', 'Real Player Video', 'rm');
INSERT INTO `smartmedia_formats` VALUES (7, '<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="{CLIP_WIDTH}" height="{CLIP_HEIGHT}"  codebase="http://www.apple.com/qtactivex/qtplugin.cab#version=6,0,2,0">\\\r\n	<param name="type" value="{CLIP_URL}" />\r\n	<param name="autoplay" value="{CLIP_AUTOPLAY}" />\r\n	<param name="target" value="myself" />\r\n	<param name="src" value="{CLIP_URL}" />\r\n	<param name="href" value="{CLIP_URL}" />\r\n	<param name="pluginspage" value="http://www.apple.com/quicktime/download/indext.html" />\r\n	<param name="ShowControls" value="1" />\r\n	<param name="ShowStatusBar" value="1" />\r\n	<param name="showdisplay" value="0" />\r\n	<embed \r\n		width="{CLIP_WIDTH}" \r\n		height="{CLIP_HEIGHT}" \r\n		src="{CLIP_URL}" \r\n		href="{CLIP_URL}" \r\n		type="video/quicktime" \r\n		target="myself" \r\n		border="0" \r\n		showcontrols="1" \r\n		showdisplay="0" \r\n		showstatusbar="1" \r\n		autoplay="{CLIP_AUTOPLAY}" \r\n		pluginspage="http://www.apple.com/quicktime/download/indext.html">\r\n	</embed>\r\n</object>', 'QuickTime Audio', 'mov');

# --------------------------------------------------------

# 
# Table structure for table `smartmedia_status`
# 

CREATE TABLE `smartmedia_status` (
  `statusid` int(11) NOT NULL auto_increment,
  `status` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`statusid`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

# 
# Dumping data for table `smartmedia_status`
# 

INSERT INTO `smartmedia_status` VALUES (1, 'Offline');
INSERT INTO `smartmedia_status` VALUES (2, 'Online');

#
# Table structure for table `smartmedia_meta`
#

CREATE TABLE `smartmedia_meta` (
  `metakey` varchar(50) NOT NULL default '',
  `metavalue` varchar(255) NOT NULL default '',
  PRIMARY KEY (`metakey`)
) TYPE=MyISAM;

INSERT INTO smartmedia_meta VALUES ('version', '0.85');

