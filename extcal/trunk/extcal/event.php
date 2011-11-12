<?php

include '../../mainfile.php';
$GLOBALS['xoopsOption']['template_main'] = 'extcal_event.html';
include XOOPS_ROOT_PATH . '/header.php';
//added to have access to $pathImageIcon variable
include_once './admin/admin_header.php';

include XOOPS_ROOT_PATH . '/include/comment_view.php';

if (!isset($_GET['event'])) {
    $eventId = 0;
} else {
    $eventId = intval($_GET['event']);
}
$eventHandler = xoops_getmodulehandler('event', 'extcal');
$fileHandler = xoops_getmodulehandler('file', 'extcal');
$eventmemberHandler = xoops_getmodulehandler('eventmember', 'extcal');
$eventnotmemberHandler = xoops_getmodulehandler('eventnotmember', 'extcal');
$permHandler = ExtcalPerm::getHandler();

// Retriving event
$eventObj = $eventHandler->getEvent($eventId);

if (!$eventObj) {
    redirect_header('index.php', 3, '');
}

$event = $eventHandler->objectToArray($eventObj, array('cat_id', 'event_submitter'));
$eventHandler->serverTimeToUserTime($event);

// Adding formated date for start and end event
$eventHandler->formatEventDate($event, $xoopsModuleConfig['event_date_event']);

// Assigning event to the template
$xoopsTpl->assign('event', $event);

// Title of the page
$xoopsTpl->assign('xoops_pagetitle', $event['event_title']);

// $lang = array(
//     'start' => _MD_EXTCAL_START, 'end' => _MD_EXTCAL_END, 'contact_info' => _MD_EXTCAL_CONTACT_INFO, 'email' => _MD_EXTCAL_EMAIL, 'url' => _MD_EXTCAL_URL, 'whos_going' => _MD_EXTCAL_WHOS_GOING, 'whosnot_going' => _MD_EXTCAL_WHOSNOT_GOING, 'reccur_rule' => _MD_EXTCAL_RECCUR_RULE, 'posted_by' => _MD_EXTCAL_POSTED_BY, 'on' => _MD_EXTCAL_ON
// );
// // Assigning language data to the template
// $xoopsTpl->assign('lang', $lang);

// Getting event attachement
$eventFiles = $fileHandler->objectToArray($fileHandler->getEventFiles($eventId));
$fileHandler->formatFilesSize($eventFiles);
$xoopsTpl->assign('event_attachement', $eventFiles);

// Token to disallow direct posting on membre/nonmember page
$xoopsTpl->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());

// ### For Who's Going function ###

// If the who's goging function is enabled
if ($xoopsModuleConfig['whos_going']) {

    // Retriving member's for this event
    $members = $eventmemberHandler->getMembers($eventId);

    // Initializing variable
    $eventmember['member']['show_button'] = false;

    $nbUser = 0;
    // Making a list with members and counting regitered user's
    foreach (
        $members as $k
        => $v
    ) {
        $nbUser++;
        $eventmember['member']['userList'][] = array('uid' => $k, 'uname' => $v->getVar('uname'));
    }
    $eventmember['member']['nbUser'] = $nbUser;

    // If the user is logged
    if ($xoopsUser) {

        // Initializing variable
        $eventmember['member']['show_button'] = true;
        $eventmember['member']['button_disabled'] = '';

        // If the user is already restired to this event
        if (array_key_exists($xoopsUser->getVar('uid'), $members)) {
            $eventmember['member']['button_text'] = _MD_EXTCAL_REMOVE_ME;
            $eventmember['member']['joinevent_mode'] = 'remove';
        } else {
            $eventmember['member']['button_text'] = _MD_EXTCAL_ADD_ME;
            $eventmember['member']['joinevent_mode'] = 'add';

            // If this event is full
            if ($event['event_nbmember'] != 0
                && $eventmemberHandler->getNbMember($eventId)
                    >= $event['event_nbmember']
            ) {
                $eventmember['member']['disabled'] = ' disabled="disabled"';
            }
        }

    }

}

// ### For Who's not Going function ###

// If the who's not goging function is enabled
if ($xoopsModuleConfig['whosnot_going']) {

    // Retriving not member's for this event
    $notmembers = $eventnotmemberHandler->getMembers($eventId);

    // Initializing variable
    $eventmember['notmember']['show_button'] = false;

    $nbUser = 0;
    // Making a list with not members
    foreach (
        $notmembers as $k
        => $v
    ) {
        $nbUser++;
        $eventmember['notmember']['userList'][] = array('uid' => $k, 'uname' => $v->getVar('uname'));
    }
    $eventmember['notmember']['nbUser'] = $nbUser;

    // If the user is logged
    if ($xoopsUser) {

        // Initializing variable
        $eventmember['notmember']['show_button'] = true;
        $eventmember['notmember']['button_disabled'] = '';

        // If the user is already restired to this event
        if (array_key_exists($xoopsUser->getVar('uid'), $notmembers)) {
            $eventmember['notmember']['button_text'] = _MD_EXTCAL_REMOVE_ME;
            $eventmember['notmember']['joinevent_mode'] = 'remove';
        } else {
            $eventmember['notmember']['button_text'] = _MD_EXTCAL_ADD_ME;
            $eventmember['notmember']['joinevent_mode'] = 'add';
        }
    }

}

// If who's going or not going function is enabled
if ($xoopsModuleConfig['whos_going'] || $xoopsModuleConfig['whosnot_going']) {
    $xoopsTpl->assign('eventmember', $eventmember);
}

// Checking user perm
if ($xoopsUser) {
    $xoopsTpl->assign('isAdmin', $xoopsUser->isAdmin());
    $canEdit
        =
        $permHandler->isAllowed($xoopsUser, 'extcal_cat_edit', $event['cat']['cat_id'])
            && $xoopsUser->getVar('uid') == $event['user']['uid'];
    $xoopsTpl->assign('canEdit', $canEdit);
} else {
    $xoopsTpl->assign('isAdmin', false);
    $xoopsTpl->assign('canEdit', false);
}

$xoopsTpl->assign('whosGoing', $xoopsModuleConfig['whos_going']);
$xoopsTpl->assign('whosNotGoing', $xoopsModuleConfig['whosnot_going']);

include(XOOPS_ROOT_PATH . "/footer.php");
?>
