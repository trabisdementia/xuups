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
 * @version         $Id: $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

$i = 0;
$adminmenu[$i]['title'] = _MI_XTESTE_ADMENU1;
$adminmenu[$i]['link'] = "admin/index.php";
$adminmenu[$i]["icon"] = '../xmf/images/icons/32/home.png';

$i++;
$adminmenu[$i]['title'] = _MI_XTESTE_ADMENU2;
$adminmenu[$i]['link'] = "admin/summary.php";
$adminmenu[$i]["icon"] = '../xmf/images/icons/32/view_detailed.png';
