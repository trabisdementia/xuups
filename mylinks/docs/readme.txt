//  ----------------------------------------------------------- //
//                         mylinks-w 3.0    	 	            //
//                    Just enjoy! Internet for everyone!!	    //
//                      wanikoo <http://www.wanisys.net/>       //
//  ----------------------------------------------------------- //
//                Original Module: mylinks 1.10                 //
//             The XOOPS Project ( http://www.xoops.org/ )      //
//  ----------------------------------------------------------- //


---------------------------------------------
mylinks-w(mylinks wanisys version) ?
----------------------------------------------
Another hacked version of mylinks for XOOPS/XOOPS Cube Legacy(XCL)!

----------------------------------------------
New Installation
----------------------------------------------
To install this module:
1. Upload the contents of the 'mylinks' folder into your site root.
2. Rename the directory to something else if you'd like.
3. Install this module just like any other Xoops module, from
   the Modules Administration menu. Once properly installed, you
   should see the mylinks icon on your Xoops Admin screen.
4. Navigate to the mylinks dropdown menu, click on 'Preferences'.
5. You must now set all of the Configuration settings to match your
   needs.
6. You may import a list of predefined categories into the database
   by going into the MyLinks module Admin and then selecting
   'Add/Edit Links'.  Click the button on the bottom of the page
   that asks you if you want to import the default categories.
   NOTE: Do NOT use this feature if you plan to import data from
   a previous installation!

----------------------------------------------
Advanced Customization
----------------------------------------------
There are some additional customizations available for advanced
administrators.  There are several variables in the ./header.php
file.  Please, read header.php for detail!
For example:
- To enable/disable the display of a module big logo image
  $mylinks_show_logo = true;
- Alphabetical listing
  $mylinks_show_letters = true;
- External search block ( To use this func, you need to install
  the moremetasearch.php from wanikoo [wani@wanisys.net])
  $mylinks_show_externalsearch = false;
- feed icons
  $mylinks_show_feed = true;
- Enable the Extra functions( print, pdf, bookmark, etc...)
  $mylinks_show_extrafunc = true;
====================
Module Theme Changer
====================
  Using the theme changer also requires the systems administrator to create
  custom themes to be used by the module. The custom themes must be located
  in subdirectories under the ./include directory and images in subdirectories
  of the ./images directory.
  1. You must change the configuration variable(s) located in ./header.php
    For example: $mylinks_show_themechanger = true;
           $mylinks_allowed_theme = array("mylinksdefault",
                           "mylinksdefault-RW",
                           "mylinksdefault-LW",
                           "mylinksdefault-BW",
                           "weblinkslike",
                           "weblinkslike-RW",
                           "weblinkslike-LW",
                           "weblinkslike-BW");
      In the case of mylinksdefault-RW theme, just make
      images/mylinksdefault-RW and include/mylinksdefault-RW directories
      and copy your own images and mylinks.js file, mylinks.css file
      into the corresponding directories.  So the partial directory
      tree would look like:
        ./include
          ./mylinksdefault-RW
            mylinks.js
            mylinks.css
        ./images
          ./mylinksdefault-RW
            newred.gif
            pop.gif
            update.gif
            ...
  2. You are required to create these custom themes before they can be used
     by the module. The module defaults to using ./include/mylinks.js and
     ./include/mylinks.css if it cannot find a file in the currently selected
     theme.
  3. The themes must end in one of the following suffixes depending on the
     XOOPS theme supported by the module theme.
    -RW       => do not show right block-section
      -LW       => do not show left block-section
      -BW       => neither right block-section nor left block-section
      no suffix => do nothing

----------------------------------------------
How to upgrade
----------------------------------------------
1. Make a backup of your site (including the database)!
2. Copy all files to the location on your site where the previous version
   is installed.
     NOTE: Renaming is not supported for an module upgrade.  You must
           leave the module directory unchanged.  You may not change the
           module directory name once it has been installed!  If you want
           to put the module into a different directory you must make a
           data backup of your module data (using phpMyAdmin or equiv),
           deactivate and then uninstall the old version of mylinks
           completely.  It is recommended that you delete the old mylinks
           directory and all it's files from the server.  Then follow the
           instructions above for a new Installation.
3. Navigate to the mylinks dropdown menu, click on 'Preferences'.
4. You must now set all of the Configuration settings to match your
   needs.


----------------------------------------------
History
----------------------------------------------
-Ver3.11-[2011-04-15]
+ added pre-install check to verify min versions for PHP/MySQL/Xoops
+ added category class to manage categories
+ changed to use XoopsObjectTree instead of deprecated XoopsTree class
+ fixed various english language typos and grammer
+ moved hard coded language strings to language files
+ fixed missing language definition strings in admin
+ modified block/group administration for XOOPS > 2.2
+ improved html/CSS in both admin and front side page display
+ changed deprecated 'TYPE' to 'ENGINE' in /sql/mysql.sql
+ general code cleanup to improve readability
+ fixed bug in ./admin/about.php to display release status
+ removed display of 'Modify' link if user is not logged in
+ moved numerous configuration options from ./header.php to module Preferences
+ input variables sanitized to eliminate SQL injection
+ changed from using xoops_module_header in templates to using xoTheme class
+ fixed bug in ./rating.php where checking for form submitted with no rating selected.
+ added Preferences setting to select which auto screenshot provider to use
+ fixed bug where module couldn't be relocated to alternate directory
+ added Preferences option to include/exclude admin hits in hit counter
+ added Random Listing display block
+ fixed RSS links displayed by ./feedsubscription.php
+ removed additional XOOPS search block in ./singlelink.php display
----------------------------
-Ver3.1-[2011-03-18]
- updated admin menu to XOOPS 2.5 style
----------------------------
-Ver3.0-[2008-11-25]
+ bookmark button
+ bug/typo fix!(Sorry for my stupid mistake!!)
+ Code refined
+ etc.
----------------------------
-Ver2.5-[2008-05-27]
+ minimize/restore button
+ Internal search block
+ enhanced page-navigation
+ etc.
-----------------------------
-Ver2.0-[2008-04-20]
+ Category Jump box
+ print button
+ pdf button
+ qrcode button ( qrcode module needed! )
+ etc.
------------------------------
-Ver1.5-
+ Module Theme changer
+ Search function!
+ Index Browsing
+ Code refined
+ etc.
------------------------------


Demo:
http://kjw0815.codns.com/wanisys/japanese/xoops/html/modules/mylinks/

Support Forum:
http://kjw0815.codns.com/wanisys/japanese/xoops/html/modules/newbb/

From wanikoo [wani@wanisys.net]

the most educational site, wanisys.net [ http://www.wanisys.net  ]

