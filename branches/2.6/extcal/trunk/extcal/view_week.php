<?php

include '../../mainfile.php';

if (!defined('CALENDAR_ROOT')) {
    define('CALENDAR_ROOT',
        XOOPS_ROOT_PATH . '/modules/extcal/class/pear/Calendar/');
}
include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once ('include/constantes.php');
include_once ('include/agenda_fnc.php');

$params = array('view' => _EXTCAL_NAV_WEEK, 'file' => _EXTCAL_FILE_WEEK);
$GLOBALS['xoopsOption']['template_main'] = "extcal_view_{$params['view']}.html";
include XOOPS_ROOT_PATH . '/header.php';
/* ========================================================================== */
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
$month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
$day = isset($_GET['day']) ? intval($_GET['day']) : date('j');
$cat = isset($_GET['cat']) ? intval($_GET['cat']) : 0;

require_once CALENDAR_ROOT . 'Week.php';
include_once ('include/agenda_fnc.php');

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
$form->addElement(new XoopsFormButton("", "", _SEND, "submit"));
 
// Assigning the form to the template
$form->assign($xoopsTpl);

// Retriving events
$events = $eventHandler->objectToArray($eventHandler->getEventWeek($day, $month, $year, $cat), array('cat_id'));
$eventHandler->serverTimeToUserTimes($events);

// Formating date
$eventHandler->formatEventsDate($events, $xoopsModuleConfig['event_date_year']);

// Treatment for recurring event
$startWeek = mktime(0, 0, 0, $month, $day, $year);
$endWeek = $startWeek + 604800;

$eventsArray = array();
foreach ($events as $event) {
    if (!$event['event_isrecur']) {
        // Formating date
        $eventHandler->formatEventDate($event, $xoopsModuleConfig['event_date_week']);
        $eventsArray[] = $event;
    } else {
        $recurEvents = $eventHandler->getRecurEventToDisplay($event, $startWeek, $endWeek);
        // Formating date
        $eventHandler->formatEventsDate($recurEvents, $xoopsModuleConfig['event_date_week']);
        $eventsArray = array_merge($eventsArray, $recurEvents);
    }
}

// Sort event array by event start
usort($eventsArray, "orderEvents");

// Assigning events to the template
$xoopsTpl->assign('events', $eventsArray);

// Retriving categories
$cats = $catHandler->objectToArray($catHandler->getAllCat($xoopsUser));
// Assigning categories to the template
$xoopsTpl->assign('cats', $cats);

// Making navig data
$weekCalObj = new Calendar_Week($year, $month, $day, $xoopsModuleConfig['week_start_day']);
$pWeekCalObj = $weekCalObj->prevWeek('object');
$nWeekCalObj = $weekCalObj->nextWeek('object');
$navig = array('prev' => array('uri' => 'year=' . $pWeekCalObj->thisYear() 
                                      . '&amp;month=' . $pWeekCalObj->thisMonth() 
                                      . '&amp;day=' . $pWeekCalObj->thisDay(), 
                               'name' => $extcalTimeHandler->getFormatedDate($xoopsModuleConfig['nav_date_week'], $pWeekCalObj->getTimestamp())), 
               'this' => array('uri'  => 'year=' . $weekCalObj->thisYear() 
                                       . '&amp;month=' . $weekCalObj->thisMonth() 
                                       . '&amp;day=' . $weekCalObj->thisDay(), 
                               'name' => $extcalTimeHandler->getFormatedDate($xoopsModuleConfig['nav_date_week'], $weekCalObj->getTimestamp())), 
               'next' => array('uri'  => 'year=' . $nWeekCalObj->thisYear() 
                                       . '&amp;month=' . $nWeekCalObj->thisMonth() 
                                       . '&amp;day=' . $nWeekCalObj->thisDay(), 
                               'name' => $extcalTimeHandler->getFormatedDate($xoopsModuleConfig['nav_date_week'], $nWeekCalObj->getTimestamp()))
               );

// Title of the page
$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar('name') . ' ' 
                                   . $navig['this']['name']);

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
