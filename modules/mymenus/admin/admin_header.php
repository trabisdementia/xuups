<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/include/cp_header.php';

include_once XOOPS_ROOT_PATH . '/include/functions.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once XOOPS_ROOT_PATH . '/class/template.php';

include_once XOOPS_ROOT_PATH . '/modules/mymenus/include/functions.php';
include_once XOOPS_ROOT_PATH . '/modules/mymenus/class/registry.php';
include_once XOOPS_ROOT_PATH . '/modules/mymenus/class/plugin.php';

xoops_loadLanguage('modinfo', 'mymenus');
$mymenusTpl = new XoopsTpl();