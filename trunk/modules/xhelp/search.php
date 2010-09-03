<?php
//$Id: search.php,v 1.51 2005/11/29 17:52:26 ackbarr Exp $
require_once('header.php');
include_once(XOOPS_ROOT_PATH . '/class/pagenav.php');
$hStaff =& xhelpGetHandler('staff');
$hDepartments =& xhelpGetHandler('department');
$hTickets =& xhelpGetHandler('ticket');
$hSavedSearch =& xhelpGetHandler('savedSearch');
$hFields =& xhelpGetHandler('ticketField');

if (!$xoopsUser) {
    redirect_header(XOOPS_URL, 3, _NOPERM);
}

if (!$hStaff->isStaff($xoopsUser->getVar('uid'))) {
    redirect_header(XHELP_BASE_URL . "/index.php", 3, _NOPERM);
}


if ($xoopsUser) {
    $start = $limit = 0;
    $page_vars = array('limit', 'start', 'sort', 'order');
    $sort_order = array('ASC', 'DESC');
    $sort = '';
    $order = '';
    $displayName =& $xoopsModuleConfig['xhelp_displayName']; // Determines if username or real name is displayed
    $returnPage = false;
    $aReturnPages = array('profile');
    if (isset($_GET['return']) && in_array($_GET['return'], $aReturnPages)) {
        $returnPage = $_GET['return'];
    }

    foreach ($page_vars as $var) {
        if (isset($_REQUEST[$var])) {
            $$var = $_REQUEST[$var];
        }
    }
    $limit = intval($limit);
    $start = intval($start);
    $sort = strtolower($sort);
    $order = (in_array(strtoupper($order), $sort_order) ? $order : 'ASC');
    $sort_columns = array('id', 'priority', 'elapsed', 'lastupdate', 'status', 'subject', 'department', 'ownership', 'uid');
    $sort = (in_array($sort, $sort_columns) ? $sort : '');
    $hasCustFields = false;

    // Make sure start is greater than 0
    $start = max($start, 0);

    // Make sure limit is set
    if (!$limit) {
        $limit = $xoopsModuleConfig['xhelp_staffTicketCount'];
    }

    $pagenav_vars = "limit=$limit";
    $uid = $xoopsUser->getVar('uid');

    $viewResults = false;
    $op = "default";
    if (isset($_REQUEST['op'])) {
        $op = $_REQUEST['op'];
    }

    switch ($op) {
        case "edit":
            if (isset($_REQUEST['id']) && $_REQUEST['id'] != 0) {
                $searchid = intval($_REQUEST['id']);
                if (!array_key_exists($searchid, $aSavedSearches)) {
                    if ($returnPage != false) {
                        redirect_header(XHELP_BASE_URL . "/" . $returnPage . ".php", 3, _XHELP_MSG_NO_EDIT_SEARCH);
                    } else {
                        redirect_header(XHELP_BASE_URL . "/search.php", 3, _XHELP_MSG_NO_EDIT_SEARCH);
                    }
                }

            } else {
                if ($returnPage != false) {
                    redirect_header(XHELP_BASE_URL . "/" . $returnPage . ".php", 3, _XHELP_MSG_NO_ID);
                } else {
                    redirect_header(XHELP_BASE_URL . "/search.php", 3, _XHELP_MSG_NO_ID);
                }
            }
            $xoopsOption['template_main'] = 'xhelp_editSearch.html'; // Set template
            require(XOOPS_ROOT_PATH . '/header.php'); // Include the page header
            $mySearch =& $hSavedSearch->get($searchid);
            $xoopsTpl->assign('xhelp_baseURL', XHELP_BASE_URL);
            if (is_object($mySearch)) { // Go through saved search info, set values on page
                $vars = array('ticketid', 'department', 'description', 'subject', 'priority', 'status', 'state', 'uid', 'submittedBy', 'ownership', 'closedBy');
                $ticketid = '';
                $department = -1;
                $description = '';
                $subject = '';
                $priority = -1;
                $status = -1;
                $state = -1;
                $uid = '';
                $submittedBy = '';
                $ownership = '';
                $closedBy = '';

                $fields =& $hFields->getObjects();
                $aFields = array();
                $aFieldnames = array();
                foreach ($fields as $field) {
                    $vars[] = $field->getVar('fieldname');
                    ${$field->getVar('fieldname')} = '';
                    $values = $field->getVar('fieldvalues');
                    if ($field->getVar('controltype') == XHELP_CONTROL_YESNO) {
                        $values = (($values == 1) ? _YES : _NO);
                    }
                    $defaultValue = $field->getVar('defaultvalue');
                    $aFields[$field->getVar('id')] =
                            array('name' => $field->getVar('name'),
                                  'desc' => $field->getVar('description'),
                                  'fieldname' => $field->getVar('fieldname'),
                                  'defaultvalue' => $defaultValue,
                                  'controltype' => $field->getVar('controltype'),
                                  'required' => $field->getVar('required'),
                                  'fieldlength' => ($field->getVar('fieldlength') < 50 ? $field->getVar('fieldlength') : 50),
                                  'maxlength' => $field->getVar('fieldlength'),
                                  'weight' => $field->getVar('weight'),
                                  'fieldvalues' => $values,
                                  'validation' => $field->getVar('validation'));
                    $aFieldnames[$field->getVar('id')] = $field->getVar('fieldname');
                }
                unset($fields);

                $crit = unserialize($mySearch->getVar('search'));
                $pagenav_vars = $mySearch->getVar('pagenav_vars');
                $searchLimit = $crit->getLimit();
                $searchStart = $crit->getStart();
                $crit = get_object_vars($crit);
                $critElements = $crit['criteriaElements'];
                $hasSubmittedBy = false;
                foreach ($critElements as $critEle) {
                    $critEle = get_object_vars($critEle);
                    $colName = $critEle['column'];
                    if (in_array($colName, $vars)) {
                        switch ($colName) {
                            case "department":
                            case "status":
                                $eleValue = str_replace('(', '', $critEle['value']);
                                $eleValue = str_replace(')', '', $eleValue);
                                ${$colName} = $eleValue;
                                ${$colName} = split(",", ${$colName});
                                break;

                            case "uid":
                                if (!$hasSubmittedBy) {
                                    if ($submitted_string = strstr($pagenav_vars, 'submittedBy=')) {
                                        $end_string = strpos($submitted_string, '&');
                                        if ($submitted_string_sub = substr($submitted_string, 0, $end_string)) {
                                            $submitted_string = $submitted_string_sub;
                                        }
                                        $submitted_string = split('=', $submitted_string);
                                        $submitted_string = $submitted_string[1];
                                        $submittedBy = $xoopsUser->getUnameFromId(intval($submitted_string));
                                        $hasSubmittedBy = true;
                                    }
                                }
                                break;

                            default:
                                $eleValue = $critEle['value'];
                                $eleLength = strlen($eleValue);
                                $firstSpot = strpos($eleValue, '%');
                                $lastSpot = strrpos($eleValue, '%');
                                if ($firstSpot !== false && $lastSpot !== false) {
                                    $eleValue = substr($eleValue, 1, $eleLength - 2);
                                }
                                ${$colName} = $eleValue;
                                break;
                        }
                        $arr_key = array_search($colName, $aFieldnames);
                        if ($arr_key != false) {
                            $aFields[$arr_key]['defaultvalue'] = ${$colName};
                        }
                    }
                }
                foreach ($vars as $var) {
                    $xoopsTpl->assign('xhelp_search' . $var, $$var);
                }

                $xoopsTpl->assign('xhelp_custFields', $aFields);
                if (!empty($aFields)) {
                    $xoopsTpl->assign('xhelp_hasCustFields', true);
                } else {
                    $xoopsTpl->assign('xhelp_hasCustFields', false);
                }
                $_xhelpSession->set('xhelp_custFields', $aFields);
                $staff =& xhelpGetStaff($displayName);
                $xoopsTpl->assign('xhelp_staff', $staff);
                $hMember =& xhelpGetHandler('membership');
                if ($xoopsModuleConfig['xhelp_deptVisibility'] == 1) { // Apply dept visibility to staff members?
                    $depts =& $hMember->getVisibleDepartments($xoopsUser->getVar('uid'));
                } else {
                    $depts =& $hMember->membershipByStaff($xoopsUser->getVar('uid'));
                }
                foreach ($depts as $dept) {
                    $myDepts[$dept->getVar('id')] = $dept->getVar('department');
                }
                unset($depts);
                asort($myDepts);
                $myDepts[-1] = _XHELP_TEXT_SELECT_ALL;
                $xoopsTpl->assign('xhelp_depts', $myDepts);

                $hStatus =& xhelpGetHandler('status');
                $crit_stat = new Criteria('', '');
                $crit_stat->setSort('description');
                $crit_stat->setOrder('ASC');
                $statuses =& $hStatus->getObjects($crit_stat);
                $aStatuses = array();
                foreach ($statuses as $status) {
                    $aStatuses[$status->getVar('id')] = $status->getVar('description');
                }
                unset($statuses);
                $xoopsTpl->assign('xhelp_statuses', $aStatuses);
                $xoopsTpl->assign('xhelp_searchid', $mySearch->getVar('id'));
                $xoopsTpl->assign('xhelp_searchName', $mySearch->getVar('name'));
                $xoopsTpl->assign('xhelp_searchLimit', $searchLimit);
                $xoopsTpl->assign('xhelp_searchStart', $searchStart);
                $xoopsTpl->assign('xhelp_priorities', array(5, 4, 3, 2, 1));
                $xoopsTpl->assign('xhelp_priorities_desc', array('5' => _XHELP_PRIORITY5, '4' => _XHELP_PRIORITY4, '3' => _XHELP_PRIORITY3,
                                                                 '2' => _XHELP_PRIORITY2, '1' => _XHELP_PRIORITY1));
                $xoopsTpl->assign('xhelp_imagePath', XHELP_BASE_URL . '/images/');
                $xoopsTpl->assign('xhelp_returnPage', $returnPage);
            }

            break;

        case "editSave":

            break;

        case "search":
        default:
            $xoopsOption['template_main'] = 'xhelp_search.html'; // Set template
            require(XOOPS_ROOT_PATH . '/header.php'); // Include the page header

            $xoopsTpl->assign('xhelp_imagePath', XHELP_BASE_URL . '/images/');
            $xoopsTpl->assign('xhelp_uid', $uid);
            $xoopsTpl->assign('xhelp_returnPage', $returnPage);
            $xoopsTpl->assign('xhelp_baseURL', XHELP_BASE_URL);
            $viewResults = false;

            // If search submitted, or moving to another page of search results, or submitted a saved search
            if (isset($_POST['search']) || isset($_GET['start']) || isset($_REQUEST['savedSearch'])) {
                if (isset($_REQUEST['savedSearch']) && $_REQUEST['savedSearch'] != 0) { // If this is a saved search

                    if (!isset($_POST['delete_savedSearch'])) { // If not deleting saved search
                        $mySavedSearch =& $hSavedSearch->get($_REQUEST['savedSearch']);
                        $crit = unserialize($mySavedSearch->getVar('search')); // Set $crit object
                        $pagenav_vars = $mySavedSearch->getVar('pagenav_vars'); // set pagenav vars

                        if ($crit->getLimit() != 0) {
                            $limit = $crit->getLimit(); // Set limit
                        }
                        $start = $crit->getStart(); // Set start

                        if ($custFields =& $_xhelpSession->get("xhelp_custFields")) { // Custom fields
                            $hasCustFields = true;
                        }
                    } else { // If deleting saved search
                        $mySavedSearch =& $aSavedSearches[intval($_REQUEST['savedSearch'])]; // Retrieve saved search
                        if ($mySavedSearch['uid'] == XHELP_GLOBAL_UID) {
                            redirect_header(XHELP_BASE_URL . '/search.php', 3, _XHELP_MSG_NO_DEL_SEARCH);
                        }
                        $crit = new Criteria('id', $mySavedSearch['id']);
                        if ($hSavedSearch->deleteAll($crit)) {
                            $_xhelpSession->del('xhelp_savedSearches');
                            header("Location: " . XHELP_BASE_URL . "/search.php");
                        } else {
                            redirect_header(XHELP_BASE_URL . "/search.php", 3, _XHELP_MESSAGE_DELETE_SEARCH_ERR);
                        }
                    }
                } elseif (isset($_POST['search']) || isset($_GET['start'])) { // If this is a new search or next page in search results
                    $crit = new CriteriaCompo(new Criteria('uid', $xoopsUser->getVar('uid'), "=", "j"));
                    $vars = array('ticketid', 'department', 'description', 'subject', 'priority', 'status', 'state', 'submittedBy', 'ownership', 'closedBy');

                    if ($custFields =& $_xhelpSession->get("xhelp_custFields")) { // Custom fields
                        $hasCustFields = false;
                        foreach ($custFields as $field) {
                            $fieldname = $field['fieldname'];
                            if (isset($_REQUEST[$fieldname]) && $_REQUEST[$fieldname] != "" && $_REQUEST[$fieldname] <> -1) {
                                $hasCustFields = true;
                                $crit->add(new Criteria($fieldname, "%" . $_REQUEST[$fieldname] . "%", "LIKE", "f"));
                            }
                        }
                    }
                    // Finished with session var - delete it now
                    $_xhelpSession->del('xhelp_custFields');

                    foreach ($vars as $var) {
                        if (isset($_POST[$var])) {
                            $$var = $_POST[$var];
                        } elseif (isset($_GET[$var])) {
                            $$var = $_GET[$var];
                        }
                    }

                    if (isset($ticketid) && $ticketid = intval($ticketid)) {
                        $crit->add(new Criteria("id", $ticketid, "=", "t"));
                        $pagenav_vars .= "&amp;ticketid=$ticketid";
                    }

                    if (isset($department)) {
                        if (!in_array("-1", $department)) {
                            $department = array_filter($department);
                            $crit->add(new Criteria("department", "(" . implode($department, ',') . ")", "IN", "t"));
                            $pagenav_vars .= "&amp;department[]=" . implode($department, "&amp;department[]=");
                        }
                    }

                    if (isset($description) && ($description)) {
                        $crit->add(new Criteria("description", "%$description%", "LIKE", "t"));
                        $pagenav_vars .= "&amp;description=$description";
                    }

                    if (isset($subject) && ($subject)) {
                        $crit->add(new Criteria("subject", "%$subject%", "LIKE", "t"));
                        $pagenav_vars .= "&amp;subject=$subject";
                    }

                    if (isset($priority) && ($priority <> -1)) {
                        $priority = intval($priority);
                        $crit->add(new Criteria("priority", $priority, "=", "t"));
                        $pagenav_vars .= "&amp;priority=$priority";
                    }

                    if (isset($status)) {
                        if (is_array($status)) {
                            $status = array_filter($status);
                            $crit->add(new Criteria("status", "(" . implode($status, ',') . ")", "IN", "t"));
                            $pagenav_vars .= "&amp;status[]=" . implode($status, "&amp;status[]=");
                        } else {
                            $crit->add(new Criteria("status", intval($status), "=", "t"));
                            $pagenav_vars .= "&amp;status=$status";
                        }
                    } else { // Only evaluate if status is not set
                        if (isset($state) && $state != -1) {
                            $crit->add(new Criteria('state', intval($state), "=", "s"));
                            $pagenav_vars .= "&amp;state=$state";
                        }
                    }

                    if (isset($submittedBy) && ($submittedBy)) {
                        if (strlen($submittedBy) > 0) {
                            if (!is_numeric($submittedBy)) {
                                $hMember =& xoops_gethandler('member');
                                if ($users =& $hMember->getUsers(new Criteria('uname', $submittedBy))) {
                                    $submittedBy = $users[0]->getVar('uid');
                                } elseif ($users =& $hMember->getUsers(new Criteria("email", "%$submittedBy%", "LIKE"))) {
                                    $submittedBy = $users[0]->getVar('uid');
                                } else {
                                    $submittedBy = -1;
                                }
                            }
                            $submittedBy = intval($submittedBy);
                            $crit->add(new Criteria("uid", $submittedBy, "=", "t"));
                            $pagenav_vars .= "&amp;submittedBy=$submittedBy";
                        }
                    }
                    if (isset($ownership) && ($ownership <> -1)) {
                        $ownership = intval($ownership);
                        $crit->add(new Criteria("ownership", $ownership, "=", "t"));
                        $pagenav_vars .= "&amp;ownership=$ownership";
                    }
                    if (isset($closedBy) && ($closedBy <> -1)) {
                        $closedBy = intval($closedBy);
                        $crit->add(new Criteria("closedBy", $closedBy, "=", "t"));
                        $pagenav_vars .= "&amp;closedBy=$closedBy";
                    }
                    $crit->setStart($start);
                    $crit->setLimit($limit);
                    $crit->setSort($sort);
                    $crit->setOrder($order);

                    if (isset($_POST['save']) && $_POST['save'] == 1) {
                        if (isset($_POST['searchid']) && $_POST['searchid'] != 0) {
                            $exSearch =& $hSavedSearch->get(intval($_POST['searchid']));
                            $exSearch->setVar('uid', $xoopsUser->getVar('uid'));
                            $exSearch->setVar('name', $_POST['searchName']);
                            $exSearch->setVar('search', serialize($crit));
                            $exSearch->setVar('pagenav_vars', $pagenav_vars);
                            $exSearch->setVar('hasCustFields', (($hasCustFields) ? 1 : 0));

                            if ($hSavedSearch->insert($exSearch)) { // If saved, store savedSearches in a session var
                                $_xhelpSession->del('xhelp_savedSearches');
                            }
                            unset($exSearch);
                            if ($returnPage != false) {
                                header("Location: " . XHELP_BASE_URL . "/" . $returnPage . ".php");
                            }
                        } else {
                            if ($_POST['searchName'] != '') {
                                $newSearch =& $hSavedSearch->create();
                                $newSearch->setVar('uid', $xoopsUser->getVar('uid'));
                                $newSearch->setVar('name', $_POST['searchName']);
                                $newSearch->setVar('search', serialize($crit));
                                $newSearch->setVar('pagenav_vars', $pagenav_vars);
                                $newSearch->setVar('hasCustFields', (($hasCustFields) ? 1 : 0));

                                if ($hSavedSearch->insert($newSearch)) { // If saved, store savedSearches in a session var
                                    $_xhelpSession->del('xhelp_savedSearches');
                                }
                                unset($newSearch);
                                if ($returnPage != false) {
                                    header("Location: " . XHELP_BASE_URL . "/" . $returnPage . ".php");
                                }
                            }
                        }
                    }
                }
                $viewResults = true;

                $tickets =& $hTickets->getObjectsByStaff($crit, false, $hasCustFields);

                $total = $hTickets->getCountByStaff($crit, $hasCustFields);
                //$pageNav = new  XoopsPageNav($total, $limit, $start, "start", "limit=$limit&department=$search_department&description=$search_description&subject=$search_subject&priority=$search_priority&status=$search_status&submittedBy=$search_submittedBy&ownership=$search_ownership&closedBy=$search_closedBy");   // New PageNav object
                $pageNav = new XoopsPageNav($total, $limit, $start, "start", $pagenav_vars);
                $xoopsTpl->assign('xhelp_pagenav', $pageNav->renderNav());
                unset($pageNav);
                $member_handler =& xoops_gethandler('member');
                foreach ($tickets as $ticket) {
                    $user =& $member_handler->getUser($ticket->getVar('uid'));
                    $owner =& $member_handler->getUser($ticket->getVar('ownership'));
                    //$closer =& $member_handler->getUser($ticket->getVar('closedBy'));
                    $department =& $hDepartments->get($ticket->getVar('department'));
                    //if($owner){
                    $overdue = false;
                    if ($ticket->isOverdue()) {
                        $overdue = true;
                    }

                    $aTickets[$ticket->getVar('id')] = array('id' => $ticket->getVar('id'),
                                                             'uid' => $ticket->getVar('uid'),
                                                             'uname' => (($user) ? $user->getVar('uname') : $xoopsConfig['anonymous']),
                                                             'userinfo' => XOOPS_URL . '/userinfo.php?uid=' . $ticket->getVar('uid'),
                                                             'subject' => xoops_substr($ticket->getVar('subject'), 0, 35),
                                                             'full_subject' => $ticket->getVar('subject'),
                                                             'description' => $ticket->getVar('description'),
                                                             'department' => $department->getVar('department'),
                                                             'departmentid' => $department->getVar('id'),
                                                             'departmenturl' => xhelpMakeURI('index.php', array('op' => 'staffViewAll', 'dept' => $department->getVar('id'))),
                                                             'priority' => $ticket->getVar('priority'),
                                                             'status' => xhelpGetStatus($ticket->getVar('status')),
                                                             'posted' => $ticket->posted(),
                                                             'totalTimeSpent' => $ticket->getVar('totalTimeSpent'),
                                                             'ownership' => (($owner && $owner->getVar('uname') != "") ? $owner->getVar('uname') : _XHELP_NO_OWNER),
                                                             'ownerid' => (($owner && $owner->getVar('uid') != 0) ? $owner->getVar('uid') : 0),
                                                             'ownerinfo' => (($owner && $owner->getVar('uid') != 0) ? XOOPS_URL . '/userinfo.php?uid=' . $owner->getVar('uid') : 0),
                                                             'closedBy' => $ticket->getVar('closedBy'),
                                                             'closedByUname' => $xoopsUser->getUnameFromId($ticket->getVar('closedBy')),
                                                             'url' => XOOPS_URL . '/modules/xhelp/ticket.php?id=' . $ticket->getVar('id'),
                                                             'elapsed' => $ticket->elapsed(),
                                                             'lastUpdate' => $ticket->lastUpdate(),
                                                             'overdue' => $overdue);
                    unset($user);
                    unset($owner);
                    //$closer =& $member_handler->getUser($ticket->getVar('closedBy'));
                    unset($department);
                }
                unset($tickets);
                $xoopsTpl->assign('xhelp_viewResults', $viewResults);
                if (isset($aTickets)) {
                    $xoopsTpl->assign('xhelp_allTickets', $aTickets);
                    $xoopsTpl->assign('xhelp_has_tickets', true);
                } else {
                    $xoopsTpl->assign('xhelp_allTickets', 0);
                    $xoopsTpl->assign('xhelp_has_tickets', false);
                }


                $tpl_cols = array();
                //Setup Column Sorting Vars
                foreach ($sort_columns as $col) {
                    $col_qs = array('sort' => $col);
                    if ($sort == $col) {
                        $col_qs_order = ($order == $sort_order[0] ? $sort_order[1] : $sort_order[0]);
                        $col_sortby = true;
                    } else {
                        $col_qs_order = $order;
                        $col_sortby = false;
                    }
                    $tpl_cols[$col] = array('url' => "search.php?$pagenav_vars&amp;start=$start&amp;sort=$col&amp;order=$col_qs_order",
                                            'urltitle' => _XHELP_TEXT_SORT_TICKETS,
                                            'sortby' => $col_sortby,
                                            'sortdir' => strtolower($col_qs_order));
                }
                $xoopsTpl->assign('xhelp_cols', $tpl_cols);
            } else {
                $xoopsTpl->assign('xhelp_viewResults', $viewResults);
            }
            $xoopsTpl->assign('xhelp_savedSearches', $aSavedSearches);
            $xoopsTpl->assign('xhelp_text_allTickets', _XHELP_TEXT_SEARCH_RESULTS);
            $xoopsTpl->assign('xhelp_priorities', array(5, 4, 3, 2, 1));
            $xoopsTpl->assign('xhelp_priorities_desc', array('5' => _XHELP_PRIORITY5, '4' => _XHELP_PRIORITY4, '3' => _XHELP_PRIORITY3,
                                                             '2' => _XHELP_PRIORITY2, '1' => _XHELP_PRIORITY1));
            $staff =& xhelpGetStaff($displayName);
            $xoopsTpl->assign('xhelp_staff', $staff);
            $hMember =& xhelpGetHandler('membership');
            if ($xoopsModuleConfig['xhelp_deptVisibility'] == 1) { // Apply dept visibility to staff members?
                $hMembership =& xhelpGetHandler('membership');
                $depts =& $hMembership->getVisibleDepartments($xoopsUser->getVar('uid'));
            } else {
                $depts =& $hMember->membershipByStaff($xoopsUser->getVar('uid'));
            }
            foreach ($depts as $dept) {
                $myDepts[$dept->getVar('id')] = $dept->getVar('department');
            }
            unset($depts);
            asort($myDepts);
            $myDepts[-1] = _XHELP_TEXT_SELECT_ALL;
            $xoopsTpl->assign('xhelp_depts', $myDepts);
            $xoopsTpl->assign('xhelp_batch_form', 'index.php');
            $xoopsTpl->assign('xoops_module_header', $xhelp_module_header);

            $hStatus =& xhelpGetHandler('status');
            $crit_stat = new Criteria('', '');
            $crit_stat->setSort('description');
            $crit_stat->setOrder('ASC');
            $statuses =& $hStatus->getObjects($crit_stat);
            $aStatuses = array();
            foreach ($statuses as $status) {
                $aStatuses[$status->getVar('id')] = array('id' => $status->getVar('id'),
                                                          'desc' => $status->getVar('description'),
                                                          'state' => $status->getVar('state'));
            }
            unset($statuses);
            $xoopsTpl->assign('xhelp_statuses', $aStatuses);

            $fields =& $hFields->getObjects();
            $aFields = array();
            foreach ($fields as $field) {
                $values = $field->getVar('fieldvalues');
                if ($field->getVar('controltype') == XHELP_CONTROL_YESNO) {
                    //$values = array(1 => _YES, 0 => _NO);
                    $values = (($values == 1) ? _YES : _NO);
                }
                $defaultValue = $field->getVar('defaultvalue');

                $aFields[$field->getVar('id')] =
                        array('name' => $field->getVar('name'),
                              'desc' => $field->getVar('description'),
                              'fieldname' => $field->getVar('fieldname'),
                              'defaultvalue' => $defaultValue,
                              'controltype' => $field->getVar('controltype'),
                              'required' => $field->getVar('required'),
                              'fieldlength' => ($field->getVar('fieldlength') < 50 ? $field->getVar('fieldlength') : 50),
                              'maxlength' => $field->getVar('fieldlength'),
                              'weight' => $field->getVar('weight'),
                              'fieldvalues' => $values,
                              'validation' => $field->getVar('validation'));
            }
            unset($fields);
            $xoopsTpl->assign('xhelp_custFields', $aFields);
            if (!empty($aFields)) {
                $xoopsTpl->assign('xhelp_hasCustFields', true);
            } else {
                $xoopsTpl->assign('xhelp_hasCustFields', false);
            }

            $_xhelpSession->set('xhelp_custFields', $aFields);
            break;
    }


    require(XOOPS_ROOT_PATH . '/footer.php');
} else { // If not a user
    redirect_header(XOOPS_URL . '/user.php', 3);
}
?>