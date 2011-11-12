<?php
// @author      Gregory Mage (Aka Mage)
//***************************************************************************************
// index.php
define('_AM_EXTCAL_CONFIG_CHECK', 'Configurations');
define('_AM_EXTCAL_CONFIG_PHP', "You must have at least  %s as a php version (your current version is %s)");
define('_AM_EXTCAL_CONFIG_XOOPS', "You must have at least the version %s (your current version is %s)");
define('_AM_EXTCAL_INDEX_CATEGORIES', "Number of categories: %s");
define('_AM_EXTCAL_INDEX_EVENT', "Number of Events in DB: %s");
define('_AM_EXTCAL_INDEX_PENDING', "Pendings events: %s");
define('_AM_EXTCAL_INDEX_APPROVED', "Events for approval: %s");
//***************************************************************************************


define('_AM_EXTCAL_GO_TO_MODULE', 'Go to module');
define('_AM_EXTCAL_PREFERENCES', 'Preferences');
define('_AM_EXTCAL_ADMINISTRATION', 'Administration');

define('_AM_EXTCAL_CATEGORY', 'Category');
define('_AM_EXTCAL_EVENT', 'Event');
define('_AM_EXTCAL_MODULE_ADMIN_SUMMARY', 'eXtCal Administration Summary');
define('_AM_EXTCAL_UPDATE_INFO', 'Update Information');
define('_AM_EXTCAL_CHECK_UPDATE_ERROR', 'Can\'t retrive the last version of eXtCal.');
define('_AM_EXTCAL_UPDATE_KO', 'Your eXtCal version is obsolete. We recommand to check out new eXtCal version on <a href=\"http://www.zoullou.net/\">Zoullou.net</a>.');
define('_AM_EXTCAL_UPDATE_UPGRADE', 'Click here to upgrade module to the newer version');
define('_AM_EXTCAL_UPDATE_OK', 'You are running eXtCal with the latest updates for stability and security.');
define('_AM_EXTCAL_PENDING', 'Pending');
define('_AM_EXTCAL_APPROVED', 'Approved');
define('_AM_EXTCAL_SUBMITTED_EVENT', 'Submitted Event');
define('_AM_EXTCAL_INFORMATION', 'Information');
define('_AM_EXTCAL_PENDING_EVENT', 'Pending Event');
define('_AM_EXTCAL_INFO_APPROVE_PENDING_EVENT', '<b>Approve</b> new event without read information.');
define('_AM_EXTCAL_INFO_EDIT_PENDING_EVENT', '<b>Edit</b> new event before approving it.');
define('_AM_EXTCAL_INFO_DELETE_PENDING_EVENT', '<b>Delete</b> the new event.');
define('_AM_EXTCAL_TITLE', 'Title');
define('_AM_EXTCAL_START_DATE', 'Start Date');
define('_AM_EXTCAL_ACTION', 'Action');
define('_AM_NO_PENDING_EVENT', 'No pending Event');
define('_AM_EXTCAL_EDIT_OR_DELETE_CATEGORY', 'Edit or Delete category');
define('_AM_EXTCAL_EDIT_CATEGORY', 'Edit category');
define('_AM_EXTCAL_ADD_CATEGORY', 'Add category');
define('_AM_EXTCAL_NAME', 'Name');
define('_AM_EXTCAL_DESCRIPTION', 'Description');
define('_AM_EXTCAL_COLOR', 'Color');
define('_AM_EXTCAL_APPROVED_EVENT', 'Approve event');
define('_AM_EXTCAL_INFO_EDIT', '<b>Edit</b> event.');
define('_AM_EXTCAL_INFO_DELETE', '<b>Delete</b> event.');
define('_AM_EXTCAL_VIEW_PERMISSION', 'View permission');
define('_AM_EXTCAL_VIEW_PERMISSION_DESC', 'Select categories that each group is allowed to view');
define('_AM_EXTCAL_SUBMIT_PERMISSION', 'Submit permission');
define('_AM_EXTCAL_SUBMIT_PERMISSION_DESC', 'Select categories that each group is allowed to submit');
define('_AM_EXTCAL_AUTOAPPROVE_PERMISSION', 'Autoprove permission');
define('_AM_EXTCAL_AUTOAPPROVE_PERMISSION_DESC', 'Select categories that each group needn\'t approve for submitted event');
define('_AM_EXTCAL_PERM_NO_CATEGORY', 'You must create category first');
define('_AM_EXTCAL_CAT_EDITED', 'Category edited');
define('_AM_EXTCAL_CAT_CREATED', 'Category created');
define('_AM_EXTCAL_EVENT_EDITED', 'Event edited');
define('_AM_EXTCAL_EVENT_CREATED', 'Event created');
define('_AM_EXTCAL_PUBLIC_PERM_MASK', 'Public permissions mask');
define('_AM_EXTCAL_PUBLIC_PERM_MASK_INFO', 'You can set here the default mask permission who will be apply to new category. Be carefull to don\'t give excessive permissions here because all new category will give them.');
define('_AM_EXTCAL_GROUP_NAME', 'Group name');
define('_AM_EXTCAL_CAN_VIEW', 'Can view');
define('_AM_EXTCAL_CAN_SUBMIT', 'Can submit');
define('_AM_EXTCAL_AUTO_APPROVE', 'Auto approve sumitted event');
define('_AM_EXTCAL_MD_FILE_DONT_EXIST', 'Module file don\'t exist on repository :<br /><b>Server : </b>%s<br /><b>File : </b>%s');
define('_AM_EXTCAL_LG_FILE_DONT_EXIST', 'Language file don\'t exist on repository :<br /><b>Server : </b>%s<br /><b>File : </b>%s');
define('_AM_EXTCAL_DOWN_DONE', 'Downloading done. Click here to install files');
define('_AM_EXTCAL_INSTALL', 'Install files');
define('_AM_EXTCAL_MD_FILE_DONT_EXIST_SHORT', 'Module file don\'t exist');
define('_AM_EXTCAL_INSTALL_DONE', 'Installing done. Click here to update your module');
define('_AM_EXTCAL_UPDATE', 'Update module');
define('_AM_EXTCAL_PERM_MASK_UPDATED', 'Permission mask updated');
define('_AM_EXTCAL_CAN_EDIT', 'Can edit');
define('_AM_EXTCAL_EDIT_PERMISSION', 'Edit permission');
define('_AM_EXTCAL_EDIT_PERMISSION_DESC', 'Select categories where each group is allowed to edit there own event');
define('_AM_EXTCAL_CONFIRM_DELETE_EVENT', 'Confirm delete event.');
define('_AM_EXTCAL_EVENT_DELETED', 'Event successfully deleted.');

//added in 2.23

// About.php
define('_AM_EXTCAL_ABOUT_RELEASEDATE', 'Released: ');
define('_AM_EXTCAL_ABOUT_UPDATEDATE', 'Updated: ');
define('_AM_EXTCAL_ABOUT_AUTHOR', 'Author: ');
define('_AM_EXTCAL_ABOUT_CREDITS', 'Credits: ');
define('_AM_EXTCAL_ABOUT_LICENSE', 'License: ');
define('_AM_EXTCAL_ABOUT_MODULE_STATUS', 'Status: ');
define('_AM_EXTCAL_ABOUT_WEBSITE', 'Website: ');
define('_AM_EXTCAL_ABOUT_AUTHOR_NAME', 'Author name: ');
define('_AM_EXTCAL_ABOUT_CHANGELOG', 'Change Log');
define('_AM_EXTCAL_ABOUT_MODULE_INFO', 'Module Infos');
define('_AM_EXTCAL_ABOUT_AUTHOR_INFO', 'Author Infos');
define('_AM_EXTCAL_ABOUT_DESCRIPTION', 'Description: ');

define('_AM_EXTCAL_CONFIRM_DELETE_CAT', 'Confirm to delete category');
define('_AM_EXTCAL_CAT_DELETED', 'Category successfully deleted.');
define('_AM_EXTCAL_NOPERMSSET', 'Permission cannot be set: There are no Categories created yet! Please create a Category first.');
?>
