<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

$modversion['name'] = _MI_MYTABS_NAME;
$modversion['version'] = '2.00';
$modversion['description'] = _MI_MYTABS_DSC;
$modversion['author'] = "Xuups";
$modversion['credits'] = "Michael Wulff Nielsen <naish@klanen.net>(www.smartfactory.ca),  Jan Keller Pedersen <jkp@cusix.dk>(www.smartfactory.ca), Tab Content script v2.2- © Dynamic Drive DHTML code library (www.dynamicdrive.com) ";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
if (defined("ICMS_VERSION_NAME")) {
    $modversion['image'] = "images/mytabs_ilogo.gif";
} else {
    $modversion['image'] = "images/mytabs_slogo.gif";     // for backwards compatibility
}

$modversion['iconsmall'] = "images/mytabs_iconsmall.gif";
$modversion['iconbig'] = "images/mytabs_iconbig.gif";

$modversion['dirname'] = "mytabs";

//Database
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][0] = "mytabs_page";
$modversion['tables'][1] = "mytabs_tab";
$modversion['tables'][2] = "mytabs_pageblock";

$modversion['hasMain'] = 0;

//Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

$modversion['templates'][] = array('file' => "mytabs_admin_blocks.html",
                                   'description' => "");
$modversion['templates'][] = array('file' => "mytabs_admin_page.html",
                                   'description' => "");
$modversion['templates'][] = array('file' => "mytabs_block.html",
                                   'description' => "");
$modversion['templates'][] = array('file' => "mytabs_index.html",
                                   'description' => "");
$modversion['templates'][] = array('file' => "mytabs_about.html",
                                   'description' => "");
                                   
//Blocks
$modversion['blocks'][1]['file'] = "mytabs_block.php";
$modversion['blocks'][1]['name'] = _MI_MYATBS_BNAME1;
$modversion['blocks'][1]['description'] = "Shows dynamic content tab";
$modversion['blocks'][1]['show_func'] = "b_mytabs_block_show";
$modversion['blocks'][1]['edit_func'] = "b_mytabs_block_edit";
$modversion['blocks'][1]['options'] = "|0|400|mytabsdefault|true|2000||1|0";
$modversion['blocks'][1]['template'] = 'mytabs_block_blocks.html';
$modversion['blocks'][4]['show_all_module'] = true;
$modversion['blocks'][1]['can_clone'] = true ;

// About stuff
$modversion['status_version'] = "Final";
$modversion['developer_website_url'] = "http://www.xuups.com";
$modversion['developer_website_name'] = "Xuups";
$modversion['developer_email'] = "lusopoemas@gmail.com";
$modversion['status'] = "Final";
$modversion['date'] = "06/07/2008";

$modversion['people']['developers'][] = "Trabis, Mowaffak, Gopala, Beduíno";

$modversion['people']['testers'][] = "xoopsbr.org Team, X-Trad.org Team, impresscms.org Team, xoops.org Team, YOU!";

$modversion['people']['translaters'][] = "flymirco(italian), voltan(persian), Gibaphp(portuguesebr), kris_fr(french), wuddel(german), almjd(arabic)";

$modversion['people']['documenters'][] = "mamba (<a href='http://www.xoops.org/uploads/tutorials/MyTabsTutorial.pdf' target='_blank'>Quick Tutorial</a>)";

//$modversion['people']['other'][] = "";

$modversion['demo_site_url'] = "http://www.xuups.com";
$modversion['demo_site_name'] = "Xuups.com";
$modversion['support_site_url'] = "http://www.xuups.com/modules/newbb";
$modversion['support_site_name'] = "Xuups Support Forums";
//$modversion['submit_bug'] = "";
//$modversion['submit_feature'] = "";

$modversion['author_word'] = "I want to dedicated this module to Gopala, the owner of this idea and first lines of code.";
$modversion['warning'] = "";

// On Update
if( ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname'] ) {
	include dirname( __FILE__ ) . "/include/onupdate.inc.php" ;
}
?>
