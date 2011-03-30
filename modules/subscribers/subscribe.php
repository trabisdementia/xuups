<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

include_once dirname(dirname(dirname(__FILE__))) . '/mainfile.php';

$redirect = $_SERVER['HTTP_REFERER'];

xoops_load("captcha");
$xoopsCaptcha =& XoopsCaptcha::getInstance();
if (!$xoopsCaptcha->verify()) {
    redirect_header($redirect, 2, $xoopsCaptcha->getMessage());
}

$myts =& MyTextSanitizer::getInstance();
$country = isset($_POST['user_country']) ? $myts->stripSlashesGPC($_POST['user_country']) : '';
$email = isset($_POST['user_email']) ? trim($myts->stripSlashesGPC($_POST['user_email'])) : '';
$name = isset($_POST['user_name']) ? trim($myts->stripSlashesGPC($_POST['user_name'])) : $GLOBALS['xoopsConfig']['anonymous'];
$phone = isset($_POST['user_phone']) ? trim($myts->stripSlashesGPC($_POST['user_phone'])) : '';

$stop = false;

if (!checkEmail($email)) {
    redirect_header($redirect, 2, _MD_SUBSCRIBERS_ERROR_BADEMAIL);
    exit();
}
if (strrpos($email,' ') > 0) {
    redirect_header($redirect, 2, _MD_SUBSCRIBERS_ERROR_BADEMAIL);
    exit();
}

include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
$countries = XoopsLists::getCountryList();
if (!in_array($country, array_keys($countries))){
    redirect_header($redirect, 2, _MD_SUBSCRIBERS_NO_THANKS);
    exit();
}

$user_handler =& xoops_getModuleHandler('user');
$criteria = new Criteria('user_email', $myts->addSlashes($email));
$count = $user_handler->getCount($criteria);
unset($criteria);

if ($count > 0) {
    redirect_header($redirect, 2, _MD_SUBSCRIBERS_ERROR_ALREADY);
    exit();
}

if ($stop) {
    redirect_header($redirect, 2, _MD_SUBSCRIBERS_NO_THANKS);
    exit();
}


$user = $user_handler->create();
$user->setVar('user_email', $email);
$user->setVar('user_name', $name);
$user->setVar('user_country', $country);
$user->setVar('user_phone', $phone);
$user->setVar('user_created', time());

if (false == $user_handler->insert($user)) {
    redirect_header($redirect, 2, _MD_SUBSCRIBERS_NO_THANKS);
    exit();
}

redirect_header($redirect, 2, _MD_SUBSCRIBERS_THANKS);
exit();

?>
