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
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

/**
 * Xoops object data model handlers
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         kernel
 * @subpackage      model
 * @since           2.3.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: xoopsmodel.php 1778 2008-05-25 10:57:41Z phppp $
 */

/**
 * Factory for object handlers
 *
 * @author Taiwen Jiang <phppp@users.sourceforge.net>
 * @copyright copyright &copy; The XOOPS project
 * @package kernel
 **/
class Xmf_Object_Helper_Factory
{
    /**
     * @access private
     */
    //static $instance;

    /**
     * holds reference to object handlers {@link XoopsPersistableObjectHandler}
     *
     * var array of objects
     * @access private
     */
    /*static private*/var $helpers = array();

    function __construct()
    {
    }

    /**
     * Get singleton instance
     *
     * @access  public
     */
    function getInstance()
    {
        static $instance;
        if (!isset($instance)) {
            $class = __CLASS__;
            $instance = new $class();
        }
        return $instance;
    }

    /**
     * Load object handler
     *
     * @access  public
     *
     * @param   object  $ohandler   reference to {@link XoopsPersistableObjectHandler}
     * @param   string  $name   handler name
     * @param   mixed   $args   args
     * @return  object of handler
     */
    function loadHelper($object, $name, $args = null)
    {
        //$instance = XoopsModelFactory::getInstance();
        static $helpers;
        if (!isset($helpers[$name])) {
            $helper = null;
            if (@include_once dirname(__FILE__) . "/{$name}.php") {
                $className = "Xmf_Object_Helper_" . ucfirst($name);
                $helper = new $className();
            }

            if (!is_object($helper)) {
                return null;
            }
            $helpers[$name] = $helper;
            //xoops_result('loaded handler ' . $name);
        }

        $helpers[$name]->setObject($object);
        if (!empty($args) && is_array($args) && is_a($helpers[$name], 'Xmf_Object_Helper_Abstract')) {
            $helpers[$name]->setVars($args);
        }

        return $helpers[$name];
    }
}