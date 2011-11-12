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
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id$
 */

class PublisherHandler
{
    /**
     * Wrapper, allows good code inspection
     *
     * @return PublisherCategoryHandler
     */
    public function category()
    {
        return Xmf_Module_Helper::getInstance(PUBLISHER_DIRNAME)->getHandler('category');
    }

    /**
     * Wrapper, allows good code inspection
     *
     * @return Xmf_Module_Helper_Permission
     */
    public function permission()
    {
        return Xmf_Module_Helper::getInstance(PUBLISHER_DIRNAME)->getHelper('permission');
    }

    /**
     * Wrapper, allows good code inspection
     *
     * @return PublisherItemHandler
     */
    public function item()
    {
        return Xmf_Module_Helper::getInstance(PUBLISHER_DIRNAME)->getHandler('item');
    }

    /**
     * Wrapper, allows good code inspection
     *
     * @return PublisherFileHandler
     */
    public function file()
    {
        return Xmf_Module_Helper::getInstance(PUBLISHER_DIRNAME)->getHandler('file');
    }

    /**
     * Wrapper, allows good code inspection
     *
     * @return XoopsMemberHandler
     */
    public function member()
    {
        return xoops_getHandler('member');
    }

    /**
     * Wrapper, allows good code inspection
     *
     * @return XoopsUserHandler
     */
    public function user()
    {
        return xoops_getHandler('user');
    }

    /**
     * Wrapper, allows good code inspection
     *
     * @return XoopsGrouppermHandler
     */
    public function groupperm()
    {
        return xoops_getHandler('groupperm');
    }

    /**
     * Wrapper, allows good code inspection
     *
     * @return XoopsNotificationHandler
     */
    public function notification()
    {
        return xoops_getHandler('notification');
    }

    /**
     * Wrapper, allows good code inspection
     *
     * @return XoopsImageHandler
     */
    public function image()
    {
        return xoops_getHandler('image');
    }

}