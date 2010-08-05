<?php
//Include XOOPS Global Includes
error_reporting(E_ALL); //Enable Error Reporting
$xoopsOption['nocommon'] = 1;

require '../../mainfile.php';
require_once XOOPS_ROOT_PATH.'/kernel/object.php';
require_once XOOPS_ROOT_PATH.'/class/criteria.php';
require_once XOOPS_ROOT_PATH.'/include/functions.php';
include_once XOOPS_ROOT_PATH.'/class/logger.php';
include_once XOOPS_ROOT_PATH.'/class/module.textsanitizer.php';
include_once XOOPS_ROOT_PATH.'/class/xoopsuser.php';

define("XOOPS_CACHE_PATH", XOOPS_ROOT_PATH."/cache");
define("XOOPS_UPLOAD_PATH", XOOPS_ROOT_PATH."/uploads");
define("XOOPS_THEME_PATH", XOOPS_ROOT_PATH."/themes");
define("XOOPS_COMPILE_PATH", XOOPS_ROOT_PATH."/templates_c");
define("XOOPS_THEME_URL", XOOPS_URL."/themes");
define("XOOPS_UPLOAD_URL", XOOPS_URL."/uploads");

if (!defined('XHELP_CONSTANTS_INCLUDED')) {
    include_once(XOOPS_ROOT_PATH.'/modules/xhelp/include/constants.php');
}

require_once(XHELP_BASE_PATH.'/functions.php');

//Initialize XOOPS Logger
$xoopsLogger =& XoopsLogger::instance();
$xoopsLogger->startTime();

//Initialize DB Connection
include_once XOOPS_ROOT_PATH.'/class/database/databasefactory.php';
$xoopsDB =& XoopsDatabaseFactory::getDatabaseConnection();
$module_handler =& xoops_gethandler('module');
$module =& $module_handler;
$config_handler =& xoops_gethandler('config');
$xoopsConfig =& $config_handler->getConfigsByCat(XOOPS_CONF);

//Include XOOPS Language Files
if ( file_exists(XOOPS_ROOT_PATH."/language/".$xoopsConfig['language']."/global.php") ) {
    include_once XOOPS_ROOT_PATH."/language/".$xoopsConfig['language']."/global.php";
} else {
    include_once XOOPS_ROOT_PATH."/language/english/global.php";
}

$xoopsConfigUser = array();
$myConfigs =& $config_handler->getConfigs();
foreach($myConfigs as $myConf){
    $xoopsConfigUser[$myConf->getVar('conf_name')] = $myConf->getVar('conf_value');
}

$xoopsModule =& xhelpGetModule();
$xoopsModuleConfig =& xhelpGetModuleConfig();

xhelpIncludeLang('main');
?>