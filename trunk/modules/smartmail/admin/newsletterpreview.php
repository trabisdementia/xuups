<?php
// $Id: newsletterpreview.php,v 1.3 2006/06/17 19:00:13 marcan Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
include "header.php";

$dispatch_handler = xoops_getmodulehandler('dispatch');
$dispatch = $dispatch_handler->get($_REQUEST['id']);

if (isset($_REQUEST['test'])) {
    $email_arr = explode(',', $_REQUEST['email']);
    $emails = array_map('trim', $email_arr);
    if ($dispatch->send(true, $emails)) {
        $myts = MyTextSanitizer::getInstance();
        echo "Mail sent to ".$myts->addSlashes($_REQUEST['email']);
    }
}
//else {
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
$form = new XoopsSimpleForm("", 'form', 'newsletterpreview.php', 'get');
$tray = new XoopsFormElementTray('', "&nbsp;", "tray");
$tray->addElement(new XoopsFormText('email', 'email', 35, 255, ''));
$tray->addElement(new XoopsFormButton('', 'submit', 'Send Preview', 'submit'));
$form->addElement($tray);
$form->addElement(new XoopsFormHidden('test', 1));
$form->addElement(new XoopsFormHidden('id', $_REQUEST['id']));
$form->display();

$content = $dispatch->build();
echo $dispatch->getVar('dispatch_subject')."<br />";
echo str_replace("cid:embedimage", XOOPS_URL."/fil/", $content['html']);

//echo $xoopsLogger->dumpAll();
//echo "<br />";
//echo $content['text'];
//}
//echo "<hr />";
//$dispatch_time = $dispatch->getNextDispatch();
//echo "<br /> <br />Next dispatch: ".date("d-m-Y H:i", $dispatch_time);
//echo "<hr />";
//xoops_cp_footer();
?>