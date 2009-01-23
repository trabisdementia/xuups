<?php

/**
* $Id: blocks.php,v 1.13 2007/02/03 16:23:35 malanciault Exp $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

/*global $xoopsConfig, $xoopsModule, $xoopsModuleConfig;
if (isset($xoopsModuleConfig) && isset($xoopsModule) && $xoopsModule->getVar('dirname') == 'publisher') {
	$itemType = $xoopsModuleConfig['itemtype'];
} else {
	$hModule = &xoops_gethandler('module');
	$hModConfig = &xoops_gethandler('config');
	if ($publisher_Module = &$hModule->getByDirname('publisher')) {
		$module_id = $publisher_Module->getVar('mid');
		$publisher_Config = &$hModConfig->getConfigsByCat(0, $publisher_Module->getVar('mid'));
		$itemType = $publisher_Config['itemtype'];
	} else {
		$itemType = 'article';
	}
}

include_once(XOOPS_ROOT_PATH . "/modules/publisher/language/" . $xoopsConfig['language'] . "/plugin/" . $itemType . "/blocks.php");
*/
// Blocks

define('_MB_PUB_ALLCAT', 'Alle Kategorier');
define('_MB_PUB_AUTO_LAST_ITEMS', 'Automatisk visning af sidste post(er)?');
define('_MB_PUB_CATEGORY', 'Kategori');
define('_MB_PUB_CHARS', 'Længde på titel');
define('_MB_PUB_COMMENTS', 'Kommentar');
define('_MB_PUB_DATE', 'Udgivet den');
define('_MB_PUB_DISP', 'Vis');
define('_MB_PUB_DISPLAY_CATEGORY', 'Vis kategori navnet?');
define('_MB_PUB_DISPLAY_COMMENTS', 'Vis antallat af kommentarer?');
define('_MB_PUB_DISPLAY_TYPE', 'Visnings type:');
define('_MB_PUB_DISPLAY_TYPE_BLOCK', 'Hver post er en blok');
define('_MB_PUB_DISPLAY_TYPE_BULLET', 'Hver post er en liste');
define('_MB_PUB_DISPLAY_WHO_AND_WHEN', 'Vis indsender og dato?');
define('_MB_PUB_FULLITEM', 'Læs hele artiklen');
define('_MB_PUB_HITS', 'Antal hits');
define('_MB_PUB_ITEMS', 'Artikler');
define('_MB_PUB_LAST_ITEMS_COUNT', 'hvis ja, hvor mange poster vil du vise?');
define('_MB_PUB_LENGTH', ' katakter');
define('_MB_PUB_ORDER', 'Rækkefølge');
define('_MB_PUB_POSTEDBY', 'Indsendt af');
define('_MB_PUB_READMORE', 'Læs mere ....');
define('_MB_PUB_READS', 'læst');
define('_MB_PUB_SELECT_ITEMS', 'hvis nej, vælg hvilke artikler der skal vises:');
define('_MB_PUB_SELECTCAT', 'Vis artiklerne af :');
define('_MB_PUB_VISITITEM', 'Besøg den');
define('_MB_PUB_WEIGHT', 'Vis efter vægt');
define('_MB_PUB_WHO_WHEN', 'Indsendt af %s den %s');
//bd tree block hack
define('_MB_PUB_LEVELS', 'niveau');
define('_MB_PUB_CURRENTCATEGORY', 'Aktuel kategori');
define('_MB_PUB_ASC', 'Stigende');
define('_MB_PUB_DESC', 'Faldende');
define('_MB_PUB_SHOWITEMS', 'Vis poster');
//--/bd

define('_MB_PUB_FILES', 'filer');
define('_MB_PUB_DIRECTDOWNLOAD', 'Direkte link til download af fil, i stedet for et link til artiklen?');
define("_MB_PUB_FROM", "Select articles <br />from ");
define("_MB_PUB_UNTIL", "&nbsp;&nbsp;to");
define("_MB_PUB_DATE_FORMAT", "Date format must be mm/dd/yyy");
define("_MB_PUB_ARTICLES_FROM_TO", "Articles published between %s and %s");
?>