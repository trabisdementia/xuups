<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}

function mytabsblock_show($pageid, $tabid, $placement = '', $remove = '') {
    $block = array();
    $visblocks = array();

    $blocks_handler = xoops_getmodulehandler('pageblock', 'mytabs');
    $blocks = $blocks_handler->getBlocks($pageid, $tabid, $placement, $remove);
    
    $groups = $GLOBALS['xoopsUser'] ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS);

    foreach (array_keys($blocks) as $key) {
        foreach ($blocks[$key] as $thisblock) {
            if($thisblock->isVisible() && array_intersect($thisblock->getVar('groups'), $groups)) {
                $visblocks[] = $thisblock;
            }
        }
    }
    
    for($i=0; $i < count($visblocks); $i++) {
        $logger_name = $visblocks[$i]->getVar('title')."(".$visblocks[$i]->getVar('pageblockid').")";
        $GLOBALS['xoopsLogger']->startTime($logger_name);
        $thisblock = $visblocks[$i]->render($GLOBALS['xoopsTpl'], $tabid.'_'.$visblocks[$i]->getVar('pageblockid'));
        if ($thisblock != false) {
            if (strlen($thisblock['title']) > 0){
                if ($thisblock['title'][0] == '-') {
                    $thisblock['title'] = '';
                }
            }
            $block[] = $thisblock;
        }
        $GLOBALS['xoopsLogger']->stopTime($logger_name);

    }
    return $block;
}

function mytabs_getcms() {
    static $version = '';

    if ($version  == '') {
        if (defined("ICMS_VERSION_NAME")) {
            $version = 'ICMS';
        } elseif (substr( XOOPS_VERSION , 10 , 2 ) < 15  && substr( XOOPS_VERSION , 8 , 1 ) == 1 ) {
            $version = 'OLDXOOPS';
        }  elseif (strstr(XOOPS_VERSION, "XOOPS 2.2")) {
            $version = 'XOOPS22';
        }  else {
            $version = 'XOOPS';
        }
        
    }
    
    return $version;
}

?>
