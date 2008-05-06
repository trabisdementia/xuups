<?php
//  Author: SMD & Trabis
//  URL: http://www.xoopsmalaysia.org  & http://www.xuups.com
//  E-Mail: webmaster@xoopsmalaysia.org  & lusopoemas@gmail.com

$modversion['name']         = _MI_MSHIP_NAME;
$modversion['dirname']      = "membership";
$modversion['description']  = _MI_MSHIP_DSC;
$modversion['version']      = "2.2";
$modversion['author']       = "SMD <webmaster@xoopsmalaysia.org> http://www.xoopsmalaysia.org & Trabis<lusopoemas@gmail.com> http://www.xuups.com";
$modversion['credits']      = "SMD <webmaster@xoopsmalaysia.org> http://www.xoopsmalaysia.org & Trabis<lusopoemas@gmail.com> http://www.xuups.com";
$modversion['license']      = "GNU/GPL";
$modversion['official']     = "No";
$modversion['image']        = "images/membership_logo.gif";

// Main
$modversion['hasMain'] = 1;

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Tables
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$i=0;
$modversion['tables'][$i] = "mship_ips";

// Blocks
$modversion['blocks'][1]['file'] 		= "membership_block.php";
$modversion['blocks'][1]['show_func'] 	= "show_membership_block";
$modversion['blocks'][1]['name'] 		= _MI_MSHIP_TITLE;
$modversion['blocks'][1]['description'] = _MI_MSHIP_DSC;
$modversion['blocks'][1]['edit_func'] = "membership_edit";
$modversion['blocks'][1]['options'] = "1";
$modversion['blocks'][1]['template'] = 'membership_block.html';


//Configs

//Menu
$i=0;
$i++;
$modversion['sub'][$i]['name'] = _MI_MSHIP_SMRANK;
$modversion['sub'][$i]['url'] = "rank.php";

?>
