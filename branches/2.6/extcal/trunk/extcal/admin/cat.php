<?php

include '../../../include/cp_header.php';
include '../../../class/xoopsformloader.php';
include 'admin_header.php';

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = 'default';
}

switch ($op) {

    case 'enreg':

        // Modify cat
        if (isset($_POST['cat_id'])) {
            $catHandler = xoops_getmodulehandler('cat', 'extcal');
            $varArr = array(
                'cat_name' => $_POST['cat_name'], 'cat_desc' => $_POST['cat_desc'], 'cat_color' => substr($_POST['cat_color'], 1)
            );
            $catHandler->modifyCat($_POST['cat_id'], $varArr);
            redirect_header("cat.php", 3, _AM_EXTCAL_CAT_EDITED, false);
            // Create new cat
        } else {
            $catHandler = xoops_getmodulehandler('cat', 'extcal');
            $varArr = array(
                'cat_name' => $_POST['cat_name'], 'cat_desc' => $_POST['cat_desc'], 'cat_color' => substr($_POST['cat_color'], 1)
            );
            $catHandler->createCat($varArr);
            redirect_header("cat.php", 3, _AM_EXTCAL_CAT_CREATED, false);
        }

        break;

    case 'modify':

        if (isset($_POST['form_modify'])) {
            xoops_cp_header();
            // @author      Gregory Mage (Aka Mage)
            //***************************************************************************************
            include_once XOOPS_ROOT_PATH . "/modules/extcal/class/admin.php";
            $categoryAdmin = new ModuleAdmin();
            echo $categoryAdmin->addNavigation('cat.php');
            //***************************************************************************************
            $catHandler = xoops_getmodulehandler('cat', 'extcal');
            $cat = $catHandler->getCat($_POST['cat_id'], true);

            echo'<fieldset><legend style="font-weight:bold; color:#990000;">'
                . _AM_EXTCAL_EDIT_CATEGORY . '</legend>';

            $form = new XoopsThemeForm(_AM_EXTCAL_ADD_CATEGORY, 'add_cat', 'cat.php?op=enreg', 'post', true);
            $form->addElement(new XoopsFormText(_AM_EXTCAL_NAME, 'cat_name', 30, 255, $cat->getVar('cat_name')), true);
            $form->addElement(new XoopsFormDhtmlTextArea(_AM_EXTCAL_DESCRIPTION, 'cat_desc', $cat->getVar('cat_desc')), false);
            $form->addElement(
                new XoopsFormColorPicker(_AM_EXTCAL_COLOR, 'cat_color',
                    '#' . $cat->getVar('cat_color'))
            );
            $form->addElement(new XoopsFormHidden('cat_id', $cat->getVar('cat_id')), false);
            $form->addElement(new XoopsFormButton("", "form_submit", _SEND, "submit"), false);
            $form->display();

            echo '</fieldset>';

            xoops_cp_footer();
        } else {
            if (isset($_POST['form_delete'])) {
                if (!isset($_POST['confirm'])) {
                    xoops_cp_header();
        // @author      Gregory Mage (Aka Mage)
        //***************************************************************************************
        include_once XOOPS_ROOT_PATH . "/modules/extcal/class/admin.php";
        $categoryAdmin = new ModuleAdmin();
        echo $categoryAdmin->addNavigation('cat.php');
        //***************************************************************************************                    

                    $hiddens = array('cat_id' => $_POST['cat_id'], 'form_delete' => '', 'confirm' => 1);
                    xoops_confirm($hiddens, 'cat.php?op=modify', _AM_EXTCAL_CONFIRM_DELETE_CAT, _DELETE, 'cat.php');

                    xoops_cp_footer();
                } else {
                    if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
                        $catHandler = xoops_getmodulehandler('cat', 'extcal');
                        $catHandler->deleteCat($_POST['cat_id']);
                        redirect_header("cat.php", 3, _AM_EXTCAL_CAT_DELETED, false);
                    }
                }
            }
        }

        break;

    case 'default':
    default:

        xoops_cp_header();
        // @author      Gregory Mage (Aka Mage)
        //***************************************************************************************
        $categoryAdmin = new ModuleAdmin();
        echo $categoryAdmin->addNavigation('cat.php');
        //***************************************************************************************

        $catHandler = xoops_getmodulehandler('cat', 'extcal');
        $cats = $catHandler->getAllCat($xoopsUser, 'all');


        echo'<fieldset><legend style="font-weight:bold; color:#990000;">'
            . _AM_EXTCAL_EDIT_OR_DELETE_CATEGORY . '</legend>';
        $form = new XoopsThemeForm(_AM_EXTCAL_EDIT_OR_DELETE_CATEGORY, 'mod_cat', 'cat.php?op=modify', 'post', true);
        $catSelect = new XoopsFormSelect(_AM_EXTCAL_CATEGORY, 'cat_id');

        foreach (
            $cats as $cat
        ) {
            $catSelect->addOption($cat->getVar('cat_id'), $cat->getVar('cat_name'));
        }

        $form->addElement($catSelect, true);
        $button = new XoopsFormElementTray('');
        $button->addElement(new XoopsFormButton("", "form_modify", _EDIT, "submit"), false);
        $button->addElement(new XoopsFormButton("", "form_delete", _DELETE, "submit"), false);
        $form->addElement($button, false);
        $form->display();


        echo '</fieldset><br />';
        echo'<fieldset><legend style="font-weight:bold; color:#990000;">'
            . _AM_EXTCAL_ADD_CATEGORY . '</legend>';

        $form = new XoopsThemeForm(_AM_EXTCAL_ADD_CATEGORY, 'add_cat', 'cat.php?op=enreg', 'post', true);
        $form->addElement(new XoopsFormText(_AM_EXTCAL_NAME, 'cat_name', 30, 255), true);
        $form->addElement(new XoopsFormDhtmlTextArea(_AM_EXTCAL_DESCRIPTION, 'cat_desc', ''), false);
        $form->addElement(new XoopsFormColorPicker(_AM_EXTCAL_COLOR, 'cat_color'));
        $form->addElement(new XoopsFormButton("", "form_submit", _SEND, "submit"), false);
        $form->display();

        echo '</fieldset><br />';

        include 'admin_footer.php';

        break;
}

?>