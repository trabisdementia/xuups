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
 * @package         log
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id$
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

class LogItem extends XoopsObject
{
    /**
     * constructor
     */
    function __construct()
    {
        $this->initVar("id", XOBJ_DTYPE_INT);
        $this->initVar('dirname', XOBJ_DTYPE_TXTBOX, 'system');
        $this->initVar('category', XOBJ_DTYPE_TXTBOX, 'notset');
        $this->initVar('content', XOBJ_DTYPE_TXTAREA, '');
        $this->initVar("uid", XOBJ_DTYPE_INT, 0);
        $this->initVar('time', XOBJ_DTYPE_INT, time());
        //For display
        $this->initVar("dohtml", XOBJ_DTYPE_INT, 1);
        $this->initVar("dosmiley", XOBJ_DTYPE_INT, 1);
        $this->initVar("doimage", XOBJ_DTYPE_INT, 1);
        $this->initVar("dobr", XOBJ_DTYPE_INT, 1);
        $this->initVar("doxcode", XOBJ_DTYPE_INT, 1);
    }

}

class LogItemHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db)
    {
        parent::__construct($db, 'log_item', 'LogItem', 'id', 'dirname');
    }

    function addItem($dirname = 'system', $category = 'notset', $content = '')
    {
        $obj = $this->create();
        $obj->setVar('dirname', $dirname);
        $obj->setVar('category', $category);
        $obj->setVar('content', $content);
        $obj->setVar('uid', is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar('uid') : 0);
        $obj->setVar('time', time());
        $ret = $this->insert($obj);
        return $ret;
    }

    function render($objs)
    {
        xoops_load('XoopsUserUtility');
        $ts = Xmf_Sanitizer::getInstance();
        $ret = array();
        foreach ($objs as $obj) {
            $objArray = $obj->getValues();
            $objArray['time'] = formatTimestamp($objArray['time']);
            $objArray['ulink'] = XoopsUserUtility::getUnameFromId($objArray['uid'], false, true);
            $ret[] = $objArray;
        }
        return $ret;
    }

    function deleteAllByDirname($dirname = 'system')
    {
        $ret = parent::deleteAll(new Criteria('dirname', $dirname));
        return $ret;
    }

}