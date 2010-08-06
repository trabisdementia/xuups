<?php

/**
 * $Id: functions.php,v 1.4 2005/06/02 16:08:20 fx2024 Exp $
 * Module: SmartMedia
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

include_once XOOPS_ROOT_PATH.'/modules/smartmedia/include/common.php';


/**
 * Detemines if a table exists in the current db
 *
 * @param string $table the table name (without XOOPS prefix)
 * @return bool True if table exists, false if not
 *
 * @access public
 * @author xhelp development team
 */
function smartmedia_TableExists($table)
{

    $bRetVal = false;
    //Verifies that a MySQL table exists
    $xoopsDB =& Database::getInstance();
    $realname = $xoopsDB->prefix($table);
    $ret = mysql_list_tables(XOOPS_DB_NAME, $xoopsDB->conn);
    while (list($m_table)=$xoopsDB->fetchRow($ret)) {

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
function smartmedia_GetMeta($key)
{
    $xoopsDB =& Database::getInstance();
    $sql = sprintf("SELECT metavalue FROM %s WHERE metakey=%s", $xoopsDB->prefix('smartmedia_meta'), $xoopsDB->quoteString($key));
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
function smartmedia_SetMeta($key, $value)
{
    $xoopsDB =& Database::getInstance();
    if($ret = smartmedia_GetMeta($key)){
        $sql = sprintf("UPDATE %s SET metavalue = %s WHERE metakey = %s", $xoopsDB->prefix('smartmedia_meta'), $xoopsDB->quoteString($value), $xoopsDB->quoteString($key));
    } else {
        $sql = sprintf("INSERT INTO %s (metakey, metavalue) VALUES (%s, %s)", $xoopsDB->prefix('smartmedia_meta'), $xoopsDB->quoteString($key), $xoopsDB->quoteString($value));
    }
    $ret = $xoopsDB->queryF($sql);
    if (!$ret) {
        return false;
    }
    return true;
}

function smartmedia_setCookieVar($name, $value, $time=0)
{
    if ($time == 0) {
        $time = time()+3600*24*365;
    }
    setcookie($name, $value, $time, '/');
}

function smartmedia_getCookieVar($name, $default='')
{
    if ((isset($_COOKIE[$name])) && ($_COOKIE[$name] > '')) {
        return 	$_COOKIE[$name];
    } else {
        return	$default;
    }
}

function smartmedia_getConfig($key)
{
    $configs = smartmedia_getModuleConfig();
    return $configs[$key];
}

function smartmedia_make_control_disabled() {
    return 'disabled="disabled" style="color: grey;"';
}

function smartmedia_highlighter ($matches) {
    //$color=getmoduleoption('highlightcolor');
    $smartConfig =& smartmedia_getModuleConfig();
    $color = $smartConfig['highlight_color'];
    if(substr($color,0,1)!='#') {
        $color='#'.$color;
    }
    return '<span style="font-weight: bolder; background-color: '.$color.';">' . $matches[0] . '</span>';
}

function smartmedia_metagen_html2text($document)
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
}

function smartmedia_getAllowedMimeTypes()
{
    return "";
    //return array('jpg/jpeg', 'image/bmp', 'image/gif', 'image/jpeg', 'image/jpg', 'image/x-png', 'image/png');
}

function smartmedia_module_home($withLink=true)
{
    global $smartmedia_moduleName;

    if (!$withLink)	{
        return $smartmedia_moduleName;
    } else {
        return '<a href="' . SMARTMEDIA_URL . '">' . $smartmedia_moduleName . '</a>';
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
function smartmedia_copyr($source, $dest)
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

function smartmedia_getStatusArray()
{
    global $xoopsDB;
    $ret = array();
    $sql = "SELECT * FROM " . $xoopsDB->prefix('smartmedia_status') . " ORDER BY status ASC";
    $result = $xoopsDB->query($sql);
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $ret[$myrow['statusid']] = $myrow['status'];
    }
    return $ret;
}

function smartmedia_getFormatArray($forSelectBox = false)
{
    static $smartmedia_formatArray;
    if (!isset($smartmedia_formatArray)) {
        global $xoopsDB;
        $ret = array();
        $sql = "SELECT * FROM " . $xoopsDB->prefix('smartmedia_formats') . " ORDER BY format ASC";
        $result = $xoopsDB->query($sql);
        while ($myrow = $xoopsDB->fetchArray($result)) {
            if ($forSelectBox) {
                $ret[$myrow['formatid']] = $myrow['format'];
            } else {
                $ret[$myrow['formatid']] = $myrow;
            }
        }
        return $ret;
    } else {
        return $smartmedia_formatArray;
    }
}

function displayClip($clipObj, $folderid, $categoryid, $from_within=false)
{
    Global $xoopsModule, $smartmedia_clip_handler;

    if ($from_within) {
        $extra = "&from_within=1";
    }

    $modify = "<a href='clip.php?op=mod&clipid=" . $clipObj->clipid() . "&folderid=$folderid" . $extra . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_SMEDIA_CLIP_EDIT . "' alt='" . _AM_SMEDIA_CLIP_EDIT . "' /></a>";
    $delete = "<a href='clip.php?op=del&clipid=" . $clipObj->clipid() . "&folderid=$folderid" . $extra . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_SMEDIA_CLIP_DELETE . "' alt='" . _AM_SMEDIA_CLIP_DELETE . "' /></a>";

    $description = $clipObj->description();
    if (!XOOPS_USE_MULTIBYTES) {
        if (strlen($description) >= 100) {
            $description = substr($description, 0, (100 -1)) . "...";
        }
    }

    echo "<tr>";
    echo "<td class='even' align='left'>&nbsp;&nbsp;</td>";
    echo "<td class='even' align='left'>" . "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/clip.php?categoryid=" . $categoryid . "&folderid=" . $folderid . "&clipid=" . $clipObj->clipid() . "'><img src='" . XOOPS_URL . "/modules/smartmedia/images/icon/clip.gif' alt='' />&nbsp;" . $clipObj->title() . "</a></td>";
    echo "<td class='even' align='left'>" . $description . "</td>";
    echo "<td class='even' align='center'>" . $clipObj->weight() . "</td>";
    echo "<td class='even' align='right'> $modify $delete </td>";
    echo "</tr>";
}

function displayFolder($folderObj, $categoryid)
{
    Global $xoopsModule, $smartmedia_folder_handler;

    //var_dump($folderObj);
    $show_clips = "<a href='clip.php?op=show_within&folderid=" . $folderObj->folderid() . "&categoryid=$categoryid'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/show_clips.gif' title='" . _AM_SMEDIA_FOLDER_SHOW_CLIP . "' alt='" . _AM_SMEDIA_FOLDER_SHOW_CLIP . "' /></a>";
    $modify = "<a href='folder.php?op=mod&folderid=" . $folderObj->folderid() . "&categoryid=$categoryid'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_SMEDIA_FOLDER_EDIT . "' alt='" . _AM_SMEDIA_FOLDER_EDIT . "' /></a>";
    $delete = "<a href='folder.php?op=del&folderid=" . $folderObj->folderid() . "&categoryid=$categoryid'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_SMEDIA_FOLDER_DELETE . "' alt='" . _AM_SMEDIA_FOLDER_DELETE . "' /></a>";

    $description = $folderObj->description();
    if (!XOOPS_USE_MULTIBYTES) {
        if (strlen($description) >= 100) {
            $description = substr($description, 0, (100 -1)) . "...";
        }
    }

    echo "<tr>";
    echo "<td class='even' align='left'>&nbsp;&nbsp;</td>";
    echo "<td class='even' align='left'>" . "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/folder.php?categoryid=$categoryid&folderid=" . $folderObj->folderid() . "'><img src='" . XOOPS_URL . "/modules/smartmedia/images/icon/folder.gif' alt='' />&nbsp;" . $folderObj->title() . "</a></td>";
    echo "<td class='even' align='left'>" . $description . "</td>";
    echo "<td class='even' align='center'>" . $folderObj->weight() . "</td>";
    echo "<td class='even' align='right'> $show_clips $modify $delete </td>";
    echo "</tr>";
}

function displayCategory($categoryObj, $level = 0, $showFolders=false, $foldersCategoriesObj=null)
{
    Global $xoopsModule, $smartmedia_category_handler;

    $modify = "<a href='category.php?op=mod&categoryid=" . $categoryObj->categoryid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_SMEDIA_EDITCOL . "' alt='" . _AM_SMEDIA_EDITCOL . "' /></a>";
    $delete = "<a href='category.php?op=del&categoryid=" . $categoryObj->categoryid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_SMEDIA_DELETECOL . "' alt='" . _AM_SMEDIA_DELETECOL . "' /></a>";

    $description = $categoryObj->description();
    if (!XOOPS_USE_MULTIBYTES) {
        if (strlen($description) >= 100) {
            $description = substr($description, 0, (100 -1)) . "...";
        }
    }

    $spaces = '';
    for ( $j = 0; $j < $level; $j++ ) {
        $spaces .= '&nbsp;&nbsp;&nbsp;';
    }

    if (!$showFolders) {
        $col_span = " colspan='2' ";
    } else {
        $col_span = "";
    }

    echo "<tr>";
    echo "<td colspan='2' class='even' align='lefet'>" . $spaces . "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/category.php?categoryid=" . $categoryObj->categoryid() . "'><img src='" . XOOPS_URL . "/modules/smartmedia/images/icon/subcat.gif' alt='' />&nbsp;" . $categoryObj->title() . "</a></td>";
    echo "<td class='even' align='left'>" . $description . "</td>";
    echo "<td class='even' align='center'>" . $categoryObj->weight() . "</td>";
    echo "<td class='even' align='right'> $modify $delete </td>";
    echo "</tr>";

    if ($foldersCategoriesObj){
        foreach ($foldersCategoriesObj[$categoryObj->categoryid()] as $folderObj) {
            displayFolder($folderObj, $categoryObj->categoryid());
        }
    }

    $subCategoriesObj = $smartmedia_category_handler->getCategories(0, 0, $categoryObj->categoryid());
    if (count($subCategoriesObj) > 0) {
        $level++;
        foreach ( $subCategoriesObj as $key => $thiscat ) {
            displayCategory($thiscat, $level);
        }
    }
    unset($categoryObj);
}

function displayFolderForClip($folderObj, $level = 0, $showClips=false, $clipsFoldersObj=null, $categoryid, $from_within = false)
{
    Global $xoopsModule, $smartmedia_folder_handler;

    $modify = "<a href='folder.php?op=mod&folderid=" . $folderObj->folderid() . "&categoryid=" . $categoryid . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_SMEDIA_FOLDER_EDIT . "' alt='" . _AM_SMEDIA_FOLDER_EDIT . "' /></a>";
    $delete = "<a href='folder.php?op=del&folderid=" . $folderObj->folderid() . "&categoryid=" . $categoryid . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_SMEDIA_FOLDER_DELETE . "' alt='" . _AM_SMEDIA_FOLDER_DELETE . "' /></a>";

    $description = $folderObj->description();
    if (!XOOPS_USE_MULTIBYTES) {
        if (strlen($description) >= 100) {
            $description = substr($description, 0, (100 -1)) . "...";
        }
    }

    $spaces = '';
    for ( $j = 0; $j < $level; $j++ ) {
        $spaces .= '&nbsp;&nbsp;&nbsp;';
    }

    if (!$showClips) {
        $col_span = " colspan='2' ";
    } else {
        $col_span = "";
    }

    echo "<tr>";
    echo "<td colspan='2' class='even' align='lefet'>" . $spaces . "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/folder.php?folderid=" . $folderObj->folderid() . "&categoryid=" . $categoryid . "'><img src='" . XOOPS_URL . "/modules/smartmedia/images/icon/folder.gif' alt='' />&nbsp;" . $folderObj->title() . "</a></td>";
    echo "<td class='even' align='left'>" . $description . "</td>";
    echo "<td class='even' align='center'>" . $folderObj->weight() . "</td>";
    echo "<td class='even' align='right'> $modify $delete </td>";
    echo "</tr>";

    if ($clipsFoldersObj){
        foreach ($clipsFoldersObj[$folderObj->folderid()] as $clipObj) {
            displayClip($clipObj, $folderObj->folderid(), $categoryid, $from_within);
        }
    }

    unset($folderObj);
}


/**
 * Thanks to the NewBB2 Development Team
 */
function &smartmedia_admin_getPathStatus($item, $getStatus=false)
{
    if ($item == 'root') {
        $path = '';
    } else {
        $path = $item;
    }

    $thePath = smartmedia_getUploadDir(true, $path);

    if(empty($thePath)) return false;
    if(@is_writable($thePath)){
        $pathCheckResult = 1;
        $path_status = _AM_SMEDIA_AVAILABLE;
    }elseif(!@is_dir($thePath)){
        $pathCheckResult = -1;
        $path_status = _AM_SMEDIA_NOTAVAILABLE." <a href=index.php?op=createdir&amp;path=$item>"._AM_SMEDIA_CREATETHEDIR.'</a>';
    }else{
        $pathCheckResult = -2;
        $path_status = _AM_SMEDIA_NOTWRITABLE." <a href=index.php?op=setperm&amp;path=$item>"._AM_SCS_SETMPERM.'</a>';
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
function smartmedia_admin_mkdir($target)
{
    // http://www.php.net/manual/en/function.mkdir.php
    // saint at corenova.com
    // bart at cdasites dot com
    if (is_dir($target)||empty($target)) return true; // best case check first
    if (file_exists($target) && !is_dir($target)) return false;
    if (smartmedia_admin_mkdir(substr($target,0,strrpos($target,'/'))))
    if (!file_exists($target)) return mkdir($target); // crawl back up & create dir tree
    return true;
}

/**
 * Thanks to the NewBB2 Development Team
 */
function smartmedia_admin_chmod($target, $mode = 0777)
{
    return @chmod($target, $mode);
}


function smartmedia_getUploadDir($local=true, $item=false)
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
        return XOOPS_ROOT_PATH . "/uploads/smartmedia/$item";
    } else {
        return XOOPS_URL . "/uploads/smartmedia/$item";
    }
}

function smartmedia_getImageDir($item='', $local=true)
{
    if ($item) {
        $item = "images/$item";
    } else {
        $item = 'images';
    }

    return smartmedia_getUploadDir($local, $item);
}


function smartmedia_getModuleImageDir($item='', $local=true)
{
    if ($item) {
        $imagedir = 'images/' . $item . '/';
    } else {
        $imagedir = 'images/';
    }

    if ($local) {
        return SMARTMEDIA_ROOT_PATH . $imagedir;
    } else {
        return SMARTMEDIA_URL . $imagedir;
    }
}


function smartmedia_imageResize($src, $maxWidth, $maxHeight)
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

function smartmedia_getHelpPath()
{
    $smartConfig =& smartmedia_getModuleConfig();
    switch ($smartConfig['helppath_select'])
    {
        case 'docs.xoops.org' :
            return 'http://docs.xoops.org/help/ssectionh/index.htm';
            break;

        case 'inside' :
            return XOOPS_URL . "/modules/smartmedia/doc/";
            break;

        case 'custom' :
            return $smartConfig['helppath_custom'];
            break;
    }
}

function &smartmedia_getModuleInfo()
{
    static $smartModule;
    if (!isset($smartModule)) {
        global $xoopsModule;
        if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == 'smartmedia') {
            $smartModule =& $xoopsModule;
        }
        else {
            $hModule = &xoops_gethandler('module');
            $smartModule = $hModule->getByDirname('smartmedia');
        }
    }
    return $smartModule;
}

function &smartmedia_getModuleConfig()
{
    static $smartConfig;
    if (!$smartConfig) {
        global $xoopsModule;
        if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == 'smartmedia') {
            global $xoopsModuleConfig;
            $smartConfig =& $xoopsModuleConfig;
        }
        else {
            $smartModule =& smartmedia_getModuleInfo();
            $hModConfig = &xoops_gethandler('config');
            $smartConfig = $hModConfig->getConfigsByCat(0, $smartModule->getVar('mid'));
        }
    }
    return $smartConfig;
}


function smartmedia_deleteFile($dirname)
{
    // Simple delete for a file
    if (is_file($dirname)) {
        return unlink($dirname);
    }
}

function smartmedia_formatErrors($errors=array())
{
    $ret = '';
    foreach ($errors as $key=>$value)
    {
        $ret .= "<br /> - " . $value;
    }
    return $ret;
}

function smartmedia_addCategoryOption($categoryObj, $selectedid=0, $level = 0, $ret='')
{
    // Creating the category handler object
    $category_handler =& smartmedia_gethandler('category');
    $spaces = '';
    for ( $j = 0; $j < $level; $j++ ) {
        $spaces .= '--';
    }

    $ret .= "<option value='" . $categoryObj->categoryid() . "'";
    if ($selectedid == $categoryObj->categoryid()) {
        $ret .= " selected='selected'";
    }
    $ret .= ">" . $spaces . $categoryObj->name() . "</option>\n";

    $subCategoriesObj = $category_handler->getCategories(0, 0, $categoryObj->categoryid());
    if (count($subCategoriesObj) > 0) {
        $level++;
        foreach ( $subCategoriesObj as $catID => $subCategoryObj) {
            $ret .= smartmedia_addCategoryOption($subCategoryObj, $selectedid, $level);
        }
    }
    return $ret;
}

function smartmedia_createCategoryOptions($selectedid=0, $parentcategory=0, $allCatOption=true)
{
    $ret = "";
    If ($allCatOption) {
        $ret .= "<option value='0'";
        $ret .= ">" . _MB_SMEDIA_ALLCAT . "</option>\n";
    }

    // Creating the category handler object
    $category_handler =& smartmedia_gethandler('category');

    // Creating category objects
    $categoriesObj = $category_handler->getCategories(0, 0, $parentcategory);
    if (count($categoriesObj) > 0) {
        foreach ( $categoriesObj as $catID => $categoryObj) {
            $ret .= smartmedia_addCategoryOption($categoryObj, $selectedid);
        }
    }
    return $ret;
}

function smartmedia_moderator ()
{
    global $xoopsUser, $xoopsDB, $xoopsConfig, $xoopsUser;

    If (!$xoopsUser) {
        $result = false;
    } else {
        $hModule = &xoops_gethandler('module');
        $hModConfig = &xoops_gethandler('config');

        if ($smartModule = &$hModule->getByDirname('smartmedia')) {
            $module_id = $smartModule->getVar('mid');
        }

        $module_name = $smartModule->getVar('dirname');
        $smartConfig = &$hModConfig->getConfigsByCat(0, $smartModule->getVar('mid'));

        $gperm_handler = &xoops_gethandler('groupperm');

        $categories = $gperm_handler->getItemIds('category_moderation', $xoopsUser->getVar('uid'), $module_id);
        If (count($categories) == 0) {
            $result = false;
        } else {
            $result = true;
        }
    }
    return $result;
}

function smartmedia_modFooter ()
{
    global $xoopsUser, $xoopsDB, $xoopsConfig;

    $hModule = &xoops_gethandler('module');
    $hModConfig = &xoops_gethandler('config');

    $smartModule = &$hModule->getByDirname('smartmedia');
    $module_id = $smartModule->getVar('mid');

    $module_name = $smartModule->getVar('dirname');
    $smartConfig = &$hModConfig->getConfigsByCat(0, $smartModule->getVar('mid'));

    $module_id = $smartModule->getVar('mid');

    $versioninfo = &$hModule->get($smartModule->getVar('mid'));
    $modfootertxt = "Module " . $versioninfo->getInfo('name') . " - Version " . $versioninfo->getInfo('version') . "";

    $modfooter = "<a href='" . $versioninfo->getInfo('developer_website_url') . "' target='_blank'><img src='" . XOOPS_URL . "/modules/smartmedia/images/sscssbutton.gif' title='" . $modfootertxt . "' alt='" . $modfootertxt . "'/></a>";

    echo "<div style='padding-top: 10px;' align='center'>" . $modfooter . "</div>";
}

/**
 * Checks if a user is admin of SmartMedia
 *
 * smartmedia_userIsAdmin()
 *
 * @return boolean : array with userids and uname
 */
function smartmedia_userIsAdmin()
{
    global $xoopsUser, $xoopsModule;

    $result = false;

    $hModule = &xoops_gethandler('module');
    if ($smartModule = &$hModule->getByDirname('smartmedia')) {
        $module_id = $smartModule->getVar('mid');
    }

    if (!empty($xoopsUser)) {
        $groups = $xoopsUser->getGroups();
        $result = (in_array(XOOPS_GROUP_ADMIN, $groups)) || ($xoopsUser->isAdmin($module_id));
    }
    return $result;
}

/**
 * Checks if a user has access to a selected item. If no item permissions are
 * set, access permission is denied. The user needs to have necessary category
 * permission as well.
 *
 * smartmedia_itemAccessGranted()
 *
 * @param integer $itemid : itemid on which we are setting permissions
 * @param integer $ categoryid : categoryid of the item
 * @return boolean : TRUE if the no errors occured
 */

// TODO : Move this function to ssItem class
function smartmedia_itemAccessGranted($itemid, $categoryid)
{
    Global $xoopsUser;

    if (smartmedia_userIsAdmin()) {
        $result = true;
    } else {
        $result = false;

        $groups = ($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;

        $gperm_handler = &xoops_gethandler('groupperm');
        $hModule = &xoops_gethandler('module');
        $hModConfig = &xoops_gethandler('config');

        $smartModule = &$hModule->getByDirname('smartmedia');

        $module_id = $smartModule->getVar('mid');
        // Do we have access to the parent category
        If ($gperm_handler->checkRight('category_read', $categoryid, $groups, $module_id)) {
            // Do we have access to the item ?
            If ($gperm_handler->checkRight('item_read', $itemid, $groups, $module_id)) {
                $result = true;
            } else { // No we don't !
                $result = false;
            }
        } else { // No we don't !
            $result = false;
        }
    }

    return $result;
}

/**
 * Override ITEMs permissions of a category by the category read permissions
 *
 *   smartmedia_overrideItemsPermissions()
 *
 * @param array $groups : group with granted permission
 * @param integer $categoryid :
 * @return boolean : TRUE if the no errors occured
 */
function smartmedia_overrideItemsPermissions($groups, $categoryid)
{
    Global $xoopsDB;

    $result = true;
    $hModule = &xoops_gethandler('module');
    $smartModule = &$hModule->getByDirname('smartmedia');

    $module_id = $smartModule->getVar('mid');
    $gperm_handler = &xoops_gethandler('groupperm');

    $sql = "SELECT itemid FROM " . $xoopsDB->prefix("smartmedia_item") . " WHERE categoryid = '$categoryid' ";
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
 *   smartmedia_saveItemPermissions()
 *
 * @param array $groups : group with granted permission
 * @param integer $itemID : itemid on which we are setting permissions
 * @return boolean : TRUE if the no errors occured

 */
function smartmedia_saveItemPermissions($groups, $itemID)
{
    $result = true;
    $hModule = &xoops_gethandler('module');
    $smartModule = &$hModule->getByDirname('smartmedia');

    $module_id = $smartModule->getVar('mid');
    $gperm_handler = &xoops_gethandler('groupperm');
    // First, if the permissions are already there, delete them
    $gperm_handler->deleteByModule($module_id, 'item_read', $itemID);
    // Save the new permissions
    if (count($groups) > 0) {
        foreach ($groups as $group_id) {
            $gperm_handler->addRight('item_read', $itemID, $group_id, $module_id);
        }
    }
    return $result;
}

/**
 * Saves permissions for the selected category
 *
 *   smartmedia_saveCategory_Permissions()
 *
 * @param array $groups : group with granted permission
 * @param integer $categoryid : categoryid on which we are setting permissions
 * @param string $perm_name : name of the permission
 * @return boolean : TRUE if the no errors occured
 */

function smartmedia_saveCategory_Permissions($groups, $categoryid, $perm_name)
{
    $result = true;
    $hModule = &xoops_gethandler('module');
    $smartModule = &$hModule->getByDirname('smartmedia');

    $module_id = $smartModule->getVar('mid');
    $gperm_handler = &xoops_gethandler('groupperm');
    // First, if the permissions are already there, delete them
    $gperm_handler->deleteByModule($module_id, $perm_name, $categoryid);
    // Save the new permissions
    if (count($groups) > 0) {
        foreach ($groups as $group_id) {
            $gperm_handler->addRight($perm_name, $categoryid, $group_id, $module_id);
        }
    }
    return $result;
}

/**
 * Saves permissions for the selected category
 *
 *   smartmedia_saveModerators()
 *
 * @param array $moderators : moderators uids
 * @param integer $categoryid : categoryid on which we are setting permissions
 * @return boolean : TRUE if the no errors occured
 */

function smartmedia_saveModerators($moderators, $categoryid)
{
    $result = true;
    $hModule = &xoops_gethandler('module');
    $smartModule = &$hModule->getByDirname('smartmedia');
    $module_id = $smartModule->getVar('mid');
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


/**
 * smartmedia_getAdminLinks()
 *
 * @param integer $itemid
 * @return
 */


/**
 * sf_getLinkedUnameFromId()
 *
 * @param integer $userid Userid of poster etc
 * @param integer $name :  0 Use Usenamer 1 Use realname
 * @return
 */
function smartmedia_getLinkedUnameFromId($userid = 0, $name = 0, $users = array())
{
    if (!is_numeric($userid)) {
        return $userid;
    }

    $userid = intval($userid);
    if ($userid > 0) {
        if ($users == array()) {
            //fetching users
            $member_handler = &xoops_gethandler('member');
            $user = &$member_handler->getUser($userid);
        }
        else {
            if (!isset($users[$userid])) {
                return $GLOBALS['xoopsConfig']['anonymous'];
            }
            $user =& $users[$userid];
        }

        if (is_object($user)) {
            $ts = &MyTextSanitizer::getInstance();
            $username = $user->getVar('uname');
            $fullname = '';
             
            $fullname2 = $user->getVar('name');
             
            if (($name) && !empty($fullname2)) {
                $fullname = $user->getVar('name');
            }
            if (!empty($fullname)) {
                $linkeduser = "$fullname [<a href='" . XOOPS_URL . "/userinfo.php?uid=" . $userid . "'>" . $ts->htmlSpecialChars($username) . "</a>]";
            } else {
                $linkeduser = "<a href='" . XOOPS_URL . "/userinfo.php?uid=" . $userid . "'>" . ucwords($ts->htmlSpecialChars($username)) . "</a>";
            }
            return $linkeduser;
        }
    }
    return $GLOBALS['xoopsConfig']['anonymous'];
}

function smartmedia_getxoopslink($url = '')
{
    $xurl = $url;
    If (strlen($xurl) > 0) {
        If ($xurl[0] = '/') {
            $xurl = str_replace('/', '', $xurl);
        }
        $xurl = str_replace('{SITE_URL}', XOOPS_URL, $xurl);
    }
    $xurl = $url;
    return $xurl;
}

function smartmedia_adminMenu ($currentoption = 0, $breadcrumb = '')
{

    /* Nice buttons styles */
    echo "
    	<style type='text/css'>
    	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
    	#buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/smartmedia/images/bg.gif') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }
    	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
		#buttonbar li { display:inline; margin:0; padding:0; }
		#buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/smartmedia/images/left_both.gif') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
		#buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/smartmedia/images/right_both.gif') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
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
    $myts = &MyTextSanitizer::getInstance();

    $tblColors = Array();
    $tblColors[0] = $tblColors[1] = $tblColors[2] = $tblColors[3] = $tblColors[4] = $tblColors[5] = $tblColors[6] = $tblColors[7] = $tblColors[8] = '';
    $tblColors[$currentoption] = 'current';
    if (file_exists(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
        include_once '../language/' . $xoopsConfig['language'] . '/modinfo.php';
    } else {
        include_once '../language/english/modinfo.php';
    }

    echo "<div id='buttontop'>";
    echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
    //echo "<td style=\"width: 45%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a class=\"nobutton\" href=\"../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoopsModule->getVar('mid') . "\">" . _AM_SMEDIA_OPTS . "</a> | <a href=\"../index.php\">" . _AM_SMEDIA_GOMOD . "</a> | <a href='" . smartmedia_getHelpPath() ."' target=\"_blank\">" . _AM_SMEDIA_HELP . "</a> | <a href=\"about.php\">" . _AM_SMEDIA_ABOUT . "</a></td>";
    echo "<td style=\"width: 65%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a class=\"nobutton\" href=\"../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoopsModule->getVar('mid') . "\">" . _AM_SMEDIA_OPTS . "</a> | <a href='" . XOOPS_URL . "/modules/system/admin.php?fct=modulesadmin&op=update&module=" . $xoopsModule->getVar('dirname') . "'>" . _AM_SMEDIA_UPDATE_MODULE . " | <a href='" . SMARTMEDIA_URL . "admin/upgrade.php?op=checkTables'>" . _AM_SMEDIA_DB_CHECKTABLES . " | <a href=\"../index.php\">" . _AM_SMEDIA_GOMOD . "</a> | <a href=\"about.php\">" . _AM_SMEDIA_ABOUT . "</a></td>";
    //echo "<td style=\"width: 55%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;\"><b>" . $myts->displayTarea($xoopsModule->name()) . " " . _AM_SMEDIA_MODADMIN . "</b> " . $breadcrumb . "</td>";
    echo "<td style=\"width: 55%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;\">" . $breadcrumb . "</td>";
    echo "</tr></table>";
    echo "</div>";

    echo "<div id='buttonbar'>";
    echo "<ul>";
    echo "<li id='" . $tblColors[0] . "'><a href=\"index.php\"><span>" . _AM_SMEDIA_INDEX . "</span></a></li>";
    echo "<li id='" . $tblColors[1] . "'><a href=\"category.php\"><span>" . _AM_SMEDIA_CATEGORIES . "</span></a></li>";
    echo "<li id='" . $tblColors[2] . "'><a href=\"folder.php\"><span>" . _AM_SMEDIA_FOLDERS . "</span></a></li>";
    echo "<li id='" . $tblColors[3] . "'><a href=\"clip.php\"><span>" . _AM_SMEDIA_CLIPS . "</span></a></li>";
    echo "<li id='" . $tblColors[4] . "'><a href=\"format.php\"><span>" . _AM_SMEDIA_FORMATS . "</span></a></li>";
    echo "<li id='" . $tblColors[5] . "'><a href=\"myblocksadmin.php\"><span>" . _AM_SMEDIA_BLOCKSANDGROUPS . "</span></a></li>";
    echo "</ul></div>";
}

function smartmedia_collapsableBar($tablename = '', $iconname = '')
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

function &smartmedia_gethandler($name)
{
    static $smartmedia_handlers;

    if (!isset($smartmedia_handlers[$name])) {
        $smartmedia_handlers[$name] =& xoops_getmodulehandler($name, 'smartmedia');
    }
    return $smartmedia_handlers[$name];
}

?>