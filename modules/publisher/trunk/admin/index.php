<?php

/**
* $Id: index.php 1429 2008-04-05 02:00:06Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once("admin_header.php");
$myts = &MyTextSanitizer::getInstance();

$itemid = isset($_POST['itemid']) ? intval($_POST['itemid']) : 0;

$pick = isset($_GET['pick']) ? intval($_GET['pick']) : 0;
$pick = isset($_POST['pick']) ? intval($_POST['pick']) : $pick;

$statussel = isset($_GET['statussel']) ? intval($_GET['statussel']) : 0;
$statussel = isset($_POST['statussel']) ? intval($_POST['statussel']) : $statussel;

$sortsel = isset($_GET['sortsel']) ? $_GET['sortsel'] : 'itemid';
$sortsel = isset($_POST['sortsel']) ? $_POST['sortsel'] : $sortsel;

$ordersel = isset($_GET['ordersel']) ? $_GET['ordersel'] : 'DESC';
$ordersel = isset($_POST['ordersel']) ? $_POST['ordersel'] : $ordersel;

$module_id = $xoopsModule->getVar('mid');
$gperm_handler = &xoops_gethandler('groupperm');
$groups = ($xoopsUser) ? ($xoopsUser->getGroups()) : XOOPS_GROUP_ANONYMOUS;


// auto crate folders----------------------------------------

function createDir(){
// auto crate folders
$thePath = publisher_getUploadDir();

	if(publisher_admin_getPathStatus('root', true) < 0){
		$thePath = publisher_getUploadDir();
		$res = publisher_admin_mkdir($thePath);
		$msg = ($res)?_AM_PUB_DIRCREATED:_AM_PUB_DIRNOTCREATED;
	}

	if(publisher_admin_getPathStatus('images', true) < 0){
		$thePath = publisher_getImageDir();
		$res = publisher_admin_mkdir($thePath);

		if ($res) {
			$source = PUBLISHER_ROOT_PATH ."/images/blank.png";
			$dest = $thePath . "blank.png";
			publisher_copyr($source, $dest);
		}
		$msg = ($res)?_AM_PUB_DIRCREATED:_AM_PUB_DIRNOTCREATED;
	}

	if(publisher_admin_getPathStatus('images/category', true) < 0){
		$thePath = publisher_getImageDir('category');
		$res = publisher_admin_mkdir($thePath);

		if ($res) {
			$source = PUBLISHER_ROOT_PATH ."/images/blank.png";
			$dest = $thePath . "blank.png";
			publisher_copyr($source, $dest);
		}
		$msg = ($res)?_AM_PUB_DIRCREATED:_AM_PUB_DIRNOTCREATED;
	}

	if(publisher_admin_getPathStatus('images/item', true) < 0){
		$thePath = publisher_getImageDir('item');
		$res = publisher_admin_mkdir($thePath);

		if ($res) {
			$source = PUBLISHER_ROOT_PATH ."/images/blank.png";
			$dest = $thePath . "blank.png";
			publisher_copyr($source, $dest);
		}
		$msg = ($res)?_AM_PUB_DIRCREATED:_AM_PUB_DIRNOTCREATED;
	}

	if(publisher_admin_getPathStatus('content', true) < 0){
		$thePath = publisher_getUploadDir(true, 'content');
		$res = publisher_admin_mkdir($thePath);
		$msg = ($res)?_AM_PUB_DIRCREATED:_AM_PUB_DIRNOTCREATED;
	}
}
//----------------------------------------------------------



function buildTable()
{
	global $xoopsConfig, $xoopsModuleConfig, $xoopsModule;
	echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
	echo "<tr>";
	echo "<td width='40px' class='bg3' align='center'><b>" . _AM_PUB_ITEMID . "</b></td>";
	echo "<td width='100px' class='bg3' align='center'><b>" . _AM_PUB_ITEMCAT . "</b></td>";
	echo "<td class='bg3' align='center'><b>" . _AM_PUB_TITLE . "</b></td>";
	echo "<td width='90px' class='bg3' align='center'><b>" . _AM_PUB_CREATED . "</b></td>";
	echo "<td width='90px' class='bg3' align='center'><b>" . _AM_PUB_STATUS . "</b></td>";
	echo "<td width='90px' class='bg3' align='center'><b>" . _AM_PUB_ACTION . "</b></td>";
	echo "</tr>";
}
// Code for the page
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';

global $publisher_category_handler, $publisher_item_handler;

$startentry = isset($_GET['startentry']) ? intval($_GET['startentry']) : 0;

publisher_xoops_cp_header();

global $xoopsUser, $xoopsConfig,$xoopsModuleConfig, $xoopsModule;

publisher_adminMenu(0, _AM_PUB_INDEX);

// Total ITEMs -- includes everything on the table
$totalitems = $publisher_item_handler->getItemsCount();

// Total categories
$totalcategories = $publisher_category_handler->getCategoriesCount(-1);

// Total submitted ITEMs
$totalsubmitted = $publisher_item_handler->getItemsCount(-1, array(_PUB_STATUS_SUBMITTED));

// Total published ITEMs
$totalpublished = $publisher_item_handler->getItemsCount(-1, array(_PUB_STATUS_PUBLISHED));

// Total offline ITEMs
$totaloffline = $publisher_item_handler->getItemsCount(-1, array(_PUB_STATUS_OFFLINE));

// Total rejected
$totalrejected = $publisher_item_handler->getItemsCount(-1, array(_PUB_STATUS_REJECTED));

// Check Path Configuration
if ((publisher_admin_getPathStatus('root', true) < 0) ||
(publisher_admin_getPathStatus('images', true) < 0) ||
(publisher_admin_getPathStatus('images/category', true) < 0) ||
(publisher_admin_getPathStatus('images/item', true) < 0) ||
(publisher_admin_getPathStatus('content', true) < 0)
) {

	createDir();
}

// -- //
publisher_collapsableBar('inventorytable', 'inventoryicon', _AM_PUB_INVENTORY);
echo "<br />";
echo "<table width='100%' class='outer' cellspacing='1' cellpadding='3' border='0' ><tr>";
echo "<td class='head'>" . _AM_PUB_TOTALCAT . "</td><td align='center' class='even'>" . $totalcategories . "</td>";
echo "<td class='head'>" . _AM_PUB_TOTALSUBMITTED . "</td><td align='center' class='even'>" . $totalsubmitted . "</td>";
echo "<td class='head'>" . _AM_PUB_TOTALPUBLISHED . "</td><td align='center' class='even'>" . $totalpublished . "</td>";
echo "<td class='head'>" . _AM_PUB_TOTAL_OFFLINE . "</td><td align='center' class='even'>" . $totaloffline . "</td>";
echo "</tr></table>";
echo "<br />";

echo "<form><div style=\"margin-bottom: 12px;\">";
echo "<input type='button' name='button' onclick=\"location='category.php?op=mod'\" value='" . _AM_PUB_CATEGORY_CREATE . "'>&nbsp;&nbsp;";
echo "<input type='button' name='button' onclick=\"location='item.php?op=mod'\" value='" . _AM_PUB_CREATEITEM . "'>&nbsp;&nbsp;";
echo "</div></form>";

publisher_close_collapsable('inventorytable', 'inventoryicon');

// Construction of lower table
publisher_collapsableBar('allitemstable', 'allitemsicon', _AM_PUB_ALLITEMS, _AM_PUB_ALLITEMSMSG);

$showingtxt = '';
$selectedtxt = '';
$cond = "";
$selectedtxt0 = '';
$selectedtxt1 = '';
$selectedtxt2 = '';
$selectedtxt3 = '';
$selectedtxt4 = '';

$sorttxttitle = "";
$sorttxtcreated = "";
$sorttxtweight = "";
$sorttxtitemid = "";

$ordertxtasc='';
$ordertxtdesc='';

switch ($sortsel) {
	case 'title':
	$sorttxttitle = "selected='selected'";
	break;

	case 'datesub':
	$sorttxtcreated = "selected='selected'";
	break;

	case 'weight':
	$sorttxtweight = "selected='selected'";
	break;

	default :
	$sorttxtitemid = "selected='selected'";
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
	case _PUB_STATUS_ALL :
	$selectedtxt0 = "selected='selected'";
	$caption = _AM_PUB_ALL;
	$cond = "";
	$status_explaination = _AM_PUB_ALL_EXP;
	break;

	case _PUB_STATUS_SUBMITTED :
	$selectedtxt1 = "selected='selected'";
	$caption = _AM_PUB_SUBMITTED;
	$cond = " WHERE status = " . _PUB_STATUS_SUBMITTED . " ";
	$status_explaination = _AM_PUB_SUBMITTED_EXP;
	break;

	case _PUB_STATUS_PUBLISHED :
	$selectedtxt2 = "selected='selected'";
	$caption = _AM_PUB_PUBLISHED;
	$cond = " WHERE status = " . _PUB_STATUS_PUBLISHED . " ";
	$status_explaination = _AM_PUB_PUBLISHED_EXP;
	break;

	case _PUB_STATUS_OFFLINE :
	$selectedtxt3 = "selected='selected'";
	$caption = _AM_PUB_OFFLINE;
	$cond = " WHERE status = " . _PUB_STATUS_OFFLINE . " ";
	$status_explaination = _AM_PUB_OFFLINE_EXP;
	break;

	case _PUB_STATUS_REJECTED :
	$selectedtxt4 = "selected='selected'";
	$caption = _AM_PUB_REJECTED;
	$cond = " WHERE status = " . _PUB_STATUS_REJECTED . " ";
	$status_explaination = _AM_PUB_REJECTED_ITEM_EXP;
	break;
}

/* -- Code to show selected terms -- */
echo "<form name='pick' id='pick' action='" . $_SERVER['PHP_SELF'] . "' method='POST' style='margin: 0;'>";

echo "
	<table width='100%' cellspacing='1' cellpadding='2' border='0' style='border-left: 1px solid silver; border-top: 1px solid silver; border-right: 1px solid silver;'>
		<tr>
			<td><span style='font-weight: bold; font-variant: small-caps;'>" . _AM_PUB_SHOWING . " " . $caption . "</span></td>
			<td align='right'>" . _AM_PUB_SELECT_SORT . "
				<select name='sortsel' onchange='submit()'>
					<option value='itemid' $sorttxtitemid>" . _AM_PUB_ID . "</option>
					<option value='title' $sorttxttitle>" . _AM_PUB_TITLE . "</option>
					<option value='datesub' $sorttxtcreated>" . _AM_PUB_CREATED . "</option>
					<option value='weight' $sorttxtweight>" . _AM_PUB_WEIGHT . "</option>
				</select>
				<select name='ordersel' onchange='submit()'>
					<option value='ASC' $ordertxtasc>" . _AM_PUB_ASC . "</option>
					<option value='DESC' $ordertxtdesc>" . _AM_PUB_DESC . "</option>
				</select>
			" . _AM_PUB_SELECT_STATUS . " :
				<select name='statussel' onchange='submit()'>
					<option value='0' $selectedtxt0>" . _AM_PUB_ALL . " [$totalitems]</option>
					<option value='1' $selectedtxt1>" . _AM_PUB_SUBMITTED . " [$totalsubmitted]</option>
					<option value='2' $selectedtxt2>" . _AM_PUB_PUBLISHED . " [$totalpublished]</option>
					<option value='3' $selectedtxt3>" . _AM_PUB_OFFLINE . " [$totaloffline]</option>
					<option value='4' $selectedtxt4>" . _AM_PUB_REJECTED . " [$totalrejected]</option>
				</select>
			</td>
		</tr>
	</table>
	</form>";


// Get number of entries in the selected state
$statusSelected = ($statussel == 0) ? -1 : $statussel;

$numrows = $publisher_item_handler->getItemsCount(-1, $statusSelected);
// creating the Q&As objects

$itemsObj = $publisher_item_handler->getItems($xoopsModuleConfig['perpage'], $startentry, $statusSelected, -1, $sortsel, $ordersel);

$totalItemsOnPage = count($itemsObj);

buildTable();

if ($numrows > 0) {

	for ( $i = 0; $i < $totalItemsOnPage; $i++ ) {
		// Creating the category object to which this item is linked
		$categoryObj =& $itemsObj[$i]->category();
		$approve = '';

		switch ($itemsObj[$i]->status()) {

			case _PUB_STATUS_SUBMITTED :
			$statustxt = _AM_PUB_SUBMITTED;
			$approve = "<a href='item.php?op=mod&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/approve.gif' title='" . _AM_PUB_SUBMISSION_MODERATE . "' alt='" . _AM_PUB_SUBMISSION_MODERATE . "' /></a>&nbsp;";
			$clone = '';
			$delete = "<a href='item.php?op=del&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_PUB_DELETEITEM . "' alt='" . _AM_PUB_DELETEITEM . "' /></a>";
			$modify = "";
			break;

			case _PUB_STATUS_PUBLISHED :
			$statustxt = _AM_PUB_PUBLISHED;
			$approve = "";
			$clone = "<a href='item.php?op=clone&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/clone.gif' title='" . _AM_PUB_CLONE_ITEM . "' alt='" .  _AM_PUB_CLONE_ITEM  . "' /></a>&nbsp;";
			$modify = "<a href='item.php?op=mod&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_PUB_ITEM_EDIT . "' alt='" . _AM_PUB_ITEM_EDIT . "' /></a>&nbsp;";
			$delete = "<a href='item.php?op=del&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_PUB_DELETEITEM . "' alt='" . _AM_PUB_DELETEITEM . "' /></a>";
			break;

			case _PUB_STATUS_OFFLINE :
			$statustxt = _AM_PUB_OFFLINE;
			$approve = "";
			$clone = "<a href='item.php?op=clone&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/clone.gif' title='" . _AM_PUB_CLONE_ITEM . "' alt='" .  _AM_PUB_CLONE_ITEM  . "' /></a>&nbsp;";
			$modify = "<a href='item.php?op=mod&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_PUB_ITEM_EDIT . "' alt='" . _AM_PUB_ITEM_EDIT . "' /></a>&nbsp;";
			$delete = "<a href='item.php?op=del&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_PUB_DELETEITEM . "' alt='" . _AM_PUB_DELETEITEM . "' /></a>";
			break;

			case _PUB_STATUS_REJECTED :
			$statustxt = _AM_PUB_REJECTED;
			$approve = "";
			$clone = "<a href='item.php?op=clone&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/clone.gif' title='" . _AM_PUB_CLONE_ITEM . "' alt='" . _AM_PUB_CLONE_ITEM . "' /></a>&nbsp;";
			$modify = "<a href='item.php?op=mod&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_PUB_REJECTED_EDIT . "' alt='" . _AM_PUB_REJECTED_EDIT . "' /></a>&nbsp;";
			$delete = "<a href='item.php?op=del&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_PUB_DELETEITEM . "' alt='" . _AM_PUB_DELETEITEM . "' /></a>";
			break;

			case "default" :
			default :
			$statustxt = _AM_PUB_STATUS0;
			$approve = "";
			$clone = '';
			$modify = "<a href='item.php?op=mod&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_PUB_REJECTED_EDIT . "' alt='" . _AM_PUB_REJECTED_EDIT . "' /></a>&nbsp;";
			$delete = "<a href='item.php?op=del&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_PUB_DELETEITEM . "' alt='" . _AM_PUB_DELETEITEM . "' /></a>";
			break;
		}

		echo "<tr>";
		echo "<td class='head' align='center'>" . $itemsObj[$i]->itemid() . "</td>";
		echo "<td class='even' align='left'>" . $categoryObj->getCategoryLink() . "</td>";
		echo "<td class='even' align='left'>" . $itemsObj[$i]->getItemLink() . "</td>";
		echo "<td class='even' align='center'>" . $itemsObj[$i]->datesub() . "</td>";
		echo "<td class='even' align='center'>" . $statustxt . "</td>";
		echo "<td class='even' align='center'> ". $approve .$clone. $modify . $delete . "</td>";
		echo "</tr>";
	}
} else {
	// that is, $numrows = 0, there's no entries yet
	echo "<tr>";
	echo "<td class='head' align='center' colspan= '7'>" . _AM_PUB_NOITEMSSEL . "</td>";
	echo "</tr>";
}
echo "</table>\n";
echo "<span style=\"color: #567; margin: 3px 0 18px 0; font-size: small; display: block; \">$status_explaination</span>";
$pagenav = new XoopsPageNav($numrows, $xoopsModuleConfig['perpage'], $startentry, 'startentry', "statussel=$statussel&amp;sortsel=$sortsel&amp;ordersel=$ordersel");

if ($xoopsModuleConfig['useimagenavpage'] == 1) {
	echo '<div style="text-align:right; background-color: white; margin: 10px 0;">' . $pagenav->renderImageNav() . '</div>';
} else {
	echo '<div style="text-align:right; background-color: white; margin: 10px 0;">' . $pagenav->renderNav() . '</div>';
}
// ENDs code to show active entries
publisher_close_collapsable('allitemstable', 'allitemsicon');
// Close the collapsable div


xoops_cp_footer();

?>
