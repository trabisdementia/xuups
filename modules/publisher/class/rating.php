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
 *  Publisher class
 *
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Class
 * @subpackage      Handlers
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: rating.php 0 2009-06-11 18:47:04Z trabis $
 */

if (!defined("XOOPS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

include_once dirname(dirname(__FILE__)) . '/include/common.php';

class PublisherRating extends XoopsObject
{
    /**
     * constructor
     */
    function PublisherRating()
    {
        $this->initVar("ratingid", XOBJ_DTYPE_INT, null, false);
        $this->initVar("itemid", XOBJ_DTYPE_INT, null, false);
        $this->initVar("uid", XOBJ_DTYPE_INT, null, false);
        $this->initVar("rate", XOBJ_DTYPE_INT, null, false);
        $this->initVar("ip", XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("date", XOBJ_DTYPE_INT, null, false);
    }

}

class PublisherRatingHandler extends XoopsPersistableObjectHandler
{
    function PublisherRatingHandler(&$db)
    {
        $this->__construct($db);
    }

    function __construct($db)
    {
        parent::__construct($db, 'publisher_rating', 'PublisherRating', 'ratingid', 'itemid');
    }
}
?>
