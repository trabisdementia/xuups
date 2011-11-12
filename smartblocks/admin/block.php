<?php
require("header.php");

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : "";
$pageblock_handler = xoops_getmodulehandler('pageblock');

switch ($op) {
    case "save":
        $block = $pageblock_handler->get($_POST['pageblockid']);

        if ($block->isNew() ) {
            $block->setVar('moduleid', $_POST['moduleid']);
            $block->setVar('location', $_POST['location']);
            $block->setVar('blockid', $_POST['blockid']);
        }

        $block->setVar('title', $_POST['title']);
        $block->setVar('options', implode('|', $_REQUEST['options']));

        $block->setVar('placement', $_POST['placement']);
        $block->setVar('priority', $_POST['priority']);
        $block->setVar('showalways', $_POST['alwayson']);
        $block->setVar('fromdate', strtotime($_POST['fromdate']['date'])+$_POST['fromdate']['time']);
        $block->setVar('todate', strtotime($_POST['todate']['date'])+$_POST['todate']['time']);
        $block->setVar('falldown', $_POST['falldown']);

        $block->setVar('pbcachetime', $_POST['pbcachetime']);
        $block->setVar('cachebyurl', $_POST['cachebyurl']);
        $block->setVar('note', $_POST['note']);
        $block->setVar('groups', $_POST['groups']);

        if ($pageblock_handler->insert($block)) {
            header("Location: ".XOOPS_URL."/modules/smartblocks/admin/page.php?location=".$block->getVar('location')."&moduleid=".$block->getVar('moduleid'));
            exit;
        }
        break;

    case "new":
    case "edit":

        xoops_cp_header();

        if ($op == "new") {
            $block = $pageblock_handler->create();
            $block->setVar('moduleid', $_REQUEST['moduleid']);
            $block->setVar('location', $_REQUEST['location']);
            $block->setVar('placement', $_REQUEST['placement']);
            $block->setBlock($_REQUEST['blockid']);
        }
        else {
            $block = $pageblock_handler->get($_REQUEST['blockid']);
            $block->setBlock();
        }
        $moduleid = $block->getVar('moduleid');
        $location = $block->getVar('location');

        $handler = xoops_getmodulehandler('resolver');
        $resolver = $handler->getResolverById($moduleid);

        $locations = $resolver->getLocationParentPath($location);
        $bread = array_reverse($locations);

        echo "<a href=\"index.php\">"._SMARTBLOCKS_SMARTBLOCKS."</a>&nbsp;";

        if ($moduleid > 0) {
            $module_handler =& xoops_gethandler('module');
            $module = $module_handler->get($moduleid);
            //            echo "<a href=\"page.php?location=0&amp;moduleid=".$moduleid."\">".$module->getVar("name")."</a>";

            foreach($bread as $crumb)
            {
                echo "&raquo;&nbsp;";
                echo "<a href=\"page.php?moduleid=".$moduleid."&location=".$crumb."\">".$resolver->getLocation($crumb)."</a>&nbsp;";
            }
        }

        $form = $block->getForm();

        echo $form->render();

        xoops_cp_footer();
        break;

    case "delete":
        $obj =& $pageblock_handler->get($_REQUEST['id']);
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if ($pageblock_handler->delete($obj)) {
                redirect_header('page.php?moduleid='.$obj->getVar('moduleid').'&location='.$obj->getVar('location'), 3, sprintf(_SMARTBLOCKS_DELETEDSUCCESS, $obj->getVar('title')));
            }
            else {
                xoops_cp_header();
                echo implode('<br />', $obj->getErrors());
            }
        }
        else {

            xoops_cp_header();
            xoops_confirm(array('ok' => 1, 'id' => $_REQUEST['id'], 'op' => 'delete'), 'block.php', sprintf(_SMARTBLOCKS_RUSUREDEL, $obj->getVar('title')));
        }
        break;
}
?>