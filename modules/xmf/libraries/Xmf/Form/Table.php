<?php
defined('XMF_EXEC') or die('Xmf was not detected');
Xmf_Language::load('form', 'xmf');


/**
 * Form that will output formatted as a HTML table
 *
 * No styles and no JavaScript to check for required fields.
 *
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 *
 * @package     kernel
 * @subpackage  form
 */
class Xmf_Form_Table extends Xmf_Form
{

    /**
     * create HTML to output the form as a table
     *
     * @return	string
     */
    function render()
    {
        $ret = $this->getTitle()."\n<form name='".$this->getName()."' id='".$this->getName()."' action='".$this->getAction()."' method='".$this->getMethod()."'".$this->getExtra().">\n<table border='0' width='100%'>\n";
        $hidden = '';
        foreach ( $this->getElements() as $ele ) {
            if ( !$ele->isHidden() ) {
                $ret .= "<tr valign='top' align='left'><td>".$ele->getCaption();
                if ($ele_desc = $ele->getDescription()) {
                    $ret .= '<br /><br /><span style="font-weight: normal;">'.$ele_desc.'</span>';
                }
                $ret .= "</td><td>".$ele->render()."</td></tr>";
            } else {
                $hidden .= $ele->render()."\n";
            }
        }
        $ret .= "</table>\n$hidden</form>\n";
        return $ret;
    }
}