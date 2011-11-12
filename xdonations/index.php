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


include 'header.php';
include_once 'include' . DIRECTORY_SEPARATOR . 'functions.php';
$xoopsOption['template_main'] = 'donations_main.html';
include XOOPS_ROOT_PATH . DIRECTORY_SEPARATOR . 'header.php';

$tr_config  = configInfo(); //load the module configuration settings
$paypal_url = explode('|',$tr_config['paypal_url']);
$paypal_url = $paypal_url[0];

//determine the currency
$PP_CURR_CODE  = explode('|',$tr_config['pp_curr_code']); // [USD,GBP,JPY,CAD,EUR]
$PP_CURR_CODE  = $PP_CURR_CODE[0];
$curr_sign     = define_curr($PP_CURR_CODE);

$swingd        = $tr_config['swing_day'];
$PP_RECEIVER_EMAIL = $tr_config['receiver_email'];
$PP_ITEMNAME   = $tr_config['pp_itemname'];
$PP_TY_URL     = $tr_config['ty_url'];
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
. " WHERE name = 'don_text'";
$Recordset = $xoopsDB->query($sql);
$row = $xoopsDB->fetchArray($Recordset);
$DON_TEXT = $row['text'];

$sql = "SELECT * FROM ".$xoopsDB->prefix("donations_config")
. " WHERE name='don_amount' ORDER BY subtype";
$Recordset1 = $xoopsDB->query($sql);

$DONATION_AMOUNTS = "";
while ($row_Recordset1 = $xoopsDB->fetchArray($Recordset1)) {
    if( is_numeric($row_Recordset1['value']) && $row_Recordset1['value'] > 0 ) {
        if( $row_Recordset1['subtype'] == $tr_config['don_amt_checked'] ) {
            $checked = " selected";
            $xoopsTpl->assign('BASEDONATION', $row_Recordset1['value']);
        } else {
            $checked = "";
        }
        $DONATION_AMOUNTS .= '<option value="'
        .  $row_Recordset1['value'] . '" '
        .  $checked . ' > ' . $curr_sign . $row_Recordset1['value'] . '</option>' . "\n";
    }
}
$DONATION_AMOUNTS .= '<option value="0"> '._MD_DON_OTHER.' </option>';

$uid = (is_object($xoopsUser)) ? $xoopsUser->getVar('uid') : 0 ;

// Ok, output the page

$xoopsTpl->assign('CUSTOM',            $uid);
$xoopsTpl->assign('DON_TITLE',         _MD_DON_TITLE);
$xoopsTpl->assign('PP_RECEIVER_EMAIL', $PP_RECEIVER_EMAIL);
$xoopsTpl->assign('PP_ITEMNAME',       $PP_ITEMNAME);
$xoopsTpl->assign('DONATION_AMOUNTS',  $DONATION_AMOUNTS);
$xoopsTpl->assign('DON_TEXT',          $DON_TEXT);
$xoopsTpl->assign('DON_NAME_YES',      $tr_config['don_name_yes']);
$xoopsTpl->assign('DON_NAME_NO',       $tr_config['don_name_no']);
$xoopsTpl->assign('PP_NO_SHIP',        $PP_NO_SHIP);
$xoopsTpl->assign('PP_CURR_CODE',      $PP_CURR_CODE);
$xoopsTpl->assign('PP_CANCEL_URL',     $PP_CANCEL_URL);
$xoopsTpl->assign('PP_TY_URL',         $PP_TY_URL);
$xoopsTpl->assign('PP_IMAGE_URL',      $PP_IMAGE_URL);
$xoopsTpl->assign('DON_SUB_IMG_DIMS',  $DON_SUB_IMG_DIMS);
$xoopsTpl->assign('DON_BUTTON_SUBMIT', $DON_BUTTON_SUBMIT);
$xoopsTpl->assign('MAKEADON',          _MD_DON_MAKEADON);
$xoopsTpl->assign('SELECTAMT',         _MD_DON_SELECTAMT);
$xoopsTpl->assign('SHOWNAME',          $tr_config['don_name_prompt']);
$xoopsTpl->assign('DONTHISMONTH',      _MD_DON_DONTHISMONTH);
$xoopsTpl->assign('DON_NAME',          _MD_DON_NAME);
$xoopsTpl->assign('DON_DIR',           $xoopsModule->getVar('dirname'));
$xoopsTpl->assign('SUBMIT_BUTTON',     _MD_DON_SUBMIT_BUTTON);
$xoopsTpl->assign('PAYPAL_URL',        $paypal_url);

include 'footer.php';
?>
