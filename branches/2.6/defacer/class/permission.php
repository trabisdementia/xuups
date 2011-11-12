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
 * @package         Defacer
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id$
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

class DefacerPermission extends XoopsObject
{
    /**
     * constructor
     */
    public function __construct()
    {
        $this->initVar("permission_id", XOBJ_DTYPE_INT, 0, true);
        $this->initVar('permission_groups', XOBJ_DTYPE_ARRAY, serialize(array(XOOPS_GROUP_ANONYMOUS, XOOPS_GROUP_USERS)));
    }
}

class DefacerPermissionHandler extends XoopsPersistableObjectHandler
{
    /**
     * @param null|XoopsDatabase $db
     */
    public function __construct(XoopsDatabase $db = null)
    {
        parent::__construct($db, 'defacer_permission', 'DefacerPermission', 'permission_id', 'permission_groups');
    }

    /**
     * @param DefacerPermission $obj
     * @param string $field_name
     * @param string $field_value
     * @return mixed
     */
    public function updateByField(DefacerPermission &$obj, $field_name, $field_value)
    {
        $obj->unsetNew();
        $obj->setVar($field_name, $field_value);
        return $this->insert($obj);
    }
}