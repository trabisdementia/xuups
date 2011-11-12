<?php
// $Id$
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
// ------------------------------------------------------------------------- //
// Author: Raul Recio (AKA UNFOR)                                            //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

include 'header.php';
$xoopsOption['template_main'] = 'xoopspartners_index.html';
include XOOPS_ROOT_PATH . '/header.php';

$moduleInfo =& $module_handler->get($xoopsModule->getVar('mid'));
$pathImageIcon = XOOPS_URL .'/'. $moduleInfo->getInfo('icons16');    


$start = (isset($_GET['start']) && (intval($_GET['start']) > 0)) ? intval($_GET['start']) : 0;

$xpPartnersHandler =& xoops_getmodulehandler('partners', $xoopsModule->getVar('dirname'));


$criteria = new CriteriaCompo();
$criteria->add(new Criteria('status', 1, '='));
$criteria->setOrder($xoopsModuleConfig['modorder']);
$criteria->setOrder($xoopsModuleConfig['modorderd']);
$criteria->setLimit($xoopsModuleConfig['modlimit']);

if (0 != $xoopsModuleConfig['modlimit']) {
    $init = ($start) ? $start : 0;
    $criteria->setStart($init);
}

$partnerFields = array('id', 'hits', 'url', 'image', 'title', 'description');
$partners = $xpPartnersHandler->getAll($criteria, $partnerFields, false, false);
$numPartners = count($partners);

if ($xoopsUser) {
    $xoopsTpl->assign(
        "partner_join",
        "<a href='join.php' title='" . _MD_XPARTNERS_JOIN . "'><strong>" . _MD_XPARTNERS_JOIN . "</strong></a>"
    );
}

$partnerCount = count($partners);
for (
    $i = 0; $i < $partnerCount; $i++
) {
    /**
     * $xoopsModuleConfig['modshow']
     *    = 1        images
     *    = 2        text
     *    = 3        both
     */
    switch ($xoopsModuleConfig['modshow']) {
        case 3: //both image and text
            $partners[$i]['image']
                = "<img src='" . $partners[$i]["image"] . "' alt='" . $partners[$i]["url"] . "' />" . "<br />"
                . $partners[$i]["title"];
            break;
        case 2: // text
            $partners[$i]['image'] = $partners[$i]["title"];
            break;
        case 1: // images
        default:
            if (empty($partners[$i]["image"])) {
                $partners[$i]['image'] = $partners[$i]["title"];
            } else {
                $partners[$i]['image']
                    = "<img src='" . $partners[$i]["image"] . "' alt='" . $partners[$i]["url"] . "' />";
            }
            break;
    }

    if ($xoopsUserIsAdmin) {
        $partners[$i]['admin_option']
            = "
            <a href='admin/main.php?op=editPartner&amp;id={$partners[$i]['id']}' title=''" . _EDIT
            . "><img src=". $pathImageIcon .'/edit.png'." alt='" . _EDIT . "' title='" . _EDIT
            . "' /></a>&nbsp;
            
            <a href='admin/main.php?op=delPartner&id={$partners[$i]['id']}' title=''" . _DELETE
            . "><img src=". $pathImageIcon .'/delete.png' ." alt='" . _DELETE . "' title='" . _DELETE 
            . "' /></a>"
            ;
    }
    $xoopsTpl->append("partners", $partners[$i]);
}

if (0 != intval($xoopsModuleConfig['modlimit'])) {
    $nav = new XoopsPageNav($numPartners, intval($xoopsModuleConfig['modlimit']), $start);
    $pagenav = $nav->renderImageNav();
}
$xoopsTpl->assign(
    array(
         "lang_partner" => _MD_XPARTNERS_PARTNER, "lang_desc" => _MD_XPARTNERS_DESCRIPTION, "lang_hits" => _MD_XPARTNERS_HITS, "lang_no_partners" => _MD_XPARTNERS_NOPART, "lang_main_partner" => _MD_XPARTNERS_PARTNERS, "sitename" => $xoopsConfig['sitename'], "pagenav" => $pagenav
    )
);
include_once XOOPS_ROOT_PATH . '/footer.php';