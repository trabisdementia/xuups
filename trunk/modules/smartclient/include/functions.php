<?php

/**
 * $Id: functions.php,v 1.8 2005/05/09 17:52:05 malanciault Exp $
 * Module: SmartClient
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

function smartclient_highlighter ($matches) {
    //$color=getmoduleoption('highlightcolor');
    $smartConfig =& smartclient_getModuleConfig();
    $color = $smartConfig['highlight_color'];
    if(substr($color,0,1)!='#') {
        $color='#'.$color;
    }
    return '<span style="font-weight: bolder; background-color: '.$color.';">' . $matches[0] . '</span>';
}

function smartclient_getAllowedMimeTypes()
{
    return array('jpg/jpeg', 'image/bmp', 'image/gif', 'image/jpeg', 'image/jpg', 'image/x-png', 'image/png', 'image/pjpeg');
}

/**
 * Copy a file, or a folder and its contents
 *
 * @author      Aidan Lister <aidan@php.net>
 * @version     1.0.0
 * @param       string   $source    The source
 * @param       string   $dest      The destination
 * @return      bool     Returns true on success, false on failure
 */
function smartclient_copyr($source, $dest)
{
    // Simple copy for a file
    if (is_file($source)) {
        return copy($source, $dest);
    }

    // Make destination directory
    if (!is_dir($dest)) {
        mkdir($dest);
    }

    // Loop through the folder
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }

        // Deep copy directories
        if (is_dir("$source/$entry") && ($dest !== "$source/$entry")) {
            copyr("$source/$entry", "$dest/$entry");
        } else {
            copy("$source/$entry", "$dest/$entry");
        }
    }

    // Clean up
    $dir->close();
    return true;
}

function smartclient_getHelpPath()
{
    $smartConfig =& smartclient_getModuleConfig();
    switch ($smartConfig['helppath_select'])
    {
        case 'docs.xoops.org' :
            return 'http://docs.xoops.org/help/sclienth/index.htm';
            break;

        case 'inside' :
            return SMARTCLIENT_URL . "doc/";
            break;

        case 'custom' :
            return $smartConfig['helppath_custom'];
            break;
    }
}

function &smartclient_getModuleInfo()
{
    static $smartModule;
    if (!isset($smartModule)) {
        global $xoopsModule;
        if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == SMARTCLIENT_DIRNAME) {
            $smartModule =& $xoopsModule;
        }
        else {
            $hModule = &xoops_gethandler('module');
            $smartModule = $hModule->getByDirname(SMARTCLIENT_DIRNAME);
        }
    }
    return $smartModule;
}

function &smartclient_getModuleConfig()
{
    static $smartConfig;
    if (!$smartConfig) {
        global $xoopsModule;
        if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == SMARTCLIENT_DIRNAME) {
            global $xoopsModuleConfig;
            $smartConfig =& $xoopsModuleConfig;
        }
        else {
            $smartModule =& smartclient_getModuleInfo();
            $hModConfig = &xoops_gethandler('config');
            $smartConfig = $hModConfig->getConfigsByCat(0, $smartModule->getVar('mid'));
        }
    }
    return $smartConfig;
}


function smartclient_imageResize($src, $maxWidth, $maxHeight)
{
    $width = '';
    $height = '';
    $type = '';
    $attr = '';

    if (file_exists($src)) {
        list($width, $height, $type, $attr) = getimagesize($src);
        If ($width > $maxWidth) {
            $originalWidth = $width;
            $width = $maxWidth;
            $height = $width * $height / $originalWidth;
        }

        If ($height > $maxHeight) {
            $originalHeight = $height;
            $height = $maxHeight;
            $width = $height * $width / $originalHeight;
        }

        $attr = " width='$width' height='$height'";
    }
    return array($width, $height, $type, $attr);
}

function smartclient_gethandler($name, $optional = false )
{
    static $handlers;
    $ret = false;
    $name = strtolower(trim($name));
    if (!isset($handlers[$name])) {
        if ( file_exists( $hnd_file = SMARTCLIENT_ROOT_PATH.'class/'.$name.'.php' ) ) {
            require_once $hnd_file;
        }
        $class = "Smartclient" . ucfirst($name).'Handler';
        if (class_exists($class)) {
            $handlers[$name] = new $class($GLOBALS['xoopsDB']);
        }
    }
    if (!isset($handlers[$name]) && !$optional ) {
        trigger_error('Class <b>'.$class.'</b> does not exist<br />Handler Name: '.$name . ' | Module path : ' . SMARTCLIENT_ROOT_PATH, E_USER_ERROR);
    }
    return isset($handlers[$name]) ? $handlers[$name] : $ret;
}


/**
 * Checks if a user is admin of SmartClient
 *
 * smartclient_userIsAdmin()
 *
 * @return boolean : array with userids and uname
 */
function smartclient_userIsAdmin()
{
    global $xoopsUser;

    $result = false;
    $smartModule = smartclient_getModuleInfo();
    $module_id = $smartModule->getVar('mid');

    if (!empty($xoopsUser)) {
        $groups = $xoopsUser->getGroups();
        $result = (in_array(XOOPS_GROUP_ADMIN, $groups)) || ($xoopsUser->isAdmin($module_id));
    }
    return $result;
}


function smartclient_adminMenu ($currentoption = 0, $breadcrumb = '')
{

    /* Nice buttons styles */
    echo "
    	<style type='text/css'>
    	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
    	#buttonbar { float:left; width:100%; background: #e7e7e7 url('" . SMARTCLIENT_URL . "images/bg.gif') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }
    	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
		#buttonbar li { display:inline; margin:0; padding:0; }
		#buttonbar a { float:left; background:url('" . SMARTCLIENT_URL . "images/left_both.gif') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
		#buttonbar a span { float:left; display:block; background:url('" . SMARTCLIENT_URL . "images/right_both.gif') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
		/* Commented Backslash Hack hides rule from IE5-Mac \*/
		#buttonbar a span {float:none;}
		/* End IE5-Mac hack */
		#buttonbar a:hover span { color:#333; }
		#buttonbar #current a { background-position:0 -150px; border-width:0; }
		#buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
		#buttonbar a:hover { background-position:0% -150px; }
		#buttonbar a:hover span { background-position:100% -150px; }
		</style>
    ";

    // global $xoopsDB, $xoopsModule, $xoopsConfig, $xoopsModuleConfig;
    global $xoopsModule, $xoopsConfig;

    $myts =& MyTextSanitizer::getInstance();

    $tblColors = Array();
    $tblColors[0] = $tblColors[1] = $tblColors[2] = $tblColors[3] = $tblColors[4] = $tblColors[5] = $tblColors[6] = $tblColors[7] = $tblColors[8] = '';
    $tblColors[$currentoption] = 'current';
    $fileName = SMARTCLIENT_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/modinfo.php';
    if (file_exists($fileName)) {
        include_once $fileName;
    } else {
        include_once SMARTCLIENT_ROOT_PATH . '/language/english/modinfo.php';
    }

    echo "<div id='buttontop'>";
    echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
    //echo "<td style=\"width: 45%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a class=\"nobutton\" href=\"../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoopsModule->getVar('mid') . "\">" . _AM_SCLIENT_OPTS . "</a> | <a href=\"../index.php\">" . _AM_SCLIENT_GOMOD . "</a> | <a href=\"import.php\">" . _AM_SCLIENT_IMPORT . "</a> | <a href='" . smartclient_getHelpPath() ."' target=\"_blank\">" . _AM_SCLIENT_HELP . "</a> | <a href=\"about.php\">" . _AM_SCLIENT_ABOUT . "</a></td>";
    echo "<td style=\"width: 45%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a class=\"nobutton\" href=\"../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoopsModule->getVar('mid') . "\">" . _AM_SCLIENT_OPTS . "</a> | <a href=\"../index.php\">" . _AM_SCLIENT_GOMOD . "</a> | <a href=\"about.php\">" . _AM_SCLIENT_ABOUT . "</a></td>";
    echo "<td style=\"width: 55%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;\"><b>" . $myts->displayTarea($xoopsModule->name()) . " " . _AM_SCLIENT_MODADMIN . "</b> " . $breadcrumb . "</td>";
    echo "</tr></table>";
    echo "</div>";

    echo "<div id='buttonbar'>";
    echo "<ul>";
    echo "<li id='" . $tblColors[0] . "'><a href=\"index.php\"><span>" . _AM_SCLIENT_INDEX . "</span></a></li>";
    echo "<li id='" . $tblColors[1] . "'><a href=\"client.php\"><span>" . _AM_SCLIENT_CLIENTS . "</span></a></li>";
    echo "<li id='" . $tblColors[2] . "'><a href=\"myblocksadmin.php\"><span>" . _AM_SCLIENT_BLOCKS . "</span></a></li>";
    echo "</ul></div>";
}

function smartclient_collapsableBar($tablename = '', $iconname = '')
{

    ?>
<script type="text/javascript"><!--
	function goto_URL(object)
	{
		window.location.href = object.options[object.selectedIndex].value;
	}

	function toggle(id)
	{
		if (document.getElementById) { obj = document.getElementById(id); }
		if (document.all) { obj = document.all[id]; }
		if (document.layers) { obj = document.layers[id]; }
		if (obj) {
			if (obj.style.display == "none") {
				obj.style.display = "";
			} else {
				obj.style.display = "none";
			}
		}
		return false;
	}

	var iconClose = new Image();
	iconClose.src = '../images/icon/close12.gif';
	var iconOpen = new Image();
	iconOpen.src = '../images/icon/open12.gif';

	function toggleIcon ( iconName )
	{
		if ( document.images[iconName].src == window.iconOpen.src ) {
			document.images[iconName].src = window.iconClose.src;
		} else if ( document.images[iconName].src == window.iconClose.src ) {
			document.images[iconName].src = window.iconOpen.src;
		}
		return;
	}

	//-->
	</script>
    <?php
    echo "<h3 style=\"color: #2F5376; font-weight: bold; font-size: 14px; margin: 6px 0 0 0; \"><a href='javascript:;' onclick=\"toggle('" . $tablename . "'); toggleIcon('" . $iconname . "')\";>";
}

function smartclient_modFooter ()
{
    global $xoopsUser, $xoopsDB, $xoopsConfig;

    $hModule = &xoops_gethandler('module');

    $smartModule = smartclient_getModuleInfo();
    $module_id = $smartModule->getVar('mid');

    $module_name = $smartModule->getVar('dirname');
    $smartConfig = smartclient_getModuleConfig();

    $module_id = $smartModule->getVar('mid');

    $versioninfo = &$hModule->get($smartModule->getVar('mid'));
    $modfootertxt = "Module " . $versioninfo->getInfo('name') . " - Version " . $versioninfo->getInfo('version') . "";

    $modfooter = "<a href='" . $versioninfo->getInfo('support_site_url') . "' target='_blank'><img src='" . SMARTCLIENT_URL . "images/spcssbutton.gif' title='" . $modfootertxt . "' alt='" . $modfootertxt . "'/></a>";

    return $modfooter;
}

/**
 * Thanks to the NewBB2 Development Team
 */
function &smartclient_admin_getPathStatus($item, $getStatus=false)
{
    if ($item == 'root') {
        $path = '';
    } else {
        $path = $item;
    }

    $thePath = smartclient_getUploadDir(true, $path);

    if(empty($thePath)) return false;
    if(@is_writable($thePath)){
        $pathCheckResult = 1;
        $path_status = _AM_SCLIENT_AVAILABLE;
    }elseif(!@is_dir($thePath)){
        $pathCheckResult = -1;
        $path_status = _AM_SCLIENT_NOTAVAILABLE." <a href=index.php?op=createdir&amp;path=$item>"._AM_SCLIENT_CREATETHEDIR.'</a>';
    }else{
        $pathCheckResult = -2;
        $path_status = _AM_SCLIENT_NOTWRITABLE." <a href=index.php?op=setperm&amp;path=$item>"._AM_SCS_SETMPERM.'</a>';
    }
    if (!$getStatus) {
        return $path_status;
    } else {
        return $pathCheckResult;
    }
}

/**
 * Thanks to the NewBB2 Development Team
 */
function smartclient_admin_mkdir($target)
{
    // http://www.php.net/manual/en/function.mkdir.php
    // saint at corenova.com
    // bart at cdasites dot com
    if (is_dir($target)||empty($target)) return true; // best case check first
    if (file_exists($target) && !is_dir($target)) return false;
    if (smartclient_admin_mkdir(substr($target,0,strrpos($target,'/'))))
    if (!file_exists($target)) return mkdir($target); // crawl back up & create dir tree
    return true;
}

/**
 * Thanks to the NewBB2 Development Team
 */
function smartclient_admin_chmod($target, $mode = 0777)
{
    return @chmod($target, $mode);
}


function smartclient_getUploadDir($local=true, $item=false)
{
    if ($item) {
        if ($item=='root') {
            $item = '';
        } else {
            $item = $item . '/';
        }
    } else {
        $item = '';
    }

    If ($local) {
        return XOOPS_ROOT_PATH . "/uploads/smartclient/$item";
    } else {
        return XOOPS_URL . "/uploads/smartclient/$item";
    }
}

function smartclient_getImageDir($item='', $local=true)
{
    if ($item) {
        $item = "images/$item";
    } else {
        $item = 'images';
    }

    return smartclient_getUploadDir($local, $item);
}


function smartclient_formatErrors($errors=array())
{
    $ret = '';
    foreach ($errors as $key=>$value)
    {
        $ret .= "<br /> - " . $value;
    }

    return $ret;
}

?>