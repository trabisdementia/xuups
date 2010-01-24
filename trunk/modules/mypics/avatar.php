<?php
// $Id: avatar.php,v 1.5 2008/04/07 23:56:46 marcellobrandao Exp $
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
include_once XOOPS_ROOT_PATH . '/header.php';

/**
 * Verify TOKEN
 */
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header('index.php', 5, _MD_MYPICS_TOKENEXPIRED);
}
$id = intval($_POST['id']);
$handler = xoops_getModuleHandler('image');
$image = $handler->get($id);
$uid = $xoopsUser->getVar('uid');
$image_path = $xoopsModuleConfig['path_upload'] .'/thumb_' . $image->getVar('url');
$avatar = 'av_'. $uid . '.jpg';
$avatar_path = $xoopsModuleConfig['path_upload'] . '/' . $avatar;

if (!copy($image_path, $avatar_path)) {
    echo 'failed to copy file...\n';
} else {
    $xoopsUser->setVar('user_avatar', $avatar);
    $userHandler = new XoopsUserHandler($xoopsDB);

    /**
    * Verifying who's the owner to allow changes
    */
    if ($uid == $image->getVar('uid')) {
        if ($userHandler->insert($xoopsUser)) {
            redirect_header('index.php', 2, _MD_MYPICS_AVATAR_EDITED);
        } else {
            redirect_header('album.php', 2, _MD_MYPICS_NOCACHACA);
        }
    }
}

include_once XOOPS_ROOT_PATH . '/footer.php';
?>