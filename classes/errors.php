<?php
class errorsLbs {
    const FATAL = 'fatal';
    const MOD_INSTALL = 'mod_install';
    static private $errors = array();
    static private $haveErrors = false;
    
    static public $current = array();
    static public $displayed = false;
    
    static public function push($error, $type = 'common') {
        if(!isset(self::$errors[$type]))
            self::$errors[$type] = array();
        if(is_array($error))
            self::$errors[$type] = array_merge(self::$errors[$type], $error);
        else
            self::$errors[$type][] = $error;
        self::$haveErrors = true;
        
        if($type == 'session') 
            self::setSession(self::$errors[$type]);
    }
    static public function setSession($error) {
        $sesErrors = self::getSession();
        if(empty($sesErrors))
            $sesErrors = array();
        if(is_array($error))
            $sesErrors = array_merge($sesErrors, $error);
        else
            $sesErrors[] = $error;
        reqLbs::setVar('sesErrors', $sesErrors, 'session');
    }
    static public function init() {
        $lbsErrors = reqLbs::getVar('lbsErrors');
        if(!empty($lbsErrors)) {
            if(!is_array($lbsErrors)) {
                $lbsErrors = array( $lbsErrors );
            }
            $lbsErrors = array_map('htmlspecialchars', array_map('stripslashes', array_map('trim', $lbsErrors)));
            if(!empty($lbsErrors)) {
                self::$current = $lbsErrors;
				if(is_admin()) {
					add_action('admin_notices', array('errorsLbs', 'showAdminErrors'));
				} else {
					add_filter('the_content', array('errorsLbs', 'appendErrorsContent'), 99999);
				}
            }
        }
    }
	static public function showAdminErrors() {
		if(self::$current) {
			$html = '';
			foreach(self::$current as $error) {
				$html .= '<div class="error"><p><strong style="font-size: 15px;">'. $error. '</strong></p></div>';
			}
			echo $html;
		}
	}
    static public function appendErrorsContent($content) {
        if(!self::$displayed && !empty(self::$current)) {
            $content = '<div class="toeErrorMsg">'. implode('<br />', self::$current). '</div>'. $content;
            self::$displayed = true;
        }
        return $content;
    }
    static public function getSession() {
        return reqLbs::getVar('sesErrors', 'session');
    }
    static public function clearSession() {
        reqLbs::clearVar('sesErrors', 'session');
    }
    static public function get($type = '') {
        $res = array();
        if(!empty(self::$errors)) {
            if(empty($type)) {
                foreach(self::$errors as $e) {
                    foreach($e as $error) {
                        $res[] = $error;
                    }
                }
            } else 
                $res = self::$errors[$type];
        }
        return $res;
    }
    static public function haveErrors($type = '') {
        if(empty($type))
            return self::$haveErrors;
        else
            return isset(self::$errors[$type]);
    }
}

