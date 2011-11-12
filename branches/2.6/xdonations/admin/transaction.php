<?php
/**
 *  Transaction Details
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package::    xdonations
 * @subpackage:: admin
 * @author::	 zyspec (owners@zyspec.com)
 * @license::    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @since::      File available since version 1.96
 * @version::    $Id$
 */

include '../../../include/cp_header.php';
include_once 'admin_header.php';

xoops_loadLanguage('main', $xoopsModule->getVar('dirname'));

include_once XOOPS_ROOT_PATH . DIRECTORY_SEPARATOR . 'class'   . DIRECTORY_SEPARATOR . 'xoopsformloader.php';
include '..' . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'functions.php';

xoops_cp_header();
//adminmain();

	$indexAdmin = new ModuleAdmin();
echo $indexAdmin->addNavigation('transaction.php');

$txn_id = (isset($_GET['txn_id'])) ? $_GET['txn_id'] : NULL ;
$txn_id = (isset($_POST['txn_id'])) ? $_POST['txn_id'] : $txn_id ;

// display search box
$searchForm = new XoopsThemeForm(_AD_DON_SEARCH_FORM, 'searchform', $_SERVER['PHP_SELF'], 'POST');
$searchForm->addElement(new XoopsFormText(_AD_DON_SEARCH_TERM, 'txn_id', 20, 20));
$buttonTray = new XoopsFormElementTray('');
$sButton    = new XoopsFormButton('', 'search', _SEARCH, 'submit');
$buttonTray->addElement($sButton);
$searchForm->addElement($buttonTray);
$searchForm->display();

if (isset($txn_id) && ($txn_id != 0)) {
    //find the transaction in the database
    $sql = "SELECT id, item_name, item_number, custom, memo, option_name1, option_selection1,"
    . " option_name2, option_selection2, payer_id, mc_gross, mc_fee,"
    . " (mc_gross - mc_fee) as mc_net, mc_currency, payment_status, payment_date, txn_id, txn_type,"
    . " payment_type, CONCAT(first_name,' ',last_name) AS full_name, payer_email, payer_status"
    . " FROM " . $xoopsDB->prefix('donations_transactions')
    . " WHERE `txn_id` = '" . addslashes($txn_id) . "' LIMIT 1";

    $txnRecord = $xoopsDB->query($sql);
    $row_txnRecord = $xoopsDB->fetchArray($txnRecord); //get the transaction
    $txnForm = new XoopsThemeForm(_AD_DON_TXN_FORM, 'txnform', $_SERVER['PHP_SELF'], 'POST');
    $txnForm->addElement(new XoopsFormLabel(_AD_DON_TXN_ID, $row_txnRecord['txn_id']));
    $txnForm->addElement(new XoopsFormLabel(_AD_DON_PMNT_DATE, $row_txnRecord['payment_date']));
    $txnForm->addElement(new XoopsFormLabel(_AD_DON_PMNT_TYPE, $row_txnRecord['payment_type']));
    $txnForm->addElement(new XoopsFormLabel(_AD_DON_TXN_TYPE, $row_txnRecord['txn_type']));
    $txnForm->addElement(new XoopsFormLabel(_AD_DON_ITEM_INFO, $row_txnRecord['item_name'] . " [" . $row_txnRecord['item_number'] . "]"));
    $custInfo = "<a href=\"mailto:{$row_txnRecord['payer_email']}?subject=PayPal%20TXN:%20{$row_txnRecord['txn_id']}\">{$row_txnRecord['full_name']}</a>";
    $txnForm->addElement(new XoopsFormLabel(_AD_DON_CUST_NAME, $custInfo . " (" . ucfirst($row_txnRecord['payer_status']) . ")"));
    $txnForm->addElement(new XoopsFormLabel(_AD_DON_CUST_ID, $row_txnRecord['payer_id']));
    if ( '' != $row_txnRecord['option_name1'] ) {
        $txnForm->addElement(new XoopsFormLabel($row_txnRecord['option_name1'], $row_txnRecord['option_selection1']));
    }
    if ( '' != $row_txnRecord['option_name2'] ) {
        $txnForm->addElement(new XoopsFormLabel($row_txnRecord['option_name2'], $row_txnRecord['option_selection2']));
    }
    $amount = define_curr($row_txnRecord['mc_currency']) . $row_txnRecord['mc_gross'] . " (" . $row_txnRecord['mc_currency'] . ") " . _AD_DON_GROSS
            . "<br />" . define_curr($row_txnRecord['mc_currency']) . $row_txnRecord['mc_net'] . " (" . $row_txnRecord['mc_currency'] . ") " . _AD_DON_NETBAL;
    $txnForm->addElement(new XoopsFormLabel(_AD_DON_TXN_AMOUNT, $amount));
    $txnForm->addElement(new XoopsFormLabel(_AD_DON_TXN_MEMO, $row_txnRecord['memo']));
    $txnForm->display();
} else {
    //list 10 most recent transactions in the database
    $sql = "SELECT id, item_name, item_number, custom, memo, option_name1, option_selection1,"
    . " (mc_gross - mc_fee) as mc_net, mc_currency, payment_status, payment_date, txn_id, txn_type,"
    . " payment_type, CONCAT(first_name,' ',last_name) AS full_name, payer_email, payer_status"
    . " FROM " . $xoopsDB->prefix('donations_transactions')
    //         . " WHERE `test_ipn` = `0`"
    . " ORDER BY `payment_date` DESC"
    . " LIMIT 10";

    $txnRecords = $xoopsDB->query($sql);
    /*
     $txnRecordArray = $xoopsDB->fetchArray($txnRecords); //get the transaction
     var_dump($txnRecordArray);
     exit();
     */
    $allForm = new XoopsThemeForm(_AD_DON_TXN_RECENT_FORM, 'txnform', $_SERVER['PHP_SELF'], 'POST');
    while ( $txnRecord = $xoopsDB->fetchArray($txnRecords)) {
        //    foreach($txnRecordArray as $txnRecord) {
        $thisTray = 'txnTray_' . $txnRecord['id'];
        $$thisTray = new XoopsFormElementTray($txnRecord['id'], "<br />", $txnRecord['id']);
        $txnLink = "<a href=\"transaction.php?txn_id={$txnRecord['txn_id']}\">{$txnRecord['txn_id']}</a>";
        $$thisTray->addElement(new XoopsFormLabel(_AD_DON_TXN_ID, $txnLink));
        $$thisTray->addElement(new XoopsFormLabel(_AD_DON_PMNT_DATE, $txnRecord['payment_date']));
        $custInfo = "<a href=\"mailto:{$txnRecord['payer_email']}?subject=PayPal%20TXN:%20{$txnRecord['txn_id']}\">{$txnRecord['full_name']}</a>";
        $$thisTray->addElement(new XoopsFormLabel(_AD_DON_CUST_NAME, $custInfo . " (" . ucfirst($txnRecord['payer_status']) . ")"));
        $$thisTray->addElement(new XoopsFormLabel(_AD_DON_TXN_AMOUNT, $txnRecord['mc_net'] . " (" . $txnRecord['mc_currency'] . ")"));
        $allForm->addElement($$thisTray);
    }
    $allForm->display();
}
include "admin_footer.php";
