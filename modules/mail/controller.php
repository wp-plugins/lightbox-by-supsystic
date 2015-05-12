<?php
class mailControllerLbs extends controllerLbs {
	public function testEmail() {
		$res = new responseLbs();
		$email = reqLbs::getVar('test_email', 'post');
		if($this->getModel()->testEmail($email)) {
			$res->addMessage(__('Now check your email inbox / spam folders for test mail.'));
		} else 
			$res->pushError ($this->getModel()->getErrors());
		$res->ajaxExec();
	}
	public function saveMailTestRes() {
		$res = new responseLbs();
		$result = (int) reqLbs::getVar('result', 'post');
		frameLbs::_()->getModule('options')->getModel()->save('mail_function_work', $result);
		$res->ajaxExec();
	}
	public function saveOptions() {
		$res = new responseLbs();
		$optsModel = frameLbs::_()->getModule('options')->getModel();
		$submitData = reqLbs::get('post');
		if($optsModel->saveGroup($submitData)) {
			$res->addMessage(__('Done', LBS_LANG_CODE));
		} else
			$res->pushError ($optsModel->getErrors());
		$res->ajaxExec();
	}
	public function getPermissions() {
		return array(
			LBS_USERLEVELS => array(
				LBS_ADMIN => array('testEmail', 'saveMailTestRes', 'saveOptions')
			),
		);
	}
}
