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
 * @copyright       The XUUPS Project http://www.xuups.com
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Myinviter
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: blacklist.php 0 2009-11-14 18:47:04Z trabis $
 */

include_once dirname(__FILE__) . '/header.php';

if (!isset($_GET["email"]) || !isset($_GET["key"])) {
    redirect_header(XOOPS_URL, 2, _MA_MYINV_ERROR_BLACKLIST);
    exit();
}

$email = $_GET["email"];
$key = $_GET["key"];

$truekey = md5($email . XOOPS_ROOT_PATH);

if ($truekey != $key) {
    redirect_header(XOOPS_URL, 2, _MA_MYINV_ERROR_BLACKLIST);
    exit();
}

$bl_handler = xoops_getmodulehandler('blacklist');
$criteria = new Criteria('bl_email',$email);

if ($bl_handler->getCount($criteria) > 0) {
    redirect_header(XOOPS_URL, 2, _MA_MYINV_ERROR_BLACKLIST);
    exit();
}

$bl = $bl_handler->create();
$bl->setVar('bl_email',$email);
$bl->setVar('bl_date', time());

if (!$bl_handler->insert($bl)){
    redirect_header(XOOPS_URL, 2, _MA_MYINV_ERROR_BLACKLIST);
    exit();
}

redirect_header(XOOPS_URL, 5, _MA_INVITER_BLACKLISTED);
exit();

?>