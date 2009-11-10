<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}

function b_mytabs_block_show($options) {
    global $xoTheme, $xoopsTpl;
    $block = array();
    $vistabs = array();
    $pageid = $options[0];
    
    include_once(XOOPS_ROOT_PATH."/modules/mytabs/include/functions.php");

    $tab_handler = xoops_getmodulehandler('tab','mytabs');
    $criteria = new Criteria('tabpageid', $pageid);
    $criteria->setSort('tabpriority');
    $criteria->setOrder('ASC');
    $tabs = $tab_handler->getObjects($criteria);

    if (count($tabs) == 0) return $block;

    $groups = $GLOBALS['xoopsUser'] ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS);

    foreach ($tabs as $tab) {
        if($tab->isVisible() && array_intersect($tab->getVar('tabgroups'), $groups)) {
            $vistabs[] = $tab;
        }
    }

    $tabsmenu = '<ul>';
    $selected = 'class="selected"';
    $hascontent = false;
    $i = 0;
    foreach ($vistabs as $tab){
        $placements = array();
        $width = 0;
        $block['tabs'][$i]['id'] = $tab->getVar('tabid');
        $tab_blocks = mytabsblock_show($pageid, $tab->getVar('tabid'));

        foreach ($tab_blocks as $thisblock) {
            $block['tabs'][$i][$thisblock['placement']][] = $thisblock;
            $placements[$thisblock['placement']] = true;
        }
        
        $count = count($placements);
        $block['tabs'][$i]['width'] = ($count != 0) ? intval(100 / $count) : 100;
        
        //for the menu
        $link = $tab->getTabLink();
        $title = $tab->getTabTitle();
        if ($link != ''){
            $tabsmenu .= '<li><a href="'.$link.'">'.$title.'</a></li>';
            $hasmenu= true;
        } elseif ($count != 0) {
            $rev = ($tab->getVar('tabrev') != '') ? 'rev="'.$tab->getVar('tabrev').'"' : '';
            $tabsmenu .= '<li><a href="#" rel="tab_'.$tab->getVar('tabid').'_'.$options[6].'" '.$selected.' '.$rev.'>'.$title.'</a></li>';
            $selected = '';
            $hasmenu = true;
        }
        
        $i++;
    }
    if(!$hasmenu) return array();
    
    $tabsmenu .= '</ul><br style="clear: left" />';

    $block['tabsmenu'] = $tabsmenu;
    $block['width'] = $options[1];
    $block['height'] = $options[2];
    $block['class'] = $options[3];
    $block['persist'] = $options[4];
    $block['milisec'] = $options[5];
    $block['uniqueid'] = $options[6];
    $block['showblockstitle'] = $options[7];
    $block['onmouseover'] = $options[8];
    $block['placements'] = array('left', 'center', 'right');
    
    if (is_object($xoTheme)){
        $xoTheme->addStylesheet(XOOPS_URL.'/modules/mytabs/css/'.$options[3].'.css');
        $xoTheme->addScript(XOOPS_URL.'/modules/mytabs/jscript/tabcontent.js');
    } else {
        $xoopsTpl->assign( 'xoops_module_header' , '<link rel="stylesheet" type="text/css" media="screen" href="'.XOOPS_URL.'/modules/mytabs/css/'.$options[3].'.css" /><script type="text/javascript" src="'.XOOPS_URL.'/modules/mytabs/jscript/tabcontent.js"></script>'.$xoopsTpl->get_template_vars("xoops_module_header") );
    }

    return $block;
}

function b_mytabs_block_edit($options) {
    $criteria = new Criteria(1,1);
    $criteria->setSort('pagetitle');
    $criteria->setOrder('ASC');
    $page_handler = xoops_getmodulehandler('page', 'mytabs');
    $pages = $page_handler->getObjects($criteria);
    if(!$pages) {
        $form = "<a href='".XOOPS_URL."/modules/mytabs/admin/index.php'>"._MB_MYTABS_CREATEPAGEFIRST."</a>";
        return $form;
    }
    
    $form = "<b>"._MB_MYTABS_PAGE."</b>&nbsp;<select name='options[0]'>";
    foreach($pages as $page){
        $form .= "<option value='".$page->getVar('pageid')."'";
        if ( $options[0] == $page->getVar('pageid') ) {
            $form .= " selected='selected'";
        }
        $form .= '>'.$page->getVar('pagetitle')."</option>\n";
    }
    $form .= "</select>\n<br /><br />";
    
    $form .= "<b>"._MB_MYTABS_WIDTH."</b>&nbsp;<input type='text' name='options[1]' value='".$options[1]."'/>&nbsp;&nbsp;<i>"._MB_MYTABS_WIDTH_DSC."</i><br /><br />";
    $form .= "<b>"._MB_MYTABS_HEIGHT."</b>&nbsp;<input type='text' name='options[2]' value='".$options[2]."'/>&nbsp;&nbsp;<i>"._MB_MYTABS_HEIGHT_DSC."</i><br /><br />";

    include_once(XOOPS_ROOT_PATH."/class/xoopslists.php");
    $classes = XoopsLists::getFileListAsArray(XOOPS_ROOT_PATH."/modules/mytabs/css", "");
    $form .= "<b>"._MB_MYTABS_CLASS."</b>&nbsp;<select name='options[3]'>";
    foreach($classes as $class){
        if (preg_match("/[.css]$/",$class)) {
            $class = str_replace('.css' , '', $class);
            $form .= "<option value='".$class."'";
            if ( $options[3] == $class ) {
                $form .= " selected='selected'";
            }
            $form .= '>'.$class."</option>\n";
        }
    }
    $form .= "</select>\n&nbsp;&nbsp;<i>"._MB_MYTABS_CLASS_DSC."</i><br /><br />";
    
    $form .= "<b>"._MB_MYTABS_PERSIST."</b>&nbsp;<input type='radio' name='options[4]' value='true'";
    if ($options[4] == 'true') {
        $form .= " checked='checked'";
    }
    $form .= ' />'._YES;
    $form .= "<input type='radio' name='options[4]' value='false'";
    if ($options[4] == 'false') {
        $form .= " checked='checked'";
    }
    $form .= ' />'._NO.'&nbsp;&nbsp;<i>'._MB_MYTABS_PERSIST_DSC.'</i><br /><br />';

    $form .= "<b>"._MB_MYTABS_MILISEC."</b>&nbsp;<input type='text' name='options[5]' value='".$options[5]."'/>&nbsp;&nbsp;<i>"._MB_MYTABS_MILISEC_DSC."</i><br /><br />";

    if (!$options[6] || (isset($_GET['op']) && $_GET['op'] == 'clone')) $options[6] = time();
    $form .= "<b>"._MB_MYTABS_UNIQUEID."</b>&nbsp;<input type='text' name='options[6]' value='".$options[6]."'/>&nbsp;&nbsp;<i>"._MB_MYTABS_UNIQUEID_DSC."</i><br /><br />";
    
    $form .= "<b>"._MB_MYTABS_BLOCKSTITLE."</b>&nbsp;<input type='radio' name='options[7]' value='1'";
    if ($options[7] == '1') {
        $form .= " checked='checked'";
    }
    $form .= ' />'._YES;
    $form .= "<input type='radio' name='options[7]' value='0'";
    if ($options[7] == '0') {
        $form .= " checked='checked'";
    }
    $form .= ' />'._NO.'&nbsp;&nbsp;<i>'._MB_MYTABS_BLOCKSTITLE_DSC.'</i><br /><br />';
    
    $form .= "<b>"._MB_MYTABS_ONMOUSEOVER."</b>&nbsp;<input type='radio' name='options[8]' value='1'";
    if ($options[8] == '1') {
        $form .= " checked='checked'";
    }
    $form .= ' />'._YES;
    $form .= "<input type='radio' name='options[8]' value='0'";
    if ($options[8] == '0') {
        $form .= " checked='checked'";
    }
    $form .= ' />'._NO.'&nbsp;&nbsp;<i>'._MB_MYTABS_ONMOUSEOVER_DSC.'</i><br /><br />';
    
    return $form;
}
?>
