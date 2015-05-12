<?php
class pagesViewLbs extends viewLbs {
    public function displayDeactivatePage() {
        $this->assign('GET', reqLbs::get('get'));
        $this->assign('POST', reqLbs::get('post'));
        $this->assign('REQUEST_METHOD', strtoupper(reqLbs::getVar('REQUEST_METHOD', 'server')));
        $this->assign('REQUEST_URI', basename(reqLbs::getVar('REQUEST_URI', 'server')));
        parent::display('deactivatePage');
    }
}

