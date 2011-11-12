<?php
/**
 * MyLinks - Module Info Definitions
 *
 * @version:: $Id$
 */

// The name of this module
define("_MI_MYLINKS_NAME", "My Links");

// A brief description of this module
define("_MI_MYLINKS_DESC", "Creates a web links section where users can search/submit/rate various web sites.");

// Names of blocks for this module (Not all module has blocks)
define("_MI_MYLINKS_BNAME1", "Recent Links");
define("_MI_MYLINKS_BNAME1DESC", "Shows recently added web links");
define("_MI_MYLINKS_BNAME2", "Top Links");
define("_MI_MYLINKS_BNAME2DESC", "Shows most visited web links");
define("_MI_MYLINKS_BNAME3", "Random Link");
define("_MI_MYLINKS_BNAME3DESC", "Shows a random link");
// Sub menu titles
define("_MI_MYLINKS_SMNAME1", "Submit");
define("_MI_MYLINKS_SMNAME2", "Popular");
define("_MI_MYLINKS_SMNAME3", "Top Rated");

// Names of admin menu items
define("_MI_MYLINKS_ADMENU2", "Add/Edit Links");
define("_MI_MYLINKS_ADMENU3", "Submitted Links");
define("_MI_MYLINKS_ADMENU4", "Broken Links");
define("_MI_MYLINKS_ADMENU5", "Modified Links");
define("_MI_MYLINKS_ADMENU6", "Permissions");
define("_MI_MYLINKS_ADMENU7", "Template Admin");

// Template Descriptions
define("_MI_MYLINKS_TPLDESC_BROKEN", "Broken Link Template");
define("_MI_MYLINKS_TPLDESC_LINK", "Link Template");
define("_MI_MYLINKS_TPLDESC_INDEX", "Module Index Template");
define("_MI_MYLINKS_TPLDESC_MODLINK", "Link Modification Template");
define("_MI_MYLINKS_TPLDESC_RATELINK", "Rate Link Template");
define("_MI_MYLINKS_TPLDESC_SINGLELINK", "Single Link Template");
define("_MI_MYLINKS_TPLDESC_SUBMIT", "Submit Link Template");
define("_MI_MYLINKS_TPLDESC_TOPTEN", "Top Ten Template");
define("_MI_MYLINKS_TPLDESC_VIEWCAT", "View Category Template");
define("_MI_MYLINKS_TPLDESC_ADMIN_INDEX", "Administration Index Template");
define("_MI_MYLINKS_TPLDESC_ADMIN_ABOUT", "Administration About Template");
define("_MI_MYLINKS_TPLDESC_ADMIN_HELP", "Administration Help Template");
define("_MI_MYLINKS_TPLDESC_SEARCHINC", "Search form include Template");

// Title of config items
define('_MI_MYLINKS_POPULAR', 'Select the number of hits for links to be marked as popular');
define('_MI_MYLINKS_NEWLINKS', 'Select the maximum number of new links displayed on top page');
define('_MI_MYLINKS_PERPAGE', 'Select the maximum number of links displayed in each page');
define('_MI_MYLINKS_USESHOTS', 'Display a screenshot image for each link');
define('_MI_MYLINKS_USEFRAMES', 'Would you like to display the linked page within a frame?');
define('_MI_MYLINKS_SHOTWIDTH', 'Maximum allowed width of each screenshot image (in pixels)');
define('_MI_MYLINKS_SHOTPROVIDER', 'Select the external screen shot provider');
define('_MI_MYLINKS_ANONPOST', 'Allow anonymous users to post links?');
define('_MI_MYLINKS_AUTOAPPROVE', 'Auto approve new links without admin intervention?');
define('_MI_MYLINKS_INCADMIN', 'Include administrator visits in hit counter results?');
define('_MI_MYLINKS_SHOWEXTRAFUNC', 'Show extra functionality in link display?');
define('_MI_MYLINKS_CANPRINT', 'Select which users can print links');
define('_MI_MYLINKS_CANPDF', 'Select which users can create PDF files');
define('_MI_MYLINKS_CANBOOKMARK', 'Select which users can create a bookmark');
define('_MI_MYLINKS_CANQRCODE', 'Select which users can create a qrcode (3D barcode)');
define('_MI_MYLINKS_SHOWLOGO', 'Display the module header logo?');
define('_MI_MYLINKS_SHOWXOOPSSEARCH', 'Enable XOOPS sitewide search form in module templates?');
define('_MI_MYLINKS_SHOWTOOLBAR', 'Display horizontal menu at top of module templates?');
define('_MI_MYLINKS_SHOWLETTERS', 'Display horizontal category letter hyperlink menu at top of module templates?');
define('_MI_MYLINKS_SHOWFEED', 'Display RSS/Atom feed icons?');
define('_MI_MYLINKS_SHOWSITEINFO', 'Show site statistics information?');

// Description of each config items
define('_MI_MYLINKS_POPULARDSC', '');
define('_MI_MYLINKS_NEWLINKSDSC', '');
define('_MI_MYLINKS_PERPAGEDSC', '');
define('_MI_MYLINKS_USEFRAMEDSC', '');
define('_MI_MYLINKS_USESHOTSDSC', '');
define('_MI_MYLINKS_SHOTWIDTHDSC', '');
define('_MI_MYLINKS_SHOTPROVIDERDSC', 'Provider for screen shots if images from image directory are not used.');
define('_MI_MYLINKS_AUTOAPPROVEDSC', '');
define('_MI_MYLINKS_INCADMINDSC', '');
define('_MI_MYLINKS_SHOWEXTRAFUNCDSC', 'Allow display of print, pdf, qrcode, bookmark options');
define('_MI_MYLINKS_CANPRINTDSC', '');
define('_MI_MYLINKS_CANPDFDSC', '');
define('_MI_MYLINKS_CANBOOKMARKDSC', '');
define('_MI_MYLINKS_CANQRCODEDSC', 'Note: QRCODE module must be installed for this option to function');
define('_MI_MYLINKS_SHOWLOGODSC', '');
define('_MI_MYLINKS_SHOWXOOPSSEARCHDSC', '');
define('_MI_MYLINKS_SHOWTOOLBARDSC', '');
define('_MI_MYLINKS_SHOWLETTERSDSC', '');
define('_MI_MYLINKS_SHOWFEEDDSC', '');
define('_MI_MYLINKS_SHOWSITEINFODSC', 'Show hyperlink menu to show Alexa, Archive, & Google stats');

// Values for config items
define('_MI_MYLINKS_DISALLOW', 0);
define('_MI_MYLINKS_ALLOW', 1);
define('_MI_MYLINKS_MEMBERONLY', 2);
define('_MI_MYLINKS_ALLOWDSC', 'Allow all users');
define('_MI_MYLINKS_DISALLOWDSC', 'Disallow all users');
define('_MI_MYLINKS_MEMBERONLYDSC', 'Registered users only');
define('_MI_MYLINKS_SHPROV0', 'Thumbshots.org');
define('_MI_MYLINKS_SHPROV1', 'Nemui.org');
define('_MI_MYLINKS_SHPROV0_VAL', 'http://open.thumbshots.org/image.pxf?url=');
define('_MI_MYLINKS_SHPROV1_VAL', 'http://mozshot.nemui.org/shot?');

// Text for notifications

define('_MI_MYLINKS_GLOBAL_NOTIFY', 'Global');
define('_MI_MYLINKS_GLOBAL_NOTIFYDSC', 'Global links notification options.');

define('_MI_MYLINKS_CATEGORY_NOTIFY', 'Category');
define('_MI_MYLINKS_CATEGORY_NOTIFYDSC', 'Notification options that apply to the current link category.');

define('_MI_MYLINKS_LINK_NOTIFY', 'Link');
define('_MI_MYLINKS_LINK_NOTIFYDSC', 'Notification options that aply to the current link.');

define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFY', 'New Category');
define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFYCAP', 'Notify me when a new link category is created.');
define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFYDSC', 'Receive notification when a new link category is created.');
define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New link category');

define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFY', 'Modify Link Requested');
define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFYCAP', 'Notify me of any link modification request.');
define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFYDSC', 'Receive notification when any link modification request is submitted.');
define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Link Modification Requested');

define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFY', 'Broken Link Submitted');
define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFYCAP', 'Notify me of any broken link report.');
define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFYDSC', 'Receive notification when any broken link report is submitted.');
define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Broken Link Reported');

define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFY', 'New Link Submitted');
define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFYCAP', 'Notify me when any new link is submitted (awaiting approval).');
define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFYDSC', 'Receive notification when any new link is submitted (awaiting approval).');
define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New link submitted');

define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFY', 'New Link');
define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFYCAP', 'Notify me when any new link is posted.');
define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFYDSC', 'Receive notification when any new link is posted.');
define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New link');

define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFY', 'New Link Submitted');
define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFYCAP', 'Notify me when a new link is submitted (awaiting approval) to the current category.');
define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFYDSC', 'Receive notification when a new link is submitted (awaiting approval) to the current category.');
define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New link submitted in category');

define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFY', 'New Link');
define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFYCAP', 'Notify me when a new link is posted to the current category.');
define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFYDSC', 'Receive notification when a new link is posted to the current category.');
define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New link in category');

define('_MI_MYLINKS_LINK_APPROVE_NOTIFY', 'Link Approved');
define('_MI_MYLINKS_LINK_APPROVE_NOTIFYCAP', 'Notify me when this link is approved.');
define('_MI_MYLINKS_LINK_APPROVE_NOTIFYDSC', 'Receive notification when this link is approved.');
define('_MI_MYLINKS_LINK_APPROVE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Link approved');

// index.php
define("_MYLINKS_ADMIN_HOME", "Home");
define("_MYLINKS_ADMIN_INDEX", "FAQ");
define("_MYLINKS_ADMIN_ABOUT", "About");
define("_MYLINKS_ADMIN_HELP", "Help");
define("_MYLINKS_ADMIN_SLIDES", "Slides");
define("_MYLINKS_ADMIN_PREFERENCES", "Preferences");


define("_MYLINKS_ADMIN_HOME_DESC", "Home");
define("_MI_MYLINKS_ADMENU2_DESC", "Add/Edit Links");
define("_MI_MYLINKS_ADMENU3_DESC", "Submitted Links");
define("_MI_MYLINKS_ADMENU4_DESC", "Broken Links");
define("_MI_MYLINKS_ADMENU5_DESC", "Modified Links");
define("_MI_MYLINKS_ADMENU6_DESC", "Blocks/Group Admin");
define("_MI_MYLINKS_ADMENU7_DESC", "Template Admin");
define("_MYLINKS_ADMIN_ABOUT_DESC", "Info About the Module");
define("_MYLINKS_ADMIN_HELP_DESC", "Help");

/**
 * Module Prefs
 */
define("_XO_MIF_MYLINKS_EDITORS", "Select Editor:");
define("_XO_MIF_MYLINKS_EDITORS_DSC", "Please select the editor you would like to use? <br />You maybe required to install an editor before you can use it.");