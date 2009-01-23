<?php
/**
* PDF class
*
* System tool that allow's you to generate PDF files from your articles
*
* @copyright	The ImpressCMS Project http://www.impresscms.org/
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @package		Modules (publisher)
* @since		2.14
* @author		Sina Asghari (AKA stranger) <stranger@impresscms.ir>
* @version		$Id$
*/

error_reporting(0);
include_once 'header.php';
global $publisher_item_handler, $publisher_category_handler, $xoopsUser, $xoopsConfig, $xoopsModuleConfig, $xoopsModule;

$itemid = isset($_GET['itemid']) ? intval($_GET['itemid']) : 0;
$item_page_id = isset($_GET['page']) ? intval($_GET['page']) : -1;

if ($itemid == 0) {
	redirect_header("javascript:history.go(-1)", 1, _MD_PUB_NOITEMSELECTED);
	exit();
}

// Creating the item object for the selected item
$itemObj = $publisher_item_handler->get($itemid);

// if the selected item was not found, exit
if (!$itemObj) {
	redirect_header("javascript:history.go(-1)", 1, _MD_PUB_NOITEMSELECTED);
	exit();
}

// Creating the category object that holds the selected item
$categoryObj =& $publisher_category_handler->get($itemObj->categoryid());

// Check user permissions to access that category of the selected item
if (!(publisher_itemAccessGranted($itemObj))) {
	redirect_header("javascript:history.go(-1)", 1, _NOPERM);
	exit;
}

require_once ICMS_PDF_LIB_PATH.'/tcpdf.php';
$filename = XOOPS_ROOT_PATH.'/modules/publisher/'.$xoopsConfig['language'].'/main.php';
if (file_exists( $filename)) {
	include_once $filename;
} else {
	include_once XOOPS_ROOT_PATH.'/modules/publisher/language/english/main.php';
}

$filename = ICMS_PDF_LIB_PATH.'/config/lang/'._LANGCODE.'.php';
if(file_exists($filename)) {
	include_once $filename;
} else {
	include_once ICMS_PDF_LIB_PATH.'/config/lang/en.php';
}

$dateformat = $itemObj->datesub();
$sender_inform = sprintf(_MD_PUB_WHO_WHEN, $itemObj->posterName(), $itemObj->datesub());
$content = '<b><i><u><a href="'.XOOPS_URL.'/modules/publisher/item.php?itemid='.$itemid.'" title="'.$myts->undoHtmlSpecialChars($itemObj->title()).'">'.$myts->undoHtmlSpecialChars($itemObj->title()).'</a></u></i></b><br /><b>'._MD_PUB_CATEGORY.' : <a href="'.XOOPS_URL.'/modules/publisher/category.php?categoryid='.$itemObj->categoryid().'" title="'.$myts->undoHtmlSpecialChars($categoryObj->name()).'">'.$myts->undoHtmlSpecialChars($categoryObj->name()).'</a></b><br /><b>'.$sender_inform.'</b><br />'.$myts->undoHtmlSpecialChars($itemObj->plain_maintext()).'';
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);

$doc_title = $myts->undoHtmlSpecialChars($itemObj->title());
$doc_keywords = 'ICMS';

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(PDF_AUTHOR);
$pdf->SetTitle($doc_title);
$pdf->SetSubject($doc_title);
$pdf->SetKeywords($doc_keywords);

$firstLine = $xoopsConfig['sitename'];
$secondLine =  $xoopsConfig['slogan'];
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $firstLine, $secondLine);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); //set image scale factor

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->setLanguageArray($l); //set language items


//initialize document
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->writeHTML($content, true, 0);
$pdf->Output();
?>