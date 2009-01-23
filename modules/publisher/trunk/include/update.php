<?php

if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

function xoops_module_update_publisher($module) {

	// Load SmartDbUpdater from the SmartObject Framework if present
	$smartdbupdater = XOOPS_ROOT_PATH . "/modules/publisher/class/smartdbupdater.php";
	include_once($smartdbupdater);

	$dbupdater = new SmartobjectDbupdater();

    ob_start();

	echo "<code>" . _SDU_UPDATE_UPDATING_DATABASE . "<br />";

	// Adding partial_view field
    $table = new SmartDbTable('publisher_items');
    if (!$table->fieldExists('partial_view')) {
    	$table->addNewField('partial_view', "varchar(255) NOT NULL default ''");
    } else {
   		$table->addAlteredField('partial_view', "varchar(255) NOT NULL default ''");
    }

    if (!$dbupdater->updateTable($table)) {
        /**
         * @todo trap the errors
         */
    }
	unset($table);

	/**
	 * Check for items with categoryid=0
	 */

	@$publisher_item_handler = xoops_getmodulehandler('item', 'publisher');
	@$publisher_category_handler = xoops_getmodulehandler('category', 'publisher');

	if ($publisher_item_handler) {
		//find a valid categoryid
		$categoriesObj = $publisher_category_handler->getCategories(1, 0, 0, 'weight', 'ASC', false);
		if (count($categoriesObj) > 0) {
			$categoryid = $categoriesObj[0]->getVar('categoryid');
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('categoryid', 0));
			$publisher_item_handler->updateAll('categoryid', $categoryid, $criteria);
			echo "&nbsp;&nbsp;Cleaning up items for with categoryid=0<br />";
		}
	}

	// Adding item_tag field in publisher_items
    $table = new SmartDbTable('publisher_items');
    if (!$table->fieldExists('item_tag')) {
    	$table->addNewField('item_tag', "TEXT NOT NULL");
    }
    if ($table->fieldExists('tags')) {
    	$table->addDropedField('tags');
    }

    if (!$dbupdater->updateTable($table)) {
        /**
         * @todo trap the errors
         */
    }
	unset($table);

	echo "</code>";

    $feedback = ob_get_clean();
    if (method_exists($module, "setMessage")) {
        $module->setMessage($feedback);
    }
    else {
        echo $feedback;
    }

    return true;
}

function xoops_module_install_publisher($module) {

    ob_start();

	include_once(XOOPS_ROOT_PATH . "/modules/" . $module->getVar('dirname') . "/include/functions.php");

    $feedback = ob_get_clean();
    if (method_exists($module, "setMessage")) {
        $module->setMessage($feedback);
    }
    else {
        echo $feedback;
    }

	return true;
}


?>