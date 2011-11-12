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

$page_handler = xoops_getmodulehandler('page');

switch ($op) {
    case "save":
        if (!isset($_POST['pageid'])) {
            $page = $page_handler->create();
        } else if (!$page = $page_handler->get($_POST['pageid'])) {
            $page = $page_handler->create();
        }

        $page->setVar('pagetitle', $_POST['pagetitle']);

        if ($page_handler->insert($page)) {
            redirect_header('index.php?pageid='.$page->getVar('pageid'), 1, _AM_MYTABS_SUCCESS);
            exit;
        }
        break;

    case "new":
    case "edit":
        xoops_cp_header();
        mytabs_adminmenu(0);

        if ($op == "new") {
            $page = $page_handler->create();
            $page->setVar('pagetitle', $_REQUEST['pagetitle']);
        } else {
            $page = $page_handler->get($_REQUEST['pageid']);
        }
        $pageid = $page->getVar('pageid');

        echo "<a href=\"index.php\">"._AM_MYTABS_HOME."</a>&nbsp;";

        $form = $page->getForm();
        echo $form->render();

        xoops_cp_footer();
        break;

    case "delete":
        $obj = $page_handler->get($_REQUEST['pageid']);
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if ($page_handler->delete($obj)) {
                $tab_handler = xoops_getmodulehandler('tab');
                $tabs = $tab_handler->getObjects(new Criteria('tabpageid', $_REQUEST['pageid']));
                foreach ($tabs as $tab) {
                    $tab_handler->delete($tab);
                }
                $pageblock_handler = xoops_getmodulehandler('pageblock');
                $blocks = $pageblock_handler->getObjects(new Criteria('pageid', $_REQUEST['pageid']));
                foreach ($blocks as $block) {
                    $pageblock_handler->delete($block);
                }
                redirect_header('index.php', 3, sprintf(_AM_MYTABS_DELETEDSUCCESS, $obj->getVar('pagetitle')));
            } else {
                xoops_cp_header();
                echo implode('<br />', $obj->getErrors());
                xoops_cp_footer();
            }
        } else {
            xoops_cp_header();
            xoops_confirm(array('ok' => 1, 'pageid' => $_REQUEST['pageid'], 'op' => 'delete'), 'page.php', sprintf(_AM_MYTABS_RUSUREDEL, $obj->getVar('pagetitle')));
            xoops_cp_footer();
        }
        break;
}
?>