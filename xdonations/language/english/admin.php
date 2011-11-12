<?php
/**
 * @version::   $Id$
 */
$xdonDir = basename ( dirname ( dirname ( dirname( __FILE__ ) ) ) ) ;
define ('_AD_DON_ADD',                            'Add');
define ('_AD_DON_ADD_ANYWAY',                     'Add user to Group/Rank if donating anonymously');
define ('_AD_DON_ALERTE_INPUT_NUMBER',            'Please enter a number for the &quot;&apos; + fieldLabel +&apos;&quot; field.');
define ('_AD_DON_ALERTE_INPUT_NUMBER_B',          'Please enter a number or a blank for the &quot;&apos; + fieldLabel +&apos;&quot; field.');
define ('_AD_DON_ALERTE_INPUT_STRING',            "Please enter a value for the &quot;%1\$s&quot; field.");
define ('_AD_DON_ALERTE_URL_FOR_CANCEL',          'There is no URL for a Cancelled payment.  If you do not enter'.'<br />'
                                                 .'a URL for cancelled payments PayPal will also use'.'<br />'
                                                 .'this URL for cancelled payments.');

define ('_AD_DON_AMOUNT',                         'Amount');
define ('_AD_DON_AMOUNT_DEFAULT',                 'Which donation amount below'.'<br />'
                                                 .'is checked by default?');

define ('_AD_DON_BUTTON_URL',                     'https://www.paypal.com/en_US/i/btn/x-click-but21.gif');
define ('_AD_DON_CLEAR_LOG',                      'Clear Log');
define ('_AD_DON_CLEAR_THIS_LOG',                 'Are you sure you want to Delete the Transaction Log?');
define ('_AD_DON_CONFIG_PAYPAL_HEADER',           'PayPal Configuration');
define ('_AD_DON_CONFIG_MODULE',                  'Donations Module Config');
define ('_AD_DON_CONFIGURATION',                  'Config');
define ('_AD_DON_CONFIRM_ACTION',                 'Are you sure you want to do this now?');
define ('_AD_DON_CONFIRM_DELETE',                 'Are you sure you want to delete this record?');
define ('_AD_DON_CONFIRM_IMG_URL',                'This URL does not begin with https://'.'<br />'
                                                 .'This image should reside on an HTTPS server.'.'<br />'
                                                 .'If you use this URL, users will receive a warning'.'<br />'
                                                 .'about viewing secure and non-secure data on the same page.'.'<br />'
                                                 .' Are you sure you want to continue?');

define ('_AD_DON_CONFIRM_TOTAL_UP',               'This action will total up all recent PayPal IPN '
                                                 .'transactions and post them here in the register. '
                                                 .'Are you sure you want to do this now ?');

define ('_AD_DON_CONTINUE',                       'Continue');
define ('_AD_DON_CURRENT',                        'Current');
define ('_AD_DON_CUST_ID',                        'Customer PayPal ID:');
define ('_AD_DON_CUST_NAME',                      'Customer:');
define ('_AD_DON_DATE',                           'Date');
define ('_AD_DON_DEFAULT',                        'Default');
define ('_AD_DON_DESCRIPTION',                    'Description');
define ('_AD_DON_DONATIONS',                      'Donations');
define ('_AD_DON_ERR_BAD_DATE_FORMAT',            'Invalid Date format');
define ('_AD_DON_ERR_BAD_NAME_FORMAT',            'The Name field cannot be blank');
define ('_AD_DON_ERR_DB_INSERTION',               '<span style="font-weight: bold; color: red;"> ERROR :</span> '
                                                 .'There are %d to import, but there was an<br />'
                                                 .'error encoutered during db record insertion into Financial '
                                                 .'table.<br />Insertion <span style="font-weight: bold; color: red;">FAILED</span>');
define ('_AD_DON_ERR_INVALID_RECORD_ID',          'Invalid record id specified, operation aborted');
define ('_AD_DON_ERR_SQL_FAILURE',                '<span style="color: #0000FF;"><span style="font-weight: bold;">If you see this screen '
                                                 .'then an SQL error was encountered</span><br />'
                                                 .'You should see a message in <span style="color: #FF0000;">RED</span> below indicating '
                                                 .'the error condition</span>');
define ('_AD_DON_FIELD_PASSED',                   'Field passed validation !');
define ('_AD_DON_GOAL',                           'Goal');
define ('_AD_DON_GOAL_DONATION',                  'Goal donation');
define ('_AD_DON_GOAL_HEBDO',                     'Donation goals by week (4 weeks in a month)');
define ('_AD_DON_GOAL_MENSUEL',                   'Donation goals by month');
define ('_AD_DON_GOAL_PREFERENCES',               'Goal Preferences');
define ('_AD_DON_GOAL_QUARTER',                   'Donation goals by quarter');
define ('_AD_DON_GOAL_TYPE',                      'Choose which goal type you would like to use.');
define ('_AD_DON_GROSS',                          'Gross Amount');
define ('_AD_DON_HEIGHT',                         'Height');
define ('_AD_DON_IMAGE_SIZE',                     'Image dimensions');
define ('_AD_DON_IMG_BUTTON_TOP',                 'Donations page top button');
define ('_AD_DON_IMG_BUTTON_URL',                 'Donations page "Submit" button');
define ('_AD_DON_INTRODUCE_TEXT',                 'Donations page text');
define ('_AD_DON_INVALID_AMOUNT',                 'Invalid Amount field');
define ('_AD_DON_INVALID_AMOUNT2',                'Invalid Amount field, do not use any characters other than -.0123456789');
define ('_AD_DON_IPN_EMAIL_RECEIVER',             'PayPal Receiver Email');
define ('_AD_DON_IPN_LINK',                       'IPN link for PayPal');
define ('_AD_DON_IPN_LOGGING',                    'IPN Logging Options');
define ('_AD_DON_IPN_LOGGING_LEVEL',              'Logging level');
define ('_AD_DON_IPN_URL',                        'Please choose which Paypal IPN url you will use.');
define ('_AD_DON_IPN_URL_CANCELED',               'URL for cancelled donation');
define ('_AD_DON_IPN_URL_SUCCESS',                'URL for Donation \'Thank You\'');
define ('_AD_DON_ITEM_INFO',                      'Item Info');
define ('_AD_DON_LOG_CLEARED',                    'IPN Log cleared');
define ('_AD_DON_LOG_DATE',                       'Log Date: ');
define ('_AD_DON_LOG_EMPTY',                      'There are no IPN transaction logs in the database');
define ('_AD_DON_LOG_ENTRY',                      'Keep this many log entries');
define ('_AD_DON_LOG_ENTRY_TXT',                  'Log Text: ');
define ('_AD_DON_LOG_EVERYTHING',                 'Log everything');
define ('_AD_DON_LOG_NOT_CLEARED',                'IPN Log NOT cleared');
define ('_AD_DON_LOG_OFF',                        'Off');
define ('_AD_DON_LOG_ONLY_ERRORS',                'Only log errors');
define ('_AD_DON_MONTH',                          'Month');
define ('_AD_DON_MONTH_GOAL',                     'month goal');
define ('_AD_DON_NAME',                           'Name');
define ('_AD_DON_NETBAL',                         'Net Balance');
define ('_AD_DON_NEW_IPN_COUNT',                  'Number of new IPN records:');
define ('_AD_DON_NEXT_NEWEST',                    'Next Newest');
define ('_AD_DON_NEXT_OLDEST',                    'Next Oldest');
define ('_AD_DON_NO_NEW_IPNS',                    'There are no new IPN records to import! ');
define ('_AD_DON_NONE',                           'None');
define ('_AD_DON_NUM',                            'Num');
define ('_AD_DON_NUMBER_ORDINAUX',                '1st|2nd|3rd|4th|5th|6th|7th|8th|9th|10th');
define ('_AD_DON_OLDEST',                         'Oldest');
define ('_AD_DON_PMNT_DATE',                      'Payment Date: ');
define ('_AD_DON_PMNT_TYPE',                      'Payment Type: ');
define ('_AD_DON_PP_ASK_CP_ADRESS',               'Ask user for postal address');
define ('_AD_DON_PP_GROUP',                       'Select a Group to assign donors to');
define ('_AD_DON_PP_IMG',                         'URL of image to display in PayPal');
define ('_AD_DON_PP_ITEM_NAME',                   'PayPal Item Name');
define ('_AD_DON_PP_ITEM_NUMBER',                 'PayPal Item Number');
define ('_AD_DON_PP_MONEY',                       'Choose your currency');
define ('_AD_DON_PP_RANK',                        'Select a Rank to assign donors to');
define ('_AD_DON_QUARTER',                        'Quarter');
define ('_AD_DON_QUARTER_GOAL',                   'quarter goal');
define ('_AD_DON_RECORDS_INSERTED',               '<span style="font-weight: bold;">%d</span> IPN records have been imported for a total of %s%0.2f');
define ('_AD_DON_RESET',                          'Rest');
define ('_AD_DON_RETURN',                         'Return');
define ('_AD_DON_SEARCH_FORM',                    'Search By Transaction ID');
define ('_AD_DON_SEARCH_TERM',                    'Search for:');
define ('_AD_DON_SHORT_MONTH',                    'Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec');
define ('_AD_DON_SHOW_LOG',                       'IPN Log');
define ('_AD_DON_SHOW_TXN',                       'Transactions');
define ('_AD_DON_SUBMIT',                         'Submit');
define ('_AD_DON_SUGGESTED_AMOUNT',               'Suggested Donation amounts');
define ('_AD_DON_SWING_DAY',                      'Swing day');
define ('_AD_DON_SYNCHRONISE_IPN',                'PayPal IPN Reconcile');
define ('_AD_DON_T_assign_group_',                'Select the Group that users should be assigned to upon a successful donation.');
define ('_AD_DON_T_assign_rank_',                 'Select the Rank that users should be assigned to upon a successful donation.');
define ('_AD_DON_T_don_amount_1',                 'The Donations module provides a list of suggested donations amounts.  You can customize this list below.');
define ('_AD_DON_T_don_amount_2',                 '');
define ('_AD_DON_T_don_amount_3',                 '');
define ('_AD_DON_T_don_amount_4',                 '');
define ('_AD_DON_T_don_amount_5',                 '');
define ('_AD_DON_T_don_amount_6',                 '');
define ('_AD_DON_T_don_amount_7',                 '');
define ('_AD_DON_T_don_amt_checked_',             'The Donations module provides a list of suggested donations amounts.'.'<br />'
                                                 .'You can customize this list below.  In this box, specify which of the amounts '
                                                 .'listed below should be checked by default.');

define ('_AD_DON_T_don_button_submit_',           'Enter a complete URL for the image to use for at the bottom of the Donations module to submit a donation.');
define ('_AD_DON_T_don_button_top_',              'Enter a complete URL for the image to use for at the top of the Donations module.');
define ('_AD_DON_T_don_forceadd_',                'Add user to group/rank even if user selects to remain anonymous');
define ('_AD_DON_T_don_name_no_',                 'Enter the text for a &quot;NO&quot; selection');
define ('_AD_DON_T_don_name_prompt_',             'Enter the text for the prompt asking a user if they want their name revealed.');
define ('_AD_DON_T_don_name_yes_',                'Enter the text for a &quot;YES&quot; selection');
define ('_AD_DON_T_don_sub_img_height_',          '');
define ('_AD_DON_T_don_sub_img_width_',           'Restrict the dimensions for the above image.'.'<br />'
                                                 .'To use the image&apos;s native size leave both boxes blank.');

define ('_AD_DON_T_don_text_rawtext',             'We are a non-profit organization completely supported by you, the members.  Many organizations have web sites, servers and Internet bandwidth donated by it\'s members.  We pride ourselves on being run and owned as a community, and not by a few power-hungry members.  This means that we need you to be a part of that community.  We encourage every member to contribute to the community in any way that they can.  Since we do not have our servers or bandwidth donated, we have to pay our bills every month to keep things going.  For those of you who can, we ask that you make a monetary contribution in whatever denomination you\'d like.  Every little bit counts.');
define ('_AD_DON_T_don_top_img_height_',          '');
define ('_AD_DON_T_don_top_img_width_',           'Restrict the dimensions for the above image.  To use the image&apos;s native size\r\nleave both boxes blank.');
define ('_AD_DON_T_ipn_dbg_lvl_',                 'There is an IPN logging feature which has'.'<br />'
                                                 .'three log levels:'.'<br />'
                                                 .'1) OFF'.'<br />'
                                                 .'2) Log only Errors'.'<br />'
                                                 .'3) Log everything'.'<br />'
                                                 .'This log is stored in the &quot;translog&quot; table.');

define ('_AD_DON_T_ipn_log_entries_',             'Enter the maximum number of log entries to keep in the log table.');
define ('_AD_DON_T_month_goal_Apr',               '');
define ('_AD_DON_T_month_goal_Aug',               '');
define ('_AD_DON_T_month_goal_Dec',               '');
define ('_AD_DON_T_month_goal_Feb',               '');
define ('_AD_DON_T_month_goal_Jan',               'Enter the dollar amounts for each month&apos;s'.'<br />'
                                                 .'donation goal.');

define ('_AD_DON_T_month_goal_Jul',               '');
define ('_AD_DON_T_month_goal_Jun',               '');
define ('_AD_DON_T_month_goal_Mar',               '');
define ('_AD_DON_T_month_goal_May',               '');
define ('_AD_DON_T_month_goal_Nov',               '');
define ('_AD_DON_T_month_goal_Oct',               '');
define ('_AD_DON_T_month_goal_Sep',               '');
define ('_AD_DON_T_paypal_url_array',             'Please choose which Paypal IPN url you will use.'.'<br />'
                                                 .'The sandbox.paypal.com url is for testing only.');

define ('_AD_DON_T_pp_cancel_url_',               'Enter a URL here for a web page that users will be taken to when they cancel their'.'<br />'
                                                 .'payment.'.'<br />'
                                                 .' You should use this feature if you have filled in a &quot;Thank You&quot; URL.'.'<br />');
define ('_AD_DON_T_pp_curr_code_array',			 'Choose your default currency:'.'<br />'
                                                .'AUD = Austrailian Dollar'.'<br />'
                                                .'BRL = Brazilian Real'.'<br />'
                                                .'CAD = Canadian Dollar'.'<br />'
                                                .'CHF = Swiss Franc'.'<br />'
                                                .'CZK = Czech Koruna'.'<br />'
                                                .'DKK = Danish Kroner'.'<br />'
                                                .'EUR = Euro'.'<br />'
                                                .'GBP = British Pound'.'<br />'
                                                .'HKD = Hong Kong Dollar'.'<br />'
                                                .'HUF = Hungarian Forint'.'<br />'
                                                .'ILS = Israeli New Shekel'.'<br />'
                                                .'JPY = Japanese Yen'.'<br />'
                                                .'MXN = Mexican Peso'.'<br />'
                                                .'MYR = Malaysian Ringgit'.'<br />'
                                                .'NOK = Norwegian Kroner'.'<br />'
                                                .'NZD = New Zealand Dollar'.'<br />'
                                                .'PHP = Philippine Peso'.'<br />'
                                                .'PLN = Polish Zloty'.'<br />'
                                                .'SEK = Swedish Kroner'.'<br />'
                                                .'SGD = Singapore Dollar'.'<br />'
                                                .'THB = Thai Baht'.'<br />'
                                                .'TWD = Taiwan New Dollar'.'<br />'
                                                .'USD = United States Dollar'.'<br />');

define ('_AD_DON_T_pp_get_addr_',                 'Would you like PayPal to gather the user\'s shipping address?'.'<br />'
                                                .'Users can opt out of this. This could be useful if you wanted to send '
                                                .'them holiday cards or something.');

define ('_AD_DON_T_pp_image_url_',                'You can have a custom image displayed at the top of the PayPal screen when your users are donating.'.'<br />'
                                                 .' Enter the URL for the image to display here.'.'<br />'
                                                 .' NOTE: You should not enter a non HTTPS:// URL. If you enter a URL from a '
                                                 .'non-secure server your users will continually be warned that they are about '
                                                 .'to display secure and non-secure information.');

define ('_AD_DON_T_pp_item_num_',                 'Enter the IPN item number used for your donations. This feature is currently not used.');
define ('_AD_DON_T_pp_itemname_',                 'Enter the IPN item name used for your donations. This feature is currently not used.');
define ('_AD_DON_T_quarter_goal_1st',             'Enter the dollar amounts for each quarter&apos;s donation goal.');
define ('_AD_DON_T_quarter_goal_2nd',             '');
define ('_AD_DON_T_quarter_goal_3rd',             '');
define ('_AD_DON_T_quarter_goal_4th',             '');
define ('_AD_DON_T_receiver_email_',              '!!!!!!VERY IMPORTANT!!!!!!! This is the email address registered in your PayPal account that you receive money on. '
                                                 .'NOTE: Create an email address specifically and only for receiving donation');

define ('_AD_DON_T_swing_day_',                   'The Swing Day determines when the Donatometer will switch to show the next month.  The stats from the previous month will no longer be displayed.');
define ('_AD_DON_T_ty_url_',                      'You can enter a URL here for a web page that users will be taken to when they complete a donation.  This is useful for taking the user back to your site and displaying a &quot;Thank You&quot;. '.'<br />'
                                                 .'NOTE: PayPal will use this link for cancelled payments as well. If you use the feature');

define ('_AD_DON_T_use_goal_array',               'Choose which Goal Type you would like to use.');
define ('_AD_DON_T_week_goal_1st',                'Enter the dollar amounts for each week\'s donation goal.');
define ('_AD_DON_T_week_goal_2nd',                '');
define ('_AD_DON_T_week_goal_3rd',                '');
define ('_AD_DON_T_week_goal_4th',                '');
define ('_AD_DON_TEST_IPN',                       'Click here to test IPN');
define ('_AD_DON_TOTALING',                       'Totaling');
define ('_AD_DON_TRANSACTION',                    'transactions and post them here in the register.');
define ('_AD_DON_TREASURY',                       'Treasury');
define ('_AD_DON_TREASURY_ADMIN',                 'Treasury Administration');
define ('_AD_DON_TREASURY_F_REGISTER',            'Treasury Financial Register');
define ('_AD_DON_TXN_AMOUNT',                     'Amount:');
define ('_AD_DON_TXN_FORM',                       'Detailed Transaction ID Information');
define ('_AD_DON_TXN_ID',                         'TXN ID:');
define ('_AD_DON_TXN_MEMO',                       'Memo:');
define ('_AD_DON_TXN_RECENT_FORM',                'Recent Transactions');
define ('_AD_DON_TXN_TYPE',                       'Transaction Type: ');
define ('_AD_DON_UPDATE_REGISTER_IPN',            'Update register with PayPal IPN');
define ('_AD_DON_USERNAME_REQUEST',               'Prompt to use username');
define ('_AD_DON_USERNAME_REQUEST_NO',            'Username request: &quot;NO&quot; Response');
define ('_AD_DON_USERNAME_REQUEST_YES',           'Username request: &quot;YES&quot; Response');
define ('_AD_DON_V_assign_group_',                '0');
define ('_AD_DON_V_assign_rank_',                 '0');
define ('_AD_DON_V_don_amount_1',                 '5');
define ('_AD_DON_V_don_amount_2',                 '15');
define ('_AD_DON_V_don_amount_3',                 '25');
define ('_AD_DON_V_don_amount_4',                 '35');
define ('_AD_DON_V_don_amount_5',                 '45');
define ('_AD_DON_V_don_amount_6',                 '55');
define ('_AD_DON_V_don_amount_7',                 '65');
define ('_AD_DON_V_don_amt_checked_',             '3');
define ('_AD_DON_V_don_button_submit_',           'https://www.paypal.com/en_US/i/btn/x-click-but04.gif');
define ('_AD_DON_V_don_button_top_',              'https://www.paypal.com/en_US/i/btn/x-click-but21.gif');
define ('_AD_DON_V_don_forceadd_',           	  '1');
define ('_AD_DON_V_don_name_no_',                 'No - List my donation as from an Anonymous Donor');
define ('_AD_DON_V_don_name_prompt_',             'Do you want your username revealed with your donation?');
define ('_AD_DON_V_don_name_yes_',                'Yes - List me as a Generous Donor');
define ('_AD_DON_V_don_sub_img_height_',          '');
define ('_AD_DON_V_don_sub_img_width_',           '');
define ('_AD_DON_V_don_text_rawtext',             '0');
define ('_AD_DON_V_don_top_img_height_',          '');
define ('_AD_DON_V_don_top_img_width_',           '');
define ('_AD_DON_V_ipn_dbg_lvl_',                 '0');
define ('_AD_DON_V_ipn_log_entries_',             '20');
define ('_AD_DON_V_month_goal_Apr',               '15');
define ('_AD_DON_V_month_goal_Aug',               '15');
define ('_AD_DON_V_month_goal_Dec',               '15');
define ('_AD_DON_V_month_goal_Feb',               '15');
define ('_AD_DON_V_month_goal_Jan',               '15');
define ('_AD_DON_V_month_goal_Jul',               '15');
define ('_AD_DON_V_month_goal_Jun',               '15');
define ('_AD_DON_V_month_goal_Mar',               '15');
define ('_AD_DON_V_month_goal_May',               '15');
define ('_AD_DON_V_month_goal_Nov',               '15');
define ('_AD_DON_V_month_goal_Oct',               '15');
define ('_AD_DON_V_month_goal_Sep',               '15');
define ('_AD_DON_V_paypal_url_array',             'www.paypal.com|www.sandbox.paypal.com');
define ('_AD_DON_V_pp_cancel_url_',               "http://dev.csmapcentral.com/modules/{$xdonDir}/cancel.php");
define ('_AD_DON_V_pp_curr_code_array',           'AUD|BRL|CAD|CHF|CZK|DKK|EUR|GBP|HKD|HUF|ILS|JPY|MXN|MYR|NOK|NZD|PHP|PLN|SEK|SGD|THB|TWD|USD');
define ('_AD_DON_V_pp_get_addr_',                 '0');
define ('_AD_DON_V_pp_image_url_',                '');
define ('_AD_DON_V_pp_item_num_',                 '110');
define ('_AD_DON_V_pp_itemname_',                 'Donation');
define ('_AD_DON_V_quarter_goal_1st',             '500');
define ('_AD_DON_V_quarter_goal_2nd',             '500');
define ('_AD_DON_V_quarter_goal_3rd',             '500');
define ('_AD_DON_V_quarter_goal_4th',             '500');
define ('_AD_DON_V_receiver_email_',              'webmaster@csmapcentral.com');
define ('_AD_DON_V_swing_day_',                   '1');
define ('_AD_DON_V_ty_url_',                      "http://dev.csmapcentral.com/modules/{$xdonDir}/success.php");
define ('_AD_DON_V_use_goal_array',               'none|week_goal|month_goal|quarter_goal');
define ('_AD_DON_V_week_goal_1st',                '60');
define ('_AD_DON_V_week_goal_2nd',                '60');
define ('_AD_DON_V_week_goal_3rd',                '60');
define ('_AD_DON_V_week_goal_4th',                '60');
define ('_AD_DON_WEEK',                           'Week');
define ('_AD_DON_WEEK_GOAL',                      'week goal');
define ('_AD_DON_WIDTH',                          'Width');
define ('_AD_DON_z_test',                         'For testing');

//1.9.7

// About.php
define("_AM_DON_ABOUT_RELEASEDATE",              "Released: ");
define("_AM_DON_ABOUT_UPDATEDATE",               "Updated: ");
define("_AM_DON_ABOUT_AUTHOR",                   "Author: ");
define("_AM_DON_ABOUT_CREDITS",                  "Credits: ");
define("_AM_DON_ABOUT_LICENSE",                  "License: ");
define("_AM_DON_ABOUT_MODULE_STATUS",            "Status: ");
define("_AM_DON_ABOUT_WEBSITE",                  "Website: ");
define("_AM_DON_ABOUT_AUTHOR_NAME",              "Author name: ");
define("_AM_DON_ABOUT_CHANGELOG",                "Change Log");
define("_AM_DON_ABOUT_MODULE_INFO",              "Module Info");
define("_AM_DON_ABOUT_AUTHOR_INFO",              "Author Info");
define("_AM_DON_ABOUT_DESCRIPTION",              "Description: ");

// Configuration
define("_AM_DON_CONFIG_CHECK","Configuration Check");
define("_AM_DON_CONFIG_PHP","Minimum PHP required: %s (your version is %s)");
define("_AM_DON_CONFIG_XOOPS","Minimum XOOPS required:  %s (your version is %s)");
?>