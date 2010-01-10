<?php
/**
 * Article management
 *
 * Import data
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		module::article
 */
include 'header.php';

xoops_cp_header();

require_once XOOPS_ROOT_PATH."/class/xoopslists.php";
$files = XoopsLists::getFileListAsArray(".");

$mods = array();
foreach($files as $file => $filename) {
	list($mod, $ext) =explode(".", $file);
	if($ext != "php" || $mod == "index" || $mod == "header") continue;
	$mods[$mod] = $file;
}

if(empty($_GET["module"]) || !isset($mods[$_GET["module"]])) {
	$form  = "<h2>Select the module to import</h2>";
	$form .= "<p>Note: 
		<ul>
		<li>All data in current <strong>".$xoopsModule->getVar("name")."</strong> will be removed, make sure you understand it clearly!</li>
		<li>The scripts have NOT been fully tested with large volume data yet; if you find any problem, please help us improve.</li>
		</ul>
		</p>";
	$form .= "<p><form name='formop' method='get'>";
	$form .= _SELECT." <select name='module'>";
	foreach($mods as $mod => $file) {
		$form .= "<option value='{$mod}'>{$mod}</option>";
	}
	$form .= "</select>";
	$form .= " <input type='submit' name='submit' value='"._SUBMIT."' />";
	$form .= "</form></p>";
	
	echo $form;
}else{

	include XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/vars.php";
	
	xoops_result("<h2>Data Import From ".$_GET["module"]."</h2>");
	
	foreach($xoopsModule->getInfo("tables") as $table){
	    $sql = "TRUNCATE TABLE ".$GLOBALS["xoopsDB"]->prefix($table);
	    $GLOBALS["xoopsDB"]->queryF($sql);
		$sql_reset = "ALTER TABLE ".$xoopsDB->prefix($table). " AUTO_INCREMENT = 1;";
		$xoopsDB->queryF($sql_reset);
		xoops_result("succeed with emptying TABLE {$table}");
	}
	
	include $mods[$_GET["module"]];

	$sql =	
				"	SELECT mid".
				" 	FROM ".$GLOBALS['xoopsDB']->prefix("modules").
				"	WHERE dirname = '".$_GET["module"]."'"
				;
	$result = $xoopsDB->query($sql);
	list($mid) = $xoopsDB->fetchRow($result);
	
	if($mid) {
		$modid = $xoopsModule->getVar("mid");
		$sql =	
					"	INSERT INTO ".$GLOBALS['xoopsDB']->prefix("xoopscomments").
					"		(`com_pid`, `com_rootid`, `com_modid`, `com_itemid`, `com_icon`, `com_created`,
							`com_modified`, `com_uid`, `com_ip`, `com_title`, `com_text`, `com_sig`, `com_status`,
							`com_exparams`, `dohtml`, `dosmiley`, `doxcode`, `doimage`, `dobr`)".		
					"	SELECT ".
					"		`com_pid`, `com_rootid`, {$modid}, `com_itemid`, `com_icon`, `com_created`,
							`com_modified`, `com_uid`, `com_ip`, `com_title`, `com_text`, `com_sig`, `com_status`,
							`com_exparams`, `dohtml`, `dosmiley`, `doxcode`, `doimage`, `dobr`".		
					" 	FROM ".$GLOBALS['xoopsDB']->prefix("xoopscomments").
					" 	WHERE com_modid = {$mid} ".
					"		ORDER BY `com_id` ASC"
					;
		$result = $xoopsDB->queryF($sql);
		xoops_result("succeed with building comment table: ".$count = $xoopsDB->getAffectedRows());
	}
	
	
	xoops_result("<h2>The data import is executed successfully</h2>");
	xoops_result("<p>Please run 
		<ol>
		<li><a href='../admin/admin.permission.php' target='_blank'>Permission Management</a></li>
		<li><a href='../admin/admin.synchronization.php' target='_blank'>Data Synchronization</a></li>
		</ol>
		from admin panel.</p>");
}

xoops_cp_footer();
?>