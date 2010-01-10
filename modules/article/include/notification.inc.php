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
 * @version         $Id: notification.inc.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

include dirname(__FILE__) . "/vars.php";
mod_loadFunctions("parse", $GLOBALS["artdirname"]);


art_parse_function('
function [VAR_PREFIX]_notify_iteminfo($category, $item_id)
{
    // The $item is not used !
    
    $item_id = intval($item_id);
    art_define_url_delimiter();

    switch ($category) {
    case "category":
        $category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
        $category_obj =& $category_handler->get($item_id);
        if (!is_object($category_obj)) {
            redirect_header(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/index.php", 2, art_constant("MD_NOACCESS"));
            exit();
        }
        $item["name"] = $category_obj->getVar("cat_title");
        $item["url"] = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.category.php" . URL_DELIMITER . $item_id;
        break;
    case "article":
        $article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
        $article_obj =& $article_handler->get($item_id);
        if (!is_object($article_obj)) {
            redirect_header(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/index.php", 2, art_constant("MD_NOACCESS"));
            exit();
        }
        $item["name"] = $article_obj->getVar("art_title");
        $item["url"] = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php" . URL_DELIMITER . $item_id;
        break;
    case "global":
    default:
        $item["name"] = "";
        $item["url"] = "";
        break;
    }
    return $item;
}
');
?>