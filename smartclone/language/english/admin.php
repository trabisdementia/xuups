<?php

/**
 * $Id: admin.php,v 1.2 2006/11/08 15:02:47 marcan Exp $
 * Module: SmartHelp
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

define("_AM_SCLONE_CLONE_A_MODULE", "Clone a module");
define("_AM_SCLONE_CLONEFORM_TILE", "Clone a module");
define("_AM_SCLONE_CLONEFORM_DSC", "Fill out the following form in order to clone a module installed on your site.");
define("_AM_SCLONE_MODULE_SELECT", "Select a module to clone");
define("_AM_SCLONE_MODULE_SELECT_DSC", "Select the module you would like to clone. If the module you want to clone is not in this list, then this module is not yet supported by SmartClone.");

define("_AM_SCLONE_NEWNAME", "New module name");
define("_AM_SCLONE_NEWNAME_DSC", "Enter the name of the new module that will be created by this cloning feature. <br />For example : <b>SmartSection2</b>");

define("_AM_SCLONE_NEW_MODULE_ALREADY_EXISTS", "There is already a module named '%s'. Please select a different name.");
define("_AM_SCLONE_CHANGE_PERMISSION_FAILED", "It was not possible to change permissions for creating the clone module.");
define("_AM_SCLONE_INVALID_SELECTION", "Please select a module to clone and enter a name for this clone.");
define("_AM_SCLONE_SUCCESS", "The module has been successfully cloned !");

define("_AM_SCLONE_INSTALL_CHECK", "Would you like to be directed to the install screen of the new module once it has been cloned ?");

define("_AM_SCLONE_WHERE_OTHER_MODULE", "Where are my other modules ?");
define("_AM_SCLONE_WHERE_OTHER_MODULE_EXP", "For a module to appear in this select box, it has to be present on your site AND it needs to have a related plugin file in the smartclone/plugins folder. If you would like to a clone a module for which no plugin has already been written, we encourage you to create it yourself ! Simply copy one of the plugin file already in that folder and rename the file with the name of this new module. We have documented the plugin structure directly in the file so please read all the commented code.");
?>