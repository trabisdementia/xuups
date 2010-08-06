<?php

/**
 * $Id: smartobjectpermission.php 159 2007-12-17 16:44:05Z malanciault $
 * Module: SmartObject
 * Author: The SmartFactory <www.smartfactory.ca>
 * Credits: Mithrandir
 * Licence: GNU
 */
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

class SmartobjectPermissionHandler extends XoopsObjectHandler
{
    var $handler;
    function SmartObjectPermissionHandler($handler) {
        $this->handler=$handler;
    }

    /*
     * Returns permissions for a certain type
     *
     * @param string $type "global", "forum" or "topic" (should perhaps have "post" as well - but I don't know)
     * @param int $id id of the item (forum, topic or possibly post) to get permissions for
     *
     * @return array
     */
    function getGrantedGroups($gperm_name, $id = null) {
        static $groups;

        if (!isset($groups[$gperm_name]) || ($id != null && !isset($groups[$gperm_name][$id]))) {
            $smartModule =& $this->handler->getModuleInfo();
            //Get group permissions handler
            $gperm_handler =& xoops_gethandler('groupperm');

            //Get groups allowed for an item id
            $allowedgroups = $gperm_handler->getGroupIds($gperm_name, $id, $smartModule->getVar('mid'));
            $groups[$gperm_name][$id] = $allowedgroups;
        }
        //Return the permission array
        return isset($groups[$gperm_name][$id]) ? $groups[$gperm_name][$id] : array();
    }

    function getGrantedGroupsForIds($item_ids_array, $gperm_name=false) {

        static $groups;

        if ($gperm_name){
            if (isset($groups[$gperm_name])) {
                return $groups[$gperm_name];
            }
        } else {
            // if !$gperm_name then we will fetch all permissions in the module so we don't need them again
            return $groups;
        }

        $smartModule =& $this->handler->getModuleInfo();

        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('gperm_modid', $smartModule->getVar('mid')));

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

    /*
     * Returns permissions for a certain type
     *
     * @param string $type "global", "forum" or "topic" (should perhaps have "post" as well - but I don't know)
     * @param int $id id of the item (forum, topic or possibly post) to get permissions for
     *
     * @return array
     */
    function getGrantedItems($gperm_name, $id = null) {
        global $xoopsUser;
        static $permissions;

        if (!isset($permissions[$gperm_name]) || ($id != null && !isset($permissions[$gperm_name][$id]))) {

            $smartModule =& $this->handler->getModuleInfo();

            if (is_object($smartModule)) {

                //Get group permissions handler
                $gperm_handler =& xoops_gethandler('groupperm');

                //Get user's groups
                $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);

                //Get all allowed item ids in this module and for this user's groups
                $userpermissions =& $gperm_handler->getItemIds($gperm_name, $groups, $smartModule->getVar('mid'));
                $permissions[$gperm_name] = $userpermissions;
            }
        }
        //Return the permission array
        return isset($permissions[$gperm_name]) ? $permissions[$gperm_name] : array();
    }

    function storeAllPermissionsForId($id) {
        foreach ($this->handler->getPermissions() as $permission) {
            $this->saveItem_Permissions($_POST[$permission['perm_name']], $id, $permission['perm_name']);
        }
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
        $smartModule =& $this->handler->getModuleInfo();

        $result = true;
        $module_id = $smartModule->getVar('mid');
        $gperm_handler =& xoops_gethandler('groupperm');

        // First, if the permissions are already there, delete them
        $gperm_handler->deleteByModule($module_id, $perm_name, $itemid);
        //echo "itemid : $itemid - perm : $perm_name - modid : $module_id";
        //exit;
        // Save the new permissions

        if (count($groups) > 0) {
            foreach ($groups as $group_id) {
                $gperm_handler->addRight($perm_name, $itemid, $group_id, $module_id);
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
        global $xoopsModule;

        $smartModule =& smartsection_getModuleInfo();

        $result = true;
        $module_id = $smartModule->getVar('mid')   ;
        $gperm_handler =& xoops_gethandler('groupperm');


        $gperm_handler->deleteByModule($module_id, $gperm_name, $itemid);

        return $result;
    }

    /**
     * Checks if the user has access to a specific permission on a given object
     *
     * @param string $gperm_name name of the permission to test
     * @param int $gperm_itemid id of the object to check
     * @return boolean : TRUE if user has access, FALSE if not
     **/
    function accessGranted($gperm_name, $gperm_itemid) {
        global $xoopsUser;

        $gperm_groupid = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
        $smartModule =& $this->handler->getModuleInfo();
        $gperm_modid = $smartModule->getVar('mid')   ;

        //Get group permissions handler
        $gperm_handler =& xoops_gethandler('groupperm');

        return $gperm_handler->checkRight($gperm_name, $gperm_itemid, $gperm_groupid, $gperm_modid);
    }
}
?>
