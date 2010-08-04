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

class Xmf_Template_Breadcrumb extends Xmf_Template_Abstract
{
    private $_items;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct($this);
        $this->setTemplate(XMF_ROOT_PATH . '/templates/xmf_breadcrumb.html');
    }

    public function setItems($items)
    {
        $this->_items = $items;
    }

    public function render()
    {
        $tpl->assign('xmf_breadcrumb_items', $this->_items);
    }
}