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
//  ------------------------------------------------------------------------ //
if (!defined('XOOPS_ROOT_PATH')) {
  die("Direct Access Denied");
}

$checked = (1 == $contents_visible) ? " checked='checked'" : '';

echo "<form action='index.php' method='post'>\n"
    ."  <table style='border-width: 0px; padding: 0px; margin: 0px; width: 100%;'>\n"
    ."    <tr>\n"
    ."      <td class='bg2'>\n"
    ."        <table style='width: 100%; border-width: 0px; padding: 4px; margin: 1px;'>\n"
    ."          <tr>\n"
    ."            <td nowrap='nowrap' class='bg3'>" . _XD_QUESTION . " </td>\n"
    ."            <td class='bg1'><input type='text' name='contents_title' value='{$contents_title}' size='31' maxlength='255' /></td>\n"
    ."          </tr>\n"
    ."          <tr>\n"
    ."            <td nowrap='nowrap' class='bg3'>" . _XD_ORDER . " </td>\n"
    ."            <td class='bg1'><input type='text' name='contents_order' value='".$contents_order."' size='4' maxlength='3' /></td>\n"
    ."          </tr>\n"
  ."          <tr>\n"
  ."            <td nowrap='nowrap' class='bg3'>" . _XD_DISPLAY . " </td>\n"
  ."            <td class='bg1'><input type='checkbox' name='contents_visible' value='1'{$checked} /></td>\n"
  ."          </tr>\n"
  ."          <tr>\n"
  ."            <td nowrap='nowrap' class='bg3'>" . _XD_ANSWER . " </td>\n"
  ."            <td class='bg1'>";

include_once XOOPS_ROOT_PATH."/include/xoopscodes.php";

xoopsCodeTarea("contents_contents", 60, 20);
xoopsSmilies("contents_contents");

$checked = " checked='checked'";
echo "<br /><input type='checkbox' name='contents_nohtml' value='1'{$checked} />"._XD_NOHTML."<br />";

$checked = (1 == $contents_nosmiley) ? " checked='checked'" : "";
echo "<input type='checkbox' name='contents_nosmiley' value='1'$checked />"._XD_NOSMILEY."<br />";

$checked = (1 == $contents_noxcode) ? " checked='checked'" : "";
echo "<input type='checkbox' name='contents_noxcode' value='1'$checked />"._XD_NOXCODE."</td>\n"
    ."          </tr>\n"
    ."          <tr>\n"
    ."            <td nowrap='nowrap' class='bg3'>&nbsp;</td>\n"
    ."            <td class='bg1'>\n"
    ."              <input type='hidden' name='category_id' value='{$category_id}' />\n"
    ."              <input type='hidden' name='contents_id' value='{$contents_id}' />\n"
    ."              <input type='hidden' name='op' value='{$op}' />\n"
    ."              <input type='submit' name='contents_preview' value='" . _PREVIEW . "' />&nbsp;\n"
    ."              <input type='submit' name='contents_submit' value='" . _SUBMIT . "' />\n"
    ."            </td>\n"
    ."          </tr>\n"
    ."        </table>\n"
    ."      </td>\n"
    ."    </tr>\n"
    ."  </table>\n"
    ."</form>\n";