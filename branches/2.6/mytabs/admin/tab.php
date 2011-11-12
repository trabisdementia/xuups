<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Mytabs
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: header.php 0 2009-11-14 18:47:04Z trabis $
 */

require dirname(__FILE__) . '/header.php';

if (isset($_REQUEST['op'])){
    $op = $_REQUEST['op'];
} else {
    redirect_header('index.php', 1, _NOPERM);
    exit;
}

$tab_handler = xoops_getmodulehandler('tab');

switch ($op) {
    case "save":
        if (!isset($_POST['tabid'])) {
            $tab = $tab_handler->create();
        } else if (!$tab = $tab_handler->get($_POST['tabid'])) {
            $tab = $tab_handler->create();
        }

        $tab->setVar('tabpageid', $_POST['tabpageid']);
        $tab->setVar('tabtitle', $_POST['tabtitle']);
        $tab->setVar('tablink', $_POST['tablink']);
        $tab->setVar('tabrev', $_POST['tabrev']);
        $tab->setVar('tabpriority', $_POST['tabpriority']);
        $tab->setVar('tabshowalways', $_POST['tabalwayson']);
        $tab->setVar('tabfromdate', strtotime($_POST['tabfromdate']['date']) + $_POST['tabfromdate']['time']);
        $tab->setVar('tabtodate', strtotime($_POST['tabtodate']['date']) + $_POST['tabtodate']['time']);
        $tab->setVar('tabnote', $_POST['tabnote']);
        $tab->setVar('tabgroups', $_POST['tabgroups']);

        if ($tab_handler->insert($tab)) {
            redirect_header('index.php?pageid=' . $tab->getVar('tabpageid'), 1, _AM_MYTABS_SUCCESS);
            exit;
        }
        break;

    case "new":
    case "edit":
        xoops_cp_header();
        mytabs_adminmenu(0);

        if ($op == "new") {
            $tab = $tab_handler->create();
            $tab->setVar('tabpageid', $_REQUEST['pageid']);
            $tab->setVar('tabtitle', $_POST['tabtitle']);
            $tab->setVar('tabfromdate', time());
            $tab->setVar('tabtodate', time());
        } else {
            $tab = $tab_handler->get($_REQUEST['tabid']);
        }
        $pageid = $tab->getVar('tabpageid');

        echo "<a href=\"index.php\">"._AM_MYTABS_HOME."</a>&nbsp;";

        if ($pageid > 0) {
            $page_handler = xoops_getmodulehandler('page');
            $page = $page_handler->get($pageid);
            echo "&raquo;&nbsp;";
            echo "<a href=\"index.php?pageid=" . $pageid . "\">" . $page->getVar("pagetitle") . "</a>";
        }

        $form = $tab->getForm();
        echo $form->render();

        xoops_cp_footer();
        break;

    case "delete":
        $obj = $tab_handler->get($_REQUEST['tabid']);
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if ($tab_handler->delete($obj)) {
                $pageblock_handler = xoops_getmodulehandler('pageblock');
                $blocks = $pageblock_handler->getObjects(new Criteria('tabid', $_REQUEST['tabid']));
                foreach ($blocks as $block){
                    $pageblock_handler->delete($block);
                }
                redirect_header('index.php?pageid='.$obj->getVar('tabpageid'), 3, sprintf(_AM_MYTABS_DELETEDSUCCESS, $obj->getVar('tabtitle')));
            } else {
                xoops_cp_header();
                echo implode('<br />', $obj->getErrors());
                xoops_cp_footer();
            }
        } else {
            xoops_cp_header();
            xoops_confirm(array('ok' => 1, 'tabid' => $_REQUEST['tabid'], 'op' => 'delete'), 'tab.php', sprintf(_AM_MYTABS_RUSUREDEL, $obj->getVar('tabtitle')));
            xoops_cp_footer();
        }
        break;
}
?>