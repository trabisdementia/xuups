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
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Template_Adminnav extends Xmf_Template_Abstract
{
    var $adminmenu;
    var $title;
    var $link;
    var $icon;

    function __construct(XoopsModule $module)
    {
        parent::__construct($this);
        $this->module = $module;
        $module->loadAdminMenu();
        $this->adminmenu = $this->module->adminmenu;

        foreach ($this->adminmenu as $menu) {
            if (stripos($_SERVER['REQUEST_URI'], $menu['link'] ) !== false) {
                $this->title = $menu['title'];
                $this->icon = $menu['link'];
                $this->icon = $menu['icon'];
            }
        }
    }

    function render()
    {
        if (is_object($GLOBALS['xoTheme'])) {
            $GLOBALS['xoTheme']->addStylesheet(XMF_CSS_URL . '/admin.css');
        }
        $ret = "";
        $navigation = "";
        $path = XOOPS_URL . "/modules/" . $this->module->getVar('dirname') . "/";

        if ($this->icon) {
            $navigation .= $this->title . " | ";
            $ret = "<div class=\"CPbigTitle\" style=\"background-image: url(" . $path . $this->icon . "); background-repeat: no-repeat; background-position: left; padding-left: 50px;\">
    <strong>" . $this->title . "</strong></div><br />";
        } else if ($this->link) {
            $navigation .= "<a href = '../" . $this->link . "'>" . $this->title . "</a> | ";
        }

        if (substr(XOOPS_VERSION, 0, 9) < 'XOOPS 2.5') {
            $navigation .= "<a href = '../../system/admin.php?fct=preferences&op=showmod&mod=" . $this->module->getVar('mid') . "'>" . _MI_SYSTEM_ADMENU6 . "</a>";
            $ret = $navigation . "<br /><br />" . $ret;
        }

        $this->tpl->assign('dummy_content', $ret);
    }

}