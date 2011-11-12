<?php
// $Id$
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: Raul Recio (AKA UNFOR)                                            //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

//include '../../../include/cp_header.php';
include_once 'admin_header.php';

$indexAdmin = new ModuleAdmin();
$pathImageIcon = XOOPS_URL .'/'. $moduleInfo->getInfo('icons16');    

$del = 0;

function partnersAdmin()
{
    global $xoopsModule, $indexAdmin, $pathImageIcon;
    $xoopsDB =& Database::getInstance();
    $myts =& MyTextSanitizer::getInstance();
    $xpPartnerHandler =& xoops_getmodulehandler('partners', $xoopsModule->getVar('dirname'));  
  

    //	xoops_cp_header();
    //	$indexAdmin = new ModuleAdmin();
    echo $indexAdmin->addNavigation('main.php?op=default');
    echo"	<form action='main.php' method='post' name='reorderform'>\n"
        . "    <table style='width: 100%; border-width: 0px; margin: 1px; padding: 0px;' class='outer'>\n"
        . "      <tr>\n" . "        <th style='width: 20%; text-align: center;'>" . _AM_XPARTNERS_TITLE . "</th>\n"
        . "        <th style='width: 3%; text-align: center;'>" . _AM_XPARTNERS_IMAGE . "</th>\n" . "        <th>"
        . _AM_XPARTNERS_DESCRIPTION . "</th>\n" . "        <th style='width: 3%; text-align: center;'>"
        . _AM_XPARTNERS_ACTIVE . "</th>\n" . "        <th style='width: 3%; text-align: center;'>"
        . _AM_XPARTNERS_WEIGHT . "</th>\n" . "        <th style='width: 3%; text-align: center;'>" . _AM_XPARTNERS_HITS
        . "</th>\n" . "        <th style='width: 3%; text-align: center;'>" . _AM_XPARTNERS_ACTIONS . "</th>\n"
        . "      </tr>\n";

    $criteria = new CriteriaCompo();
    $criteria->setSort('status DESC, weight ASC, title');
    $criteria->setOrder('DESC');
    $partnerObjs = $xpPartnerHandler->getAll($criteria);
    $class = 'even';
    foreach (
        $partnerObjs as $partnerObj
    ) {
        $url = formatURL($myts->htmlSpecialChars($partnerObj->getVar('url')));
        $image = formatURL($myts->htmlSpecialChars($partnerObj->getVar('image')));
        $title = $myts->htmlSpecialChars($partnerObj->getVar('title'));
        $description = $myts->htmlSpecialChars($partnerObj->getVar('description'));
        $imageInfo = @getimagesize($partnerObj->getVar('image'));
        /*
            $result = $xoopsDB->query("SELECT id, hits, url, weight, image, title, description, status FROM ".$xoopsDB->prefix("partners")." ORDER BY status DESC, weight ASC, title DESC");
            $class = 'even';
          while (list($id, $hits, $url, $weight, $image, $title, $description, $status) = $xoopsDB->fetchrow($result)) {
            $url          = formatURL($myts->htmlSpecialChars($url));
            $image        = formatURL($myts->htmlSpecialChars($image));
            $title        = $myts->htmlSpecialChars($title);
            $description  = $myts->htmlSpecialChars($description);
        */
        $imageInfo = @getimagesize($image);
        $imageWidth = $imageInfo[0];
        $imageHeight = $imageInfo[1];
        $errorMsg = ($imageWidth >= 150 || $imageHeight >= 80) ? "<br />" . _AM_XPARTNERS_IMAGE_ERROR : '';
        $check1 = $check2 = "";
        if (1 == $partnerObj->getVar('status')) {
            $check1 = " selected='selected'";
        } else {
            $check2 = " selected='selected'";
        }
        echo"      <tr>\n"
            . "        <td class='{$class}' style='width: 20%; text-align: center; vertical-align: middle;'><a href='{$url}' rel='external'>{$title}</a></td>\n"
            . "        <td class='{$class}' style='width: 3%; text-align: center;'>";
        if (!empty($image)) {
            echo "<img src='{$image}' alt='{$title}' style='width: 102px; height: 47px;' />{$errorMsg}";
        } else {
            echo "&nbsp;";
        }

        echo"        </td>\n" . "        <td class='{$class}'>{$description}</td>\n"
            . "        <td class='{$class}' style='width: 3%px; text-align: center;'>\n"
            . "          <select style='size: 1px;' name='status[" . $partnerObj->getVar('id')
            . "]'> <option value='1'{$check1}>" . _YES . "</option><option value='0'{$check2}>" . _NO
            . "</option></select>\n" . "        <td class='{$class}' style='width: 3%; text-align: center;'>\n"
            . "          <input type='text' name='weight[" . $partnerObj->getVar('id') . "]' value='"
            . $partnerObj->getVar(
                'weight'
            ) . "' style='size: 3px; text-align: center;' maxlength='3' />\n" . "        </td>\n"
            . "        <td class='{$class}' style='width: 3%; text-align: center;'>" . $partnerObj->getVar('hits') . "</td>\n" 
            . "        <td class='{$class}' style='width: 3%; text-align: center;'>\n"
         
            . " <a href='main.php?op=editPartner&amp;id=" . $partnerObj->getVar('id')
            . "'><img src=". $pathImageIcon .'/edit.png' .' '."alt='" . _EDIT . "' title='" . _EDIT . "' /></a>\n"         
         
            . "          <a href='main.php?op=delPartner&amp;id=" . $partnerObj->getVar('id')
            . "'><img src=". $pathImageIcon .'/delete.png'.''." alt='" . _DELETE . "' title='" . _DELETE . "' /></a>\n"
            . "        </td>\n" . "      </tr>\n";
        $class = ($class == 'odd') ? 'even' : 'odd';
    }
    unset($partnerObjs);
    echo"      <tr>\n" . "        <td class='foot' colspan='7' style='text-align: right;'>\n"
        . "          <input type='hidden' name='op' value='reorderPartners' />\n"
        . "          <input type='button' name='button' onclick=\"location='main.php?op=partnersAdminAdd'\" value='"
        . _AM_XPARTNERS_ADD . "' />\n"
        . "          <input type='button' name='button' onclick=\"location='main.php?op=reorderAutoPartners'\" value='"
        . _AM_XPARTNERS_AUTOMATIC_SORT . "' />\n" . "          <input type='submit' name='submit' value='"
        . _AM_XPARTNERS_REORDER . "' />\n" . "        </td>\n" . "      </tr>\n" . "    </table>\n" . "  </form>\n";
    include 'admin_footer.php';
}

function reorderPartners($weight, $status)
{
    global $xoopsModule;
    //$xoopsDB =& Database::getInstance();
    $partnerHandler =& xoops_getmodulehandler('partners', $xoopsModule->getVar('dirname'));
    $partnerCount = $partnerHandler->getCount();
    if ($partnerCount) {
        /*
          $result = $xoopsDB->query("SELECT id FROM ".$xoopsDB->prefix("partners"));
          if ($xoopsDB->getRowsNum($result)) {
        */
        foreach (
            $weight as $id
            => $order
        ) {
            $id = (isset($id) && (intval($id) > 0)) ? intval($id) : 0;
            if ($id > 0) {
                $order = (isset($order) && (intval($order) > 0)) ? intval($order) : 0;
                $stat = isset($status[$id]) ? intval($status[$id]) : 0;
                $thisObj = $partnerHandler->get($id);
                if (is_object($thisObj) && count($thisObj)) {
                    $thisObj->setVar('weight', $weight);
                    $thisObj->setVar('status', $status);
                    $partnerHandler->insert($thisObj);
                    unset($thisObj);
                }
            }
        }
        redirect_header("main.php?op=default", 1, _AM_XPARTNERS_UPDATED);
    } else {
        redirect_header("main.php?op=partnersAdminAdd", 2, _AM_XPARTNERS_EMPTYDATABASE, false);
    }
}

function reorderAutoPartners()
{
    global $xoopsModule;
    //$xoopsDB =& Database::getInstance();
    $partnerHandler =& xoops_getmodulehandler('partners', $xoopsModule->getVar('dirname'));
    $partnerCount = $partnerHandler->getCount();
    $weight = 0;
    /*
        $result = $xoopsDB->query("SELECT id FROM ".$xoopsDB->prefix("partners")." ORDER BY weight ASC");
        if ($xoopsDB->getRowsNum($result)) {
    */
    if ($partnerCount) {
        $partnerObjs = $partnerHandler->getAll();
        foreach (
            $partnerObjs as $thisObj
        ) {
            $weight++;
            $thisObj->setVar('weight', $weight);
            $partnerHandler->insert($thisObj);
            unset($thisObj);
        }
        redirect_header("main.php?op=default", 1, _AM_XPARTNERS_UPDATED);
    } else {
        redirect_header("main.php?op=partnersAdminAdd", 2, _AM_XPARTNERS_EMPTYDATABASE, false);
    }
}

function partnersAdminAdd()
{
    global $xoopsModule, $indexAdmin, $pathImageIcon;
    $xoopsDB =& Database::getInstance();
    $myts =& MyTextSanitizer::getInstance();
    //xoops_cp_header();
    echo $indexAdmin->addNavigation('main.php?op=partnersAdminAdd');
    //echo "<h4>"._AM_XPARTNERS_ADD."</h4>";
    include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    $form = new XoopsThemeForm(_AM_XPARTNERS_ADDPARTNER, "addform", "main.php", "post", true);
    $formweight = new XoopsFormText(_AM_XPARTNERS_WEIGHT, "weight", 3, 10, 0);
    $formimage = new XoopsFormText(_AM_XPARTNERS_IMAGE, "image", 50, 150, 'http://');
    $formurl = new XoopsFormText(_AM_XPARTNERS_URL, "url", 50, 150, 'http://');
    $formtitle = new XoopsFormText(_AM_XPARTNERS_TITLE, "title", 50, 150);
    $formdesc = new XoopsFormTextArea(_AM_XPARTNERS_DESCRIPTION, "description", "", 10, "60");
    $statontxt
        = "&nbsp;<img src=". $pathImageIcon .'/on.png'.' '. "alt='" . _AM_XPARTNERS_ACTIVE . "' />&nbsp;" . _AM_XPARTNERS_ACTIVE
        . "&nbsp;&nbsp;&nbsp;";
    $statofftxt
        = "&nbsp;<img src=". $pathImageIcon .'/off.png' .' '."alt='" . _AM_XPARTNERS_INACTIVE . "' />&nbsp;"
        . _AM_XPARTNERS_INACTIVE . "&nbsp;";
    $formstat = new XoopsFormRadioYN(_AM_XPARTNERS_STATUS, 'status', 1, $statontxt, $statofftxt);
    /*
    $formstat   = new XoopsFormSelect(_AM_XPARTNERS_STATUS, "status");
    $formstat->addOption("1", _AM_XPARTNERS_ACTIVE);
    $formstat->addOption("0", _AM_XPARTNERS_INACTIVE);
    */
    $opHidden = new XoopsFormHidden("op", "addPartner");
    $submitButton = new XoopsFormButton("", "submit", _AM_XPARTNERS_ADDPARTNER, "submit");
    $form->addElement($formtitle, true);
    $form->addElement($formimage);
    $form->addElement($formurl, true);
    $form->addElement($formweight);
    $form->addElement($formdesc, true);
    $form->addElement($formstat);
    $form->addElement($opHidden);
    $form->addElement($submitButton);
    $form->display();
    include 'admin_footer.php';
}

function addPartner($weight, $url, $image, $title, $description, $status)
{
    global $xoopsModule;
    //$xoopsDB =& Database::getInstance();
    $myts =& MyTextSanitizer::getInstance();
    $partnerHandler =& xoops_getmodulehandler('partners', $xoopsModule->getVar('dirname'));
    $newPartner = $partnerHandler->create();

    $status = (isset($status)) ? intval($status) : 0;
    $weight = (isset($weight)) ? intval($weight) : 0;
    $title = isset($title) ? trim($title) : '';
    $url = isset($url) ? trim($url) : '';
    $image = isset($image) ? trim($image) : '';
    $image = $myts->addSlashes(formatURL($image));
    $description = isset($description) ? trim($description) : '';
    if ($title == '' || $url == '' || $description == '') {
        redirect_header("main.php?op=default", 1, _AM_XPARTNERS_BESURE);
    }
    /*
        if (!empty($image)) {
            $image_info   = @getimagesize($image);
            var_dump($image_info);
            exit;
            if (!$image_info[2]) {
                redirect_header("main.php?op=default", 2, _AM_XPARTNERS_NOEXIST . '<br />(' . $image . ')');
            }
        }

        if (!empty($image)) {
            $image_info   = exif_imagetype($image);
            if (false === $image_info) {
                redirect_header("main.php?op=default", 1, _AM_XPARTNERS_NOEXIST);
            }
        }
    */
    $newPartner->setVar('url', $myts->addSlashes(formatURL($url)));
    $newPartner->setVar('image', $image);
    $newPartner->setVar('title', $myts->addSlashes($title));
    $newPartner->setVar('description', $myts->addSlashes($description));
    $newPartner->setVar('status', $status);
    $newPartner->setVar('weight', $weight);
    if ($GLOBALS['xoopsSecurity']->check() && $partnerHandler->insert($newPartner)) {
        /*
            $sql = "INSERT INTO ".$xoopsDB->prefix("partners")." VALUES (NULL, ".intval($weight).", 0, '$url', '$image', '$title', '$description', $status)";
            if ($GLOBALS['xoopsSecurity']->check() && $xoopsDB->query($sql)) {
        */
        redirect_header("main.php?op=default", 1, _AM_XPARTNERS_UPDATED);
    } else {
        redirect_header(
            "main.php?op=default", 1,
            _AM_XPARTNERS_NOTUPDATED . "<br />" . implode('<br />', $GLOBALS['xoopsSecurity']->getErrors())
        );
    }
}

function editPartner($id)
{
    global $xoopsModule, $indexAdmin, $pathImageIcon;
    /*    $xoopsDB =& Database::getInstance(); */
    $myts =& MyTextSanitizer::getInstance();
    //xoops_cp_header();
    echo $indexAdmin->addNavigation('main.php?op=default');
    $id = (isset($id) && intval($id) > 0) ? intval($id) : 0;

    //echo "<h4>"._EDIT."</h4>";
    $partnerHandler =& xoops_getmodulehandler('partners', $xoopsModule->getVar('dirname'));
    $partnerObj = $partnerHandler->get($id);
    if (is_object($partnerObj) && count($partnerObj)) {
        /*
                $result = $xoopsDB->query("SELECT weight, hits, url, image, title, description, status FROM ".$xoopsDB->prefix("partners")." WHERE id={$id}");
                list($weight, $hits, $url, $image, $title, $description, $status) = $xoopsDB->fetchrow($result);
        */
        $partnerVars = $partnerObj->getValues();
        $url = $myts->htmlSpecialChars($partnerVars['url']);
        $image = $myts->htmlSpecialChars($partnerVars['image']);
        $title = $myts->htmlSpecialChars($partnerVars['title']);
        $description = $myts->htmlSpecialChars($partnerVars['description']);
        include XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
        $form = new XoopsThemeForm(_AM_XPARTNERS_EDITPARTNER, "editform", "main.php", "post", true);
        $formweight = new XoopsFormText(_AM_XPARTNERS_WEIGHT, "weight", 3, 10, $partnerVars['weight']);
        $formhits = new XoopsFormText(_AM_XPARTNERS_HITS, "hits", 3, 10, $partnerVars['hits']);
        $formimage = new XoopsFormText(_AM_XPARTNERS_IMAGE, "image", 50, 150, $image);
        $formurl = new XoopsFormText(_AM_XPARTNERS_URL, "url", 50, 150, $url);
        $formtitle = new XoopsFormText(_AM_XPARTNERS_TITLE, "title", 50, 150, $title);
        $formdesc = new XoopsFormTextArea(_AM_XPARTNERS_DESCRIPTION, "description", $description, 10, "100%");   
				
    $statontxt
        = "&nbsp;<img src=". $pathImageIcon .'/on.png'.' '. "alt='" . _AM_XPARTNERS_ACTIVE . "' />&nbsp;" . _AM_XPARTNERS_ACTIVE
        . "&nbsp;&nbsp;&nbsp;";
    $statofftxt
        = "&nbsp;<img src=". $pathImageIcon .'/off.png' .' '."alt='" . _AM_XPARTNERS_INACTIVE . "' />&nbsp;"
        . _AM_XPARTNERS_INACTIVE . "&nbsp;";		

        $formstat
            = new XoopsFormRadioYN(_AM_XPARTNERS_STATUS, 'status', $partnerVars['status'], $statontxt, $statofftxt);
        $idHidden = new XoopsFormHidden("id", $id);
        $opHidden = new XoopsFormHidden("op", "updatePartner");
        $submitButton = new XoopsFormButton("", "submit", _SUBMIT, "submit");
        $form->addElement($formtitle, true);
        $form->addElement($formimage);
        $form->addElement($formurl, true);
        $form->addElement($formweight);
        $form->addElement($formdesc, true);
        $form->addElement($formhits);
        $form->addElement($formstat);
        $form->addElement($idHidden);
        $form->addElement($opHidden);
        $form->addElement($submitButton);
        $form->display();
        include 'admin_footer.php';
    } else {
        redirect_header("main.php?op=default", 2, _AM_XPARTNERS_INVALIDID);
    }
}

function updatePartner($id, $weight, $hits, $url, $image, $title, $description, $status)
{
    global $xoopsModule;
    /*    $xoopsDB =& Database::getInstance(); */
    $myts =& MyTextSanitizer::getInstance();
    $title = isset($title) ? trim($title) : '';
    $image = isset($image) ? trim($image) : '';
    $image = $myts->addSlashes(formatURL($image));
    $url = isset($url) ? trim($url) : '';
    $description = isset($description) ? trim($description) : '';
    $id = (isset($id) && intval($id) > 0) ? intval($id) : 0;
    $status = isset($status) ? intval($status) : 0;
    $weight = isset($weight) ? intval($weight) : 0;
    $hits = (isset($hits) && intval($hits) > 0) ? intval($hits) : 0;
    if ($title == '' || $url == '' || empty($id) || $description == '') {
        redirect_header("main.php?op=edit_partner&amp;id={$id}", 1, _AM_XPARTNERS_BESURE);
    }
    /*
        if (!empty($image)) {
            $image_info   = exif_imagetype($image);;
            if (false === $image_info) {
                redirect_header("main.php?op=edit_partner&amp;id={$id}", 1, _AM_XPARTNERS_NOEXIST);
            }
        }
    */
    $partnerHandler =& xoops_getmodulehandler('partners', $xoopsModule->getVar('dirname'));
    $partnerObj = $partnerHandler->get($id);
    if ($GLOBALS['xoopsSecurity']->check() && is_object($partnerObj) && count($partnerObj)) {
        $partnerObj->setVar('url', $myts->addSlashes(formatURL($url)));
        $partnerObj->setVar('title', $myts->addSlashes($title));
        $partnerObj->setVar('description', $myts->addSlashes($description));
        $partnerObj->setVar('hits', $hits);
        $partnerObj->setVar('weight', $weight);
        $partnerObj->setVar('status', $status);
        $partnerObj->setVar('image', $image);
        $success = $partnerHandler->insert($partnerObj);
        if ($success) {
            redirect_header("main.php?op=default", 1, _AM_XPARTNERS_UPDATED);
        }
    }
    redirect_header(
        "main.php?op=default", 1,
        _AM_XPARTNERS_NOTUPDATED . "<br />" . implode('<br />', $GLOBALS['xoopsSecurity']->getErrors())
    );
}

function delPartner($id, $del = 0)
{
    global $xoopsModule, $indexAdmin;
    /*    $xoopsDB =& Database::getInstance(); */
    $id = (isset($id) && intval($id)) ? intval($id) : 0;
    if ((1 == $del) && ($id > 0)) {
        $partnerHandler =& xoops_getmodulehandler('partners', $xoopsModule->getVar('dirname'));
        $partnerObj = $partnerHandler->get($id);
        if (is_object($partnerObj) && count($partnerObj)) {
            if ($partnerHandler->delete($partnerObj)) {
                redirect_header("main.php?op=default", 1, _AM_XPARTNERS_UPDATED);
            }
        }
        redirect_header("main.php?op=default", 1, _AM_XPARTNERS_NOTUPDATED);
    } else {
        echo $indexAdmin->addNavigation('main.php?op=default');
        xoops_confirm(
            array('op' => 'delPartner', 'id' => intval($id), 'del' => 1), 'main.php', _AM_XPARTNERS_SUREDELETE
        );
        include 'admin_footer.php';
    }
}

$op = '';
/*
foreach ($_POST as $k => $v) {
  ${$k} = $v;
}
*/
$fields = array('op', 'id', 'weight', 'hits', 'url', 'image', 'title', 'description', 'status', 'del');
foreach (
    $fields as $field
) {
    if (isset($_POST[$field])) {
        $
        {$field}
            = $_POST[$field];
    }
}

if (isset($_GET['op'])) {
    $op = $_GET['op'];
    $id = (isset($_GET['id'])) ? intval($_GET['id']) : 0;
}

switch ($op) {
    case "partnersAdminAdd":
        partnersAdminAdd();
        break;
    case "updatePartner":
        updatePartner($id, $weight, $hits, $url, $image, $title, $description, $status);
        break;
    case "addPartner":
        addPartner($weight, $url, $image, $title, $description, $status);
        break;
    case "delPartner":
        delPartner($id, $del);
        break;
    case "editPartner":
        editPartner($id);
        break;
    case "reorderPartners":
        reorderPartners($weight, $status);
        break;
    case "reorderAutoPartners":
        reorderAutoPartners();
        break;
    default:
        partnersAdmin();
        break;
}