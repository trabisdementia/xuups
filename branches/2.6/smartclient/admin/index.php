<?php

/**
 * $Id: index.php,v 1.11 2005/05/11 14:43:40 fx2024 Exp $
 * Module: SmartClient
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

include_once("admin_header.php");
$myts = &MyTextSanitizer::getInstance();

$op = isset($_GET['op']) ? $_GET['op'] : '';

switch ($op) {
    case "createdir":
        $path = isset($_GET['path']) ? $_GET['path'] : false;
        if ($path) {
            if ($path == 'root') {
                $path = '';
            }
            $thePath = smartclient_getUploadDir(true, $path);

            $res = smartclient_admin_mkdir($thePath);
            if ($res) {
                $source = SMARTCLIENT_ROOT_PATH . "images/blank.png";
                $dest = $thePath . "blank.png";
                 
                smartclient_copyr($source, $dest);
            }
            $msg = ($res)?_AM_SCLIENT_DIRCREATED:_AM_SCLIENT_DIRNOTCREATED;

        } else {
            $msg = _AM_SCLIENT_DIRNOTCREATED;
        }

        redirect_header('index.php', 2, $msg . ': ' . $thePath);
        exit();
        break;
}
$pick = isset($_GET['pick']) ? intval($_GET['pick']) : 0;
$pick = isset($_POST['pick']) ? intval($_POST['pick']) :$pick;

$statussel = isset($_GET['statussel']) ? intval($_GET['statussel']) : 0;
$statussel = isset($_POST['statussel']) ? intval($_POST['statussel']) : $statussel;

$sortsel = isset($_GET['sortsel']) ? $_GET['sortsel'] : 'id';
$sortsel = isset($_POST['sortsel']) ? $_POST['sortsel'] : $sortsel;

$ordersel = isset($_GET['ordersel']) ? $_GET['ordersel'] : 'DESC';
$ordersel = isset($_POST['ordersel']) ? $_POST['ordersel'] : $ordersel;


$module_id = $xoopsModule->getVar('mid');

function pathConfiguration()
{
    global $xoopsModule;
    // Upload and Images Folders
    smartclient_collapsableBar('configtable', 'configtableicon');
    echo "<img id='configtableicon' name='configtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SCLIENT_PATHCONFIGURATION . "</h3>";
    echo "<div id='configtable'>";
    echo "<br />";
    echo "<table width='100%' class='outer' cellspacing='1' cellpadding='3' border='0' ><tr>";
    echo "<td class='bg3'><b>" . _AM_SCLIENT_PATH_ITEM . "</b></td>";
    echo "<td class='bg3'><b>" . _AM_SCLIENT_PATH . "</b></td>";
    echo "<td class='bg3' align='center'><b>" . _AM_SCLIENT_STATUS . "</b></td></tr>";

    echo "<tr><td class='odd'>" . _AM_SCLIENT_PATH_IMAGES . "</td>";
    $image_path = smartclient_getImageDir();
    echo "<td class='odd'>" . $image_path . "</td>";
    echo "<td class='even' style='text-align: center;'>" . smartclient_admin_getPathStatus('images') . "</td></tr>";

    echo "</table>";
    echo "<br />";

    echo "</div>";
}


function buildTable()
{
    global $xoopsConfig, $xoopsModuleConfig, $xoopsModule;
    echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
    echo "<tr>";
    echo "<td class='bg3' width='200px' align='left'><b>" . _AM_SCLIENT_NAME . "</b></td>";
    echo "<td width='' class='bg3' align='left'><b>" . _AM_SCLIENT_INTRO . "</b></td>";
    echo "<td width='90' class='bg3' align='center'><b>" . _AM_SCLIENT_HITS . "</b></td>";
    echo "<td width='90' class='bg3' align='center'><b>" . _AM_SCLIENT_STATUS . "</b></td>";
    echo "<td width='90' class='bg3' align='center'><b>" . _AM_SCLIENT_ACTION . "</b></td>";
    echo "</tr>";
}
// Code for the page
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';

// Creating the Client handler object
$client_handler =& smartclient_gethandler('client');

$startentry = isset($_GET['startentry']) ? intval($_GET['startentry']) : 0;

xoops_cp_header();
global $xoopsUser, $xoopsConfig, $xoopsModuleConfig, $xoopsModule;

smartclient_adminMenu(0, _AM_SCLIENT_INDEX);

// Total Clients -- includes everything on the table
$totalclients = $client_handler->getClientCount(_SCLIENT_STATUS_ALL);

// Total Submitted Clients
$totalsubmitted = $client_handler->getClientCount(_SCLIENT_STATUS_SUBMITTED);

// Total active Clients
$totalactive = $client_handler->getClientCount(_SCLIENT_STATUS_ACTIVE);

// Total inactive Clients
$totalinactive = $client_handler->getClientCount(_SCLIENT_STATUS_INACTIVE);

// Total rejected Clients
$totalrejected = $client_handler->getClientCount(_SCLIENT_STATUS_REJECTED);

// Check Path Configuration
if ((smartclient_admin_getPathStatus('images', true) < 0)) {
    pathConfiguration();
}

// -- //
smartclient_collapsableBar('toptable', 'toptableicon');
echo "<img id='toptableicon' name='toptableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SCLIENT_INVENTORY . "</h3>";
echo "<div id='toptable'>";
echo "<br />";
echo "<table width='100%' class='outer' cellspacing='1' cellpadding='3' border='0' ><tr>";
echo "<td class='head'>" . _AM_SCLIENT_TOTAL_SUBMITTED . "</td><td align='center' class='even'>" . $totalsubmitted . "</td>";
echo "<td class='head'>" . _AM_SCLIENT_TOTAL_ACTIVE . "</td><td align='center' class='even'>" . $totalactive . "</td>";
echo "<td class='head'>" . _AM_SCLIENT_TOTAL_REJECTED . "</td><td align='center' class='even'>" . $totalrejected . "</td>";
echo "<td class='head'>" . _AM_SCLIENT_TOTAL_INACTIVE . "</td><td align='center' class='even'>" . $totalinactive . "</td>";
echo "</tr></table>";
echo "<br />";

echo "<form><div style=\"margin-bottom: 24px;\">";
echo "<input type='button' name='button' onclick=\"location='client.php?op=add'\" value='" . _AM_SCLIENT_CLIENT_CREATE . "'>&nbsp;&nbsp;";
echo "</div></form>";
echo "</div>";

// Construction of lower table
smartclient_collapsableBar('bottomtable', 'bottomtableicon');
echo "<img id='bottomtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SCLIENT_ALLITEMS . "</h3>";
echo "<div id='bottomtable'>";
echo "<span style=\"color: #567; margin: 3px 0 18px 0; font-size: small; display: block; \">" . _AM_SCLIENT_ALLITEMSMSG . "</span>";

$showingtxt = '';
$selectedtxt = '';
$cond = "";
$selectedtxt0 = '';
$selectedtxt1 = '';
$selectedtxt2 = '';
$selectedtxt3 = '';
$selectedtxt4 = '';

$sorttxtid='';
$sorttxttitle='';
$sorttxtweight='';

$ordertxtasc='';
$ordertxtdesc='';

switch ($sortsel) {
    case 'title':
        $sorttxttitle = "selected='selected'";
        break;

    case 'weight':
        $sorttxtweight = "selected='selected'";
        break;

    default :
        $sorttxtid = "selected='selected'";
        break;
}

switch ($ordersel) {
    case 'ASC':
        $ordertxtasc = "selected='selected'";
        break;

    default :
        $ordertxtdesc = "selected='selected'";
        break;
}

switch ($statussel) {
    case _SCLIENT_STATUS_ALL :
        $selectedtxt0 = "selected='selected'";
        $caption = _AM_SCLIENT_ALL;
        $cond = "";
        $status_explaination = _AM_SCLIENT_ALL_EXP;
        break;

    case _SCLIENT_STATUS_SUBMITTED :
        $selectedtxt1 = "selected='selected'";
        $caption = _AM_SCLIENT_SUBMITTED;
        $cond = " WHERE status = " . _SCLIENT_STATUS_SUBMITTED . " ";
        $status_explaination = _AM_SCLIENT_SUBMITTED_EXP;
        break;

    case _SCLIENT_STATUS_ACTIVE :
        $selectedtxt2 = "selected='selected'";
        $caption = _AM_SCLIENT_ACTIVE;
        $cond = " WHERE status = " . _SCLIENT_STATUS_ACTIVE . " ";
        $status_explaination = _AM_SCLIENT_ACTIVE_EXP;
        break;

    case _SCLIENT_STATUS_REJECTED :
        $selectedtxt3 = "selected='selected'";
        $caption = _AM_SCLIENT_REJECTED;
        $cond = " WHERE status = " . _SCLIENT_STATUS_REJECTED . " ";
        $status_explaination = _AM_SCLIENT_REJECTED_EXP;
        break;

    case _SCLIENT_STATUS_INACTIVE :
        $selectedtxt4 = "selected='selected'";
        $caption = _AM_SCLIENT_INACTIVE;
        $cond = " WHERE status = " . _SCLIENT_STATUS_INACTIVE . " ";
        $status_explaination = _AM_SCLIENT_INACTIVE_EXP;
        break;
}

/* -- Code to show selected terms -- */
echo "<form name='pick' id='pick' action='" . $_SERVER['PHP_SELF'] . "' method='POST' style='margin: 0;'>";
echo "
	<table width='100%' cellspacing='1' cellpadding='2' border='0' style='border-left: 1px solid silver; border-top: 1px solid silver; border-right: 1px solid silver;'>
		<tr>
			<td><span style='font-weight: bold; font-variant: small-caps;'>" . _AM_SCLIENT_SHOWING . " " . $caption . "</span></td>
			<td align='right'>" . _AM_SCLIENT_SELECT_SORT . " 
				<select name='sortsel' onchange='submit()'>
					<option value='id' $sorttxtid>" . _AM_SCLIENT_ID . "</option>
					<option value='title' $sorttxttitle>" . _AM_SCLIENT_TITLE . "</option>
					<option value='weight' $sorttxtweight>" . _AM_SCLIENT_WEIGHT . "</option>
				</select>
				<select name='ordersel' onchange='submit()'>
					<option value='ASC' $ordertxtasc>" . _AM_SCLIENT_ASC . "</option>
					<option value='DESC' $ordertxtdesc>" . _AM_SCLIENT_DESC . "</option>
				</select>
			" . _AM_SCLIENT_SELECT_STATUS . " : 
				<select name='statussel' onchange='submit()'>
					<option value='0' $selectedtxt0>" . _AM_SCLIENT_ALL . " [$totalclients]</option>
					<option value='1' $selectedtxt1>" . _AM_SCLIENT_SUBMITTED . " [$totalsubmitted]</option>
					<option value='2' $selectedtxt2>" . _AM_SCLIENT_ACTIVE . " [$totalactive]</option>
					<option value='3' $selectedtxt3>" . _AM_SCLIENT_REJECTED . " [$totalrejected]</option>
					<option value='4' $selectedtxt4>" . _AM_SCLIENT_INACTIVE . " [$totalinactive]</option>
				</select>
			</td>
		</tr>
	</table>
	</form>";


// Get number of entries in the selected state
$statusSelected = ($statussel == 0) ? _SCLIENT_STATUS_ALL : $statussel;

$numrows = $client_handler->getClientCount($statusSelected);
// creating the Q&As objects
$clientsObj = $client_handler->getClients($xoopsModuleConfig['perpage_admin'], $startentry, $statusSelected, $sortsel, $ordersel);

$totalClientsOnPage = count($clientsObj);

buildTable();

if ($numrows > 0) {

    for ( $i = 0; $i < $totalClientsOnPage; $i++ ) {

        $approve = '';
        switch ($clientsObj[$i]->status()) {
             
            case _SCLIENT_STATUS_SUBMITTED :
                $statustxt = _AM_SCLIENT_SUBMITTED;
                $approve = "<a href='client.php?op=mod&id=" . $clientsObj[$i]->id() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/approve.gif' title='" . _AM_SCLIENT_CLIENT_APPROVE . "' alt='" . _AM_SCLIENT_CLIENT_APPROVE . "' /></a>&nbsp;";
                $delete = "<a href='client.php?op=del&id=" . $clientsObj[$i]->id() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_SCLIENT_CLIENT_DELETE . "' alt='" . _AM_SCLIENT_CLIENT_DELETE . "' /></a>&nbsp;";
                $modify = "";
                break;
                 
            case _SCLIENT_STATUS_ACTIVE :
                $statustxt = _AM_SCLIENT_ACTIVE;
                $approve = "";
                $modify = "<a href='client.php?op=mod&id=" . $clientsObj[$i]->id() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_SCLIENT_CLIENT_EDIT . "' alt='" . _AM_SCLIENT_CLIENT_EDIT . "' /></a>&nbsp;";
                $delete = "<a href='client.php?op=del&id=" . $clientsObj[$i]->id() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_SCLIENT_CLIENT_DELETE . "' alt='" . _AM_SCLIENT_CLIENT_DELETE . "' /></a>&nbsp;";
                break;
                 
            case _SCLIENT_STATUS_INACTIVE :
                $statustxt = _AM_SCLIENT_INACTIVE;
                $approve = "";
                $modify = "<a href='client.php?op=mod&id=" . $clientsObj[$i]->id() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_SCLIENT_CLIENT_EDIT . "' alt='" . _AM_SCLIENT_CLIENT_EDIT . "' /></a>&nbsp;";
                $delete = "<a href='client.php?op=del&id=" . $clientsObj[$i]->id() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_SCLIENT_CLIENT_DELETE . "' alt='" . _AM_SCLIENT_CLIENT_DELETE . "' /></a>&nbsp;";
                break;
                 
            case _SCLIENT_STATUS_REJECTED :
                $statustxt = _AM_SCLIENT_REJECTED;
                $approve = "";
                $modify = "<a href='client.php?op=mod&id=" . $clientsObj[$i]->id() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_SCLIENT_CLIENT_EDIT . "' alt='" . _AM_SCLIENT_CLIENT_EDIT . "' /></a>&nbsp;";
                $delete = "<a href='client.php?op=del&id=" . $clientsObj[$i]->id() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_SCLIENT_CLIENT_DELETE . "' alt='" . _AM_SCLIENT_CLIENT_DELETE . "' /></a>&nbsp;";
                break;
                 
            case "default" :
            default :
                $statustxt = "";
                $approve = "";
                $modify = "";
                break;
        }

        echo "<tr>";
        echo "<td class='head' align='left'><a href='" . SMARTCLIENT_URL . "client.php?id=" . $clientsObj[$i]->id() . "'><img src='" . SMARTCLIENT_URL . "images/links/client.gif' alt=''/>&nbsp;" . $clientsObj[$i]->title() . "</a></td>";
        echo "<td class='even' align='left'>" . $clientsObj[$i]->summary(100) . "</td>";
        echo "<td class='even' align='center'>" . $clientsObj[$i]->hits() . "</td>";
        echo "<td class='even' align='center'>" . $statustxt . "</td>";
        echo "<td class='even' align='center'> ". $approve . $modify . $delete . "</td>";
        echo "</tr>";
    }
} else {
    // that is, $numrows = 0, there's no entries yet
    echo "<tr>";
    echo "<td class='head' align='center' colspan= '7'>" . _AM_SCLIENT_NOCLIENTS . "</td>";
    echo "</tr>";
}
echo "</table>\n";
echo "<span style=\"color: #567; margin: 3px 0 18px 0; font-size: small; display: block; \">$status_explaination</span>";
$pagenav = new XoopsPageNav($numrows, $xoopsModuleConfig['perpage_admin'], $startentry, 'startentry', "statussel=$statussel&amp;sortsel=$sortsel&amp;ordersel=$ordersel");

if ($xoopsModuleConfig['useimagenavpage'] == 1) {
    echo '<div style="text-align:right; background-color: white; margin: 10px 0;">' . $pagenav->renderImageNav() . '</div>';
} else {
    echo '<div style="text-align:right; background-color: white; margin: 10px 0;">' . $pagenav->renderNav() . '</div>';
}
// ENDs code to show active entries
echo "</div>";
// Close the collapsable div
// Check Path Configuration
if ((smartclient_admin_getPathStatus('images', true) > 0) && (smartclient_admin_getPathStatus('images', true) > 0)) {
    pathConfiguration();
}
echo "</div>";
echo "</div>";

$modfooter = smartclient_modFooter();
echo "<div align='center'>" . $modfooter . "</div>";

xoops_cp_footer();

?>