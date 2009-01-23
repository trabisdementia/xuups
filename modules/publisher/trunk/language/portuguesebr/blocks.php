<?php

/**
* $Id: blocks.php 2639 2008-06-03 22:25:36Z gibaphp $
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

define("_MB_PUB_ALLCAT", "Todas as categorias");
define("_MB_PUB_AUTO_LAST_ITEMS", "Exibir o(s) último(s) automaticamente?");
define("_MB_PUB_CATEGORY", "Categoria");
define("_MB_PUB_CHARS", "Comprimento do título");
define("_MB_PUB_COMMENTS", "Comentário(s)");
define("_MB_PUB_DATE", "Data da publicação");
define("_MB_PUB_DISP", "Exibição");
define("_MB_PUB_DISPLAY_CATEGORY", "Exibir o nome de categoria?");
define("_MB_PUB_DISPLAY_COMMENTS", "Exibir contador de comentário?");
define("_MB_PUB_DISPLAY_TYPE", "Exibir tipo :");
define("_MB_PUB_DISPLAY_TYPE_BLOCK", "Cada artigo é um bloco");
define("_MB_PUB_DISPLAY_TYPE_BULLET", "Cada artigo é um item");
define("_MB_PUB_DISPLAY_WHO_AND_WHEN", "Exibir o autor e a data?");
define("_MB_PUB_FULLITEM", "Leia o artigo completo");
define("_MB_PUB_HITS", "Número de cliques");
define("_MB_PUB_ITEMS", "Artigos");
define("_MB_PUB_LAST_ITEMS_COUNT", "Se positivo, quantos artigos para exibir?");
define("_MB_PUB_LENGTH", " caracteres");
define("_MB_PUB_ORDER", "Ordem de exibição");
define("_MB_PUB_POSTEDBY", "Publicado por");
define("_MB_PUB_READMORE", "Leia mais...");
define("_MB_PUB_READS", "Leituras");
define("_MB_PUB_SELECT_ITEMS", "Se não, selecione os artigos para serem exibidos :");
define("_MB_PUB_SELECTCAT", "Exibir os artigos  :");
define("_MB_PUB_VISITITEM", "Visite o");
define("_MB_PUB_WEIGHT", "Listar por peso");
define("_MB_PUB_WHO_WHEN", "Publicado por %s em %s");
//bd tree block hack
define("_MB_PUB_LEVELS", "Níveis");
define("_MB_PUB_CURRENTCATEGORY", "Categoria Atual");
define("_MB_PUB_ASC", "ASC");
define("_MB_PUB_DESC", "DESC");
define("_MB_PUB_SHOWITEMS", "Mostrar Items");
//--/bd

define("_MB_PUB_FILES", "arquivos");
define("_MB_PUB_DIRECTDOWNLOAD", "Link direto para download do arquivo em vez de uma link para o artigo?");
define("_MB_PUB_FROM", "Selecione Artigos <br />de ");
define("_MB_PUB_UNTIL", "&nbsp;&nbsp;para");
define("_MB_PUB_DATE_FORMAT", "Formato de data deve ser mm/dd/yyy");
define("_MB_PUB_ARTICLES_FROM_TO", "Os artigos publicados entre %s e %s");
?>