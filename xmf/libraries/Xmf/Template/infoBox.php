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
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Template_Infobox extends Xmf_Template_Abstract
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
    // addILine
    //******************************************************************************************************************
    // $text:
    // $type: type of config:   1- "default": Just a line with value.
    //                          2- "information": check if this is an folder.
    //                          3- "chmod": check if this is the good chmod.
    //                                      For this type ("chmod"), the value is an array: array(path, chmod)
    //******************************************************************************************************************
    public function addLine($text = '', $type = 'raw', $value = '')
    {
        $line = "";
        switch ($type)
        {
            case "changelog":
                $line .= "<div class=\"txtchangelog\">" . $text . "</div>";
                break;
            case "span":
                $color = !empty($value) ? $value : 'inherit';
                $line .= sprintf($text, "<span style='color : " . $color . "; font-weight : bold;'>" . $value . "</span><br />");
                break;
            default:
            case "raw":
                $line .= $text;
                break;
        }
        $this->lines[] = $line;
        return $this; //Allow chain lines
    }

    protected function render()
    {
        $ret = "<fieldset>";
        $ret .= "<legend class=\"label\">" .  $this->title . "</legend>\n";
        foreach ($this->lines as $line) {
            $ret .= $line;
        }
        $ret .= "</fieldset>\n";
        $ret .= "<br/>\n";
        $this->tpl->assign('dummy_content', $ret);
    }
}