<?php
/**
 * Name: admin.php
 * Description: Xoops FAQ module admin language defines
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package : XOOPS
 * @Module : Xoops FAQ
 * @subpackage : Module Language
 * @since 2.3.0
 * @author John Neill
 * @version $Id$
 */
defined( 'XOOPS_ROOT_PATH' ) or die( 'Restricted access' );

/**
 * Icons
 */
define( '_XO_LA_EDIT', 'Edit Item' );
define( '_XO_LA_DELETE', 'Delete Item' );

define( '_AM_XOOPSFAQ_CREATENEW', 'Create New Item' );
define( '_AM_XOOPSFAQ_MODIFYITEM', 'Modify Item: %s' );

/**
 * Content
 */
//define( '_AM_XOOPSFAQ_CONTENTS_HEADER', 'FAQ Content Management' );
//define( '_AM_XOOPSFAQ_CONTENTS_SUBHEADER', '' );
define( '_AM_XOOPSFAQ_CONTENTS_LIST_DSC', '' );
define( '_AM_XOOPSFAQ_CONTENTS_ID', '#' );
define( '_AM_XOOPSFAQ_CONTENTS_TITLE', 'Content Title' );
define( '_AM_XOOPSFAQ_CONTENTS_WEIGHT', 'Weight' );
define( '_AM_XOOPSFAQ_CONTENTS_PUBLISH', 'Published' );
define( '_AM_XOOPSFAQ_CONTENTS_ACTIVE', 'Active' );
define( '_AM_XOOPSFAQ_ACTIONS', 'Actions' );
define( '_AM_XOOPSFAQ_E_CONTENTS_CATEGORY', 'Content Category:' );
define( '_AM_XOOPSFAQ_E_CONTENTS_CATEGORY_DSC', 'Select a category you wish this item to be placed under' );
define( '_AM_XOOPSFAQ_E_CONTENTS_TITLE', 'Content Title:' );
define( '_AM_XOOPSFAQ_E_CONTENTS_TITLE_DSC', 'Enter a title for this item.' );
define( '_AM_XOOPSFAQ_E_CONTENTS_CONTENT', 'Content Body:' );
define( '_AM_XOOPSFAQ_E_CONTENTS_CONTENT_DSC', '' );
define( '_AM_XOOPSFAQ_E_CONTENTS_PUBLISH', 'Content Time:' );
define( '_AM_XOOPSFAQ_E_CONTENTS_PUBLISH_DSC', 'Select the date for the publish date' );
define( '_AM_XOOPSFAQ_E_CONTENTS_WEIGHT', 'Content Weight:' );
define( '_AM_XOOPSFAQ_E_CONTENTS_WEIGHT_DSC', 'Enter a value for the item order. ' );
define( '_AM_XOOPSFAQ_E_CONTENTS_ACTIVE', 'Content Active:' );
define( '_AM_XOOPSFAQ_E_CONTENTS_ACTIVE_DSC', 'Select whether this item will be hidden or not' );
define( '_AM_XOOPSFAQ_E_DOHTML', 'Show as HTML' );
define( '_AM_XOOPSFAQ_E_BREAKS', 'Convert Linebreaks to Xoops breaks' );
define( '_AM_XOOPSFAQ_E_DOIMAGE', 'Show Xoops Images' );
define( '_AM_XOOPSFAQ_E_DOXCODE', 'Show Xoops Codes' );
define( '_AM_XOOPSFAQ_E_DOSMILEY', 'Show Xoops Smilies' );

/**
 * Category
 */
//define( '_XO_LA_ADDCAT', 'Add Category' );
define( '_AM_XOOPSFAQ_CATEGORY_HEADER', 'Faq Category Management' );
//define( '_AM_XOOPSFAQ_CATEGORY_SUBHEADER', '' );
define( '_AM_XOOPSFAQ_CATEGORY_DELETE_DSC', 'Delete Check! You are about to delete this item. You can cancel this action by clicking on the cancel button or you can choose to continue.<br /><br />This action is not reversible.' );
define( '_AM_XOOPSFAQ_CATEGORY_EDIT_DSC', 'Edit Mode: You can edit item properties here. Click the submit button to make your changes permanent or click Cancel to return you were you where.' );
define( '_AM_XOOPSFAQ_CATEGORY_LIST_DSC', '' );
define( '_AM_XOOPSFAQ_CATEGORY_ID', '#' );
define( '_AM_XOOPSFAQ_CATEGORY_TITLE', 'Category Title' );
define( '_AM_XOOPSFAQ_CATEGORY_WEIGHT', 'Weight' );
//define( '_XO_LA_ACTIONS', 'Actions' );
define( '_AM_XOOPSFAQ_E_CATEGORY_TITLE', 'Category Title:' );
define( '_AM_XOOPSFAQ_E_CATEGORY_TITLE_DSC', '' );
define( '_AM_XOOPSFAQ_E_CATEGORY_WEIGHT', 'Category Weight:' );
define( '_AM_XOOPSFAQ_E_CATEGORY_WEIGHT_DSC', '' );

/**
 * Buttons
 */
//define( '_XO_LA_CREATENEW', 'Create New' );
define( '_AM_XOOPSFAQ_NOLISTING', 'No Items Found' );

/**
 * Database and error
 */
define( '_AM_XOOPSFAQ_SUBERROR', 'We have encountered an Error<br />' );
define( '_AM_XOOPSFAQ_RUSURECAT', 'Are you sure you want to delete this category and all of its FAQ?' );
define( '_AM_XOOPSFAQ_DBSUCCESS', 'Database Updated Successfully!' );
define( '_AM_XOOPSFAQ_ERRORNOCATEGORY', 'Error: No category name given, please go back and enter a category name' );
define( '_AM_XOOPSFAQ_ERRORCOULDNOTADDCAT', 'Error: Could not add category to database.' );
define( '_AM_XOOPSFAQ_ERRORCOULDNOTDELCAT', 'Error: Could not delete requested category.' );
define( '_AM_XOOPSFAQ_ERRORCOULDNOTEDITCAT', 'Error: Could not edit requested item.' );
define( '_AM_XOOPSFAQ_ERRORCOULDNOTDELCONTENTS', 'Error: Could not delete FAQ contents.' );
define( '_AM_XOOPSFAQ_ERRORCOULDNOTUPCONTENTS', 'Error: Could not update FAQ contents.' );
define( '_AM_XOOPSFAQ_ERRORCOULDNOTADDCONTENTS', 'Error: Could not add FAQ contents.' );
define( '_AM_XOOPSFAQ_NOTHTINGTOSHOW', 'No Items To Display' );
define( '_AM_XOOPSFAQ_ERRORNOCAT', 'Error: There are no Categories created yet. Before you can create a new FAQ, you must create a Category first.' );

//1.22

// About.php
define("_AM_XOOPSFAQ_ABOUT_RELEASEDATE", "Released: ");
define("_AM_XOOPSFAQ_ABOUT_UPDATEDATE", "Updated: ");
define("_AM_XOOPSFAQ_ABOUT_AUTHOR", "Author: ");
define("_AM_XOOPSFAQ_ABOUT_CREDITS", "Credits: ");
define("_AM_XOOPSFAQ_ABOUT_LICENSE", "License: ");
define("_AM_XOOPSFAQ_ABOUT_MODULE_STATUS", "Status: ");
define("_AM_XOOPSFAQ_ABOUT_WEBSITE", "Website: ");
define("_AM_XOOPSFAQ_ABOUT_AUTHOR_NAME", "Author name: ");
define("_AM_XOOPSFAQ_ABOUT_CHANGELOG", "Change Log");
define("_AM_XOOPSFAQ_ABOUT_MODULE_INFO", "Module Info");
define("_AM_XOOPSFAQ_ABOUT_AUTHOR_INFO", "Author Info");
define("_AM_XOOPSFAQ_ABOUT_DESCRIPTION", "Description: ");

// Configuration
define("_AM_XOOPSFAQ_CONFIG_CHECK", "Configuration Check");
define("_AM_XOOPSFAQ_CONFIG_PHP", "Minimum PHP required: %s (your version is %s)");
define("_AM_XOOPSFAQ_CONFIG_XOOPS", "Minimum XOOPS required:  %s (your version is %s)");

define("_AM_XOOPSFAQ_ADMIN_PREFERENCES", "Settings");
define("_AM_XOOPSFAQ_ADMIN_INDEX_TXT1", "The XoopsFAQ module is used to create a list of Frequently Asked Questions (FAQs) for your website. It is typically used to create a list of common questions about your website, service or product(s), but you could use it to list questions and answers about anything really. FAQs can be organized into categories.");

// Text for Admin footer
define("_AM_XOOPSFAQ_ADMIN_FOOTER", "<div class='center smallsmall italic pad5'>XOOPS FAQ is maintained by the <a class='tooltip' rel='external' href='http://xoops.org/' title='Visit XOOPS Community'>XOOPS Community</a></div>");

//define('_AM_XOOPSFAQ_ADMIN_'," "); //