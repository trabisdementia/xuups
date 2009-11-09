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
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Publisher
 * @subpackage      Include
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: search.inc.php 0 2009-06-11 18:47:04Z trabis $
 */

$publisher =& PublisherPublisher::getInstance();

$startitem = isset($_GET['startitem']) ? intval($_GET['startitem']) : 0;

$items_title = _AM_PUBLISHER_CAT_ITEMS;
$items_info = _AM_PUBLISHER_CAT_ITEMS_DSC;
$sel_cat = $categoryid;

publisher_openCollapsableBar('bottomtable', 'bottomtableicon', $items_title, $items_info);

// Get the total number of published ITEMS
$totalitems = $publisher->getHandler('item')->getItemsCount($sel_cat, array(_PUBLISHER_STATUS_PUBLISHED));

// creating the items objects that are published
$itemsObj = $publisher->getHandler('item')->getAllPublished($publisher->getConfig('idxcat_perpage'), $startitem,$sel_cat);

$totalitemsOnPage = count($itemsObj);

$allcats = $publisher->getHandler('category')->getObjects(null, true);
echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
echo "<tr>";
echo "<td width='40' class='bg3' align='center'><b>" . _AM_PUBLISHER_ITEMID . "</b></td>";
echo "<td width='20%' class='bg3' align='left'><b>" . _AM_PUBLISHER_ITEMCOLNAME . "</b></td>";
echo "<td class='bg3' align='left'><b>" . _AM_PUBLISHER_ITEMDESC . "</b></td>";
echo "<td width='90' class='bg3' align='center'><b>" . _AM_PUBLISHER_CREATED . "</b></td>";
echo "<td width='60' class='bg3' align='center'><b>" . _AM_PUBLISHER_ACTION . "</b></td>";
echo "</tr>";

if ($totalitems > 0) {
	for ( $i = 0; $i < $totalitemsOnPage; $i++ ) {
		$categoryObj =& $allcats[$itemsObj[$i]->categoryid()];
		$modify = "<a href='item.php?op=mod&amp;itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . XOOPS_URL . "/modules/" . $publisher->getModule()->dirname() . "/images/icon/edit.gif' title='" . _AM_PUBLISHER_EDITITEM . "' alt='" . _AM_PUBLISHER_EDITITEM . "' /></a>";
		$delete = "<a href='item.php?op=del&amp;itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . XOOPS_URL . "/modules/" . $publisher->getModule()->dirname() . "/images/icon/delete.gif' title='" .  _AM_PUBLISHER_DELETEITEM . "' alt='" . _AM_PUBLISHER_DELETEITEM . "'/></a>";

		echo "<tr>";
		echo "<td class='head' align='center'>" . $itemsObj[$i]->itemid() . "</td>";
		echo "<td class='even' align='left'>" . $categoryObj->name() . "</td>";
		echo "<td class='even' align='left'>" . $itemsObj[$i]->getitemLink() . "</td>";

		echo "<td class='even' align='center'>" . $itemsObj[$i]->datesub('s') . "</td>";
		echo "<td class='even' align='center'> $modify $delete </td>";
		echo "</tr>";
	}
} else {
	$itemid = -1;
	echo "<tr>";
	echo "<td class='head' align='center' colspan= '7'>" . _AM_PUBLISHER_NOITEMS . "</td>";
	echo "</tr>";
}
echo "</table>\n";
echo "<br />\n";
$parentid = (isset($_POST['parentid'])) ? intval($_POST['parentid']) : 0;
$pagenav_extra_args = "op=mod&categoryid=$sel_cat&parentid=$parentid";
$pagenav = new XoopsPageNav($totalitems, $publisher->getConfig('idxcat_perpage'), $startitem, 'startitem', $pagenav_extra_args);
echo '<div style="text-align:right;">' . $pagenav->renderNav() . '</div>';
echo "<input type='button' name='button' onclick=\"location='item.php?op=mod&categoryid=" . $sel_cat . "'\" value='" . _AM_PUBLISHER_CREATEITEM . "'>&nbsp;&nbsp;";
echo "</div>";

?>
