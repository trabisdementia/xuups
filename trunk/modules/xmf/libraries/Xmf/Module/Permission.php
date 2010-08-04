<?php
defined('XMF_EXEC') or die('Xmf was not detected');

include_once XOOPS_ROOT_PATH . '/kernel/groupperm.php';

class Xmf_Module_Permission extends XoopsGroupPermHandler
{
    var $mid;

    function __construct(XoopsModule $module)
    {
        $this->mid = $module->getVar('mid');
        $this->db =& XoopsDatabaseFactory::getDatabaseConnection();
    }

    /*
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
            //Get groups allowed for an item id
            $allowedgroups = $this->getGroupIds($gperm_name, $id, $this->mid);
            $groups[$gperm_name][$id] = $allowedgroups;
        }
        //Return the permission array
        return isset($groups[$gperm_name][$id]) ? $groups[$gperm_name][$id] : array();
    }

    function getGrantedGroupsForIds($item_ids_array, $gperm_name = false)
    {

        static $groups;

        if ($gperm_name){
            if (isset($groups[$gperm_name])) {
                return $groups[$gperm_name];
            }
        } else {
            // if !$gperm_name then we will fetch all permissions in the module so we don't need them again
            return $groups;
        }

        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('gperm_modid', $this->mid));

        if ($gperm_name) {
            $criteria->add(new Criteria('gperm_name', $gperm_name));
        }

        $objs = $this->getObjects($criteria);

        foreach ($objs as $obj) {
            $groups[$obj->getVar('gperm_name')][$obj->getVar('gperm_itemid')][] = $obj->getVar('gperm_groupid');
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
    function getGrantedItems($gperm_name, $id = null)
    {
        global $xoopsUser;
        static $permissions;

        if (!isset($permissions[$gperm_name]) || ($id != null && !isset($permissions[$gperm_name][$id]))) {
            //Get user's groups
            $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);

            //Get all allowed item ids in this module and for this user's groups
            $userpermissions =& $this->getItemIds($gperm_name, $groups, $this->mid);
            $permissions[$gperm_name] = $userpermissions;

        }
        //Return the permission array
        return isset($permissions[$gperm_name]) ? $permissions[$gperm_name] : array();
    }

    /**
     * Update permissions for a specific item
     *
     * updatePermissions()
     *
     * @param array $groups : group with granted permission
     * @param integer $itemid : itemid on which we are setting permissions
     * @param string $perm_name : name of the permission
     * @return boolean : TRUE if the no errors occured
     **/

    function updatePermissions($groups, $itemid, $perm_name)
    {
        // First, if the permissions are already there, delete them
        if (!$this->deleteByModule($this->mid, $perm_name, $itemid)) {
            return false;
        }

        // Save the new permissions
        if (count($groups) > 0) {
            foreach ($groups as $group_id) {
                if (!$this->addRight($perm_name, $itemid, $group_id, $this->mid)) {
                    return false;
                }
            }
        }
        return true;
    }
    /*
    function storeAllPermissionsForId($id)
    {
        foreach ($this->handler->getPermissions() as $permission) {
            $this->updatePermissions($_POST[$permission['perm_name']], $id, $permission['perm_name']);
        }
    }
    */
    /**
     * Delete all permissions for a specific item and/or name
     *
     *  deletePermissions()
     *
     * @param integer $itemid : id of the item for which to delete the permissions
     * @return boolean : TRUE if the no errors occured
     **/
    function deletePermissions($itemid = null, $gperm_name = null)
    {
        return $this->deleteByModule($this->mid, $gperm_name, $itemid);
    }

    /**
     * Checks if the user has access to a specific permission on a given object
     *
     * @param string $gperm_name name of the permission to test
     * @param int $gperm_itemid id of the object to check
     * @return boolean : TRUE if user has access, FALSE if not
     **/
    function accessGranted($gperm_name, $gperm_itemid)
    {
        $gperm_groupid = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
        return $this->checkRight($gperm_name, $gperm_itemid, $gperm_groupid, $this->mid);
    }
}