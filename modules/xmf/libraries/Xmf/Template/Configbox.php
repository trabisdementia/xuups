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
 * @author          Grégory Mage (Aka Mage)
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Template_Configbox extends Xmf_Template_Abstract
{
    var $title;
    var $lines;

    public function __construct($title = '')
    {
        parent::__construct($this);
        $this->title = $title;
        //$this->setTemplate(XMF_ROOT_PATH . '/templates/xmf_adminmenu.html');
    }

    //******************************************************************************************************************
    // addConfigBoxLine
    //******************************************************************************************************************
    // $value: value
    // $type: type of config:   1- "default": Just a line with value.
    //                          2- "folder": check if this is an folder.
    //                          3- "chmod": check if this is the good chmod.
    //                                      For this type ("chmod"), the value is an array: array(path, chmod)
    //******************************************************************************************************************
    function addLine($value = '', $type = 'default')
    {
        $line = "";
        $path = XMF_IMAGES_URL . "/icons/16/";
        switch ($type)
        {
            default:
            case "default":
                $line .= "<span>" . $value . "</span>";
                break;

            case "folder":
                if (!is_dir($value)){
                    $line .= "<span style='color : red; font-weight : bold;'>";
                    $line .= "<img src='" . $path . "off.png' >";
                    $line .= sprintf(_AM_XMF_CONFIG_FOLDERKO, $value);
                    $line .= "</span>\n";
                }else{
                    $line .= "<span style='color : green;'>";
                    $line .= "<img src='" . $path . "on.png' >";
                    $line .= sprintf(_AM_XMF_CONFIG_FOLDEROK, $value);
                    $line .= "</span>\n";
                }
                break;

            case "chmod":
                if (is_dir($value[0])){
                    if (substr(decoct(fileperms($value[0])),2) != $value[1]) {
                        $line .= "<span style='color : red; font-weight : bold;'>";
                        $line .= "<img src='" . $path . "off.png' >";
                        $line .= sprintf(_AM_XMF_CONFIG_CHMOD, $value[0], $value[1], substr(decoct(fileperms($value[0])),2));
                        $line .= "</span>\n";
                    }else{
                        $line .= "<span style='color : green;'>";
                        $line .= "<img src='" . $path . "on.png' >";
                        $line .= sprintf(_AM_XMF_CONFIG_CHMOD, $value[0], $value[1], substr(decoct(fileperms($value[0])),2));
                        $line .= "</span>\n";
                    }
                }
                break;
        }
        $this->lines[] = $line;
        return true;
    }

    protected function render()
    {
        $ret = "";
        foreach ($this->lines as $line) {
            $ret .= $line;
            $ret .= "<br />";
        }
        $this->tpl->assign('dummy_content', $ret);
    }
}
