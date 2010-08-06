<?php
// $Id: searchform.php 2 2005-11-02 18:23:29Z skalpa $
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
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

//load scripts
if (!defined('MYSEARCH_INCLUDED')) {
    define('MYSEARCH_INCLUDED', '1');
    if (@is_object($xoTheme)) {
        $xoTheme->addStylesheet(XOOPS_URL.'/modules/mysearch/css/style.css');
        $xoTheme->addScript(XOOPS_URL.'/modules/mysearch/js/scriptaculous/lib/prototype.js');
        $xoTheme->addScript(XOOPS_URL.'/modules/mysearch/js/scriptaculous/src/scriptaculous.js');
    } else {
        $xoopsTpl->assign( 'xoops_module_header' , '<link rel="stylesheet" type="text/css" href="'.XOOPS_URL.'/modules/mysearch/css/style.css" /><script type="text/javascript" src="'.XOOPS_URL.'/modules/mysearch/js/scriptaculous/lib/prototype.js"></script><script type="text/javascript" src="'.XOOPS_URL.'/modules/mysearch/js/scriptaculous/src/scriptaculous.js"></script>'. @$xoopsTpl->get_template_vars("xoops_module_header") );
    }
}

// create form
$search_form = new XoopsThemeForm(_MA_MYSEARCH_SEARCH, "ajaxsearchform", "search.php", 'get');

// create form elements

$search_form->addElement(new XoopsFormLabel(_MA_MYSEARCH_KEYWORDS,'
<input type="text" id="autocomplete_2" name="query" size="14" value="'.htmlspecialchars(stripslashes(implode(" ", $queries))).'"/>
<span id="indicator2" style="display: none"><img src="'.XOOPS_URL.'/modules/mysearch/images/ajax-loader.gif" alt="'._MB_MYSEARCH_AJAX_WORKING.'" /></span>
<div id="autocomplete_choices_2" class="autocomplete"></div>
<script type="text/javascript">
new Ajax.Autocompleter("autocomplete_2", "autocomplete_choices_2", "'.XOOPS_URL.'/modules/mysearch/include/ajax_updater.php", {indicator: \'indicator2\',minChars: 2});
</script>'));
$type_select = new XoopsFormSelect(_MA_MYSEARCH_TYPE, "andor", $andor);
$type_select->addOptionArray(array("AND"=>_MA_MYSEARCH_ALL, "OR"=>_MA_MYSEARCH_ANY, "exact"=>_MA_MYSEARCH_EXACT));
$search_form->addElement($type_select);
if (!empty($mids)) {
    $mods_checkbox = new XoopsFormCheckBox(_MA_MYSEARCH_SEARCHIN, "mids[]", $mids);
} else {
    $mods_checkbox = new XoopsFormCheckBox(_MA_MYSEARCH_SEARCHIN, "mids[]", $mid);
}
if (empty($modules)) {
    $criteria = new CriteriaCompo();
    $criteria->add(new Criteria('hassearch', 1));
    $criteria->add(new Criteria('isactive', 1));
    if (!empty($available_modules)) {
        $criteria->add(new Criteria('mid', "(".implode(',', $available_modules).")", 'IN'));
    }
    $module_handler =& xoops_gethandler('module');
    $mods_checkbox->addOptionArray($module_handler->getList($criteria));
}
else {
    foreach ($modules as $mid => $module) {
        $module_array[$mid] = $module->getVar('name');
    }
    $mods_checkbox->addOptionArray($module_array);
}
$search_form->addElement($mods_checkbox);
if ($xoopsModuleConfig['keyword_min'] > 0) {
    $search_form->addElement(new XoopsFormLabel(_MA_MYSEARCH_SEARCHRULE, sprintf(_MA_MYSEARCH_KEYIGNORE, $xoopsModuleConfig['keyword_min'])));
}
$search_form->addElement(new XoopsFormHidden("action", "results"));
$search_form->addElement(new XoopsFormHiddenToken('id'));
$search_form->addElement(new XoopsFormButton("", "submit", _MA_MYSEARCH_SEARCH, "submit"));

return $search_form->render();	// Added by Lankford on 2007/7/26.
?>
