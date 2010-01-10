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
			"	INSERT INTO ".$GLOBALS['xoopsDB']->prefix("smartsection_categories").
			"		(categoryid,	name,			parentid,	description)".
			"	SELECT ".
			"		cat_id,			cat_title,		cat_pid,	cat_description".
			" 	FROM ".art_DB_prefix("category").
			"		ORDER BY cat_id ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building CATEGORY table: ". $count = $xoopsDB->getAffectedRows());


$sql =	
			"	INSERT INTO ".$GLOBALS['xoopsDB']->prefix("smartsection_items").
			"		(itemid,		title,		categoryid,		uid,	meta_keywords, 	summary,		datesub,				counter,		comments,		status,".
			"		body, 			dohtml,		dosmiley,		dobr,	doimage,	doxcode)".
			"	SELECT ".
			"		a.art_id, 	a.art_title, 	a.cat_id,		a.uid,	a.art_keywords,	a.art_summary,	a.art_time_submit,		a.art_counter,	a.art_comments,	2,".
			"		t.text_body,	t.dohtml,	t.dosmiley,		t.dobr,	t.doimage,	t.doxcode".
			" 	FROM ".art_DB_prefix("article")." AS a, ".art_DB_prefix("text")." AS t".
			"	WHERE a.art_id = t.art_id".
			"		ORDER BY art_id ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building ARTICLE table: ".$count = $xoopsDB->getAffectedRows());

?>