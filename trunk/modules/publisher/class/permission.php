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
 *  Publisher class
 *
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Class
 * @subpackage      Handlers
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: permission.php 0 2009-06-11 18:47:04Z trabis $
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once dirname(dirname(__FILE__)) . '/include/common.php';

class PublisherPermissionHandler extends XoopsObjectHandler
{
    /**
     * @var PublisherPublisher
	 * @access public
     */
    var $publisher = null;
    
    function PublisherPermissionHandler()
    {
        $this->publisher =& PublisherPublisher::getInstance();
    }
    
	/**
	* Returns permissions for a certain type
	*
	* @param string $type "global", "forum" or "topic" (should perhaps have "post" as well - but I don't know)
	* @param int $id id of the item (forum, topic or possibly post) to get permissions for
	*
	* @return array
	*/
	function getGrantedGroups($gperm_name, $id = null)
    {
		static $groups;

		if (!isset($groups[$gperm_name]) || ($id != null && !isset($groups[$gperm_name][$id]))) {
			//Get group permissions handler
			$gperm_handler =& xoops_gethandler('groupperm');

			//Get groups allowed for an item id
			$allowedgroups = $gperm_handler->getGroupIds($gperm_name, $id, $this->publisher->getModule()->getVar('mid'));
			$groups[$gperm_name][$id] = $allowedgroups;
		}
		//Return the permission array
		return isset($groups[$gperm_name][$id]) ? $groups[$gperm_name][$id] : array();
	}

	function getGrantedGroupsForIds($item_ids_array, $gperm_name = false)
    {
		static $groups;
		static $publisher_all_permissions_fetched;

		if ($gperm_name){
			if (isset($groups[$gperm_name])) {
				return $groups[$gperm_name];
			}
		} else {
			// if !$gperm_name then we will fetch all permissions in the module so we don't need them again

			if ($publisher_all_permissions_fetched) {
				return $groups;
			} else {
				$publisher_all_permissions_fetched = true;
			}
		}

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('gperm_modid', $this->publisher->getModule()->getVar('mid')));

		if ($gperm_name) {
			$criteria->add(new Criteria('gperm_name', $gperm_name));
		}

		//Get group permissions handler
		$gperm_handler =& xoops_gethandler('groupperm');

		$permissionsObj = $gperm_handler->getObjects($criteria);

		foreach ($permissionsObj as $permissionObj) {
			$groups[$permissionObj->getVar('gperm_name')][$permissionObj->getVar('gperm_itemid')][] = $permissionObj->getVar('gperm_groupid');
		}

		//Return the permission array
		if ($gperm_name) {
			return isset($groups[$gperm_name]) ? $groups[$gperm_name] : array();
		} else {
			return isset($groups) ? $groups : array();
		}
	}

	/**
	* Returns permissions for a certain type
	*
	* @param string $type "global", "forum" or "topic" (should perhaps have "post" as well - but I don't know)
	* @param int $id id of the item (forum, topic or possibly post) to get permissions for
	*
	* @return array
	*/
	function getGrantedItems($gperm_name, $id = null)
    {
		global $xoopsUser;
		
		static $permissions;

		if (!isset($permissions[$gperm_name]) || ($id != null && !isset($permissions[$gperm_name][$id]))) {

			//Get group permissions handler
			$gperm_handler =& xoops_gethandler('groupperm');

			//Get user's groups
			$groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);

			//Get all allowed item ids in this module and for this user's groups
			$userpermissions =& $gperm_handler->getItemIds($gperm_name, $groups, $this->publisher->getModule()->getVar('mid'));
			$permissions[$gperm_name] = $userpermissions;
		}
		//Return the permission array
		return isset($permissions[$gperm_name]) ? $permissions[$gperm_name] : array();
	}
	
	function isGranted($gperm_name, $id = null)
    {
        static $permissions;

        if ($id == null) return false;
        
        if (!isset($permissions[$gperm_name]) || !isset($permissions[$gperm_name][$id])) {
            $userpermissions = in_array($id, $this->getGrantedItems($gperm_name)) ? true : false;
			$permissions[$gperm_name][$id] = $userpermissions;
        }

        return $permissions[$gperm_name][$id];
	}

	/**
	* Saves permissions for the selected category
	*
	*  saveCategory_Permissions()
	*
	* @param array $groups : group with granted permission
	* @param integer $categoryID : categoryID on which we are setting permissions for Categories and Forums
	* @param string $perm_name : name of the permission
	* @return boolean : TRUE if the no errors occured
	**/

	function saveItem_Permissions($groups, $itemid, $perm_name)
	{
		$result = true;
		$module_id = $this->publisher->getModule()->getVar('mid')   ;
		$gperm_handler =& xoops_gethandler('groupperm');

		// First, if the permissions are already there, delete them
		$gperm_handler->deleteByModule($module_id, $perm_name, $itemid);
		//echo "itemid : $itemid - perm : $perm_name - modid : $module_id";
		//exit;
		// Save the new permissions

		if (count($groups) > 0) {
			foreach ($groups as $group_id) {
				echo $group_id . "-";
				echo $gperm_handler->addRight($perm_name, $itemid, $group_id, $module_id);
			}
		}
		return $result;
	}

	/**
	* Delete all permission for a specific item
	*
	*  deletePermissions()
	*
	* @param integer $itemid : id of the item for which to delete the permissions
	* @return boolean : TRUE if the no errors occured
	**/

	function deletePermissions($itemid, $gperm_name)
	{
		$result = true;
		
		$gperm_handler =& xoops_gethandler('groupperm');
		$gperm_handler->deleteByModule($this->publisher->getModule()->getVar('mid'), $gperm_name, $itemid);

		return $result;
	}

}
?>
