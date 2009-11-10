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
 * @package         Publisher
 * @subpackage      Blocks
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: latest_files.php 0 2009-06-11 18:47:04Z trabis $
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once dirname(dirname(__FILE__)) . '/include/common.php';

function publisher_latest_files_show ($options)
{
    $publisher =& PublisherPublisher::getInstance();
	/**
	 * $options[0] : Sort order - datesub | counter
	 * $options[1] : Number of files to display
	 * $oprions[2] : bool TRUE to link to the file download, FALSE to link to the article
	 */

	$block = array();

	$sort = $options[0];
	$order = publisher_getOrderBy($sort);
	$limit = $options[1];
	$directDownload = $options[2];

	// creating the files objects
	$filesObj = $publisher->getHandler('file')->getAllFiles(0, _PUBLISHER_STATUS_FILE_ACTIVE, $limit, 0, $sort, $order);
	foreach ($filesObj as $fileObj) {
        $aFile = array();
        $aFile['link'] = $directDownload ? $fileObj->getFileLink() : $fileObj->getItemLink();
        if ($sort == "datesub") {
            $aFile['new'] = $fileObj->datesub();
        } elseif ($sort == "counter") {
            $aFile['new'] = $fileObj->counter();
        } elseif ($sort == "weight") {
            $aFile['new'] = $fileObj->weight();
        }
		$block['files'][] = $aFile;
	}

	return $block;
}

function publisher_latest_files_edit($options)
{
    $form = "" . _MB_PUBLISHER_ORDER . "&nbsp;<select name='options[]'>";

    $form .= "<option value='datesub'";
    if ($options[0] == "datesub") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUBLISHER_DATE . "</option>\n";

    $form .= "<option value='counter'";
    if ($options[0] == "counter") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUBLISHER_HITS . "</option>\n";

    $form .= "</select>\n";

    $form .= "&nbsp;" . _MB_PUBLISHER_DISP . "&nbsp;<input type='text' name='options[]' value='" . $options[1] . "' />&nbsp;" . _MB_PUBLISHER_FILES . "";

	$yesChecked = $options[2] == true ? "checked='checked'" : '';
	$noChecked = $options[2] == false ? "checked='checked'" : '';

	$form .= "<br />" . _MB_PUBLISHER_DIRECTDOWNLOAD . "&nbsp;<input name='options[2]' value='1' type='radio' $yesChecked/>&nbsp;" . _YES . "<input name='options[2]' value='0' type='radio' $noChecked/>" . _NO;
    return $form;
}

?>
