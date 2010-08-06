<?php

/**
 * $Id: upgrade.php,v 1.5 2005/06/02 17:08:49 fx2024 Exp $
 * Module: SmartClient
 * Author: The SmartFactory <www.smartfactory.ca>
 * Credit : Thanks to the xHelp development team :-)
 * Licence: GNU
 */

include_once('admin_header.php');
include_once(SMARTMEDIA_ROOT_PATH . "class/dbupdater.php");

$dbupdater = new SmartmediaDbupdater();

global $xoopsModule;
$module_id = $xoopsModule->getVar('mid');

$op = 'default';

if ( isset( $_REQUEST['op'] ) )
{
    $op = $_REQUEST['op'];
}

switch ( $op )
{
    case "checkTables":
        checkTables();
        break;

    case "upgradeDB":
        upgradeDB();
        break;

    default:
        header("Location: ".SMARTMEDIA_URL."admin/index.php");
        break;
}


function checkTables()
{
    global $xoopsModule, $oAdminButton;
    xoops_cp_header();
    smartmedia_adminmenu(-1, _AM_SMEDIA_DB_CHECKTABLES);
    //1. Determine previous release
    if (!smartmedia_TableExists('smartmedia_meta')) {
        $ver = '0.75';
    } else {
        if (!$ver = smartmedia_GetMeta('version')) {
            echo('Unable to determine previous version.');
        }
    }

    $currentVer = round($xoopsModule->getVar('version') / 100, 2);

    printf('<h2>'._AM_SMEDIA_DB_CURRENTVER.'</h2>', $currentVer);
    printf('<h2>'._AM_SMEDIA_DB_DBVER.'</h2>', $ver);


    if ($ver == $currentVer) {
        //No updates are necessary
        echo '<div>'._AM_SMEDIA_DB_NOUPDATE.'</div>';

    } elseif ( $ver < $currentVer) {
        //Needs to upgrade
        echo '<div>'._AM_SMEDIA_DB_NEEDUPDATE.'</div>';
        echo "<form method=\"post\" action=\"upgrade.php\"><input type=\"hidden\" name=\"op\" value=\"upgradeDB\" /><input type=\"submit\" value=\"". _AM_SMEDIA_DB_UPDATE_NOW . "\" /></form>";
    } else {
        //Tried to downgrade
        echo '<div>'._AM_SMEDIA_DB_NEEDINSTALL.'</div>';
    }

    smartmedia_modFooter();
    xoops_cp_footer();
}

function upgradeDB()
{

    global $xoopsModule, $dbupdater;
    $xoopsDB =& Database::getInstance();
    //1. Determine previous release
    //   *** Update this in sql/mysql.sql for each release **
    if (!smartmedia_TableExists('smartmedia_meta')) {
        $ver = '0.75';
    } else {
        if (!$ver = smartmedia_GetMeta('version')) {
            exit(_AM_SMEDIA_DB_VERSION_ERR);
        }
    }

    $mid = $xoopsModule->getVar('mid');

    xoops_cp_header();
    smartmedia_adminMenu(-1, _AM_SMEDIA_DB_UPDATE_DB);
    echo "<h2>"._AM_SMEDIA_DB_UPDATE_DB."</h2>";
    $ret = true;
    //2. Do All Upgrades necessary to make current
    //   Break statements are omitted on purpose

    switch($ver) {
        case '0.75':
            set_time_limit(60);
            printf("<h3>". _AM_SMEDIA_DB_UPDATE_TO."</h3>", '0.85' );
            echo "<ul>";

            // Create table smartmedia_meta
            $table = new SmartmediaTable('smartmedia_meta');
            $table->setStructure(	"CREATE TABLE %s (
        						metakey varchar(50) NOT NULL default '', 
        						metavalue varchar(255) NOT NULL default '', 
        						PRIMARY KEY (metakey)) 
        						TYPE=MyISAM;");

            $table->setData(sprintf("'version', %s", $xoopsDB->quoteString($ver)));
            $ret = $ret && $dbupdater->updateTable($table);
            unset($table);

            // Add fields in smartmedia_clips
            $table = new SmartmediaTable('smartmedia_clips');
            $table->addAlteredField('statusid', "INT( 11 ) DEFAULT '1' NOT NULL");
            $table->addAlteredField('created_date', "INT( 11 ) DEFAULT '0' NOT NULL");
            $table->addAlteredField('created_uid', "INT( 11 ) DEFAULT '0' NOT NULL");
            $table->addAlteredField('modified_uid', "INT( 11 ) DEFAULT '0' NOT NULL");
            $table->addAlteredField('modified_date', "INT( 11 ) DEFAULT '0' NOT NULL");
            $table->addAlteredField('width', "INT( 11 ) DEFAULT '0' NOT NULL");
            $table->addAlteredField('height', "INT( 11 ) DEFAULT '0' NOT NULL");
            $table->addAlteredField('autostart', "INT( 11 ) DEFAULT '0' NOT NULL");
            $table->addAlteredField('counter', "INT( 11 ) DEFAULT '0' NOT NULL");

            // Drop fields in smartmedia_clips
            $table->addDropedField('resolutionid');
            $ret = $dbupdater->updateTable($table) && $ret;
            unset($table);

            // Add counter in smartmedia_folders
            $table = new SmartmediaTable('smartmedia_folders');
            $table->addAlteredField('counter', "INT( 11 ) DEFAULT '0' NOT NULL");
            $ret = $dbupdater->updateTable($table) && $ret;
            unset($table);

            //Drop table smartmedia_resolutions
            $table = new SmartmediaTable('smartmedia_resolutions');
            $table->setFlagForDrop();
            $ret = $dbupdater->updateTable($table) && $ret;
            unset($table);

            // Drop table smartmedia_languages
            $table = new SmartmediaTable('smartmedia_languages');
            $table->setFlagForDrop();
            $ret = $dbupdater->updateTable($table) && $ret;
            unset($table);
             
            // Drop table smartmedia_formats
            $table = new SmartmediaTable('smartmedia_formats');
            $table->setFlagForDrop();
            $ret = $dbupdater->updateTable($table) && $ret;
            unset($table);

            // Create table format
            $table = new SmartmediaTable('smartmedia_formats');
            $table->setStructure("CREATE TABLE %s (
  								`formatid` int(11) NOT NULL auto_increment,
  								`template` text NOT NULL,
  								`format` varchar(50) NOT NULL default '',
  								`ext` char(3) NOT NULL default '',
  								PRIMARY KEY  (`formatid`)
								) TYPE=MyISAM AUTO_INCREMENT=8 ;");
            $table->setData('1, \'<object id="MediaPlayer" width="{CLIP_WIDTH}" height="{CLIP_HEIGHT}" classid="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95" standby="Loading Windows Media Player components..." type="application/x-oleobject">\r\n	<param name="FileName" value="{CLIP_URL}" valuetype="ref" ref />\r\n	<param name="AudioStream" value="1" />\r\n	<param name="AutoSize" value="0" />\r\n	<param name="AutoStart" value="{CLIP_AUTOSTART}" />\r\n	<param name="AnimationAtStart" value="0" />\r\n	<param name="AllowScan" value="-1" />\r\n	<param name="AllowChangeDisplaySize" value="-1" />\r\n	<param name="AutoRewind" value="0" />\r\n	<param name="Balance" value="0" />\r\n	<param name="BaseURL" value />\r\n	<param name="BufferingTime" value="5" />\r\n	<param name="CaptioningID" value />\r\n	<param name="ClickToPlay" value="-1" />\r\n	<param name="CursorType" value="0" />\r\n	<param name="CurrentPosition" value="-1" />\r\n	<param name="CurrentMarker" value="0" />\r\n	<param name="DefaultFrame" value />\r\n	<param name="DisplayBackColor" value="0" />\r\n	<param name="DisplayForeColor" value="16777215" />\r\n	<param name="DisplayMode" value="1" />\r\n	<param name="DisplaySize" value="2" />\r\n	<param name="Enabled" value="-1" />\r\n	<param name="EnableContextMenu" value="-1" />\r\n	<param name="EnablePositionControls" value="-1" />\r\n	<param name="EnableFullScreenControls" value="-1" />\r\n	<param name="EnableTracker" value="-1" />\r\n	<param name="InvokeURLs" value="-1" />\r\n	<param name="Language" value="-1" />\r\n	<param name="Mute" value="0" />\r\n	<param name="PlayCount" value="1" />\r\n	<param name="PreviewMode" value="0" />\r\n	<param name="Rate" value="1" />\r\n	<param name="SAMILang" value />\r\n	<param name="SAMIStyle" value />\r\n	<param name="SAMIFileName" value />\r\n	<param name="SelectionStart" value="-1" />\r\n	<param name="SelectionEnd" value="-1" />\r\n	<param name="SendOpenStateChangeEvents" value="-1" />\r\n	<param name="SendWarningEvents" value="-1" />\r\n	<param name="SendErrorEvents" value="-1" />\r\n	<param name="SendKeyboardEvents" value="0" />\r\n	<param name="SendMouseClickEvents" value="0" />\r\n	<param name="SendMouseMoveEvents" value="0" />\r\n	<param name="SendPlayStateChangeEvents" value="-1" />\r\n	<param name="ShowCaptioning" value="0" />\r\n	<param name="ShowControls" value="-1" />\r\n	<param name="ShowAudioControls" value="-1" />\r\n	<param name="ShowDisplay" value="-1" />\r\n	<param name="ShowGotoBar" value="0" />\r\n	<param name="ShowPositionControls" value="0" />\r\n	<param name="ShowStatusBar" value="-1" />\r\n	<param name="ShowTracker" value="-1" />\r\n	<param name="TransparentAtStart" value="0" />\r\n	<param name="VideoBorderWidth" value="5" />\r\n	<param name="VideoBorderColor" value="333333" />\r\n	<param name="VideoBorder3D" value="-1" />\r\n	<param name="Volume" value="-1" />\r\n	<param name="WindowlessVideo" value="-1" />\r\n	<embed \r\n		type="application/x-mplayer2" \r\n		pluginspage="http://www.microsoft.com/windows/mediaplayer/" \r\n		width="{CLIP_WIDTH}" \r\n		height="{CLIP_HEIGHT}" \r\n		src="{CLIP_URL}" \r\n		name="player" \r\n		autostart="{CLIP_AUTOSTART}" \r\n		showcontrols="1" \r\n		showstatusbar="1" \r\n		showdisplay="1">\r\n	</embed>\r\n</object>\', \'Windows Media Player Movie\', \'wmv\'');
            $table->setData('2, \'<OBJECT CLASSID="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B"\r\n    WIDTH="{CLIP_WIDTH}"\r\n    HEIGHT="{CLIP_HEIGHT}"\r\n    CODEBASE="http://www.apple.com/qtactivex/qtplugin.cab">\r\n  	<PARAM name="SRC" VALUE="{CLIP_URL}" />\r\n	<PARAM name="AUTOPLAY" VALUE="false" />\r\n	<PARAM name="CONTROLLER" VALUE="true" />\r\n  	<EMBED SRC="{CLIP_URL}"\r\n 		WIDTH="{CLIP_WIDTH}"\r\n		HEIGHT="{CLIP_HEIGHT}"\r\n		AUTOPLAY="{CLIP_AUTOPLAY}"\r\n		CONTROLLER="true"\r\n		PLUGINSPAGE="http://www.apple.com/quicktime/download/">\r\n	</EMBED>\r\n</OBJECT>\', \'QuickTime Movie\', \'mov\'');
            $table->setData('3, \'<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" height="{CLIP_HEIGHT}" width="{CLIP_WIDTH}">\r\n	<param name="movie" value="{CLIP_URL}" />\r\n	<param name="quality" value="best" />\r\n	<param name="play" value="{CLIP_AUTOPLAY}" />\r\n	<embed \r\n		height="{CLIP_HEIGHT}" \r\n		pluginspage="http://www.macromedia.com/go/getflashplayer" \r\n		src="{CLIP_URL}" \r\n		type="application/x-shockwave-flash" \r\n		width="{CLIP_WIDTH}" \r\n		quality="best" \r\n		play="{CLIP_URL}" />\r\n	</embed>\r\n</object>\', \'Flash\', \'swf\'');
            $table->setData('4, \'<object id="MediaPlayer1" classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab# Version=5,1,52,701" standby="Loading Microsoft Windows® Media Player components..." type="application/x-oleobject" width="{CLIP_WIDTH}" height="{CLIP_HEIGHT}">\r\n	<param name="fileName" value="{CLIP_URL}" />\r\n	<param name="animationatStart" value="true" />\r\n	<param name="transparentatStart" value="true" />\r\n	<param name="autoStart" value="{CLIP_AUTOSTART}" />\r\n	<param name="showControls" value="true" />\r\n	<param name="Volume" value="-300" />\r\n	<embed \r\n		type="application/x-mplayer2" \r\n		pluginspage="http://www.microsoft.com/Windows/MediaPlayer/" \r\n		src="{CLIP_URL}" \r\n		name="MediaPlayer1" \r\n		width="{CLIP_WIDTH}" \r\n		height="{CLIP_HEIGHT}" \r\n		autostart="{CLIP_AUTOSTART}" \r\n		showcontrols="1" volume="-300">\r\n	</embed>\r\n</object>\', \'Windows Media Player Audio\', \'wma\'');
            $table->setData('5, \'<object id="RVOCX" classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" width="{CLIP_WIDTH}" height="{CLIP_HEIGHT}">\r\n	<param name="src" value="{CLIP_URL}" />\r\n	<param name="autostart" value="{CLIP_AUTOSTART}" />\r\n	<param name="controls" value="all" />\r\n	<param name="console" value="audio" />\r\n	<embed \r\n		type="audio/x-pn-realaudio-plugin" \r\n		src="{CLIP_URL}" \r\n		width="{CLIP_WIDTH}" \r\n		height="{CLIP_HEIGHT}" \r\n		autostart="{CLIP_AUTOSTART}" \r\n		controls="all" \r\n		console="audio">\r\n	</embed>\r\n</object>\', \'Real Player Audio\', \'rm\'');
            $table->setData('6, \'<object id="RVOCX" classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" width="{CLIP_WIDTH}" height="{CLIP_HEIGHT}">\r\n	<param name="src" value="{CLIP_URL}" />\r\n	<param name="autostart" value="{CLIP_AUTOSTART}" />\r\n	<param name="controls" value="imagewindow,all" />\r\n	<param name="console" value="video" />\r\n	<embed \r\n		type="audio/x-pn-realaudio-plugin" \r\n		src="{CLIP_URL}" \r\n		width="{CLIP_WIDTH}" \r\n		height="{CLIP_HEIGHT}" \r\n		autostart="{CLIP_AUTOSTART}" \r\n		controls="imagewindow,all" \r\n		console="video">\r\n	</embed>\r\n</object>\', \'Real Player Video\', \'rm\'');
            $table->setData('7, \'<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="{CLIP_WIDTH}" height="{CLIP_HEIGHT}"  codebase="http://www.apple.com/qtactivex/qtplugin.cab#version=6,0,2,0">\\\r\n	<param name="type" value="{CLIP_URL}" />\r\n	<param name="autoplay" value="{CLIP_AUTOPLAY}" />\r\n	<param name="target" value="myself" />\r\n	<param name="src" value="{CLIP_URL}" />\r\n	<param name="href" value="{CLIP_URL}" />\r\n	<param name="pluginspage" value="http://www.apple.com/quicktime/download/indext.html" />\r\n	<param name="ShowControls" value="1" />\r\n	<param name="ShowStatusBar" value="1" />\r\n	<param name="showdisplay" value="0" />\r\n	<embed \r\n		width="{CLIP_WIDTH}" \r\n		height="{CLIP_HEIGHT}" \r\n		src="{CLIP_URL}" \r\n		href="{CLIP_URL}" \r\n		type="video/quicktime" \r\n		target="myself" \r\n		border="0" \r\n		showcontrols="1" \r\n		showdisplay="0" \r\n		showstatusbar="1" \r\n		autoplay="{CLIP_AUTOPLAY}" \r\n		pluginspage="http://www.apple.com/quicktime/download/indext.html">\r\n	</embed>\r\n</object>\', \'QuickTime Audio\', \'mov\'');
            $ret = $dbupdater->updateTable($table) && $ret;
            unset($table);

            // Set the current date for created_date and modified_date and uid to admin
            $time= time();
            $table = new SmartmediaTable('smartmedia_clips');
            $table->addUpdatedField('created_date', $time);
            $table->addUpdatedField('created_uid', '1');
            $table->addUpdatedField('modified_date', $time);
            $table->addUpdatedField('modified_uid', '1');
            $ret = $dbupdater->updateTable($table) && $ret;
            unset($table);

            //set good format
            $clip_handler =& smartmedia_gethandler('clip');
            $clip_handler->updateAll('formatid', 2);
            echo "</ul>";
    }

    $newversion = round($xoopsModule->getVar('version') / 100, 2);
    //if successful, update smartmedia_meta table with new ver
    if ($ret) {
        printf(_AM_SMEDIA_DB_UPDATE_OK, $newversion);
        $ret = smartmedia_SetMeta('version', $newversion);
    } else {
        printf(_AM_SMEDIA_DB_UPDATE_ERR, $newversion);
    }

    smartmedia_modFooter();
    xoops_cp_footer();
}
?>