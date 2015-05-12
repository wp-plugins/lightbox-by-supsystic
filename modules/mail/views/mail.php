<?php
class mailViewLbs extends viewLbs {
	public function getTabContent() {
		frameLbs::_()->getModule('templates')->loadJqueryUi();
		frameLbs::_()->addScript('admin.'. $this->getCode(), $this->getModule()->getModPath(). 'js/admin.'. $this->getCode(). '.js');
		
		$this->assign('options', frameLbs::_()->getModule('options')->getCatOpts( $this->getCode() ));
		$this->assign('testEmail', frameLbs::_()->getModule('options')->get('notify_email'));
		return parent::getContent('mailAdmin');
	}
}
