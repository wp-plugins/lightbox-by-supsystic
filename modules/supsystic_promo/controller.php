<?php
class supsystic_promoControllerLbs extends controllerLbs {
    public function welcomePageSaveInfo() {
		$res = new responseLbs();
		installerLbs::setUsed();
		if($this->getModel()->welcomePageSaveInfo(reqLbs::get('get'))) {
			$res->addMessage(__('Information was saved. Thank you!', LBS_LANG_CODE));
		} else {
			$res->pushError($this->getModel()->getErrors());
		}
		$originalPage = reqLbs::getVar('original_page');
		$http = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
		if(strpos($originalPage, $http. $_SERVER['HTTP_HOST']) !== 0) {
			$originalPage = '';
		}
		redirectLbs($originalPage);
	}
	public function sendContact() {
		$res = new responseLbs();
		$time = time();
		$prevSendTime = (int) get_option(LBS_CODE. '_last__time_contact_send');
		if($prevSendTime && ($time - $prevSendTime) < 5 * 60) {	// Only one message per five minutes
			$res->pushError(__('Please don\'t send contact requests so often - wait for response for your previous requests.'));
			$res->ajaxExec();
		}
        $data = reqLbs::get('post');
        $fields = $this->getModule()->getContactFormFields();
		foreach($fields as $fName => $fData) {
			$validate = isset($fData['validate']) ? $fData['validate'] : false;
			$data[ $fName ] = isset($data[ $fName ]) ? trim($data[ $fName ]) : '';
			if($validate) {
				$error = '';
				foreach($validate as $v) {
					if(!empty($error))
						break;
					switch($v) {
						case 'notEmpty':
							if(empty($data[ $fName ])) {
								$error = $fData['html'] == 'selectbox' ? __('Please select %s', LBS_LANG_CODE) : __('Please enter %s', LBS_LANG_CODE);
								$error = sprintf($error, $fData['label']);
							}
							break;
						case 'email':
							if(!is_email($data[ $fName ])) 
								$error = __('Please enter valid email address', LBS_LANG_CODE);
							break;
					}
					if(!empty($error)) {
						$res->pushError($error, $fName);
					}
				}
			}
		}
		if(!$res->error()) {
			$msg = 'Message from: '. get_bloginfo('name').', Host: '. $_SERVER['HTTP_HOST']. '<br />';
			$msg .= 'Plugin: '. LBS_WP_PLUGIN_NAME. '<br />';
			foreach($fields as $fName => $fData) {
				if(in_array($fName, array('name', 'email', 'subject'))) continue;
				if($fName == 'category')
					$data[ $fName ] = $fData['options'][ $data[ $fName ] ];
                $msg .= '<b>'. $fData['label']. '</b>: '. nl2br($data[ $fName ]). '<br />';
            }
			if(frameLbs::_()->getModule('mail')->send('support@supsystic.team.zendesk.com', $data['subject'], $msg, $data['name'], $data['email'])) {
				update_option(LBS_CODE. '_last__time_contact_send', $time);
			} else {
				$res->pushError( frameLbs::_()->getModule('mail')->getMailErrors() );
			}
			
		}
        $res->ajaxExec();
	}
	/**
	 * @see controller::getPermissions();
	 */
	public function getPermissions() {
		return array(
			LBS_USERLEVELS => array(
				LBS_ADMIN => array('welcomePageSaveInfo', 'sendContact')
			),
		);
	}
}