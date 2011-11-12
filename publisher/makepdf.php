<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Publisher
 * @subpackage      Action
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author            Sina Asghari (AKA stranger) <stranger@impresscms.ir>
 * @version         $Id$
 */

error_reporting(0);
include_once dirname(__FILE__) . '/header.php';

$itemid = Xmf_Request::getInt('itemid');
$item_page_id = Xmf_Request::getInt('page', -1);

if ($itemid == 0) {
    redirect_header("javascript:history.go(-1)", 1, _MD_PUBLISHER_NOITEMSELECTED);
    exit();
}

// Creating the item object for the selected item
$itemObj = $publisher->getHandler('item')->get($itemid);

// if the selected item was not found, exit
if (!$itemObj) {
    redirect_header("javascript:history.go(-1)", 1, _MD_PUBLISHER_NOITEMSELECTED);
    exit();
}

// Creating the category object that holds the selected item
$categoryObj =& $publisher->getHandler('category')->get($itemObj->categoryid());

// Check user permissions to access that category of the selected item
if (!$itemObj->accessGranted()) {
    redirect_header("javascript:history.go(-1)", 1, _NOPERM);
    exit();
}

xoops_loadLanguage('main', PUBLISHER_DIRNAME);

$dateformat = $itemObj->datesub();
$sender_inform = sprintf(_MD_PUBLISHER_WHO_WHEN, $itemObj->posterName(), $itemObj->datesub());
$mainImage = $itemObj->getMainImage();

$content = '';
if ($mainImage['image_path'] != '') {
    $content .= '<img src="' . $mainImage['image_path'] . '" alt="' . $myts->undoHtmlSpecialChars($mainImage['image_name']) . '"/>';
}
$content .= '<b><i><u><a href="' . PUBLISHER_URL . '/item.php?itemid=' . $itemid . '" title="' . $myts->undoHtmlSpecialChars($itemObj->title()) . '">' . $myts->undoHtmlSpecialChars($itemObj->title()) . '</a></u></i></b>';
$content .= '<br />';
$content .= '<b>' . _CO_PUBLISHER_CATEGORY . ' : <a href="' . PUBLISHER_URL . '/category.php?categoryid=' . $itemObj->categoryid() . '" title="' . $myts->undoHtmlSpecialChars($categoryObj->name()) . '">' . $myts->undoHtmlSpecialChars($categoryObj->name()) . '</a></b>';
$content .= '<br />';
$content .= '<b>' . $sender_inform . '</b>';
$content .= '<br /><br />';
$content .= $myts->undoHtmlSpecialChars($itemObj->plain_maintext());

$pdf = new Xmf_Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$doc_title = $myts->undoHtmlSpecialChars($itemObj->title());
$doc_keywords = 'XOOPS';

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(PDF_AUTHOR);
$pdf->SetTitle($doc_title);
$pdf->SetSubject($doc_title);
$pdf->SetKeywords($doc_keywords);

$firstLine = publisher_convertCharset($xoopsConfig['sitename']);
$secondLine = publisher_convertCharset($xoopsConfig['slogan']);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $firstLine, $secondLine);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//set auto page breaks
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); //set image scale factor

$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//initialize document
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->writeHTML($content, true, 0, true, 0);
$pdf->Output();