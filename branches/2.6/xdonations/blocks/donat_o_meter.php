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


$xdBlockDir = basename ( dirname ( dirname( __FILE__ ) ) );
xoops_loadLanguage('main', $xdBlockDir);

include_once XOOPS_ROOT_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $xdBlockDir . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'functions.php';

function b_donations_donatometer_show($options)
{
    global $xoopsDB;
    $xdBlockDir = basename ( dirname ( dirname( __FILE__ ) ) );

    $tr_config = configInfo();
    //determine the currency
    $PP_CURR_CODE = explode('|',$tr_config['pp_curr_code']); // [USD,GBP,JPY,CAD,EUR]
    $PP_CURR_CODE = $PP_CURR_CODE[0];
    $curr_sign = define_curr($PP_CURR_CODE);

    $block = array();

    $swingd = $tr_config['swing_day'];
    if ( ($swingd < 0) OR ($swingd > 31) ) {
        $swingd = 6;
    }
    $dmshowdate = $options[1];
    $dmshowamt  = $options[2];

    if(is_numeric($options[0]) && $options[0] > 0 ) {
        $dmlen = $options[0];
    } elseif (is_numeric($dmlen) && $dmlen == 0) {
        $dmlen = -1;
    } else {
        $dmlen = 10;
    }

    // Check the current day against the swing day to execute the proper query
    if( date('d') >= $swingd ) {
        $query_Recordset1 = "SELECT count(mc_gross) AS count, sum(mc_gross) AS gross, sum("
        ."mc_gross-mc_fee) AS net, date_format( now(),'%M') AS mon, date_format( subdate( date_format( adddate("
        ."now(), INTERVAL 1 MONTH),'%Y-%c-1'), INTERVAL 1 DAY), '%b %e') AS due_by, date_format(now(),'%b') AS "
        ."mon_short FROM ".$xoopsDB->prefix("donations_transactions")." WHERE (payment_date >= date_format("
        ."now(),'%Y-%m-".$swingd."'))";

        $query_Recordset3 = "select custom as muser_id, option_selection1 as showname, "
        ."date_format( payment_date, '%b-%e') as date, concat('".$curr_sign."',sum(mc_gross)) as amt "
        ."from ".$xoopsDB->prefix("donations_transactions")." where (payment_date >= date_format( "
        ."now(), '%Y-%m-".$swingd."')) group by txn_id order by payment_date desc";
    } else {
        $query_Recordset1 = "select count(mc_gross) as count, sum(mc_gross) as gross, sum(mc_gross -"
        ." mc_fee) as net, date_format( subdate( now(), interval ".$swingd." day), '%M') as mon,"
        ." 'Now!' as due_by, date_format( subdate( now(), interval ".$swingd." day), '%b') as mon_short"
        ." from ".$xoopsDB->prefix("donations_transactions")." where (payment_date < date_format( now(), '%Y-%m-".$swingd."')"
        .") and payment_date > date_format( subdate( now(), interval ".$swingd." day), '%Y-%m-".$swingd."')";

        $query_Recordset3 = "select custom as muser_id, option_selection1 as showname, "
        ."date_format( payment_date, '%b-%e') as date, concat('".$curr_sign."', sum(mc_gross)) as amt "
        ."from ".$xoopsDB->prefix("donations_transactions")." where (payment_date < date_format(now(),"
        ." '%Y-%m-".$swingd."')) and payment_date > date_format( subdate( now(),interval ".$swingd." "
        ."day), '%Y-%m-".$swingd."') group by txn_id order by payment_date desc";
    }

    // Get the donation totals
    $Recordset1 = $xoopsDB->query($query_Recordset1);
    $row_Recordset1 = $xoopsDB->fetchArray($Recordset1);
    //If there are not records, then get "null" data
    if( !$row_Recordset1 ) {
        $query_Recordset1 = "select '0' as count, '0' as gross, '0' as net, date_format( now(),"
        ."'%M') as mon, date_format( subdate( date_format( adddate( now(), interval 1 month), '%Y-%c-1'),"
        ." interval 1 day), '%b %e') as due_by, date_format( now(), '%b') as mon_short from "
        ." ".$xoopsDB->prefix("donations_transactions")."";
        $Recordset1 = $xoopsDB->query($query_Recordset1);
        $row_Recordset1 = $xoopsDB->fetchArray($Recordset1);
    }
    // Get the goal
    $query_Recordset2 = "SELECT * FROM ".$xoopsDB->prefix("donations_config")." WHERE name='month_goal' AND subtype='".$row_Recordset1['mon_short']."'";
    $Recordset2= $xoopsDB->query($query_Recordset2);
    $row_Recordset2 = $xoopsDB->fetchArray($Recordset2);

    // Set our remaining template vars
    if(!$row_Recordset1['mon']) {
        $DM_MON = date('F');
    } else {
        $DM_MON = $row_Recordset1['mon'];
    }
    $difference = $row_Recordset1['net'] - $row_Recordset2['value'];
    $DM_GOAL = sprintf($curr_sign.'%.02f', $row_Recordset2['value']);
    $DM_DUE = $row_Recordset1['due_by'];
    $DM_NUM = $row_Recordset1['count'];
    $DM_GROSS = sprintf($curr_sign.'%.02f',$row_Recordset1['gross']);
    $DM_NET = sprintf($curr_sign.'%.02f',$row_Recordset1['net']);
    $DM_LEFT = sprintf($curr_sign.'%.02f', $row_Recordset2['value'] - $row_Recordset1['net']);
    $DM_BUTTON = $options[3];
    $DM_BUTT_DIMS = '';
    if ( is_numeric($options[4]) ) {
        $DM_BUTT_DIMS .= 'width='.$options[4].' ';
    }
    if ( is_numeric($options[5]) ) {
        $DM_BUTT_DIMS .= 'height='.$options[5].' ';
    }

    // Load the template
    $block['DM_BUTTON'] = $DM_BUTTON;
    $block['DM_BUTT_DIMS'] = $DM_BUTT_DIMS;
    $block['DM_MON'] = $DM_MON;
    $block['DM_GOAL'] = $DM_GOAL;
    $block['DM_DUE'] =$DM_DUE;
    $block['DM_GROSS'] = $DM_GROSS;
    $block['DM_NET'] = $DM_NET;
    $block['DON_URL'] = XOOPS_URL . '/modules/' . $xdBlockDir . '/index.php';
    $show_don=0;
    // Do we want to display the donators?
    if(is_numeric($dmlen) && $dmlen >= 0 ) {
        $show_don=1;
        // Get the list of donators
        $Recordset3= $xoopsDB->query($query_Recordset3);

        // List all the donators
        $i = 0;
        $var = '';
        while ( ($row_Recordset3 = $xoopsDB->fetchArray($Recordset3)) && ($i != $options[0]) ) {
            // Refunded transactions will show up with $0 amount
            if( $row_Recordset3['amt'] > "$0" ) {
                $dmalign = "center";
                $var .= "<tr><td style=\"width: 100%; text-align: {$dmalign}\" colspan=\"2\">\n";
                // Observe the user's wish regarding revealing their name
                $muser_id = $row_Recordset3['muser_id'];
                if( strcmp($row_Recordset3['showname'],"Yes") == 0 && ($userfoin = mgetusrinfo($muser_id))){
                    $var .= "<a href='".XOOPS_URL."/userinfo.php?uid=".$userfoin->getVar('uid')."'>".$userfoin->getVar('uname')."</a>\n";
                } else {
                    $var .= _MB_DON_ANONYMOUS_SHORT;
                }
                $var .= "&nbsp;";
                if( $dmshowamt ) {
                    $var .=  "(".$row_Recordset3['amt'].")";
                }
                if( $dmshowdate ) {
                    $var .=  $row_Recordset3['date'];
                }
                $var .=  "</td></tr>\n";
            }
            $i++;
        }
    }

    if ($difference >= 0) {
        $DM_OVERAGE = sprintf($curr_sign.'%.02f', $difference);
        $block['DM_REMAIN'] = _MB_DON_SURPLUS;
        $block['DM_BALANCE'] = $DM_OVERAGE;
    } else {
        $block['DM_REMAIN'] = _MB_DON_LEFT2GO;
        $block['DM_BALANCE'] = "<span style=\"color: #CC0000\">{$DM_LEFT}</span>";
    }

    // Define language constants
    $block['DM_STAT'] = _MB_DON_STAT;
    $block['DM_MONGOAL'] = _MB_DON_MONGOAL;
    $block['DM_DUEDATE'] = _MB_DON_DUEDATE;
    $block['DM_GROSSAMT'] = _MB_DON_GROSSAMT;
    $block['DM_NETBAL'] = _MB_DON_NETBAL;
    $block['DM_DONATIONS'] = _MB_DON_DONATIONS;
    $block['DM_MAKEDON'] = _MB_DON_MAKEDON;

    // Display block
    $block['show_don']= $show_don;
    $block['content'] = $var;
    return $block;
}

function b_donations_donatometer_edit($options)
{
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
    $form .= "<br />" . _MB_DON_BUTTON_URL . ":&nbsp;";
    $form .= "<input size='70' name='options[3]' type='text' value='".$options[3]."'>";
    $form .= "<br />" . _MB_DON_BUTTON_DIMS . ":&nbsp;";
    $form .= _MB_DON_WIDTH . "&nbsp;<input size='4' name='options[4]' type='text' value='".$options[4]."'>";
    $form .= "&nbsp;&nbsp;" . _MB_DON_WIDTH . "&nbsp;<input size='4' name='options[5]' type='text' value='".$options[5]."'>";
    return $form;
}
?>
