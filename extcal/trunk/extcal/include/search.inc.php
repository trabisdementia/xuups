<?php

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

function extcal_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsUser;

    $eventHandler = xoops_getmodulehandler('event', 'extcal');

    return $eventHandler->getSearchEvent($queryarray, $andor, $limit, $offset, $userid, $xoopsUser);

}
?>
