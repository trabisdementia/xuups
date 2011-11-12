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
 * @version         $Id$
 */

include_once dirname(__FILE__) . '/admin_header.php';
xoops_cp_header();

$menu = new Xmf_Template_Adminmenu();
$menu->display();

$nav = new Xmf_Template_Adminnav();
$nav->display();

$about = new Xmf_Template_Adminabout();
$about->display();


//echo $aboutAdmin->addNavigation('category.php');
//echo $aboutAdmin->addNavigation('about.php');
//echo $aboutAdmin->renderabout('6KJ7RW5DR3VTJ', false);
//$indexAdmin = new ModuleAdmin();
//echo $indexAdmin->addNavigation('index.php');
//echo $aboutAdmin->renderIndex();

xoops_cp_footer();
?>