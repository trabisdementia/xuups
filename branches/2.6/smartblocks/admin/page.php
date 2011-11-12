<?php
require("header.php");

$pageblock_handler = xoops_getmodulehandler('pageblock');
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

$handler = xoops_getmodulehandler('resolver');
$resolver = $handler->getResolverById($_REQUEST['moduleid']);

$locations = $resolver->getLocationParentPath($_REQUEST['location']);
$bread=array_reverse($locations);

foreach ($bread as $crumb) {
    $crumbs[] = array('location' => $crumb, 'locationname' => $resolver->getLocation($crumb));
}
$blocks = $pageblock_handler->getBlocks(0, $locations, false);

$module_handler =& xoops_gethandler('module');
if ($_REQUEST['moduleid'] > 0) {
    $module = $module_handler->get($_REQUEST['moduleid']);
}
else {
    $module = $xoopsModule;
}

$allblocks = $handler->getBlocks();

$smartOption['template_main'] = "smartblocks_admin_page.html";
foreach (array_keys($blocks) as $placement) {
    foreach ($blocks[$placement] as $block) {
        $blocks_array[$placement][] = $block->toArray();
    }
}

$grouplist = xoops_gethandler('group')->getObjects(null, true);
foreach (array_keys($grouplist) as $i) {
    $groups[$i] = $grouplist[$i]->getVar('name');
}

$xoopsTpl->assign('blocks', $blocks_array);
$xoopsTpl->assign('bread', $crumbs);
$xoopsTpl->assign('modulename', $module->getVar('name'));
$xoopsTpl->assign('moduleid', intval($_REQUEST['moduleid']));
$xoopsTpl->assign('location', intval($_REQUEST['location']));
$xoopsTpl->assign('blocklist', $allblocks);
$xoopsTpl->assign('groups', $groups);

$xoopsTpl->display("db:".$smartOption['template_main']);

xoops_cp_footer();
?>
