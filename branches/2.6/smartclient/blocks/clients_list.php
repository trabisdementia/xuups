<?php

/**
 * $Id: clients_list.php,v 1.3 2005/04/23 13:20:10 malanciault Exp $
 * Module: SmartClient
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

function b_clients_list_show($options)
{
    // This must contain the name of the folder in which reside SmartClient
    if( !defined("SMARTCLIENT_DIRNAME") ){
        define("SMARTCLIENT_DIRNAME", 'smartclient');
    }
    include_once(XOOPS_ROOT_PATH."/modules/" . SMARTCLIENT_DIRNAME . "/include/common.php");


    // Creating the client handler object
    $client_handler =& smartclient_gethandler('client');

    if ($options[2]) {
        // Randomize
        $clientsObj =& $client_handler->getClients(0, 0, _SCLIENT_STATUS_ACTIVE);
        If (count($clientsObj) > 1) {
            $key_arr = array_keys($clientsObj);
            $key_rand = array_rand($key_arr,count($key_arr));
            for ($i=0 ; (($i<count ($clientsObj)) && ($i<$options[3])) ; $i++) {
                $newObjs[$i]=$clientsObj[$key_rand[$i]];
            }

            $clientsObj = $newObjs;
        }
    } else {

        $clientsObj =& $client_handler->getClients($options[3], 0, _SCLIENT_STATUS_ACTIVE, $options[5], $options[6]);
        If ((count($clientsObj) > 1) && ($options[2] == 1)) {
            $key_arr = array_keys($clientsObj);
            $key_rand = array_rand($key_arr,count($key_arr));
            for ($i=0 ; $i<count ($clientsObj) ; $i++) {
                $newObjs[$i]=$clientsObj[$key_rand[$i]];
            }

            $clientsObj = $newObjs;
        }
    }
    $block = array();
    If ($clientsObj) {
        for ( $i = 0; $i < count($clientsObj); $i++ ) {
            $client['id'] = $clientsObj[$i]->id();
            $client['urllink'] = $clientsObj[$i]->getUrlLink('block');
            If (($clientsObj[$i]->image()) && (($options[4] == 1) || ($options[4] == 3))) {
                $client['image'] = $clientsObj[$i]->getImageUrl();
            }
            If (($clientsObj[$i]->image()) && (($options[4] == 2) || ($options[4] == 3))) {
                $client['title'] = $clientsObj[$i]->title();
            } else {
                $client['title'] = '';
            }
            $smartConfig =& smartclient_getModuleConfig();
            $image_info = smartclient_imageResize($clientsObj[$i]->getImagePath(), $smartConfig['img_max_width'], $smartConfig['img_max_height']);
            $client['img_attr'] = $image_info[3];
            $client['extendedInfo'] = $clientsObj[$i]->extentedInfo();
            $block['clients'][] = $client;
        }
        if ($options[0] == 1) {
            $block['insertBr'] = true;
        }
        if( $options[1] == 1 ){
            $block['fadeImage'] = 'style="filter:alpha(opacity=20);" onmouseover="nereidFade(this,100,30,5)" onmouseout="nereidFade(this,50,30,5)"';
        }


        $block['see_all'] = $options[7];
        $block['lang_see_all'] = _MB_SCLIENT_LANG_SEE_ALL;
        $block['smartclient_url'] = SMARTCLIENT_URL;


    }
    return $block;
}

function b_clients_list_edit($options)
{
    $form  = "<table border='0'>";
    $form .= "<tr><td>"._MB_SCLIENT_CLIENTS_PSPACE."</td><td>";
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
    $form .= "<tr><td>"._MB_SCLIENT_FADE."</td><td>";
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
    $form .= "<tr><td>"._MB_SCLIENT_BRAND."</td><td>";
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
    $form .= "<tr><td>"._MB_SCLIENT_BLIMIT."</td><td>";
    $form .= "<input type='text' name='options[3]' size='16' value='".$options[3]."' /></td></tr>";
    $form .= "<tr><td>"._MB_SCLIENT_BSHOW."</td><td>";
    $form .= "<select size='1' name='options[4]'>";
    $sel = "";
    if ( $options[4] == 1 ) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='1' ".$sel.">"._MB_SCLIENT_IMAGES."</option>";
    $sel = "";
    if ( $options[4] == 2 ) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='2' ".$sel.">"._MB_SCLIENT_TEXT."</option>";
    $sel = "";
    if ( $options[4] == 3 ) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='3' ".$sel.">"._MB_SCLIENT_BOTH."</option>";
    $form .= "</select></td></tr>";
    $form .= "<tr><td>"._MB_SCLIENT_BORDER."</td><td>";
    $form .= "<select size='1' name='options[5]'>";
    $sel = "";
    if ( $options[5] == "id" ) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='id' ".$sel.">"._MB_SCLIENT_ID."</option>";
    $sel = "";
    if ( $options[5] == "hits" ) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='hits' ".$sel.">"._MB_SCLIENT_HITS."</option>";
    $sel = "";
    if ( $options[5] == "title" ) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='title' ".$sel.">"._MB_SCLIENT_TITLE."</option>";
    if ( $options[5] == "weight" ) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='weight' ".$sel.">"._MB_SCLIENT_WEIGHT."</option>";
    $form .= "</select> ";
    $form .= "<select size='1' name='options[6]'>";
    $sel = "";
    if ( $options[6] == "ASC" ) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='ASC' ".$sel.">"._MB_SCLIENT_ASC."</option>";
    $sel = "";
    if ( $options[6] == "DESC" ) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='DESC' ".$sel.">"._MB_SCLIENT_DESC."</option>";
    $form .= "</select></td></tr>";

    $form .= "<tr><td>"._MB_SCLIENT_SEE_ALL."</td><td>";
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