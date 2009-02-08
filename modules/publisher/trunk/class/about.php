<?php

/**
* $Id: about.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

if (!defined("XOOPS_ROOT_PATH")) {
die("XOOPS root path not defined");
}

/**
* Class About is a simple class that lets you build an about page
* @author The SmartFactory <www.smartfactory.ca>
*/

class PublisherAbout
{
	var $_lang_aboutTitle;
	var $_lang_author_info;
	var $_lang_developer_lead;
	var $_lang_developer_contributor;
	var $_lang_developer_website;
	var $_lang_developer_email;
	var $_lang_developer_credits;
	var $_lang_module_info;
	var $_lang_module_status;
	var $_lang_module_release_date;
	var $_lang_module_demo;
	var $_lang_module_support;
	var $_lang_module_bug;
	var $_lang_module_submit_bug;
	var $_lang_module_feature;
	var $_lang_module_submit_feature;
	var $_lang_module_disclaimer;
	var $_lang_author_word;
	var $_lang_version_history;
	var $_lang_by;
	
	function PublisherAbout($aboutTitle='About')
	{
		global $xoopsModule, $xoopsConfig;
		$fileName = XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/modinfo.php';
		if (file_exists($fileName)) {
			include_once $fileName;
		} else {
			include_once XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . '/language/english/modinfo.php';
		}
		$this->_aboutTitle = $aboutTitle;
		$this->_lang_author_info = _MI_PUB_AUTHOR_INFO;
		$this->_lang_developer_lead = _MI_PUB_DEVELOPER_LEAD;
		$this->_lang_developer_contributor = _MI_PUB_DEVELOPER_CONTRIBUTOR;
		$this->_lang_developer_website = _MI_PUB_DEVELOPER_WEBSITE;
		$this->_lang_developer_email = _MI_PUB_DEVELOPER_EMAIL;
		$this->_lang_developer_credits = _MI_PUB_DEVELOPER_CREDITS;
		$this->_lang_module_info = _MI_PUB_MODULE_INFO;
		$this->_lang_module_status = _MI_PUB_MODULE_STATUS;
		$this->_lang_module_release_date =_MI_PUB_MODULE_RELEASE_DATE ;
		$this->_lang_module_demo = _MI_PUB_MODULE_DEMO;
		$this->_lang_module_support = _MI_PUB_MODULE_SUPPORT;
		$this->_lang_module_bug = _MI_PUB_MODULE_BUG;
		$this->_lang_module_submit_bug = _MI_PUB_MODULE_SUBMIT_BUG;
		$this->_lang_module_feature = _MI_PUB_MODULE_FEATURE;
		$this->_lang_module_submit_feature = _MI_PUB_MODULE_SUBMIT_FEATURE;
		$this->_lang_module_disclaimer = _MI_PUB_MODULE_DISCLAIMER;
		$this->_lang_author_word = _MI_PUB_AUTHOR_WORD;
		$this->_lang_version_history = _MI_PUB_VERSION_HISTORY;
		$this->_lang_by = _MI_PUB_BY;
	}
	
	function render()
	{
		
		$myts = &MyTextSanitizer::getInstance();
		
		Global $xoopsModule;
		
		xoops_cp_header();
		
		$module_handler = &xoops_gethandler('module');
		$versioninfo = &$module_handler->get($xoopsModule->getVar('mid'));
		
		$adminMenu = $versioninfo->getInfo('adminMenu');
		
		if (false != $adminMenu && trim($adminMenu) != '') {
			if (function_exists($adminMenu)) {
				$func = $adminMenu;
				if (!$func(-1, $this->_aboutTitle . " " . $versioninfo->getInfo('name'))) {
				}
			}
		}
		
		// Left headings...
		echo "<img src='" . XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/" . $versioninfo->getInfo('image') . "' alt='' hspace='0' vspace='0' align='left' style='margin-right: 10px;'/></a>";
		echo "<div style='margin-top: 10px; color: #33538e; margin-bottom: 4px; font-size: 18px; line-height: 18px; font-weight: bold; display: block;'>" . $versioninfo->getInfo('name') . " version " . $versioninfo->getInfo('version') . " (" . $versioninfo->getInfo('status_version') . ")</div>";
		if ($versioninfo->getInfo('author_realname') != '') {
			$author_name = $versioninfo->getInfo('author') . " (" . $versioninfo->getInfo('author_realname') . ")";
		} else {
			$author_name = $versioninfo->getInfo('author');
		}
		
		echo "<div style = 'line-height: 16px; font-weight: bold; display: block;'>" . $this->_lang_by . " " . $author_name;
		echo "</div>";
		echo "<div style = 'line-height: 16px; display: block;'>" . $versioninfo->getInfo('license') . "</div>\n";
		
		// Developers Information
		echo "<br /><table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
		echo "<tr>";
		echo "<td colspan='2' class='bg3' align='left'><b>" . $this->_lang_author_info . "</b></td>";
		echo "</tr>";
		
		if ($versioninfo->getInfo('developer_lead') != '') {
			echo "<tr>";
			echo "<td class='head' width = '150px' align='left'>" . $this->_lang_developer_lead . "</td>";
			echo "<td class='even' align='left'>" . $versioninfo->getInfo('developer_lead') . "</td>";
			echo "</tr>";
		}
		if ($versioninfo->getInfo('developer_contributor') != '') {
			echo "<tr>";
			echo "<td class='head' width = '150px' align='left'>" . $this->_lang_developer_contributor . "</td>";
			echo "<td class='even' align='left'>" . $versioninfo->getInfo('developer_contributor') . "</td>";
			echo "</tr>";
		}
		if ($versioninfo->getInfo('developer_website_url') != '') {
			echo "<tr>";
			echo "<td class='head' width = '150px' align='left'>" . $this->_lang_developer_website . "</td>";
			echo "<td class='even' align='left'><a href='" . $versioninfo->getInfo('developer_website_url') . "' target='blank'>" . $versioninfo->getInfo('developer_website_name') . "</a></td>";
			echo "</tr>";
		}
		if ($versioninfo->getInfo('developer_email') != '') {
			echo "<tr>";
			echo "<td class='head' width = '150px' align='left'>" . $this->_lang_developer_email . "</td>";
			echo "<td class='even' align='left'><a href='mailto:" . $versioninfo->getInfo('developer_email') . "'>" . $versioninfo->getInfo('developer_email') . "</a></td>";
			echo "</tr>";
		}
		
		
		echo "</table>";
		echo "<br />\n";
		// Module Developpment information
		echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
		echo "<tr>";
		echo "<td colspan='2' class='bg3' align='left'><b>" . $this->_lang_module_info . "</b></td>";
		echo "</tr>";
		
		if ($versioninfo->getInfo('date') != '') {
			echo "<tr>";
			echo "<td class='head' width = '200' align='left'>" . $this->_lang_module_release_date . "</td>";
			echo "<td class='even' align='left'>" . $versioninfo->getInfo('date') . "</td>";
			echo "</tr>";
		}
		
		
		if ($versioninfo->getInfo('status') != '') {
			echo "<tr>";
			echo "<td class='head' width = '200' align='left'>" . $this->_lang_module_status . "</td>";
			echo "<td class='even' align='left'>" . $versioninfo->getInfo('status') . "</td>";
			echo "</tr>";
		}
		
		if ($versioninfo->getInfo('demo_site_url') != '') {
			echo "<tr>";
			echo "<td class='head' align='left'>" . $this->_lang_module_demo . "</td>";
			echo "<td class='even' align='left'><a href='" . $versioninfo->getInfo('demo_site_url') . "' target='blank'>" . $versioninfo->getInfo('demo_site_name') . "</a></td>";
			echo "</tr>";
		}
		
		if ($versioninfo->getInfo('support_site_url') != '') {
			echo "<tr>";
			echo "<td class='head' align='left'>" . $this->_lang_module_support . "</td>";
			echo "<td class='even' align='left'><a href='" . $versioninfo->getInfo('support_site_url') . "' target='blank'>" . $versioninfo->getInfo('support_site_name') . "</a></td>";
			echo "</tr>";
		}
		
		if ($versioninfo->getInfo('submit_bug') != '') {
			echo "<tr>";
			echo "<td class='head' align='left'>" . $this->_lang_module_bug . "</td>";
			echo "<td class='even' align='left'><a href='" . $versioninfo->getInfo('submit_bug') . "' target='blank'>" . $this->_lang_module_submit_bug . "</a></td>";
			echo "</tr>";
		}
		if ($versioninfo->getInfo('submit_feature') != '') {
			echo "<tr>";
			echo "<td class='head' align='left'>" . $this->_lang_module_feature . "</td>";
			echo "<td class='even' align='left'><a href='" . $versioninfo->getInfo('submit_feature') . "' target='blank'>" . $this->_lang_module_submit_feature . "</a></td>";
			echo "</tr>";
		}
		
		echo "</table>";
		// Warning
		if ($versioninfo->getInfo('warning') != '') {
			echo "<br />\n";
			echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
			echo "<tr>";
			echo "<td class='bg3' align='left'><b>" . $this->_lang_module_disclaimer . "</b></td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td class='even' align='left'>" . $versioninfo->getInfo('warning') . "</td>";
			echo "</tr>";
			
			echo "</table>";
		}
		// Author's note
		if ($versioninfo->getInfo('author_word') != '') {
			echo "<br />\n";
			echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
			echo "<tr>";
			echo "<td class='bg3' align='left'><b>" . $this->_lang_author_word . "</b></td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td class='even' align='left'>" . $versioninfo->getInfo('author_word') . "</td>";
			echo "</tr>";
			
			echo "</table>";
		}
		
			
	    // For changelog thanks to 3Dev
	    $filename = PUBLISHER_ROOT_PATH ."/changelog.txt";
	    if(is_file($filename)){
	    	
			echo "<br />\n";
			echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
			echo "<tr>";
			echo "<td class='bg3' align='left'><b>" . $this->_lang_version_history . "</b></td>";
			echo "</tr>";
			
			echo "<tr>";
	        $filesize = filesize($filename);
	        $handle = fopen($filename, 'r');
			echo "<td class='even' align='left'><div style='line-height: 18px;'>".$myts->displayTarea(fread($handle, $filesize), true)."</div></td>";
	        fclose($handle);
			echo "</tr>";
			
			echo "</table>";

	    }
		echo "<br />";
		
		$modFooter = $versioninfo->getInfo('modFooter');
		
		if (false != $adminMenu && false != $modFooter) {
			if (function_exists($modFooter)) {
				$func = $modFooter;
				echo "<div align='center'>" . $func() . "</div>";
			}
		}
		
		xoops_cp_footer();
	}
	
}

?>
