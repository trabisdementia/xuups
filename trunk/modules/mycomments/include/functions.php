<?php

function mycomments_plugin_execute($dirname, $id, $func = 'useritems')
{
    global $xoopsUser, $xoopsConfig, $xoopsDB;

    $ret = array();
	$plugins_path = XOOPS_ROOT_PATH . "/modules/mycomments/plugins";

    $plugin_info = mycomments_get_plugin_info( $dirname , $func ) ;

    if( empty( $plugin_info ) || empty( $plugin_info['plugin_path'] ) ) return false ;

    if( ! empty( $plugin_info['langfile_path'] ) ) {
        include_once $plugin_info['langfile_path'] ;
    }
    include_once $plugin_info['plugin_path'] ;

    // call the plugin
    if( function_exists( @$plugin_info['func'] ) ) {
        // get the list of items
        $ret = $plugin_info['func']($id, $limit=0, $offset=0);
	}

	return $ret ;
}

function mycomments_get_plugin_info( $dirname , $func = 'useritems' )
{
    global $xoopsConfig;
    $language = $xoopsConfig['language'];
    // get $mytrustdirname for D3 modules
    $mytrustdirname = '' ;
	if( defined( 'XOOPS_TRUST_PATH' ) && file_exists( XOOPS_ROOT_PATH."/modules/".$dirname."/mytrustdirname.php" ) ) {
		@include XOOPS_ROOT_PATH."/modules/".$dirname."/mytrustdirname.php" ;
        $d3module_plugin_file = XOOPS_TRUST_PATH."/modules/".$mytrustdirname."/include/mycomments.plugin.php" ;
    }

	$module_plugin_file = XOOPS_ROOT_PATH."/modules/".$dirname."/include/mycomments.plugin.php" ;
	$builtin_plugin_file = XOOPS_ROOT_PATH."/modules/mycomments/plugins/".$dirname.".php" ;

	if( file_exists( $module_plugin_file ) ) {
		// module side (1st priority)
		$lang_files = array(
			XOOPS_ROOT_PATH."/modules/$dirname/language/$language/comments.php" ,
			XOOPS_ROOT_PATH."/modules/$dirname/language/english/comments.php" ,
		) ;
		$langfile_path = '' ;
		foreach( $lang_files as $lang_file ) {
			if( file_exists( $lang_file ) ) {
				$langfile_path = $lang_file ;
				break ;
			}
		}
		$ret = array(
			'plugin_path' => $module_plugin_file ,
			'langfile_path' => $langfile_path ,
			'func' => $dirname.'_'.$func ,
			'type' => 'module' ,
		) ;
	} else if( ! empty( $mytrustdirname ) && file_exists( $d3module_plugin_file ) ) {
		// D3 module's plugin under xoops_trust_path (2nd priority)
		$lang_files = array(
			XOOPS_TRUST_PATH."/modules/$mytrustdirname/language/$language/comments.php" ,
			XOOPS_TRUST_PATH."/modules/$mytrustdirname/language/english/comments.php" ,
		) ;
		$langfile_path = '' ;
		foreach( $lang_files as $lang_file ) {
			if( file_exists( $lang_file ) ) {
				$langfile_path = $lang_file ;
				break ;
			}
		}
		$ret = array(
			'plugin_path' => $d3module_plugin_file ,
			'langfile_path' => $langfile_path ,
			'func' => $mytrustdirname.'_'.$func ,
			'type' => 'module (D3)' ,
		) ;
	} else if( file_exists( $builtin_plugin_file ) ) {
		// built-in plugin under modules/waiting (3rd priority)
		$ret = array(
			'plugin_path' => $builtin_plugin_file ,
			'langfile_path' => '' ,
			'func' => $dirname.'_'.$func ,
			'type' => 'built-in' ,
		) ;
	} else {
		$ret = array() ;
	}

	return $ret ;
}

function mycomments_advanced_search($queryarray, $andor, $limit, $offset, $userid, $moduleid, $items){
	global $xoopsDB;
	include_once( XOOPS_ROOT_PATH . "/modules/mycomments/class/comment.php" ) ;
	$sql = "SELECT * FROM ".$xoopsDB->prefix("xoopscomments")." WHERE com_id>0 ";
    if ( $moduleid != 0 ) {
		$sql .= " AND com_modid=".$moduleid." ";
    }
    if ( $userid != 0 ) {
		$sql .= " AND com_uid=".$userid." ";
	}
	// because count() returns 1 even if a supplied variable
	// is not an array, we must check if $querryarray is really an array
	if ( is_array($queryarray) && $count = count($queryarray) ) {
		$sql .= " AND ((com_title LIKE '%$queryarray[0]%' OR com_text LIKE '%$queryarray[0]%')";
		for($i=1;$i<$count;$i++){
			$sql .= " $andor ";
			$sql .= "(com_title LIKE '%$queryarray[$i]%' OR com_text LIKE '%$queryarray[$i]%')";
		}
		$sql .= ") ";
	}

    if(is_array($items) && count($items)>0) {
        $sql .= ' AND com_itemid IN ('.implode(',', $items).')';
    }
	
	$sql .= "ORDER BY com_created DESC";
	$result = $xoopsDB->query($sql,$limit,$offset);

	$module_handler =& xoops_gethandler('module');
	$modules =& $module_handler->getObjects(new Criteria('hascomments', 1), true);


	$ret = array();
	$i = 0;
 	while($myrow = $xoopsDB->fetchArray($result)){
        /*
		$com_id = $myrow[com_id];
		$com_modid=$myrow[com_modid];
		$com_pid=$myrow[com_pid];
		$com_rootid=$myrow[com_rootid];
		$com_itemid=$myrow[com_itemid];

		$comment_config = array();
		$comment_config = $modules[$com_modid]->getInfo('comments');

		$link = "../".$modules[$com_modid]->getVar('dirname').'/';
		$link .= $comment_config['pageName'].'?';
		$link .= $comment_config['itemName'].'=';
		$link .= $com_itemid.'&amp;com_id='.$com_id.'&amp;com_rootid='.$com_rootid;
		$link .= '&amp;com_mode=thread&amp;#comment'.$com_id;

		$ret[$i]['image'] = "images/img.gif";
		$ret[$i]['link'] = $link;
		$ret[$i]['title'] = $myrow['com_title'];
		$ret[$i]['time'] = $myrow['com_created'];
		$ret[$i]['uid'] = $myrow['com_uid'];
		$i++;   */
        $id_as_key = false;
        $comment = new MycommentsComment();
        $comment->assignVars($myrow);
        if (!$id_as_key) {
            $ret[] =& $comment;
        } else {
            $ret[$myrow['com_id']] =& $comment;
        }
        unset($comment);
    }
	return $ret;
}

?>

