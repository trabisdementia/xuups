<?php
// Module Info
// The name of this module
define("_MI_MYINVITER_MD_NAME", "My inviter");
define("_MI_MYINVITER_MD_DESC", "My inviter is a module that allows users to invite friends directly form their provider contacts list");

//Menu
define("_MI_MYINVITER_ADMENU_INDEX", "Index");
define("_MI_MYINVITER_ADMENU_ABOUT", "About");

//Templates desc
define("_MI_MYINVITER_PAGE_INDEX", "Index page");
define("_MI_MYINVITER_PAGE_ABOUT", "About page");

//Blocks
define("_MI_MYINVITER_BLK_ADD", "Invite your friends to join us!");
define("_MI_MYINVITER_BLK_ADD_DSC", "Block for sending invitations");

//Configs
define("_MI_MYINVITER_CONF_SANDBOX", "EMAIL - Use Sandox");
define("_MI_MYINVITER_CONF_SANDBOX_DSC", "Set to yes if you want to test the module first");

define("_MI_MYINVITER_CONF_SANDBOXEMAIL", "EMAIL - Sandbox email");
define("_MI_MYINVITER_CONF_SANDBOXEMAIL_DSC", "All invitations will be sent to this email (if using 'Sandbox')");

define("_MI_MYINVITER_CONF_HTML", "EMAIL - Send HTML emails");
define("_MI_MYINVITER_CONF_HTML_DSC", "Set 'yes' to use the HTML template.<br />Templates are located under 'language/country/mail_template'");

define("_MI_MYINVITER_CONF_EMAILSPERPACK", "EMAIL - Emails per Package");
define("_MI_MYINVITER_CONF_EMAILSPERPACK_DSC", "Number of emails to send at a given time period");

define("_MI_MYINVITER_CONF_TIMEBPACKS", "EMAIL - Time between Packages");
define("_MI_MYINVITER_CONF_TIMEBPACKS_DSC", "Choose time in seconds. One hour = 3600");

define("_MI_MYINVITER_CONF_FROMNAME", "EMAIL - From name");
define("_MI_MYINVITER_CONF_FROMNAME_DSC", "You may use this field to use a 'custom' name");

define("_MI_MYINVITER_CONF_FROMEMAIL", "EMAIL - From email");
define("_MI_MYINVITER_CONF_FROMEMAIL_DSC", "You may use this field to use a 'custom' email");

define("_MI_MYINVITER_CONF_FROM", "EMAIL - From option");
define("_MI_MYINVITER_CONF_FROM_DSC", "Select what 'name' and 'email' to be used on email header (reply-to)");
define("_MI_MYINVITER_CONF_FROM_CUSTOM", "Custom (has given above)");
define("_MI_MYINVITER_CONF_FROM_SYSTEM", "System (default settings)");
define("_MI_MYINVITER_CONF_FROM_USER", "Inviter (name and email)");

define("_MI_MYINVITER_CONF_DEFAULTUID", "EMAIL - Default user id");
define("_MI_MYINVITER_CONF_DEFAULTUID_DSC", "If you are allowing anonymous users to send invitations, then you must set this with an available user id.<br /> The invitation email will be populated with this user info.");

//07/09/2011

define("_MI_MYINVITER_CONF_SUBJECT", "EMAIL - Subject");
define("_MI_MYINVITER_CONF_SUBJECT_DSC", "Please enter the subject you would like to use for email invitations<br />%s stands for the inviter name");
define("_MI_MYINVITER_CONF_SUBJECT_DEF", "You have received an invitation from %s!");

define("_MI_MYINVITER_CONF_SOCIALSUBJECT", "SOCIAL - Invitation Subject");
define("_MI_MYINVITER_CONF_SOCIALSUBJECT_DSC", "Please enter the subject you would like to use for social invitations (tweets/facebook messages)");
define("_MI_MYINVITER_CONF_SOCIALSUBJECT_DEF", "Check this out!");

define("_MI_MYINVITER_CONF_SOCIALMESSAGE", "SOCIAL - Invitation Message");
define("_MI_MYINVITER_CONF_SOCIALMESSAGE_DSC", "Please enter the text you would like to use for social invitations (tweets/facebook messages)");
define("_MI_MYINVITER_CONF_SOCIALMESSAGE_DEF", "Hi there! Come visit me at " . XOOPS_URL . " . It will be fun, I promise!");

define("_MI_MYINVITER_CONF_GOOGLEURL", "CRAWLER - Google Url");
define("_MI_MYINVITER_CONF_GOOGLEURL_DSC", "Please enter the url we should crawl, you can change this for locale proposes(ie. replace www. with es.");
define("_MI_MYINVITER_CONF_GOOGLEURL_DEF", "http://www.google.com/m");

define("_MI_MYINVITER_CONF_YAHOOURL", "CRAWLER - Yahoo Url");
define("_MI_MYINVITER_CONF_YAHOOURL_DSC", "Please enter the url we should crawl, you can change this for locale proposes(ie. replace www. with es.");
define("_MI_MYINVITER_CONF_YAHOOURL_DEF", "http://search.yahoo.com");

define("_MI_MYINVITER_CONF_BINGURL", "CRAWLER - Bing Url");
define("_MI_MYINVITER_CONF_BINGURL_DSC", "Please enter the url we should crawl, you can change this for locale proposes(ie. replace www. with es.");
define("_MI_MYINVITER_CONF_BINGURL_DEF", "http://www.bing.com");

define("_MI_MYINVITER_CONF_PROVIDERS", "CRAWLER - Providers Select Box");
define("_MI_MYINVITER_CONF_PROVIDERS_DSC", "Please enter the email providers we should look for while crawling<br /> Please separate them with |");
define("_MI_MYINVITER_CONF_PROVIDERS_DEF", "hotmail|gmail|yahoo|msn|live|aol");

define("_MI_MYINVITER_CONF_AUTOCRAWL", "AUTOCRAWLER - Enable autocrawler?");
define("_MI_MYINVITER_CONF_AUTOCRAWL_DSC", "Auto crawler will grab emails without need of user intervention, you can create jobs on the text area bellow");

define("_MI_MYINVITER_CONF_AUTOCRAWLFOLDER", "AUTOCRAWLER - Autocrawler folder");
define("_MI_MYINVITER_CONF_AUTOCRAWLFOLDER_DSC", "Select the folder for autocrawler emails");
define("_MI_MYINVITER_CONF_WAITING", "Waiting");
define("_MI_MYINVITER_CONF_NOTSENT", "Not sent");

define("_MI_MYINVITER_CONF_AUTOCRAWLJOBS", "AUTOCRAWLER - Autocrawler jobs");
define("_MI_MYINVITER_CONF_AUTOCRAWLJOBS_DSC", "Enter one job at each line. The job should look like this:<br />Domain|Provider|NumberOfPagesToCrawl|SecondsBetweenCrawls<br />site1.com|gmail|5|3600<br />site2.com|yahoo|10|1800<br /><br /> Notice that we will only do one job and one page at a time, the system will cycle jobs and pages. Don't worry about server load!");

define("_MI_MYINVITER_CONF_HOOK", "GENERAL - Hook method");
define("_MI_MYINVITER_CONF_HOOK_DSC", "You can either use cron or preload to execute jobs(crawler and email sending.<br />We recommend you to set a cron job in your server admin panel. Preload will work for testing proposes but will slow page rendering, your users will complain!");
define("_MI_MYINVITER_CONF_PRELOAD", "Preload");
define("_MI_MYINVITER_CONF_CRON", "Cron");

define("_MI_MYINVITER_CONF_CRONKEY", "GENERAL - Cron key");
define("_MI_MYINVITER_CONF_CRONKEY_DSC", "If you choose to use cron(which you should) you need to set a unique key to avoid DOS attacks<br />The cron job should be configured to request file modules/myinviter/cron.php?key=THEFOLLOWINGKEY");

define("_MI_MYINVITER_CONF_DEBUG", "GENERAL - Add debug info on 'extra' tab");
define("_MI_MYINVITER_CONF_DEBUG_DSC", "Allows extra debug info for developers (requires xoops debug to be active). use 'No' for better performance");
