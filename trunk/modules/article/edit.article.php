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
 * @version         $Id: edit.article.php 2178 2008-09-26 08:34:09Z phppp $
 */
 

include "header.php";

$category_id = intval( @$_GET["category"] );
$art_id = intval( @$_GET["article"] );
$page = intval( @$_GET["page"] );
$newpage = intval( @$_GET["newpage"] );
$from = @$_GET["from"];

$article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
if (!empty($xoopsModuleConfig["article_expire"])) {
    $article_handler->cleanExpires($xoopsModuleConfig["article_expire"]*24*3600);
}
if ($art_id > 0) {
    $article_obj =& $article_handler->get($art_id);
} else {
    $article_obj =& $article_handler->create();
}
$cat_id = $article_obj->getVar("cat_id");
$cat_id = empty($cat_id) ? $category_id : $cat_id;

$notify = null;

$user_id = (empty($xoopsUser)) ? 0 : $xoopsUser->getVar("uid");
if ($article_obj->isNew()) {
    $article_obj->setVar("uid", $user_id);
    $article_isNew = true;
}
$isAuthor = ( $user_id == $article_obj->getVar("uid") );
$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$category_obj =& $category_handler->get($cat_id);
$isModerator = $category_handler->getPermission($category_obj, "moderate");
$canPublish = $category_handler->getPermission($category_obj, "publish");

$permission_handler =& xoops_getmodulehandler("permission", $GLOBALS["artdirname"]);
$canhtml = $permission_handler->getPermission("html");
$canupload = $permission_handler->getPermission("upload");

if (!$isAuthor && !$article_obj->getVar("art_time_submit")) {
    redirect_header(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/index.php", 2, art_constant("MD_NOACCESS"));
}

if (empty($cat_id)) {
    $categories_obj = $category_handler->getAllByPermission("submit", array("cat_id"));
    if (count($categories_obj) == 0) {
        redirect_header(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/index.php", 2, art_constant("MD_NOACCESS"));
        exit();
    }
}

// The title
$art_title = $article_obj->getVar("art_title");

// image
$art_image = $article_obj->getImage();

// The author info
$uid = $article_obj->getVar("uid");

$writer_id = $article_obj->getVar("writer_id");
//$art_profile=$article_obj->getVar("art_profile", "E");

//source
$art_source = $article_obj->getVar("art_source");

// Summary
$art_summary = $article_obj->getVar("art_summary", "E");

// Attachments
//$attachments = $article_obj->getVar("attachments", "E");

// keywords
$art_keywords = $article_obj->getVar("art_keywords", "E");

// Template
$art_template = $article_obj->getVar("art_template");

// Category
$criteria = new CriteriaCompo(new Criteria("ac_register", 0, ">"));
$category =& $article_handler->getCategoryIds($article_obj, $criteria);

// topic
$topic =& $article_handler->getTopicIds($article_obj);

// Forum
//$forum =& $article_obj->getVar("art_forum", "E");

// External Links
$art_elinks = $article_obj->getVar("art_elinks", "E");

// Trackbacks
$trackbacks = "";

// Text
$subtitle = "";
$text = "";
$dohtml = empty($canhtml) ? 0 : 1;
$dosmiley = 1;
$doxcode = 1;
$dobr = $article_obj->isNew() || $newpage;
if ($article_obj->getVar("art_id") && empty($newpage)) {
    $page_id = $article_obj->getPage($page, true);
    if ($page_id) {
        $text_handler =&xoops_getmodulehandler("text", $GLOBALS["artdirname"]);
        $text_obj =& $text_handler->get($page_id);
        // Text title
        $subtitle = $text_obj->getVar("text_title", "E");
        // Text body
        $text = $text_obj->getVar("text_body", "E");
        $dohtml = $text_obj->getVar("dohtml");
        $dosmiley = $text_obj->getVar("dosmiley");
        $doxcode = $text_obj->getVar("doxcode");
        $dobr = $text_obj->getVar("dobr");

        unset($text_obj);
    }
}

if (!empty($newpage)) {
    $form_advance = false;
}

// Disable cache
$xoopsConfig["module_cache"][$xoopsModule->getVar("mid")] = 0;
include XOOPS_ROOT_PATH . "/header.php";
include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";

// Disclaimer
if (!empty($xoopsModuleConfig["disclaimer"]) /*&& !$isModerator*/ ) {
    echo "<div><strong>" . art_constant("MD_DISCLAIMER") . "</strong></div><br />";
    echo "<div class=\"confirmMsg\" style=\"text-align:left;\">" . $myts->displayTarea($xoopsModuleConfig['disclaimer']) . "</div><br />";
}

if ($user_id > 0) {
    $criteria = new CriteriaCompo(new Criteria("art_time_submit", 0));
    $criteria->add(new Criteria("art_time_create", 0, ">"));
    $criteria->add(new Criteria("uid", $user_id));
    if ($art_id > 0) {
        $criteria->add(new Criteria("art_id", $art_id, "<>"));
    }
    $drafts = $article_handler->getIds($criteria);
    if (count($drafts)) {
        echo "<div><strong>" . art_constant("MD_DRAFTS") . "</strong></div>";
        echo "<div class=\"confirmMsg\" style=\"text-align:left;\">";
        foreach ($drafts as $draft) {
            echo "<a href=\"edit.article.php?article=" . $draft . "\" title=\"click to edit\">#" . $draft . "</a> ";
        }
        echo "</div><br clear=\"both\">";
    }
}

include XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/include/form.article.php";
include XOOPS_ROOT_PATH . "/footer.php";
?>