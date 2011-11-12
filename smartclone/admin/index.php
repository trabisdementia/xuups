<?php

/**
 * $Id: index.php,v 1.3 2006/11/08 15:02:47 marcan Exp $
 * Module: SmartClone
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

include_once("admin_header.php");
include_once(SMARTCLONE_ROOT_PATH . "class/smartclone.php");
include_once(SMARTCLONE_ROOT_PATH . 'class/plugins.php');

$op = '';
if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

switch ($op) {
    case "doclone":
        $module = isset($_POST['module']) ? $_POST['module'] : false;
        $newname = isset($_POST['newname']) ? $_POST['newname'] : false;
        if ($module && $newname) {
            $smartClone = new SmartClone($module, $newname);
            if (!$smartClone->execute()) {
                redirect_header(SMARTCLONE_ADMIN_URL, 3, $smartClone->getErrors());
                exit;
            } else {

                if (isset($_POST['install']) && $_POST['install']) {
                    $url = XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin&op=install&module=' . $smartClone->_newModuleName;
                } else {
                    $url = SMARTCLONE_ADMIN_URL;
                }
                redirect_header($url, 3, _AM_SCLONE_SUCCESS);
                exit;
            }
        } else {
            redirect_header(SMARTCLONE_ADMIN_URL, 3, _AM_SCLONE_INVALID_SELECTION);
            exit;
        }
        break;

    default:
        smart_xoops_cp_header();

        smart_addAdminAjaxSupport();
        smart_addStyle('smartobject');

        smart_adminMenu(0, _AM_SOBJECT_INDEX);
        smart_collapsableBar('cloneform', _AM_SCLONE_CLONEFORM_TILE, _AM_SCLONE_CLONEFORM_DSC);

        include_once(SMARTCLONE_ADMIN_ROOT_PATH . "cloneform.inc.php");

        smart_close_collapsable('cloneform');
        smart_modFooter();
        xoops_cp_footer();
        break;
}
?>