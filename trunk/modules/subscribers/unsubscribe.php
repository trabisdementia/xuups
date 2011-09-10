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
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Subscribers
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: unsubscribe.php 0 2009-11-14 18:47:04Z trabis $
 */

include_once dirname(dirname(dirname(__FILE__))) . '/mainfile.php';

if (!isset($_GET["email"]) || !isset($_GET["key"])) {
    redirect_header(XOOPS_URL, 2, _MD_SUBSCRIBERS_U_NO_THANKS);
    exit();
}

$email = $_GET["email"];
$key = $_GET["key"];

$truekey = md5($email . XOOPS_ROOT_PATH);

if ($truekey != $key) {
    redirect_header(XOOPS_URL, 2, _MD_SUBSCRIBERS_U_NO_THANKS);
    exit();
}

$user_handler =& xoops_getModuleHandler('user');
$criteria = new Criteria('user_email', $email);
$users = $user_handler->getObjects($criteria);

unset($criteria);
if (count($users) == 0) {
    redirect_header(XOOPS_URL, 2, _MD_SUBSCRIBERS_U_NO_THANKS);
    exit();
}

//delete user from subscribers
$user = $users[0];
$user_handler->delete($user, true);

//delete all wating emails related to this user
$wt_handler =& xoops_getModuleHandler('waiting');
$criteria = new Criteria('wt_toemail', $email);
$wt_handler->deleteAll($criteria);
unset($criteria);


redirect_header(XOOPS_URL, 5, _MD_SUBSCRIBERS_U_THANKS);
exit();