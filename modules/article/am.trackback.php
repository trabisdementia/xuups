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
 * @version         $Id: am.trackback.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";

$category_id = empty($_GET["category"]) ? ( empty($_POST["category"]) ? 0 : intval($_POST["category"]) ) : intval($_GET["category"]);
$trackback_id = empty($_GET["trackback"]) ? ( empty($_POST["trackback"]) ? 0 : intval($_POST["trackback"]) ) : intval($_GET["trackback"]);
$start = empty($_GET["start"]) ? ( empty($_POST["start"]) ? 0 : intval($_POST["start"]) ) : intval($_GET["start"]);
$op = empty($_GET["op"]) ? ( empty($_POST["op"]) ? "" : $_POST["op"]) : $_GET["op"];
$tb_id = empty($_POST["tb_id"]) ? ( empty($trackback_id) ? array() : array($trackback_id) ) : $_POST["tb_id"];
$from = empty($_POST["from"]) ? 0 :1 ;

if (empty($tb_id)) {
    $redirect = empty($from) ? XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/index.php" : XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/admin/admin.trackback.php";
    redirect_header($redirect, 2, art_constant("MD_INVALID"));
}

$trackback_handler =& xoops_getmodulehandler("trackback", $GLOBALS["artdirname"]);
if (!empty($trackback_id)) {
    $trackback_obj =& $trackback_handler->get($trackback_id);
}

$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$category_obj =& $category_handler->get($category_id);

if (!$category_handler->getPermission($category_obj, "moderate")) {
    redirect_header("index.php", 2, art_constant("MD_NOACCESS"));
}

$xoops_pagetitle = $xoopsModule->getVar("name") . " - " . art_constant("MD_CPTRACKBACK");
$xoopsOption["xoops_pagetitle"] = $xoops_pagetitle;
include_once XOOPS_ROOT_PATH . "/header.php";
include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";

switch ($op) {
    case "approve":
        $trackback_handler->approveIds($tb_id);
        break;
    case "delete":
        $trackback_handler->deleteIds($tb_id);
        break;
}

$article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
foreach ($tb_id as $id) {
    $tb_obj =& $trackback_handler->get($id);
    $criteria = new CriteriaCompo(new Criteria("art_id", $tb_obj->getVar("art_id")));
    $criteria->add(new Criteria("tb_status", 0, ">"));
    $count = $trackback_handler->getCount($criteria);
    $article_obj =& $article_handler->get($tb_obj->getVar("art_id"));
    if (!$article_obj->getVar("art_id")) continue;
    if ($count > $article_obj->getVar("art_trackbacks")) {
        $article_obj->setVar("art_trackbacks", $count);
        $article_handler->insert($article_obj);
    }

    if (!empty($xoopsModuleConfig["notification_enabled"]) && $op == "approve") {
        $notification_handler =& xoops_gethandler("notification");
        $tags = array();
        $tags["ARTICLE_TITLE"] = $article_obj->getVar("art_title");
        $tags["ARTICLE_URL"] = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php" . URL_DELIMITER . $article_obj->getVar("art_id") . "#tb" . $tb_obj->getVar("tb_id");
        $tags["ARTICLE_ACTION"] = art_constant("MD_NOT_ACTION_TRACKBACK");
        $notification_handler->triggerEvent("article", $article_id, "article_monitor", $tags);
        $notification_handler->triggerEvent("global", 0, "article_monitor", $tags);
    }
    unset($tb_obj);
    unset($article_obj);
}

$message = art_constant("MD_ACTIONDONE");
$redirect = empty($from) ? XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/cp.trackback.php?category=" . $category_id . "&amp;start=" . $start : XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/admin/admin.trackback.php";
redirect_header($redirect, 2, $message);

include_once "footer.php";
?>