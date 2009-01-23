<?php

/**
* $Id: blocks.php,v 1.11 2005/10/31 13:18:45 malanciault Exp $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
* Translated by irxoops.org till 2.13 & updated and edited in 2.13 by stranger <www.impresscms.ir>
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

define("_MB_PUB_ALLCAT", "تمام بخش‌ها");
define("_MB_PUB_AUTO_LAST_ITEMS", "نمایش خودكار آخرین مقالات؟");
define("_MB_PUB_CATEGORY", "بخش");
define("_MB_PUB_CHARS", "طول عنوان");
define("_MB_PUB_COMMENTS", "توضیحات");
define("_MB_PUB_DATE", "تاریخ انتشار");
define("_MB_PUB_DISP", "نمایش");
define("_MB_PUB_DISPLAY_CATEGORY", "نمایش اسم بخش؟");
define("_MB_PUB_DISPLAY_COMMENTS", "نمایش تعداد نظر ها؟");
define("_MB_PUB_DISPLAY_TYPE", "نمایش نوع :");
define("_MB_PUB_DISPLAY_TYPE_BLOCK", "کدام قسمت مسدود است؟");
define("_MB_PUB_DISPLAY_TYPE_BULLET", "هر عنوان مانند یک گلوله است");
define("_MB_PUB_DISPLAY_WHO_AND_WHEN", "نمایش آگهی و تاریخ?");
define("_MB_PUB_FULLITEM", "خواندن متن کامل مقاله");
define("_MB_PUB_HITS", "تعداد بازدید ها");
define("_MB_PUB_ITEMS", "مقالات");
define("_MB_PUB_LAST_ITEMS_COUNT", "اگر بله, چند مقاله نمایش داده شود؟");
define("_MB_PUB_LENGTH", " ویژگیها");
define("_MB_PUB_ORDER", "نوع چینش نمایش");
define("_MB_PUB_POSTEDBY", "منتشر شده توسط");
define("_MB_PUB_READMORE", "ادامه دارد ...");
define("_MB_PUB_READS", "خوانده ها");
define("_MB_PUB_SELECT_ITEMS", "اگر نه، مقالاتی را كه باید نمایش داده شوند انتخاب كنید :");
define("_MB_PUB_SELECTCAT", "نمایش مقالات:");
define("_MB_PUB_VISITITEM", "دیدن کردن از");
define("_MB_PUB_WEIGHT", "لیست شده با وزن");
define("_MB_PUB_WHO_WHEN", "منتشر شده توسط %s در %s");
//bd tree block hack
define("_MB_PUB_LEVELS", "سطوح");
define("_MB_PUB_CURRENTCATEGORY", "شاخه فعلی");
define("_MB_PUB_ASC", "صعودی");
define("_MB_PUB_DESC", "نزولی");
define("_MB_PUB_SHOWITEMS", "موارد را نشان بده");
//--/bd

define("_MB_PUB_FILES", "پرونده ها");
define("_MB_PUB_DIRECTDOWNLOAD", "لینک مستقیم به پرونده ها به جای لینک به مقالات؟");
define("_MB_PUB_FROM", "انتخاب مقالات <br />از ");
define("_MB_PUB_UNTIL", "&nbsp;&nbsp;تا");
define("_MB_PUB_DATE_FORMAT", "نوع تاریخ باید بر اساس mm/dd/yyyy باشد");
define("_MB_PUB_ARTICLES_FROM_TO", "مقالات منتشر شده از تاریخ %s تا %s");
?>