<?php
// $Id: main.php,v 1.1.1.1 2005/11/10 19:51:19 phppp Exp $
// _LANGCODE: en
// _CHARSET : ISO-8859-1
// Translator: D.J., http://xoopsforge.com, http://xoops.org.cn

if (!defined('XOOPS_ROOT_PATH')){ exit(); }

$current_path = __FILE__;
if ( DIRECTORY_SEPARATOR != "/" ) $current_path = str_replace( strpos( $current_path, "\\\\", 2 ) ? "\\\\" : DIRECTORY_SEPARATOR, "/", $current_path);
$url_arr = explode("/",strstr($current_path,"/modules/"));
include XOOPS_ROOT_PATH."/modules/".$url_arr[2]."/include/vars.php";

if(defined($GLOBALS["ART_VAR_PREFIXU"]."_LANG_EN_MAIN")) return; define($GLOBALS["ART_VAR_PREFIXU"]."_LANG_EN_MAIN",1);


define($GLOBALS["ART_VAR_PREFIXU"]."_MD_INVALID","Invalid action");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_NOACCESS","No access");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TEXTEMPTY","Text is empty");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_INSERTERROR","Insert error");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_NEWARTICLE","New Article");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TITLE","Title");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_AUTHOR","Author");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SUMMARY","Summary");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_BODY","Text body");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SORTBY","Sort");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SAVED","Data saved");;
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SUBMITED","Submitted");;

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ALREADYRATED","You have already rated");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_NOTSAVED","Not saved");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_CPARTICLE","Article Cpanel");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ACTIONDONE","Action succeeded");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_CPCATEGORY","Category Cpanel");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_CPTOPIC","Topic Cpanel");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_CPTRACKBACK","Trackback Cpanel");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_EMAIL","Email");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_EMAILADDRESS","Email address");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_CONTENT","Content");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ARTICLE","Article");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_CATEGORY","Category");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_INDEX","Index");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_DISCLAIMER","Disclaimer");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SUBTITLE","Subtitle");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_KEYWORDS","Keywords");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_EDNOTE","Editor's Note");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_DATE","Date");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ERROROCCURED","Error occured");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_USERNAME","Username");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SELECTFEED","Select feed type");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_XMLDESC_ARTICLE","Article XML");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SOURCE","Source");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_XMLDESC_CATEGORY","XML for category %s");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_XMLDESC_AUTHOR","XML for author %s");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_XMLDESC_INDEX","XML for index page");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_PROFILE","Author profile");
//define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SELECT_EDITOR","Select editor");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TEXT","Text");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_EDITPAGE_NO","Page No. %d");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_NEWPAGE","New page");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_EDITPAGE","Multipage edit");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_EDITPAGE_DESC","");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_EDITPAGE_TEXT","Page text");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SUMMARY_DESC","Summary desc");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SUMMARY_DESC_TEXT","");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_KEYWORDS_DESC","Keywords dec");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_KEYWORDS_DESC_TEXT","");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_EDNOTE_DESC","Editor's Note desc");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_EDNOTE_DESC_TEXT","");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_FORUM","Forum");
/*
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_BLOG","Blog");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_PDF","Pdf");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_PRINT","Print");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_BOOKMARK","Bookmark");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_DC","DC");
*/
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TRACKBACKS","Trackback");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TEMPLATE_SELECT","Select template");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_CATEGORY_BASE","Basic category");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ELINKS","Related links");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ELINKS_DESC","Links desc");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ELINKS_DESC_TEXT","");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TRACKBACKS_DESC","Trackback desc");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TRACKBACKS_DESC_TEXT","");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_NOTIFY_ON_APPROVAL","Notify of approval");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_PUBLISH_ARTICLE","Publish");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SAVE","Save");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SAVE_DRAFT","Save draft");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SAVE_EDIT","Save and edit");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_DELETE_PAGE","Delete page");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_DELETE_ARTICLE","Delete article");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_DELETE_ARTICLE_CONFIRM","Are you sure to delete the article?");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_MODERATOR_REMOVE","Remove moderator");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_MODERATOR_ADD","Add moderator");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_DESCRIPTION","Description");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ORDER","Order");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SPONSOR","Sponsors URL and name");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SPONSOR_DESC","Sponsor dec");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SPONSOR_DESC_TEXT","");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_IMAGE_UPLOAD","Upload image");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_IMAGE_SELECT","Select image");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TOPIC","Topic");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_FROMLASTDAYS","From last %d days");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_FROMLASTHOURS","From last %d hours");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_THELASTYEAR","In the last year");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_BEGINNING","From the beginning");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_RSS","RSS");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_RDF","RDF");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ATOM","ATOM");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_OPML","OPML");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_CPANEL","CPANEL");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ARTICLES","Articles");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ADDARTICLE","Add article");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_MODERATOR","Moderator");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_MYARTICLES","My Page");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_STATS","Stats");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_FEATURED","Featured");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TOPICS","Topics");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SUBMITTED","Submitted");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_PUBLISHED","Published");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_CREATED","Created");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_REGISTERED","Registered");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_REGULAR", "Regular");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_CATEGORIES","Categories");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SUBTITLES","Subtitles");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_PAGES","Pages");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_URL","URL");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TRACKBACK","Trackback");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SUBMITTER","Submitter");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_VIEWS","Views");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_RATE","Rate");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_RATEIT","Rate it!");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_RESETRATE","Reset rate");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TIME", "Time");
//define($GLOBALS["ART_VAR_PREFIXU"]."_MD_PDF_PAGE", "Page %s");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_PREVIOUS", "<<");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_NEXT", ">>");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TEXTOPTIONS",'Text options');
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_DOHTML",'Enable html tags');
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_DOSMILEY",'Enable Smiley');
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_DOXCODE",'Enable Xoops Code');
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_DOBR",'Enable line break (Suggest to turn off if HTML enabled)');

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SPONSORS", "Sponsors");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TIME_CREATE", "Created");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TIME_EXPIRE", "Expire");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TYPES", "Types");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_NAME", "Name");
//define($GLOBALS["ART_VAR_PREFIXU"]."_MD_BIO", "Biography");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_FORMMODE", "Form mode");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_BASIC", "Basic");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ADVANCE", "Advanced");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_CUSTOM", "Custom");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_INVALID_SUBMIT","Invalid submission. You could have exceeded session time. Please make a backup and resubmit.");

//define($GLOBALS["ART_VAR_PREFIXU"]."_MD_KEYWORD_ON", "Keyword on");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SUBCATEGORIES","Subcategories");

//define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TAG_LIST","Tag List");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ACTIVE","Active");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_EXPIRED","Expired");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_APPROVED","Approved");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_DELETED","Deleted");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_PENDING","Pending");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_EXPIRATION","Expiration date");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_CREATION","Creation date");
//define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ADD","Add");
//define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SELECT","Select");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_APPROVE","Approve");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_FEATUREIT","Mark feature");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_UNFEATUREIT","Dismiss feature");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TERMINATE","Terminate");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_REGISTERTOPIC","Register topic");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ACTIONS","Actions");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SUBMISSION","Submission date");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_PUBLISH","Publish date");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_REGISTER","Register date");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_FEATURE","Featured date");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_HEADINGS","Headings");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_NOTES","Notes");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_FROM","From"); // Trackback

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_VIEWALL","View full text");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_COMMENTS","Comments");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_CLICKTOCOPY","Click to copy");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ACHIVE","Archive");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_MONTHLY","Monthly");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TIME_Y","%s"); // Year
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TIME_YM","%2\$s - %1\$s"); // Year - Month
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TIME_YMD","%1\$s - %2\$s - %3\$s"); // Year - Month - Day

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_MONTH_1","Jan");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_MONTH_2","Feb");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_MONTH_3","Mar");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_MONTH_4","Apr");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_MONTH_5","May");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_MONTH_6","Jun");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_MONTH_7","Jul");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_MONTH_8","Aug");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_MONTH_9","Sep");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_MONTH_10","Oct");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_MONTH_11","Nov");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_MONTH_12","Dec");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_WEEK_1","Mon");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_WEEK_2","Tue");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_WEEK_3","Wed");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_WEEK_4","Thu");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_WEEK_5","Fri");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_WEEK_6","Sat");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_WEEK_7","Sun");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_IMAGE_CAPTION", "Image caption");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_IMAGE_CURRENT", "Current image");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SPOTLIGHT", "Spotlight");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_LIST", "Article list");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_DRAFTS", "Drafts");

/*
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TRANSFER", "Transfer");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TRANSFER_DESC", "Transfer the article to other applications");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_TRANSFER_DONE","The action is done successully: %s");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SELECTEDITOR","Select editor");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_REQUIRED", "Required");
*/
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_REMOVE", "Remove");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SAVE_BEFORE_SWITCH", "Save before switching to another page");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_NEWPAGE_AVAILABLE", "Once save the first page, you can add more pages");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_MOVE_CATEGORYANDARTICLE", "All its subcategories and articles will be moved to its parent category.");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_DELETE_CATEGORYANDARTICLE", "All its subcategories and articles will be DELETED from database.");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_CONFIG_CATEGORYANDARTICLE", "The configuration can be changed from article/include/plugin.php \$GLOBALS[\"xoopsModuleConfig\"][\"category_delete_forced\"]");

//define($GLOBALS["ART_VAR_PREFIXU"]."_MD_CATEGORY1_CAN_NOT_DELETE", "The category with cat_id=1 is not allowed to delete");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_PARENT_CATEGORY", "Parent category");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ENTRY_SELECT", "Select entry article");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ARTICLE_SELECT", "Select article");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_DEFAULT", "Default");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_DESC", "DESC");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_ASC", "ASC");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_SORTORDER", "Sort by %1\$s in %2\$s"); // sort, order

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_UPDATE_TIME", "Update time");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_IMAGE_ARTICLE", "Article spotlight image");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_IMAGE_UPLOADED", "Uploaded image");

define($GLOBALS["ART_VAR_PREFIXU"]."_MD_HELP", "Help");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_HELP_PUBLISH_ARTICLE", "Save current contents and submit to publish (Approval may be required subject to permissions)");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_HELP_SAVE", "Save current contents");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_HELP_SAVE_EDIT", "Save current contents and return to the edit page (To publish the article, if not published yet, it is required to submit to publich)");
define($GLOBALS["ART_VAR_PREFIXU"]."_MD_HELP_SAVE_DRAFT", "Save current article as private draft (Only accessible to author himself, will be deleted on expiration)");

?>