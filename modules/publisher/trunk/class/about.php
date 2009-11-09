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
 *  Publisher class
 *
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Class
 * @subpackage      Utils
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: about.php 0 2009-06-11 18:47:04Z trabis $
 */

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once dirname(dirname(__FILE__)) . '/include/common.php';

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
	var $_tpl;

	function PublisherAbout($aboutTitle = 'About')
	{
		$this->_aboutTitle = $aboutTitle;
		$this->_lang_developer_contributor = _MI_PUBLISHER_DEVELOPER_CONTRIBUTOR;
		$this->_lang_developer_website = _MI_PUBLISHER_DEVELOPER_WEBSITE;
		$this->_lang_developer_email = _MI_PUBLISHER_DEVELOPER_EMAIL;
		$this->_lang_developer_credits = _MI_PUBLISHER_DEVELOPER_CREDITS;
		$this->_lang_module_info = _MI_PUBLISHER_MODULE_INFO;
		$this->_lang_module_status = _MI_PUBLISHER_MODULE_STATUS;
		$this->_lang_module_release_date =_MI_PUBLISHER_MODULE_RELEASE_DATE ;
		$this->_lang_module_demo = _MI_PUBLISHER_MODULE_DEMO;
		$this->_lang_module_support = _MI_PUBLISHER_MODULE_SUPPORT;
		$this->_lang_module_bug = _MI_PUBLISHER_MODULE_BUG;
		$this->_lang_module_submit_bug = _MI_PUBLISHER_MODULE_SUBMIT_BUG;
		$this->_lang_module_feature = _MI_PUBLISHER_MODULE_FEATURE;
		$this->_lang_module_submit_feature = _MI_PUBLISHER_MODULE_SUBMIT_FEATURE;
		$this->_lang_module_disclaimer = _MI_PUBLISHER_MODULE_DISCLAIMER;
		$this->_lang_author_word = _MI_PUBLISHER_AUTHOR_WORD;
		$this->_lang_version_history = _MI_PUBLISHER_VERSION_HISTORY;

	}

	function sanitize($value) {
		$myts = MyTextSanitizer::getInstance();
		return $myts->displayTarea($value, 1);
	}

	function render()
	{
		/**
		 * @todo move the output to a template
		 * @todo make the output XHTML compliant
		 */
		$myts = &MyTextSanitizer::getInstance();
        $publisher = PublisherPublisher::getInstance();

		publisher_cpHeader();

		publisher_adminmenu(-1);

		include_once XOOPS_ROOT_PATH . '/class/template.php';

		$this->_tpl =& new XoopsTpl();

		$this->_tpl->assign('module_url', PUBLISHER_URL);
		$this->_tpl->assign('module_image', $publisher->getModule()->getInfo('image'));
		$this->_tpl->assign('module_name', $publisher->getModule()->getInfo('name'));
		$this->_tpl->assign('module_version', $publisher->getModule()->getInfo('version'));
		$this->_tpl->assign('module_status_version', $publisher->getModule()->getInfo('status_version'));

		// Left headings...
		if ($publisher->getModule()->getInfo('author_realname') != '') {
			$author_name = $publisher->getModule()->getInfo('author') . ' (' . $publisher->getModule()->getInfo('author_realname') . ')';
		} else {
			$author_name = $publisher->getModule()->getInfo('author');
		}
		$this->_tpl->assign('module_author_name', $author_name);

		$this->_tpl->assign('module_license', $publisher->getModule()->getInfo('license'));

		$this->_tpl->assign('module_credits', $publisher->getModule()->getInfo('credits'));

		// Developers Information
		$this->_tpl->assign('module_developer_lead', $publisher->getModule()->getInfo('developer_lead'));
		$this->_tpl->assign('module_developer_contributor', $publisher->getModule()->getInfo('developer_contributor'));
		$this->_tpl->assign('module_developer_website_url', $publisher->getModule()->getInfo('developer_website_url'));
		$this->_tpl->assign('module_developer_website_name', $publisher->getModule()->getInfo('developer_website_name'));
		$this->_tpl->assign('module_developer_email', $publisher->getModule()->getInfo('developer_email'));

		$people = $publisher->getModule()->getInfo('people');
		if ($people) {

			$this->_tpl->assign('module_people_developers', isset($people['developers']) ? array_map(array($this, 'sanitize'), $people['developers']) : false);
			$this->_tpl->assign('module_people_testers', isset($people['testers']) ? array_map(array($this, 'sanitize'), $people['testers']) : false);
			$this->_tpl->assign('module_people_translaters', isset($people['translaters']) ? array_map(array($this, 'sanitize'), $people['translaters']) : false);
			$this->_tpl->assign('module_people_documenters', isset($people['documenters']) ? array_map(array($this, 'sanitize'), $people['documenters']) : false);
			$this->_tpl->assign('module_people_other', isset($people['other']) ? array_map(array($this, 'sanitize'), $people['other']) : false);
		}
		//$this->_tpl->assign('module_developers', $publisher->getModule()->getInfo('developer_email'));

		// Module Development information
		$this->_tpl->assign('module_date', $publisher->getModule()->getInfo('date'));
		$this->_tpl->assign('module_status', $publisher->getModule()->getInfo('status'));
		$this->_tpl->assign('module_demo_site_url', $publisher->getModule()->getInfo('demo_site_url'));
		$this->_tpl->assign('module_demo_site_name', $publisher->getModule()->getInfo('demo_site_name'));
		$this->_tpl->assign('module_support_site_url', $publisher->getModule()->getInfo('support_site_url'));
		$this->_tpl->assign('module_support_site_name', $publisher->getModule()->getInfo('support_site_name'));
		$this->_tpl->assign('module_submit_bug', $publisher->getModule()->getInfo('submit_bug'));
		$this->_tpl->assign('module_submit_feature', $publisher->getModule()->getInfo('submit_feature'));

		// Warning
		$this->_tpl->assign('module_warning', $this->sanitize($publisher->getModule()->getInfo('warning')));

		// Author's note
		$this->_tpl->assign('module_author_word', $publisher->getModule()->getInfo('author_word'));

	    // For changelog thanks to 3Dev
	    $filename = PUBLISHER_ROOT_PATH . '/changelog.txt';
	    if(is_file($filename)){

	        $filesize = filesize($filename);
	        $handle = fopen($filename, 'r');
	        $this->_tpl->assign('module_version_history', $myts->displayTarea(fread($handle, $filesize), true));
	        fclose($handle);
	    }

		$this->_tpl->display(PUBLISHER_ROOT_PATH . '/templates/static/publisher_about.html');

		xoops_cp_footer();
	}
}
?>
