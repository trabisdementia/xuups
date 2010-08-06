<?php

/**
 * $Id: clip.php,v 1.3 2005/06/02 19:50:59 fx2024 Exp $
 * Module: SmartMedia
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

function displayClipItem($item)
{
    Global $xoopsModule;
    //var_dump($folderObj);
    $modify = "<a href='clip.php?op=mod&clipid=" . $item['clipid'] . "&folderid=" . $item['folderid'] . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_SMEDIA_CLIP_EDIT . "' alt='" . _AM_SMEDIA_CLIP_EDIT . "' /></a>";
    $delete = "<a href='clip.php?op=del&clipid=" . $item['clipid'] . "&folderid=" . $item['folderid'] . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_SMEDIA_CLIP_DELETE . "' alt='" . _AM_SMEDIA_CLIP_DELETE . "' /></a>";

    echo "<tr>";
    echo "<td class='even' align='left'>&nbsp;&nbsp;</td>";
    echo "<td class='even' align='left'>" . "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/clip.php?categoryid=" . $item['categoryid'] . "&folderid=" . $item['folderid'] . "&clipid=" . $item['clipid'] . "'><img src='" . SMARTMEDIA_URL . "images/icon/clip.gif' alt='' />&nbsp;" . $item['title'] . "</a></td>";
    echo "<td class='even' align='left'>" . $item['foldertitle'] . "</td>";
    echo "<td class='even' align='center'>" . $item['weight'] . "</td>";
    echo "<td class='even' align='right'> $modify $delete </td>";
    echo "</tr>";
}

include_once("admin_header.php");

global $smartmedia_clip_handler;

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

/* Possible $op :
 mod : Displaying the form to edit or add a clip
 mod_text : Displaying the form to edit a clip language info
 add_clip : Adding or editing a clip in the db
 add_clip_text : Adding or editing a clip language info in the db
 del : deleting a clip
 show : show the clips related to the folder
 */

// At what clip do we start
$startclip = isset($_GET['startclip']) ? intval($_GET['startclip']) : 0;

// Display a single clip
function displayClip_text($clip_textObj)
{
    Global $xoopsModule, $smartmedia_clip_handler;

    $modify = "<a href='clip.php?op=modtext&clipid=" . $clip_textObj->clipid() . "&languageid=" . $clip_textObj->languageid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_SMEDIA_CLIP_EDIT . "' alt='" . _AM_SMEDIA_CLIP_EDIT . "' /></a>";
    $delete = "<a href='clip.php?op=deltext&clipid=" . $clip_textObj->clipid() . "&languageid=" . $clip_textObj->languageid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_SMEDIA_CLIP_DELETE . "' alt='" . _AM_SMEDIA_CLIP_DELETE . "' /></a>";
    echo "<tr>";
    echo "<td class='even' align='left'>" . $clip_textObj->languageid() . "</td>";
    echo "<td class='even' align='left'> " . $clip_textObj->title() . " </td>";
    echo "<td class='even' align='center'> " . $modify . $delete . " </td>";
    echo "</tr>";
}

// Add or edit a clip or a clip language info in the db
function addClip($language_text=false)
{
    global $xoopsUser, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $myts, $smartmedia_clip_handler;
    include_once(XOOPS_ROOT_PATH."/class/uploader.php");

    $max_size = 10000000;
    $max_imgwidth = 1000;
    $max_imgheight = 1000;
    $allowed_mimetypes = smartmedia_getAllowedMimeTypes();
    $upload_msgs = array();

    $clipid = (isset($_POST['clipid'])) ? intval($_POST['clipid']) : 0;

    if (isset($_POST['languageid'])) {
        $languageid = $_POST['languageid'];
    } elseif (isset($_POST['default_languageid'])) {
        $languageid = $_POST['default_languageid'];
    } else {
        $languageid = $xoopsModuleConfig['default_language'];
    }

    If ($clipid != 0) {
        $clipObj = $smartmedia_clip_handler->get($clipid, $languageid);
    } else {
        $clipObj = $smartmedia_clip_handler->create();
    }

    if (!$language_text) {
        /*		// Upload lr_image
         if ( $_FILES['lr_image_file']['name'] != "" ) {
         $filename = $_POST["xoops_upload_file"][0] ;
         if( !empty( $filename ) || $filename != "" ) {

         if( $_FILES[$filename]['tmp_name'] == "" || ! is_readable( $_FILES[$filename]['tmp_name'] ) ) {
         $upload_msgs[_AM_SMEDIA_FILEUPLOAD_ERROR];
         } else {
         $uploader = new XoopsMediaUploader(smartmedia_getImageDir('clip'), $allowed_mimetypes, $max_size, $max_imgwidth, $max_imgheight);

         if( $uploader->fetchMedia( $filename ) && $uploader->upload() ) {
         $clipObj->setVar('image_lr', $uploader->getSavedFileName());
         } else {
         $upload_msgs[_AM_SMEDIA_FILEUPLOAD_ERROR];
         }
         }
         }
         } else {
         $clipObj->setVar('image_lr', $_POST['image_lr']);
         }
         */
        // Upload hr_image
        if ( $_FILES['hr_image_file']['name'] != "" ) {
            $filename = $_POST["xoops_upload_file"][0] ;
            if( !empty( $filename ) || $filename != "" ) {
                if( $_FILES[$filename]['tmp_name'] == "" || ! is_readable( $_FILES[$filename]['tmp_name'] ) ) {
                    $upload_msgs[_AM_SMEDIA_FILEUPLOAD_ERROR];
                } else {
                    $uploader = new XoopsMediaUploader(smartmedia_getImageDir('clip'), $allowed_mimetypes, $max_size, $max_imgwidth, $max_imgheight);
                     
                    if( $uploader->fetchMedia( $filename ) && $uploader->upload() ) {
                        $clipObj->setVar('image_hr', $uploader->getSavedFileName());
                    } else {
                        $upload_msgs[_AM_SMEDIA_FILEUPLOAD_ERROR];
                    }
                }
            }
        } else {
            $clipObj->setVar('image_hr', $_POST['image_hr']);
        }

        //var_dump($uploader->errors);
        //exit;

        $clipObj->setVar('width', (isset($_POST['width'])) ? intval($_POST['width']) : 320);
        $clipObj->setVar('height', (isset($_POST['height'])) ? intval($_POST['height']) : 260);
        $clipObj->setVar('folderid', (isset($_POST['folderid'])) ? intval($_POST['folderid']) : 0);
        $clipObj->setVar('weight', (isset($_POST['weight'])) ? intval($_POST['weight']) : 1);
        $clipObj->setVar('file_hr', $_POST['file_hr']);
        $clipObj->setVar('file_lr', $_POST['file_lr']);
        $clipObj->setVar('formatid', $_POST['formatid']);
        $clipObj->setVar('default_languageid', (isset($_POST['default_languageid'])) ? $_POST['default_languageid'] : $xoopsModuleConfig['default_language']);
        $clipObj->setTextVar('languageid', (isset($_POST['default_languageid'])) ? $_POST['default_languageid'] : $xoopsModuleConfig['default_language']);
    } else {
        $clipObj->setTextVar('languageid', $languageid);
    }

    $clipObj->setTextVar('languageid', $languageid);
    $clipObj->setTextVar('title', $_POST['title']);
    $clipObj->setTextVar('description', $_POST['description']);
    $clipObj->setTextVar('meta_description', $_POST['meta_description']);
    $clipObj->setTextVar('tab_caption_1', $_POST['tab_caption_1']);
    $clipObj->setTextVar('tab_text_1', $_POST['tab_text_1']);
    $clipObj->setTextVar('tab_caption_2', $_POST['tab_caption_2']);
    $clipObj->setTextVar('tab_text_2', $_POST['tab_text_2']);
    $clipObj->setTextVar('tab_caption_3', $_POST['tab_caption_3']);
    $clipObj->setTextVar('tab_text_3', $_POST['tab_text_3']);

    if (!$xoopsUser) {
        $uid = 0;
    } else {
        $uid = $xoopsUser->uid();
    }

    $clipObj->setVar('modified_uid', $uid);

    if ($clipObj->isNew()) {
        $clipObj->setVar('created_uid', $uid);
        $redirect_msg = _AM_SMEDIA_CLIP_CREATED;
        $redirect_to = 'clip.php';
    } else {
        if ($language_text) {
            $redirect_to = 'clip.php?op=mod&clipid=' . $clipObj->clipid();
        } else {
            if (isset($_GET['from_within'])) {
                // To come...
            }
            $redirect_to = 'clip.php';
        }
        $redirect_msg = _AM_SMEDIA_CLIP_MODIFIED;
    }

    If ( !$clipObj->store() ) {
        redirect_header("javascript:history.go(-1)", 3, _AM_SMEDIA_CLIP_SAVE_ERROR . smartmedia_formatErrors($clipObj->getErrors()));
        exit;
    }

    redirect_header($redirect_to, 2, $redirect_msg);

    exit();
}

// Edit clip information. Also used to add a clip
function editclip($showmenu = false, $clipid = 0, $folderid = 0)
{
    Global $xoopsDB, $smartmedia_clip_handler, $xoopsUser, $myts, $xoopsConfig, $xoopsModuleConfig, $xoopsModule;
    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    // if $clipid == 0 then we are adding a new clip
    $newClip = ($clipid == 0);

    echo "<script type=\"text/javascript\" src=\"funcs.js\"></script>";
    echo "<style>";
    echo "<!-- ";
    echo "select { width: 130px; }";
    echo "-->";
    echo "</style>";
    $cat_sel = '';

    if (!$newClip) {
        // We are editing a clip

        // Creating the clip object for the selected clip
        $clipObj = $smartmedia_clip_handler->get($clipid);
        $cat_sel = "&clipid=" . $clipObj->clipid();
        $clipObj->loadLanguage($clipObj->default_languageid());

        if ($showmenu) {
            smartmedia_adminMenu(3, _AM_SMEDIA_CLIPS . " > " . _AM_SMEDIA_EDITING);
        }
        echo "<br />\n";
        if ($clipObj->notLoaded()) {
            redirect_header("clip.php", 1, _AM_SMEDIA_NOCLIPTOEDIT);
            exit();
        }
        smartmedia_collapsableBar('bottomtable', 'bottomtableicon');
        echo "<img id='bottomtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SMEDIA_CLIP_EDIT . "</h3>";
        echo "<div id='bottomtable'>";
        echo "<span style=\"color: #567; margin: 3px 0 18px 0; font-size: small; display: block; \">" . _AM_SMEDIA_CLIP_EDIT_INFO . "</span>";
    } else {
        // We are creating a new clip

        $clipObj = $smartmedia_clip_handler->create();
        if ($showmenu) {
            smartmedia_adminMenu(3, _AM_SMEDIA_CLIPS . " > " . _AM_SMEDIA_CREATINGNEW);
        }
        echo "<br />\n";
        smartmedia_collapsableBar('bottomtable', 'bottomtableicon');
        echo "<img id='bottomtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SMEDIA_CLIP_CREATE . "</h3>";
        echo "<div id='bottomtable'>";
        echo "<span style=\"color: #567; margin: 3px 0 18px 0; font-size: small; display: block; \">" . _AM_SMEDIA_CLIP_CREATE_INFO . "</span>";
    }
    if (!$newClip) {
        /* If it's not a new clip, lets display the already created clip language info
         for this clip, as well as a button to create a new clip language info */

        if ($clipObj->canAddLanguage()) {
            // If not all languages have been added
             
            echo "<form><div style=\"margin-bottom: 0px;\">";
            echo "<input type='button' name='button' onclick=\"location='clip.php?op=modtext&clipid=" . $clipObj->clipid() . "'\" value='" . _AM_SMEDIA_CLIP_TEXT_CREATE . "'>&nbsp;&nbsp;";
            echo "</div></form>";
            echo "</div>";
        }

        echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
        echo "<tr>";
        echo "<td width='20%' class='bg3' align='left'><b>" . _AM_SMEDIA_LANGUAGE . "</b></td>";
        echo "<td class='bg3' align='left'><b>" . _AM_SMEDIA_CLIP_TITLE . "</b></td>";
        echo "<td width='60' class='bg3' align='center'><b>" . _AM_SMEDIA_ACTION . "</b></td>";
        echo "</tr>";

        $clip_textObjs = $clipObj->getAllLanguages(true);
        if (count($clip_textObjs) > 0) {
            foreach ( $clip_textObjs as $key => $thiscat) {
                displayClip_text($thiscat);
            }
        } else {
            echo "<tr>";
            echo "<td class='head' align='center' colspan= '3'>" . _AM_SMEDIA_NO_LANGUAGE_INFO . "</td>";
            echo "</tr>";
        }

        echo "</table>\n<br/>";
    }

    // Start clip form

    $sform = new XoopsThemeForm(_AM_SMEDIA_CLIP, "op", xoops_getenv('PHP_SELF'));
    $sform->setExtra('enctype="multipart/form-data"');
    $sform -> addElement( new XoopsFormHidden( 'clipid', $clipid ) );

    // Language
    $languageid_select = new XoopsFormSelectLang(_AM_SMEDIA_LANGUAGE_ITEM, 'default_languageid', $clipObj->default_languageid());
    $languageid_select->setDescription(_AM_SMEDIA_LANGUAGE_ITEM_DSC);
    $languageid_select->addOptionArray(XoopsLists::getLangList());
    if (!$newClip) {
        $languageid_select->setExtra("style='color: grey;' disabled='disabled'");
    }
    $sform->addElement($languageid_select);

    // title
    $sform->addElement(new XoopsFormText(_AM_SMEDIA_CLIP_TITLE_REQ, 'title', 50, 255, $clipObj->title('e')), true);

    // Description
    $desc = new XoopsFormTextArea(_AM_SMEDIA_CLIP_DESCRIPTION, 'description', $clipObj->description('e'), 7, 60);
    $desc->setDescription(_AM_SMEDIA_CLIP_DESCRIPTIONDSC);
    $sform->addElement($desc);

    // Meta-Description
    $meta = new XoopsFormTextArea(_AM_SMEDIA_CLIP_META_DESCRIPTION, 'meta_description', $clipObj->meta_description('e'), 7, 60);
    $meta->setDescription(_AM_SMEDIA_CLIP_META_DESCRIPTIONDSC);
    $sform->addElement($meta);

    $sform -> addElement( new XoopsFormHidden( 'itemType', 'item_text' ) );

    // tab_caption_1
    $sform -> addElement(new XoopsFormText(_AM_SMEDIA_CLIP_TAB_CAPTION_1, 'tab_caption_1', 50, 50, $clipObj->tab_caption_1()), false);


    // tab_text_1
    $tab1_text = new XoopsFormTextArea(_AM_SMEDIA_CLIP_TAB_TEXT_1, 'tab_text_1', $clipObj->tab_text_1('e'), 7, 60);
    $tab1_text->setDescription(_AM_SMEDIA_CLIP_TABDSC);
    $sform->addElement($tab1_text);

    // tab_caption_2
    $sform->addElement(new XoopsFormText(_AM_SMEDIA_CLIP_TAB_CAPTION_2, 'tab_caption_2', 50, 50, $clipObj->tab_caption_2()), false);

    // tab_text_2
    $tab2_text = new XoopsFormTextArea(_AM_SMEDIA_CLIP_TAB_TEXT_2, 'tab_text_2', $clipObj->tab_text_2('e'), 7, 60);
    $tab2_text->setDescription(_AM_SMEDIA_CLIP_TABDSC);
    $sform->addElement($tab2_text);

    // tab_caption_3
    $sform->addElement(new XoopsFormText(_AM_SMEDIA_CLIP_TAB_CAPTION_3, 'tab_caption_3', 50, 50, $clipObj->tab_caption_3()), false);

    // tab_text_3
    $tab3_text = new XoopsFormTextArea(_AM_SMEDIA_CLIP_TAB_TEXT_3, 'tab_text_3', $clipObj->tab_text_3('e'), 7, 60);
    $tab3_text->setDescription(_AM_SMEDIA_CLIP_TABDSC);
    $sform->addElement($tab3_text);

    // Folder
    include_once(SMARTMEDIA_ROOT_PATH . "class/smarttree.php");
    $smarttree = new SmartTree($xoopsDB -> prefix( "smartmedia_folders" ), "folderid", "" );
    ob_start();
    $smarttree->makeMySelBox( "title", "weight", $folderid, 0, 'folderid' );

    //makeMySelBox($title,$order="",$preset_id=0, $none=0, $sel_name="", $onchange="")
    $sform -> addElement( new XoopsFormLabel( _AM_SMEDIA_FOLDER, ob_get_contents() ) );
    ob_end_clean();

    // file_lr
    $lores = new XoopsFormText(_AM_SMEDIA_CLIP_FILE_LR, 'file_lr', 50, 255, $clipObj->file_lr(), false);
    $lores->setDescription(_AM_SMEDIA_CLIP_FILE_LRDSC);
    $sform->addElement($lores);

    // file_hr
    $hires = new XoopsFormText(_AM_SMEDIA_CLIP_FILE_HR, 'file_hr', 50, 255, $clipObj->file_hr(), false);
    $hires->setDescription(_AM_SMEDIA_CLIP_FILE_HRDSC);
    $sform->addElement($hires);

    // format
    $format_select = new XoopsFormSelect( _AM_SMEDIA_CLIP_FORMAT, 'formatid', $clipObj->formatid() );
    $format_select->addOptionArray(smartmedia_getFormatArray(true));
    $sform -> addElement( $format_select );

    // width
    $width_text = new XoopsFormText(_AM_SMEDIA_CLIP_WIDTH, 'width', 20, 20, $clipObj->width(), false);
    $width_text->setDescription(_AM_SMEDIA_CLIP_WIDTHDSC);
    $sform->addElement($width_text);

    // height
    $height_text = new XoopsFormText(_AM_SMEDIA_CLIP_HEIGHT, 'height', 20, 20, $clipObj->height(), false);
    $height_text->setDescription(_AM_SMEDIA_CLIP_HEIGHTDSC);
    $sform->addElement($height_text);

    /*	// LR IMAGE
     $lr_image_array = & XoopsLists :: getImgListAsArray( smartmedia_getImageDir('clip') );
     $lr_image_select = new XoopsFormSelect( '', 'image_lr', $clipObj->image_lr() );
     $lr_image_select -> addOption ('-1', '---------------');
     $lr_image_select -> addOptionArray( $lr_image_array );
     $lr_image_select -> setExtra( "onchange='showImgSelected(\"the_image_lr\", \"image_lr\", \"" . 'uploads/smartmedia/images/clip' . "\", \"\", \"" . XOOPS_URL . "\")'" );
     $lr_image_tray = new XoopsFormElementTray( _AM_SMEDIA_CLIP_IMAGE_LR, '&nbsp;' );
     $lr_image_tray -> addElement( $lr_image_select );
     $lr_image_tray -> addElement( new XoopsFormLabel( '', "<br /><br /><img src='" . smartmedia_getImageDir('clip', false) .$clipObj->image_lr() . "' name='the_image_lr' id='the_image_lr' alt='' />" ) );
     $lr_image_tray->setDescription(_AM_SMEDIA_CLIP_IMAGE_LR_DSC);
     $sform -> addElement( $lr_image_tray );

     // LR IMAGE UPLOAD
     $max_size = 5000000;
     $lr_file_box = new XoopsFormFile(_AM_SMEDIA_CLIP_IMAGE_LR_UPLOAD, "lr_image_file", $max_size);
     $lr_file_box->setExtra( "size ='45'") ;
     $lr_file_box->setDescription(_AM_SMEDIA_CLIP_IMAGE_LR_UPLOAD_DSC);
     $sform->addElement($lr_file_box);
     */
    // HR IMAGE
    $hr_image_array = & XoopsLists :: getImgListAsArray( smartmedia_getImageDir('clip') );
    $hr_image_select = new XoopsFormSelect( '', 'image_hr', $clipObj->image_hr() );
    $hr_image_select -> addOption ('-1', '---------------');
    $hr_image_select -> addOptionArray( $hr_image_array );
    $hr_image_select -> setExtra( "onchange='showImgSelected(\"the_image_hr\", \"image_hr\", \"" . 'uploads/smartmedia/images/clip' . "\", \"\", \"" . XOOPS_URL . "\")'" );
    $hr_image_tray = new XoopsFormElementTray( _AM_SMEDIA_CLIP_IMAGE_HR, '&nbsp;' );
    $hr_image_tray -> addElement( $hr_image_select );
    $hr_image_tray -> addElement( new XoopsFormLabel( '', "<br /><br /><img src='" . smartmedia_getImageDir('clip', false) .$clipObj->image_hr() . "' name='the_image_hr' id='the_image_hr' alt='' />" ) );
    $hr_image_tray->setDescription(sprintf(_AM_SMEDIA_CLIP_IMAGE_HR_DSC, $xoopsModuleConfig['main_image_width']));
    $sform -> addElement( $hr_image_tray );

    // HR IMAGE UPLOAD
    $max_size = 5000000;
    $hr_file_box = new XoopsFormFile(_AM_SMEDIA_CLIP_IMAGE_HR_UPLOAD, "hr_image_file", $max_size);
    $hr_file_box->setExtra( "size ='45'") ;
    $hr_file_box->setDescription(_AM_SMEDIA_CLIP_IMAGE_HR_UPLOAD_DSC);
    $sform->addElement($hr_file_box);

    // Weight
    $sform->addElement(new XoopsFormText(_AM_SMEDIA_CLIP_WEIGHT, 'weight', 4, 4, $clipObj->weight()));

    $sform -> addElement( new XoopsFormHidden( 'itemType', 'item' ) );

    if (isset($_GET['from_within'])) {
        $sform -> addElement( new XoopsFormHidden( 'from_within', 1) );
    }

    // Action buttons tray
    $button_tray = new XoopsFormElementTray('', '');

    $hidden = new XoopsFormHidden('op', 'addclip');
    $button_tray->addElement($hidden);

    if ($newClip) {
        // We are creating a new clip

        $butt_create = new XoopsFormButton('', '', _AM_SMEDIA_CREATE, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'addclip\'"');
        $button_tray->addElement($butt_create);

        $butt_clear = new XoopsFormButton('', '', _AM_SMEDIA_CLEAR, 'reset');
        $button_tray->addElement($butt_clear);

        $butt_cancel = new XoopsFormButton('', '', _AM_SMEDIA_CANCEL, 'button');
        $butt_cancel->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($butt_cancel);
    } else {

        // We are editing a clip
        $butt_create = new XoopsFormButton('', '', _AM_SMEDIA_MODIFY, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'addclip\'"');
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

// Edit clip language info. Also used to add a new clip language info
function editclip_text($showmenu = false, $clipid, $languageid)
{
    Global $xoopsDB, $smartmedia_clip_handler, $xoopsUser, $myts, $xoopsConfig, $xoopsModuleConfig, $xoopsModule;
    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    echo "<script type=\"text/javascript\" src=\"funcs.js\"></script>";
    echo "<style>";
    echo "<!-- ";
    echo "select { width: 130px; }";
    echo "-->";
    echo "</style>";

    $cat_sel = '';

    $clipObj = $smartmedia_clip_handler->get($clipid, $languageid);

    if ($languageid == 'new') {
        $bread_lang = _AM_SMEDIA_CREATE;
    } else {
        $bread_lang = ucfirst($languageid);
    }

    if ($showmenu) {
        smartmedia_adminMenu(3, _AM_SMEDIA_CLIPS . " > " . _AM_SMEDIA_LANGUAGE_INFO . " > " . $bread_lang);
    }
    echo "<br />\n";
    smartmedia_collapsableBar('bottomtable', 'bottomtableicon');
    echo "<img id='bottomtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SMEDIA_CLIP_LANGUAGE_INFO_EDITING . "</h3>";
    echo "<div id='bottomtable'>";
    echo "<span style=\"color: #567; margin: 3px 0 18px 0; font-size: small; display: block; \">" . _AM_SMEDIA_CLIP_LANGUAGE_INFO_EDITING_INFO . "</span>";

    // Start clip form
    $sform = new XoopsThemeForm(_AM_SMEDIA_CLIP, "op", xoops_getenv('PHP_SELF'));
    $sform->setExtra('enctype="multipart/form-data"');
    $sform -> addElement( new XoopsFormHidden( 'clipid', $clipid ) );

    // Language
    $languageOptions = array();
    $languageList = XoopsLists::getLangList();
    $createdLanguages = $clipObj->getCreatedLanguages();
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

    // Description
    $desc = new XoopsFormTextArea(_AM_SMEDIA_CLIP_DESCRIPTION, 'description', $clipObj->description('e'), 7, 60);
    $desc->setDescription(_AM_SMEDIA_CLIP_DESCRIPTIONDSC);
    $sform->addElement($desc);

    // Meta-Description
    $meta = new XoopsFormTextArea(_AM_SMEDIA_CLIP_META_DESCRIPTION, 'meta_description', $clipObj->meta_description('e'), 7, 60);
    $meta->setDescription(_AM_SMEDIA_CLIP_META_DESCRIPTIONDSC);
    $sform->addElement($meta);

    $sform -> addElement( new XoopsFormHidden( 'itemType', 'item_text' ) );

    // tab_caption_1
    $sform -> addElement(new XoopsFormText(_AM_SMEDIA_CLIP_TAB_CAPTION_1, 'tab_caption_1', 50, 50, $clipObj->tab_caption_1()), false);


    // tab_text_1
    $tab1_text = new XoopsFormTextArea(_AM_SMEDIA_CLIP_TAB_TEXT_1, 'tab_text_1', $clipObj->tab_text_1('e'), 7, 60);
    $tab1_text->setDescription(_AM_SMEDIA_CLIP_TABDSC);
    $sform->addElement($tab1_text);

    // tab_caption_2
    $sform->addElement(new XoopsFormText(_AM_SMEDIA_CLIP_TAB_CAPTION_2, 'tab_caption_2', 50, 50, $clipObj->tab_caption_2()), false);

    // tab_text_2
    $tab2_text = new XoopsFormTextArea(_AM_SMEDIA_CLIP_TAB_TEXT_2, 'tab_text_2', $clipObj->tab_text_2('e'), 7, 60);
    $tab2_text->setDescription(_AM_SMEDIA_CLIP_TABDSC);
    $sform->addElement($tab2_text);

    // tab_caption_3
    $sform->addElement(new XoopsFormText(_AM_SMEDIA_CLIP_TAB_CAPTION_3, 'tab_caption_3', 50, 50, $clipObj->tab_caption_3()), false);

    // tab_text_3
    $tab3_text = new XoopsFormTextArea(_AM_SMEDIA_CLIP_TAB_TEXT_3, 'tab_text_3', $clipObj->tab_text_3('e'), 7, 60);
    $tab3_text->setDescription(_AM_SMEDIA_CLIP_TABDSC);
    $sform->addElement($tab3_text);
    // Action buttons tray
    $button_tray = new XoopsFormElementTray('', '');

    $hidden = new XoopsFormHidden('op', 'addclip_text');
    $button_tray->addElement($hidden);

    if ($languageid == 'new') {
        // We are creating a new clip language info

        $butt_create = new XoopsFormButton('', '', _AM_SMEDIA_CREATE, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'addclip_text\'"');
        $button_tray->addElement($butt_create);

        $butt_clear = new XoopsFormButton('', '', _AM_SMEDIA_CLEAR, 'reset');
        $button_tray->addElement($butt_clear);

        $butt_cancel = new XoopsFormButton('', '', _AM_SMEDIA_CANCEL, 'button');
        $butt_cancel->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($butt_cancel);
    } else {
        // We are editing a clip language info

        $butt_create = new XoopsFormButton('', '', _AM_SMEDIA_MODIFY, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'addclip_text\'"');
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
    // Displaying the form to edit or add a clip
    case "mod":
        //default:
        $clipid = isset($_GET['clipid']) ? intval($_GET['clipid']) : 0 ;
        $folderid = isset($_GET['folderid']) ? intval($_GET['folderid']) : 0 ;
        xoops_cp_header();
        editclip(true, $clipid, $folderid);
        break;

        // Displaying the form to edit a clip language info
    case "modtext":
        $clipid = isset($_GET['clipid']) ? intval($_GET['clipid']) : 0 ;
        $languageid = isset($_GET['languageid']) ? $_GET['languageid'] : 'new' ;

        xoops_cp_header();
        editclip_text(true, $clipid, $languageid);
        break;

        // Adding or editing a clip in the db
    case "addclip":
        addClip(false);
        break;

        // Adding or editing a clip language info in the db
    case "addclip_text":
        addClip(true);
        break;

        // deleting a clip
    case "del":
        global $smartmedia_clip_handler, $xoopsUser, $xoopsConfig, $xoopsDB, $_GET;

        $module_id = $xoopsModule->getVar('mid');
        $gperm_handler = &xoops_gethandler('groupperm');

        $clipid = (isset($_POST['clipid'])) ? intval($_POST['clipid']) : 0;
        $clipid = (isset($_GET['clipid'])) ? intval($_GET['clipid']) : $clipid;

        $clipObj = $smartmedia_clip_handler->get($clipid);

        $confirm = (isset($_POST['confirm'])) ? $_POST['confirm'] : 0;
        $name = (isset($_POST['name'])) ? $_POST['name'] : '';

        if ($confirm) {
            If ( !$smartmedia_clip_handler->delete($clipObj)) {
                redirect_header("clip.php", 1, _AM_SMEDIA_CLIP_DELETE_ERROR);
                exit;
            }

            redirect_header("clip.php", 1, sprintf(_AM_SMEDIA_CLIP_DELETE_SUCCESS, $name));
            exit();
        } else {
            // no confirm: show deletion condition
            xoops_cp_header();
            xoops_confirm(array('op' => 'del', 'clipid' => $clipObj->clipid(), 'confirm' => 1, 'name' => $clipObj->title()), 'clip.php', _AM_SMEDIA_CLIP_DELETE . " '" . $clipObj->title() . "' ?", _AM_SMEDIA_DELETE);
            xoops_cp_footer();
        }
        exit();
        break;

    case "deltext":
        global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $_GET;

        $smartsection_clip_text_handler = smartmedia_gethandler('clip_text');

        $module_id = $xoopsModule->getVar('mid');

        $clipid = (isset($_POST['clipid'])) ? intval($_POST['clipid']) : 0;
        $clipid = (isset($_GET['clipid'])) ? intval($_GET['clipid']) : $clipid;

        $languageid = (isset($_POST['languageid'])) ? $_POST['languageid'] : null;
        $languageid = (isset($_GET['languageid'])) ? $_GET['languageid'] : $languageid;

        $clip_textObj = $smartsection_clip_text_handler->get($clipid, $languageid);

        $confirm = (isset($_POST['confirm'])) ? $_POST['confirm'] : 0;
        $name = (isset($_POST['name'])) ? $_POST['name'] : '';

        if ($confirm) {
            If ( !$smartsection_clip_text_handler->delete($clip_textObj)) {
                redirect_header("clip.php?op=mod&clipid=" . $clip_textObj->clipid(), 1, _AM_SMEDIA_CLIP_TEXT_DELETE_ERROR);
                exit;
            }

            redirect_header("clip.php?op=mod&clipid=" . $clip_textObj->clipid(), 1, sprintf(_AM_SMEDIA_CLIP_TEXT_DELETE_SUCCESS, $name));
            exit();
        } else {
            // no confirm: show deletion condition
            $clipid = (isset($_GET['clipid'])) ? intval($_GET['clipid']) : 0;
            $languageid = (isset($_GET['languageid'])) ? $_GET['languageid'] : null;
            xoops_cp_header();
            xoops_confirm(array('op' => 'deltext', 'clipid' => $clip_textObj->clipid(), 'languageid' => $clip_textObj->languageid(), 'confirm' => 1, 'name' => $clip_textObj->languageid()), "clip.php?op=mod&clipid=" . $clip_textObj->clipid(), _AM_SMEDIA_CLIP_TEXT_DELETE, _AM_SMEDIA_DELETE);
            xoops_cp_footer();
        }
        exit();
        break;

    case "cancel":
        redirect_header("clip.php", 1, sprintf(_AM_SMEDIA_BACK2IDX, ''));
        exit();

    case "show_within":
        xoops_cp_header();

        $folderid = isset($_GET['folderid']) ? intval($_GET['folderid']) : 0;
        $categoryid = isset($_GET['categoryid']) ? intval($_GET['categoryid']) : 0;

        $folderObj =& $smartmedia_folder_handler->get($folderid);

        smartmedia_adminMenu(3, sprintf(_AM_SMEDIA_CLIPS_WITHIN_FOLDER, $folderObj->title('clean')));

        echo "<br />\n";

        // Creating the objects for clips
        $clipsFoldersObj = $smartmedia_clip_handler->getClips(0, 0, $folderid);

        $array_keys = array_keys($clipsFoldersObj);
        $criteria_id = new CriteriaCompo();
        foreach($array_keys as $key) {
            $criteria_id->add(new Criteria('parent.folderid', $key), 'or');
        }
        $criteria = new CriteriaCompo();
        $criteria->add($criteria_id);
        smartmedia_collapsableBar('toptable', 'toptableicon');
        echo "<img id='toptableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SMEDIA_CLIPS_TITLE . "</h3>";
        echo "<div id='toptable'>";
        echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . sprintf(_AM_SMEDIA_CLIPS_DSC, $folderObj->title('clean')) . "</span>";

        echo "<form><div style=\"margin-top: 0px; margin-bottom: 5px;\">";
        echo "<input type='button' name='button' onclick=\"location='clip.php?op=mod&folderid=" . $folderid . "'\" value='" . _AM_SMEDIA_CLIP_CREATE . "'>&nbsp;&nbsp;";
        echo "</div></form>";

        // Clips
        echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
        echo "<tr>";
        echo "<td colspan='2' width='300px' class='bg3' align='left'><b>" . _AM_SMEDIA_FOLDER_CLIP . "</b></td>";
        echo "<td class='bg3' align='center'><b>" . _AM_SMEDIA_DESCRIPTION . "</b></td>";
        echo "<td class='bg3'width='100' align='center'><b>" . _AM_SMEDIA_WEIGHT . "</b></td>";
        echo "<td width='60' class='bg3' align='center'><b>" . _AM_SMEDIA_ACTION . "</b></td>";
        echo "</tr>";
        $level = 0;

        $foldersObj = $smartmedia_folder_handler->getObjects(0, $criteria, false);
        if (count($foldersObj) > 0) {
            foreach ($foldersObj as $folderObj) {
                //var_dump($folderObj);
                displayFolderForClip($folderObj, 0, true, $clipsFoldersObj, $categoryid, true);
            }
        } else {
            echo "<tr>";
            echo "<td class='head' align='center' colspan= '7'>" . _AM_SMEDIA_NOCAT . "</td>";
            echo "</tr>";
        }

        echo "</table>\n";

        echo "</div>";

        //	editclip(false);
        break;

    case "show":
    default:
        xoops_cp_header();
        $folderid = isset($_GET['folderid']) ? intval($_GET['folderid']) : 0 ;

        $languagesel = isset($_GET['languagesel']) ? $_GET['languagesel'] : 'all';
        $languagesel = isset($_POST['languagesel']) ? $_POST['languagesel'] : $languagesel;

        $sortsel = isset($_GET['sortsel']) ? $_GET['sortsel'] : 'clips_text.title';
        $sortsel = isset($_POST['sortsel']) ? $_POST['sortsel'] : $sortsel;

        $ordersel = isset($_GET['ordersel']) ? $_GET['ordersel'] : 'ASC';
        $ordersel = isset($_POST['ordersel']) ? $_POST['ordersel'] :$ordersel;

        $limitsel = isset($_GET['limitsel']) ? $_GET['limitsel'] : smartmedia_getCookieVar('smartmedia_clip_limitsel', '15');
        $limitsel = isset($_POST['limitsel']) ? $_POST['limitsel'] : $limitsel;
        smartmedia_setCookieVar('smartmedia_clip_limitsel', $limitsel);

        $startsel = isset($_GET['startsel']) ? $_GET['startsel'] : 0;
        $startsel = isset($_POST['startsel']) ? $_POST['startsel'] : $startsel;

        $showingtxt = '';
        $cond = "";

        $sorttxttitle = "";
        $sorttxtfolder = "";
        $sorttxtweight = "";
        $sorttxtclipid = "";

        $ordertxtasc='';
        $ordertxtdesc='';

        switch ($sortsel) {
            case 'clips.clipid':
                $sorttxtclipid = "selected='selected'";
                break;

            case 'clips.weight':
                $sorttxtweight = "selected='selected'";
                break;

            case 'folders_text.title':
                $sorttxtfolder = "selected='selected'";
                break;

            default :
                $sorttxttitle = "selected='selected'";
                break;
        }

        switch ($ordersel) {
            case 'DESC':
                $ordertxtdesc = "selected='selected'";
                break;

            default :
                $ordertxtasc = "selected='selected'";
                break;
        }
        $limittxt5='';
        $limittxt10='';
        $limittxt15='';
        $limittxt20='';
        $limittxt25='';
        $limittxt30='';
        $limittxt35='';
        $limittxt40='';
        $limittxtall='';
        switch ($limitsel) {
            case 'all':
                $limittxtall = "selected='selected'";
                break;

            case '5':
                $limittxt5 = "selected='selected'";
                break;

            case '10':
                $limittxt10 = "selected='selected'";
                break;

            default :
                $limittxt15 = "selected='selected'";
                break;

            case '20':
                $limittxt20 = "selected='selected'";
                break;
                 
            case '25':
                $limittxt25 = "selected='selected'";
                break;

            case '30':
                $limittxt30 = "selected='selected'";
                break;

            case '35':
                $limittxt35 = "selected='selected'";
                break;

            case '40':
                $limittxt40 = "selected='selected'";
                break;
        }

        smartmedia_adminMenu(3, _AM_SMEDIA_CLIPS_ALL);

        echo "<br />\n";

        // Creating the objects for clips
        $clipsFoldersObj = $smartmedia_clip_handler->getClips(0,0, 0);

        $array_keys = array_keys($clipsFoldersObj);
        $criteria_id = new CriteriaCompo();
        foreach($array_keys as $key) {
            $criteria_id->add(new Criteria($xoopsDB->prefix('smartmedia_folders_categories') . '.folderid', $key), 'or');
        }
        $criteria = new CriteriaCompo();
        $criteria->add($criteria_id);
        smartmedia_collapsableBar('toptable', 'toptableicon');
        echo "<img id='toptableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SMEDIA_CLIPS_TITLE . "</h3>";
        echo "<div id='toptable'>";
        echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . _AM_SMEDIA_CLIPS_ALL_DSC . "</span>";

        echo "<form><div style=\"margin-top: 0px; margin-bottom: 5px;\">";
        echo "<input type='button' name='button' onclick=\"location='clip.php?op=mod&folderid=" . $folderid . "'\" value='" . _AM_SMEDIA_CLIP_CREATE . "'>&nbsp;&nbsp;";
        echo "</div></form>";

        /* -- Code to show selected terms -- */
        echo "<form name='pick' id='pick' action='" . $_SERVER['PHP_SELF'] . "' method='POST' style='margin: 0;'>";

        echo "
		<table width='100%' cellspacing='1' cellpadding='2' border='0' style='border-left: 1px solid silver; border-top: 1px solid silver; border-right: 1px solid silver;'>
			<tr>
				<td><span style='font-weight: bold; font-size: 12px; font-variant: small-caps;'>" . _AM_SMEDIA_CLIPS . "</span></td>
				<td align='right'>
	                " . _AM_SMEDIA_LANGUAGE . "
						<select name='languagesel' onchange='submit()'>";

        $languages = XoopsLists::getLangList();
        foreach ($languages as $language) {
            echo "<option value='" . $language . "'";
            if ($language == $languagesel) {
                echo "selected='selected'";
            }
            echo ">" . $language . "</option>";
        }
        echo "<option value='all'";
        if ('all' == $languagesel) {
            echo "selected='selected'";
        }
        echo ">" ._AM_SMEDIA_ALL. "</option>";
        echo "
					</select>
					" . _AM_SMEDIA_SORT . " 
					<select name='sortsel' onchange='submit()'>
						<option value='clips.clipid' $sorttxtclipid>" . _AM_SMEDIA_ID . "</option>
						<option value='clips_text.title' $sorttxttitle>" . _AM_SMEDIA_CLIP_TITLE . "</option>
						<option value='folders_text.title' $sorttxtfolder>" . _AM_SMEDIA_FOLDER . "</option>
						<option value='clips.weight' $sorttxtweight>" . _AM_SMEDIA_CLIP_WEIGHT . "</option>
					</select>
					<select name='ordersel' onchange='submit()'>
						<option value='ASC' $ordertxtasc>" . _AM_SMEDIA_ASC . "</option>
						<option value='DESC' $ordertxtdesc>" . _AM_SMEDIA_DESC . "</option>
					</select>
					" . _AM_SMEDIA_DISPLAY_LIMIT . " 
					<select name='limitsel' onchange='submit()'>
						<option value='all' $limittxtall>" . _AM_SMEDIA_ALL . "</option>
						<option value='5' $limittxt5>5</option>
						<option value='10' $limittxt10>10</option>
						<option value='15' $limittxt15>15</option>
						<option value='20' $limittxt20>20</option>
						<option value='25' $limittxt25>25</option>
						<option value='30' $limittxt30>30</option>	
						<option value='35' $limittxt35>35</option>
						<option value='40' $limittxt40>40</option>
					</select>
				</td>
			</tr>
		</table>
		</form>";


         
        // Clips
        echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
        echo "<tr>";
        echo "<td colspan='2' width='300px' class='bg3' align='left'><b>" . _AM_SMEDIA_CLIP . "</b></td>";
        echo "<td class='bg3' align='center'><b>" . _AM_SMEDIA_FOLDER . "</b></td>";
        echo "<td class='bg3'width='100' align='center'><b>" . _AM_SMEDIA_WEIGHT . "</b></td>";
        echo "<td width='60' class='bg3' align='center'><b>" . _AM_SMEDIA_ACTION . "</b></td>";
        echo "</tr>";
        $level = 0;
        if ($limitsel == ('all')) {
            $thelimit = 0;
        } else {
            $thelimit = $limitsel;
        }
        $clipsItems =& $smartmedia_clip_handler->getClipsFromAdmin($startsel, $thelimit, $sortsel, $ordersel, $languagesel);
        if (count($clipsItems) > 0) {
            foreach ($clipsItems as $item) {
                //var_dump($folderObj);
                displayClipItem($item);
            }
        } else {
            echo "<tr>";
            echo "<td class='head' align='center' colspan= '7'>" . _AM_SMEDIA_NOCAT . "</td>";
            echo "</tr>";
        }

        echo "</table>\n";

        // Clips Navigation Bar
        if ($thelimit != 0)	{
            $pagenav = new XoopsPageNav($smartmedia_clip_handler->getClipsCountFromAdmin($languagesel), $thelimit, $startsel, 'startsel', "languagesel=$languagesel&sortsel=$sortsel&ordersel=$ordersel&limitsel=$limitsel");
            echo '<div style="text-align:right;">' . $pagenav->renderNav() . '</div>';
        } else {
        }

        echo "</div>";

        editclip(false);
        break;
}

smartmedia_modFooter();

xoops_cp_footer();

?>