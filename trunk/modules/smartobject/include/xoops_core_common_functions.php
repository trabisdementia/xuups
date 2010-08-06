<?php

/**
 * $Id: xoops_core_common_functions.php 159 2007-12-17 16:44:05Z malanciault $
 * Module: SmartRental
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}


/* Debug functions to help developers :-)
 * Author : The SmartFactory
 */
function xoops_debug_dumbQuery($msg='') {
    global $xoopsDB;
    $xoopsDB->query('SELECT * ' . $msg . ' FROM dudewhereismycar2');
}

function xoops_debug_initiateQueryCount()
{
    global $smartfactory_query_count_activated, $smartfactory_query_count;
    $smartfactory_query_count_activated = true;
    $smartfactory_query_count = 0;
}

function xoops_debug_getQueryCount($msg='')
{
    global $smartfactory_query_count;
    return xoops_debug("xoops debug Query count ($msg): $smartfactory_query_count");
}

function xoops_debug($msg, $exit=false)
{
    echo "<div style='padding: 5px; color: red; font-weight: bold'>debug :: $msg</div>";
    if ($exit) {
        die();
    }
}

function xoops_comment($msg)
{
    echo "<div style='padding: 5px; color: green; font-weight: bold'>=> $msg</div>";
}

function xoops_debug_vardump($var)
{
    if (class_exists('MyTextSanitizer')) {
        $myts = MyTextSanitizer::getInstance();
        xoops_debug($myts->displayTarea(var_export($var, true)));
    } else {
        xoops_debug(var_export($var, true));
    }
}
?>