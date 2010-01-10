<?php
/**
 * Article management
 *
 * Import data from xfsection 1.12
 * Limit: files will not be converted
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
			"		id,			title,			pid,		description".
			" 	FROM ".$GLOBALS['xoopsDB']->prefix("xfs_category").
			"		ORDER BY id ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building CATEGORY table: ". $count = $xoopsDB->getAffectedRows());


$sql =	
			"	INSERT INTO ".art_DB_prefix("article").
			"		(art_id, 	art_title, 	cat_id,		uid,	art_summary,	art_time_create,	art_time_submit,	art_time_publish, 	art_counter,	art_rating,				art_rates)".
			"	SELECT ".
			"		articleid,	title,		categoryid,	uid,	summary,		created,			created,			created,			counter,		FLOOR(rating * votes),	votes".
			" 	FROM ".$GLOBALS['xoopsDB']->prefix("xfs_article").
			"		ORDER BY articleid ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building ARTICLE table: ".$count = $xoopsDB->getAffectedRows());


$sql =	
			"	INSERT INTO ".art_DB_prefix("artcat").
			"		(art_id, 	cat_id,		uid,	ac_register,	ac_publish)".
			"	SELECT ".
			"		articleid,	categoryid,	uid,	created,		created".
			" 	FROM ".$GLOBALS['xoopsDB']->prefix("xfs_article").
			"		ORDER BY articleid ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building ARTICLE-CATEGORY table: ".$count = $xoopsDB->getAffectedRows());


$sql =	
			"	INSERT INTO ".art_DB_prefix("text").
			"		(text_id,	art_id, 	text_body, 	dohtml,				dosmiley,			dobr,	doimage,	doxcode)".
			"	SELECT ".
			"		articleid,	articleid,	maintext,	(2-nohtml) DIV 2,	(2-nosmiley) DIV 2,	1,		1,			1".
			" 	FROM ".$GLOBALS['xoopsDB']->prefix("xfs_article").
			"		ORDER BY articleid ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building TEXT table: ".$count = $xoopsDB->getAffectedRows());


$sql =	
			"	INSERT INTO ".art_DB_prefix("rate").
			"		(rate_id,	art_id, 	uid, 		rate_rating,	rate_time)".
			"	SELECT ".
			"		ratingid,	lid,		ratinguser,	rating,			ratingtimestamp".
			" 	FROM ".$GLOBALS['xoopsDB']->prefix("xfs_votedata").
			"		ORDER BY ratingid ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building RATE table: ".$count = $xoopsDB->getAffectedRows());

?>