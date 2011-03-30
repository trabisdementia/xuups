<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

class SubscribersUser extends XoopsObject
{
    /**
     * constructor
     */
    function SubscribersUser()
    {
        $this->initVar("user_id", XOBJ_DTYPE_INT, null, false);
        $this->initVar("user_email", XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("user_name", XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("user_country", XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("user_phone", XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("user_created", XOBJ_DTYPE_INT, null, false);
    }

    function toArray()
    {
        $ret = array();
        $vars = $this->getVars();
        foreach (array_keys($vars) as $i) {
            $ret[$i] = $this->getVar($i);
        }
        return $ret;
    }
}

class SubscribersUserHandler extends XoopsPersistableObjectHandler
{
    function SubscribersUserHandler(&$db)
    {
        $this->__construct($db);
    }

    function __construct(&$db)
    {
        parent::__construct($db, 'subscribers_user', 'SubscribersUser', 'user_id', 'user_email');
    }
}
?>
