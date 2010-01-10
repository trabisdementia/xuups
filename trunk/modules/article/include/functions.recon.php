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
 * @version         $Id: functions.recon.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

include dirname(__FILE__) . "/vars.php";
define($GLOBALS["artdirname"] . "_FUNCTIONS_RECON_LOADED", TRUE);

IF (!defined("ART_FUNCTIONS_RECON")):
define("ART_FUNCTIONS_RECON", 1);


function art_synchronization($type = "")
{
    switch ($type) {
    case "article":
    case "topic":
    case "category":
        $type = array($type);
        $clean = array($type);
        break;
    default:
        $type = null;
        $clean = array("category", "topic", "article", "text", "rate", "spotlight", "pingback", "trackback");
        break;
    }
    foreach ($clean as $item) {
        $handler =& xoops_getmodulehandler($item, $GLOBALS["artdirname"]);
        $handler->cleanOrphan();
        unset($handler);
    }
    /*
    if(empty($type) || in_array("category", $type)):
        $category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
        $category_handler->setLastArticleIds();
        $category_handler->updateTrack();
    endif;
    */
    if (empty($type) || in_array("article", $type)):
        $article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
        $artConfig = art_load_config();
        $article_handler->cleanExpires($artConfig["article_expire"] * 24 * 3600);
    endif;
    return true;
}

/**
 * A very rough function to reconcile article tags
 *
 * Far to complete, like removing tags that have been removed from an article
 */
function art_updateTag($mid = 0)
{
    if (!@include_once XOOPS_ROOT_PATH . "/modules/tag/include/functions.php") {
        return false;
    }
    if (!$tag_handler =& tag_getTagHandler()) {
        return false;
    }
    $table_article = art_DB_prefix("article");
    
    $sql =  "    SELECT art_id, art_keywords" .
            "    FROM " . art_DB_prefix("article") .
            "    WHERE art_time_publish >0" .
            "        AND art_keywords <> '' ";
            
    if( ($result = $GLOBALS['xoopsDB']->query($sql)) == false){
        //xoops_error($GLOBALS['xoopsDB']->error());
    }
    $mid = empty($mid) ? $GLOBALS["xoopsModule"]->getVar("mid") : $mid;
    while ($myrow = $GLOBALS['xoopsDB']->fetchArray($result)) {
        if (empty($myrow["art_keywords"])) continue;
        $tag_handler->updateByItem($myrow["art_keywords"], $myrow["art_id"], $mid);
    }

    return true;
}

ENDIF;
?>