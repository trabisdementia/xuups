<?php

// $Id$
// ported to newbb from xforum by Defkon1 - www.xoopsitalia.org

error_reporting(0);
include 'header.php';
$GLOBALS['xoopsLogger']->activated = false;

require XOOPS_ROOT_PATH.'/Frameworks/tcpdf/tcpdf.php';
$filename = XOOPS_ROOT_PATH.'/Frameworks/tcpdf/config/lang/'._LANGCODE.'.php';
if(file_exists($filename)) {
	include_once $filename;
} else {
	include_once XOOPS_ROOT_PATH.'/Frameworks/tcpdf/config/lang/en.php';
}
error_reporting(0);

if(empty($_POST["pdf_data"])){
	
$newbb = isset($_GET['forum']) ? intval($_GET['forum']) : 0;
$topic_id = isset($_GET['topic_id']) ? intval($_GET['topic_id']) : 0;
$post_id = !empty($_GET['post_id']) ? intval($_GET['post_id']) : 0;

if ( empty($post_id) )  die(_MD_ERRORTOPIC);

$post_handler =& xoops_getmodulehandler('post', 'newbb');
$post = & $post_handler->get($post_id);
if(!$approved = $post->getVar('approved'))    die(_MD_NORIGHTTOVIEW);

$post_data = $post_handler->getPostForPDF($post);

$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
$newbbtopic =& $topic_handler->getByPost($post_id);
$topic_id = $newbbtopic->getVar('topic_id');
if(!$approved = $newbbtopic->getVar('approved'))    die(_MD_NORIGHTTOVIEW);

$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
$newbb = ($newbb)?$newbb:$newbbtopic->getVar('forum_id');
$viewtopic_forum =& $forum_handler->get($newbb);
if (!$forum_handler->getPermission($viewtopic_forum))    die(_MD_NORIGHTTOACCESS);
if (!$topic_handler->getPermission($viewtopic_forum, $newbbtopic->getVar('topic_status'), "view"))   die(_MD_NORIGHTTOVIEW);
//if ( !$newbbdata =  $topic_handler->getViewData($topic_id, $newbb) )die(_MD_newbbNOEXIST);

$pdf_data['title'] = $viewtopic_forum->getVar("forum_name");
$pdf_data['subtitle'] = $newbbtopic->getVar('topic_title');
$pdf_data['subsubtitle'] = $post_data['subject'];
$pdf_data['date'] = $post_data['date'];
$pdf_data['content'] = $post_data['text'];
$pdf_data['author'] = $post_data['author'];

}else{
	$pdf_data = unserialize(base64_decode($_POST["pdf_data"]));
}

$pdf_data['filename'] = preg_replace("/[^0-9a-z\-_\.]/i",'', $pdf_data["title"]);
$pdf_data['title'] = NEWBB_PDF_SUBJECT.': '.$pdf_data["title"];
if (!empty($pdf_data['subtitle'])){
	$pdf_data['subtitle'] = NEWBB_PDF_TOPIC.': '.$pdf_data['subtitle'];
}
$pdf_data['author'] = NEWBB_PDF_AUTHOR.': '.$pdf_data['author'];
$pdf_data['date'] = NEWBB_PDF_DATE. ': '.date(_DATESTRING, $pdf_data['date']);
$pdf_data['url'] = URL. ': '.$pdf_data['url'];

//Other stuff
$puff='<br />';
$puffer='<br />';

//create the A4-PDF...
$pdf=new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, _CHARSET, false);
if(method_exists($pdf, "encoding")){
	$pdf->encoding($pdf_data, _CHARSET);
	$pdf->encoding($pdf_config, _CHARSET);
}
$pdf->SetCreator($pdf_config['creator']);
$pdf->SetTitle($pdf_data['title']);
$pdf->SetAuthor($pdf_config['url']);
$pdf->SetSubject($pdf_data['author']);
$out=$pdf_config['url'].', '.$pdf_data['author'].', '.$pdf_data['title'].', '.$pdf_data['subtitle'];
$pdf->SetKeywords($out);
$pdf->SetAutoPageBreak(true,25);
$pdf->SetMargins($pdf_config['margin']['left'],$pdf_config['margin']['top'],$pdf_config['margin']['right']);
$pdf->Open();

//First page
$pdf->AddPage();
$pdf->SetXY(24,25);
$pdf->SetTextColor(10,60,160);
$pdf->SetFont($pdf_config['font']['slogan']['family'],$pdf_config['font']['slogan']['style'],$pdf_config['font']['slogan']['size']);
$pdf->WriteHTML($pdf_config['slogan'], $pdf_config['scale']);
$pdf->Image(XOOPS_ROOT_PATH.DS.'images'.DS.'logo.png',$pdf_config['logo']['left'],$pdf_config['logo']['top'],$pdf_config['logo']['width'],$pdf_config['logo']['height'],'',$pdf_config['url']);
$pdf->Line(25,30,190,30);
$pdf->SetXY(25,35);
$pdf->SetFont($pdf_config['font']['title']['family'],$pdf_config['font']['title']['style'],$pdf_config['font']['title']['size']);
$pdf->WriteHTML($pdf_data['title'],$pdf_config['scale']);

if (!empty($pdf_data['subtitle'])){
	$pdf->WriteHTML($puff,$pdf_config['scale']);
	$pdf->SetFont($pdf_config['font']['subtitle']['family'],$pdf_config['font']['subtitle']['style'],$pdf_config['font']['subtitle']['size']);
	$pdf->WriteHTML($pdf_data['subtitle'],$pdf_config['scale']);
}
if (!empty($pdf_data["subsubtitle"])) {
	$pdf->WriteHTML($puff,$pdf_config["scale"]);
	$pdf->SetFont($pdf_config["font"]["subsubtitle"]["family"],$pdf_config["font"]["subsubtitle"]["style"],$pdf_config["font"]["subsubtitle"]["size"]);
	$pdf->WriteHTML($pdf_data["subsubtitle"],$pdf_config["scale"]);
}

$pdf->WriteHTML($puff,$pdf_config['scale']);
$pdf->SetFont($pdf_config['font']['author']['family'],$pdf_config['font']['author']['style'],$pdf_config['font']['author']['size']);
$pdf->WriteHTML($pdf_data['author'],$pdf_config['scale']);
$pdf->WriteHTML($puff,$pdf_config['scale']);
$pdf->WriteHTML($pdf_data['date'],$pdf_config['scale']);
$pdf->WriteHTML($puff,$pdf_config['scale']);
$pdf->WriteHTML($pdf_data['url'],$pdf_config['scale']);
$pdf->WriteHTML($puff,$pdf_config['scale']);

$pdf->SetTextColor(0,0,0);
$pdf->WriteHTML($puffer,$pdf_config['scale']);

$pdf->SetFont($pdf_config['font']['content']['family'],$pdf_config['font']['content']['style'],$pdf_config['font']['content']['size']);
$pdf->WriteHTML($pdf_data['content'],$pdf_config['scale']);

$pdf->Output();
?>