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
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: $
 */

include_once dirname(__FILE__) . '/admin_header.php';
xoops_cp_header();

$menu = new Xmf_Template_Adminmenu($xoopsModule);
$menu->display();

$nav = new Xmf_Template_Adminnav($xoopsModule);
$nav->display();

$index = new Xmf_Template_Adminindex($xoopsModule);

$infoBox = new Xmf_Template_Infobox('My info Box');
$infoBox->addLine('hello');
$index->addInfoBox($infoBox);

$configBox = new Xmf_Template_Configbox('My config Box');
$configBox->addLine('hello');
//$index->addConfigBox($configBox);

$index->display();


xoops_cp_footer();