<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

class SubscribersWaiting extends XoopsObject
{

    /**
     * constructor
     */
    function SubscribersWaiting()
    {
        $this->initVar("wt_id", XOBJ_DTYPE_INT, null, false);
        $this->initVar("wt_subject", XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("wt_body", XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("wt_toname", XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("wt_toemail", XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("wt_created", XOBJ_DTYPE_INT, null, false);
        $this->initVar("wt_priority", XOBJ_DTYPE_INT, null, false);

        $this->initVar("dohtml", XOBJ_DTYPE_INT, 1);
        $this->initVar("doxcode", XOBJ_DTYPE_INT, 1);
        $this->initVar("dosmiley", XOBJ_DTYPE_INT, 1);
        $this->initVar("doimage", XOBJ_DTYPE_INT, 1);
        $this->initVar("dobr", XOBJ_DTYPE_INT, 1);

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

class SubscribersWaitingHandler extends XoopsPersistableObjectHandler
{

    function SubscribersWaitingHandler(&$db)
    {
        $this->__construct($db);
    }

    function __construct(&$db)
    {
        parent::__construct($db, 'subscribers_waiting', 'SubscribersWaiting', 'wt_id', 'wt_subject');
    }

}
?>
