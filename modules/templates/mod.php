<?php
class templatesLbs extends moduleLbs {
    protected $_styles = array();
    public function init() {
        if (is_admin()) {
			if($isAdminPlugOptsPage = frameLbs::_()->isAdminPlugOptsPage()) {
				$this->loadCoreJs();
				$this->loadAdminCoreJs();
				$this->loadCoreCss();
				$this->loadChosenSelects();
				frameLbs::_()->addScript('adminOptionsLbs', LBS_JS_PATH. 'admin.options.js', array(), false, true);
				add_action('admin_enqueue_scripts', array($this, 'loadMediaScripts'));
			}
			// Some common styles - that need to be on all admin pages - be careful with them
			frameLbs::_()->addStyle('supsystic-for-all-admin-'. LBS_CODE, LBS_CSS_PATH. 'supsystic-for-all-admin.css');
		}
        parent::init();
    }
	public function loadMediaScripts() {
		wp_enqueue_media();
	}
	public function loadAdminCoreJs() {
		frameLbs::_()->addScript('jquery-ui-dialog');
		frameLbs::_()->addScript('jquery-ui-slider');
		frameLbs::_()->addScript('wp-color-picker');
		frameLbs::_()->addScript('tooltipster', LBS_JS_PATH. 'jquery.tooltipster.min.js');
		frameLbs::_()->addScript('icheck', LBS_JS_PATH. 'icheck.min.js');
	}
	public function loadCoreJs() {
		frameLbs::_()->addScript('jquery');

		frameLbs::_()->addScript('commonLbs', LBS_JS_PATH. 'common.js');
		frameLbs::_()->addScript('coreLbs', LBS_JS_PATH. 'core.js');
		
		//frameLbs::_()->addScript('selecter', LBS_JS_PATH. 'jquery.fs.selecter.min.js');
		
		$ajaxurl = admin_url('admin-ajax.php');
		$jsData = array(
			'siteUrl'					=> LBS_SITE_URL,
			'imgPath'					=> LBS_IMG_PATH,
			'cssPath'					=> LBS_CSS_PATH,
			'loader'					=> LBS_LOADER_IMG,
			'close'						=> LBS_IMG_PATH. 'cross.gif',
			'ajaxurl'					=> $ajaxurl,
			//'options'					=> frameLbs::_()->getModule('options')->getAllowedPublicOptions(),
			'LBS_CODE'					=> LBS_CODE,
			//'ball_loader'				=> LBS_IMG_PATH. 'ajax-loader-ball.gif',
			//'ok_icon'					=> LBS_IMG_PATH. 'ok-icon.png',
		);
		if(is_admin()) {
			$jsData['isPro'] = frameLbs::_()->getModule('supsystic_promo')->isPro();
		}
		$jsData = dispatcherLbs::applyFilters('jsInitVariables', $jsData);
		frameLbs::_()->addJSVar('coreLbs', 'LBS_DATA', $jsData);
	}
	public function loadCoreCss() {
		$this->_styles = array(
			'styleLbs'			=> array('path' => LBS_CSS_PATH. 'style.css', 'for' => 'admin'),
			'supsystic-uiLbs'	=> array('path' => LBS_CSS_PATH. 'supsystic-ui.css', 'for' => 'admin'),
			'dashicons'			=> array('for' => 'admin'),
			'bootstrap-alerts'	=> array('path' => LBS_CSS_PATH. 'bootstrap-alerts.css', 'for' => 'admin'),
			'tooltipster'		=> array('path' => LBS_CSS_PATH. 'tooltipster.css', 'for' => 'admin'),
			'icheck'			=> array('path' => LBS_CSS_PATH. 'jquery.icheck.css', 'for' => 'admin'),
			//'uniform'			=> array('path' => LBS_CSS_PATH. 'uniform.default.css', 'for' => 'admin'),
			//'selecter'			=> array('path' => LBS_CSS_PATH. 'jquery.fs.selecter.min.css', 'for' => 'admin'),
			'wp-color-picker'	=> array('for' => 'admin'),
		);
		foreach($this->_styles as $s => $sInfo) {
			if(!empty($sInfo['path'])) {
				frameLbs::_()->addStyle($s, $sInfo['path']);
			} else {
				frameLbs::_()->addStyle($s);
			}
		}
		$this->loadFontAwesome();
	}
	public function loadJqueryUi() {
		static $loaded = false;
		if(!$loaded) {
			frameLbs::_()->addStyle('jquery-ui', LBS_CSS_PATH. 'jquery-ui.min.css');
			frameLbs::_()->addStyle('jquery-ui.structure', LBS_CSS_PATH. 'jquery-ui.structure.min.css');
			frameLbs::_()->addStyle('jquery-ui.theme', LBS_CSS_PATH. 'jquery-ui.theme.min.css');
			frameLbs::_()->addStyle('jquery-slider', LBS_CSS_PATH. 'jquery-slider.css');
			$loaded = true;
		}
	}
	public function loadJqGrid() {
		static $loaded = false;
		if(!$loaded) {
			$this->loadJqueryUi();
			frameLbs::_()->addScript('jq-grid', LBS_JS_PATH. 'jquery.jqGrid.min.js');
			frameLbs::_()->addStyle('jq-grid', LBS_CSS_PATH. 'ui.jqgrid.css');
			$langToLoad = utilsLbs::getLangCode2Letter();
			if(!file_exists(LBS_JS_DIR. 'i18n'. DS. 'grid.locale-'. $langToLoad. '.js')) {
				$langToLoad = 'en';
			}
			frameLbs::_()->addScript('jq-grid-lang', LBS_JS_PATH. 'i18n/grid.locale-'. $langToLoad. '.js');
			$loaded = true;
		}
	}

    public function loadFancybox() {
        static $loaded = false;
        if(!$loaded) {
            frameLbs::_()->addScript('fancybox-js', LBS_JS_PATH. 'fancybox/jquery.fancybox.pack.js');
            frameLbs::_()->addStyle('fancybox-css', LBS_JS_PATH. 'fancybox/jquery.fancybox.css');

            frameLbs::_()->addScript('fancybox-helpers-media-js', LBS_JS_PATH. 'fancybox/helpers/jquery.fancybox-buttons.js');
            frameLbs::_()->addScript('fancybox-helpers-buttons-js', LBS_JS_PATH. 'fancybox/helpers/jquery.fancybox-media.js');
            frameLbs::_()->addStyle('fancybox-helpers-css', LBS_JS_PATH. 'fancybox/helpers/jquery.fancybox-buttons.css');

            frameLbs::_()->addScript('fancybox-helpers-thumbs-js', LBS_JS_PATH. 'fancybox/helpers/jquery.fancybox-thumbs.js');
            frameLbs::_()->addStyle('fancybox-helpers-thumbs-css', LBS_JS_PATH. 'fancybox/helpers/jquery.fancybox-thumbs.css');
            $loaded = true;
        }
    }

	public function loadFontAwesome() {
		frameLbs::_()->addStyle('font-awesomeLbs', LBS_CSS_PATH. 'font-awesome.css');
	}
	public function loadChosenSelects() {
		frameLbs::_()->addStyle('jquery.chosen', LBS_CSS_PATH. 'chosen.min.css');
		frameLbs::_()->addScript('jquery.chosen', LBS_JS_PATH. 'chosen.jquery.min.js');
	}
	public function loadDatePicker() {
		frameLbs::_()->addScript('jquery-ui-datepicker');
	}
}
