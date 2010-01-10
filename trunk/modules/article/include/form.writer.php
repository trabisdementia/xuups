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
 * @version         $Id: form.writer.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined("XOOPS_ROOT_PATH")) exit();

/*
if (defined("XOOPS_PATH")):
include_once XOOPS_ROOT_PATH."/modules/" . $GLOBALS["artdirname"]."/Frameworks/class/xoopsformloader.php";
else:
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
endif;
*/

// Form
$form_art = new XoopsThemeForm(art_constant("MD_AUTHOR") . " " . $writer_obj->getVar("writer_name") . " (" . ($writer_obj->getVar("writer_id") ? _EDIT : _ADD) . ")", "formwriter", xoops_getenv('PHP_SELF'));
$form_art->setExtra("enctype=\"multipart/form-data\"");

// Title
$form_art->addElement(new XoopsFormText(art_constant("MD_NAME"), "writer_name", 50, 255, $writer_obj->getVar("writer_name")), true);

// Profile
$form_art->addElement(new XoopsFormTextArea(art_constant("MD_PROFILE"), "writer_profile", $writer_obj->getVar("writer_profile", "E")));


// Avatar
if (art_isAdministrator() && !empty($xoopsModuleConfig["path_image"])) {

    //require_once(XOOPS_ROOT_PATH . "/class/xoopstree.php");
    
    $writer_avatar = $writer_obj->getVar("writer_avatar");
    $image_option_tray = new XoopsFormElementTray(art_constant("MD_IMAGE_UPLOAD"), "<br />");
    $image_option_tray->addElement(new XoopsFormFile("", "userfile", ""));
    $form_art->addElement($image_option_tray);
    unset($image_tray);
    unset($image_option_tray);

    $image_option_tray = new XoopsFormElementTray(art_constant("MD_IMAGE_SELECT"), "<br />");
    $path_image = $xoopsModuleConfig["path_image"];
    $image_array =& XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . "/". $path_image."/");
    array_unshift($image_array, _NONE);
    $image_select = new XoopsFormSelect("", "writer_avatar", $writer_avatar);
    $image_select->addOptionArray($image_array);
    $image_select->setExtra("onchange=\"showImgSelected('img', 'writer_avatar', '/" . $path_image . "/', '', '" . XOOPS_URL . "')\"");
    $image_tray = new XoopsFormElementTray("", "&nbsp;");
    $image_tray->addElement($image_select);
    if (!empty($writer_avatar) && file_exists(XOOPS_ROOT_PATH . "/" . $path_image . "/" . $writer_avatar)) {
        $image_tray->addElement(new XoopsFormLabel("", "<div style=\"padding: 8px;\"><img src=\"" . XOOPS_URL . "/" . $path_image . "/" . $writer_avatar . "\" name=\"img\" id=\"img\" alt=\"\" /></div>"));
    } else {
        $image_tray->addElement(new XoopsFormLabel("", "<div style=\"padding: 8px;\"><img src=\"" . XOOPS_URL . "/images/blank.gif\" name=\"img\" id=\"img\" alt=\"\" /></div>"));
    }
    $image_option_tray->addElement($image_tray);
    $form_art->addElement($image_option_tray);
}

$form_art->addElement(new XoopsFormHidden("writer_id", $writer_obj->getVar("writer_id")));
//$form_art->addElement(new XoopsFormHidden("target", $name_parent));

$button_tray = new XoopsFormElementTray("", "");
$button_tray->addElement(new XoopsFormButton("", "submit_writer", _SUBMIT, "submit"));
$button_tray->addElement(new XoopsFormButton('', '', _CANCEL, 'reset'));
$form_art->addElement($button_tray);

$form_art->display();
?>