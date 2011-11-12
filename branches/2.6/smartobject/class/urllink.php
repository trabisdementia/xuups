<?php
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH."/modules/smartobject/class/basedurl.php";

class SmartobjectUrlLink extends SmartobjectBasedUrl {


    function SmartobjectUrlLink() {
        $this->SmartobjectBasedUrl();
        $this->quickInitVar('urllinkid', XOBJ_DTYPE_TXTBOX, true);
        $this->quickInitVar('target', XOBJ_DTYPE_TXTBOX, true);

        $this->setControl('target', array('options'=>
        array('_self' => _CO_SOBJECT_URLLINK_SELF,
								'_blank' => _CO_SOBJECT_URLLINK_BLANK)));
    }


}



class SmartobjectUrlLinkHandler extends SmartPersistableObjectHandler {

    function SmartobjectUrlLinkHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'urllink', 'urllinkid', 'caption', 'desc', 'smartobject');

    }

}
?>
