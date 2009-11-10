<?php
//  ------------------------------------------------------------------------ //
//                       mysearch - MODULE FOR XOOPS 2                        //
//                  Copyright (c) 2005-2006 Instant Zero                     //
//                     <http://xoops.instant-zero.com/>                      //
// ------------------------------------------------------------------------- //
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

function b_mysearch_ajaxsearch_show()
{
    global $xoTheme;
    $xoTheme->addStylesheet(XOOPS_URL.'/modules/mysearch/css/style.css');
    $xoTheme->addScript(XOOPS_URL.'/modules/mysearch/js/scriptaculous/lib/prototype.js');
    $xoTheme->addScript(XOOPS_URL.'/modules/mysearch/js/scriptaculous/src/scriptaculous.js');
    $block = array("");
    $block['lang_search'] = _MB_MYSEARCH_SEARCH;
    $block['lang_advsearch'] = _MB_MYSEARCH_ADVS;
    return $block;
}
?>
