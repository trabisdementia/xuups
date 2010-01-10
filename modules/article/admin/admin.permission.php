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
 * @version         $Id: admin.permission.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";
require_once XOOPS_ROOT_PATH . "/class/xoopsform/grouppermform.php";
require_once XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/class/permission.php";
include_once XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/class/xoopsformloader.php";

xoops_cp_header();
require XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";
loadModuleAdminMenu(4);


function display_action_form($action = "")
{
    $action_options = array(
                "no"        => _SELECT, 
                "template"    => art_constant("AM_PERMISSION_TEMPLATE"), 
                "apply"        => art_constant("AM_PERMISSION_TEMPLATE_APPLY"),
                "default"    => art_constant("AM_PERMISSION_SETBYGROUP")
                );
    $actionform = new XoopsSimpleForm(art_constant("AM_PERMISSION_ACTION"), 'actionform', 'admin.permission.php', "GET");
    $action_select = new XoopsFormSelect("", 'action', $action);
    $action_select->setExtra('onchange="document.forms.actionform.submit()"');
    $action_select->addOptionArray($action_options);
    $actionform->addElement($action_select);
    $actionform->display();
}

$action = isset($_REQUEST['action']) ? strtolower($_REQUEST['action']) : "";
switch ($action) {
    case "template":
        display_action_form($action);
        
        $member_handler =& xoops_gethandler('member');
        $glist =& $member_handler->getGroupList();
        $elements = array();
        $perm_handler = &xoops_getmodulehandler('permission', $GLOBALS["artdirname"]);
        $perm_template = $perm_handler->getTemplate($groupid = 0);
        foreach (array_keys($glist) as $i) {
            $selected = !empty($perm_template[$i]) ? array_keys($perm_template[$i]) : array();
            $ret_ele  = '<tr align="left" valign="top"><td class="head">' . $glist[$i] . '</td>';
            $ret_ele .= '<td class="even">';
            $ret_ele .= '<table class="outer"><tr><td class="odd"><table><tr>';
            $ii = 0;
            $option_ids = array();
            foreach ($GLOBALS["perms_category"] as $perm => $content) {
                $ii++;
                if ($ii % 5 == 0) {
                    $ret_ele .= '</tr><tr>';
                }
                $checked = in_array($perm, $selected) ? " checked='checked'" : "";
                $option_id = $perm . '_' . $i;
                $option_ids[] = $option_id;
                $ret_ele .= '<td><input name="perms[' . $i . '][' . $perm . ']" id="' . $option_id . '" onclick="" value="1" type="checkbox"' . $checked . '>' . $content["title"] . '<br></td>';
            }
            $ret_ele .= '</tr></table></td><td class="even">';
            $ret_ele .= _ALL . ' <input id="checkall[' . $i . ']" type="checkbox" value="" onclick="var optionids = new Array(' . implode(", ", $option_ids) . '); xoopsCheckAllElements(optionids, \'checkall[' . $i . ']\')" />';
            $ret_ele .= '</td></tr></table>';
            $ret_ele .= '</td></tr>';
            $elements[] = $ret_ele;
        } 
        $tray = new XoopsFormElementTray('');
        $tray->addElement(new XoopsFormHidden('action', 'template_save'));
        $tray->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $tray->addElement(new XoopsFormButton('', 'reset', _CANCEL, 'reset'));
         $ret = '<h4>' . art_constant("AM_PERMISSION_TEMPLATE") . '</h4>' . art_constant("AM_PERMISSION_TEMPLATE_DESC") . '<br /><br /><br />';
        $ret .= "<form name='template' id='template' method='post'>\n<table width='100%' class='outer' cellspacing='1'>\n";
        $ret .= implode("\n", $elements);
        $ret .= '<tr align="left" valign="top"><td class="head"></td><td class="even">';
        $ret .= $tray->render();
        $ret .= '</td></tr>';
        $ret .= '</table></form>';
        echo $ret;
        break;    
        
    case "template_save":
        $perm_handler =& xoops_getmodulehandler('permission', $GLOBALS["artdirname"]);
        $res = $perm_handler->setTemplate($_POST['perms'], $groupid = 0);
        if ($res) {
            redirect_header("admin.permission.php?action=template", 2, art_constant("AM_PERMISSION_TEMPLATE_CREATED"));
        } else {
            redirect_header("admin.permission.php?action=template", 2, art_constant("AM_PERMISSION_TEMPLATE_ERROR"));
        }
        break;
        
    case "apply":
        $perm_handler =& xoops_getmodulehandler('permission', $GLOBALS["artdirname"]);
        $perm_template = $perm_handler->getTemplate();
        if ($perm_template === null) {
            redirect_header("admin.permission.php?action=template", 2, art_constant("AM_PERMISSION_TEMPLATE_EMPTY"));
        }
        
        display_action_form($action);
        
        $category_handler =& xoops_getmodulehandler('category', $GLOBALS["artdirname"]);
        $categories =& $category_handler->getTree(0, "submit", "--");
        $cat_options = array();
        foreach ($categories as $id => $cat) {
            $cat_options[$id]=$cat["prefix"] . $cat["cat_title"];
        }
        
        $fmform = new XoopsThemeForm(art_constant("AM_PERMISSION_TEMPLATE_APPLY"), 'fmform', 'admin.permission.php', "post");
        $fm_select = new XoopsFormSelect(_SELECT, 'categories', null, 10, true);
        $fm_select->addOptionArray($cat_options);
        $fmform->addElement($fm_select);
        $tray = new XoopsFormElementTray('');
        $tray->addElement(new XoopsFormHidden('action', 'apply_save'));
        $tray->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $tray->addElement(new XoopsFormButton('', 'reset', _CANCEL, 'reset'));
        $fmform->addElement($tray);
        $fmform->display();
        break;
        
    case "apply_save":
        if (empty($_POST["categories"])) break;
        $perm_handler =& xoops_getmodulehandler('permission', $GLOBALS["artdirname"]);
        foreach ($_POST["categories"] as $category) {
            if ($category < 1) continue;
            $perm_handler->applyTemplate($category, $xoopsModule->getVar('mid'));
        }
        // Since we can not control the permission update, a trick is used here
        $permission_handler =& xoops_getmodulehandler("permission", $GLOBALS["artdirname"]);
        $permission_handler->createPermData();
        redirect_header("admin.permission.php", 2, art_constant("AM_PERMISSION_TEMPLATE_APPLIED"));
        break;
        
    default:
        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . art_constant("AM_PERMISSION") . "</legend>";
        echo "<div style='padding: 8px;'>";
        echo art_constant("AM_PERMISSION_DESC"); // "access" of a category is subject to the parent category's access permission
        echo "</div>";
        echo "</fieldset><br />";
        
        display_action_form($action);
        
        $op_options = array("global"=>art_constant("AM_PERMISSION_GLOBAL"));
        $fm_options = array("global"=>array("title"=>art_constant("AM_PERMISSION_GLOBAL"), "item" => "global", "desc" => "", "anonymous" => true));
        foreach ($GLOBALS["perms_category"] as $perm => $perm_info) {
            $op_options[$perm] = $perm_info['title'];
            $fm_options[$perm] = array("title" => $perm_info['title'], "item" => $perm, "desc" => $perm_info['desc'], "anonymous" => true);
            if ($perm == "moderate") $fm_options[$perm]["anonymous"] = false;
        }
        
        $op_keys = array_keys($op_options);
        $op = isset($_GET['op']) ? strtolower($_GET['op']) : (isset($_COOKIE[$GLOBALS["artdirname"] . '_perm_op']) ? strtolower($_COOKIE[$GLOBALS["artdirname"] . '_perm_op']) : "");
        if (empty($op)) {
            $op = $op_keys[0];
            setCookie($GLOBALS["artdirname"] . '_perm_op', isset($op_keys[1]) ? $op_keys[1] : "");
        } elseif (false !== ($key = array_search($op, $op_keys))) {
            setCookie($GLOBALS["artdirname"] . '_perm_op', isset($op_keys[$key + 1]) ? $op_keys[$key + 1] : "");
        }
        
        // Display option form
        $opform = new XoopsSimpleForm('', 'opform', 'admin.permission.php', "get");
        $op_select = new XoopsFormSelect("", 'op', $op);
        $op_select->setExtra('onchange="document.forms.opform.submit()"');
        $op_select->addOptionArray($op_options);
        $opform->addElement($op_select);
        $opform->display();
        
        if ($op == "global") {
            $form_perm = new XoopsGroupPermForm(art_constant("AM_PERMISSION_GLOBAL"), $xoopsModule->getVar('mid'), $op, art_constant("AM_PERMISSION_GLOBAL_DESC"), 'admin/admin.permission.php', $fm_options[$op]["anonymous"]);
            foreach ($GLOBALS["perms_global"] as $name=>$perm_info) {
                $form_perm->addItem($perm_info["id"], $perm_info["title"]);
            }
        } else {
            $category_handler =& xoops_getmodulehandler('category', $GLOBALS["artdirname"]);
            $categories =& $category_handler->getSubCategories();
            $form_perm = new XoopsGroupPermForm($GLOBALS["perms_category"][$op]['title'], $xoopsModule->getVar('mid'), $op, $GLOBALS["perms_category"][$op]['desc'], 'admin/admin.permission.php', $fm_options[$op]["anonymous"]);
            foreach ($categories as $cat_id => $cat) {
                $form_perm->addItem($cat_id, $cat->getVar('cat_title'), $cat->getVar('cat_pid'));
            }
        }
        $form_perm->display();
        
        // Since we can not control the permission update, a trick is used here
        $permission_handler =& xoops_getmodulehandler("permission", $GLOBALS["artdirname"]);
        $permission_handler->createPermData();
        
        break;
}
/*
echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . art_constant("AM_PERMISSION") . "</legend>";
echo "<div style='padding: 8px;'>";
echo art_constant("AM_PERMISSION_DESC"); // "access" of a category is subject to the parent category's access permission
echo "</div>";
echo "</fieldset><br />";


$mid = $xoopsModule->getVar('mid');

$op_options = array("global"=>art_constant("AM_PERMISSION_GLOBAL"));
$fm_options = array("global"=>array("title"=>art_constant("AM_PERMISSION_GLOBAL"), "item"=>"global", "desc"=>"", "anonymous"=>true));
foreach($GLOBALS["perms_category"] as $perm => $perm_info){
    $op_options[$perm] = $perm_info['title'];
    $fm_options[$perm] = array("title"=>$perm_info['title'], "item"=>$perm, "desc"=>$perm_info['desc'], "anonymous"=>true);
    if($perm == "moderate") $fm_options[$perm]["anonymous"] = false;
}
        
// Get option
$op_keys = array_keys($op_options);
$op = isset($_GET['op']) ? strtolower($_GET['op']) : (isset($_COOKIE[$GLOBALS["artdirname"].'_perm_op']) ? strtolower($_COOKIE[$GLOBALS["artdirname"].'_perm_op']):"");
if(empty($op)){
    $op = $op_keys[0];
    setCookie($GLOBALS["artdirname"].'_perm_op', isset($op_keys[1])?$op_keys[1]:"");
}else{
    for($i=0;$i<count($op_keys);$i++){
        if($op_keys[$i] == $op) break;
    }
    setCookie($GLOBALS["artdirname"].'_perm_op', isset($op_keys[$i+1])?$op_keys[$i+1]:"");
}

// Display option form
$opform = new XoopsSimpleForm('', 'opform', 'admin.permission.php', "get");
$op_select = new XoopsFormSelect("", 'op', $op);
$op_select->setExtra('onchange="document.forms.opform.submit()"');
$op_select->addOptionArray($op_options);
$opform->addElement($op_select);
$opform->display();

if($op=="global"){
    $form_perm = new XoopsGroupPermForm(art_constant("AM_PERMISSION_GLOBAL"), $mid, $op, art_constant("AM_PERMISSION_GLOBAL_DESC"), 'admin/admin.permission.php', $fm_options[$op]["anonymous"]);
    foreach ($GLOBALS["perms_global"] as $name=>$perm_info) {
        $form_perm->addItem($perm_info["id"], $perm_info["title"]);
    }
}else{
    $category_handler =& xoops_getmodulehandler('category', $GLOBALS["artdirname"]);
    $categories =& $category_handler->getSubCategories();
    $form_perm = new XoopsGroupPermForm($GLOBALS["perms_category"][$op]['title'], $mid, $op, $GLOBALS["perms_category"][$op]['desc'], 'admin/admin.permission.php', $fm_options[$op]["anonymous"]);
    foreach ($categories as $cat_id => $cat) {
        $form_perm->addItem($cat_id, $cat->getVar('cat_title'), $cat->getVar('cat_pid'));
    }
}
$form_perm->display();
*/

xoops_cp_footer();
?>