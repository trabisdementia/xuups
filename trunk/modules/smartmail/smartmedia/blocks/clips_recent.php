<?php

/**
 * $Id: clips_recent.php,v 1.3 2005/06/02 13:33:37 malanciault Exp $
 * Module: SmartMedia
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

function b_smartmedia_clips_recent_show($options)
{
    // This must contain the name of the folder in which reside SmartClient
    if( !defined("SMARTMEDIA_DIRNAME") ){
        define("SMARTMEDIA_DIRNAME", 'smartmedia');
    }
    include_once(XOOPS_ROOT_PATH."/modules/" . SMARTMEDIA_DIRNAME . "/include/common.php");

    //$max_clips = $options[0];
    $title_length = $options[0];
    $max_clips = $options[1];

    $clipsArray =& $smartmedia_clip_handler->getClipsFromAdmin(0, $max_clips, 'clips.created_date', 'DESC', 'all');

    If ($clipsArray) {
        foreach ($clipsArray as $clipArray) {
            $clip = array();
            $clip['itemlink'] = '<a href="' . SMARTMEDIA_URL . 'clip.php?categoryid=' . $clipArray['categoryid'] . '&folderid=' . $clipArray['folderid'] . '&clipid=' . $clipArray['clipid'] . '">' . $clipArray['title']. '</a>';
            $block['clips'][] = $clip;
            unset ($clip);
        }
    }

    $block['smartmedia_url'] = SMARTMEDIA_URL;

    return $block;
}

function b_smartmedia_clips_recent_edit($options)
{
    $form = "<table>";
    $form .= "<tr>";
    $form .= "<td>" . _MB_SMEDIA_TRUNCATE_TITLE . "</td>";
    $form .= "<td>" . "<input type='text' name='options[]' value='" . $options[0] . "' /></td>";
    $form .= "</tr>";
    $form .= "<tr>";
    $form .= "<td>" . _MB_SMEDIA_MAX_CLIPS . "</td>";
    $form .= "<td>" . "<input type='text' name='options[]' value='" . $options[1] . "' /></td>";
    $form .= "</tr>";
    $form .= "</table>";

    return $form;
}
?>