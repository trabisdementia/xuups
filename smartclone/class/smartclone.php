<?php

// work around for PHP < 5.0.x
if(!function_exists('file_put_contents')) {
    function file_put_contents($filename, $data, $file_append = false) {
        $fp = fopen($filename, (!$file_append ? 'w+' : 'a+'));
        if(!$fp) {
            trigger_error('file_put_contents cannot write in file "' . $filename . '"', E_USER_ERROR);
            return;
        }
        fputs($fp, $data);
        fclose($fp);
    }
}

class SmartClone {
    var $_fromModule;
    var $_toModule;
    var $_errors = array();
    var $_sCloNe;
    var $_sCLONE;
    var $_sclone;
    var $_sClone;
    var $_sMODULE;
    var $_sModule;
    var $_patterns;
    var $_patKeys;
    var $_patValues;
    var $_logs = array();
    var $_newModuleName = false;
    var $_newModuleURL = false;
    var $_newPath;

    function SmartClone($fromModule, $toModule) {
        $this->_fromModule = $fromModule;
        $this->_toModule = trim($toModule);

        $this->addLog('FromModule : ' . $this->_fromModule);
        $this->addLog('ToModule : ' . $this->_toModule);
    }
    function execute() {
        if (function_exists('mb_convert_encoding')) {
            $this->_toModule = mb_convert_encoding($this->_toModule, "", "auto");
        }
        $this->_toModule = str_replace('-', 'xyz', $this->_toModule);
        $this->_toModule = eregi_replace("[[:punct:]]", "", $this->_toModule);
        $this->_toModule = str_replace('xyz', '-', $this->_toModule);
        $this->_toModule = ereg_replace(' ', '_', $this->_toModule);

        $this->addLog('ToModule name, once it has been sanitized : ' . $this->_toModule);

        // Check wether the new module to be created already exists
        if (is_dir(XOOPS_ROOT_PATH . '/modules/' . $this->_toModule)) {
            $this->setError(sprintf(_AM_SCLONE_NEW_MODULE_ALREADY_EXISTS, $this->_toModule));
            return false;
        }
        $this->_sCloNe = $this->_toModule;
        $this->addLog('ToModule : ' . $this->_sCloNe);

        $this->_sCLONE = strtoupper(eregi_replace("-", "_", $this->_toModule));
        $this->addLog('TOMODULE : ' . $this->_sCLONE);

        $this->_sclone = strtolower(eregi_replace("-", "_", $this->_toModule));
        $this->addLog('tomodule : ' . $this->_sclone);

        $this->_sClone = ucfirst(strtolower($this->_toModule));
        $this->addLog('Tomodule : ' . $this->_sClone);

        $this->_sMODULE = strtoupper($this->_fromModule);
        $this->addLog('FROMMODULE : ' . $this->_sMODULE);

        $this->_sModule = ucfirst($this->_fromModule);
        $this->addLog('Frommodule : ' . $this->_sModule);

        // first one must be module directory name
        $this->_patterns = array (
        $this->_fromModule => $this->_sclone,
        $this->_sMODULE => $this->_sCLONE,
        $this->_sModule => $this->_sClone,
        );

        // Look for a plugin for this fromModule
        $plugins_handler = new SmartclonePlugins();
        if ($plugins_handler->getPlugin($this->_fromModule) && $plugins_handler->pluginPatterns) {

            foreach($plugins_handler->pluginPatterns as $aPattern) {
                switch($aPattern['replacement']) {

                    case 'ModuleName' :
                        $this->_patterns[$aPattern['key']] = $this->prefixSuffix($this->_sCloNe, $aPattern);
                        break;

                    case 'Modulename' :
                        $this->_patterns[$aPattern['key']] = $this->prefixSuffix($this->_sClone, $aPattern);
                        break;

                    case 'modulename' :
                        $this->_patterns[$aPattern['key']] = $this->prefixSuffix($this->_sclone, $aPattern);
                        break;

                    case 'MODULENAME' :
                        $this->_patterns[$aPattern['key']] = $this->prefixSuffix($this->_SCLONE, $aPattern);
                        break;

                    case 'CONSTANT' :
                        $this->_patterns[$aPattern['key']] = $this->getConstantPattern($aPattern, $aPattern);
                        break;

                    case 'CUSTOM' :
                        if (function_exists($aPattern['function'])) {
                            $function = $aPattern['function'];
                            $this->_patterns[$aPattern['key']] = $this->prefixSuffix($function($this->_sCloNe), $aPattern);
                        }

                        break;
                }
            }
        }

        $this->_patKeys = array_keys($this->_patterns);
        $this->_patValues = array_values($this->_patterns);

        // Create clone
        $module_dir = XOOPS_ROOT_PATH . '/modules';
        $fileperm = fileperms($module_dir);
        $this->addLog('Original permissions of folder "' . XOOPS_ROOT_PATH . '/modules' . '" : ' . $fileperm);

        if (chmod($module_dir, 0777)) {
            $this->cloneFileFolder($module_dir  . "/" . $this->_fromModule);
        } else {
            $this->setError(_AM_SCLONE_CHANGE_PERMISSION_FAILED);
            return false;
        }
        $this->storeLogsToFile();
        chmod($module_dir, $fileperm);
        return true;
    }
    function cloneFileFolder($path) {
        $this->addLog("Cloning '" . $this->relativePath($path) . "'");

        $newPath = str_replace($this->_patKeys[0], $this->_patValues[0], $path);

        if (!$this->_newModuleName) {
            $this->_newModuleName = str_replace(XOOPS_ROOT_PATH . '/modules/', '', $newPath);
            $this->_newModuleURL = XOOPS_URL . '/modules/' . $this->_newModuleName;
            $this->_newPath = $newPath;
        }

        $this->addLog("-- New path : " . $this->relativePath($newPath));

        if (is_dir($path)) {
            // Create new dir
            mkdir($newPath);
            $this->addLog("-- Creating folder '" . $this->relativePath($newPath) . "'");
            // check all files in dir, and process it
            if ($handle = opendir($path)) {
                while ($file = readdir($handle)) {
                    if ($file != '.' && $file != '..') {
                        $this->cloneFileFolder("$path/$file");
                    }
                }
                closedir($handle);
            }
        } else {
            if (preg_match('/(.jpg|.gif|.png|.zip)$/i', $path)) {
                $this->addLog("-- Copying file '" . $this->relativePath($newPath) . "'");
                copy($path, $newPath);
            } else {
                // file, read it
                $content = file_get_contents($path);
                $content = str_replace($this->_patKeys, $this->_patValues, $content); // Rename Clone values
                $this->addLog("-- Editing the content of '" . $this->relativePath($newPath) . "'");
                file_put_contents($newPath, $content);
            }
        }
    }

    function getConstantPattern($aPattern=false) {
        // Return the last 8 char of $this->_sCLONE
        if (strlen($this->_sCLONE) <= 8) {
            return $this->_sCLONE;
        }
        $ret = strrev($this->_sCLONE);
        $ret = substr($ret, 0, 8);
        $ret = strrev($ret);
        if ($aPattern) {
            $ret = $this->prefixSuffix($ret, $aPattern);
        }
        return $ret;
    }

    function prefixSuffix($text, $aPattern) {
        if (isset($aPattern['prefix'])) {
            $text = $aPattern['prefix'] . $text;
        }
        if (isset($aPattern['suffix'])) {
            $text = $text . $aPattern['suffix'] ;
        }
        return $text;
    }

    function setError($text) {
        $this->_errors[] = $text;
    }

    function getErrors() {
        $ret = '';
        foreach ($this->_errors as $error) {
            $ret .= "$error <br />";
        }
        return $ret;
    }

    function addLog($text) {
        $this->_logs[] = $text;
    }

    function getLogs() {
        $ret = '';
        foreach ($this->_logs as $log) {
            $ret .= "$log\r\n";
        }
        return $ret;
    }

    function relativePath($path) {
        return str_replace(XOOPS_ROOT_PATH . '/modules/', '', $path);
    }

    function storeLogsToFile() {
        $filename = $this->_newPath ."/cloning.log";
        return file_put_contents($filename, $this->getLogs());
    }
}

?>