<?php

/**
* $Id: question.php,v 1.25 2006/09/29 18:49:10 malanciault Exp $
* Module: SmartFAQ
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once("admin_header.php");

// Creating the faq handler object
$faq_handler =& sf_gethandler('faq');

// Creating the category handler object
$category_handler =& sf_gethandler('category');

$op = '';
if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

// Where shall we start?
$startfaq = isset($_GET['startfaq'])? intval($_GET['startfaq']) : 0;

function editfaq($showmenu = false, $faqid = -1)
{
	global $faq_handler, $category_handler, $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $modify, $xoopsModuleConfig, $xoopsModule, $XOOPS_URL, $myts;

	include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
	// If there is a parameter, and the id exists, retrieve data: we're editing a faq
	if ($faqid != -1) {
		// Creating the FAQ object
		$faqObj = new sfFaq($faqid);

		if ($faqObj->notLoaded()) {
			redirect_header("faq.php", 1, _AM_SF_NOARTTOEDIT);
			exit();
		}
		switch ($faqObj->status()) {

			case _SF_STATUS_ASKED :
			$breadcrumb_action = 	_AM_SF_APPROVING;
			$collapsableBar_title = _AM_SF_QUESTION_APPROVING;
			$collapsableBar_info = _AM_SF_QUESTION_APPROVING_INFO;
			$button_caption = _AM_SF_QUEUE;
			break;

			case "default" :
			default :
			$breadcrumb_action = 	_AM_SF_EDITING;
			$collapsableBar_title = _AM_SF_EDITQUES;
			$collapsableBar_info = _AM_SF_EDITING_INFO;
			$button_caption = _AM_SF_MODIFY;
			break;
		}

		// Creating the category of this FAQ
		$categoryObj =& $category_handler->get($faqObj->categoryid());

		If ($showmenu) {
			sf_adminMenu(3, _AM_SF_OPEN_QUESTIONS . " > " . $breadcrumb_action);
		}

		echo "<br />\n";
		sf_collapsableBar('bottomtable', 'bottomtableicon');
		echo "<img id='bottomtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . $collapsableBar_title . "</h3>";
		echo "<div id='bottomtable'>";
		echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . $collapsableBar_info . "</span>";
	} else {
		// there's no parameter, so we're adding a faq
		$faqObj =& $faq_handler->create();
		$faqObj->setVar('uid', $xoopsUser->getVar('uid'));
		$categoryObj =& $category_handler->create();

		$breadcrumb_action = _AM_SF_CREATINGNEW;
		$button_caption = _AM_SF_CREATE;
		If ($showmenu) {
			sf_adminMenu(3, _AM_SF_OPEN_QUESTIONS . " > " . $breadcrumb_action);
		}
		sf_collapsableBar('bottomtable', 'bottomtableicon');
		echo "<img id='bottomtableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SF_CREATEQUESTION . "</h3>";
		echo "<div id='bottomtable'>";
	}
	$sform = new XoopsThemeForm(_AM_SF_OPEN_QUESTION, "op", xoops_getenv('PHP_SELF'));
	$sform->setExtra('enctype="multipart/form-data"');

	// faq requester
	$sform->addElement(new XoopsFormLabel(_AM_SF_REQUESTED_BY, sf_getLinkedUnameFromId($faqObj->uid(), $xoopsModuleConfig['userealname'])));

	// CATEGORY
	/*
	* Get information for pulldown menu using XoopsTree.
	* First var is the database table
	* Second var is the unique field ID for the categories
	* Last one is not set as we do not have sub menus in Smartfaq
	*/

	$mytree = new XoopsTree($xoopsDB->prefix("smartfaq_categories"), "categoryid" , "parentid");
	ob_start();
	$mytree->makeMySelBox("name", "weight", $categoryObj->categoryid());
	$sform->addElement(new XoopsFormLabel(_AM_SF_CATEGORY_QUESTION, ob_get_contents()));
	ob_end_clean();

	// faq QUESTION
	$sform->addElement(new XoopsFormTextArea(_AM_SF_QUESTION, 'question', $faqObj->question(), 7, 60));

	// PER ITEM PERMISSIONS
	$member_handler = &xoops_gethandler('member');
	$group_list = &$member_handler->getGroupList();
	$groups_checkbox = new XoopsFormCheckBox(_AM_SF_PERMISSIONS_QUESTION, 'groups[]', $faqObj->getGroups_read());
	foreach ($group_list as $group_id => $group_name) {
		If ($group_id != XOOPS_GROUP_ADMIN) {
			$groups_checkbox->addOption($group_id, $group_name);
		}
	}
	$sform->addElement($groups_checkbox);

	// faq ID
	$sform->addElement(new XoopsFormHidden('faqid', $faqObj->faqid()));

	$button_tray = new XoopsFormElementTray('', '');
	$hidden = new XoopsFormHidden('op', 'addfaq');
	$button_tray->addElement($hidden);

	$sform->addElement(new XoopsFormHidden('status', $faqObj->status()));
	// Setting the FAQ Status
	/*	$status_select = new XoopsFormSelect('', 'status', $status);
	$status_select->addOptionArray(sf_getStatusArray());
	$status_tray = new XoopsFormElementTray(_AM_SF_STATUS_EXP , '&nbsp;');
	$status_tray->addElement($status_select);
	$sform->addElement($status_tray);
	*/
	if ($faqid == -1) {

		// there's no faqid? Then it's a new faq
		// $button_tray -> addElement( new XoopsFormButton( '', 'mod', _AM_SF_CREATE, 'submit' ) );
		$butt_create = new XoopsFormButton('', '', _AM_SF_CREATE, 'submit');
		$butt_create->setExtra('onclick="this.form.elements.op.value=\'addfaq\'"');
		$button_tray->addElement($butt_create);

		$butt_clear = new XoopsFormButton('', '', _AM_SF_CLEAR, 'reset');
		$button_tray->addElement($butt_clear);

		$butt_cancel = new XoopsFormButton('', '', _AM_SF_CANCEL, 'button');
		$butt_cancel->setExtra('onclick="history.go(-1)"');
		$button_tray->addElement($butt_cancel);
	} else {
		// else, we're editing an existing faq
		// $button_tray -> addElement( new XoopsFormButton( '', 'mod', _AM_SF_MODIFY, 'submit' ) );
		$butt_create = new XoopsFormButton('', '', $button_caption, 'submit');
		$butt_create->setExtra('onclick="this.form.elements.op.value=\'addfaq\'"');
		$button_tray->addElement($butt_create);

		$butt_edit = new XoopsFormButton('', '', _AM_SF_OPEN_QUESTION_EDIT, 'button');
		$butt_edit->setExtra("onclick=\"location='faq.php?op=mod&amp;faqid=" . $faqid . "'\"");
		$button_tray->addElement($butt_edit);


		$butt_cancel = new XoopsFormButton('', '', _AM_SF_CANCEL, 'button');
		$butt_cancel->setExtra('onclick="history.go(-1)"');
		$button_tray->addElement($butt_cancel);
	}

	$sform->addElement($button_tray);
	$sform->display();
	echo "</div>";
	unset($hidden);
}

/* -- Available operations -- */
switch ($op) {
	case "mod":

	Global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $xoopsModule, $modify, $myts;
	$faqid = (isset($_GET['faqid']))? $_GET['faqid'] : -1;

	if ($faqid == -1) {
		$totalcategories = $category_handler->getCategoriesCount(-1);
		if ($totalcategories == 0) {
			redirect_header("category.php?op=mod", 3, _AM_SF_NEED_CATEGORY_QUESTION);
		exit();
		}
	}

	xoops_cp_header();
	include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

	editfaq(true, $faqid);
	break;

	case "addfaq":
	global $xoopsUser;

	if (!$xoopsUser) {
		if ($xoopsModuleConfig['anonpost'] == 1) {
			$uid = 0;
		} else {
			redirect_header("index.php", 3, _NOPERM);
			exit();
		}
	} else {
	  	$uid = $xoopsUser->uid();
	}

	$faqid = (isset($_POST['faqid']))? intval($_POST['faqid']) : -1;

	// Creating the FAQ
	If ($faqid != -1) {
		$faqObj = new sfFaq($faqid);
	} else {
		$faqObj = $faq_handler->create();
	}

	// Putting the values in the FAQ object
	$faqObj->setGroups_read(isset($_POST['groups'])? $_POST['groups'] : array());
	$faqObj->setVar('categoryid', (isset($_POST['categoryid']))? intval($_POST['categoryid']) : 0);
	$faqObj->setVar('question', $_POST['question']);
	$faqObj->setVar('status', (isset($_POST['status']))? intval($_POST['status']) : _SF_STATUS_ASKED);

	$notifToDo = null;

	switch ($faqObj->status()) {

		case _SF_STATUS_NOTSET :
		$redirect_msg = _AM_SF_QUESTIONCREATEDOK;
		// Setting the new status
		$status = _SF_STATUS_OPENED;
		$notifToDo = array(_SF_NOT_QUESTION_PUBLISHED);
		$faqObj->setVar('uid', $uid);
		break;

		case _SF_STATUS_ASKED :
		$redirect_msg = _AM_SF_QUESTIONPUBLISHED;
		// Setting the new status
		$status = _SF_STATUS_OPENED;
		$notifToDo = array(_SF_NOT_QUESTION_PUBLISHED);
		break;

		case "default" :
		default :
		$redirect_msg = _AM_SF_QUESTIONMODIFIED;
		// Setting the new status
		$status = $faqObj->status();
		break;
	}
	$faqObj->setVar('status', $status);

	// Storing the FAQ
	If ( !$faqObj->store() ) {
		redirect_header("javascript:history.go(-1)", 3, _AM_SF_ERROR . sf_formatErrors($faqObj->getErrors()));
		exit;
	}

	// Send notifications
	If (!empty($notifToDo)) {
		$faqObj->sendNotifications($notifToDo);
	}

	redirect_header("question.php", 2, $redirect_msg);

	exit();
	break;

	case "del":
	global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $_GET;

	$module_id = $xoopsModule->getVar('mid');
	$gperm_handler = &xoops_gethandler('groupperm');

	$faqid = (isset($_POST['faqid']))? intval($_POST['faqid']) : 0;
	$faqid = (isset($_GET['faqid']))? intval($_GET['faqid']) : $faqid;

	$faqObj = new sfFaq($faqid);

	$confirm = (isset($_POST['confirm']))? $_POST['confirm'] : 0;
	$question = (isset($_POST['question']))? $_POST['question'] : '';

	if ($confirm) {
		If ( !$faq_handler->delete($faqObj)) {
			redirect_header("question.php", 2, _AM_SF_FAQ_DELETE_ERROR);
			exit;
		}

		redirect_header("question.php", 2, sprintf(_AM_SF_QUESTIONISDELETED, $faqObj->question()));
		exit();
	} else {
		// no confirm: show deletion condition
		$faqid = (isset($_GET['faqid']))? intval($_GET['faqid']) : 0;
		xoops_cp_header();
		xoops_confirm(array('op' => 'del', 'faqid' => $faqObj->faqid(), 'confirm' => 1, 'name' => $faqObj->question()), 'question.php', _AM_SF_DELETETHISQUESTION . " <br />'" . $faqObj->question() . "'. <br /> <br />", _AM_SF_DELETE);
		xoops_cp_footer();
	}

	exit();
	break;

	case "default":
	default:
	xoops_cp_header();

	sf_adminMenu(3, _AM_SF_OPEN_QUESTIONS);

	include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
	include_once XOOPS_ROOT_PATH . '/class/pagenav.php';

	global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $xoopsModule;

	echo "<br />\n";

	sf_collapsableBar('toptable', 'toptableicon');

	echo "<img id='toptableicon' src=" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/close12.gif alt='' /></a>&nbsp;" . _AM_SF_OPENED_TITLE . "</h3>";
	echo "<div id='toptable'>";
	echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . _AM_SF_OPENED_DSC . "</span>";

	// Get the total number of published FAQs
	$totalfaqs = $faq_handler->getFaqsCount(-1, array(_SF_STATUS_OPENED));
	// creating the FAQ objects that are published
	$faqsObj = $faq_handler->getFaqs($xoopsModuleConfig['perpage'], $startfaq, _SF_STATUS_OPENED);
	$totalFaqsOnPage = count($faqsObj);
	$allcats = $category_handler->getObjects(null, true);
	echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
	echo "<tr>";
	echo "<td width='40' class='bg3' align='center'><b>" . _AM_SF_ARTID . "</b></td>";
	echo "<td width='20%' class='bg3' align='left'><b>" . _AM_SF_ARTCOLNAME . "</b></td>";
	echo "<td class='bg3' align='left'><b>" . _AM_SF_QUESTION . "</b></td>";
	echo "<td width='90' class='bg3' align='center'><b>" . _AM_SF_CREATED . "</b></td>";
	echo "<td width='60' class='bg3' align='center'><b>" . _AM_SF_ACTION . "</b></td>";
	echo "</tr>";
	//var_dump( $faqsObj);
	if ($totalfaqs > 0) {
		foreach ( array_keys($faqsObj) as $i){
			$categoryObj =& $allcats[$faqsObj[$i]->categoryid()];

			$modify = "<a href='question.php?op=mod&amp;faqid=" . $faqsObj[$i]->faqid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_SF_EDITART . "' alt='" . _AM_SF_EDITART . "'></a>";
			$delete = "<a href='question.php?op=del&amp;faqid=" . $faqsObj[$i]->faqid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_SF_EDITART . "' alt='" . _AM_SF_DELETEART . "'></a>";

			echo "<tr>";
			echo "<td class='head' align='center'>" . $faqsObj[$i]->faqid() . "</td>";
			echo "<td class='even' align='left'>" . $categoryObj->name() . "</td>";
			echo "<td class='even' align='left'><a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/answer.php?faqid=" . $faqsObj[$i]->faqid() . "'>" . $faqsObj[$i]->question(100) . "</a></td>";
			echo "<td class='even' align='center'>" . $faqsObj[$i]->datesub('s') . "</td>";
			echo "<td class='even' align='center'> $modify $delete </td>";
			echo "</tr>";
		}
	} else {
		$faqid = -1;
		echo "<tr>";
		echo "<td class='head' align='center' colspan= '7'>" . _AM_SF_NOQUEUED . "</td>";
		echo "</tr>";
	}
	echo "</table>\n";
	echo "<br />\n";

	$pagenav = new XoopsPageNav($totalfaqs, $xoopsModuleConfig['perpage'], $startfaq, 'startfaq');
	echo '<div style="text-align:right;">' . $pagenav->renderNav() . '</div>';
	echo "</div>";

	$totalcategories = $category_handler->getCategoriesCount(-1);
	if ($totalcategories > 0) {
		editfaq();
	}

	break;
}
$modfooter = sf_modFooter();
echo "<div align='center'>" . $modfooter . "</div>";
xoops_cp_footer();

?>
