<?php


if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH . '/modules/extcal/class/ExtcalPersistableObjectHandler.php';
include_once XOOPS_ROOT_PATH . '/modules/extcal/class/perm.php';
include_once XOOPS_ROOT_PATH . '/modules/extcal/class/time.php';
include_once XOOPS_ROOT_PATH . '/modules/extcal/class/config.php';

class ExtcalEvent extends XoopsObject
{

    var $externalKey = array();

    function ExtcalEvent()
    {
        $this->initVar('event_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('cat_id', XOBJ_DTYPE_INT, null, true);
        $this->initVar('event_title', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('event_desc', XOBJ_DTYPE_TXTAREA, '', false);
        $this->initVar('event_contact', XOBJ_DTYPE_TXTBOX, '', false);
        $this->initVar('event_url', XOBJ_DTYPE_URL, '', false);
        $this->initVar('event_email', XOBJ_DTYPE_TXTBOX, '', false);
        $this->initVar('event_address', XOBJ_DTYPE_TXTAREA, '', false);
        $this->initVar('event_approved', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('event_start', XOBJ_DTYPE_INT, null, true);
        $this->initVar('event_end', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('event_submitter', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('event_submitdate', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('event_nbmember', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('event_isrecur', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('event_recur_rules', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('event_recur_start', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('event_recur_end', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('dohtml', XOBJ_DTYPE_INT, 0, false);

        $this->externalKey['cat_id'] = array('className' => 'cat', 'getMethodeName' => 'getCat', 'keyName' => 'cat', 'core' => false);
        $this->externalKey['event_submitter'] = array('className' => 'user', 'getMethodeName' => 'get', 'keyName' => 'user', 'core' => true);
    }

    function getExternalKey($key)
    {
        return $this->externalKey[$key];
    }

}

class ExtcalEventHandler extends ExtcalPersistableObjectHandler
{

    private $_extcalPerm;
    private $_extcalTime;
    private $_extcalConfig;

    function ExtcalEventHandler(&$db)
    {
        $this->_extcalPerm = ExtcalPerm::getHandler();
        $this->_extcalTime = ExtcalTime::getHandler();
        $extcalConfig = ExtcalConfig::getHandler();
        $this->_extcalConfig = $extcalConfig->getModuleConfig();
        $this->ExtcalPersistableObjectHandler($db, 'extcal_event', 'ExtcalEvent', 'event_id');
    }

    function createEvent($data)
    {
        $event = $this->create();
        $this->_checkDate($data);
        $this->_userTimeToServerTime($data);
        $this->_addRecurValue($data);
        $event->setVars($data);
        return $this->insert($event, true);
    }

    function createEventForPreview($data)
    {
        $event = $this->create();
        $this->_checkDate($data);
        $this->_addRecurValue($data);
        $event->setVars($data);

        return $event;
    }

    function modifyEvent($eventId, $data)
    {
        $event = $this->get($eventId);
        $this->_checkDate($data);
        $this->_userTimeToServerTime($data);
        $this->_addRecurValue($data);
        $event->setVars($data);
        return $this->insert($event);
    }

    function deleteEvent($eventId)
    {
        /* TODO :
           - Delete who's going
           - Delete who's not going
           - Delete comment
           - Delete notifications
          */
        $this->delete($eventId, true);
    }

    // Return one approved event selected by his id
    function getEvent($eventId, $skipPerm = false)
    {

        $user = $GLOBALS['xoopsUser'];

        $criteriaCompo = new CriteriaCompo();
        $criteriaCompo->add(new Criteria('event_id', $eventId));
        $criteriaCompo->add(new Criteria('event_approved', 1));
        if (!$skipPerm) {
            $this->_addCatPermCriteria($criteriaCompo, $user);
        }
        $ret = $this->getObjects($criteriaCompo);
        if (isset($ret[0])) {
            return $ret[0];
        } else {
            return false;
        }
    }

    // Return one event selected by his id (approve or not)
    function getEventWithNotApprove($eventId, $skipPerm = false)
    {

        $user = $GLOBALS['xoopsUser'];

        $criteriaCompo = new CriteriaCompo();
        $criteriaCompo->add(new Criteria('event_id', $eventId));
        if (!$skipPerm) {
            $this->_addCatPermCriteria($criteriaCompo, $user);
        }
        $ret = $this->getObjects($criteriaCompo);
        if (isset($ret[0])) {
            return $ret[0];
        } else {
            return false;
        }
    }

    function formatEventsDate(&$events, $pattern)
    {
        $max = count($events);
        for (
            $i = 0; $i < $max; $i++
        ) {
            $this->formatEventDate($events[$i], $pattern);
        }
    }

    function formatEventDate(&$event, $pattern)
    {
        if (!$event['event_isrecur']) {
            $event['formated_event_start'] = $this->_extcalTime->getFormatedDate($pattern, $event['event_start']);
            $event['formated_event_end'] = $this->_extcalTime->getFormatedDate($pattern, $event['event_end']);
        } else {
            $event['formated_event_start'] = $this->_extcalTime->getFormatedDate($pattern, $event['event_start']);
            $event['formated_event_end'] = $this->_extcalTime->getFormatedDate($pattern, $event['event_end']);
            $event['formated_reccur_rule'] = $this->_extcalTime->getFormatedReccurRule($event['event_recur_rules']);
        }
        $event['formated_event_submitdate'] = $this->_extcalTime->getFormatedDate($pattern, $event['event_submitdate']);
    }

    function _checkDate(&$data)
    {

        list($year, $month, $day) = explode("-", $data['event_start']['date']);
        $data['event_start']
            =
            mktime(0, 0, 0, $month, $day, $year) + $data['event_start']['time'];
        list($year, $month, $day) = explode("-", $data['event_end']['date']);
        $data['event_end']
            = mktime(0, 0, 0, $month, $day, $year) + $data['event_end']['time'];

        if ($data['have_end'] == 0 || $data['event_start'] > $data['event_end']
        ) {
            $data['event_end'] = $data['event_start'];
        }

    }

    function _userTimeToServerTime(&$data)
    {

        $user = $GLOBALS['xoopsUser'];

        $data['event_start'] = userTimeToServerTime($data['event_start'], $this->_extcalTime->_getUserTimeZone($user));
        $data['event_end'] = userTimeToServerTime($data['event_end'], $this->_extcalTime->_getUserTimeZone($user));

    }

    function serverTimeToUserTime(&$data)
    {

        $user = $GLOBALS['xoopsUser'];

        $data['event_start'] = xoops_getUserTimestamp($data['event_start'], $this->_extcalTime->_getUserTimeZone($user));
        $data['event_end'] = xoops_getUserTimestamp($data['event_end'], $this->_extcalTime->_getUserTimeZone($user));
        $data['event_submitdate'] = xoops_getUserTimestamp($data['event_submitdate'], $this->_extcalTime->_getUserTimeZone($user));

    }

    function serverTimeToUserTimes(&$events)
    {
        $max = count($events);
        for (
            $i = 0; $i < $max; $i++
        ) {
            $this->serverTimeToUserTime($events[$i]);
        }
    }

    function _addRecurValue(&$data)
    {
        $data['event_isrecur'] = $this->getIsRecur($_POST);
        $data['event_recur_rules'] = $this->getRecurRules($_POST);
        $data['event_recur_start'] = $this->getRecurStart($data, $_POST);
        $data['event_recur_end'] = $this->getRecurEnd($data, $_POST);
    }

    // Return event occuring on a given day
    function getEventDay($day, $month, $year, $cat = 0)
    {

        $user = $GLOBALS['xoopsUser'];

        $dayStart = userTimeToServerTime(mktime(0, 0, 0, $month, $day, $year), $this->_extcalTime->_getUserTimeZone($user));
        $dayEnd = userTimeToServerTime(mktime(23, 59, 59, $month, $day, $year), $this->_extcalTime->_getUserTimeZone($user));
        $criteriaCompo = $this->_getListCriteriaCompo($dayStart, $dayEnd, $cat, $user);
        return $this->getObjects($criteriaCompo);
    }

    // Return the criteria compo object for a week
    function _getEventWeekCriteria($day, $month, $year, $cat, $nbDays = 7)
    {                 
                      
        $user = $GLOBALS['xoopsUser'];

        $userStartTime = mktime(0, 0, 0, $month, $day, $year);
        $userEndTime = $userStartTime + (86400 * $nbDays);
        $weekStart = userTimeToServerTime($userStartTime, $this->_extcalTime->_getUserTimeZone($user));
        $weekEnd = userTimeToServerTime($userEndTime, $this->_extcalTime->_getUserTimeZone($user));
        $criteriaCompo = $this->_getCriteriaCompo($weekStart, $weekEnd, $cat, $user);
        return $criteriaCompo;
    }

    // Return event occuring on a given week for list view
    //modif JJd : ajout du nombre de jours a prendre en compte (7 par defaut))
    function getEventWeek($day, $month, $year, $cat = 0, $nbDays = 7)
    {
        $criteriaCompo = $this->_getEventWeekCriteria($day, $month, $year, $cat);
        if (!$this->_extcalConfig['diplay_past_event_list']) {
            $criteriaCompo->add(new Criteria('event_end', time(), '>'));
        }
        return $this->getObjects($criteriaCompo);
    }


    // Return event occuring on a given week for calendar view
    function getEventCalendarWeek($day, $month, $year, $cat = 0)
    {
        $criteriaCompo = $this->_getEventWeekCriteria($day, $month, $year, $cat);
        if (!$this->_extcalConfig['diplay_past_event_cal']) {
            $criteriaCompo->add(new Criteria('event_end', time(), '>'));
        }
        $criteriaCompo->setOrder('ASC');
        return $this->getObjects($criteriaCompo);
    }

    // Return the criteria compo object for a month
    function _getEventMonthCriteria($month, $year, $cat)
    {

        $user = $GLOBALS['xoopsUser'];

        $userStartTime = mktime(0, 0, 0, $month, 1, $year);
        $userEndTime = mktime(23, 59, 59, $month + 1, 0, $year);
        $monthStart = userTimeToServerTime($userStartTime, $this->_extcalTime->_getUserTimeZone($user));
        $monthEnd = userTimeToServerTime($userEndTime, $this->_extcalTime->_getUserTimeZone($user));
        $criteriaCompo = $this->_getCriteriaCompo($monthStart, $monthEnd, $cat, $user);
        return $criteriaCompo;
    }

    // Return event occuring on a given month for list view
    function getEventMonth($month, $year, $cat = 0)
    {
        $criteriaCompo = $this->_getEventMonthCriteria($month, $year, $cat);
        if (!$this->_extcalConfig['diplay_past_event_list']) {
            $criteriaCompo->add(new Criteria('event_end', time(), '>'));
        }
        return $this->getObjects($criteriaCompo);
    }

    // Return event occuring on a given month for calendar view
    function getEventCalendarMonth($month, $year, $cat = 0)
    {
        $criteriaCompo = $this->_getEventMonthCriteria($month, $year, $cat);
        if (!$this->_extcalConfig['diplay_past_event_cal']) {
            $criteriaCompo->add(new Criteria('event_end', time(), '>'));
        }
        $criteriaCompo->setOrder('ASC');
        return $this->getObjects($criteriaCompo);
    }

    // Return event occuring on a given year
    function getEventYear($year, $cat = 0)
    {

        $user = $GLOBALS['xoopsUser'];

        $userStartTime = mktime(0, 0, 0, 1, 1, $year);
        $userEndTime = mktime(23, 59, 59, 12, 31, $year);
        $yearStart = userTimeToServerTime($userStartTime, $this->_extcalTime->_getUserTimeZone($user));
        $yearEnd = userTimeToServerTime($userEndTime, $this->_extcalTime->_getUserTimeZone($user));
        $criteriaCompo = $this->_getListCriteriaCompo($yearStart, $yearEnd, $cat, $user);

        return $this->getObjects($criteriaCompo);
    }

    function _getCriteriaCompo($start, $end, $cat, &$user)
    {

        $criteriaNoRecur = new CriteriaCompo();
        $criteriaNoRecur->add(new Criteria('event_start', $end, '<='));
        $criteriaNoRecur->add(new Criteria('event_end', $start, '>='));
        $criteriaNoRecur->add(new Criteria('event_isrecur', 0));

        $criteriaRecur = new CriteriaCompo();
        $criteriaRecur->add(new Criteria('event_recur_start', $end, '<='));
        $criteriaRecur->add(new Criteria('event_recur_end', $start, '>='));
        $criteriaRecur->add(new Criteria('event_isrecur', 1));

        $criteriaCompoDate = new CriteriaCompo();
        $criteriaCompoDate->add($criteriaNoRecur, 'OR');
        $criteriaCompoDate->add($criteriaRecur, 'OR');

        $criteriaCompo = new CriteriaCompo();
        $criteriaCompo->add($criteriaCompoDate);

        $criteriaCompo->add(new Criteria('event_approved', 1));
        $this->_addCatSelectCriteria($criteriaCompo, $cat);
        $this->_addCatPermCriteria($criteriaCompo, $user);
        $criteriaCompo->setSort('event_start');

        return $criteriaCompo;
    }

    function _getCalendarCriteriaCompo($start, $end, $cat, &$user)
    {

        $criteriaCompo = $this->_getCriteriaCompo($start, $end, $cat, $user);
        if (!$this->_extcalConfig['diplay_past_event_cal']) {
            $criteriaCompo->add(new Criteria('event_end', time(), '>'));
        }
        return $criteriaCompo;
    }

    function _getListCriteriaCompo($start, $end, $cat, &$user)
    {

        $criteriaCompo = $this->_getCriteriaCompo($start, $end, $cat, $user);
        if (!$this->_extcalConfig['diplay_past_event_list']) {
            $criteriaCompo->add(new Criteria('event_end', time(), '>'));
        }
        return $criteriaCompo;
    }

    // Return upcomming event
    function getUpcommingEvent($nbEvent, $cat = 0)
    {

        $now = time();

        $criteriaNoRecur = new CriteriaCompo();
        $criteriaNoRecur->add(new Criteria('event_start', $now, '>='));
        $criteriaNoRecur->add(new Criteria('event_isrecur', 0));

        $criteriaRecur = new CriteriaCompo();
        $criteriaRecur->add(new Criteria('event_recur_start', $now, '>='));
        $criteriaRecur->add(new Criteria('event_isrecur', 1));

        $criteriaCompoDate = new CriteriaCompo();
        $criteriaCompoDate->add($criteriaNoRecur, 'OR');
        $criteriaCompoDate->add($criteriaRecur, 'OR');

        $criteriaCompo = new CriteriaCompo();
        $criteriaCompo->add($criteriaCompoDate);

        $criteriaCompo->add(new Criteria('event_approved', 1));
        $this->_addCatSelectCriteria($criteriaCompo, $cat);
        $this->_addCatPermCriteria($criteriaCompo, $GLOBALS['xoopsUser']);


        $criteriaCompo->setSort('event_start');
        $criteriaCompo->setLimit($nbEvent);
        return $this->getObjects($criteriaCompo);
    }

    // Return event occuring this day
    function getThisDayEvent($nbEvent, $cat = 0)
    {
        $day = date("j");
        $month = date("n");
        $year = date("Y");

        $dayStart = mktime(0, 0, 0, $month, $day, $year);
        $dayEnd = mktime(0, 0, 0, $month, $day + 1, $year);

        $criteriaCompo = new CriteriaCompo();
        $this->_addCatSelectCriteria($criteriaCompo, $cat);
        $this->_addCatPermCriteria($criteriaCompo, $GLOBALS['xoopsUser']);
        $criteriaCompo->add(new Criteria('event_end', $dayStart, '>='));
        $criteriaCompo->add(new Criteria('event_start', $dayEnd, '<'));
        $criteriaCompo->add(new Criteria('event_approved', 1));
        $criteriaCompo->setSort('event_start');
        $criteriaCompo->setLimit($nbEvent);
        return $this->getObjects($criteriaCompo);
    }

    // Return last added event
    function getNewEvent($start, $limit, $cat = 0, $skipPerm = false)
    {
        $criteriaCompo = new CriteriaCompo();
        $this->_addCatSelectCriteria($criteriaCompo, $cat);
        if (!$skipPerm) {
            $this->_addCatPermCriteria($criteriaCompo, $GLOBALS['xoopsUser']);
        }
        $criteriaCompo->add(new Criteria('event_approved', 1));
        $criteriaCompo->setSort('event_id');
        $criteriaCompo->setOrder('DESC');
        $criteriaCompo->setStart($start);
        $criteriaCompo->setLimit($limit);
        return $this->getObjects($criteriaCompo);
    }

    function getCountNewEvent()
    {
        $criteriaCompo = new CriteriaCompo();
        $this->_addCatSelectCriteria($criteriaCompo, 0);
        $criteriaCompo->add(new Criteria('event_approved', 1));
        $criteriaCompo->setSort('event_id');
        return $this->getCount($criteriaCompo);
    }

    // Return random upcomming event
    function getRandomEvent($nbEvent, $cat = 0)
    {
        $criteriaCompo = new CriteriaCompo();
        $this->_addCatSelectCriteria($criteriaCompo, $cat);
        $this->_addCatPermCriteria($criteriaCompo, $GLOBALS['xoopsUser']);
        $criteriaCompo->add(new Criteria('event_start', time(), '>='));
        $criteriaCompo->add(new Criteria('event_approved', 1));
        $criteriaCompo->setSort('RAND()');
        $criteriaCompo->setLimit($nbEvent);
        return $this->getObjects($criteriaCompo);
    }

    function getPendingEvent()
    {
        $criteriaCompo = new CriteriaCompo();
        $criteriaCompo->add(new Criteria('event_approved', 0));
        $criteriaCompo->setSort('event_start');
        return $this->getObjects($criteriaCompo);
    }

    function _addCatPermCriteria(&$criteria, &$user)
    {
        $authorizedAccessCats = $this->_extcalPerm->getAuthorizedCat($user, 'extcal_cat_view');
        $count = count($authorizedAccessCats);
        if ($count > 0) {
            $in = '(' . $authorizedAccessCats[0];
            array_shift($authorizedAccessCats);
            foreach (
                $authorizedAccessCats as $authorizedAccessCat
            ) {
                $in .= ',' . $authorizedAccessCat;
            }
            $in .= ')';
            $criteria->add(new Criteria('cat_id', $in, 'IN'));
        } else {
            $criteria->add(new Criteria('cat_id', '(0)', 'IN'));
        }
    }

    function _addCatSelectCriteria(&$criteria, $cats)
    {
        if (!is_array($cats) && $cats > 0) {
            $criteria->add(new Criteria('cat_id', $cats));
        }
        if (is_array($cats)) {
            if (array_search(0, $cats) === false) {
                $in = '(' . current($cats);
                array_shift($cats);
                foreach (
                    $cats as $cat
                ) {
                    $in .= ',' . $cat;
                }
                $in .= ')';
                $criteria->add(new Criteria('cat_id', $in, 'IN'));
            }
        }
    }

    function getEventForm($siteSide = 'user', $mode = 'new', $data = null)
    {

        $catHandler = xoops_getmodulehandler('cat', 'extcal');
        $fileHandler = xoops_getmodulehandler('file', 'extcal');

        if ($siteSide == 'admin') {
            $action = 'event.php?op=enreg';
            $cats = $catHandler->getAllCat($GLOBALS['xoopsUser'], 'all');
        } else {
            $action = 'post.php';
            $cats = $catHandler->getAllCat($GLOBALS['xoopsUser']);
        }

        $reccurOptions = array();

        if ($mode == 'edit') {
            if (!$event = $this->getEventWithNotApprove($data['event_id'])) {
                return false;
            }

            $formTitle = _MD_EXTCAL_EDIT_EVENT;
            $formName = 'modify_event';
            $title = $event->getVar('event_title', 'e');
            $cat = $event->getVar('cat_id');
            $desc = $event->getVar('event_desc', 'e');
            $nbMember = $event->getVar('event_nbmember', 'e');
            $contact = $event->getVar('event_contact', 'e');
            $url = $event->getVar('event_url', 'e');
            $email = $event->getVar('event_email', 'e');
            $address = $event->getVar('event_address', 'e');
            $startDateValue = xoops_getUserTimestamp($event->getVar('event_start'), $this->_extcalTime->_getUserTimeZone($GLOBALS['xoopsUser']));
            $endDateValue = xoops_getUserTimestamp($event->getVar('event_end'), $this->_extcalTime->_getUserTimeZone($GLOBALS['xoopsUser']));

            // Configuring recurring form
            $eventOptions = explode('|', $event->getVar('event_recur_rules'));
            $reccurMode = $eventOptions[0];
            array_shift($eventOptions);
            switch ($reccurMode) {

                case 'daily':

                    $reccurOptions['rrule_freq'] = 'daily';
                    $reccurOptions['rrule_daily_interval'] = $eventOptions[0];

                    break;

                case 'weekly':

                    $reccurOptions['rrule_freq'] = 'weekly';
                    $reccurOptions['rrule_weekly_interval'] = $eventOptions[0];
                    array_shift($eventOptions);
                    $reccurOptions['rrule_weekly_bydays'] = $eventOptions;

                    break;

                case 'monthly':

                    $reccurOptions['rrule_freq'] = 'monthly';
                    $reccurOptions['rrule_monthly_interval'] = $eventOptions[0];
                    array_shift($eventOptions);
                    if (substr($eventOptions[0], 0, 2) != "MD") {
                        $reccurOptions['rrule_monthly_byday'] = $eventOptions[0];
                    } else {
                        $reccurOptions['rrule_bymonthday'] = substr($eventOptions[0], 2);
                    }

                    break;

                case 'yearly':

                    $reccurOptions['rrule_freq'] = 'yearly';
                    $reccurOptions['rrule_yearly_interval'] = $eventOptions[0];
                    array_shift($eventOptions);
                    $reccurOptions['rrule_yearly_byday'] = $eventOptions[0];
                    array_shift($eventOptions);
                    $reccurOptions['rrule_yearly_bymonths'] = $eventOptions;

                    break;

            }

            $files = $fileHandler->objectToArray($fileHandler->getEventFiles($data['event_id']));
            $fileHandler->formatFilesSize($files);

        } elseif ($mode == 'preview') {

            $formTitle = _MD_EXTCAL_SUBMIT_EVENT;
            $formName = 'submit_event';
            $title = $data['event_title'];
            $cat = $data['cat_id'];
            $desc = $data['event_desc'];
            $nbMember = $data['event_nbmember'];
            $contact = $data['event_contact'];
            $url = $data['event_url'];
            $email = $data['event_email'];
            $address = $data['event_address'];
            $startDateValue = $data['event_start'];
            $endDateValue = $data['event_end'];
            $eventEndOk = $data['have_end'];

            // Configuring recurring form
            $eventOptions = explode('|', $this->getRecurRules($_POST));
            $reccurMode = $eventOptions[0];
            array_shift($eventOptions);
            switch ($reccurMode) {

                case 'daily':

                    $reccurOptions['rrule_freq'] = 'daily';
                    $reccurOptions['rrule_daily_interval'] = $eventOptions[0];

                    break;

                case 'weekly':

                    $reccurOptions['rrule_freq'] = 'weekly';
                    $reccurOptions['rrule_weekly_interval'] = $eventOptions[0];
                    array_shift($eventOptions);
                    $reccurOptions['rrule_weekly_bydays'] = $eventOptions;

                    break;

                case 'monthly':

                    $reccurOptions['rrule_freq'] = 'monthly';
                    $reccurOptions['rrule_monthly_interval'] = $eventOptions[0];
                    array_shift($eventOptions);
                    if (substr($eventOptions[0], 0, 2) != "MD") {
                        $reccurOptions['rrule_monthly_byday'] = $eventOptions[0];
                    } else {
                        $reccurOptions['rrule_bymonthday'] = substr($eventOptions[0], 2);
                    }

                    break;

                case 'yearly':

                    $reccurOptions['rrule_freq'] = 'yearly';
                    $reccurOptions['rrule_yearly_interval'] = $eventOptions[0];
                    array_shift($eventOptions);
                    $reccurOptions['rrule_yearly_byday'] = $eventOptions[0];
                    array_shift($eventOptions);
                    $reccurOptions['rrule_yearly_bymonths'] = $eventOptions;

                    break;

            }

            $files = $fileHandler->objectToArray($fileHandler->getEventFiles($data['event_id']));
            $fileHandler->formatFilesSize($files);

        } else {
            $formTitle = _MD_EXTCAL_SUBMIT_EVENT;
            $formName = 'submit_event';
            $title = '';
            $cat = '';
            $desc = '';
            $nbMember = 0;
            $contact = '';
            $url = '';
            $email = '';
            $address = '';
            $startDateValue = 0;
            $endDateValue = 0;
            $eventEndOk = 0;
            $files = array();

        }

        // Create XoopsForm Object
        $form = new ExtcalThemeForm($formTitle, 'event_form', $action, 'post', true);
        // Add this extra to allow file upload
        $form->setExtra('enctype="multipart/form-data"');
        // Category select
        $catSelect = new XoopsFormSelect(_MD_EXTCAL_CATEGORY, 'cat_id', $cat);
        foreach (
            $cats as $cat
        ) {
            $catSelect->addOption($cat->getVar('cat_id'), $cat->getVar('cat_name'));
        }
        $form->addElement($catSelect, true);
        // Title
        $form->addElement(new XoopsFormText(_MD_EXTCAL_TITLE, 'event_title', 30, 255, $title), true);
        // Start and end
        new ExtcalFormDateTime($form, $startDateValue, $endDateValue);
        // Description
        $form->addElement(new XoopsFormDhtmlTextArea(_MD_EXTCAL_DESCRIPTION, 'event_desc', $desc, 10), false);
        // Max registered member for this event
        $nbMemberElement = new XoopsFormText(_MD_EXTCAL_NBMEMBER, 'event_nbmember', 4, 4, $nbMember);
        $nbMemberElement->setDescription(_MD_EXTCAL_NBMEMBER_DESC);
        $form->addElement($nbMemberElement, false);
        // Contact
        $form->addElement(new XoopsFormText(_MD_EXTCAL_CONTACT, 'event_contact', 30, 255, $contact), false);
        // Url
        $form->addElement(new XoopsFormText(_MD_EXTCAL_URL, 'event_url', 30, 255, $url), false);
        // Email
        $form->addElement(new XoopsFormText(_MD_EXTCAL_EMAIL, 'event_email', 30, 255, $email), false);
        // Address
        $form->addElement(new XoopsFormDhtmlTextArea(_MD_EXTCAL_ADDRESS, 'event_address', $address), false);
        // Recurence form
        $form->addElement(new ExtcalFormRecurRules($reccurOptions));
        // File attachement
        $fileElmtTray = new XoopsFormElementTray(_MD_EXTCAL_FILE_ATTACHEMENT, "<br />");

        // If they are attached file to this event
        if (count($files) > 0) {
            $eventFiles = new ExtcalFormFileCheckBox('', 'filetokeep');
            foreach (
                $files as $file
            ) {
                $name
                    = $file['file_nicename'] . " (<i>" . $file['file_mimetype']
                    . "</i>) " . $file['formated_file_size'];
                $eventFiles->addOption($file['file_id'], $name);
            }
            $fileElmtTray->addElement($eventFiles);
        }
        $fileElmtTray->addElement(new XoopsFormFile(_MD_EXTCAL_FILE_ATTACHEMENT, 'event_file', 3145728));
        $form->addElement($fileElmtTray);

        if (isset($data['event_id'])) {
            $form->addElement(new XoopsFormHidden('event_id', $data['event_id']), false);
        }

        $buttonElmtTray = new XoopsFormElementTray('', "&nbsp;");
        $buttonElmtTray->addElement(new XoopsFormButton("", "form_submit", _SEND, "submit"), false);
        if ($siteSide == 'user') {
            $buttonElmtTray->addElement(new XoopsFormButton("", "form_preview", _MD_EXTCAL_PREVIEW, "submit"), false);
        }
        $form->addElement($buttonElmtTray);

        return $form;

    }

    function getIsRecur($parm)
    {

        $recurFreq = array('daily', 'weekly', 'monthly', 'yearly');
        return in_array($parm['rrule_freq'], $recurFreq);

    }

    function getRecurRules($parm)
    {

        // If this isn't a reccuring event
        if (!$this->getIsRecur($parm)) {
            return '';
        }

        $recurRules = '';

        $recurFreq = $parm['rrule_freq'];

        switch ($recurFreq) {

            case 'daily':

                $recurRules = 'daily|';
                $recurRules .= $parm['rrule_daily_interval'];

                break;

            case 'weekly':

                $recurRules = 'weekly|';
                $recurRules .= $parm['rrule_weekly_interval'];
                foreach (
                    $parm['rrule_weekly_bydays'] as $day
                ) {
                    $recurRules .= '|' . $day;
                }

                break;

            case 'monthly':

                $recurRules = 'monthly|';
                $recurRules .= $parm['rrule_monthly_interval'] . '|';
                if ($parm['rrule_monthly_byday'] != "") {
                    $recurRules .= $parm['rrule_monthly_byday'];
                } else {
                    $recurRules .= "MD" . $parm['rrule_bymonthday'];
                }

                break;

            case 'yearly':

                if ($parm['rrule_yearly_byday'] == "") {
                    list($year, $month, $day) = explode("-", $parm['event_start']['date']);
                    $parm['rrule_yearly_byday'] = date("j", mktime(0, 0, 0, $month, $day, $year));
                }

                $recurRules = 'yearly|';
                $recurRules .= $parm['rrule_yearly_interval'];
                $recurRules .= '|' . $parm['rrule_yearly_byday'];
                foreach (
                    $parm['rrule_yearly_bymonths'] as $month
                ) {
                    $recurRules .= '|' . $month;
                }

                break;

        }

        return $recurRules;

    }

    function getRecurStart($data, $parm)
    {

        // If this isn't a reccuring event
        if (!$this->getIsRecur($parm)) {
            return 0;
        }

        return $data['event_start'];

    }

    function getRecurEnd($data, $parm)
    {

        // If this isn't a reccuring event
        if (!$this->getIsRecur($parm)) {
            return 0;
        }

        $recurFreq = $parm['rrule_freq'];

        $recurStart = $this->getRecurStart($data, $parm);

        switch ($recurFreq) {

            case 'daily':

                $interval = $parm['rrule_daily_interval'];
                $recurEnd = $recurStart + ($interval * 86400) - 1;

                break;

            case 'weekly':

                global $xoopsModuleConfig;

                // Getting the first weekday TS
                $startWeekTS = mktime(0, 0, 0, date('n', $data['event_recur_start']), date('j', $data['event_recur_start']), date('Y', $data['event_recur_start']));
                $offset = date('w', $startWeekTS)
                    - $xoopsModuleConfig['week_start_day'];
                $startWeekTS = $startWeekTS - ($offset * 86400);

                $recurEnd
                    = $startWeekTS + ($parm['rrule_weekly_interval'] * 604800)
                    - 1;

                break;

            case 'monthly':

                $recurEnd
                    = $recurStart + ($parm['rrule_monthly_interval'] * 2678400)
                    - 1;

                break;

            case 'yearly':

                $recurEnd
                    = $recurStart + ($parm['rrule_yearly_interval'] * 32140800)
                    - 1;

                break;

        }

        return $recurEnd;

    }

    function getRecurEventToDisplay(&$event, $periodStart, $periodEnd)
    {

        $recuEvents = array();
        $eventOptions = explode('|', $event['event_recur_rules']);

        switch ($eventOptions[0]) {

            case 'daily':

                array_shift($eventOptions);
                $rRuleDailyInterval = $eventOptions[0];

                $occurEventStart = $event['event_recur_start'];
                $occurEventEnd = $event['event_recur_start'] + (
                    $event['event_end'] - $event['event_start']);

                $nbOccur = 0;
                // This variable is used to stop the loop after we add all occur on the view to keep good performance
                $isOccurOnPeriod = false;
                // Parse all occurence of this event
                while ($nbOccur < $rRuleDailyInterval) {
                    // Add this event occurence only if it's on the period view
                    if // Event start falls within search period
                    ($occurEventStart <= $periodEnd
                        && // Event end falls within search period
                        $occurEventEnd >= $periodStart
                    ) {

                        $event['event_start'] = $occurEventStart;
                        $event['event_end'] = $occurEventEnd;

                        $recuEvents[] = $event;
                        $isOccurOnPeriod = true;
                    } elseif ($isOccurOnPeriod) {
                        break;
                    }

                    $occurEventStart += 86400;
                    $occurEventEnd += 86400;

                    $nbOccur++;
                }

                break;

            case 'weekly':

                global $xoopsModuleConfig;

                array_shift($eventOptions);
                $rRuleWeeklyInterval = $eventOptions[0];
                array_shift($eventOptions);

                // Getting the first weekday TS
                $startWeekTS = mktime(0, 0, 0, date('n', $event['event_recur_start']), date('j', $event['event_recur_start']), date('Y', $event['event_recur_start']));
                $offset = date('w', $startWeekTS)
                    - $xoopsModuleConfig['week_start_day'];
                $startWeekTS = $startWeekTS - ($offset * 86400) + 604800;

                $occurEventStart = $event['event_recur_start'];
                $occurEventEnd = $event['event_recur_start'] + (
                    $event['event_end'] - $event['event_start']);

                $dayArray = array('SU', 'MO', 'TU', 'WE', 'TH', 'FR', 'SA');

                $nbOccur = 0;

                // Parse all occurence of this event
                while ($nbOccur < $rRuleWeeklyInterval) {
                    // Add this event occurence only if it's on the period view and according to day
                    if ($occurEventStart <= $periodEnd // Event start falls within search period
                        && $occurEventEnd >= $periodStart // Event end falls within search period
                        && in_array($dayArray[date('w', $occurEventStart)], $eventOptions)) // This week day is selected
                     {
                        $event['event_start'] = $occurEventStart;
                        $event['event_end'] = $occurEventEnd;

                        $recuEvents[] = $event;
                    }

                    $occurEventStart += 86400;
                    $occurEventEnd += 86400;

                    if ($occurEventStart >= $startWeekTS) {
                        $nbOccur++;
                        $startWeekTS += 604800;
                    }
                }

                break;

            case 'monthly':

                array_shift($eventOptions);
                $rRuleMonthlyInterval = $eventOptions[0];
                array_shift($eventOptions);

                $day = date('j', $event['event_recur_start']);
                $month = date('n', $event['event_recur_start']);
                $year = date('Y', $event['event_recur_start']);

                $nbOccur = 0;

                $eventHourOccurStart = $event['event_recur_start']
                    - mktime(0, 0, 0, $month, $day, $year);
                $eventHourOccurEnd
                    = $event['event_end'] - $event['event_start'];

                // Parse all occurence of this event
                while ($nbOccur < $rRuleMonthlyInterval) {

                    $eventDayOccurStart = $this->_getOccurTS($month, $year, $eventOptions[0]);
                    if (!$eventDayOccurStart) {
                        $eventDayOccurStart = mktime(0, 0, 0, $month, $day, $year);
                    }

                    $occurEventStart
                        = $eventDayOccurStart + $eventHourOccurStart;
                    $occurEventEnd = $eventDayOccurStart + $eventHourOccurEnd;

                    if // Event start falls within search period
                    ($occurEventStart <= $periodEnd
                        && // Event end falls within search period
                        $occurEventEnd >= $periodStart
                        && // This occur is after start reccur date
                        $occurEventStart >= $event['event_recur_start']
                    ) {

                        $event['event_start'] = $occurEventStart;
                        $event['event_end'] = $occurEventEnd;

                        $recuEvents[] = $event;
                    } elseif ($occurEventStart > $periodEnd) {
                        break;
                    }

                    if (++$month == 13) {
                        $month = 1;
                        $year++;
                    }

                    $nbOccur++;

                }

                break;

            case 'yearly':

                array_shift($eventOptions);
                $rRuleMonthlyInterval = $eventOptions[0];
                array_shift($eventOptions);
                $dayCode = $eventOptions[0];
                array_shift($eventOptions);

                $day = date('j', $event['event_recur_start']);
                $month = date('n', $event['event_recur_start']);
                $year = date('Y', $event['event_recur_start']);

                $nbOccur = 0;

                $eventHourOccurStart = $event['event_recur_start']
                    - mktime(0, 0, 0, $month, $day, $year);
                $eventHourOccurEnd
                    = $event['event_end'] - $event['event_start'];

                // If recurring month not specified, make it starting month
                if (!count($eventOptions)) {
                    $eventOptions[] = $month;
                }

                // Parse all occurence of this event
                while ($nbOccur < $rRuleMonthlyInterval) {

                    $eventDayOccurStart = $this->_getOccurTS($month, $year, $dayCode);
                    if (!$eventDayOccurStart) {
                        $eventDayOccurStart = mktime(0, 0, 0, $month, $day, $year);
                    }

                    $occurEventStart
                        = $eventDayOccurStart + $eventHourOccurStart;
                    $occurEventEnd = $eventDayOccurStart + $eventHourOccurEnd;

                    if // Event start falls within search period
                    (($occurEventStart <= $periodEnd)
                        && // Event end falls within search period
                        ($occurEventEnd >= $periodStart)
                        && // This week day is selected
                        in_array($month, $eventOptions)
                    ) {

                        $event['event_start'] = $occurEventStart;
                        $event['event_end'] = $occurEventEnd;

                        $recuEvents[] = $event;
                    } elseif ($occurEventStart > $periodEnd) {
                        break;
                    }

                    if (++$month == 13) {
                        $month = 1;
                        $year++;
                        $nbOccur++;
                    }

                }

                break;

        }

        return $recuEvents;

    }

    function _getOccurTS($month, $year, $dayCode)
    {

        if (substr($dayCode, 0, 2) == 'MD') {

            if (substr($dayCode, 2) != "") {
                return mktime(0, 0, 0, $month, substr($dayCode, 2), $year);
            } else {
                return 0;
            }

        } else {

            switch ($dayCode) {

                case '1SU':

                    $ts = mktime(0, 0, 0, $month, 1, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 0) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '1MO':

                    $ts = mktime(0, 0, 0, $month, 1, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 1) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '1TU':

                    $ts = mktime(0, 0, 0, $month, 1, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 2) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '1WE':

                    $ts = mktime(0, 0, 0, $month, 1, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 3) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '1TH':

                    $ts = mktime(0, 0, 0, $month, 1, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 4) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '1FR':

                    $ts = mktime(0, 0, 0, $month, 1, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 5) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '1SA':

                    $ts = mktime(0, 0, 0, $month, 1, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 6) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '2SU':

                    $ts = mktime(0, 0, 0, $month, 7, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 0) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '2MO':

                    $ts = mktime(0, 0, 0, $month, 7, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 1) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '2TU':

                    $ts = mktime(0, 0, 0, $month, 7, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 2) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '2WE':

                    $ts = mktime(0, 0, 0, $month, 7, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 3) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '2TH':

                    $ts = mktime(0, 0, 0, $month, 7, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 4) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '2FR':

                    $ts = mktime(0, 0, 0, $month, 7, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 5) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '2SA':

                    $ts = mktime(0, 0, 0, $month, 7, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 6) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '3SU':

                    $ts = mktime(0, 0, 0, $month, 14, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 0) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '3MO':

                    $ts = mktime(0, 0, 0, $month, 14, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 1) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '3TU':

                    $ts = mktime(0, 0, 0, $month, 14, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 2) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '3WE':

                    $ts = mktime(0, 0, 0, $month, 14, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 3) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '3TH':

                    $ts = mktime(0, 0, 0, $month, 14, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 4) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '3FR':

                    $ts = mktime(0, 0, 0, $month, 14, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 5) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '3SA':

                    $ts = mktime(0, 0, 0, $month, 14, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 6) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '4SU':

                    $ts = mktime(0, 0, 0, $month, 21, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 0) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '4MO':

                    $ts = mktime(0, 0, 0, $month, 21, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 1) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '4TU':

                    $ts = mktime(0, 0, 0, $month, 21, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 2) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '4WE':

                    $ts = mktime(0, 0, 0, $month, 21, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 3) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '4TH':

                    $ts = mktime(0, 0, 0, $month, 21, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 4) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '4FR':

                    $ts = mktime(0, 0, 0, $month, 21, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 5) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '4SA':

                    $ts = mktime(0, 0, 0, $month, 21, $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 6) {
                        $dayOfWeek++;
                        $i++;
                    }
                    return $ts + (86400 * $i);

                    break;

                case '-1SU':

                    $ts = mktime(0, 0, 0, $month, date('t', mktime(0, 0, 0, $month, 1, $year)), $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 0) {
                        $dayOfWeek++;
                        $i++;
                    }
                    if ($i == 0) {
                        return $ts;
                    }
                    return $ts + (86400 * ($i - 7));

                    break;

                case '-1MO':

                    $ts = mktime(0, 0, 0, $month, date('t', mktime(0, 0, 0, $month, 1, $year)), $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 1) {
                        $dayOfWeek++;
                        $i++;
                    }
                    if ($i == 0) {
                        return $ts;
                    }
                    return $ts + (86400 * ($i - 7));

                    break;

                case '-1TU':

                    $ts = mktime(0, 0, 0, $month, date('t', mktime(0, 0, 0, $month, 1, $year)), $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 2) {
                        $dayOfWeek++;
                        $i++;
                    }
                    if ($i == 0) {
                        return $ts;
                    }
                    return $ts + (86400 * ($i - 7));

                    break;

                case '-1WE':

                    $ts = mktime(0, 0, 0, $month, date('t', mktime(0, 0, 0, $month, 1, $year)), $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 3) {
                        $dayOfWeek++;
                        $i++;
                    }
                    if ($i == 0) {
                        return $ts;
                    }
                    return $ts + (86400 * ($i - 7));

                    break;

                case '-1TH':

                    $ts = mktime(0, 0, 0, $month, date('t', mktime(0, 0, 0, $month, 1, $year)), $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 4) {
                        $dayOfWeek++;
                        $i++;
                    }
                    if ($i == 0) {
                        return $ts;
                    }
                    return $ts + (86400 * ($i - 7));

                    break;

                case '-1FR':

                    $ts = mktime(0, 0, 0, $month, date('t', mktime(0, 0, 0, $month, 1, $year)), $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 5) {
                        $dayOfWeek++;
                        $i++;
                    }
                    if ($i == 0) {
                        return $ts;
                    }
                    return $ts + (86400 * ($i - 7));

                    break;

                case '-1SA':

                    $ts = mktime(0, 0, 0, $month, date('t', mktime(0, 0, 0, $month, 1, $year)), $year);
                    $dayOfWeek = date('w', $ts);
                    $i = 0;
                    while ($dayOfWeek % 7 != 6) {
                        $dayOfWeek++;
                        $i++;
                    }
                    if ($i == 0) {
                        return $ts;
                    }
                    return $ts + (86400 * ($i - 7));

                    break;

                default:

                    return 0;

                    break;

            }

        }

    }

    function getSearchEvent(
        $queryarray, $andor, $limit, $offset, $userId, $user
    )
    {
        global $xoopsDB;

        $sql
            =
            "SELECT event_id, event_title, event_submitter, event_submitdate FROM "
                . $xoopsDB->prefix("extcal_event")
                . " WHERE event_approved = '1'";
        $authorizedAccessCats = $this->_extcalPerm->getAuthorizedCat($user, 'extcal_cat_view');
        $count = count($authorizedAccessCats);
        if ($count > 0) {
            $in = '(' . $authorizedAccessCats[0];
            array_shift($authorizedAccessCats);
            foreach (
                $authorizedAccessCats as $authorizedAccessCat
            ) {
                $in .= ',' . $authorizedAccessCat;
            }
            $in .= ')';
        } else {
            $in = '(0)';
        }
        $sql .= " AND cat_id IN " . $in . "";
        if ($userId != 0) {
            $sql .= " AND event_submitter = '" . $userId . "'";
        }
        if (is_array($queryarray) && $count = count($queryarray)) {
            $sql .= " AND ((event_title LIKE '%$queryarray[0]%' OR event_desc LIKE '%$queryarray[0]%' OR event_contact LIKE '%$queryarray[0]%' OR event_address LIKE '%$queryarray[0]%')";
            for (
                $i = 1; $i < $count; $i++
            ) {
                $sql .= " $andor ";
                $sql .= "(event_title LIKE '%$queryarray[0]%' OR event_desc LIKE '%$queryarray[0]%' OR event_contact LIKE '%$queryarray[0]%' OR event_address LIKE '%$queryarray[0]%')";
            }
            $sql .= ") ";
        }
        $sql .= " ORDER BY event_id DESC";
        $result = $xoopsDB->query($sql, $limit, $offset);
        $ret = array();
        $i = 0;
        while ($myrow = $xoopsDB->fetchArray($result)) {
            $ret[$i]['image'] = "images/icons/extcal.gif";
            $ret[$i]['link'] = "event.php?event=" . $myrow['event_id'];
            $ret[$i]['title'] = $myrow['event_title'];
            $ret[$i]['time'] = $myrow['event_submitdate'];
            $ret[$i]['uid'] = $myrow['event_submitter'];
            $i++;
        }
        return $ret;
    }

    function addEventToCalArray(
        &$event, &$eventsArray, $startPeriod, $endPeriod
    )
    {

        global $extcalTimeHandler, $xoopsUser, $month, $year;

        // Calculating the start and the end of the event
        $startEvent = $event['event_start'];
        $endEvent = $event['event_end'];

        // This event start before this month and finish after
        if ($startEvent < $startPeriod && $endEvent > $endPeriod) {
            $endFor = date('t', mktime(0, 0, 0, $month, 1, $year));
            for (
                $i = 1; $i <= $endFor; $i++
            ) {
                $event['status'] = 'middle';
                $eventsArray[$i][] = $event;
            }
            // This event start before this month and finish during
        } else {
            if ($startEvent < $startPeriod) {
                $endFor = date('j', $endEvent);
                for (
                    $i = 1; $i <= $endFor; $i++
                ) {
                    $event['status'] = ($i != $endFor) ? 'middle' : 'end';
                    $eventsArray[$i][] = $event;
                }
                // This event start during this month and finish after
            } else {
                if ($endEvent > $endPeriod) {
                    $startFor = date('j', $startEvent);
                    $endFor = date('t', mktime(0, 0, 0, $month, 1, $year));
                    for (
                        $i = $startFor; $i <= $endFor; $i++
                    ) {
                        $event['status'] = ($i == $startFor) ? 'start'
                            : 'middle';
                        $eventsArray[$i][] = $event;
                    }
                    // This event start and finish during this month
                } else {
                    $startFor = date('j', $startEvent);
                    $endFor = date('j', $endEvent);
                    for (
                        $i = $startFor; $i <= $endFor; $i++
                    ) {
                        if ($startFor == $endFor) {
                            $event['status'] = 'single';
                        } else {
                            if ($i == $startFor) {
                                $event['status'] = 'start';
                            } else {
                                if ($i == $endFor) {
                                    $event['status'] = 'end';
                                } else {
                                    $event['status'] = 'middle';
                                }
                            }
                        }
                        $eventsArray[$i][] = $event;
                    }
                }
            }
        }

    }

}
?>
