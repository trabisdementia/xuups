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
 * @version         $Id: form.article.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined("XOOPS_ROOT_PATH")) exit();

include_once XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/class/xoopsformloader.php";

// The form
$form_art = new XoopsThemeForm("", "formarticle", XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/action.article.php", 'post', true);
$form_art->setExtra("enctype=\"multipart/form-data\"");


if (!empty($_POST["form_mode"])) {
    $form_mode = $_POST["form_mode"];
} elseif (!$form_mode = art_getcookie("form_mode")) {
    $form_mode = @$xoopsModuleConfig["form_mode"];
}

include dirname(__FILE__) . "/form.article.elements.php";
include_once dirname(__FILE__) . "/form.article.config.php";

$elements_active = empty($form_art_elements[$form_mode]) ? $form_art_elements["full"] : $form_art_elements[$form_mode];
foreach ($elements_active as $element) {
    if (empty($form_element["active"][$element])) continue;
    if (is_array($form_element["active"][$element])) {
        foreach (array_keys($form_element["active"][$element]) as $key) {
            $form_art->addElement($form_element["active"][$element][$key]);
        }
    } else {
        $form_art->addElement($form_element["active"][$element]);
    }
}

$elements_inactive = array_diff($form_art_elements["full"], $elements_active);
foreach ($elements_inactive as $element) {
    if (empty($form_element["inactive"][$element])) continue;
    if (is_array($form_element["inactive"][$element])) {
        foreach (array_keys($form_element["inactive"][$element]) as $key) {
            $form_art->addElement($form_element["inactive"][$element][$key]);
        }
    } else {
        $form_art->addElement($form_element["inactive"][$element]);
    }
}

// Hidden options
$form_art->addElement(new XoopsFormHidden("newpage",    $newpage));
$form_art->addElement(new XoopsFormHidden("page",        $page));
$form_art->addElement(new XoopsFormHidden("art_id",        $article_obj->getVar("art_id")));
$form_art->addElement(new XoopsFormHidden("from",        $from));

// Form actions
// "save": save as draft
// "save_edit": save and continue to edit
// "publish": regular submission
// "preview": preview and continue to edit
$button_tray = new XoopsFormElementTray("");
$help_btn = array();

$i=0;
$i_tab = 3; //?
// Submit to publish
if (!$article_obj->getVar("art_time_submit")) {
    $button[$i] = new XoopsFormButton("", "publish", art_constant("MD_PUBLISH_ARTICLE"), "submit");
    $button[$i]->setExtra("tabindex=$i_tab");
    $help_btn[art_constant("MD_PUBLISH_ARTICLE")] = art_constant("MD_HELP_PUBLISH_ARTICLE");
}

// Just save it
$i++;
$i_tab++;
if ($article_obj->getVar("art_time_submit")) {
    $button[$i] = new XoopsFormButton("", "save", art_constant("MD_SAVE"), "submit");
} else {
    $button[$i] = new XoopsFormButton("", "save", art_constant("MD_SAVE_DRAFT"), "submit");
}
$button[$i]->setExtra("tabindex=$i_tab");
$help_btn[art_constant("MD_SAVE")] = art_constant("MD_HELP_SAVE");
$help_btn[art_constant("MD_SAVE_DRAFT")] = art_constant("MD_HELP_SAVE_DRAFT");

$i++;
$i_tab++;
$button[$i] = new XoopsFormButton("", "save_edit", art_constant("MD_SAVE_EDIT"), "submit");
$button[$i]->setExtra("tabindex=$i_tab");
$help_btn[art_constant("MD_SAVE_EDIT")] = art_constant("MD_HELP_SAVE_EDIT");

$i++;
$i_tab++;
$button[$i] = new XoopsFormButton("", "btn_preview", _PREVIEW, "button");
$button[$i]->setExtra("tabindex={$i_tab}");
$button[$i]->setExtra('onclick="window.document.' . $form_art->getName() . '.preview.value=1; window.document.' . $form_art->getName() . '.submit()"');
$form_art->addElement(new XoopsFormHidden('preview', 0));

if ($article_obj->getVar("art_id")) {
    $i++;
    $i_tab++;
    $button[$i] = new XoopsFormButton("", "btn_del", art_constant("MD_DELETE_PAGE"), "button");
    $button[$i]->setExtra("tabindex=$i_tab");
    $button[$i]->setExtra('onclick="window.document.' . $form_art->getName() . '.del.value=1; window.document.' . $form_art->getName() . '.submit()"');
    $form_art->addElement(new XoopsFormHidden('del', 0));

    if ($isAuthor || $category_handler->getPermission($category_obj, "moderate")    ) {
        $i++;
        $i_tab++;
        $button[$i] = new XoopsFormButton("", "btn_delete", art_constant("MD_DELETE_ARTICLE"), "button");
        $button[$i]->setExtra("tabindex=$i_tab");
        $button[$i]->setExtra('onclick="window.document.' . $form_art->getName() . '.delart.value=1; window.document.' . $form_art->getName() . '.submit()"');
        $form_art->addElement(new XoopsFormHidden('delart', 0));
    }
}

$i++;
$i_tab++;
$button[$i] = new XoopsFormButton('', 'cancel', _CANCEL, 'button');

if ( !$article_obj->getVar("art_id") ) {
    $extra = "view.category.php?category=" . intval($cat_id);
} else {
    $extra = "view.article.php?article=" . $article_obj->getVar("art_id") . "&amp;category=" . $cat_id . "&amp;page=" . $page;
}
$button[$i]->setExtra("onclick='window.document.location=\"" . $extra . "\"'");
$button[$i]->setExtra("tabindex=$i_tab");

// Create button for help
$i++;
$i_tab++;
$button[$i] = new XoopsFormButton('', 'help', art_constant("MD_HELP"), 'button');
$button[$i]->setExtra("tabindex=$i_tab");
$help_text = "";
foreach ($help_btn as $key => $val) {
    $help_text .= htmlspecialchars("<li>[<strong>{$key}</strong>] - {$val}</li>", ENT_QUOTES);
}
$button[$i]->setExtra("onclick=\"
    var help_window = openWithSelfMain(null, 'help', 500, 200, true);
    help_window.document.write('" . $help_text . "')
\"");


foreach (array_keys($button) as $btn) {
    $button_tray->addElement($button[$btn]);
}
$form_art->addElement($button_tray);

// Display the form
$form_art->display();
?>