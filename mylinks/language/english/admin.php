<?php
// $Id$
//%%%%%%		Module Name 'MyLinks'		%%%%%

//3.1
$admin_mydirname = basename(dirname(dirname(dirname(__FILE__))));

// About.php
define("_AM_MYLINKS_ABOUT_AUTHOR", "Author: ");
define("_AM_MYLINKS_ABOUT_AUTHOR_INFO", "Author Info");
define("_AM_MYLINKS_ABOUT_AUTHOR_NAME", "Author name: ");
define("_AM_MYLINKS_ABOUT_CHANGELOG", "Change Log");
define("_AM_MYLINKS_ABOUT_CREDITS", "Credits: ");
define("_AM_MYLINKS_ABOUT_DESCRIPTION", "Description: ");
define("_AM_MYLINKS_ABOUT_LICENSE", "License: ");
define("_AM_MYLINKS_ABOUT_MODULE_INFO", "Module Info");
define("_AM_MYLINKS_ABOUT_MODULE_STATUS", "Status: ");
define("_AM_MYLINKS_ABOUT_OFFICIAL", "Official Module:");
define("_AM_MYLINKS_ABOUT_VERSION", "Version:");
define("_AM_MYLINKS_ABOUT_WEBSITE", "Website: ");
define("_AM_MYLINKS_ABOUT_RELEASEDATE", "Released: ");
define("_AM_MYLINKS_ABOUT_UPDATEDATE", "Updated: ");

// admin.php
define("_AM_MYLINKS_ADMIN_SYSTEM_CONFIG", "System Configuration");

// index.php
define("_AM_MYLINKS_ADMIN_INDEX", "Index");
define("_AM_MYLINKS_ADMIN_ABOUT", "About");
define("_AM_MYLINKS_ADMIN_HELP", "Help");
define("_AM_MYLINKS_ADMIN_PAGES", "Pages");
define("_AM_MYLINKS_ADMIN_UPDATE", "Update");
define("_AM_MYLINKS_ADMIN_PREFERENCES", "Settings");

// text in admin footer
define("_AM_MYLINKS_ADMIN_FOOTER", "<div class='right smallsmall italic pad5'><strong>{$admin_mydirname}</strong> is maintained by the <a class='tooltip' rel='external' href='http://xoops.org/' title='Visit XOOPS Community'>XOOPS Community</a></div>");

define('_MYLINKS_ADMIN_', " "); //

//myblocksadmin
define('_AM_MYLINKS_AGDS', "Admin Groups");
define('_AM_MYLINKS_BADMIN', "Blocks Admin");
define('_AM_MYLINKS_TITLE', "Title");
define('_AM_MYLINKS_SIDE', "Description");
define('_AM_MYLINKS_WEIGHT', "Weight");

define('_AM_MYLINKS_VISIBLEIN', "Visible in");
define('_AM_MYLINKS_BCACHETIME', "Cache Time");
define('_AM_MYLINKS_ACTION', "Action");
define('_AM_MYLINKS_ACTIVERIGHTS', "Submission Rights");
define('_AM_MYLINKS_ACCESSRIGHTS', "Access Rights");

//Template Admin
define('_AM_MYLINKS_TPLSETS', "Template Management");
define('_AM_MYLINKS_GENERATE', "Generate");
define('_AM_MYLINKS_FILENAME', "File Name");

//define("_MD_MYLINKS_ADMIN_FOOTER", "<div class='right smallsmall italic pad5'><strong>{$admin_mydirname}</strong> is maintained by the <a class='tooltip' rel='external' href='http://xoops.org/' title='Visit XOOPS Community'>XOOPS Community</a></div>");

// Configuration
define("_AM_MYLINKS_CONFIG_CHECK", "Configuration Check");
define("_AM_MYLINKS_CONFIG_PHP", "Minimum PHP required: %s (your version is %s)");
define("_AM_MYLINKS_CONFIG_XOOPS", "Minimum XOOPS required: %s (your version is %s)");

//main.php
define("_AM_MYLINKS_IGNORE", "Ignore");