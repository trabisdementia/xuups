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

include_once dirname(dirname(dirname(__FILE__))) . '/mainfile.php';
include_once XOOPS_ROOT_PATH . '/modules/myinviter/include/common.php';

$error = false;
if ($GLOBALS['myinviter']->getConfig('hook') == 'cron') {
    $key = Xmf_Request::getString('key');
    if ($key != $GLOBALS['myinviter']->getConfig('cronkey')) {
        $error = true;
        //We can add ?key= on any XOOPS Page while using preload and test if key is working ok
        $GLOBALS['myinviter']->addLog("Hook is set to 'cron' but no valid key was detected");
    }
}

if (!$error) {
    myinviter_sendEmails();
    if ($GLOBALS['myinviter']->getConfig('autocrawl')) {
        myinviter_runJobs();
    }
}