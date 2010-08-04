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
 * @author          Kazumi Ono <onokazu@xoops.org>
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

/**#@-*/

//include_once "xoopspluginloader.php";

/**
 * Base class for all objects in the Xoops kernel (and beyond)
 *
 * @author Kazumi Ono (AKA onokazu)
 * @author Taiwen Jiang <phppp@users.sourceforge.net>
 * @copyright copyright &copy; The XOOPS project
 * @package kernel
 **/
class Xmf_Object extends Xmf_Abstract
{
    /*var $helper;*/
    var $_helpers = array(
        /*'caption' => null,*/
        );


    /**
     * holds all variables(properties) of an object
     *
     * @var array
     * @access protected
     **/
    var $vars = array();

    /**
     * variables cleaned for store in DB
     *
     * @var array
     * @access protected
     */
    var $cleanVars = array();

    /**
     * is it a newly created object?
     *
     * @var bool
     * @access private
     */
    var $_isNew = false;

    /**
     * has any of the values been modified?
     *
     * @var bool
     * @access private
     */
    var $_isDirty = false;

    /**
     * errors
     *
     * @var array
     * @access private
     */
    var $_errors = array();

    /**
     * additional filters registered dynamically by a child class object
     *
     * @access private
     */
    var $_filters = array();

    /**
     * constructor
     *
     * normally, this is called from child classes only
     * @access public
     */
    function __construct()
    {
    }

    /**
     * Load predefined helper
     *
     * @access  protected
     *
     * @param   string  $name   helper name
     * @param   mixed   $args   args
     * @return  object of helper {@link XoopsObjectAbstract}
     */
    function loadHelper($name, $args = null)
    {
        static $helpers;
        if (!isset($helpers[$name])) {
            $helpers[$name] = Xmf_Object_Helper_Factory::loadHelper($this, $name, $args);
            $this->_helpers[$name] = null;
        /*} else {*/
            $helpers[$name]->setObject($this);
            $helpers[$name]->setVars($args);
            $helpers[$name]->init();
        }

        return $helpers[$name];
    }

    /**
     * Magic method for overloading of delegation
     *
     * To be enabled in XOOPS 3.0 with PHP 5
     * @access protected
     *
     * @param   string  $name    method name
     * @param   array   $args    arguments
     * @return  mixed
     */
    function __call($name, $args)
    {
        if ($this->isVar($name)) {
            $arg = isset($args[0]) ? $args[0] : null;
            return $this->getVar($name, $arg);
        }

        foreach (array_keys($this->_helpers) as $_helper) {
            $helper = $this->loadHelper($_helper);
            if (is_callable(array($helper, $name))) {
                return call_user_func_array(array($helper, $name), $args);
            }
        }

        exit($name . ' not found in the following helpers: '. implode(',' , array_keys($this->_helpers)));
        return null;
    }


    /**#@+
     * used for new/clone objects
     *
     * @access public
     */
    function setNew()
    {
        $this->_isNew = true;
    }
    function unsetNew()
    {
        $this->_isNew = false;
    }
    function isNew()
    {
        return $this->_isNew;
    }
    /**#@-*/

    /**#@+
     * mark modified objects as dirty
     *
     * used for modified objects only
     * @access public
     */
    function setDirty()
    {
        $this->_isDirty = true;
    }
    function unsetDirty()
    {
        $this->_isDirty = false;
    }
    function isDirty()
    {
        return $this->_isDirty;
    }
    /**#@-*/

    /**
     * initialize variables for the object
     *
     * @access public
     * @param string $key
     * @param string $data_type  set to one of Dtypes available (set to 'other' if no data type ckecking nor text sanitizing is required)
     * @param mixed
     * @param bool $required  require html form input?
     * @param int $maxlength  for textbox type only
     * @param string $option  does this data have any select options?
     */
    function initVar($key, $data_type, $value = null, $required = false, $maxlength = null, $options = '')
    {
        $this->vars[$key] = array('value' => $value, 'required' => $required, 'data_type' => $data_type, 'maxlength' => $maxlength, 'changed' => false, 'options' => $options);
    }

    /**
     * assign a value to a variable
     *
     * @access public
     * @param string $key name of the variable to assign
     * @param mixed $value value to assign
     */
    function assignVar($key, $value)
    {
        if (isset($key) && isset($this->vars[$key])) {
            $this->vars[$key]['value'] =& $value;
        }
    }

    function assignVarKey($var, $key, $value)
    {
        if (isset($var) && isset($key) && isset($this->vars[$var])) {
            $this->vars[$var][$key] =& $value;
        }
    }

    function getVarKey($var, $key, $default = null)
    {
        if (isset($var) && isset($key) && isset($this->vars[$var][$key])) {
            return $this->vars[$var][$key];
        }
        return $default;
    }

    /**
     * assign values to multiple variables in a batch
     *
     * @access private
     * @param array $var_array associative array of values to assign
     */
    function assignVars($var_arr)
    {
        foreach ($var_arr as $key => $value) {
            $this->assignVar($key, $value);
        }
    }

    /**
     * assign a value to a variable
     *
     * @access public
     * @param string $key name of the variable to assign
     * @param mixed $value value to assign
     * @param bool $not_gpc
     */
    function setVar($key, $value, $not_gpc = false)
    {
        if (!empty($key) && isset($value) && isset($this->vars[$key])) {
            $this->vars[$key]['value'] =& $value;
            $this->vars[$key]['not_gpc'] = $not_gpc;
            $this->vars[$key]['changed'] = true;
            $this->setDirty();
        }
    }

    /**
     * assign values to multiple variables in a batch
     *
     * @access private
     * @param array $var_arr associative array of values to assign
     * @param bool $not_gpc
     */
    function setVars($var_arr, $not_gpc = false)
    {
        foreach ($var_arr as $key => $value) {
            $this->setVar($key, $value, $not_gpc);
        }
    }

    /**
     * unset variable(s) for the object
     *
     * @access   public
     * @param    mixed $var
     */
    function destoryVars($var)
    {
        if (empty($var)) return true;
        $var = !is_array($var) ? array($var) : $var;
        foreach ($var as $key) {
            if (!isset($this->vars[$key])) continue;
            $this->vars[$key]["changed"] = null;
        }
        return true;
    }

    /**
     * Assign values to multiple variables in a batch
     *
     * Meant for a CGI contenxt:
     * - prefixed CGI args are considered save
     * - avoids polluting of namespace with CGI args
     *
     * @access private
     * @param array $var_arr associative array of values to assign
     * @param string $pref prefix (only keys starting with the prefix will be set)
     */
    function setFormVars($var_arr = null, $pref = 'xo_', $not_gpc = false)
    {
        $len = strlen($pref);
        foreach ($var_arr as $key => $value) {
            if ($pref == substr($key,0,$len)) {
                $this->setVar(substr($key,$len), $value, $not_gpc);
            }
        }
    }

    /**
     * returns all variables for the object
     *
     * @access public
     * @return array associative array of key->value pairs
     */
    function &getVars()
    {
        return $this->vars;
    }

    /**
     * Returns the values of the specified variables
     *
     * @param mixed $keys An array containing the names of the keys to retrieve, or null to get all of them
     * @param string $format Format to use (see getVar)
     * @param int $maxDepth Maximum level of recursion to use if some vars are objects themselves
     * @return array associative array of key->value pairs
     */
    function getValues($keys = null, $format = 's', $maxDepth = 1)
    {
        if (!isset($keys)) {
            $keys = array_keys($this->vars);
        }
        $vars = array();
        foreach ($keys as $key) {
            if (isset($this->vars[$key])) {
                if (is_object($this->vars[$key]) && is_a( $this->vars[$key], 'XoopsObject')) {
                    if ($maxDepth) {
                        $vars[$key] = $this->vars[$key]->getValues(null, $format, $maxDepth - 1);
                    }
                } else {
                    $vars[$key] = $this->getVar($key, $format);
                }
            }
        }
        return $vars;
    }

    /**
    * returns a specific variable for the object in a proper format
    *
    * @access public
    * @param string $key key of the object's variable to be returned
    * @param string $format format to use for the output
    * @return mixed formatted value of the variable
    */
    function getVar($key, $format = 's')
    {
        $ret = null;
        if (!isset($this->vars[$key])) return $ret;
        $ret = $this->vars[$key]['value'];
        $ret = Xmf_Object_Dtype::getVar($this, $key, $format, $ret);
        return $ret;
    }

    function isVar($key)
    {
        return isset($this->vars[$key]);
    }

    /**
     * clean values of all variables of the object for storage.
     * also add slashes whereever needed
     *
     * @return bool true if successful
     * @access public
     */
    function cleanVars()
    {
        $existing_errors = $this->getErrors();
        $this->_errors = array();
        foreach ($this->vars as $k => $v) {
            $cleanv = $v['value'];
            if (!$v['changed']) {
            } else {
                $cleanv = Xmf_Object_Dtype::cleanVars($this, $k, $v, $cleanv);
            }
            $this->cleanVars[$k] =& $cleanv;
            unset($cleanv);
        }
        if (count($this->_errors) > 0) {
            $this->_errors = array_merge($existing_errors, $this->_errors);
            return false;
        }
        $this->_errors = array_merge($existing_errors, $this->_errors);
        $this->unsetDirty();
        return true;
    }

    /**
     * dynamically register additional filter for the object
     *
     * @param string $filtername name of the filter
     * @access public
     */
    function registerFilter($filtername)
    {
        $this->_filters[] = $filtername;
    }

    /**
     * load all additional filters that have been registered to the object
     *
     * @access private
     */
    function _loadFilters()
    {
        static $loaded;
        if (isset($loaded)) return;
        $loaded = 1;

        $path = empty($this->plugin_path) ? dirname(__FILE__) . '/filters' : $this->plugin_path;
        @include_once $path . '/filter.php';
        foreach ($this->_filters as $f) {
            @include_once $path . '/' . strtolower($f) . 'php';
        }
    }

    /**
     * load all local filters for the object
     *
     * Filter distribution:
     * In each module folder there is a folder "filter" containing filter files with,
     * filename: [name_of_target_class][.][function/action_name][.php];
     * function name: [dirname][_][name_of_target_class][_][function/action_name];
     * parameter: the target object
     *
     * @param   string     $method    function or action name
     * @access  public
     */
    function loadFilters($method)
    {
        $this->_loadFilters();

        xoops_load("cache");
        $class = get_class($this);
        if (!$modules_active = XoopsCache::read("system_modules_active")) {
            $module_handler =& xoops_gethandler('module');
            $modules_obj = $module_handler->getObjects(new Criteria('isactive', 1));
            $modules_active = array();
            foreach (array_keys($modules_obj) as $key) {
                $modules_active[] = $modules_obj[$key]->getVar("dirname");
            }
            unset($modules_obj);
            XoopsCache::write("system_modules_active", $modules_active);
        }
        foreach ($modules_active as $dirname) {
            if (!@include_once XOOPS_ROOT_PATH . "/modules/{$dirname}/filter/{$class}.{$method}.php") continue;
            if (function_exists("{$class}_{$method}")) {
                call_user_func_array("{$dirname}_{$class}_{$method}", array(&$this));
            }
        }
    }

    /**
     * create a clone(copy) of the current object
     *
     * @access public
     * @return object clone
     */
    function &xoopsClone()
    {
        $class =  get_class($this);
        $clone =  null;
        $clone =  new $class();
        foreach ($this->vars as $k => $v) {
            $clone->assignVar($k, $v['value']);
        }
        // need this to notify the handler class that this is a newly created object
        $clone->setNew();
        return $clone;
    }

    /**
     * add an error
     *
     * @param string $value error to add
     * @access public
     */
    function setErrors($err_str)
    {
        if (is_array($err_str)) {
            $this->_errors = array_merge($this->_errors, $err_str);
        } else {
            $this->_errors[] = trim($err_str);
        }
    }

    /**
     * return the errors for this object as an array
     *
     * @return array an array of errors
     * @access public
     */
    function getErrors()
    {
        return $this->_errors;
    }

    /**
     * return the errors for this object as html
     *
     * @return string html listing the errors
     * @access public
     */
    function getHtmlErrors()
    {
        $ret = '<h4>Errors</h4>';
        if (!empty($this->_errors)) {
            foreach ($this->_errors as $error) {
                $ret .= $error.'<br />';
            }
        } else {
            $ret .= 'None<br />';
        }
        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * Deprecated, use getValues() directly
     * @return array
     */
    function toArray()
    {
        return $this->getValues();
    }
}