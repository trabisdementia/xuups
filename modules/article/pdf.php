<?php
/**
 * FPDF creator framework for XOOPS
 *
 * Supporting multi-byte languages as well as utf-8 charset
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		frameworks
 */
 
ob_start();

/**
 * If no pdf_data is set, build it from the module
 *
 * <ul>The data fields to be built:
 *		<li>title</li>
 *		<li>subtitle (optional)</li>
 *		<li>subsubtitle (optional)</li>
 *		<li>date</li>
 *		<li>author</li>
 *		<li>content</li>
 *		<li>filename</li>
 * </ul>
 */
global $pdf_data;
if(!empty($_POST["pdf_data"])){
	$pdf_data = unserialize(base64_decode($_POST["pdf_data"]));
}elseif(!empty($pdf_data)){
	
}else{
	error_reporting(0);
	include "header.php";
	error_reporting(0);

	if(art_parse_args($args_num, $args, $args_str)){
		$args["article"] = @$args_num[0];
	}
	
	$article_id = intval( empty($_GET["article"])?@$args["article"]:$_GET["article"] );
	$category_id = intval( empty($_GET["category"])?@$args["category"]:$_GET["category"] );
	$page = intval( empty($_GET["page"])?@$args["page"]:$_GET["page"] );
	
	$article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
	$article_obj =& $article_handler->get($article_id);
	
	$category_id = empty($category_id)?$article_obj->getVar("cat_id"):intval($category_id);
	
	$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
	$category_obj =& $category_handler->get($category_id);
	
	if(empty($category_obj) || !$category_handler->getPermission($category_obj, "view")){
	    DIE(_NOPERM);
	}
	
	$article_data = array();
	
	// title
	$article_data["title"] = $article_obj->getVar("art_title");
	
	$article_data["author"] = $article_obj->getAuthor(true);
	
	// source
	$article_data["source"] = $article_obj->getVar("art_source");
	
	// publish time
	$article_data["time"] = $article_obj->getTime("l");
	
	// summary
	$article_data["summary"] = $article_obj->getSummary();
	
	// Keywords
	$article_data["keywords"] = $article_obj->getVar("art_keywords");
	
	// text of page
	$article_data["text"] = $article_obj->getText($page, "raw");
	
	// Build the pdf_data array
	$pdf_data["title"] 		= $article_data["title"];
	$pdf_data["subtitle"] = $category_obj->getVar("cat_title");
	if(!empty($article_data["text"]["title"])) {
		$print_data["subsubtitle"] = "#".$page." ".$article_data["text"]["title"];
	}
	$pdf_data["author"] 	= $article_data["author"]["name"];
	$tmp = array();
	if($article_data["source"]) {
		$tmp[] = $article_data["source"];
	}
	if($article_data["author"]["author"]) {
		$tmp[] = $article_data["author"]["author"];
	}
	if(count($tmp)){
		$pdf_data["author"] .= " (".implode(" ",$tmp).")";
	}
	$pdf_data["date"] 		= $article_data["time"];
	$pdf_data["content"] 	= "";
	if($article_data["keywords"]){
		$pdf_data["content"] .= art_constant("MD_KEYWORDS").": ".$article_data["keywords"]."<br /><br />";
	}
	if($article_data["summary"]){
		$pdf_data["content"] .= art_constant("MD_SUMMARY").": ".$article_data["summary"]."<br /><br />";
	}
	$pdf_data["content"] 	.= $article_data["text"]["body"]."<br />";
	$pdf_data["url"] = XOOPS_URL."/modules/".$GLOBALS["artdirname"]."/view.article.php".URL_DELIMITER."c".$category_id."/".$article_obj->getVar("art_id");
}
$pdf_data['filename'] = preg_replace("/[^0-9a-z\-_\.]/i", '', $pdf_data["title"]);

include XOOPS_ROOT_PATH."/Frameworks/fpdf/init.php";
error_reporting(0);
ob_end_clean();

$pdf =& new xoopsPDF($xoopsConfig["language"], _CHARSET);
$pdf->initialize();
$pdf->output($pdf_data);
?>