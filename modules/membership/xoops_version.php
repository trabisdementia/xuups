<?php
//  Author: SMD & Trabis
//  URL: http://www.xoopsmalaysia.org  & http://www.xuups.com
//  E-Mail: webmaster@xoopsmalaysia.org  & lusopoemas@gmail.com

$modversion['name']         = _MI_MSHIP_NAME;
$modversion['dirname']      = "membership";
$modversion['description']  = _MI_MSHIP_DSC;
$modversion['version']      = "2.3";
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

//Templates
$i=0;
$i++;
$modversion['templates'][$i]['file'] = "membership_index.html";
$modversion['templates'][$i]['description'] = '';
$i++;
$modversion['templates'][$i]['file'] = "membership_rank.html";
$modversion['templates'][$i]['description'] = '';

// Blocks
$modversion['blocks'][1]['file'] 		= "membership_block.php";
$modversion['blocks'][1]['show_func'] 	= "show_membership_block";
$modversion['blocks'][1]['name'] 		= _MI_MSHIP_BLOCK_TITLE;
$modversion['blocks'][1]['description'] = _MI_MSHIP_BLOCK_DSC;
$modversion['blocks'][1]['edit_func'] = "membership_edit";
$modversion['blocks'][1]['options'] = "1";
$modversion['blocks'][1]['template'] = 'membership_block.html';


//Configs
$i = 0;
$i++;
$modversion['config'][$i]['name'] = 'membersperpage';
$modversion['config'][$i]['title'] = '_MI_MSHIP_MPAGE';
$modversion['config'][$i]['description'] = '_MI_MSHIP_MPAGE_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;

$i++;
$modversion['config'][$i]['name'] = 'defaultavatar';
$modversion['config'][$i]['title'] = '_MI_MSHIP_DAVATAR';
$modversion['config'][$i]['description'] = '_MI_MSHIP_DAVATAR_DSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

//Menu
$i=0;
$i++;
$modversion['sub'][$i]['name'] = _MI_MSHIP_SMLIST;
$modversion['sub'][$i]['url'] = "index.php";
$i++;
$modversion['sub'][$i]['name'] = _MI_MSHIP_SMRANK;
$modversion['sub'][$i]['url'] = "rank.php";

?>
