<?php
// $Id: newsletter.php,v 1.4 2006/07/15 20:48:19 mith Exp $
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
//  of supporting developers from this source code or any supporting         /
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

function b_newsletter_show($options) {
    $ret = array();
    $ret['newsletterid'] = intval($options[0]);
    return $ret;
}

function b_newsletter_edit($options) {
    include_once (XOOPS_ROOT_PATH."/class/xoopsformloader.php");

    if (!class_exists('XoopsFormSelectList')) {
        include_once(XOOPS_ROOT_PATH . "/modules/smartmail/class/formselectlist.php");
    }

    $form = new XoopsFormElementTray('', '<br/><br />');

    $form->addElement(new XoopsFormSelectList(_NL_BK_NEWSLETTER_ID, 'options[0]', $options[0], 1, "newsletter", "smartmail"));

    return $form->render();
}
?>