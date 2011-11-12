<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

require dirname(__FILE__) . '/admin_header.php';

$op = isset($_GET['op']) ? trim($_GET['op']) : (isset($_POST['op']) ? trim($_POST['op']) : 'form');

switch ($op){
    case 'email':
        send_email();
        break;
    case 'form':
    default:
        xoops_cp_header();
        subscribers_adminMenu(1, _MI_SUBSCRIBERS_ADMENU_SEND);
        echo send_form();
        xoops_cp_footer();
        break;
}

function send_form()
{
    global $xoopsModuleConfig;
    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    $this_handler =& xoops_getModuleHandler('user', 'subscribers');

    $form = new XoopsThemeForm(_AM_SUBSCRIBERS_SEND, 'send_form', 'admin_send.php', "post");

    $element = new XoopsFormLabel(_MI_SUBSCRIBERS_CONF_FROMNAME,  $xoopsModuleConfig['fromname']);
    $form->addElement($element);
    unset($element);

    $element = new XoopsFormLabel(_MI_SUBSCRIBERS_CONF_FROMEMAIL,  $xoopsModuleConfig['fromemail']);
    $form->addElement($element);
    unset($element);

    // Country
    include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
    $countries = array("ALL" => _AM_SUBSCRIBERS_ALL_COUNTRIES);
    $countries2 = XoopsLists::getCountryList();
    array_shift($countries2);
    $countries += $countries2;

    $element = new XoopsFormSelect(_AM_SUBSCRIBERS_COUNTRY, 'country', 'ALL');
    $element->addOptionArray($countries);
    $form->addElement($element);
    unset($element, $countries);

    // Subject
    $form->addElement(new XoopsFormText(_AM_SUBSCRIBERS_EMAIL_SUBJECT, 'subject', 75, 150, ''), true);

    // Body
    $editor_configs = array();
    $editor_configs['rows'] = 35;
    $editor_configs['cols'] = 60;
    $editor_configs['width'] = '100%';
    $editor_configs['height'] = '400px';
    $editor_configs['name'] = 'body';
    $editor_configs['value'] = '';
    $element = new XoopsFormEditor(_AM_SUBSCRIBERS_EMAIL_BODY, $xoopsModuleConfig['editor'], $editor_configs, $nohtml = false, $onfailure = null);
    $element->setDescription(_AM_SUBSCRIBERS_EMAIL_BODY_DSC);
    $form->addElement($element);
    unset($element);

    // Priority
    $priorities = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
    unset($priorities[0]);
    $element = new XoopsFormSelect(_AM_SUBSCRIBERS_EMAIL_PRIORITY, 'priority', 5);
    $element->setDescription(_AM_SUBSCRIBERS_EMAIL_PRIORITY_DSC);
    $element->addOptionArray($priorities);
    $form->addElement($element);
    unset($element, $priorities);

    // Groups
    $groups = array(_AM_SUBSCRIBERS_SUBSCRIBERS, _AM_SUBSCRIBERS_USERS, _AM_SUBSCRIBERS_BOTH);
    $element = new XoopsFormSelect(_AM_SUBSCRIBERS_EMAIL_GROUPS, 'groups', 0);
    $element->setDescription(_AM_SUBSCRIBERS_EMAIL_GROUPS_DSC);
    $element->addOptionArray($groups);
    $form->addElement($element);
    unset($element, $groups);

    // Buttons
    $tray = new XoopsFormElementTray('' ,'');
    $tray->addElement(new XoopsFormButton('', 'submit_button', _SUBMIT, 'submit'));

    $btn = new XoopsFormButton('', 'reset', _CANCEL, 'button');
    $btn->setExtra('onclick="document.location.href=\'admin_send.php\'"');

    $tray->addElement($btn);
    $form->addElement($tray);

    $form->addElement(new XoopsFormHidden('op', 'email'));

    return $form->render();
}

function send_email()
{
    $vars = array();
    $vars['wt_priority'] = isset($_POST['priority']) ? $_POST['priority'] : 5;
    $vars['wt_created'] = time();

    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $body = isset($_POST['body']) ? trim($_POST['body']) : '';
    $country = isset($_POST['country']) ? $_POST['country'] : 'ALL';
    $groups = isset($_POST['groups']) ? $_POST['groups'] : 0;

    $user_handler =& xoops_getModuleHandler('user', 'subscribers');
    $wt_handler =& xoops_getModuleHandler('waiting', 'subscribers');

    $error = false;

    if ($groups == 0 || $groups == 2) {

        $criteria = null;
        if ($country != 'ALL') {
            $criteria = new Criteria('user_country', $country);
        }
        $objs = $user_handler->getObjects($criteria);
        unset($criteria);

        foreach ($objs as $obj) {
            $waiting = $wt_handler->create();
            $vars['wt_toname']  = $obj->getVar('user_name', 'n');
            $vars['wt_toemail'] = $obj->getVar('user_email', 'n');

            $vars['wt_subject'] = str_replace("{NAME}", $vars['wt_toname'], $subject);
            $vars['wt_subject'] = str_replace("{EMAIL}", $vars['wt_toemail'], $vars['wt_subject']);

            $vars['wt_body']    = str_replace("{NAME}", $vars['wt_toname'], $body);
            $vars['wt_body']    = str_replace("{EMAIL}", $vars['wt_toemail'],  $vars['wt_body']);

            $waiting->setVars($vars);
            if (!$wt_handler->insert($waiting)) {
                $error == true;
            }
            unset($waiting);
        }
        unset($objs);
    }

    if ($groups == 1 || $groups == 2) {

        include_once XOOPS_ROOT_PATH . '/kernel/user.php';
        $member_handler = new XoopsUserHandler($GLOBALS['xoopsDB']);
        $criteria = new Criteria('level', 0, '>');
        $members = $member_handler->getAll($criteria, array('uname', 'email'), false, false); //Using this to not exaust server resources
        unset($criteria);

        foreach ($members as $member) {
            $waiting = $wt_handler->create();
            $vars['wt_toname']  = $member['uname'];
            $vars['wt_toemail'] = $member['email'];

            $vars['wt_subject'] = str_replace("{NAME}", $vars['wt_toname'], $subject);
            $vars['wt_subject'] = str_replace("{EMAIL}", $vars['wt_toemail'], $vars['wt_subject']);

            $vars['wt_body']    = str_replace("{NAME}", $vars['wt_toname'], $body);
            $vars['wt_body']    = str_replace("{EMAIL}", $vars['wt_toemail'],  $vars['wt_body']);

            $waiting->setVars($vars);
            if (!$wt_handler->insert($waiting)) {
                $error == true;
            }
            unset($waiting);
        }
        unset($members);
    }

    if ($error) {
        redirect_header('admin_send.php', 2, _AM_SUBSCRIBERS_SOME_ERROR);
        exit();
    }

    redirect_header('admin_waiting.php', 2, _AM_SUBSCRIBERS_SUCCESS);
    exit();
}

?>
