What is mytabs Module (v2.0) ?
======================

With this Xoops module, your can create blocks with several tabs an blocks inside.

The module can :
. Create any blocks you want (just clone the original)
. Create any pages (holders for tabs) you want so you can choose in the block what page to show
. Create any tabs you want per page 
. Create any blocks you want per tabs 
. Set group view permissons per block/page, tab and block
. Set time based tabs and blocks (auto-expiring)
. Set blocks side: left, center or right.
. Choose from 5 diferent page/block layouts
. Use how many blocks you want in the same page or not (just clone and set them)
. Many other goodies like cache, position, scroll, width, Show/hide other divs, link tab to url, onmouseover selection, etc



How to install mytabs
====================

Copy mytabs folder into the /modules directory of your website. Then log in
to your site as administrator, go to System Admin > Modules, look for the mytabs
icon in the list of uninstalled modules and click in the install icon. Follow
the directions in the screen and you'll be ready to go.



Requirements
====================

Works in xoops 2.3.0, xoops 2.0.16, impresscms 1.0 and Xcl

Does not work in xoops 2.2.x due to diferent configuration of database, sorry.

If you have problems using xoops 2.3 alpha then add a folder named 'smarty_cache' with write permissions in
your_root/xoopsdata/caches/xoops_cache


Tested with php5 and php4.



Bugs
====================

Blocksadmin does not work correctly under iCms, please use your system blocksadmin.

Blocksadmin does not work correctly under xcl. (I don´t know if xcl provides a cloning block function).

Be carefull when selecting time based tabs/blocks. Dislpayed hour is not always correct. Have that in mind when selecting time.



Limitations
====================

You can´t use more than one block with scrolling tabs (delay>0) per page.



Upgrading from older versions
====================

No upgrade, please:
Unistall mytabs.
Remove all files.
Clean templates_c folder
Upload new files.
Install mytabs.



Tips
====================

You can create your own .css for tabs. Just upload it to css folder an it will be available for selection in your blocks!

------

To avoid tabs from scrolling set delay to 0 inside your block.

------

Clone My Tabs Block using 'blocks and permissions' in mytabs administation page. If you use iCms or xoops 2.3.0 alpha you can also clone it from System Admin > Blocks Admin.

------

You can create html custom blocks and make them interact with each tab.
Ex of a custom block:
<div id="mydiv" style="display: none;">My tip number1</div>
<div id="mydiv2" style="display: none;">My hided links</div>

And then set 'Reveal ID' inside the tabs edit form
for tab1 : my div
for tab2 : mydiv2 

You can expand/contract more than one div, just separate the divs ids with a comma

for tab 3 : my div, mydiv2

------

You can also add a link to a tab.
Just set 'Links to' with the complete URL
Ex: http://www.anothersite.com/register.php 

------

You can use Mytabs as a menu!
Set your block height to 0 and create tabs without blocks.
Using the 'Link To' option you can easily make your menu.
You do not need to enter all the complete link
ex:

index.php
modules/news
viewpmsg.php

You can use {user_id} in your link. It will retrieve the Id of the user seing the page
ex:

userinfo?uid={user_id}

You can also customize the name of the link for display private messages info

In the tab title just add
{pm_new}
{pm_readed}
{pm_total}

ex: 

title = Inbox {pm_new}
Link to = viewpmsg.php

 


Feedback
========

Please use http://www.xuups.com (xoops user utilities)