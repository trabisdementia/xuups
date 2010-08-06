<?php

/**
 * $Id: footer.php,v 1.1 2005/05/13 18:21:55 malanciault Exp $
 * Module: SmartMedia
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

global $xoopsModule, $xoopsModuleConfig;

include_once XOOPS_ROOT_PATH . "/modules/smartmedia/include/functions.php";

$uid = ($xoopsUser) ? ($xoopsUser->getVar("uid")) : 0;

$xoopsTpl->assign("smartmedia_adminpage", "<a href='" . SMARTMEDIA_URL . "admin/index.php'>" ._MD_SMEDIA_ADMIN_PAGE . "</a>");
$xoopsTpl->assign("isAdmin", $is_smartmedia_admin);
$xoopsTpl->assign('smartmedia_url', SMARTMEDIA_URL);
$xoopsTpl->assign('smartmedia_images_url', SMARTMEDIA_IMAGES_URL);

$xoopsTpl->assign("xoops_module_header", "<link rel=\"stylesheet\" type=\"text/css\" href=\"smartmedia.css\" />
<script language=\"JavaScript\">
<!--
function show(object) {
    if (document.getElementById && document.getElementById(object) != null)
         node = document.getElementById(object).style.display='block';
    else if (document.layers && document.layers[object] != null)
        document.layers[object].display = 'block';
    else if (document.all)
        document.all[object].style.display = 'block'; }

function hide(object) {
    if (document.getElementById && document.getElementById(object) != null)
         node = document.getElementById(object).style.display='none';
    else if (document.layers && document.layers[object] != null)
        document.layers[object].display = 'none';
    else if (document.all)
         document.all[object].style.display = 'none'; } //-->

</script>
");

$xoopsTpl->assign("ref_smartfactory", "SmartMedia is developed by The SmartFactory (http://www.smartfactory.ca), a division of InBox Solutions (http://www.inboxsolutions.net)");

?>