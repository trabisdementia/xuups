<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

include_once dirname(__FILE__) . '/header.php';

include_once dirname(dirname(__FILE__)) . '/class/about.php';
$aboutObj = new MyPointsAbout();
$aboutObj->render();

?>