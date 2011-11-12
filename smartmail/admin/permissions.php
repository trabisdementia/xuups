<?php
include "header.php";
include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

smart_xoops_cp_header();
smart_adminMenu(2);

$form = new XoopsGroupPermForm(_NL_AM_PERMTITLE, $xoopsModule->getVar('mid'), 'smartmail_newsletter_subscribe', _NL_AM_PERMDESC);
$smartmail_newsletter_handler = xoops_getmodulehandler('newsletter');

$newsletters = $smartmail_newsletter_handler->getList();
foreach ($newsletters as $itemid => $itemName) {
    $form->addItem($itemid, $itemName);
}
$form->display();

smart_modFooter();
xoops_cp_footer();
?>