<?php

/**
 * $Id: smartprinterfriendly.php 159 2007-12-17 16:44:05Z malanciault $
 * Module: SmartObject
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

/**
 * Class to manage a printer friendly page
 * @author The SmartFactory <www.smartfactory.ca>
 */

class SmartPrinterFriendly
{
    var $_title;
    var $_dsc;
    var $_content;
    var $_tpl;
    var $_pageTitle = false;
    var $_width = 680;

    function SmartPrinterFriendly($content, $title=false, $dsc=false)
    {
        $this->_title = $title;
        $this->_dsc = $dsc;
        $this->_content = $content;
    }

    function render()
    {
        /**
         * @todo move the output to a template
         * @todo make the output XHTML compliant
         */

        include_once XOOPS_ROOT_PATH . '/class/template.php';

        $this->_tpl = new XoopsTpl();

        $this->_tpl->assign('smartobject_print_pageTitle', $this->_pageTitle ? $this->_pageTitle : $this->_title);
        $this->_tpl->assign('smartobject_print_title', $this->_title);
        $this->_tpl->assign('smartobject_print_dsc', $this->_dsc);
        $this->_tpl->assign('smartobject_print_content', $this->_content);
        $this->_tpl->assign('smartobject_print_width', $this->_width);

        $current_urls = smart_getCurrentUrls();
        $current_url = $current_urls['full'];

        $this->_tpl->assign('smartobject_print_currenturl', $current_url);
        $this->_tpl->assign('smartobject_print_url', $this->url);

        $this->_tpl->display( 'db:smartobject_print.html' );
    }

    function setPageTitle($text) {
        $this->_pageTitle = $text;
    }

    function setWidth($width) {
        $this->_width = $width;
    }

}

?>