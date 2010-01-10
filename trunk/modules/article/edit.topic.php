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
 * @version         $Id: edit.topic.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";

$topic_id = empty($_GET["topic"]) ? 0 : intval($_GET["topic"]);
$category_id = empty($_GET["category"]) ? 0 : intval($_GET["category"]);
$from = empty($_GET["from"]) ? 0 : intval($_GET["from"]);

$topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);
$topic_obj =& $topic_handler->get($topic_id);

$category_id = empty($category_id) ? $topic_obj->getVar("cat_id") : $category_id;
/*
$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$category_obj =& $category_handler->get($category_id);

if( !$category_handler->getPermission($category_obj, "moderate")
    || !art_isAdministrator())
{
    redirect_header(XOOPS_URL."/modules/".$GLOBALS["artdirname"]."/index.php", 2, art_constant("MD_NOACCESS"));
}
*/
// Disable cache
$xoopsConfig["module_cache"][$xoopsModule->getVar("mid")] = 0;
include XOOPS_ROOT_PATH . '/header.php';
include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";
include XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/include/form.topic.php";
include XOOPS_ROOT_PATH . "/footer.php";
?>