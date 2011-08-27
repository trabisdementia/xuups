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
 * @version         $Id: Addto.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Template_Addto extends Xmf_Template_Abstract
{
    var $layout;
    var $method;

    function __construct()
    {
        parent::__construct($this);
        $this->setTemplate(XMF_ROOT_PATH . '/templates/xmf_addto.html');
        $this->layout = 0;
        $this->method = 1;
    }

    function setLayout($value)
    {
        $layout = intval($value);
        if ($layout < 0 || $layout > 3) {
            $layout = 0;
        }
        $this->layout = $layout;

    }

    function setMethod($value)
    {
        $method = intval($value);
        if ($method < 0 || $method > 1) {
            $method = 1;
        }
        $this->method = $method;
    }

    function render()
    {
        if (is_object($GLOBALS['xoTheme'])) {
            $GLOBALS['xoTheme']->addStylesheet(XMF_LIBRARIES_URL . '/addto/addto.css');
        }
        $this->tpl->assign('xmf_addto_method', $this->method);
        $this->tpl->assign('xmf_addto_layout', $this->layout);
        $this->tpl->assign('xmf_addto_url', XMF_LIBRARIES_URL . '/addto');
    }
}
