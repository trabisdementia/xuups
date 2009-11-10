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
 * @package         Admin
 * @subpackage      Action
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: admin_header.php 0 2009-06-11 18:47:04Z trabis $
 */


include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/mainfile.php';
include_once dirname(dirname(__FILE__)) . '/include/common.php';

if (!defined("PUBLISHER_NOCPFUNC")) {
    include_once XOOPS_ROOT_PATH . '/include/cp_functions.php';

    // set config values for this module
    $xoopsModuleConfig = $publisher->getConfig();

    $moduleperm_handler =& xoops_gethandler('groupperm');
    if ($xoopsUser) {
        $xoopsModule =& $publisher->getModule();
        if ( !$moduleperm_handler->checkRight('module_admin', $publisher->getModule()->mid(), $xoopsUser->getGroups())) {
            redirect_header(XOOPS_URL, 1, _NOPERM);
            exit();
        }
    } else {
        redirect_header(XOOPS_URL . "/user.php", 1, _NOPERM);
        exit();
    }

    xoops_loadLanguage('admin', PUBLISHER_DIRNAME);
    xoops_loadLanguage('modinfo', PUBLISHER_DIRNAME);

    $imagearray = array(
        'editimg'   => "<img src='" . PUBLISHER_IMAGES_URL . "/button_edit.png' alt='" . _AM_PUBLISHER_ICO_EDIT . "' align='middle' />",
        'deleteimg' => "<img src='" . PUBLISHER_IMAGES_URL . "/button_delete.png' alt='" . _AM_PUBLISHER_ICO_DELETE . "' align='middle' />",
        'online'    => "<img src='" . PUBLISHER_IMAGES_URL . "/on.png' alt='" . _AM_PUBLISHER_ICO_ONLINE . "' align='middle' />",
        'offline'   => "<img src='" . PUBLISHER_IMAGES_URL . "/off.png' alt='" . _AM_PUBLISHER_ICO_OFFLINE . "' align='middle' />",
	);

}

include_once XOOPS_ROOT_PATH . '/kernel/module.php';
include_once XOOPS_ROOT_PATH . '/class/tree.php';
include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

$myts =& MyTextSanitizer::getInstance();
?>
