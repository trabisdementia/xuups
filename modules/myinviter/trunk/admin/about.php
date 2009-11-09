<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

include_once dirname(__FILE__) . '/admin_header.php';

include_once dirname(dirname(__FILE__)) . '/class/about.php';
$aboutObj = new MyinviterAbout(_MI_MYINV_ADMENU_ABOUT);
$aboutObj->render();

?>
