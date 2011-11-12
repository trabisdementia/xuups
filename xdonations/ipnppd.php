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

//$xoopsOption['nocommon'] = 1;
include 'header.php';
include_once 'include' . DIRECTORY_SEPARATOR . 'functions.php';
include_once XOOPS_ROOT_PATH . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'xoopsformloader.php';

$tr_config = configInfo();
$paypal_url = explode('|',$tr_config['paypal_url']);
$paypal_url = $paypal_url[0];
//determine the currency
$PP_CURR_CODE = explode('|',$tr_config['pp_curr_code']); // [USD,GBP,JPY,CAD,EUR]
$PP_CURR_CODE = $PP_CURR_CODE[0];
$curr_sign = define_curr($PP_CURR_CODE);

$pp_varlist=simple_query($xoopsDB->prefix('donations_transactions'),'','',array('id'));

define('_ERR', 1);
define('_INF', 2);
$ERR = 0;
$log = '';
$loglvl = $tr_config['ipn_dbg_lvl'];

// creates a log file in the XOOPS uploads directory
$lpFile = XOOPS_UPLOAD_PATH . DIRECTORY_SEPARATOR . 'xdonations_ipn.log';
if ( $lp = fopen($lpFile, 'w+') ) {
    dprt(_MD_DON_LOGFILE_CREATED, _INF);
} else {
    dprt(_MD_DON_LOGFILE_NOT_CREATED, _ERR);
}
dprt(date('r'), _INF);
$dbg = (isset($_GET['dbg']) && $_GET['dbg'] ) ? TRUE : FALSE ;

if( $dbg ) {
    dprt(_MD_DON_DEBUGACTIVE, _INF);
    echo _MD_DON_DEBUGHEADER;
    $pp_varlist['receiver_email'] = $tr_config['receiver_email'];
}

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
    $value = urlencode(stripslashes($value));
    $req .= "&$key=$value";
}

// post back to PayPal system to validate
dprt(_MD_DON_OPENCONN, _INF);
$fp = fsockopen ($paypal_url, 80, $errno, $errstr, 30);

if (!$fp) { // HTTP ERROR
    //TODO: use CURL if fsockopen fails
    dprt("<style=\"color: #00CC00;\">" . _MD_DON_CONNFAIL . "</span>", _ERR);
    die( sprintf(_MD_DON_POSTBACK_FAIL, $errno, $errstr) );
} else {
    dprt(_MD_DON_POSTBACK_OK, _INF);
    $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
}

// assign posted variables to local variables
$pp_varname = array_values(array_intersect(array_keys($pp_varlist), array_keys($_POST)));
for ($i = 0; $i < count($pp_varname); $i++) {
    $pp_varlist[$pp_varname[$i]] = $_POST[$pp_varname[$i]];
}

if ( '' == $pp_varlist['payment_date'] ) { //set blank date to proper format
    $pp_varlist['payment_date'] = '0000-00-00 00:00:00';
}

$writeOk = fputs ($fp, $header . $req);
if (!$writeOk) { // HTTP ERROR
    dprt("<style=\"font-weight: bold; color: #00CC00;\">" . _MD_DON_WRITEFAIL . "</span>", _ERR);
    die(sprintf(_MD_DON_ERR_FAILED_WRITE, $errno, $errstr));
} else {
    dprt(_MD_DON_WRITEOK, _INF);
}

// Perform PayPal email account verification
if ( !$dbg && (strcasecmp( $pp_varlist['business'], $tr_config['receiver_email']) != 0) ) {
    dprt(sprintf(_MD_DON_BUSINVALID,$pp_varlist['business']), _ERR) ;
    dprt(sprintf(_MD_DON_RCVINVALID,$pp_varlist['receiver_email']), _ERR) ;
    $ERR = 1;
}

$insertSQL = '';
// Look for duplicate txn_id's
if( $pp_varlist['txn_id'] ) {
    $sql = "SELECT COUNT(*) FROM ".$xoopsDB->prefix("donations_transactions")." WHERE txn_id = '" . addslashes($pp_varlist['txn_id']) . "'";
    $Recordset1 = $xoopsDB->query($sql);
    list($NumDups) = $xoopsDB->fetchRow($Recordset1);
}
if ( $pp_varlist['parent_txn_id'] ) {
    $parent_sql = "SELECT * FROM ".$xoopsDB->prefix("donations_transactions")." WHERE txn_id = '" . addslashes($pp_varlist['parent_txn_id']) . "'";
    $parent_Recordset1 = $xoopsDB->query($parent_sql);
    $parent_row_Recordset1 = $xoopsDB->fetchArray($parent_Recordset1);
    $parent_NumDups = $xoopsDB->getRowsNum($parent_Recordset1);
}

while (!$dbg && !$ERR && !feof($fp)) {
    $res = fgets ($fp, 1024);
    if (strcmp ($res, "VERIFIED") == 0) {
        // Ok - PayPal has told us we have a valid IPN here
        dprt(_MD_DON_VERIFIED, _INF);

        // Check for a reversal for a refund
        if( strcmp($pp_varlist['payment_status'], "Refunded") == 0 || strcmp($pp_varlist['txn_type'], "Reversal") == 0) {
            // Verify the reversal
            dprt(_MD_DON_REFUND, _INF);
            if ( ($parent_NumDups == 0) || strcmp($parent_row_Recordset1['payment_status'], "Completed") ||
            (strcmp($parent_row_Recordset1['txn_type'], "web_accept") != 0 && strcmp($parent_row_Recordset1['txn_type'], "send_money") != 0) ) {
                // This is an error.  A reversal implies a pre-existing completed transaction
                dprt(_MD_DON_TRANSMISSING, _ERR);
                foreach( $_POST as $key => $val ) {
                    dprt("$key => $val", _ERR);
                }
                break;
            }
            if ( 1 != $parent_NumDups  ) {
                dprt(_MD_DON_MULTITXNS, _ERR);
                foreach ( $_POST as $key => $val ) {
                    dprt("$key => $val", _ERR);
                }
                break;
            }

            /* TODO: Need to add info to database.  If user donates, then cancels a subsequent
             * donation then they are removed from group - need a counter to see how many times a
             * user has donated and only remove from group if 'everything' donated has been reversed.
             */

            // remove xoopsUsers (not anon) from group selected by Admin in config
            if ( !empty($pp_varlist['custom']) ){
                $member_handler =& xoops_gethandler('member');
                $edituser =& $member_handler->getUser($pp_varlist['custom']);

                // remove the user from the specified group
                if ($tr_config['assign_group']) {  // admin has selected a group in admin
                    $group_handler =& xoops_gethandler('group');
                    $validGroup = $group_handler->get(intval($tr_config['assign_group'])); // make sure this is a valid group id
                    if ($validGroup) {
                        $thisUserGroups = $member_handler->getGroupsByUser(intval($edituser->getVar('uid')));
                        if (!in_array($validGroup->getVar('groupid'), $thisUserGroups)) {

                            // now find out if user is in the group
                            $isMember = $member_handler->getGroupsByUser($edituser->getVar('uid'));
                            if ($isMember) {
                                $success = $member_handler->removeUserFromGroup($tr_config['assign_group'], $edituser->getVar('uid'));
                                if ($success) {
                                    dprt("User " . $edituser->getVar('uname') . " was removed from the " . $validGroup->getVar('name') . " group", _INF);
                                } else {
                                    dprt ("User " . $edituser->getVar('uname') . " could not be removed from the " . $validGroup->getVar('name') ." group", _ERR);
                                }
                            }
                        } else {
                            dprt ($edituser->getVar('uname') . " was not in the " . $validGroup->getVar('name') . " group", _INF);
                        }
                    } else {
                        dprt ('Group isn\'t valid - change Admin configs option<br />', _ERR);
                    }
                }
                /*
                 * TODO: Need to add a db table variable to 'demote' the user's rank back to where
                 * it was prior to the reversal
                 */
            }
            $pp_varlist['payment_date'] = strftime('%Y-%m-%d %H:%M:%S',strtotime($pp_varlist['payment_date']));
            $field_values=$field_names='';
            for ($i = 0; $i < count($pp_varname); $i++) {
                if ( 0 != $i ){
                    $field_names .= ',';
                    $field_values .= ',';
                }
                $field_names .= '`' . $pp_varname[$i] . '`';
                $field_values .= "'" . $pp_varlist[$pp_varname[$i]] . "'";
            }
            $insertSQL = "INSERT INTO ".$xoopsDB->prefix("donations_transactions")." ($field_names) VALUES ($field_values)";

            // We're cleared to add this record
            dprt($insertSQL, _INF);
            $Result1 = $xoopsDB->queryF($insertSQL);
            dprt("SQL result = " . $Result1, _INF);

            break;
            // Look for a normal payment
        } elseif ( (strcmp($pp_varlist['payment_status'], "Completed") == 0) && ((strcmp($pp_varlist['txn_type'], "web_accept")== 0) || (strcmp($pp_varlist['txn_type'], "send_money")== 0)) ) {
            dprt(_MD_DON_NORMAL_TXN, _INF);
            if( $lp ) {
                fputs($lp, $pp_varlist['payer_email'] . " " . $pp_varlist['payment_status'] . " " . $pp_varlist['payment_date'] . "\n");
            }

            if ( $NumDups != 0 ) { // Check for a duplicate txn_id
                dprt(_MD_DON_DUPLICATETXN, _ERR);
                foreach ( $_POST as $key => $val ) {
                    dprt("$key => $val", _ERR);
                }
                break;
            }

            $pp_varlist['payment_date'] = strftime('%Y-%m-%d %H:%M:%S', strtotime($pp_varlist['payment_date']));
            $field_values = $field_names = '';
            for ($i = 0; $i < count($pp_varname); $i++) {
                if ( $i != 0 ) {
                    $field_names .= ',';
                    $field_values .= ',';
                }
                $field_names .= '`'.$pp_varname[$i].'`';
                $field_values .= "'".$pp_varlist[$pp_varname[$i]]."'";
            }
            $insertSQL = "INSERT INTO ".$xoopsDB->prefix("donations_transactions")." ($field_names) VALUES ($field_values)";

            // We're cleared to add this record
            dprt($insertSQL, _INF);
            $Result1 = $xoopsDB->queryF($insertSQL);
            dprt("SQL result = " . $Result1, _INF);

            // add xoopsUsers (not anon) to group if selected by Admin in config
            if ( !empty($pp_varlist['custom']) && ( ($pp_varlist['option_selection1'] == 'Yes') || ($tr_config['don_forceadd'] == '1') ) ) {
                $member_handler =& xoops_gethandler('member');
                $edituser =& $member_handler->getUser($pp_varlist['custom']);

                // add the user to specified group
                if ( $tr_config['assign_group'] ) {  // config option set to add users to a group
                    $group_handler =& xoops_gethandler('group');
                    $validGroup = $group_handler->get(intval($tr_config['assign_group'])); // make sure this is a valid group id
                    if ($validGroup) {
                        $thisUserGroups = $member_handler->getGroupsByUser(intval($edituser->getVar('uid')));
                        if (!in_array($validGroup->getVar('groupid'), $thisUserGroups)) {
                            $success = $member_handler->addUserToGroup($validGroup->getVar('groupid'), $edituser->getVar('uid'));
                            if ($success) {
                                dprt("User " . $edituser->getVar('uname') . " was added to the " . $validGroup->getVar('name') . " group", _INF);
                            } else {
                                dprt ("User " . $edituser->getVar('uname') . " could not be addded to the " . $validGroup->getVar('name') ." group", _ERR);
                            }
                        } else {
                            dprt ($edituser->getVar('uname') . " is already in the " . $validGroup->getVar('name') . " group", _INF);
                        }
                    } else {
                        dprt ('Group isn\'t valid - change Admin configs option<br />', _ERR);
                    }
                }

                // add the user to a specific rank
                if ( $tr_config['assign_rank'] ) {  // config option set to add users to a rank
                    $urank = $edituser->rank();
                    if ( 0 != $urank['id'] ) {
                        $result = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix('ranks')." WHERE rank_id='".$urank['id']."' AND rank_special=0");
                        list($rank_check) = $xoopsDB->fetchRow($result);
                        $xoopsDB->freeRecordSet($result);
                    } else {
                        $rank_check = 1;
                    }
                    if ( $rank_check > 0 ) {
                        // set user's new rank
                        $edituser->setVar('rank', $tr_config['assign_rank']);
                        $member_handler->insertUser($edituser);
                    }
                }
            }
            break;
        } else  { // We're not interested in this transaction, so we're done
            dprt(_MD_DON_NOTINTERESTED, _ERR);
            foreach ( $_POST as $key => $val ) {
                dprt("$key => $val", _ERR);
            }
            dprt('pp_varlist:',_ERR);
            foreach ( $pp_varlist as $key => $val ) {
                dprt("$key => $val", _ERR);
            }
            dprt('strcmp payment_status: '.strcmp($pp_varlist['payment_status'], "Completed"),_ERR);
            dprt('strcmp txn_type: '.strcmp($pp_varlist['txn_type'], "web_accept"),_ERR);
            dprt('strcmp txn_type: '.strcmp($pp_varlist['txn_type'], "send_money"),_ERR);
            break;
        }
    } elseif (strcmp ($res, "INVALID") == 0) {
        // log for manual investigation
        dprt(_MD_DON_INVALIDIPN, _ERR);
        foreach( $_POST as $key => $val ) {
            dprt("$key => $val", _ERR);
        }
        break;
    } else {
        dprt(_MD_DON_ERR_UNKNOWN_IPN_STAT, _ERR);
    }
}

if( $dbg ) {
    $sql = "SELECT * FROM ".$xoopsDB->prefix("donations_transactions") . " LIMIT 10";
    dprt(_MD_DON_EXECUTING_QUERY, _INF);
    $Result1 = $xoopsDB->query($sql);
    if ( $Result1 ) {
        dprt("<span style=\"font-weight: bold; color: #00CC00;\">" . _MD_DON_DEBUGPASS . "</span>", _INF);
    } else {
        dprt("<span style=\"font-weight: bold; color: #CC0000;\">" . _MD_DON_DEBUGFAIL . "</span>", _ERR);
    }
    dprt(sprintf(_MD_DON_RCVEMAIL,$tr_config['receiver_email']), _INF);
}

if( $log ) {
    dprt("<br />" . _MD_DON_LOGBEGIN . "<br />\n", _INF);
    // Insert the log entry
    $currentDate = strftime('%Y-%m-%d %H:%M:%S',mktime());
    $paymentDate = isset($_POST['payment_date']) ? strftime('%Y-%m-%d %H:%M:%S',strtotime($_POST['payment_date'])) : $currentDate;
    $sql = "INSERT INTO " . $xoopsDB->prefix("donations_translog") . " VALUES (NULL,'{$currentDate}', '{$paymentDate}','" . addslashes($log) . "')";
    $Result1 = $xoopsDB->queryF($sql);

    // Clear out old log entries
    $sql = "SELECT COUNT(*) FROM ".$xoopsDB->prefix("donations_translog");
    $Result1 = $xoopsDB->query($sql);
    list($countLogs) = $xoopsDB->fetchRow($Result1);
    if( $countLogs == $tr_config['ipn_log_entries'] ) {
        $sql =  "DELETE FROM " . $xoopsDB->prefix("donations_translog");
        $Result1 = $xoopsDB->queryF($sql);
        if ( FALSE === $Result1 ) {
            dprt(_MD_DON_ERR_TXN_NOCLEAR, _ERR);
        } else {
            dprt(_MD_DON_ERR_TXN_CLEAR, _INF);
        }
    }
}

fclose ($fp);
if( $lp ) {
    fputs($lp, _MD_DON_EXITING . "\n");
    fclose ($lp);
}

if( $dbg) {
    echo "<hr />";
    echo _MD_DON_IFNOERROR . "<br />\n";
    echo "<a href='javascript:window.close();'>Close Window</a>";
}

/**
 *
 * Debug Message Store/Display
 * @param string $str string to store/display
 * @param int $clvl error reporting level (1 = error, 2= info)
 */
function dprt($str, $clvl)
{
    global $dbg, $lp, $log, $loglvl;

    if ( isset($dbg) && $dbg ) {
        echo $str . "<br />";
    }

    if ( isset($loglvl) && ($clvl <= $loglvl) ) {
        $log .= $str . "\n";
        if ( isset($lp) && $lp ) {
            fputs($lp, strip_tags($str) . "\r\n");
        }
    }
}
?>
