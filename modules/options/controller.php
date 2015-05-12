<?php
class optionsControllerLbs extends controllerLbs {
	public function saveGroup() {
		$res = new responseLbs();
		if($this->getModel()->saveGroup(reqLbs::get('post'))) {
			$res->addMessage(__('Done', LBS_LANG_CODE));
		} else
			$res->pushError ($this->getModel('options')->getErrors());
		return $res->ajaxExec();
	}
	public function getPermissions() {
		return array(
			LBS_USERLEVELS => array(
				LBS_ADMIN => array('saveGroup')
			),
		);
	}
}

