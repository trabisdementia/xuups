<?php
include("../../mainfile.php");
$xoopsOption['template_main'] = 'mytabs_index.html';
include(XOOPS_ROOT_PATH."/header.php");
include_once(XOOPS_ROOT_PATH."/class/template.php");
include_once(XOOPS_ROOT_PATH."/modules/mytabs/include/functions.php");
$pageid=isset($_REQUEST['pageid'])?intval($_REQUEST['pageid']):1;
$rotate = 1;
$xoTheme->addStylesheet(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/css/tabcontent.css');
$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/jscript/tabcontent.js');
//if ($rotate == 1)
 //   $xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/jscript/rotate.js');


/*
<link rel="stylesheet" type="text/css" href="css/tabcontent.css" />

<script type="text/javascript" src="jscript/tabcontent.js">  */
/***********************************************
* Tab Content script v2.2- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
/*</script>  */

$page_handler = xoops_getmodulehandler('page');
$page = $page_handler->get($pageid);
if (!$page) exit('wrong page');
$xoopsTpl->assign('pagename', $page->getVar('pagetitle'));

$tab_handler = xoops_getmodulehandler('tab');
$criteria = new Criteria('tabpageid', $pageid);
$criteria->setSort('taborder');
$criteria->setOrder('DESC');
$tabs = $tab_handler->getObjects(new Criteria('tabpageid', $pageid));
$i=0;
$tabs_content='';
$select = 'class="selected"';
foreach ($tabs as $tab){
    $tabs_content .= '<li><a href="#" rel="tab'.$tab->getVar('tabid').'" '.$select.'>'.$tab->getVar('tabtitle').'</a></li>';
    $select = '';
}
$xoopsTpl->assign('tabs_content',$tabs_content);

foreach ($tabs as $tab){
    echo '<div id="tab'.$tab->getVar('tabid').'" class="tabcontent"> ';
    $option=$i;
    $result = smartblock_show($pageid, $tab->getVar('tabid'));
    $tpl = new XoopsTpl();
    $tpl->assign('block', $result);
    $tpl->display('db:mytabs_block.html');
    echo'</div>';
}

?>
</div>

<script type="text/javascript">
var tabc=new ddtabcontent("tabscontents")
tabc.setpersist(true)
tabc.setselectedClassTarget("link")
tabc.init(2000)
</script>



<?php

include(XOOPS_ROOT_PATH."/footer.php");

?>


