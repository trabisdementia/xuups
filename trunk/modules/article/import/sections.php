<?php
/**
 * Article management
 *
 * Import data from sections 1.00
 * Limit: section images will not be converted
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
			"		(cat_id,	cat_title)".
			"	SELECT ".
			"		secid,	secname".
			" 	FROM ".$GLOBALS['xoopsDB']->prefix("sections").
			"		ORDER BY secid ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building CATEGORY table: ". $count = $xoopsDB->getAffectedRows());

$uid = $xoopsUser->getVar("uid");
$time = time();
$sql =	
			"	INSERT INTO ".art_DB_prefix("article").
			"		(art_id, 	art_title, 	cat_id,		uid,	art_time_create,	art_time_submit,	art_time_publish, 	art_counter)".
			"	SELECT ".
			"		artid,		title,		secid,		{$uid},	{$time},			{$time},			{$time},			counter".
			" 	FROM ".$GLOBALS['xoopsDB']->prefix("seccont").
			"		ORDER BY artid ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building ARTICLE table: ".$count = $xoopsDB->getAffectedRows());


$sql =	
			"	INSERT INTO ".art_DB_prefix("artcat").
			"		(art_id, 	cat_id,		uid,	ac_register,	ac_publish)".
			"	SELECT ".
			"		artid,		secid,		{$uid},	{$time},		{$time}".
			" 	FROM ".$GLOBALS['xoopsDB']->prefix("seccont").
			"		ORDER BY artid ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building ARTICLE-CATEGORY table: ".$count = $xoopsDB->getAffectedRows());


$sql =	
			"	INSERT INTO ".art_DB_prefix("text").
			"		(text_id,	art_id, 	text_body, 	dohtml,		dosmiley,	dobr,	doimage,	doxcode)".
			"	SELECT ".
			"		artid,		artid,		content,	1,			1,			1,		1,			1".
			" 	FROM ".$GLOBALS['xoopsDB']->prefix("seccont").
			"		ORDER BY artid ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building TEXT table: ".$count = $xoopsDB->getAffectedRows());
?>