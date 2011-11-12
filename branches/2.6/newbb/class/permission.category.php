<?php
/**
 * CBB 4.0, or newbb, the forum module for XOOPS project
 *
 * @copyright	The XOOPS Project http://xoops.sf.net
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <phppp@users.sourceforge.net>
 * @since		4.00
 * @version		$Id $
 * @package		module::newbb
 */

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

//defined("NEWBB_HANDLER_PERMISSION") || include dirname(__FILE__).'/permission.php';
//define("NEWBB_HANDLER_PERMISSION_CATEGORY", 1);

class NewbbPermissionCategoryHandler extends NewbbPermissionHandler
{
    function NewbbPermissionCategoryHandler(&$db) {
        $this->NewbbPermissionHandler($db);
	}

	function getValidItems($mid, $id = 0)
	{
        $full_items = array();
		if (empty($mid)) return $full_items;

		$full_items[] = "'category_access'";
        return $full_items;
	}

    function deleteByCategory($cat_id)
    {
	    $cat_id = intval($cat_id);
	    if (empty($cat_id)) return false;
        $gperm_handler =& xoops_gethandler('groupperm');
        $criteria = new CriteriaCompo(new Criteria('gperm_modid', $GLOBALS["xoopsModule"]->getVar('mid')));
        $criteria->add(new Criteria('gperm_name', 'category_access'));
        $criteria->add(new Criteria('gperm_itemid', $cat_id));
        return $gperm_handler->deleteAll($criteria);
    }

    function setCategoryPermission($category, $groups = array())
    {
	    if (is_object($GLOBALS["xoopsModule"]) && $GLOBALS["xoopsModule"]->getVar("dirname") == "newbb") {
		    $mid = $GLOBALS["xoopsModule"]->getVar("mid");
	    } else {
    		$module_handler =& xoops_gethandler('module');
			$newbb =& $module_handler->getByDirname('newbb');
			$mid = $newbb->getVar("mid");
	    }
		if (empty($groups)) {
		    $member_handler =& xoops_gethandler('member');
		    $glist = $member_handler->getGroupList();
		    $groups = array_keys($glist);
	    }
		$ids = $this->getGroupIds("category_access", $category, $mid);
	    $ids_add = array_diff($groups, $ids);
	    $ids_rmv = array_diff($ids, $groups);
		foreach ($ids_add as $group) {
			$this->addRight("category_access", $category, $group, $mid);
		}
		foreach ($ids_rmv as $group) {
			$this->deleteRight("category_access", $category, $group, $mid);
		}

        return true;
    }
}

?>