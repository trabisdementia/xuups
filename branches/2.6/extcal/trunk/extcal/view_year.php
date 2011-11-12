<?php

include '../../mainfile.php';

if (!defined('CALENDAR_ROOT')) {
    define('CALENDAR_ROOT',
        XOOPS_ROOT_PATH . '/modules/extcal/class/pear/Calendar/');
}
include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once ('include/constantes.php');
include_once ('include/agenda_fnc.php');

$params = array('view' => _EXTCAL_NAV_YEAR, 'file' => _EXTCAL_FILE_YEAR);
$GLOBALS['xoopsOption']['template_main'] = "extcal_view_{$params['view']}.html";
include XOOPS_ROOT_PATH . '/header.php';
/* ========================================================================== */
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
$cat = isset($_GET['cat']) ? intval($_GET['cat']) : 0;

// Getting eXtCal object's handler
$catHandler = xoops_getmodulehandler('cat', 'extcal');
$eventHandler = xoops_getmodulehandler('event', 'extcal');

// Tooltips include
$xoTheme->addScript('modules/extcal/include/ToolTips.js');
$xoTheme->addStylesheet('modules/extcal/include/style.css');


$form = new XoopsSimpleForm('', 'navigSelectBox', $params['file'], 'get');
$form->addElement(getListYears($year,$xoopsModuleConfig['agenda_nb_years_before'],$xoopsModuleConfig['agenda_nb_years_after']));

$form->addElement(getListCategories($cat));
$form->addElement(new XoopsFormButton("", "form_submit", _SEND, "submit"));

// Assigning the form to the template
$form->assign($xoopsTpl);

// Retriving events
$events = $eventHandler->objectToArray($eventHandler->getEventYear($year, $cat), array('cat_id'));
$eventHandler->serverTimeToUserTimes($events);

// Formating date
$eventHandler->formatEventsDate($events, $xoopsModuleConfig['event_date_year']);

// Treatment for recurring event
$startYear = mktime(0, 0, 0, 1, 1, $year);
$endYear = mktime(23, 59, 59, 12, 31, $year);

$eventsArray = array();
foreach ($events as $event) {
    if (!$event['event_isrecur']) {
        // Formating date
        $eventHandler->formatEventDate($event, $xoopsModuleConfig['event_date_week']);
        $eventsArray[] = $event;
    } else {
        $recurEvents = $eventHandler->getRecurEventToDisplay($event, $startYear, $endYear);
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

$prevYear = $year - 1;
$nexYear = $year + 1;
// Making navig data
$navig = array('prev' => array('uri' => 'year=' . $prevYear, 
                               'name' => $prevYear), 
               'this' => array('uri' => 'year=' . $year, 
                               'name' => $year), 
               'next' => array('uri' => 'year=' . $nexYear, 
                               'name' => $nexYear)
              );

// Title of the page
$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar('name') 
                                     . ' ' . $navig['this']['name']);

// Assigning navig data to the template
$xoopsTpl->assign('navig', $navig);

// Assigning current form navig data to the template
$xoopsTpl->assign('selectedCat', $cat);
$xoopsTpl->assign('year', $year);
$xoopsTpl->assign('params', $params);

$tNavBar = getNavBarTabs($cat,$params['view']);
$xoopsTpl->assign('tNavBar', $tNavBar);
// echoArray($tNavBar,true);

include XOOPS_ROOT_PATH . '/footer.php';
?>
