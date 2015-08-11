<?php
    global $wpdb;
    if (!defined('WPLANG') || WPLANG == '') {
        define('LBS_WPLANG', 'en_GB');
    } else {
        define('LBS_WPLANG', WPLANG);
    }
    if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

    define('LBS_PLUG_NAME', basename(dirname(__FILE__)));
    define('LBS_DIR', WP_PLUGIN_DIR. DS. LBS_PLUG_NAME. DS);
    define('LBS_TPL_DIR', LBS_DIR. 'tpl'. DS);
    define('LBS_CLASSES_DIR', LBS_DIR. 'classes'. DS);
    define('LBS_TABLES_DIR', LBS_CLASSES_DIR. 'tables'. DS);
	define('LBS_HELPERS_DIR', LBS_CLASSES_DIR. 'helpers'. DS);
    define('LBS_LANG_DIR', LBS_DIR. 'lang'. DS);
    define('LBS_IMG_DIR', LBS_DIR. 'img'. DS);
    define('LBS_TEMPLATES_DIR', LBS_DIR. 'templates'. DS);
    define('LBS_MODULES_DIR', LBS_DIR. 'modules'. DS);
    define('LBS_FILES_DIR', LBS_DIR. 'files'. DS);
    define('LBS_ADMIN_DIR', ABSPATH. 'wp-admin'. DS);

    define('LBS_SITE_URL', get_bloginfo('wpurl'). '/');
    define('LBS_JS_PATH', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/js/');
    define('LBS_CSS_PATH', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/css/');
    define('LBS_IMG_PATH', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/img/');
    define('LBS_MODULES_PATH', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/modules/');
    define('LBS_TEMPLATES_PATH', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/templates/');
    define('LBS_JS_DIR', LBS_DIR. 'js/');

    define('LBS_URL', LBS_SITE_URL);

    define('LBS_LOADER_IMG', LBS_IMG_PATH. 'loading.gif');
	define('LBS_TIME_FORMAT', 'H:i:s');
    define('LBS_DATE_DL', '/');
    define('LBS_DATE_FORMAT', 'm/d/Y');
    define('LBS_DATE_FORMAT_HIS', 'm/d/Y ('. LBS_TIME_FORMAT. ')');
    define('LBS_DATE_FORMAT_JS', 'mm/dd/yy');
    define('LBS_DATE_FORMAT_CONVERT', '%m/%d/%Y');
    define('LBS_WPDB_PREF', $wpdb->prefix);
    define('LBS_DB_PREF', 'lbs_');
    define('LBS_MAIN_FILE', 'lbs.php');

    define('LBS_DEFAULT', 'default');
    define('LBS_CURRENT', 'current');
	
	define('LBS_EOL', "\n");
    
    define('LBS_PLUGIN_INSTALLED', true);
    define('LBS_VERSION', '1.0.4');
    define('LBS_USER', 'user');
    
    define('LBS_CLASS_PREFIX', 'lbsc');
    define('LBS_FREE_VERSION', false);
	define('LBS_TEST_MODE', true);
    
    define('LBS_SUCCESS', 'Success');
    define('LBS_FAILED', 'Failed');
	define('LBS_ERRORS', 'lbsErrors');
	
	define('LBS_ADMIN',	'admin');
	define('LBS_LOGGED','logged');
	define('LBS_GUEST',	'guest');
	
	define('LBS_ALL',		'all');
	
	define('LBS_METHODS',		'methods');
	define('LBS_USERLEVELS',	'userlevels');
	/**
	 * Framework instance code, unused for now
	 */
	define('LBS_CODE', 'lbs');

	define('LBS_LANG_CODE', 'lbs_lng');
	/**
	 * Plugin name
	 */
	define('LBS_WP_PLUGIN_NAME', 'Lightbox by Supsystic');

    /**
    * Custom defined for plugin
    */
    define('LBS_COMMON', 'common');
    define('LBS_FB_LIKE', 'fb_like');
    define('LBS_VIDEO', 'video');
    define('LBS_SHORTCODE_CLICK', 'supsystic-show-popup');
    define('LBS_SHORTCODE', 'supsystic-popup');

    define('LBS_HOME_PAGE_ID', 0);