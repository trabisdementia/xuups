<?php

/**
 * $Id: vclient.php,v 1.4 2005/05/18 14:32:39 fx2024 Exp $
 * Module: SmartClient
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

include "header.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$clientObj = new SmartclientClient($id);

if ($clientObj->notLoaded()) {
    redirect_header("javascript:history.go(-1)", 1, _CO_SCLIENT_NOCLIENTSELECTED);
    exit();
}

if ( $clientObj->url() ) {
    if ( !isset($HTTP_COOKIE_VARS['clients'][$id]) ) {
        setcookie("clients[$id]", $id, $xoopsModuleConfig['cookietime']);
        $clientObj->updateHits();
    }
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$clientObj->url()." ");
    exit();
    //	echo "<html><head><meta http-equiv='Refresh' content='0; URL=".$clientObj->url()."'></head><body></body></html>";
} else {
    redirect_header("index.php", 1, _XP_NOPART);
}
?>