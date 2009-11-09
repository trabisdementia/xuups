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
 * @version         $Id: displaysubcats.php 0 2009-06-11 18:47:04Z trabis $
 */

$publisher =& PublisherPublisher::getInstance();

$sc_title = _AM_PUBLISHER_SUBCAT_CAT;
$sc_info = _AM_PUBLISHER_SUBCAT_CAT_DSC;
$sel_cat = $categoryid;

publisher_openCollapsableBar('subcatstable', 'subcatsicon', $sc_title, $sc_info);

// Get the total number of sub-categories
$categoriesObj = $publisher->getHandler('category')->get($sel_cat);

$totalsubs = $publisher->getHandler('category')->getCategoriesCount($sel_cat);

// creating the categories objects that are published
$subcatsObj = $publisher->getHandler('category')->getCategories(0, 0, $categoriesObj->categoryid());

$totalSCOnPage = count($subcatsObj);
echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
echo "<tr>";
echo "<td width='60' class='bg3' align='left'><b>" . _AM_PUBLISHER_CATID . "</b></td>";
echo "<td width='20%' class='bg3' align='left'><b>" . _AM_PUBLISHER_CATCOLNAME . "</b></td>";
echo "<td class='bg3' align='left'><b>" . _AM_PUBLISHER_SUBDESCRIPT . "</b></td>";
echo "<td width='60' class='bg3' align='right'><b>" . _AM_PUBLISHER_ACTION . "</b></td>";
echo "</tr>";

if ($totalsubs > 0) {
	foreach ($subcatsObj as $subcat) {
		$modify = "<a href='category.php?op=mod&amp;categoryid=" . $subcat->categoryid() . "'><img src='" . XOOPS_URL . "/modules/" . $publisher->getModule()->dirname() . "/images/icon/edit.gif' title='" . _AM_PUBLISHER_MODIFY . "' alt='" . _AM_PUBLISHER_MODIFY . "' /></a>";
		$delete = "<a href='category.php?op=del&amp;categoryid=" . $subcat->categoryid() . "'><img src='" . XOOPS_URL . "/modules/" . $publisher->getModule()->dirname() . "/images/icon/delete.gif' title='" . _AM_PUBLISHER_DELETE . "' alt='" . _AM_PUBLISHER_DELETE . "' /></a>";
		echo "<tr>";
		echo "<td class='head' align='left'>" . $subcat->categoryid() . "</td>";
		echo "<td class='even' align='left'><a href='" . XOOPS_URL . "/modules/" . $publisher->getModule()->dirname() . "/category.php?categoryid=" . $subcat->categoryid() . "&amp;parentid=" . $subcat->parentid() . "'>" .$subcat->name() . "</a></td>";
		echo "<td class='even' align='left'>" . $subcat->description() . "</td>";
		echo "<td class='even' align='right'> {$modify} {$delete} </td>";
		echo "</tr>";
	}
} else {
	echo "<tr>";
	echo "<td class='head' align='center' colspan= '7'>" . _AM_PUBLISHER_NOSUBCAT . "</td>";
	echo "</tr>";
}
echo "</table>\n";
echo "<br />\n";
publisher_closeCollapsableBar('subcatstable', 'subcatsicon');

?>
