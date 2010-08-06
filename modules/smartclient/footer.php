<?php

/**
 * $Id: footer.php,v 1.4 2005/04/19 18:20:56 fx2024 Exp $
 * Module: SmartClient
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

$xoopsTpl->assign("xoops_module_header", "<link rel='stylesheet' type='text/css' href='" . SMARTCLIENT_URL . "/module.css'/>");
$xoopsTpl->assign("smartclient_adminpage", "<a href='" . SMARTCLIENT_URL . "admin/index.php'>" . _MD_SCLIENT_ADMIN_PAGE . "</a>");
$xoopsTpl->assign("smartclient_url", SMARTCLIENT_URL);

$isAdmin = (smartclient_userIsAdmin());
$xoopsTpl->assign("isAdmin", $isAdmin);

$xoopsTpl->assign("ref_smartclient", "SmartClient is developed by The SmartFactory (http://www.smartfactory.ca), a division of InBox Solutions (http://www.inboxsolutions.net)");


?>