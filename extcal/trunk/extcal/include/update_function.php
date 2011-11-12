<?php

function xoops_module_update_extcal(&$xoopsModule, $oldVersion = null)
{

    if ($oldVersion < 204) {

        $db =& Database::getInstance();

        $sql = "ALTER TABLE `" . $db->prefix('extcal_event')
            . "` ADD `event_nbmember` tinyint(4) NOT NULL default '0' AFTER `event_submitdate` ;";
        $db->query($sql);

    }

    if ($oldVersion < 215) {

        $db =& Database::getInstance();

        $sql = "ALTER TABLE `" . $db->prefix('extcal_event')
            . "` CHANGE `event_approved` `event_approved` TINYINT( 1 ) NOT NULL DEFAULT '0' ;";
        $db->query($sql);

        $sql = "ALTER TABLE `" . $db->prefix('extcal_event')
            . "` ADD `event_isrecur` TINYINT( 1 ) NOT NULL AFTER `event_nbmember` ;";
        $db->query($sql);

        $sql = "ALTER TABLE `" . $db->prefix('extcal_event')
            . "` ADD `event_recur_rules` VARCHAR( 255 ) NOT NULL AFTER `event_isrecur` ";
        $db->query($sql);

        $sql = "ALTER TABLE `" . $db->prefix('extcal_event')
            . "` ADD `event_recur_start` INT( 11 ) NOT NULL AFTER `event_recur_rules` ;";
        $db->query($sql);

        $sql = "ALTER TABLE `" . $db->prefix('extcal_event')
            . "` ADD `event_recur_end` INT( 11 ) NOT NULL AFTER `event_recur_start` ;";
        $db->query($sql);

        $sql = "CREATE TABLE `" . $db->prefix('extcal_event')
            . "` (`eventnotmember_id` int(11) NOT NULL auto_increment,`event_id` int(11) NOT NULL default '0',`uid` int(11) NOT NULL default '0',PRIMARY KEY  (`eventnotmember_id`),UNIQUE KEY `eventnotmember` (`event_id`,`uid`)) COMMENT='eXtCal By Zoullou' ;";
        $db->query($sql);

        $sql = "CREATE TABLE `" . $db->prefix('extcal_file')
            . "` (`file_id` int(11) NOT NULL auto_increment,`file_name` varchar(255) NOT NULL,`file_nicename` varchar(255) NOT NULL,`file_mimetype` varchar(255) NOT NULL,`file_size` int(11) NOT NULL,`file_download` int(11) NOT NULL,`file_date` int(11) NOT NULL,`file_approved` tinyint(1) NOT NULL,`event_id` int(11) NOT NULL,`uid` int(11) NOT NULL,PRIMARY KEY  (`file_id`)) COMMENT='eXtCal By Zoullou' ;";
        $db->query($sql);

    }

    if ($oldVersion < 221) {
        // Create eXtCal upload directory if don't exist
        $dir = XOOPS_ROOT_PATH . "/uploads/extcal";
        if (!is_dir($dir)) {
            mkdir($dir);

            // Copy index.html files on uploads folders
            $indexFile = XOOPS_ROOT_PATH . "/modules/extcal/include/index.html";
            copy($indexFile, XOOPS_ROOT_PATH . "/uploads/extcal/index.html");
        }

        $db =& Database::getInstance();
        // Create who's not going table to fix bug. If the table exist, the query will faile
        $sql = "CREATE TABLE `" . $db->prefix('extcal_eventnotmember')
            . "` (`eventnotmember_id` int(11) NOT NULL auto_increment,`event_id` int(11) NOT NULL default '0',`uid` int(11) NOT NULL default '0',PRIMARY KEY  (`eventnotmember_id`),UNIQUE KEY `eventnotmember` (`event_id`,`uid`)) COMMENT='eXtCal By Zoullou' ;";
        $db->query($sql);
    }

    return true;
}
?>
