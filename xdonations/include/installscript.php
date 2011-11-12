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
include_once XOOPS_ROOT_PATH . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'cp_functions.php';

$xypDir = basename ( dirname( dirname( __FILE__ ) ) ) ;
global $xoopsConfig, $xoopsUser;

/*

echo "<hr>language : {$xoopsConfig['language']}<hr>";

$n = '_AD_DON_z_test';  if (defined($n)){echo $n . " = " . constant($n)."<br>";}else{echo $n . " = ?<br>";}
$n = '_MD_DON_z_test';  if (defined($n)){echo $n . " = " . constant($n)."<br>";}else{echo $n . " = ?<br>";}
$n = '_MI_DON_z_test';  if (defined($n)){echo $n . " = " . constant($n)."<br>";}else{echo $n . " = ?<br>";}
$n = '_MB_DON_z_test';  if (defined($n)){echo $n . " = " . constant($n)."<br>";}else{echo $n . " = ?<br>";}
*/

xoops_loadLanguage('main', $xypDir);

function xoops_module_install_xyp_base(&$module=NULL)
{
    global $xoopsDB, $xoopsUser;
    $xypDir = basename ( dirname( dirname( __FILE__ ) ) ) ;

    //----------------------------------------------------------------
    //patch JJD pour francisation ou autre langue
    //----------------------------------------------------------------
    update_lg();
    //----------------------------------------------------------------

    $sql1 = 'UPDATE '.$xoopsDB->prefix('donations_config').' SET `value` = "'.XOOPS_URL.'/modules/' . $xypDir . '/success.php" WHERE `name` = "ty_url"';
    $sql2 = 'UPDATE '.$xoopsDB->prefix('donations_config').' SET `value` = "'.XOOPS_URL.'/modules/' . $xypDir . '/cancel.php" WHERE `name` = "pp_cancel_url"';

    $retVal = FALSE;
    if ( $xoopsUser ) {
        if ( $xoopsDB->query($sql1) &&  $xoopsDB->query($sql2) ) {
            $retVal = TRUE;
        }
    }
    return $retVal;
}


/************************************************************************
 *
 ************************************************************************/
function update_lg() {
    global $xoopsDB;

//    $xypDir = basename ( dirname( dirname( __FILE__ ) ) ) ;

    if (defined('_AD_DON_DONATIONS')){
        $prefixV = '_AD_DON_V_';
        $prefixT = '_AD_DON_T_';

    }else{
        $prefixV = '_MI_DON_V_';
        $prefixT = '_MI_DON_T_';

    }

    $lstName = "receiver_email_;paypal_url_array;use_goal_array;"
    ."week_goal_1st;week_goal_2nd;week_goal_3rd;week_goal_4th;"
    ."month_goal_Jan;month_goal_Feb;month_goal_Mar;month_goal_Apr;"
    ."month_goal_May;month_goal_Jun;month_goal_Jul;"
    ."month_goal_Aug;month_goal_Sep;month_goal_Oct;"
    ."month_goal_Nov;month_goal_Dec;quarter_goal_1st;quarter_goal_2nd;"
    ."quarter_goal_3rd;quarter_goal_4th;swing_day_;ty_url_;"
    ."pp_itemname_;don_button_submit_;don_button_top_;pp_image_url_;"
    ."pp_cancel_url_;pp_get_addr_;pp_curr_code_array;don_amount_1;"
    ."don_amount_2;don_amount_3;don_amount_4;don_amount_5;"
    ."don_amount_6;don_amount_7;don_amt_checked_;pp_item_num_;"
    ."don_top_img_width_;don_top_img_height_;don_sub_img_width_;"
    ."don_sub_img_height_;don_text_rawtext;don_name_prompt_;"
    ."don_name_yes_;don_name_no_;don_forceadd_;ipn_dbg_lvl_;ipn_log_entries_;"
    ."assign_group_;assign_rank_";

    $table = $xoopsDB->prefix('donations_config');
    $sql0 = "INSERT INTO `{$table}` (`name`, `subtype`, `value`, `text`) "
    ."VALUES ('%1\$s', '%2\$s', '%3\$s', '%4\$s')";


    $sql = "DELETE FROM {$table}";
    $xoopsDB->queryF($sql);
    //echo "{$sql}<br>";
    $t = explode(';', $lstName);


    for ($h = 0; $h < count($t); $h++){
        //echo "<hr>{$t[$h]}<br>";
        $tc = explode('_', $t[$h]);
        //echo "<hr>{$t[$h]}-".count($tc)."-".count($tn)."<br>";

        //$tc = array_shift($tc);
        $subType = $tc[count($tc)-1];

        $cstV = $prefixV.$t[$h];
        $cstT = $prefixT.$t[$h];

        //$tc = array_shift($tc);
        $tn = array_pop($tc);
        $tn = $tc;
        $name = implode('_', $tn);
        //echo "{$t[$h]}-".count($tc)."-".count($tn)."-{$tc[0]}-{$tn[0]}-{$name}<br>";

        $value = constant($cstV);
        $text  = constant($cstT);
        $text = str_replace("'", "\'", $text);
        $text = html_entity_decode($text);
        $text = str_replace('<br>', "\r\n", $text);
        $text = str_replace('<br />', "\r\n", $text);

        $sql = sprintf($sql0, $name, $subType, $value, $text);
//        echo "{$sql}<br>";
        $xoopsDB->queryF($sql);

    }


}

eval( 'function xoops_module_install_' . $xypDir . '(&$module=NULL)
        {
        return xoops_module_install_xyp_base($module);
        }
    ' ) ;

/************************************************************************

 http://localhost/xoops2018a/modules/xdonations/include/installscript.php?op=update_lg
 http://localhost/xoops2018a/modules/xdonations/include/installscript.php?op=update_lg
 https://www.paypal.com/fr_FR/FR/i/btn/btn_donate_LG.gif
 ************************************************************************/

$op = isset($_GET['op']) ? $_GET['op'] : '';

switch($op)
{
    case "update_lg":
        update_lg();
        break;
    default:
        break;
}
?>
