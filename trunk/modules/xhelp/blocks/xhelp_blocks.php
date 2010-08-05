<?php
//$Id: xhelp_blocks.php,v 1.65 2005/11/30 19:25:00 eric_juden Exp $
if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

if (!defined('XHELP_CONSTANTS_INCLUDED')) {
    include_once(XOOPS_ROOT_PATH.'/modules/xhelp/include/constants.php');
}

include_once(XHELP_BASE_PATH.'/functions.php');
include_once(XHELP_CLASS_PATH.'/session.php');
xhelpIncludeLang('main');

function b_xhelp_open_show($options)
{
    global $xoopsUser;
    
    $max_char_in_title = $options[0];
    
    if($xoopsUser){
        $uid = $xoopsUser->getVar('uid');   // Get uid
        $block = array();
        $hTickets =& xhelpGetHandler('ticket');  // Get ticket handler
        $hStaff =& xhelpGetHandler('staff');
        if($isStaff =& $hStaff->isStaff($xoopsUser->getVar('uid'))){
            $crit = new CriteriaCompo(new Criteria('ownership', $uid));
            $crit->add(new Criteria('status', 2, '<'));
            $crit->setOrder('DESC');
            $crit->setSort('priority, posted');
            $crit->setLimit(5);
            $tickets =& $hTickets->getObjects($crit);
            
            foreach($tickets as $ticket){
                $overdue = false;
                if($ticket->isOverdue()){
                    $overdue = true;
                }
                $block['ticket'][] = array('id'=>$ticket->getVar('id'),
                                           'uid'=>$ticket->getVar('uid'),
                                           'subject'=>$ticket->getVar('subject'),
                                           'truncSubject'=>xoops_substr($ticket->getVar('subject'), 0, $max_char_in_title),
                                           'description'=>$ticket->getVar('description'),
                                           //'department'=>$department->getVar('department'),
                                           'priority'=>$ticket->getVar('priority'),
                                           'status'=>$ticket->getVar('status'),
                                           'posted'=>$ticket->posted(),
                                           //'ownership'=>$owner->getVar('uname'),
                                           'closedBy'=>$ticket->getVar('closedBy'),
                                           'totalTimeSpent'=>$ticket->getVar('totalTimeSpent'),
                                           //'uname'=>$user->getVar('uname'),
                                           'userinfo'=>XOOPS_URL . '/userinfo.php?uid=' . $ticket->getVar('uid'),
                                           //'ownerinfo'=>XOOPS_URL . '/userinfo.php?uid=' . $ticket->getVar('ownership'),
                                           'url'=>XOOPS_URL . '/modules/xhelp/ticket.php?id=' . $ticket->getVar('id'),
                                           'overdue' => $overdue);
            }
            
            $block['isStaff'] = true;
            $block['viewAll'] = XOOPS_URL . '/modules/xhelp/index.php?op=staffViewAll';
            $block['viewAllText'] = _MB_XHELP_TEXT_VIEW_ALL_OPEN;
            $block['priorityText'] = _MB_XHELP_TEXT_PRIORITY;
            $block['noTickets'] = _MB_XHELP_TEXT_NO_TICKETS;
        } else {
            $crit = new CriteriaCompo(new Criteria('uid', $uid));
            $crit->add(new Criteria('status', 2, '<'));
            $crit->setOrder('DESC');
            $crit->setSort('priority, posted');
            $crit->setLimit(5);
            $tickets =& $hTickets->getObjects($crit);
            $hDepartments =& xhelpGetHandler('department');
            
            foreach($tickets as $ticket){
                //$department =& $hDepartments->get($ticket->getVar('department'));
                $block['ticket'][] = array('id'=>$ticket->getVar('id'),
                                           'uid'=>$ticket->getVar('uid'),
                                           'subject'=>$ticket->getVar('subject'),
                                           'truncSubject'=>xoops_substr($ticket->getVar('subject'), 0, $max_char_in_title),
                                           'description'=>$ticket->getVar('description'),
                                           //'department'=>($department->getVar('department'),
                                           'priority'=>$ticket->getVar('priority'),
                                           'status'=>$ticket->getVar('status'),
                                           'posted'=>$ticket->posted(),
                                           //'ownership'=>$owner->getVar('uname'),
                                           'closedBy'=>$ticket->getVar('closedBy'),
                                           'totalTimeSpent'=>$ticket->getVar('totalTimeSpent'),
                                           //'uname'=>$user->getVar('uname'),
                                           'userinfo'=>XOOPS_URL . '/userinfo.php?uid=' . $ticket->getVar('uid'),
                                           //'ownerinfo'=>XOOPS_URL . '/userinfo.php?uid=' . $ticket->getVar('ownership'),
                                           'url'=>XOOPS_URL . '/modules/xhelp/ticket.php?id=' . $ticket->getVar('id'));
            }
        }
        $block['numTickets'] = count($tickets);
        $block['noTickets'] = _MB_XHELP_TEXT_NO_TICKETS;
        unset($tickets);
        $block['picPath'] = XOOPS_URL . '/modules/xhelp/images/';
        return $block;
    }
}

function b_xhelp_performance_show($options)
{
    global $xoopsUser, $xoopsDB;
    $dirname = 'xhelp';
    $block = array();
    
    if (!$xoopsUser) {
        return false;
    }
    
    //Determine if the GD library is installed
    $block['use_img'] = function_exists("imagecreatefrompng");

    $xoopsModule =& xhelpGetModule();
    
    if ($xoopsUser->isAdmin($xoopsModule->getVar('mid'))) {
        $sql = sprintf(
            "SELECT COUNT(*) as TicketCount, d.department, d.id FROM %s t INNER JOIN %s d ON t.department = d.id  INNER JOIN %s s ON t.status = s.id WHERE s.state = 1 GROUP BY d.department, d.id ORDER BY d.department", 
            $xoopsDB->prefix('xhelp_tickets'), $xoopsDB->prefix('xhelp_departments'), $xoopsDB->prefix('xhelp_status'));
    } else {
        $sql = sprintf(
            "SELECT COUNT(*) as TicketCount, d.department, d.id FROM %s t INNER JOIN %s j on t.department = j.department INNER JOIN %s d ON t.department = d.id INNER JOIN %s s on t.status = s.id WHERE s.state = 1 AND j.uid = %u GROUP BY d.department, d.id", 
            $xoopsDB->prefix('xhelp_tickets'), $xoopsDB->prefix('xhelp_jstaffdept'), $xoopsDB->prefix('xhelp_departments'), $xoopsDB->prefix('xhelp_status'), $xoopsUser->getVar('uid'));
    }
    
    $ret = $xoopsDB->query($sql);
    
    $depts = array();
    $max_open = 0;
    while ($myrow = $xoopsDB->fetchArray($ret)) {
        $max_open = max($max_open,$myrow['TicketCount']);
        $url = xhelpMakeURI(XHELP_BASE_URL.'/index.php', array('op'=>'staffViewAll', 'dept'=>$myrow['id'], 'state'=>1));
        $depts[] = array('id'=>$myrow['id'], 'tickets'=>$myrow['TicketCount'], 'name'=>$myrow['department'], 'url'=>$url);
    }
    
    if (count($depts) == 0) {
        return false;
    }
    
    if ($block['use_img']) {
        //Retrieve the image path for each department
        for($i = 0; $i < count($depts); $i++) {
            $depts[$i]['img'] = _xhelp_getDeptImg($depts[$i]['id'], $depts[$i]['tickets'], $max_open, $i);
        }
    }
    
    $block['departments'] = $depts;
    
    return $block;
}

function _xhelp_getDeptImg($dept, $tickets, $max, $counter = 0)
{
    $dept = intval($dept);
    $tickets = intval($tickets);
    $max = intval($max);
    $counter = intval($counter);
    
    $width = 60;   //Width of resulting image
    
    $cachedir_local = XHELP_CACHE_PATH .'/';
    $cachedir_www = XHELP_CACHE_URL .'/';
    $imgdir = XHELP_IMAGE_PATH.'/';
    $filename = "xhelp_perf_$dept.png";
    
    $colors = array('green', 'orange', 'red', 'blue');
    
    if (!is_file($cachedir_local.$filename)) {
        //Generate Progress Image
        $cur_color  = $colors[$counter % count($colors)];
        $bg         = @imagecreatefrompng($imgdir.'dept-bg.png');
        $fill       = @imagecreatefrompng($imgdir."dept-$cur_color.png");
        $bg_cap     = @imagecreatefrompng($imgdir.'dept-bg-cap.png');
        $fill_cap   = @imagecreatefrompng($imgdir.'dept-fill-cap.png');
        $fill_width = round((($width - imagesx($bg_cap)) * $tickets) / $max) - imagesx($fill_cap);
        
        $image = imagecreatetruecolor($width, imagesy($bg));
        imagecopy($image, $bg, 0, 0, 0, 0, imagesx($bg), $width - imagesx($bg_cap));
        imagecopy($image, $bg_cap, $width - imagesx($bg_cap), 0, 0, 0, imagesx($bg_cap), imagesy($bg_cap));
        imagecopy($image, $fill, 0, 0, 0, 0, $fill_width, imagesy($fill));
        imagecopy($image, $fill_cap, $fill_width, 0, 0, 0, imagesx($fill_cap), imagesy($fill_cap));
        
        imagepng($image, $cachedir_local.$filename);
    }
    
    return ($cachedir_www.$filename);
}

function b_xhelp_recent_show($options)
{
    if(!isset($_COOKIE['xhelp_recent_tickets'])){
        return false;
    } else {
        $tmp   = $_COOKIE['xhelp_recent_tickets'];
    }
    
    $block = array();
        
    if (strlen($tmp) > 0) {
        $tmp2 = explode(',', $tmp);
        
        $crit    = new Criteria('id', "(". $tmp . ")", 'IN', 't');
        $hTicket = xhelpGetHandler('ticket');
        $tickets = $hTicket->getObjects($crit, true);
        
        foreach ($tmp2 as $ele) {
            if (isset($tickets[intval($ele)])) {
                $ticket =& $tickets[intval($ele)];
                
                $overdue = false;
                if($ticket->isOverdue()){
                    $overdue = true;
                }
                
                $block['tickets'][] = array('id' => $ticket->getVar('id'), 
                            'trim_subject' => xoops_substr($ticket->getVar('subject'), 0, 25),
                            'subject' => $ticket->getVar('subject'),
                            'url' => XOOPS_URL . '/modules/xhelp/ticket.php?id='.$ticket->getVar('id'),
                            'overdue' => $overdue);
            }
        }  
        $block['ticketcount'] = count($tickets);
        return $block;   
    } else {
        return false;
    }
}

function b_xhelp_actions_show()
{   
    
    $_xhelpSession = new Session();
    global $ticketInfo, $xoopsUser, $xoopsModule, $xoopsModuleConfig, $ticketInfo, $staff, $xoopsConfig;
    
    $module_handler =& xoops_gethandler('module');
    $config_handler =& xoops_gethandler('config');
    $member_handler =& xoops_gethandler('member');
    $hTickets       =& xhelpGetHandler('ticket');
    $hMembership    =& xhelpGetHandler('membership');
    $hStaff         =& xhelpGetHandler('staff');
    $hDepartment    =& xhelpGetHandler('department');
    
    //Don't show block for anonymous users or for non-staff members
    if (!$xoopsUser) {
        return false;
    }
    
    //Don't show block if outside the xhelp module'
    if (!isset($xoopsModule) || $xoopsModule->getVar('dirname') != 'xhelp') {
        return false;
    }
    
    $block = array();
    
    $myPage = $_SERVER['PHP_SELF'];
	$currentPage = substr(strrchr($myPage, "/"), 1);
    if(($currentPage <> 'ticket.php') || ($xoopsModuleConfig['xhelp_staffTicketActions'] <> 2)){
        return false;
    }
    
    if(isset($_GET['id'])){
        $block['ticketid'] = intval($_GET['id']);
    } else {
        return false;
    }
    
    //Use Global $ticketInfo object (if exists)
    if (!isset($ticketInfo)) {    
        $ticketInfo =& $hTickets->get($block['ticketid']);
    }
    

    
    
    if($xoopsModuleConfig['xhelp_staffTicketActions'] == 2){
        $aOwnership = array();
        $aOwnership[] = array('uid' => 0,
                              'uname' => _XHELP_NO_OWNER);
        if(isset($staff)){
            foreach($staff as $stf){
                //** BTW - Need to have a way to get all XoopsUser objects for the staff in 1 shot
                //$own =& $member_handler->getUser($stf->getVar('uid'));    // Create user object
                $aOwnership[] = array('uid'=>$stf->getVar('uid'),
                                              'uname'=>'');
                $all_users[$stf->getVar('uid')] = '';
            }
        } else {
            return false;
        }
        
        $xoopsDB =& Database::getInstance();
        $users = array();
        
        //@Todo - why is this query here instead of using a function or the XoopsMemberHandler?
        $sql = sprintf("SELECT uid, uname, name FROM %s WHERE uid IN (%s)", $xoopsDB->prefix('users'), implode(array_keys($all_users), ','));
        $ret = $xoopsDB->query($sql);
        $displayName = $xoopsModuleConfig['xhelp_displayName'];
        while($member = $xoopsDB->fetchArray($ret)){
            if(($displayName == 2) && ($member['name'] <> '')){
                $users[$member['uid']] = $member['name'];
            } else {
                $users[$member['uid']] = $member['uname'];
            }
        }
        
        for($i=0;$i<count($aOwnership);$i++){
            if(isset($users[$aOwnership[$i]['uid']])){
                $aOwnership[$i]['uname'] = $users[$aOwnership[$i]['uid']];
            }
        }
        $block['ownership'] = $aOwnership;
    }
    
    $block['imagePath'] = XHELP_IMAGE_URL.'/';
    $block['xhelp_priorities']      = array(1, 2, 3, 4, 5);
    $block['xhelp_priorities_desc'] = array('5' => _XHELP_PRIORITY5, '4' => _XHELP_PRIORITY4,'3' => _XHELP_PRIORITY3, '2' => _XHELP_PRIORITY2, '1' => _XHELP_PRIORITY1);
    $block['ticket_priority']  = $ticketInfo->getVar('priority');
    $block['ticket_status']    = $ticketInfo->getVar('status');
    $block['xhelp_status0']    = _XHELP_STATUS0;
    $block['xhelp_status1']    = _XHELP_STATUS1;
    $block['xhelp_status2']    = _XHELP_STATUS2;
    $block['ticket_ownership'] = $ticketInfo->getVar('ownership');
    
    $block['xhelp_has_changeOwner'] = false;
    if($ticketInfo->getVar('uid') == $xoopsUser->getVar('uid')){
        $block['xhelp_has_addResponse'] = true;
    } else {
        $block['xhelp_has_addResponse'] = false;
    }
    $block['xhelp_has_editTicket'] = false;
    $block['xhelp_has_deleteTicket'] = false;
    $block['xhelp_has_changePriority'] = false;
    $block['xhelp_has_changeStatus'] = false;
    $block['xhelp_has_editResponse'] = false;
    $block['xhelp_has_mergeTicket'] = false;
    $rowspan = 2;
    $checkRights = array(
        XHELP_SEC_TICKET_OWNERSHIP => array('xhelp_has_changeOwner', false),
        XHELP_SEC_RESPONSE_ADD => array('xhelp_has_addResponse', false),
        XHELP_SEC_TICKET_EDIT => array('xhelp_has_editTicket', true),
        XHELP_SEC_TICKET_DELETE => array('xhelp_has_deleteTicket', true),
        XHELP_SEC_TICKET_MERGE => array('xhelp_has_mergeTicket', true),
        XHELP_SEC_TICKET_PRIORITY => array('xhelp_has_changePriority', false),
        XHELP_SEC_TICKET_STATUS => array('xhelp_has_changeStatus', false),
        XHELP_SEC_RESPONSE_EDIT => array('xhelp_has_editResponse', false),
        XHELP_SEC_FILE_DELETE => array('xhelp_has_deleteFile', false),
        XHELP_SEC_FAQ_ADD => array('xhelp_has_addFaq', false),
        XHELP_SEC_TICKET_TAKE_OWNERSHIP => array('xhelp_has_takeOwnership', false));
        
   
    $checkStaff =& $hStaff->getByUid($xoopsUser->getVar('uid'));
    // See if this user is accepted for this ticket
    $hTicketEmails =& xhelpGetHandler('ticketEmails');
    $crit = new CriteriaCompo(new Criteria('ticketid', $ticketInfo->getVar('id')));
    $crit->add(new Criteria('uid', $xoopsUser->getVar('uid')));
    $ticketEmails =& $hTicketEmails->getObjects($crit);
    
    //Retrieve all departments
    $crit = new Criteria('','');
    $crit->setSort('department');
    $alldepts = $hDepartment->getObjects($crit);
    $aDept = array();
    foreach($alldepts as $dept){
        $aDept[$dept->getVar('id')] = $dept->getVar('department');
    }
    unset($alldepts);
    $block['departments'] =& $aDept;
    $block['departmentid'] = $ticketInfo->getVar('department');
    

    foreach ($checkRights as $right=>$desc) {
        if(($right == XHELP_SEC_RESPONSE_ADD) && count($ticketEmails > 0)){
            $block[$desc[0]] = true;
            continue;
        }
        if(($right == XHELP_SEC_TICKET_STATUS) && count($ticketEmails > 0)){
            $block[$desc[0]] = true;
            continue;
        }
        if ($hasRights = $checkStaff->checkRoleRights($right, $ticketInfo->getVar('department'))) {
            $block[$desc[0]] = true;
            if ($desc[1]) {
                $rowspan ++;
            }
        }
        
    }
    
    $block['xhelp_actions_rowspan'] = $rowspan;
    
    $hStatus =& xhelpGetHandler('status');
    $crit = new Criteria('', '');
    $crit->setSort('description');
    $crit->setOrder('ASC');
    $statuses =& $hStatus->getObjects($crit);
    $aStatuses = array();
    foreach($statuses as $status){
        $aStatuses[$status->getVar('id')] = array('id' => $status->getVar('id'),
                                                  'desc' => $status->getVar('description'),
                                                  'state' => $status->getVar('state'));
    }
    
    $block['statuses'] = $aStatuses;
    
    return $block;
}

function b_xhelp_actions_edit($options)
{
	$form = "<table>";
	$form .= "<tr>";
	$form .= "<td>" . _MB_XHELP_TRUNCATE_TITLE . "</td>";
	$form .= "<td>" . "<input type='text' name='options[]' value='" . $options[0] . "' /></td>";
	$form .= "</tr>";
	$form .= "</table>";
	
	return $form;
}

function b_xhelp_mainactions_show($options)
{   
    
    global $xoopsUser, $xhelp_isStaff;
    // @todo - use the constant here if possible instead of the raw string
	$dirname = 'xhelp';
	$block['linkPath'] = XHELP_BASE_URL.'/';
    $block['imagePath'] = XHELP_IMAGE_URL.'/';
    $block['menustyle'] = $options[0];
    $block['showicon'] = !$block['menustyle'] && $options[1];
    $block['startitem'] = !$block['menustyle'] ? '<li>' : '';
    $block['enditem'] = !$block['menustyle'] ? '</li>' : '';
    $block['startblock'] = !$block['menustyle'] ? '<ul>' : '<table cellspacing="0"><tr><td id="usermenu">';
    $block['endblock'] = !$block['menustyle'] ? '</ul>' : '</td></tr></table>';
	$block['savedSearches'] = false;
	$block['items'][0] = array( 'link' => 'anon_addTicket.php', 'image' => 'addTicket.png', 'text' => _XHELP_MENU_LOG_TICKET );
        
	if($xoopsUser){
		$block['items'][0] = array( 'link' => 'index.php', 'image' => 'main.png', 'text' => _XHELP_MENU_MAIN );
		$block['items'][1] = array( 'link' => 'addTicket.php', 'image' => 'addTicket.png', 'text' => _XHELP_MENU_LOG_TICKET );
		$block['items'][2] = array( 'link' => 'index.php?viewAllTickets=1&op=userViewAll', 'image' => 'ticket.png', 'text' => _XHELP_MENU_ALL_TICKETS );
	    $hStaff =& xhelpGetHandler('staff');
	    if($xhelp_staff =& $hStaff->getByUid($xoopsUser->getVar('uid'))){
	        $block['whoami'] = 'staff';
	        $block['items'][3] = array( 'link' => 'search.php', 'image' => 'search2.png', 'text' => _XHELP_MENU_SEARCH );
       		$block['items'][4] = array( 'link' => 'profile.php', 'image' => 'profile.png', 'text' => _XHELP_MENU_MY_PROFILE );
			$block['items'][2] = array( 'link' => 'index.php?viewAllTickets=1&op=staffViewAll', 'image' => 'ticket.png', 'text' => _XHELP_MENU_ALL_TICKETS );
	        $hSavedSearch =& xhelpGetHandler('savedSearch');
			$savedSearches =& $hSavedSearch->getByUid($xoopsUser->getVar('uid'));
			$aSavedSearches = array();
			foreach($savedSearches as $sSearch){
				$aSavedSearches[$sSearch->getVar('id')] = array('id' => $sSearch->getVar('id'),
																'name' => $sSearch->getVar('name'),
																'search' => $sSearch->getVar('search'),
																'pagenav_vars' => $sSearch->getVar('pagenav_vars'));
			}
			$block['savedSearches'] = (count($aSavedSearches) < 1) ? false : $aSavedSearches;
		}
	}
    
    return $block;
}

function b_xhelp_mainactions_edit($options)
{	
	$form  = "<table border='0'>";
	
	// Menu style
	$form .= "<tr><td>"._MB_XHELP_TEXT_MENUSTYLE."</td><td>";
	$form .= "<input type='radio' name='options[0]' value='0'".(($options[0]==0)?" checked='checked'":"")." />"._MB_XHELP_OPTION_MENUSTYLE1."";
	$form .= "<input type='radio' name='options[0]' value='1'".(($options[0]==1)?" checked='checked'":"")." />"._MB_XHELP_OPTION_MENUSTYLE2."</td></tr>";

	// Auto select last items
	$form .= "<tr><td>"._MB_XHELP_TEXT_SHOWICON."</td><td>";
	$form .= "<input type='radio' name='options[1]' value='0'".(($options[1]==0)?" checked='checked'":"")." />"._NO."";
	$form .= "<input type='radio' name='options[1]' value='1'".(($options[1]==1)?" checked='checked'":"")." />"._YES."</td></tr>";
		
	$form .= "</table>";
	return $form;
}

?>