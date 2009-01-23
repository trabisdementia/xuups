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

define("_MB_PUB_ALLCAT", "All categories");
define("_MB_PUB_AUTO_LAST_ITEMS", "Automatically display last item(s)?");
define("_MB_PUB_CATEGORY", "Category");
define("_MB_PUB_CHARS", "Length of the title");
define("_MB_PUB_COMMENTS", "Comment(s)");
define("_MB_PUB_DATE", "Published date");
define("_MB_PUB_DISP", "Display");
define("_MB_PUB_DISPLAY_CATEGORY", "Display the category name?");
define("_MB_PUB_DISPLAY_COMMENTS", "Display comment count?");
define("_MB_PUB_DISPLAY_TYPE", "Display type :");
define("_MB_PUB_DISPLAY_TYPE_BLOCK", "Each item is a block");
define("_MB_PUB_DISPLAY_TYPE_BULLET", "Each item is a bullet");
define("_MB_PUB_DISPLAY_WHO_AND_WHEN", "Display the poster and date?");
define("_MB_PUB_FULLITEM", "Read the complete article");
define("_MB_PUB_HITS", "Number of hits");
define("_MB_PUB_ITEMS", "Articles");
define("_MB_PUB_LAST_ITEMS_COUNT", "if yes, how many items to display?");
define("_MB_PUB_LENGTH", " characters");
define("_MB_PUB_ORDER", "Display order");
define("_MB_PUB_POSTEDBY", "Published by");
define("_MB_PUB_READMORE", "Read more...");
define("_MB_PUB_READS", "reads");
define("_MB_PUB_SELECT_ITEMS", "if no, select the articles to be displayed :");
define("_MB_PUB_SELECTCAT", "Display the articles of :");
define("_MB_PUB_VISITITEM", "Visit the");
define("_MB_PUB_WEIGHT", "List by weight");
define("_MB_PUB_WHO_WHEN", "Published by %s on %s");
//bd tree block hack
define("_MB_PUB_LEVELS", "levels");
define("_MB_PUB_CURRENTCATEGORY", "Current Category");
define("_MB_PUB_ASC", "ASC");
define("_MB_PUB_DESC", "DESC");
define("_MB_PUB_SHOWITEMS", "Show Items");
//--/bd

define("_MB_PUB_FILES", "files");
define("_MB_PUB_DIRECTDOWNLOAD", "Direct link to dowload the file instead of a link to the article?");
define("_MB_PUB_FROM", "Select articles <br />from ");
define("_MB_PUB_UNTIL", "&nbsp;&nbsp;to");
define("_MB_PUB_DATE_FORMAT", "Date format must be mm/dd/yyy");
define("_MB_PUB_ARTICLES_FROM_TO", "Articles published between %s and %s");

define("_MB_PUB_TRUNCATE", "Truncate summary text at the given bytes (0 will disable this feature) :");
?>
