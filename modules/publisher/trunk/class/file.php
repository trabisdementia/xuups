<?php

/**
* $Id: file.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH.'/modules/publisher/include/common.php';

// File status
define("_PUB_STATUS_FILE_NOTSET", -1);
define("_PUB_STATUS_FILE_ACTIVE", 1);
define("_PUB_STATUS_FILE_INACTIVE", 2);

class PublisherFile extends XoopsObject
{
	/**
	* constructor
	*/
	function PublisherFile($id = null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("fileid", XOBJ_DTYPE_INT, 0, false);
		$this->initVar("itemid", XOBJ_DTYPE_INT, null, true);
		$this->initVar("name", XOBJ_DTYPE_TXTBOX, null, true, 255);
		$this->initVar("description", XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar("filename", XOBJ_DTYPE_TXTBOX, null, true, 255);
		$this->initVar("mimetype", XOBJ_DTYPE_TXTBOX, null, true, 64);
		$this->initVar("uid", XOBJ_DTYPE_INT, 0, false);
		$this->initVar("datesub", XOBJ_DTYPE_INT, null, false);
		$this->initVar("status", XOBJ_DTYPE_INT, 1, false);
		$this->initVar("notifypub", XOBJ_DTYPE_INT, 0, false);
		$this->initVar("counter", XOBJ_DTYPE_INT, null, false);

		if (isset($id)) {
			global $publisher_file_handler;
			$file =& $publisher_file_handler->get($id);
			foreach ($file->vars as $k => $v) {
				$this->assignVar($k, $v['value']);
			}
		}
	}

	function checkUpload($post_field, &$allowed_mimetypes, &$errors)
	{
		include_once (PUBLISHER_ROOT_PATH . '/class/uploader.php');
	    $config =& publisher_getModuleConfig();

	   /* $maxfilesize = $config['uploadSize'];
        $maxfilewidth = $config['uploadWidth'];
        $maxfileheight = $config['uploadHeight'];*/

	   	$maxfilesize = $config['maximum_filesize'];
		$maxfilewidth = $config['maximum_image_width'];
		$maxfileheight = $config['maximum_image_height'];

        $errors = array();

        if(!isset($allowed_mimetypes)){
            $hMime =& xoops_getmodulehandler('mimetype');
            $allowed_mimetypes = $hMime->checkMimeTypes($post_field);
            if(!$allowed_mimetypes){
                $errors[] = _PUBLISHER_MESSAGE_WRONG_MIMETYPE;
                return false;
            }
        }
        $uploader = new XoopsMediaUploader(publisher_getUploadDir(), $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);

        if ($uploader->fetchMedia($post_field)) {
            return true;
        } else {
            $errors = array_merge($errors, $uploader->getErrors(false));
            return false;
        }
	}

	function storeUpload($post_field, $allowed_mimetypes = null, &$errors)
	{
	    global $xoopsUser, $xoopsDB, $xoopsModule;
        include_once (PUBLISHER_ROOT_PATH . '/class/uploader.php');

        $config =& publisher_getModuleConfig();

	    $itemid = $this->getVar('itemid');

        if(!isset($allowed_mimetypes)){
            $hMime =& xoops_getmodulehandler('mimetype');
            $allowed_mimetypes = $hMime->checkMimeTypes($post_field);
            if(!$allowed_mimetypes){
                return false;
            }
        }

	   	$maxfilesize = $config['maximum_filesize'];
		$maxfilewidth = $config['maximum_image_width'];
		$maxfileheight = $config['maximum_image_height'];

        if(!is_dir(publisher_getUploadDir())){
            mkdir(publisher_getUploadDir(), 0757);
        }

        $uploader = new XoopsMediaUploader(publisher_getUploadDir().'/', $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);
        if ($uploader->fetchMedia($post_field)) {
            $uploader->setTargetFileName($itemid."_". $uploader->getMediaName());
            if ($uploader->upload()) {
                $this->setVar('filename', $uploader->getSavedFileName());
                if ($this->getVar('name') == '') {
                	$this->setVar('name', $this->getNameFromFilename());
                }
                $this->setVar('mimetype', $uploader->getMediaType());
                return true;
            } else {
                 $errors = array_merge($errors, $uploader->getErrors(false));
            	return false;
            }

        } else {
            $errors = array_merge($errors, $uploader->getErrors(false));
            return false;
        }
	}

	function store($allowed_mimetypes = null, $force = true, $doupload = true)
	{
		if ($this->isNew()) {
			$errors = array();
			if ($doupload) {
				$ret = $this->storeUpload('userfile', $allowed_mimetypes, $errors);
			} else {
				$ret = true;
			}
			if (!$ret) {
				foreach ($errors as $error) {
					$this->setErrors($error);
				}
				return false;
			}
		}

		global $publisher_file_handler;
		return $publisher_file_handler->insert($this, $force);
	}

	function fileid()
    {
        return $this->getVar("fileid");
    }

	function itemid()
    {
        return $this->getVar("itemid");
    }

    function name($format = "S")
    {
        return $this->getVar("name", $format);
    }

    function description($format = "S")
    {
        return $this->getVar("description", $format);
    }

    function filename($format = "S")
    {
        return $this->getVar("filename", $format);
    }

    function mimetype($format = "S")
    {
        return $this->getVar("mimetype", $format);
    }

    function uid()
    {
        return $this->getVar("uid");
    }

	function datesub($dateFormat = 's', $format = "S")
	{
		return formatTimestamp($this->getVar('datesub', $format), $dateFormat);
	}

    function status()
    {
        return $this->getVar("status");
    }

    function notifypub()
    {
        return $this->getVar("notifypub");
    }

    function counter()
    {
        return $this->getVar("counter");
    }

	function notLoaded()
	{
	   return ($this->getVar('itemid') == 0);
	}

	function getFileUrl()
	{
 		$hModule =& xoops_gethandler('module');
	 	$hModConfig =& xoops_gethandler('config');
     	$publisher_module =& $hModule->getByDirname('publisher');
	 	$publisher_config = &$hModConfig->getConfigsByCat(0, $publisher_module->getVar('mid'));

		return publisher_getUploadDir(false) .  $this->filename();
	}

	function getFilePath()
	{
 		$hModule =& xoops_gethandler('module');
	 	$hModConfig =& xoops_gethandler('config');
     	$publisher_module =& $hModule->getByDirname('publisher');
	 	$publisher_config = &$hModConfig->getConfigsByCat(0, $publisher_module->getVar('mid'));
     	return 	publisher_getUploadDir() . $this->filename();
	}

	function getFileLink()
	{
		return "<a href='" . XOOPS_URL . "/modules/publisher/visit.php?fileid=" . $this->fileid() . "'>" . $this->name()	. "</a>";
	}

	function getItemLink() {
		return "<a href='" . XOOPS_URL . "/modules/publisher/item.php?itemid=" . $this->itemid() . "'>" . $this->name()	. "</a>";
	}

	function updateCounter()
	{
	  	$this->setVar('counter', $this->counter() + 1);
	  	$this->store();
	}

	function displayFlash()
    {
		if (!defined('MYTEXTSANITIZER_EXTENDED_MEDIA')) {
			include_once(PUBLISHER_ROOT_PATH . '/include/media.textsanitizer.php');
		}
		$media_ts = MyTextSanitizerExtension::getInstance();
		return $media_ts->_displayFlash($this->getFileUrl());
	}

	function getNameFromFilename() {
		$ret = $this->filename();
		$sep_pos = strpos($ret, '_');
		$ret = substr($ret, $sep_pos + 1, strlen($ret) - $sep_pos);
		return $ret;
	}
}

/**
* Files handler class.
* This class is responsible for providing data access mechanisms to the data source
* of File class objects.
*
* @author marcan <marcan@notrevie.ca>
* @package Publisher
*/

class PublisherFileHandler extends XoopsPersistableObjectHandler
{

    function PublisherFileHandler(&$db)
    {
        $this->__construct($db);
    }

    function __construct(&$db)
    {
        parent::__construct($db, "publisher_files", 'PublisherFile', "fileid", "name");
    }

	/**
	* delete a file from the database
	*
	* @param object $file reference to the file to delete
	* @param bool $force
	* @return bool FALSE if failed.
	*/
	function delete(&$file, $force = false)
	{
		// Delete the actual file
		if (!publisher_deleteFile($file->getFilePath())) {
			return false;
		}

        $ret = parent::delete($file, $force);
        return $ret;
	}

	/**
	* delete files related to an item from the database
	*
	* @param object $itemObj reference to the item which files to delete
	*/
	function deleteItemFiles(&$itemObj)
	{
		if (strtolower(get_class($itemObj)) != 'publisheritem') {
			return false;
		}
		$files =& $this->getAllFiles($itemObj->itemid());
		$result = true;
		foreach ($files as $file) {
			if (!$this->delete($file)) {
				$result = false;
			}
		}
		return $result;
	}

	/**
	* retrieve all files
	*
	* @param object $criteria {@link CriteriaElement} conditions to be met
	* @param int $itemid
	* @return array array of {@link PublisherFile} objects
	*/
	function &getAllFiles($itemid = 0, $status = -1, $limit = 0, $start = 0, $sort = 'datesub', $order = 'DESC')
	{
		$hasStatusCriteria = false;
		$criteriaStatus = new CriteriaCompo();
		if ( is_array($status)) {
			$hasStatusCriteria = true;
			foreach ($status as $v) {
				$criteriaStatus->add(new Criteria('status', $v), 'OR');
			}
		} elseif ( $status != -1) {
			$hasStatusCriteria = true;
			$criteriaStatus->add(new Criteria('status', $status), 'OR');
		}
		$criteriaItemid = new Criteria('itemid', $itemid);

		$criteria = new CriteriaCompo();

		if ($itemid !=0) {
			$criteria->add($criteriaItemid);
		}

		if ($hasStatusCriteria) {
			$criteria->add($criteriaStatus);
		}

		$criteria->setSort($sort);
		$criteria->setOrder($order);
		$criteria->setLimit($limit);
		$criteria->setStart($start);
		$files =& $this->getObjects($criteria);

		return $files;
	}
	
}
?>
