<?php
include_once dirname(__FILE__) . '/admin_header.php';
xoops_cp_header();

$menu = new Xmf_Template_Adminmenu($xoopsModule);
//echo $menu->fetch();
$menu->display();

$addto = new Xmf_Template_Addto();
$addto->display();

$about = new Xmf_Template_About($xoopsModule);
$about->display();

xoops_cp_footer();