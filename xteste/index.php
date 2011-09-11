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
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: $
 */

include dirname(dirname(dirname(__FILE__))) . '/mainfile.php';
include dirname(__FILE__) .'/include/common.php';

include XOOPS_ROOT_PATH . '/header.php';

$helper = Xmf_Module_Helper::getInstance('xteste');
$helper->setDebug(true);

Xmf_Debug::dump($helper->getObject()->getInfo());

echo $helper->getObject()->getVar('name') . '<br>';

echo $helper->getConfig('config1') . '<br>';
echo $helper->getConfig('config2') . '<br>';
echo $helper->getConfig('config3') . '<br>'; //trows an error on log cause config3 is missing


$helper->loadLanguage('badmanifesto'); //trows error on log because language was not found
$helper->loadLanguage('manifesto');

$helper = Xmf_Module_Helper::getInstance('nomodulehere');
$helper->setDebug(true);
$helper->getObject(); //trows an error on log because module was not found */

include XOOPS_ROOT_PATH . '/footer.php';
