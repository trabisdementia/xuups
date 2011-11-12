<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/mainfile.php';
include_once dirname(dirname(__FILE__)) . '/include/functions.php';
include_once XOOPS_ROOT_PATH . '/include/cp_functions.php';


$xoopsModuleConfig =& subscribers_getModuleConfig(); //must come first
$xoopsModule =& subscribers_getModuleHandler();

$myts =& MyTextSanitizer::getInstance();

if ($xoopsUser) {
    $moduleperm_handler =& xoops_gethandler('groupperm');
    if (!$moduleperm_handler->checkRight('module_admin', $xoopsModule->getVar( 'mid' ), $xoopsUser->getGroups())) {
        redirect_header(XOOPS_URL, 1, _NOPERM);
        exit();
    }
} else {
    redirect_header(XOOPS_URL . "/user.php", 1, _NOPERM);
    exit();
}

if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
    include_once XOOPS_ROOT_PATH . '/class/template.php';
    $xoopsTpl = new XoopsTpl();
}

xoops_loadLanguage('admin', 'subscribers');
xoops_loadLanguage('modinfo', 'subscribers');

?>
