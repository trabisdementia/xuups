<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         usercsv
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: admin_index.php 0 2009-08-26 18:47:04Z trabis $
 */

require dirname(__FILE__) . '/admin_header.php';
error_reporting(0);
$GLOBALS['xoopsLogger']->activated = false;

$actions = array('list', 'export');
$op = isset($_REQUEST['op']) && in_array($_REQUEST['op'], $actions) ?  $_REQUEST['op'] : 'index';

switch ($op) {
    case 'index':
        xoops_cp_header();
        usercsv_adminMenu(0);
        usercsv_index();
        xoops_cp_footer();
        break;
    case 'export':
        usercsv_export();
        break;
}

function usercsv_index()
{
    echo usercsv_form();
}

function usercsv_export()
{
    /*
     if (!$GLOBALS['xoopsSecurity']->check()) {
     redirect_header(basename(__FILE__), 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
     }
     */

    if (!isset($_POST['fields'])) {
        redirect_header(basename(__FILE__) , 2, _AM_UCSV_ERROR_NOFIELDS);
    }

    $fields = usercsv_getFormFields();

    $export_fields = array();
    foreach ($_POST['fields'] as $key => $fieldkey) {
        $export_fields[] = $fields[$fieldkey];
    }

    if (count($export_fields) == 0) {
        redirect_header(basename(__FILE__) , 2, _AM_UCSV_ERROR_NOFIELDS);
    }

    $is_profile = usercsv_isProfile();
    $user_handler =& xoops_getHandler('user');

    if ($is_profile) {
        $profile_handler =& xoops_getModuleHandler('profile', 'profile');
        list($users, $profiles) = usercsv_profileSearch($export_fields);
        foreach (array_keys($users) as $k) {
            $userarray = array();
            foreach ($export_fields as $field) {
                  $userarray[$field] = in_array($field, usercsv_getUserFields()) ? $users[$k][$field] : $profiles[$k][$field];
            }
            $result[] = $userarray;
            unset($userarray);
        }
        unset($users, $profiles);
    } else {
        $users = usercsv_search($export_fields);
        foreach ($users as $user) {
            $userarray = array();
            foreach ($export_fields as $field) {
                  $userarray[$field] = $user[$field];
            }
            $result[] = $userarray;
            unset($userarray);
        }
        unset($users);
    }

    $csv_terminated = "\n";
    $csv_separator = ",";
    $csv_enclosed = '"';
    $csv_escaped = "\\";

    $schema_insert = '';
    foreach ($export_fields as $field) {
        $l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $field) . $csv_enclosed;
        $schema_insert .= $l;
        $schema_insert .= $csv_separator;
    }
    unset($export_fields);

    $out  = trim(substr($schema_insert, 0, -1));
    $out .= $csv_terminated;

    foreach ($result as $user) {
        $schema_insert = '';
        foreach ($user as $field => $value) {
            $l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $value) . $csv_enclosed;
            $schema_insert .= $l;
            $schema_insert .= $csv_separator;
        }
        $out .= trim(substr($schema_insert, 0, -1));
        $out .= $csv_terminated;
    }
    unset($result, $user);

    $filename = 'ucsv-' . time() . '.csv';
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Length: " . strlen($out));
    // Output to browser with appropriate mime type, you choose ;)
    //header("Content-type: text/x-csv");
    //header("Content-type: text/csv");
    header("Content-type: application/csv");
    header("Content-Disposition: attachment; filename=" . $filename);
    echo $out;
    exit();
}

function usercsv_profileSearch($searchvars = array())
{
    $profile_handler =& xoops_getModuleHandler('profile', 'profile');
    $uservars = usercsv_getUserFields();

    $searchvars_user = array_intersect($searchvars, $uservars);
    $searchvars_profile = array_diff($searchvars, $uservars);
    $sv = array();
    if (!empty($searchvars_user)) {
        $sv[] = "u." . implode(", u.", $searchvars_user);
    }
    if (!empty($searchvars_profile)) {
        $sv[] = "p." . implode(", p.", $searchvars_profile);
    }

    $sql_select = "SELECT " . (empty($searchvars) ? "u.*, p.*" : implode(", ", $sv));
    $sql_from = " FROM " . $profile_handler->db->prefix("users") . " AS u LEFT JOIN " . $profile_handler->db->prefix("profile_profile") . " AS p ON u.uid=p.profile_id";
    $sql_clause = " WHERE 1=1";
    $sql_order = "";

    $sql_users = $sql_select . $sql_from . $sql_clause . $sql_order;
    $result = $profile_handler->db->query($sql_users);

    if (!$result) {
        return array(array(), array());
    }

    $users = array();
    $profiles = array();
    while ($myrow = $profile_handler->db->fetchArray($result)) {
        $user = array();
        $profile = array();
        foreach ($myrow as $name => $value) {
            if (in_array($name, $uservars)) {
                $user[$name] = $value;
            } else {
                $profile[$name] = $value;
            }
        }
        $profiles[] = $profile;
        $users[] = $user;
    }

    return array($users, $profiles);
}

function usercsv_search($searchvars = array())
{
    global $xoopsDB;
    $uservars = usercsv_getUserFields();
    $searchvars_user = array_intersect($searchvars, $uservars);

    $sql_select = "SELECT " . (empty($searchvars) ? "*" : implode(", ", $searchvars_user));
    $sql_from = " FROM " . $xoopsDB->prefix("users");
    $sql_clause = " WHERE 1=1";
    $sql_order = "";

    $sql_users = $sql_select . $sql_from . $sql_clause . $sql_order;
    $result = $xoopsDB->query($sql_users);

    if (!$result) {
        return array();
    }

    $user = array();
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $user = array();
        foreach ($myrow as $name => $value) {
            $user[$name] = $value;
        }
        $users[] = $user;
    }

    return $users;
}

function usercsv_getUserFields()
{
    $user_fields = array('uid', 'uname', 'name', 'email', 'url','user_avatar', 'user_regdate',
                         'user_icq', 'user_from', 'user_sig', 'user_viewemail', 'actkey', 'user_aim',
                         'user_yim', 'user_msnm', 'pass', 'posts', 'attachsig', 'rank', 'level',
                         'theme', 'timezone_offset', 'last_login', 'umode', 'uorder', 'notify_method',
                         'notify_mode', 'user_occ', 'bio', 'user_intrest', 'user_mailok');
    return $user_fields;
}

function usercsv_getFormFields()
{
    $user_fields = usercsv_getUserFields();

    $profile_fields = array();

    if (usercsv_isProfile()) {
        $field_handler =& xoops_getModuleHandler('field', 'profile');
        $profile_fields = $field_handler->loadFields(true);
        $profile_fields = array_keys($profile_fields);
    }

    $fields = array_merge($user_fields, $profile_fields);
    return $fields;
}

function usercsv_isProfile()
{
    $module_handler =& xoops_gethandler('module');
    $profile_module = $module_handler->getByDirname('profile');
    if ($profile_module && $profile_module->getVar('isactive')) {
        return $profile_module;
    }
    return false;
}

function usercsv_form()
{
	$form = new XoopsThemeForm(_AM_UCSV_EXPORT, 'index_form', basename(__FILE__), 'post', true);

    $element = new XoopsFormCheckBox('', 'fields', null, '&nbsp;');
    $element->addOptionArray(usercsv_getFormFields());
    $ele_options = $element->getOptions();

    $i = 0;
    $option_ids = array();
    foreach($ele_options as $value => $name) {
        $i++;
        $option_ids[] = 'fields' . $i;
    }
    $option_ids_str = implode("', '", $option_ids);

    $element2 = new XoopsFormLabel(_AM_UCSV_FIELDS, '
    <div id="checkfields">' . $element->render(). '
    <input name="usercsv_checkall" id="usercsv_checkall" value="" type="checkbox" onclick="var optionids = new Array(\'' . $option_ids_str . '\'); xoopsCheckAllElements(optionids, \'usercsv_checkall\');")>
    ' . _ALL . '&nbsp;</div>');
    $form->addElement($element2);

    unset($element ,$element2);

    $tray = new XoopsFormElementTray('' ,'');
    $tray->addElement(new XoopsFormButton('', 'usercsv_button', _SUBMIT, 'submit'));
    $form->addElement($tray);

    $form->addElement(new XoopsFormHidden('op', 'export'));

    return $form->render();
}
?>