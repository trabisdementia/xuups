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
 * @package         Xmf
 * @since           0.1
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

/**
 * abstract class object handler
 *
 * @author Taiwen Jiang <phppp@users.sourceforge.net>
 * @copyright copyright &copy; The XOOPS project
 * @package kernel
 **/
class Xmf_Object_Helper_Abstract
{

    /**
     * holds referenced to handler object
     *
     * @var     object
     * @param   object  $ohandler   reference to {@link XoopsPersistableObjectHandler}
     * @access protected
     */
    var $object;

    /**
     * constructor
     *
     * normally, this is called from child classes only
     * @access protected
     */
    function __construct($args = null, $object = null)
    {
        $this->setObject($object);
        $this->setVars($args);
    }

    function setObject($object)
    {
        if (is_object($object) && is_a($object, 'Xmf_Object')) {
            $this->object =& $object;
            return true;
        }
        return false;
    }

    function setVars($args)
    {
        if (!empty($args) && is_array($args)) {
            foreach ($args as $key => $value) {
                $this->$key = $value;
            }
        }
        return true;
    }

    function init()
    {
    }

}