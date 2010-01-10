<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined("XOOPS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

function subscribers_adminMenu($currentoption = 0, $breadcrumb = '')
{
	include_once XOOPS_ROOT_PATH . '/class/template.php';
	include XOOPS_ROOT_PATH . '/modules/subscribers/admin/menu.php';

    xoops_loadLanguage('admin', 'subscribers');
    xoops_loadLanguage('modinfo', 'subscribers');

	$tpl =& new XoopsTpl();
	$tpl->assign(array('modurl'	    => XOOPS_URL . '/modules/subscribers',
	                   'headermenu'	=> $subscribers_headermenu,
                       'adminmenu'	=> $subscribers_adminmenu,
	                   'current'	=> $currentoption,
	                   'breadcrumb'	=> $breadcrumb,
	                   'headermenucount' => count($subscribers_headermenu)));
	$tpl->display(XOOPS_ROOT_PATH . '/modules/subscribers/templates/static/subscribers_admin_menu.html');
}

function &subscribers_getModuleHandler()
{
	static $handler;

	if (!isset($handler)) {
		global $xoopsModule;
		if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == 'subscribers') {
			$handler =& $xoopsModule;
		} else {
			$hModule =& xoops_gethandler('module');
			$handler = $hModule->getByDirname('subscribers');
		}
	}
	return $handler;
}

function &subscribers_getModuleConfig()
{
	static $config;

	if (!$config) {
		global $xoopsModule;
		if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == 'subscribers') {
			$config =& $GLOBALS['xoopsModuleConfig'];
		} else {
			$handler =& subscribers_getModuleHandler();
			$hModConfig =& xoops_gethandler('config');
			$config = $hModConfig->getConfigsByCat(0, $handler->getVar('mid'));
		}
	}
	return $config;
}

function subscribers_sendEmails()
{
    global $xoopsConfig;
    $thisConfigs =& subscribers_getModuleConfig();
    $emailsperpack = intval($thisConfigs['emailsperpack']);
    $timebpacks = intval($thisConfigs['timebpacks']);

    $fromname = trim($thisConfigs['fromname']);
    $fromemail = trim($thisConfigs['fromemail']);
    $fromname = $fromname != '' ? $fromname : $xoopsConfig['sitename'];
    $fromemail = $fromemail != '' ? $fromemail : $xoopsConfig['adminmail'];

    $now = time();
    $last = subscribers_getLastTime();

    if (($now - $last) <= $timebpacks) {
        return false;
    }
    
    $this_handler =& xoops_getModuleHandler('waiting', 'subscribers');
    
	$criteria = new CriteriaCompo();
	$criteria->setSort('wt_priority DESC, wt_created');
	$criteria->setOrder('ASC');
	$criteria->setLimit($emailsperpack);
    $objs = $this_handler->getObjects($criteria);
    $count = count($objs);
    unset ($criteria);

    if ($count == 0) {
        return false;
    }

    include_once XOOPS_ROOT_PATH . '/kernel/user.php';
    
    $myts =& MyTextSanitizer::getInstance();

    $obj_delete = array();
    foreach ($objs as $obj) {
        $xoopsMailer =& xoops_getMailer();
        $xoopsMailer->multimailer->ContentType = "text/html";
        $xoopsMailer->setFromName($fromname);
        $xoopsMailer->setFromEmail($fromemail);
        $xoopsMailer->useMail();
        $xoopsMailer->setToEmails(array($obj->getVar('wt_toemail', 'n')));
        $xoopsMailer->setSubject($obj->getVar('wt_subject'), 'n');
        $xoopsMailer->setBody($obj->getVar('wt_body'));
        $xoopsMailer->send(false);
        unset($xoopsMailer);
        

        $obj_delete[] = $obj->getVar('wt_id');
    }
    
    $criteria = new Criteria('wt_id', '(' . implode(',', $obj_delete). ')', 'IN');
    $this_handler->deleteAll($criteria, true);
    
    subscribers_setLastTime($now);
    
    return true;
}

function subscribers_getLastTime()
{
    $fileName = XOOPS_UPLOAD_PATH . '/subscribers_lasttime.txt';

    if (!file_exists($fileName)) {
        $time = time();
        $ret = subscribers_setLastTime($time);
        return $ret;
    }
    
    $ret = intval(file_get_contents($fileName));
    return $ret;
}

function subscribers_setLastTime($time = 0)
{
    $ret = 0;
    $fileName = XOOPS_UPLOAD_PATH . '/subscribers_lasttime.txt';
    @unlink($fileName);
    $fileHandler = fopen($fileName, 'w');
    if (!$fileHandler) return $ret;
    fwrite($fileHandler, $time);
    fclose($fileHandler);
    return $time;
}

?>
