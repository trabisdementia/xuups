<?php

/**
* $Id: blocks.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Dutch translation: Maurits Lamers <maurits@weidestraat.nl>
* License: GNU
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

define("_MB_PUB_ALLCAT", "Alle categorieën");
define("_MB_PUB_AUTO_LAST_ITEMS", "Automatisch laten zien van meest recente item(s)?");
define("_MB_PUB_CATEGORY", "Categorie");
define("_MB_PUB_CHARS", "Lengte van de titel");
define("_MB_PUB_COMMENTS", "Commentaar");
define("_MB_PUB_DATE", "Datum van Publicatie");
define("_MB_PUB_DISP", "Weergave");
define("_MB_PUB_DISPLAY_CATEGORY", "Categorienaam laten zien?");
define("_MB_PUB_DISPLAY_COMMENTS", "Hoeveelheid commentaar laten zien?");
define("_MB_PUB_DISPLAY_TYPE", "Weergave-type :");
define("_MB_PUB_DISPLAY_TYPE_BLOCK", "Elk item is een blok");
define("_MB_PUB_DISPLAY_TYPE_BULLET", "Elk item is een lijst item (bullet)");
define("_MB_PUB_DISPLAY_WHO_AND_WHEN", "De afzender en datum laten zien?");
define("_MB_PUB_FULLITEM", "Het hele artikel lezen");
define("_MB_PUB_HITS", "Aantal keer gelezen (Number of hits)");
define("_MB_PUB_ITEMS", "Artikelen");
define("_MB_PUB_LAST_ITEMS_COUNT", "Indien ja, hoeveel items weergeven?");
define("_MB_PUB_LENGTH", " karakters");
define("_MB_PUB_ORDER", "Weergavevolgorde");
define("_MB_PUB_POSTEDBY", "Gepubliceerd door");
define("_MB_PUB_READMORE", "Lees meer...");
define("_MB_PUB_READS", "keer gelezen");
define("_MB_PUB_SELECT_ITEMS", "Indien nee, kies de artikelen om te laten zien :");
define("_MB_PUB_SELECTCAT", "Laat de artikelen zien van :");
define("_MB_PUB_VISITITEM", "Bezoek de");
define("_MB_PUB_WEIGHT", "Sorteer op gewicht");
define("_MB_PUB_WHO_WHEN", "Gepubliceerd door %s op %s");

//bd tree block hack
define("_MB_PUB_LEVELS", "niveau's");
define("_MB_PUB_CURRENTCATEGORY", "Huidige Categorie");
define("_MB_PUB_ASC", "Opl");
define("_MB_PUB_DESC", "Afl");
define("_MB_PUB_SHOWITEMS", "Toon Items");
//--/bd
?>
