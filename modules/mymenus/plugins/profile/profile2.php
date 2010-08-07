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
 * @package         Mymenus
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: profile2.php 0 2010-07-21 18:47:04Z trabis $
 */

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

class ProfileMymenusPluginItem extends MymenusPluginItem
{
    var $friends_handler;

    function __construct()
    {
        $this->friends_handler =& xoops_getModuleHandler('friends', 'profile', true);
    }

    function eventHasAccess()
    {
        if ($this->friends_handler === false) return;

        $registry =& MymenusRegistry::getInstance();
        $menu   = $registry->getEntry('menu');

        $hooks = array_intersect($menu['hooks'], get_class_methods(__CLASS__));

        foreach ($hooks as $method) {
            if (!$this->$method()) {
                $registry->unlockEntry('has_access');
                $registry->setEntry('has_access', 'no');
                $registry->lockEntry('has_access');
            }
        }
    }

    function eventAccessFilter()
    {
        if ($this->friends_handler === false) return;

        $this->loadLanguage('profile');
        $registry =& MymenusRegistry::getInstance();
        $access_filter = $registry->getEntry('access_filter');

        $access_filter['is_friend'] = array('name'    => _PL_MYMENUS_PROFILE_ISFRIEND,
                                            'method'  => 'isFriend');

        $access_filter['is_not_friend'] = array('name'   =>  _PL_MYMENUS_PROFILE_ISNOTFRIEND,
                                                'method' => 'isNotFriend');

        $registry->setEntry('access_filter', $access_filter);
    }

    function isFriend()
    {
        static $count = false;

        if ($count === false) {
            $registry =& MymenusRegistry::getInstance();
            $handler =& xoops_getModuleHandler('friends', 'profile', true);

            $criteria1 = new CriteriaCompo();
            $criteria1->add(new Criteria('self_uid', $registry->getEntry('get_uid')));
            $criteria1->add(new Criteria('friend_uid', $registry->getEntry('user_uid')));

            $criteria2 = new CriteriaCompo();
            $criteria2->add(new Criteria('self_uid', $registry->getEntry('user_uid')));
            $criteria2->add(new Criteria('friend_uid', $registry->getEntry('get_uid')));

            $criteria = new CriteriaCompo();
            $criteria->add($criteria1);
            $criteria->add($criteria2, 'OR');

            $count = $handler->getCount($criteria);
            unset($criteria, $criteria1, $criteria2);
        }

        return ($count > 0) ? true : false;
    }

    function isNotFriend()
    {
        return !$this->isFriend();
    }
}

?>