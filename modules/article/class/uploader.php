<?php
/**
 * Article module for XOOPS
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code 
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         article
 * @since           1.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: uploader.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

require_once XOOPS_ROOT_PATH . "/class/uploader.php";

if (!class_exists("art_uploader")) {
class art_uploader extends XoopsMediaUploader
{
    var $ext = "";
    var $ImageSizeCheck = false;
    var $FileSizeCheck = false;
    var $CheckMediaTypeByExt = true;

    /**
     * No admin check for uploads
     */
    /**
     * Constructor
     *
     * @param string $uploadDir
     * @param array $allowedMimeTypes
     * @param int $maxFileSize
     * @param int $maxWidth
     * @param int $maxHeight
     * @param int $cmodvalue
     */
    function art_uploader($uploadDir, $allowedMimeTypes = false, $maxFileSize = 0, $maxWidth = 0, $maxHeight = 0)
    {
        if (!is_array($allowedMimeTypes)) {
	        if ($allowedMimeTypes == false || $allowedMimeTypes == "*") {
                $allowedMimeTypes = false;
            } else {
	           	$allowedMimeTypes = explode("|", strtolower($allowedMimeTypes));
	            if (in_array("*", $allowedMimeTypes)) {
	                $allowedMimeTypes = false;
	            }
            }
        }
        $this->XoopsMediaUploader($uploadDir, $allowedMimeTypes, $maxFileSize, $maxWidth, $maxHeight);
        //$this->setTargetFileName($this->getMediaName());
    }

    /**
     * Set the CheckMediaTypeByExt
     *
     * @param string $value
     */
    function setCheckMediaTypeByExt($value = true)
    {
        $this->CheckMediaTypeByExt = $value;
    }

    /**
     * Set the imageSizeCheck
     *
     * @param string $value
     */
    function setImageSizeCheck($value)
    {
        $this->ImageSizeCheck = $value;
    }

    /**
     * Set the fileSizeCheck
     *
     * @param string $value
     */
    function setFileSizeCheck($value)
    {
        $this->FileSizeCheck = $value;
    }

    /**
     * Get the file extension
     *
     * @return string
     */
    function getExt()
    {
        $this->ext = strtolower(ltrim(strrchr($this->getMediaName(), '.'), '.'));
        return $this->ext;
    }

    /**
     * Is the file the right size?
     *
     * @return bool
     */
    function checkMaxFileSize()
    {
        if (!$this->FileSizeCheck) {
            return true;
        }
        if ($this->mediaSize > $this->maxFileSize) {
            return false;
        }
        return true;
    }

    /**
     * Is the picture the right width?
     *
     * @return bool
     */
    function checkMaxWidth()
    {
        if (!$this->ImageSizeCheck) {
            return true;
        }
        if (false !== $dimension = getimagesize($this->mediaTmpName)) {
            if ($dimension[0] > $this->maxWidth) {
                return false;
            }
        } else {
            trigger_error(sprintf('Failed fetching image size of %s, skipping max width check..', $this->mediaTmpName), E_USER_WARNING);
        }
        return true;
    }

    /**
     * Is the picture the right height?
     *
     * @return bool
     */
    function checkMaxHeight()
    {
        if (!$this->ImageSizeCheck) {
            return true;
        }
        if (false !== $dimension = getimagesize($this->mediaTmpName)) {
            if ($dimension[1] > $this->maxHeight) {
                return false;
            }
        } else {
            trigger_error(sprintf('Failed fetching image size of %s, skipping max height check..', $this->mediaTmpName), E_USER_WARNING);
        }
        return true;
    }

    /**
     * Is the file the right Mime type
     *
     * (is there a right type of mime? ;-)
     *
     * @return bool
     */
    function checkMimeType()
    {
        if ($this->CheckMediaTypeByExt) $type = $this->getExt();
        else $type = $this->mediaType;
        if (count($this->allowedMimeTypes) > 0 && !in_array($type, $this->allowedMimeTypes)) {
            return false;
        }
        return true;
    }
}
}
?>