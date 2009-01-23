<?php // Traducción de www.riosoft.es | www.rioxoops.es
//Revisión y actualización por debianus
/**
* $Id: blocks.php 3334 2008-06-26 22:48:28Z juancj $
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

define("_MB_PUB_ALLCAT", "Todas las categorías");
define("_MB_PUB_AUTO_LAST_ITEMS", "¿Mostrar automáticamente las últimas publicaciones?");
define("_MB_PUB_CATEGORY", "Categoría");
define("_MB_PUB_CHARS", "Longitud el título");
define("_MB_PUB_COMMENTS", "Comentario(s)");
define("_MB_PUB_DATE", "Fecha de Publicación");
define("_MB_PUB_DISP", "Visualizar");
define("_MB_PUB_DISPLAY_CATEGORY", "¿Mostrar el nombre de la categoría?");
define("_MB_PUB_DISPLAY_COMMENTS", "¿Mostrar el número de comentarios?");
define("_MB_PUB_DISPLAY_TYPE", "Mostrar tipo :");
define("_MB_PUB_DISPLAY_TYPE_BLOCK", "Cada elemento es un bloque");
define("_MB_PUB_DISPLAY_TYPE_BULLET", "Cada elemento es un punto");
define("_MB_PUB_DISPLAY_WHO_AND_WHEN", "¿Mostrar autor y fecha?");
define("_MB_PUB_FULLITEM", "Leer el artículo completo");
define("_MB_PUB_HITS", "Lecturas");
define("_MB_PUB_ITEMS", "Artículos");
define("_MB_PUB_LAST_ITEMS_COUNT", "si dijo sí, ¿cuántos elementos han de mostrarse?");
define("_MB_PUB_LENGTH", " caracteres");
define("_MB_PUB_ORDER", "Orden");
define("_MB_PUB_POSTEDBY", "Publicado por");
define("_MB_PUB_READMORE", "Leer más...");
define("_MB_PUB_READS", "lecturas");
define("_MB_PUB_SELECT_ITEMS", "si dijo no, determine qué artículos han de ser mostrados :");
define("_MB_PUB_SELECTCAT", "Mostrar artículos de :");
define("_MB_PUB_VISITITEM", "Visitar");
define("_MB_PUB_WEIGHT", "Lista por 'peso'");
define("_MB_PUB_WHO_WHEN", "Publicado por %s el %s");
//bd tree block hack
define("_MB_PUB_LEVELS", "niveles");
define("_MB_PUB_CURRENTCATEGORY", "Categoría actual");
define("_MB_PUB_ASC", "ASC");
define("_MB_PUB_DESC", "DESC");
define("_MB_PUB_SHOWITEMS", "Mostrar Elementos");
//--/bd

define("_MB_PUB_FILES", "archivos");
define("_MB_PUB_DIRECTDOWNLOAD", "¿Enlace directo al archivo en lugar de al artículo?");

//Añadido en la versión 2.14

define("_MB_PUB_FROM", "Seleccionar artículos <br />desde ");
define("_MB_PUB_UNTIL", "&nbsp;&nbsp;a");
define("_MB_PUB_DATE_FORMAT", "El formato de la fecha debe ser mm/dd/yyy");
define("_MB_PUB_ARTICLES_FROM_TO", "Artículos publicados entre %s y %s");
?>