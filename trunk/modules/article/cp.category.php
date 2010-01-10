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
 * @version         $Id: cp.category.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";

$from = (!empty($_GET["from"]) || !empty($_POST["from"])) ? 1 : 0;

$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$isadmin = art_isAdministrator();
if ( !$isadmin ) {
    redirect_header(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/index.php", 2, art_constant("MD_NOACCESS"));
}

$xoopsOption["xoops_pagetitle"] = $xoopsModule->getVar("name") . " - " . art_constant("MD_CPCATEGORY");
$template = $xoopsModuleConfig["template"];
$xoopsOption["template_main"] = art_getTemplate("cpcategory", $template);
$xoopsOption["xoops_module_header"] = art_getModuleHeader($template);
// Disable cache
$xoopsConfig["module_cache"][$xoopsModule->getVar("mid")] = 0;
include_once XOOPS_ROOT_PATH . "/header.php";
include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";

// get Category Tree
/*
array(
    "prefix" =>
    "cat_id" =>
    "title" =>
    "order" =>
    );
*/
$categories =& $category_handler->getTree(0, "all", "&nbsp;&nbsp;&nbsp;&nbsp;");
$xoopsTpl -> assign("dirname", $GLOBALS["artdirname"]);
$xoopsTpl -> assign("modulename", $xoopsModule->getVar("name"));
$xoopsTpl -> assign("categories", $categories);
$xoopsTpl -> assign("from", $from);

// Loading module meta data, NOT THE RIGHT WAY DOING IT
$xoopsTpl -> assign("xoops_module_header", $xoopsOption["xoops_module_header"]);
$xoopsTpl -> assign("xoops_pagetitle", $xoopsOption["xoops_pagetitle"]);

include_once "footer.php";
?>