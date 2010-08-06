<?php

/**
 * $Id: xoopsclients.php,v 1.1 2005/04/19 18:20:55 fx2024 Exp $
 * Module: SmartClient
 * Author: Marius Scurtescu <mariuss@romanians.bc.ca>
 * Licence: GNU
 *
 * Import script from XoopsClients to SmartClient.
 *
 * It was tested with XoosClients version 1.1 and SmartClient version 1.0 beta
 *
 */

include_once("admin_header.php");

$importFromModuleName = 'XoopsClients';
$scriptname = 'xoopsclients.php';

$op = 'start';

if (isset($_POST['op']) && ($_POST['op'] == 'go'))
{
    $op = $_POST['op'];
}

if ($op == 'start')
{
    xoops_cp_header();
    smartclient_adminMenu(-1, _AM_SCLIENT_IMPORT);
    include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';

    smartclient_collapsableBar('bottomtable', 'bottomtableicon');
    echo "<img id='bottomtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . sprintf(_AM_SCLIENT_IMPORT_FROM, $importFromModuleName) . "</h3>";
    echo "<div id='bottomtable'>";

    include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";

    $result = $xoopsDB->query ("select count(*) from ".$xoopsDB->prefix("clients"));
    list ($totalclients) = $xoopsDB->fetchRow ($result);

    echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . sprintf(_AM_SCLIENT_IMPORT_MODULE_FOUND, $importFromModuleName, $totalclients) . "</span>";

    $form = new XoopsThemeForm (_AM_SCLIENT_IMPORT_SETTINGS, 'import_form',  XOOPS_URL. "/modules/" . $xoopsModule->getVar('dirname') . "/admin/" . $scriptname);

    // Auto-Approve
    $form->addElement(new XoopsFormLabel(_AM_SCLIENT_SMARTCLIENT_IMPORT_SETTINGS, _AM_SCLIENT_SMARTCLIENT_IMPORT_SETTINGS_VALUE));

    $form->addElement (new XoopsFormHidden('op', 'go'));
    $form->addElement (new XoopsFormButton ('', 'import', _AM_SCLIENT_IMPORT, 'submit'));
    $form->display();

    exit ();
}

if ($op == 'go')
{
    include_once("admin_header.php");

    xoops_cp_header();
    smartclient_adminMenu(-1, _AM_SCLIENT_IMPORT);

    smartclient_collapsableBar('bottomtable', 'bottomtableicon');
    echo "<img id='bottomtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . sprintf(_AM_SCLIENT_IMPORT_FROM, $importFromModuleName) . "</h3>";
    echo "<div id='bottomtable'>";
    echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . _AM_SCLIENT_IMPORT_RESULT . "</span>";

    $cnt_imported_client = 0;

    $client_handler  =& smartclient_gethandler('client');



    $resultClients = $xoopsDB->query ("select * from ".$xoopsDB->prefix("clients")." ");
    while ($arrClients = $xoopsDB->fetchArray ($resultClients))
    {
        extract ($arrClients, EXTR_PREFIX_ALL, 'xclient');
         
        // insert client into SmartClient
        $clientObj =& $client_handler->create();
         
        if ($xclient_status == 0) {
            $xclient_status = _SCLIENT_STATUS_INACTIVE;
        } elseif ($xclient_status == 1) {
            $xclient_status = _SCLIENT_STATUS_ACTIVE;
        }
         
        $clientObj->setVar('weight', $xclient_weight);
        $clientObj->setVar('hits', $xclient_hits);
        $clientObj->setVar('url', $xclient_url);
        $clientObj->setVar('image_url', $xclient_image);
        $clientObj->setVar('title', $xclient_title);
        $clientObj->setVar('summary', $xclient_description);
        $clientObj->setVar('status', $xclient_status);
         
        if (!$clientObj->store(false))
        {
            echo sprintf("  " . _AM_SCLIENT_IMPORT_CLIENT_ERROR, $xclient_title) . "<br/>";
            continue;
        } else {
            echo "&nbsp;&nbsp;"  . sprintf(_AM_SCLIENT_IMPORTED_CLIENT, $clientObj->title()) . "<br />";
            $cnt_imported_client++;
        }

        echo "<br/>";
    }

    echo "Done.<br/>";
    echo sprintf(_AM_SCLIENT_IMPORTED_CLIENTS, $cnt_imported_client) . "<br/>";

    exit ();
}

?>

