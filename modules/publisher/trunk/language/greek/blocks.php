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

define("_MB_PUB_ALLCAT", "Όλες οι κατηγορίες");
define("_MB_PUB_AUTO_LAST_ITEMS", "Να εμφανίζονται αυτόματα τα τελευταία αντικείμενα?");
define("_MB_PUB_CATEGORY", "Κατηγορία");
define("_MB_PUB_CHARS", "Μήκος του τίτλου");
define("_MB_PUB_COMMENTS", "Σχόλια");
define("_MB_PUB_DATE", "Ημερομηνία δημοσίευσης");
define("_MB_PUB_DISP", "Εμφάνιση");
define("_MB_PUB_DISPLAY_CATEGORY", "Εμφάνιση του τίτλου της κατηγορίας;");
define("_MB_PUB_DISPLAY_COMMENTS", "Εμφάνιση του αριθμού των σχολίων;");
define("_MB_PUB_DISPLAY_TYPE", "Τύπος εμφάνισης : ");
define("_MB_PUB_DISPLAY_TYPE_BLOCK", "Κάθε αντικείμενο να είναι block");
define("_MB_PUB_DISPLAY_TYPE_BULLET", "Κάθε αντικείμενο να είναι κουκκίδα");
define("_MB_PUB_DISPLAY_WHO_AND_WHEN", "Εμφάνιση του αποστολέα και της ημερομηνίας;");
define("_MB_PUB_FULLITEM", "Διαβάστε όλο το άρθρο");
define("_MB_PUB_HITS", "Αριθμός εμφανίσεων");
define("_MB_PUB_ITEMS", "Άρθρα");
define("_MB_PUB_LAST_ITEMS_COUNT", "Αν ναι, πόσα αντικείμενα να εμφανίζονται;");
define("_MB_PUB_LENGTH", " χαρακτήρες");
define("_MB_PUB_ORDER", "Σειρά εμφάνισης");
define("_MB_PUB_POSTEDBY", "Δημοσιεύτηκε από τον");
define("_MB_PUB_READMORE", "Διαβάστε περισσότερα...");
define("_MB_PUB_READS", "αναγνώσεις");
define("_MB_PUB_SELECT_ITEMS", "Αν όχι, επιλέξτε ποια άρθρα να εμφανίζονται :");
define("_MB_PUB_SELECTCAT", "Εμφάνιση των άρθρων της κατηγορίας :");
define("_MB_PUB_VISITITEM", "Επισκευθείτε τον");
define("_MB_PUB_WEIGHT", "Εμφάνιση κατά βάρος");
define("_MB_PUB_WHO_WHEN", "Δημοσιεύτηκε από τον %s στις %s");
?>