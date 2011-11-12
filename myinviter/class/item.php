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
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         myinviter
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id$
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

class MyinviterItem extends XoopsObject
{
    /**
     * constructor
     */
    function __construct()
    {
        $this->initVar("id", XOBJ_DTYPE_INT);
        $this->initVar("userid", XOBJ_DTYPE_INT);
        $this->initVar('email', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('date', XOBJ_DTYPE_INT, time());
        $this->initVar('status', XOBJ_DTYPE_INT, MYINVITER_STATUS_WAITING);
    }

}

class MyinviterItemHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db)
    {
        parent::__construct($db, 'myinviter_item', 'MyinviterItem', 'id', 'email');
    }

    function getWaitingObjects($id = null, $start = 0, $limit = 0)
    {
        $ret = $this->getItems($id, $start, $limit, MYINVITER_STATUS_WAITING);
        return $ret;
    }



    function getBlacklistObjects($id = null, $start = 0, $limit = 0)
    {
        $ret = $this->getItems($id, $start, $limit, MYINVITER_STATUS_BLACKLIST);
        return $ret;
    }

    function getErrorObjects($id = null, $start = 0, $limit = 0)
    {
        $ret = $this->getItems($id, $start, $limit, MYINVITER_STATUS_ERROR);
        return $ret;
    }

    function getNotsentObjects($id = null, $start = 0, $limit = 0)
    {
        $ret = $this->getItems($id, $start, $limit, MYINVITER_STATUS_NOTSENT);
        return $ret;
    }

    function getSentObjects($id = null, $start = 0, $limit = 0)
    {
        $ret = $this->getItems($id, $start, $limit, MYINVITER_STATUS_SENT);
        return $ret;
    }

    function getBlacklistList()
    {
        $criteria = new Criteria('status', MYINVITER_STATUS_BLACKLIST);
        $ret = $this->getList($criteria);
        return $ret;
    }

    function isEmailBlacklist($email)
    {
        $myts = MyTextSanitizer::getInstance();
        $criteria = new CriteriaCompo(new Criteria('status', MYINVITER_STATUS_BLACKLIST));
        $criteria->add(new Criteria('email', $myts->addSlashes($email)));
        $ret = $this->getCount($criteria);
        return $ret;
    }

    function insertWaiting($obj)
    {
        $obj->setVar('status', MYINVITER_STATUS_WAITING);
        $ret = $this->insert($obj);
        return $ret;
    }

    function insertBlacklist($obj)
    {
        $obj->setVar('status', MYINVITER_STATUS_BLACKLIST);
        $ret = $this->insert($obj);
        return $ret;
    }

    function insertError($obj)
    {
        $obj->setVar('status', MYINVITER_STATUS_ERROR);
        $ret = $this->insert($obj);
        return $ret;
    }

    function insertSent($obj)
    {
        $obj->setVar('status', MYINVITER_STATUS_SENT);
        $ret = $this->insert($obj);
        return $ret;
    }

    function insertNotSent($obj)
    {
        $obj->setVar('status', MYINVITER_STATUS_NOTSENT);
        $ret = $this->insert($obj);
        return $ret;
    }

    function deleteByIds($array = array())
    {
        $ret = 0;
        if (count($array) > 0) {
            $criteria = new Criteria('id', '(' . implode(',', $array) . ')', 'IN');
            $ret = parent::deleteAll($criteria, true);
        }
        return $ret;
    }

    function toArray($objs)
    {
        $ret = array();
        foreach ($objs as $obj) {
            $objArray = $obj->getValues();
            $objArray['date'] = formatTimestamp($objArray['date']);
            $ret[] = $objArray;
            unset($objArray);
        }
        return $ret;
    }

    function deleteAllByStatus($status = MYINVITER_STATUS_WAITING)
    {
        $ret = parent::deleteAll(new Criteria('status', $status));
        return $ret;
    }

    function getItems($id = null, $start = 0, $limit = 0, $status =  MYINVITER_STATUS_WAITING)
    {
        if ($id != null) {
            $id = new Criteria('id', $id);
        }
        $criteria = new CriteriaCompo($id);
        $criteria->add(new Criteria('status', $status));
        $criteria->setSort('date');
        $criteria->setOrder('DESC');
        $criteria->setLimit($limit);
        $criteria->setStart($start);
        $ret = $this->getObjects($criteria);
        return $ret;
    }

    function getCountByStatus($status =  MYINVITER_STATUS_WAITING)
    {
        $criteria = new Criteria('status', $status);
        $ret = $this->getCount($criteria);
        return $ret;
    }

    function moveErrorToWaiting()
    {
        $criteria = new Criteria('status', MYINVITER_STATUS_ERROR);
        $ret = $this->updateAll('status', MYINVITER_STATUS_WAITING, $criteria);
        return $ret;
    }

    function moveNotsentToWaiting()
    {
        $criteria = new Criteria('status', MYINVITER_STATUS_NOTSENT);
        $ret = $this->updateAll('status', MYINVITER_STATUS_WAITING, $criteria);
        return $ret;
    }

    function emailExists($email)
    {   $myts = MyTextSanitizer::getInstance();
        $criteria = new Criteria('email', $myts->addSlashes($email));
        $ret = $this->getCount($criteria);
        return $ret;
    }

}
?>