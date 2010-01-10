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
 * @version         $Id: am.topic.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";

$category_id = empty($_GET["category"]) ? (empty($_POST["category"]) ? 0 : intval($_POST["category"])) : intval($_GET["category"]);
$topic_id = empty($_GET["topic"]) ? (empty($_POST["topic"]) ? 0 : intval($_POST["topic"])) : intval($_GET["topic"]);
$start = empty($_GET["start"]) ? (empty($_POST["start"]) ? 0 : intval($_POST["start"])) : intval($_GET["start"]);
$op = empty($_GET["op"]) ? (empty($_POST["op"]) ? "" : $_POST["op"]) : $_GET["op"];
$top_id = empty($_POST["top_id"]) ? (empty($topic_id) ? false : array($topic_id)) : $_POST["top_id"];
$top_order = empty($_POST["top_order"]) ? false : $_POST["top_order"];
$from = empty($_POST["from"]) ? 0 : 1 ;

if ( empty($top_id) && empty($topic_id) ) {
    $redirect = empty($from) ? XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/index.php" : XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/admin/admin.topic.php";
    redirect_header($redirect, 2, art_constant("MD_INVALID"));
}

$topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);
if (!empty($topic_id)) {
    $topic_obj =& $topic_handler->get($topic_id);
    $category_id = $topic_obj->getVar("cat_id");
}

$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$category_obj =& $category_handler->get($category_id);
if( !$category_handler->getPermission($category_obj, "moderate") ) {
    $redirect = empty($from) ? XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/cp.topic.php?category=" . $category_id : XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/admin/admin.topic.php";
    redirect_header($redirect, 2, art_constant("MD_NOACCESS"));
}

$xoops_pagetitle = $xoopsModule->getVar("name") . " - " . art_constant("MD_CPTOPIC");
$xoopsOption["xoops_pagetitle"] = $xoops_pagetitle;
include_once XOOPS_ROOT_PATH . "/header.php";
include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";

switch ($op) {
    case "delete":
        if (empty($_POST["confirm_submit"])) {
            $hiddens["topic"] = $topic_id;
            $hiddens["op"] = "delete";
            $hiddens["from"] = $from;
            $hiddens["start"] = $start;
            $hiddens["category"] = $category_id;
            $action = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/am.topic.php";
            $msg = _DELETE . ": " . $topic_obj->getVar("top_title");
            include_once XOOPS_ROOT_PATH . "/header.php";
            include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";
            xoops_confirm($hiddens, $action, $msg);
            include_once XOOPS_ROOT_PATH . "/footer.php";
            exit();
        } else {
            $topic_handler->delete($topic_obj);
        }
        break;
    case "order":
        for ($i = 0; $i < count($top_id); $i++) {
            $top_obj =& $topic_handler->get($top_id[$i]);
            if ($top_obj[$i] != $top_obj->getVar("top_order")) {
                $top_obj->setVar("top_order", $top_order[$i]);
                $topic_handler->insert($top_obj);
            }
            unset($top_obj);
        }
        break;
    default:
        break;
}

$redirect = empty($from)
    ? XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/cp.topic.php?category=" . $category_id . "&amp;start=" . $start
    : XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/admin/admin.topic.php";
redirect_header($redirect, 2, art_constant("MD_ACTIONDONE"));

include_once "footer.php";
?>