<?php
require dirname(dirname(__FILE__)) . '/include/common.php';

$i = 0;
$adminmenu[$i]['title'] = _tt('_MI_XTESTE_ADMENU1');
$adminmenu[$i]['link'] = "admin/index.php";
$i++;

$adminmenu[$i]['title'] = _tt('_MI_XTESTE_ADMENU2');
$adminmenu[$i]['link'] = "admin/index.php#";
?>