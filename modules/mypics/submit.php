<?php
// $Id: submit.php,v 1.3 2007/08/26 14:43:50 marcellobrandao Exp $
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

include_once dirname(dirname(dirname(__FILE__))) . '/mainfile.php';
$xoopsOption['template_main'] = 'mypics_index.html';
include_once XOOPS_ROOT_PATH . '/header.php';

/**
 * Getting the title
 */
$title = isset($_POST['caption']) ? trim($_POST['caption']) : '';

/**
 * Getting parameters defined in admin side
 */
$path_upload    = $xoopsModuleConfig['path_upload'];
$pictwidth      = $xoopsModuleConfig['resized_width'];
$pictheight     = $xoopsModuleConfig['resized_height'];
$thumbwidth     = $xoopsModuleConfig['thumb_width'];
$thumbheight    = $xoopsModuleConfig['thumb_height'];
$maxfilebytes   = $xoopsModuleConfig['max_file_size'];
$maxfileheight  = $xoopsModuleConfig['max_original_height'];
$maxfilewidth   = $xoopsModuleConfig['max_original_width'];

/**
 * If we are receiving a file
 */
if ($_POST['xoops_upload_file'][0] == 'sel_photo') {
    /**
     * Verify Token
     */
    if (!($GLOBALS['xoopsSecurity']->check())){
        redirect_header($_SERVER['HTTP_REFERER'], 3, _MD_MYPICS_TOKENEXPIRED);
    }
    ini_set('memory_limit', '50M');
    /**
     * Try to upload picture resize it insert in database and then redirect to index
     */
    $handler =& xoops_getModuleHandler('image');
    if ($handler->receivePicture($title, $path_upload, $thumbwidth, $thumbheight, $pictwidth, $pictheight, $maxfilebytes, $maxfilewidth, $maxfileheight)) {
        $extra_tags['X_OWNER_NAME'] = $xoopsUser->getVar('uname');
        $extra_tags['X_OWNER_UID'] = $xoopsUser->getVar('uid');
        $notification_handler =& xoops_gethandler('notification');
        $notification_handler->triggerEvent('picture', $xoopsUser->getVar('uid'), 'new_picture', $extra_tags);
        redirect_header(XOOPS_URL . '/modules/mypics/index.php?uid=' . $xoopsUser->getVar('uid'), 3, _MD_MYPICS_UPLOADED);
    } else {
        redirect_header(XOOPS_URL . '/modules/mypics/index.php?uid='.$xoopsUser->getVar('uid'), 3, _MD_MYPICS_NOCACHACA);
    }
}

include_once XOOPS_ROOT_PATH . '/footer.php';
?>