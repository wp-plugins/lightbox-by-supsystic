<?php
class lightboxLbs extends moduleLbs {
	public function init() {
		dispatcherLbs::addFilter('mainAdminTabs', array($this, 'addAdminTab'));
		add_action('template_redirect', array($this, 'checkLightboxShow'));
		//add_shortcode(LBS_SHORTCODE_CLICK, array($this, 'showPopupOnClick'));
		//add_action('wp_footer', array($this, 'collectFooterRender'));
	}
	public function addAdminTab($tabs) {
		$tabs[ $this->getCode() ] = array(
			'label' => __('Settings', LBS_LANG_CODE), 'callback' => array($this, 'getTabContent'), 'fa_icon' => 'fa-list', 'sort_order' => 20, //'is_main' => true,
		);

		return $tabs;
	}
	public function getTabContent() {
		return $this->getView()->getTabContent();
	}
	public function getEditLink($id, $popupTab = '') {
		$link = frameLbs::_()->getModule('options')->getTabUrl( $this->getCode(). '_edit' );
		$link .= '&id='. $id;
		if(!empty($popupTab)) {
			$link .= '#'. $popupTab;
		}
		return $link;
	}
	public function checkLightboxShow() {
		global $wp_query;
		$currentPageId = (int) get_the_ID();

        $settings = $this->getModel()->getSettings();
        $settings = json_decode($settings['settings'], true);
        if(isset($settings['page']) && $settings['page']) {
            $pages = $this->getModel()->getPages();
            if(in_array($currentPageId, $pages)) {
                $this->renderList($settings);
            }
        } else {
            $this->renderList($settings);
        }
	}
	public function renderList($settings, $jsListVarName = 'lbsSettings') {
		frameLbs::_()->getModule('templates')->loadCoreJs();
        frameLbs::_()->getModule('templates')->loadFancybox();
		frameLbs::_()->addScript('frontend.lightbox', $this->getModPath(). 'js/frontend.lightbox.js');
		frameLbs::_()->addJSVar('frontend.lightbox', $jsListVarName, $settings);
		//frameLbs::_()->addStyle('frontend.lightbox', $this->getModPath(). 'css/frontend.lightbox.css');
		//frameLbs::_()->addStyle('magic.min', LBS_CSS_PATH. 'magic.min.css');
	}
}

