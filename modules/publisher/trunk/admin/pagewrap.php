<?php

/**
* $Id: pagewrap.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Credits : TinyContent developped by Tobias Liegl (AKA CHAPI) (http://www.chapi.de)
* Licence: GNU
*/

include_once "admin_header.php";

publisher_xoops_cp_header();

publisher_adminMenu(-1, _AM_PUB_ITEMS . " > " . _AM_PUB_PAGEWRAP);

publisher_collapsableBar('pagewraptable', 'pagewrapicon', _AM_PUB_PAGEWRAP, _AM_PUB_PAGEWRAPDSC);
	
$dir = publisher_getUploadDir(true, 'content');

if(!eregi("777",decoct(fileperms($dir)))) {
    echo"<font color='FF0000'><h4>"._AM_PUB_PERMERROR."</h4></font>";
}

// Upload File
	echo "<form name='form_name2' id='form_name2' action='pw_upload_file.php' method='post' enctype='multipart/form-data'>";
	echo "<table cellspacing='1' width='100%' class='outer'>";
	echo "<tr><th colspan='2'>"._AM_PUB_UPLOAD_FILE."</th></tr>";
	echo "<tr valign='top' align='left'><td class='head'>"._AM_PUB_SEARCH."</td><td class='even'><input type='file' name='fileupload' id='fileupload' size='30' /></td></tr>";
	echo "<tr valign='top' align='left'><td class='head'><input type='hidden' name='MAX_FILE_SIZE' id='op' value='500000' /></td><td class='even'><input type='submit' name='submit' value='"._AM_PUB_UPLOAD."' /></td></tr>";
	echo "</table>";
    echo "</form>";

// Delete File
	$form = new XoopsThemeForm(_AM_PUB_DELETEFILE, "form_name", "pw_delete_file.php");

	$pWrap_select = new XoopsFormSelect(publisher_getUploadDir(true, 'content'), "address");
    $folder = dir($dir);
	while($file = $folder->read()) {
      if ($file != "." && $file != "..") {
	     $pWrap_select->addOption($file, $file);
	  }
	}
    $folder->close();
	$form->addElement($pWrap_select);

	$delfile = "delfile";
	$form->addElement(new XoopsFormHidden('op', $delfile));
	$submit = new XoopsFormButton("", "submit", _AM_PUB_BUTTON_DELETE, "submit");
	$form->addElement($submit);
	$form->display();

	publisher_close_collapsable('pagewraptable', 'pagewrapicon');
	xoops_cp_footer();

?>