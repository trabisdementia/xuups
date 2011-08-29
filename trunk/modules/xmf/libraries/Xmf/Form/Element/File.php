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
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Xmf
 * @since           0.1
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

/**
 *
 *
 * @package     kernel
 * @subpackage  form
 *
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
/**
 * A file upload field
 *
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 *
 * @package		kernel
 * @subpackage	form
 */
class Xmf_Form_Element_File extends Xmf_Form_Element
{
    /**
     * Maximum size for an uploaded file
     * @var	int
     * @access	private
     */
    var $_maxFileSize;

    /**
     * Constructor
     *
     * @param	string	$caption		Caption
     * @param	string	$name			"name" attribute
     * @param	int		$maxfilesize	Maximum size for an uploaded file
     */
    function __construct($caption, $name, $maxfilesize)
    {
        $this->setCaption($caption);
        $this->setName($name);
        $this->_maxFileSize = intval($maxfilesize);
    }

    /**
     * Get the maximum filesize
     *
     * @return	int
     */
    function getMaxFileSize()
    {
        return $this->_maxFileSize;
    }

    /**
     * prepare HTML for output
     *
     * @return	string	HTML
     */
    function render()
    {
        $ele_name = $this->getName();
        return "<input type='hidden' name='MAX_FILE_SIZE' value='".$this->getMaxFileSize()."' /><input type='file' name='".$ele_name."' id='".$ele_name."'".$this->getExtra()." /><input type='hidden' name='xoops_upload_file[]' id='xoops_upload_file[]' value='".$ele_name."' />";
    }
}
