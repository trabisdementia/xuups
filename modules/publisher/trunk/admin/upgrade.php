<?php

/**
* $Id: upgrade.php 3436 2008-07-05 10:49:26Z malanciault $
* Module: SmartClient
* Author: The SmartFactory <www.smartfactory.ca>
* Credit : Thanks to the xHelp development team :-)
* Licence: GNU
*/

include_once('admin_header.php');
include_once(PUBLISHER_ROOT_PATH ."/class/dbupdater.php");

$dbupdater = new PublisherDbupdater();

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
        header("Location: ".PUBLISHER_URL . "/admin/index.php");
        break;
}


function checkTables()
{
    global $xoopsModule, $oAdminButton;
    xoops_cp_header();
    publisher_adminmenu(-1, _AM_PUB_DB_CHECKTABLES);
    //1. Determine previous release
    if (!publisher_TableExists('publisher_meta')) {
        $ver = '0.93';
    } else {
        if (!$ver = publisher_GetMeta('version')) {
            echo('Unable to determine previous version.');
        }
    }

    $currentVer = round($xoopsModule->getVar('version') / 100, 2);
    printf('<h2>'._AM_PUB_DB_CURRENTVER.'</h2>', $currentVer);
    printf('<h2>'._AM_PUB_DB_DBVER.'</h2>', $ver);


    if ($ver == $currentVer) {
        //No updates are necessary
        echo '<div>'._AM_PUB_DB_NOUPDATE.'</div>';

    } elseif ( $ver < $currentVer) {
        //Needs to upgrade
        echo '<div>'._AM_PUB_DB_NEEDUPDATE.'</div>';
        echo '<div style="line-height: 20px; font-size: 16px; padding-bottom: 10px; padding-top:10px; color: red; font-weight: bold;">' . _AM_PUB_DB_NEEDUPDATE_WARNING . '</div>';
        echo "<form method=\"post\" action=\"upgrade.php\"><input type=\"hidden\" name=\"op\" value=\"upgradeDB\" /><input type=\"submit\" value=\"". _AM_PUB_DB_UPDATE_NOW . "\" /></form>";
    } else {
        //Tried to downgrade
        echo '<div>'._AM_PUB_DB_NEEDINSTALL.'</div>';
    }

	xoops_cp_footer();
}

function upgradeDB()
{

    global $xoopsModule, $dbupdater;
    $xoopsDB =& Database::getInstance();
    //1. Determine previous release
    //   *** Update this in sql/mysql.sql for each release **
    if (!publisher_TableExists('publisher_meta')) {
        $ver = '0.93';
    } else {
        if (!$ver = publisher_GetMeta('version')) {
            exit(_AM_PUB_DB_VERSION_ERR);
        }
    }

    $mid = $xoopsModule->getVar('mid');

    xoops_cp_header();
    publisher_adminMenu(-1, _AM_PUB_DB_UPDATE_DB);
    echo "<h2>"._AM_PUB_DB_UPDATE_DB."</h2>";
    $ret = true;
    //2. Do All Upgrades necessary to make current
    //   Break statements are omitted on purpose

    switch($ver) {
/// PUBLISHER 0.93 ////////////////////////////////////////////////
    case '0.93':
        set_time_limit(60);
        printf("<h3>". _AM_PUB_DB_UPDATE_TO."</h3>", '1.0' );
        echo "<ul>";

        // Create table publisher_meta
        $table = new PublisherTable('publisher_meta');
        $table->setStructure(	"CREATE TABLE %s (
        						metakey varchar(50) NOT NULL default '',
        						metavalue varchar(255) NOT NULL default '',
        						PRIMARY KEY (metakey))
        						TYPE=MyISAM;");

        $table->setData(sprintf("'version', %s", $xoopsDB->quoteString($ver)));
       	$ret = $ret && $dbupdater->updateTable($table);
        unset($table);

        // Edit fields in publisher_categories
        $table = new PublisherTable('publisher_categories');
        $table->addAlteredField('categoryid', "`categoryid` INT( 11 ) NOT NULL AUTO_INCREMENT");
        $table->addAlteredField('parentid', "`parentid` INT( 11 ) DEFAULT '0' NOT NULL");
       	$ret = $dbupdater->updateTable($table) && $ret;
        unset($table);

        // Edit fields in publisher_items
        $table = new PublisherTable('publisher_items');
        $table->addAlteredField('categoryid', "`categoryid` INT( 11 ) DEFAULT '0' NOT NULL");
        $table->addAlteredField('itemid', "`itemid` INT( 11 ) NOT NULL AUTO_INCREMENT");
       	$ret = $dbupdater->updateTable($table) && $ret;
        unset($table);

        // Edit fields in publisher_files
        $table = new PublisherTable('publisher_files');
        $table->addAlteredField('itemid', "`itemid` INT( 11 ) DEFAULT '0' NOT NULL");
        $table->addAlteredField('fileid', "`fileid` INT( 11 )  NOT NULL AUTO_INCREMENT");
       	$ret = $dbupdater->updateTable($table) && $ret;
        unset($table);
        echo "</ul>";

/// PUBLISHER 1.0 ////////////////////////////////////////////////
    case '1.0':
    	set_time_limit(60);
        printf("<h3>". _AM_PUB_DB_UPDATE_TO."</h3>", '1.01' );
        echo "<ul>";

        // Edit fields in publisher_items
        $table = new PublisherTable('publisher_items');
        $table->addAlteredField('body', "`body` LONGTEXT NOT NULL");
       	$ret = $dbupdater->updateTable($table) && $ret;
        unset($table);

        echo "</ul>";

/// PUBLISHER 1.0.1 ////////////////////////////////////////////////
    case '1.01':
    	set_time_limit(60);
        printf("<h3>". _AM_PUB_DB_UPDATE_TO."</h3>", '1.02' );
        echo "<ul>";

        // Create table publisher_mimetypes
        $table = new PublisherTable('publisher_mimetypes');
        $table->setStructure("CREATE TABLE %s (
  							  mime_id int(11) NOT NULL auto_increment,
  							  mime_ext varchar(60) NOT NULL default '',
  							  mime_types text NOT NULL,
  							  mime_name varchar(255) NOT NULL default '',
  							  mime_admin int(1) NOT NULL default '1',
  							  mime_user int(1) NOT NULL default '0',
  							  KEY mime_id (mime_id)
  							  ) TYPE=MyISAM;");

        $table->setData("1, 'bin', 'application/octet-stream', 'Binary File/Linux Executable', 0, 0");
		$table->setData("2, 'dms', 'application/octet-stream', 'Amiga DISKMASHER Compressed Archive', 0, 0");
		$table->setData("3, 'class', 'application/octet-stream', 'Java Bytecode', 0, 0");
		$table->setData("4, 'so', 'application/octet-stream', 'UNIX Shared Library Function', 0, 0");
		$table->setData("5, 'dll', 'application/octet-stream', 'Dynamic Link Library', 0, 0");
		$table->setData("6, 'hqx', 'application/binhex application/mac-binhex application/mac-binhex40', 'Macintosh BinHex 4 Compressed Archive', 0, 0");
		$table->setData("7, 'cpt', 'application/mac-compactpro application/compact_pro', 'Compact Pro Archive', 0, 0");
		$table->setData("8, 'lha', 'application/lha application/x-lha application/octet-stream application/x-compress application/x-compressed application/maclha', 'Compressed Archive File', 0, 0");
		$table->setData("9, 'lzh', 'application/lzh application/x-lzh application/x-lha application/x-compress application/x-compressed application/x-lzh-archive zz-application/zz-winassoc-lzh application/maclha application/octet-stream', 'Compressed Archive File', 0, 0");
		$table->setData("10, 'sh', 'application/x-shar', 'UNIX shar Archive File', 0, 0");
		$table->setData("11, 'shar', 'application/x-shar', 'UNIX shar Archive File', 0, 0");
		$table->setData("12, 'tar', 'application/tar application/x-tar applicaton/x-gtar multipart/x-tar application/x-compress application/x-compressed', 'Tape Archive File', 0, 0");
		$table->setData("13, 'gtar', 'application/x-gtar', 'GNU tar Compressed File Archive', 0, 0");
		$table->setData("14, 'ustar', 'application/x-ustar multipart/x-ustar', 'POSIX tar Compressed Archive', 0, 0");
		$table->setData("15, 'zip', 'application/zip application/x-zip application/x-zip-compressed application/octet-stream application/x-compress application/x-compressed multipart/x-zip', 'Compressed Archive File', 0, 0");
		$table->setData("16, 'exe', 'application/exe application/x-exe application/dos-exe application/x-winexe application/msdos-windows application/x-msdos-program', 'Executable File', 0, 0");
		$table->setData("17, 'wmz', 'application/x-ms-wmz', 'Windows Media Compressed Skin File', 0, 0");
		$table->setData("18, 'wmd', 'application/x-ms-wmd', 'Windows Media Download File', 0, 0");
		$table->setData("19, 'doc', 'application/msword application/doc appl/text application/vnd.msword application/vnd.ms-word application/winword application/word application/x-msw6 application/x-msword', 'Word Document', 1, 1");
		$table->setData("20, 'pdf', 'application/pdf application/acrobat application/x-pdf applications/vnd.pdf text/pdf', 'Acrobat Portable Document Format', 1, 1");
		$table->setData("21, 'eps', 'application/eps application/postscript application/x-eps image/eps image/x-eps', 'Encapsulated PostScript', 0, 0");
		$table->setData("22, 'ps', 'application/postscript application/ps application/x-postscript application/x-ps text/postscript', 'PostScript', 0, 0");
		$table->setData("23, 'smi', 'application/smil', 'SMIL Multimedia', 0, 0");
		$table->setData("24, 'smil', 'application/smil', 'Synchronized Multimedia Integration Language', 0, 0");
		$table->setData("25, 'wmlc', 'application/vnd.wap.wmlc ', 'Compiled WML Document', 0, 0");
		$table->setData("26, 'wmlsc', 'application/vnd.wap.wmlscriptc', 'Compiled WML Script', 0, 0");
		$table->setData("27, 'vcd', 'application/x-cdlink', 'Virtual CD-ROM CD Image File', 0, 0");
		$table->setData("28, 'pgn', 'application/formstore', 'Picatinny Arsenal Electronic Formstore Form in TIFF Format', 0, 0");
		$table->setData("29, 'cpio', 'application/x-cpio', 'UNIX CPIO Archive', 0, 0");
		$table->setData("30, 'csh', 'application/x-csh', 'Csh Script', 0, 0");
		$table->setData("31, 'dcr', 'application/x-director', 'Shockwave Movie', 0, 0");
		$table->setData("32, 'dir', 'application/x-director', 'Macromedia Director Movie', 0, 0");
		$table->setData("33, 'dxr', 'application/x-director application/vnd.dxr', 'Macromedia Director Protected Movie File', 0, 0");
		$table->setData("34, 'dvi', 'application/x-dvi', 'TeX Device Independent Document', 0, 0");
		$table->setData("35, 'spl', 'application/x-futuresplash', 'Macromedia FutureSplash File', 0, 0");
		$table->setData("36, 'hdf', 'application/x-hdf', 'Hierarchical Data Format File', 0, 0");
		$table->setData("37, 'js', 'application/x-javascript text/javascript', 'JavaScript Source Code', 0, 0");
		$table->setData("38, 'skp', 'application/x-koan application/vnd-koan koan/x-skm application/vnd.koan', 'SSEYO Koan Play File', 0, 0");
		$table->setData("39, 'skd', 'application/x-koan application/vnd-koan koan/x-skm application/vnd.koan', 'SSEYO Koan Design File', 0, 0");
		$table->setData("40, 'skt', 'application/x-koan application/vnd-koan koan/x-skm application/vnd.koan', 'SSEYO Koan Template File', 0, 0");
		$table->setData("41, 'skm', 'application/x-koan application/vnd-koan koan/x-skm application/vnd.koan', 'SSEYO Koan Mix File', 0, 0");
		$table->setData("42, 'latex', 'application/x-latex text/x-latex', 'LaTeX Source Document', 0, 0");
		$table->setData("43, 'nc', 'application/x-netcdf text/x-cdf', 'Unidata netCDF Graphics', 0, 0");
		$table->setData("44, 'cdf', 'application/cdf application/x-cdf application/netcdf application/x-netcdf text/cdf text/x-cdf', 'Channel Definition Format', 0, 0");
		$table->setData("45, 'swf', 'application/x-shockwave-flash application/x-shockwave-flash2-preview application/futuresplash image/vnd.rn-realflash', 'Macromedia Flash Format File', 0, 0");
		$table->setData("46, 'sit', 'application/stuffit application/x-stuffit application/x-sit', 'StuffIt Compressed Archive File', 0, 0");
		$table->setData("47, 'tcl', 'application/x-tcl', 'TCL/TK Language Script', 0, 0");
		$table->setData("48, 'tex', 'application/x-tex', 'LaTeX Source', 0, 0");
		$table->setData("49, 'texinfo', 'application/x-texinfo', 'TeX', 0, 0");
		$table->setData("50, 'texi', 'application/x-texinfo', 'TeX', 0, 0");
		$table->setData("51, 't', 'application/x-troff', 'TAR Tape Archive Without Compression', 0, 0");
		$table->setData("52, 'tr', 'application/x-troff', 'Unix Tape Archive = TAR without compression (tar)', 0, 0");
		$table->setData("53, 'src', 'application/x-wais-source', 'Sourcecode', 0, 0");
		$table->setData("54, 'xhtml', 'application/xhtml+xml', 'Extensible HyperText Markup Language File', 0, 0");
		$table->setData("55, 'xht', 'application/xhtml+xml', 'Extensible HyperText Markup Language File', 0, 0");
		$table->setData("56, 'au', 'audio/basic audio/x-basic audio/au audio/x-au audio/x-pn-au audio/rmf audio/x-rmf audio/x-ulaw audio/vnd.qcelp audio/x-gsm audio/snd', 'ULaw/AU Audio File', 0, 0");
		$table->setData("57, 'XM', 'audio/xm audio/x-xm audio/module-xm audio/mod audio/x-mod', 'Fast Tracker 2 Extended Module', 0, 0");
		$table->setData("58, 'snd', 'audio/basic', 'Macintosh Sound Resource', 0, 0");
		$table->setData("59, 'mid', 'audio/mid audio/m audio/midi audio/x-midi application/x-midi audio/soundtrack', 'Musical Instrument Digital Interface MIDI-sequention Sound', 0, 0");
		$table->setData("60, 'midi', 'audio/mid audio/m audio/midi audio/x-midi application/x-midi', 'Musical Instrument Digital Interface MIDI-sequention Sound', 0, 0");
		$table->setData("61, 'kar', 'audio/midi audio/x-midi audio/mid x-music/x-midi', 'Karaoke MIDI File', 0, 0");
		$table->setData("62, 'mpga', 'audio/mpeg audio/mp3 audio/mgp audio/m-mpeg audio/x-mp3 audio/x-mpeg audio/x-mpg video/mpeg', 'Mpeg-1 Layer3 Audio Stream', 0, 0");
		$table->setData("63, 'mp2', 'video/mpeg audio/mpeg', 'MPEG Audio Stream, Layer II', 0, 0");
		$table->setData("64, 'mp3', 'audio/mpeg audio/x-mpeg audio/mp3 audio/x-mp3 audio/mpeg3 audio/x-mpeg3 audio/mpg audio/x-mpg audio/x-mpegaudio', 'MPEG Audio Stream, Layer III', 0, 0");
		$table->setData("65, 'aif', 'audio/aiff audio/x-aiff sound/aiff audio/rmf audio/x-rmf audio/x-pn-aiff audio/x-gsm audio/x-midi audio/vnd.qcelp', 'Audio Interchange File', 0, 0");
		$table->setData("66, 'aiff', 'audio/aiff audio/x-aiff sound/aiff audio/rmf audio/x-rmf audio/x-pn-aiff audio/x-gsm audio/mid audio/x-midi audio/vnd.qcelp', 'Audio Interchange File', 0, 0");
		$table->setData("67, 'aifc', 'audio/aiff audio/x-aiff audio/x-aifc sound/aiff audio/rmf audio/x-rmf audio/x-pn-aiff audio/x-gsm audio/x-midi audio/mid audio/vnd.qcelp', 'Audio Interchange File', 0, 0");
		$table->setData("68, 'm3u', 'audio/x-mpegurl audio/mpeg-url application/x-winamp-playlist audio/scpls audio/x-scpls', 'MP3 Playlist File', 0, 0");
		$table->setData("69, 'ram', 'audio/x-pn-realaudio audio/vnd.rn-realaudio audio/x-pm-realaudio-plugin audio/x-pn-realvideo audio/x-realaudio video/x-pn-realvideo text/plain', 'RealMedia Metafile', 0, 0");
		$table->setData("70, 'rm', 'application/vnd.rn-realmedia audio/vnd.rn-realaudio audio/x-pn-realaudio audio/x-realaudio audio/x-pm-realaudio-plugin', 'RealMedia Streaming Media', 0, 0");
		$table->setData("71, 'rpm', 'audio/x-pn-realaudio audio/x-pn-realaudio-plugin audio/x-pnrealaudio-plugin video/x-pn-realvideo-plugin audio/x-mpegurl application/octet-stream', 'RealMedia Player Plug-in', 0, 0");
		$table->setData("72, 'ra', 'audio/vnd.rn-realaudio audio/x-pn-realaudio audio/x-realaudio audio/x-pm-realaudio-plugin video/x-pn-realvideo', 'RealMedia Streaming Media', 0, 0");
		$table->setData("73, 'wav', 'audio/wav audio/x-wav audio/wave audio/x-pn-wav', 'Waveform Audio', 0, 0");
		$table->setData("74, 'wax', ' audio/x-ms-wax', 'Windows Media Audio Redirector', 0, 0");
		$table->setData("75, 'wma', 'audio/x-ms-wma video/x-ms-asf', 'Windows Media Audio File', 0, 0");
		$table->setData("76, 'bmp', 'image/bmp image/x-bmp image/x-bitmap image/x-xbitmap image/x-win-bitmap image/x-windows-bmp image/ms-bmp image/x-ms-bmp application/bmp application/x-bmp application/x-win-bitmap application/preview', 'Windows OS/2 Bitmap Graphics', 1, 1");
		$table->setData("77, 'gif', 'image/gif image/x-xbitmap image/gi_', 'Graphic Interchange Format', 1, 1");
		$table->setData("78, 'ief', 'image/ief', 'Image File - Bitmap graphics', 0, 0");
		$table->setData("79, 'jpeg', 'image/jpeg image/jpg image/jpe_ image/pjpeg image/vnd.swiftview-jpeg', 'JPEG/JIFF Image', 1, 1");
		$table->setData("80, 'jpg', 'image/jpeg image/jpg image/jp_ application/jpg application/x-jpg image/pjpeg image/pipeg image/vnd.swiftview-jpeg image/x-xbitmap', 'JPEG/JIFF Image', 1, 1");
		$table->setData("81, 'jpe', 'image/jpeg', 'JPEG/JIFF Image', 1, 1");
		$table->setData("82, 'png', 'image/png application/png application/x-png', 'Portable (Public) Network Graphic', 1, 1");
		$table->setData("83, 'tiff', 'image/tiff', 'Tagged Image Format File', 1, 1");
		$table->setData("84, 'tif', 'image/tif image/x-tif image/tiff image/x-tiff application/tif application/x-tif application/tiff application/x-tiff', 'Tagged Image Format File', 1, 1");
		$table->setData("85, 'ico', 'image/ico image/x-icon application/ico application/x-ico application/x-win-bitmap image/x-win-bitmap application/octet-stream', 'Windows Icon', 0, 0");
		$table->setData("86, 'wbmp', 'image/vnd.wap.wbmp', 'Wireless Bitmap File Format', 0, 0");
		$table->setData("87, 'ras', 'application/ras application/x-ras image/ras', 'Sun Raster Graphic', 0, 0");
		$table->setData("88, 'pnm', 'image/x-portable-anymap', 'PBM Portable Any Map Graphic Bitmap', 0, 0");
		$table->setData("89, 'pbm', 'image/portable bitmap image/x-portable-bitmap image/pbm image/x-pbm', 'UNIX Portable Bitmap Graphic', 0, 0");
		$table->setData("90, 'pgm', 'image/x-portable-graymap image/x-pgm', 'Portable Graymap Graphic', 0, 0");
		$table->setData("91, 'ppm', 'image/x-portable-pixmap application/ppm application/x-ppm image/x-p image/x-ppm', 'PBM Portable Pixelmap Graphic', 0, 0");
		$table->setData("92, 'rgb', 'image/rgb image/x-rgb', 'Silicon Graphics RGB Bitmap', 0, 0");
		$table->setData("93, 'xbm', 'image/x-xpixmap image/x-xbitmap image/xpm image/x-xpm', 'X Bitmap Graphic', 0, 0");
		$table->setData("94, 'xpm', 'image/x-xpixmap', 'BMC Software Patrol UNIX Icon File', 0, 0");
		$table->setData("95, 'xwd', 'image/x-xwindowdump image/xwd image/x-xwd application/xwd application/x-xwd', 'X Windows Dump', 0, 0");
		$table->setData("96, 'igs', 'model/iges application/iges application/x-iges application/igs application/x-igs drawing/x-igs image/x-igs', 'Initial Graphics Exchange Specification Format', 0, 0");
		$table->setData("97, 'css', 'application/css-stylesheet text/css', 'Hypertext Cascading Style Sheet', 0, 0");
		$table->setData("98, 'html', 'text/html text/plain', 'Hypertext Markup Language', 0, 0");
		$table->setData("99, 'htm', 'text/html', 'Hypertext Markup Language', 0, 0");
		$table->setData("100, 'txt', 'text/plain application/txt browser/internal', 'Text File', 1, 1");
		$table->setData("101, 'rtf', 'application/rtf application/x-rtf text/rtf text/richtext application/msword application/doc application/x-soffice', 'Rich Text Format File', 1, 1");
		$table->setData("102, 'wml', 'text/vnd.wap.wml text/wml', 'Website META Language File', 0, 0");
		$table->setData("103, 'wmls', 'text/vnd.wap.wmlscript', 'WML Script', 0, 0");
		$table->setData("104, 'etx', 'text/x-setext', 'SetText Structure Enhanced Text', 0, 0");
		$table->setData("105, 'xml', 'text/xml application/xml application/x-xml', 'Extensible Markup Language File', 0, 0");
		$table->setData("106, 'xsl', 'text/xml', 'XML Stylesheet', 0, 0");
		$table->setData("107, 'php', 'text/php application/x-httpd-php application/php magnus-internal/shellcgi application/x-php', 'PHP Script', 0, 0");
		$table->setData("108, 'php3', 'text/php3 application/x-httpd-php', 'PHP Script', 0, 0");
		$table->setData("109, 'mpeg', 'video/mpeg', 'MPEG Movie', 0, 0");
		$table->setData("110, 'mpg', 'video/mpeg video/mpg video/x-mpg video/mpeg2 application/x-pn-mpg video/x-mpeg video/x-mpeg2a audio/mpeg audio/x-mpeg image/mpg', 'MPEG 1 System Stream', 0, 0");
		$table->setData("111, 'mpe', 'video/mpeg', 'MPEG Movie Clip', 0, 0");
		$table->setData("112, 'qt', 'video/quicktime audio/aiff audio/x-wav video/flc', 'QuickTime Movie', 0, 0");
		$table->setData("113, 'mov', 'video/quicktime video/x-quicktime image/mov audio/aiff audio/x-midi audio/x-wav video/avi', 'QuickTime Video Clip', 0, 0");
		$table->setData("114, 'avi', 'video/avi video/msvideo video/x-msvideo image/avi video/xmpg2 application/x-troff-msvideo audio/aiff audio/avi', 'Audio Video Interleave File', 0, 0");
		$table->setData("115, 'movie', 'video/sgi-movie video/x-sgi-movie', 'QuickTime Movie', 0, 0");
		$table->setData("116, 'asf', 'audio/asf application/asx video/x-ms-asf-plugin application/x-mplayer2 video/x-ms-asf application/vnd.ms-asf video/x-ms-asf-plugin video/x-ms-wm video/x-ms-wmx', 'Advanced Streaming Format', 0, 0");
		$table->setData("117, 'asx', 'video/asx application/asx video/x-ms-asf-plugin application/x-mplayer2 video/x-ms-asf application/vnd.ms-asf video/x-ms-asf-plugin video/x-ms-wm video/x-ms-wmx video/x-la-asf', 'Advanced Stream Redirector File', 0, 0");
		$table->setData("118, 'wmv', 'video/x-ms-wmv', 'Windows Media File', 0, 0");
		$table->setData("119, 'wvx', 'video/x-ms-wvx', 'Windows Media Redirector', 0, 0");
		$table->setData("120, 'wm', 'video/x-ms-wm', 'Windows Media A/V File', 0, 0");
		$table->setData("121, 'wmx', 'video/x-ms-wmx', 'Windows Media Player A/V Shortcut', 0, 0");
		$table->setData("122, 'ice', 'x-conference-xcooltalk', 'Cooltalk Audio', 0, 0");
		$table->setData("123, 'rar', 'application/octet-stream', 'WinRAR Compressed Archive', 0, 0");

       	$ret = $ret && $dbupdater->updateTable($table);
        unset($table);

        echo "</ul>";

/// PUBLISHER 1.0.2 ////////////////////////////////////////////////
    case '1.02':
    	set_time_limit(60);
        printf("<h3>". _AM_PUB_DB_UPDATE_TO."</h3>", '1.03' );
        echo "<ul>";

        // Add field Address in items table
        $table = new PublisherTable('publisher_items');
        $table->addNewField('address', "varchar(255) NOT NULL default ''");

       	$ret = $ret && $dbupdater->updateTable($table);
        unset($table);

        echo "</ul>";


/// PUBLISHER 1.0.3 ////////////////////////////////////////////////
       case '1.03':
    	set_time_limit(60);
        printf("<h3>". _AM_PUB_DB_UPDATE_TO."</h3>", '1.04' );
        echo "<ul>";

        // Drop field adress in items table
        $table = new PublisherTable('publisher_items');
        $table->addDropedField('address');

       	$ret = $ret && $dbupdater->updateTable($table);
        unset($table);

        echo "</ul>";

/// PUBLISHER 1.0.4 ////////////////////////////////////////////////
       case '1.04':
    	set_time_limit(60);
        printf("<h3>". _AM_PUB_DB_UPDATE_TO."</h3>", '1.05' );
        echo "<ul>";

        echo "<li>No database changes are needed</li>";

        echo "</ul>";

/// PUBLISHER 1.0.5 ////////////////////////////////////////////////
       case '1.05':
    	set_time_limit(60);
        printf("<h3>". _AM_PUB_DB_UPDATE_TO."</h3>", '1.1' );
        echo "<ul>";

		echo "<li>No database changes are needed</li>";

        echo "</ul>";

/// PUBLISHER 1.1 ////////////////////////////////////////////////
       case '1.1':
    	set_time_limit(60);
        printf("<h3>". _AM_PUB_DB_UPDATE_TO."</h3>", '2.0' );
        echo "<ul>";

        // Add field template
        $table = new PublisherTable('publisher_categories');
        $table->addNewField('template', "varchar(255) NOT NULL default ''");

       	$ret = $ret && $dbupdater->updateTable($table);
        unset($table);

        // Create mimetypes table if not already created
        if (!publisher_TableExists('publisher_mimetypes')) {
	        // Create table publisher_mimetypes
	        $table = new PublisherTable('publisher_mimetypes');
	        $table->setStructure("CREATE TABLE %s (
	  							  mime_id int(11) NOT NULL auto_increment,
	  							  mime_ext varchar(60) NOT NULL default '',
	  							  mime_types text NOT NULL,
	  							  mime_name varchar(255) NOT NULL default '',
	  							  mime_admin int(1) NOT NULL default '1',
	  							  mime_user int(1) NOT NULL default '0',
	  							  KEY mime_id (mime_id)
	  							  ) TYPE=MyISAM;");

	        $table->setData("1, 'bin', 'application/octet-stream', 'Binary File/Linux Executable', 0, 0");
			$table->setData("2, 'dms', 'application/octet-stream', 'Amiga DISKMASHER Compressed Archive', 0, 0");
			$table->setData("3, 'class', 'application/octet-stream', 'Java Bytecode', 0, 0");
			$table->setData("4, 'so', 'application/octet-stream', 'UNIX Shared Library Function', 0, 0");
			$table->setData("5, 'dll', 'application/octet-stream', 'Dynamic Link Library', 0, 0");
			$table->setData("6, 'hqx', 'application/binhex application/mac-binhex application/mac-binhex40', 'Macintosh BinHex 4 Compressed Archive', 0, 0");
			$table->setData("7, 'cpt', 'application/mac-compactpro application/compact_pro', 'Compact Pro Archive', 0, 0");
			$table->setData("8, 'lha', 'application/lha application/x-lha application/octet-stream application/x-compress application/x-compressed application/maclha', 'Compressed Archive File', 0, 0");
			$table->setData("9, 'lzh', 'application/lzh application/x-lzh application/x-lha application/x-compress application/x-compressed application/x-lzh-archive zz-application/zz-winassoc-lzh application/maclha application/octet-stream', 'Compressed Archive File', 0, 0");
			$table->setData("10, 'sh', 'application/x-shar', 'UNIX shar Archive File', 0, 0");
			$table->setData("11, 'shar', 'application/x-shar', 'UNIX shar Archive File', 0, 0");
			$table->setData("12, 'tar', 'application/tar application/x-tar applicaton/x-gtar multipart/x-tar application/x-compress application/x-compressed', 'Tape Archive File', 0, 0");
			$table->setData("13, 'gtar', 'application/x-gtar', 'GNU tar Compressed File Archive', 0, 0");
			$table->setData("14, 'ustar', 'application/x-ustar multipart/x-ustar', 'POSIX tar Compressed Archive', 0, 0");
			$table->setData("15, 'zip', 'application/zip application/x-zip application/x-zip-compressed application/octet-stream application/x-compress application/x-compressed multipart/x-zip', 'Compressed Archive File', 0, 0");
			$table->setData("16, 'exe', 'application/exe application/x-exe application/dos-exe application/x-winexe application/msdos-windows application/x-msdos-program', 'Executable File', 0, 0");
			$table->setData("17, 'wmz', 'application/x-ms-wmz', 'Windows Media Compressed Skin File', 0, 0");
			$table->setData("18, 'wmd', 'application/x-ms-wmd', 'Windows Media Download File', 0, 0");
			$table->setData("19, 'doc', 'application/msword application/doc appl/text application/vnd.msword application/vnd.ms-word application/winword application/word application/x-msw6 application/x-msword', 'Word Document', 1, 1");
			$table->setData("20, 'pdf', 'application/pdf application/acrobat application/x-pdf applications/vnd.pdf text/pdf', 'Acrobat Portable Document Format', 1, 1");
			$table->setData("21, 'eps', 'application/eps application/postscript application/x-eps image/eps image/x-eps', 'Encapsulated PostScript', 0, 0");
			$table->setData("22, 'ps', 'application/postscript application/ps application/x-postscript application/x-ps text/postscript', 'PostScript', 0, 0");
			$table->setData("23, 'smi', 'application/smil', 'SMIL Multimedia', 0, 0");
			$table->setData("24, 'smil', 'application/smil', 'Synchronized Multimedia Integration Language', 0, 0");
			$table->setData("25, 'wmlc', 'application/vnd.wap.wmlc ', 'Compiled WML Document', 0, 0");
			$table->setData("26, 'wmlsc', 'application/vnd.wap.wmlscriptc', 'Compiled WML Script', 0, 0");
			$table->setData("27, 'vcd', 'application/x-cdlink', 'Virtual CD-ROM CD Image File', 0, 0");
			$table->setData("28, 'pgn', 'application/formstore', 'Picatinny Arsenal Electronic Formstore Form in TIFF Format', 0, 0");
			$table->setData("29, 'cpio', 'application/x-cpio', 'UNIX CPIO Archive', 0, 0");
			$table->setData("30, 'csh', 'application/x-csh', 'Csh Script', 0, 0");
			$table->setData("31, 'dcr', 'application/x-director', 'Shockwave Movie', 0, 0");
			$table->setData("32, 'dir', 'application/x-director', 'Macromedia Director Movie', 0, 0");
			$table->setData("33, 'dxr', 'application/x-director application/vnd.dxr', 'Macromedia Director Protected Movie File', 0, 0");
			$table->setData("34, 'dvi', 'application/x-dvi', 'TeX Device Independent Document', 0, 0");
			$table->setData("35, 'spl', 'application/x-futuresplash', 'Macromedia FutureSplash File', 0, 0");
			$table->setData("36, 'hdf', 'application/x-hdf', 'Hierarchical Data Format File', 0, 0");
			$table->setData("37, 'js', 'application/x-javascript text/javascript', 'JavaScript Source Code', 0, 0");
			$table->setData("38, 'skp', 'application/x-koan application/vnd-koan koan/x-skm application/vnd.koan', 'SSEYO Koan Play File', 0, 0");
			$table->setData("39, 'skd', 'application/x-koan application/vnd-koan koan/x-skm application/vnd.koan', 'SSEYO Koan Design File', 0, 0");
			$table->setData("40, 'skt', 'application/x-koan application/vnd-koan koan/x-skm application/vnd.koan', 'SSEYO Koan Template File', 0, 0");
			$table->setData("41, 'skm', 'application/x-koan application/vnd-koan koan/x-skm application/vnd.koan', 'SSEYO Koan Mix File', 0, 0");
			$table->setData("42, 'latex', 'application/x-latex text/x-latex', 'LaTeX Source Document', 0, 0");
			$table->setData("43, 'nc', 'application/x-netcdf text/x-cdf', 'Unidata netCDF Graphics', 0, 0");
			$table->setData("44, 'cdf', 'application/cdf application/x-cdf application/netcdf application/x-netcdf text/cdf text/x-cdf', 'Channel Definition Format', 0, 0");
			$table->setData("45, 'swf', 'application/x-shockwave-flash application/x-shockwave-flash2-preview application/futuresplash image/vnd.rn-realflash', 'Macromedia Flash Format File', 0, 0");
			$table->setData("46, 'sit', 'application/stuffit application/x-stuffit application/x-sit', 'StuffIt Compressed Archive File', 0, 0");
			$table->setData("47, 'tcl', 'application/x-tcl', 'TCL/TK Language Script', 0, 0");
			$table->setData("48, 'tex', 'application/x-tex', 'LaTeX Source', 0, 0");
			$table->setData("49, 'texinfo', 'application/x-texinfo', 'TeX', 0, 0");
			$table->setData("50, 'texi', 'application/x-texinfo', 'TeX', 0, 0");
			$table->setData("51, 't', 'application/x-troff', 'TAR Tape Archive Without Compression', 0, 0");
			$table->setData("52, 'tr', 'application/x-troff', 'Unix Tape Archive = TAR without compression (tar)', 0, 0");
			$table->setData("53, 'src', 'application/x-wais-source', 'Sourcecode', 0, 0");
			$table->setData("54, 'xhtml', 'application/xhtml+xml', 'Extensible HyperText Markup Language File', 0, 0");
			$table->setData("55, 'xht', 'application/xhtml+xml', 'Extensible HyperText Markup Language File', 0, 0");
			$table->setData("56, 'au', 'audio/basic audio/x-basic audio/au audio/x-au audio/x-pn-au audio/rmf audio/x-rmf audio/x-ulaw audio/vnd.qcelp audio/x-gsm audio/snd', 'ULaw/AU Audio File', 0, 0");
			$table->setData("57, 'XM', 'audio/xm audio/x-xm audio/module-xm audio/mod audio/x-mod', 'Fast Tracker 2 Extended Module', 0, 0");
			$table->setData("58, 'snd', 'audio/basic', 'Macintosh Sound Resource', 0, 0");
			$table->setData("59, 'mid', 'audio/mid audio/m audio/midi audio/x-midi application/x-midi audio/soundtrack', 'Musical Instrument Digital Interface MIDI-sequention Sound', 0, 0");
			$table->setData("60, 'midi', 'audio/mid audio/m audio/midi audio/x-midi application/x-midi', 'Musical Instrument Digital Interface MIDI-sequention Sound', 0, 0");
			$table->setData("61, 'kar', 'audio/midi audio/x-midi audio/mid x-music/x-midi', 'Karaoke MIDI File', 0, 0");
			$table->setData("62, 'mpga', 'audio/mpeg audio/mp3 audio/mgp audio/m-mpeg audio/x-mp3 audio/x-mpeg audio/x-mpg video/mpeg', 'Mpeg-1 Layer3 Audio Stream', 0, 0");
			$table->setData("63, 'mp2', 'video/mpeg audio/mpeg', 'MPEG Audio Stream, Layer II', 0, 0");
			$table->setData("64, 'mp3', 'audio/mpeg audio/x-mpeg audio/mp3 audio/x-mp3 audio/mpeg3 audio/x-mpeg3 audio/mpg audio/x-mpg audio/x-mpegaudio', 'MPEG Audio Stream, Layer III', 0, 0");
			$table->setData("65, 'aif', 'audio/aiff audio/x-aiff sound/aiff audio/rmf audio/x-rmf audio/x-pn-aiff audio/x-gsm audio/x-midi audio/vnd.qcelp', 'Audio Interchange File', 0, 0");
			$table->setData("66, 'aiff', 'audio/aiff audio/x-aiff sound/aiff audio/rmf audio/x-rmf audio/x-pn-aiff audio/x-gsm audio/mid audio/x-midi audio/vnd.qcelp', 'Audio Interchange File', 0, 0");
			$table->setData("67, 'aifc', 'audio/aiff audio/x-aiff audio/x-aifc sound/aiff audio/rmf audio/x-rmf audio/x-pn-aiff audio/x-gsm audio/x-midi audio/mid audio/vnd.qcelp', 'Audio Interchange File', 0, 0");
			$table->setData("68, 'm3u', 'audio/x-mpegurl audio/mpeg-url application/x-winamp-playlist audio/scpls audio/x-scpls', 'MP3 Playlist File', 0, 0");
			$table->setData("69, 'ram', 'audio/x-pn-realaudio audio/vnd.rn-realaudio audio/x-pm-realaudio-plugin audio/x-pn-realvideo audio/x-realaudio video/x-pn-realvideo text/plain', 'RealMedia Metafile', 0, 0");
			$table->setData("70, 'rm', 'application/vnd.rn-realmedia audio/vnd.rn-realaudio audio/x-pn-realaudio audio/x-realaudio audio/x-pm-realaudio-plugin', 'RealMedia Streaming Media', 0, 0");
			$table->setData("71, 'rpm', 'audio/x-pn-realaudio audio/x-pn-realaudio-plugin audio/x-pnrealaudio-plugin video/x-pn-realvideo-plugin audio/x-mpegurl application/octet-stream', 'RealMedia Player Plug-in', 0, 0");
			$table->setData("72, 'ra', 'audio/vnd.rn-realaudio audio/x-pn-realaudio audio/x-realaudio audio/x-pm-realaudio-plugin video/x-pn-realvideo', 'RealMedia Streaming Media', 0, 0");
			$table->setData("73, 'wav', 'audio/wav audio/x-wav audio/wave audio/x-pn-wav', 'Waveform Audio', 0, 0");
			$table->setData("74, 'wax', ' audio/x-ms-wax', 'Windows Media Audio Redirector', 0, 0");
			$table->setData("75, 'wma', 'audio/x-ms-wma video/x-ms-asf', 'Windows Media Audio File', 0, 0");
			$table->setData("76, 'bmp', 'image/bmp image/x-bmp image/x-bitmap image/x-xbitmap image/x-win-bitmap image/x-windows-bmp image/ms-bmp image/x-ms-bmp application/bmp application/x-bmp application/x-win-bitmap application/preview', 'Windows OS/2 Bitmap Graphics', 1, 1");
			$table->setData("77, 'gif', 'image/gif image/x-xbitmap image/gi_', 'Graphic Interchange Format', 1, 1");
			$table->setData("78, 'ief', 'image/ief', 'Image File - Bitmap graphics', 0, 0");
			$table->setData("79, 'jpeg', 'image/jpeg image/jpg image/jpe_ image/pjpeg image/vnd.swiftview-jpeg', 'JPEG/JIFF Image', 1, 1");
			$table->setData("80, 'jpg', 'image/jpeg image/jpg image/jp_ application/jpg application/x-jpg image/pjpeg image/pipeg image/vnd.swiftview-jpeg image/x-xbitmap', 'JPEG/JIFF Image', 1, 1");
			$table->setData("81, 'jpe', 'image/jpeg', 'JPEG/JIFF Image', 1, 1");
			$table->setData("82, 'png', 'image/png application/png application/x-png', 'Portable (Public) Network Graphic', 1, 1");
			$table->setData("83, 'tiff', 'image/tiff', 'Tagged Image Format File', 1, 1");
			$table->setData("84, 'tif', 'image/tif image/x-tif image/tiff image/x-tiff application/tif application/x-tif application/tiff application/x-tiff', 'Tagged Image Format File', 1, 1");
			$table->setData("85, 'ico', 'image/ico image/x-icon application/ico application/x-ico application/x-win-bitmap image/x-win-bitmap application/octet-stream', 'Windows Icon', 0, 0");
			$table->setData("86, 'wbmp', 'image/vnd.wap.wbmp', 'Wireless Bitmap File Format', 0, 0");
			$table->setData("87, 'ras', 'application/ras application/x-ras image/ras', 'Sun Raster Graphic', 0, 0");
			$table->setData("88, 'pnm', 'image/x-portable-anymap', 'PBM Portable Any Map Graphic Bitmap', 0, 0");
			$table->setData("89, 'pbm', 'image/portable bitmap image/x-portable-bitmap image/pbm image/x-pbm', 'UNIX Portable Bitmap Graphic', 0, 0");
			$table->setData("90, 'pgm', 'image/x-portable-graymap image/x-pgm', 'Portable Graymap Graphic', 0, 0");
			$table->setData("91, 'ppm', 'image/x-portable-pixmap application/ppm application/x-ppm image/x-p image/x-ppm', 'PBM Portable Pixelmap Graphic', 0, 0");
			$table->setData("92, 'rgb', 'image/rgb image/x-rgb', 'Silicon Graphics RGB Bitmap', 0, 0");
			$table->setData("93, 'xbm', 'image/x-xpixmap image/x-xbitmap image/xpm image/x-xpm', 'X Bitmap Graphic', 0, 0");
			$table->setData("94, 'xpm', 'image/x-xpixmap', 'BMC Software Patrol UNIX Icon File', 0, 0");
			$table->setData("95, 'xwd', 'image/x-xwindowdump image/xwd image/x-xwd application/xwd application/x-xwd', 'X Windows Dump', 0, 0");
			$table->setData("96, 'igs', 'model/iges application/iges application/x-iges application/igs application/x-igs drawing/x-igs image/x-igs', 'Initial Graphics Exchange Specification Format', 0, 0");
			$table->setData("97, 'css', 'application/css-stylesheet text/css', 'Hypertext Cascading Style Sheet', 0, 0");
			$table->setData("98, 'html', 'text/html text/plain', 'Hypertext Markup Language', 0, 0");
			$table->setData("99, 'htm', 'text/html', 'Hypertext Markup Language', 0, 0");
			$table->setData("100, 'txt', 'text/plain application/txt browser/internal', 'Text File', 1, 1");
			$table->setData("101, 'rtf', 'application/rtf application/x-rtf text/rtf text/richtext application/msword application/doc application/x-soffice', 'Rich Text Format File', 1, 1");
			$table->setData("102, 'wml', 'text/vnd.wap.wml text/wml', 'Website META Language File', 0, 0");
			$table->setData("103, 'wmls', 'text/vnd.wap.wmlscript', 'WML Script', 0, 0");
			$table->setData("104, 'etx', 'text/x-setext', 'SetText Structure Enhanced Text', 0, 0");
			$table->setData("105, 'xml', 'text/xml application/xml application/x-xml', 'Extensible Markup Language File', 0, 0");
			$table->setData("106, 'xsl', 'text/xml', 'XML Stylesheet', 0, 0");
			$table->setData("107, 'php', 'text/php application/x-httpd-php application/php magnus-internal/shellcgi application/x-php', 'PHP Script', 0, 0");
			$table->setData("108, 'php3', 'text/php3 application/x-httpd-php', 'PHP Script', 0, 0");
			$table->setData("109, 'mpeg', 'video/mpeg', 'MPEG Movie', 0, 0");
			$table->setData("110, 'mpg', 'video/mpeg video/mpg video/x-mpg video/mpeg2 application/x-pn-mpg video/x-mpeg video/x-mpeg2a audio/mpeg audio/x-mpeg image/mpg', 'MPEG 1 System Stream', 0, 0");
			$table->setData("111, 'mpe', 'video/mpeg', 'MPEG Movie Clip', 0, 0");
			$table->setData("112, 'qt', 'video/quicktime audio/aiff audio/x-wav video/flc', 'QuickTime Movie', 0, 0");
			$table->setData("113, 'mov', 'video/quicktime video/x-quicktime image/mov audio/aiff audio/x-midi audio/x-wav video/avi', 'QuickTime Video Clip', 0, 0");
			$table->setData("114, 'avi', 'video/avi video/msvideo video/x-msvideo image/avi video/xmpg2 application/x-troff-msvideo audio/aiff audio/avi', 'Audio Video Interleave File', 0, 0");
			$table->setData("115, 'movie', 'video/sgi-movie video/x-sgi-movie', 'QuickTime Movie', 0, 0");
			$table->setData("116, 'asf', 'audio/asf application/asx video/x-ms-asf-plugin application/x-mplayer2 video/x-ms-asf application/vnd.ms-asf video/x-ms-asf-plugin video/x-ms-wm video/x-ms-wmx', 'Advanced Streaming Format', 0, 0");
			$table->setData("117, 'asx', 'video/asx application/asx video/x-ms-asf-plugin application/x-mplayer2 video/x-ms-asf application/vnd.ms-asf video/x-ms-asf-plugin video/x-ms-wm video/x-ms-wmx video/x-la-asf', 'Advanced Stream Redirector File', 0, 0");
			$table->setData("118, 'wmv', 'video/x-ms-wmv', 'Windows Media File', 0, 0");
			$table->setData("119, 'wvx', 'video/x-ms-wvx', 'Windows Media Redirector', 0, 0");
			$table->setData("120, 'wm', 'video/x-ms-wm', 'Windows Media A/V File', 0, 0");
			$table->setData("121, 'wmx', 'video/x-ms-wmx', 'Windows Media Player A/V Shortcut', 0, 0");
			$table->setData("122, 'ice', 'x-conference-xcooltalk', 'Cooltalk Audio', 0, 0");
			$table->setData("123, 'rar', 'application/octet-stream', 'WinRAR Compressed Archive', 0, 0");

	       	$ret = $ret && $dbupdater->updateTable($table);
	        unset($table);
        }

        // Add header template in categories
        $table = new PublisherTable('publisher_categories');
        $table->addNewField('header', "TEXT NOT NULL");

       	$ret = $ret && $dbupdater->updateTable($table);
        unset($table);

        echo "</ul>";


/// PUBLISHER 2.0 ////////////////////////////////////////////////
       case '2.0':
    	set_time_limit(60);
        printf("<h3>". _AM_PUB_DB_UPDATE_TO."</h3>", '2.1' );
        echo "<ul>";

        // Add fields in publisher_categories
        $table = new PublisherTable('publisher_categories');
        $table->addNewField('meta_keywords', "TEXT NOT NULL");
        $table->addNewField('meta_description', "TEXT NOT NULL");
        $table->addNewField('short_url', "VARCHAR(255) NOT NULL");
        $ret = $dbupdater->updateTable($table);
        unset($table);

        // Add fields in publisher_items
        $table = new PublisherTable('publisher_items');
        $table->addNewField('meta_keywords', "TEXT NOT NULL");
        $table->addNewField('meta_description', "TEXT NOT NULL");
        $table->addNewField('short_url', "VARCHAR(255) NOT NULL");
        $ret = $dbupdater->updateTable($table);
        unset($table);

        // Automatically create meta tag infos
        global $publisher_category_handler, $publisher_item_handler;
        $categoriesObj = $publisher_category_handler->getObjects();
        foreach ($categoriesObj as $categoryObj) {
			$categoryObj->store();
			echo "<li>Meta tags info automatically generated for category '<em>" . $categoryObj->name() . "</em>'</li>";
        }

        $itemsObj = $publisher_item_handler->getObjects();
        foreach ($itemsObj as $itemObj) {
			$itemObj->store();
			echo "<li>Meta tags info automatically generated for article '<em>" . $itemObj->title() . "</em>'</li>";
        }

        echo "</ul>";

		case '2.1':
    	set_time_limit(60);
        printf("<h3>". _AM_PUB_DB_UPDATE_TO."</h3>", '2.11' );
        echo "<ul>";

        // Add fields in publisher_items
        $table = new PublisherTable('publisher_items');
        $table->addNewField('partial_view', "int(1) NOT NULL default '0'");
        $ret = $dbupdater->updateTable($table);
        unset($table);

        echo "</ul>";

    }

    $newversion = round($xoopsModule->getVar('version') / 100, 2);
    //if successful, update publisher_meta table with new ver
    if ($ret) {
        printf(_AM_PUB_DB_UPDATE_OK, $newversion);
        $ret = publisher_SetMeta('version', $newversion);
    } else {
        printf(_AM_PUB_DB_UPDATE_ERR, $newversion);
    }


	xoops_cp_footer();
}
?>