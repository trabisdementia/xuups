<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

include_once dirname(dirname(dirname(__FILE__))) . '/mainfile.php';
include_once XOOPS_ROOT_PATH . '/modules/subscribers/include/functions.php';
subscribers_sendEmails();

$xoopsOption['template_main'] = 'subscribers_index.html';
include_once XOOPS_ROOT_PATH . '/header.php';

$config =& subscribers_getModuleConfig();
$selected = $config['country'];

$sub_captcha = $config['captcha'];
if (is_object($xoopsUser)) {
    $captcha = $sub_captcha == 2 ? 0 : 1;
} else {
    $captcha = $sub_captcha == 3 ? 0 : 1;
}

include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
$countries = XoopsLists::getCountryList();
array_shift($countries);

$xoopsTpl->assign('countries', $countries);
$xoopsTpl->assign('selected', $selected);
$xoopsTpl->assign('captcha', $captcha);

include_once XOOPS_ROOT_PATH . '/footer.php';