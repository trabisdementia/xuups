<?php

/**
 * $Id: footer.php,v 1.1 2006/07/07 20:23:24 marcan Exp $
 * Module: SmartShop
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

$uid = ($xoopsUser) ? ($xoopsUser->getVar("uid")) : 0;

$xoopsTpl->assign("smartmail_adminpage", "<a href='" . XOOPS_URL . "/modules/smartmail/admin/index.php'>" ._CO_SOBJECT_ADMIN_PAGE . "</a>");
$xoopsTpl->assign("isAdmin", $smartmail_isAdmin);
$xoopsTpl->assign('smartmail_url', SMARTMAIL_URL);
$xoopsTpl->assign('smartmail_images_url', SMARTMAIL_IMAGES_URL);

$xoopsTpl->assign("xoops_module_header", smart_get_css_link(SMARTMAIL_URL . 'module.css') . ' ' . smart_get_css_link(SMARTOBJECT_URL . 'module.css'));

$xoopsTpl->assign("ref_smartfactory", "SmartMail is developed by The SmartFactory (http://smartfactory.ca), a division of InBox Solutions (http://inboxsolutions.net)");

?>