<?php

/**
 * $Id: footer.php,v 1.1 2007/06/05 18:28:22 marcan Exp $
 * Module: SmartPartner
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

$xoopsTpl->assign("xoops_module_header", "<link rel='stylesheet' type='text/css' href='" . SMARTPARTNER_URL . "/module.css'/>");
$xoopsTpl->assign("smartpartner_adminpage", "<a href='" . SMARTPARTNER_URL . "admin/index.php'>" . _MD_SPARTNER_ADMIN_PAGE . "</a>");
$xoopsTpl->assign("smartpartner_url", SMARTPARTNER_URL);

$isAdmin = smartpartner_userIsAdmin();
$xoopsTpl->assign("isAdmin", $isAdmin);

$xoopsTpl->assign("ref_smartpartner", "SmartPartner is developed by The SmartFactory (http://www.smartfactory.ca), a division of INBOX International (http://inboxinternational.com)");


?>