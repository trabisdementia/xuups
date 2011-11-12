<?php
/************************************************************************/
/* Donations - Paypal financial management module for Xoops 2           */
/* Copyright (c) 2004 by Xoops2 Donations Module Dev Team			    */
/* http://dev.xoops.org/modules/xfmod/project/?group_id=1060			*/
/* $Id$      */
/************************************************************************/
/*                                                                      */
/* Based on NukeTreasury for PHP-Nuke - by Dave Lawrence AKA Thrash     */
/* NukeTreasury - Financial management for PHP-Nuke                     */
/* Copyright (c) 2004 by Dave Lawrence AKA Thrash                       */
/*                       thrash@fragnastika.com                         */
/*                       thrashn8r@hotmail.com                          */
/*                                                                      */
/************************************************************************/
/*                                                                      */
/* This program is free software; you can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/*                                                                      */
/* This program is distributed in the hope that it will be useful, but  */
/* WITHOUT ANY WARRANTY; without even the implied warranty of           */
/* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU     */
/* General Public License for more details.                             */
/*                                                                      */
/* You should have received a copy of the GNU General Public License    */
/* along with this program; if not, write to the Free Software          */
/* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307  */
/* USA                                                                  */
/************************************************************************/

defined('XOOPS_ROOT_PATH') or die('Restricted access');

$xdonDir = basename ( dirname ( dirname( __FILE__ ) ) );

xoops_loadLanguage('main', $xdonDir);

include_once XOOPS_ROOT_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $xdonDir . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'functions.php';

function b_donations_donate_show($options) {

    global $xoopsDB, $xoopsUser;

    $xdonDir = basename ( dirname ( dirname( __FILE__ ) ) );
    $tr_config = configInfo();
    $paypal_url = explode('|',$tr_config['paypal_url']);
    $paypal_url = $paypal_url[0];
    //determine the currency
    $PP_CURR_CODE = explode('|',$tr_config['pp_curr_code']); // [USD,GBP,JPY,CAD,EUR]
    $PP_CURR_CODE = $PP_CURR_CODE[0];
    $curr_sign = define_curr($PP_CURR_CODE);

    $block = array();

    $PP_RECEIVER_EMAIL = $tr_config['receiver_email'];
    $PP_ITEMNAME = $tr_config['pp_itemname'];
    $PP_TY_URL = $tr_config['ty_url'];
    $PP_CANCEL_URL = $tr_config['pp_cancel_url'];


    // Fill out some more template tags
    $DON_BUTTON_SUBMIT = $tr_config['don_button_submit'];

    $PP_NO_SHIP = $tr_config['pp_get_addr'] ? "0" : "1" ;
    $PP_IMAGE_URL = $tr_config['pp_image_url'];

    $DON_SUB_IMG_DIMS = '';
    if( is_numeric($tr_config['don_sub_img_width']) ) {
        $DON_SUB_IMG_DIMS .= 'width='.$tr_config['don_sub_img_width'].' ';
    }
    if( is_numeric($tr_config['don_sub_img_height']) ) {
        $DON_SUB_IMG_DIMS .= 'height='.$tr_config['don_sub_img_height'].' ';
    }

    $sql = "SELECT * FROM " . $xoopsDB->prefix("donations_config")
    . " WHERE name='don_amount' ORDER BY subtype";
    $Recordset1 = $xoopsDB->query($sql);

    $DONATION_AMOUNTS = "";
    while ($row_Recordset1 = $xoopsDB->fetchArray($Recordset1)) {
        if( is_numeric($row_Recordset1['value']) && $row_Recordset1['value'] > 0 ) {
            if( $row_Recordset1['subtype'] == $tr_config['don_amt_checked'] ) {
                $checked = " selected";
                $block['basedonation'] =  $row_Recordset1['value'];
            } else {
                $checked = "";
            }
            $DONATION_AMOUNTS .= '<option value="'
            . $row_Recordset1['value'] . '" '
            . $checked . ' > ' . $curr_sign . $row_Recordset1['value'] . '</option>' . "\n";
        }
    }
    $DONATION_AMOUNTS .= '<option value="0"> '._MB_DON_OTHER_AMOUNT.' </option>';

    // Ok, output the page

    $uid = ($xoopsUser) ? $xoopsUser->getVar('uid') : 0 ;
    $block['custom'] = $uid;
    $block['email'] = $PP_RECEIVER_EMAIL;
    $block['item'] = $PP_ITEMNAME;
    $block['amounts'] =  $DONATION_AMOUNTS;
    $block['prompt'] = $tr_config['don_name_prompt'];
    $block['nm_yes'] = $tr_config['don_name_yes'];
    $block['nm_no'] = $tr_config['don_name_no'];
    $block['pp_noship'] = $PP_NO_SHIP;
    $block['pp_curr_code'] = $PP_CURR_CODE;
    $block['pp_cancel'] = $PP_CANCEL_URL;
    $block['pp_thanks'] = $PP_TY_URL;
    $block['pp_image'] = $PP_IMAGE_URL;
    $block['sub_img'] = $DON_SUB_IMG_DIMS;
    $block['submit_button'] = _MB_DON_SUBMIT_BUTTON;
    $block['paypal_url'] = $paypal_url;
    $block['lang_select'] = _MB_DON_SELECTAMT;
    $block['xdon_dir'] = $xdonDir;

    return $block;
}
?>