<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com
if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

include dirname(__FILE__) . '/include/common.php';

$modversion['dirname'] = basename(dirname(__FILE__));
$modversion['name'] = ucfirst(basename(dirname(__FILE__)));
$modversion['version'] = '0.1';
$modversion['description'] = '';
$modversion['author'] = "Xuups";
$modversion['credits'] = "Trabis(www.xuups.com)";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "dummy.png";

$modversion['hasMain'] = 1;

$modversion['onInstall'] = "include/onupdate.inc.php";
$modversion['onUpdate'] = "include/onupdate.inc.php";
$modversion['object_items'][1] = 'post';
$modversion['object_items'][2] = 'category';
/*
 $modversion["tables"] = xmf_getTablesArray($modversion['dirname'], $modversion['object_items']);
 */
$modversion["tables"][0] = 'xtest_post';
$modversion["tables"][0] = 'xtest_category';

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu']  = "admin/menu.php";

$i = 0;
$i++;
$modversion['config'][$i]['name'] = 'config1';
$modversion['config'][$i]['title'] = '_MI_XTEST_CONFIG1';
$modversion['config'][$i]['description'] = '_MI_XTEST_CONFIG2_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'this is my test config1 value';

$i++;
$modversion['config'][$i]['name'] = 'config2';
$modversion['config'][$i]['title'] = '_MI_XTEST_CONFIG2';
$modversion['config'][$i]['description'] = '_MI_XTEST_CONFIG2_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'this is my test config2 value';

// Templates
$modversion['templates'][1]['file'] = 'xteste_post.html';
$modversion['templates'][1]['description'] = '';
