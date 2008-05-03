<?php
// $Id: system_blocks.php 987 2007-08-13 07:34:08Z phppp $
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
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

function b_mycomments_show($options)
{
    $block = array();
    include_once XOOPS_ROOT_PATH.'/modules/mycomments/include/comment_constants.php';
    $comment_handler =& xoops_getmodulehandler('comment','mycomments');
    $criteria = new CriteriaCompo(new Criteria('com_status', MYCOM_ACTIVE));
    $criteria->setLimit(intval($options[0]));
    $criteria->setSort('com_created');
    $criteria->setOrder('DESC');

    // Check modules permissions
    global $xoopsUser;
    $moduleperm_handler =& xoops_gethandler('groupperm');
    $gperm_groupid = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
    $criteria1 = new CriteriaCompo(new Criteria('gperm_name','module_read','='));
    $criteria1->add(new Criteria('gperm_groupid', '('.implode(',', $gperm_groupid).')', 'IN'));
    $perms = $moduleperm_handler->getObjects($criteria1, true);
    $modIds = array();
    foreach($perms as $item) {
        $modIds[] = $item->getVar('gperm_itemid');
    }
    if(count($modIds) > 0 ) {
        $modIds = array_unique($modIds);
        $criteria->add(new Criteria('com_modid', '('.implode(',', $modIds).')', 'IN'));
    }
    // Check modules permissions

    $comments = $comment_handler->getObjects($criteria, true);
    $member_handler =& xoops_gethandler('member');
    $module_handler =& xoops_gethandler('module');
    $modules = $module_handler->getObjects(new Criteria('hascomments', 1), true);
    $comment_config = array();
    foreach (array_keys($comments) as $i) {
        $mid = $comments[$i]->getVar('com_modid');
        $com['module'] = '<a href="'.XOOPS_URL.'/modules/'.$modules[$mid]->getVar('dirname').'/">'.$modules[$mid]->getVar('name').'</a>';
        if (!isset($comment_config[$mid])) {
            $comment_config[$mid] = $modules[$mid]->getInfo('comments');
        }
        $com['id'] = $i;
        $com['title'] = '<a href="'.XOOPS_URL.'/modules/'.$modules[$mid]->getVar('dirname').'/'.$comment_config[$mid]['pageName'].'?'.$comment_config[$mid]['itemName'].'='.$comments[$i]->getVar('com_itemid').'&amp;com_id='.$i.'&amp;com_rootid='.$comments[$i]->getVar('com_rootid').'&amp;'.htmlspecialchars($comments[$i]->getVar('com_exparams')).'#comment'.$i.'">'.$comments[$i]->getVar('com_title').'</a>';
        $com['icon'] = htmlspecialchars( $comments[$i]->getVar('com_icon'), ENT_QUOTES );
        $com['icon'] = ($com['icon'] != '') ? $com['icon'] : 'icon1.gif';
        $com['time'] = formatTimestamp($comments[$i]->getVar('com_created'),'m');
        if ($comments[$i]->getVar('com_uid') > 0) {
            $poster =& $member_handler->getUser($comments[$i]->getVar('com_uid'));
            if (is_object($poster)) {
                $com['poster'] = '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$comments[$i]->getVar('com_uid').'">'.$poster->getVar('uname').'</a>';
            } else {
                $com['poster'] = $GLOBALS['xoopsConfig']['anonymous'];
            }
        } else {
            $com['poster'] = $GLOBALS['xoopsConfig']['anonymous'];
        }
        $block['comments'][] =& $com;
        unset($com);
    }
    return $block;
}


function b_mycomments_edit($options)
{
    $inputtag = "<input type='text' name='options[]' value='".intval($options[0])."' />";
    $form = sprintf(_MB_MYCOM_DISPLAYC, $inputtag);
    return $form;
}

function b_mycomments2_show($options)
{
    global $xoopsUser;
    include_once XOOPS_ROOT_PATH.'/modules/mycomments/include/comment_constants.php';
    $limit = 10; // If you  are not getting suficient results, please increase a little more this number
    $block = $comment_config = $trackedItems = array();

    $comment_handler =& xoops_getmodulehandler('comment','mycomments');
    $moduleperm_handler =& xoops_gethandler('groupperm');
    $member_handler =& xoops_gethandler('member');
    $module_handler =& xoops_gethandler('module');

    $criteria = new CriteriaCompo(new Criteria('com_status', MYCOM_ACTIVE));
    $criteria->setLimit(intval($options[0] * $limit));
    $criteria->setSort('com_created');
    $criteria->setOrder('DESC');

    $comments = $comment_handler->getObjects($criteria, true);
    $modules = $module_handler->getObjects(new Criteria('hascomments', 1), true);

    $count = 0;
    foreach (array_keys($comments) as $i) {
        if ( $count == $options[0])  continue;
        $mid = $comments[$i]->getVar('com_modid');

        if ($xoopsUser) {
            if (!$moduleperm_handler->checkRight('module_read', $mid, $xoopsUser->getGroups())) {
                continue;
            }
        } else {
            if (!$moduleperm_handler->checkRight('module_read', $mid, XOOPS_GROUP_ANONYMOUS)) {
                continue;
            }
        }

        $com['module'] = '<a href="'.XOOPS_URL.'/modules/'.$modules[$mid]->getVar('dirname').'/">'.$modules[$mid]->getVar('name').'</a>';
        if (!isset($comment_config[$mid])) {
            $comment_config[$mid] = $modules[$mid]->getInfo('comments');
        }
        $com['id'] = $i;
        $com['title'] = '<a href="'.XOOPS_URL.'/modules/'.$modules[$mid]->getVar('dirname').'/'.$comment_config[$mid]['pageName'].'?'.$comment_config[$mid]['itemName'].'='.$comments[$i]->getVar('com_itemid').'&com_id='.$i.'&com_rootid='.$comments[$i]->getVar('com_rootid').'&'.htmlspecialchars($comments[$i]->getVar('com_exparams')).'#comment'.$i.'">'.$comments[$i]->getVar('com_title').'</a>';
        $com['icon'] = htmlspecialchars( $comments[$i]->getVar('com_icon'), ENT_QUOTES );
        $com['icon'] = ($com['icon'] != '') ? $com['icon'] : 'icon1.gif';
        $com['time'] = formatTimestamp($comments[$i]->getVar('com_created'),'m');
        if ($comments[$i]->getVar('com_uid') > 0) {
            $poster =& $member_handler->getUser($comments[$i]->getVar('com_uid'));
            if (is_object($poster)) {
                $com['poster'] = '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$comments[$i]->getVar('com_uid').'">'.$poster->getVar('uname').'</a>';
            } else {
                $com['poster'] = $GLOBALS['xoopsConfig']['anonymous'];
            }
        } else {
            $com['poster'] = $GLOBALS['xoopsConfig']['anonymous'];
        }
        if (count($trackedItems) > 0) {
            $itemMatch = false;
            foreach (array_keys($trackedItems) as $j) {
                if ($comments[$i]->getVar('com_modid') == $trackedItems[$j]['modid'] && $comments[$i]->getVar('com_itemid') == $trackedItems[$j]['itemid']) {
                    $itemMatch = true;
                }
            }
            if (!$itemMatch) {
                $block['comments'][] =& $com;
                $trackedItems[] = array('modid' => $comments[$i]->getVar('com_modid'), 'itemid' => $comments[$i]->getVar('com_itemid') );
                $count++;
            }
        } else {
            $block['comments'][] =& $com;
            $trackedItems[] = array('modid' => $comments[$i]->getVar('com_modid'), 'itemid' => $comments[$i]->getVar('com_itemid') );
            $count++;
        }
        unset($com);
    }
    return $block;
}

function b_mycomments2_edit($options)
{
    $inputtag = "<input type='text' name='options[]' value='".intval($options[0])."' />";
    $form = sprintf(_MB_MYCOM_DISPLAYC, $inputtag);
    return $form;
}
?>
