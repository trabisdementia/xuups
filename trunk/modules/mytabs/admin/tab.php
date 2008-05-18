<?php
require("header.php");

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : "";
$tab_handler = xoops_getmodulehandler('tab');

switch ($op) {
    case "save":
        $tab = $tab_handler->get($_POST['tabid']);

        if (!$tab) {
            $tab = $tab_handler->create();
        } else {
            $tab->setVar('pageid', $_POST['pageid']);
        }
        
        $tab->setVar('tabpageid', $_POST['tabpageid']);
        $tab->setVar('tabtitle', $_POST['tabtitle']);
        $tab->setVar('taboptions', implode('|', $_REQUEST['taboptions']));

        //$tab->setVar('tabid', $_POST['tabid']);
        $tab->setVar('taborder', $_POST['taborder']);
        //$tab->setVar('showalways', $_POST['alwayson']);
        //$tab->setVar('fromdate', strtotime($_POST['fromdate']['date'])+$_POST['fromdate']['time']);
        //$tab->setVar('todate', strtotime($_POST['todate']['date'])+$_POST['todate']['time']);

        //$tab->setVar('pbcachetime', $_POST['pbcachetime']);
        //$tab->setVar('cachebyurl', $_POST['cachebyurl']);
        //$tab->setVar('note', $_POST['note']);
        $tab->setVar('tabgroups', $_POST['tabgroups']);

        if ($tab_handler->insert($tab)) {
            header("Location: ".XOOPS_URL."/modules/mytabs/admin/index.php?pageid=".$tab->getVar('tabpageid'));
            exit;
        }
        break;

    case "new":
    case "edit":

        xoops_cp_header();

        if ($op == "new") {
            $tab = $tab_handler->create();
            $tab->setVar('tabpageid', $_REQUEST['pageid']);
            $tab->setVar('tabtitle', $_REQUEST['tabtitle']);
        }
        else {
            $tab = $tab_handler->get($_REQUEST['tabid']);
        }
        $pageid = $tab->getVar('tabpageid');

        echo "<a href=\"index.php\">"._AM_MYTABS_HOME."</a>&nbsp;";

        $form = $tab->getForm();

        echo $form->render();

        xoops_cp_footer();
        break;

    case "delete":
        $obj =& $tab_handler->get($_REQUEST['tabid']);
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if ($tab_handler->delete($obj)) {
                redirect_header('index.php?pageid='.$obj->getVar('tabpageid'), 3, sprintf(_AM_MYTABS_DELETEDSUCCESS, $obj->getVar('tabtitle')));
            }
            else {
                xoops_cp_header();
                echo implode('<br />', $obj->getErrors());
            }
        }
        else {

            xoops_cp_header();
            xoops_confirm(array('ok' => 1, 'tabid' => $_REQUEST['tabid'], 'op' => 'delete'), 'tab.php', sprintf(_AM_MYTABS_RUSUREDEL, $obj->getVar('tabtitle')));
        }
        break;
}
?>
