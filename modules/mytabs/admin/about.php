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
 * @package         Mytabs
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: about.php 0 2009-11-14 18:47:04Z trabis $
 */

require dirname(__FILE__) . '/header.php';
include_once dirname(dirname(__FILE__)) . '/class/about.php';

xoops_cp_header();
mytabs_adminmenu(2);
$aboutObj = new MytabsAbout();
$aboutObj->render();
xoops_cp_footer();

?>