<?php

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

class XtestePost extends Xmf_Object
{
    var $itemName = 'post';
    var $moduleName = 'xteste';
    var $primaryKey = 'id';

    function __construct()
    {
        parent::__construct();
        $this->initVar("id","int",null,false);
        $this->initVar("category_id","int", 0);
        $this->initVar("title","textbox", '');
        $this->initVar("body","textarea", '');
        $this->initVar("created","int", 0);
        $this->initVar("published","int", 0);
        $this->initVar("uid","int", 0);
    }

}

class XtestePostHandler extends Xmf_Object_Handler
{
    function __construct(&$db)
    {
        parent::__construct($db, 'xteste_post', 'XtestePost', 'id', 'title');
    }

    function getOwner_uids()
    {
        $member_handler = xoops_getHandler('member');

        $sql = 'SELECT DISTINCT uid AS uid FROM ' . $this->table;
        $result = $this->db->query($sql);
        while ($uid = $this->db->fetchArray($result)) {

            $owner_uidsArray[] = $uid['uid'];
        }

        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('uid', '(' . implode(', ', $owner_uidsArray) . ')', 'IN'));

        $usersArray = $member_handler->getUserList($criteria);
        $ret = array();
        $ret['default'] = _XUUPS_ANY;
        foreach($usersArray as $k=>$v) {
            $ret[$k] = $v;
        }
        return $ret;
    }

}