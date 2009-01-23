<?php

/**
* $Id: pw_delete_file.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Credits : TinyContent developped by Tobias Liegl (AKA CHAPI) (http://www.chapi.de)
* Licence: GNU
*/

include_once "admin_header.php";

if (isset($_POST["op"]) && ($_POST["op"] == "delfileok")) {
	$dir = publisher_getUploadDir(true, 'content');
	@unlink($dir."/".$_POST["address"]);
	redirect_header($_POST['backto'],2,_AM_PUB_FDELETED);
} else {
	xoops_cp_header();
	xoops_confirm(array('backto' => $_POST['backto'], 'address' => $_POST["address"], 'op' => 'delfileok'), 'pw_delete_file.php', _AM_PUB_RUSUREDELF, _YES);
	xoops_cp_footer();
}
?>