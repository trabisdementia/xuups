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
 * Factory for object handlers
 *
 * @author Taiwen Jiang <phppp@users.sourceforge.net>
 * @copyright copyright &copy; The XOOPS project
 * @package kernel
 **/
class Xmf_Model_Factory
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
    /*static private*/var $handlers = array();

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
    function loadHandler($ohander, $name, $args = null)
    {
        //$instance = XoopsModelFactory::getInstance();
        static $handlers;
        if (!isset($handlers[$name])) {
            if (@include_once dirname(__FILE__) . "/{$name}.php") {
                $className = "Xmf_Model_" . ucfirst($name);
                $handler = new $className();
            } elseif (xoops_load("model", "framework")) {
                $handler = XoopsModel::loadHandler($name);
            }

            if (!is_object($handler)) {
                return null;
            }
            $handlers[$name] = $handler;
            //xoops_result('loaded handler ' . $name);
        }

        $handlers[$name]->setHandler($ohander);
        if (!empty($args) && is_array($args) && is_a($handlers[$name], 'Xmf_Model_Abstract')) {
            $handlers[$name]->setVars($args);
        }

        return $handlers[$name];
    }
}