<?php

include '../../mainfile.php';

if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(
        'index.php', 3, _NOPERM . "<br />"
        . implode('<br />', $GLOBALS['xoopsSecurity']->getErrors())
    );
    exit;
}

if ($xoopsUser && $xoopsModuleConfig['whosnot_going']) {
    // If param are right
    if (($_POST['mode'] == 'add' || $_POST['mode'] == 'remove')
        && intval($_POST['event']) > 0
    ) {

        $eventHandler = xoops_getmodulehandler("event", "extcal");
        $eventNotmemberHandler = xoops_getmodulehandler("eventnotmember", "extcal");

        // If the user have to be added
        if ($_POST['mode'] == 'add') {
            $event = $eventHandler->getEvent(intval($_POST['event']), $xoopsUser);
            $eventNotmemberHandler->createEventnotmember(array('event_id' => intval($_POST['event']), 'uid' => $xoopsUser->getVar('uid')));
            $rediredtMessage = _MD_EXTCAL_WHOSNOT_GOING_ADDED_TO_EVENT;

            // If the user have to be remove
        } else {
            if ($_POST['mode'] == 'remove') {
                $eventNotmemberHandler->deleteEventnotmember(array(intval($_POST['event']), $xoopsUser->getVar('uid')));
                $rediredtMessage = _MD_EXTCAL_WHOSNOT_GOING_REMOVED_TO_EVENT;
            }
        }
        redirect_header(
            "event.php?event=" . $_POST['event'], 3, $rediredtMessage, false
        );
    } else {
        redirect_header("index.php", 3, _NOPERM, false);
    }
} else {
    redirect_header("index.php", 3, _NOPERM, false);
}
?>
