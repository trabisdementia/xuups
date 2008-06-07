What is mytabs Module (v2.0 alpha3) ?
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
. Many other goodies like cache, position, scroll, width, etc



How to install mytabs
====================

Copy mytabs folder into the /modules directory of your website. Then log in
to your site as administrator, go to System Admin > Modules, look for the mytabs
icon in the list of uninstalled modules and click in the install icon. Follow
the directions in the screen and you'll be ready to go.



Requirements
====================

Works in xoops 2.3.0, xoops 2.0.16, impresscms 1.0

Does not work in xoops 2.2.x due to diferent configuration of database, sorry

Not tested in Xoops Cube Legacy but I think it will Not work, I must check something first. Be patient.

If you have problems using xoops 2.3 alpha then add a folder named 'smarty_cache' with write permissions in
your_root/xoopsdata/caches/xoops_cache


Tested with php5 and php4.



Bugs
====================

Blocksadmin does not work correctly under iCms, please use your system blocksadmin.

Be carefull when selecting time based tabs/blocks. Dislpayed hour is not always correct. Have that in mind when selecting time.



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

To avoid tabs from scrolling set delay to 0 inside your block.

Clone My Tabs Block using 'blocks and permissions' in mytabs administation page. If you use iCms or xoops 2.3.0 alpha you can also clone it from System Admin > Blocks Admin.
 


Feedback
========

Please use xuups.com (xoops user utilities), xoops.org, impresscms.org or xoopsbr.org forums