<?php

/**
 * $Id: partner.php,v 1.17 2005/05/26 15:26:22 fx2024 Exp $
 * Module: SmartPartner
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */
include_once("admin_header.php");

$op = '';
if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

// Where shall we start ?
$startpartner = isset($_GET['startpartner']) ? intval($_GET['startpartner']) : 0;

function editpartner($showmenu = false, $id = 0)
{
    global $partner_handler, $xoopsUser, $xoopsConfig, $xoopsModuleConfig, $xoopsModule;

    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    // If there is a parameter, and the id exists, retrieve data: we're editing a partner
    if ($id != 0) {
        // Creating the partner object
        $partnerObj = new SmartpartnerPartner($id);

        if ($partnerObj->notLoaded()) {
            redirect_header("partner.php", 1, _AM_SPARTNER_NOPARTNERSELECTED);
            exit();
        }

        switch ($partnerObj->status()) {

            case _SPARTNER_STATUS_SUBMITTED :
                $breadcrumb_action1 = 	_AM_SPARTNER_SUBMITTED_PARTNERS;
                $breadcrumb_action2 = 	_AM_SPARTNER_APPROVING;
                $page_title = _AM_SPARTNER_SUBMITTED_TITLE;
                $page_info = _AM_SPARTNER_SUBMITTED_INFO;
                $button_caption = _AM_SPARTNER_APPROVE;
                $new_status = _SPARTNER_STATUS_ACTIVE;
                break;

            case _SPARTNER_STATUS_ACTIVE :
                $breadcrumb_action1 = 	_AM_SPARTNER_ACTIVE_PARTNERS;
                $breadcrumb_action2 = 	_AM_SPARTNER_EDITING;
                $page_title = _AM_SPARTNER_ACTIVE_EDITING;
                $page_info = _AM_SPARTNER_ACTIVE_EDITING_INFO;
                $button_caption = _AM_SPARTNER_MODIFY;
                $new_status = _SPARTNER_STATUS_ACTIVE;
                break;

            case _SPARTNER_STATUS_INACTIVE :
                $breadcrumb_action1 = 	_AM_SPARTNER_INACTIVE_PARTNERS;
                $breadcrumb_action2 = 	_AM_SPARTNER_EDITING;
                $page_title = _AM_SPARTNER_INACTIVE_EDITING;
                $page_info = _AM_SPARTNER_INACTIVE_EDITING_INFO;
                $button_caption = _AM_SPARTNER_MODIFY;
                $new_status = _SPARTNER_STATUS_INACTIVE;
                break;

            case _SPARTNER_STATUS_REJECTED :
                $breadcrumb_action1 = 	_AM_SPARTNER_REJECTED_PARTNERS;
                $breadcrumb_action2 = 	_AM_SPARTNER_EDITING;
                $page_title = _AM_SPARTNER_REJECTED_EDITING;
                $page_info = _AM_SPARTNER_REJECTED_EDITING_INFO;
                $button_caption = _AM_SPARTNER_MODIFY;
                $new_status = _SPARTNER_STATUS_REJECTED;
                break;

            case "default" :
            default :
                break;
        }


        If ($showmenu) {
            smartpartner_adminMenu(1, $breadcrumb_action1 . " > " . $breadcrumb_action2);
        }

        echo "<br />\n";
        smartpartner_collapsableBar('bottomtable', 'bottomtableicon');
        echo "<img id='bottomtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . $page_title . "</h3>";
        echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . $page_info . "</span>";
        echo "<div id='bottomtable'>";
    } else {
        // there's no parameter, so we're adding a partner
        $partnerObj =& $partner_handler->create();
        $breadcrumb_action1 = _AM_SPARTNER_PARTNERS;
        $breadcrumb_action2 = _AM_SPARTNER_CREATE;
        $button_caption = _AM_SPARTNER_CREATE;
        $new_status = _SPARTNER_STATUS_ACTIVE;
        If ($showmenu) {
            smartpartner_adminMenu(1, $breadcrumb_action1 . " > " . $breadcrumb_action2);
        }
        smartpartner_collapsableBar('bottomtable', 'bottomtableicon');
        echo "<img id='bottomtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SPARTNER_PARTNER_CREATING . "</h3>";
        echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . _AM_SPARTNER_PARTNER_CREATING_DSC . "</span>";
        echo "<div id='bottomtable'>";
    }

    // PARTNER FORM
    $sform = new XoopsThemeForm(_AM_SPARTNER_PARTNERS, "op", xoops_getenv('PHP_SELF'));
    $sform->setExtra('enctype="multipart/form-data"');

    // TITLE
    $title_text = new XoopsFormText(_AM_SPARTNER_TITLE_REQ, 'title', 50, 255, $partnerObj->title('e'));
    $sform->addElement($title_text, true);

    // LOGO
    $logo_array = & XoopsLists :: getImgListAsArray( smartpartner_getImageDir() );
    $logo_select = new XoopsFormSelect( '', 'image', $partnerObj->image() );
    $logo_select -> addOption ('-1', '---------------');
    $logo_select -> addOptionArray( $logo_array );
    $logo_select -> setExtra( "onchange='showImgSelected(\"image3\", \"image\", \"" . 'uploads/' . SMARTPARTNER_DIRNAME . '/images' . "\", \"\", \"" . XOOPS_URL . "\")'" );
    $logo_tray = new XoopsFormElementTray( _AM_SPARTNER_LOGO, '&nbsp;' );
    $logo_tray -> addElement( $logo_select );
    $logo_tray -> addElement( new XoopsFormLabel( '', "<br /><br /><img src='" . smartpartner_getImageDir('', false) .$partnerObj->image() . "' name='image3' id='image3' alt='' />" ) );
    $logo_tray->setDescription(_AM_SPARTNER_LOGO_DSC);
    $sform -> addElement( $logo_tray );

    // LOGO UPLOAD
    $max_size = 5000000;
    $file_box = new XoopsFormFile(_AM_SPARTNER_LOGO_UPLOAD, "logo_file", $max_size);
    $file_box->setExtra( "size ='45'") ;
    $file_box->setDescription(sprintf(_AM_SPARTNER_LOGO_UPLOAD_DSC,$xoopsModuleConfig['img_max_width'],$xoopsModuleConfig['img_max_height']));
    $sform->addElement($file_box);

    // IMAGE_URL
    $image_url_text = new XoopsFormText(_CO_SPARTNER_IMAGE_URL, 'image_url', 50, 255, $partnerObj->image_url());
    $image_url_text->setDescription(_CO_SPARTNER_IMAGE_URL_DSC);
    $sform->addElement($image_url_text, false);

    // URL
    $url_text = new XoopsFormText(_AM_SPARTNER_URL, 'url', 50, 255, $partnerObj->url());
    $url_text->setDescription(_AM_SPARTNER_URL_DSC);
    $sform->addElement($url_text, false);

    // SUMMARY
    $summary_text = new XoopsFormTextArea(_AM_SPARTNER_SUMMARY_REQ, 'summary', $partnerObj->summary(0, 'e'), 7, 60);
    $summary_text->setDescription(_AM_SPARTNER_SUMMARY_DSC);
    $sform->addElement($summary_text, true);
    // DESCRIPTION
    $description_text = new XoopsFormDhtmlTextArea(_AM_SPARTNER_DESCRIPTION, 'description', $partnerObj->description(0, 'e'), 15, 60);
    $description_text->setDescription(_AM_SPARTNER_DESCRIPTION_DSC);
    $sform->addElement($description_text, false);

    // CONTACT_NAME
    $contact_name_text = new XoopsFormText(_CO_SPARTNER_CONTACT_NAME, 'contact_name', 50, 255, $partnerObj->contact_name('e'));
    $contact_name_text->setDescription(_CO_SPARTNER_CONTACT_NAME_DSC);
    $sform->addElement($contact_name_text, false);

    // CONTACT_EMAIL
    $contact_email_text = new XoopsFormText(_CO_SPARTNER_CONTACT_EMAIL, 'contact_email', 50, 255, $partnerObj->contact_email('e'));
    $contact_email_text->setDescription(_CO_SPARTNER_CONTACT_EMAIL_DSC);
    $sform->addElement($contact_email_text, false);

    // CONTACT_PHONE
    $contact_phone_text = new XoopsFormText(_CO_SPARTNER_CONTACT_PHONE, 'contact_phone', 50, 255, $partnerObj->contact_phone('e'));
    $contact_phone_text->setDescription(_CO_SPARTNER_CONTACT_PHONE_DSC);
    $sform->addElement($contact_phone_text, false);

    // ADRESS
    //$adress_text = new XoopsFormText(_CO_SPARTNER_ADRESS, 'adress', 50, 255, $partnerObj->adress('e'));
    $adress_text = new XoopsFormTextArea(_CO_SPARTNER_ADRESS, 'adress', $partnerObj->adress('e'));
    $adress_text->setDescription(_CO_SPARTNER_ADRESS_DSC);
    $sform->addElement($adress_text, false);

    // STATUS
    $options = $partnerObj->getAvailableStatus();
    $status_select = new XoopsFormSelect(_AM_SPARTNER_STATUS, 'status', $new_status);
    $status_select->addOptionArray($options);
    $status_select->setDescription(_AM_SPARTNER_STATUS_DSC);
    $sform -> addElement( $status_select );

    // WEIGHT
    $weight_text = new XoopsFormText(_AM_SPARTNER_WEIGHT, 'weight', 4, 4, $partnerObj->weight());
    $weight_text->setDescription(_AM_SPARTNER_WEIGHT_DSC);
    $sform->addElement($weight_text);

    // Partner id
    $sform->addElement(new XoopsFormHidden('id', $partnerObj->id()));

    $button_tray = new XoopsFormElementTray('', '');
    $hidden = new XoopsFormHidden('op', 'addpartner');
    $button_tray->addElement($hidden);

    $sform->addElement(new XoopsFormHidden('original_status', $partnerObj->status()));

    if (!$id) {
        // there's no id? Then it's a new partner
        // $button_tray -> addElement( new XoopsFormButton( '', 'mod', _AM_SPARTNER_CREATE, 'submit' ) );
        $butt_create = new XoopsFormButton('', '', _AM_SPARTNER_CREATE, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'addpartner\'"');
        $button_tray->addElement($butt_create);

        $butt_clear = new XoopsFormButton('', '', _AM_SPARTNER_CLEAR, 'reset');
        $button_tray->addElement($butt_clear);

        $butt_cancel = new XoopsFormButton('', '', _AM_SPARTNER_CANCEL, 'button');
        $butt_cancel->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($butt_cancel);
    } else {
        // else, we're editing an existing partner
        // $button_tray -> addElement( new XoopsFormButton( '', 'mod', _AM_SPARTNER_MODIFY, 'submit' ) );
        $butt_create = new XoopsFormButton('', '', $button_caption, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'addpartner\'"');
        $button_tray->addElement($butt_create);

        $butt_cancel = new XoopsFormButton('', '', _AM_SPARTNER_CANCEL, 'button');
        $butt_cancel->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($butt_cancel);
    }

    $sform->addElement($button_tray);
    $sform->display();
    unset($hidden);
    echo "</div>";
}

/* -- Available operations -- */
switch ($op) {
    case "add":

        xoops_cp_header();
        include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

        editpartner(true, 0);
        break;

    case "mod":

        Global $xoopsUser, $xoopsConfig, $xoopsModuleConfig, $xoopsModule;
        $id = (isset($_GET['id'])) ? $_GET['id'] : 0;

        xoops_cp_header();
        include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

        editpartner(true, $id);
        break;

    case "addpartner":
        global $xoopsUser;

        if (!$xoopsUser) {
            if ($xoopsModuleConfig['anonpost'] == 1) {
                $uid = 0;
            } else {
                redirect_header("index.php", 3, _NOPERM);
                exit();
            }
        } else {
            $uid = $xoopsUser->uid();
        }

        $id = (isset($_POST['id'])) ? intval($_POST['id']) : 0;

        // Creating the partner object
        If ($id != 0) {
            $partnerObj =& new SmartpartnerPartner($id);
        } else {
            $partnerObj = $partner_handler->create();
        }

        // Uploading the logo, if any
        // Retreive the filename to be uploaded
        if ( $_FILES['logo_file']['name'] != "" ) {
            $filename = $_POST["xoops_upload_file"][0] ;
            if( !empty( $filename ) || $filename != "" ) {
                global $xoopsModuleConfig;

                $max_size = 10000000;
                $max_imgwidth = $xoopsModuleConfig['img_max_width'];
                $max_imgheight = $xoopsModuleConfig['img_max_height'];
                $allowed_mimetypes = smartpartner_getAllowedMimeTypes();

                include_once(XOOPS_ROOT_PATH."/class/uploader.php");

                if( $_FILES[$filename]['tmp_name'] == "" || ! is_readable( $_FILES[$filename]['tmp_name'] ) ) {
                    redirect_header( 'javascript:history.go(-1)' , 2, _CO_SPARTNER_FILE_UPLOAD_ERROR ) ;
                    exit ;
                }

                $uploader = new XoopsMediaUploader(smartpartner_getImageDir(), $allowed_mimetypes, $max_size, $max_imgwidth, $max_imgheight);

                // TODO : prefix the image file with the partnerid, but for that we need to first save the partner to get partnerid...
                // $uploader->setTargetFileName($partnerObj->partnerid() . "_" . $_FILES['logo_file']['name']);

                if( $uploader->fetchMedia( $filename ) && $uploader->upload() ) {

                    $partnerObj->setVar('image', $uploader->getSavedFileName());

                } else {
                    redirect_header( 'javascript:history.go(-1)' , 2, _CO_SPARTNER_FILE_UPLOAD_ERROR . $uploader->getErrors() ) ;
                    exit ;
                }
            }
        } else {
            $partnerObj->setVar('image', $_POST['image']);
        }

        // Putting the values in the partner object
        $partnerObj->setVar('id', (isset($_POST['id'])) ? intval($_POST['id']) : 0);
        $partnerObj->setVar('status', isset($_POST['status']) ? intval($_POST['status']) : 0);
        $partnerObj->setVar('title', $_POST['title']);
        $partnerObj->setVar('summary', $_POST['summary']);
        $partnerObj->setVar('image_url', $_POST['image_url']);
        $partnerObj->setVar('description', $_POST['description']);
        $partnerObj->setVar('contact_name', $_POST['contact_name']);
        $partnerObj->setVar('contact_email', $_POST['contact_email']);
        $partnerObj->setVar('contact_phone', $_POST['contact_phone']);
        $partnerObj->setVar('adress', $_POST['adress']);
        $partnerObj->setVar('url', $_POST['url']);
        $partnerObj->setVar('weight', (isset($_POST['weight'])) ? intval($_POST['weight']) : 0);

        $redirect_msgs = $partnerObj->getRedirectMsg($_POST['original_status'], $_POST['status']);

        // Storing the partner
        If ( !$partnerObj->store() ) {
            redirect_header("javascript:history.go(-1)", 3, $redirect_msgs['error'] . smartpartner_formatErrors($partnerObj->getErrors()));
            exit;
        }

        If (($_POST['original_status'] == _SPARTNER_STATUS_SUBMITTED) || ($_POST['status'] == _SPARTNER_STATUS_ACTIVE)) {
            $partnerObj->sendNotifications(array(_SPARTNER_NOT_PARTNER_APPROVED));
        }

        redirect_header("partner.php", 2, $redirect_msgs['success']);

        exit();
        break;

    case "del":
        global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $_GET;

        $module_id = $xoopsModule->getVar('mid');
        $gperm_handler = &xoops_gethandler('groupperm');

        $id = (isset($_POST['id'])) ? intval($_POST['id']) : 0;
        $id = (isset($_GET['id'])) ? intval($_GET['id']) : $id;

        $partnerObj = new SmartpartnerPartner($id);

        $confirm = (isset($_POST['confirm'])) ? $_POST['confirm'] : 0;
        $title = (isset($_POST['title'])) ? $_POST['title'] : '';

        if ($confirm) {
            If ( !$partner_handler->delete($partnerObj)) {
                redirect_header("partner.php", 2, _AM_SPARTNER_PARTNER_DELETE_ERROR);
                exit;
            }

            redirect_header("partner.php", 2, sprintf(_AM_SPARTNER_PARTNER_DELETE_SUCCESS, $partnerObj->title()));
            exit();
        } else {
            // no confirm: show deletion condition
            $id = (isset($_GET['id'])) ? intval($_GET['id']) : 0;
            xoops_cp_header();
            xoops_confirm(array('op' => 'del', 'id' => $partnerObj->id(), 'confirm' => 1, 'name' => $partnerObj->title()), 'partner.php', _AM_SPARTNER_DELETETHISP . " <br />'" . $partnerObj->title() . "' <br /> <br />", _AM_SPARTNER_DELETE);
            xoops_cp_footer();
        }

        exit();
        break;

    case "default":
    default:
        xoops_cp_header();

        smartpartner_adminMenu(1, _AM_SPARTNER_PARTNERS);

        include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
        include_once XOOPS_ROOT_PATH . '/class/pagenav.php';

        global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $xoopsModule;

        echo "<br />\n";

        smartpartner_collapsableBar('toptable', 'toptableicon');

        echo "<img id='toptableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SPARTNER_ACTIVE_PARTNERS . "</h3>";
        echo "<div id='toptable'>";
        echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . _AM_SPARTNER_ACTIVE_PARTNERS_DSC . "</span>";

        // Get the total number of published PARTNER
        $totalpartners = $partner_handler->getPartnerCount(_SPARTNER_STATUS_ACTIVE);
        // creating the partner objects that are published
        $partnersObj = $partner_handler->getPartners($xoopsModuleConfig['perpage_admin'], $startpartner);
        $totalPartnersOnPage = count($partnersObj);

        echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
        echo "<tr>";
        echo "<td class='bg3' width='200px' align='left'><b>" . _AM_SPARTNER_NAME . "</b></td>";
        echo "<td width='' class='bg3' align='left'><b>" . _AM_SPARTNER_INTRO . "</b></td>";
        echo "<td width='90' class='bg3' align='center'><b>" . _AM_SPARTNER_HITS . "</b></td>";
        echo "<td width='90' class='bg3' align='center'><b>" . _AM_SPARTNER_STATUS . "</b></td>";
        echo "<td width='90' class='bg3' align='center'><b>" . _AM_SPARTNER_ACTION . "</b></td>";
        echo "</tr>";
        if ($totalpartners > 0) {
            for ( $i = 0; $i < $totalPartnersOnPage; $i++ ) {

                $modify = "<a href='partner.php?op=mod&id=" . $partnersObj[$i]->id() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_SPARTNER_EDITPARTNER . "' alt='" . _AM_SPARTNER_EDITPARTNER . "' /></a>&nbsp;";
                $delete = "<a href='partner.php?op=del&id=" . $partnersObj[$i]->id() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_SPARTNER_DELETEPARTNER . "' alt='" . _AM_SPARTNER_DELETEPARTNER . "'/></a>&nbsp;";

                echo "<tr>";
                echo "<td class='head' align='left'><a href='" . SMARTPARTNER_URL . "partner.php?id=" . $partnersObj[$i]->id() . "'><img src='" . SMARTPARTNER_URL . "images/links/partner.gif' alt=''/>&nbsp;" . $partnersObj[$i]->title() . "</a></td>";
                echo "<td class='even' align='left'>" . $partnersObj[$i]->summary(100) . "</td>";
                echo "<td class='even' align='center'>" . $partnersObj[$i]->hits() . "</td>";
                echo "<td class='even' align='center'>" . $partnersObj[$i]->getStatusName() . "</td>";
                echo "<td class='even' align='center'> ". $modify . $delete . "</td>";
                echo "</tr>";
            }
        } else {
            $id = 0;
            echo "<tr>";
            echo "<td class='head' align='center' colspan= '7'>" . _AM_SPARTNER_NOPARTNERS . "</td>";
            echo "</tr>";
        }
        echo "</table>\n";
        echo "<br />\n";

        $pagenav = new XoopsPageNav($totalpartners, $xoopsModuleConfig['perpage_admin'], $startpartner, 'startpartner');
        echo '<div style="text-align:right;">' . $pagenav->renderNav() . '</div>';
        echo "</div>";

        editpartner();

        break;
}
$modfooter = smartpartner_modFooter();
echo "<div align='center'>" . $modfooter . "</div>";
xoops_cp_footer();

?>