<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

require("header.php");

if (isset($_REQUEST['op'])){
    $op = $_REQUEST['op'];
} else {
    redirect_header('index.php', 1, _NOPERM);
    exit;
}

$pageblock_handler = xoops_getmodulehandler('pageblock');

switch ($op) {
    case "save":

        if (!isset($_POST['pageblockid'])){
            $block = $pageblock_handler->create();
        } elseif (! $block = $pageblock_handler->get($_POST['pageblockid'])){
            $block = $pageblock_handler->create();
        }
        
        $block->setVar('pageid', $_POST['pageid']);
        $block->setVar('blockid', $_POST['blockid']);
        $block->setVar('title', $_POST['title']);
        if ( isset($_POST['options']) && (count($_POST['options']) > 0) ) {
            $options = $_POST['options'];
            for ( $i = 0; $i < count($options); $i++ ) {
                if (is_array($options[$i])) {
                    $options[$i] = implode(',', $options[$i]);
                }
            }
            $block->setVar('options', implode('|', $options));
        }
        $block->setVar('tabid', $_POST['tabid']);
        $block->setVar('priority', $_POST['priority']);
        $block->setVar('showalways', $_POST['alwayson']);
        $block->setVar('placement', $_POST['placement']);
        $block->setVar('fromdate', strtotime($_POST['fromdate']['date'])+$_POST['fromdate']['time']);
        $block->setVar('todate', strtotime($_POST['todate']['date'])+$_POST['todate']['time']);
        $block->setVar('pbcachetime', $_POST['pbcachetime']);
        $block->setVar('cachebyurl', $_POST['cachebyurl']);
        $block->setVar('note', $_POST['note']);
        $block->setVar('groups', $_POST['groups']);

        if ($pageblock_handler->insert($block)) {
            redirect_header('index.php?pageid='.$block->getVar('pageid'), 1, _AM_MYTABS_SUCCESS);
            exit;
        }
        break;

    case "new":
    case "edit":

        xoops_cp_header();
        mytabs_adminmenu(0);

        if ($op == "new") {
            $block = $pageblock_handler->create();
            $block->setVar('pageid', $_REQUEST['pageid']);
            $block->setVar('tabid', $_POST['tabid']);
            $block->setVar('blockid', $_POST['blockid']);

            $block->setBlock($_POST['blockid']);
        }
        else {
            $block = $pageblock_handler->get($_REQUEST['pageblockid']);
            $block->setBlock();
        }
        $pageid = $block->getVar('pageid');

        echo "<a href=\"index.php\">"._AM_MYTABS_HOME."</a>&nbsp;";

        if ($pageid > 0) {
            $page_handler =& xoops_getmodulehandler('page');
            $page = $page_handler->get($pageid);
            echo "&raquo;&nbsp;";
            echo "<a href=\"index.php?pageid=".$pageid."\">".$page->getVar("pagetitle")."</a>";
        }

        $form = $block->getForm();

        echo $form->render();

        xoops_cp_footer();
        break;

    case "delete":
        $obj =& $pageblock_handler->get($_REQUEST['pageblockid']);
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
            xoops_confirm(array('ok' => 1, 'pageblockid' => $_REQUEST['pageblockid'], 'op' => 'delete'), 'block.php', sprintf(_AM_MYTABS_RUSUREDEL, $obj->getVar('title')));
        }
        break;
}
?>
