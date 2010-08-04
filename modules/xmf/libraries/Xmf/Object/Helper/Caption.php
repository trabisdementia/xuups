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

class Xmf_Object_Helper_Caption extends Xmf_Object_Helper_Abstract
{
    var $itemName;
    var $moduleName;

    /**
     * assign a value to a variable
     *
     * @access public
     * @param string $key name of the variable to assign
     * @param mixed $value value to assign
     */
    function assignVarCaption($key, $title = '', $description = '')
    {
        $this->object->assignVarKey($key, 'title', $title);
        $this->object->assignVarKey($key, 'desc', $description);
    }


    function init()
    {
        $this->moduleName = $this->object->moduleName;
        $this->itemName = $this->object->itemName;
        Xmf_Language::load('object', $this->moduleName);
        foreach ($this->object->vars as $k => $v) {
            $this->_initCaptions($k);
        }
        return $this->object;
    }

    function _initCaptions($key, $title = '', $description = '')
    {
        if (empty($title)) {
            $dyn_title = strtoupper('_OBJ_' . $this->moduleName . '_' . $this->itemName . '_' . $key);
            if (defined($dyn_title)) {
                $title = constant($dyn_title);
            } else {
                $title = $key;
            }
        }
        if (empty($description)) {
            $dyn_description = strtoupper('_OBJ_' . $this->moduleName . '_' . $this->itemName . '_' . $key . '_DSC');
            if (defined($dyn_description)) {
                $description = constant($dyn_description);
            }
        }

        $this->assignVarCaption($key, $title, $description);
    }

    /**
     * Retreive the object admin side link, displayijng a SingleView page
     *
     * @param bool $onlyUrl wether or not to return a simple URL or a full <a> link
     * @return string user side link to the object
     */
    function getAdminViewItemLink($onlyUrl=false)
    {
        $controller = new SmartObjectController($this->handler);
        return $controller->getAdminViewItemLink($this, $onlyUrl);
    }

    /**
     * Retreive the object user side link
     *
     * @param bool $onlyUrl wether or not to return a simple URL or a full <a> link
     * @return string user side link to the object
     */
    function getItemLink($onlyUrl=false)
    {
        $controller = new SmartObjectController($this->handler);
        return $controller->getItemLink($this, $onlyUrl);
    }

    function getEditItemLink($onlyUrl=false, $withimage=true, $userSide=false)
    {
        $controller = new SmartObjectController($this->handler);
        return $controller->getEditItemLink($this, $onlyUrl, $withimage, $userSide);
    }

    function getDeleteItemLink($onlyUrl=false, $withimage=false, $userSide=false)
    {
        $controller = new SmartObjectController($this->handler);
        return $controller->getDeleteItemLink($this, $onlyUrl, $withimage, $userSide);
    }

    function getPrintAndMailLink()
    {
        $controller = new SmartObjectController($this->handler);
        return $controller->getPrintAndMailLink($this);
    }
}