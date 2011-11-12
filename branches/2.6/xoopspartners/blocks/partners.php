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

function b_xoopspartners_show($options)
{
    global $xoopsDB;
    $myts =& MyTextSanitizer::getInstance();

    $block = array();
    $arrayIds = array();
    if (!empty($options[2])) {
        $arrayIds = xoopspartners_random($options[3]);
    } else {
        $arrayIds = xoopspartners_random($options[3], false, $options[5], $options[6]);
    }
    $block['xpDir'] = basename(dirname(dirname(__FILE__)));

    foreach (
        $arrayIds as $id
    ) {
        $result = $xoopsDB->query(
            "SELECT id, url, image, title, description FROM " . $xoopsDB->prefix("partners") . " WHERE id=$id"
        );
        list($id, $url, $image, $title, $description) = $xoopsDB->fetchrow($result);
        $url = $myts->htmlSpecialChars($url);
        $origtitle = $title;
        $title = $myts->htmlSpecialChars($title);
        $description = $myts->htmlSpecialChars($description);
        $image = $myts->htmlSpecialChars($image);
        if (strlen($origtitle) > 19) {
            $title = $myts->htmlSpecialChars(substr($origtitle, 0, 19)) . "...";
        }
        $partners['id'] = $id;
        $partners['url'] = $url;
        $partners['description'] = $description;
        if (!empty($image) && ($options[4] == 1 || $options[4] == 3)) {
            $partners['image'] = $image;
        }
        if (empty($image) || $options[4] == 2 || $options[4] == 3) {
            $partners['title'] = $title;
        } else {
            $partners['title'] = '';
        }
        $block['partners'][] = $partners;
    }
    if (1 == $options[0]) {
        $block['insertBr'] = true;
    }
    $block['fadeImage'] = (1 == $options[1]) ? true : false;
    /*
        if (1 == $options[1]) {
            $block['fadeImage'] = 'style="filter:alpha(opacity=20);" onmouseover="nereidFade(this, 100, 30, 5)" onmouseout="nereidFade(this, 50, 30, 5)"';
        }
    */
    return $block;
}

function xoopspartners_random($numberPartners, $random = true, $orden = "", $desc = "")
{
    global $xoopsDB;
    $partnersId = array();
    if ($random) {
        $result = $xoopsDB->query(
            "SELECT id FROM " . $xoopsDB->prefix("partners")
                . " WHERE status = 1 ORDER BY RAND() LIMIT {$numberPartners}"
        );
        $numrows = $xoopsDB->getRowsNum($result);
    } else {
        $result = $xoopsDB->query(
            "SELECT id FROM " . $xoopsDB->prefix("partners")
                . " WHERE status = 1 ORDER BY {$orden} {$desc}, LIMIT {$numberPartners}"
        );
    }
    while ($ret = $xoopsDB->fetchArray($result)) {
        $partnersId[] = $ret['id'];
    }
    return $partnersId;
    /*
    if (($numrows <= $numberPartners) || (!$random) ) {
      return $partnersId;
      exit();
    }
    $NumberTotal = 0;
    $TotalPartner = count($partnersId) - 1;
    while ($numberPartners > $NumberTotal) {
      $RandomPart = mt_rand (0, $TotalPartner);
      if  ( !in_array($partnersId[$RandomPart],$ArrayReturn) ) {
        $ArrayReturn[] = $partnersId[$RandomPart];
        $NumberTotal++;
      }
    }
    return $ArrayReturn;
    */
}

function b_xoopspartners_edit($options)
{
    if ($options[0] == 0) {
        $chk0no = " checked='checked'";
        $chk0yes = "";
    } else {
        $chk0no = "";
        $chk0yes = " checked='checked'";
    }
    if ($options[1] == 0) {
        $chk1no = " checked='checked'";
        $chk1yes = "";
    } else {
        $chk1no = "";
        $chk1yes = " checked='checked'";
    }
    if ($options[2] == 0) {
        $chk2no = " checked='checked'";
        $chk2yes = "";
    } else {
        $chk2no = "";
        $chk2yes = " checked='checked'";
    }
    $form
        =
        "<table style='border-width: 0px;'>\n" . "  <tr>\n" . "    <td>" . _MB_XPARTNERS_PSPACE . "</td>\n" . "    <td>"
            . "<input type='radio' name='options[0]' value='0'{$chk0no} />" . _NO . ""
            . "<input type='radio' name='options[0]' value='1'{$chk0yes} />" . _YES . "" . "    </td>\n" . "  </tr>\n"
            . "  <tr>\n" . "    <td>" . _MB_XPARTNERS_FADE . "</td>\n" . "    <td>"
            . "<input type='radio' name='options[1]' value='0'{$chk1no} />" . _NO . ""
            . "<input type='radio' name='options[1]' value='1'{$chk1yes} />" . _YES . "</td>\n" . "  </tr>\n"
            . "  <tr>\n" . "    <td>" . _MB_XPARTNERS_BRAND . "</td>\n" . "     <td>"
            . "<input type='radio' name='options[2]' value='0'{$chk2no} />" . _NO . ""
            . "<input type='radio' name='options[2]' value='1'{$chk2yes} />" . _YES . "</td>\n" . "  </tr>\n"
            . "  <tr>\n" . "    <td>" . _MB_XPARTNERS_BLIMIT . "</td>\n"
            . "    <td><input type='text' name='options[3]' size='16' value='{$options[3]}' /></td>\n" . "  </tr>\n"
            . "  <tr>\n" . "    <td>" . _MB_XPARTNERS_BSHOW . "</td>\n" . "    <td>\n"
            . "      <select size='1' name='options[4]'>\n";
    $sel = "";
    if (1 == $options[4]) {
        $sel = " selected='selected'";
    }
    $form .= "        <option value='1'{$sel}>" . _MB_XPARTNERS_IMAGES . "</option>\n";
    $sel = "";
    if (2 == $options[4]) {
        $sel = " selected='selected'";
    }
    $form .= "        <option value='2'{$sel}>" . _MB_XPARTNERS_TEXT . "</option>\n";
    $sel = "";
    if (3 == $options[4]) {
        $sel = " selected='selected'";
    }
    $form
        .= "        <option value='3'{$sel}>" . _MB_XPARTNERS_BOTH . "</option>\n" . "      </select>\n" . "    </td>\n"
        . "  </tr>\n" . "  <tr>\n" . "    <td>" . _MB_XPARTNERS_BORDER . "</td>\n" . "    <td>\n"
        . "      <select size='1' name='options[5]'>";
    $sel = "";
    if ('id' == $options[5]) {
        $sel = " selected='selected'";
    }
    $form .= "        <option value='id'{$sel}>" . _MB_XPARTNERS_ID . "</option>\n";
    $sel = "";
    if ('hits' == $options[5]) {
        $sel = " selected='selected'";
    }
    $form .= "        <option value='hits'{$sel}>" . _MB_XPARTNERS_HITS . "</option>\n";
    $sel = "";
    if ('title' == $options[5]) {
        $sel = " selected='selected'";
    }
    $form .= "        <option value='title'{$sel}>" . _MB_XPARTNERS_TITLE . "</option>\n";
    if ($options[5] == "weight") {
        $sel = " selected='selected'";
    }
    $form .= "        <option value='weight'{$sel}>" . _MB_XPARTNERS_WEIGHT . "</option>\n" . "      </select>\n"
        . "      <select size='1' name='options[6]'>\n";
    $sel = "";
    if ('ASC' == $options[6]) {
        $sel = " selected='selected'";
    }
    $form .= "        <option value='ASC'{$sel}>" . _MB_XPARTNERS_ASC . "</option>\n";
    $sel = "";
    if ('DESC' == $options[6]) {
        $sel = " selected='selected'";
    }
    $form
        .=
        "        <option value='DESC'{$sel}>" . _MB_XPARTNERS_DESC . "</option>\n" . "      </select>\n" . "    </td>\n"
            . "  </tr>\n" . "</table>\n";
    return $form;
}