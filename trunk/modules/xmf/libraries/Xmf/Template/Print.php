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

class Xmf_Template_Print extends Xmf_Template_Abstract
{
    public $_title;
    public $_description;
    public $_content;
    public $_pagetitle = false;
    public $_width = 680;

    function __construct()
    {
        parent::__construct($this);
        $this->setTemplate(XMF_ROOT_PATH . '/templates/xmf_print.html');
    }

    function setTitle($value)
    {
        $this->_title = $value;
    }

    function setContent($value)
    {
        $this->_content = $value;
    }

    function setDescription($value)
    {
        $this->_description = $value;
    }

    function setPagetitle($text)
    {
        $this->_pagetitle = $text;
    }

    function setWidth($width)
    {
        $this->_width = $width;
    }

    function render()
    {
        $this->tpl->assign('xmf_print_pageTitle', $this->_pagetitle ? $this->_pagetitle : $this->_title);
        $this->tpl->assign('xmf_print_title', $this->_title);
        $this->tpl->assign('xmf_print_description', $this->_description);
        $this->tpl->assign('xmf_print_content', $this->_content);
        $this->tpl->assign('xmf_print_width', $this->_width);

        $current_urls = xmf_getCurrentUrls();
        $current_url = $current_urls['full'];

        $this->tpl->assign('xmf_print_currenturl', $current_url);
        $this->tpl->assign('xmf_print_url', $this->url);
    }

}