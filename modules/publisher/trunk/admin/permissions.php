<?php

/**
* $Id: permissions.php 3437 2008-07-05 10:51:26Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once("admin_header.php");
include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

if (!$publisher_isAdmin) {
    redirect_header("javascript:history.go(-1)", 1, _NOPERM);
    exit;
}

$op = '';

switch ($op) {
    case "default":
    default:
        global $xoopsDB, $xoopsModule;

		publisher_xoops_cp_header();
        publisher_adminMenu(3, _AM_PUB_PERMISSIONS);

        // View Categories permissions
        $item_list_view = array();
        $block_view = array();
        publisher_collapsableBar('permissionstable', 'permissionsicon', _AM_PUB_PERMISSIONSVIEWMAN, _AM_PUB_VIEW_CATS);

        $result_view = $xoopsDB->query("SELECT categoryid, name FROM " . $xoopsDB->prefix("publisher_categories") . " ");
        if ($xoopsDB->getRowsNum($result_view)) {
            $form_submit = new XoopsGroupPermForm("", $xoopsModule->getVar('mid'), "item_submit", "", 'admin/permissions.php');
            while ($myrow_view = $xoopsDB->fetcharray($result_view)) {
                $form_submit->addItem($myrow_view['categoryid'], $myts->displayTarea($myrow_view['name']));
            }
            echo $form_submit->render();
        } else {
			echo "<img id='toptableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_PUB_PERMISSIONSVIEWMAN . "</h3><div id='toptable'><span style=\"color: #567; margin: 3px 0 0 0; font-size: small; display: block; \">" . _AM_PUB_NOPERMSSET . "</span>";

        }
        publisher_close_collapsable('permissionstable', 'permissionsicon');
        echo "<br />\n";

         
        // Submit Categories permissions
        publisher_collapsableBar('permissionstable_submit', 'permissions_tableicon', _AM_PUB_PERMISSIONS_CAT_SUBMIT, _AM_PUB_PERMISSIONS_CAT_SUBMIT_DSC);

        $result_view = $xoopsDB->query("SELECT categoryid, name FROM " . $xoopsDB->prefix("publisher_categories") . " ");
        if ($xoopsDB->getRowsNum($result_view)) {
            $form_submit = new XoopsGroupPermForm("", $xoopsModule->getVar('mid'), "item_submit", "", 'admin/permissions.php');
            while ($myrow_view = $xoopsDB->fetcharray($result_view)) {
                $form_submit->addItem($myrow_view['categoryid'], $myts->displayTarea($myrow_view['name']));
            }
            echo $form_submit->render();
        } else {
			echo "<img id='toptableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_PUB_PERMISSIONSVIEWMAN . "</h3><div id='toptable'><span style=\"color: #567; margin: 3px 0 0 0; font-size: small; display: block; \">" . _AM_PUB_NOPERMSSET . "</span>";
        }
        publisher_close_collapsable('permissionstable_form', 'permissions_tableicon');
        echo "<br />\n";

        // Form permissions
        publisher_collapsableBar('permissionstable_form', 'permissions_tableicon', _AM_PUB_PERMISSIONS_FORM, _AM_PUB_PERMISSIONS_FORM_DSC);

        $form_options = array(
        '1' => _AM_PUB_CATEGORY,
        '2' => _AM_PUB_SUMMARY,
        '3' => _AM_PUB_DISPLAY_SUMMARY,
        '4' => _AM_PUB_BODY,
        '5' => _AM_PUB_AVAILABLE_PAGE_WRAP,
        '6' => _AM_PUB_ITEM_TAGS,
        '7' => _AM_PUB_IMAGE_ITEM,
        '8' => _AM_PUB_IMAGE_UPLOAD,
        '9' => _AM_PUB_ITEM_UPLOAD_FILE,
        '10' => _AM_PUB_UID,
        '11' => _AM_PUB_DATESUB,
        '12' => _AM_PUB_STATUS,
        '13' => _AM_PUB_ITEM_SHORT_URL,
        '14' => _AM_PUB_ITEM_META_KEYWORDS,
        '15' => _AM_PUB_ITEM_META_DESCRIPTION,
        '16' => _AM_PUB_WEIGHT,
        '17'=> _AM_PUB_ALLOWCOMMENTS,
        '18' => _AM_PUB_PERMISSIONS_ITEM,
        '19' => _AM_PUB_PARTIAL_VIEW,
        '20' => _AM_PUB_DOHTML,
        '21' => _AM_PUB_DOSMILEY,
        '22' => _AM_PUB_DOXCODE,
        '23' => _AM_PUB_DOIMAGE,
        '24' => _AM_PUB_DOLINEBREAK);

        $form_submit = new XoopsGroupPermForm("", $xoopsModule->getVar('mid'), "form_view", "", 'admin/permissions.php');
        foreach ($form_options as $key => $value) {
            $form_submit->addItem($key, $value);
        }
        echo $form_submit->render();
        
        publisher_close_collapsable('permissionstable_form', 'permissions_tableicon');

}
xoops_cp_footer();
?>
