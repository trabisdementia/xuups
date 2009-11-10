<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined("XOOPS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

class MyinviterWaiting extends XoopsObject
{
    /**
     * constructor
     */
    function MyinviterWaiting()
    {
        $this->initVar("wt_id", XOBJ_DTYPE_INT);
        $this->initVar("wt_userid", XOBJ_DTYPE_INT);
        $this->initVar('wt_email', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('wt_name', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('wt_date', XOBJ_DTYPE_INT, time());
        
    }

}

class MyinviterWaitingHandler extends XoopsPersistableObjectHandler
{

    function MyinviterWaitingHandler(&$db)
    {
        $this->__construct($db);
    }

    function __construct(&$db)
    {
        parent::__construct($db, 'myinviter_waiting', 'MyinviterWaiting', 'wt_id', 'wt_email');
    }

}
?>
