<?php

/**
 * $Id: comment_functions.php,v 1.1 2005/05/13 18:22:03 malanciault Exp $
 * Module: SmartMedia
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

function smartmedia_com_update($item_id, $total_num)
{
    $db = &Database::getInstance();
    $sql = 'UPDATE ' . $db->prefix('smartmedia_items') . ' SET comments = ' . $total_num . ' WHERE itemid = ' . $item_id;
    $db->query($sql);
}

function smartmedia_com_approve(&$comment)
{
    // notification mail here
}

?>