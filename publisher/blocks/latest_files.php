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

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

include_once dirname(dirname(__FILE__)) . '/include/common.php';

function publisher_latest_files_show($options)
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
    include_once PUBLISHER_ROOT_PATH . '/class/blockform.php';
    xoops_load('XoopsFormLoader');

    $form = new PublisherBlockForm();

    $orderEle = new XoopsFormSelect(_MB_PUBLISHER_ORDER, 'options[0]', $options[0]);
    $orderEle->addOptionArray(array(
        'datesub' => _MB_PUBLISHER_DATE,
        'counter' => _MB_PUBLISHER_HITS,
        'weight'  => _MB_PUBLISHER_WEIGHT,
    ));
    $dispEle = new XoopsFormText(_MB_PUBLISHER_DISP, 'options[1]', 10, 255, $options[1]);
    $directEle = new XoopsFormRadioYN(_MB_PUBLISHER_DIRECTDOWNLOAD, 'options[2]', $options[2]);

    $form->addElement($orderEle);
    $form->addElement($dispEle);
    $form->addElement($directEle);

    return $form->render();
}