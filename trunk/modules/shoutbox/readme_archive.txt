Credits:
========
At the very beginning this module was developed for e-xoops aka runcms (XOOPS fork) but I ported it to XOOPS and never stopped porting... ;-)

Thx for everything...
- Herko [herkocoomans.net]: Where would I be without his spiritual help?
- Shine aka Triangle [adoptietrefpunt.nl]: Without her guidance I wouldn't have been the same person!
- All the rest I now forget but couldn't live without!

And those who helped developing me with shoutbox...
- Wizanda [wizanda.co.uk]: Kicking my ass for not following W3C guidelines... *shame*
- Masterprut [fueldump.de]: Helped me with those stupid javascript security measures (read: my scripting skills).
- Ackbarr: Small things, together big!

Version 4.0 Beta
================
* Fixed: Fixed XHTML so Tidy loves it (Thx to Wizanda [wizanda.co.uk] & Masterprut [fueldump.de])
* Fixed: Javascript optimized so it isn't a mess anymore.

* Added: You can now choose the storage method: file or database. Database is still experimental!
* Added: It's now possible to edit/remove shouts [database only]
* Added: You can now select the height and width of the popup. Popup stays resizeable!
* Added: The remove button now asks or you are sure you want to remove all posts.

* Todo: CAPTCHA integration for guest users
* Todo: Make storage file moveable
* Todo: Fix known problem with popup for users that use crappy browser (aka IE)
* Todo: Fix unknown bugs :-)

Version 3.2:
============
* Fixed: Anonymous users could post when generating own form

Version 3.1:
============
* Fixed: Possible warning in popup.
* Fixed: Wrong variable selection in popupframe
* Fixed: Forgot ":" after anonymous name...

* Changed: If you now deselect "guest" may post and block is visible to guests they will see the shouts but won't be able to add. This option gots now a logic!
* Changed: Almost all repeated actions are now packed in one class. This will speedy the conversion to a sql version.

* Added: You got now a maxview function. This is seperated from the trim function.

Install Notes:
==============
Deactivate, uninstall, remove folder if you upgrade from older version. Then upload new version and install. Be sure to set the Order of the Module to hide. (System Admin - Modules - Height -> '0')

If you set the access rights be sure to change the rights for the block and the main - THIS IS NECESSARY -, if you just allow access to the Block, the groupmembers wont see the frame content, instead of this the shoutbox will load the non acess page and in the non access page there will be another shoutbox clone again and that will also display the no access page ...

If you want to use a custom theme for the shoutbox, rename the the file style/shoutbox.temp.css to style/shoutbox.css and change it so it will fit your needs.

Help:
=====
1. My database is really BIG even with trimming enabled?
--------------------------------------------------------
Known problem. Shoutbox will ignore the trimming function when your select the database as your favorite storage method. This should be fixed in the next version. For now: live with or execute query "DELETE * FROM shoutbox WHERE time < ...".

2. If I open main I get...
--------------------------
You shouldn't open the mainpage of this module. Shoutbox exists as block and popup. Search for it in System Admin - Blocks.

3. This module sucks!
---------------------
Good for you. Move on!



 