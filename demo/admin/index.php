<?php
include_once dirname(__FILE__) . '/admin_header.php';
xoops_cp_header();

$menu = new Xmf_Template_Adminmenu();
$menu->display();

$nav = new Xmf_Template_Adminnav();
$nav->display();

$index = new Xmf_Template_Adminindex();

$infoBox = new Xmf_Template_Infobox();
$infoBox->setTitle('InfoBox');
$infoBox->addItem('hello');
$index->addInfoBox($infoBox);


$configBox = new Xmf_Template_ConfigBox();
$configBox->addItem(XOOPS_ROOT_PATH . '/uploads/demo', 'folder');
$configBox->addItem(array(XOOPS_ROOT_PATH . '/modules/demo', '0644'), 'chmod');
$index->addConfigBox($configBox);

$index->display();
xoops_cp_footer();