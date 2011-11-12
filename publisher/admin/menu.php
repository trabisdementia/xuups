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

global $xoopsModule;

$i = 0;

// Index
$adminmenu[$i]['title'] = _MI_PUBLISHER_ADMENU0;
$adminmenu[$i]['link'] = "admin/index.php";
$adminmenu[$i]["icon"] = '../xmf/images/icons/32/home.png';
$i++;
// Summary
$adminmenu[$i]['title'] = _MI_PUBLISHER_ADMENU1;
$adminmenu[$i]['link'] = "admin/summary.php";
$adminmenu[$i]["icon"] = '../xmf/images/icons/32/view_detailed.png';
$i++;
// Category
$adminmenu[$i]['title'] = _MI_PUBLISHER_ADMENU2;
$adminmenu[$i]['link'] = "admin/category.php";
$adminmenu[$i]["icon"] = '../xmf/images/icons/32/category.png';
$i++;
// Items
$adminmenu[$i]['title'] = _MI_PUBLISHER_ADMENU3;
$adminmenu[$i]['link'] = "admin/item.php";
$adminmenu[$i]["icon"] = '../xmf/images/icons/32/content.png';
$i++;
// Permissions
$adminmenu[$i]['title'] = _MI_PUBLISHER_ADMENU4;
$adminmenu[$i]['link'] = "admin/permissions.php";
$adminmenu[$i]["icon"] = '../xmf/images/icons/32/permissions.png';
$i++;
// Mimetypes
$adminmenu[$i]['title'] = _MI_PUBLISHER_ADMENU6;
$adminmenu[$i]['link'] = "admin/mimetypes.php";
$adminmenu[$i]["icon"] = '../xmf/images/icons/32/alert.png';
$i++;

// Preferences
$adminmenu[$i]['title'] = _PREFERENCES;
$adminmenu[$i]['link'] = "admin/preferences.php";
$adminmenu[$i]["icon"] = '../xmf/images/icons/32/administration.png';

?>