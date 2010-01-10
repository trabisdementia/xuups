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
 * @version         $Id: form.article.elements.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined("XOOPS_ROOT_PATH")) exit();

if (!is_object($form_art)) {
    die("No form declared");
}
$form_element = array();

// editor form mode
if ("fix" == @$xoopsModuleConfig["form_mode"]) {
    $form_element["inactive"]["form_mode"] = new XoopsFormHidden("form_mode", "custom");
} else {
    $mode = array();
    $mode["basic"] = new XoopsFormButton("", "form_mode_basic", art_constant("MD_BASIC"), "button");
    $mode["full"] = new XoopsFormButton("", "form_mode_full", art_constant("MD_ADVANCE"), "button");
    $mode["custom"] = new XoopsFormButton("", "form_mode_custom", art_constant("MD_CUSTOM"), "button");
    $mode_tray = new XoopsFormElementTray(art_constant("MD_FORMMODE"));
    foreach (array_keys($mode) as $key) {
        if ($form_mode == $key) {
            $mode[$key]->setExtra("disabled");
        } else {
            $mode[$key]->setExtra("onclick='window.document." . $form_art->getName() . ".form_mode.value=\"{$key}\"; window.document." . $form_art->getName() . ".submit()'");
        }
        $mode_tray->addElement($mode[$key]);
    }
    $form_element["active"]["form_mode"][] = $mode_tray;
    $form_element["active"]["form_mode"][] = new XoopsFormHidden("form_mode", @$form_mode);
}

// The title
$form_element["active"]["art_title"] = new XoopsFormText(art_constant("MD_TITLE"), "art_title", 60, 255, $art_title);
$form_element["inactive"]["art_title"] = new XoopsFormHidden("art_title", $art_title);

// The uid
$form_element["inactive"]["uid"] = new XoopsFormHidden("uid", $uid);
if ($isModerator) {
    include_once XOOPS_ROOT_PATH . "/Frameworks/art/functions.user.php";
    $user_tray = new XoopsFormElementTray("UID");
    $user_tray->addElement(new XoopsFormText("", "uid", 20, 255, $uid));
    xoops_load("userUtility");
    $user_tray->addElement(new XoopsFormLabel("", XoopsUserUtility::getUnameFromId($article_obj->getVar("uid"), false, true)));
    $form_element["active"]["uid"] =& $user_tray;
} else {
    $form_element["active"]["uid"] =& $form_element["inactive"]["uid"];
}
// Summary
$form_element["active"]["art_summary"] = new XoopsFormTextArea(art_constant("MD_SUMMARY"), "art_summary", $art_summary, 5, 60);
$form_element["inactive"]["art_summary"] = new XoopsFormHidden("art_summary", $art_summary);


// Text subtitle
$form_element["active"]["subtitle"] = new XoopsFormText(art_constant("MD_SUBTITLE"), "subtitle", 60, 255, $subtitle);
$form_element["inactive"]["subtitle"] = new XoopsFormHidden("subtitle", $subtitle);

// The editor selection 
$nohtml = empty($canhtml);
if (!empty($editor)) {
    //art_setcookie("editor",$editor);
} else {
    $editor = art_getcookie("editor");
    if (empty($editor) && is_object($xoopsUser)) {
        $editor =@ $xoopsUser->getVar("editor"); // Need set through user profile
    }
    if (empty($editor)) {
        $editor =@ $xoopsModuleConfig["editor_default"];
    }
}
$form_element["active"]["editor"] = new XoopsFormSelectEditor($form_art, "editor", $editor, $nohtml, @$xoopsModuleConfig["editor_allowed"]);
$form_element["inactive"]["editor"] = new XoopsFormHidden("editor", $editor);

// text render
$editor_configs = array();
$editor_configs["name"] ="text";
$editor_configs["value"] = $text;
$editor_configs["rows"] = empty($xoopsModuleConfig["editor_rows"]) ? 35 : $xoopsModuleConfig["editor_rows"];
$editor_configs["cols"] = empty($xoopsModuleConfig["editor_cols"]) ? 60 : $xoopsModuleConfig["editor_cols"];
$editor_configs["width"] = empty($xoopsModuleConfig["editor_width"]) ? "100%" : $xoopsModuleConfig["editor_width"];
$editor_configs["height"] = empty($xoopsModuleConfig["editor_height"]) ? "400px" : $xoopsModuleConfig["editor_height"];

$form_element["active"]["text"] = new XoopsFormEditor(art_constant("MD_TEXT"), $editor, $editor_configs, $nohtml, $onfailure = null);
$form_element["inactive"]["text"] = new XoopsFormHidden("text", $text);

// text options
$dohtml = empty($canhtml) ? 0 : $dohtml;
$html_checkbox = new XoopsFormCheckBox('', 'dohtml', $dohtml);
$html_checkbox->addOption(1, art_constant("MD_DOHTML"));
if (empty($canhtml)) $html_checkbox->setExtra("disabled");
$smiley_checkbox = new XoopsFormCheckBox('', 'dosmiley', $dosmiley);
$smiley_checkbox->addOption(1, art_constant("MD_DOSMILEY"));
$xcode_checkbox = new XoopsFormCheckBox('', 'doxcode', $doxcode);
$xcode_checkbox->addOption(1, art_constant("MD_DOXCODE"));
$br_checkbox = new XoopsFormCheckBox('', 'dobr', $dobr);
$br_checkbox->addOption(1, art_constant("MD_DOBR"));

$options_tray = new XoopsFormElementTray(art_constant("MD_TEXTOPTIONS"), '<br />');
$options_tray->addElement($html_checkbox);
$options_tray->addElement($smiley_checkbox);
$options_tray->addElement($xcode_checkbox);
$options_tray->addElement($br_checkbox);
$form_element["active"]["text_options"] =& $options_tray;

//$form_element["inactive"]["text_options"] = null;
$form_element["inactive"]["text_options"][] = new XoopsFormHidden("dohtml", $dohtml);
$form_element["inactive"]["text_options"][] = new XoopsFormHidden("dosmiley", $dosmiley);
$form_element["inactive"]["text_options"][] = new XoopsFormHidden("doxcode", $doxcode);
$form_element["inactive"]["text_options"][] = new XoopsFormHidden("dobr", $dobr);

// Pages
$pages = $article_obj->getPageCount(true);
$pages_valid = $article_obj->getPageCount();
if ($pages) {
    
    $QUERY_STRING = array();
    if (!empty($art_id)) $QUERY_STRING[] = "article=" . $art_id;
    if (!empty($cat_id)) $QUERY_STRING[] = "category=" . $cat_id;
    
    $href = "edit.article.php?" . implode("&", $QUERY_STRING) . "&";

    $page_string = "";
    if (!empty($newpage)) $page_string .= "
        <script type=\"text/javascript\">
        var pages = " . $pages . ";
        function setNewpage(page_no) {
            window.document.formarticle.newpage.value=page_no;
            for(var i=1;i<=pages+1;i++) {
                xoopsGetElementById('newpage'+i).style.color = \"\";
                xoopsGetElementById('newpage'+i).style.fontWeight = \"normal\";
            }
            xoopsGetElementById('newpage'+page_no).style.color = \"red\";
            xoopsGetElementById('newpage'+page_no).style.fontWeight = \"bold\";
        }
        </script>
        ";
        
    for($i = 1; $i <= $pages; $i++) {
        $pageno = ($i>$pages_valid) ? "<span style=\"font-style:italic\">" . $i . "</span>" : $i;
        if (!empty($newpage)) {
            if ($newpage == $i) {
                $page_string .= "<a href=\"###\" onclick=\"setNewpage(" . $i . ")\" title=\"" . art_constant("MD_NEWPAGE") . "\"><span id=\"newpage" . $i . "\" style=\"font-weight:bold;color:red;\">+</span></a> ";
            } else {
                $page_string .= "<a href=\"###\" onclick=\"setNewpage(" . $i . ")\" title=\"" . art_constant("MD_NEWPAGE") . "\"><span id=\"newpage" . $i . "\">+</span></a> ";
            }
            $page_string .= "<a href=\"" . $href . "page=" . ($i - 1) . "\" title=\"" . sprintf(art_constant("MD_EDITPAGE_NO"), $i) . "\">" . $pageno . "</a> ";
        } else {
            $page_string .= "<a href=\"" . $href . "newpage=" . $i . "\" title=\"" . art_constant("MD_NEWPAGE") . "\">+</a> ";
            if ($page + 1 == $i) {
                $page_string .= "<span style=\"font-weight:bold\">" . $pageno . "</span> ";
            } else {
                $page_string .= "<a href=\"" . $href . "page=" . ($i - 1) . "\" title=\"".sprintf(art_constant("MD_EDITPAGE_NO"), $i) . "\">" . $pageno . "</a> ";
            }
        }
    }
    if (!empty($newpage)) {
        if ($newpage == $i) {
            $page_string .= "<a href=\"###\" onclick=\"setNewpage(" . $i . ")\" title=\"" . art_constant("MD_NEWPAGE") . "\"><span id=\"newpage" . $i . "\" style=\"font-weight:bold\">+</span></a> ";
        } else {
            $page_string .= "<a href=\"###\" onclick=\"setNewpage(" . $i . ")\" title=\"" . art_constant("MD_NEWPAGE") . "\"><span id=\"newpage" . $i . "\">+</span></a> ";
        }
    } else {
        $page_string .= "<a href=\"" . $href."newpage=" . $i . "\" title=\"" . art_constant("MD_NEWPAGE") . "\">+</a> ";
    }
    $page_string .= " (" . art_constant("MD_SAVE_BEFORE_SWITCH") . ")";
} else {
    $page_string = art_constant("MD_NEWPAGE_AVAILABLE");
}
$form_element["active"]["page"] = new XoopsFormLabel(art_constant("MD_EDITPAGE"), $page_string);
//$form_element["inactive"]["page"] = null;

// The author info
require_once XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/class/formselectwriter.php";
$form_element["active"]["writer_id"] = new XoopsFormSelectWriter(art_constant("MD_AUTHOR"), 'writer_id', $writer_id);
$form_element["inactive"]["writer_id"] = new XoopsFormHidden("writer_id", $writer_id);


// Source
$form_element["active"]["art_source"] = new XoopsFormText(art_constant("MD_SOURCE"), "art_source", 50, 255, $art_source);
$form_element["inactive"]["art_source"] = new XoopsFormHidden("art_source", $art_source);

// Keywords/Tags
$form_element["inactive"]["art_keywords"] = new XoopsFormHidden("art_keywords", $art_keywords);
if (@include_once XOOPS_ROOT_PATH . "/modules/tag/include/formtag.php") {
    $form_element["active"]["art_keywords"] = new XoopsFormTag("art_keywords", 60, 255, $art_keywords);
} else {
    $form_element["active"]["art_keywords"] =& $form_element["inactive"]["art_keywords"];
}

// Attachments
/*
$form_element["inactive"]["userfile"] = null;
if ($canupload) {
    $upload_tray = new XoopsFormElementTray(art_constant("MD_ATTACHMENT"), '<br />');
    $upload_tray->addElement(new XoopsFormFile(art_constant("MD_ATTACHMENT"), "userfile",""));
    $upload_tray->addElement(new XoopsFormLabel(art_constant("MD_ALLOWED_EXTENSIONS"), "<i>".str_replace("|"," ",$xoopsModuleConfig["extension"]) . "</i>"));
    
    if (!empty($attachments)) {
        $delete_attach_checkbox = new XoopsFormCheckBox(art_constant("MD_ATTACHED"), "delete_attach[]");
        foreach($attachments as $key => $attachment) {
            $attach = _DELETE." <a href=".XOOPS_URL."/" . $xoopsModuleConfig["path_upload"]."/" . $attachment["name_saved"]." targe="_blank" >" . $attachment["name_display"]."</a>";
            $delete_attach_checkbox->addOption($key, $attach);
        }
        $upload_tray->addElement($delete_attach_checkbox);
    }
    $form_element["active"]["userfile"] =& $upload_tray;
} else {
    $form_element["active"]["userfile"] = null;
}
*/

// Spot Image
$image_tray = new XoopsFormElementTray(art_constant("MD_IMAGE_ARTICLE"), "<br />");
$image_current = empty($art_image["file"]) ? _NONE : _DELETE . "<input type=\"checkbox\" name=\"image_del\" value=\"" . $art_image["file"] . "\"><div style=\"padding: 8px;\"><img src=\"" . XOOPS_URL . "/" . $xoopsModuleConfig["path_image"] . "/" . $art_image["file"] . "\" name=\"img\" id=\"img\" alt=\"\" /></div>";
$image_tray->addElement(new XoopsFormLabel(art_constant("MD_IMAGE_CURRENT"), $image_current));
$image_tray->addElement(new XoopsFormText(art_constant("MD_IMAGE_CAPTION"), "art_image_caption", 50, 255, @$art_image["caption"]));
//$form_element["active"]["art_image_hidden"] = array();
if ($canupload) {
    $image_option_tray = new XoopsFormElementTray(art_constant("MD_IMAGE_UPLOAD"), "<br />");
    $image_option_tray->addElement(new XoopsFormFile("", "userfile",""));
    if (!empty($art_image_file_tmp)) {
        $image_option_tray->addElement(new XoopsFormLabel("", "<a href=\"" . XOOPS_URL . "/" . $xoopsModuleConfig["path_image"] . "/{.$art_image_file_tmp}\" rel=\"external\">" . art_constant("MD_IMAGE_UPLOADED") . "</a>"));
        $form_element["active"]["art_image"][] = new XoopsFormHidden("art_image_file_tmp", $art_image_file_tmp);
    }
    $image_tray->addElement($image_option_tray);
}
$form_element["active"]["art_image"][] = $image_tray;
$form_element["inactive"]["art_image"] = null;

// Template set
include_once dirname(__FILE__) . "/functions.render.php";
if ( $templates = art_getTemplateList("article") ) {
    $template_option_tray = new XoopsFormElementTray(art_constant("MD_TEMPLATE_SELECT"), "<br />");
    $template_select = new XoopsFormSelect("", "art_template", $art_template);
    $template_select->addOptionArray($templates);
    $template_option_tray->addElement($template_select);
    $form_element["active"]["art_template"] = $template_option_tray;
} else {
    //$form_element["active"]["art_template"] = null;
}
$form_element["inactive"]["art_template"] = new XoopsFormHidden("art_template", $art_template);

// Category
// Only author and administrators have the right to change categories
// Moderator has the right to remove the article from his category
$categories =& $category_handler->getTree(0, "submit", "----");
$cat_options = array();
$top_categories = array();
$cat_pid = 0;
foreach ($categories as $id => $cat) {
    $cat_options[$id] = $cat["prefix"] . $cat["cat_title"];
    if ($cat["cat_pid"] == 0) {
        $top_categories[$id]["cat"] = $cat; 
        $cat_pid = $id;
    } else {
        $top_categories[$cat_pid]["sub"][$id] = $cat; 
    }
}

// base category
$form_element["inactive"]["cat_id"] = new XoopsFormHidden("cat_id", $cat_id);
if (art_isAdministrator() || $isAuthor) {
    $cat_select = new XoopsFormSelect("", "cat_id", $cat_id);
    $cat_select->addOptionArray($cat_options);
    $cat_option_tray = new XoopsFormElementTray(art_constant("MD_CATEGORY_BASE"), "<br />");
    $cat_option_tray->addElement($cat_select);
    $form_element["active"]["cat_id"] = $cat_option_tray;
} else {
    $form_element["active"]["cat_id"] =& $form_element["inactive"]["cat_id"];
}

$col_num = 3;
$col_wid = floor( 95 / $col_num );
$category_string = "<div>";
$top_count = 0; 
//$form_element["active"]["category_hidden"] = array(); 
//$form_element["inactive"]["category_hidden"] = array(); 
foreach ( array_keys($top_categories) as $id) {
    $top_count++;
    $cat = $top_categories[$id]["cat"];
    $sub = empty($top_categories[$id]["sub"]) ? array() : $top_categories[$id]["sub"];
    $category_string .= "<div style=\"float: left; width: {$col_wid}%\">\n";
    
    $category_string .= "<div>" . $cat["prefix"];
    if ($category_handler->getPermission($id, "moderate")) {
        $category_string .= "<input type=\"checkbox\" name=\"category[]\"";
        if (is_array($category) && in_array($id, $category)) $category_string .= " checked";
        $category_string .= " value=\"{$id}\" />";
    } else {
        $category_string .=  "<input type=\"checkbox\" name=\"category_disable\"";
        if (is_array($category) && in_array($id, $category)) {
            $category_string .= " \"checked\"";
            $form_element["active"]["category"][] = new XoopsFormHidden("category[]", $id);
        }
        $category_string .=" \"disabled\" />";
    }
    $category_string .= $cat["cat_title"] . "</div>\n";
    if (is_array($category) && in_array($id, $category)) {
        $form_element["inactive"]["category"][] = new XoopsFormHidden("category[]", $id);
    }
    
    foreach ($sub as $sid => $scat) {
        $category_string .= "<div>" . $scat["prefix"];
        if ($category_handler->getPermission($sid, "moderate")) {
            $category_string .= "<input type=\"checkbox\" name=\"category[]\"";
            if (is_array($category) && in_array($sid, $category)) $category_string .=" checked";
            $category_string .= " value=\"{$sid}\" />";
        } else {
            $category_string .=  "<input type=\"checkbox\" name=\"category_disable\"";
            if (is_array($category) && in_array($sid, $category)) {
                $category_string .= " \"checked\"";
                $form_element["active"]["category"][] = new XoopsFormHidden("category[]", $sid);
            }
            $category_string .= " \"disabled\" />";
        }
        $category_string .= $scat["cat_title"] . "</div>\n";
        if (is_array($category) && in_array($id, $category)) {
            $form_element["inactive"]["category"][] = new XoopsFormHidden("category[]", $sid);
        }
    }
    
    $category_string .= "</div>\n";
    
    if ($top_count == $col_num) {
        $top_count = 0;
        $category_string .= "</div>\n<br style=\"clear: both;\" /><div style=\"margin-top: 10px;\">";
    }
}
$category_string .= "</div>\n";
$form_element["active"]["category"][] = new XoopsFormLabel(art_constant("MD_CATEGORY"), $category_string);
//$form_element["inactive"]["category"] = null;

// Topic
$permission_handler =& xoops_getmodulehandler("permission", $GLOBALS["artdirname"]);
$allowed_cats = $permission_handler->getCategories("submit");
$topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);
$criteria = new CriteriaCompo(new Criteria("top_expire", time(), ">"));
$tags = array("top_title", "cat_id");
$topic_string = "";
//$form_element["active"]["topic_hidden"] = array(); 
if ( $topics_obj = $topic_handler->getByCategory($allowed_cats, $xoopsModuleConfig["topics_max"], 0, $criteria, $tags) ) {
    foreach ($topics_obj as $top_id => $top) {
        if ($topic_handler->getPermission($top, "moderate")) {
            $topic_string .= "<div><input type=\"checkbox\" name=\"topic[]\"";
            if (in_array($top_id, $topic)) {
                $topic_string .=" \"checked\"";
            }
            $topic_string .=" value=\"" . $top_id . "\" />" . $top->getVar("top_title") . "</div>";
        } else {
            $topic_string .="<div><input type=\"checkbox\" name=\"topic_disable\"";
            if (in_array($top_id, $topic)) {
                $topic_string .= " \"checked\"";
                $form_element["active"]["topic"][] = new XoopsFormHidden("topic[]", $top_id);
            }
            $topic_string .=" \"disabled\" />" . $top->getVar("top_title") . "</div>";
        }
        if (in_array($top_id, $topic)) {
            $form_element["inactive"]["topic"][] = new XoopsFormHidden("topic[]", $top_id);
        }
    }
    $form_element["active"]["topic"][] = new XoopsFormLabel(art_constant("MD_TOPIC"), $topic_string);
} else {
    //$form_element["active"]["topic"] = null;
}
//$form_element["inactive"]["topic"] = null;

// Forum
if (!empty($xoopsModuleConfig["forum"]) && $isModerator && !$article_obj->getVar("art_forum")) {
    $form_element["active"]["forum"] = new XoopsFormRadioYN(art_constant("MD_FORUM"), "forum", 0, _YES, " " . _NO);
}

// External Links
$form_element["active"]["art_elinks"] = new XoopsFormTextArea(art_constant("MD_ELINKS"), "art_elinks", $art_elinks, 3);
$form_element["inactive"]["art_elinks"] = new XoopsFormHidden("art_elinks", $art_elinks);

// Trackbacks
if (!empty($xoopsModuleConfig["do_trackback"])) {
    $form_element["active"]["trackbacks"] = new XoopsFormTextArea(art_constant("MD_TRACKBACKS"), "trackbacks", $trackbacks, 3);
    $form_element["inactive"]["trackbacks"] = new XoopsFormHidden("trackbacks", $trackbacks);
}

// Notify for approval
if ( !$canPublish && is_object($xoopsUser) && $xoopsModuleConfig["notification_enabled"]) {
    $form_element["active"]["notify"] = new XoopsFormRadioYN(art_constant("MD_NOTIFY_ON_APPROVAL"), "notify", $notify, _YES, " " . _NO);
    $form_element["inactive"]["notify"] = new XoopsFormHidden("notify", $notify);
}

// Approval option
if ( $article_obj->getVar("art_time_submit") && !$article_obj->getVar("art_time_publish") && $isModerator) {
    $form_element["active"]["approved"] = new XoopsFormRadioYN(art_constant("MD_APPROVE"), "approved", 1, _YES, " " . _NO );
    $form_element["inactive"]["approved"] =& $form_element["active"]["approved"];
}

// Update publish time
if ( $article_obj->getVar("art_time_publish") && $isModerator) {
    $update_time_value = ( !empty($_POST["update_time_value"]) && !empty($_POST["update_time"]) ) ? intval( strtotime( @$_POST["update_time_value"]["date"] ) + @$_POST["update_time_value"]["time"] ) : $article_obj->getVar("art_time_publish");
    $date_tray = new XoopsFormElementTray(art_constant("MD_UPDATE_TIME"));
    $date_tray->addElement( new XoopsFormDateTime("", "update_time_value", 15, $update_time_value ) );
    $select_option = new XoopsFormCheckBox("", "update_time", intval( @$_POST["update_time"] ));
    $select_option->addOption(1, "<strong>" . _YES . "</strong>");
    $date_tray->addElement( $select_option );
    $form_element["active"]["update_time"] = $date_tray;
}

?>