<?php
/**
 * @version::   $Id$
 */
$xdonDir = basename ( dirname( dirname ( dirname( __FILE__ ) ) ) ) ;
define ('_MI_DON_ADMIN',                          'Administration');
define ('_MI_DON_BNAME1',                         'Donat-O-Meter');
define ('_MI_DON_BNAME1_DESC',                    'Graphically displays donations');
define ('_MI_DON_BNAME2',                         'Donate Now !');
define ('_MI_DON_BNAME2_DESC',                    'Allow your users to donate to your site with Paypal');
define ('_MI_DON_BNAME3',                         'Recent Donors');
define ('_MI_DON_BNAME3_DESC',                    'A list of recent donors');
define ('_MI_DON_BUTTON_URL',                     'https://www.paypal.com/en_US/i/btn/x-click-but21.gif');
define ('_MI_DON_CONFIGURATION',                  'Configuration');
define ('_MI_DON_DESC',                           'Paypal financial management module for XOOPS2');
define ('_MI_DON_DONATIONS',                      'Donations');
define ('_MI_DON_NAME',                           'Name');
define ('_MI_DON_SHOW_LOG',                       'Show IPN Log');
define ('_MI_DON_SHOW_TXN',                       'Transactions');
define ('_MI_DON_T_assign_group_',                'Select the Group that users should be assigned to upon a successful donation.');
define ('_MI_DON_T_assign_rank_',                 'Select the Rank that users should be assigned to upon a successful donation.');
define ('_MI_DON_T_don_amount_1',                 'The Donations module provides a list of suggested donations amounts.  You can customize this list below.');
define ('_MI_DON_T_don_amount_2',                 '');
define ('_MI_DON_T_don_amount_3',                 '');
define ('_MI_DON_T_don_amount_4',                 '');
define ('_MI_DON_T_don_amount_5',                 '');
define ('_MI_DON_T_don_amount_6',                 '');
define ('_MI_DON_T_don_amount_7',                 '');
define ('_MI_DON_T_don_amt_checked_',             'The Donations module provides a list of suggested donations amounts.'.'<br />'
.'You can customize this list below.  In this box, specify which of the amounts listed below should be checked by default.');

define ('_MI_DON_T_don_button_submit_',           'Enter a complete URL for the image to use for at the bottom of the Donations module to submit a donation.');
define ('_MI_DON_T_don_button_top_',              'Enter a complete URL for the image to use for at the top of the Donations module.');
define ('_MI_DON_T_don_forceadd_',                'Add user to group/rank even if user selects to remain anonymous');
define ('_MI_DON_T_don_name_no_',                 'Enter the text for a &quot;NO&quot; selection');
define ('_MI_DON_T_don_name_prompt_',             'Enter the text for the prompt asking a user if they want their name revealed.');
define ('_MI_DON_T_don_name_yes_',                'Enter the text for a &quot;YES&quot; selection');
define ('_MI_DON_T_don_sub_img_height_',          '');
define ('_MI_DON_T_don_sub_img_width_',           'Restrict the dimensions for the above image.'.'<br />'
                                                 .'To use the image&apos;s native size leave both boxes blank.');

define ('_MI_DON_T_don_text_rawtext',             'We are a non-profit organization completely supported by you, the members.  Many organizations have web sites, servers and Internet bandwidth donated by it\'s members.  We pride ourselves on being run and owned as a community, and not by a few power-hungry members.  This means that we need you to be a part of that community.  We encourage every member to contribute to the community in any way that they can.  Since we do not have our servers or bandwidth donated, we have to pay our bills every month to keep things going.  For those of you who can, we ask that you make a monetary contribution in whatever denomination you\'d like.  Every little bit counts.');
define ('_MI_DON_T_don_top_img_height_',          '');
define ('_MI_DON_T_don_top_img_width_',           'Restrict the dimensions for the above image.  To use the image\'s native size\r\nleave both boxes blank.');
define ('_MI_DON_T_ipn_dbg_lvl_',                 'There is an IPN logging feature which has'.'<br />'
                                                 .'three log levels:'.'<br />'
                                                 .'1) OFF'.'<br />'
                                                 .'2) Log only Errors'.'<br />'
                                                 .'3) Log everything'.'<br />'
                                                 .'This log is stored in the \"translog\" table.');

define ('_MI_DON_T_ipn_log_entries_',             'Enter the maximum number of log entries to keep in the log table.');
define ('_MI_DON_T_month_goal_Apr',               '');
define ('_MI_DON_T_month_goal_Aug',               '');
define ('_MI_DON_T_month_goal_Dec',               '');
define ('_MI_DON_T_month_goal_Feb',               '');
define ('_MI_DON_T_month_goal_Jan',               'Enter the dollar amounts for each month\'s'.'<br />'
                                                 .'donation goal.');

define ('_MI_DON_T_month_goal_Jul',               '');
define ('_MI_DON_T_month_goal_Jun',               '');
define ('_MI_DON_T_month_goal_Mar',               '');
define ('_MI_DON_T_month_goal_May',               '');
define ('_MI_DON_T_month_goal_Nov',               '');
define ('_MI_DON_T_month_goal_Oct',               '');
define ('_MI_DON_T_month_goal_Sep',               '');
define ('_MI_DON_T_paypal_url_array',             'Please choose which Paypal IPN url you will use.'.'<br />'
                                                 .'The sandbox.paypal.com url is for testing only.');

define ('_MI_DON_T_pp_cancel_url_',               'Enter a URL here for a web page that users will be taken to when they cancel their'.'<br />'
                                                 .'payment.'.'<br />'
                                                 .' You should use this feature if you have filled in a \"Thank You\" URL.'.'<br />');
define ('_MI_DON_T_pp_curr_code_array',          'Choose your default currency:'.'<br />'
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

define ('_MI_DON_T_pp_get_addr_',                 'Would you like PayPal to gather the user\'s shipping address?'.'<br />'
.'Users can opt out of this. This could be useful if you wanted to send them holiday cards or something.');

define ('_MI_DON_T_pp_image_url_',                'You can have a custom image displayed at the top of the PayPal screen when your users are donating.'.'<br />'
.' Enter the URL for the image to display here.'.'<br />'
.' NOTE: You should not enter a non HTTPS:// URL. If you enter a URL from a non-secure server your users will continually be warned that they are about to display secure and non-secure information.');

define ('_MI_DON_T_pp_item_num_',                 'Enter the IPN item number used for your donations. This feature is currently not used.');
define ('_MI_DON_T_pp_itemname_',                 'Enter the IPN item name used for your donations. This feature is currently not used.');
define ('_MI_DON_T_quarter_goal_1st',             'Enter the dollar amounts for each quarter\" donation goal.');
define ('_MI_DON_T_quarter_goal_2nd',             '');
define ('_MI_DON_T_quarter_goal_3rd',             '');
define ('_MI_DON_T_quarter_goal_4th',             '');
define ('_MI_DON_T_receiver_email_',              '!!!!!!VERY IMPORTANT!!!!!!! This is the email address registered in your PayPal account that you receive money on. '.'<br />'
.'NOTE: Create an email address specifically and only for receiving donation');

define ('_MI_DON_T_swing_day_',                   'The Swing Day determines when the Donatometer will switch to show the next month.  The previous month&apos;s stats will no longer be displayed.');
define ('_MI_DON_T_ty_url_',                      'You can enter a URL here for a web page that users will be taken to when they complete a donation.  This is useful for taking the user back to your site and displaying a &quot;Thank You&quot;. '.'<br />'
.'NOTE: PayPal will use this link for cancelled payments as well. If you use the feature');

define ('_MI_DON_T_use_goal_array',               'Choose which Goal Type you would like to use.');
define ('_MI_DON_T_week_goal_1st',                'Enter the dollar amounts for each week&apos;s donation goal.');
define ('_MI_DON_T_week_goal_2nd',                '');
define ('_MI_DON_T_week_goal_3rd',                '');
define ('_MI_DON_T_week_goal_4th',                '');
define ('_MI_DON_TREASURY_F_REGISTER',            'Treasury Register');
define ('_MI_DON_V_assign_group_',                '0');
define ('_MI_DON_V_assign_rank_',                 '0');
define ('_MI_DON_V_don_amount_1',                 '5');
define ('_MI_DON_V_don_amount_2',                 '15');
define ('_MI_DON_V_don_amount_3',                 '25');
define ('_MI_DON_V_don_amount_4',                 '35');
define ('_MI_DON_V_don_amount_5',                 '45');
define ('_MI_DON_V_don_amount_6',                 '55');
define ('_MI_DON_V_don_amount_7',                 '65');
define ('_MI_DON_V_don_amt_checked_',             '3');
define ('_MI_DON_V_don_button_submit_',           'https://www.paypal.com/en_US/i/btn/x-click-but04.gif');
define ('_MI_DON_V_don_button_top_',              'https://www.paypal.com/en_US/i/btn/x-click-but21.gif');
define ('_MI_DON_V_don_forceadd_',                '1');
define ('_MI_DON_V_don_name_no_',                 'No - List my donation as from an Anonymous Donor');
define ('_MI_DON_V_don_name_prompt_',             'Do you want your username revealed with your donation?');
define ('_MI_DON_V_don_name_yes_',                'Yes - List me as a Generous Donor');
define ('_MI_DON_V_don_sub_img_height_',          '');
define ('_MI_DON_V_don_sub_img_width_',           '');
define ('_MI_DON_V_don_text_rawtext',             '0');
define ('_MI_DON_V_don_top_img_height_',          '');
define ('_MI_DON_V_don_top_img_width_',           '');
define ('_MI_DON_V_ipn_dbg_lvl_',                 '0');
define ('_MI_DON_V_ipn_log_entries_',             '20');
define ('_MI_DON_V_month_goal_Apr',               '15');
define ('_MI_DON_V_month_goal_Aug',               '15');
define ('_MI_DON_V_month_goal_Dec',               '15');
define ('_MI_DON_V_month_goal_Feb',               '15');
define ('_MI_DON_V_month_goal_Jan',               '15');
define ('_MI_DON_V_month_goal_Jul',               '15');
define ('_MI_DON_V_month_goal_Jun',               '15');
define ('_MI_DON_V_month_goal_Mar',               '15');
define ('_MI_DON_V_month_goal_May',               '15');
define ('_MI_DON_V_month_goal_Nov',               '15');
define ('_MI_DON_V_month_goal_Oct',               '15');
define ('_MI_DON_V_month_goal_Sep',               '15');
define ('_MI_DON_V_paypal_url_array',             'www.paypal.com|www.sandbox.paypal.com');
define ('_MI_DON_V_pp_cancel_url_',               "http://dev.csmapcentral.com/modules/{$xdonDir}/cancel.php");
define ('_MI_DON_V_pp_curr_code_array',           'AUD|BRL|CAD|CHF|CZK|DKK|EUR|GBP|HKD|HUF|ILS|JPY|MXN|MYR|NOK|NZD|PHP|PLN|SEK|SGD|THB|TWD|USD');
define ('_MI_DON_V_pp_get_addr_',                 '0');
define ('_MI_DON_V_pp_image_url_',                '');
define ('_MI_DON_V_pp_item_num_',                 '110');
define ('_MI_DON_V_pp_itemname_',                 'Donation');
define ('_MI_DON_V_quarter_goal_1st',             '500');
define ('_MI_DON_V_quarter_goal_2nd',             '500');
define ('_MI_DON_V_quarter_goal_3rd',             '500');
define ('_MI_DON_V_quarter_goal_4th',             '500');
define ('_MI_DON_V_receiver_email_',              'webmaster@csmapcentral.com');
define ('_MI_DON_V_swing_day_',                   '1');
define ('_MI_DON_V_ty_url_',                      "http://dev.csmapcentral.com/modules/{$xdonDir}/success.php");
define ('_MI_DON_V_use_goal_array',               'none|week_goal|month_goal|quarter_goal');
define ('_MI_DON_V_week_goal_1st',                '60');
define ('_MI_DON_V_week_goal_2nd',                '60');
define ('_MI_DON_V_week_goal_3rd',                '60');
define ('_MI_DON_V_week_goal_4th',                '60');
define ('_MI_DON_z_test',                         'For testing');

//1.9.7
define ('_MI_DON_MENU_00',                         'Home');
define ('_MI_DON_ADMIN_ABOUT',                     'About');

?>