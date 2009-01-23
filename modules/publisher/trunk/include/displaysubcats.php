<?php

/**
* $Id: displaysubcats.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $xoopsModule;

$sc_title = _AM_PUB_SUBCAT_CAT;
$sc_info = _AM_PUB_SUBCAT_CAT_DSC;
$sel_cat = $categoryid;


publisher_collapsableBar('subcatstable', 'subcatsicon', $sc_title, $sc_info);

// Get the total number of sub-categories
$categoriesObj = $publisher_category_handler->get($sel_cat);

$totalsubs = $publisher_category_handler->getCategoriesCount($sel_cat);

// creating the categories objects that are published
$subcatsObj = $publisher_category_handler->getCategories(0,0,$categoriesObj->categoryid());

$totalSCOnPage = count($subcatsObj);
echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
echo "<tr>";
echo "<td width='60' class='bg3' align='left'><b>" . _AM_PUB_CATID . "</b></td>";
echo "<td width='20%' class='bg3' align='left'><b>" . _AM_PUB_CATCOLNAME . "</b></td>";
echo "<td class='bg3' align='left'><b>" . _AM_PUB_SUBDESCRIPT . "</b></td>";
echo "<td width='60' class='bg3' align='right'><b>" . _AM_PUB_ACTION . "</b></td>";
echo "</tr>";

if ($totalsubs > 0) {
	foreach ($subcatsObj as $subcat) {
		$modify = "<a href='category.php?op=mod&amp;categoryid=" . $subcat->categoryid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_PUB_MODIFY . "' alt='" . _AM_PUB_MODIFY . "' /></a>";
		$delete = "<a href='category.php?op=del&amp;categoryid=" . $subcat->categoryid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_PUB_DELETE . "' alt='" . _AM_PUB_DELETE . "'/></a>";
		echo "<tr>";
		echo "<td class='head' align='left'>" . $subcat->categoryid() . "</td>";
		echo "<td class='even' align='left'><a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/category.php?categoryid=" . $subcat->categoryid() . "&parentid=".$subcat->parentid()."'>" .$subcat->name() . "</a></td>";
		echo "<td class='even' align='left'>" . $subcat->description() . "</td>";
		echo "<td class='even' align='right'> $modify $delete </td>";
		echo "</tr>";
	}
} else {
	echo "<tr>";
	echo "<td class='head' align='center' colspan= '7'>" . _AM_PUB_NOSUBCAT . "</td>";
	echo "</tr>";
}
echo "</table>\n";
echo "<br />\n";
publisher_close_collapsable('subcatstable', 'subcatsicon');


?>
