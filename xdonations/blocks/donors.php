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

function b_donations_donors_show($options) {

    global $xoopsDB;

    $tr_config = configInfo();
    //determine the currency
    $PP_CURR_CODE = explode('|',$tr_config['pp_curr_code']); // [USD,GBP,JPY,CAD,EUR]
    $PP_CURR_CODE = $PP_CURR_CODE[0];
    $curr_sign = define_curr($PP_CURR_CODE);

    $dmshowdate = $options[1];
    $dmshowamt  = $options[2];
    $block      = array();
    $swingd     = $tr_config['swing_day'];

    if(($swingd < 0) OR ($swingd > 31)) {
        $swingd = 6;
    }

    if( date('d') >= $swingd){
        $query_Recordset1 = "SELECT custom AS muser_id, option_selection1 as showname, DATE_FORMAT(payment_date, '%b %e') AS date, CONCAT('".$curr_sign."',SUM(mc_gross)) AS amt FROM ".$xoopsDB->prefix("donations_transactions")." WHERE (payment_date >= DATE_FORMAT(NOW(),'%Y-%m-".$swingd."')) GROUP BY txn_id ORDER BY payment_date DESC";
    }else{
        $query_Recordset1 = "SELECT custom AS muser_id, option_selection1 as showname, DATE_FORMAT(payment_date, '%b-%e') AS date, CONCAT('".$curr_sign."',SUM(mc_gross)) AS amt FROM ".$xoopsDB->prefix("donations_transactions")." WHERE (payment_date < DATE_FORMAT(NOW(), '%Y-%m-".$swingd."')) AND payment_date > DATE_FORMAT(SUBDATE(NOW(),INTERVAL ".$swingd." DAY), '%Y-%m-".$swingd."') GROUP BY txn_id ORDER BY payment_date DESC";
    }

    $Recordset1 = $xoopsDB->query($query_Recordset1);
    $totalRows_Recordset1 = $xoopsDB->getRowsNum($Recordset1);

    $ROWS_DONATORS = "";
    // Fill out the donators table tag
    while ($row_Recordset1 = $xoopsDB->fetchArray($Recordset1)) {
        if ( $row_Recordset1['amt'] > $curr_sign.'0' ) {
            $ROWS_DONATORS .= "<tr>";
            $ROWS_DONATORS .= "<td style=\"font-weight: bold;\">&nbsp; ";

            $muser_id = $row_Recordset1['muser_id'];
            if ( strcmp($row_Recordset1['showname'],"Yes") == 0 && ($userfoin = mgetusrinfo($muser_id))) {
                $ROWS_DONATORS .= "<a href='".XOOPS_URL."/userinfo.php?uid=".  $userfoin->getVar('uid')."'>".xdshorten($userfoin->getVar('uname'))."</a>\n";
            } else {
                $ROWS_DONATORS .= _MB_DON_ANONYMOUS_SHORT;
            }

            $ROWS_DONATORS .= "</td>\n";
            if ( $dmshowamt ) {
                $ROWS_DONATORS .= "<td style=\"width: 2px;\">&nbsp;</td>\n";
                $ROWS_DONATORS .= "<td style=\"width: 55px; font-weight: bold;\">&nbsp;&nbsp;";
                $ROWS_DONATORS .= $row_Recordset1['amt'];
                $ROWS_DONATORS .=  "</td>\n";
            }
            if ( $dmshowdate ) {
                $ROWS_DONATORS .= "<td style=\"width: 2px;\">&nbsp;</td>\n";
                $ROWS_DONATORS .= "<td style=\"font-weight: bold;\">&nbsp;&nbsp;";
                $ROWS_DONATORS .= $row_Recordset1['date'];
                $ROWS_DONATORS .= "</td>\n";
            }
            $ROWS_DONATORS .= "</tr>\n";
        }
    }

    // Ok, output the page

    $block['showamt']  = $dmshowamt;
    $block['showdate'] = $dmshowdate;
    $block['list']     = $ROWS_DONATORS;
    $block['amount']   = _MB_DON_AMOUNT;
    $block['date']     = _MB_DON_DATE;
    $block['name']     = _MB_DON_NAME;

    return $block;
}

function xdshorten ($var, $len = 10)
{
    $var = trim($var);
    if (empty ($var)) {
        return "";
    }
    if (strlen ($var) < $len) {
        return $var;
    }

    if (preg_match ("/(.{1,$len})\s/", $var, $match)) {
        return $match [1] . "...";
    } else {
        return substr ($var, 0, $len) . "...";
    }
}

function b_donations_donors_edit($options) {
    $form = _MB_DON_NUM_DONORS . ":&nbsp;<input type='text' name='options[0]' value='".$options[0]."'  size='4'/>";
    $form .= "<br />" . _MB_DON_REVEAL_DATES . ":&nbsp;<select size='1' name='options[1]'><option value='1'";
    if ( $options[1] == 1 ) {
        $form .= " selected";
    }
    $form .= " />" . _YES . "</option><option value='0'";
    if ( $options[1] == 0 ) {
        $form .= " selected";
    }
    $form .= " />" . _NO . "</option></select>";
    $form .= "<br />" . _MB_DON_REVEAL_AMOUNTS . ":&nbsp;<select size='1' name='options[2]'><option value='1'";
    if ( $options[2] == 1 ) {
        $form .= " selected";
    }
    $form .= " />" . _YES . "</option><option value='0'";
    if ( $options[2] == 0 ) {
        $form .= " selected";
    }
    $form .= " />" . _NO . "</option></select>";
    return $form;
}

?>
