<?php

/**
 * $Id: random_partner.php,v 1.1 2007/06/05 18:32:31 marcan Exp $
 * Module: SmartPartner
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

function b_random_partner_show($options)
{
    include_once (XOOPS_ROOT_PATH . "/modules/smartpartner/include/common.php");

    // Creating the partner handler object
    $partner_handler =& smartpartner_gethandler('partner');


    // Randomize
    $partnersObj =& $partner_handler->getPartners(0, 0, _SPARTNER_STATUS_ACTIVE);
    If (count($partnersObj) > 0) {
        $key_arr = array_keys($partnersObj);
        $key_rand = array_rand($key_arr, 1);
        $partnerObj = $partnersObj[$key_rand];
    }


    $block = array();
    If ($partnerObj) {

        $partner['id'] = $partnerObj->id();
        $partner['urllink'] = $partnerObj->getUrlLink('block');
        If (($partnerObj->image()) && (($options[1] == 1) || ($options[1] == 3))) {
            $partner['image'] = $partnerObj->getImageUrl();
        }
        If (($partnerObj->image()) && (($options[1] == 2) || ($options[1] == 3))) {
            $partner['title'] = $partnerObj->title();
        } else {
            $partner['title'] = '';
        }
        $smartConfig =& smartpartner_getModuleConfig();
        $image_info = smartpartner_imageResize($partnerObj->getImagePath(), $smartConfig['img_max_width'], $smartConfig['img_max_height']);
        $partner['img_attr'] = $image_info[3];
        $partner['extendedInfo'] = $partnerObj->extentedInfo();


        if ($options[0] == 1) {
            $block['fadeImage'] = 'style="filter:alpha(opacity=20);" onmouseover="nereidFade(this,100,30,5)" onmouseout="nereidFade(this,50,30,5)"';
        }


        $block['see_all'] = $options[2];
        $block['lang_see_all'] = _MB_SPARTNER_LANG_SEE_ALL;
        $block['smartpartner_url'] = SMARTPARTNER_URL;

    }
    return $block;
}

function b_random_partner_edit($options)
{
    $form = "<table border='0'>";
    /*$form .= "<tr><td>"._MB_SPARTNER_PARTNERS_PSPACE."</td><td>";
     $chk   = "";
     if ($options[0] == 0) {
         $chk = " checked='checked'";
     }
     $form .= "<input type='radio' name='options[0]' value='0'".$chk." />"._NO."";
     $chk   = "";
     if ($options[0] == 1) {
         $chk = " checked='checked'";
     }
     $form .= "<input type='radio' name='options[0]' value='1'".$chk." />"._YES."</td></tr>";*/
    $form .= "<tr><td>" . _MB_SPARTNER_FADE . "</td><td>";
    $chk = "";
    if ($options[0] == 0) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[1]' value='0'" . $chk . " />" . _NO . "";
    $chk = "";
    if ($options[0] == 1) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[1]' value='1'" . $chk . " />" . _YES . "</td></tr>";
    /*$form .= "<tr><td>"._MB_SPARTNER_BRAND."</td><td>";
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
     $form .= "<input type='text' name='options[3]' size='16' value='".$options[3]."' /></td></tr>";*/
    $form .= "<tr><td>" . _MB_SPARTNER_BSHOW . "</td><td>";
    $form .= "<select size='1' name='options[1]'>";
    $sel = "";
    if ($options[1] == 1) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='1' " . $sel . ">" . _MB_SPARTNER_IMAGES . "</option>";
    $sel = "";
    if ($options[1] == 2) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='2' " . $sel . ">" . _MB_SPARTNER_TEXT . "</option>";
    $sel = "";
    if ($options[1] == 3) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='3' " . $sel . ">" . _MB_SPARTNER_BOTH . "</option>";
    $form .= "</select></td></tr>";
    /*$form .= "<tr><td>"._MB_SPARTNER_BORDER."</td><td>";
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
     */
    $form .= "<tr><td>" . _MB_SPARTNER_SEE_ALL . "</td><td>";
    $chk = "";
    if ($options[2] == 0) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[2]' value='0'" . $chk . " />" . _NO . "";
    $chk = "";
    if ($options[7] == 1) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[2]' value='1'" . $chk . " />" . _YES . "</td></tr>";


    $form .= "</table>";
    return $form;
}

?>