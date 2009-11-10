<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Include
 * @subpackage      Utils
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: functions.php 0 2009-06-11 18:47:04Z trabis $
 */

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once dirname(__FILE__) . '/common.php';

function publisher_isXoops22()
{
    $xoops22 = false;
    $xv=str_replace('XOOPS ', '', XOOPS_VERSION);
    if (substr($xv, 2, 1) == '2') {
        $xoops22 = true;
    }
    return $xoops22;
}

function publisher_getAllCategoriesObj()
{
    $publisher =& PublisherPublisher::getInstance();

    static $publisher_allCategoriesObj;

    if (!isset($publisher_allCategoriesObj)) {
        $publisher_allCategoriesObj = $publisher->getHandler('category')->getObjects(null, true);
        $publisher_allCategoriesObj[0] = array();
    }

    return $publisher_allCategoriesObj;
}

/**
 * Includes scripts in HTML header
 *
 */
function publisher_cpHeader()
{
    xoops_cp_header();
    echo '<link type="text/css" href="' . PUBLISHER_URL . '/css/jquery-ui-1.7.1.custom.css" rel="stylesheet" />
    <script type="text/javascript" src="' . PUBLISHER_URL . '/js/funcs.js"></script>
    <script type="text/javascript" src="' . PUBLISHER_URL . '/js/cookies.js"></script>
    <script type="text/javascript" src="' . PUBLISHER_URL . '/js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="' . PUBLISHER_URL . '/js/ui.core.js"></script>
    <script type="text/javascript" src="' . PUBLISHER_URL . '/js/ui.tabs.js"></script>
    <script type="text/javascript" src="' . PUBLISHER_URL . '/js/jquery.lightbox-0.5.js"></script>
    <script type="text/javascript" src="' . PUBLISHER_URL . '/js/ajaxupload.3.5.js"></script>
    <script type="text/javascript" src="' . PUBLISHER_URL . '/js/publisher.js"></script>
    ';
}

/**
 * Default sorting for a given order
 *
 * @param unknown_type $sort
 * @return unknown
 */
function publisher_getOrderBy($sort)
{
    if ($sort == "datesub") {
        return "DESC";
    } else if ($sort == "counter") {
        return "DESC";
    } else if ($sort == "weight") {
        return "ASC";
    }
}

/**
 * Determines if a table exists in the current db
 *
 * @param string $table the table name (without XOOPS prefix)
 * @return bool True if table exists, false if not
 *
 * @access public
 * @author xhelp development team
 */
function publisher_tableExists($table)
{
    $bRetVal = false;
    //Verifies that a MySQL table exists
    $xoopsDB =& Database::getInstance();
    $realname = $xoopsDB->prefix($table);
    $ret = mysql_list_tables(XOOPS_DB_NAME, $xoopsDB->conn);
    while (list($m_table) = $xoopsDB->fetchRow($ret)) {

        if ($m_table ==  $realname) {
            $bRetVal = true;
            break;
        }
    }
    $xoopsDB->freeRecordSet($ret);
    return ($bRetVal);
}

/**
 * Gets a value from a key in the xhelp_meta table
 *
 * @param string $key
 * @return string $value
 *
 * @access public
 * @author xhelp development team
 */
function publisher_getMeta($key)
{
    $xoopsDB =& Database::getInstance();
    $sql = sprintf("SELECT metavalue FROM %s WHERE metakey=%s", $xoopsDB->prefix('publisher_meta'), $xoopsDB->quoteString($key));
    $ret = $xoopsDB->query($sql);
    if (!$ret) {
        $value = false;
    } else {
        list($value) = $xoopsDB->fetchRow($ret);

    }
    return $value;
}

/**
 * Sets a value for a key in the xhelp_meta table
 *
 * @param string $key
 * @param string $value
 * @return bool TRUE if success, FALSE if failure
 *
 * @access public
 * @author xhelp development team
 */
function publisher_setMeta($key, $value)
{
    $xoopsDB =& Database::getInstance();
    if($ret = publisher_getMeta($key)){
        $sql = sprintf("UPDATE %s SET metavalue = %s WHERE metakey = %s", $xoopsDB->prefix('publisher_meta'), $xoopsDB->quoteString($value), $xoopsDB->quoteString($key));
    } else {
        $sql = sprintf("INSERT INTO %s (metakey, metavalue) VALUES (%s, %s)", $xoopsDB->prefix('publisher_meta'), $xoopsDB->quoteString($key), $xoopsDB->quoteString($value));
    }
    $ret = $xoopsDB->queryF($sql);
    if (!$ret) {
        return false;
    }
    return true;
}

// Thanks to Mithrandir :-)
function publisher_substr($str, $start, $length, $trimmarker = '...')
{
    // if the string is empty, let's get out ;-)
    if ($str == '') {
        return $str;
    }

    // reverse a string that is shortened with '' as trimmarker
    $reversed_string = strrev(xoops_substr($str, $start, $length, ''));

    // find first space in reversed string
    $position_of_space = strpos($reversed_string, " ", 0);

    // truncate the original string to a length of $length
    // minus the position of the last space
    // plus the length of the $trimmarker
    $truncated_string = xoops_substr($str, $start, $length-$position_of_space + strlen($trimmarker), $trimmarker);

    return $truncated_string;
}

function publisher_html2text($document)
{
    // PHP Manual:: function preg_replace
    // $document should contain an HTML document.
    // This will remove HTML tags, javascript sections
    // and white space. It will also convert some
    // common HTML entities to their text equivalent.
    // Credits : newbb2
    $search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
        "'<img.*?/>'si",       // Strip out img tags
        "'<[\/\!]*?[^<>]*?>'si",          // Strip out HTML tags
        "'([\r\n])[\s]+'",                // Strip out white space
        "'&(quot|#34);'i",                // Replace HTML entities
        "'&(amp|#38);'i",
        "'&(lt|#60);'i",
        "'&(gt|#62);'i",
        "'&(nbsp|#160);'i",
        "'&(iexcl|#161);'i",
        "'&(cent|#162);'i",
        "'&(pound|#163);'i",
        "'&(copy|#169);'i",
    "'&#(\d+);'e");                    // evaluate as php

    $replace = array ("",
        "",
        "",
        "\\1",
        "\"",
        "&",
        "<",
        ">",
        " ",
        chr(161),
        chr(162),
        chr(163),
        chr(169),
    "chr(\\1)");

    $text = preg_replace($search, $replace, $document);
    return $text;
    //<?php
}

function publisher_getAllowedImagesTypes()
{
    return array('jpg/jpeg', 'image/bmp', 'image/gif', 'image/jpeg', 'image/jpg', 'image/x-png', 'image/png', 'image/pjpeg');
}

function publisher_moduleHome($withLink = true)
{
    $publisher =& PublisherPublisher::getInstance();

    if (!$publisher->getConfig('format_breadcrumb_modname')) {
        return	'';
    }

    if (!$withLink)	{
        return $publisher->getModule()->getVar('name');
    } else {
        return '<a href="' . PUBLISHER_URL . '/">' . $publisher->getModule()->getVar('name') . '</a>';
    }
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
function publisher_copyr($source, $dest)
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

//TODO remove this function
function publisher_getEditor($caption, $name, $value, $dhtml = true)
{
    global $xoops22;
    $publisher =& PublisherPublisher::getInstance();

    $editor_configs = array();
    $editor_configs["name"] = $name;
    $editor_configs["value"] = $value;
    $editor_configs['caption'] = $caption;
    $editor_configs["rows"] = 35;
    $editor_configs["cols"] = 60;
    $editor_configs["width"] = "100%";
    $editor_configs["height"] = "400px";

    switch ($publisher->getConfig('use_wysiwyg')) {
        case 'tiny' :
            if (!$xoops22) {

                if ( is_readable(XOOPS_ROOT_PATH . "/class/xoopseditor/tinyeditor/formtinyeditortextarea.php"))	{

                    include_once XOOPS_ROOT_PATH . "/class/xoopseditor/tinyeditor/formtinyeditortextarea.php";
                    $editor = new XoopsFormTinyeditorTextArea(array('caption'=>$caption, 'name'=>$name, 'value'=>$value, 'width'=>'100%', 'height'=>'400px'));
                } else {

                    if ($dhtml) {
                        $editor = new XoopsFormDhtmlTextArea($caption, $name, $value, 20, 60);
                    } else {
                        $editor = new XoopsFormTextArea($caption, $name, $value, 7, 60);
                    }
                }
            } else {
                $editor = new XoopsFormEditor($caption, "tinyeditor", $editor_configs);
            }
            break;

        case 'inbetween' :
            if (!$xoops22) {
                if ( is_readable(XOOPS_ROOT_PATH . "/class/xoopseditor/inbetween/forminbetweentextarea.php"))	{
                    include_once(XOOPS_ROOT_PATH . "/class/xoopseditor/inbetween/forminbetweentextarea.php");
                    $editor = new XoopsFormInbetweenTextArea(array('caption'=> $caption, 'name'=>$name, 'value'=>$value, 'width'=>'100%', 'height'=>'300px'),true);
                } else {
                    if ($dhtml) {
                        $editor = new XoopsFormDhtmlTextArea($caption, $name, $value, 20, 60);
                    } else {
                        $editor = new XoopsFormTextArea($caption, $name, $value, 7, 60);
                    }
                }
            } else {
                $editor = new XoopsFormEditor($caption, "inbetween", $editor_configs);
            }
            break;

        case 'fckeditor' :
            if (!$xoops22) {
                if ( is_readable(XOOPS_ROOT_PATH . "/class/xoopseditor/fckeditor/formfckeditor.php"))	{
                    include_once(XOOPS_ROOT_PATH . "/class/xoopseditor/fckeditor/formfckeditor.php");
                    $editor = new XoopsFormFckeditor($editor_configs, true);
                } else {
                    if ($dhtml) {
                        $editor = new XoopsFormDhtmlTextArea($caption, $name, $value, 20, 60);
                    } else {
                        $editor = new XoopsFormTextArea($caption, $name, $value, 7, 60);
                    }
                }
            } else {
                $editor = new XoopsFormEditor($caption, "fckeditor", $editor_configs);
            }
            break;

        case 'koivi' :
            if (!$xoops22) {
                if ( is_readable(XOOPS_ROOT_PATH . "/class/wysiwyg/formwysiwygtextarea.php"))	{
                    include_once(XOOPS_ROOT_PATH . "/class/wysiwyg/formwysiwygtextarea.php");
                    $editor = new XoopsFormWysiwygTextArea($caption, $name, $value, '100%', '400px');
                } else {
                    if ($dhtml) {
                        $editor = new XoopsFormDhtmlTextArea($caption, $name, $value, 20, 60);
                    } else {
                        $editor = new XoopsFormTextArea($caption, $name, $value, 7, 60);
                    }
                }
            } else {
                $editor = new XoopsFormEditor($caption, "koivi", $editor_configs);
            }
            break;

        case "spaw":
            if(!$xoops22) {
                if (is_readable(XOOPS_ROOT_PATH . "/class/spaw/formspaw.php"))	{
                    include_once(XOOPS_ROOT_PATH . "/class/spaw/formspaw.php");
                    $editor = new XoopsFormSpaw($caption, $name, $value);
                } else {
                    if ($dhtml) {
                        $editor = new XoopsFormDhtmlTextArea($caption, $name, $value, 20, 60);
                    } else {
                        $editor = new XoopsFormTextArea($caption, $name, $value, 7, 60);
                    }
                }

            } else {
                $editor = new XoopsFormEditor($caption, "spaw", $editor_configs);
            }
            break;

        case "htmlarea":
            if(!$xoops22) {
                if ( is_readable(XOOPS_ROOT_PATH . "/class/htmlarea/formhtmlarea.php"))	{
                    include_once(XOOPS_ROOT_PATH . "/class/htmlarea/formhtmlarea.php");
                    $editor = new XoopsFormHtmlarea($caption, $name, $value);
                } else {
                    if ($dhtml) {
                        $editor = new XoopsFormDhtmlTextArea($caption, $name, $value, 20, 60);
                    } else {
                        $editor = new XoopsFormTextArea($caption, $name, $value, 7, 60);
                    }
                }
            } else {
                $editor = new XoopsFormEditor($caption, "htmlarea", $editor_configs);
            }
            break;

        default :
            if ($dhtml) {
                $editor = new XoopsFormDhtmlTextArea($caption, $name, $value, 20, 60);
            } else {
                $editor = new XoopsFormTextArea($caption, $name, $value, 7, 60);
            }

        break;
    }

    return $editor;
}

/**
 * Thanks to the NewBB2 Development Team
 */
function &publisher_getPathStatus($item, $getStatus = false)
{
    if ($item == 'root') {
        $path = '';
    } else {
        $path = $item;
    }

    $thePath = publisher_getUploadDir(true, $path);

    if (empty($thePath)) return false;
    if (@is_writable($thePath)) {
        $pathCheckResult = 1;
        $path_status = _AM_PUBLISHER_AVAILABLE;
    } elseif (!@is_dir($thePath)) {
        $pathCheckResult = -1;
        $path_status = _AM_PUBLISHER_NOTAVAILABLE." <a href='" . PUBLISHER_ADMIN_URL . "/index.php?op=createdir&amp;path={$item}'>"._AM_PUBLISHER_CREATETHEDIR."</a>";
    } else {
        $pathCheckResult = -2;
        $path_status = _AM_PUBLISHER_NOTWRITABLE." <a href='" . PUBLISHER_ADMIN_URL . "/index.php?op=setperm&amp;path={$item}'>"._AM_SCS_SETMPERM."</a>";
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
function publisher_mkdir($target)
{
    // http://www.php.net/manual/en/function.mkdir.php
    // saint at corenova.com
    // bart at cdasites dot com
    if (is_dir($target) || empty($target)) {
        return true; // best case check first
    }

    if (file_exists($target) && !is_dir($target)) {
        return false;
    }

    if (publisher_mkdir(substr($target, 0, strrpos($target,'/')))) {
        if (!file_exists($target)) {
            $res = mkdir($target, 0777); // crawl back up & create dir tree
            publisher_chmod($target);
            return $res;
        }
    }
    $res = is_dir($target);
    return $res;
}

/**
 * Thanks to the NewBB2 Development Team
 */
function publisher_chmod($target, $mode = 0777)
{
    return @chmod($target, $mode);
}

function publisher_getUploadDir($hasPath = true, $item = false)
{
    if ($item) {
        if ($item == 'root') {
            $item = '';
        } else {
            $item = $item . '/';
        }
    } else {
        $item = '';
    }

    if ($hasPath) {
        return PUBLISHER_UPLOADS_PATH . '/' . $item;
    } else {
        return PUBLISHER_UPLOADS_URL . '/' . $item;
    }
}

function publisher_getImageDir($item = '', $hasPath = true)
{
    if ($item) {
        $item = "images/{$item}";
    } else {
        $item = "images";
    }

    return publisher_getUploadDir($hasPath, $item);
}

function publisher_imageResize($src, $maxWidth, $maxHeight)
{
    $width = '';
    $height = '';
    $type = '';
    $attr = '';

    if (file_exists($src)) {
        list($width, $height, $type, $attr) = getimagesize($src);
        if ($width > $maxWidth) {
            $originalWidth = $width;
            $width = $maxWidth;
            $height = $width * $height / $originalWidth;
        }

        if ($height > $maxHeight) {
            $originalHeight = $height;
            $height = $maxHeight;
            $width = $height * $width / $originalHeight;
        }

        $attr = " width='{$width}' height='{$height}'";
    }
    return array($width, $height, $type, $attr);
}

/*
 function publisher_getHelpPath()
 {
 global $publisher_config;

 switch ($publisher_config['helppath_select'])
 {
 case 'docs.xoops.org' :
 return 'http://docs.xoops.org/help/ssectionh/index.htm';
 break;

 case 'inside' :
 return PUBLISHER_URL . '/doc/';
 break;

 case 'custom' :
 return $publisher_config['helppath_custom'];
 break;
 }
 }
 */

//TODO, this is only used in file class
function publisher_deleteFile($dirname)
{
    // Simple delete for a file
    if (is_file($dirname)) {
        return unlink($dirname);
    }
}

function publisher_formatErrors($errors=array())
{
    $ret = '';
    foreach ($errors as $key => $value) {
        $ret .= '<br /> - ' . $value;
    }
    return $ret;
}

// TODO, remove this, not used in module
function publisher_getStatusArray()
{
    $result = array("1" => _AM_PUBLISHER_STATUS1,
        "2" => _AM_PUBLISHER_STATUS2,
        "3" => _AM_PUBLISHER_STATUS3,
        "4" => _AM_PUBLISHER_STATUS4,
        "5" => _AM_PUBLISHER_STATUS5,
        "6" => _AM_PUBLISHER_STATUS6,
        "7" => _AM_PUBLISHER_STATUS7,
        "8" => _AM_PUBLISHER_STATUS8);
    return $result;
}

// TODO, remove this, not used in module
function publisher_moderator()
{
    global $xoopsUser;
    $publisher =& PublisherPublisher::getInstance();

    if (!$xoopsUser) {
        $result = false;
    } else {
        $gperm_handler =& xoops_gethandler('groupperm');
        $categories = $gperm_handler->getItemIds('category_moderation', $xoopsUser->getVar('uid'), $publisher->getModule()->getVar('mid'));

        if (count($categories) == 0) {
            $result = false;
        } else {
            $result = true;
        }
    }
    return $result;
}

// TODO, remove this, not used in module
function publisher_modFooter() {}

/**
 * Checks if a user is admin of Publisher
 *
 * publisher_userIsAdmin()
 *
 * @return boolean : array with userids and uname
 */
function publisher_userIsAdmin()
{
    global $xoopsUser;
    $publisher =& PublisherPublisher::getInstance();

    static $publisher_isAdmin;

    if (isset($publisher_isAdmin)) {
        return $publisher_isAdmin;
    }

    if (!$xoopsUser) {
        $publisher_isAdmin = false;
    }  else {
        $publisher_isAdmin = $xoopsUser->isAdmin($publisher->getModule()->getVar('mid'));
    }

    return $publisher_isAdmin;
}

/**
 * Override ITEMs permissions of a category by the category read permissions
 *
 *   publisher_overrideItemsPermissions()
 *
 * @param array $groups : group with granted permission
 * @param integer $categoryid :
 * @return boolean : TRUE if the no errors occured
 */
function publisher_overrideItemsPermissions($groups, $categoryid)
{
    global $xoopsDB;
    $publisher =& PublisherPublisher::getInstance();

    $result = true;

    $module_id = $publisher->getModule()->getVar('mid');
    $gperm_handler =& xoops_gethandler('groupperm');

    $sql = "SELECT itemid FROM " . $xoopsDB->prefix("publisher_items") . " WHERE categoryid = '$categoryid' ";
    $result = $xoopsDB->query($sql);

    if (count($result) > 0) {
        while (list($itemid) = $xoopsDB->fetchrow($result)) {
            // First, if the permissions are already there, delete them
            $gperm_handler->deleteByModule($module_id, 'item_read', $itemid);
            // Save the new permissions
            if (count($groups) > 0) {
                foreach ($groups as $group_id) {
                    $gperm_handler->addRight('item_read', $itemid, $group_id, $module_id);
                }
            }
        }
    }

    return $result;
}

/**
 * Saves permissions for the selected item
 *
 *   publisher_saveItemPermissions()
 *
 * @param array $groups : group with granted permission
 * @param integer $itemID : itemid on which we are setting permissions
 * @return boolean : TRUE if the no errors occured

 */
function publisher_saveItemPermissions($groups, $itemid)
{
    $publisher =& PublisherPublisher::getInstance();

    $result = true;

    $module_id = $publisher->getModule()->getVar('mid');
    $gperm_handler =& xoops_gethandler('groupperm');
    // First, if the permissions are already there, delete them
    $gperm_handler->deleteByModule($module_id, 'item_read', $itemid);
    // Save the new permissions
    if (count($groups) > 0) {
        foreach ($groups as $group_id) {
            $gperm_handler->addRight('item_read', $itemid, $group_id, $module_id);
        }
    }
    return $result;
}

/**
 * Saves permissions for the selected category
 *
 *   publisher_saveCategory_Permissions()
 *
 * @param array $groups : group with granted permission
 * @param integer $categoryid : categoryid on which we are setting permissions
 * @param string $perm_name : name of the permission
 * @return boolean : TRUE if the no errors occured
 */
function publisher_saveCategory_Permissions($groups, $categoryid, $perm_name)
{
    $publisher =& PublisherPublisher::getInstance();

    $result = true;

    $module_id = $publisher->getModule()->getVar('mid');
    $gperm_handler =& xoops_gethandler('groupperm');
    // First, if the permissions are already there, delete them
    $gperm_handler->deleteByModule($module_id, $perm_name, $categoryid);

    // Save the new permissions
    if (count($groups) > 0) {
        foreach($groups as $group_id) {
            $gperm_handler->addRight($perm_name, $categoryid, $group_id, $module_id);
        }
    }
    return $result;
}

/**
 * Saves permissions for the selected category
 *
 *   publisher_saveModerators()
 *
 * @param array $moderators : moderators uids
 * @param integer $categoryid : categoryid on which we are setting permissions
 * @return boolean : TRUE if the no errors occured
 */
function publisher_saveModerators($moderators, $categoryid)
{
    $publisher =& PublisherPublisher::getInstance();

    $result = true;

    $module_id = $publisher->getModule()->getVar('mid');
    $gperm_handler = &xoops_gethandler('groupperm');
    // First, if the permissions are already there, delete them
    $gperm_handler->deleteByModule($module_id, 'category_moderation', $categoryid);
    // Save the new permissions
    if (count($moderators) > 0) {
        foreach ($moderators as $uid) {
            $gperm_handler->addRight('category_moderation', $categoryid, $uid, $module_id);
        }
    }
    return $result;
}

// TODO, remove this, not used in module
function publisher_getXoopsLink($url = '')
{
    $xurl = $url;
    if (strlen($xurl) > 0) {
        if ($xurl[0] = '/') {
            $xurl = str_replace('/', '', $xurl);
        }
        $xurl = str_replace('{SITE_URL}', XOOPS_URL, $xurl);
    }
    $xurl = $url;
    return $xurl;
}

function publisher_adminMenu($currentoption = 0, $breadcrumb = '')
{
    include_once XOOPS_ROOT_PATH . '/class/template.php';
    include PUBLISHER_ROOT_PATH . '/admin/menu.php';

    xoops_loadLanguage('admin', PUBLISHER_DIRNAME);
    xoops_loadLanguage('modinfo', PUBLISHER_DIRNAME);

    $tpl = new XoopsTpl();
    $tpl->assign(array('modurl'	    => PUBLISHER_URL,
        'headermenu'	=> $publisher_headermenu,
        'adminmenu'	=> $publisher_adminmenu,
        'current'	=> $currentoption,
        'breadcrumb'	=> $breadcrumb,
        'headermenucount' => count($publisher_headermenu)));
    $tpl->display(PUBLISHER_ROOT_PATH . '/templates/static/publisher_admin_menu.html');
}

function publisher_openCollapsableBar($tablename = '', $iconname = '', $tabletitle = '', $tabledsc = '', $open = true)
{
    $image = 'open12.gif';
    $display = 'none';
    if ($open) {
        $image = 'close12.gif';
        $display = 'block';
    }

    echo "<h3 style=\"color: #2F5376; font-weight: bold; font-size: 14px; margin: 6px 0 0 0; \"><a href='javascript:;' onclick=\"toggle('" . $tablename . "'); toggleIcon('" . $iconname . "')\";>";
    echo "<img id='" . $iconname . "' src='" . PUBLISHER_URL . "/images/icon/" . $image . "' alt='' /></a>&nbsp;" . $tabletitle . "</h3>";
    echo "<div id='" . $tablename . "' style='display: " . $display . ";'>";
    if ($tabledsc != '') {
        echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . $tabledsc . "</span>";
    }
}

function publisher_closeCollapsableBar($name, $icon)
{
    echo "</div>";

    $urls = publisher_getCurrentUrls();
    $path = $urls['phpself'];

    $cookie_name = $path . '_publisher_collaps_' . $name;
    $cookie_name = str_replace('.', '_', $cookie_name);
    $cookie = publisher_getCookieVar($cookie_name, '');

    if ($cookie == 'none') {
        echo '
        <script type="text/javascript"><!--
        toggle("' . $name . '"); toggleIcon("' . $icon . '");
        //-->
        </script>
        ';
    }
}

function publisher_setCookieVar($name, $value, $time = 0)
{
    if ($time == 0) {
        $time = time() + 3600 * 24 * 365;
    }
    setcookie($name, $value, $time, '/');
}

function publisher_getCookieVar($name, $default = '')
{
    if (isset($_COOKIE[$name]) && ($_COOKIE[$name] > '')) {
        return 	$_COOKIE[$name];
    } else {
        return	$default;
    }
}

function publisher_getCurrentUrls()
{
    $http = strpos(XOOPS_URL, "https://") === false ? "http://" : "https://";
    $phpself = $_SERVER['PHP_SELF'];
    $httphost = $_SERVER['HTTP_HOST'];
    $querystring = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';

    if ($querystring != '') {
        $querystring = '?' . $querystring;
    }

    $currenturl = $http . $httphost . $phpself . $querystring;

    $urls = array();
    $urls['http'] = $http;
    $urls['httphost'] = $httphost;
    $urls['phpself'] = $phpself;
    $urls['querystring'] = $querystring;
    $urls['full'] = $currenturl;

    return $urls;
}

function publisher_getCurrentPage()
{
    $urls = publisher_getCurrentUrls();
    return $urls['full'];
}

function publisher_addCategoryOption($categoryObj, $selectedid = 0, $level = 0, $ret = '')
{
    $publisher =& PublisherPublisher::getInstance();

    $spaces = '';
    for ( $j = 0; $j < $level; $j++ ) {
        $spaces .= '--';
    }

    $ret .= "<option value='" . $categoryObj->categoryid() . "'";
    if (is_array($selectedid) && in_array($categoryObj->categoryid(), $selectedid)) {
        $ret .= " selected='selected'";
    } elseif($categoryObj->categoryid() == $selectedid) {
        $ret .= " selected='selected'";
    }
    $ret .= ">" . $spaces . $categoryObj->name() . "</option>\n";

    $subCategoriesObj = $publisher->getHandler('category')->getCategories(0, 0, $categoryObj->categoryid());
    if (count($subCategoriesObj) > 0) {
        $level++;
        foreach ($subCategoriesObj as $catID => $subCategoryObj) {
            $ret .= publisher_addCategoryOption($subCategoryObj, $selectedid, $level);
        }
    }
    return $ret;
}

function publisher_createCategorySelect($selectedid = 0, $parentcategory = 0, $allCatOption = true, $selectname = 'options[0]')
{
    $publisher =& PublisherPublisher::getInstance();

    $selectedid = explode(',', $selectedid);

    $ret = "<select name='" . $selectname . "[]' multiple='multiple' size='10'>";
    if ($allCatOption) {
        $ret .= "<option value='0'";
        if (in_array(0, $selectedid)) {
            $ret .= " selected='selected'";
        }
        $ret .= ">" . _MB_PUBLISHER_ALLCAT . "</option>";
    }

    // Creating category objects
    $categoriesObj = $publisher->getHandler('category')->getCategories(0, 0, $parentcategory);

    if (count($categoriesObj) > 0) {
        foreach ($categoriesObj as $catID => $categoryObj) {
            $ret .= publisher_addCategoryOption($categoryObj, $selectedid);
        }
    }
    $ret .= "</select>";
    return $ret;
}

function publisher_createCategoryOptions($selectedid = 0, $parentcategory = 0, $allCatOption = true)
{
    $publisher =& PublisherPublisher::getInstance();

    $ret = "";
    if ($allCatOption) {
        $ret .= "<option value='0'";
        $ret .= ">" . _MB_PUBLISHER_ALLCAT . "</option>\n";
    }

    // Creating category objects
    $categoriesObj = $publisher->getHandler('category')->getCategories(0, 0, $parentcategory);
    if (count($categoriesObj) > 0) {
        foreach ($categoriesObj as $catID => $categoryObj) {
            $ret .= publisher_addCategoryOption($categoryObj, $selectedid);
        }
    }
    return $ret;
}

function publisher_renderErrors(&$err_arr, $reseturl = '')
{
    if (is_array($err_arr) && count($err_arr) > 0) {
        echo '<div id="readOnly" class="errorMsg" style="border:1px solid #D24D00; background:#FEFECC url('. PUBLISHER_URL . '/images/important-32.png) no-repeat 7px 50%;color:#333;padding-left:45px;">';

        echo '<h4 style="text-align:left;margin:0; padding-top:0">'._AM_PUBLISHER_MSG_SUBMISSION_ERR;

        if ($reseturl) {
            echo ' <a href="' . $reseturl . '">[' . _AM_PUBLISHER_TEXT_SESSION_RESET . ']</a>';
        }

        echo '</h4><ul>';

        foreach($err_arr as $key=>$error) {
            if (is_array($error)) {
                foreach ($error as $err) {
                    echo '<li><a href="#'. $key . '" onclick="var e = xoopsGetElementById(\'' . $key . '\'); e.focus();">' . htmlspecialchars($err) . '</a></li>';
                }
            } else {
                echo '<li><a href="#'. $key . '" onclick="var e = xoopsGetElementById(\'' . $key . '\'); e.focus();">' . htmlspecialchars($error) . '</a></li>';
            }
        }
        echo "</ul></div><br />";
    }
}

/**
 * Generate publisher URL
 *
 * @param string $page
 * @param array $vars
 * @return
 *
 * @access public
 * @credit : xHelp module, developped by 3Dev
 */
function publisher_makeURI($page, $vars = array(), $encodeAmp = true)
{
    $joinStr = '';

    $amp = ($encodeAmp ? '&amp;' : '&');

    if (!count($vars)) {
        return $page;
    }

    $qs = '';
    foreach ($vars as $key => $value) {
        $qs .= $joinStr . $key . '=' . $value;
        $joinStr = $amp;
    }

    return $page . '?'. $qs;
}

function publisher_isActive($module = 'tag')
{
    static 	$publisher_activeModules;

    if (!isset($publisher_activeModules)) {
        $modules_handler =& xoops_gethandler('module');
        $criteria = new Criteria('isactive', 1);
        $publisher_activeModules = $modules_handler->getList($criteria, true);
        unset($criteria);
    }

    return in_array($module, array_keys($publisher_activeModules));
}

function publisher_tellafriend($subject = '')
{
    if (stristr($subject , '%' )) $subject = rawurldecode($subject) ;

    $target_uri = XOOPS_URL . $_SERVER['REQUEST_URI'] ;

    return XOOPS_URL . '/modules/tellafriend/index.php?target_uri=' . rawurlencode($target_uri) . '&amp;subject=' . rawurlencode($subject) ;
}

function publisher_uploadFile($another = false, $withRedirect = true, &$itemObj)
{
    include_once PUBLISHER_ROOT_PATH . '/class/uploader.php';

    global $publisher_isAdmin, $xoopsUser;
    $publisher =& PublisherPublisher::getInstance();

    $itemid = isset($_POST['itemid']) ? intval($_POST['itemid']) : 0;
    $uid = is_object($xoopsUser) ? $xoopsUser->uid() : 0;
    $session = PublisherSession::singleton();
    $session->set('publisher_file_filename', isset($_POST['name']) ? $_POST['name'] : '');
    $session->set('publisher_file_description', isset($_POST['description']) ? $_POST['description'] : '');
    $session->set('publisher_file_status', isset($_POST['file_status']) ? intval($_POST['file_status']) : 1);
    $session->set('publisher_file_uid', $uid);
    $session->set('publisher_file_itemid', $itemid);

    if (!is_object($itemObj)) {
        $itemObj = $publisher->getHandler('item')->get($itemid);
    }

    $max_size = $publisher->getConfig('maximum_filesize');
    $max_imgwidth = $publisher->getConfig('maximum_image_width');
    $max_imgheight = $publisher->getConfig('maximum_image_height');

    $fileObj = $publisher->getHandler('file')->create();
    $fileObj->setVar('name', isset($_POST['name']) ? $_POST['name'] : '');
    $fileObj->setVar('description', isset($_POST['description']) ? $_POST['description'] : '');
    $fileObj->setVar('status', isset($_POST['file_status']) ? intval($_POST['file_status']) : 1);
    $fileObj->setVar('uid', $uid);
    $fileObj->setVar('itemid', $itemObj->getVar('itemid'));
    $fileObj->setVar('datesub', time());

    // Get available mimetypes for file uploading
    if ($publisher_isAdmin) {
        $crit = new Criteria('mime_admin', 1);
    } else {
        $crit = new Criteria('mime_user', 1);
    }
    $mimetypes =& $publisher->getHandler('mimetype')->getObjects($crit);
    // TODO : display the available mimetypes to the user

    if ($publisher->getConfig('perm_upload') && is_uploaded_file($_FILES['item_upload_file']['tmp_name'])) {
        if (!$ret = $fileObj->checkUpload('item_upload_file', $allowed_mimetypes, $errors)) {
            $errorstxt = implode('<br />', $errors);

            $message = sprintf(_CO_PUBLISHER_MESSAGE_FILE_ERROR, $errorstxt);
            if ($withRedirect) {
                redirect_header("file.php?op=mod&itemid=" . $itemid, 5, $message);
            } else {
                return $message;
            }
        }
    }

    // Storing the file
    if (!$fileObj->store($allowed_mimetypes)) {
        if ($withRedirect) {
            redirect_header("file.php?op=mod&itemid=" . $fileObj->itemid(), 3, _CO_PUBLISHER_FILEUPLOAD_ERROR . publisher_formatErrors($fileObj->getErrors()));
            exit;
        } else {
            return _CO_PUBLISHER_FILEUPLOAD_ERROR . publisher_formatErrors($fileObj->getErrors());
        }
    }

    if ($withRedirect) {
        $redirect_page = $another ? 'file.php' : 'item.php';
        redirect_header($redirect_page . "?op=mod&itemid=" . $fileObj->itemid(), 2, _CO_PUBLISHER_FILEUPLOAD_SUCCESS);
    } else {
        return true;
    }
}

function publisher_newFeatureTag()
{
    $ret = '<span style="padding-right: 4px; font-weight: bold; color: red;">' . _CO_PUBLISHER_NEW_FEATURE . '</span>';
    return $ret;
}

/**
 * Smarty truncate_tagsafe modifier plugin
 *
 * Type:     modifier<br>
 * Name:     truncate_tagsafe<br>
 * Purpose:  Truncate a string to a certain length if necessary,
 *           optionally splitting in the middle of a word, and
 *           appending the $etc string or inserting $etc into the middle.
 *           Makes sure no tags are left half-open or half-closed
 *           (e.g. "Banana in a <a...")
 * @author   Monte Ohrt <monte at ohrt dot com>, modified by Amos Robinson
 *           <amos dot robinson at gmail dot com>
 * @param string
 * @param integer
 * @param string
 * @param boolean
 * @param boolean
 * @return string
 */
function publisher_truncateTagSafe($string, $length = 80, $etc = '...', $break_words = false)
{
    if ($length == 0) return '';

    if (strlen($string) > $length) {
        $length -= strlen($etc);
        if (!$break_words) {
            $string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length+1));
            $string = preg_replace('/<[^>]*$/', '', $string);
            $string = publisher_closeTags($string);
        }
        return $string . $etc;
    } else {
        return $string;
    }
}

/**
 * @author   Monte Ohrt <monte at ohrt dot com>, modified by Amos Robinson
 *           <amos dot robinson at gmail dot com>
 */
function publisher_closeTags($string)
{
    // match opened tags
    if(preg_match_all('/<([a-z\:\-]+)[^\/]>/', $string, $start_tags)) {
        $start_tags = $start_tags[1];
        // match closed tags
        if(preg_match_all('/<\/([a-z]+)>/', $string, $end_tags)) {
            $complete_tags = array();
            $end_tags = $end_tags[1];

            foreach($start_tags as $key => $val) {
                $posb = array_search($val, $end_tags);
                if(is_integer($posb)) {
                    unset($end_tags[$posb]);
                } else {
                    $complete_tags[] = $val;
                }
            }
        } else {
            $complete_tags = $start_tags;
        }

        $complete_tags = array_reverse($complete_tags);
        for($i = 0; $i < count($complete_tags); $i++) {
            $string .= '</' . $complete_tags[$i] . '>';
        }
    }
    return $string;
}

function publisher_stripJavascript($text)
{
    return $text;
}

function publisher_makeInfotips($string, $length = 80)
{
    if ($length > 0) {
        $myts =& MyTextSanitizer::getInstance();
        return $myts->htmlSpecialChars(xoops_substr(strip_tags($string), 0, $length));
    }
}

function publisher_ratingBar($itemid)
{
    global $xoopsDB, $xoopsUser;
    $publisher =& PublisherPublisher::getInstance();
    $rating_unitwidth = 30;
    $units = 5;

    $criteria = new Criteria('itemid', $itemid);
    $ratingObjs = $publisher->getHandler('rating')->getObjects($criteria);
    unset($criteria);

    $uid = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : 0;
    $count = count($ratingObjs);
    $current_rating = 0;
    $voted = false;
    $ip = getenv('REMOTE_ADDR');

    foreach ($ratingObjs as $ratingObj) {
        $current_rating += $ratingObj->getVar('rate');
        if ($ratingObj->getVar('ip') == $ip || ($uid > 0 && $uid == $ratingObj->getVar('uid'))) {
            $voted = true;
        }
    }

    $tense = $count == 1 ? _MD_PUBLISHER_VOTE_lVOTE : _MD_PUBLISHER_VOTE_lVOTES; //plural form votes/vote

    // now draw the rating bar
    $rating_width = @number_format($current_rating / $count, 2) * $rating_unitwidth;
    $rating1 = @number_format($current_rating / $count, 1);
    $rating2 = @number_format($current_rating / $count, 2);

    $groups = $xoopsUser ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
    $gperm_handler =& $publisher->getHandler('groupperm');

    if (!$gperm_handler->checkRight('global', _PUBLISHER_RATE, $groups, $publisher->getModule()->getVar('mid'))) {
        $static_rater = array();
        $static_rater[] .= "\n".'<div class="publisher_ratingblock">';
        $static_rater[] .= '<div id="unit_long' . $itemid . '">';
        $static_rater[] .= '<div id="unit_ul' . $itemid . '" class="publisher_unit-rating" style="width:' . $rating_unitwidth * $units . 'px;">';
        $static_rater[] .= '<div class="publisher_current-rating" style="width:' . $rating_width . 'px;">' . _MD_PUBLISHER_VOTE_RATING . ' ' . $rating2 . '/' . $units . '</div>';
        $static_rater[] .= '</div>';
        $static_rater[] .= '<div class="publisher_static">' . _MD_PUBLISHER_VOTE_RATING . ': <strong> ' . $rating1 . '</strong>/' . $units . ' (' . $count . ' ' . $tense.') <br /><em>' . _MD_PUBLISHER_VOTE_DISABLE . '</em></div>';
        $static_rater[] .= '</div>';
        $static_rater[] .= '</div>' . "\n\n";
        return join( "\n", $static_rater );
    } else {
        $rater  = '';
        $rater .= '<div class="publisher_ratingblock">';
        $rater .= '<div id="unit_long' . $itemid . '">';
        $rater .= '<div id="unit_ul' . $itemid . '" class="publisher_unit-rating" style="width:' . $rating_unitwidth * $units . 'px;">';
        $rater .= '<div class="publisher_current-rating" style="width:' . $rating_width . 'px;">' . _MD_PUBLISHER_VOTE_RATING . ' ' . $rating2 . '/' . $units . '</div>';

        for ($ncount = 1; $ncount <= $units; $ncount++) { // loop from 1 to the number of units
            if (!$voted) { // if the user hasn't yet voted, draw the voting stars
                $rater .= '<div><a href="' . PUBLISHER_URL . '/rate.php?itemid=' . $itemid . '&amp;rating=' . $ncount . '" title="' . $ncount . ' ' . _MD_PUBLISHER_VOTE_OUTOF . ' ' . $units . '" class="publisher_r' . $ncount . '-unit rater" rel="nofollow">' . $ncount . '</a></div>';
            }
        }

        $ncount = 0; // resets the count
        $rater .= '  </div>';
        $rater .= '  <div';

        if ($voted) {
            $rater .= ' class="publisher_voted"';
        }

        $rater .= '>' . _MD_PUBLISHER_VOTE_RATING . ': <strong> ' . $rating1 . '</strong>/' . $units . ' (' . $count . ' ' . $tense . ')';
        $rater .= '  </div>';
        $rater .= '</div>';
        $rater .= '</div>';
        return $rater;
    }
}

function publisher_getEditors($allowed_editors = false)
{
    $ret = array();
    xoops_load('XoopsEditorHandler');
    $editor_handler = XoopsEditorHandler::getInstance();
    $editors = $editor_handler->getList($nohtml = false);
    foreach ($editors as $name => $title) {
        $key = publisher_stringToInt($name);
        if (is_array($allowed_editors)) {
            //for submit page
            if (in_array($key, $allowed_editors)) {
                $ret[] = $name;
            }
        } else {
            //for admin permissions page
            $ret[$key]['name'] = $name;
            $ret[$key]['title'] = $title;
        }
    }
    return $ret;
}

function publisher_stringToInt($string = '', $lenght = 5)
{
    for ($i = 0, $final = "", $string = substr(md5($string), $lenght); $i < $lenght; $final .= intval($string[$i]), $i++);
    return intval($final);
}

function publisher_convertCharset($item)
{
    if ( _CHARSET != 'windows-1256') return utf8_encode($item);

    if ($unserialize = unserialize($item)) {
        foreach ($unserialize as $key => $value) {
            $unserialize[$key] = @iconv('windows-1256', 'UTF-8', $value);
        }
        $serialize = serialize($unserialize);
        return $serialize;
    } else {
        return @iconv('windows-1256', 'UTF-8', $item);
    }
}
?>