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
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id$
 */

include_once dirname(__FILE__) . '/admin_header.php';
xoops_cp_header();

$menu = new Xmf_Template_Adminmenu();
$menu->display();

$nav = new Xmf_Template_Adminnav();
$nav->display();

$buttonBox = new Xmf_Template_buttonBox();
$buttonBox->addItem('Front Page', XOOPS_URL);
$buttonBox->addItem('Self', '#');
$buttonBox->display();

$buttonBox2 = new Xmf_Template_buttonBox();
$buttonBox2->setPosition('left');
$buttonBox2->setDelimiter('<br /><br />');
$buttonBox2->addItem('Front Page 2', XOOPS_URL, 'delete');
$buttonBox2->addItem('Self 2', '#', 'delete');
$buttonBox2->display();

$infoBox = new Xmf_Template_InfoBox();
$infoBox->setTitle('This is Info Box 1');
$infoBox->addItem('My first line <br />');
$infoBox->addItem('My second line');
$infoBox->addItem($buttonBox->fetch());
$infoBox->display();

$infoBox2 = new Xmf_Template_InfoBox();
$infoBox2->setTitle('This is Info Box 2 with InFo Box 1 Inside');
$infoBox2->addItem($infoBox->fetch());
echo $infoBox2->fetch(); //same as $infoBox->display();

$configBox = new Xmf_Template_ConfigBox();
$configBox->setTitle('This is a Config Box');
$configBox->addItem('just a line');
$configBox->addItem(XOOPS_ROOT_PATH . '/uploads/demo', 'folder');
$configBox->addItem(array(XOOPS_ROOT_PATH . '/modules/demo', '0644'), 'chmod');
$configBox->display();





$addto = new Xmf_Template_Addto();
$addto->display();

xoops_cp_footer();