<?php
require("header.php");

$pageblock_handler =& xoops_getmodulehandler('pageblock');
$tab_handler =& xoops_getmodulehandler('tab');
$page_handler =& xoops_getmodulehandler('page');

$module_handler =& xoops_gethandler('module');

if ( isset($_REQUEST['pageid'])){
    $pageid = intval($_REQUEST['pageid']);
} else {
    $criteria = new Criteria(null);
    $criteria->setSort('pagetitle');
    $criteria->setOrder('DESC');
    $criteria->setLimit(1);
    $page =& $page_handler->getObjects($criteria);
    $pageid = is_object($page[0])?$page[0]->getVar('pageid'):0;
}



if(sizeof($_POST)>0)
{
    switch($_POST['doaction']) {
        case 'setpriorities':
            foreach($_POST['pri'] as $id=>$priority)
            {
                $block=& $pageblock_handler->get($id);
                $block->setVar('priority', $priority);
                $pageblock_handler->insert($block);
            }
            break;
        case 'delete':
            foreach($_POST['markedblocks'] as $id)
            {
                $block=& $pageblock_handler->get($id);
                $pageblock_handler->delete($block);
            }
            break;
    }
}

xoops_cp_header();


//$resolver = $handler->getResolverById($_REQUEST['tabid']);
//$locations=array();
//$locations = $resolver->getLocationParentPath($_REQUEST['location']);
//$bread=array_reverse($locations);

//foreach ($bread as $crumb) {
//    $crumbs[] = array('location' => $crumb, 'locationname' => $resolver->getLocation($crumb));
//}
$blocks = $pageblock_handler->getBlocks($pageid, false);
$allblocks = $pageblock_handler->getAllBlocks();



//if ($_REQUEST['moduleid'] > 0) {
    //$module = $module_handler->get($_REQUEST['moduleid']);
   // $tab = $tab_handler->get($_REQUEST['moduleid']);
//}
//else {
    //$module = $xoopsModule;
   // $tab = $tab_handler->get(1);
//}

$has_blocks = false;
$smartOption['template_main'] = "mytabs_admin_page.html";
foreach (array_keys($blocks) as $tabid) {
    foreach ($blocks[$tabid] as $block) {
        $blocks_array[$tabid][] = $block->toArray();
        $tab = $tab_handler->get($tabid);
        $tabs_array[$tabid] = $tab->getVar('tabtitle');
        $has_blocks = true;
    }
}

$grouplist = xoops_gethandler('group')->getObjects(null, true);
foreach (array_keys($grouplist) as $i) {
    $groups[$i] = $grouplist[$i]->getVar('name');
}
$has_pages = false;
$criteria = new Criteria(null);
$criteria->setSort('pagetitle');
$criteria->setOrder('ASC');
$pagelist = $page_handler->getObjects($criteria, true);
foreach (array_keys($pagelist) as $i) {
    $pages[$i] = $pagelist[$i]->getVar('pagetitle');
    $has_pages = true;
}


$has_placements = false;
$placement = '<select name="tabid">';
$tabs = $tab_handler->getObjects(new Criteria('tabpageid', $pageid), false);
foreach ($tabs as $tab){
    $placement .='<option value="'.$tab->getVar('tabid').'">'.$tab->getVar('tabtitle').'</option>';
    $has_placements = true;
}
$placement .='</select>&nbsp;';

$page = $page_handler->get($pageid);
if ($page){
    $xoopsTpl->assign('pagename', $page->getVar('pagetitle'));
}

if ($has_blocks){
    $xoopsTpl->assign('blocks', $blocks_array);
    $xoopsTpl->assign('tabs', $tabs_array);
}

if ($has_placements){
    $xoopsTpl->assign('placement', $placement);
}

if ($has_pages){
    $xoopsTpl->assign('pagelist', $pages);
}
//$xoopsTpl->assign('bread', $crumbs);
$xoopsTpl->assign('pageid', $pageid);
$xoopsTpl->assign('blocklist', $allblocks);
$xoopsTpl->assign('groups', $groups);

$xoopsTpl->display("db:".$smartOption['template_main']);

xoops_cp_footer();
?>
