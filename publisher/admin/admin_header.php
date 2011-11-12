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
 * @package         Publisher
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id$
 */

include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/mainfile.php';
include_once dirname(dirname(__FILE__)) . '/include/common.php';
include_once XOOPS_ROOT_PATH . '/include/cp_header.php';

xoops_loadLanguage('admin', PUBLISHER_DIRNAME);
xoops_loadLanguage('modinfo', PUBLISHER_DIRNAME);

$imagearray = array(
    'editimg' => "<img src='" . PUBLISHER_IMAGES_URL . "/button_edit.png' alt='" . _AM_PUBLISHER_ICO_EDIT . "' align='middle' />",
    'deleteimg' => "<img src='" . PUBLISHER_IMAGES_URL . "/button_delete.png' alt='" . _AM_PUBLISHER_ICO_DELETE . "' align='middle' />",
    'online' => "<img src='" . PUBLISHER_IMAGES_URL . "/on.png' alt='" . _AM_PUBLISHER_ICO_ONLINE . "' align='middle' />",
    'offline' => "<img src='" . PUBLISHER_IMAGES_URL . "/off.png' alt='" . _AM_PUBLISHER_ICO_OFFLINE . "' align='middle' />",
);
?>