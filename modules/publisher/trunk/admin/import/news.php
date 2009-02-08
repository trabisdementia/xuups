<?php
/**
* $Id: news.php 331 2007-12-23 16:01:11Z malanciault $
* Module: SmartFAQ
* Author: Marius Scurtescu <mariuss@romanians.bc.ca>
* Licence: GNU
*
* Import script from WF-Section 1.5 to Publisher 1.0.x.
*
*/
include_once dirname(dirname(__FILE__)) . "/admin_header.php";

$importFromModuleName = "News " . @$_POST['news_version'];

$scriptname = "news.php";

$op = 'start';

if (isset($_POST['op']) && ($_POST['op'] == 'go'))
{
	$op = $_POST['op'];
}

if ($op == 'start')
{
	include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';

	publisher_xoops_cp_header();
	publisher_adminMenu(-1, _AM_PUB_IMPORT);
	publisher_collapsableBar('newsimport', 'newsimporticon',  sprintf(_AM_PUB_IMPORT_FROM, $importFromModuleName), _AM_PUB_IMPORT_INFO);

	$result = $xoopsDB->query ("SELECT COUNT(*) FROM ".$xoopsDB->prefix("topics"));
	list ($totalCat) = $xoopsDB->fetchRow ($result);

	if ($totalCat == 0)
	{
		echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . _AM_PUB_IMPORT_NO_CATEGORY . "</span>";
	}
	else
	{
		include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";

		$result = $xoopsDB->query ("SELECT COUNT(*) FROM ".$xoopsDB->prefix("stories"));
		list ($totalArticles) = $xoopsDB->fetchRow ($result);

		if ($totalArticles == 0) {
			echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . sprintf(_AM_PUB_IMPORT_MODULE_FOUND_NO_ITEMS, $importFromModuleName, $totalArticles) . "</span>";
		} else {
			echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . sprintf(_AM_PUB_IMPORT_MODULE_FOUND, $importFromModuleName, $totalArticles, $totalCat) . "</span>";

			$form = new XoopsThemeForm (_AM_PUB_IMPORT_SETTINGS, 'import_form',  PUBLISHER_ADMIN_URL . "/import/$scriptname");

			// Categories to be imported
			$sql = "SELECT cat.topic_id, cat.topic_pid, cat.topic_title, COUNT(art.storyid) FROM ".$xoopsDB->prefix("topics") . " AS cat INNER JOIN ".$xoopsDB->prefix("stories") . " AS art ON cat.topic_id=art.topicid GROUP BY art.topicid";

			$result = $xoopsDB->query ($sql);
			$cat_cbox_options= array();
			while (list ($cid, $pid, $cat_title, $art_count) = $xoopsDB->fetchRow ($result))
			{
				$cat_title = $myts->displayTarea($cat_title);
				$cat_cbox_options[$cid] = "$cat_title ($art_count)";
			}
			$cat_label = new XoopsFormLabel(_AM_PUB_IMPORT_CATEGORIES, implode("<br />", $cat_cbox_options));
			$cat_label->setDescription(_AM_PUB_IMPORT_CATEGORIES_DSC);
			$form->addElement ($cat_label);

			// Publisher parent category
			$mytree = new XoopsTree($xoopsDB->prefix("publisher_categories"), "categoryid", "parentid");
			ob_start();
			$mytree->makeMySelBox("name", "weight", $preset_id=0, $none=1, $sel_name="parent_category");

			$parent_cat_sel = new XoopsFormLabel(_AM_PUB_IMPORT_PARENT_CATEGORY, ob_get_contents());
			$parent_cat_sel->setDescription(_AM_PUB_IMPORT_PARENT_CATEGORY_DSC);
			$form->addElement($parent_cat_sel);
			ob_end_clean();

			$form->addElement (new XoopsFormHidden('op', 'go'));
			$form->addElement (new XoopsFormButton ('', 'import', _AM_PUB_IMPORT, 'submit'));

			$form->addElement(new XoopsFormHidden('from_module_version', $_POST['news_version']));

			$form->display();
		}
	}

	publisher_close_collapsable('newsimport', 'newsimporticon');

	exit ();
}

if ($op == 'go')
{
	publisher_xoops_cp_header();
	publisher_adminMenu(-1, _AM_PUB_IMPORT);
	publisher_collapsableBar('newsimportgo', 'newsimportgoicon',  sprintf(_AM_PUB_IMPORT_FROM, $importFromModuleName), _AM_PUB_IMPORT_RESULT);

	$cnt_imported_cat = 0;
	$cnt_imported_articles = 0;

	$parentId = $_POST['parent_category'];

	$sql = "SELECT * FROM ".$xoopsDB->prefix("topics")."";

	$resultCat = $xoopsDB->query ($sql);

	$newCatArray = array();
	$newArticleArray = array();

    $oldToNew = array();
	while ($arrCat = $xoopsDB->fetchArray ($resultCat))
	{

        $categoryObj =& $publisher_category_handler->create();

		$categoryObj->setVar ('parentid', $arrCat['topic_pid']);
		$categoryObj->setVar ('weight', 0);
		$categoryObj->setVar ('name', $arrCat['topic_title']);
		$categoryObj->setVar ('description', $arrCat['topic_description']);

		// Category image
		/*if (($arrCat['imgurl'] != 'blank.gif') && ($arrCat['imgurl'])) {
			if (copy(XOOPS_ROOT_PATH . "/modules/wfsection/images/category/" . $arrCat['imgurl'], XOOPS_ROOT_PATH . "/uploads/publisher/images/category/" . $arrCat['imgurl'])) {
				$categoryObj->setVar('image', $arrCat['imgurl']);
			}
		}*/

		if (!$publisher_category_handler->insert($categoryObj))
		{
			echo sprintf(_AM_PUB_IMPORT_CATEGORY_ERROR, $arrCat['topic_title']) . "<br/>";
			continue;
		}


		// Saving category permissions
		//publisher_saveCategory_Permissions($categoryObj->getGroups_read(), $categoryObj->categoryid(), 'category_read');
		//publisher_saveCategory_Permissions($categoryObj->getGroups_submit(), $categoryObj->categoryid(), 'item_submit');

		$cnt_imported_cat++;

		echo sprintf(_AM_PUB_IMPORT_CATEGORY_SUCCESS, $categoryObj->name()) . "<br\>";

		$sql = "SELECT * FROM ".$xoopsDB->prefix("stories")." WHERE topicid=" . $arrCat['topic_id'] . "";
		$resultArticles = $xoopsDB->query ($sql);
		while ($arrArticle = $xoopsDB->fetchArray ($resultArticles))
		{
			// insert article
			$itemObj =& $publisher_item_handler->create();

			$itemObj->setVar('categoryid', $categoryObj->categoryid());
			$itemObj->setVar('title', $arrArticle['title']);
			$itemObj->setVar('uid', $arrArticle['uid']);
			$itemObj->setVar('summary', $arrArticle['hometext']);
			$itemObj->setVar('body', $arrArticle['bodytext']);
			$itemObj->setVar('counter', $arrArticle['counter']);
			$itemObj->setVar('datesub', $arrArticle['created']);
			$itemObj->setVar('dohtml', !$arrArticle['nohtml']);
			$itemObj->setVar('dosmiley', !$arrArticle['nosmiley']);
			$itemObj->setVar('weight', 0);
			$itemObj->setVar('status', _PUB_STATUS_PUBLISHED);
			//$itemObj->setGroups_read (explode (" ", trim ($arrArticle['groupid'])));
			/*
			// HTML Wrap
			if ($arrArticle['htmlpage']) {
				$pagewrap_filename	= XOOPS_ROOT_PATH . "/modules/wfsection/html/" .$arrArticle['htmlpage'];
				if (file_exists($pagewrap_filename)) {
					if (copy($pagewrap_filename, XOOPS_ROOT_PATH . "/uploads/publisher/content/" . $arrArticle['htmlpage'])) {
						$itemObj->setVar('body', "[pagewrap=" . $arrArticle['htmlpage'] . "]");
						echo sprintf("&nbsp;&nbsp;&nbsp;&nbsp;" . _AM_PUB_IMPORT_ARTICLE_WRAP, $arrArticle['htmlpage']) . "<br/>";
					}
				}
			}
			*/
			if (!$itemObj->store())
			{
				echo sprintf("  " . _AM_PUB_IMPORT_ARTICLE_ERROR, $arrArticle['title']) . "<br/>";
				continue;
			} else {
				/*
				// Linkes files
				$sql = "SELECT * FROM ".$xoopsDB->prefix("wfs_files")." WHERE articleid=" . $arrArticle['articleid'];
				$resultFiles = $xoopsDB->query ($sql);
				$allowed_mimetypes = '';
				while ($arrFile = $xoopsDB->fetchArray ($resultFiles)) {

					$filename = XOOPS_ROOT_PATH . "/modules/wfsection/cache/uploaded/" . $arrFile['filerealname'];
					if (file_exists($filename)) {
						if (copy($filename, XOOPS_ROOT_PATH . "/uploads/publisher/" . $arrFile['filerealname'])) {
							$fileObj = $publisher_file_handler->create();
							$fileObj->setVar('name', $arrFile['fileshowname']);
							$fileObj->setVar('description', $arrFile['filedescript']);
							$fileObj->setVar('status', _PUB_STATUS_FILE_ACTIVE);
							$fileObj->setVar('uid', $arrArticle['uid']);
							$fileObj->setVar('itemid', $itemObj->itemid());
							$fileObj->setVar('mimetype', $arrFile['minetype']);
							$fileObj->setVar('datesub', $arrFile['date']);
							$fileObj->setVar('counter', $arrFile['counter']);
							$fileObj->setVar('filename', $arrFile['filerealname']);

							if ($fileObj->store($allowed_mimetypes, true, false)) {
								echo "&nbsp;&nbsp;&nbsp;&nbsp;"  . sprintf(_AM_PUB_IMPORTED_ARTICLE_FILE, $arrFile['filerealname']) . "<br />";
							}
						}
					}
				}
				*/
				$newArticleArray[$arrArticle['storyid']] = $itemObj->itemid();
				echo "&nbsp;&nbsp;" . sprintf(_AM_PUB_IMPORTED_ARTICLE, $itemObj->title()) . "<br />";
				$cnt_imported_articles++;
			}
		}
		$newCatArray[$newCat['oldid']] = $newCat;
		unset($newCat);
		echo "<br/>";
	}
	// Looping through cat to change the pid to the new pid
	foreach($newCatArray as $oldid => $newCat) {
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('categoryid', $newCat['newid']));
		$oldpid = $newCat['oldpid'];
		if ($oldpid == 0) {
			$newpid = $parentId;
		} else {
			$newpid = $newCatArray[$oldpid]['newid'];
		}
		$publisher_category_handler->updateAll('parentid', $newpid, $criteria);
		unset($criteria);
	}

	// Looping through the comments to link them to the new articles and module
	echo "" . _AM_PUB_IMPORT_COMMENTS . "<br />";

	$module_handler =& xoops_gethandler ('module');
	$moduleObj = $module_handler->getByDirname('news');
	$news_module_id = $moduleObj->getVar('mid');

	$moduleObj = $module_handler->getByDirname('publisher');
	$publisher_module_id = $moduleObj->getVar('mid');


	$comment_handler = xoops_gethandler('comment');
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('com_modid', $news_module_id));
	$comments = $comment_handler->getObjects($criteria);
	foreach ($comments as $comment) {
		$comment->setVar('com_itemid', $newArticleArray[$comment->getVar('com_itemid')]);
		$comment->setVar('com_modid', $publisher_module_id);
		$comment->setNew();
		if (!$comment_handler->insert($comment)) {
			echo "&nbsp;&nbsp;"  . sprintf(_AM_PUB_IMPORTED_COMMENT_ERROR, $comment->getVar('com_title')) . "<br />";
		} else {
			echo "&nbsp;&nbsp;"  . sprintf(_AM_PUB_IMPORTED_COMMENT, $comment->getVar('com_title')) . "<br />";
		}

	}

	echo "<br/><br/>Done.<br/>";
	echo sprintf(_AM_PUB_IMPORTED_CATEGORIES, $cnt_imported_cat) . "<br/>";
	echo sprintf(_AM_PUB_IMPORTED_ARTICLES, $cnt_imported_articles) . "<br/>";
	echo "<br/><a href='" . PUBLISHER_URL . "/'>" . _AM_PUB_IMPORT_GOTOMODULE . "</a><br/>";

	publisher_close_collapsable('newsimportgo', 'newsimportgoicon');

	exit ();
}

?>

