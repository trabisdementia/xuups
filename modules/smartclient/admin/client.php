<?php

/**
 * $Id: client.php,v 1.7 2005/05/26 15:26:15 fx2024 Exp $
 * Module: SmartClient
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */
include_once("admin_header.php");

$op = '';
if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

// Where shall we start ?
$startclient = isset($_GET['startclient']) ? intval($_GET['startclient']) : 0;

function editclient($showmenu = false, $id = 0)
{
    global $client_handler, $xoopsUser, $xoopsConfig, $xoopsModuleConfig, $xoopsModule;

    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    // If there is a parameter, and the id exists, retrieve data: we're editing a client
    if ($id != 0) {
        // Creating the client object
        $clientObj = new SmartclientClient($id);

        if ($clientObj->notLoaded()) {
            redirect_header("client.php", 1, _AM_SCLIENT_NOCLIENTSELECTED);
            exit();
        }

        switch ($clientObj->status()) {

            case _SCLIENT_STATUS_SUBMITTED :
                $breadcrumb_action1 = 	_AM_SCLIENT_SUBMITTED_CLIENTS;
                $breadcrumb_action2 = 	_AM_SCLIENT_APPROVING;
                $page_title = _AM_SCLIENT_SUBMITTED_TITLE;
                $page_info = _AM_SCLIENT_SUBMITTED_INFO;
                $button_caption = _AM_SCLIENT_APPROVE;
                $new_status = _SCLIENT_STATUS_ACTIVE;
                break;

            case _SCLIENT_STATUS_ACTIVE :
                $breadcrumb_action1 = 	_AM_SCLIENT_ACTIVE_CLIENTS;
                $breadcrumb_action2 = 	_AM_SCLIENT_EDITING;
                $page_title = _AM_SCLIENT_ACTIVE_EDITING;
                $page_info = _AM_SCLIENT_ACTIVE_EDITING_INFO;
                $button_caption = _AM_SCLIENT_MODIFY;
                $new_status = _SCLIENT_STATUS_ACTIVE;
                break;

            case _SCLIENT_STATUS_INACTIVE :
                $breadcrumb_action1 = 	_AM_SCLIENT_INACTIVE_CLIENTS;
                $breadcrumb_action2 = 	_AM_SCLIENT_EDITING;
                $page_title = _AM_SCLIENT_INACTIVE_EDITING;
                $page_info = _AM_SCLIENT_INACTIVE_EDITING_INFO;
                $button_caption = _AM_SCLIENT_MODIFY;
                $new_status = _SCLIENT_STATUS_INACTIVE;
                break;

            case _SCLIENT_STATUS_REJECTED :
                $breadcrumb_action1 = 	_AM_SCLIENT_REJECTED_CLIENTS;
                $breadcrumb_action2 = 	_AM_SCLIENT_EDITING;
                $page_title = _AM_SCLIENT_REJECTED_EDITING;
                $page_info = _AM_SCLIENT_REJECTED_EDITING_INFO;
                $button_caption = _AM_SCLIENT_MODIFY;
                $new_status = _SCLIENT_STATUS_REJECTED;
                break;

            case "default" :
            default :
                break;
        }


        If ($showmenu) {
            smartclient_adminMenu(1, $breadcrumb_action1 . " > " . $breadcrumb_action2);
        }

        echo "<br />\n";
        smartclient_collapsableBar('bottomtable', 'bottomtableicon');
        echo "<img id='bottomtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . $page_title . "</h3>";
        echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . $page_info . "</span>";
        echo "<div id='bottomtable'>";
    } else {
        // there's no parameter, so we're adding a client
        $clientObj =& $client_handler->create();
        $breadcrumb_action1 = _AM_SCLIENT_CLIENTS;
        $breadcrumb_action2 = _AM_SCLIENT_CREATE;
        $button_caption = _AM_SCLIENT_CREATE;
        $new_status = _SCLIENT_STATUS_ACTIVE;
        If ($showmenu) {
            smartclient_adminMenu(1, $breadcrumb_action1 . " > " . $breadcrumb_action2);
        }
        smartclient_collapsableBar('bottomtable', 'bottomtableicon');
        echo "<img id='bottomtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SCLIENT_CLIENT_CREATING . "</h3>";
        echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . _AM_SCLIENT_CLIENT_CREATING_DSC . "</span>";
        echo "<div id='bottomtable'>";
    }

    // CLIENT FORM
    $sform = new XoopsThemeForm(_AM_SCLIENT_CLIENTS, "op", xoops_getenv('PHP_SELF'));
    $sform->setExtra('enctype="multipart/form-data"');

    // TITLE
    $title_text = new XoopsFormText(_CO_SCLIENT_TITLE_REQ, 'title', 50, 255, $clientObj->title('e'));
    $sform->addElement($title_text, true);

    // LOGO
    $logo_array = & XoopsLists :: getImgListAsArray( smartclient_getImageDir() );
    $logo_select = new XoopsFormSelect( '', 'image', $clientObj->image() );
    $logo_select -> addOption ('-1', '---------------');
    $logo_select -> addOptionArray( $logo_array );
    $logo_select -> setExtra( "onchange='showImgSelected(\"image3\", \"image\", \"" . 'uploads/' . SMARTCLIENT_DIRNAME . '/images' . "\", \"\", \"" . XOOPS_URL . "\")'" );
    $logo_tray = new XoopsFormElementTray( _AM_SCLIENT_LOGO, '&nbsp;' );
    $logo_tray -> addElement( $logo_select );
    $logo_tray -> addElement( new XoopsFormLabel( '', "<br /><br /><img src='" . smartclient_getImageDir('', false) .$clientObj->image() . "' name='image3' id='image3' alt='' />" ) );
    $logo_tray->setDescription(_AM_SCLIENT_LOGO_DSC);
    $sform -> addElement( $logo_tray );

    // LOGO UPLOAD
    $max_size = 5000000;
    $file_box = new XoopsFormFile(_AM_SCLIENT_LOGO_UPLOAD, "logo_file", $max_size);
    $file_box->setExtra( "size ='45'") ;
    $file_box->setDescription(sprintf(_AM_SCLIENT_LOGO_UPLOAD_DSC,$xoopsModuleConfig['img_max_width'],$xoopsModuleConfig['img_max_height']));
    $sform->addElement($file_box);

    // IMAGE_URL
    $image_url_text = new XoopsFormText(_CO_SCLIENT_IMAGE_URL, 'image_url', 50, 255, $clientObj->image_url());
    $image_url_text->setDescription(_CO_SCLIENT_IMAGE_URL_DSC);
    $sform->addElement($image_url_text, false);

    // URL
    $url_text = new XoopsFormText(_AM_SCLIENT_URL, 'url', 50, 255, $clientObj->url());
    $url_text->setDescription(_AM_SCLIENT_URL_DSC);
    $sform->addElement($url_text, false);

    // SUMMARY
    $summary_text = new XoopsFormTextArea(_AM_SCLIENT_SUMMARY_REQ, 'summary', $clientObj->summary(0, 'e'), 7, 60);
    $summary_text->setDescription(_AM_SCLIENT_SUMMARY_DSC);
    $sform->addElement($summary_text, true);
    // DESCRIPTION
    $description_text = new XoopsFormDhtmlTextArea(_AM_SCLIENT_DESCRIPTION, 'description', $clientObj->description(0, 'e'), 15, 60);
    $description_text->setDescription(_AM_SCLIENT_DESCRIPTION_DSC);
    $sform->addElement($description_text, false);

    // CONTACT_NAME
    $contact_name_text = new XoopsFormText(_CO_SCLIENT_CONTACT_NAME, 'contact_name', 50, 255, $clientObj->contact_name('e'));
    $contact_name_text->setDescription(_CO_SCLIENT_CONTACT_NAME_DSC);
    $sform->addElement($contact_name_text, false);

    // CONTACT_EMAIL
    $contact_email_text = new XoopsFormText(_CO_SCLIENT_CONTACT_EMAIL, 'contact_email', 50, 255, $clientObj->contact_email('e'));
    $contact_email_text->setDescription(_CO_SCLIENT_CONTACT_EMAIL_DSC);
    $sform->addElement($contact_email_text, false);

    // CONTACT_PHONE
    $contact_phone_text = new XoopsFormText(_CO_SCLIENT_CONTACT_PHONE, 'contact_phone', 50, 255, $clientObj->contact_phone('e'));
    $contact_phone_text->setDescription(_CO_SCLIENT_CONTACT_PHONE_DSC);
    $sform->addElement($contact_phone_text, false);

    // ADRESS
    //$adress_text = new XoopsFormText(_CO_SCLIENT_ADRESS, 'adress', 50, 255, $clientObj->adress('e'));
    $adress_text = new XoopsFormTextArea(_CO_SCLIENT_ADRESS, 'adress', $clientObj->adress('e'));
    $adress_text->setDescription(_CO_SCLIENT_ADRESS_DSC);
    $sform->addElement($adress_text, false);

    // STATUS
    $options = $clientObj->getAvailableStatus();
    $status_select = new XoopsFormSelect(_AM_SCLIENT_STATUS, 'status', $new_status);
    $status_select->addOptionArray($options);
    $status_select->setDescription(_AM_SCLIENT_STATUS_DSC);
    $sform -> addElement( $status_select );

    // WEIGHT
    $weight_text = new XoopsFormText(_AM_SCLIENT_WEIGHT, 'weight', 4, 4, $clientObj->weight());
    $weight_text->setDescription(_AM_SCLIENT_WEIGHT_DSC);
    $sform->addElement($weight_text);

    // Client id
    $sform->addElement(new XoopsFormHidden('id', $clientObj->id()));

    $button_tray = new XoopsFormElementTray('', '');
    $hidden = new XoopsFormHidden('op', 'addclient');
    $button_tray->addElement($hidden);

    $sform->addElement(new XoopsFormHidden('original_status', $clientObj->status()));

    if (!$id) {
        // there's no id? Then it's a new client
        // $button_tray -> addElement( new XoopsFormButton( '', 'mod', _AM_SCLIENT_CREATE, 'submit' ) );
        $butt_create = new XoopsFormButton('', '', _AM_SCLIENT_CREATE, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'addclient\'"');
        $button_tray->addElement($butt_create);

        $butt_clear = new XoopsFormButton('', '', _AM_SCLIENT_CLEAR, 'reset');
        $button_tray->addElement($butt_clear);

        $butt_cancel = new XoopsFormButton('', '', _AM_SCLIENT_CANCEL, 'button');
        $butt_cancel->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($butt_cancel);
    } else {
        // else, we're editing an existing client
        // $button_tray -> addElement( new XoopsFormButton( '', 'mod', _AM_SCLIENT_MODIFY, 'submit' ) );
        $butt_create = new XoopsFormButton('', '', $button_caption, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'addclient\'"');
        $button_tray->addElement($butt_create);

        $butt_cancel = new XoopsFormButton('', '', _AM_SCLIENT_CANCEL, 'button');
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

        editclient(true, 0);
        break;

    case "mod":

        Global $xoopsUser, $xoopsConfig, $xoopsModuleConfig, $xoopsModule;
        $id = (isset($_GET['id'])) ? $_GET['id'] : 0;

        xoops_cp_header();
        include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

        editclient(true, $id);
        break;

    case "addclient":
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

        // Creating the client object
        If ($id != 0) {
            $clientObj =& new SmartclientClient($id);
        } else {
            $clientObj = $client_handler->create();
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
                $allowed_mimetypes = smartclient_getAllowedMimeTypes();

                include_once(XOOPS_ROOT_PATH."/class/uploader.php");

                if( $_FILES[$filename]['tmp_name'] == "" || ! is_readable( $_FILES[$filename]['tmp_name'] ) ) {
                    redirect_header( 'javascript:history.go(-1)' , 2, _CO_SCLIENT_FILE_UPLOAD_ERROR ) ;
                    exit ;
                }

                $uploader = new XoopsMediaUploader(smartclient_getImageDir(), $allowed_mimetypes, $max_size, $max_imgwidth, $max_imgheight);

                // TODO : prefix the image file with the clientid, but for that we need to first save the client to get clientid...
                // $uploader->setTargetFileName($clientObj->clientid() . "_" . $_FILES['logo_file']['name']);

                if( $uploader->fetchMedia( $filename ) && $uploader->upload() ) {

                    $clientObj->setVar('image', $uploader->getSavedFileName());

                } else {
                    redirect_header( 'javascript:history.go(-1)' , 2, _CO_SCLIENT_FILE_UPLOAD_ERROR . $uploader->getErrors() ) ;
                    exit ;
                }
            }
        } else {
            $clientObj->setVar('image', $_POST['image']);
        }

        // Putting the values in the client object
        $clientObj->setVar('id', (isset($_POST['id'])) ? intval($_POST['id']) : 0);
        $clientObj->setVar('status', isset($_POST['status']) ? intval($_POST['status']) : 0);
        $clientObj->setVar('title', $_POST['title']);
        $clientObj->setVar('summary', $_POST['summary']);
        $clientObj->setVar('image_url', $_POST['image_url']);
        $clientObj->setVar('description', $_POST['description']);
        $clientObj->setVar('contact_name', $_POST['contact_name']);
        $clientObj->setVar('contact_email', $_POST['contact_email']);
        $clientObj->setVar('contact_phone', $_POST['contact_phone']);
        $clientObj->setVar('adress', $_POST['adress']);
        $clientObj->setVar('url', $_POST['url']);
        $clientObj->setVar('weight', (isset($_POST['weight'])) ? intval($_POST['weight']) : 0);

        $redirect_msgs = $clientObj->getRedirectMsg($_POST['original_status'], $_POST['status']);

        // Storing the client
        If ( !$clientObj->store() ) {
            redirect_header("javascript:history.go(-1)", 3, $redirect_msgs['error'] . smartclient_formatErrors($clientObj->getErrors()));
            exit;
        }

        If (($_POST['original_status'] == _SCLIENT_STATUS_SUBMITTED) || ($_POST['status'] == _SCLIENT_STATUS_ACTIVE)) {
            $clientObj->sendNotifications(array(_SCLIENT_NOT_CLIENT_APPROVED));
        }

        redirect_header("client.php", 2, $redirect_msgs['success']);

        exit();
        break;

    case "del":
        global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $_GET;

        $module_id = $xoopsModule->getVar('mid');
        $gperm_handler = &xoops_gethandler('groupperm');

        $id = (isset($_POST['id'])) ? intval($_POST['id']) : 0;
        $id = (isset($_GET['id'])) ? intval($_GET['id']) : $id;

        $clientObj = new SmartclientClient($id);

        $confirm = (isset($_POST['confirm'])) ? $_POST['confirm'] : 0;
        $title = (isset($_POST['title'])) ? $_POST['title'] : '';

        if ($confirm) {
            If ( !$client_handler->delete($clientObj)) {
                redirect_header("client.php", 2, _AM_SCLIENT_CLIENT_DELETE_ERROR);
                exit;
            }

            redirect_header("client.php", 2, sprintf(_AM_SCLIENT_CLIENT_DELETE_SUCCESS, $clientObj->title()));
            exit();
        } else {
            // no confirm: show deletion condition
            $id = (isset($_GET['id'])) ? intval($_GET['id']) : 0;
            xoops_cp_header();
            xoops_confirm(array('op' => 'del', 'id' => $clientObj->id(), 'confirm' => 1, 'name' => $clientObj->title()), 'client.php', _AM_SCLIENT_DELETETHISP . " <br />'" . $clientObj->title() . "' <br /> <br />", _AM_SCLIENT_DELETE);
            xoops_cp_footer();
        }

        exit();
        break;

    case "default":
    default:
        xoops_cp_header();

        smartclient_adminMenu(1, _AM_SCLIENT_CLIENTS);

        include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
        include_once XOOPS_ROOT_PATH . '/class/pagenav.php';

        global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $xoopsModule;

        echo "<br />\n";

        smartclient_collapsableBar('toptable', 'toptableicon');

        echo "<img id='toptableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SCLIENT_ACTIVE_CLIENTS . "</h3>";
        echo "<div id='toptable'>";
        echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . _AM_SCLIENT_ACTIVE_CLIENTS_DSC . "</span>";

        // Get the total number of published CLIENT
        $totalclients = $client_handler->getClientCount(_SCLIENT_STATUS_ACTIVE);
        // creating the client objects that are published
        $clientsObj = $client_handler->getClients($xoopsModuleConfig['perpage_admin'], $startclient);
        $totalClientsOnPage = count($clientsObj);

        echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
        echo "<tr>";
        echo "<td class='bg3' width='200px' align='left'><b>" . _AM_SCLIENT_NAME . "</b></td>";
        echo "<td width='' class='bg3' align='left'><b>" . _AM_SCLIENT_INTRO . "</b></td>";
        echo "<td width='90' class='bg3' align='center'><b>" . _AM_SCLIENT_HITS . "</b></td>";
        echo "<td width='90' class='bg3' align='center'><b>" . _AM_SCLIENT_STATUS . "</b></td>";
        echo "<td width='90' class='bg3' align='center'><b>" . _AM_SCLIENT_ACTION . "</b></td>";
        echo "</tr>";
        if ($totalclients > 0) {
            for ( $i = 0; $i < $totalClientsOnPage; $i++ ) {

                $modify = "<a href='client.php?op=mod&id=" . $clientsObj[$i]->id() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_SCLIENT_EDITCLIENT . "' alt='" . _AM_SCLIENT_EDITCLIENT . "' /></a>&nbsp;";
                $delete = "<a href='client.php?op=del&id=" . $clientsObj[$i]->id() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_SCLIENT_DELETECLIENT . "' alt='" . _AM_SCLIENT_DELETECLIENT . "'/></a>&nbsp;";

                echo "<tr>";
                echo "<td class='head' align='left'><a href='" . SMARTCLIENT_URL . "client.php?id=" . $clientsObj[$i]->id() . "'><img src='" . SMARTCLIENT_URL . "images/links/client.gif' alt=''/>&nbsp;" . $clientsObj[$i]->title() . "</a></td>";
                echo "<td class='even' align='left'>" . $clientsObj[$i]->summary(100) . "</td>";
                echo "<td class='even' align='center'>" . $clientsObj[$i]->hits() . "</td>";
                echo "<td class='even' align='center'>" . $clientsObj[$i]->getStatusName() . "</td>";
                echo "<td class='even' align='center'> ". $modify . $delete . "</td>";
                echo "</tr>";
            }
        } else {
            $id = 0;
            echo "<tr>";
            echo "<td class='head' align='center' colspan= '7'>" . _AM_SCLIENT_NOCLIENTS . "</td>";
            echo "</tr>";
        }
        echo "</table>\n";
        echo "<br />\n";

        $pagenav = new XoopsPageNav($totalclients, $xoopsModuleConfig['perpage_admin'], $startclient, 'startclient');
        echo '<div style="text-align:right;">' . $pagenav->renderNav() . '</div>';
        echo "</div>";

        editclient();

        break;
}
$modfooter = smartclient_modFooter();
echo "<div align='center'>" . $modfooter . "</div>";
xoops_cp_footer();

?>