<?php

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