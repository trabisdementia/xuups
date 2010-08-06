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
 * @copyright       The XUUPS Project http://www.xuups.com
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Myinviter
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: waiting.php 0 2009-11-14 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

class MyinviterWaiting extends XoopsObject
{
    /**
     * constructor
     */
    function __construct()
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
    function __construct(&$db)
    {
        parent::__construct($db, 'myinviter_waiting', 'MyinviterWaiting', 'wt_id', 'wt_email');
    }

}
?>