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
 * @version         $Id$
 */
defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

include_once dirname(dirname(__FILE__)) . '/include/common.php';

class PublisherPermissionHandler extends XoopsObjectHandler
{
    /**
     * @var PublisherPublisher
     * @access public
     */
    public $publisher = null;

    public function __construct()
    {
        $this->publisher = PublisherPublisher::getInstance();
    }

    /**
     * Returns permissions for a certain type
     *
     * @param string $gperm_name "global", "forum" or "topic" (should perhaps have "post" as well - but I don't know)
     * @param int    $id         id of the item (forum, topic or possibly post) to get permissions for
     *
     * @return array
     */
    public function getGrantedGroupsById($gperm_name, $id)
    {
        $groups = $this->getGrantedGroups($gperm_name);
        return isset($groups[$id]) ? $groups[$id] : array();
    }

    /**
     * @param string $gperm_name
     *
     * @return array
     */
    public function getGrantedGroups($gperm_name = '')
    {
        static $groups;
        static $publisher_all_permissions_fetched;
        if ($gperm_name) {
            if (isset($groups[$gperm_name])) {
                return $groups[$gperm_name];
            } elseif (true === $publisher_all_permissions_fetched) {
                //trying to get non existing permission
                return array();
            }
        } else if (true === $publisher_all_permissions_fetched) {
            return $groups;
        }
        $publisher_all_permissions_fetched = true;
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('gperm_modid', $this->publisher->getModule()->getVar('mid')));
        //Instead of calling groupperm handler and get objects, we will save some memory and do it our way
        $db = XoopsDatabaseFactory::getDatabaseConnection();
        $limit = $start = 0;
        $sql = 'SELECT * FROM ' . $db->prefix('group_permission');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $db->query($sql, $limit, $start);
        while ($myrow = $db->fetchArray($result)) {
            $groups[$myrow['gperm_name']][$myrow['gperm_itemid']][] = $myrow['gperm_groupid'];
        }
        //Return the permission array
        return $this->getGrantedGroups($gperm_name);
    }

    /**
     * Returns permissions for a certain type
     *
     * @param string $gperm_name "global", "forum" or "topic" (should perhaps have "post" as well - but I don't know)
     * @param int    $id         id of the item (forum, topic or possibly post) to get permissions for
     *
     * @return array
     */
    public function getGrantedItems($gperm_name, $id = null)
    {
        global $xoopsUser;
        static $permissions;
        if (!isset($permissions[$gperm_name]) || ($id != null && !isset($permissions[$gperm_name][$id]))) {
            //Instead of calling groupperm handler and get objects, we will save some memory and do it our way
            $criteria = new CriteriaCompo(new Criteria('gperm_name', $gperm_name));
            $criteria->add(new Criteria('gperm_modid', $this->publisher->getModule()->getVar('mid')));
            //Get user's groups
            $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
            $criteria2 = new CriteriaCompo();
            foreach ($groups as $gid) {
                $criteria2->add(new Criteria('gperm_groupid', $gid), 'OR');
            }
            $criteria->add($criteria2);
            $db = XoopsDatabaseFactory::getDatabaseConnection();
            $sql = 'SELECT * FROM ' . $db->prefix('group_permission');
            $sql .= ' ' . $criteria->renderWhere();
            $result = $db->query($sql, 0, 0);
            $permissions[$gperm_name] = array();
            while ($myrow = $db->fetchArray($result)) {
                $permissions[$gperm_name][] = $myrow['gperm_itemid'];
            }
            $permissions[$gperm_name] = array_unique($permissions[$gperm_name]);
        }
        //Return the permission array
        return isset($permissions[$gperm_name]) ? $permissions[$gperm_name] : array();
    }

    /**
     * @param string   $gperm_name
     * @param int|null $id
     *
     * @return bool
     */
    public function isGranted($gperm_name, $id = null)
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
     *  saveCategory_Permissions()
     *
     * @param array   $groups     : group with granted permission
     * @param integer $itemid     : itemid on which we are setting permissions for Categories and Forums
     * @param string  $perm_name  : name of the permission
     *
     * @return boolean : TRUE if the no errors occured
     */
    public function saveItem_Permissions($groups, $itemid, $perm_name)
    {
        $result = true;
        $module_id = $this->publisher->getModule()->getVar('mid');
        $gperm_handler = xoops_gethandler('groupperm');
        // First, if the permissions are already there, delete them
        $gperm_handler->deleteByModule($module_id, $perm_name, $itemid);
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
     *  deletePermissions()
     *
     * @param integer $itemid : id of the item for which to delete the permissions
     * @param string  $gperm_name
     *
     * @return boolean : TRUE if the no errors occured
     */
    public function deletePermissions($itemid, $gperm_name)
    {
        $result = true;
        $gperm_handler = xoops_gethandler('groupperm');
        $gperm_handler->deleteByModule($this->publisher->getModule()->getVar('mid'), $gperm_name, $itemid);
        return $result;
    }
}