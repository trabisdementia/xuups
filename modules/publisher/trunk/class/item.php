<?php

/**
* $Id: item.php 1428 2008-04-05 01:59:04Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) {
die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH.'/modules/publisher/include/common.php';

// ITEM status
define("_PUB_STATUS_NOTSET", -1);
define("_PUB_STATUS_ALL", 0);
define("_PUB_STATUS_SUBMITTED", 1);
define("_PUB_STATUS_PUBLISHED", 2);
define("_PUB_STATUS_OFFLINE", 3);
define("_PUB_STATUS_REJECTED", 4);

// Notification Events
define("_PUB_NOT_CATEGORY_CREATED", 1);
define("_PUB_NOT_ITEM_SUBMITTED", 2);
define("_PUB_NOT_ITEM_PUBLISHED", 3);
define("_PUB_NOT_ITEM_REJECTED", 4);

class PublisherItem extends XoopsObject
{

    /**
     * @var PublisherCategory
	 * @access private
     */
    var $_category = null;

	/**
     * @var array
	 * @access private
     */
    var $_groups_read = null;

	/**
	* constructor
	*/
	function PublisherItem($id = null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("itemid", XOBJ_DTYPE_INT, -1, false);
		$this->initVar("categoryid", XOBJ_DTYPE_INT, 0, false);
		$this->initVar("title", XOBJ_DTYPE_TXTBOX, null, true, 255);
		$this->initVar("summary", XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar("display_summary", XOBJ_DTYPE_INT, 1, false);
		$this->initVar("body", XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar("uid", XOBJ_DTYPE_INT, 0, false);
		$this->initVar("datesub", XOBJ_DTYPE_INT, null, false);
		$this->initVar("status", XOBJ_DTYPE_INT, -1, false);
		$this->initVar("image", XOBJ_DTYPE_TXTBOX, 'blank.png', false, 255);
		$this->initVar("counter", XOBJ_DTYPE_INT, 0, false);
		$this->initVar("weight", XOBJ_DTYPE_INT, 0, false);
		$this->initVar("partial_view", XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("dohtml", XOBJ_DTYPE_INT, 1, true);
		$this->initVar("dosmiley", XOBJ_DTYPE_INT, 1, true);
		$this->initVar("doimage", XOBJ_DTYPE_INT, 1, true);
		$this->initVar("dobr", XOBJ_DTYPE_INT, 1, false);
		$this->initVar("doxcode", XOBJ_DTYPE_INT, 1, true);
		$this->initVar("cancomment", XOBJ_DTYPE_INT, 1, true);
		$this->initVar("comments", XOBJ_DTYPE_INT, 0, false);
		$this->initVar("notifypub", XOBJ_DTYPE_INT, 1, false);
		$this->initVar("meta_keywords", XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar("meta_description", XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar("short_url", XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar("item_tag", XOBJ_DTYPE_TXTAREA, null, false);

		// Non consistent values
		$this->initVar("pagescount", XOBJ_DTYPE_INT, 0, false);

		if (isset($id)) {
			$publisher_item_handler =& publisher_gethandler('item');
			$item =& $publisher_item_handler->get($id);
			foreach ($item->vars as $k => $v) {
				$this->assignVar($k, $v['value']);
			}
			$this->assignOtherProperties();
		} else {
			// it's a new item
			// Check to see if $smartlanguage_tag_handler is available

			// Hack by marcan for condolegal.smartfactory.ca
		/*	$this->setVar('title', "[fr]entrez le texte en français[/fr][en]entrez le texte en anglais[/en]");
			$this->setVar('summary', "[fr]entrez le texte en français[/fr][en]entrez le texte en anglais[/en]");
			$this->setVar('body', "[fr]entrez le texte en français[/fr][en]entrez le texte en anglais[/en]");
			// End of Hack by marcan for condolegal.smartfactory.ca

			global $smartlanguage_tag_handler;
			if (isset($smartlanguage_tag_handler)) {
				$theLanguageTags = $smartlanguage_tag_handler->getAllTagsForInput();
				$this->setVar('title', $theLanguageTags);
				$this->setVar('summary', $theLanguageTags);
				$this->setVar('body', $theLanguageTags);
			}
			*/
		}
	}

	function assignOtherProperties()
	{
    	$publisher_allCategoriesObj = publisher_getAllCategoriesObj();

		$this->_category = $publisher_allCategoriesObj[$this->getVar('categoryid')];

		global $publisher_permission_handler;
		if (!$publisher_permission_handler) {
			$publisher_permission_handler = xoops_getmodulehandler('permission', 'publisher')	;
		}
		$this->_groups_read = $publisher_permission_handler->getGrantedGroups('item_read', $this->itemid());

	}

	function checkPermission()
	{
		include_once XOOPS_ROOT_PATH.'/modules/publisher/include/functions.php';

		$ret = false;

		$userIsAdmin = publisher_userIsAdmin();
		if ($userIsAdmin) {
			return true;
		}

		$publisherPermHandler =& xoops_getmodulehandler('permission', 'publisher');

		$itemsGranted = $publisherPermHandler->getGrantedItems('item_read');

		if ( in_array($this->itemid(), $itemsGranted) ) {
			$ret = true;
		}

		return $ret;
	}

	function getGroups_read()
	{
	    if (count($this->_groups_read) < 1) {
		    $this->assignOtherProperties();
		}
		return $this->_groups_read;
	}

	function setGroups_read($groups_read = array('0'))
	{
	  $this->_groups_read = $groups_read;
	}

	function itemid()
	{
		return $this->getVar("itemid");
	}

	function categoryid()
	{
		return $this->getVar("categoryid");
	}

	function category()
	{
		return $this->_category;
	}

	function title($maxLength=0, $format="S")
    {
		$ret = $this->getVar("title", $format);
    	if (($format=='s') || ($format=='S') || ($format=='show')) {
			$myts = &MyTextSanitizer::getInstance();
			$ret = $myts->displayTarea($ret);
		}

    	if ($maxLength != 0) {
        	if (!XOOPS_USE_MULTIBYTES) {
                if (strlen($ret) >= $maxLength) {
                    $ret = publisher_substr($ret , 0, $maxLength);
                }
            }
        }

    	return $ret;
    }

	function summary($maxLength=0, $format="S")
    {
    	$ret = $this->getVar("summary", $format);
    	if ($maxLength != 0) {
        	if (!XOOPS_USE_MULTIBYTES) {
                if (strlen($ret) >= $maxLength) {
                    $ret = publisher_substr($ret , 0, $maxLength);
                }
            }
        }

        return $ret;
    }

    function display_summary()
	{
		return $this->getVar("display_summary");
	}



	function wrappage($file_name)
	{
		$page = publisher_getUploadDir(true, 'content') . $file_name;
		if (file_exists($page)){
			// this page uses smarty template
			ob_start();
			include($page);
			$content = ob_get_contents();
			ob_end_clean();

			// Cleaning the content
			$body_start_pos = strpos($content, '<body>');
	    	if ($body_start_pos) {
	    		$body_end_pos = strpos($content, '</body>', $body_start_pos);
	    		$content = substr($content, $body_start_pos + strlen('<body>'), $body_end_pos - strlen('<body>') - $body_start_pos);
	    	}

			// Check if ML Hack is installed, and if yes, parse the $content in formatForML
			$myts = MyTextSanitizer::getInstance();
			if (method_exists($myts, 'formatForML')) {
				$content = $myts->formatForML($content);
			}
			return $content;
		}

	}

    /*
     * This method returns the body to be displayed. Not to be used for editing
     */
	function body($maxLength=0, $format="S")
    {
    	$ret = $this->getVar("body", $format);

    	$wrap_pos = strpos($ret, '[pagewrap=');
    	if (!($wrap_pos === false)) {
    		$wrap_pages = array();
    		$wrap_code_length = strlen("[pagewrap=");

	    	while (!($wrap_pos === false)) {
				$end_wrap_pos = strpos($ret, ']', $wrap_pos);
				if ($end_wrap_pos) {
    				$wrap_page_name = substr($ret, $wrap_pos + $wrap_code_length, $end_wrap_pos - $wrap_code_length - $wrap_pos);
					$wrap_pages[] = $wrap_page_name;
	    		}
	    		$wrap_pos = strpos($ret, '[pagewrap=', $end_wrap_pos -1);
	    	}

	    	foreach($wrap_pages as $page) {
	    		$wrap_page_content = $this->wrappage($page);
	    		$ret = str_replace("[pagewrap=$page]", $wrap_page_content, $ret);
	    	}
    	}
/*
    	$flash_found_pos = strpos($ret, '[flash-');
    	while ($flash_found_pos) {
    		$end_of_tag = (strpos($ret, ']', strpos($ret, '[flash-')));
    		$id_length = $end_of_tag - $flash_found_pos - 7;
    		$file_id = substr($ret, $flash_found_pos + 7, $id_length);
    		$flash_found_pos = false;
    	}
*/

        if ($maxLength != 0) {
        	if (!XOOPS_USE_MULTIBYTES) {
                if (strlen($ret) >= $maxLength) {
                    $ret = publisher_substr($ret , 0, $maxLength);
                }
            }
        }

        return $ret;
    }

    function uid()
	{
		return $this->getVar("uid");
	}

	function datesub($dateFormat='s', $format="S")
	{
		global $xoopsConfig;
		return formatTimestamp($this->getVar('datesub', $format), $dateFormat);
	}

	function status()
	{
		return $this->getVar("status");
	}

	function image($format="S")
	{
		if ($this->getVar('image') != '') {
		 	return $this->getVar('image', $format);
		} else {
			return 'blank.png';
		}
	}

	function counter()
	{
		return $this->getVar("counter");
	}

	function weight()
	{
		return $this->getVar("weight");
	}

	function dohtml()
	{
		return $this->getVar("dohtml");
	}

	function dosmiley()
	{
		return $this->getVar("dosmiley");
	}

	function doxcode()
	{
		return $this->getVar("doxcode");
	}

	function doimage()
	{
		return $this->getVar("doimage");
	}
	function dobr()
	{
		return $this->getVar("dobr");
	}

	function cancomment()
	{
		return $this->getVar("cancomment");
	}

	function comments()
	{
		return $this->getVar("comments");
	}

	function notifypub()
	{
		return $this->getVar("notifypub");
	}

	function meta_keywords($format="S")
	{
		return $this->getVar("meta_keywords", $format );
	}

	function meta_description($format="S")
	{
		return $this->getVar("meta_description", $format );
	}

	function short_url($format="S")
	{
		return $this->getVar("short_url", $format );
	}

	function pagescount()
	{
		return $this->getVar("pagescount");
	}

	function posterName($realName = -1)
	{
		if ($realName == -1) {
			global $xoopsModuleConfig;
			$smartConfig =& publisher_getModuleConfig();
			$realName = $smartConfig['userealname'];
		}
		return publisher_getLinkedUnameFromId($this->uid(), $realName);
	}

	function updateCounter()
	{
		global $publisher_item_handler;
		return $publisher_item_handler->updateCounter($this->itemid());
	}

	function store($force = true)
	{
		global $publisher_item_handler;

		$isNew = $this->isNew();

		if ( !$publisher_item_handler->insert($this, $force)) {
			return false;
		}

		if ($isNew && $this->status() == _PUB_STATUS_PUBLISHED) {
			// Increment user posts
			$user_handler = xoops_gethandler('user');
			$member_handler = xoops_gethandler('member');
			$poster = $user_handler->get($this->uid());
			if (is_object($poster)) {
				$poster->setVar('posts',$poster->getVar('posts') + 1);
	    		if (!$member_handler->insertUser($poster, true)) {
	    			$this->setErrors('Article created but could not increment user posts.');
	    			return false;
	    		}
			}
		}

		return true;
	}

	function getCategoryName()
	{
		global $publisher_category_handler;
		if (!isset ($this->_category)) {
			$this->_category = $publisher_category_handler->get($this->getVar('categoryid'));
		}
		return $this->_category->name();
	}

	function getCategoryUrl()
	{
		if (!isset ($this->_category)) {
			global $publisher_category_handler;
			$this->_category = $publisher_category_handler->get($this->getVar('categoryid'));
		}
		return $this->_category->getCategoryUrl();
	}

	function getCategoryLink()
	{
		if (!isset ($this->_category)) {
			global $publisher_category_handler;
			$this->_category = $publisher_category_handler->get($this->getVar('categoryid'));
		}
		return $this->_category->getCategoryLink();
	}

	function getCategoryPath($withAllLink=true)
	{
		global $publisher_category_handler;
		if (!isset ($this->_category)) {
			$this->_category = $publisher_category_handler->get($this->getVar('categoryid'));
		}
		return $this->_category->getCategoryPath($withAllLink);
	}

	function getFiles()
	{
		global $publisher_file_handler;
		return $publisher_file_handler->getAllFiles($this->itemid(), _PUB_STATUS_FILE_ACTIVE);
	}

	function getAdminLinks()
	{
		// include language file
		global $xoopsConfig, $smartModule, $smartConfig, $xoopsUser;

		$filePath = XOOPS_ROOT_PATH."/modules/publisher/language/".$xoopsConfig['language']."/main.php";
		if (file_exists($filePath)) {
			include_once(XOOPS_ROOT_PATH."/modules/publisher/language/".$xoopsConfig['language']."/main.php");
		} else {
			include_once(XOOPS_ROOT_PATH."/modules/publisher/language/english/main.php");
		}

		$adminLinks = '';

		// Find if the user is admin of the module
		$isAdmin = publisher_userIsAdmin();

		$groups = ($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
		$gperm_handler = &xoops_gethandler('groupperm');
		$smartModule = publisher_getModuleInfo();
		$module_id = $smartModule->getVar('mid');

		$uploadLink = '';

		// Do we have access to the parent category
		if (is_object($xoopsUser) && ($isAdmin || ($xoopsUser->uid() == $this->uid()) || $gperm_handler->checkRight('item_submit', $this->categoryid(), $groups, $module_id))) {

			if (!$isAdmin) {
				if ($xoopsUser->uid() == $this->uid()) {
					// Edit button
					$adminLinks .= "<a href='" . PUBLISHER_URL . "submit.php?itemid=" . $this->itemid() . "'><img src='" . PUBLISHER_URL . "images/links/edit.gif'" . " title='" . _MD_PUB_EDIT . "' alt='" . _MD_PUB_EDIT . "'/></a>";
					$adminLinks .= " ";
				}
				if (PUBLISHER_LEVEL > 0) {
					if ($smartConfig['allowclone']) {
						// Dupplicate button
						$adminLinks .= "<a href='" . PUBLISHER_URL . "submit.php?op=clone&itemid=" . $this->itemid() . "'><img src='" . PUBLISHER_URL . "images/links/clone.gif'" . " title='" . _MD_PUB_CLONE . "' alt='" . _MD_PUB_CLONE . "'/></a>";
						$adminLinks .= " ";
					}


					// upload a file linked this article
					if ($smartConfig['allowupload']) {
						$uploadLink = "<a href='" . PUBLISHER_URL . "addfile.php?itemid=" . $this->itemid() . "'><img src='" . PUBLISHER_URL . "images/icon/file.gif' title='" . _MD_PUB_ADD_FILE . "' alt='" . _MD_PUB_ADD_FILE . "'/></a>";
					}
				}

			} else {
				// Edit button
				//$adminLinks .= "<a href='" . PUBLISHER_URL . "admin/item.php?op=mod&itemid=" . $this->itemid() . "'><img src='" . PUBLISHER_URL . "images/links/edit.gif'" . " title='" . _MD_PUB_EDIT . "' alt='" . _MD_PUB_EDIT . "'/></a>";
                //HACK BY TRABIS
                $adminLinks .= "<a href='" . PUBLISHER_URL . "submit.php?itemid=" . $this->itemid() . "'><img src='" . PUBLISHER_URL . "images/links/edit.gif'" . " title='" . _MD_PUB_EDIT . "' alt='" . _MD_PUB_EDIT . "'/></a>";

                $adminLinks .= " ";

				if (PUBLISHER_LEVEL > 0) {
					// Dupplicate button
					$adminLinks .= "<a href='" . PUBLISHER_URL . "admin/item.php?op=clone&itemid=" . $this->itemid() . "'><img src='" . PUBLISHER_URL . "images/links/clone.gif'" . " title='" . _MD_PUB_CLONE . "' alt='" . _MD_PUB_CLONE . "'/></a>";
					$adminLinks .= " ";
				}

				// Delete button
				$adminLinks .= "<a href='" . PUBLISHER_URL . "admin/item.php?op=del&itemid=" . $this->itemid() . "'><img src='" . PUBLISHER_URL . "images/links/delete.gif'" . " title='" . _MD_PUB_DELETE . "' alt='" . _MD_PUB_DELETE . "'/></a>";
				$adminLinks .= " ";

				if (PUBLISHER_LEVEL > 0) {
					// upload a file linked this article
					$uploadLink = "<a href='" . PUBLISHER_URL . "addfile.php?itemid=" . $this->itemid() . "'><img src='" . PUBLISHER_URL . "images/icon/file.gif' title='" . _MD_PUB_ADD_FILE . "' alt='" . _MD_PUB_ADD_FILE . "'/></a>";
				}
			}
		}
		if (PUBLISHER_LEVEL > 0) {
			// PDF button
			$adminLinks .= "<a href='" . PUBLISHER_URL . "makepdf.php?itemid=" . $this->itemid() . "'><img src='" . PUBLISHER_URL . "images/links/pdf.gif' title='" . _MD_PUB_PDF . "' alt='" . _MD_PUB_PDF . "'/></a>";
			$adminLinks .= " ";
		}

		// Print button
		$adminLinks .= '<a href="' . publisher_seo_genUrl("print", $this->itemid(), $this->short_url()) . '"><img src="' . PUBLISHER_URL . 'images/links/print.gif" title="' . _MD_PUB_PRINT . '" alt="' . _MD_PUB_PRINT . '"/></a>';
		$adminLinks .= " ";

		// Email button
		$maillink = "mailto:?subject=" . sprintf(_MD_PUB_INTITEM, $xoopsConfig['sitename']) . "&amp;body=" . sprintf(_MD_PUB_INTITEMFOUND, $xoopsConfig['sitename']) . ": " . $this->getItemUrl();
		$adminLinks .= '<a href="' . $maillink . '"><img src="' . PUBLISHER_URL . 'images/links/friend.gif" title="' . _MD_PUB_MAIL . '" alt="' . _MD_PUB_MAIL . '"/></a>';
		$adminLinks .= " ";

		if (PUBLISHER_LEVEL > 0) {
			// upload a file linked this article
			// Add a file button
			$adminLinks .= $uploadLink;
			$adminLinks .= " ";
		}

		return $adminLinks;
	}

	function sendNotifications($notifications=array())
	{

		global $publisher_moduleName;

		$hModule =& xoops_gethandler('module');
    	$smartModule =& $hModule->getByDirname('publisher');
    	$module_id = $smartModule->getVar('mid');

		$notification_handler = &xoops_gethandler('notification');
		$categoryObj = $this->category();

		$tags = array();
		$tags['MODULE_NAME'] = $publisher_moduleName;
		$tags['ITEM_NAME'] = $this->title();
		$tags['CATEGORY_NAME'] = $this->getCategoryName();
		$tags['CATEGORY_URL'] = XOOPS_URL . '/modules/' . $smartModule->getVar('dirname') . '/category.php?categoryid=' . $this->categoryid();
		$tags['ITEM_BODY'] = $this->body();

		$tags['DATESUB'] = $this->datesub();
		foreach ( $notifications as $notification ) {
			switch ($notification) {
				case _PUB_NOT_ITEM_PUBLISHED :
				$tags['ITEM_URL'] = XOOPS_URL . '/modules/' . $smartModule->getVar('dirname') . '/item.php?itemid=' . $this->itemid();

				$notification_handler->triggerEvent('global_item', 0, 'published', $tags, array(), $smartModule->getVar('mid'));
				$notification_handler->triggerEvent('category_item', $this->categoryid(), 'published', $tags, array(), $smartModule->getVar('mid'));
				$notification_handler->triggerEvent('item', $this->itemid(), 'approved', $tags, array(), $smartModule->getVar('mid'));
				break;

				case _PUB_NOT_ITEM_SUBMITTED :
				$tags['WAITINGFILES_URL'] = XOOPS_URL . '/modules/' . $smartModule->getVar('dirname') . '/admin/item.php?itemid=' . $this->itemid();
				$notification_handler->triggerEvent('global_item', 0, 'submitted', $tags, array(), $smartModule->getVar('mid'));
				$notification_handler->triggerEvent('category_item',  $this->categoryid(), 'submitted', $tags, array(), $smartModule->getVar('mid'));
				break;

				case _PUB_NOT_ITEM_REJECTED :
				$notification_handler->triggerEvent('item', $this->itemid(), 'rejected', $tags, array(), $smartModule->getVar('mid'));
				break;

				case -1 :
				default:
				break;
			}
		}
	}

	function setDefaultPermissions()
	{
			$member_handler = &xoops_gethandler('member');
			$groups = $member_handler->getGroupList();

			$j = 0;
			$group_ids = array();
			foreach (array_keys($groups) as $i) {
				$group_ids[$j] = $i;
				$j++;
			}
		$this->_groups_read = $group_ids;
	}

	function setPermissions($group_ids)
	{
		if (!isset($group_ids)) {
			$member_handler = &xoops_gethandler('member');
			$groups = &$member_handler->getGroupList();

			$j = 0;
			$group_ids = array();
			foreach (array_keys($groups) as $i) {
				$group_ids[$j] = $i;
				$j++;
			}
		}
	}

	function notLoaded()
	{
	   return ($this->getVar('itemid')== -1);
	}

	function partial_view()
	{
	   return (explode(';', $this->getVar('partial_view')));
	}

	function setPartial_view($groups_array)
	{
		if ($groups_array) {
			$this->setVar('partial_view', implode(';',$groups_array));
		} else {
			$this->setVar('partial_view', 0);
		}
	}

	function showPartial_view()
	{
		global $xoopsUser;
		//if no groups are setted to see p_view, get out of here
		if(!$this->partial_view()){
			return false;
		}
		//get groups of current user
		elseif(is_object($xoopsUser)){
			$u_groups = $xoopsUser->getGroups()	;
		}
		//anonymous if it is not a user
		else{
			$u_groups = array( 0 => 3);
		}
		//get groups setted for p_view
		$pv_groups = $this->partial_view();
		//get groups to wich belong user that are not setted for p_view
		$gr_with_no_pview = array_diff ( $u_groups, $pv_groups);

		if(!empty($gr_with_no_pview)){
			//determine if these groups can view the full article
			$gperm_handler = &xoops_gethandler('groupperm');
			$hModule = &xoops_gethandler('module');
			$smartModule = &$hModule->getByDirname('publisher');
			$module_id = $smartModule->getVar('mid');

			$allowed = $gperm_handler->checkRight('item_read', $this->itemid(), $gr_with_no_pview, $module_id);
		}

		//return false if user belong to at least 1 group wich has full view
		return (empty($gr_with_no_pview) || !$allowed);
	}


	function getItemUrl()
	{
		return publisher_seo_genUrl('item', $this->itemid(), $this->short_url());
	}

	function getItemLink($class=false, $maxsize=0)
	{
		if ($class) {
			return '<a class=' . $class . ' href="' . $this->getItemUrl() . '">' . $this->title($maxsize) . '</a>';
		} else {
			return '<a href="' . $this->getItemUrl() . '">' . $this->title($maxsize) . '</a>';
		}
	}

	function getWhoAndWhen($users = array())
	{
	    $smartModuleConfig =& publisher_getModuleConfig();

		$posterName = publisher_getLinkedUnameFromId($this->uid(), $smartModuleConfig['userealname'], $users);
		$postdate = $this->datesub();
		return sprintf(_MD_PUB_POSTEDBY, $posterName, $postdate);
	}

	function plain_maintext($body=null)
	{
	  	$ret = '';
	  	if (!$body) {
	  		$body = $this->body();
	  	}
	  	if ($this->display_summary() && ($this->summary())) {
			$ret .= $this->summary();
		  	if (($body)) {
			  	$ret .= "<br /><br />";
			  }
		}
		$ret .= str_replace('[pagebreak]', '<br /><br />', $body);
		return $ret;
	}

	function buildmaintext($item_page_id = -1, $body=null)
	{
		if (!$body) {
			$body = $this->body();
		}
		$body_parts = explode('[pagebreak]', $body);
		$this->setVar('pagescount', count($body_parts));
		if (count($body_parts) <= 1) {
			return $this->plain_maintext($body);
		}

		$ret = '';

		if ($this->display_summary() && ($this->summary()) && ($item_page_id < 1)) {
			$ret .= $this->summary();
			$ret .= "<br /><br />";
		}

		if ($item_page_id == -1) {
			$ret .= trim($body_parts[0]);
			return $ret;
		}

		if ($item_page_id >= count($body_parts)) {
			$item_page_id = count($body_parts) - 1;
		}
		$ret .= trim($body_parts[$item_page_id]);
		return $ret;
	}

	function toArray($item_page_id = -1, $max_char_title=0)
	{
		global $xoopsModuleConfig,  $xoopsUser;

		$item = array();
		$item['id'] = $this->itemid();
		$item['categoryid'] = $this->categoryid();
		$item['categoryPath'] = $this->getCategoryPath(publisher_getConfig('linkedPath'));
		$item['categoryname'] = $this->getCategoryName();
		$item['title'] = $this->title();
		$item['clean_title'] = $this->title();
		$item['itemurl'] = $this->getItemUrl();
		$item['titlelink'] = $this->getItemLink(false, $max_char_title);
		$item['summary'] = $this->summary();
		$item['display_summary'] = $this->getVar('display_summary');


		$item['meta_keywords'] = $this->meta_keywords();
		$item['meta_description'] = $this->meta_description();
		$item['short_url'] = $this->short_url();

		if($this->showPartial_view()){
			$body = publisher_getConfig('partial_view_text');
		}
		else{
			$body = $this->body();
		}


		$item['body'] = $body;
		$item['maintext'] = $this->buildmaintext($item_page_id, $body);

		if ($this->image() != 'blank.png') {
			$item['image_path'] = publisher_getImageDir('item', false) . $this->image();
		} else {
			$item['image_path'] = '';
		}
		$item['posterName'] = $this->posterName();
		$item['itemid'] = $this->itemid();
		$item['counter'] = $this->counter();
		$item['cancomment'] = $this->cancomment();
		$item['comments'] = $this->comments();
		$item['datesub'] = $this->datesub();
		$item['adminlink'] = $this->getAdminLinks();


		// Hightlighting searched words
		$highlight = true;
		if($highlight && isset($_GET['keywords']))
		{
			$myts =& MyTextSanitizer::getInstance();
			$keywords=$myts->htmlSpecialChars(trim(urldecode($_GET['keywords'])));
			$h= new PublisherKeyhighlighter ($keywords, true , 'publisher_highlighter');
			$item['title'] = $h->highlight($item['title']);
			$item['summary'] = $h->highlight($item['summary']);
			$item['maintext'] = $h->highlight($item['maintext']);
		}
		return $item;
	}

	function createMetaTags() {

		$publisher_metagen = new PublisherMetagen($this->title(), $this->meta_keywords(), $this->meta_description(), $this->_category->_categoryPath);
		$publisher_metagen->createMetaTags();
	}

}

/**
* Items handler class.
* This class is responsible for providing data access mechanisms to the data source
* of Q&A class objects.
*
* @author marcan <marcan@notrevie.ca>
* @package Publisher
*/

class PublisherItemHandler extends XoopsObjectHandler
{

	function &create($isNew = true)
	{
		$item = new PublisherItem();
		if ($isNew) {
			$item->setDefaultPermissions();
			$item->setNew();
		}
		return $item;
	}

	/**
	* retrieve an item
	*
	* @param int $id itemid of the user
	* @return mixed reference to the {@link PublisherItem} object, FALSE if failed
	*/
	function &get($id)
	{
		if (intval($id) > 0) {
			$sql = 'SELECT * FROM '.$this->db->prefix('publisher_items').' WHERE itemid='.$id;

			if (!$result = $this->db->query($sql)) {
				return false;
			}

			$numrows = $this->db->getRowsNum($result);
			if ($numrows == 1) {
				$item = new PublisherItem();
				$item->assignVars($this->db->fetchArray($result));
				$item->assignOtherProperties();
				return $item;
			}
		}
		return false;
	}

	/**
	* insert a new item in the database
	*
	* @param object $item reference to the {@link PublisherItem} object
	* @param bool $force
	* @return bool FALSE if failed, TRUE if already present and unchanged or successful
	*/
	function insert(&$item, $force = false)
	{

        if (strtolower(get_class($item)) != 'publisheritem') {
        	$item->setErrors('Invalid class provided.');
            return false;
        }

		if (!$item->meta_keywords() || !$item->meta_description() || !$item->short_url()) {
			$smartobject_metagen = new PublisherMetagen($item->title(), $item->getVar('meta_keywords'), $item->getVar('summary'));
			// Auto create meta tags if empty
			if (!$item->meta_keywords()) {
				$item->setVar('meta_keywords', $smartobject_metagen->_keywords);
			}
			if (!$item->meta_description()) {
				$item->setVar('meta_description', $smartobject_metagen->_description);
			}
			// Auto create short_url if empty
			if (!$item->short_url()) {
				$item->setVar('short_url', $smartobject_metagen->generateSeoTitle($item->getVar('title', 'n'), false));
			}
		}

		if (!$item->isDirty()) {
			return true;
		}

		if (!$item->cleanVars()) {
			$item->setErrors('Variables were not cleaned properly.');
			return false;
		}

		foreach ($item->cleanVars as $k => $v) {
            ${$k} = $v;
        }
		if ($item->isNew()) {
			$sql = sprintf("INSERT INTO %s (itemid,
			categoryid,
			title,
			summary,
			display_summary,
			body,
			uid,
			datesub,
			`status`,
			image,
			item_tag,
			counter,
			weight,
			partial_view,
			dohtml,
			dosmiley,
			doxcode,
			doimage,
			dobr,
			cancomment,
			comments,
			notifypub,
			meta_keywords,
			meta_description,
			short_url
			)
			VALUES (NULL,
			%u,
			%s,
			%s,
			%u,
			%s,
			%u,
			%u,
			%u,
			%s,
			%s,
			%s,
			%u,
			%u,
			%s,
			%u,
			%u,
			%u,
			%u,
			%u,
			%u,
			%u,
			%s,
			%s,
			%s
			)",
			$this->db->prefix('publisher_items'),
			$categoryid, $this->db->quoteString($title),
			$this->db->quoteString($summary), $display_summary,
			$this->db->quoteString($body),
			$uid,
			$datesub,
			$status,
			$this->db->quoteString($image),
			$this->db->quoteString($item_tag),
			$counter,
			$weight,
			$this->db->quoteString($partial_view),
			$dohtml,
			$dosmiley,
			$doxcode,
			$doimage,
			$dobr,
			$cancomment,
			$comments,
			$notifypub,
			$this->db->quoteString($meta_keywords),
			$this->db->quoteString($meta_description),
			$this->db->quoteString($short_url)
			);
		} else {
			$sql = sprintf("UPDATE %s
			SET categoryid = %u,
			title = %s,
			summary = %s,
			display_summary = %u,
			body = %s,
			uid = %u,
			datesub = %u,
			`status` = %u,
			image = %s,
			item_tag = %s,
			counter = %u,
			weight = %u,
			partial_view = %s,
			dohtml = %u,
			dosmiley = %u,
			doxcode = %u,
			doimage = %u,
			dobr = %u,
			cancomment = %u,
			comments = %u,
			notifypub = %u,
			meta_keywords = %s,
			meta_description = %s,
			short_url = %s
			WHERE itemid = %u",
			$this->db->prefix('publisher_items'),
			$categoryid, $this->db->quoteString($title),
			$this->db->quoteString($summary),
			$display_summary,
			$this->db->quoteString($body),
			$uid,
			$datesub,
			$status,
			$this->db->quoteString($image),
			$this->db->quoteString($item_tag),
			$counter,
			$weight,
			$this->db->quoteString($partial_view),
			$dohtml,
			$dosmiley,
			$doxcode,
			$doimage,
			$dobr,
			$cancomment,
			$comments,
			$notifypub,
			$this->db->quoteString($meta_keywords),
			$this->db->quoteString($meta_description),
			$this->db->quoteString($short_url),
			$itemid);
		}

		//echo "<br />" . $sql . "<br />";exit;

		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}

		if (!$result) {
			$item->setErrors('The query returned an error. ' . $this->db->error());
			return false;
		}
		if ($item->isNew()) {
			$item->assignVar('itemid', $this->db->getInsertId());
		}

		if (publisher_tag_module_included()) {
			// Storing tags information
			$tag_handler = xoops_getmodulehandler('tag', 'tag');
			$tag_handler->updateByItem($item_tag, $item->getVar('itemid'), 'publisher', 0);
		}

		// Saving permissions
		publisher_saveItemPermissions($item->getGroups_read(), $item->itemid());

		return true;
	}

	/**
	* delete an item from the database
	*
	* @param object $item reference to the ITEM to delete
	* @param bool $force
	* @return bool FALSE if failed.
	*/
	function delete(&$item, $force = false)
	{
	    $hModule =& xoops_gethandler('module');
    	$smartModule =& $hModule->getByDirname('publisher');
    	$module_id = $smartModule->getVar('mid');

		if (strtolower(get_class($item)) != 'publisheritem') {
			return false;
		}

		// Deleting the files
		global $publisher_file_handler;
		if (!$publisher_file_handler->deleteItemFiles($item)) {
			$item->setErrors('An error while deleting a file.');
		}

		$sql = sprintf("DELETE FROM %s WHERE itemid = %u", $this->db->prefix("publisher_items"), $item->itemid());

		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			$item->setErrors('An error while deleting.');
			return false;
		}

		xoops_groupperm_deletebymoditem ($module_id, "item_read", $item->itemid());
		return true;
	}

	/**
	* retrieve items from the database
	*
	* @param object $criteria {@link CriteriaElement} conditions to be met
	* @param bool $id_key what shall we use as array key ? none, itemid, categoryid
	* @return array array of {@link PublisherItem} objects
	*/
	function &getObjects($criteria = null, $id_key = 'none', $notNullFields='')
	{
		$ret = false;
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('publisher_items');

		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$whereClause = $criteria->renderWhere();

			if ($whereClause != 'WHERE ()') {
				$sql .= ' '.$criteria->renderWhere();
				if (!empty($notNullFields)) {
					$sql .= $this->NotNullFieldClause($notNullFields, true);
				}
			} elseif (!empty($notNullFields)) {
				$sql .= " WHERE " . $this->NotNullFieldClause($notNullFields);
			}
			if ($criteria->getSort() != '') {
				$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
			}
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		} elseif (!empty($notNullFields)) {
			$sql .= $sql .= " WHERE " . $this->NotNullFieldClause($notNullFields);
		}

		$result = $this->db->query($sql, $limit, $start);
		if (!$result) {
			return $ret;
		}

		if (count($result) == 0) {
			return $ret;
		}

		$theObjects = array();

		while ($myrow = $this->db->fetchArray($result)) {
			$item = new PublisherItem();
			$item->assignVars($myrow);
			//$item->assignOtherProperties();

			$theObjects[$myrow['itemid']] =& $item;
			unset($item);
		}

		// since we need the categoryObj and the items permissions for all these items, let's
		// fetch them only once ;-)

		$publisher_allCategoriesObj = publisher_getAllCategoriesObj();

		global $publisher_permission_handler;
		if (!$publisher_permission_handler) {
			$publisher_permission_handler = xoops_getmodulehandler('permission', 'publisher')	;
		}

		$itemsObj_array_keys = array_keys($theObjects);
		$publisher_items_read_group = $publisher_permission_handler->getGrantedGroupsForIds($itemsObj_array_keys, 'item_read');

		foreach ($theObjects as $theObject) {
			$theObject->_category = isset($publisher_allCategoriesObj[$theObject->getVar('categoryid')]) ? $publisher_allCategoriesObj[$theObject->getVar('categoryid')] : null;
			$theObject->_groups_read = isset($publisher_items_read_group[$theObject->itemid()]) ? $publisher_items_read_group[$theObject->itemid()] : array();

			if ($id_key == 'none') {
				$ret[] =& $theObject;
			} elseif ($id_key == 'itemid') {
				$ret[$theObject->itemid()] =& $theObject;
			} else {
				$ret[$theObject->getVar($id_key)][$theObject->itemid()] =& $theObject;
			}
			unset($theObject);
		}

		return $ret;
	}
	function &getSimpleItemsList($criteria = null)
	{
		$ret = false;
		$limit = $start = 0;
		$sql = 'SELECT itemid, title FROM '.$this->db->prefix('publisher_items');

		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$whereClause = $criteria->renderWhere();

			if ($whereClause != 'WHERE ()') {
				$sql .= ' '.$criteria->renderWhere();
			}
			if ($criteria->getSort() != '') {
				$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
			}
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}

		$result = $this->db->query($sql, $limit, $start);
		if (!$result) {
			return $ret;
		}

		if (count($result) == 0) {
			return $ret;
		}

		$aItems = array();

		while ($myrow = $this->db->fetchArray($result)) {
			$aItems[$myrow['itemid']] = $myrow['title'];
		}
		return $aItems;
	}

	/**
	* count items matching a condition
	*
	* @param object $criteria {@link CriteriaElement} to match
	* @return int count of items
	*/
	function getCount($criteria = null, $notNullFields='')
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('publisher_items');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$whereClause = $criteria->renderWhere();
			if ($whereClause != 'WHERE ()') {
				$sql .= ' '.$criteria->renderWhere();
				if (!empty($notNullFields)) {
					$sql .= $this->NotNullFieldClause($notNullFields, true);
				}
			} elseif (!empty($notNullFields)) {
				$sql .= " WHERE " . $this->NotNullFieldClause($notNullFields);
			}
		} elseif (!empty($notNullFields)) {
			$sql .= " WHERE " . $this->NotNullFieldClause($notNullFields);
		}

		//echo "<br />" . $sql . "<br />";
		$result = $this->db->query($sql);
		if (!$result) {
			return 0;
		}
		list($count) = $this->db->fetchRow($result);
		return $count;
	}

	function getItemsCount($categoryid=-1, $status='', $notNullFields='')
	{

		global $xoopsUser;

	//	if ( ($categoryid = -1) && (empty($status) || ($status == -1)) ) {
			//return $this->getCount();
		//}

	    $hModule =& xoops_gethandler('module');
	    $hModConfig =& xoops_gethandler('config');
    	$smartModule =& $hModule->getByDirname('publisher');
    	$module_id = $smartModule->getVar('mid');

		$gperm_handler = &xoops_gethandler('groupperm');
		$groups = ($xoopsUser) ? ($xoopsUser->getGroups()) : XOOPS_GROUP_ANONYMOUS;

		$ret = array();

		$userIsAdmin = publisher_userIsAdmin();
		// Categories for which user has access
		if (!$userIsAdmin) {
			$categoriesGranted = $gperm_handler->getItemIds('category_read', $groups, $module_id);
			$grantedCategories = new Criteria('categoryid', "(".implode(',', $categoriesGranted).")", 'IN');
		}
		// ITEMs for which user has access
		if (!$userIsAdmin) {
			$itemsGranted = $gperm_handler->getItemIds('item_read', $groups, $module_id);
			$grantedItem = new Criteria('itemid', "(".implode(',', $itemsGranted).")", 'IN');
		}

		if (isset($categoryid) && ($categoryid != -1)) {
			$criteriaCategory = new criteria('categoryid', $categoryid);
		}

		$criteriaStatus = new CriteriaCompo();
		if ( !empty($status) && (is_array($status)) ) {
			foreach ($status as $v) {
				$criteriaStatus->add(new Criteria('status', $v), 'OR');
			}
		} elseif ( !empty($status) && ($status != -1)) {
			$criteriaStatus->add(new Criteria('status', $status), 'OR');
		}

		$criteriaPermissions = new CriteriaCompo();
		if (!$userIsAdmin) {
			$criteriaPermissions->add($grantedCategories, 'AND');
			$criteriaPermissions->add($grantedItem, 'AND');
		}

		$criteria = new CriteriaCompo();
		if (!empty($criteriaCategory)) {
			$criteria->add($criteriaCategory);
		}

		if (!empty($criteriaPermissions) && (!$userIsAdmin)) {
			$criteria->add($criteriaPermissions);
		}

		if (!empty($criteriaStatus)) {
			$criteria->add($criteriaStatus);
		}

		if (!empty($otherCriteria)) {
			$criteria->add($otherCriteria);
		}

		return $this->getCount($criteria, $notNullFields);
	}

	function getAllPublished($limit=0, $start=0, $categoryid=-1, $sort='datesub', $order='DESC', $notNullFields='', $asobject=true, $id_key='none')
	{
		$otherCriteria = new Criteria('datesub', time(), '<=');
		return $this->getItems($limit, $start, array(_PUB_STATUS_PUBLISHED), $categoryid, $sort, $order, $notNullFields, $asobject, $otherCriteria, $id_key);
	}

// -------------------------------------------------------------------------------------------------------------------
// Submited articles
	function getAllSubmitted($limit=0, $start=0, $categoryid=-1, $sort='datesub', $order='DESC', $notNullFields='', $asobject=true, $id_key='none')
	{
		return $this->getItems($limit, $start, array(_PUB_STATUS_SUBMITTED), $categoryid, $sort, $order, $notNullFields, $asobject, null, $id_key);
	}
// Submited articles
// -------------------------------------------------------------------------------------------------------------------

// -------------------------------------------------------------------------------------------------------------------
// Offline articles
	function getAllOffline($limit=0, $start=0, $categoryid=-1, $sort='datesub', $order='DESC', $notNullFields='', $asobject=true, $id_key='none')
	{
		return $this->getItems($limit, $start, array(_PUB_STATUS_OFFLINE), $categoryid, $sort, $order, $notNullFields, $asobject, null, $id_key);
	}
// Offline articles
// -------------------------------------------------------------------------------------------------------------------

// -------------------------------------------------------------------------------------------------------------------
// Rejected articles
	function getAllRejected($limit=0, $start=0, $categoryid=-1, $sort='datesub', $order='DESC', $notNullFields='', $asobject=true, $id_key='none')
	{
		return $this->getItems($limit, $start, array(_PUB_STATUS_REJECTED), $categoryid, $sort, $order, $notNullFields, $asobject, null, $id_key);
	}
// Rejected articles
// -------------------------------------------------------------------------------------------------------------------
	function getItems($limit=0, $start=0, $status='', $categoryid=-1, $sort='datesub', $order='DESC', $notNullFields='', $asobject=true, $otherCriteria=null, $id_key='none')
	{
		include_once XOOPS_ROOT_PATH.'/modules/publisher/include/functions.php';

		global $publisher_permission_handler;
		if (!$publisher_permission_handler) {
			$publisher_permission_handler = xoops_getmodulehandler('permission', 'publisher')	;
		}

		$ret = array();

		$userIsAdmin = publisher_userIsAdmin();
		// Categories for which user has access
		if (!$userIsAdmin) {
			$categoriesGranted = $publisher_permission_handler->getGrantedItems('category_read');
			$grantedCategories = new Criteria('categoryid', "(".implode(',', $categoriesGranted).")", 'IN');
		}
		// Item for which user has access
		if (!$userIsAdmin) {
			$itemsGranted = $publisher_permission_handler->getGrantedItems('item_read');
			$grantedItem = new Criteria('itemid', "(".implode(',', $itemsGranted).")", 'IN');
		}

		if (isset($categoryid) && ($categoryid != -1)) {
			$criteriaCategory = new criteria('categoryid', $categoryid);
		}

		if ( !empty($status) && (is_array($status)) ) {
			$criteriaStatus = new CriteriaCompo();
			foreach ($status as $v) {
				$criteriaStatus->add(new Criteria('status', $v), 'OR');
			}
		} elseif ( !empty($status) && ($status != -1)) {
			$criteriaStatus = new CriteriaCompo();
			$criteriaStatus->add(new Criteria('status', $status), 'OR');
		}

		$criteriaPermissions = new CriteriaCompo();
		if (!$userIsAdmin) {
			$criteriaPermissions->add($grantedCategories, 'AND');
			$criteriaPermissions->add($grantedItem, 'AND');
		}

		$criteria = new CriteriaCompo();
		if (!empty($criteriaCategory)) {
			$criteria->add($criteriaCategory);
		}

		if (!empty($criteriaPermissions) && (!$userIsAdmin)) {
			$criteria->add($criteriaPermissions);
		}

		if (!empty($criteriaStatus)) {
			$criteria->add($criteriaStatus);
		}

		if (!empty($otherCriteria)) {
			$criteria->add($otherCriteria);
		}

		$criteria->setLimit($limit);
		$criteria->setStart($start);
		$criteria->setSort($sort);
		$criteria->setOrder($order);

		$ret =& $this->getObjects($criteria, $id_key, $notNullFields);

		return $ret;
	}


	function getRandomItem($field='', $status='', $categoryId=-1)
	{
		$ret = false;

		$notNullFields = $field;

		// Getting the number of published Items
		$totalItems = $this->getItemsCount($categoryId, $status, $notNullFields);

		if ($totalItems > 0) {
			$totalItems = $totalItems - 1;
        	mt_srand((double)microtime() * 1000000);
        	$entrynumber = mt_rand(0, $totalItems);
        	$item =& $this->getItems(1, $entrynumber, $status, $categoryId, $sort='datesub', $order='DESC', $notNullFields);
			if ($item) {
				$ret =& $item[0];
			}
		}
		return $ret;

	}

	/**
	* delete Items matching a set of conditions
	*
	* @param object $criteria {@link CriteriaElement}
	* @return bool FALSE if deletion failed
	*/
	function deleteAll($criteria = null)
	{
		$sql = 'DELETE FROM '.$this->db->prefix('publisher_items');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result = $this->db->query($sql)) {
			return false;
			// TODO : Also delete the permissions related to each ITEM
		}
		return true;
	}

	/**
	* Change a value for Item with a certain criteria
	*
	* @param   string  $fieldname  Name of the field
	* @param   string  $fieldvalue Value to write
	* @param   object  $criteria   {@link CriteriaElement}
	*
	* @return  bool
	**/
	function updateAll($fieldname, $fieldvalue, $criteria = null)
	{
		$set_clause = is_numeric($fieldvalue) ? $fieldname.' = '.$fieldvalue : $fieldname.' = '.$this->db->quoteString($fieldvalue);
		$sql = 'UPDATE '.$this->db->prefix('publisher_items').' SET '.$set_clause;
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result = $this->db->queryF($sql)) {
			return false;
		}
		return true;
	}

	function updateCounter($itemid)
	{
		$sql = "UPDATE " . $this->db->prefix("publisher_items") . " SET counter=counter+1 WHERE itemid = " . $itemid;
		if ($this->db->queryF($sql)) {
			return true;
		} else {
			return false;
		}
	}

	function NotNullFieldClause($notNullFields='', $withAnd=false)
	{
		$ret = '';
		if ($withAnd) {
			$ret .= " AND ";
		}
		if ( !empty($notNullFields) && (is_array($notNullFields)) ) {
			foreach ($notNullFields as $v) {
				$ret .= " ($v IS NOT NULL AND $v <> ' ' )";
			}
		} elseif ( !empty($notNullFields)) {
			$ret .= " ($notNullFields IS NOT NULL AND $notNullFields <> ' ' )";
		}
		return $ret;
	}

	function getItemsFromSearch($queryarray = array(), $andor = 'AND', $limit = 0, $offset = 0, $userid = 0)
	{

	global $xoopsUser;

	$ret = array();

	$hModule =& xoops_gethandler('module');
	$hModConfig =& xoops_gethandler('config');
	$smartModule =& $hModule->getByDirname('publisher');
	$module_id = $smartModule->getVar('mid');

	$gperm_handler = &xoops_gethandler('groupperm');
	$groups = ($xoopsUser) ? ($xoopsUser->getGroups()) : XOOPS_GROUP_ANONYMOUS;
	$userIsAdmin = publisher_userIsAdmin();


	if ($userid != 0) {
		$criteriaUser = new CriteriaCompo();
		$criteriaUser->add(new Criteria('item.uid', $userid), 'OR');
	}

	if ($queryarray) {
		$criteriaKeywords = new CriteriaCompo();
		for ($i = 0; $i < count($queryarray); $i++) {
			$criteriaKeyword = new CriteriaCompo();
			$criteriaKeyword->add(new Criteria('item.title', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
			$criteriaKeyword->add(new Criteria('item.body', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
			$criteriaKeyword->add(new Criteria('item.summary', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
			$criteriaKeywords->add($criteriaKeyword, $andor);
			unset($criteriaKeyword);
		}
	}

	// Categories for which user has access
	if (!$userIsAdmin) {
		$categoriesGranted = $gperm_handler->getItemIds('category_read', $groups, $module_id);
		if (!$categoriesGranted) {
			return $ret;
		}
		$grantedCategories = new Criteria('item.categoryid', "(".implode(',', $categoriesGranted).")", 'IN');
	}
	// items for which user has access
	if (!$userIsAdmin) {
		$itemsGranted = $gperm_handler->getItemIds('item_read', $groups, $module_id);
		if (!$itemsGranted) {
			return $ret;
		}
		$grantedItem = new Criteria('item.itemid', "(".implode(',', $itemsGranted).")", 'IN');
	}

	$criteriaPermissions = new CriteriaCompo();
	if (!$userIsAdmin) {
		$criteriaPermissions->add($grantedCategories, 'AND');
		$criteriaPermissions->add($grantedItem, 'AND');
	}

	$criteriaItemsStatus = new CriteriaCompo();
	$criteriaItemsStatus->add(new Criteria('item.status', _PUB_STATUS_PUBLISHED));

	$criteria = new CriteriaCompo();
	if (!empty($criteriaUser)) {
		$criteria->add($criteriaUser, 'AND');
	}

	if (!empty($criteriaKeywords)) {
		$criteria->add($criteriaKeywords, 'AND');
	}

	if (!empty($criteriaPermissions) && (!$userIsAdmin)) {
		$criteria->add($criteriaPermissions);
	}

	if (!empty($criteriaItemsStatus)) {
		$criteria->add($criteriaItemsStatus, 'AND');
	}

	$criteria->setLimit($limit);
	$criteria->setStart($offset);
	$criteria->setSort('item.datesub');
	$criteria->setOrder('DESC');


	$sql = 'SELECT item.itemid, item.title, item.datesub, item.uid, item.categoryid FROM ('.$this->db->prefix('publisher_items') . ' as item) ';

	if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
		$whereClause = $criteria->renderWhere();

		if ($whereClause != 'WHERE ()') {
			$sql .= ' '.$criteria->renderWhere();
			if ($criteria->getSort() != '') {
				$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
			}
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}
	}

	//echo "<br />" . $sql . "<br />";

	$result = $this->db->query($sql, $limit, $start);
	if (!$result) {
		return $ret;
	}

	if (count($result) == 0) {
		return $ret;
	}

	/**
	 * Retreive the parent categories of the returned items in order
	 * to create the categoryPath
	 */
	$categoryids = array();

	$items = array();

	while ($myrow = $this->db->fetchArray($result)) {
		$items[] = $myrow;
		if (!in_array($myrow['categoryid'], $categoryids)) {
			$categoryids[] = $myrow['categoryid'];
		}
	}
	$publisher_category_handler = xoops_getmodulehandler('category', 'publisher');
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('categoryid', '(' . implode(', ', $categoryids) . ')', 'IN'));
	$categoriesObj = $publisher_category_handler->getObjects($criteria, true);

	foreach ($items as $singleitem) {
		$item['id'] = $singleitem['itemid'];
		$item['title'] = $singleitem['title'];
		$item['categoryPath'] = $categoriesObj[$singleitem['categoryid']]->getCategoryPath(false) ." > ";
		$item['datesub'] = $singleitem['datesub'];
		$item['uid'] = $singleitem['uid'];

		$ret[] = $item;
		unset($singleitem);
	}

	return $ret;
	}

	function getLastPublishedByCat($status = array(_PUB_STATUS_PUBLISHED)) {

		$ret = array();
	    $itemclause = "";
   	    if (!publisher_userIsAdmin()) {
	        $publisherPermHandler =& xoops_getmodulehandler('permission', 'publisher');
	        $items = $publisherPermHandler->getGrantedItems('item_read');
	        $itemclause = " AND itemid IN (".implode(',', $items).")";
	    }

	    $sql = "CREATE TEMPORARY TABLE tmp (categoryid INT(8) UNSIGNED NOT NULL,datesub int(11) DEFAULT '0' NOT NULL);";
	    $sql2 = " LOCK TABLES ".$this->db->prefix('publisher_items')." READ;";
	    $sql3 = " INSERT INTO tmp SELECT categoryid, MAX(datesub) FROM ".$this->db->prefix('publisher_items')." WHERE status IN (". implode(',', $status).") $itemclause GROUP BY categoryid;";
	    $sql4 = " SELECT ".$this->db->prefix('publisher_items').".categoryid, itemid, title, short_url, uid, ".$this->db->prefix('publisher_items').".datesub FROM ".$this->db->prefix('publisher_items').", tmp
	                  WHERE ".$this->db->prefix('publisher_items').".categoryid=tmp.categoryid AND ".$this->db->prefix('publisher_items').".datesub=tmp.datesub;";
        /*
	    //Old implementation
	    $sql = "SELECT categoryid, itemid, question, uid, MAX(datesub) AS datesub FROM ".$this->db->prefix("smartitem_item")."
	           WHERE status IN (". implode(',', $status).")";
	    $sql .= " GROUP BY categoryid";
	    */
	    $this->db->queryF($sql);
	    $this->db->queryF($sql2);
	    $this->db->queryF($sql3);
	    $result = $this->db->query($sql4);
	    $error = $this->db->error();
	    $this->db->queryF("UNLOCK TABLES;");
	    $this->db->queryF("DROP TABLE tmp;");
	    if (!$result) {
	        trigger_error("Error in getLastPublishedByCat SQL: ".$error);
	        return $ret;
	    }
		while ($row = $this->db->fetchArray($result)) {
		    $item = new PublisherItem();
			$item->assignVars($row);
			$ret[$row['categoryid']] =& $item;
			unset($item);
		}
		return $ret;
	}

	function countArticlesByCat($parentid, &$catsCount, $spaces='') {
		global $resultCatCounts;

		$newspaces = $spaces . '--';

		$thecount = 0;
		foreach($catsCount[$parentid] as $subCatId => $count) {
			$thecount = $thecount + $count;

			$resultCatCounts[$subCatId]	= $count;
			if (isset($catsCount[$subCatId])) {
				$thecount = $thecount + $this->countArticlesByCat($subCatId, $catsCount,  $newspaces );
				$resultCatCounts[$subCatId]	= $thecount;
			}
		}
		return $thecount;

	}

	function getCountsByCat($cat_id = 0, $status, $inSubCat=false) {
	    $ret = array();
	    $sql = 'SELECT c.parentid, i.categoryid, COUNT(*) AS count FROM '.$this->db->prefix('publisher_items') . ' AS i INNER JOIN '.$this->db->prefix('publisher_categories') . ' AS c ON i.categoryid=c.categoryid';
	    if (intval($cat_id) > 0) {
	        $sql .= ' WHERE i.categoryid = '.intval($cat_id);
	        $sql .= ' AND i.status IN ('.implode(',', $status).')';
	    }
	    else {
	        $sql .= ' WHERE i.status IN ('.implode(',', $status).')';
	        if (!publisher_userIsAdmin()) {
	            $publisherPermHandler =& xoops_getmodulehandler('permission', 'publisher');
	            $items = $publisherPermHandler->getGrantedItems('item_read');
	            $sql .= ' AND i.itemid IN ('.implode(',', $items).')';
	        }
	    }
	    $sql .= ' GROUP BY i.categoryid ORDER BY c.parentid ASC, i.categoryid ASC';

	    //echo "<br />$sql<br />";

		$result = $this->db->query($sql);
		if (!$result) {
			return $ret;
		}

		$categories = array();

		if (!$inSubCat) {
			while ($row = $this->db->fetchArray($result)) {
			    $catsCount[$row['categoryid']] = $row['count'];
			}
			return $catsCount;
		}

		while ($row = $this->db->fetchArray($result)) {
		    $catsCount[$row['parentid']][$row['categoryid']] = $row['count'];
		}

		global $resultCatCounts;
		$resultCatCounts = array();
		foreach($catsCount[0] as $subCatId => $count) {
			$resultCatCounts[$subCatId]	= $count;
			if (isset($catsCount[$subCatId])) {
				$resultCatCounts[$subCatId]	= $resultCatCounts[$subCatId] + $this->countArticlesByCat($subCatId, $catsCount);
			}
		}

	    return $resultCatCounts;
	}
}
?>
