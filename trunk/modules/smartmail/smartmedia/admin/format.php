<?php

/**
 * $Id: format.php,v 1.2 2005/05/19 01:49:46 malanciault Exp $
 * Module: SmartMedia
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */
include_once("admin_header.php");

$op = '';
if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

function editformat($showmenu = false, $id = 0)
{
    global $smartmedia_format_handler, $xoopsUser, $xoopsConfig, $xoopsModuleConfig, $xoopsModule;

    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    // If there is a parameter, and the id exists, retrieve data: we're editing a format
    if ($id != 0) {
        // Creating the format object
        $formatObj = new SmartmediaFormat($id);

        if (!$formatObj) {
            redirect_header("format.php", 1, _AM_SMEDIA_FORMAT_NOT_SELECTED);
            exit();
        }

        $breadcrumb_action1 = 	_AM_SMEDIA_FORMATS;
        $breadcrumb_action2 = 	_AM_SMEDIA_EDITING;
        $page_title = _AM_SMEDIA_FORMAT_EDITING;
        $page_info = _AM_SMEDIA_FORMAT_EDITING_INFO;
        $button_caption = _AM_SMEDIA_MODIFY;

        If ($showmenu) {
            smartmedia_adminMenu(4, $breadcrumb_action1 . " > " . $breadcrumb_action2);
        }

        echo "<br />\n";

    } else {
        // there's no parameter, so we're adding a format
        $formatObj =& $smartmedia_format_handler->create();
        $breadcrumb_action1 = _AM_SMEDIA_FORMATS;
        $breadcrumb_action2 = _AM_SMEDIA_CREATE;
        $button_caption = _AM_SMEDIA_CREATE;
        $page_title = _AM_SMEDIA_FORMAT_CREATING;
        $page_info = _AM_SMEDIA_FORMAT_CREATING_INFO;
        If ($showmenu) {
            smartmedia_adminMenu(4, $breadcrumb_action1 . " > " . $breadcrumb_action2);
        }
    }

    smartmedia_collapsableBar('bottomtable', 'bottomtableicon');
    echo "<img id='bottomtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . $page_title . "</h3>";
    echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . $page_info . "</span>";
    echo "<div id='bottomtable'>";

    // FORMAT FORM
    $sform = new XoopsThemeForm(_AM_SMEDIA_FORMAT, "op", xoops_getenv('PHP_SELF'));
    $sform->setExtra('enctype="multipart/form-data"');

    // FORMAT
    $format_text = new XoopsFormText(_AM_SMEDIA_FORMAT, 'format', 50, 255, $formatObj->format('e'));
    $format_text->setDescription(_AM_SMEDIA_FORMAT_DSC);
    $sform->addElement($format_text, true);

    // EXT
    $ext_text = new XoopsFormText(_AM_SMEDIA_FORMAT_EXT, 'ext', 5, 10, $formatObj->ext());
    $ext_text->setDescription(_AM_SMEDIA_FORMAT_EXT_DSC);
    $sform->addElement($ext_text, true);

    // TEMPLATE
    $template_text = new XoopsFormTextArea(_AM_SMEDIA_FORMAT_TEMPLATE, 'template', $formatObj->template('e'), 15, 60);
    $template_text->setDescription(_AM_SMEDIA_FORMAT_TEMPLATE_DSC);
    $sform->addElement($template_text, true);

    // FORMAT ID
    $sform->addElement(new XoopsFormHidden('formatid', $formatObj->formatid()));

    $button_tray = new XoopsFormElementTray('', '');
    $hidden = new XoopsFormHidden('op', 'addformat');
    $button_tray->addElement($hidden);

    $butt_create = new XoopsFormButton('', '', $button_caption, 'submit');
    $butt_create->setExtra('onclick="this.form.elements.op.value=\'addformat\'"');
    $button_tray->addElement($butt_create);

    $butt_cancel = new XoopsFormButton('', '', _AM_SMEDIA_CANCEL, 'button');
    $butt_cancel->setExtra('onclick="location=\'format.php\'"');
    $button_tray->addElement($butt_cancel);

    $sform->addElement($button_tray);
    $sform->display();
    unset($hidden);
    echo "</div>";
}

/* -- Available operations -- */
switch ($op) {
    case "add":

        xoops_cp_header();
        include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

        editformat(true, 0);
        break;

    case "mod":

        Global $xoopsUser, $xoopsConfig, $xoopsModuleConfig, $xoopsModule;
        $id = (isset($_GET['formatid'])) ? $_GET['formatid'] : 0;

        xoops_cp_header();
        include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

        editformat(true, $id);
        break;

    case "addformat":
        global $xoopsUser;

        $id = (isset($_POST['formatid'])) ? intval($_POST['formatid']) : 0;

        // Creating the format object
        If ($id != 0) {
            $formatObj =& new SmartmediaFormat($id);
            $action = 'edit';
        } else {
            $formatObj = $smartmedia_format_handler->create();
            $action = 'new';
        }

        // Putting the values in the format object
        $formatObj->setVar('formatid', $id);
        $formatObj->setVar('format', $_POST['format']);
        $formatObj->setVar('ext', $_POST['ext']);
        $formatObj->setVar('template', $_POST['template']);

        $redirect_msgs = $formatObj->getRedirectMsg($action);

        // Storing the format
        If ( !$formatObj->store() ) {
            redirect_header("format.php", 3, $redirect_msgs['error'] . smartmedia_formatErrors($formatObj->getErrors()));
            exit;
        }

        redirect_header("javascript:history.go(-2)", 2, $redirect_msgs['success']);

        exit();
        break;

    case "del":

        $id = (isset($_POST['formatid'])) ? intval($_POST['formatid']) : 0;
        $id = (isset($_GET['formatid'])) ? intval($_GET['formatid']) : $id;

        $formatObj = new SmartmediaFormat($id);

        $confirm = (isset($_POST['confirm'])) ? $_POST['confirm'] : 0;
        $title = (isset($_POST['format'])) ? $_POST['format'] : '';

        $redirect_msgs = $formatObj->getRedirectMsg('delete');

        if ($confirm) {
            If ( !$smartmedia_format_handler->delete($formatObj)) {
                redirect_header("format.php", 2, $redirect_msgs['error'] . smartmedia_formatErrors($formatObj->getErrors()));
                exit;
            }

            redirect_header("javascript:history.go(-2)", 2, $redirect_msgs['success']);
            exit();
        } else {
            // no confirm: show deletion condition
            $id = (isset($_GET['formatid'])) ? intval($_GET['formatid']) : 0;
            xoops_cp_header();
            xoops_confirm(array('op' => 'del', 'formatid' => $formatObj->formatid(), 'confirm' => 1, 'title' => $formatObj->format()), 'format.php', _AM_SMEDIA_FORMAT_DELETE_CONFIRM . " <br />'" . $formatObj->format() . "' <br /> <br />", _AM_SMEDIA_DELETE);
            xoops_cp_footer();
        }

        exit();
        break;

    case "default":
    default:
        xoops_cp_header();

        smartmedia_adminMenu(4, _AM_SMEDIA_FORMATS);

        include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
        include_once XOOPS_ROOT_PATH . '/class/pagenav.php';

        echo "<br />\n";

        smartmedia_collapsableBar('toptable', 'toptableicon');

        echo "<img id='toptableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SMEDIA_FORMATS_TITLE . "</h3>";
        echo "<div id='toptable'>";
        echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . _AM_SMEDIA_FORMATS_TITLE_INFO . "</span>";

        echo "<form><div style=\"margin-top: 0px; margin-bottom: 5px;\">";
        echo "<input type='button' name='button' onclick=\"location='format.php?op=mod'\" value='" . _AM_SMEDIA_FORMAT_CREATE . "'>&nbsp;&nbsp;";
        echo "</div></form>";


        // creating the format objects that are published
        $formatsObjs = $smartmedia_format_handler->getFormats();
        $totalFormats = count($formatsObjs);

        echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
        echo "<tr>";
        echo "<td class='bg3' align='left'><b>" . _AM_SMEDIA_FORMAT . "</b></td>";
        echo "<td width='100px' class='bg3' align='left'><b>" . _AM_SMEDIA_FORMAT_EXT . "</b></td>";
        echo "<td width='90' class='bg3' align='center'><b>" . _AM_SMEDIA_ACTION . "</b></td>";
        echo "</tr>";
        if ($totalFormats > 0) {
            foreach ($formatsObjs as $formatsObj) {

                $modify = "<a href='format.php?op=mod&formatid=" . $formatsObj->formatid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_SMEDIA_EDIT . "' alt='" . _AM_SMEDIA_EDIT . "' /></a>&nbsp;";
                $delete = "<a href='format.php?op=del&formatid=" . $formatsObj->formatid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_SMEDIA_DELETE . "' alt='" . _AM_SMEDIA_DELETE . "'/></a>&nbsp;";

                echo "<tr>";
                echo "<td class='even' align='left'>" . $formatsObj->format() . "</td>";
                echo "<td class='even' align='left'>" . $formatsObj->ext() . "</td>";
                echo "<td class='even' align='center'> ". $modify . $delete . "</td>";
                echo "</tr>";
            }
        } else {
            $id = 0;
            echo "<tr>";
            echo "<td class='head' align='center' colspan= '7'>" . _AM_SMEDIA_FORMATS_NONE . "</td>";
            echo "</tr>";
        }
        echo "</table>\n";
        echo "<br />\n";

        echo "</div>";

        editformat();

        break;
}
$modfooter = smartmedia_modFooter();
echo "<div align='center'>" . $modfooter . "</div>";
xoops_cp_footer();

?>