<?php

include '../../mainfile.php';

if (!defined('CALENDAR_ROOT')) {
    define('CALENDAR_ROOT',
        XOOPS_ROOT_PATH . '/modules/extcal/class/pear/Calendar/');
}
include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once ('include/constantes.php');
include_once ('include/agenda_fnc.php');

$params = array('view' => _EXTCAL_NAV_CALWEEK, 'file' => _EXTCAL_FILE_CALWEEK);
$GLOBALS['xoopsOption']['template_main'] = "extcal_view_{$params['view']}.html";
include XOOPS_ROOT_PATH . '/header.php';
/* ========================================================================== */
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
$month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
$day = isset($_GET['day']) ? intval($_GET['day']) : date('j');
$cat = isset($_GET['cat']) ? intval($_GET['cat']) : 0;

require_once CALENDAR_ROOT . 'Util/Textual.php';
require_once CALENDAR_ROOT . 'Month/Weeks.php';
require_once CALENDAR_ROOT . 'Week.php';
require_once CALENDAR_ROOT . 'Day.php';

// Validate the date (day, month and year)
$dayTS = mktime(0, 0, 0, $month, $day, $year);
$offset = date('w', $dayTS) - $xoopsModuleConfig['week_start_day'];
$dayTS = $dayTS - ($offset * 86400);
$year = date('Y', $dayTS);
$month = date('n', $dayTS);
$day = date('j', $dayTS);

// Getting eXtCal object's handler
$catHandler = xoops_getmodulehandler('cat', 'extcal');
$eventHandler = xoops_getmodulehandler('event', 'extcal');
$extcalTimeHandler = ExtcalTime::getHandler();

// Tooltips include
$xoTheme->addScript('modules/extcal/include/ToolTips.js');
$xoTheme->addStylesheet('modules/extcal/include/style.css');

$form = new XoopsSimpleForm('', 'navigSelectBox', $params['file'], 'get');
$form->addElement(getListYears($year,$xoopsModuleConfig['agenda_nb_years_before'],$xoopsModuleConfig['agenda_nb_years_after']));
$form->addElement(getListMonths($month));
$form->addElement(getListDays($day));
$form->addElement(getListCategories($cat));
$form->addElement(new XoopsFormButton("", "form_submit", _SEND, "submit"));

// Assigning the form to the template
$form->assign($xoopsTpl);

// Retriving events and formatting them
$events = $eventHandler->objectToArray($eventHandler->getEventCalendarWeek($day, $month, $year, $cat), array('cat_id'));
$eventHandler->serverTimeToUserTimes($events);

// Calculating timestamp for the begin and the end of the month
$startWeek = mktime(0, 0, 0, $month, $day, $year);
$endWeek = $startWeek + 604799;

/*
*  Adding all event occuring during this week to an array indexed by day number
*/
$eventsArray = array();
foreach ($events as $event) {
    if (!$event['event_isrecur']) {
        // Formating date
        $eventHandler->formatEventDate($event, $xoopsModuleConfig['event_date_week']);
        $eventHandler->addEventToCalArray($event, $eventsArray, $startWeek, $endWeek);
    } else {
        $recurEvents = $eventHandler->getRecurEventToDisplay($event, $startWeek, $endWeek);
        // Formating date
        $eventHandler->formatEventsDate($recurEvents, $xoopsModuleConfig['event_date_week']);
        foreach ($recurEvents as $recurEvent) {
            $eventHandler->addEventToCalArray($recurEvent, $eventsArray, $startWeek, $endWeek);
        }
    }
}

/*
*  Making an array to create tabbed output on the template
*/
// Flag current day
$selectedDays = array(
    new Calendar_Day(date('Y', xoops_getUserTimestamp(time(), $extcalTimeHandler->_getUserTimeZone($xoopsUser))), date('n', xoops_getUserTimestamp(time(), $extcalTimeHandler->_getUserTimeZone($xoopsUser))), date('j', xoops_getUserTimestamp(time(), $extcalTimeHandler->_getUserTimeZone($xoopsUser))))
);

// Build calendar object
$weekCalObj = new Calendar_Week($year, $month, $day, $xoopsModuleConfig['week_start_day']);
$pWeekCalObj = $weekCalObj->prevWeek('object');
$nWeekCalObj = $weekCalObj->nextWeek('object');
$weekCalObj->build($selectedDays);

$week = array();
$cellId = 0;
while ($dayCalObj = $weekCalObj->fetch()) {
    $week[$cellId] = array('isEmpty' => $dayCalObj->isEmpty(), 'dayNumber' => $dayCalObj->thisDay(), 'month' => $dayCalObj->thisMonth(), 'year' => $dayCalObj->thisYear(), 'isSelected' => $dayCalObj->isSelected());
    if (@ count($eventsArray[$dayCalObj->thisDay()]) > 0 && !$dayCalObj->isEmpty()) {
        $week[$cellId]['events'] = $eventsArray[$dayCalObj->thisDay()];
    } else {
        $week[$cellId]['events'] = '';
    }
    $cellId++;
}

// Assigning events to the template
$xoopsTpl->assign('week', $week);

// Retriving categories
$cats = $catHandler->objectToArray($catHandler->getAllCat($xoopsUser));
// Assigning categories to the template
$xoopsTpl->assign('cats', $cats);

// Retriving weekdayNames
$weekdayNames = Calendar_Util_Textual::weekdayNames();
for (
    $i = 0; $i < $xoopsModuleConfig['week_start_day']; $i++
) {
    $weekdayName = array_shift($weekdayNames);
    $weekdayNames[] = $weekdayName;
}
// Assigning weekdayNames to the template
$xoopsTpl->assign('weekdayNames', $weekdayNames);

// Retriving monthNames
$monthNames = Calendar_Util_Textual::monthNames();

// Making navig data
$navig = array(
    'prev'
    => array(
        'uri'
        => 'year=' . $pWeekCalObj->thisYear() . '&amp;month='
            . $pWeekCalObj->thisMonth() . '&amp;day='
            . $pWeekCalObj->thisDay(), 'name' => $extcalTimeHandler->getFormatedDate($xoopsModuleConfig['nav_date_week'], $pWeekCalObj->getTimestamp())
    ), 'this'
    => array(
        'uri'
        => 'year=' . $weekCalObj->thisYear() . '&amp;month='
            . $weekCalObj->thisMonth() . '&amp;day='
            . $weekCalObj->thisDay(), 'name' => $extcalTimeHandler->getFormatedDate($xoopsModuleConfig['nav_date_week'], $weekCalObj->getTimestamp())
    ), 'next'
    => array(
        'uri'
        => 'year=' . $nWeekCalObj->thisYear() . '&amp;month='
            . $nWeekCalObj->thisMonth() . '&amp;day='
            . $nWeekCalObj->thisDay(), 'name' => $extcalTimeHandler->getFormatedDate($xoopsModuleConfig['nav_date_week'], $nWeekCalObj->getTimestamp())
    )
);

// Title of the page
$xoopsTpl->assign(
    'xoops_pagetitle',
    $xoopsModule->getVar('name') . ' ' . $navig['this']['name']
);

// Assigning navig data to the template
$xoopsTpl->assign('navig', $navig);

// Assigning current form navig data to the template
$xoopsTpl->assign('selectedCat', $cat);
$xoopsTpl->assign('year', $year);
$xoopsTpl->assign('month', $month);
$xoopsTpl->assign('day', $day);
$xoopsTpl->assign('params', $params);

$tNavBar = getNavBarTabs($cat,$params['view']);
$xoopsTpl->assign('tNavBar', $tNavBar);
// echoArray($tNavBar,true);

include XOOPS_ROOT_PATH . '/footer.php';
?>
