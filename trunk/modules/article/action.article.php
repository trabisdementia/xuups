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
 * @version         $Id: action.article.php 2283 2008-10-12 03:36:13Z phppp $
 */
 
include "header.php";
include_once XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/class/uploader.php";

// Initialize the critical variables
$art_id        = isset($_POST["art_id"]) ? intval($_POST["art_id"]) : 0 ;
$page        = isset($_POST["page"]) ? intval($_POST["page"]) : 0 ;
$newpage    = isset($_POST["newpage"]) ? intval($_POST["newpage"]) : 0 ;
$cat_id     = isset($_POST["cat_id"]) ? intval($_POST["cat_id"]) : 0 ;
$uid         = isset($_POST["uid"]) ? intval($_POST["uid"]) : 0 ;
$from         = isset($_POST["from"]) ? $_POST["from"] : "" ;
$update_time_value = 0;

$article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
$article_obj = $art_id ? $article_handler->get($art_id) : $article_handler->create();

$article_isNew = $article_obj->isNew();
$user_id = (empty($xoopsUser)) ? 0 : $xoopsUser->getVar("uid");
$isAuthor = ($article_isNew || $user_id == $article_obj->getVar("uid")) ? 1 : 0;

if (!$isAuthor && !$article_obj->getVar("art_time_submit")) {
    redirect_header("index.php", 2, art_constant("MD_NOACCESS"));
}

$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$category_obj =& $category_handler->get($cat_id);
$isModerator = $category_handler->getPermission($category_obj, "moderate");
if (!$isModerator && (!$isAuthor || !$category_handler->getPermission($category_obj,"submit")) ) {
    redirect_header("index.php", 2, art_constant("MD_NOACCESS"));
    exit();
}
$canPublish = $category_handler->getPermission($category_obj, "publish");

$permission_handler =& xoops_getmodulehandler("permission", $xoopsModule->getVar("dirname"));
$canhtml = $permission_handler->getPermission("html");
$canupload = $permission_handler->getPermission("upload");
if (!$canhtml) {
    $_POST["dohtml"] = 0;
}

// Set cookies
foreach (array("editor", "form_mode") as $var) {
    if (!empty($_POST[$var])) art_setcookie($var, $_POST[$var]);
}

include XOOPS_ROOT_PATH . "/header.php";
include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";

// Article actions
// "delete": delete one page
// "edit": edit
// "save": save
// "save_edit": submit and continue to edit
// "publish": regular submission
// "preview": preview and continue to edit

$art_image_file_upload = "";
if ( $canupload && empty($_POST["del"]) && empty($_POST["delete"]) && !empty($_FILES["userfile"]["name"])) {
    $uploader = new art_uploader(
        XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig["path_image"],
        array("jpg", "png", "gif", "jpeg")
    );
    if ( $uploader->fetchMedia( $_POST["xoops_upload_file"][0]) ) {
        if ( !$uploader->upload() ) {
            xoops_error($uploader->getErrors());
        } elseif ( file_exists( $uploader->getSavedDestination() )) {
            $art_image_file_upload = $uploader->getSavedFileName();
        }
    } else {
        xoops_error($uploader->getErrors());
    }
    
    if ( !empty($_POST["art_image_file_tmp"]) ){
        @unlink(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig["path_image"] . "/" . $_POST["art_image_file_tmp"]);
        unset($_POST["art_image_file_tmp"]);
    }
}

if ( !empty($_POST["del"]) && isset($_POST["page"]) && $art_id > 0) {
    if (count($article_obj->getPages()) <= 1) {
        $_POST["delart"] = 1;
    } elseif (empty($newpage)) {
        $text_handler =& xoops_getmodulehandler("text", $GLOBALS["artdirname"]);
        $page_id = $article_obj->getPage($page, true);
        $text_obj =& $text_handler->get($page_id);
        $text_handler->delete($text_obj);
        $pages = $article_obj->getPages();
        array_splice($pages, $page, 1);
        $article_obj->setVar("art_pages", $pages, true); // NOT GPC, important!
        $article_handler->insert($article_obj);
        $redirect = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php" . URL_DELIMITER . "c" . $cat_id . "/" . $article_obj->getVar("art_id");
        $message = art_constant("MD_DELETED");
    
        redirect_header($redirect, 2, $message);
    } else {
        $redirect = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/edit.article.php?category=" . $cat_id . "&amp;article=" . $article_obj->getVar("art_id");
        if (!empty($from)) $redirect .= "&amp;from=" . $from;
        $message = art_constant("MD_SAVED");
        redirect_header($redirect, 1);
    }
}

if( !empty($_POST["delart"])
// If author submits
    && ($isAuthor 
// Or moderator changes
    || $category_handler->getPermission($category_obj, "moderate")
    )
    && $art_id > 0
){
    if (empty($_POST["delok"])) {
        xoops_confirm(array("delart" => 1, "art_id" => $art_id, "cat_id" => $cat_id, "delok" => 1), "action.article.php", art_constant("MD_DELETE_ARTICLE_CONFIRM"));
    } else {
        $article_handler->delete($article_obj);
        $redirect = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.category.php" . URL_DELIMITER . $cat_id;
        $message = art_constant("MD_DELETED");
        redirect_header($redirect, 2, $message);
        exit();
    }
}

if ( !empty($_POST["save"]) || !empty($_POST["save_edit"]) || !empty($_POST["publish"])) {

    if (empty($_POST["text"]) || empty($_POST["art_title"])) {
        redirect_header("javascript:history.go(-1);", 1, art_constant("MD_TEXTEMPTY"));
        exit();
    }

    foreach (array(
        "art_title", "cat_id",
        "writer_id", "art_source",
        "art_keywords", "art_elinks", "art_template",
        "art_summary"
        ) as $tag) {
        if (@$_POST[$tag] != $article_obj->getVar($tag)) {
            $article_obj->setVar($tag, @$_POST[$tag]);
        }
    }
    if ($article_isNew) {
        $uid = empty($uid) ? $user_id : $uid;
        $article_obj->setVar("uid", $uid);
        $article_obj->setVar("art_time_create", time());
    } elseif ($isModerator && $uid != $article_obj->getVar("uid")) {
        $article_obj->setVar("uid", $uid);
    }
    if ($isAuthor && !$article_obj->getVar("art_time_submit") && !empty($_POST["publish"])) {
        $article_obj->setVar("art_time_submit", time());
    }

    if ( !$article_obj->getVar("art_time_publish")
        && (
            ($isAuthor && !empty($_POST["publish"]) && $canPublish)
            ||
            (!empty($_POST["approved"]) && $article_obj->getVar("art_time_submit") && $category_handler->getPermission($category_obj, "moderate"))
        )
    ) {
        $article_obj->setVar("art_time_publish", time());
    }
    
    if (!empty($_POST["update_time"])) {
        $update_time_value = intval( strtotime( @$_POST["update_time_value"]["date"] ) + @$_POST["update_time_value"]["time"] );
        if ($isModerator) {
            $article_obj->setVar("art_time_publish", $update_time_value, true);
        }
    }

    // New uploaded
    if (!empty($art_image_file_upload)) {
        $art_image["file"] = $art_image_file_upload;
    // Uploaded during preview
    } elseif(!empty($_POST["art_image_file_tmp"])) {
        $art_image["file"] = $_POST["art_image_file_tmp"];
    // delete current image
    } elseif ( !empty($_POST["image_del"]) ) {
        $art_image["file"] = "";
    }
    if (isset($art_image["file"])) {
        $old_img = $article_obj->getVar("art_image");
        @unlink(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig["path_image"] . "/" . $old_img["file"]);
        if (empty($art_image["file"])) {
            $art_image = array();
        } else {
            $art_image["caption"] = !empty($_POST["art_image_caption"]) ? $_POST["art_image_caption"] : "";
        }
        $article_obj->setVar("art_image", $art_image);
    }

    $art_id_new = $article_handler->insert($article_obj);
    $article_obj->unsetNew();
    if (!$article_obj->getVar("art_id")) {
        if (!empty($from)) {
            $redirect = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/admin/admin.article.php";
        } elseif ($art_id) {
            $redirect = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php" . URL_DELIMITER . "c" . $cat_id . "/" . $art_id;
            $redirect .= "&amp;page=" . $page;
        } else {
            $redirect = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.category.php" . URL_DELIMITER . $cat_id;
        }
        redirect_header($redirect, 2, art_constant("MD_INSERTERROR"));
        exit();
    }

    // All info about category and topic will be DISCARDED if NOT submit
    // Categories to be registered to
    $cats_reg = array();
    // Categories to be published to
    $cats_pub = array();
    // Categories to be withdrawn from
    $cats_unpub = array();
    
    // If author submits
    if ( ($isAuthor && (!empty($_POST["publish"]) || $article_obj->getVar("art_time_publish")) )
    // Or moderator changes
        || $category_handler->getPermission($category_obj, "moderate")
    ) {
        $category = !empty($_POST["category"]) ? $_POST["category"] : array();
        // If the base category is not in the categories, add it
        if (!in_array($cat_id, $category)) $category[] = $cat_id;
        
        $topic = !empty($_POST["topic"]) ? $_POST["topic"] : array();
        
        if (!$article_isNew) {
            $old_category = $article_handler->getCategoryArray($article_obj);
            $old_topic = $article_handler->getTopicIds($article_obj);
        } else {
            $old_category = array();
            $old_topic = array();
        }
        
        foreach ($category as $id) {
            // If xoopsuser is author and has the right "publish" OR xoopsuser has Admin right, the registered Category should be approved or added
            if ( !empty($_POST["publish"]) && ( ($isAuthor && $category_handler->getPermission($id, "publish")) || $category_handler->getPermission($id, "moderate") ) ) {
                // New registered category, then register it
                if (!isset($old_category[$id])) {
                    $cats_reg[$id] = 1;
                // Existing category, then publish to it
                } elseif (empty($old_category[$id])) {
                    $cats_pub[] = $id;
                }
            // If is author and has the right "submit", the category can be registered as "pending"
            } elseif ( ($isAuthor && $category_handler->getPermission($id, "submit"))  || $category_handler->getPermission($id, "moderate") ) {
                if (!isset($old_category[$id])) $cats_reg[$id] = 0;
            }
        }
        // Update publish time for existing categories if selected.
        if (!empty($_POST["update_time"]) && !empty($update_time_value) && $cats_update = @array_intersect(array_keys($old_category), $category)) {
            foreach ($cats_update as $id) {
                if ( !$category_handler->getPermission($id, "moderate") ) continue;
                $article_handler->setCategoryStatus($article_obj, $id, 1, $update_time_value);
            }
        }
        
        // Categories that not used any more
        $cat_diff = @array_diff(array_keys($old_category), $category);
        // Categories to be withdrawn from
        $cats_del=array();
        if (count($cat_diff) > 0) {
            foreach ($cat_diff as $id) {
                // If the user has publish/moderate right over the article, remove it from the category
                if ( ($isAuthor && $category_handler->getPermission($id, "publish")) || $isModerator )  {
                    $cats_del[] = $id;
                // If the user has submission right over the article, withdraw it
                } elseif ($isAuthor && $category_handler->getPermission($id, "submit")) {
                    $cats_unpub[] = $id;
                }
            }
        }
        // Register to categories
        if (count($cats_reg) > 0) {
            $cats = array();
            foreach ($cats_reg  as $id => $status) {
                $cats[$id] = array("status" => $status, "uid" => $article_obj->getVar("uid"));
            }
            $article_handler->registerCategory($article_obj, $cats);
            unset($cats);
        }
        // Remove categories
        if (count($cats_del) > 0) {
            $article_handler->terminateCategory($article_obj, $cats_del);
        }
        // Publish to categories
        if (count($cats_pub) > 0) {
            $article_handler->publishCategory($article_obj, $cats_pub);
        }
        // Set pending in categories
        if (count($cats_unpub) > 0) {
            $article_handler->unPublishCategory($article_obj, $cats_unpub);
        }
        
        // Update category stats
        $article_handler->updateCategories($article_obj);

        $tops_add = @array_diff($topic, $old_topic);
        $tops_del = @array_diff($old_topic, $topic);
        $topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);
        if (count($tops_add) > 0) {
            $tops = array();
            foreach ($tops_add as $id) {
                $top_obj=& $topic_handler->get($id);
                if ($topic_handler->getPermission($top_obj, "moderate")) $tops[]=$id;
                unset($top_obj);
            }
            if (count($tops) > 0) {
                $article_handler->registerTopic($article_obj, $tops);
            }
        }
        if (count($tops_del) > 0) {
            $tops = array();
            foreach ($tops_del as $id) {
                if($topic_handler->getPermission($id, "moderate")) $tops[]=$id;
            }
            if (count($tops) > 0) {
                $article_handler->terminateTopic($article_obj, $tops);
            }
        }
        $article_handler->updateTopics($article_obj);
    }

    $text_handler =& xoops_getmodulehandler("text", $GLOBALS["artdirname"]);
    if (empty($newpage)) {
        $page_id = $article_obj->getPage($page, true);
        $text_obj =& $text_handler->get($page_id);
    }
    if (empty($text_obj)) {
        $text_obj =& $text_handler->create();
    }
    if ($article_obj->getVar("art_id") != $text_obj->getVar("art_id")) $text_obj->setVar("art_id", $article_obj->getVar("art_id"));
    if (@$_POST["subtitle"] != $text_obj->getVar("text_title")) $text_obj->setVar("text_title", @$_POST["subtitle"]);
    if ($myts->stripSlashesGPC($myts->censorString($_POST["text"])) != $text_obj->getVar("text_body")) {
        $text_obj->setVar("text_body", $_POST["text"]);
    }
    foreach (array("dohtml", "dosmiley", "doxcode", "dobr") as $tag) {
        if (intval(@$_POST[$tag]) != $text_obj->getVar($tag)) $text_obj->setVar($tag, intval(@$_POST[$tag]));
    }
    $text_id = $text_handler->insert($text_obj);

    $forum = 0;
    if (!$article_obj->getVar("art_forum")
        && !empty($xoopsModuleConfig["forum"])
        && $article_obj->getVar("art_time_publish")
        && !empty($_POST["forum"])
        && $category_handler->getPermission($cat_id, "moderate")
    ) {
        $data["id"] = $article_obj->getVar("art_id");
        $data["uid"] = $user_id;
        $data["title"] = $article_obj->getVar("art_title");
        $_author = $article_obj->getAuthor(true);
        $data["author"] = (!$_author["author"]) ? $_author["name"] : $_author["author"];
        $data["url"] = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php" . URL_DELIMITER . "c" . $cat_id . "/" . $article_obj->getVar("art_id");
        $data["summary"] = $article_obj->getSummary(true);
        $data["forum_id"] =  $xoopsModuleConfig["forum"];
        
        $transfer_handler =& xoops_getmodulehandler("transfer", $GLOBALS["artdirname"]);
        $forum = $transfer_handler->do_transfer("newbb", $data);
    }


    // To update article info
    $toUpdate = false;
    
    $pages_all= $article_obj->getPages(false, true);
    $pages_curr = $article_obj->getPages();
    $pages_count = count($pages_curr);
    $pages_count_all = count($pages_all);
    $pages_up = array();
    for ($i = 0; $i < $pages_count; $i++) {
        if (!empty($newpage) && ($newpage-1) == $i) {
            $pages_up[] = $text_obj->getVar("text_id");
            $newpage_inserted = true;
        }
        if (in_array($pages_curr[$i], $pages_all)) {
            $pages_up[] = $pages_curr[$i];
        }
    }
    for ($i = 0; $i < $pages_count_all; $i++) {
        if (!in_array($pages_all[$i], $pages_up)) {
            if (empty($newpage_inserted) && !empty($newpage) && ($newpage - 1) == count($pages_up)) {
                $pages_up[] = $text_obj->getVar("text_id");
            }
            $pages_up[] = $pages_all[$i];
        }
    }
    $pages_up = array_unique($pages_up);
    if (strcmp(serialize($pages_up), serialize($pages_curr))) {
        $article_obj->setVar("art_pages", $pages_up, true); // NOT GPC, important!
        $toUpdate = true;
    }
    $page = empty($newpage) ? $page : ( intval($newpage) - 1 );

    $article_handler->insert($article_obj);
    
    $isPublished = $article_obj->getVar("art_time_publish") ? 1 : 0;

    // Trigger notifications
    // Notification
    // send notification for global [submit/new], each category [submit/new] and approval
    if (!empty($xoopsModuleConfig["notification_enabled"])) {
        $notification_handler =& xoops_gethandler("notification");
        // Moved to class article.php function registerCategory()
        /*
        $tags = array();
        $tags["ARTICLE_TITLE"] = $article_obj->getVar("art_title");
        $tags["ARTICLE_URL"] = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php".URL_DELIMITER."" .$article_obj->getVar("art_id");
        $categories =& $category_handler->getList();
        if ($isPublished ) {
            if(count($cats_pub)>0) {
                $tags["ARTICLE_ACTION"] = art_constant("MD_NOT_ACTION_PUBLISHED");
                foreach($cats_pub as $cat){
                    $tags["ARTICLE_URL"] = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php".URL_DELIMITER."" .$article_obj->getVar("art_id")."/c".$cat;
                    $tags["CATEGORY_TITLE"] = $categories[$cat];
                    $notification_handler->triggerEvent("global", 0, "article_new", $tags);
                    $notification_handler->triggerEvent("global", 0, "article_monitor", $tags);
                    $notification_handler->triggerEvent("category", $cat, "article_new", $tags);
                    $notification_handler->triggerEvent("article", $article_obj->getVar("art_id"), "article_approve", $tags);
                }
            }
            if(count($cats_unpub)>0) {
                foreach($cats_unpub as $cat){
                    $tags["ARTICLE_URL"] = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/edit.article.php?article=" .$article_obj->getVar("art_id")."&category=".$cat;
                    $tags["CATEGORY_TITLE"] = $categories[$cat];
                    $notification_handler->triggerEvent("category", $cat, "article_submit", $tags);
                    $notification_handler->triggerEvent("global", 0, "article_submit", $tags);
                }
            }
        } else {
            $tags["CATEGORY_TITLE"] = $categories[$article_obj->getVar("cat_id")];
            $tags["ARTICLE_URL"] = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/edit.article.php?article=" .$article_obj->getVar("art_id")."&category=".$article_obj->getVar("cat_id");
            $notification_handler->triggerEvent("global", 0, "article_submit", $tags);
            $notification_handler->triggerEvent("category", $article_obj->getVar("cat_id"), "article_submit", $tags);
        }
        */
        // If notify checkbox is set, add subscription for approve; else unsubscribe
        if (is_object($xoopsUser)) {
            if (!empty($_POST["notify"])) {
                $notification_handler->subscribe("article", $article_obj->getVar("art_id"), "article_approve");
            } else {
                $notification_handler->unsubscribe("article", $article_obj->getVar("art_id"), "article_approve");
            }
        }
    }

    if ($isPublished && !empty($xoopsModuleConfig["do_trackback"]) && !empty($_POST["trackbacks"])) {
        $tbs = array_map("trim", preg_split("/[\s,]+/", $_POST["trackbacks"]));
        $tb_old =& $article_handler->getTracked($article_obj);
        $tb_recorded = array();
        $tb_untracked = array();
        $tb_new = array();
        foreach($tb_old as $id => $tb) {
            if ($tb["td_time"] == 0) {
                if ($article_obj->getVar("art_time_publish") > 0) {
                    art_trackback($tb["td_url"], $article_obj);
                }
                $tb_untracked[$tb["td_id"]] = $tb["td_url"];
            }
            $tb_recorded[] = $tb["td_url"];
        }
        foreach($tbs as $tb) {
            if (!in_array($tb, $tb_recorded)) {
                if ($article_obj->getVar("art_time_publish") > 0) {
                    art_trackback($tb, $article_obj);
                    $tb_new[] = array("time" => time(), "url" => $tb);
                } else {
                    $tb_new[] = array("time" => 0, "url" => $tb);
                }
            }
        }
        foreach ($tb_new as $tb) {
            $article_handler->addTracked($article_obj, $tb);
        }
        if ($article_obj->getVar("art_time_publish") > 0 && count($tb_untracked) > 0) {
            $article_handler->updateTracked($article_obj, $tb_untracked);
        }
    }
    
    // Clear caches
    load_functions("cache");
    $dirname = $GLOBALS["artdirname"];
    $pattern_uri = urlencode("/modules/{$dirname}/view.article.php?article=" . $article_obj->getVar("art_id"));
    mod_clearSmartyCache("/^{$dirname}\^.*{$pattern_uri}.*{$dirname}_article\.html$/");
    
    if ($isPublished && $article_isNew && !empty($xoopsModuleConfig["do_ping"]) && !empty($xoopsModuleConfig["pings"])) {
        $pings = array_map("trim", preg_split("/[\s,\r\n]+/", $xoopsModuleConfig["pings"]));
        art_ping($pings, $article_obj->getVar("art_id"));
    }

    if ( !empty($_POST["save"])) {
        if (empty($from)) {
            $redirect = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php" . URL_DELIMITER . "c" . $cat_id . "/" . $article_obj->getVar("art_id") . "/p" . (empty($newpage) ? $page : ($newpage - 1));
        } else {
            $redirect = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/admin/admin.article.php";
        }
        $message = art_constant("MD_SAVED");
    }
    if ( !empty($_POST["save_edit"])) {
        $redirect = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/edit.article.php?category=" . $cat_id . "&amp;article=" . $article_obj->getVar("art_id");
        $redirect .= "&amp;page=" . $page;
        if (!empty($from)) $redirect .= "&amp;from=" . $from;
        $message = art_constant("MD_SAVED");
    }
    if ( !empty($_POST["publish"])) {
        if (empty($from)) {
            $redirect = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php" . URL_DELIMITER . "c" . $cat_id . "/" . $article_obj->getVar("art_id") . "/p" . $page;
        } else {
            $redirect = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/admin/admin.article.php";
        }
        $message = art_constant("MD_SUBMITED");
    }

    redirect_header($redirect, 2, $message);
    exit();
}

$art_image = $article_obj->getImage();

// TODO: use object::getVar($var, $format="f")

if ( !empty($_POST["preview"]) ) {
    $p_title = $myts->htmlSpecialChars($myts->stripSlashesGPC($_POST["art_title"]));
    $p_source = $myts->htmlSpecialChars($myts->stripSlashesGPC( $_POST["art_source"] ));
    $p_keywords = $myts->htmlSpecialChars($myts->stripSlashesGPC( $_POST["art_keywords"] ));
    $p_elinks = $myts->stripSlashesGPC($_POST["art_elinks"]);
    $p_summary = $_POST["art_summary"];
    $p_summary = $myts->previewTarea($p_summary);
    $p_subtitile = $myts->htmlSpecialChars($myts->stripSlashesGPC($_POST["subtitle"]));
    $art_image_file_tmp = empty($art_image_file_upload) ? (empty($_POST["art_image_file_tmp"]) ? "" : $_POST["art_image_file_tmp"]) : $art_image_file_upload;
    $p_image["file"] = empty($art_image_file_tmp) ? (empty($art_image["url"]) ? "" : $art_image["file"]) : $art_image_file_tmp;
    if (!empty($p_image["file"]) && file_exists(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig["path_image"] . "/" . $p_image["file"])) {
        $p_image["url"] = XOOPS_URL . "/" . $xoopsModuleConfig["path_image"] . "/" . $p_image["file"];
        $p_image["caption"] = @$myts->htmlSpecialChars($myts->stripSlashesGPC($_POST["art_image_caption"]));
    } else {
        $p_image = null;
    }
    foreach (array("dohtml", "dosmiley", "doxcode", "dobr") as $tag) {
        ${$tag} = empty($_POST[$tag]) ? 0 : 1;
    }
    $doimage = 1;
    $p_text = $_POST["text"];
    $p_text = $myts->previewTarea($p_text, $dohtml, $dosmiley, $doxcode, $doimage, $dobr);
    $article_data = array();
    
    $article_data["id"] = $art_id;
    $article_data["cat_id"] = $cat_id;
    // title
    $article_data["title"] = $p_title;
    // image
    $article_data["image"] = $p_image;
    // Authors
    mod_loadFunctions("author");
    $author_uid = ($article_isNew) ? $user_id : $article_obj->getVar("uid");
    $authors = art_getAuthorNameFromId($author_uid, false, true);
    $article_data["author"] = $authors[$author_uid];
    if (!empty($_POST["writer_id"])) {
        $article_obj->setVar("writer_id", $_POST["writer_id"]);
        $article_data["writer"] = $article_obj->getWriter();
    }
    // source
    $article_data["source"] = $p_source;
    // publish time
    $article_data["time"] = art_formatTimestamp(time());
    // counter
    $article_data["counter"] = 0;
    // rating data
    $article_data["rates"] = 0;
    $article_data["rating"] = 0;
    // summary
    $article_data["summary"] = $p_summary;
    // Keywords
    $article_data["keywords"] = trim($p_keywords);
    // text of page
    $article_data["text"] = array( "title" => $p_subtitile, "body" => $p_text);
    
    require_once XOOPS_ROOT_PATH . "/class/pagenav.php";
    $count_page = ($art_id > 0) ? $article_obj->getPagecount(true) : 1;
    if (!empty($newpage)) {
        $count_page ++;
        $curr_page = $newpage-1;
    } else {
        $curr_page = $page;
    }
    $nav = new XoopsPageNav($count_page, 1, $curr_page, "page", "category=" . $cat_id . "&amp;article=" . $art_id);
    $article_data["pages"] = $nav->renderNav(5);
    
    // elinks
    $elinks = art_parseLinks($p_elinks);

    $template = $myts->htmlSpecialChars($myts->stripSlashesGPC($_POST["art_template"]));
    $_template = art_getTemplate("article", $template);
    $module_header = art_getModuleHeader($_template);
    $xoopsTpl -> assign("xoops_module_header", $module_header);

    require_once XOOPS_ROOT_PATH . "/class/template.php";
    $tpl = new XoopsTpl();
    $tpl -> assign("article", $article_data);
    $tpl -> assign("dirname", $GLOBALS["artdirname"]);
    $tpl -> assign("modulename", $xoopsModule->getVar("name"));
    $tpl -> assign("elinks", $elinks);
    $tpl -> assign("page", $page);
    $tpl -> assign("xoops_url", XOOPS_URL);
    $tpl -> display("db:" . $_template);
}

foreach (array(
    "art_title",
    "uid",
    //"art_author","art_profile",
    "writer_id",
    "art_source",
    "art_keywords","art_elinks","art_image_caption","art_template",
    "art_summary", 
    "trackbacks", "subtitle", "text",
    "dohtml", "dosmiley", "doxcode", "dobr",
    "editor"
    ) as $tag) {
    ${$tag} = $myts->htmlSpecialChars($myts->stripSlashesGPC(trim(@$_POST[$tag])));
}
if (!empty($article_isNew)) {
    $article_obj->setVar("uid", $uid);
}
$art_image["caption"] = $art_image_caption;
$form_advance = !empty($_POST["form_advance"]) ? intval($_POST["form_advance"]) : 0;
$notify = !empty($_POST["notify"]) ? 1 : 0;
$approved = !empty($_POST["approved"]) ? 1 : 0;
$page = !empty($_POST["page"]) ? intval($_POST["page"]) : 0;
if ($newpage) $page = -1;
$category = !empty($_POST["category"]) ? $_POST["category"] : array();
$category = array_map("intval", $category);
$topic = !empty($_POST["topic"]) ? $_POST["topic"] : array();
$topic = array_map("intval", $topic);

echo "<div class=\"clear\"></div>";
echo "<br />";
include XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/include/form.article.php";

include XOOPS_ROOT_PATH . "/footer.php";
?>