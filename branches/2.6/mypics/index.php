<?php
// $Id: index.php,v 1.4 2007/08/26 17:32:19 marcellobrandao Exp $
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

$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 1;
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$isOwner = false;
if (is_object($xoopsUser)) {
    if (!isset($_GET['uid'])) {
        $uid = $xoopsUser->getVar('uid');
        $isOwner = true;
    } else {
        $isOwner = ($xoopsUser->getVar('uid') == $uid);
    }
}

$handler =& xoops_getModuleHandler('image');

$criteria = new CriteriaCompo(new Criteria('uid', $uid));
$count = $handler->getCount($criteria);

$criteria->setLimit($xoopsModuleConfig['picturesperpage']);
$criteria->setStart($start);

$images = $handler->getAll($criteria, null, false, false);
unset($criteria);

/**
 * If there is no pictures in the album
 */
if (!$count){
    $xoopsTpl->assign('lang_nopicyet', _MD_MYPICS_NOTHINGYET);
} else {
    $xoopsTpl->assign('pics_array', $images);
}

/**
 * Show the form if it is the owner and he can still upload pictures
 */
if ($isOwner && $xoopsModuleConfig['nb_pict'] > $count){
    $maxfilebytes = $xoopsModuleConfig['max_file_size'];
    $handler->renderFormSubmit($maxfilebytes, $xoopsTpl);
}

/**
 * Let's get the user name of the owner of the album
 */
$owner = new XoopsUser();
$identifier = $owner->getUnameFromId($uid);
$avatar = $owner->getVar('user_avatar');

/**
 * Adding to the module js and css of the lightbox and new ones
 */
$header_lightbox = '<script type="text/javascript" src="lightbox/js/prototype.js"></script>
<script type="text/javascript" src="lightbox/js/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="lightbox/js/lightbox.js"></script>
<link rel="stylesheet" href="include/mypics.css" type="text/css" media="screen" />
<link rel="stylesheet" href="lightbox/css/lightbox.css" type="text/css" media="screen" />';

/**
 * Navigation
 */
xoops_load('XoopsPageNav');
$xoopsPN = new XoopsPageNav($count, $xoopsModuleConfig['picturesperpage'], $start, 'start','uid=' . $uid);
$pagenav = $xoopsPN->renderImageNav(2);

/**
 * Assigning smarty variables
 */
$xoopsTpl->assign('pagenav', $pagenav);
$xoopsTpl->assign('lang_albumtitle',sprintf(_MD_MYPICS_ALBUMTITLE,"<a href=".XOOPS_URL."/userinfo.php?uid=".$uid.">".$identifier."</a>"));
$xoopsTpl->assign('path_mypics_uploads',$xoopsModuleConfig['link_path_upload']);
$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar("name"). " - " . $identifier . "'s album");
$xoopsTpl->assign('nome_modulo', $xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_max_nb_pict', sprintf(_MD_MYPICS_YOUCANHAVE, $xoopsModuleConfig['nb_pict']));
$xoopsTpl->assign('lang_delete',_MD_MYPICS_DELETE );
$xoopsTpl->assign('lang_editdesc',_MD_MYPICS_EDITDESC );
$xoopsTpl->assign('lang_avatarchange',_MD_MYPICS_AVATAR_CHANGE);
$xoopsTpl->assign('isOwner', $isOwner);
$xoopsTpl->assign('lang_nb_pict', sprintf(_MD_MYPICS_YOUHAVE, $count));
$xoopsTpl->assign('xoops_module_header', $header_lightbox);
$xoopsTpl->assign('campo_token',$GLOBALS['xoopsSecurity']->getTokenHTML());


/**
 * Adding the comment system
 */
include XOOPS_ROOT_PATH . '/include/comment_view.php';

/**
 * Closing the page
 */
include XOOPS_ROOT_PATH . '/footer.php';
?>