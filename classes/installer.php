<?php
class installerLbs {
	static public $update_to_version_method = '';
	static private $_firstTimeActivated = false;
	static public function init() {
		global $wpdb;
		$wpPrefix = $wpdb->prefix; /* add to 0.0.3 Versiom */
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		$current_version = get_option($wpPrefix. LBS_DB_PREF. 'db_version', 0);
		if(!$current_version)
			self::$_firstTimeActivated = true;
		/**
		 * modules 
		 */
		if (!dbLbs::exist("@__modules")) {
			dbDelta(dbLbs::prepareQuery("CREATE TABLE IF NOT EXISTS `@__modules` (
			  `id` smallint(3) NOT NULL AUTO_INCREMENT,
			  `code` varchar(32) NOT NULL,
			  `active` tinyint(1) NOT NULL DEFAULT '0',
			  `type_id` tinyint(1) NOT NULL DEFAULT '0',
			  `label` varchar(64) DEFAULT NULL,
			  `ex_plug_dir` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE INDEX `code` (`code`)
			) DEFAULT CHARSET=utf8;"));
			dbLbs::query("INSERT INTO `@__modules` (id, code, active, type_id, label) VALUES
				(NULL, 'adminmenu',1,1,'Admin Menu'),
				(NULL, 'options',1,1,'Options'),
				(NULL, 'templates',1,1,'templates'),
				(NULL, 'supsystic_promo',1,1,'supsystic_promo'),
				(NULL, 'admin_nav',1,1,'admin_nav'),
				
				(NULL, 'lightbox',1,1,'lightbox'),
				
				(NULL, 'mail',1,1,'mail');");
		}
		/**
		 *  modules_type 
		 */
		if(!dbLbs::exist("@__modules_type")) {
			dbDelta(dbLbs::prepareQuery("CREATE TABLE IF NOT EXISTS `@__modules_type` (
			  `id` smallint(3) NOT NULL AUTO_INCREMENT,
			  `label` varchar(32) NOT NULL,
			  PRIMARY KEY (`id`)
			) AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;"));
			dbLbs::query("INSERT INTO `@__modules_type` VALUES
				(1,'system'),
				(6,'addons');");
		}
		/**
		 * Lightbox table
		 */
		if (!dbLbs::exist("@__lightbox")) {
			dbDelta(dbLbs::prepareQuery("CREATE TABLE IF NOT EXISTS `@__lightbox` (
				`id` INT(11) NOT NULL AUTO_INCREMENT,
				`settings` VARCHAR(1024) NULL DEFAULT NULL,
				`pages` VARCHAR (1024) NULL DEFAULT NULL,
				PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8;"));
			self::insertInitialSettins();
		}
		//self::addAdditionalLightboxes();
		/**
		* Plugin usage statistics
		*/
		if(!dbLbs::exist("@__usage_stat")) {
			dbDelta(dbLbs::prepareQuery("CREATE TABLE `@__usage_stat` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `code` varchar(64) NOT NULL,
			  `visits` int(11) NOT NULL DEFAULT '0',
			  `spent_time` int(11) NOT NULL DEFAULT '0',
			  `modify_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			  UNIQUE INDEX `code` (`code`),
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8"));
			dbLbs::query("INSERT INTO `@__usage_stat` (code, visits) VALUES ('installed', 1)");
		}
		installerDbUpdaterLbs::runUpdate();
		if($current_version && !self::$_firstTimeActivated) {
			self::setUsed();
		}
		update_option($wpPrefix. LBS_DB_PREF. 'db_version', LBS_VERSION);
		add_option($wpPrefix. LBS_DB_PREF. 'db_installed', 1);
	}
	static public function setUsed() {
		update_option(LBS_DB_PREF. 'plug_was_used', 1);
	}
	static public function isUsed() {
		// No welcome page for now
		return true;
		return (int) get_option(LBS_DB_PREF. 'plug_was_used');
	}
	static public function delete() {
		global $wpdb;
		$wpPrefix = $wpdb->prefix;
		$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.LBS_DB_PREF."modules`");
		$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.LBS_DB_PREF."modules_type`");
		$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.LBS_DB_PREF."usage_stat`");
		$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.LBS_DB_PREF."lightbox`");
		delete_option($wpPrefix. LBS_DB_PREF. 'db_version');
		delete_option($wpPrefix. LBS_DB_PREF. 'db_installed');
	}
	static public function update() {
		global $wpdb;
		$wpPrefix = $wpdb->prefix; /* add to 0.0.3 Versiom */
		$currentVersion = get_option($wpPrefix. LBS_DB_PREF. 'db_version', 0);
		if(!$currentVersion || version_compare(LBS_VERSION, $currentVersion, '>')) {
			self::init();
			update_option($wpPrefix. LBS_DB_PREF. 'db_version', LBS_VERSION);
		}
	}
	private function insertInitialSettins() {
		dbLbs::query('INSERT INTO @__lightbox VALUES
			(1, "{\"all\":\"on\",\"maxWidth\":900,\"maxHeight\":700,\"margin\":50,\"padding\":10,\"gallery\":\"on\",\"playSpeed\":\"2000\",\"closeBtn\":\"on\",\"nextClick\":\"on\",\"mouseWheel\":\"on\",\"openEffect\":\"elastic\",\"closeEffect\":\"elastic\",\"helpers\":{\"thumbs\":\"on\",\"title\":{\"type\":\"float\"}}}", NULL)');
	}
}
