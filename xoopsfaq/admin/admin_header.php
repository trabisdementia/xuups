<?php
/**
 * XOOPS FAQ module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright::	 The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license::    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package::    xoopsfaq
 * @subpackage:: admin
 * @since::      2.5.0
 * @author::     Magic.Shao <magic.shao@gmail.com> - Susheng Yang <ezskyyoung@gmail.com>
 * @version::    $Id $
**/

include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/mainfile.php';
include_once XOOPS_ROOT_PATH . '/include/cp_functions.php';
include("../../../include/cp_header.php");
include_once XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/class/admin.php";
require_once XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/include/functions.php';

$myts =& MyTextSanitizer::getInstance();

if ($xoopsUser) {
    $moduleperm_handler =& xoops_gethandler('groupperm');
    if (!$moduleperm_handler->checkRight('module_admin', $xoopsModule->getVar('mid'), $xoopsUser->getGroups())) {
        redirect_header(XOOPS_URL, 1, _NOPERM);
        exit();
    }
} else {
    redirect_header(XOOPS_URL . "/user.php", 1, _NOPERM);
    exit();
}

if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
  include_once(XOOPS_ROOT_PATH."/class/template.php");
  $xoopsTpl = new XoopsTpl();
}

xoops_cp_header();

// Define Stylesheet and JScript
$xoTheme->addStylesheet(XOOPS_URL . "/modules/" . $xoopsModule->getVar("dirname") . "/css/admin.css");
//$xoTheme->addScript("media/jquery/jquery.js");
//$xoTheme->addScript("modules/" . $xoopsModule->getVar("dirname") . "/js/admin.js");

// Load language files
if (!@include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/" . $xoopsConfig['language'] . "/admin.php")) {
    include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/english/admin.php");
}
if (!@include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/" . $xoopsConfig['language'] . "/modinfo.php")) {
    include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/english/modinfo.php");
}
if (!@include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/" . $xoopsConfig['language'] . "/main.php")) {
    include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/english/main.php");
}