<?php
//  Author: SMD & Trabis
//  URL: http://www.xoopsmalaysia.org  & http://www.xuups.com
//  E-Mail: webmaster@xoopsmalaysia.org  & lusopoemas@gmail.com

$modversion['name']         = _MI_MEMBERSHIP_NAME;
$modversion['dirname']      = "membership";
$modversion['description']  = _MI_MEMBERSHIP_DESC;
$modversion['version']      = "2.1";
$modversion['author']       = "SMD <webmaster@xoopsmalaysia.org> http://www.xoopsmalaysia.org & Trabis<lusopoemas@gmail.com> http://www.xuups.com";
$modversion['credits']      = "SMD <webmaster@xoopsmalaysia.org> http://www.xoopsmalaysia.org & Trabis<lusopoemas@gmail.com> http://www.xuups.com";
$modversion['license']      = "GNU/GPL";
$modversion['official']     = "No";
$modversion['image']        = "images/membership_logo.gif";

// Tables
$modversion['sqlfile']['mysql'] = "sql/tables.sql";
$i=0;
$modversion['tables'][$i] = "mship_ips";

// Blocks
$modversion['blocks'][1]['file'] 		= "membership_block.php";
$modversion['blocks'][1]['show_func'] 	= "show_membership_block";
$modversion['blocks'][1]['name'] 		= _MI_MEMBERSHIP_TITLE;
$modversion['blocks'][1]['description'] = _MI_MEMBERSHIP_DESC;
$modversion['blocks'][1]['edit_func'] = "membership_edit";
$modversion['blocks'][1]['options'] = "1";
$modversion['blocks'][1]['template'] = 'membership_block.html';


// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][1]['name'] = _MI_MEMBERSHIP_SMNAME1;
$modversion['sub'][1]['url'] = "rank.php";

?>
