<?php
/**
 * Article module for XOOPS
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code 
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         article
 * @since           1.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: form.article.config.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined("XOOPS_ROOT_PATH")) exit();

if (!is_object($form_art)) {
    die("No form declared");
}
$form_art_elements = array();


$form_art_elements["full"] = !empty($form_element["active"]) ? array_keys($form_element["active"]) :
    array(
        "form_mode",        // Form mode
        "art_title",        // Article title
        "uid",                // User ID for submitter
        "art_summary",        // Article summary
        "subtitle",            // Subtitle for a page
        "editor",            // Editor selection box
        "text",                // Article body
        "text_options",        // Options for article body display
        "page",                // Multipage manipulation
        "writer_id",        // Original author
        "art_source",        // Original source
        "art_keywords",        // Keywords or tags for the article
        //"attachment",        // Attachments, not used yet
        "art_image",        // Article spot image
        "art_template",        // Article template
        "cat_id",            // Basic category
        "category",            // Extra categories to register to
        "topic",            // Topics to register to
        "art_forum",        // Newbb forum board for discussing the article 
        "art_elinks",        // External relevant links
        "trackbacks",        // URL to send trackback
        "notify",            // Notification for approval of the article
        "approved",            // Approve the article, admin only
        "update_time",        // Update publish time, admin only
    );

$form_art_elements["basic"] = 
    // Comment out any of the fields to be hidden
    // Elements will be sorted according to the order here
    array(
        "form_mode",        // Form mode
        "art_title",        // Article title
        //"uid",                // User ID for submitter
        "art_summary",        // Article summary
        //"subtitle",            // Subtitle for a page
        //"editor",            // Editor selection box
        "text",                // Article body
        "text_options",        // Options for article body display
        //"page",                // Multipage manipulation
        //"writer_id",        // Original author
        //"art_source",        // Original source
        "art_keywords",        // Keywords or tags for the article
        //"attachment",        // Attachments, not used yet
        //"art_image",        // Article spot image
        //"art_template",        // Article template
        "cat_id",            // Basic category
        //"category",            // Extra categories to register to
        //"topic",            // Topics to register to
        //"art_forum",        // Newbb forum board for discussing the article 
        //"art_elinks",        // External relevant links
        //"trackbacks",        // URL to send trackback
        "notify",            // Notification for approval of the article
        "approved",            // Approve the article, admin only
        //"update_time",        // Update publish time, admin only
    );
    

$form_art_elements["custom"] = 
    // Comment out any of the fields to be hidden
    // Elements will be sorted according to the order here
    array(
        "form_mode",        // Form mode
        "art_title",        // Article title
        "uid",                // User ID for submitter
        "art_summary",        // Article summary
        "subtitle",            // Subtitle for a page
        "editor",            // Editor selection box
        "text",                // Article body
        "text_options",        // Options for article body display
        "page",                // Multipage manipulation
        "writer_id",        // Original author
        "art_source",        // Original source
        "art_keywords",        // Keywords or tags for the article
        //"attachment",        // Attachments, not used yet
        "art_image",        // Article spot image
        "art_template",        // Article template
        "cat_id",            // Basic category
        "category",            // Extra categories to register to
        //"topic",            // Topics to register to
        "art_forum",        // Newbb forum board for discussing the article 
        //"art_elinks",        // External relevant links
        //"trackbacks",        // URL to send trackback
        "notify",            // Notification for approval of the article
        "approved",            // Approve the article, admin only
        "update_time",        // Update publish time, admin only
    );
    
?>