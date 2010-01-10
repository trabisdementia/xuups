<?php
/**
 * Article management
 *
 * Import data from smartsection
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		module::article
 */

$sql =	
			"	INSERT INTO ".art_DB_prefix("category").
			"		(cat_id,	cat_title,		cat_pid,	cat_description)".
			"	SELECT ".
			"		categoryid,	name,			parentid,	description".
			" 	FROM ".$GLOBALS['xoopsDB']->prefix("smartsection_categories").
			"		ORDER BY categoryid ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building CATEGORY table: ". $count = $xoopsDB->getAffectedRows());


$sql =	
			"	INSERT INTO ".art_DB_prefix("article").
			"		(art_id, 	art_title, 	cat_id,		uid,	art_keywords,	art_summary,	art_time_create,	art_time_submit,	art_time_publish, 	art_counter,	art_comments)".
			"	SELECT ".
			"		itemid,		title,		categoryid,	uid,	meta_keywords, 	summary,		datesub,			datesub,			datesub,			counter,		comments".
			" 	FROM ".$GLOBALS['xoopsDB']->prefix("smartsection_items").
			"		ORDER BY itemid ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building ARTICLE table: ".$count = $xoopsDB->getAffectedRows());


$sql =	
			"	INSERT INTO ".art_DB_prefix("artcat").
			"		(art_id, 	cat_id,		uid,	ac_register,	ac_publish)".
			"	SELECT ".
			"		itemid,	categoryid,	uid,	datesub,		datesub".
			" 	FROM ".$GLOBALS['xoopsDB']->prefix("smartsection_items").
			"		ORDER BY itemid ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building ARTICLE-CATEGORY table: ".$count = $xoopsDB->getAffectedRows());


$sql =	
			"	INSERT INTO ".art_DB_prefix("text").
			"		(text_id,	art_id, 	text_body, 	dohtml,		dosmiley,	dobr,	doimage,	doxcode)".
			"	SELECT ".
			"		itemid,		itemid,		body,		dohtml,		dosmiley,	dobr,	doimage,	doxcode".
			" 	FROM ".$GLOBALS['xoopsDB']->prefix("smartsection_items").
			"		ORDER BY itemid ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building TEXT table: ".$count = $xoopsDB->getAffectedRows());

?>