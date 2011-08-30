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
 * @package         Xmf
 * @since           0.1
 * @author          trabis <lusopoemas@gmail.com>
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
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
class Xmf_Model_Abstract
{

    /**
     * holds referenced to handler object
     *
     * @var     object
     * @param   object  $ohandler   reference to {@link XoopsPersistableObjectHandler}
     * @access protected
     */
    var $handler;

    /**
     * constructor
     *
     * normally, this is called from child classes only
     * @access protected
     */
    function __construct($args = null, $handler = null)
    {
        $this->setHandler($handler);
        $this->setVars($args);
    }

    function setHandler($handler)
    {
        if (is_object($handler) && is_a($handler, 'Xmf_Object_Handler')) {
            $this->handler =& $handler;
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

}