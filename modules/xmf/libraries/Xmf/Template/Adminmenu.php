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
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Template_Adminmenu extends Xmf_Template_Abstract
{
    var $currentoption;
    var $breadcrumb;
    var $submenus;
    var $currentsub;
    var $adminmenu;
    var $headermenu;

    function __construct(XoopsModule $module)
    {
        parent::__construct($this);
        $this->setTemplate(XMF_ROOT_PATH . '/templates/xmf_adminmenu.html');

        $this->module =& $module;
        $this->currentoption = -1;
        $this->breadcrumb = '';
        $this->submenus = false;
        $this->currentsub = -1;
        $this->headermenu = array();
        $this->adminmenu = array();
    }

    //if string is passed the key will be 0, use this for default behavior
    function set0($value = 0)
    {
        $this->currentoption = $value;
        return $this;
    }

    function setCurrentoption($value = 0)
    {
        $this->currentoption = $value;
        return $this;
    }

    function setBreadcrumb($value = '')
    {
        $this->breadcrumb = $value;
        return $this;
    }

    function setCurrentsub($value = 0)
    {
        $this->currentsub = $value;
        return $this;
    }

    function setSubmenus($value = false)
    {
        $this->submenus = $value;
        return $this;
    }

    function getAdminmenu()
    {
        $adminmenu = array();
        include XOOPS_ROOT_PATH . '/modules/' . $this->module->getVar('dirname') . '/admin/menu.php';
        return $adminmenu;
    }

    function getHeadermenu()
    {
        Xmf_Language::load('menu', 'xmf');

        $headermenu = array();
        $modurl = XOOPS_ROOT_PATH . '/modules/' . $this->module->getVar('dirname');

        $i = -1;

        if ($this->module->getInfo('hasMain')) {
            $i++;
            $headermenu[$i]['title'] = _MENU_XMF_GOTOMOD;
            $headermenu[$i]['link'] = XOOPS_URL . '/modules/' . $this->module->getVar('dirname');
        }

        if (is_array($this->module->getInfo('config'))) {
            $i++;
            $headermenu[$i]['title'] = _PREFERENCES;
            $headermenu[$i]['link'] = XOOPS_URL . '/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;&amp;mod=' . $this->module->getVar('mid');
        }

        if ($this->module->getInfo('hasComments')) {
            $i++;
            $headermenu[$i]['title'] = _MENU_XMF_COMMENTS;
            $headermenu[$i]['link'] = XOOPS_URL . '/modules/system/admin.php?fct=comments&amp;module=' . $this->module->getVar('mid');
        }

        $i++;
        $headermenu[$i]['title'] = _MENU_XMF_UPDATE;
        $headermenu[$i]['link'] = XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $this->module->getVar('dirname');

        if (file_exists(XOOPS_ROOT_PATH . '/modules/' . $this->module->getVar('dirname') . '/admin/about.php')) {
            $i++;
            $headermenu[$i]['title'] = _MENU_XMF_ABOUT;
            $headermenu[$i]['link'] = XOOPS_URL . '/modules/' . $this->module->getVar('dirname') . '/admin/about.php';
        }

        return $headermenu;
    }

    function render()
    {

        Xmf_Language::load('modinfo', $this->module->getVar('dirname'));
        Xmf_Language::load('admin', $this->module->getVar('dirname'));

        $this->tpl->assign(array(
            'headermenu' => $this->getHeadermenu(),
            'adminmenu' => $this->getAdminmenu(),
            'current' => $this->currentoption,
            'breadcrumb' => $this->breadcrumb,
            'headermenucount' => count($this->headermenu),
            'submenus' => $this->submenus,
            'currentsub' => $this->currentsub,
            'submenuscount' => count($this->submenus)
            ));
    }

}