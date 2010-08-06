<?php

/**
 * $Id: index.php,v 1.1 2005/05/13 18:21:55 malanciault Exp $
 * Module: SmartMedia
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

include_once("admin_header.php");
$myts = &MyTextSanitizer::getInstance();

$op = isset($_GET['op']) ? $_GET['op'] : '';

// Test de la fonction getFolders

$smartmedia_folder_handler = smartmedia_gethandler('folder');

/*$limit = 6;
 $start = 3;
 echo "limit : $limit -- start : $start<br /><br />";
 $folders = $smartmedia_folder_handler->getfolders($limit, $start, '', '', 'parent.categoryid ASC, weight ASC, parent.folderid', 'ASC');
 echo "<br />";
 foreach ($folders as $foldercat) {
 foreach($foldercat as $folder) {
 echo "folderid : " . $folder->folderid() . "<br />";
 }
 }
 exit;*/

switch ($op) {
    case "createdir":
        $path = isset($_GET['path']) ? $_GET['path'] : false;
        if ($path) {
            if ($path == 'root') {
                $path = '';
            }
            $thePath = smartmedia_getUploadDir(true, $path);
            $res = smartmedia_admin_mkdir($thePath);
            if ($res) {
                $source = SMARTMEDIA_ROOT_PATH . "images/blank.png";
                $dest = $thePath . "blank.png";
                smartmedia_copyr($source, $dest);
            }
            $msg = ($res)?_AM_SMEDIA_DIRCREATED:_AM_SMEDIA_DIRNOTCREATED;

        } else {
            $msg = _AM_SMEDIA_DIRNOTCREATED;
        }

        redirect_header('index.php', 2, $msg . ': ' . $thePath);
        exit();
        break;

}

function pathConfiguration()
{
    global $xoopsModule;
    // Upload and Images Folders
    smartmedia_collapsableBar('configtable', 'configtableicon');
    echo "<img id='configtableicon' name='configtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SMEDIA_PATHCONFIGURATION . "</h3>";
    echo "<div id='configtable'>";
    echo "<br />";
    echo "<table width='100%' class='outer' cellspacing='1' cellpadding='3' border='0' ><tr>";
    echo "<td class='bg3'><b>" . _AM_SMEDIA_PATH_ITEM . "</b></td>";
    echo "<td class='bg3'><b>" . _AM_SMEDIA_PATH . "</b></td>";
    echo "<td class='bg3' align='center'><b>" . _AM_SMEDIA_STATUS . "</b></td></tr>";
    echo "<tr><td class='odd'>" . _AM_SMEDIA_PATH_FILES . "</td>";
    $upload_path = smartmedia_getUploadDir();

    echo "<td class='odd'>" . $upload_path . "</td>";
    echo "<td class='even' style='text-align: center;'>" . smartmedia_admin_getPathStatus('root') . "</td></tr>";

    echo "<tr><td class='odd'>" . _AM_SMEDIA_PATH_IMAGES . "</td>";
    $image_path = smartmedia_getImageDir();
    echo "<td class='odd'>" . $image_path . "</td>";
    echo "<td class='even' style='text-align: center;'>" . smartmedia_admin_getPathStatus('images') . "</td></tr>";

    echo "<tr><td class='odd'>" . _AM_SMEDIA_PATH_IMAGES_CATEGORY . "</td>";
    $image_path = smartmedia_getImageDir('category');
    echo "<td class='odd'>" . $image_path . "</td>";
    echo "<td class='even' style='text-align: center;'>" . smartmedia_admin_getPathStatus('images/category') . "</td></tr>";

    echo "<tr><td class='odd'>" . _AM_SMEDIA_PATH_IMAGES_FOLDER . "</td>";
    $image_path = smartmedia_getImageDir('folder');
    echo "<td class='odd'>" . $image_path . "</td>";
    echo "<td class='even' style='text-align: center;'>" . smartmedia_admin_getPathStatus('images/folder') . "</td></tr>";

    echo "<tr><td class='odd'>" . _AM_SMEDIA_PATH_IMAGES_CLIP . "</td>";
    $image_path = smartmedia_getImageDir('clip');
    echo "<td class='odd'>" . $image_path . "</td>";
    echo "<td class='even' style='text-align: center;'>" . smartmedia_admin_getPathStatus('images/clip') . "</td></tr>";

    echo "</table>";
    echo "<br />";

    echo "</div>";
}

include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';

global $smartmedia_category_handler, $smartmedia_item_handler;


xoops_cp_header();
global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $xoopsModule, $itemid;

smartmedia_adminMenu(0, _AM_SMEDIA_INDEX);

// Total categories
$totalcategories = $smartmedia_category_handler->getCategoriesCount(-1);

// Total Folders
$totalfolders = $smartmedia_folder_handler->getFoldersCount();

// Total Clips
$totalclips = $smartmedia_clip_handler->getClipsCount();

// Check Path Configuration
if ((smartmedia_admin_getPathStatus('root', true) < 0) ||
(smartmedia_admin_getPathStatus('images', true) < 0) ||
(smartmedia_admin_getPathStatus('images/category', true) < 0) ||
(smartmedia_admin_getPathStatus('images/folder', true) < 0) ||
(smartmedia_admin_getPathStatus('images/clip', true) < 0)
) {
    pathConfiguration();
}

// -- //
smartmedia_collapsableBar('toptable', 'toptableicon');
echo "<img id='toptableicon' name='toptableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SMEDIA_INVENTORY . "</h3>";
echo "<div id='toptable'>";
echo "<br />";
echo "<table width='100%' class='outer' cellspacing='1' cellpadding='3' border='0' ><tr>";
echo "<td class='head'>" . _AM_SMEDIA_TOTALCAT . "</td><td align='center' class='even'>" . $totalcategories . "</td>";
echo "<td class='head'>" . _AM_SMEDIA_TOTALFOLDERS . "</td><td align='center' class='even'>" . $totalfolders . "</td>";
echo "<td class='head'>" . _AM_SMEDIA_TOTALCLIPS . "</td><td align='center' class='even'>" . $totalclips . "</td>";
echo "</tr></table>";
echo "<br />";

echo "<form><div style=\"margin-bottom: 24px;\">";
echo "<input type='button' name='button' onclick=\"location='category.php?op=mod'\" value='" . _AM_SMEDIA_CATEGORY_CREATE . "'>&nbsp;&nbsp;";
echo "<input type='button' name='button' onclick=\"location='folder.php?op=mod'\" value='" . _AM_SMEDIA_FOLDER_CREATE . "'>&nbsp;&nbsp;";
echo "<input type='button' name='button' onclick=\"location='clip.php?op=mod'\" value='" . _AM_SMEDIA_CLIP_CREATE . "'>&nbsp;&nbsp;";
echo "</div></form>";
echo "</div>";

// Check Path Configuration
// Check Path Configuration
if ((smartmedia_admin_getPathStatus('root', true) > 0) &&
(smartmedia_admin_getPathStatus('images', true) > 0) &&
(smartmedia_admin_getPathStatus('images/category', true) > 0) &&
(smartmedia_admin_getPathStatus('images/folder', true) > 0) &&
(smartmedia_admin_getPathStatus('images/clip', true) > 0)
) {
    pathConfiguration();
}

echo "</div>";


$modfooter = smartmedia_modFooter();
echo "<div align='center'>" . $modfooter . "</div>";

xoops_cp_footer();

?>