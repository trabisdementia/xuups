<?php
/**
 * Article management
 *
 * Import data from news
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
			"		(cat_id,	cat_title,		cat_pid,	cat_image,		cat_description)".
			"	SELECT ".
			"		topic_id,	topic_title,	topic_pid,	topic_imgurl,	topic_description".
			" 	FROM ".$GLOBALS['xoopsDB']->prefix("topics").
			"		ORDER BY topic_id ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building CATEGORY table: ". $count = $xoopsDB->getAffectedRows());

$sql =	
			"	INSERT INTO ".art_DB_prefix("article").
			"		(art_id, 	art_title, 	cat_id,		uid,	art_keywords,	art_summary,	art_time_create,	art_time_submit,	art_time_publish, 	art_counter,	art_rating,				art_rates,	art_comments)".
			"	SELECT ".
			"		storyid,	title,		topicid,	uid,	keywords, 		hometext,		created,			created,			published,			counter,		FLOOR(rating * votes),	votes,		comments".
			" 	FROM ".$GLOBALS['xoopsDB']->prefix("stories").
			"		ORDER BY storyid ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building ARTICLE table: ".$count = $xoopsDB->getAffectedRows());


$sql =	
			"	INSERT INTO ".art_DB_prefix("artcat").
			"		(art_id, 	cat_id,		uid,	ac_register,	ac_publish)".
			"	SELECT ".
			"		storyid,	topicid,	uid,	created,		published".
			" 	FROM ".$GLOBALS['xoopsDB']->prefix("stories").
			"		ORDER BY storyid ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building ARTICLE-CATEGORY table: ".$count = $xoopsDB->getAffectedRows());


$sql =	
			"	INSERT INTO ".art_DB_prefix("text").
			"		(text_id,	art_id, 	text_body, 	dohtml,				dosmiley,			dobr,	doimage,	doxcode)".
			"	SELECT ".
			"		storyid,	storyid,	bodytext,	(2-nohtml) DIV 2,	(2-nosmiley) DIV 2,	1,		1,			1".
			" 	FROM ".$GLOBALS['xoopsDB']->prefix("stories").
			"		ORDER BY storyid ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building TEXT table: ".$count = $xoopsDB->getAffectedRows());


$sql =	
			"	INSERT INTO ".art_DB_prefix("rate").
			"		(rate_id,	art_id, 	uid, 		rate_rating,	rate_time)".
			"	SELECT ".
			"		ratingid,	storyid,	ratinguser,	rating,			ratingtimestamp".
			" 	FROM ".$GLOBALS['xoopsDB']->prefix("stories_votedata").
			"		ORDER BY ratingid ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building RATE table: ".$count = $xoopsDB->getAffectedRows());

?>