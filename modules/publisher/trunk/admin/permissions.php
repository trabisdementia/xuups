<?php

/**
* $Id: permissions.php 3437 2008-07-05 10:51:26Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once dirname(__FILE__) . '/admin_header.php';
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
            _PUB_SUMMARY                => _AM_PUB_SUMMARY,
            _PUB_DISPLAY_SUMMARY        => _AM_PUB_DISPLAY_SUMMARY,
            _PUB_AVAILABLE_PAGE_WRAP    => _AM_PUB_AVAILABLE_PAGE_WRAP,
            _PUB_ITEM_TAGS              => _AM_PUB_ITEM_TAGS,
            _PUB_IMAGE_ITEM             => _AM_PUB_IMAGE_ITEM,
            _PUB_IMAGE_UPLOAD           => _AM_PUB_IMAGE_UPLOAD,
            _PUB_ITEM_UPLOAD_FILE       => _AM_PUB_ITEM_UPLOAD_FILE,
            _PUB_UID                    => _AM_PUB_UID,
            _PUB_DATESUB                => _AM_PUB_DATESUB,
            _PUB_STATUS                 => _AM_PUB_STATUS,
            _PUB_ITEM_SHORT_URL         => _AM_PUB_ITEM_SHORT_URL,
            _PUB_ITEM_META_KEYWORDS     => _AM_PUB_ITEM_META_KEYWORDS,
            _PUB_ITEM_META_DESCRIPTION  => _AM_PUB_ITEM_META_DESCRIPTION,
            _PUB_WEIGHT                 => _AM_PUB_WEIGHT,
            _PUB_ALLOWCOMMENTS          => _AM_PUB_ALLOWCOMMENTS,
            _PUB_PERMISSIONS_ITEM       => _AM_PUB_PERMISSIONS_ITEM,
            _PUB_PARTIAL_VIEW           => _AM_PUB_PARTIAL_VIEW,
            _PUB_DOHTML                 => _AM_PUB_DOHTML,
            _PUB_DOSMILEY               => _AM_PUB_DOSMILEY,
            _PUB_DOXCODE                => _AM_PUB_DOXCODE,
            _PUB_DOIMAGE                => _AM_PUB_DOIMAGE,
            _PUB_DOLINEBREAK            => _AM_PUB_DOLINEBREAK,
            _PUB_NOTIFY                 => _AM_PUB_NOTIFY
        );

        $form_submit = new XoopsGroupPermForm("", $xoopsModule->getVar('mid'), "form_view", "", 'admin/permissions.php');
        foreach ($form_options as $key => $value) {
            $form_submit->addItem($key, $value);
        }
        echo $form_submit->render();
        
        publisher_close_collapsable('permissionstable_form', 'permissions_tableicon');

}
xoops_cp_footer();
?>
