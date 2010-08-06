<?php

/**
 * $Id: folder.php,v 1.1 2005/05/13 18:21:55 malanciault Exp $
 * Module: SmartMedia
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

include_once("admin_header.php");

global $smartmedia_folder_handler;

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

/* Possible $op :
 mod : Displaying the form to edit or add a folder
 mod_text : Displaying the form to edit a folder language info
 add_folder : Adding or editing a folder in the db
 add_folder_text : Adding or editing a folder language info in the db
 del : deleting a folder
 */

// At what folder do we start
$startfolder = isset($_GET['startfolder']) ? intval($_GET['startfolder']) : 0;

// Display a single folder
function displayFolder_text($folder_textObj)
{
    Global $xoopsModule, $smartmedia_folder_handler;

    $modify = "<a href='folder.php?op=modtext&folderid=" . $folder_textObj->folderid() . "&languageid=" . $folder_textObj->languageid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_SMEDIA_FOLDER_EDIT . "' alt='" . _AM_SMEDIA_FOLDER_EDIT . "' /></a>";
    $delete = "<a href='folder.php?op=deltext&folderid=" . $folder_textObj->folderid() . "&languageid=" . $folder_textObj->languageid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_SMEDIA_FOLDER_DELETE . "' alt='" . _AM_SMEDIA_FOLDER_DELETE . "' /></a>";
    echo "<tr>";
    echo "<td class='even' align='left'>" . $folder_textObj->languageid() . "</td>";
    echo "<td class='even' align='left'> " . $folder_textObj->title() . " </td>";
    echo "<td class='even' align='center'> " . $modify . $delete . " </td>";
    echo "</tr>";
}

// Add or edit a folder or a folder language info in the db
function addFolder($language_text=false)
{
    global $xoopsUser, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $myts, $smartmedia_folder_handler;
    include_once(XOOPS_ROOT_PATH."/class/uploader.php");

    $max_size = 10000000;
    $max_imgwidth = 1000;
    $max_imgheight = 1000;
    $allowed_mimetypes = smartmedia_getAllowedMimeTypes();
    $upload_msgs = array();

    $folderid = (isset($_POST['folderid'])) ? intval($_POST['folderid']) : 0;

    if (isset($_POST['languageid'])) {
        $languageid = $_POST['languageid'];
    } elseif (isset($_POST['default_languageid'])) {
        $languageid = $_POST['default_languageid'];
    } else {
        $languageid = $xoopsModuleConfig['default_language'];
    }

    If ($folderid != 0) {
        $folderObj = $smartmedia_folder_handler->get($folderid, $languageid);
    } else {
        $folderObj = $smartmedia_folder_handler->create();
    }

    if (!$language_text) {
        /*		// Upload lr_image
         if ( $_FILES['lr_image_file']['name'] != "" ) {
         $filename = $_POST["xoops_upload_file"][0] ;
         if( !empty( $filename ) || $filename != "" ) {

         if( $_FILES[$filename]['tmp_name'] == "" || ! is_readable( $_FILES[$filename]['tmp_name'] ) ) {
         $upload_msgs[_AM_SMEDIA_FILEUPLOAD_ERROR];
         } else {
         $uploader = new XoopsMediaUploader(smartmedia_getImageDir('folder'), $allowed_mimetypes, $max_size, $max_imgwidth, $max_imgheight);

         if( $uploader->fetchMedia( $filename ) && $uploader->upload() ) {
         $folderObj->setVar('image_lr', $uploader->getSavedFileName());
         } else {
         $upload_msgs[_AM_SMEDIA_FILEUPLOAD_ERROR];
         }
         }
         }
         } else {
         $folderObj->setVar('image_lr', $_POST['image_lr']);
         }
         */
        // Upload hr_image
        if ( $_FILES['hr_image_file']['name'] != "" ) {
            $filename = $_POST["xoops_upload_file"][0] ;
            if( !empty( $filename ) || $filename != "" ) {

                if( $_FILES[$filename]['tmp_name'] == "" || ! is_readable( $_FILES[$filename]['tmp_name'] ) ) {
                    $upload_msgs[_AM_SMEDIA_FILEUPLOAD_ERROR];
                } else {
                    $uploader = new XoopsMediaUploader(smartmedia_getImageDir('folder'), $allowed_mimetypes, $max_size, $max_imgwidth, $max_imgheight);
                     
                    if( $uploader->fetchMedia( $filename ) && $uploader->upload() ) {
                        $folderObj->setVar('image_hr', $uploader->getSavedFileName());
                    } else {
                        $upload_msgs[_AM_SMEDIA_FILEUPLOAD_ERROR];
                    }
                }
            }
        } else {
            $folderObj->setVar('image_hr', $_POST['image_hr']);
        }

        $folderObj->setVar('statusid', (isset($_POST['statusid'])) ? intval($_POST['statusid']) : 0);
        $folderObj->setVar('categoryid', (isset($_POST['categoryid'])) ? intval($_POST['categoryid']) : 0);
        $folderObj->setVar('new_category', (isset($_POST['category_action'])) ? $_POST['category_action']=='add' : false);
        $folderObj->setVar('weight', (isset($_POST['weight'])) ? intval($_POST['weight']) : 1);
        $folderObj->setVar('default_languageid', (isset($_POST['default_languageid'])) ? $_POST['default_languageid'] : $xoopsModuleConfig['default_language']);
        $folderObj->setTextVar('languageid', (isset($_POST['default_languageid'])) ? $_POST['default_languageid'] : $xoopsModuleConfig['default_language']);
    } else {
        $folderObj->setTextVar('languageid', $languageid);
    }

    $folderObj->setTextVar('languageid', $languageid);
    $folderObj->setTextVar('title', $_POST['title']);
    $folderObj->setTextVar('short_title', $_POST['short_title']);
    $folderObj->setTextVar('summary', $_POST['summary']);
    $folderObj->setTextVar('description', $_POST['description']);
    $folderObj->setTextVar('meta_description', $_POST['meta_description']);

    if ($folderObj->isNew()) {
        $redirect_msg = _AM_SMEDIA_FOLDER_CREATED;
        $redirect_to = 'folder.php';
    } else {
        if ($language_text) {
            $redirect_to = 'folder.php?op=mod&folderid=' . $folderObj->folderid();
        } else {
            $redirect_to = 'folder.php';
        }
        $redirect_msg = _AM_SMEDIA_FOLDER_MODIFIED;
    }

    If ( !$folderObj->store() ) {
        redirect_header("javascript:history.go(-1)", 3, _AM_SMEDIA_FOLDER_SAVE_ERROR . smartmedia_formatErrors($folderObj->getErrors()));
        exit;
    }

    redirect_header($redirect_to, 2, $redirect_msg);

    exit();
}

// Edit folder information. Also used to add a folder
function editfolder($showmenu = false, $folderid = 0, $categoryid = 0)
{
    Global $xoopsDB, $smartmedia_folder_handler, $xoopsUser, $myts, $xoopsConfig, $xoopsModuleConfig, $xoopsModule;
    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    // if $folderid == 0 then we are adding a new folder
    $newFolder = ($folderid == 0);

    echo "<script type=\"text/javascript\" src=\"funcs.js\"></script>";
    echo "<style>";
    echo "<!-- ";
    echo "select { width: 130px; }";
    echo "-->";
    echo "</style>";
    $cat_sel = '';

    if (!$newFolder) {
        // We are editing a folder

        // Creating the folder object for the selected folder
        $folderObj = $smartmedia_folder_handler->get($folderid);
        $cat_sel = "&folderid=" . $folderObj->folderid();
        $folderObj->loadLanguage($folderObj->default_languageid());

        if ($showmenu) {
            smartmedia_adminMenu(2, _AM_SMEDIA_FOLDERS . " > " . _AM_SMEDIA_EDITING);
        }
        echo "<br />\n";
        if ($folderObj->notLoaded()) {
            redirect_header("folder.php", 1, _AM_SMEDIA_NOFOLDERTOEDIT);
            exit();
        }
        smartmedia_collapsableBar('bottomtable', 'bottomtableicon');
        echo "<img id='bottomtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SMEDIA_FOLDER_EDIT . "</h3>";
        echo "<div id='bottomtable'>";
        echo "<span style=\"color: #567; margin: 3px 0 18px 0; font-size: small; display: block; \">" . _AM_SMEDIA_FOLDER_EDIT_INFO . "</span>";
    } else {
        // We are creating a new folder

        $folderObj = $smartmedia_folder_handler->create();
        if ($showmenu) {
            smartmedia_adminMenu(2, _AM_SMEDIA_FOLDERS . " > " . _AM_SMEDIA_CREATINGNEW);
        }
        echo "<br />\n";
        smartmedia_collapsableBar('bottomtable', 'bottomtableicon');
        echo "<img id='bottomtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SMEDIA_FOLDER_CREATE . "</h3>";
        echo "<div id='bottomtable'>";
        echo "<span style=\"color: #567; margin: 3px 0 18px 0; font-size: small; display: block; \">" . _AM_SMEDIA_FOLDER_CREATE_INFO . "</span>";
    }
    if (!$newFolder) {
        /* If it's not a new folder, lets display the already created folder language info
         for this folder, as well as a button to create a new folder language info */

        if ($folderObj->canAddLanguage()) {
            // If not all languages have been added
             
            echo "<form><div style=\"margin-bottom: 0px;\">";
            echo "<input type='button' name='button' onclick=\"location='folder.php?op=modtext&folderid=" . $folderObj->folderid() . "'\" value='" . _AM_SMEDIA_FOLDER_TEXT_CREATE . "'>&nbsp;&nbsp;";
            echo "</div></form>";
            echo "</div>";
        }

        echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
        echo "<tr>";
        echo "<td width='20%' class='bg3' align='left'><b>" . _AM_SMEDIA_LANGUAGE . "</b></td>";
        echo "<td class='bg3' align='left'><b>" . _AM_SMEDIA_FOLDER_TITLE . "</b></td>";
        echo "<td width='60' class='bg3' align='center'><b>" . _AM_SMEDIA_ACTION . "</b></td>";
        echo "</tr>";

        $folder_textObjs = $folderObj->getAllLanguages(true);
        if (count($folder_textObjs) > 0) {
            foreach ( $folder_textObjs as $key => $thiscat) {
                displayFolder_text($thiscat);
            }
        } else {
            echo "<tr>";
            echo "<td class='head' align='center' colspan= '3'>" . _AM_SMEDIA_NO_LANGUAGE_INFO . "</td>";
            echo "</tr>";
        }

        echo "</table>\n<br/>";
    }

    // Start folder form

    $sform = new XoopsThemeForm(_AM_SMEDIA_FOLDER, "op", xoops_getenv('PHP_SELF'));
    $sform->setExtra('enctype="multipart/form-data"');
    $sform -> addElement( new XoopsFormHidden( 'folderid', $folderid ) );

    // Language
    $languageid_select = new XoopsFormSelectLang(_AM_SMEDIA_LANGUAGE_ITEM, 'default_languageid', $folderObj->default_languageid());
    $languageid_select->setDescription(_AM_SMEDIA_LANGUAGE_ITEM_DSC);
    $languageid_select->addOptionArray(XoopsLists::getLangList());
    if (!$newFolder) {
        $languageid_select->setExtra("style='color: grey;' disabled='disabled'");
    }
    $sform->addElement($languageid_select);

    // title
    $sform->addElement(new XoopsFormText(_AM_SMEDIA_FOLDER_TITLE_REQ, 'title', 50, 255, $folderObj->title('e')), true);

    // short_title
    //$sform->addElement(new XoopsFormText(_AM_SMEDIA_FOLDER_SHORT_TITLE, 'short_title', 50, 255, $folderObj->short_title('e')));
    $sform -> addElement( new XoopsFormHidden( 'short_title', '' ) );


    // summary
    $summary = new XoopsFormTextArea(_AM_SMEDIA_FOLDER_SUMMARY, 'summary', $folderObj->summary('e'), 3, 60);
    $summary ->setDescription(_AM_SMEDIA_FOLDER_SUMMARYDSC);
    $sform->addElement($summary);

    // Description
    $description_text = new XoopsFormTextArea(_AM_SMEDIA_FOLDER_DESCRIPTION, 'description', $folderObj->description('e'), 7, 60);
    $description_text->setDescription(_AM_SMEDIA_FOLDER_DESCRIPTIONDSC);
    $sform->addElement($description_text);

    // Meta-Description
    $meta = new XoopsFormTextArea(_AM_SMEDIA_FOLDER_META_DESCRIPTION, 'meta_description', $folderObj->meta_description('e'), 7, 60);
    $meta->setDescription(_AM_SMEDIA_CLIP_META_DESCRIPTIONDSC);
    $sform->addElement($meta);

    $sform -> addElement( new XoopsFormHidden( 'itemType', 'item_text' ) );

    $category_tray = new XoopsFormElementTray(_AM_SMEDIA_CATEGORY);

    if (!$newFolder) {
        $category_action_select = new XoopsFormSelect('', 'category_action', 'change');
        $category_action_select_array['change'] = _AM_SMEDIA_CATEGORY_CHANGE;
        $category_action_select_array['add'] = _AM_SMEDIA_CATEGORY_ADD;
        $category_action_select->addOptionArray($category_action_select_array);
        $category_tray -> addElement($category_action_select);
    } else {
        $sform -> addElement( new XoopsFormHidden( 'category_action', 'add' ) );
    }

    include_once(SMARTMEDIA_ROOT_PATH . "class/smarttree.php");
    $smarttree = new SmartTree($xoopsDB -> prefix( "smartmedia_categories" ), "categoryid", "parentid" );
    ob_start();
    $smarttree->makeMySelBox( "title", "weight", $categoryid, 0, 'categoryid', '' );

    //makeMySelBox($title,$order="",$preset_id=0, $none=0, $sel_name="", $onchange="")
    $category_tray -> addElement( new XoopsFormLabel( '', ob_get_contents() ) );
    ob_end_clean();

    $sform -> addElement($category_tray);

    // status
    $status_select = new XoopsFormSelect( _AM_SMEDIA_FOLDER_STATUS, 'statusid', $folderObj->statusid() );
    $status_select->addOptionArray(smartmedia_getStatusArray());
    $sform -> addElement( $status_select );

    /*	// LR IMAGE
     $lr_image_array = & XoopsLists :: getImgListAsArray( smartmedia_getImageDir('folder') );
     $lr_image_select = new XoopsFormSelect( '', 'image_lr', $folderObj->image_lr() );
     $lr_image_select -> addOption ('-1', '---------------');
     $lr_image_select -> addOptionArray( $lr_image_array );
     $lr_image_select -> setExtra( "onchange='showImgSelected(\"the_image_lr\", \"image_lr\", \"" . 'uploads/smartmedia/images/folder' . "\", \"\", \"" . XOOPS_URL . "\")'" );
     $lr_image_tray = new XoopsFormElementTray( _AM_SMEDIA_FOLDER_IMAGE_LR, '&nbsp;' );
     $lr_image_tray -> addElement( $lr_image_select );
     $lr_image_tray -> addElement( new XoopsFormLabel( '', "<br /><br /><img src='" . smartmedia_getImageDir('folder', false) .$folderObj->image_lr() . "' name='the_image_lr' id='the_image_lr' alt='' />" ) );
     $lr_image_tray->setDescription(_AM_SMEDIA_FOLDER_IMAGE_LR_DSC);
     $sform -> addElement( $lr_image_tray );

     // LR IMAGE UPLOAD
     $max_size = 5000000;
     $lr_file_box = new XoopsFormFile(_AM_SMEDIA_FOLDER_IMAGE_LR_UPLOAD, "lr_image_file", $max_size);
     $lr_file_box->setExtra( "size ='45'") ;
     $lr_file_box->setDescription(_AM_SMEDIA_FOLDER_IMAGE_LR_UPLOAD_DSC);
     $sform->addElement($lr_file_box);
     */
    // HR IMAGE
    $hr_image_array = & XoopsLists :: getImgListAsArray( smartmedia_getImageDir('folder') );
    $hr_image_select = new XoopsFormSelect( '', 'image_hr', $folderObj->image_hr() );
    $hr_image_select -> addOption ('-1', '---------------');
    $hr_image_select -> addOptionArray( $hr_image_array );
    $hr_image_select -> setExtra( "onchange='showImgSelected(\"the_image_hr\", \"image_hr\", \"" . 'uploads/smartmedia/images/folder' . "\", \"\", \"" . XOOPS_URL . "\")'" );
    $hr_image_tray = new XoopsFormElementTray( _AM_SMEDIA_FOLDER_IMAGE_HR, '&nbsp;' );
    $hr_image_tray -> addElement( $hr_image_select );
    $hr_image_tray -> addElement( new XoopsFormLabel( '', "<br /><br /><img src='" . smartmedia_getImageDir('folder', false) .$folderObj->image_hr() . "' name='the_image_hr' id='the_image_hr' alt='' />" ) );
    $hr_image_tray->setDescription(sprintf(_AM_SMEDIA_FOLDER_IMAGE_HR_DSC, $xoopsModuleConfig['main_image_width']));
    $sform -> addElement( $hr_image_tray );

    // HR IMAGE UPLOAD
    $max_size = 5000000;
    $hr_file_box = new XoopsFormFile(_AM_SMEDIA_FOLDER_IMAGE_HR_UPLOAD, "hr_image_file", $max_size);
    $hr_file_box->setExtra( "size ='45'") ;
    $hr_file_box->setDescription(_AM_SMEDIA_FOLDER_IMAGE_HR_UPLOAD_DSC);
    $sform->addElement($hr_file_box);

    // Weight
    $sform->addElement(new XoopsFormText(_AM_SMEDIA_FOLDER_WEIGHT, 'weight', 4, 4, $folderObj->weight()));

    $sform -> addElement( new XoopsFormHidden( 'itemType', 'item' ) );

    // Action buttons tray
    $button_tray = new XoopsFormElementTray('', '');

    $hidden = new XoopsFormHidden('op', 'addfolder');
    $button_tray->addElement($hidden);

    if ($newFolder) {
        // We are creating a new folder

        $butt_create = new XoopsFormButton('', '', _AM_SMEDIA_CREATE, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'addfolder\'"');
        $button_tray->addElement($butt_create);

        $butt_clear = new XoopsFormButton('', '', _AM_SMEDIA_CLEAR, 'reset');
        $button_tray->addElement($butt_clear);

        $butt_cancel = new XoopsFormButton('', '', _AM_SMEDIA_CANCEL, 'button');
        $butt_cancel->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($butt_cancel);
    } else {

        // We are editing a folder
        $butt_create = new XoopsFormButton('', '', _AM_SMEDIA_MODIFY, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'addfolder\'"');
        $button_tray->addElement($butt_create);

        $butt_cancel = new XoopsFormButton('', '', _AM_SMEDIA_CANCEL, 'button');
        $butt_cancel->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($butt_cancel);
    }

    $sform->addElement($button_tray);
    $sform->display();
    echo "</div>";
    unset($hidden);
}

// Edit folder language info. Also used to add a new folder language info
function editfolder_text($showmenu = false, $folderid, $languageid)
{
    Global $xoopsDB, $smartmedia_folder_handler, $xoopsUser, $myts, $xoopsConfig, $xoopsModuleConfig, $xoopsModule;
    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    echo "<script type=\"text/javascript\" src=\"funcs.js\"></script>";
    echo "<style>";
    echo "<!-- ";
    echo "select { width: 130px; }";
    echo "-->";
    echo "</style>";

    $cat_sel = '';

    $folderObj = $smartmedia_folder_handler->get($folderid, $languageid);

    if ($languageid == 'new') {
        $bread_lang = _AM_SMEDIA_CREATE;
    } else {
        $bread_lang = ucfirst($languageid);
    }

    if ($showmenu) {
        smartmedia_adminMenu(2, _AM_SMEDIA_FOLDERS . " > " . _AM_SMEDIA_LANGUAGE_INFO . " > " . $bread_lang);
    }
    echo "<br />\n";
    smartmedia_collapsableBar('bottomtable', 'bottomtableicon');
    echo "<img id='bottomtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SMEDIA_FOLDER_LANGUAGE_INFO_EDITING . "</h3>";
    echo "<div id='bottomtable'>";
    echo "<span style=\"color: #567; margin: 3px 0 18px 0; font-size: small; display: block; \">" . _AM_SMEDIA_FOLDER_LANGUAGE_INFO_EDITING_INFO . "</span>";

    // Start folder form
    $sform = new XoopsThemeForm(_AM_SMEDIA_FOLDER, "op", xoops_getenv('PHP_SELF'));
    $sform->setExtra('enctype="multipart/form-data"');
    $sform -> addElement( new XoopsFormHidden( 'folderid', $folderid ) );

    // Language
    $languageOptions = array();
    $languageList = XoopsLists::getLangList();
    $createdLanguages = $folderObj->getCreatedLanguages();
    foreach ($languageList as $language) {
        if (($languageid != 'new') || (!in_array($language, $createdLanguages))) {
            $languageOptions[$language] = $language;
        }
    }
    $language_select = new XoopsFormSelect(_AM_SMEDIA_LANGUAGE_ITEM, 'languageid', $languageid);
    $language_select->addOptionArray($languageOptions);
    $language_select->setDescription(_AM_SMEDIA_LANGUAGE_ITEM_DSC);

    if ($languageid != 'new') {
        $language_select->setExtra(smartmedia_make_control_disabled());
        $sform->addElement(new XoopsFormHidden('languageid', $languageid));
    }
    $sform->addElement($language_select, true);
    // title
    $sform->addElement(new XoopsFormText(_AM_SMEDIA_FOLDER_TITLE, 'title', 50, 255, $folderObj->title()), true);
    // title
    $sform->addElement(new XoopsFormText(_AM_SMEDIA_FOLDER_TITLE_REQ, 'title', 50, 255, $folderObj->title()), true);

    // short_title
    //$sform->addElement(new XoopsFormText(_AM_SMEDIA_FOLDER_SHORT_TITLE, 'short_title', 50, 255, $folderObj->short_title()));

    // summary
    $summary = new XoopsFormTextArea(_AM_SMEDIA_FOLDER_SUMMARY, 'summary', $folderObj->summary('e'), 3, 60);
    $summary ->setDescription(_AM_SMEDIA_FOLDER_SUMMARYDSC);
    $sform->addElement($summary);

    // Description
    $description_text = new XoopsFormTextArea(_AM_SMEDIA_FOLDER_DESCRIPTION, 'description', $folderObj->description('e'), 7, 60);
    $description_text->setDescription(_AM_SMEDIA_FOLDER_DESCRIPTIONDSC);
    $sform->addElement($description_text);

    // Meta-Description
    $meta = new XoopsFormTextArea(_AM_SMEDIA_FOLDER_META_DESCRIPTION, 'meta_description', $folderObj->meta_description('e'), 7, 60);
    $meta->setDescription(_AM_SMEDIA_CLIP_META_DESCRIPTIONDSC);
    $sform->addElement($meta);

    $sform -> addElement( new XoopsFormHidden( 'itemType', 'item_text' ) );

    // Action buttons tray
    $button_tray = new XoopsFormElementTray('', '');

    $hidden = new XoopsFormHidden('op', 'addfolder_text');
    $button_tray->addElement($hidden);

    if ($languageid == 'new') {
        // We are creating a new folder language info

        $butt_create = new XoopsFormButton('', '', _AM_SMEDIA_CREATE, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'addfolder_text\'"');
        $button_tray->addElement($butt_create);

        $butt_clear = new XoopsFormButton('', '', _AM_SMEDIA_CLEAR, 'reset');
        $button_tray->addElement($butt_clear);

        $butt_cancel = new XoopsFormButton('', '', _AM_SMEDIA_CANCEL, 'button');
        $butt_cancel->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($butt_cancel);
    } else {
        // We are editing a folder language info

        $butt_create = new XoopsFormButton('', '', _AM_SMEDIA_MODIFY, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'addfolder_text\'"');
        $button_tray->addElement($butt_create);

        $butt_cancel = new XoopsFormButton('', '', _AM_SMEDIA_CANCEL, 'button');
        $butt_cancel->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($butt_cancel);
    }
    $sform->addElement($button_tray);
    $sform->display();
    echo "</div>";
    unset($hidden);
}
switch ($op) {
    // Displaying the form to edit or add a folder
    case "mod":
        $folderid = isset($_GET['folderid']) ? intval($_GET['folderid']) : 0 ;
        $categoryid = isset($_GET['categoryid']) ? intval($_GET['categoryid']) : 0 ;
        xoops_cp_header();
        editfolder(true, $folderid, $categoryid);
        break;

        // Displaying the form to edit a folder language info
    case "modtext":
        $folderid = isset($_GET['folderid']) ? intval($_GET['folderid']) : 0 ;
        $languageid = isset($_GET['languageid']) ? $_GET['languageid'] : 'new' ;

        xoops_cp_header();
        editfolder_text(true, $folderid, $languageid);
        break;

        // Adding or editing a folder in the db
    case "addfolder":
        addFolder(false);
        break;

        // Adding or editing a folder language info in the db
    case "addfolder_text":
        addFolder(true);
        break;

        // deleting a folder
    case "del":
        global $smartmedia_folder_handler, $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $_GET;

        $module_id = $xoopsModule->getVar('mid');
        $gperm_handler = &xoops_gethandler('groupperm');

        $folderid = (isset($_POST['folderid'])) ? intval($_POST['folderid']) : 0;
        $folderid = (isset($_GET['folderid'])) ? intval($_GET['folderid']) : $folderid;
        $categoryid = (isset($_POST['categoryid'])) ? intval($_POST['categoryid']) : 0;
        $categoryid = (isset($_GET['categoryid'])) ? intval($_GET['categoryid']) : $categoryid;

        $folderObj = $smartmedia_folder_handler->get($folderid);

        // Check to see if this item has children
        if ($folderObj->hasChild()) {
            redirect_header("folder.php", 3, _AM_SMEDIA_FOLDER_CANNOT_DELETE_HAS_CHILD);
            exit();
        }

        $confirm = (isset($_POST['confirm'])) ? $_POST['confirm'] : 0;
        $name = (isset($_POST['name'])) ? $_POST['name'] : '';

        if ($confirm) {
            If ( !$smartmedia_folder_handler->deleteParentLink($folderObj, $categoryid)) {
                redirect_header("folder.php", 1, _AM_SMEDIA_FOLDER_DELETE_ERROR);
                exit;
            }

            redirect_header("folder.php", 1, sprintf(_AM_SMEDIA_FOLDER_DELETE_SUCCESS, $name));
            exit();
        } else {
            // no confirm: show deletion condition
            xoops_cp_header();
            xoops_confirm(array('op' => 'del', 'categoryid' => $categoryid, 'folderid' => $folderObj->folderid(), 'confirm' => 1, 'name' => $folderObj->title()), 'folder.php', _AM_SMEDIA_FOLDER_DELETE . " '" . $folderObj->title() . "' ?", _AM_SMEDIA_DELETE);
            xoops_cp_footer();
        }
        exit();
        break;

    case "deltext":
        global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $_GET;

        $smartsection_folder_text_handler = smartmedia_gethandler('folder_text');

        $module_id = $xoopsModule->getVar('mid');

        $folderid = (isset($_POST['folderid'])) ? intval($_POST['folderid']) : 0;
        $folderid = (isset($_GET['folderid'])) ? intval($_GET['folderid']) : $folderid;

        $languageid = (isset($_POST['languageid'])) ? $_POST['languageid'] : null;
        $languageid = (isset($_GET['languageid'])) ? $_GET['languageid'] : $languageid;

        $folder_textObj = $smartsection_folder_text_handler->get($folderid, $languageid);

        $confirm = (isset($_POST['confirm'])) ? $_POST['confirm'] : 0;
        $name = (isset($_POST['name'])) ? $_POST['name'] : '';

        if ($confirm) {
            If ( !$smartsection_folder_text_handler->delete($folder_textObj)) {
                redirect_header("folder.php?op=mod&folderid=" . $folder_textObj->folderid(), 1, _AM_SMEDIA_FOLDER_TEXT_DELETE_ERROR);
                exit;
            }

            redirect_header("folder.php?op=mod&folderid=" . $folder_textObj->folderid(), 1, sprintf(_AM_SMEDIA_FOLDER_TEXT_DELETE_SUCCESS, $name));
            exit();
        } else {
            // no confirm: show deletion condition
            $folderid = (isset($_GET['folderid'])) ? intval($_GET['folderid']) : 0;
            $languageid = (isset($_GET['languageid'])) ? $_GET['languageid'] : null;
            xoops_cp_header();
            xoops_confirm(array('op' => 'deltext', 'folderid' => $folder_textObj->folderid(), 'languageid' => $folder_textObj->languageid(), 'confirm' => 1, 'name' => $folder_textObj->languageid()), "folder.php?op=mod&folderid=" . $folder_textObj->folderid(), _AM_SMEDIA_FOLDER_TEXT_DELETE, _AM_SMEDIA_DELETE);
            xoops_cp_footer();
        }
        exit();
        break;

    case "cancel":
        redirect_header("folder.php", 1, sprintf(_AM_SMEDIA_BACK2IDX, ''));
        exit();

    case "default":
    default:

        xoops_cp_header();
        smartmedia_adminMenu(2, _AM_SMEDIA_FOLDERS);

        echo "<br />\n";

        // Creating the objects for folders
        $foldersCategoriesObj = $smartmedia_folder_handler->getFolders(0, 0, 0);
        $array_keys = array_keys($foldersCategoriesObj);
        $criteria_id = new CriteriaCompo();
        foreach($array_keys as $key) {
            $criteria_id->add(new Criteria('categoryid', $key), 'or');
        }
        $criteria_parent = new CriteriaCompo();
        $criteria_parent->add(new Criteria('parentid', 0));

        $criteria = new CriteriaCompo();
        $criteria->add($criteria_id);
        $criteria->add($criteria_parent);

        smartmedia_collapsableBar('toptable', 'toptableicon');
        echo "<img id='toptableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SMEDIA_FOLDERS_TITLE . "</h3>";
        echo "<div id='toptable'>";
        echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . _AM_SMEDIA_FOLDERS_DSC . "</span>";

        echo "<form><div style=\"margin-top: 0px; margin-bottom: 5px;\">";
        echo "<input type='button' name='button' onclick=\"location='folder.php?op=mod'\" value='" . _AM_SMEDIA_FOLDER_CREATE . "'>&nbsp;&nbsp;";
        echo "</div></form>";

        // Folders
        echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
        echo "<tr>";
        echo "<td colspan='2' width='300px' class='bg3' align='left'><b>" . _AM_SMEDIA_CATEGORY_FOLDER . "</b></td>";
        echo "<td class='bg3' align='center'><b>" . _AM_SMEDIA_DESCRIPTION . "</b></td>";
        echo "<td class='bg3'width='100' align='center'><b>" . _AM_SMEDIA_WEIGHT . "</b></td>";
        echo "<td width='80px' class='bg3' align='center'><b>" . _AM_SMEDIA_ACTION . "</b></td>";
        echo "</tr>";
        $level = 0;

        $categoriesObj = $smartmedia_category_handler->getObjects($criteria, true);
        if (count($categoriesObj) > 0) {
            foreach ($categoriesObj as $categoryObj) {
                displayCategory($categoryObj, 0, true, $foldersCategoriesObj);
            }
        } else {
            echo "<tr>";
            echo "<td class='head' align='center' colspan= '7'>" . _AM_SMEDIA_NOCAT . "</td>";
            echo "</tr>";
        }

        echo "</table>\n";

        echo "</div>";

        //editfolder(false);

        break;
}

smartmedia_modFooter();

xoops_cp_footer();

?>