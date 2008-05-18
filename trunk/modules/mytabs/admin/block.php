<?php
require("header.php");

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : "";
$pageblock_handler = xoops_getmodulehandler('pageblock');

switch ($op) {
    case "save":
        $block = $pageblock_handler->get($_POST['pageblockid']);

        if ($block->isNew() ) {
            $block->setVar('pageid', $_POST['pageid']);
            $block->setVar('blockid', $_POST['blockid']);
        }

        $block->setVar('title', $_POST['title']);
        $block->setVar('options', implode('|', $_REQUEST['options']));

        $block->setVar('tabid', $_POST['tabid']);
        $block->setVar('priority', $_POST['priority']);
        $block->setVar('showalways', $_POST['alwayson']);
        $block->setVar('fromdate', strtotime($_POST['fromdate']['date'])+$_POST['fromdate']['time']);
        $block->setVar('todate', strtotime($_POST['todate']['date'])+$_POST['todate']['time']);

        $block->setVar('pbcachetime', $_POST['pbcachetime']);
        $block->setVar('cachebyurl', $_POST['cachebyurl']);
        $block->setVar('note', $_POST['note']);
        $block->setVar('groups', $_POST['groups']);

        if ($pageblock_handler->insert($block)) {
            header("Location: ".XOOPS_URL."/modules/mytabs/admin/index.php?pageid=".$block->getVar('pageid'));
            exit;
        }
        break;

    case "new":
    case "edit":

        xoops_cp_header();

        if ($op == "new") {
            $block = $pageblock_handler->create();
            $block->setVar('pageid', $_REQUEST['pageid']);
            $block->setVar('tabid', $_REQUEST['tabid']);
            $block->setBlock($_REQUEST['blockid']);
        }
        else {
            $block = $pageblock_handler->get($_REQUEST['blockid']);
            $block->setBlock();
        }
        $pageid = $block->getVar('pageid');

        echo "<a href=\"index.php\">"._AM_MYTABS_HOME."</a>&nbsp;";
        /*
        if ($pageid > 0) {
            $module_handler =& xoops_gethandler('module');
            $module = $module_handler->get($pageid);
//            echo "<a href=\"index.php?location=0&amp;pageid=".$pageid."\">".$module->getVar("name")."</a>";

            foreach($bread as $crumb)
            {
                echo "&raquo;&nbsp;";
                echo "<a href=\"index.php?pageid=".$pageid."&location=".$crumb."\">".$resolver->getLocation($crumb)."</a>&nbsp;";
            }
        }  */

        $form = $block->getForm();

        echo $form->render();

        xoops_cp_footer();
        break;

    case "delete":
        $obj =& $pageblock_handler->get($_REQUEST['id']);
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if ($pageblock_handler->delete($obj)) {
                redirect_header('index.php?pageid='.$obj->getVar('pageid'), 3, sprintf(_AM_MYTABS_DELETEDSUCCESS, $obj->getVar('title')));
            }
            else {
                xoops_cp_header();
                echo implode('<br />', $obj->getErrors());
            }
        }
        else {

            xoops_cp_header();
            xoops_confirm(array('ok' => 1, 'id' => $_REQUEST['id'], 'op' => 'delete'), 'block.php', sprintf(_AM_MYTABS_RUSUREDEL, $obj->getVar('title')));
        }
        break;
}
?>
