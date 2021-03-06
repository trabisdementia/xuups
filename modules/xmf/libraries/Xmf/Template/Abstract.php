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
include_once XOOPS_ROOT_PATH . '/class/template.php';

abstract class Xmf_Template_Abstract
{
    var $tpl;
    var $_template;
    var $_handler;

    function __construct(Xmf_Template_Abstract $handler)
    {
        $this->_handler = $handler;
        $this->tpl = new XoopsTpl();
        $this->_template = "db:system_dummy.html";
    }

    protected function setTemplate($template = '')
    {
        $this->_template = $template;
    }

    abstract protected function render();

    public function fetch()
    {
        $this->_handler->render();
        return $this->tpl->fetch($this->_template);
    }

    public function display()
    {
        echo $this->_handler->fetch();
    }
}