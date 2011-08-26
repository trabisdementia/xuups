<?php
include_once dirname(__FILE__) . '/admin_header.php';
xoops_cp_header();

$menu = new Xmf_Template_Adminmenu($xoopsModule);

$submenus[0]['title'] = 'hey';
$submenus[0]['link'] = 'somelink';
$submenus[1]['title'] = 'hey2';
$submenus[1]['link'] = 'somelink2';

$options['submenus'] = $submenus;
$options['currentsub'] = 0;
$options['currentoption'] = 1;

$menu->display($options);

_e('Content goes here');
xoops_cp_footer();