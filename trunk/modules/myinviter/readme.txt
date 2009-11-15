What is myinviter Module (v1.0) ?
======================

With this Xoops module you can allow users to import addressbook/contacts from different email providers like Yahoo, Gmail, Hotmail, Live etc
and send email invitations.

The module can :
. Allow users/anonymous to invite their contacts to join your site
. Control how many emails are sent per package (avoiding your site to get blacklisted)
. Control time between package sending
. Check if given contacts are already registered or not
. Check if given contacts are already pending for invitation
. Allows the invited ones to add their emails to blacklist, respecting their privacy
. Other options such has sandbox, overiding reply-to, html/text plain emails, etc
. More than 70 plugins available


Requirements
====================

XOOPS 2.4.x only
Php5
Curl php extension


How to install myinviter
====================

Copy myinviter folder into the /modules directory of your website.

Give write permission to 'Cookies' folder.

There are several plugins available in 'plugins/unused' folder. Move the ones you want to 'plugins' folder.

Log in to your site as administrator, go to System Admin > Modules, look for the myinviter
icon in the list of uninstalled modules and click in the install icon. 

Follow the directions in the screen.

Go to myinviter preferences and set them as you wish.

Place a myinviter block in your front page if possible.

Very important: Emails sending routine is activated when someone visits your site.
You must set your preferences accordingly to your site traffic.
Setting 100 emails per hour will not work as expected if you do not have at least one visitor per hour!!!


Tips
====================

Visit http://openinviter.com/ and get the plugins you need to update

If you have a limit of 600 emails per hour you can use this settings:
600 emails for 3600 seconds period (60 minutes)
100 emails per 600 seconds period  (10 minutes)
10 emails per 60 seconds period (1 minute)

Don't make your users wait while emails are being sent,
the last option would be the best one if you have a high traffic website!


Feedback
========

Please use http://www.xuups.com (xoops user utilities)