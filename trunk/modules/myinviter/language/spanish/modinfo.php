<?php
// Module Info
// The name of this module
define("_MI_MYINVITER_MD_NAME", "My inviter");
define("_MI_MYINVITER_MD_DESC", "My inviter is a module that allows users to invite friends directly form their provider contacts list");

//Menu
define("_MI_MYINVITER_ADMENU_INDEX", "Index");
define("_MI_MYINVITER_ADMENU_WAITING", "Waiting");
define("_MI_MYINVITER_ADMENU_BLACKLIST", "Blacklist");
define("_MI_MYINVITER_ADMENU_ABOUT", "About");

//Templates desc
define("_MI_MYINVITER_PAGE_INDEX", "Index page");
define("_MI_MYINVITER_PAGE_ABOUT", "About page");

//Blocks
define("_MI_MYINVITER_BLK_ADD", "Invite your friends to join us!");
define("_MI_MYINVITER_BLK_ADD_DSC", "Block for sending invitations");

//Configs
define("_MI_MYINVITER_CONF_SANDBOX", "Use Sandox");
define("_MI_MYINVITER_CONF_SANDBOX_DSC", "Set to yes if you want to test the module first");

define("_MI_MYINVITER_CONF_SANDBOXEMAIL", "Sandbox email");
define("_MI_MYINVITER_CONF_SANDBOXEMAIL_DSC", "All invitations will be sent to this email (if using 'Sandbox')");

define("_MI_MYINVITER_CONF_HTML", "Send HTML emails");
define("_MI_MYINVITER_CONF_HTML_DSC", "Set 'yes' to use the HTML template.<br />Templates are located under 'language/country/mail_template'");

define("_MI_MYINVITER_CONF_EMAILSPERPACK", "Emails per Package");
define("_MI_MYINVITER_CONF_EMAILSPERPACK_DSC", "Number of emails to send at a given time period");

define("_MI_MYINVITER_CONF_TIMEBPACKS", "Time between Packages");
define("_MI_MYINVITER_CONF_TIMEBPACKS_DSC", "Choose time in seconds. One hour = 3600");

define("_MI_MYINVITER_CONF_FROMNAME", "From name");
define("_MI_MYINVITER_CONF_FROMNAME_DSC", "You may use this field to use a 'custom' name");

define("_MI_MYINVITER_CONF_FROMEMAIL", "From email");
define("_MI_MYINVITER_CONF_FROMEMAIL_DSC", "You may use this field to use a 'custom' email");

define("_MI_MYINVITER_CONF_FROM", "From option");
define("_MI_MYINVITER_CONF_FROM_DSC", "Select what 'name' and 'email' to be used on email header (reply-to)");
define("_MI_MYINVITER_CONF_FROM_CUSTOM", "Custom (has given above)");
define("_MI_MYINVITER_CONF_FROM_SYSTEM", "System (default settings)");
define("_MI_MYINVITER_CONF_FROM_USER", "Inviter (name and email)");

define("_MI_MYINVITER_CONF_DEFAULTUID", "Default user id");
define("_MI_MYINVITER_CONF_DEFAULTUID_DSC", "If you are allowing anonymous users to send invitations, then you must set this with an available user id.<br /> The invitation email will be populated with this user info.");
?>
