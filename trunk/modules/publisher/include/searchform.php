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
 * @version         $Id: searchform.php 0 2009-06-11 18:47:04Z trabis $
 */

if (!defined("XOOPS_ROOT_PATH")) { 
 	die("XOOPS root path not defined");
}

$categoryID = isset($categoryID) ? intval($categoryID) : 0;
$type = isset($type) ? intval($type) : 3;
$term = isset($term) ? ($type) : '';

$sform = new XoopsThemeForm(_MD_WB_SEARCHFORM, "searchform", "search.php");
$sform->setExtra('enctype="multipart/form-data"');

$searchtype = new XoopsFormSelect(_MD_WB_LOOKON, 'type', $type);
$searchtype->addOptionArray(array("1" => _MD_WB_TERMS, "2" => _MD_WB_DEFINS, "3" => _MD_WB_TERMSDEFS));
$sform->addElement($searchtype, true);

if ($publisher->getConfig('multicats') == 1) {
    $searchcat = new XoopsFormSelect(_MD_WB_CATEGORY, 'categoryID', $categoryID);
    $searchcat->addOption ("0", _MD_WB_ALLOFTHEM);

    $resultcat = $xoopsDB->query ("SELECT categoryID, name FROM " . $xoopsDB->prefix ("wbcategories") . " ORDER BY categoryID");

    while (list($categoryID, $name) = $xoopsDB->fetchRow($resultcat)) {
        $searchcat->addOption ("categoryID", "$categoryID : $name");
    } 
    $sform->addElement($searchcat, true);
} 

$searchterm = new XoopsFormText(_MD_WB_TERM, "term", 25, 100, $term);
$sform->addElement($searchterm, true);

$submit_button = new XoopsFormButton("", "submit", _MD_WB_SEARCH, "submit");
$sform->addElement($submit_button);

?>
