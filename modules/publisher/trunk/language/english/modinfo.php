<?php

/**
* $Id: modinfo.php 3195 2008-06-23 17:03:58Z xoops-magazine $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

// Module Info
// The name of this module

global $xoopsModule;

define("_MI_PUB_ADMENU1", "Index");
define("_MI_PUB_ADMENU2", "Categories");
define("_MI_PUB_ADMENU3", "Articles");
define("_MI_PUB_ADMENU4", "Permissions");
define("_MI_PUB_ADMENU5", "Blocks and Groups");
define("_MI_PUB_ADMENU6", "Mimetypes");
define("_MI_PUB_ADMENU7", "Go to module");

define("_MI_PUB_ADMINHITS", "[CONTENT OPTIONS] Admin counter reads?");
define("_MI_PUB_ADMINHITSDSC", "Allow admin hits for counter stats?");
define("_MI_PUB_ALLOWSUBMIT", "[PERMISSIONS] User submissions?");
define("_MI_PUB_ALLOWSUBMITDSC", "Allow users to submit articles on your website?");
define("_MI_PUB_ANONPOST", "[PERMISSIONS] Allow anonymous posting?");
define("_MI_PUB_ANONPOSTDSC", "Allow anonymous users to submit articles?");
define("_MI_PUB_AUTHOR_INFO", "Developers");
define("_MI_PUB_AUTHOR_WORD", "The Author's Word");
define("_MI_PUB_AUTOAPP", "[PERMISSIONS] Auto approve submitted articles?");
define("_MI_PUB_AUTOAPPDSC", "Auto approves submitted articles without admin intervention?");
define("_MI_PUB_BCRUMB","[PRINT OPTIONS] Show the module name in the breadcrumb?");
define("_MI_PUB_BCRUMBDSC","if you select yes, the breadcrumb will show \"Publisher > category name > article name\". <br>Otherwise, only \"category name > article name\" will be shown.");
define("_MI_PUB_BOTH_FOOTERS","Both footers");
define("_MI_PUB_BY", "by");
define("_MI_PUB_CATEGORY_ITEM_NOTIFY", "Category Items");
define("_MI_PUB_CATEGORY_ITEM_NOTIFY_DSC", "Notification options that apply to the current category.");
define("_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY", "New article published");
define("_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_CAP", "Notify me when a new article is published in the current category.");
define("_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_DSC", "Receive notification when a new article is published in the current category.");
define("_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New article published in category");
define("_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY", "'Article submitted");
define("_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_CAP", "Notify me when a new article is submitted in the current category.");
define("_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_DSC", "Receive notification when a new article is submitted in the current category.");
define("_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New article submitted in category");
define("_MI_PUB_CATLIST_IMG_W", "[FORMAT OPTIONS] Category list image width");
define("_MI_PUB_CATLIST_IMG_WDSC", "Specify the width of category images when listing the categories.");
define("_MI_PUB_CATMAINIMG_W", "[FORMAT OPTIONS] Category main image width");
define("_MI_PUB_CATMAINIMG_WDSC", "Specify the width of the category main image.");
define("_MI_PUB_CATPERPAGE", "[FORMAT OPTIONS] Maximum Categories per page (User side)?");
define("_MI_PUB_CATPERPAGEDSC", "Maximum number of top categories per page to be displayed at once in the user side?");
define("_MI_PUB_CLONE", "[PERMISSIONS] Allow article duplication ?");
define("_MI_PUB_CLONEDSC", "Select 'Yes' to allo users with appropriate permissions to duplicate an article.");
define("_MI_PUB_COLLHEAD", "[FORMAT OPTIONS] Display the collapsable bar?");
define("_MI_PUB_COLLHEADDSC", "if you set this option to 'Yes', the Categories summary will be displayed in a collapsable bar, as well as The articles. if you set this option to 'No', the collapsable will not be displayed.");
define("_MI_PUB_COMMENTS", "[PERMISSIONS] Control comments at the article level?");
define("_MI_PUB_COMMENTSDSC", "if you set this option to 'Yes', you'll see comments only on those items that have their comment checkbox marked. <br /><br />Select 'No' to have comments managed at the global level (look below under the tag 'Comment rules'.");
define("_MI_PUB_DATEFORMAT", "[FORMAT OPTIONS] Date format:");
define("_MI_PUB_DATEFORMATDSC", "Use the final part of language/english/global.php to select a display style. Example: \"d-M-Y H:i\" translates to \"30-Mar-2004 22:35\"");
define("_MI_PUB_DEMO_SITE", "SmartFactory Demo Site");
define("_MI_PUB_DEVELOPER_CONTRIBUTOR", "Contributor(s)");
define("_MI_PUB_DEVELOPER_CREDITS", "Credits");
define("_MI_PUB_DEVELOPER_EMAIL", "Email");
define("_MI_PUB_DEVELOPER_LEAD", "Lead developer(s)");
define("_MI_PUB_DEVELOPER_WEBSITE", "Website");
define("_MI_PUB_DISCOM", "[CONTENT OPTIONS] Display comment count?");
define("_MI_PUB_DISCOMDSC", "Set to 'Yes' to display the comments count in the individual article");
define("_MI_PUB_DISDATECOL", "[CONTENT OPTIONS] Display the 'Published on' column?");
define("_MI_PUB_DISDATECOLDSC", "When the 'Summary' display type is selected, select 'Yes' to display a 'Published on' date in the items table on the index and category page.");
define("_MI_PUB_DCS", "[CONTENT OPTIONS] Display the category summary?");
define("_MI_PUB_DCS_DSC", "Select 'No' to not display the Categoy summary on a category page that has no subcats.");
define("_MI_PUB_DISPLAY_CATEGORY", "Display the category name?");
define("_MI_PUB_DISPLAY_CATEGORY_DSC", "Set to 'Yes' to display the category link in the individual article");
define("_MI_PUB_DISPLAYTYPE_FULL", "Full View");
define("_MI_PUB_DISPLAYTYPE_LIST", "Bullet list");
define("_MI_PUB_DISPLAYTYPE_WFSECTION", "WFSection style");
define("_MI_PUB_DISPLAYTYPE_SUMMARY", "Summary View");
define("_MI_PUB_DISSBCATDSC", "[CONTENT OPTIONS] Display sub-categories description?");
define("_MI_PUB_DISSBCATDSCDSC", "Select 'Yes' to display the description of sub-categories in the index and category page.");
define("_MI_PUB_DISTYPE", "[FORMAT OPTIONS] Articles display type:");
define("_MI_PUB_DISTYPEDSC", "if 'Summary View' is selected, only the Title, Date and Hits of each item will be displayed in a selected category. if 'Full View' is selected, each article will be fully displayed in a selected category.");
define("_MI_PUB_FILEUPLOADDIR", "Attached files upload directory:");
define("_MI_PUB_FILEUPLOADDIRDSC", "Directory into which will be imported the files attached to the articles. Do not include any leading nor trailing slashes.");
define("_MI_PUB_FOOTERPRINT","[PRINT OPTIONS] Print page footer");
define("_MI_PUB_FOOTERPRINTDSC","Footer that will be printed for each article");
define("_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY", "New category");
define("_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_CAP", "Notify me when a new category is created.");
define("_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_DSC", "Receive notification when a new category is created.");
define("_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New category");
define("_MI_PUB_GLOBAL_ITEM_NOTIFY", "Global Articles");
define("_MI_PUB_GLOBAL_ITEM_NOTIFY_DSC", "Notification options that apply to all articles.");
define("_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY", "New article published");
define("_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_CAP", "Notify me when any new article is published.");
define("_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_DSC", "Receive notification when any new article is published.");
define("_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New article published");
define("_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY", "Article submitted");
define("_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_CAP", "Notify me when any article is submitted and is awaiting approval.");
define("_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_DSC", "Receive notification when any article is submitted and is waiting approval.");
define("_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New article submitted");
define("_MI_PUB_HEADERPRINT","[PRINT OPTIONS] Print page header");
define("_MI_PUB_HEADERPRINTDSC","Header that will be printed for each article");
define("_MI_PUB_HELP_CUSTOM", "Custom Path");
define("_MI_PUB_HELP_INSIDE", "Inside the module");
define("_MI_PUB_HELP_PATH_CUSTOM", "Custom path of Publisher's help files");
define("_MI_PUB_HELP_PATH_CUSTOM_DSC", "if you selected 'Custom path' in the previous option 'Path of Publisher's help files', please specify the URL of Publisher's help files, in that format : http://www.yoursite.com/doc");
define("_MI_PUB_HELP_PATH_SELECT", "Path of Publisher's help files");
define("_MI_PUB_HELP_PATH_SELECT_DSC", "Select from where you would like to access Publisher's help files. if you downloaded the 'Publisher's Help Package' and uploaded it in 'modules/publisher/doc/', you can select 'Inside the module'. Alternatively, you can access the module's help file directly from docs.xoops.org by chosing this in the selector. You can also select 'Custom Path' and specify yourself the path of the help files in the next config option 'Custom path of Publisher's help files'");
define("_MI_PUB_HITSCOL", "[CONTENT OPTIONS] Display the 'Hits' column?");
define("_MI_PUB_HITSCOLDSC", "When the 'Summary' display type is selected, select 'Yes' to display the 'Hits' column in the items table on the index and category page.");
define("_MI_PUB_HLCOLOR", "[FORMAT OPTIONS] Highlight color for keywords");
define("_MI_PUB_HLCOLORDSC", "Color of the keywords highligting for the search function");
define("_MI_PUB_IMAGENAV", "[FORMAT OPTIONS] Use the image Page Navigation:");
define("_MI_PUB_IMAGENAVDSC", "if you set this option to \"Yes\", the Page Navigation will be displayed with images, otherwise, the original Page Naviagation will be used.");
define("_MI_PUB_INDEXFOOTER","[CONTENT OPTIONS] Index Footer");
define("_MI_PUB_INDEXFOOTER_SEL","Index Footer");
define("_MI_PUB_INDEXFOOTERDSC","Footer that will be displayed at the index page of the module");
define("_MI_PUB_INDEXMSG", "[CONTENT OPTIONS] Index page welcome message:");
define("_MI_PUB_INDEXMSGDEF", "");
define("_MI_PUB_INDEXMSGDSC", "Welcome message to be displayed in the index page of the module.");
define("_MI_PUB_ITEM_APPROVED_NOTIFY", "Article approved");
define("_MI_PUB_ITEM_APPROVED_NOTIFY_CAP", "Notify me when this article is approved.");
define("_MI_PUB_ITEM_APPROVED_NOTIFY_DSC", "Receive notification when this article is approved.");
define("_MI_PUB_ITEM_APPROVED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : article approved");
define("_MI_PUB_ITEM_NOTIFY", "Article");
define("_MI_PUB_ITEM_NOTIFY_DSC", "Notification options that apply to the current article.");
define("_MI_PUB_ITEM_REJECTED_NOTIFY", "Article rejected");
define("_MI_PUB_ITEM_REJECTED_NOTIFY_CAP", "Notify me if this article is rejected.");
define("_MI_PUB_ITEM_REJECTED_NOTIFY_DSC", "Receive notification if this article is rejected.");
define("_MI_PUB_ITEM_REJECTED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : article rejected");
define("_MI_PUB_ITEM_TYPE", "Item type:");
define("_MI_PUB_ITEM_TYPEDSC", "Select the kind of items this module is going to manage.");
define("_MI_PUB_ITEMFOOTER", "[CONTENT OPTIONS] Item footer");
define("_MI_PUB_ITEMFOOTER_SEL", "Item footer");
define("_MI_PUB_ITEMFOOTERDSC","Footer that will be displayed for each article");
define("_MI_PUB_ITEMSMENU", "Categories Menu block");
//bd tree block hack
define("_MI_PUB_ITEMSTREE", "Tree block");
//--/bd
define("_MI_PUB_ITEMSNEW", "Recent items List");
define("_MI_PUB_ITEMSPOT", "In the Spotlight !");
define("_MI_PUB_ITEMSRANDOM_ITEM", "Random item !");
define("_MI_PUB_LASTITEM", "[CONTENT OPTIONS] Display last item column ?");
define("_MI_PUB_LASTITEMDSC", "Select 'Yes' to display the last item in each category in the index and category page.");
define("_MI_PUB_LASTITEMS", "[CONTENT OPTIONS] Display the list of newly published articles?");
define("_MI_PUB_LASTITEMSDSC", "Select 'Yes' to have the list at the bottom of the first page of the module");
define("_MI_PUB_LASTITSIZE", "[FORMAT OPTIONS] Last item size :");
define("_MI_PUB_LASTITSIZEDSC", "Set the maximum size of the title in the Last item column.");
define("_MI_PUB_LINKPATH", "[FORMAT OPTIONS] Enable links on the current path:");
define("_MI_PUB_LINKPATHDSC", "This option allows the user back-track by clicking on a element of the current path displayed on the top of the page");
define("_MI_PUB_MAX_HEIGHT", "[PERMISSIONS] Maximum uploaded image height");
define("_MI_PUB_MAX_HEIGHTDSC", "Maximum height of an image file that can be uploaded.");
define("_MI_PUB_MAX_SIZE", "[PERMISSIONS] Maximum file size");
define("_MI_PUB_MAX_SIZEDSC", "Maximum size (in bytes) of a file that can be uploaded.");
define("_MI_PUB_MAX_WIDTH", "[PERMISSIONS] Maximum uploaded image width");
define("_MI_PUB_MAX_WIDTHDSC", "Maximum width of an image file that can be uploaded.");
define("_MI_PUB_MD_DESC", "Section Management System for your XOOPS Site");
define("_MI_PUB_MD_NAME", "Publisher");
define("_MI_PUB_MODULE_BUG", "Report a bug for this module");
define("_MI_PUB_MODULE_DEMO", "Demo Site");
define("_MI_PUB_MODULE_DISCLAIMER", "Disclaimer");
define("_MI_PUB_MODULE_FEATURE", "Suggest a new feature for this module");
define("_MI_PUB_MODULE_INFO", "Module Development details");
define("_MI_PUB_MODULE_RELEASE_DATE", "Release date");
define("_MI_PUB_MODULE_STATUS", "Status");
define("_MI_PUB_MODULE_SUBMIT_BUG", "Submit a bug");
define("_MI_PUB_MODULE_SUBMIT_FEATURE", "Submit a feature request");
define("_MI_PUB_MODULE_SUPPORT", "Official support site");
define("_MI_PUB_NO_FOOTERS","None");
define("_MI_PUB_ORDERBY", "[FORMAT OPTIONS] Sort order");
define("_MI_PUB_ORDERBY_DATE", "Date DESC");
define("_MI_PUB_ORDERBY_TITLE", "Title ASC");
define("_MI_PUB_ORDERBY_WEIGHT", "Weight ASC");
define("_MI_PUB_ORDERBYDSC", "Select the sort order of the items throughout the module.");
define("_MI_PUB_OTHER_ITEMS_TYPE_ALL", "All articles");
define("_MI_PUB_OTHER_ITEMS_TYPE_NONE", "None");
define("_MI_PUB_OTHER_ITEMS_TYPE_PREVIOUS_NEXT", "Previous and next article");
define("_MI_PUB_OTHERITEMS", "[FORMAT OPTIONS] Other articles display type");
define("_MI_PUB_OTHERITEMSDSC", "Select how you would like to display the other articles of the category in the article page.");
define("_MI_PUB_PERPAGE", "[FORMAT OPTIONS] Maximum articles per page (Admin side):");
define("_MI_PUB_PERPAGEDSC", "Maximum number of articles per page to be displayed at once in the admin side.");
define("_MI_PUB_PERPAGEINDEX", "[FORMAT OPTIONS] Maximum articles per page (User side):");
define("_MI_PUB_PERPAGEINDEXDSC", "[PRINT OPTIONS] Maximum number of articles per page to be displayed together in the user side.");
define("_MI_PUB_PRINTLOGOURL","[PRINT OPTIONS] Logo print url");
define("_MI_PUB_PRINTLOGOURLDSC","Url of the logo that will be printed at the top of the page");
define("_MI_PUB_RECENTITEMS", "Recent items (Detail)");
define("_MI_PUB_SHOW_RSS","[CONTENT OPTIONS] Show link for RSS feed");
define("_MI_PUB_SHOW_RSSDSC","");
define("_MI_PUB_SHOW_SUBCATS", "[CONTENT OPTIONS] Display sub categories");
define("_MI_PUB_SHOW_SUBCATS_ALL", "Display all subcategories");
define("_MI_PUB_SHOW_SUBCATS_DSC", "Select if you want to display the sub categories in the categories list of the index and category page of the module");
define("_MI_PUB_SHOW_SUBCATS_NO", "Do not display sub-categories");
define("_MI_PUB_SHOW_SUBCATS_NOTEMPTY", "Display non empty sub-categories");
define("_MI_PUB_SUB_SMNAME1", "Submit an article");
define("_MI_PUB_SUB_SMNAME2", "Popular articles");
define("_MI_PUB_SUBMITMSG", "[CONTENT OPTIONS] Submit page intro message:");
define("_MI_PUB_SUBMITMSGDEF", "");
define("_MI_PUB_SUBMITMSGDSC", "Intro message to be displayed in the submit page of the module.");
define("_MI_PUB_TITLE_SIZE", "[FORMAT OPTIONS] Title size :");
define("_MI_PUB_TITLE_SIZEDSC", "Set the maximum size of the title in the single item display page.");
define("_MI_PUB_UPLOAD", "[PERMISSIONS] User file upload?");
define("_MI_PUB_UPLOADDSC", "Allow users to upload files linked to articles on your website?");
define("_MI_PUB_USEREALNAME", "[FORMAT OPTIONS] Use the Real Name of users");
define("_MI_PUB_USEREALNAMEDSC", "When displaying a username, use the real name of that user if he has a set his real name.");
define("_MI_PUB_VERSION_HISTORY", "Version History");
define("_MI_PUB_WARNING_BETA", "This module comes as is, without any guarantees whatsoever. This module is BETA, meaning it is still under active development. This release is meant for <b>testing purposes only</b> and we <b>strongly</b> recommend that you do not use it on a live website or in a production environment.");
define("_MI_PUB_WARNING_FINAL", "This module comes as is, without any guarantees whatsoever. Although this module is not beta, it is still under active development. This release can be used in a live website or a production environment, but its use is under your own responsibility, which means the author is not responsible.");
define("_MI_PUB_WARNING_RC", "This module comes as is, without any guarantees whatsoever. This module is a Release Candidate and should not be used on a production web site. The module is still under active development and its use is under your own responsibility, which means the author is not responsible.");
define("_MI_PUB_WELCOME", "[CONTENT OPTIONS] Display the welcome title and message:");
define("_MI_PUB_WELCOMEDSC", "if this option is set to 'Yes', the module index page will display the title 'Welcome in the Publisher of...', followed by the welcome message defined below. if this option is set to 'No', none of these lines will be displayed.");
define("_MI_PUB_WHOWHEN", "[CONTENT OPTIONS] Display the poster and date?");
define("_MI_PUB_WHOWHENDSC", "Set to 'Yes' to display the poster and date information in the individual article");
define("_MI_PUB_WYSIWYG", "[FORMAT OPTIONS] Editor type");
define("_MI_PUB_WYSIWYGDSC", "What kind of editor would you like  to use. Please note that of you choose any other editor than the DHTML-Editor, it must be installed on your site.");

define("_MI_PUB_PV_TEXT", "Partial view message");
define("_MI_PUB_PV_TEXTDSC", "Message for articles that allows only partial view.");
define("_MI_PUB_PV_TEXT_DEF", "To view the complete article, you must register.");

define("_MI_PUB_SEOMODNAME", "URL Rewriting module name");
define("_MI_PUB_SEOMODNAMEDSC", "if URL Rewriting is enabled for the module, this is the name of the module that will be used. For example : http://yoursite.com/smartection/...");

define("_MI_PUB_ARTCOUNT", "Display articles count");
define("_MI_PUB_ARTCOUNTDSC", "Select 'Yes' to display the article count within each category in the Category summary table. Please note that the module currently only count articles within each category and does not count within subcategoies.");

define("_MI_PUB_LATESTFILES", "Latest uploaded files");

define("_MI_PUB_PATHSEARCH", "[FORMAT OPTIONS] Display category path in search results");
define("_MI_PUB_PATHSEARCHDSC", "");
define("_MI_PUB_SHOW_SUBCATS_NOMAIN", "Display sub-categories on index page only");
define("_MI_PUB_RATING_ENABLED", "Enable rating system");
define("_MI_PUB_RATING_ENABLEDDSC", "This features requires the SmartObject Framework");

define("_MI_PUB_DISPBREAD", "Display the breadcrumb");
define("_MI_PUB_DISPBREADDSC", "Breadcrumb navigation displays the current page's context within the site structure.");

define('_MI_PUB_DATE_TO_DATE', 'Articles from date to date')
?>