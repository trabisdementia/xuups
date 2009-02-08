<?php

//we don´t want the admin to have privileges that are not set in module permissions so we have to overide the class


if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}

include_once XOOPS_ROOT_PATH . '/kernel/groupperm.php';

class PublisherGroupPermHandler extends XoopsGroupPermHandler
{

    /**
     * Check permission
     *
     * @param	string    $gperm_name       Name of permission
     * @param	int       $gperm_itemid     ID of an item
     * @param	int/array $gperm_groupid    A group ID or an array of group IDs
     * @param	int       $gperm_modid      ID of a module
     *
     * @return	bool    TRUE if permission is enabled
     */
    function checkRight($gperm_name, $gperm_itemid, $gperm_groupid, $gperm_modid = 1)
    {
        $criteria = new CriteriaCompo(new Criteria('gperm_modid', $gperm_modid));
        $criteria->add(new Criteria('gperm_name', $gperm_name));
        $gperm_itemid = intval($gperm_itemid);
        if ($gperm_itemid > 0) {
            $criteria->add(new Criteria('gperm_itemid', $gperm_itemid));
        }
        if (is_array($gperm_groupid)) {
            $criteria2 = new CriteriaCompo();
            foreach ($gperm_groupid as $gid) {
                $criteria2->add(new Criteria('gperm_groupid', $gid), 'OR');
            }
            $criteria->add($criteria2);
        } else {
            $criteria->add(new Criteria('gperm_groupid', $gperm_groupid));
        }
        if ($this->getCount($criteria) > 0) {
            return true;
        }
        return false;
    }
}
?>
