<?php
// $Id: custom.php,v 1.1 2006/09/12 08:43:22 mith Exp $
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

function b_smartmail_custom_show($options) {
    $myts =& MyTextSanitizer::getInstance();
    $content = $options[0];
    $c_type = $options[1];
    if ( $c_type == 'H' ) {
        $block['content'] = str_replace('{X_SITEURL}', XOOPS_URL.'/', $myts->stripSlashesGPC($content));
    } else {
        $block['content'] = str_replace('{X_SITEURL}', XOOPS_URL.'/', $myts->displayTarea($content, 1, 1));
    }
    return $block;
}

function b_smartmail_custom_edit($options) {
    $ts =& MyTextSanitizer::getInstance();
    include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
    $form = new XoopsFormElementTray('', '<br />', 'options');
    $form->addElement(new XoopsFormDhtmlTextArea(_NL_MB_CONTENT, 'options[0]', htmlspecialchars($ts->stripSlashesGPC($options[0]), ENT_QUOTES), 15, 60));
    $type_select = new XoopsFormSelect(_NL_MB_CONTENTTYPE, 'options[1]', $options[1]);
    $type_select->addOption('H', _NL_MB_HTMLBLOCK);
    $type_select->addOption('S', _NL_MB_NOHTMLBLOCK);
    $form->addElement($type_select);
    return $form->render();
}
?>