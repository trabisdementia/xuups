<?php

include '../../mainfile.php';

include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include 'class/form/extcalform.php';
include 'class/perm.php';

$permHandler = ExtcalPerm::getHandler();
$xoopsUser = $xoopsUser ? $xoopsUser : null;

if (count($permHandler->getAuthorizedCat($xoopsUser, 'extcal_cat_submit')) == 0
    && count($permHandler->getAuthorizedCat($xoopsUser, 'extcal_cat_edit')) == 0
) {
    redirect_header("index.php", 3);
    exit;
}

if (!isset($_GET['event'])) {
    $eventId = 0;
} else {
    $eventId = intval($_GET['event']);
}

// Getting eXtCal object's handler
$eventHandler = xoops_getmodulehandler('event', 'extcal');

include XOOPS_ROOT_PATH . '/header.php';

// Title of the page
$xoopsTpl->assign('xoops_pagetitle', _MI_EXTCAL_SUBMIT_EVENT);

// Display the submit form
$form = $eventHandler->getEventForm('user', 'edit', array('event_id' => $eventId));
$form->display();

include XOOPS_ROOT_PATH . '/footer.php';
?>
