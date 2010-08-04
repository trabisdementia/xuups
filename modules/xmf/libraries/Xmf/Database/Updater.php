<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Xmf
 * @since           0.1
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

Xmf_Language::load('database', 'xmf');

class Xmf_Database_Updater
{

    var $_dbTypesArray;
    var $db;

    function __construct()
    {
        $this->_db =& XoopsDatabaseFactory::getDatabaseConnection();
        $this->_dbTypesArray['textbox'] = 'varchar(255)';
        $this->_dbTypesArray['textarea'] = 'text';
        $this->_dbTypesArray['int'] = 'int(11)';
        $this->_dbTypesArray['url'] = 'varchar(255)';
        $this->_dbTypesArray['email'] = 'varchar(255)';
        $this->_dbTypesArray['array'] = 'text';
        $this->_dbTypesArray['other'] = 'text';
        $this->_dbTypesArray['source'] = 'text';
        $this->_dbTypesArray['stime'] = 'int(11)';
        $this->_dbTypesArray['mtime'] = 'int(11)';
        $this->_dbTypesArray['ltime'] = 'int(11)';
        //$this->_dbTypesArray[XMF_OBJ_DTYPE_SIMPLE_ARRAY] = 'text';
        //$this->_dbTypesArray[XMF_OBJ_DTYPE_CURRENCY] = 'text';
        //$this->_dbTypesArray[XMF_OBJ_DTYPE_FLOAT] = 'float';
        //$this->_dbTypesArray[XMF_OBJ_DTYPE_TIME_ONLY] = 'int(11)';
        //$this->_dbTypesArray[XMF_OBJ_DTYPE_URLLINK] = 'int(11)';
        //$this->_dbTypesArray[XMF_OBJ_DTYPE_FILE] = 'int(11)';
        //$this->_dbTypesArray[XMF_OBJ_DTYPE_IMAGE] = 'varchar(255)';
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
    function runQuery($query, $goodmsg, $badmsg)
    {
        $ret = $this->db->query($query);
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
    function renameTable($from, $to)
    {
        $from = $this->db->prefix($from);
        $to = $this->db->prefix($to);
        $query = sprintf("ALTER TABLE %s RENAME %s", $from, $to);
        $ret = $this->db->query($query);
        if (!$ret) {
            echo "&nbsp;&nbsp;" . sprintf(_DB_XMF_MSG_RENAME_TABLE_ERR, $from) . "<br />";
            return false;
        } else {
            echo "&nbsp;&nbsp;" . sprintf(_DB_XMF_MSG_RENAME_TABLE, $from, $to) . "<br />";
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
    function updateTable($table)
    {
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

    function automaticUpgrade($module, $item)
    {
        if (is_array($item)) {
            foreach ($item as $v) {
                $this->upgradeObjectItem($module, $v);
            }
        } else {
            $this->upgradeObjectItem($module, $item);
        }
    }

    function getFieldTypeFromVar($var)
    {
        $ret = isset($this->_dbTypesArray[$var['data_type']]) ? $this->_dbTypesArray[$var['data_type']] : 'text';
        return $ret;
    }

    function getFieldDefaultFromVar($var, $key = false)
    {
        if ($var['value']) {
            return $var['value'];
        } else {
            if (in_array($var['data_type'], array(
                'int',
                'stime',
                'mtime',
                'ltime',
                //XMF_OBJ_DTYPE_TIME_ONLY,
                //XMF_OBJ_DTYPE_URLLINK,
                //XMF_OBJ_DTYPE_FILE
            ))) {
                return '0';
            } else {
                return '';
            }
        }
    }

    function upgradeObjectItem($module, $item)
    {
        $helper = Xmf_Module_Helper::getInstance($module);
        $helper->setDebug(true);

        $module_handler = $helper->getHandler($item);

        if (!$module_handler) {
            return false;
        }

        $table = new Xmf_Database_Table($module . '_' . $item);
        $object = $module_handler->create();
        $objectVars = $object->getVars();

        if (!$table->exists()) {
            // table was never created, let's do it
            $structure = "";
            foreach ($objectVars as $key => $var) {
                $extra = '';
                //if ($var['persistent']) {
                    $type = $this->getFieldTypeFromVar($var);
                    if ($key == $module_handler->keyName) {
                        $extra = " not null auto_increment";
                    } else if ($type != 'text') {
                        $default = $this->getFieldDefaultFromVar($var);
                        $extra = " not null default '$default'";
                    } else {
                        $extra = "";
                    }
                    $structure .= "`$key` $type$extra,";
                //}
            }
            $structure .= "PRIMARY KEY  (`" . $module_handler->keyName . "`)";
            $table->setStructure($structure);
            if (!$this->updateTable($table)) {
                /**
                 * @todo trap the errors
                 */
            }
        } else {
            $existingFieldsArray = $table->getExistingFieldsArray();
            foreach ($objectVars as $key => $var) {
                //if ($var['persistent']) {
                    $extra = '';
                    if (!isset($existingFieldsArray[$key])) {
                        // the fiels does not exist, let's create it
                        $type = $this->getFieldTypeFromVar($var);
                        $default =  $this->getFieldDefaultFromVar($var);
                        if ($type != 'text') {
                            $table->addNewField($key, "$type not null default '$default'");
                        } else {
                            $table->addNewField($key, "$type null");
                        }
                    } else {
                        // if field already exists, let's check if the definition is correct
                        $definition = strtolower($existingFieldsArray[$key]);
                        $type = $this->getFieldTypeFromVar($var);
                        if ($key == $module_handler->keyName) {
                            $extra = " not null auto_increment";
                        } else if ($type != 'text') {
                            $default =  $this->getFieldDefaultFromVar($var, $key);
                            $extra = " not null default '$default'";
                        } else {
                            $extra = "";
                        }
                        $actual_definition = "$type$extra";
                        if ($definition != $actual_definition) {
                            //exit ($definition . '-'.$actual_definition);
                            $table->addAlteredField($key, $actual_definition);
                        }
                    }
                //}
            }

            // check to see if there are some unused fields left in the table
            foreach ($existingFieldsArray as $key => $v) {
                if (!isset($objectVars[$key]) /*|| !$objectVars[$key]['persistent']*/) {
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

    function moduleUpgrade(&$module)
    {
        $dirname = $module->getVar('dirname');

        ob_start();

        $table = new Xmf_Database_Table($dirname . '_meta');
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

        $dbVersion  = xmf_getMeta('version', $dirname);
        if (!$dbVersion) {
            $dbVersion = 0;
        }
        $newDbVersion = constant(strtoupper($dirname . '_db_version')) ? constant(strtoupper($dirname . '_db_version')) : 0;
        echo 'Database version : ' . $dbVersion . '<br />';
        echo 'New database version : ' . $newDbVersion . '<br />';

        if ($newDbVersion > $dbVersion) {
            for ($i = $dbVersion + 1; $i <= $newDbVersion; $i++) {
                $upgrade_function = $dirname . '_db_upgrade_' . $i;
                if (function_exists($upgrade_function)) {
                    $upgrade_function();
                }
            }
        }

        echo "<code>" . _DB_XMF_UPDATE_UPDATING_DATABASE . "<br />";

        // if there is a function to execute for this DB version, let's do it
        //$function_

        $this->automaticUpgrade($dirname, $module->modinfo['object_items']);

        echo "</code>";

        $feedback = ob_get_clean();
        if (method_exists($module, "setMessage")) {
            $module->setMessage($feedback);
        } else {
            echo $feedback;
        }
        xmf_setMeta("version", $newDbVersion, $dirname); //Set meta version to current
        return true;
    }
}