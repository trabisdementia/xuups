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
 *  Publisher form class
 *
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Class
 * @subpackage      Forms
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: item.php 0 2009-06-11 18:47:04Z trabis $
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

include_once dirname(dirname(dirname(__FILE__))) . '/include/common.php';

include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';
include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once PUBLISHER_ROOT_PATH . '/class/formdatetime.php';
include_once PUBLISHER_ROOT_PATH . '/class/themetabform.php';

class PublisherItemForm extends XoopsThemeTabForm {

    var $checkperm = true;

    function setCheckPermissions($checkperm)
    {
        $this->checkperm = (bool) $checkperm;
    }

    function createElements($obj) {
        
        global $xoopsConfig, $xoopsUser;
        $publisher =& PublisherPublisher::getInstance();
        $checkperm = $this->checkperm;

        $allowed_editors = publisher_getEditors($publisher->getHandler('permission')->getGrantedItems('editors'));
        $form_view = $publisher->getHandler('permission')->getGrantedItems('form_view');

        if (!is_object($xoopsUser)) {
            $group = array(XOOPS_GROUP_ANONYMOUS);
        } else {
            $group = $xoopsUser->getGroups();
        }

        $this->setExtra('enctype="multipart/form-data"');

        $this->startTab(_CO_PUBLISHER_TAB_MAIN);

        // Category
        $category_select = new XoopsFormSelect(_CO_PUBLISHER_CATEGORY, 'categoryid', $obj->getVar('categoryid', 'e'));
        $category_select->setDescription(_CO_PUBLISHER_CATEGORY_DSC);
        $category_select->addOptionArray($publisher->getHandler('category')->getCategoriesForSubmit());
        $this->addElement($category_select);

        // ITEM TITLE
        $this->addElement(new XoopsFormText(_CO_PUBLISHER_TITLE, 'title', 50, 255, $obj->getVar('title', 'e')), true);

        // SUBTITLE
        if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_SUBTITLE)) {
            $this->addElement(new XoopsFormText(_CO_PUBLISHER_SUBTITLE, 'subtitle', 50, 255, $obj->getVar('subtitle', 'e')));
        }

         // SHORT URL
        if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_ITEM_SHORT_URL)) {
            $text_short_url = new XoopsFormText(_CO_PUBLISHER_ITEM_SHORT_URL, 'item_short_url', 50, 255, $obj->short_url('e'));
            $text_short_url->setDescription(_CO_PUBLISHER_ITEM_SHORT_URL_DSC);
            $this->addElement($text_short_url);
        }

        // TAGS
        if (publisher_isActive('tag') && (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_ITEM_TAGS))) {
            include_once XOOPS_ROOT_PATH . '/modules/tag/include/formtag.php';
            $text_tags = new XoopsFormTag('item_tag', 60, 255, $obj->getVar('item_tag', 'e'), 0);
            $this->addElement($text_tags);
        }

        // SUMMARY
        if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_SUMMARY)) {
            // Description
		    $summary_text = new XoopsFormTextArea(_CO_PUBLISHER_SUMMARY, 'summary', $obj->getVar('summary', 'e'), 7, 60);
            /*$editor_configs["name"] = "summary";
            $editor_configs["value"] = $obj->getVar('summary', 'e');
            $summary_text = new XoopsFormEditor(_CO_PUBLISHER_SUMMARY, $editor, $editor_configs, $nohtml, $onfailure = null);   */
            $summary_text->setDescription(_CO_PUBLISHER_SUMMARY_DSC);
            $this->addElement($summary_text);
        }

        // SELECT EDITOR
        $nohtml = false;
        if (count($allowed_editors) > 0) {
            $editor = @$_POST['editor'];
            if (!empty($editor)) {
                publisher_setCookieVar('publisher_editor', $editor);
            } else {
                $editor = publisher_getCookieVar('publisher_editor');
                if (empty($editor) && is_object($xoopsUser)) {
                    $editor =@ $xoopsUser->getVar('publisher_editor'); // Need set through user profile
                }
            }
            $editor = (empty($editor) || !in_array($editor, $allowed_editors)) ?  $publisher->getConfig('submit_editor') : $editor;

            $form_editor = new XoopsFormSelectEditor($this, 'editor', $editor, $nohtml, $allowed_editors);
            $this->addElement($form_editor);
        } else {
            $editor = $publisher->getConfig('submit_editor');
        }

        $editor_configs = array();
        $editor_configs["rows"]   = !$publisher->getConfig('submit_editor_rows') ? 35 : $publisher->getConfig('submit_editor_rows');
        $editor_configs["cols"]   = !$publisher->getConfig('submit_editor_cols') ? 60 : $publisher->getConfig('submit_editor_cols');
        $editor_configs["width"]  = !$publisher->getConfig('submit_editor_width') ? "100%" : $publisher->getConfig('submit_editor_width');
        $editor_configs["height"] = !$publisher->getConfig('submit_editor_height') ? "400px" : $publisher->getConfig('submit_editor_height');

        // BODY
        $editor_configs["name"] = "body";
        $editor_configs["value"] = $obj->getVar('body', 'e');
        $body_text = new XoopsFormEditor(_CO_PUBLISHER_BODY, $editor, $editor_configs, $nohtml, $onfailure = null);
        $body_text->setDescription(_CO_PUBLISHER_BODY_DSC);
        $this->addElement($body_text);

        // VARIOUS OPTIONS
        if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_DOHTML)
                        || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_DOSMILEY)
                        || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_DOXCODE)
                        || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_DOIMAGE)
                        || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_DOLINEBREAK)) {

            $options_tray = new XoopsFormElementTray(_CO_PUBLISHER_OPTIONS, '<br />');

            if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_DOHTML)) {
                $html_checkbox = new XoopsFormCheckBox('', 'dohtml', $obj->dohtml());
                $html_checkbox->addOption(1, _CO_PUBLISHER_DOHTML);
                $options_tray->addElement($html_checkbox);
            }

            if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_DOSMILEY)) {
                $smiley_checkbox = new XoopsFormCheckBox('', 'dosmiley', $obj->dosmiley());
                $smiley_checkbox->addOption(1, _CO_PUBLISHER_DOSMILEY);
                $options_tray->addElement($smiley_checkbox);
            }

            if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_DOXCODE)) {
                $xcodes_checkbox = new XoopsFormCheckBox('', 'doxcode', $obj->doxcode());
                $xcodes_checkbox->addOption(1, _CO_PUBLISHER_DOXCODE);
                $options_tray->addElement($xcodes_checkbox);
            }

            if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_DOIMAGE)) {
                $images_checkbox = new XoopsFormCheckBox('', 'doimage', $obj->doimage());
                $images_checkbox->addOption(1, _CO_PUBLISHER_DOIMAGE);
                $options_tray->addElement($images_checkbox);
            }

            if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_DOLINEBREAK)) {
                $linebreak_checkbox = new XoopsFormCheckBox('', 'dolinebreak', $obj->dobr());
                $linebreak_checkbox->addOption(1, _CO_PUBLISHER_DOLINEBREAK);
                $options_tray->addElement($linebreak_checkbox);
            }

            $this->addElement($options_tray);

        }
        
        // Available pages to wrap
        if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_AVAILABLE_PAGE_WRAP)) {
            $wrap_pages = XoopsLists::getHtmlListAsArray(publisher_getUploadDir(true, 'content'));
            $available_wrap_pages_text = array();
            foreach ($wrap_pages as $page) {
                $available_wrap_pages_text[] = "<span onclick='publisherPageWrap(\"body\", \"[pagewrap=$page] \");' onmouseover='style.cursor=\"pointer\"'>$page</span>";
            }
            $available_wrap_pages = new XoopsFormLabel(_CO_PUBLISHER_AVAILABLE_PAGE_WRAP, implode(', ', $available_wrap_pages_text));
            $available_wrap_pages->setDescription(_CO_PUBLISHER_AVAILABLE_PAGE_WRAP_DSC);
            $this->addElement($available_wrap_pages);
        }
        
        // Uid
        /*  We need to retreive the users manually because for some reason, on the frxoops.org server,
            the method users::getobjects encounters a memory error
        */
        // Trabis : well, maybe is because you are getting 6000 objects into memory , no??? LOL
        if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_UID)) {
            $uid_select = new XoopsFormSelect(_CO_PUBLISHER_UID, 'uid', $obj->uid(), 1, false);
            $uid_select->setDescription(_CO_PUBLISHER_UID_DSC);
            $sql = "SELECT uid, uname FROM " . $obj->db->prefix('users') . " ORDER BY uname ASC";
            $result = $obj->db->query($sql);
            $users_array = array();
            $users_array[0] = $xoopsConfig['anonymous'];
            while ($myrow = $obj->db->fetchArray($result)) {
                $users_array[$myrow['uid']] = $myrow['uname'];
            }
            $uid_select->addOptionArray($users_array);
            $this->addElement($uid_select);
        }

        // Author ALias
        if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_AUTHOR_ALIAS)) {
            $element = new XoopsFormText(_CO_PUBLISHER_AUTHOR_ALIAS, 'author_alias', 50, 255, $obj->getVar('author_alias','e'));
            $element->setDescription(_CO_PUBLISHER_AUTHOR_ALIAS_DSC);
            $this->addElement($element);
            unset($element);
        }

        // STATUS
        if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_STATUS)) {
	       $options = array(_PUBLISHER_STATUS_PUBLISHED => _CO_PUBLISHER_PUBLISHED,
                            _PUBLISHER_STATUS_OFFLINE   => _CO_PUBLISHER_OFFLINE,
                            _PUBLISHER_STATUS_SUBMITTED =>_CO_PUBLISHER_SUBMITTED,
                            _PUBLISHER_STATUS_REJECTED  =>_CO_PUBLISHER_REJECTED);
	       $status_select = new XoopsFormSelect(_CO_PUBLISHER_STATUS, 'status', $obj->getVar('status'));
	       $status_select->addOptionArray($options);
	       $status_select->setDescription(_CO_PUBLISHER_STATUS_DSC);
	       $this->addElement($status_select);
        }
        
        // Datesub
        if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_DATESUB)) {
	       $datesub = ($obj->getVar('datesub') == 0) ? time() : $obj->getVar('datesub');
	       $datesub_datetime = new PublisherFormDateTime(_CO_PUBLISHER_DATESUB, 'datesub', $size = 15, $datesub);
	       $datesub_datetime->setDescription(_CO_PUBLISHER_DATESUB_DSC);
	       $this->addElement($datesub_datetime);
        }
        
        // NOTIFY ON PUBLISH
        if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_NOTIFY)) {
            $notify_checkbox = new XoopsFormCheckBox('', 'notify', $obj->notifypub());
            $notify_checkbox->addOption(1, _CO_PUBLISHER_NOTIFY);
	        $this->addElement($notify_checkbox);
        }

        $this->startTab(_CO_PUBLISHER_TAB_IMAGES);
        // IMAGE
        if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_IMAGE_ITEM)) {
            //$image_array = & XoopsLists::getImgListAsArray(publisher_getImageDir('item'));

            $objimages = $obj->getImages();
            $mainarray = is_object($objimages['main']) ? array($objimages['main']) : array();
            $mergedimages = array_merge($mainarray, $objimages['others']);
            $objimage_array = array();
            foreach ($mergedimages as $imageObj) {
                $objimage_array[$imageObj->getVar('image_name')] = $imageObj->getVar('image_nicename');
            }

            $imgcat_handler =& xoops_gethandler('imagecategory');
            $catlist =& $imgcat_handler->getList($group, 'imgcat_read', 1);
            $catids = array_keys($catlist);

            $image_handler = xoops_gethandler('image');
            $criteria = new CriteriaCompo(new Criteria('imgcat_id', '(' . implode(',', $catids) . ')', 'IN'));
            $criteria->add(new Criteria('image_display', 1));
            $imageObjs = $image_handler->getObjects($criteria, true);
            unset($criteria);
            $image_array = array();
            foreach ($imageObjs as $id => $imageObj) {
                $image_array[$imageObj->getVar('image_name')] = $imageObj->getVar('image_nicename');
            }

            $image_array = array_diff($image_array, $objimage_array);

            $image_select = new XoopsFormSelect('', 'image_notused', '', 5);
            $image_select->addOptionArray($image_array);
            $image_select->setExtra( "onchange='showImgSelected(\"image_display\", \"image_notused\", \"uploads/\", \"\", \"" . XOOPS_URL . "\")'");
            //$image_select->setExtra( "onchange='appendMySelectOption(\"image_notused\", \"image_item\")'");
            unset($image_array);

            $image_select2 = new XoopsFormSelect('', 'image_item', '', 5, true);
            $image_select2->addOptionArray($objimage_array);
            $image_select2->setExtra( "onchange='publisher_updateSelectOption(\"image_item\", \"image_featured\"), showImgSelected(\"image_display\", \"image_item\", \"uploads/\", \"\", \"" . XOOPS_URL . "\")'");

            $buttonadd = new XoopsFormButton('', 'buttonadd', _CO_PUBLISHER_ADD);
            $buttonadd->setExtra( "onclick='publisher_appendSelectOption(\"image_notused\", \"image_item\"), publisher_updateSelectOption(\"image_item\", \"image_featured\")'");

            $buttonremove = new XoopsFormButton('', 'buttonremove', _CO_PUBLISHER_REMOVE);
            $buttonremove->setExtra( "onclick='publisher_appendSelectOption(\"image_item\", \"image_notused\"), publisher_updateSelectOption(\"image_item\", \"image_featured\")'");

            $opentable = new XoopsFormLabel('', "<table><tr><td>" );
            $addcol = new XoopsFormLabel('', "</td><td>" );
            $addbreak = new XoopsFormLabel('', "<br />" );
            $closetable = new XoopsFormLabel('', "</td></tr></table>");
            
            $js_data = new XoopsFormLabel('', '
<script type= "text/javascript">/*<![CDATA[*/
$publisher(document).ready(function(){

	/* example 1 */
	var button = $publisher("#publisher_upload_button"), interval;
	new AjaxUpload(button,{
		action: "' . PUBLISHER_URL . '/include/ajax_upload.php", // I disabled uploads in this example for security reasons
		responseType: "text/html",
		name: "publisher_upload_file",
		onSubmit : function(file, ext){
			// change button text, when user selects file
            $publisher("#publisher_upload_message").html(" ");
            button.html("<img src=\'' . PUBLISHER_URL . '/images/loadingbar.gif\'/>"); this.setData({
					"image_nicename": $publisher("#image_nicename").val(),
					"imgcat_id" : $publisher("#imgcat_id").val()
				});

			// If you want to allow uploading only 1 file at time,
			// you can disable upload button
			this.disable();

			interval = window.setInterval(function(){

			}, 200);
		},
		onComplete: function(file, response){
			button.text("' . _CO_PUBLISHER_IMAGE_UPLOAD_NEW . '");

			window.clearInterval(interval);

			// enable upload button
			this.enable();

			// add file to the list
			var result = eval(response);
            if (result[0] == "success") {
                 $publisher("#image_item").append("<option value=\'" + result[1] + "\' selected=\'selected\'>" + result[2] + "</option>");
                 publisher_updateSelectOption(\'image_item\', \'image_featured\');
                 showImgSelected(\'image_display\', \'image_item\', \'uploads/\', \'\', \'' . XOOPS_URL . '\')
            } else {
                 $publisher("#publisher_upload_message").html("<div class=\'errorMsg\'>" + result[1] + "</div>");
            }

		}
	});

});/*]]>*/</script>
');
            $messages = new XoopsFormLabel('', "<div id='publisher_upload_message'></div>");
            $button   = new XoopsFormLabel('', "<div id='publisher_upload_button' style='text-decoration: underline; font-weight: bold;'>" . _CO_PUBLISHER_IMAGE_UPLOAD_NEW . "</div>");
            $nicename = new XoopsFormText('', 'image_nicename', 30, 30, _CO_PUBLISHER_IMAGE_NICENAME);

            $imgcat_handler =& xoops_gethandler('imagecategory');
            $catlist =& $imgcat_handler->getList($group, 'imgcat_write', 1);
            $imagecat = new XoopsFormSelect('', 'imgcat_id', '', 1);
            $imagecat->addOptionArray($catlist);

            $image_upload_tray = new XoopsFormElementTray(_CO_PUBLISHER_IMAGE_UPLOAD, '');
            $image_upload_tray->addElement($js_data);
            $image_upload_tray->addElement($messages);
            $image_upload_tray->addElement($opentable);
            
            $image_upload_tray->addElement($imagecat);

            $image_upload_tray->addElement($addbreak);

            $image_upload_tray->addElement($nicename);

            $image_upload_tray->addElement($addbreak);
            
            $image_upload_tray->addElement($button);
            
            $image_upload_tray->addElement($closetable);
            $this->addElement($image_upload_tray);
            

            $image_tray = new XoopsFormElementTray( _CO_PUBLISHER_IMAGE_ITEMS, '');
            $image_tray->addElement($opentable);

            $image_tray->addElement($image_select);
            $image_tray->addElement($addbreak);
            $image_tray->addElement($buttonadd);

            $image_tray->addElement($addcol);

            $image_tray->addElement($image_select2);
            $image_tray->addElement($addbreak);
            $image_tray->addElement($buttonremove);

            $image_tray->addElement($closetable);
            $image_tray->setDescription(_CO_PUBLISHER_IMAGE_ITEMS_DSC);
            $this->addElement($image_tray);

            $imagename = is_object($objimages['main']) ? $objimages['main']->getVar('image_name') : '';
            $imageforpath = ($imagename != '') ? $imagename : 'blank.gif';

            $image_select3 = new XoopsFormSelect(_CO_PUBLISHER_IMAGE_ITEM, 'image_featured', $imagename, 1);
            $image_select3->addOptionArray($objimage_array);
            $image_select3->setExtra( "onchange='showImgSelected(\"image_display\", \"image_featured\", \"uploads/\", \"\", \"" . XOOPS_URL . "\")'");
            $image_select3->setDescription(_CO_PUBLISHER_IMAGE_ITEM_DSC);
            $this->addElement($image_select3);

            $image_preview = new XoopsFormLabel(_CO_PUBLISHER_IMAGE_PREVIEW, "<img src='" . XOOPS_URL . "/uploads/" . $imageforpath. "' name='image_display' id='image_display' alt='' />" );
            $this->addElement($image_preview);
        }

        $this->startTab(_CO_PUBLISHER_TAB_OTHERS);
        //$this->startTab(_CO_PUBLISHER_TAB_META);
        // Meta Keywords
        if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_ITEM_META_KEYWORDS)) {
            $text_meta_keywords = new XoopsFormTextArea(_CO_PUBLISHER_ITEM_META_KEYWORDS, 'item_meta_keywords', $obj->meta_keywords('e'), 7, 60);
            $text_meta_keywords->setDescription(_CO_PUBLISHER_ITEM_META_KEYWORDS_DSC);
            $this->addElement($text_meta_keywords);
        }

        // Meta Description
        if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_ITEM_META_DESCRIPTION)) {
            $text_meta_description = new XoopsFormTextArea(_CO_PUBLISHER_ITEM_META_DESCRIPTION, 'item_meta_description', $obj->meta_description('e'), 7, 60);
            $text_meta_description->setDescription(_CO_PUBLISHER_ITEM_META_DESCRIPTION_DSC);
            $this->addElement($text_meta_description);
        }

        //$this->startTab(_CO_PUBLISHER_TAB_PERMISSIONS);

        // COMMENTS
        if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_ALLOWCOMMENTS)) {
            $addcomments_radio = new XoopsFormRadioYN(_CO_PUBLISHER_ALLOWCOMMENTS, 'allowcomments', $obj->cancomment(), _YES , _NO);
            $this->addElement($addcomments_radio);
        }

        // PER ITEM PERMISSIONS
        if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_PERMISSIONS_ITEM)) {
	        $member_handler = &xoops_gethandler('member');
	        $group_list = $member_handler->getGroupList();
	        $groups_checkbox = new XoopsFormCheckBox(_CO_PUBLISHER_PERMISSIONS_ITEM, 'permissions_item[]', $obj->getGroups_read());
	        $groups_checkbox->setDescription(_CO_PUBLISHER_PERMISSIONS_ITEM_DSC);
	        foreach ($group_list as $group_id => $group_name) {
                //if ($group_id != XOOPS_GROUP_ADMIN) {
                    $groups_checkbox->addOption($group_id, $group_name);
                //}
            }
            $this->addElement($groups_checkbox);
        }

        // partial_view
        if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_PARTIAL_VIEW)) {
            $p_view_checkbox = new XoopsFormCheckBox(_CO_PUBLISHER_PARTIAL_VIEW, 'partial_view[]', $obj->partial_view());
            $p_view_checkbox->setDescription(_CO_PUBLISHER_PARTIAL_VIEW_DSC);
            foreach ($group_list as $group_id => $group_name) {
                if ($group_id != XOOPS_GROUP_ADMIN) {
                    $p_view_checkbox->addOption($group_id, $group_name);
                }
            }
            $this->addElement($p_view_checkbox);
        }

        // File upload UPLOAD
        if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_ITEM_UPLOAD_FILE)) {
	       $file_box = new XoopsFormFile(publisher_newFeatureTag() . _CO_PUBLISHER_ITEM_UPLOAD_FILE, "item_upload_file", 0);
    	   $file_box->setDescription(_CO_PUBLISHER_ITEM_UPLOAD_FILE_DSC . publisher_newFeatureTag());
	       $file_box->setExtra("size ='50'");
	       $this->addElement($file_box);
	       unset($file_box);
        }

        // WEIGHT
        if (!$checkperm || $publisher->getHandler('permission')->isGranted('form_view', _PUBLISHER_WEIGHT)) {
	       $this->addElement(new XoopsFormText(_CO_PUBLISHER_WEIGHT, 'weight', 5, 5, $obj->weight()));
        }

        $this->endTabs();

        //COMMON TO ALL TABS

        $button_tray = new XoopsFormElementTray('', '');

        if (!$obj->isNew()) {
	       $button_tray->addElement(new XoopsFormButton('', 'additem', _CO_PUBLISHER_EDIT, 'submit')); //orclone

        } else {
	        $button_tray->addElement(new XoopsFormButton('', 'additem', _CO_PUBLISHER_CREATE, 'submit'));
            $button_tray->addElement(new XoopsFormButton('', '', _CO_PUBLISHER_CLEAR, 'reset'));
        }

        $button_tray->addElement(new XoopsFormButton('', 'preview', _CO_PUBLISHER_PREVIEW, 'submit'));

		$butt_cancel = new XoopsFormButton('', '', _CO_PUBLISHER_CANCEL, 'button');
		$butt_cancel->setExtra('onclick="history.go(-1)"');
		$button_tray->addElement($butt_cancel);

        $this->addElement($button_tray);

        $hidden = new XoopsFormHidden('itemid', $obj->itemid());
        $this->addElement($hidden);
        unset($hidden);
        return $this;
    }
}