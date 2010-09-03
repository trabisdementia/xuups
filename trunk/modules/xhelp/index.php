<?php
//$Id: index.php,v 1.98 2005/12/12 19:08:05 eric_juden Exp $
require_once('header.php');
require_once(XHELP_INCLUDE_PATH . '/events.php');
include_once(XOOPS_ROOT_PATH . '/class/pagenav.php');


// Setup event handlers for page

//Initialise Necessary Data Handler Classes
$hStaff =& xhelpGetHandler('staff');
$hXoopsMember =& xoops_gethandler('member');
$hDepartments =& xhelpGetHandler('department');
$hMembership =& xhelpGetHandler('membership');
$hTickets =& xhelpGetHandler('ticket');
$hTicketList =& xhelpGetHandler('ticketList');
$hSavedSearch =& xhelpGetHandler('savedSearch');

//Determine default 'op' (if none is specified)
$uid = 0;
if ($xoopsUser) {
    $uid = $xoopsUser->getVar('uid');
    if ($xhelp_isStaff) {
        $op = 'staffMain';
    } else {
        $op = 'userMain';
    }
} else {
    $op = 'anonMain';
}

// Page Global Variables
$status_opt = array(_XHELP_TEXT_SELECT_ALL => -1, _XHELP_STATUS0 => 0, _XHELP_STATUS1 => 1, _XHELP_STATUS2 => 2);
$state_opt = array(_XHELP_TEXT_SELECT_ALL => -1, _XHELP_STATE1 => 1, _XHELP_STATE2 => 2);
$sort_columns = array();
$sort_order = array('ASC', 'DESC');
$vars = array('op', 'limit', 'start', 'sort', 'order', 'refresh');
$all_users = array();
$refresh = $start = $limit = 0;
$sort = '';
$order = '';

//Initialize Variables                                                                                
foreach ($vars as $var) {
    if (isset($_REQUEST[$var])) {
        $$var = $_REQUEST[$var];
    }
}

//Ensure Criteria Fields hold valid values
$limit = intval($limit);
$start = intval($start);
$sort = strtolower($sort);
$order = (in_array(strtoupper($order), $sort_order) ? $order : 'ASC');

$displayName =& $xoopsModuleConfig['xhelp_displayName']; // Determines if username or real name is displayed

switch ($op) {

    case 'staffMain':
        staffmain_display();
        break;

    case 'staffViewAll':
        staffviewall_display();
        break;

    case 'userMain':
        usermain_display();
        break;

    case 'userViewAll':
        userviewall_display();
        break;

    case 'setdept':
        if (!$xhelp_isStaff) {
            redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _NOPERM);
        }

        /*
         if(!$hasRights = $xhelp_staff->checkRoleRights(XHELP_SEC_TICKET_EDIT)){
         $message = _XHELP_MESSAGE_NO_EDIT_TICKET;
         redirect_header(XHELP_BASE_URL."/".basename(__FILE__), 3, $message);
         }
         */
        if (isset($_POST['setdept'])) {
            setdept_action();
        } else {
            setdept_display();
        }
        break;

    case 'setpriority':
        if (!$xhelp_isStaff) {
            redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _NOPERM);
        }
        /*
         if(!$hasRights = $xhelp_staff->checkRoleRights(XHELP_SEC_TICKET_PRIORITY)){
         $message = _XHELP_MESSAGE_NO_CHANGE_PRIORITY;
         redirect_header(XHELP_BASE_URL."/".basename(__FILE__), 3, $message);
         }
         */
        if (isset($_POST['setpriority'])) {
            setpriority_action();
        } else {
            setpriority_display();
        }
        break;

    case 'setstatus':
        if (!$xhelp_isStaff) {
            redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _NOPERM);
        }
        /*
         if(!$hasRights = $xhelp_staff->checkRoleRights(XHELP_SEC_TICKET_STATUS)){
         $message = _XHELP_MESSAGE_NO_CHANGE_STATUS;
         redirect_header(XHELP_BASE_URL."/".basename(__FILE__), 3, $message);
         }
         */
        if (isset($_POST['setstatus'])) {
            setstatus_action();
        } else {
            setstatus_display();
        }
        break;

    case 'setowner':
        if (!$xhelp_isStaff) {
            redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _NOPERM);
        }
        /*
         if(!$hasRights = $xhelp_staff->checkRoleRights(XHELP_SEC_TICKET_OWNERSHIP)){
         $message = _XHELP_MESSAGE_NO_CHANGE_OWNER;
         redirect_header(XHELP_BASE_URL."/".basename(__FILE__), 3, $message);
         }
         */
        if (isset($_POST['setowner'])) {
            setowner_action();
        } else {
            setowner_display();
        }
        break;

    case 'addresponse':
        if (!$xhelp_isStaff) {
            redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _NOPERM);
        }
        /*
         if(!$hasRights = $xhelp_staff->checkRoleRights(XHELP_SEC_RESPONSE_ADD)){
         $message = _XHELP_MESSAGE_NO_ADD_RESPONSE;
         redirect_header(XHELP_BASE_URL."/".basename(__FILE__), 3, $message);
         }
         */
        if (isset($_POST['addresponse'])) {
            addresponse_action();
        } else {
            addresponse_display();
        }
        break;

    case 'delete':
        if (!$xhelp_isStaff) {
            redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _NOPERM);
        }
        /*
         if(!$hasRights = $xhelp_staff->checkRoleRights(XHELP_SEC_TICKET_DELETE)){
         $message = _XHELP_MESSAGE_NO_DELETE_TICKET;
         redirect_header(XHELP_BASE_URL."/".basename(__FILE__), 3, $message);
         }
         */
        if (isset($_POST['delete'])) {
            delete_action();
        } else {
            delete_display();
        }
        break;

    case 'anonMain':
        $config_handler =& xoops_gethandler('config');
        $xoopsConfigUser = array();
        $crit = new CriteriaCompo(new Criteria('conf_name', 'allow_register'), 'OR');
        $crit->add(new Criteria('conf_name', 'activation_type'), 'OR');
        $myConfigs =& $config_handler->getConfigs($crit);

        foreach ($myConfigs as $myConf) {
            $xoopsConfigUser[$myConf->getVar('conf_name')] = $myConf->getVar('conf_value');
        }

        if ($xoopsConfigUser['allow_register'] == 0) {
            header("Location: " . XHELP_BASE_URL . "/error.php");
        } else {
            header("Location: " . XHELP_BASE_URL . "/addTicket.php");
        }
        exit();
        break;
    default:
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3);
        break;
}

/**
 * Assign the selected tickets to the specified department
 */
function setdept_action()
{
    global $_eventsrv, $xhelp_staff;

    //Sanity Check: tickets and department are supplied
    if (!isset($_POST['tickets'])) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_TICKETS);
    }

    if (!isset($_POST['department'])) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_DEPARTMENT);
    }
    $tickets = implode($_POST['tickets'], ',');
    $tickets = _cleanTickets($tickets);
    $oTickets =& xhelpGetTickets($tickets);

    $depts = array();
    foreach ($oTickets as $ticket) {
        $depts[$ticket->getVar('department')] = $ticket->getVar('department');
    }

    // Check staff permissions
    if (!$xhelp_staff->checkRoleRights(XHELP_SEC_TICKET_EDIT, $depts)) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_EDIT_TICKET);
    }

    $ret = xhelpSetDept($tickets, $_POST['department']);
    if ($ret) {
        $_eventsrv->trigger('batch_dept', array(@$oTickets, $_POST['department']));
        if (count($oTickets) > 1) {
            redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_UPDATE_DEPARTMENT);
        } else {
            redirect_header(XHELP_BASE_URL . "/ticket.php?id=" . $oTickets[0]->getVar('id'), 3, _XHELP_MESSAGE_UPDATE_DEPARTMENT);
        }
        end();
    }
    redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_UPDATE_DEPARTMENT_ERROR);
}

/**
 * Display form for the Batch Action: Set Department
 */
function setdept_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $displayName;

    if (!isset($_POST['tickets'])) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_TICKETS);
    }

    $hDepartments =& xhelpGetHandler('department');
    $depts = $hDepartments->getObjects(null, true);
    $oTickets =& xhelpGetTickets($_POST['tickets']);
    $all_users = array();
    $j = 0;

    $sortedTickets = _makeBatchTicketArray($oTickets, $depts, $all_users, $j, XHELP_SEC_TICKET_EDIT);
    unset($oTickets);

    $tplDepts = array();
    foreach ($depts as $dept) {
        $tplDepts[$dept->getVar('id')] = $dept->getVar('department');
    }
    unset($depts);

    //Retrieve all member information for the current page
    if (count($all_users)) {
        $crit = new Criteria('uid', "(" . implode(array_keys($all_users), ',') . ")", 'IN');
        $users =& xhelpGetUsers($crit, $displayName);
    } else {
        $users = array();
    }
    $sortedTickets =& _updateBatchTicketInfo($sortedTickets, $users, $j);

    $xoopsOption['template_main'] = 'xhelp_setdept.html'; // Set template
    require(XOOPS_ROOT_PATH . '/header.php'); // Include the page header
    $xoopsTpl->assign('xhelp_department_options', $tplDepts);
    $xoopsTpl->assign('xhelp_tickets', implode($_POST['tickets'], ','));
    $xoopsTpl->assign('xhelp_goodTickets', $sortedTickets['good']);
    $xoopsTpl->assign('xhelp_badTickets', $sortedTickets['bad']);
    $xoopsTpl->assign('xhelp_hasGoodTickets', count($sortedTickets['good']) > 0);
    $xoopsTpl->assign('xhelp_hasBadTickets', count($sortedTickets['bad']) > 0);
    $xoopsTpl->assign('xhelp_batchErrorMsg', _XHELP_MESSAGE_NO_EDIT_TICKET);
    require(XOOPS_ROOT_PATH . '/footer.php');
}

function setpriority_action()
{
    global $_eventsrv, $xhelp_staff;
    if (!isset($_POST['tickets'])) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_TICKETS);
    }

    if (!isset($_POST['priority'])) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_PRIORITY);
    }
    $tickets = implode($_POST['tickets'], ',');
    $tickets = _cleanTickets($tickets);
    $oTickets =& xhelpGetTickets($tickets);

    $depts = array();
    foreach ($oTickets as $ticket) {
        $depts[$ticket->getVar('department')] = $ticket->getVar('department');
    }

    // Check staff permissions
    if (!$xhelp_staff->checkRoleRights(XHELP_SEC_TICKET_PRIORITY, $depts)) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_CHANGE_PRIORITY);
    }

    $ret = xhelpSetPriority($tickets, $_POST['priority']);
    if ($ret) {
        $_eventsrv->trigger('batch_priority', array(@$oTickets, $_POST['priority']));
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_UPDATE_PRIORITY);
    }
    redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_UPDATE_PRIORITY_ERROR);
}

function setpriority_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin, $displayName;

    //Make sure that some tickets were selected
    if (!isset($_POST['tickets'])) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_TICKETS);
    }

    $hDepartments =& xhelpGetHandler('department');
    $depts = $hDepartments->getObjects(null, true);
    $oTickets =& xhelpGetTickets($_POST['tickets']);
    $all_users = array();
    $j = 0;

    $sortedTickets = _makeBatchTicketArray($oTickets, $depts, $all_users, $j, XHELP_SEC_TICKET_PRIORITY);
    unset($oTickets);

    //Retrieve all member information for the current page
    if (count($all_users)) {
        $crit = new Criteria('uid', "(" . implode(array_keys($all_users), ',') . ")", 'IN');
        $users =& xhelpGetUsers($crit, $displayName);
    } else {
        $users = array();
    }
    $sortedTickets =& _updateBatchTicketInfo($sortedTickets, $users, $j);

    //Get Array of priorities/descriptions
    $aPriority = array(1 => _XHELP_PRIORITY1, 2 => _XHELP_PRIORITY2, 3 => _XHELP_PRIORITY3, 4 => _XHELP_PRIORITY4, 5 => _XHELP_PRIORITY5);

    $xoopsOption['template_main'] = 'xhelp_setpriority.html'; // Set template
    require(XOOPS_ROOT_PATH . '/header.php');
    $xoopsTpl->assign('xhelp_priorities_desc', $aPriority);
    $xoopsTpl->assign('xhelp_priorities', array_keys($aPriority));
    $xoopsTpl->assign('xhelp_priority', 4);
    $xoopsTpl->assign('xhelp_imagePath', XHELP_IMAGE_URL . '/');
    $xoopsTpl->assign('xhelp_tickets', implode($_POST['tickets'], ','));
    $xoopsTpl->assign('xhelp_goodTickets', $sortedTickets['good']);
    $xoopsTpl->assign('xhelp_badTickets', $sortedTickets['bad']);
    $xoopsTpl->assign('xhelp_hasGoodTickets', count($sortedTickets['good']) > 0);
    $xoopsTpl->assign('xhelp_hasBadTickets', count($sortedTickets['bad']) > 0);
    $xoopsTpl->assign('xhelp_batchErrorMsg', _XHELP_MESSAGE_NO_CHANGE_PRIORITY);
    require(XOOPS_ROOT_PATH . '/footer.php');
}

function setstatus_action()
{
    global $_eventsrv, $xhelp_staff;
    if (!isset($_POST['tickets'])) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_TICKETS);
    }

    if (!isset($_POST['status'])) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_STATUS);
    }
    $tickets = implode($_POST['tickets'], ',');
    $tickets = _cleanTickets($tickets);
    $oTickets =& xhelpGetTickets($tickets);

    $depts = array();
    foreach ($oTickets as $ticket) {
        $depts[$ticket->getVar('department')] = $ticket->getVar('department');
    }

    // Check staff permissions
    if (!$xhelp_staff->checkRoleRights(XHELP_SEC_TICKET_STATUS, $depts)) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_CHANGE_STATUS);
    }

    $hStatus =& xhelpGetHandler('status');
    $status =& $hStatus->get($_POST['status']);
    $ret = xhelpSetStatus($tickets, $_POST['status']);
    if ($ret) {
        $_eventsrv->trigger('batch_status', array(&$oTickets, &$status));
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_UPDATE_STATUS);
        end();
    }
    redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_UPDATE_STATUS_ERROR);

}

function setstatus_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin, $displayName;
    $hStatus =& xhelpGetHandler('status');
    $crit = new Criteria('', '');
    $crit->setOrder('ASC');
    $crit->setSort('description');
    $statuses =& $hStatus->getObjects($crit);

    //Make sure that some tickets were selected
    if (!isset($_POST['tickets'])) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_TICKETS);
    }

    $hDepartments =& xhelpGetHandler('department');
    $depts = $hDepartments->getObjects(null, true);
    $oTickets =& xhelpGetTickets($_POST['tickets']);
    $all_users = array();
    $j = 0;

    $sortedTickets = _makeBatchTicketArray($oTickets, $depts, $all_users, $j, XHELP_SEC_TICKET_STATUS);
    unset($oTickets);

    //Retrieve all member information for the current page
    if (count($all_users)) {
        $crit = new Criteria('uid', "(" . implode(array_keys($all_users), ',') . ")", 'IN');
        $users =& xhelpGetUsers($crit, $displayName);
    } else {
        $users = array();
    }
    $sortedTickets =& _updateBatchTicketInfo($sortedTickets, $users, $j);

    //Get Array of Status/Descriptions
    $aStatus = array();
    foreach ($statuses as $status) {
        $aStatus[$status->getVar('id')] = $status->getVar('description');
    }

    $xoopsOption['template_main'] = 'xhelp_setstatus.html'; // Set template
    require(XOOPS_ROOT_PATH . '/header.php');
    $xoopsTpl->assign('xhelp_status_options', $aStatus);
    $xoopsTpl->assign('xhelp_tickets', implode($_POST['tickets'], ','));
    $xoopsTpl->assign('xhelp_goodTickets', $sortedTickets['good']);
    $xoopsTpl->assign('xhelp_badTickets', $sortedTickets['bad']);
    $xoopsTpl->assign('xhelp_hasGoodTickets', count($sortedTickets['good']) > 0);
    $xoopsTpl->assign('xhelp_hasBadTickets', count($sortedTickets['bad']) > 0);
    $xoopsTpl->assign('xhelp_batchErrorMsg', _XHELP_MESSAGE_NO_CHANGE_STATUS);
    require(XOOPS_ROOT_PATH . '/footer.php');
}

function setowner_action()
{
    global $_eventsrv, $xhelp_staff;
    if (!isset($_POST['tickets'])) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_TICKETS);
    }

    if (!isset($_POST['owner'])) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_OWNER);
    }
    $tickets = implode($_POST['tickets'], ',');
    $tickets = _cleanTickets($tickets);
    $oTickets =& xhelpGetTickets($tickets);

    $depts = array();
    foreach ($oTickets as $ticket) {
        $depts[$ticket->getVar('department')] = $ticket->getVar('department');
    }

    // Check staff permissions
    if (!$xhelp_staff->checkRoleRights(XHELP_SEC_TICKET_OWNERSHIP, $depts)) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_CHANGE_OWNER);
    }
    $ret = xhelpSetOwner($tickets, $_POST['owner']);

    if ($ret) {
        $_eventsrv->trigger('batch_owner', array(&$oTickets, $_POST['owner']));
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_ASSIGN_OWNER);
        end();
    }
    redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_ASSIGN_OWNER_ERROR);
}

function setowner_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsModuleConfig, $displayName;

    //Make sure that some tickets were selected
    if (!isset($_POST['tickets'])) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_TICKETS);
    }

    $hTickets =& xhelpGetHandler('ticket');
    $hMember =& xhelpGetHandler('membership');
    $hXoopsMember =& xoops_gethandler('member');

    $hDepartments =& xhelpGetHandler('department');
    $depts = $hDepartments->getObjects(null, true);
    $oTickets =& xhelpGetTickets($_POST['tickets']);
    $all_users = array();
    $j = 0;

    $sortedTickets = _makeBatchTicketArray($oTickets, $depts, $all_users, $j, XHELP_SEC_TICKET_OWNERSHIP);
    unset($oTickets);

    //Retrieve all member information for the current page
    if (count($all_users)) {
        $crit = new Criteria('uid', "(" . implode(array_keys($all_users), ',') . ")", 'IN');
        $users =& xhelpGetUsers($crit, $displayName);
    } else {
        $users = array();
    }
    $sortedTickets =& _updateBatchTicketInfo($sortedTickets, $users, $j);

    $aOwners = array();
    foreach ($users as $uid => $user) {
        $aOwners[$uid] = $uid;
    }
    $crit = new Criteria('uid', "(" . implode(array_keys($aOwners), ',') . ")", 'IN');
    $owners =& xhelpGetUsers($crit, $xoopsModuleConfig['xhelp_displayName']);

    $a_users = array();
    $a_users[0] = _XHELP_NO_OWNER;
    foreach ($owners as $owner_id => $owner_name) {
        $a_users[$owner_id] = $owner_name;
    }
    unset($users);
    unset($owners);
    unset($aOwners);

    $xoopsOption['template_main'] = 'xhelp_setowner.html'; // Set template
    require(XOOPS_ROOT_PATH . '/header.php');
    $xoopsTpl->assign('xhelp_staff_ids', $a_users);
    $xoopsTpl->assign('xhelp_tickets', implode($_POST['tickets'], ','));
    $xoopsTpl->assign('xhelp_goodTickets', $sortedTickets['good']);
    $xoopsTpl->assign('xhelp_badTickets', $sortedTickets['bad']);
    $xoopsTpl->assign('xhelp_hasGoodTickets', count($sortedTickets['good']) > 0);
    $xoopsTpl->assign('xhelp_hasBadTickets', count($sortedTickets['bad']) > 0);
    $xoopsTpl->assign('xhelp_batchErrorMsg', _XHELP_MESSAGE_NO_CHANGE_OWNER);
    require(XOOPS_ROOT_PATH . '/footer.php');
}

function addresponse_action()
{
    global $_eventsrv, $_xhelpSession, $xhelp_staff;
    if (!isset($_POST['tickets'])) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_TICKETS);
    }

    if (!isset($_POST['response'])) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_RESPONSE);
    }
    $private = isset($_POST['private']);

    $tickets = implode($_POST['tickets'], ',');
    $tickets = _cleanTickets($tickets);
    $oTickets =& xhelpGetTickets($tickets);

    $depts = array();
    foreach ($oTickets as $ticket) {
        $depts[$ticket->getVar('department')] = $ticket->getVar('department');
    }

    // Check staff permissions
    if (!$xhelp_staff->checkRoleRights(XHELP_SEC_RESPONSE_ADD, $depts)) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_ADD_RESPONSE);
    }
    $ret =& xhelpAddResponse($tickets, $_POST['response'], $_POST['timespent'], $private);
    if ($ret) {
        $_xhelpSession->del('xhelp_batch_addresponse');
        $_xhelpSession->del('xhelp_batch_response');
        $_xhelpSession->del('xhelp_batch_timespent');
        $_xhelpSession->del('xhelp_batch_private');

        $_eventsrv->trigger('batch_response', array(&$oTickets, &$ret));
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_ADDRESPONSE);
        end();
    }
    redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_ADDRESPONSE_ERROR);

}

function addresponse_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin, $_xhelpSession, $displayName;
    $hResponseTpl =& xhelpGetHandler('responseTemplates');
    $ticketVar = 'xhelp_batch_addresponse';
    $tpl = 0;
    $uid = $xoopsUser->getVar('uid');

    //Make sure that some tickets were selected
    if (!isset($_POST['tickets'])) {
        if (!$tickets = $_xhelpSession->get($ticketVar)) {
            redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_TICKETS);
        }
    } else {
        $tickets = $_POST['tickets'];
    }

    $hDepartments =& xhelpGetHandler('department');
    $depts = $hDepartments->getObjects(null, true);
    $oTickets =& xhelpGetTickets($_POST['tickets']);
    $all_users = array();
    $j = 0;

    $sortedTickets = _makeBatchTicketArray($oTickets, $depts, $all_users, $j, XHELP_SEC_RESPONSE_ADD);
    unset($oTickets);

    //Retrieve all member information for the current page
    if (count($all_users)) {
        $crit = new Criteria('uid', "(" . implode(array_keys($all_users), ',') . ")", 'IN');
        $users =& xhelpGetUsers($crit, $displayName);
    } else {
        $users = array();
    }
    $sortedTickets =& _updateBatchTicketInfo($sortedTickets, $users, $j);

    //Store tickets in session so they won't be in URL
    $_xhelpSession->set($ticketVar, $tickets);

    //Check if a predefined response was selected
    if (isset($_REQUEST['tpl'])) {
        $tpl = $_REQUEST['tpl'];
    }

    $xoopsOption['template_main'] = 'xhelp_batch_response.html';
    require(XOOPS_ROOT_PATH . '/header.php');
    $xoopsTpl->assign('xhelp_tickets', implode($tickets, ','));
    $xoopsTpl->assign('xhelp_formaction', basename(__FILE__));
    $xoopsTpl->assign('xhelp_imagePath', XHELP_IMAGE_URL . '/');
    $xoopsTpl->assign('xhelp_timespent', ($timespent = $_xhelpSession->get('xhelp_batch_timespent') ? $timespent : ''));
    $xoopsTpl->assign('xhelp_goodTickets', $sortedTickets['good']);
    $xoopsTpl->assign('xhelp_badTickets', $sortedTickets['bad']);
    $xoopsTpl->assign('xhelp_hasGoodTickets', count($sortedTickets['good']) > 0);
    $xoopsTpl->assign('xhelp_hasBadTickets', count($sortedTickets['bad']) > 0);
    $xoopsTpl->assign('xhelp_batchErrorMsg', _XHELP_MESSAGE_NO_ADD_RESPONSE);
    $xoopsTpl->assign('xhelp_responseTpl', $tpl);

    //Get all staff defined templates
    $crit = new Criteria('uid', $uid);
    $crit->setSort('name');
    $responseTpl =& $hResponseTpl->getObjects($crit, true);

    //Fill Response Template Array
    $tpls = array();
    $tpls[0] = '------------------';

    foreach ($responseTpl as $key => $obj) {
        $tpls[$key] = $obj->getVar('name');
    }
    $xoopsTpl->assign('xhelp_responseTpl_options', $tpls);
    //Get response message to display
    if (isset($responseTpl[$tpl])) { // Display Template Text
        $xoopsTpl->assign('xhelp_response_message', $responseTpl[$tpl]->getVar('response', 'e'));
    } else {
        if ($response = $_xhelpSession->get('xhelp_batch_response')) { //Display Saved Text
            $xoopsTpl->assign('xhelp_response_message', $response);
        }
    }

    //Private Message?
    $xoopsTpl->assign('xhelp_private', ($private = $_xhelpSession->get('xhelp_batch_private') ? $private : false));

    require(XOOPS_ROOT_PATH . '/footer.php');
}

function delete_action()
{
    global $_eventsrv, $xhelp_staff;
    if (!isset($_POST['tickets'])) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_TICKETS);
    }

    $tickets = implode($_POST['tickets'], ',');
    $tickets = _cleanTickets($tickets);
    $oTickets =& xhelpGetTickets($tickets);

    $depts = array();
    foreach ($oTickets as $ticket) {
        $depts[$ticket->getVar('department')] = $ticket->getVar('department');
    }

    // Check staff permissions
    if (!$xhelp_staff->checkRoleRights(XHELP_SEC_TICKET_DELETE, $depts)) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_NO_DELETE_TICKET);
    }

    $ret = xhelpDeleteTickets($tickets);
    if ($ret) {
        $_eventsrv->trigger('batch_delete_ticket', array(@$oTickets));
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_DELETE_TICKETS);
        end();
    }
    redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _XHELP_MESSAGE_DELETE_TICKETS_ERROR);
}

function delete_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin, $displayName;

    //Make sure that some tickets were selected
    if (!isset($_POST['tickets'])) {
        redirect_header(XHELP_BASE_URL . "/index.php", 3, _XHELP_MESSAGE_NO_TICKETS);
    }

    $hDepartments =& xhelpGetHandler('department');
    $depts = $hDepartments->getObjects(null, true);
    $oTickets =& xhelpGetTickets($_POST['tickets']);
    $all_users = array();
    $j = 0;

    $sortedTickets = _makeBatchTicketArray($oTickets, $depts, $all_users, $j, XHELP_SEC_TICKET_DELETE);
    unset($oTickets);

    //Retrieve all member information for the current page
    if (count($all_users)) {
        $crit = new Criteria('uid', "(" . implode(array_keys($all_users), ',') . ")", 'IN');
        $users =& xhelpGetUsers($crit, $displayName);
    } else {
        $users = array();
    }
    $sortedTickets =& _updateBatchTicketInfo($sortedTickets, $users, $j);

    $hiddenvars = array('delete' => _XHELP_BUTTON_SET, //'tickets' => implode($_POST['tickets'], ','),
                        'op' => 'delete');
    $aHiddens[] = array('name' => 'delete',
                        'value' => _XHELP_BUTTON_SET);
    $aHiddens[] = array('name' => 'op',
                        'value' => 'delete');
    $xoopsOption['template_main'] = 'xhelp_deletetickets.html';
    require(XOOPS_ROOT_PATH . '/header.php');
    $xoopsTpl->assign('xhelp_message', _XHELP_MESSAGE_TICKET_DELETE_CNFRM);
    $xoopsTpl->assign('xhelp_hiddens', $aHiddens);
    $xoopsTpl->assign('xhelp_goodTickets', $sortedTickets['good']);
    $xoopsTpl->assign('xhelp_badTickets', $sortedTickets['bad']);
    $xoopsTpl->assign('xhelp_hasGoodTickets', count($sortedTickets['good']) > 0);
    $xoopsTpl->assign('xhelp_hasBadTickets', count($sortedTickets['bad']) > 0);
    $xoopsTpl->assign('xhelp_batchErrorMsg', _XHELP_MESSAGE_NO_DELETE_TICKET);
    require(XOOPS_ROOT_PATH . '/footer.php');
}

/**
 * @todo make SmartyNewsRenderer class
 */
function getAnnouncements($topicid, $limit = 5, $start = 0)
{
    global $xoopsUser, $xoopsConfig, $xoopsModule, $xoopsTpl;
    $module_handler = xoops_gethandler('module');

    if (!$count =& $module_handler->getByDirname('news') || $topicid == 0) {
        $xoopsTpl->assign('xhelp_useAnnouncements', false);
        return false;
    }
    include_once XOOPS_ROOT_PATH . '/modules/news/class/class.newsstory.php';
    $news_version = round($count->getVar('version') / 100, 2);

    switch ($news_version) {
        case "1.1":
            $sarray = NewsStory::getAllPublished($limit, $start, $topicid);
            break;

        case "1.21":
        default:
            $sarray = NewsStory::getAllPublished($limit, $start, false, $topicid);
    }

    $scount = count($sarray);
    for ($i = 0; $i < $scount; $i++) {
        $story = array();
        $story['id'] = $sarray[$i]->storyid();
        $story['poster'] = $sarray[$i]->uname();
        if ($story['poster'] != false) {
            $story['poster'] = "<a href='" . XOOPS_URL . "/userinfo.php?uid=" . $sarray[$i]->uid() . "'>" . $story['poster'] . "</a>";
        } else {
            $story['poster'] = $xoopsConfig['anonymous'];
        }
        $story['posttime'] = formatTimestamp($sarray[$i]->published());
        $story['text'] = $sarray[$i]->hometext();
        $introcount = strlen($story['text']);
        $fullcount = strlen($sarray[$i]->bodytext());
        $totalcount = $introcount + $fullcount;
        $morelink = '';
        if ($fullcount > 1) {
            $morelink .= '<a href="' . XOOPS_URL . '/modules/news/article.php?storyid=' . $sarray[$i]->storyid() . '';
            $morelink .= '">' . _XHELP_ANNOUNCE_READMORE . '</a> | ';
            //$morelink .= sprintf(_NW_BYTESMORE,$totalcount);
            //$morelink .= ' | ';
        }
        $ccount = $sarray[$i]->comments();
        $morelink .= '<a href="' . XOOPS_URL . '/modules/news/article.php?storyid=' . $sarray[$i]->storyid() . '';
        $morelink2 = '<a href="' . XOOPS_URL . '/modules/news/article.php?storyid=' . $sarray[$i]->storyid() . '';
        if ($ccount == 0) {
            $morelink .= '">' . _XHELP_COMMMENTS . '</a>';
        } else {
            if ($fullcount < 1) {
                if ($ccount == 1) {
                    $morelink .= '">' . _XHELP_ANNOUNCE_READMORE . '</a> | ' . $morelink2 . '">' . _XHELP_ANNOUNCE_ONECOMMENT . '</a>';
                } else {
                    $morelink .= '">' . _XHELP_ANNOUNCE_READMORE . '</a> | ' . $morelink2 . '">';
                    $morelink .= sprintf(_XHELP_ANNOUNCE_NUMCOMMENTS, $ccount);
                    $morelink .= '</a>';
                }
            } else {
                if ($ccount == 1) {
                    $morelink .= '">' . _XHELP_ANNOUNCE_ONECOMMENT . '</a>';
                } else {
                    $morelink .= '">';
                    $morelink .= sprintf(_XHELP_ANNOUNCE_NUMCOMMENTS, $ccount);
                    $morelink .= '</a>';
                }
            }
        }
        $story['morelink'] = $morelink;
        $story['adminlink'] = '';
        if ($xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid())) {
            $story['adminlink'] = $sarray[$i]->adminlink();
        }
        //$story['mail_link'] = 'mailto:?subject='.sprintf(_NW_INTARTICLE,$xoopsConfig['sitename']).'&amp;body='.sprintf(_NW_INTARTFOUND, $xoopsConfig['sitename']).':  '.XOOPS_URL.'/modules/news/article.php?storyid='.$sarray[$i]->storyid();
        $story['imglink'] = '';
        $story['align'] = '';
        if ($sarray[$i]->topicdisplay()) {
            $story['imglink'] = $sarray[$i]->imglink();
            $story['align'] = $sarray[$i]->topicalign();
        }
        $story['title'] = $sarray[$i]->textlink() . '&nbsp;:&nbsp;' . "<a href='" . XOOPS_URL . "/modules/news/article.php?storyid=" . $sarray[$i]->storyid() . "'>" . $sarray[$i]->title() . "</a>";
        $story['hits'] = $sarray[$i]->counter();
        // The line below can be used to display a Permanent Link image
        // $story['title'] .= "&nbsp;&nbsp;<a href='".XOOPS_URL."/modules/news/article.php?storyid=".$sarray[$i]->storyid()."'><img src='".XOOPS_URL."/modules/news/images/x.gif' alt='Permanent Link' /></a>";

        $xoopsTpl->append('xhelp_announcements', $story);
        $xoopsTpl->assign('xhelp_useAnnouncements', true);
        unset($story);
    }
}

function getDepartmentName($dept)
{
    //BTW - I don't like that we rely on the global $depts variable to exist.
    // What if we moved this into the DepartmentsHandler class?
    global $depts;
    if (isset($depts[$dept])) { // Make sure that ticket has a department
        $department = $depts[$dept]->getVar('department');
    } else { // Else, fill it with 0
        $department = _XHELP_TEXT_NO_DEPT;
    }
    return $department;
}

function _cleanTickets($tickets)
{
    $t_tickets = explode(',', $tickets);
    $ret = array();
    foreach ($t_tickets as $ticket) {
        $ticket = intval($ticket);
        if ($ticket) {
            $ret[] = $ticket;
        }
    }
    unset($t_tickets);
    return $ret;
}

function staffmain_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin;
    global $limit, $start, $refresh, $displayName, $xhelp_isStaff, $_xhelpSession, $_eventsrv, $xhelp_module_header, $aSavedSearches;

    if (!$xhelp_isStaff) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _NOPERM);
    }

    $xhelpConfig = xhelpGetModuleConfig();
    //Get Saved Searches for Current User + Searches for every user
    $allSavedSearches =& xhelpGetSavedSearches(array($xoopsUser->getVar('uid'), XHELP_GLOBAL_UID));

    $hDepartments =& xhelpGetHandler('department');
    $hTickets =& xhelpGetHandler('ticket');
    $hTicketList =& xhelpGetHandler('ticketList');

    //Set Number of items in each section
    if ($limit == 0) {
        $limit = $xhelpConfig['xhelp_staffTicketCount'];
    } elseif ($limit == -1) {
        $limit = 0;
    }
    $uid = $xoopsUser->getVar('uid');
    $depts =& $hDepartments->getObjects(null, true);
    $priority =& $hTickets->getStaffTickets($uid, XHELP_QRY_STAFF_HIGHPRIORITY, $start, $limit);
    $ticketLists =& $hTicketList->getListsByUser($uid);
    $all_users = array();

    $tickets = array();
    $i = 0;
    foreach ($ticketLists as $ticketList) {
        $searchid = $ticketList->getVar('searchid');
        $crit = $allSavedSearches[$searchid]['search'];
        $searchname = $allSavedSearches[$searchid]['name'];
        $searchOnCustFields = $allSavedSearches[$searchid]['hasCustFields'];
        $crit->setLimit($limit);
        $newTickets = $hTickets->getObjectsByStaff($crit, false, $searchOnCustFields);
        $tickets[$i] = array();
        $tickets[$i]['tickets'] = array();
        $tickets[$i]['searchid'] = $searchid;
        $tickets[$i]['searchname'] = $searchname;
        $tickets[$i]['tableid'] = _safeHTMLId($searchname);
        $tickets[$i]['hasTickets'] = count($newTickets) > 0;
        $j = 0;
        foreach ($newTickets as $ticket) {
            $dept = @$depts[$ticket->getVar('department')];
            $tickets[$i]['tickets'][$j] = array('id' => $ticket->getVar('id'),
                                                'uid' => $ticket->getVar('uid'),
                                                'subject' => xoops_substr($ticket->getVar('subject'), 0, 35),
                                                'full_subject' => $ticket->getVar('subject'),
                                                'description' => $ticket->getVar('description'),
                                                'department' => _safeDepartmentName($dept),
                                                'departmentid' => $ticket->getVar('department'),
                                                'departmenturl' => xhelpMakeURI('index.php', array('op' => 'staffViewAll', 'dept' => $ticket->getVar('department'))),
                                                'priority' => $ticket->getVar('priority'),
                                                'status' => xhelpGetStatus($ticket->getVar('status')),
                                                'posted' => $ticket->posted(),
                                                'ownership' => _XHELP_MESSAGE_NOOWNER,
                                                'ownerid' => $ticket->getVar('ownership'),
                                                'closedBy' => $ticket->getVar('closedBy'),
                                                'totalTimeSpent' => $ticket->getVar('totalTimeSpent'),
                                                'uname' => '',
                                                'userinfo' => XHELP_SITE_URL . '/userinfo.php?uid=' . $ticket->getVar('uid'),
                                                'ownerinfo' => '',
                                                'url' => XHELP_BASE_URL . '/ticket.php?id=' . $ticket->getVar('id'),
                                                'overdue' => $ticket->isOverdue());
            $all_users[$ticket->getVar('uid')] = '';
            $all_users[$ticket->getVar('ownership')] = '';
            $all_users[$ticket->getVar('closedBy')] = '';
            $j++;
        }
        $i++;
        unset($newTickets);
    }

    //Retrieve all member information for the current page
    if (count($all_users)) {
        $crit = new Criteria('uid', "(" . implode(array_keys($all_users), ',') . ")", 'IN');
        $users =& xhelpGetUsers($crit, $displayName);
    } else {
        $users = array();
    }

    //Update tickets with user information
    for ($i = 0; $i < count($ticketLists); $i++) {
        for ($j = 0; $j < count($tickets[$i]['tickets']); $j++) {
            if (isset($users[$tickets[$i]['tickets'][$j]['uid']])) {
                $tickets[$i]['tickets'][$j]['uname'] = $users[$tickets[$i]['tickets'][$j]['uid']];
            } else {
                $tickets[$i]['tickets'][$j]['uname'] = $xoopsConfig['anonymous'];
            }
            if ($tickets[$i]['tickets'][$j]['ownerid']) {
                if (isset($users[$tickets[$i]['tickets'][$j]['ownerid']])) {
                    $tickets[$i]['tickets'][$j]['ownership'] = $users[$tickets[$i]['tickets'][$j]['ownerid']];
                    $tickets[$i]['tickets'][$j]['ownerinfo'] = XOOPS_URL . '/userinfo.php?uid=' . $tickets[$i]['tickets'][$j]['ownerid'];
                }
            }
        }
    }

    $xoopsOption['template_main'] = 'xhelp_staff_index.html'; // Set template
    require(XOOPS_ROOT_PATH . '/header.php'); // Include the page header
    if ($refresh > 0) {
        $xhelp_module_header .= "<meta http-equiv=\"Refresh\" content=\"$refresh;url=" . XOOPS_URL . "/modules/xhelp/index.php?refresh=$refresh\">";
    }
    $xoopsTpl->assign('xhelp_baseURL', XHELP_BASE_URL);
    $xoopsTpl->assign('xhelp_ticketLists', $tickets);
    $xoopsTpl->assign('xhelp_hasTicketLists', count($tickets) > 0);
    $xoopsTpl->assign('xhelp_refresh', $refresh);
    $xoopsTpl->assign('xoops_module_header', $xhelp_module_header);
    $xoopsTpl->assign('xhelp_imagePath', XHELP_IMAGE_URL . '/');
    $xoopsTpl->assign('xhelp_uid', $xoopsUser->getVar('uid'));
    $xoopsTpl->assign('xhelp_current_file', basename(__FILE__));
    $xoopsTpl->assign('xhelp_savedSearches', $aSavedSearches);
    $xoopsTpl->assign('xhelp_allSavedSearches', $allSavedSearches);

    getAnnouncements($xhelpConfig['xhelp_announcements']);

    require(XOOPS_ROOT_PATH . '/footer.php');
}

function _safeHTMLId($orig_text)
{
    //Only allow alphanumeric characters
    $match = array('/[^a-zA-Z0-9]]/', '/\s/');
    $replace = array('', '');

    $htmlID = preg_replace($match, $replace, $orig_text);

    return $htmlID;
}

function _safeDepartmentName($deptObj)
{
    if (is_object($deptObj)) {
        $department = $deptObj->getVar('department');
    } else { // Else, fill it with 0
        $department = _XHELP_TEXT_NO_DEPT;
    }
    return $department;
}

function staffviewall_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin;
    global $xhelp_isStaff, $sort_order, $start, $limit, $xhelp_module_header, $state_opt, $aSavedSearches;
    if (!$xhelp_isStaff) {
        redirect_header(XHELP_BASE_URL . "/" . basename(__FILE__), 3, _NOPERM);
    }

    //Sanity Check: sort / order column valid
    $sort = @$_REQUEST['sort'];
    $order = @$_REQUEST['order'];

    $sort_columns = array('id' => 'DESC', 'priority' => 'DESC', 'elapsed' => 'ASC', 'lastupdate' => 'ASC', 'status' => 'ASC', 'subject' => 'ASC', 'department' => 'ASC', 'ownership' => 'ASC', 'uid' => 'ASC');
    $sort = array_key_exists(strtolower($sort), $sort_columns) ? $sort : 'id';
    $order = (in_array(strtoupper($order), $sort_order) ? $order : $sort_columns[$sort]);

    $uid = $xoopsUser->getVar('uid');
    $dept = intval(isset($_REQUEST['dept']) ? $_REQUEST['dept'] : 0);
    $status = intval(isset($_REQUEST['status']) ? $_REQUEST['status'] : -1);
    $ownership = intval(isset($_REQUEST['ownership']) ? $_REQUEST['ownership'] : -1);
    $state = intval(isset($_REQUEST['state']) ? $_REQUEST['state'] : -1);

    $xhelpConfig =& xhelpGetModuleConfig();
    $hTickets =& xhelpGetHandler('ticket');
    $hMembership =& xhelpGetHandler('membership');

    if ($limit == 0) {
        $limit = $xhelpConfig['xhelp_staffTicketCount'];
    } elseif ($limit == -1) {
        $limit = 0;
    }

    //Prepare Database Query and Querystring
    $crit = new CriteriaCompo(new Criteria('uid', $uid, '=', 'j'));
    $qs = array('op' => 'staffViewAll', //Common Query String Values
                'start' => $start,
                'limit' => $limit);

    if ($dept) {
        $qs['dept'] = $dept;
        $crit->add(new Criteria('department', $dept, '=', 't'));
    }
    if ($status != -1) {
        $qs['status'] = $status;
        $crit->add(new Criteria('status', $status, '=', 't'));
    }
    if ($ownership != -1) {
        $qs['ownership'] = $ownership;
        $crit->add(new Criteria('ownership', $ownership, '=', 't'));
    }

    if ($state != -1) {
        $qs['state'] = $state;
        $crit->add(new Criteria('state', $state, '=', 's'));
    }

    $crit->setLimit($limit);
    $crit->setStart($start);
    $crit->setSort($sort);
    $crit->setOrder($order);

    //Setup Column Sorting Vars
    $tpl_cols = array();
    foreach ($sort_columns as $col => $initsort) {
        $col_qs = array('sort' => $col);
        //Check if we need to sort by current column
        if ($sort == $col) {
            $col_qs['order'] = ($order == $sort_order[0] ? $sort_order[1] : $sort_order[0]);
            $col_sortby = true;
        } else {
            $col_qs['order'] = $initsort;
            $col_sortby = false;
        }
        $tpl_cols[$col] = array('url' => xhelpMakeURI(basename(__FILE__), array_merge($qs, $col_qs)),
                                'urltitle' => _XHELP_TEXT_SORT_TICKETS,
                                'sortby' => $col_sortby,
                                'sortdir' => strtolower($col_qs['order']));
    }


    $allTickets = $hTickets->getObjectsByStaff($crit, true);
    $count = $hTickets->getCountByStaff($crit);
    $nav = new XoopsPageNav($count, $limit, $start, 'start', "op=staffViewAll&amp;limit=$limit&amp;sort=$sort&amp;order=$order&amp;dept=$dept&amp;status=$status&amp;ownership=$ownership");
    $tickets = array();
    $allUsers = array();
    $depts =& $hMembership->membershipByStaff($xoopsUser->getVar('uid'), true); //All Departments for Staff Member

    foreach ($allTickets as $ticket) {
        $deptid = $ticket->getVar('department');
        $tickets[] = array('id' => $ticket->getVar('id'),
                           'uid' => $ticket->getVar('uid'),
                           'subject' => xoops_substr($ticket->getVar('subject'), 0, 35),
                           'full_subject' => $ticket->getVar('subject'),
                           'description' => $ticket->getVar('description'),
                           'department' => _safeDepartmentName($depts[$deptid]),
                           'departmentid' => $deptid,
                           'departmenturl' => xhelpMakeURI('index.php', array('op' => 'staffViewAll', 'dept' => $deptid)),
                           'priority' => $ticket->getVar('priority'),
                           'status' => xhelpGetStatus($ticket->getVar('status')),
                           'posted' => $ticket->posted(),
                           'ownership' => _XHELP_MESSAGE_NOOWNER,
                           'ownerid' => $ticket->getVar('ownership'),
                           'closedBy' => $ticket->getVar('closedBy'),
                           'closedByUname' => '',
                           'totalTimeSpent' => $ticket->getVar('totalTimeSpent'),
                           'uname' => '',
                           'userinfo' => XHELP_SITE_URL . '/userinfo.php?uid=' . $ticket->getVar('uid'),
                           'ownerinfo' => '',
                           'url' => XHELP_BASE_URL . '/ticket.php?id=' . $ticket->getVar('id'),
                           'elapsed' => $ticket->elapsed(),
                           'lastUpdate' => $ticket->lastUpdate(),
                           'overdue' => $ticket->isOverdue());
        $allUsers[$ticket->getVar('uid')] = '';
        $allUsers[$ticket->getVar('ownership')] = '';
        $allUsers[$ticket->getVar('closedBy')] = '';
    }
    $has_allTickets = count($allTickets) > 0;
    unset($allTickets);

    //Get all member information needed on this page
    $crit = new Criteria('uid', "(" . implode(array_keys($allUsers), ',') . ")", 'IN');
    $users =& xhelpGetUsers($crit, $xhelpConfig['xhelp_displayName']);
    unset($allUsers);

    $staff_opt =& xhelpGetStaff($xhelpConfig['xhelp_displayName']);

    for ($i = 0; $i < count($tickets); $i++) {
        if (isset($users[$tickets[$i]['uid']])) {
            $tickets[$i]['uname'] = $users[$tickets[$i]['uid']];
        } else {
            $tickets[$i]['uname'] = $xoopsConfig['anonymous'];
        }
        if ($tickets[$i]['ownerid']) {
            if (isset($users[$tickets[$i]['ownerid']])) {
                $tickets[$i]['ownership'] = $users[$tickets[$i]['ownerid']];
                $tickets[$i]['ownerinfo'] = XHELP_SITE_URL . '/userinfo.php?uid=' . $tickets[$i]['ownerid'];
            }
        }
        if ($tickets[$i]['closedBy']) {
            if (isset($users[$tickets[$i]['closedBy']])) {
                $tickets[$i]['closedByUname'] = $users[$tickets[$i]['closedBy']];
            }
        }
    }

    $xoopsOption['template_main'] = 'xhelp_staff_viewall.html'; // Set template
    require(XOOPS_ROOT_PATH . '/header.php'); // Include the page header

    $javascript = "<script type=\"text/javascript\" src=\"" . XHELP_BASE_URL . "/include/functions.js\"></script>
<script type=\"text/javascript\" src='" . XHELP_SCRIPT_URL . "/changeSelectedState.php?client'></script>
<script type=\"text/javascript\">
<!--
function states_onchange()
{
    state = xoopsGetElementById('state');
    var sH = new xhelpweblib(stateHandler);
    sH.statusesbystate(state.value);
}

var stateHandler = {
    statusesbystate: function(result){
        var statuses = gE('status');
        xhelpFillSelect(statuses, result);
    }
}

function window_onload()
{
    xhelpDOMAddEvent(xoopsGetElementById('state'), 'change', states_onchange, true);
}

window.setTimeout('window_onload()', 1500);
//-->
</script>";

    $xoopsTpl->assign('xhelp_baseURL', XHELP_BASE_URL);
    $xoopsTpl->assign('xhelp_imagePath', XHELP_IMAGE_URL . '/');
    $xoopsTpl->assign('xhelp_cols', $tpl_cols);
    $xoopsTpl->assign('xhelp_allTickets', $tickets);
    $xoopsTpl->assign('xhelp_has_tickets', $has_allTickets);
    $xoopsTpl->assign('xhelp_priorities', array(5, 4, 3, 2, 1));
    $xoopsTpl->assign('xoops_module_header', $javascript . $xhelp_module_header);
    $xoopsTpl->assign('xhelp_priorities_desc', array('5' => _XHELP_PRIORITY5, '4' => _XHELP_PRIORITY4, '3' => _XHELP_PRIORITY3, '2' => _XHELP_PRIORITY2, '1' => _XHELP_PRIORITY1));
    if ($limit != 0) {
        $xoopsTpl->assign('xhelp_pagenav', $nav->renderNav());
    }
    $xoopsTpl->assign('xhelp_limit_options', array(-1 => _XHELP_TEXT_SELECT_ALL, 10 => '10', 15 => '15', 20 => '20', 30 => '30'));
    $xoopsTpl->assign('xhelp_filter', array('department' => $dept,
                                            'status' => $status,
                                            'state' => $state,
                                            'ownership' => $ownership,
                                            'limit' => $limit,
                                            'start' => $start,
                                            'sort' => $sort,
                                            'order' => $order));

    $xoopsTpl->append('xhelp_department_values', 0);
    $xoopsTpl->append('xhelp_department_options', _XHELP_TEXT_SELECT_ALL);

    if ($xhelpConfig['xhelp_deptVisibility'] == 1) { // Apply dept visibility to staff members?
        $hMembership =& xhelpGetHandler('membership');
        $depts =& $hMembership->getVisibleDepartments($xoopsUser->getVar('uid'));
    }

    foreach ($depts as $xhelp_id => $obj) {
        $xoopsTpl->append('xhelp_department_values', $xhelp_id);
        $xoopsTpl->append('xhelp_department_options', $obj->getVar('department'));
    }

    $xoopsTpl->assign('xhelp_ownership_options', array_values($staff_opt));
    $xoopsTpl->assign('xhelp_ownership_values', array_keys($staff_opt));
    $xoopsTpl->assign('xhelp_state_options', array_keys($state_opt));
    $xoopsTpl->assign('xhelp_state_values', array_values($state_opt));
    $xoopsTpl->assign('xhelp_savedSearches', $aSavedSearches);

    $hStatus =& xhelpGetHandler('status');
    $crit = new Criteria('', '');
    $crit->setSort('description');
    $crit->setOrder('ASC');
    $statuses =& $hStatus->getObjects($crit);

    $xoopsTpl->append('xhelp_status_options', _XHELP_TEXT_SELECT_ALL);
    $xoopsTpl->append('xhelp_status_values', -1);
    foreach ($statuses as $status) {
        $xoopsTpl->append('xhelp_status_options', $status->getVar('description'));
        $xoopsTpl->append('xhelp_status_values', $status->getVar('id'));
    }

    $xoopsTpl->assign('xhelp_department_current', $dept);
    $xoopsTpl->assign('xhelp_status_current', $status);
    $xoopsTpl->assign('xhelp_current_file', basename(__FILE__));
    $xoopsTpl->assign('xhelp_text_allTickets', _XHELP_TEXT_ALL_TICKETS);

    require(XOOPS_ROOT_PATH . '/footer.php');
}

function usermain_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin;
    global $xhelp_module_header;

    $xoopsOption['template_main'] = 'xhelp_user_index.html'; // Set template
    require(XOOPS_ROOT_PATH . '/header.php'); // Include the page header

    $xhelpConfig = xhelpGetModuleConfig();
    $hStaff =& xhelpGetHandler('staff');

    $staffCount =& $hStaff->getObjects();
    if (count($staffCount) == 0) {
        $xoopsTpl->assign('xhelp_noStaff', true);
    }
    /**
     * @todo remove calls to these three classes and use the ones in beginning
     */
    $member_handler =& xoops_gethandler('member');
    $hDepartments =& xhelpGetHandler('department');
    $hTickets =& xhelpGetHandler('ticket');

    $userTickets =& $hTickets->getMyUnresolvedTickets($xoopsUser->getVar('uid'), true);

    foreach ($userTickets as $ticket) {
        $aUserTickets[] = array('id' => $ticket->getVar('id'),
                                'uid' => $ticket->getVar('uid'),
                                'subject' => $ticket->getVar('subject'),
                                'status' => xhelpGetStatus($ticket->getVar('status')),
                                'priority' => $ticket->getVar('priority'),
                                'posted' => $ticket->posted());
    }
    $has_userTickets = count($userTickets) > 0;
    if ($has_userTickets) {
        $xoopsTpl->assign('xhelp_userTickets', $aUserTickets);
    } else {
        $xoopsTpl->assign('xhelp_userTickets', 0);
    }
    $xoopsTpl->assign('xhelp_baseURL', XHELP_BASE_URL);
    $xoopsTpl->assign('xhelp_has_userTickets', $has_userTickets);
    $xoopsTpl->assign('xhelp_priorities', array(5, 4, 3, 2, 1));
    $xoopsTpl->assign('xhelp_priorities_desc', array('5' => _XHELP_PRIORITY5, '4' => _XHELP_PRIORITY4, '3' => _XHELP_PRIORITY3, '2' => _XHELP_PRIORITY2, '1' => _XHELP_PRIORITY1));
    $xoopsTpl->assign('xhelp_imagePath', XHELP_IMAGE_URL . '/');
    $xoopsTpl->assign('xoops_module_header', $xhelp_module_header);

    getAnnouncements($xhelpConfig['xhelp_announcements']);

    require(XOOPS_ROOT_PATH . '/footer.php'); //Include the page footer
}

function userviewall_display()
{
    global $xoopsOption, $xoopsTpl, $xoopsConfig, $xoopsUser, $xoopsLogger, $xoopsUserIsAdmin;
    global $xhelp_module_header, $sort, $order, $sort_order, $limit, $start, $state_opt, $state;

    $xoopsOption['template_main'] = 'xhelp_user_viewall.html'; // Set template
    require(XOOPS_ROOT_PATH . '/header.php'); // Include the page header

    //Sanity Check: sort column valid
    $sort_columns = array('id' => 'DESC', 'priority' => 'DESC', 'elapsed' => 'ASC', 'lastupdate' => 'ASC', 'status' => 'ASC', 'subject' => 'ASC', 'department' => 'ASC', 'ownership' => 'ASC', 'uid' => 'ASC');
    $sort = array_key_exists($sort, $sort_columns) ? $sort : 'id';
    $order = @$_REQUEST['order'];
    $order = (in_array(strtoupper($order), $sort_order) ? $order : $sort_columns[$sort]);
    $uid = $xoopsUser->getVar('uid');

    $hDepartments =& xhelpGetHandler('department');
    $hTickets =& xhelpGetHandler('ticket');
    $hStaff =& xhelpGetHandler('staff');

    $dept = intval(isset($_REQUEST['dept']) ? $_REQUEST['dept'] : 0);
    $status = intval(isset($_REQUEST['status']) ? $_REQUEST['status'] : -1);
    $state = intval(isset($_REQUEST['state']) ? $_REQUEST['state'] : -1);
    $depts =& $hDepartments->getObjects(null, true);

    if ($limit == 0) {
        $limit = 10;
    } elseif ($limit == -1) {
        $limit = 0;
    }

    //Prepare Database Query and Querystring
    $crit = new CriteriaCompo(new Criteria ('uid', $uid));
    $qs = array('op' => 'userViewAll', //Common Query String Values
                'start' => $start,
                'limit' => $limit);

    if ($dept) {
        $qs['dept'] = $dept;
        $crit->add(new Criteria('department', $dept, '=', 't'));
    }
    if ($status != -1) {
        $qs['status'] = $status;
        $crit->add(new Criteria('status', $status, '=', 't'));
    }

    if ($state != -1) {
        $qs['state'] = $state;
        $crit->add(new Criteria('state', $state, '=', 's'));
    }

    $crit->setLimit($limit);
    $crit->setStart($start);
    $crit->setSort($sort);
    $crit->setOrder($order);

    //Setup Column Sorting Vars
    $tpl_cols = array();
    foreach ($sort_columns as $col => $initsort) {
        $col_qs = array('sort' => $col);
        //Check if we need to sort by current column
        if ($sort == $col) {
            $col_qs['order'] = ($order == $sort_order[0] ? $sort_order[1] : $sort_order[0]);
            $col_sortby = true;
        } else {
            $col_qs['order'] = $initsort;
            $col_sortby = false;
        }
        $tpl_cols[$col] = array('url' => xhelpMakeURI(basename(__FILE__), array_merge($qs, $col_qs)),
                                'urltitle' => _XHELP_TEXT_SORT_TICKETS,
                                'sortby' => $col_sortby,
                                'sortdir' => strtolower($col_qs['order']));
    }

    $xoopsTpl->assign('xhelp_cols', $tpl_cols);
    $staffCount =& $hStaff->getObjects();
    if (count($staffCount) == 0) {
        $xoopsTpl->assign('xhelp_noStaff', true);
    }

    $userTickets =& $hTickets->getObjects($crit);
    foreach ($userTickets as $ticket) {
        $aUserTickets[] = array('id' => $ticket->getVar('id'),
                                'uid' => $ticket->getVar('uid'),
                                'subject' => xoops_substr($ticket->getVar('subject'), 0, 35),
                                'full_subject' => $ticket->getVar('subject'),
                                'status' => xhelpGetStatus($ticket->getVar('status')),
                                'department' => _safeDepartmentName($depts[$ticket->getVar('department')]),
                                'departmentid' => $ticket->getVar('department'),
                                'departmenturl' => xhelpMakeURI(basename(__FILE__), array('op' => 'userViewAll', 'dept' => $ticket->getVar('department'))),
                                'priority' => $ticket->getVar('priority'),
                                'posted' => $ticket->posted(),
                                'elapsed' => $ticket->elapsed());
    }
    $has_userTickets = count($userTickets) > 0;
    if ($has_userTickets) {
        $xoopsTpl->assign('xhelp_userTickets', $aUserTickets);
    } else {
        $xoopsTpl->assign('xhelp_userTickets', 0);
    }

    $javascript = "<script type=\"text/javascript\" src=\"" . XHELP_BASE_URL . "/include/functions.js\"></script>
<script type=\"text/javascript\" src='" . XHELP_SCRIPT_URL . "/changeSelectedState.php?client'></script>
<script type=\"text/javascript\">
<!--
function states_onchange()
{
    state = xoopsGetElementById('state');
    var sH = new xhelpweblib(stateHandler);
    sH.statusesbystate(state.value);
}

var stateHandler = {
    statusesbystate: function(result){
        var statuses = gE('status');
        xhelpFillSelect(statuses, result);
    }
}

function window_onload()
{
    xhelpDOMAddEvent(xoopsGetElementById('state'), 'change', states_onchange, true);
}

window.setTimeout('window_onload()', 1500);
//-->
</script>";

    $xoopsTpl->assign('xhelp_baseURL', XHELP_BASE_URL);
    $xoopsTpl->assign('xhelp_has_userTickets', $has_userTickets);
    $xoopsTpl->assign('xhelp_viewAll', true);
    $xoopsTpl->assign('xhelp_priorities', array(5, 4, 3, 2, 1));
    $xoopsTpl->assign('xhelp_priorities_desc', array('5' => _XHELP_PRIORITY5, '4' => _XHELP_PRIORITY4, '3' => _XHELP_PRIORITY3, '2' => _XHELP_PRIORITY2, '1' => _XHELP_PRIORITY1));
    $xoopsTpl->assign('xhelp_imagePath', XHELP_IMAGE_URL . '/');
    $xoopsTpl->assign('xoops_module_header', $javascript . $xhelp_module_header);
    $xoopsTpl->assign('xhelp_limit_options', array(-1 => _XHELP_TEXT_SELECT_ALL, 10 => '10', 15 => '15', 20 => '20', 30 => '30'));
    $xoopsTpl->assign('xhelp_filter', array('department' => $dept,
                                            'status' => $status,
                                            'limit' => $limit,
                                            'start' => $start,
                                            'sort' => $sort,
                                            'order' => $order,
                                            'state' => $state));
    $xoopsTpl->append('xhelp_department_values', 0);
    $xoopsTpl->append('xhelp_department_options', _XHELP_TEXT_SELECT_ALL);

    //$depts = getVisibleDepartments($depts);
    $hMembership =& xhelpGetHandler('membership');
    $depts =& $hMembership->getVisibleDepartments($xoopsUser->getVar('uid'));
    foreach ($depts as $xhelp_id => $obj) {
        $xoopsTpl->append('xhelp_department_values', $xhelp_id);
        $xoopsTpl->append('xhelp_department_options', $obj->getVar('department'));
    }

    $hStatus =& xhelpGetHandler('status');
    $crit = new Criteria('', '');
    $crit->setSort('description');
    $crit->setOrder('ASC');
    $statuses =& $hStatus->getObjects($crit);

    $xoopsTpl->append('xhelp_status_options', _XHELP_TEXT_SELECT_ALL);
    $xoopsTpl->append('xhelp_status_values', -1);
    foreach ($statuses as $status) {
        $xoopsTpl->append('xhelp_status_options', $status->getVar('description'));
        $xoopsTpl->append('xhelp_status_values', $status->getVar('id'));
    }

    $xoopsTpl->assign('xhelp_department_current', $dept);
    $xoopsTpl->assign('xhelp_status_current', $status);
    $xoopsTpl->assign('xhelp_state_options', array_keys($state_opt));
    $xoopsTpl->assign('xhelp_state_values', array_values($state_opt));

    require(XOOPS_ROOT_PATH . '/footer.php');
}

function _makeBatchTicketArray(&$oTickets, &$depts, &$all_users, &$j, $task)
{
    global $xhelp_staff;

    $sortedTickets['good'] = array();
    $sortedTickets['bad'] = array();
    foreach ($oTickets as $ticket) {
        $dept = @$depts[$ticket->getVar('department')];
        if (!$hasRights = $xhelp_staff->checkRoleRights($task, $ticket->getVar('department'))) {
            $sortedTickets['bad'][] = array(
                'id' => $ticket->getVar('id'),
                'uid' => $ticket->getVar('uid'),
                'subject' => xoops_substr($ticket->getVar('subject'), 0, 35),
                'full_subject' => $ticket->getVar('subject'),
                'description' => $ticket->getVar('description'),
                'department' => _safeDepartmentName($dept),
                'departmentid' => $ticket->getVar('department'),
                'departmenturl' => xhelpMakeURI('index.php', array('op' => 'staffViewAll', 'dept' => $ticket->getVar('department'))),
                'priority' => $ticket->getVar('priority'),
                'status' => xhelpGetStatus($ticket->getVar('status')),
                'posted' => $ticket->posted(),
                'ownership' => _XHELP_MESSAGE_NOOWNER,
                'ownerid' => $ticket->getVar('ownership'),
                'closedBy' => $ticket->getVar('closedBy'),
                'totalTimeSpent' => $ticket->getVar('totalTimeSpent'),
                'uname' => '',
                'userinfo' => XHELP_SITE_URL . '/userinfo.php?uid=' . $ticket->getVar('uid'),
                'ownerinfo' => '',
                'url' => XHELP_BASE_URL . '/ticket.php?id=' . $ticket->getVar('id'),
                'overdue' => $ticket->isOverdue());
        } else {
            $sortedTickets['good'][] = array(
                'id' => $ticket->getVar('id'),
                'uid' => $ticket->getVar('uid'),
                'subject' => xoops_substr($ticket->getVar('subject'), 0, 35),
                'full_subject' => $ticket->getVar('subject'),
                'description' => $ticket->getVar('description'),
                'department' => _safeDepartmentName($dept),
                'departmentid' => $ticket->getVar('department'),
                'departmenturl' => xhelpMakeURI('index.php', array('op' => 'staffViewAll', 'dept' => $ticket->getVar('department'))),
                'priority' => $ticket->getVar('priority'),
                'status' => xhelpGetStatus($ticket->getVar('status')),
                'posted' => $ticket->posted(),
                'ownership' => _XHELP_MESSAGE_NOOWNER,
                'ownerid' => $ticket->getVar('ownership'),
                'closedBy' => $ticket->getVar('closedBy'),
                'totalTimeSpent' => $ticket->getVar('totalTimeSpent'),
                'uname' => '',
                'userinfo' => XHELP_SITE_URL . '/userinfo.php?uid=' . $ticket->getVar('uid'),
                'ownerinfo' => '',
                'url' => XHELP_BASE_URL . '/ticket.php?id=' . $ticket->getVar('id'),
                'overdue' => $ticket->isOverdue());
        }
        $all_users[$ticket->getVar('uid')] = '';
        $all_users[$ticket->getVar('ownership')] = '';
        $all_users[$ticket->getVar('closedBy')] = '';
        $j++;
    }
    return $sortedTickets;
}

function _updateBatchTicketInfo(&$sortedTickets, &$users, &$j)
{
    global $xoopsConfig;

    //Update tickets with user information
    $aTicketTypes = array('good', 'bad');
    foreach ($aTicketTypes as $ticketType) {
        for ($j = 0; $j < count($sortedTickets[$ticketType]); $j++) {
            if (isset($users[$sortedTickets[$ticketType][$j]['uid']])) {
                $sortedTickets[$ticketType][$j]['uname'] = $users[$sortedTickets[$ticketType][$j]['uid']];
            } else {
                $sortedTickets[$ticketType][$j]['uname'] = $xoopsConfig['anonymous'];
            }
            if ($sortedTickets[$ticketType][$j]['ownerid']) {
                if (isset($users[$sortedTickets[$ticketType][$j]['ownerid']])) {
                    $sortedTickets[$ticketType][$j]['ownership'] = $users[$sortedTickets[$ticketType][$j]['ownerid']];
                    $sortedTickets[$ticketType][$j]['ownerinfo'] = XOOPS_URL . '/userinfo.php?uid=' . $sortedTickets[$ticketType][$j]['ownerid'];
                }
            }
        }
    }
    return $sortedTickets;
}

?>