<?php
if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}

function smartblock_show($pageid, $tabid) {
    $block=array();
    $visblocks=array();

    $blocks = xoops_getmodulehandler('pageblock', 'mytabs')->getBlocks($pageid);
    $groups = $GLOBALS['xoopsUser'] ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS);

    foreach (array_keys($blocks) as $placement) {
        if ($placement == $tabid){
            foreach ($blocks[$placement] as $thisblock) {
                if($thisblock->isVisible() && array_intersect($thisblock->getVar('groups'), $groups)) {
                    $visblocks[]= $thisblock;
                }
            }
        }
    }

    $block['blocks']=array();
    for($i=0; $i < count($visblocks); $i++) {
        $logger_name = $visblocks[$i]->getVar('title')."(".$visblocks[$i]->getVar('pageblockid').")";
        $GLOBALS['xoopsLogger']->startTime($logger_name);
        $thisblock = $visblocks[$i]->render($GLOBALS['xoTheme']->template, $tabid.'_'.$visblocks[$i]->getVar('pageblockid'));
        if ($thisblock != false) {
            $block['blocks'][] = $thisblock;
        }
        $GLOBALS['xoopsLogger']->stopTime($logger_name);
    }

    return($block);
}

?>
