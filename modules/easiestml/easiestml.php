<?php
/*** THE EASIEST MULTILANGUAGE HACK  by GIJOE  ***/

// CONFIGURATIONS BEGIN

// list the language tags separated with comma
//define('EASIESTML_LANGS','xlang:en,xlang:ja'); // This is a sample of long pattern against tag misunderstanding [xlang:en]english[/xlang:en]
define('EASIESTML_LANGS','en,ja,fr'); // [en]english[/en]  [ja]japananese[/ja] common

//hack by trabis
define('EASIESTML_LANGDIRS','english,japanese,french');
//end of hack by trabis

// list the language images separated with comma
define('EASIESTML_LANGIMAGES','images/english.gif,images/japanese.gif,images/french.gif');

// list the language names separated with comma (these will be alt of <img>)
define('EASIESTML_LANGNAMES','in english,in japanese,in french');

// list language - accept_chaset patterns (perl regex) separated with comma
define('EASIESTML_ACCEPT_CHARSET_REGEXES',',/shift_jis/i');

// list language - accept_language patterns (perl regex) separated with comma
define('EASIESTML_ACCEPT_LANGUAGE_REGEXES','/^en/,/^ja/,/^fr/');

// charset in Content-Type separated with comma (only for fastestcache)
define('EASIESTML_CHARSETS','ISO-8859-1,EUC-JP,UTF-8');

// tag name for language image  (default [mlimg]. don't include specialchars)
define('EASIESTML_IMAGETAG','mlimg');

// make regular expression which disallows language tags to cross it
define('EASIESTML_NEVERCROSSREGEX','/\<\/table\>/');

// the life time of language selection stored in cookie
define('EASIESTML_COOKIELIFETIME',365*86400);

// default language
define('EASIESTML_DEFAULT_LANG',0);

// post merger  eg) <input name="subject[en]"> and <input name="subject[ja]">
define('EASIESTML_USEPOSTMERGER',0);

// CONFIGURATIONS END


// Patch check
// Hacked by trabis
defined('XOOPS_ROOT_PATH') or die('Restricted access');
global $easiestml_langs, $easiestml_lang, $easiestml_charset, $xoopsUser;
// End of hack

// Target check
if( ! preg_match( '?'.preg_quote(XOOPS_ROOT_PATH,'?').'(/modules/[^\/]+/admin/|/common/|/modules/system/|/admin\.php)?' , $_SERVER['SCRIPT_FILENAME'] ) ) {

	// get cookie path
	$xoops_cookie_path = defined('XOOPS_COOKIE_PATH') ? XOOPS_COOKIE_PATH : preg_replace( '?http://[^/]+(/.*)$?' , "$1" , XOOPS_URL ) ;
	if( $xoops_cookie_path == XOOPS_URL ) $xoops_cookie_path = '/' ;

	// for modrewrite
	if( empty( $_GET['easiestml_lang'] ) && preg_match( '#[/?&]easiestml_lang[=/]([0-9a-zA-Z%]{1,12})#' , $_SERVER['REQUEST_URI'] , $regs ) ) {
		$_GET['easiestml_lang'] = urldecode( $regs[ 1 ] ) ;
	}

	// deciding the current language (the priority is important)
	$easiestml_langs = explode( ',' , EASIESTML_LANGS ) ;
	$easiestml_charsets = explode( ',' , EASIESTML_CHARSETS ) ;
	if( ! empty( $_GET['easiestml_lang'] ) && $_GET['easiestml_lang'] == 'all' ) {
		// set by GET (all)
		$easiestml_lang = 'all' ;
	} else if( ! empty( $_GET['easiestml_lang'] ) && ( $offset = array_search( $_GET['easiestml_lang'] , $easiestml_langs ) ) !== false ) {
		// set by GET (other than all)
		$easiestml_lang = $_GET['easiestml_lang'] ;
		$easiestml_charset = $easiestml_charsets[ $offset ] ;
		setcookie( 'easiestml_lang' , $easiestml_lang , time() + EASIESTML_COOKIELIFETIME , $xoops_cookie_path, '' , 0 ) ;
	} else if( ! empty( $_COOKIE['easiestml_lang'] ) && ( $offset = array_search( $_COOKIE['easiestml_lang'] , $easiestml_langs ) ) !== false ) {
		// set by COOKIE (other than all)
		$easiestml_lang = $_COOKIE['easiestml_lang'] ;
		$easiestml_charset = $easiestml_charsets[ $offset ] ;
	} else if( ! empty( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) ) {
		// set by HTTP_ACCEPT_LANGUAGE pattern
		$offset = 0 ;
		foreach( explode( ',' , EASIESTML_ACCEPT_LANGUAGE_REGEXES ) as $pattern ) {
			if( $pattern && preg_match( $pattern , $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) ) {
				$easiestml_lang = $easiestml_langs[ $offset ] ;
				$easiestml_charset = $easiestml_charsets[ $offset ] ;
				break ;
			}
			$offset ++ ;
		}
	} else if( ! empty( $_SERVER['HTTP_ACCEPT_CHARSET'] ) ) {
		// set by HTTP_ACCEPT_CHARSET pattern
		$offset = 0 ;
		foreach( explode( ',' , EASIESTML_ACCEPT_CHARSET_REGEXES ) as $pattern ) {
			if( $pattern && preg_match( $pattern , $_SERVER['HTTP_ACCEPT_CHARSET'] ) ) {
				$easiestml_lang = $easiestml_langs[ $offset ] ;
				$easiestml_charset = $easiestml_charsets[ $offset ] ;
				break ;
			}
			$offset ++ ;
		}
	}

	if( empty( $easiestml_lang ) ) {
		$easiestml_lang = $easiestml_langs[EASIESTML_DEFAULT_LANG] ;
		$easiestml_charset = $easiestml_charsets[EASIESTML_DEFAULT_LANG] ;
	}

	// merge posts eg) subject[ja] and subject[en]
	if( @EASIESTML_USEPOSTMERGER && ! empty( $_POST ) ) {
		easiestml_post_merge( $_POST ) ;
	}
	// charset for Content-Type

	ob_start( 'easiestml' ) ;
}


// post merger
function easiestml_post_merge( &$data )
{
	global $easiestml_langs;

	$merged_string = '' ;
	$langs_counter = 0 ;
	foreach( array_keys( $data ) as $index ) {
		if( is_array( $data[ $index ] ) ) {
			easiestml_post_merge( $data[ $index ] ) ;
		} else if( in_array( $index , $easiestml_langs ) ) {
			$merged_string .= '['.$index.']'.$data[ $index ].'[/'.$index.']' ;
			$langs_counter ++ ;
		}
	}

	if( $langs_counter == sizeof( $easiestml_langs ) ) {
		$data = $merged_string ;
	}
}


// ob filter
function easiestml( $s , $lang = '' )
{
	global $xoopsUser ;

	$easiestml_lang = @$GLOBALS['easiestml_lang'] ;

	// all mode for debug (allowed to system admin only)
	if( is_object( $xoopsUser ) && $xoopsUser->isAdmin(1) && ! empty( $_GET['easiestml_lang'] ) && $_GET['easiestml_lang'] == 'all' ) {
		return $s ;
	}

	$easiestml_langs = explode( ',' , EASIESTML_LANGS ) ;
	// protection against some injection
	if( ! in_array( $easiestml_lang , $easiestml_langs ) ) {
		$easiestml_lang = $easiestml_langs[0] ;
	}

	// manual language $lang parameter
	if( $lang && in_array( $lang , $easiestml_langs ) ) {
		$easiestml_lang = $lang ;
	}

	// escape brackets inside of <input type="text" value="...">
//	$s = preg_replace_callback( '/(\<input)(?=.*type\=[\'\"]?text[\'\"]?)([^>]*)(\>)/isU' , 'easiestml_escape_bracket' , $s ) ;
	$s = preg_replace_callback( '/(\<input)([^>]*)(\>)/isU' , 'easiestml_escape_bracket_textbox' , $s ) ;

	// escape brackets inside of <textarea></textarea>
	$s = preg_replace_callback( '/(\<textarea[^>]*\>)(.*)(<\/textarea\>)/isU' , 'easiestml_escape_bracket_textarea' , $s ) ;

	// multilanguage image tag
	$langimages = explode( ',' , EASIESTML_LANGIMAGES ) ;
	$langnames = explode( ',' , EASIESTML_LANGNAMES ) ;
	if( empty( $_SERVER['QUERY_STRING'] ) ) {
		$link_base = basename($_SERVER['SCRIPT_NAME']).'?easiestml_lang=' ;
	} else if( ( $pos = strpos($_SERVER['QUERY_STRING'],'easiestml_lang=') ) === false ) {
		$link_base = basename($_SERVER['SCRIPT_NAME']) . '?' . htmlspecialchars($_SERVER['QUERY_STRING'],ENT_QUOTES) . '&amp;easiestml_lang=' ;
	} else if( $pos < 2 ) {
		$link_base = basename($_SERVER['SCRIPT_NAME']).'?easiestml_lang=' ;
	} else {
		$link_base = basename($_SERVER['SCRIPT_NAME']) . '?' . htmlspecialchars(substr($_SERVER['QUERY_STRING'],0,$pos-1),ENT_QUOTES) . '&amp;easiestml_lang=' ;
	}
	$langimage_html = '' ;
	foreach( $easiestml_langs as $l => $lang ) {
		$langimage_html .= '<a href="'.$link_base.urlencode($lang).'"><img src="'.XOOPS_URL.'/'.$langimages[$l].'" alt="'.$langnames[$l].'" /></a> ' ;
	}
	$s = preg_replace( '/\['.EASIESTML_IMAGETAG.'\]/' , $langimage_html , $s ) ;

	// create the pattern between language tags
	//$pqhtmltags = explode( ',' , preg_quote( EASIESTML_NEVERCROSSTAGS , '/' ) ) ;
	//$mid_pattern = '(?:(?!(' . implode( '|' , $pqhtmltags ) . ')).)*' ;

	// eliminate description between the other language tags.
	foreach( $easiestml_langs as $lang ) {
		if( $easiestml_lang == $lang ) continue ;
		$s = preg_replace_callback( '/\['.preg_quote($lang).'\].*\[\/'.preg_quote($lang).'(?:\]\<br \/\>|\])/isU' , 'easiestml_check_nevercross' , $s ) ;
	}


	// simple pattern to strip selected lang_tags (remove all tags)
	$s = preg_replace( '/\[\/?'.preg_quote($easiestml_lang).'\](\<br \/\>)?/i' , '' , $s ) ;

	// much complex pattern to strip valid pair of selected lag_tags (BUGGY?)
	// $s = str_replace( '['.$easiestml_lang.']<br />' , '['.$easiestml_lang.']' , $s ) ;
	// $s = str_replace( '[/'.$easiestml_lang.']<br />' , '[/'.$easiestml_lang.']' , $s ) ;
	// $s = preg_replace( '/(\['.preg_quote($easiestml_lang).'\])('.$mid_pattern.')(\[\/'.preg_quote($easiestml_lang).'\])/isU' , '$2' , $s ) ;

	/* list($usec, $sec) = explode(" ",microtime());
	$GIJ_end_time = ((float)$sec + (float)$usec);
	error_log( ($GIJ_end_time - $GLOBALS['GIJ_start_time']) . "(sec)\n" , 3 , "/tmp/error_log" ) ; */

	return $s ;
}


function easiestml_escape_bracket_textbox( $matches )
{
	if( preg_match( '/type=["\']?text["\']?/i' , $matches[2] ) ) {
		return $matches[1].str_replace('[','&#91;',$matches[2]).$matches[3] ;
	} else {
		return $matches[1].$matches[2].$matches[3] ;
	}
}

function easiestml_escape_bracket_textarea( $matches )
{
	return $matches[1].str_replace('[','&#91;',$matches[2]).$matches[3] ;
}

function easiestml_check_nevercross( $matches )
{
	return preg_match( EASIESTML_NEVERCROSSREGEX , $matches[0] ) ? $matches[0] : '' ;
}

?>