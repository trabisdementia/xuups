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
 * @version         $Id: form.category.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined("XOOPS_ROOT_PATH")) exit();

require_once XOOPS_ROOT_PATH . "/class/xoopstree.php";
include_once XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/class/xoopsformloader.php";

// Form
$form_art = new XoopsThemeForm(art_constant("MD_CATEGORY") . " " . $category_obj->getVar("cat_title"), "formcategory", XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/action.category.php");
$form_art->setExtra("enctype=\"multipart/form-data\"");

// Title
$input = new XoopsFormText(art_constant("MD_TITLE"), "cat_title", 50, 255, $category_obj->getVar("cat_title"));
if (!art_isAdministrator()) {
    $input->setExtra("type=\"disabled\"");
}
$form_art->addElement($input, true);

// Description
$form_art->addElement(new XoopsFormTextArea(art_constant("MD_DESCRIPTION"), "cat_description", $category_obj->getVar("cat_description", "E")));

// Parent category
if (art_isAdministrator()) {
    $categories =& $category_handler->getTree(0, "moderate", "----");
    $cat_options = array();
    $cat_options[0] = _NONE;
    foreach ($categories as $id => $cat) {
        $cat_options[$id] = $cat["prefix"] . $cat["cat_title"];
    }
    $cat_select = new XoopsFormSelect(art_constant("MD_PARENT_CATEGORY"), "cat_pid", $category_obj->getVar("cat_pid"));
    $cat_select->addOptionArray($cat_options);
    $form_art->addElement($cat_select);
} else {
    $form_art->addElement(new XoopsFormHidden("cat_pid", $category_obj->getVar("cat_pid")));
}

// Order
$order_input = new XoopsFormText(art_constant("MD_ORDER"), "cat_order", 20, 20, $category_obj->getVar("cat_order"));
if (!art_isAdministrator()) $order_input->setExtra("type=\"disabled\"");
$form_art->addElement($order_input);

// Template set
$templates =& art_getTemplateList("category");
if (count($templates)>0) {
    //$template_option_tray = new XoopsFormElementTray(art_constant("MD_TEMPLATE_SELECT"), "<br />");
    $template_select = new XoopsFormSelect(art_constant("MD_TEMPLATE_SELECT"), "cat_template", $category_obj->getVar("cat_template"));
    $template_select->addOptionArray($templates);
    //$template_option_tray->addElement($template_select);
    //$form_art->addElement($template_option_tray);
    $form_art->addElement($template_select);
}

// Image
if (!empty($xoopsModuleConfig["path_image"])) {
    $cat_image = $category_obj->getVar("cat_image");
    $image_option_tray = new XoopsFormElementTray(art_constant("MD_IMAGE_UPLOAD"), "<br />");
    $image_option_tray->addElement(new XoopsFormFile("", "userfile",""));
    $form_art->addElement($image_option_tray);
    unset($image_tray);
    unset($image_option_tray);

    $image_option_tray = new XoopsFormElementTray(art_constant("MD_IMAGE_SELECT"), "<br />");
    $path_image = $xoopsModuleConfig["path_image"];
    $image_array =& XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . "/". $path_image . "/");
    array_unshift($image_array, _NONE);
    $image_select = new XoopsFormSelect("", "cat_image", $cat_image);
    $image_select->addOptionArray($image_array);
    $image_select->setExtra("onchange=\"showImgSelected('img', 'cat_image', '/" . $path_image . "/', '', '" . XOOPS_URL . "')\"");
    $image_tray = new XoopsFormElementTray("", "&nbsp;");
    $image_tray->addElement($image_select);
    if (!empty($cat_image) && file_exists(XOOPS_ROOT_PATH . "/" . $path_image . "/" . $cat_image)) {
        $image_tray->addElement(new XoopsFormLabel("", "<div style=\"padding: 8px;\"><img src=\"" . XOOPS_URL . "/" . $path_image . "/" . $cat_image . "\" name=\"img\" id=\"img\" alt=\"\" /></div>"));
    } else {
        $image_tray->addElement(new XoopsFormLabel("", "<div style=\"padding: 8px;\"><img src=\"" . XOOPS_URL . "/images/blank.gif\" name=\"img\" id=\"img\" alt=\"\" /></div>"));
    }
    $image_option_tray->addElement($image_tray);
    $form_art->addElement($image_option_tray);
}

// The moderator
if (art_isAdministrator()) {
       $form_art->addElement(new XoopsFormSelectUser(art_constant("MD_MODERATOR"), 'cat_moderator', false, $category_obj->getVar("cat_moderator"), 5, true));
} else {
    if ($moderators = $category_obj->getVar("cat_moderator")) {
        $moderator_checkbox = new XoopsFormCheckBox(art_constant("MD_MODERATOR"), "cat_moderator", array_keys($moderators));
        $moderator_checkbox->addOptionArray(art_getUnameFromId($moderators));
        $moderator_checkbox->setExtra("\"disabled\"");
        $form_art->addElement($moderator_checkbox);
    }
}

// Entry article
$limit_article = 100;
if ($category_obj->getVar("cat_id")) {
    $article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
    $criteria_article = new Criteria("cat_id", $category_obj->getVar("cat_id"));
    $article_count = $article_handler->getCount($criteria_article);
    if ($article_count > 0) {
        $article_list[0] = _NONE;
        
        if ($article_count > $limit_article) {
            $article_list = $article_list + $article_handler->getList(new Criteria("art_id", $category_obj->getVar("cat_entry")));
            $article_option_tray = new XoopsFormElementTray(art_constant("MD_ENTRY_SELECT"));
            $name = "cat_entry";
            $article_select = new XoopsFormSelect("", $name, $category_obj->getVar("cat_entry"));
            $article_select->addOptionArray($article_list);
            $article_option_tray->addElement($article_select);
            $article_more = new XoopsFormLabel('', "<a href='###' onclick='return openWithSelfMain(\"" . XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/include/select.article.php?target=" . $name . "&amp;category=" . $category_obj->getVar("cat_id") . "\", \"articleselect\", 800, 500, null);' >" . _MORE . "</a>".
                "<script type=\"text/javascript\">
                function addItem(opts) {
                    var num = opts.substring(0, opts.indexOf(\":\"));
                    opts = opts.substring(opts.indexOf(\":\")+1, opts.length);
                    var sel = xoopsGetElementById(\"" . $name . "\");
                    var arr = new Array(num);
                    for(var n=0; n<num; n++) {
                        var nm = opts.substring(0, opts.indexOf(\":\"));
                        opts = opts.substring(opts.indexOf(\":\")+1, opts.length);
                        var val = opts.substring(0, opts.indexOf(\":\"));
                        opts = opts.substring(opts.indexOf(\":\")+1, opts.length);
                        var txt = opts.substring(0, nm - val.length);
                        opts = opts.substring(nm - val.length, opts.length);
                        var added = false;
                        for (var k = 0; k < sel.options.length; k++) {
                            if (sel.options[k].value == val) {
                                added = true;
                                break;
                            }
                        }
                        if (added==false) {
                            sel.options[k] = new Option(txt, val);
                            sel.options[k].selected = true;
                        }
                    }
                    return true;
                }
                </script>"
            
            );
            $article_option_tray->addElement($article_more);
            $form_art->addElement($article_option_tray);
        } else {
            //$criteria_article->setLimit($limit_article);
            $criteria_article->setSort("art_id");
            $criteria_article->setOrder("DESC");
            $article_list = $article_list + $article_handler->getList(new Criteria("cat_id", $category_obj->getVar("cat_id")));
            $article_select = new XoopsFormSelect(art_constant("MD_ENTRY_SELECT"), "cat_entry", $category_obj->getVar("cat_entry"));
            $article_select->addOptionArray($article_list);
            $form_art->addElement($article_select);
        }
    }
}

// Sponsor links
$form_art->addElement(new XoopsFormTextArea(art_constant("MD_SPONSOR"), "cat_sponsor", $category_obj->getVar("cat_sponsor", "E")));
//$form_art->addElement(new XoopsFormLabel(art_constant("MD_SPONSOR_DESC"), art_constant("MD_SPONSOR_DESC_TEXT")));

$form_art->addElement(new XoopsFormHidden("cat_id", $category_obj->getVar("cat_id")));
$form_art->addElement(new XoopsFormHidden("from", $from));

$button_tray = new XoopsFormElementTray("", "");
$button_tray->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
$cancel_button = new XoopsFormButton('', 'cancel', _CANCEL, 'button');
if (!empty($from)) {
    $extra = "admin/admin.category.php";
}elseif ( $category_obj->getVar("cat_id") ) {
    $extra = "view.category.php?category=" . $category_obj->getVar("cat_id");
}elseif ( $category_obj->getVar("cat_pid") ) {
    $extra = "view.category.php?category=" . $category_obj->getVar("cat_pid");
} else {
    $extra = "index.php";
}
$cancel_button->setExtra("onclick='window.document.location=\"" . $extra . "\"'");
$button_tray->addElement($cancel_button);
$form_art->addElement($button_tray);

$form_art->display();
?>
