<?php

/**
 * $Id: metagen.php,v 1.1 2005/05/13 18:22:03 malanciault Exp $
 * Module: SmartMedia
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

function smartmedia_createMetaDescription($description, $maxWords = 100)
{
    $myts =& MyTextSanitizer::getInstance();

    $words = array();
    $words = explode(" ", smartmedia_metagen_html2text($description));

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

function smartmedia_findMetaKeywords($text, $minChar)
{
    $myts =& MyTextSanitizer::getInstance();

    $keywords = array();
    $originalKeywords = explode(" ", smartmedia_metagen_html2text($text));
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

function smartmedia_createMetaTags($title, $categoryPath='', $description = '', $minChar=4)
{
    global $xoopsTpl, $xoopsModule, $xoopsModuleConfig;
    $myts =& MyTextSanitizer::getInstance();

    $ret = '';

    $title = $myts->displayTarea($title);
    $title = $myts->undoHtmlSpecialChars($title);

    If (isset($categoryPath)) {
        $categoryPath = $myts->displayTarea($categoryPath);
        $categoryPath = $myts->undoHtmlSpecialChars($categoryPath);
    }

    // Creating Meta Keywords
    If (isset($title) && ($title != '')) {
        $keywords = smartmedia_findMetaKeywords($title, $minChar);

        If (isset($xoopsModuleConfig) && isset($xoopsModuleConfig['moduleMetaKeywords']) && $xoopsModuleConfig['moduleMetaKeywords'] != '') {
            $moduleKeywords = explode(",", $xoopsModuleConfig['moduleMetaKeywords']);
            foreach ($moduleKeywords as $moduleKeyword) {
                If (!in_array($moduleKeyword, $keywords)) {
                    $keywords[] = trim($moduleKeyword);
                }
            }
        }

        $keywordsCount = count($keywords);
        for ($i = 0; $i < $keywordsCount; $i++) {
            $ret .= $keywords[$i];
            if ($i < $keywordsCount -1) {
                $ret .= ', ';
            }
        }

        $xoopsTpl->assign('xoops_meta_keywords', $ret);
    }
    // Creating Meta Description
    If ($description != '') {
        $xoopsTpl->assign('xoops_meta_description', smartmedia_createMetaDescription($description));
    }
    	
    // Creating Page Title
    $moduleName = '';
    $titleTag = array();

    If (isset($xoopsModule)) {
        $moduleName = $myts->displayTarea($xoopsModule->name());
        $titleTag['module'] = $moduleName;
    }

    If (isset($title) && ($title != '') && (strtoupper($title) != strtoupper($moduleName))) {
        $titleTag['title'] = $title;
    }

    If (isset($categoryPath) && ($categoryPath != '')) {
        $titleTag['category'] = $categoryPath;
    }

    $ret = '';

    If (isset($titleTag['title']) && $titleTag['title'] != '') {
        $ret .= smartmedia_metagen_html2text($titleTag['title']);
    }

    If (isset($titleTag['category']) && $titleTag['category'] != '') {
        If ($ret != '') {
            $ret .= ' - ';
        }
        $ret .= $titleTag['category'];
    }
    If (isset($titleTag['module']) && $titleTag['module'] != '') {
        If ($ret != '') {
            $ret .= ' - ';
        }
        $ret .= $titleTag['module'];
    }
    $xoopsTpl->assign('xoops_pagetitle', $ret);


}

?>