<?php

/**
 * $Id: partners_list.php,v 1.6 2005/04/21 15:09:31 malanciault Exp $
 * Module: SmartPartner
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

function b_partners_list_show($options)
{
    // This must contain the name of the folder in which reside SmartPartner
    if( !defined("SMARTPARTNER_DIRNAME") ){
        define("SMARTPARTNER_DIRNAME", 'smartpartner');
    }
    include_once(XOOPS_ROOT_PATH."/modules/" . SMARTPARTNER_DIRNAME . "/include/common.php");


    // Creating the partner handler object
    $partner_handler =& smartpartner_gethandler('partner');

    if ($options[2]) {
        // Randomize
        $partnersObj =& $partner_handler->getPartners(0, 0, _SPARTNER_STATUS_ACTIVE);
        If (count($partnersObj) > 1) {
            $key_arr = array_keys($partnersObj);
            $key_rand = array_rand($key_arr,count($key_arr));
            for ($i=0 ; (($i<count ($partnersObj)) && ($i<$options[3])) ; $i++) {
                $newObjs[$i]=$partnersObj[$key_rand[$i]];
            }

            $partnersObj = $newObjs;
        }
    } else {

        $partnersObj =& $partner_handler->getPartners($options[3], 0, _SPARTNER_STATUS_ACTIVE, $options[5], $options[6]);
        If ((count($partnersObj) > 1) && ($options[2] == 1)) {
            $key_arr = array_keys($partnersObj);
            $key_rand = array_rand($key_arr,count($key_arr));
            for ($i=0 ; $i<count ($partnersObj) ; $i++) {
                $newObjs[$i]=$partnersObj[$key_rand[$i]];
            }

            $partnersObj = $newObjs;
        }
    }
    $block = array();
    If ($partnersObj) {
        for ( $i = 0; $i < count($partnersObj); $i++ ) {
            $partner['id'] = $partnersObj[$i]->id();
            $partner['urllink'] = $partnersObj[$i]->getUrlLink('block');
            If (($partnersObj[$i]->image()) && (($options[4] == 1) || ($options[4] == 3))) {
                $partner['image'] = $partnersObj[$i]->getImageUrl();
            }
            If (($partnersObj[$i]->image()) && (($options[4] == 2) || ($options[4] == 3))) {
                $partner['title'] = $partnersObj[$i]->title();
            } else {
                $partner['title'] = '';
            }
            $smartConfig =& smartpartner_getModuleConfig();
            $image_info = smartpartner_imageResize($partnersObj[$i]->getImagePath(), $smartConfig['img_max_width'], $smartConfig['img_max_height']);
            $partner['img_attr'] = $image_info[3];
            $partner['extendedInfo'] = $partnersObj[$i]->extentedInfo();
            $block['partners'][] = $partner;
        }
        if ($options[0] == 1) {
            $block['insertBr'] = true;
        }
        if( $options[1] == 1 ){
            $block['fadeImage'] = 'style="filter:alpha(opacity=20);" onmouseover="nereidFade(this,100,30,5)" onmouseout="nereidFade(this,50,30,5)"';
        }


        $block['see_all'] = $options[7];
        $block['lang_see_all'] = _MB_SPARTNER_LANG_SEE_ALL;
        $block['smartpartner_url'] = SMARTPARTNER_URL;

    }
    return $block;
}

function b_partners_list_edit($options)
{
    $form  = "<table border='0'>";
    $form .= "<tr><td>"._MB_SPARTNER_PARTNERS_PSPACE."</td><td>";
    $chk   = "";
    if ($options[0] == 0) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[0]' value='0'".$chk." />"._NO."";
    $chk   = "";
    if ($options[0] == 1) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[0]' value='1'".$chk." />"._YES."</td></tr>";
    $form .= "<tr><td>"._MB_SPARTNER_FADE."</td><td>";
    $chk   = "";
    if ( $options[1] == 0 ) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[1]' value='0'".$chk." />"._NO."";
    $chk   = "";
    if ( $options[1] == 1 ) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[1]' value='1'".$chk." />"._YES."</td></tr>";
    $form .= "<tr><td>"._MB_SPARTNER_BRAND."</td><td>";
    $chk   = "";
    if ( $options[2] == 0 ) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[2]' value='0'".$chk." />"._NO."";
    $chk   = "";
    if ($options[2] == 1) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[2]' value='1'".$chk." />"._YES."</td></tr>";
    $form .= "<tr><td>"._MB_SPARTNER_BLIMIT."</td><td>";
    $form .= "<input type='text' name='options[3]' size='16' value='".$options[3]."' /></td></tr>";
    $form .= "<tr><td>"._MB_SPARTNER_BSHOW."</td><td>";
    $form .= "<select size='1' name='options[4]'>";
    $sel = "";
    if ( $options[4] == 1 ) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='1' ".$sel.">"._MB_SPARTNER_IMAGES."</option>";
    $sel = "";
    if ( $options[4] == 2 ) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='2' ".$sel.">"._MB_SPARTNER_TEXT."</option>";
    $sel = "";
    if ( $options[4] == 3 ) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='3' ".$sel.">"._MB_SPARTNER_BOTH."</option>";
    $form .= "</select></td></tr>";
    $form .= "<tr><td>"._MB_SPARTNER_BORDER."</td><td>";
    $form .= "<select size='1' name='options[5]'>";
    $sel = "";
    if ( $options[5] == "id" ) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='id' ".$sel.">"._MB_SPARTNER_ID."</option>";
    $sel = "";
    if ( $options[5] == "hits" ) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='hits' ".$sel.">"._MB_SPARTNER_HITS."</option>";
    $sel = "";
    if ( $options[5] == "title" ) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='title' ".$sel.">"._MB_SPARTNER_TITLE."</option>";
    if ( $options[5] == "weight" ) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='weight' ".$sel.">"._MB_SPARTNER_WEIGHT."</option>";
    $form .= "</select> ";
    $form .= "<select size='1' name='options[6]'>";
    $sel = "";
    if ( $options[6] == "ASC" ) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='ASC' ".$sel.">"._MB_SPARTNER_ASC."</option>";
    $sel = "";
    if ( $options[6] == "DESC" ) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='DESC' ".$sel.">"._MB_SPARTNER_DESC."</option>";
    $form .= "</select></td></tr>";

    $form .= "<tr><td>"._MB_SPARTNER_SEE_ALL."</td><td>";
    $chk   = "";
    if ($options[7] == 0) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[7]' value='0'".$chk." />"._NO."";
    $chk   = "";
    if ($options[7] == 1) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[7]' value='1'".$chk." />"._YES."</td></tr>";


    $form .= "</table>";
    return $form;
}
?>