<?php
/**
 * CBB 4.0, or newbb, the forum module for XOOPS project
 *
 * @copyright	The XOOPS Project http://xoops.sf.net
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <phppp@users.sourceforge.net>
 * @since		4.00
 * @version		$Id $
 * @package		module::newbb
 */
include_once '../../mainfile.php';
defined('XOOPS_ROOT_PATH') or die('Restricted access');
if (!empty($xoopsModuleConfig['do_rewrite']))  include_once "seo_url.php"; 
/* for seo */
if((strpos(getenv('REQUEST_URI'), '/modules/'.$xoopsModule->getVar("dirname").'/') === 0  && !empty($xoopsModuleConfig['do_rewrite']) && (!isset($_POST) || count($_POST) <=0))) 
{
        $newurl = str_replace("/modules/".$xoopsModule->getVar('dirname')."/","/forum/",getenv('REQUEST_URI'));
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $newurl");
        exit();
}
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/vars.php";

mod_loadFunctions("user", "newbb");
mod_loadFunctions("topic", "newbb");

require_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
require_once XOOPS_ROOT_PATH."/class/module.textsanitizer.php";
$myts =& MyTextSanitizer::getInstance();

$menumode =0;
$menumode_other = array();
$menu_url = htmlSpecialChars(preg_replace("/&menumode=[^&]/", "", $_SERVER[ 'REQUEST_URI' ]));
$menu_url .= ( false === strpos($menu_url, "?") ) ? "?menumode=" : "&amp;menumode=";
foreach ($xoopsModuleConfig["valid_menumodes"] as $key => $val) {
	if ($key != $menumode) $menumode_other[] = array("title"=>$val, "link"=>$menu_url.$key);
}

$newbb_module_header = '';
$newbb_module_header .= '<link rel="alternate" type="application/rss+xml" title="'.$xoopsModule->getVar("name").'" href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname', "n").'/rss.php" />';
if (!empty($xoopsModuleConfig['pngforie_enabled'])) {
	$newbb_module_header .= '<style type="text/css">img {behavior:url("include/pngbehavior.htc");}</style>';
}
$newbb_module_header .= '
	<link rel="stylesheet" type="text/css" href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname").'/templates/style.css" />
	<script type="text/javascript">var toggle_cookie="'.$forumCookie['prefix'].'G'.'";</script>
	<script src="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname").'/include/js/newbb_toggle.js" type="text/javascript"></script>
	';
	
if ($menumode == 2) {
	$newbb_module_header .= '
	<link rel="stylesheet" type="text/css" href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname").'templates/newbb_menu_hover.css" />
	<style type="text/css">body {behavior:url("include/newbb.htc");}</style>
	';
}

if ($menumode == 1) {
	$newbb_module_header .= '
	<link rel="stylesheet" type="text/css" href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname").'templates/newbb_menu_click.css" />
	<script src="include/js/newbb_menu_click.js" type="text/javascript"></script>
	';
}

$xoops_module_header = $newbb_module_header; // for cache hack

if (!empty($xoopsModuleConfig["welcome_forum"]) && is_object($xoopsUser) && !$xoopsUser->getVar('posts')) {
	mod_loadFunctions("welcome", "newbb");
}

$pollmodules = NULL;
$module_handler = &xoops_gethandler('module');
$xoopspoll = &$module_handler->getByDirname('xoopspoll');
if (is_object($xoopspoll) && $xoopspoll->getVar('isactive')) 
        $pollmodules = 'xoopspoll';
else 
{
    //Umfrage
    $xoopspoll = &$module_handler->getByDirname('umfrage');
    if (is_object($xoopspoll) && $xoopspoll->getVar('isactive')) 
        $pollmodules = 'umfrage';
}
?>