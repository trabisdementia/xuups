<?php
require("header.php");

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : "";
$page_handler = xoops_getmodulehandler('page');

switch ($op) {
    case "save":
        $page = $page_handler->get($_POST['pageid']);

        if (!$page) {
            $page = $page_handler->create();
        } else {
            $page->setVar('pageid', $_POST['pageid']);
        }
        $page->setVar('pagetitle', $_POST['pagetitle']);
        //$page->setVar('pageoptions', implode('|', $_REQUEST['pageoptions']));

        //$page->setVar('pageid', $_POST['pageid']);
        //$page->setVar('pageorder', $_POST['pageorder']);
        //$page->setVar('showalways', $_POST['alwayson']);
        //$page->setVar('fromdate', strtotime($_POST['fromdate']['date'])+$_POST['fromdate']['time']);
        //$page->setVar('todate', strtotime($_POST['todate']['date'])+$_POST['todate']['time']);

        //$page->setVar('pbcachetime', $_POST['pbcachetime']);
        //$page->setVar('cachebyurl', $_POST['cachebyurl']);
        //$page->setVar('note', $_POST['note']);
        //$page->setVar('pagegroups', $_POST['pagegroups']);

        if ($page_handler->insert($page)) {
            header("Location: ".XOOPS_URL."/modules/mytabs/admin/index.php?pageid=".$page->getVar('pageid'));
            exit;
        }
        break;

    case "new":
    case "edit":

        xoops_cp_header();

        if ($op == "new") {
            $page = $page_handler->create();
            $page->setVar('pagetitle', $_REQUEST['pagetitle']);
        }
        else {
            $page = $page_handler->get($_REQUEST['pageid']);
        }
        $pageid = $page->getVar('pageid');

        echo "<a href=\"index.php\">"._AM_MYTABS_HOME."</a>&nbsp;";

        $form = $page->getForm();

        echo $form->render();

        xoops_cp_footer();
        break;

    case "delete":
        $obj =& $page_handler->get($_REQUEST['pageid']);
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if ($page_handler->delete($obj)) {
                redirect_header('index.php', 3, sprintf(_AM_MYTABS_DELETEDSUCCESS, $obj->getVar('pagetitle')));
            }
            else {
                xoops_cp_header();
                echo implode('<br />', $obj->getErrors());
            }
        }
        else {

            xoops_cp_header();
            xoops_confirm(array('ok' => 1, 'pageid' => $_REQUEST['pageid'], 'op' => 'delete'), 'page.php', sprintf(_AM_MYTABS_RUSUREDEL, $obj->getVar('pagetitle')));
        }
        break;
}
?>
