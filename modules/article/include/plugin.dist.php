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
 * @version         $Id: plugin.dist.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
// plugin guide:
/* 
 * Add customized configs, variables or functions
 */
$customConfig = array();
 
/* 
 * When a category is to be deleted, there are two options for its subcategories and articles:
 * A: true -- all subcategories and articles will be deleted from database
 * B: false -- all subcategories and articles will be moved to its parent category or (if no parent) the category of cat_id = 1
 *
 * TODO: there shall be an option for admin to choose a category to store subcategories and articles
 */
$customConfig["category_delete_forced"] = false;

/* image width of spotlight icon on index page, in px */
//$customConfig["image_width_spotlight"] = "100px";
/* image width of category icon on index page, in px */
//$customConfig["image_width_category"] = "80px";
/* image width of article icon on index page, in px */
//$customConfig["image_width_article"] = "100px";

// specification for custom time format
// default manner will be used if not specified
$customConfig["formatTimestamp_custom"] = ""; // Could be set as "Y-m-d H:i" 


// Set allowed editors 
$customConfig["editor_allowed"] = array();  // Could be set as array("FCKeditor", "koivi" or "textarea")

// Set the default editor
$customConfig["editor_default"] = ""; // Could be set as any of "FCKeditor", "koivi" and "textarea"

// default value for editor rows, coloumns 
$customConfig["editor_rows"] = 25;
$customConfig["editor_cols"] = 60;

// default value for editor width, height (string)
$customConfig["editor_width"] = "100%";
$customConfig["editor_height"] = "400px";


return $customConfig;
?>