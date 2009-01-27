<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

include_once 'admin_header.php';
include_once '../class/about.php';

$aboutObj = new DefacerAbout();
$aboutObj->render();

?>
