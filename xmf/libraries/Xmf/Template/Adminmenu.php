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
        $this->adminmenu = $module->loadAdminMenu();

        foreach ($this->module->adminmenu as $i => $menu) {
            if (stripos($_SERVER['REQUEST_URI'], $menu['link'] ) !== false) {
                $this->currentoption = $i;
                $this->breadcrumb = $menu['title'];
            }
        }
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
    {   /*
        $adminmenu = array();
        include XOOPS_ROOT_PATH . '/modules/' . $this->module->getVar('dirname') . '/admin/menu.php';
        return $adminmenu; */
        return $this->module->adminmenu;
    }

    function getHeadermenu()
    {
        Xmf_Language::load('menu', 'xmf');

        $headermenu = array();
        $modPath = XOOPS_ROOT_PATH . '/modules/' . $this->module->getVar('dirname');
        $modUrl = XOOPS_URL . '/modules/' . $this->module->getVar('dirname');

        $i = -1;

        if ($this->module->getInfo('hasMain')) {
            $i++;
            $headermenu[$i]['title'] = _MENU_XMF_GOTOMOD;
            $headermenu[$i]['link'] = $modUrl;
        }

        if (is_array($this->module->getInfo('config'))) {
            $i++;
            $headermenu[$i]['title'] = _MENU_XMF_PREFERENCES;
            $headermenu[$i]['link'] = XOOPS_URL . '/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;&amp;mod=' . $this->module->getVar('mid');
        }

        $i++;
        $headermenu[$i]['title'] = _MENU_XMF_BLOCKS;
        $headermenu[$i]['link'] = XOOPS_URL . '/modules/system/system/admin.php?fct=blocksadmin&amp;selvis=-1&amp;selmod=-2&amp;selgrp=-1&amp;selgen=' . $this->module->getVar('mid');

        if ($this->module->getInfo('hasComments')) {
            $i++;
            $headermenu[$i]['title'] = _MENU_XMF_COMMENTS;
            $headermenu[$i]['link'] = XOOPS_URL . '/modules/system/admin.php?fct=comments&amp;module=' . $this->module->getVar('mid');
        }

        $i++;
        $headermenu[$i]['title'] = _MENU_XMF_UPDATE;
        $headermenu[$i]['link'] = XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $this->module->getVar('dirname');

        if (file_exists($modPath . '/admin/import.php')) {
            $i++;
            $headermenu[$i]['title'] = _MENU_XMF_IMPORT;
            $headermenu[$i]['link'] = $modUrl . '/admin/import.php';
        }

        if (file_exists($modPath . '/admin/clone.php')) {
            $i++;
            $headermenu[$i]['title'] = _MENU_XMF_CLONE;
            $headermenu[$i]['link'] = $modUrl . '/admin/clone.php';
        }

        if (file_exists($modPath . '/admin/about.php')) {
            $i++;
            $headermenu[$i]['title'] = _MENU_XMF_ABOUT;
            $headermenu[$i]['link'] = $modUrl . '/admin/about.php';
        }

        if ($this->module->getInfo('help')) {
            $i++;
            $headermenu[$i]['title'] = _MENU_XMF_HELP;
            $headermenu[$i]['link'] = XOOPS_URL . '/modules/system/help.php?mid=' . $this->module->getVar('mid') . '&amp;' . $this->module->getInfo('help');
        }

        return $headermenu;
    }

    function render()
    {

        Xmf_Language::load('modinfo', $this->module->getVar('dirname'));
        Xmf_Language::load('admin', $this->module->getVar('dirname'));

        $this->tpl->assign(array(
            'modulename' => $this->module->getVar('name'),
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