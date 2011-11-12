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

/**
 * Set the Currency Indicator ($, etc...)
 *
 * @param string $curr PAYPAL abbreviation for currency
 * @return string currency indicator (sign)
 *
 */
function define_curr($curr)
{
    switch ($curr)
    {
        case 'AUD' :
            $curr_sign = _MD_DON_CURR_EUR;
            break;
        case 'EUR' :
            $curr_sign = _MD_DON_CURR_EUR;
            break;
        case 'GBP' :
            $curr_sign = _MD_DON_CURR_GBP;
            break;
        case 'JPY' :
            $curr_sign = _MD_DON_CURR_JPY;
            break;
        case 'CAD' :
            $curr_sign = _MD_DON_CURR_CAD;
            break;
        case 'USD' :
        default:
            $curr_sign = _MD_DON_CURR_USD;
            break;
    }
    return $curr_sign;
}

/**
 * Get all Config fields from DB
 *
 * @return array
 */
function configInfo()
{
    global $xoopsDB;

    $query_cfg = "SELECT * FROM ".$xoopsDB->prefix("donations_config")." WHERE subtype = '' OR subtype = 'array'";
    $cfgset = $xoopsDB->query($query_cfg);
    $tr_config = array();
    while ( $cfgset && $row = $xoopsDB->fetchArray($cfgset))
    {
        $tr_config[$row['name']] = $row['value'];
    }
    return $tr_config;
}

/**
 * Get XOOPS Member Object
 *
 * @param int $muser_id
 * @return FALSE - no member info avail for this id, SUCCESS - member object
 */
function mgetusrinfo($muser_id)
{
    global $xoopsDB;
    $thisUser = FALSE;
    if (intval($muser_id) > 0) {
        $member_handler =& xoops_gethandler('member');
        $thisUser =& $member_handler->getUser($muser_id);
    }
    return $thisUser;
}

/**
 * Retrieve list of db table's field names
 *
 * EXAMPLE USAGE:
 *
 * $list=simple_query($xoopsDB->prefix('donations_transactions'));
 *
 * @param string $table_name DB table name
 * @param string $key_col (optional) table column name
 * @param mixed $key_val (optional) table column value
 * @param array $ignore (optional) list of values to ignore (clear)
 * @return mixed FALSE - nothing found, SUCCESS - array() of values
 */
function simple_query($table_name, $key_col='', $key_val='',$ignore=array())
{
    global $xoopsDB;
    // open the db
    $db_link = mysql_connect(XOOPS_DB_HOST, XOOPS_DB_USER, XOOPS_DB_PASS);
    $keys='';
    if($key_col!=''&&$key_val!=''){
        $keys = "WHERE $key_col = $key_val";
    }
    // query table using key col/val
    $simple_q = FALSE;
    $db_rs = mysql_query("SELECT * FROM $table_name $keys", $db_link);
    $num_fields = mysql_num_fields($db_rs);
    if ($num_fields) {
        // first (and only) row
        $simple_q = array();
        $row = mysql_fetch_assoc($db_rs);
        // load up array
        if($key_col!='' && $key_val!=''){
            for ($i = 0; $i < $num_fields; $i++) {
                $var='';
                $var = mysql_field_name($db_rs, $i);
                $simple_q[$var] = $row[$var];
            }
        }else{
            for ($i = 0; $i < $num_fields; $i++) {
                $var='';
                $var = mysql_field_name($db_rs, $i);
                if(!in_array($var,$ignore)){
                    $simple_q[$var] = '';
                }
            }
        }
    }
    mysql_free_result($db_rs);
    return $simple_q;
}

/*
 * Functions for Administration display
 */

/**
 * Display a Config Option html Option Box in a 2 column table row
 *
 * @param string $name name of config variable in config DB table
 * @param string $desc description of option box
 */
function ShowYNBox($name, $desc)
{
    global $tr_config, $modversion, $xoopsDB;

    $query_cfg = "SELECT * FROM " . $xoopsDB->prefix("donations_config")
    . " WHERE name = '{$name}'";
    $cfgset = $xoopsDB->query($query_cfg);
    if( $cfgset ) {
        $cfg = $xoopsDB->fetchArray($cfgset);
        $text = htmlentities($cfg['text']);
        echo "<tr>\n"
        . "  <td title=\"{$text}\" style=\"text-align: right;\">{$desc}</td>\n"
        . "  <td title=\"{$text}\" style=\"text-align: left\">";
        echo "    <select size=\"1\" name=\"var_{$name}\">";
        if( $cfg['value'] ) {
            echo "      <option selected value=\"1\">" . _YES . "</option>"
            . "      <option value=\"0\">" . _NO . "</option>";
        } else {
            echo "      <option value=\"1\">" . _YES . "</option>"
            . "      <option selected value=\"0\">" . _NO . "</option>";
        }
        echo "    </select>\n";
        echo "  </td>\n";
        echo "</tr>\n";
    }
}

/**
 * Display a Config option HTML Select Box in 2 column table
 *
 * @param string $name name of config DB table column
 * @param string $desc description of select box to show
 */
function ShowDropBox($name, $desc)
{
    global $tr_config, $modversion, $xoopsDB;

    $query_cfg = "SELECT * FROM " . $xoopsDB->prefix("donations_config")
    . " WHERE name = '{$name}'";
    $cfgset = $xoopsDB->query($query_cfg);
    if( $cfgset ) {
        $cfg = $xoopsDB->fetchArray($cfgset);
        $text = htmlentities($cfg['text']);
        echo "<tr style=\"text-align: center;\">\n"
        . "  <td title=\"{$text}\" style=\"text-align: right; width: 50%;\">{$desc}</td>\n"
        . "  <td title=\"{$text}\" style=\"text-align: left;\">\n";
        echo "    <select size=\"1\" name=\"var_{$name}-array\">\n";
        if( isset($cfg['value']) ) {
            $splitArr = explode('|', $cfg['value']);
            $i=0;
            while($i < count($splitArr)){
                $selected = ( 0 == $i ) ? ' selected' : '';
                echo "      <option{$selected} value=\"{$splitArr[$i]}\">{$splitArr[$i]}</option>\n";
                $i++;
            }
        }
        echo "    </select>\n";
        echo "  </td>\n";
        echo "</tr>\n";
    }
}

/**
 * Display Config Array Drop Box in HTML 2 column table row
 *
 * @param string $name name of DB column in config table
 * @param string $desc description to display for select box
 * @param array $x_array array( array($value1, $attrib1), array(...) )
 */
function ShowArrayDropBox($name, $desc, $x_array)
{
    global $tr_config, $modversion, $xoopsDB;
    $query_cfg = "SELECT * FROM ".$xoopsDB->prefix("donations_config")
    . " WHERE name = '{$name}' LIMIT 1";
    $cfgset = $xoopsDB->query($query_cfg);
    if( $cfgset ) {
        $cfg = $xoopsDB->fetchArray($cfgset);
        $text = htmlentities($cfg['text']);
        echo "<tr>\n"
        ."  <td title=\"{$text}\" style=\"text-align: right;\">{$desc}</td>\n"
        ."  <td title=\"{$text}\" style=\"text-align: left;\">\n";
        echo "    <select size=\"1\" name=\"var_{$name}\">\n";
        if ( isset($cfg['value']) ) {
            if ( 0 == $cfg['value'] ) {
                echo "      <option selected value=\"0\">-------</option>\n";
            }else{
                echo "      <option value=\"0\">-------</option>\n";
            }
            $i=0;
            while( $i < count($x_array) ){
                $mvar = $x_array[$i];
                $selected = '';
                if ( $mvar[0] == $cfg['value'] ) {
                    $selected = ' selected';
                }
                echo "      <option{$selected} value=\"{$mvar[0]}\">{$mvar[1]}</option>\n";
                $i++;
            }
        }
        echo "    </select>\n";
        echo "  </td>\n";
        echo "</tr>\n";
    }
}

/**
 * Display Config Option Text Box in a 2 column table row
 *
 * @param string $name name of DB column in config table
 * @param string $desc description of text box to display
 * @param int $tdWidth width of description field
 * @param int $inpSize width of text input box
 * @param string $extra extra info included in input box 'string'
 */
function ShowTextBox($name, $desc, $tdWidth, $inpSize, $extra)
{
    global $tr_config, $modversion, $xoopsDB;

    $query_cfg = "SELECT * FROM ".$xoopsDB->prefix("donations_config")
    . " WHERE name = '{$name}'";
    $cfgset = $xoopsDB->query($query_cfg);
    if( $cfgset ) {
        $cfg = $xoopsDB->fetchArray($cfgset);
        $text = htmlentities($cfg['text']);
        echo "<tr>\n"
        . "  <td title=\"{$text}\" style=\"text-align: right; width: {$tdWidth}\">{$desc}</td>\n"
        . "  <td title=\"{$text}\" style=\"text-align: left;\">\n"
        . "    <input size=\"{$inpSize}\" name=\"var_{$name}\" type=\"text\" value=\"{$cfg['value']}\"  {$extra} />\n"
        . "  </td>\n"
        . "</tr>\n";
    }
}

/************************************************************************
 *
 ************************************************************************/
function ShowImgXYBox($xnm, $ynm, $desc, $inpSize, $extra)
{
    global $tr_config, $modversion, $xoopsDB;

    $query_cfg = "SELECT * FROM ".$xoopsDB->prefix("donations_config")." WHERE name = '$xnm'";
    $cfgset = $xoopsDB->query($query_cfg);

    if( $cfgset) {
        $cfg = $xoopsDB->fetchArray($cfgset);

        $text = htmlentities($cfg['text']);
        echo "<tr>\n"
        . "  <td title=\"{$text}\" style=\"text-align: right;\">{$desc}</td>\n"
        . "  <td title=\"{$text}\" style=\"text-align: left;\">\n";
        echo "    &nbsp;" . _AD_DON_WIDTH . "&nbsp;\n"
        . "    <input size=\"{$inpSize}\" name=\"var_{$cfg['name']}\" type=\"text\" value=\"{$cfg['value']}\" {$extra} />\n";

        $query_cfg = "SELECT * FROM ".$xoopsDB->prefix("donations_config")." WHERE name = '$ynm'";
        $cfgset = $xoopsDB->query($query_cfg);
        if( $cfgset)
        {
            $cfg = $xoopsDB->fetchArray($cfgset);
            echo "    &nbsp;&nbsp;" . _AD_DON_HEIGHT . "&nbsp;\n"
            . "    <input size=\"{$inpSize}\" name=\"var_{$cfg['name']}\" type=\"text\" value=\"{$cfg['value']}\" {$extra} />\n";
        }
        echo "  </td>\n"
        . "</tr>\n";
    }
}

/*
 * Functions to save Administration settings
 */


/**
 * Update the Config option in the database
 *
 * @param string $name config var name in the database
 * @param string $sub  config subtype in the database
 * @param mixed $val   config var value
 * @param string $txt  configuration text for this var
 * @return bool TRUE value updated, FALSE value not updated
 */
function UpdateDb($name, $sub, $val, $txt)
{
    global $tr_config, $ilog, $xoopsDB;
    $insert_Recordset = "UPDATE `" . $xoopsDB->prefix("donations_config") . "`"
    . " SET `value`='$val', `text`='{$txt}'"
    . " WHERE `name`='{$name}' AND `subtype`='{$sub}'";
    $ilog .= "{$insert_Recordset}<br /><br />";
    echo "{$insert_Recordset}<br /><br />";
    echo "<span style=\"color: #FF0000; font-weight: bold;\">";
    $rvalue = $xoopsDB->query($insert_Recordset);
    echo "</span>";
    $retVal = ($rvalue) ? TRUE : FALSE;
    return $retVal;
}

/************************************************************************
 *
 ************************************************************************/
function UpdateDbShort($name, $sub, $val, $txt)
{
    global $tr_config, $ilog, $xoopsDB;
    if($sub=='array'){
        $newArr = '';
        $query_cfg = "SELECT * FROM ".$xoopsDB->prefix("donations_config")
        . " WHERE name = '{$name}'";
        $cfgset = $xoopsDB->query($query_cfg);
        $cfg = $xoopsDB->fetchArray($cfgset);
        if( isset($cfg['value']) ) {
            $splitArr = explode('|',$cfg['value']);
            $newArr = $val;
            $i=0;
            while($singleVar = $splitArr[$i]) {
                if ( $singleVar != $val ) {
                    $newArr = $newArr.'|'.$singleVar;
                }
                $i++;
            }
            $val = $newArr;
        }
    }
    $insert_Recordset = "UPDATE `" . $xoopsDB->prefix("donations_config") . "`"
    . " SET `value`='{$val}'"
    . " WHERE `name`='{$name}' AND `subtype`='{$sub}'";

    $ilog .= "{$insert_Recordset}<br /><br />\n";
    echo "{$insert_Recordset}<br /><br /><span style=\"color: #FF0000; font-weight: bold;\">\n";
    $rvalue = $xoopsDB->query($insert_Recordset);
    echo "</span>\n";
}

/**
 * Get Configuration Value
 *
 * @param string $name name of configuration variable
 * @return mixed value of config var on success, FALSE on failure
 *
 */
function getLibConfig($name)
{
    global $xoopsDB;

    $sql = "SELECT * FROM ".$xoopsDB->prefix("donations_config")
    ." WHERE name = '{$name}'";
    $Recordset = $xoopsDB->query($sql);
    $row = $xoopsDB->fetchArray($Recordset);
    //	$text = $b = html_entity_decode($row['text']);
    $text = html_entity_decode($row['text']);
    return $text;
}

/**
 *
 * Get All Configuration Values
 *
 * @return array SUCCESS - array of config values (name as key); FAIL - empty
 */
function getAllLibConfig()
{
    global $xoopsDB;

    $sql = "SELECT * FROM " . $xoopsDB->prefix("donations_config")
    . " ORDER BY name, subtype";
    $sqlquery = $xoopsDB->query($sql);

    $t = array();
    while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {
        $text = html_entity_decode($sqlfetch['text']);
        $text = str_replace('<br />', "\r\n", $text);
        $text = str_replace('<br />', "\r\n", $text);

        if ($sqlfetch['subtype'] == '') {
            $t[$sqlfetch['name']] = $text;
        } else {
            $t[$sqlfetch['name']][$sqlfetch['subtype']] = $text;
        }
    }
    //displayArray($t,"------getAllLibConfig-----------");
    return $t;
}
/*******************************************************************
 *
 *******************************************************************/
function displayArray_don($t, $name = "", $ident = 0)
{
    if (is_array($t)) {
        echo "------------------------------------------------<br />" ;
        echo "displayArray: " . $name . " - count = " . count($t) ;
        //echo "<table ".getTblStyle().">";
        echo "<table>\n";

        echo "  <tr><td>";
        //jjd_echo ("displayArray: ".$name." - count = ".count($t), 255, "-") ;
        echo "</td></tr>\n";

        echo "  <tr><td>\n";
        echo "    <pre>";
        echo print_r($t);
        echo "</pre>\n";
        echo "  </td></tr>\n";
        echo "</table>\n";
    } else {
        echo "The variable ---|{$t}|--- is not an array\n";
        //        echo "l'indice ---|{$t}|--- n'est pas un tableau\n";
    }
    //jjd_echo ("Fin - ".$name, 255, "-") ;
}
/**
 * Display main top header table
 *
 */
function adminmain() {
    global $tr_config, $modversion, $xoopsDB;

    echo "<div style=\"text-align: center;\">\n";
    echo "<table style='text-align: center; border-width: 1px; padding: 2px; margin: 2px; width: 90%;'>\n";
    echo "  <tr>\n";
    echo "    <td style='text-align: center; width: 25%;'><a href='index.php?op=Treasury'><img src='../images/admin/business_sm.png' alt='" . _AD_DON_TREASURY . "' />&nbsp;" . _AD_DON_TREASURY . "</a></td>\n";
    echo "    <td style='text-align: center; width: 25%;'><a href='index.php?op=ShowLog'><img src='../images/admin/view_text_sm.png' alt='" . _AD_DON_SHOW_LOG . "' />&nbsp;" . _AD_DON_SHOW_LOG . "</a></td>\n";
    echo "    <td style='text-align: center; width: 25%;'><a href='transaction.php'><img src='../images/admin/view_detailed_sm.png' alt='" . _AD_DON_SHOW_TXN . "' />&nbsp;" . _AD_DON_SHOW_TXN . "</a></td>\n";
    echo "    <td style='text-align: center; width: 25%;'><a href='index.php?op=Config'><img src='../images/admin/configure_sm.png' alt='" . _AD_DON_CONFIGURATION . "' />&nbsp;" . _AD_DON_CONFIGURATION . "</a></td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "<br /></div>\n";
}
?>
