<?php

if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}
$moduleDirName = basename(dirname(__FILE__));
//include_once('include/constantes.php');
include_once(XOOPS_ROOT_PATH . '/modules/extcal/include/constantes.php');

// @author      Gregory Mage (Aka Mage)
//***************************************************************************************
$modversion['name'] = _MI_EXTCAL_NAME;
$modversion['version'] = '2.27';
$modversion['description'] = _MI_EXTCAL_DESC;
$modversion['credits'] = 'Zoullou';
$modversion['author'] = 'Zoullou, Mage, Mamba, JJ Delalandre';
$modversion['nickname'] = '';
$modversion['website'] = '';
$modversion['license'] = 'GPL see LICENSE';
$modversion['license_url'] = "www.gnu.org/licenses/gpl-2.0.html/";
$modversion['official'] = 0;
$modversion['image'] = 'images/extcal_logo.png';
$modversion['dirname'] = $moduleDirName;
$modversion['status_version'] = 'RC';
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['onInstall'] = 'include/install_function.php';
$modversion['onUpdate'] = 'include/update_function.php';
$modversion['system_menu'] = 1;
$modversion['help'] = 'page=help';
$modversion['dirmoduleadmin'] = 'Frameworks/moduleclasses';
$modversion['icons16'] = 'Frameworks/moduleclasses/icons/16';
$modversion['icons32'] = 'Frameworks/moduleclasses/icons/32';
//***************************************************************************************

//about
$modversion["module_website_url"] = "http://www.xoops.org/";
$modversion["module_website_name"] = "XOOPS";
$modversion["release_date"] = "2011/08/07";
$modversion['module_status'] = "Beta";
$modversion['min_php'] = '5.2';
$modversion['min_xoops'] = "2.5.0";

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Menu
$catHandler = xoops_getmodulehandler('cat', 'extcal');

$modversion['hasMain'] = 1;
if (isset($GLOBALS['xoopsModule'])
    && $GLOBALS['xoopsModule']->getVar('dirname') == "extcal"
) {
    $user = isset($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser'] : null;
    if ($catHandler->haveSubmitRight($user)) {
        $modversion['sub'][0]['name'] = _MI_EXTCAL_SUBMIT_EVENT;
        $modversion['sub'][0]['url'] = "new_event.php";
    }
    /*$i = 1;
     $modversion['sub'][$i]['name'] = "Calendar Month";
     $modversion['sub'][$i]['url'] = _EXTCAL_FILE_CALMONTH;
     $i++;
     $modversion['sub'][$i]['name'] = "Calendar Week";
     $modversion['sub'][$i]['url'] = _EXTCAL_FILE_CALWEEK;
     $i++;
     $modversion['sub'][$i]['name'] = "Year";
     $modversion['sub'][$i]['url'] = _EXTCAL_FILE_YEAR;
     $i++;
     $modversion['sub'][$i]['name'] = "Month";
     $modversion['sub'][$i]['url'] = _EXTCAL_FILE_MONTH;
     $i++;
     $modversion['sub'][$i]['name'] = "Week";
     $modversion['sub'][$i]['url'] = _EXTCAL_FILE_WEEK;
     $i++;
     $modversion['sub'][$i]['name'] = "Day";
     $modversion['sub'][$i]['url'] = _EXTCAL_FILE_DAY;
     $i++;
     $modversion['sub'][$i]['name'] = "agenda week";
     $modversion['sub'][$i]['url'] = _EXTCAL_FILE_AGENDA_WEEK;
     $i++;
     $modversion['sub'][$i]['name'] = "agenda day";
     $modversion['sub'][$i]['url'] = _EXTCAL_FILE_AGENDA_DAY;
    
     */
}

// SQL
$modversion['tables'][1] = "extcal_cat";
$modversion['tables'][2] = "extcal_event";
$modversion['tables'][3] = "extcal_eventmember";
$modversion['tables'][4] = "extcal_eventnotmember";
$modversion['tables'][5] = "extcal_file";

// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'event';
$modversion['comments']['pageName'] = 'event.php';

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "extcal_search";

// Config items
$i = 0;
                                                 
$modversion['config'][$i]['name'] = 'visible_tabs';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_VISIBLE_TABS';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_VISIBLE_TABS_DESC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['default'] = array(_EXTCAL_NAV_CALMONTH,
                                             _EXTCAL_NAV_CALWEEK,
                                             _EXTCAL_NAV_YEAR,
                                             _EXTCAL_NAV_MONTH,
                                             _EXTCAL_NAV_WEEK,
                                             _EXTCAL_NAV_DAY,
                                             _EXTCAL_NAV_AGENDA_WEEK,
                                             _EXTCAL_NAV_AGENDA_DAY);
// $t = print_r($modversion['config'][$i]['default'],true);
// echo _EXTCAL_NAV_CALMONTH . "<br /><pre>{$t}</pre>";
$modversion['config'][$i]['options'] = array('_MI_EXTCAL_NAV_CALMONTH' => _EXTCAL_NAV_CALMONTH, 
                                             '_MI_EXTCAL_NAV_CALWEEK' => _EXTCAL_NAV_CALWEEK, 
                                             '_MI_EXTCAL_NAV_YEAR' => _EXTCAL_NAV_YEAR, 
                                             '_MI_EXTCAL_NAV_MONTH' => _EXTCAL_NAV_MONTH, 
                                             '_MI_EXTCAL_NAV_WEEK' => _EXTCAL_NAV_WEEK, 
                                             '_MI_EXTCAL_NAV_DAY' => _EXTCAL_NAV_DAY,
                                             '_MI_EXTCAL_NAV_AGENDA_WEEK' => _EXTCAL_NAV_AGENDA_WEEK,
                                             '_MI_EXTCAL_NAV_AGENDA_DAY' => _EXTCAL_NAV_AGENDA_DAY
                                             );

$i++;
$modversion['config'][$i]['name'] = 'start_page';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_START_PAGE';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _EXTCAL_FILE_CALMONTH;
$modversion['config'][$i]['options'] = array('_MI_EXTCAL_NAV_CALMONTH' => _EXTCAL_FILE_CALMONTH, 
                                             '_MI_EXTCAL_NAV_CALWEEK' => _EXTCAL_FILE_CALWEEK, 
                                             '_MI_EXTCAL_NAV_YEAR' => _EXTCAL_FILE_YEAR, 
                                             '_MI_EXTCAL_NAV_MONTH' => _EXTCAL_FILE_MONTH, 
                                             '_MI_EXTCAL_NAV_WEEK' => _EXTCAL_FILE_WEEK, 
                                             '_MI_EXTCAL_NAV_DAY' => _EXTCAL_FILE_DAY,
                                             '_MI_EXTCAL_NAV_AGENDA_WEEK' => _EXTCAL_FILE_AGENDA_WEEK,
                                             '_MI_EXTCAL_NAV_AGENDA_DAY' => _EXTCAL_FILE_AGENDA_DAY
                                             );
                                                 
$i++;
$modversion['config'][$i]['name'] = 'week_start_day';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_WEEK_START_DAY';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_WEEK_START_DAY_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['options'] = array('_MI_EXTCAL_SUNDAY' => 0, 
                                             '_MI_EXTCAL_MONDAY' => 1, 
                                             '_MI_EXTCAL_TUESDAY' => 2, 
                                             '_MI_EXTCAL_WEDNESDAY' => 3, 
                                             '_MI_EXTCAL_THURSDAY' => 4, 
                                             '_MI_EXTCAL_FRIDAY' => 5, 
                                             '_MI_EXTCAL_SATURDAY' => 6);
$i++;
$modversion['config'][$i]['name'] = 'rss_cache_time';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_RSS_CACHE_TIME';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_RSS_CACHE_TIME_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60;
$i++;
$modversion['config'][$i]['name'] = 'rss_nb_event';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_RSS_NB_EVENT';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_RSS_NB_EVENT_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;
$i++;
$modversion['config'][$i]['name'] = 'whos_going';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_WHOS_GOING';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_WHOS_GOING_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'whosnot_going';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_WHOSNOT_GOING';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_WHOSNOT_GOING_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'sort_order';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_SORT_ORDER';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_SORT_ORDER_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['options'] = array('_MI_EXTCAL_ASCENDING' => 'ASC', 
                                             '_MI_EXTCAL_DESCENDING' => 'DESC');
$i++;
$modversion['config'][$i]['name'] = 'event_date_year';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_EY_DATE_PATTERN';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_EY_DATE_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_EXTCAL_EY_DATE_PATTERN_VALUE;
$i++;
$modversion['config'][$i]['name'] = 'nav_date_month';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_NM_DATE_PATTERN';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_NM_DATE_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_EXTCAL_NM_DATE_PATTERN_VALUE;
$i++;
$modversion['config'][$i]['name'] = 'event_date_month';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_EM_DATE_PATTERN';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_EM_DATE_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_EXTCAL_EM_DATE_PATTERN_VALUE;
$i++;
$modversion['config'][$i]['name'] = 'nav_date_week';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_NW_DATE_PATTERN';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_NW_DATE_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_EXTCAL_NW_DATE_PATTERN_VALUE;
$i++;
$modversion['config'][$i]['name'] = 'event_date_week';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_EW_DATE_PATTERN';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_EW_DATE_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_EXTCAL_EW_DATE_PATTERN_VALUE;
$i++;
$modversion['config'][$i]['name'] = 'nav_date_day';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_ND_DATE_PATTERN';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_ND_DATE_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_EXTCAL_ND_DATE_PATTERN_VALUE;
$i++;
$modversion['config'][$i]['name'] = 'event_date_day';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_ED_DATE_PATTERN';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_ED_DATE_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_EXTCAL_ED_DATE_PATTERN_VALUE;
$i++;
$modversion['config'][$i]['name'] = 'event_date_event';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_EE_DATE_PATTERN';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_EE_DATE_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_EXTCAL_EE_DATE_PATTERN_VALUE;
$i++;
$modversion['config'][$i]['name'] = 'event_date_block';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_EB_DATE_PATTERN';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_EB_DATE_PATTERN_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_EXTCAL_EB_DATE_PATTERN_VALUE;
$i++;
$modversion['config'][$i]['name'] = 'diplay_past_event_list';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_DISP_PAST_E_LIST';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_DISP_PAST_E_LIST_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'diplay_past_event_cal';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_DISP_PAST_E_CAL';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_DISP_PAST_E_CAL_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'allowed_file_extention';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_FILE_EXTENTION';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_FILE_EXTENTION_DESC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['default'] = array('doc', 'jpg', 'jpeg', 'gif', 'png', 'pdf', 'txt');
$modversion['config'][$i]['options'] = array('ai' => 'ai', 'aif' => 'aif', 'aiff' => 'aiff', 'asc' => 'asc', 'au' => 'au', 'avi' => 'avi', 'bin' => 'bin', 'bmp' => 'bmp', 'class' => 'class', 'csh' => 'csh', 'css' => 'css', 'dcr' => 'dcr', 'dir' => 'dir', 'dll' => 'dll', 'doc' => 'doc', 'dot' => 'dot', 'dtd' => 'dtd', 'dxr' => 'dxr', 'ent' => 'ent', 'eps' => 'eps', 'exe' => 'exe', 'gif' => 'gif', 'gtar' => 'gtar', 'gz' => 'gz', 'hqx' => 'hqx', 'htm' => 'htm', 'html' => 'html', 'ics' => 'ics', 'ifb' => 'ifb', 'jpe' => 'jpe', 'jpeg' => 'jpeg', 'jpg' => 'jpg', 'js' => 'js', 'kar' => 'kar', 'lha' => 'lha', 'lzh' => 'lzh', 'm3u' => 'm3u', 'mid' => 'mid', 'midi' => 'midi', 'mod' => 'mod', 'mov' => 'mov', 'mp1' => 'mp1', 'mp2' => 'mp2', 'mp3' => 'mp3', 'mpe' => 'mpe', 'mpeg' => 'mpeg', 'mpg' => 'mpg', 'pbm' => 'pbm', 'pdf' => 'pdf', 'pgm' => 'pgm', 'php' => 'php', 'php3' => 'php3', 'php5' => 'php5', 'phtml' => 'phtml', 'png' => 'png', 'pnm' => 'pnm', 'ppm' => 'ppm', 'ppt' => 'ppt', 'ps' => 'ps', 'qt' => 'qt', 'ra' => 'ra', 'ram' => 'ram', 'rm' => 'rm', 'rpm' => 'rpm', 'rtf' => 'rtf', 'sgm' => 'sgm', 'sgml' => 'sgml', 'sh' => 'sh', 'sit' => 'sit', 'smi' => 'smi', 'smil' => 'smil', 'snd' => 'snd', 'so' => 'so', 'spl' => 'spl', 'swf' => 'swf', 'tar' => 'tar', 'tcl' => 'tcl', 'tif' => 'tif', 'tiff' => 'tiff', 'tsv' => 'tsv', 'txt' => 'txt', 'wav' => 'wav', 'wbmp' => 'wbmp', 'wbxml' => 'wbxml', 'wml' => 'wml', 'wmlc' => 'wmlc', 'wmls' => 'wmls', 'wmlsc' => 'wmlsc', 'xbm' => 'xbm', 'xht' => 'xht', 'xhtml' => 'xhtml', 'xla' => 'xla', 'xls' => 'xls', 'xlt' => 'xlt', 'xpm' => 'xpm', 'xsl' => 'xsl', 'zip' => 'zip');
$i++;
$modversion['config'][$i]['name'] = 'allow_html';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_HTML';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_HTML_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
//modif JJD ------------------------------------------------------------
$i++;
$modversion['config'][$i]['name'] = 'agenda_tranche_minutes';
$modversion['config'][$i]['title'] = '_MI_AGENDA_SLICE_MINUTES';
$modversion['config'][$i]['description'] = '_MI_AGENDA_SLICE_MINUTES_DESC';
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 15;
$i++;
$modversion['config'][$i]['name'] = 'agenda_start_hour';
$modversion['config'][$i]['title'] = '_MI_AGENDA_START_HOUR';
$modversion['config'][$i]['description'] = '_MI_AGENDA_START_HOUR_DESC';
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 8;
$i++;
$modversion['config'][$i]['name'] = 'agenda_end_hour';
$modversion['config'][$i]['title'] = '_MI_AGENDA_END_HOUR';
$modversion['config'][$i]['description'] = '_MI_AGENDA_END_HOUR_DESC';
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 20;
$i++;
$modversion['config'][$i]['name'] = 'agenda_nb_days_week';
$modversion['config'][$i]['title'] = '_MI_AGENDA_NB_DAYS_WEEK';
$modversion['config'][$i]['description'] = '_MI_AGENDA_NB_DAYS_WEEK_DESC';
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;
$i++;
$modversion['config'][$i]['name'] = 'agenda_nb_days_day';
$modversion['config'][$i]['title'] = '_MI_AGENDA_NB_DAYS_DAY';
$modversion['config'][$i]['description'] = '_MI_AGENDA_NB_DAYS_DAY_DESC';
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'agenda_nb_years_before';
$modversion['config'][$i]['title'] = '_MI_NB_YEARS_BEFORE';
$modversion['config'][$i]['description'] = '_MI_NB_YEARS_BEFORE_DESC';
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'agenda_nb_years_after';
$modversion['config'][$i]['title'] = '_MI_NB_YEARS_AFTER';
$modversion['config'][$i]['description'] = '_MI_NB_YEARS_AFTER_DESC';
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;          

/*
inutilise pour le moment, prevu pur ajout navigation dans minical
*/
$i++;
$modversion['config'][$i]['name'] = 'offsetMinical';
$modversion['config'][$i]['title'] = '_MI_EXTCAL_OFFSET_MINICAL';
$modversion['config'][$i]['description'] = '_MI_EXTCAL_OFFSET_MINICAL_DESC';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

//modif JJD ------------------------------------------------------------

// Templates
$i = 1;
$modversion['templates'][$i]['file'] = 'extcal_view_year.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'extcal_view_month.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'extcal_view_week.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'extcal_view_day.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'extcal_view_calendar-month.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'extcal_view_calendar-week.html';
$modversion['templates'][$i]['description'] = '';
//modif JJD
$i++;
$modversion['templates'][$i]['file'] = 'extcal_view_agenda-day.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'extcal_view_agenda-week.html';
$modversion['templates'][$i]['description'] = '';



$i++;
$modversion['templates'][$i]['file'] = 'extcal_event.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'extcal_post.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'extcal_rss.html';
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = 'extcal_navbar.html';
$modversion['templates'][$i]['description'] = '';


// Blocs
$i = 1;
$modversion['blocks'][$i]['file'] = "extcal_blocks.php";
$modversion['blocks'][$i]['name'] = _MI_EXTCAL_BNAME1;
$modversion['blocks'][$i]['description'] = _MI_EXTCAL_BNAME1_DESC;
$modversion['blocks'][$i]['show_func'] = "bExtcalMinicalShow";
$modversion['blocks'][$i]['options'] = "0|0|150|225|1|3|10|0|1|0";
$modversion['blocks'][$i]['edit_func'] = "bExtcalMinicalEdit";
$modversion['blocks'][$i]['template'] = 'extcal_block_minical.html';
$i++;
//$modversion['blocks'][$i]['file'] = "extcal_blocks.php";
//$modversion['blocks'][$i]['name'] = _MI_EXTCAL_BNAME2;
//$modversion['blocks'][$i]['description'] = _MI_EXTCAL_BNAME2_DESC;
//$modversion['blocks'][$i]['show_func'] = "bExtcalSpotlightShow";
//$modversion['blocks'][$i]['options'] = "0|0|0|1|0";
//$modversion['blocks'][$i]['edit_func'] = "bExtcalSpotlightEdit";
//$modversion['blocks'][$i]['template'] = 'extcal_block_spotlight.html';
//$i++;
$modversion['blocks'][$i]['file'] = "extcal_blocks.php";
$modversion['blocks'][$i]['name'] = _MI_EXTCAL_BNAME3;
$modversion['blocks'][$i]['description'] = _MI_EXTCAL_BNAME3_DESC;
$modversion['blocks'][$i]['show_func'] = "bExtcalUpcomingShow";
$modversion['blocks'][$i]['options'] = "5|25|0";
$modversion['blocks'][$i]['edit_func'] = "bExtcalUpcomingEdit";
$modversion['blocks'][$i]['template'] = 'extcal_block_upcoming.html';
$i++;
$modversion['blocks'][$i]['file'] = "extcal_blocks.php";
$modversion['blocks'][$i]['name'] = _MI_EXTCAL_BNAME4;
$modversion['blocks'][$i]['description'] = _MI_EXTCAL_BNAME4_DESC;
$modversion['blocks'][$i]['show_func'] = "bExtcalDayShow";
$modversion['blocks'][$i]['options'] = "5|25|0";
$modversion['blocks'][$i]['edit_func'] = "bExtcalDayEdit";
$modversion['blocks'][$i]['template'] = 'extcal_block_day.html';
$i++;
$modversion['blocks'][$i]['file'] = "extcal_blocks.php";
$modversion['blocks'][$i]['name'] = _MI_EXTCAL_BNAME5;
$modversion['blocks'][$i]['description'] = _MI_EXTCAL_BNAME5_DESC;
$modversion['blocks'][$i]['show_func'] = "bExtcalNewShow";
$modversion['blocks'][$i]['options'] = "5|25|0";
$modversion['blocks'][$i]['edit_func'] = "bExtcalNewEdit";
$modversion['blocks'][$i]['template'] = 'extcal_block_new.html';
$i++;
$modversion['blocks'][$i]['file'] = "extcal_blocks.php";
$modversion['blocks'][$i]['name'] = _MI_EXTCAL_BNAME6;
$modversion['blocks'][$i]['description'] = _MI_EXTCAL_BNAME6_DESC;
$modversion['blocks'][$i]['show_func'] = "bExtcalRandomShow";
$modversion['blocks'][$i]['options'] = "5|25|0";
$modversion['blocks'][$i]['edit_func'] = "bExtcalRandomEdit";
$modversion['blocks'][$i]['template'] = 'extcal_block_random.html';
                                                              

//---------------------------------------------------------
// Notifications
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'extcal_notify_iteminfo';

$modversion['notification']['category'][1]['name'] = 'global';
$modversion['notification']['category'][1]['title'] = _MI_EXTCAL_GLOBAL_NOTIFY;
$modversion['notification']['category'][1]['description'] = _MI_EXTCAL_GLOBAL_NOTIFYDSC;
$modversion['notification']['category'][1]['subscribe_from'] = '*';
$modversion['notification']['category'][1]['item_name'] = '';

$modversion['notification']['category'][2]['name'] = 'cat';
$modversion['notification']['category'][2]['title'] = _MI_EXTCAL_CAT_NOTIFY;
$modversion['notification']['category'][2]['description'] = _MI_EXTCAL_CAT_NOTIFYDSC;
$modversion['notification']['category'][2]['subscribe_from'] = array('calendar.php', 'year.php', 'day.php');
$modversion['notification']['category'][2]['item_name'] = 'cat';

$modversion['notification']['category'][3]['name'] = 'event';
$modversion['notification']['category'][3]['title'] = _MI_EXTCAL_EVENT_NOTIFY;
$modversion['notification']['category'][3]['description'] = _MI_EXTCAL_EVENT_NOTIFYDSC;
$modversion['notification']['category'][3]['subscribe_from'] = 'event.php';
$modversion['notification']['category'][3]['item_name'] = 'event';
$modversion['notification']['category'][3]['allow_bookmark'] = 1;

$modversion['notification']['event'][1]['name'] = 'new_event';
$modversion['notification']['event'][1]['category'] = 'global';
$modversion['notification']['event'][1]['title'] = _MI_EXTCAL_NEW_EVENT_NOTIFY;
$modversion['notification']['event'][1]['caption'] = _MI_EXTCAL_NEW_EVENT_NOTIFYCAP;
$modversion['notification']['event'][1]['description'] = _MI_EXTCAL_NEW_EVENT_NOTIFYDSC;
$modversion['notification']['event'][1]['mail_template'] = 'global_new_event';
$modversion['notification']['event'][1]['mail_subject'] = _MI_EXTCAL_NEW_EVENT_NOTIFYSBJ;

$modversion['notification']['event'][2]['name'] = 'new_event_pending';
$modversion['notification']['event'][2]['category'] = 'global';
$modversion['notification']['event'][2]['title'] = _MI_EXTCAL_NEW_EVENT_PENDING_NOTIFY;
$modversion['notification']['event'][2]['caption'] = _MI_EXTCAL_NEW_EVENT_PENDING_NOTIFYCAP;
$modversion['notification']['event'][2]['description'] = _MI_EXTCAL_NEW_EVENT_PENDING_NOTIFYDSC;
$modversion['notification']['event'][2]['mail_template'] = 'global_new_event_pending';
$modversion['notification']['event'][2]['mail_subject'] = _MI_EXTCAL_NEW_EVENT_PENDING_NOTIFYSBJ;
$modversion['notification']['event'][2]['admin_only'] = 1;

$modversion['notification']['event'][3]['name'] = 'new_event_cat';
$modversion['notification']['event'][3]['category'] = 'cat';
$modversion['notification']['event'][3]['title'] = _MI_EXTCAL_NEW_EVENT_CAT_NOTIFY;
$modversion['notification']['event'][3]['caption'] = _MI_EXTCAL_NEW_EVENT_CAT_NOTIFYCAP;
$modversion['notification']['event'][3]['description'] = _MI_EXTCAL_NEW_EVENT_CAT_NOTIFYDSC;
$modversion['notification']['event'][3]['mail_template'] = 'cat_new_event';
$modversion['notification']['event'][3]['mail_subject'] = _MI_EXTCAL_NEW_EVENT_CAT_NOTIFYSBJ;

// XoopsInfo
$modversion['developer_website_url'] = "http://www.zoullou.net/";
$modversion['developer_website_name'] = "eXtCal and eXtGallery module for XOOPS : Zoullou.net";
$modversion['download_website'] = "http://www.zoullou.net/";
$modversion['status_fileinfo'] = "";
$modversion['demo_site_url'] = "http://www.zoullou.net/modules/extcal/";
$modversion['demo_site_name'] = "eXtCal and eXtGallery module for XOOPS : Zoullou.net";
$modversion['support_site_url'] = "http://www.zoullou.net/";
$modversion['support_site_name'] = "eXtCal and eXtGallery module for XOOPS : Zoullou.net";
$modversion['submit_bug'] = "http://sourceforge.net/tracker/?func=add&group_id=177145&atid=880070";
$modversion['submit_feature'] = "http://sourceforge.net/tracker/?func=add&group_id=177145&atid=880073";

?>
