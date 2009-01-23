<?php

/**
* $Id: blocks.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

/*global $xoopsConfig, $xoopsModule, $xoopsModuleConfig;
if (isset($xoopsModuleConfig) && isset($xoopsModule) && $xoopsModule->getVar('dirname') == 'publisher') {
	$itemType = $xoopsModuleConfig['itemtype'];
} else {
	$hModule = &xoops_gethandler('module');
	$hModConfig = &xoops_gethandler('config');
	if ($publisher_Module = &$hModule->getByDirname('publisher')) {
		$module_id = $publisher_Module->getVar('mid');
		$publisher_Config = &$hModConfig->getConfigsByCat(0, $publisher_Module->getVar('mid'));
		$itemType = $publisher_Config['itemtype'];
	} else {
		$itemType = 'article';
	}	
}

include_once(XOOPS_ROOT_PATH . "/modules/publisher/language/" . $xoopsConfig['language'] . "/plugin/" . $itemType . "/blocks.php");
*/
// Blocks

define("_MB_PUB_ALLCAT", "���� �� ����������");
define("_MB_PUB_AUTO_LAST_ITEMS", "�� ������������ �������� �� ��������� �����������?");
define("_MB_PUB_CATEGORY", "���������");
define("_MB_PUB_CHARS", "����� ��� ������");
define("_MB_PUB_COMMENTS", "������");
define("_MB_PUB_DATE", "���������� �����������");
define("_MB_PUB_DISP", "��������");
define("_MB_PUB_DISPLAY_CATEGORY", "�������� ��� ������ ��� ����������;");
define("_MB_PUB_DISPLAY_COMMENTS", "�������� ��� ������� ��� �������;");
define("_MB_PUB_DISPLAY_TYPE", "����� ��������� : ");
define("_MB_PUB_DISPLAY_TYPE_BLOCK", "���� ����������� �� ����� block");
define("_MB_PUB_DISPLAY_TYPE_BULLET", "���� ����������� �� ����� ��������");
define("_MB_PUB_DISPLAY_WHO_AND_WHEN", "�������� ��� ��������� ��� ��� �����������;");
define("_MB_PUB_FULLITEM", "�������� ��� �� �����");
define("_MB_PUB_HITS", "������� ����������");
define("_MB_PUB_ITEMS", "�����");
define("_MB_PUB_LAST_ITEMS_COUNT", "�� ���, ���� ����������� �� ������������;");
define("_MB_PUB_LENGTH", " ����������");
define("_MB_PUB_ORDER", "����� ���������");
define("_MB_PUB_POSTEDBY", "������������ ��� ���");
define("_MB_PUB_READMORE", "�������� �����������...");
define("_MB_PUB_READS", "����������");
define("_MB_PUB_SELECT_ITEMS", "�� ���, �������� ���� ����� �� ������������ :");
define("_MB_PUB_SELECTCAT", "�������� ��� ������ ��� ���������� :");
define("_MB_PUB_VISITITEM", "������������ ���");
define("_MB_PUB_WEIGHT", "�������� ���� �����");
define("_MB_PUB_WHO_WHEN", "������������ ��� ��� %s ���� %s");
?>