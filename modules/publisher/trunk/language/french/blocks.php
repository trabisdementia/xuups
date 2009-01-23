<?php

/**
* $Id: blocks.php 3443 2008-07-05 12:03:31Z gibaphp $
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

define ("_MB_PUB_ALLCAT", "Toutes les cat&eacute;gories");
define ("_MB_PUB_AUTO_LAST_ITEMS", "Afficher automatiquement les items r&eacute;cents?");
define ("_MB_PUB_CATEGORY", "Cat&eacute;gories");
define ("_MB_PUB_CHARS", "Longeur du titre");
define ("_MB_PUB_COMMENTS", "Commentaire (s)");
define ("_MB_PUB_DATE", "Date de publication");
define ("_MB_PUB_DISP", "Afficher");
define ("_MB_PUB_DISPLAY_CATEGORY", "Afficher les noms des cat&eacute;gories?");
define ("_MB_PUB_DISPLAY_COMMENTS", "Afficher le compte des commentaires");
define ("_MB_PUB_DISPLAY_TYPE", "Type d'affichage:");
define ("_MB_PUB_DISPLAY_TYPE_BLOCK", "Chaque item est un bloc");
define ("_MB_PUB_DISPLAY_TYPE_BULLET", "Chaque item est une puce");
define ("_MB_PUB_DISPLAY_WHO_AND_WHEN", "Afficher auteur et date?");
define ("_MB_PUB_FULLITEM", "Lire l'article au complet");
define ("_MB_PUB_HITS", "Nombre de clics");
define ("_MB_PUB_ITEMS", "Articles");
define ("_MB_PUB_LAST_ITEMS_COUNT", "Si oui, enafficher combien?");
define ("_MB_PUB_LENGTH", " caract&egrave;res");
define ("_MB_PUB_ORDER", "Afficher l'ordre");
define ("_MB_PUB_POSTEDBY", "Affich&eacute; par");
define ("_MB_PUB_READMORE", "Lire la suite...");
define ("_MB_PUB_READS", "Lus");
define ("_MB_PUB_SELECT_ITEMS", "sinon, selectionner les articles &agrave; afficher:");
define ("_MB_PUB_SELECTCAT", "Afficher les articles concernant:");
define ("_MB_PUB_VISITITEM", "Visitez le");
define ("_MB_PUB_WEIGHT", "Listage par poids");
define ("_MB_PUB_WHO_WHEN", "Affich&eacute; par %s le %s");
//bd tree block hack
define("_MB_PUB_LEVELS", "Niveaux");
define("_MB_PUB_CURRENTCATEGORY", "Catégorie courante");
define("_MB_PUB_ASC", "ASC");
define("_MB_PUB_DESC", "DESC");
define("_MB_PUB_SHOWITEMS", "Afficher les Items");
//--/bd

define("_MB_PUB_FILES", "fichiers");
define("_MB_PUB_DIRECTDOWNLOAD", "Lien direct pour télécharger le fichier au lieu d'un lien vers l'article?");
define("_MB_PUB_FROM", "Afficher les articles <br />à partir de");
define("_MB_PUB_UNTIL", "jusqu'à");
define("_MB_PUB_DATE_FORMAT", "Le format de la date doit être mm/dd/yyy");
define("_MB_PUB_ARTICLES_FROM_TO", "Articles publiées entre %s et %s");
?>