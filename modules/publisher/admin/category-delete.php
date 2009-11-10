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
 * @package         Admin
 * @subpackage      Action
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: category-delete.php 0 2009-06-11 18:47:04Z trabis $
 */

include_once dirname(__FILE__) . '/admin_header.php';

$categoryid = (isset($_POST['categoryid'])) ? intval($_POST['categoryid']) : 0;
$categoryid = (isset($_GET['categoryid'])) ? intval($_GET['categoryid']) : $categoryid;
	
$categoryObj = $publisher->getHandler('category')->get($categoryid);
	
$confirm = (isset($_POST['confirm'])) ? $_POST['confirm'] : 0;
$name = (isset($_POST['name'])) ? $_POST['name'] : '';
	
if ($confirm) {
    if (!$publisher->getHandler('category')->delete($categoryObj)) {
        redirect_header("category.php", 1, _AM_PUBLISHER_DELETE_CAT_ERROR);
        exit;
    }
		
    redirect_header("category.php", 1, sprintf(_AM_PUBLISHER_COLISDELETED, $name));
    exit();
} else {
    // no confirm: show deletion condition
    $categoryid = (isset($_GET['categoryid'])) ? intval($_GET['categoryid']) : 0;
    xoops_cp_header();
    xoops_confirm(array('op' => 'del', 'categoryid' => $categoryObj->categoryid(), 'confirm' => 1, 'name' => $categoryObj->name()), 'category.php', _AM_PUBLISHER_DELETECOL . " '" . $categoryObj->name() . "'. <br /> <br />" . _AM_PUBLISHER_DELETE_CAT_CONFIRM, _AM_PUBLISHER_DELETE);
    xoops_cp_footer();
}
?>
