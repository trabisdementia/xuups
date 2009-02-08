<?php

/**
* $Id: metagen.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

/**
* Class MetaGen is a class providing some methods todynamically customize Meta Tags information
* @author The SmartFactory <www.smartfactory.ca>
*/

class PublisherMetagen
{
	
	var $_myts;
	
	var $_title;
	var $_original_title;
	var $_keywords;
	var $_categoryPath;
	var $_description;
	var $_minChar = 4;
	
	function PublisherMetagen($title, $keywords, $description, $categoryPath = false)
	{
		$this->_myts = MyTextSanitizer::GetInstance();
		
		$this->setCategoryPath($categoryPath);
		$this->setTitle($title);		
		$this->setDescription($description);
		
		if (!$keywords) {
			$keywords = $this->createMetaKeywords();
		}
		$this->setKeywords($keywords);		
	}	
	
	function setTitle($title)
	{
		$this->_title = publisher_metagen_html2text($title);
		$this->_original_title = $this->_title;

		global $publisher_moduleName;
		
		$moduleName = '';
		$titleTag = array();
		
		if (isset($publisher_moduleName)) {
			$titleTag['module'] = $publisher_moduleName;
		}

		if (isset($this->_title) && ($this->_title != '') && (strtoupper($this->_title) != strtoupper($publisher_moduleName))) {
			$titleTag['title'] = $this->_title;
		}

		if (isset($this->_categoryPath) && ($this->_categoryPath != '')) {
			$titleTag['category'] = $this->_categoryPath;
		}

		$ret = isset($titleTag['title']) ? $titleTag['title'] : '';
	
		if (isset($titleTag['category']) && $titleTag['category'] != '') {
			if ($ret != '') {
				$ret .= ' - ';
			}
			$ret .= $titleTag['category'];
		}

        if (isset($titleTag['module']) && $titleTag['module'] != '') {
			if ($ret != '') {
				$ret .= ' - ';
			}
			$ret .= $titleTag['module'];
		}
		
		$this->_title = $ret;		
	}
	
	function setKeywords($keywords)
	{
		$this->_keywords = $keywords;		
	}	

	function setCategoryPath($categoryPath)
	{
		$categoryPath = publisher_metagen_html2text($categoryPath);	
		$this->_categoryPath = $categoryPath;	
	}	
	
	function setDescription($description)
	{
		$description = publisher_metagen_html2text($description);		
		$description = $this->purifyText($description);
		$this->_description = $description;		
	}
	
	function createTitleTag()
	{

	}
	
	function purifyText($text)
	{
		$text = str_replace('&nbsp;', ' ', $text);
		$text = str_replace('<br />', ' ', $text);
		$text = strip_tags($text);
		$text = html_entity_decode($text);
		$text = $this->_myts->undoHtmlSpecialChars($text);
		$text = str_replace('. ', ' ', $text);
		$text = str_replace(', ', ' ', $text);
		$text = str_replace(')', '', $text);
		$text = str_replace('(', '', $text);
		$text = str_replace(':', '', $text);
		$text = str_replace('&euro', '', $text);
		$text = str_replace(';', '', $text);	
		$text = str_replace('!', ' ', $text);	
		$text = str_replace('?', ' ', $text);	
		
		return $text;
	}

	function createMetaDescription($maxWords = 30)
	{
		$description = $this->purifyText($description);
		$description = publisher_metagen_html2text($description);	
		
		$words = array();
		$words = explode(" ", $description);
		
		$ret = '';
		$i = 1;
		$wordCount = count($words);
		foreach ($words as $word) {
			$ret .= $word;
			if ($i < $wordCount) {
				$ret .= ' ';
			}
			$i++;
		}
	
		return $ret;
	}

	function findMetaKeywords($text, $minChar)
	{
		$keywords = array();
		
		$text = $this->purifyText($text);
		$text = publisher_metagen_html2text($text);
		
		$originalKeywords = explode(" ", $text);
		foreach ($originalKeywords as $originalKeyword) {
			$secondRoundKeywords = explode("'", $originalKeyword);
			foreach ($secondRoundKeywords as $secondRoundKeyword) {
				If (strlen($secondRoundKeyword) >= $minChar) {
					if (!in_array($secondRoundKeyword, $keywords)) {
						$keywords[] = trim($secondRoundKeyword);
					}
				}
			}
		}
		return $keywords;
	}

	function createMetaKeywords() 
	{
		global $xoopsModuleConfig;
		$keywords = $this->findMetaKeywords($this->_original_title . " " . $this->_description, $this->_minChar);

		if (isset($xoopsModuleConfig) && isset($xoopsModuleConfig['moduleMetaKeywords']) && $xoopsModuleConfig['moduleMetaKeywords'] != '') {
			$moduleKeywords = explode(",", $xoopsModuleConfig['moduleMetaKeywords']);
			$keywords = array_merge($keywords, $moduleKeywords);
		}
		
		/* Commenting this out as it may cause problem on XOOPS ML websites
		$return_keywords = array();
		
		// Cleaning for duplicate keywords
		foreach ($keywords as $keyword) {
			if (!in_array($keyword, $keywords)) {
				$return_keywords[] = trim($keyword);
			}
		}*/

		$ret = implode(', ', $keywords);
		
		return $ret;
	}
	
	function autoBuildMeta_keywords()
	{
		
	}
	
	function buildAutoMetaTags()
	{
		global $xoopsModule, $xoopsModuleConfig;
		
		$this->_keywords = $this->createMetaKeywords();
		$this->_description = $this->createMetaDescription();
		$this->_title = $this->createTitleTag();
	
	}
	
	function createMetaTags()
	{
		global $xoopsTpl;
		
		$xoopsTpl->assign('xoops_meta_keywords',$this->_keywords);
		$xoopsTpl->assign('xoops_meta_description',$this->_description);
		$xoopsTpl->assign('xoops_pagetitle',$this->_title);
	}	
	
}

?>
