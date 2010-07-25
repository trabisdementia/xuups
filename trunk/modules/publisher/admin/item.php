<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Admin
 * @subpackage      Action
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: item.php 0 2009-06-11 18:47:04Z trabis $
 */

include_once dirname(__FILE__) . '/admin_header.php';

$itemid = PublisherRequest::getInt('itemid');
$op = ($itemid > 0 || isset($_POST['editor'])) ? 'mod' : '';
$op = PublisherRequest::getString('op', $op);

if (isset($_POST['additem'])) {
    $op = 'additem';
} else if (isset($_POST['del'])) {
    $op = 'del';
}

// Where shall we start ?
$submittedstartitem = PublisherRequest::getInt('submittedstartitem');
$publishedstartitem = PublisherRequest::getInt('publishedstartitem');
$offlinestartitem   = PublisherRequest::getInt('offlinestartitem');
$rejectedstartitem  = PublisherRequest::getInt('rejectedstartitem');

switch ($op) {
    case "clone":
        if ($itemid == 0) {
            $totalcategories = $publisher->getHandler('category')->getCategoriesCount(-1);
            if ($totalcategories == 0) {
                redirect_header("category.php?op=mod", 3, _AM_PUBLISHER_NEED_CATEGORY_ITEM);
                exit();
            }
        }
        publisher_cpHeader();
        publisher_editItem(true, $itemid, true);
        break;

    case "mod":
        if ($itemid == 0) {
            $totalcategories = $publisher->getHandler('category')->getCategoriesCount(-1);
            if ($totalcategories == 0) {
                redirect_header("category.php?op=mod", 3, _AM_PUBLISHER_NEED_CATEGORY_ITEM);
                exit();
            }
        }

        publisher_cpHeader();
        publisher_editItem(true, $itemid);
        break;

    case "additem":
        // Creating the item object
        if ($itemid != 0) {
            $itemObj = $publisher->getHandler('item')->get($itemid);
            $uid = $itemObj->getVar('uid');
            $datesub = $itemObj->getVar('datesub');
        } else {
            $itemObj = $publisher->getHandler('item')->create();
            $uid = $xoopsUser->uid();
            $datesub = time();
        }

        // Putting the values in the ITEM object
        if (isset($_POST['permissions_item'])) {
            $itemObj->setGroups_read($_POST['permissions_item']);
        } else{
            $itemObj->setGroups_read();
        }

        $itemObj->setVar('categoryid', PublisherRequest::getInt('categoryid'));
        $itemObj->setVar('title', PublisherRequest::getString('title'));
        $itemObj->setVar('subtitle', PublisherRequest::getString('subtitle'));
        $itemObj->setVar('summary', PublisherRequest::getText('summary'));
        $itemObj->setVar('body', PublisherRequest::getText('body'));

        $itemObj->setVar('meta_keywords', PublisherRequest::getString('item_meta_keywords'));
        $itemObj->setVar('meta_description', PublisherRequest::getString('item_meta_description'));
        $itemObj->setVar('short_url', PublisherRequest::getString('item_short_url'));

        $image_item = PublisherRequest::getArray('image_item');
        $image_featured = PublisherRequest::getString('image_featured');

        //Todo: get a better image class for xoops!
        //Image hack
        $image_item_ids = array();
        global $xoopsDB;
        $sql = 'SELECT image_id, image_name FROM ' . $xoopsDB->prefix('image');
        $result = $xoopsDB->query($sql, 0, 0);
        while ($myrow = $xoopsDB->fetchArray($result)) {
            $image_name = $myrow['image_name'];
            $id = $myrow['image_id'];
            if ($image_name == $image_featured) {
                 $itemObj->setVar('image', $id);
            }
            if (in_array($image_name, $image_item)) {
                $image_item_ids[] = $id;
            }

        }

        $itemObj->setVar('images', implode('|', $image_item_ids));
        //Image end hack

        $itemObj->setVar('item_tag', PublisherRequest::getString('item_tag'));

        $old_status = $itemObj->status();
        $new_status = PublisherRequest::getInt('status', _PUBLISHER_STATUS_PUBLISHED);//_PUBLISHER_STATUS_NOTSET;

        $itemObj->setVar('uid', PublisherRequest::getInt('uid', $uid));
        $itemObj->setVar('datesub', isset($_POST['datesub']) ? strtotime($_POST['datesub']['date']) + $_POST['datesub']['time'] : $datesub);

        $itemObj->setVar('weight', PublisherRequest::getInt('weight'));
        $itemObj->setPartial_view(PublisherRequest::getInt('partial_view', false));

        $itemObj->setVar('dohtml', PublisherRequest::getInt('dohtml', $publisher->getConfig('submit_dohtml')));
        $itemObj->setVar('dosmiley', PublisherRequest::getInt('dosmiley', $publisher->getConfig('submit_dosmiley')));
        $itemObj->setVar('doxcode', PublisherRequest::getInt('doxcode', $publisher->getConfig('submit_doxcode')));
        $itemObj->setVar('doimage', PublisherRequest::getInt('doimage', $publisher->getConfig('submit_doimage')));
        $itemObj->setVar('dobr', PublisherRequest::getInt('dolinebreak', $publisher->getConfig('submit_dobr')));
        $itemObj->setVar('cancomment', PublisherRequest::getInt('allowcomments', $publisher->getConfig('submit_allowcomments')));

        switch ($new_status) {
            case _PUBLISHER_STATUS_SUBMITTED:
                if (($old_status == _PUBLISHER_STATUS_NOTSET)) {
                    $error_msg = _AM_PUBLISHER_ITEMNOTUPDATED;
                } else {
                    $error_msg = _AM_PUBLISHER_ITEMNOTCREATED;
                }
                $redirect_msg = _AM_PUBLISHER_ITEM_RECEIVED_NEED_APPROVAL;
                break;

            case _PUBLISHER_STATUS_PUBLISHED:
                if (($old_status == _PUBLISHER_STATUS_NOTSET) || ($old_status == _PUBLISHER_STATUS_SUBMITTED)) {
                    $redirect_msg = _AM_PUBLISHER_SUBMITTED_APPROVE_SUCCESS;
                    $notifToDo = array(_PUBLISHER_NOT_ITEM_PUBLISHED);
                } else {
                    $redirect_msg = _AM_PUBLISHER_PUBLISHED_MOD_SUCCESS;
                }
                $error_msg = _AM_PUBLISHER_ITEMNOTUPDATED;
                break;

            case _PUBLISHER_STATUS_OFFLINE:
                if ($old_status == _PUBLISHER_STATUS_NOTSET) {
                    $redirect_msg = _AM_PUBLISHER_OFFLINE_CREATED_SUCCESS;
                } else {
                    $redirect_msg = _AM_PUBLISHER_OFFLINE_MOD_SUCCESS;
                }
                $error_msg = _AM_PUBLISHER_ITEMNOTUPDATED;
                break;

            case _PUBLISHER_STATUS_REJECTED:
                if ($old_status == _PUBLISHER_STATUS_NOTSET) {
                    $error_msg = _AM_PUBLISHER_ITEMNOTUPDATED;
                } else {
                    $error_msg = _AM_PUBLISHER_ITEMNOTCREATED;
                }
                $redirect_msg = _AM_PUBLISHER_ITEM_REJECTED;
                break;
        }
        $itemObj->setVar('status', $new_status);

        // Storing the item
        if (!$itemObj->store()) {
            redirect_header("javascript:history.go(-1)", 3, $error_msg . publisher_formatErrors($itemObj->getErrors()));
            exit;
        }

        // attach file if any
        if (isset($_FILES['item_upload_file']) && $_FILES['item_upload_file']['name'] != "") {
            $file_upload_result = publisher_uploadFile(false, false, $itemObj);
            if ($file_upload_result !== true) {
                redirect_header("javascript:history.go(-1)", 3, $file_upload_result);
                exit;
            }
        }

        // Send notifications
        if (!empty($notifToDo)) {
            $itemObj->sendNotifications($notifToDo);
        }

        redirect_header("item.php", 2, $redirect_msg);

        break;

    case "del":
        $itemObj = $publisher->getHandler('item')->get($itemid);
        $confirm = isset($_POST['confirm']) ? $_POST['confirm'] : 0;

        if ($confirm) {
            if (!$publisher->getHandler('item')->delete($itemObj)) {
                redirect_header("item.php", 2, _AM_PUBLISHER_ITEM_DELETE_ERROR . publisher_formatErrors($itemObj->getErrors()));
                exit();
            }
            redirect_header("item.php", 2, sprintf(_AM_PUBLISHER_ITEMISDELETED, $itemObj->title()));
            exit();
        } else {
            xoops_cp_header();
            xoops_confirm(array('op' => 'del', 'itemid' => $itemObj->itemid(), 'confirm' => 1, 'name' => $itemObj->title()), 'item.php', _AM_PUBLISHER_DELETETHISITEM . " <br />'" . $itemObj->title() . "'. <br /> <br />", _AM_PUBLISHER_DELETE);
            xoops_cp_footer();
        }
        exit();
        break;

    case "default":
    default:
        publisher_cpHeader();
        publisher_adminMenu(2, _AM_PUBLISHER_ITEMS);
        xoops_load('XoopsPageNav');

        echo "<br />\n";
        echo "<form><div style=\"margin-bottom: 12px;\">";
        echo "<input type='button' name='button' onclick=\"location='item.php?op=mod'\" value='" . _AM_PUBLISHER_CREATEITEM . "'>&nbsp;&nbsp;";
        echo "</div></form>";

        $orderBy = 'datesub';
        $ascOrDesc = 'DESC';

        // Display Submited articles
        publisher_openCollapsableBar('submiteditemstable', 'submiteditemsicon', _AM_PUBLISHER_SUBMISSIONSMNGMT, _AM_PUBLISHER_SUBMITTED_EXP);

        // Get the total number of submitted ITEM
        $totalitems = $publisher->getHandler('item')->getItemsCount(-1, array(_PUBLISHER_STATUS_SUBMITTED));

        $itemsObj = $publisher->getHandler('item')->getAllSubmitted($publisher->getConfig('idxcat_perpage'), $submittedstartitem, -1, $orderBy, $ascOrDesc);

        $totalItemsOnPage = count($itemsObj);

        echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
        echo "<tr>";
        echo "<td width='40' class='bg3' align='center'><b>" . _AM_PUBLISHER_ITEMID . "</b></td>";
        echo "<td width='20%' class='bg3' align='left'><b>" . _AM_PUBLISHER_ITEMCATEGORYNAME . "</b></td>";
        echo "<td class='bg3' align='left'><b>" . _AM_PUBLISHER_TITLE . "</b></td>";
        echo "<td width='90' class='bg3' align='center'><b>" . _AM_PUBLISHER_CREATED . "</b></td>";
        echo "<td width='80' class='bg3' align='center'><b>" . _AM_PUBLISHER_ACTION . "</b></td>";
        echo "</tr>";
        if ($totalitems > 0) {
            for ($i = 0; $i < $totalItemsOnPage; $i++) {
                $categoryObj =& $itemsObj[$i]->category();

                $approve = "<a href='item.php?op=mod&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . PUBLISHER_URL . "/images/icon/approve.gif' title='" . _AM_PUBLISHER_SUBMISSION_MODERATE . "' alt='" . _AM_PUBLISHER_SUBMISSION_MODERATE . "' /></a>&nbsp;";
                $clone = '';
                $delete = "<a href='item.php?op=del&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . PUBLISHER_URL . "/images/icon/delete.gif' title='" . _AM_PUBLISHER_DELETEITEM . "' alt='" . _AM_PUBLISHER_DELETEITEM . "' /></a>";
                $modify = "";

                echo "<tr>";
                echo "<td class='head' align='center'>" . $itemsObj[$i]->itemid() . "</td>";
                echo "<td class='even' align='left'>" . $categoryObj->getCategoryLink() . "</td>";
                echo "<td class='even' align='left'><a href='" . PUBLISHER_URL . "/item.php?itemid=" . $itemsObj[$i]->itemid() . "'>" . $itemsObj[$i]->title() . "</a></td>";
                echo "<td class='even' align='center'>" . $itemsObj[$i]->datesub() . "</td>";
                echo "<td class='even' align='center'> $approve $clone $modify $delete </td>";
                echo "</tr>";
            }
        } else {
            $itemid = 0;
            echo "<tr>";
            echo "<td class='head' align='center' colspan= '7'>" . _AM_PUBLISHER_NOITEMS_SUBMITTED . "</td>";
            echo "</tr>";
        }
        echo "</table>\n";
        echo "<br />\n";

        $pagenav = new XoopsPageNav($totalitems, $publisher->getConfig('idxcat_perpage'), $submittedstartitem, 'submittedstartitem');
        echo '<div style="text-align:right;">' . $pagenav->renderNav() . '</div>';

        publisher_closeCollapsableBar('submiteditemstable', 'submiteditemsicon');

        // Display Published articles
        publisher_openCollapsableBar('item_publisheditemstable', 'item_publisheditemsicon', _AM_PUBLISHER_PUBLISHEDITEMS, _AM_PUBLISHER_PUBLISHED_DSC);

        // Get the total number of published ITEM
        $totalitems = $publisher->getHandler('item')->getItemsCount(-1, array(_PUBLISHER_STATUS_PUBLISHED));

        $itemsObj = $publisher->getHandler('item')->getAllPublished($publisher->getConfig('idxcat_perpage'), $publishedstartitem, -1, $orderBy, $ascOrDesc);

        $totalItemsOnPage = count($itemsObj);

        echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
        echo "<tr>";
        echo "<td width='40' class='bg3' align='center'><b>" . _AM_PUBLISHER_ITEMID . "</b></td>";
        echo "<td width='20%' class='bg3' align='left'><b>" . _AM_PUBLISHER_ITEMCATEGORYNAME . "</b></td>";
        echo "<td class='bg3' align='left'><b>" . _AM_PUBLISHER_TITLE . "</b></td>";
        echo "<td width='90' class='bg3' align='center'><b>" . _AM_PUBLISHER_CREATED . "</b></td>";
        echo "<td width='80' class='bg3' align='center'><b>" . _AM_PUBLISHER_ACTION . "</b></td>";
        echo "</tr>";
        if ($totalitems > 0) {
            for ($i = 0; $i < $totalItemsOnPage; $i++) {
                $categoryObj =& $itemsObj[$i]->category();

                $modify = "<a href='item.php?op=mod&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . PUBLISHER_URL . "/images/icon/edit.gif' title='" . _AM_PUBLISHER_EDITITEM . "' alt='" . _AM_PUBLISHER_EDITITEM . "' /></a>";
                $delete = "<a href='item.php?op=del&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . PUBLISHER_URL . "/images/icon/delete.gif' title='" . _AM_PUBLISHER_DELETEITEM . "' alt='" . _AM_PUBLISHER_DELETEITEM . "'/></a>";
                $clone = "<a href='item.php?op=clone&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . PUBLISHER_URL . "/images/icon/clone.gif' title='" . _AM_PUBLISHER_CLONE_ITEM . "' alt='" . _AM_PUBLISHER_CLONE_ITEM . "' /></a>";

                echo "<tr>";
                echo "<td class='head' align='center'>" . $itemsObj[$i]->itemid() . "</td>";
                echo "<td class='even' align='left'>" . $categoryObj->getCategoryLink() . "</td>";
                echo "<td class='even' align='left'>" . $itemsObj[$i]->getItemLink() . "</td>";
                echo "<td class='even' align='center'>" . $itemsObj[$i]->datesub() . "</td>";
                echo "<td class='even' align='center'> $clone $modify $delete </td>";
                echo "</tr>";
            }
        } else {
            $itemid = 0;
            echo "<tr>";
            echo "<td class='head' align='center' colspan= '7'>" . _AM_PUBLISHER_NOITEMS . "</td>";
            echo "</tr>";
        }
        echo "</table>\n";
        echo "<br />\n";

        $pagenav = new XoopsPageNav($totalitems, $publisher->getConfig('idxcat_perpage'), $publishedstartitem, 'publishedstartitem');
        echo '<div style="text-align:right;">' . $pagenav->renderNav() . '</div>';

        publisher_closeCollapsableBar('item_publisheditemstable', 'item_publisheditemsicon');

        // Display Offline articles
        publisher_openCollapsableBar('offlineitemstable', 'offlineitemsicon', _AM_PUBLISHER_ITEMS . " " . _CO_PUBLISHER_OFFLINE, _AM_PUBLISHER_OFFLINE_EXP);

        $totalitems = $publisher->getHandler('item')->getItemsCount(-1, array(_PUBLISHER_STATUS_OFFLINE));

        $itemsObj = $publisher->getHandler('item')->getAllOffline($publisher->getConfig('idxcat_perpage'), $offlinestartitem, -1, $orderBy, $ascOrDesc);

        $totalItemsOnPage = count($itemsObj);

        echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
        echo "<tr>";
        echo "<td width='40' class='bg3' align='center'><b>" . _AM_PUBLISHER_ITEMID . "</b></td>";
        echo "<td width='20%' class='bg3' align='left'><b>" . _AM_PUBLISHER_ITEMCATEGORYNAME . "</b></td>";
        echo "<td class='bg3' align='left'><b>" . _AM_PUBLISHER_TITLE . "</b></td>";
        echo "<td width='90' class='bg3' align='center'><b>" . _AM_PUBLISHER_CREATED . "</b></td>";
        echo "<td width='80' class='bg3' align='center'><b>" . _AM_PUBLISHER_ACTION . "</b></td>";
        echo "</tr>";
        if ($totalitems > 0) {
            for ($i = 0; $i < $totalItemsOnPage; $i++) {
                $categoryObj =& $itemsObj[$i]->category();

                $modify = "<a href='item.php?op=mod&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . PUBLISHER_URL . "/images/icon/edit.gif' title='" . _AM_PUBLISHER_EDITITEM . "' alt='" . _AM_PUBLISHER_EDITITEM . "' /></a>";
                $delete = "<a href='item.php?op=del&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . PUBLISHER_URL . "/images/icon/delete.gif' title='" . _AM_PUBLISHER_DELETEITEM . "' alt='" . _AM_PUBLISHER_DELETEITEM . "'/></a>";
                $clone = "<a href='item.php?op=clone&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . PUBLISHER_URL . "/images/icon/clone.gif' title='" . _AM_PUBLISHER_CLONE_ITEM . "' alt='" . _AM_PUBLISHER_CLONE_ITEM . "' /></a>";

                echo "<tr>";
                echo "<td class='head' align='center'>" . $itemsObj[$i]->itemid() . "</td>";
                echo "<td class='even' align='left'>" . $categoryObj->getCategoryLink() . "</td>";
                echo "<td class='even' align='left'>" . $itemsObj[$i]->getItemLink() . "</td>";
                echo "<td class='even' align='center'>" . $itemsObj[$i]->datesub() . "</td>";
                echo "<td class='even' align='center'> $clone $modify $delete </td>";
                echo "</tr>";
            }
        } else {
            $itemid = 0;
            echo "<tr>";
            echo "<td class='head' align='center' colspan= '7'>" . _AM_PUBLISHER_NOITEMS_OFFLINE . "</td>";
            echo "</tr>";
        }
        echo "</table>\n";
        echo "<br />\n";

        $pagenav = new XoopsPageNav($totalitems, $publisher->getConfig('idxcat_perpage'), $offlinestartitem, 'offlinestartitem');
        echo '<div style="text-align:right;">' . $pagenav->renderNav() . '</div>';

        publisher_closeCollapsableBar('offlineitemstable', 'offlineitemsicon');

        // Display Rejected articles
        publisher_openCollapsableBar('Rejecteditemstable', 'rejecteditemsicon', _AM_PUBLISHER_REJECTED_ITEM, _AM_PUBLISHER_REJECTED_ITEM_EXP, _AM_PUBLISHER_SUBMITTED_EXP);

        // Get the total number of Rejected ITEM
        $totalitems = $publisher->getHandler('item')->getItemsCount(-1, array(_PUBLISHER_STATUS_REJECTED));

        $itemsObj = $publisher->getHandler('item')->getAllRejected($publisher->getConfig('idxcat_perpage'), $rejectedstartitem, -1, $orderBy, $ascOrDesc);

        $totalItemsOnPage = count($itemsObj);

        echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
        echo "<tr>";
        echo "<td width='40' class='bg3' align='center'><b>" . _AM_PUBLISHER_ITEMID . "</b></td>";
        echo "<td width='20%' class='bg3' align='left'><b>" . _AM_PUBLISHER_ITEMCATEGORYNAME . "</b></td>";
        echo "<td class='bg3' align='left'><b>" . _AM_PUBLISHER_TITLE . "</b></td>";
        echo "<td width='90' class='bg3' align='center'><b>" . _AM_PUBLISHER_CREATED . "</b></td>";
        echo "<td width='80' class='bg3' align='center'><b>" . _AM_PUBLISHER_ACTION . "</b></td>";
        echo "</tr>";
        if ($totalitems > 0) {
            for ($i = 0; $i < $totalItemsOnPage; $i++) {
                $categoryObj =& $itemsObj[$i]->category();

                $modify = "<a href='item.php?op=mod&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . PUBLISHER_URL . "/images/icon/edit.gif' title='" . _AM_PUBLISHER_EDITITEM . "' alt='" . _AM_PUBLISHER_EDITITEM . "' /></a>";
                $delete = "<a href='item.php?op=del&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . PUBLISHER_URL . "/images/icon/delete.gif' title='" . _AM_PUBLISHER_DELETEITEM . "' alt='" . _AM_PUBLISHER_DELETEITEM . "'/></a>";
                $clone = "<a href='item.php?op=clone&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . PUBLISHER_URL . "/images/icon/clone.gif' title='" . _AM_PUBLISHER_CLONE_ITEM . "' alt='" . _AM_PUBLISHER_CLONE_ITEM . "' /></a>";

                echo "<tr>";
                echo "<td class='head' align='center'>" . $itemsObj[$i]->itemid() . "</td>";
                echo "<td class='even' align='left'>" . $categoryObj->getCategoryLink() . "</td>";
                echo "<td class='even' align='left'>" . $itemsObj[$i]->getItemLink() . "</td>";
                echo "<td class='even' align='center'>" . $itemsObj[$i]->datesub() . "</td>";
                echo "<td class='even' align='center'> $clone $modify $delete </td>";
                echo "</tr>";
            }
        } else {
            $itemid = 0;
            echo "<tr>";
            echo "<td class='head' align='center' colspan= '7'>" . _AM_PUBLISHER_NOITEMS_REJECTED . "</td>";
            echo "</tr>";
        }
        echo "</table>\n";
        echo "<br />\n";

        $pagenav = new XoopsPageNav($totalitems, $publisher->getConfig('idxcat_perpage'), $rejectedstartitem, 'rejectedstartitem');
        echo '<div style="text-align:right;">' . $pagenav->renderNav() . '</div>';

        publisher_closeCollapsableBar('Rejecteditemstable', 'rejecteditemsicon');
        break;
}
xoops_cp_footer();

function publisher_showFiles($itemObj)
{
    // UPLOAD FILES
    $publisher =& PublisherPublisher::getInstance();
    publisher_openCollapsableBar('filetable', 'filetableicon', _AM_PUBLISHER_FILES_LINKED);
    $filesObj =& $publisher->getHandler('file')->getAllFiles($itemObj->itemid());
    if (count($filesObj) > 0) {
        echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
        echo "<tr>";
        echo "<td width='50' class='bg3' align='center'><b>ID</b></td>";
        echo "<td width='150' class='bg3' align='left'><b>" . _AM_PUBLISHER_FILENAME . "</b></td>";
        echo "<td class='bg3' align='left'><b>" . _AM_PUBLISHER_DESCRIPTION . "</b></td>";
        echo "<td width='60' class='bg3' align='center'><b>" . _AM_PUBLISHER_HITS . "</b></td>";
        echo "<td width='100' class='bg3' align='center'><b>" . _AM_PUBLISHER_UPLOADED_DATE . "</b></td>";
        echo "<td width='60' class='bg3' align='center'><b>" . _AM_PUBLISHER_ACTION . "</b></td>";
        echo "</tr>";

        for ($i = 0; $i < count($filesObj); $i++) {
            $modify = "<a href='file.php?op=mod&fileid=" . $filesObj[$i]->fileid() . "'><img src='" . PUBLISHER_URL . "/images/icon/edit.gif' title='" . _AM_PUBLISHER_EDITFILE . "' alt='" . _AM_PUBLISHER_EDITFILE . "' /></a>";
            $delete = "<a href='file.php?op=del&fileid=" . $filesObj[$i]->fileid() . "'><img src='" . PUBLISHER_URL . "/images/icon/delete.gif' title='" . _AM_PUBLISHER_DELETEFILE . "' alt='" . _AM_PUBLISHER_DELETEFILE . "'/></a>";
            if ($filesObj[$i]->status() == 0) {
                $not_visible = "<img src='" . PUBLISHER_URL . "/images/no.gif'/>";
            } else {
                $not_visible ='';
            }
            echo "<tr>";
            echo "<td class='head' align='center'>" .$filesObj[$i]->getVar('fileid') . "</td>";
            echo "<td class='odd' align='left'>" .$not_visible. $filesObj[$i]->getFileLink() . "</td>";
            echo "<td class='even' align='left'>" . $filesObj[$i]->description() . "</td>";
            echo "<td class='even' align='center'>" . $filesObj[$i]->counter() . "";
            echo "<td class='even' align='center'>" . $filesObj[$i]->datesub() . "</td>";
            echo "<td class='even' align='center'> $modify $delete </td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<br >";
    } else {
        echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . _AM_PUBLISHER_NOFILE . "</span>";
    }

    echo "<form><div style=\"margin-bottom: 24px;\">";
    echo "<input type='button' name='button' onclick=\"location='file.php?op=mod&amp;itemid=" . $itemObj->itemid(). "'\" value='" . _AM_PUBLISHER_UPLOAD_FILE_NEW . "'>&nbsp;&nbsp;";
    echo "</div></form>";

    publisher_closeCollapsableBar('filetable', 'filetableicon');
}

function publisher_editItem($showmenu = false, $itemid = 0, $clone = false)
{
    $publisher =& PublisherPublisher::getInstance();
    global $publisher_current_page, $xoopsUser;

    xoops_load('XoopsFormLoader');

    $formTpl = new XoopsTpl();
    //publisher_submit.html

    // if there is a parameter, and the id exists, retrieve data: we're editing a item

    if ($itemid != 0) {

        // Creating the ITEM object
        $itemObj = $publisher->getHandler('item')->get($itemid);

        if (!$itemObj) {
            redirect_header("item.php", 1, _AM_PUBLISHER_NOITEMSELECTED);
            exit();
        }

        if ($clone) {
            $itemObj->setNew();
            $itemObj->setVar('itemid', 0);
            $itemObj->setVar('status', _PUBLISHER_STATUS_NOTSET);
            $itemObj->setVar('datesub', time());
        }

        switch ($itemObj->status()) {

            case _PUBLISHER_STATUS_SUBMITTED:
                $breadcrumb_action1 = _CO_PUBLISHER_SUBMITTED;
                $breadcrumb_action2 = _AM_PUBLISHER_APPROVING;
                $page_title = _AM_PUBLISHER_SUBMITTED_TITLE;
                $page_info = _AM_PUBLISHER_SUBMITTED_INFO;
                $button_caption = _AM_PUBLISHER_APPROVE;
                $new_status = _PUBLISHER_STATUS_PUBLISHED;
                break;

            case _PUBLISHER_STATUS_PUBLISHED:
                $breadcrumb_action1 = _CO_PUBLISHER_PUBLISHED;
                $breadcrumb_action2 = _AM_PUBLISHER_EDITING;
                $page_title = _AM_PUBLISHER_PUBLISHEDEDITING;
                $page_info = _AM_PUBLISHER_PUBLISHEDEDITING_INFO;
                $button_caption = _AM_PUBLISHER_MODIFY;
                $new_status = _PUBLISHER_STATUS_PUBLISHED;
                break;

            case _PUBLISHER_STATUS_OFFLINE:
                $breadcrumb_action1 = _CO_PUBLISHER_OFFLINE;
                $breadcrumb_action2 = _AM_PUBLISHER_EDITING;
                $page_title = _AM_PUBLISHER_OFFLINEEDITING;
                $page_info = _AM_PUBLISHER_OFFLINEEDITING_INFO;
                $button_caption = _AM_PUBLISHER_MODIFY;
                $new_status = _PUBLISHER_STATUS_OFFLINE;
                break;

            case _PUBLISHER_STATUS_REJECTED:
                $breadcrumb_action1 = _CO_PUBLISHER_REJECTED;
                $breadcrumb_action2 = _AM_PUBLISHER_REJECTED;
                $page_title = _AM_PUBLISHER_REJECTED_EDIT;
                $page_info = _AM_PUBLISHER_REJECTED_EDIT_INFO;
                $button_caption = _AM_PUBLISHER_MODIFY;
                $new_status = _PUBLISHER_STATUS_REJECTED;
                break;

            case _PUBLISHER_STATUS_NOTSET: // Then it's a clone...
                $breadcrumb_action1 = _AM_PUBLISHER_ITEMS;
                $breadcrumb_action2 = _AM_PUBLISHER_CLONE_NEW;
                $button_caption = _AM_PUBLISHER_CREATE;
                $new_status = _PUBLISHER_STATUS_PUBLISHED;
                $page_title = _AM_PUBLISHER_ITEM_DUPLICATING;
                $page_info = _AM_PUBLISHER_ITEM_DUPLICATING_DSC;
                break;

            case "default" :
            default :
                $breadcrumb_action1 = 	_AM_PUBLISHER_ITEMS;
                $breadcrumb_action2 = 	_AM_PUBLISHER_EDITING;
                $page_title = _AM_PUBLISHER_PUBLISHEDEDITING;
                $page_info = _AM_PUBLISHER_PUBLISHEDEDITING_INFO;
                $button_caption = _AM_PUBLISHER_MODIFY;
                $new_status = _PUBLISHER_STATUS_PUBLISHED;
                break;
        }

        $categoryObj = $itemObj->category();

        if ($showmenu) {
            publisher_adminMenu(2, $breadcrumb_action1 . " > " . $breadcrumb_action2);
        }

        echo "<br />\n";
        publisher_openCollapsableBar('edititemtable', 'edititemicon', $page_title, $page_info);

        if (!$clone) {
            echo "<form><div style=\"margin-bottom: 10px;\">";
            echo "<input type='button' name='button' onclick=\"location='item.php?op=clone&itemid=" . $itemObj->itemid(). "'\" value='" . _AM_PUBLISHER_CLONE_ITEM . "'>&nbsp;&nbsp;";
            echo "</div></form>";
        }

    } else {
        // there's no parameter, so we're adding an item

        $itemObj =& $publisher->getHandler('item')->create();
        $itemObj->setVar('uid', $xoopsUser->uid());
        $itemObj->setVar('datesub', time());
        $categoryObj =& $publisher->getHandler('category')->create();
        $breadcrumb_action1 = _AM_PUBLISHER_ITEMS;
        $breadcrumb_action2 = _AM_PUBLISHER_CREATINGNEW;
        $button_caption = _AM_PUBLISHER_CREATE;
        $new_status = _PUBLISHER_STATUS_PUBLISHED;

        if ($showmenu) {
            publisher_adminMenu(2, $breadcrumb_action1 . " > " . $breadcrumb_action2);
        }

        $sel_categoryid = isset($_GET['categoryid']) ? $_GET['categoryid'] : 0;
        $categoryObj->setVar('categoryid', $sel_categoryid);

        publisher_openCollapsableBar('createitemtable', 'createitemicon', _AM_PUBLISHER_ITEM_CREATING, _AM_PUBLISHER_ITEM_CREATING_DSC);
    }

    $sform = $itemObj->getForm(_AM_PUBLISHER_ITEMS);
    $sform->assign($formTpl);
    $formTpl->display('db:publisher_submit.html');

    publisher_closeCollapsableBar('edititemtable', 'edititemicon');

    publisher_openCollapsableBar('pagewraptable', 'pagewrapicon', _AM_PUBLISHER_PAGEWRAP, _AM_PUBLISHER_PAGEWRAPDSC);

    $dir = publisher_getUploadDir(true, 'content');

    if(!preg_match('/777/i', decoct(fileperms($dir)))) {
        echo "<font color='FF0000'><h4>" . _AM_PUBLISHER_PERMERROR . "</h4></font>";
    }

    // Upload File
    echo "<form name='form_name2' id='form_name2' action='pw_upload_file.php' method='post' enctype='multipart/form-data'>";
    echo "<table cellspacing='1' width='100%' class='outer'>";
    echo "<tr><th colspan='2'>" . _AM_PUBLISHER_UPLOAD_FILE . "</th></tr>";
    echo "<tr valign='top' align='left'><td class='head'>" . _AM_PUBLISHER_SEARCH_PW . "</td><td class='even'><input type='file' name='fileupload' id='fileupload' size='30' /></td></tr>";
    echo "<tr valign='top' align='left'><td class='head'><input type='hidden' name='MAX_FILE_SIZE' id='op' value='500000' /></td><td class='even'><input type='submit' name='submit' value='" . _AM_PUBLISHER_UPLOAD . "' /></td></tr>";
    echo "<input type='hidden' name='backto' value='$publisher_current_page'/>";
    echo "</table>";
    echo "</form>";

    // Delete File
    $form = new XoopsThemeForm(_AM_PUBLISHER_DELETEFILE, "form_name", "pw_delete_file.php");

    $pWrap_select = new XoopsFormSelect(publisher_getUploadDir(true, 'content'), "address");
    $folder = dir($dir);
    while ($file = $folder->read()) {
        if ($file != "." && $file != "..") {
            $pWrap_select->addOption($file, $file);
        }
    }
    $folder->close();
    $form->addElement($pWrap_select);

    $delfile = "delfile";
    $form->addElement(new XoopsFormHidden('op', $delfile));
    $submit = new XoopsFormButton("", "submit", _AM_PUBLISHER_BUTTON_DELETE, "submit");
    $form->addElement($submit);

    $form->addElement(new XoopsFormHidden('backto', $publisher_current_page));
    $form->display();

    publisher_closeCollapsableBar('pagewraptable', 'pagewrapicon');

    if ($itemObj->getVar('itemid') != 0) {
        publisher_showFiles($itemObj);
    }
}
?>