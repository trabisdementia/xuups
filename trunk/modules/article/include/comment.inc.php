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
 * @version         $Id: comment.inc.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined("XOOPS_ROOT_PATH")) { exit(); }

$current_path = __FILE__;
if ( DIRECTORY_SEPARATOR != "/" ) $current_path = str_replace( strpos( $current_path, "\\\\", 2 ) ? "\\\\" : DIRECTORY_SEPARATOR, "/", $current_path);
$url_arr = explode("/", strstr($current_path, "/modules/"));
include XOOPS_ROOT_PATH . "/modules/" . $url_arr[2] . "/include/vars.php";
include_once XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/include/functions.php";

art_parse_function('
function [VAR_PREFIX]_com_update($art_id, $count)
{
    $article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
    $article_obj =& $article_handler->get($art_id);
    $article_obj->setVar( "art_comments", $count, true );
    return $article_handler->insert($article_obj, true);
}

function [VAR_PREFIX]_com_approve(&$comment)
{
    art_define_url_delimiter();
    if (!empty($GLOBALS["xoopsModuleConfig"]["notification_enabled"])) {
        $article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
        $article_obj =& $article_handler->get($comment->getVar("com_itemid"));
        $notification_handler =& xoops_gethandler("notification");
        $tags = array();
        $tags["ARTICLE_TITLE"] = $article_obj->getVar("art_title");
        $tags["ARTICLE_URL"] = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php" . URL_DELIMITER . $article_obj->getVar("art_id") . "#comment" . $comment->getVar("com_id");
        $tags["ARTICLE_ACTION"] = art_constant("MD_NOT_ACTION_COMMENT");
        $notification_handler->triggerEvent("article", $article_obj->getVar("art_id"), "article_monitor", $tags);
        $notification_handler->triggerEvent("global", 0, "article_monitor", $tags);
    }
}
');
?>