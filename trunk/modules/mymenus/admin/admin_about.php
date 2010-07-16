<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

include_once dirname(__FILE__) . '/admin_header.php';
include_once XOOPS_ROOT_PATH . '/modules/mymenus/class/about.php';

$aboutObj = new MymenusAbout();
$aboutObj->render();
