<?php
function b_smartblock_show($options) {
    $block=array();

    $blocks = xoops_getmodulehandler('pageblock', 'smartblocks')->getBlocks($options[0]);

    $visblocks=array();
    $groups = $GLOBALS['xoopsUser'] ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
    for($i=0; $i < count($blocks); $i++) {
        if($blocks[$i]->isVisible() && array_intersect($blocks[$i]->getVar('groups'), $groups)) {
            $visblocks[]=&$blocks[$i];
        }
    }

    $block['blocks']=array();
    for($i=0; $i < count($visblocks); $i++) {
        $logger_name = $visblocks[$i]->getVar('title')."(".$visblocks[$i]->getVar('pageblockid').")";
        $GLOBALS['xoopsLogger']->startTime($logger_name);
        $thisblock = $visblocks[$i]->render($GLOBALS['xoTheme']->template, $options[0].'_'.$visblocks[$i]->getVar('pageblockid'));
        if ($thisblock != false) {
            $block['blocks'][] = $thisblock;
        }
        $GLOBALS['xoopsLogger']->stopTime($logger_name);
    }

    return($block);
}

function b_smartblock_edit($options) {
    include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
    $placement = new XoopsFormHidden('options[0]', intval($options[0]));
    return $placement->render();
}
?>
