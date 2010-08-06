/**
* $Id: readme.txt,v 1.3 2006/09/27 22:58:56 marcan Exp $
* Module: SmartMail
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

What is SmartMail?
==================

SmartMail is a XOOPS module for creating and publishing e-newsletters. It is fully integrated with XOOPS permissions, the XOOPS membership module, and can automatically pull content from any other module. Publication can be manual, or fully automatic (with a cron tab) on an admin defined reoccurring schedule.

What is the SmartObject Framework ?
===================================

The SmartObject Framework is basically an abstraction of all the features we are using in all SmartModules. It allows us to code features more quickly and more efficiently. All our new SmartModules are most likely to be based on this framework and older SmartModules will evolved in that same path also.

As SmartMail is one of newest module, it indeed requires the SmartObject Framework to be installed. The SmartObject Framework come as a usual XOOPS module that needs to be installed as any other module. Future versions of the SmartObject will be available for download directly on The SmartFactory just as any other SmartModules.

In the meantime, a copy of the SmartObject has been added to the SmartMail package for an easy installation.

How to install SmartMail
========================

SmartMail is installed as a regular XOOPS module, which means you should copy the complete /smartmail folder into the /modules directory of your website. Then, log in to your site as administrator, go to System Admin > Modules, look for the SmartMail icon in the list of uninstalled modules and click in the install icon. Follow the directions in the screen and you'll be ready to go.


Getting Started with SmartMail
==============================

Log in to the Admin area of your XOOPS site.
Select SmartMail > Newsletter

Setting up Newsletter Lists for Subscription
--------------------------------------------
Click "Add Newsletter" to create a Newsletter Subscription List.

Fill out the "Add newsletter" form (the "Name" and "Description" will display on the public side of the site in the SmartMail index page - yourxoopsurl/modules/smartmail/)

Select the user groups that will be allowed to subscribe to this list.

Select the template for the newsletter. (More about templates in a minute)

Add a Subscription Block or Link to your Site
--------------------------------------------
SmartMail has one "Newsletter" block. This block allows your site users to view available newsletter lists, and to subscribe to them directly. In addition, logged in users are show the list they are subscribed to. They may unsubscribe from this block as well as subscribe to additional lists. Make this Newsletter block visible (System > Blocks) and available to user groups as you desire. Note that each newsletter list also has permission settings to control who can subscribe to that particular list.

In addition to the Newsletter block, you can create a link to the index page of the SmartMail module (modules/smartmail/). This page shows the same information and provides the same functionality as the newsletter block.

A Word about the Subscription Process
--------------------------------------------
SmartMail is integrated with the XOOPS membership tables. This allows for some rather neat functionality. Assuming SmartMail is visible for anonymous as well as registered users - SmartMail will allow both to subscribe seamlessly to your Newsletter Lists. Registered user but not logged in? No problem. SmartMail will take the user through log in and add their subscription at the same time. Anonymous users who subscribe will automatically have a user registration account created for them - respecting your System > Preferences > User Info Settings for "Select activation type of newly registered users"

From the SmartMail Newsletter tab, you can see how many subscribers you have for each list. Clicking on the subscriber field takes you to SmartMail's subscriber management screen. You can select registered users from your site and subscribe them to the current list. You can also delete subscribers.

{To come - mass import of subscribers with automatic coordination with your XOOPS membership data}

Creating Custom Newsletter Templates
--------------------------------------------
A SmartMail newsletter template is an HTML document with a few simple tables and smartytags to indicate six possible block locations for content.

SmartMail newsletter templates are purposely very simple from a design point of view. You will do just about all of your design work using XOOPs blocks - both instances of SmartMail custom blocks and standard module blocks (XOOPS 2.0.x Custom System Blocks are not compatible with SmartMail - use an instance of the SmartMail custom block instead. More details on this are below in Adding Content).

You can assign standard HTML table formatting in your template - sizes, colors, borders, etc. And you can use element and class style sheets. And if you want you can add graphics and text (But a better way for that type of content is to use blocks. More on that below.) Experiment. Use relative links. And test, test, test.

The module comes with one default template with block positions like this:

************************************
*            Block 1               *
************************************
*            Block 2               *
************************************
*    Block 3    *    Block 4       *
************************************
*            Block 4               *
************************************
*            Block 5               *
************************************

After you have created a custom template, FTP-upload your HTML file to the directory /modules/smartmail/templates and you will be able to assign the new template to a newsletter via SmartMail > Newsletters  - select the newsletter list and click "edit"

Adding Content to Your Newsletter Templates
--------------------------------------------
Once you have defined a Newsletter subscription list and have your template assigned, you then define the content using blocks. What no WYSIWYG editor for the entire issue? Don't worry. You can do just about anything you want content- and design-wise with blocks.

From SmartMail > Newsletter, click the "blocks" link next to your Newsletter's name. You will be presented with a list of all available XOOPs blocks from your site, listed by module. Select a block (it is precede by a hyphen - if you select a module, nothing will happen) and click submit.

Fill out and submit the resulting Add a Block form. Any block related options/preference can be set from the "Add block" form. The "position" pop up allows you to assign that block to that position as it is defined in your template.

You can add as many blocks of the same type as you like to a newsletter - e.g. if you have five news categories, you can add five blocks with latest news in a category, one for each category (provided the block can be configured to pull articles from one category only)

For custom content items - mastheads, footers, unsubscribe info, static copy, etc, select the SmartMail Custom Block. Then assign content and a position. Create as many instances of the SmartMail custom block as necessary.

Again, don't try to use XOOPS 2.0.x custom system blocks. They won't work.


Dispatches - Publishing an Issue
--------------------------------------------
Follow SmartMail > Dispatchers (or from SmartMail > Newsletters, click on the Dispatches)

Add a dispatch for your desire list(s). Click edit to adjust the dispatch date and email subject line. If you'd like to put the issue on "hold" click the "not ready" button - your crontab will not publish it . {need to verify this is correct}

From the Dispatch > Edit screen, you adjust the content that your Newsletter template has provided you. Add more blocks, delete blocks, edit blocks as necessary for this issue. Any changes you make in the Dispatch > Edit will also be made to the corresponding newsletter template and any other dispatches you have created.


Proofing
--------------------------------------------
From SmartMail > Dispatches click the preview link for a particular issue. You will see an onscreen preview. And you will also have the option to "Send Preview" to an email address. Proof, proof, proof, and then proof on multiple email clients!

Publishing an Issue
--------------------------------------------
Use SmartMail > Preferences to set up the mail sender service
{more details to come

Creating Regular Dispatches
--------------------------------------------
From SmartMail > Newsletters, click on the name of a newsletter subscription list. You'll get a preview of what a dispatch, or issue, will look like. From this preview screen you can also set up automatic dispatches for this list. That is SmartMail will grab content from the selected blocks and publish an issue on the schedule of your choosing. Simply "add rule" {More info on this to come}

Known issues
============

As this is an Alpha release - following the motto release early and often - it does have some known issues. We just didn't want to delay release to address them. So expect a few bugs at this point.

Know bug #1: if you create a newsletter with no recurring rule, and then you add a dispatch, the dispatch will get deleted when you refresh your screen. This is because without a rule, a dispatch is dated "now" - and when you refresh your screen a few seconds will have past. The dispatch screen only displays future, unpublished dispatches. We are working improving this display.

Feedback
========

As usual, feedback is very welcomed ! We would like to know if you like the module, if it has bugs or if it can be in any way improved ! Since SmartMail uses the XOOPS Developers Forge for its development, you can easily :

=> Post any bug you may found here :
http://dev.xoops.org/modules/xfmod/tracker/?group_id=1352&atid=1562

=> Post any feature request here :
http://dev.xoops.org/modules/xfmod/tracker/?group_id=1352&atid=1565

Credits
=======

This module is based on the Newsletter module originally developed by Jan Keller Pedersen, Morten Fangel, Dan Nim Andersen - idg.dk. SmartMail was made possible by the sponsorship of <a href='http://www.ampersandesign.net/'>Ampersand Design, Inc.</a>, <a href='http://inboxinternational.com'>INBOX Solutions</a>, American Killfish Association, Crispin Moorey and Jereco Marketing.


Enjoy SmartMail

.:: The SmartFactory ::.
.:: Open Source : smartfactory.ca ::.
.:: Professionnal : inboxinternational.com ::.

