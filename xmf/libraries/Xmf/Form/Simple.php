<?php
defined('XMF_EXEC') or die('Xmf was not detected');
Xmf_Language::load('form', 'xmf');

/**
 * Form that will output as a simple HTML form with minimum formatting
 *
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 *
 * @package     kernel
 * @subpackage  form
 */
class Xmf_Form_Simple extends Xmf_Form
{
    /**
     * create HTML to output the form with minimal formatting
     *
     * @return	string
     */
    function render()
    {
        $ret = $this->getTitle()."\n<form name='".$this->getName()."' id='".$this->getName()."' action='".$this->getAction()."' method='".$this->getMethod()."'".$this->getExtra().">\n";
        foreach ($this->getElements() as $ele) {
            if (!$ele->isHidden()) {
                $ret .= "<strong>".$ele->getCaption()."</strong><br />".$ele->render()."<br />\n";
            } else {
                $ret .= $ele->render()."\n";
            }
        }
        $ret .= "</form>\n";
        return $ret;
    }
}