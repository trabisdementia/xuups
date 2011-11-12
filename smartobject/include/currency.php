<?php

/**
 * $Id: currency.php 159 2007-12-17 16:44:05Z malanciault $
 * Module: SmartObject
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

smart_loadCommonLanguageFile();

include_once(SMARTOBJECT_ROOT_PATH . "class/currency.php");

static $smartobject_currenciesObj, $smartobject_currenciesArray, $smartobject_default_currency;

$smartobject_currency_handler = xoops_getModuleHandler('currency', 'smartobject');

if (!$smartobject_currenciesObj) {
    $smartobject_currenciesObj = $smartobject_currency_handler->getCurrencies();
}
if (!$smartobject_currenciesArray) {
    foreach($smartobject_currenciesObj as $currencyid=>$currencyObj) {
        if ($currencyObj->getVar('default_currency', 'e')) {
            $smartobject_default_currency = $currencyObj;
        }
        $smartobject_currenciesArray[$currencyid] = $currencyObj->getCode();
    }
}

?>