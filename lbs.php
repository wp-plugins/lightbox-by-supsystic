<?php
/**
 * Plugin Name: Lightbox by Supsystic
 * Plugin URI: https://supsystic.com
 * Description: Nice solution to add responsive lightbox (overlay) to display images, videos and galleries. Attract users with cool effects.
 * Version: 1.0.4
 * Author: supsystic.com
 * Author URI: https://supsystic.com
 **/
	/**
	 * Base config constants and functions
	 */
    require_once(dirname(__FILE__). DIRECTORY_SEPARATOR. 'config.php');
    require_once(dirname(__FILE__). DIRECTORY_SEPARATOR. 'functions.php');
	/**
	 * Connect all required core classes
	 */
    importClassLbs('dbLbs');
    importClassLbs('installerLbs');
    importClassLbs('baseObjectLbs');
    importClassLbs('moduleLbs');
    importClassLbs('modelLbs');
    importClassLbs('viewLbs');
    importClassLbs('controllerLbs');
    importClassLbs('helperLbs');
    importClassLbs('dispatcherLbs');
    importClassLbs('fieldLbs');
    importClassLbs('tableLbs');
    importClassLbs('frameLbs');
	/**
	 * @deprecated since version 1.0.1
	 */
    importClassLbs('langLbs');
    importClassLbs('reqLbs');
    importClassLbs('uriLbs');
    importClassLbs('htmlLbs');
    importClassLbs('responseLbs');
    importClassLbs('fieldAdapterLbs');
    importClassLbs('validatorLbs');
    importClassLbs('errorsLbs');
    importClassLbs('utilsLbs');
    importClassLbs('modInstallerLbs');
	importClassLbs('installerDbUpdaterLbs');
	importClassLbs('dateLbs');
	/**
	 * Check plugin version - maybe we need to update database, and check global errors in request
	 */
    installerLbs::update();
    errorsLbs::init();
    /**
	 * Start application
	 */
    frameLbs::_()->parseRoute();
    frameLbs::_()->init();
    frameLbs::_()->exec();
