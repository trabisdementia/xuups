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
 * @package         myinviter
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id$
 */

include_once dirname(__FILE__) . '/header.php';

if (!isset($_GET["email"]) || !isset($_GET["key"])) {
    redirect_header(XOOPS_URL, 2, _MA_MYINVITER_ERROR_BLACKLIST);
    exit();
}

$email = $_GET["email"];
$key = $_GET["key"];

$truekey = md5($email . XOOPS_ROOT_PATH);

if ($truekey != $key) {
    redirect_header(XOOPS_URL, 2, _MA_MYINVITER_ERROR_BLACKLIST);
    exit();
}

$this_handler = xoops_getmodulehandler('item');
if ($this_handler->isEmailBlacklist($email)) {
    redirect_header(XOOPS_URL, 2, _MA_MYINVITER_ERROR_BLACKLIST);
    exit();
}

$bl = $this_handler->create();
$bl->setVar('email',$email);
$bl->setVar('date', time());

if (!$this_handler->insertBlacklist($bl)) {
    redirect_header(XOOPS_URL, 2, _MA_MYINVITER_ERROR_BLACKLIST);
    exit();
}

redirect_header(XOOPS_URL, 5, _MA_INVITER_BLACKLISTED);
exit();

?>