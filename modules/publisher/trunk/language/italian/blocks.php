<?php

/**
* $Id: blocks.php 331 2007-12-23 16:01:11Z malanciault $
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

define("_MB_PUB_ALLCAT", "Tutte le categorie");
define("_MB_PUB_AUTO_LAST_ITEMS", "Mostra automaticamente l'ultimo - o gli ultimi - elementi?");
define("_MB_PUB_CATEGORY", "Categoria");
define("_MB_PUB_CHARS", "Lunghezza del titolo");
define("_MB_PUB_COMMENTS", "Commenti");
define("_MB_PUB_DATE", "Data di pubblicazione");
define("_MB_PUB_DISP", "Mostra");
define("_MB_PUB_DISPLAY_CATEGORY", "Mostra il nome della categoria?");
define("_MB_PUB_DISPLAY_COMMENTS", "Mostra il contatore dei commenti?");
define("_MB_PUB_DISPLAY_TYPE", "Modalità di visualizzazione:");
define("_MB_PUB_DISPLAY_TYPE_BLOCK", "Ogni elemento come blocco");
define("_MB_PUB_DISPLAY_TYPE_BULLET", "Ogni elemento come lista");
define("_MB_PUB_DISPLAY_WHO_AND_WHEN", "Mostra Autore e Data?");
define("_MB_PUB_FULLITEM", "Leggi l'articolo completo");
define("_MB_PUB_HITS", "Numero di letture");
define("_MB_PUB_ITEMS", "Articoli");
define("_MB_PUB_LAST_ITEMS_COUNT", "Se si, quanti?");
define("_MB_PUB_LENGTH", " caratteri");
define("_MB_PUB_ORDER", "Mostra ordine");
define("_MB_PUB_POSTEDBY", "Pubblicato da");
define("_MB_PUB_READMORE", "Leggi tutto..");
define("_MB_PUB_READS", "letture");
define("_MB_PUB_SELECT_ITEMS", "Se no, seleziona gli articoli da mostrare:");
define("_MB_PUB_SELECTCAT", "Mostra gli articoli di:");
define("_MB_PUB_VISITITEM", "Visita il");
define("_MB_PUB_WEIGHT", "Elenca in base al peso");
define("_MB_PUB_WHO_WHEN", "Pubblicato da %s il %s");
?>