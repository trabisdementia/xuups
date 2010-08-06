<?php

/**
 * Contains the classes for managing clips
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>
 * @credits Many thanks to Mithrandir
 * @version $Id: permission.php,v 1.3 2005/06/02 13:33:37 malanciault Exp $
 * @link http://www.smartfactory.ca The SmartFactory
 * @package SmartMedia
 * @subpackage Permissions
 */

/**
 * Common things that need to be included everywhere in the module
 */
include_once XOOPS_ROOT_PATH.'/modules/smartmedia/include/common.php';

/**
 * SmartMedia Permission Handler class
 *
 * Class handling permissions throughout the module
 *
 * @package SmartMedia
 * @author marcan <marcan@smartfactory.ca>
 * @link http://www.smartfactory.ca The SmartFactory
 */
class SmartmediaPermissionHandler extends XoopsObjectHandler
{

    /*
     * Returns permissions for a certain type
     *
     * @param string $type "item" or "category"
     * @param int $id id of the item (clip, category, folder, etc...) to get permissions for
     *
     * @return array
     */
    function getGrantedGroups($type = "item", $id = null) {
        static $groups;

        if (!isset($groups[$type]) || ($id != null && !isset($groups[$type][$id]))) {
            $smartModule =& smartmedia_getModuleInfo();
            //Get group permissions handler
            $gperm_handler =& xoops_gethandler('groupperm');
            	
            switch ($type) {

                case "item":
                    $gperm_name = "item_read";
                    break;

                case "category":
                    $gperm_name = "category_read";
                    break;
            }
            	
            //Get groups allowed for an item id
            $allowedgroups =& $gperm_handler->getGroupIds($gperm_name, $id, $smartModule->getVar('mid'));
            $groups[$type] = $allowedgroups;
        }
        //Return the permission array
        return isset($groups[$type]) ? $groups[$type] : array();
    }

    /*
     * Returns permissions for a certain type
     *
     * @param string $type "global", "forum" or "topic" (should perhaps have "post" as well - but I don't know)
     * @param int $id id of the item (forum, topic or possibly post) to get permissions for
     *
     * @return array
     */
    function getGrantedItems($type = "item", $id = null) {
        global $xoopsUser;
        static $permissions;

        if (!isset($permissions[$type]) || ($id != null && !isset($permissions[$type][$id]))) {
            	
            $smartModule =& smartmedia_getModuleInfo();
            //Get group permissions handler
            $gperm_handler =& xoops_gethandler('groupperm');
            //Get user's groups
            $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
            	
            switch ($type) {

                case "item":
                    $gperm_name = "item_read";
                    break;

                case "category":
                    $gperm_name = "category_read";
                    break;
            }
            	
            //Get all allowed item ids in this module and for this user's groups
            $userpermissions =& $gperm_handler->getItemIds($gperm_name, $groups, $smartModule->getVar('mid'));
            $permissions[$type] = $userpermissions;
        }
        //Return the permission array
        return isset($permissions[$type]) ? $permissions[$type] : array();
    }

    /**
     * Saves permissions for the selected category
     *
     *  saveCategory_Permissions()
     *
     * @param array $groups : group with granted permission
     * @param int $categoryID : categoryID on which we are setting permissions for Categories and Forums
     * @param string $perm_name : name of the permission
     * @return bool : TRUE if the no errors occured
     **/

    function saveItem_Permissions($groups, $itemid, $perm_name)
    {
        $smartModule =& smartmedia_getModuleInfo();

        $result = true;
        $module_id = $smartModule->getVar('mid')   ;
        $gperm_handler =& xoops_gethandler('groupperm');

        // First, if the permissions are already there, delete them
        $gperm_handler->deleteByModule($module_id, $perm_name, $pageid);

        // Save the new permissions
        if (count($groups) > 0) {
            foreach ($groups as $group_id) {
                $gperm_handler->addRight($perm_name, $pageid, $group_id, $module_id);
            }
        }
        return $result;
    }

    /**
     * Delete all permission for a specific item
     *
     *  deletePermissions()
     *
     * @param int $itemid : id of the item for which to delete the permissions
     * @return bool : TRUE if the no errors occured
     **/

    function deletePermissions($itemid, $type='item')
    {
        global $xoopsModule;

        $smartModule =& smartmedia_getModuleInfo();

        $result = true;
        $module_id = $smartModule->getVar('mid')   ;
        $gperm_handler =& xoops_gethandler('groupperm');

        switch ($type) {
            	
            case "item":
                $gperm_name = "item_read";
                break;
                	
            case "category":
                $gperm_name = "category_read";
                break;
        }

        $gperm_handler->deleteByModule($module_id, $gperm_name, $itemid);

        return $result;
    }

}
?>
