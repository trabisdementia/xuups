<?php

include '../../mainfile.php';

include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include 'class/perm.php';
include 'class/form/extcalform.php';

// Getting eXtCal object's handler
$eventHandler = xoops_getmodulehandler('event', 'extcal');

$permHandler = ExtcalPerm::getHandler();
$xoopsUser = $xoopsUser ? $xoopsUser : null;
if (count($permHandler->getAuthorizedCat($xoopsUser, 'extcal_cat_submit')) > 0
) {

    include XOOPS_ROOT_PATH . '/header.php';

    // Title of the page
    $xoopsTpl->assign('xoops_pagetitle', _MI_EXTCAL_SUBMIT_EVENT);

    // Display the submit form
    $form = $eventHandler->getEventForm();
    $form->display();

    include XOOPS_ROOT_PATH . '/footer.php';

} else {
    redirect_header("index.php", 3);
}
?>
