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

class Xmf_Form_Element_Checkbox_Check extends Xmf_Form_Element_Checkbox
{
    /**
     * prepare HTML for output
     *
     * @return	string  $ret  the constructed input form element string
     */
    function render()
    {
        $ret = "";
        if (count($this->getOptions()) > 1 && substr($this->getName(), -2, 2) != "[]") {
            $newname = $this->getName()."[]";
            $this->setName($newname);
        }
        foreach ($this->getOptions() as $value => $name) {
            $ret .= "<input type='checkbox' name='".$this->getName()."' value='".$value."'";
            if (count($this->getValue()) > 0 && in_array($value, $this->getValue())) {
                $ret .= " checked='checked'";
            }
            $ret .= $this->getExtra()." />".$name."<br/>";
        }
        return $ret;
    }


    /**
     * Creates validation javascript
     * @return	string    $js   the constructed javascript
     */
    function renderValidationJS()
    {
        $js = "";
        $js .= "var hasSelections = false;";
        //sometimes, there is an implicit '[]', sometimes not
        $eltname = $this->getName();
        $eltmsg = empty($eltcaption) ? sprintf( _FORM_ENTER, $eltname ) : sprintf( _FORM_ENTER, $eltcaption );
        $eltmsg = str_replace('"', '\"', stripslashes( $eltmsg ) );
        if (strpos($eltname, '[') === false) {
            $js .= "for(var i = 0; i < myform['{$eltname}[]'].length; i++){
                if (myform['{$eltname}[]'][i].checked) {
                hasSelections = true;
                }

                }
                if (hasSelections == false) {
                window.alert(\"{$eltmsg}\"); myform['{$eltname}[]'][0].focus(); return false; }\n";
        } else {
            $js .= "for(var i = 0; i < myform['{$eltname}'].length; i++){
                if (myform['{$eltname}'][i].checked) {
                hasSelections = true;
                }

                }
                if (hasSelections == false) {
                window.alert(\"{$eltmsg}\"); myform['{$eltname}'][0].focus(); return false; }\n";
        }
        return $js;
    }

}