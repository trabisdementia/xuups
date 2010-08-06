<?php

/**
 * $Id: import.php,v 1.1 2005/05/13 18:21:55 malanciault Exp $
 * Module: SmartMedia
 * Author: The SmartFactory <www.smartfactory.ca>
 * Credits: Mariuss
 * Licence: GNU
 */

// -- General Stuff -- //
include_once("admin_header.php");

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

global $xoopsDB;

switch ($op) {

    case "importExecute":
        $importfile = (isset($_POST['importfile'])) ? $_POST['importfile'] : 'nonselected';

        $sql_file_path = XOOPS_ROOT_PATH."/modules/smartmedia/admin/import/".$importfile.".sql";

        if (!file_exists($sql_file_path)) {
            $errs[] = "SQL file not found at <b>$sql_file_path</b>";
            $error = true;
        } else {
            xoops_cp_header();
            smartmedia_adminMenu(-1, _AM_SMEDIA_IMPORT);

            $error = false;
            $db =& Database::getInstance();
            $reservedTables = array('avatar', 'avatar_users_link', 'block_module_link', 'comments', 'config', 'configcategory', 'configoption', 'image', 'imagebody', 'imagecategory', 'imgset', 'imgset_tplset_link', 'imgsetimg', 'groups','groups_users_link','group_permission', 'online', 'bannerclient', 'banner', 'bannerfinish', 'priv_msgs', 'ranks', 'session', 'smiles', 'users', 'newblocks', 'modules', 'tplfile', 'tplset', 'tplsource');
            $msgs[] = "SQL file found at <b>$sql_file_path</b>.<br  /> Importing Q&A";
            include_once XOOPS_ROOT_PATH.'/class/database/sqlutility.php';
            $sql_query = fread(fopen($sql_file_path, 'r'), filesize($sql_file_path));
            $sql_query = trim($sql_query);
            SqlUtility::splitMySqlFile($pieces, $sql_query);
            $created_tables = array();
            foreach ($pieces as $piece) {
                // [0] contains the prefixed query
                // [4] contains unprefixed table name
                $prefixed_query = SqlUtility::prefixQuery($piece, $db->prefix());
                if (!$prefixed_query) {
                    $errs[] = "<b>$piece</b> is not a valid SQL!";
                    $error = true;
                    break;
                }
                // check if the table name is reserved
                if (!in_array($prefixed_query[4], $reservedTables)) {
                    // not reserved, so try to create one
                    if (!$db->query($prefixed_query[0])) {
                        $errs[] = $db->error();
                        $error = true;
                        break;
                    } else {
                        if (!in_array($prefixed_query[4], $created_tables)) {
                            $msgs[] = '&nbsp;&nbsp;Updating <b>'.$db->prefix($prefixed_query[4]).'</b> table.';
                            $created_tables[] = $prefixed_query[4];
                        } else {
                            $msgs[] = '&nbsp;&nbsp;Data inserted to table <b>'.$db->prefix($prefixed_query[4]).'</b>.';
                        }
                    }
                } else {
                    // the table name is reserved, so halt the installation
                    $errs[] = '<b>'.$prefixed_query[4]."</b> is a reserved table!";
                    $error = true;
                    break;
                }
            }
            // if there was an error, reverse the procedure
            if ($error == true) {
                // And how shall we do that ? :)
            }
        }

        foreach ($msgs as $m) {
            echo $m.'<br />';
        }
        echo "<br />";
        if ($error == true) {
            $endMsg = _AM_SMEDIA_IMPORT_ERROR;
        } else {
            $endMsg = _AM_SMEDIA_IMPORT_SUCCESS;
        }

        echo $endMsg;
        echo "<br /><br />";
        echo "<a href='import.php'>" . _AM_SMEDIA_IMPORT_BACK . "</a>";
        echo "<br /><br />";
        break;

    case "default":
    default:

        $importfile = 'xoops_qa';

        xoops_cp_header();
        smartmedia_adminMenu(-1, _AM_SMEDIA_IMPORT);

        smartmedia_collapsableBar('bottomtable', 'bottomtableicon');
        echo "<img id='bottomtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SMEDIA_IMPORT_TITLE . "</h3>";
        echo "<div id='bottomtable'>";
        echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . _AM_SMEDIA_IMPORT_INFO . "</span>";

        global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $modify, $xoopsModuleConfig, $xoopsModule, $XOOPS_URL, $myts;

        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

        // If there is a parameter, and the id exists, retrieve data: we're editing a request
        $ssorm = new XoopsThemeForm(_AM_SMEDIA_IMPORT_SELECTION, "op", xoops_getenv('PHP_SELF'));
        $sform->setExtra('enctype="multipart/form-data"');

        // Q&A set to import

        $importfile_select_array = array("xoops_qa" => _AM_SMEDIA_XOOPS_QA);

        $importfile_select = new XoopsFormSelect('', 'importfile', $importfile);
        $importfile_select->addOptionArray($importfile_select_array);
        $importfile_tray = new XoopsFormElementTray(_AM_SMEDIA_IMPORT_SELECT_FILE , '&nbsp;');
        $importfile_tray->addElement($importfile_select);
        $sform->addElement($importfile_tray);

        // Buttons
        $button_tray = new XoopsFormElementTray('', '');
        $hidden = new XoopsFormHidden('op', 'importExecute');
        $button_tray->addElement($hidden);

        $butt_import = new XoopsFormButton('', '', _AM_SMEDIA_IMPORT, 'submit');
        $butt_import->setExtra('onclick="this.form.elements.op.value=\'importExecute\'"');
        $button_tray->addElement($butt_import);

        $butt_cancel = new XoopsFormButton('', '', _AM_SMEDIA_CANCEL, 'button');
        $butt_cancel->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($butt_cancel);

        $sform->addElement($button_tray);
        $sform->display();
        unset($hidden);

        // End of collapsable bar
        echo "</div>";

        break;
}

$modfooter = smartmedia_modFooter();
echo "<div align='center'>" . $modfooter . "</div>";
xoops_cp_footer();

?>