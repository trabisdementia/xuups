<?php

/**
* $Id: blocks.php 3196 2008-06-23 17:16:01Z xoops-magazine $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

/*global $xoopsConfig, $xoopsModule, $xoopsModuleConfig;
If (isset($xoopsModuleConfig) && isset($xoopsModule) && $xoopsModule->getVar('dirname') == 'publisher') {
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

define("_MB_PUB_ALLCAT", "Alle Kategorien");
define("_MB_PUB_AUTO_LAST_ITEMS", "Automatisch Anzeige des letzten Artikels (s)?");
define("_MB_PUB_CATEGORY", "Kategorie");
define("_MB_PUB_CHARS", "Länge des Titels");
define("_MB_PUB_COMMENTS", "Kommentar(e)");
define("_MB_PUB_DATE", "Veröffentlicht am");
define("_MB_PUB_DISP", "Anzeige");
define("_MB_PUB_DISPLAY_CATEGORY", "Kategoriename anzeigen?");
define("_MB_PUB_DISPLAY_COMMENTS", "Anzahl der Kommentare anzeigen?");
define("_MB_PUB_DISPLAY_TYPE", "Anzeige Typ:");
define("_MB_PUB_DISPLAY_TYPE_BLOCK", "Jeder Artikel als Block");
define("_MB_PUB_DISPLAY_TYPE_BULLET", "Jeder Artikel ein Punkt (Icon)");
define("_MB_PUB_DISPLAY_WHO_AND_WHEN", "Autor und Datum anzeigen?");
define("_MB_PUB_FULLITEM", "Artikel komplett lesen");
define("_MB_PUB_HITS", "Anzahl der Aufrufe");
define("_MB_PUB_ITEMS", "Artikel");
define("_MB_PUB_LAST_ITEMS_COUNT", "Wenn ja, wie viele Artikel sollen angezeigt werden?");
define("_MB_PUB_LENGTH", "Eigenschaften");
define("_MB_PUB_ORDER", "Auftrag anzeigen");
define("_MB_PUB_POSTEDBY", "Veröffentlicht von");
define("_MB_PUB_READMORE", "Lesen Sie mehr...");
define("_MB_PUB_READS", "Lesen");
define("_MB_PUB_SELECT_ITEMS", "Wenn nein, wähle den Artikel zum Anzeigen:");
define("_MB_PUB_SELECTCAT", "Zeige Artikel von:");
define("_MB_PUB_VISITITEM", "Besuchen");
define("_MB_PUB_WEIGHT", "Sortierung nach Gewichtung");
define("_MB_PUB_WHO_WHEN", "Veröffentlicht von %s am %s");
//bd tree block hack
define("_MB_PUB_LEVELS", "Levels");
define("_MB_PUB_CURRENTCATEGORY", "Aktuelle Kategorie");
define("_MB_PUB_ASC", "Nach Datum");
define("_MB_PUB_DESC", "Nach Titel");
define("_MB_PUB_SHOWITEMS", "Zeige Artikel");
//--/bd

define("_MB_PUB_FILES", "Dateien");
define("_MB_PUB_DIRECTDOWNLOAD", "Direct link to dowload the file instead of a link to the article?");
define("_MB_PUB_FROM", "Gewählte Artikel von <br />von ");
define("_MB_PUB_UNTIL", "&nbsp;&nbsp;to");
define("_MB_PUB_DATE_FORMAT", "Datumsformat muss sein mm/dd/yyy");
define("_MB_PUB_ARTICLES_FROM_TO", "Artikel veröffentlicht zwischen %s und %s");
?>