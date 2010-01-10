<?php
/**
 * Article management
 *
 * Export data to news
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		module::article
 */

$sql =	
			"	INSERT INTO ".$GLOBALS['xoopsDB']->prefix("topics").
			"		(topic_id,	topic_title,	topic_pid,	topic_imgurl,	topic_description)".
			"	SELECT ".
			"		cat_id,		cat_title,		cat_pid,	cat_image,		cat_description".
			" 	FROM ".art_DB_prefix("category").
			"		ORDER BY cat_id ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building CATEGORY table: ". $count = $xoopsDB->getAffectedRows());


$sql =	
			"	INSERT INTO ".$GLOBALS['xoopsDB']->prefix("stories").
			"		(storyid,	title,		topicid,	uid,	keywords, 		hometext,		created,			published,			counter,		rating,							votes,		comments,".
			"		bodytext,	nohtml,		nosmiley)".
			"	SELECT ".
			"		a.art_id, 	a.art_title, 	a.cat_id,		a.uid,	a.art_keywords,	a.art_summary,	a.art_time_create,	a.art_time_publish, 	a.art_counter,	FLOOR(a.art_rating/a.art_rates),	a.art_rates,	a.art_comments,".
			"		t.text_body,	(2-t.dohtml) DIV 2,	(2-t.dosmiley) DIV 2".
			" 	FROM ".art_DB_prefix("article")." AS a, ".art_DB_prefix("text")." AS t".
			"	WHERE a.art_id = t.art_id".
			"		ORDER BY art_id ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building ARTICLE table: ".$count = $xoopsDB->getAffectedRows());


$sql =	
			"	INSERT INTO ".$GLOBALS['xoopsDB']->prefix("stories_votedata").
			"		(ratingid,	storyid,	ratinguser,	rating,			ratingtimestamp)".
			"	SELECT ".
			"		rate_id,	art_id, 	uid, 		rate_rating,	rate_time".
			" 	FROM ".art_DB_prefix("rate").
			"		ORDER BY rate_id ASC"
			;

$result = $xoopsDB->queryF($sql);
xoops_result("succeed with building RATE table: ".$count = $xoopsDB->getAffectedRows());

?>