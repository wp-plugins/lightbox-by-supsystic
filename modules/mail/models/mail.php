<?php
class mailModelLbs extends modelLbs {
	public function testEmail($email) {
		$email = trim($email);
		if(!empty($email)) {
			if($this->getModule()->send($email, 
				__('Test email functionslity', LBS_LANG_CODE),
				sprintf(__('This is test email for testing email functionality on your site, %s.', LBS_LANG_CODE), LBS_SITE_URL))
			) {
				return true;
			} else {
				$this->pushError( $this->getModule()->getMailErrors() );
			}
		} else
			$this->pushError (__('Empty email address', LBS_LANG_CODE), 'test_email');
		return false;
	}
}