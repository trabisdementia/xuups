<?php
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH."/modules/smartobject/class/basedurl.php";

class SmartobjectFile extends SmartobjectBasedUrl {


    function SmartobjectFile() {
        $this->SmartobjectBasedUrl();
        $this->quickInitVar('fileid', XOBJ_DTYPE_TXTBOX, true, _CO_SOBJECT_RATING_DIRNAME);
    }
}
class SmartobjectFileHandler extends SmartPersistableObjectHandler {

    function SmartobjectFileHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'file', 'fileid', 'caption', 'desc', 'smartobject');

    }


}
?>
