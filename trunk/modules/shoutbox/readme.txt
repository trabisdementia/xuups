****************************************************************************
 
         Shoutbox v4.05 Release| Xoops Module by Tank | Dec 15, 2008
         Website: http://www.customvirtualdesigns.com
 
****************************************************************************

Shoutbox is an XOOPS module that provides an interactive block and pop-up
window for visitors to post and view messages. For background info and
previous developer credits refer to "readme_archive.txt".

Initial release 4.01  10/05/2008

 - Posted messages can be stored in database table or csv file
 - All components of message entry are routed through sanitizer prior to storage
 - Dynamic resizing of pop-up window has been disabled until further testing
 - Text entry field now contains options for single line text box or
   multi-line text area with optional alerts when approaching message
   length limit
 - Display of registered user's avatar included in standard message block
 - OnUpdate function provided so database table will be created (if
   necessary) when updating from version 4.0 beta

 NOTE: If your current version of Shoutbox is earlier than v4.0 beta, it is
 not known whether performing a module update will work properly. Our
 recommendation would be to uninstall the current Shoutbox module and
 perform a New Install.

Update Release 4.02  11/01/2008

 - Bug Fix: Typo in include/class.php causing some file storage processing
   to be performed incorrectly
 - Add guest avatar
 - Popup window dynamic resizing re-designed using div tags and css
 - Add captcha for guest posting with good guest mode
   The module contains it's own copy of XOOPS 2.3.0 captcha class with
   modifications to meet ShoutBox module requirements
 - Add captcha enable/disable preference parameter
 - Enable module style sheet so user can customize appearance
 - Change Refresh and Popup from links to buttons in Shoutbox block

Update Release 4.03  11/15/2008

 - Bug Fix: Update text sanitizer functions to eliminate debug deprecated message
 - Add wordwrap preference parameter for controlling message line display length
 - Update style sheet to coincide with wordwrap feature so horizontal scroll bar
   is automatically removed when not necessary
 - Add display avatar preference parameter to enable/disable display of avatars
   in the ShoutBox block. NOTE: This has no affect on Popup window.
 - Remove local copy of captcha class.
 - Add captcha support for Frameworks/captcha class.

Update Release 4.04  12/01/2008

 - Clean up some minor defects generating notices in debug mode
 - Bug Fix: Add passing UID to template to correct page refresh problem
 - Redefine how refresh works similar to the way it was in v4.02
   - Anytime an incorrect captcha code is entered the full page will refresh
     regardless of the type of captcha class used
   - If using Frameworks/captcha the full page will refresh for any message
     entry performed by guest
   - If using Core captcha only the message box, shout entry and captcha fields 
     will be refreshed when an entry is performed by guest
 - Add word censoring support
 - Add selectable guest avatars. If guest avatar is set to None then blank.gif
   is placed in the avatar location.
 - Add option for disable/enable sound on new message when using popup window

Update Release 4.05  12/15/2008

 - Add padding to sideboxcontent in module style sheet to provide some space
   between avatars and message text
 - Add javascript code in shoutframe and popupframe templates so URL's, when 
   selected, open in a new window. (target ="_blank")
   NOTE: Special thanks to blueteen for this code
 - Add comments to shoutbox.css style sheet to help users in making changes
 - Add definitions in language files to eliminate all hard-coded text used
   in templates
 - Improve text sanitizing used in storing and retrieving messages
 - Eliminate extra line feeds in text entry when stored as File type
 
Tested on XOOPS 2.0.18.2 and XOOPS 2.3.0

Frameworks 1.35 Download Link
   http://www.xoops.org/modules/repository/singlefile.php?cid=101&lid=1766

Special Note: Be sure the entire Frameworks package is installed if you plan on using
Frameworks captcha. The captcha class uses other classes within Frameworks. If any of the
necessary classes do not exist it will result in no captcha image being displayed.

Please note that if you plan on using the Frameworks/captcha feature you should install
Frameworks before installing ShoutBox. If Frameworks is installed after ShoutBox has been
installed you will have to perform an update on the ShoutBox module before the new
captcha enable options will appear on the module Preferences screen.

New Install v4.05 - Instructions:
1) After downloading, unzip the package
2) Upload the directory labeled 'shoutbox' to your server into the 'modules' subdirectory
3) Select Administration Menu >> System >> Modules
4) Scroll to bottom of screen and click the install icon associated with Shoutbox module
5) After installation complete is indicated
   - return to Modules Administration, cursor to Shoutbox and set order = 0
6) Don't forget to modify Shoutbox Preferences for desired features

Update from version 4.02 or earlier to v4.05 - Instructions:
1) After downloading, unzip the package
2) VERY IMPORTANT: Backup your XOOPS database before continuing with this procedure
3) Due to the fact that the local copy of captcha class has now been removed we
   recommend removing the existing shoutbox subdirectory from the modules directory
   then ftp the new shoutbox directory to the modules directory. Of course copying
   new files to the directory overwriting existing files will still work but several
   files that are no longer used will still be present on your server.
4) Select Administration Menu >> System >> Modules
5) Scroll to Shoutbox module and click the Update icon
6) After update indicates successful completion
   - return to Modules Administration, cursor to Shoutbox and set order = 0
7) Don't forget to modify Shoutbox Preferences for desired features. Be sure to
   check the Captcha Enable setting since this parameter has now changed from
   a Yes/No option to an options list.

Update from version 4.03 or 4.04 to v4.05 - Instructions:
1) After downloading, unzip the package
2) VERY IMPORTANT: Backup your XOOPS database before continuing with this procedure
3) Upload the directory labeled 'shoutbox' to your server into the 'modules' subdirectory
   overwriting all existing files.
4) Select Administration Menu >> System >> Modules
5) Scroll to Shoutbox module and click the Update icon
6) After update indicates successful completion
   - return to Modules Administration, cursor to Shoutbox and set order = 0
7) Don't forget to modify Shoutbox Preferences for desired features.
   
Using Word Censor
For word censoring go to Admin Menu -> System -> Preferences -> Word Censoring Options
enable word censoring and update the fields for bad words to censor and the replacement
phrase to be used. Visitors will see the replacement text wherever bad words are
detected. The original unaltered text entry can be viewed through the module admin
interface by selecting Database or File as applicable.

Modifying Guest Avatars
You can replace the guest avatars supplied with the module release to your own
creations. The files are located in the shoutbox/images/guestavatars/ subdirectory.
The files are labeled:
  guest1.gif
  guest2.gif
  guest3.gif
  guest4.gif
  guest5.gif
Each image is 80px wide by 80px high.

For defining display attributes of your shoutbox a style sheet has been provided.
The file is /shoutbox/style/shoutbox.css
You can open this file and change tag attribute definitions to suit your needs.