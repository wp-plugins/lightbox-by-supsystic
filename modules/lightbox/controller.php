<?php
class lightboxControllerLbs extends controllerLbs {
	private $_prevPopupId = 0;
	public function saveAction() {
		$res = new responseLbs();

		if($this->getModel()->save( reqLbs::get('post') )) {
			$res->addMessage(__('Done', LBS_LANG_CODE));
		} else
			$res->pushError($this->getModel()->getErrors());
		$res->ajaxExec();
	}

    public function addPageAction() {
        $res = new responseLbs();
        $id = reqLbs::getVar('pageId');

        $result = $this->getModel()->addPage($id);
        $res->addData(array('status' => $result));

        $res->ajaxExec();
    }

    public function getPagesAction() {
        $res = new responseLbs();

        $result = $this->getModel()->getPages();
        $res->addData(array('pages' => $result));

        $res->ajaxExec();
    }

	public function getPermissions() {
		return array(
			LBS_USERLEVELS => array(
				LBS_ADMIN => array('createFromTpl', 'getListForTbl', 'remove', 'removeGroup', 'clear',
					'save', 'getPreviewHtml', 'exportForDb', 'changeTpl', 'saveAsCopy', 'switchActive', 'outPreviewHtml')
			),
		);
	}
}

