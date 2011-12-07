<?php
/**
 * Contains the classes for updating database tables
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>
 * @version $Id: smartdbupdater.php 799 2008-02-04 22:14:27Z malanciault $
 * @link http://www.smartfactory.ca The SmartFactory
 * @package SmartObject
 */
/**
 * SmartDbTable class
 *
 * Information about an individual table
 *
 * @package SmartObject
 * @author marcan <marcan@smartfactory.ca>
 * @link http://www.smartfactory.ca The SmartFactory
 */
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}
if (!defined("SMARTOBJECT_ROOT_PATH")) {
    include_once (XOOPS_ROOT_PATH . '/modules/smartobject/include/common.php');
}
/**
 * Include the language constants for the SmartObjectDBUpdater
 */
global $xoopsConfig;
$common_file = SMARTOBJECT_ROOT_PATH . "language/" . $xoopsConfig['language'] . "/smartdbupdater.php";
if (!file_exists($common_file)) {
    $common_file = SMARTOBJECT_ROOT_PATH . "language/english/smartdbupdater.php";
}
include ($common_file);
class SmartDbTable {
    /**
     * @var string $_name name of the table
     */
    var $_name;
    /**
     * @var string $_structure structure of the table
     */
    var $_structure;

    /**
     * @var array $_data containing valued of each records to be added
     */
    var $_data;

    /**
     * @var array $_alteredFields containing fields to be altered
     */
    var $_alteredFields;

    /**
     * @var array $_newFields containing new fields to be added
     */
    var $_newFields;

    /**
     * @var array $_dropedFields containing fields to be droped
     */
    var $_dropedFields;

    /**
     * @var array $_flagForDrop flag table to drop it
     */
    var $_flagForDrop = false;

    /**
     * @var array $_updatedFields containing fields which values will be updated
     */
    var $_updatedFields;

    /**
     * @var array $_updatedFields containing fields which values will be updated
     */ //felix
    var $_updatedWhere;

    var $_existingFieldsArray=false;

    /**
     * Constructor
     *
     * @param string $name name of the table
     *
     */
    function SmartDbTable($name) {
        $this->_name = $name;
        $this->_data = array ();
    }

    /**
     * Return the table name, prefixed with site table prefix
     *
     * @return string table name
     *
     */
    function name() {
        global $xoopsDB;
        return $xoopsDB->prefix($this->_name);
    }

    /**
     * Checks if the table already exists in the database
     *
     * @return bool TRUE if it exists, FALSE if not
     *
     */
    function exists() {
        return smart_TableExists($this->_name);
    }

    function getExistingFieldsArray() {

        global $xoopsDB;
        $result = $xoopsDB->query("SHOW COLUMNS FROM " . $this->name());
        while ($existing_field = $xoopsDB->fetchArray($result)) {
            $fields[$existing_field['Field']] = $existing_field['Type'];
            if ($existing_field['Null'] != "YES") {
                $fields[$existing_field['Field']] .= " NOT NULL";
            }
            if ($existing_field['Extra']) {
                $fields[$existing_field['Field']] .= " " . $existing_field['Extra'];
            }
            if (!($existing_field['Default'] === NULL) && ($existing_field['Default'] || $existing_field['Default'] == '' || $existing_field['Default'] == 0)) {
                $fields[$existing_field['Field']] .= " default '" . $existing_field['Default'] . "'";
            }
        }
        return $fields;
    }
    function fieldExists($field) {
        $existingFields = $this->getExistingFieldsArray();
        return isset ($existingFields[$field]);
    }
    /**
     * Set the table structure
     *
     * Example :
     *
     *     	$table->setStructure("`transactionid` int(11) NOT NULL auto_increment,
     * 				  `date` int(11) NOT NULL default '0',
     * 				  `status` int(1) NOT NULL default '-1',
     * 				  `itemid` int(11) NOT NULL default '0',
     * 				  `uid` int(11) NOT NULL default '0',
     * 				  `price` float NOT NULL default '0',
     * 				  `currency` varchar(100) NOT NULL default '',
     * 				  PRIMARY KEY  (`transactionid`)");
     *
     * @param  string $structure table structure
     *
     */
    function setStructure($structure) {
        $this->_structure = $structure;
    }
    /**
     * Return the table structure
     *
     * @return string table structure
     *
     */
    function getStructure() {
        return sprintf($this->_structure, $this->name());
    }
    /**
     * Add values of a record to be added
     *
     * @param string $data values of a record
     *
     */
    function setData($data) {
        $this->_data[] = $data;
    }

    /**
     * Get the data array
     *
     * @return array containing the records values to be added
     *
     */
    function getData() {
        return $this->_data;
    }
    /**
     * Use to insert data in a table
     *
     * @return bool true if success, false if an error occured
     *
     */
    function addData() {
        global $xoopsDB;
        foreach ($this->getData() as $data) {
            $query = sprintf('INSERT INTO %s VALUES (%s)', $this->name(), $data);
            $ret = $xoopsDB->query($query);
            if (!$ret) {
                echo "&nbsp;&nbsp;" . sprintf(_SDU_MSG_ADD_DATA_ERR, $this->name()) . "<br />";
            } else {
                echo "&nbsp;&nbsp;" . sprintf(_SDU_MSG_ADD_DATA, $this->name()) . "<br />";
            }
        }
        return $ret;
    }
    /**
     * Add a field to be added
     *
     * @param string $name name of the field
     * @param string $properties properties of the field
     *
     */
    function addAlteredField($name, $properties, $newname=false, $showerror = true) {
        $field['name'] = $name;
        $field['properties'] = $properties;
        $field['showerror'] = $showerror;
        $field['newname'] = $newname;
        $this->_alteredFields[] = $field;
    }
    /**
     * Invert values 0 to 1 and 1 to 0
     *
     * @param string $name name of the field
     * @param string $old old propertie
     * @param string $new new propertie
     *
     */ //felix
    function addUpdatedWhere($name, $newValue, $oldValue) {
        $field['name'] = $name;
        $field['value'] = $newValue;
        $field['where'] = $oldValue;
        $this->_updatedWhere[] = $field;
    }
    /**
     * Add new field of a record to be added
     *
     * @param string $name name of the field
     * @param string $properties properties of the field
     *
     */
    function addNewField($name, $properties) {
        $field['name'] = $name;
        $field['properties'] = $properties;
        $this->_newFields[] = $field;
    }
    /**
     * Get fields that need to be altered
     *
     * @return array fields that need to be altered
     *
     */
    function getAlteredFields() {
        return $this->_alteredFields;
    }
    /**
     * Add field for which the value will be updated
     *
     * @param string $name name of the field
     * @param string $value value to be set
     *
     */
    function addUpdatedField($name, $value) {
        $field['name'] = $name;
        $field['value'] = $value;
        $this->_updatedFields[] = $field;
    }
    /**
     * Get new fields to be added
     *
     * @return array fields to be added
     *
     */
    function getNewFields() {
        return $this->_newFields;
    }
    /**
     * Get fields which values need to be updated
     *
     * @return array fields which values need to be updated
     *
     */
    function getUpdatedFields() {
        return $this->_updatedFields;
    }
    /**
     * Get fields which values need to be updated
     *
     * @return array fields which values need to be updated
     *
     */ //felix
    function getUpdatedWhere() {
        return $this->_updatedWhere;
    }
    /**
     * Add values of a record to be added
     *
     * @param string $name name of the field
     *
     */
    function addDropedField($name) {
        $this->_dropedFields[] = $name;
    }
    /**
     * Get fields that need to be droped
     *
     * @return array fields that need to be droped
     *
     */
    function getDropedFields() {
        return $this->_dropedFields;
    }
    /**
     * Set the flag to drop the table
     *
     */
    function setFlagForDrop() {
        $this->_flagForDrop = true;
    }
    /**
     * Use to create a table
     *
     * @return bool true if success, false if an error occured
     *
     */
    function createTable() {
        global $xoopsDB;
        $query = $this->getStructure();
        $query = "CREATE TABLE `" . $this->name() . "` (" . $query . ") ENGINE=MyISAM COMMENT='The SmartFactory <www.smartfactory.ca>'";
        //xoops_debug($query);
        $ret = $xoopsDB->query($query);
        if (!$ret) {
            echo "&nbsp;&nbsp;" . sprintf(_SDU_MSG_CREATE_TABLE_ERR, $this->name()) . " (" . $xoopsDB->error(). ")<br />";

        } else {
            echo "&nbsp;&nbsp;" . sprintf(_SDU_MSG_CREATE_TABLE, $this->name()) . "<br />";
        }
        return $ret;
    }
    /**
     * Use to drop a table
     *
     * @return bool true if success, false if an error occured
     *
     */
    function dropTable() {
        global $xoopsDB;
        $query = sprintf("DROP TABLE %s", $this->name());
        $ret = $xoopsDB->query($query);
        if (!$ret) {
            echo "&nbsp;&nbsp;" . sprintf(_SDU_MSG_DROP_TABLE_ERR, $this->name()) . " (" . $xoopsDB->error(). ")<br />";
            return false;
        } else {
            echo "&nbsp;&nbsp;" . sprintf(_SDU_MSG_DROP_TABLE, $this->name()) . "<br />";
            return true;
        }
    }
    /**
     * Use to alter a table
     *
     * @return bool true if success, false if an error occured
     *
     */
    function alterTable() {
        global $xoopsDB;
        $ret = true;

        foreach ($this->getAlteredFields() as $alteredField) {
            if (!$alteredField['newname']) {
                $alteredField['newname'] = $alteredField['name'];
            }

            $query = sprintf("ALTER TABLE `%s` CHANGE `%s` `%s` %s", $this->name(), $alteredField['name'], $alteredField['newname'], $alteredField['properties']);
            $ret = $ret && $xoopsDB->query($query);
            if ($alteredField['showerror']) {
                if (!$ret) {
                    echo "&nbsp;&nbsp;" . sprintf(_SDU_MSG_CHGFIELD_ERR, $alteredField['name'], $this->name()) . " (" . $xoopsDB->error(). ")<br />";
                } else {
                    echo "&nbsp;&nbsp;" . sprintf(_SDU_MSG_CHGFIELD, $alteredField['name'], $this->name()) . "<br />";
                }
            }
        }

        return $ret;
    }
    /**
     * Use to add new fileds in the table
     *
     * @return bool true if success, false if an error occured
     *
     */
    function addNewFields() {
        global $xoopsDB;
        $ret = true;
        foreach ($this->getNewFields() as $newField) {
            $query = sprintf("ALTER TABLE `%s` ADD `%s` %s", $this->name(), $newField['name'], $newField['properties']);
            //echo $query;
            $ret = $ret && $xoopsDB->query($query);
            if (!$ret) {
                echo "&nbsp;&nbsp;" . sprintf(_SDU_MSG_NEWFIELD_ERR, $newField['name'], $this->name()) . "<br />";
            } else {
                echo "&nbsp;&nbsp;" . sprintf(_SDU_MSG_NEWFIELD, $newField['name'], $this->name()) . "<br />";
            }
        }
        return $ret;
    }
    /**
     * Use to update fields values
     *
     * @return bool true if success, false if an error occured
     *
     */
    function updateFieldsValues() {
        global $xoopsDB;
        $ret = true;
        foreach ($this->getUpdatedFields() as $updatedField) {
            $query = sprintf("UPDATE %s SET %s = %s", $this->name(), $updatedField['name'], $updatedField['value']);
            $ret = $ret && $xoopsDB->query($query);
            if (!$ret) {
                echo "&nbsp;&nbsp;" . sprintf(_SDU_MSG_UPDATE_TABLE_ERR, $this->name()) . " (" . $xoopsDB->error(). ")<br />";
            } else {
                echo "&nbsp;&nbsp;" . sprintf(_SDU_MSG_UPDATE_TABLE, $this->name()) . "<br />";
            }
        }
        return $ret;
    }
    /**
     * Use to update fields values
     *
     * @return bool true if success, false if an error occured
     *
     */ //felix
    function updateWhereValues() {
        global $xoopsDB;
        $ret = true;
        foreach ($this->getUpdatedWhere() as $updatedWhere) {
            $query = sprintf("UPDATE %s SET %s = %s WHERE %s  %s", $this->name(), $updatedWhere['name'], $updatedWhere['value'], $updatedWhere['name'], $updatedWhere['where']);
            //echo $query."<br>";
            $ret = $ret && $xoopsDB->query($query);
            if (!$ret) {
                echo "&nbsp;&nbsp;" . sprintf(_SDU_MSG_UPDATE_TABLE_ERR, $this->name()) . " (" . $xoopsDB->error(). ")<br />";
            } else {
                echo "&nbsp;&nbsp;" . sprintf(_SDU_MSG_UPDATE_TABLE, $this->name()) . "<br />";
            }
        }
        return $ret;
    }
    /**
     * Use to drop fields
     *
     * @return bool true if success, false if an error occured
     *
     */
    function dropFields() {
        global $xoopsDB;
        $ret = true;
        foreach ($this->getdropedFields() as $dropedField) {
            $query = sprintf("ALTER TABLE %s DROP %s", $this->name(), $dropedField);
            $ret = $ret && $xoopsDB->query($query);
            if (!$ret) {
                echo "&nbsp;&nbsp;" . sprintf(_SDU_MSG_DROPFIELD_ERR, $dropedField, $this->name()) . " (" . $xoopsDB->error(). ")<br />";
            } else {
                echo "&nbsp;&nbsp;" . sprintf(_SDU_MSG_DROPFIELD, $dropedField, $this->name()) . "<br />";
            }
        }
        return $ret;
    }
}
/**
 * SmartobjectDbupdater class
 *
 * Class performing the database update for the module
 *
 * @package SmartObject
 * @author marcan <marcan@smartfactory.ca>
 * @link http://www.smartfactory.ca The SmartFactory
 */
class SmartobjectDbupdater {

    var $_dbTypesArray;

    function SmartobjectDbupdater() {
        $this->_dbTypesArray[XOBJ_DTYPE_TXTBOX] = 'varchar(255)';
        $this->_dbTypesArray[XOBJ_DTYPE_TXTAREA] = 'text';
        $this->_dbTypesArray[XOBJ_DTYPE_INT] = 'int(11)';
        $this->_dbTypesArray[XOBJ_DTYPE_URL] = 'varchar(255)';
        $this->_dbTypesArray[XOBJ_DTYPE_EMAIL] = 'varchar(255)';
        $this->_dbTypesArray[XOBJ_DTYPE_ARRAY] = 'text';
        $this->_dbTypesArray[XOBJ_DTYPE_OTHER] = 'text';
        $this->_dbTypesArray[XOBJ_DTYPE_SOURCE] = 'text';
        $this->_dbTypesArray[XOBJ_DTYPE_STIME] = 'int(11)';
        $this->_dbTypesArray[XOBJ_DTYPE_MTIME] = 'int(11)';
        $this->_dbTypesArray[XOBJ_DTYPE_LTIME] = 'int(11)';
        $this->_dbTypesArray[XOBJ_DTYPE_SIMPLE_ARRAY] = 'text';
        $this->_dbTypesArray[XOBJ_DTYPE_CURRENCY] = 'text';
        $this->_dbTypesArray[XOBJ_DTYPE_FLOAT] = 'float';
        $this->_dbTypesArray[XOBJ_DTYPE_TIME_ONLY] = 'int(11)';
        $this->_dbTypesArray[XOBJ_DTYPE_URLLINK] = 'int(11)';
        $this->_dbTypesArray[XOBJ_DTYPE_FILE] = 'int(11)';
        $this->_dbTypesArray[XOBJ_DTYPE_IMAGE] = 'varchar(255)';
    }
    /**
     * Use to execute a general query
     *
     * @param string $query query that will be executed
     * @param string $goodmsg message displayed on success
     * @param string $badmsg message displayed on error
     *
     * @return bool true if success, false if an error occured
     *
     */
    function runQuery($query, $goodmsg, $badmsg) {
        global $xoopsDB;
        $ret = $xoopsDB->query($query);
        if (!$ret) {
            echo "&nbsp;&nbsp;$badmsg<br />";
            return false;
        } else {
            echo "&nbsp;&nbsp;$goodmsg<br />";
            return true;
        }
    }
    /**
     * Use to rename a table
     *
     * @param string $from name of the table to rename
     * @param string $to new name of the renamed table
     *
     * @return bool true if success, false if an error occured
     */
    function renameTable($from, $to) {
        global $xoopsDB;
        $from = $xoopsDB->prefix($from);
        $to = $xoopsDB->prefix($to);
        $query = sprintf("ALTER TABLE %s RENAME %s", $from, $to);
        $ret = $xoopsDB->query($query);
        if (!$ret) {
            echo "&nbsp;&nbsp;" . sprintf(_SDU_MSG_RENAME_TABLE_ERR, $from) . "<br />";
            return false;
        } else {
            echo "&nbsp;&nbsp;" . sprintf(_SDU_MSG_RENAME_TABLE, $from, $to) . "<br />";
            return true;
        }
    }
    /**
     * Use to update a table
     *
     * @param object $table {@link SmartDbTable} that will be updated
     *
     * @see SmartDbTable
     *
     * @return bool true if success, false if an error occured
     */
    function updateTable($table) {
        global $xoopsDB;
        $ret = true;
        // If table has a structure, create the table
        if ($table->getStructure()) {
            $ret = $table->createTable() && $ret;
        }
        // If table is flag for drop, drop it
        if ($table->_flagForDrop) {
            $ret = $table->dropTable() && $ret;
        }
        // If table has data, insert it
        if ($table->getData()) {
            $ret = $table->addData() && $ret;
        }
        // If table has new fields to be added, add them
        if ($table->getNewFields()) {
            $ret = $table->addNewFields() && $ret;
        }
        // If table has altered field, alter the table
        if ($table->getAlteredFields()) {
            $ret = $table->alterTable() && $ret;
        }
        // If table has updated field values, update the table
        if ($table->getUpdatedFields()) {
            $ret = $table->updateFieldsValues($table) && $ret;
        }
        // If table has droped field, alter the table
        if ($table->getDropedFields()) {
            $ret = $table->dropFields($table) && $ret;
        }
        //felix
        // If table has updated field values, update the table
        if ($table->getUpdatedWhere()) {
            $ret = $table->UpdateWhereValues($table) && $ret;
        }
        return $ret;
    }

    function automaticUpgrade($module, $item) {
        if (is_array($item)) {
            foreach($item as $v) {
                $this->upgradeObjectItem($module, $v);
            }
        } else {
            $this->upgradeObjectItem($module, $item);
        }
    }

    function getFieldTypeFromVar($var) {
        $ret = isset($this->_dbTypesArray[$var['data_type']]) ? $this->_dbTypesArray[$var['data_type']] : 'text';
        return $ret;
    }

    function getFieldDefaultFromVar($var, $key = false) {
        if ($var['value']) {
            return $var['value'];
        } else {
            if (in_array($var['data_type'], array(
            XOBJ_DTYPE_INT,
            XOBJ_DTYPE_STIME,
            XOBJ_DTYPE_MTIME,
            XOBJ_DTYPE_LTIME,
            XOBJ_DTYPE_TIME_ONLY,
            XOBJ_DTYPE_URLLINK,
            XOBJ_DTYPE_FILE
            ))) {
                return '0';
            } else {
                return '';
            }
        }
    }

    function upgradeObjectItem($module, $item) {
        $module_handler = xoops_getModuleHandler($item, $module);
        if (!$module_handler) {
            return false;
        }

        $table = new SmartDbTable($module . '_' . $item);
        $object = $module_handler->create();
        $objectVars = $object->getVars();

        if (!$table->exists()) {
            // table was never created, let's do it
            $structure = "";
            foreach($objectVars as $key=>$var) {
                if ($var['persistent']) {
                    $type = $this->getFieldTypeFromVar($var);
                    if ($key == $module_handler->keyName) {
                        $extra = "auto_increment";
                    } else {
                        $default =  $this->getFieldDefaultFromVar($var);
                        $extra = "default '$default'
";
                    }
                    $structure .= "`$key` $type not null $extra,
";
                }
            }
            $structure .= "PRIMARY KEY  (`" . $module_handler->keyName . "`)
";
            $table->setStructure($structure);
            if (!$this->updateTable($table)) {
                /**
                 * @todo trap the errors
                 */
            }
        } else {
            $existingFieldsArray = $table->getExistingFieldsArray();
            foreach($objectVars as $key=>$var) {
                if ($var['persistent']) {
                    if (!isset($existingFieldsArray[$key])) {
                        // the fiels does not exist, let's create it
                        $type = $this->getFieldTypeFromVar($var);
                        $default =  $this->getFieldDefaultFromVar($var);
                        $table->addNewField($key, "$type not null default '$default'");
                    } else {
                        // if field already exists, let's check if the definition is correct
                        $definition =  strtolower($existingFieldsArray[$key]);
                        $type = $this->getFieldTypeFromVar($var);
                        if ($key == $module_handler->keyName) {
                            $extra = "auto_increment";
                        } else {
                            $default =  $this->getFieldDefaultFromVar($var, $key);
                            $extra = "default '$default'";
                        }
                        $actual_definition = "$type not null $extra";
                        if ($definition != $actual_definition) {
                            $table->addAlteredField($key, $actual_definition);
                        }
                    }
                }
            }

            // check to see if there are some unused fields left in the table
            foreach ($existingFieldsArray as $key=>$v) {
                if (!isset($objectVars[$key]) || !$objectVars[$key]['persistent']) {
                    $table->addDropedField($key);
                }
            }

            if (!$this->updateTable($table)) {
                /**
                 * @todo trap the errors
                 */
            }
        }
    }
    function moduleUpgrade(&$module) {
        $dirname = $module->getVar('dirname');

        ob_start();

        $table = new SmartDbTable($dirname . '_meta');
        if (!$table->exists()) {
            $table->setStructure("
			  `metakey` varchar(50) NOT NULL default '',
			  `metavalue` varchar(255) NOT NULL default '',
			  PRIMARY KEY (`metakey`)");
            $table->setData("'version',0");
            if (!$this->updateTable($table)) {
                /**
                 * @todo trap the errors
                 */
            }
        }

        $dbVersion  = smart_GetMeta('version', $dirname);
        if (!$dbVersion) {
            $dbVersion = 0;
        }
        $newDbVersion = constant(strtoupper($dirname . '_db_version')) ? constant(strtoupper($dirname . '_db_version')) : 0;
        echo 'Database version : ' . $dbVersion . '<br />';
        echo 'New database version : ' . $newDbVersion . '<br />';

        if ($newDbVersion > $dbVersion) {
            for($i=$dbVersion+1;$i<=$newDbVersion; $i++) {
                $upgrade_function = $dirname . '_db_upgrade_' . $i;
                if (function_exists($upgrade_function)) {
                    $upgrade_function();
                }
            }
        }

        echo "<code>" . _SDU_UPDATE_UPDATING_DATABASE . "<br />";

        // if there is a function to execute for this DB version, let's do it
        //$function_

        $module_info = smart_getModuleInfo($dirname);
        $this->automaticUpgrade($dirname, $module_info->modinfo['object_items']);

        echo "</code>";

        $feedback = ob_get_clean();
        if (method_exists($module, "setMessage")) {
            $module->setMessage($feedback);
        } else {
            echo $feedback;
        }
        smart_SetMeta("version", $newDbVersion, $dirname); //Set meta version to current
        return true;
    }
}
?>