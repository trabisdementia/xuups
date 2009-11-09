<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined("XOOPS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

class MyinviterBlacklist extends XoopsObject
{
    /**
     * constructor
     */
    function Myinviterblacklist()
    {
        $this->initVar("bl_id", XOBJ_DTYPE_INT);
        $this->initVar('bl_email', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar("bl_date", XOBJ_DTYPE_INT, time());
    }

}

class MyinviterBlacklistHandler extends XoopsPersistableObjectHandler
{

    function MyinviterBlacklistHandler(&$db)
    {
        $this->__construct($db);
    }

    function __construct(&$db)
    {
        parent::__construct($db, 'myinviter_blacklist', 'MyinviterBlacklist', 'bl_id', 'bl_email');
    }

}
