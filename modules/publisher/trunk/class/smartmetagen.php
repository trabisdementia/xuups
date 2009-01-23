<?php

/**
 * Containing the class to manage meta informations of the SmartObject framework
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>
 * @version $Id: smartmetagen.php 331 2007-12-23 16:01:11Z malanciault $
 * @link http://smartfactory.ca The SmartFactory
 * @package SmartObject
 * @subpackage SmartObjectCore
 */

if (!defined("XOOPS_ROOT_PATH")) {
die("XOOPS root path not defined");
}

/**
* Class MetaGen is a class providing some methods to dynamically and automatically customize Meta Tags information
* @author The SmartFactory <www.smartfactory.ca>
*/

class PublisherMetaGen
{

	var $_myts;

	var $_title;
	var $_original_title;
	var $_keywords;
	var $_meta_description;
	var $_categoryPath;
	var $_description;
	var $_minChar = 4;

	function PublisherMetaGen($title, $keywords=false, $description=false, $categoryPath=false)
	{
		$this->_myts = MyTextSanitizer::GetInstance();
		$this->setCategoryPath($categoryPath);
		$this->setTitle($title);

		$this->setDescription($description);

		if (!$keywords) {
			$keywords = $this->createMetaKeywords();
		}

		$myts = MyTextSanitizer::getInstance();
		if (method_exists($myts, 'formatForML')) {
			$keywords = $myts->formatForML($keywords);
			$description = $myts->formatForML($description);
		}

		$this->setKeywords($keywords);
	}

	/**
 	* Return true if the string is length > 0
 	*
 	* @credit psylove
 	*
 	* @var string $string Chaine de caract�re
	 * @return boolean
 	*/
	function emptyString($var)
	{
   		return (strlen($var) > 0);
	}

	/**
	 * Create a title for the short_url field of an article
	 *
	 * @credit psylove
	 *
	 * @var string $title title of the article
	 * @var string $withExt do we add an html extension or not
	 * @return string sort_url for the article
	 */
	function generateSeoTitle($title='', $withExt=true) {
	    // Transformation de la chaine en minuscule
	    // Codage de la chaine afin d'�viter les erreurs 500 en cas de caract�res impr�vus
	    $title   = rawurlencode(strtolower($title));

	    // Transformation des ponctuations
	    //                 Tab     Space      !        "        #        %        &        '        (        )        ,        /        :        ;        <        =        >        ?        @        [        \        ]        ^        {        |        }        ~       .
	    $pattern = array("/%09/", "/%20/", "/%21/", "/%22/", "/%23/", "/%25/", "/%26/", "/%27/", "/%28/", "/%29/", "/%2C/", "/%2F/", "/%3A/", "/%3B/", "/%3C/", "/%3D/", "/%3E/", "/%3F/", "/%40/", "/%5B/", "/%5C/", "/%5D/", "/%5E/", "/%7B/", "/%7C/", "/%7D/", "/%7E/", "/\./");
	    $rep_pat = array(  "-"  ,   "-"  ,   "-"  ,   "-"  ,   "-"  , "-100" ,   "-"  ,   "-"  ,   "-"  ,   "-"  ,   "-"  ,   "-"  ,  "-"   ,   "-"  ,   "-"  ,   "-"  ,  "-"   ,   "-"  , "-at-" ,   "-"  ,   "-"   ,  "-"  ,   "-"  ,   "-"  ,   "-"  ,   "-"  ,   "-"  ,   "-" );
	    $title   = preg_replace($pattern, $rep_pat, $title);

    	// Transformation des caract�res accentu�s
    	//                  �        �        �        �        �        �        �        �        �        �        �        �        �        �        �        �
    	$pattern = array("/%B0/", "/%E8/", "/%E9/", "/%EA/", "/%EB/", "/%E7/", "/%E0/", "/%E2/", "/%E4/", "/%EE/", "/%EF/", "/%F9/", "/%FC/", "/%FB/", "/%F4/", "/%F6/");
	    $rep_pat = array(  "-"  ,   "e"  ,   "e"  ,   "e"  ,   "e"  ,   "c"  ,   "a"  ,   "a"  ,   "a"  ,   "i"  ,   "i"  ,   "u"  ,   "u"  ,   "u"  ,   "o"  ,   "o"  );
    	$title   = preg_replace($pattern, $rep_pat, $title);

		$tableau = explode("-", $title); // Transforme la chaine de caract�res en tableau
		$tableau = array_filter($tableau, array($this, "emptyString")); // Supprime les chaines vides du tableau
		$title   = implode("-", $tableau); // Transforme un tableau en chaine de caract�res s�par� par un tiret

	    if (sizeof($title) > 0)
	    {
	        if ($withExt) {
	            $title .= '.html';
	        }
	        return $title;
	    }
	    else
	        return '';
	}

	function html2text($document)
	{
		// PHP Manual:: function preg_replace
		// $document should contain an HTML document.
		// This will remove HTML tags, javascript sections
		// and white space. It will also convert some
		// common HTML entities to their text equivalent.
		// Credits : newbb2
		$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
		"'<img.*?/>'si",       // Strip out img tags
		"'<[\/\!]*?[^<>]*?>'si",          // Strip out HTML tags
		"'([\r\n])[\s]+'",                // Strip out white space
		"'&(quot|#34);'i",                // Replace HTML entities
		"'&(amp|#38);'i",
		"'&(lt|#60);'i",
		"'&(gt|#62);'i",
		"'&(nbsp|#160);'i",
		"'&(iexcl|#161);'i",
		"'&(cent|#162);'i",
		"'&(pound|#163);'i",
		"'&(copy|#169);'i",
		//"'&#(\d+);'e"
		);                    // evaluate as php

		$replace = array ("",
		"",
		"",
		"\\1",
		"\"",
		"&",
		"<",
		">",
		" ",
		chr(161),
		chr(162),
		chr(163),
		chr(169),
		//"chr(\\1)"
		);

		$text = preg_replace($search, $replace, $document);

		return $text;
	}

	function setTitle($title)
	{
		global $xoopsModule;

		$this->_title = $this->html2text($title);
		$this->_original_title = $this->_title;

		$moduleName = $xoopsModule->getVar('name');
		$titleTag = array();

		if ($moduleName) {
			$titleTag['module'] = $moduleName;
		}

		if (isset($this->_title) && ($this->_title != '') && (strtoupper($this->_title) != strtoupper($moduleName))) {
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
		$categoryPath = $this->html2text($categoryPath);
		$this->_categoryPath = $categoryPath;
	}

	function setDescription($description)
	{
		if (!$description) {
			global $xoopsModuleConfig;
			if (isset($xoopsModuleConfig['module_meta_description'])) {
				$description = $xoopsModuleConfig['module_meta_description'];
			}
		}

		$description = $this->html2text($description);

		$description = $this->purifyText($description);

		$this->_description = $description;
		$this->_meta_description = $this->createMetaDescription();
	}

	function createTitleTag()
	{

	}

	function purifyText($text, $keyword = false)
	{
		$text = str_replace('&nbsp;', ' ', $text);
		$text = str_replace('<br />', ' ', $text);
		$text = strip_tags($text);
		$text = html_entity_decode($text);
		$text = $this->_myts->undoHtmlSpecialChars($text);
		$text = str_replace(')', ' ', $text);
		$text = str_replace('(', ' ', $text);
		$text = str_replace(':', ' ', $text);
		$text = str_replace('&euro', ' euro ', $text);
		$text = str_replace('&hellip', '...', $text);
		$text = str_replace('&rsquo', ' ', $text);
		$text = str_replace('!', ' ', $text);
		$text = str_replace('?', ' ', $text);
		$text = str_replace('"', ' ', $text);
		$text = str_replace('-', ' ', $text);
		$text = str_replace('\n', ' ', $text);
		if ($keyword){
			$text = str_replace('.', ' ', $text);
			$text = str_replace(',', ' ', $text);
			$text = str_replace('\'', ' ', $text);
		}
		$text = str_replace(';', ' ', $text);

		return $text;
	}

	function createMetaDescription($maxWords = 100)
	{
		$words = array();
		$words = explode(" ", $this->_description);
		$words = array_filter($words, array($this, "emptyString")); // Supprime les chaines vides du tableau

		// Only keep $maxWords words
		$newWords = array();
		$i = 0;

		while ($i < $maxWords-1 && $i < count($words)) {
			if (isset($words[$i])) {
				$newWords[] = trim($words[$i]);
			}
			$i++;
		}
		$ret = implode(' ', $newWords);

		return $ret;
	}

	function findMetaKeywords($text, $minChar)
	{
		$keywords = array();

		$text = $this->purifyText($text, true);
		$text = $this->html2text($text);
		$originalKeywords = explode(" ", $text);
		foreach ($originalKeywords as $originalKeyword) {
			$originalKeyword = strtolower($originalKeyword);
			if (strlen($originalKeyword) >= $minChar) {
				if (!in_array($originalKeyword, $keywords)) {
					$keywords[] = $originalKeyword;
				}
			}
		}
/*
		foreach ($originalKeywords as $originalKeyword) {
			$secondRoundKeywords = explode("'", $originalKeyword);
			foreach ($secondRoundKeywords as $secondRoundKeyword) {
				if (strlen($secondRoundKeyword) >= $minChar) {
					if (!in_array($secondRoundKeyword, $keywords)) {
						$keywords[] = trim($secondRoundKeyword);
					}
				}
			}
		}
*/
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

		// Only take the first 90 keywords
		$newKeywords = array();
		$i = 0;
		while ($i < 90 - 1 && isset($keywords[$i])) {
			$newKeywords[] = $keywords[$i];
			$i++;
		}
		$ret = implode(', ', $newKeywords);

		return $ret;
	}

	function autoBuildMeta_keywords()
	{

	}

	function buildAutoMetaTags()
	{
		global $xoopsModule, $xoopsModuleConfig;

		$this->_keywords = $this->createMetaKeywords();
		$this->_meta_description = $this->createMetaDescription();
		$this->_title = $this->createTitleTag();
	}

	function createMetaTags()
	{
		global $xoopsTpl, $xoTheme;

		if (is_object($xoTheme)) {
			$xoTheme->addMeta( 'meta', 'keywords',$this->_keywords);
			$xoTheme->addMeta( 'meta', 'description',$this->_description);
			$xoTheme->addMeta( 'meta', 'title', $this->_title);
		} else {
			$xoopsTpl->assign('xoops_meta_keywords',$this->_keywords);
			$xoopsTpl->assign('xoops_meta_description',$this->_description);
		}
		$xoopsTpl->assign('xoops_pagetitle',$this->_title);
	}

}

?>
