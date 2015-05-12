<?php
class lightboxModelLbs extends modelLbs {
	private $_showToList = array();
	private $_showPagesList = array();
	private $_showOnList = array();
	private $_types = array();
	public function __construct() {
		$this->_setTbl('lightbox');
	}
	public function abDeactivated() {
		if(frameLbs::_()->licenseDeactivated()) {
			return (bool) dbLbs::exist('@__'. $this->_tbl, 'ab_id');
		}
		return false;
	}
	public function save($d = array()) {
        $result = frameLbs::_()->getTable($this->_tbl)->getAll('id');

        if(empty($result)) {
            $result = frameLbs::_()->getTable($this->_tbl)->insert(array('settings' => json_encode($d['general'])));
        } else {
            $result = frameLbs::_()->getTable($this->_tbl)->update(array('settings' => json_encode($d['general'])), 'id="' . $result[0]['id'] .'"');
        }

        return $result;
	}

    public function getSettings() {
        $result = frameLbs::_()->getTable($this->_tbl)->getAll();

        return $result[0];
    }

    public function addPage($id) {
        $result = frameLbs::_()->getTable($this->_tbl)->getAll();

        if(empty($result)) {
            $result = frameLbs::_()->getTable($this->_tbl)->insert(array('pages' => json_encode($id)));
        } else {
            $pages = $result[0]['pages'];
            if(!$pages) {
                $pages = array($id);
            } else {
                $pages = json_decode($pages);
                if(!in_array($id, $pages)) {
                    array_push($pages, $id);
                } else {
                    return false;
                }
            }
            $result = frameLbs::_()->getTable($this->_tbl)->update(array('pages' => json_encode($pages)), 'id="' . $result[0]['id'] .'"');
        }

        return $result;
    }

    public function getPages() {
        $result = frameLbs::_()->getTable($this->_tbl)->getAll();

        return json_decode($result[0]['pages'], true);
    }
}
