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

define("_MB_PUB_ALLCAT", "Bütün Kategoriler");
define("_MB_PUB_AUTO_LAST_ITEMS", "Son eklenenleri otomatik göster)?");
define("_MB_PUB_CATEGORY", "Kategori");
define("_MB_PUB_CHARS", "Baþlýk Uzunluðu");
define("_MB_PUB_COMMENTS", "Komutlar");
define("_MB_PUB_DATE", "Yayýnlama Tarihi");
define("_MB_PUB_DISP", "Display");
define("_MB_PUB_DISPLAY_CATEGORY", "Kategori Ýsmini Göster?");
define("_MB_PUB_DISPLAY_COMMENTS", "Display comment count?");
define("_MB_PUB_DISPLAY_TYPE", "Görünüm Tipi :");
define("_MB_PUB_DISPLAY_TYPE_BLOCK", "Herbiri bir kategoridir");
define("_MB_PUB_DISPLAY_TYPE_BULLET", "Each item is a bullet");
define("_MB_PUB_DISPLAY_WHO_AND_WHEN", "Afiþ ve Tarihi göster?");
define("_MB_PUB_FULLITEM", "Devamý...");
define("_MB_PUB_HITS", "Okunma Sayýsý");
define("_MB_PUB_ITEMS", "Makaleler");
define("_MB_PUB_LAST_ITEMS_COUNT", "'Evet' seçilirse, how many items to display?");
define("_MB_PUB_LENGTH", " karakterler");
define("_MB_PUB_ORDER", "Display order");
define("_MB_PUB_POSTEDBY", "Yayýnlayan");
define("_MB_PUB_READMORE", "Devamý...");
define("_MB_PUB_READS", "okumalar");
define("_MB_PUB_SELECT_ITEMS", "'Hayýr' seçilirse, select the articles to be displayed :");
define("_MB_PUB_SELECTCAT", "Display the articles of :");
define("_MB_PUB_VISITITEM", "Ziyaret et");
define("_MB_PUB_WEIGHT", "Liste geniþliði");
define("_MB_PUB_WHO_WHEN", "Yayýnlayan %s %s");
//bd tree block hack
define("_MB_PUB_LEVELS", "seviyeler");
define("_MB_PUB_CURRENTCATEGORY", "Mevcut Kategori");
define("_MB_PUB_ASC", "ASC");
define("_MB_PUB_DESC", "DESC");
define("_MB_PUB_SHOWITEMS", "Öðeleri Göster");
//--/bd
?>