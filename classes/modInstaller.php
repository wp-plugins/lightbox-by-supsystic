<?php
class modInstallerLbs {
    static private $_current = array();
    /**
     * Install new moduleLbs into plugin
     * @param string $module new moduleLbs data (@see classes/tables/modules.php)
     * @param string $path path to the main plugin file from what module is installed
     * @return bool true - if install success, else - false
     */
    static public function install($module, $path) {
        $exPlugDest = explode('plugins', $path);
        if(!empty($exPlugDest[1])) {
            $module['ex_plug_dir'] = str_replace(DS, '', $exPlugDest[1]);
        }
        $path = $path. DS. $module['code'];
        if(!empty($module) && !empty($path) && is_dir($path)) {
            if(self::isModule($path)) {
                $filesMoved = false;
                if(empty($module['ex_plug_dir']))
                    $filesMoved = self::moveFiles($module['code'], $path);
                else
                    $filesMoved = true;     //Those modules doesn't need to move their files
                if($filesMoved) {
                    if(frameLbs::_()->getTable('modules')->exists($module['code'], 'code')) {
                        frameLbs::_()->getTable('modules')->delete(array('code' => $module['code']));
                    }
					if($module['code'] != 'license')
						$module['active'] = 0;
                    frameLbs::_()->getTable('modules')->insert($module);
                    self::_runModuleInstall($module);
                    self::_installTables($module);
                    return true;
                } else {
                    errorsLbs::push(sprintf(__('Move files for %s failed'), $module['code']), errorsLbs::MOD_INSTALL);
                }
            } else
                errorsLbs::push(sprintf(__('%s is not plugin module'), $module['code']), errorsLbs::MOD_INSTALL);
        }
        return false;
    }
    static protected function _runModuleInstall($module, $action = 'install') {
        $moduleLocationDir = LBS_MODULES_DIR;
        if(!empty($module['ex_plug_dir']))
            $moduleLocationDir = utilsLbs::getPluginDir( $module['ex_plug_dir'] );
        if(is_dir($moduleLocationDir. $module['code'])) {
			if(!class_exists($module['code']. strFirstUp(LBS_CODE))) {
				importClassLbs($module['code'], $moduleLocationDir. $module['code']. DS. 'mod.php');
			}
            $moduleClass = toeGetClassNameLbs($module['code']);
            $moduleObj = new $moduleClass($module);
            if($moduleObj) {
                $moduleObj->$action();
            }
        }
    }
    /**
     * Check whether is or no module in given path
     * @param string $path path to the module
     * @return bool true if it is module, else - false
     */
    static public function isModule($path) {
        return true;
    }
    /**
     * Move files to plugin modules directory
     * @param string $code code for module
     * @param string $path path from what module will be moved
     * @return bool is success - true, else - false
     */
    static public function moveFiles($code, $path) {
        if(!is_dir(LBS_MODULES_DIR. $code)) {
            if(mkdir(LBS_MODULES_DIR. $code)) {
                utilsLbs::copyDirectories($path, LBS_MODULES_DIR. $code);
                return true;
            } else 
                errorsLbs::push(__('Can not create module directory. Try to set permission to '. LBS_MODULES_DIR. ' directory 755 or 777', LBS_LANG_CODE), errorsLbs::MOD_INSTALL);
        } else
            return true;
        return false;
    }
    static private function _getPluginLocations() {
        $locations = array();
        $plug = reqLbs::getVar('plugin');
        if(empty($plug)) {
            $plug = reqLbs::getVar('checked');
            $plug = $plug[0];
        }
        $locations['plugPath'] = plugin_basename( trim( $plug ) );
        $locations['plugDir'] = dirname(WP_PLUGIN_DIR. DS. $locations['plugPath']);
		$locations['plugMainFile'] = WP_PLUGIN_DIR. DS. $locations['plugPath'];
        $locations['xmlPath'] = $locations['plugDir']. DS. 'install.xml';
        return $locations;
    }
    static private function _getModulesFromXml($xmlPath) {
        if($xml = utilsLbs::getXml($xmlPath)) {
            if(isset($xml->modules) && isset($xml->modules->mod)) {
                $modules = array();
                $xmlMods = $xml->modules->children();
                foreach($xmlMods->mod as $mod) {
                    $modules[] = $mod;
                }
                if(empty($modules))
                    errorsLbs::push(__('No modules were found in XML file', LBS_LANG_CODE), errorsLbs::MOD_INSTALL);
                else
                    return $modules;
            } else
                errorsLbs::push(__('Invalid XML file', LBS_LANG_CODE), errorsLbs::MOD_INSTALL);
        } else
            errorsLbs::push(__('No XML file were found', LBS_LANG_CODE), errorsLbs::MOD_INSTALL);
        return false;
    }
    /**
     * Check whether modules is installed or not, if not and must be activated - install it
     * @param array $codes array with modules data to store in database
     * @param string $path path to plugin file where modules is stored (__FILE__ for example)
     * @return bool true if check ok, else - false
     */
    static public function check($extPlugName = '') {
		if(LBS_TEST_MODE) {
			add_action('activated_plugin', array(frameLbs::_(), 'savePluginActivationErrors'));
		}
        $locations = self::_getPluginLocations();
        if($modules = self::_getModulesFromXml($locations['xmlPath'])) {
            foreach($modules as $m) {
                $modDataArr = utilsLbs::xmlNodeAttrsToArr($m);
                if(!empty($modDataArr)) {
                    if(frameLbs::_()->moduleExists($modDataArr['code'])) { //If module Exists - just activate it
                        self::activate($modDataArr);
                    } else {                                           //  if not - install it
                        if(!self::install($modDataArr, $locations['plugDir'])) {
                            errorsLbs::push(sprintf(__('Install %s failed'), $modDataArr['code']), errorsLbs::MOD_INSTALL);
                        }
                    }
                }
            }
        } else
            errorsLbs::push(__('Error Activate module', LBS_LANG_CODE), errorsLbs::MOD_INSTALL);
        if(errorsLbs::haveErrors(errorsLbs::MOD_INSTALL)) {
            self::displayErrors();
            return false;
        }
		update_option(LBS_CODE. '_full_installed', 1);
        return true;
    }
    /**
	 * Public alias for _getCheckRegPlugs()
	 */
	/**
	 * We will run this each time plugin start to check modules activation messages
	 */
	static public function checkActivationMessages() {

	}
    /**
     * Deactivate module after deactivating external plugin
     */
    static public function deactivate() {
        $locations = self::_getPluginLocations();
        if($modules = self::_getModulesFromXml($locations['xmlPath'])) {
            foreach($modules as $m) {
                $modDataArr = utilsLbs::xmlNodeAttrsToArr($m);
                if(frameLbs::_()->moduleActive($modDataArr['code'])) { //If module is active - then deacivate it
                    if(frameLbs::_()->getModule('options')->getModel('modules')->put(array(
                        'id' => frameLbs::_()->getModule($modDataArr['code'])->getID(),
                        'active' => 0,
                    ))->error) {
                        errorsLbs::push(__('Error Deactivation module', LBS_LANG_CODE), errorsLbs::MOD_INSTALL);
                    }
                }
            }
        }
        if(errorsLbs::haveErrors(errorsLbs::MOD_INSTALL)) {
            self::displayErrors(false);
            return false;
        }
        return true;
    }
    static public function activate($modDataArr) {
        $locations = self::_getPluginLocations();
        if($modules = self::_getModulesFromXml($locations['xmlPath'])) {
            foreach($modules as $m) {
                $modDataArr = utilsLbs::xmlNodeAttrsToArr($m);
                if(!frameLbs::_()->moduleActive($modDataArr['code'])) { //If module is not active - then acivate it
                    if(frameLbs::_()->getModule('options')->getModel('modules')->put(array(
                        'code' => $modDataArr['code'],
                        'active' => 1,
                    ))->error) {
                        errorsLbs::push(__('Error Activating module', LBS_LANG_CODE), errorsLbs::MOD_INSTALL);
                    } else {
						$dbModData = frameLbs::_()->getModule('options')->getModel('modules')->get(array('code' => $modDataArr['code']));
						if(!empty($dbModData) && !empty($dbModData[0])) {
							$modDataArr['ex_plug_dir'] = $dbModData[0]['ex_plug_dir'];
						}
						self::_runModuleInstall($modDataArr, 'activate');
					}
                }
            }
        }
    } 
    /**
     * Display all errors for module installer, must be used ONLY if You realy need it
     */
    static public function displayErrors($exit = true) {
        $errors = errorsLbs::get(errorsLbs::MOD_INSTALL);
        foreach($errors as $e) {
            echo '<b style="color: red;">'. $e. '</b><br />';
        }
        if($exit) exit();
    }
    static public function uninstall() {
        $locations = self::_getPluginLocations();
        if($modules = self::_getModulesFromXml($locations['xmlPath'])) {
            foreach($modules as $m) {
                $modDataArr = utilsLbs::xmlNodeAttrsToArr($m);
                self::_uninstallTables($modDataArr);
                frameLbs::_()->getModule('options')->getModel('modules')->delete(array('code' => $modDataArr['code']));
                utilsLbs::deleteDir(LBS_MODULES_DIR. $modDataArr['code']);
            }
        }
    }
    static protected  function _uninstallTables($module) {
        if(is_dir(LBS_MODULES_DIR. $module['code']. DS. 'tables')) {
            $tableFiles = utilsLbs::getFilesList(LBS_MODULES_DIR. $module['code']. DS. 'tables');
            if(!empty($tableNames)) {
                foreach($tableFiles as $file) {
                    $tableName = str_replace('.php', '', $file);
                    if(frameLbs::_()->getTable($tableName))
                        frameLbs::_()->getTable($tableName)->uninstall();
                }
            }
        }
    }
    static public function _installTables($module, $action = 'install') {
		$modDir = empty($module['ex_plug_dir']) ? 
            LBS_MODULES_DIR. $module['code']. DS :
            utilsLbs::getPluginDir($module['ex_plug_dir']). $module['code']. DS;
        if(is_dir($modDir. 'tables')) {
            $tableFiles = utilsLbs::getFilesList($modDir. 'tables');
            if(!empty($tableFiles)) {
                frameLbs::_()->extractTables($modDir. 'tables'. DS);
                foreach($tableFiles as $file) {
                    $tableName = str_replace('.php', '', $file);
                    if(frameLbs::_()->getTable($tableName))
                        frameLbs::_()->getTable($tableName)->$action();
                }
            }
        }
    }
}