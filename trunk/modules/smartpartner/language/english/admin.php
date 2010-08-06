<?php

/**
 * $Id: admin.php,v 1.9 2005/04/21 15:09:32 malanciault Exp $
 * Module: SmartPartner
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

// Including common language file
Global $xoopsConfig;

$commonFile = "../include/common.php";
if (!file_exists($commonFile)) {
    $commonFile = "include/common.php";
}

include_once($commonFile);

$fileName = SMARTPARTNER_ROOT_PATH . 'language/' . $xoopsConfig['language'] . '/common.php';
if (file_exists($fileName)) {
    include_once $fileName;
} else {
    include_once SMARTPARTNER_ROOT_PATH . 'language/english/common.php';
}

define("_AM_SPARTNER_ABOUT", "About");
define("_AM_SPARTNER_ACTION", "Action");
define("_AM_SPARTNER_ACTIVATE_PARTNER", "Activate partner");
define("_AM_SPARTNER_ACTIVE", _CO_SPARTNER_ACTIVE);
define("_AM_SPARTNER_ACTIVE_EDIT_SUCCESS", "The partner has been successfully edited.");
define("_AM_SPARTNER_ACTIVE_EDITING", "Editing an active partner");
define("_AM_SPARTNER_ACTIVE_EDITING_INFO", "You can edit this active partner. Modifications will immediatly take effect in the user side.");
define("_AM_SPARTNER_ACTIVE_EXP", "<b>Active partners</b> : Actual active partners of this site.");
define("_AM_SPARTNER_ACTIVE_PARTNERS", "Active partners");
define("_AM_SPARTNER_ACTIVE_PARTNERS_DSC", "Here is a list of active partners. These partners are displayed in the user side. You can edit or delete each partners by clicking on the related button in the <b>Action</b> column.");
define("_AM_SPARTNER_ALL", "All");
define("_AM_SPARTNER_ALL_EXP", "<b>All status</b> : All partners of the module, whatever their status.");
define("_AM_SPARTNER_ALLITEMS", "All partners of the module");
define("_AM_SPARTNER_ALLITEMSMSG", "Select a status to see all available partners in the selected status. You can also select the sort order of the partners that are displayed.");
define("_AM_SPARTNER_APPROVE", "Approve");
define("_AM_SPARTNER_APPROVING", "Approving");
define("_AM_SPARTNER_ASC", "Ascending");
define("_AM_SPARTNER_AVAILABLE", "<span style='font-weight: bold; color: green;'>Available</span>");
define("_AM_SPARTNER_BLOCKS", "Blocks and groups");
define("_AM_SPARTNER_BLOCKSANDGROUPS", "Blocks and groups");
define("_AM_SPARTNER_BLOCKSTXT", "This module has the following blocks, which you can configure here or in the system module.");
define("_AM_SPARTNER_BY", "By");
define("_AM_SPARTNER_CANCEL", _CO_SPARTNER_CANCEL);
define("_AM_SPARTNER_CLEAR", _CO_SPARTNER_CLEAR);
define("_AM_SPARTNER_CREATE", _CO_SPARTNER_CREATE);
define("_AM_SPARTNER_CREATETHEDIR", "Create the folder");
define("_AM_SPARTNER_DELETE", "Delete");
define("_AM_SPARTNER_DELETEPARTNER", _CO_SPARTNER_DELETEPARTNER);
define("_AM_SPARTNER_DELETETHISP", "Do you really want to delete this partner ?");
define("_AM_SPARTNER_DESC", "Descending");
define("_AM_SPARTNER_DESCRIPTION", _CO_SPARTNER_DESCRIPTION);
define("_AM_SPARTNER_DESCRIPTION_DSC", _CO_SPARTNER_DESCRIPTION_DSC);
define("_AM_SPARTNER_DIRCREATED", "Folder successfully created ");
define("_AM_SPARTNER_DIRNOTCREATED", "The folder could not be created ");
define("_AM_SPARTNER_EDITING", "Editing");
define("_AM_SPARTNER_EDITPARTNER", _CO_SPARTNER_EDITPARTNER);
define("_AM_SPARTNER_GOMOD", "Go to module");
define("_AM_SPARTNER_GROUPS", "Groups");
define("_AM_SPARTNER_GROUPSINFO", "Configure module and blocks permissions for each group");
define("_AM_SPARTNER_HELP", "Help");
define("_AM_SPARTNER_HITS", _CO_SPARTNER_HITS);
define("_AM_SPARTNER_ID", "Partner's id");
define("_AM_SPARTNER_IMPORT", "Import");
define("_AM_SPARTNER_IMPORT_ALL_PARTNERS", "All partners");
define("_AM_SPARTNER_IMPORT_AUTOAPPROVE", "Auto-approve");
define("_AM_SPARTNER_IMPORT_BACK", "Back to the import page");
define("_AM_SPARTNER_IMPORT_ERROR", "An error occured while importing the partner.");
define("_AM_SPARTNER_IMPORT_FILE_NOT_FOUND", "Import file not found at <b>%s</b>");
define("_AM_SPARTNER_IMPORT_FROM", "Importing from %s");
define("_AM_SPARTNER_IMPORT_INFO", "You can import partners directly in SmartPartner. Simply select from which module you would like to import the partners and click on the 'Import' button.");
define("_AM_SPARTNER_IMPORT_MODULE_FOUND", "%s module was found. There are %s partners that can be imported.");
define("_AM_SPARTNER_IMPORT_NO_MODULE", "As XoopsPartners in not installed on this site, there is no partner to import.");
define("_AM_SPARTNER_IMPORT_PARTNER_ERROR", "An error occured while importing '%s'.");
define("_AM_SPARTNER_IMPORT_RESULT", "Here is the result of the import.");
define("_AM_SPARTNER_IMPORT_SETTINGS", "Import Settings");
define("_AM_SPARTNER_IMPORT_SUCCESS", "The partners were successfully imported in the module.");
define("_AM_SPARTNER_IMPORT_TITLE", "Import Partners");
define("_AM_SPARTNER_IMPORT_XOOPSPARTNERS_110", "Partners from XoopsPartners 1.1");
define("_AM_SPARTNER_IMPORTED_PARTNER", "Imported partner : <em>%s</em>");
define("_AM_SPARTNER_IMPORTED_PARTNERS", "Partners imported : <em>%s</em>");
define("_AM_SPARTNER_IMPORT_SELECTION", "Import Selection");
define("_AM_SPARTNER_IMPORT_SELECT_FILE", "Partners");
define("_AM_SPARTNER_IMPORT_SELECT_FILE_DSC", "Choose the module from which to import the partners.");
define("_AM_SPARTNER_INACTIVATE_PARTNER", "Deactivate partner");
define("_AM_SPARTNER_INACTIVE", _CO_SPARTNER_INACTIVE);
define("_AM_SPARTNER_INACTIVE_EDITING", "Editing an inactive partner");
define("_AM_SPARTNER_INACTIVE_EDITING_INFO", "You can edit this inactive partner. Modifications will be saved for this partner. However, if you would like to display this partner in the user side, you will need to set the <b>Status</b> field to 'Active'.");
define("_AM_SPARTNER_INACTIVE_EXP", "<b>Inactive partners</b> : Active partners that has become, for some reason, inactive. An inactive partner is not displayed in the user side.");
define("_AM_SPARTNER_INACTIVE_FIELD", "Inactive");
define("_AM_SPARTNER_INACTIVE_PARTNERS", "Inactive partners");
define("_AM_SPARTNER_INDEX", "Index");
define("_AM_SPARTNER_INTRO", _CO_SPARTNER_INTRO);
define("_AM_SPARTNER_INVENTORY", _CO_SPARTNER_INVENTORY);
define("_AM_SPARTNER_LOGO", _CO_SPARTNER_LOGO);
define("_AM_SPARTNER_LOGO_DSC", _CO_SPARTNER_LOGO_DSC);
define("_AM_SPARTNER_LOGO_UPLOAD", _CO_SPARTNER_LOGO_UPLOAD);
define("_AM_SPARTNER_LOGO_UPLOAD_DSC", _CO_SPARTNER_LOGO_UPLOAD_DSC);
define("_AM_SPARTNER_MODADMIN", "Admin :");
define("_AM_SPARTNER_MODIFY", _CO_SPARTNER_MODIFY);
define("_AM_SPARTNER_NAME", _CO_SPARTNER_NAME);
define("_AM_SPARTNER_NO", "No");
define("_AM_SPARTNER_NOPARTNERS", _CO_SPARTNER_NOPARTNERS);
define("_AM_SPARTNER_NOTAVAILABLE", "<span style='font-weight: bold; color: red;'>Not available</span>");
define("_AM_SPARTNER_OPTS", "Preferences");
define("_AM_SPARTNER_OPTIONS", "Options");
define("_AM_SPARTNER_PARTNER", _CO_SPARTNER_PARTNER);
define("_AM_SPARTNER_PARTNER_APPROVE", "Approve this partner");
define("_AM_SPARTNER_PARTNER_CREATE", _CO_SPARTNER_PARTNER_CREATE);
define("_AM_SPARTNER_PARTNER_CREATED", _CO_SPARTNER_PARTNER_CREATED);
define("_AM_SPARTNER_PARTNER_CREATING", _CO_SPARTNER_PARTNER_CREATING);
define("_AM_SPARTNER_PARTNER_CREATING_DSC", _CO_SPARTNER_PARTNER_CREATING_DSC);
define("_AM_SPARTNER_PARTNER_DELETE", _CO_SPARTNER_PARTNER_DELETE);
define("_AM_SPARTNER_PARTNER_DELETE_ERROR", "An error occured while deleting this partner.");
define("_AM_SPARTNER_PARTNER_DELETE_SUCCESS", "The partner has been successfully deleted.");
define("_AM_SPARTNER_PARTNER_EDIT", _CO_SPARTNER_PARTNER_EDIT);
define("_AM_SPARTNER_PARTNER_INFORMATIONS", _CO_SPARTNER_PARTNER_INFORMATIONS);
define("_AM_SPARTNER_PARTNER_NOT_CREATED", _CO_SPARTNER_PARTNER_NOT_CREATED);
define("_AM_SPARTNER_PARTNER_NOT_SELECTED", "You did not select a valid partner.");
define("_AM_SPARTNER_PARTNER_NOT_UPDATED", _CO_SPARTNER_PARTNER_NOT_UPDATED);
define("_AM_SPARTNER_PARTNERS", _CO_SPARTNER_PARTNERS);
define("_AM_SPARTNER_PATH", "Path");
define("_AM_SPARTNER_PATH_ITEM", "Upload items");
define("_AM_SPARTNER_PATH_IMAGES", "Partners logo");
define("_AM_SPARTNER_PATHCONFIGURATION", "Module Path Configuration");
define("_AM_SPARTNER_POSITION", "Position");
define("_AM_SPARTNER_REJECTED", _CO_SPARTNER_REJECTED);
define("_AM_SPARTNER_REJECTED_EXP", "<b>Rejected partners</b> : Submitted partners that have been rejected. A rejected partner is not displayed in the user side.");
define("_AM_SPARTNER_REJECTED_PARTNERS", "Rejected partners");
define("_AM_SPARTNER_REJECTED_EDITING", "Editing a rejected partner");
define("_AM_SPARTNER_REJECTED_EDITING_INFO", "You can edit this rejected partner. Modifications will be saved for this partner. However, if you would like to display this partner in the user side, you will need to set the <b>Status</b> field to 'Active'.");
define("_AM_SPARTNER_SELECT_SORT", "Select sort order :");
define("_AM_SPARTNER_SELECT_STATUS", "Select a status");
define('_AM_SB_SETMPERM','Set the permission');
define("_AM_SPARTNER_SHOWING", "Showing");
define("_AM_SPARTNER_SMARTPARTNER_IMPORT_SETTINGS", "SmartPartner Import Settings");
define("_AM_SPARTNER_SMARTPARTNER_IMPORT_SETTINGS_VALUE", "There is no import settings. Please click the Import button to start the import.");
define("_AM_SPARTNER_STATUS", _CO_SPARTNER_STATUS);
define("_AM_SPARTNER_STATUS_DSC", "Select the status of the partner. Inactive partner are not displayed in the public section.");
define("_AM_SPARTNER_SUMMARY", _CO_SPARTNER_SUMMARY);
define("_AM_SPARTNER_SUMMARY_REQ", _CO_SPARTNER_SUMMARY_REQ);
define("_AM_SPARTNER_SUMMARY_DSC", _CO_SPARTNER_SUMMARY_DSC);
define("_AM_SPARTNER_SUBMITTED", _CO_SPARTNER_SUBMITTED);
define("_AM_SPARTNER_SUBMITTED_APPROVE_SUCCESS", "The submitted partner has been approved.");
define("_AM_SPARTNER_SUBMITTED_EXP", "<b>Submitted partners</b> : Potential partners that have submitted their organisation to become a partner of this site.");
define("_AM_SPARTNER_SUBMITTED_INFO", "This partner have been submitted on your site. You can edit it as you like. You can make some modifications if you'd like. Upon approval, this partner will be displayed in the user side of this site.");
define("_AM_SPARTNER_SUBMITTED_PARTNERS", "Submitted partners");
define("_AM_SPARTNER_SUBMITTED_TITLE", "Submitted partner");
define("_AM_SPARTNER_TITLE", "Partner's name");
define("_AM_SPARTNER_TITLE_REQ", _CO_SPARTNER_TITLE_REQ);
define("_AM_SPARTNER_TOTAL_SUBMITTED", "Submitted : ");
define("_AM_SPARTNER_TOTAL_ACTIVE", "Active : ");
define("_AM_SPARTNER_TOTAL_REJECTED", "Rejected : ");
define("_AM_SPARTNER_TOTAL_INACTIVE", "Inactive : ");
define("_AM_SPARTNER_URL", _CO_SPARTNER_URL);
define("_AM_SPARTNER_URL_DSC", _CO_SPARTNER_URL_DSC);
define("_AM_SPARTNER_WEIGHT", _CO_SPARTNER_WEIGHT);
define("_AM_SPARTNER_WEIGHT_DSC", _CO_SPARTNER_WEIGHT_DSC);
define("_AM_SPARTNER_YES", "Yes");


//Redirect messages
define("_AM_SPARTNER_NOTSET_ACTIVE_SUCCESS", "The partner has been created.");
define("_AM_SPARTNER_NOTSET_INACTIVE_SUCCESS", "The partner has been created and deactivated.");
define("_AM_SPARTNER_SUBMITTED_ACTIVE_SUCCESS", "The submitted partner has been approved !");
define("_AM_SPARTNER_SUBMITTED_INACTIVE_SUCCESS", "The submitted partner has been deactivated.");
define("_AM_SPARTNER_SUBMITTED_REJECTED_SUCCESS", "The submitted partner has been rejected.");
define("_AM_SPARTNER_ACTIVE_ACTIVE_SUCCESS", "The partner has been updated.");
define("_AM_SPARTNER_ACTIVE_INACTIVE_SUCCESS", "The partner has been deactivated.");
define("_AM_SPARTNER_INACTIVE_ACTIVE_SUCCESS", "The inactive partner has been activated.");
define("_AM_SPARTNER_INACTIVE_INACTIVE_SUCCESS", "The inactive partner has been updated.");
define("_AM_SPARTNER_REJECTED_ACTIVE_SUCCESS", "The rejected  partner has been activated !");
define("_AM_SPARTNER_REJECTED_INACTIVE_SUCCESS", "The rejected partner has been deactivated.");
define("_AM_SPARTNER_REJECTED_REJECTED_SUCCESS", "The rejected partner has been updated.");
?>