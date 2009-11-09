<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

include_once dirname(__FILE__) . '/admin_header.php';

$choice = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';
switch($choice){
	default:
		myinviter_index();
		break;
}

function myinviter_index() {
    global $xoopsUser, $xoopsModule, $xoopsModuleConfig;
    xoops_cp_header();
    myinviter_adminMenu(0, _MI_MYINV_ADMENU_INDEX);
    xoops_cp_footer();
}

?>
