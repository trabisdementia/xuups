<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

function dummy_search($queryarray, $andor, $limit, $offset, $userid){
    $dirname = XOOPS_ROOT_PATH."/modules/dummy/data/";
    $ret = array();
    $i = 0;
    return dummy_search_directory($dirname, $queryarray, $ret, $i);
}

function dummy_search_directory($dirname, $queryarray, &$ret, &$i) {
    if (is_dir($dirname)) {
        $dir_handle = opendir($dirname);
    }
    if (!$dir_handle) {
        return $ret;
    }
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            //is dir or is file
            if (!is_dir($dirname."/".$file)) {
                //is file
                preg_match("#($queryarray[0]+?)#s", $file, $new);
                $data = trim($new[1]);
                if (!empty($data)){
                    $ret[$i]['image'] = "images/image.gif";
                    
                    //must fix this better because of double slashes in the url :(
                    $url = str_replace(XOOPS_ROOT_PATH, '', $dirname);
                    $url = str_replace('//', '/', $url);
                    $url = rtrim($url, '/');

                    $ret[$i]['link'] = XOOPS_URL.'/'.$url.'/'.$file;
                    $ret[$i]['title'] = $data;
                    $ret[$i]['time'] = '';
                    $ret[$i]['uid'] = '';
                    $i++;
                }
            } else {
                //is dir
                dummy_search_directory($dirname.'/'.$file, $queryarray, $ret, $i);
            }
        }
    }
    closedir($dir_handle);
    return $ret;
}
?>
