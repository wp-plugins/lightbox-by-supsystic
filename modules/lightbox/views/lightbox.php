<?php
class lightboxViewLbs extends viewLbs {
	protected $_twig;
	private $_closeBtns = array();
	private $_bullets = array();
	private $_animationList = array();
	public function getTabContent() {
		frameLbs::_()->getModule('templates')->loadJqGrid();
		frameLbs::_()->addScript('settings-lbs', $this->getModule()->getModPath(). 'js/settings.lbs.js');
		//frameLbs::_()->addJSVar('admin.lightbox.list', 'ppsTblDataUrl', uriLbs::mod('lightbox', 'getListForTbl', array('reqType' => 'ajax')));
        frameLbs::_()->addStyle('admin-lightbox-style', $this->getModule()->getModPath(). 'css/admin.lightbox.css');

        $settings = $this->getModel('lightbox')->getSettings();
		
		$this->assign('savedSettings', json_decode($settings['settings']));
		return parent::getContent('lightboxAdmin');
	}
	public function modifyBreadcrumbsForChangeTpl($crumbs) {
		$crumbs[ count($crumbs) - 1 ]['label'] = __('Modify PopUp Template', LBS_LANG_CODE);
		return $crumbs;
	}
	public function adminBreadcrumbsClassAdd() {
		echo ' supsystic-sticky';
	}
	
	public function showEditPopupFormControls() {
		parent::display('popupEditFormControls');
	}
	public function sortEditPopupTabsClb($a, $b) {
		if($a['sort_order'] > $b['sort_order'])
			return 1;
		if($a['sort_order'] < $b['sort_order'])
			return -1;
		return 0;
	}
	public function getFbLikeOpts() {
		return array(
			'href' => array(
				'label' => __('Facebook page URL', LBS_LANG_CODE),
				'html' => 'text', 
				'desc' => __('The absolute URL of the Facebook Page that will be liked. This is a required setting.', LBS_LANG_CODE)),
			'colorscheme' => array(
				'label' => __('Color scheme', LBS_LANG_CODE),
				'html' => 'selectbox', 
				'options' => array('light' => __('Light', LBS_LANG_CODE), 'dark' => __('Dark', LBS_LANG_CODE)),
				'desc' => __('The color scheme used by the plugin. Can be "light" or "dark".', LBS_LANG_CODE)),
			'force_wall' => array(
				'label' => __('Force wall', LBS_LANG_CODE),
				'html' => 'checkbox', 
				'desc' => __('For "place" Pages (Pages that have a physical location that can be used with check-ins), this specifies whether the stream contains posts by the Page or just check-ins from friends.', LBS_LANG_CODE)),
			'header' => array(
				'label' => __('Header', LBS_LANG_CODE),
				'html' => 'checkbox', 
				'desc' => __('Specifies whether to display the Facebook header at the top of the plugin.', LBS_LANG_CODE)),
			'show_border' => array(
				'label' => __('Show border', LBS_LANG_CODE),
				'html' => 'checkbox', 
				'desc' => __('Specifies whether or not to show a border around the plugin.', LBS_LANG_CODE)),
			'show_faces' => array(
				'label' => __('Show faces', LBS_LANG_CODE),
				'html' => 'checkbox', 
				'desc' => __('Specifies whether to display profile photos of people who like the page.', LBS_LANG_CODE)),
			'stream' => array(
				'label' => __('Stream', LBS_LANG_CODE),
				'html' => 'checkbox', 
				'desc' => __('Specifies whether to display a stream of the latest posts by the Page.', LBS_LANG_CODE)),
		);
	}
	public function getMainPopupDesignTab() {
		return parent::getContent('popupEditAdminDesignOpts');
	}
	public function getMainPopupOptsTab() {
		return parent::getContent('popupEditAdminMainOpts');
	}
	public function getMainPopupTplTab() {
		return parent::getContent('popupEditAdminTplOpts');
	}
	public function getMainPopupTextsTab() {
		return parent::getContent('popupEditAdminTextsOpts');
	}
	public function getMainPopupSubTab() {
		frameLbs::_()->getModule('subscribe')->loadAdminEditAssets();
		$mailPoetAvailable = class_exists('WYSIJA');
		if($mailPoetAvailable) {
			$mailPoetLists = WYSIJA::get('list', 'model')->get(array('name', 'list_id'), array('is_enabled' => 1));
			$mailPoetListsSelect = array();
			if(!empty($mailPoetLists)) {
				foreach($mailPoetLists as $l) {
					$mailPoetListsSelect[ $l['list_id'] ] = $l['name'];
				}
			}
			$this->assign('mailPoetListsSelect', $mailPoetListsSelect);
		}
		$this->assign('availableUserRoles', frameLbs::_()->getModule('subscribe')->getAvailableUserRolesForSelect());
		$this->assign('mailPoetAvailable', $mailPoetAvailable);
		return parent::getContent('popupEditAdminSubOpts');
	}
	public function getMainPopupSmTab() {
		return parent::getContent('popupEditAdminSmOpts');
	}
	public function getMainPopupCodeTab() {
		return parent::getContent('popupEditAdminCodeOpts');
	}
	public function getMainPopupAnimationTab() {
		frameLbs::_()->addStyle('magic.min', LBS_CSS_PATH. 'magic.min.css');
		$this->assign('animationList', $this->getAnimationList());
		return parent::getContent('popupEditAdminAnimationOpts');
	}
	public function getAnimationList() {
		if(empty($this->_animationList)) {
			$this->_animationList = array(
				'none' => array('label' => __('None', LBS_LANG_CODE)),
				'puff' => array('label' => __('Puff', LBS_LANG_CODE), 'show_class' => 'puffIn', 'hide_class' => 'puffOut'),
				'vanish' => array('label' => __('Vanish', LBS_LANG_CODE), 'show_class' => 'vanishIn', 'hide_class' => 'vanishOut'),
				
				'open_down_left' => array('label' => __('Open down left', LBS_LANG_CODE), 'show_class' => 'openDownLeftRetourn', 'hide_class' => 'openDownLeft'),
				'open_down_right' => array('label' => __('Open down right', LBS_LANG_CODE), 'show_class' => 'openDownRightRetourn', 'hide_class' => 'openDownRight'),
				
				'perspective_down' => array('label' => __('Perspective down', LBS_LANG_CODE), 'show_class' => 'perspectiveDownRetourn', 'hide_class' => 'perspectiveDown'),
				'perspective_up' => array('label' => __('Perspective up', LBS_LANG_CODE), 'show_class' => 'perspectiveUpRetourn', 'hide_class' => 'perspectiveUp'),
				
				'slide_down' => array('label' => __('Slide down', LBS_LANG_CODE), 'show_class' => 'slideDownRetourn', 'hide_class' => 'slideDown'),
				'slide_up' => array('label' => __('Slide up', LBS_LANG_CODE), 'show_class' => 'slideUpRetourn', 'hide_class' => 'slideUp'),
				
				'swash' => array('label' => __('Swash', LBS_LANG_CODE), 'show_class' => 'swashIn', 'hide_class' => 'swashOut'),
				'foolis' => array('label' => __('Foolis', LBS_LANG_CODE), 'show_class' => 'foolishIn', 'hide_class' => 'foolishOut'),
				
				'tin_right' => array('label' => __('Tin right', LBS_LANG_CODE), 'show_class' => 'tinRightIn', 'hide_class' => 'tinRightOut'),
				'tin_left' => array('label' => __('Tin left', LBS_LANG_CODE), 'show_class' => 'tinLeftIn', 'hide_class' => 'tinLeftOut'),
				'tin_up' => array('label' => __('Tin up', LBS_LANG_CODE), 'show_class' => 'tinUpIn', 'hide_class' => 'tinUpOut'),
				'tin_down' => array('label' => __('Tin down', LBS_LANG_CODE), 'show_class' => 'tinDownIn', 'hide_class' => 'tinDownOut'),
				
				'boing' => array('label' => __('Boing', LBS_LANG_CODE), 'show_class' => 'boingInUp', 'hide_class' => 'boingOutDown'),
				
				'space_right' => array('label' => __('Space right', LBS_LANG_CODE), 'show_class' => 'spaceInRight', 'hide_class' => 'spaceOutRight'),
				'space_left' => array('label' => __('Space left', LBS_LANG_CODE), 'show_class' => 'spaceInLeft', 'hide_class' => 'spaceOutLeft'),
				'space_up' => array('label' => __('Space up', LBS_LANG_CODE), 'show_class' => 'spaceInUp', 'hide_class' => 'spaceOutUp'),
				'space_down' => array('label' => __('Space down', LBS_LANG_CODE), 'show_class' => 'spaceInDown', 'hide_class' => 'spaceOutDown'),
			);
		}
		return $this->_animationList;
	}
	public function getAnimationByKey($key) {
		$this->getAnimationList();
		return isset($this->_animationList[ $key ]) ? $this->_animationList[ $key ] : false;
	}
	public function adjustBrightness($hex, $steps) {
		 // Steps should be between -255 and 255. Negative = darker, positive = lighter
		$steps = max(-255, min(255, $steps));

		// Normalize into a six character long hex string
		$hex = str_replace('#', '', $hex);
		if (strlen($hex) == 3) {
			$hex = str_repeat(substr($hex, 0, 1), 2). str_repeat(substr($hex, 1, 1), 2). str_repeat(substr($hex, 2, 1), 2);
		}

		// Split into three parts: R, G and B
		$color_parts = str_split($hex, 2);
		$return = '#';

		foreach ($color_parts as $color) {
			$color   = hexdec($color); // Convert to decimal
			$color   = max(0, min(255, $color + $steps)); // Adjust color
			$return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
		}

		return $return;
	}
	private function _generateVideoHtml($popup) {
		$res = '';
		if(isset($popup['params']['tpl']['video_url']) && !empty($popup['params']['tpl']['video_url'])) {
			add_filter('oembed_result', array($this,'modifyEmbRes'), 10, 3);
			$attrs = array();
			if(isset($popup['params']['opts_attrs']['video_width_as_popup']) && $popup['params']['opts_attrs']['video_width_as_popup']) {
				$attrs['width'] = $popup['params']['tpl']['width'];
			}
			if(isset($popup['params']['opts_attrs']['video_height_as_popup']) && $popup['params']['opts_attrs']['video_height_as_popup']) {
				$attrs['height'] = $popup['params']['tpl']['height'];
			}
			if(isset($popup['params']['tpl']['video_autoplay']) && $popup['params']['tpl']['video_autoplay']) {
				$attrs['autoplay'] = 1;
			}
			if(isset($popup['params']['tpl']['vide_hide_controls']) && $popup['params']['tpl']['vide_hide_controls']) {
				$attrs['vide_hide_controls'] = 1;
			}
			$res = wp_oembed_get($popup['params']['tpl']['video_url'], $attrs);
		}
		return $res;
	}
	public function modifyEmbRes($html, $url, $attrs) {
		if(isset($attrs['autoplay']) && $attrs['autoplay']) {
			preg_match('/\<iframe.+src\=\"(?P<SRC>.+)\"/iUs', $html, $matches);
			if($matches && isset($matches['SRC']) && !empty($matches['SRC'])) {
				$newSrc = $matches['SRC']. (strpos($matches['SRC'], '?') ? '&' : '?'). 'autoplay=1';
				$html = str_replace($matches['SRC'], $newSrc, $html);
			}
		}
		if(isset($attrs['vide_hide_controls']) && $attrs['vide_hide_controls']) {
			preg_match('/\<iframe.+src\=\"(?<SRC>.+)\"/iUs', $html, $matches);
			if($matches && isset($matches['SRC']) && !empty($matches['SRC'])) {
				$newSrc = $matches['SRC']. (strpos($matches['SRC'], '?') ? '&' : '?'). 'controls=0';
				$html = str_replace($matches['SRC'], $newSrc, $html);
			}
		}		
		return $html;
	}
	private function _generateFbLikeWidget($popup) {
		$res = '';
		$res .= '<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/'. utilsLbs::getLangCode(). '/sdk.js#xfbml=1&version=v2.0";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, \'script\', \'facebook-jssdk\'));</script>';
		$res .= '<div class="fb-like-box"';
		$fbLikeOpts = $this->getFbLikeOpts();
		foreach($fbLikeOpts as $fKey => $fData) {
			$dataKey = 'data-'. str_replace('_', '-', $fKey);
			$value = '';
			if($fData['html'] == 'checkbox') {
				$value = isset($popup['params']['tpl']['fb_like_opts'][ $fKey ]) && $popup['params']['tpl']['fb_like_opts'][ $fKey ]
					? 'true'
					: 'false';
			} else {
				$value = $popup['params']['tpl']['fb_like_opts'][ $fKey ];
			}
			$res .= ' '. $dataKey.'="'. $value. '"';
		}
		if(isset($popup['params']['tpl']['width']) && !empty($popup['params']['tpl']['width'])) {
			$res .= ' data-width="'. $popup['params']['tpl']['width']. '"';
		}
		if(isset($popup['params']['tpl']['height']) && !empty($popup['params']['tpl']['height'])) {
			$res .= ' data-height="'. $popup['params']['tpl']['height']. '"';
		}
		$res .= '></div>';
		return $res;
	}
	private function _replaceTagsWithTwig($string, $popup) {
		$string = preg_replace('/\[if (.+)\]/iU', '{% if lightbox.params.tpl.$1 %}', $string);
		$string = preg_replace('/\[elseif (.+)\]/iU', '{% elseif lightbox.params.tpl.$1 %}', $string);
		
		$replaceFrom = array('ID', 'endif', 'else');
		$replaceTo = array($popup['view_id'], '{% endif %}', '{% else %}');
		if(isset($popup['params']) && isset($popup['params']['tpl'])) {
			foreach($popup['params']['tpl'] as $key => $val) {
				if(is_array($val)) {
					foreach($val as $key2 => $val2) {
						$replaceFrom[] = $key. '_'. $key2;
						$replaceTo[] = $val2;
					}
				} else {
					// Do shortcodes for all text type data in lightbox
					if(strpos($key, 'txt_') === 0 || strpos($key, 'label') === 0 || strpos($key, 'foot_note')) {
						$val = do_shortcode( $val );
					}
					$replaceFrom[] = $key;
					$replaceTo[] = $val;
				}
			}
		}
		foreach($replaceFrom as $i => $v) {
			$replaceFrom[ $i ] = '['. $v. ']';
		}
		return str_replace($replaceFrom, $replaceTo, $string);
		
	}
	public function getCloseBtns() {
		if(empty($this->_closeBtns)) {
			$this->_closeBtns = array(
				'none' => array('label' => __('None', LBS_LANG_CODE)),
				'classy_grey' => array('img' => 'classy_grey.png', 'add_style' => array('top' => '-16px', 'right' => '-16px', 'width' => '42px', 'height' => '42px')),
				'close-orange' => array('img' => 'close-orange.png', 'add_style' => array('top' => '-16px', 'right' => '-16px', 'width' => '42px', 'height' => '42px')),
				'close-red-in-circle' => array('img' => 'close-red-in-circle.png', 'add_style' => array('top' => '-16px', 'right' => '-16px', 'width' => '42px', 'height' => '42px')),
				'lists_black' => array('img' => 'lists_black.png', 'add_style' => array('top' => '-10px', 'right' => '-10px', 'width' => '25px', 'height' => '25px')),
				'while_close' => array('img' => 'while_close.png', 'add_style' => array('top' => '15px', 'right' => '15px', 'width' => '20px', 'height' => '19px')),
				'red_close' => array('img' => 'close-red.png', 'add_style' => array('top' => '15px', 'right' => '20px', 'width' => '25px', 'height' => '25px')),
				'yellow_close' => array('img' => 'close-yellow.png', 'add_style' => array('top' => '-16px', 'right' => '-16px', 'width' => '42px', 'height' => '42px')),
				'sqr_close' => array('img' => 'sqr-close.png', 'add_style' => array('top' => '25px', 'right' => '20px', 'width' => '25px', 'height' => '25px')),
			);
			foreach($this->_closeBtns as $key => $data) {
				if(isset($data['img'])) {
					if(!isset($data['img_url']))
						$this->_closeBtns[ $key ]['img_url'] = $this->getModule()->getModPath(). 'img/assets/close_btns/'. $data['img'];
				}
			}
		}
		return $this->_closeBtns;
	}
	public function getBullets() {
		if(empty($this->_bullets)) {
			$this->_bullets = array(
				'none' => array('label' => __('None (standard)', LBS_LANG_CODE)),
				'classy_blue' => array('img' => 'classy_blue.png', 'add_style' => array('list-style' => 'outside none none !important', 'background-repeat' => 'no-repeat', 'padding-left' => '30px', 'line-height' => '100%', 'height' => '38px')),
				'circle_green' => array('img' => 'circle_green.png', 'add_style' => array('list-style' => 'outside none none !important', 'background-repeat' => 'no-repeat', 'padding-left' => '30px', 'line-height' => '100%', 'height' => '30px')),
				'lists_green' => array('img' => 'lists_green.png', 'add_style' => array('list-style' => 'outside none none !important', 'background-repeat' => 'no-repeat', 'padding-left' => '30px', 'line-height' => '100%', 'height' => '38px')),
				'tick' => array('img' => 'tick.png', 'add_style' => array('list-style' => 'outside none none !important', 'background-repeat' => 'no-repeat', 'padding-left' => '30px', 'line-height' => '100%', 'height' => '30px')),
				'tick_blue' => array('img' => 'tick_blue.png', 'add_style' => array('list-style' => 'outside none none !important', 'background-repeat' => 'no-repeat', 'padding-left' => '30px', 'line-height' => '100%', 'height' => '30px')),
				'ticks' => array('img' => 'ticks.png', 'add_style' => array('list-style' => 'outside none none !important', 'background-repeat' => 'no-repeat', 'padding-left' => '30px', 'line-height' => '100%', 'height' => '30px')),
			);
			foreach($this->_bullets as $key => $data) {
				if(isset($data['img']) && !isset($data['img_url'])) {
					$this->_bullets[ $key ]['img_url'] = $this->getModule()->getModPath(). 'img/assets/bullets/'. $data['img'];
				}
			}
		}
		return $this->_bullets;
	}
	protected function _initTwig() {
		if(!$this->_twig) {
			if(!class_exists('Twig_Autoloader')) {
				require_once(LBS_CLASSES_DIR. 'Twig'. DS. 'Autoloader.php');
			}
			Twig_Autoloader::register();
			$this->_twig = new Twig_Environment(new Twig_Loader_String(), array('debug' => 1));
			$this->_twig->addFunction(
				new Twig_SimpleFunction('adjust_brightness', array(
						$this,
						'adjustBrightness'
					)
				)
			);
		}
	}
}
