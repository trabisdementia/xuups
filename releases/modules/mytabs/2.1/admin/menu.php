<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

$adminmenu[0]['title'] = _MI_MYTABS_ADMMENU1;
$adminmenu[0]['link'] = "admin/index.php";

if (mytabs_getcms() != 'XOOPS22') {
    $adminmenu[1]['title'] = _MI_MYTABS_ADMMENU3;
    $adminmenu[1]['link'] =	"admin/myblocksadmin.php";
}

$adminmenu[2]['title'] = _MI_MYTABS_ADMMENU2;
$adminmenu[2]['link'] = "admin/about.php";

?>