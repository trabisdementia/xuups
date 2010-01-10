<?php
/**
 * Article module for XOOPS
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code 
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         article
 * @since           1.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: index.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";
/**
 * Function to check status of a folder
 *
 * @return bool
 */
function art_admin_getPathStatus($path)
{
    if (empty($path)) return false;
    if (@is_writable($path)) {
        $path_status = art_constant("AM_AVAILABLE");
    } elseif (!@is_dir($path)) {
        $path_status = "<font color=\"red\">" . art_constant("AM_NOTAVAILABLE") . "</font> <a href=" . XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/admin/index.php?op=createdir&amp;path={$path}>" . art_constant("AM_CREATETHEDIR") . "</a>";
    } else {
        $path_status = "<font color=\"red\">" . art_constant("AM_NOTWRITABLE") . "</font> <a href=" . XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/admin/index.php?op=setperm&amp;path={$path}>" . art_constant("AM_SETMPERM") . "</a>";
    }
    return $path_status;
}

/**
 * Function to create directory tree recursively
 *
 * From http://www.php.net/manual/en/function.mkdir.php
 * ".." in path is filtered out however the fullpath is not checked since the action is assumed to access by admin only, which is reasonably trustable
 * 
 *
 * @return bool
 */
function art_admin_mkdir($strPath, $mode = 0777)
{
    $strPath = str_replace("..", "", $strPath);
    return is_dir($strPath) || ( art_admin_mkdir(dirname($strPath), $mode) && @mkdir($strPath, $mode) );
}

function art_admin_chmod($target, $mode = 0777)
{
    $target = str_replace("..", "", $target);
    return @chmod($target, $mode);
}

xoops_cp_header();

$op = (isset($_GET['op'])) ? $_GET['op'] : "";

switch ($op) {
    case "createdir":
        if (isset($_GET['path'])) $path = $_GET['path'];
        $res = art_admin_mkdir($path);
        $msg = ($res) ? art_constant("AM_DIRCREATED") : art_constant("AM_DIRNOTCREATED");
        redirect_header('index.php', 2, $msg . ': ' . $path);
        exit();
        break;

    case "setperm":
        if (isset($_GET['path'])) $path = $_GET['path'];
        $res = art_admin_chmod($path, 0777);
        $msg = ($res) ? art_constant("AM_PERMSET") : art_constant("AM_PERMNOTSET");
        redirect_header('index.php', 2, $msg . ': ' . $path);
        exit();
        break;

    case "default":
    default:
    break;
}


loadModuleAdminMenu(0);

$form = "
    <style type=\"text/css\">
    label,text {
        display: block;
        float: left;
        margin-bottom: 2px;
    }
    label {
        text-align: right;
        width: 150px;
        padding-right: 20px;
    }
    br {
        clear: left;
    }
    </style>
";

$form .= "<fieldset><legend style='font-weight: bold; color: #900;'>" . art_constant("AM_PREFERENCES") . "</legend>";
$form .= "<div style='padding: 8px;'>";
$form .= "<label>" . "<strong>PHP Version:</strong>" . ":</label><text>" . phpversion() . "</text><br />";
$form .= "<label>" . "<strong>MySQL Version:</strong>" . ":</label><text>" . mysql_get_server_info() . "</text><br />";
$form .= "<label>" . "<strong>XOOPS Version:</strong>" . ":</label><text>" . XOOPS_VERSION . "</text><br />";
$form .= "<label>" . "<strong>Module Version:</strong>" . ":</label><text>" . $xoopsModule->getInfo('version') . "</text><br />";
$form .= "</div>";
$form .= "<div style='padding: 8px;'>";
$form .= "<label>" . art_constant("AM_SAFEMODE") . ":</label><text>";
$form .= ( ini_get( 'safe_mode' ) ) ? art_constant("AM_ON") : art_constant("AM_OFF");
$form .= "</text><br />";
$form .= "<label>" . art_constant("AM_REGISTERGLOBALS") . ":</label><text>";
$form .= ( ini_get( 'register_globals' )) ? art_constant("AM_ON") : art_constant("AM_OFF");
$form .= "</text><br />";
$form .= "<label>" . art_constant("AM_MAGICQUOTESGPC") . ":</label><text>";
$form .= ( ini_get( 'magic_quotes_gpc' )) ? art_constant("AM_ON") : art_constant("AM_OFF");
$form .= "</text><br />";
$form .= "<label>" . art_constant("AM_MAXPOSTSIZE") .":</label><text>". ini_get( 'post_max_size' );
$form .= "</text><br />";
$form .= "<label>" . art_constant("AM_MAXINPUTTIME") .":</label><text>". ini_get( 'max_input_time' );
$form .= "</text><br />";
$form .= "<label>" . art_constant("AM_OUTPUTBUFFERING") .":</label><text>". ini_get( 'output_buffering' );
$form .= "</text><br />";
$form .= "<label>" . art_constant("AM_XML_EXTENSION") .":</label><text>";
$form .= ( extension_loaded( 'xml' )) ? art_constant("AM_ON") : art_constant("AM_OFF");
$form .= "</text><br />";
$form .= "<label>" . art_constant("AM_MB_EXTENSION") .":</label><text>";
$form .= ( extension_loaded( 'mbstring' )) ? art_constant("AM_ON") : art_constant("AM_OFF");
$form .= "</text><br />";
$form .= "<label>" . art_constant("AM_CURL") .":</label><text>";
$form .= ( function_exists('curl_init')) ? art_constant("AM_ON") : art_constant("AM_OFF");
$form .= "</text><br />";
$form .= "<label>" . art_constant("AM_FSOCKOPEN") .":</label><text>";
$form .= ( function_exists('fsockopen')) ? art_constant("AM_ON") : art_constant("AM_OFF");
$form .= "</text><br />";
$form .= "<label>" . art_constant("AM_URLFOPEN") .":</label><text>";
$form .= ( ini_get('allow_url_fopen')) ? art_constant("AM_ON") : art_constant("AM_OFF");
$form .= "</text><br />";
$form .= "</div>";

$form .= "<div style='padding: 8px;'>";
$path_image = XOOPS_ROOT_PATH . '/' . $xoopsModuleConfig['path_image'] . '/';
$path_status = art_admin_getPathStatus($path_image);
$form .= "<label>" . art_constant("AM_PATH_IMAGE") . ":</label><text>" . $path_image . ' ( ' . $path_status . ' )';
$form .= "</text><br />";
$path_file = XOOPS_ROOT_PATH . '/' . $xoopsModuleConfig['path_file'] . '/';
$path_status = art_admin_getPathStatus($path_file);
$form .= "<label>" . art_constant("AM_PATH_FILE") . ":</label><text>". $path_file . ' ( ' . $path_status . ' )';
$form .= "</text><br />";
$form .= "</div>";
$form .= "</fieldset><br />";

$form .= "<fieldset><legend style='font-weight: bold; color: #900;'>" . art_constant("AM_STATS") . "</legend>";
$form .= "<div style='padding: 8px;'>";
$category_handler =& xoops_getmodulehandler('category', $GLOBALS["artdirname"]);
$category_count = $category_handler->getCount();
$topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);
$topic_count = $topic_handler->getCount();
$article_handler =& xoops_getmodulehandler('article', $GLOBALS["artdirname"]);
$article_count = $article_handler->getCount(new Criteria("art_time_publish", 0, ">"));
$category = 0;
$article_submitted = $category_handler->getArticleCountRegistered($category);
$article_published = $category_handler->getArticleCountPublished($category);
$article_featured = $category_handler->getArticleCountFeatured($category);
$form .= "<label>" . art_constant("AM_TOTAL_CATEGORIES") . ":</label><text>" . $category_count;
$form .= "</text><br />";
$form .= "<label>" . art_constant("AM_TOTAL_TOPICS") . ":</label><text>" . $topic_count;
$form .= "</text><br />";
$form .= "<label>" . art_constant("AM_TOTAL_ARTICLES") . ":</label><text>" . $article_count;
if ($article_submitted > 0) {
    $art_extra = "<a href=\"admin.article.php\"><font color=\"red\">" . $article_submitted . "</font></a> ";
} else {
    $art_extra = "0";
}
$art_extra .= " | " . intval($article_published) . " | " . intval($article_featured);
$form .= " ( " . $art_extra . " )";
$form .= "</text><br />";

$article_stats =& $article_handler->getStats();
$form .= "<label>" . art_constant("AM_TOTAL_AUTHORS") . ":</label><text>" . $article_stats['authors'];
$form .= "</text><br />";
$form .= "<label>" . art_constant("AM_TOTAL_VIEWS") . ":</label><text>" . $article_stats['views'];
$form .= "</text><br />";
$form .= "<label>" . art_constant("AM_TOTAL_RATES") . ":</label><text>" . $article_stats['rates'];
$form .= "</text>";
$form .= "</div>";
$form .= "</fieldset>";

echo $form;

xoops_cp_footer();
?>